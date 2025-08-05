@extends('admin.layout.main')

@section('title', 'Daftar Testimonial')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Testimonial</h3>
                <p class="text-subtitle text-muted">Daftar testimonial yang tersedia</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Testimonial</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Data Testimonial</h5>
                {{-- <a href="{{ route('siswa.testimonial.create') }}" class="btn btn-primary btn-sm">+ Buat Testimonial</a> --}}
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
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
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $t->program->nama_program }}</td>
                            <td>{{ $t->komentar }}</td>
                            <td>{{ $t->rating }}/5</td>
                            <td>{{ $t->created_at->format('d M Y') }}</td>
                            <td>
                                <form action="{{ route('siswa.testimonial.destroy', $t->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus testimonial ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada testimonial.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection
