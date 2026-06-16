<div id="contact_info_panel"
    class="fixed top-0 right-0 h-screen w-[400px] bg-[#111b21] border-l border-[#313d45] z-[400] flex flex-col shadow-2xl transition-all duration-300 translate-x-full">
    <div class="h-[60px] bg-[#202c33] flex items-center px-4 gap-6 shrink-0 relative">
        <button onclick="closeContactInfo()" class="text-[#aebac1] hover:text-[#e9edef] transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path>
            </svg>
        </button>
        <span class="text-[#e9edef] text-[16px] font-medium">Contact info</span>
        <button onclick="openEditContact()" class="text-[#aebac1] hover:text-[#e9edef] transition-colors absolute right-4">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path>
            </svg>
        </button>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar">
        <!-- Profile Section -->
        <div class="bg-[#111b21] py-8 flex flex-col items-center text-center px-4">
            <div class="w-[200px] h-[200px] rounded-full overflow-hidden mb-5 border-4 border-[#202c33] shadow-lg">
                <img src="" class="w-full h-full object-cover" id="contact_info_avatar">
            </div>
            <h2 class="text-[#e9edef] text-[24px] font-normal mb-1 truncate w-full" id="contact_info_name">Name</h2>
            <span class="text-[#8696a0] text-[16px]" id="contact_info_phone">Phone</span>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-center gap-2 px-4 mb-6">
            <button onclick="window.toggleSearchPanel(); window.closeContactInfo()"
                class="flex-1 max-w-[100px] h-[72px] rounded-xl border border-[#313d45] hover:bg-[#202c33] flex flex-col items-center justify-center gap-2 transition-all group">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"
                    class="text-[#00a884] group-hover:scale-110 transition-transform">
                    <path
                        d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z">
                    </path>
                </svg>
                <span class="text-[#e9edef] text-xs">Search</span>
            </button>
            <button onclick="window.startVideoCall(); window.closeContactInfo()"
                class="flex-1 max-w-[100px] h-[72px] rounded-xl border border-[#313d45] hover:bg-[#202c33] flex flex-col items-center justify-center gap-2 transition-all group">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"
                    class="text-[#00a884] group-hover:scale-110 transition-transform">
                    <path
                        d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z">
                    </path>
                </svg>
                <span class="text-[#e9edef] text-xs">Video</span>
            </button>
            <button onclick="window.startVoiceCall(); window.closeContactInfo()"
                class="flex-1 max-w-[100px] h-[72px] rounded-xl border border-[#313d45] hover:bg-[#202c33] flex flex-col items-center justify-center gap-2 transition-all group">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"
                    class="text-[#00a884] group-hover:scale-110 transition-transform">
                    <path
                        d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z">
                    </path>
                </svg>
                <span class="text-[#e9edef] text-xs">Voice</span>
            </button>
        </div>

        <div class="h-[10px] bg-[#0c1317]"></div>

        <!-- About Section -->
        <div class="p-4 py-5 hover:bg-[#202c33]/30 cursor-pointer transition-colors">
            <label class="text-[#8696a0] text-[14px] mb-3 block">About</label>
            <div class="text-[#e9edef] text-[16px] leading-relaxed" id="contact_about_text">
                Available
            </div>
        </div>

        <div class="h-[10px] bg-[#0c1317]"></div>

        <!-- Media, links and docs -->
        <div class="p-4 py-5 hover:bg-[#202c33]/30 cursor-pointer transition-colors" onclick="window.openContactMediaLibrary()">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center gap-3">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0]">
                        <path
                            d="M19 5v14H5V5h14m0-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-4.86 8.86l-3 3.87L9 13.14 6 17h12l-3.86-5.14z">
                        </path>
                    </svg>
                    <span class="text-[#e9edef] text-[16px]">Media, links and docs</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-[#8696a0] text-[14px]" id="contact_media_count">0</span>
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0]">
                        <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"></path>
                    </svg>
                </div>
            </div>
            <div class="grid grid-cols-4 gap-2" id="contact_media_preview_container">
                <!-- Dynamically populated -->
            </div>
        </div>

        <div class="h-[10px] bg-[#0c1317]"></div>

        <!-- Items List -->
        <div class="flex flex-col">
            <button onclick="window.openStarredMessages()" class="flex items-center px-4 py-4 gap-4 hover:bg-[#202c33]/30 transition-colors text-left w-full">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0]">
                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                </svg>
                <span class="text-[#e9edef] text-[16px] flex-1">Starred messages</span>
                <span id="starred_count_badge" class="text-[#8696a0] text-sm">0</span>
            </button>

            <!-- Starred Messages Panel (inside contact_info_panel) -->
            <div id="starred_messages_panel" class="hidden fixed top-0 right-0 h-screen w-[400px] bg-[#111b21] border-l border-[#313d45] z-[500] flex flex-col shadow-2xl">
                <div class="h-[60px] bg-[#202c33] flex items-center px-4 gap-4 shrink-0">
                    <button onclick="document.getElementById('starred_messages_panel').classList.add('hidden')" class="text-[#aebac1] hover:text-[#e9edef]">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                    </button>
                    <span class="text-[#e9edef] text-[16px] font-medium">Starred messages</span>
                </div>
                <div id="starred_messages_list" class="flex-1 overflow-y-auto p-4 space-y-3 bg-[#111b21]">
                    <!-- Populated by JS -->
                </div>
            </div>
            <button class="flex items-center px-4 py-4 gap-4 hover:bg-[#202c33]/30 transition-colors text-left w-full">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0]">
                    <path
                        d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z">
                    </path>
                </svg>
                <span class="text-[#e9edef] text-[16px] flex-1">Notification settings</span>
            </button>
        </div>

        <div class="h-[10px] bg-[#0c1317]"></div>

        <!-- Groups in common -->
        <div class="p-4 py-5">
            <span class="text-[#8696a0] text-[14px] mb-4 block">No groups in common</span>
        </div>

        <div class="h-[10px] bg-[#0c1317]"></div>

        <!-- Bottom Actions -->
        <div class="flex flex-col py-2 mb-8">
            <button id="contact_info_block_btn" onclick="window.toggleBlockContact(window.activeChatUser.id, 'user'); window.updateContactInfoBlockBtn();"
                class="flex items-center px-4 py-4 gap-6 text-[#ea5656] hover:bg-[#202c33]/30 transition-colors w-full text-left focus:outline-none">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                    <path
                        d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z">
                    </path>
                </svg>
                <span class="text-[16px]"><span id="contact_info_block_text">Block</span> <span class="contact-name-placeholder">User</span></span>
            </button>
            <button onclick="window.reportContact()"
                class="flex items-center px-4 py-4 gap-6 text-[#ea5656] hover:bg-[#202c33]/30 transition-colors w-full text-left focus:outline-none">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                    <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"></path>
                </svg>
                <span class="text-[16px]">Report <span class="contact-name-placeholder">User</span></span>
            </button>
            <button onclick="if(window.openDeleteModal) { window.openDeleteModal('Delete this chat?', () => { window.deleteChatMessages(window.activeChatUser.id, 'user'); window.closeContactInfo(); }); } else { if(confirm('Delete this chat?')) { window.deleteChatMessages(window.activeChatUser.id, 'user'); window.closeContactInfo(); } }"
                class="flex items-center px-4 py-4 gap-6 text-[#ea5656] hover:bg-[#202c33]/30 transition-colors w-full text-left focus:outline-none">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path>
                </svg>
                <span class="text-[16px]">Delete chat</span>
            </button>
        </div>
    </div>
</div>

<script>
    window.openContactInfo = function () {
        const user = window.activeChatUser;
        if (!user) {
            alert('Please select a chat first');
            return;
        }

        // Close search sidebar if open
        const searchSidebar = document.getElementById('search_sidebar');
        if (searchSidebar) {
            searchSidebar.classList.add('hidden');
            searchSidebar.classList.remove('flex');
        }

        // Populate Panel with User Data
        document.getElementById('contact_info_name').textContent = user.name;
        document.getElementById('contact_info_phone').textContent = user.phone || 'No phone number';
        document.getElementById('contact_info_avatar').src = user.avatar;
        document.getElementById('contact_about_text').textContent = (user.about !== undefined && user.about !== null) ? user.about : 'Available';

        // Update placeholders in block/report buttons
        document.querySelectorAll('.contact-name-placeholder').forEach(el => el.textContent = user.name);
        
        if (window.updateContactInfoBlockBtn) window.updateContactInfoBlockBtn();
        if (window.updateContactInfoMediaSection) window.updateContactInfoMediaSection();

        const panel = document.getElementById('contact_info_panel');
        const mainChat = document.getElementById('main_chat_column');

        panel.classList.remove('translate-x-full');
        panel.classList.add('translate-x-0');

        // Adjust main chat width on desktop
        if (window.innerWidth >= 640) {
            mainChat.classList.add('sm:mr-[400px]');
        }
    };

    window.closeContactInfo = function () {
        const panel = document.getElementById('contact_info_panel');
        const mainChat = document.getElementById('main_chat_column');

        panel.classList.remove('translate-x-0');
        panel.classList.add('translate-x-full');

        // Remove width adjustment on desktop
        if (window.innerWidth >= 640) {
            mainChat.classList.remove('sm:mr-[400px]');
        }
    };

    window.openStarredMessages = function() {
        const panel = document.getElementById('starred_messages_panel');
        const list = document.getElementById('starred_messages_list');
        if (!panel || !list) return;

        list.innerHTML = '';
        const myId = window.myUserId;

         // Update starred count badge
        if (window.get && window.ref && window.db && window.myUserId) {
            window.get(window.ref(window.db, `starred_messages/${window.myUserId}`)).then(snap => {
                const badge = document.getElementById('starred_count_badge');
                if (badge) badge.textContent = snap.val() ? Object.keys(snap.val()).length : 0;
            });
        }

        window.get(window.ref(window.db, `starred_messages/${myId}`)).then(snapshot => {
            const data = snapshot.val();
            if (!data || Object.keys(data).length === 0) {
                list.innerHTML = `<div class="text-center text-[#8696a0] py-20">
                    <svg class="w-16 h-16 mx-auto mb-4 text-[#3b4a54]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    <p>No starred messages</p>
                </div>`;
            } else {
                const msgs = Object.entries(data).sort((a, b) => (b[1].time || 0) - (a[1].time || 0));
                msgs.forEach(([key, msg]) => {
                    const date = msg.time ? new Date(msg.time * 1000).toLocaleDateString([], { day:'2-digit', month:'2-digit', year:'numeric' }) : '';
                    const time = msg.time ? new Date(msg.time * 1000).toLocaleTimeString([], { hour:'2-digit', minute:'2-digit' }) : '';
                    const isMe = msg.sender_id == myId;

                    let content = msg.text || '';
                    if (msg.type === 'image') content = '📷 Photo';
                    else if (msg.type === 'video') content = '🎥 Video';
                    else if (msg.type === 'audio') content = '🎤 Voice message';
                    else if (msg.type === 'document') content = `📄 ${msg.file_name || 'Document'}`;

                    list.insertAdjacentHTML('beforeend', `
                        <div class="bg-[#202c33] rounded-xl p-3 cursor-pointer hover:bg-[#2a3942] transition-colors"
                            onclick="window.closeContactInfo(); setTimeout(() => window.scrollToMessage('${key}'), 400)">
                            <div class="flex items-center gap-2 mb-2">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="#00a884"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                <span class="text-[#00a884] text-xs font-semibold">${isMe ? 'You' : (window.activeChatUser?.name || 'Contact')}</span>
                                <span class="text-[#8696a0] text-xs ml-auto">${date} ${time}</span>
                            </div>
                            <p class="text-[#e9edef] text-sm leading-relaxed">${content}</p>
                        </div>`);
                });
            }
            // Update badge count
            const badge = document.getElementById('starred_count_badge');
            if (badge) badge.textContent = data ? Object.keys(data).length : 0;
            panel.classList.remove('hidden');
        });
    };

    window.updateContactInfoBlockBtn = function() {
        const user = window.activeChatUser;
        if (!user) return;
        const elementId = `user_sidebar_${user.id}`;
        const isBlocked = window.blockedUsers?.includes(elementId);
        const textSpan = document.getElementById('contact_info_block_text');
        if (textSpan) {
            textSpan.textContent = isBlocked ? 'Unblock' : 'Block';
        }
    };

    window.reportContact = function() {
        const user = window.activeChatUser;
        if (!user) return;
        
        if (confirm(`Report ${user.name} to WhatsApp? The last 5 messages from this contact will be forwarded. If you block this contact and delete the chat, messages will only be removed from this device and your devices on the newer versions of WhatsApp.`)) {
            // Mimic Report -> Block and Delete
            const elementId = `user_sidebar_${user.id}`;
            if (!window.blockedUsers?.includes(elementId)) {
                window.toggleBlockContact(user.id, 'user');
            }
            window.deleteChatMessages(user.id, 'user');
            window.closeContactInfo();
            window.showToast?.('Report sent', `Contact reported and blocked.`);
        }
    };

    window.updateContactInfoMediaSection = function() {
        if (!window.currentChatId) return;
        
        const activeUserId = window.activeChatUser ? window.activeChatUser.id : null;
        if (!activeUserId) return;

        // Filter global cache for the active chat
        const chatItems = (window.globalMediaCache || []).filter(m => m.chatId === window.currentChatId);

        // Sort descending by time
        chatItems.sort((a, b) => b.time - a.time);

        // Update count
        const countEl = document.getElementById('contact_media_count');
        if (countEl) {
            countEl.textContent = chatItems.length;
        }

        // Preview container
        const containerEl = document.getElementById('contact_media_preview_container');
        if (containerEl) {
            const previewItems = chatItems.slice(0, 4);
            if (previewItems.length === 0) {
                containerEl.innerHTML = `<div class="text-[#8696a0] text-sm py-2 col-span-full">No media, links or docs shared yet</div>`;
            } else {
                let html = '';
                previewItems.forEach(item => {
                    if (item.type === 'image') {
                        html += `
                            <div class="aspect-square rounded-lg bg-[#2a3942] overflow-hidden cursor-pointer relative group/item" onclick="event.stopPropagation(); window.openGmViewer('${item.url.replace(/'/g, "\\'")}', 'image', '${(item.fileName || '').replace(/'/g, "\\'")}', '${(item.senderName || '').replace(/'/g, "\\'")}')">
                                <img src="${item.url}" class="w-full h-full object-cover group-hover/item:scale-105 transition-transform duration-200 opacity-80 hover:opacity-100">
                            </div>`;
                    } else if (item.type === 'video') {
                        html += `
                            <div class="aspect-square rounded-lg bg-[#2a3942] overflow-hidden cursor-pointer relative group/item" onclick="event.stopPropagation(); window.openGmViewer('${item.url.replace(/'/g, "\\'")}', 'video', '${(item.fileName || '').replace(/'/g, "\\'")}', '${(item.senderName || '').replace(/'/g, "\\'")}')">
                                <video src="${item.url}" class="w-full h-full object-cover group-hover/item:scale-105 transition-transform duration-200 opacity-80"></video>
                                <div class="absolute inset-0 flex items-center justify-center bg-black/40 group-hover/item:bg-black/20 transition-colors">
                                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-white">
                                        <path d="M8 5v14l11-7z"></path>
                                    </svg>
                                </div>
                            </div>`;
                    } else if (item.type === 'audio') {
                        html += `
                            <div class="aspect-square bg-[#202c33] rounded-lg border border-[#313d45] overflow-hidden flex flex-col items-center justify-center cursor-pointer group/item hover:bg-[#2a3942] transition-colors relative" onclick="event.stopPropagation(); window.openGmViewer('${item.url.replace(/'/g, "\\'")}', 'audio', '${(item.fileName || '').replace(/'/g, "\\'")}', '${(item.senderName || '').replace(/'/g, "\\'")}')">
                                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="text-[#00a884]">
                                    <path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3zm5.3-3c0 3-2.54 5.1-5.3 5.1S6.7 14 6.7 11H5c0 3.41 2.72 6.23 6 6.72V21h2v-3.28c3.28-.48 6-3.3 6-6.72h-1.7z"></path>
                                </svg>
                                <span class="text-[9px] text-[#8696a0] truncate w-full text-center px-1 mt-1">Audio</span>
                            </div>`;
                    } else if (item.type === 'document') {
                        const ext = (item.fileName ? item.fileName.split('.').pop() : 'FILE').toUpperCase();
                        html += `
                            <div class="aspect-square bg-[#202c33] rounded-lg border border-[#313d45] overflow-hidden flex flex-col items-center justify-center cursor-pointer group/item hover:bg-[#2a3942] transition-colors relative" onclick="event.stopPropagation(); window.open(${item.url ? `'${item.url.replace(/'/g, "\\'")}'` : 'undefined'}, '_blank')">
                                <span class="text-[11px] font-bold text-white bg-[#00a884] px-1.5 py-0.5 rounded shadow-sm max-w-[70px] truncate uppercase">${ext}</span>
                                <span class="text-[9px] text-[#8696a0] truncate w-full text-center px-1 mt-1.5">${item.fileName || 'Document'}</span>
                            </div>`;
                    } else if (item.type === 'link') {
                        let displayDomain = 'Link';
                        try {
                            let parsed = new URL(item.url.startsWith('http') ? item.url : 'http://' + item.url);
                            displayDomain = parsed.hostname.replace('www.', '');
                        } catch (e) {}
                        html += `
                            <div class="aspect-square bg-[#202c33] rounded-lg border border-[#313d45] overflow-hidden flex flex-col items-center justify-center cursor-pointer group/item hover:bg-[#2a3942] transition-colors relative" onclick="event.stopPropagation(); window.open('${item.url.replace(/'/g, "\\'")}', '_blank')">
                                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="text-[#00a884]">
                                    <path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"></path>
                                </svg>
                                <span class="text-[9px] text-[#8696a0] truncate w-full text-center px-1 mt-1">${displayDomain}</span>
                            </div>`;
                    }
                });
                containerEl.innerHTML = html;
            }
        }
    };

    window.openContactMediaLibrary = function() {
        if (!window.currentChatId) return;
        const name = window.activeChatUser ? window.activeChatUser.name : 'Contact';
        if (window.openGlobalMediaModal) {
            window.openGlobalMediaModal(window.currentChatId, name);
        }
    };
</script>
