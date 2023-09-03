<?php

namespace Interfaces\UseCases;

use Entities\Pedido;
use Gateways\PedidoGateway;

interface PedidoUseCasesInterface
{
    public function cadastrar(PedidoGateway $pedidoGateway, Pedido $pedido);
    public function obterPedidos(PedidoGateway $pedidoGateway);
    public function atualizarStatusPedido(PedidoGateway $pedidoGateway, int $id, string $status);
    public function atualizarStatusPagamentoPedido(PedidoGateway $pedidoGateway, int $id, string $status);
    public function obterStatusPagamentoPedido(PedidoGateway $pedidoGateway, int $id);
    public function obterPorId(PedidoGateway $pedidoGateway, int $id);
}
