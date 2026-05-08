<style>
    #group_call_dropdown.show { display: flex !important; opacity: 1 !important; transform: scale(1) !important; }
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #374045; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #4a555c; }
</style>
<div id="active_group_chat_content" class="hidden flex-col flex-1 h-full overflow-hidden select-none">
    <div class="h-16 bg-[#202c33] px-4 border-b border-[#313d45] shrink-0 shadow-sm z-20 relative">
        <!-- Normal Header -->
        <div id="group_normal_header" class="flex items-center justify-between h-full w-full transition-all duration-300">
            <div class="flex items-center gap-3">
                <button class="sm:hidden text-[#8696a0] hover:text-[#e9edef] transition-colors mr-1" onclick="window.backToSidebar()">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                    </svg>
                </button>
                <div id="active_group_chat_avatar" onclick="openGroupInfoPanel()" class="w-10 h-10 rounded-full bg-[#2a3942] flex items-center justify-center text-gray-600 font-bold shadow-sm overflow-hidden transition-transform hover:scale-105 cursor-pointer shrink-0">
                    <svg class="w-6 h-6 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div onclick="openGroupInfoPanel()" class="cursor-pointer min-w-0 flex flex-col justify-center">
                    <h2 id="active_group_chat_title" class="text-[15.5px] font-semibold text-[#e9edef] leading-tight truncate">Select a group chat</h2>
                    <p id="active_group_chat_subtitle" class="text-xs text-[#8696a0] font-medium mt-0.5 truncate">Group chat</p>
                </div>
            </div>

            <!-- Header Actions -->
            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <!-- Call Button Dropdown -->
                <div class="relative">
                    <button id="group_call_btn_pill" class="hidden sm:flex items-center gap-2.5 bg-[#2a3942] hover:bg-[#384b57] text-[#e9edef] px-4 py-2 rounded-full cursor-pointer transition-all duration-200 border border-transparent hover:border-[#313d45] focus:outline-none shrink-0 group">
                        <div class="flex items-center gap-2 border-r border-[#313d45] pr-2 group-hover:border-[#8696a0]">
                            <svg class="w-5 h-5 text-[#8696a0] group-hover:text-[#e9edef]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm font-semibold">Call</span>
                        </div>
                        <svg class="w-4 h-4 text-[#8696a0] group-hover:text-[#e9edef]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Call Dropdown -->
                    <div id="group_call_dropdown" style="display: none;" class="hidden absolute top-14 right-0 w-[340px] bg-[#111b21] rounded-2xl shadow-2xl z-[100] flex flex-col border border-white/5 overflow-hidden transition-all duration-200 transform origin-top-right scale-95 opacity-0">
                        <!-- Header with Expand/Collapse -->
                        <div class="p-4 cursor-pointer hover:bg-white/5 transition-colors flex items-center justify-between" onclick="window.toggleGroupCallMembersList()">
                            <div class="flex items-center gap-3">
                                <div id="group_call_dropdown_avatar" class="w-10 h-10 rounded-full overflow-hidden bg-[#2a3942] shrink-0">
                                    <img src="https://ui-avatars.com/api/?name=Group&background=2a3942&color=fff" class="w-full h-full object-cover">
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <span id="group_call_dropdown_name" class="text-[#e9edef] font-medium text-[16px] truncate">Group</span>
                                    <span class="text-[#8696a0] text-xs">Select people</span>
                                </div>
                            </div>
                            <svg id="group_call_chevron" class="w-5 h-5 text-[#8696a0] transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>

                        <!-- Members List (Hidden by default, shown when expanded) -->
                        <div id="group_call_members_list" class="hidden flex flex-col border-t border-white/5 overflow-hidden">
                            <div class="px-4 py-2 bg-white/5">
                                <span class="text-[12px] text-[#8696a0] font-semibold uppercase tracking-wider">Members</span>
                            </div>
                            <div id="group_call_members_container" class="flex-1 max-h-[280px] overflow-y-auto custom-scrollbar">
                                <!-- Members rendered here -->
                            </div>

                            <!-- Voice/Video buttons inside the list -->
                            <div class="p-4 flex gap-3 border-t border-white/5 bg-[#111b21]">
                                <button onclick="window.startGroupVoiceCall(true)" class="flex-1 bg-[#2a3942] hover:bg-[#384b57] text-[#e9edef] py-2.5 rounded-full flex items-center justify-center gap-2 font-semibold transition-all active:scale-95">
                                    <svg class="w-5 h-5 text-[#8696a0]" fill="currentColor" viewBox="0 0 24 24"><path d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z"></path></svg>
                                    Voice
                                </button>
                                <button onclick="window.startGroupVideoCall(true)" class="flex-1 bg-[#2a3942] hover:bg-[#384b57] text-[#e9edef] py-2.5 rounded-full flex items-center justify-center gap-2 font-semibold transition-all active:scale-95">
                                    <svg class="w-5 h-5 text-[#8696a0]" fill="currentColor" viewBox="0 0 24 24"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"></path></svg>
                                    Video
                                </button>
                            </div>
                        </div>

                        <!-- Collapsed Footer Actions -->
                        <div id="group_call_collapsed_footer" class="p-4 flex flex-col gap-3">
                            <div class="flex gap-3">
                                <button onclick="window.startGroupVoiceCall(false)" class="flex-1 bg-[#00a884] hover:bg-[#06cf9c] text-[#111b21] py-3 rounded-full flex items-center justify-center gap-2 font-bold transition-all active:scale-[0.98]">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z"></path></svg>
                                    Voice Call
                                </button>
                                <button onclick="window.startGroupVideoCall(false)" class="flex-1 bg-[#00a884] hover:bg-[#06cf9c] text-[#111b21] py-3 rounded-full flex items-center justify-center gap-2 font-bold transition-all active:scale-[0.98]">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"></path></svg>
                                    Video Call
                                </button>
                            </div>
                            <div class="h-[1px] bg-white/5 my-1"></div>
                            <button class="w-full flex items-center gap-3 px-2 py-2 text-[#e9edef] hover:bg-white/5 rounded-lg transition-colors text-sm">
                                <div class="w-8 h-8 rounded-full bg-[#202c33] flex items-center justify-center text-[#8696a0]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.826a4 4 0 015.656 0l4 4a4 4 0 01-5.656 5.656l-1.103-1.103"></path></svg>
                                </div>
                                Send call link
                            </button>
                            <button class="w-full flex items-center gap-3 px-2 py-2 text-[#e9edef] hover:bg-white/5 rounded-lg transition-colors text-sm">
                                <div class="w-8 h-8 rounded-full bg-[#202c33] flex items-center justify-center text-[#8696a0]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                Schedule call
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Search Icon -->
                <button onclick="toggleGroupSearchDrawer()" class="p-2.5 text-[#8696a0] hover:text-[#e9edef] hover:bg-[#2a3942] rounded-full transition-all duration-200 focus:outline-none" title="Search">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                <!-- Menu Icon -->
                <button id="group_header_more_btn" onclick="toggleGroupHeaderMoreMenu(event)" class="p-2.5 text-[#8696a0] hover:text-[#e9edef] hover:bg-[#2a3942] rounded-full transition-all duration-200 focus:outline-none" title="Menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Selection Header (Corrected Nesting: Sibling to Normal Header) -->
        <div id="group_selection_header" class="hidden absolute inset-0 bg-teal-600 items-center justify-between px-4 h-full w-full transition-all duration-300 z-30">
            <div class="flex items-center gap-4">
                <button onclick="cancelGroupSelection()" class="text-white hover:bg-black/10 p-2 rounded-full transition-colors focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <span id="group_selection_count" class="text-white font-semibold text-lg">1 Selected</span>
            </div>
            <div class="flex items-center">
                <button onclick="confirmDeleteGroupSelected()" class="text-white hover:bg-black/10 p-2 rounded-full transition-colors focus:outline-none" title="Delete">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Pinned Message Bar (Hidden by default) -->
    <div id="group_pinned_bar" class="hidden bg-[#2a3942]/90 backdrop-blur-sm px-4 py-2 flex items-center justify-between border-b border-white/5 cursor-pointer hover:bg-[#384b57] transition-colors z-[15]">
        <div class="flex items-center gap-3 overflow-hidden">
            <div class="text-[#00a884] shrink-0">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                    <path d="M16 9V4l1 0c.55 0 1-.45 1-1s-.45-1-1-1H7c-.55 0-1 .45-1 1s.45 1 1 1l1 0v5c0 1.66-1.34 3-3 3v2h5.97v7l1 1 1-1v-7H19v-2c-1.66 0-3-1.34-3-3z"></path>
                </svg>
            </div>
            <div class="flex flex-col min-w-0">
                <span class="text-[#00a884] text-[13px] font-semibold">Pinned message</span>
                <span id="group_pinned_text" class="text-[#8696a0] text-sm truncate w-full">Message text goes here...</span>
            </div>
        </div>
        <button onclick="window.unpinGroupMessage(event)" class="text-[#8696a0] hover:text-[#e9edef] p-1 rounded-full hover:bg-white/5 transition-colors">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path>
            </svg>
        </button>
    </div>

    <!-- Main Container Row including Chat list and right-side drawers -->
    <div class="flex-1 flex overflow-hidden relative">

        <!-- Group Message List -->
        <div id="group_messages" class="flex-1 overflow-y-auto p-4 chat-bg space-y-1 scroll-smooth bg-[#0b141a]"></div>

        <!-- Group Search Drawer (Hidden by default) -->
        <div id="group_search_drawer" class="hidden w-[360px] h-full bg-[#111b21] border-l border-[#313d45] flex flex-col shrink-0">
            <!-- Search Header -->
            <div class="h-16 bg-[#202c33] px-4 flex items-center justify-between shrink-0 border-b border-[#313d45]">
                <div class="flex items-center gap-3 min-w-0">
                    <button onclick="toggleGroupSearchDrawer()" class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <span class="text-[#e9edef] font-medium text-[16px]">Search Messages</span>
                </div>
            </div>

            <!-- Search Input Field -->
            <div class="p-3 bg-[#111b21] border-b border-[#313d45]">
                <div class="bg-[#202c33] flex items-center gap-2 px-3 py-2 rounded-lg border border-transparent focus-within:border-[#00a884]">
                    <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" id="group_search_input" oninput="searchGroupMessages()" placeholder="Search messages..." class="w-full bg-transparent border-none text-[#e9edef] text-sm focus:ring-0 placeholder-gray-500">
                </div>
            </div>

            <!-- Search Results List -->
            <div id="group_search_results" class="flex-1 overflow-y-auto p-3 space-y-2 select-none">
                <div class="text-[#8696a0] text-center text-sm py-4">Type to search messages in group</div>
            </div>
        </div>

        <!-- Group Information Sidebar Drawer -->
        <!-- Group Information Sidebar Drawer -->
        <div id="group_info_panel" class="hidden w-[400px] h-full bg-[#111b21] border-l border-[#313d45] flex flex-col shrink-0 z-40 select-none">
            <!-- Header -->
            <div class="h-16 bg-[#111b21] px-4 flex items-center gap-6 shrink-0 z-10">
                <button onclick="closeGroupInfoPanel()" class="text-[#aebac1] hover:text-[#e9edef] transition-colors focus:outline-none">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path>
                    </svg>
                </button>
                <span class="text-[#e9edef] text-[16px] font-medium">Group info</span>
            </div>

            <div class="flex-1 overflow-y-auto [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-thumb]:bg-[#374248] [&::-webkit-scrollbar-track]:bg-transparent pb-10">
                <!-- Avatar & Title Section -->
                <div class="pt-6 pb-4 flex flex-col items-center px-4 shrink-0">
                    <div id="group_info_avatar_container" class="w-[200px] h-[200px] rounded-full overflow-hidden mb-4 shadow-lg bg-[#2a3942] flex items-center justify-center cursor-pointer">
                        <img src="https://ui-avatars.com/api/?name=Group&background=2a3942&color=fff" id="group_info_avatar" class="w-full h-full object-cover">
                    </div>

                    <div class="flex items-center gap-2 mb-1 w-full justify-center px-4">
                        <h2 class="text-[#e9edef] text-[24px] font-normal truncate text-center" id="group_info_name">Professor's DIV-A 🤓</h2>
                        <button class="text-[#aebac1] hover:text-[#e9edef] transition-colors flex-shrink-0" title="Group info">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="9"></circle>
                                <path d="M12 11v4"></path>
                                <circle cx="12" cy="7.5" r="0.5" fill="currentColor"></circle>
                            </svg>
                        </button>
                    </div>
                    <span class="text-[#8696a0] text-[15px] mb-6">Group · <span id="group_info_member_count_pill" class="text-[#00a884]">... members</span></span>

                    <!-- Action Buttons Row -->
                    <div class="flex justify-center gap-3 w-full mb-6">
                        <button class="flex-1 flex flex-col items-center justify-center py-3.5 rounded-2xl border border-[#313d45] hover:bg-[#202c33] transition-colors gap-2" onclick="window.openAddGroupMembersModal()">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="text-[#00a884]">
                                <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                            </svg>
                            <span class="text-[#e9edef] text-[15px]">Add</span>
                        </button>
                        <button class="flex-1 flex flex-col items-center justify-center py-3.5 rounded-2xl border border-[#313d45] hover:bg-[#202c33] transition-colors gap-2" onclick="window.toggleGroupSearchDrawer()">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="text-[#00a884]">
                                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                            </svg>
                            <span class="text-[#e9edef] text-[15px]">Search</span>
                        </button>
                    </div>
                </div>

                <!-- Group Created Info -->
                <div class="px-6 mb-5">
                    <p class="text-[#8696a0] text-[14.5px] leading-relaxed">Group created by +91 96017 84863, on 26/03/2025 at 10:16 am</p>
                </div>

                <div class="h-[1px] bg-[#313d45] mx-6 mb-5"></div>

                <!-- Media, Links and Docs -->
                <div class="px-6 py-2 hover:bg-[#202c33]/30 cursor-pointer transition-colors mb-3">
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center gap-4">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="text-[#8696a0]">
                                <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"></path>
                            </svg>
                            <span class="text-[#e9edef] text-[16px]">Media, links and docs</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[#8696a0] text-[15px]">86</span>
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0] -rotate-90">
                                <path d="M16.59 8.59L12 13.17 7.41 8.59 6 10l6 6 6-6z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex gap-2 overflow-hidden">
                        <div class="w-[80px] h-[80px] bg-[#2a3942] rounded-lg overflow-hidden shrink-0">
                            <img src="https://images.unsplash.com/photo-1511632765486-a01980e01a18?w=150&h=150&fit=crop" class="w-full h-full object-cover">
                        </div>
                        <div class="w-[80px] h-[80px] bg-[#2a3942] rounded-lg overflow-hidden shrink-0">
                            <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?w=150&h=150&fit=crop" class="w-full h-full object-cover">
                        </div>
                        <div class="w-[80px] h-[80px] bg-[#2a3942] rounded-lg overflow-hidden shrink-0 relative">
                            <img src="https://images.unsplash.com/photo-1506869640319-fe1a24fd06dc?w=150&h=150&fit=crop" class="w-full h-full object-cover">
                            <div class="absolute bottom-1 left-1 bg-black/60 rounded px-1.5 py-0.5 text-[10px] text-white font-medium">GIF</div>
                        </div>
                        <div class="w-[80px] h-[80px] bg-[#2a3942] rounded-lg overflow-hidden shrink-0 relative">
                            <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=150&h=150&fit=crop" class="w-full h-full object-cover">
                            <div class="absolute bottom-1 left-1 flex items-center gap-1 text-white text-[11px] drop-shadow-md bg-black/40 px-1 rounded">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"></path></svg>
                                0:21
                            </div>
                        </div>
                    </div>
                </div>

                <div class="h-[1px] bg-[#313d45] mx-6 mb-3"></div>

                <!-- Starred Messages & Notifications -->
                <div class="flex flex-col mb-4">
                    <div class="px-6 py-3.5 hover:bg-[#202c33]/30 cursor-pointer transition-colors flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="text-[#8696a0]">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                            </svg>
                            <span class="text-[#e9edef] text-[16px]">Starred messages</span>
                        </div>
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0] -rotate-90">
                            <path d="M16.59 8.59L12 13.17 7.41 8.59 6 10l6 6 6-6z"></path>
                        </svg>
                    </div>

                    <div class="px-6 py-3.5 hover:bg-[#202c33]/30 cursor-pointer transition-colors flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="text-[#8696a0]">
                                <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"></path>
                            </svg>
                            <span class="text-[#e9edef] text-[16px]">Notification settings</span>
                        </div>
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0] -rotate-90">
                            <path d="M16.59 8.59L12 13.17 7.41 8.59 6 10l6 6 6-6z"></path>
                        </svg>
                    </div>
                </div>

                <div class="h-[1px] bg-[#313d45] mx-6 mb-4"></div>

                <!-- Encryption & Privacy cards -->
                <div class="px-6 mb-5">
                    <div class="bg-[#182229] rounded-[16px] overflow-hidden shadow-sm border border-[#202c33]">
                        <div class="p-4 py-4 hover:bg-[#202c33] cursor-pointer transition-colors flex items-start gap-4">
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor" class="text-[#8696a0] shrink-0 mt-0.5">
                                <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"></path>
                            </svg>
                            <div>
                                <div class="text-[#e9edef] text-[16px] mb-0.5">Encryption</div>
                                <div class="text-[#8696a0] text-[14px] leading-snug">Messages are end-to-end encrypted. Click to learn more.</div>
                            </div>
                        </div>
                        <div class="h-[1px] bg-[#202c33] ml-[54px]"></div>
                        <div class="p-4 py-4 hover:bg-[#202c33] cursor-pointer transition-colors flex items-start gap-4">
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor" class="text-[#8696a0] shrink-0 mt-0.5">
                                <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"></path>
                            </svg>
                            <div class="w-full flex justify-between items-center">
                                <div>
                                    <div class="text-[#e9edef] text-[16px] mb-0.5">Advanced chat privacy</div>
                                    <div class="text-[#8696a0] text-[14px]">Off</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="h-[1px] bg-[#313d45] mx-6 mb-4"></div>

                <!-- Members Section -->
                <div class="px-6 mb-2">
                    <div class="flex justify-between items-center mb-4">
                        <span id="group_members_count" class="text-[#8696a0] text-[15px]">... members</span>
                        <button class="text-[#aebac1] hover:text-[#e9edef] transition-colors focus:outline-none">
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                            </svg>
                        </button>
                    </div>

                    <div id="group_members_list" class="flex flex-col">
                        <!-- Add Member Item -->
                        <div class="flex items-center gap-4 py-3 hover:bg-[#202c33]/30 cursor-pointer transition-colors" onclick="window.openAddGroupMembersModal()">
                            <div class="w-[44px] h-[44px] rounded-full bg-[#00a884] flex items-center justify-center text-white shrink-0">
                                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                    <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                                </svg>
                            </div>
                            <span class="text-[#e9edef] text-[16px]">Add member</span>
                        </div>
                    </div>
                </div>

                <div class="h-[1px] bg-[#313d45] mx-6 mb-4"></div>

                <!-- Footer Actions -->
                <div class="flex flex-col mb-8 px-6 pb-4">
                    <div class="py-4 hover:bg-[#202c33]/30 cursor-pointer transition-colors flex items-center gap-5">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" class="text-[#8696a0]">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                        </svg>
                        <span class="text-[#e9edef] text-[16px]">Add to favourites</span>
                    </div>

                    <div class="py-4 hover:bg-[#202c33]/30 cursor-pointer transition-colors flex items-center gap-5">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" class="text-[#8696a0]">
                            <path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"></path>
                        </svg>
                        <span class="text-[#e9edef] text-[16px]">Add to list</span>
                    </div>

                    <div class="py-4 hover:bg-[#202c33]/30 cursor-pointer transition-colors flex items-center gap-5">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="text-[#f15c6d]">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11H7v-2h10v2z"></path>
                        </svg>
                        <span class="text-[#f15c6d] text-[16px]">Clear chat</span>
                    </div>

                    <div class="py-4 hover:bg-[#202c33]/30 cursor-pointer transition-colors flex items-center gap-5">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="text-[#f15c6d]">
                            <path d="M10.09 15.59L11.5 17l5-5-5-5-1.41 1.41L12.67 11H3v2h9.67l-2.58 2.59zM19 3H5c-1.11 0-2 .9-2 2v4h2V5h14v14H5v-4H3v4c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"></path>
                        </svg>
                        <span class="text-[#f15c6d] text-[16px]">Exit group</span>
                    </div>

                    <div class="py-4 hover:bg-[#202c33]/30 cursor-pointer transition-colors flex items-center gap-5">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" class="text-[#f15c6d]">
                            <path d="M14.59 10l-4.59-4.59v3.59H2v2h8v3.59L14.59 10zM22 3v18H10V3h12z"></path>
                        </svg>
                        <span class="text-[#f15c6d] text-[16px]">Report group</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

            <!-- Footer with Emoji, Attachment, Reply and Input -->
    <div class="h-auto min-h-[64px] bg-[#202c33] px-4 py-2 flex flex-col justify-end shrink-0 relative z-20">

        <!-- Replying Block (Moved outside the flex row to be on top) -->
        <div id="group_replying_to_block" class="hidden bg-[#2a3942] backdrop-blur-sm border-l-4 border-[#00a884] px-4 py-2 mb-2 rounded-xl shadow-sm flex justify-between items-center group cursor-pointer transition-all">
            <div class="flex flex-col overflow-hidden">
                <span id="group_replying_to_name" class="font-semibold text-[#00a884] text-[13px] mb-0.5">Replying to message</span>
                <span id="group_replying_to_text" class="text-[#8696a0] text-sm truncate max-w-[200px] sm:max-w-md"></span>
            </div>
            <button onclick="cancelGroupReply()" class="text-[#8696a0] hover:text-red-500 p-1.5 rounded-full hover:bg-black/10 focus:outline-none transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="flex items-center gap-2 w-full relative">
            <!-- Emoji Picker Button -->
            <button type="button" id="group_emoji_toggle_btn" onclick="toggleGroupEmojiPicker()" class="text-[#8696a0] hover:text-[#e9edef] p-2 focus:outline-none shrink-0 transition-colors">
                <svg viewBox="0 0 24 24" width="26" height="26" fill="currentColor">
                    <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm2.5-9.5c.828 0 1.5-.672 1.5-1.5s-.672-1.5-1.5-1.5-1.5.672-1.5 1.5.672 1.5 1.5 1.5zm-5 0c.828 0 1.5-.672 1.5-1.5S8.828 8 8 8s-1.5.672-1.5 1.5.672 1.5 1.5 1.5zm2.5 6c2.511 0 4.67-1.516 5.568-3.693h-11.136c.898 2.177 3.057 3.693 5.568 3.693z"></path>
                </svg>
            </button>

            <!-- Attachment Trigger -->
            <div class="relative shrink-0">
                <button type="button" id="group_attach_toggle_btn" onclick="toggleGroupAttachMenu()" class="text-gray-500 hover:text-gray-300 p-2 focus:outline-none transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                    </svg>
                </button>

                <!-- Attachment Menu -->
                <div id="group_attach_menu" class="hidden absolute bottom-full mb-3 left-0 sm:left-4 bg-[#1f2c34] p-4 rounded-3xl w-[320px] shadow-2xl z-50 transition-all origin-bottom-left">
                    <div class="grid grid-cols-4 gap-y-6 gap-x-2 place-items-center">
                        <div class="flex flex-col items-center gap-1 group cursor-pointer" onclick="selectGroupFile('.pdf,.doc,.docx,.xls,.xlsx,.txt,.zip')">
                            <div class="w-14 h-14 rounded-2xl bg-[#5f66cd] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-300 text-xs">Document</span>
                        </div>
                        <div class="flex flex-col items-center gap-1 group cursor-pointer" onclick="selectGroupFile('image/*;capture=camera')">
                            <div class="w-14 h-14 rounded-2xl bg-[#ed517b] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9zm12 4a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <span class="text-gray-300 text-xs">Camera</span>
                        </div>
                        <div class="flex flex-col items-center gap-1 group cursor-pointer" onclick="selectGroupFile('image/*,video/*')">
                            <div class="w-14 h-14 rounded-2xl bg-[#bf59cf] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-300 text-xs">Gallery</span>
                        </div>
                        <div class="flex flex-col items-center gap-1 group cursor-pointer" onclick="selectGroupFile('audio/*')">
                            <div class="w-14 h-14 rounded-2xl bg-[#e35920] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-300 text-xs">Audio</span>
                        </div>
                        <div class="flex flex-col items-center gap-1 group cursor-pointer" onclick="shareGroupLocation()">
                            <div class="w-14 h-14 rounded-2xl bg-[#1dae75] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-300 text-xs">Location</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Emoji Picker Panel (Toggled with button) -->
            <div id="group_emoji_picker_container" class="hidden absolute bottom-full mb-3 left-0 sm:left-4 z-50 shadow-2xl origin-bottom-left rounded-[16px] overflow-hidden flex flex-col bg-white dark:bg-[#202c33] border border-gray-200 dark:border-gray-700 w-[320px]">
                <div class="grid grid-cols-6 place-items-center gap-1 p-3 bg-[#111b21]">
                    <span onclick="insertEmojiIntoGroupInput('😊')" class="text-2xl cursor-pointer hover:scale-110 p-1.5 rounded transition-all hover:bg-[#202c33]">😊</span>
                    <span onclick="insertEmojiIntoGroupInput('😂')" class="text-2xl cursor-pointer hover:scale-110 p-1.5 rounded transition-all hover:bg-[#202c33]">😂</span>
                    <span onclick="insertEmojiIntoGroupInput('😍')" class="text-2xl cursor-pointer hover:scale-110 p-1.5 rounded transition-all hover:bg-[#202c33]">😍</span>
                    <span onclick="insertEmojiIntoGroupInput('👍')" class="text-2xl cursor-pointer hover:scale-110 p-1.5 rounded transition-all hover:bg-[#202c33]">👍</span>
                    <span onclick="insertEmojiIntoGroupInput('❤️')" class="text-2xl cursor-pointer hover:scale-110 p-1.5 rounded transition-all hover:bg-[#202c33]">❤️</span>
                    <span onclick="insertEmojiIntoGroupInput('🙌')" class="text-2xl cursor-pointer hover:scale-110 p-1.5 rounded transition-all hover:bg-[#202c33]">🙌</span>
                    <span onclick="insertEmojiIntoGroupInput('😭')" class="text-2xl cursor-pointer hover:scale-110 p-1.5 rounded transition-all hover:bg-[#202c33]">😭</span>
                    <span onclick="insertEmojiIntoGroupInput('🎉')" class="text-2xl cursor-pointer hover:scale-110 p-1.5 rounded transition-all hover:bg-[#202c33]">🎉</span>
                    <span onclick="insertEmojiIntoGroupInput('🙏')" class="text-2xl cursor-pointer hover:scale-110 p-1.5 rounded transition-all hover:bg-[#202c33]">🙏</span>
                    <span onclick="insertEmojiIntoGroupInput('🎂')" class="text-2xl cursor-pointer hover:scale-110 p-1.5 rounded transition-all hover:bg-[#202c33]">🎂</span>
                    <span onclick="insertEmojiIntoGroupInput('🔥')" class="text-2xl cursor-pointer hover:scale-110 p-1.5 rounded transition-all hover:bg-[#202c33]">🔥</span>
                    <span onclick="insertEmojiIntoGroupInput('🤝')" class="text-2xl cursor-pointer hover:scale-110 p-1.5 rounded transition-all hover:bg-[#202c33]">🤝</span>
                </div>
            </div>

            <!-- Input Area Container -->
            <div id="group_input_area_container" class="flex-1 relative flex items-center bg-white rounded-lg shadow-sm">
                <!-- State 1: Normal Text Input -->
                <div id="group_text_input_state" class="w-full relative flex items-center">
                    <input type="text" id="group_msg" oninput="handleGroupInputToggle()" onkeypress="handleGroupKeyPress(event)" placeholder="Type a message" class="w-full bg-transparent border-none rounded-lg pl-4 pr-10 py-2 text-[15px] focus:ring-0 text-gray-800 placeholder-gray-500 min-h-[40px] focus:outline-none">
                    <!-- Inside Voice to Text Mic Button -->
                    <button type="button" id="group_inside_mic_btn" onclick="toggleGroupVoiceRecord()" class="absolute right-3 text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                            <path d="M11.999 14.942c2.001 0 3.531-1.53 3.531-3.531V4.35c0-2.001-1.53-3.531-3.531-3.531S8.469 2.35 8.469 4.35v7.061c0 2.001 1.53 3.531 3.53 3.531zm6.238-3.53c0 3.531-2.942 6.002-6.237 6.002s-6.237-2.471-6.237-6.002H3.761c0 4.001 3.178 7.297 7.061 7.885v3.884h2.354v-3.884c3.884-.588 7.061-3.884 7.061-7.885h-2.002z"></path>
                        </svg>
                    </button>
                </div>

                <!-- State 2: Voice Note Recording UI -->
                <div id="group_audio_recording_state" class="hidden w-full items-center justify-between px-3 h-[42px] bg-white">
                    <button type="button" onclick="cancelGroupVoiceNote()" class="text-gray-500 hover:text-red-500 focus:outline-none transition-colors">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zm2.46-7.12l1.41-1.41L12 12.59l2.12-2.12 1.41 1.41L13.41 14l2.12 2.12-1.41 1.41L12 15.41l-2.12 2.12-1.41-1.41L10.59 14l-2.13-2.12zM15.5 4l-1-1h-5l-1 1H5v2h14V4z"></path>
                        </svg>
                    </button>
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 bg-red-500 rounded-full animate-pulse"></div>
                        <span id="group_audio_timer" class="text-[15px] font-medium text-gray-700">0:00</span>
                    </div>
                    <div class="flex-1 mx-3 flex items-center h-full overflow-hidden">
                        <!-- Waveform animation effect -->
                        <div class="flex items-center gap-[3px] h-4 w-full opacity-60 justify-end overflow-hidden">
                            <div class="w-1 bg-gray-400 rounded-full h-2 animate-[pulse_1s_ease-in-out_infinite]"></div>
                            <div class="w-1 bg-gray-400 rounded-full h-4 animate-[pulse_1.2s_ease-in-out_infinite_0.2s]"></div>
                            <div class="w-1 bg-gray-400 rounded-full h-3 animate-[pulse_0.8s_ease-in-out_infinite_0.4s]"></div>
                            <div class="w-1 bg-gray-400 rounded-full h-5 animate-[pulse_1.1s_ease-in-out_infinite_0.1s]"></div>
                        </div>
                    </div>
                </div>
            </div>

            <button id="group_action_btn" onclick="handleGroupActionBtn()" class="bg-[#00a884] hover:bg-[#008f6f] text-white rounded-full w-11 h-11 flex items-center justify-center shadow-sm shrink-0 transition-colors focus:outline-none">
                <svg id="group_mic_icon" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M11.999 14.942c2.001 0 3.531-1.53 3.531-3.531V4.35c0-2.001-1.53-3.531-3.531-3.531S8.469 2.35 8.469 4.35v7.061c0 2.001 1.53 3.531 3.53 3.531zm6.238-3.53c0 3.531-2.942 6.002-6.237 6.002s-6.237-2.471-6.237-6.002H3.761c0 4.001 3.178 7.297 7.061 7.885v3.884h2.354v-3.884c3.884-.588 7.061-3.884 7.061-7.885h-2.002z"></path>
                </svg>
                <svg id="group_send_icon" viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="hidden ml-1">
                    <path d="M1.101 21.757L23.8 12.028 1.101 2.3l.011 7.912 13.623 1.816-13.623 1.817-.011 7.912z"></path>
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
    function handleGroupKeyPress(e) {
        if (e.key === 'Enter') {
            sendGroupMessage();
        }
    }

    function toggleGroupAttachMenu() {
        const menu = document.getElementById('group_attach_menu');
        if (menu) menu.classList.toggle('hidden');
    }

    function toggleGroupEmojiPicker() {
        const container = document.getElementById('group_emoji_picker_container');
        if (container) container.classList.toggle('hidden');
    }

    function insertEmojiIntoGroupInput(emoji) {
        const input = document.getElementById('group_msg');
        if (input) {
            input.value += emoji;
            handleGroupInputToggle();
            input.focus();
        }
        document.getElementById('group_emoji_picker_container')?.classList.add('hidden');
    }

    function selectGroupFile(accepts) {
        let fileInput = document.getElementById('file_input');
        if (fileInput) {
            fileInput.setAttribute('accept', accepts);
            fileInput.click();
        }
        toggleGroupAttachMenu();
    }

    window.shareGroupLocation = function() {
        toggleGroupAttachMenu();
        if (!navigator.geolocation) {
            alert("Geolocation is not supported by your browser");
            return;
        }

        const modal = document.getElementById('location_preview_modal');
        if (modal) modal.classList.remove('hidden');
        document.getElementById('location_default_panel')?.classList.remove('hidden');
        document.getElementById('live_location_config_panel')?.classList.add('hidden');
        document.getElementById('location_modal_title').textContent = 'Send location';
        document.getElementById('location_search_bar')?.classList.add('hidden');
        document.getElementById('search_results').innerHTML = '';

        if (window.fetchLocation) window.fetchLocation();
    };

    function handleGroupInputToggle() {
        const val = document.getElementById('group_msg').value.trim();
        const micIcon = document.getElementById('group_mic_icon');
        const sendIcon = document.getElementById('group_send_icon');
        const insideMicBtn = document.getElementById('group_inside_mic_btn');

        if (val.length > 0) {
            if (micIcon) micIcon.classList.add('hidden');
            if (sendIcon) sendIcon.classList.remove('hidden');
            if (insideMicBtn) insideMicBtn.classList.add('hidden');
        } else {
            if (micIcon) micIcon.classList.remove('hidden');
            if (sendIcon) sendIcon.classList.add('hidden');
            if (insideMicBtn) insideMicBtn.classList.remove('hidden');
        }
    }

    function handleGroupActionBtn() {
        const val = document.getElementById('group_msg').value.trim();
        if (val.length > 0) {
            sendGroupMessage();
        } else {
            if (isGroupRecordingVoiceNote) {
                stopAndSendGroupVoiceNote();
            } else {
                startGroupVoiceNote();
            }
        }
    }

    // Initialize dropdown caller logic once DOM or script mounts
    function initGroupCallDropdown() {
        const pill = document.getElementById('group_call_btn_pill');
        const dropdown = document.getElementById('group_call_dropdown');
        if (pill && dropdown) {
            pill.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = !dropdown.classList.contains('hidden');
                if (isOpen) {
                    dropdown.classList.remove('show');
                    setTimeout(() => {
                        dropdown.style.display = 'none';
                        dropdown.classList.add('hidden');
                    }, 200);
                } else {
                    dropdown.style.display = 'flex';
                    dropdown.classList.remove('hidden');
                    dropdown.offsetHeight; // force reflow
                    dropdown.classList.add('show');

                    const hideOnOutsideClick = (event) => {
                        if (!dropdown.contains(event.target) && !pill.contains(event.target)) {
                            dropdown.classList.remove('show');
                            setTimeout(() => {
                                dropdown.style.display = 'none';
                                dropdown.classList.add('hidden');
                            }, 200);
                            document.removeEventListener('click', hideOnOutsideClick);
                        }
                    };
                    setTimeout(() => document.addEventListener('click', hideOnOutsideClick), 10);
                }
            });
        }
    }

    setTimeout(initGroupCallDropdown, 500);

    window.selectedCallParticipants = new Set();

    window.toggleGroupCallMembersList = function() {
        const list = document.getElementById('group_call_members_list');
        const footer = document.getElementById('group_call_collapsed_footer');
        const chevron = document.getElementById('group_call_chevron');
        const isHidden = list.classList.contains('hidden');

        if (isHidden) {
            list.classList.remove('hidden');
            footer.classList.add('hidden');
            chevron.style.transform = 'rotate(180deg)';
            window.renderGroupCallParticipants();
        } else {
            list.classList.add('hidden');
            footer.classList.remove('hidden');
            chevron.style.transform = 'rotate(0deg)';
        }
    };

    window.renderGroupCallParticipants = function() {
        const container = document.getElementById('group_call_members_container');
        if (!container || !window.activeChatUser || !window.activeChatUser.users) return;

        container.innerHTML = '';
        window.activeChatUser.users.forEach(member => {
            if (member.id == window.myUserId) return; // Don't show self

            const isSelected = window.selectedCallParticipants.has(member.id);
            const avatarUrl = member.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(member.name)}&background=2a3942&color=fff`;

            const item = document.createElement('div');
            item.className = 'flex items-center gap-3 px-4 py-3 hover:bg-white/5 cursor-pointer transition-colors border-b border-white/[0.02]';
            item.onclick = (e) => {
                e.stopPropagation();
                window.toggleCallParticipant(member.id);
            };

            item.innerHTML = `
                <div class="relative">
                    <img src="${avatarUrl}" class="w-10 h-10 rounded-full object-cover">
                    <div id="call_check_${member.id}" class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-[#00a884] border-2 border-[#111b21] flex items-center justify-center ${isSelected ? '' : 'hidden'}">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-[#e9edef] text-[15px] font-medium truncate">${member.name}</div>
                    <div class="text-[#8696a0] text-xs truncate">${member.phone || 'Member'}</div>
                </div>
                <div class="w-5 h-5 rounded border border-[#3b4a54] flex items-center justify-center ${isSelected ? 'bg-[#00a884] border-[#00a884]' : ''}">
                    ${isSelected ? '<svg class="w-3.5 h-3.5 text-[#111b21]" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>' : ''}
                </div>
            `;
            container.appendChild(item);
        });
    };

    window.toggleCallParticipant = function(userId) {
        if (window.selectedCallParticipants.has(userId)) {
            window.selectedCallParticipants.delete(userId);
        } else {
            window.selectedCallParticipants.add(userId);
        }
        window.renderGroupCallParticipants();
    };

    window.startGroupVoiceCall = function(useSelection = false) {
        if (!window.activeChatUser) { alert('Please select a group first.'); return; }

        let participants = [];
        if (useSelection) {
            participants = Array.from(window.selectedCallParticipants);
            if (participants.length === 0) {
                alert('Please select at least one participant.');
                return;
            }
        } else {
            // Call everyone in the group except self
            participants = window.activeChatUser.users
                .filter(u => u.id != window.myUserId)
                .map(u => u.id);
        }

        const params = new URLSearchParams({
            name: window.activeChatUser.name || 'Group',
            avatar: window.activeChatUser.avatar || '',
            role: 'caller',
            group_id: window.activeChatUser.id,
            participants: participants.join(',')
        });

        window.location.href = '/chat/groups/voice-call?' + params.toString();
    };

    window.startGroupVideoCall = function(useSelection = false) {
        if (!window.activeChatUser) { alert('Please select a group first.'); return; }

        let participants = [];
        if (useSelection) {
            participants = Array.from(window.selectedCallParticipants);
            if (participants.length === 0) {
                alert('Please select at least one participant.');
                return;
            }
        } else {
            participants = window.activeChatUser.users
                .filter(u => u.id != window.myUserId)
                .map(u => u.id);
        }

        const params = new URLSearchParams({
            name: window.activeChatUser.name || 'Group',
            avatar: window.activeChatUser.avatar || '',
            role: 'caller',
            group_id: window.activeChatUser.id,
            participants: participants.join(',')
        });

        window.location.href = '/chat/groups/video-call?' + params.toString();
    };

    // Close any menu/picker if clicked outside
    document.addEventListener('click', function(event) {
        const attachMenu = document.getElementById('group_attach_menu');
        const attachBtn = document.getElementById('group_attach_toggle_btn');
        if (attachMenu && attachBtn && !attachMenu.classList.contains('hidden')) {
            const path = event.composedPath();
            if (!path.includes(attachMenu) && !path.includes(attachBtn)) {
                attachMenu.classList.add('hidden');
            }
        }

        const picker = document.getElementById('group_emoji_picker_container');
        const emojiBtn = document.getElementById('group_emoji_toggle_btn');
        if (picker && emojiBtn && !picker.classList.contains('hidden')) {
            const path = event.composedPath();
            if (!path.includes(picker) && !path.includes(emojiBtn)) {
                picker.classList.add('hidden');
            }
        }
    });

    async function sendGroupMessage() {
        const input = document.getElementById('group_msg');
        const text = input.value.trim();
        if (!text || !window.currentChatId) return;

        let msgData = {
            text: text,
            sender_id: window.myUserId,
            time: Math.floor(Date.now() / 1000),
            type: 'text',
            status: 'sent',
            total_members: window.currentGroupMembersCount || 1
        };

        if (window.groupReplyingTo) {
            msgData.reply_to_id = window.groupReplyingTo;
            msgData.reply_to_name = window.replyingToName;
            msgData.reply_to_text = window.replyingToText;
            if (typeof window.cancelGroupReply === 'function') {
                window.cancelGroupReply();
            }
        }

        input.value = '';
        if (typeof handleGroupInputToggle === 'function') handleGroupInputToggle();

        // Correct path for groups
        const groupId = window.currentChatId.replace('group_', '');
        msgData.read_by = {}; // Initialize read_by object
        await window.push(window.ref(window.db, `groups/${groupId}/messages`), msgData);
        input.focus();

        // Send FCM Notification
        fetch('/send-group-notification', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                group_id: groupId,
                message: text,
                type: 'text'
            })
        }).catch(err => console.error('Notification error:', err));
    }

    window.getGroupTickSVG = function (status) {
        if (status === 'all_read') {
            return `<svg viewBox="0 0 16 15" width="16" height="15" class="text-[#53bdeb]" fill="currentColor"><path d="M15,5.4L9.3,11.1l-1.3-1.4l5.7-5.7L15,5.4z M10.4,5.4L4.7,11.1L2,8.4L0.6,9.8l4.1,4.1l7.1-7.1L10.4,5.4z"></path></svg>`;
        } else if (status === 'read_by_some') {
            return `<svg viewBox="0 0 16 15" width="16" height="15" class="text-[#8696a0]" fill="currentColor"><path d="M15,5.4L9.3,11.1l-1.3-1.4l5.7-5.7L15,5.4z M10.4,5.4L4.7,11.1L2,8.4L0.6,9.8l4.1,4.1l7.1-7.1L10.4,5.4z"></path></svg>`;
        } else {
            return `<svg viewBox="0 0 16 11" width="16" height="11" class="text-[#8696a0]" fill="currentColor"><path d="M11.8,1.6L5.3,8.1L2.1,4.9l-1.5,1.5L5.3,11l8-8L11.8,1.6z"></path></svg>`;
        }
    };

    // --- GROUP INFO SIDEBAR PANEL LOGIC ---
    window.openGroupInfoPanel = function() {
        const u = window.activeChatUser;
        if (!u) return;

        document.getElementById('group_info_name').textContent = u.name;
        document.getElementById('group_info_avatar').src = u.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(u.name)}&background=202c33&color=fff`;

        if (u.id) {
            window.get(window.ref(window.db, 'groups/' + u.id)).then((snapshot) => {
                const group = snapshot.val();
                const listEl = document.getElementById('group_members_list');
                const countEl = document.getElementById('group_members_count');

                if (group && group.users && listEl) {
                    if (countEl) countEl.textContent = group.users.length + ' members';

                    const addMemberHtml = `
                        <div class="flex items-center gap-4 py-3 hover:bg-[#202c33]/30 cursor-pointer transition-colors" onclick="window.openAddGroupMembersModal()">
                            <div class="w-[44px] h-[44px] rounded-full bg-[#00a884] flex items-center justify-center text-white shrink-0">
                                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                    <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                                </svg>
                            </div>
                            <span class="text-[#e9edef] text-[16px]">Add member</span>
                        </div>
                    `;

                    let membersHtml = '';
                    group.users.forEach(userId => {
                        let memberName = "Member";
                        let memberAbout = "Available";
                        let isAdmin = (group.createdBy == userId);
                        let isAdminBadge = isAdmin ? `<div class="border border-[#00a884]/40 bg-[#00a884]/10 rounded px-1.5 py-0.5 text-[11px] text-[#00a884]">Group admin</div>` : '';

                        if (userId == window.myUserId) {
                            memberName = "You";
                            membersHtml += `
                            <div class="flex items-center justify-between py-3 hover:bg-[#202c33]/30 cursor-pointer transition-colors">
                                <div class="flex items-center gap-4">
                                    <img src="${window.myUserAvatar || `https://ui-avatars.com/api/?name=You&background=2a3942&color=fff`}" class="w-[44px] h-[44px] rounded-full object-cover">
                                    <div>
                                        <div class="text-[#e9edef] text-[16px]">You</div>
                                        <div class="text-[#8696a0] text-[14px] mt-0.5">Available</div>
                                    </div>
                                </div>
                                ${isAdminBadge}
                            </div>`;
                        } else if (window.allContacts) {
                            const matchUser = window.allContacts.find(c => c.id == userId);
                            if (matchUser) {
                                memberName = matchUser.name || matchUser.phone;
                                memberAbout = matchUser.about || "Available";
                            }

                            membersHtml += `
                            <div class="flex items-center justify-between py-3 hover:bg-[#202c33]/30 cursor-pointer transition-colors">
                                <div class="flex items-center gap-4">
                                    <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(memberName.charAt(0))}&background=2a3942&color=fff" class="w-[44px] h-[44px] rounded-full object-cover">
                                    <div class="w-[170px]">
                                        <div class="text-[#e9edef] text-[16px] truncate">${memberName}</div>
                                        <div class="text-[#8696a0] text-[14px] truncate mt-0.5">${memberAbout}</div>
                                    </div>
                                </div>
                                ${isAdminBadge}
                            </div>`;
                        }
                    });

                    listEl.innerHTML = addMemberHtml + membersHtml;
                }
            });
        }

        const p = document.getElementById('group_info_panel');
        if (p) {
            p.classList.remove('hidden');
            p.classList.add('flex');
        }
    };

    window.closeGroupInfoPanel = function() {
        const p = document.getElementById('group_info_panel');
        if (p) {
            p.classList.remove('flex');
            p.classList.add('hidden');
        }
    };

    // --- SEARCH LOGIC ---
    window.toggleGroupSearchDrawer = function() {
        const drawer = document.getElementById('group_search_drawer');
        if (!drawer) return;

        const isHidden = drawer.classList.contains('hidden');
        if (isHidden) {
            drawer.classList.remove('hidden');
            drawer.classList.add('flex');
            document.getElementById('group_search_input')?.focus();
        } else {
            drawer.classList.add('hidden');
            drawer.classList.remove('flex');
        }
    };

    window.searchGroupMessages = function() {
        const queryVal = document.getElementById('group_search_input').value.trim().toLowerCase();
        const resultsEl = document.getElementById('group_search_results');
        if (!resultsEl) return;

        if (!queryVal) {
            resultsEl.innerHTML = `<div class="text-[#8696a0] text-center text-sm py-4">Type to search messages in group</div>`;
            return;
        }

        let html = '';
        let found = false;

        for (let key in window.globalMessages) {
            const m = window.globalMessages[key];
            if (m && m.text && m.text.toLowerCase().includes(queryVal)) {
                found = true;
                const time = m.time ? new Date(m.time * 1000).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : '';
                html += `
                    <div onclick="scrollToGroupMessage('${key}')" class="p-3 bg-[#202c33] hover:bg-[#2a3942] rounded-lg transition-colors cursor-pointer border border-[#313d45]">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-[#00a884] font-medium text-xs">Message</span>
                            <span class="text-[#8696a0] text-xs">${time}</span>
                        </div>
                        <p class="text-[#e9edef] text-sm break-words">${m.text.replace(new RegExp(queryVal, 'gi'), match => `<span class="bg-[#00a884] text-white px-1 rounded">${match}</span>`)}</p>
                    </div>`;
            }
        }

        if (!found) {
            resultsEl.innerHTML = `<div class="text-[#8696a0] text-center text-sm py-4">No results found</div>`;
        } else {
            resultsEl.innerHTML = html;
        }
    };

    window.scrollToGroupMessage = function(key) {
        const el = document.getElementById('msg_' + key);
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            el.classList.add('bg-[#00a884]/20');
            setTimeout(() => el.classList.remove('bg-[#00a884]/20'), 3000);
        }
    };

    // --- GROUP VOICE NOTE RECORDING LOGIC ---
    let groupMediaRecorder = null;
    let groupAudioChunks = [];
    let groupVoiceTimerInterval = null;
    let groupVoiceSeconds = 0;
    let isGroupRecordingVoiceNote = false;

    async function startGroupVoiceNote() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
            groupMediaRecorder = new MediaRecorder(stream);
            groupAudioChunks = [];

            groupMediaRecorder.ondataavailable = event => {
                if (event.data.size > 0) groupAudioChunks.push(event.data);
            };

            groupMediaRecorder.onstop = () => {
                stream.getTracks().forEach(track => track.stop());
            };

            groupMediaRecorder.start();
            isGroupRecordingVoiceNote = true;

            document.getElementById('group_text_input_state').classList.add('hidden');
            document.getElementById('group_audio_recording_state').classList.remove('hidden');
            document.getElementById('group_audio_recording_state').classList.add('flex');

            document.getElementById('group_mic_icon').classList.add('hidden');
            document.getElementById('group_send_icon').classList.remove('hidden');

            groupVoiceSeconds = 0;
            document.getElementById('group_audio_timer').innerText = '0:00';
            groupVoiceTimerInterval = setInterval(() => {
                groupVoiceSeconds++;
                const mins = Math.floor(groupVoiceSeconds / 60);
                const secs = groupVoiceSeconds % 60;
                document.getElementById('group_audio_timer').innerText = `${mins}:${secs.toString().padStart(2, '0')}`;
            }, 1000);

        } catch (err) {
            console.error('Group mic access error:', err);
            alert('Unable to access microphone.');
        }
    }

    async function stopAndSendGroupVoiceNote() {
        if (!groupMediaRecorder || !isGroupRecordingVoiceNote) return;

        clearInterval(groupVoiceTimerInterval);
        isGroupRecordingVoiceNote = false;

        document.getElementById('group_text_input_state').classList.remove('hidden');
        document.getElementById('group_audio_recording_state').classList.add('hidden');
        document.getElementById('group_audio_recording_state').classList.remove('flex');

        document.getElementById('group_mic_icon').classList.remove('hidden');
        document.getElementById('group_send_icon').classList.add('hidden');

        groupMediaRecorder.addEventListener('stop', async () => {
            const audioBlob = new Blob(groupAudioChunks, { type: 'audio/webm' });
            if (audioBlob.size < 100) return;

            const fd = new FormData();
            fd.append('file', audioBlob, 'group_voice_note.webm');

            try {
                const res = await fetch('/upload-status-media', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': window.csrf || '' },
                    body: fd
                });
                const rData = await res.json();
                if (rData.status && rData.url) {
                    let msgData = {
                        text: '',
                        sender_id: window.myUserId,
                        time: Math.floor(Date.now() / 1000),
                        type: 'audio',
                        status: 'sent',
                        file_url: rData.url,
                        file_name: 'Voice Note',
                        total_members: window.currentGroupMembersCount || 1
                    };
                    await window.push(window.ref(window.db, `chats/${window.currentChatId}/messages`), msgData);
                }
            } catch (err) {
                console.error('Group voice note send error:', err);
            }
        });

        groupMediaRecorder.stop();
    }

    function cancelGroupVoiceNote() {
        if (groupMediaRecorder && isGroupRecordingVoiceNote) {
            clearInterval(groupVoiceTimerInterval);
            isGroupRecordingVoiceNote = false;
            groupMediaRecorder.stop();

            document.getElementById('group_text_input_state').classList.remove('hidden');
            document.getElementById('group_audio_recording_state').classList.add('hidden');
            document.getElementById('group_audio_recording_state').classList.remove('flex');

            document.getElementById('group_mic_icon').classList.remove('hidden');
            document.getElementById('group_send_icon').classList.add('hidden');
        }
    }

    let isGroupRecordingSpeechText = false;
    let groupRecognition = null;

    function toggleGroupVoiceRecord() {
        const micBtn = document.getElementById('group_inside_mic_btn');
        if (!isGroupRecordingSpeechText) {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            if (!SpeechRecognition) {
                alert('Speech recognition is not supported by your browser.');
                return;
            }

            groupRecognition = new SpeechRecognition();
            groupRecognition.continuous = false;
            groupRecognition.interimResults = true;
            groupRecognition.lang = 'en-US';

            groupRecognition.onstart = () => {
                isGroupRecordingSpeechText = true;
                if (micBtn) micBtn.classList.add('text-red-500', 'animate-pulse');
            };

            groupRecognition.onresult = (e) => {
                const transcript = Array.from(e.results)
                    .map(result => result[0].transcript)
                    .join('');
                const input = document.getElementById('group_msg');
                if (input) {
                    input.value = transcript;
                    handleGroupInputToggle();
                }
            };

            groupRecognition.onerror = (e) => {
                console.error('Speech recognition error', e);
                stopGroupSpeechRecognition();
            };

            groupRecognition.onend = () => {
                stopGroupSpeechRecognition();
            };

            groupRecognition.start();
        } else {
            stopGroupSpeechRecognition();
        }
    }

    function stopGroupSpeechRecognition() {
        if (groupRecognition && isGroupRecordingSpeechText) {
            groupRecognition.stop();
            isGroupRecordingSpeechText = false;
            const micBtn = document.getElementById('group_inside_mic_btn');
            if (micBtn) micBtn.classList.remove('text-red-500', 'animate-pulse');
        }
    }
</script>

<!-- Group Message Dropdown Menu -->
<div id="group_msg_dropdown" class="hidden fixed z-50 transition-all duration-100 opacity-0 scale-95" style="width: 220px;">
    <!-- Emoji Reactions Bar -->
    <div class="bg-[#233138] rounded-full shadow-lg border border-[#313d45] px-3 py-1.5 flex items-center gap-2 mb-2 absolute" style="top: -46px; left: 0; width: max-content;">
        <button class="hover:scale-125 transition-transform text-xl focus:outline-none">👍</button>
        <button class="hover:scale-125 transition-transform text-xl focus:outline-none">❤️</button>
        <button class="hover:scale-125 transition-transform text-xl focus:outline-none">😂</button>
        <button class="hover:scale-125 transition-transform text-xl focus:outline-none">😮</button>
        <button class="hover:scale-125 transition-transform text-xl focus:outline-none">😢</button>
        <button class="hover:scale-125 transition-transform text-xl focus:outline-none">🙏</button>
        <button class="text-[#8696a0] hover:text-[#e9edef] hover:bg-white/10 rounded-full w-7 h-7 flex items-center justify-center transition-colors focus:outline-none">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path></svg>
        </button>
    </div>

    <!-- Dropdown Menu -->
    <div class="bg-[#233138] rounded-xl shadow-2xl border border-[#313d45] py-2 w-full">
        <button onclick="window.replyToGroupMsg()" class="w-full text-left px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-[15px]">Reply</button>
        <button id="group_dropdown_reply_priv" onclick="window.replyPrivatelyFromGroup()" class="w-full text-left px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-[15px]">Reply privately</button>
        <button id="group_dropdown_msg_user" onclick="window.messageUserFromGroup()" class="w-full text-left px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-[15px] truncate">Message <span id="group_dropdown_sender_name"></span></button>
        <button onclick="window.copyGroupMessage()" class="w-full text-left px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-[15px]">Copy</button>
        <button onclick="window.forwardGroupMessage()" class="w-full text-left px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-[15px]">Forward</button>
        <button onclick="window.pinGroupMessage()" class="w-full text-left px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-[15px]">Pin</button>
        <button class="w-full text-left px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-[15px]">Ask Meta AI</button>
        <button onclick="window.askMetaAIGroupMessage()" class="w-full text-left px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-[15px]">Ask Meta AI</button>
        <button onclick="window.starGroupMessage()" class="w-full text-left px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-[15px]">Star</button>
        <div class="h-[1px] bg-[#313d45] my-1 mx-4"></div>
        <button onclick="window.selectGroupMessage()" class="w-full text-left px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-[15px]">Select</button>
        <div id="group_dropdown_report_divider" class="h-[1px] bg-[#313d45] my-1 mx-4"></div>
        <button id="group_dropdown_report" onclick="window.reportGroupMessage()" class="w-full text-left px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-[15px]">Report</button>
        <button onclick="window.deleteGroupMessage()" class="w-full text-left px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-[15px]">Delete</button>
    </div>
</div>

<!-- Group Header More Options Dropdown -->
<div id="group_header_more_dropdown" class="hidden absolute top-14 right-4 w-[260px] bg-[#233138] rounded-xl shadow-2xl border border-[#313d45] py-2 z-[100] transition-all duration-200 origin-top-right transform scale-95 opacity-0">
    <button onclick="window.openAddGroupMembersModal(); toggleGroupHeaderMoreMenu()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors">
        <svg class="w-5 h-5 text-[#8696a0]" fill="currentColor" viewBox="0 0 24 24"><path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path></svg>
        <span class="text-[15px]">Add member</span>
    </button>
    <button onclick="window.openGroupInfoPanel(); toggleGroupHeaderMoreMenu()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors">
        <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
        <span class="text-[15px]">Group info</span>
    </button>
    <button onclick="window.toggleGroupSearchDrawer(); toggleGroupHeaderMoreMenu()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors">
        <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        <span class="text-[15px]">Search</span>
    </button>
    <button onclick="toggleGroupHeaderMoreMenu()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors">
        <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
        <span class="text-[15px]">Select messages</span>
    </button>
    <div class="w-full flex items-center justify-between px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors cursor-pointer group" onclick="toggleGroupHeaderMoreMenu()">
        <div class="flex items-center gap-4">
            <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M13.73 21a2 2 0 0 1-3.46 0"></path><path d="M18.63 13A17.89 17.89 0 0 1 18 8"></path><path d="M6.26 6.26A5.86 5.86 0 0 0 6 8a7 7 0 0 0 7 7v0"></path><path d="M18 8a6 6 0 0 0-9.33-5"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
            <span class="text-[15px]">Mute notifications</span>
        </div>
        <svg class="w-4 h-4 text-[#8696a0]" fill="currentColor" viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"></path></svg>
    </div>
    <button onclick="toggleGroupHeaderMoreMenu()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors">
        <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
        <span class="text-[15px]">Disappearing messages</span>
    </button>
    <button onclick="toggleGroupHeaderMoreMenu()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors">
        <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
        <span class="text-[15px]">Lock chat</span>
    </button>
    <button onclick="toggleGroupHeaderMoreMenu()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors">
        <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
        <span class="text-[15px]">Add to favourites</span>
    </button>
    <button onclick="toggleGroupHeaderMoreMenu()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors">
        <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
        <span class="text-[15px]">Add to list</span>
    </button>
    <button onclick="window.backToSidebar(); toggleGroupHeaderMoreMenu()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors">
        <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
        <span class="text-[15px]">Close chat</span>
    </button>
    <div class="h-[1px] bg-[#313d45] my-1 mx-4"></div>
    <button onclick="toggleGroupHeaderMoreMenu()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors">
        <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="8" y1="12" x2="16" y2="12"></line></svg>
        <span class="text-[15px]">Clear chat</span>
    </button>
    <button onclick="toggleGroupHeaderMoreMenu()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors">
        <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
        <span class="text-[15px]">Exit group</span>
    </button>
</div>

<script>
    window.openGroupMessageOptions = function(event, messageKey, isMe, encodedSenderName, senderId) {
        event.stopPropagation();

        const dropdown = document.getElementById('group_msg_dropdown');
        if (!dropdown) return;

        const replyPriv = document.getElementById('group_dropdown_reply_priv');
        const msgUser = document.getElementById('group_dropdown_msg_user');
        const reportBtn = document.getElementById('group_dropdown_report');
        const reportDiv = document.getElementById('group_dropdown_report_divider');
        const senderNameSpan = document.getElementById('group_dropdown_sender_name');

        if (isMe) {
            replyPriv.style.display = 'none';
            msgUser.style.display = 'none';
            reportBtn.style.display = 'none';
            reportDiv.style.display = 'none';
        } else {
            replyPriv.style.display = 'block';
            msgUser.style.display = 'block';
            reportBtn.style.display = 'block';
            reportDiv.style.display = 'block';
            senderNameSpan.textContent = decodeURIComponent(encodedSenderName);
        }

        const rect = event.currentTarget.getBoundingClientRect();
        dropdown.classList.remove('hidden');

        // Default position: below and left-aligned with the chevron
        let top = rect.bottom;
        let left = rect.left - 180; // shift left since it's on the right edge of bubble

        if (left < 10) left = 10;

        // If it goes off the bottom of the screen, render it above the bubble
        // 400px is a rough estimate of the max height of the dropdown
        if (top + 400 > window.innerHeight) {
            top = rect.top - Math.min(380, rect.top - 50);
        }

        dropdown.style.top = top + 'px';
        dropdown.style.left = left + 'px';

        setTimeout(() => {
            dropdown.classList.remove('opacity-0', 'scale-95');
            dropdown.classList.add('opacity-100', 'scale-100');
        }, 10);

        window._activeGroupMsgKey = messageKey;
        window._activeGroupSenderId = senderId;
    };

    window.toggleGroupHeaderMoreMenu = function(event) {
        if (event) event.stopPropagation();
        const dropdown = document.getElementById('group_header_more_dropdown');
        if (!dropdown) return;

        const isHidden = dropdown.classList.contains('hidden');
        if (isHidden) {
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
    };

    // Global listener to close dropdowns on outside click
    document.addEventListener('click', function(e) {
        // Message dropdown
        const msgDropdown = document.getElementById('group_msg_dropdown');
        if (msgDropdown && !msgDropdown.classList.contains('hidden')) {
            if (!msgDropdown.contains(e.target)) {
                msgDropdown.classList.add('opacity-0', 'scale-95');
                msgDropdown.classList.remove('opacity-100', 'scale-100');
                setTimeout(() => msgDropdown.classList.add('hidden'), 200);
            }
        }

        // Header more options dropdown
        const headerDropdown = document.getElementById('group_header_more_dropdown');
        const headerBtn = document.getElementById('group_header_more_btn');
        if (headerDropdown && !headerDropdown.classList.contains('hidden')) {
            if (!headerDropdown.contains(e.target) && !headerBtn.contains(e.target)) {
                headerDropdown.classList.remove('opacity-100', 'scale-100');
                headerDropdown.classList.add('opacity-0', 'scale-95');
                setTimeout(() => headerDropdown.classList.add('hidden'), 200);
            }
        }

        // Attachment menu
        const attachMenu = document.getElementById('group_attach_menu');
        const attachBtn = document.getElementById('group_attach_toggle_btn');
        if (attachMenu && !attachMenu.classList.contains('hidden')) {
            if (!attachMenu.contains(e.target) && !attachBtn.contains(e.target)) {
                attachMenu.classList.add('hidden');
            }
        }

        // Emoji picker
        const emojiPicker = document.getElementById('group_emoji_picker_container');
        const emojiBtn = document.getElementById('group_emoji_toggle_btn');
        if (emojiPicker && !emojiPicker.classList.contains('hidden')) {
            if (!emojiPicker.contains(e.target) && !emojiBtn.contains(e.target)) {
                emojiPicker.classList.add('hidden');
            }
        }
    });

    window.copyGroupMessage = function() {
        const messageKey = window._activeGroupMsgKey;
        if (!messageKey) return;
        const msgElement = document.getElementById(`msg_${messageKey}`);
        if (!msgElement) return;
        const textDiv = msgElement.querySelector('.break-words');
        if (textDiv) {
            const text = textDiv.childNodes[0].textContent.trim();
            navigator.clipboard.writeText(text).then(() => {
                // Show a small toast or just close
                document.getElementById('group_msg_dropdown').classList.add('hidden');
            });
        }
    };

    window.messageUserFromGroup = function() {
        const senderId = window._activeGroupSenderId;
        if (!senderId) return;
        const matchUser = window.allContacts.find(c => c.id == senderId);
        if (matchUser) {
            window.selectChat(matchUser.id, matchUser.name, matchUser.phone, matchUser.avatar, matchUser.about);
            document.getElementById('group_msg_dropdown')?.classList.add('hidden');
        }
    };

    window.replyPrivatelyFromGroup = function() {
        const messageKey = window._activeGroupMsgKey;
        const senderId = window._activeGroupSenderId;
        if (!messageKey || !senderId) return;

        const msgElement = document.getElementById(`msg_${messageKey}`);
        if (!msgElement) return;
        const textDiv = msgElement.querySelector('.break-words');
        const msgText = textDiv ? textDiv.childNodes[0].textContent.trim() : "Media";

        const matchUser = window.allContacts.find(c => c.id == senderId);
        if (matchUser) {
            window.selectChat(matchUser.id, matchUser.name, matchUser.phone, matchUser.avatar, matchUser.about);
            document.getElementById('group_msg_dropdown')?.classList.add('hidden');
            // After selecting chat, initiate reply
            setTimeout(() => {
                if (window.replyToMsg) {
                    window.replyToMsg(messageKey, matchUser.name, msgText, window.activeChatName);
                }
            }, 500);
        }
    };

    window.isGroupSelectionMode = false;
    window.selectedGroupMessages = new Set();

    window.cancelGroupSelection = function() {
        window.isGroupSelectionMode = false;
        window.selectedGroupMessages.clear();
        document.getElementById('group_normal_header').classList.remove('hidden');
        document.getElementById('group_selection_header').classList.add('hidden');
        document.querySelectorAll('.msg-checkbox-container').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.msg-checkbox').forEach(el => {
            el.checked = false;
            const box = el.parentElement;
            box.classList.remove('bg-[#0d9488]', 'border-[#0d9488]');
            box.classList.add('bg-white', 'border-gray-400');
        });
        document.querySelectorAll('[id^="msg_"]').forEach(el => el.classList.remove('bg-blue-100', 'bg-opacity-50'));
    };

    window.confirmDeleteGroupSelected = function() {
        if (window.selectedGroupMessages.size === 0) return;
        window.openDeleteModal(`Delete ${window.selectedGroupMessages.size} message(s)?`, () => {
            window.selectedGroupMessages.forEach(key => {
                window.remove(window.ref(window.db, `groups/${window.currentChatId.replace('group_', '')}/messages/${key}`)).catch(e => {
                    console.error('Delete error:', e);
                });
            });
            window.cancelGroupSelection();
        });
    };

    window.toggleGroupMsgSelection = function(key) {
        if (!window.isGroupSelectionMode) return;
        const checkbox = document.getElementById('checkbox_' + key);
        const msgEl = document.getElementById('msg_' + key);
        if (!checkbox || !msgEl) return;

        checkbox.checked = !checkbox.checked;
        const box = checkbox.parentElement;

        if (checkbox.checked) {
            window.selectedGroupMessages.add(key);
            msgEl.classList.add('bg-blue-100', 'bg-opacity-50');
            box.classList.add('bg-[#0d9488]', 'border-[#0d9488]');
            box.classList.remove('bg-white', 'border-gray-400');
        } else {
            window.selectedGroupMessages.delete(key);
            msgEl.classList.remove('bg-blue-100', 'bg-opacity-50');
            box.classList.remove('bg-[#0d9488]', 'border-[#0d9488]');
            box.classList.add('bg-white', 'border-gray-400');
        }

        if (window.selectedGroupMessages.size === 0) {
            window.cancelGroupSelection();
        } else {
            document.getElementById('group_selection_count').textContent = window.selectedGroupMessages.size + ' Selected';
        }
    };

    window.deleteGroupMessage = function() {
        const key = window._activeGroupMsgKey;
        if (!key) return;

        document.getElementById('group_msg_dropdown')?.classList.add('hidden');

        const msgData = window.globalMessages[key];
        let typeLabel = 'message';
        if (msgData) {
            if (msgData.type === 'image') typeLabel = 'photo';
            else if (msgData.type === 'video') typeLabel = 'video';
            else if (msgData.type === 'audio') typeLabel = 'audio';
            else if (msgData.type === 'document') typeLabel = 'document';
        }

        window.openDeleteModal(`Delete ${typeLabel}?`, () => {
            window.remove(window.ref(window.db, `groups/${window.currentChatId.replace('group_', '')}/messages/${key}`))
                .catch(e => console.error("Group delete error:", e));
        });
    };

    window.pinGroupMessage = function() {
        const messageKey = window._activeGroupMsgKey;
        if (!messageKey || !window.currentChatId) return;

        const msgElement = document.getElementById(`msg_${messageKey}`);
        const textDiv = msgElement ? msgElement.querySelector('.break-words') : null;
        const msgText = textDiv ? textDiv.childNodes[0].textContent.trim() : "Media";

        window.update(window.ref(window.db, `groups/${window.currentChatId}`), {
            pinned_msg: {
                key: messageKey,
                text: msgText
            }
        });
        document.getElementById('group_msg_dropdown').classList.add('hidden');
    };

    window.unpinGroupMessage = function(event) {
        if (event) event.stopPropagation();
        if (!window.currentChatId) return;
        window.update(window.ref(window.db, `groups/${window.currentChatId}`), {
            pinned_msg: null
        });
    };

    window.forwardGroupMessage = function() {
        const messageKey = window._activeGroupMsgKey;
        if (!messageKey) return;
        // For now, we'll just show a prompt to simulate selection
        // In a real app, this would open a modal with contact list
        alert('Forwarding functionality triggered. Please select a contact (UI pending).');
        document.getElementById('group_msg_dropdown').classList.add('hidden');
    };

    window.replyToGroupMsg = function() {
        const messageKey = window._activeGroupMsgKey;
        if (!messageKey) return;

        // Retrieve message info directly from global messages if available
        // If not stored globally, we can extract from DOM, but global messages are usually maintained.
        // Assuming window.globalGroupMessages or similar exists. We'll extract from the DOM safely to be sure.
        const msgElement = document.getElementById(`msg_${messageKey}`);
        if (!msgElement) return;

        // We stored the senderName when opening the options
        const senderNameSpan = document.getElementById('group_dropdown_sender_name');
        let senderName = "Member";
        let isMe = false;

        const replyPriv = document.getElementById('group_dropdown_reply_priv');
        if (replyPriv.style.display === 'none') {
            isMe = true;
            senderName = "You";
        } else {
            senderName = senderNameSpan.textContent;
        }

        // Try to get message text
        let msgText = "Message";
        const textDiv = msgElement.querySelector('.break-words');
        if (textDiv) {
            msgText = textDiv.childNodes[0].textContent.trim(); // Get just the text, ignore the inline spacer
        } else if (msgElement.querySelector('img:not(.rounded-full)')) {
            msgText = "Photo";
        } else if (msgElement.querySelector('audio')) {
            msgText = "Audio";
        }

        const block = document.getElementById('group_replying_to_block');
        const nameSpan = document.getElementById('group_replying_to_name');

        nameSpan.textContent = senderName;
        document.getElementById('group_replying_to_text').textContent = msgText;

        if (isMe) {
            nameSpan.classList.remove('text-[#00a884]');
            nameSpan.classList.add('text-[#ea005e]');
            block.classList.remove('border-[#00a884]');
            block.classList.add('border-[#ea005e]');
        } else {
            nameSpan.classList.remove('text-[#ea005e]');
            nameSpan.classList.add('text-[#00a884]');
            block.classList.remove('border-[#ea005e]');
            block.classList.add('border-[#00a884]');
        }

        block.classList.remove('hidden');
        block.classList.add('flex');

        window.groupReplyingTo = messageKey;
        window.replyingToName = senderName;
        window.replyingToText = msgText;
        document.getElementById('group_msg_dropdown')?.classList.add('hidden');

        setTimeout(() => {
            document.getElementById('group_msg').focus();
        }, 100);
    };

    window.cancelGroupReply = function() {
        const block = document.getElementById('group_replying_to_block');
        block.classList.add('hidden');
        block.classList.remove('flex');
        window.groupReplyingTo = null;
    };


    // Handle Global overrides for Group context without touching index.blade.php
    (function() {
        const originalSendFromModal = window.sendFromModal;
        window.sendFromModal = async function() {
            if (window.currentChatId && window.currentChatId.startsWith('group_')) {
                const captionInput = document.getElementById('modal_caption');
                const fileInput = document.getElementById('file_input');
                const fileObj = fileInput.files[0];
                const msgText = captionInput ? captionInput.value.trim() : "";

                if (!fileObj && !msgText) return;

                const groupId = window.currentChatId.replace('group_', '');
                let msgData = {
                    sender_id: window.myUserId,
                    text: msgText,
                    time: Math.floor(Date.now() / 1000),
                    status: 'sent',
                    type: 'text',
                    total_members: window.currentGroupMembersCount || 1
                };

                if (window.groupReplyingTo) {
                    msgData.reply_to_id = window.groupReplyingTo;
                    msgData.reply_to_text = window.replyingToText;
                    msgData.reply_to_name = window.replyingToName;
                }

                document.getElementById('media_preview_modal').classList.add('hidden');

                if (fileObj) {
                    // Total Isolation: Handle file upload via JS SDK directly for groups
                    const storagePath = `uploads/groups/${groupId}/${Date.now()}_${fileObj.name}`;
                    const storageRef = window.sRef(window.storage, storagePath);
                    const uploadTask = window.uploadBytesResumable(storageRef, fileObj);

                    uploadTask.on('state_changed',
                        null,
                        (error) => { console.error("Upload error:", error); },
                        async () => {
                            const downloadURL = await window.getDownloadURL(uploadTask.snapshot.ref);
                            msgData.file_url = downloadURL;
                            msgData.file_name = fileObj.name;

                            const mimeType = fileObj.type;
                            if (mimeType.startsWith('image/')) msgData.type = 'image';
                            else if (mimeType.startsWith('video/')) msgData.type = 'video';
                            else if (mimeType.startsWith('audio/')) msgData.type = 'audio';
                            else msgData.type = 'document';

                            await window.push(window.ref(window.db, `groups/${groupId}/messages`), msgData);

                            // Send FCM Notification
                            fetch('/send-group-notification', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify({
                                    group_id: groupId,
                                    message: msgData.text || 'Media',
                                    type: msgData.type
                                })
                            }).catch(err => console.error('Notification error:', err));
                        }
                    );
                } else {
                    await window.push(window.ref(window.db, `groups/${groupId}/messages`), msgData);

                    // Send FCM Notification
                    fetch('/send-group-notification', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            group_id: groupId,
                            message: msgData.text,
                            type: 'text'
                        })
                    }).catch(err => console.error('Notification error:', err));
                }

                if (window.clearFile) window.clearFile();
                if (window.cancelGroupReply) window.cancelGroupReply();
                return;
            }
            if (typeof originalSendFromModal === 'function') originalSendFromModal();
        };
    })();

    window.confirmDeleteGroupSelected = function () {
        if (window.selectedGroupMessages.size === 0) return;
        if (confirm('Delete ' + window.selectedGroupMessages.size + ' message(s) from group?')) {
            window.selectedGroupMessages.forEach(key => {
                try {
                    window.remove(window.ref(window.db, 'groups/' + window.currentChatId.replace('group_', '') + '/messages/' + key)).catch(e => {
                        console.error('Delete error:', e);
                    });
                } catch (e) {
                    console.error('Ref error:', e);
                }
            });
            window.cancelGroupSelection();
        }
    };

    // --- GROUP LOGIC MOVED FROM INDEX ---

    // Listen to groups node
    setTimeout(() => {
        if (window.db && window.onValue) {
            window.onValue(window.ref(window.db, 'groups'), (snapshot) => {
                const groups = snapshot.val();
                if (groups) {
                    Object.values(groups).forEach(group => {
                        if (group && group.users && group.users.includes(window.myUserId)) {
                            window.renderGroupSidebarItem(group);
                        }
                    });
                }
            });
        }
    }, 2000); // Small delay to ensure index module has exposed window.db

    // Global registry for group message listeners to avoid duplicates
    window.groupMessageListeners = window.groupMessageListeners || {};

    window.listenForGroupUpdates = function(groupId) {
        if (window.groupMessageListeners[groupId]) return;

        const messagesRef = window.query(
            window.ref(window.db, `groups/${groupId}/messages`),
            window.limitToLast(1)
        );

        window.groupMessageListeners[groupId] = window.onChildAdded(messagesRef, (snapshot) => {
            const data = snapshot.val();
            if (!data) return;

            // Update Last Message Text
            const lastMsgEl = document.getElementById(`group_last_msg_${groupId}`);
            if (lastMsgEl) {
                let preview = data.text || "";
                if (data.type === 'image') preview = "📷 Image";
                else if (data.type === 'video') preview = "🎥 Video";
                else if (data.type === 'audio') preview = "🎵 Audio";
                else if (data.type === 'document') preview = "📄 Document";

                const prefix = (data.sender_id == window.myUserId) ? "✓ " : "";
                lastMsgEl.textContent = prefix + preview;
            }

            // Update Last Message Time
            const lastTimeEl = document.getElementById(`group_last_time_${groupId}`);
            if (lastTimeEl) {
                const msgDate = new Date(data.time * 1000);
                lastTimeEl.textContent = msgDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            }

            // Update Unread Badge
            const isActive = window.currentChatId === 'group_' + groupId;
            const isMe = data.sender_id == window.myUserId;

            if (!isActive && !isMe) {
                const badge = document.getElementById(`group_unread_badge_${groupId}`);
                if (badge) {
                    let count = parseInt(badge.textContent) || 0;
                    count++;
                    badge.textContent = count;
                    badge.classList.remove('hidden');
                    badge.classList.add('flex');
                }
            }
        });
    };

    window.renderGroupSidebarItem = function(group) {
        let item = document.getElementById(`group_sidebar_${group.id}`);
        if (!item) {
            item = document.createElement('div');
            item.id = `group_sidebar_${group.id}`;
            item.className = "flex items-center px-3 py-3 hover:bg-[#202c33] cursor-pointer transition-colors user-chat-item";
            item.onclick = function() {
                window.selectGroupChat(group.id, group.name, group.avatar);
            };

            item.innerHTML = `
                <div class="w-12 h-12 rounded-full overflow-hidden bg-[#2a3942] flex items-center justify-center shrink-0">
                    <img src="${group.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(group.name)}&background=2a3942&color=fff`}" class="w-full h-full object-cover">
                </div>
                <div class="ml-3 flex-1 border-b border-[#202c33] pb-3 pt-1 min-w-0">
                    <div class="flex justify-between items-center">
                        <h4 class="text-[17px] text-[#e9edef] truncate mr-2 font-normal">${group.name}</h4>
                        <span class="text-[12px] text-[#8696a0] whitespace-nowrap" id="group_last_time_${group.id}"></span>
                    </div>
                    <div class="flex justify-between items-center mt-0.5">
                        <p class="text-[14px] text-[#8696a0] truncate flex-1 min-w-0 leading-snug" id="group_last_msg_${group.id}">Group chat</p>
                        <span id="group_unread_badge_${group.id}" class="hidden bg-[#00a884] text-[#111b21] text-[12px] font-bold min-w-[20px] h-5 rounded-full flex items-center justify-center px-1.5 ml-2 shadow-sm shrink-0">0</span>
                    </div>
                </div>
            `;
            const container = document.getElementById('user_list_container');
            if (container) {
                container.appendChild(item);
            }
        } else {
            const h4 = item.querySelector('h4');
            const img = item.querySelector('img');
            if (h4) h4.textContent = group.name;
            if (img) img.src = group.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(group.name)}&background=2a3942&color=fff`;
        }

        // Attach message listener for real-time sidebar updates
        window.listenForGroupUpdates(group.id);
    };

    // Override showToast to handle group chat navigation
    (function() {
        const originalShowToast = window.showToast;
        window.showToast = function(title, body, otherUserId = null, otherName = null) {
            if (otherUserId && otherUserId.toString().startsWith('group_')) {
                const groupId = otherUserId.toString().replace('group_', '');
                const container = document.getElementById('toast_container');
                const id = Date.now();

                // For groups, we use selectGroupChat instead of selectChat
                const clickAttr = `onclick="window.selectGroupChat('${groupId}', '${otherName.replace(/'/g, "\\'")}', ''); this.remove();"`;

                const html = `
                    <div id="toast_${id}" ${clickAttr} class="toast-enter bg-white border border-gray-100 rounded-2xl shadow-2xl p-4 flex gap-4 w-full pointer-events-auto cursor-pointer hover:bg-gray-50 hover:scale-[1.02] active:scale-[0.98] transition-all border-l-4 border-l-green-500">
                        <div class="w-12 h-12 rounded-full bg-green-500/10 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-[15px] font-bold text-gray-900 truncate">${title}</div>
                            <div class="text-[13px] text-gray-500 mt-0.5 line-clamp-2">${body}</div>
                        </div>
                        <button onclick="event.stopPropagation(); this.parentElement.remove()" class="text-gray-400 hover:text-gray-600 focus:outline-none self-start">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>`;

                if (container) {
                    container.insertAdjacentHTML('afterbegin', html);
                    setTimeout(() => {
                        const t = document.getElementById('toast_' + id);
                        if (t) t.remove();
                    }, 5000);
                }
                return;
            }
            // Fallback to original for 1-to-1 chats
            if (typeof originalShowToast === 'function') {
                originalShowToast(title, body, otherUserId, otherName);
            }
        };
    })();

    window.selectGroupChat = function(groupId, name, avatar) {
        const msgInput = document.getElementById('group_msg') || document.getElementById('msg');
        if (msgInput) {
            msgInput.disabled = false;
            msgInput.placeholder = "Type a message";
        }

        window.get(window.ref(window.db, 'groups/' + groupId)).then((snapshot) => {
            const group = snapshot.val();

            // Listen for group metadata (pinned msgs, member count, etc)
            const groupRef = window.ref(window.db, 'groups/' + groupId);
            window.onValue(groupRef, (snap) => {
                const gData = snap.val();
                if (!gData) return;

                // Dynamic Member Count
                const memberCount = (gData.users) ? gData.users.length : 0;
                window.currentGroupMembersCount = memberCount;

                const subtitle = document.getElementById('active_group_chat_subtitle');
                if (subtitle) subtitle.textContent = memberCount + ' members';

                const infoCount = document.getElementById('group_members_count');
                if (infoCount) infoCount.textContent = memberCount + ' members';

                const infoPill = document.getElementById('group_info_member_count_pill');
                if (infoPill) infoPill.textContent = memberCount + ' members';

                const pinBar = document.getElementById('group_pinned_bar');
                const pinText = document.getElementById('group_pinned_text');
                if (gData.pinned_msg && pinBar && pinText) {
                    pinText.textContent = gData.pinned_msg.text;
                    pinBar.classList.remove('hidden');
                } else if (pinBar) {
                    pinBar.classList.add('hidden');
                }
            });

            if (group && group.permissions) {
                const canSend = group.permissions.sendMessages;
                const isAdmin = group.createdBy == window.myUserId;
                if (!canSend && !isAdmin) {
                    if (msgInput) {
                        msgInput.disabled = true;
                        msgInput.placeholder = "Only admins can send messages";
                    }
                }
            }

            // Populate users for calling list
            if (group && group.users && window.activeChatUser) {
                window.activeChatUser.users = group.users.map(uid => {
                    const contact = window.allContacts ? window.allContacts.find(c => c.id == uid) : null;
                    return {
                        id: uid,
                        name: contact ? (contact.name || contact.phone) : (uid == window.myUserId ? 'You' : 'Member'),
                        phone: contact ? contact.phone : '',
                        avatar: contact ? contact.avatar : ''
                    };
                });
            }

            // Mark existing messages as read
            if (window.globalMessages) {
                for (let key in window.globalMessages) {
                    const msg = window.globalMessages[key];
                    if (msg.sender_id != window.myUserId && (!msg.read_by || !msg.read_by[window.myUserId])) {
                        window.update(window.ref(window.db, `groups/${groupId}/messages/${key}/read_by`), {
                            [window.myUserId]: Math.floor(Date.now() / 1000)
                        });
                    }
                }
            }
        });

        const statusView = document.getElementById('status_view_container');
        if (statusView && !statusView.classList.contains('hidden')) {
            window.showChats();
        }

        const searchInput = document.getElementById('sidebar_search');
        window.activeSearchQuery = (searchInput && searchInput.value.trim().length > 0) ? searchInput.value.trim().toLowerCase() : null;
        window.activeSearchMsgTime = null;
        window._searchScrolled = false;

        document.getElementById('chat_empty_state')?.classList.add('hidden');

        // Reset states
        if (window.cancelSelection) window.cancelSelection();
        if (window.cancelGroupSelection) window.cancelGroupSelection();

        // Reset call selection
        if (window.selectedCallParticipants) window.selectedCallParticipants.clear();
        const list = document.getElementById('group_call_members_list');
        const footer = document.getElementById('group_call_collapsed_footer');
        const chevron = document.getElementById('group_call_chevron');
        if (list) list.classList.add('hidden');
        if (footer) footer.classList.remove('hidden');
        if (chevron) chevron.style.transform = 'rotate(0deg)';
        const dropdown = document.getElementById('group_call_dropdown');
        if (dropdown) {
            dropdown.classList.add('hidden');
            dropdown.style.display = 'none';
            dropdown.classList.remove('show');
        }

        document.getElementById('active_chat_content')?.classList.add('hidden');
        document.getElementById('active_chat_content')?.classList.remove('flex');

        const gContent = document.getElementById('active_group_chat_content');
        if (gContent) {
            gContent.classList.remove('hidden');
            gContent.classList.add('flex');
        }

        const panel = document.getElementById('settings_panel');
        if (panel && !panel.classList.contains('hidden')) {
            window.toggleSettings();
        }

        if (window.innerWidth < 640) {
            document.getElementById('user_sidebar_container').classList.add('hidden');
            document.getElementById('main_chat_column').classList.remove('hidden');
            document.getElementById('main_chat_column').classList.add('flex');
        }

        if (window.unsubscribeAdded) window.unsubscribeAdded();
        if (window.unsubscribeRemoved) window.unsubscribeRemoved();
        if (window.unsubscribeChanged) window.unsubscribeChanged();
        if (window.statusUnsubscribe) window.statusUnsubscribe();

        window.currentChatId = 'group_' + groupId;

        const activeName = name;
        window.activeChatName = activeName;

        // --- HIJACK SELECT CHAT ---
        // We override the original selectChat in group_chat.blade.php to ensure
        // that when a user is selected, we restore main_chat_column and hide group chat.
        if (!window._selectChatHijacked) {
            const originalSelectChat = window.selectChat;
            window.selectChat = function() {
                // Hide group chat content
                const gContent = document.getElementById('active_group_chat_content');
                if (gContent) {
                    gContent.classList.add('hidden');
                    gContent.classList.remove('flex');
                }
                // Call original function
                if (typeof originalSelectChat === 'function') {
                    originalSelectChat.apply(this, arguments);
                }
            };
            window._selectChatHijacked = true;
        }

        // Hijack backToSidebar for mobile navigation
        if (!window._backToSidebarHijacked) {
            const originalBackToSidebar = window.backToSidebar;
            window.backToSidebar = function() {
                const gContent = document.getElementById('active_group_chat_content');
                if (gContent) {
                    gContent.classList.add('hidden');
                    gContent.classList.remove('flex');
                }
                if (typeof originalBackToSidebar === 'function') {
                    originalBackToSidebar.apply(this, arguments);
                }
            };
            window._backToSidebarHijacked = true;
        }
        const activeAvatar = avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(activeName)}&background=202c33&color=fff`;
        window.activeChatAvatar = activeAvatar;

        window.activeChatUser = {
            id: groupId,
            name: activeName,
            phone: '',
            avatar: activeAvatar,
            about: 'Group chat',
            users: [] // Will be populated in the .then() of group fetch
        };

        if (document.getElementById('active_group_chat_title')) {
            document.getElementById('active_group_chat_title').textContent = activeName;
        }
        if (document.getElementById('active_group_chat_avatar')) {
            document.getElementById('active_group_chat_avatar').innerHTML = `<img src="${activeAvatar}" class="w-full h-full object-cover">`;
        }

        document.getElementById('active_chat_title').textContent = activeName;
        const subtitle = document.getElementById('active_chat_subtitle');
        if (subtitle) {
            subtitle.textContent = 'Group chat';
            subtitle.classList.remove('hidden', 'text-green-600');
            subtitle.classList.add('text-gray-500');
        }

        document.getElementById('active_chat_avatar').innerHTML = `<img src="${activeAvatar}" class="w-full h-full object-cover">`;

        document.getElementById('call_dropdown_name').textContent = activeName;
        document.getElementById('call_dropdown_avatar').innerHTML = `<img src="${activeAvatar}" class="w-full h-full object-cover">`;

        const badge = document.getElementById(`group_unread_badge_${groupId}`);
        if (badge) {
            badge.textContent = '0';
            badge.classList.add('hidden');
            badge.classList.remove('flex');
        }

        const gMsgs = document.getElementById('group_messages');
        if (gMsgs) gMsgs.innerHTML = '';
        window.globalMessages = {};

        const messagesRef = window.ref(window.db, 'groups/' + groupId + '/messages');
        let lastDateString = null;

        // Helper to determine group status
        const getMsgGroupStatus = (data) => {
            if (!data.read_by) return 'sent';
            const readCount = Object.keys(data.read_by).filter(uid => uid != data.sender_id).length;
            
            // For OLD messages (pre-change), if anyone read it, keep it blue (all_read)
            // This prevents old messages from turning grey when new members join.
            if (!data.total_members) {
                return (readCount > 0) ? 'all_read' : 'sent';
            }

            // For NEW messages, use the stored member count for accuracy
            const totalOthers = (data.total_members || 1) - 1;
            
            if (totalOthers <= 0) return (readCount > 0) ? 'all_read' : 'sent';
            if (readCount >= totalOthers) return 'all_read';
            if (readCount > 0) return 'read_by_some';
            return 'sent';
        };

        window.unsubscribeAdded = window.onChildAdded(messagesRef, (snapshot) => {
            const data = snapshot.val();
            const key = snapshot.key;
            window.globalMessages[key] = data;

            // Auto-read new messages
            if (data.sender_id != window.myUserId && (!data.read_by || !data.read_by[window.myUserId])) {
                window.update(window.ref(window.db, `groups/${groupId}/messages/${key}/read_by`), {
                    [window.myUserId]: Math.floor(Date.now() / 1000)
                });
            }

            const dateHeader = window.getDateHeader(data.time);
            if (dateHeader !== lastDateString) {
                lastDateString = dateHeader;
                const headerHtml = `
                    <div class="flex justify-center my-3 sticky top-0 z-[5]">
                        <div class="bg-[#182229]/90 backdrop-blur-sm text-[#8696a0] text-[11px] px-3 py-1 rounded-lg shadow-sm font-medium uppercase tracking-wider border border-[#202c33]">
                            ${dateHeader}
                        </div>
                    </div>`;
                const gMsgs = document.getElementById('group_messages');
                if (gMsgs) gMsgs.insertAdjacentHTML('beforeend', headerHtml);
            }

            const isMe = data.sender_id == window.myUserId;
            const time = new Date(data.time * 1000).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            let mediaContent = '';
            if (data.type === 'image' && data.file_url) {
                mediaContent = `<img src="${data.file_url}" class="max-w-[200px] sm:max-w-xs rounded-lg mb-2 object-cover cursor-pointer hover:opacity-90" onclick="window.open('${data.file_url}', '_blank')">`;
            } else if (data.type === 'video' && data.file_url) {
                mediaContent = `<video src="${data.file_url}" controls class="max-w-[200px] sm:max-w-xs rounded-lg mb-2"></video>`;
            } else if (data.type === 'audio' && data.file_url) {
                mediaContent = `<audio src="${data.file_url}" controls class="max-w-[200px] sm:max-w-xs mb-2"></audio>`;
            } else if (data.type === 'document' && data.file_url) {
                mediaContent = `
                    <div class="relative rounded-lg overflow-hidden border border-black/10 bg-black/5 mb-1 cursor-pointer hover:bg-black/10 transition-colors w-[260px] sm:w-[280px]" onclick="window.open('${data.file_url}', '_blank')">
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
                            <div class="w-10 h-10 rounded flex items-center justify-center shrink-0 text-[11px] font-bold text-white shadow-sm" style="background-color: ${window.getFileColor(data.file_name)}">
                                ${window.getFileExt(data.file_name)}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-[15px] font-medium text-gray-800 truncate leading-tight">${data.file_name || 'Document'}</div>
                                <div class="text-[12px] text-gray-500 mt-1 truncate">${window.getFileExt(data.file_name)} Document</div>
                            </div>
                        </div>
                    </div>`;
            }

            let replyPreviewHtml = '';
            if (data.reply_to_text) {
                let rSenderName = data.reply_to_name || "Member";
                let rIsMe = false;

                if (data.reply_to_id && window.globalMessages[data.reply_to_id]) {
                    const r = window.globalMessages[data.reply_to_id];
                    rIsMe = r.sender_id == window.myUserId;
                    if (rIsMe) {
                        rSenderName = "You";
                    } else if (window.allContacts) {
                        const matchUser = window.allContacts.find(c => c.id == r.sender_id);
                        if (matchUser) rSenderName = matchUser.name || matchUser.phone;
                    }
                }

                let nameColor = (rSenderName === "You" || rIsMe) ? 'text-[#ea005e]' : 'text-[#00a884]';
                let borderColor = (rSenderName === "You" || rIsMe) ? 'border-[#ea005e]' : 'border-[#00a884]';

                replyPreviewHtml = `
                    <div class="bg-black/5 border-l-4 ${borderColor} p-1.5 rounded mb-1 cursor-pointer select-none max-w-full" onclick="if(document.getElementById('msg_${data.reply_to_id}')){document.getElementById('msg_${data.reply_to_id}').scrollIntoView({behavior:'smooth'})}">
                        <div class="${nameColor} text-[12px] font-semibold">${rSenderName}</div>
                        <div class="text-[#e9edef] text-[13px] truncate">${data.reply_to_text}</div>
                    </div>`;
            }

            let msgText = data.text || '';
            if (data.type === 'call') {
                const isVoice = data.call_type === 'voice';
                const isMissed = data.call_status === 'missed' || data.call_status === 'rejected';
                const isNoAnswer = data.call_status === 'no_answer';
                const isCompleted = data.call_status === 'completed';

                let durationText = '';
                if (isCompleted && data.call_duration) {
                    const d = data.call_duration;
                    if (d >= 3600) durationText = Math.floor(d/3600) + ' hr ' + Math.floor((d%3600)/60) + ' min';
                    else if (d >= 60) durationText = Math.floor(d/60) + ' min';
                    else durationText = d + ' secs';
                } else if (isMissed) durationText = 'Missed';
                else if (isNoAnswer) durationText = 'No answer';

                const iconColor = isMissed ? '#ef4444' : (isMe ? '#00a884' : '#8696a0');
                const callIcon = isVoice
                    ? `<svg class="w-5 h-5" fill="${iconColor}" viewBox="0 0 24 24"><path d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z"/></svg>`
                    : `<svg class="w-5 h-5" fill="${iconColor}" viewBox="0 0 24 24"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>`;

                const callLabel = isVoice ? 'Voice call' : 'Video call';
                const callTitle = isMissed ? (isVoice ? 'Missed voice call' : 'Missed video call') : callLabel;

                const tapAction = isMissed && !isMe ? `onclick="event.stopPropagation(); ${isVoice ? 'window.startGroupVoiceCall()' : 'window.startGroupVideoCall()'}" style="cursor:pointer"` : '';

                mediaContent = `
                    <div class="flex items-center gap-3 py-1 min-w-[180px]" ${tapAction}>
                        <div class="w-9 h-9 rounded-full ${isMissed ? 'bg-red-100' : (isMe ? 'bg-[#d0f4e4]' : 'bg-gray-100')} flex items-center justify-center shrink-0">
                            ${callIcon}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-[14px] font-semibold ${isMissed ? 'text-[#ef4444]' : 'text-[#e9edef]'} leading-tight">${callTitle}</div>
                            <div class="flex items-center gap-1 mt-0.5">
                                <span class="text-[12px] ${isMissed ? 'text-red-400' : 'text-[#8696a0]'}">${durationText}</span>
                            </div>
                        </div>
                    </div>`;
            }

            if (window.activeSearchQuery && msgText.toLowerCase().includes(window.activeSearchQuery)) {
                const regex = new RegExp(`(${window.activeSearchQuery})`, 'gi');
                msgText = msgText.replace(regex, `<span class="search-highlight">$1</span>`);
            }

            let senderDisplayName = "Member";
            let senderAvatar = "";

            if (data.sender_id == window.myUserId) {
                senderDisplayName = "You";
            } else if (window.allContacts) {
                const matchUser = window.allContacts.find(c => c.id == data.sender_id);
                if (matchUser) {
                    senderDisplayName = matchUser.name || matchUser.phone || "Member";
                    senderAvatar = matchUser.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(senderDisplayName.charAt(0))}&background=2a3942&color=fff`;
                } else {
                    senderAvatar = `https://ui-avatars.com/api/?name=${encodeURIComponent(senderDisplayName.charAt(0))}&background=2a3942&color=fff`;
                }
            } else {
                senderAvatar = `https://ui-avatars.com/api/?name=${encodeURIComponent(senderDisplayName.charAt(0))}&background=2a3942&color=fff`;
            }

            const msgHtml = `
                <div id="msg_${key}" onclick="window.toggleGroupMsgSelection('${key}')" class="flex ${isMe ? 'justify-end' : 'justify-start'} mb-2 px-4 group/msg relative gap-2 items-start group/bubble-container cursor-default">
                    <!-- Selection Checkbox -->
                    <div class="msg-checkbox-container hidden shrink-0 self-center mr-2">
                        <div class="w-5 h-5 rounded border-2 border-gray-400 bg-white flex items-center justify-center transition-all">
                            <input type="checkbox" id="checkbox_${key}" class="msg-checkbox hidden">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>

                    ${!isMe ? `
                    <div class="w-8 h-8 rounded-full overflow-hidden shrink-0 mt-0.5 shadow-sm">
                        <img src="${senderAvatar}" class="w-full h-full object-cover">
                    </div>` : ''}

                    <div id="bubble_${key}" class="${isMe ? 'bg-[#005c4b]' : 'bg-[#202c33]'} rounded-lg px-2.5 py-1.5 max-w-[70%] sm:max-w-[65%] shadow-sm min-w-[100px] relative group/bubble">
                        <!-- Options Button (WhatsApp Style) -->
                        <div class="absolute top-0 right-0 opacity-0 group-hover/bubble-container:opacity-100 transition-opacity z-10 bg-gradient-to-l ${isMe ? 'from-[#005c4b] via-[#005c4b]' : 'from-[#202c33] via-[#202c33]'} to-transparent pl-3 pr-1 pt-1 rounded-tr-lg">
                            <button onclick="window.openGroupMessageOptions(event, '${key}', ${isMe}, '${encodeURIComponent(senderDisplayName)}', '${data.sender_id}')" class="text-[#8696a0] hover:text-[#e9edef] focus:outline-none transition-colors">
                                <svg viewBox="0 0 19 20" width="19" height="20" fill="currentColor">
                                    <path d="M3.8 6.7l5.7 5.7 5.7-5.7 1.6 1.6-7.3 7.2-7.3-7.2 1.6-1.6z"></path>
                                </svg>
                            </button>
                        </div>

                        ${!isMe ? `<div class="text-[#25d366] text-[12.5px] font-semibold mb-0.5 leading-tight pr-6">${senderDisplayName}</div>` : ''}

                        ${replyPreviewHtml}
                        ${mediaContent}

                        ${msgText ? `<div class="text-[14.2px] text-[#e9edef] leading-relaxed break-words pb-[2px]">${msgText}<span class="inline-block w-[74px] h-[1px]"></span></div>` : ''}

                        <div class="flex items-center justify-end gap-1 absolute bottom-1 right-2">
                            <span class="text-[11px] text-[#8696a0] select-none leading-none">${time}</span>
                            ${isMe ? `
                                <span id="status_icon_${key}" class="shrink-0 flex items-center justify-center leading-none">
                                    ${window.getGroupTickSVG(getMsgGroupStatus(data))}
                                </span>` : ''}
                        </div>
                    </div>
                </div>`;

            const gMsgs = document.getElementById('group_messages');
            if (gMsgs) {
                gMsgs.insertAdjacentHTML('beforeend', msgHtml);
                gMsgs.scrollTop = gMsgs.scrollHeight;
            }
        });

        window.unsubscribeChanged = window.onChildChanged(messagesRef, (snapshot) => {
            const data = snapshot.val();
            const key = snapshot.key;
            window.globalMessages[key] = data;

            const isMe = data.sender_id == window.myUserId;
            if (isMe) {
                const statusEl = document.getElementById('status_icon_' + key);
                if (statusEl) {
                    statusEl.innerHTML = window.getGroupTickSVG(getMsgGroupStatus(data));
                }
            }
        });

        // Tab Visibility for Group
        document.addEventListener("visibilitychange", () => {
            if (document.visibilityState === 'visible' && window.currentChatId && window.currentChatId.startsWith('group_')) {
                const gId = window.currentChatId.replace('group_', '');
                for (let key in window.globalMessages) {
                    let msg = window.globalMessages[key];
                    if (msg.sender_id != window.myUserId && (!msg.read_by || !msg.read_by[window.myUserId])) {
                        window.update(window.ref(window.db, `groups/${gId}/messages/${key}/read_by`), {
                            [window.myUserId]: Math.floor(Date.now() / 1000)
                        });
                    }
                }
            }
        });
    };
</script>
