<div id="privacy_settings_panel"
    class="hidden flex-col w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="togglePrivacySettings()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M20 11H7.8l5.6-5.6L12 4l-8 8 8 8 1.4-1.4L7.8 13H20v-2z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Privacy</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] py-4">
        <div class="px-6 pb-12">
            <div class="text-[#8696a0] text-[14px] mb-4 mt-2">Who can see my personal info</div>

            <!-- Last seen and online -->
            <div class="flex items-center justify-between py-4 border-b border-[#202c33] cursor-pointer hover:bg-[#202c33] -mx-6 px-6 transition-colors group" onclick="togglePrivacyLastSeen()">
                <div class="flex-1 pr-4">
                    <div class="text-[#e9edef] text-[16px] mb-1">Last seen and online</div>
                    <div class="text-[#8696a0] text-[14px]" id="privacy_last_seen_label">Nobody, Everyone</div>
                </div>
                <div class="text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
                </div>
            </div>

            <!-- Profile picture -->
            <div class="flex items-center justify-between py-4 border-b border-[#202c33] cursor-pointer hover:bg-[#202c33] -mx-6 px-6 transition-colors group" onclick="togglePrivacyProfilePhoto()">
                <div class="flex-1 pr-4">
                    <div class="text-[#e9edef] text-[16px] mb-1">Profile picture</div>
                    <div class="text-[#8696a0] text-[14px]" id="privacy_profile_photo_label">My contacts</div>
                </div>
                <div class="text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
                </div>
            </div>

            <!-- About -->
            <div class="flex items-center justify-between py-4 border-b border-[#202c33] cursor-pointer hover:bg-[#202c33] -mx-6 px-6 transition-colors group" onclick="togglePrivacyAbout()">
                <div class="flex-1 pr-4">
                    <div class="text-[#e9edef] text-[16px] mb-1">About</div>
                    <div class="text-[#8696a0] text-[14px]" id="privacy_about_label">Nobody</div>
                </div>
                <div class="text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
                </div>
            </div>

            <!-- Status -->
            <div class="flex items-center justify-between py-4 border-b border-[#202c33] cursor-pointer hover:bg-[#202c33] -mx-6 px-6 transition-colors group" onclick="window.openStatusPrivacy()">
                <div class="flex-1 pr-4">
                    <div class="text-[#e9edef] text-[17px] mb-1">Status</div>
                    <div id="privacy_status_label" class="text-[#8696a0] text-[14px]">My contacts</div>
                </div>
                <div class="text-[#8696a0] group-hover:text-[#e9edef] transition-colors">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"></path>
                    </svg>
                </div>
            </div>

            <!-- Read receipts -->
            <div class="flex items-start justify-between py-5 border-b border-[#202c33]">
                <div class="flex-1 pr-4">
                    <div class="text-[#e9edef] text-[16px] mb-1">Read receipts</div>
                    <div class="text-[#8696a0] text-[14px] leading-snug">
                        If turned off, you won't send or receive read receipts. Read receipts are always sent for group chats.
                    </div>
                </div>
                <div class="pt-1">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="privacy_read_receipts" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
                    </label>
                </div>
            </div>

            <div class="text-[#8696a0] text-[14px] font-medium mb-3 mt-6">Disappearing messages</div>

            <!-- Default message timer -->
            <div class="relative flex items-center justify-between py-4 border-b border-[#202c33] cursor-pointer hover:bg-[#202c33] -mx-6 px-6 transition-colors group">
                <div class="flex-1 pr-4">
                    <div class="text-[#e9edef] text-[16px] mb-1">Default message timer</div>
                    <div class="text-[#8696a0] text-[14px]" id="privacy_message_timer_label">Off</div>
                </div>
                <div class="text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
                </div>
                <select id="privacy_message_timer" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer text-[16px]">
                    <option value="Off">Off</option>
                    <option value="24 hours">24 hours</option>
                    <option value="7 days">7 days</option>
                    <option value="90 days">90 days</option>
                </select>
            </div>

            <!-- Groups -->
            <div class="relative flex items-center justify-between py-4 border-b border-[#202c33] cursor-pointer hover:bg-[#202c33] -mx-6 px-6 transition-colors group">
                <div class="flex-1 pr-4">
                    <div class="text-[#e9edef] text-[16px] mb-1">Groups</div>
                    <div class="text-[#8696a0] text-[14px]" id="privacy_groups_label">Everyone</div>
                </div>
                <div class="text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
                </div>
                <select id="privacy_groups" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer text-[16px]">
                    <option value="Everyone">Everyone</option>
                    <option value="My contacts">My contacts</option>
                    <option value="My contacts except...">My contacts except...</option>
                </select>
            </div>

            <!-- Blocked contacts -->
            <div class="flex items-center justify-between py-4 border-b border-[#202c33] cursor-pointer hover:bg-[#202c33] -mx-6 px-6 transition-colors group" onclick="window.showToast('Blocked Contacts', 'You have 12 blocked contacts.')">
                <div class="flex-1 pr-4">
                    <div class="text-[#e9edef] text-[16px] mb-1">Blocked contacts</div>
                    <div class="text-[#8696a0] text-[14px]">12</div>
                </div>
                <div class="text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
                </div>
            </div>

            <!-- App lock -->
            <div class="flex items-center justify-between py-4 cursor-pointer hover:bg-[#202c33] -mx-6 px-6 transition-colors group" onclick="window.showToast('App Lock', 'App lock settings')">
                <div class="flex-1 pr-4">
                    <div class="text-[#e9edef] text-[16px] mb-1">App lock</div>
                    <div class="text-[#8696a0] text-[14px]">Require password to unlock WhatsApp</div>
                </div>
                <div class="text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
                </div>
            </div>

            <div class="text-[#8696a0] text-[14px] font-medium mb-3 mt-8">Advanced</div>

            <!-- Block unknown account messages -->
            <div class="flex items-start justify-between py-4 border-b border-[#202c33]">
                <div class="flex-1 pr-4">
                    <div class="text-[#e9edef] text-[16px] mb-1">Block unknown account messages</div>
                    <div class="text-[#8696a0] text-[14px] leading-snug">
                        To protect your account and improve device performance, WhatsApp will block messages from unknown accounts if they exceed a certain volume. <a href="#" class="text-[#00a884] hover:underline" onclick="window.showToast('Learn more', 'Opening help center...')">Learn more</a>
                    </div>
                </div>
                <div class="pt-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="privacy_block_unknown" class="sr-only peer">
                        <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
                    </label>
                </div>
            </div>

            <!-- Protect IP address in calls -->
            <div class="flex items-start justify-between py-4 border-b border-[#202c33]">
                <div class="flex-1 pr-4">
                    <div class="text-[#e9edef] text-[16px] mb-1">Protect IP address in calls</div>
                    <div class="text-[#8696a0] text-[14px] leading-snug">
                        To make it harder for people to infer your location, calls on this device will be securely relayed through WhatsApp servers. This will reduce call quality. <a href="#" class="text-[#00a884] hover:underline" onclick="window.showToast('Learn more', 'Opening help center...')">Learn more</a>
                    </div>
                </div>
                <div class="pt-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="privacy_protect_ip" class="sr-only peer">
                        <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
                    </label>
                </div>
            </div>

            <!-- Disable link previews -->
            <div class="flex items-start justify-between py-4 border-b border-[#202c33]">
                <div class="flex-1 pr-4">
                    <div class="text-[#e9edef] text-[16px] mb-1">Disable link previews</div>
                    <div class="text-[#8696a0] text-[14px] leading-snug">
                        To help protect your IP address from being inferred by third-party websites, previews for the links you share in chats will no longer be generated. <a href="#" class="text-[#00a884] hover:underline" onclick="window.showToast('Learn more', 'Opening help center...')">Learn more</a>
                    </div>
                </div>
                <div class="pt-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="privacy_disable_links" class="sr-only peer">
                        <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
                    </label>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    window.togglePrivacySettings = function() {
        const privacyPanel = document.getElementById('privacy_settings_panel');
        const settingsPanel = document.getElementById('settings_panel');

        if (privacyPanel.classList.contains('hidden')) {
            privacyPanel.classList.remove('hidden');
            privacyPanel.classList.add('flex');
            if (settingsPanel) settingsPanel.classList.add('hidden');
        } else {
            privacyPanel.classList.add('hidden');
            privacyPanel.classList.remove('flex');
            if (settingsPanel) settingsPanel.classList.remove('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Dropdowns mapping (id -> default value in screenshot)
        const selects = {
            'privacy_last_seen': 'Nobody, Everyone',
            'privacy_profile_photo': 'My contacts',
            'privacy_about': 'Nobody',
            'privacy_status': '1 contact included',
            'privacy_message_timer': 'Off',
            'privacy_groups': 'Everyone'
        };
        
        for (const [id, defaultVal] of Object.entries(selects)) {
            const el = document.getElementById(id);
            const labelEl = document.getElementById(id + '_label');
            if (el && labelEl) {
                // Initialize with localstorage or default
                const saved = localStorage.getItem('whatsapp_' + id);
                if (saved) {
                    el.value = saved;
                    labelEl.innerText = saved;
                } else {
                    el.value = defaultVal;
                    labelEl.innerText = defaultVal;
                }
                
                // Change listener
                el.addEventListener('change', function() {
                    localStorage.setItem('whatsapp_' + id, this.value);
                    labelEl.innerText = this.value;
                    if(window.showToast) window.showToast('Privacy Updated', 'Setting saved.');
                });
            }
        }

        // Toggles mapping
        const toggles = ['privacy_read_receipts', 'privacy_block_unknown', 'privacy_protect_ip', 'privacy_disable_links'];
        toggles.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                const saved = localStorage.getItem('whatsapp_' + id);
                if (saved !== null) {
                    el.checked = (saved === 'true');
                } else {
                    // Default read receipts to true, others to false (based on screenshot)
                    if (id === 'privacy_read_receipts') el.checked = true;
                    else el.checked = false;
                }
                
                el.addEventListener('change', function() {
                    localStorage.setItem('whatsapp_' + id, this.checked);
                    if(window.showToast) window.showToast('Privacy Updated', 'Setting updated.');
                });
            }
        });
    });
</script>
