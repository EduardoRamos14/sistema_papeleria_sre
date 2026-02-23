<?php

namespace App\Models;

use CodeIgniter\Model;

class EntradaDetalleModel extends Model
{
    protected $table            = 'entradas_detalle';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $allowedFields    = [
        'entrada_id', 
        'producto_id', 
        'cantidad'
        ];
}