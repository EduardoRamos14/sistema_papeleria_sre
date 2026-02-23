<?php

namespace App\Models;

use CodeIgniter\Model;

class EntradaModel extends Model
{
    protected $table            = 'entradas';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $allowedFields    = [
        'usuario_recibe', 
        'observaciones', 
        'id_usuario',
        'fecha_registro'
        ];

    protected $useTimestamps    = false;
}