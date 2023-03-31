<?php

namespace App\Http\Controllers;

use App\Classes\Enum\OrderStatus;
use App\Models\Booking;
use App\Models\Orders;
use Illuminate\Http\Request;

class BookingController extends Controller
{
   public function index(){

        dd('d');
   }

   public function myBooking(){

        $bookings = Booking::where('user_id', auth()->id())->get();
        $notConfirmedOrders = Orders::where('user_id', auth()->id())->whereIn('status',  ['2', '1'])->get();
        return view('bookings', compact('bookings','notConfirmedOrders'));
   }

   public function addBooking(Request $request)
   {
        $order = Orders::find($request->id);
        $order->status = OrderStatus::BOOKED;
        $order->save();

        foreach($order->orderFlight as $flight){
            $booking = Booking::find($flight->booking_id);
            $booking->user_id = auth()->id();
            $booking->status = OrderStatus::BOOKED;
            $booking->save();
        }

        return response()->json($request->id);
   }

   public function edit($id)
   {
    $aircrafts = 'd';


    return view('/booking/edit', compact('aircrafts'));
   }


}
