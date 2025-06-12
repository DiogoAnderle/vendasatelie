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

    public $searchBestProducts = '';
    public $startDateBestProducts;
    public $endDateBestProducts;
    public $perPageBestProducts = 10;

    public $searchProductsWithoutInvoice = '';
    public $startDateProductsWithoutInvoice;
    public $endDateProductsWithoutInvoice;
    public $perPageProductsWithoutInvoice = 10;

    public function render()
    {
        return view('livewire.reports-page', [
            'bestSellingProducts' =>  $this->getBestSellingProducts(),
            'salesWithoutInvoice' => $this->getSalesWithoutInvoice(),
            'totalSalesWithoutInvoice' => $this->getTotalSalesWithoutInvoice(), // ← adiciona isso
        ]);
    }

    public function getBestSellingProducts()
    {
        $query = Item::select('items.id', 'items.name', 'items.image', 'items.product_id', 'items.price', DB::raw('SUM(items.quantity) as total_quantity'))
            ->join('products', 'products.id', '=', 'items.product_id')
            ->where('items.name', 'like', '%' . $this->searchBestProducts . '%')
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'desc')
            ->whereYear('items.sale_date', date('Y')); // Filtro padrão para o ano atual

        if ($this->startDateBestProducts && $this->endDateBestProducts) {
            $query->whereBetween('items.sale_date', [$this->startDateBestProducts, $this->endDateBestProducts]);
        } elseif ($this->startDateBestProducts) {
            $query->where('items.sale_date', '>=', $this->startDateBestProducts);
        } elseif ($this->endDateBestProducts) {
            $query->where('items.sale_date', '<=', $this->endDateBestProducts);
        }

        return $query->paginate($this->perPageBestProducts);
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

    public function getSalesWithoutInvoice()
    {
        $query = DB::table('sales')
            ->select('id', 'total', 'addition_discount', 'net_value', 'sale_date', 'status')
            ->where('invoice', 0) // apenas vendas sem nota
            ->orderBy('sale_date', 'desc');

        if ($this->startDateProductsWithoutInvoice && $this->endDateProductsWithoutInvoice) {
            $query->whereBetween('sale_date', [$this->startDateProductsWithoutInvoice, $this->endDateProductsWithoutInvoice]);
        } elseif ($this->startDateProductsWithoutInvoice) {
            $query->where('sale_date', '>=', $this->startDateProductsWithoutInvoice);
        } elseif ($this->endDateProductsWithoutInvoice) {
            $query->where('sale_date', '<=', $this->endDateProductsWithoutInvoice);
        }

        return $query->paginate($this->perPageProductsWithoutInvoice);
    }

    public function getTotalSalesWithoutInvoice()
    {
        $query = DB::table('sales')
            ->where('invoice', 0);

        if ($this->startDateProductsWithoutInvoice && $this->endDateProductsWithoutInvoice) {
            $query->whereBetween('sale_date', [$this->startDateProductsWithoutInvoice, $this->endDateProductsWithoutInvoice]);
        } elseif ($this->startDateProductsWithoutInvoice) {
            $query->where('sale_date', '>=', $this->startDateProductsWithoutInvoice);
        } elseif ($this->endDateProductsWithoutInvoice) {
            $query->where('sale_date', '<=', $this->endDateProductsWithoutInvoice);
        }

        return $query->sum('net_value');
    }

}