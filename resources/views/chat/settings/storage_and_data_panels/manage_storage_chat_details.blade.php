<div id="manage_storage_chat_details_panel" class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden relative">
    
    <!-- Default Header -->
    <div id="chat_details_default_header" class="h-16 bg-[#202c33] px-6 flex items-center justify-between shrink-0 border-b border-[#313d45] transition-all">
        <div class="flex items-center gap-6">
            <button onclick="closeChatStorageDetails()" class="text-[#aebac1] hover:text-white transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
                </svg>
            </button>
            <div class="flex items-center gap-3">
                <img id="chat_details_avatar" src="" class="w-10 h-10 rounded-full object-cover">
                <div class="flex flex-col">
                    <h2 id="chat_details_name" class="text-[#e9edef] text-[19px] font-semibold truncate max-w-[120px]">Chat Name</h2>
                    <span id="chat_details_size" class="text-[#8696a0] text-[13px]">0 KB</span>
                </div>
            </div>
        </div>
        <button onclick="chatDetailsToggleSortModal()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z"></path>
            </svg>
        </button>
    </div>

    <!-- Selection Header (Hidden by default) -->
    <div id="chat_details_selection_header" class="hidden h-16 bg-[#202c33] px-6 flex items-center justify-between shrink-0 border-b border-[#313d45] transition-all">
        <div class="flex items-center gap-6">
            <button onclick="chatDetailsClearSelection()" class="text-[#aebac1] hover:text-white transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
                </svg>
            </button>
            <div class="flex flex-col">
                <h2 id="selection_count_title" class="text-[#e9edef] text-[19px] font-semibold">0</h2>
                <span id="selection_size_subtitle" class="text-[#8696a0] text-[13px]">0 KB</span>
            </div>
        </div>
        <div class="flex items-center gap-4 text-[#aebac1]">
            <button class="hover:text-white transition-colors" onclick="chatDetailsStarSelectedItems()">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                </svg>
            </button>
            <button class="hover:text-white transition-colors" onclick="chatDetailsDeleteSelectedItems()">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Sub-header (SIZE and Select All) -->
    <div class="bg-[#111b21] px-4 py-2 flex justify-between items-center shrink-0 border-b border-[#313d45]">
        <span class="text-[#8696a0] text-[13px] font-semibold tracking-wider">SIZE</span>
        <label class="flex items-center gap-2 cursor-pointer group">
            <span class="text-[#8696a0] text-[14px]">Select all</span>
            <div class="relative w-5 h-5 border-2 border-[#8696a0] rounded-[4px] flex items-center justify-center transition-colors group-hover:border-[#00a884]">
                <input type="checkbox" id="chat_details_select_all_checkbox" class="absolute opacity-0 w-full h-full cursor-pointer" onchange="chatDetailsToggleSelectAll(this.checked)">
                <svg id="chat_details_select_all_checkmark" class="hidden w-3.5 h-3.5 text-[#111b21]" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
            </div>
        </label>
    </div>

    <!-- Scrollable Grid -->
    <div class="flex-1 min-h-0 overflow-y-auto custom-scrollbar bg-[#111b21]">
        <div class="grid grid-cols-3 gap-0.5" id="chat_details_grid">
            <!-- Dynamic Grid Items Injected Here -->
        </div>
    </div>

    <!-- Sort Modal (Bottom Sheet) -->
    <div id="chat_details_sort_modal" class="hidden absolute inset-0 z-50 flex-col justify-end bg-black/50 transition-opacity">
        <div class="bg-[#233138] w-full rounded-t-2xl py-4 flex flex-col transform translate-y-full transition-transform duration-300" id="chat_details_sort_modal_sheet">
            <div class="px-6 pb-2 mb-2">
                <span class="text-[#8696a0] text-[15px]">Sort by</span>
            </div>
            <div class="flex items-center justify-between px-6 py-3 cursor-pointer hover:bg-[#182229] transition-colors" onclick="chatDetailsSelectSort('Newest')">
                <span class="text-[#e9edef] text-[16px]">Newest</span>
                <svg class="sort-check hidden w-5 h-5 text-[#00a884]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div class="flex items-center justify-between px-6 py-3 cursor-pointer hover:bg-[#182229] transition-colors" onclick="chatDetailsSelectSort('Oldest')">
                <span class="text-[#e9edef] text-[16px]">Oldest</span>
                <svg class="sort-check hidden w-5 h-5 text-[#00a884]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div class="flex items-center justify-between px-6 py-3 cursor-pointer hover:bg-[#182229] transition-colors" onclick="chatDetailsSelectSort('Largest')">
                <span class="text-[#e9edef] text-[16px]">Largest</span>
                <svg id="chat_details_sort_largest_check" class="sort-check w-5 h-5 text-[#00a884]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
            </div>
        </div>
    </div>

    <!-- Custom Delete Modal -->
    <div id="chat_details_delete_modal" class="hidden absolute inset-0 z-[1000] flex items-center justify-center bg-black/60 backdrop-blur-sm transition-all duration-300">
        <div class="bg-[#3b4a54] w-[90%] max-w-[340px] rounded-[3px] p-6 shadow-2xl transform scale-95 transition-all duration-300 opacity-0" id="chat_details_delete_modal_content">
            <h3 class="text-[#e9edef] text-[20px] font-normal mb-5">Delete items?</h3>
            <p class="text-[#8696a0] text-[15px] mb-8 leading-relaxed">Items will be deleted from your WhatsApp media, but they may still be saved on your device.</p>
            <div class="flex justify-end gap-6 items-center">
                <button onclick="chatDetailsCloseStorageDeleteModal()" class="text-[#00a884] font-medium text-[14px] hover:bg-white/5 px-3 py-2 rounded-lg transition-colors">Cancel</button>
                <button onclick="chatDetailsExecuteStorageDeletion()" class="text-[#00a884] font-medium text-[14px] hover:bg-white/5 px-3 py-2 rounded-lg transition-colors">Delete</button>
            </div>
        </div>
    </div>

</div>

<style>
    /* Styling for the custom checkbox to look like WhatsApp */
    .storage-checkbox-container input:checked + div {
        background-color: #00a884;
        border-color: #00a884;
    }
    .storage-checkbox-container input:checked + div svg {
        display: block;
    }
    
    /* Overlay for selected items */
    .grid-item-selected .selection-overlay {
        opacity: 1;
    }
    .grid-item-selected .item-checkbox div {
        background-color: #00a884;
        border-color: #00a884;
    }
    .grid-item-selected .item-checkbox div svg {
        display: block;
    }
</style>

<script>
    let chatDetailsMockMediaItems = [];
    let chatDetailsSelectedItems = new Set();
    let chatDetailsCurrentSort = 'Largest';
    window.currentChatDetailsId = null;

    window.openChatStorageDetails = function(chatId, name, avatar, size) {
        window.currentChatDetailsId = chatId;
        document.getElementById('chat_details_avatar').src = avatar;
        document.getElementById('chat_details_name').innerText = name;
        document.getElementById('chat_details_size').innerText = size;
        
        const storagePanel = document.getElementById('manage_storage_panel');
        const detailsPanel = document.getElementById('manage_storage_chat_details_panel');
        
        if (storagePanel) {
            storagePanel.classList.add('hidden');
            storagePanel.classList.remove('flex');
        }
        if (detailsPanel) {
            detailsPanel.classList.remove('hidden');
            detailsPanel.classList.add('flex');
            chatDetailsRenderGrid();
        }
    };
    
    window.closeChatStorageDetails = function() {
        const storagePanel = document.getElementById('manage_storage_panel');
        const detailsPanel = document.getElementById('manage_storage_chat_details_panel');
        
        if (detailsPanel) {
            detailsPanel.classList.add('hidden');
            detailsPanel.classList.remove('flex');
            
            chatDetailsClearSelection();
        }
        if (storagePanel) {
            storagePanel.classList.remove('hidden');
            storagePanel.classList.add('flex');
        }
    };

    window.chatDetailsRenderGrid = function() {
        if (!window.currentChatDetailsId) return;
        
        const dataSource = window.fullStorageCache || window.globalMediaCache || [];
        
        if (dataSource.length > 0) {
            chatDetailsMockMediaItems = [];
            dataSource.forEach(item => {
                // Filter by chatId
                if (!item.chatId || !item.chatId.includes(window.currentChatDetailsId.replace('chat_', ''))) {
                    return;
                }
                
                // Generate a deterministic pseudo-size if fileSize is missing
                let sizeMb = item.fileSize ? (item.fileSize / (1024 * 1024)) : 0;
                if (!sizeMb || sizeMb === 0) {
                    if (item.type === 'video') sizeMb = 12 + (item.key.length % 5);
                    else if (item.type === 'document') sizeMb = 6 + (item.key.length % 4);
                    else sizeMb = 2 + (item.key.length % 2); // Image
                }
                
                chatDetailsMockMediaItems.push({
                    id: item.key,
                    sizeMb: Math.round(sizeMb * 10) / 10,
                    name: item.fileName || 'Media',
                    type: item.type,
                    url: item.url,
                    chatId: item.chatId,
                    senderName: item.senderName,
                    timestamp: item.timestamp
                });
            });
        }
        
        const grid = document.getElementById('chat_details_grid');
        let html = '';
        
        // Apply Sort
        let sortedItems = [...chatDetailsMockMediaItems];
        if(chatDetailsCurrentSort === 'Largest') {
            sortedItems.sort((a, b) => b.sizeMb - a.sizeMb);
        } else if(chatDetailsCurrentSort === 'Newest') {
            sortedItems.sort((a, b) => a.id.localeCompare(b.id)); // Mock sort
        } else if(chatDetailsCurrentSort === 'Oldest') {
            sortedItems.sort((a, b) => b.id.localeCompare(a.id)); // Mock sort
        }

        sortedItems.forEach(item => {
            const isSelected = chatDetailsSelectedItems.has(item.id);
            
            let iconHtml = '';
            let bgClass = 'bg-[#182229]';
            
            // Extract extension
            let ext = 'DOC';
            if (item.name && item.name.includes('.')) {
                ext = item.name.split('.').pop().toUpperCase();
                if (ext.length > 4) ext = ext.substring(0, 4);
            }

            if (item.type === 'document') {
                iconHtml = `
                    <svg viewBox="0 0 24 24" width="48" height="48" fill="#8696a0">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 2l5 5h-5V4zM6 20V4h5v7h7v9H6z"></path>
                        <text x="12" y="16" font-family="Arial" font-size="6" font-weight="bold" fill="white" text-anchor="middle">${ext}</text>
                    </svg>`;
            } else if (item.type === 'video') {
                iconHtml = `
                    <div class="relative w-full h-full bg-[#111b21]">
                        <video src="${item.url}#t=0.1" class="w-full h-full object-cover" muted preload="metadata"></video>
                        <div class="absolute bottom-1 left-1 flex items-center gap-1 z-10 drop-shadow-md">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="white"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"></path></svg>
                        </div>
                    </div>`;
                bgClass = ''; // full inner content
            } else {
                iconHtml = `
                    <img src="${item.url}" class="w-full h-full object-cover">
                `;
                bgClass = '';
            }

            let isStarred = window.starredMsgKeys && window.starredMsgKeys.has(item.id);
            let starHtml = isStarred ? `
                <div class="absolute bottom-1.5 right-1.5 z-10 drop-shadow-md text-white/90">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor">
                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                    </svg>
                </div>` : '';

            html += `
                <div class="aspect-square relative cursor-pointer group ${isSelected ? 'grid-item-selected' : ''}" onclick="chatDetailsOpenRealMediaItem('${item.id}')">
                    <div class="w-full h-full ${bgClass} flex flex-col items-center justify-center relative overflow-hidden">
                        ${iconHtml}
                        
                        <div class="absolute top-1 right-2 text-white text-[12px] font-medium drop-shadow-md z-10">
                            ${item.sizeMb} MB
                        </div>
                        
                        ${item.type === 'document' ? `<div class="absolute bottom-1 left-2 right-6 text-white text-[11px] truncate z-10">${item.name}</div>` : ''}
                        ${item.type === 'image' ? `<div class="absolute bottom-1 left-2 right-6 text-white text-[11px] truncate z-10 drop-shadow-md">${item.name}</div>` : ''}
                        
                        ${starHtml}

                        <!-- Selection Overlay -->
                        <div class="selection-overlay absolute inset-0 bg-white/30 opacity-0 transition-opacity z-20 pointer-events-none"></div>
                        
                        <!-- Checkbox -->
                        <div class="item-checkbox absolute top-1.5 left-1.5 z-30 p-2 -m-2 opacity-0 group-hover:opacity-100 transition-opacity ${isSelected ? '!opacity-100' : ''}" onclick="event.stopPropagation(); chatDetailsToggleItemSelection('${item.id}')">
                            <div class="w-5 h-5 border-[1.5px] border-white rounded-[4px] flex items-center justify-center transition-colors shadow-sm bg-black/20 hover:bg-black/40">
                                <svg class="hidden w-3.5 h-3.5 text-[#111b21]" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        
        document.getElementById('chat_details_grid').innerHTML = html;
        chatDetailsUpdateSelectionHeader();
    }

    function chatDetailsOpenRealMediaItem(id) {
        const item = chatDetailsMockMediaItems.find(m => m.id === id);
        if (!item) return;
        
        const senderName = item.senderName || 'Unknown';
        const timestamp = item.timestamp || '';
        const name = item.name || 'Media';
        
        if (item.type === 'image' && window.openGlobalSearchImageViewer) {
            window.openGlobalSearchImageViewer(item.id, item.chatId, item.url, senderName, timestamp, false, name);
        } else if (item.type === 'video' && window.openGlobalSearchVideoViewer) {
            window.openGlobalSearchVideoViewer(item.id, item.chatId, item.url, senderName, timestamp, false, name);
        } else if (item.type === 'document') {
            window.open(item.url, '_blank');
        } else if (window.showToast) {
            window.showToast('Opening File', `Simulating opening ${item.type} file...`);
        }
    }

    function chatDetailsStarSelectedItems() {
        if (chatDetailsSelectedItems.size === 0) return;
        
        let promises = [];
        chatDetailsSelectedItems.forEach(id => {
            const item = chatDetailsMockMediaItems.find(m => m.id === id);
            if (item && window.db && window.myUserId) {
                promises.push(window.set(window.ref(window.db, `starred_messages/${window.myUserId}/${item.id}`), {
                    text: '',
                    type: item.type,
                    file_url: item.url,
                    file_name: item.name || null,
                    time: item.timestamp,
                    sender_id: item.senderId || window.myUserId,
                    chat_id: item.chatId
                }));
                if (window.starredMsgKeys) window.starredMsgKeys.add(item.id);
            }
        });
        
        Promise.all(promises).then(() => {
            if(window.showToast) window.showToast('Starred', `${chatDetailsSelectedItems.size} message(s) starred.`);
            chatDetailsClearSelection();
            chatDetailsRenderGrid();
        }).catch(err => {
            if (window.showToast) window.showToast('Error', 'Failed to star messages.');
        });
    }

    function chatDetailsDeleteSelectedItems() {
        if (chatDetailsSelectedItems.size === 0) return;
        
        // Show custom modal instead of native confirm
        const modal = document.getElementById('chat_details_delete_modal');
        const content = document.getElementById('chat_details_delete_modal_content');
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }
    
    function chatDetailsCloseStorageDeleteModal() {
        const modal = document.getElementById('chat_details_delete_modal');
        const content = document.getElementById('chat_details_delete_modal_content');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
    
    function chatDetailsExecuteStorageDeletion() {
        chatDetailsCloseStorageDeleteModal();
        if (chatDetailsSelectedItems.size === 0) return;
        
        let promises = [];
        chatDetailsSelectedItems.forEach(id => {
            const item = chatDetailsMockMediaItems.find(m => m.id === id);
            if (item && window.db) {
                let refPath = '';
                if (item.chatId.startsWith('group_')) {
                    refPath = `groups/${item.chatId.replace('group_', '')}/messages/${item.id}`;
                } else {
                    refPath = `chats/${item.chatId}/messages/${item.id}`;
                }
                promises.push(window.remove(window.ref(window.db, refPath)));
            }
        });
        
        Promise.all(promises).then(() => {
            // Remove from local cache
            if (window.fullStorageCache) {
                window.fullStorageCache = window.fullStorageCache.filter(m => !chatDetailsSelectedItems.has(m.key));
            }
            if (window.globalMediaCache) {
                window.globalMediaCache = window.globalMediaCache.filter(m => !chatDetailsSelectedItems.has(m.key));
            }
            
            if(window.showToast) window.showToast('Deleted', `${chatDetailsSelectedItems.size} message(s) deleted.`);
            chatDetailsClearSelection();
            
            // Re-render
            chatDetailsRenderGrid();
            
            // Tell parent manage_storage to update sizes
            if (typeof updateStorageUIDynamically === 'function') {
                updateStorageUIDynamically();
            }
        }).catch(err => {
            if (window.showToast) window.showToast('Error', 'Failed to delete messages.');
        });
    }

    function chatDetailsToggleItemSelection(id) {
        if (chatDetailsSelectedItems.has(id)) {
            chatDetailsSelectedItems.delete(id);
        } else {
            chatDetailsSelectedItems.add(id);
        }
        
        // Check if all are selected to update the "Select all" checkbox
        const selectAllCb = document.getElementById('chat_details_select_all_checkbox');
        const selectAllIcon = document.getElementById('chat_details_select_all_checkmark');
        const selectAllBox = selectAllCb.nextElementSibling;
        
        if (chatDetailsSelectedItems.size === chatDetailsMockMediaItems.length && chatDetailsMockMediaItems.length > 0) {
            selectAllCb.checked = true;
            selectAllBox.classList.add('bg-[#00a884]', 'border-[#00a884]');
            selectAllIcon.classList.remove('hidden');
        } else {
            selectAllCb.checked = false;
            selectAllBox.classList.remove('bg-[#00a884]', 'border-[#00a884]');
            selectAllIcon.classList.add('hidden');
        }

        chatDetailsRenderGrid(); // Re-render to update classes (inefficient but works for mock)
    }

    function chatDetailsToggleSelectAll(isChecked) {
        if (isChecked) {
            chatDetailsMockMediaItems.forEach(item => chatDetailsSelectedItems.add(item.id));
            const selectAllIcon = document.getElementById('chat_details_select_all_checkmark');
            selectAllIcon.classList.remove('hidden');
            selectAllIcon.parentElement.classList.add('bg-[#00a884]', 'border-[#00a884]');
        } else {
            chatDetailsSelectedItems.clear();
            const selectAllIcon = document.getElementById('chat_details_select_all_checkmark');
            selectAllIcon.classList.add('hidden');
            selectAllIcon.parentElement.classList.remove('bg-[#00a884]', 'border-[#00a884]');
        }
        chatDetailsRenderGrid();
    }

    function chatDetailsClearSelection() {
        document.getElementById('chat_details_select_all_checkbox').checked = false;
        chatDetailsToggleSelectAll(false);
    }

    function chatDetailsUpdateSelectionHeader() {
        const defaultHeader = document.getElementById('chat_details_default_header');
        const selectionHeader = document.getElementById('chat_details_selection_header');
        
        if (chatDetailsSelectedItems.size > 0) {
            defaultHeader.classList.add('hidden');
            selectionHeader.classList.remove('hidden');
            
            document.getElementById('selection_count_title').innerText = chatDetailsSelectedItems.size;
            
            let totalMb = 0;
            chatDetailsSelectedItems.forEach(id => {
                const item = chatDetailsMockMediaItems.find(m => m.id === id);
                if(item) totalMb += item.sizeMb;
            });
            
            let sizeText = totalMb >= 1000 ? (totalMb/1000).toFixed(1) + ' GB' : totalMb + ' MB';
            document.getElementById('selection_size_subtitle').innerText = sizeText;
        } else {
            defaultHeader.classList.remove('hidden');
            selectionHeader.classList.add('hidden');
        }
    }

    // Sort Modal Logic
    function chatDetailsToggleSortModal() {
        const modal = document.getElementById('chat_details_sort_modal');
        const sheet = document.getElementById('chat_details_sort_modal_sheet');
        
        modal.classList.remove('hidden');
        // trigger reflow
        void modal.offsetWidth;
        
        sheet.classList.remove('translate-y-full');
        sheet.classList.add('translate-y-0');
    }

    function chatDetailsCloseSortModal() {
        const modal = document.getElementById('chat_details_sort_modal');
        const sheet = document.getElementById('chat_details_sort_modal_sheet');
        
        sheet.classList.remove('translate-y-0');
        sheet.classList.add('translate-y-full');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function chatDetailsSelectSort(sortType) {
        chatDetailsCurrentSort = sortType;
        
        // Update checks in modal
        document.querySelectorAll('.sort-check').forEach(el => el.classList.add('hidden'));
        event.currentTarget.querySelector('.sort-check').classList.remove('hidden');
        
        chatDetailsCloseSortModal();
        chatDetailsRenderGrid();
    }
</script>
