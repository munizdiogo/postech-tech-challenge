<?php

use PHPUnit\Framework\TestCase;
use Domain\Entities\PedidoDomain;

class PedidoDomainTest extends TestCase
{
    public function testSetNovoPedido()
    {
        $pedidoDomainMock = $this->createMock(PedidoDomain::class);

        $pedidoDomainMock->expects($this->once())
            ->method('setNovoPedido')
            ->with([
                'idCliente' => 1,
                'produtos' => [
                    ['id' => 1, 'nome' => 'Lanche 1', 'descricao' => 'Lanche 1', 'preco' => 10.00, 'categoria' => 'lanche'],
                    ['id' => 2, 'nome' => 'Bebida 1', 'descricao' => 'Bebida 1', 'preco' => 5.00, 'categoria' => 'bebida'],
                ]
            ])
            ->willReturn(true);

        $dadosPedido = [
            'idCliente' => 1,
            'produtos' => [
                ['id' => 1, 'nome' => 'Lanche 1', 'descricao' => 'Lanche 1', 'preco' => 10.00, 'categoria' => 'lanche'],
                ['id' => 2, 'nome' => 'Bebida 1', 'descricao' => 'Bebida 1', 'preco' => 5.00, 'categoria' => 'bebida'],
            ]
        ];

        $resultado = $pedidoDomainMock->setNovoPedido($dadosPedido);

        $this->assertTrue($resultado);
    }

    public function testGetPedidos()
    {
        $pedidoDomainMock = $this->createMock(PedidoDomain::class);

        $pedidoDomainMock->expects($this->once())
            ->method('getPedidos')
            ->willReturn(
                [
                    [
                        "idPedido" => 1,
                        "status" => "recebido",
                        "precoTotal" => 25,
                        "produtos" => [
                            [
                                "id" => "12",
                                "nome" => "Lanche 1",
                                "descricao" => "Pão, hamburger, queijo",
                                "preco" => "20",
                                "categoria" => "lanche"
                            ],
                            [
                                "id" => "13",
                                "nome" => "Bebida 1",
                                "descricao" => "Bebida gelada",
                                "preco" => "5",
                                "categoria" => "bebida"
                            ],
                        ]
                    ]
                ]
            );

        $resultado = $pedidoDomainMock->getPedidos();

        $this->assertEquals([
            [
                "idPedido" => 1,
                "status" => "recebido",
                "precoTotal" => 25,
                "produtos" => [
                    [
                        "id" => "12",
                        "nome" => "Lanche 1",
                        "descricao" => "Pão, hamburger, queijo",
                        "preco" => "20",
                        "categoria" => "lanche"
                    ],
                    [
                        "id" => "13",
                        "nome" => "Bebida 1",
                        "descricao" => "Bebida gelada",
                        "preco" => "5",
                        "categoria" => "bebida"
                    ],
                ]
            ]
        ], $resultado);
    }
}
