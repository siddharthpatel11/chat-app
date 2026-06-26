<!-- Channels Sidebar -->
<div id="channels_sidebar_container" class="hidden h-full flex flex-col bg-[#111b21] w-[30%] min-w-[300px] border-r border-[#313d45] z-50 shrink-0 relative flex-1 sm:flex-none">
    <!-- Header -->
    <div class="px-4 py-3 bg-[#111b21] shrink-0 h-[60px] flex items-center justify-between z-20">
        <h1 class="text-[#e9edef] text-[22px] font-medium">Channels</h1>
        <div class="flex items-center gap-4 relative">
            <button class="text-[#aebac1] hover:text-[#e9edef] focus:outline-none transition-colors" onclick="window.toggleChannelsHeaderMenu(event)" title="Options">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"></path>
                </svg>
            </button>
            
            <!-- Dropdown Menu -->
            <div id="channels_header_menu" class="hidden absolute right-0 top-10 bg-[#233138] rounded-2xl shadow-2xl py-2 w-48 z-[100] border border-[#313d45]">
                <button onclick="window.showCreateChannelIntroModal(); window.toggleChannelsHeaderMenu(event);" class="w-full flex items-center gap-4 px-5 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors text-[15px]">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                        <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm1 14h-2v-3H8v-2h3V8h2v3h3v2h-3v3z"></path>
                    </svg>
                    Create channel
                </button>
                <button onclick="window.showFindChannelsSidebar(); window.toggleChannelsHeaderMenu(event);" class="w-full flex items-center gap-4 px-5 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors text-[15px]">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                    </svg>
                    Find channels
                </button>
            </div>
        </div>
    </div>

    <!-- Search/Discover -->
    <div class="px-3 py-2 bg-[#111b21] shrink-0 border-b border-[#202c33]">
        <div class="flex items-center bg-[#202c33] rounded-lg px-3 py-1 border border-transparent focus-within:border-[#00a884]/30 focus-within:bg-[#2a3942] transition-colors">
            <svg class="w-5 h-5 text-[#8696a0] mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" id="channels_search_input" oninput="window.filterChannels()" placeholder="Search" class="w-full bg-transparent border-none text-[#e9edef] text-[15px] focus:ring-0 placeholder-[#8696a0] py-1">
        </div>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21]">
        
        <!-- Followed Channels List -->
        <div id="my_channels_list">
            <!-- Populated via Firebase JS -->
        </div>

        <div class="px-4 py-2 mt-2">
            <h2 class="text-[#8696a0] text-[15px] font-normal mb-2">Find channels to follow</h2>
        </div>

        <!-- Discover Channels List -->
        <div id="discover_channels_list" class="">
            <!-- Populated via Firebase JS -->
        </div>

        <!-- Action Buttons -->
        <div class="px-4 py-4 flex flex-col gap-3 border-t border-[#202c33]">
            <button onclick="window.loadDiscoverChannels()" class="w-full flex items-center justify-center gap-2 border border-[#313d45] text-[#00a884] rounded-full py-2 px-4 font-medium text-[15px] hover:bg-[#202c33] transition-colors">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                    <path d="M4 4h6v6H4V4zm10 0h6v6h-6V4zM4 14h6v6H4v-6zm10 0h6v6h-6v-6z"/>
                </svg>
                Discover more
            </button>
            <button onclick="window.showCreateChannelIntroModal()" class="w-full flex items-center justify-center gap-2 border border-[#313d45] text-[#00a884] rounded-full py-2 px-4 font-medium text-[15px] hover:bg-[#202c33] transition-colors">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                    <path d="M12 4v16M4 12h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                Create channel
            </button>
        </div>

    </div>
</div>

<script>
    window.showChannels = function() {
        // Hide all sidebars
        if(typeof window.closeAllSidebarPanels === 'function') {
            window.closeAllSidebarPanels();
        }

        // Hide user sidebar
        document.getElementById('user_sidebar_container')?.classList.add('hidden');
        document.getElementById('user_sidebar_container')?.classList.remove('flex', 'sm:flex');
        
        // Hide status view
        document.getElementById('status_view_container')?.classList.add('hidden');
        document.getElementById('status_view_container')?.classList.remove('flex');

        // Hide calls sidebar and main column
        document.getElementById('calls_sidebar_container')?.classList.add('hidden');
        document.getElementById('calls_sidebar_container')?.classList.remove('flex');
        document.getElementById('calls_main_column')?.classList.add('hidden');
        document.getElementById('calls_main_column')?.classList.remove('flex');
        
        // Hide main chat area
        document.getElementById('chat_view_container')?.classList.add('hidden');
        document.getElementById('chat_view_container')?.classList.remove('flex');

        // Show Channels sidebar
        document.getElementById('channels_sidebar_container')?.classList.remove('hidden');
        document.getElementById('channels_sidebar_container')?.classList.add('flex');

        // Show default empty state for channels if no channel is selected
        document.getElementById('channels_main_column')?.classList.remove('hidden');
        document.getElementById('channels_main_column')?.classList.add('flex');

        document.getElementById('sidebar_resizer')?.classList.remove('hidden');

        // Update nav active states
        document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
        document.getElementById('nav_channels')?.classList.add('active');

        // Load channels from Firebase
        if (typeof window.loadMyChannels === 'function') {
            window.loadMyChannels();
        }
    }

    window.toggleChannelsHeaderMenu = function(e) {
        if(e) e.stopPropagation();
        const menu = document.getElementById('channels_header_menu');
        menu.classList.toggle('hidden');
    };

    document.addEventListener('click', function(e) {
        const menu = document.getElementById('channels_header_menu');
        if (menu && !menu.classList.contains('hidden') && !e.target.closest('#channels_header_menu') && !e.target.closest('button[onclick="window.toggleChannelsHeaderMenu(event)"]')) {
            menu.classList.add('hidden');
        }
    });

    window.showCreateChannelIntroModal = function() {
        const modal = document.getElementById('create_channel_intro_modal');
        const content = document.getElementById('create_channel_intro_modal_content');
        if(modal) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('opacity-100');
                if(content) {
                    content.classList.remove('scale-95', 'opacity-0');
                    content.classList.add('scale-100', 'opacity-100');
                }
            }, 10);
        }
    };
    
    window.closeCreateChannelIntroModal = function() {
        const modal = document.getElementById('create_channel_intro_modal');
        const content = document.getElementById('create_channel_intro_modal_content');
        if(content) {
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
        }
        if(modal) {
            setTimeout(() => {
                modal.classList.remove('opacity-100');
                modal.classList.add('hidden');
            }, 300);
        }
    };

    window.continueToCreateChannel = function() {
        window.closeCreateChannelIntroModal();
        window.showCreateChannelModal(); // existing function
    };
</script>
