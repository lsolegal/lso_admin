<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class VedicAstroApi
{
    protected $baseUrl;
    protected $api_key;
    protected $lang;

    public function __construct()
    {
        // $this->baseUrl = env('VEDICASTRO_BASE_URL');
        // $this->api_key = env('VEDICASTRO_API_KEY');
        $this->baseUrl = "https://api.vedicastroapi.com/v3-json";
        $this->api_key = "2010326b-4c6f-5a01-90a0-31a33bc54b4e";
        $this->lang = 'en';
        $this->tz = '5.5';
    }

    public function getBirthChart($data)
    {
        $data['lang'] = $this->lang;
        $data['tz'] = $this->lang;
        $http = $this->createHttp();
        return $http->get($this->baseUrl . '/horoscope/planet-details', $data)->body();
    }

    public function getManglicDosh($data)
    {
        // $data['lang'] = $this->lang;
        $http = $this->createHttp();
        return $http->get($this->baseUrl . '/dosha/manglik-dosh', $data)->body();
    }

    public function getPosts()
    {
        return Http::get($this->baseUrl . '/posts');
    }

    protected function isLocal(): bool
    {
        return app()->environment('local');
    }
    protected function createHttp()
    {
        return $this->isLocal() ? Http::withOptions(['verify' => false]) : Http::withHeaders([]);
    }
}
