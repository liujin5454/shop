<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'config';

    //支付宝appid
    const ALIPAY_APP_ID = '';
    //支付宝公匙
    const ALI_PUBLIC_KEY = '';
    //支付宝私匙
    const  PRIVATE_KEY = '';
}
