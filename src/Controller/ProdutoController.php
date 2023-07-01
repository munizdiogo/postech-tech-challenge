<?php

namespace Controller;

use Service\ProdutoService;

class ProdutoController
{
    private $produtoService;

    public function __construct(ProdutoService $produtoService)
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

        $produtoJaCadastrado = $this->produtoService->obterProdutoPorNome($dados["nome"]);

        if ($produtoJaCadastrado) {
            retornarRespostaJSON("Já existe um produto cadastrado com esse nome.", 409);
            return;
        }

        $salvarDados = $this->produtoService->cadastrar($dados);

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

        $dadosProduto = $this->produtoService->obterProdutoPorId($dados["id"]);

        if (empty($dadosProduto)) {
            retornarRespostaJSON("Não foi encontrado um produto com o ID informado.", 440);
            return;
        }

        $novosDados = [
            "id" => $dados["id"],
            "nome" => $dados["nome"] ?? $dadosProduto["nome"] ?? "",
            "descricao" => $dados["descricao"] ?? $dadosProduto["descricao"] ?? "",
            "preco" => $dados["preco"] ?? $dadosProduto["preco"] ?? "",
            "categoria" => $dados["categoria"] ?? $dadosProduto["categoria"] ?? ""
        ];

        $salvarDados = $this->produtoService->editar($novosDados);

        if ($salvarDados) {
            retornarRespostaJSON("Produto atualizado com sucesso.", 200);
        } else {
            retornarRespostaJSON("Ocorreu um erro ao atualizar os dados do produto.", 500);
        }
    }

    public function excluir(int $id): void
    {
        if (empty($id)) {
            retornarRespostaJSON("O campo ID é obrigatório.", 400);
            return;
        }

        $dadosProduto = $this->produtoService->obterProdutoPorId($id);

        if (empty($dadosProduto)) {
            retornarRespostaJSON("Não foi encontrado um produto com o ID informado.", 440);
            return;
        }

        $excluirProduto = $this->produtoService->excluir($id);

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

        $produtos = $this->produtoService->obterProdutosPorCategoria($nome);

        if (!empty($produtos)) {
            retornarRespostaJSON($produtos, 200);
        } else {
            retornarRespostaJSON("Nenhum produto encontrado nesta categoria.", 200);
        }
    }
}
