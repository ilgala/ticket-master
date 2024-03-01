<div class="w-1/3 px-4 py-2 mt-2 rounded-lg shadow">
    <h2 class="text-xl font-bold">Crea nuovo ticket</h2>
    <form class="mt-2" wire:submit="create">
        <div class="flex flex-col">
            <label for=""
                   @class([
    'font-medium' => true,
    'text-gray-700' => !$errors->has('title'),
    'text-red-500' => $errors->has('title')
])
            >Titolo</label>
            <input
                wire:model="title"
                type="text"
                @class([
    'px-2 py-2 mt-2 text-sm rounded-lg border' => true,
    'border-gray-300' => !$errors->has('title'),
    'border-red-500' => $errors->has('title'),
])
            />
            @error('title')
            <p class="text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex flex-col mt-2">
            <label for=""
                @class([
    'font-medium' => true,
    'text-gray-700' => !$errors->has('title'),
    'text-red-500' => $errors->has('title')
])
            >Messaggio</label>
            <textarea
                wire:model="body"
                @class([
    'px-2 py-2 h-48 mt-2 text-sm rounded-lg border' => true,
    'border-gray-300' => !$errors->has('body'),
    'border-red-500' => $errors->has('body'),
])
            ></textarea>
            @error('body')
            <p class="text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex flex-col mt-2">
            <button
                type="submit"
                class="px-2 py-2 bg-blue-400 text-white rounded-lg hover:bg-blue-700"
            >Invia</button>
        </div>
    </form>
</div>
