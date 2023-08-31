<?php

namespace gateways;

use core\domain\entities\Cliente;
use interfaces\DbConnection;
use interfaces\ClienteGatewayInterface;
use PDOException;

class ClienteGateway implements ClienteGatewayInterface
{
    private $repositorioDados;
    private $nomeTabela = "clientes";

    public function __construct(DbConnection $database)
    {
        $this->repositorioDados = $database;
    }

    public function cadastrar(Cliente $cliente): bool
    {
        $parametros = [
            "data_criacao" => date('Y-m-y h:s:i'),
            "nome" => $cliente->getNome(),
            "email" => $cliente->getEmail(),
            "cpf" =>  $cliente->getCpf()
        ];

        $resultado = $this->repositorioDados->inserir($this->nomeTabela, $parametros);
        return $resultado;
    }

    public function getClientePorId(int $id)
    {
        // $sql = "SELECT id FROM clientes WHERE id = :id";
        // $stmt = $this->db->prepare($sql);
        // $stmt->bindParam(":id", $id);

        // try {
        //     $stmt->execute();
        //     $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        //     return !empty($result);
        // } catch (PDOException $e) {
        //     return false;
        // }
    }

    public function obterClientePorCPF(string $cpf)
    {
        $campos = []; // Todos os campos
        $parametros = [
            [
                "campo" => "cpf",
                "valor" => $cpf
            ]
        ];
        $resultado = $this->repositorioDados->buscarPorParametros($this->nomeTabela, $campos, $parametros);
        return $resultado[0] ?? [];
    }
}
