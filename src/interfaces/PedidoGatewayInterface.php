<?php

namespace interfaces;

use core\domain\entities\Pedido;

interface PedidoGatewayInterface
{
    public function cadastrar(Pedido $pedido);
    public function getPedidos(): array;
    public function getProdutosPorIdPedido(int $idPedido): array;
}
