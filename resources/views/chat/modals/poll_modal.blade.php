<!-- Poll Creation Modal -->
<div id="poll_modal" class="hidden fixed inset-0 z-[4000] flex items-center justify-center">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="window.closePollModal()"></div>
    
    <!-- Modal Content -->
    <div class="bg-[#1f2c34] w-[400px] max-w-[90vw] rounded-xl shadow-2xl relative z-10 flex flex-col max-h-[85vh] overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="poll_modal_content">
        <!-- Header -->
        <div class="flex items-center gap-4 p-4 border-b border-[#2a3942] bg-[#202c33]">
            <button onclick="window.closePollModal()" class="text-[#aebac1] hover:text-white transition-colors focus:outline-none">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path>
                </svg>
            </button>
            <h2 class="text-white text-[19px] font-medium">Create poll</h2>
        </div>

        <!-- Body -->
        <div class="p-5 flex-1 overflow-y-auto custom-scrollbar flex flex-col gap-5">
            <!-- Question Input -->
            <div class="flex flex-col gap-2">
                <label class="text-[#00a884] text-sm font-medium px-1">Ask question</label>
                <input type="text" id="poll_question" placeholder="Ask question" class="bg-[#2a3942] text-white px-4 py-3 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#00a884] placeholder-[#8696a0] text-base w-full" autocomplete="off">
            </div>

            <div class="w-full h-[1px] bg-[#2a3942] my-1"></div>

            <!-- Options Container -->
            <div class="flex flex-col gap-3">
                <label class="text-[#8696a0] text-sm font-medium px-1">Options</label>
                <div id="poll_options_container" class="flex flex-col gap-3">
                    <div class="flex items-center gap-3 group relative">
                        <input type="text" placeholder="Option 1" class="poll-option-input bg-[#2a3942] text-white px-4 py-2.5 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#00a884] placeholder-[#8696a0] flex-1 text-[15px]" oninput="window.handlePollOptionInput(this)" onkeydown="window.handlePollOptionKeydown(event, this)">
                        <button type="button" class="text-[#8696a0] hover:text-[#f15c6d] opacity-0 group-hover:opacity-100 transition-opacity absolute right-3 focus:outline-none" onclick="window.removePollOption(this)" title="Remove option">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path></svg>
                        </button>
                    </div>
                    <div class="flex items-center gap-3 group relative">
                        <input type="text" placeholder="Option 2" class="poll-option-input bg-[#2a3942] text-white px-4 py-2.5 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#00a884] placeholder-[#8696a0] flex-1 text-[15px]" oninput="window.handlePollOptionInput(this)" onkeydown="window.handlePollOptionKeydown(event, this)">
                        <button type="button" class="text-[#8696a0] hover:text-[#f15c6d] opacity-0 group-hover:opacity-100 transition-opacity absolute right-3 focus:outline-none" onclick="window.removePollOption(this)" title="Remove option">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="w-full h-[1px] bg-[#2a3942] mt-2 mb-1"></div>

            <!-- Settings -->
            <div class="flex items-center justify-between px-1">
                <span class="text-white text-[15.5px]">Allow multiple answers</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="poll_allow_multiple" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-[#8696a0]/30 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00a884]"></div>
                </label>
            </div>
        </div>

        <!-- Footer / Send Button -->
        <div class="p-4 bg-[#202c33] flex justify-end">
            <button onclick="window.sendPollMessage()" id="poll_send_btn" class="bg-[#00a884] text-[#111b21] p-3 rounded-full hover:bg-[#00bfa5] transition-colors focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed shadow-md" disabled>
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="translate-x-[2px]">
                    <path d="M1.101 21.757L23.8 12.028 1.101 2.3l.011 7.912 13.623 1.816-13.623 1.817-.011 7.912z"></path>
                </svg>
            </button>
        </div>
    </div>
</div>

<style>
    #poll_modal.show #poll_modal_content {
        transform: scale(1);
        opacity: 1;
    }
</style>

<script>
    window.openPollModal = function() {
        const modal = document.getElementById('poll_modal');
        modal.classList.remove('hidden');
        
        // Reset fields
        document.getElementById('poll_question').value = '';
        document.getElementById('poll_allow_multiple').checked = true;
        
        const container = document.getElementById('poll_options_container');
        container.innerHTML = `
            <div class="flex items-center gap-3 group relative">
                <input type="text" placeholder="Option 1" class="poll-option-input bg-[#2a3942] text-white px-4 py-2.5 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#00a884] placeholder-[#8696a0] flex-1 text-[15px]" oninput="window.handlePollOptionInput(this)" onkeydown="window.handlePollOptionKeydown(event, this)">
                <button type="button" class="text-[#8696a0] hover:text-[#f15c6d] opacity-0 group-hover:opacity-100 transition-opacity absolute right-3 focus:outline-none" onclick="window.removePollOption(this)" title="Remove option">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path></svg>
                </button>
            </div>
            <div class="flex items-center gap-3 group relative">
                <input type="text" placeholder="Option 2" class="poll-option-input bg-[#2a3942] text-white px-4 py-2.5 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#00a884] placeholder-[#8696a0] flex-1 text-[15px]" oninput="window.handlePollOptionInput(this)" onkeydown="window.handlePollOptionKeydown(event, this)">
                <button type="button" class="text-[#8696a0] hover:text-[#f15c6d] opacity-0 group-hover:opacity-100 transition-opacity absolute right-3 focus:outline-none" onclick="window.removePollOption(this)" title="Remove option">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path></svg>
                </button>
            </div>
            <div class="flex items-center gap-3 group relative">
                <input type="text" placeholder="+ Add option" class="poll-option-input bg-[#2a3942] text-white px-4 py-2.5 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#00a884] placeholder-[#8696a0] flex-1 text-[15px]" oninput="window.handlePollOptionInput(this)" onkeydown="window.handlePollOptionKeydown(event, this)">
                <button type="button" class="text-[#8696a0] hover:text-[#f15c6d] opacity-0 group-hover:opacity-100 transition-opacity absolute right-3 focus:outline-none" onclick="window.removePollOption(this)" title="Remove option">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path></svg>
                </button>
            </div>
        `;
        window.updatePollOptionsPlaceholders();
        window.checkPollValidity();

        // Close attach menu
        if (typeof toggleAttachMenu === 'function') {
            const menu = document.getElementById('attach_menu');
            if (menu && !menu.classList.contains('hidden')) toggleAttachMenu();
        }

        setTimeout(() => {
            modal.classList.add('show');
            document.getElementById('poll_question').focus();
        }, 10);
    };

    window.closePollModal = function() {
        const modal = document.getElementById('poll_modal');
        modal.classList.remove('show');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    };

    window.updatePollOptionsPlaceholders = function() {
        const inputs = document.querySelectorAll('.poll-option-input');
        inputs.forEach((input, index) => {
            if (index === inputs.length - 1) {
                input.placeholder = "+ Add option";
            } else {
                input.placeholder = "Option " + (index + 1);
            }
        });
    };

    window.handlePollOptionInput = function(inputEl) {
        const container = document.getElementById('poll_options_container');
        const inputs = Array.from(document.querySelectorAll('.poll-option-input'));
        const index = inputs.indexOf(inputEl);
        
        // If typing in the last input, add a new one below it
        if (index === inputs.length - 1 && inputEl.value.trim() !== '') {
            if (inputs.length < 12) { // max 12 options
                const newOption = document.createElement('div');
                newOption.className = "flex items-center gap-3 group relative";
                newOption.innerHTML = `
                    <input type="text" class="poll-option-input bg-[#2a3942] text-white px-4 py-2.5 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#00a884] placeholder-[#8696a0] flex-1 text-[15px]" oninput="window.handlePollOptionInput(this)" onkeydown="window.handlePollOptionKeydown(event, this)">
                    <button type="button" class="text-[#8696a0] hover:text-[#f15c6d] opacity-0 group-hover:opacity-100 transition-opacity absolute right-3 focus:outline-none" onclick="window.removePollOption(this)" title="Remove option">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path></svg>
                    </button>
                `;
                container.appendChild(newOption);
                window.updatePollOptionsPlaceholders();
            }
        }
        
        window.checkPollValidity();
    };
    
    window.handlePollOptionKeydown = function(e, inputEl) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const inputs = Array.from(document.querySelectorAll('.poll-option-input'));
            const index = inputs.indexOf(inputEl);
            if (index < inputs.length - 1) {
                inputs[index + 1].focus();
            } else if (inputEl.value.trim() !== '') {
                // If it's the last input and it has value, handlePollOptionInput will have created a new one, focus it
                setTimeout(() => {
                    const newInputs = document.querySelectorAll('.poll-option-input');
                    if (newInputs.length > inputs.length) {
                        newInputs[newInputs.length - 1].focus();
                    }
                }, 10);
            }
        }
    };

    window.removePollOption = function(btnEl) {
        const container = document.getElementById('poll_options_container');
        const options = container.querySelectorAll('.poll-option-input');
        if (options.length <= 3) {
            // keep at least 2 + 1 empty
            const wrapper = btnEl.closest('.flex');
            wrapper.querySelector('input').value = '';
            window.checkPollValidity();
            return;
        }
        
        const wrapper = btnEl.closest('.flex');
        wrapper.remove();
        window.updatePollOptionsPlaceholders();
        window.checkPollValidity();
    };

    window.checkPollValidity = function() {
        const question = document.getElementById('poll_question').value.trim();
        const inputs = document.querySelectorAll('.poll-option-input');
        let filledCount = 0;
        inputs.forEach(input => {
            if (input.value.trim() !== '') filledCount++;
        });
        
        const sendBtn = document.getElementById('poll_send_btn');
        if (question && filledCount >= 2) {
            sendBtn.disabled = false;
        } else {
            sendBtn.disabled = true;
        }
    };

    document.getElementById('poll_question').addEventListener('input', window.checkPollValidity);

    window.sendPollMessage = async function() {
        if (!window.currentChatId) return;
        
        const sendBtn = document.getElementById('poll_send_btn');
        if (sendBtn.disabled) return;
        
        const question = document.getElementById('poll_question').value.trim();
        const allowMultiple = document.getElementById('poll_allow_multiple').checked;
        
        const inputs = document.querySelectorAll('.poll-option-input');
        let options = [];
        let idCounter = 1;
        inputs.forEach(input => {
            const val = input.value.trim();
            if (val !== '') {
                options.push({
                    id: 'opt_' + idCounter,
                    text: val,
                    votes: {}
                });
                idCounter++;
            }
        });
        
        if (question === '' || options.length < 2) return;
        
        const msgData = {
            type: 'poll',
            text: question, // using text field for question text so search works easily
            poll_options: options,
            poll_allow_multiple: allowMultiple,
            sender_id: window.myUserId,
            time: Math.floor(Date.now() / 1000),
            status: 'sent'
        };
        
        if (window.replyingToKey) {
            msgData.reply_to_id = window.replyingToKey;
            msgData.reply_to_text = window.replyingToText || (window.globalMessages[window.replyingToKey]?.text || 'Media');
            msgData.reply_to_name = window.replyingToName || 'Member';
            msgData.reply_to_media = window.replyingToMedia || null;
        }

        window.closePollModal();
        
        const isGroup = window.currentChatId.startsWith('group_');
        let path = '';
        if (isGroup) {
            let firebaseChatId = window.currentChatId;
            if (firebaseChatId.startsWith('group_group_')) firebaseChatId = firebaseChatId.substring(6);
            path = `groups/${firebaseChatId}/messages`;
        } else {
            path = `chats/${window.currentChatId}/messages`;
        }
        
        try {
            await window.push(window.ref(window.db, path), msgData);
            if (!isGroup) {
                window.update(window.ref(window.db, `chats/${window.currentChatId}`), {
                    'last_message': '📊 Poll: ' + question,
                    'updated_at': Math.floor(Date.now() / 1000)
                });
            }
            if (typeof window.cancelReply === 'function') window.cancelReply();
        } catch (e) {
            console.error("Failed to send poll", e);
        }
    };
    window.votePoll = async function(msgKey, optionId, allowMultiple) {
        if (!window.currentChatId) return;
        
        const isGroup = window.currentChatId.startsWith('group_');
        let path = '';
        if (isGroup) {
            let firebaseChatId = window.currentChatId;
            if (firebaseChatId.startsWith('group_group_')) firebaseChatId = firebaseChatId.substring(6);
            path = `groups/${firebaseChatId}/messages/${msgKey}`;
        } else {
            path = `chats/${window.currentChatId}/messages/${msgKey}`;
        }
        
        try {
            // We need to fetch the current message to update it
            const msgRef = window.ref(window.db, path);
            const snapshot = await window.get(msgRef);
            if (!snapshot.exists()) return;
            
            const msgData = snapshot.val();
            if (msgData.type !== 'poll') return;
            
            let options = msgData.poll_options || [];
            let myUserId = window.myUserId;
            
            // If not allowMultiple, remove user's vote from all other options
            if (!allowMultiple) {
                options.forEach(opt => {
                    if (opt.id !== optionId && opt.votes && opt.votes[myUserId]) {
                        delete opt.votes[myUserId];
                    }
                });
            }
            
            // Toggle vote on the selected option
            let optIndex = options.findIndex(o => o.id === optionId);
            if (optIndex > -1) {
                let opt = options[optIndex];
                if (!opt.votes) opt.votes = {};
                
                if (opt.votes[myUserId]) {
                    delete opt.votes[myUserId];
                } else {
                    opt.votes[myUserId] = {
                        time: Math.floor(Date.now() / 1000)
                    };
                }
            }
            
            // Push updated options back to Firebase
            await window.update(msgRef, {
                poll_options: options
            });
            
        } catch (e) {
            console.error("Failed to vote on poll", e);
        }
    };
</script>
