<?php

namespace controllers;

use core\application\ports\ProdutoGatewayInterface;
use core\domain\entities\Produto;

class ProdutoController
{
    private $produtoService;

    public function __construct(ProdutoGatewayInterface $produtoService)
    {
        $this->produtoService = $produtoService;
    }

    public function cadastrar(array $dados): void
    {
        $campos = ["nome", "descricao", "preco", "categoria"];

        foreach ($campos as $campo) {
            if (empty($dados[$campo])) {
                retornarRespostaJSON("O campo '$campo' é obrigatório.", 400);
                return;
            }
        }

        $produtoJaCadastrado = $this->produtoService->getProdutoPorNome($dados["nome"]);

        if ($produtoJaCadastrado) {
            retornarRespostaJSON("Já existe um produto cadastrado com esse nome.", 409);
            return;
        }


        $produto = new Produto($dados["nome"], $dados["descricao"], $dados["preco"], $dados["categoria"]);
        $salvarDados = $this->produtoService->setNovoProduto($produto);

        if ($salvarDados) {
            retornarRespostaJSON("Produto cadastrado com sucesso.", 201);
        } else {
            retornarRespostaJSON("Ocorreu um erro ao salvar os dados do produto.", 500);
        }
    }

    public function editar(array $dados): void
    {
        $campos = ["id", "nome", "descricao", "preco", "categoria"];

        foreach ($campos as $campo) {
            if (empty($dados[$campo])) {
                retornarRespostaJSON("O campo '$campo' é obrigatório.", 400);
                return;
            }
        }

        $dadosProduto = $this->produtoService->getProdutoPorId($dados["id"]);

        if (empty($dadosProduto)) {
            retornarRespostaJSON("Não foi encontrado um produto com o ID informado.", 440);
            return;
        }

        $produto = new Produto(
            $dados["nome"] ?? $dados["nome"] ?? $dadosProduto["nome"],
            $dados["descricao"] ?? $dados["descricao"] ?? $dadosProduto["descricao"],
            $dados["preco"] ?? $dados["preco"] ?? $dadosProduto["preco"],
            $dados["categoria"] ?? $dados["categoria"] ?? $dadosProduto["categoria"]
        );
        $produto->setId($dados["id"]);


        $salvarDados = $this->produtoService->setProduto($produto);

        if ($salvarDados) {
            retornarRespostaJSON("Produto atualizado com sucesso.", 200);
        } else {
            retornarRespostaJSON("Ocorreu um erro ao atualizar os dados do produto.", 500);
        }
    }

    public function excluir($id): void
    {

        if (empty(strval($id))) {
            retornarRespostaJSON("O campo ID é obrigatório.", 400);
            return;
        }

        $dadosProduto = $this->produtoService->getProdutoPorId($id);

        if (empty($dadosProduto)) {
            retornarRespostaJSON("Não foi encontrado um produto com o ID informado.", 440);
            return;
        }

        $excluirProduto = $this->produtoService->setExcluirProdutoPorId($id);

        if ($excluirProduto) {
            retornarRespostaJSON("Produto excluído com sucesso.", 200);
        } else {
            retornarRespostaJSON("Ocorreu um erro ao excluir o produto.", 500);
        }
    }

    public function obterProdutosPorCategoria(string $nome): void
    {
        if (empty($nome)) {
            retornarRespostaJSON("O campo nome é obrigatório.", 400);
            return;
        }

        $produtos = $this->produtoService->getProdutosPorCategoria($nome);

        if (!empty($produtos)) {
            retornarRespostaJSON($produtos, 200);
        } else {
            retornarRespostaJSON("Nenhum produto encontrado nesta categoria.", 200);
        }
    }
}
