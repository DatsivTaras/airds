<?php

namespace App\Console\Commands;

use App\Components\ImportCiti;
use App\Models\Cities;
use App\Models\Countries;
use App\Models\Country;
use Illuminate\Console\Command;
use PhpParser\JsonDecoder;

class ImportCitiesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:jsonplaceholder';

    protected $description = 'Get data from country ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $import = new ImportCiti();
        $response = $import->client->request ('GET' ,  'countries/');
        $data =  json_decode($response->getBody()->getContents());

        foreach ($data->data as  $country) {
            $addcountry = new Country();
            $addcountry->name = $country->country;
            $addcountry->save();

            foreach($country->cities as $citi) {
                $addciti = new Cities();
                $addciti->country_id = $addcountry->id;
                $addciti->name = $citi;
                $addciti->save();
            }
        }
    dd('FINICH');
    }
}
