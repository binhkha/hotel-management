<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // Tìm user trong database
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            session([
                'user_logged_in' => true,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_role' => $user->role,
                'user_id' => $user->id
            ]);
            return redirect()->back()->with('success', 'Đăng nhập thành công!');
        }

        return redirect()->back()->with('error', 'Email hoặc mật khẩu không đúng!');
    }

    public function register(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:6|confirmed'
        ]);

        // Tạo user mới
        $user = User::create([
            'name' => $request->fullname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone
        ]);

        // Tự động đăng nhập sau khi đăng ký
        session([
            'user_logged_in' => true,
            'user_name' => $user->name,
            'user_email' => $user->email
        ]);

        return redirect()->back()->with('success', 'Đăng ký thành công!');
    }

    public function logout()
    {
        session()->forget(['user_logged_in', 'user_name', 'user_email']);
        return redirect('/')->with('success', 'Đăng xuất thành công!');
    }
} 