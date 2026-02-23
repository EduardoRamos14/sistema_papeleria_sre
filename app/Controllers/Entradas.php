<?php

namespace App\Controllers;

use App\Models\EntradaModel;
use App\Models\EntradaDetalleModel;
use App\Models\ProductoModel;
use CodeIgniter\Controller;

class Entradas extends Controller
{
    public function index(){
        $entradaModel = new EntradaModel();
        $data['entradas'] = $entradaModel->orderBy('fecha_registro', 'DESC')->findAll();
        $data['titulo']   = "Historial de Entradas";

        if (session()->get('rol') != 'ADMIN') {
            return redirect()->to(base_url('inicio'))->with('message_danger', 'No tienes permiso para Ver Historial de Entradas');
        }
        return view('entradas/index', $data);
    }

    public function crear(){
        $productoModel = new ProductoModel();
        
        $data['productos'] = $productoModel->findAll(); 
        $data['titulo']    = "Cargar Stock Recibido";

        return view('entradas/crear', $data);
    }

    public function guardar(){
        $db = \Config\Database::connect();
        $entradaModel = new EntradaModel();
        $detalleModel = new EntradaDetalleModel();

        // Datos de cabecera
        $idUsuarioActivo = session()->get('id_usuario');
        $usuario_recibe = session()->get('nombre');
        $observaciones = $this->request->getPost('observaciones');

        // Arreglos del formulario
        $productosIds = $this->request->getPost('producto_id');
        $cantidades   = $this->request->getPost('cantidad');

        if (empty($productosIds)) {
            return redirect()->back()->with('error', 'Seleccione al menos un producto.');
        }

        $db->transStart();
        
        // 1. Cabecera
        $idEntrada = $entradaModel->insert([
            'id_usuario'     => $idUsuarioActivo,
            'usuario_recibe' => $usuario_recibe,
            'observaciones'  => $observaciones
            ]);
            
            // 2. Detalles (El Trigger de SQL sumará al stock automáticamente)
            foreach ($productosIds as $index => $idProd) {
                $detalleModel->insert([
                    'entrada_id'  => $idEntrada,
                    'producto_id' => $idProd,
                    'cantidad'    => $cantidades[$index]
                    ]);
                    }
                    
        $id_nueva_entrada = $entradaModel->insertID(); 
        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Error crítico al cargar el stock.');
        }

        if (session()->get('rol') !== 'ADMIN') {
            return redirect()->to(base_url('inicio'))
                ->with('mensaje', 'Entrada registrada exitosamente.')
                ->with('abrir_pdf', $id_nueva_entrada)
                ->with('tipo_pdf', 'entradas'); // <--- Esto le dirá al script qué ruta usar
        } else {
            return redirect()->to(base_url('entradas'))
                ->with('mensaje', 'Entrada registrada exitosamente.')
                ->with('abrir_pdf', $id_nueva_entrada)
                ->with('tipo_pdf', 'entradas');
        }
    }
    

    public function detalles($id){
        $db = \Config\Database::connect();
        
        // 1. Obtener datos generales de la entrada
        $builder = $db->table('entradas');
        $entrada = $builder->where('id', $id)->get()->getRow();

        if (!$entrada) {
            return redirect()->to(base_url('entradas'))->with('error', 'Entrada no encontrada');
        }

        // 2. Obtener los productos vinculados a esa entrada
        $detalles = $db->table('entradas_detalle as ed')
                    ->select('ed.*, p.nombre as producto_nombre, e.fecha_registro as fecha_entrada')
                    ->join('productos as p', 'p.id = ed.producto_id')
                    ->join('entradas as e', 'e.id = ed.entrada_id')
                    ->where('ed.entrada_id', $id)
                    ->get()
                    ->getResult();

        $data = [
            'titulo'   => 'Detalles de la Entrada #' . $id,
            'entrada'  => $entrada,
            'detalles' => $detalles,
        ];

        return view('entradas/detalles', $data);
    }

    public function generarPDF($id) {
    $entradaModel = new EntradaModel();
    $detalleModel = new EntradaDetalleModel();

    // 1. Consultar datos (Con JOIN para traer al responsable)
    $entrada = $entradaModel
            ->select('entradas.*, usuarios.nombre as nombre_usuario')
            ->join('usuarios', 'usuarios.id_usuario = entradas.id_usuario') 
            ->find($id);

    if (!$entrada) {
        return redirect()->back()->with('mensaje', 'Entrada no encontrada');
    }

    $detalles = $detalleModel->select('entradas_detalle.*, productos.nombre as producto_nombre')
                            ->join('productos', 'productos.id = entradas_detalle.producto_id')
                            ->where('entrada_id', $id)
                            ->findAll();

    // 2. Preparar los datos
    $data = [
        'entrada'  => $entrada,
        'detalles' => $detalles        
    ];

    // 3. Cargar el HTML
    $html = view('entradas/comprobante_pdf', $data);

    // 4. Configurar Dompdf (Forma correcta y limpia)
    $options = new \Dompdf\Options();
    $options->set('isRemoteEnabled', true); // Necesario para logos
    $options->set('defaultFont', 'Helvetica');
    
    $dompdf = new \Dompdf\Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // 5. LIMPIEZA TOTAL (Vital para Hostinger)
    if (ob_get_length()) {
        ob_end_clean();
    }

    // 6. ENCABEZADOS Y SALIDA
    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename='Comprobante_Entrada_{$id}.pdf'");
    header("Cache-Control: private, max-age=0, must-revalidate");
    header("Pragma: public");

    echo $dompdf->output();
    exit; 
}
}