<?php

namespace external;

use interfaces\DbConnection;
use \PDO;
use \PDOException;
use \controllers\DotEnvEnvironment;

class MySqlConnection implements DbConnection
{

    private $conn;
    public function getConexao()
    {
        $dotEnv = new DotEnvEnvironment();
        $dotEnv->load();
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_NAME'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Erro na conexão com o banco de dados: " . $e->getMessage();
        }

        return $this->conn;
    }

    public function inserir(string $nomeTabela, array $parametros): bool
    {
        $db = $this->getConexao();

        $nomesCampos = implode(", ", array_keys($parametros));
        $nomesValores = ":" . implode(", :", array_keys($parametros));

        $sql = "INSERT INTO $nomeTabela ($nomesCampos) VALUES ($nomesValores)";

        $stmt = $db->prepare($sql);

        foreach ($parametros as $chave => $valor) {
            $stmt->bindValue(":$chave", $valor);
        }

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function buscarPorParametros(string $nomeTabela, array $campos, array $parametros): array
    {
        $camposBusca = $this->ajustarCamposExpressao($campos);
        $parametrosBusca = $this->prepararParametrosBusca($parametros);

        $sql = "SELECT $camposBusca FROM $nomeTabela " . $parametrosBusca["restricao"];
        
        $db = $this->getConexao();
    
        const rows = await connection.all(sql, parametrosBusca.valores);
        connection.close();
        return rows;
    }

    private function ajustarCamposExpressao(array $campos): string {
        if (empty($campos)) {
          return " * ";
        } else {
          return implode(", ", $campos);
        }
    }

    private function prepararParametrosBusca(array $params): array {
        if (empty($params)) {
          return ["restricao" => "",
            "valores" => [],
            ];
        }
    
        $camposRestricaoArray = [];
        $valores = [];
        
        foreach ($params as $item) {
            $camposRestricaoArray[] = $item["campo"] . " = ?";
            $valores[] = $item["valor"];
        }

        $camposRestricao = implode(" AND ", $camposRestricaoArray);
       
        return [
          "restricao" => "WHERE $camposRestricao",
          "valores" => $valores
        ];
      }
}
