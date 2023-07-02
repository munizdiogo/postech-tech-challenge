<?php

interface ProdutoInterface
{
    public function setNovoProduto(array $dados): bool;
    public function setProduto(array $dados): bool;
    public function setExcluirProdutoPorId(int $id): bool;
    public function getProdutosPorCategoria(string $categoria): array;
    public function getProdutoPorNome(string $nome): array;
    public function getProdutoPorId(string $id): array;
}
