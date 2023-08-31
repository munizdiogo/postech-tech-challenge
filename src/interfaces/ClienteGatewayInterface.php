<?php

namespace interfaces;
use core\domain\entities\Cliente;

interface ClienteGatewayInterface
{
    public function cadastrar(Cliente $cliente): bool;
    public function obterClientePorCPF(string $cpf);
    public function getClientePorId(int $id);
}
