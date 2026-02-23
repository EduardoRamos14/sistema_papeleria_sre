<?php

namespace App\Controllers;

use App\Models\AreaModel; // Asegúrate de tener este modelo creado

class Areas extends BaseController
{
    protected $areasModel;

    public function __construct()
    {
        $this->areasModel = new AreaModel();
    }

    public function index()
    {
        $data = [
            'titulo' => 'Catálogo de Áreas',
            'areas'  => $this->areasModel->findAll(),
        ];

        return view('areas/index', $data);
    }

    public function guardar()
    {
        // Recibimos los datos del formulario
        $id = $this->request->getPost('id');
        $data = [
            'nombre_area' => $this->request->getPost('nombre_area'),
        ];

        if ($id) {
            // Si hay ID, es una actualización (Editar)
            $this->areasModel->update($id, $data);
            $mensaje = 'Área actualizada correctamente.';
        } else {
            // Si no hay ID, es un registro nuevo (Crear)
            $this->areasModel->insert($data);
            $mensaje = 'Nueva área registrada con éxito.';
        }

        return redirect()->to(base_url('areas'))->with('mensaje', $mensaje);
    }

    public function eliminar($id = null)
    {
        if ($id) {
            $this->areasModel->delete($id);
        }
        return redirect()->to(base_url('areas'))->with('mensaje', 'Área eliminada.');
    }
}