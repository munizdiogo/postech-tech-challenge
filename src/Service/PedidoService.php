<?php

namespace Service;

use Domain\Entities\PedidoDomain;

class PedidoService
{
    private $pedidoDomain;

    public function __construct(PedidoDomain $pedidoDomain)
    {
        $this->pedidoDomain = $pedidoDomain;
    }

    public function cadastrarPedido(array $dados)
    {
        return $this->pedidoDomain->setNovoPedido($dados);
    }

    public function obterPedidos()
    {
        return $this->pedidoDomain->getPedidos();
    }

    public function obterProdutosPorIdPedido(int $idPedido)
    {
        return $this->pedidoDomain->getProdutosPorIdPedido($idPedido);
    }
}
