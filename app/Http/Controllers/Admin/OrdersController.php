<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Enum\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderProcessingRequest;
use App\Models\Booking;
use App\Models\Delivery;
use App\Models\Orders;
use App\Models\OrdersFlights;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $confirmedOrders = Orders::where('status', OrderStatus::CONFIRMED)->get();
        $notConfirmedOrders = Orders::where('status', OrderStatus::BOOKED)->get();
        $rejectedOrders = Orders::where('status', OrderStatus::DENIED)->get();


        return view('admin/orders/index',compact('confirmedOrders','notConfirmedOrders','rejectedOrders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request)
    {
        $order = Orders::find($request->id);
        $order->status = OrderStatus::CONFIRMED;
        $order->save();

        return json_encode(true) ;
    }
    public function rejectedStatus(Request $request)
    {
        $order = Orders::find($request->id);
        $order->status = OrderStatus::DENIED;
        $order->save();

        foreach($order->orderFlight as $flight){
            $booking = Booking::find($flight->booking_id);
            $booking->user_id = NULL;
            $booking->status = NULL;
            $booking->save();
        }
        return json_encode(true) ;
    }

    public function editOrderProcessing(Request $request)
    {
        $order = Orders::where('id', $request->id)->first();
        $deliveries = Delivery::all();
        return view('admin/orders/edit', compact('order', 'deliveries'));
    }

    public function orderProcessing(OrderProcessingRequest $request)
    {
        $order = Orders::find($request->id);
        $order->fill($request->all());
        $order->status = OrderStatus::BOOKED;
        $order->save();

        foreach($order->orderFlight as $flight){
            $booking = Booking::find($flight->booking_id);
            $booking->user_id = auth()->id();
            $booking->status = OrderStatus::BOOKED;
            $booking->save();
        }
        return json_encode(true) ;
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
