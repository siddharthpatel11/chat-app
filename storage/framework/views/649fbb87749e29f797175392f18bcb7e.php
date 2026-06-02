<div id="add_group_members_panel"
    class="hidden flex-col w-[30%] sm:min-w-[300px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden z-[60]">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="toggleAddMembers()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
            </svg>
        </button>
        <div class="flex flex-col">
            <h2 class="text-[#e9edef] text-[16px] font-medium leading-tight">Add group members</h2>
            <span id="selected_members_count" class="text-[#8696a0] text-xs">0 selected</span>
        </div>
    </div>

    <!-- Chips Container -->
    <div id="selected_members_chips" class="p-3 bg-[#111b21] flex flex-wrap gap-2 border-b border-[#202c33] hidden">
        <!-- JS dynamically adds chips here -->
    </div>

    <!-- Search / Add input (Image 3 style) -->
    <div class="p-2 border-b border-[#202c33] bg-[#111b21] shrink-0">
        <div class="bg-[#202c33] rounded-lg flex items-center px-3 py-1.5 h-9 transition-all duration-200 focus-within:bg-[#2a3942]">
            <div class="relative w-6 h-6 shrink-0">
                <svg class="w-[18px] h-[18px] text-[#8696a0] absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 0 0 1.256-3.386 5.207 5.207 0 1 0-5.207 5.208 5.183 5.183 0 0 0 3.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-4.6-1.598a3.608 3.608 0 1 1 0-7.216 3.608 3.608 0 0 1 0 7.216z"></path>
                </svg>
            </div>
            <input type="text" id="add_group_search" placeholder="Search name or number" class="bg-transparent border-none focus:ring-0 w-full text-sm ml-2 text-[#d1d7db] placeholder-[#8696a0]">
        </div>
    </div>

    <!-- Contacts list -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21]">
        <div class="py-2">
            <div id="add_group_contacts_list">
                <?php $__currentLoopData = $users ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $userAvatar = $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?: $user->phone) . '&background=2a3942&color=fff';
                    ?>
                    <div onclick="window.toggleGroupMemberSelection(<?php echo e($user->id); ?>, '<?php echo e(addslashes($user->name ?: $user->phone)); ?>', '<?php echo e($userAvatar); ?>')"
                        class="flex items-center px-3 py-3 hover:bg-[#202c33] cursor-pointer transition-colors group-member-item" data-name="<?php echo e(strtolower($user->name ?: $user->phone)); ?>" id="group_member_row_<?php echo e($user->id); ?>">
                        <div class="w-12 h-12 rounded-full overflow-hidden bg-[#2a3942] flex items-center justify-center shrink-0 ml-1 relative">
                            <img src="<?php echo e($userAvatar); ?>" class="w-full h-full object-cover">
                            <!-- Checked circle overlay if selected -->
                            <div class="absolute inset-0 bg-[#00a884]/60 flex items-center justify-center hidden check-overlay">
                                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="text-white">
                                    <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 flex-1 border-b border-[#202c33] pb-3 pt-1 min-w-0">
                            <h4 class="text-[17px] text-[#e9edef] truncate mr-2 font-normal"><?php echo e($user->name ?: $user->phone); ?></h4>
                            <p class="text-[14px] text-[#8696a0] truncate mt-0.5 leading-snug"><?php echo e($user->about ?? 'Available'); ?></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <!-- Bottom Forward Arrow (Visible when members are selected) -->
    <div id="go_to_create_group_btn" class="p-4 bg-[#111b21] flex justify-center border-t border-[#202c33] hidden">
        <button onclick="openCreateGroup()" class="w-14 h-14 bg-[#00a884] hover:bg-[#00bfa5] rounded-full flex items-center justify-center text-white shadow-lg transition-colors">
            <svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor">
                <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"></path>
            </svg>
        </button>
    </div>
</div>

<script>
    let selectedGroupMembers = [];

    function toggleAddMembers() {
        const addMembersPanel = document.getElementById('add_group_members_panel');
        const newChatPanel = document.getElementById('new_chat_panel');
        const mainSidebar = document.getElementById('user_sidebar_container');

        if (addMembersPanel.classList.contains('hidden')) {
            newChatPanel.classList.add('hidden');
            newChatPanel.classList.remove('sm:flex');
            if (mainSidebar) {
                mainSidebar.classList.add('hidden');
                mainSidebar.classList.remove('sm:flex');
            }
            addMembersPanel.classList.remove('hidden');
            addMembersPanel.classList.add('flex');
            document.getElementById('add_group_search').focus();
        } else {
            addMembersPanel.classList.add('hidden');
            addMembersPanel.classList.remove('flex');
            if (mainSidebar && newChatPanel.classList.contains('hidden')) {
                mainSidebar.classList.remove('hidden');
                mainSidebar.classList.add('sm:flex');
            } else {
                newChatPanel.classList.remove('hidden');
                newChatPanel.classList.add('sm:flex');
            }
            // reset selection
            selectedGroupMembers = [];
            updateGroupMembersUI();
        }
    }

    window.toggleGroupMemberSelection = function(userId, name, avatar) {
        const index = selectedGroupMembers.findIndex(u => u.id === userId);
        if (index === -1) {
            selectedGroupMembers.push({ id: userId, name: name, avatar: avatar });
        } else {
            selectedGroupMembers.splice(index, 1);
        }
        updateGroupMembersUI();
    };

    function updateGroupMembersUI() {
        const countSpan = document.getElementById('selected_members_count');
        const chipsContainer = document.getElementById('selected_members_chips');
        const nextBtn = document.getElementById('go_to_create_group_btn');
        
        countSpan.textContent = `${selectedGroupMembers.length} selected`;

        // Update list checkmarks
        document.querySelectorAll('.group-member-item').forEach(item => {
            const checkOverlay = item.querySelector('.check-overlay');
            if (checkOverlay) checkOverlay.classList.add('hidden');
        });

        chipsContainer.innerHTML = '';

        if (selectedGroupMembers.length > 0) {
            chipsContainer.classList.remove('hidden');
            nextBtn.classList.remove('hidden');

            selectedGroupMembers.forEach(user => {
                // Show check on list
                const row = document.getElementById(`group_member_row_${user.id}`);
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
                    <button onclick="event.stopPropagation(); window.toggleGroupMemberSelection(${user.id}, '${user.name.replace(/'/g, "\\'")}', '${user.avatar}')" class="text-[#8696a0] hover:text-[#f15c6d] font-bold text-xs ml-1 focus:outline-none">✕</button>
                `;
                chipsContainer.appendChild(chip);
            });
        } else {
            chipsContainer.classList.add('hidden');
            nextBtn.classList.add('hidden');
        }
    }

    // Search filter for contacts
    const addGroupSearch = document.getElementById('add_group_search');
    if (addGroupSearch) {
        addGroupSearch.addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            const items = document.querySelectorAll('.group-member-item');
            
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

    function openCreateGroup() {
        if (selectedGroupMembers.length === 0) return;
        
        const addMembersPanel = document.getElementById('add_group_members_panel');
        const createGroupPanel = document.getElementById('create_group_panel');

        addMembersPanel.classList.add('hidden');
        addMembersPanel.classList.remove('flex');
        
        createGroupPanel.classList.remove('hidden');
        createGroupPanel.classList.add('flex');
        
        // Focus the group subject input
        const subjectInput = document.getElementById('group_subject_input');
        if (subjectInput) {
            subjectInput.value = '';
            subjectInput.focus();
        }
    }
</script>
<?php /**PATH D:\xampp\htdocs\laravel\chat_app\resources\views/chat/groups/add_group_members.blade.php ENDPATH**/ ?>