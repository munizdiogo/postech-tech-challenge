<?php

use PHPUnit\Framework\TestCase;
use Domain\Entities\PedidoDomain;
use Service\PedidoService;

class PedidoServiceTest extends TestCase
{
    public function testCadastrarPedido()
    {
        $pedidoDomainMock = $this->createMock(PedidoDomain::class);

        $pedidoDomainMock->expects($this->once())
            ->method('setNovoPedido')
            ->with([
                'idCliente' => 1,
                'produtos' => [
                    ['id' => 1, 'categoria' => 'lanche', 'descricao' => 'Lanche 1', 'preco' => 10.00],
                    ['id' => 2, 'categoria' => 'bebida', 'descricao' => 'Bebida 1', 'preco' => 5.00],
                ]
            ])
            ->willReturn(true);

        $pedidoService = new PedidoService($pedidoDomainMock);

        $dadosPedido = [
            'idCliente' => 1,
            'produtos' => [
                ['id' => 1, 'categoria' => 'lanche', 'descricao' => 'Lanche 1', 'preco' => 10.00],
                ['id' => 2, 'categoria' => 'bebida', 'descricao' => 'Bebida 1', 'preco' => 5.00],
            ]
        ];

        $resultado = $pedidoService->cadastrarPedido($dadosPedido);

        $this->assertTrue($resultado);
    }

    public function testObterPedidos()
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
                                "descricao" => "Lanche 1",
                                "preco" => "20",
                                "categoria" => "lanche"
                            ],
                            [
                                "id" => "13",
                                "descricao" => "Bebida 1",
                                "preco" => "5",
                                "categoria" => "bebida"
                            ],
                        ]
                    ]
                ]
            );

        $pedidoService = new PedidoService($pedidoDomainMock);

        $resultado = $pedidoService->obterPedidos();

        $this->assertEquals([
            [
                "idPedido" => 1,
                "status" => "recebido",
                "precoTotal" => 25,
                "produtos" => [
                    [
                        "id" => "12",
                        "descricao" => "Lanche 1",
                        "preco" => "20",
                        "categoria" => "lanche"
                    ],
                    [
                        "id" => "13",
                        "descricao" => "Bebida 1",
                        "preco" => "5",
                        "categoria" => "bebida"
                    ],
                ]
            ]
        ], $resultado);
    }
}
