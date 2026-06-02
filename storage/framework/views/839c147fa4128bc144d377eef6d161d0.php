<div id="settings_shortcuts_view" class="hidden flex-col items-center justify-center flex-1 bg-[#0b141a] transition-all duration-300">
    <div class="flex gap-8">
        <!-- Send Document -->
        <div class="flex flex-col items-center gap-3 group cursor-pointer">
            <div class="w-[120px] h-[120px] bg-[#2a3942] rounded-3xl flex items-center justify-center text-[#8696a0] group-hover:bg-[#384b57] transition-all transform group-hover:scale-105 shadow-lg">
                <svg viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
            </div>
            <span class="text-[#8696a0] text-sm font-medium group-hover:text-[#e9edef] transition-colors">Send document</span>
        </div>

        <!-- Add Contact -->
        <div class="flex flex-col items-center gap-3 group cursor-pointer">
            <div class="w-[120px] h-[120px] bg-[#2a3942] rounded-3xl flex items-center justify-center text-[#8696a0] group-hover:bg-[#384b57] transition-all transform group-hover:scale-105 shadow-lg">
                <svg viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <line x1="20" y1="8" x2="20" y2="14"></line>
                    <line x1="23" y1="11" x2="17" y2="11"></line>
                </svg>
            </div>
            <span class="text-[#8696a0] text-sm font-medium group-hover:text-[#e9edef] transition-colors">Add contact</span>
        </div>

        <!-- Ask Meta AI -->
        <div class="flex flex-col items-center gap-3 group cursor-pointer">
            <div class="w-[120px] h-[120px] bg-[#2a3942] rounded-3xl flex items-center justify-center group-hover:bg-[#384b57] transition-all transform group-hover:scale-105 shadow-lg overflow-hidden">
                <svg viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="url(#ai_gradient)" stroke-width="2">
                    <defs>
                        <linearGradient id="ai_gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#a855f7;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#ec4899;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    <path d="M12 2v2m0 16v2m8-10h2m-20 0h2m15.364-6.364l-1.414 1.414m-11.314 11.314l-1.414 1.414m0-14.142l1.414 1.414m11.314 11.314l1.414-1.414"></path>
                    <circle cx="12" cy="12" r="4"></circle>
                </svg>
            </div>
            <span class="text-[#8696a0] text-sm font-medium group-hover:text-[#e9edef] transition-colors">Ask Meta AI</span>
        </div>
    </div>
</div>
<?php /**PATH D:\xampp\htdocs\laravel\chat_app\resources\views/chat/settings_shortcuts.blade.php ENDPATH**/ ?>