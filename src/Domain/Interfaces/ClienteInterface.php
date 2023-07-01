<?php

interface ClienteInterface
{
    public function setNovoCliente(array $dados): bool;
    public function getClientePorCPF(string $cpf);
}
