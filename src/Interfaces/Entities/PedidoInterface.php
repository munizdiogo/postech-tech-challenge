<?php

namespace Interfaces\Entities;

interface PedidoInterface
{
    public function getId(): string;
    public function getStatus(): string;
    public function getIdCliente(): string;
    public function getProdutos(): array;
}
