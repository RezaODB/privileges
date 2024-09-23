<div class="grid grid-cols-1 gap-4">

    <input type="text" name="question_fr" placeholder="Question FR" value="{{ old('question_fr') ?? $quota->question_fr }}" class="border-gray-200 shadow rounded-md" required>
    @error('question_fr')<div class="text-red-500">{{ $message }}</div>@enderror
   
    <input type="text" name="question_en" placeholder="Question EN" value="{{ old('question_en') ?? $quota->question_en }}" class="border-gray-200 shadow rounded-md" required>
    @error('question_en')<div class="text-red-500">{{ $message }}</div>@enderror

    <button type="submit" class="px-4 py-2 bg-green-600 rounded-md text-white justify-self-start">Submit</button>

</div>