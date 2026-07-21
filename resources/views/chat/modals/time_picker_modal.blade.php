<!-- Material Time Picker Modal -->
<div id="time_picker_modal" class="hidden fixed inset-0 z-[6000] flex items-center justify-center bg-black/60 backdrop-blur-sm transition-all duration-300">
    <div class="bg-[#3c4043] w-[320px] rounded-lg shadow-2xl flex flex-col overflow-hidden transform scale-95 transition-all duration-300 opacity-0 relative select-none" id="time_picker_modal_content">
        
        <!-- Header -->
        <div class="bg-[#5f6368] px-6 py-5 flex items-center justify-between">
            <div class="flex items-baseline gap-1 text-white font-light">
                <span id="tp_display_hour" class="text-[56px] leading-none cursor-pointer text-[#8ab4f8] hover:opacity-80 transition-colors" onclick="window.tpSetMode('hour')">11</span>
                <span class="text-[56px] leading-none opacity-50">:</span>
                <span id="tp_display_minute" class="text-[56px] leading-none cursor-pointer opacity-50 hover:opacity-80 transition-colors" onclick="window.tpSetMode('minute')">00</span>
            </div>
            <div class="flex flex-col text-white font-medium text-[16px] gap-1 ml-4">
                <span id="tp_display_am" class="cursor-pointer text-[#8ab4f8] hover:opacity-80 transition-colors" onclick="window.tpSetAmPm('AM')">AM</span>
                <span id="tp_display_pm" class="cursor-pointer opacity-50 hover:opacity-80 transition-colors" onclick="window.tpSetAmPm('PM')">PM</span>
            </div>
        </div>

        <!-- Clock Body -->
        <div class="p-6 flex flex-col items-center">
            
            <!-- Clock Face -->
            <div class="relative w-[240px] h-[240px] bg-[#202124]/40 rounded-full my-2" id="tp_clock_face" onmousedown="window.tpHandleDragStart(event)" onmousemove="window.tpHandleDragMove(event)" onmouseup="window.tpHandleDragEnd(event)" onmouseleave="window.tpHandleDragEnd(event)" ontouchstart="window.tpHandleDragStart(event)" ontouchmove="window.tpHandleDragMove(event)" ontouchend="window.tpHandleDragEnd(event)">
                
                <!-- Center Dot -->
                <div class="absolute w-2 h-2 rounded-full bg-[#8ab4f8] top-1/2 left-1/2 -mt-1 -ml-1"></div>
                
                <!-- Hand -->
                <div id="tp_clock_hand" class="absolute bg-[#8ab4f8] origin-bottom w-0.5 rounded-full z-10 transition-transform duration-200" style="height: 100px; left: 50%; bottom: 50%; transform: translateX(-50%) rotate(0deg);">
                    <!-- Hand Circle at the end -->
                    <div id="tp_hand_circle" class="absolute w-10 h-10 rounded-full bg-[#8ab4f8] -top-5 left-1/2 -ml-5 opacity-90 flex items-center justify-center text-[#202124] font-medium text-[16px] pointer-events-none"></div>
                </div>

                <!-- Numbers Container -->
                <div id="tp_numbers_container" class="absolute inset-0 z-0"></div>

            </div>

        </div>
        
        <!-- Footer Buttons -->
        <div class="flex items-center justify-between px-4 pb-4 pt-2">
            <button class="p-2 text-white/70 hover:text-white transition-colors focus:outline-none">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M20 5H4c-1.1 0-1.99.9-1.99 2L2 17c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm-9 3h2v2h-2V8zm0 3h2v2h-2v-2zM8 8h2v2H8V8zm0 3h2v2H8v-2zm-1 2H5v-2h2v2zm0-3H5V8h2v2zm9 7H8v-2h8v2zm0-4h-2v-2h2v2zm0-3h-2V8h2v2zm3 3h-2v-2h2v2zm0-3h-2V8h2v2z"></path>
                </svg>
            </button>
            <div class="flex gap-2">
                <button onclick="window.closeTimePickerModal()" class="px-4 py-2 text-[#8ab4f8] font-medium hover:bg-white/5 rounded transition-colors focus:outline-none tracking-wide">CANCEL</button>
                <button onclick="window.tpConfirmTime()" class="px-4 py-2 text-[#8ab4f8] font-medium hover:bg-white/5 rounded transition-colors focus:outline-none tracking-wide">OK</button>
            </div>
        </div>

    </div>
</div>

<script>
    window.tpState = {
        mode: 'hour', // 'hour' or 'minute'
        hour: 11,
        minute: 0,
        ampm: 'AM',
        isDragging: false,
        callback: null // function to call on OK
    };

    const RADIUS = 100; // Radius of numbers
    const CENTER = 120; // 240/2

    function tpGenerateNumbers() {
        const container = document.getElementById('tp_numbers_container');
        container.innerHTML = '';
        
        const isHour = window.tpState.mode === 'hour';
        const steps = 12;
        
        for (let i = 1; i <= steps; i++) {
            let val = isHour ? i : (i === 12 ? 0 : i * 5);
            let displayVal = isHour ? val : String(val).padStart(2, '0');
            
            // Calculate angle (12 is at top -> 0 degrees, 3 is at right -> 90 degrees)
            const angle = (i * 30) * (Math.PI / 180);
            
            const x = Math.round(CENTER + RADIUS * Math.sin(angle));
            const y = Math.round(CENTER - RADIUS * Math.cos(angle));
            
            const numEl = document.createElement('div');
            numEl.className = 'absolute w-10 h-10 -ml-5 -mt-5 rounded-full flex items-center justify-center text-white text-[15px] pointer-events-none transition-opacity duration-200';
            numEl.style.left = `${x}px`;
            numEl.style.top = `${y}px`;
            
            // If the value matches the current state, hide it since the hand circle shows it
            const currentVal = isHour ? (window.tpState.hour % 12 || 12) : (Math.round(window.tpState.minute / 5) * 5) % 60;
            if (val === currentVal && !window.tpState.isDragging) {
                numEl.style.opacity = '0';
            }
            
            numEl.innerText = displayVal;
            numEl.id = `tp_num_${val}`;
            
            container.appendChild(numEl);
        }
    }

    function tpUpdateHandUI(val, animate = true) {
        const isHour = window.tpState.mode === 'hour';
        let displayVal = isHour ? (val % 12 || 12) : String(val).padStart(2, '0');
        
        const hand = document.getElementById('tp_clock_hand');
        if (animate) {
            hand.classList.add('duration-200');
        } else {
            hand.classList.remove('duration-200');
        }

        let angle;
        if (isHour) {
            angle = (val % 12) * 30;
        } else {
            angle = val * 6; // 360 / 60
        }
        
        hand.style.transform = `translateX(-50%) rotate(${angle}deg)`;
        
        const circle = document.getElementById('tp_hand_circle');
        circle.innerText = displayVal;

        // Ensure rotation is applied then update numbers visibility
        setTimeout(() => {
            const container = document.getElementById('tp_numbers_container');
            if (container) {
                Array.from(container.children).forEach(child => {
                    child.style.opacity = '1';
                });
                
                let nearestVal = isHour ? (val % 12 || 12) : (Math.round(val / 5) * 5) % 60;
                const activeId = `tp_num_${nearestVal}`;
                const activeNum = document.getElementById(activeId);
                // hide the number under the hand circle to avoid double rendering
                if (activeNum && !window.tpState.isDragging) {
                    activeNum.style.opacity = '0';
                }
            }
        }, 50);
    }

    function tpUpdateDisplayUI() {
        const hDisplay = document.getElementById('tp_display_hour');
        const mDisplay = document.getElementById('tp_display_minute');
        
        let displayHour = window.tpState.hour % 12;
        if (displayHour === 0) displayHour = 12;

        hDisplay.innerText = displayHour;
        mDisplay.innerText = String(window.tpState.minute).padStart(2, '0');

        // Green color used in screenshot
        const accentColor = 'text-[#7ad894]';
        
        // Update colors
        if (window.tpState.mode === 'hour') {
            hDisplay.className = `text-[56px] leading-none cursor-pointer ${accentColor} opacity-100 transition-colors`;
            mDisplay.className = `text-[56px] leading-none cursor-pointer text-white opacity-50 hover:opacity-80 transition-colors`;
        } else {
            mDisplay.className = `text-[56px] leading-none cursor-pointer ${accentColor} opacity-100 transition-colors`;
            hDisplay.className = `text-[56px] leading-none cursor-pointer text-white opacity-50 hover:opacity-80 transition-colors`;
        }

        const amDisplay = document.getElementById('tp_display_am');
        const pmDisplay = document.getElementById('tp_display_pm');

        if (window.tpState.ampm === 'AM') {
            amDisplay.className = `cursor-pointer ${accentColor} opacity-100 transition-colors`;
            pmDisplay.className = `cursor-pointer text-white opacity-50 hover:opacity-80 transition-colors`;
        } else {
            pmDisplay.className = `cursor-pointer ${accentColor} opacity-100 transition-colors`;
            amDisplay.className = `cursor-pointer text-white opacity-50 hover:opacity-80 transition-colors`;
        }
        
        // Update hand circle and line color to match screenshot
        const hand = document.getElementById('tp_clock_hand');
        const circle = document.getElementById('tp_hand_circle');
        const dot = document.querySelector('#tp_clock_face > div:first-child');
        
        hand.style.backgroundColor = '#7ad894';
        circle.style.backgroundColor = '#7ad894';
        dot.style.backgroundColor = '#7ad894';
    }

    window.tpSetMode = function(mode) {
        window.tpState.mode = mode;
        tpUpdateDisplayUI();
        tpGenerateNumbers();
        tpUpdateHandUI(mode === 'hour' ? window.tpState.hour : window.tpState.minute, true);
    };

    window.tpSetAmPm = function(ampm) {
        window.tpState.ampm = ampm;
        if (ampm === 'PM' && window.tpState.hour < 12) {
            window.tpState.hour += 12;
        } else if (ampm === 'AM' && window.tpState.hour >= 12) {
            window.tpState.hour -= 12;
        }
        tpUpdateDisplayUI();
    };

    function tpCalculateValueFromEvent(e) {
        const face = document.getElementById('tp_clock_face');
        const rect = face.getBoundingClientRect();
        
        let clientX = e.clientX;
        let clientY = e.clientY;
        
        if (e.touches && e.touches.length > 0) {
            clientX = e.touches[0].clientX;
            clientY = e.touches[0].clientY;
        }

        const x = clientX - rect.left - CENTER;
        const y = clientY - rect.top - CENTER;
        
        // Calculate angle in degrees, 0 at top, increasing clockwise
        let angle = Math.atan2(y, x) * (180 / Math.PI);
        angle += 90; // Shift so 0 is at top
        if (angle < 0) angle += 360;

        if (window.tpState.mode === 'hour') {
            // Hours are in 30 degree steps
            let hour = Math.round(angle / 30);
            if (hour === 0) hour = 12;
            if (window.tpState.ampm === 'PM' && hour < 12) hour += 12;
            if (window.tpState.ampm === 'AM' && hour === 12) hour = 0;
            return hour;
        } else {
            // Minutes are in 6 degree steps
            let minute = Math.round(angle / 6);
            if (minute === 60) minute = 0;
            
            // Snap to 1 minute precision during drag
            return minute;
        }
    }

    window.tpHandleDragStart = function(e) {
        if (e.cancelable) e.preventDefault();
        window.tpState.isDragging = true;
        const val = tpCalculateValueFromEvent(e);
        
        if (window.tpState.mode === 'hour') {
            window.tpState.hour = val;
        } else {
            window.tpState.minute = val;
        }
        
        tpUpdateDisplayUI();
        tpUpdateHandUI(val, false);
        
        // show all numbers while dragging
        const container = document.getElementById('tp_numbers_container');
        if (container) {
            Array.from(container.children).forEach(child => {
                child.style.opacity = '1';
            });
        }
    };

    window.tpHandleDragMove = function(e) {
        if (!window.tpState.isDragging) return;
        if (e.cancelable) e.preventDefault();
        
        const val = tpCalculateValueFromEvent(e);
        
        if (window.tpState.mode === 'hour') {
            if (window.tpState.hour !== val) {
                window.tpState.hour = val;
                tpUpdateDisplayUI();
                tpUpdateHandUI(val, false);
            }
        } else {
            if (window.tpState.minute !== val) {
                window.tpState.minute = val;
                tpUpdateDisplayUI();
                tpUpdateHandUI(val, false);
            }
        }
    };

    window.tpHandleDragEnd = function(e) {
        if (!window.tpState.isDragging) return;
        window.tpState.isDragging = false;
        
        const val = window.tpState.mode === 'hour' ? window.tpState.hour : window.tpState.minute;
        tpUpdateHandUI(val, true);

        // Auto switch to minute mode if hour was just selected
        if (window.tpState.mode === 'hour') {
            setTimeout(() => {
                window.tpSetMode('minute');
            }, 300);
        }
    };

    window.openTimePickerModal = function(initialTimeStr, callback) {
        window.tpState.callback = callback;
        
        // parse initial time "15:30"
        let h = 11;
        let m = 0;
        
        if (initialTimeStr && initialTimeStr.includes(':')) {
            const parts = initialTimeStr.split(':');
            h = parseInt(parts[0], 10);
            m = parseInt(parts[1], 10);
        } else {
            const now = new Date();
            h = now.getHours();
            m = now.getMinutes();
        }

        window.tpState.hour = h;
        window.tpState.minute = m;
        window.tpState.ampm = h >= 12 ? 'PM' : 'AM';
        
        window.tpSetMode('hour');

        const modal = document.getElementById('time_picker_modal');
        const content = document.getElementById('time_picker_modal_content');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        setTimeout(() => {
            modal.classList.add('opacity-100');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    };

    window.closeTimePickerModal = function() {
        const modal = document.getElementById('time_picker_modal');
        const content = document.getElementById('time_picker_modal_content');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        modal.classList.remove('opacity-100');
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 300);
    };

    window.tpConfirmTime = function() {
        if (typeof window.tpState.callback === 'function') {
            let h = window.tpState.hour;
            const m = window.tpState.minute;
            
            let displayH = h % 12 || 12;
            let ampm = h >= 12 ? 'PM' : 'AM';
            const displayStr = `${displayH}:${String(m).padStart(2, '0')} ${ampm}`;
            const valStr = `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}`;
            
            window.tpState.callback(displayStr, valStr);
        }
        window.closeTimePickerModal();
    };

</script>
