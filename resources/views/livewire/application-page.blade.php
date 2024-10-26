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
                @for($i=0; $i <10; $i++)
                    <div class="grid grid-rows-2 my-4">
                        <div class="content-end">
                            <p class="text-xs">30 Agustus 2024</p>
                        </div>
                        <div class="grid grid-cols-12 content-center">
                            <div class="col-span-12 sm:col-span-4 md:col-span-4">
                                <p>Welcoming New Student 2024</p>
                            </div>
                            <div class="col-span-12 sm:col-span-3 md:col-span-3 text-center">
                                <p>13:00-17:00</p>
                            </div>
                            <div class="col-span-12 sm:col-span-3 md:col-span-3 text-center">
                                <p>LP01 - LP02</p>
                            </div>
                            <div class="col-span-12 sm:col-span-2 md:col-span-2 text-center">
                                <p>Approved</p>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endfor
            </div>
        </div>
    </div>
</section>
