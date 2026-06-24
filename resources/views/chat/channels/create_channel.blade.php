<!-- Create Channel Panel -->
<div id="create_channel_panel" class="hidden h-full flex flex-col bg-[#111b21] w-full sm:w-[30%] sm:min-w-[300px] border-r border-[#313d45] z-[60] absolute top-0 left-0 sm:left-[60px] transition-transform duration-300 transform -translate-x-full">
    
    <!-- Header -->
    <div class="h-[60px] bg-[#111b21] shrink-0 flex items-center px-4 gap-6 text-[#e9edef] border-b border-[#313d45] z-10">
        <button onclick="window.closeCreateChannelModal()" class="hover:bg-white/10 p-2 rounded-full transition-colors focus:outline-none">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M20 11H7.8l5.6-5.6L12 4l-8 8 8 8 1.4-1.4L7.8 13H20v-2z"></path>
            </svg>
        </button>
        <h1 class="text-[19px] font-medium pb-0.5">New channel</h1>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar p-6 flex flex-col items-center relative">
        
        <div class="w-[160px] h-[160px] rounded-full bg-[#202c33] flex flex-col items-center justify-center mb-10 relative group cursor-pointer overflow-hidden border border-[#313d45]" onclick="window.toggleChannelAvatarMenu(event)">
            <img id="new_channel_avatar_preview" src="" class="hidden w-full h-full object-cover">
            <div id="new_channel_avatar_placeholder" class="flex flex-col items-center gap-2 text-[#8696a0] transition-colors relative z-10">
                <svg viewBox="0 0 24 24" width="36" height="36" fill="currentColor">
                    <path d="M21.2 7.7l-2.2-2.2c-.4-.4-1.1-.5-1.5-.1l-1.6 1.6-1.6-1.6c-.4-.4-1.1-.5-1.5-.1L11.2 7H3v14h18V7.7zM7.5 18C6.1 18 5 16.9 5 15.5S6.1 13 7.5 13 10 14.1 10 15.5 8.9 18 7.5 18zm5.5 0c-1.4 0-2.5-1.1-2.5-2.5s1.1-2.5 2.5-2.5 2.5 1.1 2.5 2.5-1.1 2.5-2.5 2.5z"></path>
                </svg>
                <span class="text-[13px] text-center px-4 uppercase leading-tight font-medium">Add channel<br>icon</span>
            </div>
            <!-- Overlay on hover -->
            <div class="absolute inset-0 bg-black/40 hidden flex-col items-center justify-center group-hover:flex z-20">
                <svg viewBox="0 0 24 24" width="28" height="28" fill="white" class="mb-2">
                    <path d="M21.2 7.7l-2.2-2.2c-.4-.4-1.1-.5-1.5-.1l-1.6 1.6-1.6-1.6c-.4-.4-1.1-.5-1.5-.1L11.2 7H3v14h18V7.7zM7.5 18C6.1 18 5 16.9 5 15.5S6.1 13 7.5 13 10 14.1 10 15.5 8.9 18 7.5 18z"></path>
                </svg>
                <span class="text-white text-[11px] uppercase tracking-wide">Change</span>
            </div>
            <input type="file" id="new_channel_avatar_input" class="hidden" accept="image/*" onchange="window.previewChannelAvatar(this)">
        </div>

        <!-- Popover menu for avatar -->
        <div id="channel_avatar_menu" class="hidden absolute top-[180px] left-[50%] bg-[#233138] rounded-xl shadow-2xl py-2 w-48 z-[100] border border-[#313d45]">
            <button onclick="document.getElementById('new_channel_avatar_input').click(); window.toggleChannelAvatarMenu(event)" class="w-full flex items-center gap-3 px-4 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-[14px]">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                Take photo
            </button>
            <button onclick="document.getElementById('new_channel_avatar_input').click(); window.toggleChannelAvatarMenu(event)" class="w-full flex items-center gap-3 px-4 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-[14px]">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M21.2 7.7l-2.2-2.2c-.4-.4-1.1-.5-1.5-.1l-1.6 1.6-1.6-1.6c-.4-.4-1.1-.5-1.5-.1L11.2 7H3v14h18V7.7z"></path></svg>
                Upload photo
            </button>
            <button onclick="alert('Emoji & sticker support coming soon!'); window.toggleChannelAvatarMenu(event)" class="w-full flex items-center gap-3 px-4 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-[14px]">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
                Emoji & sticker
            </button>
        </div>

        <div class="w-full flex flex-col gap-6">
            <div class="border-b-2 border-[#8696a0] focus-within:border-[#00a884] transition-colors flex items-center pb-1">
                <input type="text" id="new_channel_name" placeholder="Channel name" class="flex-1 bg-transparent border-none text-[#e9edef] text-[15px] px-0 py-1 focus:ring-0 placeholder-[#8696a0]">
                <button class="text-[#8696a0] hover:text-[#e9edef] p-1"><svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg></button>
            </div>

            <div class="bg-[#202c33] rounded-lg p-3 relative flex flex-col border-b-2 border-transparent focus-within:border-[#00a884] transition-colors shadow-sm">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-[#8696a0] text-[12px]">Channel description</span>
                </div>
                <div class="flex items-start">
                    <textarea id="new_channel_desc" placeholder="Describe your channel. Include information to help people understand what your channel is about." class="flex-1 bg-transparent border-none text-[#e9edef] text-[15px] px-0 py-0 min-h-[80px] focus:ring-0 placeholder-[#8696a0] resize-none leading-relaxed" maxlength="2048"></textarea>
                    <button class="text-[#8696a0] hover:text-[#e9edef] p-1 mt-1 ml-2 shrink-0"><svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Action -->
    <div class="p-6 flex justify-center bg-[#111b21]">
        <button id="btn_create_channel_submit" onclick="window.submitCreateChannel()" class="bg-[#2a3942] text-[#8696a0] font-medium text-[15px] px-6 py-2.5 rounded-full transition-all cursor-not-allowed">
            Create channel
        </button>
    </div>
</div>

<script>
    window.showCreateChannelModal = function() {
        const panel = document.getElementById('create_channel_panel');
        panel.classList.remove('hidden');
        // Force reflow
        void panel.offsetWidth;
        panel.classList.remove('-translate-x-full');
        panel.classList.add('translate-x-0');
        
        // Reset fields
        document.getElementById('new_channel_name').value = '';
        document.getElementById('new_channel_desc').value = '';
        document.getElementById('new_channel_avatar_preview').src = '';
        document.getElementById('new_channel_avatar_preview').classList.add('hidden');
        document.getElementById('new_channel_avatar_placeholder').classList.remove('hidden');
        document.getElementById('new_channel_avatar_input').value = '';
        
        window.validateChannelForm();
    };

    window.closeCreateChannelModal = function() {
        const panel = document.getElementById('create_channel_panel');
        panel.classList.remove('translate-x-0');
        panel.classList.add('-translate-x-full');
        setTimeout(() => {
            panel.classList.add('hidden');
        }, 300);
    };

    window.previewChannelAvatar = function(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('new_channel_avatar_preview');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                document.getElementById('new_channel_avatar_placeholder').classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    };

    window.toggleChannelAvatarMenu = function(e) {
        if(e) e.stopPropagation();
        const menu = document.getElementById('channel_avatar_menu');
        menu.classList.toggle('hidden');
    };

    document.addEventListener('click', function(e) {
        const menu = document.getElementById('channel_avatar_menu');
        if (menu && !menu.classList.contains('hidden') && !e.target.closest('#channel_avatar_menu') && !e.target.closest('.group')) {
            menu.classList.add('hidden');
        }
    });

    window.validateChannelForm = function() {
        const name = document.getElementById('new_channel_name').value.trim();
        const btn = document.getElementById('btn_create_channel_submit');
        if (name.length > 0) {
            btn.classList.remove('bg-[#2a3942]', 'text-[#8696a0]', 'cursor-not-allowed');
            btn.classList.add('bg-[#00a884]', 'text-[#111b21]', 'hover:bg-[#008f72]');
        } else {
            btn.classList.add('bg-[#2a3942]', 'text-[#8696a0]', 'cursor-not-allowed');
            btn.classList.remove('bg-[#00a884]', 'text-[#111b21]', 'hover:bg-[#008f72]');
        }
    };

    document.getElementById('new_channel_name').addEventListener('input', window.validateChannelForm);
</script>

<!-- Create Channel Intro Modal -->
<div id="create_channel_intro_modal" class="hidden fixed inset-0 z-[1000] flex items-center justify-center bg-black/60 backdrop-blur-sm transition-all duration-300 opacity-0">
    <div class="bg-[#233138] w-[90%] max-w-[480px] rounded-[24px] p-8 shadow-2xl transform scale-95 transition-all duration-300 opacity-0 flex flex-col" id="create_channel_intro_modal_content">
        <div class="flex justify-center mb-6">
            <svg viewBox="0 0 24 24" width="80" height="80" fill="#25D366">
                <path d="M12 2C6.48 2 2 6.03 2 11c0 1.98.71 3.81 1.91 5.25L2.5 21.5l5.36-1.57C9.17 20.61 10.55 21 12 21c5.52 0 10-4.03 10-9s-4.48-9-10-9z"/>
                <path d="M7 11a5 5 0 0110 0" fill="none" stroke="#233138" stroke-width="2"/>
                <circle cx="12" cy="11" r="2" fill="#233138"/>
            </svg>
        </div>
        <h2 class="text-white text-[22px] font-medium text-center mb-8">Create a channel to reach unlimited followers</h2>
        
        <div class="flex flex-col gap-6 mb-10">
            <div class="flex items-start gap-4">
                <div class="text-[#00a884] shrink-0 mt-1">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                </div>
                <div>
                    <h3 class="text-[#e9edef] text-[15px] font-medium mb-1">Anyone can discover your channel</h3>
                    <p class="text-[#8696a0] text-[14px]">Channels are public, so anyone can find them and see 30 days of history.</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div class="text-[#00a884] shrink-0 mt-1">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.28 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/></svg>
                </div>
                <div>
                    <h3 class="text-[#e9edef] text-[15px] font-medium mb-1">People see your channel, not you</h3>
                    <p class="text-[#8696a0] text-[14px]">Followers can't see your phone number, profile picture or name, but other admins can.</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div class="text-[#00a884] shrink-0 mt-1">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>
                </div>
                <div>
                    <h3 class="text-[#e9edef] text-[15px] font-medium mb-1">You're responsible for your channel</h3>
                    <p class="text-[#8696a0] text-[14px]">Your channel needs to follow our <a href="#" class="text-[#00a884] hover:underline">guidelines</a> and is reviewed against them.</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4 items-center">
            <button onclick="window.closeCreateChannelIntroModal()" class="text-[#00a884] font-medium text-[14px] hover:bg-white/5 px-4 py-2 rounded-full transition-colors">Close</button>
            <button onclick="window.continueToCreateChannel()" class="bg-[#25D366] text-[#111b21] font-medium text-[14px] px-6 py-2.5 rounded-full hover:bg-[#20bd5a] transition-all active:scale-95 shadow-sm">Continue</button>
        </div>
    </div>
</div>
