<?php

namespace App\Livewire\Home;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Inicio')]
class Home extends Component
{
    // Today Sales
    public $todaySales = 0;
    public $totalTodaySales = 0;
    public $itemsToday = 0;
    public $productsToday = 0;

    // Months Sales Graph
    public $listTotalSalesMonth = '';

    // Month Box Report
    public $monthSalesQuantity = 0;
    public $monthTotalSales = 0;
    public $monthItemsQuantity = 0;
    public $monthProductsSalesQuantity = 0;

    // Box Report
    public $salesQuantity = 0;
    public $totalSales = 0;
    public $itemsQuantity = 0;
    public $productsSalesQuantity = 0;
    public $productsQuantity = 0;
    public $categoriesQuantity = 0;
    public $customersQuantity = 0;

    // Best Sales Products and recents
    public $bestSaleProductsToday = 0;
    public $bestSaleProductsMonth = 0;
    public $bestSaleProducts = 0;
    public $recentProducts = 0;

    //Best sellers end buyers properties
    public $bestSellers = 0;
    public $bestBuyers = 0;

    //Sales in progress

    public function render()
    {

        $this->today_sales();
        $this->calc_sales_month();
        $this->boxes_reports();
        $this->set_products_reports();
        $this->set_best_sellers_and_buyers();
        $salesInProgress = Sale::where('status', '=', 0)->get();
        return view('livewire.home.home', ['salesInProgress' => $salesInProgress]);
    }

    public function today_sales()
    {
        $this->todaySales = Sale::whereDate('sale_date', date('Y-m-d'))->count();
        $this->totalTodaySales = currencyBRLFormat(Sale::whereDate('sale_date', date('Y-m-d'))->sum('net_value'));
        $this->itemsToday = Item::whereDate('sale_date', date('Y-m-d'))->sum('quantity');
        $this->productsToday = count(Item::whereDate('sale_date', date('Y-m-d'))->groupBy('product_id')->get());

    }
    public function calc_sales_month()
    {
        for ($i = 1; $i < 12; $i++) {
            $this->listTotalSalesMonth .= Sale::whereMonth('sale_date', '=', $i)->sum('net_value') . ',';
        }
    }

    public function boxes_reports()
    {
        $this->salesQuantity = Sale::whereYear('sale_date', '=', date('Y'))->count();
        $this->totalSales = currencyBRLFormat(Sale::whereYear('sale_date', '=', date('Y'))->sum('net_value'));
        $this->itemsQuantity = Item::whereYear('sale_date', '=', date('Y'))->sum('quantity');
        $this->productsSalesQuantity = count(Item::whereYear('sale_date', '=', date('Y'))->groupBy('product_id')->get());

        $this->monthSalesQuantity = Sale::whereMonth('sale_date', '=', date('m'))->count();
        $this->monthTotalSales = currencyBRLFormat(Sale::whereMonth('sale_date', '=', date('m'))->sum('net_value'));
        $this->monthItemsQuantity = Item::whereMonth('sale_date', '=', date('m'))->sum('quantity');
        $this->monthProductsSalesQuantity = count(Item::whereMonth('sale_date', '=', date('m'))->groupBy('product_id')->get());

        $this->productsQuantity = Product::count();
        $this->categoriesQuantity = Category::count();
        $this->customersQuantity = Customer::count();
    }

    public function products_reports($dayFilter = 0, $monthFilter = 0)
    {
        $productsQuery = Item::select('items.id', 'items.name', 'items.image', 'items.product_id', 'items.price', DB::raw('SUM(items.quantity) as total_quantity'))->groupBy('product_id')->whereYear('items.sale_date', date('Y'));

        if ($dayFilter) {
            $productsQuery = $productsQuery->whereDate('items.sale_date', date('Y-m-d'));
        }
        if ($monthFilter) {
            $productsQuery = $productsQuery->whereMonth('items.sale_date', date('m'));
        }

        $productsQuery = $productsQuery
            ->orderBy('total_quantity', 'desc')
            ->take(30)
            ->get();
        return $productsQuery;
    }
    public function set_products_reports()
    {
        $this->bestSaleProductsToday = $this->products_reports(1);
        $this->bestSaleProductsMonth = $this->products_reports(0, 1);
        $this->bestSaleProducts = $this->products_reports();
        $this->recentProducts = Product::take(5)->orderBy('id', 'desc')->get();
    }

    public function best_sellers()
    {
        return User::select('users.id', 'users.name', 'users.admin', DB::raw('SUM(sales.net_value) as total'))
            ->join('sales', 'sales.user_id', '=', 'users.id')
            ->whereYear('sales.sale_date', date('Y'))
            ->groupBy('users.id', 'users.name')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();
    }
    public function best_buyers()
    {
        return Customer::select('customers.id', 'customers.name', DB::raw('SUM(sales.net_value) as total'))
            ->join('sales', 'sales.customer_id', '=', 'customers.id')
            ->whereYear('sales.sale_date', date('Y'))
            ->groupBy('customers.id', 'customers.name')
            ->orderBy('total', 'desc')
            ->take(50)
            ->get();
    }
    public function set_best_sellers_and_buyers()
    {
        $this->bestSellers = $this->best_sellers();
        $this->bestBuyers = $this->best_buyers();

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
