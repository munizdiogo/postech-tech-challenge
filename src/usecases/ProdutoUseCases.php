<?php

namespace usecases;

use core\domain\entities\Produto;
use gateways\ProdutoGateway;

class ProdutoUseCases
{
    public function cadastrar(ProdutoGateway $produtoGateway, Produto $produto)
    {
        $produtoJaCadastrado = $produtoGateway->obterPorNome($produto->getNome());

        if ($produtoJaCadastrado) {
            retornarRespostaJSON("Já existe um produto cadastrado com esse nome.", 409);
            exit;
        }

        $resultadoCadastro = $produtoGateway->cadastrar($produto);
        return $resultadoCadastro;
    }

    public function atualizar(ProdutoGateway $produtoGateway, int $id, Produto $produto)
    {
        $produtoEncontrado = $produtoGateway->obterPorId($id);

        if ($produtoEncontrado) {
            $produtoAtualizado = new Produto(
                $produto->getNome() ?? $produtoEncontrado["nome"],
                $produto->getDescricao() ?? $produtoEncontrado["descricao"],
                $produto->getPreco() ?? $produtoEncontrado["preco"],
                $produto->getCategoria() ?? $produtoEncontrado["categoria"]
            );
            $resultadoAtualizacao = $produtoGateway->atualizar($id, $produtoAtualizado);
            return $resultadoAtualizacao;
        } else {
            retornarRespostaJSON("Não foi encontrado um produto com o ID informado.", 400);
            exit;
        }
    }

    public function excluir(ProdutoGateway $produtoGateway, int $id)
    {
        $produtoEncontrado = $produtoGateway->obterPorId($id);

        if ($produtoEncontrado) {
            $resultadoAtualizacao = $produtoGateway->excluir($id);
            return $resultadoAtualizacao;
        } else {
            retornarRespostaJSON("Não foi encontrado um produto com o ID informado.", 400);
            exit;
        }
    }

    public function obterPorCategoria(ProdutoGateway $produtoGateway, string $categoria)
    {
        $produtos = $produtoGateway->obterPorCategoria($categoria);
        return $produtos;
    }
}
