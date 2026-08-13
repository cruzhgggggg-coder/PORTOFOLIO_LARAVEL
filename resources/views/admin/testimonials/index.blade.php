@extends('admin.layout')

@section('title', 'Fun Facts')

@section('content')
<div style="width:100%;">
    {{-- Header --}}
    <div style="margin-bottom:2.5rem; display:flex; justify-content:space-between; align-items:end;">
        <div>
            <h1 style="font-size:36px; font-weight:800; letter-spacing:-0.05em; margin-bottom:8px;">Fun Facts</h1>
            <p style="color:rgba(255,255,255,0.4); font-size:14px;">Manage "Beyond the Code" personal facts shown on your About page</p>
        </div>
        <a href="{{ route('admin.testimonials.create') }}" class="btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:14px;height:14px;">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Add Fun Fact
        </a>
    </div>

    {{-- Fun Facts Grid --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(300px, 1fr)); gap:20px;">
        @forelse($funFacts as $fact)
        <div class="glass-card" style="padding:24px; position:relative;">
            {{-- Emoji --}}
            <div style="font-size:40px; margin-bottom:16px;">{{ $fact->emoji ?? '✨' }}</div>

            {{-- Title --}}
            <div style="font-size:17px; font-weight:700; color:#fff; margin-bottom:8px;">{{ $fact->name }}</div>

            {{-- Description --}}
            <div style="font-size:13px; line-height:1.7; color:rgba(255,255,255,0.6); margin-bottom:16px;">
                {{ Str::limit($fact->content, 120) }}
            </div>

            {{-- Status --}}
            <div style="display:flex; gap:8px; margin-bottom:16px;">
                @if($fact->is_active)
                <span style="background:rgba(16,185,129,0.1); color:#6ee7b7; font-size:10px; font-weight:700; padding:4px 10px; border-radius:10px; text-transform:uppercase;">Active</span>
                @else
                <span style="background:rgba(255,255,255,0.05); color:rgba(255,255,255,0.4); font-size:10px; font-weight:700; padding:4px 10px; border-radius:10px; text-transform:uppercase;">Inactive</span>
                @endif
                <span style="background:rgba(255,255,255,0.03); color:rgba(255,255,255,0.3); font-size:10px; font-weight:600; padding:4px 10px; border-radius:10px;">
                    Order: {{ $fact->sort_order }}
                </span>
            </div>

            {{-- Actions --}}
            <div style="display:flex; gap:8px; padding-top:16px; border-top:1px solid rgba(255,255,255,0.06);">
                <a href="{{ route('admin.testimonials.edit', $fact) }}" class="btn-secondary" style="flex:1; justify-content:center; font-size:11px; padding:8px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                    Edit
                </a>
                <form method="POST" action="{{ route('admin.testimonials.toggle-active', $fact) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-secondary" style="font-size:11px; padding:8px 12px;" title="{{ $fact->is_active ? 'Deactivate' : 'Activate' }}">
                        @if($fact->is_active)
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                        @else
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" />
                            <line x1="1" y1="1" x2="23" y2="23" />
                        </svg>
                        @endif
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.testimonials.destroy', $fact) }}" onsubmit="return confirm('Delete this fun fact?')">
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
            <div style="font-size:64px; margin-bottom:16px;">🌟</div>
            <div style="font-size:16px; font-weight:700; margin-bottom:8px;">No fun facts yet</div>
            <p style="font-size:13px; color:rgba(255,255,255,0.3); margin-bottom:20px;">Add personal facts to show on your About page under "Beyond the Code"</p>
            <a href="{{ route('admin.testimonials.create') }}" class="btn-primary">Add Your First Fun Fact</a>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($funFacts->hasPages())
    <div style="margin-top:24px;">
        {{ $funFacts->links() }}
    </div>
    @endif
</div>
@endsection
