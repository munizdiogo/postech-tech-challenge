<?php

namespace usecases;

use core\domain\entities\Pedido;
use gateways\PedidoGateway;

class PedidoUseCases
{
    public function cadastrar(PedidoGateway $pedidoGateway, Pedido $pedido)
    {
       $resultadoCadastro = $pedidoGateway->cadastrar($pedido);
        return $resultadoCadastro;
    }
}
