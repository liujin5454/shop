<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    //返回所有分类
    public function getCategory()
    {
        return response()->json(Category::get());
    }

    //返回分类下的所有商品
    public  function getCategoryByProduct(Request $request)
    {
        $category_id = $request->category_id;
        return response()->json(Category::find($category_id)->categoryByProduct);
    }
}
