<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    //
    public function Index(){
        $categories = Category::all();
        $brands = Brand::all();
        $products= Product::paginate(9);
        return view('Client.Layout.Shop',compact('categories','brands','products'));
    }
}
