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
        </style>
    @endpush

    <div class="flex w-full max-w-[1400px] h-[100vh] sm:h-[95vh] sm:py-4 sm:px-4 mx-auto overflow-hidden shadow-xl sm:rounded-xl">
        <div class="flex w-full h-full bg-white sm:rounded-xl overflow-hidden border border-gray-200">

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

            <div class="flex flex-col w-full sm:w-[70%] h-full relative">
                <div
                    class="h-16 bg-gray-100 px-4 border-b border-gray-200 shrink-0 shadow-sm z-10 relative overflow-hidden">
                    <!-- Normal Header -->
                    <div id="normal_header" class="flex items-center gap-4 h-full w-full transition-all duration-300">
                        <div id="active_chat_avatar"
                            class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 font-bold shadow-sm overflow-hidden">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 id="active_chat_title" class="text-sm font-semibold text-gray-800">Select a chat</h2>
                            <p id="active_chat_subtitle" class="text-xs text-green-600 font-medium hidden">online</p>
                        </div>
                    </div>

                    <!-- Selection Header -->
                    <div id="selection_header"
                        class="absolute inset-0 bg-teal-600 flex items-center justify-between px-4 h-full w-full transform -translate-y-full transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <button onclick="cancelSelection()"
                                class="text-white hover:bg-black/10 p-2 rounded-full transition-colors focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                            <span id="selection_count" class="text-white font-semibold text-lg">1 Selected</span>
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

                <div id="messages" class="flex-1 overflow-y-auto p-4 chat-bg space-y-1 scroll-smooth">
                </div>

                <div class="h-auto min-h-[64px] bg-gray-100 px-4 py-2 flex flex-col justify-end shrink-0 relative z-20">
                    <!-- Replying Block -->
                    <div id="replying_to_block"
                        class="hidden bg-gray-200/80 backdrop-blur-sm border-l-4 border-green-500 px-4 py-2 mb-2 rounded-xl shadow-sm flex justify-between items-center group cursor-pointer transition-all">
                        <div class="flex flex-col overflow-hidden">
                            <span class="font-semibold text-green-600 text-[13px]">Replying to message</span>
                            <span id="replying_to_text"
                                class="text-gray-600 text-sm truncate max-w-[200px] sm:max-w-md"></span>
                        </div>
                        <button onclick="cancelReply()"
                            class="text-gray-400 hover:text-red-500 p-1.5 rounded-full hover:bg-gray-300 focus:outline-none transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="flex items-center gap-3 w-full">
                        <input type="file" id="file_input" class="hidden">
                        <div class="relative">
                            <button type="button" onclick="toggleAttachMenu()"
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
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
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
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <span class="text-gray-300 text-xs">Poll</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="text" id="msg" onkeypress="handleKeyPress(event)" placeholder="Type a message..."
                            class="flex-1 bg-white border-none rounded-lg px-4 py-2 text-sm focus:ring-0 shadow-sm">
                        <button onclick="send()"
                            class="bg-green-500 hover:bg-green-600 text-white rounded-full p-2 shadow-sm">
                            <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
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
    </script>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
        import { getDatabase, ref, onChildAdded, remove, onChildRemoved } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-database.js";
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
        window.myUserId = {{ auth()->id() ?? '0' }};
        window.currentChatId = null;
        let unsubscribeAdded = null;
        let unsubscribeRemoved = null;

        window.selectChat = function (otherUserId, name, phone) {
            if (unsubscribeAdded) unsubscribeAdded();
            if (unsubscribeRemoved) unsubscribeRemoved();

            const myId = window.myUserId;
            const minId = Math.min(myId, otherUserId);
            const maxId = Math.max(myId, otherUserId);
            window.currentChatId = `chat_${minId}_${maxId}`;

            document.getElementById('active_chat_title').textContent = name ? name : phone;
            document.getElementById('active_chat_subtitle').classList.remove('hidden');
            document.getElementById('active_chat_avatar').innerHTML = `<img src="https://ui-avatars.com/api/?name=${encodeURIComponent(name ? name : phone)}&background=202c33&color=fff" class="w-full h-full object-cover">`;

            document.getElementById('messages').innerHTML = '';
            window.globalMessages = {};

            const messagesRef = ref(db, 'chats/' + window.currentChatId + '/messages');

            unsubscribeAdded = onChildAdded(messagesRef, (snapshot) => {
                const data = snapshot.val();
                const key = snapshot.key;
                window.globalMessages[key] = data; // store for reply/forward

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
                        <a href="${data.file_url}" target="_blank" class="flex items-center gap-2 p-2 bg-gray-50 rounded mb-2 hover:bg-gray-100 transition-colors border border-gray-200">
                            <svg class="w-6 h-6 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            <span class="text-sm text-blue-600 truncate max-w-[150px]" title="${data.file_name}">${data.file_name || 'Download File'}</span>
                        </a>`;
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
                                <span class="text-[10px] text-gray-500 whitespace-nowrap self-end leading-none">${time}</span>
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
        };

        // Handle Notifications Permissions and Token
        async function requestPermission() {
            console.log('Requesting permission...');
            const permission = await Notification.requestPermission();
            if (permission === 'granted') {
                console.log('Notification permission granted.');

                try {
                    // Get FCM Token
                    // NOTE: If you have a VAPID key, use it here: { vapidKey: '...' }
                    const currentToken = await getToken(messaging);
                    if (currentToken) {
                        console.log('FCM Token:', currentToken);
                        // Save token to server
                        const response = await fetch('/save-token', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                            body: JSON.stringify({ token: currentToken })
                        });
                        const result = await response.json();
                        console.log('Token save response:', result);
                    } else {
                        console.warn('No registration token available. Request permission to generate one.');
                    }
                } catch (err) {
                    console.error('An error occurred while retrieving token. ', err);
                }
            } else {
                console.warn('Unable to get permission to notify.');
            }
        }

        requestPermission();

        // Handle Foreground Messages
        onMessage(messaging, (payload) => {
            console.log('Message received. ', payload);
            alert(`New Notification: ${payload.notification.title}\n${payload.notification.body}`);
        });

        // Selection Logic
        window.isSelectionMode = false;
        window.selectedMessages = new Set();

        window.cancelSelection = function () {
            window.isSelectionMode = false;
            window.selectedMessages.clear();
            document.getElementById('normal_header').classList.remove('-translate-y-full');
            document.getElementById('selection_header').classList.add('-translate-y-full');
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
            document.getElementById('normal_header').classList.add('-translate-y-full');
            document.getElementById('selection_header').classList.remove('-translate-y-full');

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

        onChildAdded(ref(db, 'chats/' + chatId + '/messages'), (snapshot) => {
            const data = snapshot.val();
            const key = snapshot.key;
            window.globalMessages[key] = data; // store for reply/forward

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
                    <a href="${data.file_url}" target="_blank" class="flex items-center gap-2 p-2 bg-gray-50 rounded mb-2 hover:bg-gray-100 transition-colors border border-gray-200">
                        <svg class="w-6 h-6 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        <span class="text-sm text-blue-600 truncate max-w-[150px]" title="${data.file_name}">${data.file_name || 'Download File'}</span>
                    </a>`;
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
                            <span class="text-[10px] text-gray-500 whitespace-nowrap self-end leading-none">${time}</span>
                        </div>
                    </div>
                </div>`;
            document.getElementById('messages').insertAdjacentHTML('beforeend', html);
            scrollToBottom();
        });

        onChildRemoved(ref(db, 'chats/' + chatId + '/messages'), (snapshot) => {
            const key = snapshot.key;
            const msgEl = document.getElementById('msg_' + key);
            if (msgEl) msgEl.remove();
            delete window.globalMessages[key];
        });
    </script>
</x-app-layout>
