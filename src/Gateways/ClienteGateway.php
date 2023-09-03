<?php

namespace Gateways;

use Interfaces\dbconnection\DbConnectionInterface;
use Interfaces\Gateways\ClienteGatewayInterface;
use Entities\Cliente;
use PDOException;

class ClienteGateway implements ClienteGatewayInterface
{
    private $repositorioDados;
    private $nomeTabela = "clientes";

    public function __construct(DbConnectionInterface $database)
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

    public function obterClientePorCPF(string $cpf): array
    {
        $campos = []; 
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
