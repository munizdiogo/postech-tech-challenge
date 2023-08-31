<?php

namespace usecases;

use core\domain\entities\Cliente;
use gateways\ClienteGateway;

class ClienteUseCases
{
    public function cadastrar(ClienteGateway $clienteGateway, Cliente $cliente)
    {
        $cpf = $cliente->getCpf();
        $clienteJaCadastrado = $clienteGateway->obterClientePorCPF($cpf);

        if ($clienteJaCadastrado) {
            retornarRespostaJSON("Já existe um cliente cadastrado com este CPF.", 409);
            exit;
        }

        $resultadoCadastro = $clienteGateway->cadastrar($cliente);
        return $resultadoCadastro;
    }

    public function obterClientePorCPF(ClienteGateway $clienteGateway, string $cpf)
    {
        $dados = $clienteGateway->obterClientePorCPF($cpf);
        return $dados;
    }
}
