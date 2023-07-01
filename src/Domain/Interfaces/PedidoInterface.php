<?php

interface PedidoInterface
{
    public function setNovoPedido(array $dados): bool;
    public function setProduto(array $dados): bool;
    public function setExcluirProduto(int $id);
    public function getPedidos(): array;
}
