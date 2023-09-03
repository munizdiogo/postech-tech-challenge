<?php

namespace Controllers;

use Gateways\ProdutoGateway;
use Entities\Produto;
use Interfaces\Controllers\ProdutoControllerInterface;
use UseCases\ProdutoUseCases;

class ProdutoController implements ProdutoControllerInterface
{
    public function cadastrar($dbConnection, array $dados)
    {
        $nome = $dados["nome"] ?? "";
        $descricao = $dados["descricao"] ?? "";
        $preco = $dados["preco"] ?? "";
        $categoria = $dados["categoria"] ?? "";
        $produto = new Produto($nome, $descricao, $preco, $categoria);
        $produtoGateway = new ProdutoGateway($dbConnection);
        $produtoUseCases = new ProdutoUseCases();
        $salvarDados = $produtoUseCases->cadastrar($produtoGateway, $produto);
        return $salvarDados;
    }

    public function atualizar($dbConnection, array $dados)
    {
        $nome = $dados["nome"] ?? "";
        $descricao = $dados["descricao"] ?? "";
        $preco = $dados["preco"] ?? "";
        $categoria = $dados["categoria"] ?? "";
        $id = $dados["id"] ?? 0;
        $produto = new Produto($nome, $descricao, $preco, $categoria);
        $produtoGateway = new ProdutoGateway($dbConnection);
        $produtoUseCases = new ProdutoUseCases();
        $atualizarDados = $produtoUseCases->atualizar($produtoGateway, $id, $produto);
        return $atualizarDados;
    }

    public function excluir($dbConnection, int $id)
    {
        $produtoGateway = new ProdutoGateway($dbConnection);
        $produtoUseCases = new ProdutoUseCases();
        $excluirProduto = $produtoUseCases->excluir($produtoGateway, $id);
        return $excluirProduto;
    }

    public function obterPorCategoria($dbConnection, string $nome)
    {
        $produtoGateway = new ProdutoGateway($dbConnection);
        $produtoUseCases = new ProdutoUseCases();
        $produtos = $produtoUseCases->obterPorCategoria($produtoGateway, $nome);
        return $produtos;
    }
}
