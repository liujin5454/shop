<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdersItem extends Model
{
    //
    public function getProduct()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }
}
