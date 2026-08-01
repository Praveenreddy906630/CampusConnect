<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = User::where('user_type', 'admin')->get();
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'user_type' => 'admin', // ✅ assign admin type
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'New admin added successfully!');
    }

    public function edit(User $admin)
    {
        if ($admin->user_type !== 'admin') {
            return redirect()->back()->with('error', 'Not an admin account.');
        }

        return view('admin.admins.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        if ($admin->user_type !== 'admin') {
            return redirect()->back()->with('error', 'Not an admin account.');
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $admin->name  = $request->name;
        $admin->email = $request->email;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.admins.index')->with('success', 'Admin updated successfully!');
    }

    public function destroy(User $admin)
    {
        if ($admin->user_type !== 'admin') {
            return redirect()->back()->with('error', 'Not an admin account.');
        }

        $admin->delete();

        return redirect()->back()->with('success', 'Admin deleted successfully.');
    }
}
