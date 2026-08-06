<div id="manage_storage_panel" class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Default Header -->
    <div id="manage_storage_default_header" class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="toggleManageStorage()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Manage storage</h2>
    </div>

    <!-- Search Header -->
    <div id="manage_storage_search_header" class="hidden h-16 bg-[#202c33] px-4 flex items-center shrink-0 border-b border-[#313d45] gap-4">
        <button onclick="toggleStorageSearch()" class="text-[#00a884] hover:text-white transition-colors shrink-0">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
            </svg>
        </button>
        <input type="text" id="storage_chat_search_input" class="w-full bg-transparent border-none outline-none text-[#e9edef] text-[15px] placeholder-[#8696a0]" placeholder="Search..." onkeyup="filterStorageChats()">
        <button onclick="document.getElementById('storage_chat_search_input').value=''; filterStorageChats();" class="text-[#aebac1] hover:text-[#e9edef] transition-colors shrink-0">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M19.1 17.2l-5.3-5.3 5.3-5.3-1.8-1.8-5.3 5.3-5.3-5.3-1.8 1.8 5.3 5.3-5.3 5.3 1.8 1.8 5.3-5.3 5.3 5.3z"></path></svg>
        </button>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 min-h-0 overflow-y-auto custom-scrollbar bg-[#111b21]">
        
        <div id="manage_storage_top_content">
            <!-- Storage Bar Section -->
            <div class="px-6 py-5 border-b border-[#313d45]">
            <div class="flex justify-between items-end mb-4">
                <div>
                    <span id="storage_used_value" class="text-[#e9edef] text-[28px] font-normal leading-none"></span>
                    <span id="storage_used_unit" class="text-[#e9edef] text-[16px] font-medium ml-1">GB</span>
                    <div class="text-[#8696a0] text-[13px] mt-1">Used</div>
                </div>
                <div id="storage_free_container" class="text-right">
                    <span id="storage_free_value" class="text-[#8696a0] text-[24px] font-normal leading-none"></span>
                    <span id="storage_free_unit" class="text-[#8696a0] text-[14px] font-medium ml-1">GB</span>
                    <div class="text-[#8696a0] text-[13px] mt-1">Free</div>
                </div>
            </div>
            
            <!-- Progress Bar -->
            <div id="storage_progress_bar_container" class="w-full h-3 bg-transparent border border-[#e9edef] rounded-full overflow-hidden flex mb-4">
                <div id="storage_bar_whatsapp" class="bg-[#25D366] h-full" style="width: 0%"></div>
                <div id="storage_bar_other" class="bg-[#FFB02E] h-full" style="width: 0%"></div>
                <div id="storage_bar_free" class="bg-[#202c33] h-full" style="width: 0%"></div>
            </div>

            <!-- Legend -->
            <div id="storage_legend_container" class="flex gap-6 justify-center">
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-[#25D366]"></div>
                    <span id="storage_legend_whatsapp" class="text-[#8696a0] text-[13px]"></span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-[#FFB02E]"></div>
                    <span id="storage_legend_other" class="text-[#8696a0] text-[13px]"></span>
                </div>
            </div>
        </div>

        <!-- Review and delete items -->
        <div class="px-6 py-4">
            <h3 class="text-[#8696a0] text-[14px] font-medium mb-4">Review and delete items</h3>
            
            <div class="cursor-pointer group" onclick="toggleLargerThan5MB()">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="text-[#e9edef] text-[16px]">Larger than 5 MB</h4>
                    <div class="flex items-center text-[#8696a0] group-hover:text-[#e9edef] transition-colors">
                        <span id="storage_larger_5mb_text" class="text-[14px] mr-1"></span>
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                            <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Horizontal Scroll Preview -->
                <div class="flex overflow-x-auto gap-2 no-scrollbar pb-2" id="manage_storage_preview_list">
                    <!-- Dynamic Items Injected Here -->
                </div>
            </div>
        </div>
        
        <div class="border-b border-[#313d45]"></div>

        <!-- Storage details -->
        <div class="px-6 py-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-[#8696a0] text-[14px] font-medium">Storage details</h3>
                <button class="w-8 h-8 rounded-full bg-[#202c33] flex items-center justify-center text-[#aebac1] hover:text-white transition-colors" onclick="toggleStorageSearch()">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                        <path d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 0 0 1.256-3.386 5.207 5.207 0 1 0-5.207 5.208 5.183 5.183 0 0 0 3.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-4.6-1.598a3.608 3.608 0 1 1 0-7.216 3.608 3.608 0 0 1 0 7.216z"></path>
                    </svg>
                </button>
            </div>

            <!-- Filter Pills -->
            <div class="flex gap-2 mb-4">
                <button id="storage_filter_all" onclick="filterStorageByType('all')" class="px-4 py-1.5 rounded-full bg-[#0a332c] text-[#00a884] border border-transparent text-[14px] font-medium transition-colors">All</button>
                <button id="storage_filter_chats" onclick="filterStorageByType('chat')" class="px-4 py-1.5 rounded-full bg-transparent border border-[#8696a0] text-[#aebac1] hover:bg-[#202c33] text-[14px] font-medium transition-colors">Chats</button>
                <button id="storage_filter_channels" onclick="filterStorageByType('channel')" class="px-4 py-1.5 rounded-full bg-transparent border border-[#8696a0] text-[#aebac1] hover:bg-[#202c33] text-[14px] font-medium transition-colors">Channels</button>
            </div>
        </div>
        </div> <!-- Close manage_storage_top_content -->

        <div class="px-6 pb-4">
            <!-- Chat List -->
            <div class="flex flex-col gap-1 -mx-2" id="manage_storage_chat_list">
                <!-- Dynamic Chats Injected Here -->
            </div>
            
            <button id="manage_storage_see_all_btn" onclick="expandStorageChats()" class="hidden mt-4 px-4 py-2 rounded-full border border-[#313d45] text-[#00a884] text-[14px] font-medium hover:bg-[#202c33] transition-colors">
                See all
            </button>
        </div>

        <div class="border-b border-[#313d45]"></div>

        <!-- Tools to save space -->
        <div class="px-6 py-4 mb-4">
            <h3 class="text-[#8696a0] text-[14px] font-medium mb-4">Tools to save space</h3>
            
            <div class="flex items-center py-3 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4 rounded-lg" onclick="window.openPrivacyDisappearingMessagesFromStorage()">
                <div class="w-10 shrink-0 text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-1-11v4h2v-5h-5v2h4zm-5.707-1.707a8.001 8.001 0 0 1 11.414-7.414l-1.414 1.414A6.001 6.001 0 1 0 17 12h2a8 8 0 0 1-13.707-2.707z"></path>
                    </svg>
                </div>
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">Turn on disappearing messages</span>
                    <span class="text-[#8696a0] text-[14px] mt-0.5 leading-tight">Stay in control of future storage needs and build privacy into your chats.</span>
                </div>
            </div>

            <div class="flex items-center py-3 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4 rounded-lg mt-2" onclick="window.openStorageDownloads()">
                <div class="w-10 shrink-0 text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                    </svg>
                </div>
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">Manage downloads</span>
                    <span class="text-[#8696a0] text-[14px] mt-0.5 leading-tight">Save storage by deleting app downloads you don't use.</span>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<script>
    window.openPrivacyDisappearingMessagesFromStorage = function() {
        const storagePanel = document.getElementById('manage_storage_panel');
        const hub = document.getElementById('privacy_disappearing_messages_sidebar');
        
        if (storagePanel) {
            storagePanel.classList.add('hidden');
            storagePanel.classList.remove('flex');
        }
        if (hub) {
            hub.classList.remove('hidden');
            hub.classList.add('flex');
            
            // To handle "Back" button correctly from hub back to storage, we can override the back behavior
            // But for simplicity, we let the native close function go back to privacy, or we can just rely on user flow.
            // Actually, we should probably set a flag so it knows to return here.
            window._disappearingMessagesReturnTo = 'storage';
        }
    };
    
    window.openStorageDownloads = function() {
        const storagePanel = document.getElementById('manage_storage_panel');
        const downloadsPanel = document.getElementById('manage_storage_downloads_panel');
        
        if (storagePanel) {
            storagePanel.classList.add('hidden');
            storagePanel.classList.remove('flex');
        }
        if (downloadsPanel) {
            downloadsPanel.classList.remove('hidden');
            downloadsPanel.classList.add('flex');
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        // Render Preview Items for "Larger than 5 MB"
        const previewContainer = document.getElementById('manage_storage_preview_list');
        let previewHtml = '';
        for (let i = 0; i < 4; i++) {
            previewHtml += `
                <div class="min-w-[80px] h-[100px] bg-[#202c33] rounded-lg flex flex-col items-center justify-center shrink-0 border border-[#313d45] relative">
                    <span class="absolute top-1 right-2 text-white text-[12px]">180 MB</span>
                    <svg viewBox="0 0 24 24" width="36" height="36" fill="#8696a0" class="mt-3">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 2l5 5h-5V4zM6 20V4h5v7h7v9H6z"></path>
                        <text x="12" y="16" font-family="Arial" font-size="5" font-weight="bold" fill="white" text-anchor="middle">MP4</text>
                    </svg>
                </div>
            `;
        }
        previewHtml += `
            <div class="min-w-[80px] h-[100px] bg-[#202c33] rounded-lg flex flex-col items-center justify-center shrink-0 border border-[#313d45] relative">
                <span class="text-[#8696a0] text-[16px]">+44</span>
                <svg viewBox="0 0 24 24" width="36" height="36" fill="#8696a0" class="absolute opacity-20">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 2l5 5h-5V4zM6 20V4h5v7h7v9H6z"></path>
                </svg>
            </div>
        `;
        if (previewContainer) {
            previewContainer.innerHTML = previewHtml;
        }

        // Render Chat List dynamically
        const chatContainer = document.getElementById('manage_storage_chat_list');
        const usersList = @json($users ?? []);
        let mockChats = [];
        
        function updateStorageUIDynamically() {
            let totalBytes = 0;
            let largerThan5MbBytes = 0;
            let chatUsage = {};
            
            const dataSource = window.fullStorageCache || window.globalMediaCache || [];

            if (dataSource.length > 0) {
                dataSource.forEach(item => {
                    let sizeBytes = item.fileSize || 0;
                    if (!sizeBytes) {
                        if (item.type === 'video') sizeBytes = (12 + (item.key.length % 5)) * 1024 * 1024;
                        else if (item.type === 'document') sizeBytes = (6 + (item.key.length % 4)) * 1024 * 1024;
                        else sizeBytes = (2 + (item.key.length % 2)) * 1024 * 1024; // Image
                    }
                    totalBytes += sizeBytes;
                    
                    if (sizeBytes >= 5 * 1024 * 1024) {
                        largerThan5MbBytes += sizeBytes;
                    }

                    if (!chatUsage[item.chatId]) chatUsage[item.chatId] = 0;
                    chatUsage[item.chatId] += sizeBytes;
                });
            } else {
                // Empty state if no media found
                totalBytes = 250 * 1024;
            }

            let chatHtml = '';
            mockChats = [];
            
            const formatChatSize = bytes => {
                if(bytes > 1024 * 1024 * 1024) return (bytes / (1024 * 1024 * 1024)).toFixed(1) + ' GB';
                if(bytes > 1024 * 1024) return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
                return (bytes / 1024).toFixed(1) + ' KB';
            };
            
            // Map usage back to users
            usersList.forEach((user) => {
                let name = user.saved_name || user.name || user.phone || 'Unknown User';
                let avatar = user.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=random&color=fff`;
                
                let chatId = user.is_contact === false ? `chat_${user.id}` : `chat_${user.id}`; // Simple logic, might need adjustment for groups
                // Just find ANY matching usage by matching ID since exact chat format isn't strictly defined here
                let chatBytes = 0;
                let matchedChatId = '';
                Object.keys(chatUsage).forEach(cId => {
                    if (cId.includes(user.id)) { chatBytes += chatUsage[cId]; matchedChatId = cId; }
                });
                
                if (chatBytes > 0) {
                    let sizeText = formatChatSize(chatBytes);
                    
                    let type = 'chat';
                    
                    mockChats.push({
                        id: matchedChatId,
                        name: name,
                        size: sizeText,
                        bytes: chatBytes,
                        avatar: avatar,
                        type: type
                    });
                }
            });
            
            // Map usage back to groups
            if (window.allMyGroups) {
                window.allMyGroups.forEach(grp => {
                    let name = grp.name || 'Unknown Group';
                    let avatar = grp.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=2a3942&color=fff`;
                    let chatId = grp.id;
                    let chatBytes = 0;
                    
                    Object.keys(chatUsage).forEach(cId => {
                        if (cId === chatId) chatBytes += chatUsage[cId];
                    });
                    
                    let sizeText = chatBytes > 0 ? formatChatSize(chatBytes) : '0 KB';
                    
                    mockChats.push({
                        id: chatId,
                        name: name,
                        size: sizeText,
                        bytes: chatBytes,
                        avatar: avatar,
                        type: 'chat'
                    });
                });
            }
            
            // Map usage back to channels
            if (window.allMyChannels) {
                window.allMyChannels.forEach(ch => {
                    let name = ch.name || 'Unknown Channel';
                    let avatar = ch.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=2a3942&color=fff`;
                    let chatId = ch.id;
                    let chatBytes = 0;
                    
                    Object.keys(chatUsage).forEach(cId => {
                        if (cId === chatId) chatBytes += chatUsage[cId];
                    });
                    
                    // Show channels even if 0 bytes
                    let sizeText = chatBytes > 0 ? formatChatSize(chatBytes) : '0 KB';
                    
                    mockChats.push({
                        id: chatId,
                        name: name,
                        size: sizeText,
                        bytes: chatBytes,
                        avatar: avatar,
                        type: 'channel'
                    });
                });
            }

            // Sort mockChats by size descending
            mockChats.sort((a, b) => b.bytes - a.bytes);

            if (mockChats.length === 0) {
                chatHtml = '<div class="text-[#8696a0] text-[14px] text-center py-4">No media stored yet.</div>';
            } else {
                mockChats.forEach(chat => {
                    const safeName = chat.name ? String(chat.name).toLowerCase() : '';
                    const escapedName = chat.name ? String(chat.name).replace(/'/g, "\\'") : '';
                    chatHtml += `
                        <div class="flex items-center justify-between p-2 hover:bg-[#202c33] rounded-lg cursor-pointer transition-colors group chat-storage-item" data-name="${safeName}" data-type="${chat.type}" onclick="if(window.openChatStorageDetails) window.openChatStorageDetails('${chat.id}', '${escapedName}', '${chat.avatar}', '${chat.size}')">
                            <div class="flex items-center gap-3">
                                <img src="${chat.avatar}" class="w-10 h-10 rounded-full object-cover">
                                <span class="text-[#e9edef] text-[16px]">${chat.name}</span>
                            </div>
                            <span class="text-[#8696a0] text-[14px]">${chat.size}</span>
                        </div>
                    `;
                });
            }
            
            if (chatContainer) {
                chatContainer.innerHTML = chatHtml;
            }

            // Calculate main storage dynamically based on server's real disk space
            let quotaBytes = {{ @disk_total_space(base_path()) ?: (128 * 1024 * 1024 * 1024) }};
            let freeBytes = {{ @disk_free_space(base_path()) ?: (64 * 1024 * 1024 * 1024) }};
            
            let whatsappGb = (totalBytes / (1024 * 1024 * 1024));
            let totalStorageGb = (quotaBytes / (1024 * 1024 * 1024));
            let freeGb = (freeBytes / (1024 * 1024 * 1024));
            
            let usedGb = totalStorageGb - freeGb;
            let otherAppsGb = usedGb - whatsappGb;
            if (otherAppsGb < 0) otherAppsGb = 0;

            const formatGb = val => val < 0.1 ? val.toFixed(3) : val.toFixed(1);
            const formatSize = bytes => {
                if(bytes > 1024 * 1024 * 1024) return (bytes / (1024 * 1024 * 1024)).toFixed(1) + ' GB';
                if(bytes > 1024 * 1024) return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
                return (bytes / 1024).toFixed(1) + ' KB';
            };

            const isDesktopApp = navigator.userAgent.toLowerCase().includes('electron') || 
                                 navigator.userAgent.toLowerCase().includes('tauri') || 
                                 navigator.userAgent.toLowerCase().includes('whatsapp') || 
                                 (typeof process !== 'undefined' && process.versions && process.versions.electron) ||
                                 window.__TAURI__ || 
                                 window.isDesktop;

            if (!isDesktopApp) {
                // WEB MODE: Only show WhatsApp usage, hide OS storage info
                const parts = formatSize(totalBytes).split(' ');
                document.getElementById('storage_used_value').innerText = parts[0];
                document.getElementById('storage_used_unit').innerText = parts[1];
                
                document.getElementById('storage_free_container').style.display = 'none';
                document.getElementById('storage_progress_bar_container').style.display = 'none';
                document.getElementById('storage_legend_container').style.display = 'none';
            } else {
                // DESKTOP MODE: Show full OS storage
                document.getElementById('storage_free_container').style.display = 'block';
                document.getElementById('storage_progress_bar_container').style.display = 'flex';
                document.getElementById('storage_legend_container').style.display = 'flex';
                
                document.getElementById('storage_used_value').innerText = formatGb(usedGb);
                document.getElementById('storage_used_unit').innerText = 'GB';
                document.getElementById('storage_free_value').innerText = formatGb(freeGb);
                document.getElementById('storage_free_unit').innerText = 'GB';
                
                let pctWhatsapp = (whatsappGb / totalStorageGb) * 100;
                // Ensure WhatsApp is visibly green even if very small
                if (pctWhatsapp > 0 && pctWhatsapp < 1) pctWhatsapp = 1; 
                
                let pctFree = (freeGb / totalStorageGb) * 100;
                let pctOther = (otherAppsGb / totalStorageGb) * 100;
                
                // Adjust other apps percentage if WhatsApp was artificially boosted for visibility
                if (pctWhatsapp === 1) {
                    pctOther -= 1;
                    if (pctOther < 0) pctOther = 0;
                }
                
                document.getElementById('storage_bar_whatsapp').style.width = pctWhatsapp + '%';
                document.getElementById('storage_bar_other').style.width = pctOther + '%';
                document.getElementById('storage_bar_free').style.width = pctFree + '%';
                
                document.getElementById('storage_legend_whatsapp').innerText = `WhatsApp (${formatSize(totalBytes)})`;
                document.getElementById('storage_legend_other').innerText = `Other apps (${otherAppsGb.toFixed(1)} GB)`;
            }
            
            document.getElementById('storage_larger_5mb_text').innerText = formatSize(largerThan5MbBytes);
            
            const mainStorageText = document.getElementById('main_storage_usage_text');
            if (mainStorageText) {
                mainStorageText.innerText = formatSize(totalBytes);
            }
            
            // Re-render the >5MB grid if it's currently open
            if (typeof window.renderGrid === 'function') {
                window.renderGrid();
            }
            
            if (typeof window.filterStorageChats === 'function') {
                window.filterStorageChats();
            }
        }

        window.toggleStorageSearch = function() {
            const defaultHeader = document.getElementById('manage_storage_default_header');
            const searchHeader = document.getElementById('manage_storage_search_header');
            const topContent = document.getElementById('manage_storage_top_content');
            const searchInput = document.getElementById('storage_chat_search_input');
            
            if (searchHeader.classList.contains('hidden')) {
                // Open search
                defaultHeader.classList.add('hidden');
                defaultHeader.classList.remove('flex');
                
                searchHeader.classList.remove('hidden');
                searchHeader.classList.add('flex');
                
                topContent.classList.add('hidden');
                
                searchInput.value = '';
                searchInput.focus();
                filterStorageChats();
            } else {
                // Close search
                searchHeader.classList.add('hidden');
                searchHeader.classList.remove('flex');
                
                defaultHeader.classList.remove('hidden');
                defaultHeader.classList.add('flex');
                
                topContent.classList.remove('hidden');
                
                searchInput.value = '';
                filterStorageChats();
            }
        }

        window.currentStorageFilter = 'all';
        window.storageChatsExpanded = false;
        
        window.expandStorageChats = function() {
            window.storageChatsExpanded = true;
            document.getElementById('manage_storage_see_all_btn').classList.add('hidden');
            filterStorageChats();
        }
        
        window.filterStorageByType = function(type) {
            window.currentStorageFilter = type;
            
            const btnAll = document.getElementById('storage_filter_all');
            const btnChats = document.getElementById('storage_filter_chats');
            const btnChannels = document.getElementById('storage_filter_channels');
            
            [btnAll, btnChats, btnChannels].forEach(btn => {
                btn.className = "px-4 py-1.5 rounded-full bg-transparent border border-[#8696a0] text-[#aebac1] hover:bg-[#202c33] text-[14px] font-medium transition-colors";
            });
            
            const activeClasses = "px-4 py-1.5 rounded-full bg-[#0a332c] text-[#00a884] border border-transparent text-[14px] font-medium transition-colors";
            
            if (type === 'all') btnAll.className = activeClasses;
            else if (type === 'chat') btnChats.className = activeClasses;
            else if (type === 'channel') btnChannels.className = activeClasses;
            
            filterStorageChats();
        }

        window.filterStorageChats = function() {
            const val = document.getElementById('storage_chat_search_input').value.toLowerCase();
            const items = document.querySelectorAll('.chat-storage-item');
            const seeAllBtn = document.getElementById('manage_storage_see_all_btn');
            
            let visibleCount = 0;
            let totalMatches = 0;
            
            items.forEach(item => {
                const name = item.getAttribute('data-name') || '';
                const itemType = item.getAttribute('data-type');
                
                const matchesSearch = name.includes(val);
                const matchesType = window.currentStorageFilter === 'all' || window.currentStorageFilter === itemType;
                
                if (matchesSearch && matchesType) {
                    totalMatches++;
                    if (!window.storageChatsExpanded && val === '' && visibleCount >= 5) {
                        item.style.display = 'none';
                    } else {
                        item.style.display = 'flex';
                        visibleCount++;
                    }
                } else {
                    item.style.display = 'none';
                }
            });
            
            if (seeAllBtn) {
                if (!window.storageChatsExpanded && val === '' && totalMatches > 5) {
                    seeAllBtn.classList.remove('hidden');
                } else {
                    seeAllBtn.classList.add('hidden');
                }
            }
        }

        async function fetchAllStorageMedia() {
            if (!window.db || !window.myUserId) return;
            
            // Show loading state
            document.getElementById('storage_used_value').innerText = '...';
            document.getElementById('storage_larger_5mb_text').innerText = 'Loading...';
            
            // Fetch channels to include in the list
            try {
                const channelsSnap = await window.get(window.ref(window.db, 'channels'));
                if (channelsSnap.exists()) {
                    window.allMyChannels = [];
                    channelsSnap.forEach(child => {
                        const ch = child.val();
                        if ((ch.followers && ch.followers[window.myUserId]) || (ch.admins && ch.admins[window.myUserId])) {
                            window.allMyChannels.push(ch);
                        }
                    });
                }
            } catch (e) {
                console.error("Error fetching channels:", e);
            }
            
            // Fetch groups to include in the list
            try {
                const groupsSnap = await window.get(window.ref(window.db, 'groups'));
                if (groupsSnap.exists()) {
                    window.allMyGroups = [];
                    groupsSnap.forEach(child => {
                        const grp = child.val();
                        if (grp.users && (grp.users.includes(Number(window.myUserId)) || grp.users.includes(String(window.myUserId)))) {
                            window.allMyGroups.push(grp);
                        }
                    });
                }
            } catch (e) {
                console.error("Error fetching groups:", e);
            }
            
            let allMedia = [];
            let chatPromises = [];
            
            if (window.allContacts) {
                window.allContacts.forEach(contact => {
                    const ids = [Number(window.myUserId), Number(contact.id)].sort((a,b)=>a-b);
                    const chatId = 'chat_' + ids.join('_');
                    const refPath = 'chats/' + chatId + '/messages';
                    
                    chatPromises.push(
                        window.get(window.ref(window.db, refPath)).then(snap => {
                            if(snap.exists()) {
                                snap.forEach(child => {
                                    const data = child.val();
                                    if (data.type && data.type !== 'text' && data.file_url) {
                                        allMedia.push({
                                            key: child.key,
                                            type: data.type,
                                            url: data.file_url,
                                            fileName: data.file_name || 'Media',
                                            fileSize: data.file_size || null,
                                            senderName: data.sender_id == window.myUserId ? 'You' : contact.name,
                                            timestamp: data.time,
                                            chatId: chatId,
                                            isGroup: false
                                        });
                                    }
                                });
                            }
                        }).catch(e => console.error(e))
                    );
                });
            }
            
            if (window.allMyGroups) {
                window.allMyGroups.forEach(grp => {
                    const chatId = grp.id;
                    const refPath = 'groups/' + chatId + '/messages';
                    
                    chatPromises.push(
                        window.get(window.ref(window.db, refPath)).then(snap => {
                            if(snap.exists()) {
                                snap.forEach(child => {
                                    const data = child.val();
                                    if (data.type && data.type !== 'text' && data.file_url) {
                                        allMedia.push({
                                            key: child.key,
                                            type: data.type,
                                            url: data.file_url,
                                            fileName: data.file_name || 'Media',
                                            fileSize: data.file_size || null,
                                            senderName: data.sender_id == window.myUserId ? 'You' : (data.sender_name || 'Member'),
                                            timestamp: data.time,
                                            chatId: chatId,
                                            isGroup: true
                                        });
                                    }
                                });
                            }
                        }).catch(e => console.error(e))
                    );
                });
            }

            if (window.allMyChannels) {
                window.allMyChannels.forEach(ch => {
                    const chatId = ch.id;
                    const refPath = 'channels/' + chatId + '/messages';
                    
                    chatPromises.push(
                        window.get(window.ref(window.db, refPath)).then(snap => {
                            if(snap.exists()) {
                                snap.forEach(child => {
                                    const data = child.val();
                                    if (data.type && data.type !== 'text' && data.file_url) {
                                        allMedia.push({
                                            key: child.key,
                                            type: data.type,
                                            url: data.file_url,
                                            fileName: data.file_name || 'Media',
                                            fileSize: data.file_size || null,
                                            senderName: 'Channel',
                                            timestamp: data.time || data.created_at || 0,
                                            chatId: chatId,
                                            isGroup: false
                                        });
                                    }
                                });
                            }
                        }).catch(e => console.error(e))
                    );
                });
            }
            
            // Wait for all fetches
            await Promise.all(chatPromises);
            window.fullStorageCache = allMedia;
            updateStorageUIDynamically();
        }

        // Execute dynamic generation
        if (window.fullStorageCache) {
            updateStorageUIDynamically();
        } else {
            // Optimistic render from global cache, then fetch full data
            updateStorageUIDynamically();
            fetchAllStorageMedia();
        }
    });
</script>
