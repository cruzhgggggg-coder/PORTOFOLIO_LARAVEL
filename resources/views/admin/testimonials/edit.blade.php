@extends('admin.layout')

@section('title', 'Edit Fun Fact')

@section('content')
<div style="width:100%;">
    <div style="margin-bottom:2.5rem;">
        <a href="{{ route('admin.testimonials.index') }}" style="font-size:12px; color:rgba(255,255,255,0.4); text-decoration:none; display:inline-flex; align-items:center; gap:6px; margin-bottom:16px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;">
                <line x1="19" y1="12" x2="5" y2="12" />
                <polyline points="12 19 5 12 12 5" />
            </svg>
            Back to Fun Facts
        </a>
        <h1 style="font-size:36px; font-weight:800; letter-spacing:-0.05em;">Edit Fun Fact</h1>
    </div>

    <form method="POST" action="{{ route('admin.testimonials.update', $funFact) }}">
        @csrf
        @method('PUT')
        <div style="display:grid; grid-template-columns: 2fr 1fr; gap:24px;">
            {{-- Main Content --}}
            <div class="glass-card" style="padding:32px;">
                <div style="margin-bottom:24px;">
                    <label class="form-label">Emoji</label>
                    <input type="text" name="emoji" class="form-input" value="{{ old('emoji', $funFact->emoji) }}" placeholder="e.g. 🎮 🎸 📚 ☕" maxlength="10" style="font-size:24px; text-align:center; width:120px;">
                    <p style="font-size:11px; color:rgba(255,255,255,0.3); margin-top:6px;">Pick an emoji that represents this fact</p>
                </div>

                <div style="margin-bottom:24px;">
                    <label class="form-label">Title *</label>
                    <input type="text" name="title" class="form-input" value="{{ old('title', $funFact->name) }}" placeholder="e.g. Gamer, Coffee Addict, Night Owl" required>
                </div>

                <div style="margin-bottom:24px;">
                    <label class="form-label">Description *</label>
                    <textarea name="description" class="form-input" rows="4" placeholder="A short description about this personal fact..." required>{{ old('description', $funFact->content) }}</textarea>
                </div>
            </div>

            {{-- Sidebar --}}
            <div style="display:flex; flex-direction:column; gap:24px;">
                <div class="glass-card" style="padding:24px;">
                    <h3 style="font-size:12px; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; color:rgba(255,255,255,0.4); margin-bottom:16px;">Display</h3>
                    <div style="margin-bottom:16px;">
                        <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $funFact->is_active) ? 'checked' : '' }}>
                            <span style="font-size:13px; color:rgba(255,255,255,0.7);">Active (visible on About page)</span>
                        </label>
                    </div>
                    <div>
                        <label class="form-label" style="margin-bottom:6px;">Sort Order</label>
                        <input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', $funFact->sort_order) }}" min="0" style="width:100px;">
                        <p style="font-size:11px; color:rgba(255,255,255,0.3); margin-top:4px;">Lower = shows first</p>
                    </div>
                </div>

                <button type="submit" class="btn-primary" style="width:100%; justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:14px;height:14px;">
                        <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
                        <polyline points="17,21 17,13 7,13 7,21" />
                        <polyline points="7,3 7,8 15,8" />
                    </svg>
                    Update Fun Fact
                </button>
            </div>
        </div>
    </form>

    {{-- Delete Form --}}
    <form method="POST" action="{{ route('admin.testimonials.destroy', $funFact) }}" onsubmit="return confirm('Delete this fun fact permanently?')" style="margin-top:16px; max-width:200px;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-danger" style="width:100%; justify-content:center;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;">
                <polyline points="3,6 5,6 21,6" />
                <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2" />
            </svg>
            Delete Fun Fact
        </button>
    </form>
</div>
@endsection
