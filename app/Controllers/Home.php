<?php namespace App\Controllers;
use \App\Models\UserModel;
use App\Models\ProductoModel;
use App\Models\SalidaModel;
use App\Models\EntradaModel;


class Home extends BaseController{
    
    public function index(): string{
        return view('login');
    }

    public function login(){
        $validation = \Config\Services::validation();
        
        $rules = [
            'usuario' => 'required|min_length[2]|max_length[30]',
            'password' => 'required|min_length[3]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/')->withInput()->with('message_danger', $validation->listErrors());
        }

        $usuario = $this->request->getPost('usuario');
        $password = $this->request->getPost('password');

        $UsuarioModel = new UserModel();
        $datosUsuario = $UsuarioModel->obtenerUsuario(['usuario' => $usuario]);

        if (!empty($datosUsuario) && password_verify($password, $datosUsuario[0]['password'])) {
            session()->set([
                "id_usuario" => $datosUsuario[0]['id_usuario'],
                "usuario" => $datosUsuario[0]['usuario'],
                "rol" => $datosUsuario[0]['rol'],
                "nombre" => $datosUsuario[0]['nombre'],
            ]);

            return redirect()->to('/inicio')->with('message', 'Bienvenid@ ' . $datosUsuario[0]['nombre']);
        } else {
            return redirect()->to('/')->with('message_danger', 'Usuario y/o contraseña incorrectos');
        }
    }   
    
    public function logout() {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }

    public function inicio(){
        
        $session = session();
        $idUsuario = $session->get('id_usuario');
        $usuario = $session->get('nombre');
        $rol = $session->get('rol');

        $productoModel = new ProductoModel();
        $salidaModel   = new SalidaModel();
        $entradaModel  = new EntradaModel();

        $data = [
            'titulo'           => 'Panel de Control - Papelería', 
            'total_productos'  => $productoModel->countAllResults(),// Total de productos en catálogo
            'stock_bajo'       => $productoModel->where('stock_actual <= stock_minimo')->findAll(), // Productos con stock por debajo del mínimo
            'total_salidas'    => $salidaModel->countAllResults(), // Conteo de movimientos recientes
            'ultimas_salidas'  => $salidaModel->select('salidas.*, areas.nombre_area')
                                              ->join('areas', 'areas.id = salidas.area_id')
                                              ->orderBy('fecha_salida', 'DESC')
                                              ->findAll(5) // Solo las últimas 5
                                              
        ];

        return view('inicio', $data);
    }

}
