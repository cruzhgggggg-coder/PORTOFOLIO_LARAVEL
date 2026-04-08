@extends('admin.layout')

@section('title', 'Edit Skill')

@section('content')
<div style="max-width:800px;">
    <div style="margin-bottom:2.5rem;">
        <a href="{{ route('admin.skills.index') }}" style="font-size:12px; color:rgba(255,255,255,0.4); text-decoration:none; display:inline-flex; align-items:center; gap:6px; margin-bottom:16px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><line x1="19" y1="12" x2="5" y2="12" /><polyline points="12 19 5 12 12 5" /></svg>
            Back to Skills
        </a>
        <h1 style="font-size:36px; font-weight:800; letter-spacing:-0.05em;">Edit Skill: {{ $skill->name }}</h1>
    </div>

    <form method="POST" action="{{ route('admin.skills.update', $skill) }}">
        @csrf
        @method('PUT')
        <div class="glass-card" style="padding:32px;">
            <div style="margin-bottom:24px;">
                <label class="form-label">Skill Name *</label>
                <input type="text" name="name" class="form-input" value="{{ old('name', $skill->name) }}" required>
            </div>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px; margin-bottom:24px;">
                <div>
                    <label class="form-label">Category *</label>
                    <select name="category" class="form-input" required>
                        <option value="frontend" {{ old('category', $skill->category) === 'frontend' ? 'selected' : '' }}>Frontend</option>
                        <option value="backend" {{ old('category', $skill->category) === 'backend' ? 'selected' : '' }}>Backend</option>
                        <option value="tools" {{ old('category', $skill->category) === 'tools' ? 'selected' : '' }}>Tools</option>
                        <option value="soft" {{ old('category', $skill->category) === 'soft' ? 'selected' : '' }}>Soft Skills</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Icon/Emoji</label>
                    <input type="text" name="icon" class="form-input" value="{{ old('icon', $skill->icon) }}" maxlength="10">
                </div>
            </div>

            <div style="margin-bottom:24px;">
                <label class="form-label">Proficiency Level: <span id="profValue" style="color:var(--brand);">{{ old('proficiency', $skill->proficiency) }}%</span></label>
                <input type="range" name="proficiency" id="profRange" min="0" max="100" value="{{ old('proficiency', $skill->proficiency) }}" style="width:100%;" oninput="document.getElementById('profValue').textContent = this.value + '%'">
            </div>

            <div style="margin-bottom:24px;">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-input" rows="3">{{ old('description', $skill->description) }}</textarea>
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $skill->is_active) ? 'checked' : '' }}>
                    <span style="font-size:13px; color:rgba(255,255,255,0.7);">Active (show on portfolio)</span>
                </label>
            </div>

            <div style="display:flex; gap:12px;">
                <button type="submit" class="btn-primary" style="flex:1; justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" /><polyline points="17 21 17 13 7 13 7 21" /><polyline points="7 3 7 8 15 8" /></svg>
                    Update Skill
                </button>
            </div>
        </div>
    </form>

    {{-- Delete --}}
    <div class="glass-card" style="padding:24px; margin-top:24px; background:rgba(239,68,68,0.05); border-color:rgba(239,68,68,0.2);">
        <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}" onsubmit="return confirm('Delete this skill permanently?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger" style="width:100%; justify-content:center;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><path d="M3 6h18m-2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" /></svg>
                Delete Skill
            </button>
        </form>
    </div>
</div>
@endsection
