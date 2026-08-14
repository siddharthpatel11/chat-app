<div id="settings_shortcuts_view" class="hidden flex-col items-center justify-center flex-1 bg-[#0b141a] transition-all duration-300">
    <div class="flex gap-14 mb-8">
        <!-- Send Document -->
        <div class="flex flex-col items-center gap-4 group cursor-pointer"
            onclick="selectFile('.pdf,.doc,.docx')">
            <div
                class="w-[110px] h-[110px] rounded-[28px] bg-[#202c33] flex items-center justify-center text-[#00a884] group-hover:bg-[#2a3942] transition-all duration-300">
                <svg viewBox="0 0 24 24" width="36" height="36" fill="none"
                    stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 3h6m-6 3h6" />
                </svg>
            </div>
            <span class="text-[#8696a0] text-[13px] font-normal">Send document</span>
        </div>
        <!-- Add Contact -->
        <div class="flex flex-col items-center gap-4 group cursor-pointer"
            onclick="toggleNewContact()">
            <div
                class="w-[110px] h-[110px] rounded-[28px] bg-[#202c33] flex items-center justify-center text-[#00a884] group-hover:bg-[#2a3942] transition-all duration-300">
                <svg viewBox="0 0 24 24" width="40" height="40" fill="none"
                    stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                </svg>
            </div>
            <span class="text-[#8696a0] text-[13px] font-normal">Add contact</span>
        </div>
        <!-- Ask Meta AI -->
        <div class="flex flex-col items-center gap-4 group cursor-pointer"
            onclick="window.openMetaAiChat()">
            <div
                class="w-[110px] h-[110px] rounded-[28px] bg-[#202c33] flex items-center justify-center text-[#00a884] group-hover:bg-[#2a3942] transition-all duration-300">
                <div class="relative w-10 h-10 flex items-center justify-center">
                    <div class="absolute inset-0 border-2 border-current rounded-full opacity-40">
                    </div>
                    <div class="w-5 h-5 border-2 border-current rounded-full"></div>
                    <!-- Dots -->
                    <div
                        class="absolute -top-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 bg-current rounded-full">
                    </div>
                    <div
                        class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 bg-current rounded-full">
                    </div>
                    <div
                        class="absolute top-1/2 -left-1 -translate-y-1/2 w-1.5 h-1.5 bg-current rounded-full">
                    </div>
                    <div
                        class="absolute top-1/2 -right-1 -translate-y-1/2 w-1.5 h-1.5 bg-current rounded-full">
                    </div>
                </div>
            </div>
            <span class="text-[#8696a0] text-[13px] font-normal">Ask Meta AI</span>
        </div>
    </div>
</div>
