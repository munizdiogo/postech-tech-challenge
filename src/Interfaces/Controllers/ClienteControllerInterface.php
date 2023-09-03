<?php

namespace Interfaces\Controllers;

interface ClienteControllerInterface
{
    public function cadastrar($dbConnection, array $dados);
    public function buscarPorCPF($dbConnection, string $cpf);
}
