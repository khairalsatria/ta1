@extends('siswa.layout.main')

@section('content')
<h2 class="text-xl font-bold mb-4">Materi Kelas</h2>

<pre>
    {{ auth()->check() ? 'Logged in as: ' . auth()->id() : 'Not logged in' }}
</pre>


{{-- Jika materi kosong --}}
@if($materi->isEmpty())
    <p class="text-gray-600">Belum ada materi tersedia.</p>
@else
    @foreach ($materi as $item)
        <div class="border p-4 rounded mb-3 shadow">
            <h4 class="font-semibold mb-1">
                Pertemuan {{ $item->pertemuan_ke }}: {{ $item->judul }}
            </h4>

            {{-- File PDF --}}
            @if ($item->file_pdf)
                <p>
                    <a href="{{ asset('storage/' . $item->file_pdf) }}"
                       target="_blank"
                       class="text-blue-600 underline">
                       📄 Unduh Materi (PDF)
                    </a>
                </p>
            @endif

            {{-- Link Zoom (hanya jika waktu sekarang < expired) --}}
            @if ($item->link_zoom && now()->lt($item->created_at->addDays(1)))
                <p>
                    <a href="{{ $item->link_zoom }}"
                       target="_blank"
                       class="text-indigo-600 underline">
                       🎥 Join Zoom
                    </a>
                </p>
            @endif

            {{-- Link Rekaman --}}
            @if ($item->link_rekaman)
                <p>
                    <a href="{{ $item->link_rekaman }}"
                       target="_blank"
                       class="text-purple-600 underline">
                       🎞️ Tonton Rekaman
                    </a>
                </p>
            @endif


        </div>
    @endforeach
@endif
@endsection
