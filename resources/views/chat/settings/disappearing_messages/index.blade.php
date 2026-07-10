<!-- Disappearing Messages Sidebar -->
<div id="disappearing_messages_sidebar"
    class="fixed top-0 right-0 h-screen w-[400px] bg-[#111b21] border-l border-[#313d45] z-[550] flex flex-col shadow-2xl transition-transform duration-300 translate-x-full">
    <!-- Header -->
    <div class="h-[60px] bg-[#202c33] flex items-center px-4 gap-6 shrink-0 cursor-pointer hover:bg-[#2a3942] transition-colors"
        onclick="closeDisappearingMessagesSidebar()">
        <button class="text-[#aebac1] hover:text-[#e9edef] transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
            </svg>
        </button>
        <span class="text-[#e9edef] text-[16px] font-medium">Disappearing messages</span>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar">
        <div class="p-6 flex flex-col">
            <!-- Icon -->
            <div class="flex justify-center mb-6">
                <svg width="120" height="120" viewBox="0 0 120 120" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <circle cx="60" cy="60" r="40" fill="#00a884" />
                    <path d="M60 30V60L80 80" stroke="#111b21" stroke-width="6" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <circle cx="20" cy="40" r="10" fill="#dcf8c6" />
                    <circle cx="30" cy="80" r="15" fill="#dcf8c6" />
                    <circle cx="90" cy="30" r="20" fill="#f0f2f5" />
                </svg>
            </div>

            <div class="text-[#e9edef] text-[16px] font-medium mb-2">Make messages in this chat disappear</div>
            <div class="text-[#8696a0] text-[14px] leading-relaxed mb-6">
                For more privacy and storage, all new messages will disappear from this chat for everyone after the
                selected duration, except when kept. Group admins control who can change this setting. <a href="#"
                    class="text-[#00a884] hover:underline">Learn more</a>
            </div>

            <!-- Radio Options -->
            <div class="space-y-4">
                <label class="flex items-center gap-4 cursor-pointer group">
                    <input type="radio" name="sidebar_disappearing_duration" value="2 minutes" class="hidden peer"
                        onchange="saveSidebarDisappearingTimer(120)">
                    <div
                        class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] flex items-center justify-center transition-colors relative before:content-[''] before:w-2.5 before:h-2.5 before:bg-[#00a884] before:rounded-full before:opacity-0 peer-checked:before:opacity-100 before:transition-opacity">
                    </div>
                    <span class="text-[#e9edef] text-[16px]">2 minutes (Testing)</span>
                </label>

                <label class="flex items-center gap-4 cursor-pointer group">
                    <input type="radio" name="sidebar_disappearing_duration" value="24 hours" class="hidden peer"
                        onchange="saveSidebarDisappearingTimer(86400)">
                    <div
                        class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] flex items-center justify-center transition-colors relative before:content-[''] before:w-2.5 before:h-2.5 before:bg-[#00a884] before:rounded-full before:opacity-0 peer-checked:before:opacity-100 before:transition-opacity">
                    </div>
                    <span class="text-[#e9edef] text-[16px]">24 hours</span>
                </label>

                <label class="flex items-center gap-4 cursor-pointer group">
                    <input type="radio" name="sidebar_disappearing_duration" value="7 days" class="hidden peer"
                        onchange="saveSidebarDisappearingTimer(604800)">
                    <div
                        class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] flex items-center justify-center transition-colors relative before:content-[''] before:w-2.5 before:h-2.5 before:bg-[#00a884] before:rounded-full before:opacity-0 peer-checked:before:opacity-100 before:transition-opacity">
                    </div>
                    <span class="text-[#e9edef] text-[16px]">7 days</span>
                </label>

                <label class="flex items-center gap-4 cursor-pointer group">
                    <input type="radio" name="sidebar_disappearing_duration" value="90 days" class="hidden peer"
                        onchange="saveSidebarDisappearingTimer(7776000)">
                    <div
                        class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] flex items-center justify-center transition-colors relative before:content-[''] before:w-2.5 before:h-2.5 before:bg-[#00a884] before:rounded-full before:opacity-0 peer-checked:before:opacity-100 before:transition-opacity">
                    </div>
                    <span class="text-[#e9edef] text-[16px]">90 days</span>
                </label>

                <label class="flex items-center gap-4 cursor-pointer group">
                    <input type="radio" name="sidebar_disappearing_duration" value="Off" class="hidden peer"
                        onchange="saveSidebarDisappearingTimer(0)">
                    <div
                        class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] flex items-center justify-center transition-colors relative before:content-[''] before:w-2.5 before:h-2.5 before:bg-[#00a884] before:rounded-full before:opacity-0 peer-checked:before:opacity-100 before:transition-opacity">
                    </div>
                    <span class="text-[#e9edef] text-[16px]">Off</span>
                </label>
            </div>

            <div class="text-[#8696a0] text-[14px] mt-6">
                Update your <a href="#" class="text-[#00a884] hover:underline"
                    onclick="window.closeDisappearingMessagesSidebar(); window.closeContactInfo(); togglePrivacySettings();">default
                    message timer</a> in Settings
            </div>
        </div>
    </div>
</div>

<script>
    window.openDisappearingMessagesSidebar = function() {
        if (!window.currentChatId) return;

        // Close other info panels first
        if (typeof window.closeContactInfo === 'function') {
            window.closeContactInfo();
        }
        if (typeof window.closeGroupInfoPanel === 'function') {
            window.closeGroupInfoPanel();
        }
        if (typeof window.closeBroadcastInfo === 'function') {
            window.closeBroadcastInfo();
        }

        // Fetch current state from JS state
        let duration = 0;
        if (window.currentChatId.startsWith('group_')) {
            duration = window.currentGroupData?.disappearingTimer || 0;
        } else {
            duration = window.chatDisappearingTimers?.[window.currentChatId] || 0;
        }

        let current = 'Off';
        if (duration === 120) current = '2 minutes';
        else if (duration === 86400) current = '24 hours';
        else if (duration === 604800) current = '7 days';
        else if (duration === 7776000) current = '90 days';

        document.querySelectorAll('input[name="sidebar_disappearing_duration"]').forEach(radio => {
            radio.checked = (radio.value === current);
        });

        const sidebar = document.getElementById('disappearing_messages_sidebar');
        if (sidebar) {
            sidebar.classList.remove('translate-x-full');
            sidebar.classList.add('translate-x-0');
        }

        // Adjust main chat width on desktop
        const mainChat = document.getElementById('main_chat_column');
        if (window.innerWidth >= 640 && mainChat) {
            mainChat.classList.add('sm:mr-[400px]');
        }
    }

    window.closeDisappearingMessagesSidebar = function() {
        const sidebar = document.getElementById('disappearing_messages_sidebar');
        if (sidebar) {
            sidebar.classList.add('translate-x-full');
            sidebar.classList.remove('translate-x-0');
        }

        // Check if contact info panel or broadcast info panel is open.
        // If not, remove width adjustment on desktop.
        const contactPanel = document.getElementById('contact_info_panel');
        const broadcastPanel = document.getElementById('broadcast_info_panel');
        
        const isContactInfoOpen = contactPanel && !contactPanel.classList.contains('translate-x-full');
        const isBroadcastInfoOpen = broadcastPanel && !broadcastPanel.classList.contains('translate-x-full');

        if (!isContactInfoOpen && !isBroadcastInfoOpen) {
            const mainChat = document.getElementById('main_chat_column');
            if (window.innerWidth >= 640 && mainChat) {
                mainChat.classList.remove('sm:mr-[400px]');
            }
        }
    }

    window.saveSidebarDisappearingTimer = function(duration) {
        if (!window.currentChatId) return;

        // Update label in contact info or group info
        let val = 'Off';
        if (duration === 120) val = '2 minutes';
        else if (duration === 86400) val = '24 hours';
        else if (duration === 604800) val = '7 days';
        else if (duration === 7776000) val = '90 days';

        if (window.currentChatId.startsWith('group_')) {
            if (window.currentGroupData) window.currentGroupData.disappearingTimer = duration;
            const groupLabel = document.getElementById('group_disappearing_timer_label');
            if (groupLabel) groupLabel.innerText = val;
        } else {
            window.chatDisappearingTimers = window.chatDisappearingTimers || {};
            window.chatDisappearingTimers[window.currentChatId] = duration;
            const contactLabel = document.getElementById('contact_disappearing_timer_label');
            if (contactLabel) contactLabel.innerText = val;
        }

        fetch('/chat/settings/disappearing-message-timer', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                chat_id: window.currentChatId,
                duration: duration
            })
        }).then(res => {
            if (!res.ok) throw new Error('API Error');
            if (window.showToast) window.showToast('Updated', 'Disappearing messages timer updated.');
            setTimeout(() => {
                closeDisappearingMessagesSidebar();
            }, 300);
        }).catch(err => console.error('Failed to update timer', err));
    }
</script>
