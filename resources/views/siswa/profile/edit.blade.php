@extends('landing.layout.main')

@section('title', 'Edit Profil')

@section('content')
<style>
    .page-heading {
        background: linear-gradient(135deg, #2ecc71, #27ae60);
        padding: 2rem 1rem;
        border-radius: 12px;
        color: #fff;
        margin-bottom: 2rem;
        text-align: center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .page-heading h3 {
        font-weight: 700;
        font-size: 2.2rem;
        position: relative;
        padding-bottom: 0.5rem;
    }
    .page-heading h3::after {
        content: "";
        position: absolute;
        width: 50%;
        height: 3px;
        background: #a3e635;
        bottom: 0;
        left: 25%;
        border-radius: 2px;
        animation: underlineGlowGreen 2s ease-in-out infinite;
    }
    @keyframes underlineGlowGreen {
        0%, 100% {
            box-shadow: 0 0 8px #a3e635, 0 0 18px #a3e635;
        }
        50% {
            box-shadow: 0 0 16px #a3e635, 0 0 36px #a3e635;
        }
    }

    .card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 16px 40px rgba(39, 174, 96, 0.15);
        max-width: 600px;
        margin: auto;
        padding: 2rem;
    }

    label {
        font-weight: 600;
        color: #2e7d32;
    }

    input.form-control {
        border: 2px solid #a5d6a7;
        border-radius: 10px;
        margin-bottom: 1rem;
        padding: 0.6rem 1rem;
    }

    input.form-control:focus {
        border-color: #2e7d32;
        box-shadow: 0 0 6px #66bb6a;
    }

    button.btn-primary {
        background: linear-gradient(90deg, #43a047, #2e7d32);
        border: none;
        padding: 0.65rem 1.8rem;
        font-weight: 700;
        font-size: 1rem;
        border-radius: 50px;
        box-shadow: 0 6px 12px #43a047aa;
        width: 100%;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 0 8px rgba(0, 128, 0, 0.2);
        text-align: center;
        font-weight: 600;
    }

    img.profile-preview {
        border-radius: 8px;
        margin-bottom: 1rem;
    }
</style>

<div class="page-heading">
    <h3>Edit Profil</h3>
</div>

<div class="card">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="name">Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
        </div>

        <div>
            <label for="nohp">No HP</label>
            <input type="text" name="nohp" class="form-control" value="{{ old('nohp', $user->nohp) }}">
        </div>

        <div>
            <label for="password">Password Baru (kosongkan jika tidak diganti)</label>
            <input type="password" name="password" class="form-control">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password">
        </div>

        <div>
            <label for="photo">Foto Profil</label><br>
            @if ($user->photo)
                <img src="{{ asset('storage/' . $user->photo) }}" width="100" class="profile-preview"><br>
            @endif
            <input type="file" name="photo" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
    </form>
</div>
@endsection
