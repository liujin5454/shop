<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Carts;
use App\Models\OrdersItem;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Orders;
use App\Models\Product;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    //获取订单
    public function getOrder()
    {
        return response(Orders::get());
    }

    //根据订单id获取订单详情
    public function showOrder(Request $request)
    {
        return response(Orders::where('id',$request->id)->with('getOrderItem.getProduct')->first());
    }

    //添加订单
    public function addOrder(Request $request)
    {
        $user  = $request->user();
        // 开启一个数据库事务
        $order = \DB::transaction(function () use ($user, $request)
        {
            $address = Address::find($request->input('address_id'));
            // 创建一个订单
            $order   = new Orders([
                'address' => [ // 将地址信息放入订单中
                    'province' => $address->province,
                    'city' => $address->city,
                    'district' => $address->district,
                    'address' => $address->address,
                    'zip' => $address->zip,
                    'contact_name'  => $address->contact_name,
                    'contact_phone' => $address->contact_phone,
                ],
                'remark' => $request->input('remark'),
                'total_amount' => 0,
            ]);
            // 订单关联到当前用户
            $order->user_id = auth()->user()->id;
            $order->store_id = $request->store_id;
            // 写入数据库
            $order->save();

            $totalAmount = 0;
            $cart_product_id = $request->product_id;
            $cart_product_id=explode(',',$cart_product_id);
            // 遍历用户提交的商品,增加销量，减少库存
            foreach ($cart_product_id as $data)
            {
                //根据用户id和商品id获取购物车
                $cart = Carts::where('user_id',auth()->user()->id)->where('product_id',$data)->first();
                //订单从表用于存订单的商品，数量
                $order_item = new OrdersItem();
                //商品表，订单成功之后更新库存和销量
                $product = Product::where('id',$data)->first();
                //判断商品库存是否足以购买
                if($product->stock <= 0)
                {
                    return response('商品库存不足')->setStatusCode('400');
                }
                $product->stock = $product->stock - $cart->amount;      //商品库存等于初始库存减去购物车商品数量
                $product->count = $product->count + $cart->amount;      //商品销量等于购物车商品数量加上初始数量
                $order_item->order_id = $order->id;     //当前订单表跟订单从表关联
                $order_item->product_id = $cart->product_id;    //订单从表获取购物车里面商品
                $order_item->amount = $cart->amount;    //订单从表获取购物车里面商品数量
                $order_item->price = Product::find($data)->price;   //订单从表获取商品表里面商品价格
                $product->update();
                $order_item->save();

                $totalAmount += $order_item->price * $order_item->amount;
            }

            // 更新订单总金额
            $order->update(['total_amount' => $totalAmount]);

            // 将下单的商品从购物车中移除
//            foreach ($cart_product_id as $data)
//            {
//                Carts::where('user_id',auth()->user()->id)->where('product_id',$data)->delete();
//            }

            return $order;
        });

        return $order;
    }
}