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

    public function cadastrar($dbConnection, array $dados)
    {
        $campos = ["nome", "email", "cpf"];

        foreach ($campos as $campo) {
            if (empty($dados["$campo"])) {
                retornarRespostaJSON("O campo '$campo' é obrigatório.", 400);
                exit;
            }
        }

        $cliente = new Cliente($dados['nome'], $dados['email'], $dados['cpf']);
        $clienteGateway = new ClienteGateway($dbConnection);
        $clienteUseCases = new ClienteUseCases();
        $salvarDados = $clienteUseCases->cadastrar($clienteGateway, $cliente);
        return $salvarDados;
    }

    public function buscarPorCPF($dbConnection, string $cpf)
    {
        if (empty($cpf)) {
            retornarRespostaJSON("O campo CPF é obrigatório.", 400);
            return;
        }

        $cpf = str_replace([".", "-"], "", $cpf);
        $clienteGateway = new ClienteGateway($dbConnection);
        $clienteUseCases = new ClienteUseCases();
        $dados = $clienteUseCases->obterClientePorCPF($clienteGateway, $cpf);
        return $dados;
    }
}
