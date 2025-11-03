<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return '<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sistema de Estoque</title>

  <!-- TailwindCSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

  <div class="container mx-auto mt-10">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold text-gray-800">📦 Controle de Estoque</h1>
      <button
        onclick="openModal()"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
        ➕ Novo Produto
      </button>
    </div>

    <!-- Tabela -->
    <div class="bg-white shadow-md rounded-lg p-4">
      <table class="w-full table-auto">
        <thead>
          <tr class="bg-gray-200 text-gray-700 font-semibold">
            <th class="p-2">ID</th>
            <th class="p-2">Nome</th>
            <th class="p-2">Categoria</th>
            <th class="p-2">Qtd</th>
            <th class="p-2">Preço</th>
            <th class="p-2">Ações</th>
          </tr>
        </thead>
        <tbody id="tabelaProdutos"></tbody>
      </table>
    </div>
  </div>

  <!-- Modal -->
  <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg shadow-md w-96">
      <h2 class="text-xl font-semibold mb-4">Cadastrar Produto</h2>

      <input id="nome" class="border p-2 w-full mb-2 rounded" placeholder="Nome">
      <input id="categoria" class="border p-2 w-full mb-2 rounded" placeholder="Categoria">
      <input id="quantidade" type="number" class="border p-2 w-full mb-2 rounded" placeholder="Quantidade">
      <input id="preco" type="number" class="border p-2 w-full mb-2 rounded" placeholder="Preço">

      <div class="flex justify-end gap-2 mt-4">
        <button onclick="closeModal()" class="bg-gray-400 px-4 py-2 rounded text-white">
          Cancelar
        </button>
        <button onclick="salvarProduto()" class="bg-green-600 px-4 py-2 rounded text-white">
          Salvar
        </button>
      </div>
    </div>
  </div>

<script>
    const API = "http://localhost/estoque-upe/public/api/produtos";

function openModal() {
    document.getElementById("modal").classList.remove("hidden");
}

function closeModal() {
    document.getElementById("modal").classList.add("hidden");
}

async function listarProdutos() {
    const res = await fetch(API);
    const dados = await res.json();

    let html = "";
    dados.forEach(p => {
        html += `
        <tr class="border-b">
          <td class="p-2 text-center">${p.id}</td>
          <td class="p-2">${p.nome}</td>
          <td class="p-2">${p.categoria}</td>
          <td class="p-2 text-center">${p.quantidade}</td>
          <td class="p-2 text-center">R$ ${p.preco}</td>
          <td class="p-2 text-center">
            <button class="bg-red-500 text-white px-2 py-1 rounded" onclick="deletarProduto(${p.id})">Excluir</button>
          </td>
        </tr>`;
    });

    document.getElementById("tabelaProdutos").innerHTML = html;
}

async function salvarProduto() {
    const produto = {
        nome: document.getElementById("nome").value,
        categoria: document.getElementById("categoria").value,
        quantidade: document.getElementById("quantidade").value,
        preco: document.getElementById("preco").value
    };

    await fetch(API, {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify(produto)
    });

    closeModal();
    listarProdutos();
}

async function deletarProduto(id) {
    await fetch(`${API}/${id}`, { method: "DELETE" });
    listarProdutos();
}

listarProdutos();

</script>
</body>
</html>
';
    }
}
