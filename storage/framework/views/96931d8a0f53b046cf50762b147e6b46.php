<div id="edit_profile_panel"
    class="hidden flex-col w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="toggleEditProfile()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Edit profile</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21]">
        <!-- Profile Photo Section -->
        <div class="flex flex-col items-center py-10 px-6">
            <div class="relative group">
                <div class="w-[200px] h-[200px] rounded-full overflow-hidden shadow-2xl border-4 border-[#313d45] cursor-pointer"
                    onclick="viewPhoto()">
                    <img src="<?php echo e(auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=2a3942&color=fff&size=256'); ?>"
                        class="w-full h-full object-cover profile-image-main my-avatar">
                </div>
                <!-- Edit Button with Dropdown -->
                <div class="absolute bottom-2 right-2 z-[20]">
                    <button onclick="toggleProfileDropdown(event)"
                        class="bg-[#202c33] p-2.5 rounded-full border border-[#313d45] shadow-lg cursor-pointer hover:bg-[#384b57] transition-all text-[#00a884] flex items-center gap-2 px-4 border-2 border-[#111b21] focus:outline-none">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor" class="text-[#00a884]">
                            <path
                                d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z">
                            </path>
                        </svg>
                        <span class="text-sm font-semibold text-[#00a884]">Edit</span>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="profile_edit_dropdown"
                        class="hidden absolute top-full mt-2 left-0 w-[200px] bg-[#233138] rounded-xl shadow-2xl z-[30] py-2 border border-[#313d45] transform origin-top-left transition-all">
                        <button onclick="viewPhoto()"
                            class="w-full flex items-center gap-4 px-4 py-3 hover:bg-[#182229] text-[#e9edef] transition-colors">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
                                stroke-width="2" class="text-[#8696a0]">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                            <span class="text-[15px]">View photo</span>
                        </button>
                        <button onclick="openCamera()"
                            class="w-full flex items-center gap-4 px-4 py-3 hover:bg-[#182229] text-[#e9edef] transition-colors">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
                                stroke-width="2" class="text-[#8696a0]">
                                <path
                                    d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z">
                                </path>
                                <circle cx="12" cy="13" r="4"></circle>
                            </svg>
                            <span class="text-[15px]">Take photo</span>
                        </button>
                        <button onclick="triggerFileUpload()"
                            class="w-full flex items-center gap-4 px-4 py-3 hover:bg-[#182229] text-[#e9edef] transition-colors">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
                                stroke-width="2" class="text-[#8696a0]">
                                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z">
                                </path>
                            </svg>
                            <span class="text-[15px]">Upload photo</span>
                        </button>
                        <div class="h-px bg-[#313d45] my-1 mx-2"></div>
                        <button onclick="removePhoto()"
                            class="w-full flex items-center gap-4 px-4 py-3 hover:bg-[#182229] text-[#f15c5c] transition-colors">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path
                                    d="M3 6h18m-2 0v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6m3 0V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2">
                                </path>
                            </svg>
                            <span class="text-[15px]">Remove photo</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Section -->
        <div class="flex flex-col px-8 pb-10">
            <!-- Hidden File Input -->
            <input type="file" id="profile_file_input" accept="image/*" class="hidden"
                onchange="handleFileUpload(event)">

            <!-- About -->
            <div class="mb-10 group" onclick="openAboutModal()">
                <label class="text-[#8696a0] text-sm font-medium mb-3 block">About</label>
                <div
                    class="flex items-center justify-between group-hover:bg-[#202c33]/30 p-2 -mx-2 rounded-lg transition-all cursor-pointer">
                    <div class="flex flex-col">
                        <span class="text-[#e9edef] text-[17px] font-normal"
                            id="profile_about_text"><?php echo e(auth()->user()->about ?? auth()->user()->name); ?></span>
                        <span class="text-[#8696a0] text-[14px] mt-1 italic"
                            id="profile_about_subtitle"><?php echo e(auth()->user()->about_subtitle ?? 'Until I change it'); ?></span>
                    </div>
                    <button class="text-[#8696a0] hover:text-[#e9edef] transition-colors">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                            <path
                                d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Name -->
            <div class="mb-10 group">
                <label class="text-[#8696a0] text-sm font-medium mb-3 block">Name</label>

                <div id="name_display_mode"
                    class="flex items-center justify-between group-hover:bg-[#202c33]/30 p-2 -mx-2 rounded-lg transition-all cursor-pointer"
                    onclick="toggleNameEdit()">
                    <span class="text-[#e9edef] text-[17px] font-normal"
                        id="profile_name_text"><?php echo e(auth()->user()->name); ?></span>
                    <button class="text-[#8696a0] hover:text-[#e9edef] transition-colors">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                            <path
                                d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z">
                            </path>
                        </svg>
                    </button>
                </div>

                <div id="name_edit_mode" class="hidden flex flex-col pt-2">
                    <div class="relative border-b-2 border-[#00a884] pb-2 flex items-center gap-3">
                        <input type="text" id="name_edit_input" value="<?php echo e(auth()->user()->name); ?>" maxlength="25"
                            class="bg-transparent border-none focus:ring-0 text-[#e9edef] text-[17px] w-full p-0"
                            oninput="updateNameCounter(this)">

                        <div class="flex items-center gap-4">
                            <span id="name_char_counter" class="text-[#8696a0] text-sm">25</span>
                            <button class="text-[#8696a0] hover:text-[#e9edef] transition-colors"
                                onclick="toggleNameEmojiPicker(event)">
                                <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                                    <path
                                        d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm2.5-9.5c.828 0 1.5-.672 1.5-1.5s-.672-1.5-1.5-1.5-1.5.672-1.5 1.5.672 1.5 1.5 1.5zm-5 0c.828 0 1.5-.672 1.5-1.5S8.828 8 8 8s-1.5.672-1.5 1.5.672 1.5 1.5 1.5zm2.5 6c2.511 0 4.67-1.516 5.568-3.693h-11.136c.898 2.177 3.057 3.693 5.568 3.693z">
                                    </path>
                                </svg>
                            </button>
                            <button class="text-[#8696a0] hover:text-[#00a884] transition-colors" onclick="saveName()">
                                <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Name Emoji Picker -->
                        <div id="name_emoji_picker"
                            class="hidden absolute top-full mt-2 right-0 w-[280px] h-[220px] bg-[#233138] rounded-xl shadow-2xl border border-[#313d45] z-[100] overflow-hidden flex flex-col">
                            <div class="flex-1 overflow-y-auto p-3 grid grid-cols-7 gap-2 custom-scrollbar"
                                id="name_emoji_grid">
                                <!-- Populated by JS -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Phone -->
            <div class="mb-10 group">
                <label class="text-[#8696a0] text-sm font-medium mb-3 block">Phone</label>
                <div class="flex items-center justify-between p-2 -mx-2">
                    <div class="flex items-center gap-4">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0]">
                            <path
                                d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z">
                            </path>
                        </svg>
                        <span id="profile_phone_text" class="text-[#e9edef] text-[17px] font-normal">+91 93136
                            11375</span>
                    </div>
                    <button onclick="copyPhoneNumber()"
                        class="text-[#8696a0] hover:text-[#00a884] transition-all relative group" id="phone_copy_btn"
                        title="Copy to clipboard">
                        <svg id="copy_icon" viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                        </svg>
                        <svg id="check_icon" class="hidden text-[#00a884]" viewBox="0 0 24 24" width="22" height="22"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span
                            class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-[#233138] text-white text-[10px] rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap border border-[#313d45]">Copy</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Take Photo Modal -->
<div id="camera_modal"
    class="hidden fixed inset-0 z-[200] bg-black/90 flex items-center justify-center backdrop-blur-sm">
    <div class="bg-[#111b21] w-full max-w-xl rounded-2xl overflow-hidden shadow-2xl flex flex-col">
        <div class="h-16 bg-[#202c33] px-6 flex items-center justify-between border-b border-[#313d45]">
            <div class="flex items-center gap-6">
                <button onclick="closeCamera()" class="text-[#aebac1] hover:text-white transition-colors">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path
                            d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z">
                        </path>
                    </svg>
                </button>
                <h2 class="text-white text-[19px] font-semibold">Take photo</h2>
            </div>
        </div>
        <div class="relative bg-black aspect-square flex items-center justify-center overflow-hidden">
            <video id="camera_video" autoplay playsinline class="w-full h-full object-cover"></video>
            <canvas id="camera_canvas" class="hidden"></canvas>

            <button onclick="capturePhoto()"
                class="absolute bottom-6 left-1/2 -translate-x-1/2 w-16 h-16 bg-[#00a884] hover:bg-[#06cf9c] rounded-full flex items-center justify-center shadow-2xl transform active:scale-90 transition-all">
                <svg viewBox="0 0 24 24" width="30" height="30" fill="currentColor" class="text-[#111b21]">
                    <path
                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
                        class="hidden"></path>
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                    <circle cx="12" cy="13" r="4"></circle>
                </svg>
            </button>
        </div>
        <div class="h-24 bg-[#111b21]"></div>
    </div>
</div>

<!-- View Photo Modal -->
<div id="view_photo_modal"
    class="hidden fixed inset-0 z-[200] bg-black/95 flex flex-col items-center justify-center backdrop-blur-md">
    <div
        class="absolute top-0 left-0 w-full h-16 bg-gradient-to-b from-black/50 to-transparent flex items-center justify-between px-6 z-10">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-full overflow-hidden border border-white/20">
                <img src="<?php echo e(auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=2a3942&color=fff'); ?>"
                    class="w-full h-full object-cover profile-image-preview">
            </div>
            <span class="text-white font-medium"><?php echo e(auth()->user()->name); ?></span>
        </div>
        <button onclick="closeViewPhoto()" class="text-white hover:bg-white/10 p-2 rounded-full transition-colors">
            <svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor">
                <path
                    d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z">
                </path>
            </svg>
        </button>
    </div>
    <div class="w-full max-w-3xl aspect-square p-4 flex items-center justify-center">
        <img id="full_photo_preview" src=""
            class="max-w-full max-h-full object-contain rounded-lg shadow-2xl profile-image-preview">
    </div>
</div>

<script>
    let cameraStream = null;
    const defaultAvatar = "https://ui-avatars.com/api/?name=<?php echo e(urlencode(auth()->user()->name)); ?>&background=2a3942&color=fff&size=256";

    function toggleProfileDropdown(event) {
        event.stopPropagation();
        const dropdown = document.getElementById('profile_edit_dropdown');
        dropdown.classList.toggle('hidden');
    }

    // Dynamic Photo Functions
    function viewPhoto() {
        const currentSrc = document.querySelector('.profile-image-main').src;
        document.getElementById('full_photo_preview').src = currentSrc;
        document.getElementById('view_photo_modal').classList.remove('hidden');
        document.getElementById('view_photo_modal').classList.add('flex');
    }

    function closeViewPhoto() {
        document.getElementById('view_photo_modal').classList.add('hidden');
        document.getElementById('view_photo_modal').classList.remove('flex');
    }

    async function openCamera() {
        try {
            const modal = document.getElementById('camera_modal');
            const video = document.getElementById('camera_video');
            cameraStream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = cameraStream;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        } catch (err) {
            alert('Camera access denied or not available');
            console.error(err);
        }
    }

    function closeCamera() {
        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop());
        }
        document.getElementById('camera_modal').classList.add('hidden');
        document.getElementById('camera_modal').classList.remove('flex');
    }

    function capturePhoto() {
        const video = document.getElementById('camera_video');
        const canvas = document.getElementById('camera_canvas');
        const context = canvas.getContext('2d');

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        const dataUrl = canvas.toDataURL('image/jpeg');
        updateProfileImage(dataUrl);
        closeCamera();
    }

    function triggerFileUpload() {
        document.getElementById('profile_file_input').click();
    }

    function handleFileUpload(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                updateProfileImage(e.target.result);
                uploadProfilePhoto(file);
            };
            reader.readAsDataURL(file);
        }
    }

    function removePhoto() {
        if (confirm('Remove profile photo?')) {
            updateProfileImage(defaultAvatar);
            uploadProfilePhoto(null); // Send null to remove
        }
    }

    function uploadProfilePhoto(file) {
        const formData = new FormData();
        formData.append('user_id', window.myUserId);
        if (file) {
            formData.append('avatar', file);
        } else {
            formData.append('avatar_remove', 'true');
        }

        fetch('/api/update-profile', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status) {
                window.showToast('Success', 'Profile photo updated');
                // Use the server URL to ensure consistency
                if (data.data.avatar) {
                    updateProfileImage(data.data.avatar);
                }
            }
        })
        .catch(err => {
            console.error('Error uploading photo:', err);
            window.showToast('Error', 'Failed to upload photo');
        });
    }

    function updateProfileImage(src) {
        // Update all profile image instances globally
        document.querySelectorAll('.my-avatar, .profile-image-preview').forEach(img => {
            img.src = src;
        });

        // Hide dropdown
        document.getElementById('profile_edit_dropdown').classList.add('hidden');
    }

    // Close dropdown when clicking outside
    window.addEventListener('click', function (e) {
        const dropdown = document.getElementById('profile_edit_dropdown');
        if (dropdown && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });

    function toggleEditProfile() {
        const editPanel = document.getElementById('edit_profile_panel');
        const settingsPanel = document.getElementById('settings_panel');

        if (editPanel.classList.contains('hidden')) {
            editPanel.classList.remove('hidden');
            editPanel.classList.add('flex');
            if (settingsPanel) settingsPanel.classList.add('hidden');
        } else {
            editPanel.classList.add('hidden');
            editPanel.classList.remove('flex');
            if (settingsPanel) settingsPanel.classList.remove('hidden');
        }
    }
    // Name Edit Logic
    function toggleNameEdit() {
        document.getElementById('name_display_mode').classList.add('hidden');
        document.getElementById('name_edit_mode').classList.remove('hidden');
        const input = document.getElementById('name_edit_input');
        input.focus();
        input.setSelectionRange(input.value.length, input.value.length);
        updateNameCounter(input);
        populateNameEmojis();
    }

    function updateNameCounter(input) {
        document.getElementById('name_char_counter').innerText = 25 - input.value.length;
    }

    function toggleNameEmojiPicker(event) {
        event.stopPropagation();
        document.getElementById('name_emoji_picker').classList.toggle('hidden');
    }

    function saveName() {
        const newName = document.getElementById('name_edit_input').value;
        if (newName.trim() === '') return;

        // Update API
        fetch('/api/update-profile', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                user_id: window.myUserId,
                name: newName
            })
        })
            .then(res => res.json())
            .then(data => {
                if (data.status) {
                    // Update all name displays
                    document.querySelectorAll('#profile_name_text').forEach(el => el.innerText = newName);

                    // Also update settings panel name if it exists
                    const settingsName = document.querySelector('.settings-profile-name');
                    if (settingsName) settingsName.innerText = newName;

                    document.getElementById('name_display_mode').classList.remove('hidden');
                    document.getElementById('name_edit_mode').classList.add('hidden');

                    window.showToast('Success', 'Name updated successfully');
                }
            })
            .catch(err => {
                console.error('Error updating name:', err);
                window.showToast('Error', 'Failed to update name');
            });
    }

    function populateNameEmojis() {
        const emojis = ['😀', '😃', '😄', '😁', '😆', '😅', '😂', '🤣', '😊', '😇', '🙂', '🙃', '😉', '😌', '😍', '🥰', '😘', '😗', '😙', '😚', '😋', '😛', '😝', '😜', '🤪', '🤨', '🧐', '🤓', '😎', '🤩', '🥳', '😏', '😒', '😞', '😔', '😟', '😕', '🙁', '☹️', '😣', '😖', '😫', '😩', '🥺', '😢', '😭', '😤', '😠', '😡', '🤬', '🤯', '🤔', '🤗', '🤭', '🤫'];
        const grid = document.getElementById('name_emoji_grid');
        if (!grid || grid.children.length > 0) return;

        emojis.forEach(emoji => {
            const btn = document.createElement('button');
            btn.className = 'text-xl hover:bg-white/10 p-1 rounded transition-colors';
            btn.innerText = emoji;
            btn.onclick = (e) => {
                e.stopPropagation();
                const input = document.getElementById('name_edit_input');
                input.value += emoji;
                updateNameCounter(input);
            };
            grid.appendChild(btn);
        });
    }

    // Close name emoji picker on outside click
    window.addEventListener('click', function (e) {
        const picker = document.getElementById('name_emoji_picker');
        if (picker && !picker.contains(e.target) && !e.target.closest('button')) {
            picker.classList.add('hidden');
        }
    });
    // Phone Copy Logic
    function copyPhoneNumber() {
        const phoneText = document.getElementById('profile_phone_text').innerText;
        navigator.clipboard.writeText(phoneText).then(() => {
            const copyIcon = document.getElementById('copy_icon');
            const checkIcon = document.getElementById('check_icon');

            // Visual feedback
            copyIcon.classList.add('hidden');
            checkIcon.classList.remove('hidden');

            setTimeout(() => {
                copyIcon.classList.remove('hidden');
                checkIcon.classList.add('hidden');
            }, 2000);
        });
    }
    // Format about subtitle on load
    document.addEventListener('DOMContentLoaded', () => {
        const subtitleElem = document.getElementById('profile_about_subtitle');
        if (subtitleElem && window.formatAboutSubtitle) {
            subtitleElem.innerText = window.formatAboutSubtitle(subtitleElem.innerText);
        }
    });
</script>
<?php /**PATH D:\xampp\htdocs\laravel\chat_app\resources\views/chat/settings/edit_profile.blade.php ENDPATH**/ ?>