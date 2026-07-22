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

    .user-chat-item.active:hover .options-btn-gradient {
        background: linear-gradient(to left, #374248 50%, transparent 100%) !important;
    }

    .user-chat-item.active {
        background-color: #2a3942 !important;
    }

    .user-chat-item.active:hover {
        background-color: #374248 !important;
    }

    /* Hide divider borders on hover and active state with smooth transition */
    .user-chat-item > div.flex-1 {
        transition: border-color 0.15s ease-in-out;
    }

    .user-chat-item:hover > div.flex-1,
    .user-chat-item.active > div.flex-1 {
        border-color: transparent !important;
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
                <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=2a3942&color=fff' }}"
                    class="w-full h-full object-cover my-avatar">
            </div>
            <span class="font-semibold text-[#e9edef]"><span class="settings-profile-name">{{ auth()->user()->name }}</span> (You)</span>
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
                    <button onclick="window.showBroadcastLists()"
                        class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px]">
                        <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor"
                            class="text-[#aebac1]">
                            <path d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm8.94 3c-.46-4.17-3.77-7.48-7.94-7.94V1h-2v2.06C6.83 3.52 3.52 6.83 3.06 11H1v2h2.06c.46 4.17 3.77 7.48 7.94 7.94V23h2v-2.06c4.17-.46 7.48-3.77 7.94-7.94H23v-2h-2.06zM12 19c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7z"/>
                        </svg>
                        Broadcast lists
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
            
            <!-- Selected Filter Chip (Injected via JS) -->
            <div id="search_selected_filter_chip" class="hidden items-center gap-1.5 bg-[#0a332c] rounded-full px-2 py-1 shrink-0 ml-2"></div>

            <input type="text" id="sidebar_search" oninput="window.handleSidebarSearchInput ? window.handleSidebarSearchInput() : window.filterSidebar()"
                onfocus="onSidebarSearchFocus()" onblur="onSidebarSearchBlur()"
                placeholder="Ask Meta AI or Search" autocomplete="off"
                class="bg-transparent border-none focus:ring-0 w-full text-[13px] ml-4 text-[#d1d7db] placeholder-[#8696a0] outline-none">
            
            <div class="flex items-center gap-1 shrink-0">
                <!-- List View Icon (Hidden initially) -->
                <button id="sidebar_search_list_view" onclick="window.toggleGlobalSearchLayout()" class="hidden text-[#8696a0] hover:text-[#e9edef] transition-colors p-1">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" id="sidebar_search_list_view_icon">
                        <path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z"></path>
                    </svg>
                </button>
                <!-- Clear button -->
                <button id="sidebar_search_clear" onclick="clearSidebarSearch()"
                    class="hidden text-[#8696a0] hover:text-[#e9edef] transition-colors p-0.5">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Chat Filters -->
        <div id="chat_filters_container" class="flex items-center gap-2 px-1 overflow-x-auto custom-scrollbar pb-1 transition-all duration-200">
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

        <!-- Global Search Filters (Hidden initially) -->
        <div id="global_search_filters_container" class="hidden items-center gap-2 px-1 overflow-x-auto custom-scrollbar pb-1 transition-all duration-200">
            <button onmousedown="event.preventDefault(); window.setGlobalSearchFilter(this, 'unread')" class="global-search-filter flex items-center gap-1.5 bg-[#202c33] hover:bg-[#2a3942] rounded-full px-3 py-1.5 shrink-0 transition-colors">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" class="text-[#aebac1]">
                    <path d="M18.8 6c.9 0 1.7.8 1.7 1.7v10.6c0 .9-.8 1.7-1.7 1.7H5.2c-.9 0-1.7-.8-1.7-1.7V7.7C3.5 6.8 4.3 6 5.2 6h13.6zm0 1.2H5.2c-.3 0-.5.2-.5.5v1.2l7.3 4.6 7.3-4.6V7.7c0-.3-.2-.5-.5-.5zm-13.6 11h13.6c.3 0 .5-.2.5-.5V9.4l-7.3 4.6-7.3-4.6v8.3c0 .3.2.5.5.5z"></path>
                </svg>
                <span class="text-[#aebac1] text-[13px] font-medium">Unread</span>
            </button>
            <button onmousedown="event.preventDefault(); window.setGlobalSearchFilter(this, 'photos')" class="global-search-filter flex items-center gap-1.5 bg-[#202c33] hover:bg-[#2a3942] rounded-full px-3 py-1.5 shrink-0 transition-colors">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" class="text-[#aebac1]">
                    <path d="M21.1 5.3h-1.5l-1-1.3C18 3.3 17.3 3 16.5 3h-9C6.7 3 6 3.3 5.4 4L4.4 5.3H2.9C1.3 5.3 0 6.6 0 8.2v10.6C0 20.4 1.3 21.7 2.9 21.7h18.2c1.6 0 2.9-1.3 2.9-2.9V8.2c0-1.6-1.3-2.9-2.9-2.9zM12 18.5c-3.1 0-5.7-2.5-5.7-5.7s2.5-5.7 5.7-5.7 5.7 2.5 5.7 5.7-2.5 5.7-5.7 5.7zm0-9.8c-2.3 0-4.1 1.8-4.1 4.1s1.8 4.1 4.1 4.1 4.1-1.8 4.1-4.1-1.8-4.1-4.1-4.1z"></path>
                </svg>
                <span class="text-[#aebac1] text-[13px] font-medium">Photos</span>
            </button>
            <button onmousedown="event.preventDefault(); window.setGlobalSearchFilter(this, 'videos')" class="global-search-filter flex items-center gap-1.5 bg-[#202c33] hover:bg-[#2a3942] rounded-full px-3 py-1.5 shrink-0 transition-colors">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" class="text-[#aebac1]">
                    <path d="M17.3 5.6H2.7C1.2 5.6 0 6.8 0 8.3v7.4C0 17.2 1.2 18.4 2.7 18.4h14.6c1.5 0 2.7-1.2 2.7-2.7V8.3c0-1.5-1.2-2.7-2.7-2.7zm.8 9.2L22 17.2c.4.3 1-.1 1-.5V7.3c0-.4-.6-.8-1-.5l-3.9 2.4v5.6z"></path>
                </svg>
                <span class="text-[#aebac1] text-[13px] font-medium">Videos</span>
            </button>
            <button onmousedown="event.preventDefault(); window.setGlobalSearchFilter(this, 'links')" class="global-search-filter flex items-center gap-1.5 bg-[#202c33] hover:bg-[#2a3942] rounded-full px-3 py-1.5 shrink-0 transition-colors">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" class="text-[#aebac1]">
                    <path d="M8.8 14.8c-.8.8-2 .8-2.8 0l-2.8-2.8c-.8-.8-.8-2 0-2.8l2.8-2.8c.8-.8 2-.8 2.8 0 .3.3.5.7.7 1.2l1.6-.9c-.3-.9-.9-1.6-1.6-2.3-1.6-1.6-4.1-1.6-5.7 0L1 7.2C-.6 8.8-.6 11.3 1 12.9l2.8 2.8c1.6 1.6 4.1 1.6 5.7 0 .5-.5 1-1.2 1.3-2l-1.5-1c-.2.7-.4 1.4-1.3 2.1zm5.4-8.7c-.5.5-1 1.2-1.3 2l1.5 1c.2-.7.4-1.4 1.3-2.1.8-.8 2-.8 2.8 0l2.8 2.8c.8.8.8 2 0 2.8l-2.8 2.8c-.8.8-2 .8-2.8 0-.3-.3-.5-.7-.7-1.2l-1.6.9c.3.9.9 1.6 1.6 2.3 1.6 1.6 4.1 1.6 5.7 0l2.8-2.8c1.6-1.6 1.6-4.1 0-5.7l-2.8-2.8c-1.6-1.6-4.1-1.6-5.7 0z"></path>
                </svg>
                <span class="text-[#aebac1] text-[13px] font-medium">Links</span>
            </button>
            <button onmousedown="event.preventDefault(); window.setGlobalSearchFilter(this, 'gifs')" class="global-search-filter flex items-center gap-1.5 bg-[#202c33] hover:bg-[#2a3942] rounded-full px-3 py-1.5 shrink-0 transition-colors">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" class="text-[#aebac1]">
                    <path d="M11.5 9H13v6h-1.5V9zM9 9H6c-.6 0-1 .5-1 1v4c0 .5.4 1 1 1h3c.6 0 1-.5 1-1v-2H8.5v1.5h-1.5v-3H10V10c0-.6-.4-1-1-1zm10 1.5V9h-4.5v6H16v-2h2v-1.5h-2v-1h3z"></path>
                </svg>
                <span class="text-[#aebac1] text-[13px] font-medium">GIFs</span>
            </button>
            <button onmousedown="event.preventDefault(); window.setGlobalSearchFilter(this, 'audio')" class="global-search-filter flex items-center gap-1.5 bg-[#202c33] hover:bg-[#2a3942] rounded-full px-3 py-1.5 shrink-0 transition-colors">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" class="text-[#aebac1]">
                    <path d="M12 3a9 9 0 0 0-9 9v7c0 1.1.9 2 2 2h4v-8H5v-1c0-3.9 3.1-7 7-7s7 3.1 7 7v1h-4v8h4c1.1 0 2-.9 2-2v-7a9 9 0 0 0-9-9z"></path>
                </svg>
                <span class="text-[#aebac1] text-[13px] font-medium">Audio</span>
            </button>
            <button onmousedown="event.preventDefault(); window.setGlobalSearchFilter(this, 'documents')" class="global-search-filter flex items-center gap-1.5 bg-[#202c33] hover:bg-[#2a3942] rounded-full px-3 py-1.5 shrink-0 transition-colors">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" class="text-[#aebac1]">
                    <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"></path>
                </svg>
                <span class="text-[#aebac1] text-[13px] font-medium">Documents</span>
            </button>
            <button onmousedown="event.preventDefault(); window.setGlobalSearchFilter(this, 'stickers')" class="global-search-filter flex items-center gap-1.5 bg-[#202c33] hover:bg-[#2a3942] rounded-full px-3 py-1.5 shrink-0 transition-colors">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" class="text-[#aebac1]">
                    <path d="M19.5 4h-15C3.1 4 2 5.1 2 6.5v11C2 18.9 3.1 20 4.5 20h10l7-7V6.5C21.5 5.1 20.4 4 19.5 4zm.5 8h-4.5V20l4.5-4.5V12z"></path>
                </svg>
                <span class="text-[#aebac1] text-[13px] font-medium">Stickers</span>
            </button>
            <button onmousedown="event.preventDefault(); window.setGlobalSearchFilter(this, 'polls')" class="global-search-filter flex items-center gap-1.5 bg-[#202c33] hover:bg-[#2a3942] rounded-full px-3 py-1.5 shrink-0 transition-colors">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" class="text-[#aebac1]">
                    <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <span class="text-[#aebac1] text-[13px] font-medium">Polls</span>
            </button>
            <button onmousedown="event.preventDefault(); window.setGlobalSearchFilter(this, 'contacts')" class="global-search-filter flex items-center gap-1.5 bg-[#202c33] hover:bg-[#2a3942] rounded-full px-3 py-1.5 shrink-0 transition-colors">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" class="text-[#aebac1]">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                </svg>
                <span class="text-[#aebac1] text-[13px] font-medium">Contacts</span>
            </button>
            <button onmousedown="event.preventDefault(); window.setGlobalSearchFilter(this, 'non-contacts')" class="global-search-filter flex items-center gap-1.5 bg-[#202c33] hover:bg-[#2a3942] rounded-full px-3 py-1.5 shrink-0 transition-colors">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" class="text-[#aebac1]">
                    <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                </svg>
                <span class="text-[#aebac1] text-[13px] font-medium">Non-contacts</span>
            </button>
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
        @foreach ($users ?? [] as $user)
            @php
                $userAvatar =
                    $user->avatar ??
                    'https://ui-avatars.com/api/?name=' .
                        urlencode($user->saved_name ?? $user->name ?: $user->phone) .
                        '&background=2a3942&color=fff';
                $displayName = $user->saved_name ?? ($user->name ?: $user->phone);
                // Hide users by default if they are not a contact (they will be unhidden by Firebase if a chat exists)
                $visibilityClass = $user->is_contact ?? false ? 'flex' : 'hidden';
            @endphp
            <div onclick="window.selectChat({{ $user->id }}, '{{ addslashes($displayName) }}', '{{ addslashes($user->phone ?? '') }}', '{{ $userAvatar }}', '{{ addslashes($user->about ?? 'Available') }}')"
                class="{{ $visibilityClass }} relative items-center px-3 py-3 hover:bg-[#202c33] cursor-pointer transition-colors user-chat-item group"
                id="user_sidebar_{{ $user->id }}" data-name="{{ $displayName }}"
                data-avatar="{{ $userAvatar }}" data-phone="{{ $user->phone ?? '' }}"
                data-about="{{ $user->about ?? 'Available' }}" data-userid="{{ $user->id }}"
                data-timestamp="0" data-is-contact="{{ $user->is_contact ?? false ? 'true' : 'false' }}">
                <div id="avatar_wrapper_user_{{ $user->id }}"
                    class="relative w-12 h-12 rounded-full bg-[#2a3942] flex items-center justify-center shrink-0">
                    <img src="{{ $userAvatar }}" class="w-full h-full object-cover rounded-full">
                </div>
                <div class="ml-3 flex-1 border-b border-[#202c33] pb-3 pt-1 min-w-0 pr-6 relative">
                    <div class="flex justify-between items-center">
                        <h4 class="text-[17px] text-[#e9edef] truncate mr-2 font-normal">
                            {{ $displayName }}
                        </h4>
                        <span class="text-[12px] text-[#8696a0] whitespace-nowrap"
                            id="last_time_{{ $user->id }}"></span>
                    </div>
                    <div class="flex justify-between items-center mt-0.5">
                        <p class="text-[14px] text-[#8696a0] truncate flex-1 min-w-0 leading-snug"
                            id="last_msg_{{ $user->id }}">
                            Click to chat
                        </p>
                        <div class="flex items-center gap-2 shrink-0">
                            <!-- Pin Icon -->
                            <span id="pin_icon_{{ $user->id }}" class="hidden text-[#8696a0]">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                                    <path d="M16 12V4h1V2H7v2h1v8l-2 2v2h5.2v6h1.6v-6H18v-2l-2-2z" />
                                </svg>
                            </span>
                            <!-- Unread Badge -->
                            <span id="unread_badge_{{ $user->id }}"
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
                        onclick="event.stopPropagation(); window.toggleUserContextMenu(event, {{ $user->id }}, '{{ addslashes($displayName) }}', 'user')"
                        class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none">
                        <svg viewBox="0 0 19 20" width="19" height="20" fill="currentColor">
                            <path d="M3.8 6.7l5.7 5.7 5.7-5.7 1.6 1.6-7.3 7.2-7.3-7.2 1.6-1.6z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Global Search Results Container (Hidden initially) -->
    <div class="hidden flex-col flex-1 overflow-y-auto custom-scrollbar bg-[#111b21]" id="global_search_results_container">
        
        <div class="px-5 py-3 text-[#8696a0] text-[13px] font-medium tracking-wide">
            RECENT
        </div>
        
        <!-- Grid layout for photos -->
        <div class="grid grid-cols-3 gap-[2px]">
            <div class="aspect-square bg-[#202c33] cursor-pointer hover:opacity-90 transition-opacity">
                <img src="https://images.unsplash.com/photo-1575936123452-b67c3203c357?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover">
            </div>
            <div class="aspect-square bg-[#202c33] cursor-pointer hover:opacity-90 transition-opacity">
                <img src="https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover">
            </div>
            <div class="aspect-square bg-[#202c33] cursor-pointer hover:opacity-90 transition-opacity">
                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover">
            </div>
        </div>

        <div class="px-5 py-3 text-[#8696a0] text-[13px] font-medium tracking-wide mt-1">
            LAST WEEK
        </div>

        <div class="grid grid-cols-3 gap-[2px]">
            <div class="aspect-square bg-[#202c33] cursor-pointer hover:opacity-90 transition-opacity">
                <img src="https://images.unsplash.com/photo-1472214103451-9374bd1c798e?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover">
            </div>
            <div class="aspect-square bg-[#202c33] cursor-pointer hover:opacity-90 transition-opacity">
                <img src="https://images.unsplash.com/photo-1532274402911-5a369e4c4bb5?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover">
            </div>
            <div class="aspect-square bg-[#202c33] cursor-pointer hover:opacity-90 transition-opacity">
                <img src="https://images.unsplash.com/photo-1542273917363-3b1817f69a5d?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover">
            </div>
            <div class="aspect-square bg-[#202c33] cursor-pointer hover:opacity-90 transition-opacity">
                <img src="https://images.unsplash.com/photo-1517816743773-6e0fd518b4a6?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover">
            </div>
            <div class="aspect-square bg-[#202c33] cursor-pointer hover:opacity-90 transition-opacity">
                <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover">
            </div>
            <div class="aspect-square bg-[#202c33] cursor-pointer hover:opacity-90 transition-opacity">
                <img src="https://images.unsplash.com/photo-1470071131384-001b85755536?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover">
            </div>
            <div class="aspect-square bg-[#202c33] cursor-pointer hover:opacity-90 transition-opacity">
                <img src="https://images.unsplash.com/photo-1447752875215-b2761acb3c5d?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover">
            </div>
            <div class="aspect-square bg-[#202c33] cursor-pointer hover:opacity-90 transition-opacity">
                <img src="https://images.unsplash.com/photo-1433086966358-54859d0ed716?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover">
            </div>
            <div class="aspect-square bg-[#202c33] cursor-pointer hover:opacity-90 transition-opacity">
                <img src="https://images.unsplash.com/photo-1426604966848-d7adac402bff?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover">
            </div>
        </div>
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
            window.hiddenChats = JSON.parse(localStorage.getItem('hidden_chats') || '[]');
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

                    // Hide hidden chats from all views
                    if (window.hiddenChats && window.hiddenChats.includes(item.id)) {
                        matchesFilter = false;
                    }

                    // Hide deleted chats unless new message exists (timestamp > cleared timestamp)
                    // Hide deleted chats unless new message exists (timestamp > cleared timestamp)
                    if (window.deletedChats.includes(item.id)) {
                        const itemTime = parseFloat(item.getAttribute('data-timestamp') || '0');
                        const clearedTime = (window.clearedChats[item.id] || 0) * 1000;
                        if (itemTime <= clearedTime) {
                            matchesFilter = false;
                        }
                    }

                    // Hide community sub-groups from the main chat list (only show announcement/root community row)
                    const commId = item.getAttribute('data-community-id');
                    const isAnnounce = item.getAttribute('data-is-announcement') === 'true';
                    if (commId && !isAnnounce) {
                        matchesFilter = false;
                    }

                    // Global Search Filters (Contacts, Non-contacts)
                    if (matchesFilter) {
                        if (window.currentGlobalSearchFilter === 'contacts') {
                            if (item.getAttribute('data-is-contact') !== 'true' || item.id.startsWith('group_sidebar_')) {
                                matchesFilter = false;
                            }
                        } else if (window.currentGlobalSearchFilter === 'non-contacts') {
                            if (item.getAttribute('data-is-contact') === 'true' || item.id.startsWith('group_sidebar_')) {
                                matchesFilter = false;
                            }
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

                 let chatIdToClear = null;
                 if (type === 'group') {
                     chatIdToClear = String(targetId);
                     if (!chatIdToClear.startsWith('group_')) {
                         chatIdToClear = 'group_' + chatIdToClear;
                     }
                 } else {
                     const minId = Math.min(window.myUserId, targetId);
                     const maxId = Math.max(window.myUserId, targetId);
                     chatIdToClear = `chat_${minId}_${maxId}`;
                 }

                 if (chatIdToClear && window.globalMediaCache) {
                     window.globalMediaCache = window.globalMediaCache.filter(m => m.chatId !== chatIdToClear);
                 }
                 if (window.updateContactInfoMediaSection) {
                     window.updateContactInfoMediaSection();
                 }

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

                 let chatIdToClear = null;
                 if (type === 'group') {
                     chatIdToClear = String(targetId);
                     if (!chatIdToClear.startsWith('group_')) {
                         chatIdToClear = 'group_' + chatIdToClear;
                     }
                 } else {
                     const minId = Math.min(window.myUserId, targetId);
                     const maxId = Math.max(window.myUserId, targetId);
                     chatIdToClear = `chat_${minId}_${maxId}`;
                 }

                 if (chatIdToClear && window.globalMediaCache) {
                     window.globalMediaCache = window.globalMediaCache.filter(m => m.chatId !== chatIdToClear);
                 }
                 if (window.updateContactInfoMediaSection) {
                     window.updateContactInfoMediaSection();
                 }

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
                    if (type === 'group' && window.currentGroupId == targetId) {
                        document.getElementById('group_header_mute_icon')?.classList.remove('hidden');
                    } else if (type === 'user' && window.activeChatUser && window.activeChatUser.id == targetId) {
                        document.getElementById('private_header_mute_icon')?.classList.remove('hidden');
                    }
                } else {
                    window.showToast?.('Unmute Notifications', `Notifications have been unmuted.`);
                    if (type === 'group' && window.currentGroupId == targetId) {
                        document.getElementById('group_header_mute_icon')?.classList.add('hidden');
                    } else if (type === 'user' && window.activeChatUser && window.activeChatUser.id == targetId) {
                        document.getElementById('private_header_mute_icon')?.classList.add('hidden');
                    }
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
                            if (msg.type === 'image') content = 'ðŸ“· Photo';
                            else if (msg.type === 'video') content = 'ðŸŽ¥ Video';
                            else if (msg.type === 'audio') content = 'ðŸŽ¤ Voice message';
                            else if (msg.type === 'document') content = `ðŸ“„ ${msg.file_name || 'Document'}`;

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
        window.handleChatContextMenu = function(e, chatId, chatType) {
            e.preventDefault();
            const rect = e.currentTarget.getBoundingClientRect();
            window.showContextMenu(chatId, chatType, e.clientX, e.clientY);
        };

        window.handleSidebarSearchInput = function() {
            const isGlobalSearch = !document.getElementById('global_search_results_container')?.classList.contains('hidden');
            
            if (isGlobalSearch) {
                const clearBtn = document.getElementById('sidebar_search_clear');
                if (document.getElementById('sidebar_search').value.trim() !== '') {
                    clearBtn?.classList.remove('hidden');
                    clearBtn?.classList.add('block');
                } else {
                    clearBtn?.classList.add('hidden');
                    clearBtn?.classList.remove('block');
                }
                const filter = window.currentGlobalSearchFilter;
                if (filter === 'photos' && window.renderGlobalSearchPhotos) {
                    window.renderGlobalSearchPhotos();
                } else if (filter === 'videos' && window.renderGlobalSearchVideos) {
                    window.renderGlobalSearchVideos();
                } else if (filter === 'links' && window.renderGlobalSearchLinks) {
                    window.renderGlobalSearchLinks();
                } else if (filter === 'gifs' && window.renderGlobalSearchGifs) {
                    window.renderGlobalSearchGifs();
                } else if (filter === 'stickers' && window.renderGlobalSearchStickers) {
                    window.renderGlobalSearchStickers();
                } else if (filter === 'polls' && window.renderGlobalSearchPolls) {
                    window.renderGlobalSearchPolls();
                } else if (filter === 'audio' && window.renderGlobalSearchAudio) {
                    window.renderGlobalSearchAudio();
                } else if (filter === 'documents' && window.renderGlobalSearchDocuments) {
                    window.renderGlobalSearchDocuments();
                }
                return;
            }
            if (typeof window.filterSidebar === 'function') {
                window.filterSidebar();
            }
        };

        window.setGlobalSearchFilter = function(activeBtn, filter) {
            // Handle filter selection styling
            document.querySelectorAll('.global-search-filter').forEach(btn => {
                btn.classList.remove('bg-[#0a332c]');
                btn.classList.add('bg-[#202c33]');
                btn.querySelector('svg').classList.remove('text-[#00a884]');
                btn.querySelector('span').classList.remove('text-[#00a884]');
                
                btn.querySelector('svg').classList.add('text-[#aebac1]');
                btn.querySelector('span').classList.add('text-[#aebac1]');
            });
            
            activeBtn.classList.remove('bg-[#202c33]');
            activeBtn.classList.add('bg-[#0a332c]');
            
            activeBtn.querySelector('svg').classList.remove('text-[#aebac1]');
            activeBtn.querySelector('svg').classList.add('text-[#00a884]');
            activeBtn.querySelector('span').classList.remove('text-[#aebac1]');
            activeBtn.querySelector('span').classList.add('text-[#00a884]');
            
            // Extract SVG and Text from the clicked button
            const iconHTML = activeBtn.querySelector('svg').outerHTML;
            const textHTML = activeBtn.querySelector('span').innerText;
            
            // Show the inner chip in search input
            const chipContainer = document.getElementById('search_selected_filter_chip');
            chipContainer.innerHTML = iconHTML + '<span class="text-[13px] font-medium">' + textHTML + '</span>';
            chipContainer.classList.remove('hidden');
            chipContainer.classList.add('flex');
            
            // Update search placeholder and icon
            const searchInput = document.getElementById('sidebar_search');
            searchInput.placeholder = 'Search...';
            searchInput.classList.remove('ml-4');
            searchInput.classList.add('ml-2');
            
            // Show list view icon
            if (['photos', 'videos', 'gifs', 'stickers', 'polls'].includes(filter)) {
                document.getElementById('sidebar_search_list_view')?.classList.remove('hidden');
                document.getElementById('sidebar_search_list_view')?.classList.add('block');
            } else {
                document.getElementById('sidebar_search_list_view')?.classList.add('hidden');
                document.getElementById('sidebar_search_list_view')?.classList.remove('block');
            }
            
            // Show clear button immediately (since we have a filter active)
            document.getElementById('sidebar_search_clear')?.classList.remove('hidden');
            document.getElementById('sidebar_search_clear')?.classList.add('block');
            
            // Toggle view depending on filter
            window.currentGlobalSearchFilter = filter;
            if (['photos', 'videos', 'links', 'gifs', 'audio', 'documents', 'stickers', 'polls'].includes(filter)) {
                document.getElementById('user_list_container')?.classList.add('hidden');
                document.getElementById('search_results_container')?.classList.add('hidden');
                document.getElementById('sidebar_no_results')?.classList.add('hidden');
                document.getElementById('global_search_results_container')?.classList.remove('hidden');
                document.getElementById('global_search_results_container')?.classList.add('flex');
                if (filter === 'photos' && window.renderGlobalSearchPhotos) {
                    window.renderGlobalSearchPhotos();
                } else if (filter === 'videos' && window.renderGlobalSearchVideos) {
                    window.renderGlobalSearchVideos();
                } else if (filter === 'links' && window.renderGlobalSearchLinks) {
                    window.renderGlobalSearchLinks();
                } else if (filter === 'gifs' && window.renderGlobalSearchGifs) {
                    window.renderGlobalSearchGifs();
                } else if (filter === 'stickers' && window.renderGlobalSearchStickers) {
                    window.renderGlobalSearchStickers();
                } else if (filter === 'polls' && window.renderGlobalSearchPolls) {
                    window.renderGlobalSearchPolls();
                } else if (filter === 'audio' && window.renderGlobalSearchAudio) {
                    window.renderGlobalSearchAudio();
                } else if (filter === 'documents' && window.renderGlobalSearchDocuments) {
                    window.renderGlobalSearchDocuments();
                }
            } else {
                document.getElementById('user_list_container')?.classList.remove('hidden');
                document.getElementById('global_search_results_container')?.classList.add('hidden');
                document.getElementById('global_search_results_container')?.classList.remove('flex');
                if (typeof window.filterSidebar === 'function') {
                    window.filterSidebar();
                }
            }
            
            // Hide all filter buttons since one is selected
            document.getElementById('global_search_filters_container')?.classList.add('hidden');
            document.getElementById('global_search_filters_container')?.classList.remove('flex');
            document.getElementById('chat_filters_container')?.classList.add('hidden');
            document.getElementById('chat_filters_container')?.classList.remove('flex');
        };

        window.globalSearchPhotoLayout = 'grid'; // Default layout
        window.globalSearchVideoLayout = 'grid';
        window.globalSearchGIFLayout = 'grid';
        window.globalSearchStickerLayout = 'grid';

        window.toggleGlobalSearchLayout = function() {
            const iconSvg = document.getElementById('sidebar_search_list_view_icon');
            if (window.globalSearchPhotoLayout === 'grid') {
                window.globalSearchPhotoLayout = 'list';
                window.globalSearchVideoLayout = 'list';
                window.globalSearchGIFLayout = 'list';
                window.globalSearchStickerLayout = 'list';
                iconSvg.innerHTML = '<path d="M3 3h8v8H3zm0 10h8v8H3zM13 3h8v8h-8zm0 10h8v8h-8z"></path>';
            } else {
                window.globalSearchPhotoLayout = 'grid';
                window.globalSearchVideoLayout = 'grid';
                window.globalSearchGIFLayout = 'grid';
        window.globalSearchStickerLayout = 'grid';
                iconSvg.innerHTML = '<path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z"></path>';
            }
            if (!document.getElementById('global_search_results_container').classList.contains('hidden')) {
                const filter = window.currentGlobalSearchFilter;
                if (filter === 'photos' && window.renderGlobalSearchPhotos) {
                    window.renderGlobalSearchPhotos();
                } else if (filter === 'videos' && window.renderGlobalSearchVideos) {
                    window.renderGlobalSearchVideos();
                } else if (filter === 'gifs' && window.renderGlobalSearchGifs) {
                    window.renderGlobalSearchGifs();
                } else if (filter === 'stickers' && window.renderGlobalSearchStickers) {
                    window.renderGlobalSearchStickers();
                } else if (filter === 'polls' && window.renderGlobalSearchPolls) {
                    window.renderGlobalSearchPolls();
                } else if (filter === 'links' && window.renderGlobalSearchLinks) {
                    window.renderGlobalSearchLinks();
                } else if (filter === 'audio' && window.renderGlobalSearchAudio) {
                    window.renderGlobalSearchAudio();
                } else if (filter === 'documents' && window.renderGlobalSearchDocuments) {
                    window.renderGlobalSearchDocuments();
                }
            }
        };

        window.openLinkInChat = function(key, chatId, isGroup) {
            let cId = chatId;
            if (chatId.startsWith('group_')) {
                cId = chatId.replace('group_', '');
            } else {
                const ids = chatId.replace('chat_', '').split('_');
                cId = ids.find(id => id != window.myUserId) || window.myUserId;
            }
            
            let name = 'Chat';
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
                if (window.selectGroupChat) window.selectGroupChat(cId, name, avatar, key);
            } else {
                if (window.selectChat) window.selectChat(cId, name, '', avatar, status, key);
            }
            
            if (window.closeGlobalSearch) window.closeGlobalSearch();
        };

        window.renderGlobalSearchLinks = function() {
            const container = document.getElementById('global_search_results_container');
            if (!container) return;

            let allLinks = [];
            const linkRegex = /(https?:\/\/[^\s]+|www\.[^\s]+)/gi;

            const processMessage = (msg, chatId) => {
                if (msg.text && linkRegex.test(msg.text)) {
                    // Extract first link match
                    linkRegex.lastIndex = 0; // reset regex
                    const matches = msg.text.match(linkRegex);
                    if (matches && matches.length > 0) {
                        const url = matches[0];
                        let domain = 'Link';
                        try {
                            let urlStr = url;
                            if (!urlStr.toLowerCase().startsWith('http://') && !urlStr.toLowerCase().startsWith('https://')) {
                                urlStr = 'http://' + urlStr;
                            }
                            const urlObj = new URL(urlStr);
                            domain = urlObj.hostname;
                        } catch (e) {
                            domain = 'Link';
                        }
                        
                        allLinks.push({
                            ...msg,
                            chatId: chatId,
                            url: url,
                            domain: domain
                        });
                    }
                }
            };

            if (window.messageCache) {
                Object.entries(window.messageCache).forEach(([chatId, chatMessages]) => {
                    chatMessages.forEach(msg => processMessage(msg, chatId));
                });
            }
            if (window.groupMessagesCache) {
                Object.entries(window.groupMessagesCache).forEach(([groupId, chatMessages]) => {
                    chatMessages.forEach(msg => processMessage(msg, 'group_' + groupId));
                });
            }

            const searchQuery = document.getElementById('sidebar_search')?.value.toLowerCase().trim() || '';

            allLinks = allLinks.map(linkObj => {
                let chatName = 'Unknown Chat';
                let chatAvatar = '';
                let isGroup = false;

                if (linkObj.chatId) {
                    if (linkObj.chatId.startsWith('group_')) {
                        isGroup = true;
                        const groupId = linkObj.chatId.replace('group_', '');
                        const groupEl = document.getElementById(`group_sidebar_${groupId}`);
                        if (groupEl) {
                            chatName = groupEl.getAttribute('data-name') || chatName;
                            chatAvatar = groupEl.getAttribute('data-avatar') || '';
                        }
                    } else {
                        const ids = linkObj.chatId.replace('chat_', '').split('_');
                        const targetId = ids.find(id => id != window.myUserId) || window.myUserId;
                        const userEl = document.getElementById(`user_sidebar_${targetId}`);
                        if (userEl) {
                            chatName = userEl.getAttribute('data-name') || chatName;
                            chatAvatar = userEl.getAttribute('data-avatar') || '';
                        }
                    }
                }

                let senderName = '';
                if (isGroup && linkObj.senderId) {
                    const senderEl = document.getElementById(`user_sidebar_${linkObj.senderId}`);
                    if (senderEl) {
                        senderName = senderEl.getAttribute('data-name') || '';
                    } else if (linkObj.senderId == window.myUserId) {
                        senderName = 'You';
                    }
                } else if (!isGroup && linkObj.senderId == window.myUserId) {
                    senderName = 'You';
                } else if (!isGroup) {
                    senderName = chatName;
                }

                return {
                    ...linkObj,
                    resolvedChatName: chatName,
                    resolvedChatAvatar: chatAvatar,
                    resolvedSenderName: senderName,
                    isGroup: isGroup
                };
            });

            // Filtering by search query if any
            if (searchQuery !== '') {
                allLinks = allLinks.filter(linkObj => {
                    const cName = (linkObj.resolvedChatName || '').toLowerCase();
                    const text = (linkObj.text || '').toLowerCase();
                    const urlVal = (linkObj.url || '').toLowerCase();
                    const domainVal = (linkObj.domain || '').toLowerCase();
                    return cName.includes(searchQuery) || text.includes(searchQuery) || urlVal.includes(searchQuery) || domainVal.includes(searchQuery);
                });
            }

            if (allLinks.length === 0) {
                container.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                        <svg class="w-16 h-16 text-[#3b4a54] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                        <p class="text-[#8696a0] text-[14px]">No links found</p>
                    </div>
                `;
                return;
            }

            // Time helpers
            const extractFirebaseTime = (id) => {
                if (!id || typeof id !== 'string' || id.length < 8 || !id.startsWith('-')) return 0;
                const PUSH_CHARS = '-0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
                let time = 0;
                for (let i = 0; i < 8; i++) {
                    time = time * 64 + PUSH_CHARS.indexOf(id.charAt(i));
                }
                return time;
            };

            allLinks = allLinks.map(linkObj => {
                let timestampMs = (linkObj.time && linkObj.time.toString().length <= 10) ? linkObj.time * 1000 : linkObj.time;
                if (!timestampMs || timestampMs < 315532800000 || isNaN(new Date(timestampMs).getTime())) {
                    if (linkObj.key && !isNaN(Number(linkObj.key)) && Number(linkObj.key) > 315532800000) {
                        timestampMs = Number(linkObj.key);
                    } else {
                        const extracted = extractFirebaseTime(linkObj.key);
                        if (extracted > 0) timestampMs = extracted;
                    }
                }
                return { ...linkObj, normalizedTime: timestampMs || 0 };
            });

            // Sort newest first
            allLinks.sort((a, b) => b.normalizedTime - a.normalizedTime);

            // Group into Starred vs Normal
            const starredLinks = [];
            const normalLinks = [];

            allLinks.forEach(linkObj => {
                const isStarred = linkObj.is_starred || (window.starredMsgKeys && window.starredMsgKeys.has(linkObj.key));
                if (isStarred) {
                    starredLinks.push(linkObj);
                } else {
                    normalLinks.push(linkObj);
                }
            });

            // Group normal links by date
            const groups = {};
            const groupKeys = [];
            const now = new Date();
            const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
            const startOfDay = (date) => new Date(date.getFullYear(), date.getMonth(), date.getDate());

            normalLinks.forEach(linkObj => {
                const linkDate = new Date(linkObj.normalizedTime);
                const linkDay = startOfDay(linkDate);
                const diffTime = Math.abs(today - linkDay);
                const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
                
                let groupName = '';
                if (diffDays <= 7) {
                    groupName = 'RECENT';
                } else if (diffDays <= 14) {
                    groupName = 'LAST WEEK';
                } else if (diffDays <= 30) {
                    groupName = 'LAST MONTH';
                } else if (linkDate.getFullYear() === today.getFullYear()) {
                    const monthNames = ["JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"];
                    groupName = monthNames[linkDate.getMonth()];
                } else {
                    groupName = linkDate.getFullYear().toString();
                }

                if (linkDate.getFullYear() <= 1970) {
                    groupName = 'OLDER';
                }

                if (!groups[groupName]) {
                    groups[groupName] = [];
                    groupKeys.push(groupName);
                }
                groups[groupName].push(linkObj);
            });

            let html = '';

            // Render Helper for a single Link item
            const renderLinkItem = (linkObj) => {
                let senderInfo = linkObj.resolvedSenderName || linkObj.resolvedChatName;
                if (linkObj.isGroup && linkObj.resolvedSenderName) {
                    senderInfo = `${linkObj.resolvedSenderName} @ ${linkObj.resolvedChatName}`;
                }
                
                const timeStr = new Date(linkObj.normalizedTime).toLocaleDateString([], { month: '2-digit', day: '2-digit', year: '2-digit' });
                const escapedText = (linkObj.text || '').replace(/'/g, "\\'").replace(/"/g, '&quot;');
                
                return `
                    <div onclick="window.openLinkInChat('${linkObj.key}', '${linkObj.chatId}', ${linkObj.isGroup})" class="flex flex-col px-4 py-3 hover:bg-[#202c33] cursor-pointer border-b border-[#202c33]/40 transition-colors">
                        <div class="flex items-center justify-between mb-1.5">
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 rounded-full overflow-hidden bg-[#2a3942] shrink-0">
                                    ${linkObj.resolvedChatAvatar ? `<img src="${linkObj.resolvedChatAvatar}" class="w-full h-full object-cover">` : ''}
                                </div>
                                <span class="text-[13px] text-[#8696a0] font-medium truncate max-w-[170px]">${senderInfo}</span>
                            </div>
                            <span class="text-[11px] text-[#8696a0] shrink-0">${timeStr}</span>
                        </div>
                        ${linkObj.text ? `<div class="text-[14px] text-[#d1d7db] mb-2 leading-snug break-all" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">${escapedText}</div>` : ''}
                        <div class="flex items-center gap-3 p-2.5 bg-[#182229] rounded-[4px] border border-[#2f3b43]/30">
                            <div class="w-10 h-10 bg-[#202c33] flex items-center justify-center text-[#8696a0] rounded shrink-0">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                                    <path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-[13px] text-[#e9edef] truncate font-medium">${linkObj.domain}</div>
                                <div class="text-[11.5px] text-[#00a884] truncate">${linkObj.url}</div>
                            </div>
                        </div>
                    </div>
                `;
            };

            // 1. Render Starred Links first
            if (starredLinks.length > 0) {
                html += `
                    <div class="px-5 py-3 text-[#8696a0] text-[13px] font-medium tracking-wide">
                        Starred messages
                    </div>
                    <div class="flex flex-col">
                `;
                starredLinks.forEach(linkObj => {
                    html += renderLinkItem(linkObj);
                });
                html += `</div>`;
            }

            // 2. Render normal grouped links
            groupKeys.forEach((key, index) => {
                const mtClass = (index > 0 || starredLinks.length > 0) ? 'mt-1' : '';
                html += `
                    <div class="px-5 py-3 text-[#8696a0] text-[13px] font-medium tracking-wide ${mtClass}">
                        ${key}
                    </div>
                    <div class="flex flex-col">
                `;
                groups[key].forEach(linkObj => {
                    html += renderLinkItem(linkObj);
                });
                html += `</div>`;
            });

            container.innerHTML = html;
        };

        window.renderGlobalSearchAudio = function() {
            const container = document.getElementById('global_search_results_container');
            if (!container) return;

            let allAudios = [];
            if (window.messageCache) {
                Object.entries(window.messageCache).forEach(([chatId, chatMessages]) => {
                    chatMessages.forEach(msg => {
                        if (msg.type === 'audio' && msg.file_url) {
                            allAudios.push({...msg, chatId: chatId});
                        }
                    });
                });
            }
            if (window.groupMessagesCache) {
                Object.entries(window.groupMessagesCache).forEach(([groupId, chatMessages]) => {
                    chatMessages.forEach(msg => {
                        if (msg.type === 'audio' && msg.file_url) {
                            allAudios.push({...msg, chatId: 'group_' + groupId});
                        }
                    });
                });
            }

            const searchQuery = document.getElementById('sidebar_search')?.value.toLowerCase().trim() || '';

            allAudios = allAudios.map(audioObj => {
                let chatName = 'Unknown Chat';
                let chatAvatar = '';
                let isGroup = false;

                if (audioObj.chatId) {
                    if (audioObj.chatId.startsWith('group_')) {
                        isGroup = true;
                        const groupId = audioObj.chatId.replace('group_', '');
                        const groupEl = document.getElementById(`group_sidebar_${groupId}`);
                        if (groupEl) {
                            chatName = groupEl.getAttribute('data-name') || chatName;
                            chatAvatar = groupEl.getAttribute('data-avatar') || '';
                        }
                    } else {
                        const ids = audioObj.chatId.replace('chat_', '').split('_');
                        const targetId = ids.find(id => id != window.myUserId) || window.myUserId;
                        const userEl = document.getElementById(`user_sidebar_${targetId}`);
                        if (userEl) {
                            chatName = userEl.getAttribute('data-name') || chatName;
                            chatAvatar = userEl.getAttribute('data-avatar') || '';
                        }
                    }
                }

                let senderName = '';
                if (isGroup && audioObj.senderId) {
                    const senderEl = document.getElementById(`user_sidebar_${audioObj.senderId}`);
                    if (senderEl) {
                        senderName = senderEl.getAttribute('data-name') || '';
                    } else if (audioObj.senderId == window.myUserId) {
                        senderName = 'You';
                    }
                } else if (!isGroup && audioObj.senderId == window.myUserId) {
                    senderName = 'You';
                } else if (!isGroup) {
                    senderName = chatName;
                }

                return {
                    ...audioObj,
                    resolvedChatName: chatName,
                    resolvedChatAvatar: chatAvatar,
                    resolvedSenderName: senderName,
                    isGroup: isGroup
                };
            });

            // Filtering by search query if any
            if (searchQuery !== '') {
                allAudios = allAudios.filter(audioObj => {
                    const cName = (audioObj.resolvedChatName || '').toLowerCase();
                    const sName = (audioObj.resolvedSenderName || '').toLowerCase();
                    return cName.includes(searchQuery) || sName.includes(searchQuery);
                });
            }

            if (allAudios.length === 0) {
                container.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                        <svg class="w-16 h-16 text-[#3b4a54] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                        </svg>
                        <p class="text-[#8696a0] text-[14px]">No audio messages found</p>
                    </div>
                `;
                return;
            }

            // Time helpers
            const extractFirebaseTime = (id) => {
                if (!id || typeof id !== 'string' || id.length < 8 || !id.startsWith('-')) return 0;
                const PUSH_CHARS = '-0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
                let time = 0;
                for (let i = 0; i < 8; i++) {
                    time = time * 64 + PUSH_CHARS.indexOf(id.charAt(i));
                }
                return time;
            };

            allAudios = allAudios.map(audioObj => {
                let timestampMs = (audioObj.time && audioObj.time.toString().length <= 10) ? audioObj.time * 1000 : audioObj.time;
                if (!timestampMs || timestampMs < 315532800000 || isNaN(new Date(timestampMs).getTime())) {
                    if (audioObj.key && !isNaN(Number(audioObj.key)) && Number(audioObj.key) > 315532800000) {
                        timestampMs = Number(audioObj.key);
                    } else {
                        const extracted = extractFirebaseTime(audioObj.key);
                        if (extracted > 0) timestampMs = extracted;
                    }
                }
                return { ...audioObj, normalizedTime: timestampMs || 0 };
            });

            // Sort newest first
            allAudios.sort((a, b) => b.normalizedTime - a.normalizedTime);

            // Group into Starred vs Normal
            const starredAudios = [];
            const normalAudios = [];

            allAudios.forEach(audioObj => {
                const isStarred = audioObj.is_starred || (window.starredMsgKeys && window.starredMsgKeys.has(audioObj.key));
                if (isStarred) {
                    starredAudios.push(audioObj);
                } else {
                    normalAudios.push(audioObj);
                }
            });

            // Group normal audios by date
            const groups = {};
            const groupKeys = [];
            const now = new Date();
            const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
            const startOfDay = (date) => new Date(date.getFullYear(), date.getMonth(), date.getDate());

            normalAudios.forEach(audioObj => {
                const audioDate = new Date(audioObj.normalizedTime);
                const audioDay = startOfDay(audioDate);
                const diffTime = Math.abs(today - audioDay);
                const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
                
                let groupName = '';
                if (diffDays <= 7) {
                    groupName = 'RECENT';
                } else if (diffDays <= 14) {
                    groupName = 'LAST WEEK';
                } else if (diffDays <= 30) {
                    groupName = 'LAST MONTH';
                } else if (audioDate.getFullYear() === today.getFullYear()) {
                    const monthNames = ["JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"];
                    groupName = monthNames[audioDate.getMonth()];
                } else {
                    groupName = audioDate.getFullYear().toString();
                }

                if (audioDate.getFullYear() <= 1970) {
                    groupName = 'OLDER';
                }

                if (!groups[groupName]) {
                    groups[groupName] = [];
                    groupKeys.push(groupName);
                }
                groups[groupName].push(audioObj);
            });

            let html = '';

            // Render Helper for a single Audio list item
            const renderAudioItem = (audioObj) => {
                let senderInfo = audioObj.resolvedSenderName || audioObj.resolvedChatName;
                if (audioObj.isGroup && audioObj.resolvedSenderName) {
                    senderInfo = `${audioObj.resolvedSenderName} @ ${audioObj.resolvedChatName}`;
                }
                
                const timeStr = new Date(audioObj.normalizedTime).toLocaleDateString([], { month: '2-digit', day: '2-digit', year: '2-digit' });
                const dateStr = new Date(audioObj.normalizedTime).toLocaleDateString();
                const timeStrFull = new Date(audioObj.normalizedTime).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                const timestampStr = `${dateStr}, ${timeStrFull}`;
                
                const key = `gs_${audioObj.key}`;
                const senderAvatar = audioObj.resolvedChatAvatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(senderInfo);

                return `
                    <div class="flex flex-col px-4 py-3 hover:bg-[#202c33] border-b border-[#202c33]/40 transition-colors">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 rounded-full overflow-hidden bg-[#2a3942] shrink-0">
                                    <img src="${senderAvatar}" class="w-full h-full object-cover">
                                </div>
                                <span class="text-[13px] text-[#8696a0] font-medium truncate max-w-[170px]">${senderInfo}</span>
                            </div>
                            <span class="text-[11px] text-[#8696a0] shrink-0">${timeStr}</span>
                        </div>
                        
                        <!-- Inline Custom Voice Note Player -->
                        <div class="flex items-center gap-3 p-1.5 rounded-lg">
                            <!-- Left: Avatar with blue microphone badge -->
                            <div class="relative shrink-0 w-11 h-11 cursor-pointer" onclick="window.openGlobalSearchAudioViewer('${audioObj.key}', '${audioObj.chatId}', '${audioObj.file_url}', '${senderInfo.replace(/'/g, "\\'")}', '${timestampStr}', ${audioObj.isGroup}, 'Voice message')">
                                <img src="${senderAvatar}" class="w-full h-full rounded-full object-cover">
                                <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-[#111b21] flex items-center justify-center text-[#53bdeb] shadow-sm border border-[#111b21]">
                                    <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor">
                                        <path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3zm5.3-3c0 3-2.54 5.1-5.3 5.1S6.7 14 6.7 11H5c0 3.41 2.72 6.23 6 6.72V21h2v-3.28c3.28-.48 6-3.3 6-6.72h-1.7z"/>
                                    </svg>
                                </div>
                            </div>
                            <!-- Right: Play/Pause button, seekbar, speed -->
                            <div class="flex-1 flex flex-col gap-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <button onclick="window.toggleCustomAudioPlay('${key}')" id="audio_play_btn_${key}" class="text-[#8696a0] hover:text-[#e9edef] focus:outline-none transition-colors shrink-0">
                                        <svg viewBox="0 0 24 24" width="26" height="26" fill="currentColor" id="play_svg_${key}">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                        <svg viewBox="0 0 24 24" width="26" height="26" fill="currentColor" id="pause_svg_${key}" class="hidden">
                                            <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                                        </svg>
                                    </button>
                                    
                                    <div class="flex-1 max-w-[140px] relative flex items-center h-6">
                                        <div id="audio_waveform_bars_${key}" class="absolute inset-0 flex items-center justify-between pointer-events-none">
                                            ${[8, 12, 16, 12, 8, 14, 20, 16, 10, 18, 22, 14, 10, 16, 20, 12, 8, 14, 18, 12, 10, 16, 12, 8].map((h, i) => `
                                                <div class="w-[2.5px] rounded-full bg-[#8696a0] transition-colors duration-150" style="height: ${h}px;" data-index="${i}"></div>
                                            `).join('')}
                                        </div>
                                        <div id="audio_thumb_${key}" class="absolute w-[9px] h-[9px] rounded-full bg-[#53bdeb] pointer-events-none transform -translate-x-1/2" style="left: 0%;"></div>
                                        <input type="range" min="0" max="100" value="0" step="0.1" id="audio_slider_${key}" oninput="window.onCustomAudioSliderInput('${key}')" onchange="window.onCustomAudioSliderChange('${key}')" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between text-[11px] text-[#8696a0] px-1 font-medium tracking-wide">
                                    <span id="audio_time_${key}">0:00</span>
                                    <button onclick="window.toggleCustomAudioSpeed('${key}')" id="audio_speed_${key}" class="hover:text-[#e9edef] bg-[#202c33]/60 px-1.5 py-0.5 rounded transition-colors focus:outline-none">1.0x</button>
                                </div>
                            </div>
                            
                            <audio id="audio_element_${key}" src="${audioObj.file_url}" preload="metadata" class="hidden" ontimeupdate="window.onCustomAudioTimeUpdate('${key}')" onended="window.onCustomAudioEnded('${key}')" onloadedmetadata="window.onCustomAudioLoadedMetadata('${key}')"></audio>
                        </div>
                    </div>
                `;
            };

            // 1. Render Starred Audios first
            if (starredAudios.length > 0) {
                html += `
                    <div class="px-5 py-3 text-[#8696a0] text-[13px] font-medium tracking-wide">
                        Starred messages
                    </div>
                    <div class="flex flex-col">
                `;
                starredAudios.forEach(audioObj => {
                    html += renderAudioItem(audioObj);
                });
                html += `</div>`;
            }

            // 2. Render normal grouped audios
            groupKeys.forEach((key, index) => {
                const mtClass = (index > 0 || starredAudios.length > 0) ? 'mt-1' : '';
                html += `
                    <div class="px-5 py-3 text-[#8696a0] text-[13px] font-medium tracking-wide ${mtClass}">
                        ${key}
                    </div>
                    <div class="flex flex-col">
                `;
                groups[key].forEach(audioObj => {
                    html += renderAudioItem(audioObj);
                });
                html += `</div>`;
            });

            container.innerHTML = html;
        };

        window.renderGlobalSearchDocuments = function() {
            const container = document.getElementById('global_search_results_container');
            if (!container) return;

            let allDocs = [];
            if (window.messageCache) {
                Object.entries(window.messageCache).forEach(([chatId, chatMessages]) => {
                    chatMessages.forEach(msg => {
                        if (msg.type === 'document' && msg.file_url) {
                            allDocs.push({...msg, chatId: chatId});
                        }
                    });
                });
            }
            if (window.groupMessagesCache) {
                Object.entries(window.groupMessagesCache).forEach(([groupId, chatMessages]) => {
                    chatMessages.forEach(msg => {
                        if (msg.type === 'document' && msg.file_url) {
                            allDocs.push({...msg, chatId: 'group_' + groupId});
                        }
                    });
                });
            }

            const searchQuery = document.getElementById('sidebar_search')?.value.toLowerCase().trim() || '';

            allDocs = allDocs.map(docObj => {
                let chatName = 'Unknown Chat';
                let chatAvatar = '';
                let isGroup = false;

                if (docObj.chatId) {
                    if (docObj.chatId.startsWith('group_')) {
                        isGroup = true;
                        const groupId = docObj.chatId.replace('group_', '');
                        const groupEl = document.getElementById(`group_sidebar_${groupId}`);
                        if (groupEl) {
                            chatName = groupEl.getAttribute('data-name') || chatName;
                            chatAvatar = groupEl.getAttribute('data-avatar') || '';
                        }
                    } else {
                        const ids = docObj.chatId.replace('chat_', '').split('_');
                        const targetId = ids.find(id => id != window.myUserId) || window.myUserId;
                        const userEl = document.getElementById(`user_sidebar_${targetId}`);
                        if (userEl) {
                            chatName = userEl.getAttribute('data-name') || chatName;
                            chatAvatar = userEl.getAttribute('data-avatar') || '';
                        }
                    }
                }

                let senderName = '';
                if (isGroup && docObj.senderId) {
                    const senderEl = document.getElementById(`user_sidebar_${docObj.senderId}`);
                    if (senderEl) {
                        senderName = senderEl.getAttribute('data-name') || '';
                    } else if (docObj.senderId == window.myUserId) {
                        senderName = 'You';
                    }
                } else if (!isGroup && docObj.senderId == window.myUserId) {
                    senderName = 'You';
                } else if (!isGroup) {
                    senderName = chatName;
                }

                return {
                    ...docObj,
                    resolvedChatName: chatName,
                    resolvedChatAvatar: chatAvatar,
                    resolvedSenderName: senderName,
                    isGroup: isGroup
                };
            });

            // Filtering by search query if any
            if (searchQuery !== '') {
                allDocs = allDocs.filter(docObj => {
                    const cName = (docObj.resolvedChatName || '').toLowerCase();
                    const sName = (docObj.resolvedSenderName || '').toLowerCase();
                    const fName = (docObj.file_name || '').toLowerCase();
                    return cName.includes(searchQuery) || sName.includes(searchQuery) || fName.includes(searchQuery);
                });
            }

            if (allDocs.length === 0) {
                container.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                        <svg class="w-16 h-16 text-[#3b4a54] mb-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"></path>
                        </svg>
                        <p class="text-[#8696a0] text-[14px]">No documents found</p>
                    </div>
                `;
                return;
            }

            // Time helpers
            const extractFirebaseTime = (id) => {
                if (!id || typeof id !== 'string' || id.length < 8 || !id.startsWith('-')) return 0;
                const PUSH_CHARS = '-0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
                let time = 0;
                for (let i = 0; i < 8; i++) {
                    time = time * 64 + PUSH_CHARS.indexOf(id.charAt(i));
                }
                return time;
            };

            allDocs = allDocs.map(docObj => {
                let timestampMs = (docObj.time && docObj.time.toString().length <= 10) ? docObj.time * 1000 : docObj.time;
                if (!timestampMs || timestampMs < 315532800000 || isNaN(new Date(timestampMs).getTime())) {
                    if (docObj.key && !isNaN(Number(docObj.key)) && Number(docObj.key) > 315532800000) {
                        timestampMs = Number(docObj.key);
                    } else {
                        const extracted = extractFirebaseTime(docObj.key);
                        if (extracted > 0) timestampMs = extracted;
                    }
                }
                return { ...docObj, normalizedTime: timestampMs || 0 };
            });

            // Sort newest first
            allDocs.sort((a, b) => b.normalizedTime - a.normalizedTime);

            // Group into Starred vs Normal
            const starredDocs = [];
            const normalDocs = [];

            allDocs.forEach(docObj => {
                const isStarred = docObj.is_starred || (window.starredMsgKeys && window.starredMsgKeys.has(docObj.key));
                if (isStarred) {
                    starredDocs.push(docObj);
                } else {
                    normalDocs.push(docObj);
                }
            });

            // Group normal docs by date
            const groups = {};
            const groupKeys = [];
            const now = new Date();
            const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
            const startOfDay = (date) => new Date(date.getFullYear(), date.getMonth(), date.getDate());

            normalDocs.forEach(docObj => {
                const docDate = new Date(docObj.normalizedTime);
                const docDay = startOfDay(docDate);
                const diffTime = Math.abs(today - docDay);
                const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
                
                let groupName = '';
                if (diffDays <= 7) {
                    groupName = 'RECENT';
                } else if (diffDays <= 14) {
                    groupName = 'LAST WEEK';
                } else if (diffDays <= 30) {
                    groupName = 'LAST MONTH';
                } else if (docDate.getFullYear() === today.getFullYear()) {
                    const monthNames = ["JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"];
                    groupName = monthNames[docDate.getMonth()];
                } else {
                    groupName = docDate.getFullYear().toString();
                }

                if (docDate.getFullYear() <= 1970) {
                    groupName = 'OLDER';
                }

                if (!groups[groupName]) {
                    groups[groupName] = [];
                    groupKeys.push(groupName);
                }
                groups[groupName].push(docObj);
            });

            let html = '';

            const formatBytes = (bytes) => {
                if (bytes === 0 || !bytes) return '';
                const k = 1024;
                const sizes = ['Bytes', 'kB', 'MB', 'GB', 'TB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
            };

            // Render Helper for a single Document list item
            const renderDocItem = (docObj) => {
                let senderInfo = docObj.resolvedSenderName || docObj.resolvedChatName;
                if (docObj.isGroup && docObj.resolvedSenderName) {
                    senderInfo = `${docObj.resolvedSenderName} @ ${docObj.resolvedChatName}`;
                }
                
                // Show chat name instead of sender name if it's more accurate for display
                if (docObj.resolvedChatName) {
                    senderInfo = docObj.resolvedChatName;
                }
                
                const timeStr = new Date(docObj.normalizedTime).toLocaleDateString([], { month: '2-digit', day: '2-digit', year: '2-digit' });
                
                const fileName = docObj.file_name || 'Document';
                const fileExt = fileName.split('.').pop().toUpperCase();
                const fileSizeStr = docObj.file_size ? formatBytes(docObj.file_size) : '';
                const sizeExtStr = fileSizeStr ? `${fileSizeStr} • ${fileExt}` : fileExt;
                
                // Color mapping for different extensions
                let bgColor = '#6e7a85'; // default
                if (fileExt === 'PDF') bgColor = '#E53935';
                else if (fileExt === 'DOC' || fileExt === 'DOCX') bgColor = '#1E88E5';
                else if (fileExt === 'XLS' || fileExt === 'XLSX') bgColor = '#43A047';
                else if (fileExt === 'PPT' || fileExt === 'PPTX') bgColor = '#FB8C00';
                
                const textPreview = docObj.text || docObj.caption;
                let textHtml = '';
                if (textPreview) {
                    const senderPrefix = docObj.senderId == window.myUserId ? 'You: ' : '';
                    textHtml = `<div class="text-[13px] text-[#8696a0] mb-2 truncate max-w-full">${senderPrefix}📄 ${textPreview}</div>`;
                }

                return `
                    <div onclick="window.openLinkInChat('${docObj.key}', '${docObj.chatId}', ${docObj.isGroup})" class="flex flex-col px-4 py-3 hover:bg-[#202c33] cursor-pointer border-b border-[#202c33]/40 transition-colors">
                        <div class="flex items-center justify-between mb-1.5">
                            <div class="text-[14px] text-[#e9edef] truncate max-w-[200px]">${senderInfo}</div>
                            <span class="text-[11px] text-[#8696a0] shrink-0">${timeStr}</span>
                        </div>
                        ${textHtml}
                        <div onclick="window.open('${docObj.file_url}', '_blank'); event.stopPropagation();" class="flex items-center gap-4 bg-[#182229] p-3 rounded-lg border border-[#2f3b43]/30 hover:bg-[#233138] transition-colors cursor-pointer" title="Download Document">
                            <!-- Document Icon -->
                            <div class="w-10 h-10 rounded flex items-center justify-center shrink-0" style="background-color: ${bgColor}">
                                <span class="text-white font-bold text-[12px]">${fileExt.substring(0, 4)}</span>
                            </div>
                            
                            <!-- Document Info -->
                            <div class="flex-1 flex flex-col min-w-0">
                                <div class="text-[14px] text-[#e9edef] truncate font-medium">${fileName}</div>
                                <div class="text-[12px] text-[#8696a0] truncate mt-0.5">${sizeExtStr}</div>
                            </div>
                        </div>
                    </div>
                `;
            };

            // 1. Render Starred Docs first
            if (starredDocs.length > 0) {
                html += `
                    <div class="px-5 py-3 text-[#8696a0] text-[13px] font-medium tracking-wide">
                        Starred messages
                    </div>
                    <div class="flex flex-col">
                `;
                starredDocs.forEach(docObj => {
                    html += renderDocItem(docObj);
                });
                html += `</div>`;
            }

            // 2. Render normal grouped docs
            groupKeys.forEach((key, index) => {
                const mtClass = (index > 0 || starredDocs.length > 0) ? 'mt-1' : '';
                html += `
                    <div class="px-5 py-3 text-[#8696a0] text-[13px] font-medium tracking-wide ${mtClass}">
                        ${key}
                    </div>
                    <div class="flex flex-col">
                `;
                groups[key].forEach(docObj => {
                    html += renderDocItem(docObj);
                });
                html += `</div>`;
            });

            container.innerHTML = html;
        };

        window.renderGlobalSearchPhotos = function() {
            const container = document.getElementById('global_search_results_container');
            if (!container) return;
            
            let allImages = [];
            if (window.messageCache) {
                Object.entries(window.messageCache).forEach(([chatId, chatMessages]) => {
                    chatMessages.forEach(msg => {
                        if (msg.type === 'image' && msg.file_url && !(msg.file_name?.toLowerCase().endsWith('.gif') || msg.file_name?.toLowerCase().includes('sticker') || msg.file_url.toLowerCase().includes('.gif') || msg.file_url.toLowerCase().includes('tenor.com') || msg.file_url.toLowerCase().includes('giphy.com'))) {
                            allImages.push({...msg, chatId: chatId});
                        }
                    });
                });
            }
            if (window.groupMessagesCache) {
                Object.entries(window.groupMessagesCache).forEach(([groupId, chatMessages]) => {
                    chatMessages.forEach(msg => {
                        if (msg.type === 'image' && msg.file_url && !(msg.file_name?.toLowerCase().endsWith('.gif') || msg.file_name?.toLowerCase().includes('sticker') || msg.file_url.toLowerCase().includes('.gif') || msg.file_url.toLowerCase().includes('tenor.com') || msg.file_url.toLowerCase().includes('giphy.com'))) {
                            allImages.push({...msg, chatId: 'group_' + groupId});
                        }
                    });
                });
            }
            
            const searchQuery = document.getElementById('sidebar_search')?.value.toLowerCase().trim() || '';

            allImages = allImages.map(img => {
                let chatName = 'Unknown Chat';
                let chatAvatar = '';
                let chatPhone = '';
                let isGroup = false;

                if (img.chatId) {
                    if (img.chatId.startsWith('group_')) {
                        isGroup = true;
                        const groupId = img.chatId.replace('group_', '');
                        const groupEl = document.getElementById(`group_sidebar_${groupId}`);
                        if (groupEl) {
                            chatName = groupEl.getAttribute('data-name') || chatName;
                            chatAvatar = groupEl.getAttribute('data-avatar') || '';
                        }
                    } else {
                        const ids = img.chatId.replace('chat_', '').split('_');
                        const targetId = ids.find(id => id != window.myUserId) || window.myUserId;
                        const userEl = document.getElementById(`user_sidebar_${targetId}`);
                        if (userEl) {
                            chatName = userEl.getAttribute('data-name') || chatName;
                            chatAvatar = userEl.getAttribute('data-avatar') || '';
                            chatPhone = userEl.getAttribute('data-phone') || '';
                        }
                    }
                }

                let senderName = '';
                let senderPhone = '';
                if (isGroup && img.senderId) {
                    const senderEl = document.getElementById(`user_sidebar_${img.senderId}`);
                    if (senderEl) {
                        senderName = senderEl.getAttribute('data-name') || '';
                        senderPhone = senderEl.getAttribute('data-phone') || '';
                    } else if (img.senderId == window.myUserId) {
                        senderName = 'You';
                    }
                } else if (!isGroup && img.senderId == window.myUserId) {
                    senderName = 'You';
                } else if (!isGroup) {
                    senderName = chatName;
                }

                return {
                    ...img,
                    resolvedChatName: chatName,
                    resolvedChatAvatar: chatAvatar,
                    resolvedSenderName: senderName,
                    searchSenderName: senderName === 'You' ? (window.myUserName || 'You') : senderName,
                    resolvedChatPhone: chatPhone,
                    resolvedSenderPhone: senderPhone,
                    isGroup: isGroup
                };
            });

            if (searchQuery !== '') {
                allImages = allImages.filter(img => {
                    const cName = (img.resolvedChatName || '').toLowerCase();
                    const cPhone = (img.resolvedChatPhone || '').toLowerCase();
                    const sName = (img.searchSenderName || '').toLowerCase();
                    const sPhone = (img.resolvedSenderPhone || '').toLowerCase();
                    if (window.globalSearchPhotoLayout === 'list') {
                        const text = (img.text || '').toLowerCase();
                        return cName.includes(searchQuery) || cPhone.includes(searchQuery) || sName.includes(searchQuery) || sPhone.includes(searchQuery) || text.includes(searchQuery);
                    }
                    return cName.includes(searchQuery) || cPhone.includes(searchQuery) || sName.includes(searchQuery) || sPhone.includes(searchQuery);
                });
            }
            
            if (allImages.length === 0) {
                container.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                        <svg class="w-16 h-16 text-[#3b4a54] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-[#8696a0] text-[14px]">No photos found</p>
                    </div>
                `;
                return;
            }
            
            // Helper to extract timestamp from Firebase push key
            const extractFirebaseTime = (id) => {
                if (!id || typeof id !== 'string' || id.length < 8 || !id.startsWith('-')) return 0;
                const PUSH_CHARS = '-0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
                let time = 0;
                for (let i = 0; i < 8; i++) {
                    time = time * 64 + PUSH_CHARS.indexOf(id.charAt(i));
                }
                return time;
            };

            // Normalize all timestamps
            allImages = allImages.map(img => {
                let timestampMs = (img.time && img.time.toString().length <= 10) ? img.time * 1000 : img.time;
                
                // If timestamp evaluates to invalid or 1970 (less than 1980), fallback to Firebase key
                if (!timestampMs || timestampMs < 315532800000 || isNaN(new Date(timestampMs).getTime())) {
                    if (img.key && !isNaN(Number(img.key)) && Number(img.key) > 315532800000) {
                        timestampMs = Number(img.key);
                    } else {
                        const extracted = extractFirebaseTime(img.key);
                        if (extracted > 0) timestampMs = extracted;
                    }
                }
                
                return { ...img, normalizedTime: timestampMs || 0 };
            });

            // Sort by normalized time descending
            allImages.sort((a, b) => b.normalizedTime - a.normalizedTime);
            
            const groups = {};
            const groupKeys = [];
            
            const now = new Date();
            const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
            
            // Helper to get start of a day
            const startOfDay = (date) => new Date(date.getFullYear(), date.getMonth(), date.getDate());
            
            allImages.forEach(img => {
                const imgDate = new Date(img.normalizedTime);
                const imgDay = startOfDay(imgDate);
                
                // Calculate difference in days
                const diffTime = Math.abs(today - imgDay);
                const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
                
                let groupName = '';
                
                if (diffDays <= 7) {
                    groupName = 'RECENT';
                } else if (diffDays <= 14) {
                    groupName = 'LAST WEEK';
                } else if (diffDays <= 30) {
                    groupName = 'LAST MONTH';
                } else if (imgDate.getFullYear() === today.getFullYear()) {
                    const monthNames = ["JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"];
                    groupName = monthNames[imgDate.getMonth()];
                } else {
                    groupName = imgDate.getFullYear().toString();
                }
                
                // If it's 1970 (or earlier), we couldn't determine the time, so put it in "OLDER"
                if (imgDate.getFullYear() <= 1970) {
                    groupName = 'OLDER';
                }
                
                if (!groups[groupName]) {
                    groups[groupName] = [];
                    groupKeys.push(groupName);
                }
                groups[groupName].push(img);
            });
            
            let html = '';
            
            groupKeys.forEach((key, index) => {
                const mtClass = index > 0 ? 'mt-1' : '';
                html += `
                    <div class="px-5 py-3 text-[#8696a0] text-[13px] font-medium tracking-wide ${mtClass}">
                        ${key}
                    </div>
                `;
                
                if (window.globalSearchPhotoLayout === 'list') {
                    html += `<div class="flex flex-col">`;
                    groups[key].forEach(img => {
                        let chatName = img.resolvedChatName || 'Unknown Chat';
                        let chatAvatar = img.resolvedChatAvatar || '';
                        
                        let senderInfo = 'Photo';
                        if (img.isGroup && img.resolvedSenderName) {
                            senderInfo = `${img.resolvedSenderName}: Photo`;
                        } else if (!img.isGroup && img.senderId == window.myUserId) {
                            senderInfo = `You: Photo`;
                        }

                        let senderNameForViewer = 'Photo';
                        if (img.isGroup && img.resolvedSenderName) {
                            senderNameForViewer = img.resolvedSenderName;
                        } else if (!img.isGroup && img.senderId == window.myUserId) {
                            senderNameForViewer = 'You';
                        } else if (!img.isGroup) {
                            senderNameForViewer = img.resolvedChatName || 'Unknown';
                        }
                        
                        let timeStr = new Date(img.normalizedTime).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        let dateStr = new Date(img.normalizedTime).toLocaleDateString();
                        let timestampStr = `${dateStr}, ${timeStr}`;
                        let escapedText = (img.text || '').replace(/'/g, "\\'").replace(/"/g, '&quot;').replace(/\n/g, ' ').replace(/\r/g, '');
                        
                        html += `
                            <div class="flex items-center px-4 py-2 hover:bg-[#202c33] cursor-pointer transition-colors" onclick="window.openGlobalSearchImageViewer('${img.key}', '${img.chatId}', '${img.file_url}', '${senderNameForViewer.replace(/'/g, "\\'")}', '${timestampStr}', ${img.isGroup}, '${escapedText}')">
                                <div class="w-12 h-12 rounded-full overflow-hidden bg-[#2a3942] shrink-0 mr-4">
                                    ${chatAvatar ? `<img src="${chatAvatar}" class="w-full h-full object-cover">` : ''}
                                </div>
                                <div class="flex-1 min-w-0 pr-4 flex flex-col justify-center">
                                    <div class="text-[16px] text-[#e9edef] truncate mb-0.5 leading-tight">${chatName}</div>
                                    <div class="flex items-start text-[#8696a0] text-[14px] leading-tight">
                                        ${img.isGroup ? '' : `
                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor" class="mr-1 shrink-0 mt-0.5">
                                            <path d="M21.1 5.3h-1.5l-1-1.3C18 3.3 17.3 3 16.5 3h-9C6.7 3 6 3.3 5.4 4L4.4 5.3H2.9C1.3 5.3 0 6.6 0 8.2v10.6C0 20.4 1.3 21.7 2.9 21.7h18.2c1.6 0 2.9-1.3 2.9-2.9V8.2c0-1.6-1.3-2.9-2.9-2.9zM12 18.5c-3.1 0-5.7-2.5-5.7-5.7s2.5-5.7 5.7-5.7 5.7 2.5 5.7 5.7-2.5 5.7-5.7 5.7zm0-9.8c-2.3 0-4.1 1.8-4.1 4.1s1.8 4.1 4.1 4.1 4.1-1.8 4.1-4.1-1.8-4.1-4.1-4.1z"></path>
                                        </svg>
                                        `}
                                        <div class="flex flex-col flex-1 min-w-0">
                                            <span class="truncate">${senderInfo}</span>
                                            ${img.text ? `<span class="truncate text-[#d1d7db] mt-0.5">${escapedText}</span>` : ''}
                                        </div>
                                    </div>
                                </div>
                                <div class="w-[52px] h-[52px] bg-[#202c33] shrink-0 rounded-[4px] overflow-hidden">
                                    <img src="${img.file_url}" class="w-full h-full object-cover">
                                </div>
                            </div>
                        `;
                    });
                    html += `</div>`;
                } else {
                    html += `<div class="grid grid-cols-3 gap-[2px]">`;
                    groups[key].forEach(img => {
                        let senderInfo = 'Photo';
                        if (img.isGroup && img.resolvedSenderName) {
                            senderInfo = img.resolvedSenderName;
                        } else if (!img.isGroup && img.senderId == window.myUserId) {
                            senderInfo = 'You';
                        } else if (!img.isGroup) {
                            senderInfo = img.resolvedChatName || 'Unknown';
                        }
                        let timeStr = new Date(img.normalizedTime).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        let dateStr = new Date(img.normalizedTime).toLocaleDateString();
                        let timestampStr = `${dateStr}, ${timeStr}`;
                        let escapedText = (img.text || '').replace(/'/g, "\\'").replace(/"/g, '&quot;').replace(/\n/g, ' ').replace(/\r/g, '');
                        
                        html += `
                            <div class="aspect-square bg-[#202c33] cursor-pointer hover:opacity-90 transition-opacity" onclick="window.openGlobalSearchImageViewer('${img.key}', '${img.chatId}', '${img.file_url}', '${senderInfo.replace(/'/g, "\\'")}', '${timestampStr}', ${img.isGroup}, '${escapedText}')">
                                <img src="${img.file_url}" class="w-full h-full object-cover">
                            </div>
                        `;
                    });
                    html += `</div>`;
                }
            });
            
            container.innerHTML = html;
        };
    

        window.renderGlobalSearchGifs = function() {
            const container = document.getElementById('global_search_results_container');
            if (!container) return;
            
            let allGifs = [];
            if (window.messageCache) {
                Object.entries(window.messageCache).forEach(([chatId, chatMessages]) => {
                    chatMessages.forEach(msg => {
                        if (msg.type === 'image' && msg.file_url && (msg.file_name?.toLowerCase().endsWith('.gif') || msg.file_url.toLowerCase().includes('.gif') || msg.file_url.toLowerCase().includes('tenor.com') || msg.file_url.toLowerCase().includes('giphy.com')) && !(msg.file_name?.toLowerCase().includes('sticker') || msg.type === 'sticker' || msg.file_url.toLowerCase().includes('/stickers/'))) {
                            allGifs.push({...msg, chatId: chatId});
                        }
                    });
                });
            }
            if (window.groupMessagesCache) {
                Object.entries(window.groupMessagesCache).forEach(([groupId, chatMessages]) => {
                    chatMessages.forEach(msg => {
                        if (msg.type === 'image' && msg.file_url && (msg.file_name?.toLowerCase().endsWith('.gif') || msg.file_url.toLowerCase().includes('.gif') || msg.file_url.toLowerCase().includes('tenor.com') || msg.file_url.toLowerCase().includes('giphy.com')) && !(msg.file_name?.toLowerCase().includes('sticker') || msg.type === 'sticker' || msg.file_url.toLowerCase().includes('/stickers/'))) {
                            allGifs.push({...msg, chatId: 'group_' + groupId});
                        }
                    });
                });
            }
            
            const searchQuery = document.getElementById('sidebar_search')?.value.toLowerCase().trim() || '';

            allGifs = allGifs.map(gifObj => {
                let chatName = 'Unknown Chat';
                let chatAvatar = '';
                let chatPhone = '';
                let isGroup = false;

                if (gifObj.chatId) {
                    if (gifObj.chatId.startsWith('group_')) {
                        isGroup = true;
                        const groupId = gifObj.chatId.replace('group_', '');
                        const groupEl = document.getElementById(`group_sidebar_${groupId}`);
                        if (groupEl) {
                            chatName = groupEl.getAttribute('data-name') || chatName;
                            chatAvatar = groupEl.getAttribute('data-avatar') || '';
                        }
                    } else {
                        const ids = gifObj.chatId.replace('chat_', '').split('_');
                        const targetId = ids.find(id => id != window.myUserId) || window.myUserId;
                        const userEl = document.getElementById(`user_sidebar_${targetId}`);
                        if (userEl) {
                            chatName = userEl.getAttribute('data-name') || chatName;
                            chatAvatar = userEl.getAttribute('data-avatar') || '';
                            chatPhone = userEl.getAttribute('data-phone') || '';
                        }
                    }
                }

                let senderName = '';
                let senderPhone = '';
                if (isGroup && gifObj.senderId) {
                    const senderEl = document.getElementById(`user_sidebar_${gifObj.senderId}`);
                    if (senderEl) {
                        senderName = senderEl.getAttribute('data-name') || '';
                        senderPhone = senderEl.getAttribute('data-phone') || '';
                    } else if (gifObj.senderId == window.myUserId) {
                        senderName = 'You';
                    }
                } else if (!isGroup && gifObj.senderId == window.myUserId) {
                    senderName = 'You';
                } else if (!isGroup) {
                    senderName = chatName;
                }

                return {
                    ...gifObj,
                    resolvedChatName: chatName,
                    resolvedChatAvatar: chatAvatar,
                    resolvedSenderName: senderName,
                    searchSenderName: senderName === 'You' ? (window.myUserName || 'You') : senderName,
                    resolvedChatPhone: chatPhone,
                    resolvedSenderPhone: senderPhone,
                    isGroup: isGroup
                };
            });

            if (searchQuery !== '') {
                allGifs = allGifs.filter(gifObj => {
                    const cName = (gifObj.resolvedChatName || '').toLowerCase();
                    const cPhone = (gifObj.resolvedChatPhone || '').toLowerCase();
                    const sName = (gifObj.searchSenderName || '').toLowerCase();
                    const sPhone = (gifObj.resolvedSenderPhone || '').toLowerCase();
                    if (window.globalSearchGIFLayout === 'list') {
                        const text = (gifObj.text || '').toLowerCase();
                        return cName.includes(searchQuery) || cPhone.includes(searchQuery) || sName.includes(searchQuery) || sPhone.includes(searchQuery) || text.includes(searchQuery);
                    }
                    return cName.includes(searchQuery) || cPhone.includes(searchQuery) || sName.includes(searchQuery) || sPhone.includes(searchQuery);
                });
            }
            
            if (allGifs.length === 0) {
                container.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                        <svg class="w-16 h-16 text-[#3b4a54] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-[#8696a0] text-[14px]">No GIFs found</p>
                    </div>
                `;
                return;
            }
            
            // Helper to extract timestamp from Firebase push key
            const extractFirebaseTime = (id) => {
                if (!id || typeof id !== 'string' || id.length < 8 || !id.startsWith('-')) return 0;
                const PUSH_CHARS = '-0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
                let time = 0;
                for (let i = 0; i < 8; i++) {
                    time = time * 64 + PUSH_CHARS.indexOf(id.charAt(i));
                }
                return time;
            };

            // Normalize all timestamps
            allGifs = allGifs.map(gifObj => {
                let timestampMs = (gifObj.time && gifObj.time.toString().length <= 10) ? gifObj.time * 1000 : gifObj.time;
                
                // If timestamp evaluates to invalid or 1970 (less than 1980), fallback to Firebase key
                if (!timestampMs || timestampMs < 315532800000 || isNaN(new Date(timestampMs).getTime())) {
                    if (gifObj.key && !isNaN(Number(gifObj.key)) && Number(gifObj.key) > 315532800000) {
                        timestampMs = Number(gifObj.key);
                    } else {
                        const extracted = extractFirebaseTime(gifObj.key);
                        if (extracted > 0) timestampMs = extracted;
                    }
                }
                
                return { ...gifObj, normalizedTime: timestampMs || 0 };
            });

            // Sort by normalized time descending
            allGifs.sort((a, b) => b.normalizedTime - a.normalizedTime);
            
            const groups = {};
            const groupKeys = [];
            
            const now = new Date();
            const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
            
            // Helper to get start of a day
            const startOfDay = (date) => new Date(date.getFullYear(), date.getMonth(), date.getDate());
            
            allGifs.forEach(gifObj => {
                const gifObjDate = new Date(gifObj.normalizedTime);
                const gifObjDay = startOfDay(gifObjDate);
                
                // Calculate difference in days
                const diffTime = Math.abs(today - gifObjDay);
                const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
                
                let groupName = '';
                
                if (diffDays <= 7) {
                    groupName = 'RECENT';
                } else if (diffDays <= 14) {
                    groupName = 'LAST WEEK';
                } else if (diffDays <= 30) {
                    groupName = 'LAST MONTH';
                } else if (gifObjDate.getFullYear() === today.getFullYear()) {
                    const monthNames = ["JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"];
                    groupName = monthNames[gifObjDate.getMonth()];
                } else {
                    groupName = gifObjDate.getFullYear().toString();
                }
                
                // If it's 1970 (or earlier), we couldn't determine the time, so put it in "OLDER"
                if (gifObjDate.getFullYear() <= 1970) {
                    groupName = 'OLDER';
                }
                
                if (!groups[groupName]) {
                    groups[groupName] = [];
                    groupKeys.push(groupName);
                }
                groups[groupName].push(gifObj);
            });
            
            let html = '';
            
            groupKeys.forEach((key, index) => {
                const mtClass = index > 0 ? 'mt-1' : '';
                html += `
                    <div class="px-5 py-3 text-[#8696a0] text-[13px] font-medium tracking-wide ${mtClass}">
                        ${key}
                    </div>
                `;
                
                if (window.globalSearchGIFLayout === 'list') {
                    html += `<div class="flex flex-col">`;
                    groups[key].forEach(gifObj => {
                        let chatName = gifObj.resolvedChatName || 'Unknown Chat';
                        let chatAvatar = gifObj.resolvedChatAvatar || '';
                        
                        let senderInfo = 'GIF';
                        if (gifObj.isGroup && gifObj.resolvedSenderName) {
                            senderInfo = `${gifObj.resolvedSenderName}: GIF`;
                        } else if (!gifObj.isGroup && gifObj.senderId == window.myUserId) {
                            senderInfo = `You: GIF`;
                        }

                        let senderNameForViewer = 'GIF';
                        if (gifObj.isGroup && gifObj.resolvedSenderName) {
                            senderNameForViewer = gifObj.resolvedSenderName;
                        } else if (!gifObj.isGroup && gifObj.senderId == window.myUserId) {
                            senderNameForViewer = 'You';
                        } else if (!gifObj.isGroup) {
                            senderNameForViewer = gifObj.resolvedChatName || 'Unknown';
                        }
                        
                        let timeStr = new Date(gifObj.normalizedTime).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        let dateStr = new Date(gifObj.normalizedTime).toLocaleDateString();
                        let timestampStr = `${dateStr}, ${timeStr}`;
                        let escapedText = (gifObj.text || '').replace(/'/g, "\\'").replace(/"/g, '&quot;').replace(/\n/g, ' ').replace(/\r/g, '');
                        
                        html += `
                            <div class="flex items-center px-4 py-2 hover:bg-[#202c33] cursor-pointer transition-colors" onclick="window.openGlobalSearchGifViewer('${gifObj.key}', '${gifObj.chatId}', '${gifObj.file_url}', '${senderNameForViewer.replace(/'/g, "\\'")}', '${timestampStr}', ${gifObj.isGroup}, '${escapedText}')">
                                <div class="w-12 h-12 rounded-full overflow-hidden bg-[#2a3942] shrink-0 mr-4">
                                    ${chatAvatar ? `<img src="${chatAvatar}" class="w-full h-full object-cover">` : ''}
                                </div>
                                <div class="flex-1 min-w-0 pr-4 flex flex-col justify-center">
                                    <div class="text-[16px] text-[#e9edef] truncate mb-0.5 leading-tight">${chatName}</div>
                                    <div class="flex items-start text-[#8696a0] text-[14px] leading-tight">
                                        ${gifObj.isGroup ? '' : `
                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor" class="mr-1 shrink-0 mt-0.5">
                                            <path d="M21.1 5.3h-1.5l-1-1.3C18 3.3 17.3 3 16.5 3h-9C6.7 3 6 3.3 5.4 4L4.4 5.3H2.9C1.3 5.3 0 6.6 0 8.2v10.6C0 20.4 1.3 21.7 2.9 21.7h18.2c1.6 0 2.9-1.3 2.9-2.9V8.2c0-1.6-1.3-2.9-2.9-2.9zM12 18.5c-3.1 0-5.7-2.5-5.7-5.7s2.5-5.7 5.7-5.7 5.7 2.5 5.7 5.7-2.5 5.7-5.7 5.7zm0-9.8c-2.3 0-4.1 1.8-4.1 4.1s1.8 4.1 4.1 4.1 4.1-1.8 4.1-4.1-1.8-4.1-4.1-4.1z"></path>
                                        </svg>
                                        `}
                                        <div class="flex flex-col flex-1 min-w-0">
                                            <span class="truncate">${senderInfo}</span>
                                            ${gifObj.text ? `<span class="truncate text-[#d1d7db] mt-0.5">${escapedText}</span>` : ''}
                                        </div>
                                    </div>
                                </div>
                                <div class="w-[52px] h-[52px] bg-[#202c33] shrink-0 rounded-[4px] overflow-hidden">
                                    <img src="${gifObj.file_url}" class="w-full h-full object-cover">
                                </div>
                            </div>
                        `;
                    });
                    html += `</div>`;
                } else {
                    html += `<div class="grid grid-cols-3 gap-[2px]">`;
                    groups[key].forEach(gifObj => {
                        let senderInfo = 'GIF';
                        if (gifObj.isGroup && gifObj.resolvedSenderName) {
                            senderInfo = gifObj.resolvedSenderName;
                        } else if (!gifObj.isGroup && gifObj.senderId == window.myUserId) {
                            senderInfo = 'You';
                        } else if (!gifObj.isGroup) {
                            senderInfo = gifObj.resolvedChatName || 'Unknown';
                        }
                        let timeStr = new Date(gifObj.normalizedTime).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        let dateStr = new Date(gifObj.normalizedTime).toLocaleDateString();
                        let timestampStr = `${dateStr}, ${timeStr}`;
                        let escapedText = (gifObj.text || '').replace(/'/g, "\\'").replace(/"/g, '&quot;').replace(/\n/g, ' ').replace(/\r/g, '');
                        
                        html += `
                            <div class="aspect-square bg-[#202c33] cursor-pointer hover:opacity-90 transition-opacity" onclick="window.openGlobalSearchGifViewer('${gifObj.key}', '${gifObj.chatId}', '${gifObj.file_url}', '${senderInfo.replace(/'/g, "\\'")}', '${timestampStr}', ${gifObj.isGroup}, '${escapedText}')">
                                <img src="${gifObj.file_url}" class="w-full h-full object-cover">
                            </div>
                        `;
                    });
                    html += `</div>`;
                }
            });
            
            container.innerHTML = html;
        };window.renderGlobalSearchStickers = function() {
            const container = document.getElementById('global_search_results_container');
            if (!container) return;
            
            let allStickers = [];
            if (window.messageCache) {
                Object.entries(window.messageCache).forEach(([chatId, chatMessages]) => {
                    chatMessages.forEach(msg => {
                        if ((msg.type === 'image' && msg.file_url && msg.file_name?.toLowerCase().includes('sticker')) || (msg.type === 'sticker' && msg.file_url) || (msg.type === 'image' && msg.file_url && msg.file_url.toLowerCase().includes('/stickers/'))) {
                            allStickers.push({...msg, chatId: chatId});
                        }
                    });
                });
            }
            if (window.groupMessagesCache) {
                Object.entries(window.groupMessagesCache).forEach(([groupId, chatMessages]) => {
                    chatMessages.forEach(msg => {
                        if ((msg.type === 'image' && msg.file_url && msg.file_name?.toLowerCase().includes('sticker')) || (msg.type === 'sticker' && msg.file_url) || (msg.type === 'image' && msg.file_url && msg.file_url.toLowerCase().includes('/stickers/'))) {
                            allStickers.push({...msg, chatId: 'group_' + groupId});
                        }
                    });
                });
            }
            
            const searchQuery = document.getElementById('sidebar_search')?.value.toLowerCase().trim() || '';

            allStickers = allStickers.map(stickerObj => {
                let chatName = 'Unknown Chat';
                let chatAvatar = '';
                let chatPhone = '';
                let isGroup = false;

                if (stickerObj.chatId) {
                    if (stickerObj.chatId.startsWith('group_')) {
                        isGroup = true;
                        const groupId = stickerObj.chatId.replace('group_', '');
                        const groupEl = document.getElementById(`group_sidebar_${groupId}`);
                        if (groupEl) {
                            chatName = groupEl.getAttribute('data-name') || chatName;
                            chatAvatar = groupEl.getAttribute('data-avatar') || '';
                        }
                    } else {
                        const ids = stickerObj.chatId.replace('chat_', '').split('_');
                        const targetId = ids.find(id => id != window.myUserId) || window.myUserId;
                        const userEl = document.getElementById(`user_sidebar_${targetId}`);
                        if (userEl) {
                            chatName = userEl.getAttribute('data-name') || chatName;
                            chatAvatar = userEl.getAttribute('data-avatar') || '';
                            chatPhone = userEl.getAttribute('data-phone') || '';
                        }
                    }
                }

                let senderName = '';
                let senderPhone = '';
                if (isGroup && stickerObj.senderId) {
                    const senderEl = document.getElementById(`user_sidebar_${stickerObj.senderId}`);
                    if (senderEl) {
                        senderName = senderEl.getAttribute('data-name') || '';
                        senderPhone = senderEl.getAttribute('data-phone') || '';
                    } else if (stickerObj.senderId == window.myUserId) {
                        senderName = 'You';
                    }
                } else if (!isGroup && stickerObj.senderId == window.myUserId) {
                    senderName = 'You';
                } else if (!isGroup) {
                    senderName = chatName;
                }

                return {
                    ...stickerObj,
                    resolvedChatName: chatName,
                    resolvedChatAvatar: chatAvatar,
                    resolvedSenderName: senderName,
                    searchSenderName: senderName === 'You' ? (window.myUserName || 'You') : senderName,
                    resolvedChatPhone: chatPhone,
                    resolvedSenderPhone: senderPhone,
                    isGroup: isGroup
                };
            });

            if (searchQuery !== '') {
                allStickers = allStickers.filter(stickerObj => {
                    const cName = (stickerObj.resolvedChatName || '').toLowerCase();
                    const cPhone = (stickerObj.resolvedChatPhone || '').toLowerCase();
                    const sName = (stickerObj.searchSenderName || '').toLowerCase();
                    const sPhone = (stickerObj.resolvedSenderPhone || '').toLowerCase();
                    if (window.globalSearchStickerLayout === 'list') {
                        const text = (stickerObj.text || '').toLowerCase();
                        return cName.includes(searchQuery) || cPhone.includes(searchQuery) || sName.includes(searchQuery) || sPhone.includes(searchQuery) || text.includes(searchQuery);
                    }
                    return cName.includes(searchQuery) || cPhone.includes(searchQuery) || sName.includes(searchQuery) || sPhone.includes(searchQuery);
                });
            }
            
            if (allStickers.length === 0) {
                container.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                        <svg class="w-16 h-16 text-[#3b4a54] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-[#8696a0] text-[14px]">No stickers found</p>
                    </div>
                `;
                return;
            }
            
            // Helper to extract timestamp from Firebase push key
            const extractFirebaseTime = (id) => {
                if (!id || typeof id !== 'string' || id.length < 8 || !id.startsWith('-')) return 0;
                const PUSH_CHARS = '-0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
                let time = 0;
                for (let i = 0; i < 8; i++) {
                    time = time * 64 + PUSH_CHARS.indexOf(id.charAt(i));
                }
                return time;
            };

            // Normalize all timestamps
            allStickers = allStickers.map(stickerObj => {
                let timestampMs = (stickerObj.time && stickerObj.time.toString().length <= 10) ? stickerObj.time * 1000 : stickerObj.time;
                
                // If timestamp evaluates to invalid or 1970 (less than 1980), fallback to Firebase key
                if (!timestampMs || timestampMs < 315532800000 || isNaN(new Date(timestampMs).getTime())) {
                    if (stickerObj.key && !isNaN(Number(stickerObj.key)) && Number(stickerObj.key) > 315532800000) {
                        timestampMs = Number(stickerObj.key);
                    } else {
                        const extracted = extractFirebaseTime(stickerObj.key);
                        if (extracted > 0) timestampMs = extracted;
                    }
                }
                
                return { ...stickerObj, normalizedTime: timestampMs || 0 };
            });

            // Sort by normalized time descending
            allStickers.sort((a, b) => b.normalizedTime - a.normalizedTime);
            
            const groups = {};
            const groupKeys = [];
            
            const now = new Date();
            const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
            
            // Helper to get start of a day
            const startOfDay = (date) => new Date(date.getFullYear(), date.getMonth(), date.getDate());
            
            allStickers.forEach(stickerObj => {
                const stickerObjDate = new Date(stickerObj.normalizedTime);
                const stickerObjDay = startOfDay(stickerObjDate);
                
                // Calculate difference in days
                const diffTime = Math.abs(today - stickerObjDay);
                const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
                
                let groupName = '';
                
                if (diffDays <= 7) {
                    groupName = 'RECENT';
                } else if (diffDays <= 14) {
                    groupName = 'LAST WEEK';
                } else if (diffDays <= 30) {
                    groupName = 'LAST MONTH';
                } else if (stickerObjDate.getFullYear() === today.getFullYear()) {
                    const monthNames = ["JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"];
                    groupName = monthNames[stickerObjDate.getMonth()];
                } else {
                    groupName = stickerObjDate.getFullYear().toString();
                }
                
                // If it's 1970 (or earlier), we couldn't determine the time, so put it in "OLDER"
                if (stickerObjDate.getFullYear() <= 1970) {
                    groupName = 'OLDER';
                }
                
                if (!groups[groupName]) {
                    groups[groupName] = [];
                    groupKeys.push(groupName);
                }
                groups[groupName].push(stickerObj);
            });
            
            let html = '';
            
            groupKeys.forEach((key, index) => {
                const mtClass = index > 0 ? 'mt-1' : '';
                html += `
                    <div class="px-5 py-3 text-[#8696a0] text-[13px] font-medium tracking-wide ${mtClass}">
                        ${key}
                    </div>
                `;
                
                if (window.globalSearchStickerLayout === 'list') {
                    html += `<div class="flex flex-col">`;
                    groups[key].forEach(stickerObj => {
                        let chatName = stickerObj.resolvedChatName || 'Unknown Chat';
                        let chatAvatar = stickerObj.resolvedChatAvatar || '';
                        
                        let senderInfo = 'Sticker';
                        if (stickerObj.isGroup && stickerObj.resolvedSenderName) {
                            senderInfo = `${stickerObj.resolvedSenderName}: GIF`;
                        } else if (!stickerObj.isGroup && stickerObj.senderId == window.myUserId) {
                            senderInfo = `You: Sticker`;
                        }

                        let senderNameForViewer = 'Sticker';
                        if (stickerObj.isGroup && stickerObj.resolvedSenderName) {
                            senderNameForViewer = stickerObj.resolvedSenderName;
                        } else if (!stickerObj.isGroup && stickerObj.senderId == window.myUserId) {
                            senderNameForViewer = 'You';
                        } else if (!stickerObj.isGroup) {
                            senderNameForViewer = stickerObj.resolvedChatName || 'Unknown';
                        }
                        
                        let timeStr = new Date(stickerObj.normalizedTime).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        let dateStr = new Date(stickerObj.normalizedTime).toLocaleDateString();
                        let timestampStr = `${dateStr}, ${timeStr}`;
                        let escapedText = (stickerObj.text || '').replace(/'/g, "\\'").replace(/"/g, '&quot;').replace(/\n/g, ' ').replace(/\r/g, '');
                        
                        html += `
                            <div class="flex items-center px-4 py-2 hover:bg-[#202c33] cursor-pointer transition-colors" onclick="window.openGlobalSearchGifViewer('${stickerObj.key}', '${stickerObj.chatId}', '${stickerObj.file_url}', '${senderNameForViewer.replace(/'/g, "\\'")}', '${timestampStr}', ${stickerObj.isGroup}, '${escapedText}')">
                                <div class="w-12 h-12 rounded-full overflow-hidden bg-[#2a3942] shrink-0 mr-4">
                                    ${chatAvatar ? `<img src="${chatAvatar}" class="w-full h-full object-cover">` : ''}
                                </div>
                                <div class="flex-1 min-w-0 pr-4 flex flex-col justify-center">
                                    <div class="text-[16px] text-[#e9edef] truncate mb-0.5 leading-tight">${chatName}</div>
                                    <div class="flex items-start text-[#8696a0] text-[14px] leading-tight">
                                        ${stickerObj.isGroup ? '' : `
                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor" class="mr-1 shrink-0 mt-0.5">
                                            <path d="M21.1 5.3h-1.5l-1-1.3C18 3.3 17.3 3 16.5 3h-9C6.7 3 6 3.3 5.4 4L4.4 5.3H2.9C1.3 5.3 0 6.6 0 8.2v10.6C0 20.4 1.3 21.7 2.9 21.7h18.2c1.6 0 2.9-1.3 2.9-2.9V8.2c0-1.6-1.3-2.9-2.9-2.9zM12 18.5c-3.1 0-5.7-2.5-5.7-5.7s2.5-5.7 5.7-5.7 5.7 2.5 5.7 5.7-2.5 5.7-5.7 5.7zm0-9.8c-2.3 0-4.1 1.8-4.1 4.1s1.8 4.1 4.1 4.1 4.1-1.8 4.1-4.1-1.8-4.1-4.1-4.1z"></path>
                                        </svg>
                                        `}
                                        <div class="flex flex-col flex-1 min-w-0">
                                            <span class="truncate">${senderInfo}</span>
                                            ${stickerObj.text ? `<span class="truncate text-[#d1d7db] mt-0.5">${escapedText}</span>` : ''}
                                        </div>
                                    </div>
                                </div>
                                <div class="w-[52px] h-[52px] bg-[#202c33] shrink-0 rounded-[4px] overflow-hidden">
                                    <img src="${stickerObj.file_url}" class="w-full h-full object-cover">
                                </div>
                            </div>
                        `;
                    });
                    html += `</div>`;
                } else {
                    html += `<div class="grid grid-cols-3 gap-[2px]">`;
                    groups[key].forEach(stickerObj => {
                        let senderInfo = 'Sticker';
                        if (stickerObj.isGroup && stickerObj.resolvedSenderName) {
                            senderInfo = stickerObj.resolvedSenderName;
                        } else if (!stickerObj.isGroup && stickerObj.senderId == window.myUserId) {
                            senderInfo = 'You';
                        } else if (!stickerObj.isGroup) {
                            senderInfo = stickerObj.resolvedChatName || 'Unknown';
                        }
                        let timeStr = new Date(stickerObj.normalizedTime).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        let dateStr = new Date(stickerObj.normalizedTime).toLocaleDateString();
                        let timestampStr = `${dateStr}, ${timeStr}`;
                        let escapedText = (stickerObj.text || '').replace(/'/g, "\\'").replace(/"/g, '&quot;').replace(/\n/g, ' ').replace(/\r/g, '');
                        
                        html += `
                            <div class="aspect-square bg-[#202c33] cursor-pointer hover:opacity-90 transition-opacity" onclick="window.openGlobalSearchGifViewer('${stickerObj.key}', '${stickerObj.chatId}', '${stickerObj.file_url}', '${senderInfo.replace(/'/g, "\\'")}', '${timestampStr}', ${stickerObj.isGroup}, '${escapedText}')">
                                <img src="${stickerObj.file_url}" class="w-full h-full object-cover">
                            </div>
                        `;
                    });
                    html += `</div>`;
                }
            });
            
            container.innerHTML = html;
        };
    
window.renderGlobalSearchPolls = function() {
        const container = document.getElementById('global_search_results_container');
        if (!container) return;
        
        let allPolls = [];
        if (window.messageCache) {
            Object.entries(window.messageCache).forEach(([chatId, chatMessages]) => {
                chatMessages.forEach(msg => {
                    if (msg.type === 'poll') {
                        allPolls.push({...msg, chatId: chatId});
                    }
                });
            });
        }
        if (window.groupMessagesCache) {
            Object.entries(window.groupMessagesCache).forEach(([groupId, chatMessages]) => {
                chatMessages.forEach(msg => {
                    if (msg.type === 'poll') {
                        allPolls.push({...msg, chatId: 'group_' + groupId});
                    }
                });
            });
        }
        
        const searchQuery = document.getElementById('sidebar_search')?.value.toLowerCase().trim() || '';

        allPolls = allPolls.map(poll => {
            let chatName = 'Unknown Chat';
            let chatAvatar = 'https://ui-avatars.com/api/?name=U&background=202c33&color=fff';
            let chatPhone = '';
            
            if (poll.chatId.startsWith('group_')) {
                const groupId = poll.chatId.replace('group_', '');
                const groupInfo = window.allGroups?.find(g => String(g.id) === String(groupId));
                if (groupInfo) {
                    chatName = groupInfo.name;
                    chatAvatar = groupInfo.avatar;
                }
            } else {
                const contactInfo = window.allContacts?.find(c => String(c.id) === String(poll.chatId));
                if (contactInfo) {
                    chatName = contactInfo.name || contactInfo.phone;
                    chatAvatar = contactInfo.avatar;
                    chatPhone = contactInfo.phone || '';
                } else {
                    const el = document.getElementById('user_sidebar_' + poll.chatId);
                    if (el) {
                        chatName = el.getAttribute('data-name');
                        chatAvatar = el.getAttribute('data-avatar');
                    }
                }
            }
            
            let senderName = '';
            if (String(poll.sender_id) === String(window.myUserId)) {
                senderName = 'You';
            } else if (poll.chatId.startsWith('group_')) {
                const contactInfo = window.allContacts?.find(c => String(c.id) === String(poll.sender_id));
                if (contactInfo) {
                    senderName = contactInfo.name || contactInfo.phone;
                }
            } else {
                senderName = chatName;
            }

            return {
                ...poll,
                resolvedChatName: chatName,
                resolvedChatAvatar: chatAvatar,
                resolvedChatPhone: chatPhone,
                resolvedSenderName: senderName,
                normalizedTime: poll.time * 1000
            };
        });

        // Filtering by search query if any
        if (searchQuery !== '') {
            allPolls = allPolls.filter(poll => {
                const q = searchQuery;
                const matchesQuestion = (poll.text || '').toLowerCase().includes(q);
                let matchesOption = false;
                if (poll.poll_options) {
                    matchesOption = poll.poll_options.some(opt => (opt.text || '').toLowerCase().includes(q));
                }
                const matchesChatName = (poll.resolvedChatName || '').toLowerCase().includes(q);
                const matchesSender = (poll.resolvedSenderName || '').toLowerCase().includes(q);
                return matchesQuestion || matchesOption || matchesChatName || matchesSender;
            });
        }

        if (allPolls.length === 0) {
            container.innerHTML = `
                <div class="flex flex-col items-center justify-center h-full text-[#8696a0] text-sm px-10 text-center space-y-4 pt-10">
                    <p>No polls found</p>
                </div>
            `;
            return;
        }

        allPolls.sort((a, b) => b.normalizedTime - a.normalizedTime);

        let groupedPolls = {};
        allPolls.forEach(poll => {
            const date = new Date(poll.normalizedTime);
            const today = new Date();
            const yesterday = new Date(today);
            yesterday.setDate(yesterday.getDate() - 1);
            
            let dateCategory = '';
            if (date.toDateString() === today.toDateString()) {
                dateCategory = 'Today';
            } else if (date.toDateString() === yesterday.toDateString()) {
                dateCategory = 'Yesterday';
            } else if (date.getFullYear() === today.getFullYear()) {
                dateCategory = date.toLocaleDateString([], { month: 'short', day: 'numeric' });
            } else {
                dateCategory = date.toLocaleDateString([], { year: 'numeric', month: 'short', day: 'numeric' });
            }
            
            if (!groupedPolls[dateCategory]) groupedPolls[dateCategory] = [];
            groupedPolls[dateCategory].push(poll);
        });

        let html = '';
        Object.entries(groupedPolls).forEach(([dateLabel, polls]) => {
            html += `
                <div class="text-[#aebac1] text-[12px] font-medium tracking-wide uppercase px-5 py-3 bg-[#111b21] sticky top-0 z-10">
                    ${dateLabel}
                </div>
            `;
            
            polls.forEach(poll => {
                let timeStr = new Date(poll.normalizedTime).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                
                // Truncate options for preview
                let optionsPreview = [];
                if (poll.poll_options) {
                    optionsPreview = poll.poll_options.map(opt => opt.text).slice(0, 3);
                    if (poll.poll_options.length > 3) optionsPreview.push('...');
                }
                
                html += `
                    <div class="flex px-4 py-3 hover:bg-[#202c33] cursor-pointer transition-colors border-t border-[#202c33]/50" onclick="window.openLinkInChat('${poll.key}', '${poll.chatId}', ${poll.chatId.startsWith('group_')})">
                        <div class="w-12 h-12 rounded-full overflow-hidden mr-4 shrink-0 bg-[#202c33] flex items-center justify-center border border-white/5 shadow-sm">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="#00a884">
                                <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        
                        <div class="flex-1 min-w-0 flex flex-col justify-center">
                            <div class="flex items-baseline justify-between mb-0.5">
                                <div class="text-[#e9edef] text-[16px] font-normal truncate pr-2">${poll.resolvedChatName}</div>
                                <div class="text-[#8696a0] text-[12px] whitespace-nowrap shrink-0">${timeStr}</div>
                            </div>
                            <div class="text-[#8696a0] text-[14px] truncate flex items-center gap-1.5">
                                ${poll.resolvedSenderName ? `<span>${poll.resolvedSenderName}: </span>` : ''}
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor" class="opacity-70 inline"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                <span>Poll</span>
                            </div>
                            
                            <div class="mt-2 bg-[#202c33] rounded-xl p-3 border border-white/5 shadow-sm">
                                <div class="text-white text-[15px] font-medium mb-1 truncate">${poll.text || 'Poll'}</div>
                                <div class="text-[#8696a0] text-[13px] truncate">
                                    ${optionsPreview.join(', ')}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
        });
        
        container.innerHTML = html;
    };
    
window.renderGlobalSearchVideos = function() {
            const container = document.getElementById('global_search_results_container');
            if (!container) return;
            
            let allVideos = [];
            if (window.messageCache) {
                Object.entries(window.messageCache).forEach(([chatId, chatMessages]) => {
                    chatMessages.forEach(msg => {
                        if (msg.type === 'video' && msg.file_url) {
                            allVideos.push({...msg, chatId: chatId});
                        }
                    });
                });
            }
            if (window.groupMessagesCache) {
                Object.entries(window.groupMessagesCache).forEach(([groupId, chatMessages]) => {
                    chatMessages.forEach(msg => {
                        if (msg.type === 'video' && msg.file_url) {
                            allVideos.push({...msg, chatId: 'group_' + groupId});
                        }
                    });
                });
            }
            
            const searchQuery = document.getElementById('sidebar_search')?.value.toLowerCase().trim() || '';

            allVideos = allVideos.map(vid => {
                let chatName = 'Unknown Chat';
                let chatAvatar = '';
                let chatPhone = '';
                let isGroup = false;

                if (vid.chatId) {
                    if (vid.chatId.startsWith('group_')) {
                        isGroup = true;
                        const groupId = vid.chatId.replace('group_', '');
                        const groupEl = document.getElementById(`group_sidebar_${groupId}`);
                        if (groupEl) {
                            chatName = groupEl.getAttribute('data-name') || chatName;
                            chatAvatar = groupEl.getAttribute('data-avatar') || '';
                        }
                    } else {
                        const ids = vid.chatId.replace('chat_', '').split('_');
                        const targetId = ids.find(id => id != window.myUserId) || window.myUserId;
                        const userEl = document.getElementById(`user_sidebar_${targetId}`);
                        if (userEl) {
                            chatName = userEl.getAttribute('data-name') || chatName;
                            chatAvatar = userEl.getAttribute('data-avatar') || '';
                            chatPhone = userEl.getAttribute('data-phone') || '';
                        }
                    }
                }

                let senderName = '';
                let senderPhone = '';
                if (isGroup && vid.senderId) {
                    const senderEl = document.getElementById(`user_sidebar_${vid.senderId}`);
                    if (senderEl) {
                        senderName = senderEl.getAttribute('data-name') || '';
                        senderPhone = senderEl.getAttribute('data-phone') || '';
                    } else if (vid.senderId == window.myUserId) {
                        senderName = 'You';
                    }
                } else if (!isGroup && vid.senderId == window.myUserId) {
                    senderName = 'You';
                } else if (!isGroup) {
                    senderName = chatName;
                }

                return {
                    ...vid,
                    resolvedChatName: chatName,
                    resolvedChatAvatar: chatAvatar,
                    resolvedSenderName: senderName,
                    searchSenderName: senderName === 'You' ? (window.myUserName || 'You') : senderName,
                    resolvedChatPhone: chatPhone,
                    resolvedSenderPhone: senderPhone,
                    isGroup: isGroup
                };
            });

            if (searchQuery !== '') {
                allVideos = allVideos.filter(vid => {
                    const cName = (vid.resolvedChatName || '').toLowerCase();
                    const cPhone = (vid.resolvedChatPhone || '').toLowerCase();
                    const sName = (vid.searchSenderName || '').toLowerCase();
                    const sPhone = (vid.resolvedSenderPhone || '').toLowerCase();
                    if (window.globalSearchVideoLayout === 'list') {
                        const text = (vid.text || '').toLowerCase();
                        return cName.includes(searchQuery) || cPhone.includes(searchQuery) || sName.includes(searchQuery) || sPhone.includes(searchQuery) || text.includes(searchQuery);
                    }
                    return cName.includes(searchQuery) || cPhone.includes(searchQuery) || sName.includes(searchQuery) || sPhone.includes(searchQuery);
                });
            }
            
            if (allVideos.length === 0) {
                container.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                        <svg class="w-16 h-16 text-[#3b4a54] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-[#8696a0] text-[14px]">No photos found</p>
                    </div>
                `;
                return;
            }
            
            // Helper to extract timestamp from Firebase push key
            const extractFirebaseTime = (id) => {
                if (!id || typeof id !== 'string' || id.length < 8 || !id.startsWith('-')) return 0;
                const PUSH_CHARS = '-0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
                let time = 0;
                for (let i = 0; i < 8; i++) {
                    time = time * 64 + PUSH_CHARS.indexOf(id.charAt(i));
                }
                return time;
            };

            // Normalize all timestamps
            allVideos = allVideos.map(vid => {
                let timestampMs = (vid.time && vid.time.toString().length <= 10) ? vid.time * 1000 : vid.time;
                
                // If timestamp evaluates to invalid or 1970 (less than 1980), fallback to Firebase key
                if (!timestampMs || timestampMs < 315532800000 || isNaN(new Date(timestampMs).getTime())) {
                    if (vid.key && !isNaN(Number(vid.key)) && Number(vid.key) > 315532800000) {
                        timestampMs = Number(vid.key);
                    } else {
                        const extracted = extractFirebaseTime(vid.key);
                        if (extracted > 0) timestampMs = extracted;
                    }
                }
                
                return { ...vid, normalizedTime: timestampMs || 0 };
            });

            // Sort by normalized time descending
            allVideos.sort((a, b) => b.normalizedTime - a.normalizedTime);
            
            const groups = {};
            const groupKeys = [];
            
            const now = new Date();
            const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
            
            // Helper to get start of a day
            const startOfDay = (date) => new Date(date.getFullYear(), date.getMonth(), date.getDate());
            
            allVideos.forEach(vid => {
                const imgDate = new Date(vid.normalizedTime);
                const imgDay = startOfDay(imgDate);
                
                // Calculate difference in days
                const diffTime = Math.abs(today - imgDay);
                const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
                
                let groupName = '';
                
                if (diffDays <= 7) {
                    groupName = 'RECENT';
                } else if (diffDays <= 14) {
                    groupName = 'LAST WEEK';
                } else if (diffDays <= 30) {
                    groupName = 'LAST MONTH';
                } else if (imgDate.getFullYear() === today.getFullYear()) {
                    const monthNames = ["JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"];
                    groupName = monthNames[imgDate.getMonth()];
                } else {
                    groupName = imgDate.getFullYear().toString();
                }
                
                // If it's 1970 (or earlier), we couldn't determine the time, so put it in "OLDER"
                if (imgDate.getFullYear() <= 1970) {
                    groupName = 'OLDER';
                }
                
                if (!groups[groupName]) {
                    groups[groupName] = [];
                    groupKeys.push(groupName);
                }
                groups[groupName].push(vid);
            });
            
            let html = '';
            
            groupKeys.forEach((key, index) => {
                const mtClass = index > 0 ? 'mt-1' : '';
                html += `
                    <div class="px-5 py-3 text-[#8696a0] text-[13px] font-medium tracking-wide ${mtClass}">
                        ${key}
                    </div>
                `;
                
                if (window.globalSearchVideoLayout === 'list') {
                    html += `<div class="flex flex-col">`;
                    groups[key].forEach(vid => {
                        let chatName = vid.resolvedChatName || 'Unknown Chat';
                        let chatAvatar = vid.resolvedChatAvatar || '';
                        
                        let senderInfo = 'Video';
                        if (vid.isGroup && vid.resolvedSenderName) {
                            senderInfo = `${vid.resolvedSenderName}: Video`;
                        } else if (!vid.isGroup && vid.senderId == window.myUserId) {
                            senderInfo = `You: Video`;
                        }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
                        let senderNameForViewer = 'Video';
                        if (vid.isGroup && vid.resolvedSenderName) {
                            senderNameForViewer = vid.resolvedSenderName;
                        } else if (!vid.isGroup && vid.senderId == window.myUserId) {
                            senderNameForViewer = 'You';
                        } else if (!vid.isGroup) {
                            senderNameForViewer = vid.resolvedChatName || 'Unknown';
                        }
                        
                        let timeStr = new Date(vid.normalizedTime).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        let dateStr = new Date(vid.normalizedTime).toLocaleDateString();
                        let timestampStr = `${dateStr}, ${timeStr}`;
                        let escapedText = (vid.text || '').replace(/'/g, "\\'").replace(/"/g, '&quot;').replace(/\n/g, ' ').replace(/\r/g, '');
                        
                        html += `
                            <div class="flex items-center px-4 py-2 hover:bg-[#202c33] cursor-pointer transition-colors" onclick="window.openGlobalSearchVideoViewer('${vid.key}', '${vid.chatId}', '${vid.file_url}', '${senderNameForViewer.replace(/'/g, "\\'")}', '${timestampStr}', ${vid.isGroup}, '${escapedText}')">
                                <div class="w-12 h-12 rounded-full overflow-hidden bg-[#2a3942] shrink-0 mr-4">
                                    ${chatAvatar ? `<img src="${chatAvatar}" class="w-full h-full object-cover">` : ''}
                                </div>
                                <div class="flex-1 min-w-0 pr-4 flex flex-col justify-center">
                                    <div class="text-[16px] text-[#e9edef] truncate mb-0.5 leading-tight">${chatName}</div>
                                    <div class="flex items-start text-[#8696a0] text-[14px] leading-tight">
                                        ${vid.isGroup ? '' : `
                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor" class="mr-1 shrink-0 mt-0.5">
                                            <path d="M21.1 5.3h-1.5l-1-1.3C18 3.3 17.3 3 16.5 3h-9C6.7 3 6 3.3 5.4 4L4.4 5.3H2.9C1.3 5.3 0 6.6 0 8.2v10.6C0 20.4 1.3 21.7 2.9 21.7h18.2c1.6 0 2.9-1.3 2.9-2.9V8.2c0-1.6-1.3-2.9-2.9-2.9zM12 18.5c-3.1 0-5.7-2.5-5.7-5.7s2.5-5.7 5.7-5.7 5.7 2.5 5.7 5.7-2.5 5.7-5.7 5.7zm0-9.8c-2.3 0-4.1 1.8-4.1 4.1s1.8 4.1 4.1 4.1 4.1-1.8 4.1-4.1-1.8-4.1-4.1-4.1z"></path>
                                        </svg>
                                        `}
                                        <div class="flex flex-col flex-1 min-w-0">
                                            <span class="truncate">${senderInfo}</span>
                                            ${vid.text ? `<span class="truncate text-[#d1d7db] mt-0.5">${escapedText}</span>` : ''}
                                        </div>
                                    </div>
                                </div>
                                <div class="w-[52px] h-[52px] bg-[#202c33] shrink-0 rounded-[4px] overflow-hidden relative">
                                    <video src="${vid.file_url}#t=0.1" preload="metadata" class="w-full h-full object-cover pointer-events-none"></video>
                                    <div class="absolute bottom-1 left-1 text-white opacity-90 flex items-center gap-1 bg-black/40 px-1 rounded pointer-events-none"><svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg><span class="text-[10px] font-medium">Video</span></div>
                                </div>
                            </div>
                        `;
                    });
                    html += `</div>`;
                } else {
                    html += `<div class="grid grid-cols-3 gap-[2px]">`;
                    groups[key].forEach(vid => {
                        let senderInfo = 'Video';
                        if (vid.isGroup && vid.resolvedSenderName) {
                            senderInfo = vid.resolvedSenderName;
                        } else if (!vid.isGroup && vid.senderId == window.myUserId) {
                            senderInfo = 'You';
                        } else if (!vid.isGroup) {
                            senderInfo = vid.resolvedChatName || 'Unknown';
                        }
                        let timeStr = new Date(vid.normalizedTime).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        let dateStr = new Date(vid.normalizedTime).toLocaleDateString();
                        let timestampStr = `${dateStr}, ${timeStr}`;
                        let escapedText = (vid.text || '').replace(/'/g, "\\'").replace(/"/g, '&quot;').replace(/\n/g, ' ').replace(/\r/g, '');
                        
                        html += `
                            <div class="aspect-square bg-[#202c33] relative cursor-pointer hover:opacity-90 transition-opacity" onclick="window.openGlobalSearchVideoViewer('${vid.key}', '${vid.chatId}', '${vid.file_url}', '${senderInfo.replace(/'/g, "\\'")}', '${timestampStr}', ${vid.isGroup}, '${escapedText}')">
                                <video src="${vid.file_url}#t=0.1" preload="metadata" class="w-full h-full object-cover pointer-events-none"></video>
                                <div class="absolute bottom-1 left-1 text-white opacity-90 flex items-center gap-1 bg-black/40 px-1 rounded pointer-events-none"><svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg><span class="text-[10px] font-medium">Video</span></div>
                            </div>
                        `;
                    });
                    html += `</div>`;
                }
            });
            
            container.innerHTML = html;
        };

    // ==========================================
    // Video Viewer Functions (Global Search)
    // ==========================================
    window.gsVideoViewerCurrentContext = null;

    window.openGlobalSearchVideoViewer = function(key, chatId, url, senderName, timestampStr, isGroup, text) {
        window.gsVideoViewerCurrentContext = { key, chatId, url, senderName, timestampStr, isGroup, text };
        
        const videoEl = document.getElementById('gs_video_viewer_video');
        if (videoEl) videoEl.src = url;
        const senderEl = document.getElementById('gs_video_viewer_sender_name');
        if (senderEl) senderEl.textContent = senderName;
        const timeEl = document.getElementById('gs_video_viewer_time');
        if (timeEl) timeEl.textContent = timestampStr;
        
        // Show existing reactions if available
        const reactionsContainer = document.getElementById('gs_video_viewer_reactions_container');
        if (reactionsContainer) reactionsContainer.innerHTML = '';
        
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
        
        if (existingReactions && reactionsContainer) {
            const counts = {};
            Object.values(existingReactions).forEach(r => counts[r] = (counts[r] || 0) + 1);
            Object.entries(counts).forEach(([emoji, count]) => {
                reactionsContainer.innerHTML += `<div class="bg-black/50 border border-white/20 rounded-full px-2 py-0.5 text-white text-[13px] flex items-center gap-1"><span>${emoji}</span>${count > 1 ? `<span class="text-white/80">${count}</span>` : ''}</div>`;
            });
        }

        const viewer = document.getElementById('gs_video_viewer');
        if (viewer) {
            viewer.classList.remove('hidden');
            void viewer.offsetWidth;
            viewer.classList.add('show');
        }
        
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
            if (reactionsContainer) reactionsContainer.innerHTML = '';
            
            if (snap.exists() && reactionsContainer) {
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
        if (viewer) viewer.classList.remove('show');
        setTimeout(() => {
            if (viewer) viewer.classList.add('hidden');
            const videoEl = document.getElementById('gs_video_viewer_video');
            if (videoEl) videoEl.src = '';
            window.gsVideoViewerCurrentContext = null;
        }, 300);
        if (window.closeGsVideoViewerMenu) window.closeGsVideoViewerMenu();
    };

    window.toggleGsVideoViewerMenu = function(e) {
        if (e) e.stopPropagation();
        const menu = document.getElementById('gs_video_viewer_dropdown_menu');
        if (menu) menu.classList.toggle('hidden');
    };

    window.closeGsVideoViewerMenu = function() {
        const menu = document.getElementById('gs_video_viewer_dropdown_menu');
        if (menu && !menu.classList.contains('hidden')) {
            menu.classList.add('hidden');
        }
    };

    // Close on escape key
    document.addEventListener('keydown', (e) => {
        const viewer = document.getElementById('gs_video_viewer');
        if (e.key === 'Escape' && viewer && viewer.classList.contains('show')) {
            window.closeGlobalSearchVideoViewer();
        }
    });

    // Wire up video viewer button event listeners after DOM is ready
    document.addEventListener('DOMContentLoaded', () => {
        return; // Prevent duplicate listeners (already handled in video_viewer.blade.php)
        
        const gsVideoViewer = document.getElementById('gs_video_viewer');
        if (!gsVideoViewer) return; // Video viewer HTML not loaded

        // Close menu when clicking outside
        gsVideoViewer.addEventListener('click', (e) => {
            if (!e.target.closest('#gs_video_viewer_dropdown_menu') && !e.target.closest('button[onclick="window.toggleGsVideoViewerMenu(event)"]')) {
                window.closeGsVideoViewerMenu();
            }
        });

        // Download
        const btnDownload = document.getElementById('gs_video_viewer_btn_download');
        if (btnDownload) btnDownload.addEventListener('click', () => {
            if (!window.gsVideoViewerCurrentContext) return;
            const link = document.createElement('a');
            link.href = window.gsVideoViewerCurrentContext.url;
            link.download = `Video_${window.gsVideoViewerCurrentContext.key}.mp4`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        // Forward/Share
        const handleForwardOrShare = () => {
            if (!window.gsVideoViewerCurrentContext) return;
            window.closeGlobalSearchVideoViewer();
            if (window.openForwardModal) {
                window.selectedMessages = new Set([window.gsVideoViewerCurrentContext.key]);
                if (!window.globalMessages) window.globalMessages = {};
                if (!window.globalMessages[window.gsVideoViewerCurrentContext.key]) {
                    window.globalMessages[window.gsVideoViewerCurrentContext.key] = {
                        key: window.gsVideoViewerCurrentContext.key,
                        file_url: window.gsVideoViewerCurrentContext.url,
                        type: 'video',
                        text: window.gsVideoViewerCurrentContext.text || ''
                    };
                }
                window.openForwardModal();
            }
        };
        const btnForward = document.getElementById('gs_video_viewer_btn_forward');
        if (btnForward) btnForward.addEventListener('click', handleForwardOrShare);
        const btnShare = document.getElementById('gs_video_viewer_btn_share');
        if (btnShare) btnShare.addEventListener('click', handleForwardOrShare);

        // Status
        const btnStatus = document.getElementById('gs_video_viewer_btn_status');
        if (btnStatus) btnStatus.addEventListener('click', async () => {
            if (!window.gsVideoViewerCurrentContext) return;
            window.closeGlobalSearchVideoViewer();
            if (window.openMediaStatusWithFiles) {
                try {
                    const response = await fetch(window.gsVideoViewerCurrentContext.url);
                    const blob = await response.blob();
                    let filename = 'status_video.mp4';
                    try {
                        const urlPath = new URL(window.gsVideoViewerCurrentContext.url).pathname;
                        const parts = urlPath.split('/');
                        const lastPart = parts[parts.length - 1];
                        if (lastPart) filename = decodeURIComponent(lastPart);
                    } catch(e) {}
                    const file = new File([blob], filename, { type: blob.type || 'video/mp4' });
                    window.openMediaStatusWithFiles([file]);
                } catch (e) {
                    console.error("Failed to load video for status", e);
                    if (window.showToast) window.showToast('Error', 'Failed to load video for status.');
                }
            }
        });

        // Reply
        const btnReply = document.getElementById('gs_video_viewer_btn_reply');
        if (btnReply) btnReply.addEventListener('click', () => {
            if (!window.gsVideoViewerCurrentContext) return;
            window.closeGlobalSearchVideoViewer();
            const chatId = window.gsVideoViewerCurrentContext.chatId;
            const key = window.gsVideoViewerCurrentContext.key;
            let cId = chatId;
            let isGroup = window.gsVideoViewerCurrentContext.isGroup;
            if (chatId.startsWith('group_')) {
                cId = chatId.replace('group_', '');
                let name = window.gsVideoViewerCurrentContext.senderName;
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
                let name = window.gsVideoViewerCurrentContext.senderName;
                const sidebarEl = document.getElementById(`user_sidebar_${cId}`);
                if (sidebarEl) name = sidebarEl.getAttribute('data-name') || name;
                if (window.selectChat) window.selectChat(cId, name);
            }
            if (!window.globalMessages) window.globalMessages = {};
            if (!window.globalMessages[key]) {
                window.globalMessages[key] = {
                    key: key,
                    file_url: window.gsVideoViewerCurrentContext.url,
                    type: 'video',
                    text: window.gsVideoViewerCurrentContext.text || ''
                };
            }
            const senderName = window.gsVideoViewerCurrentContext.senderName;
            const text = window.gsVideoViewerCurrentContext.text || 'Video';
            const url = window.gsVideoViewerCurrentContext.url;
            setTimeout(() => {
                if (window.replyToMsg) {
                    let groupName = null;
                    if (isGroup) {
                        const groupEl = document.getElementById(`group_sidebar_${cId}`);
                        if (groupEl) groupName = groupEl.getAttribute('data-name');
                    }
                    window.replyToMsg(key, senderName, text, groupName, url, 'video');
                }
            }, 800);
        });

        // React
        const btnReact = document.getElementById('gs_video_viewer_btn_react');
        if (btnReact) btnReact.addEventListener('click', (e) => {
            if (!window.gsVideoViewerCurrentContext) return;
            if (window.showReactionPopup) {
                window.showReactionPopup(e, window.gsVideoViewerCurrentContext.key, window.gsVideoViewerCurrentContext.isGroup, true);
            }
        });

        // Show in chat
        const btnShowChat = document.getElementById('gs_video_viewer_btn_show_chat');
        if (btnShowChat) btnShowChat.addEventListener('click', () => {
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
                if (window.selectGroupChat) window.selectGroupChat(cId, name, avatar);
            } else {
                if (window.selectChat) window.selectChat(cId, name, '', avatar, status);
            }
            if (window.closeGlobalSearch) window.closeGlobalSearch();
            if (window.jumpToMessage) {
                setTimeout(() => window.jumpToMessage(chatId, window.gsVideoViewerCurrentContext.key), 500);
            }
        });

        // Delete
        const btnDelete = document.getElementById('gs_video_viewer_btn_delete');
        if (btnDelete) btnDelete.addEventListener('click', () => {
            if (!window.gsVideoViewerCurrentContext) return;
            window.closeGlobalSearchVideoViewer();
            if (window.deleteMsg) {
                if (!window.globalMessages) window.globalMessages = {};
                if (!window.globalMessages[window.gsVideoViewerCurrentContext.key]) {
                    window.globalMessages[window.gsVideoViewerCurrentContext.key] = {
                        key: window.gsVideoViewerCurrentContext.key,
                        file_url: window.gsVideoViewerCurrentContext.url,
                        type: 'video',
                        sender_id: window.gsVideoViewerCurrentContext.isGroup ? null : (window.gsVideoViewerCurrentContext.senderName === 'You' ? window.myUserId : 'other')
                    };
                }
                window.deleteMsg(window.gsVideoViewerCurrentContext.key);
            }
        });

        // Double click zoom
        const imgContainer = document.getElementById('gs_video_viewer_image_container');
        if (imgContainer) imgContainer.addEventListener('dblclick', (e) => {
            if (e.target.tagName !== 'VIDEO') return;
            const video = e.target;
            const isZoomed = video.style.transform === 'scale(2)';
            if (isZoomed) {
                video.style.transform = 'scale(1)';
                video.style.cursor = 'zoom-in';
            } else {
                const rect = video.getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width) * 100;
                const y = ((e.clientY - rect.top) / rect.height) * 100;
                video.style.transformOrigin = `${x}% ${y}%`;
                video.style.transform = 'scale(2)';
                video.style.cursor = 'zoom-out';
            }
        });
    });

</script>
</div>



