<?php

namespace UseCases;

use Entities\Cliente;
use Gateways\ClienteGateway;
use Interfaces\UseCases\ClienteUseCasesInterface;

class ClienteUseCases implements ClienteUseCasesInterface
{
    public function cadastrar(ClienteGateway $clienteGateway, Cliente $cliente)
    {
        if (empty($cliente->getNome())) {
            retornarRespostaJSON("O campo nome é obrigatório.", 400);
            die();
        }

        if (empty($cliente->getEmail())) {
            retornarRespostaJSON("O campo email é obrigatório.", 400);
            die();
        }

        if (empty($cliente->getCpf())) {
            retornarRespostaJSON("O campo cpf é obrigatório.", 400);
            die();
        }

        $cpf = $cliente->getCpf();
        $clienteJaCadastrado = $clienteGateway->obterClientePorCPF($cpf);

        if ($clienteJaCadastrado) {
            retornarRespostaJSON("Já existe um cliente cadastrado com este CPF.", 409);
            die();
        }

        $resultadoCadastro = $clienteGateway->cadastrar($cliente);
        return $resultadoCadastro;
    }

    public function obterClientePorCPF(ClienteGateway $clienteGateway, string $cpf)
    {
        if (empty($cpf)) {
            retornarRespostaJSON("O campo cpf é obrigatório.", 400);
            die();
        }
        
        $dados = $clienteGateway->obterClientePorCPF($cpf);
        return $dados;
    }
}
