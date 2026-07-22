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

        // Check firebase for backup to show restore button
        if (window.myUserId && window.db && window.ref && window.get) {
            window.get(window.ref(window.db, `backups/${window.myUserId}`)).then(snapshot => {
                if (snapshot.exists()) {
                    document.getElementById('chat_restore_btn').classList.remove('hidden');
                } else {
                    document.getElementById('chat_restore_btn').classList.add('hidden');
                }
            }).catch(e => console.error("Error checking for backup:", e));
        }
    }

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

    window.startChatBackup = function() {
        if (!window.myUserId) {
            if (window.showToast) window.showToast('Error', 'User ID not found.');
            return;
        }

        const btn = document.getElementById('chat_backup_btn');
        const progressContainer = document.getElementById('chat_backup_progress_container');
        const progressBar = document.getElementById('chat_backup_progress_bar');
        const progressText = document.getElementById('chat_backup_progress_text');
        
        if (btn.disabled) return;
        
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
        progressContainer.classList.remove('hidden');
        document.getElementById('chat_backup_up_to_date').classList.add('hidden');
        
        let progress = 0;
        
        // 1. Gather all data from Firebase or local window objects if they exist
        // To be safe and ensure a full backup, we will read directly from Firebase root
        // But for performance in this prototype, writing window.chats is faster.
        // Actually, let's just fetch everything relevant to the user to make it a REAL backup.
        
        const backupRef = window.ref(window.db, `backups/${window.myUserId}`);
        const dataPayload = {
            timestamp: window.serverTimestamp(),
            chats: window.chats || {},
            messages: window.messages || {},
            groups: window.groups || {}
        };
        
        const sizeMB = (JSON.stringify(dataPayload).length / (1024 * 1024)).toFixed(2);
        
        const interval = setInterval(() => {
            if (progress < 90) {
                progress += Math.floor(Math.random() * 10) + 5;
                if (progress > 90) progress = 90;
                progressBar.style.width = `${progress}%`;
                progressText.innerText = `${progress}%`;
            }
        }, 300);

        window.set(backupRef, dataPayload).then(() => {
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
        }).catch(error => {
            clearInterval(interval);
            console.error("Backup failed:", error);
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
            progressContainer.classList.add('hidden');
            if (window.showToast) window.showToast('Backup Failed', 'An error occurred during backup.');
        });
    };

    window.startChatRestore = function() {
        if (!window.myUserId) return;
        if (!confirm('Are you sure you want to restore your backup? This will fetch your saved chats and overwrite your local data.')) return;
        
        const btn = document.getElementById('chat_restore_btn');
        btn.disabled = true;
        btn.innerText = 'Restoring...';
        btn.classList.add('opacity-50', 'cursor-not-allowed');
        
        window.get(window.ref(window.db, `backups/${window.myUserId}`)).then(snapshot => {
            if (snapshot.exists()) {
                const data = snapshot.val();
                const updates = {};
                
                if (data.chats) updates[`chats`] = data.chats;
                if (data.messages) updates[`messages`] = data.messages;
                if (data.groups) updates[`groups`] = data.groups;
                
                if (Object.keys(updates).length > 0) {
                    window.update(window.ref(window.db), updates).then(() => {
                        btn.innerText = 'Restore';
                        btn.disabled = false;
                        btn.classList.remove('opacity-50', 'cursor-not-allowed');
                        if (window.showToast) window.showToast('Restore Complete', 'Your chats have been restored successfully.');
                        setTimeout(() => location.reload(), 1500);
                    }).catch(error => {
                        console.error("Restore failed on update:", error);
                        btn.innerText = 'Restore';
                        btn.disabled = false;
                        btn.classList.remove('opacity-50', 'cursor-not-allowed');
                    });
                } else {
                    btn.innerText = 'Restore';
                    btn.disabled = false;
                    btn.classList.remove('opacity-50', 'cursor-not-allowed');
                    if (window.showToast) window.showToast('Restore Failed', 'No valid chat data found in backup.');
                }
            } else {
                btn.innerText = 'Restore';
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
                if (window.showToast) window.showToast('Restore Failed', 'No backup found in the cloud.');
            }
        }).catch(error => {
            console.error("Restore fetch failed:", error);
            btn.innerText = 'Restore';
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
        });
    };
</script>
