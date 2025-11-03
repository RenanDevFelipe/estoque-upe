<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class AuthController extends BaseController
{
    public function login()
    {
        $data = $this->request->getJSON(true);
        if (!$data || !isset($data['email'], $data['senha'])) {
            return $this->response->setJSON(['error' => 'Dados inválidos'])->setStatusCode(400);
        }

        $um = new UsuarioModel();
        $user = $um->verifyPassword($data['email'], $data['senha']);

        if (!$user) {
            return $this->response->setJSON(['error' => 'Credenciais inválidas'])->setStatusCode(401);
        }

        // Token simples: aqui você pode gerar JWT. Por enquanto, retornamos id e tipo (não seguro)
        $token = base64_encode($user['id'] . ':' . $user['email']); // apenas placeholder
        return $this->response->setJSON([
            'token' => $token,
            'usuario' => [
                'id' => $user['id'],
                'nome' => $user['nome'],
                'tipo' => $user['tipo']
            ]
        ]);
    }
}
?>