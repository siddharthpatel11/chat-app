<x-app-layout>
    @push('styles')
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                margin: 0;
                overflow: hidden;
            }

            .call-bg {
                background: linear-gradient(135deg, #0b141a 0%, #1a2e38 40%, #0d3320 70%, #0b141a 100%);
                position: relative;
            }

            .call-bg::before {
                content: '';
                position: absolute;
                inset: 0;
                background: radial-gradient(ellipse at 50% 30%, rgba(0, 168, 132, 0.08) 0%, transparent 70%);
                pointer-events: none;
            }

            .pulse-ring {
                position: absolute;
                border-radius: 50%;
                border: 1px solid rgba(0, 168, 132, 0.15);
                animation: pulse-expand 3s ease-out infinite;
            }

            .pulse-ring:nth-child(1) {
                animation-delay: 0s;
            }

            .pulse-ring:nth-child(2) {
                animation-delay: 1s;
            }

            .pulse-ring:nth-child(3) {
                animation-delay: 2s;
            }

            @keyframes pulse-expand {
                0% {
                    width: 140px;
                    height: 140px;
                    opacity: 0.6;
                }

                100% {
                    width: 350px;
                    height: 350px;
                    opacity: 0;
                }
            }

            @keyframes dot-blink {

                0%,
                80%,
                100% {
                    opacity: 0.3;
                }

                40% {
                    opacity: 1;
                }
            }

            .dot-1 {
                animation: dot-blink 1.4s ease-in-out infinite;
            }

            .dot-2 {
                animation: dot-blink 1.4s ease-in-out 0.2s infinite;
            }

            .dot-3 {
                animation: dot-blink 1.4s ease-in-out 0.4s infinite;
            }

            .end-call-btn {
                box-shadow: 0 0 30px rgba(239, 68, 68, 0.3), 0 4px 20px rgba(0, 0, 0, 0.3);
            }

            .end-call-btn:hover {
                box-shadow: 0 0 40px rgba(239, 68, 68, 0.5), 0 4px 25px rgba(0, 0, 0, 0.4);
            }

            .call-control {
                backdrop-filter: blur(20px);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .call-control:hover {
                transform: scale(1.1);
                background: rgba(255, 255, 255, 0.25);
            }

            .call-control:active {
                transform: scale(0.95);
            }

            .call-control.active {
                background: white;
                color: #111b21;
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .fade-in-up {
                animation: fadeInUp 0.6s ease-out forwards;
            }

            .fade-in-up-delay {
                animation: fadeInUp 0.6s ease-out 0.2s forwards;
                opacity: 0;
            }

            .fade-in-up-delay-2 {
                animation: fadeInUp 0.6s ease-out 0.4s forwards;
                opacity: 0;
            }

            .encryption-badge {
                background: rgba(255, 255, 255, 0.06);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.08);
            }

            .participant-strip {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 12px;
                flex-wrap: wrap;
                padding: 16px 24px;
                animation: fadeInUp 0.4s ease-out;
            }

            .participant-bubble {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 6px;
                animation: popIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            }

            @keyframes popIn {
                from {
                    transform: scale(0);
                    opacity: 0;
                }

                to {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            .participant-avatar {
                width: 48px;
                height: 48px;
                border-radius: 50%;
                overflow: hidden;
                border: 2px solid rgba(0, 168, 132, 0.4);
                background: #202c33;
            }

            .participant-avatar img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .participant-name {
                color: #d1d7db;
                font-size: 11px;
                max-width: 70px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                text-align: center;
            }

            .participant-status {
                font-size: 9px;
                color: #00a884;
            }

            .participant-status.calling {
                color: #8696a0;
            }
        </style>
    @endpush

    <div class="call-bg w-full h-screen flex flex-col items-center justify-between font-['Inter'] select-none"
        id="voice_call_screen">

        <!-- Top -->
        <div class="pt-12 pb-4 text-center fade-in-up">
            <div class="encryption-badge inline-flex items-center gap-2 px-4 py-2 rounded-full">
                <svg class="w-3.5 h-3.5 text-[#00a884]" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z" />
                </svg>
                <span class="text-[#8696a0] text-[12px] font-medium tracking-wide">End-to-end encrypted</span>
            </div>
        </div>

        <!-- Center -->
        <div class="flex-1 flex flex-col items-center justify-center -mt-12 fade-in-up-delay">
            <div class="relative flex items-center justify-center mb-8">
                <div class="pulse-ring" id="ring1"></div>
                <div class="pulse-ring" id="ring2"></div>
                <div class="pulse-ring" id="ring3"></div>
                <div
                    class="w-[140px] h-[140px] rounded-full overflow-hidden border-[3px] border-[#00a884]/30 shadow-2xl relative z-10 bg-[#202c33]">
                    <img id="call_user_avatar" src="{!! $avatar !!}" class="w-full h-full object-cover"
                        alt="User avatar">
                </div>
            </div>
            <h1 id="call_user_name" class="text-white text-[28px] font-semibold tracking-tight mb-2">{{ $name }}
            </h1>
            <div id="call_status" class="flex items-center gap-1.5">
                <span id="call_status_text"
                    class="text-[#8696a0] text-[15px] font-normal">{{ $role === 'caller' ? 'Calling' : 'Connecting' }}</span>
                <span class="flex gap-0.5" id="ringing_dots">
                    <span class="dot-1 text-[#8696a0] text-[15px]">.</span>
                    <span class="dot-2 text-[#8696a0] text-[15px]">.</span>
                    <span class="dot-3 text-[#8696a0] text-[15px]">.</span>
                </span>
                <span id="call_timer" class="text-[#00a884] text-[15px] font-medium hidden">00:00</span>
            </div>

            <!-- Participants Strip -->
            <div id="participants_strip" class="participant-strip hidden mt-4"></div>
        </div>

        <!-- Ringtone Audio -->
        <audio id="ringtone_audio" loop>
            <source src="https://www.soundjay.com/phone/phone-calling-1.mp3" type="audio/mpeg">
        </audio>
        <!-- Remote audio (plays other user's voice) -->
        <audio id="remote_audio" autoplay></audio>

        <!-- Controls -->
        <div class="pb-16 w-full max-w-md px-8 fade-in-up-delay-2">
            <div class="flex items-center justify-between px-6 mb-8">
                <button id="speaker_btn" onclick="toggleSpeaker()"
                    class="call-control w-14 h-14 rounded-full bg-white/10 text-white flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z" />
                    </svg>
                </button>
                <button id="mute_btn" onclick="toggleMute()"
                    class="call-control w-14 h-14 rounded-full bg-white/10 text-white flex items-center justify-center">
                    <svg id="mute_icon_off" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 14c1.66 0 2.99-1.34 2.99-3L15 5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3zm5.3-3c0 3-2.54 5.1-5.3 5.1S6.7 14 6.7 11H5c0 3.41 2.72 6.23 6 6.72V21h2v-3.28c3.28-.48 6-3.3 6-6.72h-1.7z" />
                    </svg>
                    <svg id="mute_icon_on" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M19 11h-1.7c0 .74-.16 1.43-.43 2.05l1.23 1.23c.56-.98.9-2.09.9-3.28zm-4.02.17c0-.06.02-.11.02-.17V5c0-1.66-1.34-3-3-3S9 3.34 9 5v.18l5.98 5.99zM4.27 3L3 4.27l6.01 6.01V11c0 1.66 1.33 3 2.99 3 .22 0 .44-.03.65-.08l1.66 1.66c-.71.33-1.5.52-2.31.52-2.76 0-5.3-2.1-5.3-5.1H5c0 3.41 2.72 6.23 6 6.72V21h2v-3.28c.91-.13 1.77-.45 2.54-.9L19.73 21 21 19.73 4.27 3z" />
                    </svg>
                </button>
                <button onclick="openContactPicker()"
                    class="call-control w-14 h-14 rounded-full bg-white/10 text-white flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </button>
            </div>
            <div class="flex justify-center">
                <button onclick="endCall()"
                    class="end-call-btn w-16 h-16 rounded-full bg-red-500 hover:bg-red-600 text-white flex items-center justify-center transition-all duration-300 active:scale-90">
                    <svg class="w-8 h-8 rotate-[135deg]" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Contact Picker Overlay -->
    <div id="contact_picker"
        class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-end justify-center">
        <div class="w-full max-w-md bg-[#111b21] rounded-t-2xl max-h-[70vh] flex flex-col"
            style="animation:slideUp .3s ease">
            <style>
                @keyframes slideUp {
                    from {
                        transform: translateY(100%)
                    }

                    to {
                        transform: translateY(0)
                    }
                }
            </style>
            <div class="flex items-center justify-between px-5 py-4 border-b border-[#313d45]">
                <h3 class="text-white text-lg font-semibold">Add participant</h3>
                <button onclick="closeContactPicker()" class="text-[#8696a0] hover:text-white p-1"><svg class="w-6 h-6"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg></button>
            </div>
            <div class="px-4 py-2"><input id="cp_search" type="text" placeholder="Search contacts..."
                    oninput="filterContacts()"
                    class="w-full bg-[#202c33] border-none rounded-lg px-4 py-2 text-sm text-[#d1d7db] placeholder-[#8696a0] focus:ring-1 focus:ring-[#00a884] outline-none">
            </div>
            <div class="flex-1 overflow-y-auto" id="cp_list">
                @foreach ($users as $u)
                    <div class="cp-item flex items-center gap-3 px-5 py-3 hover:bg-[#202c33] cursor-pointer transition-colors"
                        data-name="{{ strtolower($u->name) }}"
                        onclick="selectContact({{ $u->id }}, '{{ addslashes($u->name) }}', '{!! $u->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($u->name) . '&background=2a3942&color=fff' !!}')">
                        <div class="w-10 h-10 rounded-full overflow-hidden bg-[#2a3942] shrink-0"><img
                                src="{!! $u->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($u->name) . '&background=2a3942&color=fff' !!}" class="w-full h-full object-cover"></div>
                        <div class="flex-1 min-w-0">
                            <div class="text-[#e9edef] text-[15px] truncate">{{ $u->name }}</div>
                            <div class="text-[#8696a0] text-xs truncate">{{ $u->phone ?? '' }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script type="module">
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
        import {
            getDatabase,
            ref,
            set,
            update,
            onValue,
            push,
            onChildAdded,
            remove,
            get
        } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-database.js";

        const firebaseConfig = {
            apiKey: "{{ env('FIREBASE_API_KEY') }}",
            authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
            databaseURL: "{{ env('FIREBASE_DATABASE_URL') }}",
            projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
            messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
            appId: "{{ env('FIREBASE_APP_ID') }}"
        };


        const app = initializeApp(firebaseConfig);
        const db = getDatabase(app);

        // === CONFIG ===
        const ROLE = "{{ $role }}";
        const CALL_ID = "{{ $callId ?? '' }}";
        const CALLEE_ID = "{{ $calleeId ?? '' }}";
        const MY_USER_ID = {{ $myUserId }};
        const MY_NAME = "{{ $myName }}";
        const MY_AVATAR = "{!! $myAvatar !!}";
        const GROUP_CALL_ID = "{{ $groupCallId ?? '' }}";
        const OTHER_NAME = "{{ $name }}";
        const OTHER_AVATAR = "{!! $avatar !!}";
        const CALL_TYPE = "voice";

        const iceServers = {
            iceServers: [{
                    urls: 'stun:stun.l.google.com:19302'
                },
                {
                    urls: 'stun:stun1.l.google.com:19302'
                },
                {
                    urls: 'stun:stun2.l.google.com:19302'
                },
                {
                    urls: 'stun:stun3.l.google.com:19302'
                },
                {
                    urls: 'stun:stun4.l.google.com:19302'
                }
            ]
        };

        let peerConnection = null;
        let localStream = null;
        let callSeconds = 0;
        let callTimer = null;
        let callId = CALL_ID;
        let isMuted = false;
        let isSpeaker = false;
        let callEnded = false;
        let wasConnected = false;
        let callLogSent = false;
        let otherUserId = ROLE === 'caller' ? parseInt(CALLEE_ID) : 0;
        let groupId = GROUP_CALL_ID || (CALL_ID ? 'gc_' + CALL_ID : null);
        let extraPeers = {};
        let participantListenerSet = false;

        function getChatId() {
            const minId = Math.min(MY_USER_ID, otherUserId);
            const maxId = Math.max(MY_USER_ID, otherUserId);
            return `chat_${minId}_${maxId}`;
        }

        async function sendCallLog(callStatus, duration) {
            if (callLogSent || !otherUserId) return;
            callLogSent = true;
            const now = Math.floor(Date.now() / 1000);
            try {
                await push(ref(db, `chats/${getChatId()}/messages`), {
                    sender_id: MY_USER_ID,
                    type: 'call',
                    call_type: CALL_TYPE,
                    call_status: callStatus,
                    call_duration: duration || 0,
                    text: '',
                    time: now,
                    status: 'sent'
                });

                const logData = {
                    type: CALL_TYPE,
                    status: callStatus,
                    direction: ROLE === 'caller' ? 'outgoing' : 'incoming',
                    duration: duration || 0,
                    time: now,
                    other_user_id: otherUserId,
                    other_user_name: OTHER_NAME,
                    other_user_avatar: OTHER_AVATAR
                };
                await push(ref(db, `users/${MY_USER_ID}/call_logs`), logData);
            } catch (e) {
                console.error('Call log error:', e);
            }
        }

        // === INIT ===
        async function init() {
            try {
                // Get microphone
                try {
                    localStream = await navigator.mediaDevices.getUserMedia({
                        audio: true
                    });
                } catch (err) {
                    console.error("Microphone access denied or error:", err);
                    alert(
                        "Microphone access is required for this call. Please check your browser permissions. If you are on mobile, make sure you are using HTTPS.");
                    document.getElementById('call_status_text').textContent = 'Microphone access denied';
                    return;
                }

                // Create peer connection
                peerConnection = new RTCPeerConnection(iceServers);

                // Add local audio tracks
                localStream.getTracks().forEach(track => {
                    peerConnection.addTrack(track, localStream);
                });

                // When remote audio arrives, play it
                peerConnection.ontrack = (event) => {
                    const remoteAudio = document.getElementById('remote_audio');
                    if (event.streams && event.streams[0]) {
                        if (remoteAudio.srcObject !== event.streams[0]) remoteAudio.srcObject = event.streams[0];
                    } else {
                        let stream = remoteAudio.srcObject || new MediaStream();
                        if (stream.getTracks().indexOf(event.track) === -1) {
                            stream.addTrack(event.track);
                        }
                        remoteAudio.srcObject = stream;
                    }
                    remoteAudio.muted = false;
                    setTimeout(() => {
                        remoteAudio.play().catch(err => {
                            console.log('Autoplay blocked', err);
                            document.body.addEventListener('click', () => {
                                remoteAudio.play();
                            }, {
                                once: true
                            });
                        });
                    }, 500);
                };

                // ICE connection state change
                peerConnection.oniceconnectionstatechange = () => {
                    const state = peerConnection.iceConnectionState;
                    console.log('ICE state:', state);
                    if (state === 'connected' || state === 'completed') {
                        onCallConnected();
                    } else if (state === 'failed' || state === 'disconnected' || state === 'closed') {
                        if (!callEnded) endCall();
                    }
                };

                if (ROLE === 'caller') {
                    await startAsCaller();
                } else {
                    await startAsCallee();
                }

            } catch (err) {
                console.error('Init error:', err);
                document.getElementById('call_status_text').textContent = 'Microphone access denied';
                document.getElementById('ringing_dots').classList.add('hidden');
            }
        }

        // === CALLER FLOW ===
        async function startAsCaller() {
            // Generate call ID
            callId = 'call_' + MY_USER_ID + '_' + CALLEE_ID + '_' + Date.now();

            // ICE candidates → Firebase
            peerConnection.onicecandidate = (event) => {
                if (event.candidate) {
                    push(ref(db, `calls/${callId}/caller_candidates`), event.candidate.toJSON());
                }
            };

            // Create offer
            const offer = await peerConnection.createOffer({
                offerToReceiveAudio: true,
                offerToReceiveVideo: false
            });
            await peerConnection.setLocalDescription(offer);

            // Write call to Firebase
            await set(ref(db, `calls/${callId}`), {
                caller_id: MY_USER_ID,
                callee_id: parseInt(CALLEE_ID),
                caller_name: MY_NAME,
                caller_avatar: MY_AVATAR,
                callee_name: OTHER_NAME,
                callee_avatar: OTHER_AVATAR,
                type: CALL_TYPE,
                status: 'calling',
                offer: {
                    type: offer.type,
                    sdp: offer.sdp
                },
                created_at: Date.now()
            });

            document.getElementById('call_status_text').textContent = 'Ringing';
            try {
                document.getElementById('ringtone_audio').play().catch(() => {});
            } catch (e) {}

            // Listen for answer
            onValue(ref(db, `calls/${callId}/answer`), async (snapshot) => {
                const answer = snapshot.val();
                if (answer && peerConnection.signalingState === 'have-local-offer') {
                    await peerConnection.setRemoteDescription(new RTCSessionDescription(answer));
                }
            });

            // Listen for callee's ICE candidates
            onChildAdded(ref(db, `calls/${callId}/callee_candidates`), async (snapshot) => {
                const candidate = snapshot.val();
                if (candidate) {
                    try {
                        await peerConnection.addIceCandidate(new RTCIceCandidate(candidate));
                    } catch (e) {
                        console.warn('ICE add error:', e);
                    }
                }
            });

            // Listen for status changes (rejected/ended)
            onValue(ref(db, `calls/${callId}/status`), async (snapshot) => {
                const status = snapshot.val();
                if (status === 'rejected' || status === 'ended') {
                    if (!callEnded) {
                        callEnded = true;
                        // Caller sends call log when callee ends
                        if (status === 'ended' && wasConnected) await sendCallLog('completed', callSeconds);
                        document.getElementById('call_status_text').textContent = status === 'rejected' ?
                            'Call declined' : 'Call ended';
                        document.getElementById('ringing_dots').classList.add('hidden');
                        document.getElementById('call_timer').classList.add('hidden');
                        cleanup();
                        setTimeout(() => {
                            window.location.href = '/chat';
                        }, 1500);
                    }
                }
            });
        }

        // === CALLEE FLOW ===
        async function startAsCallee() {
            document.getElementById('call_status_text').textContent = 'Connecting';

            // Read offer from Firebase (and get caller info)
            const callSnapshot = await get(ref(db, `calls/${callId}`));
            const callData = callSnapshot.val();

            if (callData) {
                otherUserId = callData.caller_id;
                if (callData.group_call_id) {
                    groupId = callData.group_call_id;
                    setupParticipantListener(); // Start listening immediately
                }
            }

            if (!callData || !callData.offer) {
                document.getElementById('call_status_text').textContent = 'Call not found';
                document.getElementById('ringing_dots').classList.add('hidden');
                setTimeout(() => {
                    window.location.href = '/chat';
                }, 2000);
                return;
            }

            // Update status
            await update(ref(db, `calls/${callId}`), {
                status: 'connected'
            });

            // ICE candidates → Firebase
            peerConnection.onicecandidate = (event) => {
                if (event.candidate) {
                    push(ref(db, `calls/${callId}/callee_candidates`), event.candidate.toJSON());
                }
            };

            // Set remote (caller's offer)
            await peerConnection.setRemoteDescription(new RTCSessionDescription(callData.offer));

            // Create answer
            const answer = await peerConnection.createAnswer();
            await peerConnection.setLocalDescription(answer);

            // Write answer to Firebase
            await update(ref(db, `calls/${callId}`), {
                answer: {
                    type: answer.type,
                    sdp: answer.sdp
                }
            });

            // Listen for caller's ICE candidates
            onChildAdded(ref(db, `calls/${callId}/caller_candidates`), async (snapshot) => {
                const candidate = snapshot.val();
                if (candidate) {
                    try {
                        await peerConnection.addIceCandidate(new RTCIceCandidate(candidate));
                    } catch (e) {
                        console.warn('ICE add error:', e);
                    }
                }
            });

            // Listen for status changes
            onValue(ref(db, `calls/${callId}/status`), (snapshot) => {
                const status = snapshot.val();
                if (status === 'ended') {
                    if (!callEnded) {
                        callEnded = true;
                        document.getElementById('call_status_text').textContent = 'Call ended';
                        document.getElementById('ringing_dots').classList.add('hidden');
                        document.getElementById('call_timer').classList.add('hidden');
                        cleanup();
                        setTimeout(() => {
                            window.location.href = '/chat';
                        }, 1500);
                    }
                }
            });
        }

        // === CONNECTED ===
        function onCallConnected() {
            wasConnected = true;
            try {
                document.getElementById('ringtone_audio').pause();
            } catch (e) {}
            document.getElementById('call_status_text').textContent = '';
            document.getElementById('ringing_dots').classList.add('hidden');
            document.getElementById('call_timer').classList.remove('hidden');

            // Stop pulse rings
            document.querySelectorAll('.pulse-ring').forEach(r => r.style.animationPlayState = 'paused');

            // Start timer
            callTimer = setInterval(() => {
                callSeconds++;
                const mins = Math.floor(callSeconds / 60).toString().padStart(2, '0');
                const secs = (callSeconds % 60).toString().padStart(2, '0');
                document.getElementById('call_timer').textContent = `${mins}:${secs}`;
            }, 1000);
        }

        // === CLEANUP ===
        function cleanup() {
            clearInterval(callTimer);
            try {
                document.getElementById('ringtone_audio').pause();
            } catch (e) {}
            if (localStream) {
                localStream.getTracks().forEach(track => track.stop());
            }
            if (peerConnection) {
                peerConnection.close();
            }
            Object.values(extraPeers).forEach(pc => {
                try {
                    pc.close();
                } catch (e) {}
            });
            extraPeers = {};
            if (groupId) {
                try {
                    update(ref(db, `group_calls/${groupId}/participants/${MY_USER_ID}`), {
                        status: 'left'
                    });
                } catch (e) {}
            }
        }

        // === END CALL ===
        window.endCall = async function() {
            if (callEnded) return;
            callEnded = true;

            document.getElementById('call_status_text').textContent = 'Call ended';
            document.getElementById('ringing_dots').classList.add('hidden');
            document.getElementById('call_timer').classList.add('hidden');

            // Send call log
            if (ROLE === 'caller') {
                if (wasConnected) await sendCallLog('completed', callSeconds);
                else await sendCallLog('no_answer', 0);
            } else if (wasConnected) {
                // Callee ended connected call - caller will send log via status listener
            }

            if (callId) {
                try {
                    await update(ref(db, `calls/${callId}`), {
                        status: 'ended'
                    });
                    setTimeout(async () => {
                        try {
                            await remove(ref(db, `calls/${callId}`));
                        } catch (e) {}
                    }, 3000);
                } catch (e) {}
            }

            cleanup();
            setTimeout(() => {
                window.location.href = '/chat';
            }, 1000);
        };

        // === CONTROLS ===
        window.toggleMute = function() {
            isMuted = !isMuted;
            if (localStream) {
                localStream.getAudioTracks().forEach(track => track.enabled = !isMuted);
            }
            document.getElementById('mute_icon_off').classList.toggle('hidden', isMuted);
            document.getElementById('mute_icon_on').classList.toggle('hidden', !isMuted);
            document.getElementById('mute_btn').classList.toggle('active', isMuted);
        };

        window.toggleSpeaker = async function() {
            isSpeaker = !isSpeaker;
            document.getElementById('speaker_btn').classList.toggle('active', isSpeaker);

            const remoteAudio = document.getElementById('remote_audio');
            if (remoteAudio) {
                remoteAudio.play().catch(() => {});
                if (typeof remoteAudio.setSinkId === 'function') {
                    try {
                        const devices = await navigator.mediaDevices.enumerateDevices();
                        const audioOutputs = devices.filter(d => d.kind === 'audiooutput');
                        if (audioOutputs.length > 1) {
                            const newSinkId = isSpeaker ? audioOutputs[1].deviceId : audioOutputs[0].deviceId;
                            await remoteAudio.setSinkId(newSinkId);
                        }
                    } catch (e) {}
                }
            }
        };

        // Handle tab close / navigate away
        window.addEventListener('beforeunload', () => {
            if (!callEnded && callId) {
                // Use sendBeacon pattern - update status
                navigator.sendBeacon('/api/end-call', JSON.stringify({
                    call_id: callId
                }));
                cleanup();
            }
        });

        // === MULTI-PARTY: Connect to a new peer ===
        async function connectToPeer(remoteId) {
            if (extraPeers[remoteId] || remoteId == MY_USER_ID) return;
            const pc = new RTCPeerConnection(iceServers);
            localStream.getTracks().forEach(t => pc.addTrack(t, localStream));
            pc.ontrack = (e) => {
                let audio = document.getElementById('audio_' + remoteId);
                if (!audio) {
                    audio = document.createElement('audio');
                    audio.id = 'audio_' + remoteId;
                    audio.autoplay = true;
                    document.body.appendChild(audio);
                }
                if (e.streams && e.streams[0]) {
                    if (audio.srcObject !== e.streams[0]) audio.srcObject = e.streams[0];
                } else {
                    let stream = audio.srcObject || new MediaStream();
                    if (stream.getTracks().indexOf(e.track) === -1) {
                        stream.addTrack(e.track);
                    }
                    audio.srcObject = stream;
                }
                audio.muted = false;
                setTimeout(() => {
                    audio.play().catch(err => {
                        console.log('Autoplay blocked', err);
                        document.body.addEventListener('click', () => {
                            audio.play();
                        }, {
                            once: true
                        });
                    });
                }, 500);
            };
            pc.oniceconnectionstatechange = () => {
                if (pc.iceConnectionState === 'connected' || pc.iceConnectionState === 'completed') {
                    if (!wasConnected) onCallConnected();
                }
            };
            extraPeers[remoteId] = pc;
            const pairKey = `${Math.min(MY_USER_ID, remoteId)}_${Math.max(MY_USER_ID, remoteId)}`;
            const iAmInitiator = MY_USER_ID < remoteId;

            pc.onicecandidate = (e) => {
                if (e.candidate) push(ref(db,
                        `group_calls/${groupId}/signaling/${pairKey}/${MY_USER_ID}_candidates`), e.candidate
                    .toJSON());
            };

            if (iAmInitiator) {
                const offer = await pc.createOffer({
                    offerToReceiveAudio: true,
                    offerToReceiveVideo: false
                });
                await pc.setLocalDescription(offer);
                await set(ref(db, `group_calls/${groupId}/signaling/${pairKey}/offer`), {
                    type: offer.type,
                    sdp: offer.sdp
                });
                onValue(ref(db, `group_calls/${groupId}/signaling/${pairKey}/answer`), async (s) => {
                    if (s.val() && pc.signalingState === 'have-local-offer') await pc.setRemoteDescription(
                        new RTCSessionDescription(s.val()));
                });
            } else {
                onValue(ref(db, `group_calls/${groupId}/signaling/${pairKey}/offer`), async (s) => {
                    if (!s.val() || pc.signalingState !== 'stable') return;
                    await pc.setRemoteDescription(new RTCSessionDescription(s.val()));
                    const answer = await pc.createAnswer();
                    await pc.setLocalDescription(answer);
                    await set(ref(db, `group_calls/${groupId}/signaling/${pairKey}/answer`), {
                        type: answer.type,
                        sdp: answer.sdp
                    });
                });
            }
            onChildAdded(ref(db, `group_calls/${groupId}/signaling/${pairKey}/${remoteId}_candidates`), async (s) => {
                try {
                    await pc.addIceCandidate(new RTCIceCandidate(s.val()));
                } catch (e) {}
            });
        }

        // === Update participant strip UI ===
        function updateParticipantStrip(participantsData) {
            const strip = document.getElementById('participants_strip');
            if (!participantsData || Object.keys(participantsData).length <= 1) {
                strip.classList.add('hidden');
                return;
            }
            strip.classList.remove('hidden');
            strip.innerHTML = '';
            Object.entries(participantsData).forEach(([uid, p]) => {
                // Use String comparison to avoid type issues
                if (String(uid) === String(MY_USER_ID)) return;

                const statusText = p.status === 'connected' ? 'Connected' : (p.status === 'calling' ? 'Ringing...' :
                    p.status);
                const statusClass = p.status === 'calling' ? 'calling' : '';
                const avatarUrl = p.avatar ||
                    `https://ui-avatars.com/api/?name=${encodeURIComponent(p.name)}&background=2a3942&color=fff&size=96`;

                const bubble = document.createElement('div');
                bubble.className = 'participant-bubble';
                bubble.id = 'pb_' + uid;
                bubble.innerHTML = `
                    <div class="participant-avatar"><img src="${avatarUrl}" alt="${p.name}"></div>
                    <div class="participant-name">${p.name}</div>
                    <div class="participant-status ${statusClass}">${statusText}</div>`;
                strip.appendChild(bubble);
            });
        }

        // === Setup group call listener ===
        function setupParticipantListener() {
            if (participantListenerSet || !groupId) return;
            participantListenerSet = true;

            // Listen for new participants to create peer connections
            onChildAdded(ref(db, `group_calls/${groupId}/participants`), (snap) => {
                const uid = parseInt(snap.key);
                if (uid !== MY_USER_ID && !extraPeers[uid] && uid !== otherUserId) {
                    connectToPeer(uid);
                }
            });

            // Listen for ALL participant changes to update the strip
            onValue(ref(db, `group_calls/${groupId}/participants`), (snap) => {
                const data = snap.val();
                if (data) {
                    // If group exists but I am not in it, join automatically
                    if (!data[MY_USER_ID]) {
                        ensureGroupCall();
                    }
                    updateParticipantStrip(data);
                }
            });
        }

        // === Create/join group call ===
        async function ensureGroupCall() {
            if (!groupId) groupId = 'gc_' + callId;
            const me = {
                name: MY_NAME,
                avatar: MY_AVATAR,
                status: 'connected'
            };
            await set(ref(db, `group_calls/${groupId}/participants/${MY_USER_ID}`), me);
            if (otherUserId) {
                await set(ref(db, `group_calls/${groupId}/participants/${otherUserId}`), {
                    name: OTHER_NAME,
                    avatar: OTHER_AVATAR,
                    status: 'connected'
                });
            }
            await set(ref(db, `group_calls/${groupId}/type`), CALL_TYPE);
            setupParticipantListener();
        }

        // === Add participant ===
        window.selectContact = async function(userId, name, avatar) {
            closeContactPicker();
            await ensureGroupCall();
            await set(ref(db, `group_calls/${groupId}/participants/${userId}`), {
                name,
                avatar,
                status: 'calling'
            });
            // Create call invitation
            const inviteId = `gc_${groupId}_${userId}`;
            const offer_pc = new RTCPeerConnection(iceServers);
            localStream.getTracks().forEach(t => offer_pc.addTrack(t, localStream));
            offer_pc.ontrack = (e) => {
                let audio = document.getElementById('audio_' + userId);
                if (!audio) {
                    audio = document.createElement('audio');
                    audio.id = 'audio_' + userId;
                    audio.autoplay = true;
                    document.body.appendChild(audio);
                }
                audio.srcObject = e.streams[0];
                setTimeout(() => {
                    audio.play().catch(err => console.log('Autoplay blocked', err));
                }, 500);
            };
            offer_pc.oniceconnectionstatechange = () => {
                if (offer_pc.iceConnectionState === 'connected') {
                    update(ref(db, `group_calls/${groupId}/participants/${userId}`), {
                        status: 'connected'
                    });
                }
            };
            extraPeers[userId] = offer_pc;
            offer_pc.onicecandidate = (e) => {
                if (e.candidate) push(ref(db, `calls/${inviteId}/caller_candidates`), e.candidate.toJSON());
            };
            const offer = await offer_pc.createOffer();
            await offer_pc.setLocalDescription(offer);
            await set(ref(db, `calls/${inviteId}`), {
                caller_id: MY_USER_ID,
                callee_id: userId,
                caller_name: MY_NAME,
                caller_avatar: MY_AVATAR,
                callee_name: name,
                callee_avatar: avatar,
                type: CALL_TYPE,
                status: 'calling',
                group_call_id: groupId,
                offer: {
                    type: offer.type,
                    sdp: offer.sdp
                },
                created_at: Date.now()
            });
            onValue(ref(db, `calls/${inviteId}/answer`), async (s) => {
                if (s.val() && offer_pc.signalingState === 'have-local-offer') await offer_pc
                    .setRemoteDescription(new RTCSessionDescription(s.val()));
            });
            onChildAdded(ref(db, `calls/${inviteId}/callee_candidates`), async (s) => {
                try {
                    await offer_pc.addIceCandidate(new RTCIceCandidate(s.val()));
                } catch (e) {}
            });
            onValue(ref(db, `calls/${inviteId}/status`), (s) => {
                if (s.val() === 'rejected') {
                    delete extraPeers[userId];
                    offer_pc.close();
                }
            });
            setupParticipantListener();
        };

        // === If joining a group call as new participant ===
        // Join group call on connect if it exists
        const origOnConnected = onCallConnected;
        onCallConnected = function() {
            origOnConnected();
            ensureGroupCall();
        };

        // Contact picker UI functions
        window.openContactPicker = function() {
            document.getElementById('contact_picker').classList.remove('hidden');
        };
        window.closeContactPicker = function() {
            document.getElementById('contact_picker').classList.add('hidden');
            document.getElementById('cp_search').value = '';
            filterContacts();
        };
        window.filterContacts = function() {
            const q = document.getElementById('cp_search').value.toLowerCase();
            document.querySelectorAll('.cp-item').forEach(el => {
                el.style.display = el.dataset.name.includes(q) ? '' : 'none';
            });
        };

        // Start!
        setupParticipantListener();
        init();
    </script>
</x-app-layout>
