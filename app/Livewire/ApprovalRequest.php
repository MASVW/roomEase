<?php

namespace App\Livewire;

use App\Models\RequestRoom;
use Livewire\Component;

class ApprovalRequest extends Component
{
    public $record;
    public $status;

    public function mount(RequestRoom $record)
    {
        $this->record = $record;
        $this->status = $record->status;
    }

    public function updateStatus($newStatus)
    {
        $this->record->update(['status' => $newStatus]);
        $this->status = $newStatus;
        $this->emit('statusUpdated', $newStatus);
    }

    public function render()
    {
        return view('livewire.approval-request');
    }
}
