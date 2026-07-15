<!-- Global Search Sidebar Container -->
<div id="global_search_sidebar" class="hidden flex-col w-[30%] sm:min-w-[300px] border-r border-[#313d45] h-full bg-[#111b21] relative z-20 shrink-0">
    
    <!-- Header / Search Input area -->
    <div class="px-3 py-2 flex flex-col gap-3">
        <!-- Search Input with Back Arrow -->
        <div class="flex items-center bg-[#202c33] rounded-full h-10 px-3 w-full">
            <button onclick="closeGlobalSearch()" class="text-[#8696a0] hover:text-[#d1d7db] shrink-0 mr-3 transition-colors">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                    <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
                </svg>
            </button>
            <input type="text" id="global_search_input"
                placeholder="Ask Meta AI or Search"
                class="bg-transparent border-none focus:ring-0 w-full text-[15px] text-[#d1d7db] placeholder-[#8696a0] outline-none h-full">
            <button id="global_search_clear" onclick="clearGlobalSearch()" class="hidden text-[#8696a0] hover:text-[#d1d7db] shrink-0 ml-2 transition-colors">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path>
                </svg>
            </button>
        </div>

        <!-- Filter Chips -->
        <div class="flex items-center gap-2 overflow-x-auto custom-scrollbar pb-1 pt-1 -mx-3 px-3">
            <!-- Unread -->
            <button onclick="setGlobalSearchFilter('unread')" class="global-search-filter flex items-center gap-2 bg-[#202c33] hover:bg-[#2a3942] rounded-full px-3 py-1.5 shrink-0 transition-colors">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" class="text-[#aebac1]">
                    <path d="M18.8 6c.9 0 1.7.8 1.7 1.7v10.6c0 .9-.8 1.7-1.7 1.7H5.2c-.9 0-1.7-.8-1.7-1.7V7.7C3.5 6.8 4.3 6 5.2 6h13.6zm0 1.2H5.2c-.3 0-.5.2-.5.5v1.2l7.3 4.6 7.3-4.6V7.7c0-.3-.2-.5-.5-.5zm-13.6 11h13.6c.3 0 .5-.2.5-.5V9.4l-7.3 4.6-7.3-4.6v8.3c0 .3.2.5.5.5z"></path>
                </svg>
                <span class="text-[#aebac1] text-[14px] font-medium">Unread</span>
            </button>
            <!-- Photos -->
            <button onclick="setGlobalSearchFilter('photos')" class="global-search-filter flex items-center gap-2 bg-[#202c33] hover:bg-[#2a3942] rounded-full px-3 py-1.5 shrink-0 transition-colors">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" class="text-[#aebac1]">
                    <path d="M21.1 5.3h-1.5l-1-1.3C18 3.3 17.3 3 16.5 3h-9C6.7 3 6 3.3 5.4 4L4.4 5.3H2.9C1.3 5.3 0 6.6 0 8.2v10.6C0 20.4 1.3 21.7 2.9 21.7h18.2c1.6 0 2.9-1.3 2.9-2.9V8.2c0-1.6-1.3-2.9-2.9-2.9zM12 18.5c-3.1 0-5.7-2.5-5.7-5.7s2.5-5.7 5.7-5.7 5.7 2.5 5.7 5.7-2.5 5.7-5.7 5.7zm0-9.8c-2.3 0-4.1 1.8-4.1 4.1s1.8 4.1 4.1 4.1 4.1-1.8 4.1-4.1-1.8-4.1-4.1-4.1z"></path>
                </svg>
                <span class="text-[#aebac1] text-[14px] font-medium">Photos</span>
            </button>
            <!-- Videos -->
            <button onclick="setGlobalSearchFilter('videos')" class="global-search-filter flex items-center gap-2 bg-[#202c33] hover:bg-[#2a3942] rounded-full px-3 py-1.5 shrink-0 transition-colors">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" class="text-[#aebac1]">
                    <path d="M17.3 5.6H2.7C1.2 5.6 0 6.8 0 8.3v7.4C0 17.2 1.2 18.4 2.7 18.4h14.6c1.5 0 2.7-1.2 2.7-2.7V8.3c0-1.5-1.2-2.7-2.7-2.7zm.8 9.2L22 17.2c.4.3 1-.1 1-.5V7.3c0-.4-.6-.8-1-.5l-3.9 2.4v5.6z"></path>
                </svg>
                <span class="text-[#aebac1] text-[14px] font-medium">Videos</span>
            </button>
            <!-- Links -->
            <button onclick="setGlobalSearchFilter('links')" class="global-search-filter flex items-center gap-2 bg-[#202c33] hover:bg-[#2a3942] rounded-full px-3 py-1.5 shrink-0 transition-colors">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" class="text-[#aebac1]">
                    <path d="M8.8 14.8c-.8.8-2 .8-2.8 0l-2.8-2.8c-.8-.8-.8-2 0-2.8l2.8-2.8c.8-.8 2-.8 2.8 0 .3.3.5.7.7 1.2l1.6-.9c-.3-.9-.9-1.6-1.6-2.3-1.6-1.6-4.1-1.6-5.7 0L1 7.2C-.6 8.8-.6 11.3 1 12.9l2.8 2.8c1.6 1.6 4.1 1.6 5.7 0 .5-.5 1-1.2 1.3-2l-1.5-1c-.2.7-.4 1.4-1.3 2.1zm5.4-8.7c-.5.5-1 1.2-1.3 2l1.5 1c.2-.7.4-1.4 1.3-2.1.8-.8 2-.8 2.8 0l2.8 2.8c.8.8.8 2 0 2.8l-2.8 2.8c-.8.8-2 .8-2.8 0-.3-.3-.5-.7-.7-1.2l-1.6.9c.3.9.9 1.6 1.6 2.3 1.6 1.6 4.1 1.6 5.7 0l2.8-2.8c1.6-1.6 1.6-4.1 0-5.7l-2.8-2.8c-1.6-1.6-4.1-1.6-5.7 0z"></path>
                </svg>
                <span class="text-[#aebac1] text-[14px] font-medium">Links</span>
            </button>
        </div>
    </div>

    <div class="w-full h-[1px] bg-[#202c33] my-1"></div>

    <!-- Search Results Container -->
    <div id="global_search_results" class="flex-1 overflow-y-auto custom-scrollbar flex flex-col items-center justify-center">
        <!-- Initial State -->
        <span class="text-[#8696a0] text-[14px]">Search for messages, photos, videos, or links.</span>
    </div>

</div>

<script>
    window.openGlobalSearch = function() {
        // Hide normal sidebar
        document.getElementById('user_sidebar_container')?.classList.add('hidden');
        document.getElementById('user_sidebar_container')?.classList.remove('sm:flex');
        
        // Show Global search sidebar
        document.getElementById('global_search_sidebar').classList.remove('hidden');
        document.getElementById('global_search_sidebar').classList.add('flex', 'sm:flex');
        
        // Focus the input
        document.getElementById('global_search_input')?.focus();
    }

    window.closeGlobalSearch = function() {
        // Hide Global search sidebar
        document.getElementById('global_search_sidebar').classList.add('hidden');
        document.getElementById('global_search_sidebar').classList.remove('flex', 'sm:flex');
        
        // Show normal sidebar
        document.getElementById('user_sidebar_container')?.classList.remove('hidden');
        document.getElementById('user_sidebar_container')?.classList.add('sm:flex');
        
        // Unfocus search in main sidebar
        window.blurSidebarSearch();
        
        // Clear input
        document.getElementById('global_search_input').value = '';
        window.clearGlobalSearch();
    }

    window.clearGlobalSearch = function() {
        document.getElementById('global_search_input').value = '';
        document.getElementById('global_search_clear').classList.add('hidden');
        
        // Reset results UI
        document.getElementById('global_search_results').innerHTML = `<span class="text-[#8696a0] text-[14px]">Search for messages, photos, videos, or links.</span>`;
        document.getElementById('global_search_results').classList.add('items-center', 'justify-center');
    }

    // Input event
    document.getElementById('global_search_input')?.addEventListener('input', function(e) {
        if(this.value.trim().length > 0) {
            document.getElementById('global_search_clear').classList.remove('hidden');
        } else {
            document.getElementById('global_search_clear').classList.add('hidden');
        }
    });

    window.setGlobalSearchFilter = function(filter) {
        // Handle filter selection styling
        document.querySelectorAll('.global-search-filter').forEach(btn => {
            btn.classList.remove('bg-[#0a332c]');
            btn.classList.add('bg-[#202c33]');
            btn.querySelector('svg').classList.remove('text-[#00a884]');
            btn.querySelector('span').classList.remove('text-[#00a884]');
            
            btn.querySelector('svg').classList.add('text-[#aebac1]');
            btn.querySelector('span').classList.add('text-[#aebac1]');
        });
        
        const activeBtn = event.currentTarget;
        activeBtn.classList.remove('bg-[#202c33]');
        activeBtn.classList.add('bg-[#0a332c]');
        
        activeBtn.querySelector('svg').classList.remove('text-[#aebac1]');
        activeBtn.querySelector('svg').classList.add('text-[#00a884]');
        activeBtn.querySelector('span').classList.remove('text-[#aebac1]');
        activeBtn.querySelector('span').classList.add('text-[#00a884]');

        // TODO: Implement actual filtering logic later
        console.log("Global search filter set to:", filter);
    }
</script>
