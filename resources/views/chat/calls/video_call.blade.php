<x-app-layout>
    @push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body{margin:0;overflow:hidden}
        .vc-container{position:relative;width:100%;height:100vh;background:#0b141a;overflow:hidden}
        .remote-video-wrap{position:absolute;inset:0;background:linear-gradient(135deg,#0b141a 0%,#1a2e38 40%,#0d3320 70%,#0b141a 100%)}
        .remote-video-wrap video{width:100%;height:100%;object-fit:cover}
        .self-video-wrap{position:absolute;top:80px;right:20px;width:130px;height:180px;border-radius:16px;overflow:hidden;background:#202c33;box-shadow:0 8px 32px rgba(0,0,0,0.5);border:2px solid rgba(255,255,255,0.1);z-index:30;cursor:grab}
        .self-video-wrap video{width:100%;height:100%;object-fit:cover;transform:scaleX(-1)}
        .top-grad{position:absolute;top:0;left:0;right:0;height:140px;background:linear-gradient(to bottom,rgba(0,0,0,0.6),transparent);z-index:20;pointer-events:none}
        .bot-grad{position:absolute;bottom:0;left:0;right:0;height:280px;background:linear-gradient(to top,rgba(0,0,0,0.7),transparent);z-index:20;pointer-events:none}
        .vc-controls{position:absolute;bottom:0;left:0;right:0;z-index:25;padding:24px 32px 48px;display:flex;flex-direction:column;align-items:center;gap:16px}
        .vc-btn{backdrop-filter:blur(20px);transition:all .3s cubic-bezier(.4,0,.2,1)}
        .vc-btn:hover{transform:scale(1.1);background:rgba(255,255,255,0.3)}
        .vc-btn:active{transform:scale(0.95)}
        .vc-btn.active{background:white;color:#111b21}
        .vc-end{box-shadow:0 0 30px rgba(239,68,68,0.3),0 4px 20px rgba(0,0,0,0.3)}
        .vp-ring{position:absolute;border-radius:50%;border:1px solid rgba(0,168,132,0.15);animation:vpe 3s ease-out infinite}
        .vp-ring:nth-child(1){animation-delay:0s}.vp-ring:nth-child(2){animation-delay:1s}.vp-ring:nth-child(3){animation-delay:2s}
        @keyframes vpe{0%{width:140px;height:140px;opacity:.6}100%{width:350px;height:350px;opacity:0}}
        @keyframes vdb{0%,80%,100%{opacity:.3}40%{opacity:1}}
        .vd1{animation:vdb 1.4s ease-in-out infinite}.vd2{animation:vdb 1.4s ease-in-out .2s infinite}.vd3{animation:vdb 1.4s ease-in-out .4s infinite}
        .wait-overlay{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;z-index:15;transition:opacity .5s ease}
        .enc-badge{background:rgba(0,0,0,0.3);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,0.08)}
        .vc-participants{position:absolute;top:60px;left:50%;transform:translateX(-50%);z-index:30;display:flex;gap:8px;padding:8px 16px;background:rgba(0,0,0,0.4);backdrop-filter:blur(12px);border-radius:20px;border:1px solid rgba(255,255,255,0.1)}
        .vc-participant{display:flex;flex-direction:column;align-items:center;gap:3px;animation:vcpIn .3s cubic-bezier(.34,1.56,.64,1)}
        @keyframes vcpIn{from{transform:scale(0);opacity:0}to{transform:scale(1);opacity:1}}
        .vc-participant img{width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid rgba(0,168,132,0.5)}
        .vc-participant span{color:#d1d7db;font-size:9px;max-width:50px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    </style>
    @endpush

    <div class="vc-container font-['Inter'] select-none">
        <div class="remote-video-wrap"><video id="remote_video" autoplay playsinline></video></div>

        <!-- Waiting overlay -->
        <div class="wait-overlay" id="waiting_overlay">
            <div class="relative flex items-center justify-center mb-8">
                <div class="vp-ring"></div><div class="vp-ring"></div><div class="vp-ring"></div>
                <div class="w-[140px] h-[140px] rounded-full overflow-hidden border-[3px] border-[#00a884]/30 shadow-2xl relative z-10 bg-[#202c33]">
                    <img src="{!! $avatar !!}" class="w-full h-full object-cover">
                </div>
            </div>
            <h1 class="text-white text-[28px] font-semibold mb-2">{{ $name }}</h1>
            <div class="flex items-center gap-1.5">
                <span id="vc_status" class="text-[#8696a0] text-[15px]">{{ $role === 'caller' ? 'Calling' : 'Connecting' }}</span>
                <span class="flex gap-0.5" id="vc_dots"><span class="vd1 text-[#8696a0]">.</span><span class="vd2 text-[#8696a0]">.</span><span class="vd3 text-[#8696a0]">.</span></span>
            </div>
        </div>

        <div class="top-grad"></div>
        <div class="absolute top-0 left-0 right-0 z-30 flex items-center justify-between px-5 pt-5">
            <div class="enc-badge inline-flex items-center gap-2 px-3 py-1.5 rounded-full">
                <svg class="w-3 h-3 text-[#00a884]" fill="currentColor" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                <span class="text-white/60 text-[11px] font-medium">End-to-end encrypted</span>
            </div>
            <div id="vc_timer" class="text-white text-[15px] font-medium tracking-wider hidden bg-black/30 backdrop-blur-sm px-3 py-1 rounded-full">00:00</div>
        </div>

        <!-- Participants Strip -->
        <div id="vc_participants" class="vc-participants hidden"></div>

        <div class="self-video-wrap" id="self_pip">
            <video id="self_video" autoplay playsinline muted></video>
            <div id="self_fallback" class="absolute inset-0 bg-[#202c33] flex items-center justify-center">
                <div class="w-16 h-16 rounded-full bg-[#2a3942] flex items-center justify-center text-[#8696a0]">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
            </div>
        </div>

        <div class="bot-grad"></div>
        <audio id="ringtone_audio" loop><source src="https://www.soundjay.com/phone/phone-calling-1.mp3" type="audio/mpeg"></audio>

        <div class="vc-controls">
            <div id="vc_conn_name" class="text-white text-lg font-medium mb-2 hidden">{{ $name }}</div>
            <div class="flex items-center justify-center gap-5">
                <button id="cam_btn" onclick="toggleCam()" class="vc-btn w-12 h-12 rounded-full bg-white/15 text-white flex items-center justify-center">
                    <svg id="cam_on" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>
                    <svg id="cam_off" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M21 6.5l-4 4V7c0-.55-.45-1-1-1H9.82L21 17.18V6.5zM3.27 2L2 3.27 4.73 6H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.21 0 .39-.08.54-.18L19.73 21 21 19.73 3.27 2z"/></svg>
                </button>
                <button id="vmute_btn" onclick="toggleVMute()" class="vc-btn w-12 h-12 rounded-full bg-white/15 text-white flex items-center justify-center">
                    <svg id="vm_off" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 14c1.66 0 2.99-1.34 2.99-3L15 5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3zm5.3-3c0 3-2.54 5.1-5.3 5.1S6.7 14 6.7 11H5c0 3.41 2.72 6.23 6 6.72V21h2v-3.28c3.28-.48 6-3.3 6-6.72h-1.7z"/></svg>
                    <svg id="vm_on" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M19 11h-1.7c0 .74-.16 1.43-.43 2.05l1.23 1.23c.56-.98.9-2.09.9-3.28zm-4.02.17c0-.06.02-.11.02-.17V5c0-1.66-1.34-3-3-3S9 3.34 9 5v.18l5.98 5.99zM4.27 3L3 4.27l6.01 6.01V11c0 1.66 1.33 3 2.99 3 .22 0 .44-.03.65-.08l1.66 1.66c-.71.33-1.5.52-2.31.52-2.76 0-5.3-2.1-5.3-5.1H5c0 3.41 2.72 6.23 6 6.72V21h2v-3.28c.91-.13 1.77-.45 2.54-.9L19.73 21 21 19.73 4.27 3z"/></svg>
                </button>
                <button onclick="openContactPicker()" class="vc-btn w-12 h-12 rounded-full bg-white/15 text-white flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </button>
                <button onclick="endVCall()" class="vc-end w-14 h-14 rounded-full bg-red-500 hover:bg-red-600 text-white flex items-center justify-center transition-all active:scale-90">
                    <svg class="w-7 h-7 rotate-[135deg]" fill="currentColor" viewBox="0 0 24 24"><path d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z"/></svg>
                </button>
                <button id="vspk_btn" onclick="toggleVSpk()" class="vc-btn w-12 h-12 rounded-full bg-white/15 text-white flex items-center justify-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Contact Picker Overlay -->
    <div id="contact_picker" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-end justify-center">
        <div class="w-full max-w-md bg-[#111b21] rounded-t-2xl max-h-[70vh] flex flex-col" style="animation:slideUp .3s ease">
            <style>@keyframes slideUp{from{transform:translateY(100%)}to{transform:translateY(0)}}</style>
            <div class="flex items-center justify-between px-5 py-4 border-b border-[#313d45]">
                <h3 class="text-white text-lg font-semibold">Add participant</h3>
                <button onclick="closeContactPicker()" class="text-[#8696a0] hover:text-white p-1"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            <div class="px-4 py-2"><input id="cp_search" type="text" placeholder="Search contacts..." oninput="filterContacts()" class="w-full bg-[#202c33] border-none rounded-lg px-4 py-2 text-sm text-[#d1d7db] placeholder-[#8696a0] focus:ring-1 focus:ring-[#00a884] outline-none"></div>
            <div class="flex-1 overflow-y-auto" id="cp_list">
                @foreach($users as $u)
                <div class="cp-item flex items-center gap-3 px-5 py-3 hover:bg-[#202c33] cursor-pointer transition-colors" data-name="{{ strtolower($u->name) }}" onclick="selectContact({{ $u->id }}, '{{ addslashes($u->name) }}', '{!! $u->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($u->name).'&background=2a3942&color=fff' !!}')">
                    <div class="w-10 h-10 rounded-full overflow-hidden bg-[#2a3942] shrink-0"><img src="{!! $u->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($u->name).'&background=2a3942&color=fff' !!}" class="w-full h-full object-cover"></div>
                    <div class="flex-1 min-w-0"><div class="text-[#e9edef] text-[15px] truncate">{{ $u->name }}</div><div class="text-[#8696a0] text-xs truncate">{{ $u->phone ?? '' }}</div></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

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
        const CALL_ID = "{{ $callId ?? '' }}";
        const CALLEE_ID = "{{ $calleeId ?? '' }}";
        const MY_USER_ID = {{ $myUserId }};
        const MY_NAME = "{{ $myName }}";
        const MY_AVATAR = "{!! $myAvatar !!}";
        const GROUP_CALL_ID = "{{ $groupCallId ?? '' }}";
        const OTHER_NAME = "{{ $name }}";
        const OTHER_AVATAR = "{!! $avatar !!}";

        const iceConfig = { iceServers: [
            { urls: 'stun:stun.l.google.com:19302' },
            { urls: 'stun:stun1.l.google.com:19302' },
            { urls: 'stun:stun2.l.google.com:19302' }
        ]};

        let pc = null, localStream = null, callSec = 0, timer = null, callId = CALL_ID, ended = false;
        let isMuted = false, isCamOff = false;
        let wasConnected = false, callLogSent = false;
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
                    sender_id: MY_USER_ID, type: 'call', call_type: 'video',
                    call_status: callStatus, call_duration: duration || 0,
                    text: '', time: now, status: 'sent'
                });
                
                const logData = {
                    type: 'video',
                    status: callStatus,
                    direction: ROLE === 'caller' ? 'outgoing' : 'incoming',
                    duration: duration || 0,
                    time: now,
                    other_user_id: otherUserId,
                    other_user_name: OTHER_NAME,
                    other_user_avatar: OTHER_AVATAR
                };
                await push(ref(db, `users/${MY_USER_ID}/call_logs`), logData);
            } catch(e) { console.error('Call log error:', e); }
        }

        async function init() {
            try {
                localStream = await navigator.mediaDevices.getUserMedia({ audio: true, video: { facingMode: 'user', width: { ideal: 640 }, height: { ideal: 480 } } });
                document.getElementById('self_video').srcObject = localStream;
                document.getElementById('self_fallback').classList.add('hidden');

                pc = new RTCPeerConnection(iceConfig);
                localStream.getTracks().forEach(t => pc.addTrack(t, localStream));

                pc.ontrack = (e) => {
                    document.getElementById('remote_video').srcObject = e.streams[0];
                };

                pc.oniceconnectionstatechange = () => {
                    const s = pc.iceConnectionState;
                    if (s === 'connected' || s === 'completed') onConnected();
                    else if ((s === 'failed' || s === 'disconnected' || s === 'closed') && !ended) endVCall();
                };

                if (ROLE === 'caller') await callerFlow();
                else await calleeFlow();
            } catch (err) {
                console.error('Init error:', err);
                document.getElementById('vc_status').textContent = 'Camera/Mic access denied';
                document.getElementById('vc_dots').classList.add('hidden');
            }
        }

        async function callerFlow() {
            callId = 'call_' + MY_USER_ID + '_' + CALLEE_ID + '_' + Date.now();
            pc.onicecandidate = (e) => { if (e.candidate) push(ref(db, `calls/${callId}/caller_candidates`), e.candidate.toJSON()); };

            const offer = await pc.createOffer();
            await pc.setLocalDescription(offer);

            await set(ref(db, `calls/${callId}`), {
                caller_id: MY_USER_ID, callee_id: parseInt(CALLEE_ID),
                caller_name: MY_NAME, caller_avatar: MY_AVATAR,
                callee_name: OTHER_NAME, callee_avatar: OTHER_AVATAR,
                type: 'video', status: 'calling',
                offer: { type: offer.type, sdp: offer.sdp }, created_at: Date.now()
            });

            document.getElementById('vc_status').textContent = 'Ringing';
            try { document.getElementById('ringtone_audio').play().catch(()=>{}); } catch(e) {}

            onValue(ref(db, `calls/${callId}/answer`), async (snap) => {
                const a = snap.val();
                if (a && pc.signalingState === 'have-local-offer') await pc.setRemoteDescription(new RTCSessionDescription(a));
            });

            onChildAdded(ref(db, `calls/${callId}/callee_candidates`), async (snap) => {
                try { await pc.addIceCandidate(new RTCIceCandidate(snap.val())); } catch(e) {}
            });

            onValue(ref(db, `calls/${callId}/status`), async (snap) => {
                const st = snap.val();
                if ((st === 'rejected' || st === 'ended') && !ended) {
                    ended = true;
                    if (st === 'ended' && wasConnected) await sendCallLog('completed', callSec);
                    document.getElementById('vc_status').textContent = st === 'rejected' ? 'Call declined' : 'Call ended';
                    document.getElementById('vc_dots').classList.add('hidden');
                    cleanup();
                    setTimeout(() => { window.location.href = '/chat'; }, 1500);
                }
            });
        }

        async function calleeFlow() {
            document.getElementById('vc_status').textContent = 'Connecting';
            const snap = await get(ref(db, `calls/${callId}`));
            const data = snap.val();
            if (data) {
                otherUserId = data.caller_id;
                if (data.group_call_id) {
                    groupId = data.group_call_id;
                    setupParticipantListener();
                }
            }
            if (!data || !data.offer) {
                document.getElementById('vc_status').textContent = 'Call not found';
                document.getElementById('vc_dots').classList.add('hidden');
                setTimeout(() => { window.location.href = '/chat'; }, 2000);
                return;
            }
            otherUserId = data.caller_id;

            await update(ref(db, `calls/${callId}`), { status: 'connected' });
            pc.onicecandidate = (e) => { if (e.candidate) push(ref(db, `calls/${callId}/callee_candidates`), e.candidate.toJSON()); };

            await pc.setRemoteDescription(new RTCSessionDescription(data.offer));
            const answer = await pc.createAnswer();
            await pc.setLocalDescription(answer);
            await update(ref(db, `calls/${callId}`), { answer: { type: answer.type, sdp: answer.sdp } });

            onChildAdded(ref(db, `calls/${callId}/caller_candidates`), async (snap) => {
                try { await pc.addIceCandidate(new RTCIceCandidate(snap.val())); } catch(e) {}
            });

            onValue(ref(db, `calls/${callId}/status`), (snap) => {
                if (snap.val() === 'ended' && !ended) {
                    ended = true;
                    document.getElementById('vc_status').textContent = 'Call ended';
                    document.getElementById('vc_dots').classList.add('hidden');
                    cleanup(); setTimeout(() => { window.location.href = '/chat'; }, 1500);
                }
            });
        }

        function onConnected() {
            wasConnected = true;
            try { document.getElementById('ringtone_audio').pause(); } catch(e) {}
            document.getElementById('vc_dots').classList.add('hidden');
            document.getElementById('vc_status').textContent = '';
            document.getElementById('vc_timer').classList.remove('hidden');
            document.getElementById('vc_conn_name').classList.remove('hidden');
            const ov = document.getElementById('waiting_overlay');
            ov.style.opacity = '0'; setTimeout(() => ov.style.display = 'none', 500);
            document.querySelectorAll('.vp-ring').forEach(r => r.style.animationPlayState = 'paused');
            timer = setInterval(() => {
                callSec++;
                document.getElementById('vc_timer').textContent = `${Math.floor(callSec/60).toString().padStart(2,'0')}:${(callSec%60).toString().padStart(2,'0')}`;
            }, 1000);
        }

        function cleanup() {
            clearInterval(timer);
            try { document.getElementById('ringtone_audio').pause(); } catch(e) {}
            if (localStream) localStream.getTracks().forEach(t => t.stop());
            if (pc) pc.close();
            Object.values(extraPeers).forEach(p => { try { p.close(); } catch(e) {} });
            extraPeers = {};
            if (groupId) { try { update(ref(db, `group_calls/${groupId}/participants/${MY_USER_ID}`), { status: 'left' }); } catch(e) {} }
        }

        window.endVCall = async function() {
            if (ended) return; ended = true;
            // Send call log
            if (ROLE === 'caller') {
                if (wasConnected) await sendCallLog('completed', callSec);
                else await sendCallLog('no_answer', 0);
            }
            if (callId) { try { await update(ref(db, `calls/${callId}`), { status: 'ended' }); setTimeout(async () => { try { await remove(ref(db, `calls/${callId}`)); } catch(e) {} }, 3000); } catch(e) {} }
            cleanup(); setTimeout(() => { window.location.href = '/chat'; }, 500);
        };

        window.toggleVMute = function() {
            isMuted = !isMuted;
            if (localStream) localStream.getAudioTracks().forEach(t => t.enabled = !isMuted);
            document.getElementById('vm_off').classList.toggle('hidden', isMuted);
            document.getElementById('vm_on').classList.toggle('hidden', !isMuted);
            document.getElementById('vmute_btn').classList.toggle('active', isMuted);
        };

        window.toggleCam = function() {
            isCamOff = !isCamOff;
            if (localStream) localStream.getVideoTracks().forEach(t => t.enabled = !isCamOff);
            document.getElementById('cam_on').classList.toggle('hidden', isCamOff);
            document.getElementById('cam_off').classList.toggle('hidden', !isCamOff);
            document.getElementById('cam_btn').classList.toggle('active', isCamOff);
            document.getElementById('self_fallback').classList.toggle('hidden', !isCamOff);
        };

        window.toggleVSpk = function() { document.getElementById('vspk_btn').classList.toggle('active'); };

        // PiP drag
        const pip = document.getElementById('self_pip');
        let drag=false, sx, sy, px, py;
        pip.addEventListener('mousedown', (e) => { drag=true; sx=e.clientX; sy=e.clientY; px=pip.offsetLeft; py=pip.offsetTop; pip.style.transition='none'; });
        document.addEventListener('mousemove', (e) => { if(!drag) return; pip.style.left=(px+e.clientX-sx)+'px'; pip.style.top=(py+e.clientY-sy)+'px'; pip.style.right='auto'; });
        document.addEventListener('mouseup', () => { if(drag){drag=false; pip.style.transition='all .3s ease';} });
        pip.addEventListener('touchstart', (e) => { drag=true; sx=e.touches[0].clientX; sy=e.touches[0].clientY; px=pip.offsetLeft; py=pip.offsetTop; pip.style.transition='none'; });
        document.addEventListener('touchmove', (e) => { if(!drag) return; pip.style.left=(px+e.touches[0].clientX-sx)+'px'; pip.style.top=(py+e.touches[0].clientY-sy)+'px'; pip.style.right='auto'; });
        document.addEventListener('touchend', () => { if(drag){drag=false; pip.style.transition='all .3s ease';} });

        window.addEventListener('beforeunload', () => { if(!ended && callId) cleanup(); });

        // === MULTI-PARTY: Connect to a new peer ===
        async function connectToPeer(remoteId) {
            if (extraPeers[remoteId] || remoteId == MY_USER_ID) return;
            const npc = new RTCPeerConnection(iceConfig);
            localStream.getTracks().forEach(t => npc.addTrack(t, localStream));
            npc.ontrack = (e) => {
                // Add extra remote video
                let vid = document.getElementById('rv_' + remoteId);
                if (!vid) {
                    vid = document.createElement('video'); vid.id = 'rv_' + remoteId;
                    vid.autoplay = true; vid.playsinline = true;
                    vid.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:5';
                    document.querySelector('.remote-video-wrap').appendChild(vid);
                }
                vid.srcObject = e.streams[0];
            };
            npc.oniceconnectionstatechange = () => {
                if (npc.iceConnectionState === 'connected' && !wasConnected) onConnected();
            };
            extraPeers[remoteId] = npc;
            const pairKey = `${Math.min(MY_USER_ID, remoteId)}_${Math.max(MY_USER_ID, remoteId)}`;
            const iAmInit = MY_USER_ID < remoteId;
            npc.onicecandidate = (e) => { if (e.candidate) push(ref(db, `group_calls/${groupId}/signaling/${pairKey}/${MY_USER_ID}_candidates`), e.candidate.toJSON()); };
            if (iAmInit) {
                const o = await npc.createOffer(); await npc.setLocalDescription(o);
                await set(ref(db, `group_calls/${groupId}/signaling/${pairKey}/offer`), { type: o.type, sdp: o.sdp });
                onValue(ref(db, `group_calls/${groupId}/signaling/${pairKey}/answer`), async (s) => {
                    if (s.val() && npc.signalingState === 'have-local-offer') await npc.setRemoteDescription(new RTCSessionDescription(s.val()));
                });
            } else {
                onValue(ref(db, `group_calls/${groupId}/signaling/${pairKey}/offer`), async (s) => {
                    if (!s.val() || npc.signalingState !== 'stable') return;
                    await npc.setRemoteDescription(new RTCSessionDescription(s.val()));
                    const a = await npc.createAnswer(); await npc.setLocalDescription(a);
                    await set(ref(db, `group_calls/${groupId}/signaling/${pairKey}/answer`), { type: a.type, sdp: a.sdp });
                });
            }
            onChildAdded(ref(db, `group_calls/${groupId}/signaling/${pairKey}/${remoteId}_candidates`), async (s) => {
                try { await npc.addIceCandidate(new RTCIceCandidate(s.val())); } catch(e) {}
            });
        }

        // === Update participant strip ===
        function updateParticipantStrip(data) {
            const strip = document.getElementById('vc_participants');
            if (!data || Object.keys(data).length <= 1) { strip.classList.add('hidden'); return; }
            strip.classList.remove('hidden');
            strip.innerHTML = '';
            Object.entries(data).forEach(([uid, p]) => {
                if (String(uid) === String(MY_USER_ID)) return;
                const url = p.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(p.name)}&background=2a3942&color=fff&size=72`;
                const el = document.createElement('div');
                el.className = 'vc-participant';
                el.innerHTML = `<img src="${url}" alt="${p.name}"><span>${p.name}</span>`;
                strip.appendChild(el);
            });
        }

        function setupParticipantListener() {
            if (participantListenerSet || !groupId) return;
            participantListenerSet = true;
            onChildAdded(ref(db, `group_calls/${groupId}/participants`), (snap) => {
                const uid = parseInt(snap.key);
                if (uid !== MY_USER_ID && !extraPeers[uid] && uid !== otherUserId) connectToPeer(uid);
            });
            onValue(ref(db, `group_calls/${groupId}/participants`), (snap) => {
                const data = snap.val();
                if (data) {
                    if (!data[MY_USER_ID]) ensureGroupCall();
                    updateParticipantStrip(data);
                }
            });
        }

        async function ensureGroupCall() {
            if (!groupId) groupId = 'gc_' + callId;
            const updates = {};
            updates[`group_calls/${groupId}/participants/${MY_USER_ID}`] = { name: MY_NAME, avatar: MY_AVATAR, status: 'connected' };
            if (otherUserId) {
                updates[`group_calls/${groupId}/participants/${otherUserId}`] = { name: OTHER_NAME, avatar: OTHER_AVATAR, status: 'connected' };
            }
            await update(ref(db), updates);
            await set(ref(db, `group_calls/${groupId}/type`), 'video');
            setupParticipantListener();
        }

        window.selectContact = async function(userId, name, avatar) {
            closeContactPicker();
            await ensureGroupCall();
            await set(ref(db, `group_calls/${groupId}/participants/${userId}`), { name, avatar, status: 'calling' });
            const inviteId = `gc_${groupId}_${userId}`;
            const opc = new RTCPeerConnection(iceConfig);
            localStream.getTracks().forEach(t => opc.addTrack(t, localStream));
            opc.ontrack = (e) => {
                let vid = document.getElementById('rv_' + userId);
                if (!vid) { vid = document.createElement('video'); vid.id = 'rv_' + userId; vid.autoplay = true; vid.playsinline = true; vid.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:5'; document.querySelector('.remote-video-wrap').appendChild(vid); }
                vid.srcObject = e.streams[0];
            };
            opc.oniceconnectionstatechange = () => { if (opc.iceConnectionState === 'connected') update(ref(db, `group_calls/${groupId}/participants/${userId}`), { status: 'connected' }); };
            extraPeers[userId] = opc;
            opc.onicecandidate = (e) => { if (e.candidate) push(ref(db, `calls/${inviteId}/caller_candidates`), e.candidate.toJSON()); };
            const offer = await opc.createOffer(); await opc.setLocalDescription(offer);
            await set(ref(db, `calls/${inviteId}`), {
                caller_id: MY_USER_ID, callee_id: userId, caller_name: MY_NAME, caller_avatar: MY_AVATAR,
                callee_name: name, callee_avatar: avatar, type: 'video', status: 'calling',
                group_call_id: groupId, offer: { type: offer.type, sdp: offer.sdp }, created_at: Date.now()
            });
            onValue(ref(db, `calls/${inviteId}/answer`), async (s) => { if (s.val() && opc.signalingState === 'have-local-offer') await opc.setRemoteDescription(new RTCSessionDescription(s.val())); });
            onChildAdded(ref(db, `calls/${inviteId}/callee_candidates`), async (s) => { try { await opc.addIceCandidate(new RTCIceCandidate(s.val())); } catch(e) {} });
            onValue(ref(db, `calls/${inviteId}/status`), (s) => { if (s.val() === 'rejected') { delete extraPeers[userId]; opc.close(); } });
            setupParticipantListener();
        };

        // Join group on connect
        const origConn = onConnected;
        onConnected = function() {
            origConn();
            ensureGroupCall();
        };

        window.openContactPicker = function() { document.getElementById('contact_picker').classList.remove('hidden'); };
        window.closeContactPicker = function() { document.getElementById('contact_picker').classList.add('hidden'); document.getElementById('cp_search').value = ''; filterContacts(); };
        window.filterContacts = function() {
            const q = document.getElementById('cp_search').value.toLowerCase();
            document.querySelectorAll('.cp-item').forEach(el => { el.style.display = el.dataset.name.includes(q) ? '' : 'none'; });
        };

        // Start!
        setupParticipantListener();
        init();
    </script>
</x-app-layout>
