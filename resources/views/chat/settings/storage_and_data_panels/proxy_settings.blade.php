<div id="proxy_settings_panel"
    class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="toggleProxySettings()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Proxy</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 min-h-0 overflow-y-auto custom-scrollbar bg-[#111b21] py-2">
        <div class="flex flex-col gap-0 mx-4 mb-4 pb-2 mt-2">
            
            <!-- Use proxy -->
            <div class="flex items-center py-4 justify-between -mx-4 px-4 border-b border-[#202c33]">
                <div class="flex-1 pr-4">
                    <div class="text-[#e9edef] text-[16px] mb-1">Use proxy</div>
                    <div class="text-[#8696a0] text-[14px] leading-snug">
                        Only use a proxy if you're unable to connect to WhatsApp. Your IP address may be visible to the proxy provider, which is not WhatsApp. <a href="#" class="text-[#00a884] hover:underline" onclick="window.showToast('Learn more', 'Opening help center...')">Learn more</a>
                    </div>
                </div>
                <div class="pt-2 flex items-center h-full">
                    <label class="relative inline-flex items-center cursor-pointer mt-1">
                        <input type="checkbox" id="use_proxy_toggle" class="sr-only peer" onchange="toggleUseProxy(this.checked)">
                        <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
                    </label>
                </div>
            </div>

            <!-- Set up proxy -->
            <div class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4" onclick="toggleProxySetup()">
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">Set up proxy</span>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script>
    function toggleProxySettings() {
        const proxyPanel = document.getElementById('proxy_settings_panel');
        const storagePanel = document.getElementById('storage_and_data_settings_panel');

        if (proxyPanel.classList.contains('hidden')) {
            proxyPanel.classList.remove('hidden');
            proxyPanel.classList.add('flex');
            if (storagePanel) {
                storagePanel.classList.add('hidden');
                storagePanel.classList.remove('flex');
            }
        } else {
            proxyPanel.classList.add('hidden');
            proxyPanel.classList.remove('flex');
            if (storagePanel) {
                storagePanel.classList.remove('hidden');
                storagePanel.classList.add('flex');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const proxyToggle = document.getElementById('use_proxy_toggle');
        if (proxyToggle) {
            const savedSetting = localStorage.getItem('whatsapp_proxy_enabled');
            if (savedSetting !== null) {
                proxyToggle.checked = savedSetting === 'true';
            }
        }
        checkAndLoadFirebaseProxySettings();
    });

    function checkAndLoadFirebaseProxySettings() {
        if (window.db && window.ref && window.get && window.myUserId && window.myUserId !== '0') {
            window.get(window.ref(window.db, `users/${window.myUserId}/settings/proxy_enabled`)).then(snap => {
                if (snap.exists()) {
                    const isChecked = snap.val();
                    const proxyToggle = document.getElementById('use_proxy_toggle');
                    if (proxyToggle) proxyToggle.checked = isChecked;
                    localStorage.setItem('whatsapp_proxy_enabled', isChecked);
                    updateStorageAndDataProxyText();
                }
            }).catch(e => console.error("Firebase proxy fetch error:", e));
        } else {
            setTimeout(checkAndLoadFirebaseProxySettings, 1000);
        }
    }

    function toggleUseProxy(isChecked) {
        localStorage.setItem('whatsapp_proxy_enabled', isChecked);
        updateStorageAndDataProxyText();
        
        if (window.db && window.ref && window.set && window.myUserId && window.myUserId !== '0') {
            window.set(window.ref(window.db, `users/${window.myUserId}/settings/proxy_enabled`), isChecked)
                .catch(e => console.error("Firebase save proxy error:", e));
        }
    }

    function updateStorageAndDataProxyText() {
        const isEnabled = localStorage.getItem('whatsapp_proxy_enabled') === 'true';
        const textEl = document.getElementById('storage_and_data_proxy_text');
        if (textEl) {
            textEl.innerText = isEnabled ? 'On' : 'Off';
        }
    }
</script>
