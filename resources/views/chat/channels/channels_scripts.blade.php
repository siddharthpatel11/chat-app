<script type="module">
    import {
        ref,
        set,
        push,
        onChildAdded,
        onValue,
        remove,
        update,
        get
    } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-database.js";
    import {
        ref as storageRef,
        uploadBytesResumable,
        getDownloadURL
    } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-storage.js";

    window.currentChannel = null;
    window.myUserId = '{{ auth()->id() }}';

    // Ensure db and storage are loaded from index.blade.php's global context
    const db = window.db;
    const storage = window.storage;

    // Track unread counts and last messages
    try {
        window.channelUnreadCounts = JSON.parse(localStorage.getItem('channelUnreadCounts')) || {};
    } catch (e) {
        window.channelUnreadCounts = {};
    }
    window.prevChannelLastMessage = {};

    // Attach firebase methods to window for use in non-module scripts
    window.firebaseGet = get;
    window.firebaseRef = ref;
    window.firebaseUpdate = update;
    window.firebasePush = push;
    window.firebaseSet = set;

    window.loadMyChannels = function() {
        window.getChannelDateHeader = function(timestamp) {
            if (!timestamp) return '';
            const date = new Date(timestamp * 1000);
            const now = new Date();
            const isSameDay = (d1, d2) => d1.getDate() === d2.getDate() && d1.getMonth() === d2.getMonth() && d1.getFullYear() === d2.getFullYear();
            const yesterday = new Date(now);
            yesterday.setDate(now.getDate() - 1);

            if (isSameDay(date, now)) {
                let hours = date.getHours();
                const minutes = date.getMinutes().toString().padStart(2, '0');
                const ampm = hours >= 12 ? 'pm' : 'am';
                hours = hours % 12 || 12;
                return `${hours}:${minutes} ${ampm}`;
            } else if (isSameDay(date, yesterday)) {
                return 'Yesterday';
            } else {
                return date.toLocaleDateString([], { day: '2-digit', month: '2-digit', year: 'numeric' });
            }
        };

        const myChannelsList = document.getElementById('my_channels_list');
        myChannelsList.innerHTML =
            '<div class="p-4 text-center text-[#8696a0] text-sm">Loading your channels...</div>';

        const channelsRef = ref(db, 'channels');
        onValue(channelsRef, (snapshot) => {
            let html = '';
            let hasChannels = false;
            const channelsArr = [];

            snapshot.forEach((childSnapshot) => {
                const ch = childSnapshot.val();
                channelsArr.push(ch);

                // Check for new messages
                const currentUpdate = ch.updated_at || ch.created_at || 0;

                if (typeof window.prevChannelLastMessage[ch.id] !== 'undefined' && window
                    .prevChannelLastMessage[ch.id] < currentUpdate) {
                    if (!window.currentChannel || window.currentChannel.id !== ch.id) {
                        if ((ch.followers && ch.followers[window.myUserId]) || (ch.admins && ch
                                .admins[window.myUserId])) {
                            window.channelUnreadCounts[ch.id] = (window.channelUnreadCounts[ch
                                .id] || 0) + 1;
                            localStorage.setItem('channelUnreadCounts', JSON.stringify(window
                                .channelUnreadCounts));

                            const title = ch.name;
                            const body = ch.last_message || 'New update';

                            if (window.showToast) {
                                window.showToast(title, body, ch.id, title);
                            }

                            if (typeof Notification !== 'undefined' && Notification.permission ===
                                "granted" && document.visibilityState !== 'visible') {
                                new Notification(title, {
                                    body: body,
                                    icon: ch.avatar || 'https://ui-avatars.com/api/?name=' +
                                        encodeURIComponent(ch.name) +
                                        '&background=2a3942&color=fff'
                                });
                            }
                        }
                    }
                }
                window.prevChannelLastMessage[ch.id] = currentUpdate;
            });

            // Sort descending by created_at or id
            channelsArr.sort((a, b) => {
                const timeA = a.created_at || 0;
                const timeB = b.created_at || 0;
                return timeB - timeA;
            });

            channelsArr.forEach((ch) => {
                if ((ch.followers && ch.followers[window.myUserId]) || (ch.admins && ch.admins[
                        window.myUserId])) {
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
                                        <span class="text-[#8696a0] text-[12px] whitespace-nowrap ml-2">${window.getChannelDateHeader(ch.updated_at || ch.created_at || 0)}</span>
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
                html =
                    '<div class="p-4 text-center text-[#8696a0] text-sm">You are not following any channels yet.</div>';
            }
            myChannelsList.innerHTML = html;
        });
    };

    window.loadDiscoverChannels = function() {
        document.getElementById('discover_channels_list').classList.remove('hidden');
        const discoverList = document.getElementById('discover_channels_list');
        discoverList.innerHTML =
            '<div class="p-4 text-center text-[#8696a0] text-sm">Loading channels to discover...</div>';

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
                                                ${ch.followers ? Object.keys(ch.followers).length : 0} follower${(ch.followers ? Object.keys(ch.followers).length : 0) !== 1 ? 's' : ''}
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
                html +=
                    '<div class="p-4 text-center text-[#8696a0] text-sm">No new channels to discover.</div>';
            }
            discoverList.innerHTML = html;
        });
    };

    window.loadFindChannelsCategories = function() {
        const listContainer = document.getElementById('find_channels_explore_list');
        if (!listContainer) return;

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
                const followersCount = ch.followers ? Object.keys(ch.followers).length : 0;
                const followersStr = followersCount + ' follower' + (followersCount !== 1 ? 's' :
                    '');

                const actionHtml = isFollowing ?
                    `<div class="px-5 py-1.5 text-sm font-medium text-[#8696a0] shrink-0">Following</div>` :
                    `<button onclick="event.stopPropagation(); window.toggleFollowFromList('${ch.id}')" class="bg-[#0a332c] text-[#00a884] hover:bg-[#00a884] hover:text-[#111b21] px-5 py-1.5 rounded-full text-sm font-medium transition-colors shrink-0">Follow</button>`;

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
        const lists = [document.getElementById('my_channels_list'), document.getElementById(
            'discover_channels_list')];
        lists.forEach(list => {
            if (!list) return;
            const items = list.querySelectorAll('.cursor-pointer');
            items.forEach(item => {
                const h3 = item.querySelector('h3');
                if (!h3) return;
                const name = h3.innerText.toLowerCase();
                if (name.includes(val)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    };

    window.backToChannelSidebar = function() {
        document.getElementById('channels_sidebar_container')?.classList.remove('hidden');
        document.getElementById('channels_sidebar_container')?.classList.add('flex', 'w-full');
        document.getElementById('channels_main_column')?.classList.add('hidden');
        document.getElementById('channels_main_column')?.classList.remove('flex');
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

        // On mobile, hide sidebar and show main column
        if (window.innerWidth < 640) {
            document.getElementById('channels_sidebar_container')?.classList.add('hidden');
            document.getElementById('channels_sidebar_container')?.classList.remove('flex');
            document.getElementById('channels_main_column')?.classList.remove('hidden');
            document.getElementById('channels_main_column')?.classList.add('flex');
        }

        const chRef = ref(db, 'channels/' + channelId);
        onValue(chRef, (snapshot) => {
            const ch = snapshot.val();
            if (!ch) return;
            window.currentChannel = ch;

            document.getElementById('current_channel_name').innerText = ch.name;
            const fCount = ch.followers ? Object.keys(ch.followers).length : 0;
            document.getElementById('current_channel_followers').innerText = fCount + " follower" + (
                fCount !== 1 ? 's' : '');
            document.getElementById('current_channel_avatar').src = ch.avatar ||
                'https://ui-avatars.com/api/?name=' + encodeURIComponent(ch.name) +
                '&background=2a3942&color=fff';
            
            if (typeof window.updateChannelMuteIcon === 'function') {
                window.updateChannelMuteIcon(channelId);
            }

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

            if (isAdmin) {
                document.getElementById('btn_mute_channel')?.classList.add('hidden');
                document.getElementById('channel_menu_unfollow')?.classList.add('hidden');
                document.getElementById('channel_input_area').classList.remove('hidden');
                document.getElementById('channel_follower_banner').classList.add('hidden');
            } else {
                if (isFollowing) {
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
            if (sidebar && !sidebar.classList.contains('hidden') && !sidebar.classList.contains(
                    'translate-x-full')) {
                if (typeof window.populateChannelInfo === 'function') {
                    window.populateChannelInfo();
                }
            }

            window.loadChannelMessages(channelId);
        });
    };

    window.acceptAdminInvite = function() {
        if (!window.currentChannel) return;
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
        document.getElementById('admin_invite_modal_avatar').src = channelAvatar ||
            'https://ui-avatars.com/api/?name=' + encodeURIComponent(channelName) + '&background=2a3942&color=fff';

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
        if (!window.pendingInviteChannelId) return;
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
        if (!window.pendingInviteChannelId) return;
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

        const isAdmin = window.currentChannel && window.currentChannel.admins && window.currentChannel.admins[window
            .myUserId];
        const adminBanner = document.getElementById('admin_empty_state_banner');

        if (isAdmin) {
            adminBanner.classList.remove('hidden');
            adminBanner.classList.add('flex');
            document.getElementById('admin_empty_state_title').innerText = "Start growing '" + window.currentChannel
                .name + "'";
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
                    headerDiv.className =
                        "flex justify-center w-full my-3 sticky top-0 z-[5] pointer-events-none";
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
            div.id = 'channel_msg_' + data.key;

            let contentHtml = '';
            if (msg.type === 'image' && msg.fileUrl) {
                hasRealMessages = true;
                contentHtml =
                    `<img src="${msg.fileUrl}" class="rounded-lg mb-2 max-w-full cursor-pointer hover:opacity-90" onclick="window.openGlobalMediaModal('${msg.fileUrl}')">`;
                if (msg.text) contentHtml +=
                    `<p class="text-[#e9edef] text-[15px] leading-relaxed">${window.formatMessageText ? window.formatMessageText(msg.text) : msg.text}</p>`;
            } else if (msg.type === 'video' && msg.fileUrl) {
                hasRealMessages = true;
                contentHtml =
                    `<video src="${msg.fileUrl}" controls class="rounded-lg mb-2 max-w-full max-h-[300px] bg-black"></video>`;
                if (msg.text) contentHtml +=
                    `<p class="text-[#e9edef] text-[15px] leading-relaxed">${window.formatMessageText ? window.formatMessageText(msg.text) : msg.text}</p>`;
            } else if (msg.type === 'audio' && msg.fileUrl) {
                hasRealMessages = true;
                contentHtml = `<audio src="${msg.fileUrl}" controls class="w-[250px] mb-2"></audio>`;
                if (msg.text) contentHtml +=
                    `<p class="text-[#e9edef] text-[15px] leading-relaxed">${window.formatMessageText ? window.formatMessageText(msg.text) : msg.text}</p>`;
            } else if (msg.type === 'document' && msg.fileUrl) {
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
                if (msg.text) contentHtml +=
                    `<p class="text-[#e9edef] text-[15px] leading-relaxed">${window.formatMessageText ? window.formatMessageText(msg.text) : msg.text}</p>`;
            } else if (msg.type === 'system') {
                div.className = "flex justify-center w-full mt-4 mb-2 px-4";
                // Custom pill for system messages
                div.innerHTML =
                    `<div class="bg-[#202c33] text-[#8696a0] text-[12.5px] px-4 py-1.5 rounded-[10px] shadow-sm border border-[#313d45] flex items-center justify-center max-w-full">${msg.text}</div>`;
                msgsList.appendChild(div);
                document.getElementById('channel_messages_area').scrollTop = document.getElementById(
                    'channel_messages_area').scrollHeight;
                return;
            } else {
                hasRealMessages = true;
                
                let parsedText = window.formatMessageText ? window.formatMessageText(msg.text) : msg.text;

                contentHtml = `<p class="text-[#e9edef] text-[15px] leading-relaxed whitespace-pre-wrap">${parsedText}</p>`;
            }

            const timeStr = new Date(msg.time * 1000).toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });

            div.className =
                `flex w-full mt-2 justify-start pr-12 relative cursor-pointer channel-msg-row ${isAdmin ? 'admin-view' : ''}`;
            div.id = 'msg_' + data.key;
            div.setAttribute('onclick', `window.toggleChannelMsgSelection('${data.key}')`);

            div.innerHTML = `
                    <!-- Selection Checkbox -->
                    <div class="channel-msg-checkbox-container hidden flex-col justify-center px-3 z-10 w-11 shrink-0">
                        <div class="w-5 h-5 border-2 border-gray-400 rounded-md flex items-center justify-center bg-white relative">
                            <input type="checkbox" id="channel_checkbox_${data.key}" class="channel-msg-checkbox opacity-0 absolute w-5 h-5 pointer-events-none">
                            <svg class="w-4 h-4 text-white pointer-events-none transition-opacity opacity-0 check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                    <style>#channel_checkbox_${data.key}:checked + svg { opacity: 1; }</style>

                    <div class="flex flex-col w-full relative">
                        <div id="bubble_${data.key}" class="bg-[#005c4b] rounded-xl px-2 py-1 shadow-sm relative min-w-[120px] pb-5 group">
                            <!-- Options Button (WhatsApp Style) -->
                            <div class="absolute top-0 right-0 opacity-0 group-hover:opacity-100 transition-opacity z-10 bg-gradient-to-l from-[#005c4b] via-[#005c4b] to-transparent pl-3 pr-1 pt-1 rounded-tr-xl">
                                <button onclick="event.stopPropagation(); window.toggleMsgMenu('${data.key}')" class="text-[#8696a0] hover:text-[#e9edef] focus:outline-none transition-colors">
                                    <svg viewBox="0 0 19 20" width="19" height="20" fill="currentColor">
                                        <path d="M3.8 6.7l5.7 5.7 5.7-5.7 1.6 1.6-7.3 7.2-7.3-7.2 1.6-1.6z"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Menu Container with Reaction Strip -->
                            <div id="menu_${data.key}" class="hidden absolute top-8 right-0 z-[50] flex flex-col items-end gap-1.5 transform transition-all duration-200">
                                <!-- Reaction Strip -->
                                <div class="bg-[#233138] rounded-full px-2 py-1.5 flex items-center gap-1 shadow-2xl border border-[#313d45] w-max">
                                    <button onclick="event.stopPropagation(); window.sendReaction('👍', '${data.key}', false, event, true); window.toggleMsgMenu('${data.key}')" class="w-8 h-8 flex items-center justify-center text-lg hover:bg-white/10 rounded-full transition-transform hover:scale-125"><span class="emoji-text">👍</span></button>
                                    <button onclick="event.stopPropagation(); window.sendReaction('❤️', '${data.key}', false, event, true); window.toggleMsgMenu('${data.key}')" class="w-8 h-8 flex items-center justify-center text-lg hover:bg-white/10 rounded-full transition-transform hover:scale-125"><span class="emoji-text">❤️</span></button>
                                    <button onclick="event.stopPropagation(); window.sendReaction('😂', '${data.key}', false, event, true); window.toggleMsgMenu('${data.key}')" class="w-8 h-8 flex items-center justify-center text-lg hover:bg-white/10 rounded-full transition-transform hover:scale-125"><span class="emoji-text">😂</span></button>
                                    <button onclick="event.stopPropagation(); window.sendReaction('😮', '${data.key}', false, event, true); window.toggleMsgMenu('${data.key}')" class="w-8 h-8 flex items-center justify-center text-lg hover:bg-white/10 rounded-full transition-transform hover:scale-125"><span class="emoji-text">😮</span></button>
                                    <button onclick="event.stopPropagation(); window.sendReaction('😢', '${data.key}', false, event, true); window.toggleMsgMenu('${data.key}')" class="w-8 h-8 flex items-center justify-center text-lg hover:bg-white/10 rounded-full transition-transform hover:scale-125"><span class="emoji-text">😢</span></button>
                                    <button onclick="event.stopPropagation(); window.sendReaction('🙏', '${data.key}', false, event, true); window.toggleMsgMenu('${data.key}')" class="w-8 h-8 flex items-center justify-center text-lg hover:bg-white/10 rounded-full transition-transform hover:scale-125"><span class="emoji-text">🙏</span></button>
                                    <button onclick="event.stopPropagation(); window.openFullReactionPicker('${data.key}', false, event, true); window.toggleMsgMenu('${data.key}')" class="w-8 h-8 flex items-center justify-center text-[18px] text-[#aebac1] hover:bg-white/10 rounded-full transition-transform hover:scale-125 bg-white/5 ml-1">
                                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path></svg>
                                    </button>
                                </div>
                                <!-- Dropdown List -->
                                <div class="bg-[#233138] shadow-2xl border border-[#313d45] rounded-xl w-44 py-1 overflow-hidden flex-shrink-0 text-left">
                                    <button onclick="event.stopPropagation(); window.copyChannelMsg('${data.key}'); window.toggleMsgMenu('${data.key}')" class="w-full text-left px-4 py-2 text-sm text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors">Copy <svg class="w-4 h-4 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg></button>
                                    <button onclick="event.stopPropagation(); window.forwardChannelMsg('${data.key}'); window.toggleMsgMenu('${data.key}')" class="w-full text-left px-4 py-2 text-sm text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors">Forward <svg class="w-4 h-4 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></button>
                                    <button onclick="event.stopPropagation(); window.askMetaAiChannel('${data.key}', '${window.btoa(encodeURIComponent(data.text || ''))}'); window.toggleMsgMenu('${data.key}')" class="w-full text-left px-4 py-2 text-sm text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors">Ask Meta AI <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8696a0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M12 8a4 4 0 0 1 4 4c0 2.21-1.79 4-4 4s-4-1.79-4-4a4 4 0 0 1 4-4z" class="fill-[#8696a0]"></path></svg></button>
                                    <button onclick="event.stopPropagation(); window.startChannelMsgSelection('${data.key}'); window.toggleMsgMenu('${data.key}')" class="w-full text-left px-4 py-2 text-sm text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors">Select <svg class="w-4 h-4 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></button>
                                    ${isAdmin ? `
                                    <div class="h-px bg-[#313d45] my-1 mx-2"></div>
                                    <button onclick="event.stopPropagation(); window.deleteChannelSingleMsg('${data.key}'); window.toggleMsgMenu('${data.key}')" class="w-full text-left px-4 py-2 text-sm text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors">Delete <svg class="w-4 h-4 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                    ` : ''}
                                </div>
                            </div>
                            <div class="px-1 pt-1">
                                ${contentHtml}
                            </div>
                            <div class="flex items-center justify-between mt-1 absolute bottom-1 right-2 left-2">
                                <button class="text-[#8696a0] hover:text-[#e9edef] transition-colors" onclick="event.stopPropagation(); window.forwardChannelMsg('${data.key}')">
                                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M10.74 5.253a.835.835 0 0 0-1.285.7l-.004 3.018c-3.791.246-6.425 2.502-7.391 5.485-.29.897.669 1.636 1.343.914 1.488-1.594 3.078-2.308 6.046-2.508v3.136a.835.835 0 0 0 1.286.7l5.918-4.167a.833.833 0 0 0 0-1.365l-5.913-4.913z"></path></svg>
                                </button>
                                <div class="flex items-center gap-1">
                                    <span class="text-[#8696a0] text-[11px] leading-none">${timeStr}</span>
                                    <svg viewBox="0 0 16 16" width="15" height="15" fill="#53bdeb"><path d="M11.5 3.5L6 9l-2-2-1 1 3 3 6.5-6.5-1-1zm3 0L9 9l-1-1 1-1 4.5-4.5 1 1zM4 9l1 1-3 3-1-1 3-3z"></path></svg>
                                </div>
                            </div>
                        </div>
                        <div id="reactions_${data.key}" class="hidden" onclick="event.stopPropagation()"></div>
                    </div>
                `;

            msgsList.appendChild(div);
            
            // Render existing reactions if any
            if (msg.reactions) {
                if (typeof window.renderReactions === 'function') {
                    window.renderReactions(data.key, msg.reactions, true);
                }
            }

            document.getElementById('channel_messages_area').scrollTop = document.getElementById(
                'channel_messages_area').scrollHeight;
        });

        onChildChanged(messagesRef, (data) => {
            const msg = data.val();
            window.globalMessages[data.key] = msg;
            
            // Re-render reactions if they exist
            if (typeof window.renderReactions === 'function') {
                window.renderReactions(data.key, msg.reactions, true);
            }
        });
    };

    window.submitCreateChannel = async function() {
        const name = document.getElementById('new_channel_name').value.trim();
        const desc = document.getElementById('new_channel_desc').value.trim();
        const avatarFile = document.getElementById('new_channel_avatar_input').files[0];

        const btn = document.getElementById('btn_create_channel_submit');
        if (btn.classList.contains('cursor-not-allowed')) return;

        btn.innerHTML =
            '<svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>';
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
                if (jsonRes.status) {
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
        } catch (err) {
            console.error(err);
            alert("Failed to create channel: " + err.message);
        } finally {
            btn.innerHTML = 'Create channel';
            window.validateChannelForm();
        }
    };

    window.toggleFollowChannel = async function() {
        if (!window.currentChannel) return;
        const ch = window.currentChannel;
        const isFollowing = ch.followers && ch.followers[window.myUserId];
        const url = isFollowing ? `/channel/${ch.id}/unfollow` : `/channel/${ch.id}/follow`;

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                }
            });
            const res = await response.json();
            if (!res.status) alert(res.message);
        } catch (err) {
            console.error(err);
        }
    };

    window.toggleFollowFromList = async function(channelId) {
        try {
            const response = await fetch(`/channel/${channelId}/follow`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                }
            });
            const res = await response.json();
            if (res.status) {
                window.openChannel(channelId);
            } else {
                alert(res.message);
            }
        } catch (err) {
            console.error(err);
        }
    };

    let selectedChannelFile = null;
    window.handleChannelAttachment = function(input) {
        if (input.files && input.files[0]) {
            selectedChannelFile = input.files[0];
            document.getElementById('channel_message_input').placeholder = "Add a caption for " +
                selectedChannelFile.name;
        }
    };

    window.sendChannelMessage = async function() {
        if (!window.currentChannel) return;
        const textInput = document.getElementById('channel_message_input');
        const text = textInput.value.trim();
        const chId = window.currentChannel.id;

        if (!text && !selectedChannelFile) return;

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

        if (fileToUpload) {
            if (fileToUpload.type.startsWith('video/')) msgData.type = 'video';
            else if (fileToUpload.type.startsWith('audio/')) msgData.type = 'audio';
            else if (fileToUpload.type.startsWith('image/')) msgData.type = 'image';
            else msgData.type = 'document';

            msgData.fileName = fileToUpload.name;
            msgData.fileSize = (fileToUpload.size / (1024 * 1024)).toFixed(2) + ' MB';

            const formData = new FormData();
            formData.append('file', fileToUpload);

            fetch('/channel/upload-message-media', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': window.csrf
                },
                body: formData
            }).then(res => res.json()).then(json => {
                if (json.status) {
                    msgData.fileUrl = json.url;
                    push(ref(db, `channels/${chId}/messages`), msgData);

                    let lastMsgText = '📄 Document';
                    if (msgData.type === 'image') lastMsgText = '📸 Photo';
                    else if (msgData.type === 'video') lastMsgText = '🎥 Video';
                    else if (msgData.type === 'audio') lastMsgText = '🎵 Audio';

                    if (text) lastMsgText = text.substring(0, 50);

                    update(ref(db, `channels/${chId}`), {
                        last_message: lastMsgText
                    });
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
            update(ref(db, `channels/${chId}`), {
                last_message: text.substring(0, 50)
            });
        }
    };

    window.closeActiveChannel = function() {
        document.getElementById('active_channel_view').classList.add('hidden');
        document.getElementById('active_channel_view').classList.remove('flex');
        document.getElementById('channel_empty_state').classList.remove('hidden');
        document.getElementById('channel_empty_state').classList.add('flex');

        // Also hide right sidebar if open
        if (window.closeChannelInfo) window.closeChannelInfo();

        window.currentChannel = null;
        const menu = document.getElementById('channel_dropdown_menu');
        if (menu) menu.classList.add('hidden');
    };

    // Selection Mode
    window.selectedChannelUpdates = new Set();

    window.toggleChannelSelectionMode = function() {
        const bottomBar = document.getElementById('channel_selection_bottom_bar');
        if (!bottomBar) return;
        const isSelectionMode = !bottomBar.classList.contains('translate-y-full');
        if (isSelectionMode) {
            window.cancelChannelSelection();
            return;
        }

        bottomBar.classList.remove('hidden');
        // Give a tiny delay for transition to work if it was hidden
        setTimeout(() => {
            bottomBar.classList.remove('translate-y-full');
        }, 10);

        const checkboxes = document.querySelectorAll('.channel-msg-checkbox-container');
        checkboxes.forEach(cb => {
            cb.classList.remove('hidden');
            cb.classList.add('flex');
        });
        window.selectedChannelUpdates.clear();
        const countEl = document.getElementById('channel_selection_count');
        if (countEl) countEl.innerText = '0 selected';
        window.closeChannelMenu();

        // Hide delete button if user is not admin
        const isAdmin = window.currentChannel && window.currentChannel.admins && window.currentChannel.admins[window
            .myUserId];
        const deleteBtn = document.getElementById('channel_selection_delete_btn');
        if (deleteBtn) {
            if (isAdmin) deleteBtn.style.display = 'block';
            else deleteBtn.style.display = 'none';
        }
    };

    window.cancelChannelSelection = function() {
        const bottomBar = document.getElementById('channel_selection_bottom_bar');
        if (!bottomBar) return;
        bottomBar.classList.add('translate-y-full');
        setTimeout(() => {
            bottomBar.classList.add('hidden');
        }, 300);

        const checkboxes = document.querySelectorAll('.channel-msg-checkbox-container');
        checkboxes.forEach(cb => {
            cb.classList.add('hidden');
            cb.classList.remove('flex');
        });

        document.querySelectorAll('.channel-msg-checkbox').forEach(cb => {
            cb.checked = false;
            const box = cb.parentElement;
            box.classList.remove('bg-[#00a884]', 'border-[#00a884]');
            box.classList.add('bg-transparent', 'border-gray-400');
        });

        document.querySelectorAll('.channel-msg-row').forEach(row => {
            row.classList.remove('bg-blue-100', 'bg-opacity-50');
        });

        window.selectedChannelUpdates.clear();
    };

    window.toggleChannelMsgSelection = function(key, force = false) {
        const bottomBar = document.getElementById('channel_selection_bottom_bar');
        if (!force && (!bottomBar || bottomBar.classList.contains('translate-y-full'))) return; // Not in selection mode

        const cb = document.getElementById('channel_checkbox_' + key);
        const msgEl = document.getElementById('msg_' + key);
        if (!cb || !msgEl) return;

        cb.checked = !cb.checked;
        const box = cb.parentElement;

        if (cb.checked) {
            window.selectedChannelUpdates.add(key);
            msgEl.classList.add('bg-blue-100', 'bg-opacity-50');
            box.classList.add('bg-[#00a884]', 'border-[#00a884]');
            box.classList.remove('bg-white', 'border-gray-400');
        } else {
            window.selectedChannelUpdates.delete(key);
            msgEl.classList.remove('bg-blue-100', 'bg-opacity-50');
            box.classList.remove('bg-[#00a884]', 'border-[#00a884]');
            box.classList.add('bg-white', 'border-gray-400');
        }
        const countEl = document.getElementById('channel_selection_count');
        if (countEl) countEl.innerText = window.selectedChannelUpdates.size + ' selected';
    };

    window.forwardSelectedChannelUpdates = function() {
        if (!window.currentChannel || window.selectedChannelUpdates.size === 0) return;
        
        const chId = window.currentChannel.id;
        const promises = Array.from(window.selectedChannelUpdates).map(key => {
            return window.firebaseGet(window.firebaseRef(window.db, `channels/${chId}/messages/${key}`)).then(snapshot => {
                if(snapshot.exists()) return { ...snapshot.val(), key };
                return null;
            });
        });

        Promise.all(promises).then(messages => {
            const validMessages = messages.filter(m => m !== null);
            if(validMessages.length > 0 && window.openForwardModal) {
                window.openForwardModal(validMessages);
                window.cancelChannelSelection();
            }
        });
    };

    window.deleteSelectedChannelUpdates = function() {
        if (!window.currentChannel) return;
        if (window.selectedChannelUpdates.size === 0) return;

        if (window.openDeleteModal) {
            window.openDeleteModal(`Delete ${window.selectedChannelUpdates.size} update(s)?`, () => {}, () => {
                const chId = window.currentChannel.id;
                const updates = {};
                window.selectedChannelUpdates.forEach(key => {
                    updates[`channels/${chId}/messages/${key}`] = null;
                });
                window.firebaseUpdate(window.firebaseRef(window.db, '/'), updates).then(() => {
                    window.cancelChannelSelection();
                });
            }, 'Cancel');
        } else {
            if (confirm('Delete selected updates?')) {
                const chId = window.currentChannel.id;
                const updates = {};
                window.selectedChannelUpdates.forEach(key => {
                    updates[`channels/${chId}/messages/${key}`] = null;
                });
                window.firebaseUpdate(window.firebaseRef(window.db, '/'), updates).then(() => {
                    window.cancelChannelSelection();
                });
            }
        }
    };

    window.copySelectedChannelUpdates = function() {
        if (window.selectedChannelUpdates.size === 0) return;
        let text = '';
        window.selectedChannelUpdates.forEach(key => {
            if (window.globalMessages && window.globalMessages[key]) {
                if (window.globalMessages[key].text) {
                    text += window.globalMessages[key].text + '\n';
                }
            }
        });
        if (text.trim() === '') {
            if (window.showToast) window.showToast('Copied', 'Updates copied to clipboard');
            window.cancelChannelSelection();
            return;
        }
        navigator.clipboard.writeText(text.trim()).then(() => {
            if (window.showToast) window.showToast('Copied', 'Updates copied to clipboard');
            window.cancelChannelSelection();
        });
    };

    window.forwardSelectedChannelUpdates = function() {
        if (window.selectedChannelUpdates.size === 0) return;
        if (window.openForwardModal) {
            window.selectedMessages = new Set(window.selectedChannelUpdates);
            window.isForwardingChannel = false;
            window.openForwardModal(false);
        } else {
            if (window.showToast) window.showToast('Forward', 'Forwarding coming soon!');
        }
        window.cancelChannelSelection();
    };

    // Channel Settings Mode
    window.toggleChannelSettings = function() {
        window.closeChannelMenu();
        const drawer = document.getElementById('channel_settings_drawer');
        if (!drawer) return;
        drawer.classList.remove('hidden');
        setTimeout(() => {
            drawer.classList.remove('translate-x-full');
        }, 10);

        // load current settings
        if (window.currentChannel) {
            const reactions = window.currentChannel.reactions_setting || 'any';
            const rb = document.getElementById('channel_reaction_' + reactions);
            if (rb) rb.checked = true;
        }
    };

    window.closeChannelSettings = function() {
        const drawer = document.getElementById('channel_settings_drawer');
        if (!drawer) return;
        drawer.classList.add('translate-x-full');
        setTimeout(() => {
            drawer.classList.add('hidden');
        }, 300);
    };

    window.saveChannelReactionsSetting = function(val) {
        if (!window.currentChannel) return;
        const chId = window.currentChannel.id;
        window.firebaseUpdate(window.firebaseRef(window.db, `channels/${chId}`), {
            reactions_setting: val
        });
    };

    window.getDateHeader = function(timestamp) {
        const date = new Date(timestamp * 1000);
        const today = new Date();
        const yesterday = new Date();
        yesterday.setDate(yesterday.getDate() - 1);

        if (date.toDateString() === today.toDateString()) {
            return 'TODAY';
        } else if (date.toDateString() === yesterday.toDateString()) {
            return 'YESTERDAY';
        } else {
            return date.toLocaleDateString([], { day: '2-digit', month: '2-digit', year: 'numeric' });
        }
    };

    window.updateChannelMuteIcon = function(channelId) {
        if (window.firebaseGet && window.firebaseRef && window.db && window.myUserId) {
            window.firebaseGet(window.firebaseRef(window.db, `users/${window.myUserId}/channel_settings/${channelId}`)).then(snapshot => {
                let isMuted = false;
                if (snapshot.exists()) {
                    isMuted = !!snapshot.val().mute_follower;
                }
                const btn = document.getElementById('btn_mute_channel');
                if (btn) {
                    btn.classList.remove('hidden');
                    if (isMuted) {
                        btn.innerHTML = `<svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                            <path d="M11.332 3.659L7.388 7H4c-.552 0-1 .448-1 1v8c0 .552.448 1 1 1h3.388l3.944 3.341c.218.185.535.18.746-.011.206-.188.293-.473.222-.741v-15.16c.071-.268-.016-.553-.222-.741-.211-.191-.528-.196-.746-.011zm5.183 2.946l-1.414 1.414 2.829 2.829-2.829 2.828 1.414 1.415 2.828-2.829 2.829 2.829 1.414-1.415-2.829-2.828 2.829-2.829-1.414-1.414-2.829 2.829-2.828-2.829z"/>
                        </svg>`;
                        btn.title = "Unmute channel";
                    } else {
                        btn.innerHTML = `<svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                            <path d="M11.646 2.353c-.39-.39-1.023-.39-1.414 0l-3.535 3.535H4c-1.104 0-2 .896-2 2v8c0 1.104.896 2 2 2h2.697l3.535 3.535c.391.391 1.024.391 1.414 0 .391-.39.391-1.023 0-1.414L8.828 14H4v-8h4.828l2.818-2.818c.391-.39.391-1.024 0-1.414z"/>
                            <path d="M15.5 12c0-1.428-.488-2.748-1.305-3.805-.34-.44-.969-.523-1.414-.183-.445.34-.528.974-.188 1.414.542.702.863 1.583.863 2.535s-.321 1.833-.863 2.535c-.34.44-.257 1.074.188 1.414.445.34 1.074.257 1.414-.183C15.012 14.667 15.5 13.385 15.5 12z"/>
                            <path d="M18.805 12c0-3.328-1.996-6.143-5.263-7.234-.524-.175-1.085.108-1.26.633-.175.525.108 1.085.633 1.26 2.541.848 4.09 3.12 4.09 5.341s-1.549 4.493-4.09 5.341c-.525.175-.808.735-.633 1.26.136.408.513.664.912.664.114 0 .23-.02.348-.06C16.809 18.143 18.805 15.328 18.805 12z"/>
                        </svg>`;
                        btn.title = "Mute channel";
                    }
                }
            });
        }
    };

    window.toggleMuteChannel = function() {
        const ch = window.currentChannel;
        if(ch && window.firebaseGet && window.firebaseRef && window.db) {
            window.firebaseGet(window.firebaseRef(window.db, `users/${window.myUserId}/channel_settings/${ch.id}`)).then(snapshot => {
                let isMuted = false;
                if (snapshot.exists()) {
                    isMuted = !!snapshot.val().mute_follower;
                }
                const newMuteStatus = !isMuted;
                
                if (typeof window.toggleChannelMute === 'function') {
                    window.toggleChannelMute('follower', newMuteStatus);
                } else {
                    const updates = {};
                    updates[`mute_follower`] = newMuteStatus;
                    window.firebaseUpdate(window.firebaseRef(window.db, `users/${window.myUserId}/channel_settings/${ch.id}`), updates);
                    window.showToast?.('Notifications', newMuteStatus ? 'Notifications muted' : 'Notifications unmuted');
                }
                
                window.updateChannelMuteIcon(ch.id);
            });
        }
    };

    window.toggleChannelSearchDrawer = function() {
        const drawer = document.getElementById('channel_search_drawer');
        if (drawer.classList.contains('hidden')) {
            drawer.classList.remove('hidden');
            drawer.classList.add('flex');
            document.getElementById('channel_search_input').focus();
        } else {
            drawer.classList.add('hidden');
            drawer.classList.remove('flex');
        }
    };

    window.performChannelSearch = function() {
        const query = document.getElementById('channel_search_input').value;
        const resultsList = document.getElementById('channel_search_results');

        if (!query.trim()) {
            resultsList.innerHTML = '<div class="text-[#8696a0] text-center text-sm py-4">Type to search messages in channel</div>';
            return;
        }

        const searchTerm = query.toLowerCase();
        const results = [];

        for (let key in window.globalMessages) {
            const msg = window.globalMessages[key];
            if (msg.text && msg.text.toLowerCase().includes(searchTerm)) {
                results.push({
                    ...msg,
                    key
                });
            }
        }

        // Sort results by time descending
        results.sort((a, b) => b.time - a.time);

        window.renderChannelSearchResults(results, searchTerm);
    };

    window.renderChannelSearchResults = function(results, searchTerm) {
        const resultsList = document.getElementById('channel_search_results');
        resultsList.innerHTML = '';

        if (results.length === 0) {
            resultsList.innerHTML = `<div class="p-10 text-center text-[#8696a0] text-sm">No messages found</div>`;
            return;
        }

        let lastDate = '';

        results.forEach(msg => {
            const date = window.getChannelDateHeader ? window.getChannelDateHeader(msg.time) : new Date(msg.time * 1000).toLocaleDateString();
            if (date !== lastDate) {
                lastDate = date;
                resultsList.insertAdjacentHTML('beforeend',
                    `<div class="px-6 py-4 text-[#8696a0] text-[13px] font-medium">${date}</div>`);
            }

            // Highlight search term
            const regex = new RegExp(`(${searchTerm})`, 'gi');
            const highlightedText = msg.text.replace(regex,
                '<span class="text-[#00a884] font-medium">$1</span>');
            const time = new Date(msg.time * 1000).toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
            const isMe = msg.sender_id == window.myUserId;

            const html = `
                <div class="px-6 py-3 hover:bg-[#202c33] cursor-pointer transition-colors border-b border-gray-800/30 group" onclick="window.scrollToChannelMessage('${msg.key}')">
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-1">
                            <span class="text-[#8696a0] text-[13px] font-medium">${isMe ? 'You' : window.currentChannel.name}</span>
                        </div>
                        <div class="text-[#e9edef] text-[15px] leading-relaxed break-words line-clamp-3">${highlightedText}</div>
                        <span class="text-[#8696a0] text-[11px] mt-1">${time}</span>
                    </div>
                </div>
            `;
            resultsList.insertAdjacentHTML('beforeend', html);
        });
    };

    window.scrollToChannelMessage = function(msgId) {
        const msgEl = document.getElementById('channel_msg_' + msgId);
        if (msgEl) {
            msgEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            // Highlight effect
            const originalBg = msgEl.style.backgroundColor;
            msgEl.style.backgroundColor = '#2a3942';
            msgEl.style.transition = 'background-color 1s';
            
            setTimeout(() => {
                msgEl.style.backgroundColor = originalBg;
            }, 2000);
        }
    };

    window.copyChannelMsg = function(key) {
        const msgRef = ref(window.db, `channels/${window.currentChannel.id}/messages/${key}`);
        import('https://www.gstatic.com/firebasejs/10.7.1/firebase-database.js').then((module) => {
            const get = module.get;
            get(msgRef).then((snapshot) => {
                if (snapshot.exists()) {
                    navigator.clipboard.writeText(snapshot.val().text || '').then(() => {
                        if (window.showToast) window.showToast('Copied', 'Message copied to clipboard');
                    });
                }
            });
        });
    };

    window.copyChannelLink = function(key) {
        const chId = window.currentChannel ? window.currentChannel.id : '';
        const link = window.location.origin + '/channel/' + chId + '/' + key;
        navigator.clipboard.writeText(link).then(() => {
            if (window.showToast) window.showToast('Copied', 'Link copied to clipboard');
        });
    };

    window.forwardSelectedChannelUpdates = function() {
        if (!window.currentChannel || window.selectedChannelUpdates.size === 0) return;
        
        const chId = window.currentChannel.id;
        const promises = Array.from(window.selectedChannelUpdates).map(key => {
            return window.firebaseGet(window.firebaseRef(window.db, `channels/${chId}/messages/${key}`)).then(snapshot => {
                if(snapshot.exists()) return { ...snapshot.val(), key };
                return null;
            });
        });

        Promise.all(promises).then(messages => {
            const validMessages = messages.filter(m => m !== null);
            if(validMessages.length > 0 && window.openForwardModal) {
                window.globalMessages = window.globalMessages || {};
                window.selectedMessages = window.selectedMessages || new Set();
                window.selectedMessages.clear();
                window.isForwardingChannel = false; // Ensure it's treated as normal messages

                validMessages.forEach(m => {
                    window.globalMessages[m.key] = m;
                    window.selectedMessages.add(m.key);
                });

                window.openForwardModal();
                window.cancelChannelSelection();
            }
        });
    };

    window.deleteSelectedChannelUpdates = function() {
        if (!window.currentChannel) return;
        if (window.selectedChannelUpdates.size === 0) return;

        if (window.openDeleteModal) {
            window.openDeleteModal(`Delete ${window.selectedChannelUpdates.size} update(s)?`, null, () => {
                const chId = window.currentChannel.id;
                const updates = {};
                window.selectedChannelUpdates.forEach(key => {
                    updates[`channels/${chId}/messages/${key}`] = null;
                });
                window.firebaseUpdate(window.firebaseRef(window.db, '/'), updates).then(() => {
                    window.cancelChannelSelection();
                });
            });
        } else {
            if (confirm(`Delete ${window.selectedChannelUpdates.size} update(s) for everyone?`)) {
                const chId = window.currentChannel.id;
                const updates = {};
                window.selectedChannelUpdates.forEach(key => {
                    updates[`channels/${chId}/messages/${key}`] = null;
                });
                window.firebaseUpdate(window.firebaseRef(window.db, '/'), updates).then(() => {
                    window.cancelChannelSelection();
                });
            }
        }
    };

    window.deleteChannelSingleMsg = function(key) {
        if (window.openDeleteModal) {
            window.openDeleteModal('Delete message?', null, () => {
                const chId = window.currentChannel.id;
                const updates = {};
                updates[`channels/${chId}/messages/${key}`] = null;
                window.firebaseUpdate(window.firebaseRef(window.db, '/'), updates).then(() => {
                    if (window.showToast) window.showToast('Deleted', 'Message deleted');
                });
            });
        } else {
            if (confirm('Delete this message for everyone?')) {
                const chId = window.currentChannel.id;
                const updates = {};
                updates[`channels/${chId}/messages/${key}`] = null;
                window.firebaseUpdate(window.firebaseRef(window.db, '/'), updates).then(() => {
                    if (window.showToast) window.showToast('Deleted', 'Message deleted');
                });
            }
        }
    };

    window.askMetaAiChannel = function(key, encodedText) {
        if (!window.askMetaAi) return;
        const text = decodeURIComponent(window.atob(encodedText));
        const senderName = window.currentChannel ? window.currentChannel.name : 'Channel';
        window.askMetaAi(key, senderName, text);
    };

    window.startChannelMsgSelection = function(key) {
        const bottomBar = document.getElementById('channel_selection_bottom_bar');
        if (bottomBar && bottomBar.classList.contains('translate-y-full')) {
            window.toggleChannelSelectionMode();
        }
        setTimeout(() => {
            window.toggleChannelMsgSelection(key, true);
        }, 20);
    };

    window.forwardChannelMsg = function(key) {
        if (!window.currentChannel) return;
        const msgRef = window.firebaseRef(window.db, `channels/${window.currentChannel.id}/messages/${key}`);
        window.firebaseGet(msgRef).then((snapshot) => {
            if (snapshot.exists() && window.openForwardModal) {
                window.globalMessages = window.globalMessages || {};
                window.globalMessages[key] = { ...snapshot.val(), key };
                window.selectedMessages = window.selectedMessages || new Set();
                window.selectedMessages.clear();
                window.selectedMessages.add(key);
                window.isForwardingChannel = false; // Ensure it's treated as normal message

                window.openForwardModal();
            }
        });
    };

    window.toggleChannelEmojiPicker = function() {
        const container = document.getElementById('channel_emoji_picker_container');
        if (container) container.classList.toggle('hidden');
    };

    window.insertEmojiIntoChannelInput = function(emoji) {
        const input = document.getElementById('channel_message_input');
        if (input) {
            input.value += emoji;
            input.style.height = 'auto';
            input.style.height = input.scrollHeight + 'px';
            input.focus();
        }
        document.getElementById('channel_emoji_picker_container')?.classList.add('hidden');
    };

    const channelEmojiPicker = document.getElementById('channel_emoji_picker');
    if (channelEmojiPicker) {
        channelEmojiPicker.addEventListener('emoji-click', event => {
            window.insertEmojiIntoChannelInput(event.detail.unicode);
        });
    }

    document.addEventListener('click', function(event) {
        const picker = document.getElementById('channel_emoji_picker_container');
        const btn = document.getElementById('channel_emoji_toggle_btn');
        if (picker && btn && !picker.classList.contains('hidden')) {
            const path = event.composedPath();
            if (!path.includes(picker) && !path.includes(btn)) {
                picker.classList.add('hidden');
            }
        }
    });

    window.switchChannelPickerTab = function(tab) {
        document.getElementById('channel_panel_emoji').classList.add('hidden');
        document.getElementById('channel_panel_gif').classList.add('hidden');
        document.getElementById('channel_panel_sticker').classList.add('hidden');
        
        document.getElementById('channel_tab_btn_emoji').classList.remove('bg-gray-200', 'dark:bg-[#384b57]');
        document.getElementById('channel_tab_btn_gif').classList.remove('bg-gray-200', 'dark:bg-[#384b57]');
        document.getElementById('channel_tab_btn_sticker').classList.remove('bg-gray-200', 'dark:bg-[#384b57]');
        
        document.getElementById('channel_tab_indicator_emoji').classList.add('hidden');
        document.getElementById('channel_tab_indicator_gif').classList.add('hidden');
        document.getElementById('channel_tab_indicator_sticker').classList.add('hidden');

        document.getElementById(`channel_panel_${tab}`).classList.remove('hidden');
        document.getElementById(`channel_tab_btn_${tab}`).classList.add('bg-gray-200', 'dark:bg-[#384b57]');
        document.getElementById(`channel_tab_indicator_${tab}`).classList.remove('hidden');

        if (tab === 'gif' && document.getElementById('channel_gif_results').children.length === 0) {
            window.loadChannelTrendingGifs();
        } else if (tab === 'sticker' && document.getElementById('channel_sticker_results').children.length === 0) {
            window.loadChannelStickers();
        }
    };

    window.GIPHY_API_KEY = '{{ env("GIPHY_API_KEY", "") }}';

    window.loadChannelTrendingGifs = async function() {
        const gifResults = document.getElementById('channel_gif_results');
        if (!window.GIPHY_API_KEY) {
            gifResults.innerHTML = '<div class="col-span-2 text-center text-red-500 text-sm py-4">GIPHY API Key missing.<br>Please add GIPHY_API_KEY to your .env file.</div>';
            return;
        }
        gifResults.innerHTML = '<div class="col-span-2 text-center text-gray-500 text-sm py-4">Loading GIFs...</div>';
        try {
            const res = await fetch(`https://api.giphy.com/v1/gifs/trending?api_key=${window.GIPHY_API_KEY}&limit=20`);
            const data = await res.json();
            window.renderChannelGifs(data.data);
        } catch (e) {
            gifResults.innerHTML = '<div class="col-span-2 text-center text-red-500 text-sm py-4">Failed to load GIFs</div>';
        }
    };

    window.searchChannelGifs = async function(query) {
        if (!query.trim()) return window.loadChannelTrendingGifs();
        const gifResults = document.getElementById('channel_gif_results');
        if (!window.GIPHY_API_KEY) {
            gifResults.innerHTML = '<div class="col-span-2 text-center text-red-500 text-sm py-4">GIPHY API Key missing.<br>Please add GIPHY_API_KEY to your .env file.</div>';
            return;
        }
        gifResults.innerHTML = '<div class="col-span-2 text-center text-gray-500 text-sm py-4">Searching...</div>';
        try {
            const res = await fetch(`https://api.giphy.com/v1/gifs/search?api_key=${window.GIPHY_API_KEY}&q=${encodeURIComponent(query)}&limit=20`);
            const data = await res.json();
            window.renderChannelGifs(data.data);
        } catch (e) {
            gifResults.innerHTML = '<div class="col-span-2 text-center text-red-500 text-sm py-4">Search failed</div>';
        }
    };

    window.renderChannelGifs = function(gifs) {
        const gifResults = document.getElementById('channel_gif_results');
        gifResults.innerHTML = '';
        if (!gifs || gifs.length === 0) {
            gifResults.innerHTML = '<div class="col-span-2 text-center text-gray-500 text-sm py-4">No GIFs found</div>';
            return;
        }
        gifs.forEach(gif => {
            const previewUrl = gif.images.fixed_height_small.url;
            const sendUrl = gif.images.original.url;
            const img = document.createElement('img');
            img.src = previewUrl;
            img.className = 'w-full h-[100px] object-cover rounded cursor-pointer hover:opacity-80 transition-opacity bg-gray-100 dark:bg-[#2a3942]';
            img.onclick = () => window.sendChannelMediaFromUrl(sendUrl, 'image/gif', 'animation.gif');
            gifResults.appendChild(img);
        });
    };

    window.loadChannelStickers = async function() {
        const stickerResults = document.getElementById('channel_sticker_results');
        if (!window.GIPHY_API_KEY) {
            stickerResults.innerHTML = '<div class="col-span-4 text-center text-red-500 text-sm py-4">GIPHY API Key missing.<br>Please add GIPHY_API_KEY to your .env file.</div>';
            return;
        }
        stickerResults.innerHTML = '<div class="col-span-4 text-center text-gray-500 text-sm py-4">Loading Stickers...</div>';
        try {
            const res = await fetch(`https://api.giphy.com/v1/stickers/trending?api_key=${window.GIPHY_API_KEY}&limit=20`);
            const data = await res.json();
            window.renderChannelStickers(data.data);
        } catch (e) {
            stickerResults.innerHTML = '<div class="col-span-4 text-center text-red-500 text-sm py-4">Failed to load Stickers</div>';
        }
    };

    window.searchChannelStickers = async function(query) {
        if (!query.trim()) return window.loadChannelStickers();
        const stickerResults = document.getElementById('channel_sticker_results');
        if (!window.GIPHY_API_KEY) {
            stickerResults.innerHTML = '<div class="col-span-4 text-center text-red-500 text-sm py-4">GIPHY API Key missing.<br>Please add GIPHY_API_KEY to your .env file.</div>';
            return;
        }
        stickerResults.innerHTML = '<div class="col-span-4 text-center text-gray-500 text-sm py-4">Searching...</div>';
        try {
            const res = await fetch(`https://api.giphy.com/v1/stickers/search?api_key=${window.GIPHY_API_KEY}&q=${encodeURIComponent(query)}&limit=20`);
            const data = await res.json();
            window.renderChannelStickers(data.data);
        } catch (e) {
            stickerResults.innerHTML = '<div class="col-span-4 text-center text-red-500 text-sm py-4">Search failed</div>';
        }
    };

    window.renderChannelStickers = function(stickers) {
        const stickerResults = document.getElementById('channel_sticker_results');
        stickerResults.innerHTML = '';
        if (!stickers || stickers.length === 0) {
            stickerResults.innerHTML = '<div class="col-span-4 text-center text-gray-500 text-sm py-4">No stickers found</div>';
            return;
        }
        stickers.forEach(sticker => {
            const previewUrl = sticker.images.fixed_height_small.url;
            const sendUrl = sticker.images.original.url;
            const img = document.createElement('img');
            img.src = previewUrl;
            img.className = 'w-full h-[72px] object-contain cursor-pointer hover:scale-110 transition-transform p-1';
            img.onclick = () => window.sendChannelMediaFromUrl(sendUrl, 'image/gif', 'sticker.gif');
            stickerResults.appendChild(img);
        });
    };

    window.sendChannelMediaFromUrl = async function(url, type, filename) {
        document.getElementById('channel_emoji_picker_container').classList.add('hidden');
        if (!window.currentChannel) return;
        const chId = window.currentChannel.id;

        try {
            const response = await fetch(url);
            const blob = await response.blob();
            const file = new File([blob], filename, { type: type });
            
            const time = Math.floor(Date.now() / 1000);
            const msgData = {
                sender_id: window.myUserId,
                time: time,
                type: 'image',
                text: '',
                fileName: file.name,
                fileSize: (file.size / (1024 * 1024)).toFixed(2) + ' MB'
            };

            const formData = new FormData();
            formData.append('file', file);

            const uploadRes = await fetch('/channel/upload-message-media', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': window.csrf
                },
                body: formData
            });
            const json = await uploadRes.json();
            
            if (json.status) {
                msgData.fileUrl = json.url;
                import('https://www.gstatic.com/firebasejs/10.7.1/firebase-database.js').then(module => {
                    const { ref, push, update } = module;
                    push(ref(db, `channels/${chId}/messages`), msgData);
                    update(ref(db, `channels/${chId}`), {
                        last_message: '📸 Photo'
                    });
                });
            }
        } catch (err) {
            console.error('Error sending media:', err);
            alert('Failed to send media. Network error.');
        }
    };
</script>
