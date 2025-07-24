@extends('landing.layout.main')

@section('title', 'Detail Program')

@section('content')

<!-- Header Start -->
<div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom mb-5">
    <div class="container text-center py-5">
        <h1 class="text-white display-4 font-weight-bold" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.7);">
            {{ $program->tipe_program }}
        </h1>
        <div class="d-inline-flex text-white mt-3 font-weight-semibold">
            <p class="m-0 text-uppercase"><a class="text-white" href="{{ url('/') }}">Home</a></p>
            <i class="fa fa-angle-double-right pt-1 px-3"></i>
            <p class="m-0 text-uppercase text-white">Detail Program</p>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Detail Start -->
<div class="container py-5">
    <div class="row">
        <!-- Konten Kiri -->
        <div class="col-lg-8 mb-5">
            <div class="mb-4">
                <h6 class="text-success text-uppercase font-weight-bold mb-2">Deskripsi Program</h6>
                <h2 class="display-5 font-weight-bold text-dark mb-3">{{ $program->nama_program }}</h2>
                <div class="detail-img-wrapper mb-4">
                    <img class="img-fluid w-100 h-100" src="{{ asset('storage/' . $program->gambar) }}" alt="{{ $program->nama_program }}">
                </div>
                <p class="text-muted" style="line-height: 1.8;">{!! nl2br(e($program->deskripsi)) !!}</p>
            </div>
        </div>

        <!-- Sidebar Kanan -->
        <div class="col-lg-4">
            <div class="bg-primary text-white p-4 rounded mb-4 shadow-sm">
                <h4 class="mb-3">Fitur Program</h4>
                <ul class="list-unstyled">
                    <li class="d-flex justify-content-between border-bottom py-2">
                        <span>Instruktur</span> <strong>{{ $program->instruktur }}</strong>
                    </li>
                    <li class="d-flex justify-content-between border-bottom py-2">
                        <span>Program</span> <strong>{{ ucfirst($program->tipe_program) }}</strong>
                    </li>
                    <li class="d-flex justify-content-between border-bottom py-2">
                        <span>Durasi</span> <strong>{{ $program->durasi }}</strong>
                    </li>
                    <li class="d-flex justify-content-between border-bottom py-2">
                        <span>Pendidikan</span> <strong>{{ $program->level }}</strong>
                    </li>
                    <li class="d-flex justify-content-between border-bottom py-2">
    <span>Rating</span>
    <strong>{{ is_numeric($program->rating) ? $program->rating . ' / 5' : $program->rating }}</strong>
</li>

                </ul>

                <div class="text-center mt-4">
                    @if ($program->tipe_program === 'GenZE Class')
                        <button class="btn btn-light w-100" data-bs-toggle="modal" data-bs-target="#daftarGenzeClassModal">Daftar GenZE Class</button>
                    @elseif ($program->tipe_program === 'GenZE Guide')
                        <button class="btn btn-light w-100" data-bs-toggle="modal" data-bs-target="#daftarGenzeGuideModal">Daftar GenZE Guide</button>
                    @elseif ($program->tipe_program === 'GenZE Learn')
                        <button class="btn btn-light w-100" data-bs-toggle="modal" data-bs-target="#daftarGenzeLearnModal">Daftar GenZE Learn</button>
                    @else
                        <button class="btn btn-warning w-100" disabled>Jenis Program Tidak Dikenal</button>
                    @endif
                </div>
            </div>

            <!-- Program Lainnya -->
            <div class="bg-white border rounded p-4 shadow-sm">
                <h5 class="mb-4">Program Lainnya</h5>
                @foreach ($relatedPrograms as $related)
                <a class="d-flex mb-3 align-items-center text-decoration-none" href="{{ route('landing.page.detail-program', $related->id) }}">
                    <div class="me-3 flex-shrink-0" style="width: 70px; height: 70px;">
                        <img src="{{ asset('storage/' . $related->gambar) }}" class="img-fluid rounded object-fit-cover" style="width: 70px; height: 70px;" alt="{{ $related->nama_program }}">
                    </div>
                    <div>
                        <h6 class="mb-1 text-dark">{{ $related->nama_program }}</h6>
                        <small class="text-muted d-block"><i class="fa fa-user me-1 text-success"></i> {{ $related->instruktur }}</small>
                        <small class="text-muted d-block"><i class="fa fa-star me-1 text-warning"></i> {{ $related->rating ?? '4.5' }}</small>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Detail End -->

<style>
    .detail-img-wrapper {
        height: 300px;
        overflow: hidden;
        border-radius: 8px;
        background-color: #f5f5f5;
    }

    .detail-img-wrapper img {
        object-fit: cover;
        width: 100%;
        height: 100%;
        transition: transform 0.4s ease;
    }

    .detail-img-wrapper:hover img {
        transform: scale(1.03);
    }

    .object-fit-cover {
        object-fit: cover;
    }

    @media (max-width: 768px) {
        .detail-img-wrapper {
            height: 200px;
        }

        .display-5 {
            font-size: 1.75rem;
        }
    }
</style>


<!-- Modal GenZE Clas -->
<div class="modal fade" id="daftarGenzeClassModal" tabindex="-1" aria-labelledby="daftarModalLabel" aria-hidden="true">
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
            <h4 class="fw-bold text-primary text-center">Pendaftaran</h4>
            <h4 class="fw-bold text-primary text-center mb-4">GenZE Class</h4>

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
    <label class="form-label fw-semibold" style="font-size: 0.875rem;">Pilih Minimal 3 Jadwal:</label>
    @foreach($jadwalKelas as $jadwal)
        <div class="form-check" style="font-size: 0.875rem;">
            <input type="checkbox" class="form-check-input jadwal-checkbox" name="jadwal_pilihan[]" value="{{ $jadwal->id_jadwalkelas }}" id="jadwal-{{ $jadwal->id_jadwalkelas }}">
            <label class="form-check-label" for="jadwal-{{ $jadwal->id_jadwalkelas }}" style="font-size: 0.875rem;">
                {{ $jadwal->jadwalkelas }}
            </label>
        </div>
    @endforeach
    <small id="jadwal-error" class="text-danger d-none">Silakan pilih minimal 3 jadwal.</small>
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

<!-- Modal GenZE Guide -->
<div class="modal fade" id="daftarGenzeGuideModal" tabindex="-1" aria-labelledby="daftarGuideModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-5 overflow-hidden" style="background-color: #fff7ee;">
      <div class="modal-body d-flex flex-column flex-md-row p-0">

        <!-- Kiri - Ilustrasi -->
        <div class="col-md-6 bg-light-green d-flex flex-column align-items-center justify-content-center text-center p-4">
          <img src="{{ asset('assets2/img/login.png') }}" alt="Guide Illustration" class="img-fluid mb-3 login-illustration">
          <h2 class="fw-bold text-dark">GenZE Guide<br><small class="text-muted">Bimbingan Tugas & Proyekmu</small></h2>
        </div>

        <!-- Kanan - Formulir -->
        <div class="col-md-6 bg-white p-5">
          <h4 class="fw-bold text-primary text-center">Pendaftaran</h4>
          <h4 class="fw-bold text-primary text-center mb-4">GenZE Guide</h4>

          <form action="{{ route('pendaftaran-guide.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            <input type="hidden" name="pendaftaran_id" value="{{ request()->get('pendaftaran_id') ?? $pendaftaran_id ?? '' }}">
              <input type="hidden" name="tipe_program" value="{{ $program->id }}">


            <div class="form-group mb-3">
              <label for="paket_guide">Pilih Paket Guide:</label>
                <select name="paket_guide" id="paket_guide" class="form-control" required>
                    <option value="">-- Pilih Paket Guide --</option>
                    @foreach($paketGuides as $paket)
                    <option value="{{ $paket->id_paket_guide }}">{{ $paket->paket_guide }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Upload File -->
            <div class="form-group mb-3" id="file-upload" style="display:none;">
              <label for="file_upload" class="form-label">Upload File (PDF, DOC, JPG)</label>
              <input type="file" class="form-control" name="file_upload" id="file_upload" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
            </div>

            <!-- Pilih Jadwal -->
<div class="form-group mb-4" id="jadwal-pilihan" style="display:none;">
    <label class="form-label fw-semibold" style="font-size: 0.875rem;">Pilih Maksimal 3 Jadwal:</label>
    @if(isset($jadwalGuide2) && $jadwalGuide2->count() > 0)
        @foreach($jadwalGuide2 as $jadwal)
            <div class="form-check" style="font-size: 0.875rem;">
                <input type="checkbox" class="form-check-input" name="jadwalguide2_pilihan[]" value="{{ $jadwal->id_jadwalguide2 }}" id="jadwal-{{ $jadwal->id_jadwalguide2 }}">
                <label class="form-check-label" for="jadwal-{{ $jadwal->id_jadwalguide2 }}" style="font-size: 0.875rem;">{{ $jadwal->jadwalguide2 }}</label>
            </div>
        @endforeach
    @else
        <p>Jadwal belum tersedia.</p>
    @endif
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

<!-- Style -->
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
  document.getElementById('paket_guide').addEventListener('change', function () {
    const fileUpload = document.getElementById('file-upload');
    const jadwalPilihan = document.getElementById('jadwal-pilihan');

    if (this.value === '1' || this.value === '3') {
      fileUpload.style.display = 'block';
      jadwalPilihan.style.display = 'none';
    } else if (this.value === '2') {
      fileUpload.style.display = 'none';
      jadwalPilihan.style.display = 'block';
    } else {
      fileUpload.style.display = 'none';
      jadwalPilihan.style.display = 'none';
    }
  });

  // Trigger display on load if needed (for edit form or refresh)
  document.addEventListener('DOMContentLoaded', () => {
    const trigger = document.getElementById('paket_guide');
    const event = new Event('change');
    trigger.dispatchEvent(event);
  });

  // Validasi Bootstrap
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
</script>
<script>
    // Batasi maksimal checkbox terpilih hanya 3
    const maxChecked = 3;
    const checkboxes = document.querySelectorAll('input[name="jadwalguide2_pilihan[]"]');
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', function() {
            const checkedBoxes = document.querySelectorAll('input[name="jadwalguide2_pilihan[]"]:checked');
            if (checkedBoxes.length > maxChecked) {
                this.checked = false;
                alert(`Maksimal memilih ${maxChecked} jadwal.`);
            }
        });
    });
</script>


<<!-- Modal GenZE Learn -->
<div class="modal fade" id="daftarGenzeLearnModal" tabindex="-1" aria-labelledby="daftarLearnModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-5 overflow-hidden" style="background-color: #fff7ee;">
      <div class="modal-body d-flex flex-column flex-md-row p-0">

        <!-- Kiri - Ilustrasi -->
        <div class="col-md-6 bg-light-green d-flex flex-column align-items-center justify-content-center text-center p-4">
          <img src="{{ asset('assets2/img/login.png') }}" alt="Learn Illustration" class="img-fluid mb-3 login-illustration">
          <h2 class="fw-bold text-dark">GenZE Learn<br><small class="text-muted">Upgrade Skill dengan Sertifikat</small></h2>
        </div>

        <!-- Kanan - Formulir -->
        <div class="col-md-6 bg-white p-5">
          <h4 class="fw-bold text-primary text-center">Pendaftaran</h4>
          <h4 class="fw-bold text-primary text-center mb-4">GenZE Learn</h4>

          <form action="{{ route('pendaftaran-learn.store') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            <input type="hidden" name="tipe_program" value="{{ $program->id }}">

            <div class="form-group mb-4">
              <label for="asal_instansi" class="form-label">Asal Instansi</label>
              <input type="text" class="form-control" id="asal_instansi" name="asal_instansi" required placeholder="Contoh: SMAN 1 Jakarta / Universitas ABC">
              <div class="invalid-feedback">
                Harap isi asal instansi Anda.
              </div>
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

<!-- Style -->
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

<!-- Validasi Bootstrap -->
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
</script>



@endsection
