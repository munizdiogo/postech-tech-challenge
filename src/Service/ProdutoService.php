<?php

namespace Service;

use Domain\Entities\ProdutoDomain;

class ProdutoService
{
    private $produtoDomain;

    public function __construct(ProdutoDomain $produtoDomain)
    {
        $this->produtoDomain = $produtoDomain;
    }

    public function cadastrar(array $dados)
    {
        return $this->produtoDomain->setNovoProduto($dados);
    }

    public function editar(array $dados)
    {
        return $this->produtoDomain->setProduto($dados);
    }

    public function excluir(int $id)
    {
        return $this->produtoDomain->setExcluirProdutoPorId($id);
    }

    public function obterProdutosPorCategoria(string $categoria)
    {
        return $this->produtoDomain->getProdutosPorCategoria($categoria);
    }
    
    public function obterProdutoPorNome(string $nome)
    {
        return $this->produtoDomain->getProdutoPorNome($nome);
    }

    public function obterProdutoPorId(string $id)
    {
        return $this->produtoDomain->getProdutoPorId($id);
    }
}
