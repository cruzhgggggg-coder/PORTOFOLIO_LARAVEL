@extends('admin.layout')

@section('title', 'SEO Manager')

@section('content')
<div style="max-width:1200px;">
    {{-- Header --}}
    <div style="margin-bottom:2.5rem;">
        <h1 style="font-size:32px; font-weight:800; letter-spacing:-0.04em; margin-bottom:8px;">SEO Manager</h1>
        <p style="color:rgba(255,255,255,0.4); font-size:14px;">Manage meta tags and search optimization for each page</p>
    </div>

    {{-- Pages Grid --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(300px, 1fr)); gap:20px;">
        @foreach($pages as $key => $page)
        <a href="{{ route('admin.seo.edit', ['pageKey' => $key]) }}" class="seo-page-card" style="text-decoration:none; display:block;">
            <div class="glass-card" style="padding:24px; transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1); height:100%;">
                {{-- Page Icon & Name --}}
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:16px;">
                    <div style="width:40px; height:40px; background:var(--brand-muted); border:1px solid rgba(0,242,255,0.2); border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="var(--brand)" stroke-width="2" style="width:20px; height:20px;">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                    </div>
                    <div>
                        <div style="font-size:16px; font-weight:700; color:#fff;">{{ $page['name'] }}</div>
                        <div style="font-size:10px; color:rgba(255,255,255,0.3); font-family:'JetBrains Mono', monospace; text-transform:uppercase; letter-spacing:0.1em; font-weight:700;">{{ $page['route'] ?? 'Static Page' }}</div>
                    </div>
                </div>

                {{-- Meta Title --}}
                <div style="margin-bottom:12px;">
                    <div style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:rgba(255,255,255,0.25); margin-bottom:4px;">Meta Title</div>
                    <div style="font-size:13px; color:rgba(255,255,255,0.6); line-height:1.4;">
                        @if(!empty($page['seoSetting']->meta_title))
                        {{ $page['seoSetting']->meta_title }}
                        @else
                        <span style="color:rgba(239,68,68,0.5); font-style:italic;">Not set</span>
                        @endif
                    </div>
                </div>

                {{-- Meta Description --}}
                <div style="margin-bottom:16px;">
                    <div style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:rgba(255,255,255,0.25); margin-bottom:4px;">Meta Description</div>
                    <div style="font-size:12px; color:rgba(255,255,255,0.4); line-height:1.5;">
                        @if(!empty($page['seoSetting']->meta_description))
                        {{ Str::limit($page['seoSetting']->meta_description, 100) }}
                        @else
                        <span style="color:rgba(239,68,68,0.5); font-style:italic;">Not set</span>
                        @endif
                    </div>
                </div>

                {{-- Status Badges --}}
                <div style="display:flex; gap:8px; flex-wrap:wrap;">
                    @if(!empty($page['seoSetting']->meta_title) && !empty($page['seoSetting']->meta_description))
                    <span style="background:rgba(16,185,129,0.1); color:#6ee7b7; border:1px solid rgba(16,185,129,0.2); font-size:9px; padding:3px 10px; border-radius:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em;">Optimized</span>
                    @else
                    <span style="background:rgba(245,158,11,0.1); color:#fbbf24; border:1px solid rgba(245,158,11,0.2); font-size:9px; padding:3px 10px; border-radius:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em;">Needs Attention</span>
                    @endif
                    @if(!empty($page['seoSetting']->no_index))
                    <span style="background:rgba(239,68,68,0.1); color:#f87171; border:1px solid rgba(239,68,68,0.2); font-size:9px; padding:3px 10px; border-radius:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em;">No Index</span>
                    @endif
                </div>

                {{-- Edit Link --}}
                <div style="margin-top:16px; padding-top:16px; border-top:1px solid rgba(255,255,255,0.06); display:flex; align-items:center; gap:8px; color:var(--brand); font-size:12px; font-weight:600;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px; height:14px;">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                    Edit SEO Settings
                </div>
            </div>
        </a>
        @endforeach
    </div>

    {{-- Empty State --}}
    @if(empty($pages))
    <div class="glass-card" style="padding:64px; text-align:center; color:rgba(255,255,255,0.2);">
        <div style="font-size:64px; margin-bottom:16px; opacity:0.3;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:64px; height:64px; margin:0 auto; display:block;">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
        </div>
        <div style="font-size:18px; font-weight:700; margin-bottom:8px; color:rgba(255,255,255,0.4);">No pages configured</div>
        <p style="font-size:14px; color:rgba(255,255,255,0.25);">Configure your pages in the controller to manage their SEO settings.</p>
    </div>
    @endif
</div>

<style>
    .seo-page-card:hover .glass-card {
        border-color: rgba(0, 242, 255, 0.25);
        box-shadow: 0 10px 40px rgba(0, 242, 255, 0.08), 0 0 0 1px rgba(0, 242, 255, 0.1);
        transform: translateY(-2px);
    }
</style>
@endsection
