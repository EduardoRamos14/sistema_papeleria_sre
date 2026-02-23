<?php

namespace App\Models;

use CodeIgniter\Model;

class SalidaModel extends Model
{
    protected $table            = 'salidas';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $allowedFields    = [
        'area_id', 
        'id_usuario', 
        'solicitante_nombre', 
        'fecha_salida', 
        'notas'
        ];
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'fecha_salida'; 
    protected $updatedField  = '';
}