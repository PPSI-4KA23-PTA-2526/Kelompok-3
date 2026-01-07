<?php

namespace App\Livewire\Partial;

use App\helper\AddToCart;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cookie;

class Navbar extends Component
{
    public $search = '';

    public function render()
    {
        return view('livewire.partial.navbar');
    }
}
