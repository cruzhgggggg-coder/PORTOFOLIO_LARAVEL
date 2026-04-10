<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Mode - {{ \App\Models\SiteSetting::get('site_name', 'Portfolio') }}</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: {{ \App\Models\SiteSetting::get('brand_color_primary', '#00f2ff') }};
            --brand-secondary: {{ \App\Models\SiteSetting::get('brand_color_secondary', '#7c3aed') }};
        }
        body {
            background-color: #030303;
            color: white;
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow: hidden;
        }
        .font-display { font-family: 'Outfit', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .text-gradient {
            background: linear-gradient(135deg, var(--brand) 0%, var(--brand-secondary) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
            opacity: 0.15;
            animation: float 20s infinite alternate;
        }
        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(100px, 50px) scale(1.2); }
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-6">
    <!-- Background Elements -->
    <div class="orb w-96 h-96 bg-(--brand) top-[-10%] left-[-10%]"></div>
    <div class="orb w-[500px] h-[500px] bg-(--brand-secondary) bottom-[-20%] right-[-10%]" style="animation-delay: -5s;"></div>

    <div class="relative z-10 max-w-2xl w-full text-center">
        <div class="glass p-12 md:p-20 rounded-[3rem] shadow-2xl">
            <!-- Icon -->
            <div class="w-20 h-20 bg-white/5 border border-white/10 rounded-3xl flex items-center justify-center mx-auto mb-10">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-10 h-10 text-(--brand)">
                    <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.77 3.77z"></path>
                </svg>
            </div>

            <h1 class="text-4xl md:text-6xl font-display font-black uppercase tracking-tighter mb-6">
                Under <span class="text-gradient">Optimization</span>
            </h1>
            
            <p class="text-white/40 text-lg leading-relaxed mb-12 font-light">
                We're currently refining the digital experience. <br/>
                {{ \App\Models\SiteSetting::get('site_name', 'Portfolio') }} will be back online shortly.
            </p>

            <div class="inline-flex items-center gap-2 px-6 py-3 bg-white/5 border border-white/10 rounded-full text-xs font-mono uppercase tracking-widest text-white/60">
                <span class="w-2 h-2 rounded-full bg-(--brand) animate-pulse"></span>
                System Maintenance in Progress
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-12 text-white/20 text-[10px] uppercase tracking-[0.5em] font-bold">
            &copy; {{ date('Y') }} {{ \App\Models\SiteSetting::get('site_name', 'Portfolio') }}
        </div>
    </div>
</body>
</html>
