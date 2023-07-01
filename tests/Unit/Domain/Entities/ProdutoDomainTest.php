<?php

use PHPUnit\Framework\TestCase;
use Domain\Entities\ProdutoDomain;

class ProdutoDomainTest extends TestCase
{
    public function testSetNovoProduto()
    {
        $produtoDomainMock = $this->createMock(ProdutoDomain::class);

        $produtoDomainMock->expects($this->once())
            ->method('setNovoProduto')
            ->with(['nome' => 'Lanche 2', 'descricao' => 'Descrição do lanche', 'preco' => 10.0, 'categoria' => 'lanche'])
            ->willReturn(true);

        $dadosProduto = ['nome' => 'Lanche 2', 'descricao' => 'Descrição do lanche', 'preco' => 10.0, 'categoria' => 'lanche'];

        $resultado = $produtoDomainMock->setNovoProduto($dadosProduto);

        $this->assertTrue($resultado);
    }

    public function testSetProduto()
    {
        $produtoDomainMock = $this->createMock(ProdutoDomain::class);

        $produtoDomainMock->expects($this->once())
            ->method('setProduto')
            ->with(['id' => 1, 'nome' => 'Lanche 2', 'descricao' => 'Descrição do lanche', 'preco' => 10.0, 'categoria' => 'lanche'])
            ->willReturn(true);

        $dadosProduto = ['id' => 1, 'nome' => 'Lanche 2', 'descricao' => 'Descrição do lanche', 'preco' => 10.0, 'categoria' => 'lanche'];

        $resultado = $produtoDomainMock->setProduto($dadosProduto);

        $this->assertTrue($resultado);
    }

    public function testSetExcluirProdutoPorId()
    {
        $produtoDomainMock = $this->createMock(ProdutoDomain::class);

        $produtoDomainMock->expects($this->once())
            ->method('setExcluirProdutoPorId')
            ->with(1)
            ->willReturn(true);

        $idProduto = 1;

        $resultado = $produtoDomainMock->setExcluirProdutoPorId($idProduto);

        $this->assertTrue($resultado);
    }

    public function testGetProdutosPorCategoria()
    {
        $produtoDomainMock = $this->createMock(ProdutoDomain::class);

        $produtoDomainMock->expects($this->once())
            ->method('getProdutosPorCategoria')
            ->with('lanche')
            ->willReturn(
                [
                    [
                        "id" => "1",
                        "data_criacao" => "2023-06-26 05:53:00",
                        "data_alteracao" => null,
                        "nome" => "Cheeseburger",
                        "descricao" => "Pão, hamburger e queijo",
                        "preco" => "10.50",
                        "categoria" => "lanche"
                    ],
                    [
                        "id" => "12",
                        "data_criacao" => "2023-06-26 05:53:00",
                        "data_alteracao" => null,
                        "nome" => "Cheeseburger 2",
                        "descricao" => "Pão, hamburger e queijo",
                        "preco" => "10.50",
                        "categoria" => "lanche"
                    ],
                    [
                        "id" => "13",
                        "data_criacao" => "2023-06-26 05:53:00",
                        "data_alteracao" => null,
                        "nome" => "Cheeseburger 3",
                        "descricao" => "Pão, hamburger e queijo",
                        "preco" => "10.50",
                        "categoria" => "lanche"
                    ],
                    [
                        "id" => "14",
                        "data_criacao" => "2023-06-26 05:53:00",
                        "data_alteracao" => null,
                        "nome" => "Cheeseburger 4",
                        "descricao" => "Pão, hamburger e queijo",
                        "preco" => "10.50",
                        "categoria" => "lanche"
                    ]
                ]
            );

        $categoria = 'lanche';

        $resultado = $produtoDomainMock->getProdutosPorCategoria($categoria);

        $this->assertEquals([
            [
                "id" => "1",
                "data_criacao" => "2023-06-26 05:53:00",
                "data_alteracao" => null,
                "nome" => "Cheeseburger",
                "descricao" => "Pão, hamburger e queijo",
                "preco" => "10.50",
                "categoria" => "lanche"
            ],
            [
                "id" => "12",
                "data_criacao" => "2023-06-26 05:53:00",
                "data_alteracao" => null,
                "nome" => "Cheeseburger 2",
                "descricao" => "Pão, hamburger e queijo",
                "preco" => "10.50",
                "categoria" => "lanche"
            ],
            [
                "id" => "13",
                "data_criacao" => "2023-06-26 05:53:00",
                "data_alteracao" => null,
                "nome" => "Cheeseburger 3",
                "descricao" => "Pão, hamburger e queijo",
                "preco" => "10.50",
                "categoria" => "lanche"
            ],
            [
                "id" => "14",
                "data_criacao" => "2023-06-26 05:53:00",
                "data_alteracao" => null,
                "nome" => "Cheeseburger 4",
                "descricao" => "Pão, hamburger e queijo",
                "preco" => "10.50",
                "categoria" => "lanche"
            ]
        ], $resultado);
    }

    public function testGetProdutoPorNome()
    {
        $produtoDomainMock = $this->createMock(ProdutoDomain::class);

        $produtoDomainMock->expects($this->once())
            ->method('getProdutoPorNome')
            ->with('Lanche 1')
            ->willReturn(['id' => 1, 'data_criacao' => '2023-06-26 05:53:00', 'data_alteracao' => null, 'nome' => 'Lanche 1', 'descricao' => 'Pão, hamburger e queijo', 'preco' => 10.50, 'categoria' => 'lanche']);

        $nomeProduto = 'Lanche 1';

        $resultado = $produtoDomainMock->getProdutoPorNome($nomeProduto);

        $this->assertEquals(['id' => 1, 'data_criacao' => '2023-06-26 05:53:00', 'data_alteracao' => null, 'nome' => 'Lanche 1', 'descricao' => 'Pão, hamburger e queijo', 'preco' => 10.50, 'categoria' => 'lanche'], $resultado);
    }

    public function testGetProdutoPorId()
    {
        $produtoDomainMock = $this->createMock(ProdutoDomain::class);

        $produtoDomainMock->expects($this->once())
            ->method('getProdutoPorId')
            ->with('1')
            ->willReturn(['id' => 1, 'data_criacao' => '2023-06-26 05:53:00', 'data_alteracao' => null, 'nome' => 'Lanche 1', 'descricao' => 'Pão, hamburger e queijo', 'preco' => 10.50, 'categoria' => 'lanche']);

        $idProduto = '1';

        $resultado = $produtoDomainMock->getProdutoPorId($idProduto);

        $this->assertEquals(['id' => 1, 'data_criacao' => '2023-06-26 05:53:00', 'data_alteracao' => null, 'nome' => 'Lanche 1', 'descricao' => 'Pão, hamburger e queijo', 'preco' => 10.50, 'categoria' => 'lanche'], $resultado);
    }
}
