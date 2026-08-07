<div id="proxy_setup_panel"
    class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="toggleProxySetup()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Set up proxy</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 min-h-0 overflow-y-auto custom-scrollbar bg-[#111b21] py-2 relative">
        <div class="flex flex-col gap-0 mx-4 mb-4 pb-2 mt-4">
            
            <!-- Proxy Host Input -->
            <div class="relative border-b-2 border-[#00a884] bg-[#202c33] rounded-t-md px-3 pt-5 pb-2 mb-6">
                <label class="absolute top-1 left-3 text-[12px] text-[#00a884]">Proxy host</label>
                <input type="text" id="proxy_host_input" class="w-full bg-transparent text-[#e9edef] text-[16px] outline-none" placeholder="">
            </div>

            <div class="text-[#8696a0] text-[14px] font-semibold mb-2">Ports (Optional)</div>

            <!-- Chat Port -->
            <div class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4" onclick="openProxyPortModal('chat')">
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">Chat port</span>
                    <span id="proxy_chat_port_text" class="text-[#8696a0] text-[14px] mt-1">Default</span>
                </div>
            </div>

            <!-- Media Port -->
            <div class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4" onclick="openProxyPortModal('media')">
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">Media port</span>
                    <span id="proxy_media_port_text" class="text-[#8696a0] text-[14px] mt-1">Default</span>
                </div>
            </div>

        </div>

        <!-- Floating Save Button -->
        <button onclick="saveProxySetup()" class="absolute bottom-6 right-6 w-14 h-14 bg-[#00a884] rounded-full flex items-center justify-center hover:bg-[#00c99f] transition-colors shadow-lg">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="white">
                <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path>
            </svg>
        </button>
    </div>
</div>

<!-- Port Modal overlay -->
<div id="proxy_port_modal" class="hidden absolute top-0 left-0 w-full h-full z-40 bg-black bg-opacity-70 flex items-center justify-center px-4">
    <div class="bg-[#2a3942] rounded-2xl w-full max-w-[340px] p-6 shadow-2xl relative">
        <h2 id="proxy_port_modal_title" class="text-[#e9edef] text-[20px] mb-6 font-medium">Chat port</h2>
        
        <div class="border border-[#313d45] rounded-md px-3 py-2 mb-6 focus-within:border-[#00a884]">
            <input type="number" id="proxy_port_input_modal" class="w-full bg-transparent text-[#e9edef] text-[16px] outline-none" value="443">
        </div>
        
        <div id="proxy_tls_container" class="flex items-center mb-8 cursor-pointer" onclick="toggleTlsCheckbox()">
            <div class="w-5 h-5 border-2 rounded-sm border-[#8696a0] flex items-center justify-center mr-4" id="proxy_tls_checkbox_ui">
                <svg id="proxy_tls_check_svg" viewBox="0 0 24 24" width="16" height="16" fill="white" class="hidden">
                    <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path>
                </svg>
            </div>
            <span class="text-[#e9edef] text-[16px]">Use TLS</span>
            <input type="checkbox" id="proxy_tls_input" class="hidden" checked>
        </div>

        <div class="flex justify-end gap-6 text-[#00a884] font-medium text-[14px]">
            <button onclick="closeProxyPortModal()" class="hover:text-[#00c99f] uppercase tracking-wide">Cancel</button>
            <button onclick="saveProxyPortModal()" class="hover:text-[#00c99f] uppercase tracking-wide">Save</button>
        </div>
    </div>
</div>

<script>
    let currentProxyPortEdit = 'chat';

    function toggleProxySetup() {
        const setupPanel = document.getElementById('proxy_setup_panel');
        const proxySettingsPanel = document.getElementById('proxy_settings_panel');
        
        if (setupPanel.classList.contains('hidden')) {
            setupPanel.classList.remove('hidden');
            setupPanel.classList.add('flex');
            if (proxySettingsPanel) {
                proxySettingsPanel.classList.add('hidden');
                proxySettingsPanel.classList.remove('flex');
            }
            loadProxySetupFields();
        } else {
            setupPanel.classList.add('hidden');
            setupPanel.classList.remove('flex');
            if (proxySettingsPanel) {
                proxySettingsPanel.classList.remove('hidden');
                proxySettingsPanel.classList.add('flex');
            }
        }
    }

    function openProxyPortModal(type) {
        currentProxyPortEdit = type;
        const modal = document.getElementById('proxy_port_modal');
        const title = document.getElementById('proxy_port_modal_title');
        const input = document.getElementById('proxy_port_input_modal');
        const tlsContainer = document.getElementById('proxy_tls_container');
        const tlsInput = document.getElementById('proxy_tls_input');
        
        modal.classList.remove('hidden');
        
        if (type === 'chat') {
            title.innerText = 'Chat port';
            const p = localStorage.getItem('whatsapp_proxy_chat_port') || '443';
            input.value = p;
            tlsContainer.classList.remove('hidden');
            
            const useTls = localStorage.getItem('whatsapp_proxy_chat_tls') !== 'false';
            tlsInput.checked = useTls;
            updateTlsCheckboxUI();
        } else {
            title.innerText = 'Media port';
            const p = localStorage.getItem('whatsapp_proxy_media_port') || '587';
            input.value = p;
            tlsContainer.classList.add('hidden'); // Only Chat port has Use TLS in screenshot
        }
    }

    function closeProxyPortModal() {
        document.getElementById('proxy_port_modal').classList.add('hidden');
    }

    function toggleTlsCheckbox() {
        const input = document.getElementById('proxy_tls_input');
        input.checked = !input.checked;
        updateTlsCheckboxUI();
    }

    function updateTlsCheckboxUI() {
        const input = document.getElementById('proxy_tls_input');
        const ui = document.getElementById('proxy_tls_checkbox_ui');
        const svg = document.getElementById('proxy_tls_check_svg');
        if (input.checked) {
            ui.classList.add('bg-[#00a884]', 'border-[#00a884]');
            ui.classList.remove('border-[#8696a0]');
            svg.classList.remove('hidden');
        } else {
            ui.classList.remove('bg-[#00a884]', 'border-[#00a884]');
            ui.classList.add('border-[#8696a0]');
            svg.classList.add('hidden');
        }
    }

    function saveProxyPortModal() {
        const val = document.getElementById('proxy_port_input_modal').value;
        if (currentProxyPortEdit === 'chat') {
            const tls = document.getElementById('proxy_tls_input').checked;
            localStorage.setItem('whatsapp_proxy_chat_port', val);
            localStorage.setItem('whatsapp_proxy_chat_tls', tls);
            document.getElementById('proxy_chat_port_text').innerText = val === '443' ? 'Default' : val;
        } else {
            localStorage.setItem('whatsapp_proxy_media_port', val);
            document.getElementById('proxy_media_port_text').innerText = val === '587' ? 'Default' : val;
        }
        closeProxyPortModal();
    }

    function loadProxySetupFields() {
        const host = localStorage.getItem('whatsapp_proxy_host') || '';
        document.getElementById('proxy_host_input').value = host;
        
        const chatPort = localStorage.getItem('whatsapp_proxy_chat_port') || '443';
        document.getElementById('proxy_chat_port_text').innerText = chatPort === '443' ? 'Default' : chatPort;

        const mediaPort = localStorage.getItem('whatsapp_proxy_media_port') || '587';
        document.getElementById('proxy_media_port_text').innerText = mediaPort === '587' ? 'Default' : mediaPort;
    }

    function saveProxySetup() {
        const host = document.getElementById('proxy_host_input').value;
        localStorage.setItem('whatsapp_proxy_host', host);
        
        if (window.db && window.ref && window.set && window.myUserId && window.myUserId !== '0') {
            const proxyData = {
                host: host,
                chat_port: localStorage.getItem('whatsapp_proxy_chat_port') || '443',
                chat_tls: localStorage.getItem('whatsapp_proxy_chat_tls') !== 'false',
                media_port: localStorage.getItem('whatsapp_proxy_media_port') || '587',
                updated_at: new Date().toISOString()
            };
            window.set(window.ref(window.db, `users/${window.myUserId}/settings/proxy_config`), proxyData)
                .then(() => {
                    if(window.showToast) window.showToast('Proxy Saved', 'Proxy settings saved successfully.');
                })
                .catch(e => console.error("Firebase save proxy config error:", e));
        } else {
            if(window.showToast) window.showToast('Proxy Saved', 'Saved locally.');
        }
        
        toggleProxySetup(); // Go back
    }

    // Call check Firebase on load for proxy setup
    document.addEventListener('DOMContentLoaded', () => {
        checkAndLoadFirebaseProxyConfig();
    });

    function checkAndLoadFirebaseProxyConfig() {
        if (window.db && window.ref && window.get && window.myUserId && window.myUserId !== '0') {
            window.get(window.ref(window.db, `users/${window.myUserId}/settings/proxy_config`)).then(snap => {
                if (snap.exists()) {
                    const data = snap.val();
                    if(data.host) localStorage.setItem('whatsapp_proxy_host', data.host);
                    if(data.chat_port) localStorage.setItem('whatsapp_proxy_chat_port', data.chat_port);
                    if(data.chat_tls !== undefined) localStorage.setItem('whatsapp_proxy_chat_tls', data.chat_tls);
                    if(data.media_port) localStorage.setItem('whatsapp_proxy_media_port', data.media_port);
                    loadProxySetupFields();
                }
            }).catch(e => console.error(e));
        } else {
            setTimeout(checkAndLoadFirebaseProxyConfig, 1000);
        }
    }
</script>
