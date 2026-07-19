<x-app-layout>
    @push('styles')
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <!-- Cropper.js -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
        <style>
            .chat-bg {
                background-color: #efeae2;
                background-image: url('https://w0.peakpx.com/wallpaper/508/871/HD-wallpaper-whatsapp-background-theme-pattern.jpg');
                background-blend-mode: multiply;
            }

            /* Instant Light Theme via CSS Filter */
            html.light-theme {
                filter: invert(1) hue-rotate(180deg);
            }

            html.light-theme img,
            html.light-theme video,
            html.light-theme canvas,
            html.light-theme iframe,
            html.light-theme .emoji-text {
                filter: invert(1) hue-rotate(180deg);
            }

            html.light-theme .emoji-text {
                display: inline-block;
            }

            html.light-theme emoji-picker {
                filter: invert(1) hue-rotate(180deg);
                --background: #f0f2f5 !important;
                --border-color: #e9edef !important;
                --input-background: #ffffff !important;
                --input-color: #111b21 !important;
                --input-border-color: #e9edef !important;
                --indicator-color: #00a884 !important;
                --button-hover-background: #e9edef !important;
            }

            html.light-theme .bg-transparent {
                /* Fix for transparent backgrounds looking weird when inverted if they have borders */
            }

            /* Toast Animations */
            @keyframes slide-in {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }

                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }

            .toast-enter {
                animation: slide-in 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            }

            /* Search highlight in chat messages - text level */
            .search-highlight {
                background-color: #00a884;
                color: #fff;
                border-radius: 3px;
                padding: 0 2px;
            }

            /* Search highlight - full row background line */
            .search-msg-highlight {
                background-color: rgba(0, 168, 132, 0.15);
                position: relative;
            }

            .search-msg-highlight::before {
                content: '';
                position: absolute;
                left: 0;
                right: 0;
                top: 0;
                bottom: 0;
                background-color: rgba(0, 168, 132, 0.08);
                pointer-events: none;
                z-index: 0;
            }

            @media (min-width: 640px) {
                #user_sidebar_container,
                #calls_sidebar_container,
                #settings_panel,
                #edit_profile_panel,
                #general_settings_panel,
                #privacy_settings_panel,
                #chats_settings_panel,
                #video_voice_settings_panel,
                #notifications_settings_panel,
                #help_feedback_settings_panel,
                #account_settings_panel,
                #security_settings_panel,
                #privacy_last_seen_panel,
                #privacy_status_panel,
                #privacy_profile_photo_panel,
                #privacy_about_panel,
                #privacy_exclude_panel,
                #privacy_blocked_contacts_panel,
                #chats_wallpaper_panel,
                #chats_upload_quality_panel,
                #chats_auto_download_panel,
                #notifications_taskbar_panel,
                #notifications_banner_panel,
                #notifications_subpanel,
                #new_chat_panel,
                #add_group_members_panel,
                #create_group_panel,
                #new_contact_panel,
                #status_sidebar {
                    min-width: 300px !important;
                }
            }
        </style>
    @endpush

    <div class="flex w-full h-[100vh] mx-auto overflow-hidden shadow-xl">

        <!-- Toast Container -->
        <div id="toast_container"
            class="fixed top-6 left-1/2 -translate-x-1/2 z-[200] flex flex-col gap-3 pointer-events-none w-full max-w-sm px-4">
        </div>

        <!-- Incoming Call Overlay -->
        <div id="incoming_call_overlay" class="hidden fixed inset-0 z-[300] flex flex-col items-center justify-between"
            style="background:linear-gradient(135deg,#0b141a 0%,#1a2e38 40%,#0d3320 70%,#0b141a 100%)">
            <style>
                @keyframes ic-pulse {
                    0% {
                        width: 120px;
                        height: 120px;
                        opacity: .6
                    }

                    100% {
                        width: 300px;
                        height: 300px;
                        opacity: 0
                    }
                }

                .ic-ring {
                    position: absolute;
                    border-radius: 50%;
                    border: 1px solid rgba(0, 168, 132, 0.15);
                    animation: ic-pulse 3s ease-out infinite
                }

                .ic-ring:nth-child(1) {
                    animation-delay: 0s
                }

                .ic-ring:nth-child(2) {
                    animation-delay: 1s
                }

                .ic-ring:nth-child(3) {
                    animation-delay: 2s
                }

                @keyframes ic-dot {

                    0%,
                    80%,
                    100% {
                        opacity: .3
                    }

                    40% {
                        opacity: 1
                    }
                }

                .icd1 {
                    animation: ic-dot 1.4s ease-in-out infinite
                }

                .icd2 {
                    animation: ic-dot 1.4s ease-in-out .2s infinite
                }

                .icd3 {
                    animation: ic-dot 1.4s ease-in-out .4s infinite
                }

                @keyframes ic-btn-pulse {

                    0%,
                    100% {
                        box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4)
                    }

                    50% {
                        box-shadow: 0 0 0 15px rgba(34, 197, 94, 0)
                    }
                }

                .ic-accept-pulse {
                    animation: ic-btn-pulse 2s ease-in-out infinite
                }
            </style>
            <div class="pt-14 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full"
                    style="background:rgba(255,255,255,0.06);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,0.08)">
                    <svg class="w-3.5 h-3.5 text-[#00a884]" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z" />
                    </svg>
                    <span class="text-[#8696a0] text-[12px] font-medium">End-to-end encrypted</span>
                </div>
            </div>
            <div class="flex-1 flex flex-col items-center justify-center -mt-8">
                <div class="relative flex items-center justify-center mb-8">
                    <div class="ic-ring"></div>
                    <div class="ic-ring"></div>
                    <div class="ic-ring"></div>
                    <div
                        class="w-[120px] h-[120px] rounded-full overflow-hidden border-[3px] border-[#00a884]/30 shadow-2xl relative z-10 bg-[#202c33]">
                        <img id="ic_caller_avatar" src="" class="w-full h-full object-cover">
                    </div>
                </div>
                <h1 id="ic_caller_name" class="text-white text-[26px] font-semibold mb-1"></h1>
                <div class="flex items-center gap-1">
                    <span id="ic_call_type" class="text-[#8696a0] text-[15px]">Voice Call</span>
                    <span class="flex gap-0.5"><span class="icd1 text-[#8696a0]">.</span><span
                            class="icd2 text-[#8696a0]">.</span><span class="icd3 text-[#8696a0]">.</span></span>
                </div>
            </div>
            <div class="pb-16 flex items-center justify-center gap-20">
                <div class="flex flex-col items-center gap-2">
                    <button id="ic_reject_btn" onclick="rejectIncomingCall()"
                        class="w-16 h-16 rounded-full bg-red-500 hover:bg-red-600 text-white flex items-center justify-center shadow-lg transition-all active:scale-90"
                        style="box-shadow:0 0 30px rgba(239,68,68,0.3)">
                        <svg class="w-8 h-8 rotate-[135deg]" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z" />
                        </svg>
                    </button>
                    <span class="text-[#8696a0] text-xs">Decline</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <button id="ic_accept_btn" onclick="acceptIncomingCall()"
                        class="ic-accept-pulse w-16 h-16 rounded-full bg-green-500 hover:bg-green-600 text-white flex items-center justify-center shadow-lg transition-all active:scale-90"
                        style="box-shadow:0 0 30px rgba(34,197,94,0.3)">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z" />
                        </svg>
                    </button>
                    <span class="text-[#8696a0] text-xs">Accept</span>
                </div>
            </div>
            <audio id="ic_ringtone" loop>
                <source src="https://www.soundjay.com/phone/phone-calling-1.mp3" type="audio/mpeg">
            </audio>
        </div>

        <!-- Custom Delete Modal -->
        <div id="delete_modal"
            class="hidden fixed inset-0 z-[1000] flex items-center justify-center bg-black/60 backdrop-blur-sm transition-all duration-300">
            <div class="bg-[#233138] w-[90%] max-w-[340px] rounded-[32px] p-6 shadow-2xl transform scale-95 transition-all duration-300 opacity-0"
                id="delete_modal_content">
                <h3 id="delete_modal_title" class="text-[#e9edef] text-[16px] font-normal mb-8">Delete message?</h3>
                <div class="flex flex-col gap-3 items-end w-full">
                    <button id="delete_everyone_btn"
                        class="hidden bg-[#ea005e] text-white font-bold text-[14px] px-6 py-2.5 rounded-full hover:bg-[#ff1a75] transition-all active:scale-95 shadow-lg w-full text-center">Delete for everyone</button>
                    <button id="delete_confirm_btn"
                        class="bg-[#00a884] text-[#111b21] font-bold text-[14px] px-6 py-2.5 rounded-full hover:bg-[#06cf9c] transition-all active:scale-95 shadow-lg w-full text-center">Delete for me</button>
                    <button onclick="window.closeDeleteModal()"
                        class="text-[#8696a0] font-medium text-[14px] hover:bg-white/5 px-4 py-2 rounded-lg transition-colors w-full text-center">Cancel</button>
                </div>
            </div>
        </div>

        <!-- Custom Logout Modal -->
        <div id="logout_modal"
            class="hidden fixed inset-0 z-[1000] flex items-center justify-center bg-black/60 backdrop-blur-sm transition-all duration-300">
            <div class="bg-[#233138] w-[90%] max-w-[340px] rounded-[3px] p-6 shadow-2xl transform scale-95 transition-all duration-300 opacity-0"
                id="logout_modal_content">
                <h3 class="text-[#e9edef] text-[20px] font-normal mb-8">Log out?</h3>
                <p class="text-[#8696a0] text-[15px] mb-8">Are you sure you want to log out?</p>
                <div class="flex justify-end gap-4 items-center">
                    <button onclick="window.closeLogoutModal()"
                        class="text-[#00a884] font-medium text-[14px] hover:bg-white/5 px-4 py-2 rounded-lg transition-colors border border-gray-600/30">Cancel</button>
                    <button onclick="document.getElementById('logout-form').submit();"
                        class="bg-[#00a884] text-[#111b21] font-medium text-[14px] px-6 py-2.5 rounded-full hover:bg-[#06cf9c] transition-all active:scale-95 shadow-lg">Log
                        out</button>
                </div>
            </div>
        </div>

        <script>
            window.openLogoutModal = function() {
                const modal = document.getElementById('logout_modal');
                const content = document.getElementById('logout_modal_content');
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.classList.add('opacity-100');
                    content.classList.remove('scale-95', 'opacity-0');
                    content.classList.add('scale-100', 'opacity-100');
                }, 10);
            };

            window.closeLogoutModal = function() {
                const modal = document.getElementById('logout_modal');
                const content = document.getElementById('logout_modal_content');
                content.classList.remove('scale-100', 'opacity-100');
                content.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.remove('opacity-100');
                    modal.classList.add('hidden');
                }, 300);
            };
        </script>

        <!-- Forward Modal -->
        <div id="forward_modal"
            class="hidden fixed inset-0 z-[3000] flex items-center justify-center bg-black/60 backdrop-blur-sm transition-all duration-300">
            <div class="bg-[#222e35] w-[90%] max-w-[440px] h-[550px] rounded-2xl flex flex-col overflow-hidden shadow-2xl transform scale-95 transition-all duration-300 opacity-0"
                id="forward_modal_content">
                <!-- Header -->
                <div class="flex items-center gap-4 px-6 py-4 bg-[#202c33] shrink-0">
                    <button onclick="window.closeForwardModal()"
                        class="text-[#8696a0] hover:text-[#e9edef] p-1 rounded-full focus:outline-none transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <h3 class="text-[#e9edef] text-[18px] font-medium">Forward message to</h3>
                </div>

                <!-- Search Bar -->
                <div class="px-4 py-2 bg-[#111b21] shrink-0 border-b border-white/5">
                    <div
                        class="flex items-center bg-[#202c33] rounded-lg px-3 py-1.5 focus-within:bg-[#2a3942] transition-colors border border-transparent focus-within:border-[#00a884]/30">
                        <svg class="w-5 h-5 text-[#8696a0] mr-3 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" id="forward_search_input" oninput="window.filterForwardContacts()"
                            placeholder="Search name or number"
                            class="w-full bg-transparent border-none text-[#e9edef] text-sm focus:ring-0 placeholder-[#8696a0] py-0.5">
                    </div>
                </div>

                <!-- Scrollable Content -->
                <div class="flex-1 overflow-y-auto custom-scrollbar p-2 bg-[#111b21]">
                    <!-- My Status -->
                    <div onclick="window.toggleForwardTargetSelection('status', 'My status', '')"
                        class="flex items-center justify-between p-3 hover:bg-[#2a3942]/60 rounded-xl cursor-pointer transition-all group/item forward-target-item"
                        data-name="my status">
                        <div class="flex items-center gap-4 flex-1 min-w-0">
                            <div
                                class="w-12 h-12 rounded-full bg-[#00a884]/10 flex items-center justify-center shrink-0">
                                <svg class="w-7 h-7 text-[#00a884]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M12 6v6l4 2"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-[#e9edef] font-medium truncate">My status</div>
                                <div class="text-[#8696a0] text-sm mt-0.5 truncate">Share to my status</div>
                            </div>
                        </div>
                        <div class="shrink-0 mr-1">
                            <div class="w-5 h-5 rounded border-2 border-gray-400 bg-white flex items-center justify-center transition-all select-none"
                                id="forward_checkbox_box_status">
                                <input type="checkbox" id="forward_checkbox_status" class="hidden">
                                <svg class="w-3.5 h-3.5 text-white hidden" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Chats Header -->
                    <div class="text-[#00a884] text-xs font-semibold px-3 py-2 mt-2 uppercase tracking-wider">Recent
                        chats</div>

                    <!-- Contacts List Container -->
                    <div id="forward_contacts_list" class="space-y-1">
                        <!-- Populated by JS -->
                    </div>
                </div>

                <!-- Footer -->
                <div id="forward_modal_footer"
                    class="hidden flex items-center justify-between px-6 py-4 bg-[#202c33] shrink-0 border-t border-white/5">
                    <div class="flex-1 min-w-0 pr-4">
                        <div class="text-[#8696a0] text-xs">Selected targets</div>
                        <div id="forward_selected_names" class="text-[#e9edef] text-sm font-medium truncate mt-0.5">
                        </div>
                    </div>
                    <button onclick="window.sendForwardedMessages()"
                        class="bg-[#00a884] hover:bg-[#008f72] text-[#111b21] p-3 rounded-full shadow-lg transition-transform focus:outline-none hover:scale-105 active:scale-95 shrink-0"
                        title="Send messages">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                            <path
                                d="M1.101 21.757L23.8 12.028 1.101 2.3l.011 7.912 13.623 1.816-13.623 1.817-.011 7.912z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <style>
            #delete_modal.show {
                display: flex;
            }

            #delete_modal.show #delete_modal_content {
                transform: scale(1);
                opacity: 1;
            }

            #forward_modal.show {
                display: flex;
            }

            #forward_modal.show #forward_modal_content {
                transform: scale(1);
                opacity: 1;
            }
        </style>

        <script>
            window.applyGlobalWallpaper = function() {
                const currentUserId = window.myUserId || 'default';
                const color = localStorage.getItem(`whatsapp_wallpaper_color_${currentUserId}`) || '#0b141a';
                const doodles = localStorage.getItem(`whatsapp_wallpaper_doodles_${currentUserId}`) !== 'false';
                const globalImg = localStorage.getItem(`whatsapp_wallpaper_global_image_${currentUserId}`);

                const bgElements = document.querySelectorAll('.chat-bg');
                bgElements.forEach(el => {
                    // Check if it's #messages or #group_messages and if they have custom wallpaper
                    let hasCustom = false;
                    if (el.id === 'messages' && window.activeChatUser && window.activeChatUser.id) {
                        if (localStorage.getItem(`custom_wallpaper_${currentUserId}_user_${window.activeChatUser.id}`)) hasCustom = true;
                    }
                    if (el.id === 'group_messages' && window.currentGroupId) {
                        if (localStorage.getItem(`custom_wallpaper_${currentUserId}_group_${window.currentGroupId}`)) hasCustom = true;
                    }

                    if (!hasCustom) {
                        if (globalImg) {
                            el.style.backgroundColor = 'transparent';
                            el.style.backgroundImage = `url('${globalImg}')`;
                            el.style.backgroundSize = 'cover';
                            el.style.backgroundPosition = 'center';
                            el.style.backgroundRepeat = 'no-repeat';
                            el.style.backgroundBlendMode = 'normal';
                        } else {
                            el.style.backgroundColor = color;
                            if (doodles) {
                                el.style.backgroundImage = "url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png')";
                                el.style.backgroundBlendMode = "overlay";
                                el.style.backgroundSize = '';
                                el.style.backgroundPosition = '';
                                el.style.backgroundRepeat = '';
                            } else {
                                el.style.backgroundImage = 'none';
                                el.style.backgroundSize = '';
                                el.style.backgroundPosition = '';
                                el.style.backgroundRepeat = '';
                                el.style.backgroundBlendMode = '';
                            }
                        }
                    }
                });
            };

            document.addEventListener('DOMContentLoaded', () => {
                window.applyGlobalWallpaper();
            });
        </script>

        <div class="flex w-full h-full bg-[#111b21] overflow-hidden border-none">

            @include('chat.nav_sidebar')
            @include('chat.status.index')
            @include('chat.status.text_status')
            @include('chat.status.media_status')
            @include('chat.status.status_viewer')
            @include('chat.settings.profile_settings')
            @include('chat.settings.edit_profile')
            @include('chat.settings.general')
            @include('chat.settings.privacy')
            @include('chat.settings.disappearing_messages.default_timer')
            @include('chat.settings.privacy_panels.privacy_last_seen')
            @include('chat.settings.privacy_panels.privacy_profile_photo')
            @include('chat.settings.privacy_panels.privacy_about')
            @include('chat.settings.privacy_panels.privacy_exclude_contacts')
            @include('chat.settings.privacy_panels.privacy_blocked_contacts')
            @include('chat.settings.privacy_panels.privacy_add_blocked_contact')
            @include('chat.settings.chats')
            @include('chat.settings.chats_panels.chats_modals')
            @include('chat.settings.chats_panels.chats_upload_quality')
            @include('chat.settings.chats_panels.chats_auto_download')
            @include('chat.settings.chats_panels.chats_wallpaper')
            @include('chat.settings.chats_panels.chats_hide')
            @include('chat.settings.account')
            @include('chat.settings.security_notifications')
            @include('chat.settings.video_voice_panels.video_voice')
            @include('chat.settings.notifications_panels.notifications')
            @include('chat.settings.notifications_panels.notifications_banner')
            @include('chat.settings.notifications_panels.notifications_taskbar')
            @include('chat.settings.notifications_panels.notifications_subpanel')
            @include('chat.settings.help_and_feedback_panels.help_and_feedback')
            @include('chat.settings.keyboard_shortcuts_modal')
            @include('chat.about.about_modal')
            @include('chat.about.about_privacy_modal')
            @include('chat.contacts.contact_info')
            @include('chat.new_chat')
            @include('chat.groups.add_group_members')
            @include('chat.groups.create_group')
            @include('chat.contacts.new_contact')
            @include('chat.contacts.edit_contact')
            @include('chat.sidebar')
            @include('chat.broadcasts.broadcast_panel')
            @include('chat.broadcasts.new_broadcast_panel')
            @include('chat.broadcasts.broadcast_info')
            @include('chat.broadcasts.change_name_modal')
            @include('chat.broadcasts.edit_recipients_panel')
            @include('chat.calls_sidebar')
            @include('chat.communities_sidebar')
            @include('chat.communities.communities_panel')
            @include('chat.channels.channels_sidebar')
            @include('chat.channels.find_channels_sidebar')
            @include('chat.channels.create_channel')

            @include('chat.channels.share_channel_modals')
            <div id="sidebar_resizer"
                class="hidden sm:block w-[4px] hover:bg-[#00a884]/30 cursor-col-resize shrink-0 z-[60] transition-colors active:bg-[#00a884]">
            </div>
            @include('chat.calls_main_column')
            @include('chat.channels.channels_main_column')
            @include('chat.calls.add_favourite_modal')
            @include('chat.media_gallery')
            @include('chat.global_search.image_viewer')
            @include('chat.global_search.video_viewer')
            @include('chat.global_search.gif_viewer')
            @include('chat.global_search.audio_viewer')

            <!-- Media Preview Modal -->
            <div id="media_preview_modal"
                class="hidden fixed inset-0 z-[100] bg-gray-900/95 flex flex-col items-center justify-center backdrop-blur-sm">
                <div class="absolute top-4 right-4 z-[110]">
                    <button onclick="clearFile()"
                        class="text-white hover:text-red-400 p-2 focus:outline-none transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div
                    class="w-full max-w-4xl px-4 flex-1 flex items-center justify-center overflow-hidden py-12 relative">
                    <div id="modal_image_container" class="hidden h-full w-full flex items-center justify-center">
                        <img id="modal_image_preview"
                            class="max-h-full max-w-full object-contain rounded-lg shadow-2xl">
                    </div>
                    <div id="modal_file_container"
                        class="hidden bg-white/10 p-8 rounded-3xl flex flex-col items-center justify-center gap-6 text-white w-full max-w-sm shadow-2xl backdrop-blur-md border border-white/20">
                        <svg class="w-20 h-20 text-blue-400 drop-shadow-md" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <span id="modal_file_name" class="font-medium text-lg text-center break-words w-full"></span>
                    </div>
                </div>

                <div class="w-full max-w-2xl px-6 pb-8 flex gap-3 items-end">
                    <div
                        class="flex-1 bg-gray-800 rounded-2xl px-4 py-3 border border-gray-700 shadow-xl focus-within:border-gray-500 transition-colors">
                        <input type="text" id="modal_caption" placeholder="Add a caption..."
                            class="w-full bg-transparent border-none text-white focus:ring-0 placeholder-gray-400 text-lg">
                    </div>
                    <button onclick="sendFromModal()"
                        class="bg-green-500 hover:bg-green-600 text-white rounded-full p-4 shadow-lg transition-all hover:scale-105 active:scale-95 focus:outline-none">
                        <svg class="w-7 h-7 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Location Modal Full UI -->
            <div id="location_preview_modal"
                class="hidden fixed inset-0 z-[100] bg-[#0b141a] flex flex-col font-sans">
                <!-- Header -->
                <div
                    class="flex items-center justify-between px-4 h-16 bg-[#202c33] shrink-0 border-b border-[#313d45]">
                    <div class="flex items-center gap-4">
                        <button onclick="closeLocationModal()"
                            class="text-white hover:bg-white/10 p-2 rounded-full focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </button>
                        <h2 class="text-white text-lg font-medium" id="location_modal_title">Send location</h2>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="toggleLocationSearch()"
                            class="text-white hover:bg-white/10 p-2 rounded-full">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                        <button onclick="refreshLocation()" class="text-white hover:bg-white/10 p-2 rounded-full">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Search Bar (Hidden by default) -->
                <div id="location_search_bar" class="hidden px-4 py-2 bg-[#202c33] border-b border-[#313d45]">
                    <input type="text" id="location_search_input" placeholder="Search for places..."
                        class="w-full bg-[#2a3942] text-white border-none rounded-lg px-4 py-2 focus:ring-0 text-sm placeholder-gray-400"
                        oninput="searchLocation(this.value)">
                </div>

                <!-- Main Content Split -->
                <div class="flex-1 flex flex-col relative overflow-hidden">
                    <!-- Map Area (Top 50%) -->
                    <div id="location_map_area"
                        class="w-full h-1/2 relative transition-all duration-300 border-b border-[#313d45]">
                        <div id="leaflet_map" class="w-full h-full z-10 bg-[#0b141a]"></div>
                        <button onclick="centerOnMe()"
                            class="absolute top-4 right-4 z-[400] bg-[#2a3942] text-[#8696a0] p-3 rounded-full shadow-lg border border-[#313d45] hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm8.94 3c-.46-4.17-3.77-7.48-7.94-7.94V1h-2v2.06C6.83 3.52 3.52 6.83 3.06 11H1v2h2.06c.46 4.17 3.77 7.48 7.94 7.94V23h2v-2.06c4.17-.46 7.48-3.77 7.94-7.94H23v-2h-2.06zM12 19c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7z">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <!-- Panel Area (Bottom 50%) -->
                    <div id="location_panel_area"
                        class="w-full h-1/2 bg-[#0b141a] overflow-y-auto transition-all duration-300 flex flex-col">

                        <!-- Default Options (Share Live & Current) -->
                        <div id="location_default_panel">
                            <div class="px-4 py-4 hover:bg-[#202c33] cursor-pointer flex items-center gap-4 transition-colors"
                                onclick="openLiveLocationConfig()">
                                <div
                                    class="w-12 h-12 rounded-full bg-[#1dae75] flex items-center justify-center text-white shrink-0 shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                        </path>
                                    </svg>
                                </div>
                                <div class="border-b border-[#202c33] flex-1 pb-4 pt-2">
                                    <h3 class="text-white text-[17px] font-normal">Share live location</h3>
                                </div>
                            </div>

                            <div class="px-4 py-2 mt-1">
                                <h4 class="text-[#8696a0] text-[14px] font-medium tracking-wide">Nearby places</h4>
                            </div>

                            <div class="px-4 py-3 hover:bg-[#202c33] cursor-pointer flex items-center gap-4 transition-colors"
                                onclick="sendCurrentLocation()">
                                <div
                                    class="w-12 h-12 rounded-full bg-[#1dae75] bg-opacity-20 flex items-center justify-center text-[#1dae75] shrink-0 border border-[#1dae75]/30">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="border-b border-[#202c33] flex-1 pb-3 pt-1">
                                    <h3 class="text-[#1dae75] text-[17px] font-normal">Send your current location</h3>
                                    <p class="text-[#8696a0] text-sm mt-0.5">Accurate to <span
                                            id="accuracy_meters">15</span> meters</p>
                                </div>
                            </div>

                            <div id="search_results" class="flex flex-col pb-4">
                                <!-- Populated by JS -->
                            </div>
                        </div>

                        <!-- Live Location Config Panel (Hidden by default) -->
                        <div id="live_location_config_panel" class="hidden flex-col h-full bg-[#202c33]">
                            <div class="px-4 py-3 bg-[#0b141a]">
                                <h3 class="text-white font-medium text-[16px]">Share live location</h3>
                            </div>
                            <div class="flex items-center gap-2 px-4 py-4">
                                <button onclick="selectDuration(15)" id="dur_15"
                                    class="dur-btn flex-1 py-2 text-center rounded bg-[#2a3942] text-[#8696a0] font-medium transition-colors">15
                                    minutes</button>
                                <button onclick="selectDuration(60)" id="dur_60"
                                    class="dur-btn flex-1 py-2 text-center rounded bg-[#1dae75] text-white font-medium transition-colors">1
                                    hour</button>
                                <button onclick="selectDuration(480)" id="dur_480"
                                    class="dur-btn flex-1 py-2 text-center rounded bg-[#2a3942] text-[#8696a0] font-medium transition-colors">8
                                    hours</button>
                            </div>
                            <div class="px-4 pb-4 flex gap-4 items-end flex-1">
                                <input type="text" id="live_loc_comment" placeholder="Add comment"
                                    class="flex-1 bg-transparent border-none border-b border-[#8696a0] focus:border-[#1dae75] transition-colors text-white focus:ring-0 px-0 pb-1 text-[15px] placeholder-[#8696a0]">
                                <button onclick="startLiveLocation()"
                                    class="w-12 h-12 rounded-full bg-[#1dae75] flex items-center justify-center text-white shrink-0 hover:bg-[#159362] active:scale-95 transition-transform shadow-lg">
                                    <svg class="w-5 h-5 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div id="chat_view_container" class="flex-1 flex h-full overflow-hidden relative">
                @include('chat.settings_shortcuts')
                <div id="main_chat_column" class="flex flex-col flex-1 h-full relative transition-all duration-300 min-w-0">
                    <!-- Lock Overlay to hide messages during lock/unlock prompts -->
                    <div id="chat_lock_overlay" class="hidden absolute inset-0 bg-[#0b141a] z-[150] flex flex-col items-center justify-center text-center px-4 transition-all duration-300">
                        <div class="flex flex-col items-center animate-pulse">
                            <div class="w-16 h-16 bg-[#202c33] rounded-full flex items-center justify-center mb-4 shadow-lg border border-white/5">
                                <svg viewBox="0 0 24 24" height="28" width="28" fill="#00a884">
                                    <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-[#e9edef] text-[16px] font-normal tracking-wide">Chat is Locked</h3>
                            <p class="text-[#8696a0] text-[13px] mt-1">Unlock to view messages</p>
                        </div>
                    </div>
                    <script>
                        if (localStorage.getItem('app_lock_hash')) {
                            document.getElementById('chat_lock_overlay').classList.remove('hidden');
                        }
                    </script>

                    <!-- Empty State -->
                    <div id="chat_empty_state"
                        class="flex-1 flex flex-col items-center justify-center bg-[#0b141a] text-center px-4 z-20">
                        <div class="flex gap-14 mb-8">
                            <!-- Send Document -->
                            <div class="flex flex-col items-center gap-4 group cursor-pointer"
                                onclick="selectFile('.pdf,.doc,.docx')">
                                <div
                                    class="w-[110px] h-[110px] rounded-[28px] bg-[#202c33] flex items-center justify-center text-[#8696a0] group-hover:bg-[#2a3942] transition-all duration-300">
                                    <svg viewBox="0 0 24 24" width="36" height="36" fill="none"
                                        stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12h6m-6 3h6m-6 3h6" />
                                    </svg>
                                </div>
                                <span class="text-[#8696a0] text-[13px] font-normal">Send document</span>
                            </div>
                            <!-- Add Contact -->
                            <div class="flex flex-col items-center gap-4 group cursor-pointer"
                                onclick="toggleNewContact()">
                                <div
                                    class="w-[110px] h-[110px] rounded-[28px] bg-[#202c33] flex items-center justify-center text-[#8696a0] group-hover:bg-[#2a3942] transition-all duration-300">
                                    <svg viewBox="0 0 24 24" width="40" height="40" fill="none"
                                        stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                                    </svg>
                                </div>
                                <span class="text-[#8696a0] text-[13px] font-normal">Add contact</span>
                            </div>
                            <!-- Ask Meta AI -->
                            <div class="flex flex-col items-center gap-4 group cursor-pointer"
                                onclick="window.openMetaAiChat()">
                                <div
                                    class="w-[110px] h-[110px] rounded-[28px] bg-[#202c33] flex items-center justify-center text-[#d33682] group-hover:bg-[#2a3942] transition-all duration-300">
                                    <div class="relative w-10 h-10 flex items-center justify-center">
                                        <div class="absolute inset-0 border-2 border-current rounded-full opacity-40">
                                        </div>
                                        <div class="w-5 h-5 border-2 border-current rounded-full"></div>
                                        <!-- Dots -->
                                        <div
                                            class="absolute -top-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 bg-current rounded-full">
                                        </div>
                                        <div
                                            class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 bg-current rounded-full">
                                        </div>
                                        <div
                                            class="absolute top-1/2 -left-1 -translate-y-1/2 w-1.5 h-1.5 bg-current rounded-full">
                                        </div>
                                        <div
                                            class="absolute top-1/2 -right-1 -translate-y-1/2 w-1.5 h-1.5 bg-current rounded-full">
                                        </div>
                                    </div>
                                </div>
                                <span class="text-[#8696a0] text-[13px] font-normal">Ask Meta AI</span>
                            </div>
                        </div>
                    </div>

                    <div id="active_chat_content" class="hidden flex-col flex-1 h-full overflow-hidden">
                        <div class="h-16 bg-[#202c33] px-4 border-b border-[#313d45] shrink-0 shadow-sm z-[45] relative">
                            <!-- Normal Header -->
                            <div id="normal_header"
                                class="flex items-center justify-between h-full w-full transition-all duration-300">
                                <div class="flex items-center gap-2">
                                    <button
                                        class="sm:hidden text-[#8696a0] hover:text-[#e9edef] transition-colors mr-1"
                                        onclick="window.backToSidebar()">
                                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z">
                                            </path>
                                        </svg>
                                    </button>
                                    <div id="active_chat_avatar" onclick="openContactInfo()"
                                        class="relative w-10 h-10 rounded-full bg-[#2a3942] flex items-center justify-center text-gray-600 font-bold shadow-sm transition-transform hover:scale-105 cursor-pointer">
                                        <svg class="w-6 h-6 text-[#8696a0]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="cursor-pointer" onclick="openContactInfo()">
                                        <h2 id="active_chat_title"
                                            class="text-[15px] font-semibold text-[#e9edef] leading-tight">Select a
                                            chat
                                        </h2>
                                        <p id="active_chat_subtitle"
                                            class="text-xs text-[#00a884] font-medium hidden">
                                            online</p>
                                    </div>
                                </div>

                                <!-- Header Actions -->
                                <div class="flex items-center gap-2 sm:gap-4">
                                    <!-- Call Button Pill -->
                                    <div class="relative">
                                        <button id="call_btn_pill"
                                            class="hidden sm:flex items-center gap-2.5 bg-[#2a3942] hover:bg-[#384b57] text-[#e9edef] px-4 py-2 rounded-full cursor-pointer transition-all duration-200 border border-transparent hover:border-[#313d45] group focus:outline-none">
                                            <div
                                                class="flex items-center gap-2 border-r border-[#313d45] pr-2 group-hover:border-[#8696a0]">
                                                <svg class="w-5 h-5 text-[#8696a0] group-hover:text-[#e9edef]"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                <span class="text-sm font-semibold">Call</span>
                                            </div>
                                            <svg class="w-4 h-4 text-[#8696a0] group-hover:text-[#e9edef]"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>

                                        <!-- Call Dropdown -->
                                        <div id="call_dropdown" style="display: none;"
                                            class="hidden absolute top-full mt-2 right-0 w-[350px] bg-[#111b21] rounded-2xl shadow-2xl z-[100] flex flex-col border border-white/5 overflow-hidden transition-all duration-200 transform origin-top-right scale-95 opacity-0">
                                            <style>
                                                #call_dropdown.show {
                                                    transform: scale(1);
                                                    opacity: 1;
                                                }
                                            </style>

                                            <!-- User Info Section -->
                                            <div class="p-6 pb-4">
                                                <div class="flex items-center gap-4">
                                                    <div id="call_dropdown_avatar"
                                                        class="w-14 h-14 rounded-full overflow-hidden bg-[#202c33]">
                                                        <img src="https://ui-avatars.com/api/?name=User&background=202c33&color=fff"
                                                            class="w-full h-full object-cover">
                                                    </div>
                                                    <div class="flex flex-col">
                                                        <span id="call_dropdown_name"
                                                            class="text-[#e9edef] font-medium text-[19px]">User</span>
                                                    </div>
                                                </div>

                                                <!-- Call Action Buttons -->
                                                <div class="flex gap-3 mt-6">
                                                    <button onclick="startVoiceCall()"
                                                        class="flex-1 bg-[#00a884] hover:bg-[#06cf9c] text-[#111b21] py-3 rounded-full flex items-center justify-center gap-2.5 font-bold transition-all active:scale-[0.98]">
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                            <path
                                                                d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z">
                                                            </path>
                                                        </svg>
                                                        Voice
                                                    </button>
                                                    <button onclick="startVideoCall()"
                                                        class="flex-1 bg-[#00a884] hover:bg-[#06cf9c] text-[#111b21] py-3 rounded-full flex items-center justify-center gap-2.5 font-bold transition-all active:scale-[0.98]">
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                            <path
                                                                d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z">
                                                            </path>
                                                        </svg>
                                                        Video
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="h-px bg-white/5 mx-6 mb-1"></div>

                                            <!-- Menu List Options -->
                                            <div class="flex flex-col py-1">
                                                <button onclick="window.openNewGroupCallModal()"
                                                    class="flex items-center gap-5 px-6 py-3.5 hover:bg-[#202c33] text-[#e9edef] transition-colors group/opt text-left">
                                                    <div
                                                        class="w-6 h-6 flex items-center justify-center text-[#8696a0] group-hover/opt:text-[#e9edef]">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                    <span class="text-[16px]">New group call</span>
                                                </button>
                                                <button onclick="window.openNewCallLinkModal()"
                                                    class="flex items-center gap-5 px-6 py-3.5 hover:bg-[#202c33] text-[#e9edef] transition-colors group/opt text-left">
                                                    <div
                                                        class="w-6 h-6 flex items-center justify-center text-[#8696a0] group-hover/opt:text-[#e9edef]">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                    <span class="text-[16px]">Send call link</span>
                                                </button>
                                                <button onclick="window.openScheduleCallModal()"
                                                    class="flex items-center gap-5 px-6 py-3.5 hover:bg-[#202c33] text-[#e9edef] transition-colors group/opt text-left">
                                                    <div
                                                        class="w-6 h-6 flex items-center justify-center text-[#8696a0] group-hover/opt:text-[#e9edef]">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                    <span class="text-[16px]">Schedule call</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Search Icon -->
                                    <button onclick="toggleSearchPanel()"
                                        class="p-2.5 text-[#8696a0] hover:text-[#e9edef] hover:bg-[#2a3942] rounded-full transition-all duration-200 focus:outline-none"
                                        title="Search">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </button>

                                    <!-- Menu Icon -->
                                    <div class="relative">
                                        <button id="private_header_more_btn"
                                            onclick="togglePrivateHeaderMoreMenu(event)"
                                            class="p-2.5 text-[#8696a0] hover:text-[#e9edef] hover:bg-[#2a3942] rounded-full transition-all duration-200 focus:outline-none"
                                            title="Menu">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                                </path>
                                            </svg>
                                        </button>

                                        <!-- Private Header More Options Dropdown -->
                                        <div id="private_header_more_dropdown"
                                            class="hidden absolute top-12 right-0 w-[240px] bg-[#233138] rounded-xl shadow-2xl border border-[#313d45] py-2 z-[100] transition-all duration-200 origin-top-right transform scale-95 opacity-0">
                                            <button onclick="window.openContactInfo(); togglePrivateHeaderMoreMenu()"
                                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                                    class="text-[15px]">Contact info</span></button>
                                            <button onclick="toggleSearchPanel(); togglePrivateHeaderMoreMenu()"
                                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                                    class="text-[15px]">Search</span></button>
                                            <button onclick="window.selectMessage(); togglePrivateHeaderMoreMenu()"
                                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                                    class="text-[15px]">Select messages</span></button>
                                            <button
                                                onclick="window.toggleMuteChat(window.activeChatUser.id, 'user', window.mutedChats[`user_sidebar_${window.activeChatUser.id}`] ? null : 'always'); togglePrivateHeaderMoreMenu()"
                                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                                    class="text-[15px]" id="private_header_mute_text">Mute
                                                    notifications</span></button>
                                            <button onclick="window.openDisappearingMessagesSidebar(); togglePrivateHeaderMoreMenu()"
                                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                                    class="text-[15px]">Disappearing messages</span></button>
                                            <button onclick="window.openWallpaperModal(window.activeChatUser.id, 'user'); togglePrivateHeaderMoreMenu()"
                                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                                    class="text-[15px]">Chat wallpaper</span></button>
                                            <button
                                                onclick="window.toggleLockChat(window.activeChatUser.id, 'user'); togglePrivateHeaderMoreMenu()"
                                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                                    class="text-[15px]" id="private_header_lock_text">Lock
                                                    chat</span></button>
                                            <button
                                                onclick="window.toggleFavouriteChat(window.activeChatUser.id, 'user'); window.updatePrivateHeaderFavouriteText(); togglePrivateHeaderMoreMenu()"
                                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                                    class="text-[15px]" id="private_header_favourite_text">Add to
                                                    favourites</span></button>
                                            <button onclick="togglePrivateHeaderMoreMenu()"
                                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                                    class="text-[15px]">Add to list</span></button>
                                            <button onclick="window.closeChat(); togglePrivateHeaderMoreMenu()"
                                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                                    class="text-[15px]">Close chat</span></button>
                                            <div class="h-[1px] bg-[#313d45] my-1 mx-4"></div>
                                            <button onclick="window.reportContact(); togglePrivateHeaderMoreMenu()"
                                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                                    class="text-[15px]">Report</span></button>
                                            <button
                                                onclick="window.toggleBlockContact(window.activeChatUser.id, 'user'); window.updateBlockedUI(); togglePrivateHeaderMoreMenu()"
                                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors">
                                                <span class="text-[15px]"><span
                                                        id="private_header_block_text">Block</span></span>
                                            </button>
                                            <button
                                                onclick="if(window.openDeleteModal) { window.openDeleteModal('Clear this chat?', () => { window.clearChatMessages(window.activeChatUser.id, 'user'); togglePrivateHeaderMoreMenu(); }); } else { if(confirm('Clear this chat?')) { window.clearChatMessages(window.activeChatUser.id, 'user'); togglePrivateHeaderMoreMenu(); } }"
                                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                                    class="text-[15px]">Clear chat</span></button>
                                            <button
                                                onclick="if(window.openDeleteModal) { window.openDeleteModal('Delete this chat?', () => { window.deleteChatMessages(window.activeChatUser.id, 'user'); togglePrivateHeaderMoreMenu(); }); } else { if(confirm('Delete this chat?')) { window.deleteChatMessages(window.activeChatUser.id, 'user'); togglePrivateHeaderMoreMenu(); } }"
                                                class="w-full flex items-center gap-4 px-5 py-2.5 text-[#e9edef] hover:bg-[#182229] transition-colors"><span
                                                    class="text-[15px]">Delete chat</span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Selection Header -->
                            <div id="selection_header"
                                class="hidden absolute inset-0 bg-teal-600 items-center justify-between px-4 h-full w-full transition-all duration-300">
                                <div class="flex items-center gap-4">
                                    <button onclick="cancelSelection()"
                                        class="text-white hover:bg-black/10 p-2 rounded-full transition-colors focus:outline-none">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                    <span id="selection_count" class="text-white font-semibold text-lg">1
                                        Selected</span>
                                </div>
                                <div class="flex items-center">
                                    <button onclick="confirmDeleteSelected()"
                                        class="text-white hover:bg-black/10 p-2 text-sm rounded-full transition-colors focus:outline-none"
                                        title="Delete">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Pinned Messages Bar (Hidden by default, supports multiple) -->
                        <div id="private_pinned_bar"
                            onclick="window.scrollToCurrentPin && window.scrollToCurrentPin()"
                            class="hidden bg-[#2a3942]/90 backdrop-blur-sm px-4 py-2 flex items-center justify-between border-b border-white/5 cursor-pointer hover:bg-[#384b57] transition-colors z-[15] w-full max-w-full min-w-0 overflow-hidden">
                            <div class="flex items-center gap-3 overflow-hidden min-w-0 flex-1">
                                <div class="text-[#00a884] shrink-0">
                                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                                        <path
                                            d="M16 9V4l1 0c.55 0 1-.45 1-1s-.45-1-1-1H7c-.55 0-1 .45-1 1s.45 1 1 1l1 0v5c0 1.66-1.34 3-3 3v2h5.97v7l1 1 1-1v-7H19v-2c-1.66 0-3-1.34-3-3z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex flex-col min-w-0 flex-1">
                                    <span id="private_pinned_count" class="text-[#00a884] text-[13px] font-semibold">1
                                        pinned message</span>
                                    <span id="private_pinned_text"
                                        class="text-[#8696a0] text-sm truncate block w-full">Message text goes here...</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 shrink-0">
                                <button onclick="event.stopPropagation(); window.navigatePin && window.navigatePin(-1)"
                                    class="text-[#8696a0] hover:text-[#e9edef] p-1 rounded-full hover:bg-white/5 transition-colors"
                                    title="Previous pin">
                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                                        <path d="M7.41 15.41L12 10.83l4.59 4.58L18 14l-6-6-6 6z"></path>
                                    </svg>
                                </button>
                                <button onclick="event.stopPropagation(); window.navigatePin && window.navigatePin(1)"
                                    class="text-[#8696a0] hover:text-[#e9edef] p-1 rounded-full hover:bg-white/5 transition-colors"
                                    title="Next pin">
                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                                        <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div id="messages"
                            class="flex-1 overflow-y-auto p-4 chat-bg space-y-1 scroll-smooth bg-[#0b141a]">
                        </div>

                        <div
                            class="h-auto min-h-[64px] bg-[#202c33] px-4 py-2 flex flex-col justify-end shrink-0 relative z-20">
                            <!-- Replying Block -->
                            <div id="replying_to_block"
                                class="hidden bg-[#2a3942] backdrop-blur-sm border-l-4 border-[#00a884] px-4 py-2 mb-2 rounded-xl shadow-sm flex justify-between items-center group cursor-pointer transition-all">
                                <div class="flex-1 flex flex-col overflow-hidden mr-2">
                                    <span id="replying_to_name"
                                        class="font-semibold text-[#00a884] text-[13px]">Replying to message</span>
                                    <span id="replying_to_text"
                                        class="text-[#8696a0] text-sm truncate max-w-[200px] sm:max-w-md"></span>
                                </div>
                                <div id="replying_to_media_container" class="hidden h-10 w-10 shrink-0 mr-3 rounded bg-black/20 overflow-hidden relative">
                                    <img id="replying_to_media" src="" class="hidden h-full w-full object-cover" />
                                    <video id="replying_to_media_vid" src="" preload="metadata" class="hidden h-full w-full object-cover pointer-events-none"></video>
                                    <div id="replying_to_media_vid_icon" class="hidden absolute inset-0 flex items-center justify-center bg-black/20 pointer-events-none">
                                        <svg viewBox="0 0 24 24" width="16" height="16" fill="white"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>
                                    </div>
                                </div>
                                <button onclick="cancelReply()"
                                    class="text-[#8696a0] hover:text-red-500 p-1.5 rounded-full hover:bg-black/10 focus:outline-none transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <!-- Editing Block -->
                            <div id="editing_to_block"
                                class="hidden bg-[#2a3942] backdrop-blur-sm border-l-4 border-[#00a884] px-4 py-2 mb-2 rounded-xl shadow-sm flex justify-between items-center group cursor-pointer transition-all">
                                <div class="flex flex-col overflow-hidden">
                                    <span class="font-semibold text-[#00a884] text-[13px]">Edit message</span>
                                    <span id="editing_to_text"
                                        class="text-[#8696a0] text-sm truncate max-w-[200px] sm:max-w-md"></span>
                                </div>
                                <button onclick="window.cancelEdit()"
                                    class="text-[#8696a0] hover:text-red-500 p-1.5 rounded-full hover:bg-black/10 focus:outline-none transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>


                            <div id="normal_input_container" class="flex items-center gap-2 w-full relative">
                                <!-- Emoji Picker Button -->
                                <button type="button" id="emoji_toggle_btn" onclick="toggleEmojiPicker()"
                                    class="text-[#8696a0] hover:text-[#e9edef] p-2 focus:outline-none shrink-0 transition-colors">
                                    <svg viewBox="0 0 24 24" width="26" height="26" fill="currentColor">
                                        <path
                                            d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm2.5-9.5c.828 0 1.5-.672 1.5-1.5s-.672-1.5-1.5-1.5-1.5.672-1.5 1.5.672 1.5 1.5 1.5zm-5 0c.828 0 1.5-.672 1.5-1.5S8.828 8 8 8s-1.5.672-1.5 1.5.672 1.5 1.5 1.5zm2.5 6c2.511 0 4.67-1.516 5.568-3.693h-11.136c.898 2.177 3.057 3.693 5.568 3.693z">
                                        </path>
                                    </svg>
                                </button>

                                <!-- Emoji Picker Panel -->
                                <div id="emoji_picker_container"
                                    class="hidden absolute bottom-full mb-3 left-0 sm:left-4 z-50 shadow-2xl origin-bottom-left rounded-[16px] overflow-hidden flex flex-col bg-white dark:bg-[#202c33] border border-gray-200 dark:border-gray-700 w-[320px] sm:w-[350px]">

                                    <!-- Panels container -->
                                    <div class="w-full relative" style="height: 320px;">
                                        <!-- Emoji Panel (Uses system dark/light mode automatically) -->
                                        <div id="panel_emoji" class="w-full h-full">
                                            <emoji-picker id="emoji_picker" class="w-full"
                                                style="--num-columns: 8; --emoji-size: 1.5rem; --indicator-color: #00a884; height: 320px; border: none;"></emoji-picker>
                                        </div>

                                        <!-- GIF Panel -->
                                        <div id="panel_gif" class="w-full h-full hidden bg-white dark:bg-[#202c33] p-2 flex flex-col">
                                            <div class="mb-2 shrink-0">
                                                <input type="text" id="gif_search_input" placeholder="Search GIFs..." class="w-full bg-gray-100 dark:bg-[#2a3942] text-gray-800 dark:text-white rounded-lg px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#00a884] border-none text-sm placeholder-gray-500" onkeyup="if(event.key === 'Enter') searchGifs(this.value)">
                                            </div>
                                            <div id="gif_results" class="flex-1 overflow-y-auto custom-scrollbar grid grid-cols-2 gap-1 p-1 content-start">
                                                <!-- Populated by JS -->
                                            </div>
                                        </div>

                                        <!-- Sticker Panel -->
                                        <div id="panel_sticker" class="w-full h-full hidden bg-white dark:bg-[#202c33] p-2 flex flex-col">
                                            <div class="mb-2 shrink-0">
                                                <input type="text" id="sticker_search_input" placeholder="Search Stickers..." class="w-full bg-gray-100 dark:bg-[#2a3942] text-gray-800 dark:text-white rounded-lg px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#00a884] border-none text-sm placeholder-gray-500" onkeyup="if(event.key === 'Enter') searchStickers(this.value)">
                                            </div>
                                            <div id="sticker_results" class="flex-1 overflow-y-auto custom-scrollbar grid grid-cols-4 gap-2 p-1 content-start">
                                                <!-- Populated by JS -->
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bottom Tabs Bar (WhatsApp Style) -->
                                    <div
                                        class="h-[50px] bg-gray-100 dark:bg-[#2a3942] border-t border-gray-200 dark:border-gray-700 flex items-center justify-center shrink-0">
                                        <!-- Emoji Tab -->
                                        <button onclick="switchPickerTab('emoji')" id="tab_btn_emoji"
                                            class="flex-1 flex justify-center py-2 h-full items-center relative transition-colors bg-gray-200 dark:bg-[#384b57]">
                                            <svg viewBox="0 0 24 24" width="24" height="24"
                                                class="text-gray-600 dark:text-gray-300" fill="currentColor">
                                                <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm2.5-9.5c.828 0 1.5-.672 1.5-1.5s-.672-1.5-1.5-1.5-1.5.672-1.5 1.5.672 1.5 1.5 1.5zm-5 0c.828 0 1.5-.672 1.5-1.5S8.828 8 8 8s-1.5.672-1.5 1.5.672 1.5 1.5 1.5zm2.5 6c2.511 0 4.67-1.516 5.568-3.693h-11.136c.898 2.177 3.057 3.693 5.568 3.693z"></path>
                                            </svg>
                                            <div id="tab_indicator_emoji" class="absolute bottom-0 left-0 w-full h-[3px] bg-[#00a884]"></div>
                                        </button>
                                        <!-- GIF Tab -->
                                        <button onclick="switchPickerTab('gif')" id="tab_btn_gif"
                                            class="flex-1 flex justify-center py-2 h-full items-center hover:bg-gray-200 dark:hover:bg-[#384b57] transition-colors relative">
                                            <span
                                                class="font-bold text-gray-500 dark:text-gray-400 text-[15px]">GIF</span>
                                            <div id="tab_indicator_gif" class="absolute bottom-0 left-0 w-full h-[3px] bg-[#00a884] hidden"></div>
                                        </button>
                                        <!-- Sticker Tab -->
                                        <button onclick="switchPickerTab('sticker')" id="tab_btn_sticker"
                                            class="flex-1 flex justify-center py-2 h-full items-center hover:bg-gray-200 dark:hover:bg-[#384b57] transition-colors relative">
                                            <svg viewBox="0 0 24 24" width="24" height="24"
                                                class="text-gray-500 dark:text-gray-400" fill="currentColor">
                                                <path d="M14.5 3h-5C6.46 3 4 5.46 4 8.5v7C4 18.54 6.46 21 9.5 21h4l6-6v-6.5C19.5 5.46 17.04 3 14.5 3zm-2.5 16h-2.5C7.57 19 6 17.43 6 15.5v-7C6 6.57 7.57 5 9.5 5h5C16.43 5 18 6.57 18 8.5v5.09l-4.5 4.5V19h-1.5zM17 14h-2.5c-.83 0-1.5.67-1.5 1.5V18l4-4z"></path>
                                            </svg>
                                            <div id="tab_indicator_sticker" class="absolute bottom-0 left-0 w-full h-[3px] bg-[#00a884] hidden"></div>
                                        </button>
                                    </div>
                                </div>

                                <input type="file" id="file_input" class="hidden">
                                <div class="relative shrink-0">
                                    <button type="button" id="attach_toggle_btn" onclick="toggleAttachMenu()"
                                        class="text-gray-500 hover:text-gray-700 p-2 focus:outline-none">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                            </path>
                                        </svg>
                                    </button>

                                    <!-- Attachment Menu -->
                                    <div id="attach_menu"
                                        class="hidden absolute bottom-full mb-3 left-0 sm:left-4 bg-[#1f2c34] p-4 rounded-3xl w-[320px] shadow-2xl z-50 transition-all origin-bottom-left">
                                        <div class="grid grid-cols-4 gap-y-6 gap-x-2 place-items-center">
                                            <!-- Document -->
                                            <div class="flex flex-col items-center gap-1 group cursor-pointer"
                                                onclick="selectFile('.pdf,.doc,.docx,.xls,.xlsx,.txt,.zip')">
                                                <div
                                                    class="w-14 h-14 rounded-2xl bg-[#5f66cd] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                                <span class="text-gray-300 text-xs">Document</span>
                                            </div>
                                            <!-- Camera -->
                                            <div class="flex flex-col items-center gap-1 group cursor-pointer"
                                                onclick="selectFile('image/*;capture=camera')">
                                                <div
                                                    class="w-14 h-14 rounded-2xl bg-[#ed517b] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                                    <svg class="w-7 h-7" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                                        </path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <span class="text-gray-300 text-xs">Camera</span>
                                            </div>
                                            <!-- Gallery -->
                                            <div class="flex flex-col items-center gap-1 group cursor-pointer"
                                                onclick="selectFile('image/*,video/*')">
                                                <div
                                                    class="w-14 h-14 rounded-2xl bg-[#bf59cf] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                                <span class="text-gray-300 text-xs">Gallery</span>
                                            </div>
                                            <!-- Audio -->
                                            <div class="flex flex-col items-center gap-1 group cursor-pointer"
                                                onclick="selectFile('audio/*')">
                                                <div
                                                    class="w-14 h-14 rounded-2xl bg-[#e35920] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                                <span class="text-gray-300 text-xs">Audio</span>
                                            </div>
                                            <!-- Location -->
                                            <div class="flex flex-col items-center gap-1 group cursor-pointer"
                                                onclick="shareLocation()">
                                                <div
                                                    class="w-14 h-14 rounded-2xl bg-[#1dae75] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                                <span class="text-gray-300 text-xs">Location</span>
                                            </div>
                                            <!-- Contact (Placeholder) -->
                                            <div class="flex flex-col items-center gap-1 group cursor-pointer">
                                                <div
                                                    class="w-14 h-14 rounded-2xl bg-[#09a5eb] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                                <span class="text-gray-300 text-xs">Contact</span>
                                            </div>
                                            <!-- Poll (Placeholder) -->
                                            <div class="flex flex-col items-center gap-1 group cursor-pointer">
                                                <div
                                                    class="w-14 h-14 rounded-2xl bg-[#11a9a1] flex items-center justify-center text-white shadow-sm group-active:scale-95 transition-transform">
                                                    <svg class="w-7 h-7" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <span class="text-gray-300 text-xs">Poll</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Input Area Container -->
                                <div id="input_area_container"
                                    class="flex-1 relative flex items-center bg-[#2a3942] rounded-xl shadow-sm overflow-hidden">

                                    <!-- State 1: Normal Text Input -->
                                    <div id="text_input_state" class="w-full relative flex items-center">
                                        <textarea id="msg" oninput="handleInputToggle(); autoResizeTextarea(this)"
                                            onkeydown="handleTextareaKey(event)" placeholder="Type a message" rows="1"
                                            class="w-full bg-transparent border-none pl-4 pr-10 py-2.5 text-[15px] focus:ring-0 text-[#d1d7db] placeholder-[#8696a0] min-h-[44px] max-h-32 resize-none overflow-y-auto custom-scrollbar leading-normal"></textarea>
                                        <!-- INSIDE MIC (Voice-to-Text) -->
                                        <button type="button" id="inside_mic_btn" onclick="toggleVoiceRecord()"
                                            class="absolute right-3 text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                                            <svg viewBox="0 0 24 24" width="20" height="20"
                                                fill="currentColor">
                                                <path
                                                    d="M11.999 14.942c2.001 0 3.531-1.53 3.531-3.531V4.35c0-2.001-1.53-3.531-3.531-3.531S8.469 2.35 8.469 4.35v7.061c0 2.001 1.53 3.531 3.53 3.531zm6.238-3.53c0 3.531-2.942 6.002-6.237 6.002s-6.237-2.471-6.237-6.002H3.761c0 4.001 3.178 7.297 7.061 7.885v3.884h2.354v-3.884c3.884-.588 7.061-3.884 7.061-7.885h-2.002z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- State 2: Voice Note Recording UI -->
                                    <div id="audio_recording_state"
                                        class="hidden w-full items-center justify-between px-3 h-[40px]">
                                        <button type="button" onclick="cancelVoiceNote()"
                                            class="text-gray-500 hover:text-red-500 focus:outline-none transition-colors">
                                            <svg viewBox="0 0 24 24" width="22" height="22"
                                                fill="currentColor">
                                                <path
                                                    d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zm2.46-7.12l1.41-1.41L12 12.59l2.12-2.12 1.41 1.41L13.41 14l2.12 2.12-1.41 1.41L12 15.41l-2.12 2.12-1.41-1.41L10.59 14l-2.13-2.12zM15.5 4l-1-1h-5l-1 1H5v2h14V4z">
                                                </path>
                                            </svg>
                                        </button>
                                        <div class="flex items-center gap-2">
                                            <div class="w-2.5 h-2.5 bg-red-500 rounded-full animate-pulse"></div>
                                            <span id="audio_timer"
                                                class="text-[15px] font-medium text-gray-700">0:00</span>
                                        </div>
                                        <div class="flex-1 mx-3 flex items-center h-full overflow-hidden">
                                            <!-- Animated Waveform SVG -->
                                            <div
                                                class="flex items-center gap-[3px] h-4 w-full opacity-60 justify-end overflow-hidden">
                                                <!-- Animated Bars -->
                                                <div
                                                    class="w-1 bg-gray-400 rounded-full h-2 animate-[pulse_1s_ease-in-out_infinite]">
                                                </div>
                                                <div
                                                    class="w-1 bg-gray-400 rounded-full h-4 animate-[pulse_1.2s_ease-in-out_infinite_0.2s]">
                                                </div>
                                                <div
                                                    class="w-1 bg-gray-400 rounded-full h-3 animate-[pulse_0.8s_ease-in-out_infinite_0.4s]">
                                                </div>
                                                <div
                                                    class="w-1 bg-gray-400 rounded-full h-5 animate-[pulse_1.1s_ease-in-out_infinite_0.1s]">
                                                </div>
                                                <div
                                                    class="w-1 bg-gray-400 rounded-full h-2 animate-[pulse_0.9s_ease-in-out_infinite_0.5s]">
                                                </div>
                                                <div
                                                    class="w-1 bg-gray-400 rounded-full h-4 animate-[pulse_1.3s_ease-in-out_infinite_0.3s]">
                                                </div>
                                                <div
                                                    class="w-1 bg-gray-400 rounded-full h-3 animate-[pulse_1s_ease-in-out_infinite_0.7s]">
                                                </div>
                                                <div
                                                    class="w-1 bg-gray-400 rounded-full h-5 animate-[pulse_1.4s_ease-in-out_infinite_0.2s]">
                                                </div>
                                                <div
                                                    class="w-1 bg-gray-400 rounded-full h-2 animate-[pulse_0.8s_ease-in-out_infinite_0.6s]">
                                                </div>
                                                <div
                                                    class="w-1 bg-gray-400 rounded-full h-4 animate-[pulse_1.1s_ease-in-out_infinite_0.1s]">
                                                </div>
                                                <div
                                                    class="w-1 bg-gray-400 rounded-full h-3 animate-[pulse_1s_ease-in-out_infinite]">
                                                </div>
                                                <div
                                                    class="w-1 bg-gray-400 rounded-full h-2 animate-[pulse_1.2s_ease-in-out_infinite_0.4s]">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button id="action_btn" onclick="handleActionBtn()"
                                    class="bg-[#00a884] hover:bg-[#008f6f] text-white rounded-full w-10 h-10 flex items-center justify-center shadow-sm shrink-0 transition-colors focus:outline-none">
                                    <!-- Mic SVG -->
                                    <svg id="mic_icon" viewBox="0 0 24 24" width="24" height="24"
                                        fill="currentColor">
                                        <path
                                            d="M11.999 14.942c2.001 0 3.531-1.53 3.531-3.531V4.35c0-2.001-1.53-3.531-3.531-3.531S8.469 2.35 8.469 4.35v7.061c0 2.001 1.53 3.531 3.53 3.531zm6.238-3.53c0 3.531-2.942 6.002-6.237 6.002s-6.237-2.471-6.237-6.002H3.761c0 4.001 3.178 7.297 7.061 7.885v3.884h2.354v-3.884c3.884-.588 7.061-3.884 7.061-7.885h-2.002z">
                                        </path>
                                    </svg>
                                    <!-- Send SVG -->
                                    <svg id="send_icon" viewBox="0 0 24 24" width="24" height="24"
                                        fill="currentColor" class="hidden ml-1">
                                        <path
                                            d="M1.101 21.757L23.8 12.028 1.101 2.3l.011 7.912 13.623 1.816-13.623 1.817-.011 7.912z">
                                        </path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Blocked State Container -->
                            <div id="blocked_state_container"
                                class="hidden w-full h-[62px] flex items-center justify-center bg-[#202c33] text-[#8696a0] text-[14.5px] cursor-pointer hover:bg-[#202c33]/80 transition-colors"
                                onclick="window.unblockCurrentContact()">
                                You blocked this contact. Tap to unblock.
                            </div>

                            <!-- Bottom Selection Bar -->
                            <div id="selection_bottom_bar"
                                class="hidden flex items-center justify-between w-full h-[52px] bg-[#202c33] px-4 py-2 text-[#e9edef] z-20">
                                <div class="flex items-center gap-4">
                                    <button onclick="cancelSelection()"
                                        class="text-[#8696a0] hover:text-[#e9edef] p-2 rounded-full focus:outline-none transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                    <span id="selection_bottom_count" class="font-semibold text-base">0
                                        selected</span>
                                </div>
                                <button onclick="window.openForwardModal()"
                                    class="bg-[#00a884] hover:bg-[#008f72] text-white p-2.5 rounded-full shadow-lg transition-transform focus:outline-none hover:scale-105 active:scale-95"
                                    title="Forward message">
                                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                        <path
                                            d="M12.072 1.061a1 1 0 0 0-1.414 1.414L18.586 10.5H3a1 1 0 1 0 0 2h15.586l-7.928 8.025a1 1 0 1 0 1.414 1.414l9.643-9.761a1 1 0 0 0 0-1.414L12.072 1.061z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @include('chat.reaction_popup')
                    @include('chat.groups.group_chat')
                    @include('chat.meta_ai')
                </div>

                <!-- Search Messages Sidebar -->
                <div id="search_sidebar"
                    class="hidden w-[400px] h-full bg-[#111b21] border-l border-gray-800 flex flex-col z-30 transition-all duration-300">
                    <!-- Header -->
                    <div class="h-[110px] bg-[#202c33] px-6 flex flex-col justify-end pb-4 shrink-0">
                        <div class="flex items-center gap-8 mb-6">
                            <button onclick="toggleSearchPanel()"
                                class="text-[#aebac1] hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                            <h2 class="text-[#e9edef] text-[19px] font-medium">Search messages</h2>
                        </div>
                    </div>

                    <!-- Search Input Area -->
                    <div class="p-3 bg-[#111b21] flex flex-col gap-4">
                        <div class="flex items-center gap-3 relative">
                            <!-- Calendar Button -->
                            <button onclick="toggleCalendar()"
                                class="text-[#aebac1] hover:text-white transition-colors">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2">
                                    </rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </button>

                            <!-- Calendar Modal -->
                            <div id="calendar_modal"
                                class="hidden absolute top-12 left-0 w-[300px] bg-[#233138] rounded-xl shadow-2xl z-[100] p-5 flex flex-col border border-white/5 transition-all duration-200 transform origin-top-left scale-95 opacity-0 active:scale-100 active:opacity-100">
                                <style>
                                    #calendar_modal:not(.hidden) {
                                        display: flex;
                                        transform: scale(1);
                                        opacity: 1;
                                    }
                                </style>
                                <div class="flex items-center justify-between mb-5">
                                    <h3 id="calendar_month_year" class="text-[#e9edef] font-medium text-base">April
                                        2026
                                    </h3>
                                    <div class="flex items-center gap-6">
                                        <button onclick="changeCalendarMonth(-1)"
                                            class="text-[#aebac1] hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                                            </svg>
                                        </button>
                                        <button onclick="changeCalendarMonth(1)"
                                            class="text-[#aebac1] hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div
                                    class="grid grid-cols-7 gap-1 mb-3 text-center text-[#8696a0] text-[13px] font-medium uppercase tracking-tighter">
                                    <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
                                </div>
                                <div id="calendar_days_grid" class="grid grid-cols-7 gap-1 text-center">
                                    <!-- JS Populated -->
                                </div>
                            </div>

                            <div
                                class="flex-1 bg-[#202c33] rounded-lg flex items-center px-3 py-1.5 focus-within:bg-[#2a3942] transition-colors border border-transparent focus-within:border-[#00a884]/30">
                                <svg class="w-5 h-5 text-[#8696a0] mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <input type="text" id="search_messages_input"
                                    oninput="performMessageSearch(this.value)" placeholder="Search..."
                                    class="w-full bg-transparent border-none text-[#e9edef] text-sm focus:ring-0 placeholder-[#8696a0] py-0.5">
                                <button onclick="clearMessageSearch()" id="clear_search_btn"
                                    class="hidden text-[#8696a0] hover:text-white transition-colors ml-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Results List -->
                    <div id="search_results_container" class="flex-1 overflow-y-auto px-1 py-2 custom-scrollbar">
                        <div id="no_results_text"
                            class="flex flex-col items-center justify-center h-full text-[#8696a0] text-sm px-10 text-center space-y-4">
                            <p>Search for messages with Z Jenil Jg</p>
                        </div>
                        <div id="search_results_list" class="flex flex-col">
                            <!-- Populated by JS -->
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="p-6 text-center border-t border-gray-800 bg-[#111b21]">
                        <p class="text-[#8696a0] text-[13px] leading-relaxed">
                            Use WhatsApp on your phone to search messages from before {{ date('d/m/Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
    <script>
        window.wrapEmojis = function(text) {
            if (!text) return '';
            // Matches Regional Indicators (flags) or emojis with optional skin tones and ZWJ joins
            const emojiRegex = /(\p{Regional_Indicator}{2}|(\p{Emoji_Presentation}|\p{Emoji_Modifier_Base}\p{Emoji_Modifier}?)(\u200D(\p{Emoji_Presentation}|\p{Emoji_Modifier_Base}\p{Emoji_Modifier}?))*)/gu;
            return text.replace(emojiRegex, '<span class="emoji-text">$1</span>');
        };

        window.linkifyText = function(text) {
            if (!text) return text;
            const urlRegex = /(https?:\/\/[^\s<]+)/g;
            return text.replace(urlRegex, function(url) {
                // Intercept WhatsApp channel links and our app's channel links
                if (url.includes('whatsapp.com/channel/') || url.includes('/channel/')) {
                    let channelId = '';
                    if (url.includes('whatsapp.com/channel/')) {
                        channelId = url.split('whatsapp.com/channel/')[1].split('/')[0].split('?')[0];
                    } else if (url.includes('/channel/')) {
                        channelId = url.split('/channel/')[1].split('/')[0].split('?')[0];
                    }
                    if (channelId) {
                        return `<a href="javascript:void(0)" class="text-[#00a884] hover:underline hover:text-[#008f72] transition-colors" onclick="window.showChannels(); setTimeout(() => { window.openChannel('${channelId}'); }, 300);">${url}</a>`;
                    }
                }
                return `<a href="${url}" target="_blank" class="text-[#00a884] hover:underline hover:text-[#008f72] transition-colors">${url}</a>`;
            });
        };

        function toggleEmojiPicker() {
            const picker = document.getElementById('emoji_picker_container');
            picker.classList.toggle('hidden');
        }

        window.updatePrivateHeaderFavouriteText = function() {
            const favText = document.getElementById('private_header_favourite_text');
            if (favText && window.activeChatUser && window.favouriteChats) {
                const isFav = window.favouriteChats.includes(`user_sidebar_${window.activeChatUser.id}`);
                favText.textContent = isFav ? 'Remove from favourites' : 'Add to favourites';
            }
        };

        window.switchPickerTab = function(tab) {
            // Hide all panels
            document.getElementById('panel_emoji').classList.add('hidden');
            document.getElementById('panel_gif').classList.add('hidden');
            document.getElementById('panel_sticker').classList.add('hidden');

            // Reset tab styles
            document.getElementById('tab_btn_emoji').classList.remove('bg-gray-200', 'dark:bg-[#384b57]');
            document.getElementById('tab_btn_gif').classList.remove('bg-gray-200', 'dark:bg-[#384b57]');
            document.getElementById('tab_btn_sticker').classList.remove('bg-gray-200', 'dark:bg-[#384b57]');

            document.getElementById('tab_indicator_emoji').classList.add('hidden');
            document.getElementById('tab_indicator_gif').classList.add('hidden');
            document.getElementById('tab_indicator_sticker').classList.add('hidden');

            // Show selected panel
            document.getElementById(`panel_${tab}`).classList.remove('hidden');
            document.getElementById(`tab_btn_${tab}`).classList.add('bg-gray-200', 'dark:bg-[#384b57]');
            document.getElementById(`tab_indicator_${tab}`).classList.remove('hidden');

            if (tab === 'gif' && document.getElementById('gif_results').children.length === 0) {
                window.loadTrendingGifs();
            } else if (tab === 'sticker' && document.getElementById('sticker_results').children.length === 0) {
                window.loadStickers();
            }
        };

        window.GIPHY_API_KEY = '{{ env("GIPHY_API_KEY", "") }}';

        window.loadTrendingGifs = async function() {
            const gifResults = document.getElementById('gif_results');
            if (!window.GIPHY_API_KEY) {
                gifResults.innerHTML = '<div class="col-span-2 text-center text-red-500 text-sm py-4">GIPHY API Key missing.<br>Please add GIPHY_API_KEY to your .env file.</div>';
                return;
            }
            gifResults.innerHTML = '<div class="col-span-2 text-center text-gray-500 text-sm py-4">Loading GIFs...</div>';
            try {
                const res = await fetch(`https://api.giphy.com/v1/gifs/trending?api_key=${window.GIPHY_API_KEY}&limit=20`);
                const data = await res.json();
                window.renderGifs(data.data);
            } catch (e) {
                gifResults.innerHTML = '<div class="col-span-2 text-center text-red-500 text-sm py-4">Failed to load GIFs</div>';
            }
        };

        window.searchGifs = async function(query) {
            if (!query.trim()) return window.loadTrendingGifs();
            const gifResults = document.getElementById('gif_results');
            if (!window.GIPHY_API_KEY) {
                gifResults.innerHTML = '<div class="col-span-2 text-center text-red-500 text-sm py-4">GIPHY API Key missing.<br>Please add GIPHY_API_KEY to your .env file.</div>';
                return;
            }
            gifResults.innerHTML = '<div class="col-span-2 text-center text-gray-500 text-sm py-4">Searching...</div>';
            try {
                const res = await fetch(`https://api.giphy.com/v1/gifs/search?api_key=${window.GIPHY_API_KEY}&q=${encodeURIComponent(query)}&limit=20`);
                const data = await res.json();
                window.renderGifs(data.data);
            } catch (e) {
                gifResults.innerHTML = '<div class="col-span-2 text-center text-red-500 text-sm py-4">Search failed</div>';
            }
        };

        window.renderGifs = function(gifs) {
            const gifResults = document.getElementById('gif_results');
            gifResults.innerHTML = '';
            if (!gifs || gifs.length === 0) {
                gifResults.innerHTML = '<div class="col-span-2 text-center text-gray-500 text-sm py-4">No GIFs found</div>';
                return;
            }
            gifs.forEach(gif => {
                const previewUrl = gif.images.fixed_height_small.url;
                const sendUrl = gif.images.original.url;
                const img = document.createElement('img');
                img.src = previewUrl;
                img.className = 'w-full h-[100px] object-cover rounded cursor-pointer hover:opacity-80 transition-opacity bg-gray-100 dark:bg-[#2a3942]';
                img.onclick = () => window.sendMediaFromUrl(sendUrl, 'image/gif', 'animation.gif');
                gifResults.appendChild(img);
            });
        };

        window.loadStickers = async function() {
            const stickerResults = document.getElementById('sticker_results');
            if (!window.GIPHY_API_KEY) {
                stickerResults.innerHTML = '<div class="col-span-4 text-center text-red-500 text-sm py-4">GIPHY API Key missing.<br>Please add GIPHY_API_KEY to your .env file.</div>';
                return;
            }
            stickerResults.innerHTML = '<div class="col-span-4 text-center text-gray-500 text-sm py-4">Loading Stickers...</div>';
            try {
                const res = await fetch(`https://api.giphy.com/v1/stickers/trending?api_key=${window.GIPHY_API_KEY}&limit=20`);
                const data = await res.json();
                window.renderStickers(data.data);
            } catch (e) {
                stickerResults.innerHTML = '<div class="col-span-4 text-center text-red-500 text-sm py-4">Failed to load Stickers. Network Error.</div>';
                console.error(e);
            }
        };

        window.searchStickers = async function(query) {
            if (!query.trim()) return window.loadStickers();
            const stickerResults = document.getElementById('sticker_results');
            if (!window.GIPHY_API_KEY) {
                stickerResults.innerHTML = '<div class="col-span-4 text-center text-red-500 text-sm py-4">GIPHY API Key missing.<br>Please add GIPHY_API_KEY to your .env file.</div>';
                return;
            }
            stickerResults.innerHTML = '<div class="col-span-4 text-center text-gray-500 text-sm py-4">Searching...</div>';
            try {
                const res = await fetch(`https://api.giphy.com/v1/stickers/search?api_key=${window.GIPHY_API_KEY}&q=${encodeURIComponent(query)}&limit=20`);
                const data = await res.json();
                window.renderStickers(data.data);
            } catch (e) {
                stickerResults.innerHTML = '<div class="col-span-4 text-center text-red-500 text-sm py-4">Search failed. Network Error.</div>';
                console.error(e);
            }
        };

        window.renderStickers = function(stickers) {
            const stickerResults = document.getElementById('sticker_results');
            stickerResults.innerHTML = '';

            if (!stickers || stickers.length === 0) {
                stickerResults.innerHTML = '<div class="col-span-4 text-center text-gray-500 text-sm py-4">No stickers found</div>';
                return;
            }

            stickers.forEach(sticker => {
                const previewUrl = sticker.images.fixed_height_small.url;
                const sendUrl = sticker.images.original.url;
                const img = document.createElement('img');
                img.src = previewUrl;
                img.className = 'w-full h-[72px] object-contain cursor-pointer hover:scale-110 transition-transform p-1';
                img.onclick = () => window.sendMediaFromUrl(sendUrl, 'image/gif', 'sticker.gif');
                stickerResults.appendChild(img);
            });
        };

        window.sendMediaFromUrl = async function(url, type, filename) {
            // Show loading or close picker immediately
            document.getElementById('emoji_picker_container').classList.add('hidden');

            try {
                // Fetch blob
                const response = await fetch(url);
                const blob = await response.blob(); 
                const file = new File([blob], filename, { type: type });

                // Pass to emitMessage
                if (window.emitMessage) {
                    window.emitMessage('', file);
                } else {
                    console.error('emitMessage function not found');
                }
            } catch (err) {
                console.error('Error sending media:', err);
                alert('Failed to send media. Network error.');
            }
        };

        window.togglePrivateHeaderMoreMenu = function(event) {
            if (event) event.stopPropagation();
            const dropdown = document.getElementById('private_header_more_dropdown');
            if (!dropdown) return;

            const isHidden = dropdown.classList.contains('hidden');
            if (isHidden) {
                // Update block, favourite, mute, lock text based on state
                if (window.activeChatUser) {
                    const elementId = `user_sidebar_${window.activeChatUser.id}`;

                    const isBlocked = window.blockedUsers?.includes(elementId);
                    const blockText = document.getElementById('private_header_block_text');
                    if (blockText) blockText.textContent = isBlocked ? 'Unblock' : 'Block';

                    const isMuted = window.mutedChats && !!window.mutedChats[elementId];
                    const muteText = document.getElementById('private_header_mute_text');
                    if (muteText) muteText.textContent = isMuted ? 'Unmute notifications' : 'Mute notifications';

                    const isLocked = window.lockedChats?.includes(elementId);
                    const lockText = document.getElementById('private_header_lock_text');
                    if (lockText) lockText.textContent = isLocked ? 'Unlock chat' : 'Lock chat';

                    window.updatePrivateHeaderFavouriteText();
                }

                dropdown.classList.remove('hidden');
                setTimeout(() => {
                    dropdown.classList.remove('opacity-0', 'scale-95');
                    dropdown.classList.add('opacity-100', 'scale-100');
                }, 10);
            } else {
                dropdown.classList.remove('opacity-100', 'scale-100');
                dropdown.classList.add('opacity-0', 'scale-95');
                setTimeout(() => dropdown.classList.add('hidden'), 200);
            }
        };

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const emojiPicker = document.getElementById('emoji_picker_container');
            const emojiBtn = document.getElementById('emoji_toggle_btn');
            if (emojiPicker && emojiBtn && !emojiPicker.classList.contains('hidden')) {
                // emoji-picker component has shadow DOM which messes with contains() sometimes,
                // so we use composedPath() to check if the click was inside the picker.
                const path = event.composedPath();
                if (!path.includes(emojiPicker) && !path.includes(emojiBtn)) {
                    emojiPicker.classList.add('hidden');
                }
            }

            const attachMenu = document.getElementById('attach_menu');
            const attachBtn = document.getElementById('attach_toggle_btn');
            if (attachMenu && attachBtn && !attachMenu.classList.contains('hidden')) {
                const path = event.composedPath();
                if (!path.includes(attachMenu) && !path.includes(attachBtn)) {
                    attachMenu.classList.add('hidden');
                }
            }

            // Close any open message menu dropdowns when clicking outside
            const menuBtn = event.target.closest('button[onclick*="window.toggleMsgMenu"]');
            const menuDropdown = event.target.closest('[id^="menu_"]');
            if (!menuBtn && !menuDropdown) {
                document.querySelectorAll('[id^="menu_"]').forEach(el => {
                    if (!el.classList.contains('hidden')) {
                        el.classList.add('hidden');
                        const k = el.id.replace('menu_', '');
                        const msgEl = document.getElementById('msg_' + k);
                        const bubbleEl = document.getElementById('bubble_' + k);
                        if (msgEl) msgEl.style.zIndex = '';
                        if (bubbleEl) bubbleEl.style.zIndex = '';
                    }
                });
            }

            // Close private header more dropdown
            const privateHeaderDropdown = document.getElementById('private_header_more_dropdown');
            const privateHeaderBtn = document.getElementById('private_header_more_btn');
            if (privateHeaderDropdown && !privateHeaderDropdown.classList.contains('hidden')) {
                const path = event.composedPath();
                if (!path.includes(privateHeaderDropdown) && (!privateHeaderBtn || !path.includes(
                    privateHeaderBtn))) {
                    privateHeaderDropdown.classList.remove('opacity-100', 'scale-100');
                    privateHeaderDropdown.classList.add('opacity-0', 'scale-95');
                    setTimeout(() => privateHeaderDropdown.classList.add('hidden'), 200);
                }
            }
        });

        document.getElementById('emoji_picker').addEventListener('emoji-click', event => {
            const msgInput = document.getElementById('msg');
            msgInput.value += event.detail.unicode;
            msgInput.focus();
            handleInputToggle();
            autoResizeTextarea(msgInput);
        });

        let recognition = null;
        let isRecordingSpeechText = false;

        let mediaRecorder = null;
        let audioChunks = [];
        let voiceNoteTimerInterval = null;
        let voiceNoteSeconds = 0;
        let isRecordingVoiceNote = false;

        function handleInputToggle() {
            const val = document.getElementById('msg').value.trim();
            const micIcon = document.getElementById('mic_icon');
            const sendIcon = document.getElementById('send_icon');
            const insideMicBtn = document.getElementById('inside_mic_btn');

            if (val.length > 0) {
                micIcon.classList.add('hidden');
                sendIcon.classList.remove('hidden');
                if (insideMicBtn) insideMicBtn.classList.add('hidden');
            } else {
                micIcon.classList.remove('hidden');
                sendIcon.classList.add('hidden');
                if (insideMicBtn) insideMicBtn.classList.remove('hidden');
            }
        }

        function handleActionBtn() {
            const val = document.getElementById('msg').value.trim();
            if (val.length > 0) {
                send();
            } else {
                if (isRecordingVoiceNote) {
                    stopAndSendVoiceNote();
                } else {
                    startVoiceNote();
                }
            }
        }

        // --- VOICE NOTE (AUDIO RECORDING) LOGIC ---
        async function startVoiceNote() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    audio: true
                });
                mediaRecorder = new MediaRecorder(stream);
                audioChunks = [];

                mediaRecorder.ondataavailable = event => {
                    if (event.data.size > 0) audioChunks.push(event.data);
                };

                mediaRecorder.onstop = () => {
                    stream.getTracks().forEach(track => track.stop());
                };

                mediaRecorder.start();
                isRecordingVoiceNote = true;

                // Update UI to Audio Recording State
                document.getElementById('text_input_state').classList.add('hidden');
                document.getElementById('audio_recording_state').classList.remove('hidden');
                document.getElementById('audio_recording_state').classList.add('flex');

                // Switch outside action button to Send immediately while recording
                document.getElementById('mic_icon').classList.add('hidden');
                document.getElementById('send_icon').classList.remove('hidden');

                // Timer
                voiceNoteSeconds = 0;
                document.getElementById('audio_timer').innerText = '0:00';
                voiceNoteTimerInterval = setInterval(() => {
                    voiceNoteSeconds++;
                    const mins = Math.floor(voiceNoteSeconds / 60);
                    const secs = voiceNoteSeconds % 60;
                    document.getElementById('audio_timer').innerText =
                        `${mins}:${secs.toString().padStart(2, '0')}`;
                }, 1000);

            } catch (err) {
                console.error("Error accessing microphone:", err);
                alert("Microphone access is required to send voice messages.");
            }
        }

        function cancelVoiceNote() {
            if (mediaRecorder && mediaRecorder.state !== "inactive") {
                mediaRecorder.stop();
            }
            audioChunks = [];
            resetVoiceNoteUI();
        }

        function stopAndSendVoiceNote() {
            if (mediaRecorder && mediaRecorder.state !== "inactive") {
                mediaRecorder.addEventListener("stop", () => {
                    const audioBlob = new Blob(audioChunks, {
                        type: 'audio/webm'
                    });
                    sendVoiceNoteBlob(audioBlob);
                    audioChunks = [];
                });
                mediaRecorder.stop();
            }
            resetVoiceNoteUI();
        }

        function resetVoiceNoteUI() {
            isRecordingVoiceNote = false;
            clearInterval(voiceNoteTimerInterval);

            document.getElementById('audio_recording_state').classList.add('hidden');
            document.getElementById('audio_recording_state').classList.remove('flex');
            document.getElementById('text_input_state').classList.remove('hidden');

            handleInputToggle(); // Restores outside button based on text
        }

        function sendVoiceNoteBlob(blob) {
            if (!window.currentChatId) {
                alert('Please select a chat first.');
                return;
            }
            const formData = new FormData();
            formData.append('file', blob, 'voice_message.webm');
            formData.append('chat_id', window.currentChatId);
            formData.append('type', 'audio');
            formData.append('duration', voiceNoteSeconds);

            if (window.replyingToKey && window.globalMessages[window.replyingToKey]) {
                formData.append('reply_to_id', window.replyingToKey);
                formData.append('reply_to_text', window.globalMessages[window.replyingToKey].text || 'Voice Message');
            }

            fetch('/send', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                body: formData
            }).then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                cancelReply();
            }).catch(err => {
                console.error("Error sending voice note", err);
                alert("Failed to send voice note.");
            });
        }

        // --- UI TOGGLES ---
        function initCallDropdown() {
            const callBtn = document.getElementById('call_btn_pill');
            const callDropdown = document.getElementById('call_dropdown');

            if (callBtn && callDropdown) {
                // Remove old listeners to prevent duplicates
                const newBtn = callBtn.cloneNode(true);
                callBtn.parentNode.replaceChild(newBtn, callBtn);

                newBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const isOpening = callDropdown.classList.contains('hidden') || callDropdown.style.display ===
                        'none';

                    if (isOpening) {
                        callDropdown.classList.remove('hidden');
                        callDropdown.style.display = 'flex';
                        callDropdown.offsetHeight; // Force reflow
                        callDropdown.classList.add('show');

                        // Close on outside click
                        const closeHandler = (evt) => {
                            if (!callDropdown.contains(evt.target) && !newBtn.contains(evt.target)) {
                                callDropdown.classList.remove('show');
                                setTimeout(() => {
                                    callDropdown.style.display = 'none';
                                    callDropdown.classList.add('hidden');
                                }, 200);
                                document.removeEventListener('click', closeHandler);
                            }
                        };
                        setTimeout(() => document.addEventListener('click', closeHandler), 10);
                    } else {
                        callDropdown.classList.remove('show');
                        setTimeout(() => {
                            callDropdown.style.display = 'none';
                            callDropdown.classList.add('hidden');
                        }, 200);
                    }
                });
            }
        }

        // Run immediately and also on a short delay to be sure
        initCallDropdown();
        setTimeout(initCallDropdown, 500);

        // --- CALL LINK PARSING & RENDERING ---
        window.parseCallLink = function(text) {
            if (!text) return null;
            const regex = /(https?:\/\/[^\s]+)?\/chat\/groups\/(video|voice)-call\?group_call_id=([a-zA-Z0-9_-]+)/;
            const match = text.match(regex);
            if (!match) return null;
            let fullUrl = match[0];
            if (!fullUrl.startsWith('http')) {
                fullUrl = window.location.origin + fullUrl;
            }
            return {
                url: fullUrl,
                type: match[2],
                id: match[3]
            };
        };

        window.renderCallLinkHTML = function(url, type, isMe) {
            const isVideo = type === 'video';
            const iconSvg = isVideo
                ? `<svg class="w-5 h-5 text-[#00a884]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>`
                : `<svg class="w-5 h-5 text-[#00a884]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>`;
            const typeLabel = isVideo ? 'Video' : 'Voice';

            return `
            <div class="flex flex-col gap-2.5 p-1.5 w-[260px] select-text">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-[#00a884]/20 flex items-center justify-center shrink-0">
                        ${iconSvg}
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="text-[#e9edef] font-semibold text-[14.5px]">Call link</span>
                        <span class="text-[12px] text-[#8696a0] truncate">Click to join this ${typeLabel.toLowerCase()} call</span>
                    </div>
                </div>
                <div class="h-px bg-white/10 my-1"></div>
                <a href="${url}" target="_blank" onclick="event.stopPropagation();" class="w-full py-2 bg-[#00a884] hover:bg-[#06cf9c] text-[#111b21] rounded-lg text-center font-bold text-sm block transition-all active:scale-[0.98] select-none">
                    Join call
                </a>
            </div>
            `;
        };

        // --- DYNAMIC CALL NAVIGATION ---
        window.startVoiceCall = function(userId, name, avatar) {
            let uId = userId,
                uName = name,
                uAvatar = avatar;
            if (!uId) {
                if (!window.activeChatUser) {
                    alert('Please select a chat first.');
                    return;
                }
                uId = window.activeChatUser.id;
                uName = window.activeChatUser.name;
                uAvatar = window.activeChatUser.avatar;
            }
            const params = new URLSearchParams({
                name: uName || 'User',
                avatar: uAvatar || '',
                role: 'caller',
                callee_id: uId
            });
            window.location.href = '/chat/voice-call?' + params.toString();
        };

        window.startVideoCall = function(userId, name, avatar) {
            let uId = userId,
                uName = name,
                uAvatar = avatar;
            if (!uId) {
                if (!window.activeChatUser) {
                    alert('Please select a chat first.');
                    return;
                }
                uId = window.activeChatUser.id;
                uName = window.activeChatUser.name;
                uAvatar = window.activeChatUser.avatar;
            }
            const params = new URLSearchParams({
                name: uName || 'User',
                avatar: uAvatar || '',
                role: 'caller',
                callee_id: uId
            });
            window.location.href = '/chat/video-call?' + params.toString();
        };

        // --- INCOMING CALL HANDLERS ---
        window._incomingCallId = null;
        window._incomingCallType = null;
        window._incomingCallerName = null;
        window._incomingCallerAvatar = null;

        window.showIncomingCall = function(callId, callerName, callerAvatar, callType, groupCallId) {
            window._incomingCallId = callId;
            window._incomingCallType = callType;
            window._incomingCallerName = callerName;
            window._incomingCallerAvatar = callerAvatar;
            window._incomingGroupCallId = groupCallId || null;
            document.getElementById('ic_caller_name').textContent = callerName;
            document.getElementById('ic_caller_avatar').src = callerAvatar || 'https://ui-avatars.com/api/?name=' +
                encodeURIComponent(callerName) + '&background=202c33&color=fff&size=240';
            document.getElementById('ic_call_type').textContent = callType === 'video' ? 'Video Call' : 'Voice Call';
            document.getElementById('incoming_call_overlay').classList.remove('hidden');
            try {
                document.getElementById('ic_ringtone').play().catch(() => {});
            } catch (e) {}
        };

        window.acceptIncomingCall = function() {
            try {
                document.getElementById('ic_ringtone').pause();
            } catch (e) {}
            document.getElementById('incoming_call_overlay').classList.add('hidden');
            const route = window._incomingCallType === 'video' ? '/chat/video-call' : '/chat/voice-call';
            const params = new URLSearchParams({
                name: window._incomingCallerName || 'User',
                avatar: window._incomingCallerAvatar || '',
                role: 'callee',
                call_id: window._incomingCallId
            });
            if (window._incomingGroupCallId) params.set('group_call_id', window._incomingGroupCallId);
            window.location.href = route + '?' + params.toString();
        };

        window.rejectIncomingCall = function() {
            try {
                document.getElementById('ic_ringtone').pause();
            } catch (e) {}
            document.getElementById('incoming_call_overlay').classList.add('hidden');
            // Update Firebase status to rejected
            if (window._rejectCallFn) window._rejectCallFn();
            // Send missed call message to chat
            if (window._incomingCallerId && window._sendMissedCallLog) {
                window._sendMissedCallLog();
            }
            window._incomingCallId = null;
        };

        // --- SPEECH-TO-TEXT LOGIC (INSIDE MIC) ---
        function toggleVoiceRecord() {
            if (isRecordingSpeechText) {
                if (recognition) recognition.stop();
                return;
            }

            if (!('webkitSpeechRecognition' in window) && !('SpeechRecognition' in window)) {
                alert('Voice typing is not supported in this browser.');
                return;
            }

            const SpeechRec = window.SpeechRecognition || window.webkitSpeechRecognition;
            recognition = new SpeechRec();
            recognition.continuous = false;
            recognition.interimResults = true;
            recognition.lang = 'gu-IN';

            recognition.onstart = function() {
                isRecordingSpeechText = true;
                const insideMicBtn = document.getElementById('inside_mic_btn');
                if (insideMicBtn) {
                    insideMicBtn.classList.replace('text-gray-400', 'text-red-500');
                    insideMicBtn.classList.add('animate-pulse');
                }
            };

            recognition.onresult = function(event) {
                let finalTranscript = '';
                for (let i = event.resultIndex; i < event.results.length; ++i) {
                    if (event.results[i].isFinal) {
                        finalTranscript += event.results[i][0].transcript;
                    }
                }
                if (finalTranscript) {
                    const msgInput = document.getElementById('msg');
                    msgInput.value += (msgInput.value ? ' ' : '') + finalTranscript;
                    handleInputToggle();
                }
            };

            recognition.onerror = function(event) {
                console.error('Speech recognition error', event.error);
                stopSpeechToText();
            };

            recognition.onend = function() {
                stopSpeechToText();
            };

            recognition.start();
        }

        function stopSpeechToText() {
            isRecordingSpeechText = false;
            const insideMicBtn = document.getElementById('inside_mic_btn');
            if (insideMicBtn) {
                insideMicBtn.classList.replace('text-red-500', 'text-gray-400');
                insideMicBtn.classList.remove('animate-pulse');
            }
        }

        let csrf = '';
        try {
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            if (csrfMeta) csrf = csrfMeta.getAttribute('content');
        } catch (e) {
            console.error('CSRF token not found');
        }
        window.csrf = csrf;
        window.myUserId = {{ auth()->id() ?? 1 }};


        // Global state for features
        window.globalMessages = {};
        window.replyingToKey = null;
        window.replyingToName = null;
        window.replyingToText = null;

        let leafletMapInstance = null;
        let leafletMarker = null;
        let currentLat = null;
        let currentLng = null;
        let currentAccuracy = null;
        let selectedDuration = 60; // default 1 hour
        let searchTimeout = null;

        window.shareLocation = function() {
            toggleAttachMenu();
            if (!navigator.geolocation) {
                alert("Geolocation is not supported by your browser");
                return;
            }

            document.getElementById('location_preview_modal').classList.remove('hidden');
            document.getElementById('location_default_panel').classList.remove('hidden');
            document.getElementById('live_location_config_panel').classList.add('hidden');
            document.getElementById('location_modal_title').textContent = 'Send location';
            document.getElementById('location_search_bar').classList.add('hidden');
            document.getElementById('search_results').innerHTML = '';

            fetchLocation();
        };

        window.fetchLocation = function() {
            navigator.geolocation.getCurrentPosition((position) => {
                currentLat = position.coords.latitude;
                currentLng = position.coords.longitude;
                currentAccuracy = Math.round(position.coords.accuracy);
                document.getElementById('accuracy_meters').textContent = currentAccuracy;

                if (!leafletMapInstance) {
                    leafletMapInstance = L.map('leaflet_map', {
                        zoomControl: false
                    }).setView([currentLat, currentLng], 16);

                    // Dark Theme map tiles
                    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                        attribution: '&copy; OpenStreetMap &copy; CARTO',
                        subdomains: 'abcd',
                        maxZoom: 20
                    }).addTo(leafletMapInstance);

                    // Custom WhatsApp-style blue dot
                    const myIcon = L.divIcon({
                        className: 'custom-div-icon',
                        html: `<div style="width: 16px; height: 16px; background-color: #4285F4; border: 3px solid white; border-radius: 50%; box-shadow: 0 0 4px rgba(0,0,0,0.5);"></div>`,
                        iconSize: [16, 16],
                        iconAnchor: [8, 8]
                    });

                    leafletMarker = L.marker([currentLat, currentLng], {
                        icon: myIcon,
                        draggable: true
                    }).addTo(leafletMapInstance);

                    leafletMarker.on('dragend', function(e) {
                        currentLat = leafletMarker.getLatLng().lat;
                        currentLng = leafletMarker.getLatLng().lng;
                        updateNearbyPlaces(currentLat, currentLng);
                    });

                    leafletMapInstance.on('moveend', function(e) {
                        // If marker is locked to center, update it
                        if (document.getElementById('live_location_config_panel').classList.contains(
                                'hidden')) {
                            const center = leafletMapInstance.getCenter();
                            currentLat = center.lat;
                            currentLng = center.lng;
                            leafletMarker.setLatLng(center);
                            updateNearbyPlaces(center.lat, center.lng);
                        }
                    });

                } else {
                    leafletMapInstance.setView([currentLat, currentLng], 16);
                    leafletMarker.setLatLng([currentLat, currentLng]);
                    setTimeout(() => leafletMapInstance.invalidateSize(), 100);
                    updateNearbyPlaces(currentLat, currentLng);
                }
            }, () => {
                alert("Unable to retrieve your location. Please allow location access.");
            }, {
                enableHighAccuracy: true
            });
        };

        window.centerOnMe = function() {
            fetchLocation();
        };

        window.refreshLocation = function() {
            fetchLocation();
        };

        window.toggleLocationSearch = function() {
            const sb = document.getElementById('location_search_bar');
            sb.classList.toggle('hidden');
            if (!sb.classList.contains('hidden')) document.getElementById('location_search_input').focus();
        };

        window.searchLocation = function(query) {
            clearTimeout(searchTimeout);
            if (query.length < 3) return;
            searchTimeout = setTimeout(async () => {
                try {
                    const res = await fetch(
                        `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`
                        );
                    const data = await res.json();
                    let html = '';
                    data.slice(0, 5).forEach(item => {
                        html += `
                            <div class="px-4 py-3 hover:bg-[#202c33] cursor-pointer flex items-center gap-4 transition-colors" onclick="selectPlace(${item.lat}, ${item.lon}, '${item.display_name.replace(/'/g, "\\'")}')">
                                <div class="w-10 h-10 rounded-full bg-[#2a3942] flex items-center justify-center text-[#8696a0] shrink-0">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"></path></svg>
                                </div>
                                <div class="border-b border-[#202c33] flex-1 pb-3 pt-1">
                                    <h3 class="text-white text-[16px] font-normal truncate max-w-[250px]">${item.display_name.split(',')[0]}</h3>
                                    <p class="text-[#8696a0] text-sm mt-0.5 truncate max-w-[250px]">${item.display_name}</p>
                                </div>
                            </div>`;
                    });
                    document.getElementById('search_results').innerHTML = html;
                } catch (e) {}
            }, 500);
        };

        window.updateNearbyPlaces = function(lat, lng) {
            // Using nominatim reverse geocoding to simulate nearby places
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(res => res.json())
                .then(data => {
                    if (data && data.address) {
                        const placeName = data.address.suburb || data.address.neighbourhood || data.address.road ||
                            data.display_name.split(',')[0];
                        document.getElementById('search_results').innerHTML = `
                            <div class="px-4 py-3 hover:bg-[#202c33] cursor-pointer flex items-center gap-4 transition-colors" onclick="sendSpecificLocation(${lat}, ${lng}, '${placeName.replace(/'/g, "\\'")}')">
                                <div class="w-10 h-10 rounded-full bg-[#2a3942] flex items-center justify-center text-[#8696a0] shrink-0">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"></path></svg>
                                </div>
                                <div class="border-b border-[#202c33] flex-1 pb-3 pt-1">
                                    <h3 class="text-white text-[16px] font-normal">${placeName}</h3>
                                    <p class="text-[#8696a0] text-sm mt-0.5 truncate max-w-[250px]">${data.display_name}</p>
                                </div>
                            </div>`;
                    }
                }).catch(e => {});
        };

        window.selectPlace = function(lat, lng, name) {
            currentLat = lat;
            currentLng = lng;
            leafletMapInstance.setView([lat, lng], 16);
            leafletMarker.setLatLng([lat, lng]);
            toggleLocationSearch();
        };

        window.openLiveLocationConfig = function() {
            document.getElementById('location_default_panel').classList.add('hidden');
            document.getElementById('live_location_config_panel').classList.remove('hidden');
            document.getElementById('location_modal_title').textContent = 'Share live location';

            // Show user avatar on map instead of blue dot
            const myAvatarIcon = L.divIcon({
                className: 'custom-div-icon',
                html: `<div style="width: 44px; height: 44px; background-color: #202c33; border-radius: 50%; overflow:hidden; border: 2px solid #1dae75; display:flex; justify-content:center; align-items:center; color:white; font-weight:bold; font-size: 20px;">{{ substr(auth()->user()->name ?? 'Me', 0, 1) }}</div>`,
                iconSize: [44, 44],
                iconAnchor: [22, 22]
            });
            leafletMarker.setIcon(myAvatarIcon);
        };

        window.selectDuration = function(mins) {
            selectedDuration = mins;
            document.querySelectorAll('.dur-btn').forEach(btn => {
                btn.classList.remove('bg-[#1dae75]', 'text-white');
                btn.classList.add('bg-[#2a3942]', 'text-[#8696a0]');
            });
            const selectedBtn = document.getElementById('dur_' + mins);
            selectedBtn.classList.remove('bg-[#2a3942]', 'text-[#8696a0]');
            selectedBtn.classList.add('bg-[#1dae75]', 'text-white');
        };

        window.sendCurrentLocation = function() {
            sendLocationToServer(currentLat, currentLng, '');
        };

        window.sendSpecificLocation = function(lat, lng, text) {
            sendLocationToServer(lat, lng, text);
        };

        window.startLiveLocation = function() {
            const comment = document.getElementById('live_loc_comment').value;
            sendLocationToServer(currentLat, currentLng, comment, 'live_location', selectedDuration);
        };

        window.sendLocationToServer = async function(lat, lng, text, msgType = 'location', duration = null) {
            if (!window.currentChatId) {
                alert('Please select a chat first.');
                return;
            }
            let formData = new FormData();
            formData.append('chat_id', window.currentChatId);
            formData.append('message', text || '');
            formData.append('type', msgType);
            formData.append('lat', lat);
            formData.append('lng', lng);
            if (duration) formData.append('duration', duration);

            if (window.replyingToKey && window.globalMessages[window.replyingToKey]) {
                formData.append('reply_to_id', window.replyingToKey);
                formData.append('reply_to_text', window.globalMessages[window.replyingToKey].text || 'Media');
            }

            document.getElementById('msg').value = "";
            closeLocationModal();
            cancelReply();

            try {
                await fetch('/send', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    body: formData
                });
            } catch (e) {
                console.error('Send error:', e);
            }
        };

        window.closeLocationModal = function() {
            document.getElementById('location_preview_modal').classList.add('hidden');
            if (leafletMarker) {
                // Reset to blue dot if it was changed
                const myIcon = L.divIcon({
                    className: 'custom-div-icon',
                    html: `<div style="width: 16px; height: 16px; background-color: #4285F4; border: 3px solid white; border-radius: 50%; box-shadow: 0 0 4px rgba(0,0,0,0.5);"></div>`,
                    iconSize: [16, 16],
                    iconAnchor: [8, 8]
                });
                leafletMarker.setIcon(myIcon);
            }
        };

        function toggleAttachMenu() {
            document.getElementById('attach_menu').classList.toggle('hidden');
        }

        function selectFile(accepts) {
            let fileInput = document.getElementById('file_input');
            fileInput.setAttribute('accept', accepts);
            fileInput.click();
            toggleAttachMenu();
        }

        // Close menu if clicked outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('attach_menu');
            const button = event.target.closest('button[onclick="toggleAttachMenu()"]');
            if (!button && menu && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
        });

        // HANDLE FILE SELECTION -> SHOW FULL SCREEN MODAL
        document.getElementById('file_input').addEventListener('change', function(e) {
            const file = this.files[0];
            if (!file) return;

            const modal = document.getElementById('media_preview_modal');
            const imgContainer = document.getElementById('modal_image_container');
            const fileContainer = document.getElementById('modal_file_container');
            const imgPreview = document.getElementById('modal_image_preview');
            const fileNameDisplay = document.getElementById('modal_file_name');
            const captionInput = document.getElementById('modal_caption');

            modal.classList.remove('hidden');
            captionInput.value = '';
            captionInput.focus();

            if (file.type.startsWith('image/')) {
                imgContainer.classList.remove('hidden');
                fileContainer.classList.add('hidden');
                const reader = new FileReader();
                reader.onload = function(e) {
                    imgPreview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            } else {
                imgContainer.classList.add('hidden');
                fileContainer.classList.remove('hidden');
                imgPreview.src = '';
                fileNameDisplay.textContent = file.name;
            }
        });

        function clearFile() {
            document.getElementById('file_input').value = "";
            document.getElementById('media_preview_modal').classList.add('hidden');
        }

        function autoResizeTextarea(el) {
            el.style.height = 'auto';
            el.style.height = el.scrollHeight + 'px';
        }

        function handleTextareaKey(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                send();
            }
        }

        // Core Send Function (used for text & modal)
        async function emitMessage(msgText, fileObj = null) {
            if (!window.currentChatId) {
                alert('Please select a chat first.');
                return;
            }
            if (msgText === "" && !fileObj) return;

            if (window.editingMessageKey) {
                const isGroup = window.currentChatId.startsWith('group_');
                let path = '';
                if (isGroup) {
                    let firebaseChatId = window.currentChatId;
                    if (firebaseChatId.startsWith('group_group_')) {
                        firebaseChatId = firebaseChatId.substring(6);
                    }
                    path = `groups/${firebaseChatId}/messages/${window.editingMessageKey}`;
                } else {
                    path = `chats/${window.currentChatId}/messages/${window.editingMessageKey}`;
                }

                try {
                    await window.update(window.ref(window.db, path), {
                        text: msgText,
                        is_edited: true,
                        edited_at: Math.floor(Date.now() / 1000)
                    });

                    if (!isGroup) {
                        window.update(window.ref(window.db, `chats/${window.currentChatId}`), {
                            'last_message': msgText,
                            'updated_at': Math.floor(Date.now() / 1000)
                        });
                    }
                } catch (e) {
                    console.error("Error editing message:", e);
                }

                window.cancelEdit();
                return;
            }

            const msgInput = document.getElementById('msg');
            if (msgInput && msgInput.disabled) {
                alert('You do not have permission to send messages to this group.');
                return;
            }

            if (window.currentChatId && typeof window.currentChatId === 'string' && window.currentChatId.startsWith(
                    'group_')) {
                let msgData = {
                    text: msgText,
                    sender_id: window.myUserId,
                    time: Math.floor(Date.now() / 1000),
                    type: 'text',
                    status: 'sent'
                };
                if (fileObj) {
                    const fd = new FormData();
                    fd.append('file', fileObj);
                    const res = await fetch('/upload-status-media', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf
                        },
                        body: fd
                    });
                    const rData = await res.json();
                    if (rData.status && rData.url) {
                        msgData.file_url = rData.url;
                        msgData.file_name = fileObj.name;
                        if (fileObj.type.startsWith('image/')) {
                            msgData.type = 'image';
                        } else if (fileObj.type.startsWith('video/')) {
                            msgData.type = 'video';
                        } else if (fileObj.type.startsWith('audio/')) {
                            msgData.type = 'audio';
                        } else {
                            msgData.type = 'document';
                        }
                    }
                }
                if (window.replyingToKey) {
                    msgData.reply_to_id = window.replyingToKey;
                    msgData.reply_to_text = window.replyingToText || (window.globalMessages[window.replyingToKey]
                        ?.text || 'Media');
                    msgData.reply_to_name = window.replyingToName || 'Member';
                    msgData.reply_to_media = window.replyingToMedia || null;
                }

                const msgEl = document.getElementById('msg');
                if (msgEl) {
                    msgEl.value = "";
                    autoResizeTextarea(msgEl);
                }
                clearFile();
                cancelReply();
                if (typeof handleInputToggle === 'function') handleInputToggle();

                await window.push(window.ref(window.db, `chats/${window.currentChatId}/messages`), msgData);
                document.getElementById('msg').focus();
                return;
            }

            let formData = new FormData();
            formData.append('chat_id', window.currentChatId);
            formData.append('message', msgText);

            if (fileObj) {
                formData.append('file', fileObj);
            }
            if (window.replyingToKey) {
                formData.append('reply_to_id', window.replyingToKey);
                formData.append('reply_to_text', window.replyingToText || (window.globalMessages[window.replyingToKey]?.text || 'Media'));
                formData.append('reply_to_name', window.replyingToName || 'Member');
                if (window.replyingToMedia) {
                    formData.append('reply_to_media', window.replyingToMedia);
                }
            }

            // Reset inputs
            const msgEl = document.getElementById('msg');
            if (msgEl) {
                msgEl.value = "";
                autoResizeTextarea(msgEl);
            }
            clearFile();
            cancelReply();
            if (typeof handleInputToggle === 'function') handleInputToggle();

            try {
                await fetch('/send', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    body: formData
                });
            } catch (e) {
                console.error('Send error:', e);
            }

            document.getElementById('msg').focus();
        }
        window.emitMessage = emitMessage;

        // Triggered by normal chat bar
        function send() {
            let msgInput = document.getElementById('msg');
            let fileInput = document.getElementById('file_input');
            emitMessage(msgInput.value.trim(), fileInput.files[0]);
        }

        //Location
        function openMap(lat, lng) {
            window.open(`https://www.google.com/maps?q=${lat},${lng}`);
        }

        // Triggered by Modal Button
        function sendFromModal() {
            let captionInput = document.getElementById('modal_caption');
            let fileInput = document.getElementById('file_input');
            emitMessage(captionInput.value.trim(), fileInput.files[0]);
        }

        function scrollToBottom() {
            const m = document.getElementById('messages');
            m.scrollTop = m.scrollHeight;
        }

        // Feature Actions
        window.askMetaAi = function(key, senderName, text) {
            // Close any open menus
            document.querySelectorAll('[id^="menu_"]').forEach(el => el.classList.add('hidden'));

            if (window.openMetaAiChat) {
                window.openMetaAiChat();
            }
            if (window.setMetaAiReplyContext) {
                window.setMetaAiReplyContext(key, senderName, text);
            }
        };

        window.replyingToMedia = null;
        window.replyingToType = null;

        window.replyTo = function(key) {
            window.closeMsgMenu(key);
            const msgData = window.globalMessages[key];
            if (!msgData) return;

            window.replyingToKey = key;
            window.replyingToMedia = msgData.file_url || null;
            window.replyingToType = msgData.type || null;

            let senderName = "Member";
            if (msgData.sender_id == window.myUserId) {
                senderName = "You";
            } else if (window.allContacts) {
                const match = window.allContacts.find(c => c.id == msgData.sender_id);
                if (match) senderName = match.name || match.phone;
            } else if (window.activeChatUser && window.activeChatUser.id == msgData.sender_id) {
                senderName = window.activeChatUser.name;
            }

            window.replyingToName = senderName;
            window.replyingToText = msgData.text || (msgData.type || 'Media');

            document.getElementById('replying_to_block').classList.remove('hidden');
            document.getElementById('replying_to_name').textContent = window.replyingToName;
            document.getElementById('replying_to_text').textContent = window.replyingToText;
            
            const mediaContainer = document.getElementById('replying_to_media_container');
            const mediaImg = document.getElementById('replying_to_media');
            const mediaVid = document.getElementById('replying_to_media_vid');
            const mediaVidIcon = document.getElementById('replying_to_media_vid_icon');
            
            if (window.replyingToMedia && (window.replyingToType === 'image' || window.replyingToType === 'video')) {
                mediaContainer.classList.remove('hidden');
                if (window.replyingToType === 'video') {
                    if (mediaImg) { mediaImg.classList.add('hidden'); mediaImg.src = ''; }
                    if (mediaVid) { mediaVid.classList.remove('hidden'); mediaVid.src = window.replyingToMedia + '#t=0.1'; }
                    if (mediaVidIcon) mediaVidIcon.classList.remove('hidden');
                } else {
                    if (mediaVid) { mediaVid.classList.add('hidden'); mediaVid.src = ''; }
                    if (mediaVidIcon) mediaVidIcon.classList.add('hidden');
                    if (mediaImg) { mediaImg.classList.remove('hidden'); mediaImg.src = window.replyingToMedia; }
                }
            } else {
                mediaContainer.classList.add('hidden');
                if (mediaImg) mediaImg.src = '';
                if (mediaVid) mediaVid.src = '';
            }

            document.getElementById('msg').focus();
        };

        window.replyToMsg = function(key, name, text, groupName = null, mediaUrl = null, mediaType = null) {
            window.replyingToKey = key;
            window.replyingToName = name;
            window.replyingToText = text;
            window.replyingToMedia = mediaUrl;
            window.replyingToType = mediaType;

            document.getElementById('replying_to_block').classList.remove('hidden');
            document.getElementById('replying_to_name').textContent = groupName ? `${name} . ${groupName}` : name;
            document.getElementById('replying_to_text').textContent = text;
            
            const mediaContainer = document.getElementById('replying_to_media_container');
            const mediaImg = document.getElementById('replying_to_media');
            const mediaVid = document.getElementById('replying_to_media_vid');
            const mediaVidIcon = document.getElementById('replying_to_media_vid_icon');
            
            if (mediaUrl && (mediaType === 'image' || mediaType === 'video')) {
                mediaContainer.classList.remove('hidden');
                if (mediaType === 'video') {
                    if (mediaImg) { mediaImg.classList.add('hidden'); mediaImg.src = ''; }
                    if (mediaVid) { mediaVid.classList.remove('hidden'); mediaVid.src = mediaUrl + '#t=0.1'; }
                    if (mediaVidIcon) mediaVidIcon.classList.remove('hidden');
                } else {
                    if (mediaVid) { mediaVid.classList.add('hidden'); mediaVid.src = ''; }
                    if (mediaVidIcon) mediaVidIcon.classList.add('hidden');
                    if (mediaImg) { mediaImg.classList.remove('hidden'); mediaImg.src = mediaUrl; }
                }
            } else {
                mediaContainer.classList.add('hidden');
                if (mediaImg) mediaImg.src = '';
                if (mediaVid) mediaVid.src = '';
            }

            document.getElementById('msg').focus();
        };

        window.cancelReply = function() {
            window.replyingToKey = null;
            window.replyingToName = null;
            window.replyingToText = null;
            window.replyingToMedia = null;
            window.replyingToType = null;
            document.getElementById('replying_to_block').classList.add('hidden');
        };

        window.scrollToAndHighlightMessage = function(msgId) {
            const el = document.getElementById('msg_' + msgId);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                // Remove existing highlight if any
                el.classList.remove('bg-white/20', 'transition-colors', 'duration-500', 'duration-1000');
                
                // Add highlight
                setTimeout(() => {
                    el.classList.add('bg-white/20', 'transition-colors', 'duration-500');
                    setTimeout(() => {
                        el.classList.remove('bg-white/20');
                        el.classList.add('duration-1000');
                        setTimeout(() => {
                            el.classList.remove('transition-colors', 'duration-500', 'duration-1000');
                        }, 1000);
                    }, 1000);
                }, 100);
            }
        };

        window.editingMessageKey = null;

        window.startEdit = function(key) {
            window.closeMsgMenu(key);
            const msgData = window.globalMessages[key];
            if (!msgData || msgData.type !== 'text') return;

            window.cancelReply();

            window.editingMessageKey = key;
            const text = msgData.text || "";

            document.getElementById('editing_to_block').classList.remove('hidden');
            document.getElementById('editing_to_text').textContent = text;

            const textarea = document.getElementById('msg');
            textarea.value = text;
            textarea.focus();
            autoResizeTextarea(textarea);
            if (typeof handleInputToggle === 'function') handleInputToggle();
        };

        window.cancelEdit = function() {
            window.editingMessageKey = null;
            document.getElementById('editing_to_block').classList.add('hidden');
            const textarea = document.getElementById('msg');
            textarea.value = "";
            autoResizeTextarea(textarea);
            if (typeof handleInputToggle === 'function') handleInputToggle();
        };

        // Multi-pin state
        window.pinnedMsgKeys = new Set();
        window._pinnedMsgsList = []; // Array of {key, text, time} sorted by time desc
        window._currentPinIndex = 0;

        window.toggleMsgMenu = function(key) {
            // close others
            document.querySelectorAll('[id^="menu_"]').forEach(el => {
                if (el.id !== 'menu_' + key) {
                    el.classList.add('hidden');
                    const k = el.id.replace('menu_', '');
                    const msgEl = document.getElementById('msg_' + k);
                    const bubbleEl = document.getElementById('bubble_' + k);
                    if (msgEl) msgEl.style.zIndex = '';
                    if (bubbleEl) bubbleEl.style.zIndex = '';
                }
            });
            const menu = document.getElementById('menu_' + key);

            // Dynamic text update for pin/unpin
            const pinBtnText = document.getElementById('pin_btn_text_' + key);
            if (pinBtnText) {
                pinBtnText.textContent = window.pinnedMsgKeys.has(key) ? 'Unpin' : 'Pin';
            }

            menu.classList.toggle('hidden');
            const parentMsg = document.getElementById('msg_' + key);
            const bubbleEl = document.getElementById('bubble_' + key);
            if (!menu.classList.contains('hidden')) {
                if (parentMsg) parentMsg.style.zIndex = '9999';
                if (bubbleEl) bubbleEl.style.zIndex = '9999';
            } else {
                if (parentMsg) parentMsg.style.zIndex = '';
                if (bubbleEl) bubbleEl.style.zIndex = '';
            }
        };

        window.pinPrivateMessage = function(messageKey) {
            if (!messageKey || !window.currentChatId) return;

            const msg = window.globalMessages[messageKey];
            if (!msg) return;

            let msgText = "Media";
            if (msg.text) {
                msgText = msg.text;
            } else if (msg.type) {
                msgText = msg.type.charAt(0).toUpperCase() + msg.type.slice(1);
            }

            // Write to pinned_msgs/${key} (multi-pin)
            set(ref(db, `chats/${window.currentChatId}/pinned_msgs/${messageKey}`), {
                text: msgText,
                time: msg.time || Math.floor(Date.now() / 1000)
            }).then(() => {
                window.showToast?.('Message Pinned', 'This message has been pinned.');
            }).catch(e => console.error("Pin private error:", e));

            // Hide the menu dropdown
            const menu = document.getElementById('menu_' + messageKey);
            if (menu) menu.classList.add('hidden');
        };

        window.unpinPrivateMessage = function(messageKey, event) {
            if (event) event.stopPropagation();
            if (!window.currentChatId) return;

            // If called with a specific key, remove that key; otherwise remove current pin
            const keyToRemove = messageKey || (window._pinnedMsgsList[window._currentPinIndex] ? window._pinnedMsgsList[
                window._currentPinIndex].key : null);
            if (!keyToRemove) return;

            remove(ref(db, `chats/${window.currentChatId}/pinned_msgs/${keyToRemove}`)).then(() => {
                window.showToast?.('Message Unpinned', 'This message has been unpinned.');
            }).catch(e => console.error("Unpin private error:", e));

            // Hide active menus
            document.querySelectorAll('[id^="menu_"]').forEach(el => el.classList.add('hidden'));
        };

        // Update pin icons on all visible messages
        window.updatePinIcons = function() {
            // Hide all pin icons first
            document.querySelectorAll('.msg-pin-icon').forEach(el => el.classList.add('hidden'));
            // document.querySelectorAll('[id^="pin_icon_"]').forEach(el => el.classList.add('hidden'));
            // Show pin icons for pinned messages
            window.pinnedMsgKeys.forEach(key => {
                const icon = document.getElementById('pin_icon_' + key);
                if (icon) icon.classList.remove('hidden');
            });
        };

        // Navigate between pinned messages
        window.navigatePin = function(direction) {
            if (!window._pinnedMsgsList.length) return;
            window._currentPinIndex = (window._currentPinIndex + direction + window._pinnedMsgsList.length) % window
                ._pinnedMsgsList.length;

            const pin = window._pinnedMsgsList[window._currentPinIndex];
            const pinText = document.getElementById('private_pinned_text');
            if (pinText) pinText.textContent = pin.text;

            window.scrollToMessage(pin.key);
        };

        // Scroll to currently displayed pin
        window.scrollToCurrentPin = function() {
            if (!window._pinnedMsgsList.length) return;
            const pin = window._pinnedMsgsList[window._currentPinIndex];
            if (pin) window.scrollToMessage(pin.key);
        };

        window.closeMsgMenu = function(key) {
            const menu = document.getElementById('menu_' + key);
            if (menu) menu.classList.add('hidden');
            const parentMsg = document.getElementById('msg_' + key);
            const bubbleEl = document.getElementById('bubble_' + key);
            if (parentMsg) parentMsg.style.zIndex = '';
            if (bubbleEl) bubbleEl.style.zIndex = '';
        };

        window.copyPrivateMessage = function(key) {
            window.closeMsgMenu(key);
            const msg = window.globalMessages[key];
            if (!msg) return;
            const textToCopy = msg.text || '';
            if (textToCopy) {
                navigator.clipboard.writeText(textToCopy).then(() => {
                    window.showToast?.('Copied', 'Message copied to clipboard.');
                }).catch(err => {
                    console.error('Could not copy text: ', err);
                });
            }
        };

        // Highlight search text in chat messages
        window.highlightSearchText = function(text) {
            if (!window.activeSearchQuery || !text) return text;
            const q = window.activeSearchQuery;
            const regex = new RegExp(`(${q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
            return text.replace(regex, '<mark class="search-highlight">$1</mark>');
        };

        window.filterSidebar = function() {
            const searchQuery = document.getElementById('sidebar_search').value.toLowerCase().trim();
            const clearBtn = document.getElementById('sidebar_search_clear');
            const userList = document.getElementById('user_list_container');
            const searchResults = document.getElementById('search_results_container');
            const chatsList = document.getElementById('search_chats_list');
            const msgsList = document.getElementById('search_messages_list');
            const chatsSection = document.getElementById('search_chats_section');
            const msgsSection = document.getElementById('search_messages_section');
            const noResults = document.getElementById('sidebar_no_results');

            // Show/hide clear button
            if (searchQuery.length > 0) {
                clearBtn?.classList.remove('hidden');
            } else {
                clearBtn?.classList.add('hidden');
            }

            // No query - show normal list
            if (searchQuery === '') {
                userList.classList.remove('hidden');
                searchResults?.classList.add('hidden');
                noResults?.classList.add('hidden');
                noResults?.classList.remove('flex');
                
                const chipContainer = document.getElementById('search_selected_filter_chip');
                const hasFilter = chipContainer && !chipContainer.classList.contains('hidden');
                if (hasFilter && window.currentGlobalSearchFilter === 'unread') {
                    if (window.setSidebarFilter) window.setSidebarFilter('unread');
                }
                return;
            }

            // Hide normal list, show search results
            userList.classList.add('hidden');
            searchResults?.classList.remove('hidden');

            // Clear previous results
            if (chatsList) chatsList.innerHTML = '';
            if (msgsList) msgsList.innerHTML = '';

            const users = document.getElementById('user_list_container').querySelectorAll('[id^="user_sidebar_"]');
            let chatMatches = 0;
            let allMsgResults = []; // Collect all message matches across all users

            const escQ = searchQuery.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            const highlightRegex = new RegExp(`(${escQ})`, 'gi');

            users.forEach(user => {
                const userId = user.getAttribute('data-userid') || user.id.replace('user_sidebar_', '');
                
                const chipContainer = document.getElementById('search_selected_filter_chip');
                const hasFilter = chipContainer && !chipContainer.classList.contains('hidden');
                if (hasFilter && window.currentGlobalSearchFilter === 'unread') {
                    const isGroup = user.id.startsWith('group_sidebar_');
                    const badge = isGroup ? document.getElementById(`group_unread_badge_${userId}`) : document.getElementById(`unread_badge_${userId}`);
                    const isUnread = badge && !badge.classList.contains('hidden') && parseInt(badge.textContent) > 0;
                    if (!isUnread) return;
                }

                const name = user.getAttribute('data-name') || user.querySelector('h4')?.textContent.trim() ||
                    '';
                const avatar = user.getAttribute('data-avatar') || '';
                const phone = user.getAttribute('data-phone') || '';
                const about = user.getAttribute('data-about') || 'Available';
                const lastTimeEl = document.getElementById(`last_time_${userId}`);
                const lastTime = lastTimeEl ? lastTimeEl.textContent.trim() : '';
                const lastMsgEl = document.getElementById(`last_msg_${userId}`);
                const lastMsg = lastMsgEl ? (lastMsgEl.getAttribute('data-msg') || lastMsgEl.textContent
                .trim()) : '';

                const nameLower = name.toLowerCase();
                const nameMatch = nameLower.includes(searchQuery);

                // Chat name match -> Chats section
                if (nameMatch && chatsList) {
                    chatMatches++;
                    const highlightedName = name.replace(highlightRegex,
                        '<span class="text-[#00a884] font-medium">$1</span>');
                    const prefix = lastMsg ? (lastMsg.startsWith('Click to chat') ? '' : '✓ ') : '';
                    const previewMsg = lastMsg && !lastMsg.startsWith('Click to chat') ? prefix + lastMsg :
                        phone || 'Click to chat';

                    const safeAvatar = window.getUserAvatar ? window.getUserAvatar(userId) : avatar;
                    chatsList.insertAdjacentHTML('beforeend', `
                        <div onclick="window.selectChat(${userId}, '${name.replace(/'/g, "\\'")}', '${phone.replace(/'/g, "\\'")}', '${safeAvatar}', '${about.replace(/'/g, "\\'")}')"
                            class="flex items-center px-3 py-3 hover:bg-[#202c33] cursor-pointer transition-colors relative group user-chat-item" data-userid="${userId}">
                            <div class="w-12 h-12 rounded-full overflow-hidden bg-[#2a3942] flex items-center justify-center shrink-0">
                                <img src="${safeAvatar}" class="w-full h-full object-cover">
                            </div>
                            <div class="ml-3 flex-1 border-b border-[#202c33] pb-3 pt-1 min-w-0 pr-6 relative">
                                <div class="flex justify-between items-center">
                                    <h4 class="text-[17px] text-[#e9edef] truncate mr-2 font-normal">${highlightedName}</h4>
                                    <span class="text-[12px] text-[#8696a0] whitespace-nowrap">${lastTime}</span>
                                </div>
                                <p class="text-[14px] text-[#8696a0] truncate mt-0.5 leading-snug">${previewMsg}</p>
                            </div>
                            <!-- Dropdown Trigger Button with Gradient Overlay -->
                            <div class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-[#202c33] via-[#202c33] to-transparent hidden group-hover:flex items-center justify-end pr-3 z-20 options-btn-gradient">
                                <button onclick="event.stopPropagation(); window.toggleUserContextMenu(event, ${userId}, '${name.replace(/'/g, "\\'")}', 'user')"
                                    class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none">
                                    <svg viewBox="0 0 19 20" width="19" height="20" fill="currentColor">
                                        <path d="M3.8 6.7l5.7 5.7 5.7-5.7 1.6 1.6-7.3 7.2-7.3-7.2 1.6-1.6z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    `);
                }

                // Search through ALL cached messages -> collect for Messages section
                const cachedMessages = window.messageCache?.[userId] || [];
                for (let i = 0; i < cachedMessages.length; i++) {
                    const m = cachedMessages[i];
                    if (m.text && m.text.toLowerCase().includes(searchQuery)) {
                        allMsgResults.push({
                            userId,
                            name,
                            avatar,
                            phone,
                            about,
                            text: m.text,
                            time: m.time,
                            senderId: m.senderId
                        });
                    }
                }
            });

            // Sort message results by date (newest first)
            allMsgResults.sort((a, b) => (b.time || 0) - (a.time || 0));

            // Render all message results
            allMsgResults.forEach(r => {
                const msgTime = r.time ? new Date(r.time * 1000) : null;
                let timeStr = '';
                if (msgTime) {
                    const now = new Date();
                    const todayStart = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                    const msgDayStart = new Date(msgTime.getFullYear(), msgTime.getMonth(), msgTime.getDate());
                    const diffDays = Math.round((todayStart - msgDayStart) / (1000 * 60 * 60 * 24));
                    if (diffDays === 0) timeStr = msgTime.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    else if (diffDays === 1) timeStr = 'Yesterday';
                    else if (diffDays < 7) timeStr = msgTime.toLocaleDateString([], {
                        weekday: 'long'
                    });
                    else timeStr = msgTime.toLocaleDateString([], {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    });
                }

                const highlightedMsg = r.text.replace(highlightRegex,
                    '<span class="text-[#00a884] font-medium">$1</span>');
                const prefix = r.senderId == window.myUserId ? '<span class="text-[#8696a0]">✓ You: </span>' :
                    '';

                if (msgsList) {
                    const safeAvatar = window.getUserAvatar ? window.getUserAvatar(r.userId) : r.avatar;
                    msgsList.insertAdjacentHTML('beforeend', `
                        <div onclick="window.selectChat(${r.userId}, '${r.name.replace(/'/g, "\\'")}', '${r.phone.replace(/'/g, "\\'")}', '${safeAvatar}', '${r.about.replace(/'/g, "\\'")}', ${r.time || 0})"
                            class="flex items-center px-3 py-3 hover:bg-[#202c33] cursor-pointer transition-colors relative group user-chat-item" data-userid="${r.userId}">
                            <div class="w-12 h-12 rounded-full overflow-hidden bg-[#2a3942] flex items-center justify-center shrink-0">
                                <img src="${safeAvatar}" class="w-full h-full object-cover">
                            </div>
                            <div class="ml-3 flex-1 border-b border-[#202c33] pb-3 pt-1 min-w-0 pr-6 relative">
                                <div class="flex justify-between items-center">
                                    <h4 class="text-[16px] text-[#e9edef] truncate mr-2 font-normal">${r.name}</h4>
                                    <span class="text-[12px] text-[#8696a0] whitespace-nowrap">${timeStr}</span>
                                </div>
                                <p class="text-[14px] text-[#8696a0] truncate mt-0.5 leading-snug">${prefix}${highlightedMsg}</p>
                            </div>
                            <!-- Dropdown Trigger Button with Gradient Overlay -->
                            <div class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-[#202c33] via-[#202c33] to-transparent hidden group-hover:flex items-center justify-end pr-3 z-20 options-btn-gradient">
                                <button onclick="event.stopPropagation(); window.toggleUserContextMenu(event, ${r.userId}, '${r.name.replace(/'/g, "\\'")}', 'user')"
                                    class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none">
                                    <svg viewBox="0 0 19 20" width="19" height="20" fill="currentColor">
                                        <path d="M3.8 6.7l5.7 5.7 5.7-5.7 1.6 1.6-7.3 7.2-7.3-7.2 1.6-1.6z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    `);
                }
            });

            const msgMatches = allMsgResults.length;

            // Toggle section visibility
            if (chatsSection) {
                if (chatMatches > 0) {
                    chatsSection.classList.remove('hidden');
                } else {
                    chatsSection.classList.add('hidden');
                }
            }
            if (msgsSection) {
                if (msgMatches > 0) {
                    msgsSection.classList.remove('hidden');
                } else {
                    msgsSection.classList.add('hidden');
                }
            }

            // No results at all
            if (noResults) {
                if (chatMatches === 0 && msgMatches === 0) {
                    noResults.classList.remove('hidden');
                    noResults.classList.add('flex');
                } else {
                    noResults.classList.add('hidden');
                    noResults.classList.remove('flex');
                }
            }
        };

        // Search bar animation helpers
        window.onSidebarSearchFocus = function() {
            document.getElementById('sidebar_search_icon')?.classList.add('hidden');
            document.getElementById('sidebar_back_icon')?.classList.remove('hidden');
            
            // Toggle filters
            document.getElementById('chat_filters_container')?.classList.add('hidden');
            document.getElementById('chat_filters_container')?.classList.remove('flex');
            document.getElementById('global_search_filters_container')?.classList.remove('hidden');
            document.getElementById('global_search_filters_container')?.classList.add('flex');
        };

        window.onSidebarSearchBlur = function() {
            setTimeout(() => {
                const input = document.getElementById('sidebar_search');
                // Don't revert if a filter chip is active
                const chipContainer = document.getElementById('search_selected_filter_chip');
                const hasFilter = chipContainer && !chipContainer.classList.contains('hidden');
                
                if (!hasFilter && (!input || input.value.trim() === '')) {
                    document.getElementById('sidebar_search_icon')?.classList.remove('hidden');
                    document.getElementById('sidebar_back_icon')?.classList.add('hidden');
                    
                    // Toggle filters back
                    document.getElementById('global_search_filters_container')?.classList.add('hidden');
                    document.getElementById('global_search_filters_container')?.classList.remove('flex');
                    document.getElementById('chat_filters_container')?.classList.remove('hidden');
                    document.getElementById('chat_filters_container')?.classList.add('flex');
                }
            }, 150);
        };

        window.blurSidebarSearch = function() {
            const input = document.getElementById('sidebar_search');
            if (input) {
                input.value = '';
                input.blur();
            }
            window.activeSearchQuery = null;
            window.activeSearchMsgTime = null;
            
            // Revert filter if we applied it via global search
            const chipContainer = document.getElementById('search_selected_filter_chip');
            const hasFilter = chipContainer && !chipContainer.classList.contains('hidden');
            if (hasFilter && window.currentGlobalSearchFilter === 'unread') {
                if (window.setSidebarFilter) window.setSidebarFilter('all');
            }
            window.currentGlobalSearchFilter = null;
            
            window.filterSidebar();
            
            // Clear chip and restore search UI
            if (chipContainer) {
                chipContainer.classList.add('hidden');
                chipContainer.classList.remove('flex');
                chipContainer.innerHTML = '';
            }
            
            const searchInput = document.getElementById('sidebar_search');
            if (searchInput) {
                searchInput.placeholder = 'Ask Meta AI or Search';
                searchInput.classList.add('ml-4');
                searchInput.classList.remove('ml-2');
            }
            
            document.getElementById('sidebar_search_list_view')?.classList.add('hidden');
            document.getElementById('sidebar_search_list_view')?.classList.remove('block');
            
            // Restore views
            document.getElementById('user_list_container')?.classList.remove('hidden');
            document.getElementById('global_search_results_container')?.classList.add('hidden');
            document.getElementById('global_search_results_container')?.classList.remove('flex');
            
            // Remove selection styles from buttons
            document.querySelectorAll('.global-search-filter').forEach(btn => {
                btn.classList.remove('bg-[#0a332c]');
                btn.classList.add('bg-[#202c33]');
                btn.querySelector('svg')?.classList.remove('text-[#00a884]');
                btn.querySelector('span')?.classList.remove('text-[#00a884]');
                btn.querySelector('svg')?.classList.add('text-[#aebac1]');
                btn.querySelector('span')?.classList.add('text-[#aebac1]');
            });
            
            document.getElementById('sidebar_search_icon')?.classList.remove('hidden');
            document.getElementById('sidebar_back_icon')?.classList.add('hidden');
            document.getElementById('sidebar_search_clear')?.classList.add('hidden');
        };

        window.clearSidebarSearch = function() {
            const input = document.getElementById('sidebar_search');
            if (input) {
                input.value = '';
                input.focus();
            }
            
            // If there's a filter active, clear it too
            const chipContainer = document.getElementById('search_selected_filter_chip');
            if (chipContainer && !chipContainer.classList.contains('hidden')) {
                window.blurSidebarSearch();
                // We keep focus in this case but blur logic does what we need
                document.getElementById('sidebar_search')?.focus();
            } else {
                window.filterSidebar();
            }
        };

        window.showToast = function(title, body, otherUserId = null, otherName = null) {
            const container = document.getElementById('toast_container');
            const id = Date.now();
            const clickAttr = (otherUserId && otherName) ?
                `onclick="window.selectChat('${otherUserId}', '${otherName.replace(/'/g, "\\'")}', ''); this.remove();"` :
                '';

            const html = `
                <div id="toast_${id}" ${clickAttr} class="toast-enter bg-white border border-gray-100 rounded-2xl shadow-2xl p-4 flex gap-4 w-full pointer-events-auto cursor-pointer hover:bg-gray-50 hover:scale-[1.02] active:scale-[0.98] transition-all border-l-4 border-l-green-500">
                    <div class="w-12 h-12 rounded-full bg-green-500/10 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-[15px] font-bold text-gray-900 truncate">${title}</div>
                        <div class="text-[13px] text-gray-500 mt-0.5 line-clamp-2">${body}</div>
                    </div>
                    <button onclick="event.stopPropagation(); this.parentElement.remove()" class="text-gray-400 hover:text-gray-600 focus:outline-none self-start">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>`;

            container.insertAdjacentHTML('afterbegin', html);
            const toast = document.getElementById(`toast_${id}`);

            // Play a subtle sound if possible
            try {
                new Audio('https://assets.mixkit.co/active_storage/sfx/2354/2354-preview.mp3').play();
            } catch (e) {}

            // Auto remove after 8 seconds
            setTimeout(() => {
                if (toast) {
                    toast.style.transform = 'translateX(120%)';
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 400);
                }
            }, 8000);
        };

        window.toggleSearchPanel = function() {
            const sidebar = document.getElementById('search_sidebar');
            if (!sidebar) return;
            const isHidden = sidebar.classList.contains('hidden');
            if (isHidden) {
                // Close other panels
                if (window.closeContactInfo) window.closeContactInfo();
                if (window.closeGroupInfoPanel) window.closeGroupInfoPanel();
                if (window.closeBroadcastInfo) window.closeBroadcastInfo();
                const metaAiPanel = document.getElementById('meta_ai_info_panel');
                if (metaAiPanel) {
                    metaAiPanel.classList.add('translate-x-full');
                    metaAiPanel.classList.remove('translate-x-0');
                }

                sidebar.classList.remove('hidden');
                sidebar.classList.add('flex');
                document.getElementById('search_messages_input').focus();
                document.getElementById('no_results_text').querySelector('p').textContent =
                    `Search for messages with ${document.getElementById('active_chat_title').textContent}`;
            } else {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('flex');
            }
        };

        window.clearMessageSearch = function() {
            const input = document.getElementById('search_messages_input');
            input.value = '';
            document.getElementById('clear_search_btn').classList.add('hidden');
            document.getElementById('search_results_list').innerHTML = '';
            document.getElementById('no_results_text').classList.remove('hidden');
            input.focus();
        };

        window.performMessageSearch = function(query) {
            const clearBtn = document.getElementById('clear_search_btn');
            const resultsList = document.getElementById('search_results_list');
            const noResults = document.getElementById('no_results_text');

            if (!query.trim()) {
                clearBtn.classList.add('hidden');
                resultsList.innerHTML = '';
                noResults.classList.remove('hidden');
                return;
            }

            clearBtn.classList.remove('hidden');
            noResults.classList.add('hidden');

            const searchTerm = query.toLowerCase();
            const results = [];

            for (let key in window.globalMessages) {
                const msg = window.globalMessages[key];
                if (msg.text && msg.text.toLowerCase().includes(searchTerm)) {
                    results.push({
                        ...msg,
                        key
                    });
                }
            }

            // Sort results by time descending
            results.sort((a, b) => b.time - a.time);

            renderMessageSearchResults(results, searchTerm);
        };

        window.renderMessageSearchResults = function(results, searchTerm) {
            const resultsList = document.getElementById('search_results_list');
            resultsList.innerHTML = '';

            if (results.length === 0) {
                resultsList.innerHTML = `<div class="p-10 text-center text-[#8696a0] text-sm">No messages found</div>`;
                return;
            }

            let lastDate = '';

            results.forEach(msg => {
                const date = window.getDateHeader(msg.time);
                if (date !== lastDate) {
                    lastDate = date;
                    resultsList.insertAdjacentHTML('beforeend',
                        `<div class="px-6 py-4 text-[#8696a0] text-[13px] font-medium">${date}</div>`);
                }

                // Highlight search term
                const regex = new RegExp(`(${searchTerm})`, 'gi');
                const highlightedText = msg.text.replace(regex,
                    '<span class="text-[#00a884] font-medium">$1</span>');
                const time = new Date(msg.time * 1000).toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                const isMe = msg.sender_id == window.myUserId;

                const html = `
                    <div class="px-6 py-3 hover:bg-[#202c33] cursor-pointer transition-colors border-b border-gray-800/30 group" onclick="window.scrollToMessage('${msg.key}')">
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center gap-1">
                                ${isMe ? `<span class="shrink-0">${window.getTickSVG(msg.status || 'sent')}</span>` : ''}
                                <p class="text-[#e9edef] text-[15px] line-clamp-2 leading-relaxed">${highlightedText}</p>
                            </div>
                        </div>
                    </div>`;
                resultsList.insertAdjacentHTML('beforeend', html);
            });
        };

        window.scrollToMessage = function(key) {
            const el = document.getElementById('msg_' + key);
            if (el) {
                el.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                el.classList.add('bg-[#00a884]/20');
                setTimeout(() => {
                    el.classList.remove('bg-[#00a884]/20');
                }, 2000);
            }
        };
    </script>

    <script type="module">
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
        import {
            getDatabase,
            ref,
            push,
            get,
            onChildAdded,
            remove,
            onChildRemoved,
            onValue,
            onDisconnect,
            set,
            serverTimestamp,
            onChildChanged,
            update,
            query,
            limitToLast
        } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-database.js";
        import {
            getMessaging,
            getToken,
            onMessage
        } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging.js";
        import {
            getStorage,
            ref as sRef,
            uploadBytesResumable,
            getDownloadURL
        } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-storage.js";

        const firebaseConfig = {
            apiKey: "{{ env('FIREBASE_API_KEY') }}",
            authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
            databaseURL: "{{ env('FIREBASE_DATABASE_URL') }}",
            projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
            storageBucket: "{{ env('FIREBASE_PROJECT_ID') }}.appspot.com",
            messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
            appId: "{{ env('FIREBASE_APP_ID') }}"
        };

        const app = initializeApp(firebaseConfig);
        const db = getDatabase(app);
        const messaging = getMessaging(app);
        const storage = getStorage(app);

        const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
        window.csrf = csrf;

        // Expose to window for global access
        window.firebaseApp = app;
        window.db = db;
        window.storage = storage;
        window.ref = ref;
        window.get = get;
        window.update = update;
        window.remove = remove;
        window.set = set;
        window.push = push;
        window.onValue = onValue;
        window.onChildAdded = onChildAdded;
        window.onChildChanged = onChildChanged;
        window.onChildRemoved = onChildRemoved;
        window.onDisconnect = onDisconnect;
        window.remove = remove;
        window.get = get;
        window.query = query;
        window.limitToLast = limitToLast;
        window.serverTimestamp = serverTimestamp;
        window.storage = storage;
        window.sRef = sRef;
        window.uploadBytesResumable = uploadBytesResumable;
        window.getDownloadURL = getDownloadURL;
        window.myUserId = {{ auth()->id() ?? '0' }};
        window.myUserName = "{{ auth()->user()->name ?? 'Me' }}";
        window.myUserAvatar = "{{ auth()->user()->avatar ?? '' }}";
        window.currentChatId = null;
        window.allContacts = @json($users ?? []);
        window.unsubscribeAdded = null;
        window.unsubscribeRemoved = null;
        window.statusUnsubscribe = null;
        window.selectedMessages = new Set();
        window.isSelectionMode = false;

        window.usersPrivacyData = {};
        window.chatDisappearingTimers = {};

        window.updateDisappearingBadge = function(chatId, isDisappearing) {
            try {
                if (!chatId) return;

                let sidebarWrapperId = '';
                let headerWrapperId = '';

                if (chatId.startsWith('group_')) {
                    const cleanGroupId = chatId.replace('group_', '');
                    sidebarWrapperId = `avatar_wrapper_group_${cleanGroupId}`;
                    headerWrapperId = `active_group_chat_avatar`;
                } else if (chatId.startsWith('chat_')) {
                    const parts = chatId.replace('chat_', '').split('_');
                    const otherUserId = parts.find(id => String(id) !== String(window.myUserId));
                    if (!otherUserId) return;
                    sidebarWrapperId = `avatar_wrapper_user_${otherUserId}`;
                    headerWrapperId = `active_chat_avatar`;
                } else {
                    return;
                }

                const sidebarWrapper = document.getElementById(sidebarWrapperId);
                if (sidebarWrapper) {
                    const existing = sidebarWrapper.querySelector('.disappearing-badge');
                    if (existing) existing.remove();

                    if (isDisappearing) {
                        const img = sidebarWrapper.querySelector('img');
                        if (img) img.classList.add('rounded-full');

                        const badge = document.createElement('div');
                        badge.className = "disappearing-badge absolute -bottom-0.5 -right-0.5 w-[18px] h-[18px] bg-[#111b21] rounded-full flex items-center justify-center border border-[#111b21] z-10 shadow-md";
                        badge.innerHTML = `
                            <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="#8696a0" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="stroke-dasharray: 4 2;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 6v6l4 2"></path>
                            </svg>
                        `;
                        sidebarWrapper.appendChild(badge);
                    }
                }

                const headerWrapper = document.getElementById(headerWrapperId);
                if (headerWrapper) {
                    const existing = headerWrapper.querySelector('.disappearing-badge');
                    if (existing) existing.remove();

                    if (isDisappearing) {
                        const img = headerWrapper.querySelector('img');
                        if (img) img.classList.add('rounded-full');

                        const badge = document.createElement('div');
                        badge.className = "disappearing-badge absolute -bottom-1 -right-1 w-[16px] h-[16px] bg-[#202c33] rounded-full flex items-center justify-center border border-[#202c33] z-10 shadow-md";
                        badge.innerHTML = `
                            <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="#8696a0" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="stroke-dasharray: 4 2;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 6v6l4 2"></path>
                            </svg>
                        `;
                        headerWrapper.appendChild(badge);
                    }
                }
            } catch (err) {
                console.error("Error in updateDisappearingBadge:", err);
            }
        };

        window.isAvatarVisible = function(otherUserId) {
            if (String(otherUserId) === String(window.myUserId)) {
                return true;
            }
            const privacy = window.usersPrivacyData ? window.usersPrivacyData[otherUserId] : null;
            if (!privacy) {
                return true;
            }
            const mode = privacy.profile_photo || 'Everyone';
            if (mode === 'Everyone') {
                return true;
            }
            if (mode === 'Nobody') {
                return false;
            }
            if (mode === 'My contacts') {
                return true;
            }
            if (mode === 'My contacts except...' || mode.includes('excluded')) {
                const excludeList = privacy.profile_photo_exclude || [];
                if (excludeList.includes(String(window.myUserId)) || excludeList.includes(Number(window.myUserId))) {
                    return true;
                }
                return false;
            }
            return true;
        };

        window.isLastSeenVisible = function(otherUserId) {
            if (String(otherUserId) === String(window.myUserId)) {
                return true;
            }
            const privacy = window.usersPrivacyData ? window.usersPrivacyData[otherUserId] : null;
            if (!privacy) {
                return true;
            }
            const mode = privacy.last_seen || 'Everyone';
            if (mode === 'Everyone') {
                return true;
            }
            if (mode === 'Nobody') {
                return false;
            }
            if (mode === 'My contacts') {
                return true;
            }
            if (mode === 'My contacts except...' || mode.includes('excluded')) {
                const excludeList = privacy.last_seen_exclude || [];
                // Only users in excludeList can see it (inverted logic)
                if (excludeList.includes(String(window.myUserId)) || excludeList.includes(Number(window.myUserId))) {
                    return true;
                }
                return false;
            }
            return true;
        };

        window.isOnlineVisible = function(otherUserId) {
            if (String(otherUserId) === String(window.myUserId)) {
                return true;
            }
            const privacy = window.usersPrivacyData ? window.usersPrivacyData[otherUserId] : null;
            if (!privacy) {
                return true;
            }
            const onlineMode = privacy.online || 'Everyone';
            if (onlineMode === 'Everyone') {
                return true;
            }
            if (onlineMode === 'Same as last seen') {
                return window.isLastSeenVisible(otherUserId);
            }
            return true;
        };

        window.updateActiveChatSubtitle = function(statusData = null) {
            const subtitle = document.getElementById('active_chat_subtitle');
            if (!subtitle || !window.activeChatUser) return;

            const otherUserId = window.activeChatUser.id;

            if (statusData) {
                window.latestActiveChatStatusData = statusData;
            }

            const data = window.latestActiveChatStatusData;
            if (!data) {
                subtitle.classList.add('hidden');
                return;
            }

            const isOnline = data.state === 'online';

            if (isOnline) {
                if (window.isOnlineVisible && window.isOnlineVisible(otherUserId)) {
                    subtitle.textContent = 'online';
                    subtitle.classList.remove('hidden', 'text-gray-500');
                    subtitle.classList.add('text-green-600');
                } else {
                    if (window.isLastSeenVisible && window.isLastSeenVisible(otherUserId) && data.last_changed) {
                        const date = new Date(data.last_changed);
                        const text = 'last seen ' + date.toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                        subtitle.textContent = text;
                        subtitle.classList.remove('hidden', 'text-green-600');
                        subtitle.classList.add('text-gray-500');
                    } else {
                        subtitle.classList.add('hidden');
                    }
                }
            } else {
                if (window.isLastSeenVisible && window.isLastSeenVisible(otherUserId) && data.last_changed) {
                    const date = new Date(data.last_changed);
                    const text = 'last seen ' + date.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    subtitle.textContent = text;
                    subtitle.classList.remove('hidden', 'text-green-600');
                    subtitle.classList.add('text-gray-500');
                } else {
                    subtitle.classList.add('hidden');
                }
            }
        };

        window.isAboutVisible = function(otherUserId) {
            if (String(otherUserId) === String(window.myUserId)) {
                return true;
            }
            const privacy = window.usersPrivacyData ? window.usersPrivacyData[otherUserId] : null;
            if (!privacy) {
                return true;
            }
            const mode = privacy.about || 'Everyone';
            if (mode === 'Everyone') {
                return true;
            }
            if (mode === 'Nobody') {
                return false;
            }
            if (mode === 'My contacts') {
                return true;
            }
            if (mode === 'My contacts except...' || mode.includes('excluded')) {
                const excludeList = privacy.about_exclude || [];
                // Only users in excludeList can see it (inverted logic)
                if (excludeList.includes(String(window.myUserId)) || excludeList.includes(Number(window.myUserId))) {
                    return true;
                }
                return false;
            }
            return true;
        };

        window.toggleCustomAudioSpeed = function(key) {
            const audio = document.getElementById(`audio_element_${key}`);
            const btn = document.getElementById(`audio_speed_${key}`);
            if (!audio || !btn) return;
            let nextSpeed = 1.0;
            if (audio.playbackRate === 1.0) {
                nextSpeed = 1.5;
            } else if (audio.playbackRate === 1.5) {
                nextSpeed = 2.0;
            } else {
                nextSpeed = 1.0;
            }
            audio.playbackRate = nextSpeed;
            btn.textContent = nextSpeed + 'x';
        };

        window.toggleCustomAudioPlay = function(key) {
            const audio = document.getElementById(`audio_element_${key}`);
            const playSvg = document.getElementById(`play_svg_${key}`);
            const pauseSvg = document.getElementById(`pause_svg_${key}`);
            if (!audio) return;
            
            document.querySelectorAll('audio[id^="audio_element_"]').forEach(el => {
                if (el.id !== `audio_element_${key}` && !el.paused) {
                    el.pause();
                    const otherKey = el.id.replace('audio_element_', '');
                    const otherPlay = document.getElementById(`play_svg_${otherKey}`);
                    const otherPause = document.getElementById(`pause_svg_${otherKey}`);
                    if (otherPlay) otherPlay.classList.remove('hidden');
                    if (otherPause) otherPause.classList.add('hidden');
                }
            });

            if (audio.paused) {
                const playPromise = audio.play();
                if (playPromise !== undefined) {
                    playPromise.catch(e => {
                        console.error("Audio playback error:", e);
                        if (playSvg) playSvg.classList.remove('hidden');
                        if (pauseSvg) pauseSvg.classList.add('hidden');
                    });
                }
                if (playSvg) playSvg.classList.add('hidden');
                if (pauseSvg) pauseSvg.classList.remove('hidden');
            } else {
                audio.pause();
                if (playSvg) playSvg.classList.remove('hidden');
                if (pauseSvg) pauseSvg.classList.add('hidden');
            }
        };

        window.onCustomAudioSliderInput = function(key) {
            const audio = document.getElementById(`audio_element_${key}`);
            const slider = document.getElementById(`audio_slider_${key}`);
            const thumb = document.getElementById(`audio_thumb_${key}`);
            if (!audio || !slider) return;
            
            const pct = parseFloat(slider.value);
            if (thumb) thumb.style.left = pct + '%';
            
            const barsContainer = document.getElementById(`audio_waveform_bars_${key}`);
            if (barsContainer) {
                const bars = barsContainer.children;
                const activeIndex = Math.floor((pct / 100) * bars.length);
                for (let i = 0; i < bars.length; i++) {
                    if (i <= activeIndex && pct > 0) {
                        bars[i].classList.remove('bg-[#8696a0]', 'bg-[#51636f]');
                        bars[i].classList.add('bg-[#53bdeb]');
                    } else {
                        bars[i].classList.remove('bg-[#53bdeb]');
                        bars[i].classList.add('bg-[#8696a0]');
                    }
                }
            }
        };

        window.onCustomAudioSliderChange = function(key) {
            const audio = document.getElementById(`audio_element_${key}`);
            const slider = document.getElementById(`audio_slider_${key}`);
            if (!audio || !slider) return;
            
            if (!isNaN(audio.duration) && isFinite(audio.duration)) {
                audio.currentTime = (parseFloat(slider.value) / 100) * audio.duration;
            }
        };

        window.onCustomAudioTimeUpdate = function(key) {
            const audio = document.getElementById(`audio_element_${key}`);
            if (!audio) return;
            
            let pct = 0;
            if (audio.duration && !isNaN(audio.duration) && isFinite(audio.duration)) {
                pct = (audio.currentTime / audio.duration) * 100 || 0;
            }
            
            const slider = document.getElementById(`audio_slider_${key}`);
            if (slider) slider.value = pct;
            
            const thumb = document.getElementById(`audio_thumb_${key}`);
            if (thumb) thumb.style.left = pct + '%';
            
            const timeSpan = document.getElementById(`audio_time_${key}`);
            if (timeSpan) {
                const formatTime = (secs) => {
                    if (isNaN(secs)) return '0:00';
                    const m = Math.floor(secs / 60);
                    const s = Math.floor(secs % 60);
                    return `${m}:${s < 10 ? '0' : ''}${s}`;
                };
                timeSpan.textContent = formatTime(audio.currentTime);
            }
            
            const barsContainer = document.getElementById(`audio_waveform_bars_${key}`);
            if (barsContainer) {
                const bars = barsContainer.children;
                const activeIndex = Math.floor((pct / 100) * bars.length);
                for (let i = 0; i < bars.length; i++) {
                    if (i <= activeIndex && pct > 0) {
                        bars[i].classList.remove('bg-[#8696a0]', 'bg-[#51636f]');
                        bars[i].classList.add('bg-[#53bdeb]');
                    } else {
                        bars[i].classList.remove('bg-[#53bdeb]');
                        bars[i].classList.add('bg-[#8696a0]');
                    }
                }
            }
        };

        window.onCustomAudioEnded = function(key) {
            const playSvg = document.getElementById(`play_svg_${key}`);
            const pauseSvg = document.getElementById(`pause_svg_${key}`);
            playSvg?.classList.remove('hidden');
            pauseSvg?.classList.add('hidden');
            
            const audio = document.getElementById(`audio_element_${key}`);
            if (audio) audio.currentTime = 0;
            
            const slider = document.getElementById(`audio_slider_${key}`);
            if (slider) slider.value = 0;
            const thumb = document.getElementById(`audio_thumb_${key}`);
            if (thumb) thumb.style.left = '0%';
            
            const barsContainer = document.getElementById(`audio_waveform_bars_${key}`);
            if (barsContainer) {
                const bars = barsContainer.children;
                for (let i = 0; i < bars.length; i++) {
                    bars[i].classList.remove('bg-[#53bdeb]');
                    bars[i].classList.add('bg-[#8696a0]');
                }
            }
            
            const timeSpan = document.getElementById(`audio_time_${key}`);
            if (timeSpan && audio) timeSpan.textContent = '0:00';
        };

        window.onCustomAudioLoadedMetadata = function(key) {
            const audio = document.getElementById(`audio_element_${key}`);
            const timeSpan = document.getElementById(`audio_time_${key}`);
            if (audio && timeSpan) {
                const formatTime = (secs) => {
                    if (isNaN(secs)) return '0:00';
                    const m = Math.floor(secs / 60);
                    const s = Math.floor(secs % 60);
                    return `${m}:${s < 10 ? '0' : ''}${s}`;
                };
                timeSpan.textContent = formatTime(audio.duration);
            }
        };

        window.getUserAvatar = function(userId, forceFallback = false) {
            const contact = window.allContacts ? window.allContacts.find(c => String(c.id) === String(userId)) : null;
            const name = contact ? (contact.saved_name || contact.name || contact.phone) : 'Contact';
            const fallbackUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=2a3942&color=fff`;

            if (forceFallback) {
                return fallbackUrl;
            }

            if (!window.isAvatarVisible(userId)) {
                return fallbackUrl;
            }

            return (contact && contact.avatar) ? contact.avatar : fallbackUrl;
        };

        window.applyAllAvatarsPrivacy = function() {
            if (!window.allContacts) return;

            window.allContacts.forEach(contact => {
                const userId = contact.id;
                const avatarUrl = window.getUserAvatar(userId);
                const originalAbout = contact.about || 'Available';
                const safeAbout = (window.isAboutVisible && window.isAboutVisible(userId)) ? originalAbout : '';

                // 1. Update sidebar list item img
                const sidebarImg = document.querySelector(`#user_sidebar_${userId} img`);
                if (sidebarImg) {
                    sidebarImg.src = avatarUrl;
                }

                // 2. Update data-avatar and data-about attributes of sidebar item
                const sidebarItem = document.getElementById(`user_sidebar_${userId}`);
                if (sidebarItem) {
                    sidebarItem.setAttribute('data-avatar', avatarUrl);
                    sidebarItem.setAttribute('data-about', safeAbout);
                }

                // 3. Update new chat panel item img and about text
                const newChatImg = document.querySelector(`#new_chat_contact_${userId} img`);
                if (newChatImg) {
                    newChatImg.src = avatarUrl;
                }
                const newChatAbout = document.querySelector(`#new_chat_contact_${userId} .new-chat-about-text`);
                if (newChatAbout) {
                    newChatAbout.textContent = safeAbout;
                }

                // 4. Update exclude list contact item avatar and about text
                const excludeCheckbox = document.querySelector(`input[name="exclude_contact"][value="${userId}"]`);
                if (excludeCheckbox) {
                    const labelEl = excludeCheckbox.closest('label');
                    if (labelEl) {
                        const img = labelEl.querySelector('.w-12.h-12 img');
                        if (img) {
                            img.src = avatarUrl;
                        }
                        const excludeAbout = labelEl.querySelector('.exclude-about-text');
                        if (excludeAbout) {
                            excludeAbout.textContent = safeAbout;
                        }
                    }
                }
            });

            // 4. Update active chat avatar
            if (window.activeChatUser) {
                const activeUserId = window.activeChatUser.id;
                const avatarUrl = window.getUserAvatar(activeUserId);

                const activeChatAvatarImg = document.querySelector('#active_chat_avatar img');
                if (activeChatAvatarImg) {
                    activeChatAvatarImg.src = avatarUrl;
                }

                const callDropdownAvatarImg = document.querySelector('#call_dropdown_avatar img');
                if (callDropdownAvatarImg) {
                    callDropdownAvatarImg.src = avatarUrl;
                }

                const contactInfoAvatarImg = document.getElementById('contact_info_avatar');
                if (contactInfoAvatarImg) {
                    contactInfoAvatarImg.src = avatarUrl;
                }

                window.activeChatUser.avatar = avatarUrl;

                // Update contact info panel about text
                const aboutText = document.getElementById('contact_about_text');
                if (aboutText) {
                    const originalAbout = window.allContacts ? (window.allContacts.find(c => String(c.id) === String(activeUserId))?.about || 'Available') : 'Available';
                    const safeAbout = (window.isAboutVisible && window.isAboutVisible(activeUserId)) ? originalAbout : '';
                    window.activeChatUser.about = safeAbout;
                    aboutText.textContent = safeAbout;
                }
            }

            // 5. Update active chat subtitle
            if (window.updateActiveChatSubtitle) {
                window.updateActiveChatSubtitle();
            }
        };

        // Firebase Presence System
        if (window.myUserId !== '0') {
            const connectedRef = ref(db, ".info/connected");
            const myStatusRef = ref(db, `status/${window.myUserId}`);

            onValue(connectedRef, (snap) => {
                if (snap.val() === true) {
                    onDisconnect(myStatusRef).update({
                        state: 'offline',
                        last_changed: serverTimestamp(),
                    }).then(() => {
                        update(myStatusRef, {
                            state: 'online',
                            last_changed: serverTimestamp(),
                        });
                    });
                }
            });

            // Sync local privacy settings to Firebase on startup
            try {
                // Profile photo
                const savedProfilePhoto = localStorage.getItem('whatsapp_privacy_profile_photo') || 'My contacts';
                let profilePhotoVal = savedProfilePhoto;
                let profilePhotoExcludedIds = [];

                if (savedProfilePhoto.includes('excluded') || savedProfilePhoto === 'My contacts except...') {
                    profilePhotoVal = 'My contacts except...';
                    const savedExclude = localStorage.getItem('whatsapp_privacy_exclude_profile_photo');
                    if (savedExclude) {
                        profilePhotoExcludedIds = JSON.parse(savedExclude);
                    }
                }

                // Last seen and online
                const savedLastSeen = localStorage.getItem('whatsapp_privacy_last_seen_val') || 'Nobody';
                const savedOnline = localStorage.getItem('whatsapp_privacy_online_val') || 'Everyone';
                let lastSeenVal = savedLastSeen;
                let lastSeenExcludedIds = [];

                if (savedLastSeen.includes('excluded') || savedLastSeen === 'My contacts except...') {
                    lastSeenVal = 'My contacts except...';
                    const savedExclude = localStorage.getItem('whatsapp_privacy_exclude_last_seen');
                    if (savedExclude) {
                        lastSeenExcludedIds = JSON.parse(savedExclude);
                    }
                }

                // About
                const savedAbout = localStorage.getItem('whatsapp_privacy_about') || 'Nobody';
                let aboutVal = savedAbout;
                let aboutExcludedIds = [];

                if (savedAbout.includes('excluded') || savedAbout === 'My contacts except...') {
                    aboutVal = 'My contacts except...';
                    const savedExclude = localStorage.getItem('whatsapp_privacy_exclude_about');
                    if (savedExclude) {
                        aboutExcludedIds = JSON.parse(savedExclude);
                    }
                }

                window.update(window.ref(window.db, `users/${window.myUserId}/privacy`), {
                    profile_photo: profilePhotoVal,
                    profile_photo_exclude: profilePhotoExcludedIds,
                    last_seen: lastSeenVal,
                    last_seen_exclude: lastSeenExcludedIds,
                    online: savedOnline,
                    about: aboutVal,
                    about_exclude: aboutExcludedIds
                }).catch(err => console.error("Error syncing startup privacy to firebase:", err));
            } catch(e) {
                console.error("Error parsing local privacy settings on startup:", e);
            }

            // Global Privacy Listener for all users
            const privacyRef = window.ref(window.db, 'users');
            window.onValue(privacyRef, (snapshot) => {
                const usersData = snapshot.val();
                window.usersPrivacyData = {};
                if (usersData) {
                    for (const [userId, userData] of Object.entries(usersData)) {
                        if (userData.privacy) {
                            window.usersPrivacyData[userId] = userData.privacy;
                        }
                    }
                }
                // Apply privacy settings to update all avatars in the UI
                if (window.applyAllAvatarsPrivacy) {
                    window.applyAllAvatarsPrivacy();
                }
            });
            //////api to web wallpaper
            // Global Wallpaper Listener for current user
            const wallpaperRef = window.ref(window.db, `users/${window.myUserId}/settings/wallpaper`);
            window.onValue(wallpaperRef, (snapshot) => {
                const wallpaperData = snapshot.val();
                if (wallpaperData) {
                    if (wallpaperData.color) localStorage.setItem(`whatsapp_wallpaper_color_${window.myUserId}`, wallpaperData.color);
                    if (wallpaperData.doodles !== undefined) localStorage.setItem(`whatsapp_wallpaper_doodles_${window.myUserId}`, wallpaperData.doodles);
                    if (wallpaperData.global_image) {
                        localStorage.setItem(`whatsapp_wallpaper_global_image_${window.myUserId}`, wallpaperData.global_image);
                    } else if (wallpaperData.global_image === null) {
                        localStorage.removeItem(`whatsapp_wallpaper_global_image_${window.myUserId}`);
                    }
                    if (window.applyGlobalWallpaper) window.applyGlobalWallpaper();
                }
            });
            //////////
            // Global Delivered Listener (for all users in sidebar)
            const allUserIds = [
                @foreach ($users ?? [] as $u)
                    {{ $u->id }},
                @endforeach
            ];

            // Message cache for search
            window.messageCache = window.messageCache || {};

            allUserIds.forEach(otherId => {
                const minId = Math.min(window.myUserId, otherId);
                const maxId = Math.max(window.myUserId, otherId);
                const chatId = `chat_${minId}_${maxId}`;
                const messagesRef = query(ref(db, 'chats/' + chatId + '/messages'), limitToLast(50));

                // Initialize cache for this user
                if (!window.messageCache[otherId]) {
                    window.messageCache[otherId] = [];
                }

                onChildAdded(messagesRef, (snapshot) => {
                    const data = snapshot.val();
                    const key = snapshot.key;

                    // Ignore messages from blocked users
                    const isBlocked = window.blockedUsers?.includes(`user_sidebar_${otherId}`);
                    if (isBlocked && data.sender_id != window.myUserId) {
                        return;
                    }

                    // Ignore expired disappearing messages
                    if (data.is_disappearing && data.expires_at) {
                        const currentTime = Date.now() / 1000;
                        if (data.expires_at - currentTime <= 0) {
                            return; // Already expired, ignore it for sidebar/badges
                        }
                    }

                    // Cache message for search (text or media)
                    if (data.text || (data.type !== 'text' && data.file_url)) {
                        // Avoid duplicates
                        if (!window.messageCache[otherId].find(m => m.key === key)) {
                            window.messageCache[otherId].push({
                                key: key,
                                text: data.text || '',
                                time: data.time,
                                type: data.type || 'text',
                                file_url: data.file_url || null,
                                file_name: data.file_name || null,
                                file_size: data.file_size || null,
                                caption: data.caption || null,
                                senderId: data.sender_id
                            });
                        }
                    }

                    // Populate global media cache
                    if (data.type !== 'text' && data.file_url) {
                        window.globalMediaCache = window.globalMediaCache || [];
                        if (!window.globalMediaCache.find(m => m.key === key)) {
                            let sName = 'Someone';
                            if (data.sender_id == window.myUserId) {
                                sName = 'You';
                            } else {
                                const sidebarUser = document.getElementById(`user_sidebar_${data.sender_id}`);
                                if (sidebarUser) {
                                    const h4Text = sidebarUser.querySelector('h4')?.textContent;
                                    sName = sidebarUser.getAttribute('data-name') || (h4Text ? h4Text.trim() : null) || sidebarUser.getAttribute('data-phone') || 'Someone';
                                }
                            }

                            window.globalMediaCache.push({
                                key: key,
                                type: data.type,
                                url: data.file_url,
                                fileName: data.file_name,
                                time: data.time,
                                senderId: data.sender_id,
                                senderName: sName,
                                chatId: chatId
                            });
                        }
                    } else if (data.type === 'text' && data.text) {
                        const urlRegex = /(https?:\/\/[^\s]+)/g;
                        const links = data.text.match(urlRegex);
                        if (links) {
                            window.globalMediaCache = window.globalMediaCache || [];
                            let sName = data.sender_id == window.myUserId ? 'You' : 'Someone';
                            if (data.sender_id != window.myUserId) {
                                const sidebarUser = document.getElementById(`user_sidebar_${data.sender_id}`);
                                if (sidebarUser) {
                                    const h4Text = sidebarUser.querySelector('h4')?.textContent;
                                    sName = sidebarUser.getAttribute('data-name') || (h4Text ? h4Text.trim() : null) || sidebarUser.getAttribute('data-phone') || 'Someone';
                                }
                            }
                            links.forEach((url, idx) => {
                                const linkKey = key + '_link_' + idx;
                                if (!window.globalMediaCache.find(m => m.key === linkKey)) {
                                    window.globalMediaCache.push({
                                        key: linkKey,
                                        type: 'link',
                                        url: url,
                                        time: data.time,
                                        senderId: data.sender_id,
                                        senderName: sName,
                                        chatId: chatId
                                    });
                                }
                            });
                        }
                    }

                    // Check if chat is deleted. If so, remove from deletedChats because a new message arrived
                    const sidebarElementId = `user_sidebar_${otherId}`;
                    const deletedIndex = window.deletedChats?.indexOf(sidebarElementId) ?? -1;
                    if (deletedIndex > -1) {
                        const clearedTime = window.clearedChats?.[sidebarElementId] || 0;
                        if (data.time > clearedTime) {
                            window.deletedChats.splice(deletedIndex, 1);
                            localStorage.setItem('deleted_chats', JSON.stringify(window.deletedChats));
                        }
                    }

                    // Unhide the sidebar item if it was hidden (e.g. non-contact but has messages)
                    const sidebarItem = document.getElementById(sidebarElementId);
                    if (sidebarItem && sidebarItem.classList.contains('hidden')) {
                        sidebarItem.classList.remove('hidden');
                        sidebarItem.classList.add('flex');
                    }

                    // Update Sidebar Content Preview & Time
                    const lastMsgEl = document.getElementById(`last_msg_${otherId}`);
                    const lastTimeEl = document.getElementById(`last_time_${otherId}`);
                    if (lastMsgEl) {
                        let text = data.text ? data.text : (data.type ? data.type.charAt(0).toUpperCase() +
                            data.type.slice(1) : 'Media');
                        lastMsgEl.textContent = text;
                    }
                    if (lastTimeEl && data.time) {
                        const date = new Date(data.time * 1000);
                        lastTimeEl.textContent = date.toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    }

                    // Update timestamp attribute and sort sidebar
                    if (sidebarItem && data.time) {
                        sidebarItem.setAttribute('data-timestamp', data.time);
                        if (window.sortSidebar) window.sortSidebar();
                    }

                    if (window.currentChatId === chatId && window.updateContactInfoMediaSection) {
                        window.updateContactInfoMediaSection();
                    }

                    // If message is for me, and I am not currently looking at this chat, mark it as delivered
                    if (data.sender_id != window.myUserId && (data.status === 'sent' || data.status === 'delivered')) {
                        if (window.currentChatId !== chatId) {
                            if (data.status === 'sent') {
                                update(ref(db, `chats/${chatId}/messages/${key}`), {
                                    status: 'delivered'
                                });
                            }

                            // Increment Unread Badge
                            const badge = document.getElementById(`unread_badge_${otherId}`);
                            if (badge) {
                                let count = parseInt(badge.textContent) || 0;
                                badge.textContent = count + 1;
                                badge.classList.remove('hidden');
                                badge.classList.add('flex');
                            }
                        }
                        // Show star icon if this message is already starred
                        if (window.starredMsgKeys && window.starredMsgKeys.has(key)) {
                            const sIcon = document.getElementById('star_icon_' + key);
                            if (sIcon) sIcon.classList.remove('hidden');
                            const btnText = document.getElementById('star_btn_text_' + key);
                            if (btnText) btnText.textContent = 'Unstar';
                        }
                    }
                });

                // Listen for disappearing messages status for this chat
                const timerRef = ref(db, `chats/${chatId}/disappearingTimer`);
                onValue(timerRef, (snap) => {
                    const duration = snap.val() || 0;
                    window.chatDisappearingTimers = window.chatDisappearingTimers || {};
                    window.chatDisappearingTimers[chatId] = duration;

                    const isDisappearing = (duration > 0);
                    window.updateDisappearingBadge(chatId, isDisappearing);

                    if (window.currentChatId === chatId) {
                        let val = 'Off';
                        if (duration === 120) val = '2 minutes';
                        else if (duration === 86400) val = '24 hours';
                        else if (duration === 604800) val = '7 days';
                        else if (duration === 7776000) val = '90 days';

                        const label = document.getElementById('contact_disappearing_timer_label');
                        if (label) label.innerText = val;
                    }
                });
            });
        }

        window.toggleSearchPanel = function() {
            const sidebar = document.getElementById('search_sidebar');
            if (!sidebar) return;
            const isHidden = sidebar.classList.contains('hidden');
            if (isHidden) {
                // Close other panels
                if (window.closeContactInfo) window.closeContactInfo();
                if (window.closeGroupInfoPanel) window.closeGroupInfoPanel();
                if (window.closeBroadcastInfo) window.closeBroadcastInfo();
                const metaAiPanel = document.getElementById('meta_ai_info_panel');
                if (metaAiPanel) {
                    metaAiPanel.classList.add('translate-x-full');
                    metaAiPanel.classList.remove('translate-x-0');
                }

                sidebar.classList.remove('hidden');
                sidebar.classList.add('flex');
                document.getElementById('search_messages_input').focus();
                document.getElementById('no_results_text').querySelector('p').textContent =
                    `Search for messages with ${document.getElementById('active_chat_title').textContent}`;
            } else {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('flex');
            }
        };

        window.clearMessageSearch = function() {
            const input = document.getElementById('search_messages_input');
            input.value = '';
            document.getElementById('clear_search_btn').classList.add('hidden');
            document.getElementById('search_results_list').innerHTML = '';
            document.getElementById('no_results_text').classList.remove('hidden');
            input.focus();
        };

        window.performMessageSearch = function(query) {
            const clearBtn = document.getElementById('clear_search_btn');
            const resultsList = document.getElementById('search_results_list');
            const noResults = document.getElementById('no_results_text');

            if (!query.trim()) {
                clearBtn.classList.add('hidden');
                resultsList.innerHTML = '';
                noResults.classList.remove('hidden');
                return;
            }

            clearBtn.classList.remove('hidden');
            noResults.classList.add('hidden');

            const searchTerm = query.toLowerCase();
            const results = [];

            for (let key in window.globalMessages) {
                const msg = window.globalMessages[key];
                if (msg.text && msg.text.toLowerCase().includes(searchTerm)) {
                    results.push({
                        ...msg,
                        key
                    });
                }
            }

            // Sort results by time descending
            results.sort((a, b) => b.time - a.time);

            renderMessageSearchResults(results, searchTerm);
        };

        window.renderMessageSearchResults = function(results, searchTerm) {
            const resultsList = document.getElementById('search_results_list');
            resultsList.innerHTML = '';

            if (results.length === 0) {
                resultsList.innerHTML = `<div class="p-10 text-center text-[#8696a0] text-sm">No messages found</div>`;
                return;
            }

            let lastDate = '';

            results.forEach(msg => {
                const date = window.getDateHeader(msg.time);
                if (date !== lastDate) {
                    lastDate = date;
                    resultsList.insertAdjacentHTML('beforeend',
                        `<div class="px-6 py-4 text-[#8696a0] text-[13px] font-medium">${date}</div>`);
                }

                // Highlight search term
                const regex = new RegExp(`(${searchTerm})`, 'gi');
                const highlightedText = msg.text.replace(regex,
                    '<span class="text-[#00a884] font-medium">$1</span>');
                const time = new Date(msg.time * 1000).toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                const isMe = msg.sender_id == window.myUserId;

                const html = `
                    <div class="px-6 py-3 hover:bg-[#202c33] cursor-pointer transition-colors border-b border-gray-800/30 group" onclick="window.scrollToMessage('${msg.key}')">
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center gap-1">
                                ${isMe ? `<span class="shrink-0">${window.getTickSVG(msg.status || 'sent')}</span>` : ''}
                                <p class="text-[#e9edef] text-[15px] line-clamp-2 leading-relaxed">${highlightedText}</p>
                            </div>
                        </div>
                    </div>`;
                resultsList.insertAdjacentHTML('beforeend', html);
            });
        };

        window.scrollToMessage = function(key) {
            const el = document.getElementById('msg_' + key);
            if (el) {
                el.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                el.classList.add('bg-[#00a884]/20');
                setTimeout(() => {
                    el.classList.remove('bg-[#00a884]/20');
                }, 2000);
            }
        };


        // Calendar Logic
        let currentCalendarDate = new Date();

        window.toggleCalendar = function() {
            const modal = document.getElementById('calendar_modal');
            modal.classList.toggle('hidden');
            if (!modal.classList.contains('hidden')) {
                renderCalendar(currentCalendarDate);
            }
        };

        window.changeCalendarMonth = function(delta) {
            currentCalendarDate.setMonth(currentCalendarDate.getMonth() + delta);
            renderCalendar(currentCalendarDate);
        };

        window.renderCalendar = function(date) {
            const grid = document.getElementById('calendar_days_grid');
            const monthYearText = document.getElementById('calendar_month_year');
            grid.innerHTML = '';

            const year = date.getFullYear();
            const month = date.getMonth();
            const monthName = date.toLocaleString('default', {
                month: 'long'
            });
            monthYearText.textContent = `${monthName} ${year}`;

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            // Prev month days
            const prevMonthDays = new Date(year, month, 0).getDate();
            for (let i = firstDay - 1; i >= 0; i--) {
                grid.insertAdjacentHTML('beforeend',
                    `<span class="h-9 flex items-center justify-center text-[#54656f] text-sm select-none">${prevMonthDays - i}</span>`
                    );
            }

            // Current month days
            const today = new Date();
            for (let day = 1; day <= daysInMonth; day++) {
                const isToday = today.getDate() === day && today.getMonth() === month && today.getFullYear() === year;
                const html = `
                    <button onclick="selectCalendarDate(${day}, ${month}, ${year})"
                        class="h-9 w-9 rounded-full flex items-center justify-center text-sm transition-colors
                        ${isToday ? 'bg-[#00a884] text-white font-bold' : 'text-[#e9edef] hover:bg-[#2a3942]'}">
                        ${day}
                    </button>`;
                grid.insertAdjacentHTML('beforeend', html);
            }

            // Next month days (padding)
            const totalCells = grid.children.length;
            const nextPadding = (7 - (totalCells % 7)) % 7;
            for (let i = 1; i <= nextPadding; i++) {
                grid.insertAdjacentHTML('beforeend',
                    `<span class="h-9 flex items-center justify-center text-[#54656f] text-sm select-none">${i}</span>`
                    );
            }
        };

        window.selectCalendarDate = function(day, month, year) {
            const selectedDateStr =
                `${year}-${(month + 1).toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
            jumpToDate(selectedDateStr);
            document.getElementById('calendar_modal').classList.add('hidden');
        };

        window.jumpToDate = function(targetDateStr) {
            const messages = Object.keys(window.globalMessages).map(key => ({
                ...window.globalMessages[key],
                key
            }));

            // Sort by time
            messages.sort((a, b) => a.time - b.time);

            const targetMsg = messages.find(msg => {
                const date = new Date(msg.time * 1000);
                const dStr = date.toISOString().split('T')[0];
                return dStr === targetDateStr;
            });

            if (targetMsg) {
                window.scrollToMessage(targetMsg.key);
            } else {
                window.showToast('No messages', `No messages found on ${targetDateStr}.`);
            }
        };

        window.getTickSVG = function(status) {
            if (status === 'read') {
                return `<svg viewBox="0 0 16 15" width="16" height="15" class="text-[#53bdeb]" fill="currentColor"><path d="M15,5.4L9.3,11.1l-1.3-1.4l5.7-5.7L15,5.4z M10.4,5.4L4.7,11.1L2,8.4L0.6,9.8l4.1,4.1l7.1-7.1L10.4,5.4z"></path></svg>`;
            } else if (status === 'delivered') {
                return `<svg viewBox="0 0 16 15" width="16" height="15" class="text-[#8696a0]" fill="currentColor"><path d="M15,5.4L9.3,11.1l-1.3-1.4l5.7-5.7L15,5.4z M10.4,5.4L4.7,11.1L2,8.4L0.6,9.8l4.1,4.1l7.1-7.1L10.4,5.4z"></path></svg>`;
            } else {
                return `<svg viewBox="0 0 16 11" width="16" height="11" class="text-[#8696a0]" fill="currentColor"><path d="M11.8,1.6L5.3,8.1L2.1,4.9l-1.5,1.5L5.3,11l8-8L11.8,1.6z"></path></svg>`;
            }
        };

        window.getDateHeader = function(timestamp) {
            const date = new Date(timestamp * 1000);
            const today = new Date();
            const yesterday = new Date();
            yesterday.setDate(today.getDate() - 1);

            const isSameDay = (d1, d2) =>
                d1.getDate() === d2.getDate() &&
                d1.getMonth() === d2.getMonth() &&
                d1.getFullYear() === d2.getFullYear();

            if (isSameDay(date, today)) return "Today";
            if (isSameDay(date, yesterday)) return "Yesterday";

            const diffTime = Math.abs(today - date);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays < 7) {
                return date.toLocaleDateString([], {
                    weekday: 'long'
                });
            }

            return date.toLocaleDateString([], {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        };

        window.formatAboutSubtitle = function(raw) {
            if (!raw) return 'Until I change it';
            if (!raw.includes('|')) return raw;

            const [type, iso] = raw.split('|');
            const date = new Date(iso);
            const now = new Date();

            const formatTime = (d) => {
                let hours = d.getHours();
                const minutes = d.getMinutes().toString().padStart(2, '0');
                const ampm = hours >= 12 ? 'pm' : 'am';
                hours = hours % 12 || 12;
                return `${hours}:${minutes} ${ampm}`;
            };

            const isToday = date.toDateString() === now.toDateString();
            const yesterday = new Date(now);
            yesterday.setDate(now.getDate() - 1);
            const isYesterday = date.toDateString() === yesterday.toDateString();

            let datePart = '';
            if (isToday) datePart = 'today';
            else if (isYesterday) datePart = 'yesterday';
            else {
                const diffTime = Math.abs(now.getTime() - date.getTime());
                const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
                if (diffDays < 7) {
                    datePart = date.toLocaleDateString([], {
                        weekday: 'long'
                    });
                } else {
                    datePart = date.toLocaleDateString([], {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    });
                }
            }

            if (type === 'UPDATED') {
                return `Last updated ${datePart} at ${formatTime(date)}`;
            } else {
                return `Until ${datePart} at ${formatTime(date)}`;
            }
        };

        window.getFileExt = function(filename) {
            if (!filename) return 'DOC';
            let parts = filename.split('.');
            return parts.length > 1 ? parts.pop().toUpperCase().substring(0, 4) : 'DOC';
        };

        window.getFileColor = function(filename) {
            const ext = window.getFileExt(filename).toLowerCase();
            if (ext === 'pdf') return '#e53935';
            if (ext.startsWith('doc')) return '#1e88e5';
            if (ext.startsWith('xls') || ext === 'csv') return '#43a047';
            if (ext.startsWith('ppt')) return '#fb8c00';
            if (ext === 'zip' || ext === 'rar') return '#8e24aa';
            if (ext === 'txt') return '#757575';
            return '#607d8b';
        };

        window.closeAllSidebarPanels = function() {
            const panels = [
                'new_chat_panel',
                'new_contact_panel',
                'edit_contact_panel',
                'add_group_members_panel',
                'create_group_panel',
                'broadcast_panel',
                'new_broadcast_panel'
            ];
            panels.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.classList.add('hidden');
                    el.classList.remove('sm:flex', 'flex');
                    el.style.display = '';
                }
            });

            // Hide communities panel and sidebar
            const cSidebar = document.getElementById('communities_sidebar_container');
            if (cSidebar) {
                cSidebar.classList.add('hidden');
                cSidebar.classList.remove('sm:flex', 'flex');
            }
            const cMain = document.getElementById('communities_main_column');
            if (cMain) {
                cMain.classList.add('hidden');
                cMain.classList.remove('flex');
            }

            // Hide channels panel and sidebar
            const chSidebar = document.getElementById('channels_sidebar_container');
            if (chSidebar) {
                chSidebar.classList.add('hidden');
                chSidebar.classList.remove('sm:flex', 'flex');
            }
            const chMain = document.getElementById('channels_main_column');
            if (chMain) {
                chMain.classList.add('hidden');
                chMain.classList.remove('flex');
            }
            if(window.closeChannelInfo) window.closeChannelInfo();
            if(window.closeCreateChannelModal) window.closeCreateChannelModal();

            // Cleanly close info and edit panels to restore main_chat_column layout
            if (window.closeContactInfo) window.closeContactInfo();
            if (window.closeBroadcastInfo) window.closeBroadcastInfo();
            if (window.closeEditRecipients) window.closeEditRecipients();
            if (window.closeDisappearingMessagesSidebar) window.closeDisappearingMessagesSidebar();
        };

        window.showChats = function() {
            // Close other sidebar panels
            window.closeAllSidebarPanels();

            // Update Navigation UI
            document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
            document.getElementById('nav_chats').classList.add('active');

            // Set filter back to all if coming from archived
            if (window.activeSidebarFilter === 'archived') {
                window.setSidebarFilter('all');
            }

            // Toggle Views
            document.getElementById('status_view_container').classList.add('hidden');
            document.getElementById('status_view_container').classList.remove('flex');

            document.getElementById('calls_sidebar_container')?.classList.add('hidden');
            document.getElementById('calls_sidebar_container')?.classList.remove('flex');
            document.getElementById('calls_main_column')?.classList.add('hidden');
            document.getElementById('calls_main_column')?.classList.remove('flex');

            document.getElementById('channels_sidebar_container')?.classList.add('hidden');
            document.getElementById('channels_sidebar_container')?.classList.remove('flex');
            document.getElementById('channels_main_column')?.classList.add('hidden');
            document.getElementById('channels_main_column')?.classList.remove('flex');

            document.getElementById('channels_sidebar_container')?.classList.add('hidden');
            document.getElementById('channels_sidebar_container')?.classList.remove('flex');
            document.getElementById('channels_main_column')?.classList.add('hidden');
            document.getElementById('channels_main_column')?.classList.remove('flex');

            const sidebar = document.getElementById('user_sidebar_container');
            sidebar.classList.remove('hidden');
            sidebar.classList.add('sm:flex', 'flex'); // Ensure both base and responsive flex are added

            document.getElementById('chat_view_container').classList.remove('hidden');
            document.getElementById('chat_view_container').classList.add('flex');

            document.getElementById('sidebar_resizer').classList.remove('hidden');

            if (window.closeAllSettings) {
                window.closeAllSettings();
            }
        };

        window.showArchivedChats = function() {
            // Close other sidebar panels
            window.closeAllSidebarPanels();

            // Update Navigation UI
            document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
            document.getElementById('nav_archived')?.classList.add('active');

            // Apply archived filter
            if (window.setSidebarFilter) {
                window.setSidebarFilter('archived');
            }

            // Ensure Sidebar is shown (similar to showChats)
            document.getElementById('status_view_container').classList.add('hidden');
            document.getElementById('status_view_container').classList.remove('flex');

            document.getElementById('calls_sidebar_container')?.classList.add('hidden');
            document.getElementById('calls_sidebar_container')?.classList.remove('flex');
            document.getElementById('calls_main_column')?.classList.add('hidden');
            document.getElementById('calls_main_column')?.classList.remove('flex');

            document.getElementById('channels_sidebar_container')?.classList.add('hidden');
            document.getElementById('channels_sidebar_container')?.classList.remove('flex');
            document.getElementById('channels_main_column')?.classList.add('hidden');
            document.getElementById('channels_main_column')?.classList.remove('flex');

            document.getElementById('channels_sidebar_container')?.classList.add('hidden');
            document.getElementById('channels_sidebar_container')?.classList.remove('flex');
            document.getElementById('channels_main_column')?.classList.add('hidden');
            document.getElementById('channels_main_column')?.classList.remove('flex');

            const sidebar = document.getElementById('user_sidebar_container');
            sidebar.classList.remove('hidden');
            sidebar.classList.add('sm:flex', 'flex');

            document.getElementById('chat_view_container').classList.remove('hidden');
            document.getElementById('chat_view_container').classList.add('flex');

            document.getElementById('sidebar_resizer').classList.remove('hidden');

            if (window.closeAllSettings) {
                window.closeAllSettings();
            }
        };

        window.showStatus = function() {
            // Close all sidebar panels
            window.closeAllSidebarPanels();

            // Update Navigation UI
            document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
            document.getElementById('nav_status').classList.add('active');

            // Toggle Views
            const sidebar = document.getElementById('user_sidebar_container');
            sidebar.classList.add('hidden');
            sidebar.classList.remove('sm:flex', 'flex'); // Remove both base and responsive flex

            document.getElementById('chat_view_container').classList.add('hidden');
            document.getElementById('chat_view_container').classList.remove('flex');

            document.getElementById('channels_sidebar_container')?.classList.add('hidden');
            document.getElementById('channels_sidebar_container')?.classList.remove('flex');
            document.getElementById('channels_main_column')?.classList.add('hidden');
            document.getElementById('channels_main_column')?.classList.remove('flex');

            document.getElementById('sidebar_resizer').classList.add('hidden');

            document.getElementById('calls_sidebar_container')?.classList.add('hidden');
            document.getElementById('calls_sidebar_container')?.classList.remove('flex');
            document.getElementById('calls_main_column')?.classList.add('hidden');
            document.getElementById('calls_main_column')?.classList.remove('flex');

            document.getElementById('channels_sidebar_container')?.classList.add('hidden');
            document.getElementById('channels_sidebar_container')?.classList.remove('flex');
            document.getElementById('channels_main_column')?.classList.add('hidden');
            document.getElementById('channels_main_column')?.classList.remove('flex');

            document.getElementById('channels_sidebar_container')?.classList.add('hidden');
            document.getElementById('channels_sidebar_container')?.classList.remove('flex');
            document.getElementById('channels_main_column')?.classList.add('hidden');
            document.getElementById('channels_main_column')?.classList.remove('flex');

            document.getElementById('status_view_container').classList.remove('hidden');
            document.getElementById('status_view_container').classList.add('flex');

            if (window.closeAllSettings) {
                window.closeAllSettings();
            }
        };

        window.showCalls = function() {
            // Close all sidebar panels
            window.closeAllSidebarPanels();

            // Update Navigation UI
            document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
            document.getElementById('nav_calls')?.classList.add('active');

            // Hide other views
            const sidebar = document.getElementById('user_sidebar_container');
            sidebar.classList.add('hidden');
            sidebar.classList.remove('sm:flex', 'flex');

            document.getElementById('chat_view_container').classList.add('hidden');
            document.getElementById('chat_view_container').classList.remove('flex');

            document.getElementById('channels_sidebar_container')?.classList.add('hidden');
            document.getElementById('channels_sidebar_container')?.classList.remove('flex');
            document.getElementById('channels_main_column')?.classList.add('hidden');
            document.getElementById('channels_main_column')?.classList.remove('flex');

            document.getElementById('status_view_container').classList.add('hidden');
            document.getElementById('status_view_container').classList.remove('flex');

            document.getElementById('sidebar_resizer').classList.remove('hidden');

            // Show calls views
            document.getElementById('calls_sidebar_container')?.classList.remove('hidden');
            document.getElementById('calls_sidebar_container')?.classList.add('flex');
            document.getElementById('calls_main_column')?.classList.remove('hidden');
            document.getElementById('calls_main_column')?.classList.add('flex');

            if (window.closeAllSettings) {
                window.closeAllSettings();
            }

            // Load logs
            if (window.loadCallLogs) {
                window.loadCallLogs();
            }
        };

        // Sidebar Resizer Logic
        (function() {
            window.updateAllSidebarsWidth = function(width) {
                const sidebarIds = [
                    'user_sidebar_container',
                    'calls_sidebar_container',
                    'settings_panel',
                    'edit_profile_panel',
                    'general_settings_panel',
                    'privacy_settings_panel',
                    'chats_settings_panel',
                    'video_voice_settings_panel',
                    'notifications_settings_panel',
                    'help_feedback_settings_panel',
                    'account_settings_panel',
                    'security_settings_panel',
                    'privacy_last_seen_panel',
                    'privacy_status_panel',
                    'privacy_profile_photo_panel',
                    'privacy_about_panel',
                    'privacy_exclude_panel',
                    'privacy_blocked_contacts_panel',
                    'chats_wallpaper_panel',
                    'chats_upload_quality_panel',
                    'chats_auto_download_panel',
                    'notifications_taskbar_panel',
                    'notifications_banner_panel',
                    'notifications_subpanel',
                    'new_chat_panel',
                    'add_group_members_panel',
                    'create_group_panel',
                    'new_contact_panel',
                    'status_sidebar',
                    'channels_sidebar_container',
                    'find_channels_sidebar'
                ];
                sidebarIds.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.style.width = width;
                    }
                });
            };

            const resizer = document.getElementById('sidebar_resizer');
            let isResizing = false;

            // Load saved width
            const savedWidth = localStorage.getItem('sidebarWidth');
            if (savedWidth && window.innerWidth >= 640) {
                window.updateAllSidebarsWidth(savedWidth);
            }

            resizer.addEventListener('mousedown', (e) => {
                isResizing = true;
                document.body.style.cursor = 'col-resize';
                document.body.classList.add('select-none');
            });

            document.addEventListener('mousemove', (e) => {
                if (!isResizing) return;

                let newWidth = e.clientX - 60; // Subtract nav_sidebar width
                const maxWidth = window.innerWidth / 2;
                const minWidth = 280;

                if (newWidth > maxWidth) newWidth = maxWidth;
                if (newWidth < minWidth) newWidth = minWidth;

                window.updateAllSidebarsWidth(`${newWidth}px`);
                localStorage.setItem('sidebarWidth', `${newWidth}px`);
            });

            document.addEventListener('mouseup', () => {
                if (isResizing) {
                    isResizing = false;
                    document.body.style.cursor = '';
                    document.body.classList.remove('select-none');
                }
            });
        })();

        window.focusSearch = function() {
            const input = document.getElementById('sidebar_search');
            if (input) {
                input.focus();
            }
        };

        window.toggleNewChat = function() {
            const sidebar = document.getElementById('user_sidebar_container');
            const newChatPanel = document.getElementById('new_chat_panel');
            if (!sidebar || !newChatPanel) return;

            if (newChatPanel.classList.contains('hidden')) {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('sm:flex');
                newChatPanel.classList.remove('hidden');
                newChatPanel.classList.add('sm:flex');
            } else {
                newChatPanel.classList.add('hidden');
                newChatPanel.classList.remove('sm:flex');
                sidebar.classList.remove('hidden');
                sidebar.classList.add('sm:flex');
            }
        };

        window.toggleEditProfile = function() {
            const editPanel = document.getElementById('edit_profile_panel');
            const settingsPanel = document.getElementById('settings_panel');
            if (!editPanel || !settingsPanel) return;

            if (editPanel.classList.contains('hidden')) {
                settingsPanel.classList.add('hidden');
                settingsPanel.classList.remove('flex');
                editPanel.classList.remove('hidden');
                editPanel.classList.add('flex');
            } else {
                editPanel.classList.add('hidden');
                editPanel.classList.remove('flex');
                settingsPanel.classList.remove('hidden');
                settingsPanel.classList.add('flex');
            }
        };

        window.toggleAboutModal = function() {
            document.getElementById('about_modal')?.classList.toggle('hidden');
        };

        window.toggleAboutPrivacy = function() {
            document.getElementById('about_privacy_modal')?.classList.toggle('hidden');
        };

        window.toggleAddGroupMembers = function() {
            // If the local function toggleAddMembers from add_group_members.blade.php exists, use it
            if (typeof toggleAddMembers === 'function') {
                toggleAddMembers();
            } else {
                const addMembersPanel = document.getElementById('add_group_members_panel');
                const newChatPanel = document.getElementById('new_chat_panel');
                if (addMembersPanel && newChatPanel) {
                    if (addMembersPanel.classList.contains('hidden')) {
                        newChatPanel.classList.add('hidden');
                        newChatPanel.classList.remove('sm:flex');
                        addMembersPanel.classList.remove('hidden');
                        addMembersPanel.classList.add('flex');
                    } else {
                        addMembersPanel.classList.add('hidden');
                        addMembersPanel.classList.remove('flex');
                        newChatPanel.classList.remove('hidden');
                        newChatPanel.classList.add('sm:flex');
                    }
                }
            }
        };

        window.toggleCreateGroup = function() {
            const createGroupPanel = document.getElementById('create_group_panel');
            const addMembersPanel = document.getElementById('add_group_members_panel');
            if (!createGroupPanel || !addMembersPanel) return;

            if (createGroupPanel.classList.contains('hidden')) {
                addMembersPanel.classList.add('hidden');
                addMembersPanel.classList.remove('flex');
                createGroupPanel.classList.remove('hidden');
                createGroupPanel.classList.add('flex');
            } else {
                createGroupPanel.classList.add('hidden');
                createGroupPanel.classList.remove('flex');
                addMembersPanel.classList.remove('hidden');
                addMembersPanel.classList.add('flex');
            }
        };

        window.toggleEditContact = function() {
            document.getElementById('edit_contact_panel')?.classList.toggle('hidden');
            document.getElementById('contact_info_panel')?.classList.add('hidden');
        };

        window.toggleContactInfo = function() {
            const panel = document.getElementById('contact_info_panel');
            if (panel) {
                panel.classList.toggle('translate-x-full');
            }
        };

        window.backToSidebar = function() {
            document.getElementById('user_sidebar_container').classList.remove('hidden');
            document.getElementById('user_sidebar_container').classList.add('flex', 'w-full');
            document.getElementById('main_chat_column').classList.add('hidden');
            document.getElementById('main_chat_column').classList.remove('flex');
        };

        window.closeAllSearchPanels = function() {
            // 1. Private / Meta AI Search
            const privateSearch = document.getElementById('search_sidebar');
            if (privateSearch) {
                privateSearch.classList.add('hidden');
                privateSearch.classList.remove('flex');
            }
            const searchInput = document.getElementById('search_messages_input');
            if (searchInput) {
                searchInput.value = '';
            }
            const clearBtn = document.getElementById('clear_search_btn');
            if (clearBtn) {
                clearBtn.classList.add('hidden');
            }
            const resultsList = document.getElementById('search_results_list');
            if (resultsList) {
                resultsList.innerHTML = '';
            }
            const noResults = document.getElementById('no_results_text');
            if (noResults) {
                noResults.classList.remove('hidden');
            }

            // 2. Group Search
            const groupSearch = document.getElementById('group_search_drawer');
            if (groupSearch) {
                groupSearch.classList.add('hidden');
                groupSearch.classList.remove('flex');
            }
            const groupSearchInput = document.getElementById('group_search_input');
            if (groupSearchInput) {
                groupSearchInput.value = '';
            }
            const groupSearchResults = document.getElementById('group_search_results');
            if (groupSearchResults) {
                groupSearchResults.innerHTML = `<div class="text-[#8696a0] text-center text-sm py-4">Type to search messages in group</div>`;
            }
        };

        window.closeChat = function() {
            window.activeChatUser = null;
            document.getElementById('chat_empty_state')?.classList.remove('hidden');

            if (typeof window.closeContactInfo === 'function') {
                window.closeContactInfo();
            }
            if (typeof window.closeDisappearingMessagesSidebar === 'function') {
                window.closeDisappearingMessagesSidebar();
            }

            if (typeof window.closeAllSearchPanels === 'function') {
                window.closeAllSearchPanels();
            }

            // Hide all chat contents
            document.getElementById('active_chat_content')?.classList.add('hidden');
            document.getElementById('active_chat_content')?.classList.remove('flex');
            document.getElementById('active_group_chat_content')?.classList.add('hidden');
            document.getElementById('active_group_chat_content')?.classList.remove('flex');
            document.getElementById('meta_ai_content')?.classList.add('hidden');
            document.getElementById('meta_ai_content')?.classList.remove('flex');

            // Remove active highlight from sidebar
            document.querySelectorAll('.user-chat-item').forEach(el => el.classList.remove('active'));

            // On mobile, also navigate back to sidebar
            if (window.innerWidth < 640) {
                window.backToSidebar();
            }
        };

        window.selectChat = function(otherUserId, name, phone, avatar = null, about = null, searchMsgTime = null) {
            const elementId = `user_sidebar_${otherUserId}`;
            if (window.hiddenChats && window.hiddenChats.includes(elementId)) {
                window.promptHiddenChatClickUnlock(function() {
                    window.selectChatOriginal(otherUserId, name, phone, avatar, about, searchMsgTime);
                });
            } else {
                window.selectChatOriginal(otherUserId, name, phone, avatar, about, searchMsgTime);
            }
        };

        window.selectChatOriginal = function(otherUserId, name, phone, avatar = null, about = null, searchMsgTime = null) {
            if (typeof window.closeAllSearchPanels === 'function') {
                window.closeAllSearchPanels();
            }
            if (typeof window.closeContactInfo === 'function') {
                window.closeContactInfo();
            }
            if (typeof window.closeGroupInfoPanel === 'function') {
                window.closeGroupInfoPanel();
            }
            if (typeof window.closeBroadcastInfo === 'function') {
                window.closeBroadcastInfo();
            }
            // Fetch missing info from DOM
            const sidebarEl = document.getElementById(`user_sidebar_${otherUserId}`);
            if (sidebarEl) {
                if (!name || name === 'undefined') name = sidebarEl.getAttribute('data-name');
                if (!phone || phone === 'undefined') phone = sidebarEl.getAttribute('data-phone') || '';
                if (!avatar || avatar === 'undefined') avatar = sidebarEl.getAttribute('data-avatar');
                if (!about || about === 'undefined') about = sidebarEl.getAttribute('data-about') || 'Available';
            }

            // Try fallback from allContacts if still missing
            if ((!name || name === 'undefined' || !avatar || avatar === 'undefined') && window.allContacts) {
                const contact = window.allContacts.find(c => String(c.id) === String(otherUserId));
                if (contact) {
                    if (!name || name === 'undefined') name = contact.name || contact.phone;
                    if (!phone || phone === 'undefined') phone = contact.phone || '';
                    if (!avatar || avatar === 'undefined') avatar = contact.avatar;
                    if (!about || about === 'undefined') about = contact.about || 'Available';
                }
            }

            // If we are not in Chats view, switch back to Chats
            const chatViewContainer = document.getElementById('chat_view_container');
            if (chatViewContainer && chatViewContainer.classList.contains('hidden')) {
                window.showChats();
            }

            // Capture search query for highlighting messages
            const searchInput = document.getElementById('sidebar_search');
            window.activeSearchQuery = (searchInput && searchInput.value.trim().length > 0) ? searchInput.value.trim()
                .toLowerCase() : null;
            window.activeSearchMsgTime = searchMsgTime || null;
            window._searchScrolled = false;

            // Show content, hide empty state
            document.getElementById('chat_empty_state')?.classList.add('hidden');

            // Hide channels and others
            document.getElementById('channels_main_column')?.classList.add('hidden');
            document.getElementById('channels_main_column')?.classList.remove('flex');

            // Highlight selected item in sidebar
            document.querySelectorAll('.user-chat-item').forEach(el => {
                el.classList.remove('active');
                if (el.getAttribute('id') === `user_sidebar_${otherUserId}` || el.getAttribute('data-userid') ==
                    otherUserId) {
                    el.classList.add('active');
                }
            });

            // Update UI based on block status
            if (window.updateBlockedUI) window.updateBlockedUI();

            // Reset states
            if (window.cancelSelection) window.cancelSelection();
            if (window.cancelGroupSelection) window.cancelGroupSelection();

            document.getElementById('active_group_chat_content')?.classList.add('hidden');
            document.getElementById('active_group_chat_content')?.classList.remove('flex');
            document.getElementById('meta_ai_content')?.classList.add('hidden');
            document.getElementById('meta_ai_content')?.classList.remove('flex');
            document.getElementById('active_chat_content')?.classList.remove('hidden');
            document.getElementById('active_chat_content')?.classList.add('flex');

            if (window.closeAllSettings) {
                window.closeAllSettings();
            }

            // Mobile view handling
            if (window.innerWidth < 640) {
                document.getElementById('user_sidebar_container').classList.add('hidden');
                document.getElementById('main_chat_column').classList.remove('hidden');
                document.getElementById('main_chat_column').classList.add('flex');
            }

            if (window.statusUnsubscribe) window.statusUnsubscribe();
            if (window.unsubscribeAdded) window.unsubscribeAdded();
            if (window.unsubscribeRemoved) window.unsubscribeRemoved();
            if (window.unsubscribeChanged) window.unsubscribeChanged();
            if (window.unsubscribePinnedMsg) {
                window.unsubscribePinnedMsg();
                window.unsubscribePinnedMsg = null;
            }

            const myId = window.myUserId;
            const minId = Math.min(myId, otherUserId);
            const maxId = Math.max(myId, otherUserId);
            window.currentChatId = `chat_${minId}_${maxId}`;

            const activeName = name ? name : phone;
            window.activeChatName = activeName;

            // Use privacy-safe avatar
            const activeAvatar = window.getUserAvatar ? window.getUserAvatar(otherUserId) : (avatar ||
                `https://ui-avatars.com/api/?name=${encodeURIComponent(activeName)}&background=202c33&color=fff`);
            window.activeChatAvatar = activeAvatar;

            const safeAbout = (window.isAboutVisible && window.isAboutVisible(otherUserId)) ? (about || 'Available') : '';
            window.activeChatUser = {
                id: otherUserId,
                name: activeName,
                phone: phone,
                avatar: activeAvatar,
                about: safeAbout
            };
            window.currentGroupId = null;

            // Apply custom wallpaper
            window.applyCustomWallpaper(otherUserId, 'user');

            if (window.updateContactInfoMediaSection) {
                window.updateContactInfoMediaSection();
            }

            document.getElementById('active_chat_title').textContent = activeName;
            document.getElementById('active_chat_subtitle').classList.add('hidden');
            document.getElementById('active_chat_avatar').innerHTML =
                `<img src="${activeAvatar}" class="w-full h-full object-cover rounded-full">`;

            // Update Call Dropdown
            document.getElementById('call_dropdown_name').textContent = activeName;
            document.getElementById('call_dropdown_avatar').innerHTML =
                `<img src="${activeAvatar}" class="w-full h-full object-cover">`;

            // Reset Unread Badge for this user
            const badge = document.getElementById(`unread_badge_${otherUserId}`);
            if (badge) {
                badge.textContent = '0';
                badge.classList.add('hidden');
                badge.classList.remove('flex');
            }

            // Apply disappearing messages badge if active
            const currentDuration = window.chatDisappearingTimers?.[window.currentChatId] || 0;
            window.updateDisappearingBadge(window.currentChatId, currentDuration > 0);

            // Also update contact info label
            let timerText = 'Off';
            if (currentDuration === 120) timerText = '2 minutes';
            else if (currentDuration === 86400) timerText = '24 hours';
            else if (currentDuration === 604800) timerText = '7 days';
            else if (currentDuration === 7776000) timerText = '90 days';
            const label = document.getElementById('contact_disappearing_timer_label');
            if (label) label.innerText = timerText;

            // Listen to other user's status
            const otherUserStatusRef = window.ref(window.db, `status/${otherUserId}`);
            window.statusUnsubscribe = window.onValue(otherUserStatusRef, (snapshot) => {
                const data = snapshot.val();
                const subtitle = document.getElementById('active_chat_subtitle');

                // Update global activeChatUser with latest about info
                if (data && window.activeChatUser && window.activeChatUser.id == otherUserId) {
                    if (data.about) {
                        const safeAbout = (window.isAboutVisible && window.isAboutVisible(otherUserId)) ? data.about : '';
                        window.activeChatUser.about = safeAbout;
                    }

                    // If Contact Info panel is open and showing this user, update it live
                    const panel = document.getElementById('contact_info_panel');
                    if (panel && !panel.classList.contains('translate-x-full')) {
                        const aboutText = document.getElementById('contact_about_text');
                        if (aboutText) aboutText.textContent = window.activeChatUser.about || '';
                    }
                }

                if (window.updateActiveChatSubtitle) {
                    window.updateActiveChatSubtitle(data);
                } else {
                    if (data && data.state === 'online') {
                        subtitle.textContent = 'online';
                        subtitle.classList.remove('hidden', 'text-gray-500');
                        subtitle.classList.add('text-green-600');
                    } else {
                        let text = 'offline';
                        if (data && data.last_changed) {
                            const date = new Date(data.last_changed);
                            text = 'last seen ' + date.toLocaleTimeString([], {
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                        }
                        subtitle.textContent = text;
                        subtitle.classList.remove('hidden', 'text-green-600');
                        subtitle.classList.add('text-gray-500');
                    }
                }
            });

            document.getElementById('messages').innerHTML = '';
            window.globalMessages = {};

            // Multi-pin listener
            const pinnedMsgsRef = ref(db, `chats/${window.currentChatId}/pinned_msgs`);
            window.unsubscribePinnedMsg = onValue(pinnedMsgsRef, (snapshot) => {
                const pinnedData = snapshot.val();
                const pinBar = document.getElementById('private_pinned_bar');
                const pinText = document.getElementById('private_pinned_text');
                const pinCount = document.getElementById('private_pinned_count');

                window.pinnedMsgKeys = new Set();
                window._pinnedMsgsList = [];
                window._currentPinIndex = 0;

                const isGroup = window.currentChatId.startsWith('group_');
                const targetId = isGroup ? window.currentChatId.replace('group_', '') : window.currentChatId
                    .replace('chat_', '').split('_').find(id => id != window.myUserId);
                const elementId = isGroup ? `group_sidebar_${targetId}` : `user_sidebar_${targetId}`;
                const clearedTime = window.clearedChats?.[elementId] || 0;

                if (pinnedData && typeof pinnedData === 'object') {
                    // Build sorted list (newest first)
                    for (const [key, val] of Object.entries(pinnedData)) {
                        // Hide if chat was cleared after the message was pinned
                        if (val.time && val.time <= clearedTime) {
                            continue;
                        }

                        window.pinnedMsgKeys.add(key);
                        window._pinnedMsgsList.push({
                            key,
                            text: val.text,
                            time: val.time || 0
                        });
                    }
                    window._pinnedMsgsList.sort((a, b) => b.time - a.time);

                    if (pinBar && pinText && pinCount) {
                        const count = window._pinnedMsgsList.length;
                        if (count > 0) {
                            pinCount.textContent = count === 1 ? '1 pinned message' : `${count} pinned messages`;
                            pinText.textContent = window._pinnedMsgsList[0].text;
                            pinBar.classList.remove('hidden');
                        } else {
                            pinBar.classList.add('hidden');
                        }
                    }
                } else {
                    if (pinBar) pinBar.classList.add('hidden');
                }

                // Update pin icons on message bubbles
                if (typeof window.updatePinIcons === 'function') window.updatePinIcons();
            });

            let lastDateString = null;

            const messagesRef = ref(db, 'chats/' + window.currentChatId + '/messages');

            window.unsubscribeAdded = window.onChildAdded(messagesRef, (snapshot) => {
                const data = snapshot.val();
                const key = snapshot.key;

                // Check if message is expired (disappearing messages)
                if (data.is_disappearing && data.expires_at) {
                    const currentTime = Date.now() / 1000;
                    const remainingSeconds = data.expires_at - currentTime;
                    if (remainingSeconds <= 0) {
                        return; // Already expired
                    } else {
                        // Set timeout to delete message element from DOM when it expires
                        // Max 32-bit int for setTimeout is 2147483647 ms (~24.8 days). 
                        // If remaining time is greater, we don't set a timeout as the user will likely reload before then.
                        const delayMs = remainingSeconds * 1000;
                        if (delayMs <= 2147483647) {
                            setTimeout(() => {
                                const msgEl = document.getElementById('msg_' + key);
                                if (msgEl) msgEl.remove();
                            }, delayMs);
                        }
                    }
                }

                // Check if message is older than clear timestamp
                const isGroup = window.currentChatId.startsWith('group_');
                const targetId = isGroup ? window.currentChatId.replace('group_', '') : window.currentChatId
                    .replace('chat_', '').split('_').find(id => id != window.myUserId);
                const elementId = isGroup ? `group_sidebar_${targetId}` : `user_sidebar_${targetId}`;
                const clearedTime = window.clearedChats?.[elementId] || 0;

                if (data.time && data.time <= clearedTime) {
                    return; // Ignore this message because chat was cleared after it was sent
                }

                if (data.deleted_for && data.deleted_for[window.myUserId]) {
                    return;
                }

                // Ignore messages from blocked users
                if (!isGroup && window.blockedUsers?.includes(elementId) && data.sender_id != window.myUserId) {
                    return;
                }
 
                // Render system messages (like disappearing timer updates)
                if (data.type === 'system') {
                    const dateHeader = window.getDateHeader(data.time);
                    if (dateHeader !== lastDateString) {
                        lastDateString = dateHeader;
                        const headerHtml = `
                            <div class="flex justify-center my-3 sticky top-0 z-[5]">
                                <div class="bg-[#182229]/90 backdrop-blur-sm text-[#8696a0] text-[11px] px-3 py-1 rounded-lg shadow-sm font-medium uppercase tracking-wider border border-[#202c33]">
                                    ${dateHeader}
                                </div>
                            </div>`;
                        document.getElementById('messages').insertAdjacentHTML('beforeend', headerHtml);
                    }

                    const msgHtml = `
                        <div id="msg_${key}" class="flex justify-center my-3 relative select-none w-full">
                            <div class="bg-[#182229]/90 backdrop-blur-sm text-[#8696a0] text-[12px] px-3.5 py-1.5 rounded-lg shadow-sm font-normal text-center max-w-[85%] border border-[#202c33] flex items-center justify-center gap-2">
                                <svg class="w-3.5 h-3.5 text-[#8696a0] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span>${data.text}</span>
                            </div>
                        </div>`;
                    document.getElementById('messages').insertAdjacentHTML('beforeend', msgHtml);

                    const container = document.getElementById('messages_container') || document.getElementById('messages');
                    if (container) {
                        container.scrollTop = container.scrollHeight;
                    }
                    return;
                }

                window.globalMessages[key] = data; // store for reply/forward

                // Date Header Logic
                const dateHeader = window.getDateHeader(data.time);
                if (dateHeader !== lastDateString) {
                    lastDateString = dateHeader;
                    const headerHtml = `
                        <div class="flex justify-center my-3 sticky top-0 z-[5]">
                            <div class="bg-[#182229]/90 backdrop-blur-sm text-[#8696a0] text-[11px] px-3 py-1 rounded-lg shadow-sm font-medium uppercase tracking-wider border border-[#202c33]">
                                ${dateHeader}
                            </div>
                        </div>`;
                    document.getElementById('messages').insertAdjacentHTML('beforeend', headerHtml);
                }

                // If message is from other user and not read, mark it as read since chat is open
                if (data.sender_id != window.myUserId && data.status !== 'read') {
                    if (document.visibilityState === 'visible') {
                        update(ref(db, `chats/${window.currentChatId}/messages/${key}`), {
                            status: 'read'
                        });
                    } else if (data.status === 'sent') {
                        // Chat is selected but tab is hidden, so it's delivered
                        update(ref(db, `chats/${window.currentChatId}/messages/${key}`), {
                            status: 'delivered'
                        });
                    }
                }

                const isMe = data.sender_id == window.myUserId;
                const time = new Date(data.time * 1000).toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                let mediaContent = '';
                if (data.type === 'image' && data.file_url) {
                    mediaContent =
                        `<img src="${data.file_url}" class="max-w-[200px] sm:max-w-xs rounded-lg mb-2 object-cover cursor-pointer hover:opacity-90" onclick="window.open('${data.file_url}', '_blank')">`;
                } else if (data.type === 'video' && data.file_url) {
                    const vSender = isMe ? 'You' : (window.activeChatUser ? window.activeChatUser.name : 'Member');
                    const vSenderEscaped = vSender.replace(/'/g, "\\'").replace(/"/g, "&quot;");
                    const vTextEscaped = data.text ? data.text.replace(/'/g, "\\'").replace(/"/g, "&quot;").replace(/\n/g, " ") : '';
                    mediaContent =
                        `<div class="relative cursor-pointer max-w-[200px] sm:max-w-xs rounded-lg mb-2 overflow-hidden bg-[#233138] border border-[#313d45] flex items-center justify-center min-h-[120px]" onclick="event.stopPropagation(); window.openGlobalSearchVideoViewer('${key}', window.currentChatId, '${data.file_url}', '${vSenderEscaped}', '${time}', false, '${vTextEscaped}')">
                            <video src="${data.file_url}#t=0.1" preload="metadata" class="w-full h-full max-h-[300px] object-cover pointer-events-none"></video>
                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                <div class="w-12 h-12 rounded-full bg-black/50 flex items-center justify-center backdrop-blur-sm shadow-sm border border-white/20">
                                    <svg viewBox="0 0 24 24" width="24" height="24" fill="white" class="ml-1"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </div>
                        </div>`;
                } else if (data.type === 'audio' && data.file_url) {
                    const senderAvatar = isMe ? window.myUserAvatar : (window.activeChatUser?.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(window.activeChatUser?.name || 'User')}&background=202c33&color=fff`);
                    mediaContent = `
                        <div class="flex items-center gap-3 p-2 select-none" style="min-width: 250px; max-width: 320px;">
                            <!-- Left: Avatar with blue microphone badge -->
                            <div class="relative shrink-0 w-10 h-10">
                                <img src="${senderAvatar}" class="w-full h-full rounded-full object-cover">
                                <div class="absolute -bottom-1 -right-1 w-4.5 h-4.5 rounded-full bg-[#111b21] flex items-center justify-center text-[#53bdeb] shadow-sm border border-[#111b21]">
                                    <svg viewBox="0 0 24 24" width="10" height="10" fill="currentColor">
                                        <path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3zm5.3-3c0 3-2.54 5.1-5.3 5.1S6.7 14 6.7 11H5c0 3.41 2.72 6.23 6 6.72V21h2v-3.28c3.28-.48 6-3.3 6-6.72h-1.7z"/>
                                    </svg>
                                </div>
                            </div>
                            <!-- Right: Play/Pause button, seekbar, speed -->
                            <div class="flex-1 flex flex-col gap-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <button onclick="window.toggleCustomAudioPlay('${key}')" id="audio_play_btn_${key}" class="text-[#8696a0] hover:text-[#e9edef] focus:outline-none transition-colors shrink-0">
                                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" id="play_svg_${key}">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" id="pause_svg_${key}" class="hidden">
                                            <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                                        </svg>
                                    </button>
                                    
                                    <div class="flex-1 relative flex items-center h-6">
                                        <div id="audio_waveform_bars_${key}" class="absolute inset-0 flex items-center gap-[2px] pointer-events-none">
                                            ${[8, 12, 16, 12, 8, 14, 20, 16, 10, 18, 22, 14, 10, 16, 20, 12, 8, 14, 18, 12, 10, 16, 12, 8].map((h, i) => `
                                                <div class="w-[2.5px] rounded-full bg-[#8696a0] transition-colors duration-150" style="height: ${h}px;" data-index="${i}"></div>
                                            `).join('')}
                                        </div>
                                        <div id="audio_thumb_${key}" class="absolute w-[8px] h-[8px] rounded-full bg-[#53bdeb] pointer-events-none transform -translate-x-1/2" style="left: 0%;"></div>
                                        <input type="range" min="0" max="100" value="0" step="0.1" id="audio_slider_${key}" oninput="window.onCustomAudioSliderInput('${key}')" onchange="window.onCustomAudioSliderChange('${key}')" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between text-[10px] text-[#8696a0] px-1 font-semibold">
                                    <span id="audio_time_${key}">0:00</span>
                                    <button onclick="window.toggleCustomAudioSpeed('${key}')" id="audio_speed_${key}" class="hover:text-[#e9edef] bg-[#202c33]/60 px-1 rounded transition-colors focus:outline-none">1.0x</button>
                                </div>
                            </div>
                            
                            <audio id="audio_element_${key}" src="${data.file_url}" preload="metadata" class="hidden" ontimeupdate="window.onCustomAudioTimeUpdate('${key}')" onended="window.onCustomAudioEnded('${key}')" onloadedmetadata="window.onCustomAudioLoadedMetadata('${key}')"></audio>
                        </div>`;
                } else if (data.type === 'document' && data.file_url) {
                    mediaContent = `
                        <div class="relative rounded-lg overflow-hidden border border-black/10 bg-black/5 mb-1 cursor-pointer hover:bg-black/10 transition-colors w-[260px] sm:w-[280px]" onclick="window.open('${data.file_url}', '_blank')">
                            <div class="h-[140px] bg-white flex flex-col items-center justify-center border-b border-black/5 relative">
                                <div class="w-[80px] h-[100px] bg-white border border-gray-200 rounded shadow-sm flex flex-col p-3 gap-2">
                                    <div class="w-full h-1.5 bg-gray-200 rounded-full"></div>
                                    <div class="w-5/6 h-1.5 bg-gray-200 rounded-full"></div>
                                    <div class="w-full h-1.5 bg-gray-200 rounded-full"></div>
                                    <div class="w-3/4 h-1.5 bg-gray-200 rounded-full"></div>
                                    <div class="w-1/2 h-1.5 bg-gray-200 rounded-full mt-auto"></div>
                                </div>
                            </div>
                            <div class="p-3 flex items-center gap-3">
                                <div class="w-10 h-10 rounded flex items-center justify-center shrink-0 text-[11px] font-bold text-white shadow-sm" style="background-color: ${window.getFileColor(data.file_name)}">
                                    ${window.getFileExt(data.file_name)}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-[15px] font-medium text-gray-800 truncate leading-tight">${data.file_name || 'Document'}</div>
                                    <div class="text-[12px] text-gray-500 mt-1 truncate">${window.getFileExt(data.file_name)} Document</div>
                                </div>
                            </div>
                        </div>`;
                } else if ((data.type === 'location' || data.type === 'live_location') && data.lat && data
                    .lng) {
                    const lat = parseFloat(data.lat);
                    const lng = parseFloat(data.lng);
                    const isLive = data.type === 'live_location';

                    mediaContent = `
                        <div class="mb-2 relative rounded-lg overflow-hidden border border-gray-200 w-[250px] max-w-[100%] h-[150px] bg-gray-100 flex items-center justify-center">
                            <iframe width="100%" height="150" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.openstreetmap.org/export/embed.html?bbox=${lng - 0.005}%2C${lat - 0.005}%2C${lng + 0.005}%2C${lat + 0.005}&amp;layer=mapnik&amp;marker=${lat}%2C${lng}" class="w-full absolute inset-0 pointer-events-none opacity-80"></iframe>

                            <div class="z-20 relative flex flex-col items-center">
                                ${isLive ? `
                                        <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur border border-white/50 flex flex-col items-center justify-center overflow-hidden relative shadow-lg">
                                            <div class="absolute inset-0 bg-[#1dae75] rounded-full animate-ping opacity-70"></div>
                                            <div class="w-10 h-10 rounded-full bg-[#202c33] border-2 border-[#1dae75] flex items-center justify-center text-white font-bold text-lg relative z-10">
                                                {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                                            </div>
                                        </div>
                                    ` : `
                                        <div class="w-10 h-10 rounded-full bg-white shadow-md flex items-center justify-center text-[#ea4335]">
                                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"></path></svg>
                                        </div>
                                    `}
                            </div>

                            <a href="https://www.google.com/maps?q=${lat},${lng}" target="_blank" class="absolute inset-0 z-30 flex flex-col justify-end group">
                                <div class="bg-white/90 text-[#111b21] text-xs p-2 text-center backdrop-blur-sm border-t border-gray-200 flex justify-between items-center group-hover:bg-gray-100 transition-colors">
                                    <span class="font-medium truncate max-w-[150px] text-left">${isLive ? 'Live location' : 'Location'}</span>
                                    <span class="text-[#008069] uppercase tracking-wider text-[10px] font-semibold">View map</span>
                                </div>
                            </a>
                        </div>`;

                    if (isLive && data.duration) {
                        const endTime = new Date((data.time + data.duration * 60) * 1000);
                        const diff = endTime - new Date();
                        const statusText = diff > 0 ?
                            `Live until ${endTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}` :
                            'Live location ended';
                        mediaContent +=
                            `<div class="text-xs text-gray-500 mb-1 italic px-1">${statusText}</div>`;
                    }
                } else if (data.type === 'channel_invite') {
                    mediaContent = `
                        <div class="mb-1 w-[280px] max-w-[100%]">
                            <div class="flex items-center gap-3 mb-2 pt-1 px-1">
                                <div class="w-10 h-10 rounded-full bg-[#111b21] flex items-center justify-center shrink-0 overflow-hidden">
                                    <img src="${data.channel_avatar || 'https://ui-avatars.com/api/?name='+encodeURIComponent(data.channel_name)+'&background=2a3942&color=fff'}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-[15px] font-medium truncate text-[#e9edef]">${data.channel_name}</div>
                                    <div class="text-[12.5px] text-[#8696a0] truncate">WhatsApp channel admin invite</div>
                                </div>
                            </div>
                            <div class="text-[14.5px] leading-5 text-[#e9edef] px-1 pb-2">
                                Accept this invitation to be an admin for my WhatsApp channel, ${data.channel_name}
                            </div>
                            <div class="border-t border-white/10 mt-1 cursor-pointer" onclick="window.showAdminInviteModal('${data.channel_id}', this.dataset.name, this.dataset.avatar)" data-name="${(data.channel_name||'').replace(/&/g, '&amp;').replace(/\"/g, '&quot;')}" data-avatar="${data.channel_avatar || ''}">
                                <div class="py-2 text-center text-[#00a884] hover:text-[#00c298] font-medium text-[15px] transition-colors">View Invite</div>
                            </div>
                        </div>`;
                } else if (data.type === 'scheduled_call') {
                    const startStr = new Date(data.start_time * 1000).toLocaleString([], {
                        weekday: 'short',
                        month: 'short',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    const isVideo = data.call_type === 'video';
                    const approvalParam = data.require_approval ? '&require_approval=true' : '';
                    const callLink = `${window.location.origin}/chat/groups/${data.call_type}-call?group_call_id=${data.group_call_id}&name=${encodeURIComponent(data.call_name)}${approvalParam}`;

                    mediaContent = `
                        <div class="mb-2 relative rounded-2xl overflow-hidden border border-white/5 bg-[#1f2c34] w-[270px] max-w-[100%] shadow-lg p-4 text-[#e9edef] font-['Inter']">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-full bg-[#202c33] flex items-center justify-center text-[#00a884] shrink-0 border border-white/5">
                                    ${isVideo ? `
                                        <svg class="w-5 h-5 text-[#00a884]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    ` : `
                                        <svg class="w-5 h-5 text-[#00a884]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    `}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-[15px] font-semibold truncate leading-tight">${data.call_name}</div>
                                    <div class="text-[12px] text-[#8696a0] mt-1">${startStr}</div>
                                    ${data.description ? `<div class="text-xs text-[#8696a0] mt-2 italic line-clamp-2">${data.description}</div>` : ''}
                                </div>
                            </div>
                            <div class="mt-4 flex gap-2 pt-3 border-t border-white/5">
                                <button onclick="window.open('${callLink}', '_blank')" class="flex-1 bg-[#00a884] hover:bg-[#06cf9c] text-[#111b21] py-2 rounded-xl text-center text-sm font-bold transition-all active:scale-[0.98] focus:outline-none">
                                    Join call
                                </button>
                            </div>
                        </div>`;
                } else if (data.type === 'call') {
                    const isVoice = data.call_type === 'voice';
                    const isMissed = data.call_status === 'missed' || data.call_status === 'rejected';
                    const isNoAnswer = data.call_status === 'no_answer';
                    const isCompleted = data.call_status === 'completed';

                    // Format duration
                    let durationText = '';
                    if (isCompleted && data.call_duration) {
                        const d = data.call_duration;
                        if (d >= 3600) durationText = Math.floor(d / 3600) + ' hr ' + Math.floor((d % 3600) /
                            60) + ' min';
                        else if (d >= 60) durationText = Math.floor(d / 60) + ' min';
                        else durationText = d + ' secs';
                    } else if (isMissed) {
                        durationText = 'Tap to call back';
                    } else if (isNoAnswer) {
                        durationText = 'No answer';
                    }

                    const iconColor = isMissed ? '#ef4444' : (isMe ? '#00a884' : '#8696a0');
                    const callIcon = isVoice ?
                        `<svg class="w-5 h-5" fill="${iconColor}" viewBox="0 0 24 24"><path d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z"/></svg>` :
                        `<svg class="w-5 h-5" fill="${iconColor}" viewBox="0 0 24 24"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>`;

                    const arrowIcon = isMe ?
                        `<svg class="w-4 h-4" fill="${isMissed || isNoAnswer ? '#ef4444' : '#00a884'}" viewBox="0 0 24 24"><path d="M5.5 18.5l1.5-1.5L4 14h16v-2H4l3-3-1.5-1.5L0 13l5.5 5.5z" transform="rotate(180 12 12)"/></svg>` :
                        `<svg class="w-4 h-4" fill="${isMissed ? '#ef4444' : '#00a884'}" viewBox="0 0 24 24"><path d="M5.5 18.5l1.5-1.5L4 14h16v-2H4l3-3-1.5-1.5L0 13l5.5 5.5z"/></svg>`;

                    const callLabel = isVoice ? 'Voice call' : 'Video call';
                    const callTitle = isMissed ? (isVoice ? 'Missed voice call' : 'Missed video call') :
                        callLabel;

                    const tapAction = isMissed && !isMe ?
                        `onclick="event.stopPropagation(); ${isVoice ? 'window.startVoiceCall()' : 'window.startVideoCall()'}" style="cursor:pointer"` :
                        '';

                    mediaContent = `
                        <div class="flex items-center gap-3 py-1 min-w-[180px]" ${tapAction}>
                            <div class="w-9 h-9 rounded-full ${isMissed ? 'bg-red-100' : (isMe ? 'bg-[#d0f4e4]' : 'bg-gray-100')} flex items-center justify-center shrink-0">
                                ${callIcon}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-[14px] font-semibold ${isMissed ? 'text-red-600' : 'text-[#e9edef]'} leading-tight">${callTitle}</div>
                                <div class="flex items-center gap-1 mt-0.5">
                                    ${arrowIcon}
                                    <span class="text-[12px] ${isMissed ? 'text-red-500' : 'text-[#8696a0]'}">${durationText}</span>
                                </div>
                            </div>
                        </div>`;
                }

                let replyBlock = '';
                if (data.reply_to_text) {
                    const rName = data.reply_to_name || 'Member';
                    let replyMediaHtml = '';
                    if (data.reply_to_media) {
                        if (data.reply_to_media.match(/\.(mp4|webm|ogg)(\?.*)?$/i) || data.reply_to_text === 'Video') {
                            replyMediaHtml = `<div class="h-10 w-10 shrink-0 ml-2 rounded overflow-hidden bg-black/20 relative"><video src="${data.reply_to_media}#t=0.1" preload="metadata" class="h-full w-full object-cover pointer-events-none"></video><div class="absolute inset-0 flex items-center justify-center bg-black/20 pointer-events-none"><svg viewBox="0 0 24 24" width="16" height="16" fill="white"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg></div></div>`;
                        } else {
                            replyMediaHtml = `<div class="h-10 w-10 shrink-0 ml-2 rounded overflow-hidden bg-black/20"><img src="${data.reply_to_media}" class="h-full w-full object-cover"></div>`;
                        }
                    }
                    replyBlock = `
                    <div class="bg-black/5 border-l-4 ${isMe ? 'border-green-600' : 'border-blue-500'} rounded p-2 mb-2 text-sm overflow-hidden opacity-80 cursor-pointer flex justify-between items-center" onclick="window.scrollToAndHighlightMessage('${data.reply_to_id}')">
                        <div class="flex flex-col flex-1 overflow-hidden">
                            <div class="font-semibold ${isMe ? 'text-green-700' : 'text-blue-600'} text-xs truncate">${rName}</div>
                            <div class="text-[#e9edef] truncate">${data.reply_to_text}</div>
                        </div>
                        ${replyMediaHtml}
                    </div>`;
                }

                // Check if this is the specific searched message (by timestamp)
                const isSearchMatch = window.activeSearchMsgTime && data.time && data.time == window
                    .activeSearchMsgTime;
                const searchHighlightClass = isSearchMatch ? 'search-msg-highlight' : '';

                const html = `
                    <div class="relative group/msg w-full flex ${isMe ? 'justify-end' : 'justify-start'} mt-1 mb-2 px-2 transition-colors cursor-pointer select-none ${searchHighlightClass} gap-2 items-start" id="msg_${key}" onclick="window.toggleMsgSelection('${key}')">

                        ${!isMe ? `
                            <div class="w-8 h-8 rounded-full overflow-hidden shrink-0 mt-0.5 shadow-sm">
                                <img src="${activeAvatar}" class="w-full h-full object-cover">
                            </div>` : ''}

                        <!-- Selection Checkbox (Hidden by default) -->
                        ${data.type !== 'call' ? `
                            <div class="msg-checkbox-container hidden flex-col justify-center px-3 z-10 ${isMe ? 'order-first' : ''}">
                                <div class="w-5 h-5 border-2 border-gray-400 rounded-md flex items-center justify-center bg-white">
                                    <input type="checkbox" id="checkbox_${key}" class="msg-checkbox opacity-0 absolute w-5 h-5 pointer-events-none">
                                    <svg class="w-4 h-4 text-white pointer-events-none transition-opacity opacity-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            </div>
                            ` : ''}

                        <style>
                            #checkbox_${key}:checked + svg { opacity: 1; }
                        </style>

                        <div id="bubble_${key}" class="max-w-[85%] sm:max-w-[70%] relative px-2.5 py-1.5 shadow-sm rounded-lg ${isMe ? 'bg-[#005c4b] rounded-tr-none' : 'bg-[#202c33] rounded-tl-none'} transform transition-transform group-active/msg:scale-[0.98]">

                            <!-- Options Button (WhatsApp Style) -->
                            <div class="absolute top-0 right-0 opacity-0 group-hover/msg:opacity-100 transition-opacity z-10 bg-gradient-to-l ${isMe ? 'from-[#005c4b] via-[#005c4b]' : 'from-[#202c33] via-[#202c33]'} to-transparent pl-3 pr-1 pt-1 ${isMe ? 'rounded-tr-none' : 'rounded-tr-lg'}">
                                <button onclick="event.stopPropagation(); window.toggleMsgMenu('${key}')" class="text-[#8696a0] hover:text-[#e9edef] focus:outline-none transition-colors">
                                    <svg viewBox="0 0 19 20" width="19" height="20" fill="currentColor">
                                        <path d="M3.8 6.7l5.7 5.7 5.7-5.7 1.6 1.6-7.3 7.2-7.3-7.2 1.6-1.6z"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Menu Container with Reaction Strip -->
                            <div id="menu_${key}" class="hidden absolute top-8 ${isMe ? 'right-0' : 'left-0'} z-50 flex flex-col ${isMe ? 'items-end' : 'items-start'} gap-1.5 transform transition-all duration-200">
                                <!-- Reaction Strip -->
                                <div class="bg-[#233138] rounded-full px-2 py-1.5 flex items-center gap-1 shadow-2xl border border-[#313d45] w-max">
                                    <button onclick="event.stopPropagation(); window.sendReaction('👍', '${key}', false, event)" class="w-8 h-8 flex items-center justify-center text-lg hover:bg-white/10 rounded-full transition-transform hover:scale-125"><span class="emoji-text">👍</span></button>
                                    <button onclick="event.stopPropagation(); window.sendReaction('❤️', '${key}', false, event)" class="w-8 h-8 flex items-center justify-center text-lg hover:bg-white/10 rounded-full transition-transform hover:scale-125"><span class="emoji-text">❤️</span></button>
                                    <button onclick="event.stopPropagation(); window.sendReaction('😂', '${key}', false, event)" class="w-8 h-8 flex items-center justify-center text-lg hover:bg-white/10 rounded-full transition-transform hover:scale-125"><span class="emoji-text">😂</span></button>
                                    <button onclick="event.stopPropagation(); window.sendReaction('😮', '${key}', false, event)" class="w-8 h-8 flex items-center justify-center text-lg hover:bg-white/10 rounded-full transition-transform hover:scale-125"><span class="emoji-text">😮</span></button>
                                    <button onclick="event.stopPropagation(); window.sendReaction('😢', '${key}', false, event)" class="w-8 h-8 flex items-center justify-center text-lg hover:bg-white/10 rounded-full transition-transform hover:scale-125"><span class="emoji-text">😢</span></button>
                                    <button onclick="event.stopPropagation(); window.sendReaction('🙏', '${key}', false, event)" class="w-8 h-8 flex items-center justify-center text-lg hover:bg-white/10 rounded-full transition-transform hover:scale-125"><span class="emoji-text">🙏</span></button>
                                    <button onclick="event.stopPropagation(); window.openFullReactionPicker('${key}', false, event)" class="w-8 h-8 flex items-center justify-center text-[18px] text-[#aebac1] hover:bg-white/10 rounded-full transition-transform hover:scale-125 bg-white/5 ml-1">
                                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path></svg>
                                    </button>
                                </div>
                                <!-- Dropdown List -->
                                <div class="bg-[#233138] shadow-2xl border border-[#313d45] rounded-xl w-40 py-1 overflow-hidden flex-shrink-0">
                                    ${data.type !== 'call' ? `
                                        <button onclick="event.stopPropagation(); window.replyTo('${key}')" class="w-full text-left px-4 py-2 text-sm text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors">Reply <svg class="w-4 h-4 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg></button>
                                        <button onclick="event.stopPropagation(); window.copyPrivateMessage('${key}')" class="w-full text-left px-4 py-2 text-sm text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors">Copy <svg class="w-4 h-4 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg></button>
                                        ${isMe && data.type === 'text' ? `
                                            <button onclick="event.stopPropagation(); window.startEdit('${key}')" class="w-full text-left px-4 py-2 text-sm text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors">Edit <svg class="w-4 h-4 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                                        ` : ''}
                                        <button onclick="event.stopPropagation(); window.forwardMsg('${key}')" class="w-full text-left px-4 py-2 text-sm text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors">Forward <svg class="w-4 h-4 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></button>
                                        <button onclick="event.stopPropagation(); window.askMetaAi('${key}', '${activeName}', \`${data.text ? data.text.replace(/\`/g, '\\\\`') : ''}\`)" class="w-full text-left px-4 py-2 text-sm text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors">Ask Meta AI <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8696a0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M12 8a4 4 0 0 1 4 4c0 2.21-1.79 4-4 4s-4-1.79-4-4a4 4 0 0 1 4-4z" class="fill-[#8696a0]"></path></svg></button>
                                        <button id="pin_btn_${key}" onclick="event.stopPropagation(); if(window.pinnedMsgKeys && window.pinnedMsgKeys.has('${key}')) { window.unpinPrivateMessage('${key}'); } else { window.pinPrivateMessage('${key}'); }" class="w-full text-left px-4 py-2 text-sm text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors">
                                             <span id="pin_btn_text_${key}">Pin</span>
                                             <svg class="w-4 h-4 text-[#8696a0]" viewBox="0 0 24 24" fill="currentColor">
                                                 <path d="M16 9V4l1 0c.55 0 1-.45 1-1s-.45-1-1-1H7c-.55 0-1 .45-1 1s.45 1 1 1l1 0v5c0 1.66-1.34 3-3 3v2h5.97v7l1 1 1-1v-7H19v-2c-1.66 0-3-1.34-3-3z"></path>
                                             </svg>
                                         </button>
                                        <button onclick="event.stopPropagation(); window.toggleStarMessage('${key}')" class="w-full text-left px-4 py-2 text-sm text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors"><span id="star_btn_text_${key}">Star</span> <svg class="w-4 h-4 text-[#8696a0]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></button>
                                        <button onclick="event.stopPropagation(); window.selectMessage(); window.toggleMsgSelection('${key}');" class="w-full text-left px-4 py-2 text-sm text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors">Select <svg class="w-4 h-4 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></button>
                                        <div class="h-px bg-[#313d45] my-1 mx-2"></div>
                                        ` : ''}
                                    <button onclick="event.stopPropagation(); window.deleteMsg('${key}')" class="w-full text-left px-4 py-2 text-sm text-[#e9edef] hover:bg-[#182229] flex items-center justify-between transition-colors">Delete <svg class="w-4 h-4 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                </div>
                            </div>

                            ${replyBlock}
                            ${mediaContent}

                            ${data.text ? (() => {
                                const callLink = window.parseCallLink(data.text);
                                if (callLink) {
                                    return window.renderCallLinkHTML(callLink.url, callLink.type, isMe);
                                }
                                const textToRender = isSearchMatch ? window.highlightSearchText(data.text) : data.text;
                                let htmlText = window.wrapEmojis ? window.wrapEmojis(textToRender) : textToRender;
                                if (window.linkifyText) htmlText = window.linkifyText(htmlText);
                                return `<div class="text-[14.2px] text-[#e9edef] leading-relaxed break-words pb-[2px]" style="white-space: pre-wrap; word-break: break-word;">${htmlText}<span class="inline-block w-[99px] h-[1px]"></span></div>`;
                            })() : ''}

                            <div class="flex items-center justify-end gap-1 absolute bottom-1 right-2 bg-transparent">
                                <span id="star_icon_${key}" class="msg-star-icon hidden shrink-0"><svg viewBox="0 0 24 24" width="14" height="14" fill="#8696a0"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></span>
                                <span id="pin_icon_${key}" class="msg-pin-icon hidden shrink-0"><svg viewBox="0 0 24 24" width="14" height="14" fill="#8696a0"><path d="M16 9V4l1 0c.55 0 1-.45 1-1s-.45-1-1-1H7c-.55 0-1 .45-1 1s.45 1 1 1l1 0v5c0 1.66-1.34 3-3 3v2h5.97v7l1 1 1-1v-7H19v-2c-1.66 0-3-1.34-3-3z"/></svg></span>
                                ${data.is_edited ? `<span class="edited-label text-[10px] text-[#8696a0] select-none italic mr-0.5">Edited</span>` : ''}
                                <span class="text-[11px] text-[#8696a0] select-none leading-none">${time}</span>
                                ${isMe ? `<span id="tick_${key}" class="shrink-0 flex items-center justify-center leading-none">${window.getTickSVG(data.status || 'sent')}</span>` : ''}
                            </div>
                            <div id="reactions_${key}" class="hidden"></div>
                        </div>
                    </div>`;
                    document.getElementById('messages').insertAdjacentHTML('beforeend', html);
                    if (data.reactions) window.renderReactions(key, data.reactions, isMe);
                    // Show pin icon immediately if this message is already pinned
                    if (window.pinnedMsgKeys && window.pinnedMsgKeys.has(key)) {
                        const icon = document.getElementById('pin_icon_' + key);
                        if (icon) icon.classList.remove('hidden');
                    }

                    // Show star icon if already starred
                    if (window.starredMsgKeys && window.starredMsgKeys.has(key)) {
                        const sIcon = document.getElementById('star_icon_' + key);
                        if (sIcon) sIcon.classList.remove('hidden');
                        const btnText = document.getElementById('star_btn_text_' + key);
                        if (btnText) btnText.textContent = 'Unstar';
                    }

                    // If search is active, scroll to first matching message; otherwise scroll to bottom
                    if (isSearchMatch && !window._searchScrolled) {
                        window._searchScrolled = true;
                        setTimeout(() => {
                            const firstMatch = document.querySelector('.search-msg-highlight');
                            if (firstMatch) {
                                firstMatch.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        }, 500);
                    } else if (!window.activeSearchQuery) {
                        scrollToBottom();
                    }
                });

                window.unsubscribeRemoved = window.onChildRemoved(messagesRef, (snapshot) => {
                    const key = snapshot.key;
                    const msgEl = document.getElementById('msg_' + key);
                    if (msgEl) msgEl.remove();
                    delete window.globalMessages[key];
                    if (window.globalMediaCache) {
                        window.globalMediaCache = window.globalMediaCache.filter(m => m.key !== key && !m.key.startsWith(key + '_link_'));
                    }
                    if (window.updateContactInfoMediaSection) {
                        window.updateContactInfoMediaSection();
                    }
                });

                window.unsubscribeChanged = window.onChildChanged(messagesRef, (snapshot) => {
                    const data = snapshot.val();
                    const key = snapshot.key;

                    if (data && data.deleted_for && data.deleted_for[window.myUserId]) {
                        const msgEl = document.getElementById('msg_' + key);
                        if (msgEl) msgEl.remove();
                        delete window.globalMessages[key];
                        if (window.globalMediaCache) {
                            window.globalMediaCache = window.globalMediaCache.filter(m => m.key !== key && !m.key.startsWith(key + '_link_'));
                        }
                        if (window.updateContactInfoMediaSection) {
                            window.updateContactInfoMediaSection();
                        }
                        return;
                    }

                    const oldMsg = window.globalMessages[key];
                    const oldReactions = oldMsg ? (oldMsg.reactions || {}) : {};
                    const newReactions = data.reactions || {};

                    window.globalMessages[key] = data;

                    const isMe = data.sender_id == window.myUserId;
                    if (isMe) {
                        const tickEl = document.getElementById('tick_' + key);
                        if (tickEl) {
                            tickEl.innerHTML = window.getTickSVG(data.status || 'sent');
                        }
                    }

                    // Update text if message was edited
                    const bubbleEl = document.getElementById('bubble_' + key);
                    if (bubbleEl) {
                        const textDiv = bubbleEl.querySelector('.break-words');
                        if (textDiv && data.text) {
                            const callLink = window.parseCallLink(data.text);
                            let newHtmlText = '';
                            if (callLink) {
                                newHtmlText = window.renderCallLinkHTML(callLink.url, callLink.type, isMe);
                            } else {
                                const isSearchMatch = window.activeSearchMsgTime && data.time && data.time == window.activeSearchMsgTime;
                                const textToRender = isSearchMatch ? window.highlightSearchText(data.text) : data.text;
                                newHtmlText = (window.wrapEmojis ? window.wrapEmojis(textToRender) : textToRender) + '<span class="inline-block w-[99px] h-[1px]"></span>';
                            }
                            textDiv.innerHTML = newHtmlText;
                        }

                        // Add Edited indicator if not present
                        if (data.is_edited) {
                            const timeSpan = bubbleEl.querySelector('span.text-\\[11px\\]') || bubbleEl.querySelector('span:not(.edited-label):not(.msg-star-icon):not(.msg-pin-icon):not(#tick_' + key + ')');
                            if (timeSpan && !bubbleEl.querySelector('.edited-label')) {
                                timeSpan.insertAdjacentHTML('beforebegin', '<span class="edited-label text-[10px] text-[#8696a0] select-none italic mr-0.5">Edited</span>');
                            }
                        }
                    }

                    window.renderReactions(key, newReactions, isMe);

                    // Notification for new reactions on MY messages
                    if (isMe) {
                        for (const [uid, emoji] of Object.entries(newReactions)) {
                            if (uid != window.myUserId && oldReactions[uid] !== emoji) {
                                const reactionKey = `${key}_${uid}_${emoji}`;
                                window.seenReactions = window.seenReactions || new Set();
                                if (!window.seenReactions.has(reactionKey)) {
                                    window.seenReactions.add(reactionKey);
                                    const reactorName = window.activeChatName || 'Someone';
                                    window.showToast('Reaction', `${reactorName} reacted to your message: ${emoji}`);
                                    if (Notification.permission === "granted" && document.visibilityState !== 'visible') {
                                        new Notification("Reaction", { body: `${reactorName} reacted: ${emoji}` });
                                    }
                                }
                            }
                        }
                    }
                });

                // Call updateBlockedUI to refresh UI state for newly selected chat
                if (window.updateBlockedUI) window.updateBlockedUI();
            };

            // Handle Tab Visibility (Mark as read when returning to tab)
            document.addEventListener("visibilitychange", () => {
                if (document.visibilityState === 'visible' && window.currentChatId) {
                    for (let key in window.globalMessages) {
                        let msg = window.globalMessages[key];
                        if (msg.sender_id != window.myUserId && msg.status !== 'read') {
                            update(ref(db, `chats/${window.currentChatId}/messages/${key}`), { status: 'read' });
                        }
                    }
                }
            });

            // Handle Notifications Permissions and Token
            async function requestPermission() {
                console.log('Requesting permission...');

                if (Notification.permission === 'denied') {
                    window.showToast('Notifications Blocked', 'Please enable notifications in your browser settings to receive messages.');
                    return;
                }

                const permission = await Notification.requestPermission();
                if (permission === 'granted') {
                    console.log('Notification permission granted.');

                    try {
                        // Get FCM Token
                        // NOTE: For production, you should add your VAPID key here: { vapidKey: '...' }
                        const currentToken = await getToken(messaging);
                        if (currentToken) {
                            console.log('FCM Token:', currentToken);
                            // Save token to server
                            await fetch('/save-token', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                                body: JSON.stringify({ token: currentToken })
                            });
                        } else {
                            console.warn('No registration token available. Request permission to generate one.');
                        }
                    } catch (err) {
                        console.error('An error occurred while retrieving token. ', err);
                    }
                } else if (permission === 'denied') {
                    console.warn('Unable to get permission to notify.');
                    window.showToast('Permission Denied', 'You will not receive notifications until you allow them in your browser.');
                }
            }

            requestPermission();

            // Handle Foreground Messages
            onMessage(messaging, (payload) => {
                console.log('Message received. ', payload);

                // 1. If I am the sender, don't show notification
                if (payload.data && payload.data.sender_id == window.myUserId) {
                    return;
                }

                // 2. If I am already looking at this chat, don't show notification
                if (payload.data && payload.data.chat_id == window.currentChatId) {
                    return;
                }

                const { title, body } = payload.notification;
                const senderId = payload.data ? payload.data.sender_id : null;
                const senderName = payload.data ? payload.data.sender_name : 'Someone';

                // Use the custom showToast instead of alert
                window.showToast(title, body, senderId, senderName);

                // Also trigger standard browser notification if permission granted and tab is hidden
                if (Notification.permission === "granted" && document.visibilityState !== 'visible') {
                    new Notification(title, {
                        body: body,
                        icon: 'https://cdn-icons-png.flaticon.com/512/733/733585.png' // WhatsApp icon
                    });
                }
            });

            // Selection Logic
            window.isSelectionMode = false;
            window.isForwardSelection = false;
            window.selectedMessages = new Set();
            window._selectedForwardTargets = new Map(); // targetId => { type, name }

            window.selectMessage = function() {
                window.isSelectionMode = true;
                document.getElementById('normal_header')?.classList.add('hidden');
                document.getElementById('selection_header')?.classList.remove('hidden');
                document.getElementById('selection_header')?.classList.add('flex');

                document.querySelectorAll('.msg-checkbox-container').forEach(el => el.classList.remove('hidden'));
                document.getElementById('private_header_more_dropdown')?.classList.add('hidden');
            };

            window.cancelSelection = function () {
                window.isSelectionMode = false;
                window.isForwardSelection = false;
                window.selectedMessages.clear();

                document.getElementById('normal_header')?.classList.remove('hidden');
                document.getElementById('selection_header')?.classList.add('hidden');

                // Hide selection bottom bar and show normal input container
                document.getElementById('selection_bottom_bar')?.classList.add('hidden');
                document.getElementById('normal_input_container')?.classList.remove('hidden');

                document.querySelectorAll('.msg-checkbox-container').forEach(el => el.classList.add('hidden'));
                document.querySelectorAll('.msg-checkbox').forEach(el => {
                    el.checked = false;
                    const box = el.parentElement;
                    box.classList.remove('bg-[#0d9488]', 'border-[#0d9488]');
                    box.classList.add('bg-white', 'border-gray-400');
                });
                document.querySelectorAll('[id^="msg_"]').forEach(el => el.classList.remove('bg-blue-100', 'bg-opacity-50'));
            };

            window.confirmDeleteSelected = function () {
                if (window.selectedMessages.size === 0) return;
                window.openDeleteModal(`Delete ${window.selectedMessages.size} message(s)?`, () => {
                    window.selectedMessages.forEach(key => {
                        remove(ref(db, `chats/${window.currentChatId}/messages/${key}`))
                            .catch(e => console.error("Batch delete error:", e));
                    });
                    window.cancelSelection();
                });
            };

            window.openDeleteModal = function (title, onConfirmMe, onConfirmEveryone = null, confirmBtnLabel = 'Delete for me') {
                const modal = document.getElementById('delete_modal');
                const titleEl = document.getElementById('delete_modal_title');
                const confirmBtn = document.getElementById('delete_confirm_btn');
                const everyoneBtn = document.getElementById('delete_everyone_btn');

                if (titleEl) titleEl.textContent = title;
                if (confirmBtn) {
                    if (onConfirmMe === null) {
                        confirmBtn.classList.add('hidden');
                    } else {
                        confirmBtn.classList.remove('hidden');
                        confirmBtn.textContent = confirmBtnLabel;
                        confirmBtn.onclick = function () {
                            if(typeof onConfirmMe === 'function') onConfirmMe();
                            window.closeDeleteModal();
                        };
                    }
                }

                if (everyoneBtn) {
                    if (onConfirmEveryone) {
                        everyoneBtn.classList.remove('hidden');
                        everyoneBtn.onclick = function () {
                            onConfirmEveryone();
                            window.closeDeleteModal();
                        };
                    } else {
                        everyoneBtn.classList.add('hidden');
                    }
                }

                modal.classList.remove('hidden');
                setTimeout(() => modal.classList.add('show'), 10);
            };

            window.closeDeleteModal = function () {
                const modal = document.getElementById('delete_modal');
                modal.classList.remove('show');
                setTimeout(() => modal.classList.add('hidden'), 300);
            };

            window.toggleMsgSelection = function (key) {
                if (!window.isSelectionMode && !window.isForwardSelection) return;
                const msg = window.globalMessages[key];
                if (msg && msg.type === 'call') return;

                const checkbox = document.getElementById('checkbox_' + key);
                const msgEl = document.getElementById('msg_' + key);
                if (!checkbox || !msgEl) return;

                checkbox.checked = !checkbox.checked;
                const box = checkbox.parentElement;

                if (checkbox.checked) {
                    window.selectedMessages.add(key);
                    msgEl.classList.add('bg-blue-100', 'bg-opacity-50');
                    box.classList.add('bg-[#0d9488]', 'border-[#0d9488]');
                    box.classList.remove('bg-white', 'border-gray-400');
                } else {
                    window.selectedMessages.delete(key);
                    msgEl.classList.remove('bg-blue-100', 'bg-opacity-50');
                    box.classList.remove('bg-[#0d9488]', 'border-[#0d9488]');
                    box.classList.add('bg-white', 'border-gray-400');
                }

                if (window.selectedMessages.size === 0) {
                    window.cancelSelection();
                } else {
                    if (window.isSelectionMode) {
                        document.getElementById('selection_count').textContent = window.selectedMessages.size + ' Selected';
                    } else if (window.isForwardSelection) {
                        document.getElementById('selection_bottom_count').textContent = window.selectedMessages.size + ' Selected';
                    }
                }
            };

            // Forward Modal Operations
            window.openForwardModal = function (isFromGroup = false) {
                window.isForwardingFromGroup = isFromGroup;
                const modal = document.getElementById('forward_modal');
                const listContainer = document.getElementById('forward_contacts_list');
                const searchInput = document.getElementById('forward_search_input');
                const footer = document.getElementById('forward_modal_footer');

                if (!modal || !listContainer) return;

                window._selectedForwardTargets.clear();
                if (searchInput) searchInput.value = '';
                if (footer) footer.classList.add('hidden');

                // Reset My Status checkbox UI
                const statusBox = document.getElementById('forward_checkbox_box_status');
                const statusCheck = document.getElementById('forward_checkbox_status');
                if (statusCheck) statusCheck.checked = false;
                if (statusBox) {
                    statusBox.classList.remove('bg-[#0d9488]', 'border-[#0d9488]');
                    statusBox.classList.add('bg-white', 'border-gray-400');
                    statusBox.querySelector('svg')?.classList.add('hidden');
                }

                // Gather contacts from sidebar
                let html = '';

                // 1. Users
                const userNodes = document.querySelectorAll('#user_list_container [id^="user_sidebar_"]');
                userNodes.forEach(node => {
                    const userId = node.id.replace('user_sidebar_', '');
                    const name = node.querySelector('h4')?.textContent.trim() || '';
                    const imgEl = node.querySelector('img');
                    const avatar = imgEl ? imgEl.src : `
            https: //ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=2a3942&color=fff`;
                    const about = node.querySelector('p')?.textContent.trim() || 'Available';

                html += `
                    <div onclick="window.toggleForwardTargetSelection('${userId}', '${name.replace(/'/g, "\\'")}', 'user')"
                        class="flex items-center justify-between p-3 hover:bg-[#2a3942]/60 rounded-xl cursor-pointer transition-all group/item forward-target-item" data-name="${name.toLowerCase()}">
                        <div class="flex items-center gap-4 flex-1 min-w-0">
                            <img src="${avatar}" class="w-12 h-12 rounded-full object-cover border border-white/5 shrink-0">
                            <div class="min-w-0 flex-1">
                                <div class="text-[#e9edef] font-medium truncate">${name}</div>
                                <div class="text-[#8696a0] text-sm truncate mt-0.5">${about}</div>
                            </div>
                        </div>
                        <div class="shrink-0 mr-1">
                            <div class="w-5 h-5 rounded border-2 border-gray-400 bg-white flex items-center justify-center transition-all select-none" id="forward_checkbox_box_${userId}">
                                <input type="checkbox" id="forward_checkbox_${userId}" class="hidden">
                                <svg class="w-3.5 h-3.5 text-white hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        </div>
                    </div>`;
            });

            // 2. Groups
            const groupNodes = document.querySelectorAll('#user_list_container [id^="group_sidebar_"]');
            groupNodes.forEach(node => {
                const groupId = node.id.replace('group_sidebar_', '');
                const name = node.querySelector('h4')?.textContent.trim() || '';
                const imgEl = node.querySelector('img');
                const avatar = imgEl ? imgEl.src :
                    `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=2a3942&color=fff`;
                const about = node.querySelector('p')?.textContent.trim() || 'Group chat';

                html += `
                    <div onclick="window.toggleForwardTargetSelection('${groupId}', '${name.replace(/'/g, "\\'")}', 'group')"
                        class="flex items-center justify-between p-3 hover:bg-[#2a3942]/60 rounded-xl cursor-pointer transition-all group/item forward-target-item" data-name="${name.toLowerCase()}">
                        <div class="flex items-center gap-4 flex-1 min-w-0">
                            <img src="${avatar}" class="w-12 h-12 rounded-full object-cover border border-white/5 shrink-0">
                            <div class="min-w-0 flex-1">
                                <div class="text-[#e9edef] font-medium truncate">${name}</div>
                                <div class="text-[#8696a0] text-sm truncate mt-0.5">${about}</div>
                            </div>
                        </div>
                        <div class="shrink-0 mr-1">
                            <div class="w-5 h-5 rounded border-2 border-gray-400 bg-white flex items-center justify-center transition-all select-none" id="forward_checkbox_box_${groupId}">
                                <input type="checkbox" id="forward_checkbox_${groupId}" class="hidden">
                                <svg class="w-3.5 h-3.5 text-white hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        </div>
                    </div>`;
            });

            listContainer.innerHTML = html;
            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.add('show'), 10);
        };

        window.closeForwardModal = function() {
            const modal = document.getElementById('forward_modal');
            modal.classList.remove('show');
            setTimeout(() => {
                modal.classList.add('hidden');
                window.isForwardingChannel = false;
                window.forwardChannelText = '';
            }, 300);
        };

        window.filterForwardContacts = function() {
            const val = document.getElementById('forward_search_input').value.trim().toLowerCase();
            const items = document.querySelectorAll('.forward-target-item');
            items.forEach(item => {
                const name = item.getAttribute('data-name');
                if (name.includes(val)) {
                    item.classList.remove('hidden');
                    item.classList.add('flex');
                } else {
                    item.classList.remove('flex');
                    item.classList.add('hidden');
                }
            });
        };

        window.toggleForwardTargetSelection = function(targetId, targetName, type) {
            const checkbox = document.getElementById('forward_checkbox_' + targetId);
            const box = document.getElementById('forward_checkbox_box_' + targetId);
            if (!checkbox || !box) return;

            checkbox.checked = !checkbox.checked;
            const svg = box.querySelector('svg');

            if (checkbox.checked) {
                window._selectedForwardTargets.set(targetId, {
                    type,
                    name: targetName
                });
                box.classList.add('bg-[#0d9488]', 'border-[#0d9488]');
                box.classList.remove('bg-white', 'border-gray-400');
                if (svg) svg.classList.remove('hidden');
            } else {
                window._selectedForwardTargets.delete(targetId);
                box.classList.remove('bg-[#0d9488]', 'border-[#0d9488]');
                box.classList.add('bg-white', 'border-gray-400');
                if (svg) svg.classList.add('hidden');
            }

            // Update footer
            const footer = document.getElementById('forward_modal_footer');
            const namesDisplay = document.getElementById('forward_selected_names');

            if (window._selectedForwardTargets.size > 0) {
                footer.classList.remove('hidden');
                footer.classList.add('flex');

                const names = Array.from(window._selectedForwardTargets.values()).map(t => t.name);
                namesDisplay.textContent = names.join(', ');
            } else {
                footer.classList.add('hidden');
                footer.classList.remove('flex');
            }
        };

        window.sendForwardedMessages = async function() {
            if (window.isForwardingFromGroup) {
                if (typeof window.sendGroupForwardedMessages === 'function') {
                    await window.sendGroupForwardedMessages();
                }
                return;
            }

            if (window._selectedForwardTargets.size === 0) return;
            if (!window.isForwardingChannel && (!window.selectedMessages || window.selectedMessages.size === 0)) return;

            const messagesToForward = [];

            if (window.isForwardingChannel) {
                messagesToForward.push({
                    type: 'text',
                    text: window.forwardChannelText || 'Check out this channel'
                });
            } else {
                window.selectedMessages.forEach(key => {
                    let msg = window.globalMessages ? window.globalMessages[key] : null;

                if (!msg && window.globalMediaCache) {
                    const cacheItem = window.globalMediaCache.find(m => m.key === key);
                    if (cacheItem) {
                        msg = {
                            type: cacheItem.type,
                            file_url: cacheItem.url,
                            file_name: cacheItem.fileName,
                            text: '',
                            lat: null,
                            lng: null
                        };
                    }
                }

                    if (msg) {
                        messagesToForward.push(msg);
                    }
                });
            }

            window.closeForwardModal();
            window.cancelSelection();

            for (const [targetId, targetInfo] of window._selectedForwardTargets.entries()) {
                if (targetId === 'status') {
                    for (const msg of messagesToForward) {
                        const statusData = {
                            userId: window.myUserId,
                            userName: window.myUserName,
                            userAvatar: window.myUserAvatar,
                            text: msg.text || '',
                            type: msg.type || 'text',
                            timestamp: window.serverTimestamp(),
                            viewers: {},
                            privacyMode: window.currentPrivacyMode || 'all',
                            privacyContacts: window.currentPrivacyContacts || []
                        };
                        if (msg.file_url) statusData.mediaUrl = msg.file_url;
                        if (msg.type === 'text') {
                            statusData.bgColor = '#00a884';
                            statusData.font = 'font-sans';
                        }

                        try {
                            const statusRef = window.ref(window.db, `statuses/${window.myUserId}`);
                            await window.push(statusRef, statusData);
                        } catch (e) {
                            console.error('Forward to status error:', e);
                        }
                    }
                } else {
                    const isTargetGroup = targetInfo.type === 'group';
                    let chatId = '';
                    if (isTargetGroup) {
                        chatId = 'group_' + targetId.replace('group_', '');
                    } else {
                        const minId = Math.min(window.myUserId, parseInt(targetId));
                        const maxId = Math.max(window.myUserId, parseInt(targetId));
                        chatId = `chat_${minId}_${maxId}`;
                    }

                    for (const msg of messagesToForward) {
                        const formData = new FormData();
                        formData.append('chat_id', chatId);
                        formData.append('type', msg.type || 'text');
                        formData.append('message', msg.text || '');
                        if (msg.file_url) {
                            formData.append('file_url', msg.file_url);
                            formData.append('file_name', msg.file_name || 'file');
                        }
                        if (msg.lat) formData.append('lat', msg.lat);
                        if (msg.lng) formData.append('lng', msg.lng);

                        try {
                            await fetch('/send', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrf
                                },
                                body: formData
                            });
                        } catch (e) {
                            console.error('Forward send error:', e);
                        }
                    }
                }
            }

            if (window.showToast) {
                window.showToast('Forwarded', 'Message forwarded successfully.');
            }
        };

        window.forwardMsg = function(key) {
            window.closeMsgMenu(key);

            window.isForwardSelection = true;
            window.selectedMessages.clear();

            document.getElementById('normal_input_container')?.classList.add('hidden');

            const bottomBar = document.getElementById('selection_bottom_bar');
            if (bottomBar) {
                bottomBar.classList.remove('hidden');
                bottomBar.classList.add('flex');
            }

            document.querySelectorAll('.msg-checkbox-container').forEach(el => el.classList.remove('hidden'));

            window.toggleMsgSelection(key);
        };

        // Activates selection mode starting with chosen message
        window.deleteMsg = function(key) {
            window.closeMsgMenu(key);
            const msgData = window.globalMessages[key];
            let typeLabel = 'message';
            if (msgData) {
                if (msgData.type === 'image') typeLabel = 'photo';
                else if (msgData.type === 'video') typeLabel = 'video';
                else if (msgData.type === 'audio') typeLabel = 'audio';
                else if (msgData.type === 'document') typeLabel = 'document';
            }

            const isMe = msgData && msgData.sender_id == window.myUserId;

            const onConfirmMe = () => {
                set(ref(db, `chats/${window.currentChatId}/messages/${key}/deleted_for/${window.myUserId}`), true)
                    .catch(e => console.error("Delete for me error:", e));
            };

            const onConfirmEveryone = isMe ? () => {
                remove(ref(db, `chats/${window.currentChatId}/messages/${key}`))
                    .catch(e => console.error("Delete for everyone error:", e));
            } : null;

            window.openDeleteModal(`Delete ${typeLabel}?`, onConfirmMe, onConfirmEveryone);
        };

        // === INCOMING CALL LISTENER ===
        const myCallsRef = ref(db, 'calls');
        onChildAdded(myCallsRef, async (snapshot) => {
            const callData = snapshot.val();
            const callKey = snapshot.key;
            if (!callData) return;

            // ✅ FIX 1: Ignore calls older than 30 seconds (handles page refresh showing stale calls)
            const callAge = Date.now() - (callData.created_at || 0);
            if (callAge > 30000) return; // Older than 30 seconds → skip

            // ✅ FIX 2: Re-read from Firebase to get the LATEST status (not cached snapshot)
            let freshStatus = callData.status;
            try {
                const freshSnap = await get(ref(db, `calls/${callKey}/status`));
                freshStatus = freshSnap.val();
            } catch(e) {}

            // Only show if I am the callee and call is STILL in 'calling' state RIGHT NOW
            if (callData.callee_id == window.myUserId && freshStatus === 'calling') {
                window.showIncomingCall(callKey, callData.caller_name, callData.caller_avatar || '', callData.type,
                    callData.group_call_id || null);
                window._incomingCallerId = callData.caller_id;
                window._incomingCallType = callData.type;

                // Set up reject function
                window._rejectCallFn = async function() {
                    try {
                        await update(ref(db, `calls/${callKey}`), {
                            status: 'rejected'
                        });
                    } catch (e) {}
                    setTimeout(async () => {
                        try {
                            await remove(ref(db, `calls/${callKey}`));
                        } catch (e) {}
                    }, 3000);
                };

                // Set up missed call log sender
                window._sendMissedCallLog = async function() {
                    const callerId = callData.caller_id;
                    const minId = Math.min(window.myUserId, callerId);
                    const maxId = Math.max(window.myUserId, callerId);
                    const chatId = `chat_${minId}_${maxId}`;
                    const now = Math.floor(Date.now() / 1000);
                    try {
                        await push(ref(db, `chats/${chatId}/messages`), {
                            sender_id: callerId,
                            type: 'call',
                            call_type: callData.type,
                            call_status: 'missed',
                            call_duration: 0,
                            text: '',
                            time: now,
                            status: 'sent'
                        });

                        const logData = {
                            type: callData.type,
                            status: 'missed',
                            direction: 'incoming',
                            duration: 0,
                            time: now,
                            other_user_id: callerId,
                            other_user_name: callData.caller_name || 'Unknown',
                            other_user_avatar: callData.caller_avatar || ''
                        };
                        await push(ref(db, `users/${window.myUserId}/call_logs`), logData);
                    } catch (e) {
                        console.error('Missed call log error:', e);
                    }
                };

                // Auto-dismiss if caller cancels
                onValue(ref(db, `calls/${callKey}/status`), (snap) => {
                    const st = snap.val();
                    if (st === 'ended' || st === null) {
                        try {
                            document.getElementById('ic_ringtone').pause();
                        } catch (e) {}
                        document.getElementById('incoming_call_overlay').classList.add('hidden');
                        window._incomingCallId = null;
                    }
                });
            }
        });

        // Starred messages state
        window.starredMsgKeys = new Set();

        window.toggleStarMessage = function(key) {
            window.closeMsgMenu(key);
            if (!window.currentChatId || !window.myUserId) return;

            const msg = window.globalMessages[key];
            if (!msg) return;

            const starRef = ref(db, `starred_messages/${window.myUserId}/${key}`);

            if (window.starredMsgKeys.has(key)) {
                // Unstar
                remove(starRef).then(() => {
                    window.starredMsgKeys.delete(key);
                    const icon = document.getElementById('star_icon_' + key);
                    if (icon) icon.classList.add('hidden');
                    const btnText = document.getElementById('star_btn_text_' + key);
                    if (btnText) btnText.textContent = 'Star';
                    window.showToast?.('Message Unstarred', 'Message removed from starred.');
                });
            } else {
                // Star
                set(starRef, {
                    text: msg.text || '',
                    type: msg.type || 'text',
                    file_url: msg.file_url || null,
                    file_name: msg.file_name || null,
                    time: msg.time || 0,
                    sender_id: msg.sender_id,
                    chat_id: window.currentChatId
                }).then(() => {
                    window.starredMsgKeys.add(key);
                    const icon = document.getElementById('star_icon_' + key);
                    if (icon) icon.classList.remove('hidden');
                    const btnText = document.getElementById('star_btn_text_' + key);
                    if (btnText) btnText.textContent = 'Unstar';
                    window.showToast?.('Message Starred', 'Message added to starred.');
                });
            }
        };

        // Load starred messages for current chat and apply icons
        window.loadStarredMessages = function() {
            if (!window.myUserId) return;
            const starredRef = ref(db, `starred_messages/${window.myUserId}`);
            onValue(starredRef, (snapshot) => {
                window.starredMsgKeys = new Set();
                const data = snapshot.val();
                if (data) {
                    Object.keys(data).forEach(key => {
                        window.starredMsgKeys.add(key);
                    });
                }
                // Apply icons after a short delay to ensure messages are rendered
                window._applyStarIcons();
            });
        };

        window._applyStarIcons = function() {
            if (!window.starredMsgKeys) return;
            // Clear all star icons first
            document.querySelectorAll('.msg-star-icon, [id^="star_icon_"]').forEach(el => {
                el.classList.add('hidden');
            });
            // Show icons for starred messages
            window.starredMsgKeys.forEach(key => {
                const icon = document.getElementById('star_icon_' + key);
                if (icon) icon.classList.remove('hidden');
                const btnText = document.getElementById('star_btn_text_' + key);
                if (btnText) btnText.textContent = 'Unstar';
            });
        };

        window.updateBlockedUI = function() {
            if (!window.currentChatId || window.currentChatId.startsWith('group_')) {
                // Group chats can't be blocked in this implementation
                document.getElementById('normal_input_container')?.classList.remove('hidden');
                document.getElementById('normal_input_container')?.classList.add('flex');
                document.getElementById('blocked_state_container')?.classList.add('hidden');
                document.getElementById('blocked_state_container')?.classList.remove('flex');
                return;
            }

            const targetId = window.currentChatId.replace('chat_', '').split('_').find(id => id != window.myUserId);
            const elementId = `user_sidebar_${targetId}`;
            const isBlocked = window.blockedUsers?.includes(elementId);

            const normalInput = document.getElementById('normal_input_container');
            const blockedState = document.getElementById('blocked_state_container');

            if (isBlocked) {
                if (normalInput) {
                    normalInput.classList.add('hidden');
                    normalInput.classList.remove('flex');
                }
                if (blockedState) {
                    blockedState.classList.remove('hidden');
                    blockedState.classList.add('flex');
                }
            } else {
                if (normalInput) {
                    normalInput.classList.remove('hidden');
                    normalInput.classList.add('flex');
                }
                if (blockedState) {
                    blockedState.classList.add('hidden');
                    blockedState.classList.remove('flex');
                }
            }
        };

        window.checkAndApplyClearedChatUI = function(clearedElementId) {
            if (window.currentChatId) {
                const isGroup = window.currentChatId.startsWith('group_');
                let activeElementId;
                if (isGroup) {
                    activeElementId = `group_sidebar_${window.currentChatId.replace('group_', '')}`;
                } else {
                    const targetId = window.currentChatId.replace('chat_', '').split('_').find(id => id != window
                        .myUserId);
                    activeElementId = `user_sidebar_${targetId}`;
                }

                if (activeElementId === clearedElementId || (isGroup && clearedElementId.replace('group_sidebar_group_', 'group_sidebar_') === activeElementId)) {
                    // Clear messages container
                    const msgsContainer = document.getElementById(isGroup ? 'group_messages' : 'messages');
                    if (msgsContainer) {
                        msgsContainer.innerHTML = '';
                    }
                    // Clear reply state
                    if (isGroup && typeof window.cancelGroupReply === 'function') {
                        window.cancelGroupReply();
                    } else if (typeof window.cancelReply === 'function') {
                        window.cancelReply();
                    }

                    // Hide pinned messages bars
                    if (isGroup) {
                        const pinBar = document.getElementById('group_pinned_bar');
                        if (pinBar) pinBar.classList.add('hidden');
                        window._groupPinnedMsgsList = [];
                        if (window._groupPinnedMsgKeys) window._groupPinnedMsgKeys.clear();
                    } else {
                        const pinBar = document.getElementById('private_pinned_bar');
                        if (pinBar) pinBar.classList.add('hidden');
                        window._pinnedMsgsList = [];
                        if (window.pinnedMsgKeys) window.pinnedMsgKeys.clear();
                    }
                }
            }

            // Also update the sidebar preview
            const isTargetGroup = clearedElementId.startsWith('group_sidebar_');
            const targetId = clearedElementId.replace('user_sidebar_', '').replace('group_sidebar_', '');
            const lastMsgElId = isTargetGroup ? `group_last_msg_${targetId}` : `last_msg_${targetId}`;
            let lastMsgEl = document.getElementById(lastMsgElId);
            if (!lastMsgEl && isTargetGroup) {
                lastMsgEl = document.getElementById(`group_last_msg_${targetId.replace('group_', '')}`);
            }
            if (lastMsgEl) lastMsgEl.textContent = isTargetGroup ? 'Group chat' : 'Click to chat';
        };

        // --- NEW GROUP CALL MODAL LOGIC ---
        window.selectedGroupCallUsers = new Set();

        window.openNewGroupCallModal = function() {
            // Close the call dropdown
            const callDropdown = document.getElementById('call_dropdown');
            if (callDropdown) {
                callDropdown.style.display = 'none';
                callDropdown.classList.remove('show');
            }

            // Show the modal
            const modal = document.getElementById('new_group_call_modal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            // Reset selection state
            window.selectedGroupCallUsers.clear();
            document.getElementById('group_call_search_input').value = '';

            // Pre-select the current active chat user if available
            if (window.activeChatUser && window.activeChatUser.id !== 'meta_ai') {
                window.selectedGroupCallUsers.add(String(window.activeChatUser.id));
            }

            // Render contacts list and chips
            window.renderGroupCallContacts();
            window.renderGroupCallChips();
        };

        window.openNewCallModal = function() {
            const modal = document.getElementById('new_call_modal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
            const searchInput = document.getElementById('new_call_search_input');
            if (searchInput) {
                searchInput.value = '';
            }
            window.renderNewCallContacts();
        };

        window.closeNewCallModal = function() {
            const modal = document.getElementById('new_call_modal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        };

        window.renderNewCallContacts = function() {
            const listEl = document.getElementById('new_call_contacts_list');
            if (!listEl) return;

            const searchQuery = (document.getElementById('new_call_search_input')?.value || '').toLowerCase().trim();
            listEl.innerHTML = '';

            if (!window.allContacts || window.allContacts.length === 0) {
                listEl.innerHTML = `<div class="p-10 text-center text-[#8696a0] text-sm">No contacts available</div>`;
                return;
            }

            const filtered = window.allContacts.filter(c => {
                if (String(c.id) === String(window.myUserId) || c.id === 'meta_ai') return false;
                const name = (c.saved_name || c.name || c.phone || '').toLowerCase();
                const phone = (c.phone || '').toLowerCase();
                return name.includes(searchQuery) || phone.includes(searchQuery);
            });

            if (filtered.length === 0) {
                listEl.innerHTML = `<div class="p-10 text-center text-[#8696a0] text-sm">No matching contacts found</div>`;
                return;
            }

            filtered.forEach(c => {
                const displayName = c.saved_name || c.name || c.phone;
                const displayAvatar = c.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(displayName)}&background=2a3942&color=fff`;

                const itemHtml = `
                    <div class="flex items-center justify-between p-3 rounded-lg hover:bg-[#202c33] transition-colors border-b border-gray-800/20">
                        <div class="flex items-center gap-4 flex-1 min-w-0">
                            <div class="w-11 h-11 rounded-full overflow-hidden bg-[#2a3942] shrink-0">
                                <img src="${displayAvatar}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex flex-col min-w-0">
                                <span class="text-[#e9edef] text-[16px] font-normal truncate">${displayName}</span>
                                <span class="text-[#8696a0] text-[13px] truncate mt-0.5">${c.phone || ''}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 text-[#00a884] shrink-0">
                            <button onclick="window.closeNewCallModal(); window.startVideoCall('${c.id}', '${displayName.replace(/'/g, "\\'")}', '${displayAvatar}')" class="hover:bg-[#202c33] p-2 rounded-full transition-colors" title="Video call">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"></path></svg>
                            </button>
                            <button onclick="window.closeNewCallModal(); window.startVoiceCall('${c.id}', '${displayName.replace(/'/g, "\\'")}', '${displayAvatar}')" class="hover:bg-[#202c33] p-2 rounded-full transition-colors" title="Voice call">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z"></path></svg>
                            </button>
                        </div>
                    </div>`;
                listEl.insertAdjacentHTML('beforeend', itemHtml);
            });
        };

        window.closeNewGroupCallModal = function() {
            const modal = document.getElementById('new_group_call_modal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        };

        window.renderGroupCallContacts = function() {
            const listEl = document.getElementById('group_call_contacts_list');
            if (!listEl) return;

            const searchQuery = document.getElementById('group_call_search_input').value.toLowerCase().trim();
            listEl.innerHTML = '';

            if (!window.allContacts || window.allContacts.length === 0) {
                listEl.innerHTML = `<div class="p-10 text-center text-[#8696a0] text-sm">No contacts available</div>`;
                return;
            }

            const filtered = window.allContacts.filter(c => {
                // Exclude current user & Meta AI
                if (String(c.id) === String(window.myUserId) || c.id === 'meta_ai') return false;

                const name = (c.saved_name || c.name || c.phone || '').toLowerCase();
                const phone = (c.phone || '').toLowerCase();
                return name.includes(searchQuery) || phone.includes(searchQuery);
            });

            if (filtered.length === 0) {
                listEl.innerHTML = `<div class="p-10 text-center text-[#8696a0] text-sm">No matching contacts</div>`;
                return;
            }

            filtered.forEach(c => {
                const isSelected = window.selectedGroupCallUsers.has(String(c.id));
                const displayName = c.saved_name || c.name || c.phone;
                const displayAvatar = c.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(displayName)}&background=2a3942&color=fff`;

                const itemHtml = `
                    <div onclick="window.toggleGroupCallUser('${c.id}')"
                        class="flex items-center gap-4 px-6 py-3 hover:bg-[#202c33] cursor-pointer transition-colors border-b border-gray-800/30">
                        <!-- Checkbox -->
                        <div class="relative flex items-center shrink-0">
                            <input type="checkbox" ${isSelected ? 'checked' : ''}
                                onclick="event.stopPropagation(); window.toggleGroupCallUser('${c.id}')"
                                class="w-5 h-5 rounded border-[#313d45] bg-transparent text-[#00a884] focus:ring-0 focus:ring-offset-0 cursor-pointer">
                        </div>
                        <!-- Avatar -->
                        <div class="w-10 h-10 rounded-full overflow-hidden bg-[#2a3942] shrink-0">
                            <img src="${displayAvatar}" class="w-full h-full object-cover">
                        </div>
                        <!-- Name / Phone -->
                        <div class="flex-1 min-w-0">
                            <div class="text-[#e9edef] text-[15px] font-medium truncate">${displayName}</div>
                            <div class="text-[#8696a0] text-xs truncate">${c.phone || ''}</div>
                        </div>
                    </div>`;
                listEl.insertAdjacentHTML('beforeend', itemHtml);
            });
        };

        window.toggleGroupCallUser = function(userId) {
            const uidStr = String(userId);
            if (window.selectedGroupCallUsers.has(uidStr)) {
                window.selectedGroupCallUsers.delete(uidStr);
            } else {
                window.selectedGroupCallUsers.add(uidStr);
            }
            window.renderGroupCallContacts();
            window.renderGroupCallChips();
        };

        window.renderGroupCallChips = function() {
            const container = document.getElementById('group_call_selected_chips');
            if (!container) return;

            container.innerHTML = '';

            if (window.selectedGroupCallUsers.size === 0) {
                container.classList.add('hidden');
                return;
            }

            container.classList.remove('hidden');

            window.selectedGroupCallUsers.forEach(uid => {
                const contact = window.allContacts.find(c => String(c.id) === String(uid));
                if (!contact) return;

                const displayName = contact.saved_name || contact.name || contact.phone;
                const displayAvatar = contact.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(displayName)}&background=2a3942&color=fff`;

                const chipHtml = `
                    <div class="flex items-center gap-1.5 bg-[#202c33] pl-1.5 pr-2.5 py-1 rounded-full text-white text-sm shrink-0 border border-white/5">
                        <img src="${displayAvatar}" class="w-6 h-6 rounded-full object-cover">
                        <span class="max-w-[80px] truncate text-[#e9edef]">${displayName}</span>
                        <button onclick="window.toggleGroupCallUser('${uid}')" class="text-[#8696a0] hover:text-white transition-colors focus:outline-none ml-0.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>`;
                container.insertAdjacentHTML('beforeend', chipHtml);
            });
        };

        window.startGroupCallFromModal = function(type) {
            if (window.selectedGroupCallUsers.size === 0) {
                alert('Please select at least one contact.');
                return;
            }

            const participants = Array.from(window.selectedGroupCallUsers);
            const callGroupId = 'gc_' + window.myUserId + '_' + Date.now();

            // Generate query parameters
            const params = new URLSearchParams({
                name: 'Group Call',
                avatar: '',
                role: 'caller',
                group_id: callGroupId,
                participants: participants.join(',')
            });

            // Redirect to group voice/video call page
            const callPath = type === 'video' ? '/chat/groups/video-call?' : '/chat/groups/voice-call?';
            window.location.href = callPath + params.toString();
        };

        // --- NEW CALL LINK MODAL HANDLERS ---
        window.currentCallLinkType = 'video';
        window.currentCallLinkApproval = false;
        window.currentCallLinkId = '';

        window.openNewCallLinkModal = function() {
            // Close call dropdowns
            const callDropdown = document.getElementById('call_dropdown');
            if (callDropdown) {
                callDropdown.classList.remove('show');
                setTimeout(() => {
                    callDropdown.style.display = 'none';
                    callDropdown.classList.add('hidden');
                }, 200);
            }

            // Set type to 'video' by default
            window.currentCallLinkType = 'video';
            window.currentCallLinkApproval = false;
            // Generate a random call ID
            window.currentCallLinkId = 'cl_' + Math.random().toString(36).substr(2, 9);

            // Initialize target recipient
            window.shareTargetChatId = window.currentChatId || '';
            window.shareTargetChatName = window.activeChatName || 'Select Chat';
            const targetLabel = document.getElementById('call_link_target_name');
            if (targetLabel) targetLabel.textContent = window.shareTargetChatName;

            // Update UI elements
            window.updateCallLinkUI();

            // Show modal
            document.getElementById('new_call_link_modal').classList.remove('hidden');
        };

        window.closeNewCallLinkModal = function() {
            document.getElementById('new_call_link_modal').classList.add('hidden');
            // Hide dropdown if open
            document.getElementById('call_link_type_menu').classList.add('hidden');
        };

        window.toggleCallLinkTypeDropdown = function(event) {
            event.stopPropagation();
            const menu = document.getElementById('call_link_type_menu');
            menu.classList.toggle('hidden');
        };

        window.setCallLinkType = function(type) {
            window.currentCallLinkType = type;
            document.getElementById('call_link_type_menu').classList.add('hidden');
            window.updateCallLinkUI();
        };

        window.toggleCallLinkApproval = function() {
            window.currentCallLinkApproval = !window.currentCallLinkApproval;
            const toggle = document.getElementById('call_link_approval_toggle');
            const circle = document.getElementById('call_link_approval_circle');

            if (window.currentCallLinkApproval) {
                toggle.classList.remove('bg-[#2f3b43]');
                toggle.classList.add('bg-[#00a884]');
                circle.classList.remove('translate-x-0', 'bg-[#8696a0]');
                circle.classList.add('translate-x-5', 'bg-[#111b21]');
            } else {
                toggle.classList.remove('bg-[#00a884]');
                toggle.classList.add('bg-[#2f3b43]');
                circle.classList.remove('translate-x-5', 'bg-[#111b21]');
                circle.classList.add('translate-x-0', 'bg-[#8696a0]');
            }
            window.updateCallLinkUI();
        };

        window.updateCallLinkUI = function() {
            const type = window.currentCallLinkType;
            const label = document.getElementById('call_link_type_label');
            const iconContainer = document.getElementById('call_link_type_icon');

            const videoCheck = document.getElementById('call_link_type_check_video');
            const voiceCheck = document.getElementById('call_link_type_check_voice');

            if (type === 'video') {
                label.textContent = 'Video';
                iconContainer.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>`;
                videoCheck.classList.remove('hidden');
                voiceCheck.classList.add('hidden');
            } else {
                label.textContent = 'Voice';
                iconContainer.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>`;
                videoCheck.classList.add('hidden');
                voiceCheck.classList.remove('hidden');
            }

            // Construct Link
            const approvalParam = window.currentCallLinkApproval ? '&require_approval=true' : '';
            const link = `${window.location.origin}/chat/groups/${type}-call?group_call_id=${window.currentCallLinkId}&name=${type === 'video' ? 'Video+Call' : 'Voice+Call'}${approvalParam}`;
            const el = document.getElementById('call_link_input');
            if (el.tagName === 'INPUT') el.value = link; else el.textContent = link;
        };

        window.copyCallLink = function() {
            const el = document.getElementById('call_link_input');
            const linkText = el.value || el.textContent;
            navigator.clipboard.writeText(linkText).then(() => {
                const normalIcon = document.getElementById('copy_icon_normal');
                const successIcon = document.getElementById('copy_icon_success');
                normalIcon.classList.add('hidden');
                successIcon.classList.remove('hidden');

                // Show a toast
                if (window.showToast) {
                    window.showToast('Copied', 'Call link copied to clipboard!');
                } else {
                    alert('Call link copied to clipboard!');
                }

                setTimeout(() => {
                    normalIcon.classList.remove('hidden');
                    successIcon.classList.add('hidden');
                }, 2000);
            });
        };

        window.joinCallFromLink = function() {
            const el = document.getElementById('call_link_input');
            window.open(el.value || el.textContent, '_blank');
        };

        window.sendCallLinkToChat = function() {
            const el = document.getElementById('call_link_input');
            const linkText = el.value || el.textContent;
            const targetChatId = window.shareTargetChatId;

            if (!targetChatId) {
                alert('Please select a target chat first.');
                return;
            }

            // Temporarily swap currentChatId to send to the chosen recipient
            const originalChatId = window.currentChatId;
            window.currentChatId = targetChatId;

            if (typeof window.emitMessage === 'function') {
                window.emitMessage(linkText);
                window.closeNewCallLinkModal();
                if (window.showToast) {
                    window.showToast('Call Link Sent', 'Call link sent successfully!');
                }
            } else {
                alert('Cannot send call link.');
            }

            // Restore original active chat
            window.currentChatId = originalChatId;
        };

        // Click outside type menu closes it
        window.addEventListener('click', function(e) {
            const menu = document.getElementById('call_link_type_menu');
            const btn = document.getElementById('call_link_type_btn');
            if (menu && !menu.classList.contains('hidden') && btn && !btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

        // --- SCHEDULE CALL MODAL HANDLERS ---
        window.currentScheduleCallType = 'video';
        window.currentScheduleApproval = false;
        window.isEndTimeRemoved = false;

        window.openScheduleCallModal = function() {
            // Close dropdowns
            const callDropdown = document.getElementById('call_dropdown');
            if (callDropdown) {
                callDropdown.classList.remove('show');
                setTimeout(() => {
                    callDropdown.style.display = 'none';
                    callDropdown.classList.add('hidden');
                }, 200);
            }
            const groupCallDropdown = document.getElementById('group_call_dropdown');
            if (groupCallDropdown) {
                groupCallDropdown.classList.remove('show');
                setTimeout(() => {
                    groupCallDropdown.style.display = 'none';
                    groupCallDropdown.classList.add('hidden');
                }, 200);
            }

            // Set default call name
            const currentUserName = "{{ auth()->user()->name ?? 'User' }}";
            document.getElementById('schedule_call_name').value = `${currentUserName}'s call`;
            document.getElementById('schedule_call_desc').value = '';

            // Set default dates & times
            const now = new Date();

            // Format YYYY-MM-DD
            const yyyy = now.getFullYear();
            const mm = String(now.getMonth() + 1).padStart(2, '0');
            const dd = String(now.getDate()).padStart(2, '0');
            const defaultDate = `${yyyy}-${mm}-${dd}`;
            document.getElementById('schedule_start_date').value = defaultDate;
            document.getElementById('schedule_end_date').value = defaultDate;

            // Format HH:MM (start call 30 mins from now, rounded to 5 mins)
            let start = new Date(now.getTime() + 30 * 60 * 1000);
            let minutes = start.getMinutes();
            minutes = Math.ceil(minutes / 5) * 5;
            if (minutes >= 60) {
                start.setHours(start.getHours() + 1);
                minutes = 0;
            }
            start.setMinutes(minutes);

            const startHour = String(start.getHours()).padStart(2, '0');
            const startMin = String(start.getMinutes()).padStart(2, '0');
            document.getElementById('schedule_start_time').value = `${startHour}:${startMin}`;

            // End call 30 mins after start
            let end = new Date(start.getTime() + 30 * 60 * 1000);
            const endHour = String(end.getHours()).padStart(2, '0');
            const endMin = String(end.getMinutes()).padStart(2, '0');
            document.getElementById('schedule_end_time').value = `${endHour}:${endMin}`;

            // Reset dropdown & toggle state
            window.currentScheduleCallType = 'video';
            window.currentScheduleApproval = false;
            window.isEndTimeRemoved = false;
            window.updateScheduleCallTypeUI();

            // Reset approval UI
            const toggle = document.getElementById('schedule_approval_toggle');
            const circle = document.getElementById('schedule_approval_circle');
            toggle.classList.remove('bg-[#00a884]');
            toggle.classList.add('bg-[#2f3b43]');
            circle.classList.remove('translate-x-5', 'bg-[#111b21]');
            circle.classList.add('translate-x-0', 'bg-[#8696a0]');

            // Reset End Time container & button
            document.getElementById('schedule_end_datetime_container').classList.remove('hidden');
            document.getElementById('schedule_toggle_endtime_text').textContent = 'Remove end time';
            document.getElementById('schedule_toggle_endtime_btn').querySelector('svg').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>';

            // Hide Emojis trays
            document.getElementById('schedule_name_emoji_tray').classList.add('hidden');
            document.getElementById('schedule_desc_emoji_tray').classList.add('hidden');

            // Initialize target recipient
            window.shareTargetChatId = window.currentChatId || '';
            window.shareTargetChatName = window.activeChatName || 'Select Chat';
            const targetLabel = document.getElementById('schedule_target_name');
            if (targetLabel) targetLabel.textContent = window.shareTargetChatName;

            // Show Modal
            document.getElementById('schedule_call_modal').classList.remove('hidden');
        };

        window.closeScheduleCallModal = function() {
            document.getElementById('schedule_call_modal').classList.add('hidden');
        };

        window.toggleScheduleEndTime = function() {
            window.isEndTimeRemoved = !window.isEndTimeRemoved;
            const container = document.getElementById('schedule_end_datetime_container');
            const text = document.getElementById('schedule_toggle_endtime_text');
            const btn = document.getElementById('schedule_toggle_endtime_btn');

            if (window.isEndTimeRemoved) {
                container.classList.add('hidden');
                text.textContent = 'Add end time';
                btn.querySelector('svg').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>';
            } else {
                container.classList.remove('hidden');
                text.textContent = 'Remove end time';
                btn.querySelector('svg').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>';
            }
        };

        window.toggleScheduleCallTypeDropdown = function(event) {
            event.stopPropagation();
            document.getElementById('schedule_call_type_menu').classList.toggle('hidden');
        };

        window.setScheduleCallType = function(type) {
            window.currentScheduleCallType = type;
            document.getElementById('schedule_call_type_menu').classList.add('hidden');
            window.updateScheduleCallTypeUI();
        };

        window.updateScheduleCallTypeUI = function() {
            const type = window.currentScheduleCallType;
            const label = document.getElementById('schedule_call_type_label');
            const icon = document.getElementById('schedule_call_type_icon');

            if (type === 'video') {
                label.textContent = 'Video';
                icon.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>';
            } else {
                label.textContent = 'Voice';
                icon.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>';
            }
        };

        window.toggleScheduleApproval = function() {
            window.currentScheduleApproval = !window.currentScheduleApproval;
            const toggle = document.getElementById('schedule_approval_toggle');
            const circle = document.getElementById('schedule_approval_circle');

            if (window.currentScheduleApproval) {
                toggle.classList.remove('bg-[#2f3b43]');
                toggle.classList.add('bg-[#00a884]');
                circle.classList.remove('translate-x-0', 'bg-[#8696a0]');
                circle.classList.add('translate-x-5', 'bg-[#111b21]');
            } else {
                toggle.classList.remove('bg-[#00a884]');
                toggle.classList.add('bg-[#2f3b43]');
                circle.classList.remove('translate-x-5', 'bg-[#111b21]');
                circle.classList.add('translate-x-0', 'bg-[#8696a0]');
            }
        };

        window.toggleScheduleCallNameEmoji = function() {
            document.getElementById('schedule_name_emoji_tray').classList.toggle('hidden');
            document.getElementById('schedule_desc_emoji_tray').classList.add('hidden');
        };

        window.toggleScheduleCallDescEmoji = function() {
            document.getElementById('schedule_desc_emoji_tray').classList.toggle('hidden');
            document.getElementById('schedule_name_emoji_tray').classList.add('hidden');
        };

        window.insertScheduleNameEmoji = function(emoji) {
            const input = document.getElementById('schedule_call_name');
            input.value += emoji;
            input.focus();
        };

        window.insertScheduleDescEmoji = function(emoji) {
            const input = document.getElementById('schedule_call_desc');
            input.value += emoji;
            input.focus();
        };

        window.submitScheduledCall = async function() {
            const targetChatId = window.shareTargetChatId;
            if (!targetChatId) {
                alert('Please select a target chat to send this scheduled call invitation to.');
                return;
            }

            const callName = document.getElementById('schedule_call_name').value.trim();
            const desc = document.getElementById('schedule_call_desc').value.trim();
            const startDateVal = document.getElementById('schedule_start_date').value;
            const startTimeVal = document.getElementById('schedule_start_time').value;

            if (!callName) {
                alert('Please enter a call name.');
                return;
            }
            if (!startDateVal || !startTimeVal) {
                alert('Please select start date and time.');
                return;
            }

            const startDateTime = new Date(`${startDateVal}T${startTimeVal}`);
            if (isNaN(startDateTime.getTime())) {
                alert('Invalid start date or time.');
                return;
            }

            let endDateTime = null;
            if (!window.isEndTimeRemoved) {
                const endDateVal = document.getElementById('schedule_end_date').value;
                const endTimeVal = document.getElementById('schedule_end_time').value;
                if (!endDateVal || !endTimeVal) {
                    alert('Please select end date and time or click "Remove end time".');
                    return;
                }
                endDateTime = new Date(`${endDateVal}T${endTimeVal}`);
                if (isNaN(endDateTime.getTime())) {
                    alert('Invalid end date or time.');
                    return;
                }
                if (endDateTime <= startDateTime) {
                    alert('End date/time must be after start date/time.');
                    return;
                }
            }

            // Constraints check: not more than 1 year in future
            const oneYearLater = new Date();
            oneYearLater.setFullYear(oneYearLater.getFullYear() + 1);
            if (startDateTime > oneYearLater) {
                alert('Call cannot be scheduled more than one year in the future.');
                return;
            }

            // Generate unique group call id
            const callId = 'sc_' + Math.random().toString(36).substr(2, 9);
            const startTimestamp = Math.floor(startDateTime.getTime() / 1000);
            const endTimestamp = endDateTime ? Math.floor(endDateTime.getTime() / 1000) : null;

            // Prepare message data
            const msgData = {
                type: 'scheduled_call',
                sender_id: window.myUserId,
                time: Math.floor(Date.now() / 1000),
                status: 'sent',
                call_name: callName,
                description: desc,
                start_time: startTimestamp,
                end_time: endTimestamp,
                call_type: window.currentScheduleCallType,
                require_approval: window.currentScheduleApproval,
                group_call_id: callId
            };

            // Send via POST request to Laravel backend which routes to chats or groups accordingly
            const fd = new FormData();
            fd.append('chat_id', targetChatId);
            fd.append('type', 'scheduled_call');
            fd.append('call_name', callName);
            fd.append('description', desc);
            fd.append('start_time', startTimestamp);
            if (endTimestamp) fd.append('end_time', endTimestamp);
            fd.append('call_type', window.currentScheduleCallType);
            fd.append('require_approval', window.currentScheduleApproval);
            fd.append('group_call_id', callId);

            // Close modal and show toast immediately for a responsive, optimistic UI experience
            window.closeScheduleCallModal();
            if (window.showToast) window.showToast('Call Scheduled', 'Scheduled call posted successfully!');

            try {
                fetch('/send', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': window.csrf || document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: fd
                }).then(async res => {
                    const resData = await res.json();
                    if (!resData.status) {
                        console.error('Failed to schedule call:', resData);
                    }
                }).catch(e => {
                    console.error('Schedule Call Error:', e);
                });
            } catch (e) {
                console.error('Schedule Call Error:', e);
            }
        };

        // Close dropdown menus when clicking outside
        window.addEventListener('click', function(e) {
            const menu = document.getElementById('schedule_call_type_menu');
            const btn = document.getElementById('schedule_call_type_btn');
            if (menu && !menu.classList.contains('hidden') && btn && !btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

        // --- DIALER MODAL HANDLERS ---
        window.openDialerModal = function() {
            // Close call dropdowns if open
            const callDropdown = document.getElementById('call_dropdown');
            if (callDropdown) {
                callDropdown.style.display = 'none';
                callDropdown.classList.remove('show');
            }
            const groupCallDropdown = document.getElementById('group_call_dropdown');
            if (groupCallDropdown) {
                groupCallDropdown.style.display = 'none';
                groupCallDropdown.classList.remove('show');
            }

            // Reset dialer input
            const input = document.getElementById('dialer_number_input');
            if (input) {
                input.value = '';
            }

            // Show dialer modal
            const modal = document.getElementById('dialer_modal');
            if (modal) {
                modal.classList.remove('hidden');
            }
        };

        window.closeDialerModal = function() {
            const modal = document.getElementById('dialer_modal');
            if (modal) {
                modal.classList.add('hidden');
            }
        };

        window.pressDialKey = function(key) {
            const input = document.getElementById('dialer_number_input');
            if (!input) return;

            let val = input.value;
            if (key === 'backspace') {
                input.value = val.slice(0, -1);
            } else {
                // Limit phone number input to a reasonable length
                if (val.length < 20) {
                    input.value = val + key;
                }
            }
        };

        window.submitDialerCall = async function(callType) {
            const input = document.getElementById('dialer_number_input');
            if (!input) return;

            const phone = input.value.trim();
            if (!phone) {
                if (window.showToast) {
                    window.showToast('Call Error', 'Please enter a phone number to call.');
                } else {
                    alert('Please enter a phone number to call.');
                }
                return;
            }

            if (window.showToast) {
                window.showToast('Checking number', 'Checking if number is on WhatsApp...');
            }

            try {
                const response = await fetch('/api/check-phone', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': window.csrf || document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({ phone: phone })
                });

                const data = await response.json();
                if (data.status && data.user) {
                    // Number is valid and user exists
                    window.closeDialerModal();
                    const targetUser = data.user;
                    if (callType === 'video') {
                        window.startVideoCall(targetUser.id, targetUser.name, targetUser.avatar);
                    } else {
                        window.startVoiceCall(targetUser.id, targetUser.name, targetUser.avatar);
                    }
                } else {
                    // Number not on WhatsApp
                    if (window.showToast) {
                        window.showToast('Call Failed', data.message || 'This phone number is not on WhatsApp.');
                    } else {
                        alert(data.message || 'This phone number is not on WhatsApp.');
                    }
                }
            } catch (error) {
                console.error('Dialer verification error:', error);
                if (window.showToast) {
                    window.showToast('Network Error', 'Could not verify the phone number.');
                } else {
                    alert('Could not verify the phone number.');
                }
            }
        };

        // --- SHARE SELECTOR HANDLERS ---
        window.shareSelectorMode = null; // 'call_link' or 'schedule'
        window.shareTargetChatId = '';
        window.shareTargetChatName = '';

        window.openShareSelector = function(mode) {
            window.shareSelectorMode = mode;

            // Show modal
            const modal = document.getElementById('share_selector_modal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            // Clear search
            const search = document.getElementById('share_search_input');
            if (search) search.value = '';

            // Render list
            window.renderShareSelectorList();
        };

        window.closeShareSelector = function() {
            const modal = document.getElementById('share_selector_modal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        };

        window.renderShareSelectorList = function() {
            const listEl = document.getElementById('share_chats_list');
            if (!listEl) return;

            listEl.innerHTML = '';
            const q = (document.getElementById('share_search_input')?.value || '').toLowerCase().trim();

            let items = [];

            // 1. Add all contacts from window.allContacts
            if (window.allContacts) {
                window.allContacts.forEach(c => {
                    if (String(c.id) === String(window.myUserId) || c.id === 'meta_ai') return;

                    const minId = Math.min(window.myUserId, c.id);
                    const maxId = Math.max(window.myUserId, c.id);
                    const chatId = `chat_${minId}_${maxId}`;

                    items.push({
                        id: chatId,
                        name: c.saved_name || c.name || c.phone,
                        avatar: c.avatar || '',
                        phone: c.phone || ''
                    });
                });
            }

            // 2. Add all groups from sidebar
            const groupNodes = document.querySelectorAll('#user_list_container [id^="group_sidebar_"]');
            groupNodes.forEach(node => {
                const groupId = node.id.replace('group_sidebar_', '');
                const groupName = node.getAttribute('data-name') || node.querySelector('h4')?.textContent?.trim() || 'Group';
                const groupAvatar = node.getAttribute('data-avatar') || node.querySelector('img')?.src || '';

                items.push({
                    id: 'group_' + groupId,
                    name: groupName,
                    avatar: groupAvatar,
                    phone: 'Group Chat'
                });
            });

            // Filter items based on search query
            const filtered = items.filter(item => {
                return item.name.toLowerCase().includes(q) || item.phone.toLowerCase().includes(q);
            });

            if (filtered.length === 0) {
                listEl.innerHTML = `<div class="p-10 text-center text-[#8696a0] text-sm">No matching chats found</div>`;
                return;
            }

            filtered.forEach(item => {
                const displayName = item.name;
                const displayAvatar = item.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(displayName)}&background=2a3942&color=fff`;

                const itemHtml = `
                    <div onclick="window.selectShareTarget('${item.id}', '${displayName.replace(/'/g, "\\'")}')"
                        class="flex items-center gap-4 px-6 py-3 hover:bg-[#202c33] cursor-pointer transition-colors border-b border-gray-800/30">
                        <div class="w-10 h-10 rounded-full overflow-hidden bg-[#2a3942] shrink-0">
                            <img src="${displayAvatar}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-[#e9edef] text-[15px] font-medium truncate">${displayName}</div>
                            <div class="text-[#8696a0] text-xs truncate">${item.phone || ''}</div>
                        </div>
                    </div>`;
                listEl.insertAdjacentHTML('beforeend', itemHtml);
            });
        };

        window.selectShareTarget = function(chatId, chatName) {
            window.shareTargetChatId = chatId;
            window.shareTargetChatName = chatName;

            // Update UI elements in active modals
            if (window.shareSelectorMode === 'call_link') {
                const targetLabel = document.getElementById('call_link_target_name');
                if (targetLabel) targetLabel.textContent = chatName;
            } else if (window.shareSelectorMode === 'schedule') {
                const targetLabel = document.getElementById('schedule_target_name');
                if (targetLabel) targetLabel.textContent = chatName;
            }

            window.closeShareSelector();
        };

        // Keyboard support for dialer modal
        document.addEventListener('keydown', function(e) {
            const dialerModal = document.getElementById('dialer_modal');
            if (!dialerModal || dialerModal.classList.contains('hidden')) {
                return; // Dialer is not open
            }

            const allowedKeys = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '*', '#', '+'];
            if (allowedKeys.includes(e.key)) {
                e.preventDefault();
                window.pressDialKey(e.key);
            } else if (e.key === 'Backspace') {
                e.preventDefault();
                window.pressDialKey('backspace');
            } else if (e.key === 'Escape') {
                e.preventDefault();
                window.closeDialerModal();
            } else if (e.key === 'Enter') {
                e.preventDefault();
                window.submitDialerCall('voice'); // default to voice call on Enter key
            }
        });

        window.loadStarredMessages();

        // Communities JS logic has been migrated to communities_panel.blade.php

    </script>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    @include('chat.app_lock')
    @include('chat.add_to_list_modal')

    <!-- New Call Modal -->
    <div id="new_call_modal"
        class="hidden fixed inset-0 z-[160] bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="w-full max-w-[400px] bg-[#111b21] rounded-2xl flex flex-col h-[550px] border border-white/5 shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200 font-['Inter']">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 bg-[#202c33] border-b border-white/5 shrink-0">
                <h3 class="text-[#e9edef] text-[19px] font-semibold">New call</h3>
                <button onclick="window.closeNewCallModal()" class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Search Area -->
            <div class="p-3 bg-[#111b21] border-b border-white/5 shrink-0">
                <div class="bg-[#202c33] flex items-center gap-3 px-4 py-2 rounded-lg border border-transparent focus-within:border-[#00a884] transition-all">
                    <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" id="new_call_search_input" oninput="window.renderNewCallContacts()"
                        placeholder="Search name or number"
                        class="bg-transparent border-none text-[#e9edef] text-sm focus:ring-0 placeholder-[#8696a0] p-0 w-full outline-none">
                </div>
            </div>

            <!-- Contacts List -->
            <div id="new_call_contacts_list" class="flex-1 overflow-y-auto custom-scrollbar p-2 flex flex-col gap-1">
                <!-- Contacts will be populated here -->
            </div>
        </div>
    </div>

    <!-- New Group Call Modal -->
    <div id="new_group_call_modal"
        class="hidden fixed inset-0 z-[100] bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="w-full max-w-[420px] bg-[#111b21] rounded-2xl flex flex-col h-[600px] border border-white/5 shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200">
            <!-- Header -->
            <div class="flex items-center gap-6 px-6 py-4 bg-[#202c33] border-b border-white/5 shrink-0">
                <button onclick="window.closeNewGroupCallModal()" class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <h3 class="text-[#e9edef] text-[19px] font-semibold">New group call</h3>
            </div>

            <!-- Search Area -->
            <div class="p-3 bg-[#111b21] border-b border-white/5 shrink-0">
                <div class="bg-[#202c33] flex items-center gap-3 px-4 py-2 rounded-lg border border-transparent focus-within:border-[#00a884] transition-all">
                    <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" id="group_call_search_input" oninput="window.renderGroupCallContacts()"
                        placeholder="Search name or number"
                        class="bg-transparent border-none text-[#e9edef] text-sm focus:ring-0 placeholder-[#8696a0] p-0 w-full outline-none">
                </div>
            </div>

            <!-- Selected Chips Area -->
            <div id="group_call_selected_chips"
                class="hidden flex items-center gap-2 px-6 py-3 bg-[#111b21] border-b border-white/5 overflow-x-auto custom-scrollbar shrink-0">
                <!-- Selected user chips will be populated here -->
            </div>

            <!-- Contacts List -->
            <div id="group_call_contacts_list" class="flex-1 overflow-y-auto custom-scrollbar">
                <!-- Contacts will be populated here -->
            </div>

            <!-- Bottom Floating Action Bar -->
            <div class="p-4 bg-[#202c33] border-t border-white/5 shrink-0 flex gap-3 justify-end">
                <button onclick="window.startGroupCallFromModal('voice')"
                    class="bg-[#00a884] hover:bg-[#06cf9c] text-[#111b21] px-5 py-2.5 rounded-full flex items-center gap-2 font-bold transition-all active:scale-95 text-sm shrink-0">
                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z"></path>
                    </svg>
                    Voice
                </button>
                <button onclick="window.startGroupCallFromModal('video')"
                    class="bg-[#00a884] hover:bg-[#06cf9c] text-[#111b21] px-5 py-2.5 rounded-full flex items-center gap-2 font-bold transition-all active:scale-95 text-sm shrink-0">
                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"></path>
                    </svg>
                    Video
                </button>
            </div>
        </div>
    </div>

    <!-- Dialer / Call a Number Modal -->
    <div id="dialer_modal"
        class="hidden fixed inset-0 z-[160] bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="w-full max-w-[360px] bg-[#111b21] rounded-3xl flex flex-col border border-white/5 shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200 font-['Inter']">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 bg-[#202c33] border-b border-white/5 shrink-0">
                <h3 class="text-[#e9edef] text-[18px] font-semibold">Call a number</h3>
                <button onclick="window.closeDialerModal()" class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Number Display -->
            <div class="p-6 bg-[#111b21] flex flex-col items-center shrink-0">
                <input type="text" id="dialer_number_input" readonly placeholder="Enter number"
                    class="bg-transparent border-none text-[#e9edef] text-center text-3xl font-light w-full focus:ring-0 placeholder-[#8696a0] p-0 outline-none select-all tracking-wide">
            </div>

            <!-- Dialpad Keys Grid -->
            <div class="px-6 pb-6 bg-[#111b21] flex flex-col items-center">
                <div class="grid grid-cols-3 gap-x-6 gap-y-4 max-w-[280px] w-full">
                    <!-- Key buttons -->
                    <button onclick="window.pressDialKey('1')" class="w-14 h-14 rounded-full bg-[#202c33] hover:bg-[#2a3942] active:bg-[#3b4a54] text-[#e9edef] text-2xl font-normal flex flex-col items-center justify-center transition-all focus:outline-none shadow-sm">
                        <span>1</span>
                        <span class="text-[9px] text-[#8696a0] uppercase -mt-1 font-semibold">&nbsp;</span>
                    </button>
                    <button onclick="window.pressDialKey('2')" class="w-14 h-14 rounded-full bg-[#202c33] hover:bg-[#2a3942] active:bg-[#3b4a54] text-[#e9edef] text-2xl font-normal flex flex-col items-center justify-center transition-all focus:outline-none shadow-sm">
                        <span>2</span>
                        <span class="text-[9px] text-[#8696a0] uppercase -mt-1 font-semibold">abc</span>
                    </button>
                    <button onclick="window.pressDialKey('3')" class="w-14 h-14 rounded-full bg-[#202c33] hover:bg-[#2a3942] active:bg-[#3b4a54] text-[#e9edef] text-2xl font-normal flex flex-col items-center justify-center transition-all focus:outline-none shadow-sm">
                        <span>3</span>
                        <span class="text-[9px] text-[#8696a0] uppercase -mt-1 font-semibold">def</span>
                    </button>
                    <button onclick="window.pressDialKey('4')" class="w-14 h-14 rounded-full bg-[#202c33] hover:bg-[#2a3942] active:bg-[#3b4a54] text-[#e9edef] text-2xl font-normal flex flex-col items-center justify-center transition-all focus:outline-none shadow-sm">
                        <span>4</span>
                        <span class="text-[9px] text-[#8696a0] uppercase -mt-1 font-semibold">ghi</span>
                    </button>
                    <button onclick="window.pressDialKey('5')" class="w-14 h-14 rounded-full bg-[#202c33] hover:bg-[#2a3942] active:bg-[#3b4a54] text-[#e9edef] text-2xl font-normal flex flex-col items-center justify-center transition-all focus:outline-none shadow-sm">
                        <span>5</span>
                        <span class="text-[9px] text-[#8696a0] uppercase -mt-1 font-semibold">jkl</span>
                    </button>
                    <button onclick="window.pressDialKey('6')" class="w-14 h-14 rounded-full bg-[#202c33] hover:bg-[#2a3942] active:bg-[#3b4a54] text-[#e9edef] text-2xl font-normal flex flex-col items-center justify-center transition-all focus:outline-none shadow-sm">
                        <span>6</span>
                        <span class="text-[9px] text-[#8696a0] uppercase -mt-1 font-semibold">mno</span>
                    </button>
                    <button onclick="window.pressDialKey('7')" class="w-14 h-14 rounded-full bg-[#202c33] hover:bg-[#2a3942] active:bg-[#3b4a54] text-[#e9edef] text-2xl font-normal flex flex-col items-center justify-center transition-all focus:outline-none shadow-sm">
                        <span>7</span>
                        <span class="text-[9px] text-[#8696a0] uppercase -mt-1 font-semibold">pqrs</span>
                    </button>
                    <button onclick="window.pressDialKey('8')" class="w-14 h-14 rounded-full bg-[#202c33] hover:bg-[#2a3942] active:bg-[#3b4a54] text-[#e9edef] text-2xl font-normal flex flex-col items-center justify-center transition-all focus:outline-none shadow-sm">
                        <span>8</span>
                        <span class="text-[9px] text-[#8696a0] uppercase -mt-1 font-semibold">tuv</span>
                    </button>
                    <button onclick="window.pressDialKey('9')" class="w-14 h-14 rounded-full bg-[#202c33] hover:bg-[#2a3942] active:bg-[#3b4a54] text-[#e9edef] text-2xl font-normal flex flex-col items-center justify-center transition-all focus:outline-none shadow-sm">
                        <span>9</span>
                        <span class="text-[9px] text-[#8696a0] uppercase -mt-1 font-semibold">wxyz</span>
                    </button>
                    <button onclick="window.pressDialKey('*')" class="w-14 h-14 rounded-full bg-[#202c33] hover:bg-[#2a3942] active:bg-[#3b4a54] text-[#e9edef] text-2xl font-normal flex items-center justify-center transition-all focus:outline-none shadow-sm">
                        *
                    </button>
                    <button onclick="window.pressDialKey('0')" class="w-14 h-14 rounded-full bg-[#202c33] hover:bg-[#2a3942] active:bg-[#3b4a54] text-[#e9edef] text-2xl font-normal flex flex-col items-center justify-center transition-all focus:outline-none shadow-sm">
                        <span>0</span>
                        <span class="text-[9px] text-[#808d96] -mt-1 font-semibold">+</span>
                    </button>
                    <button onclick="window.pressDialKey('#')" class="w-14 h-14 rounded-full bg-[#202c33] hover:bg-[#2a3942] active:bg-[#3b4a54] text-[#e9edef] text-2xl font-normal flex items-center justify-center transition-all focus:outline-none shadow-sm">
                        #
                    </button>
                </div>

                <!-- Call Actions & Backspace -->
                <div class="flex items-center justify-between gap-6 w-full max-w-[280px] mt-6 px-2">
                    <!-- Backspace -->
                    <button onclick="window.pressDialKey('backspace')" class="w-12 h-12 text-[#8696a0] hover:text-[#e9edef] flex items-center justify-center transition-colors focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414-6.414A2 2 0 0110.828 5H19a2 2 0 012 2v10a2 2 0 01-2 2h-8.172a2 2 0 01-1.414-.586L3 12z"></path>
                        </svg>
                    </button>

                    <!-- Green Call Buttons (Voice & Video) -->
                    <div class="flex gap-4">
                        <button onclick="window.submitDialerCall('voice')" class="w-14 h-14 rounded-full bg-[#00a884] hover:bg-[#06cf9c] active:scale-95 text-[#111b21] flex items-center justify-center shadow-lg transition-all focus:outline-none">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                <path d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z"></path>
                            </svg>
                        </button>
                        <button onclick="window.submitDialerCall('video')" class="w-14 h-14 rounded-full bg-[#00a884] hover:bg-[#06cf9c] active:scale-95 text-[#111b21] flex items-center justify-center shadow-lg transition-all focus:outline-none">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                <path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Call Modal -->
    <div id="schedule_call_modal"
        class="hidden fixed inset-0 z-[150] bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
        <style>
            /* Custom styling for inputs inside schedule call modal */
            #schedule_call_modal input[type="date"],
            #schedule_call_modal input[type="time"] {
                background-color: transparent !important;
                color: #e9edef !important;
                border: none !important;
                outline: none !important;
                box-shadow: none !important;
                padding-right: 32px !important;
                width: 100% !important;
                cursor: pointer;
                font-family: inherit;
                -webkit-appearance: none;
                appearance: none;
            }

            /* Remove native date/time indicator icons but keep picker functional */
            #schedule_call_modal input[type="date"]::-webkit-calendar-picker-indicator,
            #schedule_call_modal input[type="time"]::-webkit-calendar-picker-indicator {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                width: 100%;
                height: 100%;
                opacity: 0 !important;
                cursor: pointer;
                z-index: 10;
            }

            /* Clean textarea styling */
            #schedule_call_modal textarea {
                background-color: transparent !important;
                color: #e9edef !important;
                border: none !important;
                outline: none !important;
                box-shadow: none !important;
                width: 100% !important;
                font-family: inherit;
            }
        </style>
        <div class="w-full max-w-[420px] bg-[#111b21] rounded-2xl flex flex-col border border-white/5 shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 bg-[#202c33] border-b border-white/5 shrink-0">
                <div class="flex items-center gap-3">
                    <button onclick="window.closeScheduleCallModal()" class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <h3 class="text-[#e9edef] text-[20px] font-bold">Schedule call</h3>
                </div>
            </div>

            <!-- Body Content -->
            <div class="p-6 flex flex-col gap-5 overflow-y-auto max-h-[500px] custom-scrollbar">
                <!-- Call Name -->
                <div class="flex flex-col gap-1 w-full relative">
                    <label class="text-[#8696a0] text-xs font-normal">Call name</label>
                    <div class="relative w-full flex items-center border-b border-gray-600/30 py-1 focus-within:border-[#00a884] transition-all">
                        <input type="text" id="schedule_call_name" class="w-full bg-transparent border-none text-[#e9edef] text-[16px] focus:ring-0 p-0 pr-8 placeholder-gray-500 outline-none">
                        <button type="button" class="absolute right-0 text-[#8696a0] hover:text-white focus:outline-none" onclick="window.toggleScheduleCallNameEmoji()">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </button>
                    </div>
                    <!-- Popular Emojis Tray for Call Name -->
                    <div id="schedule_name_emoji_tray" class="hidden flex items-center gap-1.5 p-2 bg-[#202c33] rounded-lg mt-1 overflow-x-auto">
                        <span onclick="window.insertScheduleNameEmoji('😊')" class="text-xl cursor-pointer hover:scale-110 transition-transform">😊</span>
                        <span onclick="window.insertScheduleNameEmoji('😂')" class="text-xl cursor-pointer hover:scale-110 transition-transform">😂</span>
                        <span onclick="window.insertScheduleNameEmoji('😍')" class="text-xl cursor-pointer hover:scale-110 transition-transform">😍</span>
                        <span onclick="window.insertScheduleNameEmoji('👍')" class="text-xl cursor-pointer hover:scale-110 transition-transform">👍</span>
                        <span onclick="window.insertScheduleNameEmoji('❤️')" class="text-xl cursor-pointer hover:scale-110 transition-transform">❤️</span>
                        <span onclick="window.insertScheduleNameEmoji('🙌')" class="text-xl cursor-pointer hover:scale-110 transition-transform">🙌</span>
                        <span onclick="window.insertScheduleNameEmoji('😭')" class="text-xl cursor-pointer hover:scale-110 transition-transform">😭</span>
                        <span onclick="window.insertScheduleNameEmoji('🎉')" class="text-xl cursor-pointer hover:scale-110 transition-transform">🎉</span>
                        <span onclick="window.insertScheduleNameEmoji('🙏')" class="text-xl cursor-pointer hover:scale-110 transition-transform">🙏</span>
                        <span onclick="window.insertScheduleNameEmoji('🔥')" class="text-xl cursor-pointer hover:scale-110 transition-transform">🔥</span>
                    </div>
                </div>

                <!-- Description -->
                <div class="flex flex-col gap-1 w-full relative">
                    <label class="text-[#8696a0] text-xs font-normal">Description (optional)</label>
                    <div class="relative w-full flex items-center border border-gray-600/30 rounded-lg p-2.5 bg-[#202c33]/30 focus-within:border-[#00a884] transition-all">
                        <textarea id="schedule_call_desc" rows="2" class="w-full bg-transparent border-none text-[#e9edef] text-[15px] focus:ring-0 p-0 pr-8 placeholder-gray-500 outline-none resize-none" placeholder="Description (optional)"></textarea>
                        <button type="button" class="absolute top-2.5 right-2.5 text-[#8696a0] hover:text-white focus:outline-none" onclick="window.toggleScheduleCallDescEmoji()">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </button>
                    </div>
                    <!-- Popular Emojis Tray for Description -->
                    <div id="schedule_desc_emoji_tray" class="hidden flex items-center gap-1.5 p-2 bg-[#202c33] rounded-lg mt-1 overflow-x-auto">
                        <span onclick="window.insertScheduleDescEmoji('😊')" class="text-xl cursor-pointer hover:scale-110 transition-transform">😊</span>
                        <span onclick="window.insertScheduleDescEmoji('😂')" class="text-xl cursor-pointer hover:scale-110 transition-transform">😂</span>
                        <span onclick="window.insertScheduleDescEmoji('😍')" class="text-xl cursor-pointer hover:scale-110 transition-transform">😍</span>
                        <span onclick="window.insertScheduleDescEmoji('👍')" class="text-xl cursor-pointer hover:scale-110 transition-transform">👍</span>
                        <span onclick="window.insertScheduleDescEmoji('❤️')" class="text-xl cursor-pointer hover:scale-110 transition-transform">❤️</span>
                        <span onclick="window.insertScheduleDescEmoji('🙌')" class="text-xl cursor-pointer hover:scale-110 transition-transform">🙌</span>
                        <span onclick="window.insertScheduleDescEmoji('😭')" class="text-xl cursor-pointer hover:scale-110 transition-transform">😭</span>
                        <span onclick="window.insertScheduleDescEmoji('🎉')" class="text-xl cursor-pointer hover:scale-110 transition-transform">🎉</span>
                        <span onclick="window.insertScheduleDescEmoji('🙏')" class="text-xl cursor-pointer hover:scale-110 transition-transform">🙏</span>
                        <span onclick="window.insertScheduleDescEmoji('🔥')" class="text-xl cursor-pointer hover:scale-110 transition-transform">🔥</span>
                    </div>
                </div>

                <!-- Start Date and Time -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-[#8696a0] text-xs font-normal">Start date and time</label>
                    <div class="flex gap-4">
                        <div class="flex-1 border-b border-gray-600/30 py-1 flex items-center justify-between focus-within:border-[#00a884] transition-all relative">
                            <input type="date" id="schedule_start_date" class="w-full bg-transparent border-none text-[#e9edef] text-[15px] focus:ring-0 p-0 outline-none">
                            <svg class="w-5 h-5 text-[#8696a0] absolute right-0 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex-1 border-b border-gray-600/30 py-1 flex items-center justify-between focus-within:border-[#00a884] transition-all relative">
                            <input type="time" id="schedule_start_time" class="w-full bg-transparent border-none text-[#e9edef] text-[15px] focus:ring-0 p-0 outline-none">
                            <svg class="w-5 h-5 text-[#8696a0] absolute right-0 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- End Date and Time -->
                <div id="schedule_end_datetime_container" class="flex flex-col gap-1.5">
                    <label class="text-[#8696a0] text-xs font-normal">End date and time</label>
                    <div class="flex gap-4">
                        <div class="flex-1 border-b border-gray-600/30 py-1 flex items-center justify-between focus-within:border-[#00a884] transition-all relative">
                            <input type="date" id="schedule_end_date" class="w-full bg-transparent border-none text-[#e9edef] text-[15px] focus:ring-0 p-0 outline-none">
                            <svg class="w-5 h-5 text-[#8696a0] absolute right-0 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex-1 border-b border-gray-600/30 py-1 flex items-center justify-between focus-within:border-[#00a884] transition-all relative">
                            <input type="time" id="schedule_end_time" class="w-full bg-transparent border-none text-[#e9edef] text-[15px] focus:ring-0 p-0 outline-none">
                            <svg class="w-5 h-5 text-[#8696a0] absolute right-0 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Toggle End Time Button -->
                <button type="button" id="schedule_toggle_endtime_btn" onclick="window.toggleScheduleEndTime()" class="text-[#00a884] hover:text-[#06cf9c] text-sm font-medium flex items-center gap-1.5 focus:outline-none self-start mt-1 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <span id="schedule_toggle_endtime_text">Remove end time</span>
                </button>

                <p class="text-[#8696a0] text-xs leading-normal">
                    Events with call links can't be more than one year in the future
                </p>

                <!-- Call Type -->
                <div class="flex items-center justify-between border-t border-white/5 pt-4">
                    <span class="text-[#e9edef] text-[15px] font-normal">Call type</span>
                    <div class="relative">
                        <button type="button" id="schedule_call_type_btn" onclick="window.toggleScheduleCallTypeDropdown(event)" class="flex items-center gap-2 bg-[#202c33] hover:bg-[#2a3942] text-[#00a884] px-4 py-2.5 rounded-full border border-white/5 transition-all text-sm font-semibold focus:outline-none">
                            <span id="schedule_call_type_icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            </span>
                            <span id="schedule_call_type_label">Video</span>
                            <svg class="w-3.5 h-3.5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div id="schedule_call_type_menu" class="hidden absolute right-0 bottom-full mb-1.5 w-[140px] bg-[#233138] border border-white/5 rounded-xl shadow-2xl z-[200] py-1.5 overflow-hidden animate-in fade-in zoom-in-95 duration-150">
                            <button type="button" onclick="window.setScheduleCallType('video')" class="w-full flex items-center justify-between px-4 py-2 text-sm text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    <span>Video</span>
                                </div>
                            </button>
                            <button type="button" onclick="window.setScheduleCallType('voice')" class="w-full flex items-center justify-between px-4 py-2 text-sm text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    <span>Voice</span>
                                </div>
                        </div>
                    </div>
                </div>
                <!-- Send invitation to -->
                <div class="flex items-center justify-between border-t border-white/5 pt-4">
                    <span class="text-[#e9edef] text-[15px] font-normal">Send invitation to</span>
                    <button type="button" onclick="window.openShareSelector('schedule')" class="flex items-center gap-1.5 bg-[#202c33] hover:bg-[#2a3942] text-[#00a884] px-4 py-2.5 rounded-lg border border-white/5 transition-all text-sm font-semibold focus:outline-none">
                        <span id="schedule_target_name">Select Chat</span>
                        <svg class="w-3.5 h-3.5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Require approval to join -->
                <div class="flex items-center justify-between border-t border-white/5 pt-4">
                    <span class="text-[#e9edef] text-[15px] font-normal">Require approval to join</span>
                    <button type="button" onclick="window.toggleScheduleApproval()" id="schedule_approval_toggle"
                        class="w-10 h-5 flex items-center rounded-full p-0.5 transition-all duration-200 bg-[#2f3b43] focus:outline-none">
                        <div class="bg-[#8696a0] w-4 h-4 rounded-full transform transition-transform duration-200 translate-x-0" id="schedule_approval_circle"></div>
                    </button>
                </div>
            </div>

            <!-- Footer actions -->
            <div class="px-6 py-4 bg-[#202c33] border-t border-white/5 flex items-center justify-end shrink-0">
                <button type="button" onclick="window.submitScheduledCall()" class="w-12 h-12 rounded-full bg-[#00a884] hover:bg-[#06cf9c] text-[#111b21] flex items-center justify-center shadow-lg transition-all active:scale-95 focus:outline-none">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path d="M1.101 21.757L23.8 12.028 1.101 2.3l.011 7.912 13.623 1.816-13.623 1.817-.011 7.912z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- New Call Link Modal -->
    <div id="new_call_link_modal"
        class="hidden fixed inset-0 z-[150] bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="w-full max-w-[420px] bg-[#111b21] rounded-2xl flex flex-col border border-white/5 shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 bg-[#202c33] border-b border-white/5">
                <h3 class="text-[#e9edef] text-[20px] font-bold">New call link</h3>
                <button onclick="window.closeNewCallLinkModal()" class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Body Content -->
            <div class="p-6 flex flex-col gap-6">
                <!-- Selector & Link Input Row -->
                <div class="flex items-center gap-3">
                    <!-- Custom Dropdown Trigger -->
                    <div class="relative">
                        <button id="call_link_type_btn" onclick="window.toggleCallLinkTypeDropdown(event)"
                            class="flex items-center gap-2 bg-[#202c33] hover:bg-[#2a3942] text-[#00a884] px-4 py-2.5 rounded-lg border border-white/5 transition-all text-sm font-semibold focus:outline-none">
                            <span id="call_link_type_icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                            </span>
                            <span id="call_link_type_label">Video</span>
                            <svg class="w-3.5 h-3.5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Custom Dropdown Menu -->
                        <div id="call_link_type_menu" class="hidden absolute left-0 top-full mt-1.5 w-[160px] bg-[#233138] border border-white/5 rounded-xl shadow-2xl z-[200] py-1.5 overflow-hidden animate-in fade-in zoom-in-95 duration-150">
                            <button onclick="window.setCallLinkType('video')" class="w-full flex items-center justify-between px-4 py-2.5 text-sm text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Video</span>
                                </div>
                                <svg id="call_link_type_check_video" class="w-4 h-4 text-[#00a884]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </button>
                            <button onclick="window.setCallLinkType('voice')" class="w-full flex items-center justify-between px-4 py-2.5 text-sm text-[#e9edef] hover:bg-[#182229] transition-colors text-left focus:outline-none">
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <span>Voice</span>
                                </div>
                                <svg id="call_link_type_check_voice" class="w-4 h-4 text-[#00a884] hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Input Link with Copy Button -->
                    <div class="flex-1 min-w-0 bg-[#202c33] flex items-center gap-3 pl-4 pr-2.5 py-2.5 rounded-lg border border-white/5 transition-all">
                        <span id="call_link_input"
                            class="text-[#e9edef] text-sm focus:ring-0 p-0 w-full outline-none select-all select-text font-mono truncate"></span>
                        <button onclick="window.copyCallLink()" id="call_link_copy_btn" class="text-[#8696a0] hover:text-[#e9edef] p-1.5 hover:bg-white/5 rounded-lg transition-all focus:outline-none shrink-0" title="Copy Link">
                            <svg id="copy_icon_normal" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            <svg id="copy_icon_success" class="w-5 h-5 text-[#00a884] hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Helper Text -->
                <p class="text-[#8696a0] text-sm leading-relaxed">
                    Anyone with this app can use this link to join this call. Only share it with people you trust.
                </p>

                <!-- Send link to -->
                <div class="flex items-center justify-between py-3 border-t border-white/5">
                    <span class="text-[#e9edef] text-sm font-medium">Send link to</span>
                    <button type="button" onclick="window.openShareSelector('call_link')" class="flex items-center gap-1.5 bg-[#202c33] hover:bg-[#2a3942] text-[#00a884] px-4 py-2 rounded-lg border border-white/5 transition-all text-sm font-semibold focus:outline-none">
                        <span id="call_link_target_name">Select Chat</span>
                        <svg class="w-3.5 h-3.5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Approval Toggle Switch -->
                <div class="flex items-center justify-between py-2 border-t border-white/5">
                    <span class="text-[#e9edef] text-sm font-medium">Require approval to join</span>
                    <button onclick="window.toggleCallLinkApproval()" id="call_link_approval_toggle"
                        class="w-10 h-5 flex items-center rounded-full p-0.5 transition-all duration-200 bg-[#2f3b43] focus:outline-none">
                        <div class="bg-[#8696a0] w-4 h-4 rounded-full transform transition-transform duration-200 translate-x-0" id="call_link_approval_circle"></div>
                    </button>
                </div>
            </div>

            <!-- Footer actions -->
            <div class="px-6 py-4 bg-[#202c33] border-t border-white/5 flex items-center justify-between shrink-0 font-['Inter']">
                <button onclick="window.joinCallFromLink()" class="text-[#00a884] hover:text-[#06cf9c] font-bold text-base transition-colors focus:outline-none">
                    Join call
                </button>
                <button onclick="window.sendCallLinkToChat()"
                    class="bg-[#00a884] hover:bg-[#06cf9c] text-[#111b21] px-5 py-2.5 rounded-full flex items-center gap-2 font-bold transition-all active:scale-95 text-[15px] focus:outline-none shrink-0">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"></path>
                    </svg>
                    <span class="whitespace-nowrap">Send link to chat</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Admin Invite Modal -->
    <div id="admin_invite_modal" class="hidden fixed inset-0 z-[300] bg-black/60 backdrop-blur-sm flex items-end sm:items-center justify-center p-0 sm:p-4 transition-opacity">
        <div id="admin_invite_modal_content" class="w-full max-w-[400px] bg-white rounded-t-3xl sm:rounded-3xl flex flex-col shadow-2xl transform translate-y-full transition-transform duration-300">
            <!-- Grab Handle -->
            <div class="w-full flex justify-center pt-3 pb-2 sm:hidden">
                <div class="w-10 h-1 rounded-full bg-gray-300"></div>
            </div>

            <!-- Close Button (Desktop) -->
            <div class="absolute top-4 right-4 hidden sm:block">
                <button onclick="window.closeAdminInviteModal()" class="text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div class="px-6 pt-4 pb-8 flex flex-col items-center font-sans">
                <!-- Channel Avatar -->
                <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden mb-5 border border-gray-100 shadow-sm">
                    <img id="admin_invite_modal_avatar" src="" class="w-full h-full object-cover">
                </div>

                <!-- Channel Name -->
                <h2 id="admin_invite_modal_name" class="text-[24px] font-semibold text-gray-900 mb-1 text-center leading-tight"></h2>
                <p class="text-[15px] text-gray-600 mb-8 font-medium">Channel admin invite</p>

                <!-- Features List -->
                <div class="w-full flex flex-col gap-6 mb-8">
                    <div class="flex items-start gap-4">
                        <div class="mt-0.5 text-[#008069] shrink-0">
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-[16px] text-gray-900 font-normal">Admins can send updates</h4>
                            <p class="text-[14px] text-gray-500 leading-snug mt-0.5">Admins can also change the channel's profile and settings.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="mt-0.5 text-[#008069] shrink-0">
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-[16px] text-gray-900 font-normal">You're visible to other admins</h4>
                            <p class="text-[14px] text-gray-500 leading-snug mt-0.5">Admins for this channel can see your phone number, profile picture and name, but followers can't.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="mt-0.5 text-[#008069] shrink-0">
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-[16px] text-gray-900 font-normal">You're responsible for this channel</h4>
                            <p class="text-[14px] text-gray-500 leading-snug mt-0.5">This channel needs to follow our guidelines and is reviewed against them.</p>
                        </div>
                    </div>
                </div>

                <!-- Expiry -->
                <p class="text-[13px] text-gray-500 mb-6">Expires in 7 days</p>

                <!-- Actions -->
                <div class="w-full flex flex-col gap-3">
                    <button onclick="window.acceptAdminInviteAndOpen()" class="w-full bg-[#008069] text-white py-3 rounded-full font-medium text-[15px] hover:bg-[#00695c] transition-colors focus:outline-none shadow-sm">
                        Accept invite
                    </button>
                    <button onclick="window.viewChannelFromInvite()" class="w-full bg-white text-[#008069] py-3 rounded-full font-medium text-[15px] hover:bg-gray-50 transition-colors focus:outline-none">
                        View channel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Share Selector Modal (select user or group to send link/scheduled call to) -->
    <div id="share_selector_modal"
        class="hidden fixed inset-0 z-[250] bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="w-full max-w-[380px] bg-[#111b21] rounded-2xl flex flex-col h-[500px] border border-white/5 shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 bg-[#202c33] border-b border-white/5 shrink-0">
                <h3 class="text-[#e9edef] text-[18px] font-semibold">Send to...</h3>
                <button onclick="window.closeShareSelector()" class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Search -->
            <div class="p-3 bg-[#111b21] border-b border-white/5 shrink-0">
                <div class="bg-[#202c33] flex items-center gap-3 px-4 py-2 rounded-lg border border-transparent focus-within:border-[#00a884] transition-all">
                    <svg class="w-5 h-5 text-[#8696a0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" id="share_search_input" oninput="window.renderShareSelectorList()"
                        placeholder="Search contact or group"
                        class="bg-transparent border-none text-[#e9edef] text-sm focus:ring-0 placeholder-[#8696a0] p-0 w-full outline-none">
                </div>
            </div>

            <!-- List -->
            <div id="share_chats_list" class="flex-1 overflow-y-auto custom-scrollbar">
                <!-- Chats will be populated dynamically from DOM -->
            </div>
        </div>
    </div>
    @include('chat.modals.chat_wallpaper_modal')
    @include('chat.settings.disappearing_messages.index')
    @include('chat.channels.channels_scripts')

    <script>
        window.addEventListener('load', function() {
            const path = window.location.pathname;
            if (path.startsWith('/channel/')) {
                const parts = path.split('/');
                const channelId = parts[2];
                if (channelId) {
                    if (typeof window.showChannels === 'function') {
                        window.showChannels();
                    }
                    let attempts = 0;
                    const check = setInterval(() => {
                        if (typeof window.openChannel === 'function' && window.db) {
                            clearInterval(check);
                            window.openChannel(channelId);
                        }
                        attempts++;
                        if (attempts > 50) clearInterval(check); // timeout after 5s
                    }, 100);
                }
            }
        });
    </script>
</x-app-layout>


