@php($currentLang = old('lang', $chapter->lang ?? 'fr'))

<div class="grid grid-cols-1 gap-4">

    <select name="lang" class="justify-self-start border-gray-200 shadow rounded-md">
        <option value="fr" @selected($currentLang === 'fr')>FR</option>
        <option value="en" @selected($currentLang === 'en')>EN</option>
    </select>
    @error('lang')<div class="text-red-500">{{ $message }}</div>@enderror

    <div class="grid grid-cols-1 sm:grid-cols-[8rem_1fr] gap-4">
        <div>
            <input type="text" name="number" placeholder="N&deg; (ex. 01)" value="{{ old('number', $chapter->number) }}" class="w-full border-gray-200 shadow rounded-md">
            @error('number')<div class="text-red-500">{{ $message }}</div>@enderror
        </div>
        <div>
            <input type="text" name="title" placeholder="Title" value="{{ old('title', $chapter->title) }}" class="w-full border-gray-200 shadow rounded-md" required>
            @error('title')<div class="text-red-500">{{ $message }}</div>@enderror
        </div>
        <p class="text-sm text-gray-500 sm:col-span-2">Le num&eacute;ro s'affiche dans sa propre colonne, &agrave; gauche du titre&nbsp;: inutile de le r&eacute;p&eacute;ter dans le titre.</p>
    </div>

    <div>
        <textarea name="summary" rows="2" placeholder="Mini-r&eacute;cap, &agrave; droite du titre" class="w-full border-gray-200 shadow rounded-md">{{ old('summary', $chapter->summary) }}</textarea>
        <p class="text-sm text-gray-500 mt-1">Une phrase, visible sans ouvrir le bloc. Laissez vide pour n'afficher que le titre.</p>
    </div>
    @error('summary')<div class="text-red-500">{{ $message }}</div>@enderror

    <textarea name="body" class="editor" placeholder="Body">{{ old('body', $chapter->body) }}</textarea>
    @error('body')<div class="text-red-500">{{ $message }}</div>@enderror

    <button type="submit" class="px-4 py-2 bg-green-600 rounded-md text-white justify-self-start">Submit</button>

</div>
