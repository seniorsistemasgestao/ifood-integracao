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


    public function getToken($credencial)
    {


        try {
            $request = $this->clientHttpGuzz->getCliente()->request('POST', $this->clientHttpGuzz->getUrlToken(), [
                "headers" => [
                    'Content-Type' => "application/x-www-form-urlencoded",
                    'Accept' => "application/json"
                ],
                "form_params" => [
                    "grantType" => $credencial['grantType'],
                    "clientId" => $credencial['clientId'],
                    "clientSecret" => $credencial['clientSecret']
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
            return response(["error" => $e->getMessage()], 200, ['Content-Type' => "application/json"]);
        }
    }

    public function getCategorias($credencial)
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
            return response(["error" => $e->getMessage()], 200, ['Content-Type' => "application/json"]);
        }
    }


    public function postProdutos($credencial)
    {


        $token = $this->session->get('token') ?? "vazio";
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
            $format = json_decode($request->getBody());
            //$this->session->set('catalogoID', $format[0]->catalogId);
            return response($request->getBody(), 200, ['Content-Type' => "application/json"]);
        } catch (Exception $e) {
            return response(["error" => $e->getMessage()], 200, ['Content-Type' => "application/json"]);
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
            $format = json_decode($request->getBody());
            //$this->session->set('catalogoID', $format[0]->catalogId);
            return response($request->getBody(), 200, ['Content-Type' => "application/json"]);
        } catch (Exception $e) {
            return response(["error" => $e->getMessage()], 200, ['Content-Type' => "application/json"]);
        }
    }

    public function postItem($credencial)
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

                    "status" => $credencial['status'],
                    "price" => [
                        "value" => $credencial['price']['value'] ?? "",
                        "originalValue" => $credencial['price']['originalValue'] ?? "",
                        "scalePrices" => [
                            "minQuantity" => $credencial['price']['scalePrices']['minQuantity'],
                            "price" => $credencial['price']['scalePrices']['price']
                        ]
                    ],
                    "shifts" => [
                        "startTime" =>  $credencial['shifts']['startTime'] ?? "00:00",
                        "endTime" => $credencial['shifts']['endTime'] ?? "23:59",
                        "monday" => $credencial['shifts']['monday'] ?? false,
                        "tuesday" => $credencial['shifts']['tuesday'] ?? false,
                        "wednesday" => $credencial['shifts']['wednesday'] ?? false,
                        "thursday" => $credencial['shifts']['thursday'] ?? false,
                        "friday"  => $credencial['shifts']['friday'] ?? false,
                        "saturday" => $credencial['shifts']['saturday'] ?? false,
                        "sunday" => $credencial['shifts']['sunday'] ?? false
                    ],
                    "tags" => $credencial['tags']
                ]
            ]);
            $format = json_decode($request->getBody());
            //$this->session->set('catalogoID', $format[0]->catalogId);
            return response($request->getBody(), 200, ['Content-Type' => "application/json"]);
        } catch (Exception $e) {
            return response(["error" => $e->getMessage()], 200, ['Content-Type' => "application/json"]);
        }
    }
}
