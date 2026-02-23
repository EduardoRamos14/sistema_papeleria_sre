<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.bootstrap5.css"/>
    <link rel="shortcut icon" href="<?= base_url() ?>public/assets/img/icon.ico" type="image/x-icon">

    <title>Detalles de Entrada #<?= $entrada->id ?></title>
</head>
<body>
    <?= view("partials/navbar"); ?>

    <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-dark fw-bold">📦 Detalles de Movimiento</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('inicio') ?>">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('entradas') ?>">Historial</a></li>
                    <li class="breadcrumb-item active">Folio #<?= $entrada->id ?></li>
                </ol>
            </nav>
        </div>
        <div>
            
            <a href="<?= base_url('entradas') ?>" class="btn btn-outline-dark">
                <i class="fas fa-arrow-left"></i> Volver al Historial
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-dark text-white fw-bold">
                    Resumen de Operación
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Fecha de Carga:</strong>
                            <span class="text-muted"><?= date('d/m/Y H:i', strtotime($entrada->fecha_registro)) ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Folio Sistema:</strong>
                            <span class="badge bg-primary rounded-pill">#<?= $entrada->id ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Estado:</strong>
                            <span class="badge bg-success">Aplicado al Stock</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="ps-4">Descripción del Producto</th>
                                    <th class="text-center">Cantidad Recibida</th>
                                    <th class="text-end pe-4">Unidad de Medida</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($detalles as $item): ?>
                                <tr class="align-middle">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-light rounded text-center me-3" style="width: 40px; height: 40px; line-height: 40px;">
                                                📝
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold"><?= $item->producto_nombre ?></h6>
                                                <small class="text-muted">ID: <?= $item->producto_id ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info text-dark fs-6">+ <?= $item->cantidad ?></span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <span class="text-muted"><?= $item->unida_medida ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white text-end py-3">
                    <h5 class="mb-0 text-muted">Total de Artículos: <span class="text-dark fw-bold"><?= count($detalles) ?></span></h5>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>





</body>
</html>