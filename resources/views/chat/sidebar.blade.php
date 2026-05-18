<div id="user_sidebar_container"
    class="hidden sm:flex flex-col w-[30%] sm:min-w-[300px] border-r border-[#313d45] bg-[#111b21]">
    <div class="h-16 bg-[#202c33] flex items-center px-4 justify-between shrink-0 border-b border-[#313d45]">
        <div class="flex items-center gap-3 cursor-pointer" onclick="toggleSettings()">
            <div
                class="w-10 h-10 rounded-full overflow-hidden bg-[#202c33] flex items-center justify-center text-white border border-[#313d45]">
                <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=2a3942&color=fff' }}"
                    class="w-full h-full object-cover my-avatar">
            </div>
            <span class="font-semibold text-[#e9edef]">{{ auth()->user()->name }} (You)</span>
        </div>
        <div class="flex items-center gap-2">
            <!-- New Chat Icon -->
            <button onclick="toggleNewChat()" class="p-2 rounded-full hover:bg-[#384b57] transition-colors text-[#aebac1]">
                <svg viewBox="0 0 24 24" height="24" width="24" preserveAspectRatio="xMidYMid meet" class=""
                    fill="currentColor">
                    <title>New chat (Ctrl+Alt+bN)</title>
                    <path
                        d="M19.005 3.175H4.674C3.751 3.175 3 3.926 3 4.85v10.65c0 .925.751 1.675 1.674 1.675h10.334l4.851 4.851V4.85c0-.924-.751-1.675-1.674-1.675zm-1.674 12.325H7.001L5 17.501V5.175h14.331V15.5z">
                    </path>
                    <path d="M11.853 7.006v3.8h-3.8v1.5h3.8v3.8h1.5v-3.8h3.8v-1.5h-3.8v-3.8z"></path>
                </svg>
            </button>
            <!-- Menu Icon & Dropdown -->
            <div class="relative">
                <button id="sidebar_menu_btn" class="p-2 rounded-full hover:bg-[#384b57] transition-colors text-[#aebac1] focus:bg-[#384b57]">
                    <svg viewBox="0 0 24 24" height="24" width="24" preserveAspectRatio="xMidYMid meet" class="" fill="currentColor">
                        <title>menu</title>
                        <path d="M12 7a2 2 0 1 0-.001-4.001A2 2 0 0 0 12 7zm0 2a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 9zm0 6a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 15z"></path>
                    </svg>
                </button>
                
                <!-- Dropdown Menu -->
                <div id="sidebar_menu_dropdown" class="hidden absolute right-0 top-12 w-56 bg-[#233138] rounded-lg shadow-xl border border-[#313d45] py-2 z-50 transform origin-top-right transition-all">
                    <button onclick="toggleAddMembers()" class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px]">
                        <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-[#aebac1]">
                            <path d="M12.5 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm6.5 11h-1v-1.5c0-1.93-3.5-3-6.5-3s-6.5 1.07-6.5 3V17h14v-1.5z"></path>
                            <path d="M19 13h-2v2h-2v2h2v2h2v-2h2v-2h-2z"></path>
                        </svg>
                        New group
                    </button>
                    <button class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px]">
                        <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-[#aebac1]">
                            <path d="M20.54 5.23l-1.39-1.68C18.88 3.21 18.47 3 18 3H6c-.47 0-.88.21-1.16.55L3.46 5.23C3.17 5.57 3 6.02 3 6.5V19c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6.5c0-.48-.17-.93-.46-1.27zM6.24 5h11.52l.81.97H5.44l.8-.97zM19 19H5V8h14v11zM11 10.5h2v4.09l1.45-1.45 1.41 1.41L12 18.41l-3.86-3.86 1.41-1.41L11 14.59V10.5z"></path>
                        </svg>
                        Archived
                    </button>
                    <button class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px]">
                        <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-[#aebac1]">
                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                        </svg>
                        Starred messages
                    </button>
                    <button class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px]">
                        <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-[#aebac1]">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM17.99 9l-1.41-1.42-6.59 6.59-2.58-2.57-1.42 1.41 4 3.99z"></path>
                        </svg>
                        Select chats
                    </button>
                    <button class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px]">
                        <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-[#aebac1]">
                            <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H5.17L4 17.17V4h16v12zM7 9h10v2H7zm0-3h10v2H7zm0 6h7v2H7z"></path>
                        </svg>
                        Mark all as read
                    </button>
                    <div class="h-[1px] bg-[#313d45] my-1 mx-4"></div>
                    <button class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px]">
                        <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-[#aebac1]">
                            <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"></path>
                        </svg>
                        App lock
                    </button>
                    <button onclick="document.getElementById('logout-form').submit();" class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex items-center gap-4 text-[14.5px]">
                        <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor" class="text-[#aebac1]">
                            <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"></path>
                        </svg>
                        Log out
                    </button>
                </div>
            </div>
            
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const menuBtn = document.getElementById('sidebar_menu_btn');
                    const menuDropdown = document.getElementById('sidebar_menu_dropdown');

                    if(menuBtn && menuDropdown) {
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

    <div class="p-2 border-b border-[#202c33] bg-[#111b21]">
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
            <input type="text" id="sidebar_search" oninput="window.filterSidebar()" onfocus="onSidebarSearchFocus()"
                onblur="onSidebarSearchBlur()" placeholder="Search or start new chat"
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
    </div>

    <div class="flex-1 overflow-y-auto custom-scrollbar" id="user_list_container">
        @foreach($users ?? [] as $user)
            @php
                $userAvatar = $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->saved_name ?? $user->name ?: $user->phone) . '&background=2a3942&color=fff';
                $displayName = $user->saved_name ?? ($user->name ?: $user->phone);
                // Hide users by default if they are not a contact (they will be unhidden by Firebase if a chat exists)
                $visibilityClass = ($user->is_contact ?? false) ? 'flex' : 'hidden';
            @endphp
            <div onclick="window.selectChat({{ $user->id }}, '{{ addslashes($displayName) }}', '{{ addslashes($user->phone ?? '') }}', '{{ $userAvatar }}', '{{ addslashes($user->about ?? 'Available') }}')"
                class="{{ $visibilityClass }} items-center px-3 py-3 hover:bg-[#202c33] cursor-pointer transition-colors user-chat-item"
                id="user_sidebar_{{ $user->id }}" data-name="{{ $displayName }}"
                data-avatar="{{ $userAvatar }}" data-phone="{{ $user->phone ?? '' }}"
                data-about="{{ $user->about ?? 'Available' }}" data-userid="{{ $user->id }}">
                <div class="w-12 h-12 rounded-full overflow-hidden bg-[#2a3942] flex items-center justify-center shrink-0">
                    <img src="{{ $userAvatar }}" class="w-full h-full object-cover">
                </div>
                <div class="ml-3 flex-1 border-b border-[#202c33] pb-3 pt-1 min-w-0">
                    <div class="flex justify-between items-center">
                        <h4 class="text-[17px] text-[#e9edef] truncate mr-2 font-normal">
                            {{ $displayName }}
                        </h4>
                        <span class="text-[12px] text-[#8696a0] whitespace-nowrap" id="last_time_{{ $user->id }}"></span>
                    </div>
                    <div class="flex justify-between items-center mt-0.5">
                        <p class="text-[14px] text-[#8696a0] truncate flex-1 min-w-0 leading-snug"
                            id="last_msg_{{ $user->id }}">
                            Click to chat
                        </p>
                        <span id="unread_badge_{{ $user->id }}"
                            class="hidden bg-[#00a884] text-[#111b21] text-[12px] font-bold min-w-[20px] h-5 rounded-full flex items-center justify-center px-1.5 ml-2 shadow-sm shrink-0">
                            0
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
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
</div>
