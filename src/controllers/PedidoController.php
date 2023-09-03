<?php

namespace Controllers;

use Gateways\PedidoGateway;
use Entities\Pedido;
use Interfaces\Controllers\PedidoControllerInterface;
use UseCases\PedidoUseCases;

class PedidoController implements PedidoControllerInterface
{
    public function cadastrar($dbConnection, array $dados)
    {
        $dados = $dados ?? [];
        $idCliente = $dados["idCliente"] ?? "";
        $produtos = $dados["produtos"] ?? [];
        $pedidoGateway = new PedidoGateway($dbConnection);
        $pedidoUseCases = new PedidoUseCases();
        $pedido = new Pedido("recebido", $idCliente, $produtos);
        $idPedido = $pedidoUseCases->cadastrar($pedidoGateway, $pedido);
        return $idPedido;
    }

    public function obterPedidos($dbConnection)
    {
        $pedidoGateway = new PedidoGateway($dbConnection);
        $pedidoUseCases = new PedidoUseCases();
        $pedidos = $pedidoUseCases->obterPedidos($pedidoGateway);
        return $pedidos;
    }

    public function obterPorId($dbConnection, $id)
    {
        $pedidoGateway = new PedidoGateway($dbConnection);
        $pedidoUseCases = new PedidoUseCases();
        $pedido = $pedidoUseCases->obterPorId($pedidoGateway, $id);
        return $pedido;
    }
    public function obterStatusPagamentoPedido($dbConnection, $id)
    {
        $pedidoGateway = new PedidoGateway($dbConnection);
        $pedidoUseCases = new PedidoUseCases();
        $pedidos = $pedidoUseCases->obterStatusPagamentoPedido($pedidoGateway, $id);
        return $pedidos;
    }
    public function atualizarStatusPedido($dbConnection, $id, $status)
    {
        $pedidoGateway = new PedidoGateway($dbConnection);
        $pedidoUseCases = new PedidoUseCases();
        $resultado = $pedidoUseCases->atualizarStatusPedido($pedidoGateway, $id, $status);
        return $resultado;
    }
    public function atualizarStatusPagamentoPedido($dbConnection, $id, $status)
    {
        $pedidoGateway = new PedidoGateway($dbConnection);
        $pedidoUseCases = new PedidoUseCases();
        $resultado = $pedidoUseCases->atualizarStatusPagamentoPedido($pedidoGateway, $id, $status);
        return $resultado;
    }
}
