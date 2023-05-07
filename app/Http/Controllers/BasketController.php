<?php

namespace App\Http\Controllers;

use App\Classes\Enum\OrderStatus;
use App\Models\Booking;
use App\Models\Flights;
use App\Models\Orders;
use App\Models\OrdersFlights;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = Orders::where('user_id', auth()->id())
            ->where('status', OrderStatus::BASKET)
            ->first();
            if (!$order) {
                $order = new Orders();
                $order->user_id = auth()->id();
                $order->status = OrderStatus::BASKET;
                $order->save();
            }
        $ordersFlight = [];
        foreach($order->orderFlight as $flight) {
            $ordersFlight[] = [
                'id' => $flight->id,
                'title' => trans('country.'.mb_strtolower($flight->flight->countryOfDispatch->name)).'-'.trans('country.'.mb_strtolower($flight->flight->countryOfArrival->name)),
                'link' => '/flight/view/'.$flight->flight->id,
                'time' => $flight->flight->formatDateFlight($flight->dateOfDispatch).'--'.$flight->flight->formatDateFlight($flight->dateOfArrival),
                'price' => $flight->booking->price
            ];
        }

        return json_encode([
            'ordersFlight' => $ordersFlight,
            'order_id' => $order->id,
            'sum' => $order->sum($order)
        ]);
    }

    public function addBasket(Request $request ,$id)
    {
         $booking = Booking::where('flight_id' , $id)->where('class' ,$request->classes)->where('place' ,$request->places)->first();
         $order = Orders::where('user_id',auth()->user()->id)->where('status', OrderStatus::BASKET)->first();
        if(!$booking->bookingBasket()){
            if (!$order) {
                $order = new Orders();
                $order->user_id = auth()->id();
                $order->status = OrderStatus::BASKET;
                $order->save();
            }

            $ordersProduct = new OrdersFlights();
            $ordersProduct->flight_id = $id;
            $ordersProduct->booking_id = $booking->id;
            $ordersProduct->order_id = $order->id;
            $ordersProduct->save();

            $booking = Booking::find($booking->id);
            $booking->user_id = auth()->id();
            $booking->status = OrderStatus::BOOKED;
            $booking->save();
        } else{
            dd('Неможливо додати');
        }

        return redirect('/flight/view/'.$id);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

        return redirect('/basket');
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
    public function destroy(Request $request)
    {
        $ordersFlights = OrdersFlights::where('id', $request->id)->first();

        $booking = Booking::find($ordersFlights->booking_id);
        $booking->user_id = NULL;
        $booking->status = NULL;
        $booking->save();

        $ordersFlights->delete();
        return true;

    }
}
