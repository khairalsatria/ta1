@extends('admin.layout.main')

@section('title', 'Detail Pendaftaran Guide')

@section('content')
<div class="page-heading">
    <h2 class="text-xl font-bold mb-4">Detail Pendaftaran Guide</h2>

    <p><strong>Nama:</strong> {{ $pendaftaran->pendaftaran->user->name ?? '-' }}</p>
    <p><strong>Paket:</strong> {{ $pendaftaran->paketGuide->paket_guide ?? 'Paket ' . $pendaftaran->paket_guide }}</p>
    <p><strong>Status Pembayaran:</strong> {{ ucfirst($pendaftaran->pendaftaran->status ?? '-') }}</p>

    <hr class="my-4">

    {{-- ====================== PAKET 2: KONFIRMASI JADWAL ====================== --}}
    @if ((int) $pendaftaran->paket_guide === 2)
        <h4 class="mb-2">Konfirmasi Jadwal</h4>

        @if($pendaftaran->jadwalguide2_konfirmasi)
            @php $konf = $pendaftaran->jadwalKonfirmasi; @endphp
            <p>
                Jadwal terkonfirmasi:
                <strong>
                    {{ $konf->jadwalguide2 ?? $konf->waktu ?? ('ID #' . $konf->id_jadwalguide2) }}
                </strong>
            </p>
            {{-- Form ubah jadwal (opsional) --}}
            <form action="{{ route('admin.pendaftaran.guides.konfirmasi', $pendaftaran->id) }}" method="POST" class="mb-4">
                @csrf
                <label for="jadwalguide2_konfirmasi" class="form-label">Ubah Jadwal Konfirmasi</label>
                <select name="jadwalguide2_konfirmasi" id="jadwalguide2_konfirmasi" class="form-select">
                    @foreach($jadwalTersedia as $jadwal)
                        <option value="{{ $jadwal->id_jadwalguide2 }}"
                            {{ $pendaftaran->jadwalguide2_konfirmasi == $jadwal->id_jadwalguide2 ? 'selected' : '' }}>
                            {{ $jadwal->jadwalguide2 }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary mt-2">Simpan</button>
            </form>
        @else
            {{-- Belum konfirmasi jadwal --}}
            <form action="{{ route('admin.pendaftaran.guides.konfirmasi', $pendaftaran->id) }}" method="POST" class="mb-4">
                @csrf
                <label for="jadwalguide2_konfirmasi" class="form-label">Pilih Jadwal Konfirmasi</label>
                <select name="jadwalguide2_konfirmasi" id="jadwalguide2_konfirmasi" class="form-select" required>
                    <option value="">-- Pilih Jadwal --</option>
                    @foreach($jadwalTersedia as $jadwal)
                        <option value="{{ $jadwal->id_jadwalguide2 }}">{{ $jadwal->jadwalguide2 }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary mt-2">Konfirmasi</button>
            </form>
        @endif

        {{-- ======= Setelah status diterima, input Link Zoom ======= --}}
        @if(($pendaftaran->pendaftaran->status ?? null) === 'diterima')
            <hr class="my-4">
            <h4 class="mb-2">Link Zoom</h4>

            @php
                $zoomRows = $pendaftaran->hasilFiles->whereNotNull('link_zoom');
            @endphp

            @if($zoomRows->isNotEmpty())
                <ul class="list-unstyled mb-3">
                    @foreach($zoomRows as $zf)
                        <li class="mb-2">
                            <a href="{{ $zf->link_zoom }}" target="_blank">{{ $zf->link_zoom }}</a>
                            <small class="text-muted">
                                @if($zf->keterangan) ({{ $zf->keterangan }}) @endif
                                • {{ $zf->created_at->format('d M Y H:i') }}
                                @if($zf->uploader) • oleh {{ $zf->uploader->name }} @endif
                            </small>
                            <form action="{{ route('admin.pendaftaran.guides.hapusHasil', $zf->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus link ini?')">Hapus</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">Belum ada link Zoom.</p>
            @endif

            <form action="{{ route('admin.pendaftaran.guides.simpanZoom', $pendaftaran->id) }}"
                  method="POST" class="mt-2">
                @csrf
                <div class="mb-3">
                    <label for="link_zoom" class="form-label">Tambah / Update Link Zoom</label>
                    <input type="url" name="link_zoom" id="link_zoom" class="form-control" placeholder="https://..." required>
                </div>
                <div class="mb-3">
                    <input type="text" name="keterangan" class="form-control" placeholder="Keterangan (opsional)">
                </div>
                <button type="submit" class="btn btn-primary">Simpan Link Zoom</button>
            </form>
        @endif

    {{-- ====================== PAKET 1 & 3 ====================== --}}
    @else
        <h4 class="mb-2">File dari Siswa</h4>
        @if($pendaftaran->file_upload)
            <a href="{{ asset('storage/' . $pendaftaran->file_upload) }}" target="_blank" class="btn btn-outline-info btn-sm">
                Lihat File Siswa
            </a>
        @else
            <p class="text-muted">Belum ada file dari siswa.</p>
        @endif

        {{-- Hanya setelah status diterima --}}
        @if(($pendaftaran->pendaftaran->status ?? null) === 'diterima')
            <hr class="my-4">
            <h4 class="mb-2">File Hasil Admin</h4>

            @php
                $hasilRows = $pendaftaran->hasilFiles->whereNotNull('file_hasil');
            @endphp

            @if($hasilRows->isEmpty())
                <p class="text-muted">Belum ada file hasil.</p>
            @else
                <ul class="list-unstyled">
                    @foreach($hasilRows as $hf)
                        <li class="mb-2">
                            <a href="{{ asset('storage/' . $hf->file_hasil) }}" target="_blank">
                                {{ basename($hf->file_hasil) }}
                            </a>
                            <small class="text-muted">
                                @if($hf->keterangan) ({{ $hf->keterangan }}) @endif
                                • {{ $hf->created_at->format('d M Y H:i') }}
                                @if($hf->uploader) • oleh {{ $hf->uploader->name }} @endif
                            </small>
                            <form action="{{ route('admin.pendaftaran.guides.hapusHasil', $hf->id) }}"
                                  method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus file ini?')">
                                    Hapus
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @endif

            <form action="{{ route('admin.pendaftaran.guides.uploadHasil', $pendaftaran->id) }}"
                  method="POST" enctype="multipart/form-data" class="mt-3">
                @csrf
                <div class="mb-3">
                    <label for="file_hasil" class="form-label">Upload File Hasil (PDF/DOC/PPT/ZIP/RAR, maks 5MB)</label>
                    <input type="file" name="file_hasil" id="file_hasil" class="form-control" required>
                    @error('file_hasil') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mb-3">
                    <input type="text" name="keterangan" class="form-control" placeholder="Keterangan (opsional)">
                </div>
                <button type="submit" class="btn btn-primary">Upload File Hasil</button>
            </form>
        @endif
    @endif
</div>
@endsection
