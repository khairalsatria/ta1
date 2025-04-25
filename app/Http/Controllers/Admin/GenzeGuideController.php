<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GenzeGuide;
use App\Models\PaketGuide;
use App\Models\JadwalGuide2;
use Illuminate\Support\Facades\Storage;

class GenzeGuideController extends Controller
{
    public function index()
    {
        $guides = GenzeGuide::with(['paket', 'jadwal'])->latest()->get();
        return view('admin.genze_guides.index', compact('guides'));
    }

    public function create()
    {
        $pakets = PaketGuide::all();
        $jadwals = JadwalGuide2::all();
        return view('admin.genze_guides.create', compact('pakets', 'jadwals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paket_guide' => 'required|exists:paket_guides,id_paket_guide',
            'harga' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'link_zoom' => 'nullable|string',
        ]);

        if ($request->paket_guide == 2) {
            $request->validate([
                'jadwal_guide2' => 'required|exists:jadwal_guide2,id_jadwalguide2',
            ]);
        } else {
            $request->validate([
                'file' => 'required|file|mimes:pdf,docx,zip,rar,mp4|max:20480',
            ]);
            $request->merge(['jadwal_guide2' => null]);
        }

        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('genze_guides', 'public');
        }

        GenzeGuide::create([
            'paket_guide' => $request->paket_guide,
            'jadwal_guide2' => $request->jadwal_guide2,
            'file' => $path,
            'harga' => $request->harga,
            'keterangan' => $request->keterangan,
            'link_zoom' => $request->link_zoom,
        ]);

        return redirect()->route('admin.genze_guides.index')->with('success', 'Genze Guide berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $guide = GenzeGuide::findOrFail($id);
        $pakets = PaketGuide::all();
        $jadwals = JadwalGuide2::all();

        return view('admin.genze_guides.edit', compact('guide', 'pakets', 'jadwals'));
    }

    public function update(Request $request, $id)
    {
        $guide = GenzeGuide::findOrFail($id);

        $request->validate([
            'paket_guide' => 'required|exists:paket_guides,id_paket_guide',
            'harga' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'link_zoom' => 'nullable|string',
        ]);

        if ($request->paket_guide == 2) {
            $request->validate([
                'jadwal_guide2' => 'required|exists:jadwal_guide2,id_jadwalguide2',
            ]);
        } else {
            $request->validate([
                'file' => 'nullable|file|mimes:pdf,docx,zip,rar,mp4|max:20480',
            ]);
            $request->merge(['jadwal_guide2' => null]);
        }

        if ($request->hasFile('file')) {
            if ($guide->file && Storage::disk('public')->exists($guide->file)) {
                Storage::disk('public')->delete($guide->file);
            }

            $path = $request->file('file')->store('genze_guides', 'public');
            $guide->file = $path;
        }

        $guide->paket_guide = $request->paket_guide;
        $guide->jadwal_guide2 = $request->jadwal_guide2;
        $guide->harga = $request->harga;
        $guide->keterangan = $request->keterangan;
        $guide->link_zoom = $request->link_zoom;
        $guide->save();

        return redirect()->route('admin.genze_guides.index')->with('success', 'Genze Guide berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $guide = GenzeGuide::findOrFail($id);

        if ($guide->file && Storage::disk('public')->exists($guide->file)) {
            Storage::disk('public')->delete($guide->file);
        }

        $guide->delete();

        return redirect()->route('admin.genze_guides.index')->with('success', 'Genze Guide berhasil dihapus.');
    }
}
