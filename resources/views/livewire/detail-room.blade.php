<section class="py-4 antialiased md:py-4">
    <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0 space-y-16">
        <livewire:book-section :$selectedRoom id="{{$roomId}}" />

        <livewire:overview-section :$selectedRoom />
    </div>

    <livewire:room-list-component :$room/>
    <livewire:detail-book-modal :roomId=$roomId />

    <livewire:request-room-modal :roomId=$roomId />
</section>

@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', function() {
            let calendarEl = document.getElementById('calendar');
            let calendar = new Calendar(calendarEl, {
                plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
                initialView: 'timeGridWeek',
                allDaySlot: false,
                hiddenDays: [6, 0],
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay'
                },
                slotEventOverlap: true,
                events: @json($this->data),
                titleFormat: { year: 'numeric', month: 'long', day: 'numeric' },
                buttonText: {
                    month: 'Month',
                    week: 'Week',
                    list: 'List',
                    today: 'Today',
                    day: 'Day'
                },
                validRange: {
                    start: new Date().toISOString().slice(0, 10)
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
                    Livewire.dispatch('dateSelected', {data: info});
                },
                businessHours: {
                    daysOfWeek: [1, 2, 3, 4, 5],
                    startTime: '09:00',
                    endTime: '21:00',
                },
                eventClick: function(info) {
                    Livewire.dispatch('eventSelected', {data: info});
                }
            });
            calendar.render();
        });
    </script>
@endpush

