<div>
    <section class="py-12 sm:px-4 flex flex-wrap-reverse justify-between items-end gap-8">
        <h1 class="text-5xl font-bold uppercase border-t-8 border-black pt-2">Privileges<br>invisibles</h1>
        <h2 class="text-4xl relative px-4 py-2">
            <span class="rounded-full w-2 h-2 bg-black absolute top-0 left-0"></span>
            <span class="rounded-full w-2 h-2 bg-black absolute top-0 right-0"></span>
            <span class="rounded-full w-2 h-2 bg-black absolute bottom-0 left-0"></span>
            <span class="rounded-full w-2 h-2 bg-black absolute bottom-0 right-0"></span>
            N° {{ Auth::id() ?? 'x' }}/250
        </h2>
    </section>

    <form wire:submit class="py-12 sm:px-4 grid grid-cols-[auto_1fr_auto]">
        <div></div>
        <div class="border-b-4 border-black ml-4"></div>
        <div class="border-b-4 border-black text-3xl uppercase font-medium pb-8">
            <div class="-rotate-90">
                <h3>{{ __('content.true') }}</h3>
                <h3 class="mt-4">{{ __('content.false') }}</h3>
            </div>
        </div>
        @foreach ($quotas as $item)
        <div class="font-bold pt-4 px-4">{{ sprintf('%03d', $loop->iteration) }}</div>
        <div class="font-print text-lg pt-4 px-4">{{ $item->{'question_' . app()->getLocale()} }}</div>
        <div class="border-l-4 border-black pt-6 px-4 flex gap-4">
            <input type="radio" wire:model.blur="answers.{{ $loop->iteration }}" value="yes" class="rounded-none border-none w-8 h-3 text-black checked:bg-none focus:ring-0"> 
            <input type="radio" wire:model.blur="answers.{{ $loop->iteration }}" value="no" class="rounded-none border-none w-8 h-3 text-black checked:bg-none focus:ring-0"> 
        </div>
        @endforeach
    </form>
</div>
