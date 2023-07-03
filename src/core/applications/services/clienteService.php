<?php

namespace core\applications\services;

use core\applications\ports\ClienteServiceInterface;
use core\domain\entities\Cliente;
use PDOException;

class ClienteService implements ClienteServiceInterface
{
    private $database;
    private $db;

    public function __construct()
    {
        $database = new Database;
        $this->database = $database;
        $this->db = $this->database->getConexao();
    }

    public function cadastrarCliente(Cliente $cliente): bool
    {
        $_nome = $cliente->getNome();
        $_email = $cliente->getEmail();
        $_cpf = $cliente->getCpf();
        
        $sql = "INSERT INTO clientes (data_criacao, nome, email, cpf) VALUES (NOW(), :nome, :email, :cpf)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nome", $_nome);
        $stmt->bindParam(":email", $_email);
        $stmt->bindParam(":cpf", $_cpf);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function validarClientePorId(int $id)
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

    public function obterClientePorCPF(string $cpf)
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
}
