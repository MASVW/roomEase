<section class="flex items-center justify-center min-h-screen py-8 antialiased md:py-12">
    <div class="max-w-4xl w-full">
        <div class="mx-auto px-4 2xl:px-0">
            <div class="col-span-7" id="calendar" wire:ignore></div>
        </div>
    </div>
    <livewire:detail-book-modal :roomId=$roomId />
</section>


@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', function() {
            let calendarEl = document.getElementById('calendar');
            let calendar = new Calendar(calendarEl, {
                plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
                initialView: 'dayGridMonth',
                allDaySlot: false,
                hiddenDays: [6, 0],
                headerToolbar: function() {
                    // Dynamically adjust header buttons based on screen width
                    if (window.innerWidth < 768) {
                        return {
                            left: 'prev,next',
                            center: 'title',
                            right: 'listWeek'
                        };
                    } else {
                        return {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay'
                        };
                    }
                }(),
                windowResize: function(view) {
                    if (window.innerWidth < 768) {
                        calendar.changeView('listWeek');
                    } else if (window.innerWidth >= 768 && window.innerWidth < 1024) {
                        calendar.changeView('timeGridWeek');
                    } else {
                        calendar.changeView('dayGridMonth');
                    }
                },
                slotEventOverlap: true,
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
                selectOverlap: true,
                unselectAuto: true,
                select: function(info) {
                    Livewire.dispatch('dateSelected', info);
                },
                businessHours: {
                    daysOfWeek: [0, 1, 2, 3, 4, 5, 6],
                    startTime: '09:00',
                    endTime: '21:00',
                },
                eventClick: function(info) {
                    Livewire.dispatch('eventSelected', {data: info});
                }
            });
            calendar.render();
            // Adjust initial view based on initial screen size
            if (window.innerWidth < 768) {
                calendar.changeView('listWeek');
            }
        });
    </script>

@endpush
