<div id="notifications_banner_panel" class="hidden flex-col w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="closeNotificationsBannerPanel()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Show notification banner</h2>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] py-4 px-4">
        <div class="flex flex-col gap-2">
            <label class="flex items-center gap-4 cursor-pointer group hover:bg-[#202c33] p-4 rounded-xl transition-colors bg-[#202c33]">
                <div class="relative flex items-center justify-center">
                    <input type="radio" name="notif_banner_radio" value="Always" class="peer sr-only" checked onchange="updateNotifBanner(this)">
                    <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] transition-colors"></div>
                    <div class="absolute w-2.5 h-2.5 rounded-full bg-[#00a884] opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                </div>
                <span class="text-[#e9edef] text-[15px]">Always</span>
            </label>

            <label class="flex items-center gap-4 cursor-pointer group hover:bg-[#202c33] p-4 rounded-xl transition-colors">
                <div class="relative flex items-center justify-center">
                    <input type="radio" name="notif_banner_radio" value="Never" class="peer sr-only" onchange="updateNotifBanner(this)">
                    <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] transition-colors"></div>
                    <div class="absolute w-2.5 h-2.5 rounded-full bg-[#00a884] opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                </div>
                <span class="text-[#e9edef] text-[15px]">Never</span>
            </label>

            <label class="flex items-center gap-4 cursor-pointer group hover:bg-[#202c33] p-4 rounded-xl transition-colors">
                <div class="relative flex items-center justify-center">
                    <input type="radio" name="notif_banner_radio" value="Only when app is open" class="peer sr-only" onchange="updateNotifBanner(this)">
                    <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] transition-colors"></div>
                    <div class="absolute w-2.5 h-2.5 rounded-full bg-[#00a884] opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                </div>
                <span class="text-[#e9edef] text-[15px]">Only when app is open</span>
            </label>
        </div>
    </div>
</div>

<script>
    window.openNotificationsBannerPanel = function() {
        document.getElementById('notifications_banner_panel').classList.remove('hidden');
        document.getElementById('notifications_banner_panel').classList.add('flex');
        document.getElementById('notifications_settings_panel').classList.add('hidden');
    }

    window.closeNotificationsBannerPanel = function() {
        document.getElementById('notifications_banner_panel').classList.add('hidden');
        document.getElementById('notifications_banner_panel').classList.remove('flex');
        document.getElementById('notifications_settings_panel').classList.remove('hidden');
    }

    window.updateNotifBanner = function(radio) {
        if(radio.checked) {
            document.getElementById('notif_banner_status').innerText = radio.value;
            // Update active background
            document.querySelectorAll('input[name="notif_banner_radio"]').forEach(r => {
                r.closest('label').classList.remove('bg-[#202c33]');
            });
            radio.closest('label').classList.add('bg-[#202c33]');
        }
    }
</script>
