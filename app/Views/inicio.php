<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="<?= base_url() ?>public/assets/img/icon.ico" type="image/x-icon">

</head>
<body class="bg-light">

    <?=view ("partials/navbar"); ?><!--NavBar-->
<div class="container">
 <p>Hora actual del sistema es: 
    <span id="reloj-servidor" data-hora="<?= date('Y-m-d H:i:s') ?>">
        <?= date('H:i:s') ?>
    </span>
</p>
    <h2 class="mb-4 text-secondary">Bienvenido al Control de Existencias</h2>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary h-100 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-uppercase">Productos en Catálogo</h6>
                    <h2 class="display-4 fw-bold"><?= $total_productos ?></h2>
                    <i class="bi bi-box-seam position-absolute end-0 bottom-0 m-3 opacity-25" style="font-size: 3rem;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger h-100 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-uppercase">Alertas de Stock Bajo</h6>
                    <h2 class="display-4 fw-bold"><?= count($stock_bajo) ?></h2>
                    <i class="bi bi-exclamation-triangle position-absolute end-0 bottom-0 m-3 opacity-25" style="font-size: 3rem;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success h-100 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-uppercase">Salidas Realizadas</h6>
                    <h2 class="display-4 fw-bold"><?= $total_salidas ?></h2>
                    <i class="bi bi-arrow-up-right-circle position-absolute end-0 bottom-0 m-3 opacity-25" style="font-size: 3rem;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-danger"><i class="bi bi-bell-fill me-2"></i>Materiales por Agotarse</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Material</th>
                                <th>Existencia</th>
                                <th>Mínimo</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($stock_bajo as $item): ?>
                            <tr>
                                <td><?= $item->nombre ?></td>
                                <td class="text-danger fw-bold"><?= $item->stock_actual ?></td>
                                <td><?= $item->stock_minimo ?></td>
                                <td><a href="<?= base_url('entradas/crear') ?>" class="btn btn-sm btn-outline-primary">Entrada</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary"><i class="bi bi-clock-history me-2"></i>Movimientos Recientes</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php if(!empty($ultimas_salidas)): ?>
                            <?php foreach($ultimas_salidas as $salida): ?>
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <h6 class="mb-1 fw-bold"><?= $salida->nombre_area ?></h6>
                                    <small class="text-muted"><?= date('d/m/Y', strtotime($salida->fecha_salida)) ?></small>
                                </div>
                                <p class="mb-1 text-secondary" style="font-size: 0.9rem;">
                                    Folio de salida: #<?= $salida->id ?>
                                </p>
                                <small class="text-primary">
                                    <a href="<?= base_url('salidas/detalle/' . $salida->id) ?>" class="text-decoration-none">
                                        <i class="bi bi-search me-1"></i>Ver desglose
                                    </a>
                                </small>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="bi bi-inbox text-muted" style="font-size: 2rem;"></i>
                                <p class="text-muted mt-2">No hay salidas registradas hoy.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if(session()->get('rol') == 'ADMIN'): ?>
                <div class="card-footer bg-light text-center border-0">
                    <a href="<?= base_url('salidas') ?>" class="btn btn-sm btn-outline-primary w-100">
                        Ir al historial completo
                    </a>
                </div>
                <?php endif; ?>
            </div>
            
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>

<script>
   <?php if (session()->getFlashdata('abrir_pdf')): ?>
    $(document).ready(function() {
        const id = "<?= session()->getFlashdata('abrir_pdf') ?>";
        // Detectamos el tipo (si no se envía, por defecto será 'salidas')
        const tipo = "<?= session()->getFlashdata('tipo_pdf') ?? 'salidas' ?>";
        
        // Creamos una sola URL dinámica
        const urlFinal = "<?= base_url() ?>" + tipo + "/pdf/" + id;
        
        console.log("Abriendo PDF de " + tipo + " con ID: " + id);

        const win = window.open(urlFinal, '_blank');
        
        if (win) {
            win.focus();
        } else {
            alert('El navegador bloqueó la apertura del vale. Por favor, permite las ventanas emergentes en este sitio.');
        }
    });
<?php endif; ?>
</script>

<script>
    // 1. Obtenemos la hora inicial que mandó el servidor
    const spanReloj = document.getElementById('reloj-servidor');
    let fechaServidor = new Date(spanReloj.getAttribute('data-hora'));

    function ticTac() {
        // 2. Sumamos un segundo a nuestra variable de fecha
        fechaServidor.setSeconds(fechaServidor.getSeconds() + 1);

        // 3. Formateamos la hora para mostrarla (HH:mm:ss)
        const h = String(fechaServidor.getHours()).padStart(2, '0');
        const m = String(fechaServidor.getMinutes()).padStart(2, '0');
        const s = String(fechaServidor.getSeconds()).padStart(2, '0');

        spanReloj.textContent = `${h}:${m}:${s}`;
    }

    // 4. Ejecutar cada segundo
    setInterval(ticTac, 1000);
</script>
</body>
</html>