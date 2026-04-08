@extends('admin.layout')

@section('title', 'Edit Testimonial')

@section('content')
<div style="max-width:1000px;">
    <div style="margin-bottom:2.5rem;">
        <a href="{{ route('admin.testimonials.index') }}" style="font-size:12px; color:rgba(255,255,255,0.4); text-decoration:none; display:inline-flex; align-items:center; gap:6px; margin-bottom:16px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;">
                <line x1="19" y1="12" x2="5" y2="12" />
                <polyline points="12 19 5 12 12 5" />
            </svg>
            Back to Testimonials
        </a>
        <h1 style="font-size:36px; font-weight:800; letter-spacing:-0.05em;">Edit Testimonial</h1>
    </div>

    <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div style="display:grid; grid-template-columns: 2fr 1fr; gap:24px;">
            {{-- Main Content --}}
            <div class="glass-card" style="padding:32px;">
                <div style="margin-bottom:24px;">
                    <label class="form-label">Client Name *</label>
                    <input type="text" name="name" class="form-input" value="{{ old('name', $testimonial->name) }}" required>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px; margin-bottom:24px;">
                    <div>
                        <label class="form-label">Job Title</label>
                        <input type="text" name="title" class="form-input" value="{{ old('title', $testimonial->title) }}" placeholder="e.g. CEO">
                    </div>
                    <div>
                        <label class="form-label">Company</label>
                        <input type="text" name="company" class="form-input" value="{{ old('company', $testimonial->company) }}" placeholder="e.g. Google">
                    </div>
                </div>

                <div style="margin-bottom:24px;">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" value="{{ old('email', $testimonial->email) }}">
                </div>

                <div style="margin-bottom:24px;">
                    <label class="form-label">Testimonial Content *</label>
                    <textarea name="content" class="form-input" rows="6" required>{{ old('content', $testimonial->content) }}</textarea>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
                    <div>
                        <label class="form-label">Project Name</label>
                        <input type="text" name="project_name" class="form-input" value="{{ old('project_name', $testimonial->project_name) }}">
                    </div>
                    <div>
                        <label class="form-label">Project URL</label>
                        <input type="url" name="project_url" class="form-input" value="{{ old('project_url', $testimonial->project_url) }}">
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div style="display:flex; flex-direction:column; gap:24px;">
                <div class="glass-card" style="padding:24px;">
                    <h3 style="font-size:12px; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; color:rgba(255,255,255,0.4); margin-bottom:16px;">Rating</h3>
                    <select name="rating" class="form-input">
                        <option value="5" {{ old('rating', $testimonial->rating) == 5 ? 'selected' : '' }}>★★★★★ (5 Stars)</option>
                        <option value="4" {{ old('rating', $testimonial->rating) == 4 ? 'selected' : '' }}>★★★★☆ (4 Stars)</option>
                        <option value="3" {{ old('rating', $testimonial->rating) == 3 ? 'selected' : '' }}>★★★☆☆ (3 Stars)</option>
                        <option value="2" {{ old('rating', $testimonial->rating) == 2 ? 'selected' : '' }}>★★☆☆☆ (2 Stars)</option>
                        <option value="1" {{ old('rating', $testimonial->rating) == 1 ? 'selected' : '' }}>★☆☆☆☆ (1 Star)</option>
                    </select>
                </div>

                <div class="glass-card" style="padding:24px;">
                    <h3 style="font-size:12px; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; color:rgba(255,255,255,0.4); margin-bottom:16px;">Avatar</h3>
                    @if($testimonial->avatar_url)
                    <div style="margin-bottom:12px;">
                        <img src="{{ asset('storage/' . $testimonial->avatar_url) }}" alt="Current Avatar" style="width:64px; height:64px; border-radius:50%; border:2px solid #00f2ff; object-fit:cover;">
                        <p style="font-size:11px; color:rgba(255,255,255,0.4); margin-top:6px;">Current avatar</p>
                    </div>
                    @endif
                    <input type="file" name="avatar_url" class="form-input" accept="image/*">
                </div>

                <div class="glass-card" style="padding:24px;">
                    <h3 style="font-size:12px; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; color:rgba(255,255,255,0.4); margin-bottom:16px;">Status</h3>
                    <div style="margin-bottom:12px;">
                        <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                            <input type="checkbox" name="is_approved" value="1" {{ old('is_approved', $testimonial->is_approved) ? 'checked' : '' }}>
                            <span style="font-size:13px; color:rgba(255,255,255,0.7);">Approved</span>
                        </label>
                    </div>
                    <div>
                        <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $testimonial->is_featured) ? 'checked' : '' }}>
                            <span style="font-size:13px; color:rgba(255,255,255,0.7);">Featured</span>
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-primary" style="width:100%; justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:14px;height:14px;">
                        <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
                        <polyline points="17,21 17,13 7,13 7,21" />
                        <polyline points="7,3 7,8 15,8" />
                    </svg>
                    Update Testimonial
                </button>
            </div>
        </div>
    </form>

    {{-- Delete Form (separate from update form) --}}
    <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" onsubmit="return confirm('Delete permanently?')" style="margin-top:16px; max-width:200px;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-danger" style="width:100%; justify-content:center;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;">
                <polyline points="3,6 5,6 21,6" />
                <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2" />
            </svg>
            Delete Testimonial
        </button>
    </form>
</div>
@endsection