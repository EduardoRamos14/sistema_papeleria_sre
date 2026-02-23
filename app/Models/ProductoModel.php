<?php 
namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model {
    protected $table      = 'productos';
    protected $primaryKey = 'id';
    protected $returnType = 'object'; 
    protected $allowedFields = [
        'nombre',
        'descripcion',
        'clasificador',
        'stock_actual',
        'stock_minimo',
        'unidad_medida'
    ];

    protected $useTimestamps    = false; 


}
