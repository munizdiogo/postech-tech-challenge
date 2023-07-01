<?php

namespace Domain\Entities;

use Infrastructure\Database;
use \PDOException;


class PedidoDomain
{
    private $database;
    private $db;

    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->db = $this->database->getConexao();
    }

    public function setNovoPedido(array $dados)
    {
        $sql = "INSERT INTO pedidos (data_criacao, status, cliente_id) VALUES(NOW(), 'recebido', :idCliente);";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":idCliente", $dados["idCliente"]);

        try {
            $stmt->execute();
            $idPedido = $this->db->lastInsertId();

            $sql = "";

            if (!empty($dados["produtos"])) {
                $sql .= "INSERT INTO pedidos_produtos (data_criacao, pedido_id, produto_id, produto_nome, produto_descricao, produto_preco, produto_categoria) VALUES ";
            }

            foreach ($dados["produtos"] as $chave => $valor) {
                $sql .= "(NOW(), $idPedido, '{$valor['id']}', '{$valor['nome']}', '{$valor['descricao']}', '{$valor['preco']}', '{$valor['categoria']}'),";

                if ($chave == count($dados["produtos"]) - 1) {
                    $sql = substr($sql, 0, -1);
                }
            }

            $this->db->exec($sql);
            return $idPedido;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getPedidos(): array
    {
        $sql = "SELECT * FROM pedidos";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getProdutosPorIdPedido(int $idPedido): array
    {
        $sql = "SELECT produto_id AS 'id', produto_nome AS 'nome', produto_descricao AS 'descricao', produto_preco AS 'preco', produto_categoria AS 'categoria'
                FROM pedidos_produtos
                WHERE pedido_id = :idPedido";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":idPedido", $idPedido);
        try {
            $stmt->execute();
            $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $resultado ? $resultado : [];
        } catch (PDOException $e) {
            return [];
        }
    }
}
