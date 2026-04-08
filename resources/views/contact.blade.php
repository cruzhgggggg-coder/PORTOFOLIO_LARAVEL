@extends('app')

@section('title', 'Contact - Luminescent Architect')

@section('content')
<div class="relative pt-32 pb-24 px-6 overflow-hidden">
    <div class="relative max-w-7xl mx-auto z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-20 lg:gap-28">
            {{-- Left Column — Info --}}
            <div>
                <span class="text-brand-primary font-mono text-[10px] uppercase tracking-[0.5em] mb-8 block" data-reveal="fade">Connection</span>
                <h1 class="text-5xl md:text-7xl font-display font-bold tracking-tighter uppercase mb-10 leading-[0.85]" data-reveal="up" data-delay="100">
                    Initiate <br /><span class="text-gradient-blue">Contact</span>
                </h1>
                <p class="text-lg text-white/45 leading-relaxed mb-14" data-reveal="up" data-delay="200">
                    Have a vision that needs a digital structure? Let's discuss how we can build something extraordinary together.
                </p>

                {{-- Contact Cards --}}
                <div class="flex flex-col gap-6" data-reveal="up" data-delay="300">
                    <div class="group flex items-start gap-6 glass-premium p-6 rounded-2xl cursor-default" data-tilt style="--card-accent: #00f2ff;">
                        <div data-tilt-glow></div>
                        <div class="relative z-10 flex items-start gap-6">
                            <div class="w-12 h-12 bg-brand-primary/10 flex items-center justify-center rounded-xl text-brand-primary group-hover:bg-brand-primary/20 transition-all duration-500 group-hover:scale-110 shrink-0">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-5 h-5">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-[9px] font-bold uppercase tracking-[0.4em] text-white/30 mb-2">Direct Email</h4>
                                <p class="text-base font-display font-medium group-hover:text-brand-primary transition-colors duration-300">{{ $profile['email'] ?? 'hello@luminescent.arch' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="group flex items-start gap-6 glass-premium p-6 rounded-2xl cursor-default" data-tilt style="--card-accent: #7000ff;">
                        <div data-tilt-glow></div>
                        <div class="relative z-10 flex items-start gap-6">
                            <div class="w-12 h-12 bg-brand-secondary/10 flex items-center justify-center rounded-xl text-brand-secondary group-hover:bg-brand-secondary/20 transition-all duration-500 group-hover:scale-110 shrink-0">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-5 h-5">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-[9px] font-bold uppercase tracking-[0.4em] text-white/30 mb-2">Base of Operations</h4>
                                <p class="text-base font-display font-medium group-hover:text-brand-secondary transition-colors duration-300">{{ $profile['location'] ?? 'Jakarta, Indonesia' }}</p>
                            </div>
                        </div>
                    </div>

                    @if(!empty($profile['phone']))
                    <div class="group flex items-start gap-6 glass-premium p-6 rounded-2xl cursor-default" data-tilt style="--card-accent: #ff0099;">
                        <div data-tilt-glow></div>
                        <div class="relative z-10 flex items-start gap-6">
                            <div class="w-12 h-12 bg-brand-accent/10 flex items-center justify-center rounded-xl text-brand-accent group-hover:bg-brand-accent/20 transition-all duration-500 group-hover:scale-110 shrink-0">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-5 h-5">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-[9px] font-bold uppercase tracking-[0.4em] text-white/30 mb-2">Encrypted Line</h4>
                                <p class="text-base font-display font-medium group-hover:text-brand-accent transition-colors duration-300">{{ $profile['phone'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Availability banner --}}
                <div class="mt-10 glass-premium p-6 rounded-2xl flex items-center gap-4" data-reveal="up" data-delay="400">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-400 shadow-[0_0_10px_rgba(74,222,128,0.5)]"></span>
                    </span>
                    <span class="text-[10px] font-mono uppercase tracking-[0.3em] text-white/50">Currently accepting new projects</span>
                </div>
            </div>

            {{-- Right Column — Form --}}
            <div class="glass-premium p-10 md:p-12 rounded-[2.5rem] relative overflow-hidden" data-reveal="left" data-delay="200">
                {{-- Decorative corner accents --}}
                <div class="absolute top-0 right-0 w-40 h-40 bg-brand-primary/5 rounded-full blur-[80px] pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-brand-secondary/5 rounded-full blur-[60px] pointer-events-none"></div>

                {{-- Form Success Message --}}
                <div id="form-success" class="hidden h-full flex-col items-center justify-center text-center py-20">
                    <div class="w-20 h-20 bg-brand-primary/10 flex items-center justify-center rounded-full mb-8 shadow-[0_0_40px_rgba(0,242,255,0.1)]">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-8 h-8 text-brand-primary">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-display font-bold uppercase tracking-tight mb-4">Transmission <span class="text-brand-primary">Received</span></h3>
                    <p class="text-white/40 mb-8">Your message has been successfully encrypted and sent. I will respond shortly.</p>
                    <button onclick="resetForm()" class="text-brand-primary uppercase tracking-widest text-[10px] font-bold hover:underline flex items-center gap-2 mx-auto">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4">
                            <polyline points="1 4 1 10 7 10"></polyline>
                            <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                        </svg>
                        Send another message
                    </button>
                </div>

                {{-- Form --}}
                <form id="contact-form" class="flex flex-col gap-7 relative z-10" onsubmit="handleContact(event)">
                    <div class="mb-4">
                        <h3 class="text-2xl font-display font-bold uppercase tracking-tight mb-2">Send a <span class="text-brand-primary">Message</span></h3>
                        <p class="text-white/30 text-sm">Fill in the fields below to start a conversation.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-2">
                            <label class="text-[9px] font-bold uppercase tracking-[0.4em] text-white/30 ml-1">Identity</label>
                            <input
                                required
                                type="text"
                                name="name"
                                placeholder="Your Name"
                                class="form-input bg-white/3 border border-white/8 rounded-xl px-6 py-4 focus:outline-none text-white text-sm placeholder:text-white/20"
                            />
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="text-[9px] font-bold uppercase tracking-[0.4em] text-white/30 ml-1">Frequency</label>
                            <input
                                required
                                type="email"
                                name="email"
                                placeholder="Your Email"
                                class="form-input bg-white/3 border border-white/8 rounded-xl px-6 py-4 focus:outline-none text-white text-sm placeholder:text-white/20"
                            />
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-[9px] font-bold uppercase tracking-[0.4em] text-white/30 ml-1">Subject</label>
                        <input
                            required
                            type="text"
                            name="subject"
                            placeholder="Project Inquiry"
                            class="form-input bg-white/3 border border-white/8 rounded-xl px-6 py-4 focus:outline-none text-white text-sm placeholder:text-white/20"
                        />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-[9px] font-bold uppercase tracking-[0.4em] text-white/30 ml-1">Transmission</label>
                        <textarea
                            required
                            name="message"
                            rows="5"
                            placeholder="Describe your vision..."
                            class="form-input bg-white/3 border border-white/8 rounded-xl px-6 py-4 focus:outline-none resize-none text-white text-sm placeholder:text-white/20"
                        ></textarea>
                    </div>
                    <button
                        type="submit"
                        id="submit-btn"
                        class="group mt-2 w-full px-8 py-4 bg-brand-primary text-black font-bold uppercase tracking-widest rounded-full hover:scale-[1.02] active:scale-95 transition-all duration-300 hover:shadow-[0_0_40px_rgba(0,242,255,0.3)] flex items-center justify-center gap-3 text-sm"
                        data-magnetic
                    >
                        <span data-magnetic-text class="flex items-center gap-3">
                            Send Transmission
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4 group-hover:translate-x-1 transition-transform">
                                <line x1="22" y1="2" x2="11" y2="13"></line>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                            </svg>
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function handleContact(e) {
        e.preventDefault();
        const btn = document.getElementById('submit-btn');
        const form = document.getElementById('contact-form');
        const success = document.getElementById('form-success');

        btn.innerHTML = `<span class="flex items-center gap-3"><svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" opacity="0.3"></circle><path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path></svg> Transmitting...</span>`;
        btn.disabled = true;

        setTimeout(() => {
            form.classList.add('hidden');
            success.classList.replace('hidden', 'flex');
        }, 1500);
    }

    function resetForm() {
        const form = document.getElementById('contact-form');
        const success = document.getElementById('form-success');
        const btn = document.getElementById('submit-btn');

        form.classList.remove('hidden');
        success.classList.replace('flex', 'hidden');
        btn.innerHTML = `<span data-magnetic-text class="flex items-center gap-3">Send Transmission <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg></span>`;
        btn.disabled = false;
        form.reset();
    }
</script>
@endsection
