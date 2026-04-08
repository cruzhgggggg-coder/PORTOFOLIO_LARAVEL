@extends('admin.layout')

@section('title', 'Message Details')

@section('content')
<div style="max-width:1000px;">
    {{-- Header --}}
    <div style="margin-bottom:2.5rem;">
        <a href="{{ route('admin.messages.index') }}" style="font-size:12px; color:rgba(255,255,255,0.4); text-decoration:none; display:inline-flex; align-items:center; gap:6px; margin-bottom:16px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;">
                <line x1="19" y1="12" x2="5" y2="12" />
                <polyline points="12 19 5 12 12 5" />
            </svg>
            Back to Inbox
        </a>
        <h1 style="font-size:36px; font-weight:800; letter-spacing:-0.05em; margin-bottom:8px;">Message Details</h1>
    </div>

    {{-- Message Card --}}
    <div class="glass-card" style="padding:32px; margin-bottom:24px;">
        {{-- Sender Info --}}
        <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:24px; padding-bottom:24px; border-bottom:1px solid rgba(255,255,255,0.06);">
            <div>
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
                    <div style="width:48px; height:48px; background:linear-gradient(135deg, var(--brand), #7000ff); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; font-weight:800; color:#fff;">
                        {{ substr($message->name, 0, 1) }}
                    </div>
                    <div>
                        <div style="font-size:18px; font-weight:700; color:#fff;">{{ $message->name }}</div>
                        <div style="font-size:13px; color:rgba(255,255,255,0.4);">{{ $message->email }}</div>
                    </div>
                </div>
            </div>
            <div style="text-align:right;">
                <div style="font-size:12px; color:rgba(255,255,255,0.3); margin-bottom:4px;">{{ $message->created_at->format('F d, Y \a\t g:i A') }}</div>
                <div style="font-size:11px; color:rgba(255,255,255,0.3);">{{ $message->created_at->diffForHumans() }}</div>
            </div>
        </div>

        {{-- Subject --}}
        @if($message->subject)
        <div style="margin-bottom:24px;">
            <div style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:rgba(255,255,255,0.3); margin-bottom:8px;">Subject</div>
            <div style="font-size:16px; font-weight:600; color:#fff;">{{ $message->subject }}</div>
        </div>
        @endif

        {{-- Message --}}
        <div style="margin-bottom:32px;">
            <div style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:rgba(255,255,255,0.3); margin-bottom:12px;">Message</div>
            <div style="font-size:14px; line-height:1.8; color:rgba(255,255,255,0.7); white-space:pre-wrap;">{{ $message->message }}</div>
        </div>

        {{-- Reply --}}
        @if($message->reply)
        <div style="margin-bottom:32px; padding:20px; background:rgba(16,185,129,0.05); border-left:3px solid #10b981; border-radius:8px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                <div style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:#6ee7b7;">Your Reply</div>
                @if($message->replied_at)
                <div style="font-size:10px; color:rgba(255,255,255,0.3);">{{ $message->replied_at->diffForHumans() }}</div>
                @endif
            </div>
            <div style="font-size:14px; line-height:1.8; color:rgba(255,255,255,0.7); white-space:pre-wrap;">{{ $message->reply }}</div>
        </div>
        @endif

        {{-- Actions --}}
        <div style="display:flex; gap:12px; flex-wrap:wrap;">
            @if($message->is_read)
            <form method="POST" action="{{ route('admin.messages.mark-unread', $message) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn-secondary">Mark as Unread</button>
            </form>
            @else
            <form method="POST" action="{{ route('admin.messages.mark-read', $message) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn-secondary">Mark as Read</button>
            </form>
            @endif

            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Are you sure you want to delete this message?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">Delete</button>
            </form>
        </div>
    </div>

    {{-- Reply Form --}}
    <div class="glass-card" style="padding:32px;">
        <h2 style="font-size:18px; font-weight:700; margin-bottom:20px;">Reply to Message</h2>
        <form method="POST" action="{{ route('admin.messages.reply', $message) }}">
            @csrf
            <div style="margin-bottom:20px;">
                <label class="form-label">Reply</label>
                <textarea name="reply" class="form-input" rows="8" placeholder="Type your reply here...">{{ old('reply', $message->reply) }}</textarea>
            </div>
            <div style="display:flex; gap:12px;">
                <button type="submit" class="btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;">
                        <line x1="22" y1="2" x2="11" y2="13" />
                        <polygon points="22 2 15 22 11 13 2 9 22 2" />
                    </svg>
                    Send Reply
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
