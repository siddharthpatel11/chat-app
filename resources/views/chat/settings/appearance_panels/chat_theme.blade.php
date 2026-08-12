<div id="chat_theme_panel" class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden absolute sm:relative z-20 top-0 left-0">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center justify-between shrink-0 border-b border-[#313d45]">
        <div class="flex items-center gap-6">
            <button onclick="toggleChatThemePanel()" class="text-[#aebac1] hover:text-white transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
            </button>
            <h2 class="text-[#e9edef] text-[19px] font-medium">Chat theme</h2>
        </div>
        <div class="relative">
            <button onclick="toggleChatThemeDropdown(event)" id="chat_theme_menu_btn" class="text-[#aebac1] hover:text-white transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M12 7a2 2 0 1 0-.001-4.001A2 2 0 0 0 12 7zm0 2a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 9zm0 6a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 15z"></path>
                </svg>
            </button>
            <!-- Dropdown -->
            <div id="chat_theme_menu_dropdown" class="hidden absolute right-0 top-10 w-48 bg-[#233138] rounded shadow-lg py-2 z-50 transform origin-top-right transition-transform scale-95 opacity-0">
                <div class="px-4 py-3 hover:bg-[#111b21] cursor-pointer text-[#d1d7db] text-[14px] flex items-center gap-3 transition-colors" onclick="resetChatTheme()">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M21 12a9 9 0 1 1-9-9c2.52 0 4.93 1 6.74 2.74L21 8"></path>
                        <path d="M21 3v5h-5"></path>
                    </svg>
                    Reset theme
                </div>
            </div>
        </div>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#0b141a] py-4 relative">
        <!-- Themes Section -->
        <div class="px-6 mb-6">
            <h3 class="text-[#8696a0] text-[14px] font-medium mb-4">Themes</h3>
            
            <div class="grid grid-cols-4 gap-2 mb-6" id="themes_grid">
                @php
                    $themes = [
                        ['id' => 't1', 'bg' => 'bg-gradient-to-b from-[#111b21] to-[#20052a]', 'custom' => '<div class="absolute inset-0 opacity-20" style="background-image: linear-gradient(#00a884 1px, transparent 1px), linear-gradient(90deg, #00a884 1px, transparent 1px); background-size: 10px 10px;"></div>', 'in' => 'bg-[#202c33]', 'out' => 'bg-[#005c4b]', 'bubbleColor' => '#005c4b'],
                        ['id' => 't2', 'isAi' => true],
                        ['id' => 't3', 'bg' => 'bg-[#111b21]', 'custom' => '<div class="absolute inset-0 opacity-[0.03]" style="background-image: url(\'data:image/svg+xml,%3Csvg xmlns=\\\'http://www.w3.org/2000/svg\\\' width=\\\'20\\\' height=\\\'20\\\'%3E%3Cpath d=\\\'M0 10 Q 5 0 10 10 T 20 10\\\' fill=\\\'none\\\' stroke=\\\'white\\\' stroke-width=\\\'0.5\\\'/%3E%3C/svg%3E\'); background-size: 20px 20px;"></div>', 'in' => 'bg-[#202c33]', 'out' => 'bg-[#005c4b]', 'bubbleColor' => '#005c4b'],
                        ['id' => 't4', 'bg' => 'bg-[#1a1a1a]', 'in' => 'bg-[#2a2a2a]', 'out' => 'bg-[#0a4768]', 'bubbleColor' => '#0a4768'],
                        ['id' => 't5', 'bg' => 'bg-gradient-to-tr from-[#988bc1] via-[#d6a4c2] to-[#8eb1d4]', 'in' => 'bg-[#3b3a3b]', 'out' => 'bg-[#373591]', 'bubbleColor' => '#373591'],
                        ['id' => 't6', 'bg' => 'bg-gradient-to-br from-[#c99bb3] to-[#e4a49c]', 'in' => 'bg-[#3b3a3b]', 'out' => 'bg-[#84277c]', 'bubbleColor' => '#84277c'],
                        ['id' => 't7', 'bg' => 'bg-gradient-to-bl from-[#dfb987] to-[#ba7c4c]', 'in' => 'bg-[#3b3a3b]', 'out' => 'bg-[#a34421]', 'bubbleColor' => '#a34421'],
                        ['id' => 't8', 'bg' => 'bg-gradient-to-t from-[#e9a4ac] via-[#6ba8bb] to-[#80add4]', 'in' => 'bg-[#3b3a3b]', 'out' => 'bg-[#1c786a]', 'bubbleColor' => '#1c786a'],
                        ['id' => 't9', 'bg' => 'bg-[#181a20]', 'in' => 'bg-[#2f333e]', 'out' => 'bg-[#0653c3]', 'bubbleColor' => '#0653c3'],
                        ['id' => 't10', 'bg' => 'bg-[#1f2022]', 'in' => 'bg-[#35363a]', 'out' => 'bg-[#1e74a8]', 'bubbleColor' => '#1e74a8'],
                        ['id' => 't11', 'bg' => 'bg-[#1a1919]', 'in' => 'bg-[#333333]', 'out' => 'bg-[#5b5b5b]', 'bubbleColor' => '#5b5b5b'],
                        ['id' => 't12', 'bg' => 'bg-[#181719]', 'in' => 'bg-[#2d2c2f]', 'out' => 'bg-[#6c4896]', 'bubbleColor' => '#6c4896'],
                        ['id' => 't13', 'bg' => 'bg-gradient-to-b from-[#8ab4d3] to-[#f4b6c3]', 'in' => 'bg-[#3b3a3b]', 'out' => 'bg-[#0d59a8]', 'bubbleColor' => '#0d59a8'],
                        ['id' => 't14', 'bg' => 'bg-gradient-to-t from-[#7f9fbf] to-[#c9dbe3]', 'in' => 'bg-[#3b3a3b]', 'out' => 'bg-[#517a41]', 'bubbleColor' => '#517a41'],
                        ['id' => 't15', 'bg' => 'bg-gradient-to-tr from-[#9fb4c2] to-[#456b82]', 'in' => 'bg-[#3b3a3b]', 'out' => 'bg-[#1b6b93]', 'bubbleColor' => '#1b6b93'],
                        ['id' => 't16', 'bg' => 'bg-gradient-to-b from-[#c0d0c3] to-[#8da892]', 'in' => 'bg-[#3b3a3b]', 'out' => 'bg-[#295631]', 'bubbleColor' => '#295631'],
                        ['id' => 't17', 'bg' => 'bg-[#120b1f]', 'custom' => '<div class="absolute inset-0 opacity-[0.05]" style="background-image: url(\'data:image/svg+xml,%3Csvg xmlns=\\\'http://www.w3.org/2000/svg\\\' width=\\\'20\\\' height=\\\'20\\\'%3E%3Cpath d=\\\'M0 10 Q 5 0 10 10 T 20 10\\\' fill=\\\'none\\\' stroke=\\\'white\\\' stroke-width=\\\'0.5\\\'/%3E%3C/svg%3E\'); background-size: 20px 20px;"></div>', 'in' => 'bg-[#322c3d]', 'out' => 'bg-[#43239a]', 'bubbleColor' => '#43239a'],
                        ['id' => 't18', 'bg' => 'bg-[#111b21]', 'custom' => '<div class="absolute inset-0 opacity-[0.05]" style="background-image: url(\'data:image/svg+xml,%3Csvg xmlns=\\\'http://www.w3.org/2000/svg\\\' width=\\\'20\\\' height=\\\'20\\\'%3E%3Cpath d=\\\'M0 10 Q 5 0 10 10 T 20 10\\\' fill=\\\'none\\\' stroke=\\\'white\\\' stroke-width=\\\'0.5\\\'/%3E%3C/svg%3E\'); background-size: 20px 20px;"></div>', 'in' => 'bg-[#202c33]', 'out' => 'bg-[#299557]', 'bubbleColor' => '#299557'],
                        ['id' => 't19', 'bg' => 'bg-[#261511]', 'custom' => '<div class="absolute inset-0 opacity-[0.05]" style="background-image: url(\'data:image/svg+xml,%3Csvg xmlns=\\\'http://www.w3.org/2000/svg\\\' width=\\\'20\\\' height=\\\'20\\\'%3E%3Cpath d=\\\'M0 10 Q 5 0 10 10 T 20 10\\\' fill=\\\'none\\\' stroke=\\\'white\\\' stroke-width=\\\'0.5\\\'/%3E%3C/svg%3E\'); background-size: 20px 20px;"></div>', 'in' => 'bg-[#3d312e]', 'out' => 'bg-[#af5d33]', 'bubbleColor' => '#af5d33'],
                        ['id' => 't20', 'bg' => 'bg-[#0a1c22]', 'custom' => '<div class="absolute inset-0 opacity-[0.05]" style="background-image: url(\'data:image/svg+xml,%3Csvg xmlns=\\\'http://www.w3.org/2000/svg\\\' width=\\\'20\\\' height=\\\'20\\\'%3E%3Cpath d=\\\'M0 10 Q 5 0 10 10 T 20 10\\\' fill=\\\'none\\\' stroke=\\\'white\\\' stroke-width=\\\'0.5\\\'/%3E%3C/svg%3E\'); background-size: 20px 20px;"></div>', 'in' => 'bg-[#26373d]', 'out' => 'bg-[#057973]', 'bubbleColor' => '#057973'],
                        ['id' => 't21', 'bg' => 'bg-[#2a1721]', 'custom' => '<div class="absolute inset-0 opacity-[0.05]" style="background-image: url(\'data:image/svg+xml,%3Csvg xmlns=\\\'http://www.w3.org/2000/svg\\\' width=\\\'20\\\' height=\\\'20\\\'%3E%3Cpath d=\\\'M0 10 Q 5 0 10 10 T 20 10\\\' fill=\\\'none\\\' stroke=\\\'white\\\' stroke-width=\\\'0.5\\\'/%3E%3C/svg%3E\'); background-size: 20px 20px;"></div>', 'in' => 'bg-[#473841]', 'out' => 'bg-[#b6245d]', 'bubbleColor' => '#b6245d'],
                        ['id' => 't22', 'bg' => 'bg-[#202324]', 'in' => 'bg-[#3b3f40]', 'out' => 'bg-[#697a82]', 'bubbleColor' => '#697a82'],
                        ['id' => 't23', 'bg' => 'bg-[#17181c]', 'in' => 'bg-[#34353a]', 'out' => 'bg-[#5b5b5b]', 'bubbleColor' => '#5b5b5b'],
                    ];
                @endphp

                @foreach($themes as $index => $theme)
                    @if(isset($theme['isAi']) && $theme['isAi'])
                        <!-- Create with AI Card -->
                        <div class="aspect-[1/1.6] rounded-xl bg-gradient-to-br from-[#282f48] to-[#201d36] flex flex-col items-center justify-center cursor-pointer hover:opacity-90 transition-opacity border border-transparent" onclick="toggleAiThemePanel()">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="white" class="mb-2">
                                <path d="M19 1l-1.26 2.75L15 5l2.74 1.26L19 9l1.25-2.74L23 5l-2.75-1.25zM9 4L6.5 9.5 1 12l5.5 2.5L9 20l2.5-5.5L17 12l-5.5-2.5zM19 15l-1.26 2.74L15 19l2.74 1.25L19 23l1.25-2.75L23 19l-2.75-1.25z"></path>
                            </svg>
                            <span class="text-white text-[12px] text-center leading-tight">Create<br>with AI</span>
                        </div>
                    @else
                        <!-- Normal Theme Card -->
                        <div id="theme-card-{{ $index }}" class="theme-card aspect-[1/1.6] rounded-[10px] {{ $theme['bg'] }} relative overflow-hidden cursor-pointer group hover:opacity-90 transition-opacity border-2 border-transparent" onclick="openThemePreview({{ $index }})">
                            {!! $theme['custom'] ?? '' !!}
                            
                            <!-- Mock Chat Bubbles -->
                            <div class="absolute inset-x-0 top-3 flex flex-col gap-1.5 px-2">
                                <div class="w-[85%] h-5 {{ $theme['in'] }} rounded-[6px] rounded-tl-none self-start relative z-10"></div>
                                <div class="w-[85%] h-5 {{ $theme['out'] }} rounded-[6px] rounded-tr-none self-end relative z-10"></div>
                            </div>

                            <!-- Active Checkmark -->
                            <div id="theme-check-{{ $index }}" class="theme-check hidden absolute bottom-1 right-1 w-5 h-5 bg-white rounded-full items-center justify-center shadow-sm z-20">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" class="text-black">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="text-[#8696a0] text-[14px]">
                The chat bubble and wallpaper will both change.
            </div>
        </div>

        <!-- Customize Section -->
        <div class="px-6 mt-8">
            <h3 class="text-[#8696a0] text-[14px] font-medium mb-3">Customize</h3>
            
            <div class="flex items-center justify-between cursor-pointer hover:bg-[#202c33] -mx-6 px-6 py-4 transition-colors" onclick="toggleChatBubblePanel()">
                <div class="flex items-center gap-5">
                    <div class="text-[#8696a0]">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            <line x1="7" y1="9" x2="17" y2="9"></line>
                        </svg>
                    </div>
                    <div class="text-[#e9edef] text-[16px]">Chat bubble</div>
                </div>
            </div>

            <div class="flex items-center justify-between cursor-pointer hover:bg-[#202c33] -mx-6 px-6 py-4 transition-colors" onclick="toggleChatWallpaperPanel()">
                <div class="flex items-center gap-5">
                    <div class="text-[#8696a0]">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                            <polyline points="21 15 16 10 5 21"></polyline>
                        </svg>
                    </div>
                    <div class="text-[#e9edef] text-[16px]">Wallpaper</div>
                </div>
            </div> <!-- Closes line 106 Wallpaper row -->
        </div> <!-- Closes line 91 Customize Section -->
    </div> <!-- Closes line 20 Scrollable Content -->

    <!-- Chat Bubble Settings Panel (Nested) -->
    <div id="chat_bubble_settings_panel" class="hidden absolute inset-0 z-30 flex-col bg-[#111b21] transition-transform duration-300 transform translate-x-full">
        <!-- Header -->
        <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
            <button onclick="toggleChatBubblePanel()" class="text-[#aebac1] hover:text-white transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
                </svg>
            </button>
            <h2 class="text-[#e9edef] text-[19px] font-semibold">Chat bubble</h2>
        </div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#0b141a] py-6 px-6">
            <div class="grid grid-cols-4 gap-y-6 gap-x-4 justify-items-center" id="settings_bubble_color_grid">
                <!-- Colors injected via JS -->
            </div>
        </div>
    </div>

    <!-- Create with Meta AI Panel (Nested) -->
    <div id="ai_theme_panel" class="hidden absolute inset-0 z-40 flex-col bg-[#111b21] transition-transform duration-300 transform translate-x-full">
        <!-- Header -->
        <div class="h-16 bg-[#202c33] px-6 flex items-center shrink-0 border-b border-[#313d45]">
            <button onclick="toggleAiThemePanel()" class="text-[#aebac1] hover:text-white transition-colors mr-6">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                </svg>
            </button>
            <div class="flex items-center gap-2">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="#a48cff" class="shrink-0">
                    <path d="M19 1l-1.26 2.75L15 5l2.74 1.26L19 9l1.25-2.74L23 5l-2.75-1.25zM9 4L6.5 9.5 1 12l5.5 2.5L9 20l2.5-5.5L17 12l-5.5-2.5zM19 15l-1.26 2.74L15 19l2.74 1.25L19 23l1.25-2.75L23 19l-2.75-1.25z"></path>
                </svg>
                <h2 class="text-[#e9edef] text-[16px] font-medium">Create with Meta AI</h2>
            </div>
        </div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] flex flex-col">
            <div class="p-4 flex gap-3">
                <button class="flex-1 bg-transparent border border-[#313d45] hover:bg-[#202c33] rounded-xl py-3 flex flex-col items-center justify-center gap-2 transition-colors" onclick="openAiInteractivePanel()">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="#25D366">
                        <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"></path>
                        <path d="M19 1l-1.26 2.75L15 5l2.74 1.26L19 9l1.25-2.74L23 5l-2.75-1.25z" fill="#25D366"></path>
                    </svg>
                    <span class="text-[#e9edef] text-[14px]">Create image</span>
                </button>
                <button class="flex-1 bg-transparent border border-[#313d45] hover:bg-[#202c33] rounded-xl py-3 flex flex-col items-center justify-center gap-2 transition-colors" onclick="document.getElementById('ai_edit_photo_input').click()">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="#25D366">
                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34a.9959.9959 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path>
                        <path d="M19 1l-1.26 2.75L15 5l2.74 1.26L19 9l1.25-2.74L23 5l-2.75-1.25z" fill="#25D366"></path>
                    </svg>
                    <span class="text-[#e9edef] text-[14px]">Edit photo</span>
                </button>
                <input type="file" id="ai_edit_photo_input" class="hidden" accept="image/*" onchange="window.showToast('Edit Photo', 'Gallery selected: ' + this.files[0].name)">
            </div>

            <!-- Grid -->
            <div class="px-4 pb-4 grid grid-cols-2 gap-3" id="ai_inspiration_grid">
                <!-- Hardcoded for now like the screenshot -->
                <div class="relative aspect-[3/4] rounded-xl overflow-hidden cursor-pointer group" onclick="setAiPrompt('Sweet storm')">
                    <img src="https://image.pollinations.ai/prompt/sweet%20storm?width=400&height=533&nologo=true&seed=42" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Sweet storm">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                    <div class="absolute bottom-3 left-3 right-3">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="white" class="mb-1">
                            <path d="M19 1l-1.26 2.75L15 5l2.74 1.26L19 9l1.25-2.74L23 5l-2.75-1.25zM9 4L6.5 9.5 1 12l5.5 2.5L9 20l2.5-5.5L17 12l-5.5-2.5zM19 15l-1.26 2.74L15 19l2.74 1.25L19 23l1.25-2.75L23 19l-2.75-1.25z"></path>
                        </svg>
                        <span class="text-white text-[13px] font-medium truncate block">Sweet storm</span>
                    </div>
                </div>
                <div class="relative aspect-[3/4] rounded-xl overflow-hidden cursor-pointer group" onclick="setAiPrompt('Mountain lake')">
                    <img src="https://image.pollinations.ai/prompt/mountain%20lake%20landscape?width=400&height=533&nologo=true&seed=10" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Mountain lake">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                    <div class="absolute bottom-3 left-3 right-3">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="white" class="mb-1">
                            <path d="M19 1l-1.26 2.75L15 5l2.74 1.26L19 9l1.25-2.74L23 5l-2.75-1.25zM9 4L6.5 9.5 1 12l5.5 2.5L9 20l2.5-5.5L17 12l-5.5-2.5zM19 15l-1.26 2.74L15 19l2.74 1.25L19 23l1.25-2.75L23 19l-2.75-1.25z"></path>
                        </svg>
                        <span class="text-white text-[13px] font-medium truncate block">Mountain lake</span>
                    </div>
                </div>
                <div class="relative aspect-[3/4] rounded-xl overflow-hidden cursor-pointer group" onclick="setAiPrompt('a rooftop garden')">
                    <img src="https://image.pollinations.ai/prompt/rooftop%20garden%20cityscape?width=400&height=533&nologo=true&seed=24" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="rooftop garden">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                    <div class="absolute bottom-3 left-3 right-3">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="white" class="mb-1">
                            <path d="M19 1l-1.26 2.75L15 5l2.74 1.26L19 9l1.25-2.74L23 5l-2.75-1.25zM9 4L6.5 9.5 1 12l5.5 2.5L9 20l2.5-5.5L17 12l-5.5-2.5zM19 15l-1.26 2.74L15 19l2.74 1.25L19 23l1.25-2.75L23 19l-2.75-1.25z"></path>
                        </svg>
                        <span class="text-white text-[13px] font-medium truncate block">a rooftop garden</span>
                    </div>
                </div>
                <div class="relative aspect-[3/4] rounded-xl overflow-hidden cursor-pointer group" onclick="setAiPrompt('a field of sunflowers')">
                    <img src="https://image.pollinations.ai/prompt/field%20of%20sunflowers%20sunset?width=400&height=533&nologo=true&seed=33" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="sunflowers">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                    <div class="absolute bottom-3 left-3 right-3">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="white" class="mb-1">
                            <path d="M19 1l-1.26 2.75L15 5l2.74 1.26L19 9l1.25-2.74L23 5l-2.75-1.25zM9 4L6.5 9.5 1 12l5.5 2.5L9 20l2.5-5.5L17 12l-5.5-2.5zM19 15l-1.26 2.74L15 19l2.74 1.25L19 23l1.25-2.75L23 19l-2.75-1.25z"></path>
                        </svg>
                        <span class="text-white text-[13px] font-medium truncate block">a field of sunflowers</span>
                    </div>
                </div>
            </div>

        </div>
        
        <!-- Bottom Input Box -->
        <div class="p-4 shrink-0 border-t border-[#313d45]">
            <div class="bg-[#2a2f32] rounded-full px-5 py-3.5 flex items-center gap-3">
                <input type="text" id="ai_prompt_input" class="bg-transparent outline-none border-none ring-0 focus:ring-0 focus:outline-none focus:border-none text-[#d1d7db] text-[15px] w-full placeholder-[#8696a0] p-0 m-0 shadow-none" placeholder="Describe an image..." onkeydown="handleAiInput(event)">
                <button onclick="submitAiPrompt()" class="text-[#8696a0] hover:text-[#00a884] transition-colors shrink-0">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- AI Interactive Panel (Full UI logic based on new screenshots) -->
    <div id="ai_interactive_panel" class="hidden absolute inset-0 z-50 flex-col bg-[#111b21] transition-transform duration-300 transform translate-x-full">
        <!-- Header -->
        <div class="h-16 px-6 flex items-center shrink-0 border-b border-transparent">
            <button onclick="closeAiInteractivePanel()" class="text-[#aebac1] hover:text-white transition-colors mr-6">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
            </button>
            <div class="flex items-center gap-2">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="#a48cff" class="shrink-0">
                    <path d="M19 1l-1.26 2.75L15 5l2.74 1.26L19 9l1.25-2.74L23 5l-2.75-1.25zM9 4L6.5 9.5 1 12l5.5 2.5L9 20l2.5-5.5L17 12l-5.5-2.5zM19 15l-1.26 2.74L15 19l2.74 1.25L19 23l1.25-2.75L23 19l-2.75-1.25z"></path>
                </svg>
                <h2 class="text-[#e9edef] text-[16px] font-medium">Create with Meta AI</h2>
            </div>
        </div>

        <!-- State 1: Create Image Input (Empty State) -->
        <div id="ai_state_input" class="flex-1 flex flex-col hidden">
            <!-- Chat Area -->
            <div class="flex-1 overflow-y-auto p-4 flex flex-col gap-4">
                <!-- AI Welcome Message -->
                <div class="flex items-start gap-3 mt-4">
                    <div class="w-8 h-8 rounded-full bg-[#1da0f2]/20 flex items-center justify-center flex-shrink-0">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="#1da0f2">
                            <path d="M19 1l-1.26 2.75L15 5l2.74 1.26L19 9l1.25-2.74L23 5l-2.75-1.25zM9 4L6.5 9.5 1 12l5.5 2.5L9 20l2.5-5.5L17 12l-5.5-2.5zM19 15l-1.26 2.74L15 19l2.74 1.25L19 23l1.25-2.75L23 19l-2.75-1.25z"></path>
                        </svg>
                    </div>
                    <div class="bg-[#202c33] rounded-2xl rounded-tl-none p-3 max-w-[85%] text-[15px] text-[#e9edef] shadow-sm">
                        Hi! I can generate custom chat themes for you. Describe what you'd like to see.
                    </div>
                </div>
                
                <!-- Examples -->
                <div class="flex flex-wrap gap-2 mt-2 ml-11">
                    <button onclick="setAiPrompt('A serene anime sunset over a calm ocean')" class="px-4 py-2 rounded-full bg-transparent border border-[#313d45] text-[14px] text-[#00a884] hover:bg-[#202c33] transition-colors">A serene anime sunset</button>
                    <button onclick="setAiPrompt('Cyberpunk city street in the rain, neon lights')" class="px-4 py-2 rounded-full bg-transparent border border-[#313d45] text-[14px] text-[#00a884] hover:bg-[#202c33] transition-colors">Cyberpunk city street</button>
                    <button onclick="setAiPrompt('Minimalist dark mode geometric patterns')" class="px-4 py-2 rounded-full bg-transparent border border-[#313d45] text-[14px] text-[#00a884] hover:bg-[#202c33] transition-colors">Minimalist geometric</button>
                </div>
            </div>
            
            <!-- Input Area (WhatsApp Style) -->
            <div class="p-3 bg-[#202c33] flex items-end gap-2">
                <div class="flex-1 bg-[#2a3942] rounded-3xl flex items-center px-2 py-1 min-h-[44px]">
                    <input type="text" id="ai_interactive_input" 
                           class="flex-1 bg-transparent border-none outline-none ring-0 focus:ring-0 focus:outline-none focus:border-none text-white text-[15px] px-3 placeholder-[#8696a0] shadow-none m-0" 
                           placeholder="Message Meta AI..."
                           onkeypress="if(event.key === 'Enter') submitAiInteractivePrompt()">
                </div>
                <button onclick="submitAiInteractivePrompt()" class="w-[44px] h-[44px] rounded-full bg-[#00a884] flex items-center justify-center text-white hover:bg-[#008f6f] transition-colors flex-shrink-0 shadow-md">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="translate-x-[-1px] translate-y-[1px]">
                        <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- State 2: Loading (Dotted Animation) -->
        <div id="ai_state_loading" class="flex-1 flex flex-col hidden">
            <div class="flex-1 flex flex-col items-center justify-center p-6 relative">
                <!-- Mock dotted animation using background pattern -->
                <div class="w-full max-w-[280px] aspect-[1/1.5] rounded-[24px] bg-[#1a2328] relative overflow-hidden flex items-center justify-center opacity-50 shadow-2xl">
                <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(#a48cff 2px, transparent 2px); background-size: 20px 20px; background-position: center; animation: pulse 1.5s infinite alternate;"></div>
                <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="#a48cff" stroke-width="1.5" class="z-10 animate-pulse">
                    <path d="M19 1l-1.26 2.75L15 5l2.74 1.26L19 9l1.25-2.74L23 5l-2.75-1.25zM9 4L6.5 9.5 1 12l5.5 2.5L9 20l2.5-5.5L17 12l-5.5-2.5zM19 15l-1.26 2.74L15 19l2.74 1.25L19 23l1.25-2.75L23 19l-2.75-1.25z"></path>
                </svg>
                </div>
            </div>
            <div class="p-4 mt-auto flex justify-center pb-8">
                <button onclick="cancelAiGeneration()" class="bg-[#2a2f32] hover:bg-[#3b4246] transition-colors rounded-full px-8 py-2.5 text-[#e9edef] text-[15px] font-medium">Cancel</button>
            </div>
        </div>

        <!-- State 3: Results (4-image swiper) -->
        <div id="ai_state_results" class="flex-1 flex flex-col hidden h-full overflow-hidden relative">
            <!-- Swiper Container -->
            <div class="flex-1 relative flex items-center justify-center overflow-hidden px-4 py-2" id="ai_carousel_container">
                <div id="ai_carousel_track" class="flex w-full h-full transition-transform duration-300 ease-in-out" style="transform: translateX(0%);">
                    <!-- Images injected here -->
                </div>
            </div>
            
            <!-- Pagination Dots -->
            <div class="flex justify-center gap-2 mb-6" id="ai_carousel_dots">
                <!-- Dots injected here -->
            </div>

            <!-- Action Buttons (Edit/Restyle) -->
            <div class="flex justify-center gap-12 mb-8">
                <div class="flex flex-col items-center gap-2 cursor-pointer group" onclick="editAiPrompt()">
                    <div class="w-12 h-12 rounded-full bg-[#2a2f32] group-hover:bg-[#3b4246] flex items-center justify-center transition-colors shadow-sm">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="white"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34a.9959.9959 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path></svg>
                    </div>
                    <span class="text-[#d1d7db] text-[13px] font-medium">Edit</span>
                </div>
                <div class="flex flex-col items-center gap-2 cursor-pointer group" onclick="restyleAiPrompt()">
                    <div class="w-12 h-12 rounded-full bg-[#2a2f32] group-hover:bg-[#3b4246] flex items-center justify-center transition-colors shadow-sm">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="white"><path d="M19 1l-1.26 2.75L15 5l2.74 1.26L19 9l1.25-2.74L23 5l-2.75-1.25zM9 4L6.5 9.5 1 12l5.5 2.5L9 20l2.5-5.5L17 12l-5.5-2.5zM19 15l-1.26 2.74L15 19l2.74 1.25L19 23l1.25-2.75L23 19l-2.75-1.25z"></path></svg>
                    </div>
                    <span class="text-[#d1d7db] text-[13px] font-medium">Restyle</span>
                </div>
            </div>

            <!-- Bottom Bar (Refresh / Confirm) -->
            <div class="px-6 py-4 flex justify-between items-center pb-8 border-t border-[#313d45] border-opacity-30">
                <button onclick="regenerateAiTheme()" class="w-12 h-12 rounded-full bg-[#2a2f32] hover:bg-[#3b4246] flex items-center justify-center transition-colors">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="white"><path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"></path></svg>
                </button>
                <button onclick="applyAiThemeSelection()" class="w-14 h-14 rounded-full bg-[#25D366] hover:bg-[#1EBE5D] flex items-center justify-center transition-colors shadow-lg">
                    <svg viewBox="0 0 24 24" width="28" height="28" fill="#111b21"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path></svg>
                </button>
            </div>
        </div>

        <!-- State 4: Edit Image -->
        <div id="ai_state_edit" class="flex-1 flex flex-col hidden h-full overflow-hidden absolute inset-0 z-50 bg-[#111b21]">
            <!-- Top Bar -->
            <div class="h-16 px-4 flex items-center justify-between shrink-0">
                <button onclick="closeAiEdit()" class="text-white p-2">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path></svg>
                </button>
                <button onclick="applyAiEdit()" class="w-10 h-10 rounded-full bg-white flex items-center justify-center hover:bg-gray-200 transition-colors">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="black" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </button>
            </div>
            
            <!-- Image Preview -->
            <div class="flex-1 p-4 flex items-center justify-center pb-2">
                <img id="ai_edit_preview_img" src="" class="w-full max-w-[280px] aspect-[9/16] object-cover rounded-[24px]">
            </div>
            
            <!-- Bottom Controls -->
            <div class="p-4 flex flex-col gap-4 mb-4">
                <!-- Pills -->
                <div class="flex gap-2 justify-center">
                    <button onclick="selectEditAction('Add', this)" class="edit-action-pill px-6 py-2 rounded-full bg-[#2a2f32] hover:bg-[#3b4246] text-white text-[14px] font-medium transition-colors">Add</button>
                    <button onclick="selectEditAction('Remove', this)" class="edit-action-pill px-6 py-2 rounded-full bg-[#2a2f32] hover:bg-[#3b4246] text-white text-[14px] font-medium transition-colors">Remove</button>
                    <button onclick="selectEditAction('Change', this)" class="edit-action-pill px-6 py-2 rounded-full bg-[#2a2f32] hover:bg-[#3b4246] text-white text-[14px] font-medium transition-colors">Change</button>
                </div>
                <!-- Input -->
                <div class="bg-[#2a2f32] rounded-full px-5 py-3">
                    <input type="text" id="ai_edit_input" class="bg-transparent border-none outline-none ring-0 focus:ring-0 focus:outline-none focus:border-none text-[#d1d7db] text-[15px] w-full placeholder-[#8696a0] p-0 m-0 shadow-none" placeholder="Describe edits..." onkeypress="if(event.key === 'Enter') applyAiEdit()">
                </div>
            </div>
        </div>

        <!-- State 5: Restyle Image -->
        <div id="ai_state_restyle" class="flex-1 flex flex-col hidden h-full overflow-hidden absolute inset-0 z-50 bg-[#111b21]">
            <!-- Top Bar -->
            <div class="h-16 px-4 flex items-center justify-between shrink-0">
                <button onclick="closeAiRestyle()" class="text-white p-2">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path></svg>
                </button>
                <button onclick="applyAiRestyle()" class="w-10 h-10 rounded-full bg-white flex items-center justify-center hover:bg-gray-200 transition-colors">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="black" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </button>
            </div>
            
            <!-- Image Preview -->
            <div class="flex-1 p-4 flex items-center justify-center pb-2">
                <img id="ai_restyle_preview_img" src="" class="w-full max-w-[280px] aspect-[9/16] object-cover rounded-[24px]">
            </div>
            
            <!-- Bottom Controls -->
            <div class="p-4 flex flex-col gap-4 mb-4">
                <!-- Categories (Scrollable) -->
                <div class="flex gap-2 overflow-x-auto custom-scrollbar pb-2">
                    <button class="px-4 py-1.5 rounded-full bg-[#1e3a2f] text-white text-[14px] font-medium whitespace-nowrap shrink-0">Featured</button>
                    <button class="px-4 py-1.5 rounded-full bg-[#2a2f32] text-[#8696a0] hover:text-white text-[14px] font-medium whitespace-nowrap shrink-0 transition-colors">Styles</button>
                    <button class="px-4 py-1.5 rounded-full bg-[#2a2f32] text-[#8696a0] hover:text-white text-[14px] font-medium whitespace-nowrap shrink-0 transition-colors">Moods</button>
                    <button class="px-4 py-1.5 rounded-full bg-[#2a2f32] text-[#8696a0] hover:text-white text-[14px] font-medium whitespace-nowrap shrink-0 transition-colors">Lighting</button>
                    <button class="px-4 py-1.5 rounded-full bg-[#2a2f32] text-[#8696a0] hover:text-white text-[14px] font-medium whitespace-nowrap shrink-0 transition-colors">Colors</button>
                </div>
                
                <!-- Style Chips (Scrollable) -->
                <div class="flex gap-3 overflow-x-auto custom-scrollbar pb-2 px-1">
                    <!-- 3D -->
                    <div class="flex flex-col items-center gap-2 cursor-pointer shrink-0 group" onclick="selectStyle('3D', this)">
                        <div class="w-[72px] h-[72px] rounded-xl overflow-hidden border-2 border-transparent group-hover:opacity-80 transition-opacity style-thumb bg-gradient-to-br from-gray-200 to-gray-500 shadow-inner flex items-center justify-center text-[24px]">
                            🧊
                        </div>
                        <span class="text-[#8696a0] text-[13px] font-medium transition-colors">3D</span>
                    </div>
                    <!-- Anime -->
                    <div class="flex flex-col items-center gap-2 cursor-pointer shrink-0 group" onclick="selectStyle('Anime', this)">
                        <div class="w-[72px] h-[72px] rounded-xl overflow-hidden border-2 border-transparent group-hover:opacity-80 transition-opacity style-thumb bg-gradient-to-br from-pink-300 to-purple-400 shadow-inner flex items-center justify-center text-[24px]">
                            🌸
                        </div>
                        <span class="text-[#8696a0] text-[13px] font-medium transition-colors">Anime</span>
                    </div>
                    <!-- Paper -->
                    <div class="flex flex-col items-center gap-2 cursor-pointer shrink-0 group" onclick="selectStyle('Papercraft', this)">
                        <div class="w-[72px] h-[72px] rounded-xl overflow-hidden border-2 border-transparent group-hover:opacity-80 transition-opacity style-thumb bg-gradient-to-br from-yellow-100 to-orange-300 shadow-inner flex items-center justify-center text-[24px]">
                            📄
                        </div>
                        <span class="text-[#8696a0] text-[13px] font-medium transition-colors">Paper</span>
                    </div>
                    <!-- Illustrated -->
                    <div class="flex flex-col items-center gap-2 cursor-pointer shrink-0 group" onclick="selectStyle('Illustrated', this)">
                        <div class="w-[72px] h-[72px] rounded-xl overflow-hidden border-2 border-transparent group-hover:opacity-80 transition-opacity style-thumb bg-gradient-to-br from-blue-300 to-green-300 shadow-inner flex items-center justify-center text-[24px]">
                            🎨
                        </div>
                        <span class="text-[#8696a0] text-[13px] font-medium transition-colors">Illustrated</span>
                    </div>
                     <!-- Low Poly -->
                    <div class="flex flex-col items-center gap-2 cursor-pointer shrink-0 group" onclick="selectStyle('Low Poly', this)">
                        <div class="w-[72px] h-[72px] rounded-xl overflow-hidden border-2 border-transparent group-hover:opacity-80 transition-opacity style-thumb bg-gradient-to-br from-purple-400 to-indigo-600 shadow-inner flex items-center justify-center text-[24px]">
                            💠
                        </div>
                        <span class="text-[#8696a0] text-[13px] font-medium transition-colors">Low Poly</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- Closes line 1 chat_theme_panel -->

<!-- Preview Overlay Panel -->
<div id="chat_theme_preview_panel" class="hidden flex-col h-full bg-[#111b21] absolute z-[100] top-0 right-0 transition-transform duration-300 transform translate-x-full" style="width: calc(100% - 350px);">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-4 flex items-center justify-between shrink-0 border-b border-[#313d45] z-40 relative">
        <div class="flex items-center gap-4">
            <button onclick="closeThemePreview()" class="text-[#aebac1] hover:text-white transition-colors p-2">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
            </button>
            <h2 class="text-[#e9edef] text-[19px] font-medium">Preview</h2>
        </div>
        <button onclick="applyCurrentPreviewTheme()" class="w-8 h-8 rounded-full bg-[#25D366] flex items-center justify-center hover:bg-[#22c35e] transition-colors">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="black" stroke-width="2.5">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </button>
    </div>

    <!-- Preview Area -->
    <div class="flex-1 relative overflow-hidden" id="preview_swipe_area">
        <!-- Wallpaper Background -->
        <div id="preview_wallpaper" class="absolute inset-0 transition-all duration-300"></div>
        
        <!-- Dimming Overlay -->
        <div id="preview_dim_overlay" class="absolute inset-0 bg-black pointer-events-none transition-opacity duration-100" style="opacity: 0.5;"></div>

        <!-- Chat Content -->
        <div class="absolute inset-0 flex flex-col p-4 pointer-events-none z-10">
            <!-- Today Badge -->
            <div class="flex justify-center mb-6">
                <div class="bg-[#182229]/80 backdrop-blur-sm text-[#8696a0] text-[12.5px] px-3 py-1 rounded-lg">
                    Today
                </div>
            </div>

            <!-- Incoming Message -->
            <div class="flex mb-4">
                <div id="preview_msg_in" class="bg-[#202c33] text-[#e9edef] text-[15px] p-2 px-3 rounded-xl rounded-tl-none max-w-[85%] shadow-sm relative transition-colors duration-300">
                    <div>Swipe left or right to preview more themes 🎨✨</div>
                    <div class="text-[#8696a0] text-[11px] text-right mt-1 ml-4 float-right">11:59 am</div>
                </div>
            </div>

            <!-- Outgoing Message -->
            <div class="flex justify-end mb-4">
                <div id="preview_msg_out" class="bg-[#005c4b] text-[#e9edef] text-[15px] p-2 px-3 rounded-xl rounded-tr-none max-w-[85%] shadow-sm relative transition-colors duration-300">
                    <div>This will replace your existing default chat theme. Only you see your chat themes.</div>
                    <div class="flex items-center justify-end gap-1 text-[#8696a0] mt-1 ml-4 float-right">
                        <span class="text-[11px]">11:59 am</span>
                        <svg viewBox="0 0 16 15" width="16" height="15" fill="none">
                            <path d="M15.01 3.316l-.478-.372a.365.365 0 0 0-.51.063L8.666 9.88a.32.32 0 0 1-.484.032l-.358-.325a.32.32 0 0 0-.484.032l-.378.48a.418.418 0 0 0 .036.54l1.32 1.267a.32.32 0 0 0 .484-.034l6.272-8.048a.366.366 0 0 0-.064-.512zm-4.1 0l-.478-.372a.365.365 0 0 0-.51.063L4.566 9.88a.32.32 0 0 1-.484.032L1.892 7.72a.366.366 0 0 0-.516.005l-.423.433a.364.364 0 0 0-.006.514l3.255 3.185a.32.32 0 0 0 .484-.033l6.272-8.048a.365.365 0 0 0-.063-.51z" fill="#53bdeb"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Controls UI overlay -->
        <div class="absolute bottom-0 inset-x-0 h-40 flex items-end justify-between p-6 z-20 pointer-events-none">
            
            <!-- Left: Color Picker Circle -->
            <div class="pointer-events-auto cursor-pointer" onclick="openBubbleColorPicker()">
                <div class="w-12 h-12 rounded-full border-2 border-white flex items-center justify-center p-[2px]">
                    <div id="preview_color_circle" class="w-full h-full rounded-full bg-[#005c4b] transition-colors duration-300"></div>
                </div>
            </div>

            <!-- Center: Pagination Dots -->
            <div id="preview_pagination_dots" class="flex gap-2 pb-3 pointer-events-auto overflow-hidden max-w-[200px] justify-center">
                <!-- Dots injected via JS -->
            </div>

            <!-- Right: Slider and Brightness icon -->
            <div class="flex flex-col items-center gap-4 pointer-events-auto">
                <!-- Custom Vertical Slider for Dimming -->
                <div class="relative w-8 h-40 bg-[#202c33] rounded-full flex flex-col items-center justify-end p-1 overflow-hidden" id="dim_slider_track">
                    <div id="dim_slider_fill" class="w-full bg-[#3b4a54] rounded-full absolute bottom-0 transition-all duration-75" style="height: 50%;"></div>
                    <!-- Thumb -->
                    <div id="dim_slider_thumb" class="w-10 h-10 rounded-full bg-white shadow-md absolute z-10 flex items-center justify-center cursor-ns-resize transition-all duration-75" style="bottom: calc(50% - 20px);">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-black">
                            <path d="M12 2a1 1 0 011 1v2a1 1 0 11-2 0V3a1 1 0 011-1zm0 16a1 1 0 011 1v2a1 1 0 11-2 0v-2a1 1 0 011-1zm8-9a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1zm-16 0a1 1 0 01-1-1H3a1 1 0 110 2h2a1 1 0 011-1zm13.071 7.071a1 1 0 011.414 0l1.414 1.414a1 1 0 01-1.414 1.414l-1.414-1.414a1 1 0 010-1.414zM4.929 4.929a1 1 0 011.414 0l1.414 1.414a1 1 0 01-1.414 1.414L4.929 6.343a1 1 0 010-1.414zm14.142 0a1 1 0 010 1.414l-1.414 1.414a1 1 0 01-1.414-1.414l1.414-1.414a1 1 0 011.414 0zM4.929 19.071a1 1 0 010-1.414l1.414-1.414a1 1 0 011.414 1.414l-1.414 1.414a1 1 0 01-1.414 0zM12 7a5 5 0 100 10 5 5 0 000-10zm0 2a3 3 0 110 6 3 3 0 010-6z"></path>
                        </svg>
                    </div>
                </div>
                <!-- Brightness Icon below slider -->
                <div id="preview_theme_toggle_btn" onclick="togglePreviewThemeMode()" class="w-12 h-12 bg-white rounded-full flex items-center justify-center mt-2 cursor-pointer hover:bg-gray-200 transition-colors">
                    <svg id="preview_theme_icon" viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="text-black">
                        <!-- Default: Sun Icon -->
                        <path d="M12 2a1 1 0 011 1v2a1 1 0 11-2 0V3a1 1 0 011-1zm0 16a1 1 0 011 1v2a1 1 0 11-2 0v-2a1 1 0 011-1zm8-9a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1zm-16 0a1 1 0 01-1-1H3a1 1 0 110 2h2a1 1 0 011-1zm13.071 7.071a1 1 0 011.414 0l1.414 1.414a1 1 0 01-1.414 1.414l-1.414-1.414a1 1 0 010-1.414zM4.929 4.929a1 1 0 011.414 0l1.414 1.414a1 1 0 01-1.414 1.414L4.929 6.343a1 1 0 010-1.414zm14.142 0a1 1 0 010 1.414l-1.414 1.414a1 1 0 01-1.414-1.414l1.414-1.414a1 1 0 011.414 0zM4.929 19.071a1 1 0 010-1.414l1.414-1.414a1 1 0 011.414 1.414l-1.414 1.414a1 1 0 01-1.414 0zM12 7a5 5 0 100 10 5 5 0 000-10zm0 2a3 3 0 110 6 3 3 0 010-6z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Bubble Color Picker Panel -->
        <div id="bubble_color_picker_panel" class="absolute inset-x-0 bottom-0 bg-[#0b141a] rounded-t-3xl z-[110] transition-transform duration-300 transform translate-y-full flex flex-col pointer-events-auto shadow-[0_-10px_40px_rgba(0,0,0,0.5)]" style="height: 70%;">
            <!-- Handle -->
            <div class="w-full flex justify-center py-4 shrink-0 cursor-pointer" onclick="closeBubbleColorPicker()">
                <div class="w-10 h-[5px] bg-[#3b4a54] rounded-full"></div>
            </div>
            
            <!-- Grid -->
            <div class="flex-1 overflow-y-auto custom-scrollbar px-6 pb-6 pt-2">
                <div class="grid grid-cols-4 sm:grid-cols-5 gap-y-6 gap-x-4 justify-items-center" id="bubble_color_grid">
                    <!-- Colors injected via JS -->
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // Pass PHP theme array to JS
    const chatThemes = @json($themes);
    let activeThemeIndex = 0; // Default active
    let previewIndex = 0;
    window.isPreviewDarkMode = true; // Default to dark mode

    window.toggleChatThemeDropdown = function(e) {
        if(e) e.stopPropagation();
        const dropdown = document.getElementById('chat_theme_menu_dropdown');
        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
            setTimeout(() => {
                dropdown.classList.remove('scale-95', 'opacity-0');
            }, 10);
        } else {
            dropdown.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                dropdown.classList.add('hidden');
            }, 150);
        }
    };

    window.resetChatTheme = function() {
        const currentUserId = window.myUserId || 'default';
        localStorage.removeItem(`whatsapp_chat_theme_${currentUserId}`);
        
        // Remove custom user/group wallpaper so theme applies globally
        if (window.activeChatUser && window.activeChatUser.id) {
            localStorage.removeItem(`custom_wallpaper_${currentUserId}_user_${window.activeChatUser.id}`);
        }
        if (window.currentGroupId) {
            localStorage.removeItem(`custom_wallpaper_${currentUserId}_group_${window.currentGroupId}`);
        }
        
        // Re-apply globally
        if (typeof window.applyGlobalWallpaper === 'function') {
            window.applyGlobalWallpaper();
        }
        
        // Update UI
        activeThemeIndex = 0;
        updateGridActiveState();
        
        const theme = chatThemes[0];
        const headerIndicator = document.getElementById('appearance_theme_header');
        if (headerIndicator) {
            headerIndicator.style.backgroundColor = theme.bubbleColor || theme.out.replace('bg-[', '').replace(']', '');
        }
        
        if (window.showToast) {
            window.showToast('Theme Reset', 'Chat theme has been reset to default');
        }
        
        window.toggleChatThemeDropdown();
    };

    // Close dropdown on outside click
    document.addEventListener('click', (e) => {
        const btn = document.getElementById('chat_theme_menu_btn');
        const dropdown = document.getElementById('chat_theme_menu_dropdown');
        if (dropdown && !dropdown.classList.contains('hidden') && !dropdown.contains(e.target) && e.target !== btn && !btn?.contains(e.target)) {
            window.toggleChatThemeDropdown();
        }
    });

    // Filter out the AI card which doesn't have a normal theme structure for the preview
    const previewableThemes = chatThemes.filter(t => !t.isAi);

    window.chatThemeSource = 'appearance'; // default
    window.toggleChatThemePanel = function(source) {
        if(source) window.chatThemeSource = source;
        const chatThemePanel = document.getElementById('chat_theme_panel');
        
        if (chatThemePanel.classList.contains('hidden')) {
            if (window.closeAllSettings) window.closeAllSettings();
            
            // Set active index based on saved theme
            const currentUserId = window.myUserId || 'default';
            const savedThemeStr = localStorage.getItem(`whatsapp_chat_theme_${currentUserId}`);
            if (savedThemeStr) {
                try {
                    const savedTheme = JSON.parse(savedThemeStr);
                    const idx = chatThemes.findIndex(t => t.id === savedTheme.id);
                    if (idx !== -1) activeThemeIndex = idx;
                } catch(e) {}
            }
            
            chatThemePanel.classList.remove('hidden');
            chatThemePanel.classList.add('flex');
            updateGridActiveState();
        } else {
            chatThemePanel.classList.add('hidden');
            chatThemePanel.classList.remove('flex');
            
            if (window.chatThemeSource === 'chats') {
                const chatsPanel = document.getElementById('chats_settings_panel');
                if (chatsPanel) {
                    chatsPanel.classList.remove('hidden');
                    chatsPanel.classList.add('flex');
                }
            } else {
                const appearancePanel = document.getElementById('appearance_settings_panel');
                if (appearancePanel) {
                    appearancePanel.classList.remove('hidden');
                    appearancePanel.classList.add('flex');
                }
            }
        }
    }

    // Initialize Grid UI state
    function updateGridActiveState() {
        chatThemes.forEach((theme, idx) => {
            if(theme.isAi) return;
            const card = document.getElementById(`theme-card-${idx}`);
            const check = document.getElementById(`theme-check-${idx}`);
            if(!card) return;

            // Reset borders
            card.classList.remove('border-white');
            card.classList.add('border-transparent');
            check.classList.add('hidden');
            check.classList.remove('flex');

            if (idx === activeThemeIndex) {
                card.classList.remove('border-transparent');
                card.classList.add('border-white');
                check.classList.remove('hidden');
                check.classList.add('flex');
            } else {
                card.classList.add('border-[#313d45]', 'border-opacity-50', 'hover:border-white');
            }
        });
    }

    window.applyCurrentPreviewTheme = function() {
        const theme = previewableThemes[previewIndex];
        if (theme) {
            // Find original index
            const originalIndex = chatThemes.findIndex(t => t.id === theme.id);
            if (originalIndex !== -1) {
                activeThemeIndex = originalIndex;
                updateGridActiveState();
                
                // Save it globally
                const currentUserId = window.myUserId || 'default';
                localStorage.setItem(`whatsapp_chat_theme_${currentUserId}`, JSON.stringify(theme));
                
                // Remove custom user/group wallpaper so theme applies globally
                if (window.activeChatUser && window.activeChatUser.id) {
                    localStorage.removeItem(`custom_wallpaper_${currentUserId}_user_${window.activeChatUser.id}`);
                }
                if (window.currentGroupId) {
                    localStorage.removeItem(`custom_wallpaper_${currentUserId}_group_${window.currentGroupId}`);
                }
                
                // Re-apply styles
                if (typeof window.applyGlobalWallpaper === 'function') {
                    window.applyGlobalWallpaper();
                }
                
                if (window.showToast) {
                    window.showToast('Theme Updated', 'Global chat theme applied');
                }
                
                closeThemePreview();
            }
        }
    }

    window.openThemePreview = function(originalIndex) {
        const theme = chatThemes[originalIndex];
        if (theme.isAi) return; // Handle AI separately if needed

        // Find the index in the previewable array
        previewIndex = previewableThemes.findIndex(t => t.id === theme.id);
        
        const previewPanel = document.getElementById('chat_theme_preview_panel');
        const sidebarPanel = document.getElementById('chat_theme_panel');
        
        // Dynamically set position so it covers exactly the right side
        if (sidebarPanel) {
            const updatePreviewLayout = () => {
                const rect = sidebarPanel.getBoundingClientRect();
                previewPanel.style.left = rect.right + 'px';
                previewPanel.style.width = 'auto';
            };
            updatePreviewLayout();
            
            if (!window.previewResizeObserver) {
                window.previewResizeObserver = new ResizeObserver(updatePreviewLayout);
            }
            window.previewResizeObserver.observe(sidebarPanel);
        }

        previewPanel.classList.remove('hidden');
        previewPanel.classList.add('flex');
        
        // Trigger reflow for transition
        void previewPanel.offsetWidth;
        previewPanel.classList.remove('translate-x-full');
        previewPanel.classList.add('translate-x-0');

        updatePreviewUI();
    }

    window.closeThemePreview = function() {
        const previewPanel = document.getElementById('chat_theme_preview_panel');
        const sidebarPanel = document.getElementById('chat_theme_panel');
        
        previewPanel.classList.remove('translate-x-0');
        previewPanel.classList.add('translate-x-full');
        
        if (window.previewResizeObserver && sidebarPanel) {
            window.previewResizeObserver.unobserve(sidebarPanel);
        }

        setTimeout(() => {
            previewPanel.classList.remove('flex');
            previewPanel.classList.add('hidden');
        }, 300); // Wait for transition
    }

    window.applyCurrentPreviewTheme = function() {
        const theme = previewableThemes[previewIndex];
        // Find original index
        activeThemeIndex = chatThemes.findIndex(t => t.id === theme.id);
        
        // Save to localStorage
        const currentUserId = window.myUserId || 'default';
        localStorage.setItem(`whatsapp_chat_theme_${currentUserId}`, JSON.stringify(theme));
        
        // Update Grid UI
        updateGridActiveState();

        // Update Appearance Panel UI (mock)
        const headerIndicator = document.getElementById('appearance_theme_header');
        if (headerIndicator) {
            headerIndicator.style.backgroundColor = theme.bubbleColor || theme.out.replace('bg-[', '').replace(']', '');
        }

        // Apply globally
        if (typeof window.applyGlobalWallpaper === 'function') {
            window.applyGlobalWallpaper();
        }

        window.showToast('Theme Applied', 'Your default chat theme has been updated.');
        
        // Close preview
        closeThemePreview();
    }

    window.togglePreviewThemeMode = function() {
        window.isPreviewDarkMode = !window.isPreviewDarkMode;
        updatePreviewUI();
    };

    function updatePreviewUI() {
        const theme = previewableThemes[previewIndex];
        if(!theme) return;

        let inClass = theme.in;
        let outClass = theme.out;
        let bgClass = theme.bg;
        let custom = theme.custom || '';
        let textClassIn = 'text-[#e9edef]';
        let textClassOut = 'text-[#e9edef]';
        let timeClassIn = 'text-[#8696a0]';
        let timeClassOut = 'text-[#8696a0]';
        let timeSvgColor = '#53bdeb';

        if (!window.isPreviewDarkMode) {
            // Incoming bubbles are always light in Light Mode
            inClass = 'bg-[#ffffff]';
            textClassIn = 'text-[#111b21]';
            timeClassIn = 'text-[#667781]';
            
            // If it's one of the default themes, switch to light default bg and green outgoing bubble
            if (theme.id === 't1' || theme.id === 't3' || theme.id === 't18') {
                bgClass = 'bg-[#efeae2]';
                custom = '<div class="absolute inset-0 opacity-[0.4]" style="background-image: url(https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png); background-size: auto; background-blend-mode: normal;"></div>';
                
                // Only override bubble color if it hasn't been customized!
                const originalBubbleColor = theme.id === 't18' ? '#299557' : '#005c4b';
                if (!theme.bubbleColor || theme.bubbleColor === originalBubbleColor) {
                    outClass = 'bg-[#d9fdd3]';
                    textClassOut = 'text-[#111b21]';
                    timeClassOut = 'text-[#667781]';
                }
            }
        }

        // Update Wallpaper
        const wp = document.getElementById('preview_wallpaper');
        // Clear old classes
        wp.className = `absolute inset-0 transition-all duration-300 ${bgClass}`;
        wp.innerHTML = custom;

        // Update Bubbles
        const msgIn = document.getElementById('preview_msg_in');
        const msgOut = document.getElementById('preview_msg_out');
        
        msgIn.className = `${textClassIn} text-[15px] p-2 px-3 rounded-xl rounded-tl-none max-w-[85%] shadow-sm relative transition-colors duration-300 ${inClass}`;
        msgOut.className = `${textClassOut} text-[15px] p-2 px-3 rounded-xl rounded-tr-none max-w-[85%] shadow-sm relative transition-colors duration-300 ${outClass}`;

        // Update time colors
        const timeDivIn = msgIn.querySelector('.float-right');
        const timeDivOut = msgOut.querySelector('.float-right');
        if(timeDivIn) timeDivIn.className = `${timeClassIn} text-[11px] text-right mt-1 ml-4 float-right`;
        if(timeDivOut) {
            timeDivOut.className = `flex items-center justify-end gap-1 ${timeClassOut} mt-1 ml-4 float-right`;
            const checkSvg = timeDivOut.querySelector('svg path');
            if(checkSvg) checkSvg.setAttribute('fill', timeSvgColor);
        }

        // Update Color Circle
        const circle = document.getElementById('preview_color_circle');
        circle.style.backgroundColor = theme.bubbleColor || theme.out.replace('bg-[', '').replace(']', '');

        // Update Sun/Moon icon & Dim Slider
        const iconSvg = document.getElementById('preview_theme_icon');
        const dimSlider = document.getElementById('dim_slider_track');
        if (window.isPreviewDarkMode) {
            // Show Sun icon (to switch to light)
            iconSvg.innerHTML = '<path d="M12 2a1 1 0 011 1v2a1 1 0 11-2 0V3a1 1 0 011-1zm0 16a1 1 0 011 1v2a1 1 0 11-2 0v-2a1 1 0 011-1zm8-9a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1zm-16 0a1 1 0 01-1-1H3a1 1 0 110 2h2a1 1 0 011-1zm13.071 7.071a1 1 0 011.414 0l1.414 1.414a1 1 0 01-1.414 1.414l-1.414-1.414a1 1 0 010-1.414zM4.929 4.929a1 1 0 011.414 0l1.414 1.414a1 1 0 01-1.414 1.414L4.929 6.343a1 1 0 010-1.414zm14.142 0a1 1 0 010 1.414l-1.414 1.414a1 1 0 01-1.414-1.414l1.414-1.414a1 1 0 011.414 0zM4.929 19.071a1 1 0 010-1.414l1.414-1.414a1 1 0 011.414 1.414l-1.414 1.414a1 1 0 01-1.414 0zM12 7a5 5 0 100 10 5 5 0 000-10zm0 2a3 3 0 110 6 3 3 0 010-6z"></path>';
            dimSlider.style.display = 'flex';
        } else {
            // Show Moon icon (to switch to dark)
            iconSvg.innerHTML = '<path d="M12 3a9 9 0 1 0 9 9c0-.46-.04-.92-.1-1.36a5.389 5.389 0 0 1-4.4 2.26 5.403 5.403 0 0 1-3.14-9.8c-.44-.06-.9-.1-1.36-.1z"></path>';
            dimSlider.style.display = 'none';
        }

        // Update Pagination Dots
        const dotsContainer = document.getElementById('preview_pagination_dots');
        const totalThemes = previewableThemes.length;
        
        let dotsHtml = '';
        for (let i = 0; i < totalThemes; i++) {
            const opacityClass = i === previewIndex ? 'opacity-100' : 'opacity-40';
            // Scale active dot slightly for better visual feedback
            const scaleClass = i === previewIndex ? 'scale-110' : 'scale-100';
            dotsHtml += `<div class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-white shrink-0 transition-all duration-300 ${opacityClass} ${scaleClass}"></div>`;
        }
        dotsContainer.innerHTML = dotsHtml;
        
        // Scroll the active dot into view if there are many dots (like 20)
        const activeDot = dotsContainer.children[previewIndex];
        if (activeDot) {
            activeDot.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }
    }

    // Slider Logic
    const sliderTrack = document.getElementById('dim_slider_track');
    const sliderThumb = document.getElementById('dim_slider_thumb');
    const sliderFill = document.getElementById('dim_slider_fill');
    const dimOverlay = document.getElementById('preview_dim_overlay');
    
    let isDraggingSlider = false;

    function setDimLevel(clientY) {
        const rect = sliderTrack.getBoundingClientRect();
        let y = clientY - rect.top;
        y = Math.max(0, Math.min(y, rect.height));
        
        // Calculate percentage from bottom
        const percentage = 100 - ((y / rect.height) * 100);
        
        sliderThumb.style.bottom = `calc(${percentage}% - 20px)`;
        sliderFill.style.height = `${percentage}%`;
        
        // Opacity mapping: 0% slider = 0 opacity, 100% slider = 0.8 opacity
        const opacity = (percentage / 100) * 0.8;
        dimOverlay.style.opacity = opacity;
    }

    sliderThumb.addEventListener('mousedown', (e) => {
        isDraggingSlider = true;
        e.preventDefault();
    });
    sliderThumb.addEventListener('touchstart', (e) => {
        isDraggingSlider = true;
        e.preventDefault(); // prevent scrolling
    });

    window.addEventListener('mousemove', (e) => {
        if(isDraggingSlider) setDimLevel(e.clientY);
    });
    window.addEventListener('touchmove', (e) => {
        if(isDraggingSlider) setDimLevel(e.touches[0].clientY);
    });

    window.addEventListener('mouseup', () => { isDraggingSlider = false; });
    window.addEventListener('touchend', () => { isDraggingSlider = false; });


    // Swipe Logic for Carousel
    const swipeArea = document.getElementById('preview_swipe_area');
    let touchStartX = 0;
    let touchEndX = 0;
    let isSwiping = false;

    // Touch Support
    swipeArea.addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].screenX;
    }, {passive: true});

    swipeArea.addEventListener('touchend', e => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, {passive: true});
    
    // Mouse Drag Support
    swipeArea.addEventListener('mousedown', e => {
        isSwiping = true;
        touchStartX = e.screenX;
    });

    swipeArea.addEventListener('mouseup', e => {
        if (!isSwiping) return;
        isSwiping = false;
        touchEndX = e.screenX;
        handleSwipe();
    });

    swipeArea.addEventListener('mouseleave', e => {
        if (!isSwiping) return;
        isSwiping = false;
        touchEndX = e.screenX;
        handleSwipe();
    });

    // Keyboard Arrow Support
    document.addEventListener('keydown', e => {
        const previewPanel = document.getElementById('chat_theme_preview_panel');
        if (previewPanel && !previewPanel.classList.contains('hidden')) {
            if (e.key === 'ArrowLeft') {
                touchStartX = 100;
                touchEndX = 0;
                handleSwipe();
            } else if (e.key === 'ArrowRight') {
                touchStartX = 0;
                touchEndX = 100;
                handleSwipe();
            }
        }
    });

    function handleSwipe() {
        const threshold = 50; // minimum distance to be considered a swipe
        if (touchEndX < touchStartX - threshold) {
            // Swipe Left -> Next Theme
            if (previewIndex < previewableThemes.length - 1) {
                previewIndex++;
                updatePreviewUI();
            }
        }
        if (touchEndX > touchStartX + threshold) {
            // Swipe Right -> Prev Theme
            if (previewIndex > 0) {
                previewIndex--;
                updatePreviewUI();
            }
        }
    }

    // Bubble Color Picker Logic
    const bubbleColors = [
        '#005c4b', '#0a4768', '#373591', '#84277c', '#a34421', '#1c786a',
        '#0653c3', '#1e74a8', '#5b5b5b', '#6c4896', '#0d59a8', '#517a41',
        '#1b6b93', '#295631', '#43239a', '#299557', '#af5d33', '#057973',
        '#b6245d', '#697a82', '#181a20', '#1f2022', '#2a1721', '#0a1c22'
    ];

    window.openBubbleColorPicker = function() {
        renderBubbleColorGrid();
        const panel = document.getElementById('bubble_color_picker_panel');
        panel.classList.remove('translate-y-full');
    };

    window.closeBubbleColorPicker = function() {
        const panel = document.getElementById('bubble_color_picker_panel');
        panel.classList.add('translate-y-full');
    };

    function renderBubbleColorGrid() {
        const grid = document.getElementById('bubble_color_grid');
        const theme = previewableThemes[previewIndex];
        const currentBubbleColor = theme.bubbleColor || theme.out.replace('bg-[', '').replace(']', '');
        
        grid.innerHTML = bubbleColors.map(color => {
            const isSelected = color === currentBubbleColor;
            return `
                <div class="w-12 h-12 rounded-full flex items-center justify-center cursor-pointer transition-transform hover:scale-110 shadow-sm"
                     style="background-color: ${color}; border: ${isSelected ? '3px solid white' : 'none'};"
                     onclick="selectBubbleColor('${color}')">
                     ${isSelected ? `<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="white" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>` : ''}
                </div>
            `;
        }).join('');
    }

    window.selectBubbleColor = function(color) {
        const theme = previewableThemes[previewIndex];
        theme.bubbleColor = color;
        theme.out = `bg-[${color}]`;
        
        updatePreviewUI();
        renderBubbleColorGrid();
    };

    // Global Bubble Color Picker Panel Logic
    window.toggleChatBubblePanel = function() {
        const panel = document.getElementById('chat_bubble_settings_panel');
        if (panel.classList.contains('translate-x-full')) {
            panel.classList.remove('hidden');
            // Small delay to allow display:block to apply before animating transform
            setTimeout(() => {
                panel.classList.remove('translate-x-full');
            }, 10);
            renderGlobalBubbleColorGrid();
        } else {
            panel.classList.add('translate-x-full');
            // Wait for animation to finish before hiding
            setTimeout(() => {
                panel.classList.add('hidden');
            }, 300);
        }
    };

    function renderGlobalBubbleColorGrid() {
        const grid = document.getElementById('settings_bubble_color_grid');
        
        const currentUserId = window.myUserId || 'default';
        const themeData = localStorage.getItem(`whatsapp_chat_theme_${currentUserId}`);
        let currentTheme = null;
        if (themeData) {
            try { currentTheme = JSON.parse(themeData); } catch(e){}
        }
        
        // If no theme, WhatsApp defaults to standard t1 bubble color
        const currentBubbleColor = currentTheme && currentTheme.bubbleColor ? currentTheme.bubbleColor : '#005c4b';
        
        grid.innerHTML = bubbleColors.map(color => {
            const isSelected = color === currentBubbleColor;
            return `
                <div class="w-12 h-12 rounded-full flex items-center justify-center cursor-pointer transition-transform hover:scale-110 shadow-sm"
                     style="background-color: ${color}; border: ${isSelected ? '3px solid white' : 'none'};"
                     onclick="setGlobalBubbleColor('${color}')">
                     ${isSelected ? `<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="white" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>` : ''}
                </div>
            `;
        }).join('');
    }

    window.setGlobalBubbleColor = function(color) {
        const currentUserId = window.myUserId || 'default';
        const themeData = localStorage.getItem(`whatsapp_chat_theme_${currentUserId}`);
        let currentTheme = null;
        if (themeData) {
            try { currentTheme = JSON.parse(themeData); } catch(e){}
        }
        
        if (!currentTheme) {
            // Default to t1 if no theme exists
            currentTheme = chatThemes.find(t => t.id === 't1') || chatThemes[0];
        }
        
        currentTheme.bubbleColor = color;
        currentTheme.out = `bg-[${color}]`;
        
        // Save back to localStorage
        localStorage.setItem(`whatsapp_chat_theme_${currentUserId}`, JSON.stringify(currentTheme));
        
        // Re-render grid to show active checkmark
        renderGlobalBubbleColorGrid();
        
        // Apply globally
        if (typeof window.applyGlobalWallpaper === 'function') {
            window.applyGlobalWallpaper();
        }
    };

    window.toggleAiThemePanel = function() {
        const panel = document.getElementById('ai_theme_panel');
        if (panel.classList.contains('translate-x-full')) {
            panel.classList.remove('hidden');
            panel.classList.add('flex');
            setTimeout(() => {
                panel.classList.remove('translate-x-full');
            }, 10);
        } else {
            panel.classList.add('translate-x-full');
            setTimeout(() => {
                panel.classList.add('hidden');
                panel.classList.remove('flex');
            }, 300);
        }
    };
   
    window.openAiInteractivePanel = function() {
        const panel = document.getElementById('ai_interactive_panel');
        panel.classList.remove('hidden');
        panel.classList.add('flex');
        setTimeout(() => {
            panel.classList.remove('translate-x-full');
        }, 10);
        showAiState('input');
        // Clear input
        document.getElementById('ai_interactive_input').value = '';
    };

    window.closeAiInteractivePanel = function() {
        const panel = document.getElementById('ai_interactive_panel');
        panel.classList.add('translate-x-full');
        setTimeout(() => {
            panel.classList.add('hidden');
            panel.classList.remove('flex');
            if(window.aiGenerationController) {
                window.aiGenerationController.abort();
            }
        }, 300);
    };

    window.showAiState = function(state) {
        document.getElementById('ai_state_input').classList.add('hidden');
        document.getElementById('ai_state_loading').classList.add('hidden');
        document.getElementById('ai_state_results').classList.add('hidden');
        
        if (state === 'input') {
            document.getElementById('ai_state_input').classList.remove('hidden');
            setTimeout(() => document.getElementById('ai_interactive_input').focus(), 100);
        } else if (state === 'loading') {
            document.getElementById('ai_state_loading').classList.remove('hidden');
        } else if (state === 'results') {
            document.getElementById('ai_state_results').classList.remove('hidden');
        }
    };

    window.handleAiInput = function(e) {
        if (e.key === 'Enter') {
            submitAiPrompt();
        }
    };

    window.submitAiPrompt = function() {
        const val = document.getElementById('ai_prompt_input').value.trim();
        if (val) {
            window.setAiPrompt(val);
            document.getElementById('ai_prompt_input').value = '';
        }
    };

    window.handleAiInteractiveInput = function(e) {
        if (e.key === 'Enter') {
            submitAiInteractivePrompt();
        }
    };

    window.submitAiInteractivePrompt = function() {
        const val = document.getElementById('ai_interactive_input').value.trim();
        if (val) {
            window.currentAiPrompt = val;
            triggerAiGeneration(val);
        }
    };
    
    // Override old setAiPrompt from grid click to open the interactive panel and generate
    window.setAiPrompt = function(promptText) {
        window.openAiInteractivePanel();
        document.getElementById('ai_interactive_input').value = promptText;
        window.currentAiPrompt = promptText;
        triggerAiGeneration(promptText);
    };

    window.cancelAiGeneration = function() {
        if(window.aiGenerationController) {
            window.aiGenerationController.abort();
        }
        showAiState('input');
    };

    window.regenerateAiTheme = function() {
        if (window.currentAiPrompt) {
            triggerAiGeneration(window.currentAiPrompt);
        }
    };

    window.aiGeneratedVariations = [];
    window.currentAiVariationIndex = 0;

    window.triggerAiGeneration = async function(promptText) {
        showAiState('loading');
        
        if(window.aiGenerationController) {
            window.aiGenerationController.abort();
        }
        window.aiGenerationController = new AbortController();

        try {
            const response = await fetch('/api/ai/generate-theme', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.csrf || document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({ prompt: promptText }),
                signal: window.aiGenerationController.signal
            });
            
            const data = await response.json();
            
            if (data.success && data.imageUrls && data.imageUrls.length > 0) {
                window.aiGeneratedVariations = data.imageUrls;
                window.currentAiVariationIndex = 0;
                renderAiCarousel();
                showAiState('results');
            } else {
                showAiState('input');
                if (window.showToast) window.showToast('Error', data.message || 'Failed to generate images');
            }
        } catch (err) {
            if (err.name === 'AbortError') return;
            console.error(err);
            showAiState('input');
            if (window.showToast) window.showToast('Error', 'Network error. Please try again.');
        }
    };

    window.renderAiCarousel = function() {
        const track = document.getElementById('ai_carousel_track');
        const dotsContainer = document.getElementById('ai_carousel_dots');
        track.innerHTML = '';
        dotsContainer.innerHTML = '';
        
        window.aiGeneratedVariations.forEach((url, idx) => {
            // Slide
            const slide = document.createElement('div');
            slide.className = 'min-w-full h-full flex items-center justify-center px-4 cursor-pointer';
            
            // Add a container with rounded corners and shadow to match the UI precisely
            slide.innerHTML = `<div class="relative h-full w-full max-w-[280px] aspect-[9/16] rounded-[24px] overflow-hidden shadow-2xl transition-all duration-300 ${idx === window.currentAiVariationIndex ? 'scale-100 opacity-100' : 'scale-95 opacity-50'}">
                <img src="${url}" class="w-full h-full object-cover aspect-[9/16]" loading="lazy">
            </div>`;
            track.appendChild(slide);
            
            // Dot
            const dot = document.createElement('div');
            dot.className = `w-2 h-2 rounded-full bg-white cursor-pointer transition-all duration-300 ${idx === window.currentAiVariationIndex ? 'opacity-100 scale-110' : 'opacity-30'}`;
            dot.onclick = () => goToAiVariation(idx);
            dotsContainer.appendChild(dot);
        });
        
        updateAiCarouselTransform();
        setupAiCarouselSwipe();
    };

    window.updateAiVariationClasses = function(index) {
        const track = document.getElementById('ai_carousel_track');
        const slides = track.children;
        for (let i = 0; i < slides.length; i++) {
            const innerDiv = slides[i].querySelector('div');
            if (i === index) {
                innerDiv.className = 'relative h-full w-full max-w-[280px] aspect-[9/16] rounded-[24px] overflow-hidden shadow-2xl transition-all duration-300 scale-100 opacity-100';
            } else {
                innerDiv.className = 'relative h-full w-full max-w-[280px] aspect-[9/16] rounded-[24px] overflow-hidden shadow-2xl transition-all duration-300 scale-95 opacity-50';
            }
        }
    };

    window.goToAiVariation = function(index) {
        if (index < 0 || index >= window.aiGeneratedVariations.length) return;
        window.currentAiVariationIndex = index;
        
        window.updateAiVariationClasses(index);
        
        updateAiCarouselTransform();
        
        // Update dots
        const dots = document.getElementById('ai_carousel_dots').children;
        for (let i = 0; i < dots.length; i++) {
            if (i === index) {
                dots[i].className = 'w-2 h-2 rounded-full bg-white cursor-pointer transition-all duration-300 opacity-100 scale-110';
            } else {
                dots[i].className = 'w-2 h-2 rounded-full bg-white cursor-pointer transition-all duration-300 opacity-30';
            }
        }
    };

    window.updateAiCarouselTransform = function() {
        const track = document.getElementById('ai_carousel_track');
        track.style.transform = `translateX(-${window.currentAiVariationIndex * 100}%)`;
    };

    window.setupAiCarouselSwipe = function() {
        const track = document.getElementById('ai_carousel_track');
        let startX = 0;
        let isDragging = false;
        
        track.onmousedown = (e) => {
            startX = e.pageX;
            isDragging = true;
            track.style.transition = 'none';
        };
        track.onmousemove = (e) => {
            if (!isDragging) return;
            const diff = e.pageX - startX;
            const baseTranslate = -(window.currentAiVariationIndex * 100);
            // Rough calculation to move track with mouse
            const movePercent = (diff / track.offsetWidth) * 100;
            track.style.transform = `translateX(${baseTranslate + movePercent}%)`;
        };
        track.onmouseup = track.onmouseleave = (e) => {
            if (!isDragging) return;
            isDragging = false;
            track.style.transition = 'transform 300ms ease-in-out';
            
            const diff = e.pageX - startX;
            if (diff < -50 && window.currentAiVariationIndex < window.aiGeneratedVariations.length - 1) {
                goToAiVariation(window.currentAiVariationIndex + 1);
            } else if (diff > 50 && window.currentAiVariationIndex > 0) {
                goToAiVariation(window.currentAiVariationIndex - 1);
            } else {
                goToAiVariation(window.currentAiVariationIndex); // snap back
            }
        };
    };

    window.applyAiThemeSelection = function() {
        const selectedUrl = window.aiGeneratedVariations[window.currentAiVariationIndex];
        if (!selectedUrl) return;
        
        const aiTheme = {
            id: 'ai_generated',
            bg: 'bg-black',
            custom: `<div class="absolute inset-0 bg-cover bg-center opacity-80" style="background-image: url('${selectedUrl}')"></div>`,
            in: 'bg-[#202c33]',
            out: 'bg-[#005c4b]',
            bubbleColor: '#005c4b'
        };
        
        // Add to array
        const existingIdx = chatThemes.findIndex(t => t.id === 'ai_generated');
        let finalIdx = 0;
        if (existingIdx !== -1) {
            chatThemes[existingIdx] = aiTheme;
            finalIdx = existingIdx;
            previewIndex = previewableThemes.findIndex(t => t.id === 'ai_generated');
        } else {
            chatThemes.push(aiTheme);
            previewableThemes.push(aiTheme);
            finalIdx = chatThemes.length - 1;
            previewIndex = previewableThemes.length - 1;
        }
        
        // Close interactive panel
        closeAiInteractivePanel();
        
        // Open the wallpaper preview using the standard function to calculate flexible layout correctly
        setTimeout(() => {
            openThemePreview(finalIdx);
        }, 300); // Wait for interactive panel to close before animating preview
        
        if (window.showToast) {
            window.showToast('Theme Generated', 'Previewing your new wallpaper!');
        }
    };
    window.editAiPrompt = function() {
        const selectedUrl = window.aiGeneratedVariations[window.currentAiVariationIndex];
        if (!selectedUrl) return;
        
        document.getElementById('ai_edit_preview_img').src = selectedUrl;
        document.getElementById('ai_state_edit').classList.remove('hidden');
        window.currentEditAction = '';
        window.tempEditPrompt = window.currentAiPrompt;
        
        // Reset pills
        document.querySelectorAll('.edit-action-pill').forEach(el => {
            el.classList.remove('bg-[#1e3a2f]', 'text-[#00a884]');
            el.classList.add('bg-[#2a2f32]', 'text-white');
        });
        document.getElementById('ai_edit_input').value = '';
    };

    window.closeAiEdit = function() {
        document.getElementById('ai_state_edit').classList.add('hidden');
    };

    window.selectEditAction = function(action, element) {
        window.currentEditAction = action;
        // Reset all pills
        document.querySelectorAll('.edit-action-pill').forEach(el => {
            el.classList.remove('bg-[#1e3a2f]', 'text-[#00a884]');
            el.classList.add('bg-[#2a2f32]', 'text-white');
        });
        // Set active pill
        element.classList.remove('bg-[#2a2f32]', 'text-white');
        element.classList.add('bg-[#1e3a2f]', 'text-[#00a884]');
        
        document.getElementById('ai_edit_input').focus();
    };

    window.generateEditPreview = function() {
        const val = document.getElementById('ai_edit_input').value.trim();
        if (val) {
            const action = window.currentEditAction ? window.currentEditAction + " " : "";
            window.tempEditPrompt = window.currentAiPrompt + ", " + action + val;
            
            // Show loading overlay
            document.getElementById('ai_edit_loading').classList.remove('hidden');
            
            // Dynamically load new image
            const img = document.getElementById('ai_edit_preview_img');
            const newSrc = `https://image.pollinations.ai/prompt/${encodeURIComponent(window.tempEditPrompt)}?width=400&height=711&nologo=true&seed=${Math.floor(Math.random()*100000)}`;
            
            img.onload = function() {
                document.getElementById('ai_edit_loading').classList.add('hidden');
            };
            img.onerror = function() {
                document.getElementById('ai_edit_loading').classList.add('hidden');
                if (window.showToast) window.showToast('Error', 'Failed to generate image. Please try again.');
            };
            img.src = newSrc;
        }
    };

    window.applyAiEdit = function() {
        const finalUrl = document.getElementById('ai_edit_preview_img').src;
        if (!finalUrl || finalUrl === window.aiGeneratedVariations[window.currentAiVariationIndex]) {
            closeAiEdit();
            return;
        }
        closeAiEdit();
        
        window.aiGeneratedVariations.push(finalUrl);
        window.currentAiVariationIndex = window.aiGeneratedVariations.length - 1;
        window.currentAiPrompt = window.tempEditPrompt;
        
        renderAiCarousel();
        goToAiVariation(window.currentAiVariationIndex);
        applyAiThemeSelection();
    };

    window.restyleAiPrompt = function() {
        const selectedUrl = window.aiGeneratedVariations[window.currentAiVariationIndex];
        if (!selectedUrl) return;
        
        document.getElementById('ai_restyle_preview_img').src = selectedUrl;
        document.getElementById('ai_state_restyle').classList.remove('hidden');
        window.currentRestyleStyle = '';
        window.tempRestylePrompt = window.currentAiPrompt;
        
        // Reset chips
        document.querySelectorAll('.style-thumb').forEach(el => {
            el.classList.remove('border-[#25D366]');
            el.classList.add('border-transparent');
        });
    };

    window.closeAiRestyle = function() {
        document.getElementById('ai_state_restyle').classList.add('hidden');
    };

    window.selectStyle = function(style, element) {
        window.currentRestyleStyle = style;
        
        // Reset all chips
        document.querySelectorAll('.style-thumb').forEach(el => {
            el.classList.remove('border-[#25D366]');
            el.classList.add('border-transparent');
        });
        // Set active chip
        element.querySelector('.style-thumb').classList.remove('border-transparent');
        element.querySelector('.style-thumb').classList.add('border-[#25D366]');
        
        window.tempRestylePrompt = window.currentAiPrompt + ", in " + style + " style";
        
        // Show loading overlay
        document.getElementById('ai_restyle_loading').classList.remove('hidden');
        
        // Dynamically load new image
        const img = document.getElementById('ai_restyle_preview_img');
        const newSrc = `https://image.pollinations.ai/prompt/${encodeURIComponent(window.tempRestylePrompt)}?width=400&height=711&nologo=true&seed=${Math.floor(Math.random()*100000)}`;
        
        img.onload = function() {
            document.getElementById('ai_restyle_loading').classList.add('hidden');
        };
        img.onerror = function() {
            document.getElementById('ai_restyle_loading').classList.add('hidden');
            if (window.showToast) window.showToast('Error', 'Failed to generate image. Please try again.');
        };
        img.src = newSrc;
    };

    window.applyAiRestyle = function() {
        const finalUrl = document.getElementById('ai_restyle_preview_img').src;
        if (!finalUrl || finalUrl === window.aiGeneratedVariations[window.currentAiVariationIndex]) {
            closeAiRestyle();
            return;
        }
        closeAiRestyle();
        
        window.aiGeneratedVariations.push(finalUrl);
        window.currentAiVariationIndex = window.aiGeneratedVariations.length - 1;
        window.currentAiPrompt = window.tempRestylePrompt;
        
        renderAiCarousel();
        goToAiVariation(window.currentAiVariationIndex);
        applyAiThemeSelection();
    };

</script>
