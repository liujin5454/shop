<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Carts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartsController extends Controller
{
    //获取购物车
    public function getCart()
    {
        return Carts::with('cartInProduct')->where('user_id',auth()->user()->id)->get();
    }

    //添加购物车
    public function addCart(Request $request)
    {
        $product_id  = $request->input('product_id');
        $amount = $request->input('amount');

        // 从数据库中查询该商品是否已经在购物车中
        $result = Carts::where('user_id',auth()->user()->id)->where('product_id',$product_id)->first();
        if ($result != null)
        {

            // 如果存在则直接叠加商品数量
            Carts::where('user_id',auth()->user()->id)->where('product_id',$product_id)->update([
                'amount' => $result->amount + $amount,
            ]);
        } else {

            // 否则创建一个新的购物车记录
            $cart = new Carts();
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product_id;
            $cart->amount = $amount;
            $cart->save();
        }

        return 'SUCCESS';
    }
}
