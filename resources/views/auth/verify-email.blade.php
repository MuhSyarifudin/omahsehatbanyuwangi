@extends('layouts.AuthenticationLayout')

@section('content')

<div class="bg-gray-200 w-full min-h-screen flex items-center justify-center">
    <div class="w-full py-8">
        <div class="flex items-center justify-center space-x-2">
            <img src="{{ url(asset('assets/img/logo-landscape.png')) }}" style="width: 240px;height: 80px" alt="">
        </div>
        <div class="bg-white w-5/6 md:w-3/4 lg:w-2/3 xl:w-[500px] 2xl:w-[550px] mt-8 mx-auto px-16 py-8 rounded-lg shadow-2xl">

            <h2 class="text-center text-2xl font-bold tracking-wide text-gray-800">Verify Your Email</h2>
            <p class="text-center text-sm text-gray-600 mt-2">No worries! Simply provide your email address, and we will send you a verification link that will allow you to verify your account and start using all the features.</p>


            <form class="my-8 text-sm" method="POST" action="{{ route('verification.send') }}">
                @csrf
                <div class="mb-4">
                    @if (session('message'))
                        <div class="bg-blue-100 text-blue-700 p-4 mb-4 rounded-lg">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
                <div class="flex flex-col my-4">
                    <label for="email" class="text-gray-700">{{ __('Enter your Email') }}</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="mt-2 py-2 border-gray-300 focus:outline-none focus:ring-0 focus:border-gray-300 rounded text-sm text-gray-900" 
                        placeholder="Enter your email"
                    >
                    @error('email')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            
                <div class="my-4 flex items-center justify-end space-x-4">
                    <button class="bg-primary hover:bg-primary-dark rounded-lg px-8 py-2 text-gray-100 hover:shadow-xl transition duration-150 uppercase">{{ __('Send Verification Link') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- 
<div class="container mx-auto p-4">
    <div class="flex justify-center">
        <div class="w-full md:w-1/2 lg:w-1/3">
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="text-lg font-semibold text-center mb-6">{{ __('Verifikasi Email Anda') }}</div>

                <div class="mb-4">
                    @if (session('message'))
                        <div class="bg-blue-100 text-blue-700 p-4 mb-4 rounded-lg">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Masukkan Email Anda') }}</label>
                        <input type="email" name="email" id="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition duration-200 ease-in-out">
                        {{ __('Kirim Link Verifikasi') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div> --}}

@endsection
