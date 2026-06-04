<div id="privacy_exclude_panel"
    class="hidden flex-col w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden z-[60] absolute top-0 left-0">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center justify-between shrink-0">
        <div class="flex items-center gap-6">
            <button onclick="closePrivacyExcludePanel(false)" class="text-[#aebac1] hover:text-white transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path>
                </svg>
            </button>
            <h2 class="text-[#e9edef] text-[19px] font-semibold" id="privacy_exclude_title">Hide from...</h2>
        </div>
        <button onclick="selectAllExclude()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M4 18h16c.55 0 1-.45 1-1s-.45-1-1-1H4c-.55 0-1 .45-1 1s.45 1 1 1zm0-5h16c.55 0 1-.45 1-1s-.45-1-1-1H4c-.55 0-1 .45-1 1s.45 1 1 1zM3 7c0 .55.45 1 1 1h16c.55 0 1-.45 1-1s-.45-1-1-1H4c-.55 0-1 .45-1 1z"></path>
                <path d="M19.5 3h-15c-.83 0-1.5.67-1.5 1.5v15c0 .83.67 1.5 1.5 1.5h15c.83 0 1.5-.67 1.5-1.5v-15c0-.83-.67-1.5-1.5-1.5zm-8.5 12.5L6.5 11l1.41-1.41 3.09 3.09 6.09-6.09L18.5 8l-7.5 7.5z" opacity="0.4" class="hidden"></path>
            </svg>
        </button>
    </div>

    <!-- Search -->
    <div class="px-3 py-2 border-b border-[#202c33] bg-[#111b21] shrink-0">
        <div class="bg-[#202c33] rounded-lg flex items-center px-3 py-1.5">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0] mr-3">
                <path d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 001.256-3.386 5.207 5.207 0 10-5.207 5.208 5.183 5.183 0 003.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-4.808 0a3.605 3.605 0 110-7.21 3.605 3.605 0 010 7.21z"></path>
            </svg>
            <input type="text" placeholder="Search name or number" class="bg-transparent text-[#d1d7db] text-[15px] placeholder-[#8696a0] w-full outline-none">
        </div>
    </div>

    <div class="px-6 py-4 text-[#00a884] text-[16px] shrink-0">
        Contacts
    </div>

    <!-- Contacts List -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21]">
        
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <!-- Contact Item -->
        <label class="flex items-center px-6 py-3 hover:bg-[#202c33] cursor-pointer group transition-colors">
            <div class="relative flex items-center justify-center w-5 h-5 mr-4">
                <input type="checkbox" name="exclude_contact" class="peer sr-only" value="<?php echo e($user->id); ?>" onchange="updateExcludeCount()">
                <div class="w-5 h-5 border-2 border-[#8696a0] rounded-sm peer-checked:bg-[#00a884] peer-checked:border-[#00a884] transition-colors"></div>
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="absolute opacity-0 peer-checked:opacity-100 transition-opacity"><path d="M20 6L9 17l-5-5"/></svg>
            </div>
            <div class="w-12 h-12 bg-[#202c33] rounded-full flex items-center justify-center mr-4 shrink-0 overflow-hidden">
                <?php if($user->avatar): ?>
                    <img src="<?php echo e($user->avatar); ?>" alt="avatar" class="w-full h-full object-cover">
                <?php else: ?>
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="white"><path d="M12 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm9 11a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3H8a3 3 0 0 0-3 3v2a1 1 0 0 1-2 0v-2a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v2z"/></svg>
                <?php endif; ?>
            </div>
            <div class="flex-1 border-b border-[#202c33] py-2 flex flex-col justify-center min-h-[48px]">
                <div class="text-[#e9edef] text-[17px]"><?php echo e($user->saved_name ?? $user->phone ?? $user->name); ?></div>
                <div class="text-[#8696a0] text-[14px] line-clamp-1 exclude-about-text"><?php echo e($user->about ?? ''); ?></div>
            </div>
        </label>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
        <div class="h-20"></div>
    </div>

    <!-- Bottom Action Bar -->
    <div class="absolute bottom-0 left-0 w-full h-[88px] bg-[#111b21] flex items-center justify-between px-6 border-t border-[#313d45]">
        <div class="text-[#e9edef] text-[16px]" id="exclude_count_text">0 contacts excluded</div>
        <button onclick="closePrivacyExcludePanel(true)" class="w-[50px] h-[50px] bg-[#00a884] rounded-full flex items-center justify-center hover:bg-[#008f6f] shadow-lg transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
        </button>
    </div>
</div>

<script>
    let currentPrivacySetting = '';

    window.openPrivacyExcludePanel = function(settingType) {
        currentPrivacySetting = settingType;
        const panel = document.getElementById('privacy_exclude_panel');
        if(panel) {
            panel.classList.remove('hidden');
            panel.classList.add('flex');
            
            // Set title based on setting
            const titleEl = document.getElementById('privacy_exclude_title');
            if (titleEl) {
                if (settingType === 'status' || settingType === 'status_include') {
                    titleEl.innerText = settingType === 'status' ? 'Hide status from...' : 'Share status with...';
                } else if (settingType === 'last_seen') {
                    titleEl.innerText = 'Hide last seen from...';
                } else if (settingType === 'profile_photo') {
                    titleEl.innerText = 'Hide profile photo from...';
                } else if (settingType === 'about') {
                    titleEl.innerText = 'Hide about from...';
                }
            }
            
            // Load saved state
            const savedData = localStorage.getItem('whatsapp_privacy_exclude_' + settingType);
            let excludedIds = [];
            if (savedData) {
                try {
                    excludedIds = JSON.parse(savedData);
                } catch(e) {}
            }
            
            document.querySelectorAll('input[name="exclude_contact"]').forEach(cb => {
                cb.checked = excludedIds.includes(cb.value);
            });
            updateExcludeCount();
        }
    }

    window.closePrivacyExcludePanel = function(save) {
        const panel = document.getElementById('privacy_exclude_panel');
        if(panel) {
            panel.classList.add('hidden');
            panel.classList.remove('flex');
            
            if(save && currentPrivacySetting) {
                const checkboxes = document.querySelectorAll('input[name="exclude_contact"]:checked');
                const excludedIds = Array.from(checkboxes).map(cb => cb.value);
                
                localStorage.setItem('whatsapp_privacy_exclude_' + currentPrivacySetting, JSON.stringify(excludedIds));
                
                const count = excludedIds.length;
                
                if (currentPrivacySetting === 'profile_photo') {
                    const labelEl = document.getElementById('privacy_profile_photo_label');
                    const privacyVal = `${count} contact${count !== 1 ? 's' : ''} excluded`;
                    localStorage.setItem('whatsapp_privacy_profile_photo', privacyVal);
                    if (labelEl) labelEl.innerText = privacyVal;
                    
                    if (window.db && window.ref && window.update && window.myUserId && window.myUserId !== '0') {
                        window.update(window.ref(window.db, `users/${window.myUserId}/privacy`), {
                            profile_photo: 'My contacts except...',
                            profile_photo_exclude: excludedIds
                        }).catch(err => console.error("Error updating exclude list in firebase:", err));
                    }
                }
                
                if (currentPrivacySetting === 'last_seen') {
                    const labelEl = document.getElementById('privacy_last_seen_label');
                    const lastSeenVal = `${count} contact${count !== 1 ? 's' : ''} excluded`;
                    const onlineVal = localStorage.getItem('whatsapp_privacy_online_val') || 'Everyone';
                    
                    localStorage.setItem('whatsapp_privacy_last_seen_val', lastSeenVal);
                    localStorage.setItem('whatsapp_privacy_last_seen', lastSeenVal + ', ' + onlineVal);
                    if (labelEl) labelEl.innerText = lastSeenVal + ', ' + onlineVal;
                    
                    if (window.db && window.ref && window.update && window.myUserId && window.myUserId !== '0') {
                        window.update(window.ref(window.db, `users/${window.myUserId}/privacy`), {
                            last_seen: 'My contacts except...',
                            last_seen_exclude: excludedIds
                        }).catch(err => console.error("Error updating last seen exclude list in firebase:", err));
                    }
                }
                
                if (currentPrivacySetting === 'about') {
                    const labelEl = document.getElementById('privacy_about_label');
                    const privacyVal = `${count} contact${count !== 1 ? 's' : ''} excluded`;
                    localStorage.setItem('whatsapp_privacy_about', privacyVal);
                    if (labelEl) labelEl.innerText = privacyVal;
                    
                    if (window.db && window.ref && window.update && window.myUserId && window.myUserId !== '0') {
                        window.update(window.ref(window.db, `users/${window.myUserId}/privacy`), {
                            about: 'My contacts except...',
                            about_exclude: excludedIds
                        }).catch(err => console.error("Error updating about exclude list in firebase:", err));
                    }
                }
                
                if(window.showToast) window.showToast('Updated', `Settings saved. ${count} contacts ${currentPrivacySetting === 'status_include' ? 'included' : 'excluded'}.`);
            }
        }
    }

    window.updateExcludeCount = function() {
        const count = document.querySelectorAll('input[name="exclude_contact"]:checked').length;
        const textEl = document.getElementById('exclude_count_text');
        if(textEl) {
            const action = currentPrivacySetting === 'status_include' ? 'included' : 'excluded';
            textEl.innerText = `${count} contact${count !== 1 ? 's' : ''} ${action}`;
        }
    }

    window.selectAllExclude = function() {
        const checkboxes = document.querySelectorAll('input[name="exclude_contact"]');
        let allChecked = true;
        checkboxes.forEach(cb => { if(!cb.checked) allChecked = false; });
        
        checkboxes.forEach(cb => cb.checked = !allChecked);
        updateExcludeCount();
    }
</script>
<?php /**PATH D:\xampp\htdocs\laravel\chat_app\resources\views/chat/settings/privacy_panels/privacy_exclude_contacts.blade.php ENDPATH**/ ?>