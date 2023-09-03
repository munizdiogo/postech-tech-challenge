<?php

use PHPUnit\Framework\TestCase;
use Entities\Pedido;

class PedidoTest extends TestCase
{
    public function testGetStatus()
    {
        $status = 'recebido';
        $idCliente = '1';
        $produtos = ['Produto A', 'Produto B'];

        $pedido = new Pedido($status, $idCliente, $produtos);

        $this->assertEquals($status, $pedido->getStatus());
    }

    public function testGetIdCliente()
    {
        $status = 'finalizado';
        $idCliente = '2';
        $produtos = ['Produto C', 'Produto D'];

        $pedido = new Pedido($status, $idCliente, $produtos);

        $this->assertEquals($idCliente, $pedido->getIdCliente());
    }

    public function testGetProdutos()
    {
        $status = 'em_preparacao';
        $idCliente = '3';
        $produtos = ['Produto E', 'Produto F'];

        $pedido = new Pedido($status, $idCliente, $produtos);

        $this->assertEquals($produtos, $pedido->getProdutos());
    }
}
