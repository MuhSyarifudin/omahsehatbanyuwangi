@extends('layouts.DashboardLayout')
@push('top')
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
@endpush
@section('content')
    <div
        x-data="{ activeTab: 'profile' }" 
        class="bg-white flex flex-col md:flex-row rounded-lg"
    >
        <div class="w-full md:w-1/3 xl:w-1/4">
            <button
                @click="activeTab = 'profile'" 
                class="w-full flex flex-col text-left p-8 border-l border-t border-b border-gray-300 rounded-tl-lg rounded-tr-lg md:rounded-tr-none"
                :class=" activeTab === 'profile' ? 'bg-white border-r md:border-r-0' : 'bg-gray-100 border-r'"
            >
                <span class="text-gray-900">Profile Information</span>
                <span class="text-sm text-gray-500">Update your account's profile information and email address.</span>
            </button>
            <button
                @click="activeTab = 'password'" 
                class="w-full flex flex-col text-left p-8 border-l border-b border-gray-300"
                :class=" activeTab === 'password' ? 'bg-white border-r md:border-r-0' : 'bg-gray-100 border-r'"
            >
                <span class="text-gray-900">Update Password</span>
                <span class="text-sm text-gray-500">Ensure your account is using a long, random password to stay secure.</span>
            </button>
            <button 
                @click="activeTab = 'two_factor_auth'"
                class="w-full flex flex-col text-left p-8 border-l border-b border-gray-300"
                :class=" activeTab === 'two_factor_auth' ? 'bg-white border-r md:border-r-0' : 'bg-gray-100 border-r'"
            >
                <span class="text-gray-900">Two Factor Authentication</span>
                <span class="text-sm text-gray-500">Add additional security to your account using two factor authentication.</span>
            </button>
            <button 
                @click="activeTab = 'browser_sessions'"
                class="w-full flex flex-col text-left p-8 border-l border-b border-gray-300"
                :class=" activeTab === 'browser_sessions' ? 'bg-white border-r md:border-r-0' : 'bg-gray-100 border-r'"
            >
                <span class="text-gray-900">Browser Sessions</span>
                <span class="text-sm text-gray-500">Manage and log out your active sessions on other browsers and devices.</span>
            </button>
            <button
                @click="activeTab = 'delete_account'"
                class="w-full flex flex-col text-left p-8 border-l border-b border-gray-300 md:rounded-bl-lg"
                :class=" activeTab === 'delete_account' ? 'bg-white border-r md:border-r-0' : 'bg-gray-100 border-r'"
            >
                <span class="text-gray-900">Delete Account</span>
                <span class="text-sm text-gray-500">Permanently delete your account.</span>
            </button>
        </div>
        <div class="w-full md:w-2/3 xl:w-3/4 py-8 px-16 flex flex-col items-start justify-start border-t border-r border-b border-gray-300 md:rounded-tr-lg rounded-br-lg">
            <div 
                x-show="activeTab === 'profile'" 
                class="w-full md:w-3/4 xl:w-1/2"
            >
                <form class="flex flex-col space-y-8" method="post" action="{{ route('settings.update') }}">
                    @csrf
                    @method('patch')
                    <div class="flex flex-col space-y-2">
                        <label class="text-sm text-gray-500">Photo</label>

                            <!-- Trigger -->
                            <div class="flex items-center gap-4">
                            <img id="avatarPreview" 
                                src="{{ url($user->avatars ? asset('storage/'.$user->avatars) : asset('assets/img/blank-profile.png')) }}"
                                class="w-24 rounded-full"
                            >

                        </div>

                        <label for="photoInput" class="w-48 text-sm text-gray-700 text-center px-3 py-2 uppercase mt-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-200 transition duration-150">Select a New Photo</label>

                        <input type="file" id="photoInput" accept="image/*" class="hidden">

                        <input type="hidden" name="cropped_photo" id="croppedPhoto">

                         <!-- Modal -->
                        <div id="cropModal"
                            class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4 transition-opacity duration-200">

                            <div class="bg-white w-full max-w-lg max-h-[90vh] rounded-2xl shadow-xl flex flex-col">

                                <!-- Header -->
                                <div class="p-6 pb-3">
                                    <h3 class="text-lg font-semibold text-gray-800">
                                        Sesuaikan Foto Profil
                                    </h3>
                                </div>

                                <!-- Image Area (Scrollable) -->
                                <div class="px-6 overflow-auto flex-1">
                                    <div class="rounded-xl overflow-hidden">
                                        <img id="imagePreview" class="max-w-full">
                                    </div>
                                </div>

                                <!-- Footer (Always Visible) -->
                                <div class="p-6 pt-4 flex justify-end gap-3 border-t border-gray-100">
                                    <button type="button" id="cancelCrop"
                                        class="px-4 py-2 rounded-xl text-sm font-medium border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                                        Batal
                                    </button>

                                    <button type="button" id="saveCrop"
                                        class="px-4 py-2 rounded-xl text-sm font-medium bg-gray-900 text-white hover:bg-black transition">
                                        Simpan
                                    </button>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="flex flex-col space-y-2">
                        <label for="name" class="text-sm text-gray-500">Name</label>
                        <input type="text" name="name" id="name" class="p-2 text-gray-900 border border-gray-300 focus:border-primary focus:outline-none focus:ring-0 rounded-lg" autocomplete="off" value="{{ $user->name }}">
                    </div>
                    <div class="flex flex-col space-y-2">
                        <label for="name" class="text-sm text-gray-500">Email</label>
                        <input type="email" name="email" id="name" class="p-2 text-gray-900 border border-gray-300 focus:border-primary focus:outline-none focus:ring-0 rounded-lg" autocomplete="off" value="{{ $user->email }}">
                    </div>
                    <div>
                        <button class="w-32 bg-primary hover:bg-primary-dark rounded-lg py-1.5 text-gray-200 text-sm uppercase hover:shadow-xl transition duration-150">Save</button>
                    </div>
                </form>
            </div>
            <div 
                x-show="activeTab === 'password'" 
                class="w-full md:w-3/4 xl:w-1/2"
            >
                <form class="flex flex-col space-y-8" method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')
                    <div class="flex flex-col space-y-2">
                        <label for="current_password" class="text-sm text-gray-500">Current Password</label>
                        <input type="password" name="current_password" id="current_password" class="p-2 border text-gray-900 border-gray-300 focus:border-primary focus:outline-none focus:ring-0 rounded-lg" autocomplete="off">
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                    </div>
                    <div class="flex flex-col space-y-2">
                        <label for="new_password" class="text-sm text-gray-500">New Password</label>
                        <input type="password" name="password" id="new_password" class="p-2 border text-gray-900 border-gray-300 focus:border-primary focus:outline-none focus:ring-0 rounded-lg" autocomplete="off">
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                    </div>
                    <div class="flex flex-col space-y-2">
                        <label for="confirm_password" class="text-sm text-gray-500">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="confirm_password" class="p-2 border text-gray-900 border-gray-300 focus:border-primary focus:outline-none focus:ring-0 rounded-lg" autocomplete="off">
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                    </div>
                    <div>
                        <button class="w-32 bg-primary hover:bg-primary-dark rounded-lg py-1.5 text-gray-200 text-sm uppercase hover:shadow-xl transition duration-150">Save</button>
                    </div>
                </form>
            </div>
            <div 
                x-show="activeTab === 'two_factor_auth'" 
                class="w-full md:w-3/4 xl:w-1/2"
            >
                <p class="text-gray-900">You have not enabled two factor authentication.</p>
                <p class="text-sm text-gray-500 mt-2">When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application.</p>
                <form class="mt-8">
                    <div>
                        <button class="w-32 bg-primary hover:bg-primary-dark rounded-lg py-1.5 text-gray-200 text-sm uppercase hover:shadow-xl transition duration-150">Enable</button>
                    </div>
                </form>
            </div>
            <div 
                x-show="activeTab === 'browser_sessions'" 
                class="w-full md:w-3/4 xl:w-1/2"
            >
                <p class="text-sm text-gray-500">If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.</p>
                <div class="flex items-center space-x-4 mt-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <div class="text-sm">
                        <span class="text-gray-500">Windows - Chrome</span>
                        <div class="flex space-x-1">
                            <span class="text-gray-400">127.0.0.1.</span>
                            <span class="text-green-600">This device</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4 mt-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <div class="text-sm">
                        <span class="text-gray-500">Linux - Chrome</span>
                        <div class="flex space-x-1">
                            <span class="text-gray-400">127.0.0.1.</span>
                            <span class="text-gray-400">Last active 11 hours ago</span>
                        </div>
                    </div>
                </div>
                <form class="mt-8">
                    <div>
                        <button class="bg-primary hover:bg-primary-dark rounded-lg px-8 py-1.5 text-gray-200 text-sm uppercase hover:shadow-xl transition duration-150">Log Out Other Browser Sessions</button>
                    </div>
                </form>
            </div>
            <div 
                x-show="activeTab === 'delete_account'" 
                class="w-full md:w-3/4 xl:w-1/2"
            >
              
                    <section class="space-y-6">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Delete Account') }}
                            </h2>
                    
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                            </p>
                        </header>
                    
                        <x-danger-button
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                        >{{ __('Delete Account') }}</x-danger-button>
                    
                        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                                @csrf
                                @method('delete')
                    
                                <h2 class="text-lg font-medium text-gray-900">
                                    {{ __('Are you sure you want to delete your account?') }}
                                </h2>
                    
                                <p class="mt-1 text-sm text-gray-600">
                                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                                </p>
                    
                                <div class="mt-6">
                                    <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                    
                                    <x-text-input
                                        id="password"
                                        name="password"
                                        type="password"
                                        class="mt-1 block w-3/4 p-2 border"
                                        placeholder="{{ __('Password') }}"
                                    />
                    
                                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                                </div>
                    
                                <div class="mt-6 flex justify-end">
                                    <x-secondary-button x-on:click="$dispatch('close-modal', 'confirm-user-deletion')">
                                        {{ __('Cancel') }}
                                    </x-secondary-button>
                    
                                    <x-danger-button class="ms-3">
                                        {{ __('Delete Account') }}
                                    </x-danger-button>
                                </div>
                            </form>
                        </x-modal>
                    </section>
            
            </div>
        </div>
    </div>
<!-- end:Page content -->
@endsection
@push('bottom')
<script>

document.addEventListener('DOMContentLoaded', function () {

let cropper;

const input = document.getElementById('photoInput')
const modal = document.getElementById('cropModal')
const image = document.getElementById('imagePreview')
const avatarPreview = document.getElementById('avatarPreview')
const saveBtn = document.getElementById('saveCrop')
const cancelBtn = document.getElementById('cancelCrop')
const croppedInput = document.getElementById('croppedPhoto')

function openModal() {
    modal.classList.remove('hidden')
    modal.classList.add('flex')
}

function closeModal() {
    modal.classList.add('hidden')
    modal.classList.remove('flex')
}

function destroyCropper() {
    if (cropper) {
        cropper.destroy()
        cropper = null
    }
}

input.addEventListener('change', function (e) {

    const file = e.target.files[0]
    if (!file) return

    const reader = new FileReader()

    reader.onload = function (event) {

        image.src = event.target.result

        image.onload = function () {

            openModal()
            destroyCropper()

            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 1,
                autoCropArea: 1,
                responsive: true,
                background: false,
                movable: true,
                zoomable: true,
                scalable: false,
                rotatable: false,
            })
        }
    }

    reader.readAsDataURL(file)
})

saveBtn.addEventListener('click', function () {

if (!cropper) return

const canvas = cropper.getCroppedCanvas({
    width: 500,
    height: 500,
    imageSmoothingQuality: 'high'
})

canvas.toBlob(function (blob) {

    const formData = new FormData()
    formData.append('photo', blob)
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))

    fetch('{{ route("profile.photo.update") }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {

        avatarPreview.src = data.url

        cropper.destroy()
        cropper = null

        modal.classList.add('hidden')
        modal.classList.remove('flex')
        input.value = ''
    })

}, 'image/jpeg', 0.9)

})

cancelBtn.addEventListener('click', function () {
    destroyCropper()
    input.value = ''
    closeModal()
})

})


</script>
@endpush