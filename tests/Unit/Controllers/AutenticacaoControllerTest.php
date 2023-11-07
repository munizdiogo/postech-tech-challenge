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
}
