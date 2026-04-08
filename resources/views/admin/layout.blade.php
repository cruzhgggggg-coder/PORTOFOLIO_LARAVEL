<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Luminescent Architect CMS</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|jetbrains-mono:400,500" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --brand: #00f2ff;
            --brand-glow: rgba(0, 242, 255, 0.3);
            --brand-muted: rgba(0, 242, 255, 0.1);
            --sidebar-w: 260px;
            --bg-deep: #050508;
            --card-bg: rgba(255, 255, 255, 0.03);
            --card-border: rgba(255, 255, 255, 0.07);
        }
        body { 
            background: var(--bg-deep); 
            color: #e2e8f0; 
            font-family: 'Instrument Sans', sans-serif; 
            margin: 0;
            overflow-x: hidden;
        }
        
        /* Sidebar Styles */
        .admin-sidebar {
            width: var(--sidebar-w);
            background: rgba(10, 10, 15, 0.7);
            border-right: 1px solid var(--card-border);
            height: 100vh;
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            backdrop-filter: blur(25px);
            z-index: 100;
            transition: transform 0.3s ease;
        }
        .admin-main {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            padding: 2.5rem;
            max-width: 1400px;
        }

        /* Nav Links */
        .nav-link {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 20px;
            color: rgba(255,255,255,0.45);
            font-size: 13px; font-weight: 500;
            text-decoration: none;
            border-radius: 10px;
            margin: 4px 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: 0.02em;
        }
        .nav-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
        }
        .nav-link.active {
            background: var(--brand-muted);
            color: var(--brand);
            font-weight: 600;
            box-shadow: inset 0 0 0 1px rgba(0, 242, 255, 0.15);
        }
        .nav-link svg {
            transition: transform 0.3s ease;
        }
        .nav-link:hover svg {
            transform: scale(1.1);
        }

        /* Components */
        .glass-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            backdrop-filter: blur(12px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .btn-primary {
            background: var(--brand); color: #000;
            font-weight: 700; font-size: 12px;
            padding: 12px 24px; border-radius: 10px;
            text-decoration: none; display: inline-flex;
            align-items: center; gap: 8px;
            transition: all 0.3s ease; border: none; cursor: pointer;
            letter-spacing: 0.05em; text-transform: uppercase;
        }
        .btn-primary:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 8px 25px var(--brand-glow);
            filter: brightness(1.1);
        }
        .btn-danger {
            background: rgba(239,68,68,0.1); color: #f87171;
            border: 1px solid rgba(239,68,68,0.2);
            font-weight: 600; font-size: 12px;
            padding: 10px 18px; border-radius: 10px;
            cursor: pointer; transition: all 0.2s; letter-spacing: 0.03em;
        }
        .btn-danger:hover { 
            background: rgba(239,68,68,0.2); 
            transform: translateY(-1px);
        }
        .btn-secondary {
            background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.7);
            border: 1px solid rgba(255,255,255,0.1);
            font-weight: 600; font-size: 12px;
            padding: 10px 18px; border-radius: 10px;
            text-decoration: none; display: inline-flex;
            align-items: center; gap: 8px;
            transition: all 0.2s; cursor: pointer;
        }
        .btn-secondary:hover { 
            background: rgba(255,255,255,0.08); 
            border-color: rgba(255,255,255,0.2);
        }

        /* Forms */
        .form-input {
            width: 100%;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            color: #fff; border-radius: 12px;
            padding: 14px 18px; font-size: 14px;
            transition: all 0.2s ease; outline: none;
        }
        .form-input:focus { 
            border-color: var(--brand); 
            background: rgba(255,255,255,0.05);
            box-shadow: 0 0 0 4px var(--brand-muted);
        }
        .form-label {
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.12em;
            color: rgba(255,255,255,0.4);
            display: block; margin-bottom: 10px;
        }

        /* Toasts */
        .toast-container {
            position: fixed; top: 2rem; right: 2rem;
            z-index: 1000; display: flex; flex-direction: column; gap: 12px;
        }
        .toast {
            padding: 16px 24px; border-radius: 12px;
            backdrop-filter: blur(20px); font-size: 14px; font-weight: 500;
            display: flex; align-items: center; gap: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            animation: toast-in 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .toast-success { background: rgba(16, 185, 129, 0.15); color: #6ee7b7; border-color: rgba(16, 185, 129, 0.2); }
        .toast-error { background: rgba(239, 68, 68, 0.15); color: #fca5a5; border-color: rgba(239, 68, 68, 0.2); }
        @keyframes toast-in {
            from { opacity: 0; transform: translateX(50px) scale(0.9); }
            to { opacity: 1; transform: translateX(0) scale(1); }
        }

        /* Modal */
        .modal-backdrop {
            position: fixed; inset: 0; background: rgba(0,0,0,0.8);
            backdrop-filter: blur(8px); display: none; align-items: center;
            justify-content: center; z-index: 2000;
        }
        .modal-content {
            width: 400px; padding: 32px; border-radius: 24px;
            background: #0d0d12; border: 1px solid var(--card-border);
            text-align: center; transform: scale(0.95); opacity: 0;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .modal-backdrop.active { display: flex; }
        .modal-backdrop.active .modal-content { transform: scale(1); opacity: 1; }

        @media(max-width: 1024px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-sidebar.mobile-active { transform: translateX(0); }
            .admin-main { margin-left: 0; padding: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="toast-container" id="toast-container">
        @if(session('success'))
            <div class="toast toast-success">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:20px;height:20px;"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="toast toast-error">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:20px;height:20px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session('error') }}
            </div>
        @endif
    </div>

    {{-- Sidebar --}}
    <aside class="admin-sidebar" id="sidebar">
        <div style="padding: 32px 24px; border-bottom: 1px solid var(--card-border);">
            <div style="display:flex; align-items:center; gap:12px;">
                <div style="width:40px;height:40px;background:var(--brand-muted);border:1px solid rgba(0,242,255,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="var(--brand)" stroke-width="2" style="width:20px;height:20px;">
                        <path d="M12 2l9 4.9V17.1L12 22l-9-4.9V6.9L12 2z"/>
                    </svg>
                </div>
                <div>
                    <div style="font-weight:800;font-size:15px;letter-spacing:-0.01em;">LA CMS</div>
                    <div style="font-size:10px;color:rgba(255,255,255,0.3);letter-spacing:0.1em;text-transform:uppercase;font-weight:700;">Dashboard</div>
                </div>
            </div>
        </div>

        <nav style="padding: 24px 0; flex:1; overflow-y:auto;">
            <div style="padding: 0 24px; margin-bottom:12px;">
                <span style="font-size:10px;font-weight:800;letter-spacing:0.15em;text-transform:uppercase;color:rgba(255,255,255,0.2);">Navigation</span>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.projects.index') }}" class="nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                Portfolio Works
            </a>
            <a href="{{ route('admin.profile.edit') }}" class="nav-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Profile & Identity
            </a>

            <div style="padding: 0 24px; margin:24px 0 12px; border-top: 1px solid rgba(255,255,255,0.04); padding-top: 24px;">
                <span style="font-size:10px;font-weight:800;letter-spacing:0.15em;text-transform:uppercase;color:rgba(255,255,255,0.2);">Quick Links</span>
            </div>
            <a href="{{ route('home') }}" target="_blank" class="nav-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                Live Preview
            </a>
        </nav>

        <div style="padding: 24px; border-top: 1px solid var(--card-border); background: rgba(0,0,0,0.2);">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
                <div style="width:36px;height:36px;background:rgba(124,58,237,0.2);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:#a78bfa;border:1px solid rgba(124,58,237,0.2);">
                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                </div>
                <div style="flex:1; min-width:0;">
                    <div style="font-size:13px;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div style="font-size:10px;color:rgba(255,255,255,0.3);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ auth()->user()->email ?? '' }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-secondary" style="width:100%;justify-content:center;font-size:11px;padding:8px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:13px;height:13px;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Logout System
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="admin-main">
        @yield('content')
    </main>

    {{-- Delete Modal --}}
    <div class="modal-backdrop" id="deleteModal">
        <div class="modal-content">
            <div style="width:60px;height:60px;background:rgba(239,68,68,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#f87171" stroke-width="2" style="width:28px;height:28px;"><path d="M3 6h18m-2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
            </div>
            <h3 style="font-size:20px;font-weight:700;margin-bottom:8px;">Hapus Data?</h3>
            <p style="color:rgba(255,255,255,0.4);font-size:14px;margin-bottom:28px;">Tindakan ini tidak dapat dibatalkan. Seluruh data terkait akan dihapus permanen.</p>
            <div style="display:flex;gap:12px;justify-content:center;">
                <button type="button" class="btn-secondary" onclick="closeDeleteModal()">Batal</button>
                <form id="deleteForm" method="POST" style="margin:0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger">Ya, Hapus Permanen</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toast auto-dismiss
        document.querySelectorAll('.toast').forEach(toast => {
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(50px) scale(0.9)';
                toast.style.transition = 'all 0.4s ease';
                setTimeout(() => toast.remove(), 400);
            }, 5000);
        });

        // Delete Modal Logic
        const deleteModal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');

        function openDeleteModal(actionUrl) {
            deleteForm.action = actionUrl;
            deleteModal.classList.add('active');
        }

        function closeDeleteModal() {
            deleteModal.classList.remove('active');
        }

        window.onclick = function(event) {
            if (event.target == deleteModal) closeDeleteModal();
        }
    </script>
</body>
</html>

