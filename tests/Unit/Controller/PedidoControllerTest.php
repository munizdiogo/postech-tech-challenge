<?php

use Controller\PedidoController;
use PHPUnit\Framework\TestCase;
use Service\PedidoService;
use Service\ClienteService;

class PedidoControllerTest extends TestCase
{
    public function testCadastrar(): void
    {
        $dados = [
            "idCliente" => 1,
            "produtos" => [
                ["id" => 1, "descricao" => "Produto 1", "preco" => 10.0, "categoria" => "lanche"],
                ["id" => 2, "descricao" => "Produto 2", "preco" => 20.0, "categoria" => "sobremesa"]
            ]
        ];

        $pedidoServiceMock = $this->createMock(PedidoService::class);
        $clienteServiceMock = $this->createMock(ClienteService::class);
        $pedidoServiceMock->expects($this->once())
            ->method('cadastrarPedido')
            ->with($dados)
            ->willReturn(1);
        $clienteServiceMock->expects($this->once())
            ->method('validarClientePorId')
            ->with(1)
            ->willReturn(true);

        $pedidoController = new PedidoController($pedidoServiceMock, $clienteServiceMock);

        $pedidoController->cadastrar($dados);

        $this->expectOutputString('{"id":1,"mensagem":"Pedido criado com sucesso."}');
    }

    public function testCadastrarComIdClienteInvalido(): void
    {
        $dados = [
            "idCliente" => "3215613216151432",
            "produtos" => [
                ["id" => 1, "descricao" => "Produto 1", "preco" => 10.0, "categoria" => "lanche"],
                ["id" => 2, "descricao" => "Produto 2", "preco" => 20.0, "categoria" => "sobremesa"]
            ]
        ];

        $pedidoServiceMock = $this->createMock(PedidoService::class);
        $clienteServiceMock = $this->createMock(ClienteService::class);
        $clienteServiceMock->expects($this->once())
            ->method('validarClientePorId')
            ->with("3215613216151432")
            ->willReturn(false);

        $pedidoController = new PedidoController($pedidoServiceMock, $clienteServiceMock);

        $pedidoController->cadastrar($dados);

        $this->expectOutputString('{"mensagem":"O ID do cliente informado é inválido."}');
    }

    public function testObterPedidos(): void
    {
        $pedidos = [
            [
                "id" => 1,
                "data_criacao" => "2023-01-01 00:00:00",
                "data_alteracao" => NULL,
                "status" => "recebido",
                "cliente_id" => "1"
            ],
            [
                "id" => 2,
                "data_criacao" => "2023-01-02 00:00:00",
                "data_alteracao" => NULL,
                "status" => "recebido",
                "cliente_id" => "1"
            ]
        ];

        $produtosIdPedido1 = [
            [
                "id" => 1,
                "nome" => "Produto 1",
                "descricao" => "Pão, hambuguer, queijo",
                "preco" => 10,
                "categoria" => "Categoria 1"
            ],
            [
                "id" => 2,
                "nome" => "Produto 2",
                "descricao" => "Bebida Gelada",
                "preco" => 5,
                "categoria" => "Categoria 2"
            ]
        ];

        $produtosIdPedido2 = [
            [
                "id" => 1,
                "nome" => "Produto 1",
                "descricao" => "Salame e pepperroni",
                "preco" => 20,
                "categoria" => "Categoria 1"
            ],
            [
                "id" => 2,
                "nome" => "Produto 2",
                "descricao" => "Vinho tinto suave",
                "preco" => 30,
                "categoria" => "Categoria 2"
            ]
        ];

        $pedidoServiceMock = $this->createMock(PedidoService::class);
        $clienteServiceMock = $this->createMock(ClienteService::class);

        $pedidoServiceMock->expects($this->once())
            ->method('obterPedidos')
            ->willReturn($pedidos);

        $pedidoServiceMock->expects($this->exactly(2))
            ->method('obterProdutosPorIdPedido')
            ->withConsecutive([1], [2])
            ->willReturnOnConsecutiveCalls($produtosIdPedido1, $produtosIdPedido2);

        $pedidoController = new PedidoController($pedidoServiceMock, $clienteServiceMock);

        $pedidoController->obterPedidos();

        $this->expectOutputString('[{"idPedido":1,"status":"recebido","qtdProdutos":2,"precoTotal":"15.00","produtos":[{"id":1,"nome":"Produto 1","descricao":"Pão, hambuguer, queijo","preco":"10.00","categoria":"Categoria 1"},{"id":2,"nome":"Produto 2","descricao":"Bebida Gelada","preco":"5.00","categoria":"Categoria 2"}]},{"idPedido":2,"status":"recebido","qtdProdutos":2,"precoTotal":"50.00","produtos":[{"id":1,"nome":"Produto 1","descricao":"Salame e pepperroni","preco":"20.00","categoria":"Categoria 1"},{"id":2,"nome":"Produto 2","descricao":"Vinho tinto suave","preco":"30.00","categoria":"Categoria 2"}]}]');
    }
}
