<?php

namespace Pagamento\Gateways;

require "./src/Interfaces/Gateways/PedidoGatewayInterface.php";

use Pagamento\Interfaces\DbConnection\DbConnectionInterface;
use Pagamento\Interfaces\Gateways\PedidoGatewayInterface;
use Pagamento\Entities\Pedido;
use PDOException;

class PedidoGateway implements PedidoGatewayInterface
{
    private $repositorioDados;
    private $nomeTabelaPedidos = "pedidos";
    private $nomeTabelaPedidosProdutos = "pedidos_produtos";

    public function __construct(DbConnectionInterface $database)
    {
        $this->repositorioDados = $database;
    }

    public function cadastrar(Pedido $pedido)
    {
        $parametros = [
            "data_criacao" => date('Y-m-y h:s:i'),
            "status" => $pedido->getStatus(),
            "cpf" => $pedido->getCPF(),
            "pagamento_status" => "pendente",
        ];

        if (empty($parametros["cpf"]) || empty($parametros["status"])) {
            return false;
        }

        $idPedido = $this->repositorioDados->inserir($this->nomeTabelaPedidos, $parametros);

        $produtos = $pedido->getProdutos();

        foreach ($produtos as $produto) {
            $parametros = [
                "data_criacao" => date('Y-m-y h:s:i'),
                "pedido_id" => $idPedido,
                "produto_id" => $produto["id"],
                "produto_nome" => $produto["nome"],
                "produto_descricao" => $produto["descricao"],
                "produto_preco" => $produto["preco"],
                "produto_categoria" => $produto["categoria"]
            ];

            $this->repositorioDados->inserir($this->nomeTabelaPedidosProdutos, $parametros);
        }
        return !empty($idPedido) ? (int)$idPedido : false;
    }

    public function buscarPedidosPorCpf($cpf)
    {
        $pedidosFormatados = [];
        $pedidos = $this->repositorioDados->buscarTodosPedidosPorCpf($this->nomeTabelaPedidos, $cpf);

        if (!empty($pedidos)) {
            foreach ($pedidos as $chave => $valor) {

                $pedidosFormatados[] = [
                    "idPedido" => (int)$valor["id"],
                    "cpf" => $valor["cpf"],
                    "dataCriacao" => $valor["data_criacao"],
                    "dataAlteracao" => $valor["data_alteracao"],
                    "status" => $valor["status"],
                    "statusPagamento" => $valor["pagamento_status"],
                    "qtdProdutos" => 0,
                    "precoTotal" => 0,
                    "produtos" => []
                ];
                $campos = [];
                $parametros = [
                    [
                        "campo" => "pedido_id",
                        "valor" => $valor["id"]
                    ]
                ];

                $produtos = $this->repositorioDados->buscarPorParametros($this->nomeTabelaPedidosProdutos, $campos, $parametros);
                $chavePedidoFormatado = array_search($valor["id"], array_column($pedidosFormatados, "idPedido"));

                foreach ($produtos as $produto) {
                    $pedidosFormatados[$chavePedidoFormatado]["produtos"][] = [
                        "id" => (int)$produto["produto_id"],
                        "nome" => $produto["produto_nome"],
                        "descricao" => $produto["produto_descricao"],
                        "preco" =>  number_format((float)$produto["produto_preco"], 2, '.', ''),
                        "categoria" => $produto["produto_categoria"],
                    ];
                    $pedidosFormatados[$chavePedidoFormatado]["precoTotal"] = number_format((float)($pedidosFormatados[$chavePedidoFormatado]["precoTotal"] +  $produto["produto_preco"]), 2, '.', '');
                    $pedidosFormatados[$chavePedidoFormatado]["qtdProdutos"]++;
                }
            }
        }
        return $pedidosFormatados;
    }

    public function excluir(int $id): bool
    {
        $resultado = $this->repositorioDados->excluir($this->nomeTabelaPedidos, $id);
        return $resultado;
    }


    public function atualizarStatusPagamentoPedido($id, $status): bool
    {
        $parametros = [
            "data_alteracao" => date('Y-m-d H:i:s'),
            "pagamento_status" => $status
        ];
        $resultado = $this->repositorioDados->atualizar($this->nomeTabelaPedidos, $id, $parametros);
        return $resultado;
    }

    public function obterPorId($id): array
    {
        $campos = [];
        $parametros = [
            [
                "campo" => "id",
                "valor" => $id
            ]
        ];
        $resultado = $this->repositorioDados->buscarPorParametros($this->nomeTabelaPedidos, $campos, $parametros);

        return $resultado;
    }
}
