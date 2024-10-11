<x-filament::section>
    <x-slot name="heading">
        Booking List
    </x-slot>
    <div class="space-y-4">
    @for($i = 0; $i <10; $i++)
        <x-filament::section
            collapsible
            collapsed
        >
            <x-slot name="heading">
                SGS | LP601
            </x-slot>
            <p>Welcoming New Student</p>
            <p>LP601</p>
            <p>14 Agustus 2024</p>
        </x-filament::section>
    @endfor
    </div>
</x-filament::section>
