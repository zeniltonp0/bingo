<div>
    <form wire:submit="gerarCartelasBingo" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="nomeBingo" class="block text-sm font-medium text-gray-700">Nome do Bingo:</label>
                <input type="text" id="nomeBingo" wire:model="nomeBingo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                @error('nomeBingo')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="quantidadeCartelas" class="block text-sm font-medium text-gray-700">Quantidade de Cartelas:</label>
                <input type="number" id="quantidadeCartelas" wire:model.live="quantidadeCartelas" min="1" max="200" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                @error('quantidadeCartelas')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="mt-4">
            <label for="listaCasas" class="block text-sm font-medium text-gray-700">Lista de Casas:</label>
            <textarea id="listaCasas" wire:model.live="listaCasas" rows="10" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
            <p class="text-xs text-gray-500 mt-1">Um número por linha. Mínimo de 24 números únicos.</p>
            @error('listaCasas') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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

    ---

    @if (!empty($cartelasGeradas))
        <h2 class="text-2xl font-bold mt-8 mb-4 text-center">Cartelas de Bingo Geradas</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($cartelasGeradas as $index => $cartela)
                <div class="border p-4 rounded-lg shadow-md bg-white">
                    <h3 class="text-lg font-semibold mb-2">Cartela #{{ $index + 1 }} - {{ $nomeBingo }}</h3>
                    <table class="w-full text-center border-collapse">
                        <thead>
                            <tr>
                                @foreach (['B', 'I', 'N', 'G', 'O'] as $colHeader)
                                    <th class="border p-2 bg-blue-100">{{ $colHeader }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < 5; $i++)
                                <tr>
                                    @foreach (['B', 'I', 'N', 'G', 'O'] as $col)
                                        <td class="border p-2 @if($cartela[$col][$i] === 'X') font-bold bg-yellow-200 @endif">
                                            {{ $cartela[$col][$i] }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    @endif
</div>