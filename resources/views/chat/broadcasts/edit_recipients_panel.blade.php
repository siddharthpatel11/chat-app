<div id="edit_recipients_panel"
    class="fixed top-0 right-0 h-screen w-[400px] bg-[#111b21] border-l border-[#313d45] z-[410] flex flex-col shadow-2xl transition-all duration-300 translate-x-full">
    
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center justify-between shrink-0 border-b border-[#313d45]">
        <div class="flex items-center gap-6">
            <button onclick="closeEditRecipients()" class="text-[#aebac1] hover:text-white transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
            </button>
            <div class="flex flex-col">
                <h2 class="text-[#e9edef] text-[16px] font-medium leading-tight">Edit recipients</h2>
                <span id="edit_selected_count" class="text-[#8696a0] text-xs">2 of 256 selected</span>
            </div>
        </div>
        
        <!-- Search Icon -->
        <button id="edit_recipients_search_btn" onclick="toggleEditSearchInput()" class="text-[#aebac1] hover:text-[#e9edef]">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
            </svg>
        </button>
    </div>

    <!-- Horizontal Selected Avatars List (Image 5 style) -->
    <div id="edit_selected_avatars_container" class="p-3 bg-[#111b21] flex gap-4 overflow-x-auto custom-scrollbar border-b border-[#202c33] hidden">
        <!-- Dynamic circular avatars with X badges -->
    </div>

    <!-- Search Input -->
    <div id="edit_recipients_search_box" class="p-2 border-b border-[#202c33] bg-[#111b21] shrink-0 hidden">
        <div class="bg-[#202c33] rounded-lg flex items-center px-3 py-1.5 h-9 transition-all duration-200 focus-within:bg-[#2a3942]">
            <div class="relative w-6 h-6 shrink-0">
                <svg class="w-[18px] h-[18px] text-[#8696a0] absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 0 0 1.256-3.386 5.207 5.207 0 1 0-5.207 5.208 5.183 5.183 0 0 0 3.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-4.6-1.598a3.608 3.608 0 1 1 0-7.216 3.608 3.608 0 0 1 0 7.216z"></path>
                </svg>
            </div>
            <input type="text" id="edit_recipients_search" placeholder="Search name or number" class="bg-transparent border-none focus:ring-0 w-full text-sm ml-2 text-[#d1d7db] placeholder-[#8696a0]">
        </div>
    </div>

    <!-- Contacts list -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21]">
        <div class="py-2">
            <div id="edit_recipients_contacts_list">
                @foreach($users ?? [] as $user)
                    @php
                        $userAvatar = $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?: $user->phone) . '&background=2a3942&color=fff';
                    @endphp
                    <div onclick="window.toggleEditRecipientRow({{ $user->id }}, '{{ addslashes($user->name ?: $user->phone) }}', '{{ $userAvatar }}')"
                        class="flex items-center px-3 py-3 hover:bg-[#202c33] cursor-pointer transition-colors edit-recipient-item" data-name="{{ strtolower($user->name ?: $user->phone) }}" id="edit_recipient_row_{{ $user->id }}">
                        <div class="w-12 h-12 rounded-full bg-[#2a3942] flex items-center justify-center shrink-0 ml-1 relative">
                            <div class="w-12 h-12 rounded-full overflow-hidden">
                                <img src="{{ $userAvatar }}" class="w-full h-full object-cover">
                            </div>
                            <!-- Checked circle overlay if selected -->
                            <div class="absolute bottom-0 right-0 w-[18px] h-[18px] bg-[#00a884] rounded-full flex items-center justify-center text-[#111b21] border border-[#111b21] hidden check-overlay">
                                <svg viewBox="0 0 24 24" width="10" height="10" fill="currentColor" class="text-[#111b21] font-bold">
                                    <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 flex-1 border-b border-[#202c33] pb-3 pt-1 min-w-0">
                            <h4 class="text-[17px] text-[#e9edef] truncate mr-2 font-normal">{{ $user->name ?: $user->phone }}</h4>
                            <p class="text-[14px] text-[#8696a0] truncate mt-0.5 leading-snug">{{ $user->about ?? 'Available' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Bottom Save Check Mark Floating Button -->
    <div class="absolute bottom-6 right-6 z-10">
        <button onclick="saveEditRecipientsChanges()" class="w-14 h-14 bg-[#00a884] hover:bg-[#00bfa5] rounded-full flex items-center justify-center text-white shadow-lg transition-colors">
            <svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor">
                <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path>
            </svg>
        </button>
    </div>
</div>

<script>
    let tempSelectedRecipients = [];

    window.openEditRecipients = function() {
        const list = window.activeBroadcastList;
        if (!list) return;

        // Reset search
        document.getElementById('edit_recipients_search').value = '';
        document.getElementById('edit_recipients_search_box').classList.add('hidden');
        filterEditContacts('');

        // Populate selected recipients array
        tempSelectedRecipients = [...list.recipients];

        // Toggle layout (slide in from right)
        const editPanel = document.getElementById('edit_recipients_panel');
        const mainChat = document.getElementById('main_chat_column');

        editPanel.classList.remove('translate-x-full');
        editPanel.classList.add('translate-x-0');

        // Adjust main chat width on desktop
        if (window.innerWidth >= 640 && mainChat) {
            mainChat.classList.add('sm:mr-[400px]');
        }

        updateEditRecipientsUI();
    };

    window.closeEditRecipients = function() {
        const editPanel = document.getElementById('edit_recipients_panel');
        const mainChat = document.getElementById('main_chat_column');
        const bcastInfo = document.getElementById('broadcast_info_panel');

        if (editPanel) {
            editPanel.classList.remove('translate-x-0');
            editPanel.classList.add('translate-x-full');
        }

        // Adjust main chat width on desktop
        // If broadcast info panel is still open (does not have translate-x-full), keep sm:mr-[400px]
        if (mainChat && window.innerWidth >= 640) {
            if (bcastInfo && !bcastInfo.classList.contains('translate-x-full')) {
                // Keep sm:mr-[400px] since info panel is still open
            } else {
                mainChat.classList.remove('sm:mr-[400px]');
            }
        }
    };

    window.toggleEditSearchInput = function() {
        const box = document.getElementById('edit_recipients_search_box');
        if (box) {
            box.classList.toggle('hidden');
            if (!box.classList.contains('hidden')) {
                document.getElementById('edit_recipients_search').focus();
            }
        }
    };

    window.toggleEditRecipientRow = function(userId, name, avatar) {
        const index = tempSelectedRecipients.findIndex(u => u.id === userId);
        if (index === -1) {
            tempSelectedRecipients.push({ id: userId, name: name, avatar: avatar });
        } else {
            tempSelectedRecipients.splice(index, 1);
        }
        updateEditRecipientsUI();
    };

    function updateEditRecipientsUI() {
        const countSpan = document.getElementById('edit_selected_count');
        const container = document.getElementById('edit_selected_avatars_container');
        
        countSpan.textContent = `${tempSelectedRecipients.length} of 256 selected`;

        // Update list checkmarks
        document.querySelectorAll('.edit-recipient-item').forEach(item => {
            const checkOverlay = item.querySelector('.check-overlay');
            if (checkOverlay) checkOverlay.classList.add('hidden');
        });

        container.innerHTML = '';

        if (tempSelectedRecipients.length > 0) {
            container.classList.remove('hidden');
            container.classList.add('flex');

            tempSelectedRecipients.forEach(user => {
                // Show check on list
                const row = document.getElementById(`edit_recipient_row_${user.id}`);
                if (row) {
                    const checkOverlay = row.querySelector('.check-overlay');
                    if (checkOverlay) checkOverlay.classList.remove('hidden');
                }

                // Add circular avatar chip with X overlay (Image 5 style)
                const chip = document.createElement('div');
                chip.className = "flex flex-col items-center shrink-0 w-14 text-center cursor-pointer relative";
                chip.onclick = () => window.toggleEditRecipientRow(user.id, user.name, user.avatar);
                
                chip.innerHTML = `
                    <div class="w-12 h-12 rounded-full overflow-hidden bg-[#2a3942] relative mb-1">
                        <img src="${user.avatar}" class="w-full h-full object-cover">
                        <!-- Small cross circle at bottom right -->
                        <div class="absolute bottom-0 right-0 w-4 h-4 bg-[#8696a0] hover:bg-[#f15c6d] rounded-full flex items-center justify-center text-[#111b21] font-bold text-[9px] border border-[#111b21]">
                            ✕
                        </div>
                    </div>
                    <span class="text-[11px] text-[#8696a0] truncate w-full select-none">${user.name.split(' ')[0]}</span>
                `;
                container.appendChild(chip);
            });
        } else {
            container.classList.add('hidden');
            container.classList.remove('flex');
        }
    }

    // Search contacts filter
    const editSearch = document.getElementById('edit_recipients_search');
    if (editSearch) {
        editSearch.addEventListener('input', function(e) {
            filterEditContacts(e.target.value.toLowerCase());
        });
    }

    function filterEditContacts(term) {
        const items = document.querySelectorAll('.edit-recipient-item');
        items.forEach(item => {
            const name = item.getAttribute('data-name');
            if (name.includes(term)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }

    window.saveEditRecipientsChanges = function() {
        if (tempSelectedRecipients.length < 2) {
            window.showToast?.('Alert', 'Please select at least 2 contacts.');
            return;
        }

        const list = window.activeBroadcastList;
        if (!list) return;

        // Update recipients
        list.recipients = tempSelectedRecipients;

        // Update in localStorage
        window.broadcastLists = window.broadcastLists.map(l => l.id === list.id ? list : l);
        localStorage.setItem('broadcast_lists', JSON.stringify(window.broadcastLists));

        // Close editor
        window.closeEditRecipients();

        // Update active UI details
        document.getElementById('bcast_info_subtitle').textContent = `Broadcast List · ${list.recipients.length} recipients`;
        document.getElementById('bcast_info_recipients_title').textContent = `${list.recipients.length} recipients`;
        
        const subtitleEl = document.getElementById('active_chat_subtitle');
        if (subtitleEl && window.currentChatId === `broadcast_${list.id}`) {
            subtitleEl.textContent = `Broadcast (${list.recipients.length} recipients)`;
        }

        // Re-render
        window.renderBroadcastLists();
        window.openBroadcastInfo(); // Refresh info list
        window.showToast?.('Success', 'Broadcast list updated.');
    };
</script>
