<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class MentorController extends Controller
{
    public function index()
    {
        $mentors = User::where('role', 'mentor')->get();
        return view('admin.mentor.index', compact('mentors'));
    }

    public function create()
    {
        return view('admin.mentor.create');
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

        // Menyimpan data mentor
        $mentor = new User();
        $mentor->name = $request->name;
        $mentor->email = $request->email;
        $mentor->nohp = $request->nohp;
        $mentor->role = 'mentor'; // Set role otomatis sebagai 'mentor'
        $mentor->password = Hash::make($request->password);

        // Jika ada foto yang diupload
        if ($request->hasFile('photo')) {
            $mentor->photo = $request->file('photo')->store('photos', 'public');
        }

        // Simpan data
        $mentor->save();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.mentor.index')->with('success', 'Mentor berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $mentor = User::findOrFail($id);
        return view('admin.mentor.edit', compact('mentor'));
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

        // Update data mentor
        $mentor = User::findOrFail($id);
        $mentor->name = $request->name;
        $mentor->email = $request->email;
        $mentor->nohp = $request->nohp;

        // Jika ada foto yang diupload
        if ($request->hasFile('photo')) {
            $mentor->photo = $request->file('photo')->store('photos', 'public');
        }

        // Simpan data
        $mentor->save();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.mentor.index')->with('success', 'Mentor berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $mentor = User::findOrFail($id);
        $mentor->delete();

        return redirect()->route('admin.mentor.index')->with('success', 'Mentor berhasil dihapus!');
    }
}
