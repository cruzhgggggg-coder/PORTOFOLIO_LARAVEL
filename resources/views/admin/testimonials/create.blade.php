@extends('admin.layout')

@section('title', 'Add Fun Fact')

@section('content')
<div style="width:100%;">
    <div style="margin-bottom:2.5rem;">
        <a href="{{ route('admin.testimonials.index') }}" style="font-size:12px; color:rgba(255,255,255,0.4); text-decoration:none; display:inline-flex; align-items:center; gap:6px; margin-bottom:16px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><line x1="19" y1="12" x2="5" y2="12" /><polyline points="12 19 5 12 12 5" /></svg>
            Back to Fun Facts
        </a>
        <h1 style="font-size:36px; font-weight:800; letter-spacing:-0.05em;">Add Fun Fact</h1>
    </div>

    <form method="POST" action="{{ route('admin.testimonials.store') }}">
        @csrf
        <div style="display:grid; grid-template-columns: 2fr 1fr; gap:24px;">
            {{-- Main Content --}}
            <div class="glass-card" style="padding:32px;">
                <div style="margin-bottom:24px;">
                    <label class="form-label">Emoji</label>
                    <input type="text" name="emoji" class="form-input" value="{{ old('emoji') }}" placeholder="e.g. 🎮 🎸 📚 ☕" maxlength="10" style="font-size:24px; text-align:center; width:120px;">
                    <p style="font-size:11px; color:rgba(255,255,255,0.3); margin-top:6px;">Pick an emoji that represents this fact</p>
                </div>

                <div style="margin-bottom:24px;">
                    <label class="form-label">Title *</label>
                    <input type="text" name="title" class="form-input" value="{{ old('title') }}" placeholder="e.g. Gamer, Coffee Addict, Night Owl" required>
                </div>

                <div style="margin-bottom:24px;">
                    <label class="form-label">Description *</label>
                    <textarea name="description" class="form-input" rows="4" placeholder="A short description about this personal fact..." required>{{ old('description') }}</textarea>
                </div>
            </div>

            {{-- Sidebar --}}
            <div style="display:flex; flex-direction:column; gap:24px;">
                <div class="glass-card" style="padding:24px;">
                    <h3 style="font-size:12px; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; color:rgba(255,255,255,0.4); margin-bottom:16px;">Display</h3>
                    <div style="margin-bottom:16px;">
                        <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <span style="font-size:13px; color:rgba(255,255,255,0.7);">Active (visible on About page)</span>
                        </label>
                    </div>
                    <div>
                        <label class="form-label" style="margin-bottom:6px;">Sort Order</label>
                        <input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', 0) }}" min="0" style="width:100px;">
                        <p style="font-size:11px; color:rgba(255,255,255,0.3); margin-top:4px;">Lower = shows first</p>
                    </div>
                </div>

                <button type="submit" class="btn-primary" style="width:100%; justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:14px;height:14px;">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Create Fun Fact
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
