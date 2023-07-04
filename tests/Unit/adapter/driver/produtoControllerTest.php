<?php

use PHPUnit\Framework\TestCase;
use adapter\driver\ProdutoController;
use core\applications\ports\ProdutoServiceInterface;
use core\domain\entities\Produto;

class ProdutoControllerTest extends TestCase
{
    // Consultar
    public function testObterProdutosPorCategoriaComNomeVazio()
    {
        $mockService = $this->createMock(ProdutoServiceInterface::class);
        $controller = new ProdutoController($mockService);

        $nome = '';

        $this->expectOutputString('{"mensagem":"O campo nome é obrigatório."}');
        $controller->obterProdutosPorCategoria($nome);
    }

    public function testObterProdutosPorCategoriaComProdutosEncontrados()
    {
        $mockService = $this->createMock(ProdutoServiceInterface::class);
        $mockService->method('getProdutosPorCategoria')->willReturn([["nome" => "Produto 1", "descricao" => "Descrição 1", "preco" => 10, "categoria" => "Categoria"],["nome" => "Produto 2", "descricao" => "Descrição 2", "preco" => 20, "categoria" => "Categoria"]]);
        

        $controller = new ProdutoController($mockService);

        $nome = 'Categoria';

        $this->expectOutputString('[{"nome":"Produto 1","descricao":"Descrição 1","preco":10,"categoria":"Categoria"},{"nome":"Produto 2","descricao":"Descrição 2","preco":20,"categoria":"Categoria"}]');
        $controller->obterProdutosPorCategoria($nome);
    }

    public function testObterProdutosPorCategoriaSemProdutosEncontrados()
    {
        $mockService = $this->createMock(ProdutoServiceInterface::class);
        $mockService->method('getProdutosPorCategoria')->willReturn([]);

        $controller = new ProdutoController($mockService);

        $nome = 'Categoria';

        $this->expectOutputString('{"mensagem":"Nenhum produto encontrado nesta categoria."}');
        $controller->obterProdutosPorCategoria($nome);
    }

    // Cadastrar

    public function testCadastrarProdutoComCamposObrigatoriosVazios()
    {
        $mockService = $this->createMock(ProdutoServiceInterface::class);
        $controller = new ProdutoController($mockService);

        $dados = [
            'nome' => '',
            'descricao' => '',
            'preco' => '',
            'categoria' => '',
        ];

        $this->expectOutputString('{"mensagem":"O campo \'nome\' é obrigatório."}');
        $controller->cadastrar($dados);
    }

    public function testCadastrarProdutoJaExistente()
    {
        $mockService = $this->createMock(ProdutoServiceInterface::class);
        $mockService->method('getProdutoPorNome')->willReturn(['nome' => 'Produto Existente','descricao' => 'Descrição','preco' => 10.0,'categoria' => 'Categoria']);

        $controller = new ProdutoController($mockService);

        $dados = [
            'nome' => 'Produto Existente',
            'descricao' => 'Descrição',
            'preco' => 10.0,
            'categoria' => 'Categoria',
        ];

        $this->expectOutputString('{"mensagem":"Já existe um produto cadastrado com esse nome."}');
        $controller->cadastrar($dados);
    }

    public function testCadastrarProdutoComSucesso()
    {
        $mockService = $this->createMock(ProdutoServiceInterface::class);
        $mockService->method('getProdutoPorNome')->willReturn([]);
        $mockService->method('setNovoProduto')->willReturn(true);

        $controller = new ProdutoController($mockService);

        $dados = [
            'nome' => 'Novo Produto 2',
            'descricao' => 'Descrição do novo produto 2',
            'preco' => 21.0,
            'categoria' => 'Categoria Nova 2',
        ];

        $this->expectOutputString('{"mensagem":"Produto cadastrado com sucesso."}');
        $controller->cadastrar($dados);
    }


    // Editar
    public function testEditarProdutoComCamposObrigatoriosVazios()
    {
        $mockService = $this->createMock(ProdutoServiceInterface::class);
        $controller = new ProdutoController($mockService);

        $dados = [
            'id' => 1,
            'nome' => '',
            'descricao' => '',
            'preco' => '',
            'categoria' => '',
        ];

        $this->expectOutputString('{"mensagem":"O campo \'nome\' é obrigatório."}');
        $controller->editar($dados);
    }

    public function testEditarProdutoNaoEncontrado()
    {
        $mockService = $this->createMock(ProdutoServiceInterface::class);
        $mockService->method('getProdutoPorId')->willReturn([]);

        $controller = new ProdutoController($mockService);

        $dados = [
            'id' => 1,
            'nome' => 'Produto Editado',
            'descricao' => 'Descrição Editada',
            'preco' => 30.0,
            'categoria' => 'Categoria Editada',
        ];

        $this->expectOutputString('{"mensagem":"Não foi encontrado um produto com o ID informado."}');
        $controller->editar($dados);
    }

    public function testEditarProdutoComSucesso()
    {
        $mockService = $this->createMock(ProdutoServiceInterface::class);
        $mockService->method('getProdutoPorId')->willReturn(['nome' => 'Produto Editado', 'descricao' => 'Descrição Editada', 'preco' => 30.0, 'categoria' => 'Categoria Editada']);
        $mockService->method('setProduto')->willReturn(true);

        $controller = new ProdutoController($mockService);

        $dados = [
            'id' => 1,
            'nome' => 'Produto Editado',
            'descricao' => 'Descrição Editada',
            'preco' => 30.0,
            'categoria' => 'Categoria Editada',
        ];

        $this->expectOutputString('{"mensagem":"Produto atualizado com sucesso."}');
        $controller->editar($dados);
    }


    // Excluir
    public function testExcluirProdutoComIdVazio()
    {
        $mockService = $this->createMock(ProdutoServiceInterface::class);
        $mockService->method('getProdutoPorId')->willReturn([]);
        $mockService->method('setExcluirProdutoPorId')->willReturn(false);

        $controller = new ProdutoController($mockService);

        $id = '';

        $this->expectOutputString('{"mensagem":"O campo ID é obrigatório."}');
        $controller->excluir($id);
    }

    public function testExcluirProdutoNaoEncontrado()
    {
        $mockService = $this->createMock(ProdutoServiceInterface::class);
        $mockService->method('getProdutoPorId')->willReturn([]);

        $controller = new ProdutoController($mockService);

        $id = 6;

        $this->expectOutputString('{"mensagem":"Não foi encontrado um produto com o ID informado."}');
        $controller->excluir($id);
    }

    public function testExcluirProdutoComSucesso()
    {
        $mockService = $this->createMock(ProdutoServiceInterface::class);
        $mockService->method('getProdutoPorId')->willReturn(["nome" => "Produto Existente", "descricao" => "Descrição", "preco" => 10.0, "categoria" => "Categoria"]);
        $mockService->method('setExcluirProdutoPorId')->willReturn(true);

        $controller = new ProdutoController($mockService);

        $id = 1;

        $this->expectOutputString('{"mensagem":"Produto excluído com sucesso."}');
        $controller->excluir($id);
    }
}
