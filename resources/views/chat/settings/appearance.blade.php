<div id="appearance_settings_panel"
    class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="toggleAppearanceSettings()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Appearance</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] py-4">
        <div class="px-6 mb-6">
            <!-- Default chat theme -->
            <div class="flex items-center justify-between cursor-pointer hover:bg-[#202c33] -mx-6 px-6 py-4 transition-colors" onclick="toggleChatThemePanel('appearance')">
                <div class="flex items-center gap-4">
                    <div class="text-[#8696a0]">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="3" y1="9" x2="21" y2="9"></line>
                        </svg>
                    </div>
                    <div class="text-[#e9edef] text-[16px]">Default chat theme</div>
                </div>
                <div class="w-5 h-8 bg-[#202c33] rounded-[4px] border border-[#313d45] overflow-hidden flex flex-col">
                    <div id="appearance_theme_header" class="h-2 bg-[#00a884] w-full transition-colors duration-300"></div>
                    <div class="flex-1 p-[2px] flex flex-col gap-[2px]">
                        <div class="w-3 h-1 bg-[#313d45] rounded-full self-end"></div>
                        <div class="w-3 h-1 bg-[#202c33] border border-[#313d45] rounded-full self-start"></div>
                    </div>
                </div>
            </div>

            <!-- WhatsApp Plus Header -->
            <div class="flex items-center gap-2 mt-6 mb-4">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="#8696a0">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                </svg>
                <span class="text-[#8696a0] text-[14px] font-medium">WhatsApp Plus</span>
            </div>

            <!-- App icon -->
            <div class="flex items-center justify-between cursor-pointer hover:bg-[#202c33] -mx-6 px-6 py-4 transition-colors" onclick="window.showToast('App icon', 'Subscribe to WhatsApp Plus to change app icon')">
                <div class="flex items-center gap-4">
                    <div class="text-[#8696a0]">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="3" width="18" height="18" rx="4" ry="4"></rect>
                            <circle cx="12" cy="12" r="3"></circle>
                            <circle cx="8" cy="8" r="1"></circle>
                            <circle cx="16" cy="8" r="1"></circle>
                            <circle cx="8" cy="16" r="1"></circle>
                            <circle cx="16" cy="16" r="1"></circle>
                        </svg>
                    </div>
                    <div class="text-[#e9edef] text-[16px]">App icon</div>
                </div>
                <div class="w-6 h-6 bg-[#25D366] rounded-full flex items-center justify-center">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="white">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"></path>
                    </svg>
                </div>
            </div>

            <!-- App theme -->
            <div class="flex items-center justify-between cursor-pointer hover:bg-[#202c33] -mx-6 px-6 py-4 transition-colors mb-2" onclick="window.showToast('App theme', 'Subscribe to WhatsApp Plus to change app theme')">
                <div class="flex items-center gap-4">
                    <div class="text-[#8696a0]">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20z"></path>
                            <path d="M12 2a10 10 0 0 1 0 20v-20z" fill="currentColor"></path>
                        </svg>
                    </div>
                    <div class="text-[#e9edef] text-[16px]">App theme</div>
                </div>
                <div class="w-6 h-6 bg-[#1a4a38] rounded-full border border-transparent"></div>
            </div>

            <!-- Help text -->
            <div class="text-[#8696a0] text-[14px] mt-4">
                Subscribe to WhatsApp Plus to change your app icon, theme and more. <a href="#" class="text-[#00a884] hover:underline" onclick="window.showToast('WhatsApp Plus', 'Opening explore benefits...')">Explore benefits</a>
            </div>
        </div>
    </div>
</div>

<script>
    window.toggleAppearanceSettings = function() {
        const appearancePanel = document.getElementById('appearance_settings_panel');
        const settingsPanel = document.getElementById('settings_panel');

        if (appearancePanel.classList.contains('hidden')) {
            appearancePanel.classList.remove('hidden');
            appearancePanel.classList.add('flex');
            if (settingsPanel) settingsPanel.classList.add('hidden');
        } else {
            appearancePanel.classList.add('hidden');
            appearancePanel.classList.remove('flex');
            if (settingsPanel) { settingsPanel.classList.remove('hidden'); settingsPanel.classList.add('flex'); }
        }
    }
</script>
