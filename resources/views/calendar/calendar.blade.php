@vite(['resources/css/app.css','resources/js/app.js'])

<x-filament-panels::page>
    <div class="flex">
        <!-- SumarizeEvent Section: Hidden on md, Visible on xl -->
        <div class="flex-1 hidden xl:block xl:flex">
            <livewire:SumarizeEvent />
        </div>

        <!-- Calendar Section -->
        <div class="flex-grow">
            <div id="calendar" wire:ignore></div>
        </div>
    </div>

</x-filament-panels::page>

@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', function() {

            // Initialize FullCalendar
            let calendarEl = document.getElementById('calendar');
            let calendar = new Calendar(calendarEl, {
                plugins: [dayGridPlugin, timeGridPlugin, listPlugin, multiMonthPlugin],
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'multiMonth,dayGridMonth,timeGridWeek,listWeek'
                },
                hiddenDays: [6, 7],
                aspectRatio: 1, // Optional
                events: @json($this->data),
                titleFormat: { year: 'numeric', month: 'long' },
                buttonText: {
                    month: 'Month',
                    week: 'Week',
                    list: 'List',
                    today: 'Today'
                },
                navLinks: true,
                selectable: true,
            });

            // Render the FullCalendar
            calendar.render();
        });
    </script>
@endpush
