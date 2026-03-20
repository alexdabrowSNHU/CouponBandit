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

    const devLogAddBtn = document.getElementById('devLogAddBtn');
    const devLogModal = document.getElementById('devLogModal');
    const devLogCancelBtn = document.getElementById('devLogCancelBtn');
    const devLogForm = document.getElementById('devLogForm');
    const devLogError = document.getElementById('devLogModalError');
    const devLogSubmitBtn = document.getElementById('devLogSubmitBtn');
    const devLogList = document.getElementById('devLogList');
    const kafkaStreamBar = document.getElementById('kafkaStreamBar');
    const kafkaStreamStatusDot = document.getElementById('kafkaStreamStatusDot');
    const kafkaStreamStatusText = document.getElementById('kafkaStreamStatusText');
    const trafficLogTriggers = document.querySelectorAll('.traffic-log-trigger');
    const trafficLogModal = document.getElementById('trafficLogModal');
    const trafficLogCloseBtn = document.getElementById('trafficLogCloseBtn');
    const trafficLogTableBody = document.getElementById('trafficLogTableBody');
    const trafficLogStatus = document.getElementById('trafficLogStatus');

    if (devLogAddBtn && devLogModal && devLogCancelBtn && devLogForm && devLogError && devLogSubmitBtn && devLogList) {
        const openDevLogModal = () => {
            devLogModal.classList.remove('hidden');
            devLogModal.classList.add('flex');
            devLogError.classList.add('hidden');
            devLogError.textContent = '';
            devLogForm.reset();
        };

        const closeDevLogModal = () => {
            devLogModal.classList.add('hidden');
            devLogModal.classList.remove('flex');
        };

        devLogAddBtn.addEventListener('click', (e) => {
            e.preventDefault();
            openDevLogModal();
        });

        devLogCancelBtn.addEventListener('click', (e) => {
            e.preventDefault();
            closeDevLogModal();
        });

        devLogModal.addEventListener('click', (e) => {
            if (e.target === devLogModal) {
                closeDevLogModal();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !devLogModal.classList.contains('hidden')) {
                closeDevLogModal();
            }
        });

        devLogForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const username = document.getElementById('devlog-username')?.value.trim() || '';
            const password = document.getElementById('devlog-password')?.value || '';
            const message = document.getElementById('devlog-message')?.value.trim() || '';

            if (!username || !password || !message) {
                devLogError.textContent = 'All fields are required.';
                devLogError.classList.remove('hidden');
                return;
            }

            devLogSubmitBtn.disabled = true;
            devLogSubmitBtn.textContent = 'Adding...';

            try {
                const response = await fetch('/api/devlog', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ username, password, message }),
                });

                const data = await response.json();

                if (!response.ok) {
                    throw data;
                }

                const emptyState = devLogList.querySelector('li.text-zinc-400');
                if (emptyState) {
                    emptyState.remove();
                }

                const li = document.createElement('li');
                li.className = 'flex items-baseline justify-between gap-2 rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2';
                li.innerHTML =
                    `<span class="min-w-0 flex-1">${escapeHtml(data.message)}</span>` +
                    `<span class="shrink-0 whitespace-nowrap text-right text-xs text-zinc-500">${escapeHtml(data.date)}</span>`;

                devLogList.prepend(li);
                closeDevLogModal();
            } catch (err) {
                let msg = err?.error || 'Something went wrong.';
                if (err?.errors) {
                    const firstKey = Object.keys(err.errors)[0];
                    msg = err.errors[firstKey][0];
                }
                devLogError.textContent = msg;
                devLogError.classList.remove('hidden');
            } finally {
                devLogSubmitBtn.disabled = false;
                devLogSubmitBtn.textContent = 'Add Entry';
            }
        });
    }

    const kafkaStreamEnabled = false;

    if (kafkaStreamEnabled && kafkaStreamBar && kafkaStreamStatusDot && kafkaStreamStatusText && typeof EventSource !== 'undefined') {
        const maxItems = 14;
        const source = new EventSource('/api/events/stream');

        const setStreamStatus = (text, dotClass) => {
            kafkaStreamStatusText.textContent = text || '';
            kafkaStreamStatusDot.className = `h-2.5 w-2.5 rounded-full ${dotClass}`;
        };

        const renderKafkaMessage = (label, payload, toneClass) => {
            const emptyState = kafkaStreamBar.querySelector('[data-kafka-empty]');
            if (emptyState) {
                emptyState.remove();
            }

            const item = document.createElement('div');
            item.className = `flex items-start justify-between gap-3 rounded-2xl border px-3 py-2.5 ${toneClass}`;

            const topic = escapeHtml(label);
            const summary = escapeHtml(payload);
            const timestamp = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });

            item.innerHTML =
                `<div class="min-w-0 flex-1">` +
                `<div class="font-semibold text-zinc-800">${topic}</div>` +
                `<div class="mt-0.5 break-words text-zinc-600">${summary}</div>` +
                `</div>` +
                `<span class="shrink-0 whitespace-nowrap pt-0.5 text-xs text-zinc-500">${timestamp}</span>`;

            kafkaStreamBar.prepend(item);

            while (kafkaStreamBar.children.length > maxItems) {
                kafkaStreamBar.removeChild(kafkaStreamBar.lastElementChild);
            }
        };

        source.addEventListener('open', () => {
            setStreamStatus('', 'bg-emerald-400');
        });

        source.addEventListener('heartbeat', () => {
            setStreamStatus('', 'bg-emerald-400');
        });

        source.addEventListener('search_event', (event) => {
            setStreamStatus('', 'bg-emerald-400');

            const data = JSON.parse(event.data);
            const query = data?.payload?.query || 'search';
            const results = data?.payload?.results ?? '?';

            renderKafkaMessage(
                'search_events',
                `"${query}" -> ${results} results`,
                'border-[#cfdcc7] bg-[#edf5e6]'
            );
        });

        source.addEventListener('page_navigation_event', (event) => {
            setStreamStatus('', 'bg-emerald-400');

            const data = JSON.parse(event.data);
            const nextUrl = data?.payload?.new_url || '';

            renderKafkaMessage(
                'page_navigation_events',
                nextUrl || 'navigation event',
                'border-[#d8d4ec] bg-[#f0eef8]'
            );
        });

        source.addEventListener('error', () => {
            setStreamStatus('Connecting', 'bg-amber-400');
        });
    }

    if (trafficLogTriggers.length && trafficLogModal && trafficLogCloseBtn && trafficLogTableBody && trafficLogStatus) {
        const setTrafficLogStatus = (message = '', tone = 'neutral') => {
            if (!message) {
                trafficLogStatus.className = 'hidden rounded-lg border px-3 py-2 text-sm';
                trafficLogStatus.textContent = '';
                return;
            }

            const toneClass = tone === 'error'
                ? 'border-red-300 bg-red-50 text-red-700'
                : 'border-zinc-300 bg-zinc-50 text-zinc-700';

            trafficLogStatus.className = `rounded-lg border px-3 py-2 text-sm ${toneClass}`;
            trafficLogStatus.textContent = message;
        };

        const renderTrafficLogRows = (events) => {
            if (!events.length) {
                trafficLogTableBody.innerHTML = '<tr><td colspan="4" class="px-4 py-6 text-center text-zinc-500">No traffic events found.</td></tr>';
                return;
            }

            trafficLogTableBody.innerHTML = events.map((event) => {
                const timestamp = event.navigated_at
                    ? new Date(event.navigated_at.replace(' ', 'T')).toLocaleString()
                    : 'Unknown';

                return `
                    <tr class="align-top">
                        <td class="px-4 py-3 text-zinc-600">${escapeHtml(timestamp)}</td>
                        <td class="px-4 py-3 text-zinc-600">${escapeHtml(event.user_id ?? 'Guest')}</td>
                        <td class="max-w-xs px-4 py-3 break-words text-zinc-700">${escapeHtml(event.prev_url || '-')}</td>
                        <td class="max-w-xs px-4 py-3 break-words text-zinc-900">${escapeHtml(event.new_url || '-')}</td>
                    </tr>
                `;
            }).join('');
        };

        const loadTrafficLog = async () => {
            setTrafficLogStatus('Loading traffic log...');
            trafficLogTableBody.innerHTML = '<tr><td colspan="4" class="px-4 py-6 text-center text-zinc-500">Loading events...</td></tr>';

            try {
                const response = await fetch('/api/traffic-log', {
                    headers: {
                        'Accept': 'application/json',
                    },
                });

                const data = await response.json();

                if (!response.ok) {
                    throw data;
                }

                setTrafficLogStatus(`Showing ${data.events.length} most recent navigation events.`);
                renderTrafficLogRows(data.events);
            } catch (err) {
                setTrafficLogStatus(err?.message || 'Unable to load traffic log.', 'error');
                trafficLogTableBody.innerHTML = '<tr><td colspan="4" class="px-4 py-6 text-center text-red-700">Traffic log unavailable.</td></tr>';
            }
        };

        const openTrafficLogModal = () => {
            trafficLogModal.classList.remove('hidden');
            trafficLogModal.classList.add('flex');
            loadTrafficLog();
        };

        const closeTrafficLogModal = () => {
            trafficLogModal.classList.add('hidden');
            trafficLogModal.classList.remove('flex');
        };

        trafficLogTriggers.forEach((trigger) => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                openTrafficLogModal();
            });
        });

        trafficLogCloseBtn.addEventListener('click', (e) => {
            e.preventDefault();
            closeTrafficLogModal();
        });

        trafficLogModal.addEventListener('click', (e) => {
            if (e.target === trafficLogModal) {
                closeTrafficLogModal();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !trafficLogModal.classList.contains('hidden')) {
                closeTrafficLogModal();
            }
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

function escapeHtml(str) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}
