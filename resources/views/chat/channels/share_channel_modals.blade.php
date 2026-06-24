<!-- Channel Link Modal/Sidebar -->
<div id="channel_link_modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-50 transition-all duration-300">
    <div class="bg-[#111b21] w-full max-w-md rounded-lg shadow-xl overflow-hidden border border-[#313d45]">
        <!-- Header -->
        <div class="h-[60px] bg-[#202c33] px-4 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
            <button onclick="window.closeChannelShareModal()" class="text-[#8696a0] hover:text-[#e9edef] focus:outline-none transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M19.1 17.2l-5.3-5.3 5.3-5.3-1.8-1.8-5.3 5.3-5.3-5.3-1.8 1.8 5.3 5.3-5.3 5.3 1.8 1.8 5.3-5.3 5.3 5.3z"></path>
                </svg>
            </button>
            <h2 class="text-[#e9edef] text-[16px] font-medium">Channel link</h2>
        </div>
        
        <!-- Content -->
        <div class="p-6">
            <!-- Card -->
            <div class="bg-[#202c33] rounded-xl p-4 flex flex-col gap-3 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full overflow-hidden shrink-0 bg-[#2a3942]">
                        <img id="share_modal_channel_avatar" src="" class="w-full h-full object-cover">
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span id="share_modal_channel_name" class="text-[#e9edef] text-[16px] font-medium truncate"></span>
                        <span id="share_modal_channel_link_text" class="text-[#00a884] text-[13px] truncate"></span>
                    </div>
                </div>
            </div>

            <p class="text-[#8696a0] text-[14px] mb-6 px-1">People with this link can view and follow your channel.</p>

            <div class="flex flex-col gap-1">
                <!-- Send link via WhatsApp -->
                <div class="px-2 py-3 flex items-center gap-4 cursor-pointer hover:bg-[#202c33] transition-colors rounded-lg group" onclick="window.openSendChannelLinkModal()">
                    <div class="text-[#8696a0] group-hover:text-[#e9edef] transition-colors">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                            <path d="M10.74 5.253a.835.835 0 0 0-1.285.7l-.004 3.018c-3.791.246-6.425 2.502-7.391 5.485-.29.897.669 1.636 1.343.914 1.488-1.594 3.078-2.308 6.046-2.508v3.136a.835.835 0 0 0 1.286.7l5.918-4.167a.833.833 0 0 0 0-1.365l-5.913-4.913z"></path>
                        </svg>
                    </div>
                    <span class="text-[#e9edef] text-[16px]">Send link via WhatsApp</span>
                </div>

                <!-- Copy link -->
                <div class="px-2 py-3 flex items-center gap-4 cursor-pointer hover:bg-[#202c33] transition-colors rounded-lg group" onclick="window.copyChannelLink()">
                    <div class="text-[#8696a0] group-hover:text-[#e9edef] transition-colors">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                            <path d="M11.646 17.066l2.121 2.122-2.121 2.121a5.975 5.975 0 0 1-4.243 1.758 5.975 5.975 0 0 1-4.242-1.758A5.972 5.972 0 0 1 1.403 17a5.97 5.97 0 0 1 1.758-4.242l2.121-2.122 2.122 2.122-2.122 2.121c-1.168 1.168-1.168 3.074 0 4.243 1.169 1.168 3.075 1.168 4.243 0l2.121-2.121-2.122-2.121 2.122-2.122zM20.84 2.736A5.975 5.975 0 0 0 16.598 1a5.975 5.975 0 0 0-4.242 1.758l-2.122 2.121 2.122 2.122 2.121-2.121c1.169-1.168 3.075-1.168 4.243 0 1.168 1.168 1.168 3.074 0 4.242l-2.121 2.122 2.121 2.121 2.121-2.121A5.972 5.972 0 0 0 22.597 7a5.97 5.97 0 0 0-1.757-4.264zM7.05 14.828l7.778-7.778 2.122 2.122-7.778 7.778-2.122-2.122z"></path>
                        </svg>
                    </div>
                    <span class="text-[#e9edef] text-[16px]">Copy link</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Send Channel Link Modal -->
<div id="send_channel_link_modal" class="hidden fixed inset-0 z-[110] flex items-center justify-center bg-black bg-opacity-50 transition-all duration-300">
    <div class="bg-[#111b21] w-full max-w-sm rounded-lg shadow-xl overflow-hidden border border-[#313d45] flex flex-col max-h-[80vh]">
        <!-- Header -->
        <div class="h-[60px] bg-[#202c33] px-4 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
            <button onclick="window.closeSendChannelLinkModal()" class="text-[#8696a0] hover:text-[#e9edef] focus:outline-none transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M19.1 17.2l-5.3-5.3 5.3-5.3-1.8-1.8-5.3 5.3-5.3-5.3-1.8 1.8 5.3 5.3-5.3 5.3 1.8 1.8 5.3-5.3 5.3 5.3z"></path>
                </svg>
            </button>
            <h2 class="text-[#e9edef] text-[16px] font-medium">Send channel link to</h2>
        </div>
        
        <!-- Search Bar -->
        <div class="p-4 border-b border-[#313d45]">
            <div class="bg-[#202c33] flex items-center px-4 py-2 rounded-lg border border-[#313d45]">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="#8696a0" class="mr-3">
                    <path d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 0 0 1.256-3.386 5.207 5.207 0 1 0-5.207 5.208 5.183 5.183 0 0 0 3.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-4.8 0a3.6 3.6 0 1 1 0-7.2 3.6 3.6 0 0 1 0 7.2z"></path>
                </svg>
                <input type="text" id="send_link_search" placeholder="Search name or number" class="bg-transparent border-none text-[#e9edef] w-full focus:outline-none text-[15px]" onkeyup="window.filterSendLinkChats()">
            </div>
        </div>

        <div class="px-4 py-2">
            <span class="text-[#8696a0] text-[14px]">Recent chats</span>
        </div>

        <!-- Chat List -->
        <div id="send_link_chat_list" class="flex-1 overflow-y-auto custom-scrollbar">
            <!-- Populated dynamically via JS -->
        </div>

        <!-- Action Footer (Send Button) -->
        <div id="send_link_action_footer" class="hidden h-[72px] bg-[#202c33] px-4 flex items-center justify-between shrink-0 border-t border-[#313d45]">
            <div class="flex items-center gap-3 overflow-hidden flex-1 mr-4">
                <div id="send_link_selected_preview" class="flex items-center gap-2 overflow-x-auto custom-scrollbar pb-1">
                    <!-- Avatars of selected chats -->
                </div>
            </div>
            <button onclick="window.confirmSendChannelLink()" class="w-[44px] h-[44px] rounded-full bg-[#00a884] flex items-center justify-center text-[#111b21] hover:bg-[#008f72] transition-colors shadow-sm shrink-0">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                    <path d="M1.101 21.757L23.8 12.028 1.101 2.3l.011 7.912 13.623 1.816-13.623 1.817-.011 7.912z"></path>
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
    window.selectedChatsForLink = [];
    window.availableChatsForLink = [];

    window.openChannelShareModal = function() {
        const ch = window.currentChannel;
        if (!ch) return;

        const modal = document.getElementById('channel_link_modal');
        modal.classList.remove('hidden');

        document.getElementById('share_modal_channel_name').innerText = ch.name;
        document.getElementById('share_modal_channel_avatar').src = ch.avatar || 'https://ui-avatars.com/api/?name='+encodeURIComponent(ch.name)+'&background=2a3942&color=fff';
        
        const link = window.location.origin + '/channel/' + ch.id;
        document.getElementById('share_modal_channel_link_text').innerText = link;
    };

    window.closeChannelShareModal = function() {
        document.getElementById('channel_link_modal').classList.add('hidden');
    };

    window.copyChannelLink = function() {
        const ch = window.currentChannel;
        if (!ch) return;
        const link = window.location.origin + '/channel/' + ch.id;
        navigator.clipboard.writeText(link).then(() => {
            if (typeof window.showToast === 'function') {
                window.showToast("Success", "Link copied to clipboard");
            } else {
                alert("Link copied to clipboard");
            }
            window.closeChannelShareModal();
        });
    };

    window.openSendChannelLinkModal = function() {
        window.closeChannelShareModal();
        const modal = document.getElementById('send_channel_link_modal');
        modal.classList.remove('hidden');
        window.selectedChatsForLink = [];
        document.getElementById('send_link_search').value = '';
        window.renderSendLinkChats();
        window.updateSendLinkFooter();
    };

    window.closeSendChannelLinkModal = function() {
        document.getElementById('send_channel_link_modal').classList.add('hidden');
    };

    window.renderSendLinkChats = async function() {
        const container = document.getElementById('send_link_chat_list');
        container.innerHTML = '<div class="text-center text-[#8696a0] py-4 text-sm">Loading chats...</div>';
        
        try {
            const users = [];
            const userNodes = document.querySelectorAll('#user_list_container [id^="user_sidebar_"]');
            
            userNodes.forEach(node => {
                const userId = node.id.replace('user_sidebar_', '');
                const nameNode = node.querySelector('h4');
                const name = nameNode ? nameNode.textContent.trim() : '';
                const imgEl = node.querySelector('img');
                const avatar = imgEl ? imgEl.src : 'https://ui-avatars.com/api/?name='+encodeURIComponent(name)+'&background=2a3942&color=fff';
                const aboutNode = node.querySelector('p');
                const about = aboutNode ? aboutNode.textContent.trim() : 'Available';
                
                users.push({ id: userId, name: name, avatar: avatar, bio: about });
            });

            if (users.length > 0) {
                window.availableChatsForLink = users;
                window.filterSendLinkChats();
            } else {
                container.innerHTML = '<div class="text-center text-[#8696a0] py-4 text-sm">No contacts available.</div>';
            }
        } catch(e) {
            console.error("Error loading chats:", e);
            container.innerHTML = '<div class="text-center text-[#ea005e] py-4 text-sm">Failed to load chats.</div>';
        }
    };

    window.filterSendLinkChats = function() {
        const q = document.getElementById('send_link_search').value.toLowerCase();
        const container = document.getElementById('send_link_chat_list');
        container.innerHTML = '';
        
        if(!window.availableChatsForLink) return;

        const filtered = window.availableChatsForLink.filter(u => u.name.toLowerCase().includes(q));

        filtered.forEach(u => {
            const isSelected = window.selectedChatsForLink.find(sc => sc.id == u.id);
            const bio = u.bio || '';
            const avatar = u.avatar || 'https://ui-avatars.com/api/?name='+encodeURIComponent(u.name)+'&background=random&color=fff';
            
            container.innerHTML += `
                <div class="px-4 py-3 flex items-center gap-4 cursor-pointer hover:bg-[#202c33] transition-colors" onclick="window.toggleChatSelectionForLink('${u.id}', '${u.name.replace(/'/g, "\\'")}', '${avatar}')">
                    <div class="relative shrink-0 flex items-center justify-center w-5 h-5">
                        <div class="w-5 h-5 rounded border flex items-center justify-center ${isSelected ? 'bg-[#00a884] border-[#00a884]' : 'border-[#8696a0]'}">
                            ${isSelected ? '<svg viewBox="0 0 24 24" width="14" height="14" fill="white"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path></svg>' : ''}
                        </div>
                    </div>
                    <div class="w-[40px] h-[40px] rounded-full overflow-hidden shrink-0">
                        <img src="${avatar}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0 flex flex-col">
                        <span class="text-[#e9edef] text-[16px] truncate ${isSelected ? 'font-medium' : ''}">${u.name}</span>
                        <span class="text-[#8696a0] text-[13px] truncate">${bio}</span>
                    </div>
                </div>
            `;
        });

        if(filtered.length === 0) {
            container.innerHTML = '<div class="text-center text-[#8696a0] py-4 text-[14px]">No chats found</div>';
        }
    };

    window.toggleChatSelectionForLink = function(id, name, avatar) {
        const idx = window.selectedChatsForLink.findIndex(u => u.id == id);
        if(idx > -1) {
            window.selectedChatsForLink.splice(idx, 1);
        } else {
            window.selectedChatsForLink.push({id, name, avatar});
        }
        window.filterSendLinkChats();
        window.updateSendLinkFooter();
    };

    window.updateSendLinkFooter = function() {
        const footer = document.getElementById('send_link_action_footer');
        const preview = document.getElementById('send_link_selected_preview');
        
        if(window.selectedChatsForLink.length > 0) {
            footer.classList.remove('hidden');
            footer.classList.add('flex');
            preview.innerHTML = '';
            window.selectedChatsForLink.forEach(u => {
                preview.innerHTML += `
                    <div class="w-8 h-8 rounded-full overflow-hidden shrink-0 border border-[#202c33] relative group" onclick="window.toggleChatSelectionForLink('${u.id}', '', '')">
                        <img src="${u.avatar}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/50 hidden group-hover:flex items-center justify-center cursor-pointer">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="white"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path></svg>
                        </div>
                    </div>
                `;
            });
        } else {
            footer.classList.add('hidden');
            footer.classList.remove('flex');
        }
    };

    window.confirmSendChannelLink = async function() {
        const ch = window.currentChannel;
        if(!ch || window.selectedChatsForLink.length === 0) return;
        
        const link = window.location.origin + '/channel/' + ch.id;
        const msgText = `Follow the ${ch.name} channel on WhatsApp:\n${link}`;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        for(let u of window.selectedChatsForLink) {
            try {
                const minId = Math.min(window.myUserId, parseInt(u.id));
                const maxId = Math.max(window.myUserId, parseInt(u.id));
                const chatId = `chat_${minId}_${maxId}`;

                const formData = new FormData();
                formData.append('chat_id', chatId);
                formData.append('type', 'text');
                formData.append('message', msgText);

                await fetch('/send', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                });
            } catch(e) {
                console.error("Failed to send link to", u.id, e);
            }
        }

        if (typeof window.showToast === 'function') {
            window.showToast("Success", "Link sent successfully.");
        } else {
            alert("Link sent successfully.");
        }
        window.closeSendChannelLinkModal();
    };
</script>
