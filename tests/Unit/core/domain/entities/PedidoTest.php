<?php

use PHPUnit\Framework\TestCase;
use core\domain\entities\Pedido;

class PedidoTest extends TestCase
{
    public function testGetters()
    {
        $status = "recebido";
        $idCliente = "123";
        $produtos = [
            [
                "nome" => "Produto 1",
                "descricao" => "Descrição do Produto 1",
                "preco" => 10.99,
                "categoria" => "Categoria 1"
            ],
            [
                "nome" => "Produto 2",
                "descricao" => "Descrição do Produto 2",
                "preco" => 19.99,
                "categoria" => "Categoria 2"
            ]
        ];

        $pedido = new Pedido($status, $idCliente, $produtos);

        $this->assertEquals($status, $pedido->getStatus());
        $this->assertEquals($idCliente, $pedido->getIdCliente());
        $this->assertEquals($produtos, $pedido->getProdutos());
    }
}
