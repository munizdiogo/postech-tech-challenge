<?php

use PHPUnit\Framework\TestCase;
use gateways\ClienteGateway;
use core\domain\entities\Cliente;

class ClienteGatewayTest extends TestCase
{
    public function testcadastrarComSucesso()
    {
        $clienteDomainMock = $this->createMock(ClienteGateway::class);

        $clienteEntity = new Cliente('José', 'jose@teste.com', '12345678900');

        $clienteDomainMock->expects($this->once())
            ->method('cadastrar')
            ->with($clienteEntity)
            ->willReturn(true);


        $resultado = $clienteDomainMock->cadastrar($clienteEntity);

        $this->assertTrue($resultado);
    }

    public function testcadastrarComErro()
    {
        $clienteDomainMock = $this->createMock(ClienteGateway::class);

        $clienteEntity = new Cliente('José', 'jose@teste.com', '12345678900');

        $clienteDomainMock->expects($this->once())
            ->method('cadastrar')
            ->with($clienteEntity)
            ->willReturn(false);


        $resultado = $clienteDomainMock->cadastrar($clienteEntity);

        $this->assertFalse($resultado);
    }

    public function testobterClientePorCPF()
    {
        $clienteDomainMock = $this->createMock(ClienteGateway::class);

        $clienteDomainMock->expects($this->once())
            ->method('obterClientePorCPF')
            ->with('12345678900')
            ->willReturn(['id' => 1, 'cpf' => '12345678900', 'nome' => 'José', 'email' => 'jose@teste.com']);

        $resultado = $clienteDomainMock->obterClientePorCPF('12345678900');

        $this->assertEquals(['id' => 1, 'cpf' => '12345678900', 'nome' => 'José', 'email' => 'jose@teste.com'], $resultado);
    }

    public function testobterClientePorCPFNaoEncontrado()
    {
        $clienteDomainMock = $this->createMock(ClienteGateway::class);

        $clienteDomainMock->expects($this->once())
            ->method('obterClientePorCPF')
            ->with('123456789001')
            ->willReturn([]);

        $resultado = $clienteDomainMock->obterClientePorCPF('123456789001');

        $this->assertEquals([], $resultado);
    }

    public function testgetClientePorIdComSucesso()
    {
        $clienteDomainMock = $this->createMock(ClienteGateway::class);

        $clienteDomainMock->expects($this->once())
            ->method('getClientePorId')
            ->with('123')
            ->willReturn(true);

        $resultado = $clienteDomainMock->getClientePorId('123');

        $this->assertTrue($resultado);
    }

    public function testgetClientePorIdComErro()
    {
        $clienteDomainMock = $this->createMock(ClienteGateway::class);

        $clienteDomainMock->expects($this->once())
            ->method('getClientePorId')
            ->with('123')
            ->willReturn(false);

        $resultado = $clienteDomainMock->getClientePorId('123');

        $this->assertFalse($resultado);
    }
}
