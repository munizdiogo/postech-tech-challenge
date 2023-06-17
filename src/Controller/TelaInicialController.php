<?php

namespace Controller;

use Service\CadastroPedidoService;

class TelaInicialController
{
    private $cadastroPedidoService;

    public function __construct(CadastroPedidoService $cadastroPedidoService)
    {
        $this->cadastroPedidoService = $cadastroPedidoService;
    }

    public function exibirTelaInicial()
    {
        echo 'escrevendo exibirTelaInicial';
        // Lógica para exibir a tela inicial
        // O cliente poderá se identificar, fazer cadastro ou seguir de forma anônima
    }
}
