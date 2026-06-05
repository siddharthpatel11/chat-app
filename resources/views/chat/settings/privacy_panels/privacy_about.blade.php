<div id="privacy_about_panel"
    class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="togglePrivacyAbout()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M20 11H7.8l5.6-5.6L12 4l-8 8 8 8 1.4-1.4L7.8 13H20v-2z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">About</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] py-4">
        <div class="px-6 pb-6">
            <div class="text-[#8696a0] text-[14px] font-medium mb-6 mt-2">Who can see my About</div>

            <div class="flex flex-col gap-6">
                <label class="flex items-center cursor-pointer group">
                    <div class="relative flex items-center justify-center w-5 h-5 mr-4">
                        <input type="radio" name="privacy_about_radio" value="Everyone" class="peer sr-only" onchange="updatePrivacyAbout()">
                        <div class="w-5 h-5 border-[2px] border-[#8696a0] rounded-full peer-checked:border-[#00a884] transition-colors"></div>
                        <div class="absolute w-2.5 h-2.5 bg-[#00a884] rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <span class="text-[#e9edef] text-[16px]">Everyone</span>
                </label>
                
                <label class="flex items-center cursor-pointer group">
                    <div class="relative flex items-center justify-center w-5 h-5 mr-4">
                        <input type="radio" name="privacy_about_radio" value="My contacts" class="peer sr-only" onchange="updatePrivacyAbout()">
                        <div class="w-5 h-5 border-[2px] border-[#8696a0] rounded-full peer-checked:border-[#00a884] transition-colors"></div>
                        <div class="absolute w-2.5 h-2.5 bg-[#00a884] rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <span class="text-[#e9edef] text-[16px]">My contacts</span>
                </label>
                
                <label class="flex items-center cursor-pointer group">
                    <div class="relative flex items-center justify-center w-5 h-5 mr-4">
                        <input type="radio" name="privacy_about_radio" value="My contacts except..." class="peer sr-only" onchange="updatePrivacyAbout()">
                        <div class="w-5 h-5 border-[2px] border-[#8696a0] rounded-full peer-checked:border-[#00a884] transition-colors"></div>
                        <div class="absolute w-2.5 h-2.5 bg-[#00a884] rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <span class="text-[#e9edef] text-[16px]">My contacts except...</span>
                </label>

                <label class="flex items-center cursor-pointer group">
                    <div class="relative flex items-center justify-center w-5 h-5 mr-4">
                        <input type="radio" name="privacy_about_radio" value="Nobody" class="peer sr-only" checked onchange="updatePrivacyAbout()">
                        <div class="w-5 h-5 border-[2px] border-[#8696a0] rounded-full peer-checked:border-[#00a884] transition-colors"></div>
                        <div class="absolute w-2.5 h-2.5 bg-[#00a884] rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <span class="text-[#e9edef] text-[16px]">Nobody</span>
                </label>
            </div>
        </div>
    </div>
</div>

<script>
    window.togglePrivacyAbout = function() {
        const aboutPanel = document.getElementById('privacy_about_panel');
        const privacyPanel = document.getElementById('privacy_settings_panel');

        if (aboutPanel.classList.contains('hidden')) {
            aboutPanel.classList.remove('hidden');
            aboutPanel.classList.add('flex');
            if (privacyPanel) privacyPanel.classList.add('hidden');
            
            // Init state
            const saved = localStorage.getItem('whatsapp_privacy_about') || 'Nobody';
            let valToCheck = saved;
            if (saved.includes('excluded')) {
                valToCheck = 'My contacts except...';
            }
            
            document.querySelectorAll('input[name="privacy_about_radio"]').forEach(r => {
                if(r.value === valToCheck) r.checked = true;
            });
        } else {
            aboutPanel.classList.add('hidden');
            aboutPanel.classList.remove('flex');
            if (privacyPanel) privacyPanel.classList.remove('hidden');
        }
    }

    window.updatePrivacyAbout = function() {
        let val = document.querySelector('input[name="privacy_about_radio"]:checked')?.value || 'Nobody';
        
        if (val === 'My contacts except...') {
            if (window.openPrivacyExcludePanel) window.openPrivacyExcludePanel('about');
            const savedData = localStorage.getItem('whatsapp_privacy_exclude_about');
            let count = 0;
            if (savedData) { try { count = JSON.parse(savedData).length; } catch(e){} }
            val = `${count} contact${count !== 1 ? 's' : ''} excluded`;
        }
        
        localStorage.setItem('whatsapp_privacy_about', val);
        
        const labelEl = document.getElementById('privacy_about_label');
        if (labelEl) labelEl.innerText = val;
        
        if (window.db && window.ref && window.set && window.myUserId && window.myUserId !== '0') {
            if (val === 'Everyone' || val === 'My contacts' || val === 'Nobody') {
                window.set(window.ref(window.db, `users/${window.myUserId}/privacy/about`), val)
                    .catch(err => console.error("Error updating firebase privacy:", err));
            }
        }
        
        if(window.showToast && !val.includes('excluded')) window.showToast('Privacy Updated', 'Setting saved.');
    }
</script>
