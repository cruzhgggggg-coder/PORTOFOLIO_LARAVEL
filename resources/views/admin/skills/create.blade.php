@extends('admin.layout')

@section('title', 'Add Skill')

@section('content')
<div style="max-width:800px;">
    <div style="margin-bottom:2.5rem;">
        <a href="{{ route('admin.skills.index') }}" style="font-size:12px; color:rgba(255,255,255,0.4); text-decoration:none; display:inline-flex; align-items:center; gap:6px; margin-bottom:16px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><line x1="19" y1="12" x2="5" y2="12" /><polyline points="12 19 5 12 12 5" /></svg>
            Back to Skills
        </a>
        <h1 style="font-size:36px; font-weight:800; letter-spacing:-0.05em;">Add New Skill</h1>
    </div>

    <form method="POST" action="{{ route('admin.skills.store') }}">
        @csrf
        <div class="glass-card" style="padding:32px;">
            <div style="margin-bottom:24px;">
                <label class="form-label">Skill Name *</label>
                <input type="text" name="name" class="form-input" value="{{ old('name') }}" placeholder="e.g. React.js" required>
            </div>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px; margin-bottom:24px;">
                <div>
                    <label class="form-label">Category *</label>
                    <select name="category" class="form-input" required>
                        <option value="">Select category</option>
                        <option value="frontend" {{ old('category') === 'frontend' ? 'selected' : '' }}>Frontend</option>
                        <option value="backend" {{ old('category') === 'backend' ? 'selected' : '' }}>Backend</option>
                        <option value="tools" {{ old('category') === 'tools' ? 'selected' : '' }}>Tools</option>
                        <option value="soft" {{ old('category') === 'soft' ? 'selected' : '' }}>Soft Skills</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Icon/Emoji</label>
                    <input type="text" name="icon" class="form-input" value="{{ old('icon') }}" placeholder="e.g. ⚛️" maxlength="10">
                </div>
            </div>

            <div style="margin-bottom:24px;">
                <label class="form-label">Proficiency Level: <span id="profValue" style="color:var(--brand);">{{ old('proficiency', 75) }}%</span></label>
                <input type="range" name="proficiency" id="profRange" min="0" max="100" value="{{ old('proficiency', 75) }}" style="width:100%;" oninput="document.getElementById('profValue').textContent = this.value + '%'">
                <div style="display:flex; justify-content:space-between; font-size:10px; color:rgba(255,255,255,0.3); margin-top:4px;">
                    <span>0%</span>
                    <span>50%</span>
                    <span>100%</span>
                </div>
            </div>

            <div style="margin-bottom:24px;">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-input" rows="3" placeholder="Brief description of your experience...">{{ old('description') }}</textarea>
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <span style="font-size:13px; color:rgba(255,255,255,0.7);">Active (show on portfolio)</span>
                </label>
            </div>

            <button type="submit" class="btn-primary" style="width:100%; justify-content:center;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:14px;height:14px;">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                Add Skill
            </button>
        </div>
    </form>
</div>
@endsection
