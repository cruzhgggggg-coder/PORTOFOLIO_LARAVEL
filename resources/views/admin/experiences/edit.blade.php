@extends('admin.layout')

@section('title', 'Edit Experience')

@section('content')
<div style="max-width:900px;">
    {{-- Header --}}
    <div style="display:flex; align-items:center; gap:16px; margin-bottom:2.5rem;">
        <a href="{{ route('admin.experiences.index') }}" class="btn-secondary" style="padding:10px; border-radius:12px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:16px;height:16px;"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        </a>
        <div>
            <h1 style="font-size:32px; font-weight:800; letter-spacing:-0.04em;">Edit Experience</h1>
            <p style="color:rgba(255,255,255,0.4); font-size:14px;">Perbarui detail pengalaman <span style="color:#fff;">{{ $experience->title }}</span>.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.experiences.update', $experience) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display:grid; grid-template-columns: 1fr 300px; gap:24px; align-items:start;">
            {{-- Main Content --}}
            <div style="display:flex; flex-direction:column; gap:24px;">
                <div class="glass-card" style="padding:32px;">
                    <div style="margin-bottom:24px;">
                        <label class="form-label">Type <span style="color:#f87171;">*</span></label>
                        <select name="type" class="form-input" required autofocus>
                            <option value="">Select type...</option>
                            <option value="work" {{ old('type', $experience->type) === 'work' ? 'selected' : '' }}>Work Experience</option>
                            <option value="education" {{ old('type', $experience->type) === 'education' ? 'selected' : '' }}>Education</option>
                            <option value="certification" {{ old('type', $experience->type) === 'certification' ? 'selected' : '' }}>Certification</option>
                        </select>
                    </div>

                    <div style="margin-bottom:24px;">
                        <label class="form-label">Title / Position <span style="color:#f87171;">*</span></label>
                        <input type="text" name="title" class="form-input" value="{{ old('title', $experience->title) }}" placeholder="e.g. Senior Frontend Developer" required>
                    </div>

                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; margin-bottom:24px;">
                        <div>
                            <label class="form-label">Company / Institution <span style="color:#f87171;">*</span></label>
                            <input type="text" name="company" class="form-input" value="{{ old('company', $experience->company) }}" placeholder="e.g. Google Inc." required>
                        </div>
                        <div>
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-input" value="{{ old('location', $experience->location) }}" placeholder="e.g. Jakarta, Indonesia">
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; margin-bottom:24px;">
                        <div>
                            <label class="form-label">Start Date <span style="color:#f87171;">*</span></label>
                            <input type="date" name="start_date" class="form-input" value="{{ old('start_date', $experience->start_date?->format('Y-m-d')) }}" required>
                        </div>
                        <div>
                            <label class="form-label">End Date</label>
                            <input type="date" name="end_date" class="form-input" value="{{ old('end_date', $experience->end_date?->format('Y-m-d')) }}">
                            <small style="color:rgba(255,255,255,0.2); font-size:10px; display:block; margin-top:6px;">Leave empty if currently active</small>
                        </div>
                    </div>

                    <div style="margin-bottom:24px;">
                        <label style="display:flex; align-items:center; gap:12px; cursor:pointer;">
                            <input type="checkbox" name="is_current" value="1" {{ old('is_current', $experience->is_current) ? 'checked' : '' }} style="width:18px; height:18px; accent-color:var(--brand);">
                            <span style="font-size:13px; font-weight:600; color:rgba(255,255,255,0.7);">Currently active in this role</span>
                        </label>
                    </div>

                    <div style="margin-bottom:24px;">
                        <label class="form-label">Description <span style="color:#f87171;">*</span></label>
                        <textarea name="description" class="form-input" rows="6" placeholder="Jelaskan tanggung jawab, pencapaian, dan kontribusi utama kamu..." required style="resize:vertical; line-height:1.6;">{{ old('description', $experience->description) }}</textarea>
                    </div>
                </div>

                <div class="glass-card" style="padding:32px;">
                    <h3 style="font-size:12px; font-weight:800; letter-spacing:0.12em; text-transform:uppercase; color:rgba(255,255,255,0.4); margin-bottom:24px;">Additional Details</h3>

                    <div style="margin-bottom:24px;">
                        <label class="form-label">Highlights / Key Achievements</label>
                        <textarea name="highlights" class="form-input" rows="5" placeholder="Led migration to microservices architecture&#10;Reduced page load time by 40%&#10;Mentored team of 5 junior developers" style="resize:vertical; line-height:1.6; font-family:'JetBrains Mono', monospace; font-size:12px;">{{ old('highlights', is_array($experience->highlights) ? implode("\n", $experience->highlights) : $experience->highlights) }}</textarea>
                        <small style="color:rgba(255,255,255,0.2); font-size:10px; display:block; margin-top:6px;">One achievement per line</small>
                    </div>

                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                        <div>
                            <label class="form-label">Logo / Image</label>
                            <input type="file" name="logo_url" class="form-input" accept="image/*" style="padding:12px;">
                            <small style="color:rgba(255,255,255,0.2); font-size:10px; display:block; margin-top:6px;">PNG, JPG, WEBP (Maks 2MB)</small>
                            @if($experience->logo_url)
                            <div style="margin-top:10px; display:flex; align-items:center; gap:8px;">
                                <img src="{{ asset('storage/' . $experience->logo_url) }}" alt="Current logo" style="width:40px; height:40px; object-fit:cover; border-radius:8px; border:1px solid rgba(255,255,255,0.1);">
                                <span style="font-size:10px; color:rgba(255,255,255,0.3);">Current logo</span>
                            </div>
                            @endif
                        </div>
                        <div>
                            <label class="form-label">Link / URL</label>
                            <input type="url" name="link" class="form-input" value="{{ old('link', $experience->link) }}" placeholder="https://company.com/...">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Actions --}}
            <div style="display:flex; flex-direction:column; gap:24px;">
                <div class="glass-card" style="padding:24px;">
                    <div style="margin-bottom:20px;">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', $experience->sort_order) }}" min="0" placeholder="0">
                        <small style="color:rgba(255,255,255,0.2); font-size:10px; display:block; margin-top:6px;">Lower number = higher priority</small>
                    </div>

                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
                        <span style="font-size:13px; font-weight:700;">Active?</span>
                        <label style="position:relative; display:inline-block; width:44px; height:24px;">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $experience->is_active) ? 'checked' : '' }} style="opacity:0; width:0; height:0;" id="active-toggle">
                            <span id="toggle-track" style="position:absolute; cursor:pointer; top:0; left:0; right:0; bottom:0; background:rgba(255,255,255,0.1); border-radius:24px; transition:0.3s;"></span>
                            <span id="toggle-thumb" style="position:absolute; content:''; height:18px; width:18px; left:3px; bottom:3px; background:white; border-radius:50%; transition:0.3s;"></span>
                        </label>
                    </div>
                    <p style="color:rgba(255,255,255,0.3); font-size:11px; line-height:1.5;">Nonaktifkan untuk menyembunyikan dari website tanpa menghapus data.</p>
                </div>

                <div style="display:flex; flex-direction:column; gap:12px;">
                    <button type="submit" class="btn-primary" style="width:100%; justify-content:center; padding:16px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:16px;height:16px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Perbarui Experience
                    </button>
                    <a href="{{ route('admin.experiences.index') }}" class="btn-secondary" style="width:100%; justify-content:center; padding:14px;">Batal</a>
                </div>

                @php $deleteUrl = route('admin.experiences.destroy', $experience); @endphp
                <button type="button" class="btn-danger" style="width:100%; justify-content:center; padding:14px; background:rgba(239,68,68,0.05); margin-top:12px;"
                        onclick="openDeleteModal('{{ $deleteUrl }}')">
                    Hapus Permanen
                </button>
            </div>
        </div>
    </form>
</div>

<script>
// Toggle switch functionality
const toggle = document.getElementById('active-toggle');
const track = document.getElementById('toggle-track');
const thumb = document.getElementById('toggle-thumb');
function updateToggle() {
    if (toggle.checked) {
        track.style.background = 'var(--brand)';
        thumb.style.transform = 'translateX(20px)';
    } else {
        track.style.background = 'rgba(255,255,255,0.1)';
        thumb.style.transform = 'translateX(0)';
    }
}
toggle.addEventListener('change', updateToggle);
updateToggle();
</script>
@endsection
