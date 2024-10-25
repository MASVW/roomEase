@vite(['resources/css/app.css','resources/js/app.js'])
{{--@extends('layouts.app')--}}
<x-filament-panels::page>
    <div class="flex">
        <!-- SumarizeEvent Section: Hidden on md, Visible on xl -->
        <div class="flex-1 hidden xl:block xl:flex">
            <livewire:SumarizeEvent />
        </div>

        <!-- Calendar Section -->
        <div class="flex-grow">
            <x-filament::section class=",">
                <div class="w-4/5 mx-auto">
                    <div id="calendar" wire:ignore></div>
                </div>
            </x-filament::section>
        </div>
    </div>

</x-filament-panels::page>

@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', function() {
            let calendarEl = document.getElementById('calendar');
            let calendar = new Calendar(calendarEl, {
                plugins: [dayGridPlugin, timeGridPlugin, listPlugin, multiMonthPlugin, timeGridPlugin, interactionPlugin],
                initialView: 'dayGridMonth',
                allDaySlot: false,
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
        });
    </script>
@endpush
