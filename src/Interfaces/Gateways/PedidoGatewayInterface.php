<?php

namespace Interfaces\Gateways;

use Entities\Pedido;

interface PedidoGatewayInterface
{
    public function cadastrar(Pedido $pedido);
    public function obterPedidos(): array;
    public function atualizarStatusPedido($id, $status): bool;
    public function atualizarStatusPagamentoPedido($id, $status): bool;
    public function obterStatusPagamentoPedido($id): array;
    public function obterPorId($id): array;
}
