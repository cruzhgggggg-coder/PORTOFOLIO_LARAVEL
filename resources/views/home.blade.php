@extends('app')

@section('title', 'Home - Luminescent Architect')

@section('content')
<div class="relative pt-20 overflow-hidden">
    {{-- ============================================================ --}}
    {{-- HERO SECTION — 3D Interactive                                 --}}
    {{-- ============================================================ --}}
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden px-6">
        {{-- Hero Content --}}
        <div class="relative z-10 max-w-6xl mx-auto text-center">
            <div>
                {{-- Badge --}}
                <span class="hero-badge inline-block px-6 py-2 glass-premium rounded-full text-[10px] font-bold uppercase tracking-[0.4em] text-brand-primary mb-10" data-reveal="scale" data-delay="200">
                    {{ $profile['hero_badge'] ?? 'Digital Architect & Designer' }}
                </span>

                {{-- Main Title --}}
                <h1 class="text-5xl md:text-7xl lg:text-8xl font-display font-bold tracking-tighter mb-10 leading-[0.88] uppercase" data-reveal="up" data-delay="400">
                    @if(!empty($profile['hero_line1']) || !empty($profile['hero_line2']))
                    {{ $profile['hero_line1'] ?? '' }}
                    @if(!empty($profile['hero_line2']))
                    <br /> <span class="text-gradient-blue">{{ $profile['hero_line2'] }}</span>
                    @endif
                    @else
                    {{ !empty($profile['name']) ? $profile['name'] : ($siteSettings['site_name'] ?? 'LUMINESCENT ARCHITECT') }}
                    @endif
                </h1>

                {{-- Description --}}
                <p class="text-lg md:text-xl text-white/50 max-w-2xl mx-auto mb-14 leading-relaxed font-light" data-reveal="up" data-delay="600">
                    {{ $profile['hero_desc'] ?? 'Creating immersive digital environments where aesthetics meet high-performance engineering.' }}
                </p>

                {{-- CTA Buttons --}}
                <div class="flex flex-col md:flex-row items-center justify-center gap-6" data-reveal="up" data-delay="800">
                    <a href="{{ route('projects') }}" class="group relative px-10 py-4 bg-brand-primary text-black font-bold uppercase tracking-widest rounded-full overflow-hidden transition-all duration-500 hover:shadow-[0_0_40px_rgba(0,242,255,0.4)] hover:scale-105" data-magnetic>
                        <span data-magnetic-text class="relative z-10 flex items-center gap-3 text-sm">
                            View Portfolio
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4 group-hover:translate-x-1 transition-transform">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </span>
                    </a>
                    <a href="{{ route('about') }}" class="group px-10 py-4 glass-premium rounded-full font-bold uppercase tracking-widest text-sm hover:border-white/20 transition-all duration-500" data-magnetic>
                        <span data-magnetic-text class="relative z-10 flex items-center gap-3">
                            The Process
                            <span class="w-2 h-2 rounded-full bg-brand-primary animate-pulse"></span>
                        </span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Scroll indicator --}}
        <div class="absolute bottom-12 left-1/2 -translate-x-1/2 flex flex-col items-center gap-4 z-10" data-reveal="fade" data-delay="1200">
            <span class="text-[9px] font-mono uppercase tracking-[0.4em] text-white/60">Scroll to explore</span>
            <div class="relative w-5 h-8 rounded-full border border-white/20">
                <div class="absolute top-1.5 left-1/2 -translate-x-1/2 w-1 h-2 rounded-full bg-brand-primary animate-bounce"></div>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- TECH MARQUEE DIVIDER                                          --}}
    {{-- ============================================================ --}}
    @if($siteSettings['show_tech_marquee'] ?? true)
    @php
        $marqueeItems = !empty($siteSettings['tech_marquee_items'])
            ? $siteSettings['tech_marquee_items']
            : 'Laravel, React, Vue.js, TypeScript, Three.js, Tailwind, Node.js, PostgreSQL, Docker, AWS';
        $marqueeFormatted = implode(' ◆ ', array_map('trim', explode(',', $marqueeItems)));
    @endphp
    <div class="overflow-hidden py-8 border-y border-white/10" data-reveal="fade" data-delay="0">
        <div class="marquee-track text-4xl md:text-5xl font-display font-black uppercase tracking-tighter text-white/25 leading-none whitespace-nowrap">
            <span>{{ $marqueeFormatted }} ◆&nbsp;</span>
            <span>{{ $marqueeFormatted }} ◆&nbsp;</span>
        </div>
    </div>
    @endif

    {{-- ============================================================ --}}
    {{-- FEATURES SECTION                                              --}}
    {{-- ============================================================ --}}
    @if($siteSettings['show_features_section'] ?? true)
    <section class="relative py-32 px-6 z-10">
        <div class="max-w-7xl mx-auto">
            {{-- Section header --}}
            <div class="text-center mb-20">
                <span class="text-brand-primary font-mono text-[10px] uppercase tracking-[0.5em] mb-6 block" data-reveal="fade" data-delay="0">
                    Core Principles
                </span>
                <h2 class="text-4xl md:text-6xl font-display font-bold tracking-tighter uppercase" data-reveal="up" data-delay="100">
                    Built on <span class="text-gradient-blue">Excellence</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Card 1: Aesthetic Precision --}}
                <div class="feature-card glass-premium p-10 rounded-4xl group cursor-default" data-tilt data-reveal="up" data-delay="0" style="--card-accent: var(--brand-primary);">
                    <div data-tilt-glow></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-brand-primary/10 flex items-center justify-center rounded-2xl mb-8 group-hover:bg-brand-primary/20 transition-all duration-500 group-hover:scale-110 group-hover:shadow-[0_0_30px_rgba(0,242,255,0.15)]">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-7 h-7 text-brand-primary">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                            </svg>
                        </div>
                        <h3 class="text-xl font-display font-bold uppercase tracking-widest mb-4 group-hover:text-brand-primary transition-colors duration-500">Aesthetic Precision</h3>
                        <p class="text-white/60 leading-relaxed text-sm">
                            Every pixel is placed with intentionality, ensuring a visual harmony that resonates with modern digital sensibilities.
                        </p>
                        <div class="mt-8 flex items-center gap-2 text-brand-primary/50 group-hover:text-brand-primary/80 transition-colors">
                            <div class="w-8 h-px bg-current"></div>
                            <span class="text-[9px] font-mono uppercase tracking-widest">Design First</span>
                        </div>
                    </div>
                </div>

                {{-- Card 2: High Performance --}}
                <div class="feature-card glass-premium p-10 rounded-4xl group cursor-default" data-tilt data-reveal="up" data-delay="150" style="--card-accent: var(--brand-secondary);">
                    <div data-tilt-glow></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-brand-secondary/10 flex items-center justify-center rounded-2xl mb-8 group-hover:bg-brand-secondary/20 transition-all duration-500 group-hover:scale-110 group-hover:shadow-[0_0_30px_rgba(112,0,255,0.15)]">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-7 h-7 text-brand-secondary">
                                <polyline points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polyline>
                            </svg>
                        </div>
                        <h3 class="text-xl font-display font-bold uppercase tracking-widest mb-4 group-hover:text-brand-secondary transition-colors duration-500">High Performance</h3>
                        <p class="text-white/60 leading-relaxed text-sm">
                            Optimized for speed and fluid interactions, bridging the gap between heavy visuals and seamless user experience.
                        </p>
                        <div class="mt-8 flex items-center gap-2 text-brand-secondary/50 group-hover:text-brand-secondary/80 transition-colors">
                            <div class="w-8 h-px bg-current"></div>
                            <span class="text-[9px] font-mono uppercase tracking-widest">Speed Matters</span>
                        </div>
                    </div>
                </div>

                {{-- Card 3: Robust Architecture --}}
                <div class="feature-card glass-premium p-10 rounded-4xl group cursor-default" data-tilt data-reveal="up" data-delay="300" style="--card-accent: var(--brand-secondary);">
                    <div data-tilt-glow></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-brand-accent/10 flex items-center justify-center rounded-2xl mb-8 group-hover:bg-brand-accent/20 transition-all duration-500 group-hover:scale-110 group-hover:shadow-[0_0_30px_rgba(255,0,153,0.15)]">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-7 h-7 text-brand-secondary">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-display font-bold uppercase tracking-widest mb-4 group-hover:text-brand-secondary transition-colors duration-500">Robust Architecture</h3>
                        <p class="text-white/60 leading-relaxed text-sm">
                            Built on solid foundations that scale, ensuring your digital presence remains future-proof and resilient.
                        </p>
                        <div class="mt-8 flex items-center gap-2 text-brand-secondary/50 group-hover:text-brand-secondary/80 transition-colors">
                            <div class="w-8 h-px bg-current"></div>
                            <span class="text-[9px] font-mono uppercase tracking-widest">Built To Last</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ============================================================ --}}
    {{-- FEATURED PROJECTS                                             --}}
    {{-- ============================================================ --}}
    <section class="relative py-32 px-6 z-10">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
                <div>
                    <span class="text-brand-primary font-mono text-[10px] uppercase tracking-[0.5em] mb-6 block" data-reveal="fade" data-delay="0">Selected Works</span>
                    <h2 class="text-5xl md:text-7xl font-display font-bold tracking-tighter uppercase leading-[0.9]" data-reveal="up" data-delay="100">
                        Featured <br /><span class="text-gradient-blue">Architectures</span>
                    </h2>
                </div>
                <a href="{{ route('projects') }}" class="group text-white/60 hover:text-white flex items-center gap-3 uppercase tracking-widest text-[10px] font-bold transition-all duration-300" data-reveal="fade" data-delay="200">
                    View All Projects
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4 group-hover:translate-x-1 transition-transform">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($projects as $index => $project)
                @php
                    $pObj = is_array($project) ? (object) $project : (is_object($project) ? $project : (object)[]);
                @endphp
                <div class="project-card group relative" data-reveal="up" data-delay="{{ $loop->index * 150 }}">
                    {{-- Image --}}
                    <div class="project-image-wrap aspect-4/5 bg-white/5 rounded-4xl mb-8 shadow-2xl overflow-hidden" data-img-reveal>
                        {{-- Project index number --}}
                        <span class="project-index font-display">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>

                        <img
                            src="{{ $pObj->image ?? ($pObj->image_url ?? '') }}"
                            alt="{{ $pObj->title ?? '' }}"
                            loading="lazy"
                            decoding="async"
                            class="w-full h-full object-cover grayscale" />

                        {{-- Overlay on hover --}}
                        <div class="project-overlay flex items-end p-8 z-10">
                            <div class="flex items-center gap-3 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-200">
                                <div class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-full flex items-center justify-center border border-white/20">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4 text-white">
                                        <line x1="7" y1="17" x2="17" y2="7"></line>
                                        <polyline points="7 7 17 7 17 17"></polyline>
                                    </svg>
                                </div>
                                <span class="text-xs uppercase tracking-widest font-bold text-white/80">View Project</span>
                            </div>
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="project-info flex justify-between items-start px-2">
                        <div>
                            <span class="text-brand-primary font-mono text-xs font-semibold uppercase tracking-[0.2em] mb-2 block">{{ $pObj->category ?? '' }}</span>
                            <h4 class="text-2xl font-display font-bold text-white tracking-wide group-hover:text-brand-primary transition-colors duration-500">{{ $pObj->title ?? '' }}</h4>
                        </div>
                        <span class="text-white/60 font-mono text-xs tracking-wider mt-1">{{ $pObj->year ?? '' }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- CERTIFICATES                                                   --}}
    {{-- ============================================================ --}}
    @if(($siteSettings['enable_certificates'] ?? true) && isset($certificates) && $certificates->isNotEmpty())
    <section class="relative py-32 z-10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-20">
                <span class="text-brand-primary font-mono text-xs font-semibold uppercase tracking-[0.3em] mb-6 block" data-reveal="fade" data-delay="0">Achievements</span>
                <h2 class="text-4xl md:text-6xl font-display font-bold tracking-tight uppercase" data-reveal="up" data-delay="100">
                    Certi<span class="text-gradient-blue">fications</span>
                </h2>
            </div>
        </div>

        {{-- 3D Convex Coverflow Gallery Container --}}
        <div class="max-w-[1400px] mx-auto relative px-4 md:px-12">
            {{-- Scroll Buttons --}}
            <button onclick="scrollCerts(-1)" id="cert-btn-left" style="position:absolute; left:10px; top:50%; transform:translateY(-50%); z-index:50; width:52px; height:52px; background:rgba(0,0,0,0.7); border:1px solid rgba(255,255,255,0.15); border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all 0.3s; backdrop-filter:blur(12px); opacity:0; pointer-events:none;" onmouseover="this.style.background='rgba(255,255,255,0.15)'; this.style.borderColor='rgba(255,255,255,0.3)';" onmouseout="this.style.background='rgba(0,0,0,0.7)'; this.style.borderColor='rgba(255,255,255,0.15)';" aria-label="Previous Certificate">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" style="width:22px;height:22px;"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <button onclick="scrollCerts(1)" id="cert-btn-right" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); z-index:50; width:52px; height:52px; background:rgba(0,0,0,0.7); border:1px solid rgba(255,255,255,0.15); border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all 0.3s; backdrop-filter:blur(12px);" onmouseover="this.style.background='rgba(255,255,255,0.15)'; this.style.borderColor='rgba(255,255,255,0.3)';" onmouseout="this.style.background='rgba(0,0,0,0.7)'; this.style.borderColor='rgba(255,255,255,0.15)';" aria-label="Next Certificate">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" style="width:22px;height:22px;"><polyline points="9 18 15 12 9 6"/></svg>
            </button>

            <div id="cert-scroll-container" class="cert-3d-perspective overflow-x-auto scrollbar-hide py-16 px-[10%] md:px-[25%] snap-x snap-mandatory" style="scroll-behavior:smooth;">
                <div class="flex gap-8 md:gap-12 items-center" style="width: max-content;">
                    @foreach($certificates as $i => $certificate)
                    <div class="cert-3d-card glass-premium rounded-3xl overflow-hidden group hover:border-white/30 transition-all duration-500 snap-center flex-shrink-0 w-[310px] md:w-[380px] cursor-pointer shadow-2xl relative" 
                         data-reveal="up" data-delay="{{ $loop->index * 80 }}"
                         onclick="openCertLightbox('{{ asset('storage/' . $certificate->image_url) }}', '{{ addslashes($certificate->title) }}')">
                        
                        {{-- Certificate Image Header --}}
                        @if($certificate->image_url)
                        <div class="aspect-[16/10] overflow-hidden relative">
                            <img src="{{ asset('storage/' . $certificate->image_url) }}" alt="{{ $certificate->title }}" decoding="async" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                            
                            {{-- Expand Badge --}}
                            <div class="absolute top-3 right-3 w-9 h-9 bg-black/60 backdrop-blur-md rounded-full border border-white/10 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:scale-110">
                                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" class="w-4 h-4"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
                            </div>
                        </div>
                        @else
                        <div class="aspect-[16/10] bg-white/5 flex items-center justify-center border-b border-white/5">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" class="w-16 h-16 text-white/10">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <path d="M3 9h18M9 21V9" />
                            </svg>
                        </div>
                        @endif

                        {{-- Certificate Info Body --}}
                        <div class="p-6 md:p-7 relative z-10 bg-slate-950/40 backdrop-blur-sm">
                            <div class="font-display font-bold text-xl text-white mb-2 leading-snug tracking-wide group-hover:text-white/90 transition-colors duration-300">{{ $certificate->title }}</div>
                            <div class="text-white/60 text-sm font-medium mb-4 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/40"></span>
                                <span>{{ $certificate->issuer }}</span>
                            </div>

                            <div class="flex items-center justify-between pt-3 border-t border-white/10">
                                @if($certificate->year)
                                <span class="text-white/80 font-mono text-xs font-semibold tracking-wider px-3 py-1 rounded-full bg-white/5 border border-white/10">{{ $certificate->year }}</span>
                                @endif
                                @if($certificate->credential_url)
                                <a href="{{ $certificate->credential_url }}" target="_blank" rel="noopener" onclick="event.stopPropagation()" class="inline-flex items-center gap-1 text-white/70 text-xs font-bold uppercase tracking-widest hover:text-white transition-colors">
                                    <span>Verify</span>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-3 h-3"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <script>
            (function() {
                var sc = document.getElementById('cert-scroll-container');
                var btnL = document.getElementById('cert-btn-left');
                var btnR = document.getElementById('cert-btn-right');
                var cards = document.querySelectorAll('.cert-3d-card');

                function update3D() {
                    if (!sc || !cards.length) return;
                    
                    // Show/hide scroll buttons
                    btnL.style.opacity = sc.scrollLeft > 15 ? '1' : '0';
                    btnL.style.pointerEvents = sc.scrollLeft > 15 ? 'auto' : 'none';
                    btnR.style.opacity = sc.scrollLeft < sc.scrollWidth - sc.clientWidth - 15 ? '1' : '0';
                    btnR.style.pointerEvents = sc.scrollLeft < sc.scrollWidth - sc.clientWidth - 15 ? 'auto' : 'none';

                    // Center point of container
                    var containerCenter = sc.scrollLeft + (sc.clientWidth / 2);

                    cards.forEach(function(card) {
                        var cardCenter = card.offsetLeft + (card.offsetWidth / 2);
                        var dist = (cardCenter - containerCenter) / (card.offsetWidth * 0.95);
                        var clampedDist = Math.max(-2.5, Math.min(2.5, dist));
                        
                        // 3D U-Shape (Concave Amphitheater Arc Math):
                        // Left & Right cards angle inward facing the user (U-shape curve!)
                        // Center card pops out forward (translateZ 70px, scale 1.07)
                        var rotateY = clampedDist * 26;
                        var translateY = Math.pow(clampedDist, 2) * 6;
                        var translateZ = Math.max(-70, 70 - Math.abs(clampedDist) * 85);
                        var scale = Math.max(0.84, 1.07 - Math.abs(clampedDist) * 0.11);
                        var opacity = Math.max(0.5, 1 - Math.abs(clampedDist) * 0.32);

                        card.style.transform = 'perspective(1200px) rotateY(' + rotateY + 'deg) translateY(' + translateY + 'px) translateZ(' + translateZ + 'px) scale(' + scale + ')';
                        card.style.opacity = opacity;
                        card.style.zIndex = Math.round(100 - Math.abs(clampedDist) * 30);

                        if (Math.abs(clampedDist) < 0.45) {
                            card.classList.add('cert-card-active');
                        } else {
                            card.classList.remove('cert-card-active');
                        }
                    });
                }

                var ticking = false;
                if (sc) {
                    sc.addEventListener('scroll', function() {
                        if (!ticking) {
                            requestAnimationFrame(function() {
                                update3D();
                                ticking = false;
                            });
                            ticking = true;
                        }
                    }, { passive: true });

                    window.addEventListener('resize', update3D);
                    setTimeout(update3D, 150);
                    update3D();
                }

                window.scrollCerts = function(dir) {
                    if (sc) {
                        var scrollAmount = window.innerWidth < 768 ? 320 : 400;
                        sc.scrollBy({ left: dir * scrollAmount, behavior: 'smooth' });
                    }
                };
            })();
        </script>

    </section>
    @endif

    {{-- Certificate Lightbox Modal --}}
    <div id="cert-lightbox" style="display:none; position:fixed; inset:0; z-index:99999; background:rgba(0,0,0,0.92); backdrop-filter:blur(12px); padding:2rem; align-items:center; justify-content:center; cursor:pointer;" onclick="if(event.target===this)closeCertLightbox()">
        <button onclick="event.stopPropagation();closeCertLightbox()" style="position:absolute; top:1.5rem; right:1.5rem; z-index:10; width:3rem; height:3rem; background:rgba(255,255,255,0.1); border:none; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
            <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" style="width:24px;height:24px;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <img id="cert-lightbox-img" src="" alt="" style="max-width:90vw; max-height:85vh; object-fit:contain; border-radius:1rem; box-shadow:0 25px 50px rgba(0,0,0,0.5); cursor:default;" onclick="event.stopPropagation()">
        <div id="cert-lightbox-title" style="position:absolute; bottom:1.5rem; left:50%; transform:translateX(-50%); color:rgba(255,255,255,0.5); font-size:14px; font-family:monospace; text-transform:uppercase; letter-spacing:0.15em;"></div>
    </div>

    <script>
        function openCertLightbox(src, title) {
            var lb = document.getElementById('cert-lightbox');
            document.getElementById('cert-lightbox-img').src = src;
            document.getElementById('cert-lightbox-img').alt = title;
            document.getElementById('cert-lightbox-title').textContent = title;
            lb.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
        function closeCertLightbox() {
            document.getElementById('cert-lightbox').style.display = 'none';
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeCertLightbox();
        });
    </script>

    {{-- ============================================================ --}}
    {{-- CTA SECTION                                                   --}}
    {{-- ============================================================ --}}
    <section class="relative py-32 px-6 z-10 cta-section">
        <div class="max-w-7xl mx-auto" data-reveal="scale" data-delay="0">
            <div class="relative p-16 md:p-28 glass-premium rounded-[3rem] overflow-hidden text-center">
                {{-- Decorative gradient --}}
                <div class="absolute top-0 left-0 w-full h-full bg-linear-to-br from-brand-primary/5 via-transparent to-brand-accent/5 pointer-events-none"></div>

                {{-- Floating orb decoration --}}
                <div class="absolute top-1/4 right-1/4 w-64 h-64 bg-brand-primary/5 rounded-full blur-[100px] animate-pulse pointer-events-none"></div>
                <div class="absolute bottom-1/4 left-1/4 w-48 h-48 bg-brand-secondary/5 rounded-full blur-[80px] animate-pulse pointer-events-none" style="animation-delay: 1s;"></div>

                <div class="relative z-10">
                    <span class="inline-block text-[9px] font-mono uppercase tracking-[0.5em] text-brand-primary/60 mb-8">Let's Collaborate</span>
                    <h2 class="text-5xl md:text-8xl font-display font-bold tracking-tighter mb-8 uppercase leading-[0.85]">
                        Ready to build the <br /><span class="text-gradient-blue">Future?</span>
                    </h2>
                    <p class="text-lg text-white/60 max-w-xl mx-auto mb-14 leading-relaxed">
                        Let's collaborate on your next digital masterpiece.
                        Currently accepting new architectural commissions.
                    </p>
                    <a href="{{ route('contact') }}" class="group inline-flex items-center gap-4 px-12 py-5 bg-white text-black font-bold uppercase tracking-widest rounded-full hover:bg-brand-primary hover:scale-105 transition-all duration-500 hover:shadow-[0_0_50px_rgba(0,242,255,0.3)]" data-magnetic>
                        <span data-magnetic-text class="flex items-center gap-3">
                            Start a Project
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-5 h-5 group-hover:translate-x-1 transition-transform">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slide-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 1s ease-out forwards;
    }

    .animate-slide-up {
        animation: slide-up 1s ease-out forwards;
    }

    /* 3D container styles */
    #hero-3d-container {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }

    #hero-3d-container canvas {
        width: 100% !important;
        height: 100% !important;
    }

    /* Comet canvas subtle glow */
    #comet-container canvas {
        filter: drop-shadow(0 0 25px rgba(0, 242, 255, 0.06));
    }
</style>
@endsection