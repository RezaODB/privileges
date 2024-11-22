<form wire:submit class="grid grid-cols-1 lg:grid-cols-3 gap-16 px-2 sm:px-8 mt-16">
    <div class="grid grid-cols-[1fr_auto] items-center w-full lg:col-span-2">
        <h2 class="text-3xl uppercase">{{ __('content.ballot') }} </h2>
        <div class="text-xl uppercase font-medium pb-8">
            <div class="-rotate-90">
                <h3>{{ __('content.for') }}</h3>
                <h3 class="mt-6">{{ __('content.against') }}</h3>
                <h3 class="mt-4">{{ __('content.coinflip') }}</h3>
            </div>
        </div>
        @foreach ($questions as $item)
        <div class="font-mono py-3 border-b-2 border-zinc-800">{{ $item->{'question_' . app()->getLocale()} }}</div>
        <div class="py-3 px-4 flex gap-4 items-center">
            <input type="radio" wire:model.live="votes.{{ $item->id }}" value="yes" class="rounded-none w-8 h-3 text-zinc-800 checked:bg-none focus:ring-0"> 
            <input type="radio" wire:model.live="votes.{{ $item->id }}" value="no" class="rounded-none w-8 h-3 text-zinc-800 checked:bg-none focus:ring-0">
            <div class="group hover:scale-150 duration-700" wire:click="$set('votes.{{ $item->id }}', '{{ rand(0, 1) === 1 ? 'yes' : 'no' }}')">
                <div class="w-6 h-6 border border-zinc-800 rounded-full bg-white hover:bg-zinc-800 duration-700 cursor-pointer group-hover:[transform:rotateX(540deg)]"></div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="flex flex-col gap-4">
        <label for="comment" class="text-xl uppercase font-medium">{{ __('content.comment') }}</label>
        <textarea wire:model.live.debounce.1000ms="votes.comment" id="comment" class="w-full h-full border-none focus:ring-0"></textarea>
    </div>
</form>