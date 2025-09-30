const CACHE_NAME = 'myfarm-v2'; // Increment version to force cache refresh
const urlsToCache = [
    '/manifest.json'
];

// Install event
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                // Only cache static assets, not HTML pages
                return cache.addAll(urlsToCache);
            })
            .catch(error => {
                console.log('Cache install failed:', error);
            })
    );
    // Force immediate activation
    self.skipWaiting();
});

// Fetch event - Network-first strategy for HTML, cache for static assets
self.addEventListener('fetch', event => {
    const url = new URL(event.request.url);

    // Skip non-GET requests and cross-origin requests
    if (event.request.method !== 'GET' || !event.request.url.startsWith(self.location.origin)) {
        return;
    }

    // Never cache HTML pages or API calls (prevents stale CSRF tokens)
    const neverCache = [
        '/livewire/',
        '/admin',
        '/login'
    ];

    if (neverCache.some(path => url.pathname.includes(path)) ||
        event.request.headers.get('accept')?.includes('text/html')) {
        // Network-first: always fetch fresh HTML and Livewire requests
        event.respondWith(fetch(event.request));
        return;
    }

    // Cache-first strategy for static assets only (CSS, JS, images)
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                if (response) {
                    return response;
                }
                // Fetch and cache static assets
                return fetch(event.request).then(fetchResponse => {
                    if (!fetchResponse || fetchResponse.status !== 200) {
                        return fetchResponse;
                    }

                    // Only cache static assets (JS, CSS, images, fonts)
                    const contentType = fetchResponse.headers.get('content-type');
                    if (contentType && (
                        contentType.includes('javascript') ||
                        contentType.includes('css') ||
                        contentType.includes('image') ||
                        contentType.includes('font')
                    )) {
                        const responseToCache = fetchResponse.clone();
                        caches.open(CACHE_NAME).then(cache => {
                            cache.put(event.request, responseToCache);
                        });
                    }

                    return fetchResponse;
                });
            })
            .catch(() => fetch(event.request))
    );
});

// Activate event
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheName !== CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => {
            // Take control of all pages immediately
            return self.clients.claim();
        })
    );
});