<div id="private_processing_panel"
    class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden absolute sm:relative z-20">
    
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="window.closePrivateProcessingPanel()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Private Processing</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21]">
        <!-- Graphic -->
        <div class="flex flex-col items-center justify-center py-10">
            <div class="relative">
                <svg viewBox="0 0 100 100" width="120" height="120">
                    <path fill="#fce5cd" d="M30 10 h40 a10 10 0 0 1 10 10 v60 a10 10 0 0 1 -10 10 h-50 a10 10 0 0 1 -10 -10 v-50 l20 -20 z" />
                    <path fill="#f5ccb0" d="M30 10 v20 h-20 z" />
                    <path fill="#313d45" d="M35 30 h30 v4 h-30 z" />
                    <path fill="#313d45" d="M35 45 h30 v4 h-30 z" />
                    <path fill="#313d45" d="M35 60 h15 v4 h-15 z" />
                    <path fill="#00a884" d="M60 40 h20 v30 h-30 v-30 h10 z" rx="5" />
                    <path fill="#25d366" d="M50 50 h40 a5 5 0 0 1 5 5 v30 a5 5 0 0 1 -5 5 h-40 a5 5 0 0 1 -5 -5 v-30 a5 5 0 0 1 5 -5 z" />
                    <path fill="none" stroke="#313d45" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" d="M60 50 v-10 a10 10 0 0 1 20 0 v10" />
                    <!-- Sparkle -->
                    <path fill="#fff" d="M70 65 l3 8 l8 3 l-8 3 l-3 8 l-3 -8 l-8 -3 l8 -3 z" />
                    <path fill="#b4e4c9" d="M85 30 l2 5 l5 2 l-5 2 l-2 5 l-2 -5 l-5 -2 l5 -2 z" />
                </svg>
            </div>
        </div>

        <div class="px-6 pb-6">
            <p class="text-[#e9edef] text-[16px] mb-2 leading-relaxed">
                These Meta AI features use Private Processing to help you get more done in WhatsApp.
            </p>
            <p class="text-[#8696a0] text-[14px] leading-relaxed">
                This technology enables Meta AI to securely process messages without Meta or WhatsApp being able to read them. 
                <a href="#" class="text-[#00a884] hover:underline">Learn more</a>
            </p>
        </div>

        <!-- Toggle Item -->
        <div class="flex items-center justify-between py-4 hover:bg-[#202c33] px-6 transition-colors group cursor-pointer" onclick="window.toggleMetaAiWebSearch()">
            <div class="flex-1 pr-4 pointer-events-none">
                <div class="text-[#e9edef] text-[16px] mb-1">Web search</div>
                <div class="text-[#8696a0] text-[14px] leading-snug">
                    Allow web search in incognito chats with Meta AI to get up-to-date information
                </div>
            </div>
            
            <div id="meta_ai_toggle_container" class="relative w-[34px] h-[20px] rounded-full border-2 border-[#8696a0] bg-transparent transition-colors duration-200 shrink-0 pointer-events-none box-border">
                <div id="meta_ai_toggle_thumb" class="absolute top-[2px] left-[2px] h-[12px] w-[12px] rounded-full bg-[#8696a0] transition-all duration-200 flex items-center justify-center">
                    <svg id="meta_ai_toggle_icon_off" class="w-2 h-2 text-[#111b21]" fill="currentColor" viewBox="0 0 24 24"><path d="M4 11h16v2H4z"/></svg>
                    <svg id="meta_ai_toggle_icon_on" class="w-2 h-2 text-[#00a884] hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"/></svg>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.togglePrivateProcessingPanel = function() {
        const chatsPanel = document.getElementById('chats_settings_panel');
        const privateProcessingPanel = document.getElementById('private_processing_panel');

        if (privateProcessingPanel) {
            chatsPanel.classList.add('hidden');
            chatsPanel.classList.remove('flex');
            
            privateProcessingPanel.classList.remove('hidden');
            privateProcessingPanel.classList.add('flex');
        }
    };

    window.closePrivateProcessingPanel = function() {
        const chatsPanel = document.getElementById('chats_settings_panel');
        const privateProcessingPanel = document.getElementById('private_processing_panel');

        if (privateProcessingPanel) {
            privateProcessingPanel.classList.add('hidden');
            privateProcessingPanel.classList.remove('flex');
            
            chatsPanel.classList.remove('hidden');
            chatsPanel.classList.add('flex');
        }
    };

    window.toggleMetaAiWebSearch = function() {
        let isEnabled = localStorage.getItem('meta_ai_web_search_' + window.myUserId);
        isEnabled = (isEnabled === '0') ? '1' : '0';
        localStorage.setItem('meta_ai_web_search_' + window.myUserId, isEnabled);
        window.updateMetaAiWebSearchUI(isEnabled);

        if (window.db && window.update && window.ref) {
            window.update(window.ref(window.db, `users/${window.myUserId}/settings/private_processing`), {
                meta_ai_web_search: isEnabled === '1'
            }).catch(err => console.error("Error saving private processing to Firebase:", err));
        }
    };

    window.updateMetaAiWebSearchUI = function(val) {
        const container = document.getElementById('meta_ai_toggle_container');
        const thumb = document.getElementById('meta_ai_toggle_thumb');
        const iconOff = document.getElementById('meta_ai_toggle_icon_off');
        const iconOn = document.getElementById('meta_ai_toggle_icon_on');
        if (!container || !thumb || !iconOff || !iconOn) return;

        if (val === '0') {
            // OFF state
            container.classList.remove('border-[#00a884]', 'bg-[#00a884]');
            container.classList.add('border-[#8696a0]', 'bg-transparent');
            thumb.classList.remove('left-[16px]', 'bg-[#111b21]');
            thumb.classList.add('left-[2px]', 'bg-[#8696a0]');
            iconOff.classList.remove('hidden');
            iconOn.classList.add('hidden');
        } else {
            // ON state
            container.classList.remove('border-[#8696a0]', 'bg-transparent');
            container.classList.add('border-[#00a884]', 'bg-[#00a884]');
            thumb.classList.remove('left-[2px]', 'bg-[#8696a0]');
            thumb.classList.add('left-[16px]', 'bg-[#111b21]');
            iconOff.classList.add('hidden');
            iconOn.classList.remove('hidden');
        }
    };

    // Initialize toggle state
    window.addEventListener('load', function() {
        if (window.myUserId) {
            // Check Firebase first if we have data, but normally we rely on localStorage as immediate cache.
            // When app loads, `index.blade.php` usually fetches user settings from Firebase and sets localStorage.
            let val = localStorage.getItem('meta_ai_web_search_' + window.myUserId);
            // Default to true (1) if not set
            if (val === null) {
                val = '1';
                localStorage.setItem('meta_ai_web_search_' + window.myUserId, val);
            }
            window.updateMetaAiWebSearchUI(val);
        }
    });
</script>
