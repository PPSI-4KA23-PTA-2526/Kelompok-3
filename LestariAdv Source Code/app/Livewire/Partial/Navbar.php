<?php

namespace App\Livewire\Partial;

use Livewire\Component;

class Navbar extends Component
{
    public $search = '';

    public function render()
    {
        return view('livewire.partial.navbar');
    }
}
