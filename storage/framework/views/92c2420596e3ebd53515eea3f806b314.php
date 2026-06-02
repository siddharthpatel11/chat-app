<div id="media_status_editor" class="hidden fixed inset-0 z-[800] bg-[#0b141a] flex flex-col font-sans overflow-hidden">
    <!-- Top Toolbar -->
    <div class="h-16 flex items-center justify-between px-6 shrink-0 z-10">
        <button onclick="window.closeMediaStatusEditor()" class="text-[#8696a0] hover:text-[#e9edef] transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path
                    d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z">
                </path>
            </svg>
        </button>

        <div id="media_editor_toolbar" class="flex items-center gap-6 text-[#8696a0]">
            <!-- Undo -->
            <button id="btn_undo" onclick="window.undoCanvas()" class="hover:text-[#e9edef] transition-colors"
                title="Undo">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                    <path
                        d="M12.5 8c-2.65 0-5.05.99-6.9 2.6L2 7v9h9l-3.62-3.62c1.39-1.16 3.16-1.88 5.12-1.88 3.54 0 6.55 2.31 7.6 5.5l2.37-.78C21.08 11.03 17.15 8 12.5 8z">
                    </path>
                </svg>
            </button>

            <!-- Magic Wand (Filters) -->
            <button id="tool_filter" onclick="window.applyFilter()" class="hover:text-[#e9edef] transition-colors"
                title="Filters">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                    <path
                        d="M7.5 5.6L10 7 8.6 4.5 10 2 7.5 3.4 5 2l1.4 2.5L5 7zm12 8L17 12.2l1.4 2.5L17 17.2l2.5-1.4 2.5 1.4-1.4-2.5L22 12.2zm0-11L17 4l1.4 2.5L17 9l2.5-1.4L22 9l-1.4-2.5L22 4zM14.3 8.3c-.4-.4-1-.4-1.4 0l-10 10c-.4.4-.4 1 0 1.4l1.4 1.4c.4.4 1 .4 1.4 0l10-10c.4-.4.4-1 0-1.4l-1.4-1.4z">
                    </path>
                </svg>
            </button>

            <!-- Pencil (Draw) -->
            <button id="tool_pencil" onclick="window.setTool('pencil')" class="text-[#00a884] transition-colors"
                title="Draw">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                    <path
                        d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z">
                    </path>
                </svg>
            </button>

            <!-- Text -->
            <button id="tool_text" onclick="window.setTool('text')"
                class="hover:text-[#e9edef] transition-colors font-bold text-xl" title="Add Text">T</button>

            <!-- Crop -->
            <button id="tool_crop" onclick="window.setTool('crop')" class="hover:text-[#e9edef] transition-colors" title="Crop">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                    <path d="M17 15h2V7c0-1.1-.9-2-2-2H9v2h8v8zM7 17V1H5v4H1v2h4v10c0 1.1.9 2 2 2h10v4h2v-4h4v-2H7z"></path>
                </svg>
            </button>

            <!-- Rotate -->
            <button id="tool_rotate" onclick="window.rotateMedia()" class="hover:text-[#e9edef] transition-colors" title="Rotate">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                    <path d="M15.55 5.55L11 1v4.07C7.06 5.56 4 8.93 4 13s3.05 7.44 7 7.93v-2.02c-2.84-.48-5-2.94-5-5.91s2.16-5.43 5-5.91V12l4.55-4.45zM19.93 11c-.17-1.39-.72-2.73-1.62-3.89l-1.42 1.42c.54.75.88 1.6 1.02 2.47h2.02zM13 17.93c.87-.14 1.72-.48 2.47-1.02l1.42 1.42c-1.16.9-2.5 1.45-3.89 1.62v-2.02zM17.31 15.52l1.42 1.42c.9-1.16 1.45-2.5 1.62-3.89h-2.02c-.14.87-.48 1.72-1.02 2.47z"></path>
                </svg>
            </button>
        </div>

        <div class="flex items-center gap-4">
            <!-- HD Toggle -->
            <button id="media_hd_btn" onclick="window.toggleHD()"
                class="text-[#8696a0] hover:text-[#e9edef] transition-colors flex items-center gap-1 border border-current rounded px-1.5 py-0.5 text-[11px] font-bold">
                HD
            </button>
        </div>
    </div>


    <!-- Main Preview Area -->
    <div id="media_preview_container"
        class="flex-1 flex flex-col items-center justify-center p-4 relative overflow-hidden select-none">
        
        <!-- Cropping Layer -->
        <div id="crop_container" class="hidden absolute inset-0 z-20 bg-[#0b141a] flex flex-col items-center justify-center p-10">
            <div class="flex-1 w-full flex items-center justify-center overflow-hidden">
                <img id="crop_image" src="" class="max-w-full max-h-full">
            </div>
            <div class="h-20 flex items-center gap-6 mt-4">
                <button onclick="window.cancelCrop()" class="px-6 py-2 rounded-full text-[#8696a0] hover:text-[#e9edef] font-medium transition-colors">Cancel</button>
                <button onclick="window.applyCrop()" class="px-8 py-2 rounded-full bg-[#00a884] text-[#0b141a] font-bold hover:bg-[#06cf9c] transition-all active:scale-95">Done</button>
            </div>
        </div>
        <!-- Canvas for drawing/text -->
        <canvas id="media_canvas" class="max-w-full max-h-full object-contain cursor-crosshair"></canvas>
        <video id="media_video_preview" class="hidden max-w-full max-h-full object-contain"></video>

        <div id="media_placeholder" class="text-[#8696a0] text-center absolute">
            <p>Loading media...</p>
        </div>
    </div>

    <!-- Caption Input Area -->
    <div class="px-6 py-4 flex flex-col items-center gap-4 z-10">
        <div
            class="w-full max-w-2xl relative flex items-center bg-[#2a3942] rounded-xl px-4 py-3 shadow-lg focus-within:ring-1 ring-[#00a884]/50 transition-all">
            <button id="media_emoji_btn"
                class="text-[#8696a0] hover:text-[#e9edef] transition-colors mr-3 active:scale-90">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path
                        d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5s.67 1.5 1.5 1.5zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z">
                    </path>
                </svg>
            </button>
            <input id="media_caption_input" type="text" placeholder="Add a caption"
                class="flex-1 bg-transparent border-none text-[#e9edef] text-[15px] focus:outline-none placeholder:text-[#8696a0]">

            <!-- Emoji Picker -->
            <div id="media_emoji_picker"
                class="hidden absolute bottom-full left-0 mb-4 w-[280px] bg-[#233138] rounded-2xl shadow-2xl overflow-hidden border border-white/5 flex flex-col z-[810] animate-in slide-in-from-bottom-2 duration-200">
                <div class="p-3 border-b border-[#2a3942] flex items-center justify-between">
                    <span class="text-[#e9edef] text-sm font-medium">Emojis</span>
                </div>
                <div class="h-[200px] overflow-y-auto p-2 custom-scrollbar">
                    <div class="grid grid-cols-6 gap-1">
                        <?php
                            $emojis = ['😀', '😃', '😄', '😁', '😆', '😅', '😂', '🤣', '😊', '😇', '🙂', '🙃', '😉', '😌', '😍', '🥰', '😘', '😗', '😙', '😚', '😋', '😛', '😝', '😜', '🤪', '🤨', '🧐', '🤓', '😎', '🤩', '🥳', '😏', '😒', '😞', '😔', '😟', '😕', '🙁', '☹️', '😣', '😖', '😫', '😩', '🥺', '😢', '😭', '😤', '😠', '😡', '🤬', '🤯', '😳', '🥵', '🥶', '😱', '😨', '😰', '😥', '😓', '🤗', '🤔', '🤭', '🤫', '🤥', '😶', '😐', '😑', '😬', '🙄', '😯', '😦', '😧', '😮', '😲', '🥱', '😴', '🤤', '😪', '😵', '🤐', '🥴', '🤢', '🤮', '🤧', '😷', '🤒', '🤕', '🤑', '🤠', '😈', '👿', '👹', '👺', '🤡', '👻', '💀', '☠️', '👽', '👾', '🤖', '🎃', '😺', '😸', '😹', '😻', '😼', '😽', '🙀', '😿', '😾'];
                        ?>
                        <?php $__currentLoopData = $emojis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emoji): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button onclick="window.insertMediaEmoji('<?php echo e($emoji); ?>')"
                                class="text-[24px] p-1 hover:bg-white/5 rounded transition-all active:scale-90"><?php echo e($emoji); ?></button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Thumbnails and Send -->
    <div class="h-24 px-6 mb-4 flex items-center justify-between shrink-0 z-10">
        <div class="flex items-center gap-3">
            <button onclick="window.openStatusPrivacy()" class="bg-[#111b21]/50 rounded-full px-4 py-2 flex items-center gap-2 border border-white/5 hover:bg-[#202c33] transition-colors cursor-pointer">
                <svg viewBox="0 0 24 24" width="16" height="16" class="text-[#00a884]" fill="currentColor">
                    <path
                        d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm1 14.5h-2v-2h2v2zm0-4h-2v-6h2v6z">
                    </path>
                </svg>
                <span class="text-[#00a884] text-[13px] font-medium" id="status_privacy_label">Status (Contacts)</span>
            </button>
        </div>

        <!-- Thumbnails Container -->
        <div class="flex-1 flex justify-center items-center gap-3 overflow-x-auto px-4 no-scrollbar">
            <div id="media_thumbnails_list" class="flex items-center gap-2">
                <!-- Thumbnails injected here -->
            </div>
            <button onclick="window.addMoreMedia()"
                class="w-12 h-12 rounded-xl bg-[#202c33] flex items-center justify-center text-[#8696a0] hover:bg-[#2a3942] border border-white/5 transition-all active:scale-95">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                </svg>
            </button>
        </div>

        <button id="send_media_status_btn" onclick="window.postMediaStatus()"
            class="w-14 h-14 bg-[#00a884] rounded-full flex items-center justify-center text-white shadow-lg hover:bg-[#06cf9c] active:scale-95 transition-all transform scale-110">
            <svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor" class="ml-1">
                <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path>
            </svg>
            <!-- Media Count Badge -->
            <div id="media_count_badge" class="absolute -top-1 -right-1 bg-[#00a884] text-[#0b141a] text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center border-2 border-[#0b141a] hidden">
                <span id="media_count_label">0</span>
            </div>
            <!-- Progress Overlay for uploading -->
            <div id="upload_progress_ring" class="hidden absolute inset-0 flex items-center justify-center">
                <svg class="w-full h-full transform -rotate-90">
                    <circle cx="28" cy="28" r="24" stroke="currentColor" stroke-width="4" fill="transparent"
                        class="text-white/20" />
                    <circle id="upload_progress_circle" cx="28" cy="28" r="24" stroke="currentColor" stroke-width="4"
                        fill="transparent" stroke-dasharray="150" stroke-dashoffset="150"
                        class="text-white transition-all duration-200" />
                </svg>
            </div>
        </button>
    </div>

    <!-- Hidden File Input -->
    <input type="file" id="media_status_input" class="hidden" accept="image/*,video/*" multiple
        onchange="window.handleMediaStatusSelection(event)">
</div>

<!-- Status Privacy Modal -->
    <div id="status_privacy_modal" class="hidden fixed inset-0 z-[850] flex items-center justify-center bg-black/50 opacity-0 transition-opacity duration-200">
        <div class="bg-[#233138] w-full max-w-[400px] rounded-xl shadow-2xl flex flex-col overflow-hidden transform scale-95 transition-transform duration-200" id="status_privacy_modal_content">
            <div class="h-14 flex items-center px-4 border-b border-white/5">
                <button onclick="window.closeStatusPrivacy()" class="text-[#8696a0] hover:text-[#e9edef] mr-4">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path></svg>
                </button>
                <h2 class="text-[#e9edef] text-[16px] font-medium">Status privacy</h2>
            </div>
            <div class="p-5 flex flex-col gap-5">
                <p class="text-[#8696a0] text-sm">Who can see my status updates</p>
                
                <label class="flex items-center gap-4 cursor-pointer group">
                    <div class="relative flex items-center justify-center">
                        <input type="radio" name="status_privacy" value="all" class="peer sr-only" checked onclick="window.handlePrivacyModeChange('all')">
                        <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] transition-colors"></div>
                        <div class="absolute w-2.5 h-2.5 rounded-full bg-[#00a884] opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <div class="flex flex-col flex-1">
                        <span class="text-[#e9edef] text-base group-hover:text-white transition-colors">My contacts</span>
                        <span class="text-[#8696a0] text-[13px]">Share with all of your contacts</span>
                    </div>
                </label>

                <label class="flex items-center gap-4 cursor-pointer group">
                    <div class="relative flex items-center justify-center">
                        <input type="radio" name="status_privacy" value="except" class="peer sr-only" onclick="window.handlePrivacyModeChange('except')">
                        <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] transition-colors"></div>
                        <div class="absolute w-2.5 h-2.5 rounded-full bg-[#00a884] opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <div class="flex flex-col flex-1">
                        <span class="text-[#e9edef] text-base group-hover:text-white transition-colors">My contacts except...</span>
                        <span id="privacy_except_count_text" class="text-[#8696a0] text-[13px]">Share with your contacts except people you select</span>
                    </div>
                </label>

                <label class="flex items-center gap-4 cursor-pointer group">
                    <div class="relative flex items-center justify-center">
                        <input type="radio" name="status_privacy" value="only" class="peer sr-only" onclick="window.handlePrivacyModeChange('only')">
                        <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] transition-colors"></div>
                        <div class="absolute w-2.5 h-2.5 rounded-full bg-[#00a884] opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                    <div class="flex flex-col flex-1">
                        <span class="text-[#e9edef] text-base group-hover:text-white transition-colors">Only share with...</span>
                        <span id="privacy_only_count_text" class="text-[#8696a0] text-[13px]">Share with selected contacts</span>
                    </div>
                </label>
            </div>
        </div>
    </div>

    <!-- Contact Selection Modal -->
    <div id="contact_selection_modal" class="hidden fixed inset-0 z-[900] bg-[#111b21] flex flex-col transform translate-x-full transition-transform duration-300">
        <div class="h-16 bg-[#202c33] flex items-center px-4 shrink-0 border-b border-white/5 gap-4">
            <button onclick="window.closeContactSelection()" class="text-[#8696a0] hover:text-[#e9edef]">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path></svg>
            </button>
            <div class="flex flex-col">
                <h2 id="contact_selection_title" class="text-[#e9edef] text-[19px] font-medium">My contacts except...</h2>
                <span id="contact_selection_subtitle" class="text-[#8696a0] text-[13px]">0 contacts excluded</span>
            </div>
        </div>
        
        <div class="p-3 border-b border-[#202c33] bg-[#111b21] shrink-0">
            <div class="bg-[#202c33] rounded-lg flex items-center px-3 py-1.5 h-9 focus-within:bg-[#2a3942] transition-colors border border-white/5 focus-within:border-[#00a884]/50">
                <svg class="w-[18px] h-[18px] text-[#8696a0]" fill="currentColor" viewBox="0 0 24 24"><path d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 0 0 1.256-3.386 5.207 5.207 0 1 0-5.207 5.208 5.183 5.183 0 0 0 3.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-4.6-1.598a3.608 3.608 0 1 1 0-7.216 3.608 3.608 0 0 1 0 7.216z"></path></svg>
                <input type="text" id="contact_search_input" oninput="window.filterPrivacyContacts()" placeholder="Search name or number" class="bg-transparent border-none focus:ring-0 w-full text-[14px] ml-4 text-[#d1d7db] placeholder-[#8696a0] outline-none">
            </div>
        </div>

        <div class="px-5 pt-4 pb-2">
            <span class="text-[#8696a0] text-[14px] font-medium">Contacts</span>
        </div>

        <div class="flex-1 overflow-y-auto custom-scrollbar" id="privacy_contact_list">
            <!-- Contacts injected here via JS -->
        </div>

        <div class="p-4 bg-[#202c33] border-t border-white/5 flex justify-end shrink-0">
            <button onclick="window.saveContactSelection()" class="w-14 h-14 bg-[#00a884] rounded-full flex items-center justify-center text-white shadow-lg hover:bg-[#06cf9c] active:scale-95 transition-all">
                <svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path></svg>
            </button>
    </div>
</div>

<script>
    let selectedMediaItems = [];
    let activeMediaIndex = 0;

    window.openMediaStatusSelection = function () {
        document.getElementById('media_status_input').click();
    };

    window.addMoreMedia = function () {
        document.getElementById('media_status_input').click();
    };

    window.handleMediaStatusSelection = function (event) {
        const files = event.target.files;
        if (!files.length) return;

        const prevLength = selectedMediaItems.length;
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const type = file.type.startsWith('image/') ? 'image' : 'video';
            const url = URL.createObjectURL(file);

            selectedMediaItems.push({
                file: file,
                type: type,
                url: url,
                caption: '',
                rotation: 0,
                filter: 'none',
                isHD: false,
                canvasData: null,
                textElements: []
            });
        }

        if (selectedMediaItems.length > 0) {
            document.getElementById('media_status_editor').classList.remove('hidden');
            renderActiveMedia();
            renderThumbnails();
        }

        event.target.value = '';
    };

    let currentTool = 'pencil';
    let currentColor = '#ffffff';
    let isDrawing = false;
    let canvasHistory = [];

    function renderActiveMedia() {
        const item = selectedMediaItems[activeMediaIndex];
        const container = document.getElementById('media_preview_container');
        const captionInput = document.getElementById('media_caption_input');
        const canvas = document.getElementById('media_canvas');
        const video = document.getElementById('media_video_preview');
        const ctx = canvas.getContext('2d');

        document.getElementById('media_placeholder').classList.add('hidden');

        if (item.type === 'image') {
            canvas.classList.remove('hidden');
            video.classList.add('hidden');

            const img = new Image();
            img.onload = () => {
                const maxWidth = container.clientWidth - 40;
                const maxHeight = container.clientHeight - 40;
                let width = img.width;
                let height = img.height;

                const ratio = Math.min(maxWidth / width, maxHeight / height);
                canvas.width = width * ratio;
                canvas.height = height * ratio;

                ctx.clearRect(0, 0, canvas.width, canvas.height);

                // Apply filter
                ctx.filter = item.filter || 'none';

                ctx.save();
                ctx.translate(canvas.width / 2, canvas.height / 2);
                ctx.rotate((item.rotation * Math.PI) / 180);
                ctx.drawImage(img, -canvas.width / 2, -canvas.height / 2, canvas.width, canvas.height);
                ctx.restore();

                ctx.filter = 'none';

                if (item.canvasData) {
                    const savedImg = new Image();
                    savedImg.onload = () => ctx.drawImage(savedImg, 0, 0);
                    savedImg.src = item.canvasData;
                }
            };
            img.src = item.url;
        } else {
            canvas.classList.add('hidden');
            video.classList.remove('hidden');
            video.src = item.url;
            video.style.filter = item.filter || 'none';
            video.style.transform = `rotate(${item.rotation}deg)`;
        }

        captionInput.value = item.caption;
        captionInput.oninput = (e) => { item.caption = e.target.value; };

        const hdBtn = document.getElementById('media_hd_btn');
        if (item.isHD) {
            hdBtn.classList.replace('text-[#8696a0]', 'text-[#00a884]');
            hdBtn.classList.replace('border-current', 'border-[#00a884]');
        } else {
            hdBtn.classList.remove('text-[#00a884]');
            hdBtn.classList.add('text-[#8696a0]');
            hdBtn.classList.add('border-current');
            hdBtn.classList.remove('border-[#00a884]');
        }
        const countBadge = document.getElementById('media_count_badge');
        const countLabel = document.getElementById('media_count_label');
        if (countBadge && countLabel) {
            const count = selectedMediaItems.length;
            countLabel.textContent = count;
            if (count > 1) {
                countBadge.classList.remove('hidden');
            } else {
                countBadge.classList.add('hidden');
            }
        }
    }

    const canvas = document.getElementById('media_canvas');
    const ctx = canvas.getContext('2d');

    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);

    function startDrawing(e) {
        if (currentTool !== 'pencil') {
            if (currentTool === 'text') addTextAt(e.offsetX, e.offsetY);
            return;
        }
        isDrawing = true;
        ctx.beginPath();
        ctx.moveTo(e.offsetX, e.offsetY);
        ctx.strokeStyle = currentColor;
        ctx.lineWidth = 4;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        saveCanvasState();
    }

    function draw(e) {
        if (!isDrawing || currentTool !== 'pencil') return;
        ctx.lineTo(e.offsetX, e.offsetY);
        ctx.stroke();
    }

    function stopDrawing() {
        if (isDrawing) {
            isDrawing = false;
            selectedMediaItems[activeMediaIndex].canvasData = canvas.toDataURL();
        }
    }

    function addTextAt(x, y) {
        const text = prompt("Enter text:");
        if (!text) return;
        ctx.font = "bold 30px Arial";
        ctx.fillStyle = currentColor;
        ctx.fillText(text, x, y);
        selectedMediaItems[activeMediaIndex].canvasData = canvas.toDataURL();
    }

    let cropper = null;

    window.setTool = function (tool) {
        currentTool = tool;
        const tools = ['pencil', 'text', 'filter', 'crop'];
        tools.forEach(t => {
            const el = document.getElementById('tool_' + t);
            if (el) {
                if (t === tool) {
                    el.classList.add('text-[#00a884]');
                    el.classList.remove('text-[#8696a0]', 'hover:text-[#e9edef]');
                } else {
                    el.classList.remove('text-[#00a884]');
                    el.classList.add('text-[#8696a0]', 'hover:text-[#e9edef]');
                }
            }
        });
        
        if (tool === 'crop') {
            startCropping();
        }
    };

    function startCropping() {
        const item = selectedMediaItems[activeMediaIndex];
        if (item.type !== 'image') return;

        const cropContainer = document.getElementById('crop_container');
        const cropImg = document.getElementById('crop_image');
        
        cropImg.src = item.url;
        cropContainer.classList.remove('hidden');

        if (cropper) cropper.destroy();
        
        // Timeout to ensure image is loaded before cropper init
        setTimeout(() => {
            cropper = new Cropper(cropImg, {
                aspectRatio: NaN,
                viewMode: 1,
                guides: true,
                center: true,
                highlight: false,
                background: false,
                autoCropArea: 0.8,
                responsive: true
            });
        }, 100);
    }

    window.applyCrop = function () {
        if (!cropper) return;
        const item = selectedMediaItems[activeMediaIndex];
        const canvas = cropper.getCroppedCanvas();
        
        // Convert canvas to blob and then to file to replace the original
        canvas.toBlob((blob) => {
            const croppedFile = new File([blob], item.file.name, { type: 'image/jpeg' });
            item.file = croppedFile;
            item.url = URL.createObjectURL(croppedFile);
            
            window.cancelCrop();
            renderActiveMedia();
        }, 'image/jpeg', 0.9);
    };

    window.cancelCrop = function() {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        document.getElementById('crop_container').classList.add('hidden');
        window.setTool('pencil');
    };

    const filters = ['none', 'grayscale(100%)', 'sepia(100%)', 'invert(100%)', 'brightness(150%)', 'contrast(200%)', 'hue-rotate(90deg)'];
    let currentFilterIndex = 0;

    window.applyFilter = function () {
        const item = selectedMediaItems[activeMediaIndex];
        currentFilterIndex = (currentFilterIndex + 1) % filters.length;
        item.filter = filters[currentFilterIndex];
        renderActiveMedia();
        window.setTool('filter');
    };

    window.setMediaColor = function (color) { currentColor = color; };

    function saveCanvasState() {
        canvasHistory.push(canvas.toDataURL());
        if (canvasHistory.length > 20) canvasHistory.shift();
    }

    window.undoCanvas = function () {
        if (canvasHistory.length === 0) {
            const item = selectedMediaItems[activeMediaIndex];
            item.canvasData = null;
            item.filter = 'none';
            item.rotation = 0;
            renderActiveMedia();
            return;
        }
        const lastState = canvasHistory.pop();
        const img = new Image();
        img.onload = () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(img, 0, 0);
            selectedMediaItems[activeMediaIndex].canvasData = canvas.toDataURL();
        };
        img.src = lastState;
    };

    window.rotateMedia = function () {
        const item = selectedMediaItems[activeMediaIndex];
        item.rotation = (item.rotation + 90) % 360;
        renderActiveMedia();
        window.setTool('rotate');
    };

    window.toggleHD = function () {
        const item = selectedMediaItems[activeMediaIndex];
        item.isHD = !item.isHD;
        renderActiveMedia();
    };

    function renderThumbnails() {
        const list = document.getElementById('media_thumbnails_list');
        list.innerHTML = '';

        selectedMediaItems.forEach((item, index) => {
            const thumb = document.createElement('div');
            thumb.className = `w-14 h-14 rounded-xl overflow-hidden border-2 cursor-pointer transition-all active:scale-95 shrink-0 relative group ${index === activeMediaIndex ? 'border-[#00a884] scale-110 z-10' : 'border-transparent opacity-60 hover:opacity-100'}`;
            thumb.onclick = () => {
                activeMediaIndex = index;
                renderActiveMedia();
                renderThumbnails();
            };

            if (item.type === 'image') {
                const img = document.createElement('img');
                img.src = item.url;
                img.className = 'w-full h-full object-cover';
                thumb.appendChild(img);
            } else {
                const video = document.createElement('video');
                video.src = item.url;
                video.className = 'w-full h-full object-cover';
                thumb.appendChild(video);
                // Add play icon overlay for video thumb
                const playIcon = document.createElement('div');
                playIcon.className = 'absolute inset-0 flex items-center justify-center bg-black/20';
                playIcon.innerHTML = '<svg viewBox="0 0 24 24" width="20" height="20" fill="white"><path d="M8 5v14l11-7z"></path></svg>';
                thumb.appendChild(playIcon);
            }

            // Remove button
            const removeBtn = document.createElement('button');
            removeBtn.className = 'absolute top-0.5 right-0.5 w-4 h-4 bg-black/60 rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-500';
            removeBtn.innerHTML = '<svg viewBox="0 0 24 24" width="10" height="10" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path></svg>';
            removeBtn.onclick = (e) => window.removeMediaItem(index, e);
            thumb.appendChild(removeBtn);

            list.appendChild(thumb);
        });
    }

    window.removeMediaItem = function(index, event) {
        if (event) event.stopPropagation();
        
        // Revoke URL to free memory
        URL.revokeObjectURL(selectedMediaItems[index].url);
        
        selectedMediaItems.splice(index, 1);
        
        if (selectedMediaItems.length === 0) {
            window.closeMediaStatusEditor();
        } else {
            // Adjust active index if needed
            if (activeMediaIndex >= selectedMediaItems.length) {
                activeMediaIndex = selectedMediaItems.length - 1;
            }
            renderActiveMedia();
            renderThumbnails();
        }
    };

    window.closeMediaStatusEditor = function () {
        selectedMediaItems.forEach(item => URL.revokeObjectURL(item.url));
        selectedMediaItems = [];
        activeMediaIndex = 0;
        document.getElementById('media_status_editor').classList.add('hidden');
    };

    window.postMediaStatus = async function () {
        if (selectedMediaItems.length === 0) return;

        const btn = document.getElementById('send_media_status_btn');
        const ring = document.getElementById('upload_progress_ring');
        const circle = document.getElementById('upload_progress_circle');

        btn.disabled = true;
        ring.classList.remove('hidden');

        try {
            for (let i = 0; i < selectedMediaItems.length; i++) {
                const item = selectedMediaItems[i];

                // Upload to local Laravel server instead of Firebase Storage
                const formData = new FormData();
                formData.append('file', item.file);
                formData.append('_token', '<?php echo e(csrf_token()); ?>');

                const response = await fetch('/upload-status-media', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();
                if (!result.status) throw new Error('Upload failed');

                const downloadURL = result.url;

                const statusData = {
                    userId: window.myUserId,
                    userName: window.myUserName,
                    userAvatar: window.myUserAvatar,
                    mediaUrl: downloadURL,
                    text: item.caption,
                    type: item.type,
                    timestamp: window.serverTimestamp(),
                    viewers: {},
                    privacyMode: window.currentPrivacyMode,
                    privacyContacts: window.currentPrivacyContacts
                };

                const statusRef = window.ref(window.db, `statuses/${window.myUserId}`);
                await window.push(statusRef, statusData);
            }

            window.closeMediaStatusEditor();
            if (window.showToast) window.showToast('Status Posted', 'Your media status has been updated.');
        } catch (e) {
            console.error('Post media status error:', e);
            alert('Failed to upload media to your server.');
        } finally {
            btn.disabled = false;
            ring.classList.add('hidden');
        }
    };

    // Emoji Picker Logic
    document.getElementById('media_emoji_btn').addEventListener('click', (e) => {
        e.stopPropagation();
        const picker = document.getElementById('media_emoji_picker');
        picker.classList.toggle('hidden');
    });

    window.insertMediaEmoji = function (emoji) {
        const input = document.getElementById('media_caption_input');
        const start = input.selectionStart;
        const end = input.selectionEnd;
        const text = input.value;
        input.value = text.substring(0, start) + emoji + text.substring(end);
        input.focus();
        input.setSelectionRange(start + emoji.length, start + emoji.length);

        // Update model
        selectedMediaItems[activeMediaIndex].caption = input.value;
    };

    // Close on outside click
    document.addEventListener('click', (e) => {
        const picker = document.getElementById('media_emoji_picker');
        const btn = document.getElementById('media_emoji_btn');
        if (picker && !picker.classList.contains('hidden')) {
            if (!picker.contains(e.target) && !btn.contains(e.target)) {
                picker.classList.add('hidden');
            }
        }
    });
    // Privacy Logic
    window.currentPrivacyMode = 'all'; // 'all', 'except', 'only'
    window.currentPrivacyContacts = []; // Array of user IDs
    
    window.syncPrivacyFromStorage = function() {
        const savedStatus = localStorage.getItem('whatsapp_privacy_status') || 'My contacts';
        if (savedStatus === 'My contacts' || (!savedStatus.includes('excluded') && !savedStatus.includes('included') && savedStatus !== 'My contacts except...')) {
            window.currentPrivacyMode = 'all';
            window.currentPrivacyContacts = [];
        } else if (savedStatus.includes('excluded') || savedStatus === 'My contacts except...') {
            window.currentPrivacyMode = 'except';
            const savedData = localStorage.getItem('whatsapp_privacy_exclude_status');
            window.currentPrivacyContacts = savedData ? JSON.parse(savedData) : [];
        } else {
            window.currentPrivacyMode = 'only';
            const savedData = localStorage.getItem('whatsapp_privacy_exclude_status_include');
            window.currentPrivacyContacts = savedData ? JSON.parse(savedData) : [];
        }
        updatePrivacyLabel();
    };
    
    // Initial sync
    window.syncPrivacyFromStorage();
    
    let tempPrivacyMode = 'all';
    let tempPrivacyContacts = [];

    window.openStatusPrivacy = function() {
        window.syncPrivacyFromStorage(); // Sync again just in case it was changed in settings
        tempPrivacyMode = window.currentPrivacyMode;
        tempPrivacyContacts = [...window.currentPrivacyContacts];
        
        document.querySelector(`input[name="status_privacy"][value="${tempPrivacyMode}"]`).checked = true;
        updatePrivacyTexts();

        const modal = document.getElementById('status_privacy_modal');
        const content = document.getElementById('status_privacy_modal_content');
        modal.classList.remove('hidden');
        
        // Trigger animation
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
        }, 10);
    };

    window.closeStatusPrivacy = function() {
        const modal = document.getElementById('status_privacy_modal');
        const content = document.getElementById('status_privacy_modal_content');
        modal.classList.add('opacity-0');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    };

    window.handlePrivacyModeChange = function(mode) {
        if (mode === 'all') {
            window.currentPrivacyMode = mode;
            window.currentPrivacyContacts = [];
            localStorage.setItem('whatsapp_privacy_status', 'My contacts');
            updatePrivacyTexts();
            updatePrivacyLabel();
            window.closeStatusPrivacy();
        } else {
            tempPrivacyMode = mode;
            window.openContactSelection(mode);
        }
    };

    function updatePrivacyTexts() {
        const exceptText = document.getElementById('privacy_except_count_text');
        const onlyText = document.getElementById('privacy_only_count_text');
        
        if (window.currentPrivacyMode === 'except') {
            const count = window.currentPrivacyContacts.length;
            exceptText.textContent = `${count} contact${count !== 1 ? 's' : ''} excluded`;
            exceptText.classList.add('text-[#00a884]');
        } else {
            exceptText.textContent = 'Share with your contacts except people you select';
            exceptText.classList.remove('text-[#00a884]');
        }

        if (window.currentPrivacyMode === 'only') {
            const count = window.currentPrivacyContacts.length;
            onlyText.textContent = `${count} contact${count !== 1 ? 's' : ''} included`;
            onlyText.classList.add('text-[#00a884]');
        } else {
            onlyText.textContent = 'Share with selected contacts';
            onlyText.classList.remove('text-[#00a884]');
        }
    }

    function updatePrivacyLabel() {
        const label = document.getElementById('status_privacy_label');
        const textLabel = document.getElementById('text_status_privacy_label');
        const settingsLabel = document.getElementById('privacy_status_label');
        
        let statusTabLabel = '';
        let settingsTabLabel = '';
        
        if (window.currentPrivacyMode === 'all') {
            statusTabLabel = 'Status (Contacts)';
            settingsTabLabel = 'My contacts';
        } else if (window.currentPrivacyMode === 'except') {
            const count = window.currentPrivacyContacts.length;
            statusTabLabel = `Status (${count} excluded)`;
            settingsTabLabel = `${count} contact${count !== 1 ? 's' : ''} excluded`;
        } else {
            const count = window.currentPrivacyContacts.length;
            statusTabLabel = `Status (${count} included)`;
            settingsTabLabel = `${count} contact${count !== 1 ? 's' : ''} included`;
        }
        
        if (label) label.textContent = statusTabLabel;
        if (textLabel) textLabel.textContent = statusTabLabel;
        if (settingsLabel) settingsLabel.textContent = settingsTabLabel;
    }

    window.openContactSelection = function(mode) {
        const modal = document.getElementById('contact_selection_modal');
        const title = document.getElementById('contact_selection_title');
        
        title.textContent = mode === 'except' ? 'My contacts except...' : 'Only share with...';
        
        // If switching mode, reset temp contacts if it differs from current
        if (mode !== window.currentPrivacyMode) {
            tempPrivacyContacts = [];
        } else {
            tempPrivacyContacts = [...window.currentPrivacyContacts];
        }

        document.getElementById('contact_search_input').value = '';
        renderPrivacyContacts('');
        
        modal.classList.remove('hidden');
        // Trigger animation
        setTimeout(() => {
            modal.classList.remove('translate-x-full');
        }, 10);
    };

    window.closeContactSelection = function() {
        const modal = document.getElementById('contact_selection_modal');
        modal.classList.add('translate-x-full');
        setTimeout(() => {
            modal.classList.add('hidden');
            // Revert radio button if canceled
            document.querySelector(`input[name="status_privacy"][value="${window.currentPrivacyMode}"]`).checked = true;
        }, 300);
    };

    window.saveContactSelection = function() {
        window.currentPrivacyMode = tempPrivacyMode;
        window.currentPrivacyContacts = [...tempPrivacyContacts];
        
        // Sync to localStorage so settings panel sees it
        if (window.currentPrivacyMode === 'except') {
            localStorage.setItem('whatsapp_privacy_exclude_status', JSON.stringify(window.currentPrivacyContacts));
            const count = window.currentPrivacyContacts.length;
            localStorage.setItem('whatsapp_privacy_status', `${count} contact${count !== 1 ? 's' : ''} excluded`);
        } else if (window.currentPrivacyMode === 'only') {
            localStorage.setItem('whatsapp_privacy_exclude_status_include', JSON.stringify(window.currentPrivacyContacts));
            const count = window.currentPrivacyContacts.length;
            localStorage.setItem('whatsapp_privacy_status', `${count} contact${count !== 1 ? 's' : ''} included`);
        }
        
        updatePrivacyTexts();
        updatePrivacyLabel();
        
        const modal = document.getElementById('contact_selection_modal');
        modal.classList.add('translate-x-full');
        setTimeout(() => {
            modal.classList.add('hidden');
            window.closeStatusPrivacy();
        }, 300);
    };

    window.togglePrivacyContact = function(id) {
        const index = tempPrivacyContacts.indexOf(id);
        if (index > -1) {
            tempPrivacyContacts.splice(index, 1);
        } else {
            tempPrivacyContacts.push(id);
        }
        updateSelectionSubtitle();
        
        // Update checkbox UI visually
        const checkbox = document.getElementById(`privacy_check_${id}`);
        if(checkbox) {
            const inner = checkbox.querySelector('.check-inner');
            if(tempPrivacyContacts.includes(id)) {
                checkbox.classList.add('bg-[#00a884]', 'border-[#00a884]');
                checkbox.classList.remove('border-[#8696a0]');
                inner.classList.remove('hidden');
            } else {
                checkbox.classList.remove('bg-[#00a884]', 'border-[#00a884]');
                checkbox.classList.add('border-[#8696a0]');
                inner.classList.add('hidden');
            }
        }
    };

    function updateSelectionSubtitle() {
        const subtitle = document.getElementById('contact_selection_subtitle');
        const count = tempPrivacyContacts.length;
        if (tempPrivacyMode === 'except') {
            subtitle.textContent = `${count} contact${count !== 1 ? 's' : ''} excluded`;
        } else {
            subtitle.textContent = `${count} contact${count !== 1 ? 's' : ''} included`;
        }
    }

    window.filterPrivacyContacts = function() {
        const q = document.getElementById('contact_search_input').value.toLowerCase();
        renderPrivacyContacts(q);
    };

    function renderPrivacyContacts(query) {
        const list = document.getElementById('privacy_contact_list');
        list.innerHTML = '';
        
        const contacts = window.allContacts || [];
        
        contacts.forEach(user => {
            const name = user.name || user.phone;
            if (query && !name.toLowerCase().includes(query)) return;

            const isSelected = tempPrivacyContacts.includes(user.id);
            const avatar = user.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=2a3942&color=fff`;

            const checkColorClasses = isSelected ? 'bg-[#00a884] border-[#00a884]' : 'border-[#8696a0]';
            const checkInnerClass = isSelected ? '' : 'hidden';

            const html = `
                <div class="flex items-center px-5 py-3 hover:bg-[#202c33] cursor-pointer transition-colors" onclick="window.togglePrivacyContact(${user.id})">
                    <div class="mr-5 shrink-0">
                        <div id="privacy_check_${user.id}" class="w-5 h-5 rounded border-2 ${checkColorClasses} flex items-center justify-center transition-colors">
                            <svg class="check-inner w-3.5 h-3.5 text-white ${checkInnerClass}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                    </div>
                    <div class="w-10 h-10 rounded-full overflow-hidden bg-[#2a3942] shrink-0">
                        <img src="${avatar}" class="w-full h-full object-cover">
                    </div>
                    <div class="ml-4 flex flex-col justify-center border-b border-[#202c33]/50 pb-2 flex-1 min-w-0 h-full">
                        <h4 class="text-[17px] text-[#e9edef] truncate font-normal">${name}</h4>
                        ${user.about ? `<p class="text-[13px] text-[#8696a0] truncate">${user.about}</p>` : ''}
                    </div>
                </div>
            `;
            list.insertAdjacentHTML('beforeend', html);
        });

        updateSelectionSubtitle();
    }

</script>

<style>

    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
<?php /**PATH D:\xampp\htdocs\laravel\chat_app\resources\views/chat/status/media_status.blade.php ENDPATH**/ ?>