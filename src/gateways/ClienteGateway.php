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

    public function setCliente(Cliente $cliente): bool
    {
        $parametros = [
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

    public function getClientePorCPF(string $cpf)
    {
        $parametros = [
            "nome" => $cliente->getNome(),
            "email" => $cliente->getEmail(),
            "cpf" =>  $cliente->getCpf()
        ];

        $resultado = $this->repositorioDados->inserir($this->nomeTabela, $parametros);
        return $resultado;


        // $sql = "SELECT id, cpf, nome, email FROM clientes WHERE cpf = :cpf";
        // $stmt = $this->db->prepare($sql);
        // $stmt->bindParam(":cpf", $cpf);

        // try {
        //     $stmt->execute();
        //     $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        //     return !empty($result) ? $result : false;
        // } catch (PDOException $e) {
        //     return false;
        // }
    }
}
