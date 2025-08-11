@php use Illuminate\Support\Str; @endphp

@extends('mentor.layout.main')

@section('title', 'Daftar Soal')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Daftar Soal - {{ $kelas->nama_kelas }} (Pertemuan ke-{{ $pertemuan_ke }})</h3>
                <p class="text-subtitle text-muted">Kelola pertanyaan dan jawaban untuk pertemuan ini</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('mentor.kelas.index') }}">Kelas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Soal</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Data Soal</h5>
                <a href="{{ route('mentor.soal.create', $kelas->id) }}" class="btn btn-primary btn-sm">+ Tambah Soal</a>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($soalList->count())
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pertanyaan</th>
                                <th>Gambar</th>
                                <th>Jawaban Benar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($soalList as $index => $soal)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ Str::limit($soal->pertanyaan, 60) }}</td>
                                <td>
                                    @if($soal->gambar_soal)
                                        <img src="{{ asset('storage/' . $soal->gambar_soal) }}" alt="Gambar Soal" style="max-width: 100px; max-height: 100px;">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ strtoupper($soal->jawaban_benar) }}</td>
                                <td>
                                    <a href="{{ route('mentor.soal.edit', $soal->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('mentor.soal.destroy', $soal->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus soal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">Belum ada soal ditambahkan untuk pertemuan ini.</p>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
