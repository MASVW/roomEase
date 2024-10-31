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
            @if(is_null($selectedRoom->img))
                <iframe class="w-full h-32 sm:h-40 md:h-48 object-cover"
                        src="https://lottie.host/embed/a4c3be28-903f-4676-8d2c-bc59f082e444/uTFX8nrs58.json">
                </iframe>
            @else
                <img src="{{$selectedRoom->img}}" class="rounded-lg max-h-sm" alt="">
            @endif
        </div>
    </div>
</section>

