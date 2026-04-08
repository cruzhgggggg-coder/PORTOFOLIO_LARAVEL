@extends('admin.layout')

@section('title', 'Portfolio Analytics')

@section('content')
<div style="max-width:1400px;">
    {{-- Header --}}
    <div style="margin-bottom:2.5rem; display:flex; justify-content:space-between; align-items:end; gap:20px; flex-wrap:wrap;">
        <div>
            <h1 style="font-size:36px; font-weight:800; letter-spacing:-0.05em; margin-bottom:8px;">Deep Analytics</h1>
            <p style="color:rgba(255,255,255,0.4); font-size:14px;">Measuring the heartbeat and impact of your digital architecture.</p>
        </div>
        <div style="display:flex; gap:12px;">
            <form method="GET" action="{{ route('admin.analytics.index') }}" id="period-form">
                <select name="period" class="form-input" style="padding:10px 16px; min-width:150px;" onchange="document.getElementById('period-form').submit()">
                    <option value="7" {{ $period == 7 ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="30" {{ $period == 30 ? 'selected' : '' }}>Last 30 Days</option>
                    <option value="90" {{ $period == 90 ? 'selected' : '' }}>Last 90 Days</option>
                    <option value="365" {{ $period == 365 ? 'selected' : '' }}>Last Year</option>
                </select>
            </form>
            <button onclick="window.print()" class="btn-secondary" style="padding:10px 16px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><path d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Export PDF
            </button>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:20px; margin-bottom:2.5rem;">
        {{-- Audience Card --}}
        <div class="glass-card" style="padding:28px;">
            <div style="font-size:11px; font-weight:800; letter-spacing:0.15em; text-transform:uppercase; color:rgba(255,255,255,0.3); margin-bottom:16px;">Total Engagement</div>
            <div style="display:flex; align-items:baseline; gap:10px; margin-bottom:8px;">
                <div style="font-size:42px; font-weight:800; color:var(--brand); line-height:1;">{{ number_format($totalViews) }}</div>
                <div style="color:rgba(255,255,255,0.3); font-size:14px; font-weight:600;">Views</div>
            </div>
            <div style="display:flex; align-items:baseline; gap:10px;">
                <div style="font-size:24px; font-weight:800; color:#f472b6; line-height:1;">{{ number_format($totalLikes) }}</div>
                <div style="color:rgba(255,255,255,0.3); font-size:12px; font-weight:600;">Likes Received</div>
            </div>
            <div style="margin-top:20px; display:flex; align-items:center; gap:8px;">
                <div style="flex:1; height:4px; background:rgba(255,255,255,0.05); border-radius:10px; overflow:hidden;">
                    @php $engagementBarWidth = ($viewsToLikesRatio * 5) . '%'; @endphp
                    <div @style(['height: 100%', "width: {$engagementBarWidth}", 'background: #f472b6'])></div>
                </div>
                <div style="font-size:11px; font-weight:700; color:#f472b6;">{{ $viewsToLikesRatio }}% Engagement</div>
            </div>
        </div>

        {{-- Inbox Health --}}
        <div class="glass-card" style="padding:28px;">
            <div style="font-size:11px; font-weight:800; letter-spacing:0.15em; text-transform:uppercase; color:rgba(255,255,255,0.3); margin-bottom:16px;">Inbox Efficiency</div>
            <div style="display:flex; align-items:baseline; gap:10px; margin-bottom:8px;">
                <div style="font-size:42px; font-weight:800; color:#60a5fa; line-height:1;">{{ $replyRate }}%</div>
                <div style="color:rgba(255,255,255,0.3); font-size:14px; font-weight:600;">Reply Rate</div>
            </div>
            <div style="font-size:12px; color:rgba(255,255,255,0.4); margin-bottom:20px;">
                {{ $repliedMessages }} replied out of {{ $totalMessages }} messages
            </div>
            <div style="display:flex; align-items:center; gap:12px;">
                <div style="flex:1; text-align:center; padding:12px; background:rgba(239, 68, 68, 0.05); border-radius:12px; border:1px solid rgba(239, 68, 68, 0.1);">
                    <div style="font-size:18px; font-weight:800; color:#fca5a5;">{{ $unreadMessages }}</div>
                    <div style="font-size:9px; font-weight:700; color:rgba(239, 68, 68, 0.5); text-transform:uppercase; margin-top:4px;">Unread</div>
                </div>
                <div style="flex:1; text-align:center; padding:12px; background:rgba(16, 185, 129, 0.05); border-radius:12px; border:1px solid rgba(16, 185, 129, 0.1);">
                    <div style="font-size:18px; font-weight:800; color:#6ee7b7;">{{ $totalMessages - $unreadMessages }}</div>
                    <div style="font-size:9px; font-weight:700; color:rgba(16, 185, 129, 0.5); text-transform:uppercase; margin-top:4px;">Processed</div>
                </div>
            </div>
        </div>

        {{-- Content Balance --}}
        <div class="glass-card" style="padding:28px;">
            <div style="font-size:11px; font-weight:800; letter-spacing:0.15em; text-transform:uppercase; color:rgba(255,255,255,0.3); margin-bottom:16px;">Content Structure</div>
            <div style="display:flex; align-items:center; gap:20px; margin-bottom:20px;">
                <div style="position:relative; width:80px; height:80px;">
                    <svg viewBox="0 0 36 36" style="transform: rotate(-90deg); width:100%; height:100%;">
                        <circle cx="18" cy="18" r="16" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="4"></circle>
                        <circle cx="18" cy="18" r="16" fill="none" stroke="var(--brand)" stroke-width="4" stroke-dasharray="{{ ($featuredCount / max(1, $totalProjects)) * 100 }} 100"></circle>
                    </svg>
                    <div style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center; font-size:16px; font-weight:800; color:#fff;">{{ $featuredCount }}</div>
                </div>
                <div>
                    <div style="font-size:14px; font-weight:700; color:#fff; margin-bottom:4px;">Featured Ratio</div>
                    <div style="font-size:12px; color:rgba(255,255,255,0.4);">{{ round(($featuredCount / max(1, $totalProjects)) * 100) }}% Works Highlighted</div>
                </div>
            </div>
            <div style="display:flex; gap:10px;">
                @foreach($projectsByCategory->take(3) as $cat)
                <div style="flex:1; font-size:10px; color:rgba(255,255,255,0.3); text-align:center;">
                    <div style="font-weight:800; color:#fff; font-size:14px;">{{ $cat->total }}</div>
                    <div style="overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $cat->category }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Main Analytics Content --}}
    <div style="display:grid; grid-template-columns: 2fr 1fr; gap:24px; margin-bottom:2.5rem;">
        {{-- Traffic Visualization - Placeholder for Chart --}}
        <div class="glass-card" style="padding:32px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
                <h3 style="font-size:14px; font-weight:800; letter-spacing:0.05em; text-transform:uppercase;">Message Trends (Last {{ $period }} Days)</h3>
                <div style="display:flex; gap:16px; font-size:12px; color:rgba(255,255,255,0.4);">
                    <div style="display:flex; align-items:center; gap:6px;">
                        <div style="width:8px; height:8px; background:var(--brand); border-radius:2px;"></div> Submissions
                    </div>
                </div>
            </div>
            
            <div style="height:250px; display:flex; align-items:flex-end; gap:8px; padding-bottom:20px; border-bottom:1px solid rgba(255,255,255,0.06);">
                @php
                    $maxCount = max(1, $messagesOverTime->max('count'));
                    $days = collect();
                    for($i = $period - 1; $i >= 0; $i--) {
                        $date = now()->subDays($i)->format('Y-m-d');
                        $dayData = $messagesOverTime->firstWhere('date', $date);
                        $days->push(['date' => $date, 'count' => $dayData ? $dayData->count : 0]);
                    }
                @endphp

                @foreach($days as $day)
                @php
                    $barHeight = $maxCount > 0 ? (($day['count'] / $maxCount) * 100) . '%' : '0%';
                    $minHeight = $day['count'] > 0 ? '4px' : '0';
                    $barBg = 'linear-gradient(to top, rgba(0, 242, 255, 0.1), var(--brand))';
                @endphp
                <div style="flex:1; display:flex; flex-direction:column; align-items:center; gap:8px; height:100%; justify-content:flex-end;" title="{{ $day['date'] }}: {{ $day['count'] }} messages">
                    <div @style(['width: 100%', "height: {$barHeight}", "background: {$barBg}", 'border-radius: 4px 4px 0 0', "min-height: {$minHeight}", 'transition: all 0.3s']) 
                         onmouseover="this.style.filter='brightness(1.5)'" onmouseout="this.style.filter='none'"></div>
                </div>
                @endforeach
            </div>
            <div style="display:flex; justify-content:space-between; margin-top:12px; font-size:10px; color:rgba(255,255,255,0.2); font-family:'JetBrains Mono', monospace;">
                <span>{{ now()->subDays($period-1)->format('d M') }}</span>
                <span>{{ now()->format('d M') }} (Today)</span>
            </div>
        </div>

        {{-- Tech Stack Popularity --}}
        <div class="glass-card" style="padding:28px;">
            <h3 style="font-size:12px; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; color:rgba(255,255,255,0.4); margin-bottom:24px;">Tech Dominance</h3>
            <div style="display:flex; flex-direction:column; gap:16px;">
                @php $maxTech = max(1, count($techStackUsage) > 0 ? max($techStackUsage) : 1); @endphp
                @foreach($techStackUsage as $tech => $count)
                @php $techPercent = ($count / $maxTech) * 100; @endphp
                <div>
                    <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:6px;">
                        <span style="font-weight:700; color:#fff; text-transform:capitalize;">{{ $tech }}</span>
                        <span style="color:rgba(255,255,255,0.4);">{{ $count }} projects</span>
                    </div>
                    <div style="height:6px; background:rgba(255,255,255,0.05); border-radius:10px; overflow:hidden;">
                        @php 
                            $techPercentVal = (($count / $maxTech) * 100) . '%'; 
                            $techBg = 'linear-gradient(to right, #6366f1, #a855f7)';
                        @endphp
                        <div @style(['height: 100%', "width: {$techPercentVal}", "background: {$techBg}", 'border-radius: 10px'])></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Performance Table --}}
    <div class="glass-card" style="padding:0; overflow:hidden; margin-bottom:2.5rem;">
        <div style="padding:24px; border-bottom:1px solid rgba(255,255,255,0.06); display:flex; justify-content:space-between; align-items:center;">
            <h3 style="font-size:14px; font-weight:800; letter-spacing:0.05em; text-transform:uppercase;">Project Impact Analysis</h3>
        </div>
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr>
                    <th style="text-align:left; padding:20px 24px; font-size:10px; text-transform:uppercase; letter-spacing:0.1em; color:rgba(255,255,255,0.3); border-bottom:1px solid rgba(255,255,255,0.06);">Project</th>
                    <th style="text-align:center; padding:20px 24px; font-size:10px; text-transform:uppercase; letter-spacing:0.1em; color:rgba(255,255,255,0.3); border-bottom:1px solid rgba(255,255,255,0.06);">Visibility</th>
                    <th style="text-align:center; padding:20px 24px; font-size:10px; text-transform:uppercase; letter-spacing:0.1em; color:rgba(255,255,255,0.3); border-bottom:1px solid rgba(255,255,255,0.06);">Engagement</th>
                    <th style="text-align:center; padding:20px 24px; font-size:10px; text-transform:uppercase; letter-spacing:0.1em; color:rgba(255,255,255,0.3); border-bottom:1px solid rgba(255,255,255,0.06);">Score</th>
                    <th style="text-align:right; padding:20px 24px; font-size:10px; text-transform:uppercase; letter-spacing:0.1em; color:rgba(255,255,255,0.3); border-bottom:1px solid rgba(255,255,255,0.06);">Trend</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topViewedProjects as $project)
                <tr onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'" style="transition:all 0.2s;">
                    <td style="padding:16px 24px; border-bottom:1px solid rgba(255,255,255,0.03);">
                        <div style="font-size:14px; font-weight:700; color:#fff;">{{ $project->title }}</div>
                        <div style="font-size:11px; color:rgba(255,255,255,0.3);">{{ $project->category }}</div>
                    </td>
                    <td style="padding:16px 24px; border-bottom:1px solid rgba(255,255,255,0.03); text-align:center;">
                        <div style="font-size:16px; font-weight:800; color:#fff;">{{ number_format($project->views_count) }}</div>
                        <div style="font-size:9px; color:rgba(255,255,255,0.2); text-transform:uppercase;">Unique Views</div>
                    </td>
                    <td style="padding:16px 24px; border-bottom:1px solid rgba(255,255,255,0.03); text-align:center;">
                        <div style="font-size:16px; font-weight:800; color:#f472b6;">{{ number_format($project->likes_count) }}</div>
                        <div style="font-size:9px; color:rgba(255,255,255,0.2); text-transform:uppercase;">Likes</div>
                    </td>
                    <td style="padding:16px 24px; border-bottom:1px solid rgba(255,255,255,0.03); text-align:center;">
                        @php 
                            $score = $project->views_count > 0 ? round(($project->likes_count / $project->views_count) * 100, 1) : 0; 
                            $scoreBg = $score > 5 ? 'rgba(16, 185, 129, 0.1)' : 'rgba(255,255,255,0.03)';
                            $scoreBorder = $score > 5 ? 'rgba(16, 185, 129, 0.2)' : 'rgba(255,255,255,0.05)';
                            $scoreColor = $score > 5 ? '#6ee7b7' : '#fff';
                        @endphp
                        <div @style(['display: inline-flex', 'align-items: center', 'gap: 8px', 'padding: 4px 12px', "background: {$scoreBg}", 'border-radius: 10px', "border: 1px solid {$scoreBorder}"])>
                            <span @style(['font-size: 13px', 'font-weight: 800', "color: {$scoreColor}"])>{{ $score }}%</span>
                        </div>
                    </td>
                    <td style="padding:16px 24px; border-bottom:1px solid rgba(255,255,255,0.03); text-align:right;">
                        <div style="display:inline-flex; align-items:center; gap:4px; color:#10b981; font-size:11px; font-weight:700;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="width:12px;height:12px;"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                            Rising
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- System Architecture Details --}}
    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap:24px;">
        <div class="glass-card" style="padding:28px;">
            <h3 style="font-size:12px; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; color:rgba(255,255,255,0.4); margin-bottom:20px;">System Architecture</h3>
            <div style="display:flex; flex-direction:column; gap:16px;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:13px; color:rgba(255,255,255,0.5);">PHP Version</span>
                    <span style="font-size:13px; font-weight:700; color:var(--brand); font-family:'JetBrains Mono', monospace;">{{ PHP_VERSION }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:13px; color:rgba(255,255,255,0.5);">Laravel Core</span>
                    <span style="font-size:13px; font-weight:700; color:#fff; font-family:'JetBrains Mono', monospace;">{{ app()->version() }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:13px; color:rgba(255,255,255,0.5);">Database</span>
                    <span style="font-size:13px; font-weight:700; color:#fff; font-family:'JetBrains Mono', monospace;">{{ DB::connection()->getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME) }} {{ DB::connection()->getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION) }}</span>
                </div>
                <div style="padding:16px; background:rgba(255,255,255,0.02); border-radius:12px; margin-top:8px;">
                    <div style="display:flex; justify-content:space-between; font-size:11px; margin-bottom:8px; color:rgba(255,255,255,0.3);">
                        <span>STORAGE CAPACITY</span>
                        <span>{{ round(disk_free_space("/") / (1024 * 1024 * 1024), 2) }} GB FREE</span>
                    </div>
                    <div style="height:4px; background:rgba(255,255,255,0.05); border-radius:10px; overflow:hidden;">
                        @php 
                            $usedSpace = 100 - (disk_free_space("/") / disk_total_space("/") * 100); 
                            $usedSpaceVal = $usedSpace . '%';
                        @endphp
                        <div @style(['height: 100%', "width: {$usedSpaceVal}", 'background: var(--brand)'])></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="glass-card" style="padding:28px; background:linear-gradient(135deg, rgba(0,242,255,0.05) 0%, rgba(124,58,237,0.05) 100%);">
            <h3 style="font-size:12px; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; color:rgba(255,255,255,0.4); margin-bottom:20px;">Recent Milestones</h3>
            <div style="display:flex; flex-direction:column; gap:16px;">
                <div style="display:flex; gap:16px;">
                    <div style="width:40px; height:40px; background:rgba(0, 242, 255, 0.1); border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="var(--brand)" stroke-width="2" style="width:20px;height:20px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <div>
                        <div style="font-size:13px; font-weight:700; color:#fff;">{{ $recentActivity['new_projects'] }} New Projects</div>
                        <div style="font-size:11px; color:rgba(255,255,255,0.3);">Published in the last 7 days</div>
                    </div>
                </div>
                <div style="display:flex; gap:16px;">
                    <div style="width:40px; height:40px; background:rgba(168, 85, 247, 0.1); border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#a855f7" stroke-width="2" style="width:20px;height:20px;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <div>
                        <div style="font-size:13px; font-weight:700; color:#fff;">{{ $recentActivity['new_messages'] }} Inquiries</div>
                        <div style="font-size:11px; color:rgba(255,255,255,0.3);">Collected from prospective clients</div>
                    </div>
                </div>
                <div style="display:flex; gap:16px;">
                    <div style="width:40px; height:40px; background:rgba(16, 185, 129, 0.1); border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" style="width:20px;height:20px;"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <div>
                        <div style="font-size:13px; font-weight:700; color:#fff;">{{ $recentActivity['replied_messages'] }} Responses</div>
                        <div style="font-size:11px; color:rgba(255,255,255,0.3);">Successfully handled inquiries</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .admin-sidebar, #period-form, button { display: none !important; }
        .admin-main { margin-left: 0 !important; padding: 0 !important; }
        .glass-card { border: 1px solid #ddd !important; background: #fff !important; color: #000 !important; box-shadow: none !important; }
        h1, h2, h3, div, span, td, th { color: #000 !important; }
        .glass-card * { color: #000 !important; }
    }
</style>
@endsection
