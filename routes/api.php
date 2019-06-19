<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//支付回调
Route::post('payment/alipay/notify', 'Api\v1\PayController@alipayNotify')->name('payment.alipay.notify');
//查询物流
Route::get('get_express','Tools\ExpressController@getExpress');
//不用登陆可以访问
Route::group([

    'prefix' => 'v1'

    ],function(){

    // 用户登陆
    Route::get('login', 'Api\v1\AuthController@login');
    // 发送登陆短信
    Route::post('send_sms_login', 'Api\v1\AuthController@sendSmsLogin');
    // 短信登陆
    Route::post('sms_login', 'Api\v1\AuthController@smsLogin');
    // 发送注册短信
    Route::post('send_sms_register', 'Api\v1\AuthController@sendSmsRegister');
    // 注册
    Route::post('register', 'Api\v1\AuthController@register');
    //返回首页轮播图
    Route::get('banner','Api\v1\BannerController@getBanner');
    //返回所有分类
    Route::get('category','Api\v1\CategoryController@getCategory');
    //返回分类下的商品
    Route::get('category_product','Api\v1\CategoryController@getCategoryByProduct');
    //根据商品id返回商品详情
    Route::get('product','Api\v1\ProductController@getProduct');
});

//登陆后才能访问
Route::group([

    'prefix' => 'v1',
    'middleware' => 'refresh.token'

],function () {

    // 发送重置密码短信
    Route::post('send_reset_sms', 'Api\v1\AuthController@sendResetSms');
    // 重置密码
    Route::post('reset', 'Api\v1\AuthController@Reset');
    //获取购物车商品
    Route::get('cart','Api\v1\CartsController@getCart');
    //添加购物车商品
    Route::post('add_cart','Api\v1\CartsController@addCart');
    //获取所有收货地址
    Route::get('get_address','Api\v1\AddressController@getAddress');
    //添加收货地址
    Route::post('add_address','Api\v1\AddressController@addAddress');
    //编辑收货地址
    Route::post('edit_address','Api\v1\AddressController@editAddress');
    //下单
    Route::post('add_order','Api\v1\OrdersController@addOrder');
    //付款
    Route::get('payment/order/alipay', 'Api\v1\PayController@payByAlipay')->name('payment.alipay');
    //查看订单
    Route::get('get_order','Api\v1\OrdersController@getOrder');
    //展示订单详情
    Route::get('show_order','Api\v1\OrdersController@showOrder');
});