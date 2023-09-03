<?php

namespace Interfaces\Controllers;

interface AutenticacaoControllerInterface
{
    public function pegarHeaders();
    public function gerarTokenJWT($token = '', $chaveSecreta = '');
    public function validarTokenJWT($token, $chaveSecreta);
}
