<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FlightsRequest;
use App\Models\Aircrafts;
use App\Models\Booking;
use App\Models\Cities;
use App\Models\Countries;
use App\Models\Country;
use App\Models\Flights;
use App\Models\Orders;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Spatie\TranslationLoader\LanguageLine;
use Symfony\Component\Finder\SplFileInfo;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class FlightsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $flights = Flights::all();
        $now =  Carbon::now();
        $week = $now->subDays(7);
        // dd($week);
        // $tomorrow = $now->tomorrow();
        $tomorrow = Carbon::tomorrow()->format('d-m-Y H:i:s');


        return view('admin/flights/index',compact('flights','week','tomorrow'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $flight  = new Flights();
        $flight->countryOfDispatch_id = '';
        $countries=[];
        $countries +=[
            '' => 'Виберіть Країну'
        ];
        // $countries += Countries::pluck('name', 'id')->toArray();

        $citiesOfDispatch = [];
        $citiesOfArrival = [];
        $aircrafts = Aircrafts::pluck('name', 'id')->toArray();

        return view('admin/flights/create', compact('countries','aircrafts','flight', 'citiesOfDispatch', 'citiesOfArrival'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function citiOfFlights(Request $request)
    {

        $movies = [];
        $html = '';
        if($request->has('q')){
            $search = $request->q;
            $movies = DB::table('cities')
                ->selectRaw( 'cities.id as id , JSON_UNQUOTE(JSON_EXTRACT(language_lines.text, "$.'.session()->get('applocale').'")) as name')
                ->join('language_lines', 'cities.name', '=', 'language_lines.key')
                ->where('country_id', $request->id)
                ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(language_lines.text, '$.".session()->get('applocale')."')) LIKE '%".$search."%'")
                ->get();

                foreach ($movies as $citi){
                    $html.= '<option value ="'.$citi->id.'">'.$citi->name.'</option>';
                }
        }
        return response()->json($movies);

        // $html = '';
        // $cities = Cities::where('country_id', $request->id)->get();
        // foreach ($cities as $citi){
        //     $html.= '<option value ="'.$citi->id.'">'.$citi->name.'</option>';
        // }

        // return response()->json($html);
    }

    public function countryOfFlights(Request $request)
    {
        $movies = [];

        if($request->has('q')){
            $search = $request->q;

            $countries = DB::table('countries')
                ->selectRaw('countries.id as id, JSON_UNQUOTE(JSON_EXTRACT(language_lines.text, "$.'.session()->get('applocale').'")) as name')
                ->join('language_lines', 'countries.name', '=', 'language_lines.key')
                ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(language_lines.text, '$.".session()->get('applocale')."')) LIKE '%".$search."%'")
                ->get();
            }
        return  response()->json($countries);
    }

    public function store(FlightsRequest $request)
    {

        $flight = new  Flights();
        $flight->fill($request->all());
        $flight->save();

        for ($i = 1; $i <= $flight->aircrafts->economy_class; $i++) {
            $booking = new  Booking();
            $booking->flight_id = $flight->id;
            $booking->class= '3';
            $booking->place= $i;
            $booking->price= $flight->price_economy_class;

            $booking->save();
        }
        for ($i = 1; $i <= $flight->aircrafts->first_class; $i++) {
            $booking = new  Booking();
            $booking->flight_id = $flight->id;
            $booking->class= '1';
            $booking->place= $i;
            $booking->price= $flight->price_first_class;

            $booking->save();
        }
        for ($i = 1; $i <= $flight->aircrafts->second_class; $i++) {
            $booking = new  Booking();
            $booking->flight_id = $flight->id;
            $booking->class= '2';
            $booking->place= $i;
            $booking->price= $flight->price_second_class;

            $booking->save();
        }

        return redirect('/admin/flights');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $countries = Countries::pluck('name', 'id')->toArray();

        $flight= Flights::where('id', $id)->first();

        $citiesOfDispatch = Cities::where('country_id', $flight->countryOfDispatch_id)->pluck('name', 'id')->toArray();

        $citiesOfArrival = Cities::where('country_id', $flight->countryOfArrival_id)->pluck('name', 'id')->toArray();

        $aircrafts = Aircrafts::pluck('name', 'id')->toArray();

        return view('/admin/flights/edit', compact('flight','countries','citiesOfDispatch','citiesOfArrival','aircrafts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FlightsRequest $request, $id)
    {
        $flight = Flights::find($id);
        $flight->fill($request->all());
        $flight->save();
        return redirect('/admin/flights');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $aircrafts = Flights::where('id', $request->id)->first();
        $aircrafts->delete();

        return true;
    }

    public function placeOfClasses(Request $request)
    {
        $html = '';
        $userId = auth()->id();
        $classes = Booking::where('class', $request->id)
            ->doesntHave('orderFlight', 'and', function($query) use($userId){
                $query->whereHas('order', function($query) use($userId) {
                    $query->where('user_id', '');
                });
            })
            ->where('status', NULL)
            ->where('flight_id', $request->flightId)->get()->toArray();

        return response()->json($classes);
    }

}
