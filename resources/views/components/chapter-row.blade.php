@props(['chapter', 'nested' => false])

<div class="flex gap-4 items-center p-1 hover:bg-gray-100 {{ $nested ? 'pl-10 border-l-4 border-gray-200' : '' }}">
    <form action="{{ route('chapters.update', $chapter) }}" method="post">
        @csrf
        @method('patch')
        <input type="number" name="order" value="{{ $chapter->order }}" min="0" max="99" step="1" onchange="this.form.submit()" class="p-1 border-gray-200 shadow rounded-md">
    </form>
    <span class="text-gray-600 font-bold uppercase">{{ $chapter->lang }}</span>
    @if ($chapter->number)
        <span class="text-gray-500">{{ $chapter->number }}</span>
    @endif
    <a href="{{ route('chapters.edit', $chapter) }}" class="text-blue-600 hover:underline">{{ $chapter->title }}</a>
    @if ($chapter->summary)
        <span class="text-gray-400 text-sm truncate max-w-xs">{{ $chapter->summary }}</span>
    @endif
    <a href="{{ route('chapters.figures.index', $chapter) }}" class="ml-auto text-blue-600 hover:underline text-sm">{{ $chapter->figures()->count() }} chiffre(s)</a>
    <form action="{{ route('chapters.destroy', $chapter) }}" method="post">
        @csrf
        @method('delete')
        <button type="submit" class="text-red-600 text-sm uppercase hover:underline" onclick="return confirm('{{ $chapter->children()->exists() ? 'Supprimer ce chapitre et ses sous-chapitres ?' : 'Delete item?' }}')">Delete</button>
    </form>
</div>
