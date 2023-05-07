<?php

namespace App\Components;

use GuzzleHttp\Client;

class ImportCiti
{

    public $client;

    public function __construct()
    {
       $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://countriesnow.space/api/v0.1/',
            // You can set any number of default request options.
            'timeout'  => 60.0,
            'verify' => false,
        ]);
    }

}
