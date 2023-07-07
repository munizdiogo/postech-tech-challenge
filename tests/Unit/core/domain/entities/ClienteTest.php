<?php
use PHPUnit\Framework\TestCase;
use core\domain\entities\Cliente;

class ClienteTest extends TestCase
{
    public function testGetters()
    {
        $nome = "José";
        $email = "jose@teste.com";
        $cpf = "1234567890";
        $cliente = new Cliente($nome, $email, $cpf);

        $this->assertEquals($nome, $cliente->getNome());
        $this->assertEquals($email, $cliente->getEmail());
        $this->assertEquals($cpf, $cliente->getCpf());
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $cliente->getDataCriacao());
    }
}
