<section class="px-2 sm:px-8">
    <h1 class="uppercase text-3xl">{{ __('content.instructions') }}</h1>
    <form class="font-mono uppercase mt-8">
        <div class="py-3 border-b-2 border-dotted border-zinc-800 flex gap-4 items-center">
            @if (app()->isLocale('fr'))
            <div>1. S'enregistrer et approuver <a href="{{ route('policy') }}" class="underline">LES CONDITIONS D'UTILISATIONS</a> du projet</div>
            @else
            <div>1. Register and approve the <a href="{{ route('policy') }}" class="underline">TERMS OF USE</a> for the project</div>
            @endif
            <label for="check1" class="ml-auto">10min</label>
            <input type="checkbox"  wire:model.live="completion.1" value="10" id="check1" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="py-3 border-b-2 border-dotted border-zinc-800 flex gap-4 items-center">
            @if (app()->isLocale('fr'))
            <div>2. Lire <a href="{{ route('step1') }}" class="underline">L'ETUDE THEORIQUE</a> ou écouter les deux PODCASTS dans l'avant-propos</div>
            @else
            <div>2. Read the <a href="{{ route('step1') }}" class="underline">THEORETICAL STUDY</a> or listen to the two PODCASTS</div>
            @endif
            <label for="check2" class="ml-auto">20min</label>
            <input type="checkbox" wire:model.live="completion.2" value="20" id="check2" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="py-3 border-b-2 border-dotted border-zinc-800 flex gap-4 items-center">
            @if (app()->isLocale('fr'))
            <div>3. Recevoir la notification du DEPART de l'étude via le groupe Whatsapp (janvier 2025)</div>
            @else
            <div>3. Receive the notification about the START of the study via the WhatsApp group (January 2025)</div>
            @endif
            <label for="check3" class="ml-auto">0min</label>
            <input type="checkbox"  wire:model.live="completion.3" value="0" id="check3" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="py-3 border-b-2 border-dotted border-zinc-800 flex gap-4 items-center">
            @if (app()->isLocale('fr'))
            <div>4. Lire le mode d'emploi et remplir le questionnaire de l'<a href="{{ route('step2') }}" class="underline">ETAPE 1: QUOTA DE PRIVILEGES</a></div>
            @else
            <div>4. Read the instructions and complete the questionnaire for <a href="{{ route('step2') }}" class="underline">STEP 1: PRIVILEGE QUOTA</a></div>
            @endif
            <label for="check4" class="ml-auto">60min</label>
            <input type="checkbox"  wire:model.live="completion.4" value="60" id="check4" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="py-3 border-b-2 border-dotted border-zinc-800 flex gap-4 items-center">
            @if (app()->isLocale('fr'))
            <div>5. Lire le mode d'emploi et remplir le bulletin de vote de l'<a href="{{ route('step3') }}" class="underline">ETAPE 2: LOTERIE SOCIALE</a></div>
            @else
            <div>5. Read the instructions and fill out the ballot for <a href="{{ route('step3') }}" class="underline">STEP 2: SOCIAL LOTTERY</a></div>
            @endif
            <label for="check5" class="ml-auto">30min</label>
            <input type="checkbox"  wire:model.live="completion.5" value="30" id="check5" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="py-3 border-b-2 border-zinc-800 flex gap-4 items-center">
            @if (app()->isLocale('fr'))
            <div>6. Lire le mode d'emploi et passer au studio pour la <a href="{{ route('step4') }}" class="underline">SESSION PHOTO</a> et l'enregistrement de notre entretien</div>
            @else
            <div>6. Read the instructions and visit the studio for the <a href="{{ route('step4') }}" class="underline">PHOTO SESSION</a> and recording of our interview</div>
            @endif
            <label for="check6" class="ml-auto">120min</label>
            <input type="checkbox"  wire:model.live="completion.6" value="120" id="check6" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="py-3 flex gap-4 items-center text-xl font-medium">
            TOTAL:
            <label class="ml-auto">240min</label>
        </d>
    </form>
</section>
