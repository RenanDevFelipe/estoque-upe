<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ProdutoModel;

class ProdutoController extends BaseController
{
    protected $produtoModel;

    public function __construct()
    {
        $this->produtoModel = new ProdutoModel();
    }

    public function index() // GET /api/produtos
    {
        $produtos = $this->produtoModel->findAll();
        return $this->response->setJSON($produtos);
    }

    public function show($id = null) // GET /api/produtos/{id}
    {
        $produto = $this->produtoModel->find($id);
        if (!$produto) return $this->response->setStatusCode(404)->setJSON(['error' => 'Produto não encontrado']);
        return $this->response->setJSON($produto);
    }

    public function create() // POST /api/produtos
    {
        $data = $this->request->getJSON(true);
        if (!$this->produtoModel->insert($data)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Erro ao criar produto']);
        }
        return $this->response->setStatusCode(201)->setJSON(['message' => 'Produto criado', 'id' => $this->produtoModel->insertID()]);
    }

    public function update($id = null) // PUT /api/produtos/{id}
    {
        $data = $this->request->getJSON(true);
        if (!$this->produtoModel->update($id, $data)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Erro ao atualizar produto']);
        }
        return $this->response->setJSON(['message' => 'Produto atualizado']);
    }

    public function delete($id = null) // DELETE /api/produtos/{id}
    {
        if (!$this->produtoModel->delete($id)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Erro ao deletar produto']);
        }
        return $this->response->setJSON(['message' => 'Produto deletado']);
    }
}
?>