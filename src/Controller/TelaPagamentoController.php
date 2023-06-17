<?php

namespace Controller;

use Service\CadastroPedidoService;
use Infrastructure\MercadoPagoAPI;

class TelaPagamentoController
{
    private $cadastroPedidoService;
    private $mercadoPagoAPI;

    public function __construct(CadastroPedidoService $cadastroPedidoService, MercadoPagoAPI $mercadoPagoAPI)
    {
        $this->cadastroPedidoService = $cadastroPedidoService;
        $this->mercadoPagoAPI = $mercadoPagoAPI;
    }

    public function exibirTelaPagamento()
    {
        // Lógica para exibir a tela de pagamento com o QrCode
        // Gerar o QrCode utilizando a API do MercadoPago
    }
}
