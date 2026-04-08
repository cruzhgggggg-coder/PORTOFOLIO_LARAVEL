@extends('admin.layout')

@section('title', 'Portfolio Works')

@section('content')
<div style="max-width:1200px;">
    {{-- Header --}}
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:2.5rem; gap:20px; flex-wrap:wrap;">
        <div>
            <h1 style="font-size:32px; font-weight:800; letter-spacing:-0.04em; margin-bottom:8px;">Portfolio Works</h1>
            <p style="color:rgba(255,255,255,0.4); font-size:14px;">Kelola seluruh karya digital yang tampil di website portfolio kamu.</p>
        </div>
        <a href="{{ route('admin.projects.create') }}" class="btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:16px;height:16px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Project Baru
        </a>
    </div>

    {{-- Projects Table --}}
    <div class="glass-card" style="padding:0; overflow:hidden;">
        <table>
            <thead>
                <tr>
                    <th style="width:100px;">Preview</th>
                    <th>Project & Kategori</th>
                    <th>Tech Stack</th>
                    <th>Tahun</th>
                    <th>Featured</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                <tr>
                    <td>
                        <div style="width:80px; height:60px; background:rgba(255,255,255,0.05); border-radius:12px; overflow:hidden; border:1px solid rgba(255,255,255,0.1); position:relative;">
                            <img src="{{ $project->image }}" alt="" style="width:100%; height:100%; object-fit:cover;">
                        </div>
                    </td>
                    <td>
                        <div style="font-weight:700; font-size:15px; margin-bottom:4px; color:#fff;">{{ $project->title }}</div>
                        <div style="font-size:11px; color:rgba(255,255,255,0.35); font-family:'JetBrains Mono', monospace; text-transform:uppercase; letter-spacing:0.1em; font-weight:700;">{{ $project->category }}</div>
                    </td>
                    <td>
                        @if($project->tech_stack)
                            <div style="display:flex; flex-wrap:wrap; gap:6px;">
                                @foreach(array_slice($project->tech_stack, 0, 3) as $tech)
                                    <span style="background:rgba(0,242,255,0.05); color:rgba(0,242,255,0.6); border:1px solid rgba(0,242,255,0.1); font-size:9px; padding:3px 8px; border-radius:6px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em;">{{ $tech }}</span>
                                @endforeach
                                @if(count($project->tech_stack) > 3)
                                    <span style="color:rgba(255,255,255,0.2); font-size:10px; font-weight:700;">+{{ count($project->tech_stack) - 3 }}</span>
                                @endif
                            </div>
                        @else
                            <span style="color:rgba(255,255,255,0.1); font-size:11px;">—</span>
                        @endif
                    </td>
                    <td>
                        <span style="font-family:'JetBrains Mono', monospace; color:rgba(255,255,255,0.5); font-size:12px; font-weight:600;">{{ $project->year }}</span>
                    </td>
                    <td>
                        <form action="{{ route('admin.projects.toggle-featured', $project) }}" method="POST" style="margin:0;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" style="background:none; border:none; padding:0; cursor:pointer; display:inline-flex; outline:none;">
                                @if($project->is_featured)
                                    <span class="badge-featured" title="Klik untuk hilangkan dari featured">★ Featured</span>
                                @else
                                    <span class="badge-normal" title="Klik untuk jadikan featured">Normal</span>
                                @endif
                            </button>
                        </form>
                    </td>
                    <td style="text-align:right;">
                        <div style="display:flex; gap:10px; justify-content:flex-end; align-items:center;">
                            <a href="{{ route('admin.projects.edit', $project) }}" class="btn-secondary" style="padding:10px; border-radius:12px;" title="Edit Project">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <button type="button" class="btn-danger" style="padding:10px; border-radius:12px; background:rgba(239,68,68,0.08);" 
                                    onclick="openDeleteModal('{{ route('admin.projects.destroy', $project) }}')" title="Hapus Project">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><path d="M3 6h18m-2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:100px 40px; color:rgba(255,255,255,0.2);">
                        <div style="font-size:48px; margin-bottom:20px; opacity:0.3;">📂</div>
                        <div style="font-size:18px; font-weight:700; margin-bottom:8px; color:rgba(255,255,255,0.5);">Belum ada project</div>
                        <p style="font-size:14px; margin-bottom:32px; color:rgba(255,255,255,0.3); max-width:400px; margin-left:auto; margin-right:auto;">Mulai bangun portfolio kamu dengan menambahkan project pertama yang memukau.</p>
                        <a href="{{ route('admin.projects.create') }}" class="btn-primary">Tambah Project Sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($projects->hasPages())
    <div style="margin-top:2.5rem; display:flex; justify-content:center;">
        {{ $projects->links() }}
    </div>
    @endif
</div>

<style>
    .badge-featured {
        background: rgba(0,242,255,0.1); color: #00f2ff;
        border: 1px solid rgba(0,242,255,0.2);
        font-size: 9px; padding: 4px 12px; border-radius: 20px;
        font-weight: 800; letter-spacing: 0.12em; text-transform: uppercase;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 0 15px rgba(0,242,255,0.05);
    }
    .badge-featured:hover { background: rgba(0,242,255,0.2); transform: translateY(-1px); box-shadow: 0 5px 20px rgba(0,242,255,0.15); }
    
    .badge-normal {
        background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.3);
        border: 1px solid rgba(255,255,255,0.08);
        font-size: 9px; padding: 4px 12px; border-radius: 20px;
        font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase;
        transition: all 0.2s;
    }
    .badge-normal:hover { color: rgba(255,255,255,0.6); background: rgba(255,255,255,0.1); }

    th {
        background: rgba(255,255,255,0.015);
        font-weight: 800; font-size: 10px; text-transform: uppercase; letter-spacing: 0.18em;
        color: rgba(255,255,255,0.25); border-bottom: 1px solid rgba(255,255,255,0.08);
        padding: 20px 24px;
    }
    td {
        padding: 20px 24px; border-bottom: 1px solid rgba(255,255,255,0.04);
        vertical-align: middle;
    }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: rgba(255,255,255,0.015); }
    
    /* Custom Scrollbar for sidebars/modals */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }
</style>
@endsection
