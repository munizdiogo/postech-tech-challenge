<?php

namespace Domain\Entities;

class Produto
{
    private string $id;
    private string $nome;
    private string $descricao;
    private string $preco;
    private string $categoria;
    private string $dataCriacao;

    public function __construct($nome, $descricao, $preco, $categoria)
    {
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->preco = $preco;
        $this->categoria = $categoria;
        $this->dataCriacao = date('Y-m-y h:s:i');
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }


    public function getDescricao(): string
    {
        return $this->descricao;
    }


    public function getPreco(): string
    {
        return $this->preco;
    }


    public function getCategoria(): string
    {
        return $this->categoria;
    }


    public function getDataCriacao(): string
    {
        return $this->dataCriacao;
    }
}
