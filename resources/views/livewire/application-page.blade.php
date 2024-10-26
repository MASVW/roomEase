<section class="py-4 antialiased md:py-4 bg-gray-100">
    <div class="mx-auto max-w-screen-xl px-4 2xl:px-0 space-y-4">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Application') }}
            </h2>
        </div>

        <!-- Menambahkan overflow-auto dan max-h-screen untuk scrolling -->
        <div class="w-full bg-white shadow-sm px-4 py-5 rounded-lg divide-y divide-gray-200 space-y-4 overflow-auto max-h-[50rem]">
            <div class="mx-12 h-full">
                @forelse($this->listApplication as $application)
                    <div class="grid grid-rows-2 my-4">
                        <div class="content-end">
                            <p class="text-xs">Requested Date: {{ $this->service->formattingDate($application->created_at) }}</p>
                        </div>
                        <div class="grid grid-cols-12 content-center">
                            <div class="col-span-12 sm:col-span-4 md:col-span-4">
                                <p>{{$application->title}}</p>
                            </div>
                            <div class="col-span-12 sm:col-span-3 md:col-span-3 text-center">
{{--                                <p>13:00-17:00</p>--}}
                                <p>{{$this->eventDuration($application->start, $application->end)}}</p>
                            </div>
                            <div class="col-span-12 sm:col-span-3 md:col-span-3 text-center">
                                <p>{{$application->room->name}}</p>
                            </div>
                            <div class="col-span-12 sm:col-span-2 md:col-span-2 text-center capitalize">
                                <p>{{$application->status}}</p>
                            </div>
                        </div>
                    </div>
                    <hr>
                @empty
                    <div class="col-span-3 text-center mx-auto w-full flex items-center justify-center h-[50rem]">
                        <div class="text-center font-semibold capitalize">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <p>No Application.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
