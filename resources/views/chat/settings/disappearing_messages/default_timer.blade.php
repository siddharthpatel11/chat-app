<!-- Default Message Timer Sidebar -->
<div id="default_timer_sidebar" class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-[60px] bg-[#202c33] flex items-center px-4 gap-6 shrink-0 cursor-pointer hover:bg-[#2a3942] transition-colors" onclick="closeDefaultTimerSidebar()">
        <button class="text-[#aebac1] hover:text-[#e9edef] transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
            </svg>
        </button>
        <span class="text-[#e9edef] text-[16px] font-medium">Default message timer</span>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar">
        <div class="p-6 flex flex-col">
            
            <div class="text-[#00a884] text-[14px] font-medium mb-6">Start new chats with disappearing messages</div>
            
            <!-- Radio Options -->
            <div class="space-y-6 mb-6">
                <label class="flex items-center gap-4 cursor-pointer group">
                    <input type="radio" name="default_disappearing_duration" value="2 minutes" class="hidden peer" onchange="saveDefaultTimer(120)">
                    <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] flex items-center justify-center transition-colors relative">
                        <div class="w-2.5 h-2.5 rounded-full bg-[#00a884] opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <span class="text-[#e9edef] text-[16px]">2 minutes (Testing)</span>
                </label>

                <label class="flex items-center gap-4 cursor-pointer group">
                    <input type="radio" name="default_disappearing_duration" value="24 hours" class="hidden peer" onchange="saveDefaultTimer(86400)">
                    <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] flex items-center justify-center transition-colors relative">
                        <div class="w-2.5 h-2.5 rounded-full bg-[#00a884] opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <span class="text-[#e9edef] text-[16px]">24 hours</span>
                </label>
                
                <label class="flex items-center gap-4 cursor-pointer group">
                    <input type="radio" name="default_disappearing_duration" value="7 days" class="hidden peer" onchange="saveDefaultTimer(604800)">
                    <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] flex items-center justify-center transition-colors relative">
                        <div class="w-2.5 h-2.5 rounded-full bg-[#00a884] opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <span class="text-[#e9edef] text-[16px]">7 days</span>
                </label>

                <label class="flex items-center gap-4 cursor-pointer group">
                    <input type="radio" name="default_disappearing_duration" value="90 days" class="hidden peer" onchange="saveDefaultTimer(7776000)">
                    <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] flex items-center justify-center transition-colors relative">
                        <div class="w-2.5 h-2.5 rounded-full bg-[#00a884] opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <span class="text-[#e9edef] text-[16px]">90 days</span>
                </label>

                <label class="flex items-center gap-4 cursor-pointer group">
                    <input type="radio" name="default_disappearing_duration" value="Off" class="hidden peer" onchange="saveDefaultTimer(0)">
                    <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] flex items-center justify-center transition-colors relative">
                        <div class="w-2.5 h-2.5 rounded-full bg-[#00a884] opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <span class="text-[#e9edef] text-[16px]">Off</span>
                </label>
            </div>

            <div class="text-[#8696a0] text-[14px] leading-relaxed">
                When turned on, all new individual chats will start with disappearing messages set to the duration you select. This setting will not affect your existing chats.
            </div>

            <a href="#" class="text-[#00a884] text-[14px] hover:underline mt-4">Learn more</a>
        </div>
    </div>
</div>

<script>
    window.openDefaultTimerSidebar = function() {
        const saved = localStorage.getItem('whatsapp_privacy_message_timer') || 'Off';
        document.querySelectorAll('input[name="default_disappearing_duration"]').forEach(radio => {
            radio.checked = (radio.value === saved);
        });

        const privacyPanel = document.getElementById('privacy_settings_panel');
        const sidebar = document.getElementById('default_timer_sidebar');
        
        if (privacyPanel) {
            privacyPanel.classList.add('hidden');
            privacyPanel.classList.remove('flex');
        }
        sidebar.classList.remove('hidden');
        sidebar.classList.add('flex');
    }

    window.closeDefaultTimerSidebar = function() {
        const privacyPanel = document.getElementById('privacy_settings_panel');
        const sidebar = document.getElementById('default_timer_sidebar');
        
        if (sidebar) {
            sidebar.classList.add('hidden');
            sidebar.classList.remove('flex');
        }
        if (privacyPanel) {
            privacyPanel.classList.remove('hidden');
            privacyPanel.classList.add('flex');
        }
    }

    window.saveDefaultTimer = function(duration) {
        let val = 'Off';
        if (duration === 120) val = '2 minutes';
        else if (duration === 86400) val = '24 hours';
        else if (duration === 604800) val = '7 days';
        else if (duration === 7776000) val = '90 days';
        
        localStorage.setItem('whatsapp_privacy_message_timer', val);
        const label = document.getElementById('privacy_message_timer_label');
        if (label) label.innerText = val;

        fetch('/chat/settings/default-message-timer', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ duration: duration })
        }).then(res => {
            if(!res.ok) throw new Error('API Error');
            if(window.showToast) window.showToast('Updated', 'Default message timer updated.');
        }).catch(err => console.error('Failed to save default timer', err));
    }
</script>
