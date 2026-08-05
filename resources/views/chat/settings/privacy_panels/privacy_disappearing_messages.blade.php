<!-- Disappearing Messages Hub Sidebar -->
<div id="privacy_disappearing_messages_sidebar" class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden relative z-[45]">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="window.closePrivacyDisappearingMessages()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M20 11H7.8l5.6-5.6L12 4l-8 8 8 8 1.4-1.4L7.8 13H20v-2z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Disappearing messages</h2>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21]">
        <div class="p-6 flex flex-col items-center border-b border-[#202c33]">
            <!-- Illustration (matching screenshot 1) -->
            <div class="flex justify-center mb-6 relative mt-4">
                <svg width="140" height="100" viewBox="0 0 140 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Base shapes -->
                    <circle cx="45" cy="55" r="18" fill="#dcf8c6" opacity="0.9"/>
                    <circle cx="35" cy="40" r="5" fill="#dcf8c6" opacity="0.8"/>
                    <circle cx="58" cy="70" r="10" fill="#dcf8c6" opacity="0.9"/>
                    
                    <path d="M70 25 h30 a10 10 0 0 1 10 10 v20 a10 10 0 0 1 -10 10 h-30 z" fill="#f0f2f5"/>
                    <circle cx="75" cy="45" r="32" fill="#00a884" stroke="#111b21" stroke-width="3"/>
                    <circle cx="75" cy="45" r="24" stroke="#111b21" stroke-width="2" stroke-dasharray="4 6"/>
                    <path d="M75 45 L85 35" stroke="#111b21" stroke-width="3" stroke-linecap="round"/>
                    <path d="M75 45 L68 52" stroke="#111b21" stroke-width="3" stroke-linecap="round"/>
                </svg>
            </div>

            <div class="text-[#8696a0] text-[14px] text-center leading-relaxed">
                Set messages to automatically disappear. Chat members will see you turned this on. <a href="#" class="text-[#00a884] hover:underline">Learn more</a>
            </div>
        </div>

        <div class="p-6 pt-5">
            <div class="text-[#8696a0] text-[14px] font-medium mb-3">Set for your account</div>

            <!-- Default message timer -->
            <div class="flex items-center gap-5 py-4 cursor-pointer hover:bg-[#202c33] -mx-6 px-6 transition-colors group" onclick="window.openDefaultTimerSidebar()">
                <div class="text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="text-[#e9edef] text-[16px] mb-1">Default message timer</div>
                    <div class="text-[#8696a0] text-[14px] leading-snug">New chats will begin with a disappearing message timer</div>
                </div>
            </div>

            <div class="text-[#8696a0] text-[14px] font-medium mt-6 mb-3">Set for your current chats</div>

            <!-- Apply timer to chats -->
            <div class="flex items-center gap-5 py-4 cursor-pointer hover:bg-[#202c33] -mx-6 px-6 transition-colors group" onclick="window.openApplyTimerToChats()">
                <div class="text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                        <line x1="8" y1="14" x2="16" y2="14"></line>
                        <line x1="8" y1="18" x2="16" y2="18"></line>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="text-[#e9edef] text-[16px] mb-1">Apply timer to chats</div>
                    <div class="text-[#8696a0] text-[14px]" id="privacy_apply_timer_stats">0 chats using disappearing messages</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.openPrivacyDisappearingMessages = function() {
        const privacyPanel = document.getElementById('privacy_settings_panel');
        const hub = document.getElementById('privacy_disappearing_messages_sidebar');
        
        if (privacyPanel) {
            privacyPanel.classList.add('hidden');
            privacyPanel.classList.remove('flex');
        }
        if (hub) {
            hub.classList.remove('hidden');
            hub.classList.add('flex');
        }
        
        // Count active disappearing chats
        if (window.db && window.myUserId) {
            let count = 0;
            // Scan chats
            window.get(window.ref(window.db, 'chats')).then(snap => {
                if(snap.exists()) {
                    snap.forEach(child => {
                        if(child.key.includes(window.myUserId)) {
                            const chat = child.val();
                            if(chat.disappearingTimer && chat.disappearingTimer > 0) count++;
                        }
                    });
                }
                
                // Scan groups
                window.get(window.ref(window.db, 'groups')).then(grpSnap => {
                    if(grpSnap.exists()) {
                        grpSnap.forEach(gChild => {
                            const grp = gChild.val();
                            if(grp.users && (grp.users.includes(Number(window.myUserId)) || grp.users.includes(String(window.myUserId)))) {
                                if(grp.disappearingTimer && grp.disappearingTimer > 0) count++;
                            }
                        });
                    }
                    
                    const statsLabel = document.getElementById('privacy_apply_timer_stats');
                    if (statsLabel) {
                        statsLabel.innerText = `${count} chats using disappearing messages`;
                    }
                });
            });
        }
    }

    window.closePrivacyDisappearingMessages = function() {
        const privacyPanel = document.getElementById('privacy_settings_panel');
        const storagePanel = document.getElementById('manage_storage_panel');
        const hub = document.getElementById('privacy_disappearing_messages_sidebar');
        
        if (hub) {
            hub.classList.add('hidden');
            hub.classList.remove('flex');
        }
        
        if (window._disappearingMessagesReturnTo === 'storage') {
            if (storagePanel) {
                storagePanel.classList.remove('hidden');
                storagePanel.classList.add('flex');
            }
            window._disappearingMessagesReturnTo = null; // Reset
        } else {
            if (privacyPanel) {
                privacyPanel.classList.remove('hidden');
                privacyPanel.classList.add('flex');
            }
        }
    }
</script>
