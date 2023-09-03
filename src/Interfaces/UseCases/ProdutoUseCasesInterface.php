<?php

namespace Interfaces\UseCases;

use Entities\Produto;
use Gateways\ProdutoGateway;

interface ProdutoUseCasesInterface
{
    public function cadastrar(ProdutoGateway $produtoGateway, Produto $produto);
    public function atualizar(ProdutoGateway $produtoGateway, int $id, Produto $produto);
    public function excluir(ProdutoGateway $produtoGateway, int $id);
    public function obterPorCategoria(ProdutoGateway $produtoGateway, string $categoria);
}
