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
                <button class="sm:hidden text-[#8696a0] hover:text-[#e9edef] transition-colors mr-1" onclick="event.stopPropagation(); window.backToChannelSidebar()">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                    </svg>
                </button>
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
                    <div id="channel_dropdown_menu" class="hidden absolute right-0 top-12 bg-[#233138] rounded-md shadow-xl py-2 w-[220px] z-[100]">
                        <button onclick="window.toggleChannelInfo()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-[14.5px]">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#aebac1] shrink-0">
                                <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                            </svg>
                            <span>Channel info</span>
                        </button>
                        
                        <button onclick="window.toggleChannelSettings()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-[14.5px]">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#aebac1] shrink-0">
                                <path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.06-.94l2.03-1.58a.49.49 0 00.12-.61l-1.92-3.32a.488.488 0 00-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54a.484.484 0 00-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22l-1.92 3.32c-.12.21-.07.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.06.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .43-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.03-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/>
                            </svg>
                            <span>Channel settings</span>
                        </button>
                        
                        <button onclick="window.toggleChannelSelectionMode()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-[14.5px]">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#aebac1] shrink-0">
                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-8.29 13.29a.996.996 0 01-1.41 0L5.71 12.7a.996.996 0 111.41-1.41L10 14.17l6.88-6.88a.996.996 0 111.41 1.41l-7.58 7.59z"/>
                            </svg>
                            <span>Select updates</span>
                        </button>
                        
                        <button onclick="window.closeActiveChannel()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-[14.5px]">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#aebac1] shrink-0">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                            </svg>
                            <span>Close channel</span>
                        </button>

                        <button id="channel_menu_unfollow" onclick="window.toggleFollowChannel()" class="hidden w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-[14.5px]">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#aebac1] shrink-0">
                                <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            <span>Unfollow</span>
                        </button>
                        
                        <button id="channel_menu_delete" onclick="window.deleteChannel()" class="hidden w-full flex items-center gap-4 px-5 py-2.5 text-[#ea005e] hover:bg-[#182229] transition-colors text-[14.5px]">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="shrink-0">
                                <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                            </svg>
                            <span>Delete channel</span>
                        </button>

                        <div class="border-t border-[#313d45] my-2"></div>

                        <button onclick="window.reportChannel()" class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors text-[14.5px]">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#aebac1] shrink-0">
                                <path d="M15 3H6c-.83 0-1.54.5-1.84 1.22l-3.02 7.05c-.09.23-.14.47-.14.73v2c0 1.1.9 2 2 2h6.31l-.95 4.57-.03.32c0 .41.17.79.44 1.06L9.83 23l6.59-6.59c.36-.36.58-.86.58-1.41V5c0-1.1-.9-2-2-2zm4 0v12h4V3h-4z"/>
                            </svg>
                            <span>Report</span>
                        </button>
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
            <div class="relative shrink-0 flex items-center gap-1">
                <!-- Emoji Toggle Button -->
                <button type="button" id="channel_emoji_toggle_btn" onclick="toggleChannelEmojiPicker()" class="text-[#8696a0] hover:text-[#e9edef] p-2 rounded-full transition-colors focus:outline-none">
                    <svg viewBox="0 0 24 24" width="26" height="26" fill="currentColor">
                        <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm2.5-9.5c.828 0 1.5-.672 1.5-1.5s-.672-1.5-1.5-1.5-1.5.672-1.5 1.5.672 1.5 1.5 1.5zm-5 0c.828 0 1.5-.672 1.5-1.5S8.828 8 8 8s-1.5.672-1.5 1.5.672 1.5 1.5 1.5zm2.5 6c2.511 0 4.67-1.516 5.568-3.693h-11.136c.898 2.177 3.057 3.693 5.568 3.693z"></path>
                    </svg>
                </button>
                
                <button type="button" id="channel_attach_toggle_btn" onclick="toggleChannelAttachMenu()" class="text-[#8696a0] hover:text-[#e9edef] p-2 rounded-full transition-colors focus:outline-none">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path d="M1.816 15.556v.002c0 1.502.584 2.912 1.646 3.972s2.472 1.647 3.974 1.647a5.58 5.58 0 0 0 3.972-1.645l9.547-9.548c.769-.768 1.147-1.767 1.058-2.817-.079-.968-.548-1.927-1.319-2.698-1.594-1.592-4.068-1.711-5.517-.262l-7.916 7.915c-.881.881-.792 2.25.214 3.261.959.958 2.423 1.053 3.263.215l5.511-5.512c.28-.28.267-.722.053-.936l-.244-.244c-.191-.191-.567-.349-.957.04l-5.506 5.506c-.18.18-.635.127-.976-.214-.098-.097-.576-.613-.213-.973l7.915-7.917c.818-.817 2.267-.699 3.23.262.5.501.802 1.1.849 1.685.051.573-.156 1.111-.589 1.543l-9.547 9.549a3.97 3.97 0 0 1-2.829 1.171 3.975 3.975 0 0 1-2.83-1.173 3.973 3.973 0 0 1-1.172-2.828c0-1.071.415-2.076 1.172-2.83l7.209-7.211c.157-.157.264-.579.028-.814L11.5 4.36a.57.57 0 0 0-.834.018l-7.205 7.207a5.577 5.577 0 0 0-1.645 3.971z"></path>
                    </svg>
                </button>

                <!-- Emoji Picker Panel (Toggled with button) -->
                <div id="channel_emoji_picker_container"
                    class="hidden absolute bottom-full mb-3 left-0 z-50 shadow-2xl origin-bottom-left rounded-[16px] overflow-hidden flex flex-col bg-white dark:bg-[#202c33] border border-gray-200 dark:border-gray-700 w-[320px] sm:w-[350px]">
                    
                    <div class="w-full relative" style="height: 320px;">
                        <!-- The actual picker -->
                        <div id="channel_panel_emoji" class="w-full h-full">
                        <emoji-picker id="channel_emoji_picker" class="w-full"
                            style="--num-columns: 8; --emoji-size: 1.5rem; --indicator-color: #00a884; height: 320px; border: none;"></emoji-picker>
                    </div>

                    <!-- GIF Panel -->
                        <div id="channel_panel_gif" class="w-full h-full hidden bg-white dark:bg-[#202c33] p-2 flex flex-col">
                        <div class="mb-2 shrink-0">
                            <input type="text" id="channel_gif_search_input" placeholder="Search GIFs..." class="w-full bg-gray-100 dark:bg-[#2a3942] text-gray-800 dark:text-white rounded-lg px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#00a884] border-none text-sm placeholder-gray-500" onkeyup="if(event.key === 'Enter') searchChannelGifs(this.value)">
                        </div>
                        <div id="channel_gif_results" class="flex-1 overflow-y-auto custom-scrollbar grid grid-cols-2 gap-1 p-1 content-start">
                            <!-- Populated by JS -->
                        </div>
                    </div>

                    <!-- Sticker Panel -->
                        <div id="channel_panel_sticker" class="w-full h-full hidden bg-white dark:bg-[#202c33] p-2 flex flex-col">
                        <div class="mb-2 shrink-0">
                            <input type="text" id="channel_sticker_search_input" placeholder="Search Stickers..." class="w-full bg-gray-100 dark:bg-[#2a3942] text-gray-800 dark:text-white rounded-lg px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#00a884] border-none text-sm placeholder-gray-500" onkeyup="if(event.key === 'Enter') searchChannelStickers(this.value)">
                        </div>
                        <div id="channel_sticker_results" class="flex-1 overflow-y-auto custom-scrollbar grid grid-cols-4 gap-2 p-1 content-start">
                            <!-- Populated by JS -->
                        </div>
                    </div>
                    </div> <!-- Close w-full relative h-[320px] -->

                    <!-- Bottom Tabs Bar -->
                    <div
                        class="h-[50px] bg-gray-100 dark:bg-[#2a3942] border-t border-gray-200 dark:border-gray-700 flex items-center justify-center shrink-0">
                        <!-- Emoji Tab (Active) -->
                        <button onclick="switchChannelPickerTab('emoji')" id="channel_tab_btn_emoji"
                            class="flex-1 flex justify-center py-2 h-full items-center relative transition-colors bg-gray-200 dark:bg-[#384b57]">
                            <svg viewBox="0 0 24 24" width="24" height="24"
                                class="text-gray-600 dark:text-gray-300" fill="currentColor">
                                <path
                                    d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm2.5-9.5c.828 0 1.5-.672 1.5-1.5s-.672-1.5-1.5-1.5-1.5.672-1.5 1.5.672 1.5 1.5 1.5zm-5 0c.828 0 1.5-.672 1.5-1.5S8.828 8 8 8s-1.5.672-1.5 1.5.672 1.5 1.5 1.5zm2.5 6c2.511 0 4.67-1.516 5.568-3.693h-11.136c.898 2.177 3.057 3.693 5.568 3.693z">
                                </path>
                            </svg>
                            <div id="channel_tab_indicator_emoji" class="absolute bottom-0 left-0 w-full h-[3px] bg-[#00a884]"></div>
                        </button>
                        <!-- GIF Tab -->
                        <button onclick="switchChannelPickerTab('gif')" id="channel_tab_btn_gif"
                            class="flex-1 flex justify-center py-2 h-full items-center hover:bg-gray-200 dark:hover:bg-[#384b57] transition-colors relative">
                            <span class="font-bold text-gray-500 dark:text-gray-400 text-[15px]">GIF</span>
                            <div id="channel_tab_indicator_gif" class="absolute bottom-0 left-0 w-full h-[3px] bg-[#00a884] hidden"></div>
                        </button>
                        <!-- Sticker Tab -->
                        <button onclick="switchChannelPickerTab('sticker')" id="channel_tab_btn_sticker"
                            class="flex-1 flex justify-center py-2 h-full items-center hover:bg-gray-200 dark:hover:bg-[#384b57] transition-colors relative">
                            <svg viewBox="0 0 24 24" width="24" height="24"
                                class="text-gray-500 dark:text-gray-400" fill="currentColor">
                                <path
                                    d="M14.5 3h-5C6.46 3 4 5.46 4 8.5v7C4 18.54 6.46 21 9.5 21h4l6-6v-6.5C19.5 5.46 17.04 3 14.5 3zm-2.5 16h-2.5C7.57 19 6 17.43 6 15.5v-7C6 6.57 7.57 5 9.5 5h5C16.43 5 18 6.57 18 8.5v5.09l-4.5 4.5V19h-1.5zM17 14h-2.5c-.83 0-1.5.67-1.5 1.5V18l4-4z">
                                </path>
                            </svg>
                            <div id="channel_tab_indicator_sticker" class="absolute bottom-0 left-0 w-full h-[3px] bg-[#00a884] hidden"></div>
                        </button>
                    </div>
                </div>

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
                        <div class="flex flex-col items-center gap-1 group cursor-pointer" onclick="openContactShareModal()">
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
                        <!-- Event -->
                        <div class="flex flex-col items-center gap-1 group cursor-pointer" onclick="alert('Event feature coming soon!')">
                            <div class="w-14 h-14 rounded-2xl bg-[#f45197] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <span class="text-gray-300 text-xs">Event</span>
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
        <!-- Bottom Selection Bar -->
        <div id="channel_selection_bottom_bar" class="hidden absolute bottom-0 left-0 w-full h-[60px] bg-[#202c33] border-t border-[#313d45] flex items-center justify-between px-4 z-30 transition-transform transform translate-y-full">
            <div class="flex items-center gap-4">
                <button onclick="window.cancelChannelSelection()" class="text-[#8696a0] hover:text-[#e9edef] p-2 rounded-full focus:outline-none transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <span id="channel_selection_count" class="font-medium text-[#e9edef] text-[16px]">0 selected</span>
            </div>
            <div class="flex items-center gap-4 text-[#8696a0]">
                <!-- Forward -->
                <button onclick="window.forwardSelectedChannelUpdates()" class="hover:text-[#e9edef] p-2 focus:outline-none transition-colors" title="Forward">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
                <!-- Copy -->
                <button onclick="window.copySelectedChannelUpdates()" class="hover:text-[#e9edef] p-2 focus:outline-none transition-colors" title="Copy">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                </button>
                <!-- Delete -->
                <button onclick="window.deleteSelectedChannelUpdates()" id="channel_selection_delete_btn" class="hover:text-[#e9edef] p-2 focus:outline-none transition-colors" title="Delete">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>
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

    <!-- Channel Settings Drawer -->
    <div id="channel_settings_drawer" class="hidden absolute top-0 right-0 w-full md:w-[400px] h-full bg-[#111b21] border-l border-[#313d45] flex-col shrink-0 z-50 transition-transform transform translate-x-full duration-300">
        <!-- Header -->
        <div class="h-[60px] bg-[#202c33] px-4 flex items-center gap-4 border-b border-[#313d45] shrink-0">
            <button onclick="window.closeChannelSettings()" class="text-[#8696a0] hover:text-[#e9edef]">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path></svg>
            </button>
            <span class="text-[#e9edef] text-[16px] font-medium">Channel settings</span>
        </div>
        <!-- Body -->
        <div class="flex-1 overflow-y-auto p-6 bg-[#111b21]">
            <h3 class="text-[#8696a0] text-[14px] font-medium mb-4">Which reactions can followers send</h3>
            <label class="flex items-center gap-4 mb-6 cursor-pointer">
                <input type="radio" name="channel_reactions_setting" value="any" onchange="window.saveChannelReactionsSetting('any')" class="hidden peer" id="channel_reaction_any">
                <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] flex items-center justify-center shrink-0">
                    <div class="w-2.5 h-2.5 rounded-full bg-[#00a884] opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                </div>
                <span class="text-[#e9edef] text-[15px]">Any emoji</span>
            </label>
            <label class="flex items-center gap-4 mb-6 cursor-pointer">
                <input type="radio" name="channel_reactions_setting" value="default" onchange="window.saveChannelReactionsSetting('default')" class="hidden peer" id="channel_reaction_default">
                <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] flex items-center justify-center shrink-0">
                    <div class="w-2.5 h-2.5 rounded-full bg-[#00a884] opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                </div>
                <span class="text-[#e9edef] text-[15px]">Default only (👍❤️😂😮😢🙏)</span>
            </label>
            <label class="flex items-center gap-4 cursor-pointer">
                <input type="radio" name="channel_reactions_setting" value="none" onchange="window.saveChannelReactionsSetting('none')" class="hidden peer" id="channel_reaction_none">
                <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] flex items-center justify-center shrink-0">
                    <div class="w-2.5 h-2.5 rounded-full bg-[#00a884] opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                </div>
                <span class="text-[#e9edef] text-[15px]">None</span>
            </label>
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
