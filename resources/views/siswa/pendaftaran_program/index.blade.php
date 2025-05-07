@extends('landing.layout.main')
@section('title', 'Pendaftaran Program')
@section('content')
<div class="container">
    <h2>Pilih Program</h2>
    {{-- <form action="{{ route('siswa.pendaftaranprogram.store') }}" method="POST"> --}}
        @csrf
        <div class="form-group">
            <label for="tipe_program">Program</label>
            <select name="tipe_program" id="tipe_program" class="form-control" required>
                @foreach($programs as $program)
                    <option value="{{ $program->id }}">{{ $program->nama_program }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Lanjut</button>
    </form>
</div>
@endsection
