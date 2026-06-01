<div id="privacy_last_seen_panel"
    class="hidden flex-col w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="togglePrivacyLastSeen()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M20 11H7.8l5.6-5.6L12 4l-8 8 8 8 1.4-1.4L7.8 13H20v-2z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Last seen and online</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] py-4">
        <div class="px-6 pb-6">
            <div class="text-[#8696a0] text-[14px] font-medium mb-4 mt-2">Who can see my last seen</div>

            <div class="flex flex-col gap-6 mb-6">
                <label class="flex items-center cursor-pointer group">
                    <div class="relative flex items-center justify-center w-5 h-5 mr-4">
                        <input type="radio" name="privacy_last_seen_radio" value="Everyone" class="peer sr-only" checked onchange="updatePrivacyLastSeen()">
                        <div class="w-5 h-5 border-[2px] border-[#8696a0] rounded-full peer-checked:border-[#00a884] transition-colors"></div>
                        <div class="absolute w-2.5 h-2.5 bg-[#00a884] rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <span class="text-[#e9edef] text-[16px]">Everyone</span>
                </label>
                
                <label class="flex items-center cursor-pointer group">
                    <div class="relative flex items-center justify-center w-5 h-5 mr-4">
                        <input type="radio" name="privacy_last_seen_radio" value="My contacts" class="peer sr-only" onchange="updatePrivacyLastSeen()">
                        <div class="w-5 h-5 border-[2px] border-[#8696a0] rounded-full peer-checked:border-[#00a884] transition-colors"></div>
                        <div class="absolute w-2.5 h-2.5 bg-[#00a884] rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <span class="text-[#e9edef] text-[16px]">My contacts</span>
                </label>
                
                <label class="flex items-center cursor-pointer group">
                    <div class="relative flex items-center justify-center w-5 h-5 mr-4">
                        <input type="radio" name="privacy_last_seen_radio" value="My contacts except..." class="peer sr-only" onchange="updatePrivacyLastSeen()">
                        <div class="w-5 h-5 border-[2px] border-[#8696a0] rounded-full peer-checked:border-[#00a884] transition-colors"></div>
                        <div class="absolute w-2.5 h-2.5 bg-[#00a884] rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <span class="text-[#e9edef] text-[16px]">My contacts except...</span>
                </label>

                <label class="flex items-center cursor-pointer group">
                    <div class="relative flex items-center justify-center w-5 h-5 mr-4">
                        <input type="radio" name="privacy_last_seen_radio" value="Nobody" class="peer sr-only" onchange="updatePrivacyLastSeen()">
                        <div class="w-5 h-5 border-[2px] border-[#8696a0] rounded-full peer-checked:border-[#00a884] transition-colors"></div>
                        <div class="absolute w-2.5 h-2.5 bg-[#00a884] rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <span class="text-[#e9edef] text-[16px]">Nobody</span>
                </label>
            </div>

            <div class="border-t border-[#313d45] pt-6 mb-6">
                <div class="text-[#8696a0] text-[14px] font-medium mb-4">Who can see when I'm online</div>

                <div class="flex flex-col gap-6">
                    <label class="flex items-center cursor-pointer group">
                        <div class="relative flex items-center justify-center w-5 h-5 mr-4">
                            <input type="radio" name="privacy_online_radio" value="Everyone" class="peer sr-only" checked onchange="updatePrivacyLastSeen()">
                            <div class="w-5 h-5 border-[2px] border-[#8696a0] rounded-full peer-checked:border-[#00a884] transition-colors"></div>
                            <div class="absolute w-2.5 h-2.5 bg-[#00a884] rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                        </div>
                        <span class="text-[#e9edef] text-[16px]">Everyone</span>
                    </label>
                    
                    <label class="flex items-center cursor-pointer group">
                        <div class="relative flex items-center justify-center w-5 h-5 mr-4">
                            <input type="radio" name="privacy_online_radio" value="Same as last seen" class="peer sr-only" onchange="updatePrivacyLastSeen()">
                            <div class="w-5 h-5 border-[2px] border-[#8696a0] rounded-full peer-checked:border-[#00a884] transition-colors"></div>
                            <div class="absolute w-2.5 h-2.5 bg-[#00a884] rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                        </div>
                        <span class="text-[#e9edef] text-[16px]">Same as last seen</span>
                    </label>
                </div>
            </div>

            <div class="text-[#8696a0] text-[14px] leading-relaxed">
                If you don't share when you were <strong>last seen</strong> or <strong>online</strong>, you won't be able to see when other people were last seen or online.
            </div>
        </div>
    </div>
</div>

<script>
    window.togglePrivacyLastSeen = function() {
        const lastSeenPanel = document.getElementById('privacy_last_seen_panel');
        const privacyPanel = document.getElementById('privacy_settings_panel');

        if (lastSeenPanel.classList.contains('hidden')) {
            lastSeenPanel.classList.remove('hidden');
            lastSeenPanel.classList.add('flex');
            if (privacyPanel) privacyPanel.classList.add('hidden');
            
            // Init state
            const savedLastSeen = localStorage.getItem('whatsapp_privacy_last_seen_val') || 'Nobody';
            const savedOnline = localStorage.getItem('whatsapp_privacy_online_val') || 'Everyone';
            
            let valToCheckLastSeen = savedLastSeen;
            if (savedLastSeen.includes('excluded')) {
                valToCheckLastSeen = 'My contacts except...';
            }
            
            document.querySelectorAll('input[name="privacy_last_seen_radio"]').forEach(r => {
                if(r.value === valToCheckLastSeen) r.checked = true;
            });
            document.querySelectorAll('input[name="privacy_online_radio"]').forEach(r => {
                if(r.value === savedOnline) r.checked = true;
            });
            
        } else {
            lastSeenPanel.classList.add('hidden');
            lastSeenPanel.classList.remove('flex');
            if (privacyPanel) privacyPanel.classList.remove('hidden');
        }
    }

    window.updatePrivacyLastSeen = function() {
        let lastSeen = document.querySelector('input[name="privacy_last_seen_radio"]:checked')?.value || 'Nobody';
        const online = document.querySelector('input[name="privacy_online_radio"]:checked')?.value || 'Everyone';
        
        if (lastSeen === 'My contacts except...') {
            if (window.openPrivacyExcludePanel) window.openPrivacyExcludePanel('last_seen');
            const savedData = localStorage.getItem('whatsapp_privacy_exclude_last_seen');
            let count = 0;
            if (savedData) { try { count = JSON.parse(savedData).length; } catch(e){} }
            lastSeen = `${count} contact${count !== 1 ? 's' : ''} excluded`;
        }
        
        localStorage.setItem('whatsapp_privacy_last_seen_val', lastSeen);
        localStorage.setItem('whatsapp_privacy_online_val', online);
        
        const combined = lastSeen + ', ' + online;
        localStorage.setItem('whatsapp_privacy_last_seen', combined);
        
        const labelEl = document.getElementById('privacy_last_seen_label');
        if (labelEl) labelEl.innerText = combined;
        
        if(window.showToast && !lastSeen.includes('excluded')) window.showToast('Privacy Updated', 'Setting saved.');
    }
</script>
