@extends('admin.layout')

@section('title', 'Add New Admin')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    {{-- Back Link --}}
    <a href="{{ route('admin.users.index') }}" style="display:inline-flex; align-items:center; gap:8px; color:rgba(255,255,255,0.4); text-decoration:none; margin-bottom:24px; font-size:14px; transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.4)'">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:16px; height:16px;">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Back to Admin List
    </a>

    {{-- Header --}}
    <div style="margin-bottom:2.5rem;">
        <h1 style="font-size:32px; font-weight:800; letter-spacing:-0.04em; margin-bottom:8px;">Add New Admin</h1>
        <p style="color:rgba(255,255,255,0.4); font-size:14px;">Create a new account with administrative access.</p>
    </div>

    {{-- Form Card --}}
    <div style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.06); border-radius:24px; padding:32px;">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <div style="display:grid; gap:24px;">
                {{-- Name --}}
                <div style="display:grid; gap:8px;">
                    <label style="font-size:14px; font-weight:600; color:rgba(255,255,255,0.9);">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required 
                        style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:12px; padding:12px 16px; color:#fff; font-size:14px; transition:all 0.2s;"
                        onfocus="this.style.border='1px solid rgba(59,130,246,0.5)'; this.style.background='rgba(59,130,246,0.05)'"
                        onblur="this.style.border='1px solid rgba(255,255,255,0.1)'; this.style.background='rgba(255,255,255,0.05)'">
                    @error('name') <span style="color:#f87171; font-size:12px;">{{ $message }}</span> @enderror
                </div>

                {{-- Email --}}
                <div style="display:grid; gap:8px;">
                    <label style="font-size:14px; font-weight:600; color:rgba(255,255,255,0.9);">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                        style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:12px; padding:12px 16px; color:#fff; font-size:14px; transition:all 0.2s;"
                        onfocus="this.style.border='1px solid rgba(59,130,246,0.5)'; this.style.background='rgba(59,130,246,0.05)'"
                        onblur="this.style.border='1px solid rgba(255,255,255,0.1)'; this.style.background='rgba(255,255,255,0.05)'">
                    @error('email') <span style="color:#f87171; font-size:12px;">{{ $message }}</span> @enderror
                </div>

                {{-- Password --}}
                <div style="display:grid; gap:8px;">
                    <label style="font-size:14px; font-weight:600; color:rgba(255,255,255,0.9);">Password</label>
                    <input type="password" name="password" required 
                        style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:12px; padding:12px 16px; color:#fff; font-size:14px; transition:all 0.2s;"
                        onfocus="this.style.border='1px solid rgba(59,130,246,0.5)'; this.style.background='rgba(59,130,246,0.05)'"
                        onblur="this.style.border='1px solid rgba(255,255,255,0.1)'; this.style.background='rgba(255,255,255,0.05)'">
                    @error('password') <span style="color:#f87171; font-size:12px;">{{ $message }}</span> @enderror
                </div>

                {{-- Password Confirmation --}}
                <div style="display:grid; gap:8px;">
                    <label style="font-size:14px; font-weight:600; color:rgba(255,255,255,0.9);">Confirm Password</label>
                    <input type="password" name="password_confirmation" required 
                        style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:12px; padding:12px 16px; color:#fff; font-size:14px; transition:all 0.2s;"
                        onfocus="this.style.border='1px solid rgba(59,130,246,0.5)'; this.style.background='rgba(59,130,246,0.05)'"
                        onblur="this.style.border='1px solid rgba(255,255,255,0.1)'; this.style.background='rgba(255,255,255,0.05)'">
                </div>

                <div style="padding-top:12px;">
                    <button type="submit" class="btn-primary" style="width:100%; padding:14px;">
                        Create Admin Account
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
