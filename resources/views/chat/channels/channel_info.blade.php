<!-- Channel Info Sidebar -->
<div id="channel_info_sidebar" class="hidden w-[30%] min-w-[400px] max-w-full h-full bg-[#111b21] border-l border-[#313d45] flex-col shrink-0 z-40 select-none flex-1 sm:flex-none">
    <!-- Header -->
    <div class="h-[60px] bg-[#111b21] px-4 flex items-center gap-6 shrink-0">
        <!-- Close button 'X' -->
        <button onclick="window.closeChannelInfo()" class="text-[#d1d7db] hover:text-[#e9edef] focus:outline-none transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M19.1 17.2l-5.3-5.3 5.3-5.3-1.8-1.8-5.3 5.3-5.3-5.3-1.8 1.8 5.3 5.3-5.3 5.3 1.8 1.8 5.3-5.3 5.3 5.3z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[16px] font-medium">Channel info</h2>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] pb-10">
        <!-- Avatar Section -->
        <div class="flex flex-col items-center pt-5 pb-6">
            <div class="relative cursor-pointer group mb-5" onclick="window.triggerEditChannelAvatar()">
                <div class="w-[200px] h-[200px] rounded-full overflow-hidden bg-[#202c33]">
                    <img id="info_channel_avatar" src="" class="w-full h-full object-cover">
                </div>
                <!-- Overlay for Add channel icon -->
                <div id="info_avatar_overlay" class="absolute inset-0 bg-black bg-opacity-40 rounded-full flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity hidden">
                    <svg viewBox="0 0 24 24" width="28" height="28" fill="#fff" class="mb-2"><path d="M21.22 4.35l-2.57-2.57a1.5 1.5 0 0 0-1.06-.44H6.41a1.5 1.5 0 0 0-1.06.44L2.78 4.35A1.5 1.5 0 0 0 2.34 5.4v13.2a1.5 1.5 0 0 0 1.5 1.5h16.32a1.5 1.5 0 0 0 1.5-1.5V5.4a1.5 1.5 0 0 0-.44-1.05zM12 17a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"></path></svg>
                    <span class="text-white text-[13px] text-center px-4 leading-tight">CHANGE<br>CHANNEL ICON</span>
                </div>
            </div>
            <input type="file" id="edit_channel_avatar_input" class="hidden" accept="image/*" onchange="window.handleEditChannelAvatar(this)">

            <!-- Channel Name Section -->
            <div id="info_channel_name_display" class="flex items-center gap-3 mb-1 cursor-pointer group" onclick="window.startEditChannelName()">
                <h1 id="info_channel_name" class="text-[#e9edef] text-[22px] font-normal"></h1>
                <button id="info_channel_name_edit_btn" class="hidden text-[#8696a0] group-hover:text-[#d1d7db]"><svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M19.3 8.925l-4.25-4.225 1.4-1.425c.375-.375.9-.575 1.425-.575.525 0 1.05.2 1.425.575l1.4 1.4c.4.4.6.925.6 1.45s-.2 1.05-.6 1.45l-1.4 1.35zm-1.425 1.425l-11.45 11.45H2.2v-4.225l11.425-11.45 4.25 4.225z"></path></svg></button>
            </div>

            <div id="info_channel_name_edit_mode" class="hidden items-center justify-between w-[80%] mx-auto border-b-2 border-[#00a884] mb-1 pb-1">
                <input type="text" id="info_channel_name_input" class="bg-transparent text-[#e9edef] text-[22px] font-normal w-full outline-none" autocomplete="off">
                <div class="flex items-center gap-3 ml-2">
                    <button class="text-[#8696a0] hover:text-[#d1d7db]"><svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M9.153 11.603c.795 0 1.439-.879 1.439-1.962s-.644-1.962-1.439-1.962-1.439.879-1.439 1.962.644 1.962 1.439 1.962zm-3.204 1.362c-.026-.307-.131 5.218 6.063 5.551 6.066-.25 6.066-5.551 6.066-5.551-6.078 1.416-12.129 0-12.129 0zm11.363 1.108s-.669 1.959-5.051 1.959c-3.505 0-5.388-1.164-5.607-1.959 0 0 5.912 1.055 10.658 0zM11.804 1.011C5.609 1.011.978 6.033.978 12.228s4.826 10.761 11.021 10.761S23.02 18.423 23.02 12.228c.001-6.195-5.021-11.217-11.216-11.217zM12 21.354c-5.273 0-9.381-3.886-9.381-9.159s3.942-9.548 9.215-9.548 9.548 4.275 9.548 9.548c-.001 5.272-4.109 9.159-9.382 9.159zm3.108-9.751c.795 0 1.439-.879 1.439-1.962s-.644-1.962-1.439-1.962-1.439.879-1.439 1.962.644 1.962 1.439 1.962z"></path></svg></button>
                    <button onclick="window.saveChannelName()" class="text-[#00a884]"><svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path></svg></button>
                </div>
            </div>
            <p id="info_channel_followers" class="text-[#8696a0] text-[15px]"></p>

            <div id="info_owner_actions" class="flex items-center gap-6 mt-6">
                <!-- Forward -->
                <div class="flex flex-col items-center cursor-pointer group" onclick="window.forwardChannel()">
                    <div class="w-[50px] h-[50px] rounded-full border border-[#313d45] flex items-center justify-center mb-2 group-hover:bg-[#202c33] transition-colors">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="#d1d7db"><path d="M10.74 5.253a.835.835 0 0 0-1.285.7l-.004 3.018c-3.791.246-6.425 2.502-7.391 5.485-.29.897.669 1.636 1.343.914 1.488-1.594 3.078-2.308 6.046-2.508v3.136a.835.835 0 0 0 1.286.7l5.918-4.167a.833.833 0 0 0 0-1.365l-5.913-4.913z"></path></svg>
                    </div>
                    <span class="text-[#d1d7db] text-[14px]">Forward</span>
                </div>
                <!-- Copy link -->
                <div class="flex flex-col items-center cursor-pointer group" onclick="window.copyChannelLink()">
                    <div class="w-[50px] h-[50px] rounded-full border border-[#313d45] flex items-center justify-center mb-2 group-hover:bg-[#202c33] transition-colors">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="#d1d7db"><path d="M11.646 17.066l2.121 2.122-2.121 2.121a5.975 5.975 0 0 1-4.243 1.758 5.975 5.975 0 0 1-4.242-1.758A5.972 5.972 0 0 1 1.403 17a5.97 5.97 0 0 1 1.758-4.242l2.121-2.122 2.122 2.122-2.122 2.121c-1.168 1.168-1.168 3.074 0 4.243 1.169 1.168 3.075 1.168 4.243 0l2.121-2.121-2.122-2.121 2.122-2.122zM20.84 2.736A5.975 5.975 0 0 0 16.598 1a5.975 5.975 0 0 0-4.242 1.758l-2.122 2.121 2.122 2.122 2.121-2.121c1.169-1.168 3.075-1.168 4.243 0 1.168 1.168 1.168 3.074 0 4.242l-2.121 2.122 2.121 2.121 2.121-2.121A5.972 5.972 0 0 0 22.597 7a5.97 5.97 0 0 0-1.757-4.264zM7.05 14.828l7.778-7.778 2.122 2.122-7.778 7.778-2.122-2.122z"></path></svg>
                    </div>
                    <span class="text-[#d1d7db] text-[14px]">Copy link</span>
                </div>
            </div>

            <div id="info_follower_actions" class="hidden items-center justify-center gap-2 mt-6 w-full px-2">
                <!-- Following/Follow -->
                <button id="info_following_btn_top" onclick="window.unfollowChannel()" class="flex flex-col items-center justify-center border border-[#313d45] rounded-[16px] py-2 px-3 flex-1 hover:bg-[#202c33] transition-colors h-[72px]">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="#00a884" class="mb-1"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path></svg>
                    <span class="text-[#d1d7db] text-[13px] font-medium leading-tight">Following</span>
                </button>
                <button id="info_follow_btn_top" onclick="window.followChannel()" class="hidden flex-col items-center justify-center border border-[#313d45] rounded-[16px] py-2 px-3 flex-1 hover:bg-[#202c33] transition-colors h-[72px]">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="#00a884" class="mb-1"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path></svg>
                    <span class="text-[#d1d7db] text-[13px] font-medium leading-tight">Follow</span>
                </button>

                <!-- Forward -->
                <button onclick="window.forwardChannel()" class="flex flex-col items-center justify-center border border-[#313d45] rounded-[16px] py-2 px-3 flex-1 hover:bg-[#202c33] transition-colors h-[72px]">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="#00a884" class="mb-1"><path d="M10.74 5.253a.835.835 0 0 0-1.285.7l-.004 3.018c-3.791.246-6.425 2.502-7.391 5.485-.29.897.669 1.636 1.343.914 1.488-1.594 3.078-2.308 6.046-2.508v3.136a.835.835 0 0 0 1.286.7l5.918-4.167a.833.833 0 0 0 0-1.365l-5.913-4.913z"></path></svg>
                    <span class="text-[#d1d7db] text-[13px] font-medium leading-tight">Forward</span>
                </button>
                
                <!-- Share -->
                <button onclick="window.copyChannelLink()" class="flex flex-col items-center justify-center border border-[#313d45] rounded-[16px] py-2 px-3 flex-1 hover:bg-[#202c33] transition-colors h-[72px]">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="#00a884" class="mb-1"><path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92 1.61 0 2.92-1.31 2.92-2.92s-1.31-2.92-2.92-2.92z"></path></svg>
                    <span class="text-[#d1d7db] text-[13px] font-medium leading-tight">Share</span>
                </button>
                
                <!-- Search -->
                <button onclick="window.searchChannelMessages()" class="flex flex-col items-center justify-center border border-[#313d45] rounded-[16px] py-2 px-3 flex-1 hover:bg-[#202c33] transition-colors h-[72px]">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="#00a884" class="mb-1"><path d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 0 0 1.256-3.386 5.207 5.207 0 1 0-5.207 5.208 5.183 5.183 0 0 0 3.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-4.8 0a3.6 3.6 0 1 1 0-7.2 3.6 3.6 0 0 1 0 7.2z"></path></svg>
                    <span class="text-[#d1d7db] text-[13px] font-medium leading-tight">Search</span>
                </button>
            </div>
        </div>

        <div class="h-2 w-full bg-[#0b141a]"></div>

        <!-- Description -->
        <div id="info_channel_desc_section" class="px-6 py-4 border-b border-[#202c33]">
            <div id="info_channel_desc_display" class="flex items-start justify-between cursor-pointer group" onclick="window.startEditChannelDescription()">
                <div class="flex-1 mr-4">
                    <h3 id="info_channel_desc_header" class="text-[#8696a0] text-[15px] mb-1">Add channel description</h3>
                    <p id="info_channel_desc" class="text-[#00a884] text-[15px] break-words">Add channel description</p>
                </div>
                <button id="info_channel_desc_edit_btn" class="hidden text-[#8696a0] group-hover:text-[#d1d7db] mt-1"><svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M19.3 8.925l-4.25-4.225 1.4-1.425c.375-.375.9-.575 1.425-.575.525 0 1.05.2 1.425.575l1.4 1.4c.4.4.6.925.6 1.45s-.2 1.05-.6 1.45l-1.4 1.35zm-1.425 1.425l-11.45 11.45H2.2v-4.225l11.425-11.45 4.25 4.225z"></path></svg></button>
            </div>

            <div id="info_channel_desc_edit_mode" class="hidden flex-col gap-2 w-full mt-1">
                <div class="flex items-end justify-between border-b-2 border-[#00a884] pb-1 w-full">
                    <textarea id="info_channel_desc_input" rows="1" class="bg-transparent text-[#e9edef] text-[15px] w-full outline-none resize-none overflow-hidden" placeholder="Add channel description" autocomplete="off" oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px';"></textarea>
                    <div class="flex items-center gap-3 ml-2 shrink-0 pb-0.5">
                        <button class="text-[#8696a0] hover:text-[#d1d7db]"><svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M9.153 11.603c.795 0 1.439-.879 1.439-1.962s-.644-1.962-1.439-1.962-1.439.879-1.439 1.962.644 1.962 1.439 1.962zm-3.204 1.362c-.026-.307-.131 5.218 6.063 5.551 6.066-.25 6.066-5.551 6.066-5.551-6.078 1.416-12.129 0-12.129 0zm11.363 1.108s-.669 1.959-5.051 1.959c-3.505 0-5.388-1.164-5.607-1.959 0 0 5.912 1.055 10.658 0zM11.804 1.011C5.609 1.011.978 6.033.978 12.228s4.826 10.761 11.021 10.761S23.02 18.423 23.02 12.228c.001-6.195-5.021-11.217-11.216-11.217zM12 21.354c-5.273 0-9.381-3.886-9.381-9.159s3.942-9.548 9.215-9.548 9.548 4.275 9.548 9.548c-.001 5.272-4.109 9.159-9.382 9.159zm3.108-9.751c.795 0 1.439-.879 1.439-1.962s-.644-1.962-1.439-1.962-1.439.879-1.439 1.962.644 1.962 1.439 1.962z"></path></svg></button>
                        <button onclick="window.saveChannelDescription()" class="text-[#00a884]"><svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path></svg></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Created Info -->
        <div class="px-6 py-4">
            <p id="info_channel_created_at" class="text-[#8696a0] text-[15px]">Created today at 10:14 am</p>
        </div>

        <div class="h-2 w-full bg-[#0b141a]"></div>

        <!-- Insights -->
        <div id="info_insights_section" class="px-6 py-5 border-b border-[#202c33]">
            <div class="flex items-center gap-2 mb-4">
                <h3 class="text-[#8696a0] text-[14px]">Insights for last 30 days</h3>
                <svg viewBox="0 0 24 24" width="16" height="16" fill="#8696a0"><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path></svg>
            </div>

            <div class="flex gap-3 mb-4">
                <div class="flex-1 border border-[#313d45] rounded-[16px] p-4 flex flex-col justify-between h-[85px]">
                    <span class="text-[#e9edef] text-[16px] font-medium tracking-widest">_ _</span>
                    <span class="text-[#8696a0] text-[14px]">Accounts reached</span>
                </div>
                <div class="flex-1 border border-[#313d45] rounded-[16px] p-4 flex flex-col justify-between h-[85px]">
                    <span class="text-[#e9edef] text-[16px] font-medium tracking-widest">_ _</span>
                    <span class="text-[#8696a0] text-[14px]">Net follows</span>
                </div>
            </div>
            <p class="text-[#8696a0] text-[14px]">Insights are available after reaching 100 followers.</p>
        </div>

        <!-- Settings Links -->
        <div class="py-2">
            <!-- Notifications -->
            <div class="px-6 py-4 flex items-center justify-between cursor-pointer hover:bg-[#202c33] transition-colors" onclick="window.openChannelNotifications()">
                <div class="flex items-center gap-6">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="#8696a0"><path d="M21.565 17.568c-.461-.416-2.585-2.22-2.585-8.497 0-3.328-1.996-6.143-5.263-7.234a2.915 2.915 0 0 0-3.435 0C7.016 2.928 5.02 5.743 5.02 9.071c0 6.277-2.124 8.081-2.585 8.497-.376.34-.582.836-.554 1.353.027.518.286.993.696 1.282A1.94 1.94 0 0 0 3.702 20.5h16.596c.394 0 .777-.116 1.125-.297a2.022 2.022 0 0 0 .696-1.282c.028-.517-.178-1.013-.554-1.353zM12 23.5c1.47 0 2.75-.81 3.407-2H8.593c.657 1.19 1.937 2 3.407 2z"></path></svg>
                    <span class="text-[#e9edef] text-[17px]">Notifications</span>
                </div>
                <svg viewBox="0 0 24 24" width="20" height="20" fill="#8696a0"><path d="M8.5 20l-1.5-1.5L13.5 12 7 5.5 8.5 4l8 8-8 8z"></path></svg>
            </div>

            <!-- Public channel -->
            <div class="px-6 py-3 flex gap-6 cursor-pointer hover:bg-[#202c33] transition-colors" onclick="window.openPublicChannelModal()">
                <div class="mt-1"><svg viewBox="0 0 24 24" width="24" height="24" fill="#8696a0"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-.5 18c-1.32 0-2.54-.42-3.55-1.12.92-1.23 2.12-3.62 2.37-5.88h2.36c.25 2.26 1.45 4.65 2.37 5.88-.99.7-2.21 1.12-3.55 1.12zm0-9H8.21c-.4-1.89-1.26-3.83-2.07-5.18.99-.7 2.22-1.12 3.55-1.12 1.32 0 2.54.42 3.55 1.12-.81 1.35-1.67 3.29-2.07 5.18h-2.27z"></path></svg></div>
                <div>
                    <h3 class="text-[#e9edef] text-[17px]">Public channel</h3>
                    <p class="text-[#8696a0] text-[14px] pr-4">What you share is visible to anyone, but your phone number isn't. Click to learn more.</p>
                </div>
            </div>

            <!-- Channel settings -->
            <div id="info_channel_settings_btn" class="px-6 py-4 flex items-center gap-6 cursor-pointer hover:bg-[#202c33] transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="#8696a0"><path d="M19.43 12.98c.04-.32.07-.64.07-.98s-.03-.66-.07-.98l2.11-1.65c.19-.15.24-.42.12-.64l-2-3.46c-.12-.22-.39-.3-.61-.22l-2.49 1c-.52-.4-1.08-.73-1.69-.98l-.38-2.65C14.46 2.18 14.25 2 14 2h-4c-.25 0-.46.18-.49.42l-.38 2.65c-.61.25-1.17.59-1.69-.98l-2.49-1c-.23-.09-.49 0-.61.22l-2 3.46c-.13.22-.07.49.12.64l2.11 1.65c-.04.32-.07.65-.07.98s-.03.66.07.98l-2.11 1.65c-.19.15-.24.42-.12.64l2 3.46c.12.22.39.3.61.22l2.49-1c.52.4 1.08.73 1.69.98l.38 2.65c.03.24.24.42.49.42h4c.25 0 .46-.18.49-.42l.38-2.65c.61-.25 1.17-.59 1.69-.98l2.49 1c.23.09.49 0 .61-.22l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.65zM12 15.5c-1.93 0-3.5-1.57-3.5-3.5s1.57-3.5 3.5-3.5 3.5 1.57 3.5 3.5-1.57 3.5-3.5 3.5z"></path></svg>
                <span class="text-[#e9edef] text-[17px]">Channel settings</span>
            </div>

            <!-- Channel alerts -->
            <div id="info_channel_alerts_btn" class="px-6 py-4 flex items-center gap-6 cursor-pointer hover:bg-[#202c33] transition-colors" onclick="window.openChannelAlerts()">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="#8696a0"><path d="M11 15h2v2h-2v-2zm0-8h2v6h-2V7zm1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"></path></svg>
                <span class="text-[#e9edef] text-[17px]">Channel alerts</span>
            </div>
        </div>

        <div class="h-2 w-full bg-[#0b141a]"></div>

        <!-- Followers Section -->
        <div id="info_followers_section" class="py-2 pb-6 hidden">
            <div class="px-6 py-3 flex items-center justify-between">
                <h3 id="info_follower_count_header" class="text-[#8696a0] text-[14px]">0 followers</h3>
                <svg viewBox="0 0 24 24" width="20" height="20" fill="#8696a0"><path d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 0 0 1.256-3.386 5.207 5.207 0 1 0-5.207 5.208 5.183 5.183 0 0 0 3.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-4.8 0a3.6 3.6 0 1 1 0-7.2 3.6 3.6 0 0 1 0 7.2z"></path></svg>
            </div>

            <div id="info_followers_list_actions">
                <!-- Invite admins -->
                <div id="info_invite_admins_btn" class="hidden px-6 py-3 items-center gap-4 cursor-pointer hover:bg-[#202c33] transition-colors" onclick="window.openInviteAdmins()">
                    <div class="w-[44px] h-[44px] rounded-full bg-[#00a884] flex items-center justify-center shrink-0">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="#111b21"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path></svg>
                    </div>
                    <span class="text-[#e9edef] text-[16px]">Invite admins</span>
                </div>

                <!-- Invite followers -->
                <div id="info_invite_followers_btn" class="hidden px-6 py-3 items-center gap-4 cursor-pointer hover:bg-[#202c33] transition-colors" onclick="window.openChannelShareModal()">
                    <div class="w-[44px] h-[44px] rounded-full bg-[#00a884] flex items-center justify-center shrink-0">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="#111b21"><path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path></svg>
                    </div>
                    <span class="text-[#e9edef] text-[16px]">Invite followers</span>
                </div>

                <!-- Channel link -->
                <div class="px-6 py-3 flex items-center gap-4 cursor-pointer hover:bg-[#202c33] transition-colors" onclick="window.openChannelLinkSidebar()">
                    <div class="w-[44px] h-[44px] rounded-full bg-[#00a884] flex items-center justify-center shrink-0">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="#111b21"><path d="M11.646 17.066l2.121 2.122-2.121 2.121a5.975 5.975 0 0 1-4.243 1.758 5.975 5.975 0 0 1-4.242-1.758A5.972 5.972 0 0 1 1.403 17a5.97 5.97 0 0 1 1.758-4.242l2.121-2.122 2.122 2.122-2.122 2.121c-1.168 1.168-1.168 3.074 0 4.243 1.169 1.168 3.075 1.168 4.243 0l2.121-2.121-2.122-2.121 2.122-2.122zM20.84 2.736A5.975 5.975 0 0 0 16.598 1a5.975 5.975 0 0 0-4.242 1.758l-2.122 2.121 2.122 2.122 2.121-2.121c1.169-1.168 3.075-1.168 4.243 0 1.168 1.168 1.168 3.074 0 4.242l-2.121 2.122 2.121 2.121 2.121-2.121A5.972 5.972 0 0 0 22.597 7a5.97 5.97 0 0 0-1.757-4.264zM7.05 14.828l7.778-7.778 2.122 2.122-7.778 7.778-2.122-2.122z"></path></svg>
                    </div>
                    <span class="text-[#e9edef] text-[16px]">Channel link</span>
                </div>
            </div>

            <!-- Followers List Container -->
            <div id="info_followers_list" class="mt-2">
                <!-- Appended via JS -->
            </div>

            <p class="px-6 py-4 text-[#8696a0] text-[14px] leading-relaxed">
                You can only view individual followers who are contacts or admins.
            </p>
        </div>

        <div class="h-2 w-full bg-[#0b141a]"></div>

        <!-- Danger Zone Actions -->
        <div id="info_admin_danger_controls" class="py-4">
            <!-- Transfer ownership -->
            <div id="info_transfer_ownership_btn" onclick="window.openTransferOwnershipSidebar()" class="hidden px-6 py-3 items-center gap-6 cursor-pointer hover:bg-[#202c33] transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="#00a884"><path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path></svg>
                <span class="text-[#00a884] text-[17px]">Transfer ownership</span>
            </div>
            <!-- Dismiss yourself as admin -->
            <div id="info_dismiss_self_admin_btn" onclick="window.dismissSelfAdmin()" class="hidden px-6 py-3 items-center gap-6 cursor-pointer hover:bg-[#202c33] transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="#ea005e"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm4-9H8v2h8v-2z"></path></svg>
                <span class="text-[#ea005e] text-[17px]">Dismiss yourself as admin</span>
            </div>
            <!-- Delete channel -->
            <div id="info_delete_channel_btn" onclick="window.deleteChannel()" class="hidden px-6 py-3 items-center gap-6 cursor-pointer hover:bg-[#202c33] transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="#ea005e"><path d="M19 4h-3.5l-1-1h-5l-1 1H5v2h14M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12z"></path></svg>
                <span class="text-[#ea005e] text-[17px]">Delete channel</span>
            </div>
            <!-- Unfollow channel -->
            <div id="info_unfollow_channel_btn" onclick="window.unfollowChannel()" class="hidden px-6 py-3 items-center gap-6 cursor-pointer hover:bg-[#202c33] transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="#ea005e"><path d="M10.09 15.59L11.5 17l5-5-5-5-1.41 1.41L12.67 11H3v2h9.67l-2.58 2.59zM19 3H5c-1.11 0-2 .9-2 2v4h2V5h14v14H5v-4H3v4c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"></path></svg>
                <span class="text-[#ea005e] text-[17px]">Unfollow channel</span>
            </div>
            <!-- Report channel -->
            <div id="info_report_channel_btn" onclick="window.reportChannel()" class="px-6 py-3 flex items-center gap-6 cursor-pointer hover:bg-[#202c33] transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="#ea005e"><path d="M15 3H6c-.83 0-1.54.5-1.84 1.22l-3.02 7.05c-.09.23-.14.47-.14.73v2c0 1.1.9 2 2 2h6.31l-.95 4.57-.03.32c0 .41.17.79.44 1.06L9.83 23l6.59-6.59c.36-.36.58-.86.58-1.41V5c0-1.1-.9-2-2-2zm4 0v12h4V3h-4z"></path></svg>
                <span class="text-[#ea005e] text-[17px]">Report channel</span>
            </div>
        </div>

    </div>
</div>

<!-- Channel Notifications Sidebar -->
<div id="channel_notifications_sidebar" class="hidden h-full flex flex-col bg-[#111b21] w-full sm:w-[30%] sm:min-w-[400px] border-l border-[#313d45] z-[80] absolute right-0 top-0 transition-transform duration-300 transform translate-x-full">
    <!-- Header -->
    <div class="h-[60px] bg-[#111b21] px-4 flex items-center gap-6 shrink-0">
        <!-- Back button '<-' -->
        <button onclick="window.closeChannelNotifications()" class="text-[#d1d7db] hover:text-[#e9edef] focus:outline-none transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M20 11H7.8l5.6-5.6L12 4l-8 8 8 8 1.4-1.4L7.8 13H20v-2z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[16px] font-medium">Notifications</h2>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] pb-10">
        <!-- Follower activity -->
        <div class="px-6 py-4">
            <h3 class="text-[#8696a0] text-[14px] mb-4">Follower activity</h3>
            <div class="flex items-center justify-between">
                <span class="text-[#e9edef] text-[16px]">Mute notifications</span>

                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="mute_follower_notifications" class="sr-only peer" onchange="window.toggleChannelMute('follower', this.checked)">
                    <div class="w-10 h-5 bg-[#313d45] rounded-full peer peer-checked:bg-[#00a884] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-[#8696a0] peer-checked:after:bg-[#e9edef] after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-5"></div>
                </label>
            </div>
        </div>

        <div class="h-[1px] w-[calc(100%-48px)] mx-auto bg-[#202c33]"></div>

        <!-- Admin activity -->
        <div class="px-6 py-4">
            <h3 class="text-[#8696a0] text-[14px] mb-4">Admin activity</h3>
            <div class="flex items-center justify-between">
                <span class="text-[#e9edef] text-[16px]">Mute notifications</span>

                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="mute_admin_notifications" class="sr-only peer" onchange="window.toggleChannelMute('admin', this.checked)">
                    <div class="w-10 h-5 bg-[#313d45] rounded-full peer peer-checked:bg-[#00a884] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-[#8696a0] peer-checked:after:bg-[#e9edef] after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-5"></div>
                </label>
            </div>
        </div>
    </div>
</div>

<!-- Channel Alerts Sidebar -->
<div id="channel_alerts_sidebar" class="hidden h-full flex flex-col bg-[#111b21] w-full sm:w-[30%] sm:min-w-[400px] border-l border-[#313d45] z-[80] absolute right-0 top-0 transition-transform duration-300 transform translate-x-full">
    <!-- Header -->
    <div class="h-[60px] bg-[#111b21] px-4 flex items-center gap-6 shrink-0">
        <!-- Close 'X' button -->
        <button onclick="window.closeChannelAlerts()" class="text-[#d1d7db] hover:text-[#e9edef] focus:outline-none transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M19.1 17.2l-5.3-5.3 5.3-5.3-1.8-1.8-5.3 5.3-5.3-5.3-1.8 1.8 5.3 5.3-5.3 5.3 1.8 1.8 5.3-5.3 5.3 5.3z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[16px] font-medium">Channel alerts</h2>
    </div>

    <!-- Content -->
    <div class="flex-1 flex flex-col items-center justify-center p-8 bg-[#111b21] text-center">
        <h2 class="text-[#e9edef] text-[22px] mb-4 font-normal">No current alerts</h2>
        <p class="text-[#8696a0] text-[15px] leading-6">You may get channel alerts if your channel shares updates that do not follow our <span class="text-[#00a884] hover:underline cursor-pointer" onclick="window.showToast?.('Guidelines', 'Opening Guidelines...')">Channels Guidelines</span>.</p>
    </div>
</div>

<!-- Public Channel Modal -->
<div id="public_channel_modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/70">
    <div class="bg-[#202c33] w-[450px] rounded-2xl flex flex-col overflow-hidden text-[#e9edef] transform transition-transform scale-95 opacity-0 duration-200" id="public_channel_modal_content">
        <!-- Illustration -->
        <div class="bg-[#111b21] h-[160px] flex items-center justify-center relative">
            <div class="absolute inset-0 overflow-hidden flex items-center justify-center">
                <!-- Abstract green blobs -->
                <svg viewBox="0 0 200 150" class="w-full h-full opacity-60">
                    <path d="M 40,80 C 30,30 100,10 160,40 C 190,60 180,120 130,140 C 70,160 50,130 40,80 Z" fill="#00a884" />
                </svg>
            </div>
            <!-- Phone illustration -->
            <div class="z-10 bg-white rounded-lg p-2 shadow-lg flex items-center gap-2 border-[4px] border-[#00a884]">
                <div class="w-5 h-5 bg-[#00a884] rounded-full flex items-center justify-center">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="white"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-.5 18c-1.32 0-2.54-.42-3.55-1.12.92-1.23 2.12-3.62 2.37-5.88h2.36c.25 2.26 1.45 4.65 2.37 5.88-.99.7-2.21 1.12-3.55 1.12zm0-9H8.21c-.4-1.89-1.26-3.83-2.07-5.18.99-.7 2.22-1.12 3.55-1.12 1.32 0 2.54.42 3.55 1.12-.81 1.35-1.67 3.29-2.07 5.18h-2.27z"></path></svg>
                </div>
                <span id="public_channel_modal_name" class="text-[#111b21] text-sm font-medium">Channel</span>
            </div>
            <div class="absolute top-4 right-[25%] text-white">✨</div>
            <div class="absolute bottom-4 left-[35%] text-white">✨</div>
        </div>

        <div class="p-6">
            <h2 class="text-center text-[22px] font-medium mb-6">About this channel</h2>

            <div class="flex flex-col gap-5">
                <div class="flex gap-4">
                    <div class="mt-1"><svg viewBox="0 0 24 24" width="20" height="20" fill="#00a884"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-.5 18c-1.32 0-2.54-.42-3.55-1.12.92-1.23 2.12-3.62 2.37-5.88h2.36c.25 2.26 1.45 4.65 2.37 5.88-.99.7-2.21 1.12-3.55 1.12zm0-9H8.21c-.4-1.89-1.26-3.83-2.07-5.18.99-.7 2.22-1.12 3.55-1.12 1.32 0 2.54.42 3.55 1.12-.81 1.35-1.67 3.29-2.07 5.18h-2.27z"></path></svg></div>
                    <div>
                        <h4 class="text-[15px] text-[#e9edef]">Anyone can discover your channel</h4>
                        <p class="text-[14px] text-[#8696a0] mt-1 leading-5">Channels are public, so anyone can find them and see 30 days of history before following.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="mt-1">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="#00a884">
                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"></path>
                            <line x1="2" y1="2" x2="22" y2="22" stroke="#202c33" stroke-width="4"></line>
                            <line x1="2" y1="2" x2="22" y2="22" stroke="#00a884" stroke-width="2"></line>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-[15px] text-[#e9edef]">People see your channel, not you</h4>
                        <p class="text-[14px] text-[#8696a0] mt-1 leading-5">Followers can't see your phone number, profile picture or name, but other admins can.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="mt-1"><svg viewBox="0 0 24 24" width="20" height="20" fill="#00a884"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"></path></svg></div>
                    <div>
                        <h4 class="text-[15px] text-[#e9edef]">You're responsible for your channel</h4>
                        <p class="text-[14px] text-[#8696a0] mt-1 leading-5">Your channel needs to follow our <span class="text-[#00a884] hover:underline cursor-pointer" onclick="window.showToast?.('Guidelines', 'Opening Guidelines...')">Guidelines</span> and is reviewed against them.</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-6 mt-8">
                <button class="text-[#00a884] text-[14px] font-medium hover:underline" onclick="window.showToast?.('Learn More', 'Opening help center...')">Learn more</button>
                <button class="bg-[#00a884] text-[#111b21] px-6 py-2 rounded-full font-medium hover:bg-[#00c298] transition-colors" onclick="window.closePublicChannelModal()">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Channel Link Sidebar -->
<div id="channel_link_sidebar" class="hidden h-full flex flex-col bg-[#111b21] w-full sm:w-[30%] sm:min-w-[400px] border-l border-[#313d45] z-[80] absolute right-0 top-0 transition-transform duration-300 transform translate-x-full">
    <!-- Header -->
    <div class="h-[60px] bg-[#111b21] px-4 flex items-center gap-6 shrink-0">
        <!-- Back button '<-' -->
        <button onclick="window.closeChannelLink()" class="text-[#d1d7db] hover:text-[#e9edef] focus:outline-none transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M20 11H7.8l5.6-5.6L12 4l-8 8 8 8 1.4-1.4L7.8 13H20v-2z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[16px] font-medium">Channel link</h2>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] pb-10">

        <div class="px-6 py-6">
            <div class="bg-[#202c33] rounded-2xl p-4 flex items-center gap-4 border border-[#313d45]">
                <div class="w-[48px] h-[48px] bg-[#3b4a54] rounded-full flex items-center justify-center shrink-0">
                    <svg viewBox="0 0 24 24" width="28" height="28" fill="#e9edef"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-.5 18c-1.32 0-2.54-.42-3.55-1.12.92-1.23 2.12-3.62 2.37-5.88h2.36c.25 2.26 1.45 4.65 2.37 5.88-.99.7-2.21 1.12-3.55 1.12zm0-9H8.21c-.4-1.89-1.26-3.83-2.07-5.18.99-.7 2.22-1.12 3.55-1.12 1.32 0 2.54.42 3.55 1.12-.81 1.35-1.67 3.29-2.07 5.18h-2.27z"></path></svg>
                </div>
                <div class="flex-1 overflow-hidden">
                    <h3 id="channel_link_name" class="text-[#e9edef] text-[16px] truncate">Channel</h3>
                    <p id="channel_link_url" class="text-[#00a884] text-[14px] truncate mt-1">...</p>
                </div>
            </div>

            <p class="text-[#e9edef] text-[14px] mt-6 leading-5">People with this link can view and follow your channel.</p>
        </div>

        <div class="h-[1px] w-[calc(100%-48px)] mx-auto bg-[#202c33]"></div>

        <div class="py-2">
            <div class="px-6 py-4 flex items-center gap-6 cursor-pointer hover:bg-[#202c33] transition-colors" onclick="window.openChannelShareModal()">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="#8696a0"><path d="M12.953 5.441L21 12l-8.047 6.559v-4.14C6.541 14.532 2 18.003 2 18.003s1.5-6.666 10.953-8.423v-4.139z"></path></svg>
                <span class="text-[#e9edef] text-[16px]">Send link via WhatsApp</span>
            </div>

            <div class="px-6 py-4 flex items-center gap-6 cursor-pointer hover:bg-[#202c33] transition-colors" onclick="window.copyChannelLink()">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="#8696a0"><path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"></path></svg>
                <span class="text-[#e9edef] text-[16px]">Copy link</span>
            </div>
        </div>
    </div>
</div>

<!-- Transfer Ownership Sidebar -->
<div id="transfer_ownership_sidebar" class="hidden h-full flex flex-col bg-[#111b21] w-full sm:w-[30%] sm:min-w-[400px] border-l border-[#313d45] z-[90] absolute right-0 top-0 transition-transform duration-300 transform translate-x-full">
    <!-- Header -->
    <div class="h-[60px] bg-[#111b21] px-4 flex items-center gap-6 shrink-0">
        <button onclick="window.closeTransferOwnershipSidebar()" class="text-[#d1d7db] hover:text-[#e9edef] focus:outline-none transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M20 11H7.8l5.6-5.6L12 4l-8 8 8 8 1.4-1.4L7.8 13H20v-2z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[16px] font-medium">Select new owner</h2>
    </div>

    <!-- Search Bar -->
    <div class="px-4 py-2">
        <div class="bg-[#202c33] rounded-lg flex items-center px-4 py-1.5 border-b-2 border-transparent transition-colors focus-within:bg-[#111b21] focus-within:border-[#00a884]">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="#8696a0"><path d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 0 0 1.256-3.386 5.207 5.207 0 1 0-5.207 5.208 5.183 5.183 0 0 0 3.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-4.8 0a3.6 3.6 0 1 1 0-7.2 3.6 3.6 0 0 1 0 7.2z"></path></svg>
            <input type="text" id="transfer_owner_search" placeholder="Search" class="bg-transparent border-none outline-none text-[#e9edef] text-[15px] ml-4 w-full h-8" onkeyup="window.filterTransferOwner()">
        </div>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] pb-10">
        <div class="px-6 py-4">
            <h3 class="text-[#8696a0] text-[14px]">Admins</h3>
        </div>
        <div id="transfer_owner_list">
            <!-- Appended via JS -->
        </div>
    </div>
</div>

<!-- Invite Admins Modal -->
<div id="invite_admins_modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/70">
    <div class="bg-[#111b21] w-[400px] rounded-2xl flex flex-col overflow-hidden text-[#e9edef] transform transition-transform scale-95 opacity-0 duration-200" id="invite_admins_modal_content" style="max-height: 80vh;">
        <!-- Header -->
        <div class="px-6 py-4 flex items-center gap-4 bg-[#111b21]">
            <button onclick="window.closeInviteAdmins()" class="text-[#8696a0] hover:text-[#d1d7db] focus:outline-none transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M19.1 17.2l-5.3-5.3 5.3-5.3-1.8-1.8-5.3 5.3-5.3-5.3-1.8 1.8 5.3 5.3-5.3 5.3 1.8 1.8 5.3-5.3 5.3 5.3z"></path></svg>
            </button>
            <div>
                <h2 class="text-[#e9edef] text-[18px] font-medium">Invite admins</h2>
                <p id="invite_admins_count" class="text-[#8696a0] text-[13px]">0 of 16 selected</p>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="px-6 pb-2 bg-[#111b21]">
            <div class="bg-[#202c33] rounded-lg flex items-center px-4 py-2 border-b-2 border-transparent transition-colors focus-within:bg-[#111b21] focus-within:border-[#00a884]">
                <button class="text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 0 0 1.256-3.386 5.207 5.207 0 1 0-5.207 5.208 5.183 5.183 0 0 0 3.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-4.8 0a3.6 3.6 0 1 1 0-7.2 3.6 3.6 0 0 1 0 7.2z"></path></svg>
                </button>
                <input type="text" id="invite_admins_search" onkeyup="window.filterAdminContacts(this.value)" placeholder="Search name or number" class="bg-transparent border-none outline-none text-[#e9edef] text-[15px] w-full ml-4 placeholder-[#8696a0]" autocomplete="off">
            </div>
        </div>

        <div class="px-6 py-3 border-b border-[#202c33] bg-[#111b21]">
            <p class="text-[#8696a0] text-[14px] leading-5">Admins can send updates, change the channel profile and see your phone number. <span class="text-[#00a884] hover:underline cursor-pointer" onclick="window.showToast?.('Learn More', 'Opening help center...')">Learn more</span>.</p>
        </div>

        <div class="px-6 py-4">
            <h3 class="text-[#8696a0] text-[14px]">Contacts</h3>
        </div>

        <!-- Contacts List -->
        <div class="flex-1 overflow-y-auto custom-scrollbar px-2 pb-6 relative" id="invite_admins_contacts_list">
            <!-- Populated via JS -->
        </div>

        <!-- Floating Action Button -->
        <div class="absolute bottom-6 right-6">
            <button class="w-[50px] h-[50px] bg-[#00a884] hover:bg-[#00c298] rounded-full flex items-center justify-center shadow-lg transition-colors" onclick="window.sendAdminInvites()">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="#111b21"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path></svg>
            </button>
        </div>
    </div>
</div>

<script>
    window.toggleChannelInfo = async function() {
        const sidebar = document.getElementById('channel_info_sidebar');
        if (sidebar.classList.contains('hidden')) {
            sidebar.classList.remove('hidden');
            sidebar.classList.add('flex');

            // Populate data
            await window.populateChannelInfo();
        } else {
            window.closeChannelInfo();
        }
    };

    window.populateChannelInfo = async function() {
        const ch = window.currentChannel;
        if (!ch) return;
        
        document.getElementById('info_channel_name').innerText = ch.name;
        if(ch.description) {
            document.getElementById('info_channel_desc').innerText = ch.description;
            document.getElementById('info_channel_desc').classList.remove('text-[#00a884]');
            document.getElementById('info_channel_desc').classList.add('text-[#e9edef]');
            document.getElementById('info_channel_desc_header').innerText = 'Description';
        } else {
            document.getElementById('info_channel_desc').innerText = 'Add channel description';
            document.getElementById('info_channel_desc').classList.add('text-[#00a884]');
            document.getElementById('info_channel_desc').classList.remove('text-[#e9edef]');
            document.getElementById('info_channel_desc_header').innerText = 'Add channel description';
        }

        const userId = '{{ auth()->id() }}';
        const isFollowing = ch.followers && ch.followers[userId];
        const isAdmin = ch.admins && ch.admins[userId];
        const amIOwner = ch.created_by == window.myUserId;

        // Hide description section entirely if not admin and no description
        const descSection = document.getElementById('info_channel_desc_section');
        if (!isAdmin && !ch.description) {
            descSection.classList.add('hidden');
        } else {
            descSection.classList.remove('hidden');
        }

        document.getElementById('info_channel_avatar').src = ch.avatar || 'https://ui-avatars.com/api/?name='+encodeURIComponent(ch.name)+'&background=2a3942&color=fff';

        const followersCount = ch.followers ? Object.keys(ch.followers).length : 0;
        document.getElementById('info_channel_followers').innerText = "Channel · " + followersCount + " follower" + (followersCount !== 1 ? 's' : '');
        document.getElementById('info_follower_count_header').innerText = followersCount + " follower" + (followersCount !== 1 ? 's' : '');

        // Created at formatting
        if(ch.created_at) {
            const d = new Date(ch.created_at * 1000);
            // Check if it's today
            const today = new Date();
            const isToday = d.getDate() == today.getDate() && d.getMonth() == today.getMonth() && d.getFullYear() == today.getFullYear();
            const timeStr = d.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            const dateStr = isToday ? "today" : d.toLocaleDateString();
            document.getElementById('info_channel_created_at').innerText = "Created " + dateStr + " at " + timeStr;
        }

        if (isAdmin) {
            document.getElementById('info_avatar_overlay').classList.remove('hidden');
            document.getElementById('info_channel_name_edit_btn').classList.remove('hidden');
            document.getElementById('info_channel_desc_edit_btn').classList.remove('hidden');
            document.getElementById('info_followers_list_actions').classList.remove('hidden');
            document.getElementById('info_insights_section').classList.remove('hidden');
            
            document.getElementById('info_channel_settings_btn').classList.remove('hidden');
            document.getElementById('info_channel_settings_btn').classList.add('flex');
            document.getElementById('info_channel_alerts_btn').classList.remove('hidden');
            document.getElementById('info_channel_alerts_btn').classList.add('flex');
            document.getElementById('info_channel_desc_display').classList.add('cursor-pointer');

            document.getElementById('info_owner_actions').classList.remove('hidden');
            document.getElementById('info_owner_actions').classList.add('flex');
            document.getElementById('info_follower_actions').classList.add('hidden');
            document.getElementById('info_follower_actions').classList.remove('flex');
        } else {
            document.getElementById('info_avatar_overlay').classList.add('hidden');
            document.getElementById('info_channel_name_edit_btn').classList.add('hidden');
            document.getElementById('info_channel_desc_edit_btn').classList.add('hidden');
            // Non-admin can't invite admins
            document.getElementById('info_followers_list_actions').classList.add('hidden');
            document.getElementById('info_insights_section').classList.add('hidden');
            
            document.getElementById('info_channel_settings_btn').classList.add('hidden');
            document.getElementById('info_channel_settings_btn').classList.remove('flex');
            document.getElementById('info_channel_alerts_btn').classList.add('hidden');
            document.getElementById('info_channel_alerts_btn').classList.remove('flex');
            document.getElementById('info_channel_desc_display').classList.remove('cursor-pointer');

            document.getElementById('info_owner_actions').classList.add('hidden');
            document.getElementById('info_owner_actions').classList.remove('flex');
            document.getElementById('info_follower_actions').classList.remove('hidden');
            document.getElementById('info_follower_actions').classList.add('flex');

            if (isFollowing) {
                document.getElementById('info_following_btn_top').classList.remove('hidden');
                document.getElementById('info_following_btn_top').classList.add('flex');
                document.getElementById('info_follow_btn_top').classList.add('hidden');
                document.getElementById('info_follow_btn_top').classList.remove('flex');
            } else {
                document.getElementById('info_following_btn_top').classList.add('hidden');
                document.getElementById('info_following_btn_top').classList.remove('flex');
                document.getElementById('info_follow_btn_top').classList.remove('hidden');
                document.getElementById('info_follow_btn_top').classList.add('flex');
            }
        }
        
        if (amIOwner) {
            document.getElementById('info_transfer_ownership_btn').classList.remove('hidden');
            document.getElementById('info_transfer_ownership_btn').classList.add('flex');
            document.getElementById('info_delete_channel_btn').classList.remove('hidden');
            document.getElementById('info_delete_channel_btn').classList.add('flex');
            document.getElementById('info_dismiss_self_admin_btn').classList.add('hidden');
            document.getElementById('info_dismiss_self_admin_btn').classList.remove('flex');
            
            document.getElementById('info_invite_admins_btn').classList.remove('hidden');
            document.getElementById('info_invite_admins_btn').classList.add('flex');
            document.getElementById('info_invite_followers_btn').classList.add('hidden');
            document.getElementById('info_invite_followers_btn').classList.remove('flex');

            document.getElementById('info_followers_section').classList.remove('hidden');
            document.getElementById('info_unfollow_channel_btn').classList.add('hidden');
            document.getElementById('info_unfollow_channel_btn').classList.remove('flex');
        } else if (isAdmin) {
            document.getElementById('info_transfer_ownership_btn').classList.add('hidden');
            document.getElementById('info_transfer_ownership_btn').classList.remove('flex');
            document.getElementById('info_delete_channel_btn').classList.add('hidden');
            document.getElementById('info_delete_channel_btn').classList.remove('flex');
            document.getElementById('info_dismiss_self_admin_btn').classList.remove('hidden');
            document.getElementById('info_dismiss_self_admin_btn').classList.add('flex');
            
            document.getElementById('info_invite_admins_btn').classList.add('hidden');
            document.getElementById('info_invite_admins_btn').classList.remove('flex');
            document.getElementById('info_invite_followers_btn').classList.remove('hidden');
            document.getElementById('info_invite_followers_btn').classList.add('flex');

            document.getElementById('info_followers_section').classList.remove('hidden');
            document.getElementById('info_unfollow_channel_btn').classList.add('hidden');
            document.getElementById('info_unfollow_channel_btn').classList.remove('flex');
        } else {
            document.getElementById('info_transfer_ownership_btn').classList.add('hidden');
            document.getElementById('info_transfer_ownership_btn').classList.remove('flex');
            document.getElementById('info_delete_channel_btn').classList.add('hidden');
            document.getElementById('info_delete_channel_btn').classList.remove('flex');
            document.getElementById('info_dismiss_self_admin_btn').classList.add('hidden');
            document.getElementById('info_dismiss_self_admin_btn').classList.remove('flex');
            
            document.getElementById('info_invite_admins_btn').classList.add('hidden');
            document.getElementById('info_invite_admins_btn').classList.remove('flex');
            document.getElementById('info_invite_followers_btn').classList.add('hidden');
            document.getElementById('info_invite_followers_btn').classList.remove('flex');

            document.getElementById('info_followers_section').classList.add('hidden');
            if (isFollowing) {
                document.getElementById('info_unfollow_channel_btn').classList.remove('hidden');
                document.getElementById('info_unfollow_channel_btn').classList.add('flex');
            } else {
                document.getElementById('info_unfollow_channel_btn').classList.add('hidden');
                document.getElementById('info_unfollow_channel_btn').classList.remove('flex');
            }
        }

        // Render Followers List
        const followersListEl = document.getElementById('info_followers_list');
        followersListEl.innerHTML = '<div class="text-center text-[#8696a0] py-4 text-sm">Loading followers...</div>'; // loading state

        const followerIds = ch.followers ? Object.keys(ch.followers) : [];
        const pendingAdminIds = ch.pending_admins ? Object.keys(ch.pending_admins) : [];

        followersListEl.innerHTML = ''; // clear

        // Add You (Owner) manually
        if(isAdmin) {
            followersListEl.innerHTML += `
                <div class="px-6 py-3 flex items-center gap-4 hover:bg-[#202c33] transition-colors cursor-pointer group">
                    <div class="w-[40px] h-[40px] rounded-full overflow-hidden shrink-0">
                        <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0 flex items-center justify-between">
                        <div class="flex flex-col">
                            <h4 class="text-[#e9edef] text-[16px]">You</h4>
                            <p class="text-[#8696a0] text-[13px] italic truncate max-w-[200px]">You're not visible to followers</p>
                        </div>
                        <span class="bg-[#00a884]/10 text-[#00a884] text-[12px] px-2 py-0.5 rounded font-medium">${ch.created_by == userId ? 'Owner' : 'Admin'}</span>
                    </div>
                </div>
            `;
        }

        // Render Pending Admins (Invited)
        if(amIOwner && pendingAdminIds.length > 0) {
            try {
                const res = await fetch('/users/details?ids=' + pendingAdminIds.join(','));
                const users = await res.json();

                followersListEl.innerHTML += `
                    <div class="px-6 py-2">
                        <h3 class="text-[#8696a0] text-[14px]">${pendingAdminIds.length} invited</h3>
                    </div>
                `;

                users.forEach(u => {
                    if(u.id == userId && isAdmin) return;
                    followersListEl.innerHTML += `
                        <div class="px-6 py-3 flex items-center gap-4 hover:bg-[#202c33] transition-colors cursor-pointer group">
                            <div class="w-[40px] h-[40px] rounded-full overflow-hidden shrink-0">
                                <img src="${u.avatar || 'https://ui-avatars.com/api/?name='+encodeURIComponent(u.name)+'&background=random&color=fff'}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0 flex items-center justify-between">
                                <div class="flex flex-col">
                                    <h4 class="text-[#e9edef] text-[16px]">${u.name}</h4>
                                    <p class="text-[#8696a0] text-[13px] font-mono tracking-tight truncate max-w-[200px]">${u.about || u.phone || ''}</p>
                                </div>
                                <div class="flex items-center gap-2 relative">
                                    <span class="bg-[#00a884]/10 text-[#00a884] text-[12px] px-2 py-0.5 rounded font-medium">Invited</span>
                                    ${isAdmin ? `
                                    <button onclick="event.stopPropagation(); window.toggleRevokeMenu('${u.id}')" class="text-[#8696a0] hover:text-[#d1d7db] p-1 focus:outline-none">
                                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M7.4 8l4.6 4.6L16.6 8 18 9.4l-6 6-6-6L7.4 8z"></path></svg>
                                    </button>
                                    <!-- Dropdown Menu -->
                                    <div id="revoke_menu_${u.id}" class="hidden absolute right-0 top-8 w-[200px] bg-[#233138] rounded-lg shadow-xl border border-[#313d45] z-[80] py-2">
                                        <div class="px-4 py-2 text-[#e9edef] hover:bg-[#182229] cursor-pointer text-[14.5px]" onclick="event.stopPropagation(); window.showRevokeModal('${u.id}', this.dataset.name)" data-name="${(u.name||'').replace(/&/g, '&amp;').replace(/\"/g, '&quot;')}">Revoke invite</div>
                                        <div class="px-4 py-2 text-[#e9edef] hover:bg-[#182229] cursor-pointer text-[14.5px]" onclick="event.stopPropagation(); window.showSecurityCodeModal(this.dataset.name)" data-name="${(u.name||'').replace(/&/g, '&amp;').replace(/\"/g, '&quot;')}">Verify security code</div>
                                    </div>
                                    ` : ''}
                                </div>
                            </div>
                        </div>
                    `;
                });
            } catch(e) {
                console.error('Failed to load pending admins', e);
            }
        }

        // Render Followers
        if(followerIds.length > 0) {
            try {
                let idsToFetch = followerIds;
                if (!amIOwner && isAdmin) {
                    idsToFetch = ch.admins ? Object.keys(ch.admins) : [];
                    if (ch.created_by && !idsToFetch.includes(ch.created_by)) {
                        idsToFetch.push(ch.created_by);
                    }
                } else if (!isAdmin) {
                    idsToFetch = [];
                }

                if(idsToFetch.length > 0) {
                    const res = await fetch('/users/details?ids=' + idsToFetch.join(','));
                    const users = await res.json();

                    // Count text for followers if owner
                    if(amIOwner && (pendingAdminIds.length > 0 || followerIds.length > 0)) {
                        followersListEl.innerHTML += `
                            <div class="px-6 py-2 mt-2 border-t border-[#202c33]">
                                <h3 class="text-[#8696a0] text-[14px]">${followerIds.length} follower${followerIds.length !== 1 ? 's' : ''}</h3>
                            </div>
                        `;
                    }

                users.forEach(u => {
                    // Skip if somehow user is in followers list and is admin (already rendered)
                    if(u.id == userId && isAdmin) return;
                    if(pendingAdminIds.includes(u.id.toString())) return; // skip if already rendered as pending

                    const isMe = u.id == userId;
                    const isThisUserAdmin = ch.admins && ch.admins[u.id];
                    const amIOwner = ch.created_by == window.myUserId;
                    const isThisUserOwner = ch.created_by == u.id;
                    
                    let subtitle = u.about || '';
                    if(isMe) subtitle = "You're not visible to followers";

                    followersListEl.innerHTML += `
                        <div class="px-6 py-3 flex items-center gap-4 hover:bg-[#202c33] transition-colors cursor-pointer group">
                            <div class="w-[40px] h-[40px] rounded-full overflow-hidden shrink-0">
                                <img src="${u.avatar || 'https://ui-avatars.com/api/?name='+encodeURIComponent(u.name)+'&background=random&color=fff'}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0 flex items-center justify-between">
                                <div class="flex flex-col">
                                    <h4 class="text-[#e9edef] text-[16px]">${isMe ? 'You' : u.name}</h4>
                                    <p class="text-[#8696a0] text-[13px] ${isMe ? 'italic' : 'font-mono tracking-tight'} truncate max-w-[200px]">${subtitle}</p>
                                </div>
                                <div class="flex items-center gap-2 relative">
                                    ${isThisUserAdmin ? '<span class="bg-[#00a884]/10 text-[#00a884] text-[12px] px-2 py-0.5 rounded font-medium">' + (isThisUserOwner ? 'Owner' : 'Admin') + '</span>' : ''}
                                    ${(!isMe && isAdmin) ? `
                                    <button onclick="event.stopPropagation(); window.toggleRevokeMenu('${u.id}')" class="text-[#8696a0] hover:text-[#d1d7db] p-1 focus:outline-none">
                                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M7.4 8l4.6 4.6L16.6 8 18 9.4l-6 6-6-6L7.4 8z"></path></svg>
                                    </button>
                                    <!-- Dropdown Menu -->
                                    <div id="revoke_menu_${u.id}" class="hidden absolute right-0 top-8 w-[200px] bg-[#233138] rounded-lg shadow-xl border border-[#313d45] z-[80] py-2">
                                        ${(amIOwner && isThisUserAdmin && !isThisUserOwner) ? `
                                            <div class="px-4 py-2 text-[#e9edef] hover:bg-[#182229] cursor-pointer text-[14.5px]" onclick="event.stopPropagation(); window.dismissAdmin('${u.id}', this.dataset.name)" data-name="${(u.name||'').replace(/&/g, '&amp;').replace(/\"/g, '&quot;')}">Dismiss as admin</div>
                                            <div class="px-4 py-2 text-[#e9edef] hover:bg-[#182229] cursor-pointer text-[14.5px]" onclick="event.stopPropagation(); window.transferOwnership('${u.id}', this.dataset.name)" data-name="${(u.name||'').replace(/&/g, '&amp;').replace(/\"/g, '&quot;')}">Transfer ownership</div>
                                        ` : ''}
                                        ${(amIOwner && !isThisUserAdmin && !isThisUserOwner) ? `
                                            <div class="px-4 py-2 text-[#e9edef] hover:bg-[#182229] cursor-pointer text-[14.5px]" onclick="event.stopPropagation(); window.inviteFollowerAsAdmin('${u.id}', this.dataset.name)" data-name="${(u.name||'').replace(/&/g, '&amp;').replace(/\"/g, '&quot;')}">Invite as admin</div>
                                        ` : ''}
                                        <div class="px-4 py-2 text-[#e9edef] hover:bg-[#182229] cursor-pointer text-[14.5px]" onclick="event.stopPropagation(); window.showSecurityCodeModal(this.dataset.name)" data-name="${(u.name||'').replace(/&/g, '&amp;').replace(/\"/g, '&quot;')}">Verify security code</div>
                                    </div>
                                    ` : ''}
                                </div>
                            </div>
                        </div>
                    `;
                });
                }
            } catch(e) {
                followersListEl.innerHTML += '<div class="text-center text-[#ea005e] py-4 text-sm">Failed to load followers.</div>';
            }
        } else if (!isAdmin) {
            followersListEl.innerHTML = '<div class="text-center text-[#8696a0] py-4 text-sm">No followers yet.</div>';
        }
    };

    window.closeChannelInfo = function() {
        const sidebar = document.getElementById('channel_info_sidebar');
        sidebar.classList.add('hidden');
        sidebar.classList.remove('flex');
        window.closeChannelNotifications(); // also close any child panel
        window.closeChannelAlerts();
        window.closeChannelLink();
        window.closeTransferOwnershipSidebar();
    };

    window.openTransferOwnershipSidebar = async function() {
        const sidebar = document.getElementById('transfer_ownership_sidebar');
        sidebar.classList.remove('hidden');
        void sidebar.offsetWidth;
        sidebar.classList.remove('translate-x-full');
        sidebar.classList.add('translate-x-0');

        const listEl = document.getElementById('transfer_owner_list');
        listEl.innerHTML = '<div class="text-center text-[#8696a0] py-4 text-sm">Loading admins...</div>';
        
        const ch = window.currentChannel;
        if(!ch || !ch.admins) return;
        const adminIds = Object.keys(ch.admins).filter(id => id != window.myUserId);
        
        if (adminIds.length === 0) {
            listEl.innerHTML = '<div class="text-center text-[#8696a0] py-4 text-sm">No other admins.</div>';
            return;
        }

        try {
            const res = await fetch('/users/details?ids=' + adminIds.join(','));
            const users = await res.json();
            listEl.innerHTML = '';
            
            users.forEach(u => {
                listEl.innerHTML += `
                    <div class="px-6 py-3 flex items-center gap-4 hover:bg-[#202c33] transition-colors cursor-pointer group" onclick="window.transferOwnership('${u.id}', this.dataset.name)" data-name="${(u.name||'').replace(/&/g, '&amp;').replace(/\"/g, '&quot;')}">
                        <div class="w-[40px] h-[40px] rounded-full overflow-hidden shrink-0">
                            <img src="${u.avatar || 'https://ui-avatars.com/api/?name='+encodeURIComponent(u.name)+'&background=random&color=fff'}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0 flex items-center justify-between">
                            <div class="flex flex-col">
                                <h4 class="text-[#e9edef] text-[16px]">${u.name}</h4>
                                <p class="text-[#8696a0] text-[13px] font-mono tracking-tight truncate max-w-[200px]">${u.about || u.phone || ''}</p>
                            </div>
                        </div>
                    </div>
                `;
            });
        } catch(e) {
            listEl.innerHTML = '<div class="text-center text-[#ea005e] py-4 text-sm">Failed to load admins.</div>';
        }
    };

    window.closeTransferOwnershipSidebar = function() {
        const sidebar = document.getElementById('transfer_ownership_sidebar');
        if(!sidebar) return;
        sidebar.classList.remove('translate-x-0');
        sidebar.classList.add('translate-x-full');
        setTimeout(() => {
            sidebar.classList.add('hidden');
        }, 300);
    };

    window.filterTransferOwner = function() {
        const val = document.getElementById('transfer_owner_search').value.toLowerCase();
        const items = document.getElementById('transfer_owner_list').querySelectorAll('.group');
        items.forEach(item => {
            const name = item.querySelector('h4').innerText.toLowerCase();
            if (name.includes(val)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    };

    window.openChannelNotifications = function() {
        const sidebar = document.getElementById('channel_notifications_sidebar');
        if (sidebar.classList.contains('hidden')) {
            sidebar.classList.remove('hidden');
            void sidebar.offsetWidth;
            sidebar.classList.remove('translate-x-full');
            sidebar.classList.add('translate-x-0');

            // Load mute settings
            const ch = window.currentChannel;
            if(ch && window.firebaseGet && window.firebaseRef) {
                window.firebaseGet(window.firebaseRef(window.db, `users/${window.myUserId}/channel_settings/${ch.id}`)).then(snapshot => {
                    if (snapshot.exists()) {
                        const settings = snapshot.val();
                        document.getElementById('mute_follower_notifications').checked = !!settings.mute_follower;
                        document.getElementById('mute_admin_notifications').checked = !!settings.mute_admin;
                    } else {
                        document.getElementById('mute_follower_notifications').checked = false;
                        document.getElementById('mute_admin_notifications').checked = false;
                    }
                });
            }
        }
    };

    window.forwardChannel = function() {
        if (window.openForwardModal) {
            window.isForwardingChannel = true;
            window.forwardChannelText = "Check out this channel: " + window.location.href;
            window.openForwardModal(false);
        } else {
            if(window.showToast) window.showToast('Forward', 'Select a chat to forward to.');
        }
    };

    window.toggleChannelSearchDrawer = function() {
        const drawer = document.getElementById('channel_search_drawer');
        if (!drawer) return;

        const isHidden = drawer.classList.contains('hidden');
        if (isHidden) {
            drawer.classList.remove('hidden');
            drawer.classList.add('flex');
            document.getElementById('channel_search_input')?.focus();
        } else {
            drawer.classList.add('hidden');
            drawer.classList.remove('flex');
        }
    };

    window.searchChannelMessages = function() {
        window.toggleChannelSearchDrawer();
        if (window.closeChannelInfo) {
            window.closeChannelInfo();
        }
    };

    window.performChannelSearch = function() {
        const queryVal = document.getElementById('channel_search_input').value.trim().toLowerCase();
        const resultsEl = document.getElementById('channel_search_results');
        if (!resultsEl) return;

        if (!queryVal) {
            resultsEl.innerHTML = `<div class="text-[#8696a0] text-center text-sm py-4">Type to search messages in channel</div>`;
            return;
        }

        resultsEl.innerHTML = `<div class="text-[#8696a0] text-center text-sm py-4">No results found for "${queryVal}"</div>`;
    };

    window.closeChannelNotifications = function() {
        const sidebar = document.getElementById('channel_notifications_sidebar');
        sidebar.classList.remove('translate-x-0');
        sidebar.classList.add('translate-x-full');
        setTimeout(() => {
            sidebar.classList.add('hidden');
        }, 300);
    };

    window.openChannelAlerts = function() {
        const sidebar = document.getElementById('channel_alerts_sidebar');
        if (sidebar.classList.contains('hidden')) {
            sidebar.classList.remove('hidden');
            void sidebar.offsetWidth;
            sidebar.classList.remove('translate-x-full');
            sidebar.classList.add('translate-x-0');
        }
    };

    window.closeChannelAlerts = function() {
        const sidebar = document.getElementById('channel_alerts_sidebar');
        sidebar.classList.remove('translate-x-0');
        sidebar.classList.add('translate-x-full');
        setTimeout(() => {
            sidebar.classList.add('hidden');
        }, 300);
    };

    window.toggleChannelMute = function(type, isMuted) {
        const ch = window.currentChannel;
        if(ch) {
            const updates = {};
            if (type === 'follower') {
                updates[`mute_follower`] = isMuted;
                window.showToast?.('Notifications', isMuted ? 'Follower notifications muted' : 'Follower notifications unmuted');
            } else if (type === 'admin') {
                updates[`mute_admin`] = isMuted;
                window.showToast?.('Notifications', isMuted ? 'Admin notifications muted' : 'Admin notifications unmuted');
            }
            update(ref(db, `users/${window.myUserId}/channel_settings/${ch.id}`), updates);
        }
    };

    window.openPublicChannelModal = function() {
        const modal = document.getElementById('public_channel_modal');
        const modalContent = document.getElementById('public_channel_modal_content');
        if(window.currentChannel) {
            document.getElementById('public_channel_modal_name').innerText = window.currentChannel.name;
        }
        modal.classList.remove('hidden');
        // trigger animation
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    };

    window.closePublicChannelModal = function() {
        const modal = document.getElementById('public_channel_modal');
        const modalContent = document.getElementById('public_channel_modal_content');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    };

    window.selectedAdminCount = 0;
    window.selectedAdminIds = [];

    window.toggleAdminSelection = function(el, uid) {
        const checkbox = el.querySelector('.admin-checkbox');
        const isSelected = checkbox.classList.contains('bg-[#00a884]');

        if (isSelected) {
            checkbox.classList.remove('bg-[#00a884]', 'border-transparent');
            checkbox.classList.add('border-[#8696a0]');
            checkbox.innerHTML = '';
            window.selectedAdminCount--;
            window.selectedAdminIds = window.selectedAdminIds.filter(id => id !== uid);
        } else {
            checkbox.classList.remove('border-[#8696a0]');
            checkbox.classList.add('bg-[#00a884]', 'border-transparent');
            checkbox.innerHTML = '<svg viewBox="0 0 24 24" width="16" height="16" fill="#111b21"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path></svg>';
            window.selectedAdminCount++;
            window.selectedAdminIds.push(uid);
        }

        const total = window.totalInviteableAdmins || 0;
        document.getElementById('invite_admins_count').innerText = `${window.selectedAdminCount} of ${total} selected`;
    };

    window.filterAdminContacts = function(query) {
        query = query.toLowerCase();
        const items = document.querySelectorAll('#invite_admins_contacts_list .contact-item');
        items.forEach(item => {
            const name = item.getAttribute('data-name').toLowerCase();
            const phone = item.getAttribute('data-phone').toLowerCase();
            if (name.includes(query) || phone.includes(query)) {
                item.classList.remove('hidden');
                item.classList.add('flex');
            } else {
                item.classList.add('hidden');
                item.classList.remove('flex');
            }
        });
    };

    window.openInviteAdmins = async function() {
        // Reset selections
        window.selectedAdminCount = 0;
        window.selectedAdminIds = [];
        document.getElementById('invite_admins_count').innerText = `0 selected`;
        document.getElementById('invite_admins_search').value = '';

        const contactsList = document.getElementById('invite_admins_contacts_list');
        contactsList.innerHTML = '<div class="p-4 text-center text-[#8696a0] text-sm">Loading contacts...</div>';

        const modal = document.getElementById('invite_admins_modal');
        const modalContent = document.getElementById('invite_admins_modal_content');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);

        try {
            const res = await fetch('/users/details?all=1');
            const users = await res.json();

            let html = '';
            let count = 0;

            const currentAdmins = window.currentChannel && window.currentChannel.admins ? window.currentChannel.admins : {};
            const pendingAdmins = window.currentChannel && window.currentChannel.pending_admins ? window.currentChannel.pending_admins : {};

            users.forEach(user => {
                if (user.id == window.myUserId) return;
                if (currentAdmins[user.id]) return;
                if (pendingAdmins[user.id]) return;

                count++;
                html += `
                    <div class="contact-item px-4 py-3 flex items-center gap-4 cursor-pointer hover:bg-[#202c33] rounded-lg group" data-name="${user.name}" data-phone="${user.phone || ''}" onclick="window.toggleAdminSelection(this, '${user.id}')">
                        <div class="admin-checkbox w-[20px] h-[20px] border border-[#8696a0] rounded-[4px] flex items-center justify-center shrink-0 transition-colors"></div>
                        <div class="w-[40px] h-[40px] rounded-full bg-[#6b7c85] flex items-center justify-center overflow-hidden shrink-0">
                            <img src="${user.avatar || 'https://ui-avatars.com/api/?name='+encodeURIComponent(user.name)+'&background=random&color=fff'}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 flex flex-col justify-center">
                            <span class="text-[#e9edef] text-[16px]">${user.name}</span>
                            <span class="text-[#8696a0] text-[13px] font-mono">${user.about || user.phone || ''}</span>
                        </div>
                    </div>
                `;
            });

            if (count === 0) {
                html = '<div class="p-4 text-center text-[#8696a0] text-sm">No contacts available to invite.</div>';
            }

            contactsList.innerHTML = html;
            window.totalInviteableAdmins = count;
            document.getElementById('invite_admins_count').innerText = `0 of ${count} selected`;
        } catch(e) {
            contactsList.innerHTML = '<div class="p-4 text-center text-[#ea005e] text-sm">Failed to load contacts.</div>';
        }
    };

    window.sendAdminInvites = function() {
        if (!window.selectedAdminIds || window.selectedAdminIds.length === 0) return;
        if (!window.currentChannel) return;

        const ch = window.currentChannel;
        const updates = {};

        window.selectedAdminIds.forEach(uid => {
            updates[`channels/${ch.id}/pending_admins/${uid}`] = true;

            // Send chat message
            const minId = Math.min(window.myUserId, uid);
            const maxId = Math.max(window.myUserId, uid);
            const chatId = `chat_${minId}_${maxId}`;

            const msgData = {
                sender_id: String(window.myUserId),
                text: "WhatsApp channel admin invite",
                type: 'channel_invite',
                channel_id: ch.id,
                channel_name: ch.name,
                channel_avatar: ch.avatar || '',
                time: Date.now() / 1000,
                status: 'sent'
            };

            if (window.firebasePush) {
                const msgRef = window.firebasePush(window.firebaseRef(window.db, `chats/${chatId}/messages`));
                updates[`chats/${chatId}/messages/${msgRef.key}`] = msgData;

                // Update chat metadata so it appears in chat list
                updates[`users/${minId}/chats/${chatId}`] = true;
                updates[`users/${maxId}/chats/${chatId}`] = true;
                updates[`chats/${chatId}/last_message`] = "WhatsApp channel admin invite";
                updates[`chats/${chatId}/updated_at`] = Math.floor(Date.now() / 1000);
                updates[`chats/${chatId}/participants/${minId}`] = true;
                updates[`chats/${chatId}/participants/${maxId}`] = true;
            }
        });

        window.firebaseUpdate(window.firebaseRef(window.db, '/'), updates).then(() => {
            window.showToast?.('Invites Sent', 'Admin invites sent successfully');
            window.closeInviteAdmins();
        });
    };

    window.closeInviteAdmins = function() {
        const modal = document.getElementById('invite_admins_modal');
        const modalContent = document.getElementById('invite_admins_modal_content');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    };

    window.openChannelLinkSidebar = function() {
        const sidebar = document.getElementById('channel_link_sidebar');
        if (sidebar.classList.contains('hidden')) {
            sidebar.classList.remove('hidden');
            void sidebar.offsetWidth;
            sidebar.classList.remove('translate-x-full');
            sidebar.classList.add('translate-x-0');

            // set dynamically
            if(window.currentChannel) {
                document.getElementById('channel_link_name').innerText = window.currentChannel.name;
                document.getElementById('channel_link_url').innerText = `${window.location.origin}/channel/${window.currentChannel.id}`;
            }
        }
    };

    window.closeChannelLink = function() {
        const sidebar = document.getElementById('channel_link_sidebar');
        if(sidebar) {
            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('translate-x-full');
            setTimeout(() => {
                sidebar.classList.add('hidden');
            }, 300);
        }
    };

    window.copyChannelLink = function() {
        if(window.currentChannel) {
            navigator.clipboard.writeText(`${window.location.origin}/channel/${window.currentChannel.id}`);
            window.showToast?.('Link Copied', 'Channel link copied to clipboard');
        }
    };

    window.triggerEditChannelAvatar = function() {
        const ch = window.currentChannel;
        if(ch && ch.admins && ch.admins[window.myUserId]) {
            document.getElementById('edit_channel_avatar_input').click();
        }
    };

    window.handleEditChannelAvatar = async function(input) {
        const ch = window.currentChannel;
        if(!ch || !input.files || !input.files[0]) return;

        const file = input.files[0];
        const formData = new FormData();
        formData.append('avatar', file);

        try {
            const uploadRes = await fetch('/channel/upload-avatar', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': window.csrf },
                body: formData
            });
            const jsonRes = await uploadRes.json();
            if(jsonRes.status) {
                await update(ref(db, `channels/${ch.id}`), { avatar: jsonRes.url });
                document.getElementById('info_channel_avatar').src = jsonRes.url;
                document.getElementById('current_channel_avatar').src = jsonRes.url;
            } else {
                alert("Failed to upload avatar");
            }
        } catch (e) {
            alert("Upload error");
        }
    };

    window.startEditChannelName = function() {
        const ch = window.currentChannel;
        if(ch && ch.admins && ch.admins[window.myUserId]) {
            document.getElementById('info_channel_name_display').classList.add('hidden');
            document.getElementById('info_channel_name_display').classList.remove('flex');
            document.getElementById('info_channel_name_edit_mode').classList.remove('hidden');
            document.getElementById('info_channel_name_edit_mode').classList.add('flex');

            const input = document.getElementById('info_channel_name_input');
            input.value = ch.name;
            input.focus();

            // Allow Enter key to save
            input.onkeydown = function(e) {
                if(e.key === 'Enter') {
                    e.preventDefault();
                    window.saveChannelName();
                } else if(e.key === 'Escape') {
                    window.cancelEditChannelName();
                }
            };
        }
    };

    window.cancelEditChannelName = function() {
        document.getElementById('info_channel_name_edit_mode').classList.add('hidden');
        document.getElementById('info_channel_name_edit_mode').classList.remove('flex');
        document.getElementById('info_channel_name_display').classList.remove('hidden');
        document.getElementById('info_channel_name_display').classList.add('flex');
    };

    window.saveChannelName = function() {
        const ch = window.currentChannel;
        if(ch && ch.admins && ch.admins[window.myUserId]) {
            const input = document.getElementById('info_channel_name_input');
            const newName = input.value.trim();
            if(newName && newName !== "") {
                update(ref(db, `channels/${ch.id}`), { name: newName }).then(() => {
                    document.getElementById('info_channel_name').innerText = newName;
                    document.getElementById('current_channel_name').innerText = newName;
                    window.currentChannel.name = newName; // locally update
                    window.cancelEditChannelName();
                });
            } else {
                window.cancelEditChannelName();
            }
        }
    };

    window.startEditChannelDescription = function() {
        const ch = window.currentChannel;
        if(!ch || !ch.admins || !ch.admins[window.myUserId]) return;

        document.getElementById('info_channel_desc_display').classList.add('hidden');
        document.getElementById('info_channel_desc_edit_mode').classList.remove('hidden');
        document.getElementById('info_channel_desc_edit_mode').classList.add('flex');

        const input = document.getElementById('info_channel_desc_input');
        input.value = ch.description || '';
        input.focus();
        // Trigger auto resize
        input.style.height = '';
        input.style.height = input.scrollHeight + 'px';

        // Allow Escape to cancel
        input.onkeydown = function(e) {
            if(e.key === 'Escape') {
                window.cancelEditChannelDescription();
            }
        };
    };

    window.cancelEditChannelDescription = function() {
        document.getElementById('info_channel_desc_edit_mode').classList.add('hidden');
        document.getElementById('info_channel_desc_edit_mode').classList.remove('flex');
        document.getElementById('info_channel_desc_display').classList.remove('hidden');
        document.getElementById('info_channel_desc_display').classList.add('flex');
    };

    window.saveChannelDescription = function() {
        const ch = window.currentChannel;
        if(ch && ch.admins && ch.admins[window.myUserId]) {
            const input = document.getElementById('info_channel_desc_input');
            const newDesc = input.value.trim();
            update(ref(db, `channels/${ch.id}`), { description: newDesc }).then(() => {
                const descEl = document.getElementById('info_channel_desc');
                descEl.innerText = newDesc || 'Add channel description';
                if(newDesc) {
                    descEl.classList.remove('text-[#00a884]');
                    descEl.classList.add('text-[#e9edef]');
                } else {
                    descEl.classList.add('text-[#00a884]');
                    descEl.classList.remove('text-[#e9edef]');
                }
                window.currentChannel.description = newDesc; // locally update
                window.cancelEditChannelDescription();
            });
        }
    };

    window.deleteChannel = function() {
        const ch = window.currentChannel;
        if(ch && ch.admins && ch.admins[window.myUserId]) {
            window.showCustomConfirmModal("Are you sure you want to delete this channel? This action cannot be undone.", function() {
                remove(ref(window.db, `channels/${ch.id}`)).then(() => {
                    if (window.showToast) window.showToast("Channel Deleted", "Channel deleted successfully.");
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }).catch(err => {
                    if (window.showToast) window.showToast("Error", "Failed to delete channel.", true);
                });
            });
        }
    };

    window.dismissSelfAdmin = function() {
        const ch = window.currentChannel;
        if(ch) {
            window.showCustomConfirmModal("Are you sure you want to dismiss yourself as admin?", function() {
                remove(ref(window.db, `channels/${ch.id}/admins/${window.myUserId}`)).then(() => {
                    if (window.showToast) window.showToast("Dismissed", "You are no longer an admin.");
                });
            });
        }
    };

    window.unfollowChannel = function() {
        const ch = window.currentChannel;
        if(ch) {
            window.showCustomConfirmModal(`Are you sure you want to unfollow ${ch.name}?`, function() {
                remove(ref(window.db, `channels/${ch.id}/followers/${window.myUserId}`)).then(() => {
                    import('https://www.gstatic.com/firebasejs/10.7.1/firebase-database.js').then((module) => {
                        const runTransaction = module.runTransaction;
                        runTransaction(ref(window.db, `channels/${ch.id}/followers_count`), (currentData) => {
                            return (currentData || 0) > 0 ? currentData - 1 : 0;
                        }).then(() => {
                            if (window.showToast) window.showToast("Unfollowed", `You unfollowed ${ch.name}.`);
                            setTimeout(() => { window.location.reload(); }, 1000);
                        });
                    });
                });
            });
        }
    };

    window.reportChannel = function() {
        const ch = window.currentChannel;
        if(ch) {
            window.showCustomConfirmModal(`Are you sure you want to report ${ch.name}?`, function() {
                if (window.showToast) window.showToast("Report Sent", "This channel has been reported.");
            });
        }
    };
    window.toggleRevokeMenu = function(uid) {
        document.querySelectorAll('[id^="revoke_menu_"]').forEach(el => {
            if(el.id !== `revoke_menu_${uid}`) {
                el.classList.add('hidden');
            }
        });
        const menu = document.getElementById(`revoke_menu_${uid}`);
        if(menu) menu.classList.toggle('hidden');
    };

    window.closeAllRevokeMenus = function() {
        document.querySelectorAll('[id^="revoke_menu_"]').forEach(el => el.classList.add('hidden'));
    };

    // Close dropdowns if clicked outside
    document.addEventListener('click', function(e) {
        if(!e.target.closest('[id^="revoke_menu_"]') && !e.target.closest('button[onclick*="toggleRevokeMenu"]')) {
            window.closeAllRevokeMenus();
        }
    });

    window.showRevokeModal = function(uid, name) {
        window.closeAllRevokeMenus();
        window.revokeTargetUid = uid;

        const modal = document.getElementById('revoke_invite_modal');
        const modalContent = document.getElementById('revoke_invite_modal_content');
        const ch = window.currentChannel;

        if (ch) {
            document.getElementById('revoke_modal_channel_name').innerText = ch.name;
            document.getElementById('revoke_modal_avatar').src = ch.avatar || 'https://ui-avatars.com/api/?name='+encodeURIComponent(ch.name)+'&background=2a3942&color=fff';
        }

        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    };

    window.closeRevokeModal = function() {
        const modal = document.getElementById('revoke_invite_modal');
        const modalContent = document.getElementById('revoke_invite_modal_content');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    };

    window.confirmRevokeInvite = function() {
        if (!window.revokeTargetUid || !window.currentChannel) return;
        const ch = window.currentChannel;
        const updates = {};
        updates[`channels/${ch.id}/pending_admins/${window.revokeTargetUid}`] = null;

        window.firebaseUpdate(window.firebaseRef(window.db, '/'), updates).then(() => {
            window.closeRevokeModal();
        });
    };

    window.showCustomConfirmModal = function(text, onConfirm) {
        const modal = document.getElementById('custom_confirm_modal');
        const modalContent = document.getElementById('custom_confirm_modal_content');
        
        document.getElementById('custom_confirm_modal_text').innerText = text;
        
        const oldBtn = document.getElementById('custom_confirm_modal_ok_btn');
        const newBtn = oldBtn.cloneNode(true);
        oldBtn.parentNode.replaceChild(newBtn, oldBtn);
        
        newBtn.onclick = function() {
            window.closeCustomConfirmModal();
            if (typeof onConfirm === 'function') onConfirm();
        };

        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    };

    window.closeCustomConfirmModal = function() {
        const modal = document.getElementById('custom_confirm_modal');
        const modalContent = document.getElementById('custom_confirm_modal_content');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    };

    window.dismissAdmin = function(userId, userName) {
        window.closeAllRevokeMenus();
        window.showCustomConfirmModal(`Are you sure you want to dismiss ${userName} as admin?`, function() {
            const chId = window.currentChannel.id;
            const updates = {};
            updates[`channels/${chId}/admins/${userId}`] = null;
            updates[`channels/${chId}/followers/${userId}`] = true; // Demoted to follower

            window.firebaseUpdate(window.firebaseRef(window.db, '/'), updates).then(() => {
                if (window.showToast) window.showToast('Admin Dismissed', `${userName} is no longer an admin.`);
            });
        });
    };

    window.transferOwnership = function(userId, userName) {
        window.closeAllRevokeMenus();
        window.showCustomConfirmModal(`Are you sure you want to transfer ownership to ${userName}? You will no longer be an owner.`, function() {
            const chId = window.currentChannel.id;
            const updates = {};
            updates[`channels/${chId}/created_by`] = userId;
            // Optionally demote self, but for now we just change created_by.
            // In WhatsApp, old owner usually becomes a regular admin.
            
            window.firebaseUpdate(window.firebaseRef(window.db, '/'), updates).then(() => {
                if (window.showToast) window.showToast('Ownership Transferred', `${userName} is now the primary owner.`);
                window.closeChannelInfo();
            });
        });
    };

    window.inviteFollowerAsAdmin = function(userId, userName) {
        window.closeAllRevokeMenus();
        window.showCustomConfirmModal(`Are you sure you want to invite ${userName} to be an admin?`, function() {
            const chId = window.currentChannel.id;
            const updates = {};
            updates[`channels/${chId}/pending_admins/${userId}`] = true;
            
            // Send chat message
            const minId = Math.min(window.myUserId, userId);
            const maxId = Math.max(window.myUserId, userId);
            const chatId = minId + '_' + maxId;
            
            const msgData = {
                sender_id: String(window.myUserId),
                text: "WhatsApp channel admin invite",
                type: 'channel_invite',
                channel_id: String(chId),
                channel_name: window.currentChannel.name,
                channel_avatar: window.currentChannel.avatar || '',
                time: Date.now() / 1000,
                status: 'sent'
            };
            
            if (window.firebasePush) {
                const msgRef = window.firebasePush(window.firebaseRef(window.db, `chats/${chatId}/messages`));
                updates[`chats/${chatId}/messages/${msgRef.key}`] = msgData;
                
                updates[`users/${minId}/chats/${chatId}`] = true;
                updates[`users/${maxId}/chats/${chatId}`] = true;
                updates[`chats/${chatId}/participants/${minId}`] = true;
                updates[`chats/${chatId}/participants/${maxId}`] = true;
            }
            
            window.firebaseUpdate(window.firebaseRef(window.db, '/'), updates).then(() => {
                if (window.showToast) window.showToast('Invite Sent', `Admin invite sent to ${userName}.`);
            });
        });
    };

    window.showSecurityCodeModal = function(name) {
        window.closeAllRevokeMenus();
        const modal = document.getElementById('security_code_modal');
        const modalContent = document.getElementById('security_code_modal_content');

        document.getElementById('security_code_contact_name').innerText = name;
        document.getElementById('security_code_contact_name_desc').innerText = name;

        // Generate dynamic 60-digit security code (12 blocks of 5 digits)
        let html = '';
        for(let row=0; row<3; row++) {
            let rowText = '';
            for(let col=0; col<4; col++) {
                let block = Math.floor(Math.random() * 100000).toString().padStart(5, '0');
                rowText += block + (col < 3 ? ' ' : '');
            }
            html += `<div>${rowText}</div>`;
        }
        document.getElementById('security_code_numbers').innerHTML = html;

        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    };

    window.closeSecurityCodeModal = function() {
        const modal = document.getElementById('security_code_modal');
        const modalContent = document.getElementById('security_code_modal_content');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    };
</script>

<!-- Revoke Invite Modal -->
<div id="revoke_invite_modal" class="hidden fixed inset-0 bg-black/80 z-[100] flex items-center justify-center p-4">
    <div id="revoke_invite_modal_content" class="bg-[#3b4a54] rounded-2xl w-full max-w-sm overflow-hidden shadow-2xl transform scale-95 opacity-0 transition-all duration-200">
        <div class="px-6 pt-6 pb-8 flex flex-col items-center">
            <div class="w-16 h-16 rounded-full overflow-hidden mb-4 shrink-0 bg-[#202c33]">
                <img id="revoke_modal_avatar" src="" class="w-full h-full object-cover">
            </div>
            <h3 id="revoke_modal_channel_name" class="text-[#e9edef] text-[20px] font-medium text-center leading-6">Siddharth Channel</h3>
            <p class="text-[#8696a0] text-[15px] mt-2">Channel admin invite</p>
        </div>

        <div class="px-6 py-4 flex gap-4 bg-[#202c33] justify-end border-t border-[#313d45]">
            <button onclick="window.closeRevokeModal()" class="text-[#00a884] hover:bg-[#111b21] px-5 py-2.5 rounded-full font-medium transition-colors text-[14px]">Cancel</button>
            <button onclick="window.confirmRevokeInvite()" class="bg-[#00a884] hover:bg-[#00c298] text-[#111b21] px-5 py-2.5 rounded-full font-medium transition-colors text-[14px]">Revoke invite</button>
        </div>
    </div>
</div>

<!-- Verify Security Code Modal -->
<div id="security_code_modal" class="hidden fixed inset-0 bg-black/80 z-[100] flex items-center justify-center p-4">
    <div id="security_code_modal_content" class="bg-[#111b21] rounded-2xl w-full max-w-sm overflow-hidden shadow-2xl transform scale-95 opacity-0 transition-all duration-200">
        <!-- Header -->
        <div class="px-4 py-3 flex items-center gap-4">
            <button onclick="window.closeSecurityCodeModal()" class="text-[#e9edef] hover:text-[#d1d7db] transition-colors focus:outline-none">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M20 11H7.8l5.6-5.6L12 4l-8 8 8 8 1.4-1.4L7.8 13H20v-2z"></path></svg>
            </button>
            <div class="flex flex-col">
                <h3 class="text-[#e9edef] text-[18px] font-medium leading-tight">Verify security code</h3>
                <p class="text-[#8696a0] text-[13px] mt-0.5">You, <span id="security_code_contact_name"></span></p>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6 flex flex-col items-center">
            <!-- QR Code Circle -->
            <div class="w-[200px] h-[200px] bg-white rounded-full flex items-center justify-center mb-8 shrink-0 overflow-hidden p-6">
                <!-- Generic QR Code placeholder -->
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=EndToEndEncryptionSecurityCode" alt="QR Code" class="w-full h-full object-contain">
            </div>

            <!-- Numbers -->
            <div id="security_code_numbers" class="font-mono text-[#e9edef] text-[14px] leading-relaxed tracking-widest text-center flex flex-col gap-1.5 mb-8 opacity-90 font-medium">
                <!-- Numbers will be generated dynamically -->
            </div>

            <p class="text-[#8696a0] text-[14px] text-center leading-[1.4] mb-8">
                To verify that messages and calls with <span id="security_code_contact_name_desc"></span> are end-to-end encrypted, scan or upload this code on their device. You can also compare the number above instead. <a href="#" class="text-[#00a884] hover:underline font-medium" onclick="window.showToast?.('Learn More', 'Opening Help Center...');">Learn more</a>
            </p>

            <div class="flex flex-col gap-4 w-[160px] pb-4">
                <button class="bg-[#00a884] hover:bg-[#00c298] text-[#111b21] py-2.5 px-4 rounded-full font-medium transition-colors text-[14px]" onclick="window.showToast?.('Scan code', 'Camera access needed');">Scan code</button>
                <button class="bg-[#00a884] hover:bg-[#00c298] text-[#111b21] py-2.5 px-4 rounded-full font-medium transition-colors text-[14px]" onclick="window.showToast?.('Upload code', 'Opening file picker...');">Upload code</button>
            </div>
        </div>
    </div>
</div>

<!-- Custom Confirm Modal -->
<div id="custom_confirm_modal" class="hidden fixed inset-0 bg-black/80 z-[100] flex items-center justify-center p-4">
    <div id="custom_confirm_modal_content" class="bg-[#3b4a54] rounded-2xl w-full max-w-sm overflow-hidden shadow-2xl transform scale-95 opacity-0 transition-all duration-200">
        <div class="px-6 pt-8 pb-8 flex flex-col items-center">
            <h3 id="custom_confirm_modal_text" class="text-[#e9edef] text-[16px] font-normal text-center leading-relaxed"></h3>
        </div>

        <div class="px-6 py-4 flex gap-4 bg-[#202c33] justify-end border-t border-[#313d45]">
            <button onclick="window.closeCustomConfirmModal()" class="text-[#00a884] hover:bg-[#111b21] px-5 py-2.5 rounded-full font-medium transition-colors text-[14px]">Cancel</button>
            <button id="custom_confirm_modal_ok_btn" class="bg-[#00a884] hover:bg-[#00c298] text-[#111b21] px-5 py-2.5 rounded-full font-medium transition-colors text-[14px]">OK</button>
        </div>
    </div>
</div>
