<?php

namespace App\Controllers;

use App\Models\ProductoModel;
use CodeIgniter\Controller;

class Productos extends Controller{
    
    public function index(){
        $model = new ProductoModel();
        
        $data['productos'] = $model->findAll();
        $data['titulo']    = "Catálogo de Papelería";

        return view('productos/index', $data);
    }

    public function crear(){
        if (session()->get('rol') != 'ADMIN') {
            return redirect()->to(base_url('productos'))->with('message_danger', 'No tienes permiso para crear productos');
        }
        return view('productos/crear', ['titulo' => 'Nuevo Material']);
    }

    public function guardar(){
        $model = new ProductoModel();

        $data = [
            'nombre'        => $this->request->getPost('nombre'),
            'descripcion'   => $this->request->getPost('descripcion'),
            'clasificador'  => $this->request->getPost('clasificador'),
            'stock_minimo'  => $this->request->getPost('stock_minimo'),
            'unidad_medida' => $this->request->getPost('unidad_medida'),
        ];

        if ($model->insert($data)) {
            return redirect()->to(base_url('productos'))->with('mensaje', 'Producto creado con éxito');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al guardar');
        }
    }

    
    public function editar($id) {
        $model = new \App\Models\ProductoModel();
        $data['producto'] = $model->find($id);
        
        if (!$data['producto']) {
            return redirect()->to(base_url('productos'))->with('error', 'Producto no encontrado.');
        }

        return view('productos/editar', $data);
    }

    public function actualizar($id){
        $model = new \App\Models\ProductoModel();

        // 1. Validamos que el producto exista
        if (!$model->find($id)) {
            return redirect()->to(base_url('productos'))->with('error', 'Producto no encontrado.');
        }

        // 2. Recolectamos los datos
        $data = [
            'activo'        => $this->request->getPost('activo'),
            'nombre'        => $this->request->getPost('nombre'),
            'descripcion'   => $this->request->getPost('descripcion'),
            'clasificador'  => $this->request->getPost('clasificador'),
            'stock_minimo'  => $this->request->getPost('stock_minimo'),
        ];
            // No actualizamos el stock aquí para no romper la lógica de inventario


        // 3. Guardamos
        if ($model->update($id, $data)) {
            return redirect()->to(base_url('productos'))->with('mensaje', 'Producto actualizado con éxito.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Ocurrió un error al actualizar.');
        }
    }

    public function eliminar($id){
        $model = new \App\Models\ProductoModel();

        // Verificamos si existe
        $producto = $model->find($id);
        if (!$producto) {
            return redirect()->to(base_url('productos'))->with('error', 'Producto no encontrado.');
        }

        // Cambio de estatus: de 1 (activo) a 0 (inactivo)
        $data = ['activo' => 0];

        if ($model->update($id, $data)) {
            return redirect()->to(base_url('productos'))->with('mensaje', 'Producto desactivado del catálogo.');
        } else {
            return redirect()->to(base_url('productos'))->with('error', 'No se pudo procesar la acción.');
        }
    }

    
}