<?php

namespace Interfaces\UseCases;

use Entities\Cliente;
use Gateways\ClienteGateway;

interface ClienteUseCasesInterface
{
    public function cadastrar(ClienteGateway $clienteGateway, Cliente $cliente);
    public function obterClientePorCPF(ClienteGateway $clienteGateway, string $cpf);
}
