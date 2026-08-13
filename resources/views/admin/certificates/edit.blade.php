@extends('admin.layout')

@section('title', 'Edit Certificate')

@section('content')
<div style="width:100%;">
    <div style="margin-bottom:2.5rem;">
        <a href="{{ route('admin.certificates.index') }}" style="font-size:12px; color:rgba(255,255,255,0.4); text-decoration:none; display:inline-flex; align-items:center; gap:6px; margin-bottom:16px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;">
                <line x1="19" y1="12" x2="5" y2="12" />
                <polyline points="12 19 5 12 12 5" />
            </svg>
            Back to Certificates
        </a>
        <h1 style="font-size:36px; font-weight:800; letter-spacing:-0.05em;">Edit Certificate</h1>
    </div>

    @if($errors->any())
    <div style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); border-radius:12px; padding:16px 20px; margin-bottom:24px;">
        <div style="font-size:13px; font-weight:700; color:#fca5a5; margin-bottom:8px;">Please fix the following errors:</div>
        <ul style="margin:0; padding-left:20px; font-size:13px; color:rgba(255,255,255,0.6);">
            @foreach($errors->all() as $error)
            <li style="margin-bottom:4px;">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.certificates.update', $certificate) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div style="display:grid; grid-template-columns: 2fr 1fr; gap:24px;">
            {{-- Main Content --}}
            <div class="glass-card" style="padding:32px;">
                <div style="margin-bottom:24px;">
                    <label class="form-label">Certificate Title *</label>
                    <input type="text" name="title" class="form-input" value="{{ old('title', $certificate->title) }}" required>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px; margin-bottom:24px;">
                    <div>
                        <label class="form-label">Issuer *</label>
                        <input type="text" name="issuer" class="form-input" value="{{ old('issuer', $certificate->issuer) }}" required>
                    </div>
                    <div>
                        <label class="form-label">Year</label>
                        <input type="text" name="year" class="form-input" value="{{ old('year', $certificate->year) }}" placeholder="e.g. 2025">
                    </div>
                </div>

                <div style="margin-bottom:24px;">
                    <label class="form-label">Credential URL</label>
                    <input type="url" name="credential_url" class="form-input" value="{{ old('credential_url', $certificate->credential_url) }}" placeholder="https://verify.credential.com/...">
                </div>

                <div style="margin-bottom:24px;">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-input" rows="4" placeholder="Brief description of the certification...">{{ old('description', $certificate->description) }}</textarea>
                </div>
            </div>

            {{-- Sidebar --}}
            <div style="display:flex; flex-direction:column; gap:24px;">
                <div class="glass-card" style="padding:24px;">
                    <h3 style="font-size:12px; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; color:rgba(255,255,255,0.4); margin-bottom:16px;">Certificate Image</h3>
                    @if($certificate->image_url)
                    <div style="margin-bottom:12px;">
                        <img src="{{ asset('storage/' . $certificate->image_url) }}" alt="Current Certificate" style="width:100%; border-radius:8px; border:1px solid rgba(255,255,255,0.1);">
                        <p style="font-size:11px; color:rgba(255,255,255,0.4); margin-top:6px;">Current image</p>
                    </div>
                    @endif
                    <input type="file" name="image_url" class="form-input" accept="image/*">
                </div>

                <div class="glass-card" style="padding:24px;">
                    <h3 style="font-size:12px; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; color:rgba(255,255,255,0.4); margin-bottom:16px;">Status</h3>
                    <div style="margin-bottom:12px;">
                        <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $certificate->is_active) ? 'checked' : '' }}>
                            <span style="font-size:13px; color:rgba(255,255,255,0.7);">Active</span>
                        </label>
                    </div>
                    <div>
                        <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $certificate->is_featured) ? 'checked' : '' }}>
                            <span style="font-size:13px; color:rgba(255,255,255,0.7);">Featured</span>
                        </label>
                    </div>
                </div>

                <div class="glass-card" style="padding:24px;">
                    <h3 style="font-size:12px; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; color:rgba(255,255,255,0.4); margin-bottom:16px;">Sort Order</h3>
                    <input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', $certificate->sort_order) }}" min="0">
                </div>

                <button type="submit" class="btn-primary" style="width:100%; justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:14px;height:14px;">
                        <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
                        <polyline points="17,21 17,13 7,13 7,21" />
                        <polyline points="7,3 7,8 15,8" />
                    </svg>
                    Update Certificate
                </button>
            </div>
        </div>
    </form>

    {{-- Delete Form (separate from update form) --}}
    <form method="POST" action="{{ route('admin.certificates.destroy', $certificate) }}" onsubmit="return confirm('Delete permanently?')" style="margin-top:16px; max-width:200px;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-danger" style="width:100%; justify-content:center;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;">
                <polyline points="3,6 5,6 21,6" />
                <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2" />
            </svg>
            Delete Certificate
        </button>
    </form>
</div>
@endsection
