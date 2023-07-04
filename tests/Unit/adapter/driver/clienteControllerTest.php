<?php

use PHPUnit\Framework\TestCase;
use adapter\driver\ClienteController;
use core\applications\ports\ClienteServiceInterface;

class ClienteControllerTest extends TestCase
{
    public function testCadastrar()
    {
        $clienteServiceMock = $this->createMock(ClienteServiceInterface::class);

        $clienteServiceMock->expects($this->once())
            ->method('obterClientePorCPF')
            ->willReturn(false);

        $clienteServiceMock->expects($this->once())
            ->method('cadastrarCliente')
            ->willReturn(true);

        $clienteController = new ClienteController($clienteServiceMock);

        $dados = [
            'nome' => 'João',
            'email' => 'joao@example.com',
            'cpf' => '12345678901',
        ];

        $clienteController->cadastrar($dados);

        $this->expectOutputString('{"mensagem":"Cliente criado com sucesso."}');
    }

    public function testBuscarClientePorCpf()
    {
        $clienteServiceMock = $this->createMock(ClienteServiceInterface::class);

        $clienteServiceMock->expects($this->once())
            ->method('obterClientePorCPF')
            ->willReturn(['nome' => 'João', 'email' => 'joao@example.com', 'cpf' => '12345678901']);

        $clienteController = new ClienteController($clienteServiceMock);

        $clienteController->buscarClientePorCPF('123.456.789-01');

        $this->expectOutputString('{"nome":"João","email":"joao@example.com","cpf":"12345678901"}');
    }

    public function testBuscarClientePorCpfNaoEncontrado()
    {
        $clienteServiceMock = $this->createMock(ClienteServiceInterface::class);

        $clienteServiceMock->expects($this->once())
            ->method('obterClientePorCPF')
            ->willReturn([]);

        $clienteController = new ClienteController($clienteServiceMock);

        $clienteController->buscarClientePorCPF('123456789015');

        $this->expectOutputString('{"mensagem":"Nenhum cliente encontrado com o CPF informado."}');
    }
}
