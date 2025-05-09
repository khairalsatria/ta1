@extends('landing.layout.main')

@section('content')
<h2 class="text-xl font-bold mb-4">Daftar Pendaftar Guide</h2>
<table class="table-auto w-full border">
    <thead>
        <tr>
            <th class="border px-2 py-1">Nama</th>
            <th class="border px-2 py-1">Paket</th>
            <th class="border px-2 py-1">Status</th>
            <th class="border px-2 py-1">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pendaftarans as $p)
        <tr>
            <td class="border px-2 py-1">{{ $p->pendaftaran->user->name ?? '-' }}</td>
            <td class="border px-2 py-1">Paket {{ $p->paket_guide }}</td>
            <td class="border px-2 py-1">{{ $p->pendaftaran->status }}</td>
            <td class="border px-2 py-1">
                <a href="{{ route('admin.pendaftaran.guides.show', $p->id) }}" class="text-blue-500">Detail</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
