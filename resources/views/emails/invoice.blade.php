@component('mail::message')
# Invoice Pendaftaran Program

Halo {{ $pendaftaran->user->name ?? 'Peserta' }},

Terima kasih telah mendaftar program **{{ $pendaftaran->program->nama_program ?? '-' }}**.

Detail pembayaran Anda ada di file PDF yang terlampir.

@component('mail::button', ['url' => url('/dashboard')])
Buka Dashboard
@endcomponent

Terima kasih,
{{ config('app.name') }}
@endcomponent
