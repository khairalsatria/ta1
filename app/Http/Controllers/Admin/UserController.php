<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nohp' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
            'photo' => 'nullable|image|max:2048', // Validasi foto jika ada
        ]);

        // Menyimpan data user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->nohp = $request->nohp;
        $user->role = 'user'; // Set role otomatis sebagai 'user'
        $user->password = Hash::make($request->password);

        // Jika ada foto yang diupload
        if ($request->hasFile('photo')) {
            $user->photo = $request->file('photo')->store('photos', 'public');
        }

        // Simpan data
        $user->save();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'nohp' => 'required|string',
            'photo' => 'nullable|image|max:2048', // Validasi foto jika ada
        ]);

        // Update data user
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->nohp = $request->nohp;

        // Jika ada foto yang diupload
        if ($request->hasFile('photo')) {
            $user->photo = $request->file('photo')->store('photos', 'public');
        }

        // Simpan data
        $user->save();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus!');
    }
}
