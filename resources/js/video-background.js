import HlsModule from 'hls.js';

const VIDEO_SRC = 'https://stream.mux.com/Aa02T7oM1wH5Mk5EEVDYhbZ1ChcdhRsS2m1NYyx4Ua1g.m3u8';

export function initVideoBackground() {
    const video = document.getElementById('bg-video');
    const container = document.getElementById('bg-video-container');
    if (!video || !container) {
        console.warn('[VideoBackground] #bg-video or #bg-video-container not found');
        return;
    }

    // Set video attributes for reliable autoplay
    video.muted = true;
    video.defaultMuted = true;
    video.playsInline = true;
    video.loop = true;
    video.setAttribute('playsinline', '');
    video.setAttribute('muted', '');
    video.setAttribute('autoplay', '');
    video.setAttribute('loop', '');

    const HlsClass = window.Hls || HlsModule;

    const showVideo = () => {
        video.classList.remove('opacity-0');
        video.classList.add('opacity-100');
        container.classList.remove('bg-video-fallback');
    };

    const playVideo = () => {
        const p = video.play();
        if (p && typeof p.then === 'function') {
            p.then(() => {
                console.log('[VideoBackground] Video playing successfully');
                showVideo();
            }).catch(err => {
                console.warn('[VideoBackground] Autoplay blocked, waiting for user gesture:', err.message);
                const onGesture = () => {
                    video.play().then(() => showVideo()).catch(() => {});
                    window.removeEventListener('click', onGesture);
                    window.removeEventListener('scroll', onGesture);
                    window.removeEventListener('touchstart', onGesture);
                    window.removeEventListener('keydown', onGesture);
                    window.removeEventListener('mousemove', onGesture);
                };
                window.addEventListener('click', onGesture, { once: true });
                window.addEventListener('scroll', onGesture, { once: true });
                window.addEventListener('touchstart', onGesture, { once: true });
                window.addEventListener('keydown', onGesture, { once: true });
                window.addEventListener('mousemove', onGesture, { once: true });
            });
        }
    };

    const onError = (context) => {
        console.error(`[VideoBackground] ${context} — fallback gradient remains visible`);
        // Keep the fallback gradient visible; no further action needed
    };

    if (HlsClass && HlsClass.isSupported()) {
        console.log('[VideoBackground] Initializing HLS.js...');
        const hls = new HlsClass({
            enableWorker: true,
            lowLatencyMode: false,
            backBufferLength: 90,
            maxBufferLength: 30,
            maxMaxBufferLength: 60,
        });

        hls.loadSource(VIDEO_SRC);
        hls.attachMedia(video);

        hls.on(HlsClass.Events.MANIFEST_PARSED, () => {
            console.log('[VideoBackground] Manifest parsed, attempting play');
            playVideo();
        });

        hls.on(HlsClass.Events.ERROR, (event, data) => {
            if (data.fatal) {
                switch (data.type) {
                    case HlsClass.ErrorTypes.NETWORK_ERROR:
                        console.warn('[VideoBackground] Network error, retrying...');
                        hls.startLoad();
                        break;
                    case HlsClass.ErrorTypes.MEDIA_ERROR:
                        console.warn('[VideoBackground] Media error, recovering...');
                        hls.recoverMediaError();
                        break;
                    default:
                        onError('Unrecoverable HLS error');
                        hls.destroy();
                        break;
                }
            }
        });
    } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
        console.log('[VideoBackground] Using native HLS player (Safari/iOS)');
        video.src = VIDEO_SRC;
        video.addEventListener('loadedmetadata', () => {
            playVideo();
        });
        video.addEventListener('error', () => {
            onError('Native HLS playback error');
        });
        playVideo();
    } else {
        onError('HLS not supported in this browser');
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initVideoBackground);
} else {
    initVideoBackground();
}
