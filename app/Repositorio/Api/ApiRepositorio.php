<?php

namespace App\Repositorio\Api;

use App\Models\User;
use App\Repositorio\Api\Cliente\ClienteGuzzHttpRepositorio;
use App\Repositorio\Api\Cliente\ClienteHttpRepositorio;
use App\Repositorio\Session\SessionRepositorio;
use Exception;


class ApiRepositorio
{


    //clientes Http
    protected $clientHttpGuzz;
    protected $clientHttp;
    protected $user;

    //session
    protected $session;

    //urls


    public function __construct()
    {
        $this->clientHttp = new ClienteHttpRepositorio();
        $this->clientHttpGuzz = new ClienteGuzzHttpRepositorio();
        $this->user = new User();
        $this->session = new SessionRepositorio();
    }


    public function getToken($credencial = [])
    {

        $validarUser = $this->user->all()->first();

        try {
            $request = $this->clientHttpGuzz->getCliente()->request('POST', $this->clientHttpGuzz->getUrlToken(), [
                "headers" => [
                    'Content-Type' => "application/x-www-form-urlencoded",
                    'Accept' => "application/json"
                ],
                "form_params" => [
                    "grantType" => $credencial['grantType'] ?? 'client_credentials',
                    "clientId" => $credencial['clientId'] ? $validarUser->cliente_id : "",
                    "clientSecret" => $credencial['clientSecret'] ? $validarUser->cliente_secreto : ""
                ]
            ]);

            $format = json_decode($request->getBody());

            $this->session->set('token', 'Bearer ' . $format->accessToken);
            return response(["token" => $format->accessToken], 200, ['Content-Type' => "application/json"]);
        } catch (Exception $e) {
            return response(["error" => $e->getMessage()], 200, ['Content-Type' => "application/json"]);
        }
    }


    public function getProdutos($credencial)
    {
        $token = $this->session->get('token') ?? "vazio";

        //    var_dump($this->clientHttpGuzz->getUrlProdutos($credencial['merchantId']));die();
        try {
            $request = $this->clientHttpGuzz->getCliente()->request('GET', $this->clientHttpGuzz->getUrlProdutos($credencial['merchantId']), [
                "headers" => [
                    'Content-Type' => "application/json",
                    'Accept' => "application/json",
                    "Authorization" => $token
                ],
                "query" => [
                    "limit" => $credencial['limit'],
                    "page" => $credencial['page']
                ]
            ]);
            return response($request->getBody(), 200, ['Content-Type' => "application/json"]);
        } catch (Exception $e) {
            if ($this->verifyToken($e->getMessage())) {
                return $this->getProdutos($credencial);
            }
            return response(["error" => $e->getMessage()], 200, ['Content-Type' => "application/json"]);
        }
    }

    public function getCatalogos($credencial)
    {
        $token = $this->session->get('token') ?? "vazio";
        try {
            $request = $this->clientHttpGuzz->getCliente()->request('GET', $this->clientHttpGuzz->getUrlGetCalalogo($credencial['merchantId']), [
                "headers" => [
                    'Content-Type' => "application/json",
                    'Accept' => "application/json",
                    "Authorization" => $token
                ],
                "query" => [
                    "merchantId" => $credencial['merchantId']
                ]
            ]);
            $format = json_decode($request->getBody());
            $this->session->set('catalogoID', $format[0]->catalogId);
            return response($request->getBody(), 200, ['Content-Type' => "application/json"]);
        } catch (Exception $e) {
            if ($this->verifyToken($e->getMessage())) {
                return $this->getCatalogos($credencial);
            }
            return response(["error" => $e->getMessage()], 200, ['Content-Type' => "application/json"]);
        }
    }

    public function getCategorias($credencial)
    {
        $token = $this->session->get('token') ?? "vazio";
        try {
            $request = $this->clientHttpGuzz->getCliente()->request('GET', $this->clientHttpGuzz->getUrlCategoria($credencial['merchantId'], $credencial['catalogId']), [
                "headers" => [
                    'Content-Type' => "application/json",
                    'Accept' => "application/json",
                    "Authorization" => $token
                ],
                "query" => [
                    "merchantId" => $credencial['merchantId']
                ]
            ]);
            return response($request->getBody(), 200, ['Content-Type' => "application/json"]);
        } catch (Exception $e) {
            if ($this->verifyToken($e->getMessage())) {
                return $this->getCategorias($credencial);
            }
            return response(["error" => $e->getMessage()], 200, ['Content-Type' => "application/json"]);
        }
    }

    public function postProdutos($credencial)
    {
        $token =   $this->session->get('token') ?? "vazio";
        try {
            $request = $this->clientHttpGuzz->getCliente()->request('POST', $this->clientHttpGuzz->getUrlPostProduto($credencial['merchantId']), [
                "headers" => [
                    'Content-Type' => "application/x-www-form-urlencoded",
                    'Accept' => "application/json",
                    "Authorization" => $token
                ],
                "form_params" => [
                    "name" => $credencial['name'],
                    "description" => $credencial['description'],
                    "externalCode" => $credencial['externalCode'] ?? uniqid(),
                    "serving" => $credencial['serving'],
                    "dietaryRestrictions" => $credencial['dietaryRestrictions'] ?? [],
                    "weight" => [
                        "quantity" =>  $credencial['weight']['quantity'] ?? "",
                        "unit" =>  $credencial['weight']['unit'] ?? ""
                    ]
                ]
            ]);

            return response($request->getBody(), 201, ['Content-Type' => "application/json"]);
        } catch (Exception $e) {


            if ($this->verifyToken($e->getMessage())) {

                $this->postProdutos($credencial);
            }
            return response(["error" => $e->getMessage()], 401, ['Content-Type' => "application/json"]);
        }
    }

    public function postCategoria($credencial)
    {
        $token = $this->session->get('token') ?? "vazio";
        try {
            $request = $this->clientHttpGuzz->getCliente()->request('POST', $this->clientHttpGuzz->getUrlPostCategoria($credencial['merchantId'], $credencial['catalogId']), [
                "headers" => [
                    'Content-Type' => "application/x-www-form-urlencoded",
                    'Accept' => "application/json",
                    "Authorization" => $token
                ],
                "form_params" => [
                    "name" => $credencial['name'],
                    "status" => $credencial['status'],
                    "template" => $credencial['template']
                ]
            ]);

            return response($request->getBody(), 200, ['Content-Type' => "application/json"]);
        } catch (Exception $e) {
            if ($this->verifyToken($e->getMessage())) {
                return $this->postCategoria($credencial);
            }
            return response(["error" => $e->getMessage()], 200, ['Content-Type' => "application/json"]);
        }
    }

    //criar item 
    public function postItem($credencial)
    {
        $token = $this->session->get('token') ?? "vazio";
        // var_dump();die();

        $response = $this->clientHttpGuzz->getCliente()->request($this->clientHttpGuzz->getUrlPostItems($credencial['merchantId'], $credencial['categoryId'], $credencial['productId']), [
            "headers" => [
                'Content-Type' => "application/multipart/form-data",
                'Accept' => "application/json",
                "Authorization" => $token
            ],
        ]);
    }





    protected function verifyToken($token)
    {

        if (str_contains($token, 'token expired')) {
            $response = json_decode($this->apiRepositorio->getToken()->content());

            if (isset($response->token)) {
                return true;
            }
            return  false;
        }
        return false;
    }
}
