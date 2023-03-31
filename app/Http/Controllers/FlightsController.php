<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Classes;
use App\Models\Countries;
use App\Models\Country;
use App\Models\Flights;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class FlightsController extends Controller
{
    public function index(Request $request)
    {

        $flights =  Flights::query();
        $now =  Carbon::now();
        $week = $now->subDays(7);
        $tomorrow = Carbon::tomorrow()->format('d-m-Y H:i:s');
        $citiesOfDispatch=[];
        $countries=[];
        $classes=[];
        $countries +=[
            '' => 'Виберіть Країну'
        ];
        $countries += Countries::pluck('name', 'id')->toArray();

        if (!empty($request->input('filteringCountryOfDispatch'))) {
            $flights->where('countryOfDispatch_id',$request->input('filteringCountryOfDispatch'));
            if (!empty($request->input('filteringCityOfDispatch'))) {
                $flights->where('citiOfDispatch_id',$request->input('filteringCityOfDispatch'));
            }
        }
        if (!empty($request->input('filteringCountryOfArrival'))) {
            $flights->where('countryOfArrival_id',$request->input('filteringCountryOfArrival'));
            if (!empty($request->input('filteringCityOfArrival'))) {
                $flights->where('citiOfArrival_id',$request->input('filteringCityOfArrival'));
            }
        }
        if (!empty($request->input('filteringDateOfDispatch'))) {
            $flights->whereDate('dateOfDispatch', '>=', $request->input('filteringDateOfDispatch'));
        }
        if (!empty($request->input('filteringDateOfDispatch'))) {
            $flights->whereDate('dateOfDispatch', '>=', $request->input('filteringDateOfDispatch'));
        }
        if (!empty($request->input('filteringDateOfArrival'))) {
            $flights->whereDate('dateOfArrival', '<=', $request->input('filteringDateOfArrival'));
        }

        $flights = $flights->paginate(15);
        $classes += Classes::pluck('name', 'id')->toArray();

        return view('index',compact('flights','week','tomorrow','countries','citiesOfDispatch','classes'));
    }

    public function view(Request $request , $id)
    {
        $flight = Flights::where('id', $id)->first();
        $classes = [];
        $classes +=[
            '' => 'Виберіть Клас'
        ];
        $classes += Classes::pluck('name', 'id')->toArray();
        $count = '22';

        return view('flights/view',compact('flight','request','classes'));
    }







}
