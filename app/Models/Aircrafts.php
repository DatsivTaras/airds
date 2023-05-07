<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aircrafts extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'second_class',
        'first_class',
        'economy_class',
        'description',
        'aircrafts_image',

    ];

    public static function hello()
    {
        return 'Ура робить';
    }

    public function aircraftMainImage()
    {
        return $this->hasOne(Aircraf_image::class, 'aircraft_id','id')->where('status', 1);
    }

}
