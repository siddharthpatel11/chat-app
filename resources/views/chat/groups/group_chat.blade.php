<style>
    #group_call_dropdown.show {
        display: flex !important;
        opacity: 1 !important;
        transform: scale(1) !important;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #374045;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #4a555c;
    }
</style>
<div id="active_group_chat_content" class="hidden flex-row flex-1 h-full overflow-hidden select-none">
    <!-- Main Chat Column -->
    <div id="group_chat_main_column" class="flex-1 flex flex-col relative h-full min-w-0">
        <div class="h-16 bg-[#202c33] px-4 border-b border-[#313d45] shrink-0 shadow-sm z-[45] relative">
            <!-- Normal Header -->
            <div id="group_normal_header"
                class="flex items-center justify-between h-full w-full transition-all duration-300">
                <div class="flex items-center gap-3">
                    <button class="sm:hidden text-[#8696a0] hover:text-[#e9edef] transition-colors mr-1"
                        onclick="window.backToSidebar()">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                        </svg>
                    </button>
                    <div id="active_group_chat_avatar" onclick="window.handleGroupHeaderClick()"
                        class="w-10 h-10 rounded-full bg-[#2a3942] flex items-center justify-center text-gray-600 font-bold shadow-sm overflow-hidden transition-transform hover:scale-105 cursor-pointer shrink-0">
                        <svg class="w-6 h-6 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div onclick="window.handleGroupHeaderClick()"  
                        class="cursor-pointer min-w-0 flex flex-col justify-center">
                        <h2 id="active_group_chat_title"
                            class="text-[15.5px] font-semibold text-[#e9edef] leading-tight truncate">Select a group
                            chat
                        </h2>
                        <p id="active_group_chat_subtitle" class="text-xs text-[#8696a0] font-medium mt-0.5 truncate">
                            Group
                            chat</p>
                    </div>
                </div>

                <!-- Header Actions -->
                <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                    <!-- Call Button Dropdown -->
                    <div class="relative">
                        <button id="group_call_btn_pill"
                            class="hidden sm:flex items-center gap-2.5 bg-[#2a3942] hover:bg-[#384b57] text-[#e9edef] px-4 py-2 rounded-full cursor-pointer transition-all duration-200 border border-transparent hover:border-[#313d45] focus:outline-none shrink-0 group">
                            <div
                                class="flex items-center gap-2 border-r border-[#313d45] pr-2 group-hover:border-[#8696a0]">
                                <svg class="w-5 h-5 text-[#8696a0] group-hover:text-[#e9edef]" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="text-sm font-semibold">Call</span>
                            </div>
                            <svg class="w-4 h-4 text-[#8696a0] group-hover:text-[#e9edef]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>

                        <!-- Call Dropdown -->
                        <div id="group_call_dropdown" style="display: none;"
                            class="hidden absolute top-full mt-2 right-0 w-[340px] bg-[#111b21] rounded-2xl shadow-2xl z-[100] flex flex-col border border-white/5 overflow-hidden transition-all duration-200 transform origin-top-right scale-95 opacity-0">
                            <!-- Header with Expand/Collapse -->
                            <div class="p-4 cursor-pointer hover:bg-white/5 transition-colors flex items-center justify-between"
                                onclick="window.toggleGroupCallMembersList()">
                                <div class="flex items-center gap-3">
                                    <div id="group_call_dropdown_avatar"
                                        class="w-10 h-10 rounded-full overflow-hidden bg-[#2a3942] shrink-0">
                                        <img src="https://ui-avatars.com/api/?name=Group&background=2a3942&color=fff"
                                            class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <span id="group_call_dropdown_name"
                                            class="text-[#e9edef] font-medium text-[16px] truncate">Group</span>
                                        <span class="text-[#8696a0] text-xs">Select people</span>
                                    </div>
                                </div>
                                <svg id="group_call_chevron"
                                    class="w-5 h-5 text-[#8696a0] transition-transform duration-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>

                            <!-- Members List (Hidden by default, shown when expanded) -->
                            <div id="group_call_members_list"
                                class="hidden flex flex-col border-t border-white/5 overflow-hidden">
                                <div class="px-4 py-2 bg-white/5">
                                    <span
                                        class="text-[12px] text-[#8696a0] font-semibold uppercase tracking-wider">Members</span>
                                </div>
                                <div id="group_call_members_container"
                                    class="flex-1 max-h-[280px] overflow-y-auto custom-scrollbar">
                                    <!-- Members rendered here -->
                                </div>

                                <!-- Voice/Video buttons inside the list -->
                                <div class="p-4 flex gap-3 border-t border-white/5 bg-[#111b21]">
                                    <button onclick="window.startGroupVoiceCall(true)"
                                        class="flex-1 bg-[#2a3942] hover:bg-[#384b57] text-[#e9edef] py-2.5 rounded-full flex items-center justify-center gap-2 font-semibold transition-all active:scale-95">
                                        <svg class="w-5 h-5 text-[#8696a0]" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z">
                                            </path>
                                        </svg>
                                        Voice
                                    </button>
                                    <button onclick="window.startGroupVideoCall(true)"
                                        class="flex-1 bg-[#2a3942] hover:bg-[#384b57] text-[#e9edef] py-2.5 rounded-full flex items-center justify-center gap-2 font-semibold transition-all active:scale-95">
                                        <svg class="w-5 h-5 text-[#8696a0]" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z">
                                            </path>
                                        </svg>
                                        Video
                                    </button>
                                </div>
                            </div>

                            <!-- Collapsed Footer Actions -->
                            <div id="group_call_collapsed_footer" class="p-4 flex flex-col gap-3">
                                <div class="flex gap-3">
                                    <button onclick="window.startGroupVoiceCall(false)"
                                        class="flex-1 bg-[#00a884] hover:bg-[#06cf9c] text-[#111b21] py-3 rounded-full flex items-center justify-center gap-2 font-bold transition-all active:scale-[0.98]">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z">
                                            </path>
                                        </svg>
                                        Voice Call
                                    </button>
                                    <button onclick="window.startGroupVideoCall(false)"
                                        class="flex-1 bg-[#00a884] hover:bg-[#06cf9c] text-[#111b21] py-3 rounded-full flex items-center justify-center gap-2 font-bold transition-all active:scale-[0.98]">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z">
                                            </path>
                                        </svg>
                                        Video Call
                                    </button>
                                </div>
                                <div class="h-[1px] bg-white/5 my-1"></div>
                                <button onclick="window.openNewCallLinkModal()"
                                    class="w-full flex items-center gap-3 px-2 py-2 text-[#e9edef] hover:bg-white/5 rounded-lg transition-colors text-sm">
                                    <div
                                        class="w-8 h-8 rounded-full bg-[#202c33] flex items-center justify-center text-[#8696a0]">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.826a4 4 0 015.656 0l4 4a4 4 0 01-5.656 5.656l-1.103-1.103">
                                            </path>
                                        </svg>
                                    </div>
                                    Send call link
                                </button>
                                <button onclick="window.openScheduleCallModal()"
                                    class="w-full flex items-center gap-3 px-2 py-2 text-[#e9edef] hover:bg-white/5 rounded-lg transition-colors text-sm">
                                    <div
                                        class="w-8 h-8 rounded-full bg-[#202c33] flex items-center justify-center text-[#8696a0]">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    Schedule call
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Search Icon -->
                    <button onclick="toggleGroupSearchDrawer()"
                        class="p-2.5 text-[#8696a0] hover:text-[#e9edef] hover:bg-[#2a3942] rounded-full transition-all duration-200 focus:outline-none"
                        title="Search">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>

                    <!-- Community Icon -->
                    <button id="group_community_btn" onclick="window.currentGroupData && window.currentGroupData.community_id && window.openCommunityGroupsDrawer(window.currentGroupData.community_id)"
                        class="hidden p-2 text-[#8696a0] hover:bg-[#2a3942] rounded-full transition-all duration-200 focus:outline-none"
                        title="Community Groups">
                        <div class="relative w-7 h-7 bg-[#3a2c26] rounded-xl flex items-center justify-center">
                            <svg class="w-4 h-4 text-[#eaa180]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12.75c1.63 0 3.07.39 4.24.9 1.08.48 1.76 1.56 1.76 2.73V18H6v-1.62c0-1.17.68-2.25 1.76-2.73 1.17-.51 2.61-.9 4.24-.9zM12 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zM18.8 11.23c-1.28 0-2.42-.45-3.32-1.2a4.4 4.4 0 0 0 .52-2.03c0-.75-.19-1.46-.52-2.03.9-.75 2.04-1.2 3.32-1.2 2.08 0 3.8 1.71 3.8 3.8s-1.72 3.8-3.8 3.8zM5.2 11.23C3.12 11.23 1.4 9.52 1.4 7.44s1.72-3.8 3.8-3.8c1.28 0 2.42.45 3.32 1.2-.33.57-.52 1.28-.52 2.03 0 .75.19 1.46.52 2.03-.9.75-2.04 1.2-3.32 1.2z"/>
                            </svg>
                            <div class="absolute -bottom-1 -right-1 w-[18px] h-[18px] bg-[#f0f2f5] rounded-full flex items-center justify-center border-2 border-[#202c33]">
                                <svg class="w-2.5 h-2.5 text-[#111b21] mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </button>

                    <!-- Menu Icon -->
                    <button id="group_header_more_btn" onclick="toggleGroupHeaderMoreMenu(event)"
                        class="p-2.5 text-[#8696a0] hover:text-[#e9edef] hover:bg-[#2a3942] rounded-full transition-all duration-200 focus:outline-none"
                        title="Menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Selection Header (Corrected Nesting: Sibling to Normal Header) -->
            <div id="group_selection_header"
                class="hidden absolute inset-0 bg-teal-600 items-center justify-between px-4 h-full w-full transition-all duration-300 z-30">
                <div class="flex items-center gap-4">
                    <button onclick="cancelGroupSelection()"
                        class="text-white hover:bg-black/10 p-2 rounded-full transition-colors focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                    <span id="group_selection_count" class="text-white font-semibold text-lg">1 Selected</span>
                </div>
                <div class="flex items-center">
                    <button onclick="confirmDeleteGroupSelected()"
                        class="text-white hover:bg-black/10 p-2 rounded-full transition-colors focus:outline-none"
                        title="Delete">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Pinned Messages Bar (Hidden by default, supports multiple) -->
        <div id="group_pinned_bar" onclick="window.scrollToCurrentGroupPin && window.scrollToCurrentGroupPin()"
            class="hidden bg-[#2a3942]/90 backdrop-blur-sm px-4 py-2 flex items-center justify-between border-b border-white/5 cursor-pointer hover:bg-[#384b57] transition-colors z-[15] w-full max-w-full min-w-0 overflow-hidden">
            <div class="flex items-center gap-3 overflow-hidden min-w-0 flex-1">
                <div class="text-[#00a884] shrink-0">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                        <path
                            d="M16 9V4l1 0c.55 0 1-.45 1-1s-.45-1-1-1H7c-.55 0-1 .45-1 1s.45 1 1 1l1 0v5c0 1.66-1.34 3-3 3v2h5.97v7l1 1 1-1v-7H19v-2c-1.66 0-3-1.34-3-3z">
                        </path>
                    </svg>
                </div>
                <div class="flex flex-col min-w-0 flex-1">
                    <span id="group_pinned_count" class="text-[#00a884] text-[13px] font-semibold">1 pinned
                        message</span>
                    <span id="group_pinned_text" class="text-[#8696a0] text-sm truncate block w-full">Message text
                        goes
                        here...</span>
                </div>
            </div>
            <div class="flex items-center gap-1 shrink-0">
                <button onclick="event.stopPropagation(); window.navigateGroupPin && window.navigateGroupPin(-1)"
                    class="text-[#8696a0] hover:text-[#e9edef] p-1 rounded-full hover:bg-white/5 transition-colors"
                    title="Previous pin">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                        <path d="M7.41 15.41L12 10.83l4.59 4.58L18 14l-6-6-6 6z"></path>
                    </svg>
                </button>
                <button onclick="event.stopPropagation(); window.navigateGroupPin && window.navigateGroupPin(1)"
                    class="text-[#8696a0] hover:text-[#e9edef] p-1 rounded-full hover:bg-white/5 transition-colors"
                    title="Next pin">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                        <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6z"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Group Message List -->
        <div id="group_messages" class="flex-1 overflow-y-auto p-4 chat-bg space-y-1 scroll-smooth bg-[#0b141a]">
        </div>


        <!-- Footer with Emoji, Attachment, Reply and Input -->
        <div class="h-auto min-h-[64px] bg-[#202c33] px-4 py-2 flex flex-col justify-end shrink-0 relative z-20">

            <!-- Replying Block (Moved outside the flex row to be on top) -->
            <div id="group_replying_to_block"
                class="hidden bg-[#2a3942] backdrop-blur-sm border-l-4 border-[#00a884] px-4 py-2 mb-2 rounded-xl shadow-sm flex justify-between items-center group cursor-pointer transition-all">
                <div class="flex flex-col overflow-hidden">
                    <span id="group_replying_to_name" class="font-semibold text-[#00a884] text-[13px] mb-0.5">Replying
                        to
                        message</span>
                    <span id="group_replying_to_text"
                        class="text-[#8696a0] text-sm truncate max-w-[200px] sm:max-w-md"></span>
                </div>
                <button onclick="cancelGroupReply()"
                    class="text-[#8696a0] hover:text-red-500 p-1.5 rounded-full hover:bg-black/10 focus:outline-none transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <!-- Group Editing Block -->
            <div id="group_editing_to_block"
                class="hidden bg-[#2a3942] backdrop-blur-sm border-l-4 border-[#00a884] px-4 py-2 mb-2 rounded-xl shadow-sm flex justify-between items-center group cursor-pointer transition-all">
                <div class="flex flex-col overflow-hidden">
                    <span class="font-semibold text-[#00a884] text-[13px] mb-0.5">Edit message</span>
                    <span id="group_editing_to_text"
                        class="text-[#8696a0] text-sm truncate max-w-[200px] sm:max-w-md"></span>
                </div>
                <button onclick="window.cancelGroupEdit()"
                    class="text-[#8696a0] hover:text-red-500 p-1.5 rounded-full hover:bg-black/10 focus:outline-none transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <div id="group_normal_input_container" class="flex items-center gap-2 w-full relative">
                <!-- Emoji Picker Button -->
                <button type="button" id="group_emoji_toggle_btn" onclick="toggleGroupEmojiPicker()"
                    class="text-[#8696a0] hover:text-[#e9edef] p-2 focus:outline-none shrink-0 transition-colors">
                    <svg viewBox="0 0 24 24" width="26" height="26" fill="currentColor">
                        <path
                            d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm2.5-9.5c.828 0 1.5-.672 1.5-1.5s-.672-1.5-1.5-1.5-1.5.672-1.5 1.5.672 1.5 1.5 1.5zm-5 0c.828 0 1.5-.672 1.5-1.5S8.828 8 8 8s-1.5.672-1.5 1.5.672 1.5 1.5 1.5zm2.5 6c2.511 0 4.67-1.516 5.568-3.693h-11.136c.898 2.177 3.057 3.693 5.568 3.693z">
                        </path>
                    </svg>
                </button>

                <!-- Hidden File Input for Group Media -->
                <input type="file" id="group_file_input" class="hidden"
                    onchange="window.handleGroupFileChange(this)">

                <!-- Attachment Trigger -->
                <div class="relative shrink-0">
                    <button type="button" id="group_attach_toggle_btn" onclick="window.toggleGroupAttachMenu()"
                        class="text-gray-500 hover:text-gray-300 p-2 focus:outline-none transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                            </path>
                        </svg>
                    </button>

                    <!-- Attachment Menu -->
                    <div id="group_attach_menu"
                        class="hidden absolute bottom-full mb-3 left-0 sm:left-4 bg-[#1f2c34] p-4 rounded-3xl w-[320px] shadow-2xl z-50 transition-all origin-bottom-left">
                        <div class="grid grid-cols-4 gap-y-6 gap-x-2 place-items-center">
                            <div class="flex flex-col items-center gap-1 group cursor-pointer"
                                onclick="window.selectGroupFile('.pdf,.doc,.docx,.xls,.xlsx,.txt,.zip')">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-[#5f66cd] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-300 text-xs">Document</span>
                            </div>
                            <div class="flex flex-col items-center gap-1 group cursor-pointer"
                                onclick="window.selectGroupFile('image/*;capture=camera')">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-[#ed517b] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9zm12 4a3 3 0 11-6 0 3 3 0 016 0z">
                                        </path>
                                    </svg>
                                </div>
                                <span class="text-gray-300 text-xs">Camera</span>
                            </div>
                            <div class="flex flex-col items-center gap-1 group cursor-pointer"
                                onclick="window.selectGroupFile('image/*,video/*')">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-[#bf59cf] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-300 text-xs">Gallery</span>
                            </div>
                            <div class="flex flex-col items-center gap-1 group cursor-pointer"
                                onclick="window.selectGroupFile('audio/*')">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-[#e35920] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-300 text-xs">Audio</span>
                            </div>
                            <div class="flex flex-col items-center gap-1 group cursor-pointer"
                                onclick="shareGroupLocation()">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-[#1dae75] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-300 text-xs">Location</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Emoji Picker Panel (Toggled with button) -->
                <div id="group_emoji_picker_container"
                    class="hidden absolute bottom-full mb-3 left-0 sm:left-4 z-50 shadow-2xl origin-bottom-left rounded-[16px] overflow-hidden flex flex-col bg-white dark:bg-[#202c33] border border-gray-200 dark:border-gray-700 w-[320px] sm:w-[350px]">
                    <!-- The actual picker (Uses system dark/light mode automatically) -->
                    <emoji-picker id="group_emoji_picker" class="w-full"
                        style="--num-columns: 8; --emoji-size: 1.5rem; --indicator-color: #00a884; height: 320px; border: none;"></emoji-picker>

                    <!-- Bottom Tabs Bar (WhatsApp Style) -->
                    <div
                        class="h-[50px] bg-gray-100 dark:bg-[#2a3942] border-t border-gray-200 dark:border-gray-700 flex items-center justify-center shrink-0">
                        <!-- Emoji Tab (Active) -->
                        <button
                            class="flex-1 flex justify-center py-2 h-full items-center relative transition-colors bg-gray-200 dark:bg-[#384b57]">
                            <svg viewBox="0 0 24 24" width="24" height="24"
                                class="text-gray-600 dark:text-gray-300" fill="currentColor">
                                <path
                                    d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm2.5-9.5c.828 0 1.5-.672 1.5-1.5s-.672-1.5-1.5-1.5-1.5.672-1.5 1.5.672 1.5 1.5 1.5zm-5 0c.828 0 1.5-.672 1.5-1.5S8.828 8 8 8s-1.5.672-1.5 1.5.672 1.5 1.5 1.5zm2.5 6c2.511 0 4.67-1.516 5.568-3.693h-11.136c.898 2.177 3.057 3.693 5.568 3.693z">
                                </path>
                            </svg>
                            <div class="absolute bottom-0 left-0 w-full h-[3px] bg-[#00a884]"></div>
                        </button>
                        <!-- GIF Tab -->
                        <button
                            class="flex-1 flex justify-center py-2 h-full items-center hover:bg-gray-200 dark:hover:bg-[#384b57] transition-colors">
                            <span class="font-bold text-gray-500 dark:text-gray-400 text-[15px]">GIF</span>
                        </button>
                        <!-- Sticker Tab -->
                        <button
                            class="flex-1 flex justify-center py-2 h-full items-center hover:bg-gray-200 dark:hover:bg-[#384b57] transition-colors">
                            <svg viewBox="0 0 24 24" width="24" height="24"
                                class="text-gray-500 dark:text-gray-400" fill="currentColor">
                                <path
                                    d="M14.5 3h-5C6.46 3 4 5.46 4 8.5v7C4 18.54 6.46 21 9.5 21h4l6-6v-6.5C19.5 5.46 17.04 3 14.5 3zm-2.5 16h-2.5C7.57 19 6 17.43 6 15.5v-7C6 6.57 7.57 5 9.5 5h5C16.43 5 18 6.57 18 8.5v5.09l-4.5 4.5V19h-1.5zM17 14h-2.5c-.83 0-1.5.67-1.5 1.5V18l4-4z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Input Area Container -->
                <div id="group_input_area_container"
                    class="flex-1 relative flex items-center bg-[#2a3942] rounded-xl shadow-sm overflow-hidden">
                    <!-- State 1: Normal Text Input -->
                    <div id="group_text_input_state" class="w-full relative flex items-center">
                        <textarea id="group_msg"
                            oninput="handleGroupInputToggle(); if(typeof autoResizeTextarea === 'function') autoResizeTextarea(this)"
                            onkeydown="handleGroupKeyPress(event)" placeholder="Type a message" rows="1"
                            class="w-full bg-transparent border-none pl-4 pr-10 py-2.5 text-[15px] focus:ring-0 text-[#d1d7db] placeholder-[#8696a0] min-h-[44px] max-h-32 resize-none overflow-y-auto custom-scrollbar leading-normal focus:outline-none"></textarea>
                        <!-- Inside Voice to Text Mic Button -->
                        <button type="button" id="group_inside_mic_btn" onclick="toggleGroupVoiceRecord()"
                            class="absolute right-3 text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                                <path
                                    d="M11.999 14.942c2.001 0 3.531-1.53 3.531-3.531V4.35c0-2.001-1.53-3.531-3.531-3.531S8.469 2.35 8.469 4.35v7.061c0 2.001 1.53 3.531 3.53 3.531zm6.238-3.53c0 3.531-2.942 6.002-6.237 6.002s-6.237-2.471-6.237-6.002H3.761c0 4.001 3.178 7.297 7.061 7.885v3.884h2.354v-3.884c3.884-.588 7.061-3.884 7.061-7.885h-2.002z">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <!-- State 2: Voice Note Recording UI -->
                    <div id="group_audio_recording_state"
                        class="hidden w-full items-center justify-between px-3 h-[42px] bg-white">
                        <button type="button" onclick="cancelGroupVoiceNote()"
                            class="text-gray-500 hover:text-red-500 focus:outline-none transition-colors">
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                                <path
                                    d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zm2.46-7.12l1.41-1.41L12 12.59l2.12-2.12 1.41 1.41L13.41 14l2.12 2.12-1.41 1.41L12 15.41l-2.12 2.12-1.41-1.41L10.59 14l-2.13-2.12zM15.5 4l-1-1h-5l-1 1H5v2h14V4z">
                                </path>
                            </svg>
                        </button>
                        <div class="flex items-center gap-2">
                            <div class="w-2.5 h-2.5 bg-red-500 rounded-full animate-pulse"></div>
                            <span id="group_audio_timer" class="text-[15px] font-medium text-gray-700">0:00</span>
                        </div>
                        <div class="flex-1 mx-3 flex items-center h-full overflow-hidden">
                            <!-- Waveform animation effect -->
                            <div class="flex items-center gap-[3px] h-4 w-full opacity-60 justify-end overflow-hidden">
                                <div class="w-1 bg-gray-400 rounded-full h-2 animate-[pulse_1s_ease-in-out_infinite]">
                                </div>
                                <div
                                    class="w-1 bg-gray-400 rounded-full h-4 animate-[pulse_1.2s_ease-in-out_infinite_0.2s]">
                                </div>
                                <div
                                    class="w-1 bg-gray-400 rounded-full h-3 animate-[pulse_0.8s_ease-in-out_infinite_0.4s]">
                                </div>
                                <div
                                    class="w-1 bg-gray-400 rounded-full h-5 animate-[pulse_1.1s_ease-in-out_infinite_0.1s]">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button id="group_action_btn" onclick="handleGroupActionBtn()"
                    class="bg-[#00a884] hover:bg-[#008f6f] text-white rounded-full w-11 h-11 flex items-center justify-center shadow-sm shrink-0 transition-colors focus:outline-none">
                    <svg id="group_mic_icon" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path
                            d="M11.999 14.942c2.001 0 3.531-1.53 3.531-3.531V4.35c0-2.001-1.53-3.531-3.531-3.531S8.469 2.35 8.469 4.35v7.061c0 2.001 1.53 3.531 3.53 3.531zm6.238-3.53c0 3.531-2.942 6.002-6.237 6.002s-6.237-2.471-6.237-6.002H3.761c0 4.001 3.178 7.297 7.061 7.885v3.884h2.354v-3.884c3.884-.588 7.061-3.884 7.061-7.885h-2.002z">
                        </path>
                    </svg>
                    <svg id="group_send_icon" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"
                        class="hidden ml-1">
                        <path d="M1.101 21.757L23.8 12.028 1.101 2.3l.011 7.912 13.623 1.816-13.623 1.817-.011 7.912z">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Group Bottom Selection Bar -->
            <div id="group_selection_bottom_bar"
                class="hidden flex items-center justify-between w-full h-[52px] bg-[#202c33] px-4 py-2 text-[#e9edef] z-20">
                <div class="flex items-center gap-4">
                    <button onclick="window.cancelGroupForwardSelection()"
                        class="text-[#8696a0] hover:text-[#e9edef] p-2 rounded-full focus:outline-none transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <span id="group_selection_bottom_count" class="font-semibold text-base">0 Selected</span>
                </div>
                <button onclick="window.openForwardModal(true)"
                    class="bg-[#00a884] hover:bg-[#008f72] text-white p-2.5 rounded-full shadow-lg transition-transform focus:outline-none hover:scale-105 active:scale-95"
                    title="Forward message">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path
                            d="M12.072 1.061a1 1 0 0 0-1.414 1.414L18.586 10.5H3a1 1 0 1 0 0 2h15.586l-7.928 8.025a1 1 0 1 0 1.414 1.414l9.643-9.761a1 1 0 0 0 0-1.414L12.072 1.061z">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

    </div> <!-- Close group_chat_main_column -->
    <!-- Group Search Drawer (Hidden by default) -->
    <div id="group_search_drawer"
        class="hidden w-[360px] h-full bg-[#111b21] border-l border-[#313d45] flex flex-col shrink-0">
        <!-- Search Header -->
        <div class="h-16 bg-[#202c33] px-4 flex items-center justify-between shrink-0 border-b border-[#313d45]">
            <div class="flex items-center gap-3 min-w-0">
                <button onclick="toggleGroupSearchDrawer()"
                    class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <span class="text-[#e9edef] font-medium text-[16px]">Search Messages</span>
            </div>
        </div>

        <!-- Search Input Field -->
        <div class="p-3 bg-[#111b21] border-b border-[#313d45]">
            <div
                class="bg-[#202c33] flex items-center gap-2 px-3 py-2 rounded-lg border border-transparent focus-within:border-[#00a884]">
                <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" id="group_search_input" oninput="searchGroupMessages()"
                    placeholder="Search messages..."
                    class="w-full bg-transparent border-none text-[#e9edef] text-sm focus:ring-0 placeholder-gray-500">
            </div>
        </div>

        <!-- Search Results List -->
        <div id="group_search_results" class="flex-1 overflow-y-auto p-3 space-y-2 select-none">
            <div class="text-[#8696a0] text-center text-sm py-4">Type to search messages in group</div>
        </div>
    </div>

    <!-- Group Information Sidebar Drawer -->
    <!-- Group Information Sidebar Drawer -->
    <div id="group_info_panel"
        class="hidden w-[400px] h-full bg-[#111b21] border-l border-[#313d45] flex flex-col shrink-0 z-40 select-none">
        <!-- Header -->
        <div class="h-16 bg-[#111b21] px-4 flex items-center gap-6 shrink-0 z-10">
            <button onclick="closeGroupInfoPanel()"
                class="text-[#aebac1] hover:text-[#e9edef] transition-colors focus:outline-none">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path
                        d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z">
                    </path>
                </svg>
            </button>
            <span class="text-[#e9edef] text-[16px] font-medium">Group info</span>
        </div>

        <div
            class="flex-1 overflow-y-auto [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-thumb]:bg-[#374248] [&::-webkit-scrollbar-track]:bg-transparent pb-10">
            <!-- Avatar & Title Section -->
            <div class="pt-6 pb-4 flex flex-col items-center px-4 shrink-0">
                <div id="group_info_avatar_container"
                    class="w-[200px] h-[200px] rounded-full overflow-hidden mb-4 shadow-lg bg-[#2a3942] flex items-center justify-center cursor-pointer">
                    <img src="https://ui-avatars.com/api/?name=Group&background=2a3942&color=fff"
                        id="group_info_avatar" class="w-full h-full object-cover">
                </div>

                <div id="group_info_name_container"
                    class="flex items-center gap-3 mb-1 w-full justify-center px-4 group">
                    <h2 class="text-[#e9edef] text-[24px] font-normal truncate text-center" id="group_info_name">
                        Group Name</h2>
                    <button onclick="window.startEditGroupName()"
                        class="text-[#8696a0] hover:text-[#e9edef] transition-colors flex-shrink-0 opacity-0 group-hover:opacity-100 focus:opacity-100 focus:outline-none"
                        title="Edit group subject">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                            <path
                                d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z">
                            </path>
                        </svg>
                    </button>
                </div>

                <div id="group_info_name_edit_container"
                    class="hidden items-center gap-2 mb-1 w-full justify-center px-4">
                    <input type="text" id="group_info_name_input"
                        class="bg-transparent border-b-2 border-[#00a884] text-[#e9edef] text-[24px] font-normal w-full focus:outline-none focus:ring-0 pb-1"
                        maxlength="50">
                    <div class="flex items-center gap-1.5 shrink-0">
                        <button onclick="window.saveGroupName()"
                            class="text-[#00a884] hover:text-[#00bfa5] p-1.5 focus:outline-none transition-colors">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"></path>
                            </svg>
                        </button>
                        <button onclick="window.cancelEditGroupName()"
                            class="text-[#f15c6d] hover:text-[#ff7b8b] p-1.5 focus:outline-none transition-colors">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                <path
                                    d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
                <span class="text-[#8696a0] text-[15px] mb-6">Group · <span id="group_info_member_count_pill"
                        class="text-[#00a884]">... members</span></span>

                <!-- Action Buttons Row -->
                <div class="flex justify-center gap-3 w-full mb-6 px-4">
                    <button
                        class="flex-1 flex flex-col items-center justify-center py-3.5 rounded-2xl border border-[#313d45] hover:bg-[#202c33] transition-colors gap-2"
                        onclick="window.startGroupVoiceCall(false)">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"
                            class="text-[#00a884]">
                            <path
                                d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z">
                            </path>
                        </svg>
                        <span class="text-[#e9edef] text-[14px]">Voice</span>
                    </button>
                    <button
                        class="flex-1 flex flex-col items-center justify-center py-3.5 rounded-2xl border border-[#313d45] hover:bg-[#202c33] transition-colors gap-2"
                        onclick="window.startGroupVideoCall(false)">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"
                            class="text-[#00a884]">
                            <path
                                d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z">
                            </path>
                        </svg>
                        <span class="text-[#e9edef] text-[14px]">Video</span>
                    </button>
                    <button
                        class="flex-1 flex flex-col items-center justify-center py-3.5 rounded-2xl border border-[#313d45] hover:bg-[#202c33] transition-colors gap-2"
                        onclick="window.openAddGroupMembersModal()">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"
                            class="text-[#00a884]">
                            <path
                                d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z">
                            </path>
                        </svg>
                        <span class="text-[#e9edef] text-[14px]">Add</span>
                    </button>
                    <button
                        class="flex-1 flex flex-col items-center justify-center py-3.5 rounded-2xl border border-[#313d45] hover:bg-[#202c33] transition-colors gap-2"
                        onclick="window.toggleGroupSearchDrawer()">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"
                            class="text-[#00a884]">
                            <path
                                d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z">
                            </path>
                        </svg>
                        <span class="text-[#e9edef] text-[14px]">Search</span>
                    </button>
                </div>
            </div>

            <!-- Group Description -->
            <div class="px-6 mb-5 group/desc">
                <div id="group_info_description_container" class="flex items-start justify-between gap-2">
                    <div class="flex-1 min-w-0">
                        <p id="group_info_description"
                            class="text-[#00a884] text-[15px] cursor-pointer hover:underline break-words"
                            onclick="window.startEditGroupDescription()">Add group description</p>
                    </div>
                    <button onclick="window.startEditGroupDescription()"
                        class="text-[#8696a0] hover:text-[#e9edef] opacity-0 group-hover/desc:opacity-100 transition-opacity flex-shrink-0"
                        title="Edit description">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                            <path
                                d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z">
                            </path>
                        </svg>
                    </button>
                </div>
                <div id="group_info_description_edit_container" class="hidden flex-col gap-2">
                    <textarea id="group_info_description_input"
                        class="bg-transparent border-b-2 border-[#00a884] text-[#e9edef] text-[15px] w-full focus:outline-none focus:ring-0 pb-1 resize-none overflow-hidden"
                        rows="1" placeholder="Add group description" maxlength="500"
                        oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"></textarea>
                    <div class="flex justify-end gap-2">
                        <button onclick="window.cancelEditGroupDescription()"
                            class="text-[#f15c6d] hover:text-[#ff7b8b] p-1.5 focus:outline-none transition-colors"
                            title="Cancel">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                <path
                                    d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z">
                                </path>
                            </svg>
                        </button>
                        <button onclick="window.saveGroupDescription()"
                            class="text-[#00a884] hover:text-[#00bfa5] p-1.5 focus:outline-none transition-colors"
                            title="Save">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Group Created Info -->
            <div class="px-6 mb-5">
                <p id="group_info_created_at" class="text-[#8696a0] text-[14.5px] leading-relaxed">
                    Group created...
                </p>
            </div>

            <div class="h-[1px] bg-[#313d45] mx-6 mb-5"></div>

            <!-- Media, Links and Docs -->
            <div class="px-6 py-2 hover:bg-[#202c33]/30 cursor-pointer transition-colors mb-3"
                onclick="window.openGroupMediaLibrary()">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center gap-4">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"
                            class="text-[#8696a0]">
                            <path
                                d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z">
                            </path>
                        </svg>
                        <span class="text-[#e9edef] text-[16px]">Media, links and docs</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span id="group_media_count" class="text-[#8696a0] text-[15px]">0</span>
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"
                            class="text-[#8696a0] -rotate-90">
                            <path d="M16.59 8.59L12 13.17 7.41 8.59 6 10l6 6 6-6z"></path>
                        </svg>
                    </div>
                </div>
                <div id="group_media_container" class="flex gap-2 overflow-hidden">
                    <!-- Dynamically populated -->
                </div>
            </div>

            <div class="h-[1px] bg-[#313d45] mx-6 mb-3"></div>

            <!-- Starred Messages & Notifications -->
            <div class="flex flex-col mb-4">
                <div onclick="window.openGroupStarredMessages()"
                    class="px-6 py-3.5 hover:bg-[#202c33]/30 cursor-pointer transition-colors flex justify-between items-center relative">
                    <div class="flex items-center gap-4">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"
                            class="text-[#8696a0]">
                            <path
                                d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z">
                            </path>
                        </svg>
                        <span class="text-[#e9edef] text-[16px]">Starred messages</span>
                        <span id="group_starred_count_badge" class="text-[#8696a0] text-sm ml-2 hidden">0</span>
                    </div>
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"
                        class="text-[#8696a0] -rotate-90">
                        <path d="M16.59 8.59L12 13.17 7.41 8.59 6 10l6 6 6-6z"></path>
                    </svg>
                </div>

                <!-- Group Starred Messages Panel -->
                <div id="group_starred_messages_panel"
                    class="hidden fixed top-0 right-0 h-screen w-[400px] bg-[#111b21] border-l border-[#313d45] z-[500] flex-col shadow-2xl">
                    <div
                        class="h-[64px] bg-[#202c33] flex items-center px-4 gap-6 shrink-0 shadow-sm z-10 border-b border-[#313d45]">
                        <button
                            onclick="document.getElementById('group_starred_messages_panel').classList.add('hidden')"
                            class="text-[#aebac1] hover:text-[#e9edef] transition-colors focus:outline-none">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                            </svg>
                        </button>
                        <span class="text-[#e9edef] text-[16px] font-medium">Starred messages</span>
                    </div>
                    <div id="group_starred_messages_list"
                        class="flex-1 overflow-y-auto p-4 space-y-3 bg-[#111b21] [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-thumb]:bg-[#374248] [&::-webkit-scrollbar-track]:bg-transparent pb-10">
                        <!-- Populated by JS -->
                    </div>
                </div>

                <div
                    class="px-6 py-3.5 hover:bg-[#202c33]/30 cursor-pointer transition-colors flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"
                            class="text-[#8696a0]">
                            <path
                                d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z">
                            </path>
                        </svg>
                        <span class="text-[#e9edef] text-[16px]">Notification settings</span>
                    </div>
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"
                        class="text-[#8696a0] -rotate-90">
                        <path d="M16.59 8.59L12 13.17 7.41 8.59 6 10l6 6 6-6z"></path>
                    </svg>
                </div>
            </div>

            <div class="h-[1px] bg-[#313d45] mx-6 mb-4"></div>

            <!-- Encryption & Privacy cards -->
            <div class="px-6 mb-5">
                <div class="bg-[#182229] rounded-[16px] overflow-hidden shadow-sm border border-[#202c33]">
                    <div class="p-4 py-4 hover:bg-[#202c33] cursor-pointer transition-colors flex items-start gap-4">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"
                            class="text-[#8696a0] shrink-0 mt-0.5">
                            <path
                                d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z">
                            </path>
                        </svg>
                        <div>
                            <div class="text-[#e9edef] text-[16px] mb-0.5">Encryption</div>
                            <div class="text-[#8696a0] text-[14px] leading-snug">Messages are end-to-end encrypted.
                                Click to learn more.</div>
                        </div>
                    </div>
                    <div class="h-[1px] bg-[#202c33] ml-[54px]"></div>
                    <div class="p-4 py-4 hover:bg-[#202c33] cursor-pointer transition-colors flex items-start gap-4">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"
                            class="text-[#8696a0] shrink-0 mt-0.5">
                            <path
                                d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z">
                            </path>
                        </svg>
                        <div class="w-full flex justify-between items-center">
                            <div>
                                <div class="text-[#e9edef] text-[16px] mb-0.5">Advanced chat privacy</div>
                                <div class="text-[#8696a0] text-[14px]">Off</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Group Settings Row -->
                <div id="group_settings_info_row" class="px-6 mb-5 hidden">
                    <div class="bg-[#182229] rounded-[16px] p-4 border border-[#202c33] space-y-4">
                        <div class="flex items-center gap-2 mb-2 pb-2 border-b border-[#313d45]">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"
                                class="text-[#00a884]">
                                <path
                                    d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z">
                                </path>
                            </svg>
                            <span class="text-[#e9edef] text-[15px] font-semibold">Group settings (Admins only)</span>
                        </div>

                        <!-- Edit group settings -->
                        <div class="flex items-start justify-between">
                            <div class="flex-1 pr-4">
                                <span class="text-[#e9edef] text-[14px] block">Edit group settings</span>
                                <span class="text-[#8696a0] text-xs">Name, icon, and description.</span>
                            </div>
                            <button onclick="window.toggleGroupInfoPerm('editSettings')"
                                id="info_perm_toggle_editSettings"
                                class="w-11 h-6 flex items-center rounded-full p-0.5 transition-colors duration-200 bg-[#00a884] shrink-0">
                                <div class="bg-white w-5 h-5 rounded-full shadow-md transform transition-transform duration-200 translate-x-5"
                                    id="info_perm_circle_editSettings"></div>
                            </button>
                        </div>

                        <!-- Send messages -->
                        <div class="flex items-start justify-between">
                            <div class="flex-1 pr-4">
                                <span class="text-[#e9edef] text-[14px] block">Send messages</span>
                                <span class="text-[#8696a0] text-xs">Choose who can send messages to this group.</span>
                            </div>
                            <button onclick="window.toggleGroupInfoPerm('sendMessages')"
                                id="info_perm_toggle_sendMessages"
                                class="w-11 h-6 flex items-center rounded-full p-0.5 transition-colors duration-200 bg-[#00a884] shrink-0">
                                <div class="bg-white w-5 h-5 rounded-full shadow-md transform transition-transform duration-200 translate-x-5"
                                    id="info_perm_circle_sendMessages"></div>
                            </button>
                        </div>

                        <!-- Add other members -->
                        <div class="flex items-start justify-between">
                            <div class="flex-1 pr-4">
                                <span class="text-[#e9edef] text-[14px] block">Add other members</span>
                                <span class="text-[#8696a0] text-xs">Choose who can add new members to this
                                    group.</span>
                            </div>
                            <button onclick="window.toggleGroupInfoPerm('addMembers')"
                                id="info_perm_toggle_addMembers"
                                class="w-11 h-6 flex items-center rounded-full p-0.5 transition-colors duration-200 bg-[#00a884] shrink-0">
                                <div class="bg-white w-5 h-5 rounded-full shadow-md transform transition-transform duration-200 translate-x-5"
                                    id="info_perm_circle_addMembers"></div>
                            </button>
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
                                <path
                                    d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <div id="group_members_list" class="flex flex-col">
                        <!-- Add Member Item -->
                        <div class="flex items-center gap-4 py-3 hover:bg-[#202c33]/30 cursor-pointer transition-colors"
                            onclick="window.openAddGroupMembersModal()">
                            <div
                                class="w-[44px] h-[44px] rounded-full bg-[#00a884] flex items-center justify-center text-white shrink-0">
                                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                    <path
                                        d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z">
                                    </path>
                                </svg>
                            </div>
                            <span class="text-[#e9edef] text-[16px]">Add member</span>
                        </div>
                    </div>
                </div>

                <div class="h-[1px] bg-[#313d45] mx-6 mb-4"></div>

                <!-- Footer Actions -->
                <div class="flex flex-col mb-8 px-6 pb-4">
                    <div onclick="window.toggleFavouriteChat(window.activeChatUser.id, 'group'); window.updateGroupInfoFavouriteText();"
                        class="py-4 hover:bg-[#202c33]/30 cursor-pointer transition-colors flex items-center gap-5">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor"
                            stroke-width="2" class="text-[#8696a0]">
                            <path
                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                            </path>
                        </svg>
                        <span id="group_info_fav_text" class="text-[#e9edef] text-[16px]">Add to favourites</span>
                    </div>

                    <div onclick="if(window.openAddToListModal) { window.openAddToListModal('group_sidebar_' + window.activeChatUser.id); }"
                        class="py-4 hover:bg-[#202c33]/30 cursor-pointer transition-colors flex items-center gap-5">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor"
                            stroke-width="2" class="text-[#8696a0]">
                            <path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"></path>
                        </svg>
                        <span class="text-[#e9edef] text-[16px]">Add to list</span>
                    </div>

                    <div onclick="window.handleGroupInfoClearChat();"
                        class="py-4 hover:bg-[#202c33]/30 cursor-pointer transition-colors flex items-center gap-5">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"
                            class="text-[#f15c6d]">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11H7v-2h10v2z">
                            </path>
                        </svg>
                        <span class="text-[#f15c6d] text-[16px]">Clear chat</span>
                    </div>

                    <div onclick="window.handleGroupInfoExitGroup();"
                        class="py-4 hover:bg-[#202c33]/30 cursor-pointer transition-colors flex items-center gap-5">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"
                            class="text-[#f15c6d]">
                            <path
                                d="M10.09 15.59L11.5 17l5-5-5-5-1.41 1.41L12.67 11H3v2h9.67l-2.58 2.59zM19 3H5c-1.11 0-2 .9-2 2v4h2V5h14v14H5v-4H3v4c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z">
                            </path>
                        </svg>
                        <span class="text-[#f15c6d] text-[16px]">Exit group</span>
                    </div>

                    <div onclick="window.handleGroupInfoReportGroup();"
                        class="py-4 hover:bg-[#202c33]/30 cursor-pointer transition-colors flex items-center gap-5">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor"
                            stroke-width="2" class="text-[#f15c6d]">
                            <path d="M14.59 10l-4.59-4.59v3.59H2v2h8v3.59L14.59 10zM22 3v18H10V3h12z"></path>
                        </svg>
                        <span class="text-[#f15c6d] text-[16px]">Report group</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Group Member Context Dropdown Menu -->
<div id="group_member_context_dropdown"
    class="hidden fixed w-48 bg-[#233138] rounded-xl shadow-2xl border border-[#313d45] py-2 z-[600] transform scale-95 opacity-0 transition-all duration-150 origin-top-right">
    <button id="member_menu_message"
        class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors text-sm focus:outline-none">
        Message
    </button>
    <button id="member_menu_make_admin"
        class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors text-sm focus:outline-none">
        Make group admin
    </button>
    <button id="member_menu_dismiss_admin"
        class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors text-sm focus:outline-none">
        Dismiss as admin
    </button>
    <button id="member_menu_remove"
        class="w-full text-left px-4 py-3 text-red-500 hover:bg-red-500/10 transition-colors text-sm focus:outline-none">
        Remove
    </button>
</div>

<!-- Add Group Member Modal -->
<div id="add_group_member_modal" class="hidden fixed inset-0 z-[150] flex items-center justify-center p-4">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-[#0b141a]/80 backdrop-blur-sm" onclick="window.closeAddGroupMembersModal()"></div>

    <!-- Modal Content -->
    <div
        class="relative w-full max-w-[400px] bg-[#222e35] rounded-2xl shadow-2xl flex flex-col overflow-hidden animate-in fade-in zoom-in duration-200">
        <!-- Header -->
        <div class="px-6 py-5 flex items-center gap-4 bg-[#2a3942] shrink-0 border-b border-white/5">
            <button onclick="window.closeAddGroupMembersModal()"
                class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path
                        d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z">
                    </path>
                </svg>
            </button>
            <h3 class="text-[#e9edef] text-[17px] font-semibold">Add members</h3>
        </div>

        <!-- Search -->
        <div class="px-4 py-3 shrink-0">
            <div
                class="bg-[#202c33] rounded-xl flex items-center px-4 h-10 transition-all border border-transparent focus-within:border-[#00a884]/30">
                <svg class="w-5 h-5 text-[#8696a0]" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 0 0 1.256-3.386 5.207 5.207 0 1 0-5.207 5.208 5.183 5.183 0 0 0 3.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-4.6-1.598a3.608 3.608 0 1 1 0-7.216 3.608 3.608 0 0 1 0 7.216z">
                    </path>
                </svg>
                <input type="text" id="add_member_search" oninput="window.filterAddMembers()"
                    placeholder="Search name or number"
                    class="bg-transparent border-none focus:ring-0 w-full text-sm ml-2 text-[#d1d7db] placeholder-[#8696a0] focus:outline-none">
            </div>
        </div>

        <!-- Contacts List -->
        <div id="add_member_list" class="flex-1 overflow-y-auto max-h-[350px] custom-scrollbar px-2 pb-4">
            <!-- Members will be injected here -->
        </div>

        <!-- Footer -->
        <div id="add_member_footer"
            class="hidden px-6 py-4 bg-[#111b21] border-t border-white/5 flex items-center justify-between">
            <span id="add_member_selected_count" class="text-[#8696a0] text-sm font-medium">0 selected</span>
            <button onclick="window.submitAddMembers()"
                class="bg-[#00a884] hover:bg-[#00bfa5] text-[#111b21] font-bold px-6 py-2 rounded-full transition-all active:scale-95 shadow-lg">
                Add members
            </button>
        </div>
    </div>
</div>

<!-- Group Media Preview Modal -->
<div id="group_media_preview_modal"
    class="hidden fixed inset-0 z-[200] bg-gray-900/95 flex flex-col items-center justify-center backdrop-blur-sm">
    <div class="absolute top-4 right-4 z-[210]">
        <button onclick="window.clearGroupFile()"
            class="text-white hover:text-red-400 p-2 focus:outline-none transition-colors">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                </path>
            </svg>
        </button>
    </div>

    <div class="w-full max-w-4xl px-4 flex-1 min-h-0 flex items-center justify-center overflow-hidden py-12 relative">
        <div id="group_modal_image_container" class="hidden h-full w-full flex items-center justify-center min-h-0">
            <img id="group_modal_image_preview" class="max-h-full max-w-full object-contain rounded-lg shadow-2xl">
        </div>
        <div id="group_modal_file_container"
            class="hidden bg-white/10 p-8 rounded-3xl flex flex-col items-center justify-center gap-6 text-white w-full max-w-sm shadow-2xl backdrop-blur-md border border-white/20">
            <svg class="w-20 h-20 text-blue-400 drop-shadow-md" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            <span id="group_modal_file_name" class="font-medium text-lg text-center break-words w-full"></span>
        </div>
    </div>

    <div class="w-full max-w-2xl px-6 pb-8 flex gap-3 items-end">
        <div
            class="flex-1 bg-gray-800 rounded-2xl px-4 py-3 border border-gray-700 shadow-xl focus-within:border-gray-500 transition-colors">
            <input type="text" id="group_modal_caption" placeholder="Add a caption..."
                onkeypress="if(event.key === 'Enter') window.sendFromGroupModal()"
                class="w-full bg-transparent border-none text-white focus:ring-0 placeholder-gray-400 text-lg">
        </div>
        <button id="group_modal_send_btn" onclick="window.sendFromGroupModal()"
            class="bg-green-500 hover:bg-green-600 text-white rounded-full p-4 shadow-lg transition-all hover:scale-105 active:scale-95 focus:outline-none flex items-center justify-center min-w-[60px] min-h-[60px]">
            <svg id="group_modal_send_icon" class="w-7 h-7 ml-1" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
            </svg>
            <svg id="group_modal_spinner" class="hidden w-7 h-7 animate-spin text-white" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                    stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        </button>
    </div>
</div>

<!-- Group Media Library Modal -->
<div id="group_media_library_modal"
    class="hidden fixed inset-0 z-[250] bg-black/70 flex items-center justify-center p-4 backdrop-blur-sm">
    <div
        class="bg-[#111b21] border border-[#313d45] w-full max-w-2xl h-[85vh] rounded-2xl flex flex-col overflow-hidden shadow-2xl">
        <!-- Modal Header -->
        <div class="h-16 bg-[#202c33] px-6 flex items-center justify-between shrink-0 border-b border-[#313d45]">
            <div class="flex items-center gap-4">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="text-[#00a884]">
                    <path
                        d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z">
                    </path>
                </svg>
                <span class="text-[#e9edef] text-[18px] font-medium">Media, links and docs</span>
            </div>
            <button onclick="window.closeGroupMediaLibrary()"
                class="text-[#aebac1] hover:text-[#e9edef] transition-colors focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Tabs Navigation -->
        <div class="flex bg-[#111b21] border-b border-[#313d45] shrink-0">
            <button onclick="window.switchGroupMediaTab('media')" id="tab_btn_media"
                class="flex-1 py-3 text-center border-b-2 border-[#00a884] text-[#00a884] font-medium text-sm transition-all focus:outline-none">
                Media
            </button>
            <button onclick="window.switchGroupMediaTab('docs')" id="tab_btn_docs"
                class="flex-1 py-3 text-center border-b-2 border-transparent text-[#8696a0] hover:text-[#e9edef] font-medium text-sm transition-all focus:outline-none">
                Docs
            </button>
            <button onclick="window.switchGroupMediaTab('links')" id="tab_btn_links"
                class="flex-1 py-3 text-center border-b-2 border-transparent text-[#8696a0] hover:text-[#e9edef] font-medium text-sm transition-all focus:outline-none">
                Links
            </button>
        </div>

        <!-- Scrollable Tabs Content -->
        <div
            class="flex-1 overflow-y-auto p-6 [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-thumb]:bg-[#374248] [&::-webkit-scrollbar-track]:bg-transparent bg-[#0b141a]">
            <!-- Media Tab Content (Grid of images and videos) -->
            <div id="tab_content_media" class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                <!-- Dynamically populated -->
            </div>

            <!-- Docs Tab Content (List of documents and audio) -->
            <div id="tab_content_docs" class="hidden flex flex-col gap-3">
                <!-- Dynamically populated -->
            </div>

            <!-- Links Tab Content (List of links) -->
            <div id="tab_content_links" class="hidden flex flex-col gap-3">
                <!-- Dynamically populated -->
            </div>
        </div>
    </div>
</div>

<!-- Group Media Viewer Modal -->
<div id="group_media_viewer_modal"
    class="hidden fixed inset-0 z-[300] bg-black/95 flex flex-col items-center justify-between select-none">
    <!-- Header -->
    <div class="w-full h-16 bg-black/30 px-6 flex items-center justify-between shrink-0 text-white z-10">
        <div class="flex flex-col">
            <span id="group_viewer_title" class="font-medium text-sm sm:text-base">Media Viewer</span>
            <span id="group_viewer_subtitle" class="text-xs text-[#8696a0]">Sent by Someone</span>
        </div>
        <div class="flex items-center gap-4">
            <!-- Download Button -->
            <button id="group_viewer_download_btn"
                class="text-[#aebac1] hover:text-white transition-colors focus:outline-none" title="Download">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path
                        d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM17 13l-5 5-5-5h3V9h4v4h3z">
                    </path>
                </svg>
            </button>
            <button onclick="window.closeGroupMediaViewer()"
                class="text-[#aebac1] hover:text-white transition-colors focus:outline-none" title="Close">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Main Content Area with Navigation Arrows -->
    <div class="w-full flex-1 flex items-center justify-between px-4 sm:px-12 relative min-h-0">
        <!-- Prev Arrow -->
        <button id="group_viewer_prev_btn" onclick="window.prevGroupMediaItem()"
            class="text-white bg-black/40 hover:bg-black/60 p-3 rounded-full transition-all active:scale-90 focus:outline-none z-10 shrink-0">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>

        <!-- Center Media Display -->
        <div class="flex-1 flex items-center justify-center p-4 max-h-full max-w-full overflow-hidden min-h-0">
            <!-- Image Frame -->
            <div id="group_viewer_image_frame" class="hidden max-h-full max-w-full">
                <img id="group_viewer_image"
                    class="max-h-[75vh] max-w-full object-contain rounded-lg shadow-2xl transition-transform duration-200">
            </div>

            <!-- Video Frame -->
            <div id="group_viewer_video_frame" class="hidden w-full max-w-3xl">
                <video id="group_viewer_video" controls class="w-full max-h-[75vh] rounded-lg shadow-2xl"></video>
            </div>

            <!-- Audio Frame -->
            <div id="group_viewer_audio_frame"
                class="hidden bg-[#202c33]/90 border border-[#313d45] p-8 rounded-3xl flex flex-col items-center gap-4 text-white w-full max-w-md shadow-2xl backdrop-blur-md">
                <div
                    class="w-20 h-20 rounded-full bg-[#00a884] flex items-center justify-center shadow-lg animate-pulse">
                    <svg viewBox="0 0 24 24" width="40" height="40" fill="currentColor">
                        <path
                            d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3zm5.3-3c0 3-2.54 5.1-5.3 5.1S6.7 14 6.7 11H5c0 3.41 2.72 6.23 6 6.72V21h2v-3.28c3.28-.48 6-3.3 6-6.72h-1.7z">
                        </path>
                    </svg>
                </div>
                <span class="font-medium text-lg text-center break-words w-full">Audio Message</span>
                <audio id="group_viewer_audio" controls class="w-full mt-2"></audio>
            </div>

            <!-- Document Frame -->
            <div id="group_viewer_doc_frame"
                class="hidden bg-[#202c33]/90 border border-[#313d45] p-8 rounded-3xl flex flex-col items-center gap-6 text-white w-full max-w-md shadow-2xl backdrop-blur-md">
                <svg class="w-24 h-24 text-blue-400 drop-shadow-md" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <span id="group_viewer_doc_name"
                    class="font-medium text-lg text-center break-words w-full">file_name.pdf</span>
                <a id="group_viewer_doc_download_link" target="_blank"
                    class="w-full bg-[#00a884] hover:bg-[#00bfa5] text-[#111b21] font-bold py-3.5 px-6 rounded-xl text-center shadow-lg transition-all hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                        <path
                            d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM17 13l-5 5-5-5h3V9h4v4h3z">
                        </path>
                    </svg>
                    Download / Open Document
                </a>
            </div>

            <!-- Link Frame -->
            <div id="group_viewer_link_frame"
                class="hidden bg-[#202c33]/90 border border-[#313d45] p-8 rounded-3xl flex flex-col items-center gap-6 text-white w-full max-w-md shadow-2xl backdrop-blur-md">
                <div class="w-20 h-20 rounded-full bg-[#00a884]/20 flex items-center justify-center text-[#00a884]">
                    <svg viewBox="0 0 24 24" width="40" height="40" fill="currentColor">
                        <path
                            d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z">
                        </path>
                    </svg>
                </div>
                <span id="group_viewer_link_url"
                    class="font-medium text-lg text-center break-all w-full text-[#00a884] hover:underline cursor-pointer"></span>
                <p id="group_viewer_link_context"
                    class="text-sm text-gray-400 text-center break-words max-h-24 overflow-y-auto px-2"></p>
                <a id="group_viewer_link_btn" target="_blank"
                    class="w-full bg-[#00a884] hover:bg-[#00bfa5] text-[#111b21] font-bold py-3.5 px-6 rounded-xl text-center shadow-lg transition-all hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2">
                    Open Link in New Tab
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                        <path
                            d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z">
                        </path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Next Arrow -->
        <button id="group_viewer_next_btn" onclick="window.nextGroupMediaItem()"
            class="text-white bg-black/40 hover:bg-black/60 p-3 rounded-full transition-all active:scale-90 focus:outline-none z-10 shrink-0">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
    </div>

    <!-- Bottom Caption/Context Bar -->
    <div
        class="w-full bg-black/40 p-6 flex flex-col items-center text-center text-white shrink-0 z-10 border-t border-white/5">
        <p id="group_viewer_caption" class="text-base font-normal max-w-3xl leading-relaxed break-words"></p>
    </div>
</div>

<script>
    window.autoResizeTextarea = function(el) {
        el.style.height = 'auto';
        el.style.height = el.scrollHeight + 'px';
    };

    window.handleGroupKeyPress = function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendGroupMessage();
        }
    };

    window.toggleGroupAttachMenu = function() {
        const menu = document.getElementById('group_attach_menu');
        if (menu) menu.classList.toggle('hidden');
    };

    window.toggleGroupEmojiPicker = function() {
        const container = document.getElementById('group_emoji_picker_container');
        if (container) container.classList.toggle('hidden');
    };

    window.insertEmojiIntoGroupInput = function(emoji) {
        const input = document.getElementById('group_msg');
        if (input) {
            input.value += emoji;
            handleGroupInputToggle();
            if (typeof autoResizeTextarea === 'function') autoResizeTextarea(input);
            input.focus();
        }
        document.getElementById('group_emoji_picker_container')?.classList.add('hidden');
    };

    // Add listener for group emoji picker component clicks
    const groupEmojiPicker = document.getElementById('group_emoji_picker');
    if (groupEmojiPicker) {
        groupEmojiPicker.addEventListener('emoji-click', event => {
            const input = document.getElementById('group_msg');
            if (input) {
                input.value += event.detail.unicode;
                if (typeof handleGroupInputToggle === 'function') handleGroupInputToggle();
                if (typeof autoResizeTextarea === 'function') autoResizeTextarea(input);
                input.focus();
            }
        });
    }

    window.selectGroupFile = function(accepts) {
        let fileInput = document.getElementById('group_file_input');
        if (fileInput) {
            fileInput.setAttribute('accept', accepts);
            fileInput.click();
        }
        window.toggleGroupAttachMenu();
    };

    window.handleGroupFileChange = function(input) {
        const file = input.files[0];
        if (!file) return;

        const modal = document.getElementById('group_media_preview_modal');
        const imgContainer = document.getElementById('group_modal_image_container');
        const fileContainer = document.getElementById('group_modal_file_container');
        const imgPreview = document.getElementById('group_modal_image_preview');
        const fileNameDisplay = document.getElementById('group_modal_file_name');
        const captionInput = document.getElementById('group_modal_caption');

        modal.classList.remove('hidden');
        captionInput.value = '';
        captionInput.focus();

        if (file.type.startsWith('image/')) {
            imgContainer.classList.remove('hidden');
            fileContainer.classList.add('hidden');
            const reader = new FileReader();
            reader.onload = function(e) {
                imgPreview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        } else {
            imgContainer.classList.add('hidden');
            fileContainer.classList.remove('hidden');
            imgPreview.src = '';
            fileNameDisplay.textContent = file.name;
        }
    };

    window.clearGroupFile = function() {
        document.getElementById('group_file_input').value = "";
        document.getElementById('group_media_preview_modal').classList.add('hidden');
    };

    window.sendFromGroupModal = async function() {
        let captionInput = document.getElementById('group_modal_caption');
        let fileInput = document.getElementById('group_file_input');
        let fileObj = fileInput.files[0];
        let msgText = captionInput.value.trim();

        if (!window.currentChatId || (!msgText && !fileObj)) return;

        const formData = new FormData();
        formData.append('chat_id', window.currentChatId);
        formData.append('message', msgText);

        if (fileObj) {
            formData.append('file', fileObj);
        }

        if (window.groupReplyingTo) {
            formData.append('reply_to_id', window.groupReplyingTo);
            formData.append('reply_to_name', window.replyingToName);
            formData.append('reply_to_text', window.replyingToText);
            if (typeof window.cancelGroupReply === 'function') {
                window.cancelGroupReply();
            }
        }

        const btn = document.getElementById('group_modal_send_btn');
        const icon = document.getElementById('group_modal_send_icon');
        const spinner = document.getElementById('group_modal_spinner');

        if (btn) btn.disabled = true;
        if (icon) icon.classList.add('hidden');
        if (spinner) spinner.classList.remove('hidden');

        try {
            let res = await fetch('/send', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });

            if (btn) btn.disabled = false;
            if (icon) icon.classList.remove('hidden');
            if (spinner) spinner.classList.add('hidden');

            let data = await res.json();
            if (res.ok && data.status) {
                clearGroupFile();
            } else {
                alert("Failed to send: " + JSON.stringify(data));
            }
        } catch (err) {
            if (btn) btn.disabled = false;
            if (icon) icon.classList.remove('hidden');
            if (spinner) spinner.classList.add('hidden');

            console.error('Group media send error:', err);
            alert("Error: " + err.message);
        }

        document.getElementById('group_msg').focus();
    };

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
            const avatarUrl = member.avatar ||
                `https://ui-avatars.com/api/?name=${encodeURIComponent(member.name)}&background=2a3942&color=fff`;

            const item = document.createElement('div');
            item.className =
                'flex items-center gap-3 px-4 py-3 hover:bg-white/5 cursor-pointer transition-colors border-b border-white/[0.02]';
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

    window.startGroupVoiceCall = function(groupIdOrUseSelection = false) {
        let isSelection = typeof groupIdOrUseSelection === 'boolean' ? groupIdOrUseSelection : false;
        let providedGroupId = typeof groupIdOrUseSelection === 'string' || typeof groupIdOrUseSelection ===
            'number' ? groupIdOrUseSelection : null;

        let gId = providedGroupId;
        let gName = 'Group';
        let gAvatar = '';
        let participants = [];

        if (providedGroupId) {
            // Started from calls list, pass the ID. Route will handle it.
        } else {
            if (!window.activeChatUser) {
                alert('Please select a group first.');
                return;
            }
            gId = window.activeChatUser.id;
            gName = window.activeChatUser.name || 'Group';
            gAvatar = window.activeChatUser.avatar || '';

            if (isSelection) {
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
        }

        const params = new URLSearchParams({
            name: gName,
            avatar: gAvatar,
            role: 'caller',
            group_id: gId,
            participants: participants.join(',')
        });

        window.location.href = '/chat/groups/voice-call?' + params.toString();
    };

    window.startGroupVideoCall = function(groupIdOrUseSelection = false) {
        let isSelection = typeof groupIdOrUseSelection === 'boolean' ? groupIdOrUseSelection : false;
        let providedGroupId = typeof groupIdOrUseSelection === 'string' || typeof groupIdOrUseSelection ===
            'number' ? groupIdOrUseSelection : null;

        let gId = providedGroupId;
        let gName = 'Group';
        let gAvatar = '';
        let participants = [];

        if (providedGroupId) {
            // Started from calls list, we just pass the ID. We might not have participants array immediately,
            // but the route can handle it by fetching group members, or the caller will broadcast to the group node.
        } else {
            if (!window.activeChatUser) {
                alert('Please select a group first.');
                return;
            }
            gId = window.activeChatUser.id;
            gName = window.activeChatUser.name || 'Group';
            gAvatar = window.activeChatUser.avatar || '';

            if (isSelection) {
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
        }

        const params = new URLSearchParams({
            name: gName,
            avatar: gAvatar,
            role: 'caller',
            group_id: gId,
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

    window.sendGroupMessage = async function() {
        const input = document.getElementById('group_msg');
        const text = input.value.trim();

        if (!text || !window.currentChatId) return;

        if (window.groupEditingMessageKey) {
            let firebaseChatId = window.currentChatId;
            if (firebaseChatId.startsWith('group_group_')) {
                firebaseChatId = firebaseChatId.substring(6);
            }
            const path = `groups/${firebaseChatId}/messages/${window.groupEditingMessageKey}`;

            try {
                await window.update(window.ref(window.db, path), {
                    text: text,
                    is_edited: true,
                    edited_at: Math.floor(Date.now() / 1000)
                });
            } catch (e) {
                console.error("Error editing group message:", e);
            }

            window.cancelGroupEdit();
            return;
        }

        input.value = '';
        if (typeof autoResizeTextarea === 'function') autoResizeTextarea(input);
        input.focus();

        if (typeof handleGroupInputToggle === 'function') handleGroupInputToggle();

        const formData = new FormData();
        formData.append('chat_id', window.currentChatId);
        formData.append('message', text);

        if (window.groupReplyingTo) {
            formData.append('reply_to_id', window.groupReplyingTo);
            formData.append('reply_to_name', window.replyingToName);
            formData.append('reply_to_text', window.replyingToText);
            if (typeof window.cancelGroupReply === 'function') {
                window.cancelGroupReply();
            }
        }

        input.value = '';
        if (typeof autoResizeTextarea === 'function') autoResizeTextarea(input);
        if (typeof handleGroupInputToggle === 'function') handleGroupInputToggle();

        try {
            await fetch('/send', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });
        } catch (err) {
            console.error('Group message send error:', err);
        }
        input.focus();
    };

    window.getGroupTickSVG = function(status) {
        if (status === 'all_read') {
            return `<svg viewBox="0 0 16 15" width="16" height="15" class="text-[#53bdeb]" fill="currentColor"><path d="M15,5.4L9.3,11.1l-1.3-1.4l5.7-5.7L15,5.4z M10.4,5.4L4.7,11.1L2,8.4L0.6,9.8l4.1,4.1l7.1-7.1L10.4,5.4z"></path></svg>`;
        } else if (status === 'read_by_some') {
            return `<svg viewBox="0 0 16 15" width="16" height="15" class="text-[#8696a0]" fill="currentColor"><path d="M15,5.4L9.3,11.1l-1.3-1.4l5.7-5.7L15,5.4z M10.4,5.4L4.7,11.1L2,8.4L0.6,9.8l4.1,4.1l7.1-7.1L10.4,5.4z"></path></svg>`;
        } else {
            return `<svg viewBox="0 0 16 11" width="16" height="11" class="text-[#8696a0]" fill="currentColor"><path d="M11.8,1.6L5.3,8.1L2.1,4.9l-1.5,1.5L5.3,11l8-8L11.8,1.6z"></path></svg>`;
        }
    };

    // --- GROUP INFO SIDEBAR PANEL LOGIC ---
    window.openGroupStarredMessages = function() {
        const panel = document.getElementById('group_starred_messages_panel');
        const list = document.getElementById('group_starred_messages_list');
        if (!panel || !list) return;

        list.innerHTML = '';
        const myId = window.myUserId;
        const currentChat = window.currentChatId;

        if (!myId || !currentChat) return;

        window.get(window.ref(window.db, `starred_messages/${myId}`)).then(snapshot => {
            const data = snapshot.val();

            let groupStarredData = null;
            if (data) {
                const filtered = Object.entries(data).filter(([k, v]) => v.chat_id === currentChat);
                if (filtered.length > 0) {
                    groupStarredData = Object.fromEntries(filtered);
                }
            }

            if (!groupStarredData || Object.keys(groupStarredData).length === 0) {
                list.innerHTML = `<div class="text-center text-[#8696a0] py-20 flex flex-col items-center">
                    <div class="w-[84px] h-[84px] rounded-full bg-[#202c33] flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-[#8696a0]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    </div>
                    <span class="text-[#e9edef] text-[16px]">No starred messages</span>
                </div>`;
            } else {
                const msgs = Object.entries(groupStarredData).sort((a, b) => (b[1].time || 0) - (a[1]
                    .time || 0));

                msgs.forEach(([key, msg]) => {
                    const dateObj = msg.time ? new Date(msg.time * 1000) : new Date();
                    const date = dateObj.toLocaleDateString('en-US', {
                        month: '2-digit',
                        day: '2-digit',
                        year: 'numeric'
                    });
                    const time = dateObj.toLocaleTimeString('en-US', {
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: true
                    });
                    const isMe = msg.sender_id == myId;

                    let senderName = isMe ? 'You' : 'Member';
                    if (!isMe && window.allContacts) {
                        const contact = window.allContacts.find(c => c.id == msg.sender_id);
                        if (contact) senderName = contact.name || contact.phone;
                    }

                    let content = msg.text || '';
                    if (msg.type === 'image') content = '📷 Photo';
                    else if (msg.type === 'video') content = '🎥 Video';
                    else if (msg.type === 'audio') content = '🎤 Voice message';
                    else if (msg.type === 'document') content = `📄 ${msg.file_name || 'Document'}`;

                    list.insertAdjacentHTML('beforeend', `
                        <div class="bg-[#202c33] rounded-xl p-3 cursor-pointer hover:bg-[#2a3942] transition-colors"
                            onclick="document.getElementById('group_info_panel').classList.add('hidden'); document.getElementById('group_starred_messages_panel').classList.add('hidden'); setTimeout(() => window.scrollToGroupMessage && window.scrollToGroupMessage('${key}'), 400)">
                            <div class="flex items-center gap-2 mb-2">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="#00a884"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                <span class="text-[#00a884] text-[13.5px] font-medium">${senderName}</span>
                                <span class="text-[#8696a0] text-[12px] ml-auto">${date} ${time}</span>
                            </div>
                            <p class="text-[#e9edef] text-[14.5px] leading-relaxed break-words">${content}</p>
                        </div>`);
                });
            }

            const badge = document.getElementById('group_starred_count_badge');
            if (badge) {
                const count = groupStarredData ? Object.keys(groupStarredData).length : 0;
                if (count > 0) {
                    badge.textContent = count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            }

            panel.classList.remove('hidden');
            panel.classList.add('flex');
        });
    };

    window.openGroupInfoPanel = function() {
        const u = window.activeChatUser;
        if (!u) return;

        // Close search sidebar if open
        const searchSidebar = document.getElementById('search_sidebar');
        if (searchSidebar) {
            searchSidebar.classList.add('hidden');
            searchSidebar.classList.remove('flex');
        }

        document.getElementById('group_info_name').textContent = u.name;
        document.getElementById('group_info_avatar').src = u.avatar ||
            `https://ui-avatars.com/api/?name=${encodeURIComponent(u.name)}&background=202c33&color=fff`;

        // Update Starred messages badge
        if (window.get && window.ref && window.db && window.myUserId && window.currentChatId) {
            window.get(window.ref(window.db, `starred_messages/${window.myUserId}`)).then(snap => {
                const data = snap.val();
                let count = 0;
                if (data) count = Object.values(data).filter(m => m.chat_id === window.currentChatId)
                    .length;
                const badge = document.getElementById('group_starred_count_badge');
                if (badge) {
                    if (count > 0) {
                        badge.textContent = count;
                        badge.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                    }
                }
            });
        }

        const descEl = document.getElementById('group_info_description');
        if (descEl) {
            descEl.textContent = "Add group description";
            descEl.classList.add('text-[#00a884]');
            descEl.classList.remove('text-[#8696a0]');
        }

        if (u.id) {
            window.get(window.ref(window.db, 'groups/' + u.id)).then((snapshot) => {
                const group = snapshot.val();

                // Set current group data
                window.currentGroupData = group;

                const listEl = document.getElementById('group_members_list');
                const countEl = document.getElementById('group_members_count');
                const createdInfoEl = document.getElementById('group_info_created_at');

                if (group && createdInfoEl) {
                    const creatorId = group.createdBy || group.creator_id;
                    let creatorName = "Someone";
                    if (creatorId == window.myUserId) {
                        creatorName = "You";
                    } else if (window.allContacts && creatorId) {
                        const creator = window.allContacts.find(c => String(c.id) === String(creatorId));
                        creatorName = creator ? (creator.name || creator.phone) : creatorId;
                    }

                    let dateStr = "";
                    const timestamp = group.createdAt || group.created_at || group.time;
                    if (timestamp) {
                        const date = new Date(timestamp * 1000);
                        const day = date.getDate().toString().padStart(2, '0');
                        const month = (date.getMonth() + 1).toString().padStart(2, '0');
                        const year = date.getFullYear();
                        const time = date.toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                        dateStr = `, on ${day}/${month}/${year} at ${time}`;
                    }
                    createdInfoEl.textContent = `Group created by ${creatorName}${dateStr}`;

                    // Populate Description
                    const descEl = document.getElementById('group_info_description');
                    if (descEl) {
                        if (group.description) {
                            descEl.textContent = group.description;
                            descEl.classList.remove('text-[#00a884]');
                            descEl.classList.add('text-[#8696a0]');
                        } else {
                            descEl.textContent = "Add group description";
                            descEl.classList.add('text-[#00a884]');
                            descEl.classList.remove('text-[#8696a0]');
                        }
                    }
                }

                // Render group members using the new helper function
                if (group && window.renderGroupInfoMembers) {
                    window.renderGroupInfoMembers(group);
                }
            });
        }

        const p = document.getElementById('group_info_panel');
        if (p) {
            p.classList.remove('hidden');
            p.classList.add('flex');
        }
        if (typeof window.updateGroupInfoMediaList === 'function') {
            window.updateGroupInfoMediaList();
        }
        if (typeof window.updateGroupInfoFavouriteText === 'function') {
            window.updateGroupInfoFavouriteText();
        }
    };

    window.closeGroupInfoPanel = function() {
        const p = document.getElementById('group_info_panel');
        if (p) {
            p.classList.remove('flex');
            p.classList.add('hidden');
        }
    };

    window.updateGroupInfoFavouriteText = function() {
        const textSpan = document.getElementById('group_info_fav_text');
        if (!textSpan || !window.activeChatUser) return;
        const elementId = `group_sidebar_${window.activeChatUser.id}`;
        const isFav = window.favouriteChats && window.favouriteChats.includes(elementId);
        textSpan.textContent = isFav ? 'Remove from favourites' : 'Add to favourites';
    };

    window.handleGroupInfoClearChat = function() {
        if (!window.activeChatUser) return;
        const groupId = window.activeChatUser.id;
        const confirmAction = () => {
            window.clearChatMessages(groupId, 'group');
            window.closeGroupInfoPanel();
        };
        if (window.openDeleteModal) {
            window.openDeleteModal('Clear this chat?', confirmAction);
        } else if (confirm('Clear this chat?')) {
            confirmAction();
        }
    };

    window.handleGroupInfoExitGroup = function() {
        if (!window.activeChatUser) return;
        const groupId = window.activeChatUser.id;
        const groupName = window.activeChatUser.name;
        const confirmAction = async () => {
            try {
                const res = await fetch(`/api/group/${groupId}/leave`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            ?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({
                        user_id: window.myUserId
                    })
                });
                const data = await res.json();
                if (data.status) {
                    if (window.db && window.ref && window.push) {
                        const myName = document.getElementById('my_profile_name')?.textContent || 'Someone';
                        window.push(window.ref(window.db, `groups/${groupId}/messages`), {
                            text: `${myName} has left the group`,
                            sender_id: window.myUserId,
                            time: Math.floor(Date.now() / 1000),
                            type: 'text',
                            status: 'read'
                        });
                    }
                    window.closeGroupInfoPanel();
                    document.getElementById('active_group_chat_content')?.classList.add('hidden');
                    document.getElementById('chat_empty_state')?.classList.remove('hidden');
                    window.currentChatId = null;
                    window.activeChatUser = null;

                    const sidebarEl = document.getElementById(`group_sidebar_${groupId}`) || document
                        .getElementById(`group_sidebar_${groupId.toString().replace('group_', '')}`);
                    if (sidebarEl) sidebarEl.remove();

                    window.showToast?.('Exit Group', 'You have left the group.');
                } else {
                    window.showToast?.('Error', data.message || 'Failed to exit group.');
                }
            } catch (e) {
                console.error(e);
                window.showToast?.('Error', 'Failed to exit group.');
            }
        };
        if (confirm(`Are you sure you want to exit ${groupName}?`)) {
            confirmAction();
        }
    };

    window.handleGroupInfoReportGroup = function() {
        if (!window.activeChatUser) return;
        const groupId = window.activeChatUser.id;
        const groupName = window.activeChatUser.name;
        const confirmAction = async () => {
            try {
                const res = await fetch('/user/report', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            ?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({
                        reported_id: groupId,
                        reason: 'Reported from Group Info'
                    })
                });
                const data = await res.json();
                if (data.status) {
                    window.showToast?.('Report sent', `Group ${groupName} reported.`);
                    // Auto exit group after reporting
                    await fetch(`/api/group/${groupId}/leave`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                ?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({
                            user_id: window.myUserId
                        })
                    });
                    if (window.db && window.ref && window.push) {
                        const myName = document.getElementById('my_profile_name')?.textContent || 'Someone';
                        window.push(window.ref(window.db, `groups/${groupId}/messages`), {
                            text: `${myName} has left the group`,
                            sender_id: window.myUserId,
                            time: Math.floor(Date.now() / 1000),
                            type: 'text',
                            status: 'read'
                        });
                    }
                    window.closeGroupInfoPanel();
                    document.getElementById('active_group_chat_content')?.classList.add('hidden');
                    document.getElementById('chat_empty_state')?.classList.remove('hidden');
                    window.currentChatId = null;
                    window.activeChatUser = null;

                    const sidebarEl = document.getElementById(`group_sidebar_${groupId}`) || document
                        .getElementById(`group_sidebar_${groupId.toString().replace('group_', '')}`);
                    if (sidebarEl) sidebarEl.remove();
                } else {
                    window.showToast?.('Error', data.message || 'Failed to report group.');
                }
            } catch (e) {
                console.error(e);
                window.showToast?.('Error', 'Failed to report group.');
            }
        };
        if (confirm(
                `Report ${groupName} to WhatsApp? The last 5 messages from this group will be forwarded. If you exit this group, messages will be removed from this device.`
                )) {
            confirmAction();
        }
    };

    // --- GROUP MEDIA, LINKS AND DOCS LOGIC ---
    window.updateGroupInfoMediaList = function() {
        if (!window.globalMessages) return;

        let mediaItems = [];
        let docItems = [];
        let linkItems = [];

        // Simple URL regex
        const urlRegex = /(https?:\/\/[^\s]+|www\.[^\s]+)/gi;

        for (let key in window.globalMessages) {
            const m = window.globalMessages[key];
            if (!m) continue;

            if (m.type === 'image' || m.type === 'video') {
                mediaItems.push({
                    key: key,
                    type: m.type,
                    url: m.file_url,
                    name: m.file_name || (m.type === 'image' ? 'Image' : 'Video'),
                    time: m.time || 0,
                    sender: m.sender_name || 'Member'
                });
            } else if (m.type === 'document' || m.type === 'audio') {
                docItems.push({
                    key: key,
                    type: m.type,
                    url: m.file_url,
                    name: m.file_name || (m.type === 'audio' ? 'Audio Note' : 'Document'),
                    time: m.time || 0,
                    sender: m.sender_name || 'Member'
                });
            }

            if (m.text) {
                const matches = m.text.match(urlRegex);
                if (matches) {
                    matches.forEach(url => {
                        linkItems.push({
                            key: key,
                            type: 'link',
                            url: url,
                            text: m.text,
                            time: m.time || 0,
                            sender: m.sender_name || 'Member'
                        });
                    });
                }
            }
        }

        // Sort descending by time
        mediaItems.sort((a, b) => b.time - a.time);
        docItems.sort((a, b) => b.time - a.time);
        linkItems.sort((a, b) => b.time - a.time);

        const totalCount = mediaItems.length + docItems.length + linkItems.length;

        // Update count
        const countEl = document.getElementById('group_media_count');
        if (countEl) {
            countEl.textContent = totalCount;
        }

        // Grab top 4 most recent combined items to show in preview
        const previewItems = [...mediaItems, ...docItems, ...linkItems]
            .sort((a, b) => b.time - a.time)
            .slice(0, 4);

        const containerEl = document.getElementById('group_media_container');
        if (containerEl) {
            if (previewItems.length === 0) {
                containerEl.innerHTML =
                    `<div class="text-[#8696a0] text-sm py-2">No media, links or docs shared yet</div>`;
            } else {
                let html = '';
                previewItems.forEach(item => {
                    if (item.type === 'image') {
                        html += `
                            <div class="w-[80px] h-[80px] bg-[#2a3942] rounded-lg overflow-hidden shrink-0 relative cursor-pointer group/item" onclick="event.stopPropagation(); window.openGroupMediaViewer('${item.key}')">
                                <img src="${item.url}" class="w-full h-full object-cover group-hover/item:scale-105 transition-transform duration-200">
                            </div>`;
                    } else if (item.type === 'video') {
                        html += `
                            <div class="w-[80px] h-[80px] bg-[#2a3942] rounded-lg overflow-hidden shrink-0 relative cursor-pointer group/item" onclick="event.stopPropagation(); window.openGroupMediaViewer('${item.key}')">
                                <video src="${item.url}" class="w-full h-full object-cover group-hover/item:scale-105 transition-transform duration-200"></video>
                                <div class="absolute inset-0 flex items-center justify-center bg-black/40 group-hover/item:bg-black/20 transition-colors">
                                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-white">
                                        <path d="M8 5v14l11-7z"></path>
                                    </svg>
                                </div>
                            </div>`;
                    } else if (item.type === 'audio') {
                        html += `
                            <div class="w-[80px] h-[80px] bg-[#202c33] rounded-lg border border-[#313d45] overflow-hidden shrink-0 flex flex-col items-center justify-center cursor-pointer group/item hover:bg-[#2a3942] transition-colors relative" onclick="event.stopPropagation(); window.openGroupMediaViewer('${item.key}')">
                                <svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor" class="text-[#00a884]">
                                    <path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3zm5.3-3c0 3-2.54 5.1-5.3 5.1S6.7 14 6.7 11H5c0 3.41 2.72 6.23 6 6.72V21h2v-3.28c3.28-.48 6-3.3 6-6.72h-1.7z"></path>
                                </svg>
                                <span class="text-[9px] text-[#8696a0] truncate w-full text-center px-1 mt-1">Audio</span>
                            </div>`;
                    } else if (item.type === 'document') {
                        const ext = window.getFileExt(item.name).toUpperCase() || 'FILE';
                        html += `
                            <div class="w-[80px] h-[80px] bg-[#202c33] rounded-lg border border-[#313d45] overflow-hidden shrink-0 flex flex-col items-center justify-center cursor-pointer group/item hover:bg-[#2a3942] transition-colors relative" onclick="event.stopPropagation(); window.openGroupMediaViewer('${item.key}')">
                                <span class="text-[11px] font-bold text-white bg-[#00a884] px-1.5 py-0.5 rounded shadow-sm max-w-[70px] truncate uppercase">${ext}</span>
                                <span class="text-[9px] text-[#8696a0] truncate w-full text-center px-1 mt-1.5">${item.name}</span>
                            </div>`;
                    } else if (item.type === 'link') {
                        let displayDomain = 'Link';
                        try {
                            let parsed = new URL(item.url.startsWith('http') ? item.url : 'http://' + item
                                .url);
                            displayDomain = parsed.hostname.replace('www.', '');
                        } catch (e) {}
                        html += `
                            <div class="w-[80px] h-[80px] bg-[#202c33] rounded-lg border border-[#313d45] overflow-hidden shrink-0 flex flex-col items-center justify-center cursor-pointer group/item hover:bg-[#2a3942] transition-colors relative" onclick="event.stopPropagation(); window.openGroupMediaViewer('${item.key}')">
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

        window.currentGroupMediaItems = mediaItems;
        window.currentGroupDocItems = docItems;
        window.currentGroupLinkItems = linkItems;
    };

    window.switchGroupMediaTab = function(tab) {
        ['media', 'docs', 'links'].forEach(t => {
            const btn = document.getElementById('tab_btn_' + t);
            const content = document.getElementById('tab_content_' + t);
            if (btn && content) {
                if (t === tab) {
                    btn.classList.add('border-[#00a884]', 'text-[#00a884]');
                    btn.classList.remove('border-transparent', 'text-[#8696a0]');
                    content.classList.remove('hidden');
                    if (t === 'media') {
                        content.classList.add('grid');
                    } else {
                        content.classList.add('flex');
                    }
                } else {
                    btn.classList.remove('border-[#00a884]', 'text-[#00a884]');
                    btn.classList.add('border-transparent', 'text-[#8696a0]');
                    content.classList.add('hidden');
                    content.classList.remove('grid', 'flex');
                }
            }
        });
    };

    window.openGroupMediaLibrary = function() {
        const modal = document.getElementById('group_media_library_modal');
        if (!modal) return;

        // Render Media tab content
        const mediaTab = document.getElementById('tab_content_media');
        if (mediaTab) {
            const items = window.currentGroupMediaItems || [];
            if (items.length === 0) {
                mediaTab.innerHTML =
                    `<div class="text-[#8696a0] text-sm py-4 text-center col-span-full">No media shared yet</div>`;
            } else {
                let html = '';
                items.forEach(item => {
                    if (item.type === 'image') {
                        html += `
                            <div class="aspect-square bg-[#2a3942] rounded-lg overflow-hidden cursor-pointer group/item relative shadow border border-[#313d45]" onclick="window.openGroupMediaViewer('${item.key}')">
                                <img src="${item.url}" class="w-full h-full object-cover group-hover/item:scale-105 transition-transform duration-200">
                            </div>`;
                    } else if (item.type === 'video') {
                        html += `
                            <div class="aspect-square bg-[#2a3942] rounded-lg overflow-hidden cursor-pointer group/item relative shadow border border-[#313d45]" onclick="window.openGroupMediaViewer('${item.key}')">
                                <video src="${item.url}" class="w-full h-full object-cover group-hover/item:scale-105 transition-transform duration-200"></video>
                                <div class="absolute inset-0 flex items-center justify-center bg-black/40 group-hover/item:bg-black/20 transition-colors">
                                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="text-white">
                                        <path d="M8 5v14l11-7z"></path>
                                    </svg>
                                </div>
                            </div>`;
                    }
                });
                mediaTab.innerHTML = html;
            }
        }

        // Render Docs tab content
        const docsTab = document.getElementById('tab_content_docs');
        if (docsTab) {
            const items = window.currentGroupDocItems || [];
            if (items.length === 0) {
                docsTab.innerHTML =
                    `<div class="text-[#8696a0] text-sm py-4 text-center">No documents shared yet</div>`;
            } else {
                let html = '';
                items.forEach(item => {
                    const ext = window.getFileExt(item.name);
                    const color = window.getFileColor(item.name);
                    const dateStr = new Date(item.time * 1000).toLocaleDateString([], {
                        month: 'short',
                        day: 'numeric',
                        year: 'numeric'
                    });

                    docsTab.innerHTML = ''; // Clear earlier if any
                    html += `
                        <div class="p-3.5 bg-[#202c33] hover:bg-[#2a3942] rounded-xl flex items-center gap-4 transition-colors cursor-pointer border border-[#313d45]" onclick="window.openGroupMediaViewer('${item.key}')">
                            <div class="w-12 h-12 rounded-lg flex items-center justify-center shrink-0 text-[13px] font-bold text-white shadow-sm" style="background-color: ${color}">
                                ${ext.toUpperCase()}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-[#e9edef] font-medium text-[15px] truncate">${item.name}</div>
                                <div class="text-[#8696a0] text-[13px] mt-1 flex items-center gap-1.5">
                                    <span>${item.sender}</span>
                                    <span class="w-1 h-1 rounded-full bg-[#8696a0]"></span>
                                    <span>${dateStr}</span>
                                </div>
                            </div>
                        </div>`;
                });
                docsTab.innerHTML = html;
            }
        }

        // Render Links tab content
        const linksTab = document.getElementById('tab_content_links');
        if (linksTab) {
            const items = window.currentGroupLinkItems || [];
            if (items.length === 0) {
                linksTab.innerHTML =
                    `<div class="text-[#8696a0] text-sm py-4 text-center">No links shared yet</div>`;
            } else {
                let html = '';
                items.forEach(item => {
                    const dateStr = new Date(item.time * 1000).toLocaleDateString([], {
                        month: 'short',
                        day: 'numeric',
                        year: 'numeric'
                    });
                    let displayDomain = 'Link';
                    try {
                        let parsed = new URL(item.url.startsWith('http') ? item.url : 'http://' + item.url);
                        displayDomain = parsed.hostname.replace('www.', '');
                    } catch (e) {}

                    html += `
                        <div class="p-4 bg-[#202c33] hover:bg-[#2a3942] rounded-xl flex flex-col gap-2 transition-colors cursor-pointer border border-[#313d45]" onclick="window.openGroupMediaViewer('${item.key}')">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-[#00a884]/10 text-[#00a884] flex items-center justify-center shrink-0">
                                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                                        <path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-[#00a884] font-medium text-[15px] truncate">${displayDomain}</div>
                                    <div class="text-[#8696a0] text-[12px] mt-0.5">${dateStr} • ${item.sender}</div>
                                </div>
                            </div>
                            <p class="text-[#e9edef] text-[14px] leading-relaxed break-words line-clamp-2 mt-1">${item.text}</p>
                        </div>`;
                });
                linksTab.innerHTML = html;
            }
        }

        window.switchGroupMediaTab('media');
        modal.classList.remove('hidden');
    };

    window.closeGroupMediaLibrary = function() {
        const modal = document.getElementById('group_media_library_modal');
        if (modal) modal.classList.add('hidden');
    };

    window.groupViewerList = [];
    window.groupViewerIndex = -1;

    window.openGroupMediaViewer = function(itemKey) {
        const viewerModal = document.getElementById('group_media_viewer_modal');
        if (!viewerModal) return;

        const media = window.currentGroupMediaItems || [];
        const docs = window.currentGroupDocItems || [];
        const links = window.currentGroupLinkItems || [];

        window.groupViewerList = [...media, ...docs, ...links].sort((a, b) => b.time - a.time);
        window.groupViewerIndex = window.groupViewerList.findIndex(item => item.key === itemKey);

        if (window.groupViewerIndex === -1) return;

        window.renderGroupViewerItem();
        viewerModal.classList.remove('hidden');
    };

    window.closeGroupMediaViewer = function() {
        const viewerModal = document.getElementById('group_media_viewer_modal');
        if (viewerModal) {
            viewerModal.classList.add('hidden');
            const vid = document.getElementById('group_viewer_video');
            if (vid) vid.pause();
            const aud = document.getElementById('group_viewer_audio');
            if (aud) aud.pause();
        }
    };

    window.renderGroupViewerItem = function() {
        if (window.groupViewerIndex < 0 || window.groupViewerIndex >= window.groupViewerList.length) return;

        const item = window.groupViewerList[window.groupViewerIndex];
        const msg = window.globalMessages[item.key];
        if (!msg) return;

        const prevBtn = document.getElementById('group_viewer_prev_btn');
        const nextBtn = document.getElementById('group_viewer_next_btn');
        if (prevBtn) prevBtn.style.visibility = (window.groupViewerIndex < window.groupViewerList.length - 1) ?
            'visible' : 'hidden';
        if (nextBtn) nextBtn.style.visibility = (window.groupViewerIndex > 0) ? 'visible' : 'hidden';

        const titleEl = document.getElementById('group_viewer_title');
        const subtitleEl = document.getElementById('group_viewer_subtitle');
        const dateStr = new Date(msg.time * 1000).toLocaleString([], {
            month: 'short',
            day: 'numeric',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });

        if (titleEl) {
            let label = 'Media Viewer';
            if (msg.type === 'document') label = 'Document';
            else if (msg.type === 'audio') label = 'Audio Note';
            else if (msg.type === 'image') label = 'Image';
            else if (msg.type === 'video') label = 'Video';
            else if (item.type === 'link') label = 'Shared Link';
            titleEl.textContent = label;
        }

        if (subtitleEl) {
            const sender = msg.sender_name || 'Member';
            subtitleEl.textContent = `Sent by ${sender} on ${dateStr}`;
        }

        ['image', 'video', 'audio', 'doc', 'link'].forEach(t => {
            const frame = document.getElementById(`group_viewer_${t}_frame`);
            if (frame) frame.classList.add('hidden');
        });

        const vid = document.getElementById('group_viewer_video');
        if (vid) {
            vid.pause();
            vid.src = '';
        }
        const aud = document.getElementById('group_viewer_audio');
        if (aud) {
            aud.pause();
            aud.src = '';
        }

        const downloadBtn = document.getElementById('group_viewer_download_btn');
        if (downloadBtn) {
            if (msg.file_url) {
                downloadBtn.classList.remove('hidden');
                downloadBtn.onclick = () => window.open(msg.file_url, '_blank');
            } else {
                downloadBtn.classList.add('hidden');
            }
        }

        if (msg.type === 'image') {
            const frame = document.getElementById('group_viewer_image_frame');
            const img = document.getElementById('group_viewer_image');
            if (frame && img) {
                img.src = msg.file_url;
                frame.classList.remove('hidden');
            }
        } else if (msg.type === 'video') {
            const frame = document.getElementById('group_viewer_video_frame');
            const video = document.getElementById('group_viewer_video');
            if (frame && video) {
                video.src = msg.file_url;
                frame.classList.remove('hidden');
            }
        } else if (msg.type === 'audio') {
            const frame = document.getElementById('group_viewer_audio_frame');
            const audio = document.getElementById('group_viewer_audio');
            if (frame && audio) {
                audio.src = msg.file_url;
                frame.classList.remove('hidden');
            }
        } else if (msg.type === 'document') {
            const frame = document.getElementById('group_viewer_doc_frame');
            const nameEl = document.getElementById('group_viewer_doc_name');
            const link = document.getElementById('group_viewer_doc_download_link');
            if (frame && nameEl && link) {
                nameEl.textContent = msg.file_name || 'Document';
                link.href = msg.file_url;
                frame.classList.remove('hidden');
            }
        } else if (item.type === 'link') {
            const frame = document.getElementById('group_viewer_link_frame');
            const urlEl = document.getElementById('group_viewer_link_url');
            const contextEl = document.getElementById('group_viewer_link_context');
            const linkBtn = document.getElementById('group_viewer_link_btn');
            if (frame && urlEl && contextEl && linkBtn) {
                urlEl.textContent = item.url;
                urlEl.onclick = () => window.open(item.url.startsWith('http') ? item.url : 'http://' + item.url,
                    '_blank');
                contextEl.textContent = msg.text;
                linkBtn.href = item.url.startsWith('http') ? item.url : 'http://' + item.url;
                frame.classList.remove('hidden');
            }
        }

        const captionEl = document.getElementById('group_viewer_caption');
        if (captionEl) {
            const hasCaption = (msg.type !== 'text' && msg.text && msg.text.trim().length > 0);
            captionEl.textContent = hasCaption ? msg.text : '';
            captionEl.parentElement.style.display = hasCaption ? 'flex' : 'none';
        }
    };

    window.prevGroupMediaItem = function() {
        if (window.groupViewerIndex < window.groupViewerList.length - 1) {
            window.groupViewerIndex++;
            window.renderGroupViewerItem();
        }
    };

    window.nextGroupMediaItem = function() {
        if (window.groupViewerIndex > 0) {
            window.groupViewerIndex--;
            window.renderGroupViewerItem();
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
            resultsEl.innerHTML =
                `<div class="text-[#8696a0] text-center text-sm py-4">Type to search messages in group</div>`;
            return;
        }

        let html = '';
        let found = false;

        for (let key in window.globalMessages) {
            const m = window.globalMessages[key];
            if (m && m.text && m.text.toLowerCase().includes(queryVal)) {
                found = true;
                const time = m.time ? new Date(m.time * 1000).toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                }) : '';
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
            el.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
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
            const stream = await navigator.mediaDevices.getUserMedia({
                audio: true
            });
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
                document.getElementById('group_audio_timer').innerText =
                    `${mins}:${secs.toString().padStart(2, '0')}`;
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
            const audioBlob = new Blob(groupAudioChunks, {
                type: 'audio/webm'
            });
            if (audioBlob.size < 100) return;

            const fd = new FormData();
            fd.append('file', audioBlob, 'group_voice_note.webm');
            fd.append('chat_id', window.currentChatId);

            try {
                await fetch('/send', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .content
                    },
                    body: fd
                });
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
<div id="group_msg_dropdown" class="hidden fixed z-50 transition-all duration-100 opacity-0 scale-95"
    style="width: 220px;">
    <!-- Emoji Reactions Bar -->
    <div class="bg-[#233138] rounded-full shadow-lg border border-[#313d45] px-2 py-1.5 flex items-center gap-1 mb-2 absolute"
        style="top: -46px; left: 0; width: max-content;">
        <button onclick="event.stopPropagation(); window.sendReaction('👍', window._activeGroupMsgKey, true, event)"
            class="w-8 h-8 flex items-center justify-center text-lg hover:bg-white/10 rounded-full transition-transform hover:scale-125"><span
                class="emoji-text">👍</span></button>
        <button onclick="event.stopPropagation(); window.sendReaction('❤️', window._activeGroupMsgKey, true, event)"
            class="w-8 h-8 flex items-center justify-center text-lg hover:bg-white/10 rounded-full transition-transform hover:scale-125"><span
                class="emoji-text">❤️</span></button>
        <button onclick="event.stopPropagation(); window.sendReaction('😂', window._activeGroupMsgKey, true, event)"
            class="w-8 h-8 flex items-center justify-center text-lg hover:bg-white/10 rounded-full transition-transform hover:scale-125"><span
                class="emoji-text">😂</span></button>
        <button onclick="event.stopPropagation(); window.sendReaction('😮', window._activeGroupMsgKey, true, event)"
            class="w-8 h-8 flex items-center justify-center text-lg hover:bg-white/10 rounded-full transition-transform hover:scale-125"><span
                class="emoji-text">😮</span></button>
        <button onclick="event.stopPropagation(); window.sendReaction('😢', window._activeGroupMsgKey, true, event)"
            class="w-8 h-8 flex items-center justify-center text-lg hover:bg-white/10 rounded-full transition-transform hover:scale-125"><span
                class="emoji-text">😢</span></button>
        <button onclick="event.stopPropagation(); window.sendReaction('🙏', window._activeGroupMsgKey, true, event)"
            class="w-8 h-8 flex items-center justify-center text-lg hover:bg-white/10 rounded-full transition-transform hover:scale-125"><span
                class="emoji-text">🙏</span></button>
        <button
            onclick="event.stopPropagation(); window.openFullReactionPicker(window._activeGroupMsgKey, true, event)"
            class="w-8 h-8 flex items-center justify-center text-[18px] text-[#aebac1] hover:bg-white/10 rounded-full transition-transform hover:scale-125 bg-white/5 ml-1">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
            </svg>
        </button>
    </div>

    <!-- Dropdown Menu -->
    <div class="bg-[#233138] rounded-xl shadow-2xl border border-[#313d45] py-2 w-full">
        <button onclick="window.replyToGroupMsg()"
            class="w-full text-left px-4 py-2.5 text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors text-[15px]"><span>Reply</span>
            <svg class="w-4 h-4 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
            </svg></button>
        <button onclick="window.askMetaAiGroupMsg()"
            class="w-full text-left px-4 py-2.5 text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors text-[15px]"><span>Ask
                Meta AI</span>
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8696a0"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M12 8a4 4 0 0 1 4 4c0 2.21-1.79 4-4 4s-4-1.79-4-4a4 4 0 0 1 4-4z" class="fill-[#8696a0]">
                </path>
            </svg>
        </button>
        <button id="group_dropdown_reply_priv" onclick="window.replyPrivatelyFromGroup()"
            class="w-full text-left px-4 py-2.5 text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors text-[15px]"><span>Reply
                privately</span> <svg class="w-4 h-4 text-[#8696a0]" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
            </svg></button>
        <button id="group_dropdown_msg_user" onclick="window.messageUserFromGroup()"
            class="w-full text-left px-4 py-2.5 text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors text-[15px] truncate"><span>Message
                <span id="group_dropdown_sender_name"></span></span></button>
        <button onclick="window.copyGroupMessage()"
            class="w-full text-left px-4 py-2.5 text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors text-[15px]"><span>Copy</span></button>
        <button id="group_edit_dropdown_btn" onclick="window.startGroupEdit()"
            class="w-full text-left px-4 py-2.5 text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors text-[15px]"><span>Edit</span>
            <svg class="w-4 h-4 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                </path>
            </svg>
        </button>
        <button onclick="window.forwardGroupMessage()"
            class="w-full text-left px-4 py-2.5 text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors text-[15px]"><span>Forward</span>
            <svg class="w-4 h-4 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M14 5l7 7m0 0l-7 7m7-7H3">
                </path>
            </svg></button>
        <button id="group_pin_dropdown_btn" onclick="window.toggleGroupPinMessage(event)"
            class="w-full text-left px-4 py-2.5 text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors text-[15px]"><span
                id="group_pin_dropdown_btn_text">Pin</span> <svg class="w-4 h-4 text-[#8696a0]"
                viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M16 9V4l1 0c.55 0 1-.45 1-1s-.45-1-1-1H7c-.55 0-1 .45-1 1s.45 1 1 1l1 0v5c0 1.66-1.34 3-3 3v2h5.97v7l1 1 1-1v-7H19v-2c-1.66 0-3-1.34-3-3z">
                </path>
            </svg></button>

        <button onclick="window.starGroupMessage()"
            class="w-full text-left px-4 py-2.5 text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors text-[15px]"><span
                id="group_star_dropdown_btn_text">Star</span> <svg class="w-4 h-4 text-[#8696a0]"
                viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
            </svg></button>
        <div class="h-[1px] bg-[#313d45] my-1 mx-4"></div>
        <button onclick="window.selectGroupMessage()"
            class="w-full text-left px-4 py-2.5 text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors text-[15px]"><span>Select</span></button>
        <div id="group_dropdown_report_divider" class="h-[1px] bg-[#313d45] my-1 mx-4"></div>
        <button id="group_dropdown_report" onclick="window.reportGroupMessage()"
            class="w-full text-left px-4 py-2.5 text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors text-[15px]"><span>Report</span></button>
        <button onclick="window.deleteGroupMessage()"
            class="w-full text-left px-4 py-2.5 text-red-500 hover:bg-red-500/10 flex items-center justify-between transition-colors text-[15px]"><span>Delete</span>
            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                </path>
            </svg></button>
    </div>
</div>

<!-- Group Header More Options Dropdown -->
<div id="group_header_more_dropdown"
    class="hidden absolute top-14 right-4 w-[260px] bg-[#233138] rounded-xl shadow-2xl border border-[#313d45] py-2 z-[100] transition-all duration-200 origin-top-right transform scale-95 opacity-0">
    <div id="group_header_main_menu"></div>
    <div id="group_header_submenu"
        class="hidden absolute top-0 right-full mr-2 w-[220px] bg-[#233138] rounded-xl shadow-2xl border border-[#313d45] py-2 z-[101]"></div>
</div>
</div>

<script>
    window.openGroupMessageOptions = function(event, messageKey, isMe, encodedSenderName, senderId) {
        event.stopPropagation();

        const msg = window.globalMessages[messageKey];
        const isCall = msg && msg.type === 'call';

        const dropdown = document.getElementById('group_msg_dropdown');
        if (!dropdown) return;

        const replyPriv = document.getElementById('group_dropdown_reply_priv');
        const msgUser = document.getElementById('group_dropdown_msg_user');
        const reportBtn = document.getElementById('group_dropdown_report');
        const reportDiv = document.getElementById('group_dropdown_report_divider');
        const senderNameSpan = document.getElementById('group_dropdown_sender_name');

        // Toggle visibility of standard buttons for call logs
        const replyBtn = dropdown.querySelector('button[onclick="window.replyToGroupMsg()"]');
        const copyBtn = dropdown.querySelector('button[onclick="window.copyGroupMessage()"]');
        const forwardBtn = dropdown.querySelector('button[onclick="window.forwardGroupMessage()"]');
        const pinBtn = document.getElementById('group_pin_dropdown_btn');
        const starBtn = dropdown.querySelector('button[onclick="window.starGroupMessage()"]');
        const selectBtn = dropdown.querySelector('button[onclick="window.selectGroupMessage()"]');

        // Find Meta AI buttons (both standard class and onclick)
        const metaAiBtns = Array.from(dropdown.querySelectorAll('button')).filter(btn => btn.textContent.trim() ===
            'Ask Meta AI');

        const deleteBtn = dropdown.querySelector('button[onclick="window.deleteGroupMessage()"]');

        const editBtn = document.getElementById('group_edit_dropdown_btn');
        if (editBtn) {
            editBtn.style.display = (isMe && msg && msg.type === 'text') ? 'flex' : 'none';
        }

        if (isMe) {
            replyPriv.style.display = 'none';
            msgUser.style.display = 'none';
            reportBtn.style.display = 'none';
            reportDiv.style.display = 'none';
            if (deleteBtn) deleteBtn.style.display = 'flex';
        } else {
            replyPriv.style.display = isCall ? 'none' : 'flex';
            msgUser.style.display = 'flex';
            reportBtn.style.display = isCall ? 'none' : 'flex';
            reportDiv.style.display = isCall ? 'none' : 'block';
            senderNameSpan.textContent = decodeURIComponent(encodedSenderName);
            if (deleteBtn) deleteBtn.style.display = 'none';
        }

        if (replyBtn) replyBtn.style.display = isCall ? 'none' : 'flex';
        if (copyBtn) copyBtn.style.display = isCall ? 'none' : 'flex';
        if (forwardBtn) forwardBtn.style.display = isCall ? 'none' : 'flex';

        if (pinBtn) {
            const pinBtnText = document.getElementById('group_pin_dropdown_btn_text');
            if (pinBtnText) {
                pinBtnText.textContent = (window._groupPinnedMsgKeys && window._groupPinnedMsgKeys.has(
                    messageKey)) ? 'Unpin' : 'Pin';
            } else {
                pinBtn.textContent = (window._groupPinnedMsgKeys && window._groupPinnedMsgKeys.has(messageKey)) ?
                    'Unpin' : 'Pin';
            }
            pinBtn.style.display = isCall ? 'none' : 'flex';
        }

        if (starBtn) starBtn.style.display = isCall ? 'none' : 'flex';
        if (selectBtn) selectBtn.style.display = isCall ? 'none' : 'flex';

        metaAiBtns.forEach(btn => {
            btn.style.display = isCall ? 'none' : 'flex';
        });

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

        // Adjust reaction strip alignment to prevent overflowing off-screen
        const reactionStrip = dropdown.firstElementChild;
        if (reactionStrip) {
            if (isMe) {
                reactionStrip.style.left = 'auto';
                reactionStrip.style.right = '0';
            } else {
                reactionStrip.style.right = 'auto';
                reactionStrip.style.left = '0';
            }
        }

        setTimeout(() => {
            dropdown.classList.remove('opacity-0', 'scale-95');
            dropdown.classList.add('opacity-100', 'scale-100');
        }, 10);

        window._activeGroupMsgKey = messageKey;
        window._activeGroupSenderId = senderId;
    };

    window.renderGroupHeaderMoreMenu = function() {
        const isAnnouncement = window.currentGroupData && window.currentGroupData.is_announcement === true;
        const mainMenu = document.getElementById('group_header_main_menu');
        const submenu = document.getElementById('group_header_submenu');
        const dropdown = document.getElementById('group_header_more_dropdown');
        if (!mainMenu || !submenu || !dropdown) return;

        if (isAnnouncement) {
            // Main Menu Content for Announcements
            mainMenu.innerHTML = `
                <button onclick="window.openAddGroupMembersModal(); toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                    <svg class="w-5 h-5 text-[#8696a0]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                    </svg>
                    <span class="text-[15px]">Add members</span>
                </button>
                <button onclick="window.openGroupInfoPanel(); toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                    <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <span class="text-[15px]">Announcements info</span>
                </button>
                <button onclick="window.showToast?.('Media', 'Opening media, docs, and links...'); toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                    <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                        <polyline points="21 15 16 10 5 21"></polyline>
                    </svg>
                    <span class="text-[15px]">Announcements media</span>
                </button>
                <button onclick="window.toggleGroupSearchDrawer(); toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                    <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <span class="text-[15px]">Search</span>
                </button>
                <button onclick="window.showToast?.('Mute', 'Notifications muted'); toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                    <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span class="text-[15px]">Mute notifications</span>
                </button>
                <button onclick="window.showToast?.('Disappearing Messages', 'Settings updated'); toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                    <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <span class="text-[15px]">Disappearing messages</span>
                </button>
                <button onclick="window.showToast?.('Theme', 'Opening theme selector...'); toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                    <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M12 2a7 7 0 0 0-7 7c0 2.38 1.19 4.47 3 5.74V17a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-2.26c1.81-1.27 3-3.36 3-5.74a7 7 0 0 0-7-7z"></path>
                        <line x1="9" y1="22" x2="15" y2="22"></line>
                    </svg>
                    <span class="text-[15px]">Chat theme</span>
                </button>
                <div id="group_header_more_trigger" class="w-full flex items-center justify-between px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors cursor-pointer group">
                    <div class="flex items-center gap-4">
                        <svg class="w-5 h-5 text-[#8696a0]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 10c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm12 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm-6 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
                        </svg>
                        <span class="text-[15px]">More</span>
                    </div>
                    <svg class="w-4 h-4 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </div>
            `;

            // Submenu Content for Announcements
            submenu.innerHTML = `
                <button onclick="window.showToast?.('Clear', 'Chat cleared'); toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                    <span class="text-[15px]">Clear chat</span>
                </button>
                <button onclick="window.showToast?.('Export', 'Exporting chat...'); toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                    <span class="text-[15px]">Export chat</span>
                </button>
                <button onclick="window.showToast?.('Shortcut', 'Shortcut added'); toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                    <span class="text-[15px]">Add shortcut</span>
                </button>
                <button onclick="window.showToast?.('List', 'Added to list'); toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                    <span class="text-[15px]">Add to list</span>
                </button>
                <button onclick="window.showToast?.('Report', 'Report sent'); toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                    <span class="text-[15px]">Report</span>
                </button>
                <button onclick="window.showToast?.('Exit', 'Exited community'); toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-red-500 hover:bg-[#182229] transition-colors text-left focus:outline-none font-medium">
                    <span class="text-[15px]">Exit community</span>
                </button>
            `;

            // Mouse behaviors to show/hide submenu on hover
            const trigger = document.getElementById('group_header_more_trigger');
            if (trigger) {
                trigger.addEventListener('mouseenter', () => {
                    submenu.classList.remove('hidden');
                });
                trigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    submenu.classList.toggle('hidden');
                });
            }

            dropdown.addEventListener('mouseleave', () => {
                submenu.classList.add('hidden');
            });
        } else {
            // Main Menu Content for Standard Groups (original menu layout)
            mainMenu.innerHTML = `
                <button onclick="window.openAddGroupMembersModal(); toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                    <svg class="w-5 h-5 text-[#8696a0]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                    </svg>
                    <span class="text-[15px]">Add member</span>
                </button>
                <button onclick="window.openGroupInfoPanel(); toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                    <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <span class="text-[15px]">Group info</span>
                </button>
                <button onclick="window.toggleGroupSearchDrawer(); toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                    <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <span class="text-[15px]">Search</span>
                </button>
                <button onclick="toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                    <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <polyline points="9 11 12 14 22 4"></polyline>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                    <span class="text-[15px]">Select messages</span>
                </button>
                <button onclick="toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                    <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M18 8a6 6 0 0 0-9.33-5"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                    </svg>
                    <span class="text-[15px]">Mute notifications</span>
                </button>
                <button onclick="toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                    <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <span class="text-[15px]">Disappearing messages</span>
                </button>
                <button onclick="toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                    <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                    <span class="text-[15px]">Lock chat</span>
                </button>
                <button onclick="toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                    <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                    <span class="text-[15px]">Add to favourites</span>
                </button>
                <button onclick="toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                    <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <line x1="8" y1="6" x2="21" y2="6"></line>
                        <line x1="8" y1="12" x2="21" y2="12"></line>
                        <line x1="8" y1="18" x2="21" y2="18"></line>
                        <line x1="3" y1="6" x2="3.01" y2="6"></line>
                        <line x1="3" y1="12" x2="3.01" y2="12"></line>
                        <line x1="3" y1="18" x2="3.01" y2="18"></line>
                    </svg>
                    <span class="text-[15px]">Add to list</span>
                </button>
                <button onclick="window.closeChat(); toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                    <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                    <span class="text-[15px]">Close chat</span>
                </button>
                <div class="h-[1px] bg-[#313d45] my-1 mx-4"></div>
                <button onclick="toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                    <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>
                    <span class="text-[15px]">Clear chat</span>
                </button>
                <button onclick="toggleGroupHeaderMoreMenu()"
                    class="w-full flex items-center gap-4 px-5 py-2.5 text-red-500 hover:bg-[#182229] transition-colors text-left focus:outline-none font-medium">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span class="text-[15px]">Exit group</span>
                </button>
            `;
            submenu.innerHTML = '';
        }
    };

    window.toggleGroupHeaderMoreMenu = function(event) {
        if (event) event.stopPropagation();
        const dropdown = document.getElementById('group_header_more_dropdown');
        if (!dropdown) return;

        const isHidden = dropdown.classList.contains('hidden');
        if (isHidden) {
            window.renderGroupHeaderMoreMenu();
            dropdown.classList.remove('hidden');
            setTimeout(() => {
                dropdown.classList.remove('opacity-0', 'scale-95');
                dropdown.classList.add('opacity-100', 'scale-100');
            }, 10);
        } else {
            dropdown.classList.remove('opacity-100', 'scale-100');
            dropdown.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                dropdown.classList.add('hidden');
                const submenu = document.getElementById('group_header_submenu');
                if (submenu) submenu.classList.add('hidden');
            }, 200);
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
            const path = e.composedPath();
            if (!path.includes(attachMenu) && !path.includes(attachBtn)) {
                attachMenu.classList.add('hidden');
            }
        }

        // Emoji picker
        const emojiPicker = document.getElementById('group_emoji_picker_container');
        const emojiBtn = document.getElementById('group_emoji_toggle_btn');
        if (emojiPicker && !emojiPicker.classList.contains('hidden')) {
            const path = e.composedPath();
            if (!path.includes(emojiPicker) && !path.includes(emojiBtn)) {
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
        document.querySelectorAll('[id^="msg_"]').forEach(el => el.classList.remove('bg-blue-100',
            'bg-opacity-50'));
    };

    window.confirmDeleteGroupSelected = function() {
        if (window.selectedGroupMessages.size === 0) return;
        window.openDeleteModal(`Delete ${window.selectedGroupMessages.size} message(s)?`, () => {
            window.selectedGroupMessages.forEach(key => {
                window.remove(window.ref(window.db,
                    `groups/${window.currentChatId}/messages/${key}`)).catch(e => {
                    console.error('Delete error:', e);
                });
            });
            window.cancelGroupSelection();
        });
    };

    window.toggleGroupMsgSelection = function(key) {
        if (!window.isGroupSelectionMode && !window.isGroupForwardSelection) return;
        const msg = window.globalMessages[key];
        if (msg && msg.type === 'call') return;

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
            if (window.isGroupSelectionMode) {
                window.cancelGroupSelection();
            } else if (window.isGroupForwardSelection) {
                window.cancelGroupForwardSelection();
            }
        } else {
            if (window.isGroupSelectionMode) {
                document.getElementById('group_selection_count').textContent = window.selectedGroupMessages.size +
                    ' Selected';
            } else if (window.isGroupForwardSelection) {
                document.getElementById('group_selection_bottom_count').textContent = window.selectedGroupMessages
                    .size + ' Selected';
            }
        }
    };

    window.sendGroupForwardedMessages = async function() {
        if (window.selectedGroupMessages.size === 0 || window._selectedForwardTargets.size === 0) return;

        const messagesToForward = [];
        window.selectedGroupMessages.forEach(key => {
            const msg = window.globalMessages[key];
            if (msg) {
                messagesToForward.push(msg);
            }
        });

        window.closeForwardModal();
        window.cancelGroupForwardSelection();

        for (const [targetId, targetInfo] of window._selectedForwardTargets.entries()) {
            if (targetId === 'status') {
                for (const msg of messagesToForward) {
                    const statusData = {
                        userId: window.myUserId,
                        userName: window.myUserName,
                        userAvatar: window.myUserAvatar,
                        text: msg.text || '',
                        type: msg.type || 'text',
                        timestamp: window.serverTimestamp(),
                        viewers: {},
                        privacyMode: window.currentPrivacyMode || 'all',
                        privacyContacts: window.currentPrivacyContacts || []
                    };
                    if (msg.file_url) statusData.mediaUrl = msg.file_url;
                    if (msg.type === 'text') {
                        statusData.bgColor = '#00a884';
                        statusData.font = 'font-sans';
                    }

                    try {
                        const statusRef = window.ref(window.db, `statuses/${window.myUserId}`);
                        await window.push(statusRef, statusData);
                    } catch (e) {
                        console.error('Forward group msg to status error:', e);
                    }
                }
            } else {
                const isTargetGroup = targetInfo.type === 'group';
                let chatId = '';
                if (isTargetGroup) {
                    chatId = 'group_' + targetId.replace('group_', '');
                } else {
                    const minId = Math.min(window.myUserId, parseInt(targetId));
                    const maxId = Math.max(window.myUserId, parseInt(targetId));
                    chatId = `chat_${minId}_${maxId}`;
                }

                for (const msg of messagesToForward) {
                    const formData = new FormData();
                    formData.append('chat_id', chatId);
                    formData.append('type', msg.type || 'text');
                    formData.append('message', msg.text || '');
                    if (msg.file_url) {
                        formData.append('file_url', msg.file_url);
                        formData.append('file_name', msg.file_name || 'file');
                    }
                    if (msg.lat) formData.append('lat', msg.lat);
                    if (msg.lng) formData.append('lng', msg.lng);

                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || (
                            typeof csrf !== 'undefined' ? csrf : '');
                        await fetch('/send', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: formData
                        });
                    } catch (e) {
                        console.error('Forward group msg send error:', e);
                    }
                }
            }
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
            else if (msgData.type === 'location' || msgData.type === 'live_location') typeLabel = 'location';
        }

        const isMe = msgData && msgData.sender_id == window.myUserId;
        const isAdmin = window.currentGroupData && window.currentGroupData.admins &&
            (window.currentGroupData.admins.includes(parseInt(window.myUserId)) || window.currentGroupData.admins
                .includes(String(window.myUserId)));
        const canDeleteEveryone = isMe || isAdmin;

        const onConfirmMe = () => {
            window.set(window.ref(window.db,
                    `groups/${window.currentChatId}/messages/${key}/deleted_for/${window.myUserId}`), true)
                .catch(e => console.error("Group delete for me error:", e));
        };

        const onConfirmEveryone = canDeleteEveryone ? () => {
            window.remove(window.ref(window.db, `groups/${window.currentChatId}/messages/${key}`))
                .catch(e => console.error("Group delete for everyone error:", e));
        } : null;

        window.openDeleteModal(`Delete ${typeLabel}?`, onConfirmMe, onConfirmEveryone);
    };

    // Multi-pin state for groups
    window._groupPinnedMsgKeys = new Set();
    window._groupPinnedMsgsList = [];
    window._currentGroupPinIndex = 0;

    window.pinGroupMessage = function() {
        const messageKey = window._activeGroupMsgKey;
        if (!messageKey || !window.currentChatId) return;

        const msg = window.globalMessages[messageKey];
        if (!msg) return;

        let msgText = "Media";
        if (msg.text) {
            msgText = msg.text;
        } else if (msg.type) {
            msgText = msg.type.charAt(0).toUpperCase() + msg.type.slice(1);
        }

        // Write to pinned_msgs/${key} (multi-pin)
        window.set(window.ref(window.db, `groups/${window.currentChatId}/pinned_msgs/${messageKey}`), {
            text: msgText,
            time: msg.time || Math.floor(Date.now() / 1000)
        });
        document.getElementById('group_msg_dropdown').classList.add('hidden');
    };

    window.unpinGroupMessage = function(messageKey, event) {
        if (event) event.stopPropagation();
        if (!window.currentChatId) return;

        const keyToRemove = messageKey || (window._groupPinnedMsgsList[window._currentGroupPinIndex] ? window
            ._groupPinnedMsgsList[window._currentGroupPinIndex].key : null);
        if (!keyToRemove) return;

        window.remove(window.ref(window.db, `groups/${window.currentChatId}/pinned_msgs/${keyToRemove}`));
    };

    window.toggleGroupPinMessage = function(event) {
        if (event) event.stopPropagation();
        const messageKey = window._activeGroupMsgKey;
        if (!messageKey || !window.currentChatId) return;

        if (window._groupPinnedMsgKeys.has(messageKey)) {
            window.unpinGroupMessage(messageKey, event);
        } else {
            window.pinGroupMessage();
        }
        document.getElementById('group_msg_dropdown').classList.add('hidden');
    };

    // Update pin icons on all visible group messages
    window.updateGroupPinIcons = function() {
        document.querySelectorAll('#group_messages [id^="pin_icon_"]').forEach(el => el.classList.add('hidden'));
        window._groupPinnedMsgKeys.forEach(key => {
            const icon = document.getElementById('pin_icon_' + key);
            if (icon) icon.classList.remove('hidden');
        });
    };

    // Scroll to message by key (group)
    window.scrollToMessage = function(key) {
        const el = document.getElementById('msg_' + key);
        if (el) {
            el.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            el.style.backgroundColor = 'rgba(0, 168, 132, 0.15)';
            setTimeout(() => {
                el.style.backgroundColor = '';
            }, 2000);
        }
    };

    // Navigate between group pinned messages
    window.navigateGroupPin = function(direction) {
        if (!window._groupPinnedMsgsList.length) return;
        window._currentGroupPinIndex = (window._currentGroupPinIndex + direction + window._groupPinnedMsgsList
            .length) % window._groupPinnedMsgsList.length;

        const pin = window._groupPinnedMsgsList[window._currentGroupPinIndex];
        const pinText = document.getElementById('group_pinned_text');
        if (pinText) pinText.textContent = pin.text;

        window.scrollToMessage(pin.key);
    };

    // Scroll to currently displayed group pin
    window.scrollToCurrentGroupPin = function() {
        if (!window._groupPinnedMsgsList.length) return;
        const pin = window._groupPinnedMsgsList[window._currentGroupPinIndex];
        if (pin) window.scrollToMessage(pin.key);
    };

    window.isGroupForwardSelection = false;

    window.cancelGroupForwardSelection = function() {
        window.isGroupForwardSelection = false;
        window.selectedGroupMessages.clear();

        // Hide selection bottom bar
        const bottomBar = document.getElementById('group_selection_bottom_bar');
        if (bottomBar) {
            bottomBar.classList.remove('flex');
            bottomBar.classList.add('hidden');
        }

        // Show normal input container
        document.getElementById('group_normal_input_container')?.classList.remove('hidden');

        // Hide checkboxes next to messages
        document.querySelectorAll('#group_messages .msg-checkbox-container').forEach(el => el.classList.add(
            'hidden'));

        // Uncheck all checkboxes
        document.querySelectorAll('#group_messages .msg-checkbox').forEach(el => {
            el.checked = false;
            const box = el.parentElement;
            box.classList.remove('bg-[#0d9488]', 'border-[#0d9488]');
            box.classList.add('bg-white', 'border-gray-400');
        });

        // Clear message background selection classes
        document.querySelectorAll('#group_messages [id^="msg_"]').forEach(el => el.classList.remove('bg-blue-100',
            'bg-opacity-50'));
    };

    window.forwardGroupMessage = function() {
        const messageKey = window._activeGroupMsgKey;
        if (!messageKey) return;

        document.getElementById('group_msg_dropdown').classList.add('hidden');

        window.isGroupForwardSelection = true;
        window.selectedGroupMessages.clear();

        // Hide normal input area and show selection bottom bar
        document.getElementById('group_normal_input_container')?.classList.add('hidden');
        const bottomBar = document.getElementById('group_selection_bottom_bar');
        if (bottomBar) {
            bottomBar.classList.remove('hidden');
            bottomBar.classList.add('flex');
        }

        // Show checkboxes
        document.querySelectorAll('#group_messages .msg-checkbox-container').forEach(el => el.classList.remove(
            'hidden'));

        // Toggle selection for current message
        window.toggleGroupMsgSelection(messageKey);
    };

    window.starGroupMessage = function() {
        const key = window._activeGroupMsgKey;
        if (!key || !window.myUserId) return;

        document.getElementById('group_msg_dropdown')?.classList.add('hidden');

        const msg = window.globalMessages[key];
        if (!msg) return;

        const starRef = window.ref(window.db, `starred_messages/${window.myUserId}/${key}`);

        if (window.starredMsgKeys && window.starredMsgKeys.has(key)) {
            window.remove(starRef).then(() => {
                window.starredMsgKeys.delete(key);
                const icon = document.getElementById('star_icon_' + key);
                if (icon) icon.classList.add('hidden');
                window.showToast?.('Message Unstarred', 'Message removed from starred.');
            });
        } else {
            window.set(starRef, {
                text: msg.text || '',
                type: msg.type || 'text',
                file_url: msg.file_url || null,
                file_name: msg.file_name || null,
                time: msg.time || 0,
                sender_id: msg.sender_id,
                chat_id: window.currentChatId
            }).then(() => {
                if (!window.starredMsgKeys) window.starredMsgKeys = new Set();
                window.starredMsgKeys.add(key);
                const icon = document.getElementById('star_icon_' + key);
                if (icon) icon.classList.remove('hidden');
                window.showToast?.('Message Starred', 'Message added to starred.');
            });
        }
    };

    window.selectGroupMessage = function() {
        const messageKey = window._activeGroupMsgKey;
        if (!messageKey) return;

        document.getElementById('group_msg_dropdown').classList.add('hidden');

        window.isGroupSelectionMode = true;
        window.selectedGroupMessages.clear();

        // Hide normal header and show selection header
        document.getElementById('group_normal_header').classList.add('hidden');
        document.getElementById('group_selection_header').classList.remove('hidden');
        document.getElementById('group_selection_header').classList.add('flex');

        // Show checkboxes
        document.querySelectorAll('#group_messages .msg-checkbox-container').forEach(el => el.classList.remove(
            'hidden'));

        // Toggle selection for current message
        window.toggleGroupMsgSelection(messageKey);
    };

    window.askMetaAiGroupMsg = function() {
        const messageKey = window._activeGroupMsgKey;
        if (!messageKey) return;

        let msgNode = document.getElementById(`group_msg_${messageKey}`);
        if (!msgNode) return;

        let senderName = msgNode.querySelector('.text-\\[13px\\]')?.innerText || 'Unknown';
        if (msgNode.classList.contains('justify-end')) {
            senderName = 'You';
        }

        let textNode = msgNode.querySelector('.break-words');
        let text = textNode ? textNode.innerText : '';

        window.closeGroupMsgDropdown();

        if (window.openMetaAiChat) {
            window.openMetaAiChat();
        }
        if (window.setMetaAiReplyContext) {
            window.setMetaAiReplyContext(messageKey, senderName, text);
        }
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

    window.groupEditingMessageKey = null;

    window.startGroupEdit = function() {
        const messageKey = window._activeGroupMsgKey;
        if (!messageKey) return;
        const msg = window.globalMessages[messageKey];
        if (!msg || msg.type !== 'text') return;

        window.cancelGroupReply();

        window.groupEditingMessageKey = messageKey;
        const text = msg.text || "";

        document.getElementById('group_editing_to_block').classList.remove('hidden');
        document.getElementById('group_editing_to_block').classList.add('flex');
        document.getElementById('group_editing_to_text').textContent = text;

        const input = document.getElementById('group_msg');
        if (input) {
            input.value = text;
            input.focus();
            if (typeof handleGroupInputToggle === 'function') handleGroupInputToggle();
        }
        document.getElementById('group_msg_dropdown')?.classList.add('hidden');
    };

    window.cancelGroupEdit = function() {
        window.groupEditingMessageKey = null;
        const block = document.getElementById('group_editing_to_block');
        block.classList.add('hidden');
        block.classList.remove('flex');
        const input = document.getElementById('group_msg');
        if (input) {
            input.value = "";
            if (typeof handleGroupInputToggle === 'function') handleGroupInputToggle();
        }
    };


    // Handle Global overrides for Group context without touching index.blade.php
    function applyGroupOverrides() {
        if (window._groupOverridesApplied) return;

        // Wait until core functions are available
        if (typeof window.emitMessage !== 'function') {
            console.log("Waiting for emitMessage to be available for override...");
            setTimeout(applyGroupOverrides, 500);
            return;
        }

        console.log("Applying Group Chat overrides to emitMessage...");
        const originalEmitMessage = window.emitMessage;

        window.emitMessage = async function(msgText, fileObj = null) {
            console.log("emitMessage intercepted. chatId:", window.currentChatId);
            if (window.currentChatId && typeof window.currentChatId === 'string' && window.currentChatId
                .startsWith('group_')) {

                if (window.groupEditingMessageKey) {
                    let firebaseChatId = window.currentChatId;
                    if (firebaseChatId.startsWith('group_group_')) {
                        firebaseChatId = firebaseChatId.substring(6);
                    }
                    const path = `groups/${firebaseChatId}/messages/${window.groupEditingMessageKey}`;

                    try {
                        await window.update(window.ref(window.db, path), {
                            text: msgText,
                            is_edited: true,
                            edited_at: Math.floor(Date.now() / 1000)
                        });
                    } catch (e) {
                        console.error("Error editing group message:", e);
                    }

                    window.cancelGroupEdit();
                    return;
                }

                console.log("Routing group message through /send:", msgText, fileObj?.name);

                const formData = new FormData();
                formData.append('chat_id', window.currentChatId);
                formData.append('message', msgText || '');
                if (fileObj) {
                    formData.append('file', fileObj);
                }

                // Handle group reply context
                if (window.groupReplyingTo) {
                    formData.append('reply_to_id', window.groupReplyingTo);
                    formData.append('reply_to_text', window.replyingToText || 'Media');
                    formData.append('reply_to_name', window.replyingToName || 'Member');
                }

                // Hide preview modal if open
                if (window.clearFile) {
                    document.getElementById('media_preview_modal')?.classList.add('hidden');
                }

                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || (
                        typeof csrf !== 'undefined' ? csrf : '');
                    const response = await fetch('/send', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    });

                    if (!response.ok) throw new Error('Failed to send group message via server');

                    // Cleanup UI
                    if (window.clearFile) window.clearFile();
                    if (window.cancelGroupReply) window.cancelGroupReply();
                    const msgInput = document.getElementById('msg');
                    if (msgInput) {
                        msgInput.value = '';
                        if (window.handleInputToggle) window.handleInputToggle();
                    }
                    console.log("Group message sent successfully via /send");
                } catch (error) {
                    console.error("Error sending group message:", error);
                    alert("Failed to send message to group.");
                }
                return;
            }

            // Fallback to original for non-groups
            return originalEmitMessage.apply(this, arguments);
        };

        window._groupOverridesApplied = true;
        console.log("Group Chat overrides successfully applied.");
    }

    // Run override after a delay to ensure index.blade.php scripts are loaded
    setTimeout(applyGroupOverrides, 1000);
    window.addEventListener('load', applyGroupOverrides);
    // Also try calling it when a group chat is selected to be absolutely sure
    const originalSelectGroupChat = window.selectGroupChat;
    window.selectGroupChat = function() {
        applyGroupOverrides();
        if (typeof window.cancelGroupForwardSelection === 'function') window.cancelGroupForwardSelection();
        if (typeof window.cancelGroupSelection === 'function') window.cancelGroupSelection();
        if (typeof originalSelectGroupChat === 'function') {
            originalSelectGroupChat.apply(this, arguments);
        }
    };

    window.confirmDeleteGroupSelected = function() {
        if (window.selectedGroupMessages.size === 0) return;
        if (confirm('Delete ' + window.selectedGroupMessages.size + ' message(s) from group?')) {
            window.selectedGroupMessages.forEach(key => {
                try {
                    window.remove(window.ref(window.db, 'groups/' + window.currentChatId + '/messages/' +
                        key)).catch(e => {
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
    const initGroupListener = setInterval(() => {
        if (window.db && window.onValue && window.myUserId && window.myUserId !== '0') {
            clearInterval(initGroupListener);
            window.onValue(window.ref(window.db, 'groups'), (snapshot) => {
                const groups = snapshot.val();
                if (groups) {
                    Object.values(groups).forEach(group => {
                        if (group && group.users) {
                            let uList = Array.isArray(group.users) ? group.users : Object
                                .values(group.users);
                            let hasUser = uList.some(u => String(u) === String(window
                                .myUserId));
                            if (hasUser) {
                                window.renderGroupSidebarItem(group);
                            }
                        }
                    });
                }
            });
        }
    }, 500); // Poll every 500ms until index module exposes window.db


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

            const elementId = `group_sidebar_${groupId}`;
            const clearedTime = window.clearedChats?.[elementId] || 0;
            if (data.time <= clearedTime) return;

            // Update Last Message Text
            const lastMsgEl = document.getElementById(`group_last_msg_${groupId}`);
            if (lastMsgEl) {
                let preview = data.text || "";
                if (data.type === 'image') preview = "📷 Image";
                else if (data.type === 'video') preview = "🎥 Video";
                else if (data.type === 'audio') preview = "🎵 Audio";
                else if (data.type === 'document') preview = "📄 Document";
                else if (data.type === 'location') preview = "📍 Location";
                else if (data.type === 'live_location') preview = "📍 Live Location";

                const prefix = (data.sender_id == window.myUserId) ? "✓ " : "";
                lastMsgEl.textContent = prefix + preview;
            }

            // Update Last Message Time
            const lastTimeEl = document.getElementById(`group_last_time_${groupId}`);
            if (lastTimeEl) {
                const msgDate = new Date(data.time * 1000);
                lastTimeEl.textContent = msgDate.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }

            // Update timestamp attribute and sort sidebar
            const groupItem = document.getElementById(`group_sidebar_${groupId}`);
            if (groupItem && data.time) {
                groupItem.setAttribute('data-timestamp', data.time);
                if (window.sortSidebar) window.sortSidebar();
            }

            // Update Unread Badge
            const isActive = window.currentChatId === 'group_' + groupId.replace('group_', '');
            const isMe = data.sender_id == window.myUserId;
            const hasRead = data.read_by && data.read_by[window.myUserId];

            if (!isActive && !isMe && !hasRead) {
                const badge = document.getElementById(`group_unread_badge_${groupId}`);
                if (badge) {
                    let count = parseInt(badge.textContent) || 0;
                    count++;
                    badge.textContent = count;
                    badge.classList.remove('hidden');
                    badge.classList.add('flex');

                    const drawerBadge = document.getElementById(`community_drawer_unread_${groupId}`);
                    if (drawerBadge) {
                        drawerBadge.textContent = count;
                        drawerBadge.classList.remove('hidden');
                        drawerBadge.classList.add('flex');
                    }

                    const sidebarBadge = document.getElementById(`sidebar_comm_unread_${groupId}`);
                    if (sidebarBadge) {
                        sidebarBadge.textContent = count;
                        sidebarBadge.classList.remove('hidden');
                        sidebarBadge.classList.add('flex');
                    }
                }
            }

            // If this is a community sub-group, update the parent Community row details and recalculate unread badge
            if (groupItem) {
                const communityId = groupItem.getAttribute('data-community-id');
                const isAnnouncement = groupItem.getAttribute('data-is-announcement') === 'true';
                const groupName = groupItem.getAttribute('data-name') || "";

                if (communityId && !isAnnouncement) {
                    const parentItem = document.querySelector(`[data-community-id="${communityId}"][data-is-announcement="true"]`);
                    if (parentItem) {
                        const parentGroupId = parentItem.getAttribute('data-groupid');
                        if (parentGroupId) {
                            // Update parent last message
                            const parentLastMsgEl = document.getElementById(`group_last_msg_${parentGroupId}`);
                            if (parentLastMsgEl) {
                                let previewText = data.text || "";
                                if (data.type === 'image') previewText = "📷 Image";
                                else if (data.type === 'video') previewText = "🎥 Video";
                                else if (data.type === 'audio') previewText = "🎵 Audio";
                                else if (data.type === 'document') previewText = "📄 Document";
                                else if (data.type === 'location') previewText = "📍 Location";
                                else if (data.type === 'live_location') previewText = "📍 Live Location";

                                const prefix = (data.sender_id == window.myUserId) ? "✓ " : "";
                                parentLastMsgEl.innerHTML = `${prefix}<span class="text-[#e9edef] font-medium">${groupName}</span> ▸ ${previewText}`;
                            }

                            // Update parent last message time
                            const parentLastTimeEl = document.getElementById(`group_last_time_${parentGroupId}`);
                            if (parentLastTimeEl) {
                                const msgDate = new Date(data.time * 1000);
                                parentLastTimeEl.textContent = msgDate.toLocaleTimeString([], {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });
                            }

                            // Update parent timestamp
                            parentItem.setAttribute('data-timestamp', data.time);
                            if (window.sortSidebar) window.sortSidebar();

                            // Recalculate parent unread badge
                            if (typeof window.recalculateCommunityUnreadBadge === 'function') {
                                window.recalculateCommunityUnreadBadge(communityId);
                            }
                        }
                    }
                }
            }
        });
    };

    window.recalculateCommunityUnreadBadge = function(communityId) {
        if (!communityId) return;
        const parentItem = document.querySelector(`[data-community-id="${communityId}"][data-is-announcement="true"]`);
        if (!parentItem) return;
        const parentGroupId = parentItem.getAttribute('data-groupid');
        if (!parentGroupId) return;

        let totalUnread = 0;
        // Sum up unread counts of all groups belonging to this community
        const commGroups = document.querySelectorAll(`[data-community-id="${communityId}"]`);
        commGroups.forEach(item => {
            const isAnnounce = item.getAttribute('data-is-announcement') === 'true';
            const gId = item.getAttribute('data-groupid');
            // If it's a sub-group, get its unread badge count
            if (!isAnnounce && gId) {
                const badge = document.getElementById(`group_unread_badge_${gId}`);
                if (badge && !badge.classList.contains('hidden')) {
                    totalUnread += parseInt(badge.textContent) || 0;
                }
            }
        });

        // Also add the announcement group's own unread count if any (wait, the parent item is the announcement group)
        // Since we are setting the badge on the parent item directly, it represents the community level unread count.
        const parentBadge = document.getElementById(`group_unread_badge_${parentGroupId}`);
        if (parentBadge) {
            if (totalUnread > 0) {
                parentBadge.textContent = totalUnread;
                parentBadge.classList.remove('hidden');
                parentBadge.classList.add('flex');
            } else {
                parentBadge.textContent = '0';
                parentBadge.classList.add('hidden');
                parentBadge.classList.remove('flex');
            }
        }
    };

    window.renderGroupSidebarItem = function(group) {
        let item = document.getElementById(`group_sidebar_${group.id}`);
        const isAnnounceGroup = group.is_announcement === true || group.is_announcement === 'true' || group.is_announcement == 1;
        if (!item) {
            item = document.createElement('div');
            item.id = `group_sidebar_${group.id}`;
            item.className =
                "flex items-center px-3 py-3 hover:bg-[#202c33] cursor-pointer transition-colors user-chat-item relative group";
            item.setAttribute('data-name', group.name);
            item.setAttribute('data-groupid', group.id);
            item.setAttribute('data-timestamp', '0');
            item.setAttribute('data-avatar', group.avatar ||
                `https://ui-avatars.com/api/?name=${encodeURIComponent(group.name)}&background=2a3942&color=fff`
            );

            // Set community data attributes for all community groups
            if (group.community_id) {
                item.setAttribute('data-community-id', group.community_id);
            }
            if (isAnnounceGroup) {
                item.setAttribute('data-is-announcement', 'true');
            }

            // For announcement groups (community announcements), open the community sidebar list
            if (isAnnounceGroup && group.community_id) {
                item.onclick = function() {
                    if (typeof window.openCommunityFromChats === 'function') {
                        window.openCommunityFromChats(group.community_id);
                    } else {
                        window.selectGroupChat(group.id, group.name, group.avatar);
                    }
                };

                // If community_name is not in group data, fetch it from Firebase
                if (!group.community_name && window.db && window.get && window.ref) {
                    window.get(window.ref(window.db, `communities/${group.community_id}/name`)).then((snap) => {
                        const cName = snap.val();
                        if (cName) {
                            group.community_name = cName;
                            // Update the h4 in the sidebar item if it's already rendered
                            const h4 = document.getElementById(`group_sidebar_name_${group.id}`);
                            if (h4) {
                                h4.textContent = cName;
                            }
                        }
                    }).catch(() => {});
                }
            } else {
                item.onclick = function() {
                    window.selectGroupChat(group.id, group.name, group.avatar);
                };
            }

            const avatarHtml = isAnnounceGroup ? `
                <div class="relative w-12 h-12 shrink-0 flex items-center justify-center">
                    <!-- Stacked background cards -->
                    <div class="absolute w-[36px] h-[36px] rounded-lg bg-[#3a464c] left-0.5 top-1 border border-[#111b21] transform -rotate-[10deg] z-[1]"></div>
                    <div class="absolute w-[36px] h-[36px] rounded-lg bg-[#2d383e] left-1.5 top-1.5 border border-[#111b21] transform -rotate-[5deg] z-[2]"></div>
                    <!-- Main top card -->
                    <div class="relative w-9 h-9 rounded-xl bg-[#3d302b] flex items-center justify-center border border-[#111b21] shadow-md z-[3] overflow-hidden">
                        <img src="${group.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(group.name)}&background=3d302b&color=ff8e6e`}" class="w-full h-full object-cover">
                    </div>
                </div>
            ` : `
                <div class="w-12 h-12 rounded-full overflow-hidden bg-[#2a3942] flex items-center justify-center shrink-0">
                    <img src="${group.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(group.name)}&background=2a3942&color=fff`}" class="w-full h-full object-cover">
                </div>
            `;

            item.innerHTML = `
                ${avatarHtml}
                ${isAnnounceGroup && group.community_id ? `
                <div class="ml-3 flex-1 border-b border-[#202c33] pb-3 pt-1 min-w-0 pr-2 relative">
                    <div class="flex justify-between items-center">
                        <h4 id="group_sidebar_name_${group.id}" class="text-[17px] text-[#e9edef] truncate mr-2 font-normal">${group.community_name || group.name.replace(' - Announcements','').replace(' Announcements','')}</h4>
                        <span class="text-[12px] text-[#8696a0] whitespace-nowrap" id="group_last_time_${group.id}"></span>
                    </div>
                    <div class="flex justify-between items-center mt-0.5">
                        <div class="flex items-center gap-1 min-w-0 flex-1">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor" class="text-[#8696a0] shrink-0"><path d="M8 5v14l11-7z"/></svg>
                            <p class="text-[14px] text-[#8696a0] truncate leading-snug" id="group_last_msg_${group.id}">Add members to start chatting</p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0 ml-2">
                            <!-- Unread Badge -->
                            <span id="group_unread_badge_${group.id}" class="hidden bg-[#00a884] text-[#111b21] text-[12px] font-bold min-w-[20px] h-5 rounded-full flex items-center justify-center px-1.5 shadow-sm">0</span>
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor" class="text-[#8696a0] shrink-0"><path d="M8.59 16.59L10 18l6-6-6-6-1.41 1.41L13.17 12z"/></svg>
                        </div>
                    </div>
                </div>
                ` : `
                <div class="ml-3 flex-1 border-b border-[#202c33] pb-3 pt-1 min-w-0 pr-6 relative">
                    <div class="flex justify-between items-center">
                        <h4 class="text-[17px] text-[#e9edef] truncate mr-2 font-normal">${group.name}</h4>
                        <span class="text-[12px] text-[#8696a0] whitespace-nowrap" id="group_last_time_${group.id}"></span>
                    </div>
                    <div class="flex justify-between items-center mt-0.5">
                        <p class="text-[14px] text-[#8696a0] truncate flex-1 min-w-0 leading-snug" id="group_last_msg_${group.id}">Group chat</p>
                        <div class="flex items-center gap-2 shrink-0">
                            <!-- Pin Icon -->
                            <span id="group_pin_icon_${group.id}" class="hidden text-[#8696a0]">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                                    <path d="M16 12V4h1V2H7v2h1v8l-2 2v2h5.2v6h1.6v-6H18v-2l-2-2z"/>
                                </svg>
                            </span>
                            <!-- Unread Badge -->
                            <span id="group_unread_badge_${group.id}" class="hidden bg-[#00a884] text-[#111b21] text-[12px] font-bold min-w-[20px] h-5 rounded-full flex items-center justify-center px-1.5 shadow-sm">0</span>
                        </div>
                    </div>
                </div>
                <!-- Dropdown Trigger Button with Gradient Overlay -->
                <div class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-[#202c33] via-[#202c33] to-transparent hidden group-hover:flex items-center justify-end pr-3 z-20 options-btn-gradient">
                    <button onclick="event.stopPropagation(); window.toggleUserContextMenu(event, '${group.id}', '${group.name.replace(/'/g, "\\'")}', 'group')"
                        class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none">
                        <svg viewBox="0 0 19 20" width="19" height="20" fill="currentColor">
                            <path d="M3.8 6.7l5.7 5.7 5.7-5.7 1.6 1.6-7.3 7.2-7.3-7.2 1.6-1.6z"></path>
                        </svg>
                    </button>
                </div>
                `}
            `;
            const container = document.getElementById('user_list_container');
            if (container) {
                container.appendChild(item);
            }

            // Apply initial pin visual state
            const isPinned = window.pinnedChats && window.pinnedChats.includes(item.id);
            if (window.applyPinVisualState) {
                window.applyPinVisualState(item, isPinned);
            }
            if (window.sortSidebar) {
                window.sortSidebar();
            }
        } else {
            const h4 = document.getElementById(`group_sidebar_name_${group.id}`) || item.querySelector('h4');
            const img = item.querySelector('img');
            const displayName = (isAnnounceGroup && group.community_id) ? (group.community_name || group.name.replace(' - Announcements','').replace(' Announcements','')) : group.name;
            if (h4) h4.textContent = displayName;
            if (img) img.src = group.avatar ||
                `https://ui-avatars.com/api/?name=${encodeURIComponent(displayName)}&background=2a3942&color=fff`;
        }

        // Attach message listener for real-time sidebar updates
        window.listenForGroupUpdates(group.id);

        // Cache group messages for global search
        if (typeof window.cacheGroupMessages === 'function') {
            window.cacheGroupMessages(group.id);
        }
    };

    window.groupMessagesCache = window.groupMessagesCache || {};

    window.cacheGroupMessages = function(groupId) {
        if (window.groupMessagesCache[groupId]) return; // already listening

        window.groupMessagesCache[groupId] = [];
        const messagesRef = window.ref(window.db, `groups/${groupId}/messages`);

        window.onChildAdded(messagesRef, (snapshot) => {
            const data = snapshot.val();
            if (data) {
                const elementId = `group_sidebar_${groupId}`;
                const clearedTime = window.clearedChats?.[elementId] || 0;
                if (data.time <= clearedTime) return;
                if (data.deleted_for && data.deleted_for[window.myUserId]) return;

                const key = snapshot.key;
                const idx = window.groupMessagesCache[groupId].findIndex(m => m.key === key);
                if (idx === -1) {
                    window.groupMessagesCache[groupId].push({
                        key: key,
                        text: data.text || "",
                        time: data.time || 0,
                        senderId: data.sender_id,
                        type: data.type || 'text',
                        file_url: data.file_url || ""
                    });

                    // Populate global media cache
                    if (data.type !== 'text' && data.file_url) {
                        window.globalMediaCache = window.globalMediaCache || [];
                        if (!window.globalMediaCache.find(m => m.key === key)) {
                            let sName = 'Someone';
                            if (data.sender_id == window.myUserId) {
                                sName = 'You';
                            } else {
                                const sidebarUser = document.getElementById(
                                    `user_sidebar_${data.sender_id}`);
                                if (sidebarUser) {
                                    const h4Text = sidebarUser.querySelector('h4')?.textContent;
                                    sName = sidebarUser.getAttribute('data-name') || (h4Text ? h4Text
                                            .trim() : null) || sidebarUser.getAttribute('data-phone') ||
                                        'Someone';
                                }
                            }

                            window.globalMediaCache.push({
                                key: key,
                                type: data.type,
                                url: data.file_url,
                                fileName: data.file_name,
                                time: data.time,
                                senderId: data.sender_id,
                                senderName: sName,
                                chatId: groupId
                            });
                        }
                    } else if (data.type === 'text' && data.text) {
                        const urlRegex = /(https?:\/\/[^\s]+)/g;
                        const links = data.text.match(urlRegex);
                        if (links) {
                            window.globalMediaCache = window.globalMediaCache || [];
                            let sName = data.sender_id == window.myUserId ? 'You' : 'Someone';
                            if (data.sender_id != window.myUserId) {
                                const sidebarUser = document.getElementById(
                                    `user_sidebar_${data.sender_id}`);
                                if (sidebarUser) {
                                    const h4Text = sidebarUser.querySelector('h4')?.textContent;
                                    sName = sidebarUser.getAttribute('data-name') || (h4Text ? h4Text
                                            .trim() : null) || sidebarUser.getAttribute('data-phone') ||
                                        'Someone';
                                }
                            }
                            links.forEach((url, idx) => {
                                const linkKey = key + '_link_' + idx;
                                if (!window.globalMediaCache.find(m => m.key === linkKey)) {
                                    window.globalMediaCache.push({
                                        key: linkKey,
                                        type: 'link',
                                        url: url,
                                        time: data.time,
                                        senderId: data.sender_id,
                                        senderName: sName,
                                        chatId: groupId
                                    });
                                }
                            });
                        }
                    }
                }
            }
        });

        window.onChildRemoved(messagesRef, (snapshot) => {
            const key = snapshot.key;
            if (window.groupMessagesCache[groupId]) {
                window.groupMessagesCache[groupId] = window.groupMessagesCache[groupId].filter(m => m
                    .key !== key);
            }
        });

        window.onChildChanged(messagesRef, (snapshot) => {
            const data = snapshot.val();
            const key = snapshot.key;
            if (data && data.deleted_for && data.deleted_for[window.myUserId]) {
                if (window.groupMessagesCache[groupId]) {
                    window.groupMessagesCache[groupId] = window.groupMessagesCache[groupId].filter(m => m
                        .key !== key);
                }
                const msgEl = document.getElementById('msg_' + key);
                if (msgEl) msgEl.remove();
                delete window.globalMessages[key];
                return;
            }
            if (window.groupMessagesCache[groupId]) {
                const idx = window.groupMessagesCache[groupId].findIndex(m => m.key === key);
                if (idx !== -1 && data) {
                    window.groupMessagesCache[groupId][idx].text = data.text || "";
                }
            }
        });
    };

    // Hijack window.filterSidebar using Object.defineProperty to prevent index.blade.php from overwriting it
    let customFilterSidebar = function() {
        const searchQuery = document.getElementById('sidebar_search').value.toLowerCase().trim();
        const clearBtn = document.getElementById('sidebar_search_clear');
        const userList = document.getElementById('user_list_container');
        const searchResults = document.getElementById('search_results_container');
        const chatsList = document.getElementById('search_chats_list');
        const msgsList = document.getElementById('search_messages_list');
        const chatsSection = document.getElementById('search_chats_section');
        const msgsSection = document.getElementById('search_messages_section');
        const noResults = document.getElementById('sidebar_no_results');

        // Show/hide clear button
        if (searchQuery.length > 0) {
            clearBtn?.classList.remove('hidden');
        } else {
            clearBtn?.classList.add('hidden');
        }

        // No query - show normal list
        if (searchQuery === '') {
            userList.classList.remove('hidden');
            searchResults?.classList.add('hidden');
            noResults?.classList.add('hidden');
            noResults?.classList.remove('flex');
            return;
        }

        // Hide normal list, show search results
        userList.classList.add('hidden');
        searchResults?.classList.remove('hidden');

        // Clear previous results
        if (chatsList) chatsList.innerHTML = '';
        if (msgsList) msgsList.innerHTML = '';

        const escQ = searchQuery.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const highlightRegex = new RegExp(`(${escQ})`, 'gi');

        let chatMatches = 0;
        let allMsgResults = [];

        // 1. Search Private Chats / Contacts
        const privateUserNodes = document.getElementById('user_list_container').querySelectorAll(
            '[id^="user_sidebar_"]');
        privateUserNodes.forEach(user => {
            const userId = user.getAttribute('data-userid') || user.id.replace('user_sidebar_', '');
            const name = user.getAttribute('data-name') || user.querySelector('h4')?.textContent.trim() ||
                '';
            const avatar = user.getAttribute('data-avatar') || '';
            const phone = user.getAttribute('data-phone') || '';
            const about = user.getAttribute('data-about') || 'Available';
            const lastTimeEl = document.getElementById(`last_time_${userId}`);
            const lastTime = lastTimeEl ? lastTimeEl.textContent.trim() : '';
            const lastMsgEl = document.getElementById(`last_msg_${userId}`);
            const lastMsg = lastMsgEl ? (lastMsgEl.getAttribute('data-msg') || lastMsgEl.textContent
                .trim()) : '';

            const nameLower = name.toLowerCase();
            const nameMatch = nameLower.includes(searchQuery);

            const elementId = `user_sidebar_${userId}`;
            // Skip locked chats if not in locked view
            if (window.lockedChats && window.lockedChats.includes(elementId) && window
                .activeSidebarFilter !== 'locked') {
                return; // Skip this user
            }

            if (nameMatch && chatsList) {
                chatMatches++;
                const highlightedName = name.replace(highlightRegex,
                    '<span class="text-[#00a884] font-medium">$1</span>');
                const prefix = lastMsg ? (lastMsg.startsWith('Click to chat') ? '' : '✓ ') : '';
                const previewMsg = lastMsg && !lastMsg.startsWith('Click to chat') ? prefix + lastMsg :
                    phone || 'Click to chat';

                const elementId = `user_sidebar_${userId}`;
                const isPinned = window.pinnedChats && window.pinnedChats.includes(elementId);
                const pinClass = isPinned ? '' : 'hidden';

                chatsList.insertAdjacentHTML('beforeend', `
                    <div onclick="window.selectChat(${userId}, '${name.replace(/'/g, "\\'")}', '${phone.replace(/'/g, "\\'")}', '${avatar}', '${about.replace(/'/g, "\\'")}')"
                        class="flex items-center px-3 py-3 hover:bg-[#202c33] cursor-pointer transition-colors relative group user-chat-item" data-userid="${userId}">
                        <div class="w-12 h-12 rounded-full overflow-hidden bg-[#2a3942] flex items-center justify-center shrink-0">
                            <img src="${avatar}" class="w-full h-full object-cover">
                        </div>
                        <div class="ml-3 flex-1 border-b border-[#202c33] pb-3 pt-1 min-w-0 pr-6 relative">
                            <div class="flex justify-between items-center">
                                <h4 class="text-[17px] text-[#e9edef] truncate mr-2 font-normal">${highlightedName}</h4>
                                <span class="text-[12px] text-[#8696a0] whitespace-nowrap">${lastTime}</span>
                            </div>
                            <div class="flex justify-between items-center mt-0.5">
                                <p class="text-[14px] text-[#8696a0] truncate flex-1 min-w-0 leading-snug">${previewMsg}</p>
                                <div class="flex items-center gap-2 shrink-0">
                                    <!-- Pin Icon -->
                                    <span id="pin_icon_${userId}" class="${pinClass} text-[#8696a0]">
                                        <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                                            <path d="M16 12V4h1V2H7v2h1v8l-2 2v2h5.2v6h1.6v-6H18v-2l-2-2z"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Dropdown Trigger Button with Gradient Overlay -->
                        <div class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-[#202c33] via-[#202c33] to-transparent hidden group-hover:flex items-center justify-end pr-3 z-20 options-btn-gradient">
                            <button onclick="event.stopPropagation(); window.toggleUserContextMenu(event, ${userId}, '${name.replace(/'/g, "\\'")}', 'user')"
                                class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none">
                                <svg viewBox="0 0 19 20" width="19" height="20" fill="currentColor">
                                    <path d="M3.8 6.7l5.7 5.7 5.7-5.7 1.6 1.6-7.3 7.2-7.3-7.2 1.6-1.6z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                `);
            }

            const cachedMessages = window.messageCache?.[userId] || [];
            for (let i = 0; i < cachedMessages.length; i++) {
                const m = cachedMessages[i];
                if (m.text && m.text.toLowerCase().includes(searchQuery)) {
                    allMsgResults.push({
                        isGroup: false,
                        userId,
                        name,
                        avatar,
                        phone,
                        about,
                        text: m.text,
                        time: m.time,
                        senderId: m.senderId
                    });
                }
            }
        });

        // 2. Search Groups / Group Chats
        const groupNodes = document.getElementById('user_list_container').querySelectorAll(
            '[id^="group_sidebar_"]');
        groupNodes.forEach(groupNode => {
            const groupId = groupNode.id.replace('group_sidebar_', '');
            const name = groupNode.querySelector('h4')?.textContent.trim() || '';
            const imgEl = groupNode.querySelector('img');
            const avatar = imgEl ? imgEl.src : '';
            const lastTimeEl = document.getElementById(`group_last_time_${groupId}`);
            const lastTime = lastTimeEl ? lastTimeEl.textContent.trim() : '';
            const lastMsgEl = document.getElementById(`group_last_msg_${groupId}`);
            const lastMsg = lastMsgEl ? lastMsgEl.textContent.trim() : 'Group chat';

            const nameLower = name.toLowerCase();
            const nameMatch = nameLower.includes(searchQuery);

            const elementId = `group_sidebar_${groupId}`;
            // Skip locked groups if not in locked view
            if (window.lockedChats && window.lockedChats.includes(elementId) && window
                .activeSidebarFilter !== 'locked') {
                return; // Skip this group
            }

            if (nameMatch && chatsList) {
                chatMatches++;
                const highlightedName = name.replace(highlightRegex,
                    '<span class="text-[#00a884] font-medium">$1</span>');

                const elementId = `group_sidebar_${groupId}`;
                const isPinned = window.pinnedChats && window.pinnedChats.includes(elementId);
                const pinClass = isPinned ? '' : 'hidden';

                chatsList.insertAdjacentHTML('beforeend', `
                    <div onclick="window.selectGroupChat('${groupId}', '${name.replace(/'/g, "\\'")}', '${avatar}')"
                        class="flex items-center px-3 py-3 hover:bg-[#202c33] cursor-pointer transition-colors relative group user-chat-item" data-groupid="${groupId}">
                        <div class="w-12 h-12 rounded-full overflow-hidden bg-[#2a3942] flex items-center justify-center shrink-0">
                            <img src="${avatar}" class="w-full h-full object-cover">
                        </div>
                        <div class="ml-3 flex-1 border-b border-[#202c33] pb-3 pt-1 min-w-0 pr-6 relative">
                            <div class="flex justify-between items-center">
                                <h4 class="text-[17px] text-[#e9edef] truncate mr-2 font-normal">${highlightedName}</h4>
                                <span class="text-[12px] text-[#8696a0] whitespace-nowrap">${lastTime}</span>
                            </div>
                            <div class="flex justify-between items-center mt-0.5">
                                <p class="text-[14px] text-[#8696a0] truncate flex-1 min-w-0 leading-snug">${lastMsg}</p>
                                <div class="flex items-center gap-2 shrink-0">
                                    <!-- Pin Icon -->
                                    <span id="group_pin_icon_${groupId}" class="${pinClass} text-[#8696a0]">
                                        <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                                            <path d="M16 12V4h1V2H7v2h1v8l-2 2v2h5.2v6h1.6v-6H18v-2l-2-2z"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Dropdown Trigger Button with Gradient Overlay -->
                        <div class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-[#202c33] via-[#202c33] to-transparent hidden group-hover:flex items-center justify-end pr-3 z-20 options-btn-gradient">
                            <button onclick="event.stopPropagation(); window.toggleUserContextMenu(event, '${groupId}', '${name.replace(/'/g, "\\'")}', 'group')"
                                class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none">
                                <svg viewBox="0 0 19 20" width="19" height="20" fill="currentColor">
                                    <path d="M3.8 6.7l5.7 5.7 5.7-5.7 1.6 1.6-7.3 7.2-7.3-7.2 1.6-1.6z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                `);
            }

            const cachedMessages = window.groupMessagesCache?.[groupId] || [];
            for (let i = 0; i < cachedMessages.length; i++) {
                const m = cachedMessages[i];
                if (m.text && m.text.toLowerCase().includes(searchQuery)) {
                    allMsgResults.push({
                        isGroup: true,
                        groupId,
                        name,
                        avatar,
                        text: m.text,
                        time: m.time,
                        senderId: m.senderId
                    });
                }
            }
        });

        // Sort combined message results chronologically (newest first)
        allMsgResults.sort((a, b) => (b.time || 0) - (a.time || 0));

        // Render all message results
        allMsgResults.forEach(r => {
            const msgTime = r.time ? new Date(r.time * 1000) : null;
            let timeStr = '';
            if (msgTime) {
                const now = new Date();
                const todayStart = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                const msgDayStart = new Date(msgTime.getFullYear(), msgTime.getMonth(), msgTime.getDate());
                const diffDays = Math.round((todayStart - msgDayStart) / (1000 * 60 * 60 * 24));
                if (diffDays === 0) timeStr = msgTime.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                else if (diffDays === 1) timeStr = 'Yesterday';
                else if (diffDays < 7) timeStr = msgTime.toLocaleDateString([], {
                    weekday: 'long'
                });
                else timeStr = msgTime.toLocaleDateString([], {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                });
            }

            const highlightedMsg = r.text.replace(highlightRegex,
                '<span class="text-[#00a884] font-medium">$1</span>');

            let prefix = '';
            if (r.isGroup) {
                const senderContact = window.allContacts ? window.allContacts.find(c => c.id == r
                    .senderId) : null;
                const senderName = r.senderId == window.myUserId ? 'You' : (senderContact ? (senderContact
                    .name || senderContact.phone) : 'Member');
                prefix = `<span class="text-[#8696a0] font-semibold">${senderName}: </span>`;
            } else {
                prefix = r.senderId == window.myUserId ? '<span class="text-[#8696a0]">✓ You: </span>' : '';
            }

            if (msgsList) {
                if (r.isGroup) {
                    msgsList.insertAdjacentHTML('beforeend', `
                        <div onclick="window.selectGroupChat('${r.groupId}', '${r.name.replace(/'/g, "\\'")}', '${r.avatar}', ${r.time || 0})"
                            class="flex items-center px-3 py-3 hover:bg-[#202c33] cursor-pointer transition-colors relative group user-chat-item" data-groupid="${r.groupId}">
                            <div class="w-12 h-12 rounded-full overflow-hidden bg-[#2a3942] flex items-center justify-center shrink-0">
                                <img src="${r.avatar}" class="w-full h-full object-cover">
                            </div>
                            <div class="ml-3 flex-1 border-b border-[#202c33] pb-3 pt-1 min-w-0 pr-6 relative">
                                <div class="flex justify-between items-center">
                                    <h4 class="text-[16px] text-[#e9edef] truncate mr-2 font-normal">${r.name}</h4>
                                    <span class="text-[12px] text-[#8696a0] whitespace-nowrap">${timeStr}</span>
                                </div>
                                <p class="text-[14px] text-[#8696a0] truncate mt-0.5 leading-snug">${prefix}${highlightedMsg}</p>
                            </div>
                            <!-- Dropdown Trigger Button with Gradient Overlay -->
                            <div class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-[#202c33] via-[#202c33] to-transparent hidden group-hover:flex items-center justify-end pr-3 z-20 options-btn-gradient">
                                <button onclick="event.stopPropagation(); window.toggleUserContextMenu(event, '${r.groupId}', '${r.name.replace(/'/g, "\\'")}', 'group')"
                                    class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none">
                                    <svg viewBox="0 0 19 20" width="19" height="20" fill="currentColor">
                                        <path d="M3.8 6.7l5.7 5.7 5.7-5.7 1.6 1.6-7.3 7.2-7.3-7.2 1.6-1.6z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    `);
                } else {
                    msgsList.insertAdjacentHTML('beforeend', `
                        <div onclick="window.selectChat(${r.userId}, '${r.name.replace(/'/g, "\\'")}', '${r.phone.replace(/'/g, "\\'")}', '${r.avatar}', '${r.about.replace(/'/g, "\\'")}', ${r.time || 0})"
                            class="flex items-center px-3 py-3 hover:bg-[#202c33] cursor-pointer transition-colors relative group user-chat-item" data-userid="${r.userId}">
                            <div class="w-12 h-12 rounded-full overflow-hidden bg-[#2a3942] flex items-center justify-center shrink-0">
                                <img src="${r.avatar}" class="w-full h-full object-cover">
                            </div>
                            <div class="ml-3 flex-1 border-b border-[#202c33] pb-3 pt-1 min-w-0 pr-6 relative">
                                <div class="flex justify-between items-center">
                                    <h4 class="text-[16px] text-[#e9edef] truncate mr-2 font-normal">${r.name}</h4>
                                    <span class="text-[12px] text-[#8696a0] whitespace-nowrap">${timeStr}</span>
                                </div>
                                <p class="text-[14px] text-[#8696a0] truncate mt-0.5 leading-snug">${prefix}${highlightedMsg}</p>
                            </div>
                            <!-- Dropdown Trigger Button with Gradient Overlay -->
                            <div class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-[#202c33] via-[#202c33] to-transparent hidden group-hover:flex items-center justify-end pr-3 z-20 options-btn-gradient">
                                <button onclick="event.stopPropagation(); window.toggleUserContextMenu(event, ${r.userId}, '${r.name.replace(/'/g, "\\'")}', 'user')"
                                    class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none">
                                    <svg viewBox="0 0 19 20" width="19" height="20" fill="currentColor">
                                        <path d="M3.8 6.7l5.7 5.7 5.7-5.7 1.6 1.6-7.3 7.2-7.3-7.2 1.6-1.6z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    `);
                }
            }
        });

        const msgMatches = allMsgResults.length;

        // Toggle section visibility
        if (chatsSection) {
            if (chatMatches > 0) {
                chatsSection.classList.remove('hidden');
            } else {
                chatsSection.classList.add('hidden');
            }
        }
        if (msgsSection) {
            if (msgMatches > 0) {
                msgsSection.classList.remove('hidden');
            } else {
                msgsSection.classList.add('hidden');
            }
        }

        // No results at all
        if (noResults) {
            if (chatMatches === 0 && msgMatches === 0) {
                noResults.classList.remove('hidden');
                noResults.classList.add('flex');
            } else {
                noResults.classList.add('hidden');
                noResults.classList.remove('flex');
            }
        }
    };

    // Object.defineProperty to override window.filterSidebar and prevent overwrites
    if (Object.getOwnPropertyDescriptor(window, 'filterSidebar')?.configurable !== false) {
        Object.defineProperty(window, 'filterSidebar', {
            get: function() {
                return customFilterSidebar;
            },
            set: function(val) {
                if (val !== customFilterSidebar && typeof val === 'function') {
                    window._originalFilterSidebar = val;
                }
            },
            configurable: true
        });
    }

    // Override showToast to handle group chat navigation
    (function() {
        const originalShowToast = window.showToast;
        window.showToast = function(title, body, otherUserId = null, otherName = null) {
            if (otherUserId && otherUserId.toString().startsWith('group_')) {
                const groupId = 'group_' + otherUserId.toString().replace('group_', '');
                const container = document.getElementById('toast_container');
                const id = Date.now();

                // For groups, we use selectGroupChat instead of selectChat
                const clickAttr =
                    `onclick="window.selectGroupChat('${groupId}', '${otherName.replace(/'/g, "\\'")}', ''); this.remove();"`;

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

    window.selectGroupChat = function(groupId, name, avatar, searchMsgTime = null) {
        const elementId = `group_sidebar_${groupId}`;
        if (window.hiddenChats && window.hiddenChats.includes(elementId)) {
            window.promptHiddenChatClickUnlock(function() {
                window.selectGroupChatOriginal(groupId, name, avatar, searchMsgTime);
            });
        } else {
            window.selectGroupChatOriginal(groupId, name, avatar, searchMsgTime);
        }
    };

    window.selectGroupChatOriginal = function(groupId, name, avatar, searchMsgTime = null) {
        const commSidebar = document.getElementById('communities_sidebar_container');
        const isCommSidebarActive = commSidebar && !commSidebar.classList.contains('hidden');

        if (isCommSidebarActive) {
            const commMain = document.getElementById('communities_main_column');
            if (commMain) {
                commMain.classList.add('hidden');
                commMain.classList.remove('flex');
            }
            const chatContainer = document.getElementById('chat_view_container');
            if (chatContainer) {
                chatContainer.classList.remove('hidden');
                chatContainer.classList.add('flex');
            }
        } else {
            if (typeof window.showChats === 'function') {
                window.showChats();
            }
        }
        if (typeof window.closeAllSearchPanels === 'function') {
            window.closeAllSearchPanels();
        }
        if (typeof window.closeContactInfo === 'function') {
            window.closeContactInfo();
        }
        if (typeof window.closeGroupInfoPanel === 'function') {
            window.closeGroupInfoPanel();
        }
        if (typeof window.closeBroadcastInfo === 'function') {
            window.closeBroadcastInfo();
        }
        // Fetch missing info from DOM
        const sidebarEl = document.getElementById(`group_sidebar_${groupId}`);
        if (sidebarEl) {
            if (!name || name === 'undefined') name = sidebarEl.getAttribute('data-name');
            if (!avatar || avatar === 'undefined') avatar = sidebarEl.getAttribute('data-avatar');
        }

        // Highlight selected group item in sidebar
        document.querySelectorAll('.user-chat-item').forEach(el => {
            el.classList.remove('active');
            if (el.getAttribute('id') === `group_sidebar_${groupId}` || el.getAttribute('data-groupid') ===
                groupId) {
                el.classList.add('active');
            }
        });

        const msgInput = document.getElementById('group_msg') || document.getElementById('msg');
        if (msgInput) {
            msgInput.disabled = false;
            msgInput.placeholder = "Type a message";
        }

        window.get(window.ref(window.db, 'groups/' + groupId)).then((snapshot) => {
            const group = snapshot.val();

            // Clear any old welcome card first
            const oldCard = document.getElementById('community_welcome_card');
            if (oldCard) oldCard.remove();

            if (group && (group.is_announcement === true || group.is_general === true)) {
                const adminsList = group.admins || [];
                const isCurrentUserAdmin = adminsList.includes(window.myUserId) || adminsList.includes(
                        parseInt(window.myUserId)) || adminsList.includes(String(window.myUserId)) ||
                    String(group.createdBy) === String(window.myUserId);

                const addMembersBtnHtml = isCurrentUserAdmin ? `
                    <button onclick="window.openAddGroupMembersModal()" class="mt-4 flex items-center justify-center gap-2 border border-[#00a884] hover:bg-[#00a884]/10 text-[#00a884] font-semibold px-6 py-2 rounded-full transition-all duration-200 focus:outline-none cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Add members
                    </button>
                ` : '';

                let cardIconHtml = '';
                let cardTitle = '';
                let cardSubtitle = '';

                if (group.is_announcement === true) {
                    cardIconHtml = `
                        <div class="w-16 h-16 rounded-2xl bg-[#3d302b] flex items-center justify-center text-[#ff8e6e] mb-4 shadow-inner">
                            <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    `;
                    cardTitle = 'Welcome to your community!';
                    cardSubtitle =
                        'Use this chat to send important admin announcements to all your members at once.';
                } else {
                    cardIconHtml = `
                        <div class="w-16 h-16 rounded-full bg-[#3d4b53] flex items-center justify-center text-[#e9edef] mb-4 shadow-inner">
                            <svg class="w-9 h-9" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6V9zm0-3h12v2H6V6zm0 6h7v2H6v-2z"/>
                            </svg>
                        </div>
                    `;
                    cardTitle = `Welcome to the group: ${group.name}`;
                    cardSubtitle = 'All community members can use this chat to talk with each other';
                }

                const welcomeCardHtml = `
                    <div id="community_welcome_card" class="flex flex-col items-center justify-center p-6 mx-auto my-6 max-w-sm bg-[#1f2c34] rounded-2xl border border-white/5 text-center shadow-lg">
                        ${cardIconHtml}
                        <h3 class="text-[#e9edef] text-[18px] font-bold mb-2">${cardTitle}</h3>
                        <p class="text-[#8696a0] text-sm leading-relaxed max-w-[280px]">${cardSubtitle}</p>
                        ${addMembersBtnHtml}
                    </div>
                `;
                const gMsgs = document.getElementById('group_messages');
                if (gMsgs) gMsgs.insertAdjacentHTML('afterbegin', welcomeCardHtml);
            }

            // Listen for group metadata (pinned msgs, member count, etc)
            const groupRef = window.ref(window.db, 'groups/' + groupId);
            window.onValue(groupRef, (snap) => {
                const gData = snap.val();
                if (!gData) return;
                window.currentGroupData = gData;

                // Hide call button for announcement groups
                const callBtn = document.getElementById('group_call_btn_pill');
                if (callBtn) {
                    if (gData.is_announcement === true) {
                        callBtn.classList.add('hidden');
                        callBtn.classList.remove('sm:flex');
                    } else {
                        callBtn.classList.remove('hidden');
                        callBtn.classList.add('sm:flex');
                    }
                }

                // Show community button if part of a community
                const commBtn = document.getElementById('group_community_btn');
                if (commBtn) {
                    if (gData.community_id) {
                        commBtn.classList.remove('hidden');
                    } else {
                        commBtn.classList.add('hidden');
                    }
                }

                // Dynamic Name, Member Count & Users List
                if (gData.name) {
                    const titleEl = document.getElementById('active_group_chat_title');
                    const infoNameEl = document.getElementById('group_info_name');
                    if (titleEl) titleEl.textContent = gData.name;
                    if (infoNameEl) infoNameEl.textContent = gData.name;
                    if (window.activeChatUser) window.activeChatUser.name = gData.name;
                    window.activeChatName = gData.name;
                    document.getElementById('active_chat_title').textContent = gData.name;
                }

                if (gData.avatar) {
                    window.activeChatAvatar = gData.avatar;
                    if (window.activeChatUser) window.activeChatUser.avatar = gData.avatar;
                    const avatarEl = document.getElementById('active_group_chat_avatar');
                    if (avatarEl) avatarEl.innerHTML =
                        `<img src="${gData.avatar}" class="w-full h-full object-cover">`;
                    const infoAvatarEl = document.getElementById('group_info_avatar');
                    if (infoAvatarEl) infoAvatarEl.src = gData.avatar;
                } else if (gData.name) {
                    const fallbackAvatar =
                        `https://ui-avatars.com/api/?name=${encodeURIComponent(gData.name)}&background=202c33&color=fff`;
                    window.activeChatAvatar = fallbackAvatar;
                    if (window.activeChatUser) window.activeChatUser.avatar = fallbackAvatar;
                    const avatarEl = document.getElementById('active_group_chat_avatar');
                    if (avatarEl) avatarEl.innerHTML =
                        `<img src="${fallbackAvatar}" class="w-full h-full object-cover">`;
                    const infoAvatarEl = document.getElementById('group_info_avatar');
                    if (infoAvatarEl) infoAvatarEl.src = fallbackAvatar;
                }

                let uList = [];
                if (gData.users) {
                    uList = Array.isArray(gData.users) ? gData.users : Object.values(gData.users);
                }
                const memberCount = uList.length;
                window.currentGroupMembersCount = memberCount;

                if (gData.users && window.activeChatUser) {
                    window.activeChatUser.users = uList.map(uid => {
                        const contact = window.allContacts ? window.allContacts.find(c =>
                            String(c.id) === String(uid)) : null;
                        return {
                            id: uid,
                            name: contact ? (contact.name || contact.phone) : (String(
                                uid) === String(window.myUserId) ? 'You' : 'Member'),
                            phone: contact ? contact.phone : '',
                            avatar: contact ? contact.avatar : ''
                        };
                    });
                }

                const subtitle = document.getElementById('active_group_chat_subtitle');
                if (subtitle) subtitle.textContent = memberCount + ' members';

                const infoCount = document.getElementById('group_members_count');
                if (infoCount) infoCount.textContent = memberCount + ' members';

                const infoPill = document.getElementById('group_info_member_count_pill');
                if (infoPill) infoPill.textContent = memberCount + ' members';

                if (gData.is_announcement === true && gData.community_id) {
                    if (subtitle) subtitle.textContent = 'Announcements';
                    if (infoCount) infoCount.textContent = 'Announcements';
                    if (infoPill) infoPill.textContent = 'Announcements';
                    
                    window.get(window.ref(window.db, 'communities/' + gData.community_id)).then((cSnap) => {
                        const cData = cSnap.val();
                        if (cData && cData.name) {
                            const titleEl = document.getElementById('active_group_chat_title');
                            if (titleEl) titleEl.textContent = cData.name;
                            
                            const infoNameEl = document.getElementById('group_info_name');
                            if (infoNameEl) infoNameEl.textContent = cData.name;
                            
                            window.activeChatName = cData.name;
                            if (window.activeChatUser) window.activeChatUser.name = cData.name;
                            
                            if (cData.avatar) {
                                const avatarEl = document.getElementById('active_group_chat_avatar');
                                if (avatarEl) avatarEl.innerHTML = `<img src="${cData.avatar}" class="w-full h-full object-cover">`;
                                const infoAvatarEl = document.getElementById('group_info_avatar');
                                if (infoAvatarEl) infoAvatarEl.src = cData.avatar;
                                window.activeChatAvatar = cData.avatar;
                                if (window.activeChatUser) window.activeChatUser.avatar = cData.avatar;
                            }
                        }
                    });
                }

                const pinBar = document.getElementById('group_pinned_bar');
                const pinText = document.getElementById('group_pinned_text');
                const pinCount = document.getElementById('group_pinned_count');

                // Multi-pin support
                window._groupPinnedMsgKeys = new Set();
                window._groupPinnedMsgsList = [];
                window._currentGroupPinIndex = 0;

                if (gData.pinned_msgs && typeof gData.pinned_msgs === 'object') {
                    for (const [key, val] of Object.entries(gData.pinned_msgs)) {
                        window._groupPinnedMsgKeys.add(key);
                        window._groupPinnedMsgsList.push({
                            key,
                            text: val.text,
                            time: val.time || 0
                        });
                    }
                    window._groupPinnedMsgsList.sort((a, b) => b.time - a.time);

                    if (pinBar && pinText && pinCount) {
                        const count = window._groupPinnedMsgsList.length;
                        pinCount.textContent = count === 1 ? '1 pinned message' :
                            `${count} pinned messages`;
                        pinText.textContent = window._groupPinnedMsgsList[0].text;
                        pinBar.classList.remove('hidden');
                    }
                } else if (pinBar) {
                    pinBar.classList.add('hidden');
                }

                // Update pin icons on message bubbles
                if (typeof window.updateGroupPinIcons === 'function') window.updateGroupPinIcons();

                // Real-time Description Update
                const descEl = document.getElementById('group_info_description');
                if (descEl) {
                    if (gData.description) {
                        descEl.textContent = gData.description;
                        descEl.classList.remove('text-[#00a884]');
                        descEl.classList.add('text-[#8696a0]');
                    } else {
                        descEl.textContent = "Add group description";
                        descEl.classList.add('text-[#00a884]');
                        descEl.classList.remove('text-[#8696a0]');
                    }
                }

                // Render group members using the new helper function
                if (window.renderGroupInfoMembers) {
                    window.renderGroupInfoMembers(gData);
                }
                const settingsPanel = document.getElementById('group_info_settings_panel');
                if (settingsPanel && !settingsPanel.classList.contains('hidden') && window
                    .updateGroupInfoSettingsUI) {
                    window.updateGroupInfoSettingsUI(gData);
                }

                // Dynamic input control
                const myUidStr = String(window.myUserId);
                let uListForCheck = [];
                if (gData.users) {
                    uListForCheck = Array.isArray(gData.users) ? gData.users : Object.values(gData
                        .users);
                }
                const isStillMember = uListForCheck.includes(myUidStr) || uListForCheck.includes(
                    parseInt(myUidStr));

                if (!isStillMember) {
                    const msgInput = document.getElementById('group_msg') || document
                        .getElementById('msg');
                    if (msgInput) {
                        msgInput.disabled = true;
                        msgInput.placeholder = "You are no longer a participant of this group.";
                    }
                    window.closeGroupInfoPanel();
                } else {
                    const adminsList = gData.admins || [];
                    const isCurrentUserAdmin = adminsList.includes(myUidStr) || adminsList.includes(
                        parseInt(myUidStr)) || adminsList.includes(String(myUidStr)) || String(
                        gData.createdBy) === String(myUidStr);
                    const canSend = gData.permissions ? gData.permissions.sendMessages !== false :
                        true;

                    const msgInput = document.getElementById('group_msg') || document
                        .getElementById('msg');
                    const emojiBtn = document.getElementById('group_emoji_toggle_btn');
                    const attachBtn = document.getElementById('group_attach_toggle_btn');
                    const actionBtn = document.getElementById('group_action_btn');
                    const insideMicBtn = document.getElementById('group_inside_mic_btn');

                    if (msgInput) {
                        if (!canSend && !isCurrentUserAdmin) {
                            msgInput.disabled = true;
                            if (gData.is_announcement === true) {
                                msgInput.placeholder =
                                    "You can reply to announcements, but only community admins can send them.";
                            } else {
                                msgInput.placeholder = "Only admins can send messages";
                            }
                            if (emojiBtn) emojiBtn.classList.add('hidden');
                            if (attachBtn) attachBtn.classList.add('hidden');
                            if (actionBtn) actionBtn.classList.add('hidden');
                            if (insideMicBtn) insideMicBtn.classList.add('hidden');
                        } else {
                            msgInput.disabled = false;
                            msgInput.placeholder = "Type a message";
                            if (emojiBtn) emojiBtn.classList.remove('hidden');
                            if (attachBtn) attachBtn.classList.remove('hidden');
                            if (actionBtn) actionBtn.classList.remove('hidden');
                            if (insideMicBtn) insideMicBtn.classList.remove('hidden');
                        }
                    }
                }
            });

            // Populate users for calling list
            if (group && group.users && window.activeChatUser) {
                let uList = Array.isArray(group.users) ? group.users : Object.values(group.users);
                window.activeChatUser.users = uList.map(uid => {
                    const contact = window.allContacts ? window.allContacts.find(c => String(c
                        .id) === String(uid)) : null;
                    return {
                        id: uid,
                        name: contact ? (contact.name || contact.phone) : (String(uid) === String(
                            window.myUserId) ? 'You' : 'Member'),
                        phone: contact ? contact.phone : '',
                        avatar: contact ? contact.avatar : ''
                    };
                });
            }

            // Mark existing messages as read
            if (window.globalMessages) {
                for (let key in window.globalMessages) {
                    const msg = window.globalMessages[key];
                    if (msg.sender_id != window.myUserId && (!msg.read_by || !msg.read_by[window
                            .myUserId])) {
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
        window.activeSearchQuery = (searchInput && searchInput.value.trim().length > 0) ? searchInput.value.trim()
            .toLowerCase() : null;
        window.activeSearchMsgTime = searchMsgTime || null;
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
        document.getElementById('meta_ai_content')?.classList.add('hidden');
        document.getElementById('meta_ai_content')?.classList.remove('flex');

        const gContent = document.getElementById('active_group_chat_content');
        if (gContent) {
            gContent.classList.remove('hidden');
            gContent.classList.add('flex');
        }

        if (window.closeAllSettings) {
            window.closeAllSettings();
        }

        if (window.innerWidth < 640) {
            const sidebarToHide = isCommSidebarActive ? 'communities_sidebar_container' : 'user_sidebar_container';
            const sEl = document.getElementById(sidebarToHide);
            if (sEl) {
                sEl.classList.add('hidden');
                sEl.classList.remove('flex', 'w-full');
            }
            document.getElementById('main_chat_column').classList.remove('hidden');
            document.getElementById('main_chat_column').classList.add('flex');
        }

        if (window.unsubscribeAdded) window.unsubscribeAdded();
        if (window.unsubscribeRemoved) window.unsubscribeRemoved();
        if (window.unsubscribeChanged) window.unsubscribeChanged();
        if (window.statusUnsubscribe) window.statusUnsubscribe();

        window.currentChatId = 'group_' + groupId.replace('group_', '');

        const activeName = name && name !== 'undefined' ? name : 'Group';
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
        const activeAvatar = avatar ||
            `https://ui-avatars.com/api/?name=${encodeURIComponent(activeName)}&background=202c33&color=fff`;
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
            document.getElementById('active_group_chat_avatar').innerHTML =
                `<img src="${activeAvatar}" class="w-full h-full object-cover">`;
        }

        document.getElementById('active_chat_title').textContent = activeName;
        const subtitle = document.getElementById('active_chat_subtitle');
        if (subtitle) {
            subtitle.textContent = 'Group chat';
            subtitle.classList.remove('hidden', 'text-green-600');
            subtitle.classList.add('text-gray-500');
        }

        document.getElementById('active_chat_avatar').innerHTML =
            `<img src="${activeAvatar}" class="w-full h-full object-cover">`;

        document.getElementById('call_dropdown_name').textContent = activeName;
        document.getElementById('call_dropdown_avatar').innerHTML =
            `<img src="${activeAvatar}" class="w-full h-full object-cover">`;

        const badge = document.getElementById(`group_unread_badge_${groupId}`);
        if (badge) {
            badge.textContent = '0';
            badge.classList.add('hidden');
            badge.classList.remove('flex');
        }

        const drawerBadge = document.getElementById(`community_drawer_unread_${groupId}`);
        if (drawerBadge) {
            drawerBadge.textContent = '0';
            drawerBadge.classList.add('hidden');
            drawerBadge.classList.remove('flex');
        }

        const sidebarBadge = document.getElementById(`sidebar_comm_unread_${groupId}`);
        if (sidebarBadge) {
            sidebarBadge.textContent = '0';
            sidebarBadge.classList.add('hidden');
            sidebarBadge.classList.remove('flex');
        }

        // If this is a community sub-group, recalculate parent community unread badge
        const groupEl = document.getElementById(`group_sidebar_${groupId}`);
        if (groupEl) {
            const communityId = groupEl.getAttribute('data-community-id');
            if (communityId) {
                if (typeof window.recalculateCommunityUnreadBadge === 'function') {
                    window.recalculateCommunityUnreadBadge(communityId);
                }
            }
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

            const elementId = `group_sidebar_${groupId}`;
            const clearedTime = window.clearedChats?.[elementId] || 0;
            if (data.time && data.time <= clearedTime) return;
            if (data.deleted_for && data.deleted_for[window.myUserId]) return;

            const key = snapshot.key;
            window.globalMessages[key] = data;

            // Check if this is the specific searched message (by timestamp)
            const isSearchMatch = window.activeSearchMsgTime && data.time && data.time == window
                .activeSearchMsgTime;
            const searchHighlightClass = isSearchMatch ? 'search-msg-highlight' : '';

            // Intercept special community welcome/added cards and system messages
            if (data.type === 'group_link_announcement') {
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

                const msgHtml = `
                    <div id="msg_${key}" class="flex justify-center my-3 relative select-none w-full">
                        <div class="bg-[#182229]/90 backdrop-blur-sm text-[#8696a0] text-[12.5px] px-3.5 py-1.5 rounded-lg shadow-sm font-normal text-center max-w-[85%] border border-[#202c33]">
                            ${data.text}
                        </div>
                    </div>`;

                const gMsgs = document.getElementById('group_messages');
                if (gMsgs) {
                    gMsgs.insertAdjacentHTML('beforeend', msgHtml);
                    gMsgs.scrollTop = gMsgs.scrollHeight;
                }
                return;
            }

            if (data.type === 'community_added' || data.type === 'welcome_announcement') {
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

                let cardHtml = '';
                if (data.type === 'community_added') {
                    const groupAvatar = window.activeGroupChatAvatar || '';
                    const isMe = data.sender_id == window.myUserId;
                    const senderName = isMe ? 'You' : (data.sender_name || 'Admin');

                    const groupAvatarHtml = groupAvatar
                        ? `<img src="${groupAvatar}" class="w-full h-full object-cover">`
                        : `<div class="w-full h-full bg-[#3d3025] flex items-center justify-center text-gray-400">
                             <svg class="w-8 h-8 text-[#a98a6c]" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                           </div>`;

                    const communityAvatarHtml = `<div class="w-full h-full bg-[#2b2520] flex items-center justify-center text-red-300">
                        <svg viewBox="0 0 24 24" width="32" height="32" class="text-[#a96c6c]" fill="currentColor">
                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                        </svg>
                    </div>`;

                    cardHtml = `
                        <div id="msg_${key}" class="flex justify-center my-4 relative select-none w-full px-4">
                            <div class="bg-[#1f2c34] text-[#e9edef] rounded-2xl p-6 shadow-xl w-full max-w-[360px] border border-white/5 flex flex-col items-center">
                                <!-- Icons Row -->
                                <div class="flex items-center justify-center gap-5 mb-5">
                                    <div class="w-14 h-14 rounded-full bg-[#2a2421] flex items-center justify-center border border-white/5 overflow-hidden shrink-0">
                                        ${groupAvatarHtml}
                                    </div>
                                    <span class="text-xl text-[#8696a0]">→</span>
                                    <div class="w-14 h-14 rounded-2xl bg-[#241e21] flex items-center justify-center border border-white/5 overflow-hidden shrink-0">
                                        ${communityAvatarHtml}
                                    </div>
                                </div>
                                <!-- Title -->
                                <h4 class="text-[17px] text-[#e9edef] font-semibold text-center mb-4 leading-snug">
                                    ${senderName} added this group to the community: ${data.community_name || 'Community'}
                                </h4>
                                <!-- Bullets -->
                                <ul class="text-[13.5px] text-[#8696a0] space-y-2 mb-6 w-full px-2 list-inside list-disc">
                                    <li>Members in this group are now community members</li>
                                    <li>Anyone in the community can join this group</li>
                                </ul>
                                <!-- Buttons -->
                                <div class="flex flex-col gap-2.5 w-full">
                                    <button onclick="window.handleManageCommunityClick('${data.community_id}')"
                                        class="w-full py-2.5 rounded-full border border-[#313d45] hover:bg-[#202c33] text-[#00a884] font-semibold text-sm transition-colors text-center">
                                        Manage community
                                    </button>
                                    <button onclick="window.handleAddDescriptionClick('${data.community_id}')"
                                        class="w-full py-2.5 rounded-full border border-[#313d45] hover:bg-[#202c33] text-[#00a884] font-semibold text-sm transition-colors text-center">
                                        Add description...
                                    </button>
                                </div>
                            </div>
                        </div>`;
                } else if (data.type === 'welcome_announcement') {
                    const isMe = data.sender_id == window.myUserId;
                    const senderName = isMe ? 'You' : (data.sender_name || 'Admin');

                    const communitySquareIcon = `<svg viewBox="0 0 24 24" width="36" height="36" class="text-[#a98a6c]" fill="currentColor">
                        <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                    </svg>`;

                    cardHtml = `
                        <div id="msg_${key}" class="flex justify-center my-4 relative select-none w-full px-4">
                            <div class="bg-[#1f2c34] text-[#e9edef] rounded-2xl p-6 shadow-xl w-full max-w-[360px] border border-white/5 flex flex-col items-center">
                                <!-- Square Community Icon -->
                                <div class="w-16 h-16 rounded-2xl bg-[#2a2421] flex items-center justify-center border border-white/5 mb-4 shrink-0">
                                    ${communitySquareIcon}
                                </div>
                                <!-- Title -->
                                <h3 class="text-[18px] text-[#e9edef] font-semibold text-center mb-3 leading-snug">
                                    Welcome to the community!
                                </h3>
                                <!-- Bullets -->
                                <ul class="text-[13.5px] text-[#8696a0] space-y-2 mb-6 w-full px-2 list-inside list-disc">
                                    <li>${senderName} added you</li>
                                    <li>Admins will send everyone important community announcements here</li>
                                </ul>
                                <!-- Buttons -->
                                <div class="w-full">
                                    <button onclick="window.handleManageCommunityClick('${data.community_id}')"
                                        class="w-full py-2.5 rounded-full border border-[#313d45] hover:bg-[#202c33] text-[#00a884] font-semibold text-sm transition-colors text-center">
                                        See community info
                                    </button>
                                </div>
                            </div>
                        </div>`;
                }

                const gMsgs = document.getElementById('group_messages');
                if (gMsgs) {
                    gMsgs.insertAdjacentHTML('beforeend', cardHtml);
                    gMsgs.scrollTop = gMsgs.scrollHeight;
                }
                return;
            }

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
            const time = new Date(data.time * 1000).toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });

            let mediaContent = '';
            if (data.type === 'image' && data.file_url) {
                mediaContent =
                    `<img src="${data.file_url}" class="max-w-[200px] sm:max-w-xs rounded-lg mb-2 object-cover cursor-pointer hover:opacity-90" onclick="window.open('${data.file_url}', '_blank')">`;
            } else if (data.type === 'video' && data.file_url) {
                mediaContent =
                    `<video src="${data.file_url}" controls class="max-w-[200px] sm:max-w-xs rounded-lg mb-2"></video>`;
            } else if (data.type === 'audio' && data.file_url) {
                mediaContent =
                    `<audio src="${data.file_url}" controls class="max-w-[200px] sm:max-w-xs mb-2"></audio>`;
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
            } else if ((data.type === 'location' || data.type === 'live_location') && data.lat && data
                .lng) {
                const lat = parseFloat(data.lat);
                const lng = parseFloat(data.lng);
                const isLive = data.type === 'live_location';

                mediaContent = `
                    <div class="mb-2 relative rounded-lg overflow-hidden border border-gray-200 w-[250px] max-w-[100%] h-[150px] bg-gray-100 flex items-center justify-center">
                        <iframe width="100%" height="150" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.openstreetmap.org/export/embed.html?bbox=${lng - 0.005}%2C${lat - 0.005}%2C${lng + 0.005}%2C${lat + 0.005}&amp;layer=mapnik&amp;marker=${lat}%2C${lng}" class="w-full absolute inset-0 pointer-events-none opacity-80"></iframe>

                        <div class="z-20 relative flex flex-col items-center">
                            ${isLive ? `
                                <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur border border-white/50 flex flex-col items-center justify-center overflow-hidden relative shadow-lg">
                                    <div class="absolute inset-0 bg-[#1dae75] rounded-full animate-ping opacity-70"></div>
                                    <div class="w-10 h-10 rounded-full bg-[#202c33] border-2 border-[#1dae75] flex items-center justify-center text-white font-bold text-lg relative z-10">
                                        {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
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
                                <span class="font-medium truncate max-w-[150px] text-left">${isLive ? 'Live location' : 'Location'}</span>
                                <span class="text-[#008069] uppercase tracking-wider text-[10px] font-semibold">View map</span>
                            </div>
                        </a>
                    </div>`;

                if (isLive && data.duration) {
                    const endTime = new Date((data.time + data.duration * 60) * 1000);
                    const diff = endTime - new Date();
                    const statusText = diff > 0 ?
                        `Live until ${endTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}` :
                        'Live location ended';
                    mediaContent +=
                        `<div class="text-xs text-gray-500 mb-1 italic px-1">${statusText}</div>`;
                }
            } else if (data.type === 'scheduled_call') {
                const startStr = new Date(data.start_time * 1000).toLocaleString([], {
                    weekday: 'short',
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                const isVideo = data.call_type === 'video';
                const approvalParam = data.require_approval ? '&require_approval=true' : '';
                const callLink =
                    `${window.location.origin}/chat/groups/${data.call_type}-call?group_call_id=${data.group_call_id}&name=${encodeURIComponent(data.call_name)}${approvalParam}`;

                mediaContent = `
                    <div class="mb-2 relative rounded-2xl overflow-hidden border border-white/5 bg-[#1f2c34] w-[270px] max-w-[100%] shadow-lg p-4 text-[#e9edef] font-['Inter']">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#202c33] flex items-center justify-center text-[#00a884] shrink-0 border border-white/5">
                                ${isVideo ? `
                                    <svg class="w-5 h-5 text-[#00a884]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                ` : `
                                    <svg class="w-5 h-5 text-[#00a884]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                `}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-[15px] font-semibold truncate leading-tight">${data.call_name}</div>
                                <div class="text-[12px] text-[#8696a0] mt-1">${startStr}</div>
                                ${data.description ? `<div class="text-xs text-[#8696a0] mt-2 italic line-clamp-2">${data.description}</div>` : ''}
                            </div>
                        </div>
                        <div class="mt-4 flex gap-2 pt-3 border-t border-white/5">
                            <button onclick="window.open('${callLink}', '_blank')" class="flex-1 bg-[#00a884] hover:bg-[#06cf9c] text-[#111b21] py-2 rounded-xl text-center text-sm font-bold transition-all active:scale-[0.98] focus:outline-none">
                                Join call
                            </button>
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
                let borderColor = (rSenderName === "You" || rIsMe) ? 'border-[#ea005e]' :
                    'border-[#00a884]';

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
                    if (d >= 3600) durationText = Math.floor(d / 3600) + ' hr ' + Math.floor((d % 3600) /
                        60) + ' min';
                    else if (d >= 60) durationText = Math.floor(d / 60) + ' min';
                    else durationText = d + ' secs';
                } else if (isMissed) durationText = 'Missed';
                else if (isNoAnswer) durationText = 'No answer';

                const iconColor = isMissed ? '#ef4444' : (isMe ? '#00a884' : '#8696a0');
                const callIcon = isVoice ?
                    `<svg class="w-5 h-5" fill="${iconColor}" viewBox="0 0 24 24"><path d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z"/></svg>` :
                    `<svg class="w-5 h-5" fill="${iconColor}" viewBox="0 0 24 24"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>`;

                const callLabel = isVoice ? 'Voice call' : 'Video call';
                const callTitle = isMissed ? (isVoice ? 'Missed voice call' : 'Missed video call') :
                    callLabel;

                const tapAction = isMissed && !isMe ?
                    `onclick="event.stopPropagation(); ${isVoice ? 'window.startGroupVoiceCall()' : 'window.startGroupVideoCall()'}" style="cursor:pointer"` :
                    '';

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
                    senderAvatar = matchUser.avatar ||
                        `https://ui-avatars.com/api/?name=${encodeURIComponent(senderDisplayName.charAt(0))}&background=2a3942&color=fff`;
                } else {
                    senderAvatar =
                        `https://ui-avatars.com/api/?name=${encodeURIComponent(senderDisplayName.charAt(0))}&background=2a3942&color=fff`;
                }
            } else {
                senderAvatar =
                    `https://ui-avatars.com/api/?name=${encodeURIComponent(senderDisplayName.charAt(0))}&background=2a3942&color=fff`;
            }

            const msgHtml = `
                <div id="msg_${key}" onclick="window.toggleGroupMsgSelection('${key}')" class="flex ${isMe ? 'justify-end' : 'justify-start'} mb-2 px-4 group/msg relative gap-2 items-start group/bubble-container cursor-default ${searchHighlightClass}">
                    <!-- Selection Checkbox -->
                    ${data.type !== 'call' ? `
                    <div class="msg-checkbox-container hidden shrink-0 self-center mr-2">
                        <div class="w-5 h-5 rounded border-2 border-gray-400 bg-white flex items-center justify-center transition-all">
                            <input type="checkbox" id="checkbox_${key}" class="msg-checkbox hidden">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                    ` : ''}

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

                        ${(!isMe || (window.currentGroupData && window.currentGroupData.is_announcement)) ? (() => {
                            const adminsList = window.currentGroupData?.admins || [];
                            const isSenderAdmin = adminsList.includes(data.sender_id) || adminsList.includes(parseInt(data.sender_id)) || adminsList.includes(String(data.sender_id)) || String(window.currentGroupData?.createdBy) === String(data.sender_id);
                            const badgeHtml = (window.currentGroupData?.is_announcement && isSenderAdmin)
                                ? `<span class="bg-[#00a884]/20 text-[#00a884] text-[9.5px] font-bold px-1.5 py-0.5 rounded ml-2 border border-[#00a884]/30">Community admin</span>`
                                : '';
                            return `<div class="text-[#25d366] text-[12.5px] font-semibold mb-0.5 leading-tight pr-6 flex items-center flex-wrap gap-1">${senderDisplayName}${badgeHtml}</div>`;
                        })() : ''}

                        ${replyPreviewHtml}
                        ${mediaContent}

                        ${msgText ? (() => {
                            const callLink = window.parseCallLink(data.text || msgText);
                            if (callLink) {
                                return window.renderCallLinkHTML(callLink.url, callLink.type, isMe);
                            }
                            const htmlText = window.wrapEmojis ? window.wrapEmojis(msgText) : msgText;
                            const finalHtmlText = window.linkifyText ? window.linkifyText(htmlText) : htmlText;
                            return `<div class="text-[14.2px] text-[#e9edef] leading-relaxed break-words pb-[2px]" style="white-space: pre-wrap; word-break: break-word;">${finalHtmlText}<span class="inline-block w-[99px] h-[1px]"></span></div>`;
                        })() : ''}

                        <div class="flex items-center justify-end gap-1 absolute bottom-0.5 right-2 bg-transparent">
                            <span id="star_icon_${key}" class="hidden shrink-0"><svg viewBox="0 0 24 24" width="14" height="14" fill="#8696a0"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></span>
                            <span id="pin_icon_${key}" class="hidden shrink-0"><svg viewBox="0 0 24 24" width="14" height="14" fill="#8696a0"><path d="M16 9V4l1 0c.55 0 1-.45 1-1s-.45-1-1-1H7c-.55 0-1 .45-1 1s.45 1 1 1l1 0v5c0 1.66-1.34 3-3 3v2h5.97v7l1 1 1-1v-7H19v-2c-1.66 0-3-1.34-3-3z"/></svg></span>
                            ${data.is_edited ? `<span class="edited-label text-[10px] text-[#8696a0] select-none italic mr-0.5">Edited</span>` : ''}
                            <span class="text-[11px] text-[#8696a0] select-none leading-none">${time}</span>
                            ${isMe ? `
                                <span id="status_icon_${key}" class="shrink-0 flex items-center justify-center leading-none">
                                    ${window.getGroupTickSVG(getMsgGroupStatus(data))}
                                </span>` : ''}
                        </div>
                        <div id="reactions_${key}" class="hidden"></div>
                    </div>
                </div>`;

            const gMsgs = document.getElementById('group_messages');
            if (gMsgs) {
                gMsgs.insertAdjacentHTML('beforeend', msgHtml);

                if (data.reactions) window.renderReactions(key, data.reactions, isMe);

                if (window.starredMsgKeys && window.starredMsgKeys.has(key)) {
                    const sIcon = document.getElementById('star_icon_' + key);
                    if (sIcon) sIcon.classList.remove('hidden');
                }

                // If search is active, scroll to first matching message; otherwise scroll to bottom
                if (isSearchMatch && !window._searchScrolled) {
                    window._searchScrolled = true;
                    setTimeout(() => {
                        const firstMatch = gMsgs.querySelector('.search-msg-highlight');
                        if (firstMatch) {
                            firstMatch.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }
                    }, 500);
                } else if (!window.activeSearchQuery) {
                    gMsgs.scrollTop = gMsgs.scrollHeight;
                }
            }

            if (window._mediaListTimeout) clearTimeout(window._mediaListTimeout);
            window._mediaListTimeout = setTimeout(() => {
                if (typeof window.updateGroupInfoMediaList === 'function') {
                    window.updateGroupInfoMediaList();
                }
                const libModal = document.getElementById('group_media_library_modal');
                if (libModal && !libModal.classList.contains('hidden')) {
                    if (typeof window.openGroupMediaLibrary === 'function') {
                        window.openGroupMediaLibrary();
                    }
                }
            }, 100);
        });

        window.unsubscribeRemoved = window.onChildRemoved(messagesRef, (snapshot) => {
            const key = snapshot.key;
            const msgEl = document.getElementById('msg_' + key);
            if (msgEl) msgEl.remove();
            delete window.globalMessages[key];
            if (window.globalMediaCache) {
                window.globalMediaCache = window.globalMediaCache.filter(m => m.key !== key && !m.key
                    .startsWith(key + '_link_'));
            }
            if (window.updateContactInfoMediaSection) {
                window.updateContactInfoMediaSection();
            }
        });

        window.unsubscribeChanged = window.onChildChanged(messagesRef, (snapshot) => {
            const data = snapshot.val();
            const key = snapshot.key;

            if (data && data.deleted_for && data.deleted_for[window.myUserId]) {
                const msgEl = document.getElementById('msg_' + key);
                if (msgEl) msgEl.remove();
                delete window.globalMessages[key];
                if (window.globalMediaCache) {
                    window.globalMediaCache = window.globalMediaCache.filter(m => m.key !== key && !m.key
                        .startsWith(key + '_link_'));
                }
                if (window.updateContactInfoMediaSection) {
                    window.updateContactInfoMediaSection();
                }
                return;
            }

            const oldMsg = window.globalMessages[key];
            const oldReactions = oldMsg ? (oldMsg.reactions || {}) : {};
            const newReactions = data.reactions || {};

            window.globalMessages[key] = data;

            const isMe = data.sender_id == window.myUserId;
            if (isMe) {
                const statusEl = document.getElementById('status_icon_' + key);
                if (statusEl) {
                    statusEl.innerHTML = window.getGroupTickSVG(getMsgGroupStatus(data));
                }
            }

            // Update text if message was edited
            const bubbleEl = document.getElementById('bubble_' + key);
            if (bubbleEl) {
                const textDiv = bubbleEl.querySelector('.break-words');
                if (textDiv && data.text) {
                    const callLink = window.parseCallLink(data.text);
                    let newHtmlText = '';
                    if (callLink) {
                        newHtmlText = window.renderCallLinkHTML(callLink.url, callLink.type, isMe);
                    } else {
                        newHtmlText = (window.wrapEmojis ? window.wrapEmojis(data.text) : data.text) +
                            '<span class="inline-block w-[99px] h-[1px]"></span>';
                    }
                    textDiv.innerHTML = newHtmlText;
                }

                // Add Edited indicator if not present
                if (data.is_edited) {
                    const timeSpan = bubbleEl.querySelector('span.text-\\[11px\\]') || bubbleEl
                        .querySelector('span:not(.edited-label):not(#star_icon_' + key +
                            '):not(#pin_icon_' + key + '):not(#status_icon_' + key + ')');
                    if (timeSpan && !bubbleEl.querySelector('.edited-label')) {
                        timeSpan.insertAdjacentHTML('beforebegin',
                            '<span class="edited-label text-[10px] text-[#8696a0] select-none italic mr-0.5">Edited</span>'
                            );
                    }
                }
            }

            window.renderReactions(key, newReactions, isMe);

            // Notification for new reactions on MY messages
            if (isMe) {
                for (const [uid, emoji] of Object.entries(newReactions)) {
                    if (uid != window.myUserId && oldReactions[uid] !== emoji) {
                        const reactionKey = `${key}_${uid}_${emoji}`;
                        window.seenReactions = window.seenReactions || new Set();
                        if (!window.seenReactions.has(reactionKey)) {
                            window.seenReactions.add(reactionKey);
                            let reactorName = 'Someone';
                            if (window.allContacts) {
                                const contact = window.allContacts.find(c => c.id == uid);
                                if (contact) reactorName = contact.name || contact.phone;
                            }
                            const groupName = window.activeChatName || 'Group';
                            window.showToast('Reaction in ' + groupName,
                                `${reactorName} reacted: ${emoji}`);
                            if (Notification.permission === "granted" && document.visibilityState !==
                                'visible') {
                                new Notification(groupName, {
                                    body: `${reactorName} reacted: ${emoji}`
                                });
                            }
                        }
                    }
                }
            }

            if (window._mediaListTimeout) clearTimeout(window._mediaListTimeout);
            window._mediaListTimeout = setTimeout(() => {
                if (typeof window.updateGroupInfoMediaList === 'function') {
                    window.updateGroupInfoMediaList();
                }
                const libModal = document.getElementById('group_media_library_modal');
                if (libModal && !libModal.classList.contains('hidden')) {
                    if (typeof window.openGroupMediaLibrary === 'function') {
                        window.openGroupMediaLibrary();
                    }
                }
            }, 100);
        });

        // Tab Visibility for Group
        document.addEventListener("visibilitychange", () => {
            if (document.visibilityState === 'visible' && window.currentChatId && window.currentChatId
                .startsWith('group_')) {
                const gId = window.currentChatId;
                for (let key in window.globalMessages) {
                    let msg = window.globalMessages[key];
                    if (msg.sender_id != window.myUserId && (!msg.read_by || !msg.read_by[window
                            .myUserId])) {
                        window.update(window.ref(window.db, `groups/${gId}/messages/${key}/read_by`), {
                            [window.myUserId]: Math.floor(Date.now() / 1000)
                        });
                    }
                }
            }
        });
    };

    // --- ADD MEMBER MODAL LOGIC ---
    window._selectedAddMembers = new Set();

    window.openAddGroupMembersModal = function() {
        const modal = document.getElementById('add_group_member_modal');
        const listContainer = document.getElementById('add_member_list');
        const footer = document.getElementById('add_member_footer');
        const searchInput = document.getElementById('add_member_search');

        if (!modal || !listContainer) return;

        window._selectedAddMembers.clear();
        if (footer) footer.classList.add('hidden');
        if (searchInput) searchInput.value = '';

        const currentMembers = window.activeChatUser ? window.activeChatUser.users.map(u => String(u.id)) : [];
        const contactsToAdd = window.allContacts ? window.allContacts.filter(c => !currentMembers.includes(String(c
            .id))) : [];

        let html = '';
        if (contactsToAdd.length === 0) {
            html = `<div class="p-8 text-center text-[#8696a0] text-sm">No new contacts to add</div>`;
        } else {
            contactsToAdd.forEach(user => {
                const avatar = user.avatar ||
                    `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name || user.phone)}&background=2a3942&color=fff`;
                html += `
                    <div onclick="window.toggleAddMemberSelection('${user.id}')" class="flex items-center gap-4 p-3 hover:bg-[#2a3942]/60 rounded-xl cursor-pointer transition-all group/item add-member-item" data-name="${(user.name || user.phone).toLowerCase()}">
                        <div class="relative shrink-0">
                            <img src="${avatar}" class="w-12 h-12 rounded-full object-cover border border-white/5">
                            <div id="check_add_${user.id}" class="absolute -bottom-0.5 -right-0.5 w-5 h-5 bg-[#00a884] rounded-full border-2 border-[#222e35] flex items-center justify-center scale-0 transition-transform">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor" class="text-[#111b21]"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path></svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0 border-b border-white/5 group-last/item:border-none pb-3 pt-1 group-hover/item:border-transparent transition-colors">
                            <div class="text-[#e9edef] font-medium truncate">${user.name || user.phone}</div>
                            <div class="text-[#8696a0] text-sm truncate mt-0.5">${user.about || 'Available'}</div>
                        </div>
                    </div>`;
            });
        }

        listContainer.innerHTML = html;
        modal.classList.remove('hidden');
    };

    window.closeAddGroupMembersModal = function() {
        document.getElementById('add_group_member_modal')?.classList.add('hidden');
    };

    window.toggleAddMemberSelection = function(userId) {
        const check = document.getElementById('check_add_' + userId);
        if (!check) return;

        if (window._selectedAddMembers.has(userId)) {
            window._selectedAddMembers.delete(userId);
            check.classList.replace('scale-100', 'scale-0');
        } else {
            window._selectedAddMembers.add(userId);
            check.classList.replace('scale-0', 'scale-100');
        }

        const footer = document.getElementById('add_member_footer');
        const countSpan = document.getElementById('add_member_selected_count');

        if (window._selectedAddMembers.size > 0) {
            footer.classList.remove('hidden');
            countSpan.textContent = window._selectedAddMembers.size + ' selected';
        } else {
            footer.classList.add('hidden');
        }
    };

    window.filterAddMembers = function() {
        const term = document.getElementById('add_member_search').value.toLowerCase();
        const items = document.querySelectorAll('.add-member-item');
        items.forEach(item => {
            const name = item.getAttribute('data-name');
            item.style.display = name.includes(term) ? 'flex' : 'none';
        });
    };

    window.submitAddMembers = async function() {
        if (window._selectedAddMembers.size === 0 || !window.activeChatUser) return;

        const groupId = window.activeChatUser.id;
        const newMemberIds = Array.from(window._selectedAddMembers);

        try {
            const groupRef = window.ref(window.db, 'groups/' + groupId);
            const snapshot = await window.get(groupRef);
            const group = snapshot.val();

            if (group) {
                const currentUsers = group.users || [];
                let uList = Array.isArray(currentUsers) ? currentUsers : Object.values(currentUsers);
                const updatedUsers = [...new Set([...uList, ...newMemberIds])];

                await window.update(groupRef, {
                    users: updatedUsers
                });

                window.closeAddGroupMembersModal();
                // Refresh group info panel if open
                if (typeof window.openGroupInfoPanel === 'function') {
                    window.openGroupInfoPanel();
                }

                // Optional: Send a system message about new members
                // (logic for that can be added here if needed)
            }
        } catch (err) {
            console.error('Error adding members:', err);
            alert('Failed to add members. Please try again.');
        }
    };

    // --- EDIT GROUP NAME LOGIC ---
    window.startEditGroupName = function() {
        const viewContainer = document.getElementById('group_info_name_container');
        const editContainer = document.getElementById('group_info_name_edit_container');
        const nameInput = document.getElementById('group_info_name_input');
        const currentName = document.getElementById('group_info_name').textContent;

        if (viewContainer && editContainer && nameInput) {
            viewContainer.classList.add('hidden');
            viewContainer.classList.remove('flex');
            editContainer.classList.add('flex');
            editContainer.classList.remove('hidden');
            nameInput.value = currentName;
            nameInput.focus();
            nameInput.select();
        }
    };

    window.cancelEditGroupName = function() {
        const viewContainer = document.getElementById('group_info_name_container');
        const editContainer = document.getElementById('group_info_name_edit_container');

        if (viewContainer && editContainer) {
            editContainer.classList.add('hidden');
            editContainer.classList.remove('flex');
            viewContainer.classList.add('flex');
            viewContainer.classList.remove('hidden');
        }
    };

    window.saveGroupName = async function() {
        const nameInput = document.getElementById('group_info_name_input');
        const newName = nameInput ? nameInput.value.trim() : "";

        if (!newName || !window.activeChatUser) return;
        if (newName === document.getElementById('group_info_name').textContent) {
            window.cancelEditGroupName();
            return;
        }

        const groupId = window.activeChatUser.id;
        try {
            const groupRef = window.ref(window.db, 'groups/' + groupId);
            await window.update(groupRef, {
                name: newName
            });
            window.cancelEditGroupName();

            // Note: The UI for the title and group info will update automatically
            // via the real-time listener already present in selectGroupChat.
        } catch (err) {
            console.error('Error updating group name:', err);
            alert('Failed to update group name. Please try again.');
        }
    };

    // Support Enter to save, Escape to cancel
    document.getElementById('group_info_name_input')?.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') window.saveGroupName();
        if (e.key === 'Escape') window.cancelEditGroupName();
    });

    // --- EDIT GROUP DESCRIPTION LOGIC ---
    window.startEditGroupDescription = function() {
        const viewContainer = document.getElementById('group_info_description_container');
        const editContainer = document.getElementById('group_info_description_edit_container');
        const descInput = document.getElementById('group_info_description_input');
        const currentDescEl = document.getElementById('group_info_description');
        let currentDesc = currentDescEl.textContent;

        if (currentDesc === "Add group description") currentDesc = "";

        if (viewContainer && editContainer && descInput) {
            viewContainer.classList.add('hidden');
            editContainer.classList.add('flex');
            editContainer.classList.remove('hidden');
            descInput.value = currentDesc;
            descInput.focus();

            // Adjust height
            descInput.style.height = '';
            descInput.style.height = descInput.scrollHeight + 'px';
        }
    };

    window.cancelEditGroupDescription = function() {
        const viewContainer = document.getElementById('group_info_description_container');
        const editContainer = document.getElementById('group_info_description_edit_container');

        if (viewContainer && editContainer) {
            editContainer.classList.add('hidden');
            editContainer.classList.remove('flex');
            viewContainer.classList.remove('hidden');
        }
    };

    window.saveGroupDescription = async function() {
        const descInput = document.getElementById('group_info_description_input');
        const newDesc = descInput ? descInput.value.trim() : "";

        if (!window.activeChatUser) return;

        const currentDescEl = document.getElementById('group_info_description');
        let currentDesc = currentDescEl.textContent;
        if (currentDesc === "Add group description") currentDesc = "";

        if (newDesc === currentDesc) {
            window.cancelEditGroupDescription();
            return;
        }

        const groupId = window.activeChatUser.id;
        try {
            const groupRef = window.ref(window.db, 'groups/' + groupId);
            await window.update(groupRef, {
                description: newDesc
            });
            window.cancelEditGroupDescription();
        } catch (err) {
            console.error('Error updating group description:', err);
            alert('Failed to update group description.');
        }
    };

    // --- GROUP MEMBER LIST & PERMISSIONS HELPER FUNCTIONS ---
    window.renderGroupInfoMembers = function(group) {
        if (!group) return;
        const listEl = document.getElementById('group_members_list');
        const countEl = document.getElementById('group_members_count');
        if (!listEl) return;

        const usersList = Array.isArray(group.users) ? group.users : Object.values(group.users || {});
        if (countEl) countEl.textContent = usersList.length + ' members';

        // Check if current user is admin
        const myUidStr = String(window.myUserId);
        const adminsList = group.admins || [];
        const isCurrentUserAdmin = adminsList.includes(myUidStr) || adminsList.includes(parseInt(myUidStr)) ||
            adminsList.includes(String(myUidStr)) || (String(group.createdBy) === myUidStr);

        // Check if settings row should be displayed
        const settingsRow = document.getElementById('group_settings_info_row');
        if (settingsRow) {
            if (isCurrentUserAdmin) {
                settingsRow.classList.remove('hidden');
            } else {
                settingsRow.classList.add('hidden');
            }
        }

        // Show/Hide Add button in action row based on permissions
        const canAddMembers = isCurrentUserAdmin || (group.permissions ? group.permissions.addMembers !== false :
            true);

        // Toggle the edit buttons for name & description as well
        const canEditInfo = isCurrentUserAdmin || (group.permissions ? group.permissions.editSettings !== false :
            true);
        const nameEditBtn = document.querySelector('#group_info_name_container button');
        const descEditBtn = document.querySelector('#group_info_description_container button');
        if (nameEditBtn) {
            if (canEditInfo) {
                nameEditBtn.classList.remove('hidden');
            } else {
                nameEditBtn.classList.add('hidden');
            }
        }
        if (descEditBtn) {
            if (canEditInfo) {
                descEditBtn.classList.remove('hidden');
            } else {
                descEditBtn.classList.add('hidden');
            }
        }

        // Action Buttons Row Add button
        const actionAddBtn = document.querySelector('button[onclick="window.openAddGroupMembersModal()"]');
        if (actionAddBtn) {
            if (canAddMembers) {
                actionAddBtn.classList.remove('hidden');
                actionAddBtn.classList.add('flex-grow');
            } else {
                actionAddBtn.classList.add('hidden');
                actionAddBtn.classList.remove('flex-grow');
            }
        }

        let addMemberHtml = '';
        if (canAddMembers) {
            addMemberHtml = `
                <div class="flex items-center gap-4 py-3 hover:bg-[#202c33]/30 cursor-pointer transition-colors px-1" onclick="window.openAddGroupMembersModal()">
                    <div class="w-[44px] h-[44px] rounded-full bg-[#00a884] flex items-center justify-center text-white shrink-0">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                            <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                        </svg>
                    </div>
                    <span class="text-[#e9edef] text-[16px]">Add member</span>
                </div>
            `;
        }

        let membersHtml = '';
        usersList.forEach(userId => {
            let memberName = "Member";
            let memberAbout = "Available";
            let memberAvatar = "";
            let phone = "";

            const isThisMemberAdmin = adminsList.includes(userId) || adminsList.includes(parseInt(
                userId)) || adminsList.includes(String(userId)) || (String(group.createdBy) === String(
                    userId));
            const isAdminBadge = isThisMemberAdmin ?
                `<div class="border border-[#00a884]/40 bg-[#00a884]/10 rounded px-1.5 py-0.5 text-[11px] text-[#00a884]">Group admin</div>` :
                '';

            if (userId == window.myUserId) {
                memberName = "You";
                memberAbout = window.myUserAbout || "Available";
                memberAvatar = window.myUserAvatar ||
                    `https://ui-avatars.com/api/?name=You&background=2a3942&color=fff`;
                phone = window.myUserPhone || "";
            } else {
                const matchUser = window.allContacts ? window.allContacts.find(c => String(c.id) === String(
                    userId)) : null;
                if (matchUser) {
                    memberName = matchUser.name || matchUser.phone;
                    memberAbout = matchUser.about || "Available";
                    memberAvatar = window.getUserAvatar ? window.getUserAvatar(matchUser.id) : (matchUser
                        .avatar || "");
                    phone = matchUser.phone || "";
                }
                if (!memberAvatar) {
                    memberAvatar =
                        `https://ui-avatars.com/api/?name=${encodeURIComponent(memberName)}&background=2a3942&color=fff`;
                }
            }

            const clickHandler = (userId == window.myUserId) ? "" :
                `onclick="window.showGroupMemberMenu(event, '${userId}', '${memberName.replace(/'/g, "\\'")}', '${memberAvatar}', '${phone.replace(/'/g, "\\'")}', '${memberAbout.replace(/'/g, "\\'")}')"`;

            membersHtml += `
            <div ${clickHandler} class="flex items-center justify-between py-3 hover:bg-[#202c33]/30 cursor-pointer transition-colors px-1 rounded-lg">
                <div class="flex items-center gap-4 min-w-0">
                    <img src="${memberAvatar}" class="w-[44px] h-[44px] rounded-full object-cover shrink-0">
                    <div class="min-w-0 pr-2">
                        <div class="text-[#e9edef] text-[16px] truncate">${memberName}</div>
                        <div class="text-[#8696a0] text-[14px] truncate mt-0.5">${memberAbout}</div>
                    </div>
                </div>
                ${isAdminBadge}
            </div>`;
        });

        listEl.innerHTML = addMemberHtml + membersHtml;
    };

    window.showGroupMemberMenu = function(event, targetUserId, name, avatar, phone, about) {
        if (event) {
            event.stopPropagation();
            event.preventDefault();
        }

        const dropdown = document.getElementById('group_member_context_dropdown');
        if (!dropdown) return;

        const x = event.clientX;
        const y = event.clientY;

        const dropdownWidth = 192;
        const dropdownHeight = 200;
        const windowWidth = window.innerWidth;
        const windowHeight = window.innerHeight;

        let left = x;
        let top = y;

        if (x + dropdownWidth > windowWidth) {
            left = windowWidth - dropdownWidth - 10;
        }
        if (y + dropdownHeight > windowHeight) {
            top = windowHeight - dropdownHeight - 10;
        }

        dropdown.style.left = `${left}px`;
        dropdown.style.top = `${top}px`;

        dropdown.classList.remove('hidden');
        setTimeout(() => {
            dropdown.classList.remove('scale-95', 'opacity-0');
            dropdown.classList.add('scale-100', 'opacity-100');
        }, 10);

        dropdown.dataset.targetUserId = targetUserId;
        dropdown.dataset.targetName = name;
        dropdown.dataset.targetAvatar = avatar;
        dropdown.dataset.targetPhone = phone;
        dropdown.dataset.targetAbout = about;

        const group = window.currentGroupData;
        if (!group) return;

        const myUidStr = String(window.myUserId);
        const adminsList = group.admins || [];
        const isCurrentUserAdmin = adminsList.includes(myUidStr) || adminsList.includes(parseInt(myUidStr)) ||
            adminsList.includes(String(myUidStr)) || (String(group.createdBy) === myUidStr);
        const isTargetAdmin = adminsList.includes(targetUserId) || adminsList.includes(parseInt(targetUserId)) ||
            adminsList.includes(String(targetUserId)) || (String(group.createdBy) === String(targetUserId));

        const makeAdminBtn = document.getElementById('member_menu_make_admin');
        const dismissAdminBtn = document.getElementById('member_menu_dismiss_admin');
        const removeBtn = document.getElementById('member_menu_remove');
        const messageBtn = document.getElementById('member_menu_message');

        if (messageBtn) {
            messageBtn.textContent = `Message ${name}`;
            messageBtn.onclick = function() {
                window.selectChat(targetUserId, name, phone, avatar, about);
                window.closeGroupMemberMenu();
            };
        }

        if (isCurrentUserAdmin) {
            if (isTargetAdmin) {
                if (String(group.createdBy) === String(targetUserId)) {
                    if (makeAdminBtn) makeAdminBtn.classList.add('hidden');
                    if (dismissAdminBtn) dismissAdminBtn.classList.add('hidden');
                } else {
                    if (makeAdminBtn) makeAdminBtn.classList.add('hidden');
                    if (dismissAdminBtn) dismissAdminBtn.classList.remove('hidden');
                }
            } else {
                if (makeAdminBtn) makeAdminBtn.classList.remove('hidden');
                if (dismissAdminBtn) dismissAdminBtn.classList.add('hidden');
            }
            if (String(group.createdBy) === String(targetUserId)) {
                if (removeBtn) removeBtn.classList.add('hidden');
            } else {
                if (removeBtn) removeBtn.classList.remove('hidden');
            }
        } else {
            if (makeAdminBtn) makeAdminBtn.classList.add('hidden');
            if (dismissAdminBtn) dismissAdminBtn.classList.add('hidden');
            if (removeBtn) removeBtn.classList.add('hidden');
        }

        if (makeAdminBtn) {
            makeAdminBtn.onclick = function() {
                window.toggleMemberAdminStatus(targetUserId, true);
                window.closeGroupMemberMenu();
            };
        }
        if (dismissAdminBtn) {
            dismissAdminBtn.onclick = function() {
                window.toggleMemberAdminStatus(targetUserId, false);
                window.closeGroupMemberMenu();
            };
        }
        if (removeBtn) {
            removeBtn.onclick = function() {
                window.removeMemberFromGroup(targetUserId);
                window.closeGroupMemberMenu();
            };
        }
    };

    window.closeGroupMemberMenu = function() {
        const dropdown = document.getElementById('group_member_context_dropdown');
        if (dropdown) {
            dropdown.classList.remove('scale-100', 'opacity-100');
            dropdown.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                dropdown.classList.add('hidden');
            }, 150);
        }
    };

    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('group_member_context_dropdown');
        if (dropdown && !dropdown.classList.contains('hidden')) {
            if (!dropdown.contains(e.target)) {
                window.closeGroupMemberMenu();
            }
        }
    });

    window.toggleMemberAdminStatus = async function(targetUserId, makeAdmin) {
        const group = window.currentGroupData;
        if (!group) return;

        const groupId = group.id;
        const adminsList = group.admins ? [...group.admins] : [group.createdBy];
        const targetUserIdStr = String(targetUserId);

        if (makeAdmin) {
            if (!adminsList.includes(targetUserIdStr) && !adminsList.includes(parseInt(targetUserIdStr))) {
                adminsList.push(targetUserIdStr);
            }
        } else {
            const idx = adminsList.findIndex(id => String(id) === targetUserIdStr);
            if (idx > -1) {
                adminsList.splice(idx, 1);
            }
        }

        try {
            await window.update(window.ref(window.db, `groups/${groupId}`), {
                admins: adminsList
            });
            window.showToast?.(makeAdmin ? "Promoted" : "Demoted",
                `${makeAdmin ? "Promoted to admin" : "Dismissed as admin"}.`);
        } catch (err) {
            console.error("Error toggling admin status:", err);
            alert("Failed to update member role.");
        }
    };

    window.removeMemberFromGroup = async function(targetUserId) {
        const group = window.currentGroupData;
        if (!group) return;

        const groupId = group.id;
        const usersList = group.users ? [...group.users] : [];
        const adminsList = group.admins ? [...group.admins] : [group.createdBy];
        const targetUserIdStr = String(targetUserId);

        const userIdx = usersList.findIndex(id => String(id) === targetUserIdStr);
        if (userIdx > -1) {
            usersList.splice(userIdx, 1);
        }

        const adminIdx = adminsList.findIndex(id => String(id) === targetUserIdStr);
        if (adminIdx > -1) {
            adminsList.splice(adminIdx, 1);
        }

        if (confirm(`Are you sure you want to remove this member from the group?`)) {
            try {
                await window.update(window.ref(window.db, `groups/${groupId}`), {
                    users: usersList,
                    admins: adminsList
                });
                window.showToast?.("Removed", "Member removed from the group.");
            } catch (err) {
                console.error("Error removing member:", err);
                alert("Failed to remove member.");
            }
        }
    };

    window.updateGroupInfoSettingsUI = function(group) {
        const perms = group.permissions || {
            editSettings: true,
            sendMessages: true,
            addMembers: true
        };

        const keys = ['editSettings', 'sendMessages', 'addMembers'];
        keys.forEach(key => {
            const val = perms[key] !== false;
            const btn = document.getElementById(`info_perm_toggle_${key}`);
            const circle = document.getElementById(`info_perm_circle_${key}`);

            if (btn && circle) {
                if (val) {
                    btn.classList.remove('bg-[#374248]');
                    btn.classList.add('bg-[#00a884]');
                    circle.classList.remove('translate-x-0');
                    circle.classList.add('translate-x-5');
                } else {
                    btn.classList.remove('bg-[#00a884]');
                    btn.classList.add('bg-[#374248]');
                    circle.classList.remove('translate-x-5');
                    circle.classList.add('translate-x-0');
                }
            }
        });
    };

    window.toggleGroupInfoPerm = async function(key) {
        const group = window.currentGroupData;
        if (!group) return;

        const groupId = group.id;
        const perms = group.permissions ? {
            ...group.permissions
        } : {
            editSettings: true,
            sendMessages: true,
            addMembers: true
        };

        const currentVal = perms[key] !== false;
        perms[key] = !currentVal;

        try {
            await window.update(window.ref(window.db, `groups/${groupId}`), {
                permissions: perms
            });
            window.showToast?.("Settings Saved", `Updated permission: ${key}`);
        } catch (err) {
            console.error("Error toggling group info permission:", err);
            alert("Failed to update group permission.");
        }
    };

    window.handleGroupHeaderClick = function() {
        if (window.currentGroupData && window.currentGroupData.community_id && window.currentGroupData.is_announcement === true) {
            // Switch to Communities tab & load details
            if (typeof window.showCommunities === 'function') {
                window.showCommunities();
                window.showCommunityDetails(window.currentGroupData.community_id);
            }
        } else {
            window.openGroupInfoPanel();
        }
    };

</script>
@include('chat.communities.community_drawer')
