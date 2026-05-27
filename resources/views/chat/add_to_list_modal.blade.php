<!-- Add to List Modal -->
<div id="add_to_list_modal" class="hidden fixed inset-0 z-[500] flex items-center justify-center bg-black/60 backdrop-blur-sm transition-opacity duration-300 opacity-0">
    <div class="bg-[#3b4a54] w-[90%] max-w-[400px] rounded-xl shadow-2xl overflow-hidden transform scale-95 transition-transform duration-300 flex flex-col max-h-[80vh]">
        <!-- Header -->
        <div class="px-6 py-5 flex justify-between items-center bg-[#233138] border-b border-[#313d45] shrink-0">
            <h2 class="text-[#e9edef] text-[19px] font-medium">Add to list</h2>
            <button onclick="window.closeAddToListModal()" class="text-[#aebac1] hover:text-[#e9edef] transition-colors focus:outline-none">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path>
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="flex-1 overflow-y-auto custom-scrollbar p-2" id="custom_lists_checkbox_container">
            <!-- Dynamic checkboxes for existing lists will be injected here -->
        </div>

        <!-- Create New List Section -->
        <div class="p-4 border-t border-[#313d45] bg-[#233138] shrink-0">
            <div id="new_list_btn_container">
                <button onclick="window.showNewListInput()" class="flex items-center gap-4 px-2 py-2 text-[#00a884] hover:bg-[#182229] w-full rounded-lg transition-colors focus:outline-none">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                    </svg>
                    <span class="text-[16px] font-medium">New list</span>
                </button>
            </div>
            
            <div id="new_list_input_container" class="hidden flex flex-col gap-3">
                <input type="text" id="new_list_name_input" placeholder="List name" maxlength="25" class="w-full bg-[#2a3942] border border-[#313d45] rounded-lg px-4 py-2.5 text-[15px] text-[#d1d7db] placeholder-[#8696a0] focus:outline-none focus:border-[#00a884] transition-colors">
                <div class="flex justify-end gap-3">
                    <button onclick="window.hideNewListInput()" class="px-5 py-2 rounded-full border border-[#313d45] text-[#00a884] hover:bg-[#182229] transition-colors text-[14px] font-medium focus:outline-none">Cancel</button>
                    <button onclick="window.createNewList()" class="px-5 py-2 rounded-full bg-[#00a884] text-[#111b21] hover:bg-[#008f6f] transition-colors text-[14px] font-medium focus:outline-none">Create</button>
                </div>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="px-6 py-4 bg-[#233138] border-t border-[#313d45] flex justify-end gap-4 shrink-0" id="add_to_list_actions">
            <button onclick="window.closeAddToListModal()" class="px-6 py-2.5 rounded-full border border-[#313d45] text-[#00a884] hover:bg-[#182229] transition-colors text-[14px] font-medium focus:outline-none">Cancel</button>
            <button onclick="window.saveChatToLists()" class="px-6 py-2.5 rounded-full bg-[#00a884] text-[#111b21] hover:bg-[#008f6f] transition-colors text-[14px] font-medium focus:outline-none">Save</button>
        </div>
    </div>
</div>

<script>
    window.activeChatForList = null;

    window.openAddToListModal = function(chatId) {
        window.activeChatForList = chatId;
        const modal = document.getElementById('add_to_list_modal');
        modal.classList.remove('hidden');
        
        window.renderListCheckboxes();
        window.hideNewListInput();

        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.querySelector('div').classList.remove('scale-95');
        }, 10);
    };

    window.closeAddToListModal = function() {
        const modal = document.getElementById('add_to_list_modal');
        modal.classList.add('opacity-0');
        modal.querySelector('div').classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            window.activeChatForList = null;
        }, 300);
    };

    window.renderListCheckboxes = function() {
        const container = document.getElementById('custom_lists_checkbox_container');
        if (!container) return;
        container.innerHTML = '';

        const lists = Object.keys(window.customLists || {});
        if (lists.length === 0) {
            container.innerHTML = `<div class="text-[#8696a0] text-[15px] text-center p-6">No custom lists created yet.</div>`;
            return;
        }

        let html = '<div class="flex flex-col space-y-1">';
        lists.forEach(listName => {
            const isChecked = window.customLists[listName].includes(window.activeChatForList);
            const checkboxHtml = isChecked ? 
                `<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-white"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path></svg>` : 
                '';
                
            const bgClass = isChecked ? 'bg-[#00a884] border-[#00a884]' : 'bg-transparent border-[#8696a0]';

            html += `
                <div onclick="window.toggleListCheckbox('${listName.replace(/'/g, "\\'")}')" class="flex items-center gap-4 px-4 py-3 hover:bg-[#202c33] cursor-pointer rounded-lg transition-colors group">
                    <div class="w-5 h-5 rounded border-2 ${bgClass} flex items-center justify-center transition-colors shrink-0" id="checkbox_ui_${listName}">
                        ${checkboxHtml}
                    </div>
                    <span class="text-[#e9edef] text-[16px] truncate flex-1">${listName}</span>
                    
                    <button onclick="window.deleteCustomList(event, '${listName.replace(/'/g, "\\'")}')" class="opacity-0 group-hover:opacity-100 p-1.5 hover:bg-[#2a3942] rounded transition-all text-[#8696a0] hover:text-[#f15c6d]" title="Delete list">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path>
                        </svg>
                    </button>
                    
                    <input type="checkbox" id="list_cb_${listName}" value="${listName}" class="hidden list-selection-cb" ${isChecked ? 'checked' : ''}>
                </div>
            `;
        });
        html += '</div>';
        container.innerHTML = html;
    };

    window.deleteCustomList = function(event, listName) {
        event.stopPropagation();
        
        if (confirm(`Are you sure you want to delete the list "${listName}"?`)) {
            delete window.customLists[listName];
            localStorage.setItem('custom_lists', JSON.stringify(window.customLists));
            
            // If the deleted list was currently active, switch to 'all'
            if (window.activeSidebarFilter === `list_${listName}`) {
                window.setSidebarFilter('all');
            } else {
                if (window.renderCustomListFilters) {
                    window.renderCustomListFilters();
                }
            }
            
            window.renderListCheckboxes();
            window.showToast?.('List Deleted', `The list "${listName}" has been removed.`);
        }
    };

    window.toggleListCheckbox = function(listName) {
        const cb = document.getElementById(`list_cb_${listName}`);
        if (!cb) return;
        
        cb.checked = !cb.checked;
        const ui = document.getElementById(`checkbox_ui_${listName}`);
        
        if (cb.checked) {
            ui.className = 'w-5 h-5 rounded border-2 bg-[#00a884] border-[#00a884] flex items-center justify-center transition-colors shrink-0';
            ui.innerHTML = `<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="text-white"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path></svg>`;
        } else {
            ui.className = 'w-5 h-5 rounded border-2 bg-transparent border-[#8696a0] flex items-center justify-center transition-colors shrink-0';
            ui.innerHTML = '';
        }
    };

    window.showNewListInput = function() {
        document.getElementById('new_list_btn_container').classList.add('hidden');
        document.getElementById('add_to_list_actions').classList.add('hidden');
        document.getElementById('new_list_input_container').classList.remove('hidden');
        document.getElementById('new_list_input_container').classList.add('flex');
        document.getElementById('new_list_name_input').focus();
    };

    window.hideNewListInput = function() {
        document.getElementById('new_list_btn_container').classList.remove('hidden');
        document.getElementById('add_to_list_actions').classList.remove('hidden');
        document.getElementById('add_to_list_actions').classList.add('flex');
        document.getElementById('new_list_input_container').classList.add('hidden');
        document.getElementById('new_list_input_container').classList.remove('flex');
        document.getElementById('new_list_name_input').value = '';
    };

    window.createNewList = function() {
        const nameInput = document.getElementById('new_list_name_input');
        const listName = nameInput.value.trim();
        
        if (!listName) return;
        
        if (window.customLists[listName]) {
            window.showToast?.('Error', 'List already exists!');
            return;
        }

        // Initialize new empty list
        window.customLists[listName] = [];
        localStorage.setItem('custom_lists', JSON.stringify(window.customLists));
        
        // Re-render UI
        window.renderListCheckboxes();
        if (window.renderCustomListFilters) {
            window.renderCustomListFilters();
        }
        window.hideNewListInput();
        
        // Automatically check it
        setTimeout(() => {
            window.toggleListCheckbox(listName);
        }, 50);
    };

    window.saveChatToLists = function() {
        if (!window.activeChatForList) return;
        
        const checkboxes = document.querySelectorAll('.list-selection-cb');
        
        checkboxes.forEach(cb => {
            const listName = cb.value;
            const isChecked = cb.checked;
            
            const idx = window.customLists[listName].indexOf(window.activeChatForList);
            
            if (isChecked && idx === -1) {
                window.customLists[listName].push(window.activeChatForList);
            } else if (!isChecked && idx !== -1) {
                window.customLists[listName].splice(idx, 1);
            }
        });
        
        localStorage.setItem('custom_lists', JSON.stringify(window.customLists));
        window.closeAddToListModal();
        window.showToast?.('Lists Updated', 'Chat lists have been saved successfully.');
        
        // If we were filtering by a specific list, refresh it
        if (window.activeSidebarFilter && window.activeSidebarFilter.startsWith('list_')) {
            window.setSidebarFilter(window.activeSidebarFilter);
        } else {
            window.sortSidebar();
        }
    };
</script>
