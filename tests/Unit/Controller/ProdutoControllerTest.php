<?php

use Controller\ProdutoController;
use PHPUnit\Framework\TestCase;
use Service\ProdutoService;

class ProdutoControllerTest extends TestCase
{
    public function testCadastrar(): void
    {
        $dados = [
            "nome" => "Produto 1",
            "descricao" => "Descrição do Produto 1",
            "preco" => 10.0,
            "categoria" => "lanche"
        ];

        $produtoServiceMock = $this->createMock(ProdutoService::class);
        $produtoServiceMock->method('obterProdutoPorNome')
            ->with($dados["nome"])
            ->willReturn(false);

        $produtoServiceMock->method('cadastrar')
            ->with($dados)
            ->willReturn(true);

        $produtoController = new ProdutoController($produtoServiceMock);

        $produtoController->cadastrar($dados);

        $this->expectOutputString('{"mensagem":"Produto cadastrado com sucesso."}');
    }

    public function testEditar(): void
    {
        $dados = [
            "id" => 1,
            "nome" => "Produto Editado",
            "descricao" => "Descrição Editada",
            "preco" => 20.0,
            "categoria" => "Categoria Editada"
        ];

        $produtoServiceMock = $this->createMock(ProdutoService::class);
        $produtoServiceMock->method('obterProdutoPorId')
            ->with($dados["id"])
            ->willReturn(["id" => $dados["id"]]);

        $produtoServiceMock->method('editar')
            ->with($dados)
            ->willReturn(true);

        $produtoController = new ProdutoController($produtoServiceMock);

        $produtoController->editar($dados);

        $this->expectOutputString('{"mensagem":"Produto atualizado com sucesso."}');
    }

    public function testExcluir(): void
    {
        $id = 1;

        $produtoServiceMock = $this->createMock(ProdutoService::class);
        $produtoServiceMock->method('obterProdutoPorId')
            ->with($id)
            ->willReturn(["id" => $id]);

        $produtoServiceMock->method('excluir')
            ->with($id)
            ->willReturn(true);

        $produtoController = new ProdutoController($produtoServiceMock);

        $produtoController->excluir($id);

        $this->expectOutputString('{"mensagem":"Produto excluído com sucesso."}');
    }

    public function testObterProdutosPorCategoria(): void
    {
        $nomeCategoria = "lanche";

        $produtos = [
            ["nome" => "Produto 1", "descricao" => "Descrição do Produto 1"],
            ["nome" => "Produto 2", "descricao" => "Descrição do Produto 2"]
        ];

        $produtoServiceMock = $this->createMock(ProdutoService::class);
        $produtoServiceMock->method('obterProdutosPorCategoria')
            ->with($nomeCategoria)
            ->willReturn($produtos);

        $produtoController = new ProdutoController($produtoServiceMock);

        $produtoController->obterProdutosPorCategoria($nomeCategoria);

        $this->expectOutputString('[{"nome":"Produto 1","descricao":"Descrição do Produto 1"},{"nome":"Produto 2","descricao":"Descrição do Produto 2"}]');
    }
}
