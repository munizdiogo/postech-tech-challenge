<?php

use PHPUnit\Framework\TestCase;
use controllers\ClienteController;
use interfaces\gateways;

class ClienteControllerTest extends TestCase
{
    public function testsetClienteComSucesso()
    {
        $ClienteGatewayMock = $this->createMock(ClienteGatewayInterface::class);

        $ClienteGatewayMock->expects($this->once())
            ->method('getClientePorCPF')
            ->willReturn(false);

        $ClienteGatewayMock->expects($this->once())
            ->method('setCliente')
            ->willReturn(true);

        $clienteController = new ClienteController($ClienteGatewayMock);

        $dados = [
            'nome' => 'João',
            'email' => 'joao@example.com',
            'cpf' => '12345678901',
        ];

        $clienteController->cadastrar($dados);

        $this->expectOutputString('{"mensagem":"Cliente criado com sucesso."}');
    }

    public function testsetClienteErroAoSalvarDados()
    {
        $ClienteGatewayMock = $this->createMock(ClienteGatewayInterface::class);

        $ClienteGatewayMock->expects($this->once())
            ->method('getClientePorCPF')
            ->willReturn(false);

        $ClienteGatewayMock->expects($this->once())
            ->method('setCliente')
            ->willReturn(false);

        $clienteController = new ClienteController($ClienteGatewayMock);

        $dados = [
            'nome' => 'João',
            'email' => 'joao@example.com',
            'cpf' => '12345678901',
        ];

        $clienteController->cadastrar($dados);

        $this->expectOutputString('{"mensagem":"Ocorreu um erro ao salvar os dados do cliente."}');
    }

    public function testsetClienteJaCadastrado()
    {
        $ClienteGatewayMock = $this->createMock(ClienteGatewayInterface::class);

        $ClienteGatewayMock->expects($this->once())
            ->method('getClientePorCPF')
            ->willReturn(true);

        $clienteController = new ClienteController($ClienteGatewayMock);

        $dados = [
            'nome' => 'João',
            'email' => 'joao@example.com',
            'cpf' => '12345678901',
        ];

        $clienteController->cadastrar($dados);
        $this->expectOutputString('{"mensagem":"Já existe um cliente cadastrado com este CPF."}');
    }

    public function testsetClienteComCamposObrigatoriosNaoPreenchidos()
    {
        $ClienteGatewayMock = $this->createMock(ClienteGatewayInterface::class);
        $clienteController = new ClienteController($ClienteGatewayMock);

        $dados = [
            'nome' => '',
            'email' => 'joao@example.com',
            'cpf' => '12345678901',
        ];

        $clienteController->cadastrar($dados);

        $this->expectOutputString('{"mensagem":"O campo \'nome\' é obrigatório."}');
    }

    public function testBuscarClientePorCpfComCampoObrigatorioNaoPreenchido()
    {
        $ClienteGatewayMock = $this->createMock(ClienteGatewayInterface::class);
        $clienteController = new ClienteController($ClienteGatewayMock);
        $clienteController->buscarClientePorCPF('');
        $this->expectOutputString('{"mensagem":"O campo CPF é obrigatório."}');
    }

    public function testBuscarClientePorCpf()
    {
        $ClienteGatewayMock = $this->createMock(ClienteGatewayInterface::class);

        $ClienteGatewayMock->expects($this->once())
            ->method('getClientePorCPF')
            ->willReturn(['nome' => 'João', 'email' => 'joao@example.com', 'cpf' => '12345678901']);

        $clienteController = new ClienteController($ClienteGatewayMock);

        $clienteController->buscarClientePorCPF('123.456.789-01');

        $this->expectOutputString('{"nome":"João","email":"joao@example.com","cpf":"12345678901"}');
    }

    public function testBuscarClientePorCpfNaoEncontrado()
    {
        $ClienteGatewayMock = $this->createMock(ClienteGatewayInterface::class);

        $ClienteGatewayMock->expects($this->once())
            ->method('getClientePorCPF')
            ->willReturn([]);

        $clienteController = new ClienteController($ClienteGatewayMock);

        $clienteController->buscarClientePorCPF('123456789015');

        $this->expectOutputString('{"mensagem":"Nenhum cliente encontrado com o CPF informado."}');
    }
}
