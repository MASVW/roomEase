<x-filament::section>
    <x-slot name="heading">
        Pick a Date
    </x-slot>

    <input type="text" data-picker>
</x-filament::section>
@script
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Pikaday({
            field: document.querySelector('[data-picker]')
        });
    });
</script>
@endscript

