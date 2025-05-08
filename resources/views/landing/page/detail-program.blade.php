@extends('landing.layout.main')

@section('title', 'Detail Program')

@section('content')

<!-- Header Start -->
<div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom" style="margin-bottom: 90px;">
    <div class="container text-center py-5">
        <h1 class="text-white display-1">{{ $program->tipe_program }}</h1> <!-- Menampilkan nama program -->
        <div class="d-inline-flex text-white mb-5">
            {{-- <p class="m-0 text-uppercase"><a class="text-white" href="{{ route('beranda') }}">Beranda</a></p> --}}
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
            <button class="btn btn-block btn-secondary py-3 px-5" data-bs-toggle="modal" data-bs-target="#daftarModal">
                Enroll Now {{ $program->nama }}
            </button>
<!-- Modal -->
<div class="modal fade" id="daftarModal" tabindex="-1" aria-labelledby="daftarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg rounded-5 overflow-hidden" style="background-color: #fff7ee;">
        <div class="modal-body d-flex flex-column flex-md-row p-0">
          <!-- Kiri - Ilustrasi -->
          <div class="col-md-6 bg-light-green d-flex flex-column align-items-center justify-content-center text-center p-4">
            <img src="{{ asset('assets2/img/login.png') }}" alt="GenZE Illustration" class="img-fluid mb-3 login-illustration">
            <h2 class="fw-bold text-dark">GenZE<br><small class="text-muted">Empower Your Learning</small></h2>
          </div>

          <!-- Formulir Pendaftaran Kanan -->
          <div class="col-md-6 bg-white p-5">
            <h4 class="fw-bold text-primary text-center mb-4">Pendaftaran GenZE Class</h4>

            <form action="{{ route('siswa.pendaftaran.genze-class.store') }}" method="POST">
              @csrf
              <input type="hidden" name="pendaftaran_id" value="{{ request()->get('pendaftaran_id') ?? $pendaftaran_id ?? '' }}">
              <input type="hidden" name="tipe_program" value="{{ $program->id }}">

              <div class="form-group mb-3">
                <select name="id_jeniskelas" class="form-select" required>
                  <option value="">-- Pilih Jenis Kelas --</option>
                  @foreach($jenisKelas as $jenis)
                    <option value="{{ $jenis->id_jeniskelas }}">{{ $jenis->jeniskelas }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group mb-3">
                <input type="number" name="kelas" class="form-control" placeholder="Kelas (contoh: 10)" required>
              </div>

              <div class="form-group mb-3">
                <select name="id_jenjang_pendidikan" id="jenjang" class="form-select" required>
                  <option value="">-- Pilih Jenjang Pendidikan --</option>
                  @foreach($jenjangPendidikans as $jenjang)
                    <option value="{{ $jenjang->id_jenjang_pendidikan }}">{{ $jenjang->jenjang_pendidikan }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group mb-3">
                <select name="id_mata_pelajaran" id="mataPelajaran" class="form-select" required>
                  <option value="">-- Pilih Mata Pelajaran --</option>
                </select>
              </div>

              <div class="form-group mb-4">
                <label class="form-label fw-semibold" style="font-size: 0.875rem;">Pilih Maksimal 3 Jadwal:</label>
                @foreach($jadwalKelas as $jadwal)
                  <div class="form-check" style="font-size: 0.875rem;">
                    <input type="checkbox" class="form-check-input" name="jadwal_pilihan[]" value="{{ $jadwal->id_jadwalkelas }}" id="jadwal-{{ $jadwal->id_jadwalkelas }}">
                    <label class="form-check-label" for="jadwal-{{ $jadwal->id_jadwalkelas }}" style="font-size: 0.875rem;">{{ $jadwal->jadwalkelas }}</label>
                  </div>
                @endforeach
              </div>


              <button type="submit" class="btn w-100 rounded-3 fw-bold py-2" style="background-color: #3ddc97; color: white;">
                Daftar Sekarang
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    .bg-light-green {
      background-color: #C6F6E2;
    }

    .login-illustration {
      max-height: 280px;
      width: auto;
      object-fit: contain;
    }

    @media (max-width: 768px) {
      .login-illustration {
        max-height: 180px;
      }
    }
  </style>

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
        </div>

    </div>

    <!-- Program Terkait Dipindahkan ke Sini -->
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

@endsection
