<?php

namespace Domain\Interfaces;

use Domain\Entities\Pedido;

interface PedidoServiceInterface
{
    public function setNovoPedido(Pedido $pedido): bool;
    public function getPedidos(): array;
    public function getProdutosPorIdPedido(int $idPedido): array;
}
