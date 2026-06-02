<div id="security_settings_panel"
    class="hidden flex-col w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="toggleSecuritySettings()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M20 11H7.8l5.6-5.6L12 4l-8 8 8 8 1.4-1.4L7.8 13H20v-2z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Security</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] py-6">
        <div class="px-6 flex flex-col items-center">
            <!-- Icon -->
            <div class="mb-8">
                <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.5 15H80C86.9036 15 92.5 20.5964 92.5 27.5V67.5C92.5 74.4036 86.9036 80 80 80H42.5L20 100V80H12.5C5.59644 80 0 74.4036 0 67.5V27.5C0 20.5964 5.59644 15 12.5 15Z" fill="#E9FBC5"/>
                    <rect x="25" y="40" width="40" height="3" fill="#111B21"/>
                    <rect x="25" y="55" width="25" height="3" fill="#111B21"/>
                    <rect x="65" y="45" width="45" height="40" rx="6" fill="#00A884"/>
                    <path d="M72.5 45V32.5C72.5 24.2157 79.2157 17.5 87.5 17.5C95.7843 17.5 102.5 24.2157 102.5 32.5V45" stroke="#00A884" stroke-width="10" stroke-linecap="round"/>
                    <circle cx="87.5" cy="65" r="4" stroke="#111B21" stroke-width="2"/>
                </svg>
            </div>
        </div>

        <div class="px-6">
            <h1 class="text-[#e9edef] text-[20px] font-medium mb-3 leading-tight">Your chats and calls are private</h1>
            <p class="text-[#8696a0] text-[14px] leading-relaxed mb-6">
                End-to-end encryption keeps your personal messages and calls between you and the people you choose. No one outside of the chat, not even WhatsApp, can read, listen to, or share them. This includes your:
            </p>

            <div class="flex flex-col gap-4 mb-6">
                <!-- List Items -->
                <div class="flex items-center gap-4">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#e9edef]">
                        <path d="M20 2H4C2.9 2 2 2.9 2 4v12c0 1.1.9 2 2 2h14l4 4V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/>
                    </svg>
                    <span class="text-[#e9edef] text-[15px]">Text and voice messages</span>
                </div>
                <div class="flex items-center gap-4">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#e9edef]">
                        <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.977.977 0 00-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.03 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>
                    </svg>
                    <span class="text-[#e9edef] text-[15px]">Audio and video calls</span>
                </div>
                <div class="flex items-center gap-4">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#e9edef]">
                        <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                    </svg>
                    <span class="text-[#e9edef] text-[15px]">Photos, videos and documents</span>
                </div>
                <div class="flex items-center gap-4">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#e9edef]">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                    <span class="text-[#e9edef] text-[15px]">Location sharing</span>
                </div>
                <div class="flex items-center gap-4">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#e9edef]">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/>
                    </svg>
                    <span class="text-[#e9edef] text-[15px]">Status updates</span>
                </div>
            </div>

            <a href="#" class="text-[#00a884] text-[14px] hover:underline mb-6 block" onclick="window.showToast('Learn more', 'Opening help center...')">Learn more</a>

            <div class="border-t border-[#313d45] py-6">
                <div class="flex items-start justify-between gap-4">
                    <div class="pt-1">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" class="text-[#e9edef]">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="text-[#e9edef] text-[16px] leading-tight mb-2">Show security notifications on this computer</div>
                        <p class="text-[#8696a0] text-[14px] leading-relaxed mb-1">
                            Get notified when your security code changes for a contact's phone. If you have multiple devices, this setting must be enabled on each device where you want to get notifications.
                        </p>
                        <a href="#" class="text-[#00a884] text-[14px] hover:underline block" onclick="window.showToast('Learn more', 'Opening help center...')">Learn more</a>
                    </div>
                    <div class="pt-1 shrink-0">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="security_notification_toggle" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.toggleSecuritySettings = function() {
        const securityPanel = document.getElementById('security_settings_panel');
        const accountPanel = document.getElementById('account_settings_panel');

        if (securityPanel.classList.contains('hidden')) {
            securityPanel.classList.remove('hidden');
            securityPanel.classList.add('flex');
            if (accountPanel) accountPanel.classList.add('hidden');
        } else {
            securityPanel.classList.add('hidden');
            securityPanel.classList.remove('flex');
            if (accountPanel) accountPanel.classList.remove('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const securityToggle = document.getElementById('security_notification_toggle');
        if (securityToggle) {
            // Load state
            const isEnabled = localStorage.getItem('whatsapp_security_notifications') !== 'false';
            securityToggle.checked = isEnabled;
            
            // Save state on change
            securityToggle.addEventListener('change', function() {
                localStorage.setItem('whatsapp_security_notifications', this.checked);
                if (window.showToast) {
                    window.showToast('Security', 'Security notifications ' + (this.checked ? 'enabled' : 'disabled'));
                }
            });
        }
    });
</script>
<?php /**PATH D:\xampp\htdocs\laravel\chat_app\resources\views/chat/settings/security_notifications.blade.php ENDPATH**/ ?>