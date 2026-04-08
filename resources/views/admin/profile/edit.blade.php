@extends('admin.layout')

@section('title', 'Profile Identity')

@section('content')
<div style="max-width:1000px;">
    {{-- Header --}}
    <div style="margin-bottom:3rem;">
        <h1 style="font-size:36px; font-weight:800; letter-spacing:-0.05em; margin-bottom:10px;">Profile & Identity</h1>
        <p style="color:rgba(255,255,255,0.4); font-size:15px;">Kelola representasi diri kamu di jagat digital.</p>
    </div>

    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
        @csrf

        <div style="display:grid; grid-template-columns: 1fr 320px; gap:32px; align-items:start;">
            <div style="display:flex; flex-direction:column; gap:32px;">
                {{-- Basic Identity --}}
                <div class="glass-card" style="padding:32px;">
                    <h3 style="font-size:12px; font-weight:800; letter-spacing:0.15em; text-transform:uppercase; color:rgba(255,255,255,0.3); margin-bottom:24px; display:flex; align-items:center; gap:10px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Identitas Dasar
                    </h3>
                    
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; margin-bottom:24px;">
                        <div>
                            <label class="form-label">Nama Lengkap <span style="color:#f87171;">*</span></label>
                            <input type="text" name="name" class="form-input" value="{{ old('name', $settings['name'] ?? '') }}" required>
                        </div>
                        <div>
                            <label class="form-label">Professional Tagline</label>
                            <input type="text" name="tagline" class="form-input" value="{{ old('tagline', $settings['tagline'] ?? '') }}" placeholder="Digital Architect & Fullstack Engineer">
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; margin-bottom:24px;">
                        <div>
                            <label class="form-label">Lokasi Saat Ini</label>
                            <input type="text" name="location" class="form-input" value="{{ old('location', $settings['location'] ?? '') }}" placeholder="Jakarta, Indonesia">
                        </div>
                        <div>
                            <label class="form-label">Email Publik</label>
                            <input type="email" name="email" class="form-input" value="{{ old('email', $settings['email'] ?? '') }}">
                        </div>
                    </div>

                    <div style="margin-bottom:24px;">
                        <label class="form-label">Nomor Telepon Publik</label>
                        <input type="text" name="phone" class="form-input" value="{{ old('phone', $settings['phone'] ?? '') }}" placeholder="+62 812 ...">
                    </div>

                    <div>
                        <label class="form-label">Bio Singkat</label>
                        <textarea name="bio" class="form-input" rows="4" style="resize:vertical; line-height:1.6;">{{ old('bio', $settings['bio'] ?? '') }}</textarea>
                    </div>
                </div>

                {{-- Hero Section --}}
                <div class="glass-card" style="padding:32px;">
                    <h3 style="font-size:12px; font-weight:800; letter-spacing:0.15em; text-transform:uppercase; color:rgba(255,255,255,0.3); margin-bottom:24px; display:flex; align-items:center; gap:10px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        Main Hero Content
                    </h3>

                    <div style="margin-bottom:24px;">
                        <label class="form-label">Badge Text <small style="opacity:.5; text-transform:none;">(Floating above title)</small></label>
                        <input type="text" name="hero_badge" class="form-input" value="{{ old('hero_badge', $settings['hero_badge'] ?? '') }}" placeholder="Digital Architect & Designer">
                    </div>

                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; margin-bottom:24px;">
                        <div>
                            <label class="form-label">Headline Line 1 <small style="opacity:.5; text-transform:none;">(Standard font)</small></label>
                            <input type="text" name="hero_line1" class="form-input" value="{{ old('hero_line1', $settings['hero_line1'] ?? '') }}" placeholder="WEAVING LIGHT INTO">
                        </div>
                        <div>
                            <label class="form-label">Headline Line 2 <small style="opacity:.5; text-transform:none;">(Blue gradient font)</small></label>
                            <input type="text" name="hero_line2" class="form-input" value="{{ old('hero_line2', $settings['hero_line2'] ?? '') }}" placeholder="DIGITAL STRUCTURES">
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Hero Description</label>
                        <textarea name="hero_desc" class="form-input" rows="3" style="resize:vertical; line-height:1.6;">{{ old('hero_desc', $settings['hero_desc'] ?? '') }}</textarea>
                    </div>
                </div>

                {{-- Statistics --}}
                <div class="glass-card" style="padding:32px;">
                    <h3 style="font-size:12px; font-weight:800; letter-spacing:0.15em; text-transform:uppercase; color:rgba(255,255,255,0.3); margin-bottom:24px;">Achievements Stats</h3>
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                        <div>
                            <label class="form-label">Years of Experience</label>
                            <div style="position:relative;">
                                <input type="number" name="years_exp" class="form-input" value="{{ old('years_exp', $settings['years_exp'] ?? '') }}" min="0">
                                <span style="position:absolute; right:16px; top:50%; transform:translateY(-50%); font-size:12px; color:rgba(255,255,255,0.2);">Years</span>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Projects Completed</label>
                            <div style="position:relative;">
                                <input type="number" name="projects_count" class="form-input" value="{{ old('projects_count', $settings['projects_count'] ?? '') }}" min="0">
                                <span style="position:absolute; right:16px; top:50%; transform:translateY(-50%); font-size:12px; color:rgba(255,255,255,0.2);">Works</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="display:flex; flex-direction:column; gap:32px;">
                {{-- Profile Photo --}}
                <div class="glass-card" style="padding:24px; text-align:center;">
                    <label class="form-label" style="text-align:left;">Avatar Representation</label>
                    <div style="position:relative; width:160px; height:160px; margin:20px auto; border-radius:50%; padding:4px; background:linear-gradient(135deg, var(--brand) 0%, #7c3aed 100%);">
                        <div style="width:100%; height:100%; border-radius:50%; overflow:hidden; background:#0d0d12; position:relative;">
                            @if(!empty($settings['photo_url']))
                                <img id="photo-preview" src="{{ $settings['photo_url'] }}" alt="Avatar" style="width:100%; height:100%; object-fit:cover;">
                            @else
                                <div id="photo-preview-placeholder" style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:48px; font-weight:800; color:rgba(255,255,255,0.1);">
                                    {{ strtoupper(substr($settings['name'] ?? 'A', 0, 1)) }}
                                </div>
                                <img id="photo-preview" style="display:none; width:100%; height:100%; object-fit:cover;" alt="Preview">
                            @endif
                        </div>
                        <button type="button" onclick="document.getElementById('photo-upload').click()" 
                                style="position:absolute; bottom:5px; right:5px; width:40px; height:40px; border-radius:50%; background:var(--brand); border:4px solid #050508; color:#000; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all 0.2s;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:18px;height:18px;"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                        </button>
                    </div>
                    <input type="file" name="photo" id="photo-upload" accept="image/*" style="display:none;" onchange="previewPhoto(this)">
                    <p style="color:rgba(255,255,255,0.3); font-size:11px;">Recommended: 1:1 Aspect Ratio, Max 4MB</p>
                </div>

                {{-- Social Connect --}}
                <div class="glass-card" style="padding:24px;">
                    <h3 style="font-size:11px; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; color:rgba(255,255,255,0.3); margin-bottom:20px;">Social Connect</h3>
                    <div style="display:flex; flex-direction:column; gap:16px;">
                        <div>
                            <label class="form-label" style="font-size:9px;">GitHub URL</label>
                            <input type="url" name="github_url" class="form-input" value="{{ old('github_url', $settings['github_url'] ?? '') }}" style="padding:10px 14px; font-size:12px;">
                        </div>
                        <div>
                            <label class="form-label" style="font-size:9px;">LinkedIn URL</label>
                            <input type="url" name="linkedin_url" class="form-input" value="{{ old('linkedin_url', $settings['linkedin_url'] ?? '') }}" style="padding:10px 14px; font-size:12px;">
                        </div>
                        <div>
                            <label class="form-label" style="font-size:9px;">Twitter / X URL</label>
                            <input type="url" name="twitter_url" class="form-input" value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}" style="padding:10px 14px; font-size:12px;">
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div style="display:flex; flex-direction:column; gap:12px;">
                    <button type="submit" class="btn-primary" style="width:100%; justify-content:center; padding:16px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:18px;height:18px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn-secondary" style="width:100%; justify-content:center; padding:14px;">Batal</a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const placeholder = document.getElementById('photo-preview-placeholder');
            if (placeholder) placeholder.style.display = 'none';
            const preview = document.getElementById('photo-preview');
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
