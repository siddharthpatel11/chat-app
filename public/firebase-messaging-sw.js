importScripts('https://www.gstatic.com/firebasejs/10.7.1/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging-compat.js');

firebase.initializeApp({
    apiKey: "AIzaSyCTUuLg0mheURhlG1Z0p0DgMRwoAcR-F0w",
    authDomain: "chat-app-a370c.firebaseapp.com",
    databaseURL: "https://chat-app-a370c-default-rtdb.firebaseio.com",
    projectId: "chat-app-a370c",
    messagingSenderId: "1089034732064",
    appId: "1:1016598612026:web:6cc4d1dd4466eec8934d03"
});

const messaging = firebase.messaging();

const CACHE_NAME = 'chat-app-v3';
const OFFLINE_FALLBACK = '/chat';

// Assets to pre-cache for offline support
const PRECACHE_ASSETS = [
    '/',
    '/chat',
    '/manifest.json',
    '/icon-192.png',
    '/icon-512.png',
];

// Install: pre-cache core assets
self.addEventListener('install', (e) => {
    self.skipWaiting();
    e.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return Promise.all(
                PRECACHE_ASSETS.map((url) => {
                    return fetch(new Request(url, { headers: { 'ngrok-skip-browser-warning': 'true' } }))
                        .then((response) => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return cache.put(url, response);
                        });
                })
            ).catch(() => {
                // Silently fail if some assets can't be cached
            });
        })
    );
});

// Activate: clean up old caches
self.addEventListener('activate', (e) => {
    e.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames
                    .filter((name) => name !== CACHE_NAME)
                    .map((name) => caches.delete(name))
            );
        }).then(() => self.clients.claim())
    );
});

// Fetch: Network-first for HTML pages, Cache-first for static assets
self.addEventListener('fetch', (e) => {
    const { request } = e;
    const url = new URL(request.url);

    // Skip non-GET requests and cross-origin requests
    if (request.method !== 'GET' || url.origin !== self.location.origin) {
        return;
    }

    // Skip Firebase API calls, downloads, and other dynamic data
    if (url.pathname.includes('/api/') || url.pathname.includes('/download/') || url.hostname.includes('firebaseio.com') || url.hostname.includes('googleapis.com')) {
        return;
    }

    // Static assets and manifest: cache-first strategy
    if (url.pathname.match(/\.(js|css|png|jpg|jpeg|gif|svg|ico|woff|woff2|ttf|json)$/)) {
        e.respondWith(
            caches.match(request).then((cached) => {
                if (cached) return cached;
                // Add ngrok header for caching static assets if they missed the cache
                const fetchReq = new Request(request.url, { headers: { 'ngrok-skip-browser-warning': 'true' } });
                return fetch(fetchReq).then((response) => {
                    if (response && response.status === 200) {
                        const clone = response.clone();
                        caches.open(CACHE_NAME).then((cache) => cache.put(request, clone));
                    }
                    return response;
                }).catch(() => cached);
            })
        );
        return;
    }

    // HTML pages: network-first with fallback
    e.respondWith(
        fetch(request).then((response) => {
            if (response && response.status === 200) {
                const clone = response.clone();
                caches.open(CACHE_NAME).then((cache) => cache.put(request, clone));
            }
            return response;
        }).catch(() => {
            return caches.match(request).then((cached) => {
                return cached || caches.match(OFFLINE_FALLBACK);
            });
        })
    );
});

// Background push notifications
messaging.onBackgroundMessage((payload) => {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    const notificationTitle = payload.notification?.title || 'New Message';
    const notificationOptions = {
        body: payload.notification?.body || '',
        icon: '/icon-192.png',
        badge: '/icon-192.png',
        tag: 'chat-notification',
        renotify: true,
        data: payload.data || {},
    };
    self.registration.showNotification(notificationTitle, notificationOptions);
});

// Notification click: open/focus the app
self.addEventListener('notificationclick', (e) => {
    e.notification.close();
    e.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clientList) => {
            for (const client of clientList) {
                if (client.url.includes('/chat') && 'focus' in client) {
                    return client.focus();
                }
            }
            if (clients.openWindow) {
                return clients.openWindow('/chat');
            }
        })
    );
});
