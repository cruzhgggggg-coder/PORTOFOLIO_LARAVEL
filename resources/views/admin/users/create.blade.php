@extends('admin.layout')

@section('title', 'Tambah Admin Baru')

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

    <h1 style="font-size:32px; font-weight:800; letter-spacing:-0.04em; margin-bottom:2.5rem;">Tambah Admin Baru</h1>

    <div class="glass-card" style="padding:32px;">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            
            <div style="margin-bottom:24px;">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-input" value="{{ old('name') }}" placeholder="Contoh: Admin Utama" required>
                @error('name') <div style="color:#f87171; font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom:24px;">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="admin@example.com" required>
                @error('email') <div style="color:#f87171; font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom:24px;">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input" required>
                @error('password') <div style="color:#f87171; font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom:32px;">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-input" required>
            </div>

            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <a href="{{ route('admin.users.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Buat Akun Admin</button>
            </div>
        </form>
    </div>
</div>
@endsection
