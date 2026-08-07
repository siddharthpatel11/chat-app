<div id="storage_and_data_settings_panel"
    class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="toggleStorageAndDataSettings()" class="text-[#aebac1] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">Storage and data</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 min-h-0 overflow-y-auto custom-scrollbar bg-[#111b21] py-2">
        <div class="flex flex-col gap-0 mx-4 mb-4 pb-2 mt-2">
            
            <!-- Manage storage -->
            <div class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4" onclick="toggleManageStorage()">
                <div class="w-12 shrink-0 flex justify-start text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                    </svg>
                </div>
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">Manage storage</span>
                    <span id="main_storage_usage_text" class="text-[#8696a0] text-[14px] mt-1">...</span>
                </div>
            </div>

            <!-- Network usage -->
            <div class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4" onclick="toggleNetworkUsage()">
                <div class="w-12 shrink-0 flex justify-start text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 2v6h-6"></path>
                        <path d="M3 12a9 9 0 1 0 2.5-6.5L21 8"></path>
                    </svg>
                </div>
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">Network usage</span>
                    <span id="main_network_usage_text" class="text-[#8696a0] text-[14px] mt-1">360.5 MB sent &bull; 484.1 MB received</span>
                </div>
            </div>

            <!-- Use less data for calls -->
            <div class="flex items-center py-4 justify-between -mx-4 px-4">
                <div class="w-12 shrink-0 flex justify-start text-[#8696a0]"></div>
                <div class="flex-1 flex justify-between items-center">
                    <span class="text-[#e9edef] text-[16px]">Use less data for calls</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="use_less_data_calls_toggle" class="sr-only peer" onchange="toggleUseLessDataForCalls(this.checked)">
                        <div class="w-11 h-6 bg-[#313d45] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
                    </label>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const lessDataToggle = document.getElementById('use_less_data_calls_toggle');
                    if (lessDataToggle) {
                        // Load saved preference from localStorage, default to false if not set
                        const savedSetting = localStorage.getItem('whatsapp_use_less_data_calls');
                        lessDataToggle.checked = savedSetting === 'true';
                    }
                    
                    // Fetch real-time setting from Firebase once db is ready
                    checkAndLoadFirebaseStorageSettings();
                });

                function checkAndLoadFirebaseStorageSettings() {
                    if (window.db && window.ref && window.get && window.myUserId && window.myUserId !== '0') {
                        window.get(window.ref(window.db, `users/${window.myUserId}/settings/use_less_data_calls`)).then(snap => {
                            if (snap.exists()) {
                                const isChecked = snap.val();
                                const lessDataToggle = document.getElementById('use_less_data_calls_toggle');
                                if (lessDataToggle) lessDataToggle.checked = isChecked;
                                localStorage.setItem('whatsapp_use_less_data_calls', isChecked);
                            }
                        }).catch(e => console.error("Firebase fetch error:", e));
                    } else {
                        setTimeout(checkAndLoadFirebaseStorageSettings, 1000);
                    }
                }

                function toggleUseLessDataForCalls(isChecked) {
                    localStorage.setItem('whatsapp_use_less_data_calls', isChecked);
                    
                    // Sync with Firebase backend
                    if (window.db && window.ref && window.set && window.myUserId && window.myUserId !== '0') {
                        window.set(window.ref(window.db, `users/${window.myUserId}/settings/use_less_data_calls`), isChecked)
                            .catch(e => console.error("Firebase save error:", e));
                    }
                }

                // Media Upload Quality Logic
                let currentSelectedMediaQuality = 'HD quality';

                document.addEventListener('DOMContentLoaded', () => {
                    const savedQ = localStorage.getItem('whatsapp_media_upload_quality');
                    if (savedQ) {
                        currentSelectedMediaQuality = savedQ;
                        updateMediaUploadQualityUI();
                    }
                    checkAndLoadFirebaseMediaQuality();
                });

                function checkAndLoadFirebaseMediaQuality() {
                    if (window.db && window.ref && window.get && window.myUserId && window.myUserId !== '0') {
                        window.get(window.ref(window.db, `users/${window.myUserId}/settings/media_upload_quality`)).then(snap => {
                            if (snap.exists()) {
                                currentSelectedMediaQuality = snap.val();
                                localStorage.setItem('whatsapp_media_upload_quality', currentSelectedMediaQuality);
                                updateMediaUploadQualityUI();
                            }
                        }).catch(e => console.error(e));
                    } else {
                        setTimeout(checkAndLoadFirebaseMediaQuality, 1000);
                    }
                }

                function updateMediaUploadQualityUI() {
                    const textEl = document.getElementById('storage_media_upload_quality_text');
                    if(textEl) textEl.innerText = currentSelectedMediaQuality;
                }

                function openMediaUploadQualityModal() {
                    document.getElementById('media_upload_quality_modal').classList.remove('hidden');
                    currentSelectedMediaQuality = localStorage.getItem('whatsapp_media_upload_quality') || 'HD quality';
                    selectMediaQuality(currentSelectedMediaQuality);
                }

                function closeMediaUploadQualityModal() {
                    document.getElementById('media_upload_quality_modal').classList.add('hidden');
                }

                function selectMediaQuality(quality) {
                    currentSelectedMediaQuality = quality;
                    
                    const stdOut = document.getElementById('media_quality_radio_standard');
                    const stdIn = document.getElementById('media_quality_radio_inner_standard');
                    const hdOut = document.getElementById('media_quality_radio_hd');
                    const hdIn = document.getElementById('media_quality_radio_inner_hd');

                    // Reset both
                    stdOut.classList.remove('border-[#00a884]'); stdOut.classList.add('border-[#8696a0]');
                    hdOut.classList.remove('border-[#00a884]'); hdOut.classList.add('border-[#8696a0]');
                    stdIn.classList.add('hidden');
                    hdIn.classList.add('hidden');

                    // Activate selected
                    if (quality === 'Standard quality') {
                        stdOut.classList.add('border-[#00a884]'); stdOut.classList.remove('border-[#8696a0]');
                        stdIn.classList.remove('hidden');
                    } else {
                        hdOut.classList.add('border-[#00a884]'); hdOut.classList.remove('border-[#8696a0]');
                        hdIn.classList.remove('hidden');
                    }
                }

                function saveMediaUploadQuality() {
                    localStorage.setItem('whatsapp_media_upload_quality', currentSelectedMediaQuality);
                    updateMediaUploadQualityUI();
                    
                    if (window.db && window.ref && window.set && window.myUserId && window.myUserId !== '0') {
                        window.set(window.ref(window.db, `users/${window.myUserId}/settings/media_upload_quality`), currentSelectedMediaQuality)
                            .then(() => { if(window.showToast) window.showToast('Setting Saved', 'Media upload quality updated.'); })
                            .catch(e => console.error("Firebase save media quality error:", e));
                    }
                    closeMediaUploadQualityModal();
                }
            </script>

            <!-- Proxy -->
            <div class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4" onclick="toggleProxySettings()">
                <div class="w-12 shrink-0 flex justify-start text-[#8696a0]"></div>
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">Proxy</span>
                    <span id="storage_and_data_proxy_text" class="text-[#8696a0] text-[14px] mt-1">Off</span>
                </div>
            </div>

            <!-- Media upload quality -->
            <div class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4" onclick="openMediaUploadQualityModal()">
                <div class="w-12 shrink-0 flex justify-start text-[#8696a0]">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                        <polyline points="21 15 16 10 5 21"></polyline>
                        <path d="M18 10a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"></path>
                    </svg>
                </div>
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">Media upload quality</span>
                    <span id="storage_media_upload_quality_text" class="text-[#8696a0] text-[14px] mt-1">HD quality</span>
                </div>
            </div>

            <!-- Auto-download quality -->
            <div class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4 border-b border-[#313d45]">
                <div class="w-12 shrink-0 flex justify-start text-[#8696a0]"></div>
                <div class="flex-1 flex flex-col mb-4">
                    <span class="text-[#e9edef] text-[16px]">Auto-download quality</span>
                    <span class="text-[#8696a0] text-[14px] mt-1">HD quality</span>
                </div>
            </div>
            
            <!-- Media auto-download -->
            <div class="flex flex-col py-4 mt-2 mb-2">
                <span class="text-[#8696a0] text-[14px] font-semibold mb-1">Media auto-download</span>
                <span class="text-[#8696a0] text-[14px]">Voice messages are always automatically downloaded</span>
            </div>

            <!-- When using mobile data -->
            <div class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4">
                <div class="w-12 shrink-0 flex justify-start text-[#8696a0]"></div>
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">When using mobile data</span>
                    <span class="text-[#8696a0] text-[14px] mt-1">Photos</span>
                </div>
            </div>

            <!-- When connected on Wi-Fi -->
            <div class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4">
                <div class="w-12 shrink-0 flex justify-start text-[#8696a0]"></div>
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">When connected on Wi-Fi</span>
                    <span class="text-[#8696a0] text-[14px] mt-1">No media</span>
                </div>
            </div>

            <!-- When roaming -->
            <div class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4">
                <div class="w-12 shrink-0 flex justify-start text-[#8696a0]"></div>
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">When roaming</span>
                    <span class="text-[#8696a0] text-[14px] mt-1">No media</span>
                </div>
            </div>

        </div>
    </div>

    <!-- Media upload quality Modal overlay -->
    <div id="media_upload_quality_modal" class="hidden absolute top-0 left-0 w-full h-full z-50 bg-black bg-opacity-70 flex items-center justify-center px-4">
        <div class="bg-[#2a3942] rounded-2xl w-full max-w-[340px] p-6 shadow-2xl relative">
            <h2 class="text-[#e9edef] text-[20px] mb-2 font-medium">Media upload quality</h2>
            <p class="text-[#8696a0] text-[14px] mb-6 leading-snug">Select the quality for photos and videos to be sent at in chats.</p>
            
            <div class="flex flex-col gap-5 mb-8">
                <div class="flex items-start gap-4 cursor-pointer" onclick="selectMediaQuality('Standard quality')">
                    <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] flex items-center justify-center shrink-0 mt-0.5 transition-colors" id="media_quality_radio_standard">
                        <div class="w-2.5 h-2.5 rounded-full bg-[#00a884] hidden" id="media_quality_radio_inner_standard"></div>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[#e9edef] text-[16px] leading-tight">Standard quality</span>
                        <span class="text-[#8696a0] text-[14px] mt-1 leading-snug">Faster to send, smaller file size</span>
                    </div>
                </div>

                <div class="flex items-start gap-4 cursor-pointer" onclick="selectMediaQuality('HD quality')">
                    <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] flex items-center justify-center shrink-0 mt-0.5 transition-colors" id="media_quality_radio_hd">
                        <div class="w-2.5 h-2.5 rounded-full bg-[#00a884] hidden" id="media_quality_radio_inner_hd"></div>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[#e9edef] text-[16px] leading-tight">HD quality</span>
                        <span class="text-[#8696a0] text-[14px] mt-1 leading-snug">Slower to send, can be 6 times larger</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-6 text-[#00a884] font-medium text-[14px]">
                <button onclick="closeMediaUploadQualityModal()" class="hover:text-[#00c99f]">Cancel</button>
                <button onclick="saveMediaUploadQuality()" class="hover:text-[#00c99f]">Save</button>
            </div>
        </div>
    </div>

</div>
