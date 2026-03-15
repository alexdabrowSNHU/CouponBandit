import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    // Track page navigation
    const prevUrl = document.referrer || '';
    const newUrl = window.location.href;
    console.log('Tracking navigation:', prevUrl, '->', newUrl);

    const sent = navigator.sendBeacon('/api/track/navigation', new Blob([JSON.stringify({
        prev_url: prevUrl,
        new_url: newUrl,
    })], { type: 'application/json' }));
    console.log('Beacon sent:', sent);

    // Track outbound link clicks
    document.addEventListener('click', (e) => {
        const link = e.target.closest('a');
        if (!link || !link.href) return;
        if (link.hostname === window.location.hostname) return;

        navigator.sendBeacon('/api/track/navigation', new Blob([JSON.stringify({
            prev_url: window.location.href,
            new_url: link.href,
        })], { type: 'application/json' }));
    });

    const btn = document.getElementById('mobileMenuBtn');
    const menu = document.getElementById('mobileMenu');

    if (btn && menu) {
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    }

    // Optimistic favorite toggle
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.js-favorite-btn');
        if (!btn) return;

        e.preventDefault();

        const url = btn.dataset.favoriteUrl;
        const wasFavorited = btn.dataset.favorited === '1';
        const filled = btn.querySelector('.js-heart-filled');
        const empty = btn.querySelector('.js-heart-empty');

        // Optimistic toggle
        btn.dataset.favorited = wasFavorited ? '0' : '1';
        filled.classList.toggle('hidden', wasFavorited);
        empty.classList.toggle('hidden', !wasFavorited);

        const token = document.querySelector('meta[name="csrf-token"]')?.content;

        axios.post(url, {}, {
            headers: { 'X-CSRF-TOKEN': token }
        }).catch(() => {
            // Revert on failure
            btn.dataset.favorited = wasFavorited ? '1' : '0';
            filled.classList.toggle('hidden', !wasFavorited);
            empty.classList.toggle('hidden', wasFavorited);
        });
    });
});