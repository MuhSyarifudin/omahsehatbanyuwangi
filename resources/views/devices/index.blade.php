@extends('layouts.DashboardLayout')
    

@section('content')
<div class="bg-white rounded-lg px-8 py-6 overflow-x-scroll custom-scrollbar mb-12 min-h-20">
    <div class="py-5">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold">All Devices</h1>
                <a href="{{ route('devices.create') }}"
                    class="flex space-x-2 items-center justify-center bg-green-500 hover:bg-green-600 rounded-sm px-6 py-1.5 text-gray-100 hover:shadow-xl transition duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    <span>Add New Device</span>
                </a>
            </div>

            @if (session('success'))
                <div class="p-4 mb-4 text-green-700 bg-green-100 border-l-4 border-green-500" role="alert">
                    <p class="font-bold">Success!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="overflow-x-auto">
                <div id="notification" class="hidden p-4 mb-4 text-green-700 bg-green-100 border-l-4 border-green-500"
                    role="alert">
                    <p id="notificationMessage" class="font-bold"></p>
                </div>

                <div x-data="{ isOpen: false, qrCode: '', loading: false }">
                    <table class="w-full whitespace-nowrap my-4">
                        <thead class="border-b border-gray-300 bg-gray-800 text-gray-100">
                            <tr>
                                <th class="p-2 text-center rounded-tl-lg rounded-bl-lg">#</th>
                                <th class="p-2 text-center">Name</th>
                                <th class="p-2 text-center">Phone</th>
                                <th class="p-2 text-center">Quota</th>
                                <th class="p-2 text-center">Status</th>
                                <th class="p-2 text-center rounded-tr-lg rounded-br-lg">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($devices as $index => $device)
                                <tr class="border-b border-gray-200">
                                    <td class="p-2 text-center">{{ $index + 1 }}</td>
                                    <td class="p-2 text-center">{{ $device['name'] }}</td>
                                    <td class="p-2 text-center">{{ $device['device'] }}</td>
                                    <td class="p-2 text-center">{{ $device['quota'] }}</td>
                                    <td class="p-2 text-center">
                                        @if ($device['status'] === 'connect')
                                            <span class="px-2 py-2 text-sm font-semibold text-white bg-green-500 rounded">
                                                Connected
                                            </span>
                                        @else
                                            <span class="px-2 py-2 text-sm font-semibold text-white bg-red-500 rounded">
                                                Disconnect
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 space-x-2">
                                        <button
                                        class="px-2 py-2 text-sm font-semibold text-white bg-blue-500 rounded hover:bg-blue-600"
                                        onclick="copyToClipboard('{{ $device['token'] }}')">
                                        Copy Token
                                    </button>
                                    
                                    @if ($device['status'] === 'connect')
                                        <button class="px-2 py-2 text-sm text-white rounded bg-slate-500"
                                            onclick="openSendMessageModal('{{ $device['token'] }}')">
                                            Send Message
                                        </button>
                                    
                                        <button class="px-2 py-2 text-sm text-white bg-red-500 rounded disconnectButton"
                                            data-device-token="{{ $device['token'] }}"
                                            onclick="disconnectDevice('{{ $device['token'] }}')">
                                            Disconnect
                                            <svg class="hidden w-4 h-4 ml-1 text-white disconnectSpinner animate-spin"
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                            </svg>
                                        </button>
                                    @else
                                        <!-- Tombol Connect dengan Alpine.js -->
                                        <button @click="activateDevice('{{ $device['device'] }}', '{{ $device['token'] }}', $el)"
                                            class="px-2 py-2 text-sm text-white bg-green-500 hover:bg-green-600 rounded">
                                            Connect
                                        </button>
                                    @endif
                                    
                                    <button class="px-2 py-2 text-sm text-white bg-orange-500 hover:bg-orange-600 rounded"
                                        onclick="confirmDelete('{{ $device['token'] }}', '{{ $device['name'] }}')">
                                        Delete
                                    </button>
                                    
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @include('devices.partials.modal-qr-code')
                </div>
            </div>
        </div>
    </div>
</div>

    @include('devices.partials.modal-device-details')
    @include('devices.partials.modal-confirmation-delete')
    @include('devices.partials.modal-confirmation-disconnect')
    @include('devices.partials.modal-otp-delete')
    @include('devices.partials.modal-send-message')
    @include('devices.partials.script')

@endsection