<?php

namespace Domain\Interfaces;

use Domain\Entities\Cliente;

interface ClienteServiceInterface
{
    public function cadastrarCliente(Cliente $cliente): bool;
    public function obterClientePorCPF(string $cpf);
    public function validarClientePorId(int $id);
}
