<!-- Chat Wallpaper Modal -->
<div id="chat_wallpaper_modal" class="hidden fixed inset-0 z-[200] flex items-center justify-center p-4">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/60 transition-opacity" onclick="closeWallpaperModal()"></div>
    
    <!-- Modal Content -->
    <div class="bg-[#111b21] rounded-2xl w-full max-w-md overflow-hidden shadow-2xl transform transition-all z-10 flex flex-col border border-[#313d45]">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-[#2a3942] flex items-center justify-between bg-[#202c33]">
            <h3 class="text-[#e9edef] text-[18px] font-medium">Set Chat Wallpaper</h3>
            <button onclick="closeWallpaperModal()" class="text-[#8696a0] hover:text-[#e9edef] transition-colors focus:outline-none">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                </svg>
            </button>
        </div>
        
        <!-- Body -->
        <div class="p-6 flex flex-col gap-6">
            <div class="text-[#8696a0] text-[15px]">
                Choose a custom background image for all private or group chats. This will only be visible to you.
            </div>
            
            <!-- Upload Area -->
            <div class="flex flex-col gap-4">
                <input type="file" id="wallpaper_upload_input" accept="image/*" class="hidden" onchange="handleWallpaperSelection(event)">
                
                <!-- Preview / Upload Button Container -->
                <div id="wallpaper_preview_container" class="relative w-full h-48 rounded-xl border-2 border-dashed border-[#313d45] hover:border-[#00a884] bg-[#202c33] flex items-center justify-center overflow-hidden cursor-pointer transition-colors" onclick="document.getElementById('wallpaper_upload_input').click()">
                    
                    <div id="wallpaper_upload_prompt" class="flex flex-col items-center gap-2 text-[#8696a0]">
                        <svg viewBox="0 0 24 24" width="36" height="36" fill="currentColor">
                            <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                        </svg>
                        <span class="text-[14px]">Click to select an image</span>
                    </div>
                    
                    <img id="wallpaper_preview_img" src="" class="hidden absolute inset-0 w-full h-full object-cover">
                    
                    <div id="wallpaper_change_overlay" class="hidden absolute inset-0 bg-black/50 flex items-center justify-center">
                        <span class="text-white text-[14px] font-medium px-4 py-2 bg-black/40 rounded-full">Change Image</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="px-6 py-4 bg-[#202c33] flex items-center justify-between border-t border-[#2a3942]">
            <button id="btn_remove_wallpaper" onclick="removeWallpaper()" class="hidden px-4 py-2 text-[#f15c6d] hover:bg-[#2a3942] rounded-lg transition-colors font-medium text-[14px] focus:outline-none">
                Remove Wallpaper
            </button>
            <div class="flex items-center gap-3 ml-auto">
                <button onclick="closeWallpaperModal()" class="px-5 py-2.5 rounded-full border border-[#313d45] text-[#00a884] font-medium hover:bg-[#2a3942] transition-colors text-[14px] focus:outline-none">
                    Cancel
                </button>
                <button onclick="saveWallpaper()" class="px-5 py-2.5 rounded-full bg-[#00a884] text-[#111b21] font-medium hover:bg-[#00c298] transition-colors text-[14px] focus:outline-none shadow-sm">
                    Set Wallpaper
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    window._activeWallpaperChatId = null;
    window._activeWallpaperChatType = null;
    window._selectedWallpaperDataUrl = null;

    window.openWallpaperModal = function(chatId, type) {
        window._activeWallpaperChatId = chatId;
        window._activeWallpaperChatType = type;
        
        const modal = document.getElementById('chat_wallpaper_modal');
        const previewImg = document.getElementById('wallpaper_preview_img');
        const uploadPrompt = document.getElementById('wallpaper_upload_prompt');
        const changeOverlay = document.getElementById('wallpaper_change_overlay');
        const removeBtn = document.getElementById('btn_remove_wallpaper');
        const fileInput = document.getElementById('wallpaper_upload_input');
        
        // Reset state
        fileInput.value = '';
        window._selectedWallpaperDataUrl = null;
        
        // Check if there is an existing custom wallpaper
        const storageKey = `custom_wallpaper_${type}_${chatId}`;
        const existingWallpaper = localStorage.getItem(storageKey);
        
        if (existingWallpaper) {
            previewImg.src = existingWallpaper;
            previewImg.classList.remove('hidden');
            uploadPrompt.classList.add('hidden');
            
            const container = document.getElementById('wallpaper_preview_container');
            container.onmouseenter = () => changeOverlay.classList.remove('hidden');
            container.onmouseleave = () => changeOverlay.classList.add('hidden');
            
            removeBtn.classList.remove('hidden');
        } else {
            previewImg.src = '';
            previewImg.classList.add('hidden');
            uploadPrompt.classList.remove('hidden');
            changeOverlay.classList.add('hidden');
            
            const container = document.getElementById('wallpaper_preview_container');
            container.onmouseenter = null;
            container.onmouseleave = null;
            
            removeBtn.classList.add('hidden');
        }

        modal.classList.remove('hidden');
    };

    window.closeWallpaperModal = function() {
        const modal = document.getElementById('chat_wallpaper_modal');
        modal.classList.add('hidden');
        window._activeWallpaperChatId = null;
        window._activeWallpaperChatType = null;
        window._selectedWallpaperDataUrl = null;
    };

    window.handleWallpaperSelection = function(event) {
        const file = event.target.files[0];
        if (!file) return;

        // Check if file is an image
        if (!file.type.startsWith('image/')) {
            window.showToast?.('Error', 'Please select a valid image file.', 'error');
            return;
        }

        // Convert to Base64 and compress
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                const canvas = document.createElement('canvas');
                let width = img.width;
                let height = img.height;
                
                const MAX_WIDTH = 1920;
                const MAX_HEIGHT = 1080;
                
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
                
                // Compress to JPEG
                window._selectedWallpaperDataUrl = canvas.toDataURL('image/jpeg', 0.6);
                
                const previewImg = document.getElementById('wallpaper_preview_img');
                const uploadPrompt = document.getElementById('wallpaper_upload_prompt');
                const changeOverlay = document.getElementById('wallpaper_change_overlay');
                const removeBtn = document.getElementById('btn_remove_wallpaper');
                
                previewImg.src = window._selectedWallpaperDataUrl;
                previewImg.classList.remove('hidden');
                uploadPrompt.classList.add('hidden');
                changeOverlay.classList.add('hidden');
                
                const container = document.getElementById('wallpaper_preview_container');
                container.onmouseenter = () => changeOverlay.classList.remove('hidden');
                container.onmouseleave = () => changeOverlay.classList.add('hidden');
                
                removeBtn.classList.remove('hidden');
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    };

    window.saveWallpaper = function() {
        if (!window._activeWallpaperChatType || !window._activeWallpaperChatId) return;
        
        if (window._selectedWallpaperDataUrl) {
            const currentUserId = window.myUserId || 'default';
            const storageKey = `custom_wallpaper_${currentUserId}_${window._activeWallpaperChatType}_${window._activeWallpaperChatId}`;
            
            // Try saving
            try {
                localStorage.setItem(storageKey, window._selectedWallpaperDataUrl);
                
                // ALSO SAVE TO FIREBASE TO KEEP IN SYNC
                if (window.db && window.update && window.ref) {
                    const type = window._activeWallpaperChatType;
                    const chatId = window._activeWallpaperChatId;
                    
                    let realChatId = chatId;
                    if (type === 'user') {
                        const minId = Math.min(currentUserId, chatId);
                        const maxId = Math.max(currentUserId, chatId);
                        realChatId = `chat_${minId}_${maxId}`;
                    }
                    
                    const node = type === 'group' ? 'groups' : 'chats';
                    window.update(window.ref(window.db, `${node}/${realChatId}/settings/${currentUserId}/wallpaper`), {
                        global_image: window._selectedWallpaperDataUrl
                    }).catch(err => console.error("Error saving chat wallpaper to Firebase:", err));
                }

                window.applyCustomWallpaper(window._activeWallpaperChatId, window._activeWallpaperChatType);
                window.showToast?.('Wallpaper', 'Custom wallpaper set successfully!');
                window.closeWallpaperModal();
            } catch (e) {
                console.error("Error saving wallpaper to localStorage", e);
                window.showToast?.('Error', 'Image too large. Please select a smaller image.', 'error');
            }
        } else {
            window.closeWallpaperModal();
        }
    };

    window.removeWallpaper = function() {
        if (!window._activeWallpaperChatType || !window._activeWallpaperChatId) return;
        
        const currentUserId = window.myUserId || 'default';
        const storageKey = `custom_wallpaper_${currentUserId}_${window._activeWallpaperChatType}_${window._activeWallpaperChatId}`;
        localStorage.removeItem(storageKey);
        
        // ALSO REMOVE FROM FIREBASE
        if (window.db && window.update && window.ref) {
            const type = window._activeWallpaperChatType;
            const chatId = window._activeWallpaperChatId;
            
            let realChatId = chatId;
            if (type === 'user') {
                const minId = Math.min(currentUserId, chatId);
                const maxId = Math.max(currentUserId, chatId);
                realChatId = `chat_${minId}_${maxId}`;
            }
            
            const node = type === 'group' ? 'groups' : 'chats';
            window.update(window.ref(window.db, `${node}/${realChatId}/settings/${currentUserId}/wallpaper`), {
                global_image: null,
                color: null,
                doodles: null
            }).catch(err => console.error("Error removing chat wallpaper from Firebase:", err));
        }

        window.applyCustomWallpaper(window._activeWallpaperChatId, window._activeWallpaperChatType);
        window.showToast?.('Wallpaper', 'Custom wallpaper removed.');
        window.closeWallpaperModal();
    };

    window.applyCustomWallpaper = function(chatId, type) {
        if (!chatId || !type) return;
        
        const currentUserId = window.myUserId || 'default';
        const storageKey = `custom_wallpaper_${currentUserId}_${type}_${chatId}`;
        const colorKey = `custom_wallpaper_color_${currentUserId}_${type}_${chatId}`;
        const doodlesKey = `custom_wallpaper_doodles_${currentUserId}_${type}_${chatId}`;

        // Detach old listener
        if (window.activeChatWallpaperUnsubscribe) {
            window.activeChatWallpaperUnsubscribe();
            window.activeChatWallpaperUnsubscribe = null;
        }

        let realChatId = chatId;
        if (type === 'user') {
            const minId = Math.min(currentUserId, chatId);
            const maxId = Math.max(currentUserId, chatId);
            realChatId = `chat_${minId}_${maxId}`;
        }

        if (window.db && window.ref && window.onValue) {
            const node = type === 'group' ? 'groups' : 'chats';
            const wallpaperRef = window.ref(window.db, `${node}/${realChatId}/settings/${currentUserId}/wallpaper`);
            
            window.activeChatWallpaperUnsubscribe = window.onValue(wallpaperRef, (snapshot) => {
                const data = snapshot.val();
                if (data) {
                    if (data.global_image) localStorage.setItem(storageKey, data.global_image);
                    else if (data.global_image === null) localStorage.removeItem(storageKey);
                    
                    if (data.color) localStorage.setItem(colorKey, data.color);
                    else if (data.color === null) localStorage.removeItem(colorKey);

                    if (data.doodles !== undefined) localStorage.setItem(doodlesKey, data.doodles);
                    else if (data.doodles === null) localStorage.removeItem(doodlesKey);
                } else {
                    localStorage.removeItem(storageKey);
                    localStorage.removeItem(colorKey);
                    localStorage.removeItem(doodlesKey);
                }
                window.renderChatWallpaperStyle(chatId, type);
            });
        } else {
            window.renderChatWallpaperStyle(chatId, type);
        }
    };

    window.renderChatWallpaperStyle = function(chatId, type) {
        if (!chatId || !type) return;
        const currentUserId = window.myUserId || 'default';
        const storageKey = `custom_wallpaper_${currentUserId}_${type}_${chatId}`;
        const colorKey = `custom_wallpaper_color_${currentUserId}_${type}_${chatId}`;
        const doodlesKey = `custom_wallpaper_doodles_${currentUserId}_${type}_${chatId}`;
        
        const wallpaperBase64 = localStorage.getItem(storageKey);
        const chatColor = localStorage.getItem(colorKey);
        const chatDoodles = localStorage.getItem(doodlesKey);
        
        let styleTag = document.getElementById('dynamic_chat_wallpaper');
        if (!styleTag) {
            styleTag = document.createElement('style');
            styleTag.id = 'dynamic_chat_wallpaper';
            document.head.appendChild(styleTag);
        }

        const selector = type === 'user' ? '#messages' : '#group_messages';
        
        if (wallpaperBase64) {
            styleTag.innerHTML = `
                ${selector} {
                    background-image: url('${wallpaperBase64}') !important;
                    background-size: cover !important;
                    background-position: center !important;
                    background-repeat: no-repeat !important;
                    background-blend-mode: normal !important;
                    background-color: transparent !important;
                }
            `;
        } else if (chatColor) {
             const useDoodles = chatDoodles !== 'false';
             if (useDoodles) {
                styleTag.innerHTML = `
                    ${selector} {
                        background-color: ${chatColor} !important;
                        background-image: url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png') !important;
                        background-blend-mode: overlay !important;
                        background-size: auto !important;
                        background-position: left top !important;
                        background-repeat: repeat !important;
                    }
                `;
             } else {
                 styleTag.innerHTML = `
                    ${selector} {
                        background-color: ${chatColor} !important;
                        background-image: none !important;
                    }
                `;
             }
        } else {
            const color = localStorage.getItem(`whatsapp_wallpaper_color_${currentUserId}`) || '#0b141a';
            const doodles = localStorage.getItem(`whatsapp_wallpaper_doodles_${currentUserId}`) !== 'false';
            const globalImg = localStorage.getItem(`whatsapp_wallpaper_global_image_${currentUserId}`);
            
            if (globalImg) {
                styleTag.innerHTML = `
                    ${selector} {
                        background-image: url('${globalImg}') !important;
                        background-size: cover !important;
                        background-position: center !important;
                        background-repeat: no-repeat !important;
                        background-blend-mode: normal !important;
                        background-color: transparent !important;
                    }
                `;
            } else if (doodles) {
                styleTag.innerHTML = `
                    ${selector} {
                        background-color: ${color} !important;
                        background-image: url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png') !important;
                        background-blend-mode: overlay !important;
                        background-size: auto !important;
                        background-position: left top !important;
                        background-repeat: repeat !important;
                    }
                `;
            } else {
                styleTag.innerHTML = `
                    ${selector} {
                        background-color: ${color} !important;
                        background-image: none !important;
                    }
                `;
            }
        }
    };
</script>
