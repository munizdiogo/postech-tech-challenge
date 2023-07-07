<?php

namespace adapter\driver;

use Exception;
use Firebase\JWT\JWT;

class AutenticacaoController
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



    // Função para verificar o token JWT
    function gerarTokenJWT($token = '', $chaveSecreta = '')
    {
        // Chave secreta para assinatura do token (deve ser mantida em segurança)
        $chaveSecreta = $_ENV['CHAVE_SECRETA'];

        // Dados do usuário
        $dadosUsuario = array(
            'id' => 1,
            'nome' => 'Lanchonete XPTO'
        );

        if (!empty($chaveSecreta)) {

            // Configurações do token
            $tokenConfig = array(
                'iss' => 'localhost',  // Emissor do token
                'aud' => 'localhost',   // Audiência do token
                'iat' => time(),                  // Data de emissão do token
                'exp' => time() + (60 * 60 * 24),      // Data de expiração do token (24 hora)
                'data' => $dadosUsuario           // Dados do usuário
            );

            $algoritimo = 'HS256';

            // Gerar o token JWT
            return $token = JWT::encode($tokenConfig, $chaveSecreta, $algoritimo);
        }
    }

    // Função para verificar o token JWT
    function validarTokenJWT($token, $chaveSecreta)
    {
        try {
            $decoded = JWT::decode($token, $chaveSecreta);
            http_response_code(200);
            return (array) $decoded->data; // Retorna os dados do usuário contidos no token
        } catch (Exception $e) {
            http_response_code(401);
            return $e->getMessage(); // Token inválido ou expirado
        }
    }
}
