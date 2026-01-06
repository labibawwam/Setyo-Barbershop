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
    // 1. Validasi Data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
        'role' => 'required|in:admin,customer', 
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Tambahkan validasi file
    ]);

    // 2. Hash Password (dilakukan sebelum create)
    $validatedData['password'] = Hash::make($validatedData['password']);

    // 3. Penanganan Upload File
    if ($request->hasFile('profile_picture')) {
        // Simpan file dan ambil path-nya
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        $validatedData['profile_picture'] = $path;
    }

    // 4. Eksekusi Simpan ke Database
    // Pastikan 'name', 'email', 'password', 'role', dan 'profile_picture' ada di $fillable Model User
    User::create($validatedData);

    // 5. Redirect dengan Pesan Sukses
    return redirect()
        ->route('admin.users.index')
        ->with('success', 'User berhasil ditambahkan ke sistem.');
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
