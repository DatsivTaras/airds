<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Cities;
use App\Models\Classes;
use App\Models\Comments;
use App\Models\Countries;
use App\Models\Country;
use App\Models\Flights;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\DB;

class FlightsController extends Controller
{
    public function index(Request $request)
    {
        // dd(session()->get('applocale'));
        $flights =  Flights::query();
        $now =  Carbon::now();
        $week = $now->subDays(7);
        $tomorrow = Carbon::tomorrow()->format('d-m-Y H:i:s');
        $citiesOfDispatch=[];
        $classes=[];

        $countries = DB::table('countries')
            ->selectRaw('countries.id as id, JSON_UNQUOTE(JSON_EXTRACT(language_lines.text, "$.'.session()->get('applocale').'")) as name')
            ->join('language_lines', 'countries.name', '=', 'language_lines.key')
            ->get()
            ->pluck('name', 'id');

        $countries->prepend(__('main.selectCountry'));


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

    public function sendingComment(Request $request)
    {
        $comment = new  Comments();
        $comment->fill($request->all());
        $comment->user_id = auth()->id();
        $comment->save();

        $commentVal = [
            'id' => $comment->id,
            'user_now' => $comment->user_id,
            'text' => $comment->text,
            'user_name' =>  $comment->user->name,
            'user_id' => $comment->user_id,
            'created_at' => $comment->created_at->format('d-M-h:i'),
        ];

        return json_encode([
            'comment' => $commentVal,
        ]);
    }
    public function deleteComment(Request $request)
    {
        $comment = Comments::find($request->id);
        $comment->delete();

        return json_encode(true);
    }


    public function allComments(Request $request)
    {
        $allComments = [];
        $allCommentsd = Comments::query()
            ->where('flight_id', $request->id)
            ->orderBy('created_at','DESC')
            ->get();

            foreach($allCommentsd as $comment) {
                $allComments[] = [
                    'id' => $comment->id,
                    'user_now' => $comment->user_id,
                    'text' => $comment->text,
                    'user_name' =>  $comment->user->name,
                    'user_id' => $comment->user_id,
                    'created_at' => $comment->created_at->format('d-M-h:i'),
                ];
            }

            return json_encode([
                'allCommentsd' => $allComments,
            ]);
    }


    public function citiOfFlights(Request $request)
    {
        $html = '';

        $cities = Cities::where('country_id', $request->id)->get();


        $cities = DB::table('cities')
        ->selectRaw( 'cities.id as id , JSON_UNQUOTE(JSON_EXTRACT(language_lines.text, "$.'.session()->get('applocale').'")) as name')
        ->join('language_lines', 'cities.name', '=', 'language_lines.key')
        ->where('country_id', $request->id)
        ->get();
        foreach ($cities as $citi){
            $html.= '<option value ="'.$citi->id.'">'.$citi->name.'</option>';
        }
        return response()->json($html);
    }




}
// $countries = DB::table('countries')
// ->selectRaw('countries.id as id, JSON_UNQUOTE(JSON_EXTRACT(language_lines.text, "$.'.session()->get('applocale').'")) as name')
// ->join('language_lines', 'countries.name', '=', 'language_lines.key')
// // ->toArray()
// ->get()
// ->pluck('name', 'id');
