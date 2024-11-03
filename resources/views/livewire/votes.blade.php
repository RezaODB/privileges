<div class="relative">
    <form wire:submit class="grid grid-cols-[auto_1fr_auto]">
        <div></div>
        <div class="border-b-2 border-zinc-800 ml-4"></div>
        <div class="border-b-2 border-zinc-800 text-xl uppercase font-medium pb-8">
            <div class="-rotate-90">
                <h3>{{ __('content.for') }}</h3>
                <h3 class="mt-4">{{ __('content.against') }}</h3>
                <h3 class="mt-4">{{ __('content.coinflip') }}</h3>
            </div>
        </div>
        @foreach ($questions as $item)
        <div class="font-bold pt-4 px-4 hidden sm:block">{{ sprintf('%03d', $loop->iteration) }}</div>
        <div class="font-mono pt-4 sm:px-4 col-span-2 sm:col-span-1">{{ $item->{'question_' . app()->getLocale()} }}</div>
        <div class="sm:border-l-2 border-zinc-800 pt-6 px-4 flex gap-4">
            <input type="radio" wire:model.live="votes.{{ $item->id }}" value="yes" class="rounded-none bg-transparent w-8 h-3 text-zinc-800 checked:bg-none focus:ring-0"> 
            <input type="radio" wire:model.live="votes.{{ $item->id }}" value="no" class="rounded-none bg-transparent w-8 h-3 text-zinc-800 checked:bg-none focus:ring-0"> 
            <div></div>
        </div>
        @endforeach
    </form>
</div>