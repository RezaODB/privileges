<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl 2xl:max-w-[1800px] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <a href="{{ route('brochures.create') }}" class="px-4 py-2 bg-green-600 rounded-md text-white inline-block">Create</a>
                    <div class="divide-y">
                        @foreach ($brochures as $item)
                            <div class="flex gap-4 items-center p-1 hover:bg-gray-100">
                                <form action="{{ route('brochures.update', $item) }}" method="post">
                                    @csrf
                                    @method('patch')
                                    <input type="number" name="order" value="{{ $item->order }}" min="0" max="99" step="1" onchange="this.form.submit()" class="p-1 border-gray-200 shadow rounded-md">
                                </form>
                                <span class="text-gray-600 font-bold uppercase">{{ $item->lang }}</span>
                                @if ($item->category)
                                <span class="bg-green-100 text-green-600 uppercase px-2 whitespace-nowrap rounded text-sm">{{ $item->category }}</span>
                                @endif
                                <a href="{{ route('brochures.edit', $item) }}" class="text-blue-600 hover:underline">{{ $item->title }}</a>
                                <form action="{{ route('brochures.destroy', $item) }}" method="post" class="ml-auto">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="text-red-600 text-sm uppercase hover:underline" onclick="return confirm('Delete item?')">Delete</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>