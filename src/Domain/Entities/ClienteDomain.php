<?php

namespace Domain\Entities;

use Infrastructure\Database;
use \PDOException;

class ClienteDomain
{
    private $database;
    private $db;

    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->db = $this->database->getConexao();
    }

    public function setNovoCliente(array $dados): bool
    {
        $sql = "INSERT INTO clientes (data_criacao, nome, email, cpf) VALUES (NOW(), :nome, :email, :cpf)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nome", $dados["nome"]);
        $stmt->bindParam(":email", $dados["email"]);
        $stmt->bindParam(":cpf", $dados["cpf"]);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getClientePorCPF(string $cpf)
    {
        $sql = "SELECT id, cpf, nome, email FROM clientes WHERE cpf = :cpf";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":cpf", $cpf);

        try {
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return !empty($result) ? $result : false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getClienteEhValidoPorId(string $id)
    {
        $sql = "SELECT id FROM clientes WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id);

        try {
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return !empty($result);
        } catch (PDOException $e) {
            return false;
        }
    }
}
