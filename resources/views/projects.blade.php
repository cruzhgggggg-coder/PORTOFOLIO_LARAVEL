@extends('app')

@section('title', 'Projects - Luminescent Architect')

@section('content')
<div class="relative pt-32 pb-24 px-6 overflow-hidden">
    <div class="relative max-w-7xl mx-auto z-10">
        {{-- Header --}}
        <header class="mb-20">
            <span class="text-brand-primary font-mono text-[10px] uppercase tracking-[0.5em] mb-6 block" data-reveal="fade">
                Portfolio
            </span>
            <div class="flex flex-col md:flex-row justify-between items-end gap-8">
                <h1 class="text-5xl md:text-8xl font-display font-bold tracking-tighter uppercase leading-[0.85]" data-reveal="up" data-delay="100">
                    Architectural <br /><span class="text-gradient-blue">Works</span>
                </h1>
                <p class="text-white/30 max-w-sm text-right leading-relaxed text-sm" data-reveal="fade" data-delay="200">
                    A curated selection of digital architectures, each crafted with precision and purpose.
                </p>
            </div>
        </header>

        {{-- Animated divider --}}
        <div class="animated-divider mb-16" data-reveal="fade"></div>

        {{-- Projects Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 lg:gap-24">
            @foreach($projects as $index => $project)
            <div class="project-card group cursor-pointer relative" data-reveal="up" data-delay="{{ ($index % 2) * 150 }}">
                {{-- Image --}}
                <div class="relative aspect-4/5 md:aspect-video overflow-hidden bg-white/5 rounded-4xl mb-10 shadow-2xl" data-img-reveal data-tilt>
                    <div data-tilt-glow></div>

                    {{-- Project number --}}
                    <span class="project-index font-display">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>

                    {{-- Hover Effect --}}
                    <div class="absolute inset-0 bg-brand-primary/0 group-hover:bg-brand-primary/5 transition-colors duration-700 z-10 pointer-events-none"></div>

                    <img
                        src="{{ $project->image }}"
                        alt="{{ $project->title }}"
                        loading="lazy"
                        decoding="async"
                        class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-1000" />

                    {{-- Overlay with view button --}}
                    <div class="absolute inset-0 bg-linear-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700 flex items-end p-10 z-20">
                        <div class="flex items-center gap-4 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <div class="w-14 h-14 bg-white text-black rounded-full flex items-center justify-center shadow-[0_0_40px_rgba(255,255,255,0.3)] group-hover:scale-110 transition-transform duration-300">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-6 h-6">
                                    <line x1="7" y1="17" x2="17" y2="7"></line>
                                    <polyline points="7 7 17 7 17 17"></polyline>
                                </svg>
                            </div>
                            <div>
                                <span class="text-[10px] font-mono uppercase tracking-widest text-white/60 block mb-1">Explore</span>
                                <span class="text-sm font-bold uppercase tracking-wide text-white">View Project</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Project Info --}}
                <div class="project-info flex justify-between items-end px-4">
                    <div>
                        <div class="flex items-center gap-4 mb-4">
                            <span class="px-4 py-1.5 glass-premium rounded-full text-[9px] font-bold uppercase tracking-[0.3em] text-brand-primary border-brand-primary/20">
                                {{ $project->category }}
                            </span>
                            <span class="text-white/20 font-mono text-[10px] tracking-widest">{{ $project->year }}</span>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-display font-bold uppercase tracking-tighter group-hover:text-brand-primary transition-colors duration-500">
                            {{ $project->title }}
                        </h2>
                        <p class="text-white/30 mt-4 max-w-md leading-relaxed text-sm group-hover:text-white/50 transition-colors duration-500">
                            {{ $project->description }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection