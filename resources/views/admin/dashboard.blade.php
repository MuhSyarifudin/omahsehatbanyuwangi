@extends('layouts.DashboardLayout')
@push('top')
@endpush
@section('content')
                 <!-- start::Stats -->
                 <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-10">
                    <div class="px-6 py-6 bg-white rounded-lg shadow-xl">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-sm text-indigo-600">Keuntungan</span>
                            <span class="text-xs bg-gray-200 hover:bg-gray-500 text-gray-500 hover:text-gray-200 px-2 py-1 rounded-lg transition duration-200 cursor-default">Month</span>
                        </div>
                        <div class="flex items-center justify-between mt-6">
                            
                            <div class="flex flex-col">
                                <div class="flex items-end">
                                    <span class="text-2xl 2xl:text-4xl font-bold" id="jumlah-keuntungan">{{ rupiah($totalKeuntungan) }}</span>
                                    {{-- <div class="flex items-center ml-2 mb-1">
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                        <span class="font-bold text-sm text-gray-500 ml-0.5">3%</span>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 py-6 bg-white rounded-lg shadow-xl">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-sm text-green-600">Reservasi</span>
                            <span class="text-xs bg-gray-200 hover:bg-gray-500 text-gray-500 hover:text-gray-200 px-2 py-1 rounded-lg transition duration-200 cursor-default">Month</span>
                        </div>
                        <div class="flex items-center justify-between mt-6">
                            <div>
                                <svg class="w-12 2xl:w-16 h-12 2xl:h-16 p-1 2xl:p-3 bg-green-100 bg-opacity-20 rounded-full text-green-600 border border-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                            <div class="flex flex-col">
                                <div class="flex items-end">
                                    <span class="text-2xl 2xl:text-4xl font-bold" id="jumlah-reservasi">{{ $jumlahReservasi }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 py-6 bg-white rounded-lg shadow-xl">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-sm text-blue-600">Users</span>
                        </div>
                        <div class="flex items-center justify-between mt-6">
                            <div>
                                <svg class="w-12 2xl:w-16 h-12 2xl:h-16 p-1 2xl:p-3 bg-blue-100 bg-opacity-20 rounded-full text-blue-600 border border-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div class="flex flex-col">
                                <div class="flex items-end">
                                    <span class="text-2xl 2xl:text-4xl font-bold" id="jumlah-user">{{ $jumlahUser }}</span>
                                    <div class="flex items-center ml-2 mb-1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 py-6 bg-white rounded-lg shadow-xl">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-sm text-yellow-600">Visits</span>
                            <span class="text-xs bg-gray-200 hover:bg-gray-500 text-gray-500 hover:text-gray-200 px-2 py-1 rounded-lg transition duration-200 cursor-default">30 days</span>
                        </div>
                        <div class="flex items-center justify-between mt-6">
                            <div>
                                <svg class="w-12 2xl:w-16 h-12 2xl:h-16 p-1 2xl:p-3 bg-yellow-100 bg-opacity-20 rounded-full text-yellow-600 border border-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </div>
                            <div class="flex flex-col">
                                <div class="flex items-end">
                                    <span class="text-2xl 2xl:text-4xl font-bold" id="jumlah-visitor">{{ $jumlahVisitor }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end::Stats -->

                    <div class="w-full flex flex-col lg:flex-row items-center justify-between
                    bg-white my-16 px-2 py-4 rounded-lg shadow-lg">
                        <div class="w-full lg:w-2/3">
                        <h4 class="text-center text-xl font-semibold mb-4">Statistik Keuntungan</h4>

                        <div class="flex items-center gap-3">
                            <label for="tahunSelect"
                                class="text-sm font-medium text-gray-600 ml-7">
                                Pilih Tahun
                            </label>
                        
                            <div class="relative">
                                <select id="tahunSelect"
                                    class="appearance-none bg-white
                                           border border-blue-500
                                           text-gray-700 text-sm
                                           rounded-xl
                                           pl-4 pr-10 py-1
                                           shadow-sm
                                           focus:outline-none
                                           focus:ring-2 focus:ring-blue-500
                                           focus:border-blue-500
                                           hover:border-blue-600
                                           transition">
                                    @for ($i = now()->year; $i >= now()->year - 5; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                        
                                <svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2
                                            h-4 w-4 text-blue-500"
                                    fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>

                            <div>
                                <canvas id="profitChart"></canvas>
                            </div>
                        </div>
                    </div>
                
            </div>
@endsection

@push('bottom')

<script type="module" src="{{ url(asset('assets/js/dashboard.js')) }}"></script>
<script>
let chart;


</script>
@endpush