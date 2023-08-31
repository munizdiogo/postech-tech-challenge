<?php

namespace interfaces;
use core\domain\entities\Cliente;

interface ClienteGatewayInterface
{
    public function setCliente(Cliente $cliente): bool;
    public function getClientePorCPF(string $cpf);
    public function getClientePorId(int $id);
}
