<?php

use core\application\services\PedidoService;
use core\domain\entities\Pedido;
use core\domain\entities\Produto;
use PHPUnit\Framework\TestCase;

class PedidoServiceTest extends TestCase
{

    public function testGetProdutosPorIdPedido(): void
    {

        $pedidoServiceMock = $this->createMock(PedidoService::class);
        $idPedido = '1';

        $pedidoServiceMock->expects($this->once())
            ->method('getProdutosPorIdPedido')
            ->with($idPedido)
            ->willReturn(['id' => 1, 'nome' => 'Lanche 1', 'descricao' => 'Descrição Lanche 1', 'preco' => 10.0, 'categoria' => 'lanche']);

        $resultado = $pedidoServiceMock->getProdutosPorIdPedido($idPedido);

        $this->assertEquals(['id' => 1, 'nome' => 'Lanche 1', 'descricao' => 'Descrição Lanche 1', 'preco' => 10.0, 'categoria' => 'lanche'], $resultado);
    }

    public function testGetProdutosPorIdPedidoComProdutosNaoEncontrados(): void
    {

        $pedidoServiceMock = $this->createMock(PedidoService::class);
        $idPedido = '1';

        $pedidoServiceMock->expects($this->once())
            ->method('getProdutosPorIdPedido')
            ->with($idPedido)
            ->willReturn([]);

        $resultado = $pedidoServiceMock->getProdutosPorIdPedido($idPedido);

        $this->assertEquals([], $resultado);
    }

    public function testGetPedidos(): void
    {

        $pedidoServiceMock = $this->createMock(PedidoService::class);

        $pedidoServiceMock->expects($this->once())
            ->method('getPedidos')
            ->willReturn(['id' => 1, 'data_criacao' => '2023-06-25 18:00:00', 'data_alteracao' => '2023-06-25 18:00:00', 'status' => 'realizado', 'cliente_id' => 1]);

        $resultado = $pedidoServiceMock->getPedidos();

        $this->assertEquals(['id' => 1, 'data_criacao' => '2023-06-25 18:00:00', 'data_alteracao' => '2023-06-25 18:00:00', 'status' => 'realizado', 'cliente_id' => 1], $resultado);
    }

    public function testGetPedidosComNenhumPedidoEncontrado(): void
    {

        $pedidoServiceMock = $this->createMock(PedidoService::class);

        $pedidoServiceMock->expects($this->once())
            ->method('getPedidos')
            ->willReturn([]);

        $resultado = $pedidoServiceMock->getPedidos();

        $this->assertEquals([], $resultado);
    }

    public function testSetNovoPedidoComSucesso()
    {
        $pedidoDomainMock = $this->createMock(PedidoService::class);

        $produdo1 = new Produto('Hamburguer', 'Hamburguer de carne', 19.20, 'lanche');
        $produdo2 = new Produto('Hamburguer-X', 'Hamburguer-X de carne', 22.50, 'lanche');
        $pedidoEntity = new Pedido('recebido', 1, [$produdo1, $produdo2]);

        $pedidoDomainMock->expects($this->once())
            ->method('setNovoPedido')
            ->with($pedidoEntity)
            ->willReturn(true);

        $resultado = $pedidoDomainMock->setNovoPedido($pedidoEntity);

        $this->assertTrue($resultado);
    }

    public function testSetNovoPedidoComErro()
    {
        $pedidoDomainMock = $this->createMock(PedidoService::class);

        $produdo1 = new Produto('Hamburguer', 'Hamburguer de carne', 19.20, 'lanche');
        $produdo2 = new Produto('Hamburguer-X', 'Hamburguer-X de carne', 22.50, 'lanche');
        $pedidoEntity = new Pedido('recebido', 1, [$produdo1, $produdo2]);

        $pedidoDomainMock->expects($this->once())
            ->method('setNovoPedido')
            ->with($pedidoEntity)
            ->willReturn(false);

        $resultado = $pedidoDomainMock->setNovoPedido($pedidoEntity);

        $this->assertFalse($resultado);
    }
}
