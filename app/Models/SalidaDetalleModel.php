<?php

namespace App\Models;

use CodeIgniter\Model;

class SalidaDetalleModel extends Model
{
    protected $table            = 'salidas_detalle';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $allowedFields    = [
        'salida_id', 
        'producto_id', 
        'cantidad'
        ];
}