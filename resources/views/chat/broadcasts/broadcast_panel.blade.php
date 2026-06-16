<div id="broadcast_lists_panel"
    class="hidden flex-col w-[30%] sm:min-w-[300px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden z-[60]">
    
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="toggleBroadcastPanel()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[16px] font-medium leading-tight">Broadcasts</h2>
    </div>

    <!-- Monthly Limit Stats -->
    <div class="p-5 border-b border-[#202c33] bg-[#111b21] flex flex-col gap-4">
        <div class="flex justify-between items-center text-xs text-[#8696a0] font-medium uppercase tracking-wider">
            <span>This month</span>
            <span id="broadcast_date_range" class="text-xs">01 Jun - 30 Jun</span>
        </div>
        <div class="flex justify-between items-baseline mt-1">
            <div>
                <span id="broadcast_sent_count" class="text-3xl font-light text-white">0</span>
                <p class="text-xs text-[#8696a0] mt-0.5">Sent</p>
            </div>
            <div class="text-right">
                <span id="broadcast_remaining_count" class="text-3xl font-light text-white">35</span>
                <p class="text-xs text-[#8696a0] mt-0.5">Remaining</p>
            </div>
        </div>
        
        <!-- Progress Bar -->
        <div class="w-full bg-[#202c33] h-[5px] rounded-full overflow-hidden mt-1 relative">
            <div id="broadcast_progress_bar" class="bg-[#00a884] h-full transition-all duration-300" style="width: 0%;"></div>
        </div>
        <p class="text-[13px] text-[#8696a0] leading-snug">
            Send up to 35 broadcasts per month. <a href="#" class="text-[#00a884] hover:underline" onclick="event.preventDefault(); window.showToast?.('Info', 'Limit is reset on the 1st of every month.')">Learn more</a>
        </p>
    </div>

    <!-- Broadcast lists content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] relative flex flex-col">
        <div class="px-5 pt-4 pb-2">
            <span class="text-[#8696a0] text-xs font-semibold uppercase tracking-wider">Your broadcasts</span>
        </div>
        
        <div id="broadcast_lists_container" class="flex-1">
            <!-- Dynamic lists loaded by JS -->
            <div id="broadcast_empty_state" class="flex flex-col items-center justify-center py-16 px-6 text-center">
                <svg class="w-16 h-16 text-[#3b4a54] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.357.205a.75.75 0 0 1-1.006-.322c-.386-.77-.723-1.576-.999-2.425a17.203 17.203 0 0 1-.345-2.752m2.185-6.408A17.228 17.228 0 0 0 13.5 3h1.5a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 15 21h-1.5a17.23 17.23 0 0 1-1.175-4.577m-1.175-9.333a17.266 17.266 0 0 1 2.185 6.408m-2.185-6.408c-.056.286-.093.576-.112.868m0 0a17.52 17.52 0 0 1 1.175 4.577m-1.175-4.577c-.019-.292-.056-.582-.112-.868m0 5.445c-.019.292-.056.582-.112.868m-1.175 0c-.056-.286-.093-.576-.112-.868m0 0a17.52 17.52 0 0 0-1.175-4.577M9.25 8.132a17.266 17.266 0 0 0-2.185 6.408m2.185-6.408c.056.286.093.576.112.868m0 0a17.52 17.52 0 0 0-1.175 4.577" />
                </svg>
                <p class="text-[#8696a0] text-[14px]">No broadcast lists yet</p>
                <p class="text-[#667781] text-[12px] mt-1">Tap the + button to create one</p>
            </div>
            
            <div id="broadcasts_active_list" class="space-y-0.5"></div>
        </div>

        <!-- Floating Add Button -->
        <div class="absolute bottom-6 right-6 z-10">
            <button onclick="openNewBroadcastSelection()" class="w-14 h-14 bg-[#00a884] hover:bg-[#00bfa5] text-[#111b21] rounded-2xl flex items-center justify-center shadow-lg transition-transform hover:scale-105 active:scale-95 focus:outline-none">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
    function formatTimestamp(timestamp) {
        if (!timestamp) return '';
        const date = new Date(timestamp * 1000);
        const now = new Date();
        const diffTime = now - date;
        const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
        if (diffDays === 0 && date.getDate() === now.getDate()) {
            return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        } else if (diffDays === 1 || (diffDays === 0 && date.getDate() !== now.getDate())) {
            return 'Yesterday';
        } else {
            return date.toLocaleDateString([], { day: '2-digit', month: '2-digit', year: 'numeric' });
        }
    }

    window.syncBroadcastsToSidebar = function() {
        const container = document.getElementById('user_list_container');
        if (!container) return;

        // Get existing lists
        const lists = JSON.parse(localStorage.getItem('broadcast_lists') || '[]');

        // Remove any stale broadcast items first
        document.querySelectorAll('.user-chat-item-broadcast').forEach(el => el.remove());

        lists.forEach(list => {
            const bcastMessages = JSON.parse(localStorage.getItem('bcast_msgs_broadcast_' + list.id) || '[]');
            const lastMsg = bcastMessages.length > 0 ? bcastMessages[bcastMessages.length - 1] : null;
            const lastMsgText = lastMsg ? lastMsg.text : 'Click to chat';
            const lastMsgTime = lastMsg ? lastMsg.time : 0;
            const timeStr = lastMsg ? formatTimestamp(lastMsgTime) : '';

            const itemId = `user_sidebar_broadcast_${list.id}`;

            const itemHtml = `
                <div onclick="window.openBroadcastChat('${list.id}', true)"
                    class="flex relative items-center px-3 py-3 hover:bg-[#202c33] cursor-pointer transition-colors user-chat-item user-chat-item-broadcast group"
                    id="${itemId}" 
                    data-name="${escapeHtml(list.name)}"
                    data-avatar="https://ui-avatars.com/api/?name=B&background=00a884&color=fff" 
                    data-phone="Broadcast (${list.recipients.length} recipients)"
                    data-about="Broadcast List: ${list.recipients.map(r => r.name).join(', ')}" 
                    data-userid="broadcast_${list.id}"
                    data-timestamp="${lastMsgTime}">
                    <div class="w-12 h-12 rounded-full bg-[#00a884]/20 flex items-center justify-center shrink-0 text-[#00a884]">
                        <svg viewBox="0 0 16 16" width="24" height="24" fill="currentColor">
                            <path d="M13 2.5a1.5 1.5 0 0 1 3 0v11a1.5 1.5 0 0 1-3 0v-.214c-2.162-1.241-4.49-1.843-6.912-2.083l.405 2.712A1 1 0 0 1 5.51 15.1h-.548a1 1 0 0 1-.916-.599l-1.85-3.49-.202-.003A2.014 2.014 0 0 1 0 9V7a2.02 2.02 0 0 1 1.992-2.013 75 75 0 0 0 2.483-.075c3.043-.154 6.148-.849 8.525-2.199zm1 0v11a.5.5 0 0 0 1 0v-11a.5.5 0 0 0-1 0m-1 1.35c-2.344 1.205-5.209 1.842-8 2.033v4.233q.27.015.537.036c2.568.189 5.093.744 7.463 1.993zm-9 6.215v-4.13a95 95 0 0 1-1.992.052A1.02 1.02 0 0 0 1 7v2c0 .55.448 1.002 1.006 1.009A61 61 0 0 1 4 10.065m-.657.975 1.609 3.037.01.024h.548l-.002-.014-.443-2.966a68 68 0 0 0-1.722-.082z"/>
                        </svg>
                    </div>
                    <div class="ml-3 flex-1 border-b border-[#202c33] pb-3 pt-1 min-w-0 pr-6 relative">
                        <div class="flex justify-between items-center">
                            <h4 class="text-[17px] text-[#e9edef] truncate mr-2 font-normal">
                                ${escapeHtml(list.name)}
                            </h4>
                            <span class="text-[12px] text-[#8696a0] whitespace-nowrap" id="last_time_broadcast_${list.id}">
                                ${timeStr}
                            </span>
                        </div>
                        <div class="flex justify-between items-center mt-0.5">
                            <div class="text-[14px] text-[#8696a0] truncate flex-1 min-w-0 leading-snug flex items-center gap-1" id="last_msg_broadcast_${list.id}">
                                <svg viewBox="0 0 16 16" width="15" height="15" fill="#8696a0" class="shrink-0 inline-block mr-1">
                                    <path d="M13 2.5a1.5 1.5 0 0 1 3 0v11a1.5 1.5 0 0 1-3 0v-.214c-2.162-1.241-4.49-1.843-6.912-2.083l.405 2.712A1 1 0 0 1 5.51 15.1h-.548a1 1 0 0 1-.916-.599l-1.85-3.49-.202-.003A2.014 2.014 0 0 1 0 9V7a2.02 2.02 0 0 1 1.992-2.013 75 75 0 0 0 2.483-.075c3.043-.154 6.148-.849 8.525-2.199zm1 0v11a.5.5 0 0 0 1 0v-11a.5.5 0 0 0-1 0m-1 1.35c-2.344 1.205-5.209 1.842-8 2.033v4.233q.27.015.537.036c2.568.189 5.093.744 7.463 1.993zm-9 6.215v-4.13a95 95 0 0 1-1.992.052A1.02 1.02 0 0 0 1 7v2c0 .55.448 1.002 1.006 1.009A61 61 0 0 1 4 10.065m-.657.975 1.609 3.037.01.024h.548l-.002-.014-.443-2.966a68 68 0 0 0-1.722-.082z"/>
                                </svg>
                                <span>${escapeHtml(lastMsgText)}</span>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <!-- Pin Icon -->
                                <span id="pin_icon_broadcast_${list.id}" class="hidden text-[#8696a0]">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                                        <path d="M16 12V4h1V2H7v2h1v8l-2 2v2h5.2v6h1.6v-6H18v-2l-2-2z" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Dropdown Trigger Button with Gradient Overlay -->
                    <div class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-[#202c33] via-[#202c33] to-transparent hidden group-hover:flex items-center justify-end pr-3 z-20 options-btn-gradient">
                        <button onclick="event.stopPropagation(); window.toggleUserContextMenu(event, 'broadcast_${list.id}', '${escapeHtml(list.name).replace(/'/g, "\\'")}', 'user')"
                            class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none">
                            <svg viewBox="0 0 19 20" width="19" height="20" fill="currentColor">
                                <path d="M3.8 6.7l5.7 5.7 5.7-5.7 1.6 1.6-7.3 7.2-7.3-7.2 1.6-1.6z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', itemHtml);
            
            // Apply pin state if pinned
            const isPinned = window.pinnedChats && window.pinnedChats.includes(itemId);
            const pinIcon = document.getElementById(`pin_icon_broadcast_${list.id}`);
            if (pinIcon && isPinned) {
                pinIcon.classList.remove('hidden');
            }
        });

        // Trigger sorting
        if (window.sortSidebar) {
            window.sortSidebar();
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        // Initialize Date Range
        const now = new Date();
        const startOfMonth = new Date(now.getFullYear(), now.getMonth(), 1);
        const endOfMonth = new Date(now.getFullYear(), now.getMonth() + 1, 0);
        
        const opt = { day: '2-digit', month: 'short' };
        const dateStr = `${startOfMonth.toLocaleDateString('en-GB', opt)} - ${endOfMonth.toLocaleDateString('en-GB', opt)}`;
        
        const dateRangeEl = document.getElementById('broadcast_date_range');
        if (dateRangeEl) {
            dateRangeEl.textContent = dateStr;
        }

        // Initialize Broadcast Lists from LocalStorage
        window.broadcastLists = JSON.parse(localStorage.getItem('broadcast_lists') || '[]');
        
        // Update stats
        window.updateBroadcastStats();
        window.renderBroadcastLists();
        window.syncBroadcastsToSidebar();

        // ── Real-time Firebase Sync ──────────────────────────────────────────
        // API (Postman / mobile) writes to Firebase → web picks it up instantly
        // without any page refresh.
        const startFirebaseBroadcastSync = () => {
            if (!window.db || !window.onValue || !window.ref || !window.myUserId || window.myUserId == '0') return false;

            try {
                const broadcastsRef = window.ref(window.db, 'broadcasts');
                window.onValue(broadcastsRef, (snapshot) => {
                    try {
                        const allBroadcasts = snapshot.val() || {};
                        const myUserId = String(window.myUserId);

                        // Filter only this user's broadcast lists
                        const myLists = Object.values(allBroadcasts).filter(b => b && String(b.created_by) === myUserId);

                        // Normalize Firebase data into the format the web expects
                        const normalizedFromFirebase = myLists.map(b => {
                            const usersArray = Array.isArray(b.recipients_info)
                                ? b.recipients_info.map(r => r.id)
                                : (b.users || []);
                            
                            const recipients = usersArray.map(uid => {
                                const found = window.allContacts ? window.allContacts.find(c => String(c.id) === String(uid)) : null;
                                return {
                                    id: uid,
                                    name: found ? (found.saved_name || found.name || found.phone) : 'User ' + uid,
                                    avatar: found ? (found.avatar || '') : '',
                                    phone: found ? (found.phone || '') : '',
                                    about: found ? (found.about || 'Available') : 'Available'
                                };
                            });

                            // Sync messages history from Firebase to LocalStorage
                            if (b.messages) {
                                const firebaseMsgs = Object.entries(b.messages).map(([msgId, msg]) => {
                                    return {
                                        id: msgId,
                                        sender_id: msg.sender_id,
                                        text: msg.text || '',
                                        type: msg.type || 'text',
                                        file_url: msg.file_url || null,
                                        file_name: msg.file_name || null,
                                        lat: msg.lat || null,
                                        lng: msg.lng || null,
                                        time: msg.time,
                                        status: msg.status || 'sent',
                                        is_broadcast: true
                                    };
                                });

                                const localMsgsKey = 'bcast_msgs_broadcast_' + b.id;
                                const localMsgs = JSON.parse(localStorage.getItem(localMsgsKey) || '[]');
                                const localMsgsMap = new Map(localMsgs.map(m => [m.id, m]));
                                
                                firebaseMsgs.forEach(m => {
                                    localMsgsMap.set(m.id, m);
                                });
                                
                                const mergedMsgs = Array.from(localMsgsMap.values()).sort((a, b) => a.time - b.time);
                                localStorage.setItem(localMsgsKey, JSON.stringify(mergedMsgs));
                            }

                            return {
                                id: b.id,
                                name: b.name,
                                recipients: recipients,
                                created_at: b.created_at,
                                updated_at: b.updated_at,
                            };
                        });

                        // Merge: Firebase lists take priority (source of truth for API-created ones)
                        // Keep localStorage-only lists that don't exist in Firebase yet
                        const firebaseIds = new Set(normalizedFromFirebase.map(b => b.id));
                        const localLists = JSON.parse(localStorage.getItem('broadcast_lists') || '[]');
                        const localOnly = localLists.filter(l => !firebaseIds.has(l.id));

                        const merged = [...normalizedFromFirebase, ...localOnly];

                        // Persist merged list to localStorage
                        localStorage.setItem('broadcast_lists', JSON.stringify(merged));
                        window.broadcastLists = merged;

                        // Re-render sidebar + broadcast panel
                        window.updateBroadcastStats();
                        window.renderBroadcastLists();
                        window.syncBroadcastsToSidebar();

                        // Auto-refresh active chat if it is the currently updated broadcast list
                        myLists.forEach(b => {
                            if (window.currentChatId === 'broadcast_' + b.id && window.selectChat) {
                                const activeList = window.broadcastLists.find(l => l.id === b.id);
                                if (activeList) {
                                    window.selectChat(
                                        window.currentChatId,
                                        activeList.name,
                                        `Broadcast (${activeList.recipients.length} recipients)`,
                                        'https://ui-avatars.com/api/?name=B&background=00a884&color=fff',
                                        `Broadcast List: ${activeList.recipients.map(r => r.name).join(', ')}`
                                    );
                                }
                            }
                        });

                        // Auto-refresh Broadcast Info Panel if it is currently open
                        const infoPanel = document.getElementById('broadcast_info_panel');
                        if (infoPanel && !infoPanel.classList.contains('translate-x-full') && window.openBroadcastInfo) {
                            window.openBroadcastInfo();
                        }
                    } catch (e) {
                        console.error('Error parsing Firebase broadcasts sync:', e);
                    }
                });
                return true;
            } catch (e) {
                console.error('Error setting up Firebase broadcasts listener:', e);
                return false;
            }
        };

        // Periodically check if Firebase SDK is fully loaded and then start sync
        const syncInterval = setInterval(() => {
            if (startFirebaseBroadcastSync()) {
                clearInterval(syncInterval);
            }
        }, 500);

        // Auto open chat if open_chat URL param is set (from shortcut)
        const params = new URLSearchParams(window.location.search);
        const openChatId = params.get('open_chat');
        if (openChatId && openChatId.startsWith('broadcast_')) {
            const listId = openChatId.replace('broadcast_', '');
            setTimeout(() => {
                window.openBroadcastChat?.(listId);
            }, 500);
        }

        // Hijack deleteChatMessages and clearChatMessages for broadcasts
        if (window.deleteChatMessages) {
            const originalDeleteChatMessages = window.deleteChatMessages;
            window.deleteChatMessages = function(targetId, type) {
                if (typeof targetId === 'string' && targetId.startsWith('broadcast_')) {
                    const listId = targetId.replace('broadcast_', '');
                    const deleteAction = () => {
                        window.broadcastLists = window.broadcastLists.filter(l => l.id !== listId);
                        localStorage.setItem('broadcast_lists', JSON.stringify(window.broadcastLists));
                        window.renderBroadcastLists();
                        window.showToast?.('Success', 'Broadcast list deleted.');
                        
                        // If the deleted list was active, close the chat window
                        if (window.currentChatId === targetId) {
                            document.getElementById('active_chat_content')?.classList.add('hidden');
                            document.getElementById('chat_empty_state')?.classList.remove('hidden');
                            window.currentChatId = null;
                        }
                    };

                    if (window.openDeleteModal) {
                        window.openDeleteModal("Are you sure you want to delete this broadcast list?", deleteAction);
                    } else if (confirm("Are you sure you want to delete this broadcast list?")) {
                        deleteAction();
                    }
                } else {
                    originalDeleteChatMessages.apply(this, arguments);
                }
            };
        }

        if (window.clearChatMessages) {
            const originalClearChatMessages = window.clearChatMessages;
            window.clearChatMessages = function(targetId, type) {
                if (typeof targetId === 'string' && targetId.startsWith('broadcast_')) {
                    localStorage.removeItem('bcast_msgs_' + targetId);
                    // Refresh chat window if it is currently open
                    if (window.currentChatId === targetId) {
                        window.selectChat(targetId, window.activeChatName, `Broadcast (${window.activeBroadcastList.recipients.length} recipients)`);
                    }
                    window.syncBroadcastsToSidebar();
                    window.showToast?.('Success', 'Broadcast history cleared.');
                } else {
                    originalClearChatMessages.apply(this, arguments);
                }
            };
        }
    });

    window.toggleBroadcastPanel = function() {
        const panel = document.getElementById('broadcast_lists_panel');
        const mainSidebar = document.getElementById('user_sidebar_container');
        
        if (panel.classList.contains('hidden')) {
            // Hide main sidebar
            if (mainSidebar) {
                mainSidebar.classList.add('hidden');
                mainSidebar.classList.remove('sm:flex');
            }
            panel.classList.remove('hidden');
            panel.classList.add('flex');
            window.renderBroadcastLists();
        } else {
            panel.classList.add('hidden');
            panel.classList.remove('flex');
            if (mainSidebar) {
                mainSidebar.classList.remove('hidden');
                mainSidebar.classList.add('sm:flex');
            }
        }
    };

    // Expose showBroadcastLists globally as it's triggered from sidebar.blade.php
    window.showBroadcastLists = function() {
        window.toggleBroadcastPanel();
    };

    window.updateBroadcastStats = function() {
        const sentCount = parseInt(localStorage.getItem('broadcast_sent_count') || '0');
        const maxLimit = 35;
        const remaining = Math.max(0, maxLimit - sentCount);
        const progressPercent = Math.min(100, (sentCount / maxLimit) * 100);

        const sentEl = document.getElementById('broadcast_sent_count');
        const remainingEl = document.getElementById('broadcast_remaining_count');
        const progressEl = document.getElementById('broadcast_progress_bar');

        if (sentEl) sentEl.textContent = sentCount;
        if (remainingEl) remainingEl.textContent = remaining;
        if (progressEl) progressEl.style.width = `${progressPercent}%`;
    };

    window.renderBroadcastLists = function() {
        window.broadcastLists = JSON.parse(localStorage.getItem('broadcast_lists') || '[]');
        const container = document.getElementById('broadcasts_active_list');
        const emptyState = document.getElementById('broadcast_empty_state');

        // Update active chat header if currently showing this broadcast list
        if (window.currentChatId && window.currentChatId.startsWith('broadcast_')) {
            const activeId = window.currentChatId.replace('broadcast_', '');
            const activeList = window.broadcastLists.find(l => l.id === activeId);
            if (activeList) {
                window.activeBroadcastList = activeList;
                const titleEl = document.getElementById('active_chat_title');
                const subtitleEl = document.getElementById('active_chat_subtitle');
                if (titleEl) titleEl.textContent = activeList.name;
                if (subtitleEl) subtitleEl.textContent = `Broadcast (${activeList.recipients.length} recipients)`;
            }
        }

        if (window.syncBroadcastsToSidebar) {
            window.syncBroadcastsToSidebar();
        }

        if (!container) return;
        container.innerHTML = '';

        if (window.broadcastLists.length === 0) {
            if (emptyState) emptyState.classList.remove('hidden');
            return;
        }

        if (emptyState) emptyState.classList.add('hidden');

        window.broadcastLists.forEach(list => {
            const item = document.createElement('div');
            item.className = "flex items-center px-4 py-3 hover:bg-[#202c33] cursor-pointer transition-colors border-b border-[#202c33]/30 relative group";
            item.onclick = () => window.openBroadcastChat(list.id);
            
            item.innerHTML = `
                <div class="w-12 h-12 rounded-full bg-[#00a884]/20 flex items-center justify-center shrink-0 text-[#00a884]">
                    <svg viewBox="0 0 16 16" width="24" height="24" fill="currentColor">
                        <path d="M13 2.5a1.5 1.5 0 0 1 3 0v11a1.5 1.5 0 0 1-3 0v-.214c-2.162-1.241-4.49-1.843-6.912-2.083l.405 2.712A1 1 0 0 1 5.51 15.1h-.548a1 1 0 0 1-.916-.599l-1.85-3.49-.202-.003A2.014 2.014 0 0 1 0 9V7a2.02 2.02 0 0 1 1.992-2.013 75 75 0 0 0 2.483-.075c3.043-.154 6.148-.849 8.525-2.199zm1 0v11a.5.5 0 0 0 1 0v-11a.5.5 0 0 0-1 0m-1 1.35c-2.344 1.205-5.209 1.842-8 2.033v4.233q.27.015.537.036c2.568.189 5.093.744 7.463 1.993zm-9 6.215v-4.13a95 95 0 0 1-1.992.052A1.02 1.02 0 0 0 1 7v2c0 .55.448 1.002 1.006 1.009A61 61 0 0 1 4 10.065m-.657.975 1.609 3.037.01.024h.548l-.002-.014-.443-2.966a68 68 0 0 0-1.722-.082z"/>
                    </svg>
                </div>
                <div class="ml-4 flex-1 min-w-0 pr-8">
                    <h4 class="text-[16px] text-[#e9edef] truncate font-normal leading-snug">${escapeHtml(list.name)}</h4>
                    <p class="text-[13px] text-[#8696a0] mt-0.5">${list.recipients.length} recipients</p>
                </div>
                <button onclick="event.stopPropagation(); window.deleteBroadcastList('${list.id}')" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#8696a0] hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity p-1">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                    </svg>
                </button>
            `;
            container.appendChild(item);
        });
    };

    window.deleteBroadcastList = function(id) {
        const deleteAction = () => {
            window.broadcastLists = window.broadcastLists.filter(l => l.id !== id);
            localStorage.setItem('broadcast_lists', JSON.stringify(window.broadcastLists));
            window.renderBroadcastLists();
            window.showToast?.('Success', 'Broadcast list deleted.');
        };

        if (window.openDeleteModal) {
            window.openDeleteModal("Are you sure you want to delete this broadcast list?", deleteAction);
        } else if (confirm("Are you sure you want to delete this broadcast list?")) {
            deleteAction();
        }
    };

    window.openBroadcastChat = function(id, fromSidebar = false) {
        const list = window.broadcastLists.find(l => l.id === id);
        if (!list) return;

        // Close the panel if it is open
        const panel = document.getElementById('broadcast_lists_panel');
        if (panel && !panel.classList.contains('hidden')) {
            window.toggleBroadcastPanel();
        }

        // Let's hook it up to open a chat-like box!
        if (window.selectChat) {
            window.activeBroadcastList = list;
            window.selectChat(
                `broadcast_${list.id}`, 
                list.name, 
                `Broadcast (${list.recipients.length} recipients)`, 
                'https://ui-avatars.com/api/?name=B&background=00a884&color=fff', 
                `Broadcast List: ${list.recipients.map(r => r.name).join(', ')}`
            );
        }
    };

    window.exportBroadcastChat = function(chatId, listName) {
        const bcastMessages = JSON.parse(localStorage.getItem('bcast_msgs_' + chatId) || '[]');
        if (bcastMessages.length === 0) {
            window.showToast?.('Info', 'No messages to export.');
            return;
        }
        
        let textContent = `Chat history with Broadcast List: ${listName}\n\n`;
        bcastMessages.forEach(msg => {
            const timeStr = new Date(msg.time * 1000).toLocaleString();
            textContent += `[${timeStr}] You: ${msg.caption || msg.text}\n`;
        });
        
        const blob = new Blob([textContent], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `${listName.replace(/\s+/g, '_')}_chat_history.txt`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
        window.showToast?.('Success', 'Chat history exported successfully.');
    };

    window.addBroadcastShortcut = function(chatId, listName) {
        const urlContent = `[InternetShortcut]\nURL=${window.location.origin}/chat?open_chat=${chatId}\nIconIndex=0\n`;
        const blob = new Blob([urlContent], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `${listName.replace(/\s+/g, '_')}.url`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
        window.showToast?.('Success', 'Shortcut downloaded. Drag it to your desktop to use.');
    };

    function escapeHtml(str) {
        return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
    }

    // Hijack selectChat and emitMessage to support broadcasts
    const initBroadcastHijacks = () => {
        // Close broadcast info panel on settings/profile or other sidebar nav switches
        const navFunctions = [
            'showChats', 'showCalls', 'showStatus', 'showArchivedChats',
            'openMetaAiChat', 'openGlobalMediaModal', 'toggleSettings'
        ];
        navFunctions.forEach(fnName => {
            if (window[fnName]) {
                const originalFn = window[fnName];
                window[fnName] = function() {
                    if (window.closeBroadcastInfo) window.closeBroadcastInfo();
                    return originalFn.apply(this, arguments);
                };
            }
        });

        // Global capturing click listener to intercept and handle clicks on broadcast search results
        document.addEventListener('click', function(e) {
            const item = e.target.closest('[data-userid^="broadcast_"]');
            if (item && document.getElementById('search_results_container')?.contains(item)) {
                e.preventDefault();
                e.stopPropagation();
                
                const bcastId = item.getAttribute('data-userid');
                const listId = bcastId.replace('broadcast_', '');
                const list = window.broadcastLists?.find(l => l.id === listId);
                if (list) {
                    const avatar = 'https://ui-avatars.com/api/?name=B&background=00a884&color=fff';
                    const phone = `Broadcast (${list.recipients.length} recipients)`;
                    const about = `Broadcast List: ${list.recipients.map(r => r.name).join(', ')}`;
                    window.selectChat(bcastId, list.name, phone, avatar, about);
                }
            }
        }, true);

        // Hijack filterSidebar to support search for broadcast lists and their messages
        if (window.filterSidebar) {
            const originalFilterSidebar = window.filterSidebar;
            window.filterSidebar = function() {
                originalFilterSidebar.apply(this, arguments);
                
                const searchQuery = document.getElementById('sidebar_search').value.toLowerCase().trim();
                if (searchQuery === '') return;
                
                const chatsList = document.getElementById('search_chats_list');
                const msgsList = document.getElementById('search_messages_list');
                const chatsSection = document.getElementById('search_chats_section');
                const msgsSection = document.getElementById('search_messages_section');
                const noResults = document.getElementById('sidebar_no_results');
                
                // 1. Fix unquoted ID calls for broadcast lists in the Chats search results
                if (chatsList) {
                    const broadcastChatItems = chatsList.querySelectorAll('.user-chat-item[data-userid^="broadcast_"]');
                    broadcastChatItems.forEach(item => {
                        const bcastId = item.getAttribute('data-userid');
                        const listId = bcastId.replace('broadcast_', '');
                        const list = window.broadcastLists?.find(l => l.id === listId);
                        if (list) {
                            const nameEsc = list.name.replace(/'/g, "\\'");
                            const avatar = 'https://ui-avatars.com/api/?name=B&background=00a884&color=fff';
                            const phone = `Broadcast (${list.recipients.length} recipients)`;
                            const aboutEsc = `Broadcast List: ${list.recipients.map(r => r.name).join(', ')}`.replace(/'/g, "\\'");
                            
                            item.removeAttribute('onclick');
                            item.onclick = function() {
                                window.selectChat(bcastId, list.name, phone, avatar, `Broadcast List: ${list.recipients.map(r => r.name).join(', ')}`);
                            };
                            
                            const optBtn = item.querySelector('.options-btn-gradient button');
                            if (optBtn) {
                                optBtn.removeAttribute('onclick');
                                optBtn.onclick = function(e) {
                                    e.stopPropagation();
                                    window.toggleUserContextMenu(e, bcastId, list.name, 'user');
                                };
                            }
                        }
                    });
                }
                
                // 2. Search and append broadcast messages to the Messages search results
                let bcastMsgResults = [];
                const escQ = searchQuery.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                const highlightRegex = new RegExp(`(${escQ})`, 'gi');
                
                window.broadcastLists?.forEach(list => {
                    const chatId = 'broadcast_' + list.id;
                    const bcastMessages = JSON.parse(localStorage.getItem('bcast_msgs_' + chatId) || '[]');
                    bcastMessages.forEach(msg => {
                        const msgText = msg.text || '';
                        if (msgText.toLowerCase().includes(searchQuery)) {
                            bcastMsgResults.push({
                                list,
                                msg,
                                chatId
                            });
                        }
                    });
                });
                
                if (bcastMsgResults.length > 0 && msgsList) {
                    bcastMsgResults.forEach(r => {
                        const msgTime = r.msg.time ? new Date(r.msg.time * 1000) : null;
                        let timeStr = '';
                        if (msgTime) {
                            const now = new Date();
                            const todayStart = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                            const msgDayStart = new Date(msgTime.getFullYear(), msgTime.getMonth(), msgTime.getDate());
                            const diffDays = Math.round((todayStart - msgDayStart) / (1000 * 60 * 60 * 24));
                            if (diffDays === 0) timeStr = msgTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                            else if (diffDays === 1) timeStr = 'Yesterday';
                            else if (diffDays < 7) timeStr = msgTime.toLocaleDateString([], { weekday: 'long' });
                            else timeStr = msgTime.toLocaleDateString([], { day: '2-digit', month: '2-digit', year: 'numeric' });
                        }
                        
                        const highlightedMsg = r.msg.text.replace(highlightRegex, '<span class="text-[#00a884] font-medium">$1</span>');
                        const prefix = '<span class="text-[#8696a0]">✓ You: </span>';
                        const avatar = 'https://ui-avatars.com/api/?name=B&background=00a884&color=fff';
                        
                        const safeName = r.list.name;
                        const safePhone = `Broadcast (${r.list.recipients.length} recipients)`;
                        const safeAbout = `Broadcast List: ${r.list.recipients.map(re => re.name).join(', ')}`;
                        
                        const bcastMsgHtml = `
                            <div class="flex items-center px-3 py-3 hover:bg-[#202c33] cursor-pointer transition-colors relative group user-chat-item" data-userid="${r.chatId}">
                                <div class="w-12 h-12 rounded-full bg-[#00a884]/20 flex items-center justify-center shrink-0 text-[#00a884]">
                                    <svg viewBox="0 0 16 16" width="24" height="24" fill="currentColor">
                                        <path d="M13 2.5a1.5 1.5 0 0 1 3 0v11a1.5 1.5 0 0 1-3 0v-.214c-2.162-1.241-4.49-1.843-6.912-2.083l.405 2.712A1 1 0 0 1 5.51 15.1h-.548a1 1 0 0 1-.916-.599l-1.85-3.49-.202-.003A2.014 2.014 0 0 1 0 9V7a2.02 2.02 0 0 1 1.992-2.013 75 75 0 0 0 2.483-.075c3.043-.154 6.148-.849 8.525-2.199zm1 0v11a.5.5 0 0 0 1 0v-11a.5.5 0 0 0-1 0m-1 1.35c-2.344 1.205-5.209 1.842-8 2.033v4.233q.27.015.537.036c2.568.189 5.093.744 7.463 1.993zm-9 6.215v-4.13a95 95 0 0 1-1.992.052A1.02 1.02 0 0 0 1 7v2c0 .55.448 1.002 1.006 1.009A61 61 0 0 1 4 10.065m-.657.975 1.609 3.037.01.024h.548l-.002-.014-.443-2.966a68 68 0 0 0-1.722-.082z"/>
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1 border-b border-[#202c33] pb-3 pt-1 min-w-0 pr-6 relative">
                                    <div class="flex justify-between items-center">
                                        <h4 class="text-[16px] text-[#e9edef] truncate mr-2 font-normal">${safeName}</h4>
                                        <span class="text-[12px] text-[#8696a0] whitespace-nowrap">${timeStr}</span>
                                    </div>
                                    <p class="text-[14px] text-[#8696a0] truncate mt-0.5 leading-snug">${prefix}${highlightedMsg}</p>
                                </div>
                                <div class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-[#202c33] via-[#202c33] to-transparent hidden group-hover:flex items-center justify-end pr-3 z-20 options-btn-gradient">
                                    <button class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none">
                                        <svg viewBox="0 0 19 20" width="19" height="20" fill="currentColor">
                                            <path d="M3.8 6.7l5.7 5.7 5.7-5.7 1.6 1.6-7.3 7.2-7.3-7.2 1.6-1.6z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        `;
                        
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = bcastMsgHtml.trim();
                        const element = tempDiv.firstChild;
                        
                        element.onclick = function() {
                            window.selectChat(r.chatId, safeName, safePhone, avatar, safeAbout, r.msg.time || 0);
                        };
                        
                        const optBtn = element.querySelector('.options-btn-gradient button');
                        if (optBtn) {
                            optBtn.onclick = function(e) {
                                e.stopPropagation();
                                window.toggleUserContextMenu(e, r.chatId, safeName, 'user');
                            };
                        }
                        
                        msgsList.appendChild(element);
                    });
                    
                    if (msgsSection) msgsSection.classList.remove('hidden');
                    if (noResults) noResults.classList.add('hidden');
                }
            };
        }

        if (window.selectChat) {
            const originalSelectChat = window.selectChat;
            window.selectChat = function(otherUserId, name, phone, avatar = null, about = null, searchMsgTime = null) {
                if (window.closeBroadcastInfo) window.closeBroadcastInfo();
                if (typeof otherUserId === 'string' && otherUserId.startsWith('broadcast_')) {
                    // Clean up existing active state
                    document.querySelectorAll('.user-chat-item').forEach(el => el.classList.remove('active'));

                    // Set active highlight on the clicked item
                    const activeItem = document.getElementById(`user_sidebar_${otherUserId}`);
                    if (activeItem) activeItem.classList.add('active');
                    
                    // Set current chat state
                    window.currentChatId = otherUserId;
                    window.activeChatName = name;
                    window.activeChatAvatar = 'https://ui-avatars.com/api/?name=B&background=00a884&color=fff';
                    window.activeChatUser = {
                        id: otherUserId,
                        name: name,
                        phone: phone,
                        avatar: window.activeChatAvatar,
                        about: about
                    };
                    
                    // Unsubscribe previous Firebase listeners
                    if (window.statusUnsubscribe) window.statusUnsubscribe();
                    if (window.unsubscribeAdded) window.unsubscribeAdded();
                    if (window.unsubscribeRemoved) window.unsubscribeRemoved();
                    if (window.unsubscribeChanged) window.unsubscribeChanged();
                    if (window.unsubscribePinnedMsg) {
                        window.unsubscribePinnedMsg();
                        window.unsubscribePinnedMsg = null;
                    }
                    
                    // Toggle views
                    document.getElementById('chat_empty_state')?.classList.add('hidden');
                    document.getElementById('active_group_chat_content')?.classList.add('hidden');
                    document.getElementById('meta_ai_content')?.classList.add('hidden');
                    document.getElementById('active_chat_content')?.classList.remove('hidden');
                    document.getElementById('active_chat_content')?.classList.add('flex');
                    
                    // Hide call buttons for broadcast lists
                    const callBtn = document.getElementById('call_btn_pill');
                    if (callBtn) {
                        callBtn.style.setProperty('display', 'none', 'important');
                    }
                    
                    // Set title and subtitle in the chat header
                    const titleEl = document.getElementById('active_chat_title');
                    const subtitleEl = document.getElementById('active_chat_subtitle');
                    const avatarEl = document.getElementById('active_chat_avatar');
                    
                    if (titleEl) titleEl.textContent = name;
                    if (subtitleEl) {
                        subtitleEl.textContent = phone;
                        subtitleEl.classList.remove('hidden');
                        subtitleEl.className = "text-xs text-[#8696a0] font-normal";
                    }
                    if (avatarEl) {
                        avatarEl.innerHTML = `
                             <div class="w-10 h-10 rounded-full bg-[#00a884]/20 flex items-center justify-center text-[#00a884]">
                                 <svg viewBox="0 0 16 16" width="24" height="24" fill="currentColor">
                                     <path d="M13 2.5a1.5 1.5 0 0 1 3 0v11a1.5 1.5 0 0 1-3 0v-.214c-2.162-1.241-4.49-1.843-6.912-2.083l.405 2.712A1 1 0 0 1 5.51 15.1h-.548a1 1 0 0 1-.916-.599l-1.85-3.49-.202-.003A2.014 2.014 0 0 1 0 9V7a2.02 2.02 0 0 1 1.992-2.013 75 75 0 0 0 2.483-.075c3.043-.154 6.148-.849 8.525-2.199zm1 0v11a.5.5 0 0 0 1 0v-11a.5.5 0 0 0-1 0m-1 1.35c-2.344 1.205-5.209 1.842-8 2.033v4.233q.27.015.537.036c2.568.189 5.093.744 7.463 1.993zm-9 6.215v-4.13a95 95 0 0 1-1.992.052A1.02 1.02 0 0 0 1 7v2c0 .55.448 1.002 1.006 1.009A61 61 0 0 1 4 10.065m-.657.975 1.609 3.037.01.024h.548l-.002-.014-.443-2.966a68 68 0 0 0-1.722-.082z"/>
                                 </svg>
                             </div>
                        `;
                    }
                    
                    // Clear messages box and render local broadcast history
                    const messagesContainer = document.getElementById('messages');
                    if (messagesContainer) {
                        messagesContainer.innerHTML = '';
                        
                        const bcastMessages = JSON.parse(localStorage.getItem('bcast_msgs_' + otherUserId) || '[]');
                        let lastDateString = null;
                        
                        bcastMessages.forEach((msg, index) => {
                            const dateHeader = window.getDateHeader ? window.getDateHeader(msg.time) : new Date(msg.time * 1000).toLocaleDateString();
                            if (dateHeader !== lastDateString) {
                                lastDateString = dateHeader;
                                const headerHtml = `
                                    <div class="flex justify-center my-3 sticky top-0 z-[5]">
                                        <div class="bg-[#182229]/90 backdrop-blur-sm text-[#8696a0] text-[11px] px-3 py-1 rounded-lg shadow-sm font-medium uppercase tracking-wider border border-[#202c33]">
                                            ${dateHeader}
                                        </div>
                                    </div>`;
                                messagesContainer.insertAdjacentHTML('beforeend', headerHtml);
                            }
                            
                            const timeStr = msg.time ? new Date(msg.time * 1000).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : '';
                            
                            // Build media preview/content if available
                            let mediaContent = '';
                            if (msg.type === 'image' && msg.file_url) {
                                mediaContent = `<img src="${msg.file_url}" class="max-w-[200px] sm:max-w-xs rounded-lg mb-2 object-cover cursor-pointer hover:opacity-90" onclick="window.open('${msg.file_url}', '_blank')">`;
                            } else if (msg.type === 'video' && msg.file_url) {
                                mediaContent = `<video src="${msg.file_url}" controls class="max-w-[200px] sm:max-w-xs rounded-lg mb-2"></video>`;
                            } else if (msg.type === 'audio' && msg.file_url) {
                                mediaContent = `<audio src="${msg.file_url}" controls class="max-w-[200px] sm:max-w-xs mb-2"></audio>`;
                            } else if (msg.type === 'document' && msg.file_url) {
                                const fileColor = window.getFileColor ? window.getFileColor(msg.file_name) : '#1e88e5';
                                const fileExt = window.getFileExt ? window.getFileExt(msg.file_name) : 'DOC';
                                mediaContent = `
                                    <div class="relative rounded-lg overflow-hidden border border-black/10 bg-black/5 mb-1 cursor-pointer hover:bg-black/10 transition-colors w-[260px] sm:w-[280px]" onclick="window.open('${msg.file_url}', '_blank')">
                                        <div class="h-[140px] bg-white flex flex-col items-center justify-center border-b border-black/5 relative">
                                            <div class="w-[80px] h-[100px] bg-white border border-gray-200 rounded shadow-sm flex flex-col p-3 gap-2">
                                                <div class="w-full h-1.5 bg-gray-200 rounded-full"></div>
                                                <div class="w-5/6 h-1.5 bg-gray-200 rounded-full"></div>
                                                <div class="w-full h-1.5 bg-gray-200 rounded-full"></div>
                                                <div class="w-3/4 h-1.5 bg-gray-200 rounded-full"></div>
                                                <div class="w-1/2 h-1.5 bg-gray-200 rounded-full mt-auto"></div>
                                            </div>
                                        </div>
                                        <div class="p-3 flex items-center gap-3">
                                            <div class="w-10 h-10 rounded flex items-center justify-center shrink-0 text-[11px] font-bold text-white shadow-sm" style="background-color: ${fileColor}">
                                                ${fileExt}
                                            </div>
                                            <div class="flex-1 min-w-0 text-left">
                                                <div class="text-[15px] font-medium text-[#111b21] truncate leading-tight">${msg.file_name || 'Document'}</div>
                                                <div class="text-[12px] text-gray-500 mt-1 truncate">${fileExt} Document</div>
                                            </div>
                                        </div>
                                    </div>`;
                            } else if ((msg.type === 'location' || msg.type === 'live_location') && msg.lat && msg.lng) {
                                const lat = parseFloat(msg.lat);
                                const lng = parseFloat(msg.lng);
                                const isLive = msg.type === 'live_location';
                                mediaContent = `
                                    <div class="mb-2 relative rounded-lg overflow-hidden border border-gray-200 w-[250px] max-w-[100%] h-[150px] bg-gray-100 flex items-center justify-center">
                                        <iframe width="100%" height="150" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.openstreetmap.org/export/embed.html?bbox=${lng - 0.005}%2C${lat - 0.005}%2C${lng + 0.005}%2C${lat + 0.005}&amp;layer=mapnik&amp;marker=${lat}%2C${lng}" class="w-full absolute inset-0 pointer-events-none opacity-80"></iframe>
                                        <div class="z-20 relative flex flex-col items-center">
                                            ${isLive ? `
                                                <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur border border-white/50 flex flex-col items-center justify-center overflow-hidden relative shadow-lg">
                                                    <div class="absolute inset-0 bg-[#1dae75] rounded-full animate-ping opacity-70"></div>
                                                    <div class="w-10 h-10 rounded-full bg-[#202c33] border-2 border-[#1dae75] flex items-center justify-center text-white font-bold text-lg relative z-10">
                                                        B
                                                    </div>
                                                </div>
                                            ` : `
                                                <div class="w-10 h-10 rounded-full bg-white shadow-md flex items-center justify-center text-[#ea4335]">
                                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"></path></svg>
                                                </div>
                                            `}
                                        </div>
                                        <a href="https://www.google.com/maps?q=${lat},${lng}" target="_blank" class="absolute inset-0 z-30 flex flex-col justify-end group">
                                            <div class="bg-white/90 text-[#111b21] text-xs p-2 text-center backdrop-blur-sm border-t border-gray-200 flex justify-between items-center group-hover:bg-gray-100 transition-colors">
                                                <span class="font-medium truncate">Google Maps</span>
                                                <svg class="w-4 h-4 text-[#8696a0]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
                                            </div>
                                        </a>
                                    </div>`;
                            }

                            const msgType = msg.type || 'text';
                            let textToRender = '';
                            if (msgType === 'text') {
                                textToRender = msg.text || '';
                            } else {
                                if (msg.file_url || (msg.lat && msg.lng)) {
                                    textToRender = msg.caption || '';
                                } else {
                                    textToRender = msg.text || '';
                                }
                            }
                            const hasText = !!textToRender;

                            const msgHtml = `
                                <div class="flex justify-end mb-2 pr-4 pl-12 relative group/msg" id="msg_broadcast_msg_${index}">
                                    <div class="bg-[#005c4b] text-white rounded-lg px-2.5 py-1.5 shadow-sm max-w-[85%] relative min-w-[80px]">
                                        ${mediaContent}
                                        ${hasText ? `
                                            <div class="text-[14.2px] text-[#e9edef] leading-relaxed break-words pb-[2px]" style="white-space: pre-wrap; word-break: break-word;">
                                                ${escapeHtml(textToRender)}<span class="inline-block w-[99px] h-[1px]"></span>
                                            </div>
                                        ` : `
                                            <div class="h-[10px]"></div>
                                        `}
                                        <div class="flex items-center justify-end gap-1 absolute bottom-1 right-2 bg-transparent select-none">
                                            <span class="text-[11px] text-[#8696a0] select-none leading-none">${timeStr}</span>
                                            <span class="shrink-0 flex items-center justify-center leading-none">
                                                ${window.getTickSVG ? window.getTickSVG('sent') : `
                                                    <svg viewBox="0 0 16 15" width="16" height="15" fill="#8696a0">
                                                        <path d="M15.01 3.3L8.07 11.59l-3.8-3.8-.7-.7-1.4 1.4 5.2 5.2 7.7-9.09-.06-.06-.03-.05.03-.04z"/>
                                                    </svg>
                                                `}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            `;
                            messagesContainer.insertAdjacentHTML('beforeend', msgHtml);
                        });
                        
                        const parent = messagesContainer.parentElement;
                        if (parent) parent.scrollTop = parent.scrollHeight;
                    }
                    
                    if (window.applyGlobalWallpaper) window.applyGlobalWallpaper();
                    document.getElementById('msg')?.focus();
                } else {
                    const callBtn = document.getElementById('call_btn_pill');
                    if (callBtn) {
                        callBtn.style.display = '';
                    }
                    
                    originalSelectChat.apply(this, arguments);
                    if (window.applyGlobalWallpaper) window.applyGlobalWallpaper();
                }
            };
        }
        
        let lastBroadcastSentText = '';
        let lastBroadcastSentTime = 0;

        // Hijack window.fetch to capture and broadcast all message types (Text, Image, Video, Document, Location, Audio, etc.)
        const originalFetch = window.fetch;
        window.fetch = async function(url, options) {
            if (typeof url === 'string' && (url === '/send' || url.endsWith('/send')) && options && options.method === 'POST' && options.body instanceof FormData) {
                const fd = options.body;
                const chatId = fd.get('chat_id');
                if (chatId && chatId.startsWith('broadcast_')) {
                    const listId = chatId.replace('broadcast_', '');
                    const list = window.broadcastLists?.find(l => l.id === listId);
                    if (!list) return originalFetch(url, options);

                    const msgText = fd.get('message') || '';
                    const fileObj = fd.get('file');
                    let msgType = fd.get('type') || 'text';
                    if (msgType === 'text' && fileObj && typeof fileObj.type === 'string') {
                        if (fileObj.type.startsWith('image/')) {
                            msgType = 'image';
                        } else if (fileObj.type.startsWith('video/')) {
                            msgType = 'video';
                        } else if (fileObj.type.startsWith('audio/')) {
                            msgType = 'audio';
                        } else {
                            msgType = 'document';
                        }
                    }

                    // Deduplicate calls within 1.5 seconds
                    const nowTime = Date.now();
                    const dedupeKey = msgText + '_' + msgType + '_' + (fileObj ? fileObj.name : '');
                    if (dedupeKey === lastBroadcastSentText && (nowTime - lastBroadcastSentTime) < 1500) {
                        return new Response(JSON.stringify({ status: true }), { status: 200, headers: { 'Content-Type': 'application/json' } });
                    }
                    lastBroadcastSentText = dedupeKey;
                    lastBroadcastSentTime = nowTime;

                    // Update limits/stats
                    let sentCount = parseInt(localStorage.getItem('broadcast_sent_count') || '0');
                    sentCount++;
                    localStorage.setItem('broadcast_sent_count', sentCount.toString());
                    window.updateBroadcastStats?.();

                    // Format text for local storage history
                    let localMsgText = msgText;
                    if (msgType === 'image') localMsgText = '📷 Photo' + (msgText ? ': ' + msgText : '');
                    else if (msgType === 'video') localMsgText = '🎥 Video' + (msgText ? ': ' + msgText : '');
                    else if (msgType === 'audio') localMsgText = '🎤 Voice note';
                    else if (msgType === 'document') localMsgText = '📄 ' + (fileObj ? fileObj.name : 'Document');
                    else if (msgType === 'location') localMsgText = '📍 Location';
                    else if (msgType === 'live_location') localMsgText = '📍 Live location';

                    // Save to local storage history with temp/local media URL support
                    let localFileUrl = null;
                    if (fileObj && fileObj instanceof File) {
                        try {
                            localFileUrl = URL.createObjectURL(fileObj);
                        } catch (e) {}
                    }

                    // Save to local storage history
                    const bcastMessages = JSON.parse(localStorage.getItem('bcast_msgs_' + chatId) || '[]');
                    const nowSec = Math.floor(Date.now() / 1000);
                    const tempMsgId = 'msg_' + nowSec + '_' + Math.random().toString(36).substr(2, 9);
                    const newMsg = {
                        id: tempMsgId,
                        text: localMsgText,
                        caption: msgText,
                        time: nowSec,
                        type: msgType,
                        file_url: localFileUrl,
                        file_name: fileObj ? fileObj.name : null,
                        lat: fd.get('lat') || null,
                        lng: fd.get('lng') || null
                    };
                    bcastMessages.push(newMsg);
                    localStorage.setItem('bcast_msgs_' + chatId, JSON.stringify(bcastMessages));

                    // Refresh active chat panel locally
                    if (window.currentChatId === chatId) {
                        if (window.selectChat) {
                            window.selectChat(chatId, list.name, `Broadcast (${list.recipients.length} recipients)`);
                        }
                    }

                    // Forward to all recipients
                    for (const recipient of list.recipients) {
                        const minId = Math.min(window.myUserId, recipient.id);
                        const maxId = Math.max(window.myUserId, recipient.id);
                        const recipientChatId = `chat_${minId}_${maxId}`;

                        const recipientFd = new FormData();
                        for (const [key, value] of fd.entries()) {
                            if (key === 'chat_id') {
                                recipientFd.append('chat_id', recipientChatId);
                            } else {
                                recipientFd.append(key, value);
                            }
                        }

                        originalFetch('/send', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': window.csrf || document.querySelector('meta[name="csrf-token"]')?.content || ''
                            },
                            body: recipientFd
                        }).then(() => {
                            // Find and update pushed Firebase message to set is_broadcast: true
                            if (window.ref && window.db && window.query && window.limitToLast && window.get) {
                                const msgRef = window.ref(window.db, `chats/${recipientChatId}/messages`);
                                const lastMsgQuery = window.query(msgRef, window.limitToLast(5));
                                window.get(lastMsgQuery).then(snapshot => {
                                    if (snapshot.exists()) {
                                        snapshot.forEach(child => {
                                            const val = child.val();
                                            if (val.sender_id == window.myUserId && val.type === msgType && !val.is_broadcast) {
                                                let textMatch = val.text === msgText;
                                                if (msgType === 'document' || msgType === 'image' || msgType === 'video' || msgType === 'audio') {
                                                    textMatch = true;
                                                }
                                                if (textMatch) {
                                                    const childRef = window.ref(window.db, `chats/${recipientChatId}/messages/${child.key}`);
                                                    window.update(childRef, { is_broadcast: true }).catch(err => {});
                                                    
                                                    // Sync media details from firebase back to broadcast history
                                                    const currentBcastMsgs = JSON.parse(localStorage.getItem('bcast_msgs_' + chatId) || '[]');
                                                    const targetMsg = currentBcastMsgs.find(m => m.id === tempMsgId || (m.type === msgType && m.time >= nowSec - 10 && m.time <= nowSec + 10 && (!m.file_url || m.file_url.startsWith('blob:'))));
                                                    if (targetMsg) {
                                                        if (val.file_url) targetMsg.file_url = val.file_url;
                                                        if (val.file_name) targetMsg.file_name = val.file_name;
                                                        if (val.lat) targetMsg.lat = val.lat;
                                                        if (val.lng) targetMsg.lng = val.lng;
                                                        localStorage.setItem('bcast_msgs_' + chatId, JSON.stringify(currentBcastMsgs));
                                                        
                                                        if (window.currentChatId === chatId && window.selectChat) {
                                                            window.selectChat(chatId, list.name, `Broadcast (${list.recipients.length} recipients)`);
                                                        }
                                                    }
                                                }
                                            }
                                        });
                                    }
                                }).catch(err => {});
                            }
                        }).catch(err => {});
                    }

                    window.showToast?.('Broadcast Sent', `Broadcast message sent to all ${list.recipients.length} recipients.`);
                    return new Response(JSON.stringify({ status: true }), { status: 200, headers: { 'Content-Type': 'application/json' } });
                }
            }
            return originalFetch(url, options);
        };

        // MutationObserver to add megaphone icon to broadcasted messages in private chats on sender's side
        const messagesContainer = document.getElementById('messages');
        if (messagesContainer) {
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    mutation.addedNodes.forEach((node) => {
                        if (node.nodeType === 1 && node.id && node.id.startsWith('msg_')) {
                            const key = node.id.replace('msg_', '');
                            const msgData = window.globalMessages?.[key];
                            if (msgData && msgData.sender_id == window.myUserId && msgData.is_broadcast) {
                                // Find the time element container inside the bubble
                                const timeContainer = node.querySelector('.absolute.bottom-1.right-2');
                                if (timeContainer && !timeContainer.querySelector('.broadcast-megaphone-icon')) {
                                    const megaphoneSvg = `
                                        <span class="broadcast-megaphone-icon shrink-0 flex items-center justify-center mr-0.5" title="Sent via broadcast" style="display: inline-flex; vertical-align: middle;">
                                            <svg viewBox="0 0 16 16" width="11" height="11" fill="#8696a0">
                                                <path d="M13 2.5a1.5 1.5 0 0 1 3 0v11a1.5 1.5 0 0 1-3 0v-.214c-2.162-1.241-4.49-1.843-6.912-2.083l.405 2.712A1 1 0 0 1 5.51 15.1h-.548a1 1 0 0 1-.916-.599l-1.85-3.49-.202-.003A2.014 2.014 0 0 1 0 9V7a2.02 2.02 0 0 1 1.992-2.013 75 75 0 0 0 2.483-.075c3.043-.154 6.148-.849 8.525-2.199zm1 0v11a.5.5 0 0 0 1 0v-11a.5.5 0 0 0-1 0m-1 1.35c-2.344 1.205-5.209 1.842-8 2.033v4.233q.27.015.537.036c2.568.189 5.093.744 7.463 1.993zm-9 6.215v-4.13a95 95 0 0 1-1.992.052A1.02 1.02 0 0 0 1 7v2c0 .55.448 1.002 1.006 1.009A61 61 0 0 1 4 10.065m-.657.975 1.609 3.037.01.024h.548l-.002-.014-.443-2.966a68 68 0 0 0-1.722-.082z"/>
                                            </svg>
                                        </span>
                                    `;
                                    // Prepend before the time text span
                                    const timeSpan = timeContainer.querySelector('span.text-\\[11px\\]');
                                    if (timeSpan) {
                                        timeSpan.insertAdjacentHTML('beforebegin', megaphoneSvg);
                                    } else {
                                        timeContainer.insertAdjacentHTML('afterbegin', megaphoneSvg);
                                    }
                                }
                            }
                        }
                    });
                });
            });
            observer.observe(messagesContainer, { childList: true, subtree: true });
        }

        // Hijack window.togglePrivateHeaderMoreMenu to display custom options for Broadcast lists
        if (window.togglePrivateHeaderMoreMenu) {
            const originalToggle = window.togglePrivateHeaderMoreMenu;

            window.renderBroadcastMainMenu = function(dropdown) {
                if (!dropdown) return;
                dropdown.innerHTML = `
                    <button onclick="window.openContactInfo(); window.togglePrivateHeaderMoreMenu()"
                        class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                            class="text-[15px]">Broadcast list info</span></button>
                    <button onclick="window.showToast?.('Info', 'Media gallery is available inside Broadcast list info.'); window.togglePrivateHeaderMoreMenu()"
                        class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                            class="text-[15px]">Broadcast list media</span></button>
                    <button onclick="window.toggleSearchPanel(); window.togglePrivateHeaderMoreMenu()"
                        class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                            class="text-[15px]">Search</span></button>
                    <button onclick="window.openAddToListModal('user_sidebar_' + window.currentChatId); window.togglePrivateHeaderMoreMenu()"
                        class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                            class="text-[15px]">Add to list</span></button>
                    <button onclick="window.showBroadcastMoreMenu(event)"
                        class="w-full flex items-center justify-between px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors">
                        <span class="text-[15px]">More</span>
                        <svg class="w-4 h-4 text-[#8696a0]" fill="currentColor" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>
                    </button>
                `;
            };

            window.showBroadcastMoreMenu = function(event) {
                if (event) event.stopPropagation();
                const dropdown = document.getElementById('private_header_more_dropdown');
                if (!dropdown) return;
                dropdown.innerHTML = `
                    <button onclick="window.goBackToBroadcastMenu(event)"
                        class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors">
                        <svg class="w-4 h-4 text-[#8696a0] rotate-180" fill="currentColor" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>
                        <span class="text-[15px] font-semibold">Back</span>
                    </button>
                    <button onclick="if(confirm('Clear all messages in this broadcast list?')) { window.clearChatMessages(window.currentChatId, 'user'); }; window.togglePrivateHeaderMoreMenu()"
                        class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                            class="text-[15px]">Clear chat</span></button>
                    <button onclick="window.exportBroadcastChat(window.currentChatId, window.activeChatName); window.togglePrivateHeaderMoreMenu()"
                        class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                            class="text-[15px]">Export chat</span></button>
                    <button onclick="window.addBroadcastShortcut(window.currentChatId, window.activeChatName); window.togglePrivateHeaderMoreMenu()"
                        class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                            class="text-[15px]">Add shortcut</span></button>
                `;
            };

            window.goBackToBroadcastMenu = function(event) {
                if (event) event.stopPropagation();
                const dropdown = document.getElementById('private_header_more_dropdown');
                window.renderBroadcastMainMenu(dropdown);
            };

            window.togglePrivateHeaderMoreMenu = function(event) {
                const dropdown = document.getElementById('private_header_more_dropdown');
                if (window.currentChatId && window.currentChatId.startsWith('broadcast_')) {
                    if (event) event.stopPropagation();
                    if (!dropdown) return;
                    
                    const isHidden = dropdown.classList.contains('hidden');
                    if (isHidden) {
                        // Render broadcast main menu
                        window.renderBroadcastMainMenu(dropdown);
                        dropdown.classList.remove('hidden');
                        setTimeout(() => {
                            dropdown.classList.remove('opacity-0', 'scale-95');
                            dropdown.classList.add('opacity-100', 'scale-100');
                        }, 10);
                    } else {
                        dropdown.classList.remove('opacity-100', 'scale-100');
                        dropdown.classList.add('opacity-0', 'scale-95');
                        setTimeout(() => dropdown.classList.add('hidden'), 200);
                    }
                } else {
                    // Restore original dropdown options if it was customized for broadcast
                    if (dropdown && (dropdown.innerHTML.includes('Broadcast list info') || dropdown.innerHTML.includes('Add shortcut'))) {
                        dropdown.innerHTML = `
                            <button onclick="window.openContactInfo(); togglePrivateHeaderMoreMenu()"
                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                    class="text-[15px]">Contact info</span></button>
                            <button onclick="toggleSearchPanel(); togglePrivateHeaderMoreMenu()"
                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                    class="text-[15px]">Search</span></button>
                            <button onclick="window.selectMessage(); togglePrivateHeaderMoreMenu()"
                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                    class="text-[15px]">Select messages</span></button>
                            <button
                                onclick="window.toggleMuteChat(window.activeChatUser.id, 'user', window.mutedChats[\`user_sidebar_\${window.activeChatUser.id}\`] ? null : 'always'); togglePrivateHeaderMoreMenu()"
                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                    class="text-[15px]" id="private_header_mute_text">Mute
                                    notifications</span></button>
                            <button onclick="togglePrivateHeaderMoreMenu()"
                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                    class="text-[15px]">Disappearing messages</span></button>
                            <button
                                onclick="window.toggleLockChat(window.activeChatUser.id, 'user'); togglePrivateHeaderMoreMenu()"
                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                    class="text-[15px]" id="private_header_lock_text">Lock
                                    chat</span></button>
                            <button
                                onclick="window.toggleFavouriteChat(window.activeChatUser.id, 'user'); window.updatePrivateHeaderFavouriteText(); togglePrivateHeaderMoreMenu()"
                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                    class="text-[15px]" id="private_header_favourite_text">Add to
                                    favourites</span></button>
                            <button onclick="togglePrivateHeaderMoreMenu()"
                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                    class="text-[15px]">Add to list</span></button>
                            <button onclick="window.closeChat(); togglePrivateHeaderMoreMenu()"
                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                    class="text-[15px]">Close chat</span></button>
                            <button onclick="window.reportContact(); togglePrivateHeaderMoreMenu()"
                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                    class="text-[15px]">Report</span></button>
                            <button
                                onclick="window.toggleBlockContact(window.activeChatUser.id, 'user'); window.updateBlockedUI(); togglePrivateHeaderMoreMenu()"
                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                    class="text-[15px]" id="private_header_block_text">Block</span></button>
                            <div class="h-[1px] bg-[#313d45] my-1 mx-4"></div>
                            <button
                                onclick="if(confirm('Clear this chat?')) { window.clearChatMessages(window.activeChatUser.id, 'user'); }; togglePrivateHeaderMoreMenu()"
                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                    class="text-[15px]">Clear chat</span></button>
                            <button
                                onclick="if(window.openDeleteModal) { window.openDeleteModal('Delete this chat?', () => { window.deleteChatMessages(window.activeChatUser.id, 'user'); togglePrivateHeaderMoreMenu(); }); } else { if(confirm('Delete this chat?')) { window.deleteChatMessages(window.activeChatUser.id, 'user'); togglePrivateHeaderMoreMenu(); } }"
                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#ea5656] hover:bg-[#182229] transition-colors"><span
                                    class="text-[15px]">Delete chat</span></button>
                        `;
                    }
                    originalToggle.apply(this, arguments);
                }
            };
        }
        // Hijack window.performMessageSearch to support local broadcast messages search
        if (window.performMessageSearch) {
            const originalPerformSearch = window.performMessageSearch;
            window.performMessageSearch = function(query) {
                if (window.currentChatId && window.currentChatId.startsWith('broadcast_')) {
                    const clearBtn = document.getElementById('clear_search_btn');
                    const resultsList = document.getElementById('search_results_list');
                    const noResults = document.getElementById('no_results_text');
                    
                    if (!query.trim()) {
                        if (clearBtn) clearBtn.classList.add('hidden');
                        if (resultsList) resultsList.innerHTML = '';
                        if (noResults) noResults.classList.remove('hidden');
                        return;
                    }
                    
                    if (clearBtn) clearBtn.classList.remove('hidden');
                    if (noResults) noResults.classList.add('hidden');
                    
                    const searchTerm = query.toLowerCase();
                    const bcastMessages = JSON.parse(localStorage.getItem('bcast_msgs_' + window.currentChatId) || '[]');
                    const results = [];
                    
                    bcastMessages.forEach((msg, index) => {
                        const text = msg.caption || msg.text || '';
                        if (text.toLowerCase().includes(searchTerm)) {
                            results.push({
                                text: text,
                                time: msg.time,
                                key: `broadcast_msg_${index}`,
                                sender_id: window.myUserId
                            });
                        }
                    });
                    
                    results.sort((a, b) => b.time - a.time);
                    if (window.renderMessageSearchResults) {
                        window.renderMessageSearchResults(results, searchTerm);
                    }
                } else {
                    originalPerformSearch.apply(this, arguments);
                }
            };
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initBroadcastHijacks);
    } else {
        initBroadcastHijacks();
    }
</script>
