<?php

namespace Interfaces\Gateways;

use Entities\Cliente;

interface ClienteGatewayInterface
{
    public function cadastrar(Cliente $cliente): bool;
    public function obterClientePorCPF(string $cpf): array;
}
