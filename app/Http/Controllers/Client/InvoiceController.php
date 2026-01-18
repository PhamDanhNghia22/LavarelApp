<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use App\Models\Cart;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Carbon\Carbon;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Mail\OrderSuccessMail;
use Str;

class InvoiceController extends Controller
{
    //
    public function Index()
    {
        if (Auth::user()) {
            $user_id = Auth::user()->id;
            $carts = Cart::with('product', 'size')->where("user_id", $user_id)->get();
        }

        return view('Client.Layout.Invoice', compact('carts'));
    }

    public function Create(Request $request)
    {

        $data = $request->all();
        if (!Auth::check()) {
            return response()->json([
                'status' => 401,
                'message' => 'Vui lòng đăng nhập'
            ], 401);
        }

        $user_id = Auth::user()->id;
        $carts = Cart::with('product', 'size')->where("user_id", $user_id)->get();
        $order_code = '#' . Str::upper(Str::random(10));
        $total = 0;
        foreach ($carts as $cart) {
            if ($cart->product) {
                $total += $cart->product->price * $cart->quantity;
            }
        }
        $invoiceData = [
            'total' => $total,
            'order_code' => $order_code,
            'user_id' => $user_id,
            'InvoiceDate' => Carbon::now()->toDateString(),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
        ];

        // Tạo invoice
        $invoice = Invoice::create($invoiceData);
        // Chuẩn bị data cho bulk insert
        $dataInvoiceDetail = [];
        if (!$invoice) {
            return response()->json([
                'status' => 500,
                'message' => 'Không thể tạo đơn hàng'
            ], 500);
        }
        foreach ($carts as $cart) {
            $dataInvoiceDetail[] = [
                'order_code' => $order_code,
                'name' => $cart->product->name,
                'image' => $cart->product->image,
                'price' => $cart->product->price,
                'quantity' => $cart->quantity,
                // 'size_id' => $cart->size['id'] ? $cart->size['id'] : null,
            ];

        }

        if (!empty($dataInvoiceDetail)) {
            InvoiceDetail::insert($dataInvoiceDetail);
        }
        
        Mail::to(Auth::user()->email)->send(new OrderSuccessMail($invoice));
        Cart::where('user_id', $user_id)->delete();


        //  \Log::info('Creating invoice with data:', $InvoiceDetail);
        return response()->json([
            'status' => 201,
            'message' => 'Đặt hàng thành công',
            'data' => $dataInvoiceDetail
        ]);

    }
}
