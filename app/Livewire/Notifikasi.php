<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class Notifikasi extends Component
{

    public $notifikasi;

    public function mount()
    {
        $this->loadNotifikasi();
    }

    public function updateNotifikasi(){
        
        $this->loadNotifikasi();

    }

    public function loadNotifikasi()
    {
        if (Auth::check()) {
            $this->notifikasi = Auth::user()->unreadNotifications;
        } else {
            $this->notifikasi = collect(); // Return empty collection to avoid errors
        }
    }

    public function tandaiDibaca($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $notif = $user->notifications()->where('id', $id)->first();
        if ($notif) {
            $notif->markAsRead();
        }

        $this->loadNotifikasi(); // Refresh daftar notifikasi
    }

    public function render()
    {
        return view('livewire.notifikasi');
    }
}
