<?php

namespace App\Http\Controllers\Ifood;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositorio\Ifood\ApiRepositorio;

class ApiController extends Controller
{
    protected $apiRepositorio;

    public function __construct()
    {
        $this->apiRepositorio = new ApiRepositorio();
    }

    public function getToken()
    {
        return $this->apiRepositorio->getToken();
    }

    public function getProtudos()
    {
        return $this->apiRepositorio->getProtudos();
    }

    public function postProduto(Request $produto)
    {
      
        return $this->apiRepositorio->postProduto($produto->input());
    }
}


