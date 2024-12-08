<form wire:submit class="grid grid-cols-[1fr_auto] px-2 sm:px-8 mt-16">
    <h2 class="text-3xl uppercase border-b-2 border-zinc-800 pb-4 self-end">{{ __('content.form') }}</h2>
    <div class="text-xl uppercase font-medium border-b-2 border-zinc-800 pb-6 flex gap-4 items-end justify-center">
        <h3 class="[writing-mode:vertical-lr]">{{ __('content.true') }}</h3>
        <h3 class="[writing-mode:vertical-lr]">{{ __('content.false') }}</h3>
    </div>
    @foreach ($quotas as $item)
    <div class="font-mono py-3 border-b-2 border-zinc-800 border-dotted flex items-start gap-4 pr-4">
        <span class="hidden sm:block font-bold">{{ sprintf('%03d', $loop->iteration) }}</span>
        {{ $item->{'question_' . app()->getLocale()} }}
    </div>
    <div class="py-3 border-b-2 border-zinc-800 border-dotted flex items-center justify-end gap-4 ml-px">
        <input type="radio" wire:model.live="answers.{{ $item->id }}" value="yes" class="rounded-none w-8 h-3 text-zinc-800 checked:bg-none focus:ring-0 disabled:bg-[#fdf2e3] disabled:border-none" disabled> 
        <input type="radio" wire:model.live="answers.{{ $item->id }}" value="no" class="rounded-none w-8 h-3 text-zinc-800 checked:bg-none focus:ring-0 disabled:bg-[#fdf2e3] disabled:border-none" disabled> 
    </div>
    @endforeach
    <div class="flex flex-col lg:flex-row gap-x-6 gap-y-4 mt-12 col-span-2">
        <label for="comment" class="text-3xl uppercase">{{ __('content.comment') }}</label>
        <textarea wire:model.live.debounce.1000ms="answers.comment" id="comment" rows="5" class="w-full h-full focus:ring-0 disabled:bg-[#fdf2e3]" disabled></textarea>
    </div>
</form>

