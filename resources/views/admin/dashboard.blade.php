@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div @style(['max-width: 1400px', '--accent: ' . ($unreadMessages > 0 ? '#f59e0b' : 'var(--brand)')])>
    {{-- Header with Search & Clock --}}
    <div style="margin-bottom:3.5rem; display:flex; justify-content:space-between; align-items:flex-start; gap:40px; flex-wrap:wrap;">
        <div style="flex:1; min-width:300px;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
                <h1 style="font-size:48px; font-weight:800; letter-spacing:-0.05em; line-height:1; margin:0;">Nexus <span style="color:var(--brand);">OS</span></h1>
                @if($maintenanceMode)
                <span style="background:rgba(239,68,68,0.1); color:#f87171; font-size:10px; font-weight:800; padding:4px 12px; border-radius:20px; border:1px solid rgba(239,68,68,0.2); letter-spacing:0.1em; text-transform:uppercase;">Maintenance Active</span>
                @else
                <span style="background:rgba(16,185,129,0.1); color:#6ee7b7; font-size:10px; font-weight:800; padding:4px 12px; border-radius:20px; border:1px solid rgba(16,185,129,0.2); letter-spacing:0.1em; text-transform:uppercase;">System Online</span>
                @endif
            </div>
            <p style="color:rgba(255,255,255,0.4); font-size:16px; margin:0;">Operational intelligence for <span style="color:#fff; font-weight:600;">{{ $profileName }}</span>'s architectural matrix.</p>
        </div>

        <div style="display:flex; align-items:center; gap:24px;">
            {{-- Digital Clock --}}
            <div style="text-align:right; font-family:'JetBrains Mono', monospace;">
                <div id="dashboard-clock" style="font-size:24px; font-weight:800; color:#fff; letter-spacing:0.05em;">00:00:00</div>
                <div style="font-size:10px; color:rgba(255,255,255,0.3); text-transform:uppercase; letter-spacing:0.2em;">System Time</div>
            </div>

            {{-- Breadcrumbs/Quick Navigation --}}
            <div style="display:flex; gap:10px;">
                <a href="{{ route('admin.settings.index') }}" class="glass-card nav-icon-btn" style="padding:12px; border-radius:12px; display:flex; align-items:center; justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:20px;height:20px;color:rgba(255,255,255,0.5);"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                </a>
            </div>
        </div>
    </div>

    {{-- Performance Matrix --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:24px; margin-bottom:3.5rem;">
        {{-- Total Visibility --}}
        <div class="glass-card stat-card" style="--card-color: var(--brand); text-decoration:none;">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </div>
            <div class="stat-label">Total Visibility</div>
            <div class="stat-value">{{ number_format($totalViews) }}</div>
            <div class="stat-footer">
                <span class="trend-up">+{{ $messagesLast7Days * 5 }}%</span> vs last month
            </div>
            <div class="stat-progress"><div style="width: 75%;"></div></div>
        </div>

        {{-- Engagement Velocity --}}
        <div class="glass-card stat-card" style="--card-color: #f472b6; text-decoration:none;">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            </div>
            <div class="stat-label">Social Impact</div>
            <div class="stat-value">{{ number_format($totalLikes) }}</div>
            <div class="stat-footer">
                <span class="trend-up">Positive</span> project feedback
            </div>
            <div class="stat-progress"><div style="width: 45%; background: #f472b6;"></div></div>
        </div>

        {{-- Communication Flow --}}
        <a href="{{ route('admin.messages.index') }}" class="glass-card stat-card" style="--card-color: var(--accent); text-decoration:none;">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div class="stat-label">Inquiry Flow</div>
            <div class="stat-value">{{ $unreadMessages }}</div>
            <div class="stat-footer">
                @php $trendColor = $messageTrend >= 0 ? '#10b981' : '#ef4444'; @endphp
                <span @style(['color: ' . $trendColor, 'font-weight: 800'])>{{ $messageTrend >= 0 ? '+' : '' }}{{ $messageTrend }}%</span> frequency shift
            </div>
            @if($unreadMessages > 0)
            <div class="stat-badge" style="background:#ef4444; box-shadow:0 0 15px rgba(239,68,68,0.5);">urgent</div>
            @endif
            @php $progressWidth = min(100, ($unreadMessages / max(1, $totalMessages)) * 100); @endphp
            <div class="stat-progress"><div @style(['width: ' . $progressWidth . '%', 'background: var(--accent)'])></div></div>
        </a>

        {{-- Knowledge Inventory --}}
        <a href="{{ route('admin.skills.index') }}" class="glass-card stat-card" style="--card-color: #a78bfa; text-decoration:none;">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a4 4 0 0 0-4-4H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a4 4 0 0 1 4-4h6z"/></svg>
            </div>
            <div class="stat-label">Knowledge Matrix</div>
            <div class="stat-value" style="font-size:32px; display:flex; gap:12px;">
                <span>{{ $totalProjects }}<sub style="font-size:10px; color:rgba(255,255,255,0.3);">PRJ</sub></span>
                <span>{{ $activeSkills }}<sub style="font-size:10px; color:rgba(255,255,255,0.3);">SKL</sub></span>
            </div>
            <div class="stat-footer">
                 Structural content density
            </div>
            <div class="stat-progress"><div style="width: 88%; background: #a78bfa;"></div></div>
        </a>
    </div>

    {{-- Main Activity Center --}}
    <div style="display:grid; grid-template-columns: 2fr 1fr; gap:32px; margin-bottom:3.5rem;">
        {{-- Activity Stream --}}
        <div class="glass-card" style="padding:0; overflow:hidden;">
            <div style="padding:28px; border-bottom:1px solid rgba(255,255,255,0.06); display:flex; justify-content:space-between; align-items:center;">
                <h2 style="font-size:16px; font-weight:800; letter-spacing:0.05em; text-transform:uppercase;">Recent Architecture</h2>
                <div style="display:flex; gap:12px;">
                    <a href="{{ route('admin.projects.create') }}" class="btn-primary" style="padding:8px 16px; font-size:11px;">Init Build</a>
                </div>
            </div>
            <div style="padding:0;">
                @forelse($latestProjects as $project)
                <div class="activity-row">
                    <div class="activity-img">
                        <img src="{{ $project->image }}" alt="">
                    </div>
                    <div style="flex:1; min-width:0;">
                         <div class="activity-title">{{ $project->title }}</div>
                         <div class="activity-meta">Category: {{ $project->category }} · <span style="color:rgba(255,255,255,0.15);">{{ $project->created_at->format('M d, Y') }}</span></div>
                    </div>
                    <div class="activity-stats">
                        <div style="text-align:right;">
                            <div style="font-size:15px; font-weight:800; color:var(--brand);">{{ number_format($project->views_count) }}</div>
                            <div style="font-size:9px; color:rgba(255,255,255,0.2); text-transform:uppercase;">Views</div>
                        </div>
                        <a href="{{ route('admin.projects.edit', $project) }}" class="activity-btn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                        </a>
                    </div>
                </div>
                @empty
                <div style="padding:80px; text-align:center; color:rgba(255,255,255,0.15);">No projects detected in local storage.</div>
                @endforelse
            </div>
            <a href="{{ route('admin.projects.index') }}" style="display:block; padding:16px; text-align:center; background:rgba(255,255,255,0.02); text-decoration:none; color:rgba(255,255,255,0.4); font-size:12px; font-weight:600; border-top:1px solid rgba(255,255,255,0.04);">View All Infrastructure</a>
        </div>

        {{-- Sidebar Widgets --}}
        <div style="display:flex; flex-direction:column; gap:32px;">
            {{-- Quick Command Center --}}
            <div class="glass-card" style="padding:28px;">
                <h3 style="font-size:12px; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; color:rgba(255,255,255,0.4); margin-bottom:24px;">Command Center</h3>
                <div style="display:grid; grid-template-columns: 1fr; gap:12px;">
                    <a href="{{ route('admin.messages.index') }}" class="command-btn">
                        <span class="cmd-icon" style="background:rgba(245, 158, 11, 0.1); color:#f59e0b;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></span>
                        <div style="flex:1;">
                            <div style="font-size:13px; font-weight:700; color:#fff;">Review Comms</div>
                            <div style="font-size:10px; color:rgba(255,255,255,0.3);">{{ $unreadMessages }} unread messages</div>
                        </div>
                    </a>
                    <a href="{{ route('admin.seo.index') }}" class="command-btn">
                        <span class="cmd-icon" style="background:rgba(16, 185, 129, 0.1); color:#10b981;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v10m0 0l-4-4m4 4l4-4M5 20h14"/></svg></span>
                        <div style="flex:1;">
                            <div style="font-size:13px; font-weight:700; color:#fff;">Optimize SEO</div>
                            <div style="font-size:10px; color:rgba(255,255,255,0.3);">Global search parameters</div>
                        </div>
                    </a>
                    <a href="{{ route('admin.projects.index') }}" class="command-btn">
                        <span class="cmd-icon" style="background:rgba(0, 242, 255, 0.1); color:var(--brand);"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2v11z"/></svg></span>
                        <div style="flex:1;">
                            <div style="font-size:13px; font-weight:700; color:#fff;">Infrastructure</div>
                            <div style="font-size:10px; color:rgba(255,255,255,0.3);">Manage project matrix</div>
                        </div>
                    </a>
                </div>
            </div>

            {{-- System Metrics --}}
            <div class="glass-card" style="padding:28px; background:rgba(0,0,0,0.2);">
                <h3 style="font-size:11px; font-weight:800; letter-spacing:0.15em; text-transform:uppercase; color:rgba(255,255,255,0.3); margin-bottom:20px;">System Core</h3>
                <div style="display:flex; flex-direction:column; gap:16px;">
                    <div class="metric-line">
                        <span>CPU Load</span>
                        <div class="metric-val"><div style="width: 12%;"></div></div>
                        <span style="color:#6ee7b7;">Stable</span>
                    </div>
                    <div class="metric-line">
                        <span>Storage</span>
                        <div class="metric-val"><div style="width: 45%; background:var(--brand);"></div></div>
                        <span>45%</span>
                    </div>
                    <div style="padding-top:12px; border-top:1px solid rgba(255,255,255,0.05); font-family:'JetBrains Mono', monospace; font-size:9px; color:rgba(255,255,255,0.2);">
                        ENV: {{ app()->environment() }} · LATENCY: 24ms
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Most Viewed Terminal Style --}}
    <div class="glass-card" style="padding:28px; background:#000; border:1px solid rgba(0, 242, 255, 0.1);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
             <h3 style="font-size:11px; font-weight:800; letter-spacing:0.2em; text-transform:uppercase; color:var(--brand); display:flex; align-items:center; gap:8px;">
                <span style="display:inline-block; width:6px; height:6px; background:var(--brand); border-radius:50%; animation: pulse 2s infinite;"></span>
                Top Performing Entities
             </h3>
             <span style="font-family:'JetBrains Mono', monospace; font-size:10px; color:rgba(0, 242, 255, 0.4);">DATASET_V4.0</span>
        </div>
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:20px;">
            @foreach($mostViewedProjects->take(4) as $index => $p)
            <div style="padding:16px; background:rgba(255,255,255,0.02); border-radius:8px; border-left:3px solid var(--brand);">
                <div style="font-size:10px; color:rgba(255,255,255,0.2); margin-bottom:4px;">#0{{ $index + 1 }}</div>
                <div style="font-size:13px; font-weight:700; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom:8px;">{{ $p->title }}</div>
                <div style="font-family:'JetBrains Mono', monospace; font-size:14px; font-weight:800; color:var(--brand);">{{ number_format($p->views_count) }} <span style="font-size:9px; font-weight:400; color:rgba(255,255,255,0.3);">REQ</span></div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .stat-card {
        padding: 32px;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.19, 1, 0.22, 1);
    }
    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 100px; height: 100px;
        background: radial-gradient(circle at 100% 0%, var(--card-color) 0%, transparent 70%);
        opacity: 0.15;
    }
    .stat-icon {
        width: 48px; height: 48px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 24px;
        color: var(--card-color);
        transition: all 0.3s;
    }
    .stat-card:hover .stat-icon {
        background: var(--card-color);
        color: #fff;
        box-shadow: 0 0 20px var(--card-color);
    }
    .stat-label {
        font-size: 11px; font-weight: 800; letter-spacing: 0.15em; text-transform: uppercase; color: rgba(255,255,255,0.3); margin-bottom: 8px;
    }
    .stat-value {
        font-size: 42px; font-weight: 800; color: #fff; letter-spacing: -0.05em; line-height: 1; margin-bottom: 20px;
    }
    .stat-footer {
        font-size: 12px; color: rgba(255,255,255,0.4);
    }
    .stat-badge {
        position: absolute; top: 20px; right: 20px;
        font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em;
        padding: 4px 10px; border-radius: 20px;
        color: #fff;
    }
    .trend-up { color: #10b981; font-weight: 800; }
    .stat-progress {
        height: 4px; background: rgba(255,255,255,0.05); border-radius: 10px; overflow: hidden; margin-top: 16px;
    }
    .stat-progress div { height: 100%; background: var(--brand); border-radius: 10px; }

    .activity-row {
        padding: 20px 28px; border-bottom: 1px solid rgba(255,255,255,0.03);
        display: flex; align-items: center; gap: 24px;
        transition: all 0.3s;
    }
    .activity-row:hover { background: rgba(255,255,255,0.02); }
    .activity-img {
        width: 80px; height: 50px; border-radius: 8px; overflow: hidden; border: 1px solid rgba(255,255,255,0.05); flex-shrink: 0;
    }
    .activity-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
    .activity-row:hover .activity-img img { transform: scale(1.1); }
    .activity-title { font-size: 15px; font-weight: 700; color: #fff; margin-bottom: 4px; }
    .activity-meta { font-size: 11px; color: rgba(255,255,255,0.3); }
    .activity-stats { display: flex; align-items: center; gap: 24px; }
    .activity-btn {
        width: 36px; height: 36px; border-radius: 10px; background: rgba(255,255,255,0.03);
        display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.5);
        transition: all 0.3s;
    }
    .activity-btn:hover { background: var(--brand); color: #000; }
    .activity-btn svg { width: 16px; height: 16px; }

    .command-btn {
        display: flex; align-items: center; gap: 16px; padding: 16px;
        background: rgba(255,255,255,0.02); border-radius: 12px;
        text-decoration: none; transition: all 0.3s;
        border: 1px solid transparent;
    }
    .command-btn:hover { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.05); transform: translateX(5px); }
    .cmd-icon {
        width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;
    }
    .cmd-icon svg { width: 20px; height: 20px; }

    .metric-line { display: flex; align-items: center; gap: 12px; font-size: 11px; color: rgba(255,255,255,0.4); }
    .metric-val { flex: 1; height: 4px; background: rgba(255,255,255,0.05); border-radius: 10px; overflow: hidden; }
    .metric-val div { height: 100%; background: #6ee7b7; border-radius: 10px; }

    .nav-icon-btn:hover { background: rgba(255,255,255,0.05); }

    @keyframes pulse {
        0% { opacity: 0.4; }
        50% { opacity: 1; }
        100% { opacity: 0.4; }
    }
</style>

<script>
    function updateClock() {
        const now = new Date();
        const time = now.getHours().toString().padStart(2, '0') + ':' + 
                     now.getMinutes().toString().padStart(2, '0') + ':' + 
                     now.getSeconds().toString().padStart(2, '0');
        document.getElementById('dashboard-clock').textContent = time;
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
@endsection