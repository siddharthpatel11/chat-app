<div id="status_view_container" class="hidden flex-1 h-full overflow-hidden bg-[#0b141a]">
    <!-- Status Sidebar -->
    <div id="status_sidebar"
        class="flex flex-col w-[30%] sm:min-w-[300px] border-r border-[#313d45] bg-[#111b21] shrink-0">
        <!-- Header -->
        <div class="h-16 bg-[#202c33] flex items-center px-4 justify-between shrink-0 border-b border-[#313d45]">
            <h1 class="text-[#e9edef] text-[22px] font-bold">Status</h1>
            <div class="flex items-center gap-2 relative">
                <button onclick="window.toggleHeaderStatusMenu(event)" class="p-2 text-[#8696a0] hover:text-[#e9edef] rounded-full hover:bg-[#384b57] transition-all"
                    title="Add status">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path
                            d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z">
                        </path>
                    </svg>
                </button>
                
                <!-- Header Status Dropdown Menu -->
                <div id="header_status_dropdown" class="hidden absolute top-full right-0 w-[200px] bg-[#233138] rounded-xl shadow-2xl z-[100] py-2 mt-1 border border-white/5 animate-in fade-in zoom-in duration-200">
                    <button onclick="window.openMediaStatusSelection()" class="w-full flex items-center gap-3 px-4 py-3 hover:bg-[#182229] text-[#e9edef] transition-colors">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0]">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.96-2.36L6.5 17h11l-3.54-4.71z"></path>
                        </svg>
                        <span class="text-[15px]">Photos & videos</span>
                    </button>
                    <button onclick="window.openTextStatus()" class="w-full flex items-center gap-3 px-4 py-3 hover:bg-[#182229] text-[#e9edef] transition-colors">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#8696a0]">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                        <span class="text-[15px]">Text</span>
                    </button>
                </div>

                <button onclick="window.toggleOptionsMenu(event)" class="p-2 text-[#8696a0] hover:text-[#e9edef] rounded-full hover:bg-[#384b57] transition-all"
                    title="Status Menu">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path d="M12 7a2 2 0 100-4 2 2 0 000 4zm0 2a2 2 0 100 4 2 2 0 000-4zm0 7a2 2 0 100 4 2 2 0 000-4z"></path>
                    </svg>
                </button>

                <!-- Status Options Dropdown Menu -->
                <div id="status_options_dropdown" class="hidden absolute top-full right-0 w-[200px] bg-[#233138] rounded-xl shadow-2xl z-[100] py-2 mt-1 border border-white/5 animate-in fade-in zoom-in duration-200">
                    <button onclick="window.openStatusPrivacy(); window.closeAllStatusMenus();" class="w-full flex items-center gap-3 px-4 py-3 hover:bg-[#182229] text-[#e9edef] transition-colors text-left">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0]">
                            <path d="M12 2C8.69 2 6 4.69 6 8v4c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-6c0-1.1-.9-2-2-2V8c0-3.31-2.69-6-6-6zm-1 13h2v3h-2v-3zm3-7H10V8c0-1.1.9-2 2-2s2 .9 2 2v1z"></path>
                        </svg>
                        <span class="text-[15px]">Status Privacy</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto custom-scrollbar">
            <!-- My Status -->
            <div class="px-4 py-4 flex items-center gap-4 hover:bg-[#202c33] cursor-pointer transition-colors group relative" onclick="window.toggleMyStatusMenu(event)">
                <div class="relative w-12 h-12 shrink-0">
                    <div id="my_status_preview_ring" class="w-12 h-12 rounded-full p-[2px] border-2 border-[#8696a0]">
                        <div id="my_status_preview_inner" class="w-full h-full rounded-full overflow-hidden bg-[#2a3942] flex items-center justify-center">
                            <img id="my_status_avatar" src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=2a3942&color=fff' }}"
                                class="w-full h-full object-cover">
                            <span id="my_status_text_preview" class="hidden text-white text-[8px] text-center p-1 font-bold line-clamp-2"></span>
                        </div>
                    </div>
                    <div id="my_status_add_icon"
                        class="absolute -right-1 -bottom-1 w-5 h-5 bg-[#00a884] rounded-full border-2 border-[#111b21] flex items-center justify-center text-white">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor">
                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0" onclick="window.handleMyStatusClick(event)">
                    <h3 class="text-[#e9edef] text-[17px] font-medium leading-tight">My status</h3>
                    <p id="my_status_time" class="text-[#8696a0] text-sm mt-0.5">Click to add status update</p>
                </div>

                <!-- My Status Dropdown Menu -->
                <div id="my_status_dropdown" class="hidden absolute top-full left-4 w-[200px] bg-[#233138] rounded-xl shadow-2xl z-[100] py-2 mt-1 border border-white/5 animate-in fade-in zoom-in duration-200">
                    <button onclick="window.openMediaStatusSelection()" class="w-full flex items-center gap-3 px-4 py-3 hover:bg-[#182229] text-[#e9edef] transition-colors">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0]">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.96-2.36L6.5 17h11l-3.54-4.71z"></path>
                        </svg>
                        <span class="text-[15px]">Photos & videos</span>
                    </button>
                    <button onclick="window.openTextStatus()" class="w-full flex items-center gap-3 px-4 py-3 hover:bg-[#182229] text-[#e9edef] transition-colors">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#8696a0]">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                        <span class="text-[15px]">Text</span>
                    </button>
                </div>
            </div>

            <!-- Status Lists Container -->
            <div id="recent_statuses_list">
                <!-- Populated by Firebase -->
            </div>

            <!-- Viewed Updates -->
            <div id="viewed_statuses_header" class="hidden px-4 py-4 mt-2">
                <h2 class="text-[#8696a0] text-sm font-medium uppercase tracking-wide">Viewed</h2>
            </div>
            <div id="viewed_statuses_list">
                <!-- Populated by Firebase -->
            </div>

            <!-- Hidden Updates -->
            <div id="hidden_statuses_header" class="hidden px-4 py-4 mt-2">
                <h2 class="text-[#8696a0] text-sm font-medium uppercase tracking-wide">Hidden</h2>
            </div>
            <div id="hidden_statuses_list"></div>

            <!-- Encryption Notice -->
            <div class="px-4 py-8 text-center">
                <div class="flex items-center justify-center gap-1.5 text-[#8696a0] text-[12px]">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor">
                        <path
                            d="M12 2C8.69 2 6 4.69 6 8v4c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-6c0-1.1-.9-2-2-2V8c0-3.31-2.69-6-6-6zm-1 13h2v3h-2v-3zm3-7H10V8c0-1.1.9-2 2-2s2 .9 2 2v1z">
                        </path>
                    </svg>
                    <span>Your status updates are </span>
                    <span class="text-[#00a884]">end-to-end encrypted</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Resizer -->
    <div id="status_sidebar_resizer"
        class="hidden sm:block w-[4px] hover:bg-[#00a884]/30 cursor-col-resize shrink-0 z-[60] transition-colors active:bg-[#00a884]">
    </div>

    <!-- Status Main Content -->
    <div class="flex-1 flex flex-col items-center justify-center bg-[#0b141a] relative p-8">
        <div class="flex flex-col items-center max-w-md text-center">
            <!-- Central Icon -->
            <div class="w-24 h-24 text-[#3b4a54] mb-8 animate-pulse">
                <svg viewBox="0 0 24 24" width="96" height="96" fill="currentColor" class="opacity-40">
                    <path
                        d="M12.072 1.761a10.231 10.231 0 0 1 7.303 3.025l-1.611 1.611a7.923 7.923 0 0 0-11.433 0l-1.611-1.611a10.231 10.231 0 0 1 7.352-3.025zm7.303 17.453a10.231 10.231 0 0 1-7.303 3.025c-2.69 0-5.127-1.055-6.931-2.77l1.611-1.611a7.923 7.923 0 0 0 10.641 0l1.611 1.611a10.231 10.231 0 0 1 .371-.255zM3.737 6.397l1.611 1.611a7.923 7.923 0 0 0 0 7.984l-1.611 1.611a10.231 10.231 0 0 1 0-11.206zm14.915 0l1.611-1.611a10.231 10.231 0 0 1 0 11.206l-1.611-1.611a7.923 7.923 0 0 0 0-7.984z">
                    </path>
                </svg>
            </div>

            <h2 class="text-[#e9edef] text-[32px] font-light mb-4">Share status updates</h2>
            <p class="text-[#8696a0] text-[15px] leading-relaxed">
                Share photos, videos and text that disappear after 24 hours.
            </p>
        </div>

        <!-- Bottom Notice -->
        <div class="absolute bottom-10 flex items-center gap-1.5 text-[#667781] text-[13px]">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor">
                <path
                    d="M12 2C8.69 2 6 4.69 6 8v4c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-6c0-1.1-.9-2-2-2V8c0-3.31-2.69-6-6-6zm-1 13h2v3h-2v-3zm3-7H10V8c0-1.1.9-2 2-2s2 .9 2 2v1z">
                </path>
            </svg>
            <span>Your status updates are end-to-end encrypted</span>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #374045;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
</style>

<script>
    (function () {
        const resizer = document.getElementById('status_sidebar_resizer');
        const sidebar = document.getElementById('status_sidebar');
        let isResizing = false;

        // Load saved width
        const savedWidth = localStorage.getItem('sidebarWidth'); // Sync with chat sidebar width
        if (savedWidth && window.innerWidth >= 640) {
            sidebar.style.width = savedWidth;
        }

        resizer.addEventListener('mousedown', (e) => {
            isResizing = true;
            document.body.style.cursor = 'col-resize';
            document.body.classList.add('select-none');
        });

        document.addEventListener('mousemove', (e) => {
            if (!isResizing) return;

            let newWidth = e.clientX - 60; // Subtract nav_sidebar width
            const maxWidth = window.innerWidth / 2;
            const minWidth = 280;

            if (newWidth > maxWidth) newWidth = maxWidth;
            if (newWidth < minWidth) newWidth = minWidth;

            sidebar.style.width = `${newWidth}px`;
            localStorage.setItem('sidebarWidth', `${newWidth}px`);

            // Also update the chat sidebar to keep them in sync if you want
            const chatSidebar = document.getElementById('user_sidebar_container');
            if (chatSidebar) chatSidebar.style.width = `${newWidth}px`;
        });

        document.addEventListener('mouseup', () => {
            if (isResizing) {
                isResizing = false;
                document.body.style.cursor = '';
                document.body.classList.remove('select-none');
            }
        });
    })();

    window.toggleMyStatusMenu = function(e) {
        e.stopPropagation();
        const myStatuses = window.globalStatuses?.[window.myUserId] || [];
        if (myStatuses.length === 0) {
            window.closeAllStatusMenus();
            const menu = document.getElementById('my_status_dropdown');
            menu.classList.toggle('hidden');
        } else {
            // If we have statuses, maybe show a different menu or just open viewer
            window.openStatusViewer(myStatuses);
        }
    };

    window.handleMyStatusClick = function(e) {
        e.stopPropagation();
        const myStatuses = window.globalStatuses?.[window.myUserId] || [];
        if (myStatuses.length > 0) {
            window.openStatusViewer(myStatuses);
        } else {
            window.toggleMyStatusMenu(e);
        }
    };

    function getStatusRingSVG(total, viewedCount) {
        if (total <= 1) {
            const color = (total === 1 && viewedCount === 1) ? '#313d45' : (total === 1 ? '#00a884' : 'transparent');
            return `<div class="w-full h-full rounded-full border-2 border-[${color}]"></div>`;
        }
        
        const radius = 21;
        const circumference = 2 * Math.PI * radius;
        const gap = total > 1 ? 4 : 0; 
        const segmentLength = (circumference / total) - gap;
        
        let svg = `<svg viewBox="0 0 48 48" class="w-full h-full transform -rotate-90">`;
        for (let i = 0; i < total; i++) {
            // In WhatsApp, segments are viewed from first to last
            const isViewed = i < viewedCount;
            const color = isViewed ? '#313d45' : '#00a884';
            const offset = (circumference / total) * i;
            svg += `<circle cx="24" cy="24" r="${radius}" fill="transparent" stroke="${color}" stroke-width="2.5" stroke-dasharray="${segmentLength} ${circumference - segmentLength}" stroke-dashoffset="-${offset}" />`;
        }
        svg += `</svg>`;
        return svg;
    }

    window.toggleHeaderStatusMenu = function(e) {
        e.stopPropagation();
        window.closeAllStatusMenus();

        const menu = document.getElementById('header_status_dropdown');
        menu.classList.toggle('hidden');
    };

    window.openStatusByUserId = function(userId) {
        const statuses = window.globalStatuses?.[userId];
        if (statuses && statuses.length > 0) {
            window.openStatusViewer(statuses);
        }
    };

    window.toggleOptionsMenu = function(e) {
        e.stopPropagation();
        window.closeAllStatusMenus();

        const menu = document.getElementById('status_options_dropdown');
        menu.classList.toggle('hidden');
    };

    window.closeAllStatusMenus = function() {
        const menus = ['my_status_dropdown', 'header_status_dropdown', 'status_options_dropdown'];
        menus.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.classList.add('hidden');
        });
    };

    // Firebase Status Logic
    window.globalStatuses = {};
    
    function initStatusListeners() {
        const statusesRef = window.ref(window.db, 'statuses');
        
        window.onValue(statusesRef, (snapshot) => {
            const data = snapshot.val() || {};
            window.globalStatuses = {};
            
            const now = Date.now();
            const oneDay = 24 * 60 * 60 * 1000;

            // Filter and Organize
            for (const userId in data) {
                const userStatuses = [];
                for (const statusId in data[userId]) {
                    const status = data[userId][statusId];
                    status.id = statusId;
                    
                    // Apply Privacy Filtering
                    if (userId != window.myUserId) {
                        const mode = status.privacyMode || 'all';
                        const contacts = status.privacyContacts || [];
                        
                        // If it's 'except' and I'm in the excluded list, skip
                        if (mode === 'except' && contacts.includes(window.myUserId)) continue;
                        
                        // If it's 'only' and I'm NOT in the included list, skip
                        if (mode === 'only' && !contacts.includes(window.myUserId)) continue;
                    }

                    // Auto-delete from DB if >= 24h old
                    if (now - status.timestamp >= oneDay) {
                        try {
                            window.remove(window.ref(window.db, `statuses/${userId}/${statusId}`));
                        } catch (e) {
                            console.error('Auto-delete status error:', e);
                        }
                        continue;
                    }

                    userStatuses.push(status);
                }
                if (userStatuses.length > 0) {
                    // Sort by time
                    userStatuses.sort((a, b) => a.timestamp - b.timestamp);
                    window.globalStatuses[userId] = userStatuses;
                }
            }
            
            renderStatusLists();
        });
    }

    window.renderStatusLists = function() {
        const recentList = document.getElementById('recent_statuses_list');
        const viewedList = document.getElementById('viewed_statuses_list');
        const viewedHeader = document.getElementById('viewed_statuses_header');
        const hiddenList = document.getElementById('hidden_statuses_list');
        const hiddenHeader = document.getElementById('hidden_statuses_header');
        
        recentList.innerHTML = '<div class="px-4 py-4"><h2 class="text-[#00a884] text-sm font-medium uppercase tracking-wide">Recent</h2></div>';
        viewedList.innerHTML = '';
        if (hiddenList) hiddenList.innerHTML = '';
        
        let hasViewed = false;
        let hasHidden = false;

        const hiddenUsers = JSON.parse(localStorage.getItem('hiddenStatusUsers') || '[]').map(String);

        for (const userId in window.globalStatuses) {
            const statuses = window.globalStatuses[userId];
            const lastStatus = statuses[statuses.length - 1];
            
            if (userId == window.myUserId) {
                updateMyStatusPreview(statuses);
                continue;
            }

            const viewedCount = statuses.filter(s => s.viewers && s.viewers[window.myUserId]).length;
            const allViewed = viewedCount === statuses.length;
            const timeStr = formatStatusTime(lastStatus.timestamp);
            
            const isHidden = hiddenUsers.includes(userId);

            const html = `
                <div onclick="window.openStatusByUserId('${userId}')"
                    class="px-4 py-3 flex items-center justify-between gap-4 hover:bg-[#202c33] cursor-pointer transition-colors border-b border-[#202c33]/50 ${allViewed ? 'opacity-70' : ''}">
                    <div class="flex items-center gap-4 flex-1 min-w-0">
                        <div class="relative w-12 h-12 shrink-0">
                            <div class="absolute inset-0">
                                ${getStatusRingSVG(statuses.length, viewedCount)}
                            </div>
                            <div class="absolute inset-[3px] rounded-full overflow-hidden bg-[#2a3942] flex items-center justify-center">
                                ${lastStatus.type === 'text' ? 
                                    `<div class="w-full h-full flex items-center justify-center text-[6px] font-bold p-1 text-center" style="background-color: ${lastStatus.bgColor}">${lastStatus.text}</div>` :
                                    (lastStatus.type === 'video' ?
                                        `<div class="w-full h-full relative">
                                            <video src="${lastStatus.mediaUrl}" class="w-full h-full object-cover" muted preload="metadata"></video>
                                            <div class="absolute inset-0 flex items-center justify-center bg-black/20">
                                                <svg viewBox="0 0 24 24" width="16" height="16" fill="white"><path d="M8 5v14l11-7z"></path></svg>
                                            </div>
                                        </div>` :
                                        `<img src="${lastStatus.mediaUrl}" class="w-full h-full object-cover" onerror="this.src='${lastStatus.userAvatar}'">`
                                    )
                                }
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-[#e9edef] text-[17px] font-normal truncate">${lastStatus.userName}</h3>
                            <p class="text-[#8696a0] text-sm mt-0.5">${timeStr}</p>
                        </div>
                    </div>
                    ${isHidden ? `
                        <button onclick="event.stopPropagation(); window.unhideStatusUser('${userId}')" class="text-[#00a884] hover:text-[#06cf9c] text-sm font-semibold hover:underline shrink-0">
                            Unhide
                        </button>
                    ` : ''}
                </div>
            `;

            if (isHidden) {
                if (hiddenList) hiddenList.insertAdjacentHTML('beforeend', html);
                hasHidden = true;
            } else if (allViewed) {
                viewedList.insertAdjacentHTML('beforeend', html);
                hasViewed = true;
            } else {
                recentList.insertAdjacentHTML('beforeend', html);
            }
        }

        viewedHeader.classList.toggle('hidden', !hasViewed);
        if (hiddenHeader) hiddenHeader.classList.toggle('hidden', !hasHidden);
        
        // If no statuses (besides mine), show a placeholder or nothing
        if (recentList.children.length === 1 && !hasViewed && !hasHidden) {
            recentList.insertAdjacentHTML('beforeend', '<div class="px-4 py-8 text-center text-[#8696a0] text-sm">No recent updates</div>');
        }
    }

    window.unhideStatusUser = function(userId) {
        let hiddenUsers = JSON.parse(localStorage.getItem('hiddenStatusUsers') || '[]').map(String);
        hiddenUsers = hiddenUsers.filter(id => id != String(userId));
        localStorage.setItem('hiddenStatusUsers', JSON.stringify(hiddenUsers));
        window.renderStatusLists();
    };

    function updateMyStatusPreview(statuses) {
        const ring = document.getElementById('my_status_preview_ring');
        const inner = document.getElementById('my_status_preview_inner');
        const textPreview = document.getElementById('my_status_text_preview');
        const avatar = document.getElementById('my_status_avatar');
        const timeEl = document.getElementById('my_status_time');
        const addIcon = document.getElementById('my_status_add_icon');

        if (statuses && statuses.length > 0) {
            const lastStatus = statuses[statuses.length - 1];
            addIcon.classList.add('hidden');
            
            // Segmented ring for my status too
            ring.innerHTML = getStatusRingSVG(statuses.length, 0); // Always green/new for me
            ring.className = 'absolute inset-0';
            ring.style.border = 'none';
            ring.style.padding = '0';
            
            inner.classList.add('absolute', 'inset-[3px]');
            inner.classList.remove('w-full', 'h-full');

            if (lastStatus.type === 'text') {
                avatar.classList.add('hidden');
                textPreview.classList.remove('hidden');
                textPreview.textContent = lastStatus.text;
                inner.style.backgroundColor = lastStatus.bgColor;
            } else if (lastStatus.type === 'video') {
                avatar.classList.add('hidden');
                textPreview.classList.add('hidden');
                inner.style.backgroundColor = '#2a3942';
                inner.innerHTML = `
                    <div class="w-full h-full relative">
                        <video src="${lastStatus.mediaUrl}" class="w-full h-full object-cover" muted preload="metadata"></video>
                        <div class="absolute inset-0 flex items-center justify-center bg-black/20">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="white"><path d="M8 5v14l11-7z"></path></svg>
                        </div>
                    </div>`;
            } else {
                avatar.classList.remove('hidden');
                textPreview.classList.add('hidden');
                avatar.src = lastStatus.mediaUrl;
                avatar.onerror = () => { avatar.src = lastStatus.userAvatar; };
                inner.style.backgroundColor = '#2a3942';
                inner.innerHTML = ''; // Clear any video content
                inner.appendChild(avatar);
            }
            timeEl.textContent = formatStatusTime(lastStatus.timestamp);
        } else {
            addIcon.classList.remove('hidden');
            ring.innerHTML = '';
            ring.className = 'w-12 h-12 rounded-full p-[2px] border-2 border-[#8696a0]';
            ring.style.border = '';
            ring.style.padding = '';
            inner.className = 'w-full h-full rounded-full overflow-hidden bg-[#2a3942] flex items-center justify-center';
            inner.classList.remove('absolute', 'inset-[3px]');
            avatar.classList.remove('hidden');
            textPreview.classList.add('hidden');
            timeEl.textContent = 'Click to add status update';
        }
    }

    function formatStatusTime(timestamp) {
        const date = new Date(timestamp);
        const now = new Date();
        const diff = now - date;
        
        if (diff < 60000) return 'Just now';
        
        const isToday = date.toDateString() === now.toDateString();
        const time = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        
        if (isToday) return `Today at ${time}`;
        return `Yesterday at ${time}`;
    }

    // Initialize when ready
    if (window.db) {
        initStatusListeners();
    } else {
        const checkDB = setInterval(() => {
            if (window.db) {
                initStatusListeners();
                clearInterval(checkDB);
            }
        }, 100);
    }

    document.addEventListener('click', () => {
        window.closeAllStatusMenus();
    });
</script>
