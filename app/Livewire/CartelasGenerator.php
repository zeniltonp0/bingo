<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;

class CartelasGenerator extends Component
{

    #[Validate('required|min:3|max:10')]
    public $nomeBingo;

    #[Validate('required')]
    public $listaCasas = '';

    #[Validate('required|integer|min:1|max:200')] 
    public $quantidadeCartelas;

    public $cartelasGeradas = [];


    public function mount(){
        $this->listaCasas = implode("\n", range(1, 75)); 
    }

    public function gerarCartelasBingo()
    {
        // 1. Validar os inputs
        $this->validate();

        $items = array_map('trim', explode("\n", $this->listaCasas));
        $items = array_filter($items, 'strlen'); 

        $itensNumericos = [];
        foreach ($items as $item) {
            if (is_numeric($item)) {
                $itensNumericos[] = (int) $item;
            } else {
                $this->addError('listaCasas', 'A lista de casas deve conter apenas números.');
                return;
            }
        }
        $items = array_unique($itensNumericos);
        sort($items);

        if (count($items) < 24) { 
            $this->addError('listaCasas', 'A lista de casas deve conter no mínimo 24 números únicos para gerar cartelas válidas.');
            return;
        }

        $this->cartelasGeradas = [];

        // 4. Lógica para gerar as cartelas
        for ($i = 0; $i < $this->quantidadeCartelas; $i++) {
            $cartela = $this->gerarUmaCartela($items); 
            if (!empty($cartela)) {
                $this->cartelasGeradas[] = $cartela; 
            }
        }
    }

    /**
     * @param array $itensDisponiveis
     * @return array
     */
    public function gerarUmaCartela(array $itensDisponiveis): array
    {
        shuffle($itensDisponiveis);

        
        if (count($itensDisponiveis) < 24) {
            return []; 
        }

        // Pega 24 itens aleatórios e únicos
        $cardItems = array_slice($itensDisponiveis, 0, 24);
        sort($cardItems); 

        $columns = ['B', 'I', 'N', 'G', 'O'];
        $cardGrid = [];
        $k = 0;

        foreach ($columns as $col) {
            $columnArray = [];
            for ($j = 0; $j < 5; $j++) {
                if ($col == 'N' && $j == 2) {
                    $columnArray[] = 'X'; 
                } else {
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