@extends('admin.layout')

@section('title', 'Edit Data Admin')

@section('content')
<div style="max-width:600px;">
    {{-- Breadcrumb --}}
    <div style="margin-bottom:2rem;">
        <a href="{{ route('admin.users.index') }}" style="display:inline-flex; align-items:center; gap:8px; color:rgba(255,255,255,0.4); font-size:13px; font-weight:500; text-decoration:none;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px; height:16px;">
                <polyline points="15 18 9 12 15 6" />
            </svg>
            Kembali ke Daftar Admin
        </a>
    </div>

    <h1 style="font-size:32px; font-weight:800; letter-spacing:-0.04em; margin-bottom:2.5rem;">Edit Admin: {{ $user->name }}</h1>

    <div class="glass-card" style="padding:32px;">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom:24px;">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                @error('name') <div style="color:#f87171; font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom:24px;">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                @error('email') <div style="color:#f87171; font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
            </div>

            <div style="margin:32px 0 24px; padding-top:24px; border-top:1px solid rgba(255,255,255,0.06);">
                <div style="font-size:14px; font-weight:700; color:#fff; margin-bottom:4px;">Ganti Password (Opsional)</div>
                <p style="font-size:12px; color:rgba(255,255,255,0.3); margin-bottom:20px;">Kosongkan jika tidak ingin mengubah password.</p>

                <div style="margin-bottom:20px;">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-input">
                    @error('password') <div style="color:#f87171; font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-input">
                </div>
            </div>

            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <a href="{{ route('admin.users.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Update Data</button>
            </div>
        </form>
    </div>
</div>
@endsection
