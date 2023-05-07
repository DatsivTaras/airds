<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AircraftsRequest;
use App\Models\Aircraf_image;
use App\Models\Aircrafts;
use App\Services\AircraftServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AircraftsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $aircrafts = Aircrafts::paginate(10);

        return view('admin/aircrafts/index',compact('aircrafts'));
    }
    function generateValues($key, $values) {
        if (is_array($values)) {
            $res = [];
            foreach ($values as $key2 => $value) {
                $nkey = $key.'.'.$key2;
                $res = array_merge($res, $this->generateValues($nkey, $value));
            }

            return $res;
        }

        return [$key => $values];
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aircraft  = new Aircrafts();

        return view('admin/aircrafts/create', compact('aircraft'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AircraftsRequest $request)
    {
        $aircraft = new  Aircrafts();
        $aircraft->name = $request->name ;
        $aircraft->description = $request->description ;
        $aircraft->second_class = $request->second_class ;
        $aircraft->first_class = $request->first_class ;
        $aircraft->economy_class = $request->economy_class ;
        $aircraft->save();

        $k= 0;

        foreach($request->file('aircrafts_image') as $file){

            $aircraft_image = new  Aircraf_image();
            $aircraft_image->image = $file->store('public/image/aircrafts');
            $aircraft_image->aircraft_id = $aircraft->id ;
            if ($k == 0) {
                $aircraft_image->status = 1;
            }
            $aircraft_image->save();
            $k++;
        }

        return redirect('/admin/aircrafts');
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
       $aircraft = Aircrafts::where('id', $id)->first();

       return view('/admin/aircrafts/edit',compact('aircraft'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AircraftsRequest $request, $id)
    {
        $data = $request->validated();
        $aircraftsImage = $data['aircrafts_image'];
        $data['aircrafts_image'] = Storage::put('/public/image/aircrafts', $aircraftsImage);
        $aircraftsImage->product_image = $data['aircrafts_image'];

        $aircrafts = Aircrafts::find($id);
        $aircrafts->fill($request->all());
        $aircrafts->aircrafts_image = $data['aircrafts_image'];
        $aircrafts->save();

        return redirect()->route('admin.aircrafts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request)
    {
        // $aircrafts = Aircrafts::where('id', $request->id)->first();
        // $aircrafts->delete();
        $id = $request->id;
        AircraftServices::deleteAircraft($id);

        return true ;
    }
}
