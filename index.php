<?php
require_once 'vendor/autoload.php';

use Controller\TelaInicialController;
use Controller\TelaLanchesController;
use Controller\TelaComplementosController;
use Controller\TelaBebidasController;
use Controller\TelaPagamentoController;
use Service\CadastroPedidoService;
use Infrastructure\Database;
use Infrastructure\MercadoPagoAPI;

// Configuração do banco de dados


$db = new Database;

// Configuração da API do MercadoPago
$apiKey = 'SUA_CHAVE_DO_MERCADOPAGO';
$mercadoPagoAPI = new MercadoPagoAPI($apiKey);

// Configuração do serviço de cadastro de pedido
$cadastroPedidoService = new CadastroPedidoService($db);

// Configuração dos controllers
$telaInicialController = new TelaInicialController($cadastroPedidoService);
$telaLanchesController = new TelaLanchesController($cadastroPedidoService);
$telaComplementosController = new TelaComplementosController($cadastroPedidoService);
$telaBebidasController = new TelaBebidasController($cadastroPedidoService);
$telaPagamentoController = new TelaPagamentoController($cadastroPedidoService, $mercadoPagoAPI);

// Rotas
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['page'])) {
    if ($_GET['page'] === 'inicial') {
        $telaInicialController->exibirTelaInicial();
    } elseif ($_GET['page'] === 'lanches') {
        $telaLanchesController->exibirTelaLanches();
    } elseif ($_GET['page'] === 'complementos') {
        $telaComplementosController->exibirTelaComplementos();
    } elseif ($_GET['page'] === 'bebidas') {
        $telaBebidasController->exibirTelaBebidas();
    } elseif ($_GET['page'] === 'pagamento') {
        $telaPagamentoController->exibirTelaPagamento();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lógica para tratar os dados enviados pelos formulários
    // e avançar para a próxima tela
} else {
    echo 'página não encontrada';
}
