<!-- Channels Main Column -->
<div id="channels_main_column" class="hidden flex-col flex-1 h-full relative transition-all duration-300 min-w-0 bg-[#0b141a]">
    
    <!-- Empty State for Channels -->
    <div id="channel_empty_state" class="flex-1 flex flex-col items-center justify-center text-center px-4 z-20">
        <div class="mb-6 relative">
            <div class="flex items-center justify-center">
                <!-- Channel speech bubble icon -->
                <svg viewBox="0 0 24 24" class="w-[84px] h-[84px] text-[#42525c]" fill="currentColor">
                    <path d="M12 2C6.477 2 2 6.477 2 12c0 1.764.457 3.42 1.258 4.869L2 22l5.35-1.196A9.957 9.957 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 14.5a4.5 4.5 0 110-9 4.5 4.5 0 010 9zm0-6a1.5 1.5 0 100 3 1.5 1.5 0 000-3z"/>
                </svg>
            </div>
        </div>
        <h2 class="text-[#e9edef] text-[32px] font-normal mb-4">Discover channels</h2>
        <p class="text-[#8696a0] text-[15px] font-normal leading-relaxed max-w-md mx-auto mb-8">
            Entertainment, sports, news, lifestyle, people and more. Follow the channels that interest you
        </p>
    </div>

    <!-- Active Channel View -->
    <div id="active_channel_view" class="hidden flex-row flex-1 h-full w-full overflow-hidden">
        <!-- Main Chat Column -->
        <div id="channel_chat_main_column" class="flex-1 flex flex-col relative h-full min-w-0">
        <!-- Channel Header -->
        <div class="h-[60px] px-4 py-2 bg-[#202c33] border-b border-[#313d45] flex items-center justify-between shrink-0 z-20 cursor-pointer" onclick="window.toggleChannelInfo()">
            <div class="flex items-center gap-4 flex-1 min-w-0">
                <div class="w-10 h-10 rounded-full overflow-hidden shrink-0 border border-transparent shadow-sm bg-[#2a3942]">
                    <img id="current_channel_avatar" src="" class="w-full h-full object-cover">
                </div>
                <div class="flex flex-col flex-1 min-w-0 justify-center">
                    <div class="flex items-center gap-2">
                        <span id="current_channel_name" class="text-[#e9edef] text-[16px] font-normal truncate"></span>
                        <svg class="w-4 h-4 text-[#00a884] shrink-0" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm-1.9 14.7L6 12.6l1.5-1.5 2.6 2.6 6.4-6.4 1.5 1.5-7.9 7.9z"/>
                        </svg>
                    </div>
                    <span id="current_channel_followers" class="text-[#8696a0] text-[13px] truncate"></span>
                </div>
            </div>
            
            <div class="flex items-center gap-3 shrink-0 ml-4">
                <button id="btn_mute_channel" onclick="event.stopPropagation(); window.toggleMuteChannel()" class="hidden text-[#8696a0] hover:text-[#e9edef] p-2 rounded-full focus:outline-none transition-colors" title="Mute channel">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path d="M11.332 3.659L7.388 7H4c-.552 0-1 .448-1 1v8c0 .552.448 1 1 1h3.388l3.944 3.341c.218.185.535.18.746-.011.206-.188.293-.473.222-.741v-15.16c.071-.268-.016-.553-.222-.741-.211-.191-.528-.196-.746-.011zm5.183 2.946l-1.414 1.414 2.829 2.829-2.829 2.828 1.414 1.415 2.828-2.829 2.829 2.829 1.414-1.415-2.829-2.828 2.829-2.829-1.414-1.414-2.829 2.829-2.828-2.829z"/>
                    </svg>
                </button>
                <button onclick="event.stopPropagation(); window.openChannelShareModal()" class="text-[#8696a0] hover:text-[#e9edef] p-2 rounded-full focus:outline-none transition-colors" title="Share channel link">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path d="M11.646 17.066l2.121 2.122-2.121 2.121a5.975 5.975 0 0 1-4.243 1.758 5.975 5.975 0 0 1-4.242-1.758A5.972 5.972 0 0 1 1.403 17a5.97 5.97 0 0 1 1.758-4.242l2.121-2.122 2.122 2.122-2.122 2.121c-1.168 1.168-1.168 3.074 0 4.243 1.169 1.168 3.075 1.168 4.243 0l2.121-2.121-2.122-2.121 2.122-2.122zM20.84 2.736A5.975 5.975 0 0 0 16.598 1a5.975 5.975 0 0 0-4.242 1.758l-2.122 2.121 2.122 2.122 2.121-2.121c1.169-1.168 3.075-1.168 4.243 0 1.168 1.168 1.168 3.074 0 4.242l-2.121 2.122 2.121 2.121 2.121-2.121A5.972 5.972 0 0 0 22.597 7a5.97 5.97 0 0 0-1.757-4.264zM7.05 14.828l7.778-7.778 2.122 2.122-7.778 7.778-2.122-2.122z"></path>
                    </svg>
                </button>
                <div class="relative" onclick="event.stopPropagation();">
                    <button onclick="toggleChannelMenu()" class="text-[#8696a0] hover:text-[#e9edef] p-2 rounded-full focus:outline-none transition-colors">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                            <path d="M12 7a2 2 0 1 0-.001-4.001A2 2 0 0 0 12 7zm0 2a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 9zm0 6a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 15z"></path>
                        </svg>
                    </button>
                    <!-- Dropdown Menu -->
                    <div id="channel_dropdown_menu" class="hidden absolute right-0 top-12 bg-[#233138] rounded-md shadow-2xl py-2 w-48 z-[100] border border-[#313d45]">
                        <button onclick="window.toggleChannelInfo()" class="w-full text-left px-4 py-2 text-[#e9edef] hover:bg-[#182229] transition-colors text-sm">Channel info</button>
                        <button id="channel_menu_unfollow" onclick="window.toggleFollowChannel()" class="hidden w-full text-left px-4 py-2 text-[#e9edef] hover:bg-[#182229] transition-colors text-sm">Unfollow</button>
                        <button id="channel_menu_delete" onclick="window.deleteChannel()" class="hidden w-full text-left px-4 py-2 text-[#ea005e] hover:bg-[#182229] transition-colors text-sm">Delete channel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Background -->
        <div class="absolute inset-0 z-0 chat-bg opacity-40"></div>

        <!-- Messages Area -->
        <div id="channel_messages_area" class="flex-1 overflow-y-auto p-4 md:p-8 relative z-10 custom-scrollbar flex flex-col">
            <!-- Privacy Notice (Always at top) -->
            <div class="flex justify-center w-full mt-2 mb-4 px-4">
                <div class="bg-[#202c33] text-[#ffd279] text-[13.5px] px-4 py-2 rounded-lg shadow-sm text-center max-w-xl mx-auto flex items-start gap-2 border border-[#313d45]">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15v-2h2v2h-2zm0-4V7h2v6h-2z"/></svg>
                    <span class="text-left">This channel is public and visible to anyone, including WhatsApp. There is added privacy for your profile and phone number. <a href="#" class="text-[#53bdeb] hover:underline">Click to learn more.</a></span>
                </div>
            </div>

            <!-- Admin Empty State Banner -->
            <div id="admin_empty_state_banner" class="hidden mt-2 mb-4 mx-auto w-full max-w-xl bg-[#202c33] rounded-[20px] p-8 shadow-md border border-[#313d45] flex-col items-center text-center relative z-20">
                <div class="w-[72px] h-[72px] rounded-full bg-[#111b21] flex items-center justify-center mb-6 relative">
                    <svg viewBox="0 0 24 24" width="36" height="36" fill="#00a884">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                    </svg>
                    <div class="absolute -bottom-1 -right-1 bg-[#00a884] rounded-full p-1.5 border-[3px] border-[#202c33]">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="white">
                            <path d="M12 4v16M4 12h16" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
                <h3 id="admin_empty_state_title" class="text-[#e9edef] text-[20px] font-medium mb-3">Start growing 'Channel Name'</h3>
                <p class="text-[#8696a0] text-[15px] mb-8 px-4 leading-relaxed">Get started by adding an icon, description, and your first update. Invite people by sharing your link.</p>
                <div class="flex gap-4 w-full">
                    <button onclick="window.editChannelDescription()" class="flex-1 py-2.5 rounded-full border border-[#313d45] text-[#00a884] font-medium hover:bg-[#2a3942] transition-colors text-[15px]">Add description</button>
                    <button onclick="window.openChannelShareModal()" class="flex-1 py-2.5 rounded-full border border-[#313d45] text-[#00a884] font-medium hover:bg-[#2a3942] transition-colors text-[15px]">Share channel link</button>
                </div>
            </div>

            <!-- Pending Admin Accept Banner -->
            <div id="pending_admin_accept_banner" class="hidden mt-2 mb-4 mx-auto w-full max-w-xl bg-[#202c33] rounded-[20px] p-6 shadow-md border border-[#313d45] flex-col items-center text-center relative z-20">
                <div class="w-14 h-14 rounded-full bg-[#111b21] flex items-center justify-center mb-4 text-[#00a884]">
                    <svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                    </svg>
                </div>
                <h3 class="text-[#e9edef] text-[18px] font-medium mb-2">You're invited to be an admin</h3>
                <p class="text-[#8696a0] text-[14px] mb-6 px-2 leading-relaxed">Admins can edit channel info, send updates, and manage other admins.</p>
                <div class="flex gap-4 w-full">
                    <button onclick="window.acceptAdminInvite()" class="flex-1 py-2.5 rounded-full bg-[#00a884] text-[#111b21] font-medium hover:bg-[#00c298] transition-colors text-[15px]">Accept invite</button>
                </div>
            </div>

            <!-- Messages go here -->
            <div id="channel_messages_list" class="flex flex-col space-y-2 w-full mb-4"></div>
        </div>

        <!-- Input Area (Only visible to Admins) -->
        <div id="channel_input_area" class="hidden px-4 py-3 bg-[#202c33] border-t border-[#313d45] shrink-0 z-20 flex items-end gap-2 relative">
            <div class="relative shrink-0">
                <button type="button" id="channel_attach_toggle_btn" onclick="toggleChannelAttachMenu()" class="text-[#8696a0] hover:text-[#e9edef] p-2 rounded-full transition-colors focus:outline-none">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path d="M1.816 15.556v.002c0 1.502.584 2.912 1.646 3.972s2.472 1.647 3.974 1.647a5.58 5.58 0 0 0 3.972-1.645l9.547-9.548c.769-.768 1.147-1.767 1.058-2.817-.079-.968-.548-1.927-1.319-2.698-1.594-1.592-4.068-1.711-5.517-.262l-7.916 7.915c-.881.881-.792 2.25.214 3.261.959.958 2.423 1.053 3.263.215l5.511-5.512c.28-.28.267-.722.053-.936l-.244-.244c-.191-.191-.567-.349-.957.04l-5.506 5.506c-.18.18-.635.127-.976-.214-.098-.097-.576-.613-.213-.973l7.915-7.917c.818-.817 2.267-.699 3.23.262.5.501.802 1.1.849 1.685.051.573-.156 1.111-.589 1.543l-9.547 9.549a3.97 3.97 0 0 1-2.829 1.171 3.975 3.975 0 0 1-2.83-1.173 3.973 3.973 0 0 1-1.172-2.828c0-1.071.415-2.076 1.172-2.83l7.209-7.211c.157-.157.264-.579.028-.814L11.5 4.36a.57.57 0 0 0-.834.018l-7.205 7.207a5.577 5.577 0 0 0-1.645 3.971z"></path>
                    </svg>
                </button>

                <!-- Attachment Menu -->
                <div id="channel_attach_menu" class="hidden absolute bottom-full mb-3 left-0 bg-[#1f2c34] p-4 rounded-3xl w-[320px] shadow-2xl z-50 transition-all origin-bottom-left">
                    <div class="grid grid-cols-4 gap-y-6 gap-x-2 place-items-center">
                        <!-- Document -->
                        <div class="flex flex-col items-center gap-1 group cursor-pointer" onclick="selectChannelFile('.pdf,.doc,.docx,.xls,.xlsx,.txt,.zip')">
                            <div class="w-14 h-14 rounded-2xl bg-[#5f66cd] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                            </div>
                            <span class="text-gray-300 text-xs">Document</span>
                        </div>
                        <!-- Camera -->
                        <div class="flex flex-col items-center gap-1 group cursor-pointer" onclick="selectChannelFile('image/*;capture=camera')">
                            <div class="w-14 h-14 rounded-2xl bg-[#ed517b] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <span class="text-gray-300 text-xs">Camera</span>
                        </div>
                        <!-- Gallery -->
                        <div class="flex flex-col items-center gap-1 group cursor-pointer" onclick="selectChannelFile('image/*,video/*')">
                            <div class="w-14 h-14 rounded-2xl bg-[#bf59cf] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path></svg>
                            </div>
                            <span class="text-gray-300 text-xs">Gallery</span>
                        </div>
                        <!-- Audio -->
                        <div class="flex flex-col items-center gap-1 group cursor-pointer" onclick="selectChannelFile('audio/*')">
                            <div class="w-14 h-14 rounded-2xl bg-[#e35920] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z" clip-rule="evenodd"></path></svg>
                            </div>
                            <span class="text-gray-300 text-xs">Audio</span>
                        </div>
                        <!-- Location -->
                        <div class="flex flex-col items-center gap-1 group cursor-pointer" onclick="alert('Location sharing coming soon!')">
                            <div class="w-14 h-14 rounded-2xl bg-[#1dae75] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                            </div>
                            <span class="text-gray-300 text-xs">Location</span>
                        </div>
                        <!-- Contact -->
                        <div class="flex flex-col items-center gap-1 group cursor-pointer" onclick="alert('Contact sharing coming soon!')">
                            <div class="w-14 h-14 rounded-2xl bg-[#09a5eb] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                            </div>
                            <span class="text-gray-300 text-xs">Contact</span>
                        </div>
                        <!-- Poll -->
                        <div class="flex flex-col items-center gap-1 group cursor-pointer" onclick="alert('Polls coming soon!')">
                            <div class="w-14 h-14 rounded-2xl bg-[#11a9a1] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </div>
                            <span class="text-gray-300 text-xs">Poll</span>
                        </div>
                    </div>
                </div>
            </div>
            <input type="file" id="channel_attachment_input" class="hidden" onchange="window.handleChannelAttachment(this)">
            
            <div class="flex-1 bg-[#2a3942] rounded-lg relative flex items-end min-h-[44px]">
                <textarea id="channel_message_input" rows="1" placeholder="Type an update" class="w-full bg-transparent border-none text-[#e9edef] px-4 py-3 max-h-[100px] focus:ring-0 resize-none custom-scrollbar text-[15px]" oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px';"></textarea>
            </div>
            
            <button onclick="window.sendChannelMessage()" class="w-11 h-11 rounded-full bg-[#00a884] flex items-center justify-center text-[#111b21] shrink-0 hover:bg-[#008f72] transition-colors shadow-sm">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M1.101 21.757L23.8 12.028 1.101 2.3l.011 7.912 13.623 1.816-13.623 1.817-.011 7.912z"></path>
                </svg>
            </button>
        </div>
        
        <!-- Follow/Unfollow Banner (For non-admins) -->
        <div id="channel_follower_banner" class="hidden flex-col items-center justify-center px-4 py-4 bg-[#f0f2f5] dark:bg-[#0b141a] border-t border-[#d1d7db] dark:border-[#313d45] shrink-0 z-20 text-center w-full">
            <button onclick="window.toggleFollowChannel()" class="w-[90%] max-w-[500px] bg-[#008069] dark:bg-[#00a884] hover:bg-[#017561] dark:hover:bg-[#008f72] text-white dark:text-[#111b21] py-3 rounded-full font-medium text-[15px] transition-colors mb-3 focus:outline-none">
                Follow channel
            </button>
            <p class="text-[#54656f] dark:text-[#8696a0] text-[13px]">
                This channel has added privacy for your profile and phone number. <a href="#" class="text-[#027eb5] dark:text-[#53bdeb] font-medium hover:underline">Learn more</a>
            </p>
        </div>
        </div>
    
        <!-- Channel Search Drawer (Hidden by default) -->
    <div id="channel_search_drawer" class="hidden w-[360px] h-full bg-[#111b21] border-l border-[#313d45] flex-col shrink-0">
        <!-- Search Header -->
        <div class="h-16 bg-[#202c33] px-4 flex items-center justify-between shrink-0 border-b border-[#313d45]">
            <div class="flex items-center gap-3 min-w-0">
                <button onclick="window.toggleChannelSearchDrawer()" class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <span class="text-[#e9edef] font-medium text-[16px]">Search Messages</span>
            </div>
        </div>

        <!-- Search Input Field -->
        <div class="p-3 bg-[#111b21] border-b border-[#313d45]">
            <div class="bg-[#202c33] flex items-center gap-2 px-3 py-2 rounded-lg border border-transparent focus-within:border-[#00a884]">
                <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" id="channel_search_input" oninput="window.performChannelSearch()" placeholder="Search messages..." class="w-full bg-transparent border-none text-[#e9edef] text-sm focus:ring-0 placeholder-gray-500">
            </div>
        </div>

        <!-- Search Results List -->
        <div id="channel_search_results" class="flex-1 overflow-y-auto p-3 space-y-2 select-none">
            <div class="text-[#8696a0] text-center text-sm py-4">Type to search messages in channel</div>
        </div>
    </div>
    
    @include('chat.channels.channel_info')
    </div>
</div>

<script>
    function toggleChannelAttachMenu() {
        document.getElementById('channel_attach_menu').classList.toggle('hidden');
    }

    function selectChannelFile(accepts) {
        let fileInput = document.getElementById('channel_attachment_input');
        
        // Handle capture parameter if present
        if (accepts.includes('capture=')) {
            const parts = accepts.split(';');
            fileInput.setAttribute('accept', parts[0]);
            fileInput.setAttribute('capture', parts[1].split('=')[1]);
        } else {
            fileInput.setAttribute('accept', accepts);
            fileInput.removeAttribute('capture');
        }
        
        fileInput.click();
        toggleChannelAttachMenu();
    }

    function toggleChannelMenu() {
        const menu = document.getElementById('channel_dropdown_menu');
        menu.classList.toggle('hidden');
    }

    document.addEventListener('click', function(e) {
        const menu = document.getElementById('channel_dropdown_menu');
        if (menu && !menu.classList.contains('hidden') && !e.target.closest('#channel_dropdown_menu') && !e.target.closest('button[onclick="toggleChannelMenu()"]')) {
            menu.classList.add('hidden');
        }

        const attachMenu = document.getElementById('channel_attach_menu');
        if (attachMenu && !attachMenu.classList.contains('hidden') && !e.target.closest('#channel_attach_menu') && !e.target.closest('#channel_attach_toggle_btn')) {
            attachMenu.classList.add('hidden');
        }
    });
</script>
