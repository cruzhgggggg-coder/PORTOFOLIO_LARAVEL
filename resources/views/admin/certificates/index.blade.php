@extends('admin.layout')

@section('title', 'Certificates')

@section('content')
<div style="max-width:1400px;">
    {{-- Header --}}
    <div style="margin-bottom:2.5rem; display:flex; justify-content:space-between; align-items:end;">
        <div>
            <h1 style="font-size:36px; font-weight:800; letter-spacing:-0.05em; margin-bottom:8px;">Certificates</h1>
            <p style="color:rgba(255,255,255,0.4); font-size:14px;">Manage your certifications and achievements</p>
        </div>
        <a href="{{ route('admin.certificates.create') }}" class="btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:14px;height:14px;">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Add Certificate
        </a>
    </div>

    {{-- Filters --}}
    <div class="glass-card" style="padding:20px 24px; margin-bottom:24px;">
        <form method="GET" action="{{ route('admin.certificates.index') }}" style="display:flex; gap:16px; align-items:end;">
            <div style="flex:1;">
                <label class="form-label" style="margin-bottom:6px;">Status</label>
                <select name="status" class="form-input" style="padding:10px 14px;">
                    <option value="">All</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="featured" {{ request('status') === 'featured' ? 'selected' : '' }}>Featured</option>
                </select>
            </div>
            <button type="submit" class="btn-primary" style="padding:10px 24px; height:auto;">Filter</button>
            <a href="{{ route('admin.certificates.index') }}" class="btn-secondary" style="padding:10px 24px; height:auto;">Reset</a>
        </form>
    </div>

    {{-- Certificates Grid --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(350px, 1fr)); gap:20px;">
        @forelse($certificates as $certificate)
        <div class="glass-card" style="padding:24px; position:relative;">
            {{-- Featured Badge --}}
            @if($certificate->is_featured)
            <div style="position:absolute; top:16px; right:16px; background:rgba(245,158,11,0.1); color:#f59e0b; font-size:10px; font-weight:700; padding:4px 10px; border-radius:10px; text-transform:uppercase;">Featured</div>
            @endif

            {{-- Image Preview --}}
            @if($certificate->image_url)
            <div style="margin-bottom:16px; border-radius:12px; overflow:hidden; aspect-ratio:16/10;">
                <img src="{{ asset('storage/' . $certificate->image_url) }}" alt="{{ $certificate->title }}" style="width:100%; height:100%; object-fit:cover;">
            </div>
            @endif

            {{-- Info --}}
            <div style="font-size:16px; font-weight:700; color:#fff; margin-bottom:4px;">{{ $certificate->title }}</div>
            <div style="font-size:13px; color:rgba(255,255,255,0.5); margin-bottom:4px;">{{ $certificate->issuer }}</div>
            @if($certificate->year)
            <div style="font-size:11px; color:rgba(255,255,255,0.3); margin-bottom:12px;">{{ $certificate->year }}</div>
            @endif

            {{-- Status Badges --}}
            <div style="display:flex; gap:8px; margin-bottom:16px;">
                @if($certificate->is_active)
                <span style="background:rgba(16,185,129,0.1); color:#6ee7b7; font-size:10px; font-weight:700; padding:4px 10px; border-radius:10px; text-transform:uppercase;">Active</span>
                @else
                <span style="background:rgba(239,68,68,0.1); color:#fca5a5; font-size:10px; font-weight:700; padding:4px 10px; border-radius:10px; text-transform:uppercase;">Inactive</span>
                @endif
                @if($certificate->credential_url)
                <span style="background:rgba(59,130,246,0.1); color:#93c5fd; font-size:10px; font-weight:700; padding:4px 10px; border-radius:10px; text-transform:uppercase;">Linked</span>
                @endif
            </div>

            {{-- Actions --}}
            <div style="display:flex; gap:8px; padding-top:16px; border-top:1px solid rgba(255,255,255,0.06);">
                <a href="{{ route('admin.certificates.edit', $certificate) }}" class="btn-secondary" style="flex:1; justify-content:center; font-size:11px; padding:8px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                    Edit
                </a>
                <form method="POST" action="{{ route('admin.certificates.toggle-featured', $certificate) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-secondary" style="font-size:11px; padding:8px 12px;" title="Toggle Featured">
                        <svg viewBox="0 0 24 24" fill="{{ $certificate->is_featured ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.certificates.destroy', $certificate) }}" onsubmit="return confirm('Delete this certificate?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger" style="font-size:11px; padding:8px 12px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;">
                            <path d="M3 6h18m-2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div style="grid-column:1/-1; padding:64px; text-align:center; color:rgba(255,255,255,0.2);">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:64px;height:64px; margin:0 auto 16px; opacity:0.3;">
                <rect x="3" y="3" width="18" height="18" rx="2" />
                <path d="M3 9h18M9 21V9" />
            </svg>
            <div style="font-size:16px; font-weight:700; margin-bottom:8px;">No certificates yet</div>
            <a href="{{ route('admin.certificates.create') }}" class="btn-primary" style="margin-top:16px;">Add Your First Certificate</a>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($certificates->hasPages())
    <div style="margin-top:24px;">
        {{ $certificates->links() }}
    </div>
    @endif
</div>
@endsection
