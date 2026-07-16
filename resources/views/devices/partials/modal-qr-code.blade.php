<!-- Modal untuk menampilkan QR Code -->
<div x-show="isOpen" x-cloak 
     x-transition.opacity.duration.300
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-md">
    
    <div x-show="isOpen" 
         x-transition.scale.origin.top.duration.300
         class="w-full max-w-lg p-6 bg-white rounded-2xl shadow-2xl border border-gray-200">

        <!-- Header -->
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-semibold text-gray-800 mb-3">Use WhatsApp on your computer</h2>
            <p class="text-sm text-gray-500">Follow the steps below to link your device:</p>
        </div>

        <!-- Steps -->
        <ol class="space-y-2 text-sm text-gray-700 list-decimal list-inside mb-6">
            <li>Open WhatsApp on your phone.</li>
            <li>Tap <span class="font-medium">Menu</span> or <span class="font-medium">Settings</span> and select <span class="font-medium">Linked Devices</span>.</li>
            <li>Point your phone to this screen to capture the QR code.</li>
            <li>After your smartphone shows a success message, this page will update automatically.</li>
        </ol>

        <!-- QR Code or Loading -->
        <div class="flex justify-center items-center mb-6">
            <template x-if="loading">
                <div class="text-gray-400 text-lg font-medium animate-pulse">Loading...</div>
            </template>
            <img x-show="qrCode && !loading" :src="qrCode" class="w-48 h-48 rounded-lg border border-gray-200 shadow-lg mx-auto">
        </div>

        <!-- Footer: Close Button -->
        <div class="flex justify-center">
            <button @click="isOpen = false; qrCode = ''; stopDeviceStatusPolling();"
                    class="px-6 py-2 bg-white text-gray-600 font-semibold rounded-lg shadow transition duration-200">
                Close
            </button>
        </div>
        
    </div>
</div>
