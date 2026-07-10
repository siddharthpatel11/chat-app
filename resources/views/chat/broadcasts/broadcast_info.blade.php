<div id="broadcast_info_panel"
    class="fixed top-0 right-0 h-screen w-[400px] bg-[#111b21] border-l border-[#313d45] z-[400] flex flex-col shadow-2xl transition-all duration-300 translate-x-full">
    
    <!-- Header -->
    <div class="h-[60px] bg-[#202c33] flex items-center px-4 gap-6 shrink-0 justify-between relative">
        <div class="flex items-center gap-6">
            <button onclick="closeBroadcastInfo()" class="text-[#aebac1] hover:text-[#e9edef] transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path>
                </svg>
            </button>
            <span class="text-[#e9edef] text-[16px] font-medium">Broadcast list info</span>
        </div>
        
        <!-- Three dots menu -->
        <div class="relative">
            <button id="bcast_info_menu_btn" onclick="toggleBcastInfoDropdown(event)" class="text-[#aebac1] hover:text-[#e9edef] p-2 rounded-full transition-colors focus:outline-none">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
                </svg>
            </button>
            
            <!-- Menu Dropdown -->
            <div id="bcast_info_menu_dropdown" class="hidden absolute right-0 top-11 w-56 bg-[#233138] rounded-lg shadow-xl border border-[#313d45] py-2 z-[410]">
                <button onclick="openEditRecipients(); toggleBcastInfoDropdown(event)" class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px]">
                    Add recipient...
                </button>
                <button onclick="openChangeBroadcastName(); toggleBcastInfoDropdown(event)" class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px]">
                    Change broadcast list name
                </button>
            </div>
        </div>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar">
        <!-- Megaphone Avatar Section -->
        <div class="bg-[#111b21] py-8 flex flex-col items-center text-center px-4">
            <div class="w-[150px] h-[150px] rounded-full bg-[#00a884]/15 flex items-center justify-center mb-5 border-4 border-[#202c33] shadow-lg text-[#00a884]">
                <svg viewBox="0 0 16 16" width="80" height="80" fill="currentColor">
                    <path d="M13 2.5a1.5 1.5 0 0 1 3 0v11a1.5 1.5 0 0 1-3 0v-.214c-2.162-1.241-4.49-1.843-6.912-2.083l.405 2.712A1 1 0 0 1 5.51 15.1h-.548a1 1 0 0 1-.916-.599l-1.85-3.49-.202-.003A2.014 2.014 0 0 1 0 9V7a2.02 2.02 0 0 1 1.992-2.013 75 75 0 0 0 2.483-.075c3.043-.154 6.148-.849 8.525-2.199zm1 0v11a.5.5 0 0 0 1 0v-11a.5.5 0 0 0-1 0m-1 1.35c-2.344 1.205-5.209 1.842-8 2.033v4.233q.27.015.537.036c2.568.189 5.093.744 7.463 1.993zm-9 6.215v-4.13a95 95 0 0 1-1.992.052A1.02 1.02 0 0 0 1 7v2c0 .55.448 1.002 1.006 1.009A61 61 0 0 1 4 10.065m-.657.975 1.609 3.037.01.024h.548l-.002-.014-.443-2.966a68 68 0 0 0-1.722-.082z"/>
                </svg>
            </div>
            <div class="flex items-center gap-2 justify-center w-full px-4">
                <h2 class="text-[#e9edef] text-[22px] font-normal truncate max-w-[280px]" id="bcast_info_name">Untitled List</h2>
                <button onclick="openChangeBroadcastName()" class="text-[#8696a0] hover:text-[#e9edef] p-1.5 rounded-full hover:bg-[#202c33] transition-colors shrink-0">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path>
                    </svg>
                </button>
            </div>
            <span class="text-[#8696a0] text-[14px] mt-1" id="bcast_info_subtitle">Broadcast List · 2 recipients</span>
            <span class="text-[#667781] text-[12px] mt-0.5" id="bcast_info_created_at">Created 08/06/26, 10:00 am</span>
        </div>

        <div class="h-[10px] bg-[#0c1317]"></div>

        <!-- Encryption Notice Card -->
        <div class="p-5 flex gap-4 hover:bg-[#202c33]/20 transition-colors cursor-pointer">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0] shrink-0 mt-0.5">
                <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
            </svg>
            <div class="flex flex-col gap-0.5">
                <span class="text-[#e9edef] text-[14.5px] font-normal">Encryption</span>
                <span class="text-[#8696a0] text-[13px] leading-snug">Messages are end-to-end encrypted. Tap to learn more.</span>
            </div>
        </div>

        <div class="h-[10px] bg-[#0c1317]"></div>

        <!-- Recipients List Section -->
        <div class="py-3">
            <div class="px-5 pb-2">
                <span class="text-[#8696a0] text-[14px]" id="bcast_info_recipients_title">2 recipients</span>
            </div>
            
            <div class="flex flex-col">
                <!-- Edit Recipients Action -->
                <div onclick="openEditRecipients()" class="flex items-center px-5 py-3 hover:bg-[#202c33] cursor-pointer transition-colors gap-4">
                    <div class="w-10 h-10 rounded-full bg-[#00a884] flex items-center justify-center shrink-0 text-white shadow-sm">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                            <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    <span class="text-[#e9edef] text-[15.5px]">Edit recipients</span>
                </div>
                
                <!-- Dynamic User list container -->
                <div id="bcast_info_recipients_container" class="mt-1">
                    <!-- Populated by JS -->
                </div>
            </div>
        </div>

        <div class="h-[10px] bg-[#0c1317]"></div>

        <!-- Bottom Actions -->
        <div class="flex flex-col py-2 mb-8">
            <button onclick="window.openAddToListModal('user_sidebar_broadcast_' + window.activeBroadcastList.id)" class="flex items-center px-5 py-4 gap-6 text-[#e9edef] hover:bg-[#202c33]/30 transition-colors w-full text-left focus:outline-none">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor" class="text-[#8696a0]">
                    <path d="M4 14h6v-4H4v4zm0 5h6v-4H4v4zM4 9h6V5H4v4zm12 5h6v-4h-6v4zm0 5h6v-4h-6v4zM12 9h6V5h-6v4zm0 10h6v-4h-6v4zm0-5h6v-4h-6v4zM16 5v4h6V5h-6z"/>
                </svg>
                <span class="text-[16px] text-[#e9edef]">Add to list</span>
            </button>
            <button onclick="deleteActiveBroadcastList()" class="flex items-center px-5 py-4 gap-6 text-[#ea5656] hover:bg-[#202c33]/30 transition-colors w-full text-left focus:outline-none">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path>
                </svg>
                <span class="text-[16px] font-medium">Delete broadcast list</span>
            </button>
        </div>
    </div>
</div>

<script>
    window.openBroadcastInfo = function() {
        const list = window.activeBroadcastList;
        if (!list) return;

        // Close disappearing messages if open
        if (typeof window.closeDisappearingMessagesSidebar === 'function') {
            window.closeDisappearingMessagesSidebar();
        }

        // Close search sidebar if open
        const searchSidebar = document.getElementById('search_sidebar');
        if (searchSidebar) {
            searchSidebar.classList.add('hidden');
            searchSidebar.classList.remove('flex');
        }

        // Populate details
        document.getElementById('bcast_info_name').textContent = list.name;
        document.getElementById('bcast_info_subtitle').textContent = `Broadcast List · ${list.recipients.length} recipients`;
        document.getElementById('bcast_info_recipients_title').textContent = `${list.recipients.length} recipients`;
        
        // Formatted Date
        let dateStr = "Created on " + new Date().toLocaleDateString();
        if (list.id && list.id.startsWith('bcast_')) {
            const timestamp = parseInt(list.id.split('_')[1]);
            if (!isNaN(timestamp)) {
                const dateObj = new Date(timestamp);
                const timeStr = dateObj.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                dateStr = `Created ${dateObj.toLocaleDateString([], { day: '2-digit', month: '2-digit', year: '2-digit' })}, ${timeStr}`;
            }
        }
        document.getElementById('bcast_info_created_at').textContent = dateStr;

        // Populate Recipients List
        const container = document.getElementById('bcast_info_recipients_container');
        if (container) {
            container.innerHTML = '';
            list.recipients.forEach(user => {
                const userRow = document.createElement('div');
                userRow.className = "flex items-center px-5 py-2.5 hover:bg-[#202c33]/40 cursor-pointer transition-colors";
                // Hook to select chat for this user directly
                userRow.onclick = () => {
                    closeBroadcastInfo();
                    if (window.selectChat) {
                        window.selectChat(user.id, user.name, user.phone || '', user.avatar, user.about || 'Available');
                    }
                };
                
                userRow.innerHTML = `
                    <div class="w-10 h-10 rounded-full overflow-hidden bg-[#2a3942] flex items-center justify-center shrink-0">
                        <img src="${user.avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(user.name)}" class="w-full h-full object-cover">
                    </div>
                    <div class="ml-4 flex-1 border-b border-[#202c33]/50 pb-2.5 pt-1 min-w-0">
                        <h4 class="text-[15.5px] text-[#e9edef] truncate font-normal leading-snug">${escapeHtml(user.name)}</h4>
                        <p class="text-[13px] text-[#8696a0] truncate mt-0.5">${escapeHtml(user.about || 'Available')}</p>
                    </div>
                `;
                container.appendChild(userRow);
            });
        }

        const panel = document.getElementById('broadcast_info_panel');
        const mainChat = document.getElementById('main_chat_column');

        panel.classList.remove('translate-x-full');
        panel.classList.add('translate-x-0');

        // Adjust main chat width on desktop
        if (window.innerWidth >= 640) {
            mainChat.classList.add('sm:mr-[400px]');
        }
    };

    window.closeBroadcastInfo = function() {
        const panel = document.getElementById('broadcast_info_panel');
        const mainChat = document.getElementById('main_chat_column');
        if (panel) {
            panel.classList.remove('translate-x-0');
            panel.classList.add('translate-x-full');
        }
        if (mainChat && window.innerWidth >= 640) {
            mainChat.classList.remove('sm:mr-[400px]');
        }
        // Hide Dropdown
        document.getElementById('bcast_info_menu_dropdown')?.classList.add('hidden');
    };

    window.toggleBcastInfoDropdown = function(e) {
        e.stopPropagation();
        const dropdown = document.getElementById('bcast_info_menu_dropdown');
        if (dropdown) {
            dropdown.classList.toggle('hidden');
        }
    };

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        const dropdown = document.getElementById('bcast_info_menu_dropdown');
        const btn = document.getElementById('bcast_info_menu_btn');
        if (dropdown && !dropdown.classList.contains('hidden') && btn && !btn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });

    window.deleteActiveBroadcastList = function() {
        if (!window.activeBroadcastList) return;
        const name = window.activeBroadcastList.name;
        const deleteAction = () => {
            const id = window.activeBroadcastList.id;
            window.broadcastLists = window.broadcastLists.filter(l => l.id !== id);
            localStorage.setItem('broadcast_lists', JSON.stringify(window.broadcastLists));
            
            // Close info panel
            window.closeBroadcastInfo();
            
            // Set chat back to empty state
            window.currentChatId = null;
            window.activeBroadcastList = null;
            document.getElementById('active_chat_content')?.classList.add('hidden');
            document.getElementById('chat_empty_state')?.classList.remove('hidden');
            
            // Re-render sidebar
            window.renderBroadcastLists();
            window.syncBroadcastsToSidebar?.();
            window.showToast?.('Success', 'Broadcast list deleted.');
        };

        if (window.openDeleteModal) {
            window.openDeleteModal(`Delete broadcast list "${name}"? Recipients will not be notified.`, deleteAction);
        } else if (confirm(`Delete broadcast list "${name}"? Recipients will not be notified.`)) {
            deleteAction();
        }
    };

    // Hijack opening of chat info panel dynamically
    document.addEventListener('DOMContentLoaded', () => {
        const originalOpenContactInfo = window.openContactInfo;
        window.openContactInfo = function() {
            if (window.currentChatId && window.currentChatId.startsWith('broadcast_')) {
                window.openBroadcastInfo();
            } else {
                if (typeof originalOpenContactInfo === 'function') {
                    originalOpenContactInfo();
                }
            }
        };
    });
</script>
