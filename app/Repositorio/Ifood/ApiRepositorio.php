<?php

namespace App\Repositorio\Ifood;

use App\Models\Ifood\IfoodModel;
use Exception;

use App\Repositorio\Ifood\SessionRepositporio;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

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
            return true;
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
            if ($this->getToken()) {
                return $this->getProtudos();
            }

            return response(['error' => $e->getMessage()]);
        }
    }

    //criar o produto
    public function postProduto($produto)
    {
        $token = $this->session->get('token');


        try {

            $data = [
                "name" => $produto['name'] ?? "",
                "description" => $produto['description'] ?? "",
                "additionalInformation" => $produto['additionalInformation'] ?? "none",
                "serving" => $produto['serving'] ?? "SERVES_1",
                "externalCode" => $produto['externalCode'] ?? "",
                "image" => $produto['image'] ?? "",
                "dietaryRestrictions" => $produto['dietaryRestrictions'] ?? [],

                "ean" => $produto['ean'] ?? "",
                "weight" => [
                    "quantity" => $produto['weight']['quantity'] ?? 0,
                    "unit" => $produto['weight']['unit'] ?? "g"
                ]
            ];

            $url = 'https://merchant-api.ifood.com.br/catalog/v1.0/merchants/86a1b3cf-ea31-4a69-a502-000eb81ebf3d/products';
            $token = $this->session->get('token');
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->asForm()->post($url, $data);



            return  response($response);
        } catch (Exception $e) {



            return response(
                [
                    "token" => $token, "error" => $e->getMessage()
                ]
            );
        }
    }
}
