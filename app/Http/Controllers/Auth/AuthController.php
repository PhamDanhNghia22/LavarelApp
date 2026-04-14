<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\User;
use Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// use Validator;


class AuthController extends Controller
{
    //
    public function signup()
    {
        return view('Auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ], [
            'name.required' => "Vui lòng nhập họ tên",
            'email.required' => "Vui lòng nhập email",
            'password.required' => "Vui lòng nhập password",

            'email.unique' => "Email đã tồn tại"
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        if (!empty($data)) {
            $user = User::create([
                'email' => $data['email'],
                'name' => $data['name'],
                'password' => Hash::make($data['password']),

            ]);
            event(new Registered($user));
            return response()->json(['status' => 201, 'message' => 'Đăng ký thành công']);
        }
        return response()->json($data);
    }

    public function signin()
    {
        return view('Auth.Login');
    }

    public function login(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => "Vui lòng nhập email",
            'password.required' => "Vui lòng nhập password",

        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        if(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password']])){
            $request->session()->regenerate();
            return response()->json(['status'=>'200','message'=>'Đăng nhập thành công']);
        }else{
            return response()->json(['status'=>401, 'message'=>'Email hoặc mật khẩu không chính xác']);
        }

    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('/');
    }
}