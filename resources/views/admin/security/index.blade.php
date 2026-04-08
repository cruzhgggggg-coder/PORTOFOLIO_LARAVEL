@extends('admin.layout')

@section('title', 'Keamanan Akun')

@section('content')
<div style="max-width:800px;">
    {{-- Header --}}
    <div style="margin-bottom:2.5rem;">
        <h1 style="font-size:32px; font-weight:800; letter-spacing:-0.04em; margin-bottom:8px;">Keamanan Akun</h1>
        <p style="color:rgba(255,255,255,0.4); font-size:14px;">Kelola detail login dan password Anda.</p>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
    <div class="glass-card" style="padding:16px 24px; margin-bottom:24px; border-left:3px solid #10b981; background:rgba(16,185,129,0.1);">
        <div style="color:#6ee7b7; font-size:14px; font-weight:600;">{{ session('success') }}</div>
    </div>
    @endif

    <div style="display:grid; gap:24px;">
        {{-- Profile Information --}}
        <div class="glass-card" style="padding:28px;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
                <div style="width:36px; height:36px; background:var(--brand-muted); border:1px solid rgba(0,242,255,0.2); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="var(--brand)" stroke-width="2" style="width:18px; height:18px;">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </div>
                <div>
                    <div style="font-size:16px; font-weight:700; color:#fff;">Informasi Profil</div>
                    <div style="font-size:11px; color:rgba(255,255,255,0.3);">Update nama dan alamat email login Anda</div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.security.profile') }}">
                @csrf
                @method('PUT')

                <div style="margin-bottom:20px;">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input" required>
                    @error('name') <div style="color:#f87171; font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
                </div>

                <div style="margin-bottom:24px;">
                    <label class="form-label">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input" required>
                    @error('email') <div style="color:#f87171; font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
                </div>

                <div style="display:flex; justify-content:flex-end;">
                    <button type="submit" class="btn-primary">Simpan Profil</button>
                </div>
            </form>
        </div>

        {{-- Update Password --}}
        <div class="glass-card" style="padding:28px;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
                <div style="width:36px; height:36px; background:rgba(245,158,11,0.15); border:1px solid rgba(245,158,11,0.2); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="2" style="width:18px; height:18px;">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                </div>
                <div>
                    <div style="font-size:16px; font-weight:700; color:#fff;">Ganti Password</div>
                    <div style="font-size:11px; color:rgba(255,255,255,0.3);">Pastikan akun Anda menggunakan password yang kuat</div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.security.password') }}">
                @csrf
                @method('PUT')

                <div style="margin-bottom:20px;">
                    <label class="form-label">Password Saat Ini</label>
                    <input type="password" name="current_password" class="form-input" required>
                    @error('current_password') <div style="color:#f87171; font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
                </div>

                <div style="margin-bottom:20px;">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-input" required>
                    @error('password') <div style="color:#f87171; font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
                </div>

                <div style="margin-bottom:24px;">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-input" required>
                </div>

                <div style="display:flex; justify-content:flex-end;">
                    <button type="submit" class="btn-primary">Ganti Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
