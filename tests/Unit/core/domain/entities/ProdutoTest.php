<?php

use PHPUnit\Framework\TestCase;
use core\domain\entities\Produto;

class ProdutoTest extends TestCase
{
    public function testGetters()
    {
        $nome = "Produto Teste";
        $descricao = "Descrição do Produto Teste";
        $preco = "9.99";
        $categoria = "Categoria Teste";
        $produto = new Produto($nome, $descricao, $preco, $categoria);

        $this->assertEquals($nome, $produto->getNome());
        $this->assertEquals($descricao, $produto->getDescricao());
        $this->assertEquals($preco, $produto->getPreco());
        $this->assertEquals($categoria, $produto->getCategoria());
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $produto->getDataCriacao());
    }

    public function testSetIdEGetId()
    {
        $nome = "Produto Teste";
        $descricao = "Descrição do Produto Teste";
        $preco = "9.99";
        $categoria = "Categoria Teste";
        $produto = new Produto($nome, $descricao, $preco, $categoria);

        $id = "123";
        $produto->setId($id);

        $this->assertEquals($id, $produto->getId());
    }
}
