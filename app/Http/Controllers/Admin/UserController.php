<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,customer',
            'phone_number' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|max:2048'
        ]);

        if($request->hasFile('profile_picture')){
            $data['profile_picture'] = $request->file('profile_picture')->store('profile_pictures','public');
        }

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin.users.index')->with('success','User berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required|in:admin,customer',
            'phone_number' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|max:2048'
        ]);

        if($request->hasFile('profile_picture')){
            $data['profile_picture'] = $request->file('profile_picture')->store('profile_pictures','public');
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success','User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success','User berhasil dihapus');
    }
}
