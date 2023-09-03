<?php

use External\MySqlConnection;

header('Content-Type: application/json; charset=utf-8');
require_once 'vendor/autoload.php';

(new Controllers\DotEnvEnvironment)->load();

use Controllers\AutenticacaoController;
use Controllers\ClienteController;
use Controllers\ProdutoController;
use Controllers\PedidoController;
use Gateways\ClienteGateway;
use Gateways\ProdutoGateway;
use Gateways\PedidoGateway;
use Firebase\JWT\Key as Key;

$dbConnection = new MySqlConnection();
$clienteGateway = new ClienteGateway($dbConnection);
$clienteController = new ClienteController();
$produtoGateway = new ProdutoGateway($dbConnection);
$produtoController = new ProdutoController();
$pedidoGateway = new PedidoGateway($dbConnection);
$pedidoController = new PedidoController();

$autenticacaoController = new AutenticacaoController();
$chaveSecreta = $_ENV['CHAVE_SECRETA'] ?? "";

if (isset($_GET['acao']) && $_GET['acao'] == 'gerarToken') {
    if (empty($_POST['chaveSecreta'])) {
        retornarRespostaJSON("É obrigatório informar a chaveSecreta", 401);
        die();
    }

    if ($_POST['chaveSecreta'] == $chaveSecreta) {
        echo $autenticacaoController->gerarTokenJWT('', $_POST['chaveSecreta']);
    }
} else {
    $retornoValidacaoAcesso = validarAcesso();
    $jsonRetornoValidacaoAcesso = json_decode($retornoValidacaoAcesso);

    if ($jsonRetornoValidacaoAcesso->status) {

        if (!empty($_GET["acao"])) {
            switch ($_GET["acao"]) {
                case "cadastrarCliente":
                    $salvarDados = $clienteController->cadastrar($dbConnection, $_POST);
                    if ($salvarDados) {
                        retornarRespostaJSON("Cliente criado com sucesso.", 201);
                    } else {
                        retornarRespostaJSON("Ocorreu um erro ao salvar os dados do cliente.", 500);
                    }
                    break;

                case "obterClientePorCPF":
                    $cpf = $_GET["cpf"] ?? "";
                    $dadosCliente = $clienteController->buscarPorCPF($dbConnection, $cpf);
                    $resposta = !empty($dadosCliente) ? $dadosCliente : "Nenhum cliente encontrado com o CPF informado.";
                    retornarRespostaJSON($resposta, 200);
                    break;

                case "cadastrarProduto":
                    $salvarDados = $produtoController->cadastrar($dbConnection, $_POST);
                    if ($salvarDados) {
                        retornarRespostaJSON("Produto cadastrado com sucesso.", 201);
                    } else {
                        retornarRespostaJSON("Ocorreu um erro ao salvar os dados do produto.", 500);
                    }
                    break;

                case "editarProduto":
                    $atualizarDados = $produtoController->atualizar($dbConnection, $_POST);
                    if ($atualizarDados) {
                        retornarRespostaJSON("Produto atualizado com sucesso.", 200);
                    } else {
                        retornarRespostaJSON("Ocorreu um erro ao atualizar os dados do produto.", 500);
                    }
                    break;

                case "excluirProduto":
                    $id = $_POST["id"] ?? 0;
                    $excluirProduto = $produtoController->excluir($dbConnection, $id);
                    if ($excluirProduto) {
                        retornarRespostaJSON("Produto excluído com sucesso.", 200);
                    } else {
                        retornarRespostaJSON("Ocorreu um erro ao excluir o produto.", 500);
                    }
                    break;

                case "obterProdutosPorCategoria":
                    $categoria = $_GET["categoria"] ?? "";
                    $produtos = $produtoController->obterPorCategoria($dbConnection, $categoria);
                    if (!empty($produtos)) {
                        retornarRespostaJSON($produtos, 200);
                    } else {
                        retornarRespostaJSON("Nenhum produto encontrado nesta categoria.", 200);
                    }
                    break;

                case "cadastrarNovoPedido":
                    $jsonDados = file_get_contents("php://input");
                    $dados = json_decode($jsonDados, true) ?? [];

                    $idPedido = $pedidoController->cadastrar($dbConnection, $dados);

                    if ($idPedido) {
                        retornarRespostaJSON(["id" => $idPedido, "mensagem" => "Pedido criado com sucesso."], 201);
                    } else {
                        retornarRespostaJSON("Ocorreu um erro ao salvar os dados do pedido.", 500);
                    }
                    break;

                case "obterPedidos":
                    $pedidos = $pedidoController->obterPedidos($dbConnection);
                    if (count($pedidos) > 0) {
                        retornarRespostaJSON($pedidos, 200);
                    } else {
                        retornarRespostaJSON("Nenhum pedido encontrado.", 200);
                    }
                    break;

                case "atualizarStatusPedido":
                    $id = !empty($_POST["id"]) ? (int)$_POST["id"] : 0;
                    $status = $_POST["status"] ?? "";
                    $atualizarStatusPedido = $pedidoController->atualizarStatusPedido($dbConnection, $id, $status);

                    if ($atualizarStatusPedido) {
                        retornarRespostaJSON("Status do pedido atualizado com sucesso.", 200);
                    } else {
                        retornarRespostaJSON("Ocorreu um erro ao atualizar o status do pedido.", 500);
                    }
                    break;

                case "atualizarStatusPagamentoPedido":
                    $id = !empty($_POST["id"]) ? (int)$_POST["id"] : 0;
                    $status = $_POST["status"] ?? "";
                    $atualizarStatusPagamentoPedido = $pedidoController->atualizarStatusPagamentoPedido($dbConnection, $id, $status);
                    if ($atualizarStatusPagamentoPedido) {
                        retornarRespostaJSON("Status do pagamento do pedido atualizado com sucesso.", 200);
                    } else {
                        retornarRespostaJSON("Ocorreu um erro ao atualizar o status do pagamento do pedido.", 500);
                    }
                    break;

                case "obterStatusPagamentoPedido":
                    $id = !empty($_GET["id"]) ? (int)$_GET["id"] : 0;
                    $resposta = $pedidoController->obterStatusPagamentoPedido($dbConnection, $id);
                    retornarRespostaJSON($resposta, 200);
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
                    return json_encode(array('status' => false, 'mensagem' => 'Token não encontrado 1'));
                }
            }
        } else {
            return json_encode(array('status' => false, 'mensagem' => 'Token não encontrado 2'));
        }
    } else {
        return json_encode(array('status' => false, 'mensagem' => 'Token não informado'));
    }
}
