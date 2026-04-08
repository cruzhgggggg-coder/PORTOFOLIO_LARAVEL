@extends('admin.layout')

@section('title', 'Create Testimonial')

@section('content')
<div style="max-width:1000px;">
    <div style="margin-bottom:2.5rem;">
        <a href="{{ route('admin.testimonials.index') }}" style="font-size:12px; color:rgba(255,255,255,0.4); text-decoration:none; display:inline-flex; align-items:center; gap:6px; margin-bottom:16px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><line x1="19" y1="12" x2="5" y2="12" /><polyline points="12 19 5 12 12 5" /></svg>
            Back to Testimonials
        </a>
        <h1 style="font-size:36px; font-weight:800; letter-spacing:-0.05em;">Add Testimonial</h1>
    </div>

    <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">
        @csrf
        <div style="display:grid; grid-template-columns: 2fr 1fr; gap:24px;">
            {{-- Main Content --}}
            <div class="glass-card" style="padding:32px;">
                <div style="margin-bottom:24px;">
                    <label class="form-label">Client Name *</label>
                    <input type="text" name="name" class="form-input" value="{{ old('name') }}" required>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px; margin-bottom:24px;">
                    <div>
                        <label class="form-label">Job Title</label>
                        <input type="text" name="title" class="form-input" value="{{ old('title') }}" placeholder="e.g. CEO">
                    </div>
                    <div>
                        <label class="form-label">Company</label>
                        <input type="text" name="company" class="form-input" value="{{ old('company') }}" placeholder="e.g. Google">
                    </div>
                </div>

                <div style="margin-bottom:24px;">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" value="{{ old('email') }}">
                </div>

                <div style="margin-bottom:24px;">
                    <label class="form-label">Testimonial Content *</label>
                    <textarea name="content" class="form-input" rows="6" required>{{ old('content') }}</textarea>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
                    <div>
                        <label class="form-label">Project Name</label>
                        <input type="text" name="project_name" class="form-input" value="{{ old('project_name') }}">
                    </div>
                    <div>
                        <label class="form-label">Project URL</label>
                        <input type="url" name="project_url" class="form-input" value="{{ old('project_url') }}">
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div style="display:flex; flex-direction:column; gap:24px;">
                <div class="glass-card" style="padding:24px;">
                    <h3 style="font-size:12px; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; color:rgba(255,255,255,0.4); margin-bottom:16px;">Rating</h3>
                    <select name="rating" class="form-input">
                        <option value="5" {{ old('rating', 5) == 5 ? 'selected' : '' }}>★★★★★ (5 Stars)</option>
                        <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>★★★★☆ (4 Stars)</option>
                        <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>★★★☆☆ (3 Stars)</option>
                        <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>★★☆☆☆ (2 Stars)</option>
                        <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>★☆☆☆☆ (1 Star)</option>
                    </select>
                </div>

                <div class="glass-card" style="padding:24px;">
                    <h3 style="font-size:12px; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; color:rgba(255,255,255,0.4); margin-bottom:16px;">Avatar</h3>
                    <input type="file" name="avatar_url" class="form-input" accept="image/*">
                </div>

                <div class="glass-card" style="padding:24px;">
                    <h3 style="font-size:12px; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; color:rgba(255,255,255,0.4); margin-bottom:16px;">Status</h3>
                    <div style="margin-bottom:12px;">
                        <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                            <input type="checkbox" name="is_approved" value="1" {{ old('is_approved', true) ? 'checked' : '' }}>
                            <span style="font-size:13px; color:rgba(255,255,255,0.7);">Approved</span>
                        </label>
                    </div>
                    <div>
                        <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <span style="font-size:13px; color:rgba(255,255,255,0.7);">Featured</span>
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-primary" style="width:100%; justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:14px;height:14px;">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Create Testimonial
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
