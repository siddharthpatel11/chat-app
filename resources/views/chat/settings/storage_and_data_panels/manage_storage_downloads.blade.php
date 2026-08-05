<!-- Manage Downloads Sidebar -->
<div id="manage_storage_downloads_panel" class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden relative z-[50]">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="window.closeStorageDownloads()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M20 11H7.8l5.6-5.6L12 4l-8 8 8 8 1.4-1.4L7.8 13H20v-2z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Downloads</h2>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#0b141a] flex flex-col items-center justify-center">
        <div class="text-[#8696a0] text-[16px]">No downloads</div>
    </div>
</div>

<script>
    window.closeStorageDownloads = function() {
        const storagePanel = document.getElementById('manage_storage_panel');
        const downloadsPanel = document.getElementById('manage_storage_downloads_panel');
        
        if (downloadsPanel) {
            downloadsPanel.classList.add('hidden');
            downloadsPanel.classList.remove('flex');
        }
        if (storagePanel) {
            storagePanel.classList.remove('hidden');
            storagePanel.classList.add('flex');
        }
    }
</script>
