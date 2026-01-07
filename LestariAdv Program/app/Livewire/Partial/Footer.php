<?php

namespace App\Livewire\Partial;

use App\Models\Category;
use Livewire\Component;

class Footer extends Component
{

    public function render()
    {
        return view('livewire.partial.footer', [
            'categories' => Category::active()
                ->ordered()
                ->limit(5)
                ->get()
        ]);
    }
}
