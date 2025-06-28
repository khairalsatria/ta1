@extends('siswa.layout.main')

@section('content')
<h2 class="text-xl font-bold mb-4">Latihan Soal Pertemuan {{ $pertemuan }}</h2>

<form method="POST" action="{{ route('siswa.latihan.submit', [$kelas_id, $pertemuan]) }}">
    @csrf

    @foreach($soal as $index => $s)
        <div class="mb-4 border p-3 rounded shadow">
            <p><strong>{{ $index + 1 }}.</strong> {{ $s->pertanyaan }}</p>
            @foreach(['a', 'b', 'c', 'd'] as $opt)
                <div>
                    <label>
                        <input type="radio" name="soal_{{ $s->id }}" value="{{ $opt }}" required>
                        {{ strtoupper($opt) }}. {{ $s['pilihan_' . $opt] }}
                    </label>
                </div>
            @endforeach
        </div>
    @endforeach

    <button type="submit" class="btn btn-success">Selesai & Lihat Skor</button>
</form>
@endsection
