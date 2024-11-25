<section class="p-4 sm:p-8 bg-[#fdf2e3] rounded-xl">
    <h1 class="uppercase text-3xl">{{ __('content.instructions') }}</h1>
    <form class="font-mono uppercase mt-8">
        <div class="py-3 border-b-2 border-dotted border-zinc-800 flex gap-4 items-center">
            <div>1. S'enregister et approuver <a href="{{ route('policy') }}" class="underline">les conditions d'utilisation</a> du site</div>
            <label for="check1" class="ml-auto">10min</label>
            <input type="checkbox"  wire:model.live="completion.1" value="10" id="check1" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="py-3 border-b-2 border-dotted border-zinc-800 flex gap-4 items-center">
            <div>2. Lire ou écouter <a href="{{ route('step1') }}" class="underline">la partie théorique</a></div>
            <label for="check2" class="ml-auto">20min</label>
            <input type="checkbox" wire:model.live="completion.2" value="20" id="check2" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="py-3 border-b-2 border-dotted border-zinc-800 flex gap-4 items-center">
            <div>
                3. Parcourir les étapes 
                <a href="{{ route('step2') }}" class="underline">Quota privilèges</a>, 
                <a href="{{ route('step3') }}" class="underline">Loterie sociale</a>, 
                <a href="{{ route('step4') }}" class="underline">Session photo</a>, 
                <a href="{{ route('step5') }}" class="underline">Cartographie</a> et 
                <a href="{{ route('step6') }}" class="underline">Étude sculpturale</a>
            </div>
            <label for="check3" class="ml-auto">30min</label>
            <input type="checkbox"  wire:model.live="completion.3" value="30" id="check3" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="py-3 border-b-2 border-dotted border-zinc-800 flex gap-4 items-center">
            <div>4. Recevoir la notification du départ de l'étude via <a href="">le groupe Whatsapp</a></div>
            <label for="check4" class="ml-auto">0min</label>
            <input type="checkbox"  wire:model.live="completion.4" value="0" id="check4" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="py-3 border-b-2 border-dotted border-zinc-800 flex gap-4 items-center">
            <div>5. Remplir le <a href="{{ route('step2') }}" class="underline">questionnaire quota des privilèges</a></div>
            <label for="check5" class="ml-auto">30min</label>
            <input type="checkbox"  wire:model.live="completion.5" value="30" id="check5" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="py-3 border-b-2 border-dotted border-zinc-800 flex gap-4 items-center">
            <div>6. Lire la brochure et remplir le <a href="{{ route('step3') }}" class="underline">bulletin de vote sur la loterie sociale</a></div>
            <label for="check6" class="ml-auto">30min</label>
            <input type="checkbox"  wire:model.live="completion.6" value="30" id="check6" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="py-3 border-b-2 border-zinc-800 flex gap-4 items-center">
            <div>7. Passer au flex gap-4 items-start studio pour la <a href="{{ route('step4') }}" class="underline">session photo</a> et l'enregistrement de notre entretien</div>
            <label for="check7" class="ml-auto">120min</label>
            <input type="checkbox"  wire:model.live="completion.7" value="120" id="check7" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="py-3 flex gap-4 items-center text-xl font-medium">
            TOTAL:
            <label class="ml-auto">240min</label>
        </d>
    </form>
</section>
