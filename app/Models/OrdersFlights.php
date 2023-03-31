<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersFlights extends Model
{
    use HasFactory;

    public function flight()
    {
        return $this->hasOne(Flights::class, 'id', 'flight_id');
    }

    public function booking()
    {
        return $this->hasOne(Booking::class, 'id', 'booking_id');
    }

    public function order()
    {
        return $this->hasOne(Orders::class, 'id', 'order_id');
    }
}
