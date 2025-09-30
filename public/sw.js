const CACHE_NAME = 'myfarm-v3';

// Install event
self.addEventListener('install', event => {
    // Skip waiting to activate immediately
    self.skipWaiting();
});

// Fetch event - Minimal intervention, only cache static assets
self.addEventListener('fetch', event => {
    // Only handle GET requests from same origin
    if (event.request.method !== 'GET' || !event.request.url.startsWith(self.location.origin)) {
        return;
    }

    const url = new URL(event.request.url);

    // NEVER intercept HTML pages, Livewire, or admin routes
    // Let browser handle them naturally to avoid CSRF issues
    if (url.pathname.startsWith('/livewire') ||
        url.pathname.startsWith('/admin') ||
        url.pathname.includes('/login') ||
        event.request.headers.get('accept')?.includes('text/html')) {
        return; // Don't intercept, let browser handle
    }

    // Only cache JS, CSS, images, fonts with network-first strategy
    const cacheable = /\.(js|css|png|jpg|jpeg|gif|svg|woff|woff2|ttf|eot)$/i.test(url.pathname);

    if (!cacheable) {
        return; // Don't intercept
    }

    // Network-first strategy for static assets
    event.respondWith(
        fetch(event.request)
            .then(response => {
                if (response && response.status === 200) {
                    const responseToCache = response.clone();
                    caches.open(CACHE_NAME).then(cache => {
                        cache.put(event.request, responseToCache);
                    });
                }
                return response;
            })
            .catch(() => {
                // On network failure, try cache
                return caches.match(event.request);
            })
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