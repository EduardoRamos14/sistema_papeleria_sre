<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Salidas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css"  />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.bootstrap5.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.6/css/buttons.bootstrap5.css"/>
    <link rel="shortcut icon" href="<?= base_url() ?>public/assets/img/icon.ico" type="image/x-icon">



</head>
<body class="bg-light">
    <?=view ("partials/navbar"); ?><!--NavBar-->

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Historial de Entregas (Salidas)</h2>
            <a href="<?= base_url('salidas/crear') ?>" class="btn btn-dark">+ Nueva Entrega</a>
        </div>

        <?php if(session()->getFlashdata('mensaje')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('mensaje') ?></div>
        <?php endif; ?>

        <div class="card shadow">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="tablaSalidas">
                    <thead class="table-dark">
                        <tr>
                            <th>Folio</th>
                            <th>Generado por:</th>
                            <th>Área</th>
                            <th>Solicitante</th>
                            <th>Fecha</th>
                            <th>Notas</th>
                            <th>Detalle</th>
                            <th>Comprobante</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($salidas as $s): ?>
                        <tr>
                            <td><strong>#<?= $s->id ?></strong></td>
                            <td><strong><?= $s->nombre_usuario ?></strong></td>
                            <td><?= $s->nombre_area ?></td>
                            <td><?= $s->solicitante_nombre ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($s->fecha_salida)) ?></td>
                            <td><small class="text-muted"><?= $s->notas ?></small></td>
                            <td>
                                <a href="<?= base_url('salidas/detalle/' . $s->id) ?>" class="btn btn-outline-dark btn-sm">
                                    <i class="fa-solid fa-eye"></i> Ver Detalle
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('salidas/pdf/' . $s->id) ?>" target="_blank" class="btn btn-outline-danger btn-sm">
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
</body>


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
    if ($('#tablaSalidas').length > 0) {
        $('#tablaSalidas').DataTable({
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

<script>
<?php if (session()->getFlashdata('abrir_pdf')): ?>
    $(document).ready(function() {
        // Obtenemos el ID que mandamos desde el controlador
        const salidaId = "<?= session()->getFlashdata('abrir_pdf') ?>";
        const urlPdf = "<?= base_url('salidas/pdf') ?>/" + salidaId;

        // Abrimos el PDF en una pestaña nueva
        window.open(urlPdf, '_blank');
    });
<?php endif; ?>
</script>
</html>