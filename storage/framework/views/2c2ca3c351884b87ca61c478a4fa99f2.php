<div id="privacy_profile_photo_panel"
    class="hidden flex-col w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="togglePrivacyProfilePhoto()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M20 11H7.8l5.6-5.6L12 4l-8 8 8 8 1.4-1.4L7.8 13H20v-2z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Profile picture</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] py-4">
        <div class="px-6 pb-6">
            <div class="text-[#8696a0] text-[14px] font-medium mb-6 mt-2">Who can see my profile picture</div>

            <div class="flex flex-col gap-6">
                <label class="flex items-center cursor-pointer group">
                    <div class="relative flex items-center justify-center w-5 h-5 mr-4">
                        <input type="radio" name="privacy_profile_photo_radio" value="Everyone" class="peer sr-only" onchange="updatePrivacyProfilePhoto()">
                        <div class="w-5 h-5 border-[2px] border-[#8696a0] rounded-full peer-checked:border-[#00a884] transition-colors"></div>
                        <div class="absolute w-2.5 h-2.5 bg-[#00a884] rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <span class="text-[#e9edef] text-[16px]">Everyone</span>
                </label>
                
                <label class="flex items-center cursor-pointer group">
                    <div class="relative flex items-center justify-center w-5 h-5 mr-4">
                        <input type="radio" name="privacy_profile_photo_radio" value="My contacts" class="peer sr-only" checked onchange="updatePrivacyProfilePhoto()">
                        <div class="w-5 h-5 border-[2px] border-[#8696a0] rounded-full peer-checked:border-[#00a884] transition-colors"></div>
                        <div class="absolute w-2.5 h-2.5 bg-[#00a884] rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <span class="text-[#e9edef] text-[16px]">My contacts</span>
                </label>
                
                <label class="flex items-center cursor-pointer group">
                    <div class="relative flex items-center justify-center w-5 h-5 mr-4">
                        <input type="radio" name="privacy_profile_photo_radio" value="My contacts except..." class="peer sr-only" onchange="updatePrivacyProfilePhoto()">
                        <div class="w-5 h-5 border-[2px] border-[#8696a0] rounded-full peer-checked:border-[#00a884] transition-colors"></div>
                        <div class="absolute w-2.5 h-2.5 bg-[#00a884] rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <span class="text-[#e9edef] text-[16px]">My contacts except...</span>
                </label>

                <label class="flex items-center cursor-pointer group">
                    <div class="relative flex items-center justify-center w-5 h-5 mr-4">
                        <input type="radio" name="privacy_profile_photo_radio" value="Nobody" class="peer sr-only" onchange="updatePrivacyProfilePhoto()">
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
    window.togglePrivacyProfilePhoto = function() {
        const photoPanel = document.getElementById('privacy_profile_photo_panel');
        const privacyPanel = document.getElementById('privacy_settings_panel');

        if (photoPanel.classList.contains('hidden')) {
            photoPanel.classList.remove('hidden');
            photoPanel.classList.add('flex');
            if (privacyPanel) privacyPanel.classList.add('hidden');
            
            // Init state
            const saved = localStorage.getItem('whatsapp_privacy_profile_photo') || 'My contacts';
            let valToCheck = saved;
            if (saved.includes('excluded')) {
                valToCheck = 'My contacts except...';
            }
            
            document.querySelectorAll('input[name="privacy_profile_photo_radio"]').forEach(r => {
                if(r.value === valToCheck) r.checked = true;
            });
        } else {
            photoPanel.classList.add('hidden');
            photoPanel.classList.remove('flex');
            if (privacyPanel) privacyPanel.classList.remove('hidden');
        }
    }

    window.updatePrivacyProfilePhoto = function() {
        let val = document.querySelector('input[name="privacy_profile_photo_radio"]:checked')?.value || 'My contacts';
        
        if (val === 'My contacts except...') {
            if (window.openPrivacyExcludePanel) window.openPrivacyExcludePanel('profile_photo');
            const savedData = localStorage.getItem('whatsapp_privacy_exclude_profile_photo');
            let count = 0;
            if (savedData) { try { count = JSON.parse(savedData).length; } catch(e){} }
            val = `${count} contact${count !== 1 ? 's' : ''} excluded`;
        }
        
        localStorage.setItem('whatsapp_privacy_profile_photo', val);
        
        const labelEl = document.getElementById('privacy_profile_photo_label');
        if (labelEl) labelEl.innerText = val;
        
        if(window.showToast && !val.includes('excluded')) window.showToast('Privacy Updated', 'Setting saved.');
    }
</script>
<?php /**PATH D:\xampp\htdocs\laravel\chat_app\resources\views/chat/settings/privacy_panels/privacy_profile_photo.blade.php ENDPATH**/ ?>