<?php

namespace adapter\driver;

class DotEnvEnvironment
{
    public function load(): void
    {
        $lines = file($_SERVER["DOCUMENT_ROOT"]. ".env");
        foreach ($lines as $line) {
            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            putenv(sprintf('%s=%s', $key, $value));
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}
