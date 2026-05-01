<div id="text_status_overlay" class="hidden fixed inset-0 z-[200] transition-all duration-300" style="background-color: #a67c6d;">
    <!-- Header -->
    <div class="flex items-center justify-between p-6">
        <button onclick="window.closeTextStatus()" class="text-white/80 hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor">
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path>
            </svg>
        </button>

        <div class="flex items-center gap-6 relative">
            <!-- Emoji -->
            <button id="status_emoji_btn" type="button" class="text-white/80 hover:text-white transition-all active:scale-90">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm2.5-9.5c.828 0 1.5-.672 1.5-1.5s-.672-1.5-1.5-1.5-1.5.672-1.5 1.5.672 1.5 1.5 1.5zm-5 0c.828 0 1.5-.672 1.5-1.5S8.828 8 8 8s-1.5.672-1.5 1.5.672 1.5 1.5 1.5zm2.5 6c2.511 0 4.67-1.516 5.568-3.693h-11.136c.898 2.177 3.057 3.693 5.568 3.693z"></path>
                </svg>
            </button>

            <!-- Emoji Picker -->
            <div id="status_emoji_picker" style="display: none;" class="fixed top-16 right-6 w-[350px] bg-[#232d36] rounded-[16px] shadow-2xl z-[1000] overflow-hidden animate-in fade-in slide-in-from-top-4 duration-300 border border-white/5 flex-col">
                <!-- Categories -->
                <div class="flex items-center justify-between px-4 py-3 border-b border-white/5 bg-[#1f272e]">
                    <button class="text-[#00a884] border-b-2 border-[#00a884] pb-1"><svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M12 20c4.42 0 8-3.58 8-8s-3.58-8-8-8-8 3.58-8 8 3.58 8 8 8zm0-18c5.52 0 10 4.48 10 10s-4.48 10-10 10S2 17.52 2 12 6.48 2 12 2zM11 12h2v5h-2v-5zm0-4h2v2h-2V8z"></path></svg></button>
                    <button class="text-[#8696a0] hover:text-[#e9edef]"><svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"></path></svg></button>
                    <button class="text-[#8696a0] hover:text-[#e9edef]"><svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M12 7c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zm0-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"></path></svg></button>
                    <button class="text-[#8696a0] hover:text-[#e9edef]"><svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"></path></svg></button>
                    <button class="text-[#8696a0] hover:text-[#e9edef]"><svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"></path></svg></button>
                </div>

                <!-- Search Bar -->
                <div class="px-4 py-3">
                    <div class="relative">
                        <input type="text" placeholder="Search emoji" class="w-full bg-[#2a3942] text-[#e9edef] text-[14px] rounded-full py-2 pl-10 pr-4 border border-[#00a884] focus:ring-0">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor" class="absolute left-3 top-1/2 -translate-y-1/2 text-[#8696a0]">
                            <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Emoji Grid -->
                <div class="h-[250px] overflow-y-auto px-4 pb-4 custom-scrollbar">
                    <h4 class="text-[#8696a0] text-[13px] font-medium py-2">Recent</h4>
                    <div class="grid grid-cols-8 gap-1 mb-4">
                        <button onclick="window.insertEmoji('😊')" class="text-[24px] p-1 hover:bg-white/5 rounded">😊</button>
                    </div>

                    <h4 class="text-[#8696a0] text-[13px] font-medium py-2">Smileys & People</h4>
                    <div class="grid grid-cols-8 gap-1">
                        @php
                            $emojis = ['😀', '😃', '😄', '😁', '😆', '😅', '😂', '🤣', '😊', '😇', '🙂', '🙃', '😉', '😌', '😍', '🥰', '😘', '😗', '😙', '😚', '😋', '😛', '😝', '😜', '🤪', '🤨', '🧐', '🤓', '😎', '🥸', '🤩', '🥳', '😏', '😒', '😞', '😔', '😟', '😕', '🙁', '☹️', '😣', '😖', '😫', '😩', '🥺', '😢', '😭', '😤'];
                        @endphp
                        @foreach($emojis as $emoji)
                            <button onclick="window.insertEmoji('{{ $emoji }}')" class="text-[24px] p-1 hover:bg-white/5 rounded transition-all active:scale-90">{{ $emoji }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Font -->
            <button onclick="window.changeStatusFont()" class="text-white/80 hover:text-white transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M9.93 13.5h4.14L12 7.98zM20 2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM15.95 18.5l-1.05-2.8h-5.8l-1.05 2.8H5.4L10.8 5h2.4l5.4 13.5h-2.65z"></path>
                </svg>
            </button>
            <!-- Background Color -->
            <button onclick="window.changeStatusBg()" class="text-white/80 hover:text-white transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9c.83 0 1.5-.67 1.5-1.5 0-.39-.15-.74-.39-1.01-.23-.26-.38-.61-.38-.99 0-.83.67-1.5 1.5-1.5H16c2.76 0 5-2.24 5-5 0-4.42-4.03-8-9-8zm-5.5 9c-.83 0-1.5-.67-1.5-1.5S5.67 9 6.5 9 8 9.67 8 10.5 7.33 12 6.5 12zm3-4C8.67 8 8 7.33 8 6.5S8.67 5 9.5 5 11 5.67 11 6.5 10.33 8 9.5 8zm5 0c-.83 0-1.5-.67-1.5-1.5S13.67 5 14.5 5s1.5.67 1.5 1.5S15.33 8 14.5 8zm3 4c-.83 0-1.5-.67-1.5-1.5S16.67 9 17.5 9s1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Center Content -->
    <div class="flex-1 flex items-center justify-center px-10">
        <textarea id="text_status_input" 
            placeholder="Type a status"
            class="w-full bg-transparent border-none text-white text-[42px] text-center placeholder-white/50 focus:ring-0 resize-none h-auto overflow-hidden font-sans"
            rows="1"
            oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"></textarea>
    </div>

    <!-- Footer -->
    <div class="flex items-end justify-between p-6">
        <!-- Privacy Pill -->
        <div onclick="window.openPrivacyModal()" class="bg-black/20 backdrop-blur-md border border-white/10 rounded-full px-4 py-2 flex items-center gap-2 text-white/90 text-[13px] cursor-pointer hover:bg-black/30 transition-all">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" class="opacity-70">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h2v2h-2v-2zm0-8h2v6h-2V9z"></path>
            </svg>
            <span>Status (7 included)</span>
        </div>

        <!-- Send Button -->
        <button onclick="window.postTextStatus()" class="w-14 h-14 bg-[#00a884] rounded-full flex items-center justify-center text-white shadow-lg hover:bg-[#06cf9c] active:scale-95 transition-all">
            <svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor" class="ml-1">
                <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path>
            </svg>
        </button>
    </div>

    <!-- Privacy Modal Overlay -->
    <div id="privacy_modal_overlay" class="hidden fixed inset-0 z-[300] bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-[#1c1c1c] w-full max-w-[400px] rounded-[28px] overflow-hidden shadow-2xl animate-in zoom-in duration-300">
            <!-- Modal Header -->
            <div class="flex items-center gap-6 p-6 pb-2">
                <button onclick="window.closePrivacyModal()" class="text-[#8696a0] hover:text-[#e9edef] transition-colors">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path>
                    </svg>
                </button>
                <h2 class="text-[#e9edef] text-[20px] font-medium">Status privacy</h2>
            </div>

            <!-- Modal Content -->
            <div class="p-6 pt-4">
                <p class="text-[#8696a0] text-[14px] mb-8 font-medium">Who can see my status updates on WhatsApp</p>

                <!-- Privacy Options -->
                <div class="flex flex-col gap-8">
                    <!-- Option 1 -->
                    <label class="flex items-start gap-5 cursor-pointer group">
                        <div class="relative flex items-center justify-center mt-1">
                            <input type="radio" name="status_privacy" class="peer hidden">
                            <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] group-hover:border-[#e9edef] transition-all peer-checked:border-[#00a884] peer-checked:border-[6px]"></div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[#e9edef] text-[16px]">My contacts</span>
                            <span class="text-[#8696a0] text-[13px] mt-0.5">Share with all of your contacts</span>
                        </div>
                    </label>

                    <!-- Option 2 -->
                    <label class="flex items-start gap-5 cursor-pointer group">
                        <div class="relative flex items-center justify-center mt-1">
                            <input type="radio" name="status_privacy" class="peer hidden">
                            <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] group-hover:border-[#e9edef] transition-all peer-checked:border-[#00a884] peer-checked:border-[6px]"></div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[#e9edef] text-[16px]">My contacts except...</span>
                            <span class="text-[#8696a0] text-[13px] mt-0.5">Share with your contacts except people you select</span>
                        </div>
                    </label>

                    <!-- Option 3 -->
                    <label class="flex items-start gap-5 cursor-pointer group">
                        <div class="relative flex items-center justify-center mt-1">
                            <input type="radio" name="status_privacy" checked class="peer hidden">
                            <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] group-hover:border-[#e9edef] transition-all peer-checked:border-[#00a884] peer-checked:border-[6px]"></div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[#e9edef] text-[16px]">Only share with...</span>
                            <span class="text-[#8696a0] text-[13px] mt-0.5">7 contacts included</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Modal Footer (Optional but good for spacing) -->
            <div class="h-6"></div>
        </div>
    </div>
</div>

<script>
    const statusColors = ['#a67c6d', '#6d8ba6', '#a66d8b', '#6da68b', '#8b6da6', '#a6a66d', '#667781', '#00a884'];
    let currentColorIndex = 0;

    const statusFonts = ['font-sans', 'font-serif', 'font-mono'];
    let currentFontIndex = 0;

    window.openTextStatus = function() {
        const overlay = document.getElementById('text_status_overlay');
        overlay.classList.remove('hidden');
        overlay.classList.add('flex', 'flex-col'); // Add flex logic here
        document.getElementById('text_status_input').focus();
    };

    window.closeTextStatus = function() {
        const overlay = document.getElementById('text_status_overlay');
        overlay.classList.add('hidden');
        overlay.classList.remove('flex', 'flex-col');
    };

    window.changeStatusBg = function() {
        currentColorIndex = (currentColorIndex + 1) % statusColors.length;
        document.getElementById('text_status_overlay').style.backgroundColor = statusColors[currentColorIndex];
    };

    window.changeStatusFont = function() {
        const input = document.getElementById('text_status_input');
        input.classList.remove(...statusFonts);
        currentFontIndex = (currentFontIndex + 1) % statusFonts.length;
        input.classList.add(statusFonts[currentFontIndex]);
    };

    window.openPrivacyModal = function() {
        document.getElementById('privacy_modal_overlay').classList.remove('hidden');
    };

    window.closePrivacyModal = function() {
        document.getElementById('privacy_modal_overlay').classList.add('hidden');
    };

    // Initialize emoji picker toggle
    document.getElementById('status_emoji_btn').addEventListener('click', (e) => {
        e.stopPropagation();
        const picker = document.getElementById('status_emoji_picker');
        const isHidden = picker.style.display === 'none';
        
        // Close other potential menus
        if (window.closeAllStatusMenus) window.closeAllStatusMenus();
        
        if (isHidden) {
            picker.style.display = 'flex';
        } else {
            picker.style.display = 'none';
        }
    });

    // Close on outside click
    document.addEventListener('click', (e) => {
        const picker = document.getElementById('status_emoji_picker');
        const btn = document.getElementById('status_emoji_btn');
        if (picker && picker.style.display === 'flex') {
            if (!picker.contains(e.target) && !btn.contains(e.target)) {
                picker.style.display = 'none';
            }
        }
    });

    window.insertEmoji = function(emoji) {
        const input = document.getElementById('text_status_input');
        input.value += emoji;
        input.focus();
        input.dispatchEvent(new Event('input')); // Trigger auto-resize
    };

    window.postTextStatus = async function() {
        const text = document.getElementById('text_status_input').value.trim();
        if (!text) return;

        const statusData = {
            userId: window.myUserId,
            userName: window.myUserName,
            userAvatar: window.myUserAvatar,
            text: text,
            bgColor: statusColors[currentColorIndex],
            font: statusFonts[currentFontIndex],
            type: 'text',
            timestamp: window.serverTimestamp(),
            viewers: {}
        };

        try {
            const statusRef = window.ref(window.db, `statuses/${window.myUserId}`);
            await window.push(statusRef, statusData);
            
            // Reset and close
            document.getElementById('text_status_input').value = '';
            document.getElementById('text_status_input').style.height = 'auto';
            window.closeTextStatus();
            if (window.showToast) window.showToast('Status Updated', 'Your status has been posted successfully.');
        } catch (e) {
            console.error('Post status error:', e);
            alert('Failed to post status.');
        }
    };

    // Close modal on outside click
    document.getElementById('privacy_modal_overlay').addEventListener('click', (e) => {
        if (e.target.id === 'privacy_modal_overlay') window.closePrivacyModal();
    });
</script>
