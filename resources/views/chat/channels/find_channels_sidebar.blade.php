<!-- Find Channels Sidebar -->
<div id="find_channels_sidebar_container" class="hidden h-full flex flex-col bg-[#111b21] w-full sm:w-[30%] sm:min-w-[300px] border-r border-[#313d45] z-[60] absolute top-0 left-0 sm:left-[60px] transition-transform duration-300 transform -translate-x-full">
    
    <!-- Header -->
    <div class="h-[108px] bg-[#202c33] shrink-0 flex items-end px-4 pb-4 gap-6 text-[#e9edef] border-b border-[#313d45]">
        <button onclick="window.closeFindChannelsSidebar()" class="hover:bg-white/10 p-2 rounded-full transition-colors mb-0.5 focus:outline-none">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M20 11H7.8l5.6-5.6L12 4l-8 8 8 8 1.4-1.4L7.8 13H20v-2z"></path>
            </svg>
        </button>
        <h1 class="text-[19px] font-medium pb-1 flex-1">Find channels</h1>
        <button class="hover:bg-white/10 p-2 rounded-full transition-colors mb-0.5 focus:outline-none text-[#e9edef]">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z"></path>
            </svg>
        </button>
    </div>

    <!-- Search/Discover -->
    <div class="px-3 py-2 bg-[#111b21] shrink-0">
        <div class="flex items-center bg-[#202c33] rounded-lg px-3 py-1.5 border border-transparent focus-within:border-[#00a884]/30 focus-within:bg-[#2a3942] transition-colors">
            <svg class="w-5 h-5 text-[#8696a0] mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" id="find_channels_search_input" oninput="window.filterFindChannels()" placeholder="Search" class="w-full bg-transparent border-none text-[#e9edef] text-[15px] focus:ring-0 placeholder-[#8696a0] py-1">
        </div>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21]">
        
        <!-- Explore Categories (Populated via JS) -->
        <div id="find_channels_explore_list">
            <!-- Loading State -->
            <div class="p-4 text-center text-[#8696a0] text-sm">Loading channels...</div>
        </div>

    </div>
</div>

<script>
    window.showFindChannelsSidebar = function() {
        const panel = document.getElementById('find_channels_sidebar_container');
        panel.classList.remove('hidden');
        // Force reflow
        void panel.offsetWidth;
        panel.classList.remove('-translate-x-full');
        panel.classList.add('translate-x-0');
        
        window.loadFindChannelsCategories();
    };

    window.closeFindChannelsSidebar = function() {
        const panel = document.getElementById('find_channels_sidebar_container');
        panel.classList.remove('translate-x-0');
        panel.classList.add('-translate-x-full');
        setTimeout(() => {
            panel.classList.add('hidden');
        }, 300);
    };

    window.filterFindChannels = function() {
        const val = document.getElementById('find_channels_search_input').value.toLowerCase();
        const listContainer = document.getElementById('find_channels_explore_list');
        if(!listContainer) return;
        
        const items = listContainer.querySelectorAll('.group');
        let visibleCount = 0;
        
        items.forEach(item => {
            const h3 = item.querySelector('h3');
            if (!h3) return;
            const name = h3.innerText.toLowerCase();
            if (name.includes(val)) {
                item.style.display = 'flex';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        
        // Hide/Show section headers if all their children are hidden
        const sections = listContainer.querySelectorAll('.category-section');
        sections.forEach(sec => {
            const children = sec.querySelectorAll('.group');
            let hasVisible = false;
            children.forEach(c => {
                if (c.style.display === 'flex') hasVisible = true;
            });
            sec.style.display = hasVisible ? 'block' : 'none';
        });
        
        let noResultsMsg = document.getElementById('find_channels_no_results');
        if (visibleCount === 0 && items.length > 0) {
            if (!noResultsMsg) {
                noResultsMsg = document.createElement('div');
                noResultsMsg.id = 'find_channels_no_results';
                noResultsMsg.className = 'p-4 text-center text-[#8696a0] text-sm mt-4';
                noResultsMsg.innerText = 'No channels found.';
                listContainer.appendChild(noResultsMsg);
            }
            noResultsMsg.style.display = 'block';
        } else {
            if (noResultsMsg) noResultsMsg.style.display = 'none';
        }
    };
</script>
