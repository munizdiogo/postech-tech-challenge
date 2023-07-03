<?php

namespace core\applications\ports;

use core\domain\entities\Pedido;

interface PedidoServiceInterface
{
    public function setNovoPedido(Pedido $pedido): bool;
    public function getPedidos(): array;
    public function getProdutosPorIdPedido(int $idPedido): array;
}
