@extends('admin.layout')

@section('title', 'Edit Admin Account')

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
        <h1 style="font-size:32px; font-weight:800; letter-spacing:-0.04em; margin-bottom:8px;">Edit Admin Account</h1>
        <p style="color:rgba(255,255,255,0.4); font-size:14px;">Update account details and security settings.</p>
    </div>

    {{-- Form Card --}}
    <div style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.06); border-radius:24px; padding:32px;">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="display:grid; gap:24px;">
                {{-- Name --}}
                <div style="display:grid; gap:8px;">
                    <label style="font-size:14px; font-weight:600; color:rgba(255,255,255,0.9);">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                        style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:12px; padding:12px 16px; color:#fff; font-size:14px; transition:all 0.2s;"
                        onfocus="this.style.border='1px solid rgba(59,130,246,0.5)'; this.style.background='rgba(59,130,246,0.05)'"
                        onblur="this.style.border='1px solid rgba(255,255,255,0.1)'; this.style.background='rgba(255,255,255,0.05)'">
                    @error('name') <span style="color:#f87171; font-size:12px;">{{ $message }}</span> @enderror
                </div>

                {{-- Email --}}
                <div style="display:grid; gap:8px;">
                    <label style="font-size:14px; font-weight:600; color:rgba(255,255,255,0.9);">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                        style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:12px; padding:12px 16px; color:#fff; font-size:14px; transition:all 0.2s;"
                        onfocus="this.style.border='1px solid rgba(59,130,246,0.5)'; this.style.background='rgba(59,130,246,0.05)'"
                        onblur="this.style.border='1px solid rgba(255,255,255,0.1)'; this.style.background='rgba(255,255,255,0.05)'">
                    @error('email') <span style="color:#f87171; font-size:12px;">{{ $message }}</span> @enderror
                </div>

                <div style="margin:8px 0; height:1px; background:rgba(255,255,255,0.06);"></div>

                {{-- Password Warning --}}
                <div style="background:rgba(59,130,246,0.05); border:1px solid rgba(59,130,246,0.1); border-radius:12px; padding:16px;">
                    <div style="display:flex; gap:12px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" style="width:20px; height:20px; flex-shrink:0;">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        <p style="color:rgba(255,255,255,0.5); font-size:13px; margin:0; line-height:1.5;">
                            Leave the password fields empty if you don't want to change the existing password.
                        </p>
                    </div>
                </div>

                {{-- Password --}}
                <div style="display:grid; gap:8px;">
                    <label style="font-size:14px; font-weight:600; color:rgba(255,255,255,0.9);">New Password</label>
                    <input type="password" name="password" 
                        style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:12px; padding:12px 16px; color:#fff; font-size:14px; transition:all 0.2s;"
                        onfocus="this.style.border='1px solid rgba(59,130,246,0.5)'; this.style.background='rgba(59,130,246,0.05)'"
                        onblur="this.style.border='1px solid rgba(255,255,255,0.1)'; this.style.background='rgba(255,255,255,0.05)'">
                    @error('password') <span style="color:#f87171; font-size:12px;">{{ $message }}</span> @enderror
                </div>

                {{-- Password Confirmation --}}
                <div style="display:grid; gap:8px;">
                    <label style="font-size:14px; font-weight:600; color:rgba(255,255,255,0.9);">Confirm New Password</label>
                    <input type="password" name="password_confirmation" 
                        style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:12px; padding:12px 16px; color:#fff; font-size:14px; transition:all 0.2s;"
                        onfocus="this.style.border='1px solid rgba(59,130,246,0.5)'; this.style.background='rgba(59,130,246,0.05)'"
                        onblur="this.style.border='1px solid rgba(255,255,255,0.1)'; this.style.background='rgba(255,255,255,0.05)'">
                </div>

                <div style="padding-top:12px;">
                    <button type="submit" class="btn-primary" style="width:100%; padding:14px;">
                        Update Account Information
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
