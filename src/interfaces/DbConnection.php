<?php

namespace interfaces;

interface DbConnection
{
    public function inserir(string $nomeTabela, array $parametros): bool;
    public function buscarPorParametros(string $nomeTabela, array $campos, array $parametros): array;
}
