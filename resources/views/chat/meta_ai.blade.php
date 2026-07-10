<div id="meta_ai_content" class="hidden absolute inset-0 z-50 flex-col w-full h-full overflow-hidden select-none bg-[#0b141a]">
    <!-- Header -->
    <div id="meta_ai_normal_header" class="h-16 bg-[#202c33] px-4 border-b border-[#313d45] flex items-center justify-between shrink-0 shadow-sm z-20 relative">
        <div class="flex items-center gap-3">
            <button class="sm:hidden text-[#8696a0] hover:text-[#e9edef] transition-colors mr-1" onclick="window.closeChat()">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
            </button>
            
            <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 relative overflow-hidden" style="background: linear-gradient(135deg, #106cff 0%, #00d2ff 100%);">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 8a4 4 0 0 1 4 4c0 2.21-1.79 4-4 4s-4-1.79-4-4a4 4 0 0 1 4-4z" class="fill-white"></path>
                </svg>
            </div>
            
            <div class="flex flex-col justify-center">
                <h2 class="text-[16px] font-semibold text-[#e9edef] leading-tight">Meta AI</h2>
                <p class="text-xs text-[#8696a0] font-medium mt-0.5 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 bg-[#00a884] rounded-full inline-block"></span>
                    Online
                </p>
            </div>
        </div>
        
        <!-- Header Actions -->
        <div class="flex items-center gap-4 text-[#aebac1]">
            <!-- Search Icon -->
            <button onclick="toggleSearchPanel()" class="hover:text-[#e9edef] hover:bg-[#2a3942] p-2 rounded-full transition-colors focus:outline-none">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M15.9 14.3H15l-.3-.3c1-1.1 1.6-2.7 1.6-4.3 0-3.7-3-6.7-6.7-6.7S3 6 3 9.7s3 6.7 6.7 6.7c1.6 0 3.2-.6 4.3-1.6l.3.3v.8l5.1 5.1 1.5-1.5-5-5.2zm-6.2 0c-2.6 0-4.6-2.1-4.6-4.6s2.1-4.6 4.6-4.6 4.6 2.1 4.6 4.6-2 4.6-4.6 4.6z"></path>
                </svg>
            </button>
            
            <!-- Menu Icon -->
            <div class="relative">
                <button id="meta_ai_more_btn" onclick="toggleMetaAiHeaderMenu(event)" class="hover:text-[#e9edef] hover:bg-[#2a3942] p-2 rounded-full transition-colors focus:outline-none">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path d="M12 7a2 2 0 1 0-.001-4.001A2 2 0 0 0 12 7zm0 2a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 9zm0 6a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 15z"></path>
                    </svg>
                </button>
                
                <!-- Dropdown -->
                <div id="meta_ai_header_dropdown" class="hidden absolute top-12 right-0 w-[240px] bg-[#233138] rounded-xl shadow-2xl border border-[#313d45] py-2 z-[100] transition-all duration-200 origin-top-right transform scale-95 opacity-0">
                    <button onclick="window.openMetaAiInfo(); toggleMetaAiHeaderMenu()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span class="text-[15px]">Contact info</span></button>
                    <button onclick="toggleSearchPanel(); toggleMetaAiHeaderMenu()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span class="text-[15px]">Search</span></button>
                    <button onclick="window.selectMetaAiMessage(); toggleMetaAiHeaderMenu()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span class="text-[15px]">Select messages</span></button>
                    <button onclick="toggleMetaAiHeaderMenu()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span class="text-[15px]">Mute notifications</span></button>
                    <button onclick="window.toggleFavouriteChat('meta_ai', 'user'); window.updateMetaAiHeaderFavouriteText(); toggleMetaAiHeaderMenu()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span class="text-[15px]" id="meta_ai_favourite_text">Add to favourites</span></button>
                    <button onclick="window.closeChat(); toggleMetaAiHeaderMenu()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span class="text-[15px]">Close chat</span></button>
                    <div class="h-[1px] bg-[#313d45] my-1 mx-4"></div>
                    <button onclick="toggleMetaAiHeaderMenu()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#8696a0] hover:bg-[#182229] transition-colors cursor-not-allowed"><span class="text-[15px]">Send call link</span></button>
                    <button onclick="toggleMetaAiHeaderMenu()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#8696a0] hover:bg-[#182229] transition-colors cursor-not-allowed"><span class="text-[15px]">Schedule call</span></button>
                    <button onclick="toggleMetaAiHeaderMenu()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#8696a0] hover:bg-[#182229] transition-colors cursor-not-allowed"><span class="text-[15px]">New group call</span></button>
                    <div class="h-[1px] bg-[#313d45] my-1 mx-4"></div>
                    <button onclick="if(window.openDeleteModal) { window.openDeleteModal('Clear this chat?', () => { window.clearMetaAiChat(); toggleMetaAiHeaderMenu(); }); } else { if(confirm('Clear this chat?')) { window.clearMetaAiChat(); toggleMetaAiHeaderMenu(); } }" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span class="text-[15px]">Clear chat</span></button>
                    <button onclick="if(window.openDeleteModal) { window.openDeleteModal('Delete this chat?', () => { window.clearMetaAiChat(); window.backToSidebar(); toggleMetaAiHeaderMenu(); }); } else { if(confirm('Delete this chat?')) { window.clearMetaAiChat(); window.backToSidebar(); toggleMetaAiHeaderMenu(); } }" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span class="text-[15px]">Delete chat</span></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Selection Header -->
    <div id="meta_ai_selection_header" class="hidden h-16 bg-teal-600 items-center justify-between px-4 border-b border-[#313d45] shrink-0 shadow-sm z-30 relative transition-all duration-300">
        <div class="flex items-center gap-4">
            <button onclick="window.cancelMetaAiSelection()" class="text-white hover:bg-black/10 p-2 rounded-full transition-colors focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <span id="meta_ai_selection_count" class="text-white font-semibold text-lg">1 Selected</span>
        </div>
        <div class="flex items-center">
            <button onclick="window.confirmDeleteMetaAiSelected()" class="text-white hover:bg-black/10 p-2 text-sm rounded-full transition-colors focus:outline-none" title="Delete">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Messages Area -->
    <div id="meta_ai_messages" class="flex-1 overflow-y-auto p-4 chat-bg space-y-1 scroll-smooth" style="background: linear-gradient(135deg, #0b141a 0%, #10202b 100%);">
        <!-- Messages will be injected here via JS -->
        <div class="text-center my-6">
            <span class="bg-[#182229] text-[#8696a0] text-xs px-3 py-1.5 rounded-lg shadow-sm">
                Chat securely with Meta AI
            </span>
        </div>
    </div>

    <!-- Footer Input Area -->
    <div class="h-auto min-h-[64px] bg-[#202c33] px-4 py-2 flex items-center gap-2 shrink-0 relative z-20">
        <button class="text-[#8696a0] hover:text-[#e9edef] p-2 focus:outline-none shrink-0 transition-colors">
            <svg viewBox="0 0 24 24" width="26" height="26" fill="currentColor">
                <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm2.5-9.5c.828 0 1.5-.672 1.5-1.5s-.672-1.5-1.5-1.5-1.5.672-1.5 1.5.672 1.5 1.5 1.5zm-5 0c.828 0 1.5-.672 1.5-1.5S8.828 8 8 8s-1.5.672-1.5 1.5.672 1.5 1.5 1.5zm2.5 6c2.511 0 4.67-1.516 5.568-3.693h-11.136c.898 2.177 3.057 3.693 5.568 3.693z"></path>
            </svg>
        </button>

        <!-- Meta AI Reply Context -->
        <div id="meta_ai_reply_preview" class="hidden relative mx-4 mb-2 bg-[#202c33] rounded-xl flex items-center p-2.5 shadow-sm border-l-[4px] border-[#f15c6d]">
            <div class="flex-1 min-w-0 pr-4">
                <p id="meta_ai_reply_sender" class="text-[13px] font-semibold text-[#f15c6d] mb-1">You</p>
                <p id="meta_ai_reply_text" class="text-[13px] text-[#8696a0] truncate">Message text...</p>
            </div>
            <button onclick="window.cancelMetaAiReply()" class="p-2 text-[#8696a0] hover:text-[#e9edef] rounded-full hover:bg-black/10 transition-colors focus:outline-none shrink-0 self-start">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path></svg>
            </button>
        </div>
        <!-- Input Area Container -->
        <div class="flex-1 relative flex items-center bg-[#2a3942] rounded-xl shadow-sm overflow-hidden">
            <input type="text" id="meta_ai_input" onkeypress="handleMetaAiKeyPress(event)" oninput="handleMetaAiInputToggle()" placeholder="Ask Meta AI anything" autocomplete="off"
                class="w-full bg-transparent border-none pl-4 pr-10 py-2.5 text-[15px] focus:ring-0 text-[#d1d7db] placeholder-[#8696a0] min-h-[44px] focus:outline-none">
        </div>

        <button id="meta_ai_action_btn" onclick="sendMetaAiMessage()" class="text-[#8696a0] hover:text-[#e9edef] p-2 focus:outline-none shrink-0 transition-colors">
            <svg id="meta_ai_mic_icon" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M11.999 14.942c2.001 0 3.531-1.53 3.531-3.531V4.35c0-2.001-1.53-3.531-3.531-3.531S8.469 2.35 8.469 4.35v7.061c0 2.001 1.53 3.531 3.53 3.531zm6.238-3.53c0 3.531-2.942 6.002-6.237 6.002s-6.237-2.471-6.237-6.002H3.761c0 4.001 3.178 7.297 7.061 7.885v3.884h2.354v-3.884c3.884-.588 7.061-3.884 7.061-7.885h-2.002z"></path>
            </svg>
            <svg id="meta_ai_send_icon" viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="hidden text-[#00a884]">
                <path d="M1.101 21.757L23.8 12.028 1.101 2.3l.011 7.912 13.623 1.816-13.623 1.817-.011 7.912z"></path>
            </svg>
        </button>
    </div>
    <div id="meta_ai_info_panel" class="fixed top-0 right-0 h-screen w-[400px] bg-[#111b21] border-l border-[#313d45] z-[400] flex flex-col shadow-2xl transition-all duration-300 translate-x-full">
        <div class="h-[60px] bg-[#202c33] flex items-center px-4 gap-6 shrink-0 relative">
            <button onclick="document.getElementById('meta_ai_info_panel').classList.add('translate-x-full'); document.getElementById('meta_ai_info_panel').classList.remove('translate-x-0');" class="text-[#aebac1] hover:text-[#e9edef] transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path>
                </svg>
            </button>
            <span class="text-[#e9edef] text-[16px] font-medium">Contact info</span>
        </div>

        <div class="flex-1 overflow-y-auto custom-scrollbar">
            <!-- Profile Section -->
            <div class="bg-[#111b21] py-8 flex flex-col items-center text-center px-4">
                <div class="w-[200px] h-[200px] rounded-full overflow-hidden mb-5 border-4 border-[#202c33] shadow-lg flex items-center justify-center p-4 bg-white" style="background: linear-gradient(135deg, #106cff 0%, #00d2ff 100%);">
                    <svg viewBox="0 0 24 24" width="100" height="100" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M12 8a4 4 0 0 1 4 4c0 2.21-1.79 4-4 4s-4-1.79-4-4a4 4 0 0 1 4-4z" class="fill-white"></path>
                    </svg>
                </div>
                <h2 class="text-[#e9edef] text-[24px] font-normal mb-1 truncate w-full">Meta AI</h2>
                <span class="text-[#8696a0] text-[16px]">AI Assistant</span>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-center gap-2 px-4 mb-6">
                <button onclick="toggleSearchPanel(); document.getElementById('meta_ai_info_panel').classList.add('translate-x-full'); document.getElementById('meta_ai_info_panel').classList.remove('translate-x-0');"
                    class="flex-1 max-w-[100px] h-[72px] rounded-xl border border-[#313d45] hover:bg-[#202c33] flex flex-col items-center justify-center gap-2 transition-all group">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor" class="text-[#00a884] group-hover:scale-110 transition-transform">
                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                    </svg>
                    <span class="text-[#e9edef] text-xs">Search</span>
                </button>
            </div>

            <div class="h-[10px] bg-[#0c1317]"></div>

            <!-- About Section -->
            <div class="p-4 py-5 hover:bg-[#202c33]/30 transition-colors">
                <label class="text-[#8696a0] text-[14px] mb-3 block">About</label>
                <div class="text-[#e9edef] text-[16px] leading-relaxed">
                    Chat securely with Meta AI
                </div>
            </div>

            <div class="h-[10px] bg-[#0c1317]"></div>

            <div class="flex flex-col py-2 mb-8 mt-2">
                <button onclick="if(window.openDeleteModal) { window.openDeleteModal('Clear this chat?', () => { window.clearMetaAiChat(); document.getElementById('meta_ai_info_panel').classList.add('translate-x-full'); document.getElementById('meta_ai_info_panel').classList.remove('translate-x-0'); }); } else { if(confirm('Clear this chat?')) { window.clearMetaAiChat(); document.getElementById('meta_ai_info_panel').classList.add('translate-x-full'); document.getElementById('meta_ai_info_panel').classList.remove('translate-x-0'); } }"
                    class="flex items-center px-4 py-4 gap-6 text-[#ea5656] hover:bg-[#202c33]/30 transition-colors w-full text-left focus:outline-none">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                        <path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"></path>
                    </svg>
                    <span class="text-[16px]">Clear chat</span>
                </button>
                <button onclick="if(confirm('Delete this chat?')) { window.clearMetaAiChat(); window.backToSidebar(); document.getElementById('meta_ai_info_panel').classList.add('translate-x-full'); document.getElementById('meta_ai_info_panel').classList.remove('translate-x-0'); }"
                    class="flex items-center px-4 py-4 gap-6 text-[#ea5656] hover:bg-[#202c33]/30 transition-colors w-full text-left focus:outline-none">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path>
                    </svg>
                    <span class="text-[16px]">Delete chat</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Logic for Meta AI UI interaction and Firebase storage
    let metaAiIsTyping = false;
    let metaAiMessagesRef = null;
    let metaAiListenerAdded = false;

    window.updateMetaAiHeaderFavouriteText = function() {
        const favText = document.getElementById('meta_ai_favourite_text');
        if (favText && window.favouriteChats) {
            const isFav = window.favouriteChats.includes('user_sidebar_meta_ai');
            favText.textContent = isFav ? 'Remove from favourites' : 'Add to favourites';
        }
    };

    window.metaAiReplyContext = null;

    window.setMetaAiReplyContext = function(key, senderName, text) {
        window.metaAiReplyContext = { key, senderName, text };
        document.getElementById('meta_ai_reply_sender').textContent = senderName;
        document.getElementById('meta_ai_reply_text').textContent = text;
        document.getElementById('meta_ai_reply_preview').classList.remove('hidden');
        document.getElementById('meta_ai_input').focus();
    };

    window.cancelMetaAiReply = function() {
        window.metaAiReplyContext = null;
        document.getElementById('meta_ai_reply_preview').classList.add('hidden');
    };

    window.openMetaAiChat = function() {
        if (typeof window.closeAllSearchPanels === 'function') {
            window.closeAllSearchPanels();
        }

        // Update nav UI
        document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
        document.getElementById('nav_meta_ai').classList.add('active');

        // Hide other main contents
        document.getElementById('welcome_screen')?.classList.add('hidden');
        document.getElementById('welcome_screen')?.classList.remove('flex');
        document.getElementById('chat_empty_state')?.classList.add('hidden');
        document.getElementById('chat_empty_state')?.classList.remove('flex');
        document.getElementById('active_chat_content')?.classList.add('hidden');
        document.getElementById('active_chat_content')?.classList.remove('flex');
        document.getElementById('active_group_chat_content')?.classList.add('hidden');
        document.getElementById('active_group_chat_content')?.classList.remove('flex');
        document.getElementById('archived_chat_content')?.classList.add('hidden');
        
        // Hide all other tab main columns to ensure full width
        document.getElementById('channels_main_column')?.classList.add('hidden');
        document.getElementById('channels_main_column')?.classList.remove('flex');
        document.getElementById('calls_main_column')?.classList.add('hidden');
        document.getElementById('calls_main_column')?.classList.remove('flex');
        document.getElementById('communities_main_column')?.classList.add('hidden');
        document.getElementById('communities_main_column')?.classList.remove('flex');
        document.getElementById('status_view_container')?.classList.add('hidden');
        document.getElementById('status_view_container')?.classList.remove('flex');
        
        // Show Meta AI Content
        const metaAiContent = document.getElementById('meta_ai_content');
        if (metaAiContent) {
            metaAiContent.classList.remove('hidden');
            metaAiContent.classList.add('flex');
        }

        // Initialize Firebase connection for Meta AI if not done yet
        if (window.myUserId && window.db && window.ref && window.onChildAdded && window.get) {
            if (!metaAiListenerAdded) {
                metaAiMessagesRef = window.ref(window.db, `meta_ai_chats/${window.myUserId}/messages`);
                
                // Load existing messages first
                window.get(metaAiMessagesRef).then((snapshot) => {
                    const messagesContainer = document.getElementById('meta_ai_messages');
                    messagesContainer.innerHTML = `
                        <div class="text-center my-6">
                            <span class="bg-[#182229] text-[#8696a0] text-xs px-3 py-1.5 rounded-lg shadow-sm">
                                Chat securely with Meta AI
                            </span>
                        </div>
                    `;
                    
                    if (snapshot.exists()) {
                        const msgs = snapshot.val();
                        Object.keys(msgs).forEach(key => {
                            renderMetaAiMessage(msgs[key]);
                        });
                        scrollToMetaAiBottom();
                    }
                    
                    // Add listener for new messages
                    window.onChildAdded(metaAiMessagesRef, (data) => {
                        // Prevent re-rendering messages we just fetched
                        const msg = data.val();
                        // check if already in DOM (can use a data-id attribute)
                        if (!document.querySelector(`[data-meta-msg-id="${data.key}"]`)) {
                            renderMetaAiMessage(msg, data.key);
                            scrollToMetaAiBottom();
                        }
                    });
                    
                    metaAiListenerAdded = true;
                });
            } else {
                scrollToMetaAiBottom();
            }
        }
    };

    window.handleMetaAiInputToggle = function() {
        const input = document.getElementById('meta_ai_input');
        const micIcon = document.getElementById('meta_ai_mic_icon');
        const sendIcon = document.getElementById('meta_ai_send_icon');
        
        if (input.value.trim() !== '') {
            micIcon.classList.add('hidden');
            sendIcon.classList.remove('hidden');
        } else {
            micIcon.classList.remove('hidden');
            sendIcon.classList.add('hidden');
        }
    };

    window.handleMetaAiKeyPress = function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendMetaAiMessage();
        }
    };

    window.sendMetaAiMessage = async function() {
        const input = document.getElementById('meta_ai_input');
        const text = input.value.trim();
        if (!text || metaAiIsTyping) return;
        
        input.value = '';
        window.handleMetaAiInputToggle();
        
        const timestamp = Date.now();
        const userMsgData = {
            senderId: window.myUserId,
            text: text,
            timestamp: timestamp,
            role: 'user'
        };

        let apiText = text;
        if (window.metaAiReplyContext) {
            userMsgData.replyContext = window.metaAiReplyContext;
            apiText = `Regarding this message from ${window.metaAiReplyContext.senderName}:\n"${window.metaAiReplyContext.text}"\n\nUser Question: ${text}`;
            window.cancelMetaAiReply();
        }
        
        // Push user message to Firebase
        if (metaAiMessagesRef && window.push) {
            const newRef = window.push(metaAiMessagesRef);
            await window.set(newRef, userMsgData);
        } else {
            // Fallback for local UI only if firebase fails
            renderMetaAiMessage(userMsgData);
        }
        
        scrollToMetaAiBottom();
        
        // Show typing indicator
        metaAiIsTyping = true;
        showMetaAiTyping();
        
        // Fetch AI history for context
        let history = [];
        try {
            if (window.get && metaAiMessagesRef) {
                const snap = await window.get(metaAiMessagesRef);
                if (snap.exists()) {
                    const allMsgs = snap.val();
                    // get last 10 messages for context
                    const keys = Object.keys(allMsgs).slice(-10);
                    history = keys.map(k => ({
                        role: allMsgs[k].role || (allMsgs[k].senderId === window.myUserId ? 'user' : 'assistant'),
                        content: allMsgs[k].text
                    }));
                }
            }
        } catch (e) {
            console.error("Error fetching history", e);
        }

        // Call Laravel API
        try {
            const response = await fetch('/meta-ai/ask', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    message: apiText,
                    history: history
                })
            });
            
            const data = await response.json();
            
            removeMetaAiTyping();
            
            if (response.ok && data.reply) {
                const aiMsgData = {
                    senderId: 'meta_ai',
                    text: data.reply,
                    timestamp: Date.now(),
                    role: 'assistant'
                };
                
                // Push AI response to Firebase
                if (metaAiMessagesRef && window.push) {
                    const newRef = window.push(metaAiMessagesRef);
                    await window.set(newRef, aiMsgData);
                } else {
                    renderMetaAiMessage(aiMsgData);
                }
            } else {
                throw new Error(data.error || 'Failed to get response');
            }
        } catch (error) {
            console.error('Meta AI Error:', error);
            removeMetaAiTyping();
            // Show error message
            const errorMsgData = {
                senderId: 'meta_ai',
                text: "Sorry, I'm having trouble connecting right now. Please try again later.",
                timestamp: Date.now(),
                role: 'assistant'
            };
            if (metaAiMessagesRef && window.push) {
                const newRef = window.push(metaAiMessagesRef);
                await window.set(newRef, errorMsgData);
            }
        }
        
        metaAiIsTyping = false;
        scrollToMetaAiBottom();
    };

    function renderMetaAiMessage(msg, key = null) {
        const container = document.getElementById('meta_ai_messages');
        if (!container) return;
        
        const isMe = msg.senderId === window.myUserId;
        const time = new Date(msg.timestamp).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        
        // Convert Markdown-like text to HTML simply (very basic handling)
        let htmlText = msg.text
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\*(.*?)\*/g, '<em>$1</em>')
            .replace(/\n/g, '<br>');

        let replyBlock = '';
        if (msg.replyContext) {
            replyBlock = `
            <div class="mb-1.5 p-2 bg-black/20 rounded-lg border-l-4 border-[#f15c6d] cursor-default">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-[#f15c6d] text-[13px] font-semibold">${msg.replyContext.senderName}</span>
                </div>
                <div class="text-[#e9edef]/80 text-[13px] line-clamp-3">${msg.replyContext.text}</div>
            </div>`;
        }

        const dataIdAttr = key ? `data-meta-msg-id="${key}"` : '';

        let html = '';
        if (isMe) {
            html = `
            <div id="meta_msg_${key}" onclick="if(window.isMetaAiSelectionMode) window.toggleMetaAiMessageSelection('${key}')" class="flex justify-end mb-2 relative group message-container transition-colors duration-200 cursor-default" ${dataIdAttr}>
                <div class="flex items-center w-full justify-end">
                    <div class="max-w-[75%] md:max-w-[65%] rounded-lg px-3 py-1.5 relative shadow-sm text-[15px] leading-snug bg-[#005c4b] text-[#e9edef] rounded-tr-none min-w-[100px] z-10">
                        ${replyBlock}
                        <div class="break-words mr-20 markdown-body text-[#e9edef]" style="word-break: break-word;">${htmlText}</div>
                        <div class="absolute right-2 bottom-1 flex items-center gap-1">
                            <span class="text-[11px] text-[#8696a0]">${time}</span>
                        </div>
                        <!-- Right tail -->
                        <svg viewBox="0 0 8 13" width="8" height="13" class="absolute top-0 -right-[8px] text-[#005c4b] fill-current">
                            <path d="M5.188 1H0v11.193l6.467-8.625C7.526 2.156 6.958 1 5.188 1z"></path>
                        </svg>
                    </div>
                    <!-- Selection Checkbox -->
                    <div class="meta-msg-checkbox-container hidden shrink-0 self-center ml-2 z-10">
                        <div class="w-5 h-5 rounded border-2 border-gray-400 bg-white flex items-center justify-center transition-all">
                            <input type="checkbox" id="meta_checkbox_${key}" class="meta-msg-checkbox hidden">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                </div>
            </div>`;
        } else {
            // Meta AI message
            html = `
            <div id="meta_msg_${key}" onclick="if(window.isMetaAiSelectionMode) window.toggleMetaAiMessageSelection('${key}')" class="flex justify-start mb-2 relative group message-container mt-4 transition-colors duration-200 cursor-default" ${dataIdAttr}>
                <div class="flex items-center w-full justify-start">
                    <!-- Selection Checkbox -->
                    <div class="meta-msg-checkbox-container hidden shrink-0 self-center mr-2 z-10">
                        <div class="w-5 h-5 rounded border-2 border-gray-400 bg-white flex items-center justify-center transition-all">
                            <input type="checkbox" id="meta_checkbox_${key}" class="meta-msg-checkbox hidden">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                    <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 mr-2 mt-1 z-10" style="background: linear-gradient(135deg, #106cff 0%, #00d2ff 100%);">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M12 8a4 4 0 0 1 4 4c0 2.21-1.79 4-4 4s-4-1.79-4-4a4 4 0 0 1 4-4z" class="fill-white"></path>
                        </svg>
                    </div>
                    <div class="max-w-[75%] md:max-w-[65%] rounded-lg px-3 py-2 relative shadow-sm text-[15px] leading-snug bg-[#202c33] text-[#e9edef] rounded-tl-none border border-[#313d45] z-10 min-w-[100px]">
                        ${replyBlock}
                        <div class="break-words mb-2 markdown-body text-[#e9edef]" style="word-break: break-word;">${htmlText}</div>
                        <div class="flex items-center justify-end gap-1 mt-1">
                            <span class="text-[11px] text-[#8696a0]">${time}</span>
                        </div>
                        <!-- Left tail -->
                        <svg viewBox="0 0 8 13" width="8" height="13" class="absolute top-0 -left-[8px] text-[#202c33] fill-current">
                            <path d="M2.812 1H8v11.193L1.533 3.568C.474 2.156 1.042 1 2.812 1z"></path>
                        </svg>
                    </div>
                </div>
            </div>`;
        }
        
        container.insertAdjacentHTML('beforeend', html);
    }

    function showMetaAiTyping() {
        const container = document.getElementById('meta_ai_messages');
        if (!container) return;
        
        const html = `
        <div id="meta_ai_typing_indicator" class="flex justify-start mb-2 relative group mt-4">
            <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 mr-2 mt-1 z-10" style="background: linear-gradient(135deg, #106cff 0%, #00d2ff 100%);">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 8a4 4 0 0 1 4 4c0 2.21-1.79 4-4 4s-4-1.79-4-4a4 4 0 0 1 4-4z" class="fill-white"></path>
                </svg>
            </div>
            <div class="max-w-[75%] md:max-w-[65%] rounded-lg px-4 py-3 relative shadow-sm bg-[#202c33] text-[#e9edef] rounded-tl-none border border-[#313d45] flex items-center gap-1.5">
                <div class="w-1.5 h-1.5 bg-[#8696a0] rounded-full animate-bounce" style="animation-delay: 0s"></div>
                <div class="w-1.5 h-1.5 bg-[#8696a0] rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                <div class="w-1.5 h-1.5 bg-[#8696a0] rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
            </div>
        </div>`;
        container.insertAdjacentHTML('beforeend', html);
        scrollToMetaAiBottom();
    }

    function removeMetaAiTyping() {
        const indicator = document.getElementById('meta_ai_typing_indicator');
        if (indicator) {
            indicator.remove();
        }
    }

    function scrollToMetaAiBottom() {
        const container = document.getElementById('meta_ai_messages');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    }

    // Toggle Meta AI Header Menu
    window.toggleMetaAiHeaderMenu = function(event) {
        if (event) {
            event.stopPropagation();
        }
        const dropdown = document.getElementById('meta_ai_header_dropdown');
        if (!dropdown) return;

        if (dropdown.classList.contains('hidden')) {
            if (window.updateMetaAiHeaderFavouriteText) {
                window.updateMetaAiHeaderFavouriteText();
            }
            dropdown.classList.remove('hidden');
            setTimeout(() => {
                dropdown.classList.remove('scale-95', 'opacity-0');
                dropdown.classList.add('scale-100', 'opacity-100');
            }, 10);
        } else {
            dropdown.classList.remove('scale-100', 'opacity-100');
            dropdown.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                dropdown.classList.add('hidden');
            }, 200);
        }
    };

    // Close dropdown on outside click
    document.addEventListener('click', (e) => {
        const dropdown = document.getElementById('meta_ai_header_dropdown');
        const btn = document.getElementById('meta_ai_more_btn');
        if (dropdown && !dropdown.classList.contains('hidden')) {
            if (!dropdown.contains(e.target) && (!btn || !btn.contains(e.target))) {
                dropdown.classList.remove('scale-100', 'opacity-100');
                dropdown.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    dropdown.classList.add('hidden');
                }, 200);
            }
        }
    });

    // Clear Meta AI Chat
    window.clearMetaAiChat = function() {
        if (!window.myUserId) return;
        
        // Remove from Firebase
        const messagesRef = window.ref(window.db, `meta_ai_chats/${window.myUserId}/messages`);
        window.remove(messagesRef).then(() => {
            // Clear DOM
            const container = document.getElementById('meta_ai_messages');
            if (container) {
                container.innerHTML = `
                    <div class="text-center my-6">
                        <span class="bg-[#182229] text-[#8696a0] text-xs px-3 py-1.5 rounded-lg shadow-sm">
                            Chat securely with Meta AI
                        </span>
                    </div>
                `;
            }
        }).catch(err => {
            console.error('Error clearing Meta AI chat:', err);
        });
    };
    window.isMetaAiSelectionMode = false;
    window.selectedMetaAiMessages = new Set();

    window.selectMetaAiMessage = function() {
        window.isMetaAiSelectionMode = true;
        document.getElementById('meta_ai_normal_header')?.classList.add('hidden');
        document.getElementById('meta_ai_selection_header')?.classList.remove('hidden');
        document.getElementById('meta_ai_selection_header')?.classList.add('flex');
        
        document.querySelectorAll('.meta-msg-checkbox-container').forEach(el => el.classList.remove('hidden'));
    };

    window.cancelMetaAiSelection = function() {
        window.isMetaAiSelectionMode = false;
        window.selectedMetaAiMessages.clear();
        
        document.getElementById('meta_ai_normal_header')?.classList.remove('hidden');
        document.getElementById('meta_ai_selection_header')?.classList.add('hidden');
        document.getElementById('meta_ai_selection_header')?.classList.remove('flex');
        
        document.querySelectorAll('.meta-msg-checkbox-container').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.meta-msg-checkbox').forEach(el => {
            el.checked = false;
            const box = el.parentElement;
            box.classList.remove('bg-[#0d9488]', 'border-[#0d9488]');
            box.classList.add('bg-white', 'border-gray-400');
        });
        document.querySelectorAll('[id^="meta_msg_"]').forEach(el => el.classList.remove('bg-blue-100', 'bg-opacity-50'));
    };

    window.toggleMetaAiMessageSelection = function(key) {
        if (!key || key === 'null') return;
        
        const checkbox = document.getElementById(`meta_checkbox_${key}`);
        if (!checkbox) return;
        
        const isChecked = !checkbox.checked;
        checkbox.checked = isChecked;
        
        const box = checkbox.parentElement;
        const msgContainer = document.getElementById(`meta_msg_${key}`);
        
        if (isChecked) {
            window.selectedMetaAiMessages.add(key);
            box.classList.remove('bg-white', 'border-gray-400');
            box.classList.add('bg-[#0d9488]', 'border-[#0d9488]');
            if (msgContainer) msgContainer.classList.add('bg-blue-100', 'bg-opacity-50');
        } else {
            window.selectedMetaAiMessages.delete(key);
            box.classList.remove('bg-[#0d9488]', 'border-[#0d9488]');
            box.classList.add('bg-white', 'border-gray-400');
            if (msgContainer) msgContainer.classList.remove('bg-blue-100', 'bg-opacity-50');
        }
        
        document.getElementById('meta_ai_selection_count').textContent = `${window.selectedMetaAiMessages.size} Selected`;
        
        if (window.selectedMetaAiMessages.size === 0) {
            window.cancelMetaAiSelection();
        }
    };

    window.confirmDeleteMetaAiSelected = function() {
        if (window.selectedMetaAiMessages.size === 0) return;
        if (confirm(`Delete ${window.selectedMetaAiMessages.size} message(s)?`)) {
            window.selectedMetaAiMessages.forEach(key => {
                if (key && key !== 'null') {
                    window.remove(window.ref(window.db, `meta_ai_chats/${window.myUserId}/messages/${key}`));
                    const msgEl = document.getElementById(`meta_msg_${key}`);
                    if (msgEl) msgEl.remove();
                }
            });
            window.cancelMetaAiSelection();
        }
    };

    window.openMetaAiInfo = function() {
        // Close search sidebar if open
        const searchSidebar = document.getElementById('search_sidebar');
        if (searchSidebar) {
            searchSidebar.classList.add('hidden');
            searchSidebar.classList.remove('flex');
        }

        const panel = document.getElementById('meta_ai_info_panel');
        if (panel) {
            panel.classList.remove('translate-x-full');
            panel.classList.add('translate-x-0');
        }
    };

    window.closeMetaAiInfo = function() {
        const panel = document.getElementById('meta_ai_info_panel');
        if (panel) {
            panel.classList.add('translate-x-full');
            panel.classList.remove('translate-x-0');
        }
    };
</script>

