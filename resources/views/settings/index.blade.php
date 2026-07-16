@extends('layouts.DashboardLayout')
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
            
            <!-- PROFILE TAB -->
    <div 
        x-show="activeTab === 'profile'" 
        class="w-full max-w-3xl"
    >
        <form class="space-y-10" method="post" action="{{ route('settings.update') }}">
            @csrf
            @method('patch')

            <!-- PHOTO -->
            <div class="rounded-3xl border border-gray-100 bg-gradient-to-br from-white to-gray-50 p-6 shadow-sm">
                
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">
                            Profile Photo
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Upload foto profile baru untuk akun anda
                        </p>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row md:items-center gap-6">

                    <!-- Preview -->
                    <div class="relative group">
                        <img 
                            id="avatarPreview" 
                            src="{{ url($user->avatar ? asset('storage/'.$user->avatar) : asset('assets/img/blank-profile.png')) }}"
                            class="w-28 h-28 rounded-full object-cover ring-4 ring-white shadow-xl border border-gray-100"
                        >

                        <div class="absolute inset-0 rounded-full bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                            <span class="text-white text-xs font-medium">
                                Change
                            </span>
                        </div>
                    </div>

                    <!-- Action -->
                    <div class="space-y-3">
                        <label 
                            for="photoInput" 
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-gray-900 text-white text-sm font-medium cursor-pointer hover:scale-[1.02] hover:shadow-xl transition duration-200"
                        >
                            Upload Photo
                        </label>

                        <p class="text-xs text-gray-400">
                            JPG, PNG atau WEBP
                        </p>
                    </div>

                </div>

                <input type="file" id="photoInput" accept="image/*" class="hidden">
                <input type="hidden" name="cropped_photo" id="croppedPhoto">

                @if (($profilePhotos ?? collect())->isNotEmpty())
                    <div class="mt-8">
                        
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-sm font-semibold text-gray-700">
                                Previous Photos
                            </h4>

                            <span class="text-xs text-gray-400">
                                {{ count($profilePhotos) }} photos
                            </span>
                        </div>

                        <div id="previousProfilePhotosGrid" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-4">

                            @foreach ($profilePhotos as $profilePhoto)

                                <div
                                    class="profile-photo-item group relative overflow-visible {{ $user->avatar === $profilePhoto->path ? 'is-active' : '' }}"
                                    data-photo-path="{{ $profilePhoto->path }}"
                                >

                                    <button
                                        type="button"
                                        class="previous-profile-photo relative overflow-hidden rounded-2xl border-2 transition duration-300 w-full aspect-square
                                        {{ $user->avatar === $profilePhoto->path 
                                            ? 'border-primary shadow-lg shadow-primary/20' 
                                            : 'border-gray-100 hover:border-gray-300' }}"
                                    >

                                        <img
                                            src="{{ url(asset('storage/'.$profilePhoto->path)) }}"
                                            class="h-full w-full object-cover transition duration-500 group-hover:scale-110"
                                            alt="Foto profile sebelumnya"
                                        >

                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition pointer-events-none"></div>

                                        @if ($user->avatar === $profilePhoto->path)
                                            <span class="profile-photo-active-badge absolute bottom-2 left-1/2 -translate-x-1/2 z-10 px-2.5 py-1 rounded-full bg-primary text-white text-[10px] font-semibold shadow-lg transition-opacity duration-200 group-hover:opacity-0">
                                                Aktif
                                            </span>
                                        @endif

                                    </button>

                                    <!-- DELETE: desktop = hover, mobile = tap foto aktif -->
                                    <button
                                        type="button"
                                        class="delete-profile-photo absolute -top-2 -right-2 z-30 flex h-8 w-8 items-center justify-center rounded-full bg-white shadow-lg border border-gray-200 text-gray-600 hover:bg-red-500 hover:text-white transition duration-200 opacity-0 pointer-events-none max-lg:scale-90 lg:group-hover:opacity-100 lg:group-hover:pointer-events-auto lg:group-hover:scale-110"
                                        title="Hapus foto"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>

                                </div>

                            @endforeach

                        </div>
                    </div>
                @endif
            </div>

            <!-- BACKGROUND -->
            <div class="rounded-3xl border border-gray-100 bg-gradient-to-br from-white to-gray-50 p-6 shadow-sm">

                <div class="mb-5">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Profile Background
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Sesuaikan tampilan halaman profile anda
                    </p>
                </div>

                <div class="relative overflow-hidden rounded-3xl border border-gray-100 shadow-lg">

                    <img
                        id="backgroundPreview"
                        src="{{ url($user->background ? asset('storage/'.$user->background) : asset('assets/img/team-background.jpg')) }}"
                        class="h-56 w-full object-cover hover:scale-105 transition duration-700"
                    >

                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                    <div class="absolute bottom-4 left-4">
                        <label 
                            for="backgroundInput"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-white/90 backdrop-blur-md text-gray-800 text-sm font-medium cursor-pointer hover:bg-white transition"
                        >
                            Change Background
                        </label>
                    </div>

                </div>

                <input type="file" id="backgroundInput" accept="image/*" class="hidden">

            </div>

            <!-- FORM -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="space-y-2">
                    <label for="name" class="text-sm font-medium text-gray-600">
                        Full Name
                    </label>

                    <input 
                        type="text" 
                        name="name" 
                        id="name"
                        value="{{ $user->name }}"
                        autocomplete="off"
                        class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-white/70 backdrop-blur-sm text-gray-900 focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition"
                    >
                </div>

                <div class="space-y-2">
                    <label for="email" class="text-sm font-medium text-gray-600">
                        Email Address
                    </label>

                    <input 
                        type="email" 
                        name="email" 
                        id="email"
                        value="{{ $user->email }}"
                        autocomplete="off"
                        class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-white/70 backdrop-blur-sm text-gray-900 focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition"
                    >
                </div>

            </div>

            <!-- SAVE -->
            <div class="pt-2">
                <button 
                    class="inline-flex items-center justify-center gap-2 px-7 py-3 rounded-2xl bg-gradient-to-r from-primary to-primary-dark text-white font-semibold shadow-lg shadow-primary/20 hover:scale-[1.02] hover:shadow-2xl transition duration-300"
                >
                    Save Changes
                </button>
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
    <!-- Modal crop foto profil -->
    <div id="cropModal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4 transition-opacity duration-200">
        <div class="bg-white w-full max-w-lg max-h-[90vh] rounded-2xl shadow-xl flex flex-col">
            <div class="p-6 pb-3">
                <h3 class="text-lg font-semibold text-gray-800">Sesuaikan Foto Profil</h3>
            </div>
            <div class="px-6 overflow-auto flex-1">
                <div class="rounded-xl overflow-hidden bg-gray-100">
                    <img id="imagePreview" class="max-w-full block">
                </div>
            </div>
            <div class="px-6 py-4 space-y-4 border-t border-gray-100">
                <div class="flex items-center justify-center gap-3">
                    <button type="button" id="rotateLeft"
                        class="px-3 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                        ⟲ Putar Kiri
                    </button>
                    <button type="button" id="rotateRight"
                        class="px-3 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                        Putar Kanan ⟳
                    </button>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-2">Zoom</label>
                    <input type="range" id="zoomSlider" min="0" max="1" step="0.01" value="0"
                        class="w-full accent-gray-900">
                </div>
            </div>
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

    <!-- Modal crop background -->
    <div id="backgroundCropModal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4 transition-opacity duration-200">
        <div class="bg-white w-full max-w-3xl max-h-[90vh] rounded-2xl shadow-xl flex flex-col">
            <div class="p-6 pb-3">
                <h3 class="text-lg font-semibold text-gray-800">Sesuaikan Background Profil</h3>
            </div>
            <div class="px-6 overflow-auto flex-1">
                <div class="rounded-xl overflow-hidden bg-gray-100">
                    <img id="backgroundImagePreview" class="max-w-full block">
                </div>
            </div>
            <div class="px-6 py-4 space-y-4 border-t border-gray-100">
                <div class="flex items-center justify-center gap-3">
                    <button type="button" id="backgroundRotateLeft"
                        class="px-3 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                        ⟲ Putar Kiri
                    </button>
                    <button type="button" id="backgroundRotateRight"
                        class="px-3 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                        Putar Kanan ⟳
                    </button>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-2">Zoom</label>
                    <input type="range" id="backgroundZoomSlider" min="0" max="1" step="0.01" value="0"
                        class="w-full accent-gray-900">
                </div>
            </div>
            <div class="p-6 pt-4 flex justify-end gap-3 border-t border-gray-100">
                <button type="button" id="backgroundCancelCrop"
                    class="px-4 py-2 rounded-xl text-sm font-medium border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                    Batal
                </button>
                <button type="button" id="backgroundSaveCrop"
                    class="px-4 py-2 rounded-xl text-sm font-medium bg-gray-900 text-white hover:bg-black transition">
                    Simpan
                </button>
            </div>
        </div>
    </div>

<!-- end:Page content -->
@endsection

@push('bottom')
<style>
    @media (max-width: 1023px) {
        .profile-photo-item.is-active.show-delete .delete-profile-photo {
            opacity: 1 !important;
            pointer-events: auto !important;
            transform: scale(1) !important;
        }

        .profile-photo-item.is-active.show-delete .profile-photo-active-badge {
            opacity: 0 !important;
        }
    }
</style>
@endpush
