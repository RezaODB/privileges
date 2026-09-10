@php($uploadLimit = min(
    (int) filter_var(ini_get('upload_max_filesize'), FILTER_SANITIZE_NUMBER_INT),
    (int) filter_var(ini_get('post_max_size'), FILTER_SANITIZE_NUMBER_INT)
))

<div class="grid grid-cols-1 gap-4">

    <div>
        <label for="lang" class="block font-medium mb-1">Langue</label>
        <select name="lang" id="lang" class="border-gray-200 shadow rounded-md">
            <option value="fr" @selected(old('lang', 'fr') === 'fr')>Français</option>
            <option value="en" @selected(old('lang') === 'en')>Anglais</option>
        </select>
        <p class="text-sm text-gray-500 mt-1">Sans carrousel anglais, la version française s'affiche aussi en anglais.</p>
    </div>
    @error('lang')<div class="text-red-500">{{ $message }}</div>@enderror

    <div>
        <label class="block font-medium mb-1">Images</label>
        <input type="file" name="files[]" accept="image/jpeg,image/png,image/webp" multiple required class="block">
        <p class="text-sm text-gray-500 mt-1">
            JPG, PNG ou WEBP. Sélectionnez toutes les images en une fois&nbsp;: elles sont numérotées dans l'ordre où le système les remet, en général l'ordre des noms de fichiers.
            Ce serveur accepte au total <strong>{{ $uploadLimit }} Mo</strong> par envoi.
        </p>
    </div>
    @error('files')<div class="text-red-500">{{ $message }}</div>@enderror
    @error('files.*')<div class="text-red-500">{{ $message }}</div>@enderror

    <button type="submit" class="px-4 py-2 bg-green-600 rounded-md text-white justify-self-start">Submit</button>

</div>
