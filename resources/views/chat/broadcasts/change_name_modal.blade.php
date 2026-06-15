<!-- Change Broadcast Name Modal -->
<div id="change_broadcast_name_modal"
    class="hidden fixed inset-0 z-[1000] flex items-center justify-center bg-black/60 backdrop-blur-sm transition-all duration-300">
    <div class="bg-[#222e35] w-[90%] max-w-[360px] rounded-2xl p-6 shadow-2xl border border-[#313d45]">
        
        <!-- Header -->
        <h3 class="text-[#e9edef] text-[18px] font-medium mb-6">Broadcast list name</h3>
        
        <!-- Input Row -->
        <div class="relative flex items-center border-b-2 border-[#00a884] pb-1.5 mb-8">
            <input type="text" id="broadcast_name_input" maxlength="100" oninput="updateBcastNameCounter()"
                class="bg-transparent border-none focus:ring-0 w-full text-[16px] text-[#e9edef] outline-none p-0 pr-16 placeholder-[#8696a0]">
            
            <!-- Counter & Emoji -->
            <div class="absolute right-0 flex items-center gap-2">
                <span id="broadcast_name_counter" class="text-[12px] text-[#8696a0]">100</span>
                <button class="text-[#8696a0] hover:text-[#e9edef] focus:outline-none">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Footer Buttons (Split 50/50 block style or right-aligned) -->
        <div class="flex justify-end gap-3 text-[14px] font-bold">
            <button onclick="closeChangeBroadcastName()"
                class="text-[#00a884] hover:bg-white/5 px-4 py-2.5 rounded-lg transition-colors focus:outline-none">
                Cancel
            </button>
            <button onclick="saveBroadcastNameChange()"
                class="bg-[#00a884] text-[#111b21] hover:bg-[#00bfa5] px-6 py-2.5 rounded-full transition-all active:scale-95 shadow-lg focus:outline-none">
                OK
            </button>
        </div>
    </div>
</div>

<script>
    window.openChangeBroadcastName = function() {
        const list = window.activeBroadcastList;
        if (!list) return;

        const modal = document.getElementById('change_broadcast_name_modal');
        const input = document.getElementById('broadcast_name_input');
        
        if (modal && input) {
            input.value = list.name;
            window.updateBcastNameCounter();
            modal.classList.remove('hidden');
            setTimeout(() => input.focus(), 50);
        }
    };

    window.closeChangeBroadcastName = function() {
        const modal = document.getElementById('change_broadcast_name_modal');
        if (modal) {
            modal.classList.add('hidden');
        }
    };

    window.updateBcastNameCounter = function() {
        const input = document.getElementById('broadcast_name_input');
        const counter = document.getElementById('broadcast_name_counter');
        if (input && counter) {
            const remaining = 100 - input.value.length;
            counter.textContent = remaining;
        }
    };

    window.saveBroadcastNameChange = function() {
        const input = document.getElementById('broadcast_name_input');
        if (!input) return;

        const newName = input.value.trim();
        if (!newName) {
            window.showToast?.('Alert', 'Broadcast name cannot be empty.');
            return;
        }

        const list = window.activeBroadcastList;
        if (!list) return;

        // Update list properties
        list.name = newName;

        // Update in localStorage
        window.broadcastLists = window.broadcastLists.map(l => l.id === list.id ? list : l);
        localStorage.setItem('broadcast_lists', JSON.stringify(window.broadcastLists));

        // Close modal
        window.closeChangeBroadcastName();

        // Update active UI elements
        const titleEl = document.getElementById('active_chat_title');
        if (titleEl && window.currentChatId === `broadcast_${list.id}`) {
            titleEl.textContent = newName;
        }

        const infoNameEl = document.getElementById('bcast_info_name');
        if (infoNameEl) {
            infoNameEl.textContent = newName;
        }

        // Re-render sidebar lists
        window.renderBroadcastLists();
        window.showToast?.('Success', 'Broadcast list name updated.');
    };
</script>
