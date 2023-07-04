<?php

use PHPUnit\Framework\TestCase;
use core\applications\services\ClienteService;
use core\domain\entities\Cliente;

class ClienteServiceTest extends TestCase
{
    public function testCadastrarCliente()
    {
        $clienteDomainMock = $this->createMock(ClienteService::class);

        $clienteEntity = new Cliente('José', 'jose@teste.com', '12345678900');

        $clienteDomainMock->expects($this->once())
            ->method('cadastrarCliente')
            ->with($clienteEntity)
            ->willReturn(true);


        $resultado = $clienteDomainMock->cadastrarCliente($clienteEntity);

        $this->assertTrue($resultado);
    }

    public function testObterClientePorCpf()
    {
        $clienteDomainMock = $this->createMock(ClienteService::class);

        $clienteDomainMock->expects($this->once())
            ->method('obterClientePorCPF')
            ->with('12345678900')
            ->willReturn(['id' => 1, 'cpf' => '12345678900', 'nome' => 'José', 'email' => 'jose@teste.com']);

        $resultado = $clienteDomainMock->obterClientePorCPF('12345678900');

        $this->assertEquals(['id' => 1, 'cpf' => '12345678900', 'nome' => 'José', 'email' => 'jose@teste.com'], $resultado);
    }

    public function testObterClientePorCpfNaoEncontrado()
    {
        $clienteDomainMock = $this->createMock(ClienteService::class);

        $clienteDomainMock->expects($this->once())
            ->method('obterClientePorCPF')
            ->with('123456789001')
            ->willReturn([]);

        $resultado = $clienteDomainMock->obterClientePorCPF('123456789001');

        $this->assertEquals([], $resultado);
    }
}
