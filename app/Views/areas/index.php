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

<div class="container mt-4">
    
    <div class="card shadow-sm border-0 mt-2">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Catálogo de Áreas</h2>
            <button type="button" class="btn btn-dark shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#modalArea">
                <i class="fa-solid fa-plus-circle me-2"></i>Nueva Área
            </button>
        </div>
        <?php if(session()->getFlashdata('mensaje')): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('mensaje') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="tablaAreas" class="table table-hover mb-0 align-middle" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" width="15%">ID</th>
                            <th width="45%">Nombre del Área</th>
                            <th width="20%">Fecha Registro</th>
                            <th class="text-center pe-4" width="20%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($areas as $area): ?>
                        <tr>
                            <td class="ps-4">
                                <span class="text-muted fw-bold">#<?=($area->id) ?></span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded p-2 me-3">
                                        <i class="bi bi-building text-primary"></i>
                                    </div>
                                    <span class="fw-semibold text-dark"><?= $area->nombre_area ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted small">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    <?= date('d/m/Y', strtotime($area->created_at)) ?>
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm">
                                    <button class="btn btn-sm btn-white border" title="Editar" 
                                            onclick="editarArea(<?= $area->id ?>, '<?= $area->nombre_area ?>')">
                                        <i class="fa-regular fa-pen-to-square text-primary"></i>
                                    </button>
                                    
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalArea" tabindex="-1" aria-labelledby="modalTitulo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= base_url('areas/guardar') ?>" method="POST" class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalTitulo font-bold">
                    <i class="bi bi-pencil-fill me-2"></i>Gestionar Área
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" name="id" id="area_id">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nombre del Departamento</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-tag"></i></span>
                        <input type="text" name="nombre_area" id="nombre_area" class="form-control" 
                               placeholder="Ej. Recursos Humanos" required>
                    </div>
                    <div class="form-text">Asegúrate de no duplicar nombres existentes.</div>
                </div>
            </div>
            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-outline-dark px-4" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-dark px-4">Guardar Cambios</button>
            </div>
        </form>
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
    $('#tablaAreas').DataTable({
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
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        pageLength: 10,
        responsive: true
    });
});

// Función para reutilizar el modal al editar
function editarArea(id, nombre) {
    $('#modalTitulo').text('Editar Área');
    $('#area_id').val(id);
    $('#nombre_area').val(nombre);
    $('#modalArea').modal('show');
}
</script>
    
</body>
</html>