<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class StaffController extends Controller
{
    public function __construct()
    {
        // Kiểm tra quyền admin trước khi thực hiện bất kỳ action nào
        $this->middleware(function ($request, $next) {
            if (!session('user_logged_in') || session('user_email') !== 'admin@hotel.com') {
                return redirect('/')->with('error', 'Bạn không có quyền truy cập trang này!');
            }
            return $next($request);
        });
    }

    public function create()
    {
        return view('admin.add_staff');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'position' => 'required|in:receptionist,housekeeper,manager,maintenance',
            'password' => 'required|min:6|confirmed',
            'address' => 'nullable|string|max:500'
        ]);

        try {
            // Tạo nhân viên mới
            $staff = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'role' => 'staff', // Thêm role để phân biệt
                'position' => $request->position,
                'address' => $request->address
            ]);

            return redirect()->back()->with('success', 'Thêm nhân viên thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $staff = User::where('role', 'staff')->orderBy('created_at', 'desc')->get();
        return view('admin.staff_list', compact('staff'));
    }

    public function edit($id)
    {
        $staff = User::where('role', 'staff')->findOrFail($id);
        return view('admin.edit_staff', compact('staff'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'position' => 'required|in:receptionist,housekeeper,manager,maintenance',
            'address' => 'nullable|string|max:500'
        ]);

        try {
            $staff = User::where('role', 'staff')->findOrFail($id);
            $staff->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'position' => $request->position,
                'address' => $request->address
            ]);

            return redirect()->back()->with('success', 'Cập nhật nhân viên thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $staff = User::where('role', 'staff')->findOrFail($id);
            $staff->delete();
            return response()->json(['success' => true, 'message' => 'Xóa nhân viên thành công!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }
}

