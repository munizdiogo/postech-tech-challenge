<?php

namespace Interfaces\Entities;

interface ClienteInterface
{
    public function getNome(): string;
    public function getEmail(): string;
    public function getCpf(): string;
}
