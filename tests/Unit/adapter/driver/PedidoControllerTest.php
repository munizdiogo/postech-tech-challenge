<?php

use PHPUnit\Framework\TestCase;
use adapter\driver\PedidoController;
use core\application\ports\pedidoServiceInterface;
use core\application\ports\ClienteServiceInterface;

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

        $clienteServiceMock = $this->createMock(ClienteServiceInterface::class);
        $pedidoServiceMock = $this->createMock(PedidoServiceInterface::class);

        $clienteServiceMock->expects($this->once())
            ->method('validarClientePorId')
            ->with($this->equalTo("123"))
            ->willReturn(true);

        $pedidoServiceMock->expects($this->once())
            ->method('setNovoPedido')
            ->willReturn(1);

        $pedidoController = new PedidoController($pedidoServiceMock, $clienteServiceMock);

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

        $clienteServiceMock = $this->createMock(ClienteServiceInterface::class);
        $pedidoServiceMock = $this->createMock(PedidoServiceInterface::class);

        $clienteServiceMock->expects($this->once())
            ->method('validarClientePorId')
            ->with($this->equalTo("123"))
            ->willReturn(true);

        $pedidoServiceMock->expects($this->once())
            ->method('setNovoPedido')
            ->willReturn(false);

        $pedidoController = new PedidoController($pedidoServiceMock, $clienteServiceMock);

        $pedidoController->cadastrar($dados);

        $this->expectOutputString('{"mensagem":"Ocorreu um erro ao salvar os dados do pedido."}');
    }

    public function testCadastrarPedidoComCamposObrigatoriosVazios()
    {
        $dados = [
            "idCliente" => "123",
            "produtos" => []
        ];

        $clienteServiceMock = $this->createMock(ClienteServiceInterface::class);
        $pedidoServiceMock = $this->createMock(PedidoServiceInterface::class);
        $pedidoController = new PedidoController($pedidoServiceMock, $clienteServiceMock);

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

        $clienteServiceMock = $this->createMock(ClienteServiceInterface::class);
        $pedidoServiceMock = $this->createMock(PedidoServiceInterface::class);

        $clienteServiceMock->expects($this->once())
            ->method('validarClientePorId')
            ->with($this->equalTo("123"))
            ->willReturn(false);

        $pedidoController = new PedidoController($pedidoServiceMock, $clienteServiceMock);

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

        $clienteServiceMock = $this->createMock(ClienteServiceInterface::class);
        $pedidoServiceMock = $this->createMock(PedidoServiceInterface::class);

        $pedidoServiceMock->expects($this->once())
            ->method('getPedidos')
            ->willReturn($pedidos);

        $pedidoServiceMock->expects($this->exactly(2))
            ->method('getProdutosPorIdPedido')
            ->willReturnMap([
                [1, $produtosPedido1],
                [2, $produtosPedido2]
            ]);

        $pedidoController = new PedidoController($pedidoServiceMock, $clienteServiceMock);

        $pedidoController->obterPedidos();

        $this->expectOutputString('[{"idPedido":1,"status":"recebido","qtdProdutos":2,"precoTotal":"31.98","produtos":[{"id":1,"nome":"Produto 1","descricao":"Descrição do Produto 1","preco":"10.99","categoria":"Categoria 1"},{"id":2,"nome":"Produto 2","descricao":"Descrição do Produto 2","preco":"20.99","categoria":"Categoria 2"}]},{"idPedido":2,"status":"recebido","qtdProdutos":1,"precoTotal":"15.99","produtos":[{"id":3,"nome":"Produto 3","descricao":"Descrição do Produto 3","preco":"15.99","categoria":"Categoria 1"}]}]');
    }

    public function testObterPedidosComNenhumPedidoEncontrado()
    {
        $clienteServiceMock = $this->createMock(ClienteServiceInterface::class);
        $pedidoServiceMock = $this->createMock(PedidoServiceInterface::class);

        $pedidoServiceMock->expects($this->once())
            ->method('getPedidos')
            ->willReturn([]);

        $pedidoController = new PedidoController($pedidoServiceMock, $clienteServiceMock);

        $pedidoController->obterPedidos();

        $this->expectOutputString('{"mensagem":"Nenhum pedido encontrado."}');
    }
}
