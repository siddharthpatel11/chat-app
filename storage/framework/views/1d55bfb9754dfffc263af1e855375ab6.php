<style>
    /* Options button gradient background matches item active/hover background */
    .options-btn-gradient {
        background: linear-gradient(to left, #111b21 30%, transparent 100%) !important;
    }

    .user-chat-item:hover .options-btn-gradient {
        background: linear-gradient(to left, #202c33 50%, transparent 100%) !important;
    }

    .user-chat-item.active .options-btn-gradient {
        background: linear-gradient(to left, #2a3942 50%, transparent 100%) !important;
    }

    .user-chat-item.active {
        background-color: #2a3942 !important;
    }

    /* Hover triggers for the mute submenu */
    .group-mute:hover .submenu-mute {
        display: block !important;
    }

    .filter-hidden {
        display: none !important;
    }
</style>

<div id="user_sidebar_container"
    class="hidden sm:flex flex-col w-[30%] sm:min-w-[300px] border-r border-[#313d45] bg-[#111b21]">

    <!-- Normal Sidebar Header -->
    <div id="normal_sidebar_header"
        class="h-16 bg-[#202c33] flex items-center px-4 justify-between shrink-0 border-b border-[#313d45]">
        <div class="flex items-center gap-3 cursor-pointer" onclick="toggleSettings()">
            <div
                class="w-10 h-10 rounded-full overflow-hidden bg-[#202c33] flex items-center justify-center text-white border border-[#313d45]">
                <img src="<?php echo e(auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=2a3942&color=fff'); ?>"
                    class="w-full h-full object-cover my-avatar">
            </div>
            <span class="font-semibold text-[#e9edef]"><?php echo e(auth()->user()->name); ?> (You)</span>
        </div>
        <div class="flex items-center gap-2">
            <!-- New Chat Icon -->
            <button onclick="toggleNewChat()"
                class="p-2 rounded-full hover:bg-[#384b57] transition-colors text-[#aebac1]">
                <svg viewBox="0 0 24 24" height="24" width="24" preserveAspectRatio="xMidYMid meet"
                    class="" fill="currentColor">
                    <title>New chat (Ctrl+Alt+bN)</title>
                    <path
                        d="M19.005 3.175H4.674C3.751 3.175 3 3.926 3 4.85v10.65c0 .925.751 1.675 1.674 1.675h10.334l4.851 4.851V4.85c0-.924-.751-1.675-1.674-1.675zm-1.674 12.325H7.001L5 17.501V5.175h14.331V15.5z">
                    </path>
                    <path d="M11.853 7.006v3.8h-3.8v1.5h3.8v3.8h1.5v-3.8h3.8v-1.5h-3.8v-3.8z"></path>
                </svg>
            </button>
            <!-- Menu Icon & Dropdown -->
            <div class="relative">
                <button id="sidebar_menu_btn"
                    class="p-2 rounded-full hover:bg-[#384b57] transition-colors text-[#aebac1] focus:bg-[#384b57]">
                    <svg viewBox="0 0 24 24" height="24" width="24" preserveAspectRatio="xMidYMid meet"
                        class="" fill="currentColor">
                        <title>menu</title>
                        <path
                            d="M12 7a2 2 0 1 0-.001-4.001A2 2 0 0 0 12 7zm0 2a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 9zm0 6a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 15z">
                        </path>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div id="sidebar_menu_dropdown"
                    class="hidden absolute right-0 top-12 w-56 bg-[#233138] rounded-lg shadow-xl border border-[#313d45] py-2 z-50 transform origin-top-right transition-all">
                    <button onclick="toggleAddMembers()"
                        class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px]">
                        <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor"
                            class="text-[#aebac1]">
                            <path
                                d="M12.5 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm6.5 11h-1v-1.5c0-1.93-3.5-3-6.5-3s-6.5 1.07-6.5 3V17h14v-1.5z">
                            </path>
                            <path d="M19 13h-2v2h-2v2h2v2h2v-2h2v-2h-2z"></path>
                        </svg>
                        New group
                    </button>
                    <button onclick="window.setSidebarFilter('archived')"
                        class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px]">
                        <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor"
                            class="text-[#aebac1]">
                            <path
                                d="M20.54 5.23l-1.39-1.68C18.88 3.21 18.47 3 18 3H6c-.47 0-.88.21-1.16.55L3.46 5.23C3.17 5.57 3 6.02 3 6.5V19c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6.5c0-.48-.17-.93-.46-1.27zM6.24 5h11.52l.81.97H5.44l.8-.97zM19 19H5V8h14v11zM11 10.5h2v4.09l1.45-1.45 1.41 1.41L12 18.41l-3.86-3.86 1.41-1.41L11 14.59V10.5z">
                            </path>
                        </svg>
                        Archived
                    </button>
                    <button onclick="window.openGlobalStarredMessages()"
                        class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px]">
                        <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor"
                            class="text-[#aebac1]">
                            <path
                                d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z">
                            </path>
                        </svg>
                        Starred messages
                    </button>
                    <button onclick="window.openSelectChatsMode()"
                        class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px]">
                        <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor"
                            class="text-[#aebac1]">
                            <path
                                d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM17.99 9l-1.41-1.42-6.59 6.59-2.58-2.57-1.42 1.41 4 3.99z">
                            </path>
                        </svg>
                        Select chats
                    </button>
                    <button onclick="window.showToast?.('Coming Soon', 'Mark all as read is under development.')"
                        class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px]">
                        <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor"
                            class="text-[#aebac1]">
                            <path
                                d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H5.17L4 17.17V4h16v12zM7 9h10v2H7zm0-3h10v2H7zm0 6h7v2H7z">
                            </path>
                        </svg>
                        Mark all as read
                    </button>
                    <div class="h-[1px] bg-[#313d45] my-1 mx-4"></div>
                    <button onclick="window.handleAppLockClick()"
                        class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px]">
                        <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor"
                            class="text-[#aebac1]">
                            <path
                                d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z">
                            </path>
                        </svg>
                        App lock
                    </button>
                    <button onclick="if(window.openLogoutModal) { window.openLogoutModal(); } else { document.getElementById('logout-form').submit(); }"
                        class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px]">
                        <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor"
                            class="text-[#aebac1]">
                            <path
                                d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z">
                            </path>
                        </svg>
                        Log out
                    </button>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const menuBtn = document.getElementById('sidebar_menu_btn');
                    const menuDropdown = document.getElementById('sidebar_menu_dropdown');

                    if (menuBtn && menuDropdown) {
                        menuBtn.addEventListener('click', (e) => {
                            e.stopPropagation();
                            menuDropdown.classList.toggle('hidden');
                        });

                        document.addEventListener('click', (e) => {
                            if (!menuDropdown.contains(e.target) && !menuBtn.contains(e.target)) {
                                menuDropdown.classList.add('hidden');
                            }
                        });
                    }
                });
            </script>
        </div>
    </div>

    <!-- Archived Sidebar Header -->
    <div id="archived_sidebar_header"
        class="hidden h-16 bg-[#202c33] flex items-center px-4 gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="window.showChats()"
            class="text-[#aebac1] hover:text-[#e9edef] transition-colors focus:outline-none p-1 rounded-full hover:bg-[#384b57]">
            <svg viewBox="0 0 24 24" height="24" width="24" fill="currentColor">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
            </svg>
        </button>
        <span class="font-semibold text-lg text-[#e9edef]">Archived</span>
    </div>

    <!-- Locked Chats Header (Hidden by default) -->
    <div id="locked_sidebar_header" class="hidden items-center gap-6 px-4 py-4 bg-[#202c33] shrink-0 border-b border-[#313d45]">
        <button onclick="window.setSidebarFilter('all')" class="text-[#d1d7db] hover:text-[#e9edef] transition-colors p-2 -ml-2 rounded-full hover:bg-[#111b21]">
            <svg viewBox="0 0 24 24" height="24" width="24" fill="currentColor">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
            </svg>
        </button>
        <span class="text-[#e9edef] text-[19px] font-medium">Locked chats</span>
    </div>

    <!-- Global Starred Sidebar Header -->
    <div id="global_starred_sidebar_header"
        class="hidden h-16 bg-[#202c33] flex items-center px-4 gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="window.closeGlobalStarredMessages()"
            class="text-[#aebac1] hover:text-[#e9edef] transition-colors focus:outline-none p-1 rounded-full hover:bg-[#384b57]">
            <svg viewBox="0 0 24 24" height="24" width="24" fill="currentColor">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
            </svg>
        </button>
        <span class="font-semibold text-lg text-[#e9edef]">Starred messages</span>
    </div>

    <!-- Select Chats Sidebar Header -->
    <div id="select_chats_sidebar_header"
        class="hidden h-16 bg-[#202c33] flex items-center px-4 justify-between shrink-0 border-b border-[#313d45]">
        <div class="flex items-center gap-6">
            <button onclick="window.closeSelectChatsMode()"
                class="text-[#aebac1] hover:text-[#e9edef] transition-colors focus:outline-none p-1 rounded-full hover:bg-[#384b57]">
                <svg viewBox="0 0 24 24" height="24" width="24" fill="currentColor">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path>
                </svg>
            </button>
            <span class="font-semibold text-lg text-[#e9edef]" id="select_chats_count">0 selected</span>
        </div>
        <div class="relative">
            <button id="select_chats_menu_btn" onclick="document.getElementById('select_chats_menu_dropdown').classList.toggle('hidden')"
                class="text-[#aebac1] hover:text-[#e9edef] transition-colors focus:outline-none p-1 rounded-full hover:bg-[#384b57]">
                <svg viewBox="0 0 24 24" height="24" width="24" fill="currentColor">
                    <path d="M12 7a2 2 0 1 0-.001-4.001A2 2 0 0 0 12 7zm0 2a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 9zm0 6a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 15z"></path>
                </svg>
            </button>
            
            <!-- Dropdown -->
            <div id="select_chats_menu_dropdown"
                class="hidden absolute right-0 top-10 w-56 bg-[#233138] rounded-xl shadow-2xl border border-[#313d45] py-2 z-50 transform origin-top-right transition-all">
                <button onclick="window.handleSelectChatsAction('read')"
                    class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px]">
                    <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-[#aebac1]">
                        <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"></path>
                    </svg>
                    Mark as read
                </button>
                <button onclick="window.handleSelectChatsAction('mute')"
                    class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px]">
                    <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-[#aebac1]">
                        <path d="M16.5 12c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM19 12c0 2.76-1.9 5.07-4.5 5.72v2.06c3.74-.72 6.5-4.07 6.5-7.78s-2.76-7.06-6.5-7.78v2.06c2.6.65 4.5 2.96 4.5 5.72zM4.3 8.3H1.5v7.4h2.8l5.1 5.1V3.2L4.3 8.3z"></path>
                    </svg>
                    Mute notifications
                </button>
                <button onclick="window.handleSelectChatsAction('archive')"
                    class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px]">
                    <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-[#aebac1]">
                        <path d="M20.54 5.23l-1.39-1.68C18.88 3.21 18.47 3 18 3H6c-.47 0-.88.21-1.16.55L3.46 5.23C3.17 5.57 3 6.02 3 6.5V19c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6.5c0-.48-.17-.93-.46-1.27zM6.24 5h11.52l.81.97H5.44l.8-.97zM19 19H5V8h14v11zM11 10.5h2v4.09l1.45-1.45 1.41 1.41L12 18.41l-3.86-3.86 1.41-1.41L11 14.59V10.5z"></path>
                    </svg>
                    Archive chats
                </button>
                <button onclick="window.handleSelectChatsAction('clear')"
                    class="w-full text-left px-4 py-3 text-red-500 hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px]">
                    <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-red-500">
                        <path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 11H7v-2h10v2z"></path>
                    </svg>
                    Clear selected chats
                </button>
            </div>
        </div>
    </div>

    <div class="p-2 border-b border-[#202c33] bg-[#111b21] flex flex-col gap-2">
        <div id="sidebar_search_box"
            class="bg-[#202c33] rounded-lg flex items-center px-3 py-1.5 h-9 transition-all duration-200 focus-within:bg-[#2a3942]">
            <!-- Search / Back icon container -->
            <div class="relative w-6 h-6 shrink-0">
                <!-- Search icon -->
                <svg id="sidebar_search_icon"
                    class="w-[18px] h-[18px] text-[#8696a0] absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 transition-all duration-200"
                    fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 0 0 1.256-3.386 5.207 5.207 0 1 0-5.207 5.208 5.183 5.183 0 0 0 3.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-4.6-1.598a3.608 3.608 0 1 1 0-7.216 3.608 3.608 0 0 1 0 7.216z">
                    </path>
                </svg>
                <!-- Back arrow (visible on focus) -->
                <button id="sidebar_back_icon" onclick="blurSidebarSearch()"
                    class="hidden w-[18px] h-[18px] text-[#00a884] absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 transition-all duration-200 cursor-pointer">
                    <svg fill="currentColor" viewBox="0 0 24 24" width="18" height="18">
                        <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
                    </svg>
                </button>
            </div>
            <input type="text" id="sidebar_search" oninput="window.filterSidebar()"
                onfocus="onSidebarSearchFocus()" onblur="onSidebarSearchBlur()"
                placeholder="Search or start new chat"
                class="bg-transparent border-none focus:ring-0 w-full text-[13px] ml-4 text-[#d1d7db] placeholder-[#8696a0] outline-none">
            <!-- Clear button -->
            <button id="sidebar_search_clear" onclick="clearSidebarSearch()"
                class="hidden text-[#8696a0] hover:text-[#e9edef] transition-colors shrink-0 p-0.5">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Filters -->
        <div class="flex items-center gap-2 px-1 overflow-x-auto custom-scrollbar pb-1">
            <button onclick="window.setSidebarFilter('all')" id="filter_btn_all"
                class="px-3 py-1.5 rounded-full bg-[#2a3942] text-[#00a884] text-[14px] whitespace-nowrap transition-colors">All</button>
            <button onclick="window.setSidebarFilter('unread')" id="filter_btn_unread"
                class="px-3 py-1.5 rounded-full bg-[#202c33] text-[#8696a0] hover:bg-[#2a3942] text-[14px] whitespace-nowrap transition-colors">Unread</button>
            <button onclick="window.setSidebarFilter('favourites')" id="filter_btn_favourites"
                class="px-3 py-1.5 rounded-full bg-[#202c33] text-[#8696a0] hover:bg-[#2a3942] text-[14px] whitespace-nowrap transition-colors">Favourites</button>
            <button onclick="window.setSidebarFilter('groups')" id="filter_btn_groups"
                class="px-3 py-1.5 rounded-full bg-[#202c33] text-[#8696a0] hover:bg-[#2a3942] text-[14px] whitespace-nowrap transition-colors">Groups</button>
            <div id="custom_lists_container" class="flex items-center gap-2"></div>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto custom-scrollbar" id="user_list_container">
        <!-- Locked Chats Button (Hidden by default) -->
        <div id="locked_chats_btn" class="hidden items-center px-4 py-3 hover:bg-[#202c33] cursor-pointer transition-colors border-b border-[#202c33]" onclick="window.openLockedChatsPrompt()">
            <div class="flex items-center gap-4 w-full">
                <div class="w-12 h-12 flex items-center justify-center shrink-0 text-[#00a884]">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <span class="text-[#e9edef] text-[17px] font-normal">Locked chats</span>
                </div>
            </div>
        </div>

        <!-- Meta AI Hidden Sidebar Item -->
        <div onclick="window.openMetaAiChat()"
            class="flex relative items-center px-3 py-3 hover:bg-[#202c33] cursor-pointer transition-colors user-chat-item group"
            id="user_sidebar_meta_ai" data-name="Meta AI" data-avatar="" data-phone="" data-about="AI Assistant"
            data-userid="meta_ai" data-timestamp="0">
            <div class="w-12 h-12 rounded-full overflow-hidden bg-[#2a3942] flex items-center justify-center shrink-0">
                <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#00a884]">
                    <circle cx="12" cy="12" r="10" class="text-[#00a884]"></circle>
                    <path d="M12 8a4 4 0 0 1 4 4c0 2.21-1.79 4-4 4s-4-1.79-4-4a4 4 0 0 1 4-4z" class="fill-[#00a884]">
                    </path>
                </svg>
            </div>
            <div class="ml-3 flex-1 border-b border-[#202c33] pb-3 pt-1 min-w-0 pr-6 relative">
                <div class="flex justify-between items-center">
                    <h4 class="text-[17px] text-[#e9edef] truncate mr-2 font-normal">
                        Meta AI
                    </h4>
                    <span class="text-[12px] text-[#8696a0] whitespace-nowrap"></span>
                </div>
                <div class="flex justify-between items-center mt-0.5">
                    <p class="text-[14px] text-[#8696a0] truncate flex-1 min-w-0 leading-snug">
                        AI Assistant
                    </p>
                    <div class="flex items-center gap-2 shrink-0">
                        <span id="pin_icon_meta_ai" class="hidden text-[#8696a0]">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                                <path d="M16 12V4h1V2H7v2h1v8l-2 2v2h5.2v6h1.6v-6H18v-2l-2-2z" />
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
            <div
                class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-[#202c33] via-[#202c33] to-transparent hidden group-hover:flex items-center justify-end pr-3 z-20 options-btn-gradient">
                <button
                    onclick="event.stopPropagation(); window.toggleUserContextMenu(event, 'meta_ai', 'Meta AI', 'user')"
                    class="text-[#8696a0] hover:text-[#e9edef] p-1 rounded transition-colors focus:outline-none">
                    <svg viewBox="0 0 24 24" height="24" width="24" fill="currentColor">
                        <path
                            d="M12 7a2 2 0 1 0-.001-4.001A2 2 0 0 0 12 7zm0 2a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 9zm0 6a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 15z">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
        <?php $__currentLoopData = $users ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $userAvatar =
                    $user->avatar ??
                    'https://ui-avatars.com/api/?name=' .
                        urlencode($user->saved_name ?? $user->name ?: $user->phone) .
                        '&background=2a3942&color=fff';
                $displayName = $user->saved_name ?? ($user->name ?: $user->phone);
                // Hide users by default if they are not a contact (they will be unhidden by Firebase if a chat exists)
                $visibilityClass = $user->is_contact ?? false ? 'flex' : 'hidden';
            ?>
            <div onclick="window.selectChat(<?php echo e($user->id); ?>, '<?php echo e(addslashes($displayName)); ?>', '<?php echo e(addslashes($user->phone ?? '')); ?>', '<?php echo e($userAvatar); ?>', '<?php echo e(addslashes($user->about ?? 'Available')); ?>')"
                class="<?php echo e($visibilityClass); ?> relative items-center px-3 py-3 hover:bg-[#202c33] cursor-pointer transition-colors user-chat-item group"
                id="user_sidebar_<?php echo e($user->id); ?>" data-name="<?php echo e($displayName); ?>"
                data-avatar="<?php echo e($userAvatar); ?>" data-phone="<?php echo e($user->phone ?? ''); ?>"
                data-about="<?php echo e($user->about ?? 'Available'); ?>" data-userid="<?php echo e($user->id); ?>"
                data-timestamp="0">
                <div
                    class="w-12 h-12 rounded-full overflow-hidden bg-[#2a3942] flex items-center justify-center shrink-0">
                    <img src="<?php echo e($userAvatar); ?>" class="w-full h-full object-cover">
                </div>
                <div class="ml-3 flex-1 border-b border-[#202c33] pb-3 pt-1 min-w-0 pr-6 relative">
                    <div class="flex justify-between items-center">
                        <h4 class="text-[17px] text-[#e9edef] truncate mr-2 font-normal">
                            <?php echo e($displayName); ?>

                        </h4>
                        <span class="text-[12px] text-[#8696a0] whitespace-nowrap"
                            id="last_time_<?php echo e($user->id); ?>"></span>
                    </div>
                    <div class="flex justify-between items-center mt-0.5">
                        <p class="text-[14px] text-[#8696a0] truncate flex-1 min-w-0 leading-snug"
                            id="last_msg_<?php echo e($user->id); ?>">
                            Click to chat
                        </p>
                        <div class="flex items-center gap-2 shrink-0">
                            <!-- Pin Icon -->
                            <span id="pin_icon_<?php echo e($user->id); ?>" class="hidden text-[#8696a0]">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                                    <path d="M16 12V4h1V2H7v2h1v8l-2 2v2h5.2v6h1.6v-6H18v-2l-2-2z" />
                                </svg>
                            </span>
                            <!-- Unread Badge -->
                            <span id="unread_badge_<?php echo e($user->id); ?>"
                                class="hidden bg-[#00a884] text-[#111b21] text-[12px] font-bold min-w-[20px] h-5 rounded-full flex items-center justify-center px-1.5 shadow-sm">
                                0
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Dropdown Trigger Button with Gradient Overlay -->
                <div
                    class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-[#202c33] via-[#202c33] to-transparent hidden group-hover:flex items-center justify-end pr-3 z-20 options-btn-gradient">
                    <button
                        onclick="event.stopPropagation(); window.toggleUserContextMenu(event, <?php echo e($user->id); ?>, '<?php echo e(addslashes($displayName)); ?>', 'user')"
                        class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none">
                        <svg viewBox="0 0 19 20" width="19" height="20" fill="currentColor">
                            <path d="M3.8 6.7l5.7 5.7 5.7-5.7 1.6 1.6-7.3 7.2-7.3-7.2 1.6-1.6z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Search Results View (hidden by default) -->
    <div id="search_results_container" class="hidden flex-1 overflow-y-auto custom-scrollbar bg-[#111b21]">
        <!-- Chats Section -->
        <div id="search_chats_section" class="hidden">
            <div class="px-5 pt-4 pb-2">
                <span class="text-[#00a884] text-[14px] font-medium">Chats</span>
            </div>
            <div id="search_chats_list"></div>
        </div>

        <!-- Messages Section -->
        <div id="search_messages_section" class="hidden">
            <div class="px-5 pt-4 pb-2">
                <span class="text-[#00a884] text-[14px] font-medium">Messages</span>
            </div>
            <div id="search_messages_list"></div>
        </div>

        <!-- No results state -->
        <div id="sidebar_no_results" class="hidden flex-col items-center justify-center py-16 px-6 text-center">
            <svg class="w-16 h-16 text-[#3b4a54] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                </path>
            </svg>
            <p class="text-[#8696a0] text-[14px]">No results found</p>
            <p class="text-[#667781] text-[12px] mt-1">Try a different search</p>
        </div>
    </div>

    <!-- Global Starred Messages Container -->
    <div id="global_starred_messages_container" class="hidden flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] p-0">
        <div id="global_starred_messages_list" class="flex flex-col p-2 space-y-2"></div>
        <div id="global_starred_no_results" class="hidden flex-col items-center justify-center py-16 px-6 text-center">
            <svg class="w-16 h-16 text-[#3b4a54] mb-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
            <p class="text-[#8696a0] text-[14px]">No starred messages</p>
        </div>
    </div>

    <!-- User/Chat Context Menu Dropdown -->
    <div id="user_context_dropdown"
        class="hidden fixed w-64 bg-[#233138] rounded-xl shadow-2xl border border-[#313d45] py-2 z-[200] transform scale-95 opacity-0 transition-all duration-150 origin-top-right">
        <button id="context_archive_btn" onclick="window.handleUserContextAction('archive')"
            class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px] focus:outline-none">
            <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-[#aebac1]">
                <path
                    d="M20.54 5.23l-1.39-1.68C18.88 3.21 18.47 3 18 3H6c-.47 0-.88.21-1.16.55L3.46 5.23C3.17 5.57 3 6.02 3 6.5V19c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6.5c0-.48-.17-.93-.46-1.27zM6.24 5h11.52l.81.97H5.44l.8-.97zM19 19H5V8h14v11zM11 10.5h2v4.09l1.45-1.45 1.41 1.41L12 18.41l-3.86-3.86 1.41-1.41L11 14.59V10.5z">
                </path>
            </svg>
            Archive chat
        </button>
        <button id="context_lock_btn" onclick="window.handleUserContextAction('lock')"
            class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px] focus:outline-none">
            <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-[#aebac1]">
                <path
                    d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z">
                </path>
            </svg>
            Lock chat
        </button>

        <!-- Mute Notifications with Submenu -->
        <div class="relative group-mute w-full">
            <button id="context_mute_btn"
                onclick="if(window.mutedChats[window.activeChatTypeForMenu === 'group' ? `group_sidebar_${window.activeChatIdForMenu}` : `user_sidebar_${window.activeChatIdForMenu}`]) window.handleUserContextAction('mute_toggle')"
                class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center justify-between text-[14.5px] focus:outline-none">
                <div class="flex items-center gap-4">
                    <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor"
                        class="text-[#aebac1]">
                        <path
                            d="M16.5 12c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM19 12c0 2.76-1.9 5.07-4.5 5.72v2.06c3.74-.72 6.5-4.07 6.5-7.78s-2.76-7.06-6.5-7.78v2.06c2.6.65 4.5 2.96 4.5 5.72zM4.3 8.3H1.5v7.4h2.8l5.1 5.1V3.2L4.3 8.3z">
                        </path>
                    </svg>
                    <span id="context_mute_text">Mute notifications</span>
                </div>
                <svg id="context_mute_arrow" viewBox="0 0 24 24" width="16" height="16" fill="currentColor"
                    class="text-[#8696a0]">
                    <path d="M8.59 16.59L10 18l6-6-6-6-1.41 1.41L13.17 12z" />
                </svg>
            </button>
            <!-- Submenu (opens to the left) -->
            <div id="context_mute_submenu"
                class="hidden submenu-mute absolute right-full top-0 mr-[1px] w-48 bg-[#233138] rounded-lg shadow-xl border border-[#313d45] py-2 z-[210]">
                <button onclick="window.handleUserContextAction('mute', '8h')"
                    class="w-full text-left px-4 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-sm focus:outline-none">8
                    hours</button>
                <button onclick="window.handleUserContextAction('mute', '1w')"
                    class="w-full text-left px-4 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-sm focus:outline-none">1
                    week</button>
                <button onclick="window.handleUserContextAction('mute', 'always')"
                    class="w-full text-left px-4 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-sm focus:outline-none">Always</button>
            </div>
        </div>

        <button id="context_pin_btn" onclick="window.handleUserContextAction('pin')"
            class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px] focus:outline-none">
            <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-[#aebac1]">
                <path d="M16 12V4h1V2H7v2h1v8l-2 2v2h5.2v6h1.6v-6H18v-2l-2-2z"></path>
            </svg>
            Pin chat
        </button>
        <button onclick="window.handleUserContextAction('unread')"
            class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px] focus:outline-none">
            <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-[#aebac1]">
                <path
                    d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z">
                </path>
            </svg>
            Mark as unread
        </button>
        <button id="context_favourite_btn" onclick="window.handleUserContextAction('favourite')"
            class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px] focus:outline-none">
            <svg viewBox="0 0 24 24" height="20" width="20" fill="none" stroke="currentColor"
                stroke-width="2" class="text-[#aebac1]">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                </path>
            </svg>
            Add to favourites
        </button>
        <button onclick="window.handleUserContextAction('add_to_list')" class="w-full flex items-center gap-4 px-4 py-3 hover:bg-[#182229] transition-colors text-[#e9edef] text-[14.5px]">
            <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-[#aebac1]">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
            </svg>
            Add to list
        </button>
        <button id="context_remove_from_list_btn" onclick="window.handleUserContextAction('remove_from_list')" class="w-full hidden items-center gap-4 px-4 py-3 hover:bg-[#182229] transition-colors text-[#e9edef] text-[14.5px]">
            <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-[#aebac1]">
                <path d="M12 2c-5.5 0-10 4.5-10 10s4.5 10 10 10 10-4.5 10-10-4.5-10-10-10zm5 11h-10v-2h10v2z"></path>
            </svg>
            Remove from list
        </button>

        <button onclick="window.handleUserContextAction('disappearing')" class="w-full flex items-center gap-4 px-4 py-3 hover:bg-[#182229] transition-colors text-[#e9edef] text-[14.5px]">
            <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-[#aebac1]">
                <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"></path>
            </svg>
            Disappearing messages
        </button>

        <div class="h-[1px] bg-[#313d45] my-1.5"></div>

        <button id="context_block_btn" onclick="window.handleUserContextAction('block')"
            class="w-full text-left px-4 py-3 text-red-500 hover:bg-red-500/10 transition-colors flex items-center gap-4 text-[14.5px] focus:outline-none">
            <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-red-500">
                <path
                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8 0-1.85.63-3.55 1.69-4.9L16.9 18.31C15.55 19.37 13.85 20 12 20zm4.31-3.1L5.69 6.31C6.73 5.09 8.27 4.3 10 4.3c4.42 0 8 3.58 8 8 0 1.73-.79 3.27-2.01 4.31z">
                </path>
            </svg>
            Block
        </button>
        <button onclick="window.handleUserContextAction('clear')"
            class="w-full text-left px-4 py-3 text-red-500 hover:bg-red-500/10 transition-colors flex items-center gap-4 text-[14.5px] focus:outline-none">
            <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-red-500">
                <path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 11H7v-2h10v2z"></path>
            </svg>
            Clear chat
        </button>
        <button onclick="window.handleUserContextAction('delete')"
            class="w-full text-left px-4 py-3 text-red-500 hover:bg-red-500/10 transition-colors flex items-center gap-4 text-[14.5px] focus:outline-none">
            <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-red-500">
                <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path>
            </svg>
            Delete chat
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dropdown = document.getElementById('user_context_dropdown');
            let activeChatIdForMenu = null;
            let activeChatTypeForMenu = null; // 'user' or 'group'

            window.activeSidebarFilter = 'all';

            // Pinned chats management
            window.pinnedChats = JSON.parse(localStorage.getItem('pinned_chats') || '[]');

            // Favourites management
            window.favouriteChats = JSON.parse(localStorage.getItem('favourite_chats') || '[]');

            // Archive, Lock, Mute management
            window.archivedChats = JSON.parse(localStorage.getItem('archived_chats') || '[]');
            window.lockedChats = JSON.parse(localStorage.getItem('locked_chats') || '[]');
            window.mutedChats = JSON.parse(localStorage.getItem('muted_chats') || '{}');

            // Block, Clear, Delete management
            window.blockedUsers = JSON.parse(localStorage.getItem('blocked_users') || '[]');
            window.clearedChats = JSON.parse(localStorage.getItem('cleared_chats') || '{}');
            window.deletedChats = JSON.parse(localStorage.getItem('deleted_chats') || '[]');

            // Custom Lists management
            window.customLists = JSON.parse(localStorage.getItem('custom_lists') || '{}');

            window.setSidebarFilter = function(filter) {
                window.activeSidebarFilter = filter;

                // Update button styles for top filters
                ['all', 'unread', 'favourites', 'groups'].forEach(f => {
                    const btn = document.getElementById(`filter_btn_${f}`);
                    if (btn) {
                        if (filter === f) {
                            btn.className = 'px-3 py-1.5 rounded-full bg-[#2a3942] text-[#00a884] text-[14px] whitespace-nowrap transition-colors';
                        } else {
                            btn.className = 'px-3 py-1.5 rounded-full bg-[#202c33] text-[#8696a0] hover:bg-[#2a3942] text-[14px] whitespace-nowrap transition-colors';
                        }
                    }
                });

                // Update custom list buttons styles
                Object.keys(window.customLists || {}).forEach(listName => {
                    const btn = document.getElementById(`filter_btn_list_${listName}`);
                    if (btn) {
                        if (filter === `list_${listName}`) {
                            btn.className = 'px-3 py-1.5 rounded-full bg-[#2a3942] text-[#00a884] text-[14px] whitespace-nowrap transition-colors flex items-center gap-2';
                        } else {
                            btn.className = 'px-3 py-1.5 rounded-full bg-[#202c33] text-[#8696a0] hover:bg-[#2a3942] text-[14px] whitespace-nowrap transition-colors block';
                        }
                    }
                });

                // Show/hide filter container depending on view
                const filterContainer = document.getElementById('sidebar_filters_container');
                const normalHeader = document.getElementById('normal_sidebar_header');
                const archivedHeader = document.getElementById('archived_sidebar_header');
                const lockedHeader = document.getElementById('locked_sidebar_header');
                const searchContainer = document.getElementById('sidebar_search_container');

                if (filter === 'archived') {
                    if (searchContainer) {
                        searchContainer.classList.remove('hidden');
                        searchContainer.classList.add('flex');
                    }
                    if (filterContainer) {
                        filterContainer.classList.add('hidden');
                        filterContainer.classList.remove('flex');
                    }
                    if (normalHeader) {
                        normalHeader.classList.add('hidden');
                        normalHeader.classList.remove('flex');
                    }
                    if (archivedHeader) {
                        archivedHeader.classList.remove('hidden');
                        archivedHeader.classList.add('flex');
                    }
                    if (lockedHeader) {
                        lockedHeader.classList.add('hidden');
                        lockedHeader.classList.remove('flex');
                    }
                } else if (filter === 'locked') {
                    if (searchContainer) {
                        searchContainer.classList.add('hidden');
                        searchContainer.classList.remove('flex');
                    }
                    if (filterContainer) {
                        filterContainer.classList.add('hidden');
                        filterContainer.classList.remove('flex');
                    }
                    if (lockedHeader) {
                        lockedHeader.classList.remove('hidden');
                        lockedHeader.classList.add('flex');
                    }
                    if (normalHeader) {
                        normalHeader.classList.add('hidden');
                        normalHeader.classList.remove('flex');
                    }
                    if (archivedHeader) {
                        archivedHeader.classList.add('hidden');
                        archivedHeader.classList.remove('flex');
                    }
                } else {
                    if (searchContainer) {
                        searchContainer.classList.remove('hidden');
                        searchContainer.classList.add('flex');
                    }
                    if (filterContainer) {
                        filterContainer.classList.remove('hidden');
                        filterContainer.classList.add('flex');
                    }
                    if (lockedHeader) {
                        lockedHeader.classList.add('hidden');
                        lockedHeader.classList.remove('flex');
                    }
                    if (normalHeader) {
                        normalHeader.classList.remove('hidden');
                        normalHeader.classList.add('flex');
                    }
                    if (archivedHeader) {
                        archivedHeader.classList.add('hidden');
                        archivedHeader.classList.remove('flex');
                    }
                }

                window.sortSidebar();
            };

            window.renderCustomListFilters = function() {
                const container = document.getElementById('custom_lists_container');
                if (!container) return;
                
                container.innerHTML = '';
                
                Object.keys(window.customLists || {}).forEach(listName => {
                    const isActive = window.activeSidebarFilter === `list_${listName}`;
                    const className = isActive ? 
                        'px-3 py-1.5 rounded-full bg-[#2a3942] text-[#00a884] text-[14px] whitespace-nowrap transition-colors flex items-center gap-2' : 
                        'px-3 py-1.5 rounded-full bg-[#202c33] text-[#8696a0] hover:bg-[#2a3942] text-[14px] whitespace-nowrap transition-colors block';
                    
                    const deleteIcon = isActive ? `<span onclick="event.stopPropagation(); window.deleteCustomListInline('${listName.replace(/'/g, "\\'")}')" class="hover:text-[#f15c6d] text-[#00a884] ml-1" title="Delete list"><svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path></svg></span>` : '';
                    
                    const btnHtml = `<button onclick="window.setSidebarFilter('list_${listName.replace(/'/g, "\\'")}')" id="filter_btn_list_${listName}" class="${className}">${listName}${deleteIcon}</button>`;
                    container.insertAdjacentHTML('beforeend', btnHtml);
                });
            };

            window.deleteCustomListInline = function(listName) {
                if (confirm(`Are you sure you want to delete the list "${listName}"?`)) {
                    delete window.customLists[listName];
                    localStorage.setItem('custom_lists', JSON.stringify(window.customLists));
                    window.setSidebarFilter('all');
                    window.renderListCheckboxes?.();
                    window.showToast?.('List Deleted', `The list "${listName}" has been removed.`);
                }
            };

            window.applyPinVisualState = function(itemEl, isPinned) {
                if (!itemEl) return;
                const idSuffix = itemEl.id.replace('user_sidebar_', '').replace('group_sidebar_', '');
                const isGroup = itemEl.id.startsWith('group_sidebar_');
                const pinIcon = isGroup ? document.getElementById(`group_pin_icon_${idSuffix}`) : document
                    .getElementById(`pin_icon_${idSuffix}`);
                if (pinIcon) {
                    if (isPinned) {
                        pinIcon.classList.remove('hidden');
                    } else {
                        pinIcon.classList.add('hidden');
                    }
                }
            };

            window.togglePinChat = function(targetId, type) {
                const elementId = type === 'group' ? `group_sidebar_${targetId}` : `user_sidebar_${targetId}`;
                const index = window.pinnedChats.indexOf(elementId);
                let isPinned = false;

                if (index > -1) {
                    window.pinnedChats.splice(index, 1);
                } else {
                    window.pinnedChats.push(elementId);
                    isPinned = true;
                }

                localStorage.setItem('pinned_chats', JSON.stringify(window.pinnedChats));

                // Update visual states
                const items = document.querySelectorAll(`.user-chat-item`);
                items.forEach(item => {
                    if (item.id === elementId || item.getAttribute('data-userid') == targetId || item
                        .getAttribute('data-groupid') == targetId) {
                        window.applyPinVisualState(item, isPinned);
                    }
                });

                window.sortSidebar();

                const chatName = type === 'group' ? 'Group' : 'Chat';
                window.showToast?.(isPinned ? 'Chat Pinned' : 'Chat Unpinned',
                    `The ${chatName.toLowerCase()} has been ${isPinned ? 'pinned to top' : 'unpinned'}.`);
            };

            window.sortSidebar = function() {
                const container = document.getElementById('user_list_container');
                if (!container) return;

                const items = Array.from(container.children).filter(el => el.classList.contains(
                    'user-chat-item'));
                if (items.length === 0) return;

                const filter = window.activeSidebarFilter || 'all';

                items.forEach(item => {
                    let matchesFilter = true;
                    if (filter === 'unread') {
                        const idSuffix = item.id.replace('user_sidebar_', '').replace('group_sidebar_',
                            '');
                        const isGroup = item.id.startsWith('group_sidebar_');
                        const badge = isGroup ? document.getElementById(
                            `group_unread_badge_${idSuffix}`) : document.getElementById(
                            `unread_badge_${idSuffix}`);

                        matchesFilter = badge && !badge.classList.contains('hidden') && parseInt(badge
                            .textContent) > 0;
                    } else if (filter === 'favourites') {
                        matchesFilter = window.favouriteChats.includes(item.id);
                    } else if (filter === 'groups') {
                        matchesFilter = item.id.startsWith('group_sidebar_');
                    } else if (filter === 'archived') {
                        matchesFilter = window.archivedChats.includes(item.id) && !window.lockedChats.includes(item.id);
                    } else if (filter === 'locked') {
                        matchesFilter = window.lockedChats.includes(item.id);
                    } else if (filter.startsWith('list_')) {
                        const listName = filter.replace('list_', '');
                        matchesFilter = window.customLists[listName] && window.customLists[listName].includes(item.id);
                    }

                    // Hide archived chats from all other views
                    if (filter !== 'archived' && filter !== 'locked' && window.archivedChats.includes(item.id)) {
                        matchesFilter = false;
                    }
                    
                    // Hide locked chats from all other views
                    if (filter !== 'locked' && window.lockedChats.includes(item.id)) {
                        matchesFilter = false;
                    }

                    // Hide deleted chats unless new message exists (timestamp > cleared timestamp)
                    if (window.deletedChats.includes(item.id)) {
                        const itemTime = parseFloat(item.getAttribute('data-timestamp') || '0');
                        const clearedTime = window.clearedChats[item.id] || 0;
                        if (itemTime <= clearedTime) {
                            matchesFilter = false;
                        }
                    }

                    if (matchesFilter) {
                        item.classList.remove('filter-hidden');
                    } else {
                        item.classList.add('filter-hidden');
                    }
                });

                items.sort((a, b) => {
                    const aPinned = window.pinnedChats.includes(a.id);
                    const bPinned = window.pinnedChats.includes(b.id);

                    if (aPinned && !bPinned) return -1;
                    if (!aPinned && bPinned) return 1;

                    const aTime = parseFloat(a.getAttribute('data-timestamp') || '0');
                    const bTime = parseFloat(b.getAttribute('data-timestamp') || '0');

                    if (aTime !== bTime) {
                        return bTime - aTime;
                    }

                    const aName = (a.getAttribute('data-name') || '').toLowerCase();
                    const bName = (b.getAttribute('data-name') || '').toLowerCase();
                    return aName.localeCompare(bName);
                });

                items.forEach(item => container.appendChild(item));
                
                // Show/hide Locked Chats button
                const lockedBtn = document.getElementById('locked_chats_btn');
                if (lockedBtn) {
                    if (window.lockedChats.length > 0 && filter === 'all') {
                        lockedBtn.classList.remove('hidden');
                        lockedBtn.classList.add('flex');
                    } else {
                        lockedBtn.classList.add('hidden');
                        lockedBtn.classList.remove('flex');
                    }
                }
            };

            // Initialize visual states and sort
            document.querySelectorAll('#user_list_container .user-chat-item').forEach(item => {
                const isPinned = window.pinnedChats.includes(item.id);
                window.applyPinVisualState(item, isPinned);
            });

            if (window.renderCustomListFilters) {
                window.renderCustomListFilters();
            }

            window.sortSidebar();

            window.toggleUserContextMenu = function(event, targetId, displayName, type = 'user') {
                event.stopPropagation();
                event.preventDefault();

                activeChatIdForMenu = targetId;
                activeChatTypeForMenu = type;

                const elementId = type === 'group' ? `group_sidebar_${targetId}` : `user_sidebar_${targetId}`;
                const isPinned = window.pinnedChats.includes(elementId);
                const isFavourite = window.favouriteChats.includes(elementId);
                const isArchived = window.archivedChats.includes(elementId);
                const isLocked = window.lockedChats.includes(elementId);
                const isMuted = !!window.mutedChats[elementId];

                // Update Archive text
                const archiveBtn = document.getElementById('context_archive_btn');
                if (archiveBtn) {
                    archiveBtn.innerHTML = `
                        <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-[#aebac1]">
                            <path d="M20.54 5.23l-1.39-1.68C18.88 3.21 18.47 3 18 3H6c-.47 0-.88.21-1.16.55L3.46 5.23C3.17 5.57 3 6.02 3 6.5V19c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6.5c0-.48-.17-.93-.46-1.27zM6.24 5h11.52l.81.97H5.44l.8-.97zM19 19H5V8h14v11zM11 10.5h2v4.09l1.45-1.45 1.41 1.41L12 18.41l-3.86-3.86 1.41-1.41L11 14.59V10.5z"></path>
                        </svg>
                        ${isArchived ? 'Unarchive chat' : 'Archive chat'}
                    `;
                }

                // Update Lock text
                const lockBtn = document.getElementById('context_lock_btn');
                if (lockBtn) {
                    lockBtn.innerHTML = `
                        <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-[#aebac1]">
                            <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"></path>
                        </svg>
                        ${isLocked ? 'Unlock chat' : 'Lock chat'}
                    `;
                }

                // Update Mute text and behavior
                const muteText = document.getElementById('context_mute_text');
                const muteArrow = document.getElementById('context_mute_arrow');
                const muteSubmenu = document.getElementById('context_mute_submenu');
                if (muteText && muteArrow && muteSubmenu) {
                    if (isMuted) {
                        muteText.textContent = 'Unmute notifications';
                        muteArrow.style.display = 'none';
                        muteSubmenu.classList.remove('submenu-mute'); // remove hover trigger
                    } else {
                        muteText.textContent = 'Mute notifications';
                        muteArrow.style.display = 'block';
                        muteSubmenu.classList.add('submenu-mute'); // add hover trigger
                    }
                }

                // Update context menu pin button text and icon
                const pinBtn = document.getElementById('context_pin_btn');
                if (pinBtn) {
                    if (isPinned) {
                        pinBtn.innerHTML = `
                            <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-[#aebac1]">
                                <path d="M16 12V4h1V2H7v2h1v8l-2 2v2h5.2v6h1.6v-6H18v-2l-2-2z"/>
                            </svg>
                            Unpin chat
                        `;
                    } else {
                        pinBtn.innerHTML = `
                            <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-[#aebac1]">
                                <path d="M16 12V4h1V2H7v2h1v8l-2 2v2h5.2v6h1.6v-6H18v-2l-2-2z"/>
                            </svg>
                            Pin chat
                        `;
                    }
                }

                // Update context menu favourite button text and icon
                const favBtn = document.getElementById('context_favourite_btn');
                if (favBtn) {
                    if (isFavourite) {
                        favBtn.innerHTML = `
                            <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-[#aebac1]">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path>
                            </svg>
                            Remove from favourites
                        `;
                    } else {
                        favBtn.innerHTML = `
                            <svg viewBox="0 0 24 24" height="20" width="20" fill="none" stroke="currentColor" stroke-width="2" class="text-[#aebac1]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Add to favourites
                        `;
                    }
                }

                // Update context menu block button text
                const blockBtn = document.getElementById('context_block_btn');
                if (blockBtn) {
                    if (type === 'group') {
                        blockBtn.style.display = 'none'; // Cannot block groups in WhatsApp
                    } else {
                        blockBtn.style.display = 'flex';
                        const isBlocked = window.blockedUsers.includes(elementId);
                        if (isBlocked) {
                            blockBtn.innerHTML = `
                                <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-red-500">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8 0-1.85.63-3.55 1.69-4.9L16.9 18.31C15.55 19.37 13.85 20 12 20zm4.31-3.1L5.69 6.31C6.73 5.09 8.27 4.3 10 4.3c4.42 0 8 3.58 8 8 0 1.73-.79 3.27-2.01 4.31z"></path>
                                </svg>
                                Unblock
                            `;
                        } else {
                            blockBtn.innerHTML = `
                                <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-red-500">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8 0-1.85.63-3.55 1.69-4.9L16.9 18.31C15.55 19.37 13.85 20 12 20zm4.31-3.1L5.69 6.31C6.73 5.09 8.27 4.3 10 4.3c4.42 0 8 3.58 8 8 0 1.73-.79 3.27-2.01 4.31z"></path>
                                </svg>
                                Block
                            `;
                        }
                    }
                }

                // Dynamic updates based on state
                const removeListBtn = document.getElementById('context_remove_from_list_btn');
                if (removeListBtn) {
                    if (window.activeSidebarFilter && window.activeSidebarFilter.startsWith('list_')) {
                        removeListBtn.classList.remove('hidden');
                        removeListBtn.classList.add('flex');
                    } else {
                        removeListBtn.classList.add('hidden');
                        removeListBtn.classList.remove('flex');
                    }
                }

                // Position the dropdown at the button position
                const rect = event.currentTarget.getBoundingClientRect();

                // Show dropdown temporarily to calculate height
                dropdown.style.visibility = 'hidden';
                dropdown.classList.remove('hidden', 'scale-95', 'opacity-0');

                const dropdownHeight = dropdown.offsetHeight;

                dropdown.classList.remove('origin-top-right', 'origin-bottom-right');

                let topPos = rect.bottom + 4;
                if (topPos + dropdownHeight + 10 > window.innerHeight) {
                    topPos = rect.top - dropdownHeight - 4;
                    if (topPos < 10) topPos = 10;
                    dropdown.classList.add('origin-bottom-right');
                } else {
                    dropdown.classList.add('origin-top-right');
                }

                dropdown.style.top = `${topPos}px`;
                dropdown.style.left = `${rect.right - dropdown.offsetWidth}px`;

                // Restore classes for animation
                dropdown.classList.add('scale-95', 'opacity-0');
                dropdown.style.visibility = 'visible';

                // Apply show animation classes
                setTimeout(() => {
                    dropdown.classList.remove('scale-95', 'opacity-0');
                    dropdown.classList.add('scale-100', 'opacity-100');
                }, 10);
            };

            // Action handler
            window.handleUserContextAction = function(action, option = null) {
                console.log(`User context action: ${action} on ${activeChatTypeForMenu} ${activeChatIdForMenu}`,
                    option);

                const chatName = activeChatTypeForMenu === 'group' ? 'Group' : 'Chat';
                if (action === 'pin') {
                    window.togglePinChat(activeChatIdForMenu, activeChatTypeForMenu);
                } else if (action === 'archive') {
                    window.toggleArchiveChat(activeChatIdForMenu, activeChatTypeForMenu);
                } else if (action === 'lock') {
                    window.toggleLockChat(activeChatIdForMenu, activeChatTypeForMenu);
                } else if (action === 'mute') {
                    window.toggleMuteChat(activeChatIdForMenu, activeChatTypeForMenu, option);
                } else if (action === 'mute_toggle') {
                    window.toggleMuteChat(activeChatIdForMenu, activeChatTypeForMenu, null);
                } else if (action === 'unread') {
                    window.showToast?.('Marked Unread', `Chat marked as unread.`);
                } else if (action === 'favourite') {
                    window.toggleFavouriteChat(activeChatIdForMenu, activeChatTypeForMenu);
                } else if (action === 'add_to_list') {
                    if (window.openAddToListModal) {
                        const elId = activeChatTypeForMenu === 'group' ? `group_sidebar_${activeChatIdForMenu}` : `user_sidebar_${activeChatIdForMenu}`;
                        window.openAddToListModal(elId);
                    }
                } else if (action === 'remove_from_list') {
                    if (window.activeSidebarFilter && window.activeSidebarFilter.startsWith('list_')) {
                        const listName = window.activeSidebarFilter.replace('list_', '');
                        const elId = activeChatTypeForMenu === 'group' ? `group_sidebar_${activeChatIdForMenu}` : `user_sidebar_${activeChatIdForMenu}`;
                        const idx = window.customLists[listName].indexOf(elId);
                        if (idx !== -1) {
                            window.customLists[listName].splice(idx, 1);
                            localStorage.setItem('custom_lists', JSON.stringify(window.customLists));
                            window.sortSidebar();
                            window.showToast?.('Removed from List', `Chat removed from ${listName}.`);
                        }
                    }
                } else if (action === 'disappearing') {
                    window.showToast?.('Disappearing Messages', `Disappearing messages settings opened.`);
                } else if (action === 'block') {
                    window.toggleBlockContact(activeChatIdForMenu, activeChatTypeForMenu);
                } else if (action === 'clear') {
                    if (window.openDeleteModal) {
                        window.openDeleteModal('Clear this chat?', () => window.clearChatMessages(
                            activeChatIdForMenu, activeChatTypeForMenu));
                    } else {
                        if (confirm('Clear this chat?')) window.clearChatMessages(activeChatIdForMenu,
                            activeChatTypeForMenu);
                    }
                } else if (action === 'delete') {
                    if (window.openDeleteModal) {
                        window.openDeleteModal('Delete this chat?', () => window.deleteChatMessages(
                            activeChatIdForMenu, activeChatTypeForMenu));
                    } else {
                        if (confirm('Delete this chat?')) window.deleteChatMessages(activeChatIdForMenu,
                            activeChatTypeForMenu);
                    }
                }

                window.closeUserContextMenu();
            };

            window.toggleBlockContact = function(targetId, type) {
                if (type === 'group') return;
                const elementId = `user_sidebar_${targetId}`;
                const index = window.blockedUsers.indexOf(elementId);
                let isBlocked = false;

                if (index > -1) {
                    window.blockedUsers.splice(index, 1);
                } else {
                    window.blockedUsers.push(elementId);
                    isBlocked = true;
                }

                localStorage.setItem('blocked_users', JSON.stringify(window.blockedUsers));
                window.showToast?.(isBlocked ? 'Contact Blocked' : 'Contact Unblocked',
                    `The contact has been ${isBlocked ? 'blocked' : 'unblocked'}.`);
                if (window.updateBlockedUI) window.updateBlockedUI();
            };

            window.unblockCurrentContact = function() {
                if (window.currentChatId && !window.currentChatId.startsWith('group_')) {
                    const targetId = window.currentChatId.replace('chat_', '').split('_').find(id => id !=
                        window.myUserId);
                    if (targetId) {
                        window.toggleBlockContact(targetId, 'user');
                    }
                }
            };

            window.clearChatMessages = function(targetId, type) {
                const elementId = type === 'group' ? `group_sidebar_${targetId}` : `user_sidebar_${targetId}`;
                window.clearedChats[elementId] = Math.floor(Date.now() / 1000);
                localStorage.setItem('cleared_chats', JSON.stringify(window.clearedChats));

                // Clear UI if currently open
                if (window.checkAndApplyClearedChatUI) window.checkAndApplyClearedChatUI(elementId);

                window.showToast?.('Chat Cleared', `Messages in this chat have been cleared for you.`);
            };

            window.deleteChatMessages = function(targetId, type) {
                const elementId = type === 'group' ? `group_sidebar_${targetId}` : `user_sidebar_${targetId}`;
                window.clearedChats[elementId] = Math.floor(Date.now() / 1000);
                localStorage.setItem('cleared_chats', JSON.stringify(window.clearedChats));

                if (!window.deletedChats.includes(elementId)) {
                    window.deletedChats.push(elementId);
                    localStorage.setItem('deleted_chats', JSON.stringify(window.deletedChats));
                }

                window.sortSidebar();

                // Clear UI if currently open
                if (window.checkAndApplyClearedChatUI) window.checkAndApplyClearedChatUI(elementId);

                window.showToast?.('Chat Deleted', `The chat has been deleted.`);
            };

            window.toggleFavouriteChat = function(targetId, type) {
                const elementId = type === 'group' ? `group_sidebar_${targetId}` : `user_sidebar_${targetId}`;
                const index = window.favouriteChats.indexOf(elementId);
                let isFavourite = false;

                if (index > -1) {
                    window.favouriteChats.splice(index, 1);
                } else {
                    window.favouriteChats.push(elementId);
                    isFavourite = true;
                }

                localStorage.setItem('favourite_chats', JSON.stringify(window.favouriteChats));

                window.sortSidebar();

                const chatName = type === 'group' ? 'Group' : 'Chat';
                window.showToast?.(isFavourite ? 'Added to Favourites' : 'Removed from Favourites',
                    `The ${chatName.toLowerCase()} has been ${isFavourite ? 'added to' : 'removed from'} favourites.`
                    );
            };

            window.closeUserContextMenu = function() {
                dropdown.classList.remove('scale-100', 'opacity-100');
                dropdown.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    dropdown.classList.add('hidden');
                }, 150);
            };

            // Close when clicking anywhere else
            document.addEventListener('click', (e) => {
                if (dropdown && !dropdown.contains(e.target)) {
                    window.closeUserContextMenu();
                }
            });

            // Close on escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    window.closeUserContextMenu();
                }
            });
            window.toggleArchiveChat = function(targetId, type) {
                const elementId = type === 'group' ? `group_sidebar_${targetId}` : `user_sidebar_${targetId}`;
                const index = window.archivedChats.indexOf(elementId);
                let isArchived = false;
                if (index > -1) {
                    window.archivedChats.splice(index, 1);
                } else {
                    window.archivedChats.push(elementId);
                    isArchived = true;
                }
                localStorage.setItem('archived_chats', JSON.stringify(window.archivedChats));
                window.sortSidebar();

                const chatName = type === 'group' ? 'Group' : 'Chat';
                window.showToast?.(isArchived ? 'Chat Archived' : 'Chat Unarchived',
                    `The ${chatName.toLowerCase()} has been ${isArchived ? 'archived' : 'unarchived'}.`);
            };

            window.toggleLockChat = function(targetId, type) {
                if (!localStorage.getItem('app_lock_hash')) {
                    // Prompt user to set up App Lock first
                    window.handleAppLockClick();
                    return; // They can lock it manually after setting it up, or we could save intent. 
                            // For simplicity, just prompt them and let them try again.
                }
                
                const elementId = type === 'group' ? `group_sidebar_${targetId}` : `user_sidebar_${targetId}`;
                const index = window.lockedChats.indexOf(elementId);
                let isLocked = false;
                if (index > -1) {
                    window.lockedChats.splice(index, 1);
                } else {
                    window.lockedChats.push(elementId);
                    isLocked = true;
                    // Also unarchive if archived, since locked takes precedence visually
                    const archIndex = window.archivedChats.indexOf(elementId);
                    if (archIndex > -1) {
                        window.archivedChats.splice(archIndex, 1);
                        localStorage.setItem('archived_chats', JSON.stringify(window.archivedChats));
                    }
                }
                localStorage.setItem('locked_chats', JSON.stringify(window.lockedChats));
                window.sortSidebar();

                const chatName = type === 'group' ? 'Group' : 'Chat';
                window.showToast?.(isLocked ? 'Chat Locked' : 'Chat Unlocked',
                    `The ${chatName.toLowerCase()} has been ${isLocked ? 'locked and hidden' : 'unlocked'}.`);
            };

            window.toggleMuteChat = function(targetId, type, durationStr) {
                const elementId = type === 'group' ? `group_sidebar_${targetId}` : `user_sidebar_${targetId}`;
                let isMuted = false;

                if (!durationStr) {
                    // Unmute
                    delete window.mutedChats[elementId];
                } else {
                    let expiry = Date.now();
                    if (durationStr === '8h') expiry += 8 * 60 * 60 * 1000;
                    else if (durationStr === '1w') expiry += 7 * 24 * 60 * 60 * 1000;
                    else expiry += 100 * 365 * 24 * 60 * 60 * 1000; // Always

                    window.mutedChats[elementId] = expiry;
                    isMuted = true;
                }

                localStorage.setItem('muted_chats', JSON.stringify(window.mutedChats));
                window.sortSidebar();

                if (isMuted) {
                    window.showToast?.('Mute Notifications',
                        `Notifications muted for ${durationStr === '8h' ? '8 hours' : durationStr === '1w' ? '1 week' : 'always'}.`
                        );
                } else {
                    window.showToast?.('Unmute Notifications', `Notifications have been unmuted.`);
                }
            };

            window.openGlobalStarredMessages = function() {
                // Hide normal elements
                document.getElementById('normal_sidebar_header')?.classList.add('hidden');
                document.getElementById('normal_sidebar_header')?.classList.remove('flex');
                document.getElementById('archived_sidebar_header')?.classList.add('hidden');
                document.getElementById('archived_sidebar_header')?.classList.remove('flex');
                document.getElementById('sidebar_filters_container')?.classList.add('hidden');
                document.getElementById('sidebar_filters_container')?.classList.remove('flex');
                document.getElementById('user_list_container')?.classList.add('hidden');
                document.getElementById('search_results_container')?.classList.add('hidden');
                
                // Hide search box container
                document.getElementById('sidebar_search_box')?.parentElement?.classList.add('hidden');
                
                // Show global starred
                document.getElementById('global_starred_sidebar_header')?.classList.remove('hidden');
                document.getElementById('global_starred_sidebar_header')?.classList.add('flex');
                document.getElementById('global_starred_messages_container')?.classList.remove('hidden');
                document.getElementById('global_starred_messages_container')?.classList.add('flex');
                
                const list = document.getElementById('global_starred_messages_list');
                const noResults = document.getElementById('global_starred_no_results');
                
                if(!list || !noResults) return;
                
                list.innerHTML = '';
                noResults.classList.add('hidden');
                
                if (!window.get || !window.ref || !window.db || !window.myUserId) return;
                
                window.get(window.ref(window.db, `starred_messages/${window.myUserId}`)).then(snapshot => {
                    const data = snapshot.val();
                    if (!data || Object.keys(data).length === 0) {
                        noResults.classList.remove('hidden');
                        noResults.classList.add('flex');
                    } else {
                        noResults.classList.add('hidden');
                        noResults.classList.remove('flex');
                        
                        const msgs = Object.entries(data).sort((a, b) => (b[1].time || 0) - (a[1].time || 0));
                        msgs.forEach(([key, msg]) => {
                            const dateObj = msg.time ? new Date(msg.time * 1000) : new Date();
                            const date = dateObj.toLocaleDateString([], { day:'2-digit', month:'2-digit', year:'numeric' });
                            const time = dateObj.toLocaleTimeString([], { hour:'2-digit', minute:'2-digit' });
                            const isMe = msg.sender_id == window.myUserId;
                            
                            let content = msg.text || '';
                            if (msg.type === 'image') content = '📷 Photo';
                            else if (msg.type === 'video') content = '🎥 Video';
                            else if (msg.type === 'audio') content = '🎤 Voice message';
                            else if (msg.type === 'document') content = `📄 ${msg.file_name || 'Document'}`;
                            
                            let contextLabel = 'You > You';
                            let chatName = 'Contact';
                            
                            if (msg.chat_id) {
                                if (msg.chat_id.startsWith('group_')) {
                                    const targetId = msg.chat_id.replace('group_', '');
                                    const groupEl = document.getElementById(`group_sidebar_${targetId}`);
                                    if (groupEl) chatName = groupEl.getAttribute('data-name') || 'Group';
                                    contextLabel = isMe ? `You > ${chatName}` : `Someone > ${chatName}`;
                                } else {
                                    const ids = msg.chat_id.replace('chat_', '').split('_');
                                    const targetId = ids.find(id => id != window.myUserId);
                                    if (targetId) {
                                        const userEl = document.getElementById(`user_sidebar_${targetId}`);
                                        if (userEl) chatName = userEl.getAttribute('data-name') || 'Contact';
                                    }
                                    if(targetId == window.myUserId) {
                                        contextLabel = 'You > You';
                                    } else {
                                        contextLabel = isMe ? `You > ${chatName}` : `${chatName} > You`;
                                    }
                                }
                            }
                            
                            list.insertAdjacentHTML('beforeend', `
                                <div class="bg-[#202c33] rounded-lg p-3 cursor-pointer hover:bg-[#2a3942] transition-colors shadow-sm border-l-4 border-transparent hover:border-[#00a884]"
                                    onclick="window.goToStarredMessage('${msg.chat_id}', '${key}')">
                                    <div class="flex items-center justify-between mb-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-[#8696a0] text-[13px] font-medium">${contextLabel}</span>
                                        </div>
                                        <span class="text-[#8696a0] text-[12px]">${date}</span>
                                    </div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-[#00a884] text-xs font-medium">${isMe ? 'You' : 'Contact'}</span>
                                        <span class="text-[#8696a0] text-[11px] ml-auto">${time}</span>
                                    </div>
                                    <div class="flex gap-2">
                                        <svg viewBox="0 0 24 24" width="14" height="14" fill="#8696a0" class="shrink-0 mt-0.5"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        <p class="text-[#e9edef] text-[14px] leading-relaxed break-words line-clamp-3">${content}</p>
                                    </div>
                                </div>
                            `);
                        });
                    }
                });
            };

            window.closeGlobalStarredMessages = function() {
                document.getElementById('global_starred_sidebar_header')?.classList.add('hidden');
                document.getElementById('global_starred_sidebar_header')?.classList.remove('flex');
                document.getElementById('global_starred_messages_container')?.classList.add('hidden');
                document.getElementById('global_starred_messages_container')?.classList.remove('flex');
                
                // Restore normal state based on current filter
                window.setSidebarFilter(window.activeSidebarFilter || 'all');
                
                document.getElementById('sidebar_search_box')?.parentElement?.classList.remove('hidden');
                document.getElementById('user_list_container')?.classList.remove('hidden');
            };

            window.goToStarredMessage = function(chatId, msgId) {
                window.closeGlobalStarredMessages();
                let targetId, type;
                if (chatId.startsWith('group_')) {
                    targetId = chatId.replace('group_', '');
                    type = 'group';
                    const groupEl = document.getElementById(`group_sidebar_${targetId}`);
                    if(groupEl) groupEl.click();
                } else {
                    const ids = chatId.replace('chat_', '').split('_');
                    targetId = ids.find(id => id != window.myUserId);
                    if (!targetId) targetId = window.myUserId; // 'You > You' chat
                    type = 'user';
                    const userEl = document.getElementById(`user_sidebar_${targetId}`);
                    if(userEl) userEl.click();
                }
                
                setTimeout(() => {
                    if(type === 'group' && window.scrollToGroupMessage) {
                        window.scrollToGroupMessage(msgId);
                    } else if(type === 'user' && window.scrollToMessage) {
                        window.scrollToMessage(msgId);
                    }
                }, 500);
            };

            // Select Chats Logic
            window.isSelectChatsMode = false;
            window.selectedSidebarChats = new Set();
            
            document.addEventListener('click', (e) => {
                const menuDropdown = document.getElementById('select_chats_menu_dropdown');
                const menuBtn = document.getElementById('select_chats_menu_btn');
                if (menuDropdown && !menuDropdown.classList.contains('hidden')) {
                    if (!menuDropdown.contains(e.target) && (!menuBtn || !menuBtn.contains(e.target))) {
                        menuDropdown.classList.add('hidden');
                    }
                }
            });

            window.openSelectChatsMode = function() {
                window.isSelectChatsMode = true;
                window.selectedSidebarChats = new Set();
                
                // Hide normal elements
                document.getElementById('normal_sidebar_header')?.classList.add('hidden');
                document.getElementById('normal_sidebar_header')?.classList.remove('flex');
                document.getElementById('archived_sidebar_header')?.classList.add('hidden');
                document.getElementById('archived_sidebar_header')?.classList.remove('flex');
                document.getElementById('global_starred_sidebar_header')?.classList.add('hidden');
                document.getElementById('global_starred_sidebar_header')?.classList.remove('flex');
                document.getElementById('main_menu_dropdown')?.classList.add('hidden');
                
                // Show select chats header
                document.getElementById('select_chats_sidebar_header')?.classList.remove('hidden');
                document.getElementById('select_chats_sidebar_header')?.classList.add('flex');
                
                document.getElementById('select_chats_count').textContent = '0 selected';
                
                // Add checkboxes to all items
                document.querySelectorAll('.user-chat-item').forEach(item => {
                    if (!item.querySelector('.sidebar-chat-checkbox-container')) {
                        const cbHtml = `
                            <div class="sidebar-chat-checkbox-container hidden shrink-0 mr-3">
                                <div class="w-5 h-5 rounded border-2 border-[#8696a0] bg-transparent flex items-center justify-center transition-all select-none sidebar-chat-checkbox-box pointer-events-none">
                                    <svg class="w-3.5 h-3.5 text-[#111b21] hidden sidebar-chat-checkbox-tick" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            </div>
                        `;
                        item.insertAdjacentHTML('afterbegin', cbHtml);
                    }
                    const container = item.querySelector('.sidebar-chat-checkbox-container');
                    if(container) {
                        container.classList.remove('hidden');
                    }
                    
                    // reset visual states
                    item.classList.remove('bg-[#2a3942]');
                    const box = item.querySelector('.sidebar-chat-checkbox-box');
                    if(box) {
                        box.classList.remove('bg-[#00a884]', 'border-[#00a884]');
                        box.classList.add('border-[#8696a0]');
                    }
                    const tick = item.querySelector('.sidebar-chat-checkbox-tick');
                    if(tick) tick.classList.add('hidden');
                });
            };

            window.closeSelectChatsMode = function() {
                window.isSelectChatsMode = false;
                window.selectedSidebarChats.clear();
                
                document.getElementById('select_chats_sidebar_header')?.classList.add('hidden');
                document.getElementById('select_chats_sidebar_header')?.classList.remove('flex');
                
                // Restore normal state based on current filter
                window.setSidebarFilter(window.activeSidebarFilter || 'all');
                
                document.querySelectorAll('.user-chat-item').forEach(item => {
                    const container = item.querySelector('.sidebar-chat-checkbox-container');
                    if(container) container.classList.add('hidden');
                    item.classList.remove('bg-[#2a3942]');
                });
            };

            window.toggleSidebarChatSelection = function(itemEl) {
                const id = itemEl.id;
                if (!id) return;
                
                const isSelected = window.selectedSidebarChats.has(id);
                const box = itemEl.querySelector('.sidebar-chat-checkbox-box');
                const tick = itemEl.querySelector('.sidebar-chat-checkbox-tick');
                
                if (isSelected) {
                    window.selectedSidebarChats.delete(id);
                    itemEl.classList.remove('bg-[#2a3942]');
                    if(box) {
                        box.classList.remove('bg-[#00a884]', 'border-[#00a884]');
                        box.classList.add('border-[#8696a0]', 'bg-transparent');
                    }
                    if(tick) tick.classList.add('hidden');
                } else {
                    window.selectedSidebarChats.add(id);
                    itemEl.classList.add('bg-[#2a3942]');
                    if(box) {
                        box.classList.add('bg-[#00a884]', 'border-[#00a884]');
                        box.classList.remove('border-[#8696a0]', 'bg-transparent');
                    }
                    if(tick) tick.classList.remove('hidden');
                }
                
                document.getElementById('select_chats_count').textContent = window.selectedSidebarChats.size + (window.selectedSidebarChats.size === 1 ? ' selected' : ' selected');
            };

            document.addEventListener('click', function(e) {
                if (window.isSelectChatsMode) {
                    const item = e.target.closest('.user-chat-item');
                    if (item) {
                        e.stopPropagation();
                        e.preventDefault();
                        window.toggleSidebarChatSelection(item);
                    }
                }
            }, true);

            window.handleSelectChatsAction = function(action) {
                if (window.selectedSidebarChats.size === 0) return;
                
                document.getElementById('select_chats_menu_dropdown')?.classList.add('hidden');

                if (action === 'clear') {
                    if (window.openDeleteModal) {
                        window.openDeleteModal('Clear selected chats?', () => {
                            window.selectedSidebarChats.forEach(id => {
                                const isGroup = id.startsWith('group_sidebar_');
                                const targetId = id.replace('user_sidebar_', '').replace('group_sidebar_', '');
                                window.clearChatMessages(targetId, isGroup ? 'group' : 'user');
                            });
                            window.closeSelectChatsMode();
                        });
                    } else {
                        if (confirm('Clear selected chats?')) {
                            window.selectedSidebarChats.forEach(id => {
                                const isGroup = id.startsWith('group_sidebar_');
                                const targetId = id.replace('user_sidebar_', '').replace('group_sidebar_', '');
                                window.clearChatMessages(targetId, isGroup ? 'group' : 'user');
                            });
                            window.closeSelectChatsMode();
                        }
                    }
                    return;
                }

                window.selectedSidebarChats.forEach(id => {
                    const isGroup = id.startsWith('group_sidebar_');
                    const targetId = id.replace('user_sidebar_', '').replace('group_sidebar_', '');
                    
                    if (action === 'archive') {
                        if (!window.archivedChats.includes(id)) {
                            window.archivedChats.push(id);
                        }
                    } else if (action === 'mute') {
                        window.toggleMuteChat(targetId, isGroup ? 'group' : 'user', '100y');
                    } else if (action === 'read') {
                        const badgeId = isGroup ? `group_unread_badge_${targetId}` : `unread_badge_${targetId}`;
                        const badge = document.getElementById(badgeId);
                        if(badge) {
                            badge.textContent = '0';
                            badge.classList.add('hidden');
                        }
                        
                        if (!isGroup && window.myUserId && window.db && window.ref && window.get && window.update) {
                            const minId = Math.min(window.myUserId, parseInt(targetId));
                            const maxId = Math.max(window.myUserId, parseInt(targetId));
                            const chatId = `chat_${minId}_${maxId}`;
                            
                            window.get(window.ref(window.db, `chats/${chatId}/messages`)).then(snap => {
                                if(snap.exists()) {
                                    const updates = {};
                                    snap.forEach(child => {
                                        const msg = child.val();
                                        if(msg.sender_id != window.myUserId && msg.status !== 'read') {
                                            updates[`chats/${chatId}/messages/${child.key}/status`] = 'read';
                                        }
                                    });
                                    if(Object.keys(updates).length > 0) {
                                        window.update(window.ref(window.db), updates);
                                    }
                                }
                            });
                        }
                    }
                });

                if (action === 'archive') {
                    localStorage.setItem('archived_chats', JSON.stringify(window.archivedChats));
                    window.sortSidebar();
                    window.showToast?.('Archived', `Selected chats archived.`);
                } else if (action === 'read') {
                    window.showToast?.('Marked Read', `Selected chats marked as read.`);
                } else if (action === 'mute') {
                    window.showToast?.('Muted', `Selected chats muted.`);
                }

                window.closeSelectChatsMode();
            };
        });
    </script>
</div>
<?php /**PATH D:\xampp\htdocs\laravel\chat_app\resources\views/chat/sidebar.blade.php ENDPATH**/ ?>