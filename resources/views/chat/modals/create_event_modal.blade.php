<!-- Create Event Modal -->
<div id="create_event_modal" class="hidden fixed inset-0 z-[5000] flex items-center justify-center bg-black/60 backdrop-blur-sm transition-all duration-300">
    <div class="bg-[#111b21] w-[100%] max-w-[450px] h-full sm:h-[90vh] sm:max-h-[800px] sm:rounded-2xl flex flex-col overflow-hidden shadow-2xl transform scale-95 transition-all duration-300 opacity-0 relative" id="create_event_modal_content">
        
        <!-- Header -->
        <div class="flex items-center gap-6 px-5 py-4 bg-[#202c33] shrink-0 border-b border-white/5 shadow-sm z-10">
            <button onclick="window.closeCreateEventModal()" class="text-[#e9edef] hover:text-white transition-colors focus:outline-none">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
            </button>
            <h2 id="create_event_modal_title" class="text-[#e9edef] text-[19px] font-medium">Create event</h2>
            <input type="hidden" id="event_edit_message_id" value="">
        </div>

        <!-- Scrollable Form -->
        <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] pb-24">
            
            <!-- Event Name & Description -->
            <div class="p-5 border-b border-[#202c33]">
                <input type="text" id="event_name_input" placeholder="Event name" class="w-full bg-transparent text-[#e9edef] text-[22px] font-semibold placeholder-[#8696a0] border-none focus:ring-0 p-0 mb-3" autocomplete="off">
                <input type="text" id="event_desc_input" placeholder="Description (Optional)" class="w-full bg-transparent text-[#8696a0] text-[16px] placeholder-[#8696a0] border-none focus:ring-0 p-0" autocomplete="off">
            </div>

            <div class="p-5 flex flex-col gap-6">
                <!-- Start Time -->
                <div class="flex items-start gap-4">
                    <div class="mt-1 text-[#8696a0]">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                            <path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 flex items-center justify-between border-b border-[#202c33] pb-3">
                        <input type="date" id="event_start_date" class="bg-transparent text-[#e9edef] text-[16px] border-none focus:ring-0 p-0 cursor-pointer" value="">
                        <input type="text" readonly id="event_start_time" class="bg-transparent text-[#e9edef] text-[16px] border-none focus:ring-0 p-0 cursor-pointer w-[75px] text-right focus:outline-none" onclick="window.openTimePickerModal(this.dataset.value || this.value, (display, val) => { this.value = display; this.dataset.value = val; })" value="">
                    </div>
                </div>

                <!-- Add / Remove End Time Toggle -->
                <div class="flex items-start gap-4" id="event_end_time_container">
                    <div class="w-6 h-6 shrink-0 border-l-2 border-dashed border-[#313d45] ml-3 hidden" id="event_timeline_line"></div>
                </div>

                <div class="flex items-start gap-4 hidden" id="event_end_time_row">
                    <div class="mt-1 text-[#8696a0]">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                            <path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 flex items-center justify-between border-b border-[#202c33] pb-3">
                        <input type="date" id="event_end_date" class="bg-transparent text-[#e9edef] text-[16px] border-none focus:ring-0 p-0 cursor-pointer">
                        <input type="text" readonly id="event_end_time" class="bg-transparent text-[#e9edef] text-[16px] border-none focus:ring-0 p-0 cursor-pointer w-[75px] text-right focus:outline-none" onclick="window.openTimePickerModal(this.dataset.value || this.value, (display, val) => { this.value = display; this.dataset.value = val; })">
                    </div>
                </div>

                <div class="flex items-start gap-4 ml-[40px]">
                    <button class="text-[#e9edef] text-[16px] py-2" id="event_toggle_end_time_btn" onclick="window.toggleEventEndTime()">Add end time</button>
                </div>

                <!-- Location -->
                <div class="flex items-center gap-4 border-b border-[#202c33] pb-4 pt-2">
                    <div class="text-[#8696a0]">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"></path>
                        </svg>
                    </div>
                    <input type="text" id="event_location" placeholder="Add location" class="w-full bg-transparent text-[#e9edef] text-[16px] placeholder-[#8696a0] border-none focus:ring-0 p-0">
                </div>

                <!-- Call Link -->
                <!-- WhatsApp call link & Call Type -->
                <div class="flex items-start justify-between border-b border-[#202c33] pb-4 pt-2">
                    <div class="flex items-start gap-4">
                        <div class="text-[#8696a0] mt-1" id="event_call_icon">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                <path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"></path>
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[#e9edef] text-[16px]">WhatsApp call link</span>
                            <span id="event_call_type_display" class="hidden text-[#8696a0] text-[14px] mt-1 cursor-pointer" onclick="window.openCallTypeModal()">Video</span>
                            <input type="hidden" id="event_call_type" value="video">
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer mt-1">
                        <input type="checkbox" id="event_call_link" class="sr-only peer" onchange="window.toggleEventCallType()">
                        <div class="w-11 h-6 bg-[#374045] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
                    </label>
                </div>

                <!-- Require approval -->
                <div class="flex items-center justify-between border-b border-[#202c33] pb-4 pt-2">
                    <div class="flex items-center gap-4">
                        <div class="text-[#8696a0]">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                            </svg>
                        </div>
                        <span class="text-[#e9edef] text-[16px]">Require approval to join</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="event_require_approval" class="sr-only peer">
                        <div class="w-11 h-6 bg-[#374045] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
                    </label>
                </div>

                <!-- Reminder -->
                <div class="flex flex-col gap-1 border-b border-[#202c33] pb-4 pt-2 cursor-pointer" onclick="window.openReminderModal()">
                    <div class="flex items-center gap-4">
                        <div class="text-[#8696a0]">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2zm-2 1H8v-6c0-2.48 1.51-4.5 4-4.5s4 2.02 4 4.5v6z"></path>
                            </svg>
                        </div>
                        <span class="text-[#e9edef] text-[16px]">Reminder</span>
                    </div>
                    <input type="hidden" id="event_reminder" value="1h">
                    <div id="event_reminder_display" class="ml-[40px] text-[#8696a0] text-[14px]">1 hour before</div>
                </div>

                <!-- Allow guests -->
                <div class="flex items-center justify-between pb-4 pt-2">
                    <div class="flex flex-col gap-1 ml-[40px]">
                        <span class="text-[#e9edef] text-[16px]">Allow guests</span>
                        <span class="text-[#8696a0] text-[13px]">Allow people to bring one additional guest</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="event_allow_guests" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-[#374045] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
                    </label>
                </div>
                </div>
                
                <!-- Cancel Event (Edit Only) -->
                <div id="event_cancel_row" class="hidden flex items-center gap-4 py-4 cursor-pointer hover:bg-white/5 -mx-5 px-5 transition-colors border-t border-[#202c33]" onclick="window.cancelEvent()">
                    <div class="text-[#f15c6d]">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path>
                        </svg>
                    </div>
                    <span class="text-[#f15c6d] text-[16px]">Cancel event</span>
                </div>
            </div>
            
            <!-- Footer Text (Edit Only) -->
            <div id="event_edit_footer_text" class="hidden text-[#8696a0] text-[13px] px-5 pb-5 pt-2">
                Attendees will be notified of your event update
            </div>
        </div>
        
        <!-- Submit Button (Floating) -->
        <button onclick="window.submitCreateEvent()" class="absolute bottom-6 right-6 w-14 h-14 bg-[#00a884] hover:bg-[#008f72] text-white rounded-full flex items-center justify-center shadow-lg transition-transform hover:scale-105 active:scale-95 focus:outline-none z-20">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path>
            </svg>
        </button>

    </div>
</div>
<!-- Call Type Modal -->
<div id="event_call_type_modal" class="hidden fixed inset-0 z-[6000] flex items-center justify-center bg-black/60 backdrop-blur-sm transition-all duration-300" onclick="window.closeCallTypeModal()">
    <div class="bg-[#202c33] w-[80%] max-w-[340px] rounded-2xl flex flex-col overflow-hidden shadow-2xl p-5 transform scale-95 opacity-0 transition-all duration-300" id="event_call_type_modal_content" onclick="event.stopPropagation()">
        <h3 class="text-[#e9edef] text-[19px] font-medium mb-4">Select a call type</h3>
        
        <label class="flex items-center gap-4 py-3 cursor-pointer">
            <input type="radio" name="event_call_type_radio" value="video" class="hidden peer" onchange="window.setCallType('video')" checked>
            <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] flex items-center justify-center relative after:content-[''] after:w-2.5 after:h-2.5 after:bg-[#00a884] after:rounded-full after:hidden peer-checked:after:block"></div>
            <span class="text-[#e9edef] text-[16px]">Video</span>
        </label>
        
        <label class="flex items-center gap-4 py-3 cursor-pointer">
            <input type="radio" name="event_call_type_radio" value="voice" class="hidden peer" onchange="window.setCallType('voice')">
            <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] flex items-center justify-center relative after:content-[''] after:w-2.5 after:h-2.5 after:bg-[#00a884] after:rounded-full after:hidden peer-checked:after:block"></div>
            <span class="text-[#e9edef] text-[16px]">Voice</span>
        </label>
    </div>
</div>

<!-- Reminder Modal -->
<div id="event_reminder_modal" class="hidden fixed inset-0 z-[6000] flex items-end sm:items-center justify-center bg-black/60 backdrop-blur-sm transition-all duration-300" onclick="window.closeReminderModal()">
    <div class="bg-[#202c33] w-full sm:w-[80%] sm:max-w-[400px] rounded-t-3xl sm:rounded-2xl flex flex-col overflow-hidden shadow-2xl p-5 pb-8 sm:pb-5 transform translate-y-full sm:translate-y-0 sm:scale-95 transition-transform duration-300 sm:transition-all" id="event_reminder_modal_content" onclick="event.stopPropagation()">
        
        <div class="w-8 h-1 bg-[#374045] rounded-full mx-auto mb-4 sm:hidden"></div>
        
        <div class="flex items-center gap-4 mb-4">
            <button onclick="window.closeReminderModal()" class="text-[#e9edef] focus:outline-none">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path></svg>
            </button>
            <h3 class="text-[#e9edef] text-[19px] font-medium">Reminder</h3>
        </div>
        
        <div class="text-[#8696a0] text-[14px] mb-4">Guests also get notified at the time of the event.</div>
        
        <!-- Options -->
        <label class="flex items-center gap-4 py-3 cursor-pointer">
            <input type="radio" name="event_reminder_radio" value="15m" class="hidden peer" onchange="window.setReminder('15m')">
            <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] flex items-center justify-center relative after:content-[''] after:w-2.5 after:h-2.5 after:bg-[#00a884] after:rounded-full after:hidden peer-checked:after:block"></div>
            <span class="text-[#e9edef] text-[16px]">15 minutes before</span>
        </label>
        
        <label class="flex items-center gap-4 py-3 cursor-pointer">
            <input type="radio" name="event_reminder_radio" value="30m" class="hidden peer" onchange="window.setReminder('30m')">
            <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] flex items-center justify-center relative after:content-[''] after:w-2.5 after:h-2.5 after:bg-[#00a884] after:rounded-full after:hidden peer-checked:after:block"></div>
            <span class="text-[#e9edef] text-[16px]">30 minutes before</span>
        </label>
        
        <label class="flex items-center gap-4 py-3 cursor-pointer">
            <input type="radio" name="event_reminder_radio" value="1h" class="hidden peer" onchange="window.setReminder('1h')" checked>
            <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] flex items-center justify-center relative after:content-[''] after:w-2.5 after:h-2.5 after:bg-[#00a884] after:rounded-full after:hidden peer-checked:after:block"></div>
            <span class="text-[#e9edef] text-[16px]">1 hour before</span>
        </label>
        
        <label class="flex items-center gap-4 py-3 cursor-pointer">
            <input type="radio" name="event_reminder_radio" value="1d" class="hidden peer" onchange="window.setReminder('1d')">
            <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] flex items-center justify-center relative after:content-[''] after:w-2.5 after:h-2.5 after:bg-[#00a884] after:rounded-full after:hidden peer-checked:after:block"></div>
            <span class="text-[#e9edef] text-[16px]">1 day before</span>
        </label>
        
        <label class="flex items-center gap-4 py-3 cursor-pointer">
            <input type="radio" name="event_reminder_radio" value="none" class="hidden peer" onchange="window.setReminder('none')">
            <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] peer-checked:border-[#00a884] flex items-center justify-center relative after:content-[''] after:w-2.5 after:h-2.5 after:bg-[#00a884] after:rounded-full after:hidden peer-checked:after:block"></div>
            <span class="text-[#e9edef] text-[16px]">Never</span>
        </label>
    </div>
</div>

<script>
    // Initialize date/time inputs to current/next hour
    function initializeEventDefaults() {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        document.getElementById('event_start_date').value = `${year}-${month}-${day}`;
        
        let hour = now.getHours() + 1;
        if (hour > 23) {
            hour = 23;
        }
        
        let displayHour = hour % 12 || 12;
        let ampm = hour >= 12 ? 'PM' : 'AM';
        
        const stInput = document.getElementById('event_start_time');
        stInput.value = `${displayHour}:00 ${ampm}`;
        stInput.dataset.value = `${String(hour).padStart(2, '0')}:00`;
    }

    window.openCreateEventModal = function(eventData = null, messageId = null) {
        // Close attach menus
        if (typeof toggleAttachMenu === 'function') {
            const menu = document.getElementById('attach_menu');
            if (menu && !menu.classList.contains('hidden')) toggleAttachMenu();
        }
        if (typeof toggleGroupAttachMenu === 'function') {
            const menu = document.getElementById('group_attach_menu');
            if (menu && !menu.classList.contains('hidden')) toggleGroupAttachMenu();
        }

        initializeEventDefaults();
        
        const titleEl = document.getElementById('create_event_modal_title');
        const hiddenIdEl = document.getElementById('event_edit_message_id');
        const cancelRow = document.getElementById('event_cancel_row');
        const footerText = document.getElementById('event_edit_footer_text');

        if (eventData && messageId) {
            // Edit Mode
            titleEl.innerText = 'Edit event';
            hiddenIdEl.value = messageId;
            cancelRow.classList.remove('hidden');
            footerText.classList.remove('hidden');

            document.getElementById('event_name_input').value = eventData.event_name || '';
            document.getElementById('event_desc_input').value = eventData.event_description || '';
            
            if (eventData.start_time) {
                const sd = new Date(eventData.start_time);
                document.getElementById('event_start_date').value = sd.toISOString().split('T')[0];
                const hr = sd.getHours();
                const min = String(sd.getMinutes()).padStart(2, '0');
                const ampm = hr >= 12 ? 'PM' : 'AM';
                const dispHr = hr % 12 || 12;
                const stInput = document.getElementById('event_start_time');
                stInput.value = `${dispHr}:${min} ${ampm}`;
                stInput.dataset.value = `${String(hr).padStart(2, '0')}:${min}`;
            }

            if (eventData.end_time) {
                const ed = new Date(eventData.end_time);
                document.getElementById('event_end_date').value = ed.toISOString().split('T')[0];
                const hr = ed.getHours();
                const min = String(ed.getMinutes()).padStart(2, '0');
                const ampm = hr >= 12 ? 'PM' : 'AM';
                const dispHr = hr % 12 || 12;
                const etInput = document.getElementById('event_end_time');
                etInput.value = `${dispHr}:${min} ${ampm}`;
                etInput.dataset.value = `${String(hr).padStart(2, '0')}:${min}`;
                document.getElementById('event_end_time_row').classList.remove('hidden');
                document.getElementById('event_toggle_end_time_btn').innerText = 'Remove end time';
            } else {
                document.getElementById('event_end_time_row').classList.add('hidden');
                document.getElementById('event_toggle_end_time_btn').innerText = 'Add end time';
            }

            document.getElementById('event_location').value = eventData.location || '';
            
            const callLink = !!eventData.call_link;
            document.getElementById('event_call_link').checked = callLink;
            if (callLink) {
                document.getElementById('event_call_type_display').classList.remove('hidden');
                if (eventData.call_type) {
                    window.setCallType(eventData.call_type);
                }
            } else {
                document.getElementById('event_call_type_display').classList.add('hidden');
            }

            document.getElementById('event_require_approval').checked = !!eventData.require_approval;
            
            if (eventData.reminder) {
                window.setReminder(eventData.reminder);
            }

            document.getElementById('event_allow_guests').checked = eventData.allow_guests !== false;
            
        } else {
            // Create Mode
            titleEl.innerText = 'Create event';
            hiddenIdEl.value = '';
            cancelRow.classList.add('hidden');
            footerText.classList.add('hidden');

            document.getElementById('event_name_input').value = '';
            document.getElementById('event_desc_input').value = '';
            document.getElementById('event_end_time_row').classList.add('hidden');
            document.getElementById('event_toggle_end_time_btn').innerText = 'Add end time';
            document.getElementById('event_location').value = '';
            document.getElementById('event_call_link').checked = false;
            document.getElementById('event_call_type_display').classList.add('hidden');
            document.getElementById('event_require_approval').checked = false;
            document.getElementById('event_reminder').value = '1h';
            window.setReminder('1h');
            document.getElementById('event_allow_guests').checked = true;
            window.setCallType('video');
        }

        const modal = document.getElementById('create_event_modal');
        const content = document.getElementById('create_event_modal_content');
        modal.classList.remove('hidden');
        modal.classList.add('flex'); // Add flex immediately
        
        // Small delay for animation
        setTimeout(() => {
            modal.classList.add('opacity-100');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
            document.getElementById('event_name_input').focus();
        }, 10);
    };

    window.closeCreateEventModal = function() {
        const modal = document.getElementById('create_event_modal');
        const content = document.getElementById('create_event_modal_content');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        modal.classList.remove('opacity-100');
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 300);
    };

    window.toggleEventEndTime = function() {
        const row = document.getElementById('event_end_time_row');
        const btn = document.getElementById('event_toggle_end_time_btn');
        if (row.classList.contains('hidden')) {
            row.classList.remove('hidden');
            btn.innerText = 'Remove end time';
            // Set end time to 1 hour after start by default
            const stDate = document.getElementById('event_start_date').value;
            const stInput = document.getElementById('event_start_time');
            const stTime = stInput.dataset.value || stInput.value;
            if (stDate && stTime) {
                const dateObj = new Date(`${stDate}T${stTime}`);
                dateObj.setHours(dateObj.getHours() + 1);
                
                const year = dateObj.getFullYear();
                const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                const day = String(dateObj.getDate()).padStart(2, '0');
                document.getElementById('event_end_date').value = `${year}-${month}-${day}`;
                const endHour = dateObj.getHours();
                const endMin = dateObj.getMinutes();
                let displayEndHour = endHour % 12 || 12;
                let endAmPm = endHour >= 12 ? 'PM' : 'AM';
                
                const etInput = document.getElementById('event_end_time');
                etInput.value = `${displayEndHour}:${String(endMin).padStart(2, '0')} ${endAmPm}`;
                etInput.dataset.value = `${String(endHour).padStart(2, '0')}:${String(endMin).padStart(2, '0')}`;
            }
        } else {
            row.classList.add('hidden');
            btn.innerText = 'Add end time';
            document.getElementById('event_end_date').value = '';
            document.getElementById('event_end_time').value = '';
        }
    };

    window.toggleEventCallType = function() {
        const checked = document.getElementById('event_call_link').checked;
        const display = document.getElementById('event_call_type_display');
        if (checked) {
            display.classList.remove('hidden');
        } else {
            display.classList.add('hidden');
        }
    };

    window.submitCreateEvent = function() {
        const name = document.getElementById('event_name_input').value.trim();
        if (!name) {
            if (window.showToast) window.showToast('Validation Error', 'Event name is required.');
            else alert("Event name is required.");
            document.getElementById('event_name_input').focus();
            return;
        }

        const desc = document.getElementById('event_desc_input').value.trim();
        const startDate = document.getElementById('event_start_date').value;
        const stInput = document.getElementById('event_start_time');
        const startTime = stInput.dataset.value || stInput.value;
        
        let endDate = null, endTime = null;
        if (!document.getElementById('event_end_time_row').classList.contains('hidden')) {
            endDate = document.getElementById('event_end_date').value;
            const etInput = document.getElementById('event_end_time');
            endTime = etInput.dataset.value || etInput.value;
        }

        const location = document.getElementById('event_location').value.trim();
        const callLink = document.getElementById('event_call_link').checked;
        const callType = callLink ? document.getElementById('event_call_type').value : null;
        const requireApproval = document.getElementById('event_require_approval').checked;
        const reminder = document.getElementById('event_reminder').value;
        const allowGuests = document.getElementById('event_allow_guests').checked;
        const messageId = document.getElementById('event_edit_message_id').value;

        const formData = new FormData();
        formData.append('chat_id', window.currentChatId);
        if (messageId) {
            formData.append('message_id', messageId);
        } else {
            formData.append('type', 'event');
        }
        formData.append('event_name', name);
        formData.append('event_description', desc);
        formData.append('start_time', `${startDate} ${startTime}`);
        if (endDate && endTime) {
            formData.append('end_time', `${endDate} ${endTime}`);
        }
        formData.append('location', location);
        formData.append('call_link', callLink ? 1 : 0);
        if (callType) formData.append('call_type', callType);
        formData.append('require_approval', requireApproval ? 1 : 0);
        formData.append('reminder', reminder);
        formData.append('allow_guests', allowGuests ? 1 : 0);

        const csrf = window.csrf || document.querySelector('meta[name="csrf-token"]')?.content;
        const url = messageId ? '/chat/event/update' : '/send';

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            body: formData
        }).then(r => {
            if (r.ok) {
                if (window.showToast && messageId) window.showToast('Success', 'Event updated successfully.');
                window.closeCreateEventModal();
            } else {
                if (window.showToast) window.showToast('Error', messageId ? 'Failed to update event.' : 'Failed to create event.');
                console.error("Error creating/updating event");
            }
        }).catch(err => {
            if (window.showToast) window.showToast('Error', messageId ? 'Failed to update event.' : 'Failed to create event.');
            console.error("Fetch error creating/updating event:", err);
        });
    };

    window.cancelEvent = function() {
        const messageId = document.getElementById('event_edit_message_id').value;
        if (!messageId) return;

        if (!confirm('Are you sure you want to cancel this event? Attendees will be notified.')) return;

        const formData = new FormData();
        formData.append('chat_id', window.currentChatId);
        formData.append('message_id', messageId);

        const csrf = window.csrf || document.querySelector('meta[name="csrf-token"]')?.content;

        fetch('/chat/event/cancel', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            body: formData
        }).then(r => {
            if (r.ok) {
                if (window.showToast) window.showToast('Success', 'Event cancelled successfully.');
                window.closeCreateEventModal();
            } else {
                if (window.showToast) window.showToast('Error', 'Failed to cancel event.');
                console.error("Error cancelling event");
            }
        }).catch(err => {
            if (window.showToast) window.showToast('Error', 'Failed to cancel event.');
            console.error("Fetch error cancelling event:", err);
        });
    };
    window.openCallTypeModal = function() {
        const modal = document.getElementById('event_call_type_modal');
        const content = document.getElementById('event_call_type_modal_content');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modal.classList.add('opacity-100');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    };

    window.closeCallTypeModal = function() {
        const modal = document.getElementById('event_call_type_modal');
        const content = document.getElementById('event_call_type_modal_content');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        modal.classList.remove('opacity-100');
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 300);
    };

    window.setCallType = function(val) {
        document.getElementById('event_call_type').value = val;
        document.getElementById('event_call_type_display').innerText = val.charAt(0).toUpperCase() + val.slice(1);
        setTimeout(() => {
            window.closeCallTypeModal();
        }, 150);
    };

    window.openReminderModal = function() {
        const modal = document.getElementById('event_reminder_modal');
        const content = document.getElementById('event_reminder_modal_content');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modal.classList.add('opacity-100');
            content.classList.remove('translate-y-full');
            content.classList.remove('sm:scale-95');
            content.classList.add('translate-y-0');
            content.classList.add('sm:scale-100');
        }, 10);
    };

    window.closeReminderModal = function() {
        const modal = document.getElementById('event_reminder_modal');
        const content = document.getElementById('event_reminder_modal_content');
        content.classList.remove('translate-y-0');
        content.classList.remove('sm:scale-100');
        content.classList.add('translate-y-full');
        content.classList.add('sm:scale-95');
        modal.classList.remove('opacity-100');
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 300);
    };

    window.setReminder = function(val) {
        document.getElementById('event_reminder').value = val;
        
        let display = 'Never';
        if (val === '15m') display = '15 minutes before';
        else if (val === '30m') display = '30 minutes before';
        else if (val === '1h') display = '1 hour before';
        else if (val === '1d') display = '1 day before';
        
        document.getElementById('event_reminder_display').innerText = display;
        setTimeout(() => {
            window.closeReminderModal();
        }, 150);
    };
</script>
