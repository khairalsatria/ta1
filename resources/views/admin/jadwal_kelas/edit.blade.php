@extends('admin.layout.main')

@section('title', 'Edit Jadwal Kelas')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>Edit Jadwal Kelas</h3>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.jadwal_kelas.index') }}">Jadwal Kelas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Edit Jadwal Kelas</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.jadwal_kelas.update', $jadwal_kelas->id_jadwalkelas) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @php
                        $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
                        $jadwalTersimpan = [];

                        // Pisahkan data yang disimpan sebelumnya seperti "Senin 13.00 - 14.00 dan Selasa 15.00 - 16.00"
                        foreach (explode(' dan ', $jadwal_kelas->jadwalkelas) as $item) {
                            // Pecah "Senin 13.00 - 14.00"
                            preg_match('/(\w+)\s(\d{2}\.\d{2})\s\-\s(\d{2}\.\d{2})/', $item, $match);
                            if ($match) {
                                $hari = $match[1];
                                $mulai = str_replace('.', ':', $match[2]);
                                $selesai = str_replace('.', ':', $match[3]);
                                $jadwalTersimpan[$hari] = [
                                    'mulai' => $mulai,
                                    'selesai' => $selesai
                                ];
                            }
                        }
                    @endphp

                    <div class="card-body">
                        <!-- Judul kolom -->
                        <div class="row fw-bold mb-2">
                            <div class="col-md-3">Hari</div>
                            <div class="col-md-3">Jam Mulai</div>
                            <div class="col-md-3">Jam Selesai</div>
                        </div>

                        @foreach($hariList as $hari)
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="hari[]" value="{{ $hari }}" id="hari_{{ $hari }}"
                                           {{ isset($jadwalTersimpan[$hari]) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold ms-2" for="hari_{{ $hari }}">{{ $hari }}</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <input type="time" name="jam_mulai[{{ $hari }}]" class="form-control" id="jam_mulai_{{ $hari }}"
                                       value="{{ $jadwalTersimpan[$hari]['mulai'] ?? '' }}"
                                       {{ isset($jadwalTersimpan[$hari]) ? '' : 'disabled' }}>
                            </div>

                            <div class="col-md-3">
                                <input type="time" name="jam_selesai[{{ $hari }}]" class="form-control" id="jam_selesai_{{ $hari }}"
                                       value="{{ $jadwalTersimpan[$hari]['selesai'] ?? '' }}"
                                       {{ isset($jadwalTersimpan[$hari]) ? '' : 'disabled' }}>
                            </div>
                        </div>
                        @endforeach

                        <button type="submit" class="btn btn-primary mt-3">Update</button>
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
