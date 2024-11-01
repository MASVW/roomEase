<section class="bg-white">
    <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
        <div class="mr-auto place-self-center lg:col-span-7">
            <h1 class="max-w-2xl text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl">{{$selectedRoom->name}}</h1>
            <div class="flex items-center my-4 space-x-2">
                <div class="w-6 h-6 text-gray-500">
                    <x-elemplus-location />
                </div>
                <div class="h-full">
                    <p class="max-w-2xl font-light text-gray-500 md:text-lg lg:text-xl">
                        {{$buildingName}} {{$floor}}<sup{{$this->ordinalSuffix($floor)}}</sup> Floor
                    </p>
                </div>
            </div>
            <div class="my-4">
                <h1 class="text-xl">Room specification</h1>
                {{$selectedRoom->facilities}}
            </div>
            <livewire:modal-button />
        </div>
        <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
            @if(is_null($selectedRoom->img) || empty($selectedRoom->img))
                <iframe class="w-full h-32 sm:h-40 md:h-48 object-cover"
                        src="https://lottie.host/embed/a4c3be28-903f-4676-8d2c-bc59f082e444/uTFX8nrs58.json">
                </iframe>
            @else
                <div id="controls-carousel" class="relative w-full" data-carousel="static">
                    <!-- Carousel wrapper -->
                    <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                        @foreach($selectedRoom->img as $index => $img)
                            <!-- Slide Item -->
                            <div class="hidden duration-700 ease-in-out" data-carousel-item="{{ $loop->first ? 'active' : '' }}">
                                <img src="https://storage.googleapis.com/{{env('GOOGLE_CLOUD_STORAGE_BUCKET')}}/{{$img}}"
                                     class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                     alt="Ruangan {{ $selectedRoom->name }}" />
                            </div>
                        @endforeach
                    </div>
                    <!-- Slider controls -->
                    <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                </svg>
                <span class="sr-only">Previous</span>
                </span>
                    </button>
                    <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="sr-only">Next</span>
                        </span>
                    </button>
                </div>
            @endif

        </div>
    </div>
</section>

