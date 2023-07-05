<?php

namespace core\application\services;

use core\application\ports\ProdutoServiceInterface;
use core\domain\entities\Produto;
use PDOException;

class ProdutoService implements ProdutoServiceInterface
{
    private $database;
    private $db;

    public function __construct()
    {
        $database = new Database;
        $this->database = $database;
        $this->db = $this->database->getConexao();
    }


    public function setNovoProduto(Produto $produto): bool
    {
        $nome = $produto->getNome();
        $descricao = $produto->getDescricao();
        $preco = $produto->getPreco();
        $categoria = $produto->getCategoria();


        $sql = "INSERT INTO produtos (data_criacao, nome, descricao, preco, categoria) VALUES(NOW(), :nome, :descricao, :preco, :categoria);";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":preco", $preco);
        $stmt->bindParam(":categoria", $categoria);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function setProduto(Produto $produto): bool
    {
        $id = $produto->getId();
        $nome = $produto->getNome();
        $descricao = $produto->getDescricao();
        $preco = $produto->getPreco();
        $categoria = $produto->getCategoria();

        $sql = "UPDATE produtos SET data_alteracao = NOW(), nome = :nome, descricao = :descricao, preco = :preco, categoria = :categoria WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":preco", $preco);
        $stmt->bindParam(":categoria", $categoria);
        $stmt->bindParam(":id", $id);

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
