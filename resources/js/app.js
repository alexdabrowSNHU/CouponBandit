import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
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