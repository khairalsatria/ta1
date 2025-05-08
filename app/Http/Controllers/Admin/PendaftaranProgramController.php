<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\PendaftaranProgram;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PendaftaranProgramController extends Controller
{
    public function index()
    {
        $pendaftarans = PendaftaranProgram::with(['user', 'program'])->get();
        return view('admin.pendaftaran.program.index', compact('pendaftarans'));
    }

    public function create()
    {
        $programs = Program::all();
        return view('admin.pendaftaran.program.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe_program' => 'required|exists:programs,id',
            'harga' => 'required|numeric',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        PendaftaranProgram::create([
            'user_id' => Auth::id(),
            'tipe_program' => $request->tipe_program,
            'harga' => $request->harga,
            'status' => 'pending',
            'bukti_pembayaran' => $path,
        ]);

        return redirect()->route('admin.pendaftaran.program.index')->with('success', 'Pendaftaran berhasil!');
    }

    public function show($id)
    {
        $pendaftaran = PendaftaranProgram::with(['user', 'program'])->findOrFail($id);
        return view('admin.pendaftaran.program.show', compact('pendaftaran'));
    }
}
