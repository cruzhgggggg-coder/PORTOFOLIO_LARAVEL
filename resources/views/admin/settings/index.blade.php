@extends('admin.layout')

@section('title', 'Site Settings')

@php
    // Helper to get setting value safely
    $settingVal = function($key, $default = '') use ($settings) {
        $item = $settings->get($key);
        return $item ? $item->value : $default;
    };
    $settingBool = function($key, $default = false) use ($settings) {
        $item = $settings->get($key);
        return $item ? (bool) $item->value : $default;
    };
@endphp

@section('content')
<div style="width:100%;">
    {{-- Header --}}
    <div style="margin-bottom:2.5rem;">
        <h1 style="font-size:32px; font-weight:800; letter-spacing:-0.04em; margin-bottom:8px;">Site Settings</h1>
        <p style="color:rgba(255,255,255,0.4); font-size:14px;">Configure general settings, display toggles, contact information, and optimization preferences.</p>
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
                    <input type="text" id="site_name" name="site_name" value="{{ old('site_name', $settingVal('site_name')) }}" class="form-input" placeholder="My Portfolio" />
                    <div style="font-size:11px; color:rgba(255,255,255,0.25); margin-top:6px;">Displayed in browser tab and header</div>
                </div>

                {{-- Site Tagline --}}
                <div>
                    <label class="form-label" for="site_tagline">Site Tagline</label>
                    <input type="text" id="site_tagline" name="site_tagline" value="{{ old('site_tagline', $settingVal('site_tagline')) }}" class="form-input" placeholder="Building the future, one line at a time" />
                    <div style="font-size:11px; color:rgba(255,255,255,0.25); margin-top:6px;">Short description of your portfolio</div>
                </div>
            </div>

            {{-- Projects Per Page --}}
            <div style="margin-bottom:20px;">
                <label class="form-label" for="projects_per_page">Projects Per Page</label>
                <input type="number" id="projects_per_page" name="projects_per_page" value="{{ old('projects_per_page', $settingVal('projects_per_page', 9)) }}" class="form-input" min="1" max="50" style="max-width:200px;" />
                <div style="font-size:11px; color:rgba(255,255,255,0.25); margin-top:6px;">Number of projects displayed per page on the portfolio page</div>
            </div>

            {{-- Maintenance Mode --}}
            <div style="padding:16px; background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.06); border-radius:12px; display:flex; align-items:flex-start; gap:12px;">
                <div style="position:relative; flex-shrink:0;">
                    <input type="checkbox" id="maintenance_mode" name="maintenance_mode" value="1" {{ old('maintenance_mode', $settingBool('maintenance_mode')) ? 'checked' : '' }} class="sr-only" />
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
            <div id="maintenance-warning" @style([
                'margin-top:12px; padding:12px 16px; background:rgba(245,158,11,0.1); border:1px solid rgba(245,158,11,0.2); border-radius:10px; display:flex; align-items:center; gap:10px;',
                'display: none' => !old('maintenance_mode', $settingBool('maintenance_mode'))
            ])>
                <svg viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="2" style="width:18px; height:18px; flex-shrink:0;">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                    <line x1="12" y1="9" x2="12" y2="13" />
                    <line x1="12" y1="17" x2="12.01" y2="17" />
                </svg>
                <span style="font-size:13px; font-weight:500; color:#fbbf24;">Maintenance mode is enabled. The site will be inaccessible to regular visitors.</span>
            </div>
        </div>

        {{-- Section 2: Display Toggles --}}
        <div class="glass-card" style="padding:28px; margin-bottom:24px;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
                <div style="width:36px; height:36px; background:rgba(168,85,247,0.15); border:1px solid rgba(168,85,247,0.2); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#a855f7" stroke-width="2" style="width:18px; height:18px;">
                        <rect x="3" y="3" width="18" height="18" rx="2" />
                        <path d="M3 9h18M9 21V9" />
                    </svg>
                </div>
                <div>
                    <div style="font-size:16px; font-weight:700; color:#fff;">Display Toggles</div>
                    <div style="font-size:11px; color:rgba(255,255,255,0.3);">Control which sections appear on the portfolio</div>
                </div>
            </div>

            <div style="display:flex; flex-direction:column; gap:14px;">
                {{-- Show Tech Marquee --}}
                <div style="padding:14px 16px; background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.06); border-radius:12px; display:flex; align-items:center; justify-content:space-between;">
                    <div>
                        <div style="font-size:14px; font-weight:600; color:#fff;">Tech Marquee</div>
                        <div style="font-size:11px; color:rgba(255,255,255,0.3);">Scrolling technology stack banner on homepage</div>
                    </div>
                    <label style="position:relative; display:inline-block; width:44px; height:24px; flex-shrink:0;">
                        <input type="checkbox" name="show_tech_marquee" value="1" {{ old('show_tech_marquee', $settingBool('show_tech_marquee', true)) ? 'checked' : '' }} style="opacity:0; width:0; height:0;" class="display-toggle">
                        <span class="toggle-track" style="position:absolute; cursor:pointer; top:0; left:0; right:0; bottom:0; background:rgba(255,255,255,0.1); border-radius:24px; transition:0.3s;"></span>
                        <span class="toggle-thumb" style="position:absolute; height:18px; width:18px; left:3px; bottom:3px; background:white; border-radius:50%; transition:0.3s;"></span>
                    </label>
                </div>

                {{-- Show Features Section --}}
                <div style="padding:14px 16px; background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.06); border-radius:12px; display:flex; align-items:center; justify-content:space-between;">
                    <div>
                        <div style="font-size:14px; font-weight:600; color:#fff;">Features Section</div>
                        <div style="font-size:11px; color:rgba(255,255,255,0.3);">"Built on Excellence" cards on homepage</div>
                    </div>
                    <label style="position:relative; display:inline-block; width:44px; height:24px; flex-shrink:0;">
                        <input type="checkbox" name="show_features_section" value="1" {{ old('show_features_section', $settingBool('show_features_section', true)) ? 'checked' : '' }} style="opacity:0; width:0; height:0;" class="display-toggle">
                        <span class="toggle-track" style="position:absolute; cursor:pointer; top:0; left:0; right:0; bottom:0; background:rgba(255,255,255,0.1); border-radius:24px; transition:0.3s;"></span>
                        <span class="toggle-thumb" style="position:absolute; height:18px; width:18px; left:3px; bottom:3px; background:white; border-radius:50%; transition:0.3s;"></span>
                    </label>
                </div>

                {{-- Enable Certificates --}}
                <div style="padding:14px 16px; background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.06); border-radius:12px; display:flex; align-items:center; justify-content:space-between;">
                    <div>
                        <div style="font-size:14px; font-weight:600; color:#fff;">Certificates Section</div>
                        <div style="font-size:11px; color:rgba(255,255,255,0.3);">Horizontal scroll certificates gallery on homepage</div>
                    </div>
                    <label style="position:relative; display:inline-block; width:44px; height:24px; flex-shrink:0;">
                        <input type="checkbox" name="enable_certificates" value="1" {{ old('enable_certificates', $settingBool('enable_certificates', true)) ? 'checked' : '' }} style="opacity:0; width:0; height:0;" class="display-toggle">
                        <span class="toggle-track" style="position:absolute; cursor:pointer; top:0; left:0; right:0; bottom:0; background:rgba(255,255,255,0.1); border-radius:24px; transition:0.3s;"></span>
                        <span class="toggle-thumb" style="position:absolute; height:18px; width:18px; left:3px; bottom:3px; background:white; border-radius:50%; transition:0.3s;"></span>
                    </label>
                </div>

                {{-- Auto Optimize Images --}}
                <div style="padding:14px 16px; background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.06); border-radius:12px; display:flex; align-items:center; justify-content:space-between;">
                    <div>
                        <div style="font-size:14px; font-weight:600; color:#fff;">Auto-Optimize Images</div>
                        <div style="font-size:11px; color:rgba(255,255,255,0.3);">Automatically compress and convert uploaded images to WebP</div>
                    </div>
                    <label style="position:relative; display:inline-block; width:44px; height:24px; flex-shrink:0;">
                        <input type="checkbox" name="auto_optimize_images" value="1" {{ old('auto_optimize_images', $settingBool('auto_optimize_images', true)) ? 'checked' : '' }} style="opacity:0; width:0; height:0;" class="display-toggle">
                        <span class="toggle-track" style="position:absolute; cursor:pointer; top:0; left:0; right:0; bottom:0; background:rgba(255,255,255,0.1); border-radius:24px; transition:0.3s;"></span>
                        <span class="toggle-thumb" style="position:absolute; height:18px; width:18px; left:3px; bottom:3px; background:white; border-radius:50%; transition:0.3s;"></span>
                    </label>
                </div>
            </div>
        </div>

        {{-- Section 3: Tech Marquee Content --}}
        <div class="glass-card" style="padding:28px; margin-bottom:24px;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
                <div style="width:36px; height:36px; background:rgba(0,242,255,0.1); border:1px solid rgba(0,242,255,0.2); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="var(--brand)" stroke-width="2" style="width:18px; height:18px;">
                        <polyline points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
                    </svg>
                </div>
                <div>
                    <div style="font-size:16px; font-weight:700; color:#fff;">Marquee Content</div>
                    <div style="font-size:11px; color:rgba(255,255,255,0.3);">Customize scrolling text banners</div>
                </div>
            </div>

            <div style="margin-bottom:20px;">
                <label class="form-label" for="tech_marquee_items">Tech Stack Marquee</label>
                <input type="text" id="tech_marquee_items" name="tech_marquee_items" value="{{ old('tech_marquee_items', $settingVal('tech_marquee_items', 'Laravel, React, Vue.js, TypeScript, Three.js, Tailwind, Node.js, PostgreSQL, Docker, AWS')) }}" class="form-input" placeholder="Laravel, React, Vue.js, TypeScript, Three.js" />
                <div style="font-size:11px; color:rgba(255,255,255,0.25); margin-top:6px;">Comma-separated list of technologies. These scroll horizontally on the homepage.</div>
            </div>

            <div>
                <label class="form-label" for="footer_marquee_text">Footer Marquee Text</label>
                <input type="text" id="footer_marquee_text" name="footer_marquee_text" value="{{ old('footer_marquee_text', $settingVal('footer_marquee_text', 'Luminescent Architect, Digital Craftsman, Full-Stack Developer, UI/UX Engineer')) }}" class="form-input" placeholder="Brand Name, Role 1, Role 2" />
                <div style="font-size:11px; color:rgba(255,255,255,0.25); margin-top:6px;">Comma-separated text for the footer marquee banner.</div>
            </div>
        </div>

        {{-- Section 4: Contact Information --}}
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
                    <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', $settingVal('contact_email')) }}" class="form-input" placeholder="hello@example.com" />
                    <div style="font-size:11px; color:rgba(255,255,255,0.25); margin-top:6px;">Public-facing contact email</div>
                </div>

                {{-- Contact Phone --}}
                <div>
                    <label class="form-label" for="contact_phone">Contact Phone</label>
                    <input type="text" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $settingVal('contact_phone')) }}" class="form-input" placeholder="+1 (555) 123-4567" />
                    <div style="font-size:11px; color:rgba(255,255,255,0.25); margin-top:6px;">Include country code for international</div>
                </div>
            </div>

            {{-- Address --}}
            <div>
                <label class="form-label" for="address">Address</label>
                <textarea id="address" name="address" rows="2" class="form-input" placeholder="123 Main Street, City, Country">{{ old('address', $settingVal('address')) }}</textarea>
                <div style="font-size:11px; color:rgba(255,255,255,0.25); margin-top:6px;">Your physical location or office address</div>
            </div>
        </div>

        {{-- Submit Button --}}
        <div style="display:flex; justify-content:flex-end; gap:12px; padding-top:8px;">
            <button type="button" onclick="confirmOptimization()" class="btn-secondary" style="padding:14px 24px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px; height:16px;">
                    <rect x="3" y="3" width="18" height="18" rx="2" /><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
                </svg>
                Optimize Images
            </button>
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

    function updateMaintenanceToggle() {
        if (maintenanceCheckbox.checked) {
            maintenanceWarning.style.display = 'flex';
        } else {
            maintenanceWarning.style.display = 'none';
        }
    }
    maintenanceCheckbox.addEventListener('change', updateMaintenanceToggle);

    // Display toggle switches
    document.querySelectorAll('.display-toggle').forEach(function(toggle) {
        const track = toggle.parentElement.querySelector('.toggle-track');
        const thumb = toggle.parentElement.querySelector('.toggle-thumb');

        function update() {
            if (toggle.checked) {
                track.style.background = 'var(--brand)';
                thumb.style.transform = 'translateX(20px)';
            } else {
                track.style.background = 'rgba(255,255,255,0.1)';
                thumb.style.transform = 'translateX(0)';
            }
        }

        toggle.addEventListener('change', update);
        update();
    });

    // Initialize maintenance toggle
    (function() {
        const track = maintenanceCheckbox.parentElement.querySelector('label');
        const knob = document.getElementById('toggle-knob');
        if (maintenanceCheckbox.checked) {
            track.style.background = 'var(--brand)';
            knob.style.transform = 'translateX(20px)';
        }
    })();

    function confirmOptimization() {
        if (confirm('Run bulk image optimization now? This will process all profile and project images to ensure they are compressed and in WebP format. This might take a few seconds.')) {
            document.getElementById('optimize-form').submit();
        }
    }
</script>

{{-- Hidden Optimization Form --}}
<form id="optimize-form" action="{{ route('admin.settings.optimize-images') }}" method="POST" style="display:none;">
    @csrf
</form>
@endsection
