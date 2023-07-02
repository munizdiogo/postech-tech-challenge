<?php

namespace Domain\Interfaces;

use Domain\Entities\Pedido;

interface PedidoServiceInterface
{
    public function setNovoPedido(Pedido $pedido): bool;
    public function setProduto(array $dados): bool;
    public function setExcluirProduto(int $id);
    public function getPedidos(): array;
}
