<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    public function productImg()
    {
        return $this->hasMany('App\Models\ProductsImg','product_id','id');
    }
}
