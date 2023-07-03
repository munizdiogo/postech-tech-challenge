<?php

namespace core\applications\ports;

use core\domain\Cliente;

interface ClienteServiceInterface
{
    public function cadastrarCliente(Cliente $cliente): bool;
    public function obterClientePorCPF(string $cpf);
    public function validarClientePorId(int $id);
}
