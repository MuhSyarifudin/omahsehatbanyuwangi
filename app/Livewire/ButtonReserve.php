<?php

namespace App\Livewire;

use Livewire\Component;

class ButtonReserve extends Component
{
    public function render()
    {
        return view('livewire.button-reserve');
    }

    public function update(){

        $this->dispatch('updateNotifications');
    }
}
