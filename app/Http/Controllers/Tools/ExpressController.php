<?php

namespace App\Http\Controllers\Tools;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ExpressService;

class ExpressController extends Controller
{
    //
    public function getExpress(Request $request)
    {
        $com = $request->com;
        $num = $request->num;

        return response()->json(ExpressService::query($com,$num));
    }
}
