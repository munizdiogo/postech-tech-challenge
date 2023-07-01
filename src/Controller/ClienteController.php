<?php

namespace Controller;

use Service\ClienteService;

include("C:/xampp/htdocs/postech-tech-challenge/src/Utils/RespostasJson.php");

class ClienteController
{
    private $clienteService;

    public function __construct(ClienteService $clienteService)
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

        $salvarDados = $this->clienteService->cadastrarCliente($dados);

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

        $resposta = !empty($dadosCliente) ? $dadosCliente : [];

        retornarRespostaJSON($resposta, 200);
    }
}
