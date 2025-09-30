const CACHE_NAME = 'myfarm-v1';
const urlsToCache = [
    '/admin',
    '/admin/login',
    '/manifest.json'
];

// Install event
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                // Use relative URLs, browser will resolve with correct protocol
                return cache.addAll(urlsToCache);
            })
            .catch(error => {
                console.log('Cache install failed:', error);
            })
    );
    // Force immediate activation
    self.skipWaiting();
});

// Fetch event - Only cache GET requests and same-origin
self.addEventListener('fetch', event => {
    // Skip non-GET requests and cross-origin requests
    if (event.request.method !== 'GET' || !event.request.url.startsWith(self.location.origin)) {
        return;
    }

    event.respondWith(
        caches.match(event.request)
            .then(response => {
                if (response) {
                    return response;
                }
                // Fetch and cache for next time
                return fetch(event.request).then(fetchResponse => {
                    // Only cache successful responses
                    if (!fetchResponse || fetchResponse.status !== 200 || fetchResponse.type !== 'basic') {
                        return fetchResponse;
                    }
                    const responseToCache = fetchResponse.clone();
                    caches.open(CACHE_NAME).then(cache => {
                        cache.put(event.request, responseToCache);
                    });
                    return fetchResponse;
                });
            })
            .catch(() => {
                // Return a basic offline page if available
                return caches.match('/admin');
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