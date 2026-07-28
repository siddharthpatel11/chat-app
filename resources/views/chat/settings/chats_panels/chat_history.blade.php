<div id="chat_history_panel"
    class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden absolute sm:relative z-20">
    
    <!-- Main Chat History View -->
    <div id="chat_history_main_view" class="flex flex-col h-full w-full">
        <!-- Header -->
        <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
            <button onclick="closeChatHistoryPanel()" class="text-[#aebac1] hover:text-white transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
                </svg>
            </button>
            <h2 class="text-[#e9edef] text-[19px] font-semibold">Chat history</h2>
        </div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] py-2">
            <!-- Export chat -->
            <div class="flex items-center py-4 hover:bg-[#202c33] px-6 transition-colors cursor-pointer group" onclick="openExportChatView()">
                <div class="text-[#8696a0] mr-6">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                        <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="text-[#e9edef] text-[16px]">Export chat</div>
                </div>
            </div>

            <!-- Archive all chats -->
            <div class="flex items-center py-4 hover:bg-[#202c33] px-6 transition-colors cursor-pointer group" onclick="openArchiveAllChatsModal()">
                <div class="text-[#8696a0] mr-6">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                        <path d="M20.54 5.23l-1.39-1.68C18.88 3.21 18.47 3 18 3H6c-.47 0-.88.21-1.16.55L3.46 5.23C3.17 5.57 3 6.02 3 6.5V19c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6.5c0-.48-.17-.93-.46-1.27zM6.24 5h11.52l.83 1H5.42l.82-1zM5 19V8h14v11H5zm6-5.5l-4-4h2.5V6h3v3.5H15l-4 4z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <div id="archive_all_chats_label" class="text-[#e9edef] text-[16px]">Archive all chats</div>
                </div>
            </div>

            <!-- Clear all chats -->
            <div class="flex items-center py-4 hover:bg-[#202c33] px-6 transition-colors cursor-pointer group" onclick="openClearAllChatsModal()">
                <div class="text-[#8696a0] mr-6">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                        <path d="M19 13H5v-2h14v2z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="text-[#e9edef] text-[16px]">Clear all chats</div>
                </div>
            </div>

            <!-- Delete all chats -->
            <div class="flex items-center py-4 hover:bg-[#202c33] px-6 transition-colors cursor-pointer group" onclick="openDeleteAllChatsModal()">
                <div class="text-[#8696a0] mr-6">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zm2.46-7.12l1.41-1.41L12 12.59l2.12-2.12 1.41 1.41L13.41 14l2.12 2.12-1.41 1.41L12 15.41l-2.12 2.12-1.41-1.41L10.59 14l-2.13-2.12zM15.5 4l-1-1h-5l-1 1H5v2h14V4h-3.5z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="text-[#e9edef] text-[16px]">Delete all chats</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Chat Sub-View -->
    <div id="export_chat_sub_view" class="hidden flex-col h-full w-full bg-[#111b21] absolute inset-0 z-30">
        <!-- Header -->
        <div class="h-16 bg-[#202c33] px-6 flex items-center justify-between shrink-0 border-b border-[#313d45]">
            <div class="flex items-center gap-6">
                <button onclick="closeExportChatView()" class="text-[#aebac1] hover:text-white transition-colors">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
                    </svg>
                </button>
                <h2 class="text-[#e9edef] text-[19px] font-semibold">Choose chat</h2>
            </div>
            <button class="text-[#aebac1] hover:text-white transition-colors focus:outline-none">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 0 0 1.256-3.386 5.207 5.207 0 1 0-5.207 5.208 5.183 5.183 0 0 0 3.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-4.6-4.6v3.195a3.195 3.195 0 1 1 3.196-3.195 3.195 3.195 0 0 1-3.196 3.195z"></path>
                </svg>
            </button>
        </div>

        <!-- List -->
        <div class="flex-1 overflow-y-auto custom-scrollbar">
            <!-- Label -->
            <div class="px-6 py-4">
                <span class="text-[#8696a0] text-[14px] font-medium">Recent chats</span>
            </div>
            
            <!-- List Items populated by JS -->
            <div id="export_chat_list_container" class="flex flex-col"></div>
        </div>
    </div>
</div>

<!-- Modals -->



<!-- Archive All Chats Modal -->
<div id="archive_all_chats_modal" class="hidden fixed inset-0 z-[150] flex items-center justify-center p-4 bg-black/50">
    <div class="bg-[#3b4a54] rounded-xl shadow-lg w-full max-w-[350px] overflow-hidden flex flex-col">
        <div class="p-6">
            <p id="archive_all_chats_modal_text" class="text-[#e9edef] text-[16px]">Are you sure you want to archive ALL chats?</p>
        </div>
        <div class="flex justify-end p-4 gap-4 mt-auto">
            <button onclick="closeArchiveAllChatsModal()" class="text-[#00a884] hover:bg-[#00a884] hover:bg-opacity-10 px-4 py-2 rounded font-medium transition-colors">Cancel</button>
            <button onclick="confirmArchiveAllChats()" class="text-[#00a884] hover:bg-[#00a884] hover:bg-opacity-10 px-4 py-2 rounded font-medium transition-colors">OK</button>
        </div>
    </div>
</div>

<!-- Clear All Chats Modal -->
<div id="clear_all_chats_modal" class="hidden fixed inset-0 z-[150] flex items-center justify-center p-4 bg-black/50">
    <div class="bg-[#3b4a54] rounded-xl shadow-lg w-full max-w-[400px] overflow-hidden flex flex-col">
        <div class="p-6">
            <h3 class="text-[#e9edef] text-[20px] mb-4">Clear all chats?</h3>
            
            <label class="flex items-start gap-4 cursor-pointer mb-4">
                <div class="relative flex items-center mt-1">
                    <input type="checkbox" id="clear_all_chats_media" class="peer appearance-none w-5 h-5 border-2 border-[#8696a0] rounded-[3px] checked:bg-[#00a884] checked:border-[#00a884] transition-all">
                    <svg class="absolute w-3.5 h-3.5 pointer-events-none opacity-0 peer-checked:opacity-100 left-[3px] top-[3px] text-white" viewBox="0 0 14 10" fill="none">
                        <path d="M1 5L5 9L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="text-[#e9edef] text-[15px]">Also delete media received in chats from the device gallery</div>
            </label>
            
            <label class="flex items-start gap-4 cursor-pointer">
                <div class="relative flex items-center mt-1">
                    <input type="checkbox" id="clear_all_chats_starred" class="peer appearance-none w-5 h-5 border-2 border-[#8696a0] rounded-[3px] checked:bg-[#00a884] checked:border-[#00a884] transition-all">
                    <svg class="absolute w-3.5 h-3.5 pointer-events-none opacity-0 peer-checked:opacity-100 left-[3px] top-[3px] text-white" viewBox="0 0 14 10" fill="none">
                        <path d="M1 5L5 9L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="text-[#e9edef] text-[15px]">Delete starred messages</div>
            </label>
        </div>
        <div class="flex justify-end p-4 gap-4 mt-auto">
            <button onclick="closeClearAllChatsModal()" class="text-[#00a884] hover:bg-[#00a884] hover:bg-opacity-10 px-4 py-2 rounded font-medium transition-colors">Cancel</button>
            <button onclick="confirmClearAllChats()" class="text-[#00a884] hover:bg-[#00a884] hover:bg-opacity-10 px-4 py-2 rounded font-medium transition-colors">Clear chats</button>
        </div>
    </div>
</div>

<!-- Delete All Chats Modal -->
<div id="delete_all_chats_modal" class="hidden fixed inset-0 z-[150] flex items-center justify-center p-4 bg-black/50">
    <div class="bg-[#3b4a54] rounded-xl shadow-lg w-full max-w-[400px] overflow-hidden flex flex-col">
        <div class="p-6">
            <h3 class="text-[#e9edef] text-[20px] mb-4">Delete all chats?</h3>
            
            <label class="flex items-start gap-4 cursor-pointer mb-2">
                <div class="relative flex items-center mt-1">
                    <input type="checkbox" id="delete_all_chats_groups" class="peer appearance-none w-5 h-5 border-2 border-[#8696a0] rounded-[3px] checked:bg-[#00a884] checked:border-[#00a884] transition-all">
                    <svg class="absolute w-3.5 h-3.5 pointer-events-none opacity-0 peer-checked:opacity-100 left-[3px] top-[3px] text-white" viewBox="0 0 14 10" fill="none">
                        <path d="M1 5L5 9L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="text-[#e9edef] text-[15px]">Also exit all groups</div>
            </label>
        </div>
        <div class="flex justify-end p-4 gap-4 mt-auto">
            <button onclick="closeDeleteAllChatsModal()" class="text-[#00a884] hover:bg-[#00a884] hover:bg-opacity-10 px-4 py-2 rounded font-medium transition-colors">Cancel</button>
            <button onclick="confirmDeleteAllChats()" class="text-[#00a884] hover:bg-[#00a884] hover:bg-opacity-10 px-4 py-2 rounded font-medium transition-colors">Delete all</button>
        </div>
    </div>
</div>

<script>
    function toggleChatHistoryPanel() {
        const panel = document.getElementById('chat_history_panel');
        const chatsSettings = document.getElementById('chats_settings_panel');
        
        if (panel.classList.contains('hidden')) {
            panel.classList.remove('hidden');
            panel.classList.add('flex');
            if (chatsSettings) {
                chatsSettings.classList.remove('flex');
                chatsSettings.classList.add('hidden');
            }
        } else {
            closeChatHistoryPanel();
        }
    }

    function closeChatHistoryPanel() {
        const panel = document.getElementById('chat_history_panel');
        const chatsSettings = document.getElementById('chats_settings_panel');
        
        panel.classList.add('hidden');
        panel.classList.remove('flex');
        if (chatsSettings) {
            chatsSettings.classList.remove('hidden');
            chatsSettings.classList.add('flex');
        }
    }

    // Export Chat View
    function openExportChatView() {
        const container = document.getElementById('export_chat_list_container');
        container.innerHTML = '';
        
        const chatItems = document.querySelectorAll('.user-chat-item');
        
        // Use a Set to track added chats and avoid duplicates
        const addedChats = new Set();
        
        chatItems.forEach(item => {
            let chatId = item.getAttribute('data-userid');
            let isGroup = false;
            
            if (!chatId) {
                chatId = item.getAttribute('data-groupid');
                if (chatId) {
                    isGroup = true;
                    if (!chatId.startsWith('group_')) {
                        chatId = 'group_' + chatId;
                    }
                }
            }

            const name = item.getAttribute('data-name');
            const avatar = item.getAttribute('data-avatar');
            let about = item.getAttribute('data-about');
            
            if (!about) {
                if (chatId && chatId.toString().startsWith('broadcast_')) {
                    about = 'Broadcast List';
                } else if (isGroup) {
                    about = 'Group';
                }
            }
            
            if (chatId && name && chatId !== 'meta_ai' && !addedChats.has(chatId)) {
                addedChats.add(chatId);
                container.innerHTML += `
                    <div class="flex items-center px-4 py-3 hover:bg-[#202c33] cursor-pointer transition-colors" onclick="selectExportChat('${chatId}')">
                        <div class="relative w-12 h-12 rounded-full bg-[#2a3942] flex items-center justify-center shrink-0 overflow-hidden">
                            <img src="${avatar}" class="w-full h-full object-cover rounded-full" onerror="this.src='https://ui-avatars.com/api/?name=User&background=2a3942&color=fff'">
                        </div>
                        <div class="ml-4 flex-1 border-b border-[#202c33] pb-3 min-w-0 flex justify-between items-center">
                            <div class="flex flex-col flex-1 min-w-0 pr-4">
                                <h4 class="text-[17px] text-[#e9edef] truncate font-normal">${name}</h4>
                                <p class="text-[14px] text-[#8696a0] truncate leading-snug">${about || ''}</p>
                            </div>
                        </div>
                    </div>
                `;
            }
        });
        
        document.getElementById('chat_history_main_view').classList.add('hidden');
        document.getElementById('export_chat_sub_view').classList.remove('hidden');
        document.getElementById('export_chat_sub_view').classList.add('flex');
    }
    
    function closeExportChatView() {
        document.getElementById('export_chat_sub_view').classList.add('hidden');
        document.getElementById('export_chat_sub_view').classList.remove('flex');
        document.getElementById('chat_history_main_view').classList.remove('hidden');
    }
    
    function selectExportChat(chatId) {
        if (!chatId) return;
        
        let targetId = chatId;
        let isGroup = false;
        let isBroadcast = false;
        
        if (chatId.toString().startsWith('group_')) {
            targetId = chatId.replace('group_', '');
            isGroup = true;
        } else if (chatId.toString().startsWith('broadcast_')) {
            targetId = chatId.replace('broadcast_', '');
            isBroadcast = true;
        }
        
        let refPath = '';
        const myId = window.myUserId;
        
        if (isGroup) {
            refPath = `groups/${targetId}`;
        } else if (isBroadcast) {
            refPath = `broadcasts/${targetId}`;
        } else {
            if (!myId) {
                if (window.showToast) window.showToast('Error', 'User session missing.');
                return;
            }
            const minId = Math.min(parseInt(myId), parseInt(chatId));
            const maxId = Math.max(parseInt(myId), parseInt(chatId));
            refPath = `chats/chat_${minId}_${maxId}`;
        }
        
        if (window.db && window.get && window.ref) {
            
            // Function to load JSZip dynamically
            const loadJSZip = () => {
                return new Promise((resolve, reject) => {
                    if (window.JSZip) return resolve(window.JSZip);
                    const script = document.createElement('script');
                    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js';
                    script.onload = () => resolve(window.JSZip);
                    script.onerror = reject;
                    document.head.appendChild(script);
                });
            };
            
            // Remove extra toast notification


            Promise.all([
                loadJSZip(),
                window.get(window.ref(window.db, refPath))
            ]).then(async ([JSZip, snapshot]) => {
                const data = snapshot.val();
                if (!data) {
                    if (window.showToast) window.showToast('Error', 'Chat not found.');
                    return;
                }
                
                let messages = data.messages || {};
                let textContent = ``;
                
                // Get cleared timestamp
                const myId = window.myUserId || null; 
                let clearedAt = 0;
                if (myId && data.settings && data.settings[myId]) {
                    clearedAt = data.settings[myId].cleared_at || 0;
                }
                
                const zip = new JSZip();
                const mediaPromises = [];
                let mediaCount = 1;
                
                Object.values(messages).forEach(msg => {
                    const time = msg.time || msg.timestamp || 0;
                    if (time >= clearedAt) {
                        const date = new Date(time);
                        // Format: [1/27/26, 11:45:00 AM] Sender: Message
                        const dateStr = `[${date.toLocaleDateString()}, ${date.toLocaleTimeString()}]`;
                        const sender = msg.sender || 'Unknown';
                        
                        let text = msg.text || '';
                        
                        // Handle Media Files
                        if (msg.file_url) {
                            const ext = window.getFileExt ? window.getFileExt(msg.file_name || msg.file_url) : 'file';
                            const fileName = msg.file_name || `${msg.type || 'media'}_${mediaCount}.${ext}`;
                            mediaCount++;
                            text += (text ? ' ' : '') + `<Attached: ${fileName}>`;
                            
                            // Fix CORS for local uploads
                            let fileUrl = msg.file_url;
                            if (fileUrl.startsWith('http://localhost') || fileUrl.startsWith('http://127.0.0.1')) {
                                try {
                                    const urlObj = new URL(fileUrl);
                                    fileUrl = urlObj.pathname + urlObj.search;
                                } catch (e) {}
                            }
                            
                            // Queue download for media
                            mediaPromises.push(
                                fetch(fileUrl)
                                .then(res => res.blob())
                                .then(blob => {
                                    zip.file(fileName, blob);
                                })
                                .catch(err => console.warn('Failed to fetch media for export:', msg.file_url))
                            );
                        }
                        
                        textContent += `${dateStr} ${sender}: ${text}\n`;
                    }
                });
                
                zip.file("_chat.txt", textContent);
                
                // Download media files (silently)

                // Wait for all media files to be downloaded and added to zip
                await Promise.allSettled(mediaPromises);
                
                // Generate ZIP file (silently)

                // Generate ZIP and Download
                zip.generateAsync({ type: "blob" }).then(function (content) {
                    const url = window.URL.createObjectURL(content);
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = url;
                    a.download = `WhatsApp_Chat_${chatId}.zip`;
                    document.body.appendChild(a);
                    a.click();
                    
                    setTimeout(() => {
                        document.body.removeChild(a);
                        window.URL.revokeObjectURL(url);
                    }, 500);
                    
                    closeExportChatView();
                    if (window.showToast) window.showToast('Success', 'Chat exported successfully.');
                });
                
            }).catch(err => {
                console.error(err);
                if (window.showToast) window.showToast('Error', 'Failed to generate export.');
            });
        } else {
            if (window.showToast) window.showToast('Error', 'Database connection not available.');
        }
    }

    // Archive All
    window.checkArchiveAllStatus = function() {
        const chatItems = document.querySelectorAll('.user-chat-item');
        let unarchivedCount = 0;
        chatItems.forEach(item => {
            if (item.id && (!window.archivedChats || !window.archivedChats.includes(item.id))) {
                unarchivedCount++;
            }
        });
        
        window.isUnarchiveAllAction = (unarchivedCount === 0 && chatItems.length > 0);
        
        const label = document.getElementById('archive_all_chats_label');
        if (label) {
            label.textContent = window.isUnarchiveAllAction ? 'Unarchive all chats' : 'Archive all chats';
        }
    };

    // Run initially to set the correct label
    setTimeout(() => {
        if (window.checkArchiveAllStatus) window.checkArchiveAllStatus();
    }, 1000);

    function openArchiveAllChatsModal() {
        if (window.checkArchiveAllStatus) window.checkArchiveAllStatus();
        const textEl = document.getElementById('archive_all_chats_modal_text');
        if (textEl) {
            textEl.textContent = window.isUnarchiveAllAction 
                ? 'Are you sure you want to unarchive ALL chats?' 
                : 'Are you sure you want to archive ALL chats?';
        }
        document.getElementById('archive_all_chats_modal').classList.remove('hidden');
    }
    function closeArchiveAllChatsModal() {
        document.getElementById('archive_all_chats_modal').classList.add('hidden');
    }
    function confirmArchiveAllChats() {
        const chatItems = document.querySelectorAll('.user-chat-item');
        
        if (!window.archivedChats) window.archivedChats = [];
        
        if (window.isUnarchiveAllAction) {
            // Unarchive all: empty the array
            window.archivedChats = [];
        } else {
            // Archive all
            chatItems.forEach(item => {
                const id = item.id;
                if (id && !window.archivedChats.includes(id)) {
                    window.archivedChats.push(id);
                }
            });
        }
        
        localStorage.setItem('archived_chats', JSON.stringify(window.archivedChats));
        
        closeArchiveAllChatsModal();
        if (window.showToast) window.showToast('Success', window.isUnarchiveAllAction ? 'All chats unarchived.' : 'All chats archived.');
        setTimeout(() => window.location.reload(), 1000);
    }

    // Clear All
    function openClearAllChatsModal() {
        document.getElementById('clear_all_chats_modal').classList.remove('hidden');
    }
    function closeClearAllChatsModal() {
        document.getElementById('clear_all_chats_modal').classList.add('hidden');
    }
    function confirmClearAllChats() {
        const chatItems = document.querySelectorAll('.user-chat-item');
        const now = Math.floor(Date.now() / 1000);
        
        chatItems.forEach(item => {
            const id = item.id;
            if (id) {
                window.clearedChats[id] = now;
            }
        });
        
        localStorage.setItem('cleared_chats', JSON.stringify(window.clearedChats));
        
        closeClearAllChatsModal();
        if (window.showToast) window.showToast('Success', 'All chats cleared.');
        setTimeout(() => window.location.reload(), 1000);
    }

    // Delete All
    function openDeleteAllChatsModal() {
        document.getElementById('delete_all_chats_modal').classList.remove('hidden');
    }
    function closeDeleteAllChatsModal() {
        document.getElementById('delete_all_chats_modal').classList.add('hidden');
    }
    function confirmDeleteAllChats() {
        const chatItems = document.querySelectorAll('.user-chat-item');
        const now = Math.floor(Date.now() / 1000);
        
        chatItems.forEach(item => {
            const id = item.id;
            if (id) {
                if (!window.deletedChats.includes(id)) {
                    window.deletedChats.push(id);
                }
                window.clearedChats[id] = now;
            }
        });
        
        localStorage.setItem('deleted_chats', JSON.stringify(window.deletedChats));
        localStorage.setItem('cleared_chats', JSON.stringify(window.clearedChats));
        
        closeDeleteAllChatsModal();
        if (window.showToast) window.showToast('Success', 'All chats deleted.');
        setTimeout(() => window.location.reload(), 1000);
    }
</script>
