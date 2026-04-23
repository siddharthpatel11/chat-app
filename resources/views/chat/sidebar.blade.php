<div class="hidden sm:flex flex-col w-[30%] sm:min-w-[300px] border-r border-[#313d45] bg-[#111b21]">
    <div class="h-16 bg-[#202c33] flex items-center px-4 justify-between shrink-0 border-b border-[#313d45]">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full overflow-hidden bg-[#202c33] flex items-center justify-center text-white border border-[#313d45]">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2a3942&color=fff" class="w-full h-full object-cover">
            </div>
            <span class="font-semibold text-[#e9edef]">{{ auth()->user()->name }} (You)</span>
        </div>
    </div>

    <div class="p-2 border-b border-[#202c33] bg-[#111b21]">
        <div class="bg-[#202c33] rounded-lg flex items-center px-3 py-1.5 h-9">
            <svg class="w-4 h-4 text-[#8696a0]" fill="currentColor" viewBox="0 0 24 24">
                <path d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 0 0 1.256-3.386 5.207 5.207 0 1 0-5.207 5.208 5.183 5.183 0 0 0 3.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-4.6-1.598a3.608 3.608 0 1 1 0-7.216 3.608 3.608 0 0 1 0 7.216z"></path>
            </svg>
            <input type="text" placeholder="Search or start new chat" class="bg-transparent border-none focus:ring-0 w-full text-sm ml-2 text-[#d1d7db] placeholder-[#8696a0]">
        </div>
    </div>

    <div class="flex-1 overflow-y-auto custom-scrollbar" id="user_list_container">
        @foreach($users ?? [] as $user)
            <div onclick="window.selectChat({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->phone ?? '') }}')"
                class="flex items-center px-3 py-3 hover:bg-[#202c33] cursor-pointer transition-colors"
                id="user_sidebar_{{ $user->id }}">
                <div class="w-12 h-12 rounded-full overflow-hidden bg-[#2a3942] flex items-center justify-center shrink-0">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name ?: $user->phone) }}&background=2a3942&color=fff" class="w-full h-full object-cover">
                </div>
                <div class="ml-4 flex-1 border-b border-[#202c33] pb-3 pt-1">
                    <div class="flex justify-between items-center">
                        <h4 class="text-[17px] text-[#e9edef] whitespace-nowrap overflow-hidden text-ellipsis">
                            {{ $user->name ?: $user->phone }}
                        </h4>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
