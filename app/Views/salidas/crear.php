<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Entrega</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?= base_url() ?>public/assets/img/icon.ico" type="image/x-icon">

</head>
<body class="bg-light">
    <?= view("partials/navbar"); ?><!--NavBar-->
    <div class="container mt-5">
        <div class="card shadow border-0">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Registrar Entrega de Material</h4>
            </div>
            <div class="card-body">
                <form action="<?= base_url('salidas/guardar') ?>" method="POST">
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Área que solicita:</label>
                            <select name="area_id" class="form-select" required>
                                <option value="">Seleccione el área...</option>
                                <?php foreach($areas as $a): ?>
                                    <option value="<?= $a->id ?>"><?= $a->nombre_area ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nombre del solicitante:</label>
                            <input type="text" name="solicitante_nombre" class="form-control" placeholder="Nombre de quien recibe" required>
                        </div>
                    </div>

                    <h5 class="border-bottom pb-2">Materiales a entregar</h5>
                    <table class="table" id="tablaDetalle">
                        <thead>
                            <tr>
                                <th style="width: 50%;">Producto</th>
                                <th>Existencia</th>
                                <th style="width: 20%;">Cantidad</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            </tbody>
                    </table>

                    <button type="button" class="btn btn-outline-dark btn-sm mb-4" onclick="agregarFila()">
                        + Agregar Producto
                    </button>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Observaciones:</label>
                        <textarea name="notas" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('salidas') ?>" class="btn btn-outline-dark">Cancelar</a>
                        <button type="submit" class="btn btn-dark px-4">Confirmar y Descontar Stock</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
        const productos = <?= json_encode($productos) ?>;

        function agregarFila() {
            const tbody = document.querySelector('#tablaDetalle tbody');
            const row = document.createElement('tr');

            let opciones = '<option value="">Seleccionar producto...</option>';
            productos.forEach(p => {
                opciones += `<option value="${p.id}" data-stock="${p.stock_actual}">${p.nombre} [${p.clasificador}]</option>`;
            });

            row.innerHTML = `
                <td>
                    <select name="producto_id[]" class="form-select" onchange="actualizarMax(this)" required>
                        ${opciones}
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control bg-light input-stock" readonly value="0">
                </td>
                <td>
                    <input type="number" name="cantidad[]" class="form-control input-cantidad" min="1" value="1" required disabled>
                </td>
                <td>
                    <button type="button" class="btn btn-link text-danger" onclick="this.closest('tr').remove()">Eliminar</button>
                </td>
            `;
            tbody.appendChild(row);
        }

        function actualizarMax(select) {
            const row = select.closest('tr');
            const inputStock = row.querySelector('.input-stock');
            const inputCant = row.querySelector('.input-cantidad');
            
            if (select.value === "") {
                inputStock.value = 0;
                inputCant.disabled = true;
                return;
            }

            const stockDisponible = select.options[select.selectedIndex].getAttribute('data-stock');
            inputStock.value = stockDisponible;
            inputCant.disabled = false;
            inputCant.max = stockDisponible; // Límite físico
        }

        window.onload = agregarFila;
    </script>
</body>
</html>