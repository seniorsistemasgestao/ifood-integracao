<?php

namespace App\Repositorio\Session;

session_start();

class  SessionRepositorio
{

    public function set($key, $value)
    {
        if (is_array($value)) {
            return $_SESSION[$key] = (array)$value;
        }
        return $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key];
    }
}
