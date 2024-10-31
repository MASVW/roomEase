<?php

namespace App\Livewire;

use Livewire\Component;

class HeadingNavigationComponent extends Component
{
    public $categoryName;
    public function render()
    {
        return view('livewire.heading-navigation-component');
    }
}
