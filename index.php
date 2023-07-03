<?php
header('Content-Type: application/json; charset=utf-8');
require_once 'vendor/autoload.php';


(new Controller\DotEnvEnvironment)->load(__DIR__);

use Controller\AutenticacaoController;
use Controller\ClienteController;
use Controller\ProdutoController;
use Controller\PedidoController;
use Service\ClienteService;
use Service\ProdutoService;
use Service\PedidoService;

use Firebase\JWT\Key;

$clienteService = new ClienteService();
$clienteController = new ClienteController($clienteService);

$produtoService = new ProdutoService();
$produtoController = new ProdutoController($produtoService);

$pedidoService = new PedidoService();
$pedidoController = new PedidoController($pedidoService, $clienteService);

$autenticacaoController = new AutenticacaoController();



$chaveSecreta = $_ENV['CHAVE_SECRETA'];



if (isset($_GET['acao']) && $_GET['acao'] == 'gerar') {
    if ($GLOBALS['chaveSecreta'] == $_POST['chaveSecreta']) {
        echo $autenticacaoController->gerarTokenJWT('', $_POST['chaveSecreta']);
    }
} else {
    $retornoValidacaoAcesso = validarAcesso();
    $jsonRetornoValidacaoAcesso = json_decode($retornoValidacaoAcesso);


    if ($jsonRetornoValidacaoAcesso->status) {

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
                    echo '{"mensagem": "A ação informada é inválida."}';
                    http_response_code(400);
            }
        }
    } else {
        echo $retornoValidacaoAcesso;
    }
}




function validarAcesso()
{
    http_response_code(401);

    $headers = getallheaders();
    $token = isset($headers['Authorization']) ? $headers['Authorization'] : null;

    if ($token) {
        $autenticacaoController = new AutenticacaoController();
        $retorno = $autenticacaoController->validarTokenJWT($headers['Authorization'], new Key($GLOBALS['chaveSecreta'], 'HS256'));
        $dados = json_encode($retorno);
        $dadosUsuario = json_decode($dados, true);

        if ($dadosUsuario) {
            if ($dadosUsuario == 'Expired token') {
                return json_encode(array('status' => false, 'mensagem' => 'Token expirado'));
            } else {
                if (http_response_code() == 200) {
                    return json_encode(array('status' => true, 'mensagem' => $dadosUsuario));
                } else {
                    return json_encode(array('status' => false, 'mensagem' => 'Token nao encontrado'));
                }
            }
        } else {
            return json_encode(array('status' => false, 'mensagem' => 'Token nao encontrado'));
        }
    } else {
        return json_encode(array('status' => false, 'mensagem' => 'Token nao encontrado'));
    }
}
