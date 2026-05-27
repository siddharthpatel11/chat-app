<div id="calls_sidebar_container" class="hidden w-[300px] sm:w-[350px] lg:w-[400px] shrink-0 border-r border-[#313d45] flex-col bg-[#111b21] h-full transition-all duration-300">
    <!-- Header -->
    <div class="px-5 py-4 flex items-center justify-between mt-2">
        <h1 class="text-[#e9edef] text-[22px] font-bold">Calls</h1>
        <div class="flex gap-4 text-[#aebac1]">
            <button class="hover:bg-[#202c33] p-2 rounded-full transition-colors" title="New call">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#aebac1]">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    <line x1="14" y1="5" x2="20" y2="5"></line>
                    <line x1="17" y1="2" x2="17" y2="8"></line>
                </svg>
            </button>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="px-3 py-2">
        <div class="bg-[#202c33] rounded-lg flex items-center px-4 py-1.5 h-9">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" class="text-[#8696a0] shrink-0">
                <path d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 0 0 1.256-3.386 5.207 5.207 0 1 0-5.207 5.208 5.183 5.183 0 0 0 3.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-5.6-1.2a3.996 3.996 0 0 1-3.996-3.995 3.996 3.996 0 1 1 7.992 0 3.996 3.996 0 0 1-3.996 3.995z"></path>
            </svg>
            <input type="text" placeholder="Search name or number" class="bg-transparent border-none text-[#d1d7db] text-[14px] w-full ml-4 focus:ring-0 placeholder-[#8696a0]">
        </div>
    </div>

    <div class="flex-1 overflow-y-auto w-full pb-4 scrollbar-thin scrollbar-thumb-[#374045] scrollbar-track-transparent">
        
        <!-- Favourites -->
        <div class="mt-4 mb-2">
            <div class="px-5 mb-3 flex items-center justify-between">
                <h2 class="text-[#e9edef] text-[16px] font-medium">Favourites</h2>
                <button onclick="window.showAddFavouriteModal()" class="text-[#00a884] hover:text-[#017561] transition-colors">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M12 4c-4.41 0-8 3.59-8 8s3.59 8 8 8 8-3.59 8-8-3.59-8-8-8zm4 9h-3v3h-2v-3H8v-2h3V8h2v3h3v2z"></path></svg>
                </button>
            </div>
            
            <div id="favourites_list" class="px-3 flex flex-col gap-1">
                <!-- Dynamic Favourites will be injected here -->
            </div>
        </div>

        <div class="w-full h-[1px] bg-[#202c33] my-4 mx-auto" style="width: calc(100% - 40px);"></div>

        <!-- Recent Calls -->
        <div class="mt-2">
            <div class="px-5 mb-3">
                <h2 class="text-[#e9edef] text-[16px] font-medium">Recent</h2>
            </div>
            <div id="calls_list" class="px-3 flex flex-col gap-1">
                <!-- Dynamic Call Logs will be injected here -->
            </div>
        </div>
    </div>
</div>

<script>
window.loadCallLogs = function() {
    if (!window.myUserId) return;
    
    // Load Favourites
    const favsRef = window.ref(window.db, `users/${window.myUserId}/favorites`);
    window.onValue(favsRef, (snapshot) => {
        const favsContainer = document.getElementById('favourites_list');
        favsContainer.innerHTML = '';
        
        let hasFavs = false;
        snapshot.forEach((child) => {
            hasFavs = true;
            const fav = { key: child.key, ...child.val() };
            
            const onclickVideo = fav.is_group ? `window.startGroupVideoCall('${fav.id}')` : `window.startVideoCall('${fav.id}', '${fav.name}', '${fav.avatar}')`;
            const onclickVoice = fav.is_group ? `window.startGroupVoiceCall('${fav.id}')` : `window.startVoiceCall('${fav.id}', '${fav.name}', '${fav.avatar}')`;

            const el = document.createElement('div');
            el.className = "flex items-center justify-between p-3 rounded-lg hover:bg-[#202c33] cursor-pointer group";
            el.innerHTML = `
                <div class="flex items-center gap-3 flex-1 overflow-hidden" onclick="${onclickVoice}">
                    <div class="w-11 h-11 rounded-full overflow-hidden shrink-0">
                        <img src="${fav.avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(fav.name) + '&background=2a3942&color=fff'}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex flex-col flex-1 min-w-0 pr-2">
                        <span class="text-[#e9edef] text-[16px] font-normal leading-tight truncate">${fav.name}</span>
                    </div>
                </div>
                <div class="flex items-center gap-5 text-[#8696a0] shrink-0">
                    <button class="hover:text-[#00a884] transition-colors" onclick="event.stopPropagation(); ${onclickVideo}">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"></path></svg>
                    </button>
                    <button class="hover:text-[#00a884] transition-colors" onclick="event.stopPropagation(); ${onclickVoice}">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z"></path></svg>
                    </button>
                </div>
            `;
            favsContainer.appendChild(el);
        });
        
        if (!hasFavs) {
            favsContainer.innerHTML = `<div class="text-[#8696a0] text-[14px] text-center mt-2 mb-2">No favourites</div>`;
        }
    });

    // Load Recent Calls
    const callsRef = window.ref(window.db, `users/${window.myUserId}/call_logs`);
    
    // Sort by time descending (this is handled client side since Firebase RTDB sorting is limited)
    window.onValue(callsRef, (snapshot) => {
        const callsContainer = document.getElementById('calls_list');
        callsContainer.innerHTML = '';
        
        const logs = [];
        snapshot.forEach((child) => {
            logs.push({ key: child.key, ...child.val() });
        });
        
        if (logs.length === 0) {
            callsContainer.innerHTML = `<div class="text-[#8696a0] text-[14px] text-center mt-6">No recent calls</div>`;
            return;
        }

        // Sort descending by time
        logs.sort((a, b) => b.time - a.time);

        logs.forEach(log => {
            // Determine icon and text color based on status and direction
            let callIconHtml = '';
            let statusTextColor = 'text-[#8696a0]';
            
            if (log.status === 'missed') {
                statusTextColor = 'text-[#ef4444]'; // Red for missed
                // Missed incoming call arrow
                callIconHtml = `<svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" class="text-[#ef4444]"><path d="M12 4l-1.41 1.41L15.17 10H4v2h11.17l-4.58 4.59L12 18l7-7-7-7z" transform="rotate(135 12 12)"/></svg>`;
            } else if (log.direction === 'incoming') {
                // Incoming answered arrow
                callIconHtml = `<svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" class="text-[#00a884]"><path d="M12 4l-1.41 1.41L15.17 10H4v2h11.17l-4.58 4.59L12 18l7-7-7-7z" transform="rotate(135 12 12)"/></svg>`;
            } else {
                // Outgoing arrow
                callIconHtml = `<svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" class="text-[#00a884]"><path d="M12 4l-1.41 1.41L15.17 10H4v2h11.17l-4.58 4.59L12 18l7-7-7-7z" transform="rotate(-45 12 12)"/></svg>`;
            }

            const statusText = log.status.charAt(0).toUpperCase() + log.status.slice(1);
            
            // Format time (Date)
            const d = new Date(log.time * 1000);
            const dateStr = d.toLocaleDateString('en-GB'); // DD/MM/YYYY

            const isVideo = log.type === 'video';
            
            const onclickCode = log.is_group 
                ? (isVideo ? `window.startGroupVideoCall('${log.other_user_id}')` : `window.startGroupVoiceCall('${log.other_user_id}')`)
                : (isVideo ? `window.startVideoCall('${log.other_user_id}', '${log.other_user_name}', '${log.other_user_avatar}')` : `window.startVoiceCall('${log.other_user_id}', '${log.other_user_name}', '${log.other_user_avatar}')`);

            const el = document.createElement('div');
            el.className = "flex items-center justify-between p-3 rounded-lg hover:bg-[#202c33] cursor-pointer group";
            el.innerHTML = `
                <div class="flex items-center gap-3 overflow-hidden flex-1" onclick="${onclickCode}">
                    <div class="w-11 h-11 rounded-full overflow-hidden shrink-0">
                        <img src="${log.other_user_avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(log.other_user_name) + '&background=2a3942&color=fff'}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex flex-col flex-1 min-w-0 pr-2">
                        <span class="text-[#e9edef] text-[16px] font-normal leading-tight truncate">${log.other_user_name}</span>
                        <div class="flex items-center gap-1 mt-0.5">
                            ${callIconHtml}
                            <span class="${statusTextColor} text-[13px]">${statusText}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 text-[#8696a0] shrink-0">
                    <span class="text-[#8696a0] text-[12px] mr-2">${dateStr}</span>
                    <button class="hover:text-[#00a884] transition-colors invisible group-hover:visible" onclick="${onclickCode}">
                        ${isVideo 
                            ? '<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"></path></svg>'
                            : '<svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z"></path></svg>'
                        }
                    </button>
                </div>
            `;
            callsContainer.appendChild(el);
        });
    });
};
</script>
