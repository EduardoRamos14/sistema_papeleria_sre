<?php namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController{

    public function users(){ 
        if (session()->get('rol') !== 'ADMIN') {
            return redirect()->to('/');
        }

        $userModel = new UserModel();
        // $data['usuarios'] = $userModel->findAll();
        $data['usuarios'] = $userModel
        ->select('id_usuario, nombre, usuario, email, rol, estatus')
        ->findAll();


        return view('usuarios/usuarios', $data);
    }

    public function create() {
        $userModel = new UserModel();
        
        // Verificación de seguridad
        if (session()->get('rol') !== 'ADMIN') {
            return redirect()->to('/');
        }

        // Obtener datos del POST
        $nombre   = $this->request->getPost('new-nombre');
        $usuario = str_replace(' ', '', strtoupper($this->request->getPost('new-usuario')));
        // $usuario  = $this->request->getPost('usuario');
        $correo   = $this->request->getPost('new-email');
        $password = $this->request->getPost('mew-password');
        $rol      = $this->request->getPost('new-rol');

        // ===========================================
        // 1. VALIDACIONES (Sin $id_usuario porque es nuevo)
        // ===========================================
        
        $existeCorreo = $userModel->where('email', $correo)->first();
        $existeUsuario = $userModel->where('usuario', $usuario)->first();
        //TODO: Validar 
        if ($existeCorreo) {
            return redirect()->back()
                    ->with('open_new_modal', true)
                    ->with('message_warning', 'Ese correo ya está registrado.')
                    ->with('old_user', compact(
                        'nombre','usuario','email','rol'
                    ));
        }

        if ($existeUsuario) {
            return redirect()->back()
                ->with('open_new_modal', true)
                ->with('message_warning', 'Ese nombre de usuario ya existe.')
                ->with('old_user', compact(
                        'nombre','usuario','correo','rol'
                    ));
        }
        

        // ===========================================
        // 2. INSERCIÓN
        // ===========================================
        $userModel->insert([
            'nombre'   => $nombre,
            'usuario'  => $usuario,
            'email'    => $correo,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'rol'      => $rol
        ]);

        return redirect()->back()->with('message_success', 'Usuario creado exitosamente.');
    }

    public function update(){
        $session = session();
        $userModel = new UserModel();

        $id_usuario     = $this->request->getPost('id_user');
        $nombre = $this->request->getPost('nombre');
        $usuario = $this->request->getPost('usuario');
        $correo = $this->request->getPost('correo');
        $rol    = $this->request->getPost('rol');

        // ===============================
        // 1. VALIDAR QUE NO EXISTA EL CORREO
        // ===============================
        
            $existeCorreo = $userModel
                ->where('email', $correo)
                ->where('id_usuario !=', $id_usuario)
                ->first();

            // Validar usuario
            $existeUsuario = $userModel
                ->where('usuario', $usuario)
                ->where('id_usuario !=', $id_usuario)
                ->first();

            if ($existeCorreo) {
                return redirect()->back()
                    ->with('open_edit_modal', true)
                    ->with('message_warning', 'Ese correo ya está registrado.')
                    ->with('old_user', compact(
                        'id_usuario','nombre','usuario','correo','rol'
                    ));
            }

            if ($existeUsuario) {
                return redirect()->back()
                    ->with('open_edit_modal', true)
                    ->with('message_warning', 'Ese nombre de usuario ya existe.')
                    ->with('old_user', compact(
                        'id_usuario','nombre','usuario','correo','rol'
                    ));
            }


        // ===============================
        // 2. ACTUALIZAR USUARIO
        // ===============================
        $userModel->update($id_usuario, [
            'nombre' => $nombre,
            'usuario' => $usuario,
            'email'  => $correo,
            'rol'    => $rol,
        ]);

        return redirect()->back()
            ->with('message_success', 'Usuario actualizado correctamente.');
    }

    public function updatePassword(){
        $session = session();

        if ($session->get('rol') !== 'ADMIN') {
            return redirect()->back()->with('message_warning', 'No autorizado');
        }

        $id_usuario = $this->request->getPost('id_user');
        $pass       = $this->request->getPost('password');
        $confirm    = $this->request->getPost('password_confirm');
        $nombre     = $this->request->getPost('pass-nombre');

        if (!$pass || !$confirm) {
            return redirect()->back()
                ->with('message_warning', 'Debes ingresar ambas contraseñas')
                ->with('open_pass_modal', true)
                ->with('old_user', [
                       'id_user' => $id_usuario,
                        'nombre'  => $nombre,
                ]);
        }

        if ($pass !== $confirm) {
            return redirect()->back()
                ->with('message_warning', 'Las contraseñas no coinciden')
                ->with('open_pass_modal', true)
                ->with('old_user', [
                    'id_user' => $id_usuario,
                    'nombre'  => $nombre,
                ]);
        }

        if (strlen($pass) < 6) {
           return redirect()->back()
                ->with('message_warning', 'Las contraseñas debe tener mínimo 6 caracteres')
                ->with('open_pass_modal', true)
                ->with('old_user', [
                   'id_user' => $id_usuario,
                    'nombre'  => $nombre,
                ]);
        }

        $userModel = new UserModel();

        $userModel->update($id_usuario, [
            'password' => password_hash($pass, PASSWORD_DEFAULT)
        ]);

        return redirect()->back()
            ->with('message', 'Contraseña actualizada correctamente');
    }



   

    // public function update_estatus(){
    //     $userModel = new UserModel();
        
    //     // 1. Obtener los datos de la petición AJAX
    //     $id = $this->request->getPost('id_user');
    //     $status = $this->request->getPost('estatus');
        
    //     // 3. Preparar los datos para la actualización
    //     $data = [
    //         'estatus' => $status
    //     ];

    //     // 4. Actualizar el registro en la base de datos
    //     $userModel->update($id, $data);
    //     $newStatus = $this->request->getPost('estatus');
        
    //     // 5. Devolver una respuesta JSON para el frontend
    //     return $this->response->setJSON([
    //         'status' => 'success',
    //         'message' => 'Estado actualizado exitosamente.',
    //         'new_status' => $status,
    //     ]);
    // }
}
