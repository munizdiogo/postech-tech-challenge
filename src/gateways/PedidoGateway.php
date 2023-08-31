<?php

namespace gateways;

use interfaces\PedidoGatewayInterface;
use interfaces\DbConnection;
use core\domain\entities\Pedido;
use PDOException;

class PedidoGateway implements PedidoGatewayInterface
{
    private $repositorioDados;
    private $nomeTabela = "pedidos";

    public function __construct(DbConnection $database)
    {
        $this->repositorioDados = $database;
    }

    public function cadastrar(Pedido $pedido)
    {
        $parametros = [
            "data_criacao" => date('Y-m-y h:s:i'),
            "status" => 'recebido',
            "cliente_id" => $pedido->getIdCliente(),
        ];

        $salvarDadosPedido = $this->repositorioDados->inserir($this->nomeTabela, $parametros);

        $idPedido =  $this->repositorioDados->obterUltimoId();

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

        $resultado = $this->repositorioDados->inserir($this->nomeTabela, $parametros);
        return $resultado;
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
