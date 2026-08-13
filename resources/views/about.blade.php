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
                    {{ $profile['tagline'] ?? 'The Digital Architect' }}
                </span>

                @php
                    $rawName = !empty($profile['name']) ? $profile['name'] : 'Zaky Manggala Putra Santoso';
                    $nameParts = explode(' ', trim($rawName));
                    if (count($nameParts) > 1) {
                        $half = ceil(count($nameParts) / 2);
                        $firstHalf = implode(' ', array_slice($nameParts, 0, $half));
                        $secondHalf = implode(' ', array_slice($nameParts, $half));
                    } else {
                        $firstHalf = '';
                        $secondHalf = $rawName;
                    }
                @endphp

                <h1 class="text-4xl md:text-6xl lg:text-7xl font-display font-bold tracking-tighter uppercase mb-8 leading-[0.9]" data-reveal="up" data-delay="100">
                    @if(!empty($firstHalf))
                        {{ $firstHalf }} <br />
                    @endif
                    <span class="text-gradient-blue" style="filter: drop-shadow(0 0 30px rgba(0, 242, 255, 0.4));">{{ $secondHalf }}</span>
                </h1>

                <p class="text-base md:text-lg text-white/60 leading-relaxed mb-12 max-w-2xl font-light" data-reveal="up" data-delay="200">
                    {{ $profile['bio'] ?? 'Computer Science student and full-stack developer specializing in building modern web applications, AI integrations, and creative tech.' }}
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
                {{-- Card 1: Problem Solving & Algorithmic Logic --}}
                <div class="feature-card glass-premium p-10 md:p-12 rounded-3xl relative overflow-hidden group border border-white/10 hover:border-white/25 transition-all duration-500" data-tilt data-reveal="up" data-delay="0">
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-8">
                            <span class="font-mono text-xs font-semibold text-white/50 tracking-widest px-3.5 py-1.5 rounded-full bg-white/5 border border-white/10 group-hover:border-white/20 group-hover:text-white transition-all duration-300">
                                // 01
                            </span>
                            <span class="font-mono text-[10px] text-white/30 tracking-widest uppercase">Core / Logic</span>
                        </div>
                        <h3 class="text-xl md:text-2xl font-display font-bold uppercase tracking-wider mb-4 text-white group-hover:text-white/90 transition-colors">
                            Algorithmic Logic
                        </h3>
                        <p class="text-white/50 text-sm leading-relaxed">
                            Driven by curiosity to decompose complex problems, optimize algorithms, and write efficient, well-structured code from the ground up.
                        </p>
                    </div>
                </div>

                {{-- Card 2: Software Craftsmanship & Full-Stack --}}
                <div class="feature-card glass-premium p-10 md:p-12 rounded-3xl relative overflow-hidden group border border-white/10 hover:border-white/25 transition-all duration-500" data-tilt data-reveal="up" data-delay="150">
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-8">
                            <span class="font-mono text-xs font-semibold text-white/50 tracking-widest px-3.5 py-1.5 rounded-full bg-white/5 border border-white/10 group-hover:border-white/20 group-hover:text-white transition-all duration-300">
                                // 02
                            </span>
                            <span class="font-mono text-[10px] text-white/30 tracking-widest uppercase">Dev / Craft</span>
                        </div>
                        <h3 class="text-xl md:text-2xl font-display font-bold uppercase tracking-wider mb-4 text-white group-hover:text-white/90 transition-colors">
                            Software Craftsmanship
                        </h3>
                        <p class="text-white/50 text-sm leading-relaxed">
                            Building clean, performant web applications with intuitive user experiences. Bridging computer science theory with modern full-stack development.
                        </p>
                    </div>
                </div>

                {{-- Card 3: Continuous Discovery & Growth --}}
                <div class="feature-card glass-premium p-10 md:p-12 rounded-3xl relative overflow-hidden group border border-white/10 hover:border-white/25 transition-all duration-500" data-tilt data-reveal="up" data-delay="300">
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-8">
                            <span class="font-mono text-xs font-semibold text-white/50 tracking-widest px-3.5 py-1.5 rounded-full bg-white/5 border border-white/10 group-hover:border-white/20 group-hover:text-white transition-all duration-300">
                                // 03
                            </span>
                            <span class="font-mono text-[10px] text-white/30 tracking-widest uppercase">Growth / Stack</span>
                        </div>
                        <h3 class="text-xl md:text-2xl font-display font-bold uppercase tracking-wider mb-4 text-white group-hover:text-white/90 transition-colors">
                            Continuous Discovery
                        </h3>
                        <p class="text-white/50 text-sm leading-relaxed">
                            Passionate about exploring emerging technologies, software architecture, and new frameworks—constantly expanding my toolkit through real-world projects.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- EXPERTISE SECTION — DYNAMIC FROM ADMIN                        --}}
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

            @if($skills->isNotEmpty())
            @foreach($skills as $category => $categorySkills)
            <div class="mb-12" data-reveal="up">
                <h3 class="text-xs md:text-sm font-mono uppercase tracking-[0.3em] text-brand-primary font-semibold mb-6 flex items-center gap-4">
                    {{ $category }}
                    <span class="flex-1 h-px bg-white/10"></span>
                    <span class="text-white/50 text-xs font-mono">{{ $categorySkills->count() }} skills</span>
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @foreach($categorySkills as $skill)
                    <div class="group glass-premium rounded-2xl p-7 hover:border-white/20 transition-all duration-500" data-tilt style="--card-accent: #00f2ff;">
                        <div data-tilt-glow></div>
                        <div class="relative z-10">
                            <div class="flex justify-between items-start mb-4 gap-4">
                                <div>
                                    <h4 class="font-display font-bold text-lg md:text-xl text-white tracking-wide group-hover:text-brand-primary transition-colors duration-300">{{ $skill->name }}</h4>
                                    @if($skill->description)
                                    <p class="text-white/60 text-sm mt-1.5 leading-relaxed">{{ $skill->description }}</p>
                                    @endif
                                </div>
                                @php
                                    $proficiencyClass = match($skill->proficiency_level) {
                                        'Expert' => 'bg-brand-primary/15 text-brand-primary border border-brand-primary/30',
                                        'Advanced' => 'bg-brand-secondary/15 text-brand-secondary border border-brand-secondary/30',
                                        default => 'bg-white/10 text-white/70 border border-white/10',
                                    };
                                @endphp
                                <span @class(['text-xs font-mono uppercase tracking-wider px-3.5 py-1 rounded-full font-semibold flex-shrink-0', $proficiencyClass])>
                                    {{ $skill->proficiency_level }}
                                </span>
                            </div>
                            <div class="relative h-1.5 bg-white/10 rounded-full overflow-hidden mt-3">
                                <div class="absolute left-0 top-0 h-full rounded-full transition-all duration-1000 group-hover:opacity-100 opacity-80"
                                     @style([
                                         'width: ' . $skill->proficiency . '%',
                                         'background: linear-gradient(90deg, #00f2ff, #7000ff)'
                                     ])></div>
                            </div>
                            <div class="flex justify-end mt-2">
                                <span class="text-xs font-mono font-medium text-white/60">{{ $skill->proficiency }}%</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
            @else
            {{-- Fallback to static if no skills in DB --}}
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
            @endif
        </div>

        {{-- ============================================================ --}}
        {{-- EXPERIENCE / CAREER TIMELINE — ENHANCED                       --}}
        {{-- ============================================================ --}}
        @if($experiences->isNotEmpty())
        <div class="mb-40">
            <div class="text-center mb-20">
                <span class="text-brand-primary font-mono text-[10px] uppercase tracking-[0.5em] mb-6 block" data-reveal="fade">Career Path</span>
                <h2 class="text-4xl md:text-6xl font-display font-bold tracking-tighter uppercase" data-reveal="up" data-delay="100">
                    The <span class="text-gradient-blue">Journey</span>
                </h2>
            </div>

            <div class="relative timeline-container">
                {{-- Animated SVG timeline line (desktop only) --}}
                <div class="hidden md:block absolute left-1/2 top-0 bottom-0 -translate-x-1/2 pointer-events-none">
                    <svg class="timeline-svg w-1 h-full" viewBox="0 0 4 1000" preserveAspectRatio="none">
                        {{-- Background track --}}
                        <line x1="2" y1="0" x2="2" y2="1000" stroke="rgba(255,255,255,0.04)" stroke-width="2" />
                        {{-- Animated progress line --}}
                        <line x1="2" y1="0" x2="2" y2="1000" stroke="url(#timeline-gradient)" stroke-width="2"
                              stroke-dasharray="1000" stroke-dashoffset="1000" class="timeline-progress" />
                        <defs>
                            <linearGradient id="timeline-gradient" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#00f2ff" stop-opacity="0.8" />
                                <stop offset="50%" stop-color="#7000ff" stop-opacity="0.6" />
                                <stop offset="100%" stop-color="#ff0099" stop-opacity="0.4" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>

                {{-- Mobile timeline line --}}
                <div class="md:hidden absolute left-6 top-0 bottom-0 w-px bg-gradient-to-b from-brand-primary/30 via-brand-secondary/20 to-transparent"></div>

                <div class="flex flex-col gap-20 md:gap-28">
                    @foreach($experiences as $i => $exp)
                    <div class="relative flex flex-col md:flex-row items-center gap-8 {{ $i % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse' }} timeline-item group"
                         data-reveal="up" data-delay="{{ $i * 120 }}">

                        {{-- Large decorative number (desktop background) --}}
                        <div class="hidden md:flex absolute top-1/2 -translate-y-1/2 {{ $i % 2 === 0 ? 'right-[51%]' : 'left-[51%]' }} pointer-events-none select-none z-0">
                            <span class="font-display font-black text-[130px] leading-none opacity-[0.03] text-white"
                                  style="background: linear-gradient(180deg, rgba(0,242,255,0.2), transparent); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>

                        {{-- Timeline node --}}
                        <div class="absolute left-6 md:left-1/2 top-8 md:top-1/2 -translate-x-1/2 -translate-y-1/2 z-20">
                            @if($exp->is_current)
                            {{-- Active node with pulse rings --}}
                            <div class="relative">
                                <div class="absolute inset-0 w-6 h-6 -m-1 rounded-full bg-brand-primary/30 animate-ping"></div>
                                <div class="absolute inset-0 w-6 h-6 -m-1 rounded-full bg-brand-primary/20 animate-pulse"></div>
                                <div class="w-4 h-4 rounded-full bg-brand-primary shadow-[0_0_24px_rgba(0,242,255,0.9),0_0_48px_rgba(0,242,255,0.4)] border-2 border-white"></div>
                            </div>
                            @else
                            {{-- Regular node --}}
                            <div class="w-4 h-4 rounded-full bg-slate-900 border-2 border-white/30 group-hover:border-brand-primary group-hover:bg-brand-primary/20 group-hover:shadow-[0_0_18px_rgba(0,242,255,0.6)] transition-all duration-500"></div>
                            @endif
                        </div>

                        {{-- Content Card --}}
                        <div class="ml-16 md:ml-0 md:w-[46%] {{ $i % 2 === 0 ? 'md:mr-auto md:pr-6' : 'md:ml-auto md:pl-6' }} z-10 w-full">
                            <div class="glass-premium p-8 md:p-10 rounded-3xl group-hover:border-white/20 transition-all duration-500 relative overflow-hidden" data-tilt>
                                <div data-tilt-glow></div>

                                {{-- Subtle gradient accent --}}
                                <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-brand-primary/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>

                                <div class="relative z-10">
                                    {{-- Header --}}
                                    <div class="flex items-start gap-4 mb-5">
                                        @if($exp->logo_url_formatted)
                                        <div class="relative flex-shrink-0">
                                            <img src="{{ $exp->logo_url_formatted }}" alt="{{ $exp->company }}" class="w-12 h-12 rounded-xl object-cover bg-white/5 ring-1 ring-white/10 group-hover:ring-brand-primary/40 transition-all duration-500">
                                        </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-3 flex-wrap mb-2">
                                                <span class="text-[10px] font-mono uppercase tracking-[0.2em] px-3.5 py-1.5 rounded-full font-bold
                                                    {{ $exp->type === 'work' ? 'bg-brand-primary/15 text-brand-primary border border-brand-primary/30' : 'bg-brand-secondary/15 text-brand-secondary border border-brand-secondary/30' }}">
                                                    {{ $exp->type === 'work' ? '💼 Work' : '🎓 Education' }}
                                                </span>
                                                @if($exp->is_current)
                                                <span class="text-[10px] font-mono uppercase tracking-[0.2em] px-3.5 py-1.5 rounded-full bg-green-500/15 text-green-400 border border-green-500/30 flex items-center gap-1.5 font-bold">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse shadow-[0_0_6px_rgba(74,222,128,0.6)]"></span>
                                                    Current
                                                </span>
                                                @endif
                                            </div>
                                            <h4 class="font-display font-bold text-xl md:text-2xl text-white group-hover:text-brand-primary transition-colors duration-300 leading-tight">{{ $exp->title }}</h4>
                                            <p class="text-white/50 text-sm font-medium mt-1">{{ $exp->company }}{{ $exp->location ? ' · ' . $exp->location : '' }}</p>
                                        </div>
                                    </div>

                                    {{-- Date badge --}}
                                    <div class="inline-flex items-center gap-2 mb-5 px-4 py-2 rounded-full bg-white/[0.03] border border-white/[0.06]">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-3.5 h-3.5 text-brand-primary/70">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" /><line x1="16" y1="2" x2="16" y2="6" /><line x1="8" y1="2" x2="8" y2="6" /><line x1="3" y1="10" x2="21" y2="10" />
                                        </svg>
                                        <span class="text-brand-primary/80 text-xs font-mono font-medium tracking-wider">{{ $exp->date_range }}</span>
                                        <span class="text-white/20">·</span>
                                        <span class="text-white/40 text-xs font-mono">{{ $exp->duration }}</span>
                                    </div>

                                    {{-- Description --}}
                                    @if($exp->description)
                                    <p class="text-white/60 text-sm leading-relaxed mb-5">{{ $exp->description }}</p>
                                    @endif

                                    {{-- Highlights --}}
                                    @if($exp->highlights && count($exp->highlights) > 0)
                                    <div class="space-y-2.5 pt-5 border-t border-white/[0.06]">
                                        @foreach($exp->highlights as $highlight)
                                        <div class="flex items-start gap-3 text-sm group/item">
                                            <span class="w-1.5 h-1.5 rounded-full bg-brand-primary/50 mt-1.5 flex-shrink-0 group-hover/item:bg-brand-primary group-hover/item:shadow-[0_0_8px_rgba(0,242,255,0.4)] transition-all duration-300"></span>
                                            <span class="text-white/50 group-hover/item:text-white/80 transition-colors duration-300">{{ $highlight }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Opposite Side: Immersive Brush-Masked Location Photo --}}
                        <div class="ml-16 md:ml-0 md:w-[48%] {{ $i % 2 === 0 ? 'md:ml-auto md:pl-6' : 'md:mr-auto md:pr-6' }} flex items-center justify-center z-10 w-full">
                            <div class="w-full max-w-xl brush-mask-container cursor-pointer group/photo"
                                 onclick="openLocationModal('{{ $exp->location_photo_url }}', '{{ addslashes($exp->company ?? $exp->title) }}', '{{ addslashes($exp->location ?? '') }}')">
                                
                                <div class="brush-mask-wrapper">
                                    <img src="{{ $exp->location_photo_url }}" 
                                         alt="{{ $exp->company }} Location" 
                                         class="brush-mask-image shadow-2xl" 
                                         loading="lazy">
                                </div>

                                {{-- Minimalist Overlay Pills --}}
                                <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between pointer-events-none z-20">
                                    @if($exp->location || $exp->company)
                                    <div class="px-4 py-2 rounded-full bg-black/80 backdrop-blur-md border border-white/10 text-xs font-mono text-white/80 tracking-wider flex items-center gap-2 shadow-2xl group-hover/photo:border-white/30 transition-all duration-300">
                                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                        <span>{{ $exp->location ?? $exp->company }}</span>
                                    </div>
                                    @endif

                                    <div class="px-3 py-1.5 rounded-full bg-black/80 backdrop-blur-md border border-white/10 text-[10px] font-mono text-white/60 tracking-widest uppercase flex items-center gap-1.5 opacity-0 group-hover/photo:opacity-100 transition-opacity duration-300 ml-auto">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-3 h-3"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
                                        <span>Expand</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Interactive Location Photo Lightbox Modal --}}
        <div id="location-lightbox" class="fixed inset-0 z-[99999] hidden items-center justify-center p-4 md:p-10 bg-black/92 backdrop-blur-xl transition-all duration-300" onclick="if(event.target === this) closeLocationModal()">
            <button onclick="closeLocationModal()" class="absolute top-6 right-6 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all duration-300 border border-white/10 z-50">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="w-6 h-6"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
            <div class="relative max-w-5xl w-full max-h-[85vh] flex flex-col items-center justify-center">
                <img id="lightbox-img" src="" alt="Location Photo" class="max-h-[70vh] w-auto max-w-full rounded-2xl object-contain border border-white/15 shadow-2xl">
                <div class="mt-6 text-center">
                    <h3 id="lightbox-title" class="font-display text-2xl font-bold text-white tracking-tight"></h3>
                    <p id="lightbox-subtitle" class="font-mono text-sm text-white/50 mt-1.5"></p>
                </div>
            </div>
        </div>

        {{-- Timeline scroll animation script --}}
        @push('scripts')
        <script>
        function openLocationModal(imgUrl, title, location) {
            const modal = document.getElementById('location-lightbox');
            if (!modal) return;
            document.getElementById('lightbox-img').src = imgUrl;
            document.getElementById('lightbox-title').textContent = title;
            document.getElementById('lightbox-subtitle').textContent = location ? '📍 ' + location : '';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeLocationModal() {
            const modal = document.getElementById('location-lightbox');
            if (!modal) return;
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeLocationModal();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const timelineContainer = document.querySelector('.timeline-container');
            if (!timelineContainer) return;

            const progressLine = timelineContainer.querySelector('.timeline-progress');
            if (!progressLine) return;

            function updateTimelineProgress() {
                const rect = timelineContainer.getBoundingClientRect();
                const windowHeight = window.innerHeight;
                const containerHeight = rect.height;

                // Calculate how much of the timeline is visible/scrolled
                const scrolled = Math.max(0, windowHeight - rect.top);
                const totalScroll = containerHeight + windowHeight;
                const progress = Math.min(1, scrolled / totalScroll);

                // Update SVG line (stroke-dashoffset from 1000 to 0)
                const offset = 1000 - (progress * 1000);
                progressLine.setAttribute('stroke-dashoffset', offset);
            }

            // Throttle scroll handler
            let ticking = false;
            window.addEventListener('scroll', function() {
                if (!ticking) {
                    requestAnimationFrame(function() {
                        updateTimelineProgress();
                        ticking = false;
                    });
                    ticking = true;
                }
            }, { passive: true });

            // Initial call
            updateTimelineProgress();
        });
        </script>
        @endpush
        @endif

        {{-- ============================================================ --}}
        {{-- HOW I BUILD + BEYOND THE CODE                                  --}}
        {{-- ============================================================ --}}
        <div class="mb-40">
            {{-- HOW I BUILD --}}
            <div class="mb-32" data-reveal="up">
                <div class="text-center mb-20">
                    <span class="text-brand-primary font-mono text-[10px] uppercase tracking-[0.5em] mb-6 block" data-reveal="fade">Methodology</span>
                    <h2 class="text-4xl md:text-6xl font-display font-bold tracking-tighter uppercase" data-reveal="up" data-delay="100">
                        How I <span class="text-gradient-blue">Build</span>
                    </h2>
                    <p class="text-white/30 max-w-lg mx-auto mt-6 text-sm leading-relaxed" data-reveal="fade" data-delay="200">
                        Every project follows a structured process — from understanding the problem to shipping a polished solution.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                    @php
                    $steps = [
                        ['num' => '01', 'icon' => '<circle cx="11" cy="11" r="8" /><line x1="21" y1="21" x2="16.65" y2="16.65" />', 'title' => 'Research', 'desc' => 'Understand the problem, audience, and constraints before writing a single line.'],
                        ['num' => '02', 'icon' => '<rect x="3" y="3" width="18" height="18" rx="2" ry="2" /><line x1="3" y1="9" x2="21" y2="9" /><line x1="9" y1="21" x2="9" y2="9" />', 'title' => 'Design', 'desc' => 'Plan the architecture, data flow, and user experience.'],
                        ['num' => '03', 'icon' => '<polyline points="16 18 22 12 16 6" /><polyline points="8 6 2 12 8 18" />', 'title' => 'Build', 'desc' => 'Clean, scalable code with modern tools and best practices.'],
                        ['num' => '04', 'icon' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />', 'title' => 'Test', 'desc' => 'Automated tests, edge cases, and cross-browser checks.'],
                        ['num' => '05', 'icon' => '<path d="M22 2L11 13" /><polygon points="22 2 15 22 11 13 2 9 22 2" />', 'title' => 'Deploy', 'desc' => 'Ship with CI/CD, monitor performance, iterate fast.'],
                    ];
                    @endphp

                    @foreach($steps as $i => $step)
                    <div class="glass-premium p-8 rounded-3xl group hover:border-white/20 transition-all duration-500 text-center relative" data-tilt data-reveal="up" data-delay="{{ $i * 100 }}" style="--card-accent: #00f2ff;">
                        <div data-tilt-glow></div>
                        <div class="relative z-10">
                            <span class="text-brand-primary/30 font-display font-black text-5xl absolute -top-2 left-1/2 -translate-x-1/2 opacity-20 group-hover:opacity-40 transition-opacity">{{ $step['num'] }}</span>
                            <div class="w-12 h-12 mx-auto mb-6 text-brand-primary group-hover:scale-110 transition-transform duration-500 relative z-10 mt-4">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-full h-full">{!! $step['icon'] !!}</svg>
                            </div>
                            <h4 class="font-display font-bold text-lg uppercase tracking-widest mb-3 group-hover:text-brand-primary transition-colors duration-300">{{ $step['title'] }}</h4>
                            <p class="text-white/40 text-xs leading-relaxed">{{ $step['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- BEYOND THE CODE --}}
            @if($funFacts->isNotEmpty())
            <div data-reveal="up">
                <div class="text-center mb-16">
                    <span class="text-brand-primary font-mono text-[10px] uppercase tracking-[0.5em] mb-6 block" data-reveal="fade">Personal</span>
                    <h2 class="text-4xl md:text-6xl font-display font-bold tracking-tighter uppercase" data-reveal="up" data-delay="100">
                        Beyond the <span class="text-gradient-blue">Code</span>
                    </h2>
                    <p class="text-white/30 max-w-lg mx-auto mt-6 text-sm leading-relaxed" data-reveal="fade" data-delay="200">
                        When I'm not building things, here's what keeps me going.
                    </p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($funFacts as $i => $fact)
                    <div class="glass-premium p-8 rounded-3xl group hover:border-white/20 transition-all duration-500 text-center" data-tilt data-reveal="up" data-delay="{{ $i * 100 }}" style="--card-accent: #7000ff;">
                        <div data-tilt-glow></div>
                        <div class="relative z-10">
                            <div class="text-4xl mb-5 group-hover:scale-110 transition-transform duration-500">{{ $fact->emoji ?? '✨' }}</div>
                            <h4 class="font-display font-bold text-base uppercase tracking-widest mb-3 group-hover:text-brand-secondary transition-colors duration-300">{{ $fact->name }}</h4>
                            <p class="text-white/40 text-xs leading-relaxed">{{ $fact->content }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- ============================================================ --}}
        {{-- PHILOSOPHY SECTION                                            --}}
        {{-- ============================================================ --}}
        <section class="relative py-32 text-center overflow-hidden">
            <div class="absolute inset-0 flex items-center justify-center opacity-[0.06] pointer-events-none select-none">
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