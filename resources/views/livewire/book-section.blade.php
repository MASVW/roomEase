<div class="lg:grid lg:grid-cols-12 lg:gap-8 xl:gap-16">

    {{--CALENDAR--}}
    <div class="col-span-7" id="calendar" wire:ignore></div>

    {{--INFORMATION--}}
    <div class="col-span-5 mt-6 sm:mt-8 lg:mt-0">

        <div class="space-y-4">
            <div class="mt-4 sm:items-center sm:gap-4 sm:flex">
                <p class="text-2xl font-extrabold text-gray-900 sm:text-3xl">
                    {{$selectedRoom->name}} ROOM
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
                        <p class="capitalize">{{$this->formattedDate($event->start)}} - {{$event->booking->user->nickname}}, {{$event->title}}</p>
                    @endforeach
                    </div>
                @endif

            </div>
        </div>
        <div class="mt-6 sm:gap-4 sm:items-center sm:flex sm:mt-8 justify-end">
            <livewire:modal-button />
        </div>

        <hr class="my-6 md:my-8 border-gray-200" />
    </div>
</div>
