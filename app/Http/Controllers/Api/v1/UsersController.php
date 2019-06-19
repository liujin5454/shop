<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    //注册
    public function register(Request $request)
    {
        //短信验证
        //$verifyData = \Cache::get($request->verification_key);

//        if (!$verifyData) {
//            return $this->response->error('验证码已失效', 422);
//        }
//
//        if (!hash_equals($verifyData['code'], $request->verification_code)) {
//            // 返回401
//            return $this->response->errorUnauthorized('验证码错误');
//        }


        $user = new User();
        $user->store_id = '1';
        $user->nickname = $request->nickname;
        $user->portrait = $request->portrait;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->gender = $request->gender;
        $user->save();

        // 清除验证码缓存
        \Cache::forget($request->verification_key);

        return response()->json(User::get()->where('phone',$request->phone));
    }

    //登陆
    public function login(Request $request)
    {
        $credentials['phone'] = $request->phone;
        $credentials['password'] = $request->password;

        if (!$token = \Auth::guard('api')->attempt($credentials)) {
            return response()->json('用户名或密码错误');
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
        ])->setStatusCode(201);
    }

    //获取用户信息
    public function getUser()
    {
        return response()->json($this->user());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 编辑用户信息
     */
    public function editUser(Request $request)
    {
        $user = $this->user();
        $user->nickname = $request->nickname;
        $user->portrait = $request->portrait;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->gender = $request->gender;
        $user->update();

        return response()->json('EDIT_SUCCESS');
    }
}