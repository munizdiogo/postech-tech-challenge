<?php

namespace controllers;

use core\domain\entities\Cliente;
use gateways\ClienteGateway;
use usecases\ClienteUseCases;

include("src/utils/respostasJson.php");

class ClienteController
{

    public function __construct()
    {
    }

    public function cadastrarCliente($dbConnection, array $dados)
    {
        $campos = ["nome", "email", "cpf"];

        foreach ($campos as $campo) {
            if (empty($dados["$campo"])) {
                retornarRespostaJSON("O campo '$campo' é obrigatório.", 400);
                return;
            }
        }

        $cliente = new Cliente($dados['nome'], $dados['email'], $dados['cpf']);
        $clienteGateway = new ClienteGateway($dbConnection);
        $clienteUseCases = new ClienteUseCases();

        $salvarDados = $clienteUseCases->cadastrarCliente($clienteGateway, $cliente);



        return $salvarDados;
    }

    public function buscarClientePorCPF(string $cpf): void
    {
        if (empty($cpf)) {
            retornarRespostaJSON("O campo CPF é obrigatório.", 400);
            return;
        }

        $cpf = str_replace([".", "-"], "", $cpf);

        $dadosCliente = $this->ClienteGateway->getClientePorCPF($cpf);

        $resposta = !empty($dadosCliente) ? $dadosCliente : "Nenhum cliente encontrado com o CPF informado.";

        retornarRespostaJSON($resposta, 200);
    }
}
