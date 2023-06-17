<?php

namespace Infrastructure;

class MercadoPagoAPI
{
    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function gerarQrCode($valor)
    {
        // Lógica para gerar o QrCode utilizando a API do MercadoPago
    }
}
