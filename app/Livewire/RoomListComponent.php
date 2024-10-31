<?php

namespace App\Livewire;

use App\Models\RequestRoom;
use App\Models\Room;
use App\Service\EventService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class RoomListComponent extends Component
{
    use WithPagination;

    public $categoryName;
    #[Url(history: true)]
    public $search = '';

    protected $listeners =[
        "searchUpdated" => "updateSearch"
        ];
    public function mount($categoryName = null)
    {
        if (!is_null($categoryName)) {
            $this->categoryName = $categoryName;
        }
        $this->dispatch('searchUpdated', search: $this->search)->to(HomePage::class);
    }
    public function ongoingEvent($id): string
    {
        return app(EventService::class)->ongoingEvent($id);
    }

    public function updateSearch(string $search = ''): void
    {
        $this->search = $search;
    }

    private function getBaseQuery(): object
    {
        $query = Room::query();

        if (!empty($this->categoryName)) {
            $query->whereHas('roomCategories', function($query) {
                $query->where('name', $this->categoryName);
            });
        }

        if (!empty($this->search)) {
            $query->where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('location', 'like', '%' . $this->search . '%')
                    ->orWhere('capacity', 'like', '%' . $this->search . '%')
                    ->orWhere('facilities', 'like', '%' . $this->search . '%');
            });
        }

        return $query;
    }
    public function render()
    {
        return view('livewire.room-list-component', [
            "rooms" => $this->getBaseQuery()->paginate(12)
        ]);
    }
}
