<?php

namespace App\Livewire;

use App\Models\Room;
use Livewire\Component;

class OverviewSection extends Component
{
    public $selectedRoom;
    public $buildingName;
    public $buildingCode;

    public $floor;

    public $roomNumber;

    public function mount()
    {
        $this->parseRoomCode($this->selectedRoom['name']);
    }

    public function parseRoomCode($roomCode)
    {
        $this->buildingCode = substr($roomCode, 0, 2);

        switch ($this->buildingCode) {
            case 'LP':
                $this->buildingName = 'Lippo Plaza';
                break;
            case 'AD':
                $this->buildingName = 'Arya Duta';
                break;
            default:
                $this->buildingName = 'Tidak Dikenal';
        }
        $this->floor = substr($roomCode, 2, 1);
        $this->roomNumber = substr($roomCode, 2);
    }

    public function ordinalSuffix($num)
    {
        $lastTwoDigits = $num % 100;

        if ($lastTwoDigits >= 11 && $lastTwoDigits <= 13) {
            return $num . 'th';
        }

        switch ($num % 10) {
            case 1:
                return 'st';
            case 2:
                return 'nd';
            case 3:
                return 'rd';
            default:
                return 'th';
        }
    }

    public function render()
    {
        return view('livewire.overview-section');
    }
}
