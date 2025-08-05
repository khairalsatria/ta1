@extends('admin.layout.main')

@section('title', 'Detail Event GenZE Learn')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ $program->nama_program }}</h3>
                <p class="text-subtitle text-muted">Detail pengelolaan event dan sertifikat GenZE Learn</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.learn_events.index') }}">Event</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $program->nama_program }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Link Zoom & Tanggal --}}
        <div class="card mb-4">
            <div class="card-header">Link Zoom & Tanggal Event</div>
            <div class="card-body">
                <form action="{{ route('admin.learn_events.updateZoom', $program->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-2">
                        <label>Link Zoom</label>
                        <input type="text" name="link_zoom" class="form-control"
                               value="{{ $event->link_zoom ?? '' }}" placeholder="Masukkan Link Zoom">
                    </div>
                    <div class="mb-2">
                        <label>Tanggal Event</label>
                        <input type="date" name="tanggal_event" class="form-control"
                               value="{{ $event->tanggal_event ?? '' }}">
                    </div>
                    <div class="mb-2">
                        <label>Jam Event</label>
                        <input type="time" name="jam_event" class="form-control"
                               value="{{ $event->jam_event ?? '' }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Zoom & Tanggal</button>
                </form>
            </div>
        </div>

        {{-- Template Sertifikat --}}
        <div class="card mb-4">
            <div class="card-header">Template Sertifikat</div>
            <div class="card-body">
                @if($event && $event->template_sertifikat)
                    <p>
                        <a href="{{ asset('storage/' . $event->template_sertifikat) }}" target="_blank">Lihat Template</a>
                    </p>
                @endif
                <form action="{{ route('admin.learn_events.uploadTemplate', $program->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="template_sertifikat" class="form-control mb-2" accept="image/png,image/jpeg">
                    <button type="submit" class="btn btn-success">Upload Template</button>
                </form>
            </div>
        </div>

        {{-- Tombol Generate Sertifikat --}}
        @if($event && $event->template_sertifikat)
            <div class="mb-3">
                <form action="{{ route('admin.learn_events.generateMassal', $program->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Generate sertifikat untuk peserta yang BELUM punya sertifikat?')">
                    @csrf
                    <button type="submit" class="btn btn-success">Generate Sertifikat Massal</button>
                </form>

                <form action="{{ route('admin.learn_events.regenerateMassal', $program->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Regenerate semua sertifikat peserta? Ini akan mengganti sertifikat lama.')">
                    @csrf
                    <button type="submit" class="btn btn-warning">Regenerate Semua Sertifikat</button>
                </form>
            </div>
        @endif

        {{-- Tabel Peserta --}}
        <section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Peserta Diterima</h5>
            {{-- Tambahkan tombol aksi di sini jika diperlukan --}}
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Instansi</th>
                        <th>Sertifikat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peserta as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->pendaftaran->user->name ?? '-' }}</td>
                        <td>{{ $p->asal_instansi ?? '-' }}</td>
                        <td>
                            @if($p->sertifikat)
                                <a href="{{ asset('storage/' . $p->sertifikat) }}" target="_blank">Lihat Sertifikat</a>
                            @else
                                <span class="text-muted">Belum Ada</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada peserta diterima.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>



</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#table1').DataTable();
    });
</script>
@endsection
