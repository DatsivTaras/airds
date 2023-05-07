<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class CountrySitiApiController extends Controller
{



    function getCountryApi(){

        $response = Http::post('https://countriesnow.space/api/v0.1/countries/population');

        dd();
    }
}
