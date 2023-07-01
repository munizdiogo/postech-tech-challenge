<?php

namespace Service;

use Domain\Entities\ClienteDomain;

class ClienteService
{
    private $clienteDomain;

    public function __construct(ClienteDomain $clienteDomain)
    {
        $this->clienteDomain = $clienteDomain;
    }

    public function cadastrarCliente(array $dados)
    {
        return $this->clienteDomain->setNovoCliente($dados);
    }

    public function validarClientePorId(int $id)
    {
        return $this->clienteDomain->getClienteEhValidoPorId($id);
    }

    public function obterClientePorCPF(string $cpf)
    {
        $dadosCliente = $this->clienteDomain->getClientePorCPF($cpf);

        if (!empty($dadosCliente)) {
            return $dadosCliente;
        } else {
            return [];
        }
    }
}
