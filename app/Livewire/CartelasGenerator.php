<?php

namespace App\Livewire;

use Livewire\Component;

class CartelasGenerator extends Component
{

    public $nomeBingo;
    public $listaCasas = '';
    public $quantidadeCartelas;
    public  $cartelasGeradas = [];

    protected $regras = [
        'nomeBingo' => 'required|string|max:50',
        'quantidadeCartelas' => 'required|integer|min:1|max:200',
        'listaCasas' => 'required|string', 
    ];

    
    protected $erros = [
        'nomeBingo.required' => 'O nome do bingo é obrigatório.',
        'quantidadeCartelas.required' => 'A quantidade de cartelas é obrigatória.',
        'quantidadeCartelas.integer' => 'A quantidade de cartelas deve ser um número inteiro.',
        'quantidadeCartelas.min' => 'A quantidade de cartelas deve ser no mínimo :min.',
        'quantidadeCartelas.max' => 'A quantidade de cartelas deve ser no máximo :max.',
        'listaCasas.required' => 'A lista de casas é obrigatória.',
    ];


    public function mount(){
        $this->listaCasas = implode("\n", range(1,100));
    }

    public function gerarCartelasBingo()
    {
        // 1. Validar os inputs
        $this->validate();

        // 2. Processar a lista de casas (apenas numérico agora)
        // Remove linhas vazias e espaços em branco extras
        $items = array_map('trim', explode("\n", $this->listaCasas));
        $items = array_filter($items, 'strlen'); // Remove strings vazias

        // Valida se todos os itens são numéricos e converte para int
        $itensNumericos = [];
        foreach ($items as $item) {
            if (is_numeric($item)) {
                $itensNumericos[] = (int) $item;
            } else {
                $this->addError('listaCasas', 'A lista de casas deve conter apenas números.');
                return;
            }
        }
        $items = array_unique($itensNumericos); // Remove duplicatas de números
        sort($items); // Opcional: ordenar os números para melhor organização

        if (count($items) < 25) { // Mínimo de 25 para uma cartela 5x5 com FREE
            $this->addError('houseList', 'A lista de casas deve conter no mínimo 25 números únicos para gerar cartelas válidas.');
            return;
        }

        // 3. Resetar as cartelas geradas antes de gerar novas
        $this->cartelasGeradas = [];

        // 4. Lógica para gerar as cartelas
        for ($i = 0; $i < $this->quantidadeCartelas; $i++) {
            $cartela = $this->gerarUmaCartela($items);
            $this->quantidadeCartelas[] = $cartela;
        }
    }

    /**
     * @param array $itensDisponiveis
     * @return array
     */
    public function gerarUmaCartela(){
        // Embaralha os itens disponíveis para pegar aleatoriamente
        shuffle($itensDisponiveis);

        // Uma cartela de bingo 5x5 precisa de 24 itens únicos (o 25º é o FREE)
        // Certifica-se de que temos itens suficientes (já validado no método principal, mas bom ter aqui)
        if (count($itensDisponiveis) < 24) {
            return []; // Retorna uma cartela vazia se não houver itens suficientes
        }

        // Pega 24 itens aleatórios e únicos para esta cartela
        $cardItems = array_slice($itensDisponiveis, 0, 24);

        // Estrutura das colunas B, I, N, G, O
        $columns = ['B', 'I', 'N', 'G', 'O'];
        $cardGrid = [];
        $k = 0; // Índice para percorrer $cardItems

        foreach ($columns as $col) {
            $columnArray = [];
            for ($j = 0; $j < 5; $j++) {
                if ($col == 'N' && $j == 2) { // Posição central na coluna 'N'
                    $columnArray[] = 'X'; // O texto 'FREE' pode ser uma imagem se $imageUrl estiver definida
                } else {
                    // Garantir que não pegamos um índice fora do array $cardItems
                    $columnArray[] = $cardItems[$k] ?? null;
                    $k++;
                }
            }
            $cardGrid[$col] = $columnArray;
        }

        return $cardGrid;
    }

    public function render()
    {
        return view('livewire.cartelas-generator');
    }

    
}
