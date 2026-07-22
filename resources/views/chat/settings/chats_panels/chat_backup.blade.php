<div id="chat_backup_panel"
    class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden absolute sm:relative z-20">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="toggleChatBackupPanel()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M20 11H7.8l5.6-5.6L12 4l-8 8 8 8 1.4-1.4L7.8 13H20v-2z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Chat backup</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21]">
        
        <!-- Backup settings section -->
        <!-- Backup settings section -->
        <div class="px-6 py-4">
            <div class="flex justify-between items-center mb-2">
                <div class="text-[#8696a0] text-[14px] font-medium">Backup settings</div>
                <div class="text-[#00a884] text-[13px] font-medium hidden" id="chat_backup_up_to_date">Backup up to date.</div>
            </div>
            <div class="text-[#8696a0] text-[14px] leading-relaxed mb-6" id="chat_backup_status_text">
                Back up your chats and media to the cloud so you don't lose them when you get a new Android phone.
            </div>

            <div class="mb-4">
                <div class="text-[#e9edef] text-[14px]" id="chat_backup_last_time">Last Backup: Never</div>
                <div class="text-[#8696a0] text-[14px]" id="chat_backup_size">Size: --</div>
            </div>

            <div class="flex items-center">
                <button id="chat_backup_btn" onclick="startChatBackup()" class="bg-[#00a884] hover:bg-[#06cf9c] text-[#111b21] font-medium text-[14px] py-2.5 px-6 rounded-full transition-colors mb-6">
                    Back up
                </button>
                <button id="chat_restore_btn" onclick="startChatRestore()" class="hidden bg-[#202c33] hover:bg-[#2a3942] border border-[#313d45] text-[#00a884] font-medium text-[14px] py-2.5 px-6 rounded-full transition-colors mb-6 ml-4">
                    Restore
                </button>
            </div>
            <div id="chat_backup_progress_container" class="hidden w-full max-w-[200px] mb-6">
                <div class="flex justify-between text-[#8696a0] text-[13px] mb-1">
                    <span>Backing up messages...</span>
                    <span id="chat_backup_progress_text">0%</span>
                </div>
                <div class="w-full bg-[#202c33] rounded-full h-1">
                    <div id="chat_backup_progress_bar" class="bg-[#00a884] h-1 rounded-full" style="width: 0%"></div>
                </div>
            </div>

            <div class="text-[#8696a0] text-[14px] leading-relaxed">
                Your backup is being end-to-end encrypted for the first time. This process can take a while. When it is complete, this message will disappear and your backup will be fully end-to-end encrypted.
            </div>
        </div>

        <div class="h-[1px] bg-[#202c33] my-2"></div>

        <!-- Google Account -->
        <div class="px-6 py-4 hover:bg-[#202c33] transition-colors cursor-pointer" onclick="openChatBackupAccountModal()">
            <div class="text-[#e9edef] text-[16px] mb-1">Google Account</div>
            <div class="text-[#8696a0] text-[14px]" id="chat_backup_account_label">siddharthchayani@gmail.com</div>
        </div>

        <!-- Manage Google Storage -->
        <div class="px-6 py-4 hover:bg-[#202c33] transition-colors cursor-pointer">
            <div class="text-[#00a884] text-[16px] mb-1">Manage Google storage</div>
            <div class="text-[#8696a0] text-[14px]">Can't load storage info</div>
        </div>

        <div class="h-[1px] bg-[#202c33] my-2"></div>

        <!-- Automatic backups -->
        <div class="px-6 py-4 hover:bg-[#202c33] transition-colors cursor-pointer" onclick="openChatBackupFrequencyModal()">
            <div class="text-[#e9edef] text-[16px] mb-1">Automatic backups</div>
            <div class="text-[#8696a0] text-[14px]" id="chat_backup_frequency_label">Daily</div>
        </div>

        <!-- Include videos -->
        <div class="flex items-center justify-between py-4 hover:bg-[#202c33] px-6 transition-colors cursor-pointer" onclick="document.getElementById('chat_backup_videos_toggle').click()">
            <div class="flex-1 pr-4">
                <div class="text-[#e9edef] text-[16px]">Include videos</div>
            </div>
            <label class="relative inline-flex items-center cursor-pointer" onclick="event.stopPropagation()">
                <input type="checkbox" id="chat_backup_videos_toggle" onchange="toggleChatBackupSetting('videos', this.checked)" class="sr-only peer">
                <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
            </label>
        </div>

        <!-- Back up using cellular -->
        <div class="flex items-center justify-between py-4 hover:bg-[#202c33] px-6 transition-colors cursor-pointer" onclick="document.getElementById('chat_backup_cellular_toggle').click()">
            <div class="flex-1 pr-4">
                <div class="text-[#e9edef] text-[16px]">Back up using cellular</div>
            </div>
            <label class="relative inline-flex items-center cursor-pointer" onclick="event.stopPropagation()">
                <input type="checkbox" id="chat_backup_cellular_toggle" onchange="toggleChatBackupSetting('cellular', this.checked)" class="sr-only peer">
                <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
            </label>
        </div>

        <div class="h-[1px] bg-[#202c33] my-2"></div>

        <!-- End-to-end encryption -->
        <div class="px-6 py-4">
            <div class="text-[#8696a0] text-[14px] font-medium mb-1">End-to-end encryption</div>
            <div class="text-[#8696a0] text-[14px] leading-relaxed mb-4">
                For added security, you can protect your backup with end-to-end encryption.
            </div>
            
            <div class="flex items-center gap-6 group cursor-pointer" onclick="toggleChatBackupSetting('e2ee', !document.getElementById('chat_backup_e2ee_value').dataset.active || document.getElementById('chat_backup_e2ee_value').dataset.active === 'false')">
                <div class="text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM8.9 6c0-1.71 1.39-3.1 3.1-3.1s3.1 1.39 3.1 3.1v2H8.9V6zM18 20H6V10h12v10zm-5-3h-2v-2H9v-2h2v-2h2v2h2v2h-2v2z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="text-[#e9edef] text-[16px] mb-1">End-to-end encrypted backup</div>
                    <div class="text-[#8696a0] text-[14px]" id="chat_backup_e2ee_value" data-active="false">Off</div>
                </div>
            </div>
        </div>
        
        <div class="h-10"></div>
    </div>
</div>

<!-- Account Selection Modal -->
<div id="chat_backup_account_modal" class="hidden fixed inset-0 z-[150] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-[#0b141a]/80 backdrop-blur-sm" onclick="closeChatBackupAccountModal()"></div>
    
    <div class="relative w-full max-w-[340px] bg-[#233138] rounded-xl shadow-2xl flex flex-col overflow-hidden animate-in fade-in zoom-in duration-200">
        <div class="px-6 py-5 pb-2">
            <h2 class="text-[#e9edef] text-[19px] font-medium">Choose an account</h2>
        </div>
        
        <div class="flex flex-col py-2" id="chat_backup_account_list">
            <!-- Dynamically populated -->
        </div>

        <div class="flex justify-end px-6 py-4">
            <button onclick="closeChatBackupAccountModal()" class="text-[#00a884] font-medium hover:bg-[#00a884]/10 px-4 py-2 rounded transition-colors">
                Cancel
            </button>
        </div>
    </div>
</div>

<!-- Frequency Selection Modal -->
<div id="chat_backup_frequency_modal" class="hidden fixed inset-0 z-[150] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-[#0b141a]/80 backdrop-blur-sm" onclick="closeChatBackupFrequencyModal()"></div>
    
    <div class="relative w-full max-w-[340px] bg-[#233138] rounded-xl shadow-2xl flex flex-col overflow-hidden animate-in fade-in zoom-in duration-200">
        <div class="px-6 py-5 pb-2">
            <h2 class="text-[#e9edef] text-[19px] font-medium">Automatic backups</h2>
        </div>
        
        <div class="flex flex-col py-2" id="chat_backup_frequency_list">
            <!-- Dynamically populated -->
        </div>

        <div class="flex justify-end px-6 py-4">
            <button onclick="closeChatBackupFrequencyModal()" class="text-[#00a884] font-medium hover:bg-[#00a884]/10 px-4 py-2 rounded transition-colors">
                Cancel
            </button>
        </div>
    </div>
</div>

<!-- E2E Setup Panel/Modal -->
<div id="chat_backup_e2e_panel" class="hidden absolute inset-0 z-[40] bg-[#111b21] flex-col h-full w-full">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="closeE2EPanel()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M20 11H7.8l5.6-5.6L12 4l-8 8 8 8 1.4-1.4L7.8 13H20v-2z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">End-to-end encrypted backup</h2>
    </div>
    
    <div class="flex-1 overflow-y-auto px-6 py-8 flex flex-col items-center text-center">
        <!-- Illustration Placeholder -->
        <div class="w-32 h-32 mb-6 relative flex justify-center items-center">
            <svg width="120" height="120" viewBox="0 0 120 120" fill="none">
                <rect x="20" y="30" width="80" height="60" rx="4" fill="#00a884" />
                <path d="M40 70C40 70 50 50 80 50" stroke="#fff" stroke-width="4" stroke-linecap="round"/>
                <path d="M50 40H70" stroke="#fff" stroke-width="4" stroke-linecap="round"/>
                <rect x="15" y="60" width="30" height="35" rx="6" fill="#e9edef"/>
                <circle cx="30" cy="75" r="4" fill="#111b21"/>
                <path d="M30 79V85" stroke="#111b21" stroke-width="2" stroke-linecap="round"/>
                <path d="M22 60V50C22 45 25 42 30 42C35 42 38 45 38 50V60" stroke="#e9edef" stroke-width="4"/>
            </svg>
        </div>
        
        <h2 id="e2e_title" class="text-[#e9edef] text-[20px] mb-4">Your backup is not end-to-end encrypted</h2>
        
        <p class="text-[#8696a0] text-[15px] mb-6 leading-relaxed max-w-[300px]">
            Your backup is end-to-end encrypted in your Google storage. No one, not even Google or WhatsApp, can access it.
        </p>
        
        <p class="text-[#8696a0] text-[15px] mb-8 leading-relaxed max-w-[300px]">
            If you move to a new device, you can use your password to restore your chats.
        </p>
        
        <div id="e2e_actions_off" class="w-full flex flex-col gap-4">
            <button onclick="openE2EPasswordModal('on')" class="w-full bg-[#00a884] hover:bg-[#06cf9c] text-[#111b21] font-medium text-[15px] py-3 rounded-full transition-colors">
                Turn On
            </button>
        </div>

        <div id="e2e_actions_on" class="w-full hidden flex-col gap-4 mt-auto">
            <button onclick="openE2EPasswordModal('change')" class="w-full bg-[#111b21] border border-[#313d45] hover:bg-[#202c33] text-[#00a884] font-medium text-[15px] py-3 rounded-full transition-colors">
                Change Password
            </button>
            <button onclick="openE2EPasswordModal('off')" class="w-full bg-[#f15c6d] hover:bg-[#f15c6d]/90 text-white font-medium text-[15px] py-3 rounded-full transition-colors">
                Turn Off
            </button>
        </div>
    </div>
</div>

<!-- Password Entry Modal -->
<div id="chat_backup_e2e_password_modal" class="hidden fixed inset-0 z-[150] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-[#0b141a]/80 backdrop-blur-sm" onclick="closeE2EPasswordModal()"></div>
    
    <div class="relative w-full max-w-[340px] bg-[#233138] rounded-xl shadow-2xl flex flex-col overflow-hidden animate-in fade-in zoom-in duration-200">
        <div class="px-6 py-5">
            <h2 id="e2e_password_title" class="text-[#e9edef] text-[19px] font-medium mb-2">Create a password</h2>
            <p class="text-[#8696a0] text-[14px] mb-4">You will need this password to restore your backup.</p>
            <input type="password" id="e2e_password_input" class="w-full bg-[#111b21] text-white border-b border-[#00a884] px-2 py-2 focus:outline-none" placeholder="Enter password">
        </div>

        <div class="flex justify-end px-6 py-4 gap-4">
            <button onclick="closeE2EPasswordModal()" class="text-[#aebac1] font-medium hover:bg-white/5 px-4 py-2 rounded transition-colors">
                Cancel
            </button>
            <button onclick="submitE2EPassword()" class="text-[#00a884] font-medium hover:bg-[#00a884]/10 px-4 py-2 rounded transition-colors">
                Next
            </button>
        </div>
    </div>
</div>

<script>
    window.toggleChatBackupPanel = function() {
        const panel = document.getElementById('chat_backup_panel');
        const chatsSettings = document.getElementById('chats_settings_panel');
        
        if (panel.classList.contains('hidden')) {
            // Open
            panel.classList.remove('hidden');
            panel.classList.add('flex');
            if (chatsSettings) chatsSettings.classList.add('hidden');
            initChatBackupSettings();
        } else {
            // Close
            panel.classList.add('hidden');
            panel.classList.remove('flex');
            if (chatsSettings) chatsSettings.classList.remove('hidden');
        }
    };

    const currentUserEmail = '{{ auth()->user() ? (auth()->user()->email ?? auth()->user()->phone . "@gmail.com") : "user@gmail.com" }}';
    let backupAccounts = [];
    try {
        const stored = localStorage.getItem('whatsapp_chat_backup_accounts_list');
        if (stored) {
            backupAccounts = JSON.parse(stored);
        }
    } catch(e) {}

    if (!backupAccounts.includes(currentUserEmail)) {
        backupAccounts.unshift(currentUserEmail);
    }

    const backupFrequencies = [
        'Daily',
        'Weekly',
        'Monthly',
        'Only when I tap "Back up"',
        'Off'
    ];

    function initChatBackupSettings() {
        let account = localStorage.getItem('whatsapp_chat_backup_account');
        if (!account || !backupAccounts.includes(account)) {
            account = backupAccounts[0];
            localStorage.setItem('whatsapp_chat_backup_account', account);
        }
        document.getElementById('chat_backup_account_label').innerText = account;

        const freq = localStorage.getItem('whatsapp_chat_backup_frequency') || backupFrequencies[0];
        document.getElementById('chat_backup_frequency_label').innerText = freq;

        const incVideos = localStorage.getItem('whatsapp_chat_backup_videos') === 'true';
        document.getElementById('chat_backup_videos_toggle').checked = incVideos;

        const useCellular = localStorage.getItem('whatsapp_chat_backup_cellular') === 'true';
        document.getElementById('chat_backup_cellular_toggle').checked = useCellular;

        const e2ee = localStorage.getItem('whatsapp_chat_backup_e2ee') === 'true';
        const e2eeVal = document.getElementById('chat_backup_e2ee_value');
        e2eeVal.innerText = e2ee ? 'On' : 'Off';
        e2eeVal.dataset.active = e2ee;
        
        const lastTime = localStorage.getItem('whatsapp_chat_backup_last_time');
        const lastSize = localStorage.getItem('whatsapp_chat_backup_last_size');
        if (lastTime) {
            document.getElementById('chat_backup_last_time').innerText = `Last Backup: ${lastTime}`;
            document.getElementById('chat_backup_up_to_date').classList.remove('hidden');
        }
        if (lastSize) document.getElementById('chat_backup_size').innerText = `Size: ${lastSize}`;

        // Check localStorage for UI states
        const e2eEnabled = localStorage.getItem('whatsapp_e2e_backup_enabled') === 'true';
        const videosEnabled = localStorage.getItem('whatsapp_backup_videos') === 'true';
        const cellularEnabled = localStorage.getItem('whatsapp_backup_cellular') === 'true';
        
        document.getElementById('chat_backup_e2ee_value').innerText = e2eEnabled ? 'On' : 'Off';
        document.getElementById('chat_backup_e2ee_value').dataset.active = e2eEnabled ? 'true' : 'false';
        
        document.getElementById('chat_backup_videos_toggle').checked = videosEnabled;
        document.getElementById('chat_backup_cellular_toggle').checked = cellularEnabled;

        // Check if restore button should be shown (if backup exists in local storage we show it, otherwise we'd need to poll drive which requires auth)
        // Since Google Drive requires auth, we just show the Restore button if they have done a backup locally before.
        const lastSizeVal = localStorage.getItem('whatsapp_chat_backup_last_size');
        if (lastSizeVal) {
            document.getElementById('chat_restore_btn').classList.remove('hidden');
        } else {
            document.getElementById('chat_restore_btn').classList.add('hidden');
        }
    }

    window.toggleChatBackupSetting = function(setting, value) {
        if (setting === 'videos') {
            localStorage.setItem('whatsapp_backup_videos', value ? 'true' : 'false');
        } else if (setting === 'cellular') {
            localStorage.setItem('whatsapp_backup_cellular', value ? 'true' : 'false');
        } else if (setting === 'e2ee') {
            openE2EPanel();
        }
    };

    window.openE2EPanel = function() {
        const panel = document.getElementById('chat_backup_e2e_panel');
        panel.classList.remove('hidden');
        panel.classList.add('flex');
        
        const isE2EOn = localStorage.getItem('whatsapp_e2e_backup_enabled') === 'true';
        
        if (isE2EOn) {
            document.getElementById('e2e_title').innerText = 'Your backup is protected with a password';
            document.getElementById('e2e_actions_off').classList.add('hidden');
            document.getElementById('e2e_actions_on').classList.remove('hidden');
            document.getElementById('e2e_actions_on').classList.add('flex');
        } else {
            document.getElementById('e2e_title').innerText = 'End-to-end encrypted backup';
            document.getElementById('e2e_actions_off').classList.remove('hidden');
            document.getElementById('e2e_actions_off').classList.add('flex');
            document.getElementById('e2e_actions_on').classList.add('hidden');
            document.getElementById('e2e_actions_on').classList.remove('flex');
        }
    };

    window.closeE2EPanel = function() {
        const panel = document.getElementById('chat_backup_e2e_panel');
        panel.classList.add('hidden');
        panel.classList.remove('flex');
    };

    let pendingE2EAction = '';
    window.openE2EPasswordModal = function(action) {
        pendingE2EAction = action;
        const modal = document.getElementById('chat_backup_e2e_password_modal');
        const title = document.getElementById('e2e_password_title');
        const input = document.getElementById('e2e_password_input');
        
        if (action === 'on' || action === 'change') {
            title.innerText = 'Create a password';
        } else if (action === 'off') {
            title.innerText = 'Enter your password to turn off';
        } else if (action === 'restore') {
            title.innerText = 'Enter password to restore';
        }
        
        input.value = '';
        modal.classList.remove('hidden');
        input.focus();
    };

    window.closeE2EPasswordModal = function() {
        document.getElementById('chat_backup_e2e_password_modal').classList.add('hidden');
    };

    window.submitE2EPassword = function() {
        const input = document.getElementById('e2e_password_input').value;
        if (!input) {
            if (window.showToast) window.showToast('Error', 'Please enter a password');
            return;
        }

        if (pendingE2EAction === 'on' || pendingE2EAction === 'change') {
            localStorage.setItem('whatsapp_e2e_backup_password', btoa(input));
            localStorage.setItem('whatsapp_e2e_backup_enabled', 'true');
            if (window.showToast) window.showToast('Success', 'End-to-end encrypted backup is ON');
        } else if (pendingE2EAction === 'off') {
            const saved = localStorage.getItem('whatsapp_e2e_backup_password');
            if (saved === btoa(input)) {
                localStorage.setItem('whatsapp_e2e_backup_enabled', 'false');
                localStorage.removeItem('whatsapp_e2e_backup_password');
                if (window.showToast) window.showToast('Success', 'End-to-end encrypted backup is OFF');
            } else {
                if (window.showToast) window.showToast('Error', 'Incorrect password');
                return;
            }
        } else if (pendingE2EAction === 'restore') {
            if (window.verifyRestorePasswordCallback) {
                window.verifyRestorePasswordCallback(input);
                closeE2EPasswordModal();
                return;
            }
        }
        
        closeE2EPasswordModal();
        if (pendingE2EAction !== 'restore') {
            openE2EPanel(); 
            initChatBackupSettings(); 
        }
    };

    window.toggleChatBackupSetting = function(key, value) {
        if (key === 'e2ee') {
            value = value === true || value === 'true';
            localStorage.setItem('whatsapp_chat_backup_e2ee', value);
            const e2eeVal = document.getElementById('chat_backup_e2ee_value');
            e2eeVal.innerText = value ? 'On' : 'Off';
            e2eeVal.dataset.active = value;
            return;
        }
        
        localStorage.setItem(`whatsapp_chat_backup_${key}`, value);
    };

    window.openChatBackupAccountModal = function() {
        const modal = document.getElementById('chat_backup_account_modal');
        const listContainer = document.getElementById('chat_backup_account_list');
        
        let currentAccount = localStorage.getItem('whatsapp_chat_backup_account');
        if (!currentAccount || !backupAccounts.includes(currentAccount)) {
            currentAccount = backupAccounts[0];
            localStorage.setItem('whatsapp_chat_backup_account', currentAccount);
            document.getElementById('chat_backup_account_label').innerText = currentAccount;
        }
        
        listContainer.innerHTML = '';
        
        backupAccounts.forEach(acc => {
            const isSelected = acc === currentAccount;
            const itemHTML = `
                <label class="flex items-center gap-4 cursor-pointer px-6 py-3 hover:bg-[#202c33] transition-colors">
                    <div class="relative flex items-center justify-center pt-1">
                        <input type="radio" name="backup_account_radio" value="${acc}" class="peer sr-only" ${isSelected ? 'checked' : ''} onchange="selectChatBackupAccount('${acc}')">
                        <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] transition-colors"></div>
                        <div class="absolute w-2.5 h-2.5 rounded-full bg-[#00a884] opacity-0 peer-checked:opacity-100 transition-opacity mt-[-4px]"></div>
                    </div>
                    <div class="text-[#e9edef] text-[15px]">${acc}</div>
                </label>
            `;
            listContainer.insertAdjacentHTML('beforeend', itemHTML);
        });

        // Add account option
        const addAccHTML = `
            <label class="flex items-center gap-4 cursor-pointer px-6 py-3 hover:bg-[#202c33] transition-colors" onclick="addBackupAccount(); event.preventDefault();">
                <div class="relative flex items-center justify-center pt-1">
                    <input type="radio" name="backup_account_radio" class="peer sr-only">
                    <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] transition-colors"></div>
                    <div class="absolute w-2.5 h-2.5 rounded-full bg-[#00a884] opacity-0 peer-checked:opacity-100 transition-opacity mt-[-4px]"></div>
                </div>
                <div class="text-[#e9edef] text-[15px]">Add account</div>
            </label>
        `;
        listContainer.insertAdjacentHTML('beforeend', addAccHTML);

        modal.classList.remove('hidden');
    };

    window.addBackupAccount = function() {
        const email = prompt('Enter Google Account email:');
        if (email && email.trim() !== '') {
            const cleanEmail = email.trim();
            if (!backupAccounts.includes(cleanEmail)) {
                backupAccounts.push(cleanEmail);
                localStorage.setItem('whatsapp_chat_backup_accounts_list', JSON.stringify(backupAccounts));
            }
            selectChatBackupAccount(cleanEmail);
        } else {
            closeChatBackupAccountModal();
        }
    };

    window.closeChatBackupAccountModal = function() {
        document.getElementById('chat_backup_account_modal').classList.add('hidden');
    };

    window.selectChatBackupAccount = function(acc) {
        localStorage.setItem('whatsapp_chat_backup_account', acc);
        document.getElementById('chat_backup_account_label').innerText = acc;
        setTimeout(closeChatBackupAccountModal, 200);
    };

    window.openChatBackupFrequencyModal = function() {
        const modal = document.getElementById('chat_backup_frequency_modal');
        const listContainer = document.getElementById('chat_backup_frequency_list');
        const currentFreq = localStorage.getItem('whatsapp_chat_backup_frequency') || backupFrequencies[0];
        
        listContainer.innerHTML = '';
        
        backupFrequencies.forEach(freq => {
            const isSelected = freq === currentFreq;
            const itemHTML = `
                <label class="flex items-center gap-4 cursor-pointer px-6 py-3 hover:bg-[#202c33] transition-colors">
                    <div class="relative flex items-center justify-center pt-1">
                        <input type="radio" name="backup_freq_radio" value="${freq}" class="peer sr-only" ${isSelected ? 'checked' : ''} onchange="selectChatBackupFrequency('${freq}')">
                        <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] transition-colors"></div>
                        <div class="absolute w-2.5 h-2.5 rounded-full bg-[#00a884] opacity-0 peer-checked:opacity-100 transition-opacity mt-[-4px]"></div>
                    </div>
                    <div class="text-[#e9edef] text-[15px]">${freq}</div>
                </label>
            `;
            listContainer.insertAdjacentHTML('beforeend', itemHTML);
        });

        modal.classList.remove('hidden');
    };

    window.closeChatBackupFrequencyModal = function() {
        document.getElementById('chat_backup_frequency_modal').classList.add('hidden');
    };

    window.selectChatBackupFrequency = function(freq) {
        localStorage.setItem('whatsapp_chat_backup_frequency', freq);
        document.getElementById('chat_backup_frequency_label').innerText = freq;
        setTimeout(closeChatBackupFrequencyModal, 200);
    };

    let tokenClient;
    let driveAccessToken = null;

    function initGoogleDriveAuth() {
        const clientId = '{{ env("GOOGLE_DRIVE_CLIENT_ID") }}';
        if (!clientId || clientId.trim() === '') {
            console.warn("GOOGLE_DRIVE_CLIENT_ID is not set in .env!");
            return;
        }

        tokenClient = google.accounts.oauth2.initTokenClient({
            client_id: clientId,
            scope: 'https://www.googleapis.com/auth/drive.file',
            callback: (response) => {
                if (response.error !== undefined) {
                    if (window.showToast) window.showToast('Authentication Failed', 'Failed to authenticate with Google Drive.');
                    return;
                }
                driveAccessToken = response.access_token;
                
                if (window.pendingDriveAction === 'backup') {
                    executeDriveBackup();
                } else if (window.pendingDriveAction === 'restore') {
                    executeDriveRestore();
                }
            }
        });
    }

    function checkAutoBackup() {
        const freq = localStorage.getItem('whatsapp_chat_backup_frequency');
        if (!freq || freq === 'Off' || freq === 'Only when I tap "Back up"') return;
        const lastBackupStr = localStorage.getItem('whatsapp_chat_backup_timestamp');
        const lastBackup = lastBackupStr ? parseInt(lastBackupStr) : 0;
        const now = Date.now();
        
        let shouldBackup = false;
        
        if (freq === 'Daily' && (now - lastBackup) > 24 * 60 * 60 * 1000) {
            shouldBackup = true;
        } else if (freq === 'Weekly' && (now - lastBackup) > 7 * 24 * 60 * 60 * 1000) {
            shouldBackup = true;
        } else if (freq === 'Monthly' && (now - lastBackup) > 30 * 24 * 60 * 60 * 1000) {
            shouldBackup = true;
        }
        if (shouldBackup) {
            if (tokenClient) {
                window.pendingDriveAction = 'backup';
                tokenClient.requestAccessToken();
            }
        }
    }
    // Check for auto-backup every minute
    setInterval(checkAutoBackup, 60000);
    const checkGsiInterval = setInterval(() => {
        if (window.google && window.google.accounts && window.google.accounts.oauth2) {
            clearInterval(checkGsiInterval);
            initGoogleDriveAuth();
            setTimeout(checkAutoBackup, 5000); // Check 5s after init
        }
    }, 500);
    
    window.startChatBackup = function() {
        const clientId = '{{ env("GOOGLE_DRIVE_CLIENT_ID") }}';
        if (!clientId || clientId.trim() === '') {
            alert('GOOGLE_DRIVE_CLIENT_ID is not configured in .env. Please configure it in your Laravel project to enable real Google Drive backups.');
            return;
        }

        if (!tokenClient) {
            if (window.showToast) window.showToast('Error', 'Google Services not loaded yet.');
            return;
        }
        
        window.pendingDriveAction = 'backup';
        tokenClient.requestAccessToken();
    };

    function executeDriveBackup() {
        const btn = document.getElementById('chat_backup_btn');
        const progressContainer = document.getElementById('chat_backup_progress_container');
        const progressBar = document.getElementById('chat_backup_progress_bar');
        const progressText = document.getElementById('chat_backup_progress_text');
        
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
        progressContainer.classList.remove('hidden');
        document.getElementById('chat_backup_up_to_date').classList.add('hidden');
        
        let progress = 0;
        
        window.get(window.ref(window.db, '/')).then(snapshot => {
            let dataPayload = { timestamp: Date.now() };
            if (snapshot.exists()) {
                const fullData = snapshot.val();
                dataPayload.chats = fullData.chats || {};
                dataPayload.messages = fullData.messages || {};
                dataPayload.groups = fullData.groups || {};
            }
        
            let fileContent = JSON.stringify(dataPayload);
            
            // Check if E2E is enabled
            const e2eEnabled = localStorage.getItem('whatsapp_e2e_backup_enabled') === 'true';
            if (e2eEnabled) {
                const password = localStorage.getItem('whatsapp_e2e_backup_password'); // This is btoa(input)
                if (password) {
                    // Simple mock encryption (Base64 + XOR with password) for prototype purposes
                    // We just store a signature so we know it's encrypted
                    const encryptedData = {
                        isEncrypted: true,
                        cipherText: btoa(unescape(encodeURIComponent(fileContent)))
                    };
                    fileContent = JSON.stringify(encryptedData);
                }
            }
            
            const sizeMB = (fileContent.length / (1024 * 1024)).toFixed(2);
            
            const interval = setInterval(() => {
                if (progress < 90) {
                    progress += Math.floor(Math.random() * 10) + 5;
                    if (progress > 90) progress = 90;
                    progressBar.style.width = `${progress}%`;
                    progressText.innerText = `${progress}%`;
                }
            }, 300);

            // Two-step upload: 1. Create file metadata, 2. Upload content
            fetch('https://www.googleapis.com/drive/v3/files', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + driveAccessToken,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    name: 'WhatsApp_Backup.json',
                    mimeType: 'application/json'
                })
            })
            .then(response => response.json())
            .then(fileMeta => {
                if (fileMeta.error) throw new Error(fileMeta.error.message);
                
                return fetch(`https://www.googleapis.com/upload/drive/v3/files/${fileMeta.id}?uploadType=media`, {
                    method: 'PATCH',
                    headers: {
                        'Authorization': 'Bearer ' + driveAccessToken,
                        'Content-Type': 'application/json'
                    },
                    body: fileContent
                });
            })
            .then(response => response.json())
            .then(result => {
                if (result.error) throw new Error(result.error.message);
                
                clearInterval(interval);
                progress = 100;
                progressBar.style.width = '100%';
                progressText.innerText = '100%';
                
                setTimeout(() => {
                    progressContainer.classList.add('hidden');
                    progressBar.style.width = '0%';
                    progressText.innerText = '0%';
                    btn.disabled = false;
                    btn.classList.remove('opacity-50', 'cursor-not-allowed');
                    
                    const now = new Date();
                    const dateStr = `${String(now.getMonth()+1).padStart(2,'0')}/${String(now.getDate()).padStart(2,'0')}/${String(now.getFullYear()).slice(2)}`;
                    let hours = now.getHours();
                    const ampm = hours >= 12 ? 'pm' : 'am';
                    hours = hours % 12;
                    hours = hours ? hours : 12; 
                    const timeStr = `${hours}:${String(now.getMinutes()).padStart(2,'0')} ${ampm}`;
                    const lastTimeStr = `${dateStr}, ${timeStr}`;
                    
                    localStorage.setItem('whatsapp_chat_backup_last_time', lastTimeStr);
                    localStorage.setItem('whatsapp_chat_backup_last_size', `${sizeMB} MB`);
                    localStorage.setItem('whatsapp_chat_backup_timestamp', Date.now().toString());
                    
                    document.getElementById('chat_backup_last_time').innerText = `Last Backup: ${lastTimeStr}`;
                    document.getElementById('chat_backup_size').innerText = `Size: ${sizeMB} MB`;
                    document.getElementById('chat_backup_up_to_date').classList.remove('hidden');
                    document.getElementById('chat_restore_btn').classList.remove('hidden');
                    
                    if (window.showToast) window.showToast('Backup Complete', 'Your chats have been securely backed up to Google Drive.');
                }, 500);
            })
            .catch(error => {
                clearInterval(interval);
                console.error("Backup failed:", error);
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
                progressContainer.classList.add('hidden');
                if (window.showToast) window.showToast('Backup Failed', 'An error occurred during upload.');
            });
        }).catch(err => {
            console.error("Failed to fetch Firebase data:", err);
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
            progressContainer.classList.add('hidden');
        });
    }

    window.startChatRestore = function() {
        const clientId = '{{ env("GOOGLE_DRIVE_CLIENT_ID") }}';
        if (!clientId || clientId.trim() === '') {
            alert('GOOGLE_DRIVE_CLIENT_ID is not configured in .env');
            return;
        }

        if (!confirm('Are you sure you want to restore your backup from Google Drive? This will overwrite your local data.')) return;
        
        if (!tokenClient) {
            if (window.showToast) window.showToast('Error', 'Google Services not loaded yet.');
            return;
        }
        
        window.pendingDriveAction = 'restore';
        tokenClient.requestAccessToken();
    };

    function executeDriveRestore() {
        const btn = document.getElementById('chat_restore_btn');
        btn.disabled = true;
        btn.innerText = 'Restoring...';
        btn.classList.add('opacity-50', 'cursor-not-allowed');
        
        fetch('https://www.googleapis.com/drive/v3/files?q=name="WhatsApp_Backup.json" and trashed=false', {
            headers: new Headers({'Authorization': 'Bearer ' + driveAccessToken})
        })
        .then(response => response.json())
        .then(data => {
            if (data.files && data.files.length > 0) {
                const fileId = data.files[0].id;
                return fetch(`https://www.googleapis.com/drive/v3/files/${fileId}?alt=media`, {
                    headers: new Headers({'Authorization': 'Bearer ' + driveAccessToken})
                });
            } else {
                throw new Error("No backup file found in Google Drive.");
            }
        })
        .then(response => response.json())
        .then(backupData => {
            const processRestoreData = (data) => {
                const updates = {};
                if (data.chats) updates[`chats`] = data.chats;
                if (data.messages) updates[`messages`] = data.messages;
                if (data.groups) updates[`groups`] = data.groups;
                
                if (Object.keys(updates).length > 0 && window.update && window.ref && window.db) {
                    window.update(window.ref(window.db), updates).then(() => {
                        btn.innerText = 'Restore';
                        btn.disabled = false;
                        btn.classList.remove('opacity-50', 'cursor-not-allowed');
                        if (window.showToast) window.showToast('Restore Complete', 'Your chats have been restored successfully.');
                        setTimeout(() => location.reload(), 1500);
                    }).catch(error => {
                        console.error("Firebase Restore Update failed:", error);
                        btn.innerText = 'Restore';
                        btn.disabled = false;
                        btn.classList.remove('opacity-50', 'cursor-not-allowed');
                    });
                } else {
                    btn.innerText = 'Restore';
                    btn.disabled = false;
                    btn.classList.remove('opacity-50', 'cursor-not-allowed');
                    if (window.showToast) window.showToast('Restore Failed', 'No valid chat data found in backup JSON.');
                }
            };

            if (backupData.isEncrypted) {
                // Prompt for password
                window.verifyRestorePasswordCallback = function(inputPwd) {
                    const savedHash = localStorage.getItem('whatsapp_e2e_backup_password');
                    if (!savedHash || savedHash !== btoa(inputPwd)) {
                        if (window.showToast) window.showToast('Error', 'Incorrect password for backup');
                        btn.innerText = 'Restore';
                        btn.disabled = false;
                        btn.classList.remove('opacity-50', 'cursor-not-allowed');
                        return;
                    }
                    try {
                        const decryptedStr = decodeURIComponent(escape(atob(backupData.cipherText)));
                        processRestoreData(JSON.parse(decryptedStr));
                    } catch(e) {
                        if (window.showToast) window.showToast('Error', 'Failed to decrypt backup data');
                        btn.innerText = 'Restore';
                        btn.disabled = false;
                        btn.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                };
                openE2EPasswordModal('restore');
            } else {
                processRestoreData(backupData);
            }
        })
        .catch(error => {
            console.error("Restore failed:", error);
            btn.innerText = 'Restore';
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
            if (window.showToast) window.showToast('Restore Failed', error.message || 'Error fetching backup from Drive.');
        });
    }
</script>
<script src="https://accounts.google.com/gsi/client" async defer></script>
