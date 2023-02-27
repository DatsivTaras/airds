<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AircraftsRequest;
use App\Models\Aircrafts;
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
        $aircrafts = Aircrafts::all();

        return view('admin/aircrafts/index',compact('aircrafts'));
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
        $data = $request->validated();
        $aircraftsImage = $data['aircrafts_image'];
        $data['aircrafts_image'] = Storage::put('/public/image/aircrafts', $aircraftsImage);
        $aircraftsImage->product_image = $data['aircrafts_image'];

        $aircrafts = new  Aircrafts();
        $aircrafts->fill($request->all());
        $aircrafts->aircrafts_image = $data['aircrafts_image'];
        $aircrafts->save();

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
        $aircrafts = Aircrafts::where('id', $request->id)->first();
        $aircrafts->delete();

        return true ;
    }
}
