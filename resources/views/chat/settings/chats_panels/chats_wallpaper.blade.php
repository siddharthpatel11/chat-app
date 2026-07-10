<div id="chats_wallpaper_panel"
    class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="toggleChatWallpaperPanel()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Set chat wallpaper</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] py-4 px-6 flex flex-col h-full relative z-10">

        <div class="mb-4">
            <button onclick="document.getElementById('global_wallpaper_upload').click()" class="bg-[#00a884] hover:bg-[#008f6f] text-[#111b21] px-4 py-2 rounded-md w-full font-medium transition-colors text-[14px]">
                Upload Custom Image
            </button>
            <input type="file" id="global_wallpaper_upload" accept="image/*" class="hidden" onchange="handleGlobalWallpaperUpload(event)">
            <button id="remove_global_wallpaper_btn" onclick="removeGlobalWallpaper()" class="hidden mt-2 bg-transparent border border-red-500 text-red-500 hover:bg-red-500 hover:text-white px-4 py-2 rounded-md w-full font-medium transition-colors text-sm">
                Remove Custom Image
            </button>
        </div>

        <div class="flex items-center justify-between py-2 mb-4 group cursor-pointer" onclick="toggleDoodles()">
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="wallpaper_doodles_toggle" class="sr-only peer" checked onchange="updateWallpaperDoodles(this.checked)">
                <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
            </label>
            <div class="flex-1 ml-4 text-[#e9edef] text-[15px]">Add WhatsApp doodles</div>
        </div>

        <div class="grid grid-cols-4 gap-2 pb-8">
            <!-- Colors Grid -->
            <!-- We will generate these with JS to keep it clean -->
            <div id="wallpaper_colors_grid" class="contents"></div>
        </div>

    </div>
    <!-- We will fake the preview on the right side by injecting it or showing a modal overlay if needed. But for now this is just the panel. -->
</div>

<!-- Wallpaper Preview Overlay -->
<div id="wallpaper_preview_overlay" class="hidden absolute top-0 right-0 w-[calc(100%-64px)] sm:w-[calc(100%-72px)] h-full z-[40] flex pointer-events-none bg-transparent">
    <!-- Left space taken by the panel -->
    <div class="w-full sm:w-[30%] sm:min-w-[350px] shrink-0"></div>

    <!-- Right Preview Area -->
    <div class="flex-1 flex flex-col h-full bg-[#0b141a] pointer-events-auto">
        <div class="h-16 flex items-center justify-center border-b border-[#313d45]/0">
            <h2 class="text-[#e9edef] text-[16px] font-medium">Wallpaper preview</h2>
        </div>
        <div class="flex-1 flex items-center justify-center p-8 relative overflow-hidden bg-[#0b141a]">
            <!-- The preview chat background -->
            <div id="wallpaper_preview_bg" class="absolute inset-0 bg-[#0b141a] transition-colors duration-300"></div>
            <div id="wallpaper_preview_doodles" class="absolute inset-0 opacity-5 transition-opacity duration-300 mix-blend-overlay" style="background-image: url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png'); background-repeat: repeat;"></div>

            <!-- Fake chat messages -->
            <div class="relative z-10 w-full max-w-md flex flex-col gap-4">
                <div class="bg-[#202c33] text-[#e9edef] rounded-lg rounded-tl-none p-2 px-3 text-[14px] shadow self-start max-w-[80%]">
                    This is a preview of your chat wallpaper.
                    <div class="text-[11px] text-[#8696a0] text-right mt-1">12:00</div>
                </div>
                <div class="bg-[#005c4b] text-[#e9edef] rounded-lg rounded-tr-none p-2 px-3 text-[14px] shadow self-end max-w-[80%]">
                    It looks great!
                    <div class="text-[11px] text-[#8696a0] text-right mt-1 flex items-center justify-end gap-1">
                        12:01
                        <svg viewBox="0 0 16 15" width="16" height="15" fill="currentColor" class="text-[#53bdeb]"><path d="M15.01 3.316l-.478-.372a.365.365 0 0 0-.51.063L8.666 9.879a.32.32 0 0 1-.484.033l-.358-.325a.319.319 0 0 0-.484.032l-.378.483a.418.418 0 0 0 .036.541l1.32 1.266c.143.14.361.125.484-.033l6.272-8.048a.366.366 0 0 0-.064-.512zm-4.1 0l-.478-.372a.365.365 0 0 0-.51.063L4.566 9.879a.32.32 0 0 1-.484.033L1.891 7.769a.366.366 0 0 0-.515.006l-.423.433a.364.364 0 0 0 .006.514l3.258 3.185c.143.14.361.125.484-.033l6.272-8.048a.365.365 0 0 0-.063-.51z"></path></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const wpColors = [
        '#0b141a', '#082329', '#0d2818', '#071d2b',
        '#122738', '#1a323d', '#1d3b3c', '#2c2532',
        '#312e2f', '#3a342c', '#392d24', '#3d3420',
        '#3e2920', '#412224', '#38161d', '#330e16',
        '#2e0c15', '#2a1a14', '#1f1311', '#111a1d',
        '#083846', '#0f293b', '#0a1d2d', '#081419'
    ];

    window.toggleChatWallpaperPanel = function() {
        const wpPanel = document.getElementById('chats_wallpaper_panel');
        const overlay = document.getElementById('wallpaper_preview_overlay');
        const chatPanel = document.getElementById('chats_settings_panel');

        if (wpPanel.classList.contains('hidden')) {
            wpPanel.classList.remove('hidden');
            wpPanel.classList.add('flex');
            overlay.classList.remove('hidden');
            if (chatPanel) chatPanel.classList.add('hidden');

            // Init colors
            const grid = document.getElementById('wallpaper_colors_grid');
            if (grid.innerHTML === '') {
                wpColors.forEach((color, index) => {
                    const div = document.createElement('div');
                    div.className = `w-full aspect-square rounded cursor-pointer border-2 transition-all flex items-center justify-center hover:opacity-80`;
                    div.style.backgroundColor = color;
                    div.onclick = () => window.selectWallpaper(color, div);

                    if (index === 0) {
                        div.classList.add('border-white/50');
                        div.innerHTML = `<span class="text-[#e9edef] text-[10px] font-medium opacity-50">Default</span>`;
                    } else {
                        div.classList.add('border-transparent');
                    }

                    grid.appendChild(div);
                });
            }

            const currentUserId = window.myUserId || 'default';
            const savedColor = localStorage.getItem(`whatsapp_wallpaper_color_${currentUserId}`) || '#0b141a';
            const savedDoodles = localStorage.getItem(`whatsapp_wallpaper_doodles_${currentUserId}`) !== 'false';
            const globalImg = localStorage.getItem(`whatsapp_wallpaper_global_image_${currentUserId}`);

            document.getElementById('wallpaper_doodles_toggle').checked = savedDoodles;
            
            if (globalImg) {
                document.getElementById('remove_global_wallpaper_btn').classList.remove('hidden');
            } else {
                document.getElementById('remove_global_wallpaper_btn').classList.add('hidden');
            }
            
            window.updateWallpaperPreview(savedColor, savedDoodles);

            // Highlight selected
            Array.from(grid.children).forEach(child => {
                if(child.style.backgroundColor === savedColor || (savedColor === '#0b141a' && child.innerText === 'Default')) {
                    child.classList.replace('border-transparent', 'border-white/50');
                } else {
                    child.classList.replace('border-white/50', 'border-transparent');
                }
            });

        } else {
            wpPanel.classList.add('hidden');
            wpPanel.classList.remove('flex');
            overlay.classList.add('hidden');
            if (chatPanel) chatPanel.classList.remove('hidden');
        }
    }

    window.toggleDoodles = function() {
        const t = document.getElementById('wallpaper_doodles_toggle');
        t.checked = !t.checked;
        updateWallpaperDoodles(t.checked);
    }

    window.updateWallpaperDoodles = function(isChecked) {
        const currentUserId = window.myUserId || 'default';
        localStorage.setItem(`whatsapp_wallpaper_doodles_${currentUserId}`, isChecked);
        
        if (window.db && window.update && window.ref) {
            window.update(window.ref(window.db, `users/${currentUserId}/settings/wallpaper`), {
                doodles: isChecked
            }).catch(err => console.error("Error saving global wallpaper doodles to Firebase:", err));
        }

        const doodles = document.getElementById('wallpaper_preview_doodles');
        if (doodles) {
            doodles.style.opacity = isChecked ? '0.05' : '0';
        }
        if (window.applyGlobalWallpaper) window.applyGlobalWallpaper();
    }

    window.selectWallpaper = function(color, element) {
        const currentUserId = window.myUserId || 'default';
        localStorage.setItem(`whatsapp_wallpaper_color_${currentUserId}`, color);

        if (window.db && window.update && window.ref) {
            window.update(window.ref(window.db, `users/${currentUserId}/settings/wallpaper`), {
                color: color
            }).catch(err => console.error("Error saving global wallpaper color to Firebase:", err));
        }

        // Update borders
        const grid = document.getElementById('wallpaper_colors_grid');
        Array.from(grid.children).forEach(child => {
            child.classList.replace('border-white/50', 'border-transparent');
        });
        element.classList.replace('border-transparent', 'border-white/50');

        const isChecked = document.getElementById('wallpaper_doodles_toggle').checked;
        window.updateWallpaperPreview(color, isChecked);
        if (window.applyGlobalWallpaper) window.applyGlobalWallpaper();
    }

    window.updateWallpaperPreview = function(color, showDoodles) {
        const currentUserId = window.myUserId || 'default';
        const globalImg = localStorage.getItem(`whatsapp_wallpaper_global_image_${currentUserId}`);
        
        if (color === undefined) color = localStorage.getItem(`whatsapp_wallpaper_color_${currentUserId}`) || '#0b141a';
        if (showDoodles === undefined) showDoodles = localStorage.getItem(`whatsapp_wallpaper_doodles_${currentUserId}`) !== 'false';

        const bg = document.getElementById('wallpaper_preview_bg');
        const doodles = document.getElementById('wallpaper_preview_doodles');
        
        if (globalImg) {
            bg.style.backgroundColor = 'transparent';
            bg.style.backgroundImage = `url('${globalImg}')`;
            bg.style.backgroundSize = 'cover';
            bg.style.backgroundPosition = 'center';
            bg.style.backgroundRepeat = 'no-repeat';
            if (doodles) doodles.style.opacity = '0';
        } else {
            bg.style.backgroundImage = 'none';
            bg.style.backgroundColor = color;
            if (doodles) doodles.style.opacity = showDoodles ? '0.05' : '0';
        }
    }

    window.handleGlobalWallpaperUpload = function(event) {
        const file = event.target.files[0];
        if (!file) return;

        event.target.value = '';

        if (file.size > 2 * 1024 * 1024) {
            window.showToast?.('Error', 'Image must be less than 2MB', 'error');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                const canvas = document.createElement('canvas');
                const MAX_WIDTH = 1000;
                const MAX_HEIGHT = 1000;
                let width = img.width;
                let height = img.height;

                if (width > height) {
                    if (width > MAX_WIDTH) {
                        height *= MAX_WIDTH / width;
                        width = MAX_WIDTH;
                    }
                } else {
                    if (height > MAX_HEIGHT) {
                        width *= MAX_HEIGHT / height;
                        height = MAX_HEIGHT;
                    }
                }
                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);

                const dataUrl = canvas.toDataURL('image/jpeg', 0.6);
                
                const currentUserId = window.myUserId || 'default';
                try {
                    localStorage.setItem(`whatsapp_wallpaper_global_image_${currentUserId}`, dataUrl);
                    
                    if (window.db && window.update && window.ref) {
                        window.update(window.ref(window.db, `users/${currentUserId}/settings/wallpaper`), {
                            global_image: dataUrl
                        }).catch(err => console.error("Error saving global wallpaper image to Firebase:", err));
                    }

                    window.updateWallpaperPreview();
                    if (window.applyGlobalWallpaper) window.applyGlobalWallpaper();
                    document.getElementById('remove_global_wallpaper_btn').classList.remove('hidden');
                    window.showToast?.('Success', 'Global custom wallpaper set');
                } catch (err) {
                    console.error(err);
                    window.showToast?.('Error', 'Image too large.', 'error');
                }
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    };

    window.removeGlobalWallpaper = function() {
        const currentUserId = window.myUserId || 'default';
        localStorage.removeItem(`whatsapp_wallpaper_global_image_${currentUserId}`);
        
        if (window.db && window.update && window.ref) {
            window.update(window.ref(window.db, `users/${currentUserId}/settings/wallpaper`), {
                global_image: null
            }).catch(err => console.error("Error removing global wallpaper image from Firebase:", err));
        }

        window.updateWallpaperPreview();
        if (window.applyGlobalWallpaper) window.applyGlobalWallpaper();
        document.getElementById('remove_global_wallpaper_btn').classList.add('hidden');
        window.showToast?.('Success', 'Global custom wallpaper removed');
    };
</script>
