@extends('admin.layout.main')

@section('title', 'Detail & Konfirmasi Pendaftaran Guide')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4 mb-4">
                    <h4 class="card-title m-0">
                        <i class="bi bi-person-lines-fill me-2"></i> Detail Pendaftaran Guide
                    </h4>
                </div>

                <div class="card-body">
                    <!-- DATA PESERTA -->
                    <div class="mb-4">
                        <h5 class="text-primary"><i class="bi bi-person-circle me-2"></i>Data Peserta</h5>
                        <table class="table table-bordered table-striped align-middle">
                            <tr>
                                <th width="30%">Nama</th>
                                <td>{{ $pendaftaran->pendaftaran->user->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Status Pembayaran</th>
                                <td>
                                    <span class="badge bg-{{ $pendaftaran->pendaftaran->status === 'diterima' ? 'success' : ($pendaftaran->pendaftaran->status === 'menunggu' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($pendaftaran->pendaftaran->status ?? '-') }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Paket</th>
                                <td>{{ $pendaftaran->paketGuide->paket_guide ?? 'Paket ' . $pendaftaran->paket_guide }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- BAGIAN PAKET 2 -->
                    @if((int) $pendaftaran->paket_guide === 2)
                        <div class="mb-4">
                            <h5 class="text-success"><i class="bi bi-calendar-event me-2"></i>Konfirmasi Jadwal</h5>
                            @if($pendaftaran->jadwalguide2_konfirmasi)
                                <form action="{{ route('admin.pendaftaran.guides.konfirmasi', $pendaftaran->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="jadwalguide2_konfirmasi" class="form-label">Ubah Jadwal Konfirmasi</label>
                                        <select name="jadwalguide2_konfirmasi" id="jadwalguide2_konfirmasi" class="form-select">
                                            @foreach($jadwalTersedia as $jadwal)
                                                <option value="{{ $jadwal->id_jadwalguide2 }}"
                                                    {{ $pendaftaran->jadwalguide2_konfirmasi == $jadwal->id_jadwalguide2 ? 'selected' : '' }}>
                                                    {{ $jadwal->jadwalguide2 }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            @else
                                <form action="{{ route('admin.pendaftaran.guides.konfirmasi', $pendaftaran->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="jadwalguide2_konfirmasi" class="form-label">Pilih Jadwal Konfirmasi</label>
                                        <select name="jadwalguide2_konfirmasi" id="jadwalguide2_konfirmasi" class="form-select" required>
                                            <option value="">-- Pilih Jadwal --</option>
                                            @foreach($jadwalTersedia as $jadwal)
                                                <option value="{{ $jadwal->id_jadwalguide2 }}">{{ $jadwal->jadwalguide2 }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Konfirmasi</button>
                                </form>
                            @endif
                        </div>

                        @if(($pendaftaran->pendaftaran->status ?? null) === 'diterima')
                        <div class="mb-4">
                            <h5 class="text-info"><i class="bi bi-camera-video me-2"></i>Link Zoom</h5>
                            @php $zoomRows = $pendaftaran->hasilFiles->whereNotNull('link_zoom'); @endphp

                            @if($zoomRows->isNotEmpty())
                                <ul class="list-group mb-3">
                                    @foreach($zoomRows as $zf)
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div>
                                                <a href="{{ $zf->link_zoom }}" target="_blank" class="fw-semibold">{{ $zf->link_zoom }}</a><br>
                                                <small class="text-muted">
                                                    @if($zf->keterangan) ({{ $zf->keterangan }}) @endif
                                                    • {{ $zf->created_at->format('d M Y H:i') }}
                                                    @if($zf->uploader) • oleh {{ $zf->uploader->name }} @endif
                                                </small>
                                            </div>
                                            <form action="{{ route('admin.pendaftaran.guides.hapusHasil', $zf->id) }}" method="POST" class="ms-2">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus link ini?')">Hapus</button>
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">Belum ada link Zoom.</p>
                            @endif

                            <form action="{{ route('admin.pendaftaran.guides.simpanZoom', $pendaftaran->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="link_zoom" class="form-label">Tambah / Update Link Zoom</label>
                                    <input type="url" name="link_zoom" class="form-control" placeholder="https://..." required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="keterangan" class="form-control" placeholder="Keterangan (opsional)">
                                </div>
                                <button type="submit" class="btn btn-success">Simpan Link Zoom</button>
                            </form>
                        </div>
                        @endif
                    @else
                    <!-- PAKET 1 & 3 -->
                    <div class="mb-4">
                        <h5 class="text-warning"><i class="bi bi-file-earmark-arrow-down me-2"></i>File dari Siswa</h5>
                        @if($pendaftaran->file_upload)
                            <a href="{{ asset('storage/' . $pendaftaran->file_upload) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                Lihat File Siswa
                            </a>
                        @else
                            <p class="text-muted">Belum ada file dari siswa.</p>
                        @endif
                    </div>

                    @if(($pendaftaran->pendaftaran->status ?? null) === 'diterima')
                    <div class="mb-4">
                        <h5 class="text-info"><i class="bi bi-upload me-2"></i>File Hasil Admin</h5>
                        @php $hasilRows = $pendaftaran->hasilFiles->whereNotNull('file_hasil'); @endphp

                        @if($hasilRows->isEmpty())
                            <p class="text-muted">Belum ada file hasil.</p>
                        @else
                            <ul class="list-group mb-3">
                                @foreach($hasilRows as $hf)
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div>
                                            <a href="{{ asset('storage/' . $hf->file_hasil) }}" target="_blank" class="fw-semibold">
                                                {{ basename($hf->file_hasil) }}
                                            </a><br>
                                            <small class="text-muted">
                                                @if($hf->keterangan) ({{ $hf->keterangan }}) @endif
                                                • {{ $hf->created_at->format('d M Y H:i') }}
                                                @if($hf->uploader) • oleh {{ $hf->uploader->name }} @endif
                                            </small>
                                        </div>
                                        <form action="{{ route('admin.pendaftaran.guides.hapusHasil', $hf->id) }}" method="POST" class="ms-2">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus file ini?')">Hapus</button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <form action="{{ route('admin.pendaftaran.guides.uploadHasil', $pendaftaran->id) }}"
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="file_hasil" class="form-label">Upload File Hasil (PDF/DOC/PPT/ZIP/RAR, maks 5MB)</label>
                                <input type="file" name="file_hasil" class="form-control" required>
                                @error('file_hasil') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <input type="text" name="keterangan" class="form-control" placeholder="Keterangan (opsional)">
                            </div>
                            <button type="submit" class="btn btn-success">Upload File Hasil</button>
                        </form>
                    </div>
                    @endif
                    @endif

                    <div class="text-end">
                        <a href="{{ route('admin.pendaftaran.guides.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>

                </div> <!-- /.card-body -->
            </div> <!-- /.card -->
        </div>
    </div>
</section>
@endsection
