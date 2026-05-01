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
                        @php
                            $emojis = ['😀', '😃', '😄', '😁', '😆', '😅', '😂', '🤣', '😊', '😇', '🙂', '🙃', '😉', '😌', '😍', '🥰', '😘', '😗', '😙', '😚', '😋', '😛', '😝', '😜', '🤪', '🤨', '🧐', '🤓', '😎', '🤩', '🥳', '😏', '😒', '😞', '😔', '😟', '😕', '🙁', '☹️', '😣', '😖', '😫', '😩', '🥺', '😢', '😭', '😤', '😠', '😡', '🤬', '🤯', '😳', '🥵', '🥶', '😱', '😨', '😰', '😥', '😓', '🤗', '🤔', '🤭', '🤫', '🤥', '😶', '😐', '😑', '😬', '🙄', '😯', '😦', '😧', '😮', '😲', '🥱', '😴', '🤤', '😪', '😵', '🤐', '🥴', '🤢', '🤮', '🤧', '😷', '🤒', '🤕', '🤑', '🤠', '😈', '👿', '👹', '👺', '🤡', '👻', '💀', '☠️', '👽', '👾', '🤖', '🎃', '😺', '😸', '😹', '😻', '😼', '😽', '🙀', '😿', '😾'];
                        @endphp
                        @foreach($emojis as $emoji)
                            <button onclick="window.insertMediaEmoji('{{ $emoji }}')"
                                class="text-[24px] p-1 hover:bg-white/5 rounded transition-all active:scale-90">{{ $emoji }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Thumbnails and Send -->
    <div class="h-24 px-6 mb-4 flex items-center justify-between shrink-0 z-10">
        <div class="flex items-center gap-3">
            <div class="bg-[#111b21]/50 rounded-full px-4 py-2 flex items-center gap-2 border border-white/5">
                <svg viewBox="0 0 24 24" width="16" height="16" class="text-[#00a884]" fill="currentColor">
                    <path
                        d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm1 14.5h-2v-2h2v2zm0-4h-2v-6h2v6z">
                    </path>
                </svg>
                <span class="text-[#00a884] text-[13px] font-medium">Status (<span id="media_count_label">1</span>
                    included)</span>
            </div>
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
        document.getElementById('media_count_label').textContent = selectedMediaItems.length;
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
            thumb.className = `w-14 h-14 rounded-xl overflow-hidden border-2 cursor-pointer transition-all active:scale-95 shrink-0 ${index === activeMediaIndex ? 'border-[#00a884] scale-110 z-10' : 'border-transparent opacity-60 hover:opacity-100'}`;
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
                thumb.style.position = 'relative';
                thumb.appendChild(playIcon);
            }
            list.appendChild(thumb);
        });
    }

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
                formData.append('_token', '{{ csrf_token() }}');

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
                    viewers: {}
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
