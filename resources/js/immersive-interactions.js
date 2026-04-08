/**
 * Immersive Interactions System
 * Scroll-triggered animations, magnetic buttons, tilt cards, custom cursor, smooth reveals
 */

// ============================================================
// 1. SCROLL-TRIGGERED REVEAL ANIMATIONS (Intersection Observer)
// ============================================================
class ScrollReveal {
    constructor() {
        this.observer = null;
        this.init();
    }

    init() {
        this.observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        const delay = el.dataset.delay || 0;
                        const direction = el.dataset.direction || 'up';

                        setTimeout(() => {
                            el.classList.add('revealed');
                            el.style.transitionDelay = '0s';
                        }, delay);

                        this.observer.unobserve(el);
                    }
                });
            },
            { threshold: 0.1, rootMargin: '0px 0px -60px 0px' }
        );

        document.querySelectorAll('[data-reveal]').forEach((el) => {
            this.observer.observe(el);
        });
    }
}

// ============================================================
// 2. CUSTOM CURSOR (Premium feel)
// ============================================================
class CustomCursor {
    constructor() {
        this.cursor = null;
        this.cursorDot = null;
        this.mouseX = 0;
        this.mouseY = 0;
        this.cursorX = 0;
        this.cursorY = 0;
        this.dotX = 0;
        this.dotY = 0;
        this.isHovering = false;

        if (window.matchMedia('(pointer: fine)').matches) {
            this.init();
        }
    }

    init() {
        // Create cursor elements
        this.cursor = document.createElement('div');
        this.cursor.className = 'custom-cursor';
        document.body.appendChild(this.cursor);

        this.cursorDot = document.createElement('div');
        this.cursorDot.className = 'custom-cursor-dot';
        document.body.appendChild(this.cursorDot);

        // Track mouse
        window.addEventListener('mousemove', (e) => {
            this.mouseX = e.clientX;
            this.mouseY = e.clientY;
        });

        // Hover effects on interactive elements
        const interactives = document.querySelectorAll('a, button, [data-tilt], input, textarea, [data-magnetic]');
        interactives.forEach((el) => {
            el.addEventListener('mouseenter', () => {
                this.cursor.classList.add('cursor-hover');
                this.cursorDot.classList.add('cursor-dot-hover');
            });
            el.addEventListener('mouseleave', () => {
                this.cursor.classList.remove('cursor-hover');
                this.cursorDot.classList.remove('cursor-dot-hover');
            });
        });

        // Hide on mobile
        document.addEventListener('touchstart', () => {
            if (this.cursor) this.cursor.style.display = 'none';
            if (this.cursorDot) this.cursorDot.style.display = 'none';
        });

        this.animate();
    }

    animate() {
        // Smooth follow for ring
        this.cursorX += (this.mouseX - this.cursorX) * 0.12;
        this.cursorY += (this.mouseY - this.cursorY) * 0.12;

        // Faster follow for dot
        this.dotX += (this.mouseX - this.dotX) * 0.6;
        this.dotY += (this.mouseY - this.dotY) * 0.6;

        if (this.cursor) {
            this.cursor.style.transform = `translate(${this.cursorX - 20}px, ${this.cursorY - 20}px)`;
        }
        if (this.cursorDot) {
            this.cursorDot.style.transform = `translate(${this.dotX - 3}px, ${this.dotY - 3}px)`;
        }

        requestAnimationFrame(() => this.animate());
    }
}

// ============================================================
// 3. TILT EFFECT FOR CARDS
// ============================================================
class TiltEffect {
    constructor() {
        this.init();
    }

    init() {
        document.querySelectorAll('[data-tilt]').forEach((card) => {
            card.addEventListener('mousemove', (e) => this.handleTilt(e, card));
            card.addEventListener('mouseleave', (e) => this.resetTilt(card));
        });
    }

    handleTilt(e, card) {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;

        const tiltX = ((y - centerY) / centerY) * -6;
        const tiltY = ((x - centerX) / centerX) * 6;

        card.style.transform = `perspective(1000px) rotateX(${tiltX}deg) rotateY(${tiltY}deg) scale3d(1.02, 1.02, 1.02)`;

        // Move glow effect
        const glowEl = card.querySelector('[data-tilt-glow]');
        if (glowEl) {
            glowEl.style.background = `radial-gradient(circle at ${x}px ${y}px, rgba(0, 242, 255, 0.12) 0%, transparent 60%)`;
        }
    }

    resetTilt(card) {
        card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale3d(1, 1, 1)';
        const glowEl = card.querySelector('[data-tilt-glow]');
        if (glowEl) {
            glowEl.style.background = 'transparent';
        }
    }
}

// ============================================================
// 4. MAGNETIC BUTTONS
// ============================================================
class MagneticEffect {
    constructor() {
        this.init();
    }

    init() {
        document.querySelectorAll('[data-magnetic]').forEach((btn) => {
            btn.addEventListener('mousemove', (e) => {
                const rect = btn.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;

                btn.style.transform = `translate(${x * 0.25}px, ${y * 0.25}px)`;

                const inner = btn.querySelector('[data-magnetic-text]');
                if (inner) {
                    inner.style.transform = `translate(${x * 0.1}px, ${y * 0.1}px)`;
                }
            });

            btn.addEventListener('mouseleave', () => {
                btn.style.transform = 'translate(0, 0)';
                const inner = btn.querySelector('[data-magnetic-text]');
                if (inner) {
                    inner.style.transform = 'translate(0, 0)';
                }
            });
        });
    }
}

// ============================================================
// 5. TEXT SPLIT ANIMATION
// ============================================================
class TextSplitAnimation {
    constructor() {
        this.init();
    }

    init() {
        document.querySelectorAll('[data-split-text]').forEach((el) => {
            const text = el.textContent;
            el.innerHTML = '';
            el.setAttribute('aria-label', text);
            
            text.split('').forEach((char, i) => {
                const span = document.createElement('span');
                span.textContent = char === ' ' ? '\u00A0' : char;
                span.className = 'split-char';
                span.style.animationDelay = `${i * 0.03}s`;
                el.appendChild(span);
            });
        });
    }
}

// ============================================================
// 6. SMOOTH COUNTER ANIMATION
// ============================================================
class CounterAnimation {
    constructor() {
        this.init();
    }

    init() {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        this.animateCounter(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.5 }
        );

        document.querySelectorAll('[data-counter]').forEach((el) => {
            observer.observe(el);
        });
    }

    animateCounter(el) {
        const target = parseInt(el.dataset.counter);
        const suffix = el.dataset.suffix || '';
        const duration = 2000;
        const start = performance.now();

        const update = (now) => {
            const elapsed = now - start;
            const progress = Math.min(elapsed / duration, 1);
            // Ease out cubic
            const eased = 1 - Math.pow(1 - progress, 3);
            const current = Math.round(target * eased);

            el.textContent = current + suffix;

            if (progress < 1) {
                requestAnimationFrame(update);
            }
        };

        requestAnimationFrame(update);
    }
}

// ============================================================
// 7. PARALLAX SECTIONS
// ============================================================
class ParallaxEffect {
    constructor() {
        this.init();
    }

    init() {
        window.addEventListener('scroll', () => {
            const scrollY = window.scrollY;

            document.querySelectorAll('[data-parallax]').forEach((el) => {
                const speed = parseFloat(el.dataset.parallax) || 0.2;
                const rect = el.getBoundingClientRect();
                const visible = rect.top < window.innerHeight && rect.bottom > 0;

                if (visible) {
                    const offset = (rect.top - window.innerHeight / 2) * speed;
                    el.style.transform = `translateY(${offset}px)`;
                }
            });
        });
    }
}

// ============================================================
// 8. NAVBAR ENHANCED SCROLL
// ============================================================
class NavbarEnhanced {
    constructor() {
        this.navbar = document.getElementById('navbar');
        this.lastScroll = 0;
        this.init();
    }

    init() {
        if (!this.navbar) return;

        window.addEventListener('scroll', () => {
            const currentScroll = window.scrollY;

            // Auto-hide on scroll down, show on scroll up
            if (currentScroll > 100) {
                if (currentScroll > this.lastScroll && currentScroll > 200) {
                    this.navbar.style.transform = 'translateY(-100%)';
                } else {
                    this.navbar.style.transform = 'translateY(0)';
                }
            } else {
                this.navbar.style.transform = 'translateY(0)';
            }

            this.lastScroll = currentScroll;
        });
    }
}

// ============================================================
// 9. IMAGE PROGRESSIVE LOAD EFFECT
// ============================================================
class ImageReveal {
    constructor() {
        this.init();
    }

    init() {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('img-revealed');
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.2 }
        );

        document.querySelectorAll('[data-img-reveal]').forEach((el) => {
            observer.observe(el);
        });
    }
}

// ============================================================
// 10. SMOOTH SCROLL EASING 
// ============================================================
class SmoothNavigation {
    constructor() {
        this.init();
    }

    init() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                e.preventDefault();
                const target = document.querySelector(anchor.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    }
}

// ============================================================
// INITIALIZE ALL
// ============================================================
document.addEventListener('DOMContentLoaded', () => {
    new ScrollReveal();
    new CustomCursor();
    new TiltEffect();
    new MagneticEffect();
    new TextSplitAnimation();
    new CounterAnimation();
    new ParallaxEffect();
    new NavbarEnhanced();
    new ImageReveal();
    new SmoothNavigation();
});
