<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        /* 1. Configuración de márgenes de la página */
        @page {
            margin: 160px 50px 100px 50px; 
        }
        
        body { font-family: 'Noto Sans','Helvetica', sans-serif; color: #333; font-size: 12px; }

        /* 2. Estilo del Membrete (Encabezado Fijo) */
        #header {
            position: fixed;
            top: -140px; 
            left: 0px;
            right: 0px;
            height: 120px;
            text-align: center;
        }

        /* 3. Estilo del Pie de Página Fijo */
        #footer {
            position: fixed;
            bottom: -80px;
            left: 0px;
            right: 0px;
            height: 80px;
            text-align: center;
        }

        /* Estilos de contenido */
        .info-table { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .info-table td { padding: 5px; }
        .items-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .items-table th { background-color: #f2f2f2; padding: 10px; border: 1px solid #ddd; text-align: left; }
        .items-table td { padding: 10px; border: 1px solid #ddd; }
        
        .signature { margin-top: 50px; width: 100%; }
        .signature td { text-align: center; width: 50%; }
        .line { border-top: 1px solid #000; width: 80%; margin: 0 auto; }
        
        .nota-footer { margin-top: 30px; text-align: center; font-size: 9px; color: #555; }
    </style>
</head>

<body>
    <div id="header">
        <img src="<?=base_url()?>public/assets/img/sre_encabezado.png" style="width: 100%;">
        <h2 style="margin: 5px 0 0 0;">VALE DE ENTRADA DE MATERIAL</h2>
        <p style="margin: 0;">Control de Inventarios - Papelería</p>
    </div>

    <div id="footer">
        <img src="<?= base_url() ?>public/assets/img/sre_footer.png" style="width: 100%;">
    </div>

    <div class="content">
        <table class="info-table">
            <tr>
                <td><strong>Folio:</strong> #<?= str_pad($entrada->id, 5, '0', STR_PAD_LEFT) ?></td>
                <td align="right"><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($entrada->fecha_registro)) ?></td>
            </tr>
            <tr>
                <td><strong>Registrado por:</strong> <?= $entrada->usuario_recibe ?></td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Descripción del Producto</th>
                    <th align="center" width="15%">Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detalles as $item): ?>
                <tr>
                    <td><?= $item->producto_nombre ?></td>
                    <td align="center"><?= $item->cantidad ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

         <?php if (!empty($entrada->observaciones)) {   ?>        
            <table class="items-table w-100 mt-4">
                <thead> 
                    <tr>
                        <th align="center">Notas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $entrada->observaciones ?></td>
                    </tr>
                </tbody>
            </table>
        <?php } ?>

        <table class="signature">
            <tr>
                <td>
                    <br><br>
                    <div class="line"></div>
                    <p>Registrado por: (<?= $entrada->usuario_recibe ?>)</p>
                </td>
                <td>
                    <br><br>
                    <div class="line"></div>
                    <p>Validado Por:</p>
                </td>
                
            </tr>
        </table>

        <div class="nota-footer">
            <p>Este documento es un comprobante interno de movimiento de inventario.</p>
        </div>
    </div>
</body>
</html>

