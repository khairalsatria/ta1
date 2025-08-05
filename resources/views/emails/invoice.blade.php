@component('mail::message')
{{-- Header dengan styling khusus --}}
<div style="text-align: center; margin-bottom: 30px;">
    <h1 style="color: #059669; font-size: 28px; font-weight: 700; margin: 0; text-shadow: 0 2px 4px rgba(5, 150, 105, 0.1);">
        🎉 Selamat! Pendaftaran Berhasil
    </h1>
    <div style="width: 60px; height: 4px; background: linear-gradient(90deg, #059669, #10b981); margin: 15px auto; border-radius: 2px;"></div>
</div>

Halo **{{ $pendaftaran->user->name ?? 'Peserta' }}**,

Terima kasih telah bergabung dengan kami! Kami senang menyambut Anda dalam program **{{ $pendaftaran->program->nama_program ?? '-' }}**.

{{-- Card informasi program --}}
<div style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-radius: 12px; padding: 25px; margin: 25px 0; border-left: 5px solid #059669;">
    <h3 style="color: #1e293b; margin: 0 0 15px 0; font-size: 18px;">
        📋 Detail Program Anda
    </h3>
    <div style="display: grid; gap: 8px;">
        <div style="display: flex; justify-content: space-between; padding: 5px 0;">
            <span style="color: #64748b; font-weight: 500;">Program:</span>
            <span style="color: #1e293b; font-weight: 600;">{{ $pendaftaran->program->nama_program ?? '-' }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 5px 0;">
            <span style="color: #64748b; font-weight: 500;">Status:</span>
            <span style="background: #dcfce7; color: #166534; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                {{ ucfirst($pendaftaran->status) }}
            </span>
        </div>
    </div>
</div>

{{-- Informasi pembayaran --}}
<div style="background: #fefce8; border: 1px solid #facc15; border-radius: 8px; padding: 20px; margin: 20px 0;">
    <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <span style="font-size: 20px; margin-right: 8px;">💰</span>
        <strong style="color: #ca8a04;">Detail pembayaran lengkap tersedia dalam file PDF terlampir</strong>
    </div>
    <p style="color: #ca8a04; margin: 0; font-size: 14px;">
        Silakan simpan PDF sebagai bukti pembayaran resmi Anda.
    </p>
</div>

{{-- Button dengan styling modern --}}
@component('mail::button', ['url' => url('/home'), 'color' => 'primary'])
<span style="display: inline-flex; align-items: center; gap: 8px;">
    🚀 Buka Dashboard Saya
</span>
@endcomponent

{{-- Footer informasi --}}
<div style="margin-top: 40px; padding-top: 20px; border-top: 2px solid #bbf7d0;">
    <p style="color: #64748b; font-size: 14px; line-height: 1.6;">
        Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi tim dukungan kami.
        Kami siap membantu Anda 24/7! 💪
    </p>
</div>

Salam hangat,<br>
**Tim {{ config('app.name') }}** ✨
@endcomponent
