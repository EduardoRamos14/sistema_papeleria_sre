<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?=base_url()?>public/assets/css/comprobante.css">
</head>

<body>
    <div id="header">
        <img src="<?=base_url()?>public/assets/img/sre_encabezado.png" style="width: 100%;">
        <h2 style="margin: 5px 0 0 0;">VALE DE SALIDA DE MATERIAL</h2>
        <p style="margin: 0;">Control de Inventarios - Papelería</p>
    </div>

    <div id="footer">
        <img src="<?= base_url() ?>public/assets/img/sre_footer.png" style="width: 100%;">
    </div>

    <div class="content">
        <table class="info-table">
            <tr>
                <td><strong>Folio:</strong> #<?= str_pad($salida->id, 5, '0', STR_PAD_LEFT) ?></td>
                <td align="right"><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($salida->fecha_salida)) ?></td>
            </tr>
            <tr>
                <td><strong>Atendido por:</strong> <?= $salida->nombre_usuario ?></td>
            </tr>
            <tr>
                <td colspan="2"><strong>Área Solicitante:</strong> <?= $salida->nombre_area ?></td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Descripción del Producto</th>
                    <th align="center" width="15%">Cantidad</th>
                    <th align="center" width="15%">Unidad de Medida</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detalles as $item): ?>
                <tr>
                    <td><?= $item->producto_nombre ?></td>
                    <td align="center"><?= $item->cantidad ?></td>
                    <td align="center"><?= $item->unidad_medida ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

         <?php if (!empty($salida->notas)) {   ?>        
            <table class="items-table w-100 mt-4">
                <thead> 
                    <tr>
                        <th align="center">Notas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $salida->notas ?></td>
                    </tr>
                </tbody>
            </table>
        <?php } ?>

       <table class="signature">
            <tr>
                <td class="signature-box">
                    <div class="line"></div>
                    <p>Subdirección de Recursos Materiales,<br>
                    <span class="sub-text">Tecnológicos e Inventarios</span></p>
                </td>
                <td class="signature-box">
                    <div class="line"></div>
                    <p>Recibe (<?= esc($salida->nombre_area) ?>)</p>
                </td>
            </tr>
        </table>

        <div class="nota-footer">
            <p>Este documento es un comprobante interno de movimiento de inventario.</p>
        </div>
    </div>
</body>
</html>