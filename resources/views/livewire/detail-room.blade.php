<section class="py-4 antialiased dark:bg-gray-900 md:py-4">
    <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0 space-y-16">
        <livewire:book-section :$selectedRoom id="{{$roomId}}" />

        <livewire:overview-section :$selectedRoom />
    </div>

    <livewire:room-list-component :$room/>

    <livewire:request-room-modal />
</section>

@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', function() {
            let calendarEl = document.getElementById('calendar');
            let calendar = new Calendar(calendarEl, {
                plugins: [dayGridPlugin, timeGridPlugin, listPlugin, multiMonthPlugin, timeGridPlugin, interactionPlugin],
                initialView: 'timeGridWeek',
                hiddenDays: [6, 0],
                headerToolbar: {
                    right: 'timeGridWeek,timeGridDay'
                },
                slotEventOverlap : true,
                events: @json($this->data),
                titleFormat: { year: 'numeric', month: 'long' },
                buttonText: {
                    month: 'Month',
                    week: 'Week',
                    list: 'List',
                    today: 'Today',
                    day: 'Day'
                },
                navLinks: true,
                selectable: true,
                dateClick: function(info) {
                    Livewire.dispatch('dateSelected', {data: info.dateStr});
                }
            });
            calendar.render();
        });
    </script>
@endpush
