<?php

use PHPUnit\Framework\TestCase;
use Controller\ClienteController;
use Service\ClienteService;

class ClienteControllerTest extends TestCase
{
    public function testCadastrar(): void
    {
        $dados = [
            "nome" => "Jose",
            "email" => "jose@teste.com",
            "cpf" => "1234567890"
        ];

        $clienteServiceMock = $this->createMock(ClienteService::class);
        $clienteServiceMock->method('obterClientePorCPF')->willReturn(null);
        $clienteServiceMock->method('cadastrarCliente')->willReturn(true);

        $clienteController = new ClienteController($clienteServiceMock);

        $clienteController->cadastrar($dados);

        $this->expectOutputString('{"mensagem":"Cliente criado com sucesso."}');
    }

    public function testBuscarClientePorCPF(): void
    {
        $cpf = "12345678900";

        $clienteServiceMock = $this->createMock(ClienteService::class);
        $clienteServiceMock->method('obterClientePorCPF')->willReturn(['nome' => 'Jose', 'email' => 'jose@teste.com']);

        $clienteController = new ClienteController($clienteServiceMock);

        $clienteController->buscarClientePorCPF($cpf);

        $this->expectOutputString('{"nome":"Jose","email":"jose@teste.com"}');
    }
}
