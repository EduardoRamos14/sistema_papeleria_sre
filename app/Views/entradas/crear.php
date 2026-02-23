<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?= base_url() ?>public/assets/img/icon.ico" type="image/x-icon">

</head>
<body class="bg-light">
    <?=view ("partials/navbar"); ?><!--NavBar-->

<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0"><i class="bi bi-box-arrow-in-down"></i> Carga de Material (Entrada)</h4>
        </div>
        <div class="card-body">
            <form action="<?= base_url('entradas/guardar') ?>" method="POST">
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Usuario:</label>
                        <span class="text-muted"><?= session()->get('id_usuario') ?> <?= session()->get('nombre') ?></span>
                        <!--  -->
                    </div>

                </div>

                <table class="table table-striped" id="tablaEntrada">
                    <thead>
                        <tr>
                            <th style="width: 60%;">Producto</th>
                            <th style="width: 30%;">Cantidad que llega</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        </tbody>
                </table>

                <button type="button" class="btn btn-outline-secondary btn-sm mb-4" onclick="agregarFila()">
                    + Agregar otro producto
                </button>

                <div class="mb-4">
                    <label class="form-label">Notas de la carga:</label>
                    <textarea name="observaciones" class="form-control" rows="2" placeholder="Ej. Material solicitado el lunes..."></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="<?= base_url('entradas') ?>" class="btn btn-outline-dark">Cancelar</a>
                    <button type="submit" class="btn btn-dark px-4">Ingresar a Almacén</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    const productos = <?= json_encode($productos) ?>;

    function agregarFila() {
        const tbody = document.querySelector('#tablaEntrada tbody');
        const row = document.createElement('tr');

        let opciones = '<option value="">Seleccione el producto...</option>';
        productos.forEach(p => {
           opciones += `<option value="${p.id}">${p.nombre} [${p.clasificador}] [${p.unidad_medida}]</option>`;
        });

        row.innerHTML = `
            <td>
                <select name="producto_id[]" class="form-select" required>
                    ${opciones}
                </select>
            </td>
            <td>
                <input type="number" name="cantidad[]" class="form-control" min="1" value="1" required>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">X</button>
            </td>
        `;
        tbody.appendChild(row);
    }

    window.onload = agregarFila;
</script>

</body>
</html>