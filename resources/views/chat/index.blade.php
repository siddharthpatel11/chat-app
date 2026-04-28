<x-app-layout>
    @push('styles')
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <style>
            .chat-bg {
                background-color: #efeae2;
                background-image: url('https://w0.peakpx.com/wallpaper/508/871/HD-wallpaper-whatsapp-background-theme-pattern.jpg');
                background-blend-mode: multiply;
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
        </style>
    @endpush

    <div class="flex w-full h-[100vh] mx-auto overflow-hidden shadow-xl">

        <!-- Toast Container -->
        <div id="toast_container"
            class="fixed top-6 left-1/2 -translate-x-1/2 z-[200] flex flex-col gap-3 pointer-events-none w-full max-w-sm px-4">
        </div>

        <div class="flex w-full h-full bg-[#111b21] overflow-hidden border-none">

            @include('chat.nav_sidebar')
            @include('chat.profile_settings')
            @include('chat.edit_profile')
            @include('chat.about_modal')
            @include('chat.about_privacy_modal')
            @include('chat.contact_info')
            @include('chat.sidebar')


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
            <div id="location_preview_modal" class="hidden fixed inset-0 z-[100] bg-[#0b141a] flex flex-col font-sans">
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
                        <button onclick="toggleLocationSearch()" class="text-white hover:bg-white/10 p-2 rounded-full">
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

            <div class="flex-1 flex h-full overflow-hidden relative">
                @include('chat.settings_shortcuts')
                <div id="main_chat_column" class="flex flex-col flex-1 h-full relative transition-all duration-300">
                    <!-- Empty State -->
                    <div id="chat_empty_state"
                        class="flex-1 flex flex-col items-center justify-center bg-[#0b141a] text-center px-4 z-20">
                        <div class="flex gap-14 mb-8">
                            <!-- Send Document -->
                            <div class="flex flex-col items-center gap-4 group cursor-pointer"
                                onclick="selectFile('.pdf,.doc,.docx')">
                                <div
                                    class="w-[110px] h-[110px] rounded-[28px] bg-[#202c33] flex items-center justify-center text-[#8696a0] group-hover:bg-[#2a3942] transition-all duration-300">
                                    <svg viewBox="0 0 24 24" width="36" height="36" fill="none" stroke="currentColor"
                                        stroke-width="1.5">
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
                                onclick="window.focusSearch()">
                                <div
                                    class="w-[110px] h-[110px] rounded-[28px] bg-[#202c33] flex items-center justify-center text-[#8696a0] group-hover:bg-[#2a3942] transition-all duration-300">
                                    <svg viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="currentColor"
                                        stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                                    </svg>
                                </div>
                                <span class="text-[#8696a0] text-[13px] font-normal">Add contact</span>
                            </div>
                            <!-- Ask Meta AI -->
                            <div class="flex flex-col items-center gap-4 group cursor-pointer">
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
                        <div class="h-16 bg-[#202c33] px-4 border-b border-[#313d45] shrink-0 shadow-sm z-10 relative">
                            <!-- Normal Header -->
                            <div id="normal_header"
                                class="flex items-center justify-between h-full w-full transition-all duration-300">
                                <div class="flex items-center gap-2">
                                    <button class="sm:hidden text-[#8696a0] hover:text-[#e9edef] transition-colors mr-1"
                                        onclick="window.backToSidebar()">
                                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z">
                                            </path>
                                        </svg>
                                    </button>
                                    <div id="active_chat_avatar" onclick="openContactInfo()"
                                        class="w-10 h-10 rounded-full bg-[#2a3942] flex items-center justify-center text-gray-600 font-bold shadow-sm overflow-hidden transition-transform hover:scale-105 cursor-pointer">
                                        <svg class="w-6 h-6 text-[#8696a0]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="cursor-pointer" onclick="openContactInfo()">
                                        <h2 id="active_chat_title"
                                            class="text-[15px] font-semibold text-[#e9edef] leading-tight">Select a chat
                                        </h2>
                                        <p id="active_chat_subtitle" class="text-xs text-[#00a884] font-medium hidden">
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
                                            <svg class="w-4 h-4 text-[#8696a0] group-hover:text-[#e9edef]" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>

                                        <!-- Call Dropdown -->
                                        <div id="call_dropdown" style="display: none;"
                                            class="hidden absolute top-14 right-0 w-[350px] bg-[#111b21] rounded-2xl shadow-2xl z-[100] flex flex-col border border-white/5 overflow-hidden transition-all duration-200 transform origin-top-right scale-95 opacity-0">
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
                                                    <button
                                                        class="flex-1 bg-[#00a884] hover:bg-[#06cf9c] text-[#111b21] py-3 rounded-full flex items-center justify-center gap-2.5 font-bold transition-all active:scale-[0.98]">
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                            <path
                                                                d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z">
                                                            </path>
                                                        </svg>
                                                        Voice
                                                    </button>
                                                    <button
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
                                                <button
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
                                                <button
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
                                                <button
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
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </button>

                                    <!-- Menu Icon -->
                                    <button
                                        class="p-2.5 text-[#8696a0] hover:text-[#e9edef] hover:bg-[#2a3942] rounded-full transition-all duration-200 focus:outline-none"
                                        title="Menu">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Selection Header -->
                            <div id="selection_header"
                                class="hidden absolute inset-0 bg-teal-600 items-center justify-between px-4 h-full w-full transition-all duration-300">
                                <div class="flex items-center gap-4">
                                    <button onclick="cancelSelection()"
                                        class="text-white hover:bg-black/10 p-2 rounded-full transition-colors focus:outline-none">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
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
                                <div class="flex flex-col overflow-hidden">
                                    <span class="font-semibold text-[#00a884] text-[13px]">Replying to message</span>
                                    <span id="replying_to_text"
                                        class="text-[#8696a0] text-sm truncate max-w-[200px] sm:max-w-md"></span>
                                </div>
                                <button onclick="cancelReply()"
                                    class="text-[#8696a0] hover:text-red-500 p-1.5 rounded-full hover:bg-black/10 focus:outline-none transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>

                            <div class="flex items-center gap-2 w-full relative">
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
                                    <!-- The actual picker (Uses system dark/light mode automatically) -->
                                    <emoji-picker id="emoji_picker" class="w-full"
                                        style="--num-columns: 8; --emoji-size: 1.5rem; --indicator-color: #00a884; height: 320px; border: none;"></emoji-picker>

                                    <!-- Bottom Tabs Bar (WhatsApp Style) -->
                                    <div
                                        class="h-[50px] bg-gray-100 dark:bg-[#2a3942] border-t border-gray-200 dark:border-gray-700 flex items-center justify-center shrink-0">
                                        <!-- Emoji Tab (Active) -->
                                        <button
                                            class="flex-1 flex justify-center py-2 h-full items-center relative transition-colors bg-gray-200 dark:bg-[#384b57]">
                                            <svg viewBox="0 0 24 24" width="24" height="24"
                                                class="text-gray-600 dark:text-gray-300" fill="currentColor">
                                                <path
                                                    d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm2.5-9.5c.828 0 1.5-.672 1.5-1.5s-.672-1.5-1.5-1.5-1.5.672-1.5 1.5.672 1.5 1.5 1.5zm-5 0c.828 0 1.5-.672 1.5-1.5S8.828 8 8 8s-1.5.672-1.5 1.5.672 1.5 1.5 1.5zm2.5 6c2.511 0 4.67-1.516 5.568-3.693h-11.136c.898 2.177 3.057 3.693 5.568 3.693z">
                                                </path>
                                            </svg>
                                            <div class="absolute bottom-0 left-0 w-full h-[3px] bg-[#00a884]"></div>
                                        </button>
                                        <!-- GIF Tab -->
                                        <button
                                            class="flex-1 flex justify-center py-2 h-full items-center hover:bg-gray-200 dark:hover:bg-[#384b57] transition-colors">
                                            <span
                                                class="font-bold text-gray-500 dark:text-gray-400 text-[15px]">GIF</span>
                                        </button>
                                        <!-- Sticker Tab -->
                                        <button
                                            class="flex-1 flex justify-center py-2 h-full items-center hover:bg-gray-200 dark:hover:bg-[#384b57] transition-colors">
                                            <svg viewBox="0 0 24 24" width="24" height="24"
                                                class="text-gray-500 dark:text-gray-400" fill="currentColor">
                                                <path
                                                    d="M14.5 3h-5C6.46 3 4 5.46 4 8.5v7C4 18.54 6.46 21 9.5 21h4l6-6v-6.5C19.5 5.46 17.04 3 14.5 3zm-2.5 16h-2.5C7.57 19 6 17.43 6 15.5v-7C6 6.57 7.57 5 9.5 5h5C16.43 5 18 6.57 18 8.5v5.09l-4.5 4.5V19h-1.5zM17 14h-2.5c-.83 0-1.5.67-1.5 1.5V18l4-4z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <input type="file" id="file_input" class="hidden">
                                <div class="relative shrink-0">
                                    <button type="button" id="attach_toggle_btn" onclick="toggleAttachMenu()"
                                        class="text-gray-500 hover:text-gray-700 p-2 focus:outline-none">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    class="flex-1 relative flex items-center bg-white rounded-lg shadow-sm">

                                    <!-- State 1: Normal Text Input -->
                                    <div id="text_input_state" class="w-full relative flex items-center">
                                        <input type="text" id="msg" oninput="handleInputToggle()"
                                            onkeypress="handleKeyPress(event)" placeholder="Type a message"
                                            class="w-full bg-transparent border-none rounded-lg pl-4 pr-10 py-2 text-[15px] focus:ring-0 text-gray-800 placeholder-gray-500 min-h-[40px]">
                                        <!-- INSIDE MIC (Voice-to-Text) -->
                                        <button type="button" id="inside_mic_btn" onclick="toggleVoiceRecord()"
                                            class="absolute right-3 text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
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
                                            <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
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
                                    <svg id="mic_icon" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                        <path
                                            d="M11.999 14.942c2.001 0 3.531-1.53 3.531-3.531V4.35c0-2.001-1.53-3.531-3.531-3.531S8.469 2.35 8.469 4.35v7.061c0 2.001 1.53 3.531 3.53 3.531zm6.238-3.53c0 3.531-2.942 6.002-6.237 6.002s-6.237-2.471-6.237-6.002H3.761c0 4.001 3.178 7.297 7.061 7.885v3.884h2.354v-3.884c3.884-.588 7.061-3.884 7.061-7.885h-2.002z">
                                        </path>
                                    </svg>
                                    <!-- Send SVG -->
                                    <svg id="send_icon" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"
                                        class="hidden ml-1">
                                        <path
                                            d="M1.101 21.757L23.8 12.028 1.101 2.3l.011 7.912 13.623 1.816-13.623 1.817-.011 7.912z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
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
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
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
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M15 19l-7-7 7-7"></path>
                                            </svg>
                                        </button>
                                        <button onclick="changeCalendarMonth(1)"
                                            class="text-[#aebac1] hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M9 5l7 7-7 7"></path>
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
                                <input type="text" id="search_messages_input" oninput="performMessageSearch(this.value)"
                                    placeholder="Search..."
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
        function toggleEmojiPicker() {
            const picker = document.getElementById('emoji_picker_container');
            picker.classList.toggle('hidden');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function (event) {
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
        });

        document.getElementById('emoji_picker').addEventListener('emoji-click', event => {
            const msgInput = document.getElementById('msg');
            msgInput.value += event.detail.unicode;
            msgInput.focus();
            handleInputToggle();
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
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
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
                    document.getElementById('audio_timer').innerText = `${mins}:${secs.toString().padStart(2, '0')}`;
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
                    const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
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
                headers: { 'X-CSRF-TOKEN': csrf },
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

                newBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const isOpening = callDropdown.classList.contains('hidden') || callDropdown.style.display === 'none';

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

            recognition.onstart = function () {
                isRecordingSpeechText = true;
                const insideMicBtn = document.getElementById('inside_mic_btn');
                if (insideMicBtn) {
                    insideMicBtn.classList.replace('text-gray-400', 'text-red-500');
                    insideMicBtn.classList.add('animate-pulse');
                }
            };

            recognition.onresult = function (event) {
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

            recognition.onerror = function (event) {
                console.error('Speech recognition error', event.error);
                stopSpeechToText();
            };

            recognition.onend = function () {
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

        let leafletMapInstance = null;
        let leafletMarker = null;
        let currentLat = null;
        let currentLng = null;
        let currentAccuracy = null;
        let selectedDuration = 60; // default 1 hour
        let searchTimeout = null;

        window.shareLocation = function () {
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

        window.fetchLocation = function () {
            navigator.geolocation.getCurrentPosition((position) => {
                currentLat = position.coords.latitude;
                currentLng = position.coords.longitude;
                currentAccuracy = Math.round(position.coords.accuracy);
                document.getElementById('accuracy_meters').textContent = currentAccuracy;

                if (!leafletMapInstance) {
                    leafletMapInstance = L.map('leaflet_map', { zoomControl: false }).setView([currentLat, currentLng], 16);

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

                    leafletMarker = L.marker([currentLat, currentLng], { icon: myIcon, draggable: true }).addTo(leafletMapInstance);

                    leafletMarker.on('dragend', function (e) {
                        currentLat = leafletMarker.getLatLng().lat;
                        currentLng = leafletMarker.getLatLng().lng;
                        updateNearbyPlaces(currentLat, currentLng);
                    });

                    leafletMapInstance.on('moveend', function (e) {
                        // If marker is locked to center, update it
                        if (document.getElementById('live_location_config_panel').classList.contains('hidden')) {
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
            }, { enableHighAccuracy: true });
        };

        window.centerOnMe = function () {
            fetchLocation();
        };

        window.refreshLocation = function () {
            fetchLocation();
        };

        window.toggleLocationSearch = function () {
            const sb = document.getElementById('location_search_bar');
            sb.classList.toggle('hidden');
            if (!sb.classList.contains('hidden')) document.getElementById('location_search_input').focus();
        };

        window.searchLocation = function (query) {
            clearTimeout(searchTimeout);
            if (query.length < 3) return;
            searchTimeout = setTimeout(async () => {
                try {
                    const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`);
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
                } catch (e) { }
            }, 500);
        };

        window.updateNearbyPlaces = function (lat, lng) {
            // Using nominatim reverse geocoding to simulate nearby places
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(res => res.json())
                .then(data => {
                    if (data && data.address) {
                        const placeName = data.address.suburb || data.address.neighbourhood || data.address.road || data.display_name.split(',')[0];
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
                }).catch(e => { });
        };

        window.selectPlace = function (lat, lng, name) {
            currentLat = lat;
            currentLng = lng;
            leafletMapInstance.setView([lat, lng], 16);
            leafletMarker.setLatLng([lat, lng]);
            toggleLocationSearch();
        };

        window.openLiveLocationConfig = function () {
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

        window.selectDuration = function (mins) {
            selectedDuration = mins;
            document.querySelectorAll('.dur-btn').forEach(btn => {
                btn.classList.remove('bg-[#1dae75]', 'text-white');
                btn.classList.add('bg-[#2a3942]', 'text-[#8696a0]');
            });
            const selectedBtn = document.getElementById('dur_' + mins);
            selectedBtn.classList.remove('bg-[#2a3942]', 'text-[#8696a0]');
            selectedBtn.classList.add('bg-[#1dae75]', 'text-white');
        };

        window.sendCurrentLocation = function () {
            sendLocationToServer(currentLat, currentLng, '');
        };

        window.sendSpecificLocation = function (lat, lng, text) {
            sendLocationToServer(lat, lng, text);
        };

        window.startLiveLocation = function () {
            const comment = document.getElementById('live_loc_comment').value;
            sendLocationToServer(currentLat, currentLng, comment, 'live_location', selectedDuration);
        };

        window.sendLocationToServer = async function (lat, lng, text, msgType = 'location', duration = null) {
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
                    headers: { 'X-CSRF-TOKEN': csrf },
                    body: formData
                });
            } catch (e) { console.error('Send error:', e); }
        };

        window.closeLocationModal = function () {
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
        document.addEventListener('click', function (event) {
            const menu = document.getElementById('attach_menu');
            const button = event.target.closest('button[onclick="toggleAttachMenu()"]');
            if (!button && menu && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
        });

        // HANDLE FILE SELECTION -> SHOW FULL SCREEN MODAL
        document.getElementById('file_input').addEventListener('change', function (e) {
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
                reader.onload = function (e) { imgPreview.src = e.target.result; }
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

        function handleKeyPress(e) { if (e.key === 'Enter') send(); }

        // Core Send Function (used for text & modal)
        async function emitMessage(msgText, fileObj = null) {
            if (!window.currentChatId) {
                alert('Please select a chat first.');
                return;
            }
            if (msgText === "" && !fileObj) return;

            let formData = new FormData();
            formData.append('chat_id', window.currentChatId);
            formData.append('message', msgText);

            if (fileObj) {
                formData.append('file', fileObj);
            }
            if (window.replyingToKey && window.globalMessages[window.replyingToKey]) {
                formData.append('reply_to_id', window.replyingToKey);
                formData.append('reply_to_text', window.globalMessages[window.replyingToKey].text || 'Media');
            }

            // Reset inputs
            document.getElementById('msg').value = "";
            clearFile();
            cancelReply();
            if (typeof handleInputToggle === 'function') handleInputToggle();

            try {
                await fetch('/send', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrf },
                    body: formData
                });
            } catch (e) { console.error('Send error:', e); }

            document.getElementById('msg').focus();
        }

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
        window.replyTo = function (key) {
            document.getElementById('menu_' + key)?.classList.add('hidden');
            window.replyingToKey = key;
            const msgData = window.globalMessages[key];
            document.getElementById('replying_to_block').classList.remove('hidden');
            document.getElementById('replying_to_text').textContent = msgData.text ? msgData.text : (msgData.type || 'Media File');
            document.getElementById('msg').focus();
        };

        window.cancelReply = function () {
            window.replyingToKey = null;
            document.getElementById('replying_to_block').classList.add('hidden');
        };

        window.forwardMsg = function (key) {
            if (!window.currentChatId) {
                alert('Please select a chat first.');
                return;
            }
            document.getElementById('menu_' + key)?.classList.add('hidden');
            document.getElementById('msg_' + key).style.zIndex = '0';
            const msgData = window.globalMessages[key];

            let formData = new FormData();
            formData.append('chat_id', window.currentChatId);
            formData.append('type', msgData.type || 'text');
            formData.append('message', msgData.text || '');
            if (msgData.lat) formData.append('lat', msgData.lat);
            if (msgData.lng) formData.append('lng', msgData.lng);

            // If it's a file, we can't easily resend it via form data without downloading
            if (['image', 'video', 'audio', 'document'].includes(msgData.type)) {
                alert('Forwarding media files is not fully implemented. Please upload the file again.');
                return;
            }

            fetch('/send', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf },
                body: formData
            });
        };

        window.toggleMsgMenu = function (key) {
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

        window.filterSidebar = function () {
            const query = document.getElementById('sidebar_search').value.toLowerCase();
            const users = document.querySelectorAll('[id^="user_sidebar_"]');
            users.forEach(user => {
                const name = user.querySelector('h4').textContent.toLowerCase();
                if (name.includes(query)) {
                    user.style.display = '';
                } else {
                    user.style.display = 'none';
                }
            });
        };

        window.showToast = function (title, body, otherUserId = null, otherName = null) {
            const container = document.getElementById('toast_container');
            const id = Date.now();
            const clickAttr = (otherUserId && otherName) ? `onclick="window.selectChat('${otherUserId}', '${otherName.replace(/'/g, "\\'")}', ''); this.remove();"` : '';

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
            try { new Audio('https://assets.mixkit.co/active_storage/sfx/2354/2354-preview.mp3').play(); } catch (e) { }

            // Auto remove after 8 seconds
            setTimeout(() => {
                if (toast) {
                    toast.style.transform = 'translateX(120%)';
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 400);
                }
            }, 8000);
        };

        window.toggleSearchPanel = function () {
            const sidebar = document.getElementById('search_sidebar');
            const chatMain = document.querySelector('.flex.flex-col.w-full.sm\\:w-\\[70\\%\\]');
            sidebar.classList.toggle('hidden');
            if (!sidebar.classList.contains('hidden')) {
                document.getElementById('search_messages_input').focus();
                document.getElementById('no_results_text').querySelector('p').textContent = `Search for messages with ${document.getElementById('active_chat_title').textContent}`;
            }
        };

        window.clearMessageSearch = function () {
            const input = document.getElementById('search_messages_input');
            input.value = '';
            document.getElementById('clear_search_btn').classList.add('hidden');
            document.getElementById('search_results_list').innerHTML = '';
            document.getElementById('no_results_text').classList.remove('hidden');
            input.focus();
        };

        window.performMessageSearch = function (query) {
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
                    results.push({ ...msg, key });
                }
            }

            // Sort results by time descending
            results.sort((a, b) => b.time - a.time);

            renderMessageSearchResults(results, searchTerm);
        };

        window.renderMessageSearchResults = function (results, searchTerm) {
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
                    resultsList.insertAdjacentHTML('beforeend', `<div class="px-6 py-4 text-[#8696a0] text-[13px] font-medium">${date}</div>`);
                }

                // Highlight search term
                const regex = new RegExp(`(${searchTerm})`, 'gi');
                const highlightedText = msg.text.replace(regex, '<span class="text-[#00a884] font-medium">$1</span>');
                const time = new Date(msg.time * 1000).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
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

        window.scrollToMessage = function (key) {
            const el = document.getElementById('msg_' + key);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                el.classList.add('bg-[#00a884]/20');
                setTimeout(() => {
                    el.classList.remove('bg-[#00a884]/20');
                }, 2000);
            }
        };
    </script>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
        import { getDatabase, ref, onChildAdded, remove, onChildRemoved, onValue, onDisconnect, set, serverTimestamp, onChildChanged, update, query, limitToLast } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-database.js";
        import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging.js";

        const firebaseConfig = {
            apiKey: "AIzaSyCTUuLg0mheURhlG1Z0p0DgMRwoAcR-F0w",
            authDomain: "chat-app-a370c.firebaseapp.com",
            databaseURL: "https://chat-app-a370c-default-rtdb.firebaseio.com",
            projectId: "chat-app-a370c",
            // IMPORTANT: Get these from Firebase Console -> Project Settings
            messagingSenderId: "1089034732064",
            appId: "1:1016598612026:web:6cc4d1dd4466eec8934d03"
        };

        const app = initializeApp(firebaseConfig);
        const db = getDatabase(app);
        const messaging = getMessaging(app);

        // Expose to window for global access
        window.db = db;
        window.ref = ref;
        window.update = update;
        window.set = set;
        window.serverTimestamp = serverTimestamp;
        window.myUserId = {{ auth()->id() ?? '0' }};
        window.currentChatId = null;
        let unsubscribeAdded = null;
        let unsubscribeRemoved = null;
        let statusUnsubscribe = null;

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

            // Global Delivered Listener (for all users in sidebar)
            const allUserIds = [
                @foreach($users ?? [] as $u)
                    {{ $u->id }},
                @endforeach
            ];

            allUserIds.forEach(otherId => {
                const minId = Math.min(window.myUserId, otherId);
                const maxId = Math.max(window.myUserId, otherId);
                const chatId = `chat_${minId}_${maxId}`;
                const messagesRef = query(ref(db, 'chats/' + chatId + '/messages'), limitToLast(50));

                onChildAdded(messagesRef, (snapshot) => {
                    const data = snapshot.val();
                    const key = snapshot.key;

                    // Update Sidebar Content Preview & Time
                    const lastMsgEl = document.getElementById(`last_msg_${otherId}`);
                    const lastTimeEl = document.getElementById(`last_time_${otherId}`);
                    if (lastMsgEl) {
                        let text = data.text ? data.text : (data.type ? data.type.charAt(0).toUpperCase() + data.type.slice(1) : 'Media');
                        lastMsgEl.textContent = text;
                    }
                    if (lastTimeEl && data.time) {
                        const date = new Date(data.time * 1000);
                        lastTimeEl.textContent = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                    }

                    // If message is for me, and I am not currently looking at this chat, mark it as delivered
                    if (data.sender_id != window.myUserId && data.status === 'sent') {
                        if (window.currentChatId !== chatId) {
                            update(ref(db, `chats/${chatId}/messages/${key}`), { status: 'delivered' });

                            // Increment Unread Badge
                            const badge = document.getElementById(`unread_badge_${otherId}`);
                            if (badge) {
                                let count = parseInt(badge.textContent) || 0;
                                badge.textContent = count + 1;
                                badge.classList.remove('hidden');
                                badge.classList.add('flex');
                            }
                        }
                    }
                });
            });
        }

        // SVG Ticks Helper
        window.toggleSearchPanel = function () {
            const sidebar = document.getElementById('search_sidebar');
            sidebar.classList.toggle('hidden');
            if (!sidebar.classList.contains('hidden')) {
                document.getElementById('search_messages_input').focus();
                document.getElementById('no_results_text').querySelector('p').textContent = `Search for messages with ${document.getElementById('active_chat_title').textContent}`;
            }
        };

        window.clearMessageSearch = function () {
            const input = document.getElementById('search_messages_input');
            input.value = '';
            document.getElementById('clear_search_btn').classList.add('hidden');
            document.getElementById('search_results_list').innerHTML = '';
            document.getElementById('no_results_text').classList.remove('hidden');
            input.focus();
        };

        window.performMessageSearch = function (query) {
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
                    results.push({ ...msg, key });
                }
            }

            // Sort results by time descending
            results.sort((a, b) => b.time - a.time);

            renderMessageSearchResults(results, searchTerm);
        };

        window.renderMessageSearchResults = function (results, searchTerm) {
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
                    resultsList.insertAdjacentHTML('beforeend', `<div class="px-6 py-4 text-[#8696a0] text-[13px] font-medium">${date}</div>`);
                }

                // Highlight search term
                const regex = new RegExp(`(${searchTerm})`, 'gi');
                const highlightedText = msg.text.replace(regex, '<span class="text-[#00a884] font-medium">$1</span>');
                const time = new Date(msg.time * 1000).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
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

        window.scrollToMessage = function (key) {
            const el = document.getElementById('msg_' + key);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                el.classList.add('bg-[#00a884]/20');
                setTimeout(() => {
                    el.classList.remove('bg-[#00a884]/20');
                }, 2000);
            }
        };


        // Calendar Logic
        let currentCalendarDate = new Date();

        window.toggleCalendar = function () {
            const modal = document.getElementById('calendar_modal');
            modal.classList.toggle('hidden');
            if (!modal.classList.contains('hidden')) {
                renderCalendar(currentCalendarDate);
            }
        };

        window.changeCalendarMonth = function (delta) {
            currentCalendarDate.setMonth(currentCalendarDate.getMonth() + delta);
            renderCalendar(currentCalendarDate);
        };

        window.renderCalendar = function (date) {
            const grid = document.getElementById('calendar_days_grid');
            const monthYearText = document.getElementById('calendar_month_year');
            grid.innerHTML = '';

            const year = date.getFullYear();
            const month = date.getMonth();
            const monthName = date.toLocaleString('default', { month: 'long' });
            monthYearText.textContent = `${monthName} ${year}`;

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            // Prev month days
            const prevMonthDays = new Date(year, month, 0).getDate();
            for (let i = firstDay - 1; i >= 0; i--) {
                grid.insertAdjacentHTML('beforeend', `<span class="h-9 flex items-center justify-center text-[#54656f] text-sm select-none">${prevMonthDays - i}</span>`);
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
                grid.insertAdjacentHTML('beforeend', `<span class="h-9 flex items-center justify-center text-[#54656f] text-sm select-none">${i}</span>`);
            }
        };

        window.selectCalendarDate = function (day, month, year) {
            const selectedDateStr = `${year}-${(month + 1).toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
            jumpToDate(selectedDateStr);
            document.getElementById('calendar_modal').classList.add('hidden');
        };

        window.jumpToDate = function (targetDateStr) {
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

        window.getTickSVG = function (status) {
            if (status === 'read') {
                return `<svg viewBox="0 0 16 15" width="16" height="15" class="text-[#53bdeb]" fill="currentColor"><path d="M15,5.4L9.3,11.1l-1.3-1.4l5.7-5.7L15,5.4z M10.4,5.4L4.7,11.1L2,8.4L0.6,9.8l4.1,4.1l7.1-7.1L10.4,5.4z"></path></svg>`;
            } else if (status === 'delivered') {
                return `<svg viewBox="0 0 16 15" width="16" height="15" class="text-[#8696a0]" fill="currentColor"><path d="M15,5.4L9.3,11.1l-1.3-1.4l5.7-5.7L15,5.4z M10.4,5.4L4.7,11.1L2,8.4L0.6,9.8l4.1,4.1l7.1-7.1L10.4,5.4z"></path></svg>`;
            } else {
                return `<svg viewBox="0 0 16 11" width="16" height="11" class="text-[#8696a0]" fill="currentColor"><path d="M11.8,1.6L5.3,8.1L2.1,4.9l-1.5,1.5L5.3,11l8-8L11.8,1.6z"></path></svg>`;
            }
        };

        window.getDateHeader = function (timestamp) {
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
                return date.toLocaleDateString([], { weekday: 'long' });
            }

            return date.toLocaleDateString([], { day: '2-digit', month: '2-digit', year: 'numeric' });
        };

        window.formatAboutSubtitle = function (raw) {
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
                    datePart = date.toLocaleDateString([], { weekday: 'long' });
                } else {
                    datePart = date.toLocaleDateString([], { day: '2-digit', month: '2-digit', year: 'numeric' });
                }
            }

            if (type === 'UPDATED') {
                return `Last updated ${datePart} at ${formatTime(date)}`;
            } else {
                return `Until ${datePart} at ${formatTime(date)}`;
            }
        };

        window.getFileExt = function (filename) {
            if (!filename) return 'DOC';
            let parts = filename.split('.');
            return parts.length > 1 ? parts.pop().toUpperCase().substring(0, 4) : 'DOC';
        };

        window.getFileColor = function (filename) {
            const ext = window.getFileExt(filename).toLowerCase();
            if (ext === 'pdf') return '#e53935';
            if (ext.startsWith('doc')) return '#1e88e5';
            if (ext.startsWith('xls') || ext === 'csv') return '#43a047';
            if (ext.startsWith('ppt')) return '#fb8c00';
            if (ext === 'zip' || ext === 'rar') return '#8e24aa';
            if (ext === 'txt') return '#757575';
            return '#607d8b';
        };

        window.showChats = function () {
            const panel = document.getElementById('settings_panel');
            if (panel && !panel.classList.contains('hidden')) {
                window.toggleSettings();
            }
        };

        window.focusSearch = function () {
            const input = document.getElementById('sidebar_search');
            if (input) {
                input.focus();
            }
        };

        window.backToSidebar = function () {
            document.getElementById('user_sidebar_container').classList.remove('hidden');
            document.getElementById('user_sidebar_container').classList.add('flex', 'w-full');
            document.getElementById('main_chat_column').classList.add('hidden');
            document.getElementById('main_chat_column').classList.remove('flex');
        };

        window.selectChat = function (otherUserId, name, phone, avatar = null, about = null) {
            // Show content, hide empty state
            document.getElementById('chat_empty_state')?.classList.add('hidden');
            document.getElementById('active_chat_content')?.classList.remove('hidden');
            document.getElementById('active_chat_content')?.classList.add('flex');

            // Close settings if open
            const panel = document.getElementById('settings_panel');
            if (panel && !panel.classList.contains('hidden')) {
                window.toggleSettings();
            }

            // Mobile view handling
            if (window.innerWidth < 640) {
                document.getElementById('user_sidebar_container').classList.add('hidden');
                document.getElementById('main_chat_column').classList.remove('hidden');
                document.getElementById('main_chat_column').classList.add('flex');
            }

            let unsubscribeChanged = null;
            let lastDateString = null;
            if (unsubscribeAdded) unsubscribeAdded();
            if (unsubscribeRemoved) unsubscribeRemoved();
            if (statusUnsubscribe) statusUnsubscribe();

            const myId = window.myUserId;
            const minId = Math.min(myId, otherUserId);
            const maxId = Math.max(myId, otherUserId);
            window.currentChatId = `chat_${minId}_${maxId}`;

            const activeName = name ? name : phone;
            window.activeChatName = activeName;

            // Use provided avatar or fallback to UI-Avatar
            const activeAvatar = avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(activeName)}&background=202c33&color=fff`;
            window.activeChatAvatar = activeAvatar;

            window.activeChatUser = {
                id: otherUserId,
                name: activeName,
                phone: phone,
                avatar: activeAvatar,
                about: about || 'Available'
            };

            document.getElementById('active_chat_title').textContent = activeName;
            document.getElementById('active_chat_subtitle').classList.add('hidden');
            document.getElementById('active_chat_avatar').innerHTML = `<img src="${activeAvatar}" class="w-full h-full object-cover">`;

            // Update Call Dropdown
            document.getElementById('call_dropdown_name').textContent = activeName;
            document.getElementById('call_dropdown_avatar').innerHTML = `<img src="${activeAvatar}" class="w-full h-full object-cover">`;

            // Reset Unread Badge for this user
            const badge = document.getElementById(`unread_badge_${otherUserId}`);
            if (badge) {
                badge.textContent = '0';
                badge.classList.add('hidden');
                badge.classList.remove('flex');
            }

            // Listen to other user's status
            const otherUserStatusRef = ref(db, `status/${otherUserId}`);
            statusUnsubscribe = onValue(otherUserStatusRef, (snapshot) => {
                const data = snapshot.val();
                const subtitle = document.getElementById('active_chat_subtitle');

                // Update global activeChatUser with latest about info
                if (data && window.activeChatUser && window.activeChatUser.id == otherUserId) {
                    if (data.about) {
                        window.activeChatUser.about = data.about;
                    }

                    // If Contact Info panel is open and showing this user, update it live
                    const panel = document.getElementById('contact_info_panel');
                    if (panel && !panel.classList.contains('translate-x-full')) {
                        const aboutText = document.getElementById('contact_about_text');
                        if (aboutText) aboutText.textContent = window.activeChatUser.about;
                    }
                }

                if (data && data.state === 'online') {
                    subtitle.textContent = 'online';
                    subtitle.classList.remove('hidden', 'text-gray-500');
                    subtitle.classList.add('text-green-600');
                } else {
                    let text = 'offline';
                    if (data && data.last_changed) {
                        const date = new Date(data.last_changed);
                        text = 'last seen ' + date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                    }
                    subtitle.textContent = text;
                    subtitle.classList.remove('hidden', 'text-green-600');
                    subtitle.classList.add('text-gray-500');
                }
            });

            document.getElementById('messages').innerHTML = '';
            window.globalMessages = {};

            const messagesRef = ref(db, 'chats/' + window.currentChatId + '/messages');

            unsubscribeAdded = onChildAdded(messagesRef, (snapshot) => {
                const data = snapshot.val();
                const key = snapshot.key;
                window.globalMessages[key] = data; // store for reply/forward

                // Date Header Logic
                const dateHeader = window.getDateHeader(data.time);
                if (dateHeader !== lastDateString) {
                    lastDateString = dateHeader;
                    const headerHtml = `
                        <div class="flex justify-center my-3 sticky top-0 z-[5]">
                            <div class="bg-[#d1d7db]/90 backdrop-blur-sm text-[#54656f] text-[11px] px-3 py-1 rounded-lg shadow-sm font-semibold uppercase tracking-wider">
                                ${dateHeader}
                            </div>
                        </div>`;
                    document.getElementById('messages').insertAdjacentHTML('beforeend', headerHtml);
                }

                // If message is from other user and not read, mark it as read since chat is open
                if (data.sender_id != window.myUserId && data.status !== 'read') {
                    if (document.visibilityState === 'visible') {
                        update(ref(db, `chats/${window.currentChatId}/messages/${key}`), { status: 'read' });
                    } else if (data.status === 'sent') {
                        // Chat is selected but tab is hidden, so it's delivered
                        update(ref(db, `chats/${window.currentChatId}/messages/${key}`), { status: 'delivered' });
                    }
                }

                const isMe = data.sender_id == window.myUserId;
                const time = new Date(data.time * 1000).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                let mediaContent = '';
                if (data.type === 'image' && data.file_url) {
                    mediaContent = `<img src="${data.file_url}" class="max-w-[200px] sm:max-w-xs rounded-lg mb-2 object-cover cursor-pointer hover:opacity-90" onclick="window.open('${data.file_url}', '_blank')">`;
                } else if (data.type === 'video' && data.file_url) {
                    mediaContent = `<video src="${data.file_url}" controls class="max-w-[200px] sm:max-w-xs rounded-lg mb-2"></video>`;
                } else if (data.type === 'audio' && data.file_url) {
                    mediaContent = `<audio src="${data.file_url}" controls class="max-w-[200px] sm:max-w-xs mb-2"></audio>`;
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
                } else if ((data.type === 'location' || data.type === 'live_location') && data.lat && data.lng) {
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
                        const statusText = diff > 0 ? `Live until ${endTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}` : 'Live location ended';
                        mediaContent += `<div class="text-xs text-gray-500 mb-1 italic px-1">${statusText}</div>`;
                    }
                }

                let replyBlock = '';
                if (data.reply_to_text) {
                    replyBlock = `
                    <div class="bg-black/5 border-l-4 ${isMe ? 'border-green-600' : 'border-blue-500'} rounded p-2 mb-2 text-sm overflow-hidden opacity-80 cursor-pointer">
                        <div class="font-semibold ${isMe ? 'text-green-700' : 'text-blue-600'} text-xs">Replied Message</div>
                        <div class="text-gray-700 truncate">${data.reply_to_text}</div>
                    </div>`;
                }

                const html = `
                    <div class="relative group/msg w-full flex ${isMe ? 'justify-end' : 'justify-start'} mt-1 mb-2 px-2 transition-colors cursor-pointer select-none" id="msg_${key}" onclick="window.toggleMsgSelection('${key}')">

                        <!-- Selection Checkbox (Hidden by default) -->
                        <div class="msg-checkbox-container hidden flex-col justify-center px-3 z-10 ${isMe ? 'order-first' : ''}">
                            <div class="w-5 h-5 border-2 border-gray-400 rounded-md flex items-center justify-center bg-white">
                                <input type="checkbox" id="checkbox_${key}" class="msg-checkbox opacity-0 absolute w-5 h-5 pointer-events-none">
                                <svg class="w-4 h-4 text-white pointer-events-none transition-opacity opacity-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        </div>

                        <style>
                            #checkbox_${key}:checked + svg { opacity: 1; }
                        </style>

                        <div id="bubble_${key}" class="max-w-[85%] relative px-3 py-1.5 shadow-sm rounded-lg ${isMe ? 'bg-[#d9fdd3] rounded-tr-none order-last' : 'bg-white rounded-tl-none order-last'} transform transition-transform group-active/msg:scale-[0.98]">

                            <!-- Options Chevron -->
                            <button onclick="event.stopPropagation(); toggleMsgMenu('${key}')" class="absolute top-1 ${isMe ? 'right-2' : 'right-2'} text-gray-500 opacity-0 group-hover/msg:opacity-100 transition-opacity p-1 bg-white/50 backdrop-blur-sm rounded-full hover:bg-black/10 shadow-sm z-10 focus:outline-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <!-- Menu Dropdown -->
                            <div id="menu_${key}" class="hidden absolute top-8 ${isMe ? 'right-0' : 'left-0'} bg-white shadow-xl border border-gray-100 rounded-xl w-32 py-1 z-50 overflow-hidden transform transition-all duration-200">
                                <button onclick="event.stopPropagation(); replyTo('${key}')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center justify-between">Reply <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg></button>
                                <button onclick="event.stopPropagation(); forwardMsg('${key}')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center justify-between">Forward <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></button>
                                <div class="h-px bg-gray-100 my-1"></div>
                                <button onclick="event.stopPropagation(); deleteMsg('${key}')" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center justify-between">Delete <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                            </div>

                            ${replyBlock}
                            ${mediaContent}
                            <div class="flex items-end gap-3 text-right justify-between w-full min-w-0 pr-4 mt-1">
                                ${data.text ? `<span class="text-[15px] text-gray-900 break-words flex-1 text-left">${data.text}</span>` : '<div></div>'}
                                <div class="flex items-center gap-1 self-end leading-none">
                                    <span class="text-[10px] text-gray-500 whitespace-nowrap">${time}</span>
                                    ${isMe ? `<span id="tick_${key}" class="shrink-0 flex items-center justify-center">${window.getTickSVG(data.status || 'sent')}</span>` : ''}
                                </div>
                            </div>
                        </div>
                    </div>`;
                document.getElementById('messages').insertAdjacentHTML('beforeend', html);
                scrollToBottom();
            });

            unsubscribeRemoved = onChildRemoved(messagesRef, (snapshot) => {
                const key = snapshot.key;
                const msgEl = document.getElementById('msg_' + key);
                if (msgEl) msgEl.remove();
                delete window.globalMessages[key];
            });

            unsubscribeChanged = onChildChanged(messagesRef, (snapshot) => {
                const data = snapshot.val();
                const key = snapshot.key;
                window.globalMessages[key] = data;

                const isMe = data.sender_id == window.myUserId;
                if (isMe) {
                    const tickEl = document.getElementById('tick_' + key);
                    if (tickEl) {
                        tickEl.innerHTML = window.getTickSVG(data.status || 'sent');
                    }
                }
            });
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
        window.selectedMessages = new Set();

        window.cancelSelection = function () {
            window.isSelectionMode = false;
            window.selectedMessages.clear();
            document.getElementById('normal_header').classList.remove('hidden');
            document.getElementById('selection_header').classList.add('hidden');
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
            if (confirm('Delete ' + window.selectedMessages.size + ' message(s)?')) {
                window.selectedMessages.forEach(key => {
                    // Firebase actual delete:
                    remove(ref(db, 'chats/' + window.currentChatId + '/messages/' + key)).catch(e => {
                        console.error('Delete error:', e);
                        alert('Failed to delete message. Check console for details.');
                    });
                });
                window.cancelSelection();
            }
        };

        window.toggleMsgSelection = function (key) {
            if (!window.isSelectionMode) return;
            const checkbox = document.getElementById('checkbox_' + key);
            const msgEl = document.getElementById('msg_' + key);
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
                document.getElementById('selection_count').textContent = window.selectedMessages.size + ' Selected';
            }
        };

        // Activates selection mode starting with chosen message
        window.deleteMsg = function (key) {
            document.getElementById('menu_' + key)?.classList.add('hidden');
            document.getElementById('bubble_' + key).style.zIndex = '';
            document.getElementById('msg_' + key).style.zIndex = '';

            window.isSelectionMode = true;
            document.getElementById('normal_header').classList.add('hidden');
            document.getElementById('selection_header').classList.remove('hidden');
            document.getElementById('selection_header').classList.add('flex');

            // Show all checkboxes
            document.querySelectorAll('.msg-checkbox-container').forEach(el => el.classList.remove('hidden'));

            // Pre-select the message that triggered it
            const checkbox = document.getElementById('checkbox_' + key);
            if (checkbox && !checkbox.checked) {
                // Manually trigger so it doesn't double toggle
                checkbox.checked = true;
                window.selectedMessages.add(key);
                document.getElementById('msg_' + key).classList.add('bg-blue-100', 'bg-opacity-50');
                document.getElementById('selection_count').textContent = window.selectedMessages.size + ' Selected';

                const box = checkbox.parentElement;
                box.classList.add('bg-[#0d9488]', 'border-[#0d9488]');
                box.classList.remove('bg-white', 'border-gray-400');
            }
        };
    </script>
</x-app-layout>
