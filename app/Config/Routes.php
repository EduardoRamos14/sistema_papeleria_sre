<?php

use CodeIgniter\Router\RouteCollection;
// php spark routes----------------------------Comando para rutas
/**
 * @var RouteCollection $routes
 */
    $routes->group('', ['filter' => 'auth'], function ($routes) {
        $routes->get('/inicio', 'Home::inicio');
       
        // Catálogo de Productos
            $routes->get('productos', 'Productos::index');             // Listado principal TODO:
            $routes->get('productos/crear', 'Productos::crear');         // Formulario nuevo TODO:
            $routes->post('productos/guardar', 'Productos::guardar');     // Acción insertar
            $routes->get('editar/(:num)', 'Productos::editar/$1'); // Formulario editar
            $routes->post('actualizar', 'Productos::actualizar'); // Acción actualizar
        
        // Proceso de Salidas (Entregas a áreas)
            $routes->get('salidas', 'Salidas::index');               // Historial de entregas
            $routes->get('salidas/crear', 'Salidas::crear');           // Formulario nueva entrega
            $routes->post('salidas/guardar', 'Salidas::guardar');       // Acción procesar salida múltiple
            $routes->get('salidas/detalle/(:num)', 'Salidas::detalle/$1');
            $routes->get('salidas/pdf/(:num)', 'Salidas::generarPDF/$1');

        // Proceso de Entradas (Lo que te da tu jefe)
            $routes->get('entradas', 'Entradas::index');              // Historial de entradas   TODO:
            $routes->get('entradas/crear', 'Entradas::crear');          // Formulario carga de stock   TODO:
            $routes->post('entradas/guardar', 'Entradas::guardar');      // Acción procesar entrada múltiple
            $routes->get('entradas/detalles/(:num)', 'Entradas::detalles/$1');      // detalles de una entrada específica
            $routes->get('entradas/pdf/(:num)', 'Entradas::generarPDF/$1');


        // Áreas de la Empresa
            $routes->get('areas', 'Areas::index');              // Listado principal
            $routes->post('areas/guardar', 'Areas::guardar');    // Crear y Editar (mismo método)
            $routes->get('areas/eliminar/(:num)', 'Areas::eliminar/$1'); // Eliminar por ID

        // usuarios
            $routes->get('/usuarios', 'UserController::users');
            $routes->post('/usuario/new', 'UserController::create');
            $routes->post('/usuario/update', 'UserController::update');
            $routes->post('/usuario/updatePassword', 'UserController::updatePassword');
        
        //destruir session
            $routes->get('/logout', 'Home::logout');
        });
        
        $routes->get('/', 'Home::index');
        $routes->post('login', 'Home::login');

