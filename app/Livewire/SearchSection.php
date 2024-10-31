<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;

class SearchSection extends Component
{
    public $categoryName = null;
    #[Url(history: true)]
    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];
    public function updatedSearch()
    {
        $this->dispatch('searchUpdated', search: $this->search);
    }
    public function render()
    {
        return view('livewire.search-section');
    }
}
