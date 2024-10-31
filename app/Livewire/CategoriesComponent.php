<?php

namespace App\Livewire;

use App\Models\RoomCategories;
use Livewire\Component;

class CategoriesComponent extends Component
{
    public function render()
    {
        $categories = RoomCategories::take(4)->get();
        return view('livewire.categories-component', [
            "categories" => $categories
        ]);
    }
}
