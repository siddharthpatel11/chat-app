<div id="chats_settings_panel"
    class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="toggleChatSettings()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Chats</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] py-4">
        
        <!-- Display Section -->
        <div class="px-6 mb-2 mt-2">
            <h3 class="text-[#8696a0] text-[14px] font-medium mb-3">Display</h3>
        </div>

        <!-- Theme -->
        <div class="flex items-center justify-between py-4 hover:bg-[#202c33] px-6 transition-colors group cursor-pointer" onclick="openChatThemeModal()">
            <div class="flex-1 pr-4">
                <div class="text-[#e9edef] text-[16px] mb-1">Theme</div>
                <div id="chat_theme_label" class="text-[#8696a0] text-[14px]">System default</div>
            </div>
            <div class="text-[#8696a0] group-hover:text-[#e9edef] transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"></path>
                </svg>
            </div>
        </div>

        <!-- Wallpaper -->
        <div class="flex items-center justify-between py-4 hover:bg-[#202c33] px-6 transition-colors group cursor-pointer" onclick="toggleChatWallpaperPanel()">
            <div class="flex-1 pr-4">
                <div class="text-[#e9edef] text-[16px]">Wallpaper</div>
            </div>
            <div class="text-[#8696a0] group-hover:text-[#e9edef] transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"></path>
                </svg>
            </div>
        </div>

        <!-- Chat settings Section -->
        <div class="px-6 mb-2 mt-6">
            <h3 class="text-[#8696a0] text-[14px] font-medium mb-3">Chat settings</h3>
        </div>

        <!-- Media upload quality -->
        <div class="flex items-center justify-between py-4 hover:bg-[#202c33] px-6 transition-colors group cursor-pointer" onclick="openUploadQualityModal()">
            <div class="flex-1 pr-4">
                <div class="text-[#e9edef] text-[16px]">Media upload quality</div>
            </div>
            <div class="text-[#8696a0] group-hover:text-[#e9edef] transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"></path>
                </svg>
            </div>
        </div>

        <!-- Media auto-download -->
        <div class="flex items-center justify-between py-4 hover:bg-[#202c33] px-6 transition-colors group cursor-pointer" onclick="toggleAutoDownloadPanel()">
            <div class="flex-1 pr-4">
                <div class="text-[#e9edef] text-[16px]">Media auto-download</div>
            </div>
            <div class="text-[#8696a0] group-hover:text-[#e9edef] transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"></path>
                </svg>
            </div>
        </div>

        <!-- Spell check -->
        <div class="flex items-center justify-between py-4 hover:bg-[#202c33] px-6 transition-colors">
            <div class="flex-1 pr-4">
                <div class="text-[#e9edef] text-[16px] mb-1">Spell check</div>
                <div class="text-[#8696a0] text-[14px]">Check spelling while typing</div>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="chat_spell_check_toggle" onchange="toggleChatSetting('chat_spell_check', this.checked, 'Spell check')" class="sr-only peer" checked>
                <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
            </label>
        </div>

        <!-- Replace text with emoji -->
        <div class="flex items-center justify-between py-4 hover:bg-[#202c33] px-6 transition-colors">
            <div class="flex-1 pr-4">
                <div class="text-[#e9edef] text-[16px] mb-1">Replace text with emoji</div>
                <div class="text-[#8696a0] text-[14px]">Emoji will replace specific text as you type</div>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="chat_replace_emoji_toggle" onchange="toggleChatSetting('chat_replace_emoji', this.checked, 'Replace text with emoji')" class="sr-only peer" checked>
                <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
            </label>
        </div>

        <!-- Enter is send -->
        <div class="flex items-center justify-between py-4 hover:bg-[#202c33] px-6 transition-colors mb-10">
            <div class="flex-1 pr-4">
                <div class="text-[#e9edef] text-[16px] mb-1">Enter is send</div>
                <div class="text-[#8696a0] text-[14px]">Enter key will send your message</div>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="chat_enter_send_toggle" onchange="toggleChatSetting('chat_enter_send', this.checked, 'Enter is send')" class="sr-only peer" checked>
                <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
            </label>
        </div>

    </div>
</div>

<script>
    window.toggleChatSettings = function() {
        const chatPanel = document.getElementById('chats_settings_panel');
        const settingsPanel = document.getElementById('settings_panel');

        if (chatPanel.classList.contains('hidden')) {
            chatPanel.classList.remove('hidden');
            chatPanel.classList.add('flex');
            if (settingsPanel) settingsPanel.classList.add('hidden');
            initChatSettings();
        } else {
            chatPanel.classList.add('hidden');
            chatPanel.classList.remove('flex');
            if (settingsPanel) settingsPanel.classList.remove('hidden');
        }
    }

    function initChatSettings() {
        // Theme
        const savedTheme = localStorage.getItem('whatsapp_chat_theme') || 'System default';
        const themeLabel = document.getElementById('chat_theme_label');
        if (themeLabel) themeLabel.innerText = savedTheme;
        
        // Toggles
        const spellCheck = localStorage.getItem('whatsapp_chat_spell_check') !== 'false';
        const replaceEmoji = localStorage.getItem('whatsapp_chat_replace_emoji') !== 'false';
        const enterSend = localStorage.getItem('whatsapp_chat_enter_send') !== 'false';
        
        const scToggle = document.getElementById('chat_spell_check_toggle');
        const reToggle = document.getElementById('chat_replace_emoji_toggle');
        const esToggle = document.getElementById('chat_enter_send_toggle');
        
        if (scToggle) scToggle.checked = spellCheck;
        if (reToggle) reToggle.checked = replaceEmoji;
        if (esToggle) esToggle.checked = enterSend;
    }

    window.toggleChatSetting = function(key, isEnabled, name) {
        localStorage.setItem('whatsapp_' + key, isEnabled);
        if (window.showToast) {
            window.showToast('Settings Updated', `${name} turned ${isEnabled ? 'on' : 'off'}.`);
        }
    }
</script>
