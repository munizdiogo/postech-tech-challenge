<?php

use PHPUnit\Framework\TestCase;
use core\applications\services\Database;

class DatabaseTest extends TestCase
{
    public function testGetConexao()
    {
        $database = new Database();
        $conexao = $database->getConexao();
        $this->assertInstanceOf(PDO::class, $conexao);
    }
}
