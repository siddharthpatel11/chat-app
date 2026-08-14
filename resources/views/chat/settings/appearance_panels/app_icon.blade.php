<div id="app_icon_settings_panel" class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden absolute sm:relative z-20 top-0 left-0">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center justify-between shrink-0 border-b border-[#313d45]">
        <div class="flex items-center gap-6">
            <button onclick="toggleAppIconPanel()" class="text-[#aebac1] hover:text-white transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
            </button>
            <h2 class="text-[#e9edef] text-[19px] font-medium">App icon</h2>
        </div>
        <div class="relative">
            <button onclick="toggleAppIconDropdown(event)" id="app_icon_menu_btn" class="text-[#aebac1] hover:text-white transition-colors p-2 rounded-full hover:bg-white/5">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M12 7a2 2 0 1 0-.001-4.001A2 2 0 0 0 12 7zm0 2a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 9zm0 6a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 15z"></path>
                </svg>
            </button>
            
            <!-- Dropdown Menu -->
            <div id="app_icon_dropdown" class="hidden absolute right-0 top-12 bg-[#233138] w-48 py-2 rounded shadow-xl z-50 origin-top-right transform transition-all duration-200 scale-95 opacity-0">
                <button onclick="resetAppIcon()" class="w-full text-left px-6 py-3 text-[#d1d7db] hover:bg-[#182229] hover:text-[#e9edef] transition-colors flex items-center gap-4">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                        <path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46A7.93 7.93 0 0 0 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74A7.93 7.93 0 0 0 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"></path>
                    </svg>
                    Reset app icon
                </button>
            </div>
        </div>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] p-6 relative" id="app_icon_scroll_container">
        
        <div class="grid grid-cols-3 gap-8 gap-y-10 justify-items-center mb-8" id="app_icon_grid">
            <!-- Icons injected by JS -->
        </div>

    </div>
</div>

<style>
    .app-icon-item {
        position: relative;
        cursor: pointer;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-center;
        transition: transform 0.2s;
    }
    .app-icon-item:hover {
        transform: scale(1.05);
    }
    .app-icon-svg {
        width: 36px;
        height: 36px;
        fill: white;
    }
    .app-icon-selected .app-icon-overlay {
        display: flex;
    }
    
    /* Specific icon styles */
    .icon-style-0 { background: #25D366; outline: 3px solid white; outline-offset: -5px; } /* Default */
    .icon-style-1 { background: #25D366; }
    .icon-style-2 { background: radial-gradient(circle, #4ade80, #166534); box-shadow: inset 0 0 10px rgba(255,255,255,0.5); }
    .icon-style-3 { background: linear-gradient(135deg, #10b981, #047857); }
    .icon-style-4 { background: #0f172a; box-shadow: 0 0 15px #3b82f6; .app-icon-svg { fill: #60a5fa; } }
    .icon-style-5 { background: linear-gradient(45deg, #7c3aed, #ea580c); }
    .icon-style-6 { background: radial-gradient(circle, #fbcfe8, #db2777); .app-icon-svg { fill: #9d174d; } }
    .icon-style-7 { background: #581c87; box-shadow: inset 0 0 15px #c084fc; }
    .icon-style-8 { background: linear-gradient(to right, #ea580c, #f59e0b); }
    .icon-style-9 { background: #e0e7ff; .app-icon-svg { fill: #4f46e5; } }
    .icon-style-10 { background: #bae6fd; .app-icon-svg { fill: #0284c7; } }
    .icon-style-11 { background: #ffedd5; .app-icon-svg { fill: #ea580c; } }
    .icon-style-12 { background: #dcfce7; .app-icon-svg { fill: #16a34a; } }
    .icon-style-13 { background: transparent; border: 3px solid #22c55e; .app-icon-svg { fill: #22c55e; } }
    .icon-style-14 { background: white; .app-icon-svg { fill: black; } }
</style>

<script>
    const whatsappSvgPath = "M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z";
    let selectedIconIndex = 0;
    if (window.backendAppearance && window.backendAppearance.app_icon_index !== undefined) {
        selectedIconIndex = parseInt(window.backendAppearance.app_icon_index);
        localStorage.setItem('whatsapp_app_icon_index', selectedIconIndex);
    } else {
        let stored = localStorage.getItem('whatsapp_app_icon_index');
        if (stored !== null) selectedIconIndex = parseInt(stored);
    }

    function renderAppIcons() {
        const grid = document.getElementById('app_icon_grid');
        grid.innerHTML = '';
        for (let i = 0; i < 15; i++) {
            const isSelected = i === selectedIconIndex;
            grid.innerHTML += `
                <div class="relative app-icon-item icon-style-${i} flex items-center justify-center ${isSelected ? 'app-icon-selected' : ''}" onclick="selectAppIcon(${i})">
                    <svg viewBox="0 0 24 24" class="app-icon-svg">
                        <path d="${whatsappSvgPath}"></path>
                    </svg>
                    <!-- Checkmark overlay (only visible when selected) -->
                    <div class="app-icon-overlay absolute -bottom-2 -right-2 w-6 h-6 bg-white rounded-full hidden items-center justify-center shadow-md border border-gray-200">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="black">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                        </svg>
                    </div>
                </div>
            `;
        }
    }

    function selectAppIcon(index) {
        selectedIconIndex = index;
        localStorage.setItem('whatsapp_app_icon_index', index);
        renderAppIcons();
        applyDynamicFavicon(index);
        
        // Save to backend
        fetch('/api/settings/appearance', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('whatsapp_token')
            },
            body: JSON.stringify({ app_icon_index: index })
        }).catch(err => console.error('Error saving icon:', err));
    }

    function resetAppIcon() {
        selectAppIcon(0);
        closeAppIconDropdown();
    }

    // Convert the SVG to a base64 Data URI and set it as favicon
    function applyDynamicFavicon(index) {
        // Need to construct the SVG string with the proper styles
        const dummy = document.createElement('div');
        dummy.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60" width="60" height="60">
                <style>
                    /* Inline the CSS for the icon style so it renders in the favicon */
                    .icon-bg-0 { fill: #25D366; stroke: white; stroke-width: 3; }
                    .icon-bg-1 { fill: #25D366; }
                    .icon-bg-2 { fill: #166534; }
                    .icon-bg-3 { fill: #047857; }
                    .icon-bg-4 { fill: #0f172a; }
                    .icon-bg-5 { fill: #ea580c; }
                    .icon-bg-6 { fill: #db2777; }
                    .icon-bg-7 { fill: #581c87; }
                    .icon-bg-8 { fill: #ea580c; }
                    .icon-bg-9 { fill: #e0e7ff; }
                    .icon-bg-10 { fill: #bae6fd; }
                    .icon-bg-11 { fill: #ffedd5; }
                    .icon-bg-12 { fill: #dcfce7; }
                    .icon-bg-13 { fill: transparent; stroke: #22c55e; stroke-width: 3; }
                    .icon-bg-14 { fill: white; }
                    
                    .icon-fg { fill: white; }
                    .icon-fg-4 { fill: #60a5fa; }
                    .icon-fg-6 { fill: #9d174d; }
                    .icon-fg-9 { fill: #4f46e5; }
                    .icon-fg-10 { fill: #0284c7; }
                    .icon-fg-11 { fill: #ea580c; }
                    .icon-fg-12 { fill: #16a34a; }
                    .icon-fg-13 { fill: #22c55e; }
                    .icon-fg-14 { fill: black; }
                </style>
                <circle cx="30" cy="30" r="28" class="icon-bg-${index}" />
                <g transform="translate(12, 12) scale(1.5)">
                    <path d="${whatsappSvgPath}" class="icon-fg icon-fg-${index}"></path>
                </g>
            </svg>
        `;
        const svgStr = dummy.innerHTML.trim();
        const encoded = "data:image/svg+xml;base64," + btoa(unescape(encodeURIComponent(svgStr)));
        
        // Update favicon
        let link = document.querySelector("link[rel~='icon']");
        if (!link) {
            link = document.createElement('link');
            link.rel = 'icon';
            document.head.appendChild(link);
        }
        link.href = encoded;

        // If running inside Electron desktop app, send the icon via IPC
        if (window.electronAPI && window.electronAPI.updateIcon) {
            // Electron's nativeImage doesn't support SVG data URLs, so we convert it to PNG
            const img = new Image();
            img.onload = function() {
                const canvas = document.createElement('canvas');
                canvas.width = 256;
                canvas.height = 256;
                const ctx = canvas.getContext('2d');
                // The SVG width/height is 60, scale it up to 256 for better resolution
                ctx.scale(256 / 60, 256 / 60);
                ctx.drawImage(img, 0, 0);
                const pngDataUrl = canvas.toDataURL('image/png');
                window.electronAPI.updateIcon(pngDataUrl);
            };
            img.src = encoded;
        }
    }

    function toggleAppIconPanel(source) {
        const panel = document.getElementById('app_icon_settings_panel');
        const appPanel = document.getElementById('appearance_settings_panel');
        
        if (panel.classList.contains('hidden')) {
            panel.classList.remove('hidden');
            panel.classList.add('flex');
            if (appPanel) appPanel.classList.add('hidden');
            renderAppIcons();
        } else {
            panel.classList.add('hidden');
            panel.classList.remove('flex');
            if (appPanel) { 
                appPanel.classList.remove('hidden'); 
                appPanel.classList.add('flex'); 
            }
        }
    }

    function toggleAppIconDropdown(e) {
        if (e) {
            e.stopPropagation();
            e.preventDefault();
        }
        const dropdown = document.getElementById('app_icon_dropdown');
        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
            setTimeout(() => {
                dropdown.classList.remove('scale-95', 'opacity-0');
                dropdown.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            const closeDropdown = function(ev) {
                if (!dropdown.contains(ev.target)) {
                    closeAppIconDropdown();
                    document.removeEventListener('click', closeDropdown);
                }
            };
            setTimeout(() => document.addEventListener('click', closeDropdown), 10);
        } else {
            closeAppIconDropdown();
        }
    }

    function closeAppIconDropdown() {
        const dropdown = document.getElementById('app_icon_dropdown');
        dropdown.classList.remove('scale-100', 'opacity-100');
        dropdown.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            dropdown.classList.add('hidden');
        }, 200);
    }

    document.addEventListener('DOMContentLoaded', () => {
        applyDynamicFavicon(selectedIconIndex);
    });
</script>
