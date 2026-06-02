<div id="notifications_settings_panel"
    class="hidden flex-col w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="toggleNotificationsSettings()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Notifications</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] py-2">
        
        <div class="flex flex-col gap-0 border-b border-[#313d45] mx-4 mb-4">
            <!-- Show notification banner -->
            <div onclick="openNotificationsBannerPanel()" class="flex items-center justify-between py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4">
                <div class="flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">Show notification banner</span>
                    <span class="text-[#8696a0] text-[14px]" id="notif_banner_status">Always</span>
                </div>
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0]">
                    <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"></path>
                </svg>
            </div>
            
            <div class="h-[1px] bg-[#313d45]"></div>

            <!-- Show taskbar notification badge -->
            <div onclick="openNotificationsTaskbarPanel()" class="flex items-center justify-between py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4">
                <div class="flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">Show taskbar notification badge</span>
                    <span class="text-[#8696a0] text-[14px]" id="notif_taskbar_status">Always</span>
                </div>
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0]">
                    <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"></path>
                </svg>
            </div>
        </div>

        <div class="flex flex-col gap-0 border-b border-[#313d45] mx-4 pb-4 mb-4">
            <!-- Messages -->
            <div onclick="openNotificationsSubpanel('Messages')" class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4">
                <div class="w-12 shrink-0 flex justify-start text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                </div>
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">Messages</span>
                    <span class="text-[#8696a0] text-[14px]">On</span>
                </div>
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0]">
                    <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"></path>
                </svg>
            </div>

            <!-- Groups -->
            <div onclick="openNotificationsSubpanel('Groups')" class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4">
                <div class="w-12 shrink-0 flex justify-start text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">Groups</span>
                    <span class="text-[#8696a0] text-[14px]">On</span>
                </div>
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0]">
                    <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"></path>
                </svg>
            </div>

            <!-- Status -->
            <div onclick="openNotificationsSubpanel('Status')" class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4">
                <div class="w-12 shrink-0 flex justify-start text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </div>
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">Status</span>
                    <span class="text-[#8696a0] text-[14px]">On</span>
                </div>
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0]">
                    <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"></path>
                </svg>
            </div>

            <!-- Calls -->
            <div onclick="openNotificationsSubpanel('Calls')" class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4">
                <div class="w-12 shrink-0 flex justify-start text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                </div>
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">Calls</span>
                    <span class="text-[#8696a0] text-[14px]">On</span>
                </div>
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0]">
                    <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"></path>
                </svg>
            </div>
        </div>

        <div class="flex flex-col gap-0 border-b border-[#313d45] mx-4 pb-4 mb-4">
            <div class="flex items-center justify-between py-2">
                <div class="flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">Show previews</span>
                    <span class="text-[#8696a0] text-[14px] mt-0.5">Preview message text inside message notifications.</span>
                </div>
                <label class="relative inline-flex items-center cursor-pointer ml-4 shrink-0">
                    <input type="checkbox" onchange="window.showToast?.('Settings Updated', 'Notification preview setting updated.')" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-[#111b21] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-[#8696a0] peer-checked:after:bg-[#111b21] after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
                </label>
            </div>
        </div>

        <div class="flex flex-col gap-0 border-b border-[#313d45] mx-4 pb-4 mb-8">
            <div class="flex items-center justify-between py-2">
                <div class="flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">Play sound for outgoing messages</span>
                </div>
                <label class="relative inline-flex items-center cursor-pointer ml-4 shrink-0">
                    <input type="checkbox" onchange="window.showToast?.('Settings Updated', 'Outgoing sound setting updated.')" class="sr-only peer">
                    <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-[#111b21] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-[#8696a0] peer-checked:after:bg-[#111b21] after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
                </label>
            </div>
        </div>

    </div>
</div>

<script>
    window.toggleNotificationsSettings = function() {
        const notificationsPanel = document.getElementById('notifications_settings_panel');
        const settingsPanel = document.getElementById('settings_panel');

        if (notificationsPanel.classList.contains('hidden')) {
            notificationsPanel.classList.remove('hidden');
            notificationsPanel.classList.add('flex');
            if (settingsPanel) settingsPanel.classList.add('hidden');
        } else {
            notificationsPanel.classList.add('hidden');
            notificationsPanel.classList.remove('flex');
            if (settingsPanel) settingsPanel.classList.remove('hidden');
        }
    }
</script>
<?php /**PATH D:\xampp\htdocs\laravel\chat_app\resources\views/chat/settings/notifications_panels/notifications.blade.php ENDPATH**/ ?>