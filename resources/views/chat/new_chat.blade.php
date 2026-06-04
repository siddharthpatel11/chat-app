<div id="new_chat_panel"
    class="hidden flex-col w-[30%] sm:min-w-[300px] border-r border-[#313d45] bg-[#111b21] h-full shrink-0 overflow-hidden">
    <!-- Header -->
    <div class="h-[108px] bg-[#202c33] flex items-end pb-4 px-6 gap-6 shrink-0 border-b border-[#313d45]">
        <button onclick="toggleNewChat()" class="text-[#e9edef] hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
            </svg>
        </button>
        <h2 class="text-[#e9edef] text-[19px] font-semibold">New chat</h2>
    </div>

    <!-- Search -->
    <div class="p-2 border-b border-[#202c33] bg-[#111b21] shrink-0">
        <div class="bg-[#202c33] rounded-lg flex items-center px-3 py-1.5 h-9 transition-all duration-200 focus-within:bg-[#2a3942]">
            <div class="relative w-6 h-6 shrink-0">
                <svg class="w-[18px] h-[18px] text-[#8696a0] absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 0 0 1.256-3.386 5.207 5.207 0 1 0-5.207 5.208 5.183 5.183 0 0 0 3.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-4.6-1.598a3.608 3.608 0 1 1 0-7.216 3.608 3.608 0 0 1 0 7.216z"></path>
                </svg>
            </div>
            <input type="text" id="new_chat_search" placeholder="Search name or number" class="bg-transparent border-none focus:ring-0 w-full text-sm ml-2 text-[#d1d7db] placeholder-[#8696a0]">
        </div>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#111b21]">
        <!-- Actions -->
        <div class="py-2 border-b border-[#202c33]">
            <button onclick="toggleAddMembers()" class="w-full flex items-center px-4 py-3 hover:bg-[#202c33] transition-colors gap-4">
                <div class="w-12 h-12 rounded-full bg-[#00a884] flex items-center justify-center shrink-0 text-white">
                    <svg viewBox="0 0 24 24" height="24" width="24" preserveAspectRatio="xMidYMid meet" fill="currentColor"><path d="M12.5 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm6.5 11h-1v-1.5c0-1.93-3.5-3-6.5-3s-6.5 1.07-6.5 3V17h14v-1.5z"></path><path d="M19 13h-2v2h-2v2h2v2h2v-2h2v-2h-2z"></path></svg>
                </div>
                <span class="text-[#e9edef] text-[16px]">New group</span>
            </button>
            <button onclick="toggleNewContact()" class="w-full flex items-center px-4 py-3 hover:bg-[#202c33] transition-colors gap-4">
                <div class="w-12 h-12 rounded-full bg-[#00a884] flex items-center justify-center shrink-0 text-white">
                    <svg viewBox="0 0 24 24" height="24" width="24" preserveAspectRatio="xMidYMid meet" fill="currentColor"><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm1 14.5h-2v-2h2v2zm0-4h-2v-6h2v6z"></path></svg>
                </div>
                <span class="text-[#e9edef] text-[16px]">New contact</span>
            </button>
        </div>

        <!-- Contacts list -->
        <div class="py-2">
            <h3 class="text-[#00a884] text-[16px] px-8 py-4 uppercase tracking-wide font-medium">Contacts on WhatsApp</h3>
            <div id="new_chat_contacts_list">
                @foreach($users ?? [] as $user)
                    @php
                        $userAvatar = $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?: $user->phone) . '&background=2a3942&color=fff';
                    @endphp
                    <div id="new_chat_contact_{{ $user->id }}" onclick="window.startNewChat({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->phone ?? '') }}', '{{ $userAvatar }}', '{{ addslashes($user->about ?? 'Available') }}')"
                        class="flex items-center px-3 py-3 hover:bg-[#202c33] cursor-pointer transition-colors new-chat-contact-item" data-name="{{ strtolower($user->name ?: $user->phone) }}">
                        <div class="w-12 h-12 rounded-full overflow-hidden bg-[#2a3942] flex items-center justify-center shrink-0 ml-1">
                            <img src="{{ $userAvatar }}" class="w-full h-full object-cover">
                        </div>
                        <div class="ml-3 flex-1 border-b border-[#202c33] pb-3 pt-1 min-w-0">
                            <h4 class="text-[17px] text-[#e9edef] truncate mr-2 font-normal">{{ $user->name ?: $user->phone }}</h4>
                            <p class="text-[14px] text-[#8696a0] truncate mt-0.5 leading-snug new-chat-about-text">{{ $user->about ?? 'Available' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    function toggleNewChat() {
        const sidebar = document.getElementById('user_sidebar_container');
        const newChatPanel = document.getElementById('new_chat_panel');
        
        if (newChatPanel.classList.contains('hidden')) {
            sidebar.classList.add('hidden');
            sidebar.classList.remove('sm:flex');
            newChatPanel.classList.remove('hidden');
            newChatPanel.classList.add('sm:flex');
        } else {
            newChatPanel.classList.add('hidden');
            newChatPanel.classList.remove('sm:flex');
            sidebar.classList.remove('hidden');
            sidebar.classList.add('sm:flex');
        }
    }

    // Search functionality for new chat contacts
    const newChatSearch = document.getElementById('new_chat_search');
    if (newChatSearch) {
        newChatSearch.addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            const items = document.querySelectorAll('.new-chat-contact-item');
            
            items.forEach(item => {
                const name = item.getAttribute('data-name');
                if (name.includes(term)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    window.startNewChat = function(userId, name, phone, avatar, about) {
        // Toggle back to main sidebar
        toggleNewChat();
        // Call the main selectChat function
        if(window.selectChat) {
            window.selectChat(userId, name, phone, avatar, about);
        }
    };
</script>
