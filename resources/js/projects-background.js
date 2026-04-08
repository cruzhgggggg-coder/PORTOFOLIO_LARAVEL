/**
 * Projects Page Immersive Background
 * Architectural grid with animated streams and focal points
 */

class ProjectsBackground {
    constructor(canvas, options = {}) {
        this.canvas = canvas;
        this.ctx = canvas.getContext('2d');
        this.time = 0;

        this.config = {
            // Grid
            gridSize: 80,
            gridOpacity: 0.04,
            gridColor: '0, 242, 255',

            // Focal points (glowing intersections)
            focalPoints: 8,
            focalSize: 4,
            focalGlow: 15,

            // Data streams (vertical lines)
            streams: 12,
            streamSpeed: 1.5,
            streamOpacity: 0.06,

            // Floating orbs
            orbs: [
                { x: 0.15, y: 0.2, size: 300, color: '0, 242, 255', speed: 0.004, opacity: 0.06 },
                { x: 0.8, y: 0.6, size: 350, color: '112, 0, 255', speed: 0.003, opacity: 0.05 },
                { x: 0.6, y: 0.8, size: 280, color: '255, 0, 153', speed: 0.005, opacity: 0.04 },
            ],

            // Particles
            particles: 35,

            // Corner accents
            cornerSize: 60,
            ...options
        };

        this.focalPoints = [];
        this.streams = [];
        this.particles = [];

        this.resize();
        this.initFocalPoints();
        this.initStreams();
        this.initParticles();
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
    }

    initFocalPoints() {
        for (let i = 0; i < this.config.focalPoints; i++) {
            this.focalPoints.push({
                x: Math.random() * this.width,
                y: Math.random() * this.height,
                baseX: Math.random() * this.width,
                baseY: Math.random() * this.height,
                phase: Math.random() * Math.PI * 2,
                pulse: Math.random() * 0.3
            });
        }
    }

    initStreams() {
        for (let i = 0; i < this.config.streams; i++) {
            this.streams.push({
                x: (this.width / this.config.streams) * (i + 0.5),
                width: 1 + Math.random() * 1.5,
                speed: this.config.streamSpeed * (0.7 + Math.random() * 0.6),
                opacity: this.config.streamOpacity * (0.8 + Math.random() * 0.4),
                length: 0.25 + Math.random() * 0.2,
                delay: Math.random() * 150
            });
        }
    }

    initParticles() {
        for (let i = 0; i < this.config.particles; i++) {
            this.particles.push({
                x: Math.random() * this.width,
                y: Math.random() * this.height,
                size: 1.5 + Math.random() * 2.5,
                speedX: (Math.random() - 0.5) * 0.15,
                speedY: (Math.random() - 0.5) * 0.15,
                opacity: 0.2 + Math.random() * 0.3,
                pulse: Math.random() * Math.PI * 2,
                color: Math.random() > 0.6 ? '0, 242, 255' : (Math.random() > 0.5 ? '112, 0, 255' : '255, 255, 255')
            });
        }
    }

    drawGrid() {
        const { ctx, width, height } = this;
        const size = this.config.gridSize;
        const opacity = this.config.gridOpacity;

        // Subtle pulsing opacity
        const pulseOpacity = opacity * (0.8 + Math.sin(this.time * 0.01) * 0.2);

        ctx.strokeStyle = `rgba(${this.config.gridColor}, ${pulseOpacity})`;
        ctx.lineWidth = 0.5;

        // Vertical lines
        for (let x = 0; x <= width; x += size) {
            ctx.beginPath();
            ctx.moveTo(x, 0);
            ctx.lineTo(x, height);
            ctx.stroke();
        }

        // Horizontal lines
        for (let y = 0; y <= height; y += size) {
            ctx.beginPath();
            ctx.moveTo(0, y);
            ctx.lineTo(width, y);
            ctx.stroke();
        }
    }

    drawFocalPoints() {
        const { ctx } = this;

        this.focalPoints.forEach((fp, i) => {
            // Floating motion
            fp.x = fp.baseX + Math.sin(this.time * 0.008 + fp.phase) * 30;
            fp.y = fp.baseY + Math.cos(this.time * 0.006 + fp.phase) * 25;

            const pulse = 1 + Math.sin(this.time * 0.04 + fp.phase) * 0.3;
            const size = this.config.focalSize * pulse;
            const glowSize = this.config.focalGlow * pulse;

            // Outer glow
            const gradient = ctx.createRadialGradient(fp.x, fp.y, 0, fp.x, fp.y, glowSize);
            gradient.addColorStop(0, `rgba(0, 242, 255, 0.15)`);
            gradient.addColorStop(0.5, `rgba(0, 242, 255, 0.05)`);
            gradient.addColorStop(1, `rgba(0, 242, 255, 0)`);

            ctx.beginPath();
            ctx.arc(fp.x, fp.y, glowSize, 0, Math.PI * 2);
            ctx.fillStyle = gradient;
            ctx.fill();

            // Core point
            ctx.beginPath();
            ctx.arc(fp.x, fp.y, size, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(0, 242, 255, 0.6)`;
            ctx.shadowBlur = 10;
            ctx.shadowColor = `rgba(0, 242, 255, 0.4)`;
            ctx.fill();
            ctx.shadowBlur = 0;
        });
    }

    drawStreams() {
        const { ctx, height } = this;

        this.streams.forEach((stream, i) => {
            if (stream.delay > 0) {
                stream.delay--;
                return;
            }

            const y = ((this.time * stream.speed + i * 180) % (height * (1 + stream.length))) - height * stream.length;

            const gradient = ctx.createLinearGradient(
                stream.x, y - height * stream.length,
                stream.x, y
            );
            gradient.addColorStop(0, 'rgba(0, 242, 255, 0)');
            gradient.addColorStop(0.5, `rgba(0, 242, 255, ${stream.opacity})`);
            gradient.addColorStop(1, 'rgba(0, 242, 255, 0)');

            ctx.beginPath();
            ctx.moveTo(stream.x - stream.width, y - height * stream.length);
            ctx.lineTo(stream.x + stream.width, y - height * stream.length);
            ctx.lineTo(stream.x + stream.width * 0.5, y);
            ctx.lineTo(stream.x - stream.width * 0.5, y);
            ctx.closePath();
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
            if (p.y < 0) p.y = this.height;
            if (p.y > this.height) p.y = 0;

            const pulse = p.opacity * (0.6 + Math.sin(this.time * 0.04 + p.pulse) * 0.4);

            // Outer glow
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.size * 2, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(${p.color}, ${pulse * 0.2})`;
            ctx.fill();

            // Core particle
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(${p.color}, ${pulse})`;
            ctx.shadowBlur = 12;
            ctx.shadowColor = `rgba(${p.color}, ${pulse * 0.6})`;
            ctx.fill();
            ctx.shadowBlur = 0;

            // Bright center
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.size * 0.4, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(255, 255, 255, ${pulse * 0.8})`;
            ctx.fill();
        });
    }

    drawCornerAccents() {
        const { ctx } = this;
        const size = this.config.cornerSize;
        const opacity = 0.08 + Math.sin(this.time * 0.02) * 0.02;

        ctx.strokeStyle = `rgba(0, 242, 255, ${opacity})`;
        ctx.lineWidth = 1.5;

        // Top-left corner
        ctx.beginPath();
        ctx.moveTo(20, 20 + size);
        ctx.lineTo(20, 20);
        ctx.lineTo(20 + size, 20);
        ctx.stroke();

        // Top-right corner
        ctx.beginPath();
        ctx.moveTo(this.width - 20 - size, 20);
        ctx.lineTo(this.width - 20, 20);
        ctx.lineTo(this.width - 20, 20 + size);
        ctx.stroke();

        // Bottom-left corner
        ctx.beginPath();
        ctx.moveTo(20, this.height - 20 - size);
        ctx.lineTo(20, this.height - 20);
        ctx.lineTo(20 + size, this.height - 20);
        ctx.stroke();

        // Bottom-right corner
        ctx.beginPath();
        ctx.moveTo(this.width - 20 - size, this.height - 20);
        ctx.lineTo(this.width - 20, this.height - 20);
        ctx.lineTo(this.width - 20, this.height - 20 - size);
        ctx.stroke();
    }

    drawMeasurementTicks() {
        const { ctx, height } = this;
        const opacity = 0.05;

        ctx.fillStyle = `rgba(0, 242, 255, ${opacity})`;

        // Left side ticks
        for (let y = 100; y < height - 100; y += 150) {
            const pulse = 0.5 + Math.sin(this.time * 0.03 + y * 0.01) * 0.5;
            ctx.fillRect(8, y, 2, 20 * pulse);
        }

        // Right side ticks
        for (let y = 100; y < height - 100; y += 150) {
            const pulse = 0.5 + Math.sin(this.time * 0.03 + y * 0.01 + 1) * 0.5;
            ctx.fillRect(this.width - 10, y, 2, 20 * pulse);
        }
    }

    drawOrbs() {
        const { ctx } = this;

        this.config.orbs.forEach((orb, i) => {
            const x = this.width * orb.x + Math.sin(this.time * orb.speed + i) * 50;
            const y = this.height * orb.y + Math.cos(this.time * orb.speed * 0.8 + i * 0.5) * 40;
            const size = orb.size * (1 + Math.sin(this.time * orb.speed * 0.5) * 0.08);

            const gradient = ctx.createRadialGradient(x, y, 0, x, y, size);
            gradient.addColorStop(0, `rgba(${orb.color}, ${orb.opacity})`);
            gradient.addColorStop(1, `rgba(${orb.color}, 0)`);

            ctx.beginPath();
            ctx.arc(x, y, size, 0, Math.PI * 2);
            ctx.fillStyle = gradient;
            ctx.fill();
        });
    }

    drawVignette() {
        const { ctx, width, height } = this;

        const gradient = ctx.createRadialGradient(
            width / 2, height / 2, height * 0.25,
            width / 2, height / 2, width * 0.7
        );
        gradient.addColorStop(0, 'rgba(0, 0, 0, 0)');
        gradient.addColorStop(1, 'rgba(0, 0, 0, 0.25)');

        ctx.fillStyle = gradient;
        ctx.fillRect(0, 0, width, height);
    }

    animate() {
        const { ctx, width, height } = this;

        // Clear
        ctx.clearRect(0, 0, width, height);

        // Draw layers (back to front)
        this.drawOrbs();
        this.drawGrid();
        this.drawMeasurementTicks();
        this.drawStreams();
        this.drawFocalPoints();
        this.drawParticles();
        this.drawCornerAccents();
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
    const projectsContent = document.querySelector('.relative.max-w-7xl');
    if (!projectsContent) return;

    const canvas = document.createElement('canvas');
    canvas.id = 'projects-bg-canvas';
    canvas.className = 'absolute inset-0 w-full h-full z-0 pointer-events-none';

    // Insert as first child of the projects container
    projectsContent.insertBefore(canvas, projectsContent.firstChild);

    new ProjectsBackground(canvas, {
        gridSize: 80,
        gridOpacity: 0.035,
        focalPoints: 10,
        focalSize: 4,
        focalGlow: 18,
        streams: 14,
        streamSpeed: 1.2,
        streamOpacity: 0.05,
        particles: 40,
        cornerSize: 70
    });
});

export { ProjectsBackground };
