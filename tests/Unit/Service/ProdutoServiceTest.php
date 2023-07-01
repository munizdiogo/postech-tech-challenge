<?php

use PHPUnit\Framework\TestCase;
use Domain\Entities\ProdutoDomain;
use Service\ProdutoService;

class ProdutoServiceTest extends TestCase
{
    public function testCadastrar()
    {
        $produtoDomainMock = $this->createMock(ProdutoDomain::class);

        $produtoDomainMock->expects($this->once())
            ->method('setNovoProduto')
            ->with(['nome' => 'Lanche 2', 'descricao' => 'Descrição do lanche', 'preco' => 10.0, 'categoria' => 'lanche'])
            ->willReturn(true);

        $produtoService = new ProdutoService($produtoDomainMock);

        $dadosProduto = ['nome' => 'Lanche 2', 'descricao' => 'Descrição do lanche', 'preco' => 10.0, 'categoria' => 'lanche'];

        $resultado = $produtoService->cadastrar($dadosProduto);

        $this->assertTrue($resultado);
    }

    public function testEditar()
    {
        $produtoDomainMock = $this->createMock(ProdutoDomain::class);

        $produtoDomainMock->expects($this->once())
            ->method('setProduto')
            ->with(['id' => 1, 'nome' => 'Lanche 2', 'descricao' => 'Descrição do lanche', 'preco' => 10.0, 'categoria' => 'lanche'])
            ->willReturn(true);

        $produtoService = new ProdutoService($produtoDomainMock);

        $dadosProduto = ['id' => 1, 'nome' => 'Lanche 2', 'descricao' => 'Descrição do lanche', 'preco' => 10.0, 'categoria' => 'lanche'];

        $resultado = $produtoService->editar($dadosProduto);

        $this->assertTrue($resultado);
    }

    public function testExcluir()
    {
        $produtoDomainMock = $this->createMock(ProdutoDomain::class);

        $produtoDomainMock->expects($this->once())
            ->method('setExcluirProdutoPorId')
            ->with(1)
            ->willReturn(true);

        $produtoService = new ProdutoService($produtoDomainMock);

        $idProduto = 1;

        $resultado = $produtoService->excluir($idProduto);

        $this->assertTrue($resultado);
    }

    public function testObterProdutosPorCategoria()
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

        $produtoService = new ProdutoService($produtoDomainMock);

        $categoria = 'lanche';

        $resultado = $produtoService->obterProdutosPorCategoria($categoria);

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

    public function testObterProdutoPorNome()
    {
        $produtoDomainMock = $this->createMock(ProdutoDomain::class);

        $produtoDomainMock->expects($this->once())
            ->method('getProdutoPorNome')
            ->with('Lanche 1')
            ->willReturn(['id' => 1, 'data_criacao' => '2023-06-26 05:53:00', 'data_alteracao' => null, 'nome' => 'Lanche 1', 'descricao' => 'Pão, hamburger e queijo', 'preco' => 10.50, 'categoria' => 'lanche']);

        $produtoService = new ProdutoService($produtoDomainMock);

        $nomeProduto = 'Lanche 1';

        $resultado = $produtoService->obterProdutoPorNome($nomeProduto);

        $this->assertEquals(['id' => 1, 'data_criacao' => '2023-06-26 05:53:00', 'data_alteracao' => null, 'nome' => 'Lanche 1', 'descricao' => 'Pão, hamburger e queijo', 'preco' => 10.50, 'categoria' => 'lanche'], $resultado);
    }

    public function testObterProdutoPorId()
    {
        $produtoDomainMock = $this->createMock(ProdutoDomain::class);

        $produtoDomainMock->expects($this->once())
            ->method('getProdutoPorId')
            ->with('1')
            ->willReturn(['id' => 1, 'data_criacao' => '2023-06-26 05:53:00', 'data_alteracao' => null, 'nome' => 'Lanche 1', 'descricao' => 'Pão, hamburger e queijo', 'preco' => 10.50, 'categoria' => 'lanche']);

        $produtoService = new ProdutoService($produtoDomainMock);

        $idProduto = '1';

        $resultado = $produtoService->obterProdutoPorId($idProduto);

        $this->assertEquals(['id' => 1, 'data_criacao' => '2023-06-26 05:53:00', 'data_alteracao' => null, 'nome' => 'Lanche 1', 'descricao' => 'Pão, hamburger e queijo', 'preco' => 10.50, 'categoria' => 'lanche'], $resultado);
    }
}
