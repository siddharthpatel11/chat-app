<div id="notifications_subpanel" class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="closeNotificationsSubpanel()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
            </svg>
        </button>
        <h2 id="notif_subpanel_title" class="text-[#e9edef] text-[19px] font-semibold">Messages</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] py-4">
        
        <!-- Standard Content (Messages, Groups, Status) -->
        <div id="notif_standard_content" class="hidden flex-col px-6 mt-2">
            <div class="flex items-center justify-between mb-8">
                <div class="text-[#e9edef] text-[15px]">Show notifications</div>
                <label class="relative inline-flex items-center cursor-pointer shrink-0 ml-4">
                    <input type="checkbox" onchange="window.showToast?.('Settings Updated', 'Notification visibility updated.')" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-[#111b21] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-[#8696a0] peer-checked:after:bg-[#111b21] after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
                </label>
            </div>

            <div class="flex items-center justify-between mb-8 border-b border-[#313d45] pb-8">
                <div class="text-[#e9edef] text-[15px]">Show reaction notifications</div>
                <label class="relative inline-flex items-center cursor-pointer shrink-0 ml-4">
                    <input type="checkbox" onchange="window.showToast?.('Settings Updated', 'Reaction notifications updated.')" class="sr-only peer">
                    <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-[#111b21] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-[#8696a0] peer-checked:after:bg-[#111b21] after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
                </label>
            </div>

            <div class="text-[#8696a0] text-[14px] mb-2.5">Notification tone</div>
            <div class="relative">
                <div id="notif_tone_trigger" onclick="document.getElementById('notif_tone_dropdown').classList.toggle('hidden')" class="bg-transparent border border-[#313d45] rounded-lg p-3 flex items-center justify-between cursor-pointer hover:bg-[#202c33] transition-colors">
                    <div class="flex items-center gap-4">
                        <svg class="text-[#8696a0]" viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                            <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"></path>
                        </svg>
                        <span class="text-[#e9edef] text-[15px] font-semibold tracking-wide" id="selected_tone_text">Default</span>
                    </div>
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0]">
                        <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"></path>
                    </svg>
                </div>
                <!-- Dropdown -->
                <div id="notif_tone_dropdown" class="hidden absolute top-full left-0 right-0 mt-1 bg-[#233138] rounded-xl shadow-xl border border-[#313d45] overflow-y-auto max-h-[300px] z-50 py-2 custom-scrollbar">
                    <button onclick="selectTone('Default')" class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-[#00a884] shrink-0" id="tone_indicator_Default"></div>
                        <span>Default</span>
                    </button>
                    <button onclick="selectTone('Alert 1')" class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-transparent shrink-0" id="tone_indicator_Alert_1"></div>
                        <span>Alert 1</span>
                    </button>
                    <button onclick="selectTone('Alert 2')" class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-transparent shrink-0" id="tone_indicator_Alert_2"></div>
                        <span>Alert 2</span>
                    </button>
                    <button onclick="selectTone('Alert 3')" class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-transparent shrink-0" id="tone_indicator_Alert_3"></div>
                        <span>Alert 3</span>
                    </button>
                    <button onclick="selectTone('Alert 4')" class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-transparent shrink-0" id="tone_indicator_Alert_4"></div>
                        <span>Alert 4</span>
                    </button>
                    <button onclick="selectTone('Alert 5')" class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-transparent shrink-0" id="tone_indicator_Alert_5"></div>
                        <span>Alert 5</span>
                    </button>
                    <button onclick="selectTone('Alert 6')" class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-transparent shrink-0" id="tone_indicator_Alert_6"></div>
                        <span>Alert 6</span>
                    </button>
                    <button onclick="selectTone('Alert 7')" class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-transparent shrink-0" id="tone_indicator_Alert_7"></div>
                        <span>Alert 7</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Calls Content -->
        <div id="notif_calls_content" class="hidden flex-col px-6 mt-2">
            <div class="flex items-center justify-between mb-8 border-b border-[#313d45] pb-8">
                <div class="text-[#e9edef] text-[15px]">Show notifications for incoming calls</div>
                <label class="relative inline-flex items-center cursor-pointer shrink-0 ml-4">
                    <input type="checkbox" onchange="window.showToast?.('Settings Updated', 'Incoming call notifications updated.')" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-[#111b21] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-[#8696a0] peer-checked:after:bg-[#111b21] after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
                </label>
            </div>

            <div class="flex items-center justify-between mb-8 border-b border-[#313d45] pb-8">
                <div class="text-[#e9edef] text-[15px]">Play sound for incoming calls</div>
                <label class="relative inline-flex items-center cursor-pointer shrink-0 ml-4">
                    <input type="checkbox" onchange="window.showToast?.('Settings Updated', 'Incoming call sound updated.')" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-[#111b21] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-[#8696a0] peer-checked:after:bg-[#111b21] after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
                </label>
            </div>
        </div>
    </div>
</div>

<script>
    window.openNotificationsSubpanel = function(title) {
        document.getElementById('notif_subpanel_title').innerText = title;
        
        if(title === 'Calls') {
            document.getElementById('notif_standard_content').classList.add('hidden');
            document.getElementById('notif_standard_content').classList.remove('flex');
            document.getElementById('notif_calls_content').classList.remove('hidden');
            document.getElementById('notif_calls_content').classList.add('flex');
        } else {
            document.getElementById('notif_calls_content').classList.add('hidden');
            document.getElementById('notif_calls_content').classList.remove('flex');
            document.getElementById('notif_standard_content').classList.remove('hidden');
            document.getElementById('notif_standard_content').classList.add('flex');
        }

        document.getElementById('notifications_subpanel').classList.remove('hidden');
        document.getElementById('notifications_subpanel').classList.add('flex');
        document.getElementById('notifications_settings_panel').classList.add('hidden');
    }

    window.closeNotificationsSubpanel = function() {
        document.getElementById('notifications_subpanel').classList.add('hidden');
        document.getElementById('notifications_subpanel').classList.remove('flex');
        document.getElementById('notifications_settings_panel').classList.remove('hidden');
    }

    window.selectTone = function(tone) {
        document.getElementById('selected_tone_text').innerText = tone;
        document.getElementById('notif_tone_dropdown').classList.add('hidden');
        
        // Update indicators
        document.querySelectorAll('[id^="tone_indicator_"]').forEach(el => {
            el.classList.remove('bg-[#00a884]');
            el.classList.add('bg-transparent');
        });
        const id = 'tone_indicator_' + tone.replace(' ', '_');
        if(document.getElementById(id)) {
            document.getElementById(id).classList.remove('bg-transparent');
            document.getElementById(id).classList.add('bg-[#00a884]');
        }
        
        window.showToast?.('Settings Updated', `Notification tone set to ${tone}.`);
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        const dropdown = document.getElementById('notif_tone_dropdown');
        const trigger = document.getElementById('notif_tone_trigger');
        if (dropdown && !dropdown.classList.contains('hidden')) {
            if (!dropdown.contains(e.target) && !trigger.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        }
    });
</script>
