@extends('landing.layout.main')

@section('title', 'Detail Program')

@section('content')

<!-- Header Start -->
<div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom" style="margin-bottom: 90px;">
    <div class="container text-center py-5">
        <h1 class="text-white display-1">{{ $program->tipe_program }}</h1> <!-- Menampilkan nama program -->
        <div class="d-inline-flex text-white mb-5">
            <i class="fa fa-angle-double-right pt-1 px-3"></i>
            <p class="m-0 text-uppercase">Detail Program</p>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Detail Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row">
            <!-- Konten Kiri -->
            <div class="col-lg-8">
                <div class="mb-5">
                    <div class="section-title position-relative mb-5">
                        <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Deskripsi Program</h6>
                        <h1 class="display-4">{{ $program->nama_program }}</h1>
                    </div>
                    <img class="img-fluid rounded w-100 mb-4" src="{{ asset('storage/' . $program->gambar) }}" alt="{{ $program->nama_program }}">
                    <p>{!! nl2br(e($program->deskripsi)) !!}</p>
                </div>
            </div>

            <!-- Sidebar Kanan -->
            <div class="col-lg-4 mt-5 mt-lg-0">
                <div class="bg-primary mb-5 py-3">
                    <h3 class="text-white py-3 px-4 m-0">Fitur Program</h3>
                    <div class="d-flex justify-content-between border-bottom px-4">
                        <h6 class="text-white my-3">Instruktur</h6>
                        <h6 class="text-white my-3">{{ $program->instruktur }}</h6>
                    </div>
                    <div class="d-flex justify-content-between border-bottom px-4">
                        <h6 class="text-white my-3">Tipe Kelas</h6>
                        <h6 class="text-white my-3">{{ ucfirst($program->tipe_kelas) }}</h6>
                    </div>
                    <div class="d-flex justify-content-between border-bottom px-4">
                        <h6 class="text-white my-3">Durasi</h6>
                        <h6 class="text-white my-3">{{ $program->durasi }} Jam</h6>
                    </div>
                    <div class="d-flex justify-content-between border-bottom px-4">
                        <h6 class="text-white my-3">Pendidikan</h6>
                        <h6 class="text-white my-3">{{ $program->level }}</h6>
                    </div>
                    <div class="d-flex justify-content-between border-bottom px-4">
                        <h6 class="text-white my-3">Rating</h6>
                        <h6 class="text-white my-3">{{ $program->rating ?? '4.5' }}</h6>
                    </div>
                    <div class="py-3 px-4">
                        <button class="btn btn-block btn-secondary py-3 px-5" data-bs-toggle="modal" data-bs-target="#enrollModal">
                            Enroll Now {{ $program->nama }}
                        </button>
                    </div>
                </div>

                <!-- Program Terkait -->
                <div class="mb-5">
                    <h4 class="mb-4">Program Lainnya</h4>
                    @foreach ($relatedPrograms as $related)
                        <a class="d-flex align-items-center text-decoration-none mb-4" href="{{ route('landing.page.detail-program', $related->id) }}">
                            <img class="img-fluid rounded" src="{{ asset('storage/' . $related->gambar) }}" alt="{{ $related->nama_program }}" style="width: 80px; height: 80px; object-fit: cover;">
                            <div class="pl-3">
                                <h6 class="text-dark mb-1">{{ $related->nama_program }}</h6>
                                <div class="d-flex">
                                    <small class="text-body mr-3"><i class="fa fa-user text-primary mr-2"></i>{{ $related->instruktur ?? 'Mentor' }}</small>
                                    <small class="text-body"><i class="fa fa-star text-primary mr-2"></i>{{ $related->rating ?? '4.5' }}</small>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Detail End -->

<!-- Modal Form Pendaftaran -->
<div class="modal fade" id="enrollModal" tabindex="-1" aria-labelledby="enrollModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enrollModalLabel">Formulir Pendaftaran GenZE Class</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('siswa.pendaftaran.genze-class.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="pendaftaran_id" value="{{ request()->get('pendaftaran_id') ?? $pendaftaran_id ?? '' }}">
                    <input type="hidden" name="tipe_program" value="{{ $program->id }}">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelas</label>
                            <select name="id_jeniskelas" class="form-select" required>
                                <option value="">-- Pilih Jenis Kelas --</option>
                                @foreach($jenisKelas as $jenis)
                                    <option value="{{ $jenis->id_jeniskelas }}">{{ $jenis->jeniskelas }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Pilih jenis kelas terlebih dahulu.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kelas</label>
                            <input type="number" name="kelas" class="form-control" placeholder="Contoh: 10" required>
                            <div class="invalid-feedback">Masukkan kelas dengan benar.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jenjang Pendidikan</label>
                            <select name="id_jenjang_pendidikan" id="jenjang" class="form-select" required>
                                <option value="">-- Pilih Jenjang --</option>
                                @foreach($jenjangPendidikans as $jenjang)
                                    <option value="{{ $jenjang->id_jenjang_pendidikan }}">{{ $jenjang->jenjang_pendidikan }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Pilih jenjang pendidikan.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Mata Pelajaran</label>
                            <select name="id_mata_pelajaran" id="mataPelajaran" class="form-select" required>
                                <option value="">-- Pilih Mata Pelajaran --</option>
                            </select>
                            <div class="invalid-feedback">Pilih mata pelajaran.</div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="form-label fw-bold">Pilih Maksimal 3 Jadwal</label>
                        <div class="row">
                            @foreach($jadwalKelas as $jadwal)
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input jadwal-check" name="jadwal_pilihan[]" value="{{ $jadwal->id_jadwalkelas }}" id="jadwal-{{ $jadwal->id_jadwalkelas }}">
                                        <label class="form-check-label" for="jadwal-{{ $jadwal->id_jadwalkelas }}">
                                            {{ $jadwal->jadwalkelas }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-danger d-none" id="jadwal-limit-warning">Maksimal hanya boleh memilih 3 jadwal!</small>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill">
                            <i class="bi bi-send me-1"></i> Kirim Pendaftaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script>
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();

    document.getElementById('jenjang').addEventListener('change', function () {
        let jenjangId = this.value;
        fetch('/mata-pelajaran/by-jenjang/' + jenjangId)
            .then(response => response.json())
            .then(data => {
                let mataPelajaran = document.getElementById('mataPelajaran');
                mataPelajaran.innerHTML = '<option value="">-- Pilih Mata Pelajaran --</option>';
                data.forEach(item => {
                    mataPelajaran.innerHTML += `<option value="${item.id_mata_pelajaran}">${item.mata_pelajaran}</option>`;
                });
            });
    });

    const checkboxes = document.querySelectorAll('.jadwal-check');
    const warning = document.getElementById('jadwal-limit-warning');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            const checked = document.querySelectorAll('.jadwal-check:checked');
            if (checked.length > 3) {
                checkbox.checked = false;
                warning.classList.remove('d-none');
                setTimeout(() => warning.classList.add('d-none'), 2000);
            }
        });
    });
</script>

@endsection
