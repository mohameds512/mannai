<?php

namespace App\Http\Livewire\usercrud;

use Livewire\Component;

class AddUserComponent extends Component
{
    public function render()
    {
        return view('livewire.usercrud.add-user-component')->layout('livewire.layouts.base');
    }
}
