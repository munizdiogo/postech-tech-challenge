<?php

namespace core\application\ports;

use core\domain\entities\Produto;

interface ProdutoServiceInterface
{
    public function setNovoProduto(Produto $produto): bool;
    public function setProduto(Produto $produto): bool;
    public function setExcluirProdutoPorId(int $id): bool;
    public function getProdutosPorCategoria(string $categoria): array;
    public function getProdutoPorNome(string $nome): array;
    public function getProdutoPorId(string $id): array;
}
