<div id="edit_contact_panel" class="fixed top-0 right-0 h-screen w-[400px] bg-[#111b21] border-l border-[#313d45] z-[500] flex flex-col shadow-2xl transition-all duration-300 translate-x-full">
    <!-- Header -->
    <div class="h-[60px] bg-[#202c33] flex items-center px-4 gap-6 shrink-0 relative">
        <button onclick="closeEditContact()" class="text-[#aebac1] hover:text-[#e9edef] transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[16px] font-medium">Edit contact</h2>
        <button onclick="deleteContact()" class="text-[#aebac1] hover:text-[#f15c6d] transition-colors absolute right-4" title="Delete contact">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path>
            </svg>
        </button>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] p-6 pb-24 relative">
        <!-- First Name -->
        <div class="flex items-center gap-4 mb-6">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="text-[#8696a0] mt-4">
                <path d="M12 12a5 5 0 100-10 5 5 0 000 10zm0-2a3 3 0 110-6 3 3 0 010 6zm9 11a1 1 0 01-2 0v-2a3 3 0 00-3-3H8a3 3 0 00-3 3v2a1 1 0 01-2 0v-2a5 5 0 015-5h8a5 5 0 015 5v2z"></path>
            </svg>
            <div class="flex-1">
                <label class="text-[#8696a0] text-[12px] block mb-1">First name</label>
                <input type="text" id="edit_contact_first_name" class="w-full bg-transparent border-0 border-b border-solid border-[#00a884] focus:border-[#00a884] focus:ring-0 text-[#e9edef] px-0 py-1 text-[16px] transition-colors">
            </div>
        </div>

        <!-- Last Name -->
        <div class="flex items-center gap-4 mb-8">
            <div class="w-[24px]"></div> <!-- Spacer -->
            <div class="flex-1">
                <label class="text-[#8696a0] text-[12px] block mb-1">Last name</label>
                <input type="text" id="edit_contact_last_name" class="w-full bg-transparent border-0 border-b border-solid border-[#8696a0] focus:border-[#00a884] focus:ring-0 text-[#e9edef] px-0 py-1 text-[16px] transition-colors">
            </div>
        </div>

        <!-- Phone -->
        <div class="flex items-start gap-4 mb-8">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0] mt-5">
                <path d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z"></path>
            </svg>
            <div class="flex-1">
                <div class="flex gap-4">
                    <div class="w-1/3">
                        <label class="text-[#8696a0] text-[12px] block mb-1">Country</label>
                        <select class="w-full bg-transparent border-0 border-b border-solid border-[#8696a0] focus:border-[#00a884] focus:ring-0 text-[#e9edef] px-0 py-1 text-[16px] transition-colors appearance-none">
                            <option value="+91" class="text-black">IN +91</option>
                        </select>
                    </div>
                    <div class="flex-1 relative">
                        <label class="text-[#8696a0] text-[12px] block mb-1">Phone</label>
                        <input type="text" id="edit_contact_phone" readonly class="w-full bg-transparent border-0 border-b border-solid border-[#8696a0] focus:border-[#00a884] focus:ring-0 text-[#e9edef] px-0 py-1 text-[16px] transition-colors tracking-wide cursor-not-allowed text-[#8696a0]">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#00a884] absolute right-0 bottom-2">
                            <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-[#8696a0] text-[13px] mt-2">This phone number is on WhatsApp.</p>
            </div>
        </div>

        <!-- Sync toggle -->
        <div class="flex items-center gap-4 mt-12 border-t border-[#202c33] pt-6">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="text-[#8696a0]">
                <path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46C19.54 15.03 20 13.57 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74C4.46 8.97 4 10.43 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"></path>
            </svg>
            <div class="flex-1">
                <h4 class="text-[#e9edef] text-[15px]">Sync contact to phone</h4>
                <p class="text-[#8696a0] text-[13px]">This contact will be added to your phone's address book.</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" value="" class="sr-only peer">
                <div class="w-11 h-6 bg-[#3b4a54] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-[#8696a0] peer-checked:after:bg-[#111b21] after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
            </label>
        </div>
    </div>

    <!-- Floating Action Button -->
    <div class="absolute bottom-8 left-0 right-0 flex justify-center z-50">
        <button id="update_contact_btn" onclick="updateExistingContact()" class="w-[50px] h-[50px] bg-[#00a884] rounded-full flex items-center justify-center text-white shadow-lg hover:bg-[#00bfa5] transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path>
            </svg>
        </button>
    </div>
</div>

<script>
    function openEditContact() {
        const panel = document.getElementById('edit_contact_panel');
        
        // Parse the existing name to pre-fill
        const currentName = document.getElementById('contact_info_name').textContent;
        const phoneStr = document.getElementById('contact_info_phone').textContent;
        
        // We know we're editing window.activeChatUser.id
        if (!window.activeChatUser || !window.activeChatUser.id) return;

        let firstName = currentName;
        let lastName = '';
        if (currentName.includes(' ')) {
            const parts = currentName.split(' ');
            lastName = parts.pop();
            firstName = parts.join(' ');
        }
        
        // If the name is just a phone number, it means it's not a saved contact yet
        // In that case, maybe leave first name empty or keep the phone number there
        if (currentName === phoneStr || currentName === '') {
            document.getElementById('edit_contact_first_name').value = '';
            document.getElementById('edit_contact_last_name').value = '';
        } else {
            document.getElementById('edit_contact_first_name').value = firstName;
            document.getElementById('edit_contact_last_name').value = lastName;
        }

        document.getElementById('edit_contact_phone').value = phoneStr.replace('+91', '').trim();
        
        panel.classList.remove('translate-x-full');
        document.getElementById('edit_contact_first_name').focus();
    }

    function closeEditContact() {
        const panel = document.getElementById('edit_contact_panel');
        panel.classList.add('translate-x-full');
    }

    async function updateExistingContact() {
        const userId = window.activeChatUser?.id;
        if (!userId) return;

        const firstName = document.getElementById('edit_contact_first_name').value.trim();
        const lastName = document.getElementById('edit_contact_last_name').value.trim();
        let customName = firstName;
        if (lastName) customName += ' ' + lastName;
        customName = customName.trim();

        const btn = document.getElementById('update_contact_btn');
        btn.disabled = true;
        btn.innerHTML = '<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

        try {
            const response = await fetch('/save-contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ 
                    contact_user_id: userId,
                    custom_name: customName || null
                })
            });
            
            const data = await response.json();
            if(data.status) {
                // Update UI visually without reload
                document.getElementById('contact_info_name').textContent = customName || document.getElementById('contact_info_phone').textContent;
                document.getElementById('active_chat_title').textContent = customName || document.getElementById('contact_info_phone').textContent;
                
                const sidebarItem = document.getElementById(`user_sidebar_${userId}`);
                if (sidebarItem) {
                    sidebarItem.classList.remove('hidden');
                    sidebarItem.classList.add('flex');
                    const nameTag = sidebarItem.querySelector('h4');
                    if(nameTag) nameTag.textContent = customName || document.getElementById('contact_info_phone').textContent;
                }

                closeEditContact();
            }
        } catch(error) {
            console.error('Failed to update contact', error);
            alert('Failed to update contact');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path></svg>';
        }
    }

    async function deleteContact() {
        if(!confirm("Are you sure you want to delete this contact?")) return;

        const userId = window.activeChatUser?.id;
        if (!userId) return;

        try {
            const response = await fetch('/delete-contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ 
                    contact_user_id: userId
                })
            });
            
            const data = await response.json();
            if(data.status) {
                // Restore original phone number or name in UI
                const phoneStr = document.getElementById('contact_info_phone').textContent;
                document.getElementById('contact_info_name').textContent = phoneStr;
                document.getElementById('active_chat_title').textContent = phoneStr;
                
                const sidebarItem = document.getElementById(`user_sidebar_${userId}`);
                if (sidebarItem) {
                    const nameTag = sidebarItem.querySelector('h4');
                    if(nameTag) nameTag.textContent = phoneStr;
                }

                closeEditContact();
            }
        } catch(error) {
            console.error('Failed to delete contact', error);
            alert('Failed to delete contact');
        }
    }
</script>
