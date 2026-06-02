<!-- Global Media Modal -->
<div id="global_media_modal"
    class="hidden fixed inset-0 z-[1000] flex items-center justify-center bg-black/60 backdrop-blur-sm transition-all duration-300">
    <div class="bg-[#111b21] w-[95%] max-w-[900px] h-[85vh] rounded-2xl flex flex-col overflow-hidden shadow-2xl transform scale-95 transition-all duration-300 opacity-0"
        id="global_media_modal_content">
        
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 bg-[#202c33] shrink-0 border-b border-[#313d45]">
            <div class="flex items-center gap-4 w-1/3">
                <div class="flex flex-col">
                    <h3 class="text-[#e9edef] text-[16px] font-medium leading-tight">Media</h3>
                    <span class="text-[#8696a0] text-[13px]">Media from all chats</span>
                </div>
            </div>

            <!-- Tabs -->
            <div class="flex items-center justify-center gap-8 w-1/3 text-[14.5px] font-medium">
                <button onclick="switchGlobalMediaTab('media')" id="gm_tab_media" class="text-[#00a884] border-b-2 border-[#00a884] pb-1 transition-colors px-1">Media</button>
                <button onclick="switchGlobalMediaTab('docs')" id="gm_tab_docs" class="text-[#8696a0] hover:text-[#e9edef] pb-1 transition-colors px-1 border-b-2 border-transparent">Docs</button>
                <button onclick="switchGlobalMediaTab('links')" id="gm_tab_links" class="text-[#8696a0] hover:text-[#e9edef] pb-1 transition-colors px-1 border-b-2 border-transparent">Links</button>
            </div>

            <!-- Actions -->
            <div id="gm_normal_actions" class="flex items-center justify-end gap-5 w-1/3 relative">
                <input type="text" id="gm_search_input" onkeyup="renderGlobalMedia()" placeholder="Search..." class="hidden absolute right-[150px] bg-[#202c33] text-[#e9edef] text-[14px] px-3 py-1.5 rounded-lg outline-none border border-[#313d45] focus:border-[#00a884] transition-all w-[200px]">
                
                <button onclick="toggleGmSearch()" title="Search" class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                        <path d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 001.256-3.386 5.207 5.207 0 10-5.207 5.208 5.183 5.183 0 003.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-4.8 0a3.605 3.605 0 110-7.21 3.605 3.605 0 010 7.21z"></path>
                    </svg>
                </button>
                <button onclick="toggleGmSort()" title="Reverse Sort Order" class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none" id="gm_sort_btn">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 6h16M7 12h10M10 18h4" stroke-linecap="round"/>
                    </svg>
                </button>
                <button onclick="toggleGmSelectMode()" title="Select Items" class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none" id="gm_select_btn">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" stroke-linecap="round"/>
                        <path d="M9 12l2 2 4-4" stroke-linecap="round"/>
                    </svg>
                </button>
                <button onclick="closeGlobalMediaModal()"
                    class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none ml-2">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path>
                    </svg>
                </button>
            </div>
            
            <div id="gm_select_actions" class="hidden items-center justify-end w-1/3 pr-2">
                <button onclick="toggleGmSelectMode()" class="text-[#e9edef] text-[15px] font-medium hover:text-[#00a884] transition-colors">Cancel</button>
            </div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto custom-scrollbar p-6 bg-[#111b21]" id="global_media_container">
            <!-- Dynamically populated by JS -->
            <div class="text-center text-[#8696a0] mt-10">Loading media...</div>
        </div>

        <!-- Bulk Action Bar -->
        <div id="gm_bulk_action_bar" class="hidden flex items-center justify-between px-6 py-4 bg-[#202c33] shrink-0 border-t border-[#313d45] translate-y-full transition-transform duration-300">
            <div class="flex items-center gap-4">
                <button onclick="gmBulkDelete()" class="text-[#8696a0] hover:text-[#f15c6d] transition-colors focus:outline-none flex items-center gap-2" title="Delete">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>
            
            <div class="text-[#8696a0] text-[15px] font-medium"><span id="gm_selected_count">0</span> selected</div>

            <div class="flex items-center gap-6">
                <button onclick="gmBulkStar()" class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none" title="Star">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                </button>
                <button onclick="gmBulkDownload()" class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none" title="Download">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                </button>
                <button onclick="gmBulkForward()" class="bg-[#00a884] hover:bg-[#00bfa5] text-white rounded-full p-3 transition-colors shadow-lg focus:outline-none flex items-center justify-center" title="Forward">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Context Menu Dropdown -->
    <div id="gm_dropdown_menu" class="hidden absolute bg-[#233138] border border-[#313d45] rounded-lg shadow-xl z-[1100] py-2 w-56 transition-opacity duration-150 opacity-0 pointer-events-none">
        <button onclick="gmOptionSelect()" class="w-full text-left px-4 py-3 text-[#d1d7db] hover:bg-[#182229] hover:text-white transition-colors text-[14.5px] flex items-center gap-3"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Select</button>
        <button onclick="gmOptionGoToMessage()" class="w-full text-left px-4 py-3 text-[#d1d7db] hover:bg-[#182229] hover:text-white transition-colors text-[14.5px] flex items-center gap-3"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>Go to message</button>
        <button onclick="gmOptionReplyPrivately()" class="w-full text-left px-4 py-3 text-[#d1d7db] hover:bg-[#182229] hover:text-white transition-colors text-[14.5px] flex items-center gap-3"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>Reply privately</button>
        <button onclick="gmOptionCopy()" class="w-full text-left px-4 py-3 text-[#d1d7db] hover:bg-[#182229] hover:text-white transition-colors text-[14.5px] flex items-center gap-3"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>Copy</button>
        <button onclick="gmOptionForward()" class="w-full text-left px-4 py-3 text-[#d1d7db] hover:bg-[#182229] hover:text-white transition-colors text-[14.5px] flex items-center gap-3"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>Forward</button>
        <button onclick="gmOptionStar()" class="w-full text-left px-4 py-3 text-[#d1d7db] hover:bg-[#182229] hover:text-white transition-colors text-[14.5px] flex items-center gap-3"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>Star</button>
        <button onclick="gmOptionDelete()" class="w-full text-left px-4 py-3 text-[#f15c6d] hover:bg-[#182229] transition-colors text-[14.5px] flex items-center gap-3"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>Delete</button>
    </div>

    <!-- Fullscreen Viewer Modal -->
    <div id="gm_viewer_modal" class="hidden fixed inset-0 z-[2000] bg-black/95 flex flex-col items-center justify-center transition-opacity duration-300 opacity-0 pointer-events-auto">
        <button onclick="closeGmViewer()" class="absolute top-4 right-4 text-[#8696a0] hover:text-[#e9edef] transition-colors z-[2100] p-2">
            <svg viewBox="0 0 24 24" width="30" height="30" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/></svg>
        </button>
        <div class="absolute top-4 left-6 z-[2100]">
            <div class="text-white text-lg font-medium" id="gm_viewer_title"></div>
            <div class="text-[#8696a0] text-sm" id="gm_viewer_sender"></div>
        </div>
        <img id="gm_viewer_img" class="max-w-full max-h-[85vh] object-contain hidden z-[2050]">
        <video id="gm_viewer_video" class="max-w-full max-h-[85vh] hidden z-[2050]" controls></video>
    </div>
</div>

<style>
    #global_media_modal.show {
        display: flex !important;
    }

    #global_media_modal.show #global_media_modal_content {
        transform: scale(1);
        opacity: 1;
    }
    
    .gm-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 12px;
    }
</style>

<script>
    window.globalMediaCache = window.globalMediaCache || [];
    let currentGlobalMediaTab = 'media';
    let gmSortOrder = 'desc';
    let gmSelectMode = false;
    let gmSelectedItems = [];
    
    let activeGmDropdownKey = null;
    let activeGmDropdownChatId = null;


    window.openGlobalMediaModal = function() {
        const modal = document.getElementById('global_media_modal');
        const content = document.getElementById('global_media_modal_content');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('show');
        }, 10);
        renderGlobalMedia();
    };

    window.closeGlobalMediaModal = function() {
        const modal = document.getElementById('global_media_modal');
        modal.classList.remove('show');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    };

    window.switchGlobalMediaTab = function(tab) {
        currentGlobalMediaTab = tab;
        ['media', 'docs', 'links'].forEach(t => {
            const btn = document.getElementById('gm_tab_' + t);
            if (t === tab) {
                btn.classList.add('text-[#00a884]', 'border-[#00a884]');
                btn.classList.remove('text-[#8696a0]', 'border-transparent');
            } else {
                btn.classList.remove('text-[#00a884]', 'border-[#00a884]');
                btn.classList.add('text-[#8696a0]', 'border-transparent');
            }
        });
        gmSelectMode = false;
        gmSelectedItems = [];
        const selBtn = document.getElementById('gm_select_btn');
        selBtn.classList.remove('text-[#00a884]');
        selBtn.classList.add('text-[#8696a0]');
        renderGlobalMedia();
    };


    window.handleGmItemClick = function(key, type, url, fileName, chatId, senderName) {
        if (gmSelectMode) {
            toggleGmSelection(key);
            return;
        }
        
        if (type === 'image' || type === 'video') {
            const viewer = document.getElementById('gm_viewer_modal');
            const img = document.getElementById('gm_viewer_img');
            const vid = document.getElementById('gm_viewer_video');
            
            document.getElementById('gm_viewer_title').textContent = fileName || 'Media';
            document.getElementById('gm_viewer_sender').textContent = senderName || 'Me';
            
            viewer.classList.remove('hidden');
            setTimeout(() => viewer.classList.remove('opacity-0'), 10);
            
            if (type === 'image') {
                img.src = url;
                img.classList.remove('hidden');
                vid.classList.add('hidden');
                vid.pause();
            } else {
                vid.src = url;
                vid.classList.remove('hidden');
                img.classList.add('hidden');
                vid.play();
            }
        } else if (type === 'document' || type === 'link') {
            window.open(url, '_blank');
        }
    };

    window.closeGmViewer = function() {
        const viewer = document.getElementById('gm_viewer_modal');
        const vid = document.getElementById('gm_viewer_video');
        vid.pause();
        viewer.classList.add('opacity-0');
        setTimeout(() => viewer.classList.add('hidden'), 300);
    };

    window.openGmDropdown = function(event, key, chatId) {
        event.stopPropagation();
        activeGmDropdownKey = key;
        activeGmDropdownChatId = chatId;
        
        const menu = document.getElementById('gm_dropdown_menu');
        menu.classList.remove('hidden');
        
        const x = event.clientX;
        const y = event.clientY;
        const windowWidth = window.innerWidth;
        const windowHeight = window.innerHeight;
        
        let top = y;
        let left = x - 190; // open to the left of the chevron
        
        const menuHeight = menu.offsetHeight || 340;
        
        if (left < 10) left = 10;
        if (top + menuHeight > windowHeight) top = windowHeight - menuHeight - 10;
        
        menu.style.top = top + 'px';
        menu.style.left = left + 'px';
        
        setTimeout(() => {
            menu.classList.remove('opacity-0', 'pointer-events-none');
        }, 10);
    };

    window.closeGmDropdown = function() {
        const menu = document.getElementById('gm_dropdown_menu');
        if (menu) {
            menu.classList.add('opacity-0', 'pointer-events-none');
            setTimeout(() => {
                menu.classList.add('hidden');
            }, 150);
        }
    };

    document.addEventListener('click', function(e) {
        if (!e.target.closest('#gm_dropdown_menu') && !e.target.closest('.gm-chevron')) {
            window.closeGmDropdown();
        }
    });

    window.gmOptionSelect = function() {
        closeGmDropdown();
        if (!gmSelectMode) {
            toggleGmSelectMode();
        }
        if (!gmSelectedItems.includes(activeGmDropdownKey)) {
            toggleGmSelection(activeGmDropdownKey);
        }
    };

    window.gmOptionCopy = function() {
        closeGmDropdown();
        const item = window.globalMediaCache.find(m => m.key === activeGmDropdownKey);
        if (item && item.url) {
            navigator.clipboard.writeText(item.url).then(() => {
                if (window.showToast) window.showToast('Copied', 'Media URL copied to clipboard.');
            });
        }
    };

    window.gmOptionStar = function() {
        closeGmDropdown();
        const item = window.globalMediaCache.find(m => m.key === activeGmDropdownKey);
        if (!item) return;

        if (window.starredMsgKeys && window.starredMsgKeys.has(activeGmDropdownKey)) {
            // Unstar
            if (window.remove && window.ref && window.db) {
                window.remove(window.ref(window.db, `starred_messages/${window.myUserId}/${activeGmDropdownKey}`)).then(() => {
                    window.starredMsgKeys.delete(activeGmDropdownKey);
                    if (window.showToast) window.showToast('Message Unstarred', 'Message removed from starred.');
                });
            }
        } else {
            // Star
            if (window.set && window.ref && window.db) {
                window.set(window.ref(window.db, `starred_messages/${window.myUserId}/${activeGmDropdownKey}`), {
                    text: '',
                    type: item.type,
                    file_url: item.url,
                    file_name: item.fileName || null,
                    time: item.time,
                    sender_id: item.senderId,
                    chat_id: item.chatId
                }).then(() => {
                    if (window.starredMsgKeys) window.starredMsgKeys.add(activeGmDropdownKey);
                    if (window.showToast) window.showToast('Message Starred', 'Message added to starred.');
                });
            }
        }
    };

    window.gmOptionReplyPrivately = function() {
        closeGmDropdown();
        const item = window.globalMediaCache.find(m => m.key === activeGmDropdownKey);
        if (item) {
            closeGlobalMediaModal();
            if (window.selectChat) window.selectChat(item.senderId, item.senderName);
        }
    };

    window.gmOptionGoToMessage = function() {
        closeGmDropdown();
        closeGlobalMediaModal();
        
        const chatId = activeGmDropdownChatId;
        const msgKey = activeGmDropdownKey;
        
        if (chatId.startsWith('group_')) {
            const groupId = chatId;
            if (window.selectGroupChat) window.selectGroupChat(groupId);
        } else if (chatId.startsWith('chat_')) {
            const parts = chatId.split('_');
            let otherId = parts[1];
            if (otherId == window.myUserId) otherId = parts[2];
            
            // Try to find the item to get the name
            const item = window.globalMediaCache.find(m => m.key === activeGmDropdownKey);
            const fallbackName = item ? item.senderName : undefined;
            if (window.selectChat) window.selectChat(otherId, fallbackName);
        }
        
        // Try to scroll to message after a short delay
        setTimeout(() => {
            const msgEl = document.getElementById('message_' + msgKey);
            if (msgEl) {
                msgEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                msgEl.classList.add('bg-[#2c3943]'); // highlight
                setTimeout(() => msgEl.classList.remove('bg-[#2c3943]'), 2000);
            }
        }, 500);
    };

    window.gmOptionForward = function() {
        closeGmDropdown();
        window.selectedMessages = new Set([activeGmDropdownKey]);
        if (window.openForwardModal) window.openForwardModal();
    };

    window.gmOptionDelete = function() {
        closeGmDropdown();
        if (confirm('Are you sure you want to delete this message?')) {
            const chatId = activeGmDropdownChatId;
            const refPath = chatId.startsWith('group_') ? 
                `groups/${chatId}/messages/${activeGmDropdownKey}` :
                `chats/${chatId}/messages/${activeGmDropdownKey}`;
            
            if (window.remove && window.ref && window.db) {
                window.remove(window.ref(window.db, refPath))
                    .then(() => {
                        // remove from cache
                        window.globalMediaCache = window.globalMediaCache.filter(m => m.key !== activeGmDropdownKey);
                        renderGlobalMedia();
                    })
                    .catch(err => alert('Failed to delete message: ' + err));
            }
        }
    };


    window.openGmViewer = function(url, type, fileName, senderName) {
        const viewer = document.getElementById('gm_viewer_modal');
        const img = document.getElementById('gm_viewer_img');
        const vid = document.getElementById('gm_viewer_video');
        const title = document.getElementById('gm_viewer_title');
        const sender = document.getElementById('gm_viewer_sender');
        
        viewer.classList.remove('hidden');
        setTimeout(() => viewer.classList.remove('opacity-0'), 10);
        
        title.textContent = fileName || 'Media';
        sender.textContent = senderName || 'Unknown';
        
        if (type === 'image') {
            img.src = url;
            img.classList.remove('hidden');
            vid.classList.add('hidden');
            vid.src = '';
        } else if (type === 'video') {
            vid.src = url;
            vid.classList.remove('hidden');
            img.classList.add('hidden');
            img.src = '';
            vid.play().catch(e => console.log(e));
        }
    };

    window.closeGmViewer = function() {
        const viewer = document.getElementById('gm_viewer_modal');
        const vid = document.getElementById('gm_viewer_video');
        viewer.classList.add('opacity-0');
        setTimeout(() => {
            viewer.classList.add('hidden');
            vid.pause();
            vid.src = '';
            document.getElementById('gm_viewer_img').src = '';
        }, 300);
    };

    window.handleGmItemClick = function(key, type, url, fileName, chatId, senderName) {
        if (gmSelectMode) {
            toggleGmSelection(key);
        } else {
            if (type === 'image' || type === 'video') {
                openGmViewer(url, type, fileName, senderName);
            } else {
                window.open(url, '_blank');
            }
        }
    };

    window.gmBulkForward = function() {
        if (gmSelectedItems.length === 0) return;
        closeGlobalMediaModal();
        window.selectedMessages = new Set(gmSelectedItems);
        if (window.openForwardModal) window.openForwardModal();
    };

    window.gmBulkDelete = function() {
        if (gmSelectedItems.length === 0) return;
        if (confirm(`Are you sure you want to delete ${gmSelectedItems.length} selected message(s)?`)) {
            let promises = [];
            gmSelectedItems.forEach(key => {
                const item = window.globalMediaCache.find(m => m.key === key);
                if (item) {
                    const chatId = item.chatId;
                    const refPath = chatId.startsWith('group_') ? 
                        `groups/${chatId}/messages/${key}` :
                        `chats/${chatId}/messages/${key}`;
                    promises.push(window.remove(window.ref(window.db, refPath)));
                }
            });
            
            Promise.all(promises).then(() => {
                window.globalMediaCache = window.globalMediaCache.filter(m => !gmSelectedItems.includes(m.key));
                toggleGmSelectMode(); // turn off select mode
            }).catch(err => alert('Failed to delete messages: ' + err));
        }
    };

    window.gmBulkStar = function() {
        if (gmSelectedItems.length === 0) return;
        let promises = [];
        gmSelectedItems.forEach(key => {
            const item = window.globalMediaCache.find(m => m.key === key);
            if (item) {
                const chatId = item.chatId;
                promises.push(window.set(window.ref(window.db, `starred_messages/${window.myUserId}/${key}`), {
                    text: '',
                    type: item.type,
                    file_url: item.url,
                    file_name: item.fileName || null,
                    time: item.time,
                    sender_id: item.senderId,
                    chat_id: item.chatId
                }));
                if (window.starredMsgKeys) window.starredMsgKeys.add(key);
            }
        });
        
        Promise.all(promises).then(() => {
            if(window.showToast) window.showToast('Starred', `${gmSelectedItems.length} message(s) starred.`);
            toggleGmSelectMode(); // Close select mode
        }).catch(err => alert('Failed to star messages: ' + err));
    };

    window.gmBulkDownload = function() {
        if (gmSelectedItems.length === 0) return;
        gmSelectedItems.forEach(key => {
            const item = window.globalMediaCache.find(m => m.key === key);
            if (item && item.url) {
                const a = document.createElement('a');
                a.href = item.url;
                a.download = item.fileName || 'download';
                a.target = '_blank';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            }
        });
        toggleGmSelectMode();
    };

    window.toggleGmSearch = function() {
        const input = document.getElementById('gm_search_input');
        if (input.classList.contains('hidden')) {
            input.classList.remove('hidden');
            input.focus();
        } else {
            input.classList.add('hidden');
            input.value = '';
            renderGlobalMedia();
        }
    };

    window.toggleGmSort = function() {
        gmSortOrder = gmSortOrder === 'desc' ? 'asc' : 'desc';
        const btn = document.getElementById('gm_sort_btn');
        if (gmSortOrder === 'asc') {
            btn.classList.add('text-[#00a884]');
            btn.classList.remove('text-[#8696a0]');
        } else {
            btn.classList.remove('text-[#00a884]');
            btn.classList.add('text-[#8696a0]');
        }
        renderGlobalMedia();
    };

    window.toggleGmSelectMode = function() {
        gmSelectMode = !gmSelectMode;
        gmSelectedItems = [];
        
        const normalActions = document.getElementById('gm_normal_actions');
        const selectActions = document.getElementById('gm_select_actions');
        const bulkBar = document.getElementById('gm_bulk_action_bar');
        
        if (gmSelectMode) {
            if(normalActions) {
                normalActions.classList.add('hidden');
                normalActions.classList.remove('flex');
            }
            if(selectActions) {
                selectActions.classList.remove('hidden');
                selectActions.classList.add('flex');
            }
            if(bulkBar) {
                bulkBar.classList.remove('hidden');
                setTimeout(() => bulkBar.classList.remove('translate-y-full'), 10);
            }
            const countEl = document.getElementById('gm_selected_count');
            if(countEl) countEl.textContent = '0';
        } else {
            if(normalActions) {
                normalActions.classList.remove('hidden');
                normalActions.classList.add('flex');
            }
            if(selectActions) {
                selectActions.classList.add('hidden');
                selectActions.classList.remove('flex');
            }
            if(bulkBar) {
                bulkBar.classList.add('translate-y-full');
                setTimeout(() => bulkBar.classList.add('hidden'), 300);
            }
        }
        renderGlobalMedia();
    };

    window.toggleGmSelection = function(key) {
        if (!gmSelectMode) return;
        const idx = gmSelectedItems.indexOf(key);
        if (idx > -1) {
            gmSelectedItems.splice(idx, 1);
        } else {
            gmSelectedItems.push(key);
        }
        const countEl = document.getElementById('gm_selected_count');
        if(countEl) countEl.textContent = gmSelectedItems.length;
        renderGlobalMedia();
    };

    function formatTimeLabel(timestamp) {
        const date = new Date(timestamp * 1000);
        const today = new Date();
        const yesterday = new Date(today);
        yesterday.setDate(yesterday.getDate() - 1);
        
        if (date.toDateString() === today.toDateString()) return 'Today';
        if (date.toDateString() === yesterday.toDateString()) return 'Yesterday';
        
        const oneWeekAgo = new Date(today);
        oneWeekAgo.setDate(oneWeekAgo.getDate() - 7);
        if (date > oneWeekAgo) return 'Last week';
        
        const oneMonthAgo = new Date(today);
        oneMonthAgo.setMonth(oneMonthAgo.getMonth() - 1);
        if (date > oneMonthAgo) return 'Last month';
        
        return date.toLocaleDateString('en-GB', { month: 'long', year: 'numeric' });
    }

    function renderGlobalMedia() {
        const container = document.getElementById('global_media_container');
        if (!container) return;
        
        let items = [];
        const searchVal = document.getElementById('gm_search_input')?.value.toLowerCase() || '';
        
        if (currentGlobalMediaTab === 'media') {
            items = window.globalMediaCache.filter(m => m.type === 'image' || m.type === 'video');
        } else if (currentGlobalMediaTab === 'docs') {
            items = window.globalMediaCache.filter(m => m.type === 'document');
        } else if (currentGlobalMediaTab === 'links') {
            items = window.globalMediaCache.filter(m => m.type === 'link');
        }

        // Apply search filter
        if (searchVal) {
            items = items.filter(m => {
                const sName = (m.senderName || '').toLowerCase();
                const fName = (m.fileName || '').toLowerCase();
                const uName = (m.url || '').toLowerCase();
                return sName.includes(searchVal) || fName.includes(searchVal) || uName.includes(searchVal);
            });
        }

        if (items.length === 0) {
            container.innerHTML = `<div class="text-center text-[#8696a0] mt-10">No ${currentGlobalMediaTab} found.</div>`;
            return;
        }

        // Apply sorting
        if (gmSortOrder === 'desc') {
            items.sort((a, b) => b.time - a.time);
        } else {
            items.sort((a, b) => a.time - b.time);
        }

        // Group by time
        const groups = {};
        items.forEach(item => {
            const label = formatTimeLabel(item.time);
            if (!groups[label]) groups[label] = [];
            groups[label].push(item);
        });

        let html = '';
        for (const label in groups) {
            html += `<div class="mb-8">
                <h4 class="text-[#e9edef] text-[15px] font-medium mb-4 pl-1">${label}</h4>`;
                
            if (currentGlobalMediaTab === 'media') {
                html += `<div class="gm-grid">`;
                groups[label].forEach(item => {
                    const isSelected = gmSelectedItems.includes(item.key);
                    const selClass = isSelected ? 'border-2 border-[#00a884] opacity-80 scale-95' : 'border border-[#313d45]';
                    const checkHtml = gmSelectMode ? `
                        <div class="absolute top-2 right-2 w-[22px] h-[22px] rounded-full border-2 ${isSelected ? 'border-[#00a884] bg-[#00a884]' : 'border-white/70 bg-black/20'} flex items-center justify-center z-10 shadow-sm transition-all duration-200 hover:border-white hover:bg-black/40">
                            ${isSelected ? '<svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>' : ''}
                        </div>
                    ` : '';

                    html += `
                        <div onclick="handleGmItemClick('${item.key}', '${item.type}', '${item.url.replace(/'/g, "\\'")}', '${(item.fileName || '').replace(/'/g, "\\'")}', '${item.chatId}', '${(item.senderName || '').replace(/'/g, "\\'")}')" class="relative w-full aspect-square bg-[#202c33] rounded-lg overflow-hidden group cursor-pointer ${selClass} transition-all">
                            ${checkHtml}
                            ${gmSelectMode ? '' : `<button onclick="openGmDropdown(event, '${item.key}', '${item.chatId}')" class="gm-chevron absolute top-2 right-2 w-7 h-7 rounded-full bg-black/50 hover:bg-black/70 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-20"><svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>`}
                            ${item.type === 'image' ? 
                                `<img src="${item.url}" class="w-full h-full object-cover">` : 
                                `<video src="${item.url}" class="w-full h-full object-cover"></video>
                                 <div class="absolute inset-0 flex items-center justify-center bg-black/30">
                                     <svg class="w-8 h-8 text-white opacity-80" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                 </div>`
                            }
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-100 pointer-events-none">
                                <span class="absolute bottom-2 left-2 text-white text-[12px] font-medium drop-shadow-md truncate w-[90%]">
                                    ${item.senderName || 'Me'}
                                </span>
                            </div>
                        </div>
                    `;
                });
                html += `</div>`;
            } else if (currentGlobalMediaTab === 'docs') {
                html += `<div class="flex flex-col gap-3">`;
                groups[label].forEach(item => {
                    const isSelected = gmSelectedItems.includes(item.key);
                    const selBg = isSelected ? 'bg-[#2a3942] border-[#00a884]' : 'bg-[#202c33] border-[#313d45] hover:bg-[#2a3942]';
                    const checkHtml = gmSelectMode ? `
                        <div class="mr-3 w-[22px] h-[22px] rounded-full border-2 ${isSelected ? 'border-[#00a884] bg-[#00a884]' : 'border-[#8696a0]'} flex items-center justify-center shrink-0 transition-colors">
                            ${isSelected ? '<svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>' : ''}
                        </div>
                    ` : '';

                    html += `
                        <div onclick="handleGmItemClick('${item.key}', 'document', '${(item.url || '').replace(/'/g, "\\'")}', '${(item.fileName || '').replace(/'/g, "\\'")}', '${item.chatId}', '${(item.senderName || '').replace(/'/g, "\\'")}')" class="flex items-center p-4 rounded-xl cursor-pointer transition-colors border ${selBg} group relative overflow-hidden">
                            ${checkHtml}
                            ${gmSelectMode ? '' : `<button onclick="openGmDropdown(event, '${item.key}', '${item.chatId}')" class="gm-chevron absolute top-4 right-4 w-7 h-7 rounded-full bg-transparent hover:bg-white/10 text-[#8696a0] hover:text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-20"><svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>`}
                            <div class="w-12 h-12 rounded-lg bg-[#5f66cd]/20 flex items-center justify-center text-[#5f66cd] shrink-0 mr-4">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h5 class="text-[#e9edef] text-[15px] font-medium truncate mb-1">${item.fileName || 'Document'}</h5>
                                <p class="text-[#8696a0] text-[13px]">${item.senderName || 'Me'}</p>
                            </div>
                        </div>
                    `;
                });
                html += `</div>`;
            } else if (currentGlobalMediaTab === 'links') {
                html += `<div class="flex flex-col gap-3">`;
                groups[label].forEach(item => {
                    const isSelected = gmSelectedItems.includes(item.key);
                    const selBg = isSelected ? 'bg-[#2a3942] border-[#00a884]' : 'bg-[#202c33] border-[#313d45] hover:bg-[#2a3942]';
                    const checkHtml = gmSelectMode ? `
                        <div class="mr-3 w-[22px] h-[22px] rounded-full border-2 ${isSelected ? 'border-[#00a884] bg-[#00a884]' : 'border-[#8696a0]'} flex items-center justify-center shrink-0 transition-colors">
                            ${isSelected ? '<svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>' : ''}
                        </div>
                    ` : '';

                    html += `
                        <div onclick="handleGmItemClick('${item.key}', 'document', '${(item.url || '').replace(/'/g, "\\'")}', '${(item.fileName || '').replace(/'/g, "\\'")}', '${item.chatId}', '${(item.senderName || '').replace(/'/g, "\\'")}')" class="flex items-center p-4 rounded-xl cursor-pointer transition-colors border ${selBg} group relative overflow-hidden">
                            ${checkHtml}
                            ${gmSelectMode ? '' : `<button onclick="openGmDropdown(event, '${item.key}', '${item.chatId}')" class="gm-chevron absolute top-4 right-4 w-7 h-7 rounded-full bg-transparent hover:bg-white/10 text-[#8696a0] hover:text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-20"><svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>`}
                            <div class="w-12 h-12 rounded-lg bg-[#00a884]/20 flex items-center justify-center text-[#00a884] shrink-0 mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <a ${gmSelectMode ? '' : `href="${item.url}" target="_blank"`} class="text-[#53bdeb] ${gmSelectMode ? '' : 'hover:underline'} text-[15px] block truncate mb-1">${item.url}</a>
                                <p class="text-[#8696a0] text-[13px]">${item.senderName || 'Me'}</p>
                            </div>
                        </div>
                    `;
                });
                html += `</div>`;
            }
            html += `</div>`;
        }

        container.innerHTML = html;
    }
</script>
<?php /**PATH D:\xampp\htdocs\laravel\chat_app\resources\views/chat/media_gallery.blade.php ENDPATH**/ ?>