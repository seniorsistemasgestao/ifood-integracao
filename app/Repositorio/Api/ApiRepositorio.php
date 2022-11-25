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


        if (!empty($validarUser)) {
            $credencial['clientId'] ?? $credencial['clientId'] = $validarUser->cliente_id;
            $credencial['clientSecret'] ?? $credencial['clientSecret'] = $validarUser->cliente_screto;
            $credencial['grantType'] ?? $credencial['grantType'] = 'client_credentials';
        }

        $request = $this->clientHttp->getCliente()::withHeaders([
            'Content-Type' => "application/x-www-form-urlencoded",
            'Accept' => "application/json"
        ])->asForm()->post($this->clientHttp->getUrlToken(), $credencial)->object();

        if (isset($request->accessToken)) {
            $this->session->set('token', 'Bearer ' . $request->accessToken);
        }
        return response()->json($request);
    }


    public function getProdutos($credencial)
    {

        if (!$this->session->verifySession('token')) {
            $this->getToken();
            $this->getProdutos($credencial);
        }
        $token = $this->session->get('token');


        $request = $this->clientHttp->getCliente()::withHeaders([
            'Content-Type' => "application/json",
            'Accept' => "application/json",
            "Authorization" => $token
        ])->asForm()->get($this->clientHttp->getUrlProdutos($credencial['merchantId']), $credencial)->object();
        if (isset($request->message) && $request->message == "token expired") {
            $this->getToken();
            $this->getProdutos($credencial);
        }
        return response()->json($request);
    }

    public function getCatalogos($credencial)
    {
        if (!$this->session->verifySession('token')) {
            $this->getToken();
            $this->getCatalogos($credencial);
        }
        $token = $this->session->get('token') ?? "vazio";


        $request = $this->clientHttp->getCliente()::withHeaders([
            'Content-Type' => "application/json",
            'Accept' => "application/json",
            "Authorization" => $token
        ])->asForm()->get($this->clientHttp->getUrlGetCalalogo($credencial['merchantId']))->object();

        if (isset($request->message) && $request->message == "token expired") {
            $this->getToken();
            $this->getCatalogos($credencial);
        }

        return response()->json($request);
    }

    public function getCategorias($credencial)
    {

        if (!$this->session->verifySession('token')) {
            $this->getToken();
            $this->getCategorias($credencial);
        }
        $token = $this->session->get('token') ?? "vazio";


        $request = $this->clientHttp->getCliente()::withHeaders([
            'Content-Type' => "application/json",
            'Accept' => "application/json",
            "Authorization" => $token
        ])->asForm()->get($this->clientHttp->getUrlCategoria($credencial['merchantId'], $credencial['calatogId']))->object();

        if (isset($request->message) && $request->message == "token expired") {
            $this->getToken();
            $this->getCategorias($credencial);
        }
        return response()->json($request);
    }

    public function postProdutos($credencial)
    {

        if (!$this->session->verifySession('token')) {
            $this->getToken();
            $this->postProdutos($credencial);
        }

        $token =   $this->session->get('token') ?? "vazio";


        $request = $this->clientHttp->getCliente()::withHeaders([
            'Content-Type' => "application/json",
            'Accept' => "application/json",
            "Authorization" => $token
        ])->asForm()->post($this->clientHttp->getUrlPostProduto($credencial['merchantId']), $credencial);

        if (isset($request->message) && $request->message == "token expired") {
            $this->getToken();
            $this->postProdutos($credencial);
        }
        return response()->json($request);
    }

    public function postCategoria($credencial)
    {
        if (!$this->session->verifySession('token')) {
            $this->getToken();
            $this->postCategoria($credencial);
        }
        $token = $this->session->get('token') ?? "vazio";

        $request = $this->clientHttp->getCliente()::withHeaders([
            'Content-Type' => "application/x-www-form-urlencoded",
            'Accept' => "application/json",
            "Authorization" => $token
        ])->asForm()->post($this->clientHttp->getUrlPostCategoria($credencial['merchantId'], $credencial['catalogId']), $credencial)->object();

        if (isset($request->message) && $request->message == "token expired") {
            $this->getToken();
            $this->postCategoria($credencial);
        }
        return response()->json($request);
    }

    //criar item 
    public function postItem($credencial)
    {

        if (!$this->session->verifySession('token')) {
            $this->getToken();
            $this->postItem($credencial);
        }
        $token = $this->session->get('token');

        $curl = curl_init($this->clientHttp->getUrlPostItems($credencial['merchantId'], $credencial['categoryId'], $credencial['productId']));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: {$token}"
        ]);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($credencial));
        $result =  curl_exec($curl);
        curl_close($curl);
        $ob = json_decode($result);
        if (isset($ob->message) && $ob->message == "token expired") {
            $this->getToken();
            $this->postItem($credencial);
        }
        return $ob;
    }
}
