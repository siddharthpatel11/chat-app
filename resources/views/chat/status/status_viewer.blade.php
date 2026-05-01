<div id="status_viewer_overlay" class="hidden fixed inset-0 z-[600] bg-black flex flex-col items-center justify-center font-sans">
    <!-- Progress Bars Container -->
    <div id="status_progress_container" class="absolute top-4 left-0 right-0 flex gap-1 px-4 z-[610]">
        <!-- Bars will be injected here -->
    </div>

    <!-- Viewer Header -->
    <div class="absolute top-8 left-0 right-0 px-6 flex items-center justify-between z-[610]">
        <div class="flex items-center gap-4">
            <button onclick="window.closeStatusViewer()" class="text-white/80 hover:text-white transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
            </button>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full overflow-hidden bg-[#2a3942]">
                    <img id="viewer_user_avatar" src="" class="w-full h-full object-cover">
                </div>
                <div class="flex flex-col">
                    <span id="viewer_user_name" class="text-white font-medium text-[15px]"></span>
                    <span id="viewer_status_time" class="text-white/60 text-[12px]"></span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-6">
            <button id="status_play_pause_btn" onclick="window.toggleStatusPlayback()" class="text-white/80 hover:text-white transition-colors">
                <svg id="status_pause_icon" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"></path>
                </svg>
                <svg id="status_play_icon" viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="hidden">
                    <path d="M8 5v14l11-7z"></path>
                </svg>
            </button>
            <button class="text-white/80 hover:text-white transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"></path>
                </svg>
            </button>
            <div class="relative">
                <button onclick="window.toggleViewerMenu(event)" class="text-white/80 hover:text-white transition-colors">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path d="M12 7a2 2 0 100-4 2 2 0 000 4zm0 2a2 2 0 100 4 2 2 0 000-4zm0 7a2 2 0 100 4 2 2 0 000-4z"></path>
                    </svg>
                </button>
                <!-- Viewer Menu -->
                <div id="status_viewer_menu" class="hidden absolute top-full right-0 mt-2 w-[160px] bg-[#233138] rounded-xl shadow-2xl py-2 border border-white/5 z-[620]">
                    <button id="status_delete_btn" onclick="window.deleteStatus()" class="w-full text-left px-4 py-3 text-red-500 hover:bg-[#182229] transition-colors flex items-center gap-3">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path>
                        </svg>
                        <span class="text-[15px]">Delete</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Content Area -->
    <div id="status_content_main" class="w-full h-full flex items-center justify-center relative">
        <!-- Text Content -->
        <div id="status_text_content" class="hidden w-full max-w-2xl text-center break-words px-4">
            <h1 id="viewer_status_text" class="text-white text-[32px] md:text-[42px] leading-tight font-sans"></h1>
        </div>

        <!-- Media Content -->
        <div id="status_media_content" class="hidden w-full h-full flex flex-col items-center justify-center relative">
            <div id="media_container" class="w-full h-full flex items-center justify-center">
                <!-- img or video will be injected here -->
            </div>
            
            <!-- Caption Overlay -->
            <div id="status_caption_container" class="hidden absolute bottom-20 left-0 right-0 px-6 py-4 bg-gradient-to-t from-black/60 to-transparent text-center">
                <p id="viewer_status_caption" class="text-white text-[17px] max-w-2xl mx-auto drop-shadow-md"></p>
            </div>
        </div>
    </div>

    <!-- Navigation Buttons -->
    <button onclick="prevStatus()" class="absolute left-10 w-12 h-12 rounded-full bg-[#202c33]/50 hover:bg-[#202c33]/80 text-white flex items-center justify-center transition-all z-[615] active:scale-90">
        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
            <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"></path>
        </svg>
    </button>
    <button onclick="nextStatus()" class="absolute right-10 w-12 h-12 rounded-full bg-[#202c33]/50 hover:bg-[#202c33]/80 text-white flex items-center justify-center transition-all z-[615] active:scale-90">
        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
            <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"></path>
        </svg>
    </button>

    <!-- Viewers List Modal (Centered) -->
    <div id="status_viewers_modal" class="hidden fixed inset-0 z-[700] flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-[1px]" onclick="window.toggleViewersModal()"></div>
        <div class="relative w-full max-w-[360px] bg-[#1f2c33] rounded-3xl shadow-2xl overflow-hidden flex flex-col animate-in fade-in zoom-in duration-200">
            <div class="p-4 flex items-center gap-4 border-b border-[#202c33]">
                <button onclick="window.toggleViewersModal()" class="text-[#8696a0] hover:text-[#e9edef] transition-colors">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path>
                    </svg>
                </button>
                <span class="text-[#e9edef] font-medium">Viewed by <span id="viewer_count">0</span></span>
            </div>
            <div id="viewers_list" class="max-h-[300px] overflow-y-auto p-2 custom-scrollbar bg-[#111b21]/30">
                <!-- Viewers will be injected here -->
            </div>
        </div>
    </div>

    <!-- Bottom Viewed By Button (Only for my status) -->
    <button id="show_viewers_btn" onclick="window.toggleViewersModal()" class="hidden absolute bottom-10 flex flex-col items-center gap-1 text-white/80 hover:text-white transition-colors z-[610]">
        <div class="flex items-center gap-2">
            <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"></path>
            </svg>
            <span id="bottom_viewer_count" class="text-sm font-medium">0</span>
        </div>
    </button>

    <!-- Custom Delete Confirmation Modal -->
    <div id="delete_status_modal" class="hidden fixed inset-0 z-[700] flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-[2px]" onclick="window.closeDeleteModal()"></div>
        <div class="relative w-full max-w-[400px] bg-[#1f2c33] rounded-[28px] shadow-2xl p-8 animate-in fade-in zoom-in duration-200">
            <h2 class="text-[#e9edef] text-[22px] font-normal mb-4">Delete 1 status update</h2>
            <p class="text-[#8696a0] text-[15px] leading-relaxed mb-10">
                Delete this status update? It will also be deleted for everyone who received it.
            </p>
            <div class="flex items-center justify-end gap-6">
                <button onclick="window.closeDeleteModal()" class="text-[#00a884] font-semibold text-[15px] hover:bg-[#00a884]/10 px-4 py-2 rounded-full transition-colors">
                    Cancel
                </button>
                <button onclick="window.confirmDeleteStatus()" class="bg-[#f15c6d] hover:bg-[#d94f5e] active:scale-95 text-[#111b21] font-semibold text-[15px] px-6 py-2.5 rounded-full transition-all shadow-lg">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentStatusArray = [];
    let currentStatusIndex = 0;
    let statusPlaybackTimer = null;
    let playbackProgress = 0;
    let isPaused = false;
    const STATUS_DURATION = 5000; // 5 seconds per status

    window.openStatusViewer = function(statuses, startIndex = 0) {
        currentStatusArray = statuses;
        currentStatusIndex = startIndex;
        document.getElementById('status_viewer_overlay').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        renderStatus();
        startPlayback();
    };

    window.closeStatusViewer = function() {
        stopPlayback();
        document.getElementById('status_viewer_overlay').classList.add('hidden');
        document.body.style.overflow = '';
        document.getElementById('status_viewers_drawer').classList.add('translate-y-full');
    };

    function renderStatus() {
        const status = currentStatusArray[currentStatusIndex];
        const overlay = document.getElementById('status_viewer_overlay');
        const textContainer = document.getElementById('status_text_content');
        const mediaContainer = document.getElementById('status_media_content');
        const mediaInner = document.getElementById('media_container');
        const captionContainer = document.getElementById('status_caption_container');
        const captionText = document.getElementById('viewer_status_caption');
        
        const nameEl = document.getElementById('viewer_user_name');
        const avatarEl = document.getElementById('viewer_user_avatar');
        const timeEl = document.getElementById('viewer_status_time');
        const deleteBtn = document.getElementById('status_delete_btn');
        const showViewersBtn = document.getElementById('show_viewers_btn');

        // Reset visibility
        textContainer.classList.add('hidden');
        mediaContainer.classList.add('hidden');
        captionContainer.classList.add('hidden');
        mediaInner.innerHTML = '';

        if (!status.type || status.type === 'text') {
            overlay.style.backgroundColor = status.bgColor || '#000';
            textContainer.classList.remove('hidden');
            const textEl = document.getElementById('viewer_status_text');
            textEl.textContent = status.text;
            textEl.className = `text-white text-[32px] md:text-[42px] leading-tight ${status.font || 'font-sans'}`;
        } else {
            overlay.style.backgroundColor = '#000';
            mediaContainer.classList.remove('hidden');
            
            if (status.type === 'image') {
                const img = document.createElement('img');
                img.src = status.mediaUrl;
                img.className = 'max-w-full max-h-full object-contain';
                mediaInner.appendChild(img);
            } else if (status.type === 'video') {
                const video = document.createElement('video');
                video.src = status.mediaUrl;
                video.className = 'max-w-full max-h-full object-contain';
                video.autoplay = true;
                video.muted = true;
                video.onended = () => nextStatus();
                mediaInner.appendChild(video);
            }

            if (status.text) {
                captionContainer.classList.remove('hidden');
                captionText.textContent = status.text;
            }
        }
        
        nameEl.textContent = status.userId == window.myUserId ? 'You' : status.userName;
        avatarEl.src = status.userAvatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(status.userName)}&background=2a3942&color=fff`;
        
        // Format time
        const date = new Date(status.timestamp);
        timeEl.textContent = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        // Show/Hide delete and viewers for own status
        if (status.userId == window.myUserId) {
            deleteBtn.classList.remove('hidden');
            showViewersBtn.classList.remove('hidden');
            updateViewersList(status);
        } else {
            deleteBtn.classList.add('hidden');
            showViewersBtn.classList.add('hidden');
            // Mark as viewed in Firebase
            markAsViewed(status);
        }

        renderProgressBars();
    }

    function renderProgressBars() {
        const container = document.getElementById('status_progress_container');
        container.innerHTML = '';
        currentStatusArray.forEach((_, i) => {
            const bar = document.createElement('div');
            bar.className = 'flex-1 h-1 bg-white/30 rounded-full overflow-hidden';
            const progress = document.createElement('div');
            progress.className = 'h-full bg-white transition-all duration-100 ease-linear';
            progress.style.width = i < currentStatusIndex ? '100%' : (i === currentStatusIndex ? '0%' : '0%');
            bar.appendChild(progress);
            container.appendChild(bar);
        });
    }

    function startPlayback() {
        stopPlayback();
        playbackProgress = 0;
        isPaused = false;
        
        const bars = document.getElementById('status_progress_container').children;
        const currentBar = bars[currentStatusIndex].firstElementChild;

        statusPlaybackTimer = setInterval(() => {
            if (isPaused) return;
            
            playbackProgress += 100 / (STATUS_DURATION / 100);
            currentBar.style.width = `${playbackProgress}%`;

            if (playbackProgress >= 100) {
                nextStatus();
            }
        }, 100);
    }

    function stopPlayback() {
        if (statusPlaybackTimer) clearInterval(statusPlaybackTimer);
    }

    window.toggleStatusPlayback = function() {
        isPaused = !isPaused;
        document.getElementById('status_pause_icon').classList.toggle('hidden', isPaused);
        document.getElementById('status_play_icon').classList.toggle('hidden', !isPaused);
    };

    function nextStatus() {
        if (currentStatusIndex < currentStatusArray.length - 1) {
            currentStatusIndex++;
            renderStatus();
            startPlayback();
        } else {
            window.closeStatusViewer();
        }
    }

    function prevStatus() {
        if (currentStatusIndex > 0) {
            currentStatusIndex--;
            renderStatus();
            startPlayback();
        }
    }

    window.toggleViewerMenu = function(e) {
        e.stopPropagation();
        document.getElementById('status_viewer_menu').classList.toggle('hidden');
    };

    window.deleteStatus = function() {
        // Toggle viewer menu off
        document.getElementById('status_viewer_menu').classList.add('hidden');
        // Show custom modal
        document.getElementById('delete_status_modal').classList.remove('hidden');
        isPaused = true; // Pause status while modal is open
    };

    window.closeDeleteModal = function() {
        document.getElementById('delete_status_modal').classList.add('hidden');
        isPaused = false; // Resume if desired
    };

    window.confirmDeleteStatus = async function() {
        const status = currentStatusArray[currentStatusIndex];
        try {
            await window.remove(window.ref(window.db, `statuses/${window.myUserId}/${status.id}`));
            window.closeDeleteModal();
            window.closeStatusViewer();
            if (window.showToast) window.showToast('Deleted', 'Your status has been deleted.');
        } catch (e) {
            console.error('Delete status error:', e);
            alert('Failed to delete status.');
        }
    };

    window.toggleViewersModal = function() {
        const modal = document.getElementById('status_viewers_modal');
        const isOpening = modal.classList.contains('hidden');
        modal.classList.toggle('hidden');
        isPaused = isOpening; // Pause when viewing list
    };

    function updateViewersList(status) {
        const list = document.getElementById('viewers_list');
        const countEl = document.getElementById('viewer_count');
        const bottomCountEl = document.getElementById('bottom_viewer_count');
        
        const viewers = status.viewers || {};
        const viewerArray = Object.values(viewers);
        
        countEl.textContent = viewerArray.length;
        bottomCountEl.textContent = viewerArray.length;
        
        list.innerHTML = '';
        viewerArray.forEach(v => {
            list.insertAdjacentHTML('beforeend', `
                <div class="flex items-center gap-4 p-3 hover:bg-[#202c33] transition-colors rounded-xl">
                    <img src="${v.avatar || 'https://ui-avatars.com/api/?name='+encodeURIComponent(v.name)}" class="w-10 h-10 rounded-full object-cover">
                    <div class="flex flex-col">
                        <span class="text-[#e9edef] text-[15px] font-medium">${v.name}</span>
                        <span class="text-[#8696a0] text-[12px]">${new Date(v.timestamp).toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}</span>
                    </div>
                </div>
            `);
        });
    }

    async function markAsViewed(status) {
        // Only if not already viewed by me
        if (status.viewers && status.viewers[window.myUserId]) return;

        const viewerData = {
            id: window.myUserId,
            name: window.myUserName,
            avatar: window.myUserAvatar,
            timestamp: Date.now()
        };

        try {
            await window.set(window.ref(window.db, `statuses/${status.userId}/${status.id}/viewers/${window.myUserId}`), viewerData);
        } catch (e) {
            console.error('Mark as viewed error:', e);
        }
    }

    // Global click listener for viewer menu
    document.addEventListener('click', (e) => {
        const menu = document.getElementById('status_viewer_menu');
        if (menu && !menu.contains(e.target) && !e.target.closest('button[onclick*="toggleViewerMenu"]')) {
            menu.classList.add('hidden');
        }
    });
</script>
