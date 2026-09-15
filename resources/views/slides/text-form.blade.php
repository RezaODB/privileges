<div class="grid grid-cols-1 gap-4">

    <div>
        <label for="lang" class="block font-medium mb-1">Langue</label>
        <select name="lang" id="lang" class="border-gray-200 shadow rounded-md">
            <option value="fr" @selected(old('lang', $slide->lang ?? 'fr') === 'fr')>Français</option>
            <option value="en" @selected(old('lang', $slide->lang ?? 'fr') === 'en')>Anglais</option>
        </select>
        <p class="text-sm text-gray-500 mt-1">Sans carrousel anglais, la version française s'affiche aussi en anglais.</p>
    </div>
    @error('lang')<div class="text-red-500">{{ $message }}</div>@enderror

    <div>
        <input type="text" name="title" placeholder="La question, surlignée au fluo" value="{{ old('title', $slide->title) }}" class="w-full border-gray-200 shadow rounded-md">
        <p class="text-sm text-gray-500 mt-1">Par exemple &laquo;&nbsp;Avez-vous d&eacute;j&agrave; h&eacute;sit&eacute; devant la couleur d'un pansement&nbsp;?&nbsp;&raquo;. S'affiche en haut de la carte, au fluo. Laissez vide pour n'avoir que le texte.</p>
    </div>
    @error('title')<div class="text-red-500">{{ $message }}</div>@enderror

    <div>
        <textarea name="body" class="editor" placeholder="Le texte de la slide">{{ old('body', $slide->body) }}</textarea>
        <p class="text-sm text-gray-500 mt-1">Le bouton surligneur pose du fluo o&ugrave; vous voulez dans ce texte.</p>
    </div>
    @error('body')<div class="text-red-500">{{ $message }}</div>@enderror

    <button type="submit" class="px-4 py-2 bg-green-600 rounded-md text-white justify-self-start">Submit</button>

</div>
