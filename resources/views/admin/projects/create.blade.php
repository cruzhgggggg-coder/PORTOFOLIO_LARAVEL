@extends('admin.layout')

@section('title', 'New Project')

@section('content')
<div style="max-width:900px;">
    {{-- Header --}}
    <div style="display:flex; align-items:center; gap:16px; margin-bottom:2.5rem;">
        <a href="{{ route('admin.projects.index') }}" class="btn-secondary" style="padding:10px; border-radius:12px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:16px;height:16px;"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        </a>
        <div>
            <h1 style="font-size:32px; font-weight:800; letter-spacing:-0.04em;">Tambah Karya Baru</h1>
            <p style="color:rgba(255,255,255,0.4); font-size:14px;">Abadikan mahakarya digital terbaru kamu ke dalam portfolio.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
        @csrf

        <div style="display:grid; grid-template-columns: 1fr 300px; gap:24px; align-items:start;">
            {{-- Main Content --}}
            <div style="display:flex; flex-direction:column; gap:24px;">
                <div class="glass-card" style="padding:32px;">
                    <div style="margin-bottom:24px;">
                        <label class="form-label">Judul Project <span style="color:#f87171;">*</span></label>
                        <input type="text" name="title" class="form-input" value="{{ old('title') }}" placeholder="e.g. Cybernetic Interface 2.0" required autofocus>
                    </div>

                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; margin-bottom:24px;">
                        <div>
                            <label class="form-label">Kategori <span style="color:#f87171;">*</span></label>
                            <input type="text" name="category" class="form-input" value="{{ old('category') }}" placeholder="e.g. Digital Architecture" required>
                        </div>
                        <div>
                            <label class="form-label">Tahun <span style="color:#f87171;">*</span></label>
                            <input type="text" name="year" class="form-input" value="{{ old('year', date('Y')) }}" placeholder="2024" maxlength="4" required>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Deskripsi Naratif <span style="color:#f87171;">*</span></label>
                        <textarea name="description" class="form-input" rows="6" placeholder="Ceritakan filosofi dan tantangan teknis di balik project ini..." required style="resize:vertical; line-height:1.6;">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="glass-card" style="padding:32px;">
                    <h3 style="font-size:12px; font-weight:800; letter-spacing:0.12em; text-transform:uppercase; color:rgba(255,255,255,0.4); margin-bottom:24px;">Spesifikasi Teknis</h3>
                    
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; margin-bottom:24px;">
                        <div>
                            <label class="form-label">Tech Stack</label>
                            <input type="text" name="tech_stack" class="form-input" value="{{ old('tech_stack') }}" placeholder="Laravel, Three.js, GSAP">
                            <small style="color:rgba(255,255,255,0.2); font-size:10px; display:block; margin-top:6px;">Gunakan koma sebagai pemisah</small>
                        </div>
                        <div>
                            <label class="form-label">Tags / Keywords</label>
                            <input type="text" name="tags" class="form-input" value="{{ old('tags') }}" placeholder="immersive, high-perf, minimal">
                            <small style="color:rgba(255,255,255,0.2); font-size:10px; display:block; margin-top:6px;">Gunakan koma sebagai pemisah</small>
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                        <div>
                            <label class="form-label">Link Repository</label>
                            <input type="url" name="link_repo" class="form-input" value="{{ old('link_repo') }}" placeholder="https://github.com/...">
                        </div>
                        <div>
                            <label class="form-label">Link Demo / Live</label>
                            <input type="url" name="link_demo" class="form-input" value="{{ old('link_demo') }}" placeholder="https://interface.la/...">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Actions --}}
            <div style="display:flex; flex-direction:column; gap:24px;">
                <div class="glass-card" style="padding:24px;">
                    <label class="form-label">Visual Representasi</label>
                    <div style="border:2px dashed rgba(255,255,255,0.1); border-radius:16px; padding:20px; text-align:center; cursor:pointer; transition:all 0.3s;" 
                         id="drop-zone" onclick="document.getElementById('image-upload').click()">
                        <input type="file" name="image" id="image-upload" accept="image/*" style="display:none;" onchange="previewImage(this)">
                        
                        <div id="upload-placeholder">
                            <div style="width:48px; height:48px; background:rgba(255,255,255,0.03); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="2" style="width:24px;height:24px;">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
                                </svg>
                            </div>
                            <p style="color:rgba(255,255,255,0.3); font-size:12px; font-weight:600; margin-bottom:4px;">Klik untuk upload</p>
                            <p style="color:rgba(255,255,255,0.15); font-size:10px;">PNG, JPG, WEBP (Maks 4MB)</p>
                        </div>
                        
                        <img id="image-preview" style="display:none; width:100%; border-radius:10px; object-fit:cover; aspect-ratio:4/3;" alt="Preview">
                    </div>
                </div>

                <div class="glass-card" style="padding:24px;">
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
                        <span style="font-size:13px; font-weight:700;">Featured?</span>
                        <label style="position:relative; display:inline-block; width:44px; height:24px;">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} style="opacity:0; width:0; height:0;" id="featured-toggle">
                            <span id="toggle-track" style="position:absolute; cursor:pointer; top:0; left:0; right:0; bottom:0; background:rgba(255,255,255,0.1); border-radius:24px; transition:0.3s;"></span>
                            <span id="toggle-thumb" style="position:absolute; content:''; height:18px; width:18px; left:3px; bottom:3px; background:white; border-radius:50%; transition:0.3s;"></span>
                        </label>
                    </div>
                    <p style="color:rgba(255,255,255,0.3); font-size:11px; line-height:1.5;">Aktifkan untuk menampilkan karya ini di section utama homepage.</p>
                </div>

                <div style="display:flex; flex-direction:column; gap:12px;">
                    <button type="submit" class="btn-primary" style="width:100%; justify-content:center; padding:16px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:16px;height:16px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Simpan Karya
                    </button>
                    <a href="{{ route('admin.projects.index') }}" class="btn-secondary" style="width:100%; justify-content:center; padding:14px;">Batal</a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('upload-placeholder').style.display = 'none';
            const preview = document.getElementById('image-preview');
            preview.src = e.target.result;
            preview.style.display = 'block';
            document.getElementById('drop-zone').style.borderColor = 'var(--brand)';
            document.getElementById('drop-zone').style.background = 'rgba(0, 242, 255, 0.03)';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Toggle switch functionality
const toggle = document.getElementById('featured-toggle');
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
