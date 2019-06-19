<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    //获取所有收货地址
    public function getAddress()
    {
        return response()->json(Address::get()->where('user_id',auth()->user()->id));
    }

    //添加收货地址
    public function addAddress(Request $request)
    {

        $address = new Address();
        $address->user_id = auth()->user()->id;
        $address->province = $request->province;
        $address->city = $request->city;
        $address->district = $request->district;
        $address->address = $request->address;
        $address->zip = $request->zip;
        $address->contact_name = $request->contact_name;
        $address->contact_phone = $request->contact_phone;
        $address->save();
    }

    //编辑收货地址
    public function editAddress(Request $request)
    {
        $address = Address::find($request->id);
        $address->province = $request->province;
        $address->city = $request->city;
        $address->district = $request->district;
        $address->address = $request->address;
        $address->zip = $request->zip;
        $address->contact_name = $request->contact_name;
        $address->contact_phone = $request->contact_phone;
        $address->save();
    }
}
