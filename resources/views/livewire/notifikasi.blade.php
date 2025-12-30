
                <!-- start::Notifications -->
                <div 
                x-data="{ linkActive: false }"
                    class="relative mx-6"
                >
                    <!-- start::Main link -->
                    <div
                        @click="linkActive = !linkActive"
                        class="cursor-pointer flex"
                    >
                        <svg class="w-6 h-6 cursor-pointer hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <sub>
                            <span  wire:poll.5s class="bg-red-600 text-gray-100 px-1.5 py-0.5 rounded-full -ml-1 animate-pulse">
                                {{ count($notifikasi) }}
                            </span>
                        </sub>
                    </div>
                    <!-- end::Main link -->
                    
                    <!-- start::Submenu -->
                    <div 
                        x-show="linkActive"
                        @click.away="linkActive = false"
                        x-cloak
                        class="absolute right-0 w-96 top-11 border border-gray-300 z-10"
                    >
                    <div>
                        <!-- start::Submenu content -->
                        <div class="bg-white rounded max-h-96 overflow-y-scroll custom-scrollbar">
                            <!-- start::Submenu header -->
                            <div class="flex items-center justify-between px-4 py-2">
                                <span class="font-bold">Notifications</span>

                                <span class="text-xs px-1.5 py-0.5 bg-red-600 text-gray-100 rounded" wire:poll.5s>
                                    {{ count($notifikasi) }}
                                </span>
                            </div>
                            <hr>
                            <!-- end::Submenu header -->
                            <!-- start::Submenu link -->
                            @if(count($notifikasi) > 0)
                                @foreach ($notifikasi as $notif)
                                        <a 
                                        x-data="{ linkHover: false }"
                                        class="flex items-center justify-between py-4 px-3 hover:bg-gray-100 bg-opacity-20"
                                        @mouseover="linkHover = true"
                                        @mouseleave="linkHover = false"
                                        
                                    >
                                        <div class="flex items-center">
                                            <svg class="w-8 h-8 bg-primary bg-opacity-20 text-primary px-1.5 py-0.5 rounded-full" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            <div class="text-sm ml-3">
                                                <p 
                                                    class="text-gray-600 font-bold capitalize"
                                                    :class=" linkHover ? 'text-primary' : ''"
                                                >{{ $notif->data['status'] }}</p>
                                                <p class="text-xs">{{ $notif->data['message'] }}</p>
                                            </div>
                                        </div>
                                        <span class="text-xs font-bold">
                                            {{ $notif->created_at->diffForHumans() }}
                                        </span>
                                    </a>   
                                    <button wire:click="tandaiDibaca({{ $notif->id }})" class="btn bg-amber-400 justify-end rounded-2xl text-xs m-1 p-1">Tandai dibaca</button>                                 
                                @endforeach
                            @else
                            <center><p class="text-muted mt-2">Tidak ada notifikasi baru</p></center>
                            @endif
                            <!-- end::Submenu link -->
                        </div>
                        <!-- end::Submenu content -->
                    </div>
                    
                    </div>
                    <!-- end::Submenu -->
                </div>
                <!-- end::Notifications -->
                

