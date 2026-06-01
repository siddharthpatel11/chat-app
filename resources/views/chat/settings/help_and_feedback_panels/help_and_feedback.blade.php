<div id="help_feedback_settings_panel" class="hidden flex-col w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="toggleHelpFeedbackSettings()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Help and feedback</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] py-2">
        <div class="flex flex-col gap-0 border-b border-[#313d45] mx-4 mb-4 pb-2 mt-2">
            <!-- Help Centre -->
            <div class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4" onclick="window.open('https://faq.whatsapp.com', '_blank')">
                <div class="w-12 shrink-0 flex justify-start text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">Help Centre</span>
                    <span class="text-[#8696a0] text-[14px] mt-1">Frequently asked questions</span>
                </div>
            </div>

            <!-- Contact us -->
            <div class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4">
                <div class="w-12 shrink-0 flex justify-start text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        <path d="M9 9h6M9 13h4"></path>
                    </svg>
                </div>
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">Contact us</span>
                    <span class="text-[#8696a0] text-[14px] mt-1">Chat with support to get answers</span>
                </div>
            </div>

            <!-- Send feedback -->
            <div class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4">
                <div class="w-12 shrink-0 flex justify-start text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"></path>
                        <circle cx="12" cy="12" r="6"></circle>
                    </svg>
                </div>
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">Send feedback</span>
                    <span class="text-[#8696a0] text-[14px] mt-1">Technical issues, suggestions</span>
                </div>
            </div>
            
            <!-- Rate the app -->
            <div class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4">
                <div class="w-12 shrink-0 flex justify-start text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        <polygon points="12 8 13.5 10.5 16.5 11 14 13 14.5 16 12 14.5 9.5 16 10 13 7.5 11 10.5 10.5"></polygon>
                    </svg>
                </div>
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">Rate the app</span>
                </div>
            </div>

            <!-- Terms and Privacy Policy -->
            <div class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4">
                <div class="w-12 shrink-0 flex justify-start text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                </div>
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">Terms and Privacy Policy</span>
                </div>
            </div>

            <!-- Channels reports -->
            <div class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4">
                <div class="w-12 shrink-0 flex justify-start text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                </div>
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">Channels reports</span>
                </div>
            </div>
        </div>
        
        <div class="text-center text-[#8696a0] text-[14px] mt-4 mb-8">
            Version 2.3000.1040367347.261600
        </div>
    </div>
</div>

<script>
    window.toggleHelpFeedbackSettings = function() {
        const helpPanel = document.getElementById('help_feedback_settings_panel');
        const settingsPanel = document.getElementById('settings_panel');

        if (helpPanel.classList.contains('hidden')) {
            helpPanel.classList.remove('hidden');
            helpPanel.classList.add('flex');
            if (settingsPanel) settingsPanel.classList.add('hidden');
        } else {
            helpPanel.classList.add('hidden');
            helpPanel.classList.remove('flex');
            if (settingsPanel) settingsPanel.classList.remove('hidden');
        }
    }
</script>
