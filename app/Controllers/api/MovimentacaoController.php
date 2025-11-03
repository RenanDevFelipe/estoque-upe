<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\MovimentacaoModel;
use App\Models\ProdutoModel;

class MovimentacaoController extends BaseController
{
    protected $movModel;
    protected $prodModel;

    public function __construct()
    {
        $this->movModel = new MovimentacaoModel();
        $this->prodModel = new ProdutoModel();
    }

    public function index() // GET /api/movimentacoes
    {
        $movs = $this->movModel->findAll();
        return $this->response->setJSON($movs);
    }

    public function create() // POST /api/movimentacoes
    {
        $data = $this->request->getJSON(true);
        // Espera: produto_id, usuario_id (opcional), tipo (entrada|saida), quantidade, observacao
        if (!isset($data['produto_id'], $data['tipo'], $data['quantidade'])) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Dados incompletos']);
        }

        $produto = $this->prodModel->find($data['produto_id']);
        if (!$produto) return $this->response->setStatusCode(404)->setJSON(['error' => 'Produto não encontrado']);

        // Atualiza quantidade no produto
        $quant = (int)$data['quantidade'];
        if ($data['tipo'] === 'entrada') {
            $produto['quantidade'] += $quant;
        } elseif ($data['tipo'] === 'saida') {
            if ($produto['quantidade'] < $quant) {
                return $this->response->setStatusCode(400)->setJSON(['error' => 'Quantidade insuficiente em estoque']);
            }
            $produto['quantidade'] -= $quant;
        } else {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Tipo inválido']);
        }

        // transação simples
        $db = \Config\Database::connect();
        $db->transStart();

        $this->prodModel->update($produto['id'], ['quantidade' => $produto['quantidade']]);

        $movData = [
            'produto_id' => $data['produto_id'],
            'usuario_id' => $data['usuario_id'] ?? null,
            'tipo' => $data['tipo'],
            'quantidade' => $data['quantidade'],
            'data' => date('Y-m-d H:i:s'),
            'observacao' => $data['observacao'] ?? null,
        ];

        $this->movModel->insert($movData);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Erro ao registrar movimentação']);
        }

        return $this->response->setStatusCode(201)->setJSON(['message' => 'Movimentação registrada']);
    }
}
?>