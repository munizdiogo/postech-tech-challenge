<?php

namespace core\application\ports;

use core\domain\entities\Pedido;

interface PedidoServiceInterface
{
    public function setNovoPedido(Pedido $pedido);
    public function getPedidos(): array;
    public function getProdutosPorIdPedido(int $idPedido): array;
}
