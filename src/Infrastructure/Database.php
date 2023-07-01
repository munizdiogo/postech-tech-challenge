<?php

namespace Infrastructure;
use \PDO;
use \PDOException;

class Database
{
    private $conn;
    private $host = "SERVIDOR-DB";
    private $db_name = "dbpostech";
    private $username = "root";
    private $password = "secret";
    private $port = 3306;

    public function getConexao()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Erro na conexão com o banco de dados: " . $e->getMessage();
        }

        return $this->conn;
    }
}
