<div class="lg:grid lg:grid-cols-12 lg:gap-8 xl:gap-16">

    {{--CALENDAR--}}
    <div class="col-span-7" id="calendar" wire:ignore></div>

    {{--INFORMATION--}}
    <div class="col-span-5 mt-6 sm:mt-8 lg:mt-0">

        <div class="space-y-4">
            <div class="mt-4 sm:items-center sm:gap-4 sm:flex">
                <p class="text-2xl font-extrabold text-gray-900 sm:text-3xl">
                    ROOM {{$selectedRoom->name}}
                </p>
            </div>
            <div>
                <h1 class="text-xl font-semibold text-gray-900 capitalize">
                    {{$this->ongoingEvent($id)}}
                </h1>
            </div>
            <div class="text-black/70">
                <p class="my-2 font-semibold">Upcoming Event : </p>
                @if($upcomingEvent->isEmpty())
                    <p>No Upcoming Events</p>
                @else
                    <div class="space-y-1">
                    @foreach($upcomingEvent as $event)
                        <p class="capitalize">{{$this->formattedDate($event->start)}} - {{$event->booking->user->name}}, {{$event->event_title}}</p>
                    @endforeach
                    </div>
                @endif

            </div>
        </div>
        <div class="mt-6 sm:gap-4 sm:items-center sm:flex sm:mt-8 justify-end">
            <livewire:modal-button />
        </div>

        <hr class="my-6 md:my-8 border-gray-200" />


{{--        <p class="mb-6 text-gray-500">--}}
{{--            Studio quality three mic array for crystal clear calls and voice--}}
{{--            recordings. Six-speaker sound system for a remarkably robust and--}}
{{--            high-quality audio experience. Up to 256GB of ultrafast SSD storage.--}}
{{--        </p>--}}

{{--        <p class="text-gray-500">--}}
{{--            Two Thunderbolt USB 4 ports and up to two USB 3 ports. Ultrafast--}}
{{--            Wi-Fi 6 and Bluetooth 5.0 wireless. Color matched Magic Mouse with--}}
{{--            Magic Keyboard or Magic Keyboard with Touch ID.--}}
{{--        </p>--}}
    </div>
</div>
