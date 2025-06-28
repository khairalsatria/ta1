@extends('siswa.layout.main')

@section('title', 'Dashboard Siswa')

@section('content')
<h2 class="text-xl font-bold mb-4">Dashboard Siswa</h2>

@if(session('success'))
    <div class="alert alert-success mb-3">
        {{ session('success') }}
    </div>
@endif

@if($materi->isEmpty())
    <p class="text-gray-600">Belum ada materi yang tersedia.</p>
@else
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
            </div>
        @endforeach
    </div>
@endif
@endsection
