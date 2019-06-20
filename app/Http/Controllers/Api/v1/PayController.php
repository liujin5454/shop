<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Exceptions\InvalidRequestException;
use Yansongda\Pay\Pay;
use Monolog\Logger;

class PayController extends Controller
{
    //支付
    public function payByAlipay(Request $request)
    {
        // 当前用户支付订单
        //$order = Orders::where('id',$request->order_id)->where('user_id',auth()->user()->id)->first();
        $order = Orders::where('id',$request->order_id)->first();
        // 订单已支付或者已关闭
        if ($order->paid_at || $order->closed)
        {
            throw new InvalidRequestException('订单状态不正确');
        }

        $alipay = [
            'app_id' => Config::where('store_id',$request->store_id)->where('key','app_id')->first()->value,
            'ali_public_key' => Config::where('store_id',$request->store_id)->where('key','ali_public_key')->first()->value,
            'private_key'    => Config::where('store_id',$request->store_id)->where('key','private_key')->first()->value,
            'log'            => [
                'file' => storage_path('logs/alipay.log'),
                'level' => Logger::WARNING
            ],
            'mode' => 'dev',
            'notify_url' => route('payment.alipay.notify')
        ];
        // 调用支付宝的支付
//        return app('alipay',$alipay)->web([
//            'out_trade_no' => $order->no, // 订单编号，需保证在商户端不重复
//            'total_amount' => $order->total_amount, // 订单金额，单位元，支持小数点后两位
//            'subject'      => '支付 Laravel Shop 的订单：'.$order->no, // 订单标题
//        ]);
         return Pay::alipay($alipay)->web([
            'out_trade_no' => $order->no, // 订单编号，需保证在商户端不重复
            'total_amount' => $order->total_amount, // 订单金额，单位元，支持小数点后两位
            'subject'      => '支付 Laravel Shop 的订单：'.$order->no, // 订单标题
        ]);
    }

    // 服务器端回调
//    public function alipayNotify()
//    {
//        // 校验输入参数
//        $data  = app('alipay')->verify();
//        // 如果订单状态不是成功或者结束，则不走后续的逻辑
//        // 所有交易状态：https://docs.open.alipay.com/59/103672
//        if(!in_array($data->trade_status, ['TRADE_SUCCESS', 'TRADE_FINISHED']))
//        {
//            return app('alipay')->success();
//        }
//        // $data->out_trade_no 拿到订单流水号，并在数据库中查询
//        $order = Orders::where('no', $data->out_trade_no)->first();
//        // 正常来说不太可能出现支付了一笔不存在的订单，这个判断只是加强系统健壮性。
//        if (!$order)
//        {
//            return 'fail';
//        }
//        // 如果这笔订单的状态已经是已支付
//        if ($order->paid_at)
//        {
//            // 返回数据给支付宝
//            return app('alipay')->success();
//        }
//
//        $order->update([
//            'paid_at'        => Carbon::now(), // 支付时间
//            'payment_no'     => $data->trade_no, // 支付宝订单号
//        ]);
//
//        return app('alipay')->success();
//    }

    public function alipayNotify(Request $request)
    {
        $order = Orders::where('no',$request->out_trade_no)->first();
//        $alipay = [
//            'app_id' => Config::where('store_id',$order->store_id)->where('key','app_id')->first()->value,
//            'ali_public_key' => Config::where('store_id',$order->store_id)->where('key','ali_public_key')->first()->value,
//            'private_key'    => Config::where('store_id',$order->store_id)->where('key','private_key')->first()->value,
//            'log'            => [
//                'file' => storage_path('logs/alipay.log'),
//                'level' => Logger::WARNING
//            ],
//            'mode' => 'dev',
//            'notify_url' => route('payment.alipay.notify')
//        ];
//        // 校验输入参数
//        $pay = Pay::alipay($alipay);
//        $data = $pay->verify();
//        // 如果订单状态不是成功或者结束，则不走后续的逻辑
//        // 所有交易状态：https://docs.open.alipay.com/59/103672
//        if(!in_array($data->trade_status, ['TRADE_SUCCESS', 'TRADE_FINISHED']))
//        {
//            return $pay->success();
//        }
//        // $data->out_trade_no 拿到订单流水号，并在数据库中查询
//        // 正常来说不太可能出现支付了一笔不存在的订单，这个判断只是加强系统健壮性。
//        if (!$order)
//        {
//            return 'fail';
//        }
//        // 如果这笔订单的状态已经是已支付
//        if ($order->paid_at)
//        {
//            // 返回数据给支付宝
//            return $pay->success();
//        }

        $order->update([
            //'paid_at'        => Carbon::now(), // 支付时间
            //'payment_no'     => $data->trade_no, // 支付宝订单号
            payment_no     => 'qweqweqwe'
        ]);

        //return $pay->success();

//        // 校验输入参数
//        $data  = app('alipay')->verify();
//        // 如果订单状态不是成功或者结束，则不走后续的逻辑
//        // 所有交易状态：https://docs.open.alipay.com/59/103672
//        if(!in_array($data->trade_status, ['TRADE_SUCCESS', 'TRADE_FINISHED']))
//        {
//            return app('alipay')->success();
//        }
//        // $data->out_trade_no 拿到订单流水号，并在数据库中查询
//        $order = Orders::where('no', $data->out_trade_no)->first();
//        // 正常来说不太可能出现支付了一笔不存在的订单，这个判断只是加强系统健壮性。
//        if (!$order)
//        {
//            return 'fail';
//        }
//        // 如果这笔订单的状态已经是已支付
//        if ($order->paid_at)
//        {
//            // 返回数据给支付宝
//            return app('alipay')->success();
//        }
//
//        $order->update([
//            'paid_at'        => Carbon::now(), // 支付时间
//            'payment_no'     => $data->trade_no, // 支付宝订单号
//        ]);
//
//        return app('alipay')->success();
    }
}
