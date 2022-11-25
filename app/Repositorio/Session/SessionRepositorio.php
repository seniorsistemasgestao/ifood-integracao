<?php

namespace App\Repositorio\Session;

session_start();

class  SessionRepositorio
{

    public function set($key, $value)
    {
        if (is_array($value)) {
             $_SESSION[$key] = (array)$value;
        }
         $_SESSION[$key] = $value;
    }

    public function get($key)
    {
       
        return $_SESSION[$key];
    }

    public function verifySession($key)
    {
        return isset($_SESSION[$key]);
    }
}
