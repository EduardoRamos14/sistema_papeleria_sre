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

    /**
     * Formulario para editar (opcional pero recomendado)
     */
    public function editar($id = null)
    {
        $model = new ProductoModel();
        $producto = $model->find($id);

        if (!$producto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('productos/editar', [
            'titulo'   => 'Editar Producto',
            'producto' => $producto // Aquí 'producto' ya es un objeto
        ]);
    }

    /**
     * Actualiza los datos
     */
    public function actualizar()
    {
        $model = new ProductoModel();
        $id = $this->request->getPost('id');

        $data = [
            'nombre'        => $this->request->getPost('nombre'),
            'descripcion'   => $this->request->getPost('descripcion'),
            'clasificador'  => $this->request->getPost('clasificador'),
            'stock_minimo'  => $this->request->getPost('stock_minimo'),
        ];

        $model->update($id, $data);
        return redirect()->to(base_url('productos'))->with('mensaje', 'Actualizado correctamente');
    }
}