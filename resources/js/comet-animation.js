/**
 * Diagonal Comet Animation
 * Elegant falling streaks with glowing tails
 */

class CometAnimation {
    constructor(canvas, options = {}) {
        this.canvas = canvas;
        this.ctx = canvas.getContext('2d');
        this.time = 0;

        this.config = {
            comets: 12,
            cometMinLength: 80,
            cometMaxLength: 180,
            cometSpeed: { min: 1.5, max: 3 },
            cometWidth: { min: 1, max: 2.5 },
            cometOpacity: { min: 0.3, max: 0.6 },
            cometAngle: 35, // degrees - diagonal angle
            cometColors: [
                '0, 242, 255',    // Cyan
                '112, 0, 255',    // Purple
                '255, 0, 153',    // Pink
                '0, 220, 255',    // Light cyan
                '180, 100, 255',  // Light purple
            ],
            particles: 20,
            ambientOrbs: 3,
            ...options
        };

        this.comets = [];
        this.particles = [];
        this.ambientOrbs = [];

        this.resize();
        this.initComets();
        this.initParticles();
        this.initAmbientOrbs();
        this.animate();

        window.addEventListener('resize', () => this.resize());
    }

    resize() {
        const dpr = window.devicePixelRatio || 1;
        this.canvas.width = this.canvas.offsetWidth * dpr;
        this.canvas.height = this.canvas.offsetHeight * dpr;
        this.ctx.scale(dpr, dpr);
        this.width = this.canvas.offsetWidth;
        this.height = this.canvas.offsetHeight;
        this.angle = (this.config.cometAngle * Math.PI) / 180;
    }

    initComets() {
        for (let i = 0; i < this.config.comets; i++) {
            this.comets.push(this.createComet());
        }
    }

    createComet(startAtRandomY = true) {
        const length = this.config.cometMinLength + Math.random() * (this.config.cometMaxLength - this.config.cometMinLength);
        const color = this.config.cometColors[Math.floor(Math.random() * this.config.cometColors.length)];
        const opacity = this.config.cometOpacity.min + Math.random() * (this.config.cometOpacity.max - this.config.cometOpacity.min);
        const speed = this.config.cometSpeed.min + Math.random() * (this.config.cometSpeed.max - this.config.cometSpeed.min);
        const width = this.config.cometWidth.min + Math.random() * (this.config.cometWidth.max - this.config.cometWidth.min);

        return {
            x: Math.random() * (this.width + 200) - 100,
            y: startAtRandomY ? Math.random() * this.height : -length - Math.random() * 300,
            length,
            speed,
            width,
            opacity,
            color,
            delay: Math.random() * 100
        };
    }

    initParticles() {
        for (let i = 0; i < this.config.particles; i++) {
            this.particles.push({
                x: Math.random() * this.width,
                y: Math.random() * this.height,
                size: 1.5 + Math.random() * 2,
                opacity: 0.2 + Math.random() * 0.3,
                pulse: Math.random() * Math.PI * 2,
                color: Math.random() > 0.5 ? '0, 242, 255' : '255, 255, 255'
            });
        }
    }

    initAmbientOrbs() {
        for (let i = 0; i < this.config.ambientOrbs; i++) {
            this.ambientOrbs.push({
                x: Math.random() * this.width,
                y: Math.random() * this.height,
                size: 200 + Math.random() * 150,
                color: this.config.cometColors[i % this.config.cometColors.length],
                speed: 0.003 + Math.random() * 0.004,
                opacity: 0.04 + Math.random() * 0.03,
                phase: Math.random() * Math.PI * 2
            });
        }
    }

    drawAmbientOrbs() {
        const { ctx } = this;

        this.ambientOrbs.forEach((orb) => {
            const x = orb.x + Math.sin(this.time * orb.speed + orb.phase) * 50;
            const y = orb.y + Math.cos(this.time * orb.speed * 0.7 + orb.phase) * 40;

            const gradient = ctx.createRadialGradient(x, y, 0, x, y, orb.size);
            gradient.addColorStop(0, `rgba(${orb.color}, ${orb.opacity})`);
            gradient.addColorStop(1, `rgba(${orb.color}, 0)`);

            ctx.beginPath();
            ctx.arc(x, y, orb.size, 0, Math.PI * 2);
            ctx.fillStyle = gradient;
            ctx.fill();
        });
    }

    drawComet(comet) {
        const { ctx } = this;
        const { x, y, length, width, opacity, color } = comet;
        const angle = this.angle;

        // Calculate end position based on angle
        const endX = x - Math.cos(angle) * length;
        const endY = y - Math.sin(angle) * length;

        // Create gradient for tail
        const gradient = ctx.createLinearGradient(endX, endY, x, y);
        gradient.addColorStop(0, `rgba(${color}, 0)`);
        gradient.addColorStop(0.7, `rgba(${color}, ${opacity * 0.4})`);
        gradient.addColorStop(1, `rgba(${color}, ${opacity})`);

        // Draw tail
        ctx.beginPath();
        ctx.moveTo(endX - width, endY);
        ctx.lineTo(endX + width, endY);
        ctx.lineTo(x + width * 0.5, y);
        ctx.lineTo(x - width * 0.5, y);
        ctx.closePath();
        ctx.fillStyle = gradient;
        ctx.fill();

        // Draw glowing head
        const headGlow = ctx.createRadialGradient(x, y, 0, x, y, width * 4);
        headGlow.addColorStop(0, `rgba(${color}, ${opacity * 0.8})`);
        headGlow.addColorStop(0.5, `rgba(${color}, ${opacity * 0.2})`);
        headGlow.addColorStop(1, `rgba(${color}, 0)`);

        ctx.beginPath();
        ctx.arc(x, y, width * 4, 0, Math.PI * 2);
        ctx.fillStyle = headGlow;
        ctx.fill();

        // Core bright point
        ctx.beginPath();
        ctx.arc(x, y, width * 0.8, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(255, 255, 255, ${opacity * 0.9})`;
        ctx.shadowBlur = 15;
        ctx.shadowColor = `rgba(${color}, ${opacity})`;
        ctx.fill();
        ctx.shadowBlur = 0;
    }

    updateComets() {
        const angle = this.angle;

        this.comets.forEach((comet, i) => {
            if (comet.delay > 0) {
                comet.delay--;
                return;
            }

            // Move diagonally
            comet.x += Math.cos(angle) * comet.speed;
            comet.y += Math.sin(angle) * comet.speed;

            // Reset when off screen
            if (comet.y > this.height + 100 || comet.x > this.width + 200) {
                this.comets[i] = this.createComet(false);
            }
        });
    }

    drawComets() {
        this.comets.forEach(comet => {
            if (comet.delay <= 0) {
                this.drawComet(comet);
            }
        });
    }

    drawParticles() {
        const { ctx } = this;

        this.particles.forEach(p => {
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
            ctx.fillStyle = `rgba(255, 255, 255, ${pulse * 0.8})`;
            ctx.fill();
        });
    }

    drawVignette() {
        const { ctx, width, height } = this;

        const gradient = ctx.createRadialGradient(
            width / 2, height / 2, height * 0.25,
            width / 2, height / 2, width * 0.75
        );
        gradient.addColorStop(0, 'rgba(0, 0, 0, 0)');
        gradient.addColorStop(1, 'rgba(0, 0, 0, 0.25)');

        ctx.fillStyle = gradient;
        ctx.fillRect(0, 0, width, height);
    }

    animate() {
        const { ctx, width, height } = this;

        // Clear with subtle trail
        ctx.fillStyle = 'rgba(0, 0, 0, 0.08)';
        ctx.fillRect(0, 0, width, height);

        // Draw layers
        this.drawAmbientOrbs();
        this.drawParticles();
        this.updateComets();
        this.drawComets();
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
    const container = document.getElementById('comet-container');
    if (!container) return;

    const canvas = document.createElement('canvas');
    canvas.id = 'comet-canvas';
    canvas.className = 'w-full h-full z-0 pointer-events-none'; // Inset-0 handled by container

    container.appendChild(canvas);

    new CometAnimation(canvas, {
        comets: 15,
        cometMinLength: 80,
        cometMaxLength: 200,
        cometSpeed: { min: 2, max: 4.5 },
        cometWidth: { min: 1.5, max: 3 },
        cometOpacity: { min: 0.3, max: 0.65 },
        cometAngle: 38,
        particles: 40,
        ambientOrbs: 4
    });
});

export { CometAnimation };
