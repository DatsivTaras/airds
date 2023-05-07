<?php

use App\Models\Orders;

function countsProducts()
{
    $orders = Orders::where('user_id',auth()->user()->id)->where('status',0)->first();
    $countsProducts='';
    if(!empty($orders->id)){
        $countsProducts = $orders->orderFlight()->count();
    }
    return $countsProducts;
}
