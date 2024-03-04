<div>
    <div
        x-data="{ isUploading: false }"
        @dragover.prevent="isUploading = true"
        @dragleave="isUploading = false"
        @drop.prevent="
            isUploading = false;
            $event.preventDefault();
            if ($event.dataTransfer.files.length) {
                for (let i = 0; i < $event.dataTransfer.files.length; i++) {
                    $wire.upload('files', $event.dataTransfer.files[i]);
                }
            }
        "
        class="p-4 border-2 border-dashed rounded-md cursor-pointer flex flex-col items-center justify-center text-gray-400 transition duration-300 ease-in-out"
        :class="{ 'border-blue-500 text-blue-500': isUploading }"
    >
        <i class="fas fa-cloud-upload-alt text-4xl"></i>
        <p class="mt-2 text-sm">Trascina i file qui oppure clicca per caricarli</p>
    </div>

    <div class="mt-4">
        @if ($files)
            <ul class="list-disc p-4">
                @foreach ($files as $key => $file)
                    <li class="flex items-center justify-between">
                        <span>{{ $file->getClientOriginalName() }}</span>
                        <button wire:click="removeFile({{ $key }})" class="text-red-500 hover:underline">Rimuovi</button>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
