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
     // criar categoria
    public function getUrlPostCategoria($mercadoId,$catalogId)
    {
        return $this->urlBase . "catalog/v1.0/merchants/{$mercadoId}/catalogs/{$catalogId}/categories";
    }

    //sessão de item  - criar item
    public function getUrlPostItems($mercadoId, $categoriaId, $produtoId)
    {
       // https://merchant-api.ifood.com.br/catalog/v1.0/merchants/86a1b3cf-ea31-4a69-a502-000eb81ebf3d/categories/f8529253-d949-4056-863e-8bcad3ea360d/products/8dc7db0b-928f-45de-b03b-aa1e5a723ce1
        return $this->urlBase . "catalog/v1.0/merchants/{$mercadoId}/categories/{$categoriaId}/products/{$produtoId}";
    }

    
}
