<?php

namespace App\Models\Ifood;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IfoodModel extends Model
{
    use HasFactory;

    protected $table = 'ifood_api';
    protected $cliente;
    protected $fillable = [
        'token'
    ];

    public function __construct()
    {
        $this->cliente = new \GuzzleHttp\Client();
    }

    public function ClienteHttp($method, $url, $data = null, $headers = null, $query = null)
    {
        $response =  $this->cliente->request($method, $url, [
            "form_params" => $data,
            'headers' => $headers,
            "query" => $query
        ]);

        return json_decode($response->getBody());
    }
}
