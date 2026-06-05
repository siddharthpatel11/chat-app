<div id="general_settings_panel"
    class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="toggleGeneralSettings()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">General</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] py-4">
        <div class="px-6 mb-6">
            <h3 class="text-[#00a884] text-[14px] font-medium mb-3 mt-2">LOGIN</h3>

            <div class="flex items-center justify-between mb-4">
                <div class="text-[#e9edef] text-[16px]">Start WhatsApp at login</div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" onchange="toggleGeneralSetting('Start at login', this.checked)" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
                </label>
            </div>

            <div class="text-[#8696a0] text-[14px] mb-8">Automatically start WhatsApp when you log in to your computer</div>

            <h3 class="text-[#00a884] text-[14px] font-medium mb-3">LANGUAGE</h3>

            <div class="flex items-center justify-between cursor-pointer hover:bg-[#202c33] -mx-6 px-6 py-3 transition-colors" onclick="window.showToast('Language', 'Language settings are managed by your OS')">
                <div class="text-[#e9edef] text-[16px]">App language</div>
                <div class="flex items-center text-[#8696a0]">
                    System default
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </div>

            <div class="text-[#8696a0] text-[14px] mt-2 mb-8 border-b border-[#313d45] pb-8">Change the language of the application</div>

            <h3 class="text-[#00a884] text-[14px] font-medium mb-3">TYPING INDICATOR</h3>

            <div class="flex items-center justify-between">
                <div class="text-[#e9edef] text-[16px]">Show typing indicator</div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" onchange="toggleGeneralSetting('Typing indicator', this.checked)" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
                </label>
            </div>

            <div class="text-[#8696a0] text-[14px] mt-2">Let others know when you're typing a message</div>
        </div>
    </div>
</div>

<script>
    window.toggleGeneralSettings = function() {
        const generalPanel = document.getElementById('general_settings_panel');
        const settingsPanel = document.getElementById('settings_panel');

        if (generalPanel.classList.contains('hidden')) {
            generalPanel.classList.remove('hidden');
            generalPanel.classList.add('flex');
            if (settingsPanel) settingsPanel.classList.add('hidden');
        } else {
            generalPanel.classList.add('hidden');
            generalPanel.classList.remove('flex');
            if (settingsPanel) settingsPanel.classList.remove('hidden');
        }
    }

    window.toggleGeneralSetting = function(name, isEnabled) {
        if (window.showToast) {
            window.showToast('Settings Updated', `${name} turned ${isEnabled ? 'on' : 'off'}.`);
        }
    }
</script>
