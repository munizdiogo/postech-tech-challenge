<?php

namespace gateways;

use core\domain\entities\Produto;
use interfaces\DbConnection;
use interfaces\ProdutoGatewayInterface;
use PDOException;

class ProdutoGateway implements ProdutoGatewayInterface
{
    private $repositorioDados;
    private $nomeTabela = "produtos";

    public function __construct(DbConnection $database)
    {
        $this->repositorioDados = $database;
    }

    public function cadastrar(Produto $produto): bool
    {
        $parametros = [
            "data_criacao" => date('Y-m-y h:s:i'),
            "nome" => $produto->getNome(),
            "descricao" => $produto->getDescricao(),
            "preco" => $produto->getPreco(),
            "categoria" => $produto->getCategoria()
        ];

        $resultado = $this->repositorioDados->inserir($this->nomeTabela, $parametros);
        return $resultado;
    }

    public function atualizar(int $id, Produto $produto): bool
    {
        $parametros = [
            "id" => $id,
            "data_alteracao" => date('Y-m-y h:s:i'),
            "nome" => $produto->getNome(),
            "descricao" => $produto->getDescricao(),
            "preco" => $produto->getPreco(),
            "categoria" => $produto->getCategoria()
        ];

        $resultado = $this->repositorioDados->atualizar($this->nomeTabela, $parametros);
        return $resultado;
    }

    public function excluir(int $id): bool
    {
        $resultado = $this->repositorioDados->excluir($this->nomeTabela, $id);
        return $resultado;
    }

    public function obterPorNome(string $nome): array
    {
        $campos = []; // Todos os campos
        $parametros = [
            [
                "campo" => "nome",
                "valor" => $nome
            ]
        ];
        $resultado = $this->repositorioDados->buscarPorParametros($this->nomeTabela, $campos, $parametros);
        return $resultado[0] ?? [];
    }

    public function obterPorId(string $id): array
    {
        $campos = []; // Todos os campos
        $parametros = [
            [
                "campo" => "id",
                "valor" => $id
            ]
        ];
        $resultado = $this->repositorioDados->buscarPorParametros($this->nomeTabela, $campos, $parametros);
        return $resultado[0] ?? [];
    }

    public function obterPorCategoria(string $categoria): array
    {
        $campos = []; // Todos os campos
        $parametros = [
            [
                "campo" => "categoria",
                "valor" => $categoria
            ]
        ];
        $resultado = $this->repositorioDados->buscarPorParametros($this->nomeTabela, $campos, $parametros);
        return $resultado ?? [];
    }
}
