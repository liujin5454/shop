<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\SmsService;
use App\Http\Controllers\Controller;
use Cache;
use App\Config;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * 账号密码登录
     */
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'phone' => 'required|regex:/^1[23456789]\d{9}$/',
            'password' => 'required',
        ], [
            'phone.regex' => '请输入正确的手机号码'
        ]);
        if ($token = auth('api')->attempt($validatedData)) {
            return response(compact('token'));
        } else {
            return response('账号或者密码错误')->setStatusCode(400);
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     * 登录短信发送
     */
    public function sendSmsLogin(Request $request)
    {
        $this->validate($request, [
            'phone' => ['required', 'exists:users', 'regex:/^1[23456789]\d{9}$/'],
        ], [
            'phone.required' => '请填写手机号',
            'phone.exists' => '手机号尚未注册',
            'phone.regex' => '请填写正确的手机号码'
        ]);
        $key = SmsService::send($request->phone,'', '');
        return response(compact('key'));
    }



    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * 短信登录
     */
    public function smsLogin(Request $request)
    {
       $request->validate([
            'phone' => 'required|regex:/^1[23456789]\d{9}$/',
            'code' => 'required',
            'key' => 'required',
        ], [
            'phone.regex' => '请输入正确的手机号码'
        ],
            ['code' => '验证码']);
        $cacheResult = Cache::get($request->key);

        if (!$cacheResult) {
            return response('验证码已过期, 请重新获取')->setStatusCode(400);

        }

        if ($cacheResult['phone'] == $request->phone && $cacheResult['code'] == $request->code) {
            //验证码正确
            $user = User::where('phone', $request->phone)->firstOrFail();

            $token = auth('api')->login($user);

            Cache::forget($request->key);


            return response(compact('token'));
        } else {
            return response('验证码有误')->setStatusCode(400);
        }
    }



    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     * 发送注册短信
     */
    public function sendSmsRegister(Request $request)
    {
        $this->validate($request, [
            'phone' => ['required', 'unique:users', 'regex:/^1[23456789]\d{9}$/'],
        ], [
            'phone.required' => '请填写手机号',
            'phone.unique' => '手机号已注册过了, 请直接登录',
            'phone.regex' => '请填写正确的手机号码'
        ]);

        $key = SmsService::send($request->phone, '', '');

        return response(compact('key'));
    }



    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     * 注册
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
            'password' => 'required|min:6',
            'phone' => 'required|unique:users|regex:/^1[23456789]\d{9}$/',

        ], [
            'code.required' => '请填写验证码',
            'phone.required' => '手机号不能为空',
            'password.required' => '请输入密码',
            'password.min' => '密码最少为6位',
            'phone.regex'=>'您输入的电话号码有误',
            'phone.unique'=>'您的电话已注册过'
        ]);
        $cacheResult = Cache::get($request->key);

        if(!$cacheResult) {
            abort(400, '验证码已过期, 请重新获取');
        }
        if($cacheResult['phone'] == $request->phone && $cacheResult['code'] == $request->code) {
            //验证码正确
            $user = new User();
            $user->phone = $request->phone;
            $user->password = bcrypt($request->password);



            $user->save();

            $token = auth('api')->login($user);

            return response(compact('token'));
        } else {
            abort(400, '验证码有误');
        }

    }



    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     * 发送重置密码验证短信
     */
    public function sendResetSms(Request $request)
    {
        $this->validate($request, [
            'phone' => ['required', 'exists:users','regex:/^1[23456789]\d{9}$/'],
        ], [
            'phone.required' => '请填写手机号',
            'phone.exists' => '手机号尚未注册',
            'phone.regex'=>'请填写正确的手机号码'
        ]);

        $key = SmsService::send($request->phone, '', '');

        return response(compact('key'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     * 重置密码
     */
    public function Reset(Request $request)
    {
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
            'password' => 'required|min:6',
            'phone' => ['required'],

        ], [
            'code.required' => '请填写验证码',
            'phone.required' => '手机号不能为空',
            'password.required' => '请输入密码',
            'password.min' => '密码最少为6位',
        ]);

        $cacheResult = Cache::get($request->key);

        if(!$cacheResult) {
            abort(400, '验证码已过期, 请重新获取');
        }

        if($cacheResult['phone'] == $request->phone && $cacheResult['code'] == $request->code) {
            //验证码正确
            $user = User::where('phone', $request->phone)->firstOrFail();

            //更新密码
            $user->password = bcrypt($request->password);
            $user->save();

            $token = auth('api')->login($user);

            Cache::forget($request->key);

            return response(compact('token'));
        } else {
            abort(400, '验证码有误');
        }
    }

}
