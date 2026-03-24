<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        // Tạm thời bỏ middleware auth để test
        // $this->middleware('auth');
    }

    public function show()
    {
        return view('profile');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Xử lý avatar
        $avatarName = null;
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('avatars', $avatarName, 'public');
        }

        // Tạm thời chỉ xử lý avatar, không lưu vào database
        if ($avatarName) {
            return redirect()->route('profile.show')->with('success', 'Upload avatar thành công! Tên file: ' . $avatarName);
        }

        return redirect()->route('profile.show')->with('success', 'Cập nhật thông tin thành công!');
    }
}
