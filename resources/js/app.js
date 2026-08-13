import './bootstrap';
import './ambient-background';     // Global ambient background (all pages)
import './projects-background';    // Projects page immersive design
import './immersive-interactions'; // Scroll reveals, cursor, tilt, magnetic, etc.

// Heavy modules — loaded only on pages that use them
if (document.getElementById('hero-3d-container')) {
    import('./hero-3d');
}
if (document.getElementById('bg-video')) {
    import('./video-background');
}

