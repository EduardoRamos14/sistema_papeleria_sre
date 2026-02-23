<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="shortcut icon" href="<?= base_url() ?>public/assets/img/icon.ico" type="image/x-icon">

</head>
<body class="bg-light">
    <?= view("partials/navbar"); ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-dark text-white py-3">
                        <h5 class="mb-0"><i class="fa-solid fa-box-plus me-2"></i>Registrar Nuevo Producto en Catálogo</h5>
                    </div>
                    <div class="card-body p-4">
                        
                        <form action="<?= base_url('productos/guardar') ?>" method="POST">
                            <?= csrf_field() ?>

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Nombre del Artículo:</label>
                                    <input type="text" name="nombre" class="form-control" placeholder="Ej. Hojas Bond A4" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Clasificador / Categoría:</label>
                                    <input type="text" name="clasificador" class="form-control" list="clasificadores_comunes" placeholder="Escribe o selecciona..." required>
                                    <datalist id="clasificadores_comunes">
                                        <option value="Papelería Básica">
                                        <option value="Consumibles de Impresión">
                                        <option value="Artículos de Escritorio">
                                        <option value="Limpieza de Oficina">
                                    </datalist>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Unidad de Medida:</label>
                                    <select name="unidad_medida" class="form-select">
                                        <option value="Pieza">Pieza</option>
                                        <option value="Paquete">Paquete</option>
                                        <option value="Caja">Caja</option>
                                        <option value="Millar">Millar</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Stock Mínimo (Alerta):</label>
                                    <input type="number" name="stock_minimo" class="form-control" value="5" min="0" required>
                                    <div class="form-text">El sistema te avisará cuando el stock sea igual o menor a este número.</div>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Descripción (Opcional):</label>
                                    <textarea name="descripcion" class="form-control" rows="2" placeholder="Detalles adicionales del material..."></textarea>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-end gap-2">
                                <a href="<?= base_url('productos') ?>" class="btn btn-outline-dark">Cancelar</a>
                                <button type="submit" class="btn btn-dark px-4">
                                    <i class="fa-solid fa-save me-2"></i>Guardar Producto
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>