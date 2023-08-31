<?php

namespace controllers;

use gateways\PedidoGateway;
use core\domain\entities\Pedido;
use usecases\PedidoUseCases;

class PedidoController
{
    public function __construct()
    {
    }

    public function cadastrar($dbConnection, array $dados)
    {
        $idCliente = $dados["idCliente"] ?? "";
        $produtos = $dados["produtos"] ?? [];

        if (empty($idCliente)) {
            retornarRespostaJSON("O campo 'idCliente' é obrigatório.", 400);
            exit;
        }

        if (empty($produtos)) {
            retornarRespostaJSON("O campo 'produtos' é obrigatório.", 400);
            exit;
        }

        $pedidoGateway = new PedidoGateway($dbConnection);
        $pedidoUseCases = new PedidoUseCases();

        $pedido = new Pedido("recebido", $idCliente, $produtos);

        $salvarDados = $pedidoUseCases->cadastrar($pedidoGateway, $pedido);
        return $salvarDados;
    }

    public function obterPedidos()
    {
        // $pedidosFormatados = [];
        // $pedidos = $this->pedidoService->getPedidos();

        // if (!empty($pedidos)) {
        //     foreach ($pedidos as $chave => $valor) {
        //         $pedidosFormatados[] = [
        //             "idPedido" => $valor["id"],
        //             "status" => $valor["status"],
        //             "qtdProdutos" => 0,
        //             "precoTotal" => 0,
        //             "produtos" => []
        //         ];
        //         $produtos = $this->pedidoService->getProdutosPorIdPedido($valor["id"]);
        //         $chavePedidoFormatado = array_search($valor["id"], array_column($pedidosFormatados, "idPedido"));
        //         foreach ($produtos as $produto) {
        //             $pedidosFormatados[$chavePedidoFormatado]["produtos"][] = [
        //                 "id" => $produto["id"],
        //                 "nome" => $produto["nome"],
        //                 "descricao" => $produto["descricao"],
        //                 "preco" =>  number_format((float)$produto["preco"], 2, '.', ''),
        //                 "categoria" => $produto["categoria"],
        //             ];
        //             $pedidosFormatados[$chavePedidoFormatado]["precoTotal"] = number_format((float)($pedidosFormatados[$chavePedidoFormatado]["precoTotal"] +  $produto["preco"]), 2, '.', '');
        //             $pedidosFormatados[$chavePedidoFormatado]["qtdProdutos"]++;
        //         }
        //     }
        //     retornarRespostaJSON($pedidosFormatados, 200);
        // } else {
        //     retornarRespostaJSON("Nenhum pedido encontrado.", 200);
        // }
    }
}
