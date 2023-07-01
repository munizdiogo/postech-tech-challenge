<?php

use PHPUnit\Framework\TestCase;
use Domain\Entities\ClienteDomain;

class ClienteDomainTest extends TestCase
{
    public function testSetNovoCliente()
    {
        $clienteDomainMock = $this->createMock(ClienteDomain::class);

        $clienteDomainMock->expects($this->once())
            ->method('setNovoCliente')
            ->with(['cpf' => '12345678900', 'nome' => 'José', 'email' => 'jose@teste.com'])
            ->willReturn(true);

        $dadosCliente = ['cpf' => '12345678900', 'nome' => 'José', 'email' => 'jose@teste.com'];

        $resultado = $clienteDomainMock->setNovoCliente($dadosCliente);

        $this->assertTrue($resultado);
    }

    public function testGetClientePorCPF()
    {
        $clienteDomainMock = $this->createMock(ClienteDomain::class);

        $clienteDomainMock->expects($this->once())
            ->method('getClientePorCPF')
            ->with('12345678900')
            ->willReturn(['id' => 1, 'cpf' => '12345678900', 'nome' => 'José', 'email' => 'jose@teste.com']);

        $resultado = $clienteDomainMock->getClientePorCPF('12345678900');

        $this->assertEquals(['id' => 1, 'cpf' => '12345678900', 'nome' => 'José', 'email' => 'jose@teste.com'], $resultado);
    }
}
