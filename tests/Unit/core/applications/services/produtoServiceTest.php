<?php

use PHPUnit\Framework\TestCase;
use core\application\services\ProdutoService;
use core\domain\entities\Produto;

class ProdutoServiceTest extends TestCase
{

    public function testObterProdutosPorCategoria()
    {
        $produtoDomainMock = $this->createMock(ProdutoService::class);
        $nomeCategoria = 'lanche';

        $produtoDomainMock->expects($this->once())
            ->method('getProdutosPorCategoria')
            ->with($nomeCategoria)
            ->willReturn(['id' => 1, 'data_criacao' => '2023-06-26 05:53:00', 'data_alteracao' => null, 'nome' => 'Lanche 1', 'descricao' => 'Pão, hamburger e queijo', 'preco' => 10.50, 'categoria' => 'lanche']);

        $resultado = $produtoDomainMock->getProdutosPorCategoria($nomeCategoria);

        $this->assertEquals(['id' => 1, 'data_criacao' => '2023-06-26 05:53:00', 'data_alteracao' => null, 'nome' => 'Lanche 1', 'descricao' => 'Pão, hamburger e queijo', 'preco' => 10.50, 'categoria' => 'lanche'], $resultado);


    }
    public function testObterProdutosPorId()
    {
        $produtoDomainMock = $this->createMock(ProdutoService::class);
        $nomeCategoria = '1';

        $produtoDomainMock->expects($this->once())
            ->method('getProdutoPorId')
            ->with($nomeCategoria)
            ->willReturn(['id' => 1, 'data_criacao' => '2023-06-26 05:53:00', 'data_alteracao' => null, 'nome' => 'Lanche 1', 'descricao' => 'Pão, hamburger e queijo', 'preco' => 10.50, 'categoria' => 'lanche']);

        $resultado = $produtoDomainMock->getProdutoPorId($nomeCategoria);

        $this->assertEquals(['id' => 1, 'data_criacao' => '2023-06-26 05:53:00', 'data_alteracao' => null, 'nome' => 'Lanche 1', 'descricao' => 'Pão, hamburger e queijo', 'preco' => 10.50, 'categoria' => 'lanche'], $resultado);


    }

    public function testObterProdutoPorNome()
    {
        $produtoDomainMock = $this->createMock(ProdutoService::class);
        $nomeProduto = 'Lanche 1';

        $produtoDomainMock->expects($this->once())
            ->method('getProdutoPorNome')
            ->with($nomeProduto)
            ->willReturn(['id' => 1, 'data_criacao' => '2023-06-26 05:53:00', 'data_alteracao' => null, 'nome' => 'Lanche 1', 'descricao' => 'Pão, hamburger e queijo', 'preco' => 10.50, 'categoria' => 'lanche']);

        $resultado = $produtoDomainMock->getProdutoPorNome($nomeProduto);

        $this->assertEquals(['id' => 1, 'data_criacao' => '2023-06-26 05:53:00', 'data_alteracao' => null, 'nome' => 'Lanche 1', 'descricao' => 'Pão, hamburger e queijo', 'preco' => 10.50, 'categoria' => 'lanche'], $resultado);


    }

    public function testCadastrarNovoProdutoComSucesso()
    {
        $produtoDomainMock = $this->createMock(ProdutoService::class);

        $produtoEntity = new Produto('Hamburguer', 'Hamburguer de carne', 19.20, 'lanche');

        $produtoDomainMock->expects($this->once())
            ->method('setNovoProduto')
            ->with($produtoEntity)
            ->willReturn(true);

        $resultado = $produtoDomainMock->setNovoProduto($produtoEntity);

        $this->assertTrue($resultado);
    }

    public function testEditarProdutoComSucesso()
    {
        $produtoDomainMock = $this->createMock(ProdutoService::class);

        $produtoEntity = new Produto('Hamburguer-X', 'Hamburguer-X de carne', 21.50, 'lanche');

        $produtoDomainMock->expects($this->once())
            ->method('setProduto')
            ->with($produtoEntity)
            ->willReturn(true);

        $resultado = $produtoDomainMock->setProduto($produtoEntity);

        $this->assertTrue($resultado);
    }

    public function testExcluirProdutoComSucesso()
    {
        $produtoDomainMock = $this->createMock(ProdutoService::class);
        $idProdutoMock = 1;

        $produtoDomainMock->expects($this->once())
            ->method('setExcluirProdutoPorId')
            ->with($idProdutoMock)
            ->willReturn(true);

        $resultado = $produtoDomainMock->setExcluirProdutoPorId($idProdutoMock);

        $this->assertTrue($resultado);
    }

}
