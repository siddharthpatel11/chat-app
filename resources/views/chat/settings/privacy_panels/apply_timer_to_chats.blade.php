<!-- Apply Timer To Chats Sidebar -->
<div id="privacy_apply_timer_sidebar" class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden relative z-[50]">
    <!-- Header -->
    <div class="h-[60px] bg-[#202c33] flex items-center justify-between px-4 shrink-0 transition-colors">
        <div class="flex items-center gap-6">
            <button onclick="window.closeApplyTimerToChats()" class="text-[#aebac1] hover:text-[#e9edef] transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
            </button>
            <span class="text-[#e9edef] text-[16px] font-medium">Apply timer to chats</span>
        </div>
        <button class="text-[#aebac1] hover:text-[#e9edef] transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 0 0 1.256-3.386 5.207 5.207 0 1 0-5.207 5.208 5.183 5.183 0 0 0 3.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-4.6-1.6a3.6 3.6 0 1 1 0-7.2 3.6 3.6 0 0 1 0 7.2z"></path>
            </svg>
        </button>
    </div>

    <!-- Subheader -->
    <div class="flex items-center gap-4 py-4 px-6 border-b border-[#202c33]">
        <div class="text-[#8696a0]">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
        </div>
        <div class="flex-1">
            <div class="text-[#e9edef] text-[16px] mb-1">Disappearing message timer</div>
            <div class="text-[#8696a0] text-[14px]" id="privacy_apply_timer_current_val">Off</div>
        </div>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] relative">
        <div class="px-6 py-4">
            <div class="text-[#00a884] text-[14px] font-medium mb-4">Apply message timer to these chats</div>
            
            <div id="privacy_apply_timer_list" class="flex flex-col">
                <!-- Dynamic chats will go here -->
                <div class="text-[#8696a0] text-[14px] text-center mt-4">Loading chats...</div>
            </div>
        </div>
    </div>
    
    <!-- Floating Action Button -->
    <div id="privacy_apply_timer_fab" class="hidden absolute bottom-6 right-6 w-14 h-14 bg-[#00a884] hover:bg-[#008f6f] rounded-full items-center justify-center cursor-pointer shadow-lg transition-transform scale-0" onclick="window.submitApplyTimerToChats()">
        <svg viewBox="0 0 24 24" width="24" height="24" fill="white">
            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
        </svg>
    </div>
</div>

<script>
    let privacyApplyTimerSelectedChats = new Set();
    
    window.openApplyTimerToChats = function() {
        const hub = document.getElementById('privacy_disappearing_messages_sidebar');
        const sidebar = document.getElementById('privacy_apply_timer_sidebar');
        
        if (hub) {
            hub.classList.add('hidden');
            hub.classList.remove('flex');
        }
        sidebar.classList.remove('hidden');
        sidebar.classList.add('flex');
        
        // Setup current timer display
        const saved = localStorage.getItem('whatsapp_privacy_message_timer') || 'Off';
        document.getElementById('privacy_apply_timer_current_val').innerText = saved;
        
        // Load chats
        privacyApplyTimerSelectedChats.clear();
        updatePrivacyApplyTimerFab();
        loadPrivacyApplyTimerChats();
    }

    window.closeApplyTimerToChats = function() {
        const hub = document.getElementById('privacy_disappearing_messages_sidebar');
        const sidebar = document.getElementById('privacy_apply_timer_sidebar');
        
        if (sidebar) {
            sidebar.classList.add('hidden');
            sidebar.classList.remove('flex');
        }
        if (hub) {
            hub.classList.remove('hidden');
            hub.classList.add('flex');
        }
    }
    
    function updatePrivacyApplyTimerFab() {
        const fab = document.getElementById('privacy_apply_timer_fab');
        if (privacyApplyTimerSelectedChats.size > 0) {
            fab.classList.remove('hidden');
            fab.classList.add('flex');
            setTimeout(() => fab.classList.remove('scale-0'), 10);
        } else {
            fab.classList.add('scale-0');
            setTimeout(() => {
                if(privacyApplyTimerSelectedChats.size === 0) {
                    fab.classList.remove('flex');
                    fab.classList.add('hidden');
                }
            }, 200);
        }
    }
    
    window.togglePrivacyApplyTimerChat = function(id) {
        // Prevent toggle if disabled
        const checkbox = document.getElementById('apply_timer_check_' + id);
        if(!checkbox || checkbox.disabled) return;
        
        if (privacyApplyTimerSelectedChats.has(id)) {
            privacyApplyTimerSelectedChats.delete(id);
            checkbox.checked = false;
        } else {
            privacyApplyTimerSelectedChats.add(id);
            checkbox.checked = true;
        }
        updatePrivacyApplyTimerFab();
    }
    
    function loadPrivacyApplyTimerChats() {
        const listEl = document.getElementById('privacy_apply_timer_list');
        listEl.innerHTML = '<div class="text-[#8696a0] text-[14px] text-center mt-4">Loading chats...</div>';
        
        if (!window.db || !window.myUserId) return;
        
        const myId = window.myUserId;
        let chatList = [];
        
        // 1. Fetch private chats
        const fetchPrivate = window.get(window.ref(window.db, 'chats')).then(snap => {
            if(snap.exists()) {
                snap.forEach(child => {
                    const chatId = child.key;
                    if(chatId.includes(myId)) {
                        const otherId = chatId.split('_').find(id => id !== myId);
                        if(otherId) {
                            const chatData = child.val();
                            chatList.push({
                                id: chatId,
                                type: 'private',
                                otherId: otherId,
                                data: chatData,
                                sortTime: chatData.lastMessageTime || 0
                            });
                        }
                    }
                });
            }
        });
        
        // 2. Fetch groups
        const fetchGroups = window.get(window.ref(window.db, 'groups')).then(snap => {
            if(snap.exists()) {
                snap.forEach(child => {
                    const grp = child.val();
                    if(grp.users && (grp.users.includes(Number(myId)) || grp.users.includes(String(myId)))) {
                        chatList.push({
                            id: child.key,
                            type: 'group',
                            data: grp,
                            sortTime: grp.lastMessageTime || 0
                        });
                    }
                });
            }
        });
        
        Promise.all([fetchPrivate, fetchGroups]).then(() => {
            chatList.sort((a, b) => b.sortTime - a.sortTime);
            listEl.innerHTML = '';
            
            chatList.forEach(chat => {
                let name = '';
                let avatar = '';
                let subtitle = '';
                let disabled = false;
                
                if (chat.type === 'private') {
                    const contact = window.contacts ? window.contacts.find(c => c.id == chat.otherId) : null;
                    name = contact ? contact.name : 'Unknown Contact';
                    if (chat.otherId == myId) name += ' (You)';
                    avatar = contact?.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=2a3942&color=fff`;
                    subtitle = chat.otherId == myId ? 'Message yourself' : (contact?.phone || 'MOBILE');
                } else {
                    name = chat.data.name || 'Unknown Group';
                    avatar = chat.data.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=2a3942&color=fff`;
                    
                    // Check permissions
                    const permissions = chat.data.permissions || {};
                    const groupSettings = permissions.group_settings || 'all';
                    const isAdmin = chat.data.admins && chat.data.admins[myId];
                    
                    if (groupSettings === 'admins' && !isAdmin) {
                        disabled = true;
                        subtitle = '<i class="text-[#8696a0]">You can\\'t edit group settings</i>';
                    } else {
                        // Show members
                        let members = [];
                        if (chat.data.users) {
                            chat.data.users.slice(0, 3).forEach(uid => {
                                if(uid == myId) members.push('You');
                                else {
                                    const c = window.contacts ? window.contacts.find(x => x.id == uid) : null;
                                    if(c) members.push(c.name);
                                }
                            });
                        }
                        subtitle = members.join(', ') + (chat.data.users && chat.data.users.length > 3 ? '...' : '');
                    }
                }
                
                // Add has-timer icon to avatar if applicable
                const currentTimer = chat.data.disappearingTimer || 0;
                let timerBadge = '';
                if(currentTimer > 0) {
                    timerBadge = `
                        <div class="absolute -bottom-1 -right-1 bg-[#111b21] rounded-full p-0.5">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8696a0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                    `;
                }
                
                let checkUi = `
                    <div class="w-6 h-6 rounded-full border-2 border-[#8696a0] flex items-center justify-center transition-colors">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="white" class="hidden"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path></svg>
                    </div>
                `;
                
                listEl.innerHTML += `
                    <div class="flex items-center gap-4 py-3 cursor-pointer hover:bg-[#202c33] -mx-6 px-6 transition-colors ${disabled ? 'opacity-60' : ''}" onclick="window.togglePrivacyApplyTimerChat('${chat.id}')">
                        <div class="relative shrink-0">
                            <img src="${avatar}" class="w-12 h-12 rounded-full object-cover">
                            ${timerBadge}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-center mb-0.5">
                                <span class="text-[#e9edef] text-[16px] truncate">${name}</span>
                            </div>
                            <div class="text-[#8696a0] text-[13px] truncate">${subtitle}</div>
                        </div>
                        ${!disabled ? `
                            <div class="pl-3">
                                <label class="relative flex items-center cursor-pointer pointer-events-none">
                                    <input type="checkbox" id="apply_timer_check_${chat.id}" class="peer sr-only">
                                    <div class="w-6 h-6 rounded-full border-2 border-[#8696a0] peer-checked:bg-[#00a884] peer-checked:border-[#00a884] peer-checked:[&>svg]:opacity-100 flex items-center justify-center transition-colors">
                                        <svg viewBox="0 0 24 24" width="16" height="16" fill="white" class="opacity-0 transition-opacity"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path></svg>
                                    </div>
                                </label>
                            </div>
                        ` : ''}
                    </div>
                `;
            });
            
            if(chatList.length === 0) {
                listEl.innerHTML = '<div class="text-[#8696a0] text-[14px] text-center mt-4">No chats found.</div>';
            }
        });
    }

    window.submitApplyTimerToChats = function() {
        if (privacyApplyTimerSelectedChats.size === 0) return;
        
        const saved = localStorage.getItem('whatsapp_privacy_message_timer') || 'Off';
        let duration = 0;
        if (saved === '2 minutes') duration = 120;
        else if (saved === '24 hours') duration = 86400;
        else if (saved === '7 days') duration = 604800;
        else if (saved === '90 days') duration = 7776000;
        
        let updates = {};
        
        privacyApplyTimerSelectedChats.forEach(chatId => {
            if (chatId.startsWith('group_')) {
                updates[`groups/${chatId}/disappearingTimer`] = duration;
            } else {
                updates[`chats/${chatId}/disappearingTimer`] = duration;
            }
        });
        
        if (window.db) {
            window.update(window.ref(window.db), updates).then(() => {
                if (window.showToast) window.showToast('Timer applied', `Timer set to ${saved} for selected chats.`);
                window.closeApplyTimerToChats();
                
                // Refresh the stats in the hub panel
                if (typeof window.openPrivacyDisappearingMessages === 'function') {
                    // Close and re-open to trigger re-count
                    window.closePrivacyDisappearingMessages();
                    setTimeout(window.openPrivacyDisappearingMessages, 100);
                }
            }).catch(err => {
                console.error("Failed to apply timer:", err);
                if (window.showToast) window.showToast('Error', 'Failed to apply timer to chats.');
            });
        }
    }
</script>
