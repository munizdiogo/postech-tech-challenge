<?php

namespace core\application\ports;

use core\domain\entities\Cliente;

interface ClienteServiceInterface
{
    public function cadastrarCliente(Cliente $cliente): bool;
    public function obterClientePorCPF(string $cpf);
    public function validarClientePorId(int $id);
}
