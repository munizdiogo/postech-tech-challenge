<?php

namespace Domain\Entities;

use Infrastructure\Database;
use \PDOException;

class ProdutoDomain
{
    private $database;
    private $db;

    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->db = $this->database->getConexao();
    }

    public function setNovoProduto(array $dados): bool
    {
        $sql = "INSERT INTO produtos (data_criacao, nome, descricao, preco, categoria) VALUES(NOW(), :nome, :descricao, :preco, :categoria);";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nome", $dados["nome"]);
        $stmt->bindParam(":descricao", $dados["descricao"]);
        $stmt->bindParam(":preco", $dados["preco"]);
        $stmt->bindParam(":categoria", $dados["categoria"]);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function setProduto(array $dados): bool
    {
        $sql = "UPDATE produtos SET data_alteracao = NOW(), nome = :nome, descricao = :descricao, preco = :preco, categoria = :categoria WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nome", $dados["nome"]);
        $stmt->bindParam(":descricao", $dados["descricao"]);
        $stmt->bindParam(":preco", $dados["preco"]);
        $stmt->bindParam(":categoria", $dados["categoria"]);
        $stmt->bindParam(":id", $dados["id"]);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function setExcluirProdutoPorId(int $id): bool
    {
        $sql = "DELETE FROM produtos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getProdutosPorCategoria(string $categoria): array
    {
        $sql = "SELECT * FROM produtos WHERE categoria = :categoria";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":categoria", $categoria);
        try {
            $stmt->execute();
            $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return (count($resultado) > 0) ? $resultado : [];
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getProdutoPorNome(string $nome): array
    {
        $sql = "SELECT * FROM produtos WHERE nome = :nome";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nome", $nome);
        try {
            $stmt->execute();
            $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $resultado ? $resultado : [];
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function getProdutoPorId(string $id): array
    {
        $sql = "SELECT * FROM produtos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id);
        try {
            $stmt->execute();
            $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $resultado ? $resultado : [];
        } catch (PDOException $e) {
            return [];
        }
    }
}
