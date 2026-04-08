<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Access — Luminescent Architect</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: #050508;
            color: #e2e8f0;
            font-family: 'Instrument Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .bg-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.15;
            pointer-events: none;
            animation: pulse 6s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.15; }
            50% { transform: scale(1.1); opacity: 0.2; }
        }
        .login-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            padding: 48px 40px;
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 10;
            backdrop-filter: blur(20px);
        }
        .form-input {
            width: 100%;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: #e2e8f0;
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }
        .form-input:focus {
            border-color: #00f2ff;
            box-shadow: 0 0 0 3px rgba(0,242,255,0.1);
        }
        .form-label {
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.1em;
            color: rgba(255,255,255,0.45);
            display: block; margin-bottom: 8px;
        }
        .btn-submit {
            width: 100%;
            background: #00f2ff;
            color: #000;
            font-weight: 700;
            font-size: 13px;
            padding: 15px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            transition: all 0.2s;
            font-family: inherit;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 30px rgba(0,242,255,0.3), 0 8px 20px rgba(0,0,0,0.3);
        }
        .error-box {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.2);
            color: #fca5a5;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
        }
        a.back-link {
            color: rgba(255,255,255,0.35);
            text-decoration: none;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }
        a.back-link:hover { color: #00f2ff; }
    </style>
</head>
<body>
    {{-- Background orbs --}}
    <div class="bg-orb" style="width:500px;height:500px;background:#00f2ff;top:-200px;left:-200px;"></div>
    <div class="bg-orb" style="width:400px;height:400px;background:#7c3aed;bottom:-150px;right:-150px;animation-delay:3s;"></div>

    <div class="login-card">
        {{-- Logo --}}
        <div style="text-align:center;margin-bottom:40px;">
            <div style="width:52px;height:52px;background:rgba(0,242,255,0.1);border:1px solid rgba(0,242,255,0.2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#00f2ff" stroke-width="2" style="width:24px;height:24px;">
                    <path d="M12 2l9 4.9V17.1L12 22l-9-4.9V6.9L12 2z"/>
                </svg>
            </div>
            <h1 style="font-size:22px;font-weight:700;letter-spacing:-0.02em;margin-bottom:6px;">Admin Access</h1>
            <p style="color:rgba(255,255,255,0.35);font-size:13px;">Luminescent Architect CMS</p>
        </div>

        {{-- Errors --}}
        @if($errors->any())
            <div class="error-box">{{ $errors->first() }}</div>
        @endif
        @if(session('status'))
            <div style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.2);color:#6ee7b7;padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:20px;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf

            <div style="margin-bottom:16px;">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" value="{{ old('email') }}" autofocus required placeholder="admin@example.com">
            </div>

            <div style="margin-bottom:28px;">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input" required placeholder="••••••••••">
            </div>

            <button type="submit" class="btn-submit">Masuk ke Panel →</button>
        </form>

        <div style="margin-top:24px;text-align:center;">
            <a href="{{ route('home') }}" class="back-link" style="justify-content:center;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:13px;height:13px;"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Kembali ke Portfolio
            </a>
        </div>
    </div>
</body>
</html>
