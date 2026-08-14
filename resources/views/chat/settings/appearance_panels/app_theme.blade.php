<div id="app_theme_settings_panel" class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden absolute sm:relative z-20 top-0 left-0">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center justify-between shrink-0 border-b border-[#313d45]">
        <div class="flex items-center gap-6">
            <button onclick="toggleAppThemePanel()" class="text-[#aebac1] hover:text-white transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
            </button>
            <h2 class="text-[#e9edef] text-[19px] font-medium">App theme</h2>
        </div>
        <div class="relative">
            <button onclick="toggleAppThemeDropdown(event)" id="app_theme_menu_btn" class="text-[#aebac1] hover:text-white transition-colors p-2 rounded-full hover:bg-white/5">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M12 7a2 2 0 1 0-.001-4.001A2 2 0 0 0 12 7zm0 2a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 9zm0 6a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 15z"></path>
                </svg>
            </button>
            
            <!-- Dropdown Menu -->
            <div id="app_theme_dropdown" class="hidden absolute right-0 top-12 bg-[#233138] w-48 py-2 rounded shadow-xl z-50 origin-top-right transform transition-all duration-200 scale-95 opacity-0">
                <button onclick="resetAppTheme()" class="w-full text-left px-6 py-3 text-[#d1d7db] hover:bg-[#182229] hover:text-[#e9edef] transition-colors flex items-center gap-4">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                        <path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46A7.93 7.93 0 0 0 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74A7.93 7.93 0 0 0 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"></path>
                    </svg>
                    Reset app theme
                </button>
            </div>
        </div>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] p-6 relative">
        
        <!-- Dark Mode Selector -->
        <div class="flex items-center gap-6 cursor-pointer mb-8" onclick="openDarkModeModal()">
            <div class="text-[#8696a0]">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="5"></circle>
                    <path d="M12 1v2m0 18v2M4.22 4.22l1.42 1.42m12.72 12.72l1.42 1.42M1 12h2m18 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"></path>
                </svg>
            </div>
            <div>
                <div class="text-[#e9edef] text-[16px] mb-1">Dark mode</div>
                <div class="text-[#8696a0] text-[14px]" id="current_dark_mode_text">Dark</div>
            </div>
        </div>

        <div class="text-[#8696a0] text-[14px] font-medium mb-4">Color</div>

        <div class="grid grid-cols-4 gap-6 justify-items-center mb-8" id="app_theme_grid">
            <!-- Colors injected by JS -->
        </div>

    </div>
</div>

<!-- Choose Theme Modal -->
<div id="dark_mode_modal" class="fixed inset-0 bg-black/60 z-[100] hidden items-center justify-center">
    <div class="bg-[#202c33] w-[90%] max-w-[340px] rounded-[3px] shadow-2xl flex flex-col scale-95 opacity-0 transition-all duration-200" id="dark_mode_modal_content">
        <div class="px-6 py-5 text-[#e9edef] text-[20px] font-medium mb-2">Choose theme</div>
        
        <div class="px-6 flex flex-col gap-5 mb-8">
            <label class="flex items-center gap-4 cursor-pointer">
                <input type="radio" name="dark_mode_radio" value="system" class="hidden">
                <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] flex items-center justify-center radio-ui">
                    <div class="w-2.5 h-2.5 bg-[#00a884] rounded-full hidden inner-dot"></div>
                </div>
                <span class="text-[#d1d7db] text-[16px]">System default</span>
            </label>
            <label class="flex items-center gap-4 cursor-pointer">
                <input type="radio" name="dark_mode_radio" value="light" class="hidden">
                <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] flex items-center justify-center radio-ui">
                    <div class="w-2.5 h-2.5 bg-[#00a884] rounded-full hidden inner-dot"></div>
                </div>
                <span class="text-[#d1d7db] text-[16px]">Light</span>
            </label>
            <label class="flex items-center gap-4 cursor-pointer">
                <input type="radio" name="dark_mode_radio" value="dark" class="hidden">
                <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] flex items-center justify-center radio-ui">
                    <div class="w-2.5 h-2.5 bg-[#00a884] rounded-full hidden inner-dot"></div>
                </div>
                <span class="text-[#d1d7db] text-[16px]">Dark</span>
            </label>
        </div>

        <div class="flex justify-end gap-6 px-6 pb-5">
            <button onclick="closeDarkModeModal()" class="text-[#00a884] font-medium text-[14px] hover:bg-white/5 px-4 py-2 rounded-lg transition-colors focus:outline-none">Cancel</button>
            <button onclick="saveDarkMode()" class="text-[#00a884] font-medium text-[14px] hover:bg-white/5 px-4 py-2 rounded-lg transition-colors focus:outline-none">OK</button>
        </div>
    </div>
</div>

<style>
    .app-theme-color-item {
        position: relative;
        cursor: pointer;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-center;
        transition: transform 0.2s;
    }
    .app-theme-color-item:hover {
        transform: scale(1.05);
    }
    
    .app-theme-selected::after {
        content: '';
        position: absolute;
        inset: -6px;
        border: 2px solid white;
        border-radius: 50%;
    }
    
    .app-theme-selected .app-theme-overlay {
        display: flex;
    }
</style>

<script>
    const appThemeColors = [
        '#00a884', '#4b5563', '#1d4ed8', '#7e22ce',
        '#be185d', '#1e40af', '#1e3a8a', '#4338ca',
        '#65a30d', '#0f766e', '#115e59', '#451a03',
        '#ca8a04', '#9a3412', '#9f1239', '#b91c1c'
    ];
    // We only need 15. The screenshot shows 16 colors actually (4x4). I'll use 16 to match the grid.

    let selectedThemeColorIndex = 0;
    let storedTheme = localStorage.getItem('whatsapp_app_theme_color_index');
    if (storedTheme !== null) {
        selectedThemeColorIndex = parseInt(storedTheme);
    } else if (window.backendAppearance && window.backendAppearance.app_theme_color_index !== undefined) {
        selectedThemeColorIndex = parseInt(window.backendAppearance.app_theme_color_index);
        localStorage.setItem('whatsapp_app_theme_color_index', selectedThemeColorIndex);
    }

    let currentDarkMode = 'dark';
    let storedDark = localStorage.getItem('whatsapp_app_dark_mode');
    if (storedDark !== null) {
        currentDarkMode = storedDark;
    } else if (window.backendAppearance && window.backendAppearance.app_dark_mode !== undefined) {
        currentDarkMode = window.backendAppearance.app_dark_mode;
        localStorage.setItem('whatsapp_app_dark_mode', currentDarkMode);
    }

    function renderAppThemeColors() {
        const grid = document.getElementById('app_theme_grid');
        grid.innerHTML = '';
        for (let i = 0; i < 16; i++) {
            const isSelected = i === selectedThemeColorIndex;
            const color = appThemeColors[i];
            grid.innerHTML += `
                <div class="app-theme-color-item ${isSelected ? 'app-theme-selected' : ''}" style="background-color: ${color}" onclick="selectAppThemeColor(${i})">
                    <!-- Checkmark overlay (only visible when selected) -->
                    <div class="app-theme-overlay absolute inset-0 hidden items-center justify-center">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="white">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                        </svg>
                    </div>
                </div>
            `;
        }
    }

    function selectAppThemeColor(index) {
        selectedThemeColorIndex = index;
        localStorage.setItem('whatsapp_app_theme_color_index', index);
        renderAppThemeColors();
        applyGlobalThemeColor();
        
        // Save to backend (disabled for web)
        // fetch('/api/v1/settings/appearance', { ... })
    }

    function resetAppTheme() {
        selectAppThemeColor(0);
        closeAppThemeDropdown();
    }

    function applyGlobalThemeColor() {
        const color = appThemeColors[selectedThemeColorIndex];
        // Calculate a hover color by darkening slightly
        let hex = color.replace('#', '');
        let r = parseInt(hex.substring(0,2), 16);
        let g = parseInt(hex.substring(2,4), 16);
        let b = parseInt(hex.substring(4,6), 16);
        let hr = Math.max(0, r - 20).toString(16).padStart(2, '0');
        let hg = Math.max(0, g - 20).toString(16).padStart(2, '0');
        let hb = Math.max(0, b - 20).toString(16).padStart(2, '0');
        const hoverColor = `#${hr}${hg}${hb}`;
        
        // We set CSS variables on the root. The overriding CSS in index.blade.php will catch this.
        document.documentElement.style.setProperty('--app-primary', color);
        document.documentElement.style.setProperty('--app-primary-hover', hoverColor);
    }

    // Modal Logic
    function openDarkModeModal() {
        const modal = document.getElementById('dark_mode_modal');
        const content = document.getElementById('dark_mode_modal_content');
        
        // Update radios based on current state
        document.querySelectorAll('input[name="dark_mode_radio"]').forEach(radio => {
            radio.checked = (radio.value === currentDarkMode);
            const ui = radio.nextElementSibling;
            const dot = ui.querySelector('.inner-dot');
            if (radio.checked) {
                ui.classList.add('border-[#00a884]');
                ui.classList.remove('border-[#8696a0]');
                dot.classList.remove('hidden');
            } else {
                ui.classList.remove('border-[#00a884]');
                ui.classList.add('border-[#8696a0]');
                dot.classList.add('hidden');
            }
        });
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeDarkModeModal() {
        const modal = document.getElementById('dark_mode_modal');
        const content = document.getElementById('dark_mode_modal_content');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 200);
    }

    // Radio click event
    document.querySelectorAll('input[name="dark_mode_radio"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
            document.querySelectorAll('input[name="dark_mode_radio"]').forEach(r => {
                const ui = r.nextElementSibling;
                const dot = ui.querySelector('.inner-dot');
                if (r.checked) {
                    ui.classList.add('border-[#00a884]');
                    ui.classList.remove('border-[#8696a0]');
                    dot.classList.remove('hidden');
                } else {
                    ui.classList.remove('border-[#00a884]');
                    ui.classList.add('border-[#8696a0]');
                    dot.classList.add('hidden');
                }
            });
        });
    });

    function saveDarkMode() {
        const selected = document.querySelector('input[name="dark_mode_radio"]:checked').value;
        currentDarkMode = selected;
        localStorage.setItem('whatsapp_app_dark_mode', selected);
        
        let displayStr = 'Dark';
        if (selected === 'system') displayStr = 'System default';
        if (selected === 'light') displayStr = 'Light';
        document.getElementById('current_dark_mode_text').innerText = displayStr;
        
        applyDarkMode();
        closeDarkModeModal();
    }
    
    function applyDarkMode() {
        // Implement Tailwind Dark mode toggle logic on html element
        const isDark = currentDarkMode === 'dark' || (currentDarkMode === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
        if (isDark) {
            document.documentElement.classList.add('dark');
            document.documentElement.classList.remove('light-theme');
        } else {
            // Note: If the entire app was built strictly for dark mode, this might look weird if no light classes were added.
            // But we will respect the dark class toggle.
            document.documentElement.classList.remove('dark');
            document.documentElement.classList.add('light-theme');
        }
    }

    function toggleAppThemePanel(source) {
        const panel = document.getElementById('app_theme_settings_panel');
        const appPanel = document.getElementById('appearance_settings_panel');
        
        if (panel.classList.contains('hidden')) {
            panel.classList.remove('hidden');
            panel.classList.add('flex');
            if (appPanel) appPanel.classList.add('hidden');
            
            // Initialize states
            let displayStr = 'Dark';
            if (currentDarkMode === 'system') displayStr = 'System default';
            if (currentDarkMode === 'light') displayStr = 'Light';
            document.getElementById('current_dark_mode_text').innerText = displayStr;
            renderAppThemeColors();
        } else {
            panel.classList.add('hidden');
            panel.classList.remove('flex');
            if (appPanel) { 
                appPanel.classList.remove('hidden'); 
                appPanel.classList.add('flex'); 
            }
        }
    }

    function toggleAppThemeDropdown(e) {
        if (e) {
            e.stopPropagation();
            e.preventDefault();
        }
        const dropdown = document.getElementById('app_theme_dropdown');
        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
            setTimeout(() => {
                dropdown.classList.remove('scale-95', 'opacity-0');
                dropdown.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            const closeDropdown = function(ev) {
                if (!dropdown.contains(ev.target)) {
                    closeAppThemeDropdown();
                    document.removeEventListener('click', closeDropdown);
                }
            };
            setTimeout(() => document.addEventListener('click', closeDropdown), 10);
        } else {
            closeAppThemeDropdown();
        }
    }

    function closeAppThemeDropdown() {
        const dropdown = document.getElementById('app_theme_dropdown');
        dropdown.classList.remove('scale-100', 'opacity-100');
        dropdown.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            dropdown.classList.add('hidden');
        }, 200);
    }

    document.addEventListener('DOMContentLoaded', () => {
        applyGlobalThemeColor();
        applyDarkMode();
    });
</script>
