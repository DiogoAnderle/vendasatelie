<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Shop;
use Barryvdh\DomPDF\Facade\Pdf;

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
}
