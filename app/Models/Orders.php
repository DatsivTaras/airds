<?php

namespace App\Models;

use App\Classes\Enum\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'surname',
        'phone',
        'delivery_id',
    ];

    public function orderFlight()
    {
        return $this->hasMany(OrdersFlights::class, 'order_id');
    }
    public function getStatus()
    {
        $statuses = self::statusList();

        return array_key_exists($this->status, $statuses) ?  $statuses[$this->status] : "";
    }

    public function statusList()
    {
        return [
            OrderStatus::BASKET => 'В кошику',
            OrderStatus::BOOKED => 'Заброньовано',
            OrderStatus::CONFIRMED => 'Підтверджено',
            OrderStatus::DENIED => 'Відмінено'
        ];
    }

    public function sum($order)
    {
        $sum= '0';
        foreach($order->orderFlight as $orderFlight){

            $price = $orderFlight->booking->price;
            $sum = $sum + $price ;

        }
        return $sum ;
    }
}
