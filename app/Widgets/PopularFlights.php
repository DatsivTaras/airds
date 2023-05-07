<?php

namespace App\Widgets;

use App\Models\Countries;
use App\Models\Country;
use App\Models\Flights;
use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Facades\DB;

class PopularFlights extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $users = DB::table('countries')
            ->join('flights', 'countries.id', '=', 'flights.countryOfArrival_id')
            ->join('orders_flights', 'orders_flights.flight_id', '=', 'flights.id')
            ->select('countries.id','countries.name', DB::raw('count(*) as count'))
            ->groupBy('countries.id')
            ->orderBy('count','DESC')
            ->get();

            // $hasPosts = Countries::with('flightds')->get();
            // dd($hasPosts);
            // ->whereHas('flights', function($q){
            //     $q->whereHas('orderFlights');
            // })
            // ->select('countries.name','countries.id' )
            // ->groupBy('countries.id')
            // // ->count('countries.id');
            // ->get();

            // foreach($hasPosts as $hasPost){

            //     echo  $hasPost->name ;
            //     echo  $hasPost->id ;

            // }

// // var_dump($hasPosts);


// dd($hasPosts->toSql());


        return view('widgets.popular_flights',compact('users'));
    }
}
