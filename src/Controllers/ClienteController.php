<?php

namespace Controllers;

use Entities\Cliente;
use Gateways\ClienteGateway;
use Interfaces\Controllers\ClienteControllerInterface;
use UseCases\ClienteUseCases;

include("src/Utils/RespostasJson.php");

class ClienteController implements ClienteControllerInterface
{
    public function cadastrar($dbConnection, array $dados)
    {
        $nome = $dados['nome'] ?? "";
        $email = $dados['email'] ?? "";
        $cpf = $dados['cpf'] ?? "";
        $cliente = new Cliente($nome, $email, $cpf);
        $clienteGateway = new ClienteGateway($dbConnection);
        $clienteUseCases = new ClienteUseCases();
        $salvarDados = $clienteUseCases->cadastrar($clienteGateway, $cliente);
        return $salvarDados;
    }

    public function buscarPorCPF($dbConnection, string $cpf)
    {
        $cpf = !empty($cpf) ? str_replace([".", "-"], "", $cpf) : "";
        $clienteGateway = new ClienteGateway($dbConnection);
        $clienteUseCases = new ClienteUseCases();
        $dados = $clienteUseCases->obterClientePorCPF($clienteGateway, $cpf);
        return $dados;
    }
}
