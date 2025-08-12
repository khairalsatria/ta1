@extends('mentor.layout.main')

@section('title', 'Detail Kelas')

@section('content')
    <!-- Card Kelas Aktif -->
    <div class="card border-start border-4 border-primary shadow-sm mb-4">
        <div class="card-body d-flex align-items-center">
            <div class="me-3">
                <i class="bi bi-mortarboard-fill fs-3 text-primary"></i>
            </div>
            <div>
                <h5 class="mb-1 fw-bold">Kelas Aktif :
                    <span>{{ $kelas->nama_kelas }}</span>
                </h5>
                <p class="mb-0 text-muted small">
    Jadwal Kelas: {{ $kelas->jadwalKelas->jadwalkelas ?? 'Belum diatur' }}
</p>

                <p class="mb-0 text-muted small">Berikut adalah materi, progress, dan pertemuan dari kelas ini.</p>
            </div>
        </div>
    </div>




    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Progress Kelas -->
    {{-- <div class="card mt-4">
        <div class="card-header">
            <h4>📈 Progress Kelas</h4>
        </div>
        <div class="card-body">
            <p class="mb-2">Pertemuan: {{ $pertemuanSudahDilakukan }} dari {{ $totalPertemuan }}</p>
            <div class="progress">
                <div class="progress-bar bg-success" style="width: {{ $progress }}%" role="progressbar">
                    {{ $progress }}%
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Card Jadwal Berikutnya -->
    @if(isset($materiBerikutnya))
         <div class="card mt-4">
                <div class="card-header">
                    <h4> 📅 Pertemuan Berikutnya</h4>
                </div>
            <div class="card-body">
                <p class="mb-1"><strong>Pertemuan {{ $materiBerikutnya->pertemuan_ke }}:</strong> {{ $materiBerikutnya->judul ?? '-' }}</p>
                @if($materiBerikutnya->link_zoom)
                    <p>🔗 Zoom: <a href="{{ $materiBerikutnya->link_zoom }}" class="text-primary" target="_blank">Gabung Zoom</a></p>
                @endif
                <p class="text-muted">
                    📅 Tanggal: {{ \Carbon\Carbon::parse($materiBerikutnya->tanggal_pertemuan)->translatedFormat('l, d M Y H:i') }}
                </p>
            </div>
        </div>
    @endif

    <!-- Card Materi -->
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>📖 Materi Kelas: {{ $kelas->nama_kelas }}</h4>
            <a href="{{ route('mentor.materi.create', $kelas->id) }}" class="btn btn-success btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah Materi
            </a>
        </div>
        <div class="card-body">
            @forelse($kelas->materi->sortBy('pertemuan_ke') as $m)
                <div class="mb-4 border-bottom pb-3">
                    <h5 class="text-primary">Pertemuan {{ $m->pertemuan_ke }}: {{ $m->judul }}</h5>
                    <ul class="list-unstyled ms-3">
                        @if($m->file_pdf)
                            <li>📄 <a href="{{ asset('storage/' . $m->file_pdf) }}" target="_blank">Download Materi (PDF)</a></li>
                        @endif
                        @if($m->link_zoom)
                            <li>🔗 <a href="{{ $m->link_zoom }}" target="_blank" class="text-success">Gabung Zoom</a></li>
                        @endif
                        @if($m->link_rekaman)
                            <li>▶️ <a href="{{ $m->link_rekaman }}" target="_blank" class="text-purple">Lihat Rekaman</a></li>
                        @endif
                    </ul>

                    <!-- Tombol Edit & Hapus -->
                    <div class="mt-2 d-flex gap-2">
                        <a href="{{ route('mentor.materi.edit', ['kelas' => $kelas->id, 'materi' => $m->id]) }}" class="btn btn-sm btn-warning">
    <i class="bi bi-pencil-square"></i>
</a>
<form action="{{ route('mentor.materi.destroy', ['kelas' => $kelas->id, 'materi' => $m->id]) }}" method="POST"
 onsubmit="return confirm('Hapus materi ini?')" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-muted text-center">Belum ada materi untuk kelas ini.</p>
            @endforelse
        </div>
    </div>
@endsection
