<?php

use PHPUnit\Framework\TestCase;
use controllers\PedidoController;
use core\application\ports\PedidoGatewayInterface;
use interfaces\gateways;

class PedidoControllerTest extends TestCase
{
    public function testCadastrarPedidoComSucesso()
    {
        $dados = [
            "idCliente" => "123",
            "produtos" => [
                [
                    "id" => "1",
                    "nome" => "Produto 1",
                    "descricao" => "Descrição do Produto 1",
                    "preco" => 9,
                    "categoria" => "Categoria 1"
                ],
                [
                    "id" => "2",
                    "nome" => "Produto 2",
                    "descricao" => "Descrição do Produto 2",
                    "preco" => 10,
                    "categoria" => "Categoria 2"
                ]
            ]
        ];

        $ClienteGatewayMock = $this->createMock(ClienteGatewayInterface::class);
        $pedidoServiceMock = $this->createMock(PedidoGatewayInterface::class);

        $ClienteGatewayMock->expects($this->once())
            ->method('getClientePorId')
            ->with($this->equalTo("123"))
            ->willReturn(true);

        $pedidoServiceMock->expects($this->once())
            ->method('setNovoPedido')
            ->willReturn(1);

        $pedidoController = new PedidoController($pedidoServiceMock, $ClienteGatewayMock);

        $pedidoController->cadastrar($dados);

        $this->expectOutputString('{"id":1,"mensagem":"Pedido criado com sucesso."}');
    }

    public function testCadastrarPedidoComErro()
    {
        $dados = [
            "idCliente" => "123",
            "produtos" => [
                [
                    "id" => "1",
                    "nome" => "Produto 1",
                    "descricao" => "Descrição do Produto 1",
                    "preco" => 9,
                    "categoria" => "Categoria 1"
                ],
                [
                    "id" => "2",
                    "nome" => "Produto 2",
                    "descricao" => "Descrição do Produto 2",
                    "preco" => 10,
                    "categoria" => "Categoria 2"
                ]
            ]
        ];

        $ClienteGatewayMock = $this->createMock(ClienteGatewayInterface::class);
        $pedidoServiceMock = $this->createMock(PedidoGatewayInterface::class);

        $ClienteGatewayMock->expects($this->once())
            ->method('getClientePorId')
            ->with($this->equalTo("123"))
            ->willReturn(true);

        $pedidoServiceMock->expects($this->once())
            ->method('setNovoPedido')
            ->willReturn(false);

        $pedidoController = new PedidoController($pedidoServiceMock, $ClienteGatewayMock);

        $pedidoController->cadastrar($dados);

        $this->expectOutputString('{"mensagem":"Ocorreu um erro ao salvar os dados do pedido."}');
    }

    public function testCadastrarPedidoComCamposObrigatoriosVazios()
    {
        $dados = [
            "idCliente" => "123",
            "produtos" => []
        ];

        $ClienteGatewayMock = $this->createMock(ClienteGatewayInterface::class);
        $pedidoServiceMock = $this->createMock(PedidoGatewayInterface::class);
        $pedidoController = new PedidoController($pedidoServiceMock, $ClienteGatewayMock);

        $pedidoController->cadastrar($dados);

        $this->expectOutputString('{"mensagem":"Os campos \'idCliente\' e \'produtos\' são obrigatórios."}');
    }

    public function testCadastrarPedidoComIdDoClienteInvalido()
    {
        $dados = [
            "idCliente" => "123",
            "produtos" => [
                [
                    "id" => "1",
                    "nome" => "Produto 1",
                    "descricao" => "Descrição do Produto 1",
                    "preco" => 9,
                    "categoria" => "Categoria 1"
                ],
                [
                    "id" => "2",
                    "nome" => "Produto 2",
                    "descricao" => "Descrição do Produto 2",
                    "preco" => 10,
                    "categoria" => "Categoria 2"
                ]
            ]
        ];

        $ClienteGatewayMock = $this->createMock(ClienteGatewayInterface::class);
        $pedidoServiceMock = $this->createMock(PedidoGatewayInterface::class);

        $ClienteGatewayMock->expects($this->once())
            ->method('getClientePorId')
            ->with($this->equalTo("123"))
            ->willReturn(false);

        $pedidoController = new PedidoController($pedidoServiceMock, $ClienteGatewayMock);

        $pedidoController->cadastrar($dados);

        $this->expectOutputString('{"mensagem":"O ID do cliente informado é inválido."}');
    }

    public function testObterPedidosComPedidosEncontrados()
    {
        $pedidos = [
            [
                "id" => 1,
                "status" => "recebido"
            ],
            [
                "id" => 2,
                "status" => "recebido"
            ]
        ];

        $produtosPedido1 = [
            [
                "id" => 1,
                "nome" => "Produto 1",
                "descricao" => "Descrição do Produto 1",
                "preco" => 10.99,
                "categoria" => "Categoria 1"
            ],
            [
                "id" => 2,
                "nome" => "Produto 2",
                "descricao" => "Descrição do Produto 2",
                "preco" => 20.99,
                "categoria" => "Categoria 2"
            ]
        ];

        $produtosPedido2 = [
            [
                "id" => 3,
                "nome" => "Produto 3",
                "descricao" => "Descrição do Produto 3",
                "preco" => 15.99,
                "categoria" => "Categoria 1"
            ]
        ];

        $ClienteGatewayMock = $this->createMock(ClienteGatewayInterface::class);
        $pedidoServiceMock = $this->createMock(PedidoGatewayInterface::class);

        $pedidoServiceMock->expects($this->once())
            ->method('getPedidos')
            ->willReturn($pedidos);

        $pedidoServiceMock->expects($this->exactly(2))
            ->method('getProdutosPorIdPedido')
            ->willReturnMap([
                [1, $produtosPedido1],
                [2, $produtosPedido2]
            ]);

        $pedidoController = new PedidoController($pedidoServiceMock, $ClienteGatewayMock);

        $pedidoController->obterPedidos();

        $this->expectOutputString('[{"idPedido":1,"status":"recebido","qtdProdutos":2,"precoTotal":"31.98","produtos":[{"id":1,"nome":"Produto 1","descricao":"Descrição do Produto 1","preco":"10.99","categoria":"Categoria 1"},{"id":2,"nome":"Produto 2","descricao":"Descrição do Produto 2","preco":"20.99","categoria":"Categoria 2"}]},{"idPedido":2,"status":"recebido","qtdProdutos":1,"precoTotal":"15.99","produtos":[{"id":3,"nome":"Produto 3","descricao":"Descrição do Produto 3","preco":"15.99","categoria":"Categoria 1"}]}]');
    }

    public function testObterPedidosComNenhumPedidoEncontrado()
    {
        $ClienteGatewayMock = $this->createMock(ClienteGatewayInterface::class);
        $pedidoServiceMock = $this->createMock(PedidoGatewayInterface::class);

        $pedidoServiceMock->expects($this->once())
            ->method('getPedidos')
            ->willReturn([]);

        $pedidoController = new PedidoController($pedidoServiceMock, $ClienteGatewayMock);

        $pedidoController->obterPedidos();

        $this->expectOutputString('{"mensagem":"Nenhum pedido encontrado."}');
    }
}
