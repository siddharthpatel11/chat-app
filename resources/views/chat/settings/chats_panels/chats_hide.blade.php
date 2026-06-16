<div id="chats_hide_panel"
    class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center justify-between shrink-0 border-b border-[#313d45]">
        <div class="flex items-center gap-6">
            <button onclick="toggleHideChatPanel()" class="text-[#aebac1] hover:text-white transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
                </svg>
            </button>
            <h2 class="text-[#e9edef] text-[19px] font-semibold">Hide Chat</h2>
        </div>
        <!-- 3-Dot Menu Button (Visible in MANAGE state) -->
        <div class="relative">
            <button id="hide_chat_menu_btn" onclick="toggleHideChatHeaderMenu(event)" class="text-[#aebac1] hover:text-white transition-colors focus:outline-none hidden">
                <svg viewBox="0 0 24 24" height="24" width="24" fill="currentColor">
                    <path d="M12 7a2 2 0 1 0-.001-4.001A2 2 0 0 0 12 7zm0 2a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 9zm0 6a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 15z"></path>
                </svg>
            </button>
            <!-- Dropdown -->
            <div id="hide_chat_header_dropdown" class="hidden absolute right-0 top-10 w-44 bg-[#233138] rounded-lg shadow-xl border border-[#313d45] py-2 z-50 transform origin-top-right transition-all">
                <button onclick="window.openChangePasswordModal(event)" class="w-full text-left px-4 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-sm">
                    Change Password
                </button>
            </div>
        </div>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] py-4 px-6 flex flex-col h-full relative z-10">
        
        <!-- STATE 1: SETUP (No Password Set) -->
        <div id="hide_chat_state_setup" class="hidden flex flex-col gap-4">
            <h3 class="text-[#e9edef] text-[16px] font-medium mb-1">Set Hide Chat Password</h3>
            <p class="text-[#8696a0] text-[13px]">Create a password to secure your hidden chats. This password is separate from your App Lock.</p>
            
            <div class="space-y-3 mt-2">
                <input type="password" id="hide_chat_setup_pwd" placeholder="Enter password (min 6 chars)" 
                    class="w-full bg-[#202c33] border-none text-[#e9edef] px-4 py-2.5 rounded-lg focus:ring-2 focus:ring-[#00a884]/50 outline-none text-sm placeholder-[#8696a0]">
                
                <input type="password" id="hide_chat_setup_confirm" placeholder="Confirm password" 
                    class="w-full bg-[#202c33] border-none text-[#e9edef] px-4 py-2.5 rounded-lg focus:ring-2 focus:ring-[#00a884]/50 outline-none text-sm placeholder-[#8696a0]">
                
                <p id="hide_chat_setup_error" class="text-red-500 text-xs hidden">Passwords do not match or are too short.</p>
                
                <button onclick="saveHideChatPassword()" 
                    class="w-full bg-[#00a884] text-[#111b21] font-semibold text-sm py-2.5 rounded-full hover:bg-[#06cf9c] transition-colors shadow-lg mt-4">
                    Create Password
                </button>
            </div>
        </div>

        <!-- STATE 2: UNLOCK (Password exists, need verification) -->
        <div id="hide_chat_state_unlock" class="hidden flex flex-col gap-4">
            <div class="flex justify-center my-4 text-[#00a884]">
                <svg viewBox="0 0 24 24" height="48" width="48" fill="currentColor">
                    <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"></path>
                </svg>
            </div>
            <h3 class="text-[#e9edef] text-[16px] text-center font-medium">Unlock Hidden Chats</h3>
            <p class="text-[#8696a0] text-[13px] text-center">Enter your hide chat password to manage or view hidden chats.</p>
            
            <div class="space-y-3 mt-2">
                <input type="password" id="hide_chat_unlock_pwd" placeholder="Enter password" 
                    class="w-full bg-[#202c33] border-none text-[#e9edef] px-4 py-2.5 rounded-lg focus:ring-2 focus:ring-[#00a884]/50 outline-none text-sm placeholder-[#8696a0] text-center">
                
                <p id="hide_chat_unlock_error" class="text-red-500 text-xs hidden text-center">Incorrect password.</p>
                
                <button onclick="unlockHideChatPanel()" 
                    class="w-full bg-[#00a884] text-[#111b21] font-semibold text-sm py-2.5 rounded-full hover:bg-[#06cf9c] transition-colors shadow-lg mt-2">
                    Unlock
                </button>
            </div>
        </div>

        <!-- STATE 3: MANAGE (Unlocked) -->
        <div id="hide_chat_state_manage" class="hidden flex flex-col gap-6">
            
            <!-- Hide a new chat -->
            <div class="flex flex-col gap-2 bg-[#202c33]/40 p-4 rounded-xl border border-white/5">
                <h4 class="text-[#00a884] text-xs font-semibold uppercase tracking-wider">Hide a chat</h4>
                <div class="flex gap-2 mt-2">
                    <select id="chat_to_hide_select" 
                        class="flex-1 bg-[#202c33] border-none text-[#e9edef] text-sm rounded-lg px-3 py-2 focus:ring-1 focus:ring-[#00a884] outline-none">
                        <option value="" disabled selected>Select a chat...</option>
                    </select>
                    <button onclick="hideSelectedChat()" 
                        class="bg-[#00a884] text-[#111b21] px-4 py-2 rounded-lg text-sm font-semibold hover:bg-[#06cf9c] transition-colors">
                        Hide
                    </button>
                </div>
            </div>

            <!-- List of Hidden Chats -->
            <div class="flex flex-col gap-2">
                <h4 class="text-[#8696a0] text-xs font-semibold uppercase tracking-wider">Hidden Chats</h4>
                <div id="hidden_chats_list" class="space-y-2 mt-2">
                    <!-- Populated dynamically -->
                </div>
                <div id="no_hidden_chats_msg" class="text-[#8696a0] text-sm py-4 text-center hidden">
                    No hidden chats yet.
                </div>
            </div>

        </div>

    </div>
</div>

<!-- Modal for changing hide chat password -->
<div id="hide_chat_change_pwd_modal" class="hidden fixed inset-0 z-[3000] flex items-center justify-center bg-black/60 backdrop-blur-sm transition-all duration-300">
    <div class="bg-[#233138] w-[90%] max-w-[340px] rounded-2xl p-6 shadow-2xl transform scale-95 transition-all duration-300 opacity-0" id="hide_chat_change_pwd_content">
        <h3 class="text-[#e9edef] text-[18px] font-medium mb-4 text-center">Change Password</h3>
        
        <div class="space-y-3">
            <input type="password" id="hide_chat_change_current" placeholder="Current Password" 
                class="w-full bg-[#111b21] border border-transparent focus:border-[#00a884] text-[#e9edef] px-4 py-2.5 rounded-lg outline-none transition-colors text-sm">
            <input type="password" id="hide_chat_change_new" placeholder="New Password (min 6 chars)" 
                class="w-full bg-[#111b21] border border-transparent focus:border-[#00a884] text-[#e9edef] px-4 py-2.5 rounded-lg outline-none transition-colors text-sm">
            <input type="password" id="hide_chat_change_confirm" placeholder="Confirm New Password" 
                class="w-full bg-[#111b21] border border-transparent focus:border-[#00a884] text-[#e9edef] px-4 py-2.5 rounded-lg outline-none transition-colors text-sm">
        </div>
        
        <p id="hide_chat_change_error" class="text-red-500 text-xs hidden text-center mt-3"></p>
        
        <div class="flex justify-between gap-3 mt-6">
            <button onclick="window.closeChangePasswordModal()" class="flex-1 bg-[#2a3942] hover:bg-[#3b4a54] text-[#e9edef] font-medium text-[14px] py-2.5 rounded-full transition-colors">Cancel</button>
            <button onclick="changeHideChatPassword()" class="flex-1 bg-[#00a884] text-[#111b21] font-semibold text-[14px] py-2.5 rounded-full hover:bg-[#06cf9c] transition-colors">Update</button>
        </div>
    </div>
</div>

<!-- Modal for checking password when clicking a hidden chat from search -->
<div id="hidden_chat_click_unlock_modal" class="hidden fixed inset-0 z-[3000] flex items-center justify-center bg-black/60 backdrop-blur-sm transition-all duration-300">
    <div class="bg-[#233138] w-[90%] max-w-[320px] rounded-2xl p-6 shadow-2xl transform scale-95 transition-all duration-300 opacity-0" id="hidden_chat_click_unlock_content">
        <div class="flex justify-center mb-4 text-[#00a884]">
            <svg viewBox="0 0 24 24" height="32" width="32" fill="currentColor">
                <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"></path>
            </svg>
        </div>
        <h3 class="text-[#e9edef] text-[18px] font-medium mb-4 text-center">Unlock Hide Chat</h3>
        <p class="text-[#8696a0] text-[14px] mb-6 text-center">Enter your hide chat password to view this chat.</p>
        
        <div class="w-full relative mb-4">
            <input type="password" id="hidden_chat_click_pwd" placeholder="Password" class="w-full bg-[#111b21] border border-transparent focus:border-[#00a884] text-[#e9edef] px-4 py-2.5 rounded-lg outline-none transition-colors text-[15px] text-center">
        </div>
        
        <p id="hidden_chat_click_error" class="text-red-500 text-[13px] hidden text-center mb-4">Incorrect password.</p>
        
        <div class="flex justify-between gap-3 mt-6">
            <button onclick="window.closeHiddenChatClickUnlockModal()" class="flex-1 bg-[#2a3942] hover:bg-[#3b4a54] text-[#e9edef] font-medium text-[14px] py-2 rounded-full transition-colors">Cancel</button>
            <button onclick="window.verifyHiddenChatClickUnlock()" class="flex-1 bg-[#00a884] text-[#111b21] font-medium text-[14px] py-2 rounded-full hover:bg-[#06cf9c] transition-colors">Unlock</button>
        </div>
    </div>
</div>

<script>
    // Local state variables
    window.hiddenChats = JSON.parse(localStorage.getItem('hidden_chats') || '[]');
    let isHideChatPanelUnlocked = false;
    let pendingChatSelectionCallback = null;

    // Helper functions
    async function hashHidePassword(password) {
        const msgBuffer = new TextEncoder().encode(password);
        const hashBuffer = await crypto.subtle.digest('SHA-256', msgBuffer);
        const hashArray = Array.from(new Uint8Array(hashBuffer));
        return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
    }

    window.toggleHideChatPanel = function() {
        const panel = document.getElementById('chats_hide_panel');
        const chatsPanel = document.getElementById('chats_settings_panel');
        
        // Hide dropdown menu if open
        document.getElementById('hide_chat_header_dropdown')?.classList.add('hidden');
        
        if (panel.classList.contains('hidden')) {
            isHideChatPanelUnlocked = false; // Always require password when opening
            
            panel.classList.remove('hidden');
            panel.classList.add('flex');
            if (chatsPanel) chatsPanel.classList.add('hidden');
            
            // Check if password exists
            const hasPassword = localStorage.getItem('hide_chat_pwd_hash');
            if (!hasPassword) {
                switchHideChatState('SETUP');
            } else {
                switchHideChatState('UNLOCK');
            }
        } else {
            panel.classList.add('hidden');
            panel.classList.remove('flex');
            if (chatsPanel) chatsPanel.classList.remove('hidden');
            // reset unlock state on close
            isHideChatPanelUnlocked = false;
        }
    };

    window.toggleHideChatHeaderMenu = function(event) {
        event.stopPropagation();
        const dd = document.getElementById('hide_chat_header_dropdown');
        if (dd) {
            dd.classList.toggle('hidden');
        }
    };

    // Close header menu when clicking outside
    document.addEventListener('click', function(e) {
        const dd = document.getElementById('hide_chat_header_dropdown');
        const btn = document.getElementById('hide_chat_menu_btn');
        if (dd && !dd.classList.contains('hidden') && btn && !btn.contains(e.target) && !dd.contains(e.target)) {
            dd.classList.add('hidden');
        }
    });

    window.openChangePasswordModal = function(event) {
        if (event) event.stopPropagation();
        document.getElementById('hide_chat_header_dropdown')?.classList.add('hidden');
        
        document.getElementById('hide_chat_change_current').value = '';
        document.getElementById('hide_chat_change_new').value = '';
        document.getElementById('hide_chat_change_confirm').value = '';
        document.getElementById('hide_chat_change_error').classList.add('hidden');
        
        const modal = document.getElementById('hide_chat_change_pwd_modal');
        const content = document.getElementById('hide_chat_change_pwd_content');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('opacity-100');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
            document.getElementById('hide_chat_change_current').focus();
        }, 10);
    };

    window.closeChangePasswordModal = function() {
        const modal = document.getElementById('hide_chat_change_pwd_modal');
        const content = document.getElementById('hide_chat_change_pwd_content');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.remove('opacity-100');
            modal.classList.add('hidden');
        }, 300);
    };

    function switchHideChatState(state) {
        document.getElementById('hide_chat_state_setup').classList.add('hidden');
        document.getElementById('hide_chat_state_unlock').classList.add('hidden');
        document.getElementById('hide_chat_state_manage').classList.add('hidden');
        
        const menuBtn = document.getElementById('hide_chat_menu_btn');
        
        if (state === 'SETUP') {
            document.getElementById('hide_chat_state_setup').classList.remove('hidden');
            document.getElementById('hide_chat_setup_pwd').value = '';
            document.getElementById('hide_chat_setup_confirm').value = '';
            document.getElementById('hide_chat_setup_error').classList.add('hidden');
            if (menuBtn) menuBtn.classList.add('hidden');
        } else if (state === 'UNLOCK') {
            document.getElementById('hide_chat_state_unlock').classList.remove('hidden');
            document.getElementById('hide_chat_unlock_pwd').value = '';
            document.getElementById('hide_chat_unlock_error').classList.add('hidden');
            if (menuBtn) menuBtn.classList.add('hidden');
            setTimeout(() => document.getElementById('hide_chat_unlock_pwd').focus(), 100);
        } else if (state === 'MANAGE') {
            document.getElementById('hide_chat_state_manage').classList.remove('hidden');
            if (menuBtn) menuBtn.classList.remove('hidden');
            populateChatsToHideDropdown();
            renderHiddenChatsList();
        }
    }

    window.saveHideChatPassword = async function() {
        const pwd = document.getElementById('hide_chat_setup_pwd').value;
        const confirmPwd = document.getElementById('hide_chat_setup_confirm').value;
        const errEl = document.getElementById('hide_chat_setup_error');
        
        if (pwd.length < 6) {
            errEl.textContent = 'Password must be at least 6 characters long.';
            errEl.classList.remove('hidden');
            return;
        }
        if (pwd !== confirmPwd) {
            errEl.textContent = 'Passwords do not match.';
            errEl.classList.remove('hidden');
            return;
        }
        
        const hash = await hashHidePassword(pwd);
        localStorage.setItem('hide_chat_pwd_hash', hash);
        isHideChatPanelUnlocked = true;
        switchHideChatState('MANAGE');
        window.showToast?.('Password Created', 'Hide Chat password set successfully.');
    };

    window.unlockHideChatPanel = async function() {
        const pwd = document.getElementById('hide_chat_unlock_pwd').value;
        const errEl = document.getElementById('hide_chat_unlock_error');
        const storedHash = localStorage.getItem('hide_chat_pwd_hash');
        
        const hash = await hashHidePassword(pwd);
        if (hash === storedHash) {
            isHideChatPanelUnlocked = true;
            switchHideChatState('MANAGE');
        } else {
            errEl.classList.remove('hidden');
            document.getElementById('hide_chat_unlock_pwd').value = '';
            document.getElementById('hide_chat_unlock_pwd').focus();
        }
    };

    // Listen to Enter key in Unlock state
    document.getElementById('hide_chat_unlock_pwd').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            window.unlockHideChatPanel();
        }
    });

    function populateChatsToHideDropdown() {
        const select = document.getElementById('chat_to_hide_select');
        if (!select) return;
        select.innerHTML = '<option value="" disabled selected>Select a chat...</option>';
        
        const items = document.querySelectorAll('#user_list_container .user-chat-item');
        let count = 0;
        items.forEach(item => {
            if (item.id === 'user_sidebar_meta_ai') return;
            if (!window.hiddenChats.includes(item.id)) {
                const name = item.getAttribute('data-name') || 'Unnamed Chat';
                const isGroup = item.id.startsWith('group_sidebar_');
                const opt = document.createElement('option');
                opt.value = item.id;
                opt.textContent = name + (isGroup ? ' (Group)' : '');
                select.appendChild(opt);
                count++;
            }
        });
    }

    function renderHiddenChatsList() {
        const listContainer = document.getElementById('hidden_chats_list');
        const noMsg = document.getElementById('no_hidden_chats_msg');
        if (!listContainer) return;
        
        listContainer.innerHTML = '';
        
        if (window.hiddenChats.length === 0) {
            noMsg.classList.remove('hidden');
            return;
        }
        noMsg.classList.add('hidden');
        
        window.hiddenChats.forEach(id => {
            const isGroup = id.startsWith('group_sidebar_');
            const targetId = id.replace('user_sidebar_', '').replace('group_sidebar_', '');
            
            // Try to find matching element in sidebar or cache
            const sidebarEl = document.getElementById(id);
            let name = 'Unnamed Chat';
            let avatar = 'https://ui-avatars.com/api/?background=2a3942&color=fff&name=Chat';
            
            if (sidebarEl) {
                name = sidebarEl.getAttribute('data-name') || name;
                avatar = sidebarEl.getAttribute('data-avatar') || avatar;
            }
            
            const itemHtml = `
                <div class="flex items-center justify-between p-2 bg-[#202c33]/30 rounded-lg border border-white/5">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-9 h-9 rounded-full overflow-hidden bg-[#2a3942] shrink-0">
                            <img src="${avatar}" class="w-full h-full object-cover">
                        </div>
                        <span class="text-[#e9edef] text-sm font-normal truncate">${name}</span>
                    </div>
                    <button onclick="unhideChat('${id}')" 
                        class="text-[#00a884] hover:text-[#06cf9c] text-xs font-semibold px-2 py-1 hover:bg-[#00a884]/10 rounded transition-colors shrink-0">
                        Unhide
                    </button>
                </div>
            `;
            listContainer.insertAdjacentHTML('beforeend', itemHtml);
        });
    }

    window.hideSelectedChat = function() {
        const select = document.getElementById('chat_to_hide_select');
        const val = select.value;
        if (!val) return;
        
        if (!window.hiddenChats.includes(val)) {
            window.hiddenChats.push(val);
            localStorage.setItem('hidden_chats', JSON.stringify(window.hiddenChats));
            
            window.sortSidebar?.();
            populateChatsToHideDropdown();
            renderHiddenChatsList();
            
            window.showToast?.('Chat Hidden', 'The chat has been hidden from the main list.');
        }
        select.value = '';
    };

    window.unhideChat = function(id) {
        const index = window.hiddenChats.indexOf(id);
        if (index > -1) {
            window.hiddenChats.splice(index, 1);
            localStorage.setItem('hidden_chats', JSON.stringify(window.hiddenChats));
            
            window.sortSidebar?.();
            populateChatsToHideDropdown();
            renderHiddenChatsList();
            
            window.showToast?.('Chat Unhidden', 'The chat is now visible in the main list.');
        }
    };

    window.changeHideChatPassword = async function() {
        const currentPwd = document.getElementById('hide_chat_change_current').value;
        const newPwd = document.getElementById('hide_chat_change_new').value;
        const confirmPwd = document.getElementById('hide_chat_change_confirm').value;
        const errEl = document.getElementById('hide_chat_change_error');
        
        errEl.classList.add('hidden');
        
        const storedHash = localStorage.getItem('hide_chat_pwd_hash');
        const currentHash = await hashHidePassword(currentPwd);
        
        if (currentHash !== storedHash) {
            errEl.textContent = 'Incorrect current password.';
            errEl.classList.remove('hidden');
            return;
        }
        
        if (newPwd.length < 6) {
            errEl.textContent = 'New password must be at least 6 characters.';
            errEl.classList.remove('hidden');
            return;
        }
        
        if (newPwd !== confirmPwd) {
            errEl.textContent = 'New passwords do not match.';
            errEl.classList.remove('hidden');
            return;
        }
        
        const newHash = await hashHidePassword(newPwd);
        localStorage.setItem('hide_chat_pwd_hash', newHash);
        
        window.closeChangePasswordModal();
        window.showToast?.('Password Changed', 'Your Hide Chat password has been updated.');
    };

    // Search Click Unlock Modal Logic
    window.promptHiddenChatClickUnlock = function(callback) {
        pendingChatSelectionCallback = callback;
        document.getElementById('hidden_chat_click_pwd').value = '';
        document.getElementById('hidden_chat_click_error').classList.add('hidden');
        
        const modal = document.getElementById('hidden_chat_click_unlock_modal');
        const content = document.getElementById('hidden_chat_click_unlock_content');
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('opacity-100');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
            document.getElementById('hidden_chat_click_pwd').focus();
        }, 10);
    };

    window.closeHiddenChatClickUnlockModal = function() {
        const modal = document.getElementById('hidden_chat_click_unlock_modal');
        const content = document.getElementById('hidden_chat_click_unlock_content');
        
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.remove('opacity-100');
            modal.classList.add('hidden');
        }, 300);
        pendingChatSelectionCallback = null;
    };

    window.verifyHiddenChatClickUnlock = async function() {
        const pwd = document.getElementById('hidden_chat_click_pwd').value;
        const errEl = document.getElementById('hidden_chat_click_error');
        const storedHash = localStorage.getItem('hide_chat_pwd_hash');
        
        const hash = await hashHidePassword(pwd);
        if (hash === storedHash) {
            const cb = pendingChatSelectionCallback;
            window.closeHiddenChatClickUnlockModal();
            if (cb) cb();
        } else {
            errEl.classList.remove('hidden');
            document.getElementById('hidden_chat_click_pwd').value = '';
            document.getElementById('hidden_chat_click_pwd').focus();
        }
    };

    document.getElementById('hidden_chat_click_pwd').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            window.verifyHiddenChatClickUnlock();
        }
    });
</script>
