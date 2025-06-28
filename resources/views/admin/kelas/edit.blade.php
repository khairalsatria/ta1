@extends('admin.layout.main')
@section('content')
<h2 class="text-xl font-bold mb-4">Edit Kelas Genze</h2>

<form action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Nama Kelas</label>
        <input type="text" name="nama_kelas" value="{{ $kelas->nama_kelas }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Program</label>
        <select name="program_id" class="form-control" required>
            @foreach($programs as $p)
                <option value="{{ $p->id }}" {{ $kelas->program_id == $p->id ? 'selected' : '' }}>
                    {{ $p->nama_program }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Mentor</label>
        <select name="mentor_id" class="form-control">
            <option value="">-- Pilih Mentor --</option>
            @foreach($mentors as $m)
                <option value="{{ $m->id }}" {{ $kelas->mentor_id == $m->id ? 'selected' : '' }}>
                    {{ $m->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Kuota</label>
        <input type="number" name="kuota" value="{{ $kelas->kuota }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="form-control">{{ $kelas->deskripsi }}</textarea>
    </div>
    <div class="mb-3">
        <label>Link Zoom Default</label>
        <input type="url" name="link_zoom_default" value="{{ $kelas->link_zoom_default }}" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
