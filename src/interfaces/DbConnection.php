<?php

namespace interfaces;

interface DbConnection
{
    public function inserir(string $nomeTabela, array $parametros): bool;
    public function atualizar(string $nomeTabela, array $parametros): bool;
    public function excluir(string $nomeTabela, int $id): bool;
    public function buscarPorParametros(string $nomeTabela, array $campos, array $parametros): array;
    public function obterUltimoId(): int;
}
