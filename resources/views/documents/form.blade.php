@php($currentLang = old('lang', $document->lang ?? 'fr'))
@php($uploadLimit = min(
    (int) filter_var(ini_get('upload_max_filesize'), FILTER_SANITIZE_NUMBER_INT),
    (int) filter_var(ini_get('post_max_size'), FILTER_SANITIZE_NUMBER_INT)
))

<div class="grid grid-cols-1 gap-4">

    <select name="lang" class="justify-self-start border-gray-200 shadow rounded-md">
        <option value="fr" @selected($currentLang === 'fr')>FR</option>
        <option value="en" @selected($currentLang === 'en')>EN</option>
    </select>
    @error('lang')<div class="text-red-500">{{ $message }}</div>@enderror

    <input type="text" name="label" placeholder="Nom affiché du document" value="{{ old('label', $document->label) }}" class="border-gray-200 shadow rounded-md" required>
    @error('label')<div class="text-red-500">{{ $message }}</div>@enderror

    <div>
        <input type="file" name="file" accept="application/pdf" data-max-mb="{{ $uploadLimit }}" class="block" @unless ($document->exists) required @endunless>
        <p class="text-sm text-gray-500 mt-1">
            PDF uniquement. Ce serveur accepte les fichiers jusqu'à <strong>{{ $uploadLimit }} Mo</strong>.
            @if ($document->exists)
                Laissez vide pour conserver le fichier actuel.
            @endif
        </p>
        <p data-file-too-big class="text-sm text-red-500 mt-1 hidden">Ce fichier dépasse la limite du serveur, l'envoi échouera. Compressez le PDF ou demandez à votre hébergeur d'augmenter la limite.</p>
    </div>
    @error('file')<div class="text-red-500">{{ $message }}</div>@enderror

    <button type="submit" class="px-4 py-2 bg-green-600 rounded-md text-white justify-self-start">Submit</button>

</div>

<script>
    document.querySelector('input[name="file"]')?.addEventListener('change', function () {
        var limit = parseInt(this.dataset.maxMb, 10) * 1024 * 1024;
        var warning = document.querySelector('[data-file-too-big]');
        var tooBig = this.files.length > 0 && this.files[0].size > limit;
        warning.classList.toggle('hidden', !tooBig);
    });
</script>
