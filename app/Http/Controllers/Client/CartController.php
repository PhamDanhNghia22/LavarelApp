<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    //
    public function Index()
    {

        $user_id = Auth::check() ? Auth::user()->id : null;
        $carts = Cart::with('product', 'size')->where('user_id', $user_id)->get();

        return view('Client.Layout.Cart', compact('carts'));
    }

    public function Create(Request $request)
    {
        if (Auth::check()) {
            $data = $request->all();
            $user_id = Auth::user()->getAuthIdentifier();
            $product = Product::findOrFail($data['product_id']);
            $size = Size::find($data['size_id']);
            $cart = Cart::where('product_id', $product['id'])
                ->where('size_id', $size['id'])
                ->where('user_id', $user_id)
                ->first();
            if ($cart) {
                $data['quantity'] += 1;
                $cart->update($data);
                return response()->json(['status' => 200, 'message' => 'Them gio hang thanh cong']);
            } else {
                Cart::create([
                    'product_id' => $product['id'],
                    'size_id' => $size['id'],
                    'user_id' => $user_id,
                    'quantity' => $data['quantity'],
                ]);
                return response()->json(['status' => 201, 'message' => 'Them gio hang thanh cong']);
            }

        } else {
            return redirect('/dangnhap');
        }


        // return response()->json([$product,$size]);
    }
    public function Update(Request $request)
    {
        if (Auth::check()) {
            $data = $request->all();
            $user_id = Auth::user()->getAuthIdentifier();
            $product = Product::findOrFail($data['product_id']);
            $size = Size::find($data['size_id']);
            $cart = Cart::where('product_id', $product['id'])
                ->where('size_id', $size['id'])
                ->where('user_id', $user_id)
                ->first();
            if ($cart) {
                $cart->update($data);
                return response()->json(['status' => 200, 'message' => 'Cập nhật thanh cong']);
            } 

        } else {
            return redirect('/dang-nhap');
        }

    }

    public function Delete(Request $request)
    {
        $data = $request->all();
        $cart = Cart::where('product_id', $data['product_id'])
            ->where('size_id', $data['size_id'])
            ->where('user_id', $data['user_id'])
            ->first();
        if ($cart) {
            $cart->delete();
            return response()->json(['status' => 200, 'message' => 'Xoa thành công']);
        }
    }
}
