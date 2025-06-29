@php use Illuminate\Support\Facades\Auth; @endphp

@extends('siswa.layout.main')

@section('title', 'Dashboard Siswa')

@section('content')
<h2 class="text-xl font-bold mb-4">Dashboard Siswa</h2>

@if(session('success'))
    <div class="alert alert-success mb-3">
        {{ session('success') }}
    </div>
@endif

<h4 class="font-semibold mb-2">Kelas yang Diikuti:</h4>
<ul class="list-disc list-inside mb-4">
    @foreach($kelasList as $k)
        <li>
            <a href="{{ route('siswa.dashboard', ['kelas_id' => $k->kelas_id]) }}"
               class="text-blue-600 underline">
                {{ $k->kelasGenze->nama_kelas ?? 'Nama Kelas Tidak Ditemukan' }}
            </a>
        </li>
    @endforeach
</ul>

@if($kelasDipilihId && $materi->isNotEmpty())
    <h4 class="text-lg font-bold mb-3">
        Materi Kelas: {{ $kelasList->firstWhere('kelas_id', $kelasDipilihId)->kelasGenze->nama_kelas ?? '' }}
    </h4>

    <div class="space-y-4">
        @foreach($materi->sortBy('pertemuan_ke') as $m)
            <div class="border rounded p-4 shadow">
                <h3 class="text-lg font-semibold">
                    Pertemuan {{ $m->pertemuan_ke }}: {{ $m->judul }}
                </h3>

                @if($m->file_pdf)
                    <p><a href="{{ asset('storage/' . $m->file_pdf) }}" target="_blank" class="text-blue-600 underline">
                        📄 Download Materi (PDF)
                    </a></p>
                @endif

                @if($m->link_zoom)
                    <p>🔗 Zoom:
                        <a href="{{ $m->link_zoom }}" target="_blank" class="text-green-600 underline">
                            Gabung Zoom
                        </a>
                    </p>
                @endif

                @if($m->link_rekaman)
                    <p>▶️ Rekaman:
                        <a href="{{ $m->link_rekaman }}" target="_blank" class="text-purple-600 underline">
                            Lihat Rekaman
                        </a>
                    </p>
                @endif

                @php
                    $jumlahSoal = \App\Models\SoalLatihan::where('kelas_id', $kelasDipilihId)
                        ->where('pertemuan_ke', $m->pertemuan_ke)->count();

                    $pernahJawab = \App\Models\JawabanSoalLatihan::where('user_id', Auth::id())
                        ->whereHas('soal', fn($q) => $q->where('kelas_id', $kelasDipilihId)
                                                     ->where('pertemuan_ke', $m->pertemuan_ke))
                        ->exists();
                @endphp

                @if($jumlahSoal > 0 && !$pernahJawab)
                    <div class="mt-2">
                        <a href="{{ route('siswa.latihan.show', [$kelasDipilihId, $m->pertemuan_ke]) }}"
                           class="inline-block px-3 py-1 bg-blue-500 text-white rounded">
                            ✍️ Kerjakan Soal
                        </a>
                    </div>
                @elseif($jumlahSoal > 0 && $pernahJawab)
                    <div class="mt-2 text-sm text-gray-700">
                        ✅ Soal sudah dikerjakan.
                    </div>
                @endif

                @if(isset($riwayatNilai[$m->pertemuan_ke]))
                    @php
                        $jawaban = $riwayatNilai[$m->pertemuan_ke];
                        $total = $jawaban->count();
                        $benar = $jawaban->where('benar', true)->count();
                        $skor = round($benar / max($total, 1) * 100);
                    @endphp
                    <div class="mt-2 text-sm text-gray-700">
                        ✅ Nilai Latihan Pertemuan {{ $m->pertemuan_ke }}: <strong>{{ $skor }}</strong>
                    </div>
                @endif

               @if($kelasDipilihId)
    <div class="mb-4">
        <p class="font-semibold mb-1">
            Progress Kelas (berdasarkan link Zoom): {{ $pertemuanSudahDilakukan }} dari {{ $totalPertemuan }} pertemuan
        </p>
        <div class="w-full bg-gray-200 rounded-full h-4">
            <div class="bg-green-500 h-4 rounded-full" style="width: {{ $progress }}%"></div>
        </div>
        <p class="text-sm text-gray-600 mt-1">{{ $progress }}% selesai</p>
    </div>
@endif

@if(isset($materiBerikutnya))
    <div class="mt-4 p-4 bg-yellow-100 border-l-4 border-yellow-500">
        <h4 class="font-bold">Pertemuan Berikutnya:</h4>
        <p>Pertemuan {{ $materiBerikutnya->pertemuan_ke }}: {{ $materiBerikutnya->judul ?? '-' }}</p>
        @if($materiBerikutnya->link_zoom)
            <p>🔗 Zoom:
                <a href="{{ $materiBerikutnya->link_zoom }}" target="_blank" class="text-blue-600 underline">
                    Gabung Zoom
                </a>
            </p>
        @endif
        <p>📅 Tanggal: {{ \Carbon\Carbon::parse($materiBerikutnya->tanggal_pertemuan)->translatedFormat('l, d M Y H:i') }}</p>
    </div>
@endif



        @endforeach
    </div>
@elseif($kelasDipilihId)
    <p class="text-gray-500">Belum ada materi untuk kelas ini.</p>
@endif
@endsection
