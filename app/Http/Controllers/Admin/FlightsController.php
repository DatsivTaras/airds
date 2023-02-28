<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FlightsRequest;
use App\Models\Aircrafts;
use App\Models\Cities;
use App\Models\Countries;
use App\Models\Flights;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

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
        $countries += Countries::pluck('name', 'id')->toArray();
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
        $html = '';
        $cities = Cities::where('country_id', $request->id)->get();
        foreach ($cities as $citi){
            $html.= '<option value ="'.$citi->id.'">'.$citi->name.'</option>';
        }

        return response()->json($html);
    }

    public function store(FlightsRequest $request)
    {
        $aircrafts = new  Flights();
        $aircrafts->fill($request->all());
        $aircrafts->save();

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
    public function update(Request $request, $id)
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
}
