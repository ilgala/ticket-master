<div x-data="{ show: @entangle('show'), type: @entangle('type') }"
     x-init="setTimeout(() => { show = false }, 5000)"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="transform opacity-0 scale-0"
     x-transition:enter-end="transform opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="transform opacity-100 scale-100"
     x-transition:leave-end="transform opacity-0 scale-0"
     class="fixed top-20 right-0 mb-4 mr-4">
    <div x-show="show"
         :class="{ 'bg-blue-500': type === 'info', 'bg-green-500': type === 'success', 'bg-yellow-500': type === 'warning', 'bg-red-500': type === 'alert' }"
         class="px-4 py-2 rounded text-white shadow-lg">
        <div class="flex flex-row gap-4">
            <div class="flex-1">
                {{ $message }}
            </div>
            <div>
                <button
                    wire:click="hide"
                    class="text-white hover:text-gray-700"
                >x</button>
            </div>
        </div>
    </div>
</div>
