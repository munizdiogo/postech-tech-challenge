<?php

namespace Interfaces\Controllers;

interface PedidoControllerInterface
{
    public function cadastrar($dbConnection, array $dados);
    public function obterPedidos($dbConnection);
    public function obterPorId($dbConnection, $id);
    public function obterStatusPagamentoPedido($dbConnection, $id);
    public function atualizarStatusPedido($dbConnection, $id, $status);
    public function atualizarStatusPagamentoPedido($dbConnection, $id, $status);
}
