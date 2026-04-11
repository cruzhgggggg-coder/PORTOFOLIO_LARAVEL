@extends('admin.layout')

@section('title', 'Admin Management')

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">
    {{-- Header --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2.5rem;">
        <div>
            <h1 style="font-size:32px; font-weight:800; letter-spacing:-0.04em; margin-bottom:8px;">Admin Management</h1>
            <p style="color:rgba(255,255,255,0.4); font-size:14px;">Manage accounts authorized to access this dashboard.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-primary" style="padding:12px 24px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:16px; height:16px;">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Add New Admin
        </a>
    </div>

    @if(session('success'))
        <div style="background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.2); color:#4ade80; padding:16px; border-radius:12px; margin-bottom:24px; font-size:14px; display:flex; align-items:center; gap:12px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px; height:18px;">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); color:#f87171; padding:16px; border-radius:12px; margin-bottom:24px; font-size:14px; display:flex; align-items:center; gap:12px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px; height:18px;">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="15" y1="9" x2="9" y2="15"></line>
                <line x1="9" y1="9" x2="15" y2="15"></line>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Admin List Card --}}
    <div style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.06); border-radius:24px; overflow:hidden;">
        <table style="width:100%; border-collapse:collapse; text-align:left;">
            <thead>
                <tr style="border-bottom:1px solid rgba(255,255,255,0.06);">
                    <th style="padding:20px 24px; color:rgba(255,255,255,0.4); font-weight:600; font-size:13px; text-transform:uppercase; letter-spacing:0.05em;">Admin</th>
                    <th style="padding:20px 24px; color:rgba(255,255,255,0.4); font-weight:600; font-size:13px; text-transform:uppercase; letter-spacing:0.05em;">Email Address</th>
                    <th style="padding:20px 24px; color:rgba(255,255,255,0.4); font-weight:600; font-size:13px; text-transform:uppercase; letter-spacing:0.05em; text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                <tr style="border-bottom:1px solid rgba(255,255,255,0.03); transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.01)'" onmouseout="this.style.background='transparent'">
                    <td style="padding:20px 24px;">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="width:36px; height:36px; border-radius:10px; background:linear-gradient(135deg, rgba(59,130,246,0.2), rgba(147,51,234,0.2)); display:flex; align-items:center; justify-content:center; color:#3b82f6; font-weight:700;">
                                {{ substr($admin->name, 0, 1) }}
                            </div>
                            <span style="font-weight:600; color:rgba(255,255,255,0.9);">{{ $admin->name }}</span>
                            @if($admin->id === auth()->id())
                                <span style="font-size:10px; background:rgba(59,130,246,0.1); border:1px solid rgba(59,130,246,0.2); color:#3b82f6; padding:2px 8px; border-radius:100px; text-transform:uppercase; font-weight:700; letter-spacing:0.05em;">You</span>
                            @endif
                        </div>
                    </td>
                    <td style="padding:20px 24px;">
                        <span style="color:rgba(255,255,255,0.5);">{{ $admin->email }}</span>
                    </td>
                    <td style="padding:20px 24px; text-align:right;">
                        <div style="display:flex; justify-content:flex-end; gap:8px;">
                            <a href="{{ route('admin.users.edit', $admin->id) }}" class="btn-secondary" style="padding:8px 16px; font-size:13px;">
                                Edit
                            </a>
                            @if($admin->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Hapus admin ini? Tindakan ini tidak dapat dibatalkan.')" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); color:#f87171; padding:8px 16px; border-radius:10px; font-size:13px; font-weight:600; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.background='rgba(239,68,68,0.2)'" onmouseout="this.style.background='rgba(239,68,68,0.1)'">
                                    Delete
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
