@extends('admin.layout')

@section('title', 'Testimonials')

@section('content')
<div style="max-width:1400px;">
    {{-- Header --}}
    <div style="margin-bottom:2.5rem; display:flex; justify-content:space-between; align-items:end;">
        <div>
            <h1 style="font-size:36px; font-weight:800; letter-spacing:-0.05em; margin-bottom:8px;">Testimonials</h1>
            <p style="color:rgba(255,255,255,0.4); font-size:14px;">Manage client reviews and testimonials</p>
        </div>
        <a href="{{ route('admin.testimonials.create') }}" class="btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:14px;height:14px;">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Add Testimonial
        </a>
    </div>

    {{-- Filters --}}
    <div class="glass-card" style="padding:20px 24px; margin-bottom:24px;">
        <form method="GET" action="{{ route('admin.testimonials.index') }}" style="display:flex; gap:16px; align-items:end;">
            <div style="flex:1;">
                <label class="form-label" style="margin-bottom:6px;">Status</label>
                <select name="status" class="form-input" style="padding:10px 14px;">
                    <option value="">All</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="featured" {{ request('status') === 'featured' ? 'selected' : '' }}>Featured</option>
                </select>
            </div>
            <button type="submit" class="btn-primary" style="padding:10px 24px; height:auto;">Filter</button>
            <a href="{{ route('admin.testimonials.index') }}" class="btn-secondary" style="padding:10px 24px; height:auto;">Reset</a>
        </form>
    </div>

    {{-- Testimonials Grid --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(350px, 1fr)); gap:20px;">
        @forelse($testimonials as $testimonial)
        <div class="glass-card" style="padding:24px; position:relative;">
            {{-- Featured Badge --}}
            @if($testimonial->is_featured)
            <div style="position:absolute; top:16px; right:16px; background:rgba(245,158,11,0.1); color:#f59e0b; font-size:16px;">★</div>
            @endif

            {{-- Header --}}
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:16px;">
                @if($testimonial->avatar_url)
                <img src="{{ asset('storage/' . $testimonial->avatar_url) }}" alt="" style="width:48px; height:48px; border-radius:50%; object-fit:cover;">
                @else
                <div style="width:48px; height:48px; background:linear-gradient(135deg, #a78bfa, #60a5fa); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:18px; font-weight:800; color:#fff;">
                    {{ substr($testimonial->name, 0, 1) }}
                </div>
                @endif
                <div>
                    <div style="font-size:15px; font-weight:700; color:#fff;">{{ $testimonial->name }}</div>
                    <div style="font-size:12px; color:rgba(255,255,255,0.4);">
                        {{ $testimonial->title }}@if($testimonial->company) at {{ $testimonial->company }}@endif
                    </div>
                </div>
            </div>

            {{-- Rating --}}
            <div style="margin-bottom:12px; color:#f59e0b; font-size:14px; letter-spacing:2px;">
                {{ $testimonial->stars }}
            </div>

            {{-- Content --}}
            <div style="font-size:13px; line-height:1.7; color:rgba(255,255,255,0.6); margin-bottom:16px; max-height:80px; overflow:hidden;">
                {{ Str::limit($testimonial->content, 150) }}
            </div>

            {{-- Project --}}
            @if($testimonial->project_name)
            <div style="font-size:11px; color:rgba(255,255,255,0.3); margin-bottom:16px; padding:8px 12px; background:rgba(255,255,255,0.02); border-radius:6px;">
                Project: {{ $testimonial->project_name }}
            </div>
            @endif

            {{-- Status Badges --}}
            <div style="display:flex; gap:8px; margin-bottom:16px;">
                @if($testimonial->is_approved)
                <span style="background:rgba(16,185,129,0.1); color:#6ee7b7; font-size:10px; font-weight:700; padding:4px 10px; border-radius:10px; text-transform:uppercase;">Approved</span>
                @else
                <span style="background:rgba(245,158,11,0.1); color:#fbbf24; font-size:10px; font-weight:700; padding:4px 10px; border-radius:10px; text-transform:uppercase;">Pending</span>
                @endif
            </div>

            {{-- Actions --}}
            <div style="display:flex; gap:8px; padding-top:16px; border-top:1px solid rgba(255,255,255,0.06);">
                <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn-secondary" style="flex:1; justify-content:center; font-size:11px; padding:8px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                    Edit
                </a>
                @if(!$testimonial->is_approved)
                <form method="POST" action="{{ route('admin.testimonials.approve', $testimonial) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-secondary" style="font-size:11px; padding:8px 12px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                    </button>
                </form>
                @endif
                <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" onsubmit="return confirm('Delete this testimonial?')">
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
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
            </svg>
            <div style="font-size:16px; font-weight:700; margin-bottom:8px;">No testimonials yet</div>
            <a href="{{ route('admin.testimonials.create') }}" class="btn-primary" style="margin-top:16px;">Add Your First Testimonial</a>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($testimonials->hasPages())
    <div style="margin-top:24px;">
        {{ $testimonials->links() }}
    </div>
    @endif
</div>
@endsection
