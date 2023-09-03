<?php

namespace Controllers;

use Exception;
use Firebase\JWT\JWT;
use Interfaces\Controllers\AutenticacaoControllerInterface;

class AutenticacaoController implements AutenticacaoControllerInterface
{
    function pegarHeaders()
    {
        $headers = array();
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) <> 'HTTP_') {
                continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$key] = $value;
        }
        return $headers;
    }

    function gerarTokenJWT($token = '', $chaveSecreta = '')
    {
        $chaveSecreta = $_ENV['CHAVE_SECRETA'];
        $dadosUsuario = array(
            'id' => 1,
            'nome' => 'Lanchonete XPTO'
        );
        if (!empty($chaveSecreta)) {
            $tokenConfig = array(
                'iss' => 'localhost',
                'aud' => 'localhost',
                'iat' => time(),
                'exp' => time() + (60 * 60 * 24),
                'data' => $dadosUsuario
            );
            $algoritimo = 'HS256';
            return $token = JWT::encode($tokenConfig, $chaveSecreta, $algoritimo);
        }
    }

    function validarTokenJWT($token, $chaveSecreta)
    {
        try {
            $decoded = JWT::decode($token, $chaveSecreta);
            http_response_code(200);
            return (array) $decoded->data;
        } catch (Exception $e) {
            http_response_code(401);
            return false;
        }
    }
}
