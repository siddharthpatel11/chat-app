<div id="add_favourite_modal" class="hidden fixed inset-0 z-[150] flex items-center justify-center bg-gray-900/90 backdrop-blur-sm">
    <div class="bg-[#111b21] w-full max-w-md rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[80vh]">
        
        <!-- Header -->
        <div class="px-5 py-4 flex items-center justify-between border-b border-[#202c33] bg-[#202c33]">
            <h2 class="text-[#e9edef] text-[19px] font-medium">Add to Favourites</h2>
            <button onclick="window.closeAddFavouriteModal()" class="text-[#8696a0] hover:text-[#e9edef] transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path></svg>
            </button>
        </div>

        <!-- Search Bar -->
        <div class="p-3 bg-[#111b21]">
            <div class="bg-[#202c33] rounded-lg flex items-center px-4 py-2 h-10">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-[#8696a0] shrink-0">
                    <path d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 0 0 1.256-3.386 5.207 5.207 0 1 0-5.207 5.208 5.183 5.183 0 0 0 3.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-5.6-1.2a3.996 3.996 0 0 1-3.996-3.995 3.996 3.996 0 1 1 7.992 0 3.996 3.996 0 0 1-3.996 3.995z"></path>
                </svg>
                <input type="text" id="fav_search_input" onkeyup="window.filterFavContacts()" placeholder="Search contacts" class="bg-transparent border-none text-[#d1d7db] text-[15px] w-full ml-4 focus:ring-0 placeholder-[#8696a0]">
            </div>
        </div>

        <!-- Contacts List -->
        <div id="fav_contacts_list" class="flex-1 overflow-y-auto px-2 py-2 flex flex-col gap-1 scrollbar-thin scrollbar-thumb-[#374045] scrollbar-track-transparent">
            <!-- Dynamically populated via JS -->
        </div>

    </div>
</div>

<script>
window.showAddFavouriteModal = function() {
    document.getElementById('add_favourite_modal').classList.remove('hidden');
    document.getElementById('add_favourite_modal').classList.add('flex');
    window.renderFavContacts();
};

window.closeAddFavouriteModal = function() {
    document.getElementById('add_favourite_modal').classList.add('hidden');
    document.getElementById('add_favourite_modal').classList.remove('flex');
    document.getElementById('fav_search_input').value = '';
};

window.filterFavContacts = function() {
    const val = document.getElementById('fav_search_input').value.toLowerCase();
    const items = document.querySelectorAll('.fav-contact-item');
    items.forEach(item => {
        const name = item.getAttribute('data-name').toLowerCase();
        if (name.includes(val)) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
};

window.renderFavContacts = function() {
    const container = document.getElementById('fav_contacts_list');
    container.innerHTML = '';

    const users = window.allContacts || [];
    users.forEach(user => {
        const name = user.saved_name || user.name || user.phone;
        const avatar = user.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=2a3942&color=fff`;
        
        const el = document.createElement('div');
        el.className = "fav-contact-item flex items-center justify-between p-3 rounded-lg hover:bg-[#202c33] cursor-pointer";
        el.setAttribute('data-name', name);
        el.onclick = () => window.addContactToFavourites(user.id, name, avatar);

        el.innerHTML = `
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full overflow-hidden shrink-0">
                    <img src="${avatar}" class="w-full h-full object-cover">
                </div>
                <div class="flex flex-col">
                    <span class="text-[#e9edef] text-[16px] font-normal">${name}</span>
                </div>
            </div>
            <div class="text-[#8696a0]">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path></svg>
            </div>
        `;
        container.appendChild(el);
    });
};

window.addContactToFavourites = function(userId, name, avatar) {
    if (!window.myUserId) return;
    const favRef = window.ref(window.db, `users/${window.myUserId}/favorites/${userId}`);
    window.set(favRef, {
        id: userId,
        name: name,
        avatar: avatar,
        time: window.serverTimestamp(),
        is_group: false
    }).then(() => {
        window.closeAddFavouriteModal();
        if(window.showToast) window.showToast('Favourite added', name + ' was added to your favourites.');
    });
};
</script>
