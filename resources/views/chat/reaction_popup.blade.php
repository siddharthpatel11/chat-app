<!-- Full Emoji Picker Modal -->
<div id="full_reaction_picker_modal" class="hidden fixed inset-0 z-[3000] items-center justify-center">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px] transition-opacity"
        onclick="window.closeFullReactionPicker()"></div>
    <!-- Modal Content -->
    <div id="reaction_picker_container"
        class="bg-[#233138] rounded-xl shadow-2xl overflow-hidden relative z-10 opacity-0 scale-95 transition-all duration-200"
        onclick="event.stopPropagation()" style="width: 320px; height: 400px;">
        <emoji-picker id="reaction_emoji_picker" class="w-full h-full"
            style="--num-columns: 8; --emoji-size: 1.3rem; --indicator-color: #00a884; --background: #233138; border: none;"></emoji-picker>
    </div>
</div>

<!-- Reaction Popup Container -->
<div id="reaction_popup"
    class="hidden absolute z-[3000] bg-[#233138]/90 backdrop-blur-md rounded-full px-3 py-2 shadow-2xl border border-white/10 flex items-center gap-1.5 transition-all transform scale-95 opacity-0 duration-200 origin-bottom">
    <style>
        #reaction_popup.show {
            transform: scale(1);
            opacity: 1;
        }

        .reaction-emoji-btn {
            font-size: 24px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            line-height: 1;
            user-select: none;
        }

        .reaction-emoji-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: scale(1.2) translateY(-5px);
        }

        .reaction-emoji-btn:active {
            transform: scale(0.95);
        }
    </style>

    <button class="reaction-emoji-btn" onclick="window.sendReaction('👍', window.currentReactionMsgId, window.currentReactionIsGroup, event, window.currentReactionIsChannel)"><span class="emoji-text">👍</span></button>
    <button class="reaction-emoji-btn" onclick="window.sendReaction('❤️', window.currentReactionMsgId, window.currentReactionIsGroup, event, window.currentReactionIsChannel)"><span class="emoji-text">❤️</span></button>
    <button class="reaction-emoji-btn" onclick="window.sendReaction('😂', window.currentReactionMsgId, window.currentReactionIsGroup, event, window.currentReactionIsChannel)"><span class="emoji-text">😂</span></button>
    <button class="reaction-emoji-btn" onclick="window.sendReaction('😮', window.currentReactionMsgId, window.currentReactionIsGroup, event, window.currentReactionIsChannel)"><span class="emoji-text">😮</span></button>
    <button class="reaction-emoji-btn" onclick="window.sendReaction('😢', window.currentReactionMsgId, window.currentReactionIsGroup, event, window.currentReactionIsChannel)"><span class="emoji-text">😢</span></button>
    <button class="reaction-emoji-btn" onclick="window.sendReaction('🙏', window.currentReactionMsgId, window.currentReactionIsGroup, event, window.currentReactionIsChannel)"><span class="emoji-text">🙏</span></button>
    <button class="reaction-emoji-btn" onclick="window.openFullReactionPicker(window.currentReactionMsgId, window.currentReactionIsGroup, event, window.currentReactionIsChannel)" style="background: rgba(255,255,255,0.1); border-radius: 50%; padding: 4px; margin-left: 2px;">
        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-white">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"></path>
        </svg>
    </button>
</div>

<script>
    window.currentReactionMsgId = null;
    window.currentReactionIsGroup = false;
    window.seenReactions = window.seenReactions || new Set();
    window.closeReactionPopupTimeout = null;

    // Close popup when clicking outside
    document.addEventListener('click', function(e) {
        const popup = document.getElementById('reaction_popup');
        if (popup && !popup.classList.contains('hidden') && !popup.contains(e.target)) {
            window.closeReactionPopup();
        }
    });

    window.showReactionPopup = function(event, msgId, isGroup, forceBtnPosition = false) {
        event.stopPropagation();
        
        if (window.closeReactionPopupTimeout) {
            clearTimeout(window.closeReactionPopupTimeout);
            window.closeReactionPopupTimeout = null;
        }

        window.currentReactionMsgId = msgId;
        window.currentReactionIsGroup = isGroup;

        const popup = document.getElementById('reaction_popup');

        // Remove hidden to get dimensions
        popup.classList.remove('hidden');

        // Get button rect to position popup above it
        const btnRect = event.currentTarget.getBoundingClientRect();

        // Calculate position (centered above the message bubble)
        // Find the parent bubble
        const bubble = document.getElementById('bubble_' + msgId);
        let topPos, leftPos;

        if (bubble && !forceBtnPosition) {
            const bubbleRect = bubble.getBoundingClientRect();
            // Position above the bubble
            topPos = bubbleRect.top - 60;

            // If it goes off top of screen
            if (topPos < 10) {
                topPos = bubbleRect.bottom + 10;
                popup.style.transformOrigin = 'top';
            } else {
                popup.style.transformOrigin = 'bottom';
            }

            // Center horizontally relative to bubble
            leftPos = bubbleRect.left + (bubbleRect.width / 2) - (popup.offsetWidth / 2);
        } else {
            // Fallback to button position
            topPos = btnRect.top - 60;
            leftPos = btnRect.left - (popup.offsetWidth / 2) + 20; // Added small offset to center better on button
        }

        // Keep within screen bounds horizontally
        if (leftPos < 10) leftPos = 10;
        if (leftPos + popup.offsetWidth > window.innerWidth - 10) {
            leftPos = window.innerWidth - popup.offsetWidth - 10;
        }

        popup.style.top = topPos + 'px';
        popup.style.left = leftPos + 'px';

        // Show with animation
        setTimeout(() => {
            popup.classList.add('show');
        }, 10);
    };

    window.closeReactionPopup = function() {
        const popup = document.getElementById('reaction_popup');
        if (popup) {
            popup.classList.remove('show');
            window.closeReactionPopupTimeout = setTimeout(() => {
                popup.classList.add('hidden');
                window.currentReactionMsgId = null;
            }, 100);
        }
    };

    window.sendReaction = async function(emoji, msgId, isGroup, event, isChannel = false) {
        event.stopPropagation();

        if (!msgId || !window.myUserId) {
            window.closeReactionPopup();
            return;
        }

        let path = '';
        let targetChatId = window.currentChatId;
        let isGlobalSearch = false;
        
        if (window.gsViewerCurrentContext && window.gsViewerCurrentContext.key === msgId) {
            targetChatId = window.gsViewerCurrentContext.chatId;
            isGlobalSearch = true;
        } else if (window.gsVideoViewerCurrentContext && window.gsVideoViewerCurrentContext.key === msgId) {
            targetChatId = window.gsVideoViewerCurrentContext.chatId;
            isGlobalSearch = true;
        }
        
        if (isChannel && window.currentChannel) {
            path = `channels/${window.currentChannel.id}/messages/${msgId}/reactions/${window.myUserId}`;
        } else if (isGroup) {
            let gId = targetChatId;
            if (gId && gId.toString().startsWith('group_')) gId = gId.toString().replace('group_', '');
            path = `groups/${gId}/messages/${msgId}/reactions/${window.myUserId}`;
        } else {
            let cId = targetChatId;
            if (cId && !cId.toString().startsWith('chat_')) {
                const id1 = parseInt(window.myUserId);
                const id2 = parseInt(cId);
                cId = `chat_${Math.min(id1, id2)}_${Math.max(id1, id2)}`;
            }
            path = `chats/${cId}/messages/${msgId}/reactions/${window.myUserId}`;
        }

        try {
            const snapshot = await window.get(window.ref(window.db, path));
            const currentReaction = snapshot.val();

            if (currentReaction === emoji) {
                await window.remove(window.ref(window.db, path));
            } else {
                await window.set(window.ref(window.db, path), emoji);
            }
        } catch (e) {
            console.error("Error setting reaction", e);
        }

        if (window.refreshGsViewerReactions && window.gsViewerCurrentContext && window.gsViewerCurrentContext.key === msgId) {
            window.refreshGsViewerReactions();
        } else if (window.refreshGsVideoViewerReactions && window.gsVideoViewerCurrentContext && window.gsVideoViewerCurrentContext.key === msgId) {
            window.refreshGsVideoViewerReactions();
        }

        // Close menu
        const menu = document.getElementById('menu_' + msgId);
        if (menu) {
            menu.classList.remove('flex');
            menu.classList.add('hidden');
            
            // Reset z-index that was added by toggleMsgMenu
            const parentMsg = document.getElementById('msg_' + msgId);
            const bubbleEl = document.getElementById('bubble_' + msgId);
            if (parentMsg) parentMsg.style.zIndex = '';
            if (bubbleEl) bubbleEl.style.zIndex = '';
        }

        if (typeof window.hideGroupMessageOptions === 'function') {
            window.hideGroupMessageOptions();
        } else {
            const groupMenu = document.getElementById('group_msg_dropdown');
            if (groupMenu) {
                groupMenu.classList.remove('opacity-100', 'scale-100', 'flex');
                groupMenu.classList.add('opacity-0', 'scale-95', 'hidden');
            }
        }
        
        if (typeof window.closeFullReactionPicker === 'function') {
            window.closeFullReactionPicker();
        }
        if (typeof window.closeReactionPopup === 'function') {
            window.closeReactionPopup();
        }
    };

    window.openFullReactionPicker = function(msgId, isGroup, event, isChannel = false) {
        event.stopPropagation();

        window.currentReactionMsgId = msgId;
        window.currentReactionIsGroup = isGroup;
        window.currentReactionIsChannel = isChannel;

        // Close the quick reaction menu
        const menu = document.getElementById('menu_' + msgId);
        if (menu) {
            menu.classList.remove('flex');
            menu.classList.add('hidden');
            
            // Reset z-index that was added by toggleMsgMenu
            const parentMsg = document.getElementById('msg_' + msgId);
            const bubbleEl = document.getElementById('bubble_' + msgId);
            if (parentMsg) parentMsg.style.zIndex = '';
            if (bubbleEl) bubbleEl.style.zIndex = '';
        }
        if (typeof window.hideGroupMessageOptions === 'function') {
            window.hideGroupMessageOptions();
        } else {
            const groupMenu = document.getElementById('group_msg_dropdown');
            if (groupMenu) {
                groupMenu.classList.remove('opacity-100', 'scale-100', 'flex');
                groupMenu.classList.add('opacity-0', 'scale-95', 'hidden');
            }
        }

        const modal = document.getElementById('full_reaction_picker_modal');
        const container = document.getElementById('reaction_picker_container');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                container.classList.remove('opacity-0', 'scale-95');
                container.classList.add('opacity-100', 'scale-100');
            }, 10);
        }
    };

    window.closeFullReactionPicker = function() {
        const modal = document.getElementById('full_reaction_picker_modal');
        const container = document.getElementById('reaction_picker_container');
        if (modal) {
            container.classList.remove('opacity-100', 'scale-100');
            container.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 200);
        }
    };

    // Event listener for the emoji picker
    document.addEventListener('DOMContentLoaded', () => {
        const picker = document.getElementById('reaction_emoji_picker');
        if (picker) {
            picker.addEventListener('emoji-click', event => {
                if (window.currentReactionMsgId) {
                    window.sendReaction(event.detail.unicode, window.currentReactionMsgId, window
                        .currentReactionIsGroup, event, window.currentReactionIsChannel);
                    window.closeFullReactionPicker();
                }
            });
        }
    });
</script>

<!-- Reaction List Modal -->
<div id="reaction_list_modal" class="hidden fixed inset-0 z-[300] items-center justify-center">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px] transition-opacity"
        onclick="window.closeReactionListModal()"></div>
    <div id="reaction_list_container"
        class="bg-[#233138] rounded-xl shadow-2xl overflow-hidden relative z-10 opacity-0 scale-95 transition-all duration-200 flex flex-col"
        onclick="event.stopPropagation()" style="width: 340px; max-height: 400px;">
        <div class="px-5 py-4 border-b border-[#313d45] flex items-center justify-between">
            <h3 class="text-[#e9edef] text-[16px] font-medium" id="reaction_list_title">Reactions</h3>
            <button onclick="window.closeReactionListModal()"
                class="text-[#8696a0] hover:text-[#e9edef] transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path
                        d="M19.1 17.2l-5.3-5.3 5.3-5.3-1.8-1.8-5.3 5.3-5.3-5.3-1.8 1.8 5.3 5.3-5.3 5.3 1.8 1.8 5.3-5.3 5.3 5.3z">
                    </path>
                </svg>
            </button>
        </div>
        <div id="reaction_list_content" class="overflow-y-auto flex-1 p-2">
            <!-- Items injected here -->
        </div>
    </div>
</div>

<script>
    window.showReactionListModal = function(msgId) {
        const msg = window.globalMessages[msgId];
        if (!msg || !msg.reactions) return;

        const content = document.getElementById('reaction_list_content');
        const title = document.getElementById('reaction_list_title');
        const modal = document.getElementById('reaction_list_modal');
        const container = document.getElementById('reaction_list_container');

        const totalReactions = Object.keys(msg.reactions).length;
        title.textContent = `${totalReactions} reaction${totalReactions > 1 ? 's' : ''}`;

        let html = '';
        const isGroup = window.currentChatId && window.currentChatId.startsWith('group_');
        const isChannel = window.currentChannel ? true : false;

        for (const [uid, emoji] of Object.entries(msg.reactions)) {
            let name = 'Unknown';
            let avatar = 'https://ui-avatars.com/api/?name=U&background=2a3942&color=fff';

            if (uid == window.myUserId) {
                // Determine own avatar. Try window.myAvatar if available
                avatar = window.myAvatar || `https://ui-avatars.com/api/?name=You&background=2a3942&color=fff`;
                html += `
                    <div class="flex items-center gap-3 p-3 hover:bg-[#2a3942]/60 rounded-lg transition-colors cursor-pointer" onclick="window.sendReaction('${emoji}', '${msgId}', ${isGroup}, event, ${isChannel}); window.closeReactionListModal();">
                        <img src="${avatar}" class="w-10 h-10 rounded-full object-cover shrink-0">
                        <div class="flex-1">
                            <div class="text-[#e9edef] text-[15px]">You</div>
                            <div class="text-[#8696a0] text-[13px]">Click to remove</div>
                        </div>
                        <div class="text-[20px]"><span class="emoji-text">${emoji}</span></div>
                    </div>
                `;
                continue;
            }

            if (window.allContacts) {
                const contact = window.allContacts.find(c => c.id == uid);
                if (contact) {
                    name = contact.name || contact.phone;
                    avatar = contact.avatar ||
                        `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=2a3942&color=fff`;
                }
            }

            html += `
                <div class="flex items-center gap-3 p-3 rounded-lg">
                    <img src="${avatar}" class="w-10 h-10 rounded-full object-cover shrink-0">
                    <div class="flex-1 text-[#e9edef] text-[15px]">${name}</div>
                    <div class="text-[20px]"><span class="emoji-text">${emoji}</span></div>
                </div>
            `;
        }

        content.innerHTML = html;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            container.classList.remove('opacity-0', 'scale-95');
            container.classList.add('opacity-100', 'scale-100');
        }, 10);
    };

    window.closeReactionListModal = function() {
        const modal = document.getElementById('reaction_list_modal');
        const container = document.getElementById('reaction_list_container');
        if (modal) {
            container.classList.remove('opacity-100', 'scale-100');
            container.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 200);
        }
    };

    // Helper to render reactions in the bubble
    window.renderReactions = function(msgId, reactionsObj, isMe) {
        const containerId = 'reactions_' + msgId;
        const container = document.getElementById(containerId);
        const bubble = document.getElementById('bubble_' + msgId);

        if (!container) return;

        if (!reactionsObj || Object.keys(reactionsObj).length === 0) {
            container.innerHTML = '';
            container.classList.add('hidden');
            if (bubble) {
                bubble.classList.remove('mb-3', 'mb-4');
            }
            return;
        }

        // Count frequencies of each emoji
        const counts = {};
        let total = 0;
        let myReaction = null;

        for (const [userId, emoji] of Object.entries(reactionsObj)) {
            counts[emoji] = (counts[emoji] || 0) + 1;
            total++;
            if (userId == window.myUserId) {
                myReaction = emoji;
            }
        }

        // Sort emojis by frequency
        const sortedEmojis = Object.keys(counts).sort((a, b) => counts[b] - counts[a]).slice(0, 3);

        let html = '<div class="flex items-center gap-0.5">';
        sortedEmojis.forEach(emoji => {
            html += `<span class="emoji-text text-[12px] leading-none">${emoji}</span>`;
        });
        if (total > 1) {
            html += `<span class="text-[11px] text-[#8696a0] font-medium ml-0.5 leading-none">${total}</span>`;
        }
        html += '</div>';

        container.innerHTML = html;
        2
        container.classList.remove('hidden');
        container.className =
            `absolute -bottom-3 right-2 px-1.5 py-0.5 rounded-full border-[1.5px] text-white flex items-center shadow-sm z-20 transition-colors cursor-pointer`;
        container.onclick = function(e) {
            e.stopPropagation();
            window.showReactionListModal(msgId);
        };

        if (bubble) {
            bubble.classList.add('mb-3');
        }

        // Style adjustments based on whether I sent the message and whether I reacted
        if (myReaction) {
            if (isMe) {
                container.classList.add('bg-[#0b141a]', 'border-[#005c4b]');
            } else {
                container.classList.add('bg-[#111b21]', 'border-[#00a884]');
            }
        } else {
            if (isMe) {
                container.classList.add('bg-[#111b21]', 'border-[#005c4b]');
            } else {
                container.classList.add('bg-[#111b21]', 'border-[#202c33]');
            }
        }
    };
</script>
