@php($uploadLimit = min(
    (int) filter_var(ini_get('upload_max_filesize'), FILTER_SANITIZE_NUMBER_INT),
    (int) filter_var(ini_get('post_max_size'), FILTER_SANITIZE_NUMBER_INT)
))

<div class="grid grid-cols-1 gap-4">

    <input type="text" name="title_fr" placeholder="Légende (FR) — facultatif" value="{{ old('title_fr', $film->title_fr) }}" class="border-gray-200 shadow rounded-md">
    @error('title_fr')<div class="text-red-500">{{ $message }}</div>@enderror

    <input type="text" name="title_en" placeholder="Caption (EN) — optional" value="{{ old('title_en', $film->title_en) }}" class="border-gray-200 shadow rounded-md">
    @error('title_en')<div class="text-red-500">{{ $message }}</div>@enderror

    <div>
        <label class="block font-medium mb-1">Film</label>
        <input type="file" name="file" accept="video/mp4,video/quicktime,video/webm" data-max-mb="{{ $uploadLimit }}" class="block" @unless ($film->exists) required @endunless>
        <p class="text-sm text-gray-500 mt-1">
            MP4, MOV ou WEBM. Ce serveur accepte les fichiers jusqu'à <strong>{{ $uploadLimit }} Mo</strong>.
            @if ($film->exists)
                Laissez vide pour conserver le film actuel.
            @endif
        </p>
        <p data-file-too-big class="text-sm text-red-500 mt-1 hidden">Ce fichier dépasse la limite du serveur, l'envoi échouera. Compressez la vidéo ou demandez à votre hébergeur d'augmenter la limite.</p>
    </div>
    @error('file')<div class="text-red-500">{{ $message }}</div>@enderror

    <div>
        <label class="block font-medium mb-1">Vignette <span class="font-normal text-gray-500">(facultatif)</span></label>
        <input type="file" name="poster" accept="image/*" class="block">
        <p class="text-sm text-gray-500 mt-1">Sans vignette, le navigateur affiche la première image du film — mais il doit alors télécharger un bout de chaque vidéo. Avec 20 à 30 films, une vignette accélère nettement la page.</p>
    </div>
    @error('poster')<div class="text-red-500">{{ $message }}</div>@enderror

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
