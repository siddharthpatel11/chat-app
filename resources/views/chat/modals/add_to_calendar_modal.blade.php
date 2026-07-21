<!-- Add to Calendar Modal (Samsung Calendar Style) -->
<div id="add_to_calendar_modal" class="hidden fixed inset-0 z-[5000] flex items-center justify-center bg-black/60 backdrop-blur-sm transition-opacity opacity-0 duration-300">
    <div class="bg-[#121212] w-full max-w-[400px] h-[85vh] max-h-[800px] rounded-[32px] shadow-2xl relative z-10 flex flex-col transform scale-95 transition-transform duration-300 overflow-hidden" id="add_to_calendar_modal_content">
        
        <!-- Segmented Control -->
        <div class="flex justify-center pt-4 pb-2 shrink-0">
            <div class="bg-black border border-gray-800 rounded-full flex w-[60%] p-0.5 relative">
                <div id="add_to_calendar_tab_event" onclick="switchCalendarTab('event')" class="w-1/2 text-center py-1.5 text-sm font-medium text-white bg-[#3a3a3c] rounded-full cursor-pointer transition-colors z-10 relative">Event</div>
                <div id="add_to_calendar_tab_reminder" onclick="switchCalendarTab('reminder')" class="w-1/2 text-center py-1.5 text-sm font-medium text-gray-400 cursor-pointer hover:text-white transition-colors z-10 relative">Reminder</div>
            </div>
        </div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto custom-scrollbar px-6 pb-24 pt-4">
            
            <!-- Title -->
            <div class="mb-6 relative">
                <input type="text" id="add_to_calendar_title" class="w-full bg-transparent text-white text-2xl font-normal border-b border-gray-800 focus:border-[#00a884] focus:outline-none focus:ring-0 pb-3 placeholder-gray-500" placeholder="Title">
                <!-- Smile and Color circle -->
                <div class="absolute right-0 top-1/2 -translate-y-1/2 flex items-center gap-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div class="w-4 h-4 rounded-full bg-yellow-400"></div>
                </div>
            </div>

            <!-- Time Section -->
            <div class="flex flex-col gap-4 border-b border-gray-800 pb-4 mb-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-white text-[15px]">All day</span>
                    </div>
                    <!-- Toggle Switch -->
                    <label class="relative inline-flex items-center cursor-pointer">
                      <input type="checkbox" value="" class="sr-only peer">
                      <div class="w-9 h-5 bg-gray-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#00a884]"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between pl-9 pr-2" id="add_to_calendar_time_row">
                    <div class="flex flex-col text-center">
                        <span class="text-white text-[15px] font-medium" id="add_to_calendar_start_date">Tue, 21 Jul</span>
                        <span class="text-white text-[15px] mt-2" id="add_to_calendar_start_time">11:30 am</span>
                    </div>
                    <svg id="add_to_calendar_time_arrow" class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <div id="add_to_calendar_end_time_container" class="flex flex-col text-center">
                        <span class="text-white text-[15px] font-medium" id="add_to_calendar_end_date">Tue, 21 Jul</span>
                        <span class="text-white text-[15px] mt-2" id="add_to_calendar_end_time">1:30 pm</span>
                    </div>
                </div>
            </div>

            <!-- List items -->
            <div class="flex flex-col">
                <!-- Shared Fields -->
                
                <!-- Event Specific Fields -->
                <div id="add_to_calendar_event_fields" class="flex flex-col">
                    <!-- Location -->
                    <div class="flex items-center gap-4 py-4 border-b border-gray-800 cursor-text group">
                        <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <input type="text" id="add_to_calendar_location" class="flex-1 bg-transparent border-none text-white text-[15px] p-0 focus:ring-0 placeholder-gray-400 group-hover:placeholder-gray-300" placeholder="Location">
                    </div>

                    <!-- Calendar -->
                    <div class="flex items-center justify-between py-4 border-b border-gray-800 cursor-pointer">
                        <div class="flex items-center gap-4">
                            <div class="relative shrink-0">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <div class="absolute -bottom-1 -right-1 w-2.5 h-2.5 bg-yellow-400 rounded-full border border-[#121212]"></div>
                            </div>
                            <span class="text-white text-[15px]">Family</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>

                <!-- Shared: Alert -->
                <div class="flex items-center gap-4 py-4 border-b border-gray-800 cursor-pointer">
                    <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="text-white text-[15px]">10 mins before</span>
                </div>

                <!-- Shared: Repeat -->
                <div class="flex items-center gap-4 py-4 border-b border-gray-800 cursor-pointer">
                    <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span class="text-gray-400 text-[15px]">Don't repeat</span>
                </div>

                <!-- Event Specific Fields (Continued) -->
                <div id="add_to_calendar_event_fields_2" class="flex flex-col">
                    <!-- Notes -->
                    <div class="flex items-center gap-4 py-4 border-b border-gray-800 cursor-text group">
                        <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        <input type="text" id="add_to_calendar_desc" class="flex-1 bg-transparent border-none text-white text-[15px] p-0 focus:ring-0 placeholder-gray-400 group-hover:placeholder-gray-300" placeholder="Notes">
                    </div>

                    <!-- Video Conference -->
                    <div class="flex items-center gap-4 py-4 border-b border-gray-800 cursor-pointer">
                        <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        <span class="text-white text-[15px]">Video conference</span>
                    </div>
                    
                    <!-- Attachment -->
                    <div class="flex items-center gap-4 py-4 border-b border-gray-800 cursor-pointer">
                        <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        <span class="text-white text-[15px]">Attachment</span>
                    </div>

                    <!-- Invites -->
                    <div class="flex items-center gap-4 py-4 border-b border-gray-800 cursor-pointer">
                        <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <div class="flex-1 flex justify-between items-center">
                            <span class="text-gray-400 text-[15px]">Enter name or email</span>
                            <span class="text-[#3b82f6] text-[15px] font-medium">Contacts</span>
                        </div>
                    </div>

                    <!-- Visibility -->
                    <div class="flex items-center gap-4 py-4 border-b border-gray-800 cursor-pointer">
                        <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <span class="text-white text-[15px]">Default visibility</span>
                    </div>

                    <!-- Busy -->
                    <div class="flex items-center gap-4 py-4 border-b border-gray-800 cursor-pointer">
                        <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span class="text-white text-[15px]">Busy</span>
                    </div>

                    <!-- Timezone -->
                    <div class="flex items-center gap-4 py-4 border-b border-gray-800 cursor-pointer">
                        <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                        <span class="text-white text-[15px]">(GMT+5:30) India Standard Time</span>
                    </div>
                </div>
                
                <!-- Reminder Specific Fields -->
                <div id="add_to_calendar_reminder_fields" class="hidden flex-col">
                    <!-- Alert Type -->
                    <div class="flex items-center justify-between py-4 border-b border-gray-800 cursor-pointer">
                        <div class="flex items-center gap-4">
                            <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                            <span class="text-white text-[15px]">Medium</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>

                    <!-- Save to -->
                    <div class="flex items-center justify-between py-4 border-b border-gray-800 cursor-pointer">
                        <div class="flex items-center gap-4">
                            <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span class="text-white text-[15px]">My reminders</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
            </div>

        </div>

        <!-- Sticky Floating Buttons -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 w-max z-20">
            <div class="bg-[#3a3a3c] rounded-full flex overflow-hidden shadow-lg border border-gray-700">
                <button onclick="closeAddToCalendarModal()" class="px-8 py-3.5 text-[15px] font-medium text-white hover:bg-white/10 transition-colors border-r border-gray-600/50">Cancel</button>
                <button onclick="saveToCalendarNative()" class="px-8 py-3.5 text-[15px] font-medium text-white hover:bg-white/10 transition-colors">Save</button>
            </div>
        </div>

    </div>
</div>

<script>
    let currentNativeCalendarData = null;

    function openAddToCalendarModal(eventDataRaw) {
        try {
            const data = typeof eventDataRaw === 'string' ? JSON.parse(decodeURIComponent(eventDataRaw)) : eventDataRaw;
            currentNativeCalendarData = data;
            
            // Populate data
            const eventName = data.event_name || 'Event';
            const eventDesc = data.event_description || '';
            const location = data.location || '';
            
            document.getElementById('add_to_calendar_title').value = eventName;
            document.getElementById('add_to_calendar_location').value = location;
            document.getElementById('add_to_calendar_desc').value = eventDesc;
            
            // Format dates
            const startTime = data.start_time ? new Date(data.start_time) : new Date();
            let endTime = data.end_time ? new Date(data.end_time) : null;
            
            if (!endTime) {
                endTime = new Date(startTime.getTime());
                endTime.setHours(endTime.getHours() + 1);
            }
            
            const formatDateNative = (d) => {
                return d.toLocaleDateString('en-GB', { weekday: 'short', day: 'numeric', month: 'short' });
            };
            
            const formatTimeNative = (d) => {
                return d.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true }).toLowerCase();
            };
            
            document.getElementById('add_to_calendar_start_date').textContent = formatDateNative(startTime);
            document.getElementById('add_to_calendar_start_time').textContent = formatTimeNative(startTime);
            
            document.getElementById('add_to_calendar_end_date').textContent = formatDateNative(endTime);
            document.getElementById('add_to_calendar_end_time').textContent = formatTimeNative(endTime);
            
            // Show modal and reset to Event tab
            switchCalendarTab('event');

            const modal = document.getElementById('add_to_calendar_modal');
            const content = document.getElementById('add_to_calendar_modal_content');
            
            modal.classList.remove('hidden');
            requestAnimationFrame(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
            });
            
        } catch (e) {
            console.error(e);
        }
    }

    function switchCalendarTab(tab) {
        const tabEvent = document.getElementById('add_to_calendar_tab_event');
        const tabReminder = document.getElementById('add_to_calendar_tab_reminder');
        
        const eventFields1 = document.getElementById('add_to_calendar_event_fields');
        const eventFields2 = document.getElementById('add_to_calendar_event_fields_2');
        const reminderFields = document.getElementById('add_to_calendar_reminder_fields');

        const timeArrow = document.getElementById('add_to_calendar_time_arrow');
        const endTimeContainer = document.getElementById('add_to_calendar_end_time_container');
        const timeRow = document.getElementById('add_to_calendar_time_row');

        if (tab === 'event') {
            tabEvent.classList.remove('text-gray-400', 'hover:text-white');
            tabEvent.classList.add('text-white', 'bg-[#3a3a3c]');
            
            tabReminder.classList.add('text-gray-400', 'hover:text-white');
            tabReminder.classList.remove('text-white', 'bg-[#3a3a3c]');

            eventFields1.classList.remove('hidden');
            eventFields1.classList.add('flex');
            eventFields2.classList.remove('hidden');
            eventFields2.classList.add('flex');
            
            reminderFields.classList.remove('flex');
            reminderFields.classList.add('hidden');

            timeArrow.classList.remove('hidden');
            endTimeContainer.classList.remove('hidden');
            endTimeContainer.classList.add('flex');
            timeRow.classList.add('justify-between');
        } else {
            tabReminder.classList.remove('text-gray-400', 'hover:text-white');
            tabReminder.classList.add('text-white', 'bg-[#3a3a3c]');
            
            tabEvent.classList.add('text-gray-400', 'hover:text-white');
            tabEvent.classList.remove('text-white', 'bg-[#3a3a3c]');

            eventFields1.classList.remove('flex');
            eventFields1.classList.add('hidden');
            eventFields2.classList.remove('flex');
            eventFields2.classList.add('hidden');
            
            reminderFields.classList.remove('hidden');
            reminderFields.classList.add('flex');

            timeArrow.classList.add('hidden');
            endTimeContainer.classList.remove('flex');
            endTimeContainer.classList.add('hidden');
            timeRow.classList.remove('justify-between');
        }
    }

    function closeAddToCalendarModal() {
        const modal = document.getElementById('add_to_calendar_modal');
        const content = document.getElementById('add_to_calendar_modal_content');
        
        modal.classList.add('opacity-0');
        content.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function saveToCalendarNative() {
        // Just show success and close, as it simulates native save
        if (window.showToast) {
            window.showToast('Success', 'Event saved to calendar!');
        } else {
            alert('Event saved to calendar!');
        }
        closeAddToCalendarModal();
    }
</script>
