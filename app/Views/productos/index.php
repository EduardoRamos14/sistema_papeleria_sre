<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.bootstrap5.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.6/css/buttons.bootstrap5.css"/>
    <link rel="shortcut icon" href="<?= base_url() ?>public/assets/img/icon.ico" type="image/x-icon">

</head>
<body>
    <?=view ("partials/navbar"); ?><!--NavBar-->
    <?=view ("partials/session"); ?><!--NavBar-->

<div class="container-fluid mt-4">
    <div class="card shadow p-4">
        <h2 class="mb-4 text-center fw-bold">Productos</h2>
        <div class="container-fluid mt-4">
    <div class="card shadow p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Existencias de Papelería</h2>
            <?php if (session()->get('rol') == 'ADMIN'): ?>
            <a href="<?= base_url('productos/crear') ?>" class="btn btn-dark">
                <i class="fa-solid fa-plus-circle me-1"></i> Nuevo Producto
            </a>
            <?php endif; ?>
        </div>
        
        <table class="table table-striped table-hover border" id="inventarioTable">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Clasificador</th>
                    <th>Stock Actual</th>
                    <th>Mínimo</th>
                    <th>Estatus</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $p): ?>
                <tr>
                    <td class="fw-bold"><?= $p->nombre ?></td>
                    <td><span class="badge bg-secondary text-light"><?= $p->clasificador ?></span></td>
                    <td class="text-center"><?= $p->stock_actual ?></td>
                    <td class="text-center"><?= $p->stock_minimo ?></td>
                    <td class="text-center">
                        <?php if($p->stock_actual <= $p->stock_minimo): ?>
                            <span class="badge bg-danger"><i class="fas fa-exclamation-triangle"></i> Resurtir</span>
                        <?php else: ?>
                            <span class="badge bg-success"><i class="fas fa-check-circle"></i> OK</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <button class="btn btn-outline-dark btn-sm"><i class></i>Editar</button>
                    </td>
                    <td>
                        <button class="btn btn-outline-dark btn-sm">Eliminar</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<!-- BOTONES Y FUNCIONES PARA EXPRTAR DATATABLE -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/2.3.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.7/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.6/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.bootstrap5.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.colVis.min.js"></script>


<script>
   $(document).ready(function() {
    if ($('#inventarioTable').length > 0) {
        $('#inventarioTable').DataTable({
            layout: {
                topStart: {
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fa-solid fa-file-excel"></i>',
                            titleAttr: 'Exportar a Excel',
                            className: 'btn btn-success btn-sm'
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fa-solid fa-file-pdf"></i>',
                            titleAttr: 'Exportar a PDF',
                            className: 'btn btn-danger btn-sm'
                        },
                        {
                            extend: 'print',
                            text: '<i class="fa-solid fa-print"></i>',
                            titleAttr: 'Imprimir',
                            className: 'btn btn-info btn-sm'
                        }
                    ]
                }
            },
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/es-MX.json'
            },
            pageLength: 10,
            order: [[2, 'asc']], // Ordenar por Stock Actual
            columnDefs: [
                { targets: [2, 3, 4], className: 'text-center' }
            ]
        });
    }
});
</script>
    
</body>
</html>
