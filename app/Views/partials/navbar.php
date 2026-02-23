<?php 
    helper('url');
    $uri = service('uri');

    // Definición de variables de ruta para las validaciones
    $pagina_actual = uri_string(); 
    $seg1 = $uri->getSegment(1); 
    $seg2 = ($uri->getTotalSegments() >= 2) ? $uri->getSegment(2) : '';

    // Lógica para que los botones principales se mantengan "active"
    $es_inventario = ($seg1 == 'productos');
    $es_entradas   = ($seg1 == 'entradas');
    $es_salidas    = ($seg1 == 'salidas');
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= base_url('inicio') ?>">📦 Control Papelería</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav ms-auto align-items-center">
                
                <a class="nav-link <?= ($pagina_actual == 'inicio' || $pagina_actual == '') ? 'active fw-bold' : '' ?>" 
                   href="<?= base_url('inicio') ?>">Inicio</a>

                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= $es_inventario ? 'active fw-bold' : '' ?>" 
                       href="#" role="button" data-bs-toggle="dropdown">Inventario</a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="<?= base_url('productos') ?>">Ver Catálogo</a></li>
                        <?php if (session()->get('rol') == 'ADMIN'): ?>
                        <li><a class="dropdown-item" href="<?= base_url('productos/crear') ?>">Nuevo Producto</a></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= $es_entradas ? 'active fw-bold' : '' ?>" 
                       href="#" role="button" data-bs-toggle="dropdown">Entradas</a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="<?= base_url('entradas/crear') ?>">Cargar Stock</a></li>
                        <?php if (session()->get('rol') == 'ADMIN'): ?>
                        <li><a class="dropdown-item" href="<?= base_url('entradas') ?>">Historial de Entradas</a></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= $es_salidas ? 'active fw-bold' : '' ?>" 
                       href="#" role="button" data-bs-toggle="dropdown">Salidas</a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="<?= base_url('salidas/crear') ?>">Entregar Material</a></li>
                        <?php if (session()->get('rol') == 'ADMIN'): ?>
                        <li><a class="dropdown-item" href="<?= base_url('salidas') ?>">Historial de Salidas</a></li>
                        <?php endif; ?>
                        <li><a class="dropdown-item" href="<?= base_url('areas') ?>">Catálogo de Áreas</a></li>
                    </ul>
                </div>

                <!-- <a class="nav-link <?= ($pagina_actual == 'reportes') ? 'active fw-bold' : '' ?>" 
                   href="<?= base_url('reportes') ?>">Reportes</a> -->

                <div class="nav-item dropdown ms-lg-3 border-start ps-lg-3">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userMenu" role="button" data-bs-toggle="dropdown">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                            <i class="bi bi-person-fill text-white"></i>
                        </div>
                        <span><?= session()->get('usuario') ?? 'Admin' ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                        <?php if(session()->get('rol') == 'ADMIN'): ?>
                        <li><a class="dropdown-item" href="<?= base_url('usuarios') ?>"><i class="bi bi-gear me-2"></i>Usuarios</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <?php endif; ?>
                        <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                            <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</nav>