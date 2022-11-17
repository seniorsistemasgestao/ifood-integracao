<?php

namespace App\Repositorio\Ifood;

use App\Models\Ifood\IfoodModel;
use Exception;

use App\Repositorio\Ifood\SessionRepositporio;

class ApiRepositorio
{

    protected $tokenHttp = "https://merchant-api.ifood.com.br/authentication/v1.0/oauth/token";
    protected $ProdHttp = "https://merchant-api.ifood.com.br/catalog/v1.0/merchants/";
    protected $cliente;
    protected $session;
    protected $ifoodModel;

    public function __construct()
    {
        $this->cliente = new \GuzzleHttp\Client();
        $this->session = new SessionRepositporio();
        $this->ifoodModel = new IfoodModel();
    }

    //gera o token
    public function getToken()
    {
        try {

            $request = $this->ifoodModel->ClienteHttp('POST', $this->tokenHttp, [
                "grantType" => "client_credentials",
                "clientId" => env("CREDENCIAL_IFOOD_CLIENT_ID"),
                "clientSecret" => env('CREDENCIAL_IFOOD_CLIENT_SECRET'),
                "merchantId" => env('CREDENCIAL_IFOOD_CLIENT_MERCHANTID')
            ]);
            //salva o token na session 
            $this->session->set('token', $request->accessToken);
            return  $request;
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()]);
        }
    }

    //lista de todos os produtos
    public function getProtudos()
    {
        try {

            $token = $this->session->get('token');
            $request = $this->ifoodModel->ClienteHttp(
                'GET',
                $this->ProdHttp . env('CREDENCIAL_IFOOD_CLIENT_MERCHANTID') . '/products',

                null,
                [
                    'Authorization' => 'Bearer ' . $token
                ],
                [
                    "limit" => 100,
                    "page" => 1
                ]
            );

            return $request;
        } catch (Exception $e) {
            //caso token esteja vencido ele renova 
            $this->getToken();
            $this->getProtudos();
           // return $e->getMessage();
        }
    }

    //criar o produto
    public function postProduto()
    {
        try {
            $token = $this->session->get('token');
            $response =  $this->cliente->request('GET', $this->listProdHttp . env('CREDENCIAL_IFOOD_CLIENT_MERCHANTID') . '/products', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token
                ],
                'query' =>
                [
                    "limit" => 100,
                    "page" => 1
                ]
            ]);
            return response($response->getBody(), 200, ['Content-type' => 'application/json']);
        } catch (Exception $e) {
            //caso token esteja vencido ele renova 
            $this->getToken();
            $this->getProtudos();
        }
    }
}
