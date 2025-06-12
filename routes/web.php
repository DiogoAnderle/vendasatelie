<?php

use App\Http\Controllers\PdfController;

use Illuminate\Support\Facades\Route;

use App\Livewire\Category\CategoryComponent;
use App\Livewire\Category\CategoryShow;
use App\Livewire\Product\ProductComponent;
use App\Livewire\Product\ProductShow;
use App\Livewire\User\UserComponent;
use App\Livewire\User\UserShow;
use App\Livewire\Customer\CustomerComponent;
use App\Livewire\Customer\CustomerShow;
use App\Livewire\Sale\SaleCreate;
use App\Livewire\Sale\SaleList;
use App\Livewire\Sale\SaleShow;
use App\Livewire\Email\EmailComponent;
use App\Livewire\Sale\SaleEdit;
use App\Livewire\Shop\ShopComponent;
use App\Livewire\Home\Home;
use App\Livewire\ReportsPage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes(['register' => false]);

Route::get('/home', Home::class)->name('home')->middleware(['auth', 'check.session']);

Route::get('/categorias', CategoryComponent::class)->name('categories')->middleware(['auth', 'admin']);
Route::get('/categorias/{category}', CategoryShow::class)->name('categories.show')->middleware(['auth', 'admin', 'check.session']);

Route::get('/produtos', ProductComponent::class)->name('products')->middleware(['auth', 'check.session']);
Route::get('/produtos/{product}', ProductShow::class)->name('products.show')->middleware(['auth', 'check.session']);

Route::get('/usuarios', UserComponent::class)->name('users')->middleware(['auth', 'admin']);
Route::get('/usuarios/{user}', UserShow::class)->name('users.show')->middleware(['auth', 'check.session']);

Route::get('/clientes', CustomerComponent::class)->name('customers')->middleware(['auth', 'check.session']);
Route::get('/clientes/{customer}', CustomerShow::class)->name('customers.show')->middleware(['auth', 'check.session']);

Route::get('/criar-vendas', SaleCreate::class)->name('sales.create')->middleware(['auth', 'check.session']);
Route::get('/sales', SaleList::class)->name('sales.list')->middleware(['auth', 'check.session']);
Route::get('/sales/{sale}', SaleShow::class)->name('sales.show')->middleware(['auth', 'check.session']);
Route::get('/sales/{sale}/edit', SaleEdit::class)->name('sales.edit');

Route::get('/shop', ShopComponent::class)->name('shop')->middleware(['auth', 'check.session']);

Route::get('/sales/invoice/{sale}', [PdfController::class, 'invoicePdf'])->name('sales.invoice')->middleware(['auth', 'check.session']);

Route::get('/sales/receipt/{sale}', [PdfController::class, 'receiptPdf'])->name('sales.receipt')->middleware(['auth', 'check.session']);

Route::get('/reports/export/pdf', [PdfController::class, 'bestSellingProductsPdf'])->name('reports.export.pdf');
Route::get('/reports/export/excel', [ReportsPage::class, 'exportToExcel'])->name('reports.export.excel');
Route::get('/reports/export-sales-without-invoice/pdf', [PdfController::class, 'salesWithoutInvoicePdf'])->name('reports.exportSalesWithoutInvoice.pdf');

Route::get('/email', EmailComponent::class)->name('emails')->middleware(['auth', 'check.session']);
Route::get('/offline', function () {
    return view('vendor.laravelpwa.offline');

});
Route::get('/reports', ReportsPage::class)->name('reports');


