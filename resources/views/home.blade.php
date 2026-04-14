@extends('app')

@section('title', 'Home - Luminescent Architect')

@section('content')
<div class="relative pt-20 overflow-hidden">
    {{-- ============================================================ --}}
    {{-- HERO SECTION — 3D Interactive                                 --}}
    {{-- ============================================================ --}}
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden px-6">
        {{-- Three.js 3D Canvas --}}
        <div id="hero-3d-container" class="absolute inset-0 z-0"></div>

        {{-- Comet Canvas --}}
        <div id="comet-container" class="absolute inset-0 z-1 pointer-events-none"></div>

        {{-- Gradient overlays for depth --}}
        <div class="absolute inset-0 z-2 pointer-events-none bg-linear-to-b from-black/40 via-transparent to-black/60"></div>

        {{-- Hero Content --}}
        <div class="relative z-10 max-w-6xl mx-auto text-center">
            <div>
                {{-- Badge --}}
                <span class="hero-badge inline-block px-6 py-2 glass-premium rounded-full text-[10px] font-bold uppercase tracking-[0.4em] text-brand-primary mb-10" data-reveal="scale" data-delay="200">
                    {{ $profile['hero_badge'] ?? 'Digital Architect & Designer' }}
                </span>

                {{-- Main Title --}}
                <h1 class="text-6xl md:text-8xl lg:text-9xl font-display font-bold tracking-tighter mb-10 leading-[0.85] uppercase" data-reveal="up" data-delay="400">
                    @if(isset($profile['hero_line1']) || isset($profile['hero_line2']))
                    {{ $profile['hero_line1'] ?? '' }}
                    @if(isset($profile['hero_line2']))
                    <br /> <span class="text-gradient-blue" style="filter: drop-shadow(0 0 40px rgba(0, 242, 255, 0.5)) drop-shadow(0 0 80px rgba(0, 168, 255, 0.3));">{{ $profile['hero_line2'] }}</span>
                    @endif
                    @else
                    {{ $siteSettings['site_name'] ?? 'LUMINESCENT ARCHITECT' }}
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
            <span class="text-[9px] font-mono uppercase tracking-[0.4em] text-white/30">Scroll to explore</span>
            <div class="relative w-5 h-8 rounded-full border border-white/20">
                <div class="absolute top-1.5 left-1/2 -translate-x-1/2 w-1 h-2 rounded-full bg-brand-primary animate-bounce"></div>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- TECH MARQUEE DIVIDER                                          --}}
    {{-- ============================================================ --}}
    @if($siteSettings['show_tech_marquee'] ?? true)
    <div class="overflow-hidden py-8 border-y border-white/4" data-reveal="fade" data-delay="0">
        <div class="marquee-track text-4xl md:text-5xl font-display font-black uppercase tracking-tighter text-white/12 leading-none whitespace-nowrap">
            <span>Laravel ◆ React ◆ Vue.js ◆ TypeScript ◆ Three.js ◆ Tailwind ◆ Node.js ◆ PostgreSQL ◆ Docker ◆ AWS ◆&nbsp;</span>
            <span>Laravel ◆ React ◆ Vue.js ◆ TypeScript ◆ Three.js ◆ Tailwind ◆ Node.js ◆ PostgreSQL ◆ Docker ◆ AWS ◆&nbsp;</span>
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
                        <p class="text-white/40 leading-relaxed text-sm">
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
                        <p class="text-white/40 leading-relaxed text-sm">
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
                        <p class="text-white/40 leading-relaxed text-sm">
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
                <a href="{{ route('projects') }}" class="group text-white/40 hover:text-white flex items-center gap-3 uppercase tracking-widest text-[10px] font-bold transition-all duration-300" data-reveal="fade" data-delay="200">
                    View All Projects
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4 group-hover:translate-x-1 transition-transform">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($projects as $index => $project)
                <div class="project-card group relative" data-reveal="up" data-delay="{{ $loop->index * 150 }}">
                    {{-- Image --}}
                    <div class="project-image-wrap aspect-4/5 bg-white/5 rounded-4xl mb-8 shadow-2xl overflow-hidden" data-img-reveal>
                        {{-- Project index number --}}
                        <span class="project-index font-display">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>

                        <img
                            src="{{ $project->image }}"
                            alt="{{ $project->title }}"
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
                            <span class="text-brand-primary font-mono text-[9px] uppercase tracking-[0.3em] mb-2 block">{{ $project->category }}</span>
                            <h4 class="text-xl font-display font-bold uppercase tracking-tight group-hover:text-brand-primary transition-colors duration-500">{{ $project->title }}</h4>
                        </div>
                        <span class="text-white/20 font-mono text-[10px] tracking-widest mt-1">{{ $project->year }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- TESTIMONIALS                                                   --}}
    {{-- ============================================================ --}}
    @if(($siteSettings['enable_testimonials'] ?? true) && isset($testimonials) && $testimonials->isNotEmpty())
    <section class="relative py-32 px-6 z-10">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20">
                <span class="text-brand-primary font-mono text-[10px] uppercase tracking-[0.5em] mb-6 block" data-reveal="fade" data-delay="0">Social Proof</span>
                <h2 class="text-4xl md:text-6xl font-display font-bold tracking-tighter uppercase" data-reveal="up" data-delay="100">
                    Client <span class="text-gradient-blue">Voices</span>
                </h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($testimonials as $i => $testimonial)
                <div class="glass-premium p-8 rounded-3xl group hover:border-white/20 transition-all duration-500 flex flex-col" data-tilt data-reveal="up" data-delay="{{ $loop->index * 100 }}" style="--card-accent: #00f2ff;">
                    <div data-tilt-glow></div>
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="text-brand-primary text-lg mb-6 tracking-wider">{{ $testimonial->stars }}</div>
                        <blockquote class="text-white/60 leading-relaxed text-sm flex-1 mb-6 italic">
                            "{{ $testimonial->content }}"
                        </blockquote>
                        <div class="flex items-center gap-4 pt-6 border-t border-white/5">
                            @if($testimonial->avatar_url)
                            <img src="{{ $testimonial->avatar_url }}" alt="{{ $testimonial->name }}" class="w-10 h-10 rounded-full object-cover bg-white/5">
                            @else
                            <div class="w-10 h-10 rounded-full bg-brand-primary/10 flex items-center justify-center text-brand-primary font-bold text-sm">
                                {{ substr($testimonial->name, 0, 1) }}
                            </div>
                            @endif
                            <div>
                                <div class="font-bold text-sm">{{ $testimonial->name }}</div>
                                <div class="text-white/30 text-[10px] uppercase tracking-widest">{{ $testimonial->title }}{{ $testimonial->company ? ' @ ' . $testimonial->company : '' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

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
                    <p class="text-lg text-white/40 max-w-xl mx-auto mb-14 leading-relaxed">
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