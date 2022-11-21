<?php

namespace App\Http\Requests\Login;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        $rules = [
            "email" => "required|email",
            "password" => "required|min:5|max:12"
        ];
        return $rules;
    }
    public function messages()
    {
        return [
            'email.required' => "O campo email é orbrigatorio!",
            "email.email" => "Informe um email valido!",

            'password.required' => "O campo senha é obrigatorio!",
            "password.min" => "O campo senha não poder conter menos de 5 caracteres!",
            "password.max" => "O campo senha não pode conter mais de 12 caracteres!"
        ];
    }
}
