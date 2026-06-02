<div id="keyboard_shortcuts_modal" class="fixed inset-0 bg-[#0b141a]/80 z-[100] hidden items-center justify-center p-4">
    <div class="bg-[#202c33] rounded-3xl shadow-xl w-full max-w-[700px] h-auto max-h-[90vh] flex flex-col overflow-hidden transform scale-95 opacity-0 transition-all duration-200" id="keyboard_shortcuts_modal_content">
        <!-- Header -->
        <div class="px-6 py-6 flex items-center shrink-0">
            <h2 class="text-[#e9edef] text-[20px] font-medium">Keyboard shortcuts</h2>
        </div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto custom-scrollbar px-6 pb-2">
            <?php
                $shortcuts = [
                    ['label' => 'Mark as unread', 'keys' => ['Ctrl', 'Shift', 'U']],
                    ['label' => 'Mute', 'keys' => ['Ctrl', 'Shift', 'M']],
                    ['label' => 'Archive chat', 'keys' => ['Ctrl', 'Shift', 'A']],
                    ['label' => 'Pin chat', 'keys' => ['Ctrl', 'Alt', 'Shift', 'P']],
                    ['label' => 'Search', 'keys' => ['Ctrl', 'Alt', '/']],
                    ['label' => 'Search chat', 'keys' => ['Ctrl', 'Shift', 'F']],
                    ['label' => 'New chat', 'keys' => ['Ctrl', 'Alt', 'N']],
                    ['label' => 'Next chat', 'keys' => ['Ctrl', ']']],
                    ['label' => 'Previous chat', 'keys' => ['Ctrl', '[']],
                    ['label' => 'Label chat', 'keys' => ['Ctrl', 'Cmd', 'Shift', 'L']],
                    ['label' => 'Close chat', 'keys' => ['Escape']],
                    ['label' => 'New group', 'keys' => ['Ctrl', 'Shift', 'N']],
                    ['label' => 'Profile and About', 'keys' => ['Ctrl', 'Alt', 'P']],
                    ['label' => 'Increase speed of selected voice message', 'keys' => ['Shift', '.']],
                    ['label' => 'Decrease speed of selected voice message', 'keys' => ['Shift', ',']],
                    ['label' => 'Settings', 'keys' => ['Alt', 'S']],
                    ['label' => 'Emoji panel', 'keys' => ['Ctrl', 'Alt', 'E']],
                    ['label' => 'GIF panel', 'keys' => ['Ctrl', 'Alt', 'G']],
                    ['label' => 'Sticker panel', 'keys' => ['Ctrl', 'Alt', 'S']],
                    ['label' => 'Extended search', 'keys' => ['Alt', 'K']],
                ];
            ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-7">
                <?php $__currentLoopData = $shortcuts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shortcut): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center justify-between">
                        <span class="text-[#e9edef] text-[15px] truncate mr-2"><?php echo e($shortcut['label']); ?></span>
                        <div class="flex gap-1.5 shrink-0">
                            <?php $__currentLoopData = $shortcut['keys']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <kbd class="px-2 py-0.5 bg-[#111b21] text-[#aebac1] rounded-lg text-[13px] border border-[#313d45] shadow-sm"><?php echo e($key); ?></kbd>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-6 py-6 flex items-center justify-end shrink-0 mt-2">
            <button onclick="closeKeyboardShortcutsModal()" class="px-6 py-2.5 bg-[#00a884] hover:bg-[#06cf9c] text-[#111b21] rounded-full font-medium transition-colors text-[14px]">
                OK
            </button>
        </div>
    </div>
</div>

<script>
    window.openKeyboardShortcutsModal = function() {
        const modal = document.getElementById('keyboard_shortcuts_modal');
        const content = document.getElementById('keyboard_shortcuts_modal_content');
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // slight delay for animation
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    window.closeKeyboardShortcutsModal = function() {
        const modal = document.getElementById('keyboard_shortcuts_modal');
        const content = document.getElementById('keyboard_shortcuts_modal_content');
        
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 200);
    }

    // Close on click outside
    document.getElementById('keyboard_shortcuts_modal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            window.closeKeyboardShortcutsModal();
        }
    });
</script>
<?php /**PATH D:\xampp\htdocs\laravel\chat_app\resources\views/chat/settings/keyboard_shortcuts_modal.blade.php ENDPATH**/ ?>