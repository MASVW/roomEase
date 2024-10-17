<div class="w-full h-full mt-10 space-y-10">
    <h1 class="mt-2 text-xl font-bold tracking-tight text-gray-900 sm:text-2xl">Easy Way!</h1>
    <div class="flex justify-center items-center" wire:poll.5200ms="nextStep">
        <div class="grow">
            <ol class="relative text-gray-500 border-s border-gray-200 dark:border-gray-700 dark:text-gray-400">
                @foreach ($steps as $index => $step)
                    <li class="mb-10 ms-6">
                        @if($index == 0)
                            <span class="absolute flex items-center justify-center w-8 h-8 {{ $this->allReady[$index] === true ? 'bg-green-200' : 'bg-gray-100' }}  rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                                <svg class="w-3.5 h-3.5 {{ $this->allReady[$index] === true ? 'text-green-500' : 'text-gray-500' }}  dark:text-gray-400" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"></path>
                                </svg>
                            </span>
                        @elseif($index == 1)
                            <span class="absolute flex items-center justify-center w-8 h-8 {{ $this->allReady[$index] === true ? 'bg-green-200' : 'bg-gray-100' }} rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                                <svg class="w-3.5 h-3.5 {{ $this->allReady[$index] === true ? 'text-green-500' : 'text-gray-500' }} dark:text-gray-400" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                                </svg>
                            </span>
                        @elseif($index == 2)
                            <span class="absolute flex items-center justify-center w-8 h-8 {{ $this->allReady[$index] === true ? 'bg-green-200' : 'bg-gray-100' }} rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                                <svg class="w-3.5 h-3.5 {{ $this->allReady[$index] === true ? 'text-green-500' : 'text-gray-500' }} dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                    <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                                </svg>
                            </span>
                        @elseif($index == 3)
                            <span class="absolute flex items-center justify-center w-8 h-8 {{ $this->allReady[$index] === true ? 'bg-green-200' : 'bg-gray-100' }} rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                                <svg class="w-3.5 h-3.5 {{ $this->allReady[$index] === true ? 'text-green-500' : 'text-gray-500' }} dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                    <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z"/>
                                </svg>
                            </span>
                        @endif
                        <h3 class="font-medium leading-tight">{{ $step['title'] }}</h3>
                        <p class="text-sm">{{ $step['description'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>

        <div class="grow h-full">
            <iframe src="{{ $currentIframe }}" class="w-full h-64"></iframe>
        </div>
    </div>
</div>
