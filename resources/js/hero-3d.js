/**
 * Hero 3D Scene — Interactive Crystalline Structure
 * Premium Three.js scene with floating geometric shapes, particles, and mouse interaction
 */

import * as THREE from 'three';

class Hero3DScene {
    constructor(container) {
        this.container = container;
        this.mouse = new THREE.Vector2(0, 0);
        this.targetMouse = new THREE.Vector2(0, 0);
        this.clock = new THREE.Clock();
        this.objects = [];
        this.particles = null;
        this.ringObjects = [];
        this.disposed = false;

        this.init();
        this.createScene();
        this.animate();

        window.addEventListener('resize', () => this.onResize());
        window.addEventListener('mousemove', (e) => this.onMouseMove(e));
    }

    init() {
        // Scene
        this.scene = new THREE.Scene();
        this.scene.fog = new THREE.FogExp2(0x000000, 0.0008);

        // Camera
        this.camera = new THREE.PerspectiveCamera(
            60,
            this.container.clientWidth / this.container.clientHeight,
            0.1,
            1000
        );
        this.camera.position.set(0, 0, 30);

        // Renderer
        this.renderer = new THREE.WebGLRenderer({
            antialias: true,
            alpha: true,
            powerPreference: 'high-performance'
        });
        this.renderer.setSize(this.container.clientWidth, this.container.clientHeight);
        this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        this.renderer.setClearColor(0x000000, 0);
        this.container.appendChild(this.renderer.domElement);

        // Lights
        const ambientLight = new THREE.AmbientLight(0x111122, 0.8);
        this.scene.add(ambientLight);

        const pointLight1 = new THREE.PointLight(0x00f2ff, 2, 100);
        pointLight1.position.set(10, 15, 15);
        this.scene.add(pointLight1);
        this.mainLight = pointLight1;

        const pointLight2 = new THREE.PointLight(0x7000ff, 1.5, 80);
        pointLight2.position.set(-15, -10, 10);
        this.scene.add(pointLight2);

        const pointLight3 = new THREE.PointLight(0xff0099, 1, 60);
        pointLight3.position.set(5, -15, 5);
        this.scene.add(pointLight3);
    }

    createScene() {
        this.createCentralStructure();
        this.createFloatingGeometry();
        this.createParticleField();
        this.createOrbitalRings();
        this.createLightBeams();
    }

    createCentralStructure() {
        // Central icosahedron with wireframe
        const icoGeo = new THREE.IcosahedronGeometry(4.5, 1);
        const icoMat = new THREE.MeshPhysicalMaterial({
            color: 0x00f2ff,
            metalness: 0.9,
            roughness: 0.1,
            transparent: true,
            opacity: 0.15,
            side: THREE.DoubleSide,
            envMapIntensity: 1.5,
        });
        this.centralMesh = new THREE.Mesh(icoGeo, icoMat);
        this.scene.add(this.centralMesh);

        // Wireframe overlay
        const wireGeo = new THREE.IcosahedronGeometry(4.6, 1);
        const wireMat = new THREE.MeshBasicMaterial({
            color: 0x00f2ff,
            wireframe: true,
            transparent: true,
            opacity: 0.3,
        });
        this.wireframeMesh = new THREE.Mesh(wireGeo, wireMat);
        this.scene.add(this.wireframeMesh);

        // Inner core glow
        const coreGeo = new THREE.IcosahedronGeometry(2.5, 2);
        const coreMat = new THREE.MeshBasicMaterial({
            color: 0x00f2ff,
            transparent: true,
            opacity: 0.08,
        });
        this.coreMesh = new THREE.Mesh(coreGeo, coreMat);
        this.scene.add(this.coreMesh);

        // Outer shell
        const shellGeo = new THREE.IcosahedronGeometry(6, 0);
        const shellMat = new THREE.MeshBasicMaterial({
            color: 0x00d4ff,
            wireframe: true,
            transparent: true,
            opacity: 0.06,
        });
        this.shellMesh = new THREE.Mesh(shellGeo, shellMat);
        this.scene.add(this.shellMesh);
    }

    createFloatingGeometry() {
        const shapes = [
            { geo: new THREE.OctahedronGeometry(1.2, 0), pos: [8, 5, -3], color: 0x7000ff, speed: 0.8 },
            { geo: new THREE.TetrahedronGeometry(0.9, 0), pos: [-7, 6, -5], color: 0xff0099, speed: 1.2 },
            { geo: new THREE.OctahedronGeometry(0.7, 0), pos: [9, -4, -4], color: 0x00f2ff, speed: 0.6 },
            { geo: new THREE.IcosahedronGeometry(0.8, 0), pos: [-10, -5, -6], color: 0x7000ff, speed: 1.0 },
            { geo: new THREE.TetrahedronGeometry(0.6, 0), pos: [5, -8, -3], color: 0xff0099, speed: 1.4 },
            { geo: new THREE.OctahedronGeometry(0.5, 0), pos: [-6, 8, -7], color: 0x00f2ff, speed: 0.9 },
            { geo: new THREE.DodecahedronGeometry(0.7, 0), pos: [12, 0, -8], color: 0x7000ff, speed: 0.7 },
            { geo: new THREE.IcosahedronGeometry(0.6, 0), pos: [-12, 2, -5], color: 0xff0099, speed: 1.1 },
        ];

        shapes.forEach((shape) => {
            // Solid mesh
            const mat = new THREE.MeshPhysicalMaterial({
                color: shape.color,
                metalness: 0.8,
                roughness: 0.2,
                transparent: true,
                opacity: 0.4,
                emissive: shape.color,
                emissiveIntensity: 0.1,
            });
            const mesh = new THREE.Mesh(shape.geo, mat);
            mesh.position.set(...shape.pos);

            // Wireframe
            const wireMat = new THREE.MeshBasicMaterial({
                color: shape.color,
                wireframe: true,
                transparent: true,
                opacity: 0.2,
            });
            const wireMesh = new THREE.Mesh(shape.geo.clone(), wireMat);
            wireMesh.position.copy(mesh.position);
            wireMesh.scale.multiplyScalar(1.1);

            this.scene.add(mesh);
            this.scene.add(wireMesh);

            this.objects.push({
                mesh,
                wireMesh,
                basePos: new THREE.Vector3(...shape.pos),
                speed: shape.speed,
                rotationSpeed: {
                    x: (Math.random() - 0.5) * 0.02,
                    y: (Math.random() - 0.5) * 0.02,
                    z: (Math.random() - 0.5) * 0.01,
                },
                floatPhase: Math.random() * Math.PI * 2,
            });
        });
    }

    createParticleField() {
        const count = 2000;
        const positions = new Float32Array(count * 3);
        const colors = new Float32Array(count * 3);
        const sizes = new Float32Array(count);

        const colorPalette = [
            new THREE.Color(0x00f2ff),
            new THREE.Color(0x7000ff),
            new THREE.Color(0xff0099),
            new THREE.Color(0xffffff),
        ];

        for (let i = 0; i < count; i++) {
            // Distribute in sphere-ish pattern
            const r = 5 + Math.random() * 45;
            const theta = Math.random() * Math.PI * 2;
            const phi = Math.acos(2 * Math.random() - 1);

            positions[i * 3] = r * Math.sin(phi) * Math.cos(theta);
            positions[i * 3 + 1] = r * Math.sin(phi) * Math.sin(theta);
            positions[i * 3 + 2] = r * Math.cos(phi) - 10;

            const col = colorPalette[Math.floor(Math.random() * colorPalette.length)];
            colors[i * 3] = col.r;
            colors[i * 3 + 1] = col.g;
            colors[i * 3 + 2] = col.b;

            sizes[i] = 0.03 + Math.random() * 0.12;
        }

        const geometry = new THREE.BufferGeometry();
        geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
        geometry.setAttribute('color', new THREE.BufferAttribute(colors, 3));
        geometry.setAttribute('size', new THREE.BufferAttribute(sizes, 1));

        const material = new THREE.PointsMaterial({
            size: 0.08,
            vertexColors: true,
            transparent: true,
            opacity: 0.6,
            sizeAttenuation: true,
            blending: THREE.AdditiveBlending,
            depthWrite: false,
        });

        this.particles = new THREE.Points(geometry, material);
        this.scene.add(this.particles);
    }

    createOrbitalRings() {
        const ringRadii = [7, 10, 14];
        const ringColors = [0x00f2ff, 0x7000ff, 0xff0099];

        ringRadii.forEach((radius, i) => {
            const curve = new THREE.EllipseCurve(0, 0, radius, radius * 0.6, 0, 2 * Math.PI, false, 0);
            const points = curve.getPoints(128);
            const geometry = new THREE.BufferGeometry().setFromPoints(
                points.map(p => new THREE.Vector3(p.x, p.y, 0))
            );
            const material = new THREE.LineBasicMaterial({
                color: ringColors[i],
                transparent: true,
                opacity: 0.08 + i * 0.02,
                blending: THREE.AdditiveBlending,
            });
            const ring = new THREE.Line(geometry, material);
            ring.rotation.x = Math.PI * 0.4 + i * 0.15;
            ring.rotation.z = i * 0.3;
            this.scene.add(ring);
            this.ringObjects.push({ ring, baseRotX: ring.rotation.x, baseRotZ: ring.rotation.z, speed: 0.1 + i * 0.05 });
        });
    }

    createLightBeams() {
        // Subtle directional light beams using thin planes
        const beamGeo = new THREE.PlaneGeometry(0.05, 40);
        const beamPositions = [
            { x: -8, z: -5, rotZ: 0.3, color: 0x00f2ff },
            { x: 6, z: -8, rotZ: -0.2, color: 0x7000ff },
            { x: 12, z: -3, rotZ: 0.15, color: 0xff0099 },
        ];

        beamPositions.forEach(bp => {
            const mat = new THREE.MeshBasicMaterial({
                color: bp.color,
                transparent: true,
                opacity: 0.03,
                side: THREE.DoubleSide,
                blending: THREE.AdditiveBlending,
            });
            const beam = new THREE.Mesh(beamGeo, mat);
            beam.position.set(bp.x, 0, bp.z);
            beam.rotation.z = bp.rotZ;
            this.scene.add(beam);
        });
    }

    onMouseMove(event) {
        this.targetMouse.x = (event.clientX / window.innerWidth) * 2 - 1;
        this.targetMouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
    }

    onResize() {
        if (this.disposed) return;
        const w = this.container.clientWidth;
        const h = this.container.clientHeight;
        this.camera.aspect = w / h;
        this.camera.updateProjectionMatrix();
        this.renderer.setSize(w, h);
    }

    animate() {
        if (this.disposed) return;
        requestAnimationFrame(() => this.animate());

        const elapsed = this.clock.getElapsedTime();

        // Smooth mouse following
        this.mouse.x += (this.targetMouse.x - this.mouse.x) * 0.05;
        this.mouse.y += (this.targetMouse.y - this.mouse.y) * 0.05;

        // Camera subtle movement
        this.camera.position.x = this.mouse.x * 3;
        this.camera.position.y = this.mouse.y * 2;
        this.camera.lookAt(0, 0, 0);

        // Central structure rotation
        if (this.centralMesh) {
            this.centralMesh.rotation.x = elapsed * 0.15 + this.mouse.y * 0.3;
            this.centralMesh.rotation.y = elapsed * 0.2 + this.mouse.x * 0.3;
        }
        if (this.wireframeMesh) {
            this.wireframeMesh.rotation.x = elapsed * 0.12 + this.mouse.y * 0.2;
            this.wireframeMesh.rotation.y = elapsed * 0.18 + this.mouse.x * 0.2;
            this.wireframeMesh.material.opacity = 0.2 + Math.sin(elapsed * 1.5) * 0.1;
        }
        if (this.coreMesh) {
            this.coreMesh.rotation.x = -elapsed * 0.3;
            this.coreMesh.rotation.y = -elapsed * 0.25;
            this.coreMesh.material.opacity = 0.05 + Math.sin(elapsed * 2) * 0.03;
        }
        if (this.shellMesh) {
            this.shellMesh.rotation.x = elapsed * 0.05;
            this.shellMesh.rotation.y = elapsed * 0.08;
        }

        // Floating objects
        this.objects.forEach((obj) => {
            const t = elapsed * obj.speed;

            obj.mesh.position.x = obj.basePos.x + Math.sin(t + obj.floatPhase) * 1.5;
            obj.mesh.position.y = obj.basePos.y + Math.cos(t * 0.7 + obj.floatPhase) * 1.2;
            obj.mesh.position.z = obj.basePos.z + Math.sin(t * 0.5) * 0.8;

            obj.mesh.rotation.x += obj.rotationSpeed.x;
            obj.mesh.rotation.y += obj.rotationSpeed.y;
            obj.mesh.rotation.z += obj.rotationSpeed.z;

            obj.wireMesh.position.copy(obj.mesh.position);
            obj.wireMesh.rotation.copy(obj.mesh.rotation);
        });

        // Orbital rings
        this.ringObjects.forEach((ring, i) => {
            ring.ring.rotation.z = ring.baseRotZ + elapsed * ring.speed * 0.1;
            ring.ring.material.opacity = 0.06 + Math.sin(elapsed * 0.5 + i) * 0.03;
        });

        // Particles slow rotation
        if (this.particles) {
            this.particles.rotation.y = elapsed * 0.02;
            this.particles.rotation.x = Math.sin(elapsed * 0.01) * 0.1;
        }

        // Main light follows mouse subtly
        if (this.mainLight) {
            this.mainLight.position.x = 10 + this.mouse.x * 5;
            this.mainLight.position.y = 15 + this.mouse.y * 5;
            this.mainLight.intensity = 2 + Math.sin(elapsed * 1.5) * 0.3;
        }

        this.renderer.render(this.scene, this.camera);
    }

    destroy() {
        this.disposed = true;
        if (this.renderer) {
            this.renderer.dispose();
            this.container.removeChild(this.renderer.domElement);
        }
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('hero-3d-container');
    if (!container) return;
    new Hero3DScene(container);
});

export { Hero3DScene };
