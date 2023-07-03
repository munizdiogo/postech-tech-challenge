<?php

namespace core\domain\entities;

class Cliente
{

    private String $nome;
    private String $email;
    private String $cpf;
    private String $dataCriacao;

    public function __construct(string $nome, string $email, string $cpf)
    {
        $this->nome = $nome;
        $this->email = $email;
        $this->cpf = $cpf;
        $this->dataCriacao = date('Y-m-y h:s:i');
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

    public function getDataCriacao(): String
    {
        return $this->dataCriacao;
    }
}
