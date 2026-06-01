<div id="add_blocked_contact_modal" class="fixed inset-0 z-[100] flex items-center justify-center hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/60 transition-opacity" onclick="toggleAddBlockedContactModal()"></div>
    
    <!-- Modal Content -->
    <div class="bg-[#111b21] w-full max-w-[400px] h-full sm:h-[600px] sm:max-h-[85vh] sm:rounded-xl shadow-2xl flex flex-col relative overflow-hidden animate-slide-up">
        
        <!-- Header -->
        <div class="flex items-center px-4 py-4 shrink-0 bg-[#111b21]">
            <button onclick="toggleAddBlockedContactModal()" class="text-[#aebac1] hover:text-[#e9edef] p-1.5 rounded-full transition-colors focus:outline-none">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path>
                </svg>
            </button>
            <h2 class="text-[#e9edef] text-[18px] ml-4 font-normal">Add blocked contact</h2>
        </div>

        <!-- Search -->
        <div class="px-3 pb-3 pt-1 shrink-0 bg-[#111b21]">
            <div class="bg-[#202c33] rounded-lg flex items-center px-3 py-1.5 h-10 transition-all duration-200">
                <div class="relative w-6 h-6 shrink-0 text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                        <path d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 0 0 1.256-3.386 5.207 5.207 0 1 0-5.207 5.208 5.183 5.183 0 0 0 3.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-4.6-1.598a3.608 3.608 0 1 1 0-7.216 3.608 3.608 0 0 1 0 7.216z"></path>
                    </svg>
                </div>
                <input type="text" id="add_blocked_search" placeholder="Search contacts" class="bg-transparent border-none focus:ring-0 w-full text-[15px] ml-2 text-[#d1d7db] placeholder-[#8696a0]">
            </div>
        </div>

        <!-- Scrollable Contacts List -->
        <div class="flex-1 overflow-y-auto custom-scrollbar pb-6" id="add_blocked_contacts_list">
            <!-- Dynamic contacts will be injected here -->
        </div>

    </div>
</div>

<script>
    window.toggleAddBlockedContactModal = function() {
        const modal = document.getElementById('add_blocked_contact_modal');
        if (modal.classList.contains('hidden')) {
            populateAddBlockedModal();
            modal.classList.remove('hidden');
            document.getElementById('add_blocked_search').value = '';
        } else {
            modal.classList.add('hidden');
        }
    }

    function populateAddBlockedModal() {
        const allUsers = [];
        let blockedUsers = [];
        try {
            const raw = localStorage.getItem('blocked_users');
            if (raw && raw !== 'undefined') {
                blockedUsers = JSON.parse(raw);
            }
            if (!Array.isArray(blockedUsers)) blockedUsers = [];
        } catch (e) {
            blockedUsers = [];
        }

        document.querySelectorAll('.user-chat-item').forEach(el => {
            const userId = el.getAttribute('data-userid');
            if (blockedUsers.includes(`user_sidebar_${userId}`)) return;
            
            allUsers.push({
                id: userId,
                name: el.getAttribute('data-name'),
                phone: el.getAttribute('data-phone') || el.getAttribute('data-name'),
                avatar: el.getAttribute('data-avatar')
            });
        });

        // Sort alphabetically by name
        allUsers.sort((a, b) => a.name.localeCompare(b.name));

        const listEl = document.getElementById('add_blocked_contacts_list');
        listEl.innerHTML = '';
        
        let currentLetter = '';

        if(allUsers.length === 0) {
            listEl.innerHTML = '<div class="text-center py-10 text-[#8696a0] text-[15px]">No contacts available</div>';
            return;
        }

        allUsers.forEach(u => {
            const firstChar = u.name.charAt(0).toUpperCase();
            const letter = /[A-Z]/.test(firstChar) ? firstChar : '#';

            if (letter !== currentLetter) {
                currentLetter = letter;
                listEl.insertAdjacentHTML('beforeend', `
                    <div class="px-6 py-2 text-[#00a884] text-[15px] font-medium mt-1 mb-1 add-blocked-group-letter" data-letter="${letter}">
                        ${letter}
                    </div>
                `);
            }

            listEl.insertAdjacentHTML('beforeend', `
                <div class="flex items-center px-4 py-3 hover:bg-[#202c33] cursor-pointer transition-colors add-blocked-item" data-name="${u.name.toLowerCase()}" data-letter="${letter}" onclick="blockContactFromModal('${u.id}')">
                    <div class="w-10 h-10 rounded-full overflow-hidden bg-[#2a3942] flex items-center justify-center shrink-0 mr-4">
                        <img src="${u.avatar}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 text-[#e9edef] text-[16px] truncate">
                        ${u.name}
                    </div>
                </div>
            `);
        });
    }

    window.blockContactFromModal = function(userId) {
        window.toggleBlockContact(userId, 'user');
        window.toggleAddBlockedContactModal();
    }

    // Search filter
    document.getElementById('add_blocked_search')?.addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase();
        const items = document.querySelectorAll('.add-blocked-item');
        const headers = document.querySelectorAll('.add-blocked-group-letter');

        // Reset visibility
        items.forEach(item => {
            const name = item.getAttribute('data-name');
            item.style.display = name.includes(term) ? 'flex' : 'none';
        });

        // Hide headers if no items are visible under them
        headers.forEach(header => {
            const letter = header.getAttribute('data-letter');
            const visibleItems = document.querySelectorAll(`.add-blocked-item[data-letter="${letter}"][style="display: flex;"]`);
            header.style.display = visibleItems.length > 0 ? 'block' : 'none';
        });
    });
</script>
