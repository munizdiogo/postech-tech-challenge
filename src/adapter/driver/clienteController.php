<?php

namespace adapter\driver;

use core\application\ports\ClienteServiceInterface;
use core\domain\entities\Cliente;

include("src/utils/respostasJson.php");

class ClienteController
{
    private ClienteServiceInterface $clienteService;

    public function __construct(ClienteServiceInterface $clienteService)
    {
        $this->clienteService = $clienteService;
    }

    public function cadastrar(array $dados)
    {
        $campos = ["nome", "email", "cpf"];

        foreach ($campos as $campo) {
            if (empty($dados["$campo"])) {
                retornarRespostaJSON("O campo '$campo' é obrigatório.", 400);
                return;
            }
        }

        $clienteJaCadastrado = $this->clienteService->obterClientePorCPF($dados["cpf"]);

        if ($clienteJaCadastrado) {
            retornarRespostaJSON("Já existe um cliente cadastrado com este CPF.", 409);
            return;
        }

        $cliente = new Cliente($dados['nome'], $dados['email'], $dados['cpf']);

        $salvarDados = $this->clienteService->cadastrarCliente($cliente);

        if ($salvarDados) {
            retornarRespostaJSON("Cliente criado com sucesso.", 201);
        } else {
            retornarRespostaJSON("Ocorreu um erro ao salvar os dados do cliente.", 500);
        }
    }

    public function buscarClientePorCPF(string $cpf): void
    {
        if (empty($cpf)) {
            retornarRespostaJSON("O campo CPF é obrigatório.", 400);
            return;
        }

        $cpf = str_replace([".", "-"], "", $cpf);

        $dadosCliente = $this->clienteService->obterClientePorCPF($cpf);

        $resposta = !empty($dadosCliente) ? $dadosCliente : "Nenhum cliente encontrado com o CPF informado.";

        retornarRespostaJSON($resposta, 200);
    }
}
