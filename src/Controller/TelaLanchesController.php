<?php

namespace Controller;

use Service\CadastroPedidoService;

class TelaLanchesController
{
    private $cadastroPedidoService;

    public function __construct(CadastroPedidoService $cadastroPedidoService)
    {
        $this->cadastroPedidoService = $cadastroPedidoService;
    }

    public function exibirTelaLanches()
    {
        echo 'escrevendo lanches';
        // Lógica para exibir a lista de lanches cadastrados
        // Permitir ao cliente selecionar um lanche
    }
}
