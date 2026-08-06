<div id="network_usage_panel" class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden relative">
    
    <!-- Header -->
    <div class="h-[60px] bg-[#202c33] px-6 flex items-center shrink-0 border-b border-[#313d45]">
        <button onclick="toggleNetworkUsage()" class="text-[#aebac1] hover:text-white transition-colors mr-6">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-normal">Network usage</h2>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 min-h-0 overflow-y-auto custom-scrollbar">
        <!-- Overall Usage -->
        <div class="px-6 py-5 border-b border-[#222d34]">
            <div class="text-[#8696a0] text-[14px] font-medium mb-0">Usage</div>
            <div id="network_usage_since" class="text-[#8696a0] text-[13px] mb-2 hidden">Since 05/08/26</div>
            <div class="flex items-baseline mb-6">
                <span id="network_usage_total_val" class="text-[#e9edef] text-[32px] font-normal tracking-tight">861.7</span>
                <span id="network_usage_total_unit" class="text-[#8696a0] text-[18px] ml-2">MB</span>
            </div>
            
            <div class="flex">
                <div class="flex-1">
                    <div class="text-[#8696a0] text-[13px] flex items-center gap-1 mb-1">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor" class="opacity-70"><path d="M12 4l-7 7h4v9h6v-9h4l-7-7z"></path></svg>
                        Sent
                    </div>
                    <div id="network_usage_sent_val" class="text-[#e9edef] text-[15px]">361.0 MB</div>
                </div>
                <div class="flex-1">
                    <div class="text-[#8696a0] text-[13px] flex items-center gap-1 mb-1">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor" class="opacity-70"><path d="M12 20l7-7h-4V4h-6v9H5l7 7z"></path></svg>
                        Received
                    </div>
                    <div id="network_usage_received_val" class="text-[#e9edef] text-[15px]">500.7 MB</div>
                </div>
            </div>
        </div>

        <!-- Breakdown List Container -->
        <div id="network_usage_list_container" class="flex flex-col">
            <!-- Items injected by JS -->
        </div>

        <!-- Reset Statistics -->
        <div class="px-6 py-6 cursor-pointer hover:bg-[#202c33] transition-colors mt-2" onclick="window.resetNetworkStats()">
            <div class="text-[#e9edef] text-[16px] mb-1">Reset statistics</div>
            <div id="network_usage_reset_time" class="text-[#8696a0] text-[14px]">Last reset time: Never</div>
        </div>
        
    </div>
    <!-- Reset Confirmation Modal -->
    <div id="reset_network_stats_modal" class="hidden absolute inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="bg-[#3b4a54] w-[300px] rounded-md shadow-2xl p-6 relative">
            <div class="text-[#e9edef] text-[15px] mb-8">Reset network usage statistics?</div>
            <div class="flex justify-end gap-6 text-[#00a884] font-medium text-[14px]">
                <button onclick="closeResetNetworkStatsModal()" class="hover:bg-white/5 px-2 py-1 rounded transition-colors">Cancel</button>
                <button onclick="confirmResetNetworkStats()" class="hover:bg-white/5 px-2 py-1 rounded transition-colors">Reset</button>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        
        const defaultNetworkStats = [
            {
                id: 'calls',
                title: 'Calls',
                icon: '<path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .948.684l1.498 4.493a1 1 0 0 1-.502 1.21l-2.257 1.13a11.042 11.042 0 0 0 5.516 5.516l1.13-2.257a1 1 0 0 1 1.21-.502l4.493 1.498a1 1 0 0 1 .684.949V19a2 2 0 0 1-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>',
                sentBytes: 231.0 * 1024 * 1024,
                receivedBytes: 318.4 * 1024 * 1024,
                outgoingCount: 2,
                incomingCount: 6,
                hasSubtitle: true
            },
            {
                id: 'media',
                title: 'Media',
                icon: '<rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline>',
                sentBytes: 123.7 * 1024 * 1024,
                receivedBytes: 24.5 * 1024 * 1024,
                hasSubtitle: false
            },
            {
                id: 'google_storage',
                title: 'Google storage',
                icon: '<path stroke-linecap="round" stroke-linejoin="round" d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"></path>',
                sentBytes: 0,
                receivedBytes: 0,
                hasSubtitle: false
            },
            {
                id: 'messages',
                title: 'Messages',
                icon: '<path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path><line x1="9" y1="10" x2="15" y2="10"></line><line x1="9" y1="14" x2="15" y2="14"></line>',
                sentBytes: 6.3 * 1024 * 1024,
                receivedBytes: 22.1 * 1024 * 1024,
                sentCount: 311,
                receivedCount: 741,
                hasSubtitle: true
            },
            {
                id: 'status',
                title: 'Status',
                icon: '<path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm4-8a4 4 0 1 1-4-4 4 4 0 0 1 4 4z"></path>',
                sentBytes: 0,
                receivedBytes: 135.6 * 1024 * 1024,
                sentCount: 0,
                receivedCount: 1481,
                hasSubtitle: true
            },
            {
                id: 'roaming',
                title: 'Roaming',
                icon: '<circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>',
                sentBytes: 0,
                receivedBytes: 0,
                hasSubtitle: false
            }
        ];

        window.loadNetworkStats = function() {
            const stored = localStorage.getItem('whatsapp_network_stats');
            if (stored) {
                window.mockNetworkStats = JSON.parse(stored);
            } else {
                window.mockNetworkStats = JSON.parse(JSON.stringify(defaultNetworkStats));
            }
            
            const lastReset = localStorage.getItem('whatsapp_network_reset_time');
            const lastResetShort = localStorage.getItem('whatsapp_network_reset_time_short');
            
            if (lastReset) {
                document.getElementById('network_usage_reset_time').innerText = 'Last reset time: ' + lastReset;
                if (lastResetShort) {
                    const sinceEl = document.getElementById('network_usage_since');
                    sinceEl.innerText = 'Since ' + lastResetShort;
                    sinceEl.classList.remove('hidden');
                }
            } else {
                document.getElementById('network_usage_reset_time').innerText = 'Last reset time: Never';
                document.getElementById('network_usage_since').classList.add('hidden');
            }
        };

        window.saveNetworkStats = function() {
            localStorage.setItem('whatsapp_network_stats', JSON.stringify(window.mockNetworkStats));
        };

        window.resetNetworkStats = function() {
            document.getElementById('reset_network_stats_modal').classList.remove('hidden');
        };

        window.closeResetNetworkStatsModal = function() {
            document.getElementById('reset_network_stats_modal').classList.add('hidden');
        };

        window.confirmResetNetworkStats = function() {
            window.closeResetNetworkStatsModal();
            // Reset everything to 0
            window.mockNetworkStats = JSON.parse(JSON.stringify(defaultNetworkStats));
            window.mockNetworkStats.forEach(item => {
                item.sentBytes = 0;
                item.receivedBytes = 0;
                if (item.outgoingCount !== undefined) item.outgoingCount = 0;
                if (item.incomingCount !== undefined) item.incomingCount = 0;
                if (item.sentCount !== undefined) item.sentCount = 0;
                if (item.receivedCount !== undefined) item.receivedCount = 0;
            });
            
            const now = new Date();
            const timeStr = now.toLocaleDateString('en-GB') + ', ' + now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            const shortStr = now.toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit', year: '2-digit' });
            
            localStorage.setItem('whatsapp_network_reset_time', timeStr);
            localStorage.setItem('whatsapp_network_reset_time_short', shortStr);
            
            document.getElementById('network_usage_reset_time').innerText = 'Last reset time: ' + timeStr;
            const sinceEl = document.getElementById('network_usage_since');
            sinceEl.innerText = 'Since ' + shortStr;
            sinceEl.classList.remove('hidden');
            
            window.saveNetworkStats();
            window.renderNetworkUsage();
        };

        window.renderNetworkUsage = function() {
            let totalSent = 0;
            let totalReceived = 0;
            
            window.mockNetworkStats.forEach(item => {
                totalSent += item.sentBytes;
                totalReceived += item.receivedBytes;
            });
            
            const overallTotal = totalSent + totalReceived;
            
            const formatSize = bytes => {
                if (bytes === 0) return '0 kB';
                if (bytes > 1024 * 1024 * 1024) return (bytes / (1024 * 1024 * 1024)).toFixed(1) + ' GB';
                if (bytes > 1024 * 1024) return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
                return (bytes / 1024).toFixed(1) + ' kB';
            };

            const formatNumber = num => num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            // Update Header Totals
            const totalParts = formatSize(overallTotal).split(' ');
            document.getElementById('network_usage_total_val').innerText = totalParts[0];
            document.getElementById('network_usage_total_unit').innerText = totalParts[1];
            
            document.getElementById('network_usage_sent_val').innerText = formatSize(totalSent);
            document.getElementById('network_usage_received_val').innerText = formatSize(totalReceived);
            
            // Update Storage menu subtitle
            const menuSubtitle = document.getElementById('main_network_usage_text');
            if (menuSubtitle) {
                menuSubtitle.innerHTML = `${formatSize(totalSent)} sent &bull; ${formatSize(totalReceived)} received`;
            }
            
            const listContainer = document.getElementById('network_usage_list_container');
            let listHtml = '';
            
            window.mockNetworkStats.forEach(item => {
                const itemTotal = item.sentBytes + item.receivedBytes;
                let pct = overallTotal > 0 ? (itemTotal / overallTotal) * 100 : 0;
                
                let subtitleStr = '';
                if (item.hasSubtitle) {
                    if (item.id === 'calls') {
                        subtitleStr = `${formatNumber(item.outgoingCount)} outgoing &bull; ${formatNumber(item.incomingCount)} incoming`;
                    } else if (item.id === 'messages' || item.id === 'status') {
                        subtitleStr = `${formatNumber(item.sentCount)} sent &bull; ${formatNumber(item.receivedCount)} received`;
                    }
                }
                
                listHtml += `
                <div class="flex px-6 py-4 border-b border-[#222d34]">
                    <div class="w-10 shrink-0 text-[#8696a0] mt-0.5">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5">
                            ${item.icon}
                        </svg>
                    </div>
                    <div class="flex-1 flex flex-col">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-[#e9edef] text-[16px]">${item.title}</span>
                            <div class="text-[#8696a0] text-[13px] flex items-center gap-2">
                                <span class="flex items-center gap-1"><svg viewBox="0 0 24 24" width="10" height="10" fill="currentColor"><path d="M12 4l-7 7h4v9h6v-9h4l-7-7z"></path></svg>${formatSize(item.sentBytes)}</span>
                                <span class="flex items-center gap-1"><svg viewBox="0 0 24 24" width="10" height="10" fill="currentColor"><path d="M12 20l7-7h-4V4h-6v9H5l7 7z"></path></svg>${formatSize(item.receivedBytes)}</span>
                            </div>
                        </div>
                        <div class="w-full h-[3px] bg-[#202c33] rounded-full overflow-hidden ${item.hasSubtitle ? 'mb-1' : ''} relative">
                            <div class="absolute top-0 left-0 h-full bg-[#00a884] rounded-full" style="width: ${pct}%"></div>
                        </div>
                        ${item.hasSubtitle ? `<span class="text-[#8696a0] text-[13px]">${subtitleStr}</span>` : ''}
                    </div>
                </div>`;
            });
            
            listContainer.innerHTML = listHtml;
        };

        // Initialize
        window.loadNetworkStats();
        window.renderNetworkUsage();

        // Simulate real-time live network traffic background process
        setInterval(() => {
            let changed = false;
            
            window.mockNetworkStats.forEach(item => {
                // Only change frequently used items to make it realistic
                if (['media', 'messages', 'calls'].includes(item.id)) {
                    // Random 20% chance to simulate receiving/sending a message or byte chunk per tick
                    if (Math.random() < 0.2) {
                        const randomBytes = Math.floor(Math.random() * (500 * 1024)); // up to 500 KB per tick
                        if (Math.random() > 0.5) {
                            item.sentBytes += randomBytes;
                            if (item.sentCount !== undefined) item.sentCount++;
                            if (item.outgoingCount !== undefined) item.outgoingCount++;
                        } else {
                            item.receivedBytes += randomBytes;
                            if (item.receivedCount !== undefined) item.receivedCount++;
                            if (item.incomingCount !== undefined) item.incomingCount++;
                        }
                        changed = true;
                    }
                }
            });

            if (changed) {
                window.saveNetworkStats();
                window.renderNetworkUsage();
            }
        }, 5000); // Check every 5 seconds
    });
</script>
