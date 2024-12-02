<section class="py-4 antialiased md:py-8">
    <div class="mx-auto max-w-screen-xl px-2 sm:px-4 2xl:px-0">
        <div class="mb-2 items-end justify-between space-y-2 sm:flex sm:space-y-0 md:mb-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-900 sm:text-xl md:text-2xl">
                    @if($this->search)
                        Search For: {{$this->search}}
                    @elseif(is_null($categoryName))
                        All Room At UPH Medan Campus
                    @else
                        Room for Categories: {{$categoryName}}
                    @endif
                </h2>
            </div>
        </div>

        <div class="my-10">
            {{ $rooms->links(data: ['scrollTo' => false]) }}
        </div>

        <!-- Menambahkan 4 kolom pada perangkat mobile dengan responsif -->
        <div class="grid gap-2 md:gap-4 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-4">
            @foreach($rooms as $room)
                <a href="{{ route('detail-room', ['id' => $room->id]) }}"
                   class="block cursor-pointer rounded-lg border border-gray-200 bg-white p-3 sm:p-4 md:p-6 shadow-md">
                    <div class="w-full overflow-hidden rounded-lg">
                        @if(is_null($room->img) || $room->img == [])
                            <iframe class="w-full h-32 sm:h-40 md:h-48 object-cover"
                                    src="https://lottie.host/embed/a4c3be28-903f-4676-8d2c-bc59f082e444/uTFX8nrs58.json">
                            </iframe>
                        @else
                            <img class="w-full h-32 sm:h-40 md:h-48 object-cover"
                                 src="https://storage.googleapis.com/room-ease/{{ $room->img[0] }}" alt="Ruangan {{ $room->name }}" />
                        @endif
                    </div>
                    <div class="pt-2 sm:pt-3 md:pt-4">
                        <div class="mb-1 sm:mb-2 flex items-center justify-between gap-2">
                            <span class="rounded bg-primary-100 px-1.5 py-0.5 text-xs font-medium text-primary-800">
                                {{$this->ongoingEvent($room->id)}}
                            </span>
                            {{-- TODO: Creating Favorite and Save Feature --}}
                        </div>

                        <p class="text-sm font-medium leading-snug text-gray-900 hover:underline">
                            Ruangan {{$room->name}}
                        </p>

                        <ul class="mt-1 flex items-center gap-2">
                            <li class="flex items-center gap-1">
                                <p class="text-xs text-gray-500">Capacity: {{$room->capacity}}</p>
                                <div class="h-3 w-3 text-gray-500">
                                    <x-gmdi-groups />
                                </div>
                            </li>
                        </ul>

                        <div class="mt-2 flex items-center justify-end gap-2">
                            <button type="button"
                                    class="cursor-pointer flex space-x-2 items-center justify-center rounded-lg bg-sky-700 px-3 py-1.5 text-xs text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300">
                                <span class="flex items-center justify-center h-4 w-4">
                                    <x-bi-arrow-right-circle-fill />
                                </span>
                                <span>
                                    See Details
                                </span>
                            </button>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
       <div class="my-10">
           {{ $rooms->links(data: ['scrollTo' => false]) }}
       </div>
    </div>
</section>
