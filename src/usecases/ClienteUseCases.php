<?php

namespace usecases;

use core\domain\entities\Cliente;
use gateways\ClienteGateway;

class ClienteUseCases
{
    public function cadastrarCliente(ClienteGateway $clienteGateway, Cliente $cliente)
    {
        $cpf = $cliente->getCpf();
        $clienteJaCadastrado = $clienteGateway->getClientePorCPF($cpf);

        if ($clienteJaCadastrado) {
            retornarRespostaJSON("Já existe um cliente cadastrado com este CPF.", 409);
            return;
        }

        $resultadoCadastro = $clienteGateway->setCliente($cliente);
        return $resultadoCadastro;
    }
}
