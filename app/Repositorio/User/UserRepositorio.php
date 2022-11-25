<?php

namespace App\Repositorio\User;

use App\Models\User;
use App\Repositorio\Api\ApiRepositorio;
use App\Repositorio\Session\SessionRepositorio;


use Illuminate\Support\Facades\Auth;


class UserRepositorio
{

    protected $user;
    protected $apiRepositorio;
    protected $session;

    public function __construct()
    {
        $this->user = new User();
        $this->apiRepositorio = new ApiRepositorio();
        $this->session = new SessionRepositorio();
    }

    public function getToken($credencial)
    {

        $response = json_decode($this->apiRepositorio->getToken($credencial)->content());

        //dd($response->accessToken);
        if (!isset($response->accessToken)) {
            return false;
        }
        return true;
    }

    public function cadastrarCredencial($user)
    {

        $token = $this->getToken([
            "grantType" => "client_credentials",
            "clientId" => $user['cliente_id'],
            "clientSecret" => $user['cliente_secreto']
        ]);

        if ($token) {

            $cliente = $this->user->create([
                'mercado_id' => $user['mercado_id'],
                'cliente_id' => $user['cliente_id'],
                'cliente_secreto' => $user['cliente_secreto'],
                'email' => $user['email'],
                "password" => bcrypt($user['password'])
            ]);

            if ($cliente) {
                return Auth::attempt(['email' => $user['email'], 'password' => $user['password']]);
            }
        }

        return false;
    }

    public function getProdutos()
    {
        $mercadoID = Auth::user()->mercado_id;
        $credencial = [
            "merchantId" => $mercadoID,
            "limit" => 200,
            "page" => 1
        ];
        $response = json_decode($this->apiRepositorio->getProdutos($credencial)->content());

        return $response;
    }

    public function postLogin($credencial)
    {

        $validarUser = $this->user->where('email', $credencial['email'])->first();


        $token = $this->getToken([
            "grantType" => "client_credentials",
            "clientId" => $validarUser->cliente_id,
            "clientSecret" => $validarUser->cliente_secreto
        ]);

        if ($token) {
            if (Auth::attempt(['email' => $credencial['email'], 'password' => $credencial['password']])) {
                return true;
            }
            return false;
        }

        return false;
    }

    public function getDashboard()
    {


        $data = [
            "produtos" => ($this->getProdutos()) ?? ""
        ];


        return $data;
    }
}
