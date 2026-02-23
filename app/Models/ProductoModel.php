<?php 
namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model {
    protected $table      = 'productos';
    protected $primaryKey = 'id';
    protected $returnType = 'object'; 
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'nombre',
        'descripcion',
        'clasificador',
        'stock_actual',
        'stock_minimo',
        'unidad_medida',
        'activo'
    ];

   protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = ''; 
    protected $updatedField  = 'updated_ad';


}
