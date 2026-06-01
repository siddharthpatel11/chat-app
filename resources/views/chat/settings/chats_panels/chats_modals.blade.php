<!-- Theme Modal -->
<div id="chat_theme_modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/50 opacity-0 transition-opacity duration-200">
    <div class="bg-[#233138] w-[400px] rounded-xl shadow-2xl flex flex-col overflow-hidden transform scale-95 transition-transform duration-200" id="chat_theme_modal_content">
        <div class="p-6 pb-2">
            <h2 class="text-[#e9edef] text-[16px] font-medium mb-4">Theme</h2>
            
            <div class="flex flex-col gap-4">
                <label class="flex items-center gap-4 cursor-pointer group">
                    <div class="relative flex items-center justify-center">
                        <input type="radio" name="chat_theme_radio" value="Light" class="peer sr-only">
                        <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] transition-colors"></div>
                        <div class="absolute w-2.5 h-2.5 rounded-full bg-[#00a884] opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <span class="text-[#e9edef] text-[15px] group-hover:text-white transition-colors">Light</span>
                </label>

                <label class="flex items-center gap-4 cursor-pointer group">
                    <div class="relative flex items-center justify-center">
                        <input type="radio" name="chat_theme_radio" value="Dark" class="peer sr-only">
                        <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] transition-colors"></div>
                        <div class="absolute w-2.5 h-2.5 rounded-full bg-[#00a884] opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <span class="text-[#e9edef] text-[15px] group-hover:text-white transition-colors">Dark</span>
                </label>

                <label class="flex items-center gap-4 cursor-pointer group">
                    <div class="relative flex items-center justify-center">
                        <input type="radio" name="chat_theme_radio" value="System default" class="peer sr-only" checked>
                        <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] transition-colors"></div>
                        <div class="absolute w-2.5 h-2.5 rounded-full bg-[#00a884] opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <span class="text-[#e9edef] text-[15px] group-hover:text-white transition-colors">System default</span>
                </label>
            </div>
        </div>
        
        <div class="p-6 pt-4 flex justify-end gap-3 mt-4">
            <button onclick="closeChatThemeModal(false)" class="px-4 py-2 text-[#00a884] hover:bg-[#111b21] rounded-full text-[14px] font-medium transition-colors">Cancel</button>
            <button onclick="closeChatThemeModal(true)" class="px-5 py-2 bg-[#00a884] text-[#111b21] hover:bg-[#06cf9c] rounded-full text-[14px] font-medium transition-colors">OK</button>
        </div>
    </div>
</div>

<!-- Upload Quality Modal -->
<div id="chat_upload_quality_modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/50 opacity-0 transition-opacity duration-200">
    <div class="bg-[#233138] w-[450px] rounded-xl shadow-2xl flex flex-col overflow-hidden transform scale-95 transition-transform duration-200" id="chat_upload_quality_modal_content">
        <div class="p-6 pb-2">
            <h2 class="text-[#e9edef] text-[16px] font-medium mb-4">Media upload quality</h2>
            
            <div class="flex flex-col gap-5 mt-2">
                <label class="flex items-center gap-4 cursor-pointer group">
                    <div class="relative flex items-center justify-center h-full pt-1 items-start">
                        <input type="radio" name="chat_quality_radio" value="Standard quality" class="peer sr-only" checked>
                        <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] transition-colors"></div>
                        <div class="absolute w-2.5 h-2.5 rounded-full bg-[#00a884] opacity-0 peer-checked:opacity-100 transition-opacity mt-[3px]"></div>
                    </div>
                    <div class="flex flex-col flex-1">
                        <span class="text-[#e9edef] text-[15px] group-hover:text-white transition-colors">Standard quality</span>
                        <span class="text-[#8696a0] text-[13px] mt-0.5">Standard media uses less storage and are faster to send</span>
                    </div>
                </label>

                <label class="flex items-center gap-4 cursor-pointer group mt-2">
                    <div class="relative flex items-center justify-center h-full pt-1 items-start">
                        <input type="radio" name="chat_quality_radio" value="HD quality" class="peer sr-only">
                        <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] transition-colors"></div>
                        <div class="absolute w-2.5 h-2.5 rounded-full bg-[#00a884] opacity-0 peer-checked:opacity-100 transition-opacity mt-[3px]"></div>
                    </div>
                    <div class="flex flex-col flex-1">
                        <span class="text-[#e9edef] text-[15px] group-hover:text-white transition-colors">HD quality</span>
                        <span class="text-[#8696a0] text-[13px] mt-0.5">HD media is slower to send, can be 6 times larger</span>
                    </div>
                </label>
            </div>
        </div>
        
        <div class="p-6 pt-6 flex justify-end mt-4">
            <!-- No cancel button in the screenshot for this one? Wait, screenshot 4 just shows the radio buttons. It doesn't show cancel/ok buttons, but it's a modal or maybe a panel. Ah, the image for upload quality has a back arrow on the top! It is NOT a modal, it's a panel like Privacy Last Seen! -->
        </div>
    </div>
</div>

<script>
    window.openChatThemeModal = function() {
        const saved = localStorage.getItem('whatsapp_chat_theme') || 'System default';
        document.querySelectorAll('input[name="chat_theme_radio"]').forEach(r => {
            r.checked = (r.value === saved);
        });

        const modal = document.getElementById('chat_theme_modal');
        const content = document.getElementById('chat_theme_modal_content');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
        }, 10);
    }

    window.closeChatThemeModal = function(save) {
        if(save) {
            const val = document.querySelector('input[name="chat_theme_radio"]:checked')?.value || 'System default';
            localStorage.setItem('whatsapp_chat_theme', val);
            const label = document.getElementById('chat_theme_label');
            if (label) label.innerText = val;
            if (window.showToast) window.showToast('Theme Updated', `Theme set to ${val}.`);
            
            // Apply theme globally
            if (val === 'Light') {
                document.documentElement.classList.add('light-theme');
            } else if (val === 'Dark') {
                document.documentElement.classList.remove('light-theme');
            } else {
                // System default
                if (window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches) {
                    document.documentElement.classList.add('light-theme');
                } else {
                    document.documentElement.classList.remove('light-theme');
                }
            }
        }
        const modal = document.getElementById('chat_theme_modal');
        const content = document.getElementById('chat_theme_modal_content');
        modal.classList.add('opacity-0');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }
    
    // Init theme on load
    document.addEventListener('DOMContentLoaded', () => {
        const savedTheme = localStorage.getItem('whatsapp_chat_theme') || 'System default';
        if (savedTheme === 'Light') {
            document.documentElement.classList.add('light-theme');
        } else if (savedTheme === 'System default' && window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches) {
            document.documentElement.classList.add('light-theme');
        }
    });
</script>
