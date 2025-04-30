<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MediaPartner;
use Illuminate\Support\Facades\Storage;

class MediaPartnerController extends Controller
{
    public function index()
    {
        $partners = MediaPartner::all();
        return view('admin.media-partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.media-partners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $logo = $request->file('logo')->store('media-partners', 'public');

        MediaPartner::create([
            'nama' => $request->nama,
            'logo' => $logo,
        ]);

        return redirect()->route('admin.media-partners.index')->with('success', 'Media Partner created!');
    }

    public function edit(MediaPartner $media_partner)
    {
        return view('admin.media-partners.edit', compact('media_partner'));
    }

    public function update(Request $request, MediaPartner $media_partner)
    {
        $request->validate([
            'nama' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            Storage::disk('public')->delete($media_partner->logo);
            $logo = $request->file('logo')->store('media-partners', 'public');
            $media_partner->logo = $logo;
        }

        $media_partner->nama = $request->nama;
        $media_partner->save();

        return redirect()->route('admin.media-partners.index')->with('success', 'Updated successfully!');
    }

    public function destroy(MediaPartner $media_partner)
    {
        Storage::disk('public')->delete($media_partner->logo);
        $media_partner->delete();

        return redirect()->route('admin.media-partners.index')->with('success', 'Deleted!');
    }
}
