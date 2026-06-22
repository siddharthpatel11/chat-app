<div id="communities_main_column" class="hidden flex-1 flex-col h-full bg-[#0b141a] overflow-hidden">

    <!-- 1. INTRO / CREATE LANDING SCREEN -->
    <div id="community_intro_screen"
        class="hidden flex-col items-center justify-center p-8 max-w-[500px] mx-auto my-auto text-center flex-1 min-h-0 overflow-y-auto custom-scrollbar">
        <!-- Close button top left (optional, on mobile back to list) -->
        <div class="w-full flex justify-start mb-6 sm:hidden">
            <button onclick="window.backToCommunitiesList()" class="text-[#aebac1] hover:text-white">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
            </button>
        </div>

        <!-- Illustration -->
        <div
            class="mb-8 p-6 bg-[#202c33]/40 rounded-full border border-[#313d45] flex items-center justify-center shadow-lg relative overflow-hidden">
            <!-- Mega green WhatsApp-style community SVG illustration -->
            <svg viewBox="0 0 120 120" width="120" height="120" class="text-[#00a884]">
                <rect x="20" y="20" width="80" height="80" rx="16" fill="#111b21" stroke="#313d45"
                    stroke-width="2" />
                <circle cx="60" cy="50" r="14" fill="#00a884" fill-opacity="0.2" />
                <path
                    d="M60 38c-3.3 0-6 2.7-6 6s2.7 6 6 6 6-2.7 6-6-2.7-6-6-6zm0 14c-4.4 0-13 2.2-13 6.6V62h26v-3.4c0-4.4-8.6-6.6-13-6.6z"
                    fill="#00a884" />
                <path d="M40 75h40M40 85h30" stroke="#8696a0" stroke-width="3" stroke-linecap="round" />
                <circle cx="85" cy="80" r="10" fill="#00a884" />
                <path d="M85 75v10M80 80h10" stroke="white" stroke-width="2" stroke-linecap="round" />
            </svg>
        </div>

        <h2 class="text-2xl text-[#e9edef] font-semibold mb-3">Create a new community</h2>
        <p class="text-[#8696a0] text-[15px] leading-relaxed mb-8">
            Bring together a neighborhood, school or more. Create topic-based groups for members, and easily send them
            admin announcements.
        </p>

        <button onclick="window.showCommunityForm()"
            class="w-full py-3 bg-[#00a884] hover:bg-[#008f72] text-[#111b21] font-medium rounded-full transition-all transform hover:scale-[1.02] shadow-md">
            Get started
        </button>
    </div>

    <!-- 2. NEW COMMUNITY FORM -->
    <div id="community_form_screen" class="hidden flex-col flex-1 min-h-0 overflow-y-auto custom-scrollbar">
        <!-- Header -->
        <div class="h-16 bg-[#202c33] flex items-center px-6 gap-6 shrink-0 border-b border-[#313d45]">
            <button onclick="window.showCommunityIntro()"
                class="text-[#aebac1] hover:text-[#e9edef] transition-colors p-1 rounded-full hover:bg-[#384b57]">
                <svg viewBox="0 0 24 24" height="24" width="24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
            </button>
            <span class="font-semibold text-lg text-[#e9edef]">New community</span>
        </div>

        <!-- Form fields -->
        <form id="create_community_form" onsubmit="window.submitCreateCommunity(event)"
            class="flex-1 p-6 flex flex-col items-center max-w-[420px] mx-auto w-full gap-6">
            <!-- Avatar Selector -->
            <div class="flex flex-col items-center gap-2 group">
                <div class="relative w-28 h-28 rounded-3xl bg-[#2a3942] flex items-center justify-center text-[#8696a0] border-2 border-dashed border-[#4f5d64] hover:border-[#00a884] cursor-pointer overflow-hidden transition-all shadow-md"
                    onclick="document.getElementById('community_avatar_input').click()">
                    <img id="community_avatar_preview" class="hidden w-full h-full object-cover">
                    <div id="community_avatar_placeholder" class="flex flex-col items-center gap-1 text-[13px]">
                        <svg viewBox="0 0 24 24" width="36" height="36" fill="currentColor">
                            <path
                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                        <span>Add icon</span>
                    </div>
                    <!-- Hover overlay -->
                    <div
                        class="absolute inset-0 bg-black/40 hidden group-hover:flex items-center justify-center text-white">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                            <path
                                d="M3 4V1h2v3h3v2H5v3H3V6H0V4h3zm3 6V7h3V4h7l1.83 2H21c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H6c-1.1 0-2-.9-2-2V10h2zm7 9c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-3.2-5c0 1.77 1.43 3.2 3.2 3.2s3.2-1.43 3.2-3.2-1.43-3.2-3.2-3.2-3.2 1.43-3.2 3.2z" />
                        </svg>
                    </div>
                </div>
                <input type="file" id="community_avatar_input" accept="image/*" class="hidden"
                    onchange="window.previewCommunityAvatar(event)">
                <span class="text-[12px] text-[#8696a0]">Community icon</span>
            </div>

            <!-- Name field -->
            <div class="w-full flex flex-col gap-1.5">
                <label class="text-[#8696a0] text-[13px]">Community name</label>
                <div class="relative border-b-2 border-[#313d45] focus-within:border-[#00a884] py-1 transition-all">
                    <input type="text" id="community_name_input" placeholder="New community name" required
                        maxlength="100"
                        class="w-full bg-transparent text-[#e9edef] placeholder-[#667781] border-none focus:ring-0 outline-none text-[15px] p-0"
                        oninput="document.getElementById('community_name_counter').textContent = this.value.length + '/100'">
                    <span id="community_name_counter"
                        class="absolute right-0 bottom-1.5 text-[11px] text-[#8696a0]">0/100</span>
                </div>
            </div>

            <!-- Description field -->
            <div class="w-full flex flex-col gap-1.5">
                <label class="text-[#8696a0] text-[13px]">Community description</label>
                <div
                    class="relative border border-[#313d45] focus-within:border-[#00a884] rounded-lg p-3 transition-all bg-[#202c33]/20">
                    <textarea id="community_desc_input" placeholder="Describe this community for members" maxlength="2048" rows="4"
                        class="w-full bg-transparent text-[#e9edef] placeholder-[#667781] border-none focus:ring-0 outline-none text-[15px] p-0 resize-none"
                        oninput="document.getElementById('community_desc_counter').textContent = this.value.length + '/2048'"></textarea>
                    <span id="community_desc_counter"
                        class="absolute right-3 bottom-2 text-[11px] text-[#8696a0]">0/2048</span>
                </div>
            </div>

            <!-- Floating action button submit -->
            <button type="submit"
                class="mt-4 w-14 h-14 bg-[#00a884] hover:bg-[#008f72] text-[#111b21] rounded-full flex items-center justify-center shadow-lg transition-transform hover:scale-105 select-none shrink-0 self-end">
                <svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor">
                    <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" />
                </svg>
            </button>
        </form>
    </div>

    <!-- 3. COMMUNITY DETAIL / INFO SCREEN -->
    <div id="community_detail_screen" class="hidden flex-col flex-1 min-h-0 bg-[#111b21] overflow-y-auto custom-scrollbar">
        <!-- Header Banner -->
        <div
            class="relative h-44 bg-gradient-to-b from-[#202c33] to-[#111b21] flex flex-col items-center justify-center p-4 border-b border-[#202c33] shrink-0">
            <!-- Back Arrow -->
            <button onclick="window.backToCommunitiesList()"
                class="absolute left-6 top-6 text-[#aebac1] hover:text-[#e9edef] transition-colors p-1.5 rounded-full hover:bg-[#384b57]/50 sm:hidden">
                <svg viewBox="0 0 24 24" height="24" width="24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
            </button>

            <!-- Three-Dot Menu -->
            <div class="absolute right-6 top-6">
                <button onclick="document.getElementById('community_details_menu').classList.toggle('hidden')"
                    class="text-[#aebac1] hover:text-[#e9edef] transition-colors p-1.5 rounded-full hover:bg-[#384b57]/50">
                    <svg viewBox="0 0 24 24" height="24" width="24" fill="currentColor">
                        <path
                            d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                    </svg>
                </button>
                <!-- Menu Dropdown -->
                <div id="community_details_menu"
                    class="hidden absolute right-0 mt-2 w-56 bg-[#233138] border border-[#313d45] rounded-xl shadow-2xl py-2 z-50 transform origin-top-right">
                    <button onclick="window.showEditCommunityDetailsModal()"
                        class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors text-[14.5px] flex items-center gap-3">
                        Edit community details
                    </button>
                    <button onclick="window.showManageGroupsModal()"
                        class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors text-[14.5px] flex items-center gap-3">
                        Manage groups
                    </button>
                    <button onclick="window.deactivateCommunityAction()"
                        class="w-full text-left px-4 py-3 text-red-500 hover:bg-[#182229] transition-colors text-[14.5px] flex items-center gap-3">
                        Deactivate community
                    </button>
                </div>
            </div>

            <!-- Avatar -->
            <div
                class="w-20 h-20 rounded-3xl bg-[#2a3942] overflow-hidden flex items-center justify-center border-2 border-[#111b21] shadow-lg mb-2">
                <img id="detail_community_avatar" class="w-full h-full object-cover">
            </div>

            <!-- Title & Info -->
            <h3 id="detail_community_name" class="text-xl text-[#e9edef] font-semibold truncate max-w-[80%]">Job</h3>
            <span id="detail_community_subtitle" class="text-[13px] text-[#8696a0]">Community · 2 groups</span>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-center gap-4 py-4 bg-[#0b141a]/30 border-b border-[#202c33] shrink-0">
            <button onclick="window.showInviteMembersModal()"
                class="flex flex-col items-center gap-1.5 px-6 py-2 rounded-xl hover:bg-[#202c33]/40 border border-[#313d45]/50 transition-colors text-[#00a884]">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                    <path
                        d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z" />
                </svg>
                <span class="text-[12px] font-medium text-[#e9edef]">Invite</span>
            </button>
            <button onclick="window.showAddMembersModal()"
                class="flex flex-col items-center gap-1.5 px-6 py-2 rounded-xl hover:bg-[#202c33]/40 border border-[#313d45]/50 transition-colors text-[#00a884]">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                    <path
                        d="M19 13h-2v2h-2v2h2v2h2v-2h2v-2h-2zM12.5 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm6.5 11h-1v-1.5c0-1.93-3.5-3-6.5-3s-6.5 1.07-6.5 3V17h14v-1.5z" />
                </svg>
                <span class="text-[12px] font-medium text-[#e9edef]">Add members</span>
            </button>
            <button onclick="window.showAddGroupsModal()"
                class="flex flex-col items-center gap-1.5 px-6 py-2 rounded-xl hover:bg-[#202c33]/40 border border-[#313d45]/50 transition-colors text-[#00a884]">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                    <path
                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    <path d="M19 13h-2v2h-2v2h2v2h2v-2h2v-2h-2z" />
                </svg>
                <span class="text-[12px] font-medium text-[#e9edef]">Add groups</span>
            </button>
        </div>

        <!-- Tabs Navigation -->
        <div class="flex bg-[#111b21] border-b border-[#202c33] shrink-0">
            <button onclick="window.switchCommunityTab('community')" id="tab_btn_community"
                class="flex-1 py-3 text-center border-b-2 border-[#00a884] text-[#e9edef] font-medium text-[15px] transition-all focus:outline-none">
                Community
            </button>
            <button onclick="window.switchCommunityTab('announcements')" id="tab_btn_announcements"
                class="flex-1 py-3 text-center border-b-2 border-transparent text-[#8696a0] font-medium text-[15px] transition-all focus:outline-none">
                Announcements
            </button>
            <button onclick="window.switchCommunityTab('requests')" id="tab_btn_requests"
                class="hidden flex-1 py-3 text-center border-b-2 border-transparent text-[#8696a0] font-medium text-[15px] transition-all focus:outline-none">
                Requests
            </button>
        </div>

        <!-- Tab Content 1: COMMUNITY (Groups & settings) -->
        <div id="tab_content_community" class="p-4 flex flex-col gap-4">
            <!-- Description -->
            <p id="detail_community_description"
                class="text-[#8696a0] text-sm leading-relaxed px-2 bg-[#202c33]/10 py-3 rounded-lg border border-[#313d45]/30">
                Hi everyone! This community is for members to chat in topic-based groups and get important
                announcements.
            </p>

            <!-- Menu Options list -->
            <div class="flex flex-col bg-[#111b21] rounded-xl overflow-hidden border border-[#202c33]">
                <button onclick="window.showEditCommunityDetailsModal()"
                    class="flex items-center gap-4 px-4 py-3.5 hover:bg-[#202c33] text-left transition-colors border-b border-[#202c33]/50">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"
                        class="text-[#aebac1]">
                        <path
                            d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                    </svg>
                    <span class="text-[#e9edef] text-[15px]">Edit community info</span>
                </button>
                <button onclick="window.showManageGroupsModal()"
                    class="flex items-center gap-4 px-4 py-3.5 hover:bg-[#202c33] text-left transition-colors border-b border-[#202c33]/50">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"
                        class="text-[#aebac1]">
                        <path
                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                    <span class="text-[#e9edef] text-[15px]">Manage groups</span>
                </button>
                <button onclick="window.showCommunityMembersList()"
                    class="flex items-center gap-4 px-4 py-3.5 hover:bg-[#202c33] text-left transition-colors">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"
                        class="text-[#aebac1]">
                        <path
                            d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                    </svg>
                    <span class="text-[#e9edef] text-[15px]" id="community_view_members_btn_label">View groups
                        (2)</span>
                </button>
            </div>
            
            <!-- Groups List Section -->
            <div id="community_detail_groups_section" class="flex flex-col gap-2 mt-2 hidden">
                <span class="text-[13px] text-[#00a884] font-medium px-2 uppercase tracking-wide">Groups in this community</span>
                <div class="flex flex-col bg-[#111b21] rounded-xl overflow-hidden border border-[#202c33]"
                    id="community_detail_groups_list">
                    <!-- Dynamic Groups List -->
                </div>
            </div>

            <!-- Members/Owner info list -->
            <div class="flex flex-col gap-2 mt-2">
                <span class="text-[13px] text-[#00a884] font-medium px-2 uppercase tracking-wide"
                    id="community_member_count_label">1 community member</span>
                <div class="flex flex-col bg-[#111b21] rounded-xl border border-[#202c33]"
                    id="community_detail_members_list">
                    <!-- Dynamic Member List -->
                </div>
            </div>

            <!-- Dangerous Area Options -->
            <div class="flex flex-col bg-[#111b21] rounded-xl overflow-hidden border border-[#202c33] mt-2">
                <button onclick="window.assignNewOwnerFlow()"
                    class="flex items-center gap-4 px-4 py-3.5 hover:bg-[#202c33] text-left text-[#e9edef] transition-colors border-b border-[#202c33]/50">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"
                        class="text-[#aebac1]">
                        <path d="M16.01 11H4v2h12.01v3L20 12l-3.99-4z" />
                    </svg>
                    <span>Assign new owner</span>
                </button>
                <button onclick="window.leaveCommunityAction()"
                    class="flex items-center gap-4 px-4 py-3.5 hover:bg-[#202c33] text-left text-red-500 transition-colors border-b border-[#202c33]/50">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"
                        class="text-red-500">
                        <path
                            d="M10.09 15.59L11.5 17l5-5-5-5-1.41 1.41L12.67 11H3v2h9.67l-2.58 2.59zM19 3H5c-1.11 0-2 .9-2 2v4h2V5h14v14H5v-4H3v4c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z" />
                    </svg>
                    <span>Exit community</span>
                </button>
                <button onclick="window.showToast('Report Submitted', 'Thank you for reporting this community.')"
                    class="flex items-center gap-4 px-4 py-3.5 hover:bg-[#202c33] text-left text-red-500 transition-colors border-b border-[#202c33]/50">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"
                        class="text-red-500">
                        <path
                            d="M10.85 1.25L.25 11.85c-.3.3-.3.8 0 1.1l10.6 10.6c.3.3.8.3 1.1 0l10.6-10.6c.3-.3.3-.8 0-1.1L11.95 1.25c-.3-.3-.8-.3-1.1 0zM12 18c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm1-4.3h-2v-6.4h2v6.4z" />
                    </svg>
                    <span>Report community</span>
                </button>
                <button id="deactivate_community_btn_row" onclick="window.deactivateCommunityAction()"
                    class="flex items-center gap-4 px-4 py-3.5 hover:bg-[#202c33] text-left text-red-500 transition-colors">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"
                        class="text-red-500">
                        <path
                            d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z" />
                    </svg>
                    <span>Deactivate community</span>
                </button>
            </div>
            
            <!-- Add Group Button (Only for Admins) -->
            <div id="community_add_group_btn_container" class="mt-6 px-2 hidden">
                <button onclick="window.showManageGroupsModal()"
                    class="w-full py-3 bg-[#00a884] hover:bg-[#008f72] text-[#111b21] font-semibold rounded-full flex items-center justify-center gap-2 transition-all transform hover:scale-[1.01] shadow-md">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    <span>Add group</span>
                </button>
            </div>
        </div>

        <!-- Tab Content 2: ANNOUNCEMENTS (Megaphone details) -->
        <div id="tab_content_announcements"
            class="hidden p-4 flex flex-col gap-4">
            
            <!-- Open Announcement Chat Button -->
            <button onclick="window.openAnnouncementChatFromTab()"
                class="w-full py-3 bg-[#00a884] hover:bg-[#008f72] text-[#111b21] font-semibold rounded-xl flex items-center justify-center gap-2 transition-colors shadow-md shrink-0">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                    <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6V9zm0-3h12v2H6V6zm0 6h7v2H6v-2z"/>
                </svg>
                <span>Open Announcement Chat</span>
            </button>

            <div class="flex flex-col bg-[#111b21] rounded-xl overflow-hidden border border-[#202c33]">
                <div class="flex items-center gap-4 px-4 py-3.5 border-b border-[#202c33]/50">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"
                        class="text-[#aebac1]">
                        <path
                            d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z" />
                    </svg>
                    <div class="flex-1">
                        <h4 class="text-[#e9edef] text-[15px] font-normal">Notifications</h4>
                        <p class="text-[#8696a0] text-[13px]">Muted until tomorrow 8:00 AM</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 px-4 py-3.5 border-b border-[#202c33]/50">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"
                        class="text-[#aebac1]">
                        <path
                            d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.96-2.36L6.5 17h11l-3.54-4.71z" />
                    </svg>
                    <div class="flex-1">
                        <h4 class="text-[#e9edef] text-[15px] font-normal">Media visibility</h4>
                        <p class="text-[#8696a0] text-[13px]">Default (Yes)</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 px-4 py-3.5 border-b border-[#202c33]/50">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"
                        class="text-[#aebac1]">
                        <path
                            d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z" />
                    </svg>
                    <div class="flex-1">
                        <h4 class="text-[#e9edef] text-[15px] font-normal">Encryption</h4>
                        <p class="text-[#8696a0] text-[13px] leading-relaxed">Messages and calls are end-to-end
                            encrypted. Tap to learn more.</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 px-4 py-3.5 border-b border-[#202c33]/50">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"
                        class="text-[#aebac1]">
                        <path
                            d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
                    </svg>
                    <div class="flex-1">
                        <h4 class="text-[#e9edef] text-[15px] font-normal">Disappearing messages</h4>
                        <p class="text-[#8696a0] text-[13px]">Off</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Content 3: REQUESTS (Pending join requests) -->
        <div id="tab_content_requests" class="hidden p-4 flex flex-col gap-4">
            <div class="flex flex-col gap-2 mt-2">
                <span class="text-[13px] text-[#00a884] font-medium px-2 uppercase tracking-wide" id="community_requests_count_label">Pending Requests</span>
                <div class="flex flex-col bg-[#111b21] rounded-xl border border-[#202c33] divide-y divide-[#202c33]/50" id="community_pending_requests_list">
                    <!-- Dynamic Request list with Accept/Reject buttons -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==============================================
     MODALS FOR COMMUNITY MANAGEMENT
     ============================================== -->

<!-- 1. ADD EXISTING GROUPS TO COMMUNITY MULTI-STEP MODAL -->
<div id="community_add_groups_modal"
    class="hidden fixed inset-0 bg-black/60 z-[300] flex items-center justify-center p-4">
    <div
        class="bg-[#222e35] w-full max-w-[450px] rounded-2xl shadow-2xl border border-[#313d45] flex flex-col max-h-[85vh] overflow-hidden relative">
        
        <!-- ==============================================
             STEP 1: SELECT GROUPS
             ============================================== -->
        <div id="add_existing_groups_select_view" class="flex flex-col flex-1 min-h-0 relative pb-20">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-[#313d45] flex items-center justify-between shrink-0">
                <div class="flex items-center gap-4">
                    <button onclick="document.getElementById('community_add_groups_modal').classList.add('hidden')"
                        class="text-[#aebac1] hover:text-[#e9edef] transition-colors p-1 rounded-full hover:bg-[#384b57]">
                        <svg viewBox="0 0 24 24" height="24" width="24" fill="currentColor">
                            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                        </svg>
                    </button>
                    <div class="flex flex-col">
                        <h3 class="text-[#e9edef] font-semibold text-lg leading-tight">Add existing groups</h3>
                        <span id="add_existing_selected_count_subtitle" class="text-[12px] text-[#8696a0]">0 of 99 selected</span>
                    </div>
                </div>
                <button onclick="window.toggleAddExistingSearch()" class="text-[#aebac1] hover:text-white p-1.5 rounded-full hover:bg-[#384b57]">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                        <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                    </svg>
                </button>
            </div>

            <!-- Search input container -->
            <div id="add_existing_search_container" class="hidden px-4 py-2 border-b border-[#313d45] shrink-0">
                <input type="text" id="add_existing_search_input" oninput="window.filterAddExistingGroups()" placeholder="Search groups..."
                    class="w-full bg-[#202c33] text-[#e9edef] placeholder-[#667781] border border-[#313d45] focus:border-[#00a884] rounded-lg px-3 py-1.5 text-sm outline-none">
            </div>

            <!-- Horizontal scroll of selected group chips -->
            <div id="add_existing_selected_chips_container" class="hidden px-4 py-3 border-b border-[#313d45] overflow-x-auto shrink-0 custom-scrollbar">
                <div id="add_existing_selected_chips" class="flex items-center gap-3">
                    <!-- Dynamic chips -->
                </div>
            </div>

            <!-- Groups List -->
            <div class="flex-1 overflow-y-auto p-4 custom-scrollbar flex flex-col gap-2">
                <span class="text-[13px] text-[#8696a0] font-medium px-3 uppercase tracking-wide">Groups you're an admin of</span>
                <div id="add_existing_groups_list" class="flex flex-col gap-1">
                    <!-- Dynamic list with checkmarks -->
                </div>
            </div>

            <!-- Next Floating Action Button -->
            <button onclick="window.goToAddExistingConfirmView()" id="add_existing_next_fab"
                class="absolute bottom-6 right-6 w-14 h-14 bg-[#00a884] hover:bg-[#008f72] text-[#111b21] rounded-full flex items-center justify-center shadow-lg transition-transform hover:scale-105 select-none shrink-0 z-[305] hidden">
                <svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor">
                    <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" />
                </svg>
            </button>
        </div>

        <!-- ==============================================
             STEP 2: CONFIRM GROUPS & CONFIG
             ============================================== -->
        <div id="add_existing_groups_confirm_view" class="hidden flex-col flex-1 min-h-0 pb-20">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-[#313d45] flex items-center gap-4 shrink-0">
                <button onclick="window.goToAddExistingSelectView()"
                    class="text-[#aebac1] hover:text-[#e9edef] transition-colors p-1 rounded-full hover:bg-[#384b57]">
                    <svg viewBox="0 0 24 24" height="24" width="24" fill="currentColor">
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                    </svg>
                </button>
                <h3 class="text-[#e9edef] font-semibold text-lg">Add to community</h3>
            </div>

            <!-- Scrollable content -->
            <div class="flex-1 overflow-y-auto p-6 flex flex-col items-center gap-6 custom-scrollbar">
                <!-- Community Avatar icon (Centered) -->
                <div class="w-16 h-16 rounded-3xl bg-[#2a3942] flex items-center justify-center text-white shrink-0 overflow-hidden border border-[#313d45] shadow-lg">
                    <img id="add_existing_comm_avatar" class="w-full h-full object-cover">
                </div>

                <!-- Title -->
                <h2 id="add_existing_confirm_title" class="text-xl text-[#e9edef] font-semibold text-center leading-snug px-4">Add 1 group to "Job"?</h2>

                <!-- Notice note -->
                <p class="text-[#8696a0] text-[13.5px] leading-relaxed text-center px-2">
                    People in this group will be added to the community and the announcement group, and can join other community groups. You can review group permissions:
                </p>

                <!-- Selected Group Previews list -->
                <div id="add_existing_preview_list" class="w-full flex flex-col gap-2 bg-[#202c33]/20 border border-[#313d45]/50 rounded-xl p-3">
                    <!-- Dynamic preview row -->
                </div>

                <!-- Settings Rows -->
                <div class="w-full flex flex-col gap-4 mt-2">
                    <!-- Group Visibility -->
                    <div onclick="window.showGroupVisibilityModalForAddExisting()"
                        class="flex items-center justify-between py-2.5 cursor-pointer hover:bg-[#202c33]/50 px-3 rounded-xl transition-colors border border-[#313d45]/30">
                        <div class="flex flex-col">
                            <span class="text-[#e9edef] text-[15px] font-medium">Group visibility</span>
                            <span id="add_existing_visibility_label" class="text-[13px] text-[#8696a0]">Visible</span>
                        </div>
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0]">
                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                        </svg>
                    </div>

                    <!-- Group Permissions -->
                    <div onclick="window.showGroupPermissionsModalForAddExisting()"
                        class="flex items-center justify-between py-2.5 cursor-pointer hover:bg-[#202c33]/50 px-3 rounded-xl transition-colors border border-[#313d45]/30">
                        <div class="flex flex-col">
                            <span class="text-[#e9edef] text-[15px] font-medium">Group permissions</span>
                            <span class="text-[13px] text-[#8696a0]">Edit settings, Send messages...</span>
                        </div>
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0]">
                            <path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Footer Add Button -->
            <div class="absolute bottom-0 inset-x-0 p-4 bg-[#222e35] border-t border-[#313d45] z-50 shrink-0">
                <button onclick="window.submitAddGroupsToCommunity()"
                    class="w-full py-3 bg-[#00a884] hover:bg-[#008f72] text-[#111b21] font-semibold rounded-full transition-all transform hover:scale-[1.01] shadow-md text-sm">
                    Add to community
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 2. ADD MEMBERS TO COMMUNITY MODAL -->
<div id="community_add_members_modal"
    class="hidden fixed inset-0 bg-black/60 z-[300] flex items-center justify-center p-4">
    <div
        class="bg-[#222e35] w-full max-w-[450px] rounded-2xl shadow-2xl border border-[#313d45] flex flex-col max-h-[85vh]">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-[#313d45] flex justify-between items-center shrink-0">
            <h3 class="text-[#e9edef] font-semibold text-lg">Add members to community</h3>
            <button onclick="document.getElementById('community_add_members_modal').classList.add('hidden')"
                class="text-[#aebac1] hover:text-white">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path
                        d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z" />
                </svg>
            </button>
        </div>
        <!-- Scrollable check list of user's contacts -->
        <div class="flex-1 overflow-y-auto p-4 custom-scrollbar flex flex-col gap-2" id="community_my_contacts_list">
            <!-- Dynamic listing will go here -->
        </div>
        <!-- Footer -->
        <div class="px-6 py-4 border-t border-[#313d45] flex justify-end gap-3 shrink-0">
            <button onclick="document.getElementById('community_add_members_modal').classList.add('hidden')"
                class="px-5 py-2.5 rounded-full hover:bg-[#384b57] text-[#00a884] font-medium text-sm transition-colors border border-[#313d45]">
                Cancel
            </button>
            <button onclick="window.submitAddMembersToCommunity()"
                class="px-6 py-2.5 rounded-full bg-[#00a884] hover:bg-[#008f72] text-[#111b21] font-medium text-sm transition-colors shadow-md">
                Add Members
            </button>
        </div>
    </div>
</div>

<!-- 3. EDIT COMMUNITY DETAILS MODAL -->
<div id="community_edit_details_modal"
    class="hidden fixed inset-0 bg-black/60 z-[300] flex items-center justify-center p-4">
    <div
        class="bg-[#222e35] w-full max-w-[450px] rounded-2xl shadow-2xl border border-[#313d45] flex flex-col max-h-[85vh]">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-[#313d45] flex justify-between items-center shrink-0">
            <h3 class="text-[#e9edef] font-semibold text-lg">Edit community details</h3>
            <button onclick="document.getElementById('community_edit_details_modal').classList.add('hidden')"
                class="text-[#aebac1] hover:text-white">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path
                        d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z" />
                </svg>
            </button>
        </div>
        <!-- Form Fields -->
        <form onsubmit="window.submitEditCommunityDetails(event)" class="p-6 flex flex-col gap-5">
            <!-- Edit Avatar -->
            <div class="flex items-center gap-4">
                <div class="relative w-16 h-16 rounded-2xl bg-[#2a3942] overflow-hidden flex items-center justify-center cursor-pointer border border-[#313d45]"
                    onclick="document.getElementById('edit_community_avatar_input').click()">
                    <img id="edit_community_avatar_preview" class="w-full h-full object-cover">
                </div>
                <input type="file" id="edit_community_avatar_input" accept="image/*" class="hidden"
                    onchange="window.previewEditCommunityAvatar(event)">
                <button type="button" onclick="document.getElementById('edit_community_avatar_input').click()"
                    class="text-[#00a884] text-sm hover:underline">Change photo</button>
            </div>
            <!-- Name -->
            <div class="flex flex-col gap-1">
                <label class="text-[#8696a0] text-[13px]">Community name</label>
                <input type="text" id="edit_community_name_input" required
                    class="bg-[#202c33] text-[#e9edef] border border-[#313d45] focus:border-[#00a884] rounded-lg px-3 py-2 text-[15px] outline-none">
            </div>
            <!-- Description -->
            <div class="flex flex-col gap-1">
                <label class="text-[#8696a0] text-[13px]">Community description</label>
                <textarea id="edit_community_desc_input" rows="3"
                    class="bg-[#202c33] text-[#e9edef] border border-[#313d45] focus:border-[#00a884] rounded-lg px-3 py-2 text-[15px] outline-none resize-none"></textarea>
            </div>
            <!-- Submit -->
            <div class="flex justify-end gap-3 mt-4">
                <button type="button"
                    onclick="document.getElementById('community_edit_details_modal').classList.add('hidden')"
                    class="px-5 py-2.5 rounded-full hover:bg-[#384b57] text-[#00a884] font-medium text-sm transition-colors border border-[#313d45]">
                    Cancel
                </button>
                <button type="submit"
                    class="px-6 py-2.5 rounded-full bg-[#00a884] hover:bg-[#008f72] text-[#111b21] font-medium text-sm transition-colors shadow-md">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ==============================================
     MANAGE & CREATE GROUPS FLOW MODALS
     ============================================== -->

<!-- MANAGE GROUPS MODAL -->
<div id="community_manage_groups_modal"
    class="hidden fixed inset-0 bg-black/60 z-[300] flex items-center justify-center p-4">
    <div
        class="bg-[#222e35] w-full max-w-[450px] rounded-2xl shadow-2xl border border-[#313d45] flex flex-col max-h-[85vh]">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-[#313d45] flex items-center gap-4 shrink-0">
            <button onclick="document.getElementById('community_manage_groups_modal').classList.add('hidden')"
                class="text-[#aebac1] hover:text-[#e9edef] transition-colors p-1 rounded-full hover:bg-[#384b57]">
                <svg viewBox="0 0 24 24" height="24" width="24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
            </button>
            <div class="flex flex-col">
                <h3 class="text-[#e9edef] font-semibold text-lg leading-tight">Manage groups</h3>
                <span id="manage_groups_count_subtitle" class="text-[12px] text-[#8696a0]">0 of 100</span>
            </div>
        </div>
        <!-- Scrollable content -->
        <div class="flex-1 overflow-y-auto p-4 custom-scrollbar flex flex-col gap-4">
            <!-- Create new group option -->
            <div onclick="window.showCreateNewGroupModal()"
                class="flex items-center gap-4 p-3 hover:bg-[#202c33] rounded-xl cursor-pointer transition-colors">
                <div class="w-10 h-10 rounded-full bg-[#00a884]/20 text-[#00a884] flex items-center justify-center shrink-0">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                        <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                    </svg>
                </div>
                <span class="text-[#e9edef] text-[15px] font-medium">Create new group</span>
            </div>
            <!-- Add existing groups option -->
            <div onclick="window.showAddExistingGroupsModal()"
                class="flex items-center gap-4 p-3 hover:bg-[#202c33] rounded-xl cursor-pointer transition-colors">
                <div class="w-10 h-10 rounded-full bg-[#00a884] text-[#111b21] flex items-center justify-center shrink-0">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                </div>
                <span class="text-[#e9edef] text-[15px] font-medium">Add existing groups</span>
            </div>

            <!-- Description note -->
            <p class="text-[#8696a0] text-[13px] leading-relaxed px-3">
                Members can suggest existing groups for admin approval and add new groups directly. View in <span class="text-[#00a884] hover:underline cursor-pointer">Community settings</span>
            </p>

            <div class="border-t border-[#313d45] my-2"></div>

            <!-- Groups list section -->
            <div class="flex flex-col gap-2">
                <span class="text-[13px] text-[#8696a0] font-medium px-3 uppercase tracking-wide">Groups in this community</span>
                <div id="manage_groups_list_container" class="flex flex-col">
                    <!-- Dynamic rendering of groups -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CREATE NEW GROUP MODAL -->
<div id="community_create_group_modal"
    class="hidden fixed inset-0 bg-black/60 z-[310] flex items-center justify-center p-4">
    <div
        class="bg-[#222e35] w-full max-w-[450px] rounded-2xl shadow-2xl border border-[#313d45] flex flex-col max-h-[85vh] overflow-hidden relative">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-[#313d45] flex items-center gap-4 shrink-0">
            <button onclick="document.getElementById('community_create_group_modal').classList.add('hidden')"
                class="text-[#aebac1] hover:text-[#e9edef] transition-colors p-1 rounded-full hover:bg-[#384b57]">
                <svg viewBox="0 0 24 24" height="24" width="24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
            </button>
            <div class="flex flex-col">
                <h3 class="text-[#e9edef] font-semibold text-lg leading-tight">New group</h3>
                <span id="create_group_community_name" class="text-[12px] text-[#8696a0]">Job</span>
            </div>
        </div>
        
        <!-- Form Content -->
        <form id="create_group_in_community_form" onsubmit="window.submitCreateGroupInCommunity(event)"
            class="flex-1 overflow-y-auto p-6 flex flex-col gap-6 custom-scrollbar pb-24">
            
            <!-- Avatar & Name Input -->
            <div class="flex items-center gap-4">
                <!-- Group Avatar Select -->
                <div class="relative w-14 h-14 rounded-full bg-[#2a3942] flex items-center justify-center text-[#8696a0] border border-[#313d45] hover:border-[#00a884] cursor-pointer overflow-hidden transition-all shadow-md shrink-0"
                    onclick="document.getElementById('new_group_avatar_input').click()">
                    <img id="new_group_avatar_preview" class="hidden w-full h-full object-cover">
                    <div id="new_group_avatar_placeholder">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                            <path d="M3 4V1h2v3h3v2H5v3H3V6H0V4h3zm3 6V7h3V4h7l1.83 2H21c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H6c-1.1 0-2-.9-2-2V10h2zm7 9c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-3.2-5c0 1.77 1.43 3.2 3.2 3.2s3.2-1.43 3.2-3.2-1.43-3.2-3.2-3.2-3.2 1.43-3.2 3.2z" />
                        </svg>
                    </div>
                </div>
                <input type="file" id="new_group_avatar_input" accept="image/*" class="hidden"
                    onchange="window.previewNewGroupAvatar(event)">
                
                <!-- Group Name -->
                <div class="flex-1 relative border-b-2 border-[#313d45] focus-within:border-[#00a884] py-1 transition-all">
                    <input type="text" id="new_group_name_input" placeholder="Enter group name" required maxlength="100"
                        class="w-full bg-transparent text-[#e9edef] placeholder-[#667781] border-none focus:ring-0 outline-none text-[16px] p-0">
                </div>
            </div>

            <!-- Group Description -->
            <div class="flex flex-col gap-1">
                <textarea id="new_group_desc_input" placeholder="Group description (optional)" rows="3"
                    class="bg-[#202c33] text-[#e9edef] placeholder-[#667781] border border-[#313d45] focus:border-[#00a884] rounded-lg px-3 py-2 text-[15px] outline-none resize-none"></textarea>
                <span class="text-[12px] text-[#8696a0] mt-1 leading-normal">Describe what your group is about to help people know what to expect and whether to join.</span>
            </div>

            <div class="border-t border-[#313d45] my-1"></div>

            <!-- Group Configuration items -->
            <div class="flex flex-col gap-4">
                <!-- Disappearing Messages -->
                <div onclick="window.toggleNewGroupDisappearingMessages()"
                    class="flex items-center justify-between py-2 cursor-pointer hover:bg-[#202c33]/50 px-2 rounded-lg transition-colors">
                    <div class="flex flex-col">
                        <span class="text-[#e9edef] text-[15px] font-medium">Disappearing messages</span>
                        <span id="new_group_disappearing_label" class="text-[13px] text-[#8696a0]">Off</span>
                    </div>
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0]">
                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                    </svg>
                </div>

                <!-- Group Visibility -->
                <div onclick="window.showGroupVisibilityModal()"
                    class="flex items-center justify-between py-2 cursor-pointer hover:bg-[#202c33]/50 px-2 rounded-lg transition-colors">
                    <div class="flex flex-col">
                        <span class="text-[#e9edef] text-[15px] font-medium">Group visibility</span>
                        <span id="new_group_visibility_label" class="text-[13px] text-[#8696a0]">Visible</span>
                    </div>
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0]">
                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                    </svg>
                </div>

                <!-- Group Permissions -->
                <div onclick="window.showGroupPermissionsModal()"
                    class="flex items-center justify-between py-2 cursor-pointer hover:bg-[#202c33]/50 px-2 rounded-lg transition-colors">
                    <div class="flex flex-col">
                        <span class="text-[#e9edef] text-[15px] font-medium">Group permissions</span>
                        <span class="text-[13px] text-[#8696a0]">Edit settings, Send messages...</span>
                    </div>
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0]">
                        <path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/>
                    </svg>
                </div>
            </div>

            <!-- Members -->
            <div class="flex flex-col gap-2">
                <span class="text-[13px] text-[#8696a0] font-medium uppercase tracking-wide">Members: <span id="new_group_members_count">None</span></span>
                <div class="flex items-center gap-3">
                    <button type="button" onclick="window.showNewGroupAddMembersModal()"
                        class="w-11 h-11 rounded-full bg-[#00a884]/20 hover:bg-[#00a884]/30 text-[#00a884] flex items-center justify-center transition-colors">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                            <path d="M19 13h-2v2h-2v2h2v2h2v-2h2v-2h-2zM12.5 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm6.5 11h-1v-1.5c0-1.93-3.5-3-6.5-3s-6.5 1.07-6.5 3V17h14v-1.5z" />
                        </svg>
                    </button>
                    <span class="text-[#e9edef] text-[14px]">Add</span>
                </div>
                <!-- Selected members container -->
                <div id="new_group_selected_members_list" class="flex flex-wrap gap-2 mt-2">
                </div>
            </div>

            <!-- Submit FAB -->
            <button type="submit"
                class="absolute bottom-6 right-6 w-14 h-14 bg-[#00a884] hover:bg-[#008f72] text-[#111b21] rounded-full flex items-center justify-center shadow-lg transition-transform hover:scale-105 select-none shrink-0 z-50">
                <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="3">
                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </form>
    </div>
</div>

<!-- GROUP VISIBILITY MODAL -->
<div id="group_visibility_modal"
    class="hidden fixed inset-0 bg-black/60 z-[320] flex items-center justify-center p-4">
    <div
        class="bg-[#222e35] w-full max-w-[380px] rounded-2xl shadow-2xl border border-[#313d45] flex flex-col p-6 gap-4">
        <h3 class="text-[#e9edef] font-semibold text-lg">Group visibility</h3>
        <p class="text-[#8696a0] text-[13.5px] leading-relaxed">
            To protect member privacy, this setting can't be changed once the group is added to the community. <span class="text-[#00a884] hover:underline cursor-pointer">Learn more about group visibility</span>
        </p>

        <!-- Options list -->
        <div class="flex flex-col gap-4 mt-2">
            <!-- Visible -->
            <label class="flex items-start gap-3 cursor-pointer">
                <input type="radio" name="group_visibility_option" value="visible" checked
                    class="mt-1 border-[#8696a0] text-[#00a884] focus:ring-0 focus:ring-offset-0 bg-transparent">
                <div class="flex flex-col">
                    <span class="text-[#e9edef] text-[15px] font-medium leading-tight">Visible</span>
                    <span class="text-[12.5px] text-[#8696a0] mt-1 leading-normal">Anyone in the community can see this group.</span>
                </div>
            </label>
            <!-- Hidden -->
            <label class="flex items-start gap-3 cursor-pointer">
                <input type="radio" name="group_visibility_option" value="hidden"
                    class="mt-1 border-[#8696a0] text-[#00a884] focus:ring-0 focus:ring-offset-0 bg-transparent">
                <div class="flex flex-col">
                    <span class="text-[#e9edef] text-[15px] font-medium leading-tight">Hidden</span>
                    <span class="text-[12.5px] text-[#8696a0] mt-1 leading-normal">Only invited members and community admins can see this group.</span>
                </div>
            </label>
        </div>

        <div class="flex justify-end gap-3 mt-4">
            <button onclick="window.saveGroupVisibility()"
                class="px-5 py-2 rounded-full bg-[#00a884] hover:bg-[#008f72] text-[#111b21] font-semibold text-sm transition-colors shadow-md">
                OK
            </button>
        </div>
    </div>
</div>

<!-- GROUP PERMISSIONS MODAL -->
<div id="group_permissions_modal"
    class="hidden fixed inset-0 bg-black/60 z-[320] flex items-center justify-center p-4">
    <div
        class="bg-[#222e35] w-full max-w-[420px] rounded-2xl shadow-2xl border border-[#313d45] flex flex-col max-h-[80vh] overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-[#313d45] flex items-center gap-4 shrink-0">
            <button onclick="window.closeGroupPermissionsModal()"
                class="text-[#aebac1] hover:text-[#e9edef] transition-colors p-1 rounded-full hover:bg-[#384b57]">
                <svg viewBox="0 0 24 24" height="24" width="24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
            </button>
            <div class="flex flex-col">
                <h3 class="text-[#e9edef] font-semibold text-lg leading-tight">Group permissions</h3>
                <span id="permissions_modal_subtitle" class="text-[12px] text-[#8696a0] hidden">Group Name</span>
            </div>
        </div>
        <!-- Permissions List -->
        <div class="flex-1 overflow-y-auto p-6 custom-scrollbar flex flex-col gap-6">
            <span class="text-[13px] text-[#8696a0] font-medium uppercase tracking-wide">Members can:</span>
            
            <!-- Edit group settings -->
            <div class="flex items-start justify-between gap-4">
                <div class="flex flex-col flex-1">
                    <span class="text-[#e9edef] text-[15px] font-medium">Edit group settings</span>
                    <span class="text-[12.5px] text-[#8696a0] mt-1 leading-normal">This includes the name, icon, description, disappearing message timer, and the ability to pin, keep or unkeep messages.</span>
                </div>
                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                    <input type="checkbox" id="perm_edit_settings" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-[#374248] rounded-full peer peer-focus:ring-0 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-[#aebac1] peer-checked:after:bg-[#111b21] after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
                </label>
            </div>

            <!-- Send new messages -->
            <div class="flex items-start justify-between gap-4">
                <div class="flex flex-col flex-1">
                    <span class="text-[#e9edef] text-[15px] font-medium">Send new messages</span>
                </div>
                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                    <input type="checkbox" id="perm_send_messages" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-[#374248] rounded-full peer peer-focus:ring-0 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-[#aebac1] peer-checked:after:bg-[#111b21] after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
                </label>
            </div>

            <!-- Add other members -->
            <div class="flex items-start justify-between gap-4">
                <div class="flex flex-col flex-1">
                    <span class="text-[#e9edef] text-[15px] font-medium">Add other members</span>
                    <span class="text-[12.5px] text-[#8696a0] mt-1 leading-normal">Only admins can add new people to this community. <span class="text-[#00a884] hover:underline cursor-pointer">Edit community settings</span></span>
                </div>
                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                    <input type="checkbox" id="perm_add_members" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-[#374248] rounded-full peer peer-focus:ring-0 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-[#aebac1] peer-checked:after:bg-[#111b21] after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
                </label>
            </div>

            <div class="border-t border-[#313d45] my-2"></div>
            
            <span class="text-[13px] text-[#8696a0] font-medium uppercase tracking-wide">Admins can:</span>

            <!-- Approve new members -->
            <div class="flex items-start justify-between gap-4">
                <div class="flex flex-col flex-1">
                    <span class="text-[#e9edef] text-[15px] font-medium">Approve new members</span>
                    <span class="text-[12.5px] text-[#8696a0] mt-1 leading-normal">When turned on, admins must approve anyone who wants to join the group. <span class="text-[#00a884] hover:underline cursor-pointer">Learn more</span></span>
                </div>
                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                    <input type="checkbox" id="perm_approve_members" class="sr-only peer">
                    <div class="w-11 h-6 bg-[#374248] rounded-full peer peer-focus:ring-0 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-[#aebac1] peer-checked:after:bg-[#111b21] after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
                </label>
            </div>

            <!-- Group Admins list display (New) -->
            <div id="permissions_modal_admins_section" class="hidden flex-col gap-2 mt-4 pt-4 border-t border-[#313d45]">
                <span class="text-[13px] text-[#8696a0] font-medium uppercase tracking-wide">Group admins</span>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-[#00a884]/20 text-[#00a884] flex items-center justify-center shrink-0">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="text-[#e9edef] text-[15px] font-medium">Edit group admins</span>
                        <span id="permissions_modal_admins_list" class="text-[12.5px] text-[#8696a0] truncate">Admins list</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <div class="px-6 py-4 border-t border-[#313d45] flex justify-end shrink-0">
            <button onclick="window.closeGroupPermissionsModal()"
                class="px-6 py-2 rounded-full bg-[#00a884] hover:bg-[#008f72] text-[#111b21] font-semibold text-sm transition-colors shadow-md">
                OK
            </button>
        </div>
    </div>
</div>

<!-- NEW GROUP ADD MEMBERS MODAL -->
<div id="new_group_add_members_modal"
    class="hidden fixed inset-0 bg-black/60 z-[320] flex items-center justify-center p-4">
    <div
        class="bg-[#222e35] w-full max-w-[450px] rounded-2xl shadow-2xl border border-[#313d45] flex flex-col max-h-[85vh]">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-[#313d45] flex justify-between items-center shrink-0">
            <h3 class="text-[#e9edef] font-semibold text-lg">Add members to group</h3>
            <button onclick="document.getElementById('new_group_add_members_modal').classList.add('hidden')"
                class="text-[#aebac1] hover:text-white">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path
                        d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z" />
                </svg>
            </button>
        </div>
        <!-- Scrollable check list of user's contacts -->
        <div class="flex-1 overflow-y-auto p-4 custom-scrollbar flex flex-col gap-2" id="new_group_contacts_list">
            <!-- Dynamic listing -->
        </div>
        <!-- Footer -->
        <div class="px-6 py-4 border-t border-[#313d45] flex justify-end gap-3 shrink-0">
            <button onclick="document.getElementById('new_group_add_members_modal').classList.add('hidden')"
                class="px-5 py-2.5 rounded-full hover:bg-[#384b57] text-[#00a884] font-medium text-sm transition-colors border border-[#313d45]">
                Cancel
            </button>
            <button onclick="window.confirmNewGroupMembers()"
                class="px-6 py-2.5 rounded-full bg-[#00a884] hover:bg-[#008f72] text-[#111b21] font-medium text-sm transition-colors shadow-md">
                Add Members
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('community_details_menu');
        if (!menu) return;
        const button = menu.previousElementSibling;
        
        if (!menu.classList.contains('hidden')) {
            if (!menu.contains(event.target) && (!button || !button.contains(event.target))) {
                menu.classList.add('hidden');
            }
        }
    });

    // ==========================================
    // COMMUNITIES FEATURE JS LOGIC
    // ==========================================
    window.activeCommunityId = null;
    window.activeCommunityTab = 'community';
    window.communityListeners = {};

    window.showCommunities = function() {
        window.closeAllSidebarPanels();

        // Update Navigation UI active states
        document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
        document.getElementById('nav_communities').classList.add('active');

        // Hide normal sidebar containers
        document.getElementById('user_sidebar_container').classList.add('hidden');
        document.getElementById('user_sidebar_container').classList.remove('sm:flex', 'flex');

        document.getElementById('status_view_container').classList.add('hidden');
        document.getElementById('status_view_container').classList.remove('flex');

        document.getElementById('calls_sidebar_container')?.classList.add('hidden');
        document.getElementById('calls_sidebar_container')?.classList.remove('flex');
        document.getElementById('calls_main_column')?.classList.add('hidden');
        document.getElementById('calls_main_column')?.classList.remove('flex');

        document.getElementById('chat_view_container').classList.add('hidden');
        document.getElementById('chat_view_container').classList.remove('flex');

        // Show Communities Sidebar & Panel
        const sidebar = document.getElementById('communities_sidebar_container');
        sidebar.classList.remove('hidden');
        sidebar.classList.add('sm:flex', 'flex');

        const newCommBtn = document.getElementById('new_community_action_btn');
        if (newCommBtn) {
            newCommBtn.classList.remove('hidden');
        }

        const mainColumn = document.getElementById('communities_main_column');
        mainColumn.classList.remove('hidden');
        mainColumn.classList.add('flex');

        document.getElementById('sidebar_resizer').classList.remove('hidden');

        if (window.activeCommunityId) {
            window.showCommunityDetails(window.activeCommunityId);
        } else {
            window.showCommunityIntro();
        }

        if (window.closeAllSettings) {
            window.closeAllSettings();
        }
    };

    window.openCommunityFromChats = function(communityId) {
        // 1. Close current active chat so middle pane goes back to empty state
        if (typeof window.closeChat === 'function') {
            window.closeChat();
        }

        // 2. Hide normal sidebar container
        const userSidebar = document.getElementById('user_sidebar_container');
        if (userSidebar) {
            userSidebar.classList.add('hidden');
            userSidebar.classList.remove('sm:flex', 'flex');
        }

        // 3. Show Communities Sidebar
        const sidebar = document.getElementById('communities_sidebar_container');
        if (sidebar) {
            sidebar.classList.remove('hidden');
            sidebar.classList.add('sm:flex', 'flex');
        }

        // 4. Hide "New community" button
        const newCommBtn = document.getElementById('new_community_action_btn');
        if (newCommBtn) {
            newCommBtn.classList.add('hidden');
        }

        // 5. Hide communities main column so chat_empty_state (middle pane) remains empty
        const mainColumn = document.getElementById('communities_main_column');
        if (mainColumn) {
            mainColumn.classList.add('hidden');
            mainColumn.classList.remove('flex');
        }

        // 6. Ensure chat_view_container is visible for empty state
        const chatView = document.getElementById('chat_view_container');
        if (chatView) {
            chatView.classList.remove('hidden');
            chatView.classList.add('flex');
        }

        // 7. Track active community ID
        window.activeCommunityId = communityId;
    };

    window.backToCommunitiesList = function() {
        document.getElementById('communities_sidebar_container').classList.remove('hidden');
        document.getElementById('communities_sidebar_container').classList.add('flex', 'w-full');
        document.getElementById('communities_main_column').classList.add('hidden');
        document.getElementById('communities_main_column').classList.remove('flex');
    };

    window.startCreateCommunityFlow = function() {
        // Ensure main column is visible (for mobile)
        if (window.innerWidth < 640) {
            document.getElementById('communities_sidebar_container').classList.add('hidden');
            document.getElementById('communities_sidebar_container').classList.remove('flex');
            document.getElementById('communities_main_column').classList.remove('hidden');
            document.getElementById('communities_main_column').classList.add('flex');
        }
        window.showCommunityIntro();
    };

    window.showCommunityIntro = function() {
        document.getElementById('community_intro_screen').classList.remove('hidden');
        document.getElementById('community_intro_screen').classList.add('flex');
        document.getElementById('community_form_screen').classList.add('hidden');
        document.getElementById('community_detail_screen').classList.add('hidden');
        document.getElementById('community_detail_screen').classList.remove('flex');
    };

    window.showCommunityForm = function() {
        document.getElementById('community_intro_screen').classList.add('hidden');
        document.getElementById('community_intro_screen').classList.remove('flex');
        document.getElementById('community_form_screen').classList.remove('hidden');
        document.getElementById('community_form_screen').classList.add('flex');
        document.getElementById('community_detail_screen').classList.add('hidden');

        // Reset Form
        document.getElementById('create_community_form').reset();
        document.getElementById('community_avatar_preview').src = '';
        document.getElementById('community_avatar_preview').classList.add('hidden');
        document.getElementById('community_avatar_placeholder').classList.remove('hidden');
        document.getElementById('community_name_counter').textContent = '0/100';
        document.getElementById('community_desc_counter').textContent = '0/2048';
    };

    window.previewCommunityAvatar = function(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('community_avatar_preview').src = e.target.result;
                document.getElementById('community_avatar_preview').classList.remove('hidden');
                document.getElementById('community_avatar_placeholder').classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    };

    window.previewEditCommunityAvatar = function(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('edit_community_avatar_preview').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    };

    window.submitCreateCommunity = async function(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData();
        formData.append('name', document.getElementById('community_name_input').value);
        formData.append('description', document.getElementById('community_desc_input').value);

        const avatarInput = document.getElementById('community_avatar_input');
        if (avatarInput.files && avatarInput.files[0]) {
            formData.append('avatar', avatarInput.files[0]);
        }

        try {
            window.showToast?.('Creating Community', 'Please wait...');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            const response = await fetch('/community/create', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: formData
            });
            const res = await response.json();
            if (res.status) {
                window.showToast?.('Success', 'Community created successfully!');
                window.activeCommunityId = res.community_id;
                window.showCommunityDetails(res.community_id);
            } else {
                alert(res.message || 'Failed to create community');
            }
        } catch (err) {
            console.error(err);
            alert('Error creating community');
        }
    };

    window.switchCommunityTab = function(tab) {
        window.activeCommunityTab = tab;
        const tabCommunity = document.getElementById('tab_btn_community');
        const tabAnnouncements = document.getElementById('tab_btn_announcements');
        const tabRequests = document.getElementById('tab_btn_requests');
        const contentCommunity = document.getElementById('tab_content_community');
        const contentAnnouncements = document.getElementById('tab_content_announcements');
        const contentRequests = document.getElementById('tab_content_requests');

        const activeClass = 'flex-1 py-3 text-center border-b-2 border-[#00a884] text-[#e9edef] font-medium text-[15px] transition-all focus:outline-none';
        const inactiveClass = 'flex-1 py-3 text-center border-b-2 border-transparent text-[#8696a0] font-medium text-[15px] transition-all focus:outline-none';

        if (tabCommunity) tabCommunity.className = inactiveClass;
        if (tabAnnouncements) tabAnnouncements.className = inactiveClass;
        if (tabRequests) tabRequests.className = inactiveClass;

        if (contentCommunity) contentCommunity.classList.add('hidden');
        if (contentAnnouncements) contentAnnouncements.classList.add('hidden');
        if (contentRequests) contentRequests.classList.add('hidden');

        if (tab === 'community') {
            if (tabCommunity) tabCommunity.className = activeClass;
            if (contentCommunity) contentCommunity.classList.remove('hidden');
        } else if (tab === 'announcements') {
            if (tabAnnouncements) tabAnnouncements.className = activeClass;
            if (contentAnnouncements) contentAnnouncements.classList.remove('hidden');
        } else if (tab === 'requests') {
            if (tabRequests) tabRequests.className = activeClass;
            if (contentRequests) contentRequests.classList.remove('hidden');
        }
    };

    window.showCommunityDetails = async function(communityId) {
        window.activeCommunityId = communityId;
        document.getElementById('community_intro_screen').classList.add('hidden');
        document.getElementById('community_form_screen').classList.add('hidden');
        document.getElementById('community_detail_screen').classList.remove('hidden');
        document.getElementById('community_detail_screen').classList.add('flex');

        try {
            const response = await fetch(`/community/${communityId}/info`);
            const res = await response.json();
            if (res.status && res.data) {
                const data = res.data;
                window.activeCommunityAnnouncementGroupId = data.announcement_group_id;
                document.getElementById('detail_community_name').textContent = data.name;
                document.getElementById('detail_community_description').textContent = data.description || 'No description';
                document.getElementById('detail_community_subtitle').textContent = `Community · ${data.groups ? data.groups.length : 0} groups`;
                document.getElementById('community_view_members_btn_label').textContent = `View groups (${data.groups ? data.groups.length : 0})`;
                document.getElementById('community_member_count_label').textContent = `${data.users ? data.users.length : 0} community members`;

                const avatar = data.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(data.name)}&background=2a3942&color=fff`;
                document.getElementById('detail_community_avatar').src = avatar;
                document.getElementById('edit_community_avatar_preview').src = avatar;
                document.getElementById('edit_community_name_input').value = data.name;
                document.getElementById('edit_community_desc_input').value = data.description || '';

                // Check admin status for UI options visibility
                const myId = String(window.myUserId);
                const isAdmin = data.admins && data.admins.map(String).includes(myId);

                const dropdownRow = document.getElementById('deactivate_community_btn_row');
                if (dropdownRow) {
                    dropdownRow.style.display = String(data.created_by) === myId ? 'flex' : 'none';
                }

                const addGroupBtnContainer = document.getElementById('community_add_group_btn_container');
                if (addGroupBtnContainer) {
                    if (isAdmin) {
                        addGroupBtnContainer.classList.remove('hidden');
                    } else {
                        addGroupBtnContainer.classList.add('hidden');
                    }
                }

                const tabRequestsBtn = document.getElementById('tab_btn_requests');
                if (tabRequestsBtn) {
                    if (isAdmin) {
                        tabRequestsBtn.classList.remove('hidden');
                    } else {
                        tabRequestsBtn.classList.add('hidden');
                        if (window.activeCommunityTab === 'requests') {
                            window.switchCommunityTab('community');
                        }
                    }
                }

                // Render pending requests if admin
                const requestsContainer = document.getElementById('community_pending_requests_list');
                const requestsCountLabel = document.getElementById('community_requests_count_label');
                if (requestsContainer) {
                    requestsContainer.innerHTML = '';
                    const reqList = Object.values(data.join_requests || {});
                    if (isAdmin && reqList.length > 0) {
                        if (requestsCountLabel) {
                            requestsCountLabel.textContent = `${reqList.length} Pending Request${reqList.length > 1 ? 's' : ''}`;
                        }
                        reqList.forEach(req => {
                            const reqAvatar = req.user_avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(req.user_name)}&background=2a3942&color=fff`;
                            requestsContainer.insertAdjacentHTML('beforeend', `
                                <div class="flex items-center gap-3 px-4 py-3 border-b border-[#202c33]/50 last:border-b-0">
                                    <img src="${reqAvatar}" class="w-10 h-10 rounded-full object-cover shrink-0">
                                    <div class="flex flex-col min-w-0 flex-1">
                                        <span class="text-[#e9edef] text-[15px] font-medium truncate">${req.user_name}</span>
                                        <span class="text-[12px] text-[#8696a0] truncate">Wants to join group: <strong class="text-[#e9edef]">${req.group_name}</strong></span>
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0">
                                        <button onclick="window.handleJoinRequestAction('${req.id}', 'accept')" class="px-3 py-1.5 bg-[#00a884] hover:bg-[#008f72] text-[#111b21] rounded-full text-xs font-semibold">Accept</button>
                                        <button onclick="window.handleJoinRequestAction('${req.id}', 'reject')" class="px-3 py-1.5 bg-red-500/20 hover:bg-red-500/30 text-red-500 rounded-full text-xs font-semibold">Reject</button>
                                    </div>
                                </div>
                            `);
                        });
                    } else {
                        if (requestsCountLabel) {
                            requestsCountLabel.textContent = 'No Pending Requests';
                        }
                        requestsContainer.innerHTML = `
                            <div class="p-6 text-center text-[#8696a0] text-sm">
                                No pending join requests.
                            </div>
                        `;
                    }
                }

                // Render Members
                const membersContainer = document.getElementById('community_detail_members_list');
                membersContainer.innerHTML = '';
                if (data.members_details) {
                    data.members_details.forEach(m => {
                        const isMe = String(m.id) === myId;
                        const isOwner = String(data.created_by) === String(m.id);
                        const isUserAdmin = data.admins && data.admins.map(String).includes(String(m.id));

                        const mAvatar = m.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(m.name)}&background=2a3942&color=fff`;
                        let badge = '';
                        if (isOwner) badge = `<span class="px-2 py-0.5 text-[10px] bg-[#00a884]/20 text-[#00a884] rounded-full">Community Owner</span>`;
                        else if (isUserAdmin) badge = `<span class="px-2 py-0.5 text-[10px] bg-white/10 text-[#aebac1] rounded-full">Admin</span>`;

                        let actions = '';
                        if (isAdmin && !isOwner && !isMe) {
                            actions = `
                                <div class="relative group/action ml-auto">
                                    <button class="text-[#8696a0] hover:text-[#e9edef] p-1.5 rounded-full hover:bg-white/5" onclick="this.nextElementSibling.classList.toggle('hidden')">
                                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                                    </button>
                                    <div class="hidden absolute right-0 mt-1 bg-[#233138] border border-[#313d45] rounded-xl shadow-2xl py-1.5 z-50 w-40 member-context-menu">
                                        <button onclick="window.toggleCommunityAdmin(${m.id}, '${isUserAdmin ? 'demote' : 'promote'}')" class="w-full text-left px-4 py-2.5 hover:bg-[#182229] text-sm text-[#e9edef]">${isUserAdmin ? 'Demote Admin' : 'Make Admin'}</button>
                                        <button onclick="window.removeMemberFromCommunity(${m.id})" class="w-full text-left px-4 py-2.5 hover:bg-[#182229] text-sm text-red-500">Remove</button>
                                    </div>
                                </div>`;
                        }

                        membersContainer.insertAdjacentHTML('beforeend', `
                            <div class="flex items-center gap-3 px-4 py-3 border-b border-[#202c33]/50 last:border-b-0 first:rounded-t-xl last:rounded-b-xl">
                                <img src="${mAvatar}" class="w-10 h-10 rounded-full object-cover shrink-0">
                                <div class="flex flex-col min-w-0">
                                    <span class="text-[#e9edef] text-[15px] font-medium truncate">${isMe ? 'You' : (m.name || m.phone)}</span>
                                    <span class="text-[12px] text-[#8696a0]">${m.phone || ''}</span>
                                </div>
                                <div class="flex items-center gap-2 ml-3">
                                    ${badge}
                                </div>
                                ${actions}
                            </div>
                        `);
                    });
                }

                // Render groups in "Community" tab
                const groupsContainer = document.getElementById('community_detail_groups_list');
                const groupsSection = document.getElementById('community_detail_groups_section');
                if (groupsContainer && groupsSection) {
                    groupsContainer.innerHTML = '';
                    if (data.groups_details && data.groups_details.length > 0) {
                        data.groups_details.forEach(g => {
                            const isAnnounce = g.is_announcement === true;
                            const isGeneral = g.is_general === true;

                            let desc = isAnnounce ? 'Announcement Group' : (isGeneral ? 'General Group' : (g.description || 'No description'));
                            const isMember = g.users && g.users.map(String).includes(myId);

                            let joinBtn = '';
                            if (!isMember) {
                                const reqList = Object.values(data.join_requests || {});
                                const hasPendingRequest = reqList.some(r => String(r.group_id) === String(g.id) && String(r.user_id) === myId && r.status === 'pending');
                                if (hasPendingRequest) {
                                    joinBtn = `<button class="ml-auto px-4 py-1.5 bg-[#202c33] text-[#8696a0] rounded-full text-xs font-semibold shrink-0 cursor-default" disabled>Requested</button>`;
                                } else {
                                    joinBtn = `<button onclick="window.joinCommunityGroup('${g.id}')" class="ml-auto px-4 py-1.5 bg-[#00a884] hover:bg-[#008f72] text-[#111b21] rounded-full text-xs font-semibold shrink-0">Join</button>`;
                                }
                            } else {
                                joinBtn = `
                                    <button onclick="window.selectGroupChat('${g.id}', '${g.name.replace(/'/g, "\\'")}')" class="ml-auto p-2 hover:bg-[#202c33] rounded-full text-[#00a884] shrink-0">
                                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6V9zm0-3h12v2H6V6zm0 6h7v2H6v-2z"/></svg>
                                    </button>`;
                            }

                            let removeBtn = '';
                            const isGroupOwner = (g.createdBy == myId) || (g.created_by == myId) || 
                                                 (g.admins && (Array.isArray(g.admins) ? g.admins : Object.values(g.admins)).map(String).includes(myId));
                            if (!isAnnounce && !isGeneral && (isAdmin || isGroupOwner)) {
                                removeBtn = `
                                    <button onclick="window.removeGroupFromCommunity('${g.id}')" 
                                        title="Remove from Community"
                                        class="p-2 hover:bg-[#202c33] rounded-full text-[#aebac1] hover:text-red-500 transition-colors shrink-0 mr-1">
                                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                                        </svg>
                                    </button>`;
                            }

                            let unreadCount = 0;
                            let unreadClass = "hidden";
                            const existingBadge = document.getElementById(`group_unread_badge_${g.id}`);
                            if (existingBadge && !existingBadge.classList.contains('hidden')) {
                                unreadCount = parseInt(existingBadge.textContent) || 0;
                                if (unreadCount > 0) unreadClass = "flex";
                            }

                            groupsContainer.insertAdjacentHTML('beforeend', `
                                <div class="flex items-center gap-3 px-4 py-3 border-b border-[#202c33]/50 last:border-b-0">
                                    <div class="w-10 h-10 rounded-full bg-[#2a3942] flex items-center justify-center text-white shrink-0 overflow-hidden">
                                        ${isAnnounce ? `
                                            <div class="w-full h-full bg-[#005c4b]/30 flex items-center justify-center text-[#00a884]">
                                                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                                            </div>` : `
                                            <img src="${g.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(g.name)}&background=2a3942&color=fff`}" class="w-full h-full object-cover">`}
                                    </div>
                                    <div class="flex flex-col min-w-0 flex-1">
                                        <div class="flex items-center">
                                            <span class="text-[#e9edef] text-[15px] font-medium truncate">${g.name}</span>
                                            <span id="community_drawer_unread_${g.id}" class="${unreadClass} ml-2 bg-[#00a884] text-[#111b21] text-[12px] font-bold min-w-[20px] h-5 rounded-full items-center justify-center px-1.5 shadow-sm">${unreadCount}</span>
                                        </div>
                                        <span class="text-[12px] text-[#8696a0] truncate">${desc}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 ml-auto">
                                        ${removeBtn}
                                        ${joinBtn}
                                    </div>
                                </div>
                            `);
                        });
                        groupsSection.classList.remove('hidden');
                    } else {
                        groupsSection.classList.add('hidden');
                    }
                }
            }
        } catch (err) {
            console.error(err);
        }
    };

    window.joinCommunityGroup = async function(groupId) {
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            const response = await fetch(`/community/${window.activeCommunityId}/groups/${groupId}/join-request`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });
            const res = await response.json();
            if (res.status) {
                window.showToast?.('Request Sent', 'Join request sent to community admins.');
                window.showCommunityDetails(window.activeCommunityId);
            } else {
                alert(res.message);
            }
        } catch (err) {
            console.error(err);
        }
    };

    window.handleJoinRequestAction = async function(requestId, action) {
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            const response = await fetch(`/community/${window.activeCommunityId}/requests/${requestId}/handle`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ action: action })
            });
            const res = await response.json();
            if (res.status) {
                window.showToast?.('Success', res.message);
                window.showCommunityDetails(window.activeCommunityId);
            } else {
                alert(res.message);
            }
        } catch (err) {
            console.error(err);
        }
    };

    window.showCommunityMembersList = function() {
        const section = document.getElementById('community_detail_groups_section');
        if (section) {
            section.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    };

    window.openAnnouncementChatFromTab = function() {
        if (window.activeCommunityAnnouncementGroupId) {
            if (typeof window.showChats === 'function') {
                window.showChats();
            }
            window.selectGroupChat(window.activeCommunityAnnouncementGroupId, 'Announcements');
        }
    };



    window.showEditCommunityDetailsModal = function() {
        document.getElementById('community_edit_details_modal').classList.remove('hidden');
        document.getElementById('community_details_menu').classList.add('hidden');
    };

    window.submitEditCommunityDetails = async function(event) {
        event.preventDefault();
        const formData = new FormData();
        formData.append('name', document.getElementById('edit_community_name_input').value);
        formData.append('description', document.getElementById('edit_community_desc_input').value);

        const file = document.getElementById('edit_community_avatar_input').files[0];
        if (file) {
            formData.append('avatar', file);
        }

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            const response = await fetch(`/community/${window.activeCommunityId}/update`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: formData
            });
            const res = await response.json();
            if (res.status) {
                window.showToast?.('Success', 'Community details updated successfully!');
                document.getElementById('community_edit_details_modal').classList.add('hidden');
                window.showCommunityDetails(window.activeCommunityId);
            } else {
                alert(res.message);
            }
        } catch (err) {
            console.error(err);
        }
    };

    window.selectedAddExistingGroupIds = [];
    window.addExistingGroupsData = {};
    window.addExistingVisibilityValue = 'visible';

    window.showAddGroupsModal = async function() {
        document.getElementById('community_add_groups_modal').classList.remove('hidden');
        window.goToAddExistingSelectView();

        const listContainer = document.getElementById('add_existing_groups_list');
        listContainer.innerHTML = '<span class="text-[#8696a0] text-sm px-3">Loading groups you\'re an admin of...</span>';

        // Clear search input
        const searchInput = document.getElementById('add_existing_search_input');
        if (searchInput) searchInput.value = '';
        const searchContainer = document.getElementById('add_existing_search_container');
        if (searchContainer) searchContainer.classList.add('hidden');

        try {
            // Fetch active community info to see its linked groups
            let activeCommunityGroups = [];
            try {
                const commResponse = await fetch(`/community/${window.activeCommunityId}/info`);
                const commRes = await commResponse.json();
                if (commRes.status && commRes.data && commRes.data.groups) {
                    activeCommunityGroups = commRes.data.groups.map(String);
                }
            } catch (e) {
                console.error("Error fetching active community groups:", e);
            }

            const snap = await window.get(window.ref(window.db, 'groups'));
            const groups = snap.val();
            listContainer.innerHTML = '';
            window.selectedAddExistingGroupIds = [];
            window.addExistingGroupsData = {};

            // Hide chips & FAB initially
            document.getElementById('add_existing_selected_chips_container').classList.add('hidden');
            document.getElementById('add_existing_next_fab').classList.add('hidden');

            if (!groups) {
                listContainer.innerHTML = '<span class="text-[#8696a0] text-sm px-3">No groups found.</span>';
                return;
            }

            const myIdStr = String(window.myUserId);
            const adminGroups = [];

            Object.values(groups).forEach(g => {
                if (!g) return;
                // Skip announcements or general groups or groups already in this community's groups array
                if (g.is_announcement || g.is_general) return;
                if (activeCommunityGroups.includes(String(g.id))) return;

                // Check if user is in the group and is admin
                const admins = g.admins ? (Array.isArray(g.admins) ? g.admins : Object.values(g.admins)).map(String) : [];
                const users = g.users ? (Array.isArray(g.users) ? g.users : Object.values(g.users)).map(String) : [];

                if (users.includes(myIdStr) && (admins.includes(myIdStr) || String(g.createdBy) === myIdStr)) {
                    adminGroups.push(g);
                    window.addExistingGroupsData[g.id] = g;
                }
            });

            if (adminGroups.length === 0) {
                listContainer.innerHTML = '<span class="text-[#8696a0] text-sm px-3">No groups where you are an admin.</span>';
                return;
            }

            // Render admin groups
            adminGroups.forEach(g => {
                const users = g.users ? (Array.isArray(g.users) ? g.users : Object.values(g.users)).map(String) : [];
                const memberNames = [];
                users.forEach(uid => {
                    if (uid === myIdStr) {
                        memberNames.push('You');
                    } else if (window.allContacts) {
                        const contact = window.allContacts.find(c => String(c.id) === uid);
                        if (contact) {
                            memberNames.push(contact.name || contact.phone);
                        } else {
                            memberNames.push(uid);
                        }
                    } else {
                        memberNames.push(uid);
                    }
                });
                const membersText = memberNames.join(', ');
                const avatar = g.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(g.name)}&background=2a3942&color=fff`;

                listContainer.insertAdjacentHTML('beforeend', `
                    <div onclick="window.toggleAddExistingGroupSelect('${g.id}')" id="add_existing_row_${g.id}"
                         class="flex items-center gap-3 p-3 hover:bg-[#202c33]/40 border border-[#313d45]/20 hover:border-[#313d45]/85 rounded-xl cursor-pointer transition-all relative">
                        <div class="relative w-12 h-12 shrink-0">
                            <img src="${avatar}" class="w-full h-full rounded-full object-cover">
                            <div id="add_existing_check_icon_${g.id}" class="absolute -bottom-1 -right-1 w-5 h-5 bg-[#00a884] rounded-full hidden items-center justify-center border-2 border-[#222e35] text-white">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="4">
                                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex flex-col min-w-0 flex-1">
                            <span class="text-[#e9edef] text-[15px] font-medium truncate">${g.name}</span>
                            <span class="text-[12.5px] text-[#8696a0] truncate">${membersText}</span>
                        </div>
                    </div>
                `);
            });

            window.updateAddExistingSubtitle();

        } catch (err) {
            console.error(err);
            listContainer.innerHTML = '<span class="text-red-500 text-sm px-3">Failed to load groups.</span>';
        }
    };

    window.toggleAddExistingGroupSelect = function(groupId) {
        const idx = window.selectedAddExistingGroupIds.indexOf(groupId);
        const row = document.getElementById(`add_existing_row_${groupId}`);
        const checkIcon = document.getElementById(`add_existing_check_icon_${groupId}`);

        if (idx === -1) {
            window.selectedAddExistingGroupIds.push(groupId);
            if (row) row.classList.add('bg-[#202c33]/85', 'border-[#00a884]/40');
            if (checkIcon) {
                checkIcon.classList.remove('hidden');
                checkIcon.classList.add('flex');
            }
        } else {
            window.selectedAddExistingGroupIds.splice(idx, 1);
            if (row) {
                row.classList.remove('bg-[#202c33]/85', 'border-[#00a884]/40');
            }
            if (checkIcon) {
                checkIcon.classList.add('hidden');
                checkIcon.classList.remove('flex');
            }
        }

        window.renderAddExistingChips();
        window.updateAddExistingSubtitle();

        // Toggle FAB
        const nextFab = document.getElementById('add_existing_next_fab');
        if (nextFab) {
            if (window.selectedAddExistingGroupIds.length > 0) {
                nextFab.classList.remove('hidden');
            } else {
                nextFab.classList.add('hidden');
            }
        }
    };

    window.renderAddExistingChips = function() {
        const container = document.getElementById('add_existing_selected_chips_container');
        const chips = document.getElementById('add_existing_selected_chips');
        chips.innerHTML = '';

        if (window.selectedAddExistingGroupIds.length === 0) {
            container.classList.add('hidden');
            return;
        }

        container.classList.remove('hidden');
        window.selectedAddExistingGroupIds.forEach(gid => {
            const g = window.addExistingGroupsData[gid];
            if (!g) return;

            const avatar = g.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(g.name)}&background=2a3942&color=fff`;
            chips.insertAdjacentHTML('beforeend', `
                <div class="relative w-12 flex flex-col items-center gap-1">
                    <div class="w-10 h-10 rounded-full overflow-hidden bg-[#2a3942] relative border border-[#313d45]">
                        <img src="${avatar}" class="w-full h-full object-cover">
                    </div>
                    <button onclick="window.toggleAddExistingGroupSelect('${gid}')"
                        class="absolute -top-1 right-0 w-4 h-4 bg-[#374248] text-[#aebac1] hover:text-white rounded-full flex items-center justify-center text-[10px] border border-[#222e35]">
                        ×
                    </button>
                    <span class="text-[10px] text-[#8696a0] truncate w-full text-center">${g.name}</span>
                </div>
            `);
        });
    };

    window.updateAddExistingSubtitle = function() {
        const subtitle = document.getElementById('add_existing_selected_count_subtitle');
        if (subtitle) {
            const count = window.selectedAddExistingGroupIds.length;
            subtitle.textContent = `${count} of 99 selected`;
        }
    };

    window.toggleAddExistingSearch = function() {
        const container = document.getElementById('add_existing_search_container');
        if (container) {
            container.classList.toggle('hidden');
            const input = document.getElementById('add_existing_search_input');
            if (!container.classList.contains('hidden') && input) {
                input.focus();
            }
        }
    };

    window.filterAddExistingGroups = function() {
        const query = document.getElementById('add_existing_search_input').value.toLowerCase().trim();
        Object.values(window.addExistingGroupsData).forEach(g => {
            const row = document.getElementById(`add_existing_row_${g.id}`);
            if (row) {
                if (g.name.toLowerCase().includes(query)) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            }
        });
    };

    window.goToAddExistingSelectView = function() {
        document.getElementById('add_existing_groups_select_view').classList.remove('hidden');
        document.getElementById('add_existing_groups_select_view').classList.add('flex');
        document.getElementById('add_existing_groups_confirm_view').classList.add('hidden');
        document.getElementById('add_existing_groups_confirm_view').classList.remove('flex');
    };

    window.goToAddExistingConfirmView = function() {
        document.getElementById('add_existing_groups_select_view').classList.add('hidden');
        document.getElementById('add_existing_groups_select_view').classList.remove('flex');
        document.getElementById('add_existing_groups_confirm_view').classList.remove('hidden');
        document.getElementById('add_existing_groups_confirm_view').classList.add('flex');

        // Set community avatar
        const commAvatarEl = document.getElementById('detail_community_avatar');
        const confirmCommAvatar = document.getElementById('add_existing_comm_avatar');
        if (commAvatarEl && confirmCommAvatar) {
            confirmCommAvatar.src = commAvatarEl.src;
        }

        // Set title
        const count = window.selectedAddExistingGroupIds.length;
        const commName = document.getElementById('detail_community_name').textContent;
        document.getElementById('add_existing_confirm_title').textContent = `Add ${count} group${count > 1 ? 's' : ''} to "${commName}"?`;

        // Render preview list
        const list = document.getElementById('add_existing_preview_list');
        list.innerHTML = '';
        window.selectedAddExistingGroupIds.forEach(gid => {
            const g = window.addExistingGroupsData[gid];
            if (!g) return;

            const avatar = g.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(g.name)}&background=2a3942&color=fff`;

            const users = g.users ? (Array.isArray(g.users) ? g.users : Object.values(g.users)).map(String) : [];
            const myIdStr = String(window.myUserId);
            const memberNames = [];
            users.forEach(uid => {
                if (uid === myIdStr) {
                    memberNames.push('You');
                } else if (window.allContacts) {
                    const contact = window.allContacts.find(c => String(c.id) === uid);
                    if (contact) {
                        memberNames.push(contact.name || contact.phone);
                    } else {
                        memberNames.push(uid);
                    }
                } else {
                    memberNames.push(uid);
                }
            });
            const membersText = memberNames.join(', ');

            list.insertAdjacentHTML('beforeend', `
                <div class="flex items-center gap-3 py-2 border-b border-[#313d45]/30 last:border-b-0">
                    <img src="${avatar}" class="w-10 h-10 rounded-full object-cover shrink-0">
                    <div class="flex flex-col min-w-0">
                        <span class="text-[#e9edef] text-[15px] font-medium truncate">${g.name}</span>
                        <span class="text-[12px] text-[#8696a0] truncate">${membersText}</span>
                    </div>
                </div>
            `);
        });

        // Reset visibility
        window.addExistingVisibilityValue = 'visible';
        document.getElementById('add_existing_visibility_label').textContent = 'Visible';
    };

    window.showGroupVisibilityModalForAddExisting = function() {
        window.isEditingAddExistingConfig = true;
        window.newGroupVisibilityValue = window.addExistingVisibilityValue;
        window.showGroupVisibilityModal();
    };

    window.showGroupPermissionsModalForAddExisting = function() {
        window.isEditingAddExistingConfig = true;

        const subtitle = document.getElementById('permissions_modal_subtitle');
        const firstSelectedGroup = window.addExistingGroupsData[window.selectedAddExistingGroupIds[0]];
        if (subtitle && firstSelectedGroup) {
            subtitle.textContent = firstSelectedGroup.name;
            subtitle.classList.remove('hidden');
        }

        const adminsSection = document.getElementById('permissions_modal_admins_section');
        const adminsListEl = document.getElementById('permissions_modal_admins_list');
        if (adminsSection && adminsListEl && firstSelectedGroup) {
            adminsSection.classList.remove('hidden');
            adminsSection.classList.add('flex');

            const admins = firstSelectedGroup.admins ? (Array.isArray(firstSelectedGroup.admins) ? firstSelectedGroup.admins : Object.values(firstSelectedGroup.admins)).map(String) : [];
            const myIdStr = String(window.myUserId);
            const adminNames = [];
            admins.forEach(uid => {
                if (uid === myIdStr) {
                    adminNames.push('You');
                } else if (window.allContacts) {
                    const contact = window.allContacts.find(c => String(c.id) === uid);
                    if (contact) {
                        adminNames.push(contact.name || contact.phone);
                    } else {
                        adminNames.push(uid);
                    }
                } else {
                    adminNames.push(uid);
                }
            });

            let adminNamesText = adminNames.join(', ');
            if (adminNames.length > 1 && adminNames.includes('You')) {
                const filtered = adminNames.filter(n => n !== 'You');
                adminNamesText = filtered.join(', ') + ' and You';
            }

            adminsListEl.textContent = adminNamesText || 'None';
        }

        window.showGroupPermissionsModal();
    };

    window.closeGroupPermissionsModal = function() {
        document.getElementById('group_permissions_modal').classList.add('hidden');
        window.isEditingAddExistingConfig = false;
    };

    window.submitAddGroupsToCommunity = async function() {
        if (window.selectedAddExistingGroupIds.length === 0) {
            alert('Select at least one group');
            return;
        }

        try {
            window.showToast?.('Adding Groups', 'Please wait...');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            const response = await fetch(`/community/${window.activeCommunityId}/add-groups`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ group_ids: window.selectedAddExistingGroupIds })
            });
            const res = await response.json();
            if (res.status) {
                window.showToast?.('Success', 'Groups added successfully!');
                document.getElementById('community_add_groups_modal').classList.add('hidden');
                window.showCommunityDetails(window.activeCommunityId);
            } else {
                alert(res.message || 'Failed to add groups');
            }
        } catch (err) {
            console.error(err);
            alert('Error adding groups');
        }
    };

    window.showAddMembersModal = function() {
        document.getElementById('community_add_members_modal').classList.remove('hidden');
        const listContainer = document.getElementById('community_my_contacts_list');
        listContainer.innerHTML = '';

        // Gather all user contacts from sidebar
        const contactNodes = document.getElementById('user_list_container').querySelectorAll('[id^="user_sidebar_"]');
        if (contactNodes.length === 0) {
            listContainer.innerHTML = '<span class="text-[#8696a0] text-sm">No contacts found to add.</span>';
            return;
        }

        contactNodes.forEach(node => {
            const uid = node.getAttribute('data-userid');
            // Skip special users
            if (uid === 'meta_ai') return;

            const name = node.getAttribute('data-name');
            const avatar = node.getAttribute('data-avatar');

            listContainer.insertAdjacentHTML('beforeend', `
                <label class="flex items-center gap-3 p-3 bg-[#202c33]/40 border border-[#313d45]/50 hover:bg-[#202c33]/80 rounded-xl cursor-pointer">
                    <input type="checkbox" name="community_add_member_check" value="${uid}" class="rounded border-[#313d45] text-[#00a884] focus:ring-0">
                    <img src="${avatar}" class="w-10 h-10 rounded-full object-cover">
                    <span class="text-[#e9edef] text-[15px] font-medium">${name}</span>
                </label>
            `);
        });
    };

    window.submitAddMembersToCommunity = async function() {
        const checked = Array.from(document.querySelectorAll('input[name="community_add_member_check"]:checked')).map(cb => cb.value);
        if (checked.length === 0) {
            alert('Select at least one member');
            return;
        }

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            const response = await fetch(`/community/${window.activeCommunityId}/add-members`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ users: checked })
            });
            const res = await response.json();
            if (res.status) {
                window.showToast?.('Success', 'Members added successfully!');
                document.getElementById('community_add_members_modal').classList.add('hidden');
                window.showCommunityDetails(window.activeCommunityId);
            } else {
                alert(res.message);
            }
        } catch (err) {
            console.error(err);
        }
    };

    window.toggleCommunityAdmin = async function(targetUserId, action) {
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            const response = await fetch(`/community/${window.activeCommunityId}/toggle-admin`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ target_user_id: targetUserId, action: action })
            });
            const res = await response.json();
            if (res.status) {
                window.showToast?.('Success', res.message);
                window.showCommunityDetails(window.activeCommunityId);
            } else {
                alert(res.message);
            }
        } catch (err) {
            console.error(err);
        }
    };

    window.removeMemberFromCommunity = async function(targetUserId) {
        const action = async () => {
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
                const response = await fetch(`/community/${window.activeCommunityId}/remove-member`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ remove_user_id: targetUserId })
                });
                const res = await response.json();
                if (res.status) {
                    window.showToast?.('Success', 'Member removed');
                    window.showCommunityDetails(window.activeCommunityId);
                } else {
                    alert(res.message);
                }
            } catch (err) {
                console.error(err);
            }
        };

        if (window.openDeleteModal) {
            window.openDeleteModal('Remove member from community and all linked groups?', action, null, 'Remove');
        } else if (confirm('Remove member from community and all linked groups?')) {
            action();
        }
    };

    window.leaveCommunityAction = async function() {
        const action = async () => {
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
                const response = await fetch(`/community/${window.activeCommunityId}/leave`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });
                const res = await response.json();
                if (res.status) {
                    window.showToast?.('Left Community', 'You successfully left.');
                    window.activeCommunityId = null;
                    window.showCommunityIntro();
                } else {
                    alert(res.message);
                }
            } catch (err) {
                console.error(err);
            }
        };

        if (window.openDeleteModal) {
            window.openDeleteModal('Are you sure you want to leave this community and all its groups?', action, null, 'Leave');
        } else if (confirm('Are you sure you want to leave this community and all its groups?')) {
            action();
        }
    };

    window.selectCommunityAnnouncementsChat = function(communityId, announcementGroupId) {
        // Track active community
        window.activeCommunityId = communityId;
        window.showCommunityDetails(communityId);
        
        // Open the Announcements group chat
        if (announcementGroupId && typeof window.selectGroupChat === 'function') {
            window.selectGroupChat(announcementGroupId, 'Announcements');
        }
    };

    window.loadCommunitySidebarGroup = function(communityId, groupId, announcementGroupId) {
        const rowId = `comm_group_row_${communityId}_${groupId}`;
        const ref = window.ref(window.db, `groups/${groupId}`);
        
        window.onValue(ref, (snap) => {
            const g = snap.val();
            const rowEl = document.getElementById(rowId);
            if (!rowEl) return;
            if (!g) {
                rowEl.innerHTML = '';
                return;
            }

            const users = g.users ? (Array.isArray(g.users) ? g.users : Object.values(g.users)) : [];
            const myIdStr = String(window.myUserId);
            const isMember = users.map(String).includes(myIdStr);

            const isAnnounce = groupId === announcementGroupId || g.is_announcement === true;
            const isGeneral = g.is_general === true;

            const iconHtml = isAnnounce ? `
                <div class="w-9 h-9 rounded-xl bg-[#3d302b] flex items-center justify-center text-[#ff8e6e] shrink-0 border border-white/5 shadow-inner">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                </div>
            ` : `
                <div class="w-9 h-9 rounded-full bg-[#2a3942] flex items-center justify-center text-gray-400 shrink-0">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                </div>
            `;

            const displayName = isAnnounce ? 'Announcements' : g.name;
            const subtitle = isAnnounce ? 'Welcome to announcements' : (isMember ? 'Group chat' : 'Join group');
            const avatarUrl = g.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(displayName)}&background=2a3942&color=fff`;

            let clickAction = '';
            if (isMember) {
                clickAction = `window.selectGroupChat('${groupId}', '${displayName.replace(/'/g, "\\'")}', '${avatarUrl}')`;
            } else {
                clickAction = `window.openGroupJoinPreviewModal('${groupId}', '${communityId}')`;
            }

            let unreadCount = 0;
            let unreadClass = "hidden";
            const existingBadge = document.getElementById(`group_unread_badge_${groupId}`);
            if (existingBadge && !existingBadge.classList.contains('hidden')) {
                unreadCount = parseInt(existingBadge.textContent) || 0;
                if (unreadCount > 0) unreadClass = "flex";
            }

            rowEl.innerHTML = `
                <div class="flex items-center pl-10 pr-4 py-2.5 hover:bg-[#202c33]/30 cursor-pointer border-t border-[#202c33]/10"
                     onclick="${clickAction}">
                    ${iconHtml}
                    <div class="ml-3 flex-1 min-w-0">
                        <div class="flex justify-between items-center">
                            <h5 class="text-[14px] text-[#e9edef] font-medium truncate">${displayName}</h5>
                            <div class="flex flex-col items-end gap-1 shrink-0">
                                <span class="text-[11px] text-[#8696a0]" id="comm_group_time_${communityId}_${groupId}"></span>
                                <span id="sidebar_comm_unread_${groupId}" class="${unreadClass} bg-[#00a884] text-[#111b21] text-[12px] font-bold min-w-[20px] h-5 rounded-full items-center justify-center px-1.5 shadow-sm">${unreadCount}</span>
                            </div>
                        </div>
                        <p class="text-[13px] text-[#8696a0] truncate" id="comm_group_msg_${communityId}_${groupId}">${subtitle}</p>
                    </div>
                </div>
            `;

            if (isMember) {
                window.listenToCommGroupLastMsg(communityId, groupId);
            }
        });
    };

    window.listenToCommGroupLastMsg = function(communityId, groupId) {
        const key = `comm_last_msg_${communityId}_${groupId}`;
        if (window.communityListeners[key]) return;

        const msgsRef = window.query(
            window.ref(window.db, `groups/${groupId}/messages`),
            window.limitToLast(1)
        );

        window.communityListeners[key] = window.onChildAdded(msgsRef, (snapshot) => {
            const data = snapshot.val();
            if (!data) return;

            const msgEl = document.getElementById(`comm_group_msg_${communityId}_${groupId}`);
            if (msgEl) {
                let text = data.text || '';
                if (data.sender_id == window.myUserId) {
                    text = `✓ You: ${text}`;
                } else if (window.allContacts) {
                    const matchUser = window.allContacts.find(c => c.id == data.sender_id);
                    const senderName = matchUser ? (matchUser.name || matchUser.phone) : 'Member';
                    text = `${senderName}: ${text}`;
                }
                msgEl.textContent = text;
            }
            const timeEl = document.getElementById(`comm_group_time_${communityId}_${groupId}`);
            if (timeEl && data.time) {
                const date = new Date(data.time * 1000);
                timeEl.textContent = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            }
        });
    };

    // Initialize listeners for Realtime DB communities updates
    const initCommunitiesListener = setInterval(() => {
        if (window.db && window.onValue && window.myUserId && window.myUserId !== '0') {
            clearInterval(initCommunitiesListener);
            window.onValue(window.ref(window.db, 'communities'), (snapshot) => {
                const listContainer = document.getElementById('communities_list');
                const loadingIndicator = document.getElementById('communities_loading');
                if (loadingIndicator) loadingIndicator.remove();

                listContainer.innerHTML = '';
                const communities = snapshot.val();

                if (!communities) {
                    listContainer.innerHTML = '<div class="p-6 text-center text-[#8696a0] text-sm">No communities found. Click "New community" to create one.</div>';
                    return;
                }

                Object.values(communities).forEach(comm => {
                    if (!comm || !comm.users) return;
                    const uList = Array.isArray(comm.users) ? comm.users : Object.values(comm.users);
                    const hasUser = uList.map(String).includes(String(window.myUserId));
                    if (!hasUser) return;

                    const avatar = comm.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(comm.name)}&background=2a3942&color=fff`;

                    const cId = comm.id;
                    const groupIds = comm.groups ? (Array.isArray(comm.groups) ? comm.groups : Object.values(comm.groups)) : [];
                    
                    let groupsHtml = '';
                    groupIds.forEach(gid => {
                        groupsHtml += `<div id="comm_group_row_${cId}_${gid}"></div>`;
                    });

                    listContainer.insertAdjacentHTML('beforeend', `
                        <div class="flex flex-col border-b border-[#202c33]/50 hover:bg-[#202c33]/10">
                            <!-- Main community banner -->
                            <div class="flex items-center px-4 py-3 cursor-pointer select-none" onclick="window.selectCommunityAnnouncementsChat('${cId}', '${comm.announcement_group_id}')">
                                <img src="${avatar}" class="w-11 h-11 rounded-2xl object-cover shrink-0">
                                <div class="ml-3 flex-1 min-w-0">
                                    <h4 class="text-[16px] text-[#e9edef] font-semibold truncate">${comm.name}</h4>
                                    <p class="text-[12px] text-[#8696a0] truncate">${comm.description || 'WhatsApp Community'}</p>
                                </div>
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0] ml-2 shrink-0"><path d="M8.59 16.59L10 18l6-6-6-6-1.41 1.41L13.17 12z"/></svg>
                            </div>

                            <!-- List of groups under community -->
                            <div class="flex flex-col">
                                ${groupsHtml}
                            </div>
                        </div>
                    `);

                    groupIds.forEach(gid => {
                        window.loadCommunitySidebarGroup(cId, gid, comm.announcement_group_id);
                    });
                });
            });
        }
    }, 500);

    window.listenToAnnouncementMsg = function(announceGroupId) {
        if (window.communityListeners[announceGroupId]) return;

        const msgsRef = window.query(
            window.ref(window.db, `groups/${announceGroupId}/messages`),
            window.limitToLast(1)
        );

        window.communityListeners[announceGroupId] = window.onChildAdded(msgsRef, (snapshot) => {
            const data = snapshot.val();
            if (!data) return;

            const msgEl = document.getElementById(`announce_msg_${announceGroupId}`);
            if (msgEl) {
                msgEl.textContent = data.text || 'Announcement';
            }
            const timeEl = document.getElementById(`announce_time_${announceGroupId}`);
            if (timeEl && data.time) {
                const date = new Date(data.time * 1000);
                timeEl.textContent = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            }
        });
    };

    // ==========================================
    // NEW MANAGE & CREATE GROUPS HANDLERS
    // ==========================================
    window.newGroupDisappearingIndex = 0;
    window.newGroupDisappearingValue = 0;
    window.newGroupVisibilityValue = 'visible';
    window.newGroupSelectedMemberIds = [];

    window.showManageGroupsModal = async function() {
        if (!window.activeCommunityId) return;
        const modal = document.getElementById('community_manage_groups_modal');
        modal.classList.remove('hidden');

        const listContainer = document.getElementById('manage_groups_list_container');
        listContainer.innerHTML = '<span class="text-[#8696a0] text-sm px-3">Loading groups...</span>';

        try {
            const response = await fetch(`/community/${window.activeCommunityId}/info`);
            const res = await response.json();
            if (res.status && res.data) {
                const data = res.data;
                const countSubtitle = document.getElementById('manage_groups_count_subtitle');
                if (countSubtitle) {
                    countSubtitle.textContent = `${data.groups ? data.groups.length : 0} of 100`;
                }

                listContainer.innerHTML = '';
                if (data.groups_details && data.groups_details.length > 0) {
                    data.groups_details.forEach(g => {
                        const isAnnounce = g.is_announcement === true;
                        const isGeneral = g.is_general === true;
                        
                        let removeBtn = '';
                        if (!isAnnounce && !isGeneral) {
                            removeBtn = `
                                <button onclick="window.removeGroupFromCommunity('${g.id}')" 
                                    class="ml-auto p-1.5 hover:bg-[#384b57] text-[#aebac1] hover:text-red-500 rounded-full transition-colors">
                                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                                    </svg>
                                </button>`;
                        }

                        const avatar = g.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(g.name)}&background=2a3942&color=fff`;

                        listContainer.insertAdjacentHTML('beforeend', `
                            <div class="flex items-center gap-3 p-3 border-b border-[#313d45]/40 hover:bg-[#202c33]/30 rounded-xl transition-colors">
                                <div class="w-10 h-10 rounded-full bg-[#2a3942] flex items-center justify-center text-white shrink-0 overflow-hidden border border-[#313d45]">
                                    ${isAnnounce ? `
                                        <div class="w-full h-full bg-[#005c4b]/30 flex items-center justify-center text-[#00a884]">
                                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                                        </div>` : `
                                        <img src="${avatar}" class="w-full h-full object-cover">`}
                                </div>
                                <div class="flex flex-col min-w-0 flex-1">
                                    <span class="text-[#e9edef] text-[15px] font-medium truncate">${g.name}</span>
                                    <span class="text-[12.5px] text-[#8696a0] truncate">${isAnnounce ? 'Announcement group' : (isGeneral ? 'General group' : (g.description || 'No description'))}</span>
                                </div>
                                ${removeBtn}
                            </div>
                        `);
                    });
                } else {
                    listContainer.innerHTML = '<span class="text-[#8696a0] text-sm px-3">No groups in this community.</span>';
                }
            }
        } catch (err) {
            console.error(err);
            listContainer.innerHTML = '<span class="text-red-500 text-sm px-3">Failed to load groups.</span>';
        }
    };

    window.removeGroupFromCommunity = async function(groupId) {
        const action = async () => {
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
                const response = await fetch(`/community/${window.activeCommunityId}/remove-group`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ group_id: groupId })
                });
                const res = await response.json();
                if (res.status) {
                    window.showToast?.('Success', 'Group removed from community');
                    const manageModal = document.getElementById('community_manage_groups_modal');
                    if (manageModal && !manageModal.classList.contains('hidden')) {
                        window.showManageGroupsModal();
                    }
                    window.showCommunityDetails(window.activeCommunityId);
                } else {
                    alert(res.message || 'Failed to remove group');
                }
            } catch (err) {
                console.error(err);
                alert('Error removing group');
            }
        };

        if (window.openDeleteModal) {
            window.openDeleteModal('Are you sure you want to remove this group from the community?', action, null, 'Remove');
        } else if (confirm('Are you sure you want to remove this group from the community?')) {
            action();
        }
    };

    window.showCreateNewGroupModal = function() {
        document.getElementById('community_manage_groups_modal').classList.add('hidden');
        const modal = document.getElementById('community_create_group_modal');
        modal.classList.remove('hidden');

        // Set community name in header
        const commNameEl = document.getElementById('detail_community_name');
        document.getElementById('create_group_community_name').textContent = commNameEl ? commNameEl.textContent : 'Community';

        // Reset inputs
        document.getElementById('create_group_in_community_form').reset();
        document.getElementById('new_group_avatar_preview').src = '';
        document.getElementById('new_group_avatar_preview').classList.add('hidden');
        document.getElementById('new_group_avatar_placeholder').classList.remove('hidden');

        // Reset state
        window.newGroupDisappearingIndex = 0;
        window.newGroupDisappearingValue = 0;
        document.getElementById('new_group_disappearing_label').textContent = 'Off';

        window.newGroupVisibilityValue = 'visible';
        document.getElementById('new_group_visibility_label').textContent = 'Visible';

        window.newGroupSelectedMemberIds = [];
        document.getElementById('new_group_members_count').textContent = 'None';
        document.getElementById('new_group_selected_members_list').innerHTML = '';
        
        // Reset permissions switches
        document.getElementById('perm_edit_settings').checked = true;
        document.getElementById('perm_send_messages').checked = true;
        document.getElementById('perm_add_members').checked = true;
        document.getElementById('perm_approve_members').checked = false;
    };

    window.previewNewGroupAvatar = function(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('new_group_avatar_preview').src = e.target.result;
                document.getElementById('new_group_avatar_preview').classList.remove('hidden');
                document.getElementById('new_group_avatar_placeholder').classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    };

    window.toggleNewGroupDisappearingMessages = function() {
        const durations = [
            { value: 0, label: "Off" },
            { value: 86400, label: "24 Hours" },
            { value: 604800, label: "7 Days" },
            { value: 7776000, label: "90 Days" }
        ];
        window.newGroupDisappearingIndex = (window.newGroupDisappearingIndex || 0) + 1;
        if (window.newGroupDisappearingIndex >= durations.length) {
            window.newGroupDisappearingIndex = 0;
        }
        const dur = durations[window.newGroupDisappearingIndex];
        document.getElementById('new_group_disappearing_label').textContent = dur.label;
        window.newGroupDisappearingValue = dur.value;
    };

    window.showGroupVisibilityModal = function() {
        document.getElementById('group_visibility_modal').classList.remove('hidden');
        
        // Select matching radio
        const radios = document.getElementsByName('group_visibility_option');
        radios.forEach(r => {
            if (r.value === window.newGroupVisibilityValue) {
                r.checked = true;
            }
        });
    };

    window.saveGroupVisibility = function() {
        const radios = document.getElementsByName('group_visibility_option');
        let selectedValue = 'visible';
        radios.forEach(r => {
            if (r.checked) selectedValue = r.value;
        });

        window.newGroupVisibilityValue = selectedValue;
        document.getElementById('new_group_visibility_label').textContent = selectedValue.charAt(0).toUpperCase() + selectedValue.slice(1);
        document.getElementById('group_visibility_modal').classList.add('hidden');
    };

    window.showGroupPermissionsModal = function() {
        document.getElementById('group_permissions_modal').classList.remove('hidden');
    };

    window.showNewGroupAddMembersModal = function() {
        document.getElementById('new_group_add_members_modal').classList.remove('hidden');
        const listContainer = document.getElementById('new_group_contacts_list');
        listContainer.innerHTML = '';

        // Gather all user contacts from sidebar
        const contactNodes = document.getElementById('user_list_container').querySelectorAll('[id^="user_sidebar_"]');
        if (contactNodes.length === 0) {
            listContainer.innerHTML = '<span class="text-[#8696a0] text-sm px-3">No contacts found to add.</span>';
            return;
        }

        contactNodes.forEach(node => {
            const uid = node.getAttribute('data-userid');
            if (uid === 'meta_ai') return;

            const name = node.getAttribute('data-name');
            const avatar = node.getAttribute('data-avatar');
            const isChecked = window.newGroupSelectedMemberIds.includes(String(uid)) ? 'checked' : '';

            listContainer.insertAdjacentHTML('beforeend', `
                <label class="flex items-center gap-3 p-3 bg-[#202c33]/40 border border-[#313d45]/50 hover:bg-[#202c33]/80 rounded-xl cursor-pointer">
                    <input type="checkbox" name="new_group_member_check" value="${uid}" ${isChecked} class="rounded border-[#313d45] text-[#00a884] focus:ring-0">
                    <img src="${avatar}" class="w-10 h-10 rounded-full object-cover">
                    <span class="text-[#e9edef] text-[15px] font-medium">${name}</span>
                </label>
            `);
        });
    };

    window.confirmNewGroupMembers = function() {
        const checkedBoxes = Array.from(document.querySelectorAll('input[name="new_group_member_check"]:checked'));
        window.newGroupSelectedMemberIds = checkedBoxes.map(cb => String(cb.value));

        const count = window.newGroupSelectedMemberIds.length;
        document.getElementById('new_group_members_count').textContent = count > 0 ? `${count} selected` : 'None';

        // Render mini chips of selected members
        const container = document.getElementById('new_group_selected_members_list');
        container.innerHTML = '';
        
        checkedBoxes.forEach(cb => {
            const name = cb.nextElementSibling.nextElementSibling.textContent;
            container.insertAdjacentHTML('beforeend', `
                <span class="flex items-center gap-1 bg-[#00a884]/20 text-[#00a884] px-3 py-1 rounded-full text-xs font-medium">
                    ${name}
                    <button type="button" onclick="window.removeSelectedNewGroupMember('${cb.value}')" class="hover:text-red-500 font-bold ml-1">×</button>
                </span>
            `);
        });

        document.getElementById('new_group_add_members_modal').classList.add('hidden');
    };

    window.removeSelectedNewGroupMember = function(uid) {
        window.newGroupSelectedMemberIds = window.newGroupSelectedMemberIds.filter(id => id !== String(uid));
        
        // Re-confirm members to update UI
        const count = window.newGroupSelectedMemberIds.length;
        document.getElementById('new_group_members_count').textContent = count > 0 ? `${count} selected` : 'None';

        const container = document.getElementById('new_group_selected_members_list');
        const chip = container.querySelector(`[onclick*="'${uid}'"]`)?.parentElement;
        if (chip) chip.remove();
    };

    window.submitCreateGroupInCommunity = async function(event) {
        event.preventDefault();
        if (!window.activeCommunityId) return;

        const formData = new FormData();
        formData.append('name', document.getElementById('new_group_name_input').value);
        formData.append('description', document.getElementById('new_group_desc_input').value);
        
        // Disappearing messages configuration
        formData.append('disappearingTimer', window.newGroupDisappearingValue);

        // Group visibility settings
        formData.append('visibility', window.newGroupVisibilityValue);

        // Permissions settings
        formData.append('perm_edit_settings', document.getElementById('perm_edit_settings').checked ? 1 : 0);
        formData.append('perm_send_messages', document.getElementById('perm_send_messages').checked ? 1 : 0);
        formData.append('perm_add_members', document.getElementById('perm_add_members').checked ? 1 : 0);
        formData.append('perm_approve_members', document.getElementById('perm_approve_members').checked ? 1 : 0);

        // Members list
        if (window.newGroupSelectedMemberIds && window.newGroupSelectedMemberIds.length > 0) {
            window.newGroupSelectedMemberIds.forEach(id => {
                formData.append('users[]', id);
            });
        }

        const avatarInput = document.getElementById('new_group_avatar_input');
        if (avatarInput.files && avatarInput.files[0]) {
            formData.append('avatar', avatarInput.files[0]);
        }

        try {
            window.showToast?.('Creating Group', 'Please wait...');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            const response = await fetch(`/community/${window.activeCommunityId}/create-group`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: formData
            });
            const res = await response.json();
            if (res.status) {
                window.showToast?.('Success', 'Group created successfully!');
                document.getElementById('community_create_group_modal').classList.add('hidden');
                
                // Show community details which updates group count and groups list
                window.showCommunityDetails(window.activeCommunityId);
            } else {
                alert(res.message || 'Failed to create group');
            }
        } catch (err) {
            console.error(err);
            alert('Error creating group');
        }
    };

    window.showAddExistingGroupsModal = function() {
        document.getElementById('community_manage_groups_modal').classList.add('hidden');
        window.showAddGroupsModal();
    };

    document.addEventListener('click', function(e) {
        document.querySelectorAll('.member-context-menu').forEach(menu => {
            if (!menu.classList.contains('hidden') && !menu.contains(e.target) && !menu.previousElementSibling.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    });

    window.openGroupJoinPreviewModal = async function(groupId, communityId) {
        const modal = document.getElementById('community_group_join_preview_modal');
        if (!modal) return;

        // Reset fields to loading state
        document.getElementById('join_preview_name').textContent = 'Loading...';
        document.getElementById('join_preview_created_info').textContent = '';
        document.getElementById('join_preview_members_count').textContent = 'Loading members...';
        document.getElementById('join_preview_avatars_list').innerHTML = '';
        document.getElementById('join_preview_description').textContent = '';
        document.getElementById('join_preview_avatar').src = 'https://ui-avatars.com/api/?name=Loading&background=2a3942&color=fff';

        const actionBtn = document.getElementById('join_preview_action_btn');
        actionBtn.disabled = true;
        actionBtn.textContent = 'Please wait...';
        actionBtn.className = "w-full py-3 bg-[#313d45] text-[#8696a0] font-semibold rounded-full cursor-default text-sm";

        modal.classList.remove('hidden');

        try {
            // Fetch group details
            const gSnap = await window.get(window.ref(window.db, `groups/${groupId}`));
            const g = gSnap.val();
            if (!g) {
                document.getElementById('join_preview_name').textContent = 'Group not found';
                return;
            }

            // Fetch community details to check pending requests
            const commResponse = await fetch(`/community/${communityId}/info`);
            const commRes = await commResponse.json();
            const community = commRes.status ? commRes.data : null;

            // Set Avatar
            const displayName = g.name;
            const avatarUrl = g.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(displayName)}&background=2a3942&color=fff`;
            document.getElementById('join_preview_avatar').src = avatarUrl;

            // Set Title & Desc
            document.getElementById('join_preview_name').textContent = displayName;
            document.getElementById('join_preview_description').textContent = g.description || 'A group where community members can talk about anything...';

            // Set Created By Info
            const creatorId = g.createdBy || g.created_by;
            let creatorName = "Someone";
            if (creatorId == window.myUserId) {
                creatorName = "You";
            } else if (window.allContacts && creatorId) {
                const creator = window.allContacts.find(c => String(c.id) === String(creatorId));
                creatorName = creator ? (creator.name || creator.phone) : creatorId;
            }
            let dateStr = "";
            const timestamp = g.createdAt || g.created_at || g.time;
            if (timestamp) {
                const date = new Date(timestamp * 1000);
                const day = date.getDate().toString().padStart(2, '0');
                const month = (date.getMonth() + 1).toString().padStart(2, '0');
                const year = date.getFullYear();
                dateStr = `, ${month}/${day}/${year % 100}`;
            }
            document.getElementById('join_preview_created_info').textContent = `Created by ${creatorName}${dateStr}`;

            // Set Members count & mini avatars preview
            const users = g.users ? (Array.isArray(g.users) ? g.users : Object.values(g.users)) : [];
            document.getElementById('join_preview_members_count').textContent = `${users.length} member${users.length !== 1 ? 's' : ''}`;

            const avatarsListEl = document.getElementById('join_preview_avatars_list');
            avatarsListEl.innerHTML = '';
            
            // Loop up to 3 users
            const previewUsers = users.slice(0, 3);
            for (const uid of previewUsers) {
                let avatar = '';
                if (uid == window.myUserId) {
                    avatar = window.authUserAvatarUrl || '';
                } else if (window.allContacts) {
                    const matchUser = window.allContacts.find(c => String(c.id) === String(uid));
                    avatar = matchUser ? matchUser.avatar : '';
                }
                const avatarSrc = avatar || `https://ui-avatars.com/api/?name=User&background=2a3942&color=fff`;
                avatarsListEl.insertAdjacentHTML('beforeend', `
                    <img src="${avatarSrc}" class="w-7 h-7 rounded-full object-cover border border-[#222e35] bg-[#2a3942]">
                `);
            }
            if (users.length > 3) {
                avatarsListEl.insertAdjacentHTML('beforeend', `
                    <div class="w-7 h-7 rounded-full border border-[#222e35] bg-[#313d45] flex items-center justify-center text-[10px] text-[#e9edef] font-semibold">
                        +${users.length - 3}
                    </div>
                `);
            }

            // Check button action
            let isPending = false;
            if (community && community.join_requests) {
                const reqList = Object.values(community.join_requests);
                isPending = reqList.some(r => String(r.group_id) === String(groupId) && String(r.user_id) === String(window.myUserId) && r.status === 'pending');
            }

            if (isPending) {
                actionBtn.disabled = true;
                actionBtn.textContent = 'Requested';
                actionBtn.className = "w-full py-3 bg-[#202c33] text-[#8696a0] font-semibold rounded-full cursor-default text-sm border border-[#313d45]/50";
            } else {
                actionBtn.disabled = false;
                actionBtn.textContent = 'Join group';
                actionBtn.className = "w-full py-3 bg-[#00a884] hover:bg-[#008f72] text-[#111b21] font-semibold rounded-full transition-all shadow-md text-sm";
                actionBtn.onclick = function() {
                    window.joinCommunityGroupFromPreview(groupId, communityId);
                };
            }

        } catch (err) {
            console.error(err);
            document.getElementById('join_preview_name').textContent = 'Error loading group';
        }
    };

    window.joinCommunityGroupFromPreview = async function(groupId, communityId) {
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            const response = await fetch(`/community/${communityId}/groups/${groupId}/join-request`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });
            const res = await response.json();
            if (res.status) {
                window.showToast?.('Request Sent', 'Join request sent to community admins.');
                document.getElementById('community_group_join_preview_modal').classList.add('hidden');
                // Refresh community details page
                window.showCommunityDetails(communityId);
            } else {
                alert(res.message);
            }
        } catch (err) {
            console.error(err);
        }
    };
</script>

<!-- COMMUNITY GROUP JOIN PREVIEW MODAL -->
<div id="community_group_join_preview_modal"
    class="hidden fixed inset-0 bg-black/60 z-[320] flex items-center justify-center p-4">
    <div
        class="bg-[#222e35] w-full max-w-[420px] rounded-2xl shadow-2xl border border-[#313d45] flex flex-col p-6 gap-6 relative">
        <!-- Close Button -->
        <button onclick="document.getElementById('community_group_join_preview_modal').classList.add('hidden')"
            class="absolute top-4 right-4 text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
            </svg>
        </button>

        <!-- Center content: Avatar, Name, Metadata -->
        <div class="flex flex-col items-center gap-4 text-center mt-2">
            <!-- Group Avatar -->
            <div class="w-20 h-20 rounded-full bg-[#2a3942] overflow-hidden border border-[#313d45] shadow-md">
                <img id="join_preview_avatar" class="w-full h-full object-cover">
            </div>

            <!-- Group Name -->
            <h3 id="join_preview_name" class="text-xl text-[#e9edef] font-semibold truncate w-full px-2">Group Name</h3>
            
            <!-- Created By info -->
            <span id="join_preview_created_info" class="text-[13px] text-[#8696a0]">Created by Admin, 11/15/23</span>
        </div>

        <!-- Group Members Preview Section -->
        <div class="flex flex-col items-center gap-1.5 py-1 border-y border-[#313d45]/40 w-full">
            <div class="flex items-center justify-center -space-x-2 overflow-hidden" id="join_preview_avatars_list">
                <!-- Up to 3 member avatars -->
            </div>
            <span id="join_preview_members_count" class="text-[13.5px] text-[#8696a0]">0 members</span>
        </div>

        <!-- Description -->
        <div class="w-full text-center">
            <p id="join_preview_description" class="text-[#e9edef] text-[14px] leading-relaxed max-h-[100px] overflow-y-auto custom-scrollbar px-2">
                Group description goes here...
            </p>
        </div>

        <!-- Action Button -->
        <div class="w-full">
            <button id="join_preview_action_btn" class="w-full py-3 bg-[#00a884] hover:bg-[#008f72] text-[#111b21] font-semibold rounded-full transition-all shadow-md text-sm">
                Join group
            </button>
        </div>
    </div>
</div>
