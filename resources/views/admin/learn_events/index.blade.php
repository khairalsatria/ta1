@extends('admin.layout.main')

@section('title', 'Event GenZE Learn')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Program GenZE Learn</h3>
                <p class="text-subtitle text-muted">Kelola Link Zoom & Template Sertifikat.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">GenZE Learn</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Data Event GenZE Learn</h5>
                {{-- Tambah tombol jika perlu --}}
                {{-- <a href="{{ route('admin.learn_events.create') }}" class="btn btn-primary btn-sm">+ Tambah Event</a> --}}
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Program</th>
                            <th>Link Zoom</th>
                            <th>Template Sertifikat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($programs as $program)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $program->nama_program }}</td>
                            <td>
                                @if($program->genzeLearnEvent && $program->genzeLearnEvent->link_zoom)
                                    <a href="{{ $program->genzeLearnEvent->link_zoom }}" target="_blank" rel="noopener noreferrer">
                                        {{ $program->genzeLearnEvent->link_zoom }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($program->genzeLearnEvent && $program->genzeLearnEvent->template_sertifikat)
                                    <a href="{{ asset('storage/' . $program->genzeLearnEvent->template_sertifikat) }}" target="_blank">Lihat</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.learn_events.show', $program->id) }}" class="btn btn-sm btn-primary">Kelola</a>
                            </td>
                        </tr>
                        @endforeach
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
