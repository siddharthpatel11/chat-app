<div id="new_contact_panel" class="hidden flex-col w-[30%] sm:min-w-[300px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden absolute sm:relative z-[60] sm:z-0 left-0 top-0">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="toggleNewContact()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">New contact</h2>
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
                <input type="text" id="new_contact_first_name" class="w-full bg-transparent border-0 border-b border-solid border-[#8696a0] focus:border-[#00a884] focus:ring-0 text-[#e9edef] px-0 py-1 text-[16px] transition-colors">
            </div>
        </div>

        <!-- Last Name -->
        <div class="flex items-center gap-4 mb-8">
            <div class="w-[24px]"></div> <!-- Spacer -->
            <div class="flex-1">
                <label class="text-[#8696a0] text-[12px] block mb-1">Last name</label>
                <input type="text" id="new_contact_last_name" class="w-full bg-transparent border-0 border-b border-solid border-[#8696a0] focus:border-[#00a884] focus:ring-0 text-[#e9edef] px-0 py-1 text-[16px] transition-colors">
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
                        <select class="w-full bg-transparent border-0 border-b border-solid border-[#8696a0] focus:border-[#00a884] focus:ring-0 text-[#e9edef] px-0 py-1 text-[16px] transition-colors">
                            <option value="+91" class="text-black">IN +91</option>
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="text-[#8696a0] text-[12px] block mb-1">Phone</label>
                        <input type="text" id="new_contact_phone" oninput="checkPhoneNumber()" class="w-full bg-transparent border-0 border-b border-solid border-[#8696a0] focus:border-[#00a884] focus:ring-0 text-[#e9edef] px-0 py-1 text-[16px] transition-colors tracking-wide">
                    </div>
                </div>
                <p id="new_contact_status_msg" class="text-[#8696a0] text-[13px] mt-2 hidden"></p>
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
        <button id="save_contact_btn" onclick="saveNewContact()" class="w-[50px] h-[50px] bg-[#00a884] rounded-full flex items-center justify-center text-white shadow-lg hover:bg-[#00bfa5] transition-colors disabled:opacity-50 disabled:cursor-not-allowed" disabled>
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path>
            </svg>
        </button>
    </div>
</div>

<script>
    let checkPhoneTimeout = null;
    let validContactUser = null;

    function toggleNewContact() {
        const newContactPanel = document.getElementById('new_contact_panel');
        const newChatPanel = document.getElementById('new_chat_panel');
        
        if (newContactPanel.classList.contains('hidden')) {
            newChatPanel.classList.add('hidden');
            newChatPanel.classList.remove('sm:flex');
            newContactPanel.classList.remove('hidden');
            newContactPanel.classList.add('sm:flex');
            document.getElementById('new_contact_first_name').focus();
        } else {
            newContactPanel.classList.add('hidden');
            newContactPanel.classList.remove('sm:flex');
            newChatPanel.classList.remove('hidden');
            newChatPanel.classList.add('sm:flex');
            // reset form
            document.getElementById('new_contact_first_name').value = '';
            document.getElementById('new_contact_last_name').value = '';
            document.getElementById('new_contact_phone').value = '';
            document.getElementById('new_contact_status_msg').classList.add('hidden');
            document.getElementById('save_contact_btn').disabled = true;
            validContactUser = null;
        }
    }

    function checkPhoneNumber() {
        clearTimeout(checkPhoneTimeout);
        const phone = document.getElementById('new_contact_phone').value.trim();
        const msgEl = document.getElementById('new_contact_status_msg');
        const saveBtn = document.getElementById('save_contact_btn');
        
        if (phone.length < 5) {
            msgEl.classList.add('hidden');
            saveBtn.disabled = true;
            validContactUser = null;
            return;
        }

        checkPhoneTimeout = setTimeout(async () => {
            try {
                const response = await fetch('/api/check-phone', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ phone: phone })
                });
                
                const data = await response.json();
                
                msgEl.classList.remove('hidden');
                msgEl.textContent = data.message;
                
                if (data.status) {
                    msgEl.classList.remove('text-[#8696a0]');
                    msgEl.classList.add('text-[#00a884]'); // green for exist
                    saveBtn.disabled = false;
                    validContactUser = data.user;
                } else {
                    msgEl.classList.add('text-[#8696a0]');
                    msgEl.classList.remove('text-[#00a884]');
                    saveBtn.disabled = true;
                    validContactUser = null;
                }
            } catch (error) {
                console.error("Error checking phone", error);
            }
        }, 500); // 500ms debounce
    }

    async function saveNewContact() {
        if (!validContactUser) return;
        
        const firstName = document.getElementById('new_contact_first_name').value.trim();
        const lastName = document.getElementById('new_contact_last_name').value.trim();
        let customName = firstName;
        if (lastName) {
            customName += ' ' + lastName;
        }
        customName = customName.trim();
        
        const saveBtn = document.getElementById('save_contact_btn');
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

        try {
            const response = await fetch('/save-contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ 
                    contact_user_id: validContactUser.id,
                    custom_name: customName || null
                })
            });
            
            const data = await response.json();
            
            if(data.status) {
                // Update the validContactUser with the new name for the chat interface
                if (customName) {
                    validContactUser.name = customName;
                }
                
                // Hide new contact panel
                document.getElementById('new_contact_panel').classList.add('hidden');
                document.getElementById('new_contact_panel').classList.remove('sm:flex');
                
                // Hide new chat panel if open
                const newChatPanel = document.getElementById('new_chat_panel');
                if(newChatPanel) {
                    newChatPanel.classList.add('hidden');
                    newChatPanel.classList.remove('sm:flex');
                }

                // Show main sidebar
                const sidebar = document.getElementById('user_sidebar_container');
                sidebar.classList.remove('hidden');
                sidebar.classList.add('sm:flex');

                // Extract user data
                const user = validContactUser;
                const avatar = user.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name || user.phone)}&background=2a3942&color=fff`;
                const about = user.about || 'Available';

                // We should also unhide the user in the sidebar and update their name visually
                const sidebarItem = document.getElementById(`user_sidebar_${user.id}`);
                if (sidebarItem) {
                    sidebarItem.classList.remove('hidden');
                    sidebarItem.classList.add('flex');
                    const nameTag = sidebarItem.querySelector('h4');
                    if(nameTag) nameTag.textContent = user.name || user.phone;
                } else {
                    // Force reload if element doesn't exist (edge case)
                    window.location.reload();
                    return;
                }

                // Start chat
                if (window.selectChat) {
                    window.selectChat(user.id, user.name || user.phone, user.phone, avatar, about);
                }
            }
        } catch (error) {
            console.error("Error saving contact", error);
            alert("Failed to save contact. Please try again.");
        } finally {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path></svg>';
        }
    }
</script>
