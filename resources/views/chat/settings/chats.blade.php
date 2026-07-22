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

        <!-- Hide Chat -->
        <div class="flex items-center justify-between py-4 hover:bg-[#202c33] px-6 transition-colors group cursor-pointer" onclick="toggleHideChatPanel()">
            <div class="flex-1 pr-4">
                <div class="text-[#e9edef] text-[16px]">Hide Chat</div>
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
        <div class="flex items-center justify-between py-4 hover:bg-[#202c33] px-6 transition-colors">
            <div class="flex-1 pr-4">
                <div class="text-[#e9edef] text-[16px] mb-1">Enter is send</div>
                <div class="text-[#8696a0] text-[14px]">Enter key will send your message</div>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="chat_enter_send_toggle" onchange="toggleChatSetting('chat_enter_send', this.checked, 'Enter is send')" class="sr-only peer" checked>
                <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
            </label>
        </div>

        <div class="h-[1px] bg-[#202c33] my-2 mx-6"></div>

        <!-- Chat backup -->
        <div class="flex items-center py-4 hover:bg-[#202c33] px-6 transition-colors cursor-pointer group" onclick="toggleChatBackupPanel()">
            <div class="text-[#8696a0] mr-6">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM19 18H6c-2.21 0-4-1.79-4-4 0-2.05 1.53-3.76 3.56-3.97l1.07-.11.5-.95C11.66 7.18 12.78 6.5 14 6.5c2.11 0 3.86 1.63 3.99 3.73l.11 1.25 1.25.13c1.37.14 2.45 1.31 2.45 2.7 0 1.48-1.21 2.69-2.8 2.69zM10.88 12.88V16h2.24v-3.12h1.83L12 9.4l-2.95 3.48h1.83z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <div class="text-[#e9edef] text-[16px]">Chat backup</div>
            </div>
        </div>

        <!-- Transfer chats -->
        <div class="flex items-center py-4 hover:bg-[#202c33] px-6 transition-colors cursor-pointer group">
            <div class="text-[#8696a0] mr-6">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M16 1H8C6.9 1 6 1.9 6 3v18c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V3c0-1.1-.9-2-2-2zm0 19H8V4h8v16zm-3.5 1h-1v-1h1v1zM11 12H7V10h4V7l5 4-5 4v-3z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <div class="text-[#e9edef] text-[16px]">Transfer chats</div>
            </div>
        </div>

        <!-- Chat history -->
        <div class="flex items-center py-4 hover:bg-[#202c33] px-6 transition-colors cursor-pointer group">
            <div class="text-[#8696a0] mr-6">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M13 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42C8.27 19.99 10.51 21 13 21c4.97 0 9-4.03 9-9s-4.03-9-9-9zm-1 5v5l4.25 2.52.75-1.23-3.5-2.07V8h-1.5z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <div class="text-[#e9edef] text-[16px]">Chat history</div>
            </div>
        </div>

        <!-- Private Processing -->
        <div class="flex items-center py-4 hover:bg-[#202c33] px-6 transition-colors cursor-pointer group mb-10">
            <div class="text-[#8696a0] mr-6">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM8.9 6c0-1.71 1.39-3.1 3.1-3.1s3.1 1.39 3.1 3.1v2H8.9V6zM18 20H6V10h12v10zm-5-3h-2v-2H9v-2h2v-2h2v2h2v2h-2v2z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <div class="text-[#e9edef] text-[16px]">Private Processing</div>
            </div>
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
