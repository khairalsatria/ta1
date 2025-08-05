@extends('admin.layout.main')

@section('title', 'Detail Pendaftaran GenZE Learn')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4 mb-4">
                    <h4 class="card-title m-0">
                        <i class="bi bi-person-lines-fill me-2"></i> Detail Pendaftaran GenZE Learn
                    </h4>
                </div>

                <div class="card-body">
                    <!-- DATA PESERTA -->
                    <div class="mb-4">
                        <h5 class="text-primary"><i class="bi bi-person-circle me-2"></i>Data Peserta</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <tr>
                                    <th width="30%">Nama</th>
                                    <td>{{ $pendaftaran->pendaftaran->user->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $pendaftaran->pendaftaran->user->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>No HP</th>
                                    <td>{{ $pendaftaran->pendaftaran->user->nohp ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Asal Instansi</th>
                                    <td>{{ $pendaftaran->asal_instansi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Status Pembayaran</th>
                                    <td>
                                        <span class="badge bg-{{ $pendaftaran->pendaftaran->status === 'diterima' ? 'success' : ($pendaftaran->pendaftaran->status === 'menunggu' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($pendaftaran->pendaftaran->status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- <!-- VERIFIKASI PEMBAYARAN -->
                    @if ($pendaftaran->pendaftaran->status !== 'diterima')
                        <div class="mb-4">
                            <h5 class="text-success"><i class="bi bi-credit-card-2-back me-2"></i>Verifikasi Pembayaran</h5>
                            <form action="{{ route('admin.pendaftaran.learns.verifikasi', $pendaftaran->id) }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="status">Ubah Status Pembayaran</label>
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="diterima" {{ $pendaftaran->pendaftaran->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                        <option value="ditolak" {{ $pendaftaran->pendaftaran->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i> Update Status
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- UPLOAD SERTIFIKAT -->
                    <div class="mb-4">
                        <h5 class="text-info"><i class="bi bi-file-earmark-pdf me-2"></i>Upload Sertifikat (PDF)</h5>
                        <form action="{{ route('admin.pendaftaran.learns.uploadSertifikat', $pendaftaran->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-2">
                                <input type="file" name="sertifikat" accept="application/pdf" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-upload me-1"></i> Unggah Sertifikat
                            </button>
                        </form>

                        @if($pendaftaran->sertifikat)
                            <p class="mt-3">
                                <strong>File Sertifikat:</strong>
                                <a href="{{ asset('storage/' . $pendaftaran->sertifikat) }}" target="_blank" class="text-primary text-decoration-underline">
                                    <i class="bi bi-file-earmark-arrow-down me-1"></i> Lihat Sertifikat
                                </a>
                            </p>
                        @endif
                    </div>

                    <!-- TOMBOL KEMBALI -->
                    <div class="text-end">
                        <a href="{{ route('admin.pendaftaran.learns.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div> --}}

                </div> <!-- /.card-body -->
            </div> <!-- /.card -->
        </div>
    </div>
</section>
@endsection
