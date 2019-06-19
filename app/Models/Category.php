<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = 'categorys';

    public function categoryByProduct()
    {
        return $this->hasMany('App\Models\Product','category_id','id');
    }
}
