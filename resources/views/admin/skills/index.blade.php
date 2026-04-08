@extends('admin.layout')

@section('title', 'Skills & Expertise')

@section('content')
<div style="max-width:1400px;">
    <div style="margin-bottom:2.5rem; display:flex; justify-content:space-between; align-items:end;">
        <div>
            <h1 style="font-size:36px; font-weight:800; letter-spacing:-0.05em; margin-bottom:8px;">Skills & Expertise</h1>
            <p style="color:rgba(255,255,255,0.4); font-size:14px;">Manage your technical skills and proficiency levels</p>
        </div>
        <a href="{{ route('admin.skills.create') }}" class="btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:14px;height:14px;">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Add Skill
        </a>
    </div>

    {{-- Filters --}}
    <div class="glass-card" style="padding:20px 24px; margin-bottom:24px;">
        <form method="GET" action="{{ route('admin.skills.index') }}" style="display:flex; gap:16px; align-items:end;">
            <div style="flex:1;">
                <label class="form-label" style="margin-bottom:6px;">Category</label>
                <select name="category" class="form-input" style="padding:10px 14px;">
                    <option value="">All Categories</option>
                    <option value="frontend" {{ request('category') === 'frontend' ? 'selected' : '' }}>Frontend</option>
                    <option value="backend" {{ request('category') === 'backend' ? 'selected' : '' }}>Backend</option>
                    <option value="tools" {{ request('category') === 'tools' ? 'selected' : '' }}>Tools</option>
                    <option value="soft" {{ request('category') === 'soft' ? 'selected' : '' }}>Soft Skills</option>
                </select>
            </div>
            <div style="flex:1;">
                <label class="form-label" style="margin-bottom:6px;">Status</label>
                <select name="status" class="form-input" style="padding:10px 14px;">
                    <option value="">All</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn-primary" style="padding:10px 24px; height:auto;">Filter</button>
            <a href="{{ route('admin.skills.index') }}" class="btn-secondary" style="padding:10px 24px; height:auto;">Reset</a>
        </form>
    </div>

    {{-- Skills by Category --}}
    @php
        $groupedSkills = $skills->groupBy('category');
        $categoryColors = ['frontend' => '#60a5fa', 'backend' => '#10b981', 'tools' => '#f59e0b', 'soft' => '#a78bfa'];
        $categoryNames = ['frontend' => 'Frontend Development', 'backend' => 'Backend Development', 'tools' => 'Tools & Technologies', 'soft' => 'Soft Skills'];
    @endphp

    @foreach($categoryNames as $key => $name)
    @if($groupedSkills->has($key))
    <div style="margin-bottom:32px;">
        <h2 style="font-size:20px; font-weight:700; margin-bottom:20px; display:flex; align-items:center; gap:12px;">
            @php $catColor = $categoryColors[$key]; @endphp
            <div @style(['width: 8px', 'height: 8px', "background: {$catColor}", 'border-radius: 50%'])></div>
            {{ $name }}
            <span style="font-size:13px; color:rgba(255,255,255,0.3); font-weight:500;">({{ $groupedSkills[$key]->count() }} skills)</span>
        </h2>

        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:16px;">
            @foreach($groupedSkills[$key] as $skill)
            <div class="glass-card" style="padding:20px;">
                <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:12px;">
                    <div style="display:flex; align-items:center; gap:10px;">
                        @if($skill->icon)
                        <span style="font-size:24px;">{{ $skill->icon }}</span>
                        @endif
                        <div>
                            <div style="font-size:15px; font-weight:700; color:#fff;">{{ $skill->name }}</div>
                            <div style="font-size:11px; color:rgba(255,255,255,0.3);">{{ $skill->proficiency_level }}</div>
                        </div>
                    </div>
                    @if(!$skill->is_active)
                    <span style="background:rgba(239,68,68,0.1); color:#f87171; font-size:9px; font-weight:700; padding:3px 8px; border-radius:10px; text-transform:uppercase;">Inactive</span>
                    @endif
                </div>

                {{-- Progress Bar --}}
                <div style="margin-bottom:12px;">
                    <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                        <span @style(['font-size: 11px', 'color: rgba(255, 255, 255, 0.4)'])>Proficiency</span>
                        <span @style(['font-size: 12px', 'font-weight: 700', "color: {$catColor}"])>{{ $skill->proficiency }}%</span>
                    </div>
                    <div style="height:6px; background:rgba(255,255,255,0.05); border-radius:10px; overflow:hidden;">
                        @php $profWidthVal = $skill->proficiency . '%'; @endphp
                        <div @style(['height: 100%', "width: {$profWidthVal}", "background: {$catColor}", 'border-radius: 10px', 'transition: width 0.3s'])></div>
                    </div>
                </div>

                @if($skill->description)
                <div style="font-size:11px; color:rgba(255,255,255,0.3); line-height:1.5; margin-bottom:12px;">{{ Str::limit($skill->description, 80) }}</div>
                @endif

                <div style="display:flex; gap:8px; padding-top:12px; border-top:1px solid rgba(255,255,255,0.06);">
                    <a href="{{ route('admin.skills.edit', $skill) }}" class="btn-secondary" style="flex:1; justify-content:center; font-size:11px; padding:6px;">Edit</a>
                    <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}" onsubmit="return confirm('Delete this skill?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger" style="font-size:11px; padding:6px 10px;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;"><path d="M3 6h18m-2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" /></svg>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    @endforeach

    @if($skills->isEmpty())
    <div class="glass-card" style="padding:64px; text-align:center; color:rgba(255,255,255,0.2);">
        <div style="font-size:64px; margin-bottom:16px;">🛠️</div>
        <div style="font-size:16px; font-weight:700; margin-bottom:8px;">No skills found</div>
        <a href="{{ route('admin.skills.create') }}" class="btn-primary" style="margin-top:16px;">Add Your First Skill</a>
    </div>
    @endif

    @if($skills->hasPages())
    <div style="margin-top:24px;">
        {{ $skills->links() }}
    </div>
    @endif
</div>
@endsection
