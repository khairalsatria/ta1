@extends('admin.layout.main')

@section('title', 'Detail Event GenZE Learn')

@section('content')
<div class="page-heading">
    <h3>{{ $program->nama_program }}</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header">Link Zoom</div>
        <div class="card-body">
            <form action="{{ route('admin.learn_events.updateZoom', $program->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-2">
        <label>Link Zoom</label>
        <input type="text" name="link_zoom" class="form-control mb-2"
               value="{{ $event->link_zoom ?? '' }}" placeholder="Masukkan Link Zoom">
    </div>
    <div class="mb-2">
        <label>Tanggal Event</label>
        <input type="date" name="tanggal_event" class="form-control mb-2"
               value="{{ $event->tanggal_event ?? '' }}">
    </div>
    <div class="mb-2">
        <label>Jam Event</label>
        <input type="time" name="jam_event" class="form-control mb-2"
               value="{{ $event->jam_event ?? '' }}">
    </div>
    <button type="submit" class="btn btn-primary">Update Zoom & Tanggal</button>
</form>

        </div>
    </div>

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

    @if($event && $event->template_sertifikat)
    <form action="{{ route('admin.learn_events.generateMassal', $program->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Generate sertifikat untuk peserta yang BELUM punya sertifikat?')">
        @csrf
        <button type="submit" class="btn btn-success mb-3">Generate Sertifikat Massal</button>
    </form>

    <form action="{{ route('admin.learn_events.regenerateMassal', $program->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Regenerate semua sertifikat peserta? Ini akan mengganti sertifikat lama.')">
        @csrf
        <button type="submit" class="btn btn-warning mb-3">Regenerate Semua Sertifikat</button>
    </form>
@endif


    <h4>Peserta Diterima</h4>
    <table class="table table-bordered">
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
@endsection
