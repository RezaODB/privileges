<nav class="font-mono uppercase text-sm flex flex-col md:flex-row overflow-hidden">
    @foreach ($sections as $item)
    <a href="{{ route('pro.show', $item) }}" class="md:flex-1 p-3 pb-5 leading-tight rounded-t-md shadow-[inset_0px_-3px_3px_rgb(0,0,0,0.4)] hover:font-bold {{ $item->is($section) ? 'md:shadow-[3px_0_3px_rgb(0,0,0,0.4)] font-bold' : '' }}">{{ $item->localizedTitle() }}</a>
    @endforeach
</nav>
