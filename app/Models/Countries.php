<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    use HasFactory;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable = [
        'name',
    ];

    public function cities()
    {
        return $this->hasMany(Cities::class, 'country_id');

    }
    public function flights()
    {
        return $this->hasMany(Flights::class, OrdersFlights::class);

    }
    public function flightds()
    {
        return $this->belongsToThrough(Flights::class, OrdersFlights::class);

    }

}
