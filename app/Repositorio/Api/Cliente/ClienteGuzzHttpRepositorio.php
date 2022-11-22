<?php

namespace App\Repositorio\Api\Cliente;

use App\Models\User;

class ClienteGuzzHttpRepositorio
{
    protected $urlToken;
    protected $urlGetProtudos;
    protected User $user;
    protected $urlBase;

    public function __construct()
    {
        $this->urlBase = "https://merchant-api.ifood.com.br/";
        
    }

    public function getCliente()
    {
        return new \GuzzleHttp\Client();
    }

    public function getUrlToken()
    {
        return $this->urlBase . "authentication/v1.0/oauth/token";
    }

    public function getUrlProdutos($mercadoId)
    {
        ///merchants/{merchantId}/products
        return $this->urlBase."catalog/v1.0/merchants/{$mercadoId}/products";
    }

    public function getUrlGetCalalogo($mercadoId)
    {
        return $this->urlBase."catalog/v1.0/merchants/{$mercadoId}/catalogs";
    }

    public function getUrlCategoriaID($mercadoId)
    {
        return $this->urlBase."";
    }
}
