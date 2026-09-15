@php($isPublished = old('published', $section->exists ? $section->published : true))
@php($showsQuota = old('shows_quota', $section->shows_quota ?? false))
@php($showsPodcasts = old('shows_podcasts', $section->shows_podcasts ?? false))

<div class="grid grid-cols-1 gap-4">

    <input type="text" name="title_fr" placeholder="Titre de l'onglet (FR)" value="{{ old('title_fr', $section->title_fr) }}" class="border-gray-200 shadow rounded-md" required>
    @error('title_fr')<div class="text-red-500">{{ $message }}</div>@enderror

    <input type="text" name="title_en" placeholder="Tab title (EN)" value="{{ old('title_en', $section->title_en) }}" class="border-gray-200 shadow rounded-md" required>
    @error('title_en')<div class="text-red-500">{{ $message }}</div>@enderror

    <div>
        <input type="text" name="slug" placeholder="adresse-de-la-page" value="{{ old('slug', $section->slug) }}" class="w-full border-gray-200 shadow rounded-md">
        <p class="text-sm text-gray-500 mt-1">
            Adresse publique de l'onglet&nbsp;: <code>/pro/{{ $section->slug ?: 'adresse-de-la-page' }}</code>.
            Laissez vide pour la générer depuis le titre FR.
            @if ($section->exists)
                <strong>Attention&nbsp;:</strong> la modifier casse les liens déjà partagés.
            @endif
        </p>
    </div>
    @error('slug')<div class="text-red-500">{{ $message }}</div>@enderror

    <label class="flex items-center gap-2 justify-self-start">
        <input type="hidden" name="published" value="0">
        <input type="checkbox" name="published" value="1" @checked($isPublished) class="rounded border-gray-300">
        En ligne (visible par les visiteurs)
    </label>
    @error('published')<div class="text-red-500">{{ $message }}</div>@enderror

    <label class="flex items-start gap-2 justify-self-start">
        <input type="hidden" name="shows_quota" value="0">
        <input type="checkbox" name="shows_quota" value="1" @checked($showsQuota) class="mt-1 rounded border-gray-300">
        <span>
            Afficher le questionnaire &laquo;&nbsp;Quota de privil&egrave;ges&nbsp;&raquo; sous le contenu
            <span class="block text-sm text-gray-500">Les questions sont reprises en direct de l'onglet Questionnaire, en lecture seule&nbsp;: les visiteurs ne peuvent pas y r&eacute;pondre.</span>
        </span>
    </label>
    @error('shows_quota')<div class="text-red-500">{{ $message }}</div>@enderror

    <label class="flex items-start gap-2 justify-self-start">
        <input type="hidden" name="shows_podcasts" value="0">
        <input type="checkbox" name="shows_podcasts" value="1" @checked($showsPodcasts) class="mt-1 rounded border-gray-300">
        <span>
            Afficher les deux podcasts sous le contenu
            <span class="block text-sm text-gray-500">Le podcast th&eacute;orique et le podcast pratique, servis dans la langue de lecture.</span>
        </span>
    </label>
    @error('shows_podcasts')<div class="text-red-500">{{ $message }}</div>@enderror

    <fieldset class="border border-gray-200 rounded-md p-4 grid grid-cols-1 gap-4">
        <legend class="px-2 font-medium">En-t&ecirc;te de la page</legend>
        <p class="text-sm text-gray-500 -mt-2">
            Ce qui s'affiche en haut de l'onglet, avant les blocs de contenu. Laissez tout vide pour n'afficher aucun en-t&ecirc;te.
        </p>

        <div>
            <input type="text" name="number" placeholder="Num&eacute;ro (ex. 03)" value="{{ old('number', $section->number) }}" class="w-full border-gray-200 shadow rounded-md">
            <p class="text-sm text-gray-500 mt-1">Affich&eacute; au-dessus du titre, suivi d'un tiret.</p>
        </div>
        @error('number')<div class="text-red-500">{{ $message }}</div>@enderror

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <input type="text" name="subtitle_fr" placeholder="Sous-titre surlign&eacute; (FR)" value="{{ old('subtitle_fr', $section->subtitle_fr) }}" class="w-full border-gray-200 shadow rounded-md">
                @error('subtitle_fr')<div class="text-red-500">{{ $message }}</div>@enderror
            </div>
            <div>
                <input type="text" name="subtitle_en" placeholder="Highlighted subtitle (EN)" value="{{ old('subtitle_en', $section->subtitle_en) }}" class="w-full border-gray-200 shadow rounded-md">
                @error('subtitle_en')<div class="text-red-500">{{ $message }}</div>@enderror
            </div>
            <p class="text-sm text-gray-500 sm:col-span-2">Une ligne courte, affich&eacute;e au fluo sous le titre.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <textarea name="intro_fr" rows="4" placeholder="Mini-explication du chapitre (FR)" class="w-full border-gray-200 shadow rounded-md">{{ old('intro_fr', $section->intro_fr) }}</textarea>
                @error('intro_fr')<div class="text-red-500">{{ $message }}</div>@enderror
            </div>
            <div>
                <textarea name="intro_en" rows="4" placeholder="Chapter summary (EN)" class="w-full border-gray-200 shadow rounded-md">{{ old('intro_en', $section->intro_en) }}</textarea>
                @error('intro_en')<div class="text-red-500">{{ $message }}</div>@enderror
            </div>
            <p class="text-sm text-gray-500 sm:col-span-2">Deux ou trois lignes, &agrave; gauche sous le sous-titre. Les retours &agrave; la ligne sont conserv&eacute;s.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <textarea name="quote_fr" rows="3" placeholder="Citation (FR)" class="w-full border-gray-200 shadow rounded-md">{{ old('quote_fr', $section->quote_fr) }}</textarea>
                @error('quote_fr')<div class="text-red-500">{{ $message }}</div>@enderror
            </div>
            <div>
                <textarea name="quote_en" rows="3" placeholder="Quotation (EN)" class="w-full border-gray-200 shadow rounded-md">{{ old('quote_en', $section->quote_en) }}</textarea>
                @error('quote_en')<div class="text-red-500">{{ $message }}</div>@enderror
            </div>
            <p class="text-sm text-gray-500 sm:col-span-2">&Agrave; droite de l'en-t&ecirc;te, en machine &agrave; &eacute;crire. Les retours &agrave; la ligne sont conserv&eacute;s.</p>
        </div>
    </fieldset>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <input type="text" name="films_title_fr" placeholder="Titre de la galerie vid&eacute;o (FR)" value="{{ old('films_title_fr', $section->films_title_fr) }}" class="w-full border-gray-200 shadow rounded-md">
            @error('films_title_fr')<div class="text-red-500">{{ $message }}</div>@enderror
        </div>
        <div>
            <input type="text" name="films_title_en" placeholder="Video gallery title (EN)" value="{{ old('films_title_en', $section->films_title_en) }}" class="w-full border-gray-200 shadow rounded-md">
            @error('films_title_en')<div class="text-red-500">{{ $message }}</div>@enderror
        </div>
        <p class="text-sm text-gray-500 sm:col-span-2">
            Titre affich&eacute; au-dessus des vid&eacute;os, sans bouton d'ouverture&nbsp;: le contenu reste toujours visible.
            Laissez vide pour afficher les vid&eacute;os sans titre.
        </p>
    </div>

    <button type="submit" class="px-4 py-2 bg-green-600 rounded-md text-white justify-self-start">Submit</button>

</div>
