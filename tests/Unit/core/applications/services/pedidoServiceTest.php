<?php

use core\applications\services\PedidoService;
use core\domain\entities\Pedido;
use core\domain\entities\Produto;
use PHPUnit\Framework\TestCase;

class PedidoServiceTest extends TestCase
{

    public function testGetProdutosPorIdPedido(): void
    {
    
        $oedidoServiceMock = $this->createMock(PedidoService::class);
        $idPedido = '1';

        $oedidoServiceMock->expects($this->once())
            ->method('getProdutosPorIdPedido')
            ->with($idPedido)
            ->willReturn(['id' => 1, 'nome' => 'Lanche 1', 'descricao' => 'Descrição Lanche 1', 'preco' => 10.0, 'categoria' => 'lanche']);

        $resultado = $oedidoServiceMock->getProdutosPorIdPedido($idPedido);

        $this->assertEquals(['id' => 1, 'nome' => 'Lanche 1', 'descricao' => 'Descrição Lanche 1', 'preco' => 10.0, 'categoria' => 'lanche'], $resultado);
    }

   
}
