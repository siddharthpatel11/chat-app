<!-- Global Search Image Viewer (Lightbox) -->
<div id="gs_video_viewer" class="hidden fixed inset-0 z-[2000] bg-black flex flex-col transition-opacity duration-300 opacity-0 pointer-events-auto">
    <!-- Header -->
    <div class="flex items-center justify-between px-4 py-3 bg-gradient-to-b from-black/60 to-transparent absolute top-0 w-full z-[2100] pointer-events-none">
        <div class="flex items-center gap-4 pointer-events-auto">
            <!-- Back Button -->
            <button onclick="window.closeGlobalSearchVideoViewer()" class="text-white hover:text-[#d1d7db] transition-colors focus:outline-none p-1 rounded-full">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
            </button>
            
            <!-- Sender Info -->
            <div class="flex flex-col">
                <div id="gs_video_viewer_sender_name" class="text-white text-[16px] font-medium leading-tight"></div>
                <div id="gs_video_viewer_time" class="text-white/70 text-[13px] mt-0.5"></div>
            </div>
        </div>

        <!-- Action Icons -->
        <div class="flex items-center gap-5 text-white relative pointer-events-auto">
            <!-- Status Button -->
            <button id="gs_video_viewer_btn_status" class="hover:text-[#d1d7db] transition-colors focus:outline-none p-1 rounded-full" title="Set Status">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" stroke-dasharray="3 3"></circle>
                    <path d="M12 8v8m-4-4h8"></path>
                </svg>
            </button>
            
            <!-- Download Button -->
            <button id="gs_video_viewer_btn_download" class="hover:text-[#d1d7db] transition-colors focus:outline-none p-1 rounded-full" title="Download">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
            </button>

            <!-- Forward Button -->
            <button id="gs_video_viewer_btn_forward" class="hover:text-[#d1d7db] transition-colors focus:outline-none p-1 rounded-full" title="Forward">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </button>
            
            <!-- Share Button -->
            <button id="gs_video_viewer_btn_share" class="hover:text-[#d1d7db] transition-colors focus:outline-none p-1 rounded-full" title="Share">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                </svg>
            </button>

            <!-- 3 Dots Menu Button -->
            <button onclick="window.toggleGsVideoViewerMenu(event)" class="hover:text-[#d1d7db] transition-colors focus:outline-none p-1 rounded-full" title="Menu">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M12 7a2 2 0 10-.001-3.999A2 2 0 0012 7zm0 2a2 2 0 10-.001 3.999A2 2 0 0012 9zm0 6a2 2 0 10-.001 3.999A2 2 0 0012 15z"></path>
                </svg>
            </button>
            
            <!-- Context Menu Dropdown -->
            <div id="gs_video_viewer_dropdown_menu" class="hidden absolute top-12 right-0 bg-[#233138] border border-[#313d45] rounded-lg shadow-xl z-[2200] py-2 w-56 transition-opacity duration-150">
                <button id="gs_video_viewer_btn_show_chat" class="w-full text-left px-4 py-3 text-[#d1d7db] hover:bg-[#182229] hover:text-white transition-colors text-[14.5px] flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg> Show in chat
                </button>
                <button id="gs_video_viewer_btn_delete" class="w-full text-left px-4 py-3 text-[#f15c6d] hover:bg-[#182229] transition-colors text-[14.5px] flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Delete
                </button>
            </div>
        </div>
    </div>

    <!-- Main Image -->
    <div class="flex-1 flex items-center justify-center relative overflow-hidden pb-24 pt-16" id="gs_video_viewer_image_container">
        <video id="gs_video_viewer_video" src="" controls class="max-w-full max-h-full object-contain transition-transform duration-200"></video>
    </div>

    <!-- Footer -->
    <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-t from-black/80 to-transparent absolute bottom-0 w-full z-[2100] pointer-events-none">
        <!-- Reactions -->
        <div class="flex items-center gap-2 pointer-events-auto">
            <button id="gs_video_viewer_btn_react" class="text-white hover:text-[#d1d7db] transition-colors focus:outline-none p-2 rounded-full hover:bg-white/10" title="React">
                <svg viewBox="0 0 24 24" width="26" height="26" fill="currentColor">
                    <path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 100-16 8 8 0 000 16zm-3.5-9a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm7 0a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm-6.236 4.757C10.15 16.516 11.025 17 12 17s1.85-.484 2.736-1.243a1 1 0 111.306 1.52C14.885 18.257 13.565 19 12 19s-2.885-.743-4.042-1.723a1 1 0 011.306-1.52z"></path>
                </svg>
            </button>
            <div id="gs_video_viewer_reactions_container" class="flex gap-1"></div>
        </div>

        <!-- Reply Button -->
        <button id="gs_video_viewer_btn_reply" class="flex items-center gap-2 text-white hover:bg-white/10 transition-colors focus:outline-none px-4 py-2 rounded-full border border-white/20 bg-black/40 backdrop-blur-sm pointer-events-auto">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" style="transform: scaleX(-1);">
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z" style="display:none;"></path>
                <path d="M10 9V5l-7 7 7 7v-4.1c5 0 8.5 1.6 11 5.1-1-5-4-10-11-10z"></path>
            </svg>
            <span class="text-[15px] font-medium tracking-wide">Reply</span>
        </button>
    </div>
</div>

<style>
    #gs_video_viewer.show {
        display: flex !important;
        opacity: 1;
    }
</style>

<script>
    console.log('[DEBUG] video_viewer.blade.php script loaded');
    window.gsVideoViewerCurrentContext = null;

    window.openGlobalSearchVideoViewer = function(key, chatId, url, senderName, timestampStr, isGroup, text) {
        window.gsVideoViewerCurrentContext = { key, chatId, url, senderName, timestampStr, isGroup, text };
        
        document.getElementById('gs_video_viewer_video').src = url;
        document.getElementById('gs_video_viewer_sender_name').textContent = senderName;
        document.getElementById('gs_video_viewer_time').textContent = timestampStr;
        
        // Show existing reactions if available
        const reactionsContainer = document.getElementById('gs_video_viewer_reactions_container');
        reactionsContainer.innerHTML = '';
        
        let existingReactions = null;
        if (isGroup && window.groupMessagesCache && window.groupMessagesCache[chatId.replace('group_', '')]) {
            const msg = window.groupMessagesCache[chatId.replace('group_', '')].find(m => m.key === key);
            if (msg && msg.reactions) existingReactions = msg.reactions;
        } else if (!isGroup && window.messageCache && window.messageCache[chatId.replace('chat_', '')]) {
            const msg = window.messageCache[chatId.replace('chat_', '')].find(m => m.key === key);
            if (msg && msg.reactions) existingReactions = msg.reactions;
        } else if (window.globalMessages && window.globalMessages[key]) {
            existingReactions = window.globalMessages[key].reactions;
        }
        
        if (existingReactions) {
            const counts = {};
            Object.values(existingReactions).forEach(r => counts[r] = (counts[r] || 0) + 1);
            Object.entries(counts).forEach(([emoji, count]) => {
                reactionsContainer.innerHTML += `<div class="bg-black/50 border border-white/20 rounded-full px-2 py-0.5 text-white text-[13px] flex items-center gap-1"><span>${emoji}</span>${count > 1 ? `<span class="text-white/80">${count}</span>` : ''}</div>`;
            });
        }

        const viewer = document.getElementById('gs_video_viewer');
        viewer.classList.remove('hidden');
        // Force reflow
        void viewer.offsetWidth;
        viewer.classList.add('show');
        
        // Fetch latest reactions from Firebase just to be sure we're up to date
        if (window.refreshGsVideoViewerReactions) {
            window.refreshGsVideoViewerReactions();
        }
    };

    window.refreshGsVideoViewerReactions = async function() {
        if (!window.gsVideoViewerCurrentContext) return;
        const msgId = window.gsVideoViewerCurrentContext.key;
        const isGroup = window.gsVideoViewerCurrentContext.isGroup;
        let targetChatId = window.gsVideoViewerCurrentContext.chatId;
        let path = '';
        
        if (isGroup) {
            let gId = targetChatId;
            if (gId && gId.toString().startsWith('group_')) gId = gId.toString().replace('group_', '');
            path = `groups/${gId}/messages/${msgId}/reactions`;
        } else {
            let cId = targetChatId;
            if (cId && !cId.toString().startsWith('chat_')) {
                const id1 = parseInt(window.myUserId);
                const id2 = parseInt(cId);
                cId = `chat_${Math.min(id1, id2)}_${Math.max(id1, id2)}`;
            }
            path = `chats/${cId}/messages/${msgId}/reactions`;
        }

        try {
            const snap = await window.get(window.ref(window.db, path));
            const reactionsContainer = document.getElementById('gs_video_viewer_reactions_container');
            reactionsContainer.innerHTML = '';
            
            if (snap.exists()) {
                const existingReactions = snap.val();
                const counts = {};
                Object.values(existingReactions).forEach(r => counts[r] = (counts[r] || 0) + 1);
                Object.entries(counts).forEach(([emoji, count]) => {
                    reactionsContainer.innerHTML += `<div class="bg-black/50 border border-white/20 rounded-full px-2 py-0.5 text-white text-[13px] flex items-center gap-1"><span>${emoji}</span>${count > 1 ? `<span class="text-white/80">${count}</span>` : ''}</div>`;
                });
            }
        } catch (e) {
            console.error("Error fetching latest reactions for viewer", e);
        }
    };

    window.closeGlobalSearchVideoViewer = function() {
        const viewer = document.getElementById('gs_video_viewer');
        viewer.classList.remove('show');
        setTimeout(() => {
            viewer.classList.add('hidden');
            document.getElementById('gs_video_viewer_video').src = '';
            window.gsVideoViewerCurrentContext = null;
        }, 300);
        window.closeGsVideoViewerMenu();
    };

    // Close on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && document.getElementById('gs_video_viewer').classList.contains('show')) {
            window.closeGlobalSearchVideoViewer();
        }
    });

    window.toggleGsVideoViewerMenu = function(e) {
        if (e) e.stopPropagation();
        const menu = document.getElementById('gs_video_viewer_dropdown_menu');
        menu.classList.toggle('hidden');
    };

    window.closeGsVideoViewerMenu = function() {
        const menu = document.getElementById('gs_video_viewer_dropdown_menu');
        if (menu && !menu.classList.contains('hidden')) {
            menu.classList.add('hidden');
        }
    };

    // Close menu when clicking outside
    document.getElementById('gs_video_viewer').addEventListener('click', (e) => {
        if (!e.target.closest('#gs_video_viewer_dropdown_menu') && !e.target.closest('button[onclick="window.toggleGsVideoViewerMenu(event)"]')) {
            window.closeGsVideoViewerMenu();
        }
    });
    
    // Wire up actions
    document.getElementById('gs_video_viewer_btn_download').addEventListener('click', () => {
        if (!window.gsVideoViewerCurrentContext) return;
        const link = document.createElement('a');
        link.href = window.gsVideoViewerCurrentContext.url;
        link.download = `Photo_${window.gsVideoViewerCurrentContext.key}.jpg`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });

    const handleVideoForwardOrShare = () => {
        if (!window.gsVideoViewerCurrentContext) return;

        window.closeGlobalSearchVideoViewer();
        if (window.openForwardModal) {
            window.selectedMessages = new Set([window.gsVideoViewerCurrentContext.key]);
            
            if (!window.globalMessages) window.globalMessages = {};
            if (!window.globalMessages[window.gsVideoViewerCurrentContext.key]) {
                window.globalMessages[window.gsVideoViewerCurrentContext.key] = {
                    key: window.gsVideoViewerCurrentContext.key,
                    file_url: window.gsVideoViewerCurrentContext.url,
                    type: 'image',
                    text: window.gsVideoViewerCurrentContext.text || ''
                };
            }
            window.openForwardModal();
        }
    };
    
    document.getElementById('gs_video_viewer_btn_forward').addEventListener('click', handleVideoForwardOrShare);
    
    document.getElementById('gs_video_viewer_btn_share').addEventListener('click', async () => {
        if (!window.gsVideoViewerCurrentContext) return;
        const url = window.gsVideoViewerCurrentContext.url;
        const text = window.gsVideoViewerCurrentContext.text || '';
        
        if (!navigator.share) {
            if (window.showToast) window.showToast('Notice', 'System sharing is not supported on this device.');
            return;
        }
        
        try {
            const response = await fetch(url);
            const blob = await response.blob();
            const ext = url.split('.').pop().split('?')[0] || 'mp4';
            const file = new File([blob], `Shared_Media.${ext}`, { type: blob.type });
            
            if (navigator.canShare && navigator.canShare({ files: [file] })) {
                await navigator.share({
                    files: [file],
                    title: 'Shared Media',
                    text: text
                });
                return;
            }
        } catch (e) {
            console.log("Could not share as file, falling back to URL", e);
        }

        try {
            await navigator.share({
                title: 'Shared Media',
                text: text,
                url: url
            });
        } catch (e) {
            console.log("Share failed", e);
        }
    });
    
    document.getElementById('gs_video_viewer_btn_status').addEventListener('click', async () => {
        if (!window.gsVideoViewerCurrentContext) return;
        window.closeGlobalSearchVideoViewer();
        
        if (window.openMediaStatusWithFiles) {
            try {
                // Fetch the image and convert to File object
                const response = await fetch(window.gsVideoViewerCurrentContext.url);
                const blob = await response.blob();
                
                let filename = 'status_image.jpg';
                try {
                    const urlPath = new URL(gsVideoViewerCurrentContext.url).pathname;
                    const parts = urlPath.split('/');
                    const lastPart = parts[parts.length - 1];
                    if (lastPart) filename = decodeURIComponent(lastPart);
                } catch(e) {}
                
                const file = new File([blob], filename, { type: blob.type || 'image/jpeg' });
                window.openMediaStatusWithFiles([file]);
            } catch (e) {
                console.error("Failed to load image for status", e);
                if (window.showToast) window.showToast('Error', 'Failed to load image for status.');
            }
        }
    });

    document.getElementById('gs_video_viewer_btn_reply').addEventListener('click', () => {
        if (!gsVideoViewerCurrentContext) return;
        window.closeGlobalSearchVideoViewer();
        
        const chatId = gsVideoViewerCurrentContext.chatId;
        const key = gsVideoViewerCurrentContext.key;
        
        let cId = chatId;
        let isGroup = gsVideoViewerCurrentContext.isGroup;
        
        if (chatId.startsWith('group_')) {
            cId = chatId.replace('group_', '');
            let name = gsVideoViewerCurrentContext.senderName;
            let avatar = '';
            const groupEl = document.getElementById(`group_sidebar_${cId}`);
            if (groupEl) {
                name = groupEl.getAttribute('data-name') || name;
                avatar = groupEl.getAttribute('data-avatar') || '';
            }
            if (window.selectGroupChat) window.selectGroupChat(cId, name, avatar);
        } else {
            const ids = chatId.replace('chat_', '').split('_');
            cId = ids.find(id => id != window.myUserId) || window.myUserId;
            
            let name = gsVideoViewerCurrentContext.senderName;
            const sidebarEl = document.getElementById(`user_sidebar_${cId}`);
            if (sidebarEl) name = sidebarEl.getAttribute('data-name') || name;
            
            if (window.selectChat) window.selectChat(cId, name);
        }
        
        if (!window.globalMessages) window.globalMessages = {};
        if (!window.globalMessages[key]) {
            window.globalMessages[key] = {
                key: key,
                file_url: gsVideoViewerCurrentContext.url,
                type: 'image',
                text: gsVideoViewerCurrentContext.text || ''
            };
        }
        
        const senderName = gsVideoViewerCurrentContext.senderName;
        const text = gsVideoViewerCurrentContext.text || 'Photo';
        const url = gsVideoViewerCurrentContext.url;

        setTimeout(() => {
            if (window.replyToMsg) {
                // Pass groupName if it's a group, else null
                let groupName = null;
                if (isGroup) {
                    const groupEl = document.getElementById(`group_sidebar_${cId}`);
                    if (groupEl) groupName = groupEl.getAttribute('data-name');
                }
                window.replyToMsg(
                    key, 
                    senderName, 
                    text, 
                    groupName, 
                    url, 
                    'image'
                );
            }
        }, 800);
    });

    document.getElementById('gs_video_viewer_btn_react').addEventListener('click', (e) => {
        if (!window.gsVideoViewerCurrentContext) return;
        if (window.showReactionPopup) {
            window.showReactionPopup(e, window.gsVideoViewerCurrentContext.key, window.gsVideoViewerCurrentContext.isGroup);
        }
    });

    document.getElementById('gs_video_viewer_btn_show_chat').addEventListener('click', () => {
        if (!window.gsVideoViewerCurrentContext) return;
        window.closeGlobalSearchVideoViewer();
        
        const chatId = window.gsVideoViewerCurrentContext.chatId;
        let cId = chatId;
        let isGroup = window.gsVideoViewerCurrentContext.isGroup;
        if (chatId.startsWith('group_')) {
            cId = chatId.replace('group_', '');
        } else {
            const ids = chatId.replace('chat_', '').split('_');
            cId = ids.find(id => id != window.myUserId) || window.myUserId;
        }
        
        let name = window.gsVideoViewerCurrentContext.senderName;
        let avatar = '';
        let status = 'online';
        const elementId = isGroup ? `group_sidebar_${cId}` : `user_sidebar_${cId}`;
        const sidebarEl = document.getElementById(elementId);
        if (sidebarEl) {
            name = sidebarEl.getAttribute('data-name') || name;
            avatar = sidebarEl.getAttribute('data-avatar') || avatar;
            status = sidebarEl.getAttribute('data-status') || status;
        }
        
        if (isGroup) {
            if (window.selectGroupChat) {
                window.selectGroupChat(cId, name, avatar);
            }
        } else {
            if (window.selectChat) {
                window.selectChat(cId, name, '', avatar, status);
            }
        }
        
        // Close global search panel so the chat is visible
        if (window.closeGlobalSearch) {
            window.closeGlobalSearch();
        }
        
        // Optionally, scroll to message if jumpToMessage exists
        if (window.jumpToMessage) {
            setTimeout(() => window.jumpToMessage(chatId, window.gsVideoViewerCurrentContext.key), 500);
        }
    });

    document.getElementById('gs_video_viewer_btn_delete').addEventListener('click', () => {
        if (!gsVideoViewerCurrentContext) return;
        window.closeGlobalSearchVideoViewer();
        if (window.deleteMsg) {
            // Need globalMessages context
            if (!window.globalMessages) window.globalMessages = {};
            if (!window.globalMessages[gsVideoViewerCurrentContext.key]) {
                window.globalMessages[gsVideoViewerCurrentContext.key] = {
                    key: gsVideoViewerCurrentContext.key,
                    file_url: gsVideoViewerCurrentContext.url,
                    type: 'image',
                    sender_id: gsVideoViewerCurrentContext.isGroup ? null : (gsVideoViewerCurrentContext.senderName === 'You' ? window.myUserId : 'other')
                };
            }
            window.deleteMsg(gsVideoViewerCurrentContext.key);
        }
    });

    // Handle double click to zoom
    document.getElementById('gs_video_viewer_image_container').addEventListener('dblclick', (e) => {
        if (e.target.tagName !== 'VIDEO') return;
        const video = e.target;
        const isZoomed = video.style.transform === 'scale(2)';
        
        if (isZoomed) {
            video.style.transform = 'scale(1)';
            video.style.cursor = 'zoom-in';
        } else {
            // Zoom at click position
            const rect = video.getBoundingClientRect();
            const x = ((e.clientX - rect.left) / rect.width) * 100;
            const y = ((e.clientY - rect.top) / rect.height) * 100;
            
            video.style.transformOrigin = `${x}% ${y}%`;
            video.style.transform = 'scale(2)';
            video.style.cursor = 'zoom-out';
        }
    });
</script>







