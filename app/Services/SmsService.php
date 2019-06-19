<?php
namespace App\Services;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/4 0004
 * Time: 上午 10:36
 */
use Cache;
use Overtrue\EasySms\EasySms;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;

class SmsService
{
    /**
     * @param $phone
     * @param $templateId
     * @param null $content
     * @return string
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     */
    public static function send($phone, $templateId, $content = null)
    {//str_pad把字符串填充为新的长度参数一规定填充的字符串,2规定长度,3规定供填充的字符串.默认是空白,4从什么地方填充
        $code = str_pad(rand(0, 9999), 4, 0, STR_PAD_LEFT);
        $minute = 5;
        //如果是本地那就用验证码1234,如果是线上就运行环境就发送短信验证
        if(app()->isLocal()) {
            $code = 1234;
        } else {
            //发短信
            try {
                $app = new EasySms(config('easysms'));
                $app->send($phone, [
                    'content'  => "验证码{$code}，感谢您的支持！",
                    'template' => config('easysms.templates.sign_up'),
                    'data' => [
                        'code' => $code
                    ],
                ]);
            } catch (NoGatewayAvailableException $exception) {
                \Log::error('sms send error: ' . json_encode($exception->getExceptions()));
                abort(400, '短信发送失败!' . $exception->getMessage());
            }
        }



        //生成一个key将其缓存起来
        $key = $phone . str_random(16);
        Cache::put($key, compact('code', 'phone'), $minute);

        return $key;
    }
}
