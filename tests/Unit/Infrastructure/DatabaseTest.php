<?php

use Infrastructure\Database;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    public function testGetConexao()
    {
        $database = new Database();
        $conexao = $database->getConexao();
        $this->assertInstanceOf(PDO::class, $conexao);
    }
}
