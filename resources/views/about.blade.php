@extends('app')

@section('title', 'About - Luminescent Architect')

@section('content')
<div class="relative pt-32 pb-24 px-6 overflow-hidden">
    <div class="relative max-w-7xl mx-auto z-10">
        {{-- ============================================================ --}}
        {{-- HERO SECTION                                                  --}}
        {{-- ============================================================ --}}
        <div class="flex flex-col lg:flex-row items-center gap-16 lg:gap-24 mb-40">
            <div class="w-full lg:w-1/2 order-2 lg:order-1">
                <span class="text-brand-primary font-mono text-[10px] uppercase tracking-[0.5em] mb-8 block" data-reveal="fade" data-delay="0">
                    The Digital Architect
                </span>
                <h1 class="text-5xl md:text-8xl font-display font-bold tracking-tighter uppercase mb-12 leading-[0.85]" data-reveal="up" data-delay="100">
                    Designing the <br />
                    <span class="text-gradient-blue" style="filter: drop-shadow(0 0 30px rgba(0, 242, 255, 0.4));">Invisible</span>
                </h1>
                <p class="text-lg md:text-xl text-white/50 leading-relaxed mb-14 max-w-2xl font-light" data-reveal="up" data-delay="200">
                    I specialize in crafting immersive digital environments where human intuition meets architectural precision.
                    My philosophy is simple: <span class="text-white font-medium italic">digital structures should be as enduring and intentional as physical ones.</span>
                </p>

                {{-- Stats --}}
                <div class="grid grid-cols-2 md:flex md:flex-wrap gap-10 md:gap-14" data-reveal="up" data-delay="300">
                    <div class="group cursor-default">
                        <h4 class="text-brand-primary font-display font-bold text-5xl md:text-6xl mb-2 group-hover:scale-110 transition-transform duration-500" data-counter="{{ $profile['years_exp'] ?? '3' }}" data-suffix="+">0</h4>
                        <p class="text-white/25 text-[9px] uppercase tracking-[0.4em] font-bold">Years Experience</p>
                    </div>
                    <div class="group cursor-default">
                        <h4 class="text-brand-secondary font-display font-bold text-5xl md:text-6xl mb-2 group-hover:scale-110 transition-transform duration-500" data-counter="{{ $profile['projects_count'] ?? '20' }}" data-suffix="+">0</h4>
                        <p class="text-white/25 text-[9px] uppercase tracking-[0.4em] font-bold">Projects Built</p>
                    </div>
                </div>
            </div>

            {{-- Photo --}}
            <div class="w-full lg:w-1/2 order-1 lg:order-2 flex justify-center lg:justify-end">
                <div class="relative group w-full max-w-md" data-reveal="scale" data-delay="200">
                    {{-- Glow backdrop --}}
                    <div class="absolute -inset-4 bg-linear-to-br from-brand-primary/20 to-brand-secondary/20 rounded-[40px] blur-3xl opacity-20 group-hover:opacity-50 transition-opacity duration-1000"></div>

                    <div class="relative aspect-square glass-premium rounded-[40px] overflow-hidden p-2 md:p-4" data-tilt>
                        <div data-tilt-glow></div>
                        {{-- Dark overlay that fades on hover --}}
                        <div class="absolute inset-0 bg-black/20 z-10 transition-opacity duration-700 group-hover:opacity-0 pointer-events-none rounded-[32px]"></div>

                        <img
                            src="{{ $profile['photo_url'] ?? 'https://picsum.photos/seed/architect-portrait/800/800' }}"
                            alt="{{ $profile['name'] ?? 'Architect' }}"
                            loading="lazy"
                            decoding="async"
                            class="w-full h-full object-cover rounded-[32px] grayscale group-hover:grayscale-0 transition-all duration-1000 scale-105 group-hover:scale-100" />

                        {{-- Decorative Elements --}}
                        <div class="absolute top-8 right-8 z-20 pointer-events-none">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-brand-primary animate-spin-slow opacity-40">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                            </svg>
                        </div>
                        <div class="absolute bottom-8 left-8 z-20 pointer-events-none">
                            <div class="glass-premium px-5 py-2.5 rounded-full">
                                <span class="text-[9px] font-mono uppercase tracking-[0.3em] text-white/70">Based in {{ $profile['location'] ?? 'Jakarta' }}</span>
                            </div>
                        </div>

                        {{-- Status indicator --}}
                        <div class="absolute top-8 left-8 z-20 pointer-events-none">
                            <div class="flex items-center gap-2 glass-premium px-4 py-2 rounded-full">
                                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse shadow-[0_0_8px_rgba(74,222,128,0.6)]"></span>
                                <span class="text-[8px] font-mono uppercase tracking-[0.3em] text-white/60">Available</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- ANIMATED DIVIDER                                              --}}
        {{-- ============================================================ --}}
        <div class="animated-divider mb-40" data-reveal="fade"></div>

        {{-- ============================================================ --}}
        {{-- CORE PRINCIPLES — BENTO GRID                                  --}}
        {{-- ============================================================ --}}
        <div class="mb-40">
            <div class="text-center mb-20">
                <span class="text-brand-primary font-mono text-[10px] uppercase tracking-[0.5em] mb-6 block" data-reveal="fade">Core Values</span>
                <h2 class="text-4xl md:text-6xl font-display font-bold tracking-tighter uppercase" data-reveal="up" data-delay="100">
                    What <span class="text-gradient-blue">Drives</span> Me
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="feature-card glass-premium p-12 rounded-4xl relative overflow-hidden group" data-tilt data-reveal="up" data-delay="0" style="--card-accent: #00f2ff;">
                    <div data-tilt-glow></div>
                    <div class="relative z-10">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-brand-primary/5 blur-3xl rounded-full group-hover:bg-brand-primary/10 transition-colors pointer-events-none"></div>
                        <div class="w-14 h-14 text-brand-primary mb-8 group-hover:scale-110 transition-transform duration-500">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-full h-full">
                                <polygon points="12 2 2 7 12 12 22 7 12 2" />
                                <polyline points="2 17 12 22 22 17" />
                                <polyline points="2 12 12 17 22 12" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-display font-bold uppercase tracking-widest mb-6 group-hover:text-brand-primary transition-colors duration-500">Structural Integrity</h3>
                        <p class="text-white/40 leading-relaxed">
                            Code is my foundation. I architect clean, scalable, and performant systems that stand the test of time and traffic.
                        </p>
                    </div>
                </div>

                <div class="feature-card glass-premium p-12 rounded-4xl relative overflow-hidden group" data-tilt data-reveal="up" data-delay="150" style="--card-accent: #7000ff;">
                    <div data-tilt-glow></div>
                    <div class="relative z-10">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-brand-secondary/5 blur-3xl rounded-full group-hover:bg-brand-secondary/10 transition-colors pointer-events-none"></div>
                        <div class="w-14 h-14 text-brand-secondary mb-8 group-hover:scale-110 transition-transform duration-500">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-full h-full">
                                <rect x="4" y="4" width="16" height="16" rx="2" ry="2" />
                                <rect x="9" y="9" width="6" height="6" />
                                <line x1="9" y1="1" x2="9" y2="4" />
                                <line x1="15" y1="1" x2="15" y2="4" />
                                <line x1="9" y1="20" x2="9" y2="23" />
                                <line x1="15" y1="20" x2="15" y2="23" />
                                <line x1="20" y1="9" x2="23" y2="9" />
                                <line x1="20" y1="15" x2="23" y2="15" />
                                <line x1="1" y1="9" x2="4" y2="9" />
                                <line x1="1" y1="15" x2="4" y2="15" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-display font-bold uppercase tracking-widest mb-6 group-hover:text-brand-secondary transition-colors duration-500">Neural UX</h3>
                        <p class="text-white/40 leading-relaxed">
                            Interfaces that feel like an extension of the mind. I focus on cognitive load reduction and intuitive motion flow.
                        </p>
                    </div>
                </div>

                <div class="feature-card glass-premium p-12 rounded-4xl relative overflow-hidden group" data-tilt data-reveal="up" data-delay="300" style="--card-accent: #ff0099;">
                    <div data-tilt-glow></div>
                    <div class="relative z-10">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-brand-accent/5 blur-3xl rounded-full group-hover:bg-brand-accent/10 transition-colors pointer-events-none"></div>
                        <div class="w-14 h-14 text-brand-accent mb-8 group-hover:scale-110 transition-transform duration-500">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-full h-full">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="2" y1="12" x2="22" y2="12" />
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-display font-bold uppercase tracking-widest mb-6 group-hover:text-brand-accent transition-colors duration-500">Global Reach</h3>
                        <p class="text-white/40 leading-relaxed">
                            Designing for a connected world. My architectures are inclusive, accessible, and culturally resonant.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- EXPERTISE SECTION                                             --}}
        {{-- ============================================================ --}}
        <div class="mb-40">
            <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
                <div class="max-w-2xl">
                    <span class="text-brand-primary font-mono text-[10px] uppercase tracking-[0.5em] mb-6 block" data-reveal="fade">Expertise</span>
                    <h2 class="text-5xl md:text-7xl font-display font-bold uppercase tracking-tighter leading-none" data-reveal="up" data-delay="100">
                        Technical <br /><span class="text-gradient-blue">Mastery</span>
                    </h2>
                </div>
                <p class="text-white/30 max-w-sm text-right leading-relaxed text-sm" data-reveal="fade" data-delay="200">
                    A curated stack of technologies and methodologies refined over years of professional practice.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach([
                ['icon' => 'M16 18l6-6-6-6M8 6l-6 6 6 6', 'label' => 'Full-Stack Dev', 'color' => 'brand-primary', 'accent' => '#00f2ff'],
                ['icon' => 'M13 2L3 14h9l-1 8 10-12h-9l1-8z', 'label' => 'Performance', 'color' => 'brand-secondary', 'accent' => '#7000ff'],
                ['icon' => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z', 'label' => 'Security', 'color' => 'brand-accent', 'accent' => '#ff0099'],
                ['icon' => 'M12 15l-2 5L9 9l11 4-5 2zm0 0l4 4', 'label' => 'UI/UX Design', 'color' => 'white', 'accent' => '#ffffff'],
                ] as $index => $skill)
                <div class="feature-card glass-premium p-8 rounded-4xl flex flex-col items-center text-center group" data-tilt data-reveal="up" data-delay="{{ $index * 100 }}" style="--card-accent: {{ $skill['accent'] }};">
                    <div data-tilt-glow></div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="text-{{ $skill['color'] }} mb-6 group-hover:scale-110 transition-transform duration-500">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8">
                                <path d="{{ $skill['icon'] }}"></path>
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/70 group-hover:text-white transition-colors duration-300">{{ $skill['label'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- PHILOSOPHY SECTION                                            --}}
        {{-- ============================================================ --}}
        <section class="relative py-32 text-center overflow-hidden">
            <div class="absolute inset-0 flex items-center justify-center opacity-[0.02] pointer-events-none select-none">
                <h2 class="text-[25vw] font-display font-black uppercase tracking-tighter leading-none">
                    Vision
                </h2>
            </div>
            <div class="relative z-10 max-w-4xl mx-auto">
                <h2 class="text-brand-primary font-mono text-[9px] uppercase tracking-[0.6em] mb-14" data-reveal="fade">The Philosophy</h2>
                <blockquote class="text-3xl md:text-5xl font-display font-bold uppercase tracking-tight leading-tight mb-14" data-reveal="up" data-delay="100">
                    "We shape our digital structures; thereafter they shape our <span class="text-gradient-blue" style="filter: drop-shadow(0 0 20px rgba(0, 242, 255, 0.4));">perception of reality</span>."
                </blockquote>
                <div class="animated-divider w-32 mx-auto" data-reveal="scale" data-delay="200"></div>
            </div>
        </section>
    </div>
</div>
@endsection