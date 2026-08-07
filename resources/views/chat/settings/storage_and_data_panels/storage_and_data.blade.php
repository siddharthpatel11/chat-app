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
                    
                    // Load Media Upload Quality
                    const savedMediaQuality = localStorage.getItem('whatsapp_media_upload_quality');
                    if (savedMediaQuality) {
                        currentSelectedMediaQuality = savedMediaQuality;
                        updateMediaUploadQualityUI();
                    }

                    // Load Auto Download Quality
                    const savedAutoDownloadQuality = localStorage.getItem('whatsapp_auto_download_quality');
                    if (savedAutoDownloadQuality) {
                        currentSelectedAutoDownloadQuality = savedAutoDownloadQuality;
                        updateAutoDownloadQualityUI();
                    }

                    // Load Media Auto Download Settings
                    ['mobile', 'wifi', 'roaming'].forEach(type => {
                        const saved = localStorage.getItem('whatsapp_media_auto_download_' + type);
                        if (saved) {
                            try {
                                currentMediaAutoDownloadSettings[type] = JSON.parse(saved);
                            } catch(e) {}
                        }
                        updateMediaAutoDownloadUI(type);
                    });
                    
                    checkAndLoadFirebaseStorageSettings();
                });

                function checkAndLoadFirebaseStorageSettings() {
                    if (window.db && window.ref && window.get && window.myUserId && window.myUserId !== '0') {
                        window.get(window.ref(window.db, `users/${window.myUserId}/settings`)).then(snapshot => {
                            if (snapshot.exists()) {
                                const settings = snapshot.val();
                                
                                // Proxy
                                if (settings.use_proxy !== undefined && !localStorage.getItem('whatsapp_use_proxy')) {
                                    localStorage.setItem('whatsapp_use_proxy', settings.use_proxy ? 'true' : 'false');
                                }
                                
                                // Media Upload
                                if (settings.media_upload_quality !== undefined && !localStorage.getItem('whatsapp_media_upload_quality')) {
                                    localStorage.setItem('whatsapp_media_upload_quality', settings.media_upload_quality);
                                    currentSelectedMediaQuality = settings.media_upload_quality;
                                    updateMediaUploadQualityUI();
                                }

                                // Auto Download
                                if (settings.auto_download_quality !== undefined && !localStorage.getItem('whatsapp_auto_download_quality')) {
                                    localStorage.setItem('whatsapp_auto_download_quality', settings.auto_download_quality);
                                    currentSelectedAutoDownloadQuality = settings.auto_download_quality;
                                    updateAutoDownloadQualityUI();
                                }

                                // Media Auto Download Settings
                                ['mobile', 'wifi', 'roaming'].forEach(type => {
                                    if (settings['media_auto_download_' + type] !== undefined && !localStorage.getItem('whatsapp_media_auto_download_' + type)) {
                                        localStorage.setItem('whatsapp_media_auto_download_' + type, JSON.stringify(settings['media_auto_download_' + type]));
                                        currentMediaAutoDownloadSettings[type] = settings['media_auto_download_' + type];
                                        updateMediaAutoDownloadUI(type);
                                    }
                                });
                                
                                if(typeof updateProxyUI === 'function') updateProxyUI();
                                
                                if (settings.use_less_data_calls !== undefined) {
                                    const isChecked = settings.use_less_data_calls;
                                    const lessDataToggle = document.getElementById('use_less_data_calls_toggle');
                                    if (lessDataToggle) lessDataToggle.checked = isChecked;
                                    localStorage.setItem('whatsapp_use_less_data_calls', isChecked);
                                }
                            }
                        }).catch(e => console.error("Firebase fetch error:", e));
                    } else {
                        setTimeout(checkAndLoadFirebaseStorageSettings, 1000);
                    }
                }

                function toggleUseLessDataForCalls(isChecked) {
                    localStorage.setItem('whatsapp_use_less_data_calls', isChecked);
                    
                    if (window.db && window.ref && window.set && window.myUserId && window.myUserId !== '0') {
                        window.set(window.ref(window.db, `users/${window.myUserId}/settings/use_less_data_calls`), isChecked)
                            .catch(e => console.error("Firebase save error:", e));
                    }
                }

                let currentSelectedMediaQuality = 'HD quality';
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

                let currentSelectedAutoDownloadQuality = 'HD quality';

                function updateAutoDownloadQualityUI() {
                    const textEl = document.getElementById('storage_auto_download_quality_text');
                    if(textEl) textEl.innerText = currentSelectedAutoDownloadQuality;
                }

                function openAutoDownloadQualityModal() {
                    document.getElementById('auto_download_quality_modal').classList.remove('hidden');
                    currentSelectedAutoDownloadQuality = localStorage.getItem('whatsapp_auto_download_quality') || 'HD quality';
                    selectAutoDownloadQuality(currentSelectedAutoDownloadQuality);
                }

                function closeAutoDownloadQualityModal() {
                    document.getElementById('auto_download_quality_modal').classList.add('hidden');
                }

                function selectAutoDownloadQuality(quality) {
                    currentSelectedAutoDownloadQuality = quality;
                    
                    const autoOut = document.getElementById('auto_download_radio_auto');
                    const autoIn = document.getElementById('auto_download_radio_inner_auto');
                    const stdOut = document.getElementById('auto_download_radio_standard');
                    const stdIn = document.getElementById('auto_download_radio_inner_standard');
                    const hdOut = document.getElementById('auto_download_radio_hd');
                    const hdIn = document.getElementById('auto_download_radio_inner_hd');

                    // Reset all
                    autoOut.classList.remove('border-[#00a884]'); autoOut.classList.add('border-[#8696a0]');
                    stdOut.classList.remove('border-[#00a884]'); stdOut.classList.add('border-[#8696a0]');
                    hdOut.classList.remove('border-[#00a884]'); hdOut.classList.add('border-[#8696a0]');
                    autoIn.classList.add('hidden');
                    stdIn.classList.add('hidden');
                    hdIn.classList.add('hidden');

                    // Activate selected & update subtitle
                    const subtitle = document.getElementById('auto_download_modal_subtitle');
                    if (quality === 'Auto') {
                        autoOut.classList.add('border-[#00a884]'); autoOut.classList.remove('border-[#8696a0]');
                        autoIn.classList.remove('hidden');
                        if (subtitle) subtitle.innerText = "Photos and videos will be automatically downloaded in Auto quality. This balances data and storage.";
                    } else if (quality === 'Standard quality') {
                        stdOut.classList.add('border-[#00a884]'); stdOut.classList.remove('border-[#8696a0]');
                        stdIn.classList.remove('hidden');
                        if (subtitle) subtitle.innerText = "Photos and videos will be automatically downloaded in standard quality. This uses less storage space.";
                    } else {
                        hdOut.classList.add('border-[#00a884]'); hdOut.classList.remove('border-[#8696a0]');
                        hdIn.classList.remove('hidden');
                        if (subtitle) subtitle.innerText = "Photos and videos will be automatically downloaded in HD quality. This uses the most storage space.";
                    }
                }

                function saveAutoDownloadQuality() {
                    localStorage.setItem('whatsapp_auto_download_quality', currentSelectedAutoDownloadQuality);
                    updateAutoDownloadQualityUI();
                    
                    if (window.db && window.ref && window.set && window.myUserId && window.myUserId !== '0') {
                        window.set(window.ref(window.db, `users/${window.myUserId}/settings/auto_download_quality`), currentSelectedAutoDownloadQuality)
                            .then(() => { if(window.showToast) window.showToast('Setting Saved', 'Auto-download quality updated.'); })
                            .catch(e => console.error("Firebase save auto download quality error:", e));
                    }
                    closeAutoDownloadQualityModal();
                }

                // Media Auto-Download Logic
                let currentMediaAutoDownloadSettings = {
                    'mobile': ['photos'],
                    'wifi': ['photos', 'audio', 'videos', 'documents'],
                    'roaming': []
                };
                let activeMediaAutoDownloadType = null; // 'mobile', 'wifi', or 'roaming'
                let tempMediaAutoDownloadSelection = [];

                function getMediaAutoDownloadText(arr) {
                    if (!arr || arr.length === 0) return 'No media';
                    if (arr.length === 4) return 'All media';
                    const map = {
                        'photos': 'Photos',
                        'audio': 'Audio',
                        'videos': 'Videos',
                        'documents': 'Documents'
                    };
                    return arr.map(i => map[i]).join(', ');
                }

                function updateMediaAutoDownloadUI(type) {
                    const textEl = document.getElementById('media_auto_download_' + type + '_text');
                    if (textEl) textEl.innerText = getMediaAutoDownloadText(currentMediaAutoDownloadSettings[type]);
                }

                function openMediaAutoDownloadModal(type) {
                    activeMediaAutoDownloadType = type;
                    tempMediaAutoDownloadSelection = [...currentMediaAutoDownloadSettings[type]];
                    
                    let title = 'When using mobile data';
                    if (type === 'wifi') title = 'When connected on Wi-Fi';
                    else if (type === 'roaming') title = 'When roaming';
                    
                    document.getElementById('media_auto_download_modal_title').innerText = title;
                    
                    // Update checkboxes
                    ['photos', 'audio', 'videos', 'documents'].forEach(item => {
                        const isChecked = tempMediaAutoDownloadSelection.includes(item);
                        const box = document.getElementById('media_auto_download_check_' + item);
                        const svg = document.getElementById('media_auto_download_svg_' + item);
                        if (isChecked) {
                            box.classList.add('bg-[#00a884]', 'border-[#00a884]');
                            box.classList.remove('border-[#8696a0]');
                            svg.classList.remove('hidden');
                        } else {
                            box.classList.remove('bg-[#00a884]', 'border-[#00a884]');
                            box.classList.add('border-[#8696a0]');
                            svg.classList.add('hidden');
                        }
                    });

                    document.getElementById('media_auto_download_modal').classList.remove('hidden');
                }

                function closeMediaAutoDownloadModal() {
                    document.getElementById('media_auto_download_modal').classList.add('hidden');
                }

                function toggleMediaAutoDownloadItem(item) {
                    const idx = tempMediaAutoDownloadSelection.indexOf(item);
                    if (idx > -1) {
                        tempMediaAutoDownloadSelection.splice(idx, 1);
                    } else {
                        tempMediaAutoDownloadSelection.push(item);
                    }
                    
                    // Update visual
                    const isChecked = tempMediaAutoDownloadSelection.includes(item);
                    const box = document.getElementById('media_auto_download_check_' + item);
                    const svg = document.getElementById('media_auto_download_svg_' + item);
                    if (isChecked) {
                        box.classList.add('bg-[#00a884]', 'border-[#00a884]');
                        box.classList.remove('border-[#8696a0]');
                        svg.classList.remove('hidden');
                    } else {
                        box.classList.remove('bg-[#00a884]', 'border-[#00a884]');
                        box.classList.add('border-[#8696a0]');
                        svg.classList.add('hidden');
                    }
                }

                function saveMediaAutoDownload() {
                    if (!activeMediaAutoDownloadType) return;
                    currentMediaAutoDownloadSettings[activeMediaAutoDownloadType] = [...tempMediaAutoDownloadSelection];
                    localStorage.setItem('whatsapp_media_auto_download_' + activeMediaAutoDownloadType, JSON.stringify(currentMediaAutoDownloadSettings[activeMediaAutoDownloadType]));
                    updateMediaAutoDownloadUI(activeMediaAutoDownloadType);
                    
                    if (window.db && window.ref && window.set && window.myUserId && window.myUserId !== '0') {
                        window.set(window.ref(window.db, `users/${window.myUserId}/settings/media_auto_download_${activeMediaAutoDownloadType}`), currentMediaAutoDownloadSettings[activeMediaAutoDownloadType])
                            .then(() => { if(window.showToast) window.showToast('Setting Saved', 'Media auto-download updated.'); })
                            .catch(e => console.error("Firebase save error:", e));
                    }
                    
                    closeMediaAutoDownloadModal();
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
            <div class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4 border-b border-[#313d45]" onclick="openAutoDownloadQualityModal()">
                <div class="w-12 shrink-0 flex justify-start text-[#8696a0]"></div>
                <div class="flex-1 flex flex-col mb-4">
                    <span class="text-[#e9edef] text-[16px]">Auto-download quality</span>
                    <span id="storage_auto_download_quality_text" class="text-[#8696a0] text-[14px] mt-1">HD quality</span>
                </div>
            </div>
            
            <!-- Media auto-download -->
            <div class="flex flex-col py-4 mt-2 mb-2">
                <span class="text-[#8696a0] text-[14px] font-semibold mb-1">Media auto-download</span>
                <span class="text-[#8696a0] text-[14px]">Voice messages are always automatically downloaded</span>
            </div>

            <!-- When using mobile data -->
            <div class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4" onclick="openMediaAutoDownloadModal('mobile')">
                <div class="w-12 shrink-0 flex justify-start text-[#8696a0]"></div>
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">When using mobile data</span>
                    <span id="media_auto_download_mobile_text" class="text-[#8696a0] text-[14px] mt-1">Photos</span>
                </div>
            </div>

            <!-- When connected on Wi-Fi -->
            <div class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4" onclick="openMediaAutoDownloadModal('wifi')">
                <div class="w-12 shrink-0 flex justify-start text-[#8696a0]"></div>
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">When connected on Wi-Fi</span>
                    <span id="media_auto_download_wifi_text" class="text-[#8696a0] text-[14px] mt-1">No media</span>
                </div>
            </div>

            <!-- When roaming -->
            <div class="flex items-center py-4 cursor-pointer hover:bg-[#202c33] transition-colors -mx-4 px-4" onclick="openMediaAutoDownloadModal('roaming')">
                <div class="w-12 shrink-0 flex justify-start text-[#8696a0]"></div>
                <div class="flex-1 flex flex-col">
                    <span class="text-[#e9edef] text-[16px]">When roaming</span>
                    <span id="media_auto_download_roaming_text" class="text-[#8696a0] text-[14px] mt-1">No media</span>
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

    <!-- Auto-download quality Modal overlay -->
    <div id="auto_download_quality_modal" class="hidden absolute top-0 left-0 w-full h-full z-50 bg-black bg-opacity-70 flex items-center justify-center px-4">
        <div class="bg-[#2a3942] rounded-2xl w-full max-w-[340px] p-6 shadow-2xl relative">
            <h2 class="text-[#e9edef] text-[20px] mb-2 font-medium">Auto-download quality</h2>
            <p id="auto_download_modal_subtitle" class="text-[#8696a0] text-[14px] mb-6 leading-snug">Photos and videos will be automatically downloaded in HD quality. This uses the most storage space.</p>
            
            <div class="flex flex-col gap-5 mb-8">
                <!-- Auto -->
                <div class="flex items-start gap-4 cursor-pointer" onclick="selectAutoDownloadQuality('Auto')">
                    <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] flex items-center justify-center shrink-0 transition-colors" id="auto_download_radio_auto">
                        <div class="w-2.5 h-2.5 rounded-full bg-[#00a884] hidden" id="auto_download_radio_inner_auto"></div>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[#e9edef] text-[16px] leading-tight mt-0.5">Auto</span>
                    </div>
                </div>

                <!-- Standard quality -->
                <div class="flex items-start gap-4 cursor-pointer" onclick="selectAutoDownloadQuality('Standard quality')">
                    <div class="w-5 h-5 rounded-full border-2 border-[#8696a0] flex items-center justify-center shrink-0 transition-colors" id="auto_download_radio_standard">
                        <div class="w-2.5 h-2.5 rounded-full bg-[#00a884] hidden" id="auto_download_radio_inner_standard"></div>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[#e9edef] text-[16px] leading-tight mt-0.5">Standard quality</span>
                    </div>
                </div>

                <!-- HD quality -->
                <div class="flex items-start gap-4 cursor-pointer" onclick="selectAutoDownloadQuality('HD quality')">
                    <div class="w-5 h-5 rounded-full border-2 border-[#00a884] flex items-center justify-center shrink-0 transition-colors" id="auto_download_radio_hd">
                        <div class="w-2.5 h-2.5 rounded-full bg-[#00a884]" id="auto_download_radio_inner_hd"></div>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[#e9edef] text-[16px] leading-tight mt-0.5">HD quality</span>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end gap-6 text-[#00a884] font-medium text-[14px]">
                <button onclick="closeAutoDownloadQualityModal()" class="hover:text-[#00c99f]">Cancel</button>
                <button onclick="saveAutoDownloadQuality()" class="hover:text-[#00c99f]">Save</button>
            </div>
        </div>
    </div>

    <!-- Media Auto-Download Modal -->
    <div id="media_auto_download_modal" class="hidden absolute top-0 left-0 w-full h-full z-50 bg-black bg-opacity-70 flex items-center justify-center px-4">
        <div class="bg-[#2a3942] rounded-2xl w-full max-w-[340px] p-6 shadow-2xl relative">
            <h2 id="media_auto_download_modal_title" class="text-[#e9edef] text-[20px] mb-6 font-medium">When using mobile data</h2>
            
            <div class="flex flex-col gap-5 mb-8">
                <!-- Photos -->
                <div class="flex items-center gap-4 cursor-pointer" onclick="toggleMediaAutoDownloadItem('photos')">
                    <div class="w-5 h-5 rounded border-2 border-[#8696a0] flex items-center justify-center shrink-0 transition-colors" id="media_auto_download_check_photos">
                        <svg id="media_auto_download_svg_photos" class="hidden w-3 h-3 text-[#111b21]" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span class="text-[#e9edef] text-[16px] leading-tight mt-0.5">Photos</span>
                </div>
                <!-- Audio -->
                <div class="flex items-center gap-4 cursor-pointer" onclick="toggleMediaAutoDownloadItem('audio')">
                    <div class="w-5 h-5 rounded border-2 border-[#8696a0] flex items-center justify-center shrink-0 transition-colors" id="media_auto_download_check_audio">
                        <svg id="media_auto_download_svg_audio" class="hidden w-3 h-3 text-[#111b21]" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span class="text-[#e9edef] text-[16px] leading-tight mt-0.5">Audio</span>
                </div>
                <!-- Videos -->
                <div class="flex items-center gap-4 cursor-pointer" onclick="toggleMediaAutoDownloadItem('videos')">
                    <div class="w-5 h-5 rounded border-2 border-[#8696a0] flex items-center justify-center shrink-0 transition-colors" id="media_auto_download_check_videos">
                        <svg id="media_auto_download_svg_videos" class="hidden w-3 h-3 text-[#111b21]" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span class="text-[#e9edef] text-[16px] leading-tight mt-0.5">Videos</span>
                </div>
                <!-- Documents -->
                <div class="flex items-center gap-4 cursor-pointer" onclick="toggleMediaAutoDownloadItem('documents')">
                    <div class="w-5 h-5 rounded border-2 border-[#8696a0] flex items-center justify-center shrink-0 transition-colors" id="media_auto_download_check_documents">
                        <svg id="media_auto_download_svg_documents" class="hidden w-3 h-3 text-[#111b21]" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span class="text-[#e9edef] text-[16px] leading-tight mt-0.5">Documents</span>
                </div>
            </div>
            
            <div class="flex justify-end gap-6 text-[#00a884] font-medium text-[14px]">
                <button onclick="closeMediaAutoDownloadModal()" class="hover:text-[#00c99f]">Cancel</button>
                <button onclick="saveMediaAutoDownload()" class="hover:text-[#00c99f]">OK</button>
            </div>
        </div>
    </div>

</div>
