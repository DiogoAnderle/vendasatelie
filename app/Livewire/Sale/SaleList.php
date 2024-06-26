<?php

namespace App\Livewire\Sale;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Sale;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Listar Vendas')]
class SaleList extends Component
{

    use WithPagination;
    public $search = '';
    public $totalRegistros = 0;
    public $quantity = 15;

    public $totalVendas;
    public $dateStart;
    public $dateEnd;
    public function render()
    {
        Cart::clear();
        if ($this->search != '') {
            $this->resetPage();
        }
        $this->totalRegistros = Sale::count();

        $salesQuery = Sale::where('id', 'like', '%' . $this->search . '%');

        if ($this->dateStart && $this->dateEnd) {
            $salesQuery = $salesQuery->whereBetween(
                'sale_date',
                [$this->dateStart, $this->dateEnd]
            );
            $this->totalVendas = $salesQuery->sum('net_value');
        } else {
            $this->totalVendas = Sale::sum('net_value');
        }
        $sales = $salesQuery
            ->orderBy('id', 'desc')
            ->paginate($this->quantity);

        return view('livewire.sale.sale-list', compact('sales'));
    }

    #[On('destroySale')]
    public function destroySale($id)
    {
        $sale = Sale::findOrFail($id);

        foreach ($sale->items as $item) {
            Product::find($item->id)->increment('stock', $item->quantity);
            $item->delete();
        }

        $sale->delete();
        $this->dispatch('msg', 'Venda deletada com sucesso.');

    }

    #[On('setDates')]
    public function setDates($startDate, $endDate)
    {
        $this->dateStart = $startDate;
        $this->dateEnd = $endDate;
    }
}
