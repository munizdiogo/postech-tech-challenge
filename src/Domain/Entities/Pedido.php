<?php

namespace Domain\Entities;

class Pedido
{

    private string $status;
    private string $idCliente;
    private string $dataCriacao;

    public function __construct($status, $idCliente, $dataCriacao)
    {
        $this->status = $status;
        $this->idCliente = $idCliente;
        $this->dataCriacao = $dataCriacao;
    }


    public function getStatus(): string
    {
        return $this->status;
    }


    public function getIdCliente(): string
    {
        return $this->idCliente;
    }


    public function getDataCriacao(): string
    {
        return $this->dataCriacao;
    }
}
