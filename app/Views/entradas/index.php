<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Entradas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css"  />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.bootstrap5.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.6/css/buttons.bootstrap5.css"/>
    <link rel="shortcut icon" href="<?= base_url() ?>public/assets/img/icon.ico" type="image/x-icon">



</head>
<body class="bg-light">
    <?= view("partials/navbar"); ?>
    <?= view("partials/session"); ?>

    <div class="container mt-4">
        <div class="card shadow p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold"><i class="fa-solid fa-file-import"></i> Historial de Entradas</h2>
                <a href="<?= base_url('entradas/crear') ?>" class="btn btn-dark">
                    <i class="fa-solid fa-plus"></i> Nueva Carga de Stock
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover border" id="tablaEntradas">
                    <thead class="table-dark">
                        <tr>
                            <th>ID / Folio</th>
                            <th>Recibido por</th>
                            <th>Fecha de Registro</th>
                            <th>Observaciones</th>
                            <th class="text-center">Acciones</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($entradas as $e): ?>
                        <tr>
                            <td class="fw-bold">#<?= $e->id ?></td>
                            <td><?= $e->usuario_recibe ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($e->fecha_registro)) ?></td>
                            <td><small><?= $e->observaciones ?: 'Sin notas' ?></small></td>
                            <td class="text-center">
                                <a href="<?= base_url('entradas/detalles/' . $e->id) ?>" class="btn btn-outline-dark btn-sm">  <i class="fa-solid fa-eye"></i> Ver Detalle</a>
                            </td>
                            <td>
                                <a href="<?= base_url('entradas/pdf/' . $e->id) ?>" target="_blank" class="btn btn-outline-danger btn-sm">
                                    <i class="fa-solid fa-file-pdf"></i> Imprimir Vale
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
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
    if ($('#tablaEntradas').length > 0) {
        $('#tablaEntradas').DataTable({
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
            order: [[0, 'desc']], // Ordenar por ID
            columnDefs: [
                { targets: [2, 3, 4], className: 'text-center' }
            ]
        });
    }
});
</script>


<?php if (session()->getFlashdata('abrir_pdf')): ?>
<script>
    $(document).ready(function() {
        const entradaId = "<?= session()->getFlashdata('abrir_pdf') ?>";
        // Eliminamos el primer '/' antes de entradas para evitar rutas dobles si base_url ya trae slash
        const urlPdf = "<?= base_url('entradas/pdf') ?>/" + entradaId;

        // Intentamos abrir la pestaña
        const nuevaVentana = window.open(urlPdf, '_blank');

        if (!nuevaVentana || nuevaVentana.closed || typeof nuevaVentana.closed == 'undefined') {
            // Si el navegador bloqueó el pop-up, avisamos al usuario
            alert('El comprobante se generó, pero el navegador bloqueó la ventana emergente. Por favor, permítelas para este sitio.');
        }
    });
</script>
<?php endif; ?>