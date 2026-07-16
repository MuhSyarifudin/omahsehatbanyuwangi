@extends('layouts.DashboardLayout')

@section('content')
@php
    $avatarUrl = url($user->avatar ? asset('storage/'.$user->avatar) : asset('assets/img/blank-profile.png'));
    $coverUrl = url($user->background ? asset('storage/'.$user->background) : asset('assets/img/team-background.jpg'));
    $joinedDate = $user->created_at ? dateid('j F Y', strtotime($user->created_at)) : '-';
    $joinedRelative = $user->created_at ? $user->created_at->diffForHumans() : '-';
    $verified = (bool) $user->email_verified_at;
    $lastSeen = $user->last_seen ?? $user->last_activity ?? null;
    $lastSeenText = $lastSeen ? \Carbon\Carbon::parse($lastSeen)->diffForHumans() : 'Belum tersedia';
    $roleLabel = ucfirst($user->role ?? 'User');
@endphp

<div class="space-y-6">
    <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
        <div class="relative min-h-[280px]">
            <img
                src="{{ $coverUrl }}"
                alt="Profile cover"
                class="absolute inset-0 h-full w-full object-cover"
            >
            <div class="absolute inset-0 bg-gray-900/60"></div>

            <div class="relative flex min-h-[280px] flex-col justify-between p-6 sm:p-8 lg:p-10">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-wide text-emerald-200">Profil Pengguna</p>
                        <h1 class="mt-1 text-3xl font-bold text-white sm:text-4xl">{{ $user->name }}</h1>
                    </div>

                    <a
                        href="{{ route('settings.edit') }}"
                        class="inline-flex items-center gap-2 rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm transition hover:bg-gray-100"
                    >
                        <i class="fa-solid fa-pen-to-square text-emerald-600"></i>
                        Edit Profile
                    </a>
                </div>

                <div class="grid gap-6 lg:grid-cols-[auto,1fr] lg:items-end">
                    <div class="relative w-fit">
                        <img
                            id="avatarPreview" 
                            src="{{ $avatarUrl }}"
                            alt="{{ $user->name }}"
                            class="h-36 w-36 rounded-lg border-4 border-white object-cover shadow-xl sm:h-44 sm:w-44"
                        >
                        <span class="absolute -bottom-3 left-4 inline-flex items-center gap-2 rounded-md bg-emerald-500 px-3 py-1 text-xs font-semibold text-white shadow">
                            <span class="h-2 w-2 rounded-full bg-white"></span>
                            {{ $roleLabel }}
                        </span>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-3">
                        <div class="rounded-lg border border-white/20 bg-white/15 p-4 text-white backdrop-blur">
                            <p class="text-xs uppercase text-white/70">Email</p>
                            <p class="mt-1 truncate text-sm font-semibold">{{ $user->email }}</p>
                        </div>
                        <div class="rounded-lg border border-white/20 bg-white/15 p-4 text-white backdrop-blur">
                            <p class="text-xs uppercase text-white/70">Status</p>
                            <p class="mt-1 text-sm font-semibold">{{ $verified ? 'Terverifikasi' : 'Belum verifikasi' }}</p>
                        </div>
                        <div class="rounded-lg border border-white/20 bg-white/15 p-4 text-white backdrop-blur">
                            <p class="text-xs uppercase text-white/70">Bergabung</p>
                            <p class="mt-1 text-sm font-semibold">{{ $joinedRelative }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="grid gap-6 xl:grid-cols-[1fr,360px]">
        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase text-emerald-600">Data Diri</p>
                    <h2 class="mt-1 text-2xl font-bold text-gray-900">Informasi akun</h2>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600">
                        Ringkasan identitas akun yang digunakan untuk mengakses dashboard Omah Sehat Banyuwangi.
                    </p>
                </div>

                <span class="inline-flex w-fit items-center gap-2 rounded-md bg-gray-100 px-3 py-2 text-sm font-semibold text-gray-700">
                    <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                    {{ $verified ? 'Akun aktif' : 'Perlu verifikasi' }}
                </span>
            </div>

            <div class="mt-8 grid gap-4 md:grid-cols-2">
                <div class="rounded-lg border border-gray-200 p-5">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-md bg-emerald-100 text-emerald-700">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <div class="min-w-0">
                            <p class="text-xs font-semibold uppercase text-gray-500">Nama lengkap</p>
                            <p class="truncate font-semibold text-gray-900">{{ $user->name }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border border-gray-200 p-5">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-md bg-sky-100 text-sky-700">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <div class="min-w-0">
                            <p class="text-xs font-semibold uppercase text-gray-500">Email</p>
                            <p class="truncate font-semibold text-gray-900">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border border-gray-200 p-5">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-md bg-amber-100 text-amber-700">
                            <i class="fa-solid fa-calendar-check"></i>
                        </span>
                        <div>
                            <p class="text-xs font-semibold uppercase text-gray-500">Tanggal bergabung</p>
                            <p class="font-semibold text-gray-900">{{ $joinedDate }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border border-gray-200 p-5">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-md bg-rose-100 text-rose-700">
                            <i class="fa-solid fa-clock"></i>
                        </span>
                        <div>
                            <p class="text-xs font-semibold uppercase text-gray-500">Aktivitas terakhir</p>
                            <p class="font-semibold text-gray-900">{{ $lastSeenText }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <aside class="space-y-6">
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900">Foto Profil</h2>
                <div class="mt-5 flex flex-col items-center text-center">
                    <img
                        id="avatarPreview2" 
                        src="{{ $avatarUrl }}"
                        alt="{{ $user->name }}"
                        class="h-32 w-32 rounded-lg object-cover ring-4 ring-emerald-100"
                    >
                    <p class="mt-4 text-base font-bold text-gray-900">{{ $user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $roleLabel }}</p>
                </div>
                <label  for="photoInput"
                    class="cursor-pointer mt-6 inline-flex w-full items-center justify-center gap-2 rounded-md bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700"
                    id="backgroundInput"
                    >
                    <i class="fa-solid fa-camera"></i>
                    Ubah Foto
                </label>

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

                    <!-- Image Area -->
                    <div class="px-6 overflow-auto flex-1">
                        <div class="rounded-xl overflow-hidden bg-gray-100">
                            <img id="imagePreview" class="max-w-full">
                        </div>
                    </div>

                    <!-- Control Area -->
                    <div class="px-6 py-4 space-y-4 border-t border-gray-100">

                        <!-- Rotate Buttons -->
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

                        <!-- Zoom Slider -->
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-2">
                                Zoom
                            </label>
                            <input type="range"
                                id="zoomSlider"
                                min="0"
                                max="1"
                                step="0.01"
                                value="0"
                                class="w-full accent-gray-900">
                        </div>

                    </div>

                    <!-- Footer -->
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
                
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900">Keamanan akun</h2>
                <div class="mt-5 space-y-4">
                    <div class="flex items-center justify-between gap-4">
                        <span class="text-sm text-gray-600">Verifikasi email</span>
                        <span class="rounded-md px-2.5 py-1 text-xs font-semibold {{ $verified ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ $verified ? 'Selesai' : 'Pending' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between gap-4">
                        <span class="text-sm text-gray-600">Role akses</span>
                        <span class="rounded-md bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700">{{ $roleLabel }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-4">
                        <span class="text-sm text-gray-600">User ID</span>
                        <span class="rounded-md bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700">#{{ $user->id }}</span>
                    </div>
                </div>
            </div>
        </aside>
    </section>
</div>
@endsection
