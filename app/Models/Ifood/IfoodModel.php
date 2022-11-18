<?php

namespace App\Models\Ifood;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

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

    public function ClienteHttps($method, $url, $headers = [], $data = [], $query = [])
    {
        $response =  Http::withHeaders($headers)->asForm()->post(
            $url,
            [
                $data
            ],
            $query
        );
        return response($response);
    }
}
