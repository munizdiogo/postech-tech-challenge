<?php

use PHPUnit\Framework\TestCase;
use core\domain\entities\PedidoProduto;

class PedidoProdutoTest extends TestCase
{
    public function testGetters()
    {
        $idPedido = "123";
        $idProduto = "456";
        $nomeProduto = "Produto Teste";
        $descricaoProduto = "Descrição do Produto Teste";
        $precoProduto = "9.99";
        $categoriaProduto = "Categoria Teste";
        $dataCriacao = date('Y-m-d H:i:s');
        $pedidoProduto = new PedidoProduto($idPedido, $idProduto, $nomeProduto, $descricaoProduto, $precoProduto, $categoriaProduto, $dataCriacao);

        $this->assertEquals($idPedido, $pedidoProduto->getIdPedido());
        $this->assertEquals($idProduto, $pedidoProduto->getIdProduto());
        $this->assertEquals($nomeProduto, $pedidoProduto->getNomeProduto());
        $this->assertEquals($descricaoProduto, $pedidoProduto->getDescricaoProduto());
        $this->assertEquals($precoProduto, $pedidoProduto->getPrecoProduto());
        $this->assertEquals($categoriaProduto, $pedidoProduto->getCategoriaProduto());
        $this->assertEquals($dataCriacao, $pedidoProduto->getDataCriacao());
    }
}
