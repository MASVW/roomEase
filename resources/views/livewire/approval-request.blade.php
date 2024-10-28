<div>
    <select wire:model="status" wire:change="updateStatus($event.target.value)">
        <option value="pending">Pending</option>
        <option value="approved">Approved</option>
        <option value="rejected">Rejected</option>
    </select>
</div>
