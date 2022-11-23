<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositorio\Api\ApiRepositorio;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    protected $apiRepositorio;

    public function __construct()
    {
        $this->apiRepositorio = new ApiRepositorio();
    }

    public function getToken(Request $credencial)
    {
        return $this->apiRepositorio->getToken($credencial->input());
    }

    public function getProdutos(Request $credencial)
    {
        return $this->apiRepositorio->getProdutos($credencial->input());
    }

    public function postProdutos(Request $produto)
    {
        return $this->apiRepositorio->postProdutos($produto->input());
    }

    public function getCatalogos(Request $credencial)
    {
        return $this->apiRepositorio->getCatalogos($credencial->input());
    }

    public function postCategoria(Request $credencial)
    {
        return $this->apiRepositorio->postCategoria($credencial->input());
    }

    public function getCategorias(Request $credencial)
    {
        return $this->apiRepositorio->getCategorias($credencial->input());
    }
    public function postItem(Request $credencial)
    {
        return $this->apiRepositorio->postItem($credencial->input());

    }
}
