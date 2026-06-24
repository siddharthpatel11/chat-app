<script type="module">
    import { ref, set, push, onChildAdded, onValue, remove, update, get } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-database.js";
    import { ref as storageRef, uploadBytesResumable, getDownloadURL } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-storage.js";

    window.currentChannel = null;
    window.myUserId = '{{ auth()->id() }}';
    
    // Ensure db and storage are loaded from index.blade.php's global context
    const db = window.db;
    const storage = window.storage;
    
    // Track unread counts and last messages
    try {
        window.channelUnreadCounts = JSON.parse(localStorage.getItem('channelUnreadCounts')) || {};
    } catch(e) { window.channelUnreadCounts = {}; }
    window.prevChannelLastMessage = {};

    // Attach firebase methods to window for use in non-module scripts
    window.firebaseGet = get;
    window.firebaseRef = ref;
    window.firebaseUpdate = update;
    window.firebasePush = push;
    window.firebaseSet = set;
        
        window.loadMyChannels = function() {
            const myChannelsList = document.getElementById('my_channels_list');
            myChannelsList.innerHTML = '<div class="p-4 text-center text-[#8696a0] text-sm">Loading your channels...</div>';
            
            const channelsRef = ref(db, 'channels');
            onValue(channelsRef, (snapshot) => {
                let html = '';
                let hasChannels = false;
                const channelsArr = [];
                
                snapshot.forEach((childSnapshot) => {
                    const ch = childSnapshot.val();
                    channelsArr.push(ch);
                    
                    // Check for new messages
                    if (window.prevChannelLastMessage[ch.id] && window.prevChannelLastMessage[ch.id] !== ch.last_message) {
                        if (!window.currentChannel || window.currentChannel.id !== ch.id) {
                            window.channelUnreadCounts[ch.id] = (window.channelUnreadCounts[ch.id] || 0) + 1;
                            localStorage.setItem('channelUnreadCounts', JSON.stringify(window.channelUnreadCounts));
                        }
                    }
                    window.prevChannelLastMessage[ch.id] = ch.last_message;
                });
                
                // Sort descending by created_at or id
                channelsArr.sort((a, b) => {
                    const timeA = a.created_at || 0;
                    const timeB = b.created_at || 0;
                    return timeB - timeA;
                });
                
                channelsArr.forEach((ch) => {
                    if ((ch.followers && ch.followers[window.myUserId]) || (ch.admins && ch.admins[window.myUserId])) {
                        hasChannels = true;
                        
                        const isSelected = window.currentChannel && window.currentChannel.id === ch.id;
                        const activeClass = isSelected ? 'bg-[#2a3942]' : 'hover:bg-[#202c33]';
                        
                        // Get dynamic unread count
                        const unreadCount = window.channelUnreadCounts[ch.id] || 0;
                        const badgeDisplay = unreadCount > 0 ? 'flex' : 'hidden';
                        html += `
                            <div onclick="window.openChannel('${ch.id}')" class="flex items-center gap-3 px-3 py-3 ${activeClass} cursor-pointer transition-colors hover:bg-[#202c33]">
                                <div class="w-12 h-12 rounded-full overflow-hidden shrink-0">
                                    <img src="${ch.avatar || 'https://ui-avatars.com/api/?name='+encodeURIComponent(ch.name)+'&background=2a3942&color=fff'}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0 flex flex-col justify-center border-b border-[#202c33] pb-3 -mb-3">
                                    <div class="flex justify-between items-center mb-0.5">
                                        <div class="flex items-center gap-1 min-w-0">
                                            <h3 class="text-[#e9edef] text-[17px] font-normal truncate">${ch.name}</h3>
                                            <svg viewBox="0 0 16 16" width="14" height="14" fill="#00a884" class="shrink-0">
                                                <path d="M8 0l2.5 1.5L13.5 1 15 3.5 16 6l-1.5 2.5L16 11l-1.5 2.5L12 15l-3-1.5L6 15l-2.5-1.5L1 11 0 8.5 1.5 6 0 3.5 1.5 1 4.5 1 7 0z"/><path d="M6.5 11L3 7.5l1-1 2.5 2.5 5-5 1 1-6 6z" fill="#fff"/>
                                            </svg>
                                        </div>
                                        <span class="text-[#8696a0] text-[12px] whitespace-nowrap ml-2">Today</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <p class="text-[#8696a0] text-[14px] truncate pr-2">
                                            ${ch.last_message || ch.description || `You created this channel, "${ch.name}"`}
                                        </p>
                                        <div id="channel_unread_badge_${ch.id}" class="bg-[#00a884] text-[#111b21] rounded-full min-w-[20px] h-5 ${badgeDisplay} items-center justify-center text-[11px] font-bold px-1.5 shrink-0">
                                            ${unreadCount}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                });
                
                if (!hasChannels) {
                    html = '<div class="p-4 text-center text-[#8696a0] text-sm">You are not following any channels yet.</div>';
                }
                myChannelsList.innerHTML = html;
            });
        };

        window.loadDiscoverChannels = function() {
            document.getElementById('discover_channels_list').classList.remove('hidden');
            const discoverList = document.getElementById('discover_channels_list');
            discoverList.innerHTML = '<div class="p-4 text-center text-[#8696a0] text-sm">Loading channels to discover...</div>';
            
            const channelsRef = ref(db, 'channels');
            onValue(channelsRef, (snapshot) => {
                let html = '';
                let hasChannels = false;
                
                snapshot.forEach((childSnapshot) => {
                    const ch = childSnapshot.val();
                    if (!ch.followers || !ch.followers[window.myUserId]) {
                        hasChannels = true;
                        
                        html += `
                            <div onclick="window.openChannel('${ch.id}')" class="flex items-center gap-3 px-3 py-3 hover:bg-[#202c33] cursor-pointer transition-colors group">
                                <div class="w-12 h-12 rounded-full overflow-hidden shrink-0">
                                    <img src="${ch.avatar || 'https://ui-avatars.com/api/?name='+encodeURIComponent(ch.name)+'&background=2a3942&color=fff'}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0 flex flex-col justify-center border-b border-[#202c33] pb-3 -mb-3 group-last:border-none group-last:pb-0 group-last:-mb-0">
                                    <div class="flex justify-between items-center">
                                        <div class="flex flex-col min-w-0 pr-2">
                                            <div class="flex items-center gap-1">
                                                <h3 class="text-[#e9edef] text-[16px] font-normal truncate">${ch.name}</h3>
                                                <svg viewBox="0 0 16 16" width="14" height="14" fill="#00a884" class="shrink-0">
                                                    <path d="M8 0l2.5 1.5L13.5 1 15 3.5 16 6l-1.5 2.5L16 11l-1.5 2.5L12 15l-3-1.5L6 15l-2.5-1.5L1 11 0 8.5 1.5 6 0 3.5 1.5 1 4.5 1 7 0z"/><path d="M6.5 11L3 7.5l1-1 2.5 2.5 5-5 1 1-6 6z" fill="#fff"/>
                                                </svg>
                                            </div>
                                            <p class="text-[#8696a0] text-[13px] truncate">
                                                ${ch.followers_count || 0} follower${(ch.followers_count || 0) !== 1 ? 's' : ''}
                                            </p>
                                        </div>
                                        <button onclick="event.stopPropagation(); window.toggleFollowFromList('${ch.id}')" class="bg-[#0a332c] text-[#00a884] hover:bg-[#00a884] hover:text-[#111b21] px-5 py-1.5 rounded-full text-sm font-medium transition-colors shrink-0">Follow</button>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                });
                
                if (!hasChannels) {
                    html += '<div class="p-4 text-center text-[#8696a0] text-sm">No new channels to discover.</div>';
                }
                discoverList.innerHTML = html;
            });
        };

        window.loadFindChannelsCategories = function() {
            const listContainer = document.getElementById('find_channels_explore_list');
            if(!listContainer) return;
            
            listContainer.innerHTML = '<div class="p-4 text-center text-[#8696a0] text-sm">Loading channels...</div>';
            
            const channelsRef = ref(db, 'channels');
            onValue(channelsRef, (snapshot) => {
                let html = '';
                let exploreHtml = '';
                let entertainmentHtml = '';
                
                let exploreCount = 0;
                let entertainmentCount = 0;
                
                snapshot.forEach((childSnapshot) => {
                    const ch = childSnapshot.val();
                    const isFollowing = ch.followers && ch.followers[window.myUserId];
                    const followersCount = ch.followers_count || 0;
                    const followersStr = followersCount + ' follower' + (followersCount !== 1 ? 's' : '');
                    
                    const actionHtml = isFollowing 
                        ? `<div class="px-5 py-1.5 text-sm font-medium text-[#8696a0] shrink-0">Following</div>`
                        : `<button onclick="event.stopPropagation(); window.toggleFollowFromList('${ch.id}')" class="bg-[#0a332c] text-[#00a884] hover:bg-[#00a884] hover:text-[#111b21] px-5 py-1.5 rounded-full text-sm font-medium transition-colors shrink-0">Follow</button>`;

                    const chHtml = `
                        <div onclick="window.openChannel('${ch.id}')" class="flex items-center gap-4 px-4 py-3 hover:bg-[#202c33] cursor-pointer transition-colors group">
                            <div class="w-12 h-12 rounded-full overflow-hidden shrink-0">
                                <img src="${ch.avatar || 'https://ui-avatars.com/api/?name='+encodeURIComponent(ch.name)+'&background=2a3942&color=fff'}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0 flex flex-col justify-center border-b border-[#202c33] pb-3 -mb-3 group-last:border-none group-last:pb-0 group-last:-mb-0">
                                <div class="flex justify-between items-center">
                                    <div class="flex flex-col min-w-0 pr-2">
                                        <div class="flex items-center gap-1">
                                            <h3 class="text-[#e9edef] text-[16px] font-normal truncate">${ch.name}</h3>
                                            <svg viewBox="0 0 16 16" width="14" height="14" fill="#00a884" class="shrink-0">
                                                <path d="M8 0l2.5 1.5L13.5 1 15 3.5 16 6l-1.5 2.5L16 11l-1.5 2.5L12 15l-3-1.5L6 15l-2.5-1.5L1 11 0 8.5 1.5 6 0 3.5 1.5 1 4.5 1 7 0z"/><path d="M6.5 11L3 7.5l1-1 2.5 2.5 5-5 1 1-6 6z" fill="#fff"/>
                                            </svg>
                                        </div>
                                        <p class="text-[#8696a0] text-[13px] truncate">${followersStr}</p>
                                    </div>
                                    ${actionHtml}
                                </div>
                            </div>
                        </div>
                    `;
                    
                    // Just split them randomly for visual effect
                    if (exploreCount < 4) {
                        exploreHtml += chHtml;
                        exploreCount++;
                    } else {
                        entertainmentHtml += chHtml;
                        entertainmentCount++;
                    }
                });
                
                if (exploreCount > 0) {
                    html += `
                        <div class="mt-2 category-section">
                            <div class="flex items-center justify-between px-4 py-2">
                                <h2 class="text-[#e9edef] text-[15px] font-medium">Explore channels</h2>
                                <button class="text-[#00a884] hover:text-[#008f72] text-[13px] font-medium transition-colors">See all</button>
                            </div>
                            <div class="flex flex-col category-list">${exploreHtml}</div>
                        </div>
                    `;
                }
                
                if (entertainmentCount > 0) {
                    html += `
                        <div class="mt-4 category-section">
                            <div class="flex items-center justify-between px-4 py-2">
                                <h2 class="text-[#e9edef] text-[15px] font-medium">Entertainment</h2>
                                <button class="text-[#00a884] hover:text-[#008f72] text-[13px] font-medium transition-colors">See all</button>
                            </div>
                            <div class="flex flex-col category-list">${entertainmentHtml}</div>
                        </div>
                    `;
                }
                
                if (exploreCount === 0 && entertainmentCount === 0) {
                    html = '<div class="p-4 text-center text-[#8696a0] text-sm">No channels found.</div>';
                }
                
                listContainer.innerHTML = html;
                window.filterFindChannels(); // Re-apply filter if any
            });
        };

        window.filterChannels = function() {
            const val = document.getElementById('channels_search_input').value.toLowerCase();
            // Implement simple client-side filter
            const lists = [document.getElementById('my_channels_list'), document.getElementById('discover_channels_list')];
            lists.forEach(list => {
                if(!list) return;
                const items = list.querySelectorAll('.cursor-pointer');
                items.forEach(item => {
                    const name = item.querySelector('h3').innerText.toLowerCase();
                    if (name.includes(val)) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        };

        window.openChannel = function(channelId) {
            // Clear unread count
            if (window.channelUnreadCounts && window.channelUnreadCounts[channelId]) {
                window.channelUnreadCounts[channelId] = 0;
                localStorage.setItem('channelUnreadCounts', JSON.stringify(window.channelUnreadCounts));
                const badge = document.getElementById(`channel_unread_badge_${channelId}`);
                if (badge) {
                    badge.textContent = '0';
                    badge.classList.add('hidden');
                    badge.classList.remove('flex');
                }
            }

            // Hide empty state, show active view
            document.getElementById('channel_empty_state').classList.add('hidden');
            document.getElementById('active_channel_view').classList.remove('hidden');
            document.getElementById('active_channel_view').classList.add('flex');
            
            const chRef = ref(db, 'channels/' + channelId);
            onValue(chRef, (snapshot) => {
                const ch = snapshot.val();
                if(!ch) return;
                window.currentChannel = ch;
                
                document.getElementById('current_channel_name').innerText = ch.name;
                const fCount = ch.followers_count || 0;
                document.getElementById('current_channel_followers').innerText = fCount + " follower" + (fCount !== 1 ? 's' : '');
                document.getElementById('current_channel_avatar').src = ch.avatar || 'https://ui-avatars.com/api/?name='+encodeURIComponent(ch.name)+'&background=2a3942&color=fff';
                
                const isFollowing = ch.followers && ch.followers[window.myUserId];
                const isAdmin = ch.admins && ch.admins[window.myUserId];
                const isPendingAdmin = ch.pending_admins && ch.pending_admins[window.myUserId];
                
                if (isPendingAdmin) {
                    document.getElementById('pending_admin_accept_banner')?.classList.remove('hidden');
                    document.getElementById('pending_admin_accept_banner')?.classList.add('flex');
                } else {
                    document.getElementById('pending_admin_accept_banner')?.classList.add('hidden');
                    document.getElementById('pending_admin_accept_banner')?.classList.remove('flex');
                }

                if(isAdmin) {
                    document.getElementById('btn_mute_channel')?.classList.add('hidden');
                    document.getElementById('channel_menu_unfollow')?.classList.add('hidden');
                    document.getElementById('channel_input_area').classList.remove('hidden');
                    document.getElementById('channel_follower_banner').classList.add('hidden');
                } else {
                    if(isFollowing) {
                        document.getElementById('btn_mute_channel')?.classList.remove('hidden');
                        document.getElementById('channel_menu_unfollow')?.classList.remove('hidden');
                        
                        document.getElementById('channel_input_area').classList.add('hidden');
                        document.getElementById('channel_follower_banner').classList.add('hidden');
                    } else {
                        document.getElementById('btn_mute_channel')?.classList.add('hidden');
                        document.getElementById('channel_menu_unfollow')?.classList.add('hidden');

                        document.getElementById('channel_input_area').classList.add('hidden');
                        document.getElementById('channel_follower_banner').classList.remove('hidden');
                    }
                }
                
                const sidebar = document.getElementById('channel_info_sidebar');
                if (sidebar && !sidebar.classList.contains('hidden') && !sidebar.classList.contains('translate-x-full')) {
                    if (typeof window.populateChannelInfo === 'function') {
                        window.populateChannelInfo();
                    }
                }
                
                window.loadChannelMessages(channelId);
            });
        };

        window.acceptAdminInvite = function() {
            if(!window.currentChannel) return;
            const chId = window.currentChannel.id;
            const updates = {};
            updates[`channels/${chId}/pending_admins/${window.myUserId}`] = null;
            updates[`channels/${chId}/admins/${window.myUserId}`] = true;
            updates[`channels/${chId}/followers/${window.myUserId}`] = true;
            
            window.firebaseUpdate(window.firebaseRef(window.db, '/'), updates).then(() => {
                window.showToast?.('Invite Accepted', 'You are now an admin');
            });
        };

        window.showAdminInviteModal = function(channelId, channelName, channelAvatar) {
            window.pendingInviteChannelId = channelId;
            const modal = document.getElementById('admin_invite_modal');
            const modalContent = document.getElementById('admin_invite_modal_content');
            
            document.getElementById('admin_invite_modal_name').innerText = channelName;
            document.getElementById('admin_invite_modal_avatar').src = channelAvatar || 'https://ui-avatars.com/api/?name='+encodeURIComponent(channelName)+'&background=2a3942&color=fff';

            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('translate-y-full');
            }, 10);
        };

        window.closeAdminInviteModal = function() {
            const modal = document.getElementById('admin_invite_modal');
            const modalContent = document.getElementById('admin_invite_modal_content');
            
            modalContent.classList.add('translate-y-full');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        };

        window.acceptAdminInviteAndOpen = function() {
            if(!window.pendingInviteChannelId) return;
            const chId = window.pendingInviteChannelId;
            const updates = {};
            updates[`channels/${chId}/pending_admins/${window.myUserId}`] = null;
            updates[`channels/${chId}/admins/${window.myUserId}`] = true;
            updates[`channels/${chId}/followers/${window.myUserId}`] = true;
            
            window.firebaseUpdate(window.firebaseRef(window.db, '/'), updates).then(() => {
                window.closeAdminInviteModal();
                window.showChannels();
                setTimeout(() => {
                    window.openChannel(chId);
                }, 300);
            });
        };

        window.viewChannelFromInvite = function() {
            if(!window.pendingInviteChannelId) return;
            const chId = window.pendingInviteChannelId;
            window.closeAdminInviteModal();
            window.showChannels();
            setTimeout(() => {
                window.openChannel(chId);
            }, 300);
        };

        window.loadChannelMessages = function(channelId) {
            const msgsList = document.getElementById('channel_messages_list');
            msgsList.innerHTML = '';
            
            // Clear global messages for search compatibility
            window.globalMessages = {};
            
            const isAdmin = window.currentChannel && window.currentChannel.admins && window.currentChannel.admins[window.myUserId];
            const adminBanner = document.getElementById('admin_empty_state_banner');
            
            if(isAdmin) {
                adminBanner.classList.remove('hidden');
                adminBanner.classList.add('flex');
                document.getElementById('admin_empty_state_title').innerText = "Start growing '" + window.currentChannel.name + "'";
            } else {
                adminBanner.classList.add('hidden');
                adminBanner.classList.remove('flex');
            }
            
            let hasRealMessages = false;
            let lastDateString = null;
            
            const messagesRef = ref(db, `channels/${channelId}/messages`);
            onChildAdded(messagesRef, (data) => {
                const msg = data.val();
                
                // Store in globalMessages for search functionality
                window.globalMessages[data.key] = msg;
                
                // Date Header Logic
                if (window.getDateHeader && msg.time) {
                    const dateHeader = window.getDateHeader(msg.time);
                    if (dateHeader !== lastDateString) {
                        lastDateString = dateHeader;
                        const headerDiv = document.createElement('div');
                        headerDiv.className = "flex justify-center w-full my-3 sticky top-0 z-[5] pointer-events-none";
                        headerDiv.innerHTML = `
                            <div class="bg-[#182229]/90 backdrop-blur-sm text-[#8696a0] text-[11px] px-3 py-1 rounded-lg shadow-sm font-medium uppercase tracking-wider border border-[#202c33] pointer-events-auto">
                                ${dateHeader}
                            </div>`;
                        msgsList.appendChild(headerDiv);
                    }
                }
                
                // Construct bubble
                const div = document.createElement('div');
                div.className = "flex w-full mt-2 space-x-3 max-w-xl mx-auto";
                
                let contentHtml = '';
                if(msg.type === 'image' && msg.fileUrl) {
                    hasRealMessages = true;
                    contentHtml = `<img src="${msg.fileUrl}" class="rounded-lg mb-2 max-w-full cursor-pointer hover:opacity-90" onclick="window.openGlobalMediaModal('${msg.fileUrl}')">`;
                    if(msg.text) contentHtml += `<p class="text-[#e9edef] text-[15px] leading-relaxed">${msg.text}</p>`;
                } else if(msg.type === 'video' && msg.fileUrl) {
                    hasRealMessages = true;
                    contentHtml = `<video src="${msg.fileUrl}" controls class="rounded-lg mb-2 max-w-full max-h-[300px] bg-black"></video>`;
                    if(msg.text) contentHtml += `<p class="text-[#e9edef] text-[15px] leading-relaxed">${msg.text}</p>`;
                } else if(msg.type === 'audio' && msg.fileUrl) {
                    hasRealMessages = true;
                    contentHtml = `<audio src="${msg.fileUrl}" controls class="w-[250px] mb-2"></audio>`;
                    if(msg.text) contentHtml += `<p class="text-[#e9edef] text-[15px] leading-relaxed">${msg.text}</p>`;
                } else if(msg.type === 'document' && msg.fileUrl) {
                    hasRealMessages = true;
                    contentHtml = `
                        <div class="flex items-center gap-3 bg-black/20 p-3 rounded-lg mb-2 cursor-pointer hover:bg-black/30 transition-colors" onclick="window.open('${msg.fileUrl}', '_blank')">
                            <div class="w-10 h-10 rounded bg-[#5f66cd] flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                            </div>
                            <div class="flex flex-col min-w-0">
                                <span class="text-[#e9edef] font-medium text-sm truncate">${msg.fileName || 'Document'}</span>
                                <span class="text-[#8696a0] text-xs">${msg.fileSize || ''}</span>
                            </div>
                        </div>
                    `;
                    if(msg.text) contentHtml += `<p class="text-[#e9edef] text-[15px] leading-relaxed">${msg.text}</p>`;
                } else if(msg.type === 'system') {
                    div.className = "flex justify-center w-full mt-4 mb-2 px-4";
                    // Custom pill for system messages
                    div.innerHTML = `<div class="bg-[#202c33] text-[#8696a0] text-[12.5px] px-4 py-1.5 rounded-[10px] shadow-sm border border-[#313d45] flex items-center justify-center max-w-full">${msg.text}</div>`;
                    msgsList.appendChild(div);
                    document.getElementById('channel_messages_area').scrollTop = document.getElementById('channel_messages_area').scrollHeight;
                    return;
                } else {
                    hasRealMessages = true;
                    contentHtml = `<p class="text-[#e9edef] text-[15px] leading-relaxed break-words whitespace-pre-wrap">${msg.text}</p>`;
                }
                
                const timeStr = new Date(msg.time * 1000).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

                div.className = "flex w-full mt-2 justify-start pr-12";
                div.id = 'msg_' + data.key;
                
                div.innerHTML = `
                    <div class="flex flex-col w-full relative">
                        <div class="bg-[#005c4b] rounded-xl px-2 py-1 shadow-sm relative min-w-[120px] pb-5 group">
                            <div class="px-1 pt-1">
                                ${contentHtml}
                            </div>
                            <div class="flex items-center justify-between mt-1 absolute bottom-1 right-2 left-2">
                                <button class="text-[#8696a0] hover:text-[#e9edef] transition-colors">
                                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M10.74 5.253a.835.835 0 0 0-1.285.7l-.004 3.018c-3.791.246-6.425 2.502-7.391 5.485-.29.897.669 1.636 1.343.914 1.488-1.594 3.078-2.308 6.046-2.508v3.136a.835.835 0 0 0 1.286.7l5.918-4.167a.833.833 0 0 0 0-1.365l-5.913-4.913z"></path></svg>
                                </button>
                                <div class="flex items-center gap-1">
                                    <span class="text-[#8696a0] text-[11px] leading-none">${timeStr}</span>
                                    <svg viewBox="0 0 16 16" width="15" height="15" fill="#53bdeb"><path d="M11.5 3.5L6 9l-2-2-1 1 3 3 6.5-6.5-1-1zm3 0L9 9l-1-1 1-1 4.5-4.5 1 1zM4 9l1 1-3 3-1-1 3-3z"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                msgsList.appendChild(div);
                document.getElementById('channel_messages_area').scrollTop = document.getElementById('channel_messages_area').scrollHeight;
            });
        };

        window.submitCreateChannel = async function() {
            const name = document.getElementById('new_channel_name').value.trim();
            const desc = document.getElementById('new_channel_desc').value.trim();
            const avatarFile = document.getElementById('new_channel_avatar_input').files[0];
            
            const btn = document.getElementById('btn_create_channel_submit');
            if(btn.classList.contains('cursor-not-allowed')) return;
            
            btn.innerHTML = '<svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>';
            btn.classList.add('cursor-not-allowed');

            try {
                const channelId = 'channel_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
                let avatarUrl = null;

                if (avatarFile) {
                    const formData = new FormData();
                    formData.append('avatar', avatarFile);
                    
                    const uploadRes = await fetch('/channel/upload-avatar', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': window.csrf
                        },
                        body: formData
                    });
                    
                    const jsonRes = await uploadRes.json();
                    if(jsonRes.status) {
                        avatarUrl = jsonRes.url;
                    } else {
                        throw new Error(jsonRes.message || "Failed to upload avatar");
                    }
                }

                const nowTs = Math.floor(Date.now() / 1000);
                const channelData = {
                    id: channelId,
                    name: name,
                    description: desc,
                    avatar: avatarUrl || '',
                    created_by: window.myUserId,
                    created_at: nowTs,
                    updated_at: nowTs,
                    followers_count: 1,
                    followers: {},
                    admins: {},
                    is_channel: true
                };
                channelData.followers[window.myUserId] = true;
                channelData.admins[window.myUserId] = true;

                await set(ref(db, `channels/${channelId}`), channelData);

                // Push initial message
                const msgsRef = push(ref(db, `channels/${channelId}/messages`));
                await set(msgsRef, {
                    text: 'Channel created',
                    sender_id: window.myUserId,
                    time: nowTs,
                    type: 'system'
                });

                // Reset form
                document.getElementById('new_channel_name').value = '';
                document.getElementById('new_channel_desc').value = '';
                document.getElementById('new_channel_avatar_input').value = '';
                document.getElementById('new_channel_avatar_preview').classList.add('hidden');
                document.getElementById('new_channel_avatar_preview').src = '';
                document.getElementById('new_channel_avatar_placeholder').classList.remove('hidden');
                
                window.closeCreateChannelModal();
                window.openChannel(channelId);
            } catch(err) {
                console.error(err);
                alert("Failed to create channel: " + err.message);
            } finally {
                btn.innerHTML = 'Create channel';
                window.validateChannelForm();
            }
        };

        window.toggleFollowChannel = async function() {
            if(!window.currentChannel) return;
            const ch = window.currentChannel;
            const isFollowing = ch.followers && ch.followers[window.myUserId];
            const url = isFollowing ? `/channel/${ch.id}/unfollow` : `/channel/${ch.id}/follow`;
            
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                const res = await response.json();
                if(!res.status) alert(res.message);
            } catch(err) {
                console.error(err);
            }
        };

        window.toggleFollowFromList = async function(channelId) {
            try {
                const response = await fetch(`/channel/${channelId}/follow`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                const res = await response.json();
                if(res.status) {
                    window.openChannel(channelId);
                } else {
                    alert(res.message);
                }
            } catch(err) {
                console.error(err);
            }
        };

        let selectedChannelFile = null;
        window.handleChannelAttachment = function(input) {
            if(input.files && input.files[0]) {
                selectedChannelFile = input.files[0];
                document.getElementById('channel_message_input').placeholder = "Add a caption for " + selectedChannelFile.name;
            }
        };

        window.sendChannelMessage = async function() {
            if(!window.currentChannel) return;
            const textInput = document.getElementById('channel_message_input');
            const text = textInput.value.trim();
            const chId = window.currentChannel.id;
            
            if(!text && !selectedChannelFile) return;

            const time = Math.floor(Date.now() / 1000);
            const msgData = {
                sender_id: window.myUserId,
                time: time,
                type: 'text',
                text: text
            };

            // Reset UI
            textInput.value = '';
            textInput.style.height = '';
            textInput.placeholder = "Type an update";
            const fileToUpload = selectedChannelFile;
            selectedChannelFile = null;
            document.getElementById('channel_attachment_input').value = '';

            if(fileToUpload) {
                if(fileToUpload.type.startsWith('video/')) msgData.type = 'video';
                else if(fileToUpload.type.startsWith('audio/')) msgData.type = 'audio';
                else if(fileToUpload.type.startsWith('image/')) msgData.type = 'image';
                else msgData.type = 'document';
                
                msgData.fileName = fileToUpload.name;
                msgData.fileSize = (fileToUpload.size / (1024*1024)).toFixed(2) + ' MB';
                
                const formData = new FormData();
                formData.append('file', fileToUpload);

                fetch('/channel/upload-message-media', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': window.csrf },
                    body: formData
                }).then(res => res.json()).then(json => {
                    if (json.status) {
                        msgData.fileUrl = json.url;
                        push(ref(db, `channels/${chId}/messages`), msgData);
                        
                        let lastMsgText = '📄 Document';
                        if(msgData.type === 'image') lastMsgText = '📸 Photo';
                        else if(msgData.type === 'video') lastMsgText = '🎥 Video';
                        else if(msgData.type === 'audio') lastMsgText = '🎵 Audio';
                        
                        if(text) lastMsgText = text.substring(0, 50);

                        update(ref(db, `channels/${chId}`), { last_message: lastMsgText });
                    } else {
                        console.error("Upload failed", json.message);
                        alert("Failed to upload media");
                    }
                }).catch(err => {
                    console.error("Upload failed", err);
                    alert("Failed to upload media");
                });
            } else {
                push(ref(db, `channels/${chId}/messages`), msgData);
                // Update last message
                update(ref(db, `channels/${chId}`), { last_message: text.substring(0, 50) });
            }
        };
</script>
