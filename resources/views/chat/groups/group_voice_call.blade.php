<x-app-layout>
    @push('styles')
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style>
            body { margin: 0; overflow: hidden; background: #0b141a; }
            .call-bg { 
                background: linear-gradient(135deg, #0b141a 0%, #1a2e38 40%, #0d3320 70%, #0b141a 100%); 
                position: relative; 
                height: 100vh;
                display: flex;
                flex-direction: column;
            }
            
            #video_grid {
                flex: 1;
                display: grid;
                gap: 12px;
                padding: 12px;
                transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
                overflow: hidden;
            }

            .video-box {
                position: relative;
                background: #111b21;
                border-radius: 16px;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                box-shadow: 0 4px 20px rgba(0,0,0,0.3);
                transition: all 0.3s ease;
                border: 1px solid rgba(255,255,255,0.05);
            }

            .avatar-container {
                position: relative;
                width: 120px;
                height: 120px;
                border-radius: 50%;
                overflow: hidden;
                border: 3px solid rgba(0, 168, 132, 0.3);
                background: #202c33;
                z-index: 10;
                transition: all 0.3s ease;
            }

            .avatar-container img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .pulse-ring {
                position: absolute;
                border-radius: 50%;
                border: 2px solid rgba(0, 168, 132, 0.2);
                animation: pulse-expand 3s ease-out infinite;
                z-index: 5;
            }
            @keyframes pulse-expand {
                0% { width: 120px; height: 120px; opacity: 0.6; transform: scale(1); }
                100% { width: 280px; height: 280px; opacity: 0; transform: scale(1.5); }
            }

            .name-tag {
                position: absolute;
                bottom: 12px;
                left: 12px;
                background: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(8px);
                color: white;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 13px;
                font-weight: 500;
                border: 1px solid rgba(255,255,255,0.1);
            }

            /* Grid Layouts */
            .grid-1 { grid-template-columns: 1fr; }
            .grid-2 { grid-template-columns: 1fr; grid-template-rows: 1fr 1fr; }
            @media (min-width: 640px) { .grid-2 { grid-template-columns: 1fr 1fr; grid-template-rows: 1fr; } }
            .grid-3 { grid-template-columns: 1fr 1fr; grid-template-rows: 1fr 1fr; }
            .grid-3 .video-box:first-child { grid-column: 1 / span 2; }
            .grid-4 { grid-template-columns: 1fr 1fr; grid-template-rows: 1fr 1fr; }
            .grid-5, .grid-6 { grid-template-columns: 1fr 1fr; grid-template-rows: 1fr 1fr 1fr; }

            .controls-bar {
                height: 100px;
                background: rgba(11, 20, 26, 0.8);
                backdrop-filter: blur(20px);
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 20px;
                padding-bottom: 20px;
                z-index: 100;
            }

            .call-btn {
                width: 56px;
                height: 56px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                background: rgba(255, 255, 255, 0.1);
                color: white;
                transition: all 0.2s;
                cursor: pointer;
            }
            .call-btn:hover { background: rgba(255, 255, 255, 0.2); transform: scale(1.05); }
            .call-btn.active { background: white; color: #111b21; }
            .call-btn.end { background: #ef4444; }
            .call-btn.end:hover { background: #dc2626; }

            #participant_list_strip {
                position: absolute;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                display: flex;
                gap: 8px;
                z-index: 200;
            }
            .strip-avatar {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                border: 2px solid #00a884;
                background: #202c33;
                overflow: hidden;
            }
            .strip-avatar img { width: 100%; height: 100%; object-fit: cover; }
        </style>
    @endpush

    <div class="call-bg">
        <!-- Approval Request Prompt for host -->
        <div id="approval_prompt" class="hidden fixed top-6 left-1/2 -translate-x-1/2 z-[300] bg-[#233138] border border-white/10 rounded-2xl p-4 shadow-2xl flex flex-col gap-3 w-80 animate-in slide-in-from-top duration-300">
            <div class="flex items-center gap-3">
                <img id="approval_avatar" class="w-10 h-10 rounded-full object-cover" src="">
                <div class="flex flex-col min-w-0">
                    <span id="approval_name" class="text-white font-medium text-sm truncate">User</span>
                    <span class="text-xs text-[#8696a0]">wants to join the call</span>
                </div>
            </div>
            <div class="flex gap-2">
                <button onclick="window.declineParticipant()" class="flex-1 py-1.5 bg-[#ef4444]/10 hover:bg-[#ef4444]/20 text-[#ef4444] rounded-lg text-sm font-semibold transition-colors focus:outline-none">Decline</button>
                <button onclick="window.approveParticipant()" class="flex-1 py-1.5 bg-[#00a884] hover:bg-[#06cf9c] text-[#111b21] rounded-lg text-sm font-semibold transition-colors focus:outline-none">Approve</button>
            </div>
        </div>

        <!-- Waiting Approval Overlay for guests -->
        <div id="link_waiting_overlay" class="hidden fixed inset-0 z-[250] bg-[#111b21] flex flex-col items-center justify-center p-6 text-center">
            <div class="flex flex-col items-center gap-6">
                <div class="w-20 h-20 rounded-full bg-[#00a884]/10 flex items-center justify-center text-[#00a884] animate-pulse">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <div class="flex flex-col gap-2">
                    <h3 class="text-[#e9edef] text-xl font-semibold">Waiting for approval...</h3>
                    <p class="text-[#8696a0] text-sm max-w-xs">The call organizer needs to approve your request to join.</p>
                </div>
                <button onclick="window.location.href='/chat'" class="mt-4 px-6 py-2 bg-white/5 hover:bg-white/10 text-white rounded-full text-sm font-semibold transition-colors focus:outline-none">
                    Cancel
                </button>
            </div>
        </div>

        <!-- Declined Overlay for guests -->
        <div id="declined_overlay" class="hidden fixed inset-0 z-[250] bg-[#111b21] flex flex-col items-center justify-center p-6 text-center">
            <div class="flex flex-col items-center gap-6">
                <div class="w-20 h-20 rounded-full bg-[#ef4444]/10 flex items-center justify-center text-[#ef4444]">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="flex flex-col gap-2">
                    <h3 class="text-[#e9edef] text-xl font-semibold">Request Declined</h3>
                    <p class="text-[#8696a0] text-sm max-w-xs">Your request to join this call was declined by the organizer.</p>
                </div>
                <button onclick="window.location.href='/chat'" class="mt-4 px-6 py-2 bg-[#00a884] hover:bg-[#06cf9c] text-[#111b21] rounded-full text-sm font-semibold transition-colors focus:outline-none">
                    Go Back
                </button>
            </div>
        </div>

        <div id="participant_list_strip" class="hidden"></div>

        <div id="video_grid" class="grid-1">
            <!-- Local User -->
            <div class="video-box" id="box_self">
                <div class="pulse-ring"></div>
                <div class="pulse-ring" style="animation-delay: 1s"></div>
                <div class="avatar-container">
                    <img src="{!! $myAvatar !!}" alt="Me">
                </div>
                <div class="name-tag">You</div>
            </div>
        </div>

        <div class="controls-bar">
            <button onclick="toggleMute()" id="mute_btn" class="call-btn">
                <svg id="m_off" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg>
                <svg id="m_on" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M19 11h-1.7c0 .74-.16 1.43-.43 2.05l1.23 1.23c.56-.98.9-2.09.9-3.28zm-4.02.17c0-.06.02-.11.02-.17V5c0-1.66-1.34-3-3-3S9 3.34 9 5v.18l5.98 5.99zM4.27 3L3 4.27l6.01 6.01V11c0 1.66 1.33 3 2.99 3 .22 0 .44-.03.65-.08l1.66 1.66c-.71.33-1.5.52-2.31.52-2.76 0-5.3-2.1-5.3-5.1H5c0 3.41 2.72 6.23 6 6.72V21h2v-3.28c.91-.13 1.77-.45 2.54-.9L19.73 21 21 19.73 4.27 3z"/></svg>
            </button>
            <button onclick="toggleSpeaker()" id="spk_btn" class="call-btn">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/></svg>
            </button>
            <button onclick="openContactPicker()" class="call-btn">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </button>
            <button onclick="endVoiceCall()" class="call-btn end">
                <svg class="w-8 h-8 rotate-[135deg]" fill="currentColor" viewBox="0 0 24 24"><path d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z"/></svg>
            </button>
        </div>
    </div>

    <audio id="ringtone" loop><source src="https://assets.mixkit.co/active_storage/sfx/2358/2358-preview.mp3" type="audio/mpeg"></audio>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
        import { getDatabase, ref, set, update, onValue, push, onChildAdded, remove, get } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-database.js";

        const firebaseConfig = {
            apiKey: "AIzaSyCTUuLg0mheURhlG1Z0p0DgMRwoAcR-F0w",
            authDomain: "chat-app-a370c.firebaseapp.com",
            databaseURL: "https://chat-app-a370c-default-rtdb.firebaseio.com",
            projectId: "chat-app-a370c",
            messagingSenderId: "1089034732064",
            appId: "1:1016598612026:web:6cc4d1dd4466eec8934d03"
        };

        const app = initializeApp(firebaseConfig);
        const db = getDatabase(app);

        const ROLE = "{{ $role }}";
        const MY_USER_ID = {{ $myUserId }};
        const MY_NAME = "{{ $myName }}";
        const MY_AVATAR = "{!! $myAvatar !!}";
        const GROUP_ID = "{{ $groupId ?? '' }}";
        const CALL_ID_PARAM = new URLSearchParams(window.location.search).get('call_id');
        let groupId = new URLSearchParams(window.location.search).get('group_call_id') || (GROUP_ID ? 'gc_' + GROUP_ID + '_' + Date.now() : null);

        const iceServers = { iceServers: [{ urls: 'stun:stun.l.google.com:19302' }, { urls: 'stun:stun1.l.google.com:19302' }] };
        
        let localStream = null, isMuted = false, isSpeaker = false, ended = false, startTime = Date.now();
        let extraPeers = {}, participantListenerSet = false;

        async function init() {
            try {
                localStream = await navigator.mediaDevices.getUserMedia({ audio: true });
                if (ROLE === 'caller') {
                    startGroupVoiceCall();
                    try { document.getElementById('ringtone').play(); } catch(e) {}
                } else {
                    acceptGroupVoiceCall();
                }

                window.addEventListener('beforeunload', () => { if (!ended) endVoiceCall(); });
            } catch (err) {
                console.error("Mic access denied:", err);
                alert("Microphone access is required for calls.");
            }
        }

        async function startGroupVoiceCall() {
            ensureParticipant();
            const targets = new URLSearchParams(window.location.search).get('participants');
            if (targets) {
                targets.split(',').forEach(tid => {
                    if (tid != MY_USER_ID) inviteToCall(tid);
                });
            }
        }

        async function acceptGroupVoiceCall() {
            if (CALL_ID_PARAM) {
                await update(ref(db, `calls/${CALL_ID_PARAM}`), { status: 'connected' });
            }
            ensureParticipant();
        }

        async function inviteToCall(targetId) {
            const inviteId = `gc_${groupId}_${targetId}`;
            await set(ref(db, `calls/${inviteId}`), {
                caller_id: MY_USER_ID, callee_id: parseInt(targetId),
                caller_name: MY_NAME, caller_avatar: MY_AVATAR,
                type: 'voice', status: 'calling', group_call_id: groupId,
                created_at: Date.now()
            });
        }

        async function ensureParticipant() {
            const participantsSnap = await get(ref(db, `group_calls/${groupId}/participants`));
            const participantsVal = participantsSnap.val() || {};
            const participantIds = Object.keys(participantsVal);
            
            const isExplicitCaller = new URLSearchParams(window.location.search).get('role') === 'caller';
            const isHost = isExplicitCaller || participantIds.length === 0 || participantIds.includes(String(MY_USER_ID));
            
            const requireApprovalQuery = new URLSearchParams(window.location.search).get('require_approval') === 'true';
            
            if (isHost) {
                if (requireApprovalQuery) {
                    await set(ref(db, `group_calls/${groupId}/require_approval`), true);
                }
                await set(ref(db, `group_calls/${groupId}/participants/${MY_USER_ID}`), {
                    name: MY_NAME,
                    avatar: MY_AVATAR,
                    status: 'connected',
                    joined_at: Date.now(),
                    is_host: true
                });
                setupParticipantListener();
            } else {
                const requireApprovalSnap = await get(ref(db, `group_calls/${groupId}/require_approval`));
                const requireApproval = requireApprovalSnap.val() === true;
                
                if (requireApproval) {
                    const myParticipantRef = ref(db, `group_calls/${groupId}/participants/${MY_USER_ID}`);
                    const myParticipantSnap = await get(myParticipantRef);
                    const myParticipantVal = myParticipantSnap.val();
                    
                    if (!myParticipantVal || myParticipantVal.status !== 'connected') {
                        document.getElementById('link_waiting_overlay').classList.remove('hidden');
                        
                        await set(myParticipantRef, {
                            name: MY_NAME,
                            avatar: MY_AVATAR,
                            status: 'waiting_approval',
                            joined_at: Date.now()
                        });
                        
                        onValue(myParticipantRef, (snap) => {
                            const val = snap.val();
                            if (val) {
                                if (val.status === 'connected') {
                                    document.getElementById('link_waiting_overlay').classList.add('hidden');
                                    setupParticipantListener();
                                } else if (val.status === 'declined') {
                                    document.getElementById('link_waiting_overlay').classList.add('hidden');
                                    document.getElementById('declined_overlay').classList.remove('hidden');
                                    setTimeout(() => {
                                        window.location.href = '/chat';
                                    }, 4000);
                                }
                            }
                        });
                        return;
                    }
                }
                
                await set(ref(db, `group_calls/${groupId}/participants/${MY_USER_ID}`), {
                    name: MY_NAME,
                    avatar: MY_AVATAR,
                    status: 'connected',
                    joined_at: Date.now()
                });
                setupParticipantListener();
            }
        }

        function setupParticipantListener() {
            if (participantListenerSet) return; participantListenerSet = true;
            onChildAdded(ref(db, `group_calls/${groupId}/participants`), (snap) => {
                const uid = snap.key;
                const p = snap.val();
                if (uid != MY_USER_ID && p.status === 'connected') connectToPeer(uid);
            });
            onValue(ref(db, `group_calls/${groupId}/participants`), (snap) => {
                const data = snap.val() || {};
                
                const myEntry = data[MY_USER_ID];
                const isHost = myEntry && myEntry.is_host === true;
                
                if (isHost) {
                    Object.entries(data).forEach(([uid, p]) => {
                        if (p.status === 'waiting_approval') {
                            window.showApprovalPrompt(uid, p.name, p.avatar);
                        }
                    });
                }
                
                Object.entries(data).forEach(([uid, p]) => {
                    const rId = parseInt(uid);
                    if (rId !== MY_USER_ID && p.status === 'connected' && !extraPeers[rId]) {
                        console.log("Peer transitioned to connected, initiating connection:", rId);
                        connectToPeer(rId);
                    }
                });

                updateGrid(data);
                if (Object.keys(data).length > 1) {
                    try { document.getElementById('ringtone').pause(); } catch(e) {}
                }
            });
        }

        async function connectToPeer(remoteId) {
            if (extraPeers[remoteId]) return;
            const pc = new RTCPeerConnection(iceServers);
            extraPeers[remoteId] = pc;
            localStream.getTracks().forEach(t => pc.addTrack(t, localStream));

            pc.ontrack = (e) => {
                let audio = document.getElementById('audio_' + remoteId);
                if (!audio) {
                    audio = document.createElement('audio');
                    audio.id = 'audio_' + remoteId;
                    audio.autoplay = true;
                    document.body.appendChild(audio);
                }
                audio.srcObject = e.streams[0];
            };

            const pairKey = MY_USER_ID < remoteId ? `${MY_USER_ID}_${remoteId}` : `${remoteId}_${MY_USER_ID}`;
            const iAmInit = MY_USER_ID < remoteId;
            const signalingRef = ref(db, `group_calls/${groupId}/signaling/${pairKey}`);

            // Clear old signaling
            if (iAmInit) await remove(signalingRef);

            pc.onicecandidate = (e) => {
                if (e.candidate) push(ref(db, `group_calls/${groupId}/signaling/${pairKey}/${MY_USER_ID}_candidates`), e.candidate.toJSON());
            };

            if (iAmInit) {
                const offer = await pc.createOffer();
                await pc.setLocalDescription(offer);
                await set(ref(db, `group_calls/${groupId}/signaling/${pairKey}/offer`), { type: offer.type, sdp: offer.sdp });
                onValue(ref(db, `group_calls/${groupId}/signaling/${pairKey}/answer`), async (s) => {
                    if (s.val() && pc.signalingState === 'have-local-offer') await pc.setRemoteDescription(new RTCSessionDescription(s.val()));
                });
            } else {
                onValue(ref(db, `group_calls/${groupId}/signaling/${pairKey}/offer`), async (s) => {
                    if (s.val() && pc.signalingState === 'stable') {
                        await pc.setRemoteDescription(new RTCSessionDescription(s.val()));
                        const answer = await pc.createAnswer();
                        await pc.setLocalDescription(answer);
                        await set(ref(db, `group_calls/${groupId}/signaling/${pairKey}/answer`), { type: answer.type, sdp: answer.sdp });
                    }
                });
            }
            onChildAdded(ref(db, `group_calls/${groupId}/signaling/${pairKey}/${remoteId}_candidates`), async (s) => {
                try { await pc.addIceCandidate(new RTCIceCandidate(s.val())); } catch(e) {}
            });
        }

        function updateGrid(participants) {
            const grid = document.getElementById('video_grid');
            const currentBoxes = Array.from(grid.querySelectorAll('.video-box'));
            const activeIds = Object.keys(participants);

            // Remove left participants
            currentBoxes.forEach(box => {
                const id = box.id.replace('box_', '');
                if (id !== 'self' && (!activeIds.includes(id) || participants[id].status === 'left' || participants[id].status === 'declined')) box.remove();
            });

            // Add/Update participants
            Object.entries(participants).forEach(([uid, data]) => {
                if (uid == MY_USER_ID) return;
                let box = document.getElementById('box_' + uid);
                if (!box) {
                    box = document.createElement('div');
                    box.id = 'box_' + uid;
                    box.className = 'video-box';
                    box.innerHTML = `
                        <div class="pulse-ring"></div>
                        <div class="avatar-container">
                            <img src="${data.avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(data.name)}" alt="${data.name}">
                        </div>
                        <div class="name-tag">${data.name}</div>
                    `;
                    grid.appendChild(box);
                }
            });

            const total = grid.querySelectorAll('.video-box').length;
            grid.className = '';
            grid.classList.add('grid-' + Math.min(total, 6));
        }

        window.toggleMute = () => {
            isMuted = !isMuted;
            localStream.getAudioTracks().forEach(t => t.enabled = !isMuted);
            document.getElementById('m_off').classList.toggle('hidden', isMuted);
            document.getElementById('m_on').classList.toggle('hidden', !isMuted);
            document.getElementById('mute_btn').classList.toggle('active', isMuted);
        };

        window.toggleSpeaker = () => {
            isSpeaker = !isSpeaker;
            document.getElementById('spk_btn').classList.toggle('active', isSpeaker);
        };

        window.endVoiceCall = async () => {
            if (ended) return; ended = true;
            const duration = Math.floor((Date.now() - startTime) / 1000);
            await sendCallLog('completed', duration);
            cleanup();
            if (groupId) await update(ref(db, `group_calls/${groupId}/participants/${MY_USER_ID}`), { status: 'left' });
            window.location.href = '/chat';
        };

        async function sendCallLog(status, duration) {
            if (ROLE !== 'caller' || !GROUP_ID) return;
            const now = Math.floor(Date.now() / 1000);
            try {
                await push(ref(db, `groups/${GROUP_ID}/messages`), {
                    sender_id: MY_USER_ID, sender_name: MY_NAME,
                    type: 'call', call_type: 'voice', call_status: status,
                    call_duration: duration, text: '', time: now, status: 'sent'
                });
                
                const logData = {
                    type: 'voice',
                    status: status,
                    direction: 'outgoing',
                    duration: duration || 0,
                    time: now,
                    other_user_id: GROUP_ID,
                    other_user_name: 'Group Call',
                    other_user_avatar: '',
                    is_group: true
                };
                await push(ref(db, `users/${MY_USER_ID}/call_logs`), logData);
            } catch(e) {}
        }

        function cleanup() {
            if (localStream) localStream.getTracks().forEach(t => t.stop());
            Object.values(extraPeers).forEach(p => p.close());
            try { document.getElementById('ringtone').pause(); } catch(e) {}
        }

        window.activeApprovalUid = null;
        window.showApprovalPrompt = function(uid, name, avatar) {
            if (window.activeApprovalUid === uid) return;
            window.activeApprovalUid = uid;
            document.getElementById('approval_avatar').src = avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=2a3942&color=fff`;
            document.getElementById('approval_name').textContent = name;
            document.getElementById('approval_prompt').classList.remove('hidden');
        };
        window.approveParticipant = async function() {
            if (!window.activeApprovalUid) return;
            const uid = window.activeApprovalUid;
            window.activeApprovalUid = null;
            document.getElementById('approval_prompt').classList.add('hidden');
            await update(ref(db, `group_calls/${groupId}/participants/${uid}`), { status: 'connected' });
        };
        window.declineParticipant = async function() {
            if (!window.activeApprovalUid) return;
            const uid = window.activeApprovalUid;
            window.activeApprovalUid = null;
            document.getElementById('approval_prompt').classList.add('hidden');
            await update(ref(db, `group_calls/${groupId}/participants/${uid}`), { status: 'declined' });
        };

        init();
    </script>
</x-app-layout>
