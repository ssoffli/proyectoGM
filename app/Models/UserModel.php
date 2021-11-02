<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model 
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    
    protected $returnType = 'array';
    protected $allowedFields = ['role', 'name', 'nick', 'pass'];

    protected $useTimestamps = true;
    protected $createdFields = 'created_at';
    protected $updatedFields = 'updated_at';

    protected $validationRules = [
        'role' => 'required',
        'name' => 'required|alpha_space|min_length[4]|max_length[60]',
        'nick' => 'required|alpha_numeric_space|min_length[4]|max_length[60]',
        'pass' => 'required|alpha_numeric_space|min_length[4]|max_length[60]'
    ];

    protected $skipValidation = false;
    
    public function validate($nick, $pass) {
        $builder = $this->builder();
        $builder->getTable('users');
        $builder->where(" nick = '$nick' AND pass = '$pass'");
        $query = $builder->get();
        return $query->getResult('array');
    }
}