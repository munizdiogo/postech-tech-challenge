<?php

namespace Entities;
use Interfaces\Entities\ClienteInterface;

class Cliente implements ClienteInterface
{
    private String $nome;
    private String $email;
    private String $cpf;

    public function __construct(string $nome, string $email, string $cpf)
    {
        $this->nome = $nome;
        $this->email = $email;
        $this->cpf = $cpf;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }
}
