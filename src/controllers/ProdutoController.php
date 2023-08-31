<?php

namespace controllers;

use gateways\ProdutoGateway;
use core\domain\entities\Produto;
use usecases\ProdutoUseCases;

class ProdutoController
{
    public function __construct()
    {
    }

    public function cadastrar($dbConnection, array $dados)
    {
        $campos = ["nome", "descricao", "preco", "categoria"];

        foreach ($campos as $campo) {
            if (empty($dados[$campo])) {
                retornarRespostaJSON("O campo '$campo' é obrigatório.", 400);
                exit;
            }
        }

        $produto = new Produto($dados["nome"], $dados["descricao"], $dados["preco"], $dados["categoria"]);
        $produtoGateway = new ProdutoGateway($dbConnection);
        $produtoUseCases = new ProdutoUseCases();
        $salvarDados = $produtoUseCases->cadastrar($produtoGateway, $produto);
        return $salvarDados;
    }

    public function atualizar($dbConnection, array $dados)
    {
        $campos = ["id", "nome", "descricao", "preco", "categoria"];

        foreach ($campos as $campo) {
            if (empty($dados[$campo])) {
                retornarRespostaJSON("O campo '$campo' é obrigatório.", 400);
                exit;
            }
        }

        $produto = new Produto(
            $dados["nome"],
            $dados["descricao"],
            $dados["preco"],
            $dados["categoria"]
        );

        $produtoGateway = new ProdutoGateway($dbConnection);
        $produtoUseCases = new ProdutoUseCases();
        $atualizarDados = $produtoUseCases->atualizar($produtoGateway, $dados["id"], $produto);
        return $atualizarDados;
    }

    public function excluir($dbConnection, int $id)
    {
        if (empty(strval($id))) {
            retornarRespostaJSON("O campo ID é obrigatório.", 400);
            exit;
        }

        $produtoGateway = new ProdutoGateway($dbConnection);
        $produtoUseCases = new ProdutoUseCases();
        $excluirProduto = $produtoUseCases->excluir($produtoGateway, $id);
        return $excluirProduto;
    }

    public function obterPorCategoria($dbConnection, string $nome)
    {
        if (empty($nome)) {
            retornarRespostaJSON("O campo nome é obrigatório.", 400);
            exit;
        }

        $produtoGateway = new ProdutoGateway($dbConnection);
        $produtoUseCases = new ProdutoUseCases();
        $produtos = $produtoUseCases->obterPorCategoria($produtoGateway, $nome);
        return $produtos;
    }
}
