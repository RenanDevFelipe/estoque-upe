<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use \App\Entities\Usuario; // se usar entity, senão direto Model

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nome' => 'Admin',
                'email' => 'admin@exemplo.com',
                'senha' => password_hash('admin123', PASSWORD_DEFAULT),
                'tipo' => 'administrador'
            ],
            [
                'nome' => 'Funcionario',
                'email' => 'func@exemplo.com',
                'senha' => password_hash('func123', PASSWORD_DEFAULT),
                'tipo' => 'funcionario'
            ]
        ];

        foreach ($data as $d) {
            $this->db->table('usuarios')->insert($d);
        }
    }
}
?>