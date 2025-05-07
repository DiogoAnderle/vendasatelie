<?php

namespace App\Livewire;

use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Relatórios')]
class ReportsPage extends Component
{
    use WithPagination;

    public $search = '';
    public $startDate;
    public $endDate;
    public $perPage = 10;

    public function render()
    {
        $bestSellingProducts = $this->getBestSellingProducts();

        return view('livewire.reports-page', [
            'bestSellingProducts' => $bestSellingProducts,
        ]);
    }

    public function getBestSellingProducts()
    {
        $query = Item::select('items.id', 'items.name', 'items.image', 'items.product_id', 'items.price', DB::raw('SUM(items.quantity) as total_quantity'))
            ->join('products', 'products.id', '=', 'items.product_id')
            ->where('items.name', 'like', '%' . $this->search . '%')
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'desc')
            ->whereYear('items.sale_date', date('Y')); // Filtro padrão para o ano atual

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('items.sale_date', [$this->startDate, $this->endDate]);
        } elseif ($this->startDate) {
            $query->where('items.sale_date', '>=', $this->startDate);
        } elseif ($this->endDate) {
            $query->where('items.sale_date', '<=', $this->endDate);
        }

        return $query->paginate($this->perPage);
    }

    public function applyFilters()
    {
        $this->resetPage(); // Resetar a página ao aplicar novos filtros
    }

    public function updatingSearch()
    {
        $this->resetPage(); // Resetar a página ao alterar a pesquisa
    }

    public function updatingPerPage()
    {
        $this->resetPage(); // Resetar a página ao alterar a quantidade por página
    }
}