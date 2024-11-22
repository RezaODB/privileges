<form wire:submit class="grid grid-cols-[auto_1fr_auto] px-2 sm:px-8">
    <div></div>
    <div class="border-b-2 border-zinc-800 sm:ml-4 flex items-end pb-4">
        <h2 class="text-3xl uppercase">{{ __('content.form') }}</h2>
    </div>
    <div class="border-b-2 border-zinc-800 text-2xl uppercase font-medium pb-8">
        <div class="-rotate-90">
            <h3>{{ __('content.true') }}</h3>
            <h3 class="mt-4">{{ __('content.false') }}</h3>
        </div>
    </div>
    @foreach ($quotas as $item)
    <div class="font-bold pt-4 hidden sm:block">{{ sprintf('%03d', $loop->iteration) }}</div>
    <div class="font-mono pt-4 sm:px-4 col-span-2 sm:col-span-1">{{ $item->{'question_' . app()->getLocale()} }}</div>
    <div class="sm:border-l-2 border-zinc-800 pt-6 px-4 flex gap-4">
        <input type="radio" wire:model.live="answers.{{ $item->id }}" value="yes" class="rounded-none w-8 h-3 text-zinc-800 checked:bg-none focus:ring-0"> 
        <input type="radio" wire:model.live="answers.{{ $item->id }}" value="no" class="rounded-none w-8 h-3 text-zinc-800 checked:bg-none focus:ring-0"> 
    </div>
    @endforeach
    <div></div>
    <div class="flex flex-col gap-4 mt-12 col-span-2 sm:px-4">
        <label for="comment" class="text-3xl uppercase">{{ __('content.comment') }}</label>
        <textarea wire:model.live.debounce.1000ms="answers.comment" id="comment" class="w-full h-full border-none focus:ring-0"></textarea>
    </div>
</form>

