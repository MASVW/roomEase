<section class="flex items-center justify-center min-h-screen py-8 antialiased md:py-12">
    <div class="max-w-4xl w-full">
        <div class="mx-auto px-4 2xl:px-0">
            <div class="col-span-7" id="calendar" wire:ignore></div>
        </div>
    </div>
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
                    // Adjust view settings based on the new window size
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
                selectAllow: function(selectInfo) {
                    var startTime = '09:00';
                    var endTime = '21:00';
                    var startHour = parseFloat(selectInfo.startStr.split('T')[1].substring(0, 5).replace(':', '.'));
                    var endHour = parseFloat(selectInfo.endStr.split('T')[1].substring(0, 5).replace(':', '.'));
                    return startHour >= parseFloat(startTime.replace(':', '.')) && endHour <= parseFloat(endTime.replace(':', '.'));
                },
                navLinks: true,
                selectable: true,
                selectOverlap: true,
                unselectAuto: true,
                select: function(info) {
                    Livewire.emit('dateSelected', info);
                },
                businessHours: {
                    daysOfWeek: [0, 1, 2, 3, 4, 5, 6],
                    startTime: '09:00',
                    endTime: '21:00',
                },
                eventClick: function(info) {
                    alert('Event: ' + info.event.title);
                    alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
                    alert('View: ' + info.view.type);

                    info.el.style.borderColor = 'red';
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
