/**
 * Ambient Immersive Background
 * Subtle particles, floating orbs, and light rays across all pages
 */

class AmbientBackground {
    constructor(canvas, options = {}) {
        this.canvas = canvas;
        this.ctx = canvas.getContext('2d');
        this.time = 0;
        this.mouse = { x: 0, y: 0 };

        this.config = {
            // Floating orbs
            orbs: options.orbs || [
                { x: 0.2, y: 0.3, size: 250, color: '0, 242, 255', speed: 0.005, opacity: 0.06 },
                { x: 0.7, y: 0.5, size: 300, color: '112, 0, 255', speed: 0.004, opacity: 0.05 },
                { x: 0.5, y: 0.7, size: 200, color: '255, 0, 153', speed: 0.006, opacity: 0.04 },
            ],

            // Particles
            particles: options.particles || 35,
            particleSize: { min: 1, max: 2 },
            particleSpeed: { min: 0.08, max: 0.2 },

            // Light rays
            rays: options.rays || 5,

            // Page-specific mode
            isHomePage: options.isHomePage || false,
            pageType: options.pageType || 'default', // 'default', 'projects', 'about', 'contact'
            ...options
        };

        this.particles = [];
        this.lightRays = [];

        this.resize();
        this.initParticles();
        this.initLightRays();
        this.animate();

        window.addEventListener('resize', () => this.resize());
        window.addEventListener('mousemove', (e) => {
            this.mouse.x = e.clientX;
            this.mouse.y = e.clientY;
        });
    }

    resize() {
        const dpr = window.devicePixelRatio || 1;
        this.canvas.width = this.canvas.offsetWidth * dpr;
        this.canvas.height = this.canvas.offsetHeight * dpr;
        this.ctx.scale(dpr, dpr);
        this.width = this.canvas.offsetWidth;
        this.height = this.canvas.offsetHeight;
    }

    initParticles() {
        for (let i = 0; i < this.config.particles; i++) {
            this.particles.push({
                x: Math.random() * this.width,
                y: Math.random() * this.height,
                size: this.config.particleSize.min + Math.random() * (this.config.particleSize.max - this.config.particleSize.min),
                speedX: (Math.random() - 0.5) * this.config.particleSpeed.max,
                speedY: -Math.random() * this.config.particleSpeed.max * 0.5,
                opacity: 0.15 + Math.random() * 0.25,
                pulse: Math.random() * Math.PI * 2,
                color: Math.random() > 0.6 ? '0, 242, 255' : (Math.random() > 0.5 ? '112, 0, 255' : '255, 255, 255')
            });
        }
    }

    initLightRays() {
        for (let i = 0; i < this.config.rays; i++) {
            this.lightRays.push({
                x: (this.width / (this.config.rays + 1)) * (i + 1),
                width: 1.5 + Math.random() * 2,
                speed: 0.3 + Math.random() * 0.4,
                opacity: 0.02 + Math.random() * 0.03,
                length: 0.3 + Math.random() * 0.2,
                delay: Math.random() * 200
            });
        }
    }

    drawOrbs() {
        const { ctx } = this;

        this.config.orbs.forEach((orb, i) => {
            const centerX = this.width * orb.x;
            const centerY = this.height * orb.y;

            // Target position with mouse influence
            const distX = this.mouse.x - centerX;
            const distY = this.mouse.y - centerY;
            const targetX = centerX + distX * 0.05;
            const targetY = centerY + distY * 0.05;

            const x = targetX + Math.sin(this.time * orb.speed + i) * 60;
            const y = targetY + Math.cos(this.time * orb.speed * 0.8 + i * 0.5) * 50;
            const size = orb.size * (1 + Math.sin(this.time * orb.speed * 0.5) * 0.1);

            const gradient = ctx.createRadialGradient(x, y, 0, x, y, size);
            gradient.addColorStop(0, `rgba(${orb.color}, ${orb.opacity})`);
            gradient.addColorStop(1, `rgba(${orb.color}, 0)`);

            ctx.beginPath();
            ctx.arc(x, y, size, 0, Math.PI * 2);
            ctx.fillStyle = gradient;
            ctx.fill();
        });
    }

    drawParticles() {
        const { ctx } = this;

        this.particles.forEach(p => {
            p.x += p.speedX;
            p.y += p.speedY;

            // Wrap around
            if (p.x < 0) p.x = this.width;
            if (p.x > this.width) p.x = 0;
            if (p.y < -10) p.y = this.height + 10;
            if (p.y > this.height + 10) p.y = -10;

            const pulse = p.opacity * (0.6 + Math.sin(this.time * 0.03 + p.pulse) * 0.4);

            // Outer glow halo
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.size * 2.5, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(${p.color}, ${pulse * 0.15})`;
            ctx.fill();

            // Main particle
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(${p.color}, ${pulse})`;
            ctx.shadowBlur = 10;
            ctx.shadowColor = `rgba(${p.color}, ${pulse * 0.5})`;
            ctx.fill();
            ctx.shadowBlur = 0;

            // Bright core
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.size * 0.5, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(255, 255, 255, ${pulse * 0.7})`;
            ctx.fill();
        });
    }

    drawLightRays() {
        const { ctx } = this;

        this.lightRays.forEach((ray, i) => {
            if (ray.delay > 0) {
                ray.delay--;
                return;
            }

            const y = ((this.time * ray.speed + i * 300) % (this.height * (1 + ray.length))) - this.height * ray.length;

            const gradient = ctx.createLinearGradient(ray.x, y - this.height * ray.length, ray.x, y);
            gradient.addColorStop(0, 'rgba(0, 242, 255, 0)');
            gradient.addColorStop(0.5, `rgba(0, 242, 255, ${ray.opacity})`);
            gradient.addColorStop(1, 'rgba(0, 242, 255, 0)');

            ctx.beginPath();
            ctx.moveTo(ray.x - ray.width, y - this.height * ray.length);
            ctx.lineTo(ray.x + ray.width, y - this.height * ray.length);
            ctx.lineTo(ray.x + ray.width * 0.5, y);
            ctx.lineTo(ray.x - ray.width * 0.5, y);
            ctx.closePath();
            ctx.fillStyle = gradient;
            ctx.fill();
        });
    }

    drawVignette() {
        const { ctx, width, height } = this;

        const gradient = ctx.createRadialGradient(
            width / 2, height / 2, height * 0.3,
            width / 2, height / 2, width * 0.7
        );
        gradient.addColorStop(0, 'rgba(0, 0, 0, 0)');
        gradient.addColorStop(1, 'rgba(0, 0, 0, 0.2)');

        ctx.fillStyle = gradient;
        ctx.fillRect(0, 0, width, height);
    }

    drawPageSpecificEffects() {
        const { ctx, width, height } = this;

        if (this.config.pageType === 'projects') {
            // Subtle grid pattern for projects page
            ctx.strokeStyle = 'rgba(0, 242, 255, 0.015)';
            ctx.lineWidth = 0.5;
            const spacing = 80;

            for (let x = 0; x < width; x += spacing) {
                ctx.beginPath();
                ctx.moveTo(x, 0);
                ctx.lineTo(x, height);
                ctx.stroke();
            }
            for (let y = 0; y < height; y += spacing) {
                ctx.beginPath();
                ctx.moveTo(0, y);
                ctx.lineTo(width, y);
                ctx.stroke();
            }
        }

        if (this.config.pageType === 'about') {
            // Floating geometric shapes
            const shapes = 4;
            for (let i = 0; i < shapes; i++) {
                const x = width * (0.2 + i * 0.2) + Math.sin(this.time * 0.005 + i) * 40;
                const y = height * (0.3 + (i % 2) * 0.4) + Math.cos(this.time * 0.004 + i) * 30;
                const size = 40 + i * 15;
                const rotation = this.time * 0.003 + i;

                ctx.save();
                ctx.translate(x, y);
                ctx.rotate(rotation);
                ctx.strokeStyle = `rgba(0, 242, 255, ${0.03 + i * 0.005})`;
                ctx.lineWidth = 1;

                // Draw diamond shape
                ctx.beginPath();
                ctx.moveTo(0, -size);
                ctx.lineTo(size, 0);
                ctx.lineTo(0, size);
                ctx.lineTo(-size, 0);
                ctx.closePath();
                ctx.stroke();

                ctx.restore();
            }
        }

        if (this.config.pageType === 'contact') {
            // Soft radial pulse from center
            const pulseCount = 3;
            for (let i = 0; i < pulseCount; i++) {
                const radius = ((this.time * 0.5 + i * 100) % (width * 0.5));
                const opacity = 0.03 * (1 - radius / (width * 0.5));

                ctx.beginPath();
                ctx.arc(width / 2, height / 2, radius, 0, Math.PI * 2);
                ctx.strokeStyle = `rgba(0, 242, 255, ${opacity})`;
                ctx.lineWidth = 1.5;
                ctx.stroke();
            }
        }
    }

    animate() {
        const { ctx, width, height } = this;

        // Clear
        ctx.clearRect(0, 0, width, height);

        // Draw layers
        this.drawOrbs();
        this.drawLightRays();
        this.drawParticles();
        this.drawPageSpecificEffects();
        this.drawVignette();

        this.time++;
        this.animationId = requestAnimationFrame(() => this.animate());
    }

    destroy() {
        if (this.animationId) cancelAnimationFrame(this.animationId);
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    const body = document.body;

    const canvas = document.createElement('canvas');
    canvas.id = 'ambient-canvas';
    canvas.className = 'fixed inset-0 w-full h-full z-0 pointer-events-none';

    // Insert right after body start, before everything else
    body.insertBefore(canvas, body.firstChild);

    // Detect page type
    const path = window.location.pathname;
    let pageType = 'default';
    let isHomePage = false;

    if (path === '/') {
        isHomePage = true;
        pageType = 'home';
    } else if (path.includes('/projects')) {
        pageType = 'projects';
    } else if (path.includes('/about')) {
        pageType = 'about';
    } else if (path.includes('/contact')) {
        pageType = 'contact';
    }

    new AmbientBackground(canvas, {
        isHomePage,
        pageType,
        orbs: isHomePage ? [
            { x: 0.25, y: 0.35, size: 320, color: '0, 242, 255', speed: 0.006, opacity: 0.07 },
            { x: 0.7, y: 0.55, size: 380, color: '112, 0, 255', speed: 0.005, opacity: 0.06 },
            { x: 0.5, y: 0.45, size: 340, color: '255, 0, 153', speed: 0.007, opacity: 0.05 },
            { x: 0.6, y: 0.65, size: 290, color: '0, 220, 255', speed: 0.005, opacity: 0.06 },
        ] : [
            { x: 0.3, y: 0.3, size: 280, color: '0, 242, 255', speed: 0.005, opacity: 0.05 },
            { x: 0.7, y: 0.5, size: 320, color: '112, 0, 255', speed: 0.004, opacity: 0.04 },
            { x: 0.5, y: 0.7, size: 240, color: '255, 0, 153', speed: 0.006, opacity: 0.03 },
        ],
        particles: isHomePage ? 40 : 30,
        rays: isHomePage ? 6 : 4
    });
});

export { AmbientBackground };
