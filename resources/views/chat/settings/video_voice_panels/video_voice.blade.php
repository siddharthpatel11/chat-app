<div id="video_voice_settings_panel"
    class="hidden flex-col w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="toggleVideoVoiceSettings()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Video & voice</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] py-4">
        <div class="px-6 mb-6 mt-2">
            <div class="text-[#8696a0] text-[15px] mb-2.5">Camera</div>
            <div class="relative mb-6">
                <div class="bg-transparent border border-[#313d45] rounded-xl p-3 flex items-center justify-between cursor-pointer hover:bg-[#2a3942] transition-colors">
                    <div class="flex items-center gap-4 overflow-hidden">
                        <svg class="text-[#8696a0] shrink-0" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="6" width="20" height="12" rx="2" ry="2"></rect>
                            <circle cx="12" cy="12" r="3"></circle>
                            <line x1="6" y1="6" x2="6" y2="4"></line>
                            <line x1="18" y1="6" x2="18" y2="4"></line>
                            <line x1="12" y1="6" x2="12" y2="4"></line>
                        </svg>
                        <span class="text-[#e9edef] text-[15px] truncate font-semibold tracking-wide">HP TrueVision HD Camera (0408:5365)</span>
                    </div>
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor" class="text-[#8696a0] shrink-0 ml-2">
                        <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"></path>
                    </svg>
                </div>
            </div>

            <div class="text-[#8696a0] text-[15px] mb-2.5">Microphone</div>
            <div class="relative mb-6">
                <div class="bg-transparent border border-[#313d45] rounded-xl p-3 flex items-center justify-between cursor-pointer hover:bg-[#2a3942] transition-colors">
                    <div class="flex items-center gap-4 overflow-hidden">
                        <svg class="text-[#8696a0] shrink-0" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path>
                            <path d="M19 10v2a7 7 0 0 1-14 0v-2"></path>
                            <line x1="12" y1="19" x2="12" y2="23"></line>
                            <line x1="8" y1="23" x2="16" y2="23"></line>
                        </svg>
                        <span class="text-[#e9edef] text-[15px] truncate font-semibold tracking-wide">Default - Microphone Array (Intel® Smart Sound Technol...</span>
                    </div>
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor" class="text-[#8696a0] shrink-0 ml-2">
                        <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"></path>
                    </svg>
                </div>
            </div>

            <div class="text-[#8696a0] text-[15px] mb-2.5">Speakers</div>
            <div class="relative mb-6">
                <div class="bg-transparent border border-[#313d45] rounded-xl p-3 flex items-center justify-between cursor-pointer hover:bg-[#2a3942] transition-colors">
                    <div class="flex items-center gap-4 overflow-hidden">
                        <svg class="text-[#8696a0] shrink-0" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                            <path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path>
                        </svg>
                        <span class="text-[#e9edef] text-[15px] truncate font-semibold tracking-wide">Default - Speaker (Realtek(R) Audio)</span>
                    </div>
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor" class="text-[#8696a0] shrink-0 ml-2">
                        <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.toggleVideoVoiceSettings = function() {
        const videoVoicePanel = document.getElementById('video_voice_settings_panel');
        const settingsPanel = document.getElementById('settings_panel');

        if (videoVoicePanel.classList.contains('hidden')) {
            videoVoicePanel.classList.remove('hidden');
            videoVoicePanel.classList.add('flex');
            if (settingsPanel) settingsPanel.classList.add('hidden');
        } else {
            videoVoicePanel.classList.add('hidden');
            videoVoicePanel.classList.remove('flex');
            if (settingsPanel) settingsPanel.classList.remove('hidden');
        }
    }
</script>
