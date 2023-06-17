<?php

namespace Service;

use Infrastructure\Database;

class CadastroPedidoService
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function cadastrarPedido($cliente, $lanche, $complementos, $bebida)
    {
        // Lógica para cadastrar o pedido no banco de dados
        // Utilize o objeto $this->db para realizar as operações no banco de dados
    }
}
