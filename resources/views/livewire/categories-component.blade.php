<aside>
    <div>
        <div class="mb-4 flex items-center justify-between gap-4 md:mb-8">
            <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl">Select Category</h2>
        </div>

{{--        <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">--}}
            <div class="space-y-4 ">
                @foreach($categories as $category)
                    <a href="/room/category/{{$category->name}}" class="flex items-center rounded-lg border border-gray-200 bg-white px-4 py-2 hover:bg-gray-50">
                        <span class="text-sm font-medium text-gray-900">{{$category->name}}</span>
                    </a>
                @endforeach
            </div>

{{--        </div>--}}
    </div>
</aside>
