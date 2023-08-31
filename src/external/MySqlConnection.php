<?php

namespace external;

use interfaces\DbConnection;
use \PDO;
use \PDOException;
use \controllers\DotEnvEnvironment;

class MySqlConnection implements DbConnection
{
    public function getConexao()
    {
        $dotEnv = new DotEnvEnvironment();
        $dotEnv->load();
        $conn = null;
        try {
            $conn = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_NAME'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Erro na conexão com o banco de dados: " . $e->getMessage();
        }

        return $conn;
    }

    public function inserir(string $nomeTabela, array $parametros): bool
    {
        $db = $this->getConexao();
        $nomesCampos = implode(", ", array_keys($parametros));
        $nomesValores = ":" . implode(", :", array_keys($parametros));
        $query = "INSERT INTO $nomeTabela ($nomesCampos) VALUES ($nomesValores)";
        $stmt = $db->prepare($query);

        foreach ($parametros as $chave => $valor) {
            $stmt->bindValue(":$chave", $valor);
        }

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function excluir(string $nomeTabela, int $id): bool
    {
        $db = $this->getConexao();
        $query = "DELETE FROM $nomeTabela WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(":id", $id);
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function atualizar(string $nomeTabela, array $parametros): bool
    {
        $db = $this->getConexao();
        $nomesCampos = "";

        foreach ($parametros as $chave => $valor) {
            $nomesCampos .= $chave . " = :" . $chave . ", ";
        }

        $nomesCampos = substr($nomesCampos, 0, -2);

        $query = "UPDATE $nomeTabela SET $nomesCampos WHERE id = :id";

        $stmt = $db->prepare($query);

        foreach ($parametros as $chave => $valor) {
            $stmt->bindValue(":$chave", $valor);
        }

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function obterUltimoId(): int
    {
        $db = $this->getConexao();
        return $db->lastInsertId();
    }

    public function buscarPorParametros(string $nomeTabela, array $campos, array $parametros): array
    {
        $camposBusca = $this->ajustarCamposExpressao($campos);
        $parametrosBusca = $this->prepararParametrosBusca($parametros);

        $db = $this->getConexao();

        if (!empty($parametrosBusca["restricao"])) {
            $query = "SELECT $camposBusca FROM $nomeTabela " . $parametrosBusca["restricao"];
            $stmt = $db->prepare($query);

            foreach ($parametros as $item) {
                $stmt->bindValue(":{$item['campo']}", $item['valor']);
            }
        } else {
            $query = "SELECT $camposBusca FROM $nomeTabela";
            $stmt = $db->prepare($query);
        }

        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $dados ?? [];
    }

    private function ajustarCamposExpressao(array $campos): string
    {
        if (empty($campos)) {
            return " * ";
        } else {
            return implode(", ", $campos);
        }
    }

    private function prepararParametrosBusca(array $params): array
    {
        if (empty($params)) {
            return [
                "restricao" => "",
                "valores" => [],
            ];
        }

        $camposRestricaoArray = [];
        $valores = [];

        foreach ($params as $item) {
            $camposRestricaoArray[] = $item["campo"] . " = :" . $item["campo"];
            $valores[] = $item["valor"];
        }

        $camposRestricao = implode(" AND ", $camposRestricaoArray);

        return [
            "restricao" => "WHERE $camposRestricao",
            "valores" => $valores
        ];
    }
}
