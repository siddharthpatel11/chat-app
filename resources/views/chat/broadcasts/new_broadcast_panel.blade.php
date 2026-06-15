<div id="new_broadcast_select_panel"
    class="hidden flex-col w-[30%] sm:min-w-[300px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden z-[65]">
    
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="toggleNewBroadcastSelection()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
            </svg>
        </button>
        <div class="flex flex-col">
            <h2 class="text-[#e9edef] text-[16px] font-medium leading-tight">New broadcast</h2>
            <span id="selected_broadcast_count" class="text-[#8696a0] text-xs">0 selected</span>
        </div>
    </div>

    <!-- Chips Container for Selected Contacts -->
    <div id="selected_broadcast_chips" class="p-3 bg-[#111b21] flex flex-wrap gap-2 border-b border-[#202c33] hidden">
        <!-- JS dynamically adds chips here -->
    </div>

    <!-- Search Bar -->
    <div class="p-2 border-b border-[#202c33] bg-[#111b21] shrink-0">
        <div class="bg-[#202c33] rounded-lg flex items-center px-3 py-1.5 h-9 transition-all duration-200 focus-within:bg-[#2a3942]">
            <div class="relative w-6 h-6 shrink-0">
                <svg class="w-[18px] h-[18px] text-[#8696a0] absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 0 0 1.256-3.386 5.207 5.207 0 1 0-5.207 5.208 5.183 5.183 0 0 0 3.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-4.6-1.598a3.608 3.608 0 1 1 0-7.216 3.608 3.608 0 0 1 0 7.216z"></path>
                </svg>
            </div>
            <input type="text" id="new_broadcast_search" placeholder="Search name or number" class="bg-transparent border-none focus:ring-0 w-full text-sm ml-2 text-[#d1d7db] placeholder-[#8696a0]">
        </div>
    </div>

    <!-- Contacts list -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21]">
        <div class="py-2">
            <div id="new_broadcast_contacts_list">
                @foreach($users ?? [] as $user)
                    @php
                        $userAvatar = $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?: $user->phone) . '&background=2a3942&color=fff';
                    @endphp
                    <div onclick="window.toggleBroadcastMemberSelection({{ $user->id }}, '{{ addslashes($user->name ?: $user->phone) }}', '{{ $userAvatar }}')"
                        class="flex items-center px-3 py-3 hover:bg-[#202c33] cursor-pointer transition-colors broadcast-member-item" data-name="{{ strtolower($user->name ?: $user->phone) }}" id="broadcast_member_row_{{ $user->id }}">
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

    <!-- Bottom Check Mark Arrow (Visible when at least 2 members are selected) -->
    <div id="create_broadcast_btn_container" class="p-4 bg-[#111b21] flex justify-center border-t border-[#202c33] hidden">
        <button onclick="saveNewBroadcastList()" class="w-14 h-14 bg-[#00a884] hover:bg-[#00bfa5] rounded-full flex items-center justify-center text-white shadow-lg transition-colors">
            <svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor">
                <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path>
            </svg>
        </button>
    </div>
</div>

<script>
    let selectedBroadcastMembers = [];

    window.toggleNewBroadcastSelection = function() {
        const selectPanel = document.getElementById('new_broadcast_select_panel');
        const broadcastPanel = document.getElementById('broadcast_lists_panel');
        
        if (selectPanel.classList.contains('hidden')) {
            broadcastPanel.classList.add('hidden');
            broadcastPanel.classList.remove('flex');
            
            selectPanel.classList.remove('hidden');
            selectPanel.classList.add('flex');
            document.getElementById('new_broadcast_search').focus();
        } else {
            selectPanel.classList.add('hidden');
            selectPanel.classList.remove('flex');
            
            broadcastPanel.classList.remove('hidden');
            broadcastPanel.classList.add('flex');
            
            // reset selection
            selectedBroadcastMembers = [];
            updateBroadcastMembersUI();
        }
    };

    window.openNewBroadcastSelection = function() {
        window.toggleNewBroadcastSelection();
    };

    window.toggleBroadcastMemberSelection = function(userId, name, avatar) {
        const index = selectedBroadcastMembers.findIndex(u => u.id === userId);
        if (index === -1) {
            selectedBroadcastMembers.push({ id: userId, name: name, avatar: avatar });
        } else {
            selectedBroadcastMembers.splice(index, 1);
        }
        updateBroadcastMembersUI();
    };

    function updateBroadcastMembersUI() {
        const countSpan = document.getElementById('selected_broadcast_count');
        const chipsContainer = document.getElementById('selected_broadcast_chips');
        const nextBtnContainer = document.getElementById('create_broadcast_btn_container');
        
        countSpan.textContent = `${selectedBroadcastMembers.length} selected`;

        // Update list checkmarks
        document.querySelectorAll('.broadcast-member-item').forEach(item => {
            const checkOverlay = item.querySelector('.check-overlay');
            if (checkOverlay) checkOverlay.classList.add('hidden');
        });

        chipsContainer.innerHTML = '';

        if (selectedBroadcastMembers.length > 0) {
            chipsContainer.classList.remove('hidden');
            
            // In WhatsApp, broadcast list requires at least 2 recipients
            if (selectedBroadcastMembers.length >= 2) {
                nextBtnContainer.classList.remove('hidden');
            } else {
                nextBtnContainer.classList.add('hidden');
            }

            selectedBroadcastMembers.forEach(user => {
                // Show check on list
                const row = document.getElementById(`broadcast_member_row_${user.id}`);
                if (row) {
                    const checkOverlay = row.querySelector('.check-overlay');
                    if (checkOverlay) checkOverlay.classList.remove('hidden');
                }

                // Add chip
                const chip = document.createElement('div');
                chip.className = "flex items-center gap-1.5 bg-[#202c33] border border-[#313d45] rounded-full px-3 py-1 text-white text-sm";
                chip.innerHTML = `
                    <div class="w-5 h-5 rounded-full overflow-hidden bg-[#2a3942] shrink-0">
                        <img src="${user.avatar}" class="w-full h-full object-cover">
                    </div>
                    <span class="max-w-[120px] truncate select-none">${user.name}</span>
                    <button onclick="event.stopPropagation(); window.toggleBroadcastMemberSelection(${user.id}, '${user.name.replace(/'/g, "\\'")}', '${user.avatar}')" class="text-[#8696a0] hover:text-[#f15c6d] font-bold text-xs ml-1 focus:outline-none">✕</button>
                `;
                chipsContainer.appendChild(chip);
            });
        } else {
            chipsContainer.classList.add('hidden');
            nextBtnContainer.classList.add('hidden');
        }
    }

    // Search filter for contacts
    const newBroadcastSearch = document.getElementById('new_broadcast_search');
    if (newBroadcastSearch) {
        newBroadcastSearch.addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            const items = document.querySelectorAll('.broadcast-member-item');
            
            items.forEach(item => {
                const name = item.getAttribute('data-name');
                if (name.includes(term)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    window.saveNewBroadcastList = function() {
        if (selectedBroadcastMembers.length < 2) {
            window.showToast?.('Alert', 'Please select at least 2 contacts for a broadcast list.');
            return;
        }

        // Auto generate name e.g. "Kanoo, Z Nishit"
        const sortedNames = selectedBroadcastMembers.map(m => m.name).sort();
        const autoName = sortedNames.join(', ');

        const newList = {
            id: 'bcast_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9),
            name: autoName,
            recipients: selectedBroadcastMembers
        };

        const existingLists = JSON.parse(localStorage.getItem('broadcast_lists') || '[]');
        existingLists.unshift(newList);
        localStorage.setItem('broadcast_lists', JSON.stringify(existingLists));

        // Close selection panel
        const selectPanel = document.getElementById('new_broadcast_select_panel');
        selectPanel.classList.add('hidden');
        selectPanel.classList.remove('flex');

        // Reset state
        selectedBroadcastMembers = [];
        updateBroadcastMembersUI();

        window.renderBroadcastLists();
        
        // Open the newly created broadcast chat window directly!
        if (window.openBroadcastChat) {
            window.openBroadcastChat(newList.id);
        }
        window.showToast?.('Success', 'Broadcast list created successfully!');
    };
</script>
