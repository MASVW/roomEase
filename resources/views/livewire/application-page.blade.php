<section class="py-36 antialiased md:py-4 h-full mb-20">
    <div class="py-8 antialiased">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <div>
                <livewire:heading-navigation-component categoryName="My Application" />
            </div>
        </div>
    </div>
    <div class="mx-auto h-full max-w-screen-xl px-4 2xl:px-0 flex">


        <div class="w-full min-h-[35rem] md:min-h-[40rem] max-h-[50rem] bg-white rounded-lg shadow-md overflow-hidden">
            <div class="space-y-3 py-10 px-6 sm:px-10">
                <div class="text-2xl sm:text-3xl">
                    Application
                </div>
                <div class="text-base">
                    {{ auth()->user()->name }}
                </div>
            </div>

            <!-- Wrapper dengan overflow-auto untuk konten list -->
            <div class="w-full px-4 overflow-auto max-h-[30rem] sm:max-h-[40rem]">
                <div class="mx-6 sm:mx-12 h-full space-y-3 pb-10">
                    @forelse($listApplication as $application)
                        <div wire:click="bookingSelected({{$application->id}})" class="cursor-pointer grid grid-cols-4 py-6 hover:rounded-lg hover:shadow-md px-6 transition content-center">
                            <div class="flex-row items-center text-left">
                                <div class="content-end">
                                    <p class="text-xs sm:text-sm">
                                        Requested Date: {{ $this->service->formattingDate($application->created_at) }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm sm:text-base">{{ $application->title }}</p>
                                </div>
                            </div>
                            <div class="flex items-center text-center">
                                <p class="text-sm sm:text-base">
                                    {{ $this->service->formattingToStringWithDuration($application->start, $application->end) }}
                                </p>
                            </div>
                            <div class="flex items-center text-center">
                                    <p class="text-sm sm:text-base">
                                        @foreach ($application->rooms as $room)
                                             <span> {{ $room->name }}</span>
                                        @endforeach
                                    </p>
                            </div>
                            <div class="flex items-center text-left capitalize flex justify-between">
                                @if($application->status == 'approved')
                                    <p class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 capitalize">{{$application->status}}</p>
                                @elseif($application->status == 'rejected')
                                    <p class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300 capitalize">{{$application->status}}</p>
                                @else
                                    <p class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300 capitalize">{{$application->status}}</p>
                                @endif
                                <div class="flex gap-x-5">
                                    @if($application->status == "pending")
                                        <div wire:click.stop="editBooking({{ $application->id }})"  class="text-gray-500 hover:text-gray-600 active:text-gray-800 w-5 h-5">
                                            <x-eva-edit />
                                        </div>
                                        <div wire:click.stop="showModalConfirmDeletion({{ $application->id  }})" class="text-gray-500 hover:text-gray-600 active:text-gray-800 w-5 h-5">
                                            <x-heroicon-s-trash />
                                        </div>
                                    @elseif($application->status == "approved")
                                        <div wire:click.stop="showModalConfirmCancel({{ $application->id  }})" class="text-gray-500 hover:text-gray-600 active:text-gray-800 w-5 h-5">
                                            <x-gmdi-cancel />
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <hr class="mx-10">
                    @empty
                        <div class="w-full h-full flex rounded-lg">
                            <div class="grow my-40 col-span-3 text-center mx-auto flex items-center justify-center">
                                <div class="text-center font-semibold capitalize">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 sm:w-12 sm:h-12 mx-auto">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <p class="text-sm sm:text-base">No Application.</p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="sticky bottom-0 w-full bg-white px-10 py-5">
                    {{ $listApplication->links() }}
                </div>
            </div>
        </div>
    </div>
    <div>
        <livewire:DetailBookModal />
    </div>
    @if($showModal)
        <div>
            <div wire:loading.flex wire:target="toggleModal, dateSelected, submit" class="fixed w-screen h-screen inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                <div role="status" class="bg-white p-5 rounded-lg shadow-lg flex flex-col items-center m-auto">
                    <svg aria-hidden="true" class="w-12 h-12 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mt-4">Loading...</h3>
                    <p class="text-sm text-gray-700 mt-2">Please wait while we process your request.</p>
                </div>
            </div>

            <div x-cloak x-data="{ open: @entangle('showModal') }" x-show="open" class="fixed inset-0 bg-black bg-opacity-50 z-40 flex justify-center items-center">
                <div tabindex="-1" class="relative p-4 w-full max-w-md sm:max-w-2xl h-full md:h-auto">
                    <div class="relative bg-white rounded-lg shadow sm:p-5">
                        <div class="flex justify-between items-start p-4 sm:p-5 rounded-t border-b">
                            <h3 class="text-lg font-semibold text-gray-900">
                                Room Reservation Request
                            </h3>
                            <button type="button" wire:click="toggleModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <form wire:submit="updateBooking" class="p-4 sm:p-5">
                            <div class="grid gap-4 mb-4 grid-cols-1">
                                <div>
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Event Name</label>
                                    <input type="text" wire:model.blur="eventName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-600 focus:border-sky-600 block w-full p-2.5" placeholder="Type event name" required="">
                                    <div class="text-red-600 text-xs">@error('eventName') {{ $message }} @enderror</div>
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Event Description</label>
                                    <textarea id="description" wire:model.blur="eventDescription" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-sky-500 focus:border-sky-500" placeholder="Write abstract event here"></textarea>
                                    <div class="text-red-600 text-xs">@error('eventDescription') {{ $message }} @enderror</div>
                                </div>
                            </div>
                            <div class="grid gap-4 mb-4 grid-cols-1 sm:grid-cols-2">
                                <div>
                                    <div class="relative max-w-sm">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                            </svg>
                                        </div>
                                        <input wire:model.blur="start" id="event-start" type="datetime-local" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Select date">
                                    </div>
                                    <p class="text-red-600 text-xs">@error('start') {{ $message }} @enderror</p>
                                </div>

                                <div>
                                    <div class="relative max-w-sm">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                            </svg>
                                        </div>
                                        <input wire:model.blur="end" id="event-end" type="datetime-local" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Select date">
                                    </div>
                                    <p class="text-red-600 text-xs">@error('end') {{ $message }} @enderror</p>
                                </div>
                            </div>
                            <div class="flex items-start mt-4 space-x-2">
                                <div class="h-5">
                                    <input
                                        id="checked-checkbox"
                                        type="checkbox"
                                        wire:model="agreement"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                                    >
                                </div>

                                <div>
                                    <label for="checked-checkbox" class="text-xs font-semibold text-gray-900">
                                        By checking this box, I declare that this program has followed the established procedures, and I take full responsibility for the truth and accuracy of all the data I have provided in this form.
                                    </label>
                                    <p class="mt-1 text-xs text-red-600">@error('agreement') {{ $message }} @enderror</p>
                                </div>
                            </div>
                            <div class="w-full flex justify-end">
                                <button type="submit" class="text-white inline-flex items-center bg-sky-700 hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($modalDeletion)
        <div x-data="{ open: @entangle('modalDeletion').live }" x-show="open" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Button untuk membuka modal -->
            <button @click="open = true" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                Open Modal
            </button>

            <!-- Background backdrop -->
            <div
                x-show="open"
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                aria-hidden="true">
            </div>

            <!-- Modal -->
            <div
                x-data="{bookId: '{{$bookIdSelected}}'}"
                x-show="open"
                @keydown.escape.window="$wire.showModalConfirmDeletion('{{$bookIdSelected}}')"
                class="fixed inset-0 z-10 w-screen overflow-y-auto"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-base font-semibold text-gray-900" id="modal-title">Confirm Deletion</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">Are you sure you want to delete your room booking? This action cannot be undone.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button type="button" @click="$wire.delete(bookId)" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                                Delete
                            </button>
                            <button type="button" @click="$wire.showModalConfirmDeletion('{{$bookIdSelected}}')" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($modalCancel)
        <div x-data="{ open: @entangle('modalCancel').live }" x-show="open" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Button untuk membuka modal -->
            <button @click="open = true" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                Open Modal
            </button>

            <!-- Background backdrop -->
            <div
                x-show="open"
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                aria-hidden="true">
            </div>

            <!-- Modal -->
            <div
                x-data="{bookId: '{{$bookIdSelected}}'}"
                x-show="open"
                @keydown.escape.window="$wire.showModalConfirmDeletion('{{$bookIdSelected}}')"
                class="fixed inset-0 z-10 w-screen overflow-y-auto"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-base font-semibold text-gray-900" id="modal-title">Confirm Cancellation</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">By canceling, you may lose your deposit and future booking privileges.
                                            Are you sure you want to proceed with canceling your booking?</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button type="button" @click="$wire.cancelBooking(bookId)" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                                Confirm Cancellation
                            </button>
                            <button type="button" @click="$wire.showModalConfirmDeletion('{{$bookIdSelected}}')" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>
