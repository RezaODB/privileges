<section class="px-2 sm:px-8">
    <h1 class="uppercase text-3xl">{{ __('content.instructions') }}</h1>
    <form class="font-mono uppercase mt-8">
        <div class="py-3 border-b-2 border-dotted border-zinc-800 flex gap-4 items-center">
            @if (app()->isLocale('fr'))
            <div>1. S'enregistrer et approuver LES CONDITIONS D'UTILISATIONS du projet</div>
            @else
            <div>1. Register and approve the TERMS OF USE of the project</div>
            @endif
            <label for="check1" class="ml-auto">10min</label>
            <input type="checkbox"  wire:model.live="completion.1" value="10" id="check1" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="py-3 border-b-2 border-dotted border-zinc-800 flex gap-4 items-center">
            @if (app()->isLocale('fr'))
            <div>2. Lire ou écouter L'ETUDE THEORIQUE</div>
            @else
            <div>2. Read or listen to the THEORETICAL STUDY</div>
            @endif
            <label for="check2" class="ml-auto">20min</label>
            <input type="checkbox" wire:model.live="completion.2" value="20" id="check2" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="py-3 border-b-2 border-dotted border-zinc-800 flex gap-4 items-center">
            @if (app()->isLocale('fr'))
            <div>3. Parcourir ETAPE 1, ETAPE 2, ETAPE 3, ETAPE 4, ETAPE 5</div>
            @else
            <div>3. Navigate through STEP 1, STEP 2, STEP 3, STEP 4, STEP 5</div>
            @endif
            <label for="check3" class="ml-auto">30min</label>
            <input type="checkbox"  wire:model.live="completion.3" value="30" id="check3" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="py-3 border-b-2 border-dotted border-zinc-800 flex gap-4 items-center">
            @if (app()->isLocale('fr'))
            <div>4. Recevoir la notification du DEPART de l'étude via le groupe Whatsapp</div>
            @else
            <div>4. Receive the notification for the START of the study via the WhatsApp group</div>
            @endif
            <label for="check4" class="ml-auto">0min</label>
            <input type="checkbox"  wire:model.live="completion.4" value="0" id="check4" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="py-3 border-b-2 border-dotted border-zinc-800 flex gap-4 items-center">
            @if (app()->isLocale('fr'))
            <div>5. Remplir le questionnaire de l'ETAPE 1: QUOTA DE PRIVILEGES</div>
            @else
            <div>5. Complete the STEP 1 questionnaire: PRIVILEGE QUOTA</div>
            @endif
            <label for="check5" class="ml-auto">30min</label>
            <input type="checkbox"  wire:model.live="completion.5" value="30" id="check5" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="py-3 border-b-2 border-dotted border-zinc-800 flex gap-4 items-center">
            @if (app()->isLocale('fr'))
            <div>6. Lire la brochure et remplir le bulletin de vote de l'ETAPE 2: LOTERIE SOCIALE</a></div>
            @else
            <div>6. Read the brochure and fill out the ballot for STEP 2: SOCIAL LOTTERY</div>
            @endif
            <label for="check6" class="ml-auto">30min</label>
            <input type="checkbox"  wire:model.live="completion.6" value="30" id="check6" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="py-3 border-b-2 border-zinc-800 flex gap-4 items-center">
            @if (app()->isLocale('fr'))
            <div>7. Passer au studio pour la SESSION PHOTO et l'enregistrement de notre entretien</div>
            @else
            <div>7. Visit the studio for the PHOTO SESSION and recording of our interview</div>
            @endif
            <label for="check7" class="ml-auto">120min</label>
            <input type="checkbox"  wire:model.live="completion.7" value="120" id="check7" class="text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <div class="py-3 flex gap-4 items-center text-xl font-medium">
            TOTAL:
            <label class="ml-auto">240min</label>
        </d>
    </form>
</section>
