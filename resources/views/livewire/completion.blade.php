<section class="p-4 sm:p-8 bg-[#fdf2e3] rounded-xl">
    <h1 class="uppercase text-3xl">{{ __('content.instructions') }}</h1>
    <form class="font-mono uppercase mt-8 grid grid-cols-3 gap-y-4">
        <div class="col-span-2 pb-4 border-b-2 border-dotted border-zinc-800">1. S'enregister et approuver <a href="{{ route('policy') }}" class="underline">les conditions d'utilisation</a> du site</div>
        <div class="flex items-center justify-end gap-4 pb-4 border-b-2 border-dotted border-zinc-800">
            <label for="check1">10min</label>
            <input type="checkbox"  wire:model.live="completion.1" value="10" id="check1" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="col-span-2 pb-4 border-b-2 border-dotted border-zinc-800">2. Lire ou écouter <a href="{{ route('step1') }}" class="underline">la partie théorique</a></div>
        <div class="flex items-center justify-end gap-4 pb-4 border-b-2 border-dotted border-zinc-800">
            <label for="check2">20min</label>
            <input type="checkbox" wire:model.live="completion.2" value="20" id="check2" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="col-span-2 pb-4 border-b-2 border-dotted border-zinc-800">3. Parcourir les étapes 
            <a href="{{ route('step2') }}" class="underline">Quota privilèges</a>, 
            <a href="{{ route('step3') }}" class="underline">Loterie sociale</a>, 
            <a href="{{ route('step4') }}" class="underline">Session photo</a>, 
            <a href="{{ route('step5') }}" class="underline">Cartographie</a> et 
            <a href="{{ route('step6') }}" class="underline">Étude sculpturale</a>
        </div>
        <div class="flex items-center justify-end gap-4 pb-4 border-b-2 border-dotted border-zinc-800">
            <label for="check3">30min</label>
            <input type="checkbox"  wire:model.live="completion.3" value="30" id="check3" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="col-span-2 pb-4 border-b-2 border-dotted border-zinc-800">4. Recevoir la notification du départ de l'étude via <a href="">le groupe Whatsapp</a></div>
        <div class="flex items-center justify-end gap-4 pb-4 border-b-2 border-dotted border-zinc-800">
            <label for="check4">0min</label>
            <input type="checkbox"  wire:model.live="completion.4" value="0" id="check4" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="col-span-2 pb-4 border-b-2 border-dotted border-zinc-800">5. Remplir le <a href="{{ route('step2') }}" class="underline">questionnaire quota des privilèges</a></div>
        <div class="flex items-center justify-end gap-4 pb-4 border-b-2 border-dotted border-zinc-800">
            <label for="check5">30min</label>
            <input type="checkbox"  wire:model.live="completion.5" value="30" id="check5" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="col-span-2 pb-4 border-b-2 border-dotted border-zinc-800">6. Lire la brochure et remplir le <a href="{{ route('step3') }}" class="underline">bulletin de vote sur la loterie sociale</a></div>
        <div class="flex items-center justify-end gap-4 pb-4 border-b-2 border-dotted border-zinc-800">
            <label for="check6">30min</label>
            <input type="checkbox"  wire:model.live="completion.6" value="30" id="check6" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="col-span-2 pb-4 border-b-2 border-zinc-800">7. Passer au studio pour la <a href="{{ route('step4') }}" class="underline">session photo</a> et l'enregistrement de notre entretien</div>
        <div class="flex items-center justify-end gap-4 pb-4 border-b-2 border-zinc-800">
            <label for="check7">120min</label>
            <input type="checkbox"  wire:model.live="completion.7" value="120" id="check7" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="col-span-2 text-xl font-medium">TOTAL: </div>
        <div class="flex items-center justify-end gap-4">
            <label class="text-xl font-medium">240min</label>
        </div>
    </form>
</section>
