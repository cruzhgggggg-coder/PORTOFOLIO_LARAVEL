@extends('admin.layout')

@section('title', 'Site Settings')

@section('content')
<div style="max-width:900px;">
    {{-- Header --}}
    <div style="margin-bottom:2.5rem;">
        <h1 style="font-size:32px; font-weight:800; letter-spacing:-0.04em; margin-bottom:8px;">Site Settings</h1>
        <p style="color:rgba(255,255,255,0.4); font-size:14px;">Configure global settings and preferences for your portfolio.</p>
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

    {{-- Settings Form --}}
    <form method="POST" action="{{ route('admin.settings.update') }}">
        @method('PUT')
        @csrf

        {{-- Section 1: General Settings --}}
        <div class="glass-card" style="padding:28px; margin-bottom:24px;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
                <div style="width:36px; height:36px; background:var(--brand-muted); border:1px solid rgba(0,242,255,0.2); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="var(--brand)" stroke-width="2" style="width:18px; height:18px;">
                        <circle cx="12" cy="12" r="3" />
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                    </svg>
                </div>
                <div>
                    <div style="font-size:16px; font-weight:700; color:#fff;">General Settings</div>
                    <div style="font-size:11px; color:rgba(255,255,255,0.3);">Basic site identification and mode</div>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
                {{-- Site Name --}}
                <div>
                    <label class="form-label" for="site_name">Site Name</label>
                    <input type="text" id="site_name" name="site_name" value="{{ old('site_name', $settings->get('site_name', '')) }}" class="form-input" placeholder="My Portfolio" />
                    <div style="font-size:11px; color:rgba(255,255,255,0.25); margin-top:6px;">Displayed in browser tab and header</div>
                </div>

                {{-- Site Tagline --}}
                <div>
                    <label class="form-label" for="site_tagline">Site Tagline</label>
                    <input type="text" id="site_tagline" name="site_tagline" value="{{ old('site_tagline', $settings->get('site_tagline', '')) }}" class="form-input" placeholder="Building the future, one line at a time" />
                    <div style="font-size:11px; color:rgba(255,255,255,0.25); margin-top:6px;">Short description of your portfolio</div>
                </div>
            </div>

            {{-- Maintenance Mode --}}
            <div style="padding:16px; background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.06); border-radius:12px; display:flex; align-items:flex-start; gap:12px;">
                <div style="position:relative; flex-shrink:0;">
                    <input type="checkbox" id="maintenance_mode" name="maintenance_mode" value="1" {{ old('maintenance_mode', $settings->get('maintenance_mode', false)) ? 'checked' : '' }} class="sr-only" />
                    <label for="maintenance_mode" style="width:44px; height:24px; background:rgba(255,255,255,0.1); border-radius:12px; display:block; position:relative; cursor:pointer; transition:background 0.3s ease;" id="toggle-bg">
                        <span id="toggle-knob" style="position:absolute; top:2px; left:2px; width:20px; height:20px; background:#fff; border-radius:50%; transition:transform 0.3s cubic-bezier(0.4,0,0.2,1); box-shadow:0 2px 4px rgba(0,0,0,0.2);"></span>
                    </label>
                </div>
                <div style="flex:1;">
                    <label for="maintenance_mode" style="font-size:14px; font-weight:600; color:#fff; cursor:pointer; display:block;">Maintenance Mode</label>
                    <div style="font-size:12px; color:rgba(255,255,255,0.35); margin-top:2px;">Enable to show a "coming soon" page to visitors while you work on the site.</div>
                </div>
            </div>

            {{-- Maintenance Warning --}}
            <div id="maintenance-warning" style="margin-top:12px; padding:12px 16px; background:rgba(245,158,11,0.1); border:1px solid rgba(245,158,11,0.2); border-radius:10px; display:flex; align-items:center; gap:10px; {{ old('maintenance_mode', $settings->get('maintenance_mode', false)) ? '' : 'display:none;' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="2" style="width:18px; height:18px; flex-shrink:0;">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                    <line x1="12" y1="9" x2="12" y2="13" />
                    <line x1="12" y1="17" x2="12.01" y2="17" />
                </svg>
                <span style="font-size:13px; font-weight:500; color:#fbbf24;">Maintenance mode is enabled. The site will be inaccessible to regular visitors.</span>
            </div>
        </div>

        {{-- Section 2: Contact Information --}}
        <div class="glass-card" style="padding:28px; margin-bottom:24px;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
                <div style="width:36px; height:36px; background:rgba(16,185,129,0.15); border:1px solid rgba(16,185,129,0.2); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" style="width:18px; height:18px;">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                </div>
                <div>
                    <div style="font-size:16px; font-weight:700; color:#fff;">Contact Information</div>
                    <div style="font-size:11px; color:rgba(255,255,255,0.3);">How visitors can reach you</div>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
                {{-- Contact Email --}}
                <div>
                    <label class="form-label" for="contact_email">Contact Email</label>
                    <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', $settings->get('contact_email', '')) }}" class="form-input" placeholder="hello@example.com" />
                    <div style="font-size:11px; color:rgba(255,255,255,0.25); margin-top:6px;">Public-facing contact email</div>
                </div>

                {{-- Contact Phone --}}
                <div>
                    <label class="form-label" for="contact_phone">Contact Phone</label>
                    <input type="text" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $settings->get('contact_phone', '')) }}" class="form-input" placeholder="+1 (555) 123-4567" />
                    <div style="font-size:11px; color:rgba(255,255,255,0.25); margin-top:6px;">Include country code for international</div>
                </div>
            </div>

            {{-- Address --}}
            <div>
                <label class="form-label" for="address">Address</label>
                <textarea id="address" name="address" rows="2" class="form-input" placeholder="123 Main Street, City, Country">{{ old('address', $settings->get('address', '')) }}</textarea>
                <div style="font-size:11px; color:rgba(255,255,255,0.25); margin-top:6px;">Your physical location or office address</div>
            </div>
        </div>

        {{-- Section 3: Analytics & Tracking --}}
        <div class="glass-card" style="padding:28px; margin-bottom:24px;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
                <div style="width:36px; height:36px; background:rgba(139,92,246,0.15); border:1px solid rgba(139,92,246,0.2); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#a78bfa" stroke-width="2" style="width:18px; height:18px;">
                        <line x1="18" y1="20" x2="18" y2="10" />
                        <line x1="12" y1="20" x2="12" y2="4" />
                        <line x1="6" y1="20" x2="6" y2="14" />
                    </svg>
                </div>
                <div>
                    <div style="font-size:16px; font-weight:700; color:#fff;">Analytics & Tracking</div>
                    <div style="font-size:11px; color:rgba(255,255,255,0.3);">Integrate third-party analytics services</div>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                {{-- Google Analytics ID --}}
                <div>
                    <label class="form-label" for="google_analytics_id">Google Analytics ID</label>
                    <input type="text" id="google_analytics_id" name="google_analytics_id" value="{{ old('google_analytics_id', $settings->get('google_analytics_id', '')) }}" class="form-input" placeholder="G-XXXXXXXXXX" />
                    <div style="font-size:11px; color:rgba(255,255,255,0.25); margin-top:6px;">Your GA4 measurement ID</div>
                </div>

                {{-- Facebook Pixel ID --}}
                <div>
                    <label class="form-label" for="facebook_pixel_id">Facebook Pixel ID</label>
                    <input type="text" id="facebook_pixel_id" name="facebook_pixel_id" value="{{ old('facebook_pixel_id', $settings->get('facebook_pixel_id', '')) }}" class="form-input" placeholder="1234567890" />
                    <div style="font-size:11px; color:rgba(255,255,255,0.25); margin-top:6px;">Meta Pixel ID for ad tracking</div>
                </div>
            </div>
        </div>

        {{-- Section 4: Display Options --}}
        <div class="glass-card" style="padding:28px; margin-bottom:24px;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
                <div style="width:36px; height:36px; background:rgba(245,158,11,0.15); border:1px solid rgba(245,158,11,0.2); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="2" style="width:18px; height:18px;">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                        <circle cx="8.5" cy="8.5" r="1.5" />
                        <polyline points="21 15 16 10 5 21" />
                    </svg>
                </div>
                <div>
                    <div style="font-size:16px; font-weight:700; color:#fff;">Display Options</div>
                    <div style="font-size:11px; color:rgba(255,255,255,0.3);">Control what sections appear on the site</div>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:24px;">
                {{-- Show Tech Marquee --}}
                <div style="display:flex; align-items:center; gap:12px; padding:14px 16px; background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.06); border-radius:12px;">
                    <input type="checkbox" id="show_tech_marquee" name="show_tech_marquee" value="1" {{ old('show_tech_marquee', $settings->get('show_tech_marquee', true)) ? 'checked' : '' }}
                           style="width:18px; height:18px; accent-color:var(--brand); cursor:pointer; flex-shrink:0;" />
                    <label for="show_tech_marquee" style="font-size:13px; font-weight:600; color:#fff; cursor:pointer;">Show Tech Marquee</label>
                </div>

                {{-- Show Features Section --}}
                <div style="display:flex; align-items:center; gap:12px; padding:14px 16px; background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.06); border-radius:12px;">
                    <input type="checkbox" id="show_features_section" name="show_features_section" value="1" {{ old('show_features_section', $settings->get('show_features_section', true)) ? 'checked' : '' }}
                           style="width:18px; height:18px; accent-color:var(--brand); cursor:pointer; flex-shrink:0;" />
                    <label for="show_features_section" style="font-size:13px; font-weight:600; color:#fff; cursor:pointer;">Show Features Section</label>
                </div>

                {{-- Enable Testimonials --}}
                <div style="display:flex; align-items:center; gap:12px; padding:14px 16px; background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.06); border-radius:12px;">
                    <input type="checkbox" id="enable_testimonials" name="enable_testimonials" value="1" {{ old('enable_testimonials', $settings->get('enable_testimonials', true)) ? 'checked' : '' }}
                           style="width:18px; height:18px; accent-color:var(--brand); cursor:pointer; flex-shrink:0;" />
                    <label for="enable_testimonials" style="font-size:13px; font-weight:600; color:#fff; cursor:pointer;">Enable Testimonials</label>
                </div>

                {{-- Enable Analytics --}}
                <div style="display:flex; align-items:center; gap:12px; padding:14px 16px; background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.06); border-radius:12px;">
                    <input type="checkbox" id="enable_analytics" name="enable_analytics" value="1" {{ old('enable_analytics', $settings->get('enable_analytics', true)) ? 'checked' : '' }}
                           style="width:18px; height:18px; accent-color:var(--brand); cursor:pointer; flex-shrink:0;" />
                    <label for="enable_analytics" style="font-size:13px; font-weight:600; color:#fff; cursor:pointer;">Enable Analytics</label>
                </div>
            </div>

            {{-- Projects Per Page --}}
            <div style="max-width:200px;">
                <label class="form-label" for="projects_per_page">Projects Per Page</label>
                <input type="number" id="projects_per_page" name="projects_per_page" value="{{ old('projects_per_page', $settings->get('projects_per_page', 9)) }}" class="form-input" min="1" max="50" />
                <div style="font-size:11px; color:rgba(255,255,255,0.25); margin-top:6px;">Number of projects shown per page (1-50)</div>
            </div>
        </div>

        {{-- Section 5: Branding --}}
        <div class="glass-card" style="padding:28px; margin-bottom:24px;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
                <div style="width:36px; height:36px; background:rgba(236,72,153,0.15); border:1px solid rgba(236,72,153,0.2); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#f472b6" stroke-width="2" style="width:18px; height:18px;">
                        <circle cx="13.5" cy="6.5" r="2.5" />
                        <circle cx="17.5" cy="10.5" r="2.5" />
                        <circle cx="8.5" cy="7.5" r="2.5" />
                        <circle cx="6.5" cy="12.5" r="2.5" />
                        <path d="M12 2C6.49 2 2 6.49 2 12s4.49 10 10 10c1.38 0 2.5-1.12 2.5-2.5 0-.61-.23-1.2-.64-1.67-.08-.1-.12-.22-.12-.33 0-.28.22-.5.5-.5H16c3.31 0 6-2.69 6-6 0-5.17-4.49-9-10-9z" />
                    </svg>
                </div>
                <div>
                    <div style="font-size:16px; font-weight:700; color:#fff;">Branding</div>
                    <div style="font-size:11px; color:rgba(255,255,255,0.3);">Customize your site's color scheme</div>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                {{-- Primary Brand Color --}}
                <div>
                    <label class="form-label" for="brand_color_primary">Primary Brand Color</label>
                    <div style="display:flex; gap:12px; align-items:center;">
                        <input type="color" id="brand_color_primary_picker" value="{{ old('brand_color_primary', $settings->get('brand_color_primary', '#00f2ff')) }}" style="width:48px; height:48px; border:none; border-radius:10px; cursor:pointer; background:transparent; flex-shrink:0;" />
                        <input type="text" id="brand_color_primary" name="brand_color_primary" value="{{ old('brand_color_primary', $settings->get('brand_color_primary', '#00f2ff')) }}" class="form-input" placeholder="#00f2ff" maxlength="7" style="flex:1;" />
                    </div>
                    <div style="font-size:11px; color:rgba(255,255,255,0.25); margin-top:6px;">Used for links, buttons, and accents</div>
                </div>

                {{-- Secondary Brand Color --}}
                <div>
                    <label class="form-label" for="brand_color_secondary">Secondary Brand Color</label>
                    <div style="display:flex; gap:12px; align-items:center;">
                        <input type="color" id="brand_color_secondary_picker" value="{{ old('brand_color_secondary', $settings->get('brand_color_secondary', '#7c3aed')) }}" style="width:48px; height:48px; border:none; border-radius:10px; cursor:pointer; background:transparent; flex-shrink:0;" />
                        <input type="text" id="brand_color_secondary" name="brand_color_secondary" value="{{ old('brand_color_secondary', $settings->get('brand_color_secondary', '#7c3aed')) }}" class="form-input" placeholder="#7c3aed" maxlength="7" style="flex:1;" />
                    </div>
                    <div style="font-size:11px; color:rgba(255,255,255,0.25); margin-top:6px;">Used for gradients and highlights</div>
                </div>
            </div>

            {{-- Color Preview --}}
            <div style="margin-top:20px; padding:16px; background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.06); border-radius:12px;">
                <div style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:rgba(255,255,255,0.3); margin-bottom:12px;">Preview</div>
                <div style="display:flex; gap:12px;">
                    <div id="preview-primary" style="width:64px; height:40px; border-radius:8px; background:{{ old('brand_color_primary', $settings->get('brand_color_primary', '#00f2ff')) }}; box-shadow:0 4px 12px {{ old('brand_color_primary', $settings->get('brand_color_primary', '#00f2ff')) }}40; transition:all 0.3s ease;"></div>
                    <div id="preview-secondary" style="width:64px; height:40px; border-radius:8px; background:{{ old('brand_color_secondary', $settings->get('brand_color_secondary', '#7c3aed')) }}; box-shadow:0 4px 12px {{ old('brand_color_secondary', $settings->get('brand_color_secondary', '#7c3aed')) }}40; transition:all 0.3s ease;"></div>
                    <div style="display:flex; flex-direction:column; justify-content:center; font-size:12px; color:rgba(255,255,255,0.4);">
                        <span id="preview-primary-label" style="font-family:'JetBrains Mono', monospace;">{{ old('brand_color_primary', $settings->get('brand_color_primary', '#00f2ff')) }}</span>
                        <span id="preview-secondary-label" style="font-family:'JetBrains Mono', monospace;">{{ old('brand_color_secondary', $settings->get('brand_color_secondary', '#7c3aed')) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Submit Button --}}
        <div style="display:flex; justify-content:flex-end; padding-top:8px;">
            <button type="submit" class="btn-primary" style="padding:14px 32px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:16px; height:16px;">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                    <polyline points="17 21 17 13 7 13 7 21" />
                    <polyline points="7 3 7 8 15 8" />
                </svg>
                Save Settings
            </button>
        </div>
    </form>
</div>

<script>
    // Maintenance mode toggle
    const maintenanceCheckbox = document.getElementById('maintenance_mode');
    const maintenanceWarning = document.getElementById('maintenance-warning');
    const toggleBg = document.getElementById('toggle-bg');
    const toggleKnob = document.getElementById('toggle-knob');

    function updateToggle() {
        if (maintenanceCheckbox.checked) {
            toggleBg.style.background = 'var(--brand)';
            toggleKnob.style.transform = 'translateX(20px)';
            maintenanceWarning.style.display = 'flex';
        } else {
            toggleBg.style.background = 'rgba(255,255,255,0.1)';
            toggleKnob.style.transform = 'translateX(0)';
            maintenanceWarning.style.display = 'none';
        }
    }

    maintenanceCheckbox.addEventListener('change', updateToggle);
    updateToggle();

    // Color picker sync
    const primaryPicker = document.getElementById('brand_color_primary_picker');
    const primaryText = document.getElementById('brand_color_primary');
    const secondaryPicker = document.getElementById('brand_color_secondary_picker');
    const secondaryText = document.getElementById('brand_color_secondary');
    const previewPrimary = document.getElementById('preview-primary');
    const previewSecondary = document.getElementById('preview-secondary');
    const previewPrimaryLabel = document.getElementById('preview-primary-label');
    const previewSecondaryLabel = document.getElementById('preview-secondary-label');

    primaryPicker.addEventListener('input', function() {
        primaryText.value = this.value;
        updatePreview(previewPrimary, this.value, previewPrimaryLabel);
    });

    primaryText.addEventListener('input', function() {
        if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
            primaryPicker.value = this.value;
            updatePreview(previewPrimary, this.value, previewPrimaryLabel);
        }
    });

    secondaryPicker.addEventListener('input', function() {
        secondaryText.value = this.value;
        updatePreview(previewSecondary, this.value, previewSecondaryLabel);
    });

    secondaryText.addEventListener('input', function() {
        if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
            secondaryPicker.value = this.value;
            updatePreview(previewSecondary, this.value, previewSecondaryLabel);
        }
    });

    function updatePreview(element, color, label) {
        element.style.background = color;
        element.style.boxShadow = `0 4px 12px ${color}40`;
        label.textContent = color;
    }
</script>
@endsection
