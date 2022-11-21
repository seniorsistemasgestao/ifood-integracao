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
        //    $this->urlToken = "https://merchant-api.ifood.com.br/authentication/v1.0/oauth/token";
        //    $this->urlGetProtudos = "https://merchant-api.ifood.com.br/catalog/v1.0/".$this->user->getMerchantID()."/merchants/{merchantId}/products";

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
}
