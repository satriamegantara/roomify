@extends('layouts.app')

@push('styles')
    @vite('resources/css/profile.css')
@endpush

@section('title', 'Profil')

@section('content')
    <div class="payment-header" style="margin-bottom: 1.5rem;">
        <div class="payment-header-top">
            <div>
                <h1 class="payment-title"><i class="bi bi-person-circle me-2"></i>Profil Saya</h1>
                <p class="payment-subtitle">Kelola informasi akun, keamanan, dan preferensi Anda.</p>
            </div>
        </div>
    </div>

    <div class="profile-wrapper">
        <!-- Profile Info -->
        <div class="profile-card">
            <h3><i class="bi bi-card-text me-2 text-primary"></i>Informasi Akun</h3>
            <p class="subtitle">Perbarui nama dan email yang digunakan untuk akun Anda.</p>

            <form method="post" action="{{ route('profile.update') }}" class="form-grid" id="formProfile">
                @csrf
                @method('patch')

                <div class="form-grid">
                    <label class="label" for="name">Nama Lengkap</label>
                    <input id="name" name="name" type="text" class="input-control" value="{{ old('name', $user->name) }}"
                        required>
                    @error('name')
                        <div class="alert-inline">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-grid">
                    <label class="label" for="email">Email</label>
                    <input id="email" name="email" type="email" class="input-control"
                        value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="alert-inline">{{ $message }}</div>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                        <span class="badge-verify pending"><i class="bi bi-exclamation-circle"></i>Belum terverifikasi</span>
                        <button form="send-verification" class="btn-outline-kosan" style="margin-top: 0.6rem;">Kirim ulang
                            verifikasi</button>
                    @else
                        <span class="badge-verify verified"><i class="bi bi-check2-circle"></i>Terverifikasi</span>
                    @endif
                </div>

                <div style="display:flex; gap:0.75rem; flex-wrap:wrap; margin-top:0.5rem;">
                    <button type="submit" class="btn-primary-kosan"><i class="bi bi-save"></i>Simpan Perubahan</button>
                </div>

                @if (session('status') === 'profile-updated')
                    <div class="alert-inline" style="margin-top:0.75rem;">Perubahan profil disimpan.</div>
                @endif
            </form>

            <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="d-none">
                @csrf
            </form>
        </div>

        <!-- Password & Security -->
        <div class="profile-card">
            <h3><i class="bi bi-shield-lock me-2 text-primary"></i>Kata Sandi & Keamanan</h3>
            <p class="subtitle">Pastikan kata sandi Anda kuat dan unik.</p>

            <form method="post" action="{{ route('password.update') }}" class="form-grid" id="formPassword">
                @csrf
                @method('put')

                <div class="form-grid">
                    <label class="label" for="current_password">Kata Sandi Saat Ini</label>
                    <input id="current_password" name="current_password" type="password" class="input-control"
                        autocomplete="current-password">
                    @if ($errors->updatePassword->has('current_password'))
                        <div class="alert-inline">{{ $errors->updatePassword->first('current_password') }}</div>
                    @endif
                </div>

                <div class="form-grid two">
                    <div>
                        <label class="label" for="password">Kata Sandi Baru</label>
                        <input id="password" name="password" type="password" class="input-control"
                            autocomplete="new-password">
                        @if ($errors->updatePassword->has('password'))
                            <div class="alert-inline">{{ $errors->updatePassword->first('password') }}</div>
                        @endif
                    </div>
                    <div>
                        <label class="label" for="password_confirmation">Konfirmasi Kata Sandi</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="input-control"
                            autocomplete="new-password">
                        @if ($errors->updatePassword->has('password_confirmation'))
                            <div class="alert-inline">{{ $errors->updatePassword->first('password_confirmation') }}</div>
                        @endif
                    </div>
                </div>

                <div style="display:flex; gap:0.75rem; flex-wrap:wrap; margin-top:0.5rem;">
                    <button type="submit" class="btn-primary-kosan"><i class="bi bi-shield-check"></i>Perbarui Kata
                        Sandi</button>
                </div>

                @if (session('status') === 'password-updated')
                    <div class="alert-inline" style="margin-top:0.75rem;">Kata sandi berhasil diperbarui.</div>
                @endif
            </form>
        </div>

        <!-- Delete Account -->
        <div class="profile-card danger-card">
            <h3><i class="bi bi-exclamation-triangle me-2 text-danger"></i>Hapus Akun</h3>
            <p class="subtitle">Tindakan ini tidak bisa dibatalkan. Seluruh data akan dihapus permanen.</p>

            <form method="post" action="{{ route('profile.destroy') }}"
                onsubmit="return confirm('Hapus akun secara permanen?')">
                @csrf
                @method('delete')

                <div class="form-grid">
                    <label class="label" for="delete_password">Konfirmasi Kata Sandi</label>
                    <input id="delete_password" name="password" type="password" class="input-control"
                        placeholder="Masukkan kata sandi">
                    @if ($errors->userDeletion->has('password'))
                        <div class="alert-inline" style="background:#fee2e2; border-color:#fecdd3; color:#991b1b;">
                            {{ $errors->userDeletion->first('password') }}</div>
                    @endif
                </div>

                <div style="display:flex; gap:0.75rem; flex-wrap:wrap; margin-top:0.5rem;">
                    <button type="submit" class="btn-danger-kosan"><i class="bi bi-trash"></i>Hapus Akun</button>
                    <a href="{{ route('home') }}" class="btn-outline-kosan">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection