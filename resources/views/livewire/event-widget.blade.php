<x-filament::section>
    <x-slot name="heading">
        Booking List
    </x-slot>
    <div class="space-y-4 max-h-[40rem] overflow-y-auto">
    @forelse($listBooking as $item)
        <x-filament::section
            collapsible
            collapsed
        >
            <x-slot name="heading">
                {{ \Illuminate\Support\Str::words($item->title, 3, '...') }} | {{ optional($item->room)->name ?? 'No Room' }}
            </x-slot>
            <p>{{$item->title}}</p>
            <p>
                @foreach($item->rooms as $index => $room)
                {{$room->name}}{{ $index < $item->rooms->count() - 1 ? ', ' : '' }}
            @endforeach
            </p>
            <p>{{$item->duration}}</p>
        </x-filament::section>
    @empty
    @endforelse
    </div>
</x-filament::section>
