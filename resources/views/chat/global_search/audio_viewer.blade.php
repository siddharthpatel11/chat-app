<!-- Global Search Audio Viewer (Lightbox) -->
<div id="gs_audio_viewer" class="hidden fixed inset-0 z-[2000] bg-[#0b141a] flex flex-col transition-opacity duration-300 opacity-0 pointer-events-auto">
    <!-- Header -->
    <div class="flex items-center justify-between px-4 py-3 bg-gradient-to-b from-black/60 to-transparent absolute top-0 w-full z-[2100]">
        <div class="flex items-center gap-4">
            <!-- Back Button -->
            <button onclick="window.closeGlobalSearchAudioViewer()" class="text-white hover:text-[#d1d7db] transition-colors focus:outline-none p-1 rounded-full">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
            </button>
            
            <!-- Sender Info -->
            <div class="flex flex-col">
                <div id="gs_audio_viewer_sender_name" class="text-white text-[16px] font-medium leading-tight"></div>
                <div id="gs_audio_viewer_time" class="text-white/70 text-[13px] mt-0.5"></div>
            </div>
        </div>

        <!-- Action Icons -->
        <div class="flex items-center gap-5 text-white relative">
            <!-- Status Button -->
            <button id="gs_audio_viewer_btn_status" class="hover:text-[#d1d7db] transition-colors focus:outline-none p-1 rounded-full" title="Set Status">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" stroke-dasharray="3 3"></circle>
                    <path d="M12 8v8m-4-4h8"></path>
                </svg>
            </button>
            
            <!-- Download Button -->
            <button id="gs_audio_viewer_btn_download" class="hover:text-[#d1d7db] transition-colors focus:outline-none p-1 rounded-full" title="Download">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
            </button>

            <!-- Forward Button -->
            <button id="gs_audio_viewer_btn_forward" class="hover:text-[#d1d7db] transition-colors focus:outline-none p-1 rounded-full" title="Forward">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </button>
            
            <!-- Share Button -->
            <button id="gs_audio_viewer_btn_share" class="hover:text-[#d1d7db] transition-colors focus:outline-none p-1 rounded-full" title="Share">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                </svg>
            </button>

            <!-- 3 Dots Menu Button -->
            <button onclick="window.toggleGsAudioViewerMenu(event)" class="hover:text-[#d1d7db] transition-colors focus:outline-none p-1 rounded-full" title="Menu">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M12 7a2 2 0 10-.001-3.999A2 2 0 0012 7zm0 2a2 2 0 10-.001 3.999A2 2 0 0012 9zm0 6a2 2 0 10-.001 3.999A2 2 0 0012 15z"></path>
                </svg>
            </button>
            
            <!-- Context Menu Dropdown -->
            <div id="gs_audio_viewer_dropdown_menu" class="hidden absolute top-12 right-0 bg-[#233138] border border-[#313d45] rounded-lg shadow-xl z-[2200] py-2 w-56 transition-opacity duration-150">
                <button id="gs_audio_viewer_btn_show_chat" class="w-full text-left px-4 py-3 text-[#d1d7db] hover:bg-[#182229] hover:text-white transition-colors text-[14.5px] flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg> Show in chat
                </button>
                <button id="gs_audio_viewer_btn_delete" class="w-full text-left px-4 py-3 text-[#f15c6d] hover:bg-[#182229] transition-colors text-[14.5px] flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Delete
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content Container (WhatsApp Voice Note Card Interface) -->
    <div class="flex-1 flex items-center justify-center p-6 relative">
        <div class="bg-[#1f2c34] rounded-2xl p-8 border border-white/5 shadow-2xl flex flex-col items-center gap-6 w-full max-w-[420px] transition-all">
            <!-- Large Contact Avatar with microphone icon badge -->
            <div class="relative w-32 h-32 rounded-full overflow-hidden border border-white/10 shadow-lg bg-[#2a3942]">
                <img id="gs_audio_viewer_avatar" src="https://ui-avatars.com/api/?name=Contact&background=2a3942&color=fff" class="w-full h-full object-cover">
                <!-- Microphone Badge -->
                <div class="absolute bottom-1.5 right-1.5 w-8 h-8 rounded-full bg-[#111b21] flex items-center justify-center text-[#53bdeb] shadow-md border border-[#111b21]">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                        <path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3zm5.3-3c0 3-2.54 5.1-5.3 5.1S6.7 14 6.7 11H5c0 3.41 2.72 6.23 6 6.72V21h2v-3.28c3.28-.48 6-3.3 6-6.72h-1.7z"/>
                    </svg>
                </div>
            </div>

            <!-- Waveform Slider -->
            <div class="w-full flex items-center gap-4">
                <!-- Play Button -->
                <button onclick="window.toggleGsAudioViewerPlay()" id="gs_audio_viewer_play_btn" class="w-14 h-14 rounded-full bg-[#53bdeb] hover:bg-[#53bdeb]/90 text-[#111b21] flex items-center justify-center transition-all shadow-md focus:outline-none hover:scale-105 active:scale-95 shrink-0">
                    <svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor" id="gs_audio_viewer_play_svg" class="ml-1">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                    <svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor" id="gs_audio_viewer_pause_svg" class="hidden">
                        <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                    </svg>
                </button>

                <!-- Slider with Waveform background -->
                <div class="flex-1 relative flex items-center h-8">
                    <!-- Waveform background bars -->
                    <div id="gs_audio_viewer_waveform_bars" class="absolute inset-0 flex items-center justify-between gap-[2.5px] pointer-events-none">
                        @php
                            $heights = [10, 16, 24, 18, 12, 16, 28, 20, 14, 22, 32, 24, 16, 20, 30, 22, 14, 18, 26, 18, 12, 16, 28, 20, 14, 22, 32, 24, 16, 20, 30, 22, 14, 18, 26, 18, 12, 16, 10, 8];
                        @endphp
                        @foreach($heights as $i => $h)
                            <div class="w-[3px] rounded-full bg-white/25 transition-colors duration-150" style="height: {{ $h }}px;" data-index="{{ $i }}"></div>
                        @endforeach
                    </div>
                    <!-- Custom Thumb indicator -->
                    <div id="gs_audio_viewer_thumb" class="absolute w-3 h-3 rounded-full bg-[#53bdeb] pointer-events-none transform -translate-x-1/2" style="left: 0%;"></div>
                    <!-- Seek slider range -->
                    <input type="range" min="0" max="100" value="0" step="0.1" id="gs_audio_viewer_slider" oninput="window.onGsAudioViewerSliderInput()" onchange="window.onGsAudioViewerSliderChange()" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                </div>
            </div>

            <!-- Playback details (Time + Playback Speed) -->
            <div class="w-full flex items-center justify-between text-xs text-[#8696a0] font-semibold px-2">
                <span id="gs_audio_viewer_time_display">0:00</span>
                <button onclick="window.toggleGsAudioViewerSpeed()" id="gs_audio_viewer_speed_btn" class="hover:text-white bg-[#202c33] border border-white/5 hover:bg-[#202c33]/80 px-3 py-1 rounded-full transition-colors focus:outline-none">1.0x</button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-t from-black/80 to-transparent absolute bottom-0 w-full z-[2100]">
        <!-- Reactions -->
        <div class="flex items-center gap-2">
            <button id="gs_audio_viewer_btn_react" class="text-white hover:text-[#d1d7db] transition-colors focus:outline-none p-2 rounded-full hover:bg-white/10" title="React">
                <svg viewBox="0 0 24 24" width="26" height="26" fill="currentColor">
                    <path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 100-16 8 8 0 000 16zm-3.5-9a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm7 0a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm-6.236 4.757C10.15 16.516 11.025 17 12 17s1.85-.484 2.736-1.243a1 1 0 111.306 1.52C14.885 18.257 13.565 19 12 19s-2.885-.743-4.042-1.723a1 1 0 011.306-1.52z"></path>
                </svg>
            </button>
            <div id="gs_audio_viewer_reactions_container" class="flex gap-1"></div>
        </div>

        <!-- Reply Button -->
        <button id="gs_audio_viewer_btn_reply" class="flex items-center gap-2 text-white hover:bg-white/10 transition-colors focus:outline-none px-4 py-2 rounded-full border border-white/20 bg-black/40 backdrop-blur-sm">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" style="transform: scaleX(-1);">
                <path d="M10 9V5l-7 7 7 7v-4.1c5 0 8.5 1.6 11 5.1-1-5-4-10-11-10z"></path>
            </svg>
            <span class="text-[15px] font-medium tracking-wide">Reply</span>
        </button>
    </div>

    <!-- Real HTML5 Audio Element for Playback -->
    <audio id="gs_audio_viewer_element" src="" preload="metadata" class="hidden" ontimeupdate="window.onGsAudioViewerTimeUpdate()" onended="window.onGsAudioViewerEnded()" onloadedmetadata="window.onGsAudioViewerLoadedMetadata()"></audio>
</div>

<style>
    #gs_audio_viewer.show {
        display: flex !important;
        opacity: 1;
    }
</style>

<script>
    window.gsAudioViewerCurrentContext = null;

    window.openGlobalSearchAudioViewer = function(key, chatId, url, senderName, timestampStr, isGroup, text) {
        window.gsAudioViewerCurrentContext = { key, chatId, url, senderName, timestampStr, isGroup, text };
        
        // Stop any currently playing custom audios in chat
        document.querySelectorAll('audio[id^="audio_element_"]').forEach(el => {
            if (!el.paused) {
                el.pause();
                const otherKey = el.id.replace('audio_element_', '');
                const otherPlay = document.getElementById(`play_svg_${otherKey}`);
                const otherPause = document.getElementById(`pause_svg_${otherKey}`);
                if (otherPlay) otherPlay.classList.remove('hidden');
                if (otherPause) otherPause.classList.add('hidden');
            }
        });

        const viewer = document.getElementById('gs_audio_viewer');
        if (!viewer) return;

        viewer.classList.remove('hidden');
        setTimeout(() => viewer.classList.add('show'), 10);

        // Load details
        document.getElementById('gs_audio_viewer_sender_name').textContent = senderName;
        document.getElementById('gs_audio_viewer_time').textContent = timestampStr;

        // Resolve avatar
        let senderAvatar = window.myUserAvatar;
        if (senderName !== 'You') {
            const senderId = chatId.startsWith('group_') ? null : chatId.replace('chat_', '').split('_').find(id => id != window.myUserId);
            if (senderId) {
                const contact = window.allContacts?.find(c => String(c.id) === String(senderId));
                if (contact && contact.avatar) senderAvatar = contact.avatar;
            }
        }
        document.getElementById('gs_audio_viewer_avatar').src = senderAvatar;

        // Reset elements
        const audio = document.getElementById('gs_audio_viewer_element');
        audio.src = url;
        audio.load();
        audio.playbackRate = 1.0;
        document.getElementById('gs_audio_viewer_speed_btn').textContent = '1.0x';

        // Reset play/pause button
        document.getElementById('gs_audio_viewer_play_svg').classList.remove('hidden');
        document.getElementById('gs_audio_viewer_pause_svg').classList.add('hidden');

        // Reset Slider & thumb
        document.getElementById('gs_audio_viewer_slider').value = 0;
        document.getElementById('gs_audio_viewer_thumb').style.left = '0%';
        
        // Reset waveform bars
        const bars = document.getElementById('gs_audio_viewer_waveform_bars').children;
        for (let i = 0; i < bars.length; i++) {
            bars[i].classList.remove('bg-[#53bdeb]');
            bars[i].classList.add('bg-white/25');
        }

        // Show existing reactions if available
        const reactionsContainer = document.getElementById('gs_audio_viewer_reactions_container');
        if (reactionsContainer) reactionsContainer.innerHTML = '';
        
        let existingReactions = null;
        if (isGroup && window.groupMessagesCache && window.groupMessagesCache[chatId.replace('group_', '')]) {
            const msg = window.groupMessagesCache[chatId.replace('group_', '')].find(m => m.key === key);
            if (msg && msg.reactions) existingReactions = msg.reactions;
        } else if (!isGroup && window.messageCache && window.messageCache[chatId.replace('chat_', '')]) {
            const msg = window.messageCache[chatId.replace('chat_', '')].find(m => m.key === key);
            if (msg && msg.reactions) existingReactions = msg.reactions;
        } else if (window.globalMessages && window.globalMessages[key]) {
            existingReactions = window.globalMessages[key].reactions;
        }
        
        if (existingReactions && reactionsContainer) {
            const counts = {};
            Object.values(existingReactions).forEach(r => counts[r] = (counts[r] || 0) + 1);
            Object.entries(counts).forEach(([emoji, count]) => {
                reactionsContainer.innerHTML += `<div class="bg-black/50 border border-white/20 rounded-full px-2 py-0.5 text-white text-[13px] flex items-center gap-1"><span>${emoji}</span>${count > 1 ? `<span class="text-white/80">${count}</span>` : ''}</div>`;
            });
        }
    };

    window.closeGlobalSearchAudioViewer = function() {
        const viewer = document.getElementById('gs_audio_viewer');
        if (!viewer) return;
        viewer.classList.remove('show');
        setTimeout(() => viewer.classList.add('hidden'), 300);

        // Pause audio
        const audio = document.getElementById('gs_audio_viewer_element');
        if (audio) audio.pause();

        // Close dropdown
        document.getElementById('gs_audio_viewer_dropdown_menu')?.classList.add('hidden');
    };

    window.toggleGsAudioViewerPlay = function() {
        const audio = document.getElementById('gs_audio_viewer_element');
        const playSvg = document.getElementById('gs_audio_viewer_play_svg');
        const pauseSvg = document.getElementById('gs_audio_viewer_pause_svg');
        if (!audio) return;

        if (audio.paused) {
            const playPromise = audio.play();
            if (playPromise !== undefined) {
                playPromise.catch(e => {
                    console.error("Audio playback failed:", e);
                    if (playSvg) playSvg.classList.remove('hidden');
                    if (pauseSvg) pauseSvg.classList.add('hidden');
                });
            }
            if (playSvg) playSvg.classList.add('hidden');
            if (pauseSvg) pauseSvg.classList.remove('hidden');
        } else {
            audio.pause();
            if (playSvg) playSvg.classList.remove('hidden');
            if (pauseSvg) pauseSvg.classList.add('hidden');
        }
    };

    window.toggleGsAudioViewerSpeed = function() {
        const audio = document.getElementById('gs_audio_viewer_element');
        const btn = document.getElementById('gs_audio_viewer_speed_btn');
        if (!audio || !btn) return;
        let nextSpeed = 1.0;
        if (audio.playbackRate === 1.0) {
            nextSpeed = 1.5;
        } else if (audio.playbackRate === 1.5) {
            nextSpeed = 2.0;
        } else {
            nextSpeed = 1.0;
        }
        audio.playbackRate = nextSpeed;
        btn.textContent = nextSpeed + 'x';
    };

    window.onGsAudioViewerSliderInput = function() {
        const audio = document.getElementById('gs_audio_viewer_element');
        const slider = document.getElementById('gs_audio_viewer_slider');
        const thumb = document.getElementById('gs_audio_viewer_thumb');
        if (!audio || !slider) return;

        const pct = parseFloat(slider.value);
        if (thumb) thumb.style.left = pct + '%';

        const bars = document.getElementById('gs_audio_viewer_waveform_bars').children;
        const activeIndex = Math.floor((pct / 100) * bars.length);
        for (let i = 0; i < bars.length; i++) {
            if (i <= activeIndex && pct > 0) {
                bars[i].classList.remove('bg-white/25');
                bars[i].classList.add('bg-[#53bdeb]');
            } else {
                bars[i].classList.remove('bg-[#53bdeb]');
                bars[i].classList.add('bg-white/25');
            }
        }
    };

    window.onGsAudioViewerSliderChange = function() {
        const audio = document.getElementById('gs_audio_viewer_element');
        const slider = document.getElementById('gs_audio_viewer_slider');
        if (!audio || !slider) return;

        if (!isNaN(audio.duration) && isFinite(audio.duration)) {
            audio.currentTime = (parseFloat(slider.value) / 100) * audio.duration;
        }
    };

    window.onGsAudioViewerTimeUpdate = function() {
        const audio = document.getElementById('gs_audio_viewer_element');
        if (!audio) return;
        
        let pct = 0;
        if (audio.duration && !isNaN(audio.duration) && isFinite(audio.duration)) {
            pct = (audio.currentTime / audio.duration) * 100 || 0;
        }

        const slider = document.getElementById('gs_audio_viewer_slider');
        if (slider) slider.value = pct;

        const thumb = document.getElementById('gs_audio_viewer_thumb');
        if (thumb) thumb.style.left = pct + '%';

        const timeSpan = document.getElementById('gs_audio_viewer_time_display');
        if (timeSpan) {
            const formatTime = (secs) => {
                if (isNaN(secs)) return '0:00';
                const m = Math.floor(secs / 60);
                const s = Math.floor(secs % 60);
                return `${m}:${s < 10 ? '0' : ''}${s}`;
            };
            timeSpan.textContent = formatTime(audio.currentTime);
        }

        const bars = document.getElementById('gs_audio_viewer_waveform_bars').children;
        const activeIndex = Math.floor((pct / 100) * bars.length);
        for (let i = 0; i < bars.length; i++) {
            if (i <= activeIndex && pct > 0) {
                bars[i].classList.remove('bg-white/25');
                bars[i].classList.add('bg-[#53bdeb]');
            } else {
                bars[i].classList.remove('bg-[#53bdeb]');
                bars[i].classList.add('bg-white/25');
            }
        }
    };

    window.onGsAudioViewerEnded = function() {
        document.getElementById('gs_audio_viewer_play_svg').classList.remove('hidden');
        document.getElementById('gs_audio_viewer_pause_svg').classList.add('hidden');

        const audio = document.getElementById('gs_audio_viewer_element');
        if (audio) audio.currentTime = 0;

        document.getElementById('gs_audio_viewer_slider').value = 0;
        document.getElementById('gs_audio_viewer_thumb').style.left = '0%';

        const bars = document.getElementById('gs_audio_viewer_waveform_bars').children;
        for (let i = 0; i < bars.length; i++) {
            bars[i].classList.remove('bg-[#53bdeb]');
            bars[i].classList.add('bg-white/25');
        }

        document.getElementById('gs_audio_viewer_time_display').textContent = '0:00';
    };

    window.onGsAudioViewerLoadedMetadata = function() {
        const audio = document.getElementById('gs_audio_viewer_element');
        const timeSpan = document.getElementById('gs_audio_viewer_time_display');
        if (audio && timeSpan) {
            const formatTime = (secs) => {
                if (isNaN(secs)) return '0:00';
                const m = Math.floor(secs / 60);
                const s = Math.floor(secs % 60);
                return `${m}:${s < 10 ? '0' : ''}${s}`;
            };
            timeSpan.textContent = formatTime(audio.duration);
        }
    };

    window.toggleGsAudioViewerMenu = function(e) {
        e.stopPropagation();
        const menu = document.getElementById('gs_audio_viewer_dropdown_menu');
        if (menu) menu.classList.toggle('hidden');
    };

    // Close menu on document click
    document.addEventListener('click', () => {
        document.getElementById('gs_audio_viewer_dropdown_menu')?.classList.add('hidden');
    });

    // Share action
    document.getElementById('gs_audio_viewer_btn_share')?.addEventListener('click', async () => {
        if (!window.gsAudioViewerCurrentContext) return;
        const url = window.gsAudioViewerCurrentContext.url;
        const text = 'Voice message';
        
        if (!navigator.share) {
            if (window.showToast) window.showToast('Notice', 'System sharing is not supported on this device.');
            return;
        }
        
        try {
            const response = await fetch(url);
            const blob = await response.blob();
            const ext = url.split('.').pop().split('?')[0] || 'mp3';
            const file = new File([blob], `Shared_Media.${ext}`, { type: blob.type });
            
            if (navigator.canShare && navigator.canShare({ files: [file] })) {
                await navigator.share({
                    files: [file],
                    title: 'Shared Audio',
                    text: text
                });
                return;
            }
        } catch (e) {
            console.log("Could not share as file, falling back to URL", e);
        }

        try {
            await navigator.share({
                title: 'Shared Audio',
                text: text,
                url: url
            });
        } catch (e) {
            console.log("Share failed", e);
        }
    });

    // Forward action
    document.getElementById('gs_audio_viewer_btn_forward')?.addEventListener('click', () => {
        if (!window.gsAudioViewerCurrentContext) return;
        window.closeGlobalSearchAudioViewer();
        if (window.forwardMsg) {
            if (!window.globalMessages) window.globalMessages = {};
            if (!window.globalMessages[window.gsAudioViewerCurrentContext.key]) {
                window.globalMessages[window.gsAudioViewerCurrentContext.key] = {
                    key: window.gsAudioViewerCurrentContext.key,
                    file_url: window.gsAudioViewerCurrentContext.url,
                    type: 'audio'
                };
            }
            window.forwardMsg(window.gsAudioViewerCurrentContext.key);
        }
    });

    // Download action
    document.getElementById('gs_audio_viewer_btn_download')?.addEventListener('click', () => {
        if (!window.gsAudioViewerCurrentContext) return;
        const link = document.createElement('a');
        link.href = window.gsAudioViewerCurrentContext.url;
        link.download = 'voice-note.mp3';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });

    // Delete action
    document.getElementById('gs_audio_viewer_btn_delete')?.addEventListener('click', () => {
        if (!window.gsAudioViewerCurrentContext) return;
        window.closeGlobalSearchAudioViewer();
        if (window.deleteMsg) {
            if (!window.globalMessages) window.globalMessages = {};
            if (!window.globalMessages[window.gsAudioViewerCurrentContext.key]) {
                window.globalMessages[window.gsAudioViewerCurrentContext.key] = {
                    key: window.gsAudioViewerCurrentContext.key,
                    file_url: window.gsAudioViewerCurrentContext.url,
                    type: 'audio',
                    sender_id: window.gsAudioViewerCurrentContext.isGroup ? null : (window.gsAudioViewerCurrentContext.senderName === 'You' ? window.myUserId : 'other')
                };
            }
            window.deleteMsg(window.gsAudioViewerCurrentContext.key);
        }
    });

    // Reply action
    document.getElementById('gs_audio_viewer_btn_reply')?.addEventListener('click', () => {
        if (!window.gsAudioViewerCurrentContext) return;
        window.closeGlobalSearchAudioViewer();
        
        const chatId = window.gsAudioViewerCurrentContext.chatId;
        let cId = chatId;
        let isGroup = window.gsAudioViewerCurrentContext.isGroup;
        if (chatId.startsWith('group_')) {
            cId = chatId.replace('group_', '');
        } else {
            const ids = chatId.replace('chat_', '').split('_');
            cId = ids.find(id => id != window.myUserId) || window.myUserId;
        }

        let name = window.gsAudioViewerCurrentContext.senderName;
        let avatar = '';
        let status = 'online';
        const elementId = isGroup ? `group_sidebar_${cId}` : `user_sidebar_${cId}`;
        const sidebarEl = document.getElementById(elementId);
        if (sidebarEl) {
            name = sidebarEl.getAttribute('data-name') || name;
            avatar = sidebarEl.getAttribute('data-avatar') || avatar;
            status = sidebarEl.getAttribute('data-status') || status;
        }

        if (isGroup) {
            if (window.selectGroupChat) window.selectGroupChat(cId, name, avatar);
        } else {
            if (window.selectChat) window.selectChat(cId, name, '', avatar, status);
        }

        setTimeout(() => {
            const key = window.gsAudioViewerCurrentContext.key;
            const senderName = window.gsAudioViewerCurrentContext.senderName;
            const url = window.gsAudioViewerCurrentContext.url;
            const text = 'Voice message';
            let groupName = null;
            if (isGroup) {
                const groupEl = document.getElementById(`group_sidebar_${cId}`);
                if (groupEl) groupName = groupEl.getAttribute('data-name');
            }
            window.replyToMsg(key, senderName, text, groupName, url, 'audio');
        }, 800);
    });

    // React action
    document.getElementById('gs_audio_viewer_btn_react')?.addEventListener('click', (e) => {
        if (!window.gsAudioViewerCurrentContext) return;
        const key = window.gsAudioViewerCurrentContext.key;
        const msgEl = document.getElementById('msg_' + key);
        if (msgEl) {
            const rect = msgEl.getBoundingClientRect();
            if (window.showReactionPopup) {
                const x = rect.left + rect.width / 2;
                const y = rect.top - 10;
                window.showReactionPopup(key, x, y);
            }
        }
    });

    // Show in Chat action
    document.getElementById('gs_audio_viewer_btn_show_chat')?.addEventListener('click', () => {
        if (!window.gsAudioViewerCurrentContext) return;
        window.closeGlobalSearchAudioViewer();
        
        const chatId = window.gsAudioViewerCurrentContext.chatId;
        let cId = chatId;
        let isGroup = window.gsAudioViewerCurrentContext.isGroup;
        if (chatId.startsWith('group_')) {
            cId = chatId.replace('group_', '');
        } else {
            const ids = chatId.replace('chat_', '').split('_');
            cId = ids.find(id => id != window.myUserId) || window.myUserId;
        }
        
        let name = window.gsAudioViewerCurrentContext.senderName;
        let avatar = '';
        let status = 'online';
        const elementId = isGroup ? `group_sidebar_${cId}` : `user_sidebar_${cId}`;
        const sidebarEl = document.getElementById(elementId);
        if (sidebarEl) {
            name = sidebarEl.getAttribute('data-name') || name;
            avatar = sidebarEl.getAttribute('data-avatar') || avatar;
            status = sidebarEl.getAttribute('data-status') || status;
        }
        
        if (isGroup) {
            if (window.selectGroupChat) window.selectGroupChat(cId, name, avatar);
        } else {
            if (window.selectChat) window.selectChat(cId, name, '', avatar, status);
        }
        
        if (window.closeGlobalSearch) window.closeGlobalSearch();
        if (window.jumpToMessage) {
            setTimeout(() => window.jumpToMessage(chatId, window.gsAudioViewerCurrentContext.key), 500);
        }
    });
</script>
