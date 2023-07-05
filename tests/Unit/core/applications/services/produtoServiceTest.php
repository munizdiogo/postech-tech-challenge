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
}
