<div id="account_settings_panel"
    class="hidden flex-col w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="toggleAccountSettings()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M20 11H7.8l5.6-5.6L12 4l-8 8 8 8 1.4-1.4L7.8 13H20v-2z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Account</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] py-2">
        <div class="flex flex-col">
            <!-- Security notifications -->
            <div class="flex items-center px-6 py-4 hover:bg-[#202c33] cursor-pointer group transition-colors" onclick="toggleSecuritySettings()">
                <div class="w-10 text-[#8696a0] group-hover:text-[#e9edef] transition-colors shrink-0">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                </div>
                <div class="flex-1 ml-3">
                    <div class="text-[#e9edef] text-[16px] font-normal">Security notifications</div>
                </div>
            </div>

            <!-- Request account info -->
            <div class="flex items-center px-6 py-4 hover:bg-[#202c33] cursor-pointer group transition-colors" onclick="window.showToast('Account Info', 'Requesting account info report...')">
                <div class="w-10 text-[#8696a0] group-hover:text-[#e9edef] transition-colors shrink-0">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                </div>
                <div class="flex-1 ml-3">
                    <div class="text-[#e9edef] text-[16px] font-normal">Request account info</div>
                </div>
            </div>

            <!-- Delete account -->
            <div class="flex items-center px-6 py-4 hover:bg-[#202c33] cursor-pointer group transition-colors mt-2" onclick="promptDeleteAccount()">
                <div class="w-10 text-[#f15c5c] shrink-0">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                </div>
                <div class="flex-1 ml-3">
                    <div class="text-[#f15c5c] text-[16px] font-normal">Delete account</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.toggleAccountSettings = function() {
        const accountPanel = document.getElementById('account_settings_panel');
        const settingsPanel = document.getElementById('settings_panel');

        if (accountPanel.classList.contains('hidden')) {
            accountPanel.classList.remove('hidden');
            accountPanel.classList.add('flex');
            if (settingsPanel) settingsPanel.classList.add('hidden');
        } else {
            accountPanel.classList.add('hidden');
            accountPanel.classList.remove('flex');
            if (settingsPanel) settingsPanel.classList.remove('hidden');
        }
    }

    window.promptDeleteAccount = function() {
        if(confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
            window.showToast('Account', 'Account deletion initiated');
        }
    }
</script>
<?php /**PATH D:\xampp\htdocs\laravel\chat_app\resources\views/chat/settings/account.blade.php ENDPATH**/ ?>