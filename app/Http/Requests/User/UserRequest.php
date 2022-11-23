<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $method = $this->method();
        $id = Auth::user()->id ?? '';

        $rules = [
            'cliente_id' => 'required|max:90',
            'cliente_secreto' => 'required|max:150',
            'mercado_id' => 'required|max:90',
            'password' => 'required|min:5|max:12',
            'email' => 'required|email|unique:users,email',
        ];

        if ($method === 'PUT') {
            $rules['cliente_id'] = "required|max:90|unique:users,cliente_id,{$id},id";
            $rules['cliente_secreto'] = "required|max:90|unique:users,cliente_secreto,{$id},id";
            $rules['mercado_id'] = "required|max:90|unique:users,mercado_id,{$id},id";
            $rules['email'] = "required|email|unique:users,email,{$id},id";
            $rules['password'] = 'nullable|min:5|max:12';
        }



        return $rules;
    }

    public function messages()
    {
        return [
        
            'cliente_id.required' =>"O campo cliente id é obrigatorio!",
            'cliente_id.max' => 'O campo cliente id não pode conter mais de 90 caracteres!',

            'cliente_secreto.required' =>"O campo cliente secreto é obrigatorio!",
            'cliente_secreto.max' => 'O campo cliente secreto não pode conter mais de 150 caracteres!',

            'mercado_id.required' =>"O campo mercado id é obrigatorio!",
            'mercado_id.max' => 'O campo mercado id não pode conter mais de 90 caracteres!',

            'email.required'=> 'O campo email é obrigatorio!',
            'email.email' => 'Insira um email valido!',
            'email.unique' => 'Este email já esta em uso!',
         
            'password.required' => 'O campo senha é obrigatorio!',
            'password.min' => 'O campo senha não pode conter menos de 5 caracteres!',
            'password.max' => 'O campo senha não pode conter mais de 15 caracteres!',

            'password.confirmed' => 'As senhas não comferem',
            'password_confirmation.required' => 'O campo comfirmar senha é obrigatorio!',
            'password_confirmation.min' => 'O campo comfirmar senha não pode conter menos de 5 caracteres',
            'password_confirmation.max' => 'O campo comfirmar senha não pode conter mais de 15 caracteres',
        ];
    }
}
