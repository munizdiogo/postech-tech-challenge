<?php

use PHPUnit\Framework\TestCase;
use controllers\ClienteController;
use interfaces\gateways;

class ClienteControllerTest extends TestCase
{
    public function testcadastrarComSucesso()
    {
        $ClienteGatewayMock = $this->createMock(ClienteGatewayInterface::class);

        $ClienteGatewayMock->expects($this->once())
            ->method('obterClientePorCPF')
            ->willReturn(false);

        $ClienteGatewayMock->expects($this->once())
            ->method('cadastrar')
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

    public function testcadastrarErroAoSalvarDados()
    {
        $ClienteGatewayMock = $this->createMock(ClienteGatewayInterface::class);

        $ClienteGatewayMock->expects($this->once())
            ->method('obterClientePorCPF')
            ->willReturn(false);

        $ClienteGatewayMock->expects($this->once())
            ->method('cadastrar')
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

    public function testcadastrarJaCadastrado()
    {
        $ClienteGatewayMock = $this->createMock(ClienteGatewayInterface::class);

        $ClienteGatewayMock->expects($this->once())
            ->method('obterClientePorCPF')
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

    public function testcadastrarComCamposObrigatoriosNaoPreenchidos()
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

    public function testbuscarPorCPFComCampoObrigatorioNaoPreenchido()
    {
        $ClienteGatewayMock = $this->createMock(ClienteGatewayInterface::class);
        $clienteController = new ClienteController($ClienteGatewayMock);
        $clienteController->buscarPorCPF('');
        $this->expectOutputString('{"mensagem":"O campo CPF é obrigatório."}');
    }

    public function testbuscarPorCPF()
    {
        $ClienteGatewayMock = $this->createMock(ClienteGatewayInterface::class);

        $ClienteGatewayMock->expects($this->once())
            ->method('obterClientePorCPF')
            ->willReturn(['nome' => 'João', 'email' => 'joao@example.com', 'cpf' => '12345678901']);

        $clienteController = new ClienteController($ClienteGatewayMock);

        $clienteController->buscarPorCPF('123.456.789-01');

        $this->expectOutputString('{"nome":"João","email":"joao@example.com","cpf":"12345678901"}');
    }

    public function testbuscarPorCPFNaoEncontrado()
    {
        $ClienteGatewayMock = $this->createMock(ClienteGatewayInterface::class);

        $ClienteGatewayMock->expects($this->once())
            ->method('obterClientePorCPF')
            ->willReturn([]);

        $clienteController = new ClienteController($ClienteGatewayMock);

        $clienteController->buscarPorCPF('123456789015');

        $this->expectOutputString('{"mensagem":"Nenhum cliente encontrado com o CPF informado."}');
    }
}
