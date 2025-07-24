<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GenzeLearnEvent;
use App\Models\Program;
use App\Models\PendaftaranLearns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class GenzeLearnEventController extends Controller
{
    /**
     * Tampilkan semua program bertipe GenZE Learn.
     */
    public function index()
    {
        $programs = Program::where('tipe_program', 'GenZE Learn')
            ->with('genzeLearnEvent')
            ->get();

        return view('admin.learn_events.index', compact('programs'));
    }

    /**
     * Halaman pengaturan event (Zoom + Template + Generate Sertifikat).
     */
    public function show($id)
    {
        $program = Program::with('genzeLearnEvent')->findOrFail($id);

        // auto-create jika belum ada
        $event = $program->genzeLearnEvent;
        if (!$event) {
            $event = GenzeLearnEvent::create([
                'program_id' => $program->id,
                'link_zoom' => null,
                'template_sertifikat' => null,
            ]);
            $program->setRelation('genzeLearnEvent', $event);
        }

        // peserta dengan status diterima
        $peserta = PendaftaranLearns::with('pendaftaran.user')
            ->whereHas('pendaftaran', function ($q) use ($id) {
                $q->where('tipe_program', $id)->where('status', 'diterima');
            })
            ->get();

        return view('admin.learn_events.show', compact('program', 'event', 'peserta'));
    }

    /**
     * Update / simpan Link Zoom.
     */
    public function updateZoom(Request $request, $id)
{
    $request->validate([
        'link_zoom' => 'required|string',
        'tanggal_event' => 'nullable|date',
        'jam_event' => 'nullable'
    ]);

    $program = Program::findOrFail($id);
    $event = $program->genzeLearnEvent ?: new GenzeLearnEvent(['program_id' => $id]);

    $event->link_zoom = $request->link_zoom;
    $event->tanggal_event = $request->tanggal_event;
    $event->jam_event = $request->jam_event;
    $event->program_id = $program->id;
    $event->save();

    return back()->with('success', 'Link Zoom & Tanggal Event berhasil diperbarui.');
}

    /**
     * Upload / ganti template sertifikat (PNG/JPG).
     */
    public function uploadTemplate(Request $request, $id)
    {
        $request->validate([
            'template_sertifikat' => 'required|image|mimes:png,jpg,jpeg|max:4096',
        ]);

        $path = $request->file('template_sertifikat')->store('template_sertifikat', 'public');

        $program = Program::findOrFail($id);
        $event = $program->genzeLearnEvent ?: new GenzeLearnEvent(['program_id' => $id]);

        if ($event->template_sertifikat) {
            Storage::disk('public')->delete($event->template_sertifikat);
        }

        $event->template_sertifikat = $path;
        $event->save();

        return back()->with('success', 'Template sertifikat berhasil diunggah.');
    }

    /**
     * Generate sertifikat massal.
     */
    public function generateMassal($id)
    {
        $program = Program::findOrFail($id);
        $event = $program->genzeLearnEvent;

        if (!$event) {
            return back()->with('error', 'Event belum tersedia.');
        }

        $peserta = PendaftaranLearns::with('pendaftaran.user')
            ->whereHas('pendaftaran', function ($q) use ($id) {
                $q->where('tipe_program', $id)->where('status', 'diterima');
            })
            ->get();

        if ($peserta->isEmpty()) {
            return back()->with('error', 'Tidak ada peserta dengan status diterima.');
        }

        if (!Storage::disk('public')->exists('sertifikat')) {
            Storage::disk('public')->makeDirectory('sertifikat');
        }

        $count = 0;
        foreach ($peserta as $p) {
            if (!$p->sertifikat) {
                $this->buildSertifikatForPeserta($p, $program, $event);
                $count++;
            }
        }

        return back()->with('success', "Sertifikat massal berhasil dibuat untuk {$count} peserta.");
    }

    /**
     * Generate sertifikat PDF dari Blade.
     */
    protected function buildSertifikatForPeserta($pendaftaranLearn, $program, $event, $overwrite = false)
{
    $nama = $pendaftaranLearn->pendaftaran->user->name ?? 'Peserta';

    $pdf = Pdf::loadView('admin.sertifikat_templates.sertifikat', [
        'templatePath'     => $event->template_sertifikat, // Path JPG di storage
        'nama'             => $nama,
        'program_full'     => '', // Kosongkan karena ada di template'
        'tanggal_event'    => '', // Kosongkan karena ada di template
        'nomor_sertifikat' => ''  // Kosongkan karena ada di template
    ])->setPaper('a4', 'landscape');

    $fileName = 'sertifikat_' . Str::slug($nama) . '_' . $pendaftaranLearn->id . '.pdf';
    $pdfPath = 'sertifikat/' . $fileName;

    if ($overwrite && $pendaftaranLearn->sertifikat) {
        Storage::disk('public')->delete($pendaftaranLearn->sertifikat);
    }

    $pdf->save(storage_path('app/public/' . $pdfPath));
    $pendaftaranLearn->update(['sertifikat' => $pdfPath]);
}


    public function regenerateMassal($id)
{
    $program = Program::findOrFail($id);
    $event = $program->genzeLearnEvent;

    if (!$event) {
        return back()->with('error', 'Event belum tersedia.');
    }

    $peserta = PendaftaranLearns::with('pendaftaran.user')
        ->whereHas('pendaftaran', function ($q) use ($id) {
            $q->where('tipe_program', $id)->where('status', 'diterima');
        })
        ->get();

    if ($peserta->isEmpty()) {
        return back()->with('error', 'Tidak ada peserta dengan status diterima.');
    }

    if (!Storage::disk('public')->exists('sertifikat')) {
        Storage::disk('public')->makeDirectory('sertifikat');
    }

    $count = 0;
    foreach ($peserta as $p) {
        // Overwrite sertifikat lama
        $this->buildSertifikatForPeserta($p, $program, $event, true);
        $count++;
    }

    return back()->with('success', "Sertifikat berhasil diperbarui untuk {$count} peserta.");
}


}
