<?php
header('Content-Type: application/json; charset=utf-8');
require_once 'vendor/autoload.php';
(new Controller\DotEnvEnvironment)->load(__DIR__);

use Controller\ClienteController;
use Controller\ProdutoController;
use Controller\PedidoController;
use Service\ClienteService;
use Service\ProdutoService;
use Service\PedidoService;
use Infrastructure\Database;
use Domain\Entities\ClienteDomain;
use Domain\Entities\ProdutoDomain;
use Domain\Entities\PedidoDomain;

$database = new Database();
$clienteDomain = new ClienteDomain($database);
$produtoDomain = new ProdutoDomain($database);
$pedidoDomain = new PedidoDomain($database);
$clienteService = new ClienteService($clienteDomain);
$produtoService = new ProdutoService($produtoDomain);
$pedidoService = new PedidoService($pedidoDomain);
$clienteController = new ClienteController($clienteService, $clienteDomain);
$produtoController = new ProdutoController($produtoService);
$pedidoController = new PedidoController($pedidoService, $clienteService);

if (!empty($_GET["acao"])) {
    switch ($_GET["acao"]) {
        case "cadastrarCliente":
            $clienteController->cadastrar($_POST);
            break;

        case "obterClientePorCPF":
            $clienteController->buscarClientePorCPF($_GET["cpf"]);
            break;

        case "cadastrarProduto":
            $produtoController->cadastrar($_POST);
            break;

        case "editarProduto":
            $produtoController->editar($_POST);
            break;

        case "excluirProduto":
            $produtoController->excluir($_POST["id"]);
            break;

        case "obterProdutosPorCategoria":
            $produtoController->obterProdutosPorCategoria($_GET["categoria"]);
            break;

        case "cadastrarNovoPedido":
            $jsonDados = file_get_contents("php://input");
            $dados = json_decode($jsonDados, true);
            $pedidoController->cadastrar($dados);
            break;

        case "obterPedidos":
            $pedidoController->obterPedidos();
            break;

        default:
            echo '{
                    "mensagem": "A ação informada é inválida."
                  }';
            http_response_code(400);
    }
}
