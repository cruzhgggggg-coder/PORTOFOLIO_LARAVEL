<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $siteSettings['site_tagline'] ?? 'Luminescent Architect — Crafting immersive digital experiences at the intersection of light, motion, and code.' }}">
    <meta name="theme-color" content="{{ $siteSettings['brand_color_primary'] ?? '#000000' }}">
    <title>@yield('title', ($siteSettings['site_name'] ?? config('app.name', 'Site')) . ' — ' . ($siteSettings['site_tagline'] ?? 'Architect'))</title>

    <style>
        :root {
            --color-brand-primary: {{ $siteSettings['brand_color_primary'] ?? '#00f2ff' }} !important;
            --color-brand-secondary: {{ $siteSettings['brand_color_secondary'] ?? '#7000ff' }} !important;
        }
    </style>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|space-grotesk:400,500,600,700" rel="stylesheet" />

    {{-- Favicon --}}
    <link rel="icon" href="/favicon.ico" sizes="any">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Analytics Integration --}}
    @if(($siteSettings['enable_analytics'] ?? false) && !empty($siteSettings['google_analytics_id']))
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $siteSettings['google_analytics_id'] }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $siteSettings["google_analytics_id"] }}');
    </script>
    @endif

    @if(($siteSettings['enable_analytics'] ?? false) && !empty($siteSettings['facebook_pixel_id']))
    <!-- Facebook Pixel -->
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
        n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
        document,'script','https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ $siteSettings["facebook_pixel_id"] }}');
        fbq('track', 'PageView');
    </script>
    @endif
</head>

<body class="font-sans antialiased bg-black text-white selection:bg-brand-primary selection:text-black overflow-x-hidden">

    {{-- Page Loader --}}
    <div id="page-loader" class="page-loader">
        <div class="flex flex-col items-center gap-6">
            <div class="loader-ring"></div>
            <span class="text-[10px] font-mono uppercase tracking-[0.5em] text-white/40">Initializing</span>
        </div>
    </div>

    {{-- Background --}}
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden bg-black">
        <div class="absolute inset-0 opacity-[0.03] mix-blend-overlay" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=\'0 0 200 200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cfilter id=\'noiseFilter\'%3E%3CfeTurbulence type=\'fractalNoise\' baseFrequency=\'0.65\' numOctaves=\'3\' stitchTiles=\'stitch\'/%3E%3C/filter%3E%3Crect width=\'100%25\' height=\'100%25\' filter=\'url(%23noiseFilter)\'/%3E%3C/svg%3E')"></div>
    </div>

    {{-- Navbar --}}
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 px-6 py-4 bg-transparent">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group" data-magnetic>
                <div class="relative">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-brand-primary group-hover:rotate-90 transition-transform duration-700">
                        <path d="M12 2l9 4.9V17.1L12 22l-9-4.9V6.9L12 2z" />
                    </svg>
                    <div class="absolute inset-0 bg-brand-primary/20 blur-lg rounded-full group-hover:bg-brand-primary/40 transition-colors duration-500"></div>
                </div>
                <span class="font-display font-bold text-xl tracking-tighter uppercase" data-magnetic-text>
                    {{ $siteSettings['site_name'] ?? 'Luminescent Architect' }}
                </span>
            </a>

            <div class="hidden md:flex items-center gap-10">
                @foreach([['label' => 'Home', 'url' => route('home')], ['label' => 'Projects', 'url' => route('projects')], ['label' => 'About', 'url' => route('about')], ['label' => 'Contact', 'url' => route('contact')]] as $item)
                <a href="{{ $item['url'] }}" class="nav-link text-sm font-medium tracking-widest uppercase transition-colors hover:text-brand-primary {{ Request::url() == $item['url'] ? 'text-brand-primary active' : 'text-white/60' }}">
                    {{ $item['label'] }}
                </a>
                @endforeach
                <a href="{{ route('contact') }}" class="group relative px-7 py-2.5 bg-white text-black text-xs font-bold uppercase tracking-widest rounded-full hover:bg-brand-primary transition-all duration-500 overflow-hidden" data-magnetic>
                    <span data-magnetic-text class="relative z-10">Hire Me</span>
                </a>
            </div>

            <button id="mobile-toggle" class="md:hidden text-white relative w-8 h-8 flex items-center justify-center">
                <svg id="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-6 h-6 transition-transform duration-300">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden absolute top-full left-0 right-0 bg-black/95 backdrop-blur-2xl border-b border-white/5 px-6 py-8 flex-col gap-6 md:hidden">
            @foreach([['label' => 'Home', 'url' => route('home')], ['label' => 'Projects', 'url' => route('projects')], ['label' => 'About', 'url' => route('about')], ['label' => 'Contact', 'url' => route('contact')]] as $item)
            <a href="{{ $item['url'] }}" class="text-2xl font-display font-bold uppercase tracking-widest {{ Request::url() == $item['url'] ? 'text-brand-primary' : 'text-white/70' }} hover:text-brand-primary transition-colors">
                {{ $item['label'] }}
            </a>
            @endforeach
            <a href="{{ route('contact') }}" class="mt-4 inline-block px-8 py-3 bg-brand-primary text-black text-sm font-bold uppercase tracking-widest rounded-full text-center">
                Hire Me
            </a>
        </div>
    </nav>

    <main class="relative z-10">
        @yield('content')
    </main>

    {{-- Enhanced Footer --}}
    <footer class="relative z-10 bg-black border-t border-white/6 overflow-hidden">
        {{-- Marquee divider --}}
        <div class="py-6 border-b border-white/4 overflow-hidden">
            <div class="marquee-track text-[10rem] font-display font-black uppercase tracking-tighter text-white/10 leading-none whitespace-nowrap select-none">
                <span>Luminescent Architect ◆ Digital Craftsman ◆ Full-Stack Developer ◆ UI/UX Engineer ◆&nbsp;</span>
                <span>Luminescent Architect ◆ Digital Craftsman ◆ Full-Stack Developer ◆ UI/UX Engineer ◆&nbsp;</span>
            </div>
        </div>

        <div class="max-w-7xl mx-auto py-20 px-6">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-16">
                {{-- Brand column --}}
                <div class="col-span-1 md:col-span-5">
                    <div class="flex items-center gap-3 mb-8">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-7 h-7 text-brand-primary">
                            <path d="M12 2l9 4.9V17.1L12 22l-9-4.9V6.9L12 2z" />
                        </svg>
                        <span class="font-display font-bold text-xl tracking-tighter uppercase">
                            {{ $siteSettings['site_name'] ?? 'Luminescent Architect' }}
                        </span>
                    </div>
                    <p class="text-white/40 max-w-sm leading-relaxed text-sm mb-8">
                        {{ $siteSettings['site_tagline'] ?? 'Crafting digital experiences at the intersection of light, motion, and code.' }}
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="social-icon w-11 h-11 glass-premium flex items-center justify-center rounded-full text-white/60 hover:text-brand-primary text-sm font-medium">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                        </a>
                        <a href="#" class="social-icon w-11 h-11 glass-premium flex items-center justify-center rounded-full text-white/60 hover:text-brand-secondary text-sm font-medium">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028c.462-.63.874-1.295 1.226-1.994a.076.076 0 0 0-.041-.106 13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.892.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03z"/></svg>
                        </a>
                        <a href="#" class="social-icon w-11 h-11 glass-premium flex items-center justify-center rounded-full text-white/60 hover:text-brand-accent text-sm font-medium">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Navigation --}}
                <div class="col-span-1 md:col-span-3">
                    <h4 class="font-display font-bold uppercase tracking-widest text-[11px] mb-8 text-white/80">Navigation</h4>
                    <ul class="flex flex-col gap-4">
                        @foreach([['Home', route('home')], ['Projects', route('projects')], ['About', route('about')], ['Contact', route('contact')]] as $link)
                        <li>
                            <a href="{{ $link[1] }}" class="footer-link text-white/40 hover:text-brand-primary transition-all text-sm pl-0">
                                {{ $link[0] }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Contact Info --}}
                <div class="col-span-1 md:col-span-4">
                    <h4 class="font-display font-bold uppercase tracking-widest text-[11px] mb-8 text-white/80">Get In Touch</h4>
                    <div class="flex flex-col gap-4 text-sm">
                        <p class="text-white/40">Ready to build something extraordinary?</p>
                        @if(!empty($siteSettings['contact_email']))
                        <a href="mailto:{{ $siteSettings['contact_email'] }}" class="text-white/60 hover:text-brand-primary transition-colors">{{ $siteSettings['contact_email'] }}</a>
                        @endif
                        <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 text-brand-primary font-medium hover:gap-4 transition-all duration-300">
                            Start a conversation
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="border-t border-white/4">
            <div class="max-w-7xl mx-auto px-6 py-6 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-white/20 text-[10px] uppercase tracking-[0.3em]">
                    © {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'Luminescent Architect' }}. All Rights Reserved.
                </p>
                <p class="text-white/20 text-[10px] uppercase tracking-[0.3em] flex items-center gap-2">
                    Designed with <span class="text-brand-accent text-sm">♥</span> for the future
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Page loader
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.getElementById('page-loader')?.classList.add('loaded');
            }, 600);
        });

        // Navbar scroll effect (enhanced)
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 30) {
                navbar.classList.add('nav-scrolled');
                navbar.classList.remove('bg-transparent');
            } else {
                navbar.classList.remove('nav-scrolled');
                navbar.classList.add('bg-transparent');
            }
        });

        // Mobile menu toggle
        const toggle = document.getElementById('mobile-toggle');
        const menu = document.getElementById('mobile-menu');
        toggle.addEventListener('click', () => {
            menu.classList.toggle('hidden');
            menu.classList.toggle('flex');
        });
    </script>
</body>

</html>