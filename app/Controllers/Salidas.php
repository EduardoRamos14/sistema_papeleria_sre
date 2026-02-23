<?php

namespace App\Controllers;

use App\Models\SalidaModel;
use App\Models\SalidaDetalleModel;
use App\Models\ProductoModel;
use App\Models\AreaModel;
use CodeIgniter\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;



class Salidas extends Controller{

    public function index(){
        $salidaModel = new SalidaModel();

        $data['salidas'] = $salidaModel
            ->select('salidas.*, areas.nombre_area, usuarios.nombre as nombre_usuario')
            ->join('areas', 'areas.id = salidas.area_id')
            ->join('usuarios', 'usuarios.id_usuario = salidas.id_usuario') 
            ->orderBy('fecha_salida', 'DESC')
            ->findAll();
        
        if (session()->get('rol') != 'ADMIN') {
            return redirect()->to(base_url('inicio'))->with('message_danger', 'No tienes permiso para Ver Historial de Salidas');
        }
        
        return view('salidas/index', $data);
    }

    public function crear(){
        $productoModel = new ProductoModel();
        $areaModel     = new AreaModel();

        $data['productos'] = $productoModel->where('stock_actual >', 0)
                                            ->where('activo',1)->findAll();
        $data['areas']     = $areaModel->findAll();
        $data['titulo']    = "Registrar Entrega de Material";

        return view('salidas/crear', $data);
    }

    public function guardar(){
        $db = \Config\Database::connect();
        $salidaModel = new SalidaModel();
        $detalleModel = new SalidaDetalleModel();

        $idUsuarioActivo = session()->get('id_usuario');
        $area_id = $this->request->getPost('area_id');
        $solicitante = $this->request->getPost('solicitante_nombre');
        $notas = $this->request->getPost('notas');

        // Arreglos de productos y cantidades (vienen del formulario dinámico)
        $productosIds = $this->request->getPost('producto_id'); 
        $cantidades   = $this->request->getPost('cantidad');

        if (empty($productosIds)) {
            return redirect()->back()->with('error', 'Debes agregar al menos un producto.');
        }

        $db->transStart();

        // 1. Insertar Cabecera
        $idSalida = $salidaModel->insert([
            'area_id'            => $area_id,
            'id_usuario'   => $idUsuarioActivo,
            'solicitante_nombre' => $solicitante,
            'notas'              => $notas
        ]);

        // 2. Insertar Detalles
        foreach ($productosIds as $index => $idProd) {
            $detalleModel->insert([
                'salida_id'   => $idSalida,
                'producto_id' => $idProd,
                'cantidad'    => $cantidades[$index]
            ]);
           //El Trigger 'tr_actualizar_stock_salida' resta el stock automáticamente aquí.
        }
        
        //$id_nueva_salida = $salidaModel->insertID(); 
        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Error al procesar la salida. Verifique existencias.');
        }

        if (session()->get('rol') !== 'ADMIN') {
            return redirect()->to(base_url('inicio'))
                ->with('mensaje', 'Entrega de material registrada.') // Mensaje de éxito
                ->with('abrir_pdf', $idSalida);
        } else {
            return redirect()->to(base_url('salidas'))
                ->with('mensaje', 'Salida registrada exitosamente.')
                ->with('abrir_pdf', $idSalida);
        }
    }

    public function detalle($id){
        $salidaModel = new \App\Models\SalidaModel();
        $detalleModel = new \App\Models\SalidaDetalleModel();

        // Consultamos la salida uniendo con la tabla de áreas
        $salida = $salidaModel->select('salidas.*, areas.nombre_area')
                            ->join('areas', 'areas.id = salidas.area_id')
                            ->find($id);

        if (!$salida) {
            return redirect()->to(base_url('salidas'))->with('mensaje', 'Salida no encontrada');
        }

        // Consultamos los productos de esa salida
        $detalles = $detalleModel->select('salidas_detalle.*, productos.nombre as producto_nombre')
                                ->join('productos', 'productos.id = salidas_detalle.producto_id')
                                ->where('salida_id', $id)
                                ->findAll();

        $data = [
            'titulo'   => 'Detalle de Salida #' . $id,
            'salida'   => $salida,
            'detalles' => $detalles
        ];

        return view('salidas/detalle', $data);
    }

    public function generarPDF($id) {
        $salidaModel = new SalidaModel();
        $detalleModel = new SalidaDetalleModel();

        // 1. Consultar datos (SIEMPRE PRIMERO)
        $salida = $salidaModel
                ->select('salidas.*, areas.nombre_area, usuarios.nombre as nombre_usuario')
                ->join('areas', 'areas.id = salidas.area_id')
                ->join('usuarios', 'usuarios.id_usuario = salidas.id_usuario') 
                ->find($id);

        $detalles = $detalleModel->select('salidas_detalle.*, productos.nombre as producto_nombre')
                                ->join('productos', 'productos.id = salidas_detalle.producto_id')
                                ->where('salida_id', $id)
                                ->findAll();

        if (!$salida) {
            return redirect()->back()->with('mensaje', 'Salida no encontrada');
        }

        // 2. Preparar los datos para la vista
        $data = [
            'salida'   => $salida,
            'detalles' => $detalles
        ];

        // 3. Cargar el HTML de la vista
        $html = view('salidas/comprobante_pdf', $data);

        // 4. Configurar Dompdf
        $dompdf = new \Dompdf\Dompdf();
        $options = new \Dompdf\Options();
        $dompdf = new \Dompdf\Dompdf($options);
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();


        // 5. LIMPIEZA TOTAL (Para evitar símbolos raros en Hostinger)
        if (ob_get_length()) {
            ob_end_clean();
        }

        // 6. ENCABEZADOS Y SALIDA
        header("Content-Type: application/pdf");
        header("Content-Disposition: inline; filename='Comprobante_Salida_{$id}.pdf'");
        header("Cache-Control: private, max-age=0, must-revalidate");
        header("Pragma: public");

        echo $dompdf->output();
        exit; // Terminamos aquí para que nada más ensucie el PDF
    }
}

