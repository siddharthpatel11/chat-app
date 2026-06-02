<!-- About Edit Modal -->
<div id="about_modal"
    class="hidden fixed inset-0 z-[250] bg-black/80 flex items-center justify-center backdrop-blur-sm p-4">
    <div
        class="bg-[#111b21] w-full max-w-md max-h-[90vh] rounded-2xl overflow-hidden shadow-2xl flex flex-col border border-[#313d45]">
        <!-- Header -->
        <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
            <button onclick="closeAboutModal()" class="text-[#aebac1] hover:text-white transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path
                        d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z">
                    </path>
                </svg>
            </button>
            <h2 class="text-white text-[19px] font-semibold">About</h2>
        </div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto custom-scrollbar p-6 space-y-8">
            <!-- Input Section -->
            <div class="space-y-2 relative">
                <label class="text-[#00a884] text-xs font-medium ml-3">What's happening?</label>
                <div
                    class="relative flex items-center bg-transparent border-2 border-[#00a884] rounded-xl px-4 py-3 group">
                    <button class="text-[#00a884] hover:text-[#06cf9c] mr-3" onclick="toggleAboutEmojiPicker(event)">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                            <path
                                d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm2.5-9.5c.828 0 1.5-.672 1.5-1.5s-.672-1.5-1.5-1.5-1.5.672-1.5 1.5.672 1.5 1.5 1.5zm-5 0c.828 0 1.5-.672 1.5-1.5S8.828 8 8 8s-1.5.672-1.5 1.5.672 1.5 1.5 1.5zm2.5 6c2.511 0 4.67-1.516 5.568-3.693h-11.136c.898 2.177 3.057 3.693 5.568 3.693z">
                            </path>
                        </svg>
                    </button>
                    <input type="text" id="about_input" value="<?php echo e(auth()->user()->name); ?>"
                        class="bg-transparent border-none focus:ring-0 text-[#e9edef] text-[16px] w-full p-0"
                        maxlength="50" oninput="updateAboutCounter(this)">
                    <button class="text-[#8696a0] hover:text-[#e9edef] ml-2" onclick="clearAboutInput()">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                            <path
                                d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z">
                            </path>
                        </svg>
                    </button>
                </div>

                <!-- Emoji Picker for About (Repositioned to not overlap input) -->
                <div id="about_emoji_picker"
                    class="hidden absolute top-[calc(100%+5px)] left-0 w-full h-[250px] bg-[#233138] rounded-xl shadow-2xl border border-[#313d45] z-[300] overflow-hidden flex flex-col">
                    <div class="p-2 border-b border-[#313d45] flex gap-2 overflow-x-auto no-scrollbar">
                        <button class="text-xs text-[#8696a0] bg-[#3b4a54] px-2 py-1 rounded">😀</button>
                        <button class="text-xs text-[#8696a0] px-2 py-1 rounded">🐻</button>
                        <button class="text-xs text-[#8696a0] px-2 py-1 rounded">🍔</button>
                        <button class="text-xs text-[#8696a0] px-2 py-1 rounded">⚽</button>
                    </div>
                    <div class="flex-1 overflow-y-auto p-3 grid grid-cols-8 gap-2 custom-scrollbar"
                        id="about_emoji_grid">
                        <!-- Populated by JS -->
                    </div>
                </div>

                <div class="flex justify-end px-3">
                    <span id="about_counter" class="text-[#8696a0] text-xs">16/50</span>
                </div>
            </div>

            <!-- Privacy Section -->
            <div class="flex items-center justify-between py-2 cursor-pointer hover:bg-white/5 rounded-lg px-2 -mx-2 transition-colors"
                onclick="openAboutPrivacy()">
                <div class="flex items-center gap-4">
                    <div class="text-[#8696a0]">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                            <path
                                d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-[#e9edef] text-[15px]">Visible in chats to: <span id="about_privacy_text"
                            class="text-[#00a884]">Nobody</span></span>
                </div>
                <div class="text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                        <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"></path>
                    </svg>
                </div>
            </div>

            <!-- Duration Section -->
            <div class="space-y-4">
                <div class="relative group">
                    <label
                        class="absolute -top-2 left-3 bg-[#111b21] px-1 text-[#8696a0] text-xs font-medium z-10">Duration</label>
                    <div class="flex items-center gap-4">
                        <div class="text-[#8696a0]">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                                <path
                                    d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z">
                                </path>
                            </svg>
                        </div>
                        <div class="relative flex-1">
                            <button onclick="toggleDurationDropdown(event)"
                                class="w-full bg-transparent border border-[#313d45] rounded-xl px-4 py-3 flex items-center justify-between text-[#e9edef] text-[15px] focus:border-[#00a884] transition-all">
                                <span id="selected_duration">Until I change it</span>
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"
                                    class="text-[#8696a0]">
                                    <path d="M7 10l5 5 5-5H7z"></path>
                                </svg>
                            </button>
                            <!-- Duration Dropdown Menu (Opened downwards) -->
                            <div id="duration_dropdown"
                                class="hidden absolute top-full mt-2 left-0 w-full bg-[#233138] rounded-xl shadow-2xl border border-[#313d45] z-[270] py-2">
                                <?php
                                    $durations = ['Until I change it', '1 hour', '8 hours', '1 day', '2 days', '1 week', 'Custom'];
                                ?>
                                <?php $__currentLoopData = $durations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <button onclick="selectDuration(event, '<?php echo e($dur); ?>')"
                                        class="w-full text-left px-4 py-3 text-[#e9edef] hover:bg-[#182229] transition-colors flex justify-between items-center group/dur">
                                        <span class="pointer-events-none"><?php echo e($dur); ?></span>
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"
                                            class="text-[#00a884] duration-check pointer-events-none <?php echo e($dur == 'Until I change it' ? '' : 'hidden'); ?>"
                                            data-duration="<?php echo e($dur); ?>">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"></path>
                                        </svg>
                                    </button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Custom Date/Time -->
                <div id="custom_duration_fields" class="hidden gap-4 ml-9">
                    <div class="flex-1 relative group">
                        <label
                            class="absolute -top-2 left-3 bg-[#111b21] px-1 text-[#8696a0] text-xs font-medium z-10">Date</label>
                        <div
                            class="border border-[#313d45] rounded-xl px-4 py-2.5 flex items-center justify-between text-[#e9edef] text-[14px] bg-transparent">
                            <input type="date" id="about_custom_date"
                                class="bg-transparent border-none focus:ring-0 text-[#e9edef] w-full p-0 [color-scheme:dark]">
                        </div>
                    </div>
                    <div class="flex-1 relative group">
                        <label
                            class="absolute -top-2 left-3 bg-[#111b21] px-1 text-[#8696a0] text-xs font-medium z-10">Time</label>
                        <div
                            class="border border-[#313d45] rounded-xl px-4 py-2.5 flex items-center justify-between text-[#e9edef] text-[14px] bg-transparent">
                            <input type="time" id="about_custom_time"
                                class="bg-transparent border-none focus:ring-0 text-[#e9edef] w-full p-0 [color-scheme:dark]">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Presets -->
            <div class="pt-6 border-t border-[#313d45] space-y-1">
                <?php
                    $presets = [
                        ['icon' => '🟢', 'text' => 'Free to chat'],
                        ['icon' => '⏰', 'text' => 'Slow to respond'],
                        ['icon' => '🥳', 'text' => 'Hanging with friends'],
                        ['icon' => '✈️', 'text' => 'Travelling'],
                        ['icon' => '🔥', 'text' => 'Excited!'],
                    ];
                ?>
                <?php $__currentLoopData = $presets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center gap-4 py-3 px-4 hover:bg-[#202c33] rounded-xl cursor-pointer transition-colors"
                        onclick="setPresetStatus('<?php echo e($preset['text']); ?>')">
                        <span class="text-xl"><?php echo e($preset['icon']); ?></span>
                        <span class="text-[#e9edef] text-[15px]"><?php echo e($preset['text']); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Footer -->
        <div class="h-24 bg-[#1c272e] px-6 flex items-center justify-between border-t border-[#313d45] shrink-0">
            <button class="text-[#f15c5c] hover:bg-[#f15c5c]/10 p-3 rounded-full transition-colors"
                onclick="clearAboutInput()">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path>
                </svg>
            </button>
            <button
                class="w-14 h-14 bg-[#00a884] hover:bg-[#06cf9c] rounded-full flex items-center justify-center text-[#111b21] shadow-xl transform active:scale-95 transition-all"
                onclick="saveAbout()">
                <svg viewBox="0 0 24 24" width="30" height="30" fill="currentColor">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"></path>
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
    function openAboutModal() {
        const modal = document.getElementById('about_modal');
        const input = document.getElementById('about_input');
        input.value = document.getElementById('profile_about_text').innerText;
        updateAboutCounter(input);

        // Set current date/time as default for custom fields
        const now = new Date();
        const dateInput = document.getElementById('about_custom_date');
        const timeInput = document.getElementById('about_custom_time');
        
        if (dateInput) dateInput.value = now.toISOString().split('T')[0];
        if (timeInput) timeInput.value = now.toTimeString().split(' ')[0].substring(0, 5);

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Initial emoji population
        populateAboutEmojis();
    }

    function closeAboutModal() {
        document.getElementById('about_modal').classList.add('hidden');
        document.getElementById('about_modal').classList.remove('flex');
    }

    function updateAboutCounter(input) {
        document.getElementById('about_counter').innerText = `${input.value.length}/50`;
    }

    function clearAboutInput() {
        const input = document.getElementById('about_input');
        input.value = '';
        updateAboutCounter(input);
        input.focus();
    }

    function toggleAboutEmojiPicker(event) {
        event.stopPropagation();
        document.getElementById('about_emoji_picker').classList.toggle('hidden');
    }

    function toggleDurationDropdown(event) {
        event.stopPropagation();
        document.getElementById('duration_dropdown').classList.toggle('hidden');
    }

    // Make selectDuration global to ensure it's always accessible
    window.selectDuration = function (event, val) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }

        console.log('Selecting duration:', val);

        // Update button text
        const textElem = document.getElementById('selected_duration');
        if (textElem) textElem.innerText = val;

        // Hide dropdown
        const dropdown = document.getElementById('duration_dropdown');
        if (dropdown) dropdown.classList.add('hidden');

        // Update checkmarks
        const checks = document.querySelectorAll('.duration-check');
        checks.forEach(check => {
            if (check.getAttribute('data-duration') === val) {
                check.classList.remove('hidden');
            } else {
                check.classList.add('hidden');
            }
        });

        // Toggle custom fields
        const customFields = document.getElementById('custom_duration_fields');
        if (customFields) {
            if (val === 'Custom') {
                customFields.classList.remove('hidden');
                customFields.classList.add('flex');
            } else {
                customFields.classList.add('hidden');
                customFields.classList.remove('flex');
            }
        }

        return false;
    };

    function setPresetStatus(text) {
        const input = document.getElementById('about_input');
        input.value = text;
        updateAboutCounter(input);
    }

    function saveAbout() {
        const val = document.getElementById('about_input').value;
        const duration = document.getElementById('selected_duration').innerText;
        let subtitle = 'Until I change it';

        const now = new Date();
        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        
        const formatTime = (date) => {
            let hours = date.getHours();
            const minutes = date.getMinutes().toString().padStart(2, '0');
            const seconds = date.getSeconds().toString().padStart(2, '0');
            const ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12;
            hours = hours ? hours : 12;
            return `${hours}:${minutes}:${seconds} ${ampm}`;
        };

        const formatDate = (date) => {
            const dayName = days[date.getDay()];
            return `${dayName} at ${formatTime(date)}`;
        };

        if (duration === 'Until I change it') {
            subtitle = `UPDATED|${now.toISOString()}`;
        } else if (duration !== 'Custom') {
            let expiry = new Date();
            if (duration === '1 hour') expiry.setHours(now.getHours() + 1);
            else if (duration === '8 hours') expiry.setHours(now.getHours() + 8);
            else if (duration === '1 day') expiry.setDate(now.getDate() + 1);
            else if (duration === '2 days') expiry.setDate(now.getDate() + 2);
            else if (duration === '1 week') expiry.setDate(now.getDate() + 7);

            subtitle = `UNTIL|${expiry.toISOString()}`;
        } else {
            const customDate = document.getElementById('about_custom_date').value;
            const customTime = document.getElementById('about_custom_time').value;
            if (customDate && customTime) {
                const expiry = new Date(`${customDate}T${customTime}`);
                subtitle = `UNTIL|${expiry.toISOString()}`;
            }
        }

        // Update main text
        document.getElementById('profile_about_text').innerText = val;
        // Update subtitle text
        const subtitleElem = document.getElementById('profile_about_subtitle');
        if (subtitleElem) subtitleElem.innerText = window.formatAboutSubtitle(subtitle);

        // Save to Firebase
        if (window.db && window.myUserId) {
            window.update(window.ref(window.db, `status/${window.myUserId}`), {
                about: val,
                about_subtitle: subtitle
            }).then(() => {
                console.log('About status saved to Firebase');
            }).catch(err => {
                console.error('Error saving about to Firebase:', err);
            });
        }

        // Save to Database API
        fetch('/api/update-profile', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                user_id: window.myUserId,
                about: val,
                about_subtitle: subtitle
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status) {
                console.log('About status saved to Database');
            }
        })
        .catch(err => {
            console.error('Error saving about to Database:', err);
        });

        closeAboutModal();
    }

    function populateAboutEmojis() {
        const emojis = ['😀', '😃', '😄', '😁', '😆', '😅', '😂', '🤣', '😊', '😇', '🙂', '🙃', '😉', '😌', '😍', '🥰', '😘', '😗', '😙', '😚', '😋', '😛', '😝', '😜', '🤪', '🤨', '🧐', '🤓', '😎', '🤩', '🥳', '😏', '😒', '😞', '😔', '😟', '😕', '🙁', '☹️', '😣', '😖', '😫', '😩', '🥺', '😢', '😭', '😤', '😠', '😡', '🤬', '🤯', '😳', '🥵', '🥶', '😱', '😨', '😰', '😥', '😓', '🤗', '🤔', '🤭', '🤫', '🤥', '😶', '😐', '😑', '😬', '🙄', '😯', '😦', '😧', '😮', '😲', '🥱', '😴', '🤤', '😪', '😵', '🤐', '🥴', '🤢', '🤮', '🤧', '😷', '🤒', '🤕', '🤑', '🤠', '😈', '👿', '👹', '👺', '🤡', '👻', '💀', '☠️', '👽', '👾', '🤖', '🎃', '😺', '😸', '😹', '😻', '😼', '😽', '🙀', '😿', '😾'];
        const grid = document.getElementById('about_emoji_grid');
        grid.innerHTML = '';
        emojis.forEach(emoji => {
            const btn = document.createElement('button');
            btn.className = 'text-xl hover:bg-white/10 p-1 rounded transition-colors';
            btn.innerText = emoji;
            btn.onclick = () => {
                const input = document.getElementById('about_input');
                input.value += emoji;
                updateAboutCounter(input);
            };
            grid.appendChild(btn);
        });
    }

    // Close dropdowns on outside click
    window.addEventListener('click', function (e) {
        const emojiPicker = document.getElementById('about_emoji_picker');
        if (emojiPicker && !emojiPicker.contains(e.target)) {
            emojiPicker.classList.add('hidden');
        }
        const durationDropdown = document.getElementById('duration_dropdown');
        if (durationDropdown && !durationDropdown.contains(e.target)) {
            durationDropdown.classList.add('hidden');
        }
    });
</script>
<?php /**PATH D:\xampp\htdocs\laravel\chat_app\resources\views/chat/about/about_modal.blade.php ENDPATH**/ ?>