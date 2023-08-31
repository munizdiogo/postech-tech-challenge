<?php

use PHPUnit\Framework\TestCase;
use gateways\Database;
class DatabaseTest extends TestCase
{
    public function testGetConexao()
    {
        $database = new Database;
        $conn = $database->getConexao();
        $this->assertInstanceOf(PDO::class, $conn);
    }
}
