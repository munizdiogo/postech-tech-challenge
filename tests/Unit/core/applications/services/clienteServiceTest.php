<?php

use PHPUnit\Framework\TestCase;
use gateways\ClienteGateway;
use core\domain\entities\Cliente;

class ClienteGatewayTest extends TestCase
{
    public function testsetClienteComSucesso()
    {
        $clienteDomainMock = $this->createMock(ClienteGateway::class);

        $clienteEntity = new Cliente('José', 'jose@teste.com', '12345678900');

        $clienteDomainMock->expects($this->once())
            ->method('setCliente')
            ->with($clienteEntity)
            ->willReturn(true);


        $resultado = $clienteDomainMock->setCliente($clienteEntity);

        $this->assertTrue($resultado);
    }

    public function testsetClienteComErro()
    {
        $clienteDomainMock = $this->createMock(ClienteGateway::class);

        $clienteEntity = new Cliente('José', 'jose@teste.com', '12345678900');

        $clienteDomainMock->expects($this->once())
            ->method('setCliente')
            ->with($clienteEntity)
            ->willReturn(false);


        $resultado = $clienteDomainMock->setCliente($clienteEntity);

        $this->assertFalse($resultado);
    }

    public function testgetClientePorCPF()
    {
        $clienteDomainMock = $this->createMock(ClienteGateway::class);

        $clienteDomainMock->expects($this->once())
            ->method('getClientePorCPF')
            ->with('12345678900')
            ->willReturn(['id' => 1, 'cpf' => '12345678900', 'nome' => 'José', 'email' => 'jose@teste.com']);

        $resultado = $clienteDomainMock->getClientePorCPF('12345678900');

        $this->assertEquals(['id' => 1, 'cpf' => '12345678900', 'nome' => 'José', 'email' => 'jose@teste.com'], $resultado);
    }

    public function testgetClientePorCPFNaoEncontrado()
    {
        $clienteDomainMock = $this->createMock(ClienteGateway::class);

        $clienteDomainMock->expects($this->once())
            ->method('getClientePorCPF')
            ->with('123456789001')
            ->willReturn([]);

        $resultado = $clienteDomainMock->getClientePorCPF('123456789001');

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
