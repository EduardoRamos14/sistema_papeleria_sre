<?php 
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null) {
        $session = session();
        if (!$session->has('usuario')) { // Verifica si el usuario está autenticado
            return redirect()->to('/')->with('message_danger', 'Acceso denegado');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        // Puedes dejarlo vacío si no necesitas modificar la respuesta
    }
}
