@extends('siswa.layout.main')

@section('title', 'Testimonial Saya')

@section('content')
<div class="page-heading">
    <h3>Testimonial Saya</h3>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('siswa.testimonial.create') }}" class="btn btn-primary mb-3">+ Buat Testimonial</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Program</th>
            <th>Komentar</th>
            <th>Rating</th>
            <th>Waktu</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($testimonials as $t)
            <tr>
                <td>{{ $t->program->nama_program }}</td>
                <td>{{ $t->komentar }}</td>
                <td>{{ $t->rating }}/5</td>
                <td>{{ $t->created_at->format('d M Y') }}</td>
                <td>
                    <form action="{{ route('siswa.testimonial.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Hapus testimonial ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">Belum ada testimonial.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
