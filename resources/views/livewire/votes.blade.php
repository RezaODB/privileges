<form wire:submit class="grid grid-cols-[1fr_auto] px-2 sm:px-8 mt-16">
    <h2 class="text-3xl uppercase border-b-2 border-zinc-800 pb-4 self-end">{{ __('content.ballot') }}</h2>
    <div class="text-xl uppercase font-medium border-b-2 border-zinc-800 pb-6 flex gap-4 items-end justify-center">
        <h3 class="[writing-mode:vertical-lr]">{{ __('content.for') }}</h3>
        <h3 class="[writing-mode:vertical-lr]">{{ __('content.against') }}</h3>
        <h3 class="[writing-mode:vertical-lr]">{{ __('content.coinflip') }}</h3>
    </div>
    @foreach ($questions as $item)
    <div class="font-mono py-3 border-b-2 border-zinc-800 border-dotted pr-4">{{ $item->{'question_' . app()->getLocale()} }}</div>
    <div class="py-3 border-b-2 border-zinc-800 border-dotted flex items-center justify-end gap-4">
        <input type="radio" wire:model.live="votes.{{ $item->id }}" value="yes" class="rounded-none w-8 h-3 text-zinc-800 checked:bg-none focus:ring-0"> 
        <input type="radio" wire:model.live="votes.{{ $item->id }}" value="no" class="rounded-none w-8 h-3 text-zinc-800 checked:bg-none focus:ring-0">
        <div class="group hover:scale-150 duration-700" wire:click="$set('votes.{{ $item->id }}', '{{ rand(0, 1) === 1 ? 'yes' : 'no' }}')">
            <div class="w-6 h-6 border border-zinc-800 rounded-full bg-white hover:bg-zinc-800 duration-700 cursor-pointer group-hover:[transform:rotateX(540deg)]"></div>
        </div>
    </div>
    @endforeach
    <div class="flex flex-col lg:flex-row gap-x-6 gap-y-4 mt-12 col-span-2">
        <label for="comment" class="text-3xl uppercase">{{ __('content.comment') }}</label>
        <textarea wire:model.live.debounce.1000ms="votes.comment" id="comment" rows="5" class="w-full h-full focus:ring-0"></textarea>
    </div>
</form>