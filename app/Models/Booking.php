<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'flight_id',
        'user_id',
        'class',
        'place',
        'price',
    ];

    public function flight()
    {
        return $this->hasOne(Flights::class, 'id','flight_id');
    }

    public function orderFlight()
    {
        return $this->hasOne(OrdersFlights::class, 'booking_id','id');
    }
}

