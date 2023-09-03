<?php

namespace UseCases;

use Entities\Pedido;
use Gateways\PedidoGateway;
use Interfaces\UseCases\PedidoUseCasesInterface;

class PedidoUseCases implements PedidoUseCasesInterface
{
    public function cadastrar(PedidoGateway $pedidoGateway, Pedido $pedido)
    {
        if (empty($pedido->getIdCliente())) {
            retornarRespostaJSON("O campo idCliente é obrigatório.", 400);
            die();
        }

        if (empty($pedido->getProdutos())) {
            retornarRespostaJSON("O campo produtos é obrigatório.", 400);
            die();
        }

        $idPedido = $pedidoGateway->cadastrar($pedido);
        return $idPedido;
    }

    public function obterPedidos(PedidoGateway $pedidoGateway)
    {
        $pedidos = $pedidoGateway->obterPedidos();
        return $pedidos;
    }

    public function atualizarStatusPedido(PedidoGateway $pedidoGateway, int $id, string $status)
    {
        $statusPermitidos = ["recebido", "em_preparacao", "pronto", "finalizado"];
        $statusValido = in_array($status, $statusPermitidos);

        if (empty($id)) {
            retornarRespostaJSON("O campo id é obrigatório.", 400);
            die();
        }

        if (!$statusValido) {
            retornarRespostaJSON("O status informado é inválido.", 400);
            die();
        }

        $pedidoValido = (bool)$pedidoGateway->obterPorId($id);
        if (!$pedidoValido) {
            retornarRespostaJSON("Não foi encontrado um pedido com o ID informado.", 400);
            die();
        }

        $pedidos = $pedidoGateway->atualizarStatusPedido($id, $status);
        return $pedidos;
    }

    public function atualizarStatusPagamentoPedido(PedidoGateway $pedidoGateway, int $id, string $status)
    {
        $statusPermitidos = ["aprovado", "recusado"];
        $statusValido = in_array($status, $statusPermitidos);
        $pedidoValido = (bool)$pedidoGateway->obterPorId($id);

        if (empty($id)) {
            retornarRespostaJSON("O campo id é obrigatório.", 400);
            die();
        }

        if (empty($status)) {
            retornarRespostaJSON("O campo status é obrigatório.", 400);
            die();
        }

        if (!$pedidoValido) {
            retornarRespostaJSON("Não foi encontrado um pedido com o ID informado.", 400);
            die();
        }

        if (!$statusValido) {
            retornarRespostaJSON("O status informado é inválido.", 400);
            die();
        }

        $pedidoValido = (bool)$pedidoGateway->obterPorId($id);
        if (!$pedidoValido) {
            retornarRespostaJSON("Não foi encontrado um pedido com o ID informado.", 400);
            die();
        }

        $pedidos = $pedidoGateway->atualizarStatusPagamentoPedido($id, $status);
        return $pedidos;
    }
    public function obterStatusPagamentoPedido(PedidoGateway $pedidoGateway, int $id)
    {
        if (empty($id)) {
            retornarRespostaJSON("O campo id é obrigatório.", 400);
            die();
        }

        $pedidoValido = (bool)$pedidoGateway->obterPorId($id);

        if (!$pedidoValido) {
            retornarRespostaJSON("Não foi encontrado um pedido com o ID informado.", 400);
            die();
        }

        $pedidos = $pedidoGateway->obterStatusPagamentoPedido($id);
        return $pedidos;
    }
    public function obterPorId(PedidoGateway $pedidoGateway, int $id)
    {
        $pedido = $pedidoGateway->obterPorId($id);
        return $pedido;
    }
}
