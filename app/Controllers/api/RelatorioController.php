<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ProdutoModel;

class RelatorioController extends BaseController
{
    public function estoqueResumo()
    {
        $pm = new ProdutoModel();
        $produtos = $pm->findAll();
        // Você pode enriquecer com filtros/ordenações
        return $this->response->setJSON($produtos);
    }
}
?>