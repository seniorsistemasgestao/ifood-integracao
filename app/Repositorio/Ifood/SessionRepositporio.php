<?php


namespace  App\Repositorio\Ifood;
session_start();


class SessionRepositporio{

public function set($key,$value)
{
    $_SESSION[$key] = $value;
}
public function get($key){
    return $_SESSION[$key];
}

}