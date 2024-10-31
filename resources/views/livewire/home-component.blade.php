<div>

    <livewire:search-section />

    @if(empty($search))
        <livewire:header-component />
    @endif

    <livewire:room-list-component />

    <livewire:calendar-component :$data />

</div>



