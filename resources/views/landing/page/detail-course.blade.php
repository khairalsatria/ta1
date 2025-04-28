@extends('landing.layout.main')

@section('title', 'Detail Course')

@section('content')

<!-- Header Start -->
<div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom" style="margin-bottom: 90px;">
    <div class="container text-center py-5">
        <h1 class="text-white display-1">Course Detail</h1>
        <div class="d-inline-flex text-white mb-5">
            {{-- <p class="m-0 text-uppercase"><a class="text-white" href="{{ route('landing.home') }}">Home</a></p> --}}
            <i class="fa fa-angle-double-right pt-1 px-3"></i>
            <p class="m-0 text-uppercase">Course Detail</p>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Detail Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row">
            @foreach($promosi_classes as $item)
            <div class="col-lg-8">
                <div class="mb-5">
                    <div class="section-title position-relative mb-5">
                        <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Course Detail</h6>
                        <h1 class="display-4">{{ $item->nama_program }}</h1>
                    </div>
                    <img class="img-fluid rounded w-100 mb-4" src="{{ $item->gambar ? asset('images/promosi/' . $item->gambar) : asset('images/default-course.png') }}" alt="Image">
                    <p>{!! nl2br(e($item->deskripsi)) !!}</p>
                </div>

                <!-- Related Courses -->
                <h2 class="mb-3">Related Courses</h2>
                <div class="owl-carousel related-carousel position-relative" style="padding: 0 30px;">
                    <!-- Contoh dummy related courses -->
                    <a class="courses-list-item position-relative d-block overflow-hidden mb-2" href="#">
                        <img class="img-fluid" src="{{ asset('images/courses-1.jpg') }}" alt="">
                        <div class="courses-text">
                            <h4 class="text-center text-white px-3">Basic Web Development</h4>
                            <div class="border-top w-100 mt-3">
                                <div class="d-flex justify-content-between p-4">
                                    <span class="text-white"><i class="fa fa-user mr-2"></i>Mentor</span>
                                    <span class="text-white"><i class="fa fa-star mr-2"></i>4.5 (250)</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-4 mt-5 mt-lg-0">
                <div class="bg-primary mb-5 py-3">
                    <h3 class="text-white py-3 px-4 m-0">Course Features</h3>
                    <div class="px-4">
                        <ul class="list-unstyled text-white my-3">
                            <li><strong>Benefit:</strong></li>
                            @foreach(explode(',', $item->benefit) as $benefit)
                                <li>✔️ {{ trim($benefit) }}</li>
                            @endforeach
                        </ul>
                        <h5 class="text-white py-3">Harga: Rp {{ number_format($item->harga, 0, ',', '.') }}</h5>

                        <!-- Tombol Open Modal -->
                        <button type="button" class="btn btn-light w-100" data-toggle="modal" data-target="#enrollModal">
                            Daftar Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="enrollModal" tabindex="-1" role="dialog" aria-labelledby="enrollModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    {{-- <form action="{{ route('enroll.store') }}" method="POST" class="modal-content"> --}}
                        @csrf
                        <input type="hidden" name="promosi_class_id" value="{{ $item->id }}">

                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="enrollModalLabel">Form Pendaftaran</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">

                            <div class="form-group">
                                <label>Jenis Kelas</label>
                                <select name="jenis_kelas" class="form-control" required>
                                    <option value="">Pilih Jenis Kelas</option>
                                    <option value="Online Zoom">Online Zoom</option>
                                    <option value="Offline Home Private">Offline Home Private</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Kelas</label>
                                <select name="kelas" class="form-control" required>
                                    <option value="">Pilih Kelas</option>
                                    <option value="1 SD">1 SD</option>
                                    <option value="2 SD">2 SD</option>
                                    <option value="3 SD">3 SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Jenjang Pendidikan</label>
                                <select name="jenjang" class="form-control" required>
                                    <option value="">Pilih Jenjang</option>
                                    <option value="TK">TK</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Mata Pelajaran</label>
                                <input type="text" name="mata_pelajaran" class="form-control" placeholder="Contoh: Matematika" required>
                            </div>

                            <div class="form-group">
                                <label>Jadwal Kelas</label>
                                <input type="text" name="jadwal" class="form-control" placeholder="Contoh: Senin & Rabu, 16.00 - 17.30" required>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal End -->

            @endforeach
        </div>
    </div>
</div>
<!-- Detail End -->

@endsection
