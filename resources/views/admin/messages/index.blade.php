@extends('admin.layout')

@section('title', 'Messages')

@section('content')
<div style="max-width:1400px;">
    {{-- Header --}}
    <div style="margin-bottom:2.5rem; display:flex; justify-content:space-between; align-items:end;">
        <div>
            <h1 style="font-size:36px; font-weight:800; letter-spacing:-0.05em; margin-bottom:8px;">Inbox</h1>
            <p style="color:rgba(255,255,255,0.4); font-size:14px;">Manage contact form submissions and inquiries</p>
        </div>
        <div style="display:flex; gap:12px;">
            @if($messages->where('is_read', false)->count() > 0)
            <form method="POST" action="{{ route('admin.messages.bulk-action') }}">
                @csrf
                <input type="hidden" name="action" value="mark_read">
                @foreach($messages->where('is_read', false) as $msg)
                <input type="hidden" name="message_ids[]" value="{{ $msg->id }}">
                @endforeach
                <button type="submit" class="btn-secondary" style="font-size:11px;">
                    Mark All Read
                </button>
            </form>
            @endif
        </div>
    </div>

    {{-- Filters --}}
    <div class="glass-card" style="padding:20px 24px; margin-bottom:24px;">
        <form method="GET" action="{{ route('admin.messages.index') }}" style="display:flex; gap:16px; align-items:end;">
            <div style="flex:1;">
                <label class="form-label" style="margin-bottom:6px;">Status</label>
                <select name="status" class="form-input" style="padding:10px 14px;">
                    <option value="">All Messages</option>
                    <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread Only</option>
                    <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read Only</option>
                </select>
            </div>
            <div style="flex:2;">
                <label class="form-label" style="margin-bottom:6px;">Search</label>
                <input type="text" name="search" class="form-input" placeholder="Search name, email, subject, or message..." value="{{ request('search') }}" style="padding:10px 14px;">
            </div>
            <button type="submit" class="btn-primary" style="padding:10px 24px; height:auto;">Filter</button>
            <a href="{{ route('admin.messages.index') }}" class="btn-secondary" style="padding:10px 24px; height:auto;">Reset</a>
        </form>
    </div>

    {{-- Messages List --}}
    <div class="glass-card" style="padding:0; overflow:hidden;">
        @forelse($messages as $message)
        <a href="{{ route('admin.messages.show', $message) }}" style="display:block; padding:20px 24px; border-bottom:1px solid rgba(255,255,255,0.03); text-decoration:none; transition:all 0.2s; {{ !$message->is_read ? 'background:rgba(0,242,255,0.02);' : '' }}" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='{{ !$message->is_read ? 'rgba(0,242,255,0.02)' : 'transparent' }}'">
            <div style="display:flex; justify-content:space-between; align-items:start; gap:16px;">
                <div style="flex:1; min-width:0;">
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
                        @if(!$message->is_read)
                        <div style="width:8px; height:8px; background:var(--brand); border-radius:50%; flex-shrink:0;"></div>
                        @endif
                        <div style="font-size:15px; font-weight:700; color:{{ $message->is_read ? '#fff' : 'var(--brand)' }};">{{ $message->name }}</div>
                        <div style="font-size:11px; color:rgba(255,255,255,0.3);">({{ $message->email }})</div>
                        @if($message->replied_at)
                        <span style="background:rgba(16,185,129,0.1); color:#6ee7b7; font-size:9px; font-weight:700; padding:3px 8px; border-radius:10px; text-transform:uppercase; letter-spacing:0.05em;">Replied</span>
                        @endif
                    </div>
                    @if($message->subject)
                    <div style="font-size:13px; font-weight:600; color:rgba(255,255,255,0.6); margin-bottom:6px;">{{ $message->subject }}</div>
                    @endif
                    <div style="font-size:12px; color:rgba(255,255,255,0.4); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ Str::limit($message->message, 120) }}</div>
                </div>
                <div style="text-align:right; flex-shrink:0;">
                    <div style="font-size:10px; color:rgba(255,255,255,0.3); margin-bottom:8px;">{{ $message->created_at->format('M d, Y') }}</div>
                    <div style="font-size:10px; color:rgba(255,255,255,0.3);">{{ $message->created_at->diffForHumans() }}</div>
                </div>
            </div>
        </a>
        @empty
        <div style="padding:64px 24px; text-align:center; color:rgba(255,255,255,0.2);">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:64px;height:64px; margin:0 auto 16px; opacity:0.3;">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                <polyline points="22,6 12,13 2,6" />
            </svg>
            <div style="font-size:16px; font-weight:700; margin-bottom:8px;">No messages found</div>
            <div style="font-size:13px;">Messages from your contact form will appear here</div>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($messages->hasPages())
    <div style="margin-top:24px;">
        {{ $messages->links() }}
    </div>
    @endif
</div>
@endsection
