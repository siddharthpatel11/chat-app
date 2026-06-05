<div id="privacy_blocked_contacts_panel" class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="togglePrivacyBlockedContacts()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M20 11H7.8l5.6-5.6L12 4l-8 8 8 8 1.4-1.4L7.8 13H20v-2z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Blocked contacts</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21]">
        
        <!-- Add Blocked Contact -->
        <div class="flex items-center px-6 py-4 cursor-pointer hover:bg-[#202c33] transition-colors gap-5 border-b border-[#202c33]" onclick="toggleAddBlockedContactModal()">
            <div class="w-[40px] shrink-0 flex justify-center text-[#aebac1]">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                    <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                </svg>
            </div>
            <span class="text-[#e9edef] text-[16px]">Add blocked contact</span>
        </div>

        <div id="blocked_contacts_list" class="flex flex-col mt-2">
            <!-- Dynamic content injected here -->
        </div>
        
        <div id="no_blocked_contacts_msg" class="hidden text-center py-8 px-6 text-[#8696a0] text-[14px]">
            No blocked contacts
        </div>
    </div>
</div>

<script>
    window.togglePrivacyBlockedContacts = function() {
        const panel = document.getElementById('privacy_blocked_contacts_panel');
        const settings = document.getElementById('privacy_settings_panel');
        
        if (panel.classList.contains('hidden')) {
            panel.classList.remove('hidden');
            panel.classList.add('flex');
            settings.classList.add('hidden');
            window.updateBlockedUI(); // Ensure it's up to date when opened
        } else {
            panel.classList.add('hidden');
            panel.classList.remove('flex');
            settings.classList.remove('hidden');
        }
    }

    window.updateBlockedUI = function() {
        const container = document.getElementById('blocked_contacts_list');
        const noContactsMsg = document.getElementById('no_blocked_contacts_msg');
        if (!container) return;

        container.innerHTML = '';
        
        let blockedUsers = JSON.parse(localStorage.getItem('blocked_users') || '[]');

        // Data migration & safety check: ensure all IDs are in 'user_sidebar_XX' format
        let needsUpdate = false;
        blockedUsers = blockedUsers.map(id => {
            const strId = String(id);
            if (!strId.startsWith('user_sidebar_')) {
                needsUpdate = true;
                return 'user_sidebar_' + strId;
            }
            return strId;
        }).filter(id => id !== 'user_sidebar_undefined' && id !== 'user_sidebar_null');
        
        // Remove duplicates
        blockedUsers = [...new Set(blockedUsers)];
        
        if (needsUpdate) {
            localStorage.setItem('blocked_users', JSON.stringify(blockedUsers));
            window.blockedUsers = blockedUsers; // update global state as well
        }

        const badge = document.getElementById('privacy_blocked_count_badge');
        if (badge) badge.innerText = blockedUsers.length === 0 ? 'None' : blockedUsers.length;

        if (blockedUsers.length === 0) {
            noContactsMsg.classList.remove('hidden');
        } else {
            noContactsMsg.classList.add('hidden');
        }

        blockedUsers.forEach(elementId => {
            const userId = elementId.replace('user_sidebar_', '');
            let name = 'Unknown';
            let avatar = 'https://ui-avatars.com/api/?name=U&background=2a3942&color=fff';
            
            let found = false;

            // 1. Try robust data source first
            if (window.allContacts) {
                const contact = window.allContacts.find(c => String(c.id) === String(userId));
                if (contact) {
                    name = contact.is_contact ? contact.saved_name : (contact.name || contact.phone || 'Unknown');
                    avatar = contact.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=2a3942&color=fff`;
                    found = true;
                }
            }

            // 2. Fallback to DOM
            if (!found) {
                const sidebarEl = document.getElementById(elementId);
                if (sidebarEl) {
                    name = sidebarEl.getAttribute('data-name') || name;
                    avatar = sidebarEl.getAttribute('data-avatar') || avatar;
                }
            }

            const html = `
                <div class="flex items-center px-4 py-3 hover:bg-[#202c33] transition-colors group cursor-pointer" id="blocked_contact_${userId}">
                    <!-- Avatar -->
                    <div class="w-[48px] h-[48px] rounded-full shrink-0 flex items-center justify-center overflow-hidden mr-4">
                        <img src="${avatar}" alt="Profile" class="w-full h-full object-cover">
                    </div>
                    
                    <!-- Name -->
                    <div class="flex-1 text-[#e9edef] text-[16px] truncate">
                        ${name}
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-4 shrink-0">
                        <button onclick="event.stopPropagation(); window.toggleBlockContact('${userId}', 'user')" class="text-[#8696a0] hover:text-[#e9edef] p-1 transition-colors">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        });

        // Update active chat if we are currently chatting with someone who was blocked/unblocked
        if (window.activeChatUser && window.activeChatUser.id) {
            const isBlocked = blockedUsers.includes(`user_sidebar_${window.activeChatUser.id}`);
            const normalInput = document.getElementById('normal_input_container');
            const blockedNotice = document.getElementById('chat_blocked_notice');
            const blockText = document.getElementById('private_header_block_text');
            
            if (blockText) {
                blockText.innerText = isBlocked ? 'Unblock' : 'Block';
            }

            if (normalInput && blockedNotice) {
                if (isBlocked) {
                    normalInput.classList.add('hidden');
                    blockedNotice.classList.remove('hidden');
                } else {
                    normalInput.classList.remove('hidden');
                    blockedNotice.classList.add('hidden');
                }
            }
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        window.updateBlockedUI();
    });
</script>
