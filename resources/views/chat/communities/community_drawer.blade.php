<script>
    window.openCommunityGroupsDrawer = function(communityId) {
        const drawer = document.getElementById('community_groups_drawer');
        const content = document.getElementById('community_groups_drawer_content');
        if (!drawer || !content) return;

        drawer.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('translate-y-full');
            content.classList.add('translate-y-0');
        }, 10);

        const listContainer = document.getElementById('community_drawer_groups_list');
        listContainer.innerHTML = `
            <div class="flex justify-center items-center py-12">
                <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-[#00a884]"></div>
            </div>
        `;

        window.get(window.ref(window.db, `communities/${communityId}`)).then(async (snap) => {
            const community = snap.val();
            if (!community) {
                listContainer.innerHTML =
                    `<div class="text-[#8696a0] text-center py-6">Community not found.</div>`;
                return;
            }

            document.getElementById('community_drawer_title').textContent = community.name ||
                'Community';

            const adminsList = community.admins || [];
            const isCurrentUserAdmin = adminsList.includes(window.myUserId) || adminsList.includes(
                    parseInt(window.myUserId)) || adminsList.includes(String(window.myUserId)) ||
                String(community.createdBy) === String(window.myUserId);

            const footer = document.getElementById('community_drawer_admin_footer');
            if (isCurrentUserAdmin && footer) {
                footer.classList.remove('hidden');
            } else if (footer) {
                footer.classList.add('hidden');
            }

            const groupIds = community.groups || [];
            document.getElementById('community_drawer_subtitle').textContent =
                `${groupIds.length} groups in this community`;

            if (groupIds.length === 0) {
                listContainer.innerHTML =
                    `<div class="text-[#8696a0] text-center py-6">No groups in this community yet.</div>`;
                return;
            }

            listContainer.innerHTML = '';

            for (const gid of groupIds) {
                const gSnap = await window.get(window.ref(window.db, `groups/${gid}`));
                const g = gSnap.val();
                if (!g) continue;

                const isAnnounce = g.is_announcement === true;
                const isGeneral = g.is_general === true;
                const desc = isAnnounce ? 'Announcement Group' : (isGeneral ? 'General Group' : (g
                    .description || 'No description'));

                const groupAvatar = g.avatar ||
                    `https://ui-avatars.com/api/?name=${encodeURIComponent(g.name)}&background=2a3942&color=fff`;

                const isMember = g.users && (Object.values(g.users).includes(window.myUserId) || Object
                    .values(g.users).includes(parseInt(window.myUserId)) || Object.values(g.users)
                    .includes(String(window.myUserId)));

                let buttonHtml = '';
                if (isMember) {
                    buttonHtml = `
                        <button onclick="window.selectGroupChat('${g.id}', '${g.name.replace(/'/g, "\\'")}', '${groupAvatar}'); window.closeCommunityGroupsDrawer();" class="bg-[#2a3942] hover:bg-[#384b57] text-[#00a884] font-semibold px-4 py-1.5 rounded-full text-xs transition-colors shrink-0">
                            Open
                        </button>`;
                } else if (isCurrentUserAdmin) {
                    buttonHtml = `
                        <button onclick="window.selectGroupChat('${g.id}', '${g.name.replace(/'/g, "\\'")}', '${groupAvatar}'); window.closeCommunityGroupsDrawer();" class="bg-[#2a3942] hover:bg-[#384b57] text-[#00a884] font-semibold px-4 py-1.5 rounded-full text-xs transition-colors shrink-0">
                            View
                        </button>`;
                } else {
                    buttonHtml = `
                        <button onclick="window.requestToJoinGroup('${g.id}', '${communityId}')" class="bg-[#00a884] hover:bg-[#00bfa5] text-[#111b21] font-semibold px-4 py-1.5 rounded-full text-xs transition-colors shrink-0">
                            Join
                        </button>`;
                }

                const itemHtml = `
                    <div class="flex items-center justify-between p-3 bg-[#111b21] rounded-xl hover:bg-[#202c33] transition-colors cursor-pointer border border-white/5" onclick="if(!event.target.closest('button')) { ${isMember || isCurrentUserAdmin ? `window.selectGroupChat('${g.id}', '${g.name.replace(/'/g, "\\'")}', '${groupAvatar}'); window.closeCommunityGroupsDrawer();` : ''} }">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-12 h-12 rounded-full bg-[#2a3942] shrink-0 overflow-hidden relative">
                                <img src="${groupAvatar}" class="w-full h-full object-cover">
                                ${isAnnounce ? `
                                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-[#00a884] rounded-full flex items-center justify-center border-2 border-[#111b21]">
                                    <svg class="w-3 h-3 text-[#111b21]" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"></path>
                                    </svg>
                                </div>
                                ` : ''}
                            </div>
                            <div class="flex flex-col min-w-0">
                                <span class="text-[#e9edef] font-semibold text-[15px] truncate">${g.name}</span>
                                <span class="text-[#8696a0] text-[13px] truncate">${desc}</span>
                            </div>
                        </div>
                        <div class="ml-3 shrink-0">
                            ${buttonHtml}
                        </div>
                    </div>
                `;
                listContainer.insertAdjacentHTML('beforeend', itemHtml);
            }
        }).catch((err) => {
            console.error("Error loading community groups:", err);
            listContainer.innerHTML =
                `<div class="text-red-400 text-center py-6 text-sm">Failed to load groups.</div>`;
        });
    };

    window.closeCommunityGroupsDrawer = function() {
        const drawer = document.getElementById('community_groups_drawer');
        const content = document.getElementById('community_groups_drawer_content');
        if (!drawer || !content) return;

        content.classList.remove('translate-y-0');
        content.classList.add('translate-y-full');
        setTimeout(() => {
            drawer.classList.add('hidden');
        }, 300);
    };

    window.triggerAddGroupsFromDrawer = function() {
        window.closeCommunityGroupsDrawer();
        setTimeout(() => {
            if (window.currentGroupData && window.currentGroupData.community_id) {
                if (typeof window.showCommunityDetails === 'function') {
                    window.showCommunities();
                    window.showCommunityDetails(window.currentGroupData.community_id);
                }
            }
        }, 300);
    };

    window.requestToJoinGroup = async function(groupId, communityId) {
        // Implement logic to join a group from community
        alert('Join group requested.');
    };
</script>

<!-- Community Groups Bottom Sheet Drawer -->
<div id="community_groups_drawer" class="hidden fixed inset-0 z-[150] flex items-end justify-center">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-[#0b141a]/80 backdrop-blur-sm" onclick="window.closeCommunityGroupsDrawer()">
    </div>

    <!-- Drawer Content -->
    <div class="relative w-full max-w-[500px] bg-[#222e35] rounded-t-2xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden transform translate-y-full transition-transform duration-300 ease-out"
        id="community_groups_drawer_content">
        <!-- Drag Handle Indicator -->
        <div class="w-full flex justify-center py-2.5 shrink-0 bg-[#2a3942]/60 cursor-pointer"
            onclick="window.closeCommunityGroupsDrawer()">
            <div class="w-10 h-1 bg-[#8696a0]/30 rounded-full"></div>
        </div>

        <!-- Header -->
        <div class="px-6 pb-4 flex items-center justify-between bg-[#2a3942]/60 shrink-0 border-b border-white/5">
            <div class="flex flex-col">
                <h3 class="text-[#e9edef] text-[18px] font-bold" id="community_drawer_title">Community Groups</h3>
                <span class="text-[#8696a0] text-xs mt-0.5" id="community_drawer_subtitle">Groups in this
                    community</span>
            </div>
            <button onclick="window.closeCommunityGroupsDrawer()"
                class="text-[#8696a0] hover:text-[#e9edef] p-1.5 hover:bg-white/5 rounded-full transition-all focus:outline-none">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                    <path
                        d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Groups List -->
        <div id="community_drawer_groups_list"
            class="flex-1 overflow-y-auto custom-scrollbar p-4 flex flex-col gap-3">
            <!-- Dynamic Groups populated here -->
        </div>

        <!-- Admin Add Group Button Option -->
        <div id="community_drawer_admin_footer"
            class="hidden p-4 bg-[#111b21] border-t border-white/5 flex flex-col gap-2 shrink-0">
            <button onclick="window.triggerAddGroupsFromDrawer()"
                class="w-full bg-[#00a884] hover:bg-[#00bfa5] text-[#111b21] py-3 rounded-full flex items-center justify-center gap-2 font-bold transition-all active:scale-[0.98] shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                </svg>
                Manage Community Groups
            </button>
        </div>
    </div>
</div>
