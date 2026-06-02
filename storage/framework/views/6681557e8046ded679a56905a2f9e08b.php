<!-- About Privacy Modal -->
<div id="about_privacy_modal" class="hidden fixed inset-0 z-[300] bg-black/80 flex items-center justify-center backdrop-blur-sm p-4">
    <div class="bg-[#111b21] w-full max-w-md rounded-2xl overflow-hidden shadow-2xl flex flex-col border border-[#313d45]">
        <!-- Header -->
        <div class="h-16 bg-[#202c33] px-6 flex items-center gap-6 shrink-0 border-b border-[#313d45]">
            <button onclick="closeAboutPrivacy()" class="text-[#aebac1] hover:text-white transition-colors">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
            </button>
            <h2 class="text-white text-[19px] font-semibold">About</h2>
        </div>

        <!-- Content -->
        <div class="p-6 space-y-6">
            <h3 class="text-[#8696a0] text-sm font-medium mb-4 ml-2">Who can see my About</h3>
            
            <div class="space-y-1">
                <?php
                    $privacyOptions = ['Everyone', 'My contacts', 'My contacts except...', 'Nobody'];
                ?>

                <?php $__currentLoopData = $privacyOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center justify-between py-4 px-4 hover:bg-[#202c33] rounded-xl cursor-pointer group transition-colors" onclick="selectAboutPrivacy('<?php echo e($option); ?>')">
                    <span class="text-[#e9edef] text-[16px]"><?php echo e($option); ?></span>
                    <div class="w-5 h-5 rounded-full border-2 <?php echo e($option == 'Nobody' ? 'border-[#00a884] flex items-center justify-center' : 'border-[#8696a0]'); ?> transition-all privacy-radio" data-option="<?php echo e($option); ?>">
                        <?php if($option == 'Nobody'): ?>
                            <div class="w-2.5 h-2.5 bg-[#00a884] rounded-full"></div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        
        <!-- Bottom Spacer -->
        <div class="h-10 bg-[#111b21]"></div>
    </div>
</div>

<script>
    function openAboutPrivacy() {
        document.getElementById('about_privacy_modal').classList.remove('hidden');
        document.getElementById('about_privacy_modal').classList.add('flex');
    }

    function closeAboutPrivacy() {
        document.getElementById('about_privacy_modal').classList.add('hidden');
        document.getElementById('about_privacy_modal').classList.remove('flex');
    }

    function selectAboutPrivacy(option) {
        // Update the main modal text
        document.getElementById('about_privacy_text').innerText = option;
        
        // Update radio buttons in privacy modal
        document.querySelectorAll('.privacy-radio').forEach(radio => {
            const isSelected = radio.getAttribute('data-option') === option;
            if (isSelected) {
                radio.classList.remove('border-[#8696a0]');
                radio.classList.add('border-[#00a884]', 'flex', 'items-center', 'justify-center');
                radio.innerHTML = '<div class="w-2.5 h-2.5 bg-[#00a884] rounded-full"></div>';
            } else {
                radio.classList.add('border-[#8696a0]');
                radio.classList.remove('border-[#00a884]', 'flex', 'items-center', 'justify-center');
                radio.innerHTML = '';
            }
        });

        // Small delay before closing for better UX
        setTimeout(closeAboutPrivacy, 200);
    }
</script>
<?php /**PATH D:\xampp\htdocs\laravel\chat_app\resources\views/chat/about/about_privacy_modal.blade.php ENDPATH**/ ?>