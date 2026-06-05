<div id="chats_auto_download_panel"
    class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="toggleAutoDownloadPanel()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Media auto-download</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] py-4">
        
        <!-- Photos -->
        <div class="flex items-center justify-between py-4 px-6 hover:bg-[#202c33] transition-colors">
            <div class="text-[#e9edef] text-[16px]">Photos</div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="auto_download_photos" onchange="toggleAutoDownload('photos', this.checked)" class="sr-only peer" checked>
                <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
            </label>
        </div>

        <!-- Audio -->
        <div class="flex items-center justify-between py-4 px-6 hover:bg-[#202c33] transition-colors">
            <div class="text-[#e9edef] text-[16px]">Audio</div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="auto_download_audio" onchange="toggleAutoDownload('audio', this.checked)" class="sr-only peer" checked>
                <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
            </label>
        </div>

        <!-- Videos -->
        <div class="flex items-center justify-between py-4 px-6 hover:bg-[#202c33] transition-colors">
            <div class="text-[#e9edef] text-[16px]">Videos</div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="auto_download_videos" onchange="toggleAutoDownload('videos', this.checked)" class="sr-only peer" checked>
                <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
            </label>
        </div>

        <!-- Documents -->
        <div class="flex items-center justify-between py-4 px-6 hover:bg-[#202c33] transition-colors">
            <div class="text-[#e9edef] text-[16px]">Documents</div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="auto_download_documents" onchange="toggleAutoDownload('documents', this.checked)" class="sr-only peer" checked>
                <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
            </label>
        </div>

        <div class="px-6 border-b border-[#313d45] pb-6 mt-2">
            <p class="text-[#8696a0] text-[14px] leading-snug">Voice messages are always automatically downloaded for the best communication experience.</p>
        </div>

        <!-- Reset -->
        <div class="flex items-center gap-5 py-5 px-6 hover:bg-[#202c33] transition-colors cursor-pointer" onclick="resetAutoDownload()">
            <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor" class="text-[#8696a0]">
                <path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46A7.93 7.93 0 0 0 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74A7.93 7.93 0 0 0 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"></path>
            </svg>
            <span class="text-[#8696a0] text-[16px]">Reset auto-download settings</span>
        </div>

    </div>
</div>

<script>
    window.toggleAutoDownloadPanel = function() {
        const adPanel = document.getElementById('chats_auto_download_panel');
        const chatPanel = document.getElementById('chats_settings_panel');
        
        if (adPanel.classList.contains('hidden')) {
            adPanel.classList.remove('hidden');
            adPanel.classList.add('flex');
            if (chatPanel) chatPanel.classList.add('hidden');
            
            // Init state
            const types = ['photos', 'audio', 'videos', 'documents'];
            types.forEach(type => {
                const isEnabled = localStorage.getItem('whatsapp_auto_download_' + type) !== 'false';
                const toggle = document.getElementById('auto_download_' + type);
                if (toggle) toggle.checked = isEnabled;
            });
        } else {
            adPanel.classList.add('hidden');
            adPanel.classList.remove('flex');
            if (chatPanel) chatPanel.classList.remove('hidden');
        }
    }

    window.toggleAutoDownload = function(type, isEnabled) {
        localStorage.setItem('whatsapp_auto_download_' + type, isEnabled);
    }

    window.resetAutoDownload = function() {
        const types = ['photos', 'audio', 'videos', 'documents'];
        types.forEach(type => {
            localStorage.setItem('whatsapp_auto_download_' + type, 'true');
            const toggle = document.getElementById('auto_download_' + type);
            if (toggle) toggle.checked = true;
        });
        if(window.showToast) window.showToast('Reset', 'Auto-download settings have been reset.');
    }
</script>
