<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nome','email','senha','tipo','created_at','updated_at'];
    protected $useTimestamps = true;
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['senha'])) {
            $data['data']['senha'] = password_hash($data['data']['senha'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    public function verifyPassword($email, $senha)
    {
        $user = $this->where('email', $email)->first();
        if (!$user) return false;
        return password_verify($senha, $user['senha']) ? $user : false;
    }
}
?>