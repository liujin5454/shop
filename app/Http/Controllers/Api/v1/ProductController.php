<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    //根据id返回商品详情
    public function getProduct(Request $request)
    {
        $id = $request->id;
        return response()->json(Product::with('productImg')->where('id',$id)->where('is_buy',1)->get());
    }
}
