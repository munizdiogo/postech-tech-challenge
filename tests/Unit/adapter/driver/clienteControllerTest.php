<?php

use PHPUnit\Framework\TestCase;
use adapter\driver\ClienteController;
use core\application\ports\clienteServiceInterface;

class ClienteControllerTest extends TestCase
{
    public function testCadastrarClienteComSucesso()
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

    public function testCadastrarClienteErroAoSalvarDados()
    {
        $clienteServiceMock = $this->createMock(ClienteServiceInterface::class);

        $clienteServiceMock->expects($this->once())
            ->method('obterClientePorCPF')
            ->willReturn(false);

        $clienteServiceMock->expects($this->once())
            ->method('cadastrarCliente')
            ->willReturn(false);

        $clienteController = new ClienteController($clienteServiceMock);

        $dados = [
            'nome' => 'João',
            'email' => 'joao@example.com',
            'cpf' => '12345678901',
        ];

        $clienteController->cadastrar($dados);

        $this->expectOutputString('{"mensagem":"Ocorreu um erro ao salvar os dados do cliente."}');
    }

    public function testCadastrarClienteJaCadastrado()
    {
        $clienteServiceMock = $this->createMock(ClienteServiceInterface::class);

        $clienteServiceMock->expects($this->once())
            ->method('obterClientePorCPF')
            ->willReturn(true);

        $clienteController = new ClienteController($clienteServiceMock);

        $dados = [
            'nome' => 'João',
            'email' => 'joao@example.com',
            'cpf' => '12345678901',
        ];

        $clienteController->cadastrar($dados);
        $this->expectOutputString('{"mensagem":"Já existe um cliente cadastrado com este CPF."}');
    }

    public function testCadastrarClienteComCamposObrigatoriosNaoPreenchidos()
    {
        $clienteServiceMock = $this->createMock(ClienteServiceInterface::class);
        $clienteController = new ClienteController($clienteServiceMock);

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
        $clienteServiceMock = $this->createMock(ClienteServiceInterface::class);
        $clienteController = new ClienteController($clienteServiceMock);
        $clienteController->buscarClientePorCPF('');
        $this->expectOutputString('{"mensagem":"O campo CPF é obrigatório."}');
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
