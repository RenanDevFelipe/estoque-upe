<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMovimentacoesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'produto_id'  => ['type' => 'INT', 'unsigned' => true],
            'usuario_id'  => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'tipo'        => ['type' => 'ENUM', 'constraint' => ['entrada','saida']],
            'quantidade'  => ['type' => 'INT'],
            'data'        => ['type' => 'DATETIME', 'null' => true],
            'observacao'  => ['type' => 'TEXT', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('produto_id', 'produtos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('movimentacoes');
    }

    public function down()
    {
        $this->forge->dropTable('movimentacoes');
    }
}
?>