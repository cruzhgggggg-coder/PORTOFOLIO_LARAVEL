@extends('admin.layout')

@section('title', 'Edit SEO - ' . $pageKey)

@section('content')
<div style="max-width:800px;">
    {{-- Breadcrumb --}}
    <div style="margin-bottom:2rem;">
        <a href="{{ route('admin.seo.index') }}" style="display:inline-flex; align-items:center; gap:8px; color:rgba(255,255,255,0.4); font-size:13px; font-weight:500; text-decoration:none; transition:color 0.2s;"
           onmouseover="this.style.color='var(--brand)'" onmouseout="this.style.color='rgba(255,255,255,0.4)'">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px; height:16px;">
                <polyline points="15 18 9 12 15 6" />
            </svg>
            Back to SEO Manager
        </a>
    </div>

    {{-- Header --}}
    <div style="margin-bottom:2.5rem;">
        <h1 style="font-size:32px; font-weight:800; letter-spacing:-0.04em; margin-bottom:8px;">SEO Settings: {{ ucfirst($pageKey) }}</h1>
        <p style="color:rgba(255,255,255,0.4); font-size:14px;">Configure meta tags, Open Graph data, and indexing rules for this page.</p>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
    <div class="glass-card" style="padding:20px 24px; margin-bottom:24px; border-left:3px solid rgba(239,68,68,0.5);">
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="#f87171" stroke-width="2" style="width:20px; height:20px;">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="8" x2="12" y2="12" />
                <line x1="12" y1="16" x2="12.01" y2="16" />
            </svg>
            <div style="font-size:14px; font-weight:700; color:#f87171;">Please fix the following errors:</div>
        </div>
        <ul style="margin:0; padding-left:20px; color:rgba(255,255,255,0.6); font-size:13px;">
            @foreach($errors->all() as $error)
            <li style="margin-bottom:4px;">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- SEO Form --}}
    <form method="POST" action="{{ route('admin.seo.update', ['pageKey' => $pageKey]) }}" class="seo-form">
        @method('PUT')
        @csrf

        {{-- Basic SEO Section --}}
        <div class="glass-card" style="padding:28px; margin-bottom:24px;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
                <div style="width:36px; height:36px; background:var(--brand-muted); border:1px solid rgba(0,242,255,0.2); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="var(--brand)" stroke-width="2" style="width:18px; height:18px;">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                </div>
                <div>
                    <div style="font-size:16px; font-weight:700; color:#fff;">Basic SEO</div>
                    <div style="font-size:11px; color:rgba(255,255,255,0.3);">Title, description, and keywords</div>
                </div>
            </div>

            {{-- Meta Title --}}
            <div style="margin-bottom:24px;">
                <label class="form-label" for="meta_title">Meta Title</label>
                <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $seoSetting->meta_title) }}" class="form-input" placeholder="e.g., Home - John Doe Portfolio" maxlength="70" />
                <div style="display:flex; justify-content:space-between; margin-top:6px;">
                    <span style="font-size:11px; color:rgba(255,255,255,0.25);">Recommended: 50-60 characters</span>
                    <span id="titleCount" style="font-size:11px; color:rgba(255,255,255,0.25); font-family:'JetBrains Mono', monospace;">{{ strlen(old('meta_title', $seoSetting->meta_title ?? '')) }}/70</span>
                </div>
            </div>

            {{-- Meta Description --}}
            <div style="margin-bottom:24px;">
                <label class="form-label" for="meta_description">Meta Description</label>
                <textarea id="meta_description" name="meta_description" rows="3" class="form-input" placeholder="A concise description of this page for search engines..." maxlength="160">{{ old('meta_description', $seoSetting->meta_description) }}</textarea>
                <div style="display:flex; justify-content:space-between; margin-top:6px;">
                    <span style="font-size:11px; color:rgba(255,255,255,0.25);">Recommended: 120-155 characters</span>
                    <span id="descCount" style="font-size:11px; color:rgba(255,255,255,0.25); font-family:'JetBrains Mono', monospace;">{{ strlen(old('meta_description', $seoSetting->meta_description ?? '')) }}/160</span>
                </div>
            </div>

            {{-- Meta Keywords --}}
            <div>
                <label class="form-label" for="meta_keywords">Meta Keywords</label>
                <input type="text" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $seoSetting->meta_keywords) }}" class="form-input" placeholder="e.g., portfolio, web developer, designer" />
                <div style="font-size:11px; color:rgba(255,255,255,0.25); margin-top:6px;">Comma-separated keywords for search engines</div>
            </div>
        </div>

        {{-- Open Graph Section --}}
        <div class="glass-card" style="padding:28px; margin-bottom:24px;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
                <div style="width:36px; height:36px; background:rgba(124,58,237,0.15); border:1px solid rgba(124,58,237,0.2); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#a78bfa" stroke-width="2" style="width:18px; height:18px;">
                        <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8" />
                        <polyline points="16 6 12 2 8 6" />
                        <line x1="12" y1="2" x2="12" y2="15" />
                    </svg>
                </div>
                <div>
                    <div style="font-size:16px; font-weight:700; color:#fff;">Open Graph</div>
                    <div style="font-size:11px; color:rgba(255,255,255,0.3);">Social sharing metadata</div>
                </div>
            </div>

            {{-- OG Image --}}
            <div>
                <label class="form-label" for="og_image">Open Graph Image URL</label>
                <input type="url" id="og_image" name="og_image" value="{{ old('og_image', $seoSetting->og_image) }}" class="form-input" placeholder="https://example.com/og-image.jpg" />
                <div style="font-size:11px; color:rgba(255,255,255,0.25); margin-top:6px;">Recommended: 1200x630 pixels for optimal display on social media</div>
            </div>
        </div>

        {{-- Advanced Section --}}
        <div class="glass-card" style="padding:28px; margin-bottom:24px;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
                <div style="width:36px; height:36px; background:rgba(245,158,11,0.15); border:1px solid rgba(245,158,11,0.2); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="2" style="width:18px; height:18px;">
                        <circle cx="12" cy="12" r="3" />
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                    </svg>
                </div>
                <div>
                    <div style="font-size:16px; font-weight:700; color:#fff;">Advanced</div>
                    <div style="font-size:11px; color:rgba(255,255,255,0.3);">Canonical URL and indexing rules</div>
                </div>
            </div>

            {{-- Canonical URL --}}
            <div style="margin-bottom:24px;">
                <label class="form-label" for="canonical_url">Canonical URL</label>
                <input type="url" id="canonical_url" name="canonical_url" value="{{ old('canonical_url', $seoSetting->canonical_url) }}" class="form-input" placeholder="https://example.com/page" />
                <div style="font-size:11px; color:rgba(255,255,255,0.25); margin-top:6px;">Prevents duplicate content issues by specifying the preferred URL</div>
            </div>

            {{-- No Index Checkbox --}}
            <div style="display:flex; align-items:flex-start; gap:12px; padding:16px; background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.06); border-radius:12px;">
                <input type="checkbox" id="no_index" name="no_index" value="1" {{ old('no_index', $seoSetting->no_index) ? 'checked' : '' }}
                       style="width:20px; height:20px; margin-top:2px; accent-color:var(--brand); cursor:pointer; flex-shrink:0;" />
                <div>
                    <label for="no_index" style="font-size:14px; font-weight:600; color:#fff; cursor:pointer;">No Index</label>
                    <div style="font-size:12px; color:rgba(255,255,255,0.35); margin-top:2px;">Prevent search engines from indexing this page. Use for pages like admin panels, thank you pages, or private content.</div>
                </div>
            </div>
        </div>

        {{-- Submit Buttons --}}
        <div style="display:flex; gap:12px; justify-content:flex-end;">
            <a href="{{ route('admin.seo.index') }}" class="btn-secondary" style="padding:12px 24px;">
                Cancel
            </a>
            <button type="submit" class="btn-primary" style="padding:12px 28px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:16px; height:16px;">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                    <polyline points="17 21 17 13 7 13 7 21" />
                    <polyline points="7 3 7 8 15 8" />
                </svg>
                Update SEO Settings
            </button>
        </div>
    </form>
</div>

<script>
    // Character counters
    const titleInput = document.getElementById('meta_title');
    const descInput = document.getElementById('meta_description');
    const titleCount = document.getElementById('titleCount');
    const descCount = document.getElementById('descCount');

    if (titleInput && titleCount) {
        titleInput.addEventListener('input', function() {
            titleCount.textContent = this.value.length + '/70';
            titleCount.style.color = this.value.length > 70 ? '#f87171' : 'rgba(255,255,255,0.25)';
        });
    }

    if (descInput && descCount) {
        descInput.addEventListener('input', function() {
            descCount.textContent = this.value.length + '/160';
            descCount.style.color = this.value.length > 160 ? '#f87171' : 'rgba(255,255,255,0.25)';
        });
    }
</script>
@endsection
