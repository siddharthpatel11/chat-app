<div id="create_group_panel"
    class="hidden flex-col w-[30%] sm:min-w-[300px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden z-[60]">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="backToAddMembers()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[16px] font-medium leading-tight">New group</h2>
    </div>

    <!-- Content -->
    <div id="create_group_main_content" class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] p-6 flex flex-col items-center">
        <!-- Group Icon -->
        <div class="relative w-40 h-40 bg-[#2a3942] rounded-full flex flex-col items-center justify-center text-[#8696a0] hover:bg-[#3b4a54] transition-all cursor-pointer mb-8 overflow-hidden group">
            <input type="file" id="group_icon_input" onchange="uploadGroupIcon(event)" class="absolute inset-0 opacity-0 cursor-pointer z-20">
            <div id="group_icon_preview" class="absolute inset-0 w-full h-full object-cover hidden">
                <img src="" class="w-full h-full object-cover" id="group_icon_img_el">
            </div>
            <div id="group_icon_placeholder" class="flex flex-col items-center justify-center gap-2 select-none z-10 group-hover:text-[#00a884]">
                <svg viewBox="0 0 24 24" width="32" height="32" fill="currentColor">
                    <path d="M19 5v14H5V5h14m0-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0-2-.9-2-2V5c0-1.1-.9-2-2-2zm-4.86 8.86l-3 3.87L9 13.14 6 17h12l-3.86-5.14z"></path>
                </svg>
                <span class="text-xs uppercase tracking-wide text-center font-medium">Add group<br>icon</span>
            </div>
        </div>

        <!-- Subject Input -->
        <div class="w-full mb-8 relative border-b border-[#00a884] focus-within:border-[#00a884] flex items-center">
            <input type="text" id="group_subject_input" placeholder="Group subject (optional)" class="w-full bg-transparent border-0 focus:ring-0 text-[#e9edef] px-0 py-1.5 text-[16px] transition-colors placeholder-[#8696a0] outline-none">
            <span class="text-[#8696a0] select-none hover:text-[#00a884] cursor-pointer">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5s.67 1.5 1.5 1.5zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"></path>
                </svg>
            </span>
        </div>

        <!-- Disappearing messages option -->
        <div onclick="openDisappearingMessagesModal()" class="w-full flex items-center justify-between border-t border-[#202c33] py-4 cursor-pointer hover:bg-[#202c33]/40 transition-colors">
            <div class="flex flex-col">
                <span class="text-[#e9edef] text-[15px]">Disappearing messages</span>
                <span id="disappearing_status_text" class="text-[#8696a0] text-xs">Off</span>
            </div>
            <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" class="text-[#8696a0]">
                <path d="M9.29 15.88L13.17 12 9.29 8.12 10.71 6.7l5.29 5.3-5.29 5.3z"></path>
            </svg>
        </div>

        <!-- Group permissions -->
        <div onclick="openGroupPermissionsPanel()" class="w-full flex items-center justify-between border-t border-[#202c33] py-4 cursor-pointer hover:bg-[#202c33]/40 transition-colors border-b">
            <span class="text-[#e9edef] text-[15px]">Group permissions</span>
            <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" class="text-[#8696a0]">
                <path d="M9.29 15.88L13.17 12 9.29 8.12 10.71 6.7l5.29 5.3-5.29 5.3z"></path>
            </svg>
        </div>
    </div>

    <!-- Finalize Checkmark Floating Action Button -->
    <div id="create_group_bottom_actions" class="p-4 bg-[#111b21] flex justify-center border-t border-[#202c33] relative">
        <button id="create_group_submit_btn" onclick="submitCreateGroup()" class="w-[50px] h-[50px] bg-[#00a884] rounded-full flex items-center justify-center text-white shadow-lg hover:bg-[#00bfa5] transition-colors disabled:opacity-50">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path>
            </svg>
        </button>
    </div>

    <!-- Group Permissions Sub-Panel (Slide in replacement) -->
    <div id="group_permissions_subpanel" class="hidden flex-col flex-1 overflow-hidden bg-[#111b21]">
        <!-- Sub Header -->
        <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
            <button onclick="closeGroupPermissionsPanel()" class="text-[#aebac1] hover:text-white transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
                </svg>
            </button>
            <h2 class="text-[#e9edef] text-[16px] font-medium leading-tight">Group permissions</h2>
        </div>

        <!-- Scrollable Switches List -->
        <div class="flex-1 overflow-y-auto custom-scrollbar p-6">
            <h4 class="text-[#8696a0] text-xs font-semibold uppercase tracking-wider mb-4">Members can:</h4>
            
            <!-- 1. Edit group settings -->
            <div class="flex items-start justify-between mb-6 group/perm">
                <div class="flex items-center gap-4">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor" class="text-[#8696a0] mt-0.5 shrink-0">
                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path>
                    </svg>
                    <div class="flex flex-col">
                        <span class="text-[#e9edef] text-[15px]">Edit group settings</span>
                        <span class="text-[#8696a0] text-xs">Name, icon, description, disappearing message timer, etc.</span>
                    </div>
                </div>
                <!-- Toggle button -->
                <button onclick="togglePerm('editSettings')" id="perm_toggle_editSettings" class="w-11 h-6 flex items-center rounded-full p-0.5 transition-colors duration-200 bg-[#00a884]">
                    <div class="bg-white w-5 h-5 rounded-full shadow-md transform transition-transform duration-200 translate-x-5" id="perm_circle_editSettings"></div>
                </button>
            </div>

            <!-- 2. Send new messages -->
            <div class="flex items-start justify-between mb-6 group/perm">
                <div class="flex items-center gap-4">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor" class="text-[#8696a0] mt-0.5 shrink-0">
                        <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6V9zm8 5H6v-2h8v2zm4-6H6V6h12v2z"></path>
                    </svg>
                    <div class="flex flex-col">
                        <span class="text-[#e9edef] text-[15px]">Send new messages</span>
                    </div>
                </div>
                <!-- Toggle button -->
                <button onclick="togglePerm('sendMessages')" id="perm_toggle_sendMessages" class="w-11 h-6 flex items-center rounded-full p-0.5 transition-colors duration-200 bg-[#00a884]">
                    <div class="bg-white w-5 h-5 rounded-full shadow-md transform transition-transform duration-200 translate-x-5" id="perm_circle_sendMessages"></div>
                </button>
            </div>

            <!-- 3. Add other members -->
            <div class="flex items-start justify-between mb-6 group/perm">
                <div class="flex items-center gap-4">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor" class="text-[#8696a0] mt-0.5 shrink-0">
                        <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                    </svg>
                    <div class="flex flex-col">
                        <span class="text-[#e9edef] text-[15px]">Add other members</span>
                    </div>
                </div>
                <!-- Toggle button -->
                <button onclick="togglePerm('addMembers')" id="perm_toggle_addMembers" class="w-11 h-6 flex items-center rounded-full p-0.5 transition-colors duration-200 bg-[#00a884]">
                    <div class="bg-white w-5 h-5 rounded-full shadow-md transform transition-transform duration-200 translate-x-5" id="perm_circle_addMembers"></div>
                </button>
            </div>

            <!-- 4. Invite via link -->
            <div class="flex items-start justify-between mb-6 group/perm">
                <div class="flex items-center gap-4">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor" class="text-[#8696a0] mt-0.5 shrink-0">
                        <path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"></path>
                    </svg>
                    <div class="flex flex-col">
                        <span class="text-[#e9edef] text-[15px]">Invite via link</span>
                    </div>
                </div>
                <!-- Toggle button -->
                <button onclick="togglePerm('inviteLink')" id="perm_toggle_inviteLink" class="w-11 h-6 flex items-center rounded-full p-0.5 transition-colors duration-200 bg-[#00a884]">
                    <div class="bg-white w-5 h-5 rounded-full shadow-md transform transition-transform duration-200 translate-x-5" id="perm_circle_inviteLink"></div>
                </button>
            </div>

            <h4 class="text-[#8696a0] text-xs font-semibold uppercase tracking-wider mt-8 mb-4">Admins can:</h4>

            <!-- 5. Approve new members -->
            <div class="flex items-start justify-between mb-6 group/perm">
                <div class="flex items-center gap-4">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor" class="text-[#8696a0] mt-0.5 shrink-0">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"></path>
                    </svg>
                    <div class="flex flex-col">
                        <span class="text-[#e9edef] text-[15px]">Approve new members</span>
                        <span class="text-[#8696a0] text-xs">Admins must approve anyone who wants to join this group.</span>
                    </div>
                </div>
                <!-- Toggle button -->
                <button onclick="togglePerm('approveMembers')" id="perm_toggle_approveMembers" class="w-11 h-6 flex items-center rounded-full p-0.5 transition-colors duration-200 bg-[#2f3b43]">
                    <div class="bg-white w-5 h-5 rounded-full shadow-md transform transition-transform duration-200 translate-x-0" id="perm_circle_approveMembers"></div>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Disappearing Messages Modal -->
<div id="disappearing_messages_modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
    <div class="bg-[#222e35] rounded-3xl p-6 w-full max-w-[340px] shadow-2xl transform scale-100 transition-all">
        <h3 class="text-[#e9edef] text-[19px] font-medium mb-3 select-none">Disappearing messages</h3>
        <p class="text-[#8696a0] text-[13px] mb-5 leading-normal select-none">All new messages in this chat will disappear after the selected duration.</p>
        
        <!-- Options List -->
        <div class="flex flex-col gap-5 mb-8">
            <!-- 24 hours -->
            <label class="flex items-center justify-between cursor-pointer group select-none">
                <span class="text-[#e9edef] text-[15px] group-hover:text-white transition-colors">24 hours</span>
                <div class="relative flex items-center justify-center">
                    <input type="radio" name="disappearing_option" value="24_hours" class="peer hidden">
                    <div class="w-5 h-5 border-2 border-[#8696a0] peer-checked:border-[#00a884] rounded-full flex items-center justify-center transition-all">
                        <div class="w-2.5 h-2.5 bg-[#00a884] rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                </div>
            </label>

            <!-- 7 days -->
            <label class="flex items-center justify-between cursor-pointer group select-none">
                <span class="text-[#e9edef] text-[15px] group-hover:text-white transition-colors">7 days</span>
                <div class="relative flex items-center justify-center">
                    <input type="radio" name="disappearing_option" value="7_days" class="peer hidden">
                    <div class="w-5 h-5 border-2 border-[#8696a0] peer-checked:border-[#00a884] rounded-full flex items-center justify-center transition-all">
                        <div class="w-2.5 h-2.5 bg-[#00a884] rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                </div>
            </label>

            <!-- 90 days -->
            <label class="flex items-center justify-between cursor-pointer group select-none">
                <span class="text-[#e9edef] text-[15px] group-hover:text-white transition-colors">90 days</span>
                <div class="relative flex items-center justify-center">
                    <input type="radio" name="disappearing_option" value="90_days" class="peer hidden">
                    <div class="w-5 h-5 border-2 border-[#8696a0] peer-checked:border-[#00a884] rounded-full flex items-center justify-center transition-all">
                        <div class="w-2.5 h-2.5 bg-[#00a884] rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                </div>
            </label>

            <!-- Off -->
            <label class="flex items-center justify-between cursor-pointer group select-none">
                <span class="text-[#e9edef] text-[15px] group-hover:text-white transition-colors">Off</span>
                <div class="relative flex items-center justify-center">
                    <input type="radio" name="disappearing_option" value="off" checked class="peer hidden">
                    <div class="w-5 h-5 border-2 border-[#8696a0] peer-checked:border-[#00a884] rounded-full flex items-center justify-center transition-all">
                        <div class="w-2.5 h-2.5 bg-[#00a884] rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                </div>
            </label>
        </div>

        <!-- Action buttons -->
        <div class="flex items-center justify-end gap-6 select-none font-medium text-[14px]">
            <button onclick="closeDisappearingMessagesModal()" class="text-[#00a884] hover:text-[#00bfa5] transition-colors tracking-wide">Cancel</button>
            <button onclick="saveDisappearingOption()" class="bg-[#00a884] text-[#111b21] px-5 py-2.5 rounded-full hover:bg-[#00bfa5] transition-colors tracking-wide shadow-md font-semibold">OK</button>
        </div>
    </div>
</div>

<script>
    let groupIconUrl = null;
    let groupDisappearingTimer = 'off';
    let groupPermissions = {
        editSettings: true,
        sendMessages: true,
        addMembers: true,
        inviteLink: true,
        approveMembers: false
    };

    function backToAddMembers() {
        const addMembersPanel = document.getElementById('add_group_members_panel');
        const createGroupPanel = document.getElementById('create_group_panel');

        createGroupPanel.classList.add('hidden');
        createGroupPanel.classList.remove('flex');
        
        addMembersPanel.classList.remove('hidden');
        addMembersPanel.classList.add('flex');
    }

    /* ---- DISAPPEARING MESSAGES LOGIC ---- */
    function openDisappearingMessagesModal() {
        // Preset currently selected option
        const radios = document.getElementsByName('disappearing_option');
        radios.forEach(radio => {
            if (radio.value === groupDisappearingTimer) {
                radio.checked = true;
            }
        });
        document.getElementById('disappearing_messages_modal').classList.remove('hidden');
    }

    function closeDisappearingMessagesModal() {
        document.getElementById('disappearing_messages_modal').classList.add('hidden');
    }

    function saveDisappearingOption() {
        const radios = document.getElementsByName('disappearing_option');
        radios.forEach(radio => {
            if (radio.checked) {
                groupDisappearingTimer = radio.value;
            }
        });

        const displayText = groupDisappearingTimer === 'off' ? 'Off' : groupDisappearingTimer.replace('_', ' ');
        document.getElementById('disappearing_status_text').textContent = displayText;
        closeDisappearingMessagesModal();
    }

    /* ---- GROUP PERMISSIONS LOGIC ---- */
    function openGroupPermissionsPanel() {
        document.getElementById('create_group_main_content').classList.add('hidden');
        document.getElementById('create_group_bottom_actions').classList.add('hidden');
        document.getElementById('group_permissions_subpanel').classList.remove('hidden');
        document.getElementById('group_permissions_subpanel').classList.add('flex');
    }

    function closeGroupPermissionsPanel() {
        document.getElementById('group_permissions_subpanel').classList.add('hidden');
        document.getElementById('group_permissions_subpanel').classList.remove('flex');
        document.getElementById('create_group_main_content').classList.remove('hidden');
        document.getElementById('create_group_bottom_actions').classList.remove('hidden');
    }

    function togglePerm(key) {
        groupPermissions[key] = !groupPermissions[key];
        const btn = document.getElementById('perm_toggle_' + key);
        const circle = document.getElementById('perm_circle_' + key);

        if (groupPermissions[key]) {
            btn.className = "w-11 h-6 flex items-center rounded-full p-0.5 transition-colors duration-200 bg-[#00a884]";
            circle.className = "bg-white w-5 h-5 rounded-full shadow-md transform transition-transform duration-200 translate-x-5";
        } else {
            btn.className = "w-11 h-6 flex items-center rounded-full p-0.5 transition-colors duration-200 bg-[#2f3b43]";
            circle.className = "bg-white w-5 h-5 rounded-full shadow-md transform transition-transform duration-200 translate-x-0";
        }
    }

    async function uploadGroupIcon(event) {
        const file = event.target.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('file', file);

        try {
            const response = await fetch('/upload-status-media', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });
            const data = await response.json();
            if (data.status && data.url) {
                groupIconUrl = data.url;
                document.getElementById('group_icon_preview').classList.remove('hidden');
                document.getElementById('group_icon_img_el').src = data.url;
                document.getElementById('group_icon_placeholder').classList.add('hidden');
            }
        } catch (err) {
            console.error("Group icon upload failed", err);
        }
    }

    async function submitCreateGroup() {
        let subject = document.getElementById('group_subject_input').value.trim();
        if (!subject) {
            subject = "New Group";
        }

        const btn = document.getElementById('create_group_submit_btn');
        btn.disabled = true;
        btn.innerHTML = '<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

        try {
            const groupId = 'group_' + Date.now();
            const avatar = groupIconUrl || `https://ui-avatars.com/api/?name=${encodeURIComponent(subject)}&background=2a3942&color=fff`;

            const groupData = {
                id: groupId,
                name: subject,
                isGroup: true,
                createdBy: window.myUserId,
                users: selectedGroupMembers.map(u => u.id).concat(window.myUserId),
                avatar: avatar,
                disappearingTimer: groupDisappearingTimer,
                permissions: groupPermissions
            };

            // Save to Firebase groups/
            await window.set(window.ref(window.db, 'groups/' + groupId), groupData);

            // Create initial message or message placeholder for listing the group in chat list
            const initialMsg = {
                text: `${window.activeChatName || 'Admin'} created group "${subject}"`,
                sender_id: window.myUserId,
                time: Math.floor(Date.now() / 1000),
                type: 'text',
                status: 'read'
            };

            await window.push(window.ref(window.db, `chats/${groupId}/messages`), initialMsg);

            // Hide panels & show sidebar
            document.getElementById('create_group_panel').classList.add('hidden');
            document.getElementById('create_group_panel').classList.remove('flex');
            
            const sidebar = document.getElementById('user_sidebar_container');
            sidebar.classList.remove('hidden');
            sidebar.classList.add('sm:flex');

            // Clear input & members
            document.getElementById('group_subject_input').value = '';
            selectedGroupMembers = [];

            // Trigger visual open chat
            if (window.selectGroupChat) {
                window.selectGroupChat(groupId, subject, avatar);
            } else {
                window.location.reload();
            }
        } catch (error) {
            console.error("Failed to create group", error);
            alert("Failed to create group. Please try again.");
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path></svg>';
        }
    }
</script>
