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
             <h2 class="text-dark fw-bold">📦 Detalles de Movimiento
                 </i>Folio de Salida #<?= ($salida->id) ?></h2>
            <p class="text-muted">Área: <strong><?= $salida->nombre_area ?></strong> | Fecha: <?= date('d/m/Y H:i', strtotime($salida->fecha_salida)) ?></p>
        </div>
        <div>
            <a href="<?= base_url('salidas') ?>" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <a href="<?= base_url('salidas/pdf/' . $salida->id) ?>" target="_blank" class="btn btn-danger">
                <i class="bi bi-file-pdf"></i> Imprimir Vale
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Producto</th>
                        <th class="text-center">Cantidad Entregada</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detalles as $row): ?>
                    <tr>
                        <td class="ps-4"><?= $row->producto_nombre ?></td>
                        <td class="text-center">
                            <span class="badge bg-info text-dark px-3"><?= $row->cantidad ?> pzs</span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>



</body>
</html>