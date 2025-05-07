<?php

namespace App\Livewire\Sale;

use App\Models\Sale;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Ver Venda')]
class SaleShow extends Component
{
    public Sale $sale;
    public function render()
    {
        return view('livewire.sale.sale-show');
    }

    #[On('finishSale')]
    public function finishSale($id)
    {
        $sale = Sale::findOrFail($id);

        $sale->status = 1;

        $sale->update();
        $this->dispatch('msg', 'Venda concluída com sucesso.');

    }
}
