@php($isPublished = old('published', $section->exists ? $section->published : true))
@php($showsQuota = old('shows_quota', $section->shows_quota ?? false))

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
