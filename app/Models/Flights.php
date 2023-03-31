<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flights extends Model
{
    use HasFactory;

    protected $fillable = [
        'countryOfDispatch_id',
        'citiOfDispatch_id',
        'dateOfDispatch',
        'countryOfArrival_id',
        'citiOfArrival_id',
        'dateOfArrival',
        'aircraft_id',
        'price_first_class',
        'price_second_class',
        'price_economy_class',
        'price',
    ];

    public function booking()
    {
        return $this->hasOne(Booking::class, 'flight_id','id')->where('user_id',auth()->id());
    }
    public function formatDateFlight($date)
    {
        return Carbon::parse($date)->format('d-m-Y H:i:s');
    }
    public function countryOfDispatch()
    {
        return $this->hasOne(Countries::class, 'id','countryOfDispatch_id');

    }
    public function citiOfDispatch()
    {
        return $this->hasOne(Cities::class, 'id','citiOfDispatch_id');

    }
    public function countryOfArrival()
    {
        return $this->hasOne(Countries::class, 'id','countryOfArrival_id');

    }
    public function citiOfArrival()
    {
        return $this->hasOne(Cities::class, 'id','citiOfArrival_id');

    }
    public function aircrafts()
    {
        return $this->hasOne(Aircrafts::class, 'id','aircraft_id');

    }

}
