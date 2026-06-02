<div id="settings_panel"
    class="hidden flex-col w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="toggleSettings()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Settings</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21]">
        <!-- Title & Search (Matching Image 2) -->
        <div class="px-6 pt-4 pb-2">
            <h1 class="text-[#e9edef] text-[22px] font-bold mb-4"><?php echo e(auth()->user()->name); ?></h1>
            <div
                class="bg-[#202c33] rounded-full flex items-center px-4 py-2 h-[40px] border-2 border-transparent focus-within:border-[#00a884] transition-all">
                <svg class="w-4 h-4 text-[#8696a0]" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 0 0 1.256-3.386 5.207 5.207 0 1 0-5.207 5.208 5.183 5.183 0 0 0 3.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-4.6-1.598a3.608 3.608 0 1 1 0-7.216 3.608 3.608 0 0 1 0 7.216z">
                    </path>
                </svg>
                <input type="text" placeholder="Search"
                    class="bg-transparent border-none focus:ring-0 w-full text-[15px] ml-3 text-[#d1d7db] placeholder-[#8696a0]">
            </div>
        </div>

        <!-- Bubble Profile Section (Matching Image 2) -->
        <div class="flex flex-col items-center py-6">
            <div class="relative flex flex-col items-center">
                <!-- Name Tag Pill -->
                <div class="bg-[#3b4a54] px-5 py-1.5 rounded-full mb-[-25px] z-10 shadow-xl border border-[#44535c]">
                    <span class="text-[#e9edef] text-[15px] font-medium"><?php echo e(auth()->user()->name); ?></span>
                </div>
                <!-- Profile Image Bubble -->
                <div
                    class="w-[200px] h-[200px] rounded-full overflow-hidden border-[8px] border-[#111b21] shadow-2xl relative group cursor-pointer mt-2">
                    <img src="<?php echo e(auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=2a3942&color=fff&size=256'); ?>"
                        class="w-full h-full object-cover my-avatar">
                    <div
                        class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg viewBox="0 0 24 24" width="30" height="30" fill="currentColor" class="text-white">
                            <path d="M12 12a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H5z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings List -->
        <div class="flex flex-col mt-2 px-2">
            <?php
                $settings = [
                    ['icon' => 'monitor', 'title' => 'General', 'desc' => 'Startup and close'],
                    ['icon' => 'user', 'title' => 'Profile', 'desc' => 'Name, profile photo'],
                    ['icon' => 'key', 'title' => 'Account', 'desc' => 'Security notifications, account info'],
                    ['icon' => 'lock', 'title' => 'Privacy', 'desc' => 'Blocked contacts, disappearing messages'],
                    ['icon' => 'message-square', 'title' => 'Chats', 'desc' => 'Theme, wallpaper, chat settings'],
                    ['icon' => 'video', 'title' => 'Video & voice', 'desc' => 'Camera, microphone & speakers'],
                    ['icon' => 'bell', 'title' => 'Notifications', 'desc' => 'Messages, groups, sounds'],
                    ['icon' => 'keyboard', 'title' => 'Keyboard shortcuts', 'desc' => 'Quick actions'],
                    ['icon' => 'help-circle', 'title' => 'Help and feedback', 'desc' => 'Help centre, contact us, privacy policy'],
                ];
            ?>

            <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div
                    class="flex items-center px-4 py-3.5 hover:bg-[#202c33] rounded-lg cursor-pointer group transition-all"
                    onclick="<?php echo e($item['title'] == 'Profile' ? 'toggleEditProfile()' : ($item['title'] == 'General' ? 'toggleGeneralSettings()' : ($item['title'] == 'Account' ? 'toggleAccountSettings()' : ($item['title'] == 'Privacy' ? 'togglePrivacySettings()' : ($item['title'] == 'Chats' ? 'toggleChatSettings()' : ($item['title'] == 'Video & voice' ? 'toggleVideoVoiceSettings()' : ($item['title'] == 'Notifications' ? 'toggleNotificationsSettings()' : ($item['title'] == 'Keyboard shortcuts' ? 'openKeyboardShortcutsModal()' : ($item['title'] == 'Help and feedback' ? 'toggleHelpFeedbackSettings()' : ''))))))))); ?>">
                    <div class="w-10 text-[#8696a0] group-hover:text-[#00a884] transition-colors shrink-0">
                        <?php if($item['icon'] == 'monitor'): ?>
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                <line x1="8" y1="21" x2="16" y2="21"></line>
                                <line x1="12" y1="17" x2="12" y2="21"></line>
                            </svg>
                        <?php elseif($item['icon'] == 'user'): ?>
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        <?php elseif($item['icon'] == 'key'): ?>
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <path
                                    d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3L15.5 7.5z">
                                </path>
                            </svg>
                        <?php elseif($item['icon'] == 'lock'): ?>
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        <?php elseif($item['icon'] == 'message-square'): ?>
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                        <?php elseif($item['icon'] == 'video'): ?>
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <path d="M23 7l-7 5 7 5V7z"></path>
                                <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                            </svg>
                        <?php elseif($item['icon'] == 'bell'): ?>
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                        <?php elseif($item['icon'] == 'keyboard'): ?>
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <rect x="2" y="4" width="20" height="16" rx="2" ry="2"></rect>
                                <line x1="6" y1="8" x2="6" y2="8"></line>
                                <line x1="10" y1="8" x2="10" y2="8"></line>
                                <line x1="14" y1="8" x2="14" y2="8"></line>
                                <line x1="18" y1="8" x2="18" y2="8"></line>
                                <line x1="6" y1="12" x2="6" y2="12"></line>
                                <line x1="10" y1="12" x2="10" y2="12"></line>
                                <line x1="14" y1="12" x2="14" y2="12"></line>
                                <line x1="18" y1="12" x2="18" y2="12"></line>
                                <line x1="7" y1="16" x2="17" y2="16"></line>
                            </svg>
                        <?php elseif($item['icon'] == 'help-circle'): ?>
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                        <?php endif; ?>
                    </div>
                    <div class="flex-1 ml-3">
                        <h4 class="text-[#e9edef] text-[16px] font-normal leading-tight"><?php echo e($item['title']); ?></h4>
                        <p class="text-[#8696a0] text-[13px] mt-0.5"><?php echo e($item['desc']); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <!-- Log out -->
            <div onclick="window.openLogoutModal()"
                class="flex items-center px-4 py-4 hover:bg-[#202c33] rounded-lg cursor-pointer group transition-all mt-4 mb-10">
                <div class="w-10 text-[#f15c5c] shrink-0">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor"
                        stroke-width="1.5">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                </div>
                <div class="flex-1 ml-3">
                    <h4 class="text-[#f15c5c] text-[16px] font-medium">Log out</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.toggleSettings = function() {
        const panel = document.getElementById('settings_panel');
        const sidebar = document.getElementById('user_sidebar_container');
        const shortcuts = document.getElementById('settings_shortcuts_view');
        const profile = document.getElementById('profile_details_view');
        const chatColumn = document.getElementById('main_chat_column');

        if (panel.classList.contains('hidden')) {
            panel.classList.remove('hidden');
            panel.classList.add('flex');
            if (sidebar) {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('sm:flex');
            }
            if (shortcuts) {
                shortcuts.classList.remove('hidden');
                shortcuts.classList.add('flex');
            }
            if (chatColumn) {
                chatColumn.classList.add('hidden');
                chatColumn.classList.remove('flex');
            }
            document.getElementById('nav_chats')?.classList.remove('active');
            document.getElementById('nav_profile')?.classList.add('active');
        } else {
            panel.classList.add('hidden');
            panel.classList.remove('flex');
            if (sidebar) {
                sidebar.classList.remove('hidden');
                sidebar.classList.add('sm:flex');
            }
            if (shortcuts) {
                shortcuts.classList.add('hidden');
                shortcuts.classList.remove('flex');
            }
            if (chatColumn) {
                chatColumn.classList.remove('hidden');
                chatColumn.classList.add('flex');
            }
            document.getElementById('nav_chats')?.classList.add('active');
            document.getElementById('nav_profile')?.classList.remove('active');
        }
    }
</script>
<?php /**PATH D:\xampp\htdocs\laravel\chat_app\resources\views/chat/settings/profile_settings.blade.php ENDPATH**/ ?>