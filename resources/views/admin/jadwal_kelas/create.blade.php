@extends('admin.layout.main')

@section('title', 'Tambah Jadwal Kelas')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>Tambah Jadwal Kelas</h3>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.jadwal_kelas.index') }}">Jadwal Kelas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Tambah Jadwal Kelas</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.jadwal_kelas.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @php
                            $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
                        @endphp

                        <!-- Judul kolom -->
                        <div class="row fw-bold mb-2">
                            <div class="col-md-3">Hari</div>
                            <div class="col-md-3">Jam Mulai</div>
                            <div class="col-md-3">Jam Selesai</div>
                        </div>

                        <!-- List hari dan input jam -->
                        @foreach($hariList as $hari)
                        <div class="row align-items-center mb-3">
                            <!-- Checkbox dan nama hari -->
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="hari[]" value="{{ $hari }}" id="hari_{{ $hari }}">
                                    <label class="form-check-label fw-bold ms-2" for="hari_{{ $hari }}">{{ $hari }}</label>
                                </div>
                            </div>

                            <!-- Jam Mulai -->
                            <div class="col-md-3">
                                <input type="time" name="jam_mulai[{{ $hari }}]" class="form-control" id="jam_mulai_{{ $hari }}" disabled>
                            </div>

                            <!-- Jam Selesai -->
                            <div class="col-md-3">
                                <input type="time" name="jam_selesai[{{ $hari }}]" class="form-control" id="jam_selesai_{{ $hari }}" disabled>
                            </div>

                        </div>
                        @endforeach

                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];

        hariList.forEach(hari => {
            const checkbox = document.getElementById('hari_' + hari);
            const jamMulai = document.getElementById('jam_mulai_' + hari);
            const jamSelesai = document.getElementById('jam_selesai_' + hari);

            checkbox.addEventListener('change', function () {
                if (this.checked) {
                    jamMulai.disabled = false;
                    jamSelesai.disabled = false;
                } else {
                    jamMulai.disabled = true;
                    jamSelesai.disabled = true;
                    jamMulai.value = '';
                    jamSelesai.value = '';
                }
            });
        });
    });
</script>
@endpush


@endsection
