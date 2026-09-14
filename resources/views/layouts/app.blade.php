<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
        <!-- PWA / Mobile App Meta Tags -->
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-title" content="Chat App">
        <meta name="theme-color" content="#202c33">
        <link rel="apple-touch-icon" href="/icon-192.png">
        <link rel="apple-touch-startup-image" href="/icon-512.png">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>WhatsApp</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Dynamic Manifest and Icon -->
        <link rel="icon" type="image/png" sizes="192x192" href="/icon-192.png">
        <link rel="icon" type="image/png" sizes="512x512" href="/icon-512.png">
        <link rel="manifest" href="/manifest.json" crossorigin="use-credentials">

        <!-- Fetch Appearance Settings from Firebase if authenticated -->
        @php
            $backendAppearance = [];
            if (auth()->check()) {
                $firebaseService = app(\App\Services\FirebaseService::class);
                $userId = auth()->id();
                $backendAppearance = $firebaseService->database()->getReference("users/{$userId}/settings/appearance")->getValue() ?: [];
            }
        @endphp
        <script>
            window.backendAppearance = @json($backendAppearance);
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        @stack('styles')
    </head>
    <body class="font-sans antialiased {{ request()->is('chat') || request()->is('chat/*') ? 'bg-[#111b21] min-h-screen' : '' }}">
        <div class="{{ request()->is('chat') || request()->is('chat/*') ? 'w-full' : 'min-h-screen bg-gray-100 dark:bg-gray-900' }}">
            @if(!request()->is('chat') && !request()->is('chat/*'))
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset
            @endif

            <!-- Page Content -->
            <main class="{{ request()->is('chat') || request()->is('chat/*') ? 'w-full' : '' }}">
                {{ $slot }}
            </main>
        </div>
        
        @stack('scripts')
        <!-- PWA Install Prompt Banner -->
        <div id="pwa-install-prompt" class="hidden fixed bottom-4 left-4 right-4 md:left-auto md:right-4 md:w-96 bg-[#202c33] p-4 rounded-lg shadow-lg z-[9999] border border-[#313d45] flex items-center justify-between transition-all duration-300 transform translate-y-full">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-[#00a884] flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                </div>
                <div>
                    <h3 class="text-[#e9edef] font-semibold text-sm" id="pwa-prompt-title">Install WhatsApp Clone</h3>
                    <p class="text-[#8696a0] text-xs mt-1" id="pwa-prompt-desc">Add to your home screen for a better experience.</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button id="pwa-close-btn" class="p-2 text-[#8696a0] hover:text-[#e9edef] transition-colors">
                    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
                <button id="pwa-install-btn" class="bg-[#00a884] text-[#111b21] px-4 py-2 rounded-full font-medium text-sm hover:bg-[#029676] transition-colors whitespace-nowrap">
                    Install
                </button>
            </div>
        </div>

        <script>
            // ── Service Worker Registration ────────────────────────────────
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', () => {
                    navigator.serviceWorker.register('/firebase-messaging-sw.js')
                        .then(r  => console.log('[SW] registered:', r.scope))
                        .catch(e => console.error('[SW] registration failed:', e));
                });
            }

            // ── Platform Detection ────────────────────────────────────────
            const isAndroidMobile = () => {
                const ua = navigator.userAgent || '';
                return /android/i.test(ua) && !window.isAndroidApp;
            };

            const isIos = () => /iphone|ipad|ipod/i.test(navigator.userAgent || '');

            const isStandalone = () =>
                (('standalone' in navigator) && navigator.standalone) ||
                window.matchMedia('(display-mode: standalone)').matches;

            // ── PWA prompt helpers ────────────────────────────────────────
            const PWA_PROMPT_VERSION = '4';
            if (localStorage.getItem('pwa-prompt-version') !== PWA_PROMPT_VERSION) {
                localStorage.removeItem('pwa-prompt-dismissed');
                localStorage.setItem('pwa-prompt-version', PWA_PROMPT_VERSION);
            }

            window.deferredPrompt = null;
            const pwaInstallPrompt = document.getElementById('pwa-install-prompt');
            const pwaInstallBtn    = document.getElementById('pwa-install-btn');
            const pwaCloseBtn      = document.getElementById('pwa-close-btn');

            function showPwaPrompt() {
                pwaInstallPrompt.classList.remove('hidden');
                setTimeout(() => pwaInstallPrompt.classList.remove('translate-y-full'), 50);
            }

            function hidePwaPrompt() {
                pwaInstallPrompt.classList.add('translate-y-full');
                setTimeout(() => pwaInstallPrompt.classList.add('hidden'), 300);
            }

            // ── Desktop & Android PWA prompt (beforeinstallprompt) ──────────────────
            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                window.deferredPrompt = e;
                if (!isStandalone() && localStorage.getItem('pwa-prompt-dismissed') !== 'true') {
                    setTimeout(showPwaPrompt, 2000);
                }
            });

            pwaInstallBtn.addEventListener('click', async () => {
                hidePwaPrompt();
                window.installPWA();
            });

            pwaCloseBtn.addEventListener('click', () => {
                hidePwaPrompt();
                localStorage.setItem('pwa-prompt-dismissed', 'true');
            });

            window.addEventListener('appinstalled', () => {
                hidePwaPrompt();
                window.deferredPrompt = null;
                if (window.showToast) window.showToast('Success', 'App installed successfully!');
                const btn = document.getElementById('nav_install_pwa');
                if (btn) btn.classList.add('hidden');
            });

            // ── iOS: show "Add to Home Screen" instructions ───────────────
            if (isIos() && !isStandalone() && localStorage.getItem('pwa-prompt-dismissed') !== 'true') {
                setTimeout(() => {
                    document.getElementById('pwa-prompt-title').textContent = 'Install App (iOS)';
                    document.getElementById('pwa-prompt-desc').innerHTML =
                        'Tap the <strong>Share &#x2b06;</strong> icon, then <strong>"Add to Home Screen"</strong>.';
                    pwaInstallBtn.style.display = 'none';
                    showPwaPrompt();
                }, 3000);
            }

            // ── Show sidebar Install button (hidden by default) ───────────
            const initInstallBtn = () => {
                const btn = document.getElementById('nav_install_pwa');
                // Hide if already installed as PWA/TWA
                if (!btn || isStandalone()) return;
                btn.classList.remove('hidden');
                btn.style.display = 'block';
            };

            if (document.readyState === 'loading') {
                window.addEventListener('DOMContentLoaded', initInstallBtn);
            } else {
                initInstallBtn();
            }

            // 🚀 Main entry point: Install App button in sidebar 🚀
            window.installPWA = async function() {
                // 🛑 Running inside our Android WebView app ➔ do nothing
                if (window.isAndroidApp) return;

                const apkUrl = '{!! url("/download/universal") !!}';
                
                // If it's iOS, show iOS instructions
                if (isIos() && !isStandalone()) {
                    document.getElementById('pwa-prompt-title').textContent = 'Install App (iOS)';
                    document.getElementById('pwa-prompt-desc').innerHTML =
                        'Tap the <strong>Share &#x2b06;</strong> icon, then <strong>"Add to Home Screen"</strong>.';
                    pwaInstallBtn.style.display = 'none';
                    showPwaPrompt();
                    return;
                }

                // If it's Android Mobile, download the Universal APK
                if (isAndroidMobile()) {
                    if (window.showToast) {
                        window.showToast('Downloading Universal App...', 'Please wait while the new app downloads.');
                    }
                    // Adding timestamp to force browser to ignore any cached downloads
                    window.location.href = apkUrl + "?t=" + new Date().getTime();
                    return;
                }

                // If it's Desktop, trigger the Desktop App (.exe) download
                if (confirm("Do you want to download the Desktop App (.exe)?\n(Cancel to install the Web App instead)")) {
                    if (window.showToast) {
                        window.showToast('Downloading App...', 'Please wait while the setup file downloads.');
                    }
                    window.location.href = '{!! url("/download/desktop") !!}';
                    return;
                }

                // If they cancelled the .exe download, trigger the Native PWA Installation (Web App)
                if (window.deferredPrompt) {
                    window.deferredPrompt.prompt();
                    const { outcome } = await window.deferredPrompt.userChoice;
                    if (outcome === 'accepted') {
                        window.deferredPrompt = null;
                        const btn = document.getElementById('nav_install_pwa');
                        if (btn) btn.classList.add('hidden');
                    }
                } else {
                    if (window.showToast) {
                        window.showToast('Install App',
                            'Look for the install ⬇ icon in the address bar, or use the browser menu ➔ "Install App".');
                    }
                }
            };
        </script>
    </body>
</html>
