<?php

namespace Domain\Entities;

use Domain\Entities\Produto;

class Pedido
{

    private string $id;
    private string $status;
    private string $idCliente;
    // private string $dataCriacao;
    private array $produtos;

    public function __construct(string $status, string $idCliente, array $produtos = [])
    {
        $this->status = $status;
        $this->idCliente = $idCliente;
        $this->produtos = $produtos;
    }


    public function getId(): string
    {
        return $this->id;
    }


    public function getStatus(): string
    {
        return $this->status;
    }


    public function getIdCliente(): string
    {
        return $this->idCliente;
    }



    public function getProdutos(): array
    {
        return $this->produtos;
    }
}
