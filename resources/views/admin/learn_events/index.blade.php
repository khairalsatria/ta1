@extends('admin.layout.main')

@section('title', 'Event GenZE Learn')

@section('content')
<div class="page-heading">
    <h3>Program GenZE Learn</h3>
    <p class="text-muted">Kelola Link Zoom & Template Sertifikat.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-striped">
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
                <td>{{ $program->genzeLearnEvent->link_zoom ?? '-' }}</td>
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
@endsection
