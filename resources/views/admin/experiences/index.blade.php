@extends('admin.layout')

@section('title', 'Experience')

@section('content')
<div style="max-width:1000px;">
    {{-- Header --}}
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:2.5rem; gap:20px; flex-wrap:wrap;">
        <div>
            <h1 style="font-size:32px; font-weight:800; letter-spacing:-0.04em; margin-bottom:8px;">Experience & Career</h1>
            <p style="color:rgba(255,255,255,0.4); font-size:14px;">Kelola riwayat pekerjaan, pendidikan, dan sertifikasi profesional kamu.</p>
        </div>
        <a href="{{ route('admin.experiences.create') }}" class="btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:16px;height:16px;">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Add Experience
        </a>
    </div>

    {{-- Filters --}}
    <div class="glass-card" style="padding:20px 24px; margin-bottom:24px;">
        <form method="GET" action="{{ route('admin.experiences.index') }}" style="display:flex; gap:16px; align-items:end;">
            <div style="flex:1;">
                <label class="form-label" style="margin-bottom:6px;">Type</label>
                <select name="type" class="form-input" style="padding:10px 14px;">
                    <option value="">All Types</option>
                    <option value="work" {{ request('type') === 'work' ? 'selected' : '' }}>Work Experience</option>
                    <option value="education" {{ request('type') === 'education' ? 'selected' : '' }}>Education</option>
                    <option value="certification" {{ request('type') === 'certification' ? 'selected' : '' }}>Certification</option>
                </select>
            </div>
            <div style="flex:1;">
                <label class="form-label" style="margin-bottom:6px;">Status</label>
                <select name="status" class="form-input" style="padding:10px 14px;">
                    <option value="">All</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Only</option>
                    <option value="current" {{ request('status') === 'current' ? 'selected' : '' }}>Current Role</option>
                </select>
            </div>
            <button type="submit" class="btn-primary" style="padding:10px 24px; height:auto;">Filter</button>
            <a href="{{ route('admin.experiences.index') }}" class="btn-secondary" style="padding:10px 24px; height:auto;">Reset</a>
        </form>
    </div>

    {{-- Timeline List --}}
    @php
        $typeBadgeColors = [
            'work' => ['bg' => 'rgba(96,165,250,0.1)', 'border' => 'rgba(96,165,250,0.2)', 'text' => '#60a5fa', 'label' => 'Work'],
            'education' => ['bg' => 'rgba(16,185,129,0.1)', 'border' => 'rgba(16,185,129,0.2)', 'text' => '#10b981', 'label' => 'Education'],
            'certification' => ['bg' => 'rgba(167,139,250,0.1)', 'border' => 'rgba(167,139,250,0.2)', 'text' => '#a78bfa', 'label' => 'Certification'],
        ];
    @endphp

    @forelse($experiences as $exp)
    @php
        $colors = $typeBadgeColors[$exp->type] ?? $typeBadgeColors['work'];
    @endphp
    <div class="glass-card" style="padding:0; margin-bottom:16px; overflow:hidden; transition:all 0.3s ease;"
         onmouseover="this.style.borderColor='rgba(0,242,255,0.15)'; this.style.transform='translateX(4px)'"
         onmouseout="this.style.borderColor='var(--card-border)'; this.style.transform='translateX(0)'">
        <div style="display:flex; align-items:stretch;">
            {{-- Timeline Accent Bar --}}
            <div style="width:4px; background:{{ $colors['text'] }}; flex-shrink:0;"></div>

            <div style="flex:1; padding:24px 28px;">
                <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:16px; flex-wrap:wrap;">
                    <div style="flex:1; min-width:0;">
                        {{-- Badges Row --}}
                        <div style="display:flex; align-items:center; gap:8px; margin-bottom:10px; flex-wrap:wrap;">
                            <span style="background:{{ $colors['bg'] }}; color:{{ $colors['text'] }}; border:1px solid {{ $colors['border'] }}; font-size:9px; font-weight:800; padding:4px 10px; border-radius:8px; text-transform:uppercase; letter-spacing:0.1em;">
                                {{ $colors['label'] }}
                            </span>
                            @if($exp->is_current)
                            <span style="background:rgba(0,242,255,0.1); color:#00f2ff; border:1px solid rgba(0,242,255,0.2); font-size:9px; font-weight:800; padding:4px 10px; border-radius:8px; text-transform:uppercase; letter-spacing:0.1em;">
                                Current
                            </span>
                            @endif
                            @if(!$exp->is_active)
                            <span style="background:rgba(239,68,68,0.1); color:#f87171; border:1px solid rgba(239,68,68,0.2); font-size:9px; font-weight:700; padding:4px 10px; border-radius:8px; text-transform:uppercase; letter-spacing:0.1em;">
                                Inactive
                            </span>
                            @endif
                        </div>

                        {{-- Title & Company --}}
                        <h3 style="font-size:18px; font-weight:700; color:#fff; margin-bottom:4px; letter-spacing:-0.02em;">{{ $exp->title }}</h3>
                        <div style="font-size:14px; color:rgba(255,255,255,0.5); margin-bottom:8px;">
                            {{ $exp->company }}
                            @if($exp->location)
                            <span style="color:rgba(255,255,255,0.25); margin:0 6px;">&#8226;</span>
                            <span style="color:rgba(255,255,255,0.35);">{{ $exp->location }}</span>
                            @endif
                        </div>

                        {{-- Meta Row --}}
                        <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap;">
                            @if($exp->date_range)
                            <span style="font-family:'JetBrains Mono', monospace; font-size:11px; color:rgba(255,255,255,0.35); font-weight:600;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px; display:inline; vertical-align:-1px; margin-right:4px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ $exp->date_range }}
                            </span>
                            @endif
                            @if($exp->duration)
                            <span style="font-size:11px; color:rgba(255,255,255,0.25); font-weight:600;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px; display:inline; vertical-align:-1px; margin-right:4px;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                {{ $exp->duration }}
                            </span>
                            @endif
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div style="display:flex; gap:10px; align-items:center; flex-shrink:0;">
                        <a href="{{ route('admin.experiences.edit', $exp) }}" class="btn-secondary" style="padding:10px; border-radius:12px;" title="Edit Experience">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                        </a>
                        <button type="button" class="btn-danger" style="padding:10px; border-radius:12px; background:rgba(239,68,68,0.08);"
                            onclick="openDeleteModal('{{ route('admin.experiences.destroy', $exp) }}')" title="Delete Experience">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;">
                                <path d="M3 6h18m-2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="glass-card" style="padding:80px 40px; text-align:center; color:rgba(255,255,255,0.2);">
        <div style="font-size:56px; margin-bottom:20px; opacity:0.3;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:56px;height:56px; margin:0 auto; display:block; color:rgba(255,255,255,0.15);">
                <rect x="2" y="7" width="20" height="14" rx="2" ry="2" />
                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
            </svg>
        </div>
        <div style="font-size:18px; font-weight:700; margin-bottom:8px; color:rgba(255,255,255,0.5);">Belum ada pengalaman</div>
        <p style="font-size:14px; margin-bottom:32px; color:rgba(255,255,255,0.3); max-width:400px; margin-left:auto; margin-right:auto;">Mulai tambahkan riwayat pekerjaan, pendidikan, dan sertifikasi untuk membangun timeline karir profesional kamu.</p>
        <a href="{{ route('admin.experiences.create') }}" class="btn-primary">Tambah Experience Sekarang</a>
    </div>
    @endforelse

    {{-- Pagination --}}
    @if($experiences->hasPages())
    <div style="margin-top:2.5rem; display:flex; justify-content:center;">
        {{ $experiences->links() }}
    </div>
    @endif
</div>
@endsection
