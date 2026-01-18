<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function Index()
    {
        $NewArrivals = Product::select('id', 'name', 'price', 'image', 'slug')
            ->where('is_active', 1)
            ->orderby('id', 'desc')->get();
        return View('Client.Layout.Home', compact('NewArrivals'));
    }

    public function GetProduct($slug, $id)
    {
        $sizes= Size::all();
        $product = Product::with('sizes')
            ->where('id', $id)
            ->where('slug', $slug)
            ->firstOrFail();
        return View('Client.Layout.Product', compact('product','sizes'));
    }
}
