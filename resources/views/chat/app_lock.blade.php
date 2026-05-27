<!-- App Lock Setup Modal -->
<div id="app_lock_setup_modal" class="hidden fixed inset-0 z-[2000] flex items-center justify-center bg-black/60 backdrop-blur-sm transition-all duration-300">
    <div class="bg-[#233138] w-[90%] max-w-[400px] rounded-[3px] p-6 shadow-2xl transform scale-95 transition-all duration-300 opacity-0" id="app_lock_setup_content">
        <h3 class="text-[#e9edef] text-[20px] font-normal mb-2">Set up App lock</h3>
        <p class="text-[#8696a0] text-[14px] mb-6 leading-relaxed">Enter a password to lock WhatsApp Web. Your password must be at least 6 characters long.</p>
        
        <div class="space-y-4 mb-8">
            <div>
                <input type="password" id="app_lock_pwd_1" placeholder="Enter password" class="w-full bg-[#111b21] border-b-2 border-[#00a884] focus:border-[#06cf9c] text-[#e9edef] px-3 py-2 outline-none rounded-t-sm transition-colors text-[15px]">
            </div>
            <div>
                <input type="password" id="app_lock_pwd_2" placeholder="Confirm password" class="w-full bg-[#111b21] border-b-2 border-gray-600 focus:border-[#00a884] text-[#e9edef] px-3 py-2 outline-none rounded-t-sm transition-colors text-[15px]">
            </div>
            <p id="app_lock_error" class="text-red-500 text-[13px] hidden">Passwords do not match.</p>
        </div>

        <div class="flex justify-end gap-4 items-center">
            <button onclick="window.closeAppLockSetup()" class="text-[#00a884] font-medium text-[14px] hover:bg-white/5 px-4 py-2 rounded-lg transition-colors border border-gray-600/30">Cancel</button>
            <button onclick="window.saveAppLock()" class="bg-[#00a884] text-[#111b21] font-medium text-[14px] px-6 py-2.5 rounded-full hover:bg-[#06cf9c] transition-all active:scale-95 shadow-lg opacity-50 cursor-not-allowed" id="app_lock_save_btn" disabled>OK</button>
        </div>
    </div>
</div>

<!-- Full Screen Lock Overlay -->
<div id="app_lock_screen" class="hidden fixed inset-0 z-[3000] bg-[#111b21] flex flex-col items-center justify-center transition-all duration-300">
    <div class="flex flex-col items-center w-full max-w-[320px] px-4">
        <div class="w-20 h-20 bg-[#202c33] rounded-full flex items-center justify-center mb-6 shadow-lg border border-white/5">
            <svg viewBox="0 0 24 24" height="32" width="32" fill="#00a884">
                <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"></path>
            </svg>
        </div>
        <h2 class="text-[#e9edef] text-[24px] font-normal mb-8">Screen is locked</h2>
        
        <div class="w-full relative mb-6">
            <input type="password" id="app_lock_unlock_input" placeholder="Enter password" class="w-full bg-[#202c33] border-none text-[#e9edef] px-5 py-3.5 rounded-full outline-none focus:ring-2 focus:ring-[#00a884]/50 transition-all text-[15px] shadow-sm text-center">
            <button onclick="window.unlockApp()" class="absolute right-2 top-2 bottom-2 bg-[#00a884] text-[#111b21] w-10 rounded-full flex items-center justify-center hover:bg-[#06cf9c] transition-colors shadow-sm">
                <svg viewBox="0 0 24 24" height="20" width="20" fill="currentColor">
                    <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path>
                </svg>
            </button>
        </div>
        
        <p id="app_lock_unlock_error" class="text-red-500 text-[13px] hidden mb-4">Incorrect password.</p>
        <button onclick="window.resetAppLock()" class="text-[#00a884] hover:underline text-[14px]">Log out and clear password</button>
    </div>
</div>

<script>
    // Simple fast hash for local locking
    async function hashPassword(password) {
        const msgBuffer = new TextEncoder().encode(password);
        const hashBuffer = await crypto.subtle.digest('SHA-256', msgBuffer);
        const hashArray = Array.from(new Uint8Array(hashBuffer));
        return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
    }

    const pwd1 = document.getElementById('app_lock_pwd_1');
    const pwd2 = document.getElementById('app_lock_pwd_2');
    const saveBtn = document.getElementById('app_lock_save_btn');
    const setupError = document.getElementById('app_lock_error');
    
    function validateSetupInputs() {
        if (pwd1.value.length >= 6 && pwd1.value === pwd2.value) {
            saveBtn.disabled = false;
            saveBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            setupError.classList.add('hidden');
            pwd2.classList.remove('border-red-500');
            pwd2.classList.add('border-gray-600', 'focus:border-[#00a884]');
        } else {
            saveBtn.disabled = true;
            saveBtn.classList.add('opacity-50', 'cursor-not-allowed');
            if (pwd2.value.length > 0 && pwd1.value !== pwd2.value) {
                setupError.classList.remove('hidden');
                pwd2.classList.remove('border-gray-600', 'focus:border-[#00a884]');
                pwd2.classList.add('border-red-500');
            } else {
                setupError.classList.add('hidden');
                pwd2.classList.remove('border-red-500');
                pwd2.classList.add('border-gray-600', 'focus:border-[#00a884]');
            }
        }
    }
    
    pwd1.addEventListener('input', validateSetupInputs);
    pwd2.addEventListener('input', validateSetupInputs);

    window.handleAppLockClick = function() {
        const hasLock = localStorage.getItem('app_lock_hash');
        if (hasLock) {
            // Lock immediately
            window.lockApp();
        } else {
            // Open setup modal
            pwd1.value = '';
            pwd2.value = '';
            validateSetupInputs();
            const modal = document.getElementById('app_lock_setup_modal');
            const content = document.getElementById('app_lock_setup_content');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('opacity-100');
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
                pwd1.focus();
            }, 10);
        }
    };

    window.closeAppLockSetup = function() {
        const modal = document.getElementById('app_lock_setup_modal');
        const content = document.getElementById('app_lock_setup_content');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.remove('opacity-100');
            modal.classList.add('hidden');
        }, 300);
    };

    window.saveAppLock = async function() {
        if (pwd1.value === pwd2.value && pwd1.value.length >= 6) {
            const hash = await hashPassword(pwd1.value);
            localStorage.setItem('app_lock_hash', hash);
            window.closeAppLockSetup();
            window.showToast?.('App Lock Enabled', 'Your screen will now lock securely.');
            setTimeout(() => {
                window.lockApp();
            }, 500);
        }
    };

    window.lockApp = function() {
        document.getElementById('app_lock_screen').classList.remove('hidden');
        document.getElementById('app_lock_unlock_input').value = '';
        document.getElementById('app_lock_unlock_error').classList.add('hidden');
        setTimeout(() => {
            document.getElementById('app_lock_unlock_input').focus();
        }, 100);
    };

    window.unlockApp = async function() {
        const input = document.getElementById('app_lock_unlock_input').value;
        const hash = await hashPassword(input);
        const storedHash = localStorage.getItem('app_lock_hash');
        
        if (hash === storedHash) {
            document.getElementById('app_lock_screen').classList.add('hidden');
        } else {
            document.getElementById('app_lock_unlock_error').classList.remove('hidden');
            const inputEl = document.getElementById('app_lock_unlock_input');
            inputEl.classList.add('border', 'border-red-500');
            inputEl.value = '';
            inputEl.focus();
            setTimeout(() => {
                inputEl.classList.remove('border', 'border-red-500');
            }, 2000);
        }
    };

    document.getElementById('app_lock_unlock_input').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            window.unlockApp();
        }
    });

    window.resetAppLock = function() {
        if(confirm('This will log you out and remove your App Lock password. Continue?')) {
            localStorage.removeItem('app_lock_hash');
            document.getElementById('logout-form').submit();
        }
    };

    // Check on load
    window.addEventListener('DOMContentLoaded', () => {
        if (localStorage.getItem('app_lock_hash')) {
            window.lockApp();
        }
    });
</script>
