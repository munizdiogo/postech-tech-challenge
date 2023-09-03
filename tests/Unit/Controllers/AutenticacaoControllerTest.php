<?php

namespace Controllers;

use PHPUnit\Framework\TestCase;
use Firebase\JWT\Key as Key;

class AutenticacaoControllerTest extends TestCase
{
    protected $autenticacaoController;

    public function setUp(): void
    {
        parent::setUp();
        $this->autenticacaoController = new AutenticacaoController();
    }

    public function testGerarTokenJWT()
    {
        $_ENV['CHAVE_SECRETA'] = 'chavesecreta';
        $token = $this->autenticacaoController->gerarTokenJWT();
        $this->assertTrue(!empty($token));
    }

    public function testValidarTokenJwtComTokenValido()
    {
        $chaveSecreta = 'chavesecreta';
        $token = $this->autenticacaoController->gerarTokenJWT('', $chaveSecreta);
        $dadosUsuario = $this->autenticacaoController->validarTokenJWT($token, new Key($chaveSecreta, 'HS256'));
        $this->assertEquals(1, $dadosUsuario['id']);
        $this->assertEquals('Lanchonete XPTO', $dadosUsuario['nome']);
        $tokenValido = $token;
        $retorno = $this->autenticacaoController->validarTokenJWT($tokenValido, new Key($chaveSecreta, 'HS256'));
        $this->assertIsArray($retorno);
        $this->assertArrayHasKey("id", $retorno);
    }


    public function testValidarTokenJwtComTokenInvalido()
    {
        $chaveSecreta = 'chavesecreta';
        $token = $this->autenticacaoController->gerarTokenJWT('', $chaveSecreta);
        $dadosUsuario = $this->autenticacaoController->validarTokenJWT($token, new Key($chaveSecreta, 'HS256'));
        $this->assertEquals(1, $dadosUsuario['id']);
        $this->assertEquals('Lanchonete XPTO', $dadosUsuario['nome']);
        $tokenInvalido = 'token_invalido';
        $retorno = $this->autenticacaoController->validarTokenJWT($tokenInvalido, new Key($chaveSecreta, 'HS256'));
        $this->assertFalse($retorno);
    }
}
