<?php

namespace Service;

use Domain\Entities\Pedido;
use Domain\Interfaces\PedidoServiceInterface;
use Infrastructure\Database;
use PDOException;

class PedidoService implements PedidoServiceInterface
{
    private $database;
    private $db;

    public function __construct()
    {
        $database = new Database;
        $this->database = $database;
        $this->db = $this->database->getConexao();
    }


    public function setNovoPedido(Pedido $pedido): bool
    {
        $idCliente = $pedido->getIdCliente();
        $produtos = $pedido->getProdutos();


        $sql = "INSERT INTO pedidos (data_criacao, status, cliente_id) VALUES(NOW(), 'recebido', :idCliente);";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":idCliente", $idCliente);

        try {
            $stmt->execute();
            $idPedido = $this->db->lastInsertId();

            $sql = "";

            if (!empty($produtos)) {
                $sql .= "INSERT INTO pedidos_produtos (data_criacao, pedido_id, produto_id, produto_nome, produto_descricao, produto_preco, produto_categoria) VALUES ";
            }

            foreach ($produtos as $chave => $produto) {
                $sql .= "(NOW(), $idPedido, '{$produto->getId()}', '{$produto->getNome()}', '{$produto->getDescricao()}', '{$produto->getPreco()}', '{$produto->getCategoria()}'),";

                if ($chave == count($produtos) - 1) {
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