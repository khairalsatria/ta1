@extends('admin.layout.main')

@section('title', 'Detail Pendaftaran GenZE Learn')

@section('content')
<h2 class="text-xl font-bold mb-4">Detail Pendaftaran GenZE Learn</h2>

<p><strong>Nama:</strong> {{ $pendaftaran->pendaftaran->user->name ?? '-' }}</p>
<p><strong>Instansi:</strong> {{ $pendaftaran->asal_instansi ?? '-' }}</p>
<p><strong>Status Pembayaran:</strong> {{ ucfirst($pendaftaran->pendaftaran->status) }}</p>

@if ($pendaftaran->pendaftaran->status !== 'diterima')
<form action="{{ route('admin.pendaftaran.learns.verifikasi', $pendaftaran->id) }}" method="POST" class="mb-4">
    @csrf
    <label for="status" class="block font-semibold mb-2">Verifikasi Pembayaran:</label>
    <select name="status" id="status" class="border p-2 rounded w-full" required>
        <option value="">-- Pilih Status --</option>
        <option value="diterima" {{ $pendaftaran->pendaftaran->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
        <option value="ditolak" {{ $pendaftaran->pendaftaran->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
    </select>
    <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Update Status</button>
</form>
@endif

<h3 class="font-semibold mb-2">Upload Sertifikat (PDF)</h3>
<form action="{{ route('admin.pendaftaran.learns.uploadSertifikat', $pendaftaran->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="sertifikat" accept="application/pdf" required>
    <button type="submit" class="mt-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">Unggah Sertifikat</button>
</form>

@if($pendaftaran->sertifikat)
    <p class="mt-4"><strong>File Sertifikat:</strong>
        <a href="{{ asset('storage/' . $pendaftaran->sertifikat) }}" target="_blank" class="text-blue-500 underline hover:text-blue-700">
            Lihat Sertifikat
        </a>
    </p>
@endif
@endsection
