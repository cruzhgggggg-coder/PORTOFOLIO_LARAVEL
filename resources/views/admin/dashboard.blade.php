@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div style="max-width:1200px;">
    {{-- Header --}}
    <div style="margin-bottom:3rem;">
        <h1 style="font-size:36px; font-weight:800; letter-spacing:-0.05em; margin-bottom:10px;">Control Center</h1>
        <p style="color:rgba(255,255,255,0.4); font-size:15px;">Selamat datang kembali, <span style="color:var(--brand); font-weight:600;">{{ $profileName }}</span>. Kelola arsitektur digital kamu di sini.</p>
    </div>

    {{-- Stats Grid --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:24px; margin-bottom:3rem;">
        <div class="glass-card stat-card" style="position:relative; overflow:hidden;">
            <div style="position:absolute; top:0; right:0; padding:20px; opacity:0.1;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:60px;height:60px;">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                </svg>
            </div>
            <div style="font-size:11px; font-weight:800; letter-spacing:0.2em; text-transform:uppercase; color:rgba(255,255,255,0.3); margin-bottom:12px;">Total Works</div>
            <div style="font-size:48px; font-weight:800; color:var(--brand); letter-spacing:-0.05em; line-height:1;">{{ $totalProjects }}</div>
            <div style="margin-top:16px; font-size:12px; color:rgba(255,255,255,0.4); display:flex; align-items:center; gap:6px;">
                <div style="width:6px; height:6px; background:var(--brand); border-radius:50%;"></div>
                Digital masterpieces created
            </div>
        </div>

        <div class="glass-card stat-card" style="position:relative; overflow:hidden;">
            <div style="position:absolute; top:0; right:0; padding:20px; opacity:0.1;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:60px;height:60px;">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                </svg>
            </div>
            <div style="font-size:11px; font-weight:800; letter-spacing:0.2em; text-transform:uppercase; color:rgba(255,255,255,0.3); margin-bottom:12px;">Featured Works</div>
            <div style="font-size:48px; font-weight:800; color:#a78bfa; letter-spacing:-0.05em; line-height:1;">{{ $featuredCount }}</div>
            <div style="margin-top:16px; font-size:12px; color:rgba(255,255,255,0.4); display:flex; align-items:center; gap:6px;">
                <div style="width:6px; height:6px; background:#a78bfa; border-radius:50%;"></div>
                Highlighted on homepage
            </div>
        </div>

        <div class="glass-card stat-card" style="position:relative; overflow:hidden;">
            <div style="position:absolute; top:0; right:0; padding:20px; opacity:0.1;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:60px;height:60px;">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </div>
            <div style="font-size:11px; font-weight:800; letter-spacing:0.2em; text-transform:uppercase; color:rgba(255,255,255,0.3); margin-bottom:12px;">System Profile</div>
            <div style="font-size:20px; font-weight:800; color:#fff; letter-spacing:-0.02em; margin-top:8px; line-height:1.2;">Luminescent Architect</div>
            <div style="margin-top:20px; display:flex; align-items:center; gap:8px;">
                <a href="{{ route('admin.profile.edit') }}" style="font-size:11px; color:var(--brand); text-decoration:none; font-weight:700; text-transform:uppercase; letter-spacing:0.1em;">Edit Profile →</a>
            </div>
        </div>
    </div>

    {{-- Main Grid --}}
    <div style="display:grid; grid-template-columns: 2fr 1fr; gap:24px;">
        {{-- Recent Projects --}}
        <div class="glass-card" style="padding:0; overflow:hidden;">
            <div style="padding:24px; border-bottom:1px solid rgba(255,255,255,0.06); display:flex; justify-content:space-between; align-items:center;">
                <h2 style="font-size:15px; font-weight:800; letter-spacing:0.05em; text-transform:uppercase;">Recent Works</h2>
                <a href="{{ route('admin.projects.index') }}" class="btn-secondary" style="font-size:10px; padding:6px 12px;">View All</a>
            </div>
            <div style="padding:0;">
                @forelse($latestProjects as $project)
                <div style="padding:16px 24px; border-bottom:1px solid rgba(255,255,255,0.03); display:flex; align-items:center; gap:16px; transition:all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.01)'" onmouseout="this.style.background='transparent'">
                    <div style="width:48px; height:36px; border-radius:8px; overflow:hidden; border:1px solid rgba(255,255,255,0.05); flex-shrink:0;">
                        <img src="{{ $project->image }}" alt="" loading="lazy" decoding="async" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    <div style="flex:1; min-width:0;">
                        <div style="font-size:14px; font-weight:700; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $project->title }}</div>
                        <div style="font-size:11px; color:rgba(255,255,255,0.3); font-family:'JetBrains Mono', monospace;">{{ $project->category }}</div>
                    </div>
                    <div style="text-align:right;">
                        <a href="{{ route('admin.projects.edit', $project) }}" class="btn-secondary" style="padding:6px; border-radius:8px;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                        </a>
                    </div>
                </div>
                @empty
                <div style="padding:48px; text-align:center; color:rgba(255,255,255,0.2);">
                    No projects found.
                </div>
                @endforelse
            </div>
        </div>

        {{-- Quick Actions --}}
        <div style="display:flex; flex-direction:column; gap:24px;">
            <div class="glass-card" style="padding:24px;">
                <h3 style="font-size:12px; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; color:rgba(255,255,255,0.4); margin-bottom:20px;">Quick Actions</h3>
                <div style="display:flex; flex-direction:column; gap:12px;">
                    <a href="{{ route('admin.projects.create') }}" class="btn-primary" style="justify-content:center; width:100%;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:14px;height:14px;">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        New Project
                    </a>
                    <a href="{{ route('home') }}" target="_blank" class="btn-secondary" style="justify-content:center; width:100%;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;">
                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
                            <polyline points="15 3 21 3 21 9" />
                            <line x1="10" y1="14" x2="21" y2="3" />
                        </svg>
                        View Website
                    </a>
                </div>
            </div>

            <div class="glass-card" style="padding:24px; background:linear-gradient(135deg, rgba(0,242,255,0.05) 0%, rgba(124,58,237,0.05) 100%);">
                <h3 style="font-size:12px; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; color:rgba(255,255,255,0.4); margin-bottom:12px;">System Status</h3>
                <div style="display:flex; align-items:center; gap:8px;">
                    <div style="width:8px; height:8px; background:#10b981; border-radius:50%; box-shadow:0 0 10px #10b981;"></div>
                    <span style="font-size:13px; font-weight:600; color:#6ee7b7;">Vitals Operational</span>
                </div>
                <div style="margin-top:16px; font-size:11px; color:rgba(255,255,255,0.3); line-height:1.6;">
                    Storage: {{ round(disk_free_space("/") / (1024 * 1024 * 1024), 2) }} GB Free
                    <br>
                    Environment: {{ app()->environment() }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .stat-card {
        padding: 32px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
    }
</style>
@endsection