<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Sale;
use App\Models\Shop;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PdfController extends Controller
{
    public function invoicePdf(Sale $sale)
    {
        $shop = Shop::first();
        $pdf = Pdf::loadView('livewire.sale.invoice', compact('sale', 'shop'));
        return $pdf->stream('Fatura FV-' . $sale->id . ' ' . $sale->customer->name . '.pdf');
    }

    public function receiptPdf(Sale $sale)
    {
        $shop = Shop::first();
        $pdf = Pdf::loadView('livewire.sale.receipt', compact('sale', 'shop'));
        return $pdf->stream('Recibo RC-' . $sale->id . ' ' . $sale->customer->name . '.pdf');
    }

    public function bestSellingProductsPdf()
    {
        $shop = Shop::first();
        $bestSellingProducts = Item::select('items.id', 'items.name', 'items.image', 'items.product_id', 'items.price', DB::raw('SUM(items.quantity) as total_quantity'))
            ->join('products', 'products.id', '=', 'items.product_id')
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'desc')
            ->whereYear('items.sale_date', date('Y')) // Filtro padrão para o ano atual (você pode ajustar)
            ->get();

        $pdf = Pdf::loadView('livewire.reports.best-selling-pdf', compact('bestSellingProducts', 'shop'));
        return $pdf->stream('Relatorio_Produtos_Mais_Vendidos_' . date('YmdHis') . '.pdf');
    }



    public function salesWithoutInvoicePdf(Request $request)
    {           
        $start = $request->input('startDateProductsWithoutInvoice');
        $end = $request->input('endDateProductsWithoutInvoice');

        $query = DB::table('sales')
            ->select('id', 'total', 'addition_discount', 'net_value', 'sale_date', 'status')
            ->where('invoice', 0)
            ->orderBy('sale_date', 'desc');

        if ($start && $end) {
            $startDate = Carbon::parse($start)->startOfDay(); // 00:00:00
            $endDate = Carbon::parse($end)->endOfDay();       // 23:59:59
            $query->whereBetween('sale_date', [$startDate, $endDate]);
        } elseif ($start) {
            $startDate = Carbon::parse($start)->startOfDay();
            $query->where('sale_date', '>=', $startDate);
        } elseif ($end) {
            $endDate = Carbon::parse($end)->endOfDay();
            $query->where('sale_date', '<=', $endDate);
        }

        $salesWithoutInvoice = $query->get();
        $totalSalesWithoutInvoice = $salesWithoutInvoice->sum('net_value');
        $shop = Shop::first();

        $pdf = Pdf::loadView('livewire.reports.sales-without-invoice-pdf', [
            'salesWithoutInvoice' => $salesWithoutInvoice,
            'totalSalesWithoutInvoice' => $totalSalesWithoutInvoice,
            'startDate' => $start,
            'endDate' => $end,
            'shop' => $shop,
        ]);

        return $pdf->stream('Vendas_Sem_Nota_' . date('Ymd_His') . '.pdf');
    }

}
