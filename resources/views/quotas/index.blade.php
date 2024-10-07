<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('quotas.create') }}" class="px-4 py-2 bg-green-600 rounded-md text-white">Create</a>
                        <a href="{{ route('export') }}" class="px-4 py-2 bg-gray-600 rounded-md text-white">Export to CSV</a>
                    </div>
                    <div class="divide-y">
                        @foreach ($quotas as $item)
                            <div class="flex gap-4 items-center p-1 hover:bg-gray-100">
                                <span class="font-bold text-gray-600">{{ $loop->iteration }}</span>
                                <form action="{{ route('quotas.update', $item) }}" method="post">
                                    @csrf
                                    @method('patch')
                                    <input type="number" name="order" value="{{ $item->order }}" min="0" max="999" step="1" onchange="this.form.submit()" class="p-1 border-gray-200 shadow rounded-md">
                                </form>
                                @if ($item->category)
                                <span class="bg-green-100 text-green-600 uppercase px-2 whitespace-nowrap rounded text-sm">{{ $item->category }}</span>
                                @endif
                                <a href="{{ route('quotas.edit', $item) }}" class="text-blue-600 hover:underline">{{ Str::limit($item->question_fr, 100) }}</a>
                                <form action="{{ route('quotas.destroy', $item) }}" method="post" class="ml-auto">
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