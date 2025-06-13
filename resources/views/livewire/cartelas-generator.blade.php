<div>
    <form wire:submit="gerarCartelasBingo" class="  space-y-6">
        <div class="class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <label for="nomeBingo">Nome do Bingo:</label>
            <input type="text" id="nomeBingo" wire:model="nomeBingo" class="mt-1 block w-auto" required rounded-md>
            @error('nomeBingo')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="quantidadeCartelas">Quantidade de Cartelas:</label>
            <input type="number" id="quantidadeCartelas" wire:model.live="quantidadeCartelas" min="1" max="200" class="mt-1 block w-auto" required>
            @error('quantidadeCartelas')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-6 flex space-x-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Gerar Cartelas
            </button>
            <button type="button" onclick="window.print()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Imprimir
            </button>
        </div>

    </form>

</div>
