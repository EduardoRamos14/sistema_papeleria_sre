<?php namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model{
    protected $table ='usuarios';
        protected $primaryKey ='id_usuario';
        protected $returnType = 'object';

        //protected $useAutoincrement=true;
        protected $allowedFields=
            ['nombre',    
            'usuario', 
            'password',
            'email',
            'rol',
            'estatus'
        ];

        protected $useTimestamps = true;
        protected $createdField = 'created_at';
        protected $updateField = 'updated_at';

    public function obtenerUsuario($data){
        $Usuario = $this->db->table('usuarios');
        $Usuario->where($data);
            return $Usuario->get()->getResultArray();
    }

}
