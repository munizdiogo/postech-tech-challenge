<?php

namespace Controller;

use Service\CadastroPedidoService;

class TelaComplementosController
{
    private $cadastroPedidoService;

    public function __construct(CadastroPedidoService $cadastroPedidoService)
    {
        $this->cadastroPedidoService = $cadastroPedidoService;
    }

    public function exibirTelaComplementos()
    {
        // Lógica para exibir a lista de complementos cadastrados
        // Permitir ao cliente selecionar os complementos
    }
}
