@extends('admin.layout')

@section('title', 'Manajemen Admin')

@section('content')
<div style="max-width:1200px;">
    {{-- Header --}}
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:2.5rem;">
        <div>
            <h1 style="font-size:32px; font-weight:800; letter-spacing:-0.04em; margin-bottom:8px;">Manajemen Admin</h1>
            <p style="color:rgba(255,255,255,0.4); font-size:14px;">Kelola siapa saja yang bisa mengakses dashboard ini</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="width:16px; height:16px;">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Tambah Admin
        </a>
    </div>

    <div class="glass-card" style="overflow:hidden;">
        <table style="width:100%; border-collapse:collapse; text-align:left;">
            <thead>
                <tr style="border-bottom:1px solid rgba(255,255,255,0.06); background:rgba(255,255,255,0.02);">
                    <th style="padding:16px 24px; font-size:11px; text-transform:uppercase; letter-spacing:0.1em; color:rgba(255,255,255,0.3); font-weight:700;">Nama</th>
                    <th style="padding:16px 24px; font-size:11px; text-transform:uppercase; letter-spacing:0.1em; color:rgba(255,255,255,0.3); font-weight:700;">Email</th>
                    <th style="padding:16px 24px; font-size:11px; text-transform:uppercase; letter-spacing:0.1em; color:rgba(255,255,255,0.3); font-weight:700;">Tgl Dibuat</th>
                    <th style="padding:16px 24px; font-size:11px; text-transform:uppercase; letter-spacing:0.1em; color:rgba(255,255,255,0.3); font-weight:700; text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr style="border-bottom:1px solid rgba(255,255,255,0.04); transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.01)'" onmouseout="this.style.background='transparent'">
                    <td style="padding:20px 24px;">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="width:32px; height:32px; background:rgba(124,58,237,0.1); border-radius:8px; display:flex; align-items:center; justify-content:center; color:#a78bfa; font-weight:700; font-size:12px; border:1px solid rgba(124,58,237,0.1);">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <span style="font-weight:600; color:#fff;">{{ $user->name }}</span>
                            @if($user->id === auth()->id())
                            <span style="background:var(--brand-muted); color:var(--brand); font-size:9px; padding:2px 6px; border-radius:4px; font-weight:700; text-transform:uppercase;">Anda</span>
                            @endif
                        </div>
                    </td>
                    <td style="padding:20px 24px; color:rgba(255,255,255,0.5); font-size:14px;">{{ $user->email }}</td>
                    <td style="padding:20px 24px; color:rgba(255,255,255,0.3); font-size:13px;">{{ $user->created_at->format('d M Y') }}</td>
                    <td style="padding:20px 24px; text-align:right;">
                        <div style="display:flex; gap:8px; justify-content:flex-end;">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn-secondary" style="padding:8px 12px; font-size:11px;">Edit</a>
                            @if($user->id !== auth()->id())
                            <button type="button" class="btn-danger" style="padding:8px 12px; font-size:11px;" onclick="openDeleteModal('{{ route('admin.users.destroy', $user) }}')">Hapus</button>
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
