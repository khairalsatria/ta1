@php use Illuminate\Support\Str; @endphp


@extends('mentor.layout.main')

@section('content')
<div class="container">
    <h4>Daftar Soal - {{ $kelas->nama_kelas }} (Pertemuan ke-{{ $pertemuan_ke }})</h4>

    <a href="{{ route('mentor.soal.create', $kelas->id) }}" class="btn btn-primary mb-3">+ Tambah Soal</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($soalList->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pertanyaan</th>
                    <th>Jawaban Benar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($soalList as $index => $soal)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ Str::limit($soal->pertanyaan, 60) }}</td>
                    <td>{{ strtoupper($soal->jawaban_benar) }}</td>
                    <td>
                        <a href="{{ route('mentor.soal.edit', $soal->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        {{-- Tambahkan tombol hapus jika diperlukan --}}
                        <form action="{{ route('mentor.soal.destroy', $soal->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus soal ini?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
    </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Belum ada soal ditambahkan untuk pertemuan ini.</p>
    @endif
</div>
@endsection
