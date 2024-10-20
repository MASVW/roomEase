<section class="py-8 antialiased dark:bg-gray-900 md:py-12">
    <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
        <div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8">
            <div>
                <h2 class="mt-3 text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Lippo Plaza</h2>
            </div>
        </div>

        <div class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($room as $room)
                <a href="{{ route('detail-room', ['id' => $room->id]) }}"
                   class="cursor-pointer rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="w-full overflow-hidden rounded-lg">
                        @if(is_null($room->img))
                            <iframe class="cursor-pointer w-full h-full dark:hidden object-cover"
                                    src="https://lottie.host/embed/a4c3be28-903f-4676-8d2c-bc59f082e444/uTFX8nrs58.json">
                            </iframe>
                        @else
                            <img class="cursor-pointer w-full h-full dark:hidden object-cover"
                                 src="{{$room->img}}" alt="Ruangan {{$room->name}}" />
                        @endif
                    </div>
                    <div class="pt-6">
                        <div class="mb-4 flex items-center justify-between gap-4">
                            <span class="me-2 rounded bg-primary-100 px-2.5 py-0.5 text-xs font-medium text-primary-800 dark:bg-primary-900 dark:text-primary-300">
                                {{$this->upcomingEvent($room->id)}}
                            </span>
                            {{-- TODO: Creating Favorite and Save Feature --}}
                        </div>

                        <p class="text-lg font-semibold leading-tight text-gray-900 hover:underline dark:text-white">
                            Ruangan {{$room->name}}
                        </p>

                        <ul class="mt-2 flex items-center gap-4">
                            <li class="flex items-center gap-2">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Room Capacity: {{$room->capacity}}</p>
                                <div class="h-4 w-4 text-gray-500 dark:text-gray-400">
                                    <x-gmdi-groups />
                                </div>
                            </li>
                        </ul>

                        <div class="mt-4 flex items-center justify-end gap-4">
                            <button type="button"
                                    class="cursor-pointer flex items-center justify-center gap-2 rounded-lg bg-sky-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                <span class="flex items-center justify-center h-5 w-5">
                                    <x-bi-arrow-right-circle-fill />
                                </span>
                                See Details
                            </button>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
</section>
