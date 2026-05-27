<x-app-layout>
    @push('styles')
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                margin: 0;
                overflow: hidden
            }

            .vc-container {
                position: relative;
                width: 100%;
                height: 100vh;
                background: #0b141a;
                overflow: hidden
            }

            .remote-video-grid {
                position: absolute;
                inset: 0;
                display: grid;
                gap: 2px;
                background: #0b141a;
                transition: all 0.5s ease
            }

            .remote-video-grid.grid-1 {
                grid-template-columns: 1fr;
                grid-template-rows: 1fr;
            }

            .remote-video-grid.grid-2 {
                grid-template-columns: 1fr;
                grid-template-rows: 1fr 1fr;
            }

            .remote-video-grid.grid-3 {
                grid-template-columns: 1fr 1fr;
                grid-template-rows: 1fr 1fr;
            }

            .remote-video-grid.grid-3>div:first-child {
                grid-column: 1 / span 2;
            }

            .remote-video-grid.grid-4 {
                grid-template-columns: 1fr 1fr;
                grid-template-rows: 1fr 1fr;
            }

            .remote-video-grid.grid-5,
            .remote-video-grid.grid-6 {
                grid-template-columns: 1fr 1fr;
                grid-template-rows: 1fr 1fr 1fr;
            }

            .video-box {
                position: relative;
                width: 100%;
                height: 100%;
                background: #1a2e38;
                overflow: hidden
            }

            .video-box video {
                width: 100%;
                height: 100%;
                object-fit: cover
            }

            .video-box .name-tag {
                position: absolute;
                bottom: 10px;
                left: 10px;
                background: rgba(0, 0, 0, 0.5);
                color: white;
                padding: 2px 8px;
                border-radius: 4px;
                font-size: 12px;
                z-index: 10
            }

            .self-video-wrap {
                position: absolute;
                top: 80px;
                right: 20px;
                width: 120px;
                height: 160px;
                border-radius: 16px;
                overflow: hidden;
                background: #202c33;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
                border: 1px solid rgba(255, 255, 255, 0.1);
                z-index: 40;
                cursor: grab
            }

            .self-video-wrap video {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transform: scaleX(-1)
            }

            .top-grad {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 140px;
                background: linear-gradient(to bottom, rgba(0, 0, 0, 0.6), transparent);
                z-index: 20;
                pointer-events: none
            }

            .bot-grad {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                height: 280px;
                background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
                z-index: 20;
                pointer-events: none
            }

            .vc-controls {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 25;
                padding: 24px 32px 48px;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 16px
            }

            .vc-btn {
                backdrop-filter: blur(20px);
                transition: all .3s cubic-bezier(.4, 0, .2, 1)
            }

            .vc-btn:hover {
                transform: scale(1.1);
                background: rgba(255, 255, 255, 0.3)
            }

            .vc-btn:active {
                transform: scale(0.95)
            }

            .vc-btn.active {
                background: white;
                color: #111b21
            }

            .vc-end {
                box-shadow: 0 0 30px rgba(239, 68, 68, 0.3), 0 4px 20px rgba(0, 0, 0, 0.3)
            }

            .vp-ring {
                position: absolute;
                border-radius: 50%;
                border: 1px solid rgba(0, 168, 132, 0.15);
                animation: vpe 3s ease-out infinite
            }

            .vp-ring:nth-child(1) {
                animation-delay: 0s
            }

            .vp-ring:nth-child(2) {
                animation-delay: 1s
            }

            .vp-ring:nth-child(3) {
                animation-delay: 2s
            }

            @keyframes vpe {
                0% {
                    width: 140px;
                    height: 140px;
                    opacity: .6
                }

                100% {
                    width: 350px;
                    height: 350px;
                    opacity: 0
                }
            }

            @keyframes vdb {

                0%,
                80%,
                100% {
                    opacity: .3
                }

                40% {
                    opacity: 1
                }
            }

            .vd1 {
                animation: vdb 1.4s ease-in-out infinite
            }

            .vd2 {
                animation: vdb 1.4s ease-in-out .2s infinite
            }

            .vd3 {
                animation: vdb 1.4s ease-in-out .4s infinite
            }

            .wait-overlay {
                position: absolute;
                inset: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                z-index: 15;
                transition: opacity .5s ease
            }

            .enc-badge {
                background: rgba(0, 0, 0, 0.3);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.08)
            }

            .vc-participants {
                position: absolute;
                top: 60px;
                left: 50%;
                transform: translateX(-50%);
                z-index: 30;
                display: flex;
                gap: 8px;
                padding: 8px 16px;
                background: rgba(0, 0, 0, 0.4);
                backdrop-filter: blur(12px);
                border-radius: 20px;
                border: 1px solid rgba(255, 255, 255, 0.1)
            }

            .vc-participant {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 3px;
                animation: vcpIn .3s cubic-bezier(.34, 1.56, .64, 1)
            }

            @keyframes vcpIn {
                from {
                    transform: scale(0);
                    opacity: 0
                }

                to {
                    transform: scale(1);
                    opacity: 1
                }
            }

            .vc-participant img {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid rgba(0, 168, 132, 0.5)
            }

            .vc-participant span {
                color: #d1d7db;
                font-size: 9px;
                max-width: 50px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap
            }
        </style>
    @endpush

    <div class="vc-container font-['Inter'] select-none">
        <div id="video_grid" class="remote-video-grid grid-1">
            <!-- Self video box -->
            <div id="box_self" class="video-box">
                <video id="self_video" autoplay playsinline muted></video>
                <div class="name-tag">You</div>
                <div id="self_fallback" class="absolute inset-0 bg-[#202c33] flex items-center justify-center hidden">
                    <div class="w-16 h-16 rounded-full bg-[#2a3942] flex items-center justify-center text-[#8696a0]">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
            </div>
            <!-- Remote videos dynamically added here -->
        </div>

        <div class="wait-overlay" id="waiting_overlay">
            <h1 class="text-white text-[28px] font-semibold mb-2">{{ $name }}</h1>
            <div class="flex items-center gap-1.5">
                <span id="vc_status"
                    class="text-[#8696a0] text-[15px]">{{ $role === 'caller' ? 'Calling Group' : 'Connecting' }}</span>
                <span class="flex gap-0.5" id="vc_dots"><span class="vd1 text-[#8696a0]">.</span><span
                        class="vd2 text-[#8696a0]">.</span><span class="vd3 text-[#8696a0]">.</span></span>
            </div>
        </div>

        <div class="top-grad"></div>
        <div class="absolute top-0 left-0 right-0 z-30 flex items-center justify-between px-5 pt-5">
            <div class="enc-badge inline-flex items-center gap-2 px-3 py-1.5 rounded-full">
                <svg class="w-3 h-3 text-[#00a884]" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z" />
                </svg>
                <span class="text-white/60 text-[11px] font-medium">End-to-end encrypted</span>
            </div>
            <div id="vc_timer"
                class="text-white text-[15px] font-medium tracking-wider hidden bg-black/30 backdrop-blur-sm px-3 py-1 rounded-full">
                00:00</div>
        </div>
        <div id="vc_participants" class="vc-participants hidden"></div>
        <div class="bot-grad"></div>
        <audio id="ringtone_audio" loop>
            <source src="https://www.soundjay.com/phone/phone-calling-1.mp3" type="audio/mpeg">
        </audio>

        <div class="vc-controls">
            <div id="vc_conn_name" class="text-white text-lg font-medium mb-2 hidden">{{ $name }}</div>
            <div class="flex items-center justify-center gap-5">
                <button id="cam_btn" onclick="toggleCam()"
                    class="vc-btn w-12 h-12 rounded-full bg-white/15 text-white flex items-center justify-center"><svg
                        id="cam_on" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z" />
                    </svg><svg id="cam_off" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M21 6.5l-4 4V7c0-.55-.45-1-1-1H9.82L21 17.18V6.5zM3.27 2L2 3.27 4.73 6H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.21 0 .39-.08.54-.18L19.73 21 21 19.73 3.27 2z" />
                    </svg></button>
                <button id="vmute_btn" onclick="toggleVMute()"
                    class="vc-btn w-12 h-12 rounded-full bg-white/15 text-white flex items-center justify-center"><svg
                        id="vm_off" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 14c1.66 0 2.99-1.34 2.99-3L15 5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3zm5.3-3c0 3-2.54 5.1-5.3 5.1S6.7 14 6.7 11H5c0 3.41 2.72 6.23 6 6.72V21h2v-3.28c3.28-.48 6-3.3 6-6.72h-1.7z" />
                    </svg><svg id="vm_on" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M19 11h-1.7c0 .74-.16 1.43-.43 2.05l1.23 1.23c.56-.98.9-2.09.9-3.28zm-4.02.17c0-.06.02-.11.02-.17V5c0-1.66-1.34-3-3-3S9 3.34 9 5v.18l5.98 5.99zM4.27 3L3 4.27l6.01 6.01V11c0 1.66 1.33 3 2.99 3 .22 0 .44-.03.65-.08l1.66 1.66c-.71.33-1.5.52-2.31.52-2.76 0-5.3-2.1-5.3-5.1H5c0 3.41 2.72 6.23 6 6.72V21h2v-3.28c.91-.13 1.77-.45 2.54-.9L19.73 21 21 19.73 4.27 3z" />
                    </svg></button>
                <button onclick="openContactPicker()"
                    class="vc-btn w-12 h-12 rounded-full bg-white/15 text-white flex items-center justify-center"><svg
                        class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg></button>
                <button onclick="endVCall()"
                    class="vc-end w-14 h-14 rounded-full bg-red-500 hover:bg-red-600 text-white flex items-center justify-center transition-all active:scale-90"><svg
                        class="w-7 h-7 rotate-[135deg]" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M20 15.5c-1.2 0-2.4-.2-3.6-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.4-5.1-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H5c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z" />
                    </svg></button>
                <button id="vspk_btn" onclick="toggleVSpk()"
                    class="vc-btn w-12 h-12 rounded-full bg-white/15 text-white flex items-center justify-center"><svg
                        class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z" />
                    </svg></button>
            </div>
        </div>
    </div>

    <!-- Contact Picker -->
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
                @foreach($users as $u)
                    <div class="cp-item flex items-center gap-3 px-5 py-3 hover:bg-[#202c33] cursor-pointer transition-colors"
                        data-name="{{ strtolower($u->name) }}"
                        onclick="selectContact({{ $u->id }}, '{{ addslashes($u->name) }}', '{!! $u->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($u->name) . '&background=2a3942&color=fff' !!}')">
                        <div class="w-10 h-10 rounded-full overflow-hidden bg-[#2a3942] shrink-0"><img
                                src="{!! $u->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($u->name) . '&background=2a3942&color=fff' !!}"
                                class="w-full h-full object-cover"></div>
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

        const ROLE = "{{ $role }}", MY_USER_ID = {{ $myUserId }}, MY_NAME = "{{ $myName }}", MY_AVATAR = "{!! $myAvatar !!}", GROUP_CALL_ID = "{{ $groupCallId ?? '' }}", GROUP_ID = "{{ $groupId ?? '' }}", OTHER_NAME = "{{ $name }}", OTHER_AVATAR = "{!! $avatar !!}";
        const iceConfig = { iceServers: [{ urls: 'stun:stun.l.google.com:19302' }, { urls: 'stun:stun1.l.google.com:19302' }] };

        let localStream = null, callSec = 0, timer = null, callId = null, ended = false, wasConnected = false, startTime = Date.now();
        let isMuted = false, isCamOff = false, otherUserId = 0, groupId = GROUP_CALL_ID || (GROUP_ID ? 'gc_' + GROUP_ID + '_' + Date.now() : null);
        let extraPeers = {}, participantListenerSet = false;

        async function init() {
            try {
                localStream = await navigator.mediaDevices.getUserMedia({ audio: true, video: { facingMode: 'user' } });
                console.log("Local stream obtained");
                document.getElementById('self_video').srcObject = localStream;

                if (ROLE === 'caller') await startGroupCall();
                else await startAsCallee();
                updateGridLayout();
            } catch (err) {
                console.error('Init error:', err);
                document.getElementById('vc_status').textContent = 'Access denied';
            }
        }

        async function startGroupCall() {
            if (!groupId) groupId = 'gc_' + MY_USER_ID + '_' + Date.now();
            document.getElementById('vc_status').textContent = 'Calling Group';
            ensureGroupCall();
            const targets = new URLSearchParams(window.location.search).get('participants');
            if (targets) { targets.split(',').forEach(tid => { if (tid != MY_USER_ID) inviteToGroup(tid); }); }
        }

        async function inviteToGroup(targetId) {
            const inviteId = `gc_${groupId}_${targetId}`;
            // Only create the call notification node.
            // The actual WebRTC connection will be handled by connectToPeer via the mesh signaling path once they join the room.
            await set(ref(db, `calls/${inviteId}`), {
                caller_id: MY_USER_ID, callee_id: parseInt(targetId),
                caller_name: MY_NAME, caller_avatar: MY_AVATAR,
                type: 'video', status: 'calling', group_call_id: groupId,
                created_at: Date.now()
            });
        }

        async function startAsCallee() {
            callId = new URLSearchParams(window.location.search).get('call_id');
            const snap = await get(ref(db, `calls/${callId}`));
            const data = snap.val();
            if (data && data.group_call_id) {
                groupId = data.group_call_id;
                console.log("Joined as callee for group:", groupId);
                ensureGroupCall();
                await update(ref(db, `calls/${callId}`), { status: 'connected' });
            }
        }

        function onConnected() {
            if (wasConnected) return; wasConnected = true;
            document.getElementById('vc_dots').classList.add('hidden');
            document.getElementById('vc_status').textContent = '';
            document.getElementById('vc_timer').classList.remove('hidden');
            document.getElementById('vc_conn_name').classList.remove('hidden');
            const ov = document.getElementById('waiting_overlay');
            ov.style.opacity = '0'; setTimeout(() => ov.style.display = 'none', 500);
            timer = setInterval(() => { callSec++; document.getElementById('vc_timer').textContent = `${Math.floor(callSec / 60).toString().padStart(2, '0')}:${(callSec % 60).toString().padStart(2, '0')}`; }, 1000);
        }

        async function ensureGroupCall() {
            await set(ref(db, `group_calls/${groupId}/participants/${MY_USER_ID}`), {
                name: MY_NAME,
                avatar: MY_AVATAR,
                status: 'connected',
                joined_at: Date.now()
            });
            await set(ref(db, `group_calls/${groupId}/type`), 'video');
            setupParticipantListener();
        }

        function setupParticipantListener() {
            if (participantListenerSet || !groupId) return;
            participantListenerSet = true;

            // Listen for anyone who joins the group call participants node
            onChildAdded(ref(db, `group_calls/${groupId}/participants`), (snap) => {
                const uid = parseInt(snap.key);
                if (uid !== MY_USER_ID) {
                    console.log("Establishing mesh connection with participant:", uid);
                    connectToPeer(uid);
                }
            });

            onValue(ref(db, `group_calls/${groupId}/participants`), (snap) => {
                const data = snap.val() || {};
                if (!data[MY_USER_ID]) ensureGroupCall();
                updateParticipantStrip(data);
                updateParticipantNames(data);

                // Cleanup removed participants
                const boxes = document.querySelectorAll('.video-box[id^="box_"]');
                boxes.forEach(box => {
                    const uid = box.id.replace('box_', '');
                    if (uid === 'self') return;
                    if (!data[uid] || data[uid].status === 'left') {
                        box.remove();
                        if (extraPeers[uid]) {
                            extraPeers[uid].close();
                            delete extraPeers[uid];
                        }
                    }
                });
                updateGridLayout();
            });
        }

        async function connectToPeer(remoteId) {
            if (extraPeers[remoteId] || remoteId == MY_USER_ID) return;
            const npc = new RTCPeerConnection(iceConfig);
            extraPeers[remoteId] = npc;

            localStream.getTracks().forEach(t => npc.addTrack(t, localStream));

            npc.ontrack = (e) => {
                console.log("Received mesh track from:", remoteId);
                createVideoBox(remoteId, e.streams[0]);
            };

            const pairKey = MY_USER_ID < remoteId ? `${MY_USER_ID}_${remoteId}` : `${remoteId}_${MY_USER_ID}`;
            const iAmInit = MY_USER_ID < remoteId;
            const signalingRef = ref(db, `group_calls/${groupId}/signaling/${pairKey}`);

            if (iAmInit) await remove(signalingRef); // Clear old signaling data

            npc.onicecandidate = (e) => {
                if (e.candidate) {
                    push(ref(db, `group_calls/${groupId}/signaling/${pairKey}/${MY_USER_ID}_candidates`), e.candidate.toJSON());
                }
            };

            npc.oniceconnectionstatechange = () => {
                console.log(`Mesh with ${remoteId} state:`, npc.iceConnectionState);
                if (npc.iceConnectionState === 'connected' || npc.iceConnectionState === 'completed') onConnected();
            };

            if (iAmInit) {
                const offer = await npc.createOffer();
                await npc.setLocalDescription(offer);
                await set(ref(db, `group_calls/${groupId}/signaling/${pairKey}/offer`), { type: offer.type, sdp: offer.sdp });

                onValue(ref(db, `group_calls/${groupId}/signaling/${pairKey}/answer`), async (s) => {
                    if (s.val() && npc.signalingState === 'have-local-offer') {
                        await npc.setRemoteDescription(new RTCSessionDescription(s.val()));
                    }
                });
            } else {
                onValue(ref(db, `group_calls/${groupId}/signaling/${pairKey}/offer`), async (s) => {
                    if (s.val() && npc.signalingState === 'stable') {
                        await npc.setRemoteDescription(new RTCSessionDescription(s.val()));
                        const answer = await npc.createAnswer();
                        await npc.setLocalDescription(answer);
                        await set(ref(db, `group_calls/${groupId}/signaling/${pairKey}/answer`), { type: answer.type, sdp: answer.sdp });
                    }
                });
            }

            onChildAdded(ref(db, `group_calls/${groupId}/signaling/${pairKey}/${remoteId}_candidates`), async (s) => {
                try { await npc.addIceCandidate(new RTCIceCandidate(s.val())); } catch (e) { }
            });
        }

        function createVideoBox(remoteId, stream) {
            let box = document.getElementById('box_' + remoteId);
            if (!box) {
                box = document.createElement('div');
                box.id = 'box_' + remoteId;
                box.className = 'video-box';

                const vid = document.createElement('video');
                vid.id = 'rv_' + remoteId;
                vid.autoplay = true;
                vid.playsinline = true;

                const nameTag = document.createElement('div');
                nameTag.className = 'name-tag';
                nameTag.textContent = 'Member';

                box.appendChild(vid);
                box.appendChild(nameTag);
                document.getElementById('video_grid').appendChild(box);
            }
            const v = document.getElementById('rv_' + remoteId);
            if (v && v.srcObject !== stream) v.srcObject = stream;
            updateGridLayout();
        }

        function updateGridLayout() {
            const grid = document.getElementById('video_grid');
            const boxes = grid.querySelectorAll('.video-box');
            const count = boxes.length;

            grid.className = 'remote-video-grid';
            if (count <= 1) grid.classList.add('grid-1');
            else if (count === 2) grid.classList.add('grid-2');
            else if (count === 3) grid.classList.add('grid-3');
            else if (count === 4) grid.classList.add('grid-4');
            else grid.classList.add('grid-5');
        }


        function updateParticipantNames(participants) {
            Object.entries(participants).forEach(([uid, data]) => {
                const box = document.getElementById('box_' + uid);
                if (box) {
                    const tag = box.querySelector('.name-tag');
                    if (tag) tag.textContent = data.name;
                }
                if (uid == otherUserId) {
                    const mainTag = document.getElementById('remote_name_tag');
                    if (mainTag) mainTag.textContent = data.name;
                }
            });
        }

        function updateParticipantStrip(data) {
            const strip = document.getElementById('vc_participants');
            if (!data || Object.keys(data).length <= 1) { strip.classList.add('hidden'); return; }
            strip.classList.remove('hidden'); strip.innerHTML = '';
            Object.entries(data).forEach(([uid, p]) => {
                if (String(uid) === String(MY_USER_ID)) return;
                const url = p.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(p.name)}&background=2a3942&color=fff&size=72`;
                const el = document.createElement('div');
                el.className = 'vc-participant';
                el.innerHTML = `<img src="${url}" alt="${p.name}"><span>${p.name}</span>`;
                strip.appendChild(el);
            });
        }

        window.endVCall = function () { ended = true; const dur = Math.floor((Date.now() - startTime) / 1000); sendCallLog('completed', dur); cleanup(); if (groupId) update(ref(db, `group_calls/${groupId}/participants/${MY_USER_ID}`), { status: 'left' }); window.location.href = '/chat'; };
        async function sendCallLog(status, duration) {
            if (ROLE !== 'caller' || !GROUP_ID) return;
            const now = Math.floor(Date.now() / 1000);
            try {
                await push(ref(db, `groups/${GROUP_ID}/messages`), {
                    sender_id: MY_USER_ID, sender_name: MY_NAME,
                    type: 'call', call_type: 'video', call_status: status,
                    call_duration: duration, text: '', time: now, status: 'sent'
                });
                
                const logData = {
                    type: 'video',
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
            } catch (e) { }
        }
        function cleanup() { clearInterval(timer); if (localStream) localStream.getTracks().forEach(t => t.stop()); Object.values(extraPeers).forEach(p => p.close()); }
        window.toggleVMute = function () { isMuted = !isMuted; localStream.getAudioTracks().forEach(t => t.enabled = !isMuted); document.getElementById('vm_off').classList.toggle('hidden', isMuted); document.getElementById('vm_on').classList.toggle('hidden', !isMuted); document.getElementById('vmute_btn').classList.toggle('active', isMuted); };
        window.toggleCam = function () { isCamOff = !isCamOff; localStream.getVideoTracks().forEach(t => t.enabled = !isCamOff); document.getElementById('cam_on').classList.toggle('hidden', isCamOff); document.getElementById('cam_off').classList.toggle('hidden', !isCamOff); document.getElementById('cam_btn').classList.toggle('active', isCamOff); document.getElementById('self_fallback').classList.toggle('hidden', !isCamOff); };
        window.toggleVSpk = function () { document.getElementById('vspk_btn').classList.toggle('active'); };
        window.openContactPicker = function () { document.getElementById('contact_picker').classList.remove('hidden'); };
        window.closeContactPicker = function () { document.getElementById('contact_picker').classList.add('hidden'); };
        window.selectContact = function (uid, name, avatar) { if (!extraPeers[uid]) inviteToGroup(uid); closeContactPicker(); };

        init();
        window.addEventListener('beforeunload', () => { if (!ended) endVCall(); });
    </script>
</x-app-layout>