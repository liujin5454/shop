<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    //
    public function cartInProduct()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }
}
