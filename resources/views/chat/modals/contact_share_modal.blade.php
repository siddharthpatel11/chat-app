<div id="contact_share_modal" class="hidden fixed inset-0 z-[4000] flex items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity opacity-0 duration-300">
    <div class="bg-[#111b21] w-full max-w-md h-[80vh] sm:h-[600px] rounded-xl shadow-2xl relative z-10 flex flex-col transform scale-95 transition-transform duration-300 overflow-hidden" id="contact_share_modal_content">
        
        <!-- Header -->
        <div class="flex items-center px-4 py-3 bg-[#202c33] shadow-md z-20 shrink-0">
            <button onclick="closeContactShareModal()" class="text-gray-300 hover:text-white p-2 focus:outline-none rounded-full transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path></svg>
            </button>
            <div class="ml-2 flex-1">
                <h2 class="text-white text-lg font-medium">Contacts to send</h2>
                <p class="text-sm text-gray-400" id="contact_share_selected_count">0 selected</p>
            </div>
            <!-- Search icon can be just decorative if we always show search bar -->
            <button class="text-gray-300 hover:text-white p-2" onclick="document.getElementById('contact_share_search').focus()">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path></svg>
            </button>
        </div>

        <!-- Search Bar -->
        <div class="px-4 py-2 bg-[#202c33] border-b border-[#111b21] shrink-0">
            <div class="bg-[#2a3942] rounded-lg flex items-center px-3 py-1">
                <input type="text" id="contact_share_search" oninput="filterContactShareList()" placeholder="Search contacts" class="w-full bg-transparent border-none text-white text-sm focus:ring-0 px-2 py-1.5 placeholder-gray-400">
            </div>
        </div>

        <!-- Contact List -->
        <div class="flex-1 overflow-y-auto custom-scrollbar pt-2 pb-20" id="contact_share_list">
            <!-- Populated by JS -->
        </div>

        <!-- Send FAB -->
        <button id="contact_share_send_btn" onclick="sendSelectedContacts()" class="absolute bottom-6 right-6 w-14 h-14 bg-[#00a884] rounded-full shadow-xl items-center justify-center text-white hover:bg-[#008f6f] transition-transform scale-0 flex z-30">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path></svg>
        </button>

    </div>
</div>

<script>
    let selectedContactsToShare = new Set();
    
    function openContactShareModal() {
        if (!window.allContacts || window.allContacts.length === 0) {
            if (window.showToast) window.showToast('Notice', 'No contacts available.');
            else alert('No contacts available.');
            return;
        }
        
        selectedContactsToShare.clear();
        document.getElementById('contact_share_search').value = '';
        updateContactShareCount();
        renderContactShareList(window.allContacts);
        
        const modal = document.getElementById('contact_share_modal');
        const content = document.getElementById('contact_share_modal_content');
        modal.classList.remove('hidden');
        // trigger animation
        requestAnimationFrame(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
        });
        
        // Hide attach menus if open
        if (typeof closeAllDropdowns === 'function') closeAllDropdowns();
    }

    function closeContactShareModal() {
        const modal = document.getElementById('contact_share_modal');
        const content = document.getElementById('contact_share_modal_content');
        modal.classList.add('opacity-0');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function renderContactShareList(contacts) {
        const listEl = document.getElementById('contact_share_list');
        listEl.innerHTML = '';
        
        if (contacts.length === 0) {
            listEl.innerHTML = '<div class="text-center text-gray-400 mt-10">No contacts found</div>';
            return;
        }

        contacts.forEach(c => {
            const isSelected = selectedContactsToShare.has(c.id);
            const avatar = (typeof window.getUserAvatar === 'function') 
                ? window.getUserAvatar(c.id) 
                : `https://ui-avatars.com/api/?name=${encodeURIComponent(c.name)}&background=202c33&color=fff`;
            
            const div = document.createElement('div');
            div.className = 'flex items-center px-4 py-3 hover:bg-[#202c33] cursor-pointer transition-colors';
            div.onclick = () => toggleContactShareSelection(c.id, div);
            
            div.innerHTML = `
                <div class="relative shrink-0">
                    <img src="${avatar}" class="w-12 h-12 rounded-full object-cover">
                    <div class="absolute -bottom-1 -right-1 bg-[#00a884] w-5 h-5 rounded-full items-center justify-center text-white border-2 border-[#111b21] ${isSelected ? 'flex' : 'hidden'} select-indicator">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </div>
                <div class="ml-4 flex-1 border-b border-[#202c33] pb-3 pt-1">
                    <h3 class="text-white text-[16px] leading-tight mb-1">${c.name}</h3>
                    <p class="text-gray-400 text-[13px] leading-tight truncate">${c.about || 'Available'}</p>
                </div>
            `;
            listEl.appendChild(div);
        });
    }

    function toggleContactShareSelection(id, el) {
        if (selectedContactsToShare.has(id)) {
            selectedContactsToShare.delete(id);
            el.querySelector('.select-indicator').classList.remove('flex');
            el.querySelector('.select-indicator').classList.add('hidden');
        } else {
            selectedContactsToShare.add(id);
            el.querySelector('.select-indicator').classList.remove('hidden');
            el.querySelector('.select-indicator').classList.add('flex');
        }
        updateContactShareCount();
    }

    function updateContactShareCount() {
        const count = selectedContactsToShare.size;
        document.getElementById('contact_share_selected_count').innerText = `${count} selected`;
        
        const sendBtn = document.getElementById('contact_share_send_btn');
        if (count > 0) {
            sendBtn.classList.remove('scale-0');
            sendBtn.classList.add('scale-100');
        } else {
            sendBtn.classList.remove('scale-100');
            sendBtn.classList.add('scale-0');
        }
    }

    function filterContactShareList() {
        const q = document.getElementById('contact_share_search').value.toLowerCase().trim();
        const filtered = window.allContacts.filter(c => {
            return c.name.toLowerCase().includes(q) || (c.about && c.about.toLowerCase().includes(q));
        });
        renderContactShareList(filtered);
    }

    function sendSelectedContacts() {
        if (selectedContactsToShare.size === 0) return;
        if (!window.currentChatId) {
            if (window.showToast) window.showToast('Error', 'Please open a chat first.');
            else alert("Please open a chat first.");
            return;
        }

        const ids = Array.from(selectedContactsToShare);
        const csrf = window.csrf || document.querySelector('meta[name="csrf-token"]')?.content;
        
        let sentCount = 0;
        ids.forEach(id => {
            const formData = new FormData();
            formData.append('chat_id', window.currentChatId);
            formData.append('type', 'contact');
            formData.append('shared_contact_id', id);
            
            fetch('/send', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                body: formData
            }).then(r => {
                sentCount++;
                if (sentCount === ids.length) {
                    closeContactShareModal();
                }
            }).catch(err => {
                console.error("Error sending contact:", err);
                sentCount++;
                if (sentCount === ids.length) {
                    closeContactShareModal();
                }
            });
        });
        
        // Optimistically close
        closeContactShareModal();
        if (typeof closeAllDropdowns === 'function') closeAllDropdowns();
    }
</script>
