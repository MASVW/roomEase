<x-filament::section>
    <x-slot name="heading">
        Pick a Date
    </x-slot>
    <div x-data="{ date: '' }">
        <input type="text" x-model="date" x-ref="flatpickr" />
    </div>
</x-filament::section>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('flatpickr', () => ({
                init() {
                    flatpickr(this.$refs.flatpickr, {
                        onChange: (selectedDates, dateStr, instance) => {
                            // Mengupdate model Laravel Livewire jika diperlukan
                            this.$wire.set('name', dateStr);
                        }
                    });
                }
            }));
        });
    </script>
@endpush
