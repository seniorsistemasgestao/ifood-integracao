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
    // gerar o token de autenticação 
    public function getUrlToken()
    {
        return $this->urlBase . "authentication/v1.0/oauth/token";
    }

    //sesssão de produtos lista-produtos
    public function getUrlProdutos($mercadoId)
    {

        return $this->urlBase . "catalog/v1.0/merchants/{$mercadoId}/products";
    }

    // criar produto
    public function getUrlPostProduto($mercadoId)
    {
        return $this->urlBase . "catalog/v1.0/merchants/{$mercadoId}/products";
    }

    //sessão de catalogo - lista de catalogos
    public function getUrlGetCalalogo($mercadoId)
    {
        return $this->urlBase . "catalog/v1.0/merchants/{$mercadoId}/catalogs";
    }

    //sessão de categoria - lista de categorias
    public function getUrlCategoria($mercadoId, $catalogoId)
    {
        return $this->urlBase . "catalog/v1.0/merchants/{$mercadoId}/catalogs/{$catalogoId}/categories";
    }

    //sessão de item  - criar item
    public function getUrlPostItems($mercadoId, $categoriaId, $produtoId)
    {
        return $this->urlBase . "catalog/v1.0/merchants/{$mercadoId}/categories/{$categoriaId}/products/{$produtoId}";
    }


}
