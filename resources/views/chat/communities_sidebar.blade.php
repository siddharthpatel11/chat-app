<div id="communities_sidebar_container"
    class="hidden flex-col w-[30%] sm:min-w-[300px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0">

    <!-- Communities Header -->
    <div class="h-16 bg-[#202c33] flex items-center px-4 justify-between shrink-0 border-b border-[#313d45]">
        <div class="flex items-center gap-3">
            <span class="font-semibold text-xl text-[#e9edef]">Communities</span>
        </div>
        <div class="flex items-center gap-2 text-[#aebac1]">
            <button class="p-2 rounded-full hover:bg-[#384b57] transition-colors focus:outline-none">
                <svg viewBox="0 0 24 24" height="24" width="24" fill="currentColor">
                    <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Scrollable content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar" id="communities_list_container">
        <!-- New Community Action -->
        <div id="new_community_action_btn" onclick="window.startCreateCommunityFlow()"
            class="flex items-center px-4 py-4 hover:bg-[#202c33] cursor-pointer transition-colors border-b border-[#202c33]">
            <div class="relative w-12 h-12 rounded-xl bg-[#2a3942] flex items-center justify-center text-[#8696a0] shrink-0">
                <svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor">
                    <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                </svg>
                <div class="absolute bottom-0 right-0 w-5 h-5 bg-[#00a884] rounded-full flex items-center justify-center text-white border-2 border-[#111b21]">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="4">
                        <path d="M12 5v14M5 12h14" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
            <div class="ml-4 flex-1">
                <h4 class="text-[17px] text-[#e9edef] font-medium">New community</h4>
            </div>
        </div>

        <!-- Dynamic List of Communities -->
        <div id="communities_list" class="flex flex-col">
            <!-- Loading Indicator -->
            <div id="communities_loading" class="p-6 text-center text-[#8696a0] text-sm">
                Loading communities...
            </div>
        </div>
    </div>
</div>
