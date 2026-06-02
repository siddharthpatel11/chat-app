<div id="chats_upload_quality_panel"
    class="hidden flex-col w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="toggleUploadQualityPanel()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Media upload quality</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] py-4 px-6">
        
        <label class="flex items-start gap-4 cursor-pointer group mt-4 mb-8">
            <div class="relative flex items-center justify-center pt-1">
                <input type="radio" name="chat_quality_radio" value="Standard quality" class="peer sr-only" onchange="updateUploadQuality()" checked>
                <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] transition-colors"></div>
                <div class="absolute w-2.5 h-2.5 rounded-full bg-[#00a884] opacity-0 peer-checked:opacity-100 transition-opacity top-[9px]"></div>
            </div>
            <div class="flex flex-col flex-1">
                <span class="text-[#e9edef] text-[16px] mb-1">Standard quality</span>
                <span class="text-[#8696a0] text-[14px]">Standard media uses less storage and are faster to send</span>
            </div>
        </label>

        <label class="flex items-start gap-4 cursor-pointer group">
            <div class="relative flex items-center justify-center pt-1">
                <input type="radio" name="chat_quality_radio" value="HD quality" class="peer sr-only" onchange="updateUploadQuality()">
                <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] transition-colors"></div>
                <div class="absolute w-2.5 h-2.5 rounded-full bg-[#00a884] opacity-0 peer-checked:opacity-100 transition-opacity top-[9px]"></div>
            </div>
            <div class="flex flex-col flex-1">
                <span class="text-[#e9edef] text-[16px] mb-1">HD quality</span>
                <span class="text-[#8696a0] text-[14px]">HD media is slower to send, can be 6 times larger</span>
            </div>
        </label>

    </div>
</div>

<script>
    window.openUploadQualityModal = function() {
        toggleUploadQualityPanel();
    }
    
    window.toggleUploadQualityPanel = function() {
        const qualityPanel = document.getElementById('chats_upload_quality_panel');
        const chatPanel = document.getElementById('chats_settings_panel');
        
        if (qualityPanel.classList.contains('hidden')) {
            qualityPanel.classList.remove('hidden');
            qualityPanel.classList.add('flex');
            if (chatPanel) chatPanel.classList.add('hidden');
            
            // Init state
            const saved = localStorage.getItem('whatsapp_chat_upload_quality') || 'Standard quality';
            document.querySelectorAll('input[name="chat_quality_radio"]').forEach(r => {
                if(r.value === saved) r.checked = true;
            });
        } else {
            qualityPanel.classList.add('hidden');
            qualityPanel.classList.remove('flex');
            if (chatPanel) chatPanel.classList.remove('hidden');
        }
    }

    window.updateUploadQuality = function() {
        const val = document.querySelector('input[name="chat_quality_radio"]:checked')?.value || 'Standard quality';
        localStorage.setItem('whatsapp_chat_upload_quality', val);
        if(window.showToast) window.showToast('Updated', `Media upload quality set to ${val}.`);
    }
</script>
<?php /**PATH D:\xampp\htdocs\laravel\chat_app\resources\views/chat/settings/chats_panels/chats_upload_quality.blade.php ENDPATH**/ ?>