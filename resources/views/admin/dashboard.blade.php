
@extends('admin.layout.main')

@section('title', 'Dashboard Admin')

@section('content')

<div class="page-heading">
    <h3>Dashboard Admin</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-9">
            {{-- Statistik --}}
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-start">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldDocument"></i>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h6 class="text-muted font-semibold">Total Pendaftaran</h6>
                                    <h6 class="font-extrabold mb-0">{{ $jumlahPendaftaran }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-start">
                                    <div class="stats-icon green mb-2">
                                        <i class="iconly-boldUser"></i>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h6 class="text-muted font-semibold">Total Siswa</h6>
                                    <h6 class="font-extrabold mb-0">{{ $jumlahSiswa }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-start">
                                    <div class="stats-icon red mb-2">
                                        <i class="iconly-boldEdit-Square"></i>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h6 class="text-muted font-semibold">Total Mentor</h6>
                                    <h6 class="font-extrabold mb-0">{{ $jumlahMentor }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-start">
                                    <div class="stats-icon purple mb-2">
                                        <i class="iconly-boldHome"></i>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h6 class="text-muted font-semibold">Total Kelas</h6>
                                    <h6 class="font-extrabold mb-0">{{ $jumlahKelas }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Grafik Pendaftaran Bulanan --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Pendaftaran Bulanan</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="chartPendaftaran" style="height: 300px;"></canvas>

                        </div>
                    </div>
                </div>
            </div>




            {{-- Pendaftaran Terbaru --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pendaftaran Terbaru</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Program</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendaftaranTerbaru as $p)
                                            <tr>
                                                <td>{{ $p->user->name ?? '-' }}</td>
                                                <td>{{ $p->program->nama_program ?? '-' }}</td>
                                                <td>{{ ucfirst($p->status) }}</td>
                                                <td>{{ $p->created_at->format('d M Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Sidebar Kanan --}}
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                    @if ($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" class="rounded-circle" width="80" alt="Foto Admin">
                    @else
                        <img src="{{ asset('default-avatar.png') }}" class="rounded-circle" width="80" alt="Foto Admin Default">
                    @endif
                </div>
                <div class="ms-3 name">
                    <h5 class="font-bold">Admin GenZE</h5>
                    <h6 class="text-muted mb-0">Administrator</h6>
                </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
    <div class="card-body py-3 px-4">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h6 class="text-muted mb-1">Saldo Akhir</h6>
                <h5 class="font-bold">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</h5>
            </div>
            <i class="bi bi-wallet2 fs-3 text-success"></i>
        </div>
    </div>
</div>

            {{-- Placeholder visitor profile / custom --}}
            <div class="card">
    <div class="card-header">
        <h4>Statistik Pengunjung Berdasarkan Jenis Kelamin</h4>
    </div>
    <div class="card-body">
        <canvas id="genderChart" height="150"></canvas>
    </div>
</div>


            {{-- Siswa Aktif per Kelas --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Siswa Aktif per Kelas</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach($siswaAktifPerKelas as $kelas)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $kelas->nama_kelas }}
                                        <span class="badge bg-primary rounded-pill">{{ $kelas->siswa_count }} siswa</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@push('scripts')
<script>
    const ctxGender = document.getElementById('genderChart')?.getContext('2d');
    if (ctxGender) {
        new Chart(ctxGender, {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [{{ $jumlahLaki }}, {{ $jumlahPerempuan }}],
                    backgroundColor: ['#4e73df', '#e74a3b'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                }
            }
        });
    }

    const ctxPendaftaran = document.getElementById('chartPendaftaran')?.getContext('2d');
    if (ctxPendaftaran) {
        new Chart(ctxPendaftaran, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Pendaftaran',
                    data: {!! json_encode($chartData) !!},
                    backgroundColor: '#3b82f6',
                    borderRadius: 6,
                    barPercentage: 0.6,
                    categoryPercentage: 0.5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        padding: 10
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#cbd5e1',
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        ticks: {
                            color: '#cbd5e1',
                            font: {
                                size: 12
                            },
                            precision: 0
                        },
                        grid: {
                            color: '#334155'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    }
</script>
@endpush





