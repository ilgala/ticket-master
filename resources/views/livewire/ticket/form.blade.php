<div>
    <h2 class="text-xl font-bold">Crea nuovo ticket</h2>

    <form wire:submit="create">
        <div class="mb-4">
            <label
                for="email"
                @class([
    'font-medium' => true,
    'text-gray-700' => !$errors->has('title'),
    'text-red-500' => $errors->has('title')
])>Email</label>
            <input
                type="email"
                id="email"
                wire:model="email"
                placeholder="Inserisci la tua mail"
                @class([
 'px-2 py-2 mt-2 text-sm rounded-lg border w-full' => true,
 'border-gray-300' => !$errors->has('title'),
 'border-red-500' => $errors->has('title'),
])>
            @error('email')
            <p class="font-medium text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label
                for="department"
                @class([
 'font-medium' => true,
 'text-gray-700' => !$errors->has('title'),
 'text-red-500' => $errors->has('title')
])>Dipartimento</label>
            <select
                id="department"
                wire:model="department"
                @class([
    'px-2 py-2 mt-2 text-sm rounded-lg border w-full' => true,
    'border-gray-300' => !$errors->has('department'),
    'border-red-500' => $errors->has('department'),
])>
                <option value="ADMIN">Amministrazione</option>
                <option value="COMM">Commerciale</option>
                <option value="TECH">Reparto tecnico</option>
            </select>
            @error('department')
            <p class="font-medium text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label
                for="title" @class([
    'font-medium' => true,
    'text-gray-700' => !$errors->has('title'),
    'text-red-500' => $errors->has('title')
])>Titolo</label>
            <input
                type="text"
                id="title"
                wire:model="title"
                placeholder="Richiesta di assistenza per ..."
                @class([
 'px-2 py-2 mt-2 text-sm rounded-lg border w-full' => true,
 'border-gray-300' => !$errors->has('title'),
 'border-red-500' => $errors->has('title'),
])
            >
            @error('title')
            <p class="font-medium text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label
                for="body"
                @class([
 'font-medium' => true,
 'text-gray-700' => !$errors->has('body'),
 'text-red-500' => $errors->has('body')
])>Descrizione</label>
            <textarea
                id="body"
                wire:model="body"
                placeholder="Inserisci una descrizione dettagliata della tua richiesta di assistenza. Fornisci più dettagli possibili e, se necessario, allega dei file e riportane il contenuto in questa descrizione"
                @class([
'px-2 py-2 mt-2 text-sm rounded-lg border w-full' => true,
'border-gray-300' => !$errors->has('body'),
'border-red-500' => $errors->has('body'),
])
                rows="4"
            ></textarea>
            @error('body')
            <p class="font-medium text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label
                for="attachment"
                @class([
 'font-medium' => true,
 'text-gray-700' => !$errors->has('title'),
 'text-red-500' => $errors->has('title')
])>Allegati</label>
            <livewire:utils.dropzone></livewire:utils.dropzone>
        </div>
        <div class="mb-4">
            <input type="checkbox" id="terms" wire:model="terms">
            <label
                for="privacy" class="ml-2 text-gray-700">Accetto i termini e le condizioni d'uso</label>
            @error('terms')
            <p class="font-medium text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <input type="checkbox" id="privacy" wire:model="privacy">
            <label
                for="privacy" class="ml-2 text-gray-700">Accetto la privacy policy</label>
            @error('privacy')
            <p class="font-medium text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <input type="checkbox" id="notify" wire:model="notify">
            <label
                for="notify" class="ml-2 text-gray-700">Tienimi aggiornato</label>
            @error('notify')
            <p class="font-medium text-red-500">{{ $message }}</p>
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
