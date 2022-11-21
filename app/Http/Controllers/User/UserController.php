<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Login\LoginRequest;
use App\Http\Requests\User\UserRequest;
use App\Repositorio\User\UserRepositorio;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userRepositorio;

    public function __construct()
    {
        $this->userRepositorio = new UserRepositorio();
    }

    public function cadastrarCredenciais()
    {
        return view('User.cadastro');
    }

    public function login()
    {
        return view('User.login');
    }



    public function logout()
    {
        Auth::logout();
        return redirect()->to('/');
    }

    public function postCredencial(UserRequest $credencial)
    {

        if ($this->userRepositorio->cadastrarCredencial($credencial->input())) {
            return redirect('/dashboard');
        }
        return redirect('/cadastro')->with('msg-error', 'Falha ao criar conta e autenticar, por favor verifique as suas credencias do ifood');
    }

    public function dashboard()
    {

        return view('User.dashboard', $this->userRepositorio->getDashboard());
    }

    public function postLogin(LoginRequest $login)
    {

        if ($this->userRepositorio->postLogin($login->input())) {
            return redirect('/dashboard');
        }
        return redirect('/login')->with('msg-error-login', 'Ocorreu um erro ao tentar logar senha ou usuario invalidos!, tente novamente!');
    }
}
