<div
    class="hidden sm:flex flex-col w-[60px] bg-[#202c33] border-r border-[#313d45] py-4 items-center justify-between shrink-0">
    <!-- Top Menu Items -->
    <div class="flex flex-col gap-4 w-full items-center">
        <!-- Chats -->
        <button id="nav_chats" class="nav-item active group relative" title="Chats" onclick="window.showChats()">
            <div class="p-2 rounded-full hover:bg-[#384b57] transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"
                    class="text-[#8696a0] group-[.active]:text-[#e9edef]">
                    <path
                        d="M19.005 3.175H4.674C3.751 3.175 3 3.926 3 4.85V15.5c0 .925.751 1.675 1.674 1.675h10.334l4.851 4.851V4.85c0-.924-.751-1.675-1.674-1.675zm-1.674 12.325h-10.33l-2.001 2.001V5.175h14.331V15.5z">
                    </path>
                </svg>
            </div>
            <div
                class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-[#00a884] rounded-r-full hidden group-[.active]:block">
            </div>
        </button>

        <!-- Calls -->
        <button id="nav_calls" class="nav-item group" title="Calls" onclick="window.showCalls()">
            <div class="p-2 rounded-full hover:bg-[#384b57] transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"
                    class="text-[#8696a0] group-[.active]:text-[#e9edef]">
                    <path
                        d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z">
                    </path>
                </svg>
            </div>
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-[#00a884] rounded-r-full hidden group-[.active]:block"></div>
        </button>

        <!-- Status -->
        <button id="nav_status" class="nav-item group" title="Status" onclick="window.showStatus()">
            <div class="p-2 rounded-full hover:bg-[#384b57] transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"
                    class="text-[#8696a0] group-hover:text-[#e9edef]">
                    <path
                        d="M12.072 1.761a10.231 10.231 0 0 1 7.303 3.025l-1.611 1.611a7.923 7.923 0 0 0-11.433 0l-1.611-1.611a10.231 10.231 0 0 1 7.352-3.025zm7.303 17.453a10.231 10.231 0 0 1-7.303 3.025c-2.69 0-5.127-1.055-6.931-2.77l1.611-1.611a7.923 7.923 0 0 0 10.641 0l1.611 1.611a10.231 10.231 0 0 1 .371-.255zM3.737 6.397l1.611 1.611a7.923 7.923 0 0 0 0 7.984l-1.611 1.611a10.231 10.231 0 0 1 0-11.206zm14.915 0l1.611-1.611a10.231 10.231 0 0 1 0 11.206l-1.611-1.611a7.923 7.923 0 0 0 0-7.984z">
                    </path>
                </svg>
            </div>
            <div
                class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-[#00a884] rounded-r-full hidden group-[.active]:block">
            </div>
        </button>

        <!-- Channels -->
        <button id="nav_channels" class="nav-item group" title="Channels" onclick="window.showChannels()">
            <div class="p-2 rounded-full hover:bg-[#384b57] transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"
                    class="text-[#8696a0] group-[.active]:text-[#e9edef]">
                    <path
                        d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm1 14.5h-2v-2h2v2zm0-4h-2v-6h2v6z">
                    </path>
                </svg>
            </div>
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-[#00a884] rounded-r-full hidden group-[.active]:block"></div>
        </button>

        <!-- Communities -->
        <button id="nav_communities" class="nav-item group" title="Communities" onclick="window.showCommunities()">
            <div class="p-2 rounded-full hover:bg-[#384b57] transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"
                    class="text-[#8696a0] group-[.active]:text-[#e9edef]">
                    <path
                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z">
                    </path>
                </svg>
            </div>
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-[#00a884] rounded-r-full hidden group-[.active]:block"></div>
        </button>

        <!-- Archived -->
        <button id="nav_archived" class="nav-item group" title="Archived" onclick="window.showArchivedChats()">
            <div class="p-2 rounded-full hover:bg-[#384b57] transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" class="text-[#8696a0] group-[.active]:text-[#e9edef]">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                    <path d="M12 12v6"></path>
                    <path d="m9 15 3 3 3-3"></path>
                </svg>
            </div>
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-[#00a884] rounded-r-full hidden group-[.active]:block"></div>
        </button>

        <!-- Meta AI -->
        <button id="nav_meta_ai" class="nav-item group" title="Meta AI" onclick="window.openMetaAiChat()">
            <div class="p-2 rounded-full hover:bg-[#384b57] transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" class="group-hover:text-[#00a884] transition-colors group-[.active]:text-[#00a884]">
                    <circle cx="12" cy="12" r="10" class="text-[#8696a0] group-hover:text-[#00a884] group-[.active]:text-[#00a884]"></circle>
                    <path d="M12 8a4 4 0 0 1 4 4c0 2.21-1.79 4-4 4s-4-1.79-4-4a4 4 0 0 1 4-4z"
                        class="fill-[#8696a0] group-hover:fill-[#00a884] group-[.active]:fill-[#00a884]"></path>
                </svg>
            </div>
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-[#00a884] rounded-r-full hidden group-[.active]:block"></div>
        </button>
    </div>

    <!-- Bottom Menu Items -->
    <div class="flex flex-col gap-2 w-full items-center mb-2">
        <!-- Media -->
        <button class="nav-item group" title="Media" onclick="window.openGlobalMediaModal()">
            <div class="p-2 rounded-full hover:bg-[#384b57] transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"
                    class="text-[#8696a0] group-hover:text-[#e9edef]">
                    <path
                        d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.96-2.36L6.5 17h11l-3.54-4.71z">
                    </path>
                </svg>
            </div>
        </button>

        <!-- You (Profile) -->
        <button id="nav_profile" class="nav-item group" title="You" onclick="window.toggleSettings()">
            <div
                class="w-8 h-8 rounded-full overflow-hidden border-2 border-transparent group-hover:border-[#00a884] transition-all">
                <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=2a3942&color=fff' }}"
                    class="w-full h-full object-cover my-avatar">
            </div>
        </button>
    </div>
</div>

<style>
    .nav-item {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        cursor: pointer;
        outline: none;
        padding: 4px 0;
    }

    .nav-item.active .p-2 {
        background-color: #384b57;
    }

    .nav-item.active svg {
        color: #e9edef !important;
    }
</style>
