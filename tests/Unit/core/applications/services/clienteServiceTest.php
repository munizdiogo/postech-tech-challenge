<?php

use PHPUnit\Framework\TestCase;
use core\applications\services\ClienteService;

class ClienteServiceTest extends TestCase
{
    public function testCadastrarCliente()
    {
        $clienteDomainMock = $this->createMock(ClienteService::class);

        $clienteDomainMock->expects($this->once())
            ->method('setNovoCliente')
            ->with(['cpf' => '12345678900', 'nome' => 'José', 'email' => 'jose@teste.com'])
            ->willReturn(true);

        $clienteService = new ClienteService($clienteDomainMock);

        $dadosCliente = ['cpf' => '12345678900', 'nome' => 'José', 'email' => 'jose@teste.com'];

        $resultado = $clienteService->cadastrarCliente($dadosCliente);

        $this->assertTrue($resultado);
    }

    public function testObterClientePorCPF()
    {
        $clienteDomainMock = $this->createMock(ClienteService::class);

        $clienteDomainMock->expects($this->once())
            ->method('getClientePorCPF')
            ->with('12345678900')
            ->willReturn(['cpf' => '12345678900', 'nome' => 'José', 'email' => 'jose@teste.com']);

        $clienteService = new ClienteService($clienteDomainMock);

        $resultado = $clienteService->obterClientePorCPF('12345678900');

        $this->assertEquals(['cpf' => '12345678900', 'nome' => 'José', 'email' => 'jose@teste.com'], $resultado);
    }
}
