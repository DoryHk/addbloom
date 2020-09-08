let staticCacheName = "pwa-v" + new Date().getTime();
let imgCache = 'pwa-img';
let filesToCache = [
    '/offline',
    '/api/projects',
    '/css/app.css',
    '/js/app.js',
    '/fonts/vendor/element-ui/lib/theme-chalk/element-icons.woff?535877f50039c0cb49a6196a5b7517cd',
    '/images/icons/icon-72x72.png',
    '/images/icons/icon-96x96.png',
    '/images/icons/icon-128x128.png',
    '/images/icons/icon-144x144.png',
    '/images/icons/icon-152x152.png',
    '/images/icons/icon-192x192.png',
    '/images/icons/icon-384x384.png',
    '/images/icons/icon-512x512.png',
];

// Cache on install
self.addEventListener("install", event => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName)
            .then(cache => {
                return cache.addAll(filesToCache);
            })
    )
});

// Clear cache on activate
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => (cacheName.startsWith("pwa-")))
                    .filter(cacheName => (cacheName !== staticCacheName))
                    .map(cacheName => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", event => {
    var requestUrl = new URL(event.request.url);
    // Check if the image type
    if (/\.(jpg|jpeg|png|gif|svg|webp).*$/.test(requestUrl.pathname)) {
        event.respondWith(cacheImages(event.request));
        return;
    }
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match('offline');
            })
    )
});


/**
 * @description Adds images to the imgCache
 * @param {string} request
 * @returns {Response}
 */
function cacheImages(request) {
    let storageUrl = new URL(request.url).pathname;

    return caches.open(imgCache).then(function(cache) {
        return cache.match(storageUrl).then(function(response) {
            if (response) return response;

            return fetch(request).then(function(networkResponse) {
                cache.put(storageUrl, networkResponse.clone());
                return networkResponse;
            });
        });
    });
}
