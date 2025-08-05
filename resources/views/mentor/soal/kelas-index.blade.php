@extends('mentor.layout.main')

@section('content')
<div class="container">
    <h4>Daftar Kelas Anda</h4>

    @if($kelasList->isEmpty())
        <p>Belum ada kelas yang terdaftar.</p>
    @else
        <div class="accordion" id="accordionKelas">
            @foreach($kelasList as $kelas)
                <div class="accordion-item mb-2">
                    <h2 class="accordion-header" id="heading{{ $kelas->id }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $kelas->id }}">
                            {{ $kelas->nama_kelas }}
                        </button>
                    </h2>
                    <div id="collapse{{ $kelas->id }}" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <p>Pilih pertemuan keberapa:</p>
                            <div class="d-flex flex-wrap gap-2">
                                @for($i = 1; $i <= 8; $i++)
                                    <a href="{{ route('mentor.soal.index', ['kelas_id' => $kelas->id, 'pertemuan_ke' => $i]) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        Pertemuan ke-{{ $i }}
                                    </a>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
