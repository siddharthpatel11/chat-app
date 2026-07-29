<!-- Load jsQR Library -->
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>

<div id="transfer_chat_history_panel"
    class="hidden flex-col w-full sm:w-[30%] sm:min-w-[350px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden absolute top-0 left-0 sm:static z-30">


    <!-- SCREEN 1: Intro -->
    <div id="transfer_start_screen" class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21] flex flex-col justify-between pb-6">
        
        <!-- Header 1 -->
        <div class="h-16 px-4 flex items-center justify-between shrink-0">
            <button onclick="window.closeTransferChatHistoryPanel()" class="text-[#e9edef] hover:bg-[#202c33] p-2 rounded-full transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path></svg>
            </button>
            <div class="relative inline-block">
                <button onclick="window.toggleTransferChatHistoryMenu(event)" class="text-[#e9edef] hover:bg-[#202c33] p-2 rounded-full transition-colors">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M12 7a2 2 0 1 0-.001-4.001A2 2 0 0 0 12 7zm0 2a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 9zm0 6a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 15z"></path></svg>
                </button>
                <div id="transfer_chat_history_menu" class="hidden absolute top-full right-0 mt-1 w-44 bg-[#233138] rounded-md shadow-lg py-2 z-50 transform origin-top-right transition-transform">
                    <button class="w-full text-left px-5 py-3 text-[#e9edef] text-[15px] hover:bg-[#182229] transition-colors">Help</button>
                    <button class="w-full text-left px-5 py-3 text-[#e9edef] text-[15px] hover:bg-[#182229] transition-colors">Restart</button>
                </div>
            </div>
        </div>

        <div>
            <!-- Graphic -->
            <div class="flex items-center justify-center pt-8 pb-10">
                <svg viewBox="0 0 160 120" class="w-full max-w-[200px] h-auto">
                    <!-- Left Phone (Old) -->
                    <path fill="#f4ecd8" stroke="#a0e0b3" stroke-width="0" d="M30,30 h35 v55 a5,5 0 0 1 -5,5 h-25 a5,5 0 0 1 -5,-5 z" />
                    <!-- stroke elements to be exact -->
                    <path fill="#f4ecd8" stroke="#111b21" stroke-width="3" stroke-linejoin="round" d="M30,35 h25 v50 a5,5 0 0 1 -5,5 h-15 a5,5 0 0 1 -5,-5 z" />
                    
                    <!-- Antenna -->
                    <path fill="none" stroke="#111b21" stroke-width="3" d="M30,35 l 10,-15 h2 M32,18 h8" />
                    
                    <!-- Left screen/keypad -->
                    <rect x="35" y="55" width="15" height="20" rx="2" fill="none" stroke="#111b21" stroke-width="2.5" />
                    <!-- Keypad grid -->
                    <path fill="none" stroke="#111b21" stroke-width="2" d="M40,55 v20 M45,55 v20 M35,61.6 h15 M35,68.2 h15" />
                    <path fill="none" stroke="#111b21" stroke-width="2.5" stroke-linecap="round" d="M38,82 h9" />

                    <!-- Right Phone (New) -->
                    <rect x="100" y="25" width="45" height="65" rx="8" fill="#a0e0b3" stroke="#111b21" stroke-width="3" stroke-linejoin="round" />
                    <rect x="106" y="32" width="33" height="48" rx="2" fill="#81c784" stroke="#a0e0b3" stroke-width="1" />
                    <path fill="none" stroke="#111b21" stroke-width="2.5" stroke-linecap="round" d="M115,30 h15" />
                    <circle cx="122.5" cy="84" r="2.5" fill="#111b21" />
                    
                    <!-- Paper Receipt -->
                    <path fill="#f4ecd8" stroke="#111b21" stroke-width="3" stroke-linejoin="round" stroke-linecap="round" d="M45,25 h30 v38 c0,15 15,15 15,5 v-15 h20 v20 c0,18 -35,18 -35,0 v-48 h-30 z" />
                    
                    <!-- Receipt Lines -->
                    <path fill="none" stroke="#111b21" stroke-width="3" stroke-linecap="round" d="M52,35 h16 M52,43 h16 M52,51 h16 M52,59 h16 M82,53 h16 M82,61 h16" />
                </svg>
            </div>

            <!-- Text Content -->
            <div class="px-8 text-center">
                <h1 class="text-[#e9edef] text-[22px] font-normal mb-4">Transfer chat history</h1>
                <p class="text-[#8696a0] text-[15px] leading-relaxed">
                    Transfer your chat history privately and have your most up-to-date messages. Certain device permissions are needed to connect to your new device.
                </p>
            </div>
        </div>

        <!-- Buttons -->
        <div class="px-6 flex flex-col items-center gap-4 mt-10">
            <button onclick="window.startTransferChatScan()" class="w-full bg-[#25d366] hover:bg-[#20bd5a] text-[#111b21] font-medium text-[15px] py-[10px] rounded-full transition-colors">
                Start
            </button>
            <button class="w-full bg-transparent hover:bg-[#202c33] text-[#25d366] font-medium text-[15px] py-[10px] rounded-full transition-colors" onclick="window.closeTransferChatHistoryPanel()">
                Cancel
            </button>
        </div>
    </div>

    <!-- SCREEN 2: Progress Screen -->
    <div id="transfer_progress_screen" class="hidden flex-1 overflow-y-auto bg-[#111b21] flex flex-col justify-between pb-6 custom-scrollbar">
        <!-- Header 2 -->
        <div class="h-16 px-4 flex items-center justify-between shrink-0">
            <button onclick="window.closeTransferChatHistoryPanel()" class="text-[#e9edef] hover:bg-[#202c33] p-2 rounded-full transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path></svg>
            </button>
            <div class="relative inline-block">
                <button onclick="window.toggleTransferChatHistoryMenu(event, 2)" class="text-[#e9edef] hover:bg-[#202c33] p-2 rounded-full transition-colors">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M12 7a2 2 0 1 0-.001-4.001A2 2 0 0 0 12 7zm0 2a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 9zm0 6a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 15z"></path></svg>
                </button>
                <div id="transfer_chat_history_menu_2" class="hidden absolute top-full right-0 mt-1 w-44 bg-[#233138] rounded-md shadow-lg py-2 z-50 transform origin-top-right transition-transform">
                    <button class="w-full text-left px-5 py-3 text-[#e9edef] text-[15px] hover:bg-[#182229] transition-colors">Help</button>
                    <button class="w-full text-left px-5 py-3 text-[#e9edef] text-[15px] hover:bg-[#182229] transition-colors">Restart</button>
                </div>
            </div>
        </div>

        <div class="flex flex-col items-center flex-1 px-8">
            <!-- Graphic -->
            <div class="flex items-center justify-center mb-6">
                <svg viewBox="0 0 160 120" class="w-full max-w-[150px] h-auto">
                    <!-- Left Phone (Old) -->
                    <path fill="#f4ecd8" stroke="#a0e0b3" stroke-width="0" d="M30,30 h35 v55 a5,5 0 0 1 -5,5 h-25 a5,5 0 0 1 -5,-5 z" />
                    <!-- stroke elements to be exact -->
                    <path fill="#f4ecd8" stroke="#111b21" stroke-width="3" stroke-linejoin="round" d="M30,35 h25 v50 a5,5 0 0 1 -5,5 h-15 a5,5 0 0 1 -5,-5 z" />
                    <!-- Antenna -->
                    <path fill="none" stroke="#111b21" stroke-width="3" d="M30,35 l 10,-15 h2 M32,18 h8" />
                    <!-- Left screen/keypad -->
                    <rect x="35" y="55" width="15" height="20" rx="2" fill="none" stroke="#111b21" stroke-width="2.5" />
                    <path fill="none" stroke="#111b21" stroke-width="2" d="M40,55 v20 M45,55 v20 M35,61.6 h15 M35,68.2 h15" />
                    <path fill="none" stroke="#111b21" stroke-width="2.5" stroke-linecap="round" d="M38,82 h9" />
                    <!-- Right Phone (New) -->
                    <rect x="100" y="25" width="45" height="65" rx="8" fill="#a0e0b3" stroke="#111b21" stroke-width="3" stroke-linejoin="round" />
                    <rect x="106" y="32" width="33" height="48" rx="2" fill="#81c784" stroke="#a0e0b3" stroke-width="1" />
                    <path fill="none" stroke="#111b21" stroke-width="2.5" stroke-linecap="round" d="M115,30 h15" />
                    <circle cx="122.5" cy="84" r="2.5" fill="#111b21" />
                    <!-- Paper Receipt -->
                    <path fill="#f4ecd8" stroke="#111b21" stroke-width="3" stroke-linejoin="round" stroke-linecap="round" d="M45,25 h30 v38 c0,15 15,15 15,5 v-15 h20 v20 c0,18 -35,18 -35,0 v-48 h-30 z" />
                    <!-- Receipt Lines -->
                    <path fill="none" stroke="#111b21" stroke-width="3" stroke-linecap="round" d="M52,35 h16 M52,43 h16 M52,51 h16 M52,59 h16 M82,53 h16 M82,61 h16" />
                </svg>
            </div>

            <h2 class="text-[#e9edef] text-[22px] font-normal mb-8 text-center">Transfer chat history</h2>
            
            <div class="w-full flex flex-col gap-6 max-w-sm">
                <!-- Step 1 -->
                <div class="flex items-start gap-4">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="#8696a0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-1 shrink-0"><path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/></svg>
                    <div>
                        <div class="text-[#e9edef] text-[16px] font-normal">Preparing chats</div>
                        <div class="text-[#8696a0] text-[14px]">This can take a few minutes</div>
                    </div>
                </div>
                <!-- Step 2 -->
                <div class="flex items-center gap-4">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="#8696a0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    <div class="text-[#8696a0] text-[16px]">Connecting phones</div>
                </div>
                <!-- Step 3 -->
                <div class="flex items-center gap-4">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="#8696a0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                    <div class="text-[#8696a0] text-[16px]">Transferring chats</div>
                </div>
            </div>
        </div>

        <!-- Progress Footer -->
        <div class="w-full px-8 pb-4 flex flex-col items-center">
            <div id="transfer_progress_text" class="text-[#8696a0] text-[14px] mb-4">Preparing: 1%</div>
            <div class="w-full h-[2px] bg-[#202c33] rounded-full mb-8 relative overflow-hidden">
                <div id="transfer_progress_bar" class="absolute left-0 top-0 h-full bg-[#00a884] transition-all duration-300 ease-out" style="width: 1%"></div>
            </div>
            <button class="text-[#00a884] font-medium text-[15px] hover:bg-[#202c33] px-4 py-2 rounded-full transition-colors" onclick="window.closeTransferChatHistoryPanel()">
                Cancel
            </button>
        </div>
    </div>

    <!-- SCREEN 3: Verify Screen -->
    <div id="transfer_verify_screen" class="hidden flex-1 overflow-y-auto bg-[#111b21] flex flex-col custom-scrollbar pb-6 relative">
        <!-- Header -->
        <div class="h-16 px-4 flex items-center shrink-0 border-b border-transparent">
            <button onclick="window.closeTransferChatHistoryPanel()" class="text-[#e9edef] hover:bg-[#202c33] p-2 rounded-full transition-colors flex items-center gap-6">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
                <span class="text-[20px] font-medium text-[#e9edef]">Verify your number</span>
            </button>
        </div>

        <div class="flex-1 flex flex-col px-6 pt-6 relative pb-[80px]">
            <p class="text-[#e9edef] text-[16px] leading-relaxed mb-2">
                1. Download WhatsApp on your new Android and register with the same number.
            </p>
            <p class="text-[#e9edef] text-[16px] leading-relaxed mb-6">
                2. When prompted, enter this code:
            </p>
            
            <!-- Verification Code Box -->
            <div class="bg-[#182229] rounded-xl py-8 px-4 flex justify-center items-center">
                <!-- Using letter-spacing to space out digits like WhatsApp -->
                <span id="transfer_verify_code" class="text-white text-[32px] font-semibold tracking-[0.4em] font-sans ml-[0.4em]">306-779</span>
            </div>
        </div>

        <!-- Fixed bottom button -->
        <div class="absolute bottom-6 left-6 right-6">
            <button class="w-full bg-[#00a884] hover:bg-[#008f6f] text-[#111b21] font-medium text-[15px] py-[10px] rounded-full transition-colors" onclick="window.startScannerScreen()">
                Continue
            </button>
        </div>
    </div>

    <!-- SCREEN 4: QR Scanner Display -->
    <div id="transfer_scan_screen" class="hidden flex-1 overflow-hidden bg-black flex flex-col relative z-30">
        <style>
            @keyframes scan-laser {
                0% { top: 0%; opacity: 0; }
                10% { opacity: 1; }
                50% { top: 100%; opacity: 1; }
                90% { top: 0%; opacity: 1; }
                100% { top: 0%; opacity: 0; }
            }
            .laser-line {
                animation: scan-laser 3s infinite linear;
            }
        </style>
        
        <!-- Camera Feed -->
        <div class="absolute inset-0 bg-[#233138]">
            <video id="transfer_camera_feed" class="w-full h-full object-cover hidden" autoplay playsinline></video>
        </div>

        <!-- Scanner Viewport (Auto Centers) -->
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-10">
            <!-- The box-shadow trick creates the dark overlay around the transparent center -->
            <div class="relative rounded-lg overflow-hidden flex items-center justify-center pointer-events-none shrink-0" style="width: 260px; height: 260px; box-shadow: 0 0 0 9999px rgba(0,0,0,0.6);">
                <!-- Corner brackets -->
                <div class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-[#25d366] rounded-tl-lg" style="border-color: #25d366;"></div>
                <div class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-[#25d366] rounded-tr-lg" style="border-color: #25d366;"></div>
                <div class="absolute bottom-0 left-0 w-8 h-8 border-b-4 border-l-4 border-[#25d366] rounded-bl-lg" style="border-color: #25d366;"></div>
                <div class="absolute bottom-0 right-0 w-8 h-8 border-b-4 border-r-4 border-[#25d366] rounded-br-lg" style="border-color: #25d366;"></div>
                
                <!-- Animated Laser Line -->
                <div class="absolute left-0 right-0 h-1 laser-line z-20" style="background-color: #25d366; box-shadow: 0 0 8px #25d366;"></div>
            </div>
        </div>

        <!-- Header -->
        <div class="absolute top-0 left-0 right-0 p-4 w-full flex-none pointer-events-auto z-20">
            <button onclick="window.closeTransferChatHistoryPanel()" class="text-[#e9edef] hover:bg-white/10 p-2 rounded-full transition-colors inline-flex items-center gap-6 relative z-50">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
                <span class="text-[19px] font-medium text-[#e9edef]">Scan QR code</span>
            </button>
        </div>

        <!-- Bottom Text -->
        <div class="absolute bottom-0 left-0 right-0 p-8 pb-12 w-full flex-none pointer-events-auto flex flex-col items-center z-20">
            <p class="text-[#e9edef] text-[15px] text-center leading-relaxed max-w-sm mx-auto mb-6">
                Open WhatsApp on your new phone. Register with the same phone number. Use this phone to scan the QR code shown on your new phone.
            </p>
            <div class="flex flex-col items-center gap-4">
                <button onclick="window.showTransferQRCode()" class="text-[#00a884] font-medium text-[15px] hover:underline bg-transparent">
                    Need to show a QR code instead?
                </button>
                <button onclick="window.simulateSuccessfulScan()" class="text-[#8696a0] font-normal text-[13px] hover:underline bg-transparent opacity-70">
                    Skip Scan (Demo)
                </button>
            </div>
        </div>
    </div>

    <!-- SCREEN 5: QR Code Display Screen (For the other device) -->
    <div id="transfer_qr_display_screen" class="hidden flex-1 overflow-y-auto bg-[#111b21] flex flex-col custom-scrollbar">
        <!-- Header -->
        <div class="h-16 px-4 flex items-center shrink-0 border-b border-transparent">
            <button onclick="window.closeTransferChatHistoryPanel()" class="text-[#e9edef] hover:bg-[#202c33] p-2 rounded-full transition-colors flex items-center gap-6">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
                <span class="text-[20px] font-medium text-[#e9edef]">Scan this QR Code</span>
            </button>
        </div>

        <div class="flex-1 flex flex-col items-center pt-10 px-8">
            <h2 class="text-[#e9edef] text-[22px] font-normal mb-8 text-center">Your QR Code</h2>
            
            <div class="bg-white p-4 rounded-xl shadow-lg mb-8">
                <img id="transfer_qr_image" src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=whatsapp_transfer_demo_123&margin=0" width="220" height="220" alt="QR Code">
            </div>
            
            <p class="text-[#8696a0] text-[15px] text-center leading-relaxed max-w-[280px]">
                Scan this QR code with your other phone to transfer your chat history.
            </p>
        </div>
        
        <div class="px-6 py-6 w-full mt-auto">
            <button onclick="window.startScannerScreen()" class="w-full border border-[#313d45] text-[#e9edef] hover:bg-[#202c33] font-medium text-[15px] py-[10px] rounded-full transition-colors">
                Go back to Scanner
            </button>
        </div>
    </div>

    <!-- SCREEN 5.5: Auth / Confirmation Screen -->
    <div id="transfer_auth_screen" class="hidden flex-1 overflow-y-auto bg-[#111b21] flex flex-col justify-between pb-6 custom-scrollbar px-8">
        <div class="flex-1 flex flex-col items-center justify-center pt-8">
            <!-- Auth Icon -->
            <div class="w-24 h-24 bg-[#202c33] rounded-full flex items-center justify-center mb-8 border-4 border-[#00a884]">
                <svg viewBox="0 0 24 24" width="48" height="48" fill="#00a884">
                    <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/>
                </svg>
            </div>
            <h2 class="text-[#e9edef] text-[24px] font-normal mb-4 text-center">Device Found</h2>
            <p class="text-[#8696a0] text-[15px] text-center leading-relaxed max-w-[280px]">
                We found a device trying to connect. Do you want to authorize this transfer?
            </p>
        </div>
        
        <div class="w-full pt-8 flex flex-col gap-3">
            <button onclick="window.startTransferSync()" class="w-full bg-[#00a884] hover:bg-[#008f6f] text-[#111b21] font-medium text-[15px] py-[10px] rounded-full transition-colors shadow-lg">
                Accept and Continue
            </button>
            <button onclick="window.closeTransferChatHistoryPanel()" class="w-full bg-transparent hover:bg-white/5 text-[#8696a0] font-medium text-[15px] py-[10px] rounded-full transition-colors border border-gray-600/30">
                Cancel
            </button>
        </div>
    </div>

    <!-- SCREEN 6: Transferring Data -->
    <div id="transfer_sync_screen" class="hidden flex-1 overflow-y-auto bg-[#111b21] flex flex-col justify-center items-center pb-6 custom-scrollbar px-8">
        <div class="w-full max-w-sm flex flex-col items-center">
            <!-- Icon -->
            <div class="w-24 h-24 bg-[#25d366] rounded-full flex items-center justify-center mb-8 relative">
                <svg viewBox="0 0 24 24" width="48" height="48" fill="white" class="animate-bounce">
                    <path d="M12 2L12 16M12 16L8 12M12 16L16 12M4 20L20 20" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h2 class="text-[#e9edef] text-[24px] font-normal mb-4 text-center">Transferring chats...</h2>
            <p class="text-[#8696a0] text-[15px] text-center leading-relaxed mb-8">
                Keep the app open and the phone nearby. This may take a few moments.
            </p>
            <!-- Progress Bar -->
            <div class="w-full bg-[#202c33] rounded-full h-1.5 mb-3 overflow-hidden">
                <div id="transfer_sync_progress" class="bg-[#00a884] h-1.5 rounded-full transition-all duration-300" style="width: 0%"></div>
            </div>
            <p id="transfer_sync_text" class="text-[#8696a0] text-[14px]">0%</p>
        </div>
    </div>

    <!-- SCREEN 7: Transfer Complete -->
    <div id="transfer_complete_screen" class="hidden flex-1 overflow-y-auto bg-[#111b21] flex flex-col justify-between pb-6 custom-scrollbar px-8">
        <div class="flex-1 flex flex-col items-center justify-center pt-8">
            <!-- Check Icon -->
            <div class="w-24 h-24 bg-[#25d366] rounded-full flex items-center justify-center mb-8">
                <svg viewBox="0 0 24 24" width="48" height="48" fill="white">
                    <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/>
                </svg>
            </div>
            <h2 class="text-[#e9edef] text-[24px] font-normal mb-4 text-center">Transfer complete</h2>
            <p class="text-[#8696a0] text-[15px] text-center leading-relaxed max-w-[280px]">
                Your chat history has been successfully transferred to this device.
            </p>
        </div>
        
        <div class="w-full pt-8">
            <button onclick="window.finishChatTransfer()" class="w-full bg-[#00a884] hover:bg-[#008f6f] text-[#111b21] font-medium text-[15px] py-[10px] rounded-full transition-colors">
                Done
            </button>
        </div>
    </div>

</div>

<script>
    let transferCameraStream = null;
    let qrScanAnimation = null;

    function startQRScannerLoop() {
        const video = document.getElementById('transfer_camera_feed');
        if (!video || video.classList.contains('hidden')) return;

        let canvas = document.getElementById('qr_scan_canvas');
        if (!canvas) {
            canvas = document.createElement('canvas');
            canvas.id = 'qr_scan_canvas';
            canvas.style.display = 'none';
            document.body.appendChild(canvas);
        }
        
        if (video.readyState === video.HAVE_ENOUGH_DATA) {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d', { willReadFrequently: true });
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            
            if (typeof jsQR !== 'undefined') {
                const code = jsQR(imageData.data, imageData.width, imageData.height, {
                    inversionAttempts: "dontInvert",
                });
                if (code && code.data && code.data.startsWith('whatsapp_transfer_')) {
                    // QR Code detected!
                    window.scannedTransferSessionId = code.data;
                    
                    // Signal laptop via Firebase
                    if (window.db && window.update && window.ref) {
                        window.update(window.ref(window.db, `transfer_sessions/${window.scannedTransferSessionId}`), {
                            status: 'authorized'
                        });
                    }

                    window.showTransferAuth();
                    return; 
                }
            }
        }
        qrScanAnimation = requestAnimationFrame(startQRScannerLoop);
    }

    window.simulateSuccessfulScan = function() {
        if (qrScanAnimation) {
            cancelAnimationFrame(qrScanAnimation);
            qrScanAnimation = null;
        }
        // Simulate finding the current user's session
        window.scannedTransferSessionId = 'whatsapp_transfer_' + (window.myUserId || 'demo');
        if (window.db && window.update && window.ref) {
            window.update(window.ref(window.db, `transfer_sessions/${window.scannedTransferSessionId}`), {
                status: 'authorized'
            });
        }
        window.showTransferAuth();
    };

    function stopTransferCamera() {
        if (qrScanAnimation) {
            cancelAnimationFrame(qrScanAnimation);
            qrScanAnimation = null;
        }
        if (transferCameraStream) {
            transferCameraStream.getTracks().forEach(track => track.stop());
            transferCameraStream = null;
        }
        const video = document.getElementById('transfer_camera_feed');
        if (video) {
            video.classList.add('hidden');
            video.srcObject = null;
        }
    }

    window.toggleTransferChatHistoryPanel = function() {
        const chatsPanel = document.getElementById('chats_settings_panel');
        const transferPanel = document.getElementById('transfer_chat_history_panel');

        if (transferPanel) {
            chatsPanel.classList.add('hidden');
            chatsPanel.classList.remove('flex');
            
            transferPanel.classList.remove('hidden');
            transferPanel.classList.add('flex');
        }
    };

    let transferInterval = null;

    window.startTransferChatScan = function() {
        const startScreen = document.getElementById('transfer_start_screen');
        const progressScreen = document.getElementById('transfer_progress_screen');
        const verifyScreen = document.getElementById('transfer_verify_screen');
        const progressBar = document.getElementById('transfer_progress_bar');
        const progressText = document.getElementById('transfer_progress_text');
        const codeElement = document.getElementById('transfer_verify_code');
        
        if (startScreen && progressScreen) {
            startScreen.classList.add('hidden');
            startScreen.classList.remove('flex');
            
            progressScreen.classList.remove('hidden');
            progressScreen.classList.add('flex');

            // Reset progress
            let progress = 1;
            progressBar.style.width = '1%';
            progressText.innerText = 'Preparing: 1%';
            
            if (transferInterval) clearInterval(transferInterval);
            
            // Generate Random Code format (XXX-XXX)
            const randomCode = Math.floor(100 + Math.random() * 900) + "-" + Math.floor(100 + Math.random() * 900);
            codeElement.innerText = randomCode;

            // Animate progress to 100% in ~4 seconds
            transferInterval = setInterval(() => {
                progress += Math.floor(Math.random() * 3) + 1; // Increase by 1-3%
                if (progress >= 100) {
                    progress = 100;
                    clearInterval(transferInterval);
                    
                    // Transition to verify screen
                    setTimeout(() => {
                        progressScreen.classList.add('hidden');
                        progressScreen.classList.remove('flex');
                        verifyScreen.classList.remove('hidden');
                        verifyScreen.classList.add('flex');
                    }, 500);
                }
                
                progressBar.style.width = progress + '%';
                
                if (progress < 50) {
                    progressText.innerText = 'Preparing: ' + progress + '%';
                } else if (progress < 80) {
                    progressText.innerText = 'Connecting phones: ' + progress + '%';
                } else {
                    progressText.innerText = 'Transferring chats: ' + progress + '%';
                }
            }, 100); // run every 100ms
        }
    };

    window.startScannerScreen = function() {
        const verifyScreen = document.getElementById('transfer_verify_screen');
        const scanScreen = document.getElementById('transfer_scan_screen');
        const qrScreen = document.getElementById('transfer_qr_display_screen');
        
        if (verifyScreen && scanScreen && qrScreen) {
            verifyScreen.classList.add('hidden');
            verifyScreen.classList.remove('flex');
            
            qrScreen.classList.add('hidden');
            qrScreen.classList.remove('flex');
            
            scanScreen.classList.remove('hidden');
            scanScreen.classList.add('flex');

            // Start Camera
            const video = document.getElementById('transfer_camera_feed');
            if (video && navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
                    .then(function(stream) {
                        transferCameraStream = stream;
                        video.srcObject = stream;
                        video.classList.remove('hidden');
                        
                        // Wait for video to start playing before scanning
                        video.onloadedmetadata = () => {
                            video.play();
                            requestAnimationFrame(startQRScannerLoop);
                        };
                    })
                    .catch(function(error) {
                        console.error("Camera access denied or unavailable: ", error);
                    });
            }
        }
    };

    window.showTransferAuth = function() {
        stopTransferCamera();
        const scanScreen = document.getElementById('transfer_scan_screen');
        const authScreen = document.getElementById('transfer_auth_screen');
        
        if (scanScreen && authScreen) {
            scanScreen.classList.add('hidden');
            scanScreen.classList.remove('flex');
            
            authScreen.classList.remove('hidden');
            authScreen.classList.add('flex');
        }
    };

    window.startTransferSync = function(isFollower = false) {
        stopTransferCamera();
        const scanScreen = document.getElementById('transfer_scan_screen');
        const authScreen = document.getElementById('transfer_auth_screen');
        const syncScreen = document.getElementById('transfer_sync_screen');
        const qrScreen = document.getElementById('transfer_qr_display_screen');
        
        if (scanScreen) {
            scanScreen.classList.add('hidden');
            scanScreen.classList.remove('flex');
        }
        if (qrScreen) {
            qrScreen.classList.add('hidden');
            qrScreen.classList.remove('flex');
        }
        if (authScreen) {
            authScreen.classList.add('hidden');
            authScreen.classList.remove('flex');
        }
        
        if (syncScreen) {
            syncScreen.classList.remove('hidden');
            syncScreen.classList.add('flex');
            
            // Animate progress
            const progressBar = document.getElementById('transfer_sync_progress');
            const progressText = document.getElementById('transfer_sync_text');
            if (progressBar && !isFollower) progressBar.style.width = '0%';
            if (progressText && !isFollower) progressText.innerText = '0%';

            if (!isFollower && window.scannedTransferSessionId && window.db && window.update && window.ref) {
                // Phone leading the transfer
                window.update(window.ref(window.db, `transfer_sessions/${window.scannedTransferSessionId}`), {
                    status: 'transferring',
                    progress: 0
                });
            }

            if (!isFollower) {
                let progress = 0;
                const interval = setInterval(() => {
                    progress += Math.floor(Math.random() * 15) + 5;
                    if (progress >= 100) {
                        progress = 100;
                        clearInterval(interval);
                        
                        if (window.scannedTransferSessionId && window.db && window.update && window.ref) {
                            window.update(window.ref(window.db, `transfer_sessions/${window.scannedTransferSessionId}`), {
                                status: 'completed',
                                progress: 100
                            });
                        }

                        setTimeout(() => {
                            window.showTransferComplete();
                        }, 800);
                    }
                    if (progressBar) progressBar.style.width = progress + '%';
                    if (progressText) progressText.innerText = progress + '%';

                    // Sync progress to laptop
                    if (window.scannedTransferSessionId && window.db && window.update && window.ref) {
                        window.update(window.ref(window.db, `transfer_sessions/${window.scannedTransferSessionId}`), {
                            progress: progress
                        });
                    }
                }, 400);
            }
        }
    };

    window.showTransferComplete = function() {
        const syncScreen = document.getElementById('transfer_sync_screen');
        const completeScreen = document.getElementById('transfer_complete_screen');
        
        if (syncScreen && completeScreen) {
            syncScreen.classList.add('hidden');
            syncScreen.classList.remove('flex');
            
            completeScreen.classList.remove('hidden');
            completeScreen.classList.add('flex');
        }
    };

    window.currentTransferSessionId = null;
    window.transferFirebaseListener = null;

    window.showTransferQRCode = function() {
        stopTransferCamera();
        
        const scanScreen = document.getElementById('transfer_scan_screen');
        const qrScreen = document.getElementById('transfer_qr_display_screen');
        
        if (scanScreen && qrScreen) {
            scanScreen.classList.add('hidden');
            scanScreen.classList.remove('flex');
            
            qrScreen.classList.remove('hidden');
            qrScreen.classList.add('flex');
        }

        // Simulate "Empty New Phone" state on the laptop
        const userListContainer = document.getElementById('user_list_container');
        if (userListContainer) {
            if (!window.originalChatsHTML) {
                window.originalChatsHTML = userListContainer.innerHTML;
            }
            userListContainer.innerHTML = `
                <div class="flex flex-col items-center justify-center h-full text-center px-6 py-10 opacity-60">
                    <div class="w-16 h-16 bg-[#202c33] rounded-full flex items-center justify-center mb-4 text-[#8696a0]">
                        <svg viewBox="0 0 24 24" width="32" height="32" fill="currentColor">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"></path>
                        </svg>
                    </div>
                    <p class="text-[#e9edef] text-[17px] font-medium mb-2">No chats yet</p>
                    <p class="text-[#8696a0] text-[14px]">Scan the QR code to securely transfer your chat history from your old phone.</p>
                </div>
            `;
        }

        // Generate a unique session ID for the laptop
        window.currentTransferSessionId = 'whatsapp_transfer_' + (window.myUserId || Math.floor(Math.random() * 1000000));
        
        // Update the QR image
        const qrImg = document.getElementById('transfer_qr_image');
        if (qrImg) {
            qrImg.src = `https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=${window.currentTransferSessionId}&margin=0`;
        }

        // Listen for phone scanning it via Firebase Realtime Database
        if (window.db && window.set && window.ref && window.onValue) {
            window.set(window.ref(window.db, `transfer_sessions/${window.currentTransferSessionId}`), {
                status: 'waiting',
                progress: 0
            });

            if (window.transferFirebaseListener) {
                window.transferFirebaseListener(); // unsubscribe previous
            }
            
            window.transferFirebaseListener = window.onValue(window.ref(window.db, `transfer_sessions/${window.currentTransferSessionId}`), (snapshot) => {
                const data = snapshot.val();
                if (data) {
                    if (data.status === 'transferring') {
                        // Phone started transfer! Switch laptop to sync screen
                        const syncScreen = document.getElementById('transfer_sync_screen');
                        if (syncScreen && syncScreen.classList.contains('hidden')) {
                            window.startTransferSync(true); // true = follower
                        }
                        // Update progress bar to match phone
                        const progressBar = document.getElementById('transfer_sync_progress');
                        const progressText = document.getElementById('transfer_sync_text');
                        if (progressBar) progressBar.style.width = (data.progress || 0) + '%';
                        if (progressText) progressText.innerText = (data.progress || 0) + '%';
                    } else if (data.status === 'completed') {
                        // Phone finished transfer!
                        window.showTransferComplete();
                    }
                }
            });
        }
    };

    window.finishChatTransfer = function() {
        window.closeTransferChatHistoryPanel();
        
        const isSender = !!window.scannedTransferSessionId; // The one who scanned (Phone)
        const isReceiver = !!window.currentTransferSessionId; // The one who displayed QR (Laptop)

        if (isSender) {
            // Old Phone Experience
            document.body.insertAdjacentHTML('beforeend', `
                <div id="transfer_sender_complete" class="fixed inset-0 bg-[#111b21] z-[9999] flex flex-col items-center justify-center p-6 text-center animate-fade-in">
                    <div class="w-20 h-20 bg-[#00a884] rounded-full flex items-center justify-center mb-6 shadow-lg shadow-[#00a884]/20">
                        <svg viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="#111b21" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5"></path>
                        </svg>
                    </div>
                    <h1 class="text-[#e9edef] text-[24px] font-medium mb-4">Chats Transferred</h1>
                    <p class="text-[#8696a0] text-[15px] mb-10 max-w-[320px] leading-relaxed">
                        Your chat history is now available on your new device.<br><br>You will be logged out of this device shortly.
                    </p>
                    <button onclick="document.getElementById('transfer_sender_complete').remove()" class="bg-[#00a884] text-[#111b21] font-medium px-10 py-3 rounded-full hover:bg-[#008f72] transition-colors">
                        Okay, got it
                    </button>
                </div>
            `);
            // Clear the session state
            window.scannedTransferSessionId = null;

            // Make the old phone's chat list EMPTY and say "Logged out"
            const userListContainer = document.getElementById('user_list_container');
            if (userListContainer) {
                userListContainer.innerHTML = `
                    <div class="flex flex-col items-center justify-center h-full text-center px-6 py-10 opacity-80 cursor-pointer hover:opacity-100 transition-opacity" onclick="window.location.reload()">
                        <div class="w-20 h-20 bg-[#202c33] rounded-full flex items-center justify-center mb-6 text-[#00a884] shadow-lg">
                            <svg viewBox="0 0 24 24" width="36" height="36" fill="currentColor">
                                <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                            </svg>
                        </div>
                        <p class="text-[#e9edef] text-[19px] font-medium mb-3">Logged out</p>
                        <p class="text-[#8696a0] text-[15px] leading-relaxed mb-6">Your chats have been transferred to your new device.<br><br>You can no longer use WhatsApp on this phone.</p>
                        <button class="bg-[#00a884] text-[#111b21] font-medium px-6 py-2 rounded-full hover:bg-[#008f72] transition-colors" onclick="window.location.reload(true)">
                            Log In Again
                        </button>
                    </div>
                `;
            }
        } else {
            // New Phone (Receiver) Experience
            const leftPanel = document.querySelector('#user_sidebar_container') || document.getElementById('user_list_container');
            if (leftPanel) {
                const overlay = document.createElement('div');
                overlay.className = 'absolute inset-0 bg-[#111b21] z-[100] flex flex-col items-center justify-center transition-opacity duration-500';
                overlay.innerHTML = `
                    <div class="w-12 h-12 border-[3px] border-[#00a884] border-t-transparent rounded-full animate-spin mb-5"></div>
                    <span class="text-[#e9edef] text-[16px] font-medium tracking-wide">Organizing your chats...</span>
                `;
                leftPanel.appendChild(overlay);
                
                setTimeout(() => {
                    overlay.style.opacity = '0';
                    setTimeout(() => {
                        overlay.remove();
                        
                        // Show Welcome Modal
                        document.body.insertAdjacentHTML('beforeend', `
                            <div id="transfer_receiver_complete" class="fixed inset-0 bg-[#111b21]/90 backdrop-blur-sm z-[9999] flex flex-col items-center justify-center p-6 text-center animate-fade-in">
                                <div class="bg-[#202c33] p-8 rounded-2xl max-w-[400px] w-full shadow-2xl border border-white/5">
                                    <div class="w-16 h-16 mx-auto bg-[#00a884]/10 text-[#00a884] rounded-full flex items-center justify-center mb-6">
                                        <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                            <polyline points="7 10 12 15 17 10"></polyline>
                                            <line x1="12" y1="15" x2="12" y2="3"></line>
                                        </svg>
                                    </div>
                                    <h1 class="text-[#e9edef] text-[22px] font-medium mb-3">Welcome to your new device!</h1>
                                    <p class="text-[#8696a0] text-[15px] mb-8 leading-relaxed">Your chat history, media, and settings have been fully restored from your old phone.</p>
                                    <button onclick="document.getElementById('transfer_receiver_complete').remove()" class="w-full bg-[#00a884] text-[#111b21] font-medium px-4 py-3 rounded-full hover:bg-[#008f72] transition-colors">
                                        Start Messaging
                                    </button>
                                </div>
                            </div>
                        `);

                        // Inject the fake "Restored" chat into the DOM
                        const userListContainer = document.getElementById('user_list_container');
                        if (userListContainer) {
                            // First, restore the original chats!
                            if (window.originalChatsHTML) {
                                userListContainer.innerHTML = window.originalChatsHTML;
                                window.originalChatsHTML = null;
                            }

                            const restoredChatItem = document.createElement('div');
                            restoredChatItem.className = 'flex relative items-center px-3 py-3 hover:bg-[#202c33] cursor-pointer transition-all duration-500 user-chat-item group';
                            restoredChatItem.style.backgroundColor = 'rgba(0, 168, 132, 0.15)';
                            restoredChatItem.innerHTML = `
                                <div class="w-12 h-12 rounded-full overflow-hidden bg-[#00a884] flex items-center justify-center shrink-0">
                                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="#111b21" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 6L9 17l-5-5"></path>
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1 border-b border-[#202c33] pb-3 pt-1 min-w-0 pr-6 relative">
                                    <div class="flex justify-between items-center">
                                        <h4 class="text-[17px] text-[#e9edef] truncate mr-2 font-medium">
                                            WhatsApp System
                                        </h4>
                                        <span class="text-[12px] text-[#00a884] whitespace-nowrap">Just now</span>
                                    </div>
                                    <div class="flex justify-between items-center mt-0.5">
                                        <p class="text-[14px] text-[#8696a0] truncate flex-1 min-w-0 leading-snug">
                                            Chat history has been restored successfully.
                                        </p>
                                    </div>
                                </div>
                            `;
                            
                            const lockedChatsBtn = document.getElementById('locked_chats_btn');
                            if (lockedChatsBtn && lockedChatsBtn.nextSibling) {
                                userListContainer.insertBefore(restoredChatItem, lockedChatsBtn.nextSibling);
                            } else {
                                userListContainer.prepend(restoredChatItem);
                            }

                            setTimeout(() => {
                                restoredChatItem.style.backgroundColor = 'transparent';
                            }, 3000);
                        }
                    }, 500);
                }, 2500);
            }
            // Clear session state
            window.currentTransferSessionId = null;
        }
    };
    window.closeTransferChatHistoryPanel = function() {
        if (transferInterval) clearInterval(transferInterval);
        if (window.transferFirebaseListener) {
            window.transferFirebaseListener();
            window.transferFirebaseListener = null;
        }
        stopTransferCamera();
        
        const chatsPanel = document.getElementById('chats_settings_panel');
        const transferPanel = document.getElementById('transfer_chat_history_panel');
        const startScreen = document.getElementById('transfer_start_screen');
        const progressScreen = document.getElementById('transfer_progress_screen');
        const verifyScreen = document.getElementById('transfer_verify_screen');
        const scanScreen = document.getElementById('transfer_scan_screen');
        const authScreen = document.getElementById('transfer_auth_screen');
        const qrScreen = document.getElementById('transfer_qr_display_screen');
        const syncScreen = document.getElementById('transfer_sync_screen');
        const completeScreen = document.getElementById('transfer_complete_screen');

        if (transferPanel) {
            transferPanel.classList.add('hidden');
            transferPanel.classList.remove('flex');
            
            chatsPanel.classList.remove('hidden');
            chatsPanel.classList.add('flex');

            // Restore chats if they were hidden and the process was cancelled
            if (window.originalChatsHTML) {
                const userListContainer = document.getElementById('user_list_container');
                if (userListContainer) {
                    userListContainer.innerHTML = window.originalChatsHTML;
                    window.originalChatsHTML = null;
                }
            }

            // Reset to first screen for next time
            if (startScreen && progressScreen && verifyScreen && scanScreen && qrScreen && syncScreen && completeScreen && authScreen) {
                progressScreen.classList.add('hidden');
                progressScreen.classList.remove('flex');
                
                verifyScreen.classList.add('hidden');
                verifyScreen.classList.remove('flex');

                scanScreen.classList.add('hidden');
                scanScreen.classList.remove('flex');

                authScreen.classList.add('hidden');
                authScreen.classList.remove('flex');
                
                qrScreen.classList.add('hidden');
                qrScreen.classList.remove('flex');

                syncScreen.classList.add('hidden');
                syncScreen.classList.remove('flex');

                completeScreen.classList.add('hidden');
                completeScreen.classList.remove('flex');
                
                startScreen.classList.remove('hidden');
                startScreen.classList.add('flex');
            }
        }
    };

    window.toggleTransferChatHistoryMenu = function(e, id = '') {
        if(e) e.stopPropagation();
        const menu = document.getElementById('transfer_chat_history_menu' + (id ? '_' + id : ''));
        if(menu) menu.classList.toggle('hidden');
    };

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        const menu1 = document.getElementById('transfer_chat_history_menu');
        const menu2 = document.getElementById('transfer_chat_history_menu_2');
        
        [menu1, menu2].forEach(menu => {
            if (menu && !menu.classList.contains('hidden')) {
                const button = menu.previousElementSibling;
                if (button && !button.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            }
        });
    });
</script>
