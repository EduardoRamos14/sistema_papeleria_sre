<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.bootstrap5.css"/>
    <link rel="shortcut icon" href="<?= base_url() ?>public/assets/img/icon.ico" type="image/x-icon">

    <title>Detalles de Salida #<?= $salida->id ?></title>
</head>
<body>
    <?= view("partials/navbar"); ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-dark fw-bold">📦 Detalle de Salida de Almacén</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('inicio') ?>">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('salidas') ?>">Historial de Salidas</a></li>
                    <li class="breadcrumb-item active">Folio #<?= $salida->id ?></li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="<?= base_url('salidas') ?>" class="btn btn-outline-dark me-2">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="<?= base_url('salidas/pdf/' . $salida->id) ?>" target="_blank" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Imprimir Vale
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-danger text-white fw-bold">
                    <i class="fas fa-info-circle me-2"></i> Datos del Movimiento
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <small class="text-muted d-block">Fecha y Hora:</small>
                            <strong><?= date('d/m/Y H:i', strtotime($salida->fecha_salida)) ?></strong>
                        </li>
                        <li class="list-group-item">
                            <small class="text-muted d-block">Área de Destino:</small>
                            <span class="text-primary fw-bold"><?= $salida->nombre_area ?></span>
                        </li>
                        <li class="list-group-item">
                            <small class="text-muted d-block">Solicitante:</small>
                            <strong><?= $salida->solicitante_nombre ?? 'N/A' ?></strong>
                        </li>
                        <li class="list-group-item">
                            <small class="text-muted d-block">Estado:</small>
                            <span class="badge bg-warning text-dark">Inventario Descontado</span>
                        </li>
                        <li class="list-group-item">
                            <small class="text-muted d-block">Notas:</small>
                            <span class="small text-muted"><?= $salida->notas ?: 'Sin observaciones.' ?></span>
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
                                    <th class="text-center">Cantidad Entregada</th>
                                    <th class="text-end pe-4">U. Medida</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($detalles as $item): ?>
                                <tr class="align-middle">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-light rounded text-center me-3" style="width: 40px; height: 40px; line-height: 40px; font-size: 1.2rem;">
                                                📦
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold"><?= $item->producto_nombre ?></h6>
                                                <small class="text-muted">ID: <?= $item->producto_id ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-danger text-white fs-6">- <?= $item->cantidad ?></span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <span class="text-muted"><?= $item->unidad_medida ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white text-end py-3">
                    <h5 class="mb-0 text-muted">Total de Conceptos: <span class="text-dark fw-bold"><?= count($detalles) ?></span></h5>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>



</body>
</html>