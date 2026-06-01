<div id="privacy_status_panel"
    class="hidden flex-col w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="togglePrivacyStatus()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M20 11H7.8l5.6-5.6L12 4l-8 8 8 8 1.4-1.4L7.8 13H20v-2z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Status privacy</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] py-4">
        <div class="px-6 pb-6">
            <div class="text-[#8696a0] text-[14px] font-medium mb-6 mt-2">Who can see my status updates on WhatsApp</div>

            <div class="flex flex-col gap-6">
                <label class="flex items-start cursor-pointer group">
                    <div class="relative flex items-center justify-center w-5 h-5 mr-4 mt-0.5">
                        <input type="radio" name="privacy_status_radio" value="My contacts" class="peer sr-only" onchange="updatePrivacyStatus()">
                        <div class="w-5 h-5 border-[2px] border-[#8696a0] rounded-full peer-checked:border-[#00a884] transition-colors"></div>
                        <div class="absolute w-2.5 h-2.5 bg-[#00a884] rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <div>
                        <div class="text-[#e9edef] text-[16px] leading-tight">My contacts</div>
                        <div class="text-[#8696a0] text-[14px] mt-1">Share with all of your contacts</div>
                    </div>
                </label>
                
                <label class="flex items-start cursor-pointer group">
                    <div class="relative flex items-center justify-center w-5 h-5 mr-4 mt-0.5">
                        <input type="radio" name="privacy_status_radio" value="My contacts except..." class="peer sr-only" onchange="updatePrivacyStatus()">
                        <div class="w-5 h-5 border-[2px] border-[#8696a0] rounded-full peer-checked:border-[#00a884] transition-colors"></div>
                        <div class="absolute w-2.5 h-2.5 bg-[#00a884] rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <div>
                        <div class="text-[#e9edef] text-[16px] leading-tight">My contacts except...</div>
                        <div class="text-[#8696a0] text-[14px] mt-1">Share with your contacts except people you select</div>
                    </div>
                </label>

                <label class="flex items-start cursor-pointer group">
                    <div class="relative flex items-center justify-center w-5 h-5 mr-4 mt-0.5">
                        <input type="radio" name="privacy_status_radio" value="Only share with..." class="peer sr-only" checked onchange="updatePrivacyStatus()">
                        <div class="w-5 h-5 border-[2px] border-[#8696a0] rounded-full peer-checked:border-[#00a884] transition-colors"></div>
                        <div class="absolute w-2.5 h-2.5 bg-[#00a884] rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <div>
                        <div class="text-[#e9edef] text-[16px] leading-tight">Only share with...</div>
                        <div class="text-[#8696a0] text-[14px] mt-1" id="privacy_status_desc_label">1 contact included</div>
                    </div>
                </label>
            </div>
        </div>
    </div>
</div>

<script>
    window.togglePrivacyStatus = function() {
        const statusPanel = document.getElementById('privacy_status_panel');
        const privacyPanel = document.getElementById('privacy_settings_panel');

        if (statusPanel.classList.contains('hidden')) {
            statusPanel.classList.remove('hidden');
            statusPanel.classList.add('flex');
            if (privacyPanel) privacyPanel.classList.add('hidden');
            
            // Init state
            const saved = localStorage.getItem('whatsapp_privacy_status') || '1 contact included';
            let valToCheck = saved;
            if (saved !== 'My contacts' && saved !== 'My contacts except...' && !saved.includes('excluded') && !saved.includes('included')) {
                valToCheck = 'Only share with...';
            } else if (saved.includes('included')) {
                valToCheck = 'Only share with...';
            } else if (saved.includes('excluded')) {
                valToCheck = 'My contacts except...';
            }
            
            document.querySelectorAll('input[name="privacy_status_radio"]').forEach(r => {
                if(r.value === valToCheck) r.checked = true;
            });
            
            const descLabel = document.getElementById('privacy_status_desc_label');
            if (valToCheck === 'Only share with...' && descLabel) {
                const savedData = localStorage.getItem('whatsapp_privacy_exclude_status_include');
                let count = 1;
                if (savedData) { try { count = JSON.parse(savedData).length; } catch(e){} }
                descLabel.innerText = `${count} contact${count !== 1 ? 's' : ''} included`;
            }
        } else {
            statusPanel.classList.add('hidden');
            statusPanel.classList.remove('flex');
            if (privacyPanel) privacyPanel.classList.remove('hidden');
        }
    }

    window.updatePrivacyStatus = function() {
        let val = document.querySelector('input[name="privacy_status_radio"]:checked')?.value || '1 contact included';
        
        if (val === 'My contacts except...') {
            if (window.openPrivacyExcludePanel) window.openPrivacyExcludePanel('status');
            const savedData = localStorage.getItem('whatsapp_privacy_exclude_status');
            let count = 0;
            if (savedData) { try { count = JSON.parse(savedData).length; } catch(e){} }
            val = `${count} contact${count !== 1 ? 's' : ''} excluded`;
        } else if (val === 'Only share with...') {
            if (window.openPrivacyExcludePanel) window.openPrivacyExcludePanel('status_include');
            const savedData = localStorage.getItem('whatsapp_privacy_exclude_status_include');
            let count = 0;
            if (savedData) { try { count = JSON.parse(savedData).length; } catch(e){} }
            val = `${count} contact${count !== 1 ? 's' : ''} included`;
        }
        
        localStorage.setItem('whatsapp_privacy_status', val);
        
        const labelEl = document.getElementById('privacy_status_label');
        if (labelEl) labelEl.innerText = val;
        
        if(window.showToast && !val.includes('excluded') && !val.includes('included')) window.showToast('Privacy Updated', 'Setting saved.');
    }
</script>
