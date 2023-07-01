<?php

namespace Controller;

use Service\PedidoService;
use Service\ClienteService;

class PedidoController
{
    private $pedidoService;
    private $clienteService;

    public function __construct(PedidoService $pedidoService, ClienteService $clienteService)
    {
        $this->pedidoService = $pedidoService;
        $this->clienteService = $clienteService;
    }

    public function cadastrar(array $dados): void
    {
        $idCliente = $dados["idCliente"] ?? "";
        $produtos = $dados["produtos"] ?? [];

        if (empty($idCliente) || empty($produtos)) {
            retornarRespostaJSON("Os campos 'idCliente' e 'produtos' são obrigatórios.", 400);
            return;
        }

        $clienteValido = $this->clienteService->validarClientePorId($idCliente);

        if ($clienteValido) {
            $idPedido = $this->pedidoService->cadastrarPedido($dados);
            if ($idPedido) {
                retornarRespostaJSON(["id" => $idPedido, "mensagem" => "Pedido criado com sucesso."], 201);
            } else {
                retornarRespostaJSON("Ocorreu um erro ao salvar os dados do pedido.", 500);
            }
        } else {
            retornarRespostaJSON("O ID do cliente informado é inválido.", 400);
        }
    }

    public function obterPedidos(): void
    {
        $pedidosFormatados = [];
        $pedidos = $this->pedidoService->obterPedidos();

        if (!empty($pedidos)) {
            foreach ($pedidos as $chave => $valor) {
                $pedidosFormatados[] = [
                    "idPedido" => $valor["id"],
                    "status" => $valor["status"],
                    "qtdProdutos" => 0,
                    "precoTotal" => 0,
                    "produtos" => []
                ];
                $produtos = $this->pedidoService->obterProdutosPorIdPedido($valor["id"]);
                $chavePedidoFormatado = array_search($valor["id"], array_column($pedidosFormatados, "idPedido"));
                foreach ($produtos as $produto) {
                    $pedidosFormatados[$chavePedidoFormatado]["produtos"][] = [
                        "id" => $produto["id"],
                        "nome" => $produto["nome"],
                        "descricao" => $produto["descricao"],
                        "preco" =>  number_format((float)$produto["preco"], 2, '.', ''),
                        "categoria" => $produto["categoria"],
                    ];
                    $pedidosFormatados[$chavePedidoFormatado]["precoTotal"] = number_format((float)($pedidosFormatados[$chavePedidoFormatado]["precoTotal"] +  $produto["preco"]), 2, '.', '');
                    $pedidosFormatados[$chavePedidoFormatado]["qtdProdutos"]++;
                }
            }
            retornarRespostaJSON($pedidosFormatados, 200);
        } else {
            retornarRespostaJSON("Nenhum pedido encontrado.", 200);
        }
    }
}
