<?php

namespace core\application\services;

use \PDO;
use \PDOException;
use \adapter\driver\DotEnvEnvironment;

class Database
{
    private $conn;
    public function getConexao()
    {
        $dotEnv = new DotEnvEnvironment();
        $dotEnv->load();
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_NAME'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Erro na conexão com o banco de dados: " . $e->getMessage();
        }

        return $this->conn;
    }
}
