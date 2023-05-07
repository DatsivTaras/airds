<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aircraf_image extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'aircraft_id',
    ];

}
