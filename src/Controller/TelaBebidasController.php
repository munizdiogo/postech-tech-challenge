<?php

namespace Controller;

use Service\CadastroPedidoService;

class TelaBebidasController
{
    private $cadastroPedidoService;

    public function __construct(CadastroPedidoService $cadastroPedidoService)
    {
        $this->cadastroPedidoService = $cadastroPedidoService;
    }

    public function exibirTelaBebidas()
    {
        // Lógica para exibir a lista de bebidas cadastradas
        // Permitir ao cliente selecionar uma bebida
    }
}
