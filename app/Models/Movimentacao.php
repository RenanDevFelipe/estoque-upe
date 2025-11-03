<?php

namespace App\Models;

use CodeIgniter\Model;

class MovimentacaoModel extends Model
{
    protected $table = 'movimentacoes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['produto_id','usuario_id','tipo','quantidade','data','observacao','created_at','updated_at'];
    protected $useTimestamps = true;
}
?>