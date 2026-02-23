<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="shortcut icon" href="<?= base_url() ?>public/assets/img/icon.ico" type="image/x-icon">

</head>
<body class="bg-light">
    <?= view("partials/navbar"); ?>

   <div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Editar Producto</h4>
        </div>
        <div class="card-body">
            <form action="<?= base_url('productos/actualizar/' . $producto->id) ?>" method="POST">
                <?= csrf_field() ?> 
                <div class="col-md-2 mb-3">
                    <label class="form-label fw-bold">Estatus</label>
                    <select name="activo" id="activo" class="form-select">
                        <option value="1" <?= $producto->activo == 1 ? 'selected' : '' ?>>Activo</option>
                        <option value="0" <?= $producto->activo == 0 ? 'selected' : '' ?>>Baja</option>
                    </select>
                </div>
                <div class="row">
                
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nombre del Producto</label>
                        <input type="text" name="nombre" class="form-control" value="<?= esc($producto->nombre) ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Categoría</label>
                        <input type="text" name="clasificador" class="form-control" value="<?= esc($producto->clasificador) ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Stock Actual</label>
                        <input type="number" name="stock" class="form-control" value="<?= esc($producto->stock_actual) ?>" readonly>
                        <small class="text-muted">El stock se ajusta mediante entradas y salidas.</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Stock Mínimo</label>
                        <input type="number" name="stock_minimo" class="form-control" value="<?= esc($producto->stock_minimo) ?>">
                        <small class="text-muted">El stock mínimo del Producto</small>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Descripción (Opcional):</label>
                        <textarea name="descripcion" class="form-control" value="<?= esc($producto->descripcion) ?>"
                            rows="2" placeholder="Detalles adicionales del material..."></textarea>
                    </div>

                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="<?= base_url('productos') ?>" class="btn btn-outline-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>