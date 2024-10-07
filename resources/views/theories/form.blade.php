<div class="grid grid-cols-1 gap-4">

    <select name="lang" class="justify-self-start border-gray-200 shadow rounded-md">
        <option value="fr" {{ old('lang') ?? $theory->lang === 'fr' ? 'selected' : '' }}>FR</option>
        <option value="en" {{ old('lang') ?? $theory->lang === 'en' ? 'selected' : '' }}>EN</option>
    </select>
    @error('lang')<div class="text-red-500">{{ $message }}</div>@enderror

    <input type="text" name="title" placeholder="Title" value="{{ old('title') ?? $theory->title }}" class="border-gray-200 shadow rounded-md" required>
    @error('title')<div class="text-red-500">{{ $message }}</div>@enderror

    <textarea name="body" class="editor">{{ old('body') ?? $theory->body }}</textarea>
    @error('body')<div class="text-red-500">{{ $message }}</div>@enderror

    <button type="submit" class="px-4 py-2 bg-green-600 rounded-md text-white justify-self-start">Submit</button>

</div>